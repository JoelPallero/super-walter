<?php
declare(strict_types=1);

namespace SuperWalter;

/**
 * Conexión PDO a MySQL. Credenciales en el .env (DB_HOST, DB_NAME, DB_USER, DB_PASS).
 * Si DB_NAME está vacío, el sitio sigue leyendo los JSON de backend/data/.
 */
class Database
{
    private static ?\PDO $pdo = null;

    public static function enabled(): bool
    {
        // SW_USE_JSON=1 (variable de entorno del proceso) fuerza los JSON: útil en una PC sin MySQL.
        return getenv('SW_USE_JSON') !== '1' && function_exists('sw_env') && sw_env('DB_NAME') !== '';
    }

    public static function pdo(): \PDO
    {
        if (self::$pdo === null) {
            $dsn = 'mysql:host=' . (sw_env('DB_HOST') ?: 'localhost') . ';dbname=' . sw_env('DB_NAME') . ';charset=utf8mb4';
            self::$pdo = new \PDO($dsn, sw_env('DB_USER'), sw_env('DB_PASS'), [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                \PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        }
        return self::$pdo;
    }
}

/**
 * Misma interfaz que JsonStore (arrays con la misma forma), pero contra MySQL.
 * catalogo.json -> tablas catalogo_*; productos.json / novedades.json -> tabla contenido.
 */
class DbStore
{
    private const CONTENIDO = [
        'productos.json' => 'productos', 'novedades.json' => 'novedades',
        'productos-en.json' => 'productos_en', 'novedades-en.json' => 'novedades_en', 'catalogo-en.json' => 'catalogo_en',
    ];

    public static function handles(string $file): bool
    {
        return Database::enabled() && ($file === 'catalogo.json' || isset(self::CONTENIDO[$file]));
    }

    /** @return array<int, array<string, mixed>> */
    public static function all(string $file): array
    {
        return $file === 'catalogo.json' ? self::catalogo(null) : self::contenido(self::CONTENIDO[$file], null);
    }

    /** @return array<string, mixed>|null */
    public static function find(string $file, string $slug): ?array
    {
        $rows = $file === 'catalogo.json' ? self::catalogo($slug) : self::contenido(self::CONTENIDO[$file], $slug);
        return $rows[0] ?? null;
    }

    public static function upsert(string $file, array $item): void
    {
        self::tx(fn () => self::write($file, $item));
    }

    public static function delete(string $file, string $slug): void
    {
        $pdo = Database::pdo();
        if ($file === 'catalogo.json') {
            $pdo->prepare('DELETE FROM catalogo_productos WHERE slug = ?')->execute([$slug]);
        } else {
            $pdo->prepare('DELETE FROM contenido WHERE coleccion = ? AND slug = ?')->execute([self::CONTENIDO[$file], $slug]);
        }
    }

    /** Reemplaza la colección completa (lo usa el importador del CSV y la migración). */
    public static function replaceAll(string $file, array $items): void
    {
        self::tx(function () use ($file, $items): void {
            $pdo = Database::pdo();
            if ($file === 'catalogo.json') {
                $pdo->exec('DELETE FROM catalogo_productos');
            } else {
                $pdo->prepare('DELETE FROM contenido WHERE coleccion = ?')->execute([self::CONTENIDO[$file]]);
            }
            foreach ($items as $item) {
                self::write($file, $item);
            }
        });
    }

    private static function tx(callable $fn): void
    {
        $pdo = Database::pdo();
        $pdo->beginTransaction();
        try {
            $fn();
            $pdo->commit();
        } catch (\Throwable $e) {
            $pdo->rollBack();
            throw $e;
        }
    }

    private static function nextOrden(string $sql, array $params = []): int
    {
        $st = Database::pdo()->prepare($sql);
        $st->execute($params);
        return (int) $st->fetchColumn() + 1;
    }

    private static function write(string $file, array $item): void
    {
        $file === 'catalogo.json' ? self::writeCatalogo($item) : self::writeContenido(self::CONTENIDO[$file], $item);
    }

    private static function writeContenido(string $coleccion, array $item): void
    {
        $json = json_encode($item, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        if ($json === false) {
            throw new \RuntimeException('No se pudo serializar el contenido a JSON.');
        }
        $orden = self::nextOrden('SELECT COALESCE(MAX(orden), 0) FROM contenido WHERE coleccion = ?', [$coleccion]);
        Database::pdo()->prepare(
            'INSERT INTO contenido (coleccion, slug, titulo, orden, data) VALUES (?, ?, ?, ?, ?)
             ON DUPLICATE KEY UPDATE titulo = VALUES(titulo), data = VALUES(data)'
        )->execute([$coleccion, $item['slug'], (string) ($item['title'] ?? ''), $orden, $json]);
    }

    private static function writeCatalogo(array $item): void
    {
        $pdo = Database::pdo();
        $categoria = (string) ($item['categoria'] ?? '') ?: 'general';
        $pdo->prepare('INSERT IGNORE INTO categorias (slug, nombre) VALUES (?, ?)')->execute([$categoria, $categoria]);

        $vals = [
            (string) ($item['wc_id'] ?? ''), (string) $item['title'],
            ($item['condicion'] ?? '') === 'nuevo' ? 'nuevo' : 'usado', $categoria,
            $item['price'] ?? null, (string) ($item['sku'] ?? ''),
            (string) ($item['description_html'] ?? ''), (string) ($item['image_alt'] ?? ''),
        ];

        $st = $pdo->prepare('SELECT id FROM catalogo_productos WHERE slug = ?');
        $st->execute([$item['slug']]);
        $id = $st->fetchColumn();

        if ($id) {
            $id = (int) $id;
            $pdo->prepare(
                'UPDATE catalogo_productos SET wc_id = ?, titulo = ?, condicion = ?, categoria = ?, precio = ?,
                 sku = ?, descripcion_html = ?, image_alt = ? WHERE id = ?'
            )->execute([...$vals, $id]);
            $pdo->prepare('DELETE FROM catalogo_imagenes WHERE producto_id = ?')->execute([$id]);
            $pdo->prepare('DELETE FROM catalogo_specs WHERE producto_id = ?')->execute([$id]);
        } else {
            $orden = self::nextOrden('SELECT COALESCE(MAX(orden), 0) FROM catalogo_productos');
            $pdo->prepare(
                'INSERT INTO catalogo_productos (wc_id, titulo, condicion, categoria, precio, sku, descripcion_html, image_alt, slug, orden)
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)'
            )->execute([...$vals, $item['slug'], $orden]);
            $id = (int) $pdo->lastInsertId();
        }

        $insImg = $pdo->prepare('INSERT INTO catalogo_imagenes (producto_id, ruta, orden) VALUES (?, ?, ?)');
        foreach (array_values($item['images'] ?? []) as $i => $ruta) {
            $insImg->execute([$id, $ruta, $i]);
        }
        $insSpec = $pdo->prepare('INSERT INTO catalogo_specs (producto_id, etiqueta, valor, orden) VALUES (?, ?, ?, ?)');
        foreach (array_values($item['specs'] ?? []) as $i => $spec) {
            $spec = (string) $spec;
            if (str_contains($spec, '|')) {
                [$label, $value] = array_map('trim', explode('|', $spec, 2));
            } else {
                [$label, $value] = ['', $spec];
            }
            $insSpec->execute([$id, $label, $value, $i]);
        }
    }

    /** @return array<int, array<string, mixed>> */
    private static function contenido(string $coleccion, ?string $slug): array
    {
        $sql = 'SELECT data FROM contenido WHERE coleccion = ?' . ($slug !== null ? ' AND slug = ?' : '') . ' ORDER BY orden, id';
        $st = Database::pdo()->prepare($sql);
        $st->execute($slug !== null ? [$coleccion, $slug] : [$coleccion]);
        $out = [];
        foreach ($st->fetchAll(\PDO::FETCH_COLUMN) as $raw) {
            $d = json_decode((string) $raw, true);
            if (is_array($d)) {
                $out[] = $d;
            }
        }
        return $out;
    }

    /** @return array<int, array<string, mixed>> */
    private static function catalogo(?string $slug): array
    {
        $pdo = Database::pdo();
        $where = $slug !== null ? ' WHERE p.slug = ?' : '';
        $params = $slug !== null ? [$slug] : [];

        $st = $pdo->prepare(
            'SELECT p.id, p.slug, p.wc_id, p.titulo, p.condicion, p.categoria, p.precio, p.sku, p.descripcion_html, p.image_alt
             FROM catalogo_productos p' . $where . ' ORDER BY p.orden, p.id'
        );
        $st->execute($params);
        $items = [];
        foreach ($st->fetchAll() as $r) {
            $items[(int) $r['id']] = [
                'slug' => $r['slug'],
                'wc_id' => $r['wc_id'],
                'title' => $r['titulo'],
                'condicion' => $r['condicion'],
                'categoria' => $r['categoria'],
                'price' => $r['precio'] !== null ? (float) $r['precio'] : null,
                'sku' => $r['sku'],
                'description_html' => (string) $r['descripcion_html'],
                'specs' => [],
                'images' => [],
                'image_alt' => $r['image_alt'],
            ];
        }
        if (!$items) {
            return [];
        }

        $st = $pdo->prepare(
            'SELECT i.producto_id, i.ruta FROM catalogo_imagenes i JOIN catalogo_productos p ON p.id = i.producto_id'
            . $where . ' ORDER BY i.producto_id, i.orden, i.id'
        );
        $st->execute($params);
        foreach ($st->fetchAll() as $r) {
            $items[(int) $r['producto_id']]['images'][] = $r['ruta'];
        }

        $st = $pdo->prepare(
            'SELECT s.producto_id, s.etiqueta, s.valor FROM catalogo_specs s JOIN catalogo_productos p ON p.id = s.producto_id'
            . $where . ' ORDER BY s.producto_id, s.orden, s.id'
        );
        $st->execute($params);
        foreach ($st->fetchAll() as $r) {
            $items[(int) $r['producto_id']]['specs'][] = $r['etiqueta'] !== '' ? $r['etiqueta'] . ' | ' . $r['valor'] : $r['valor'];
        }

        return array_values($items);
    }
}
