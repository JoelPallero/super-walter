<?php
declare(strict_types=1);

namespace SuperWalter;

require_once __DIR__ . '/Database.php';

/**
 * Acceso a las colecciones JSON de contenido (productos, novedades) que
 * viven en backend/data/, fuera de public_html. Sin base de datos: el
 * panel admin lee y reescribe estos archivos directamente.
 */
class JsonStore
{
    private static function path(string $file): string
    {
        return __DIR__ . '/data/' . $file;
    }

    /** @return array<int, array<string, mixed>> */
    public static function all(string $file): array
    {
        if (DbStore::handles($file)) {
            return DbStore::all($file);
        }
        return self::allFromFile($file);
    }

    /** Lee directamente el JSON de backend/data/ (ignora la base de datos). */
    public static function allFromFile(string $file): array
    {
        $path = self::path($file);
        if (!is_file($path)) {
            return [];
        }
        $raw = file_get_contents($path);
        if ($raw === false || trim($raw) === '') {
            return [];
        }
        $data = json_decode($raw, true);
        return is_array($data) ? $data : [];
    }

    /**
     * Colección en el idioma pedido. Para 'en' toma, por slug, los campos traducidos de
     * "<nombre>-en.json" (ej: productos-en.json) y deja el resto (imágenes, precio,
     * categoría...) del original; un campo traducido vacío cae al español.
     *
     * @return array<int, array<string, mixed>>
     */
    public static function allLocalized(string $file, string $lang): array
    {
        $items = self::all($file);
        if ($lang !== 'en') {
            return $items;
        }
        $over = [];
        foreach (self::all(str_replace('.json', '-en.json', $file)) as $o) {
            $over[$o['slug'] ?? ''] = $o;
        }
        foreach ($items as $i => $item) {
            if (isset($over[$item['slug'] ?? ''])) {
                $items[$i] = self::overlay($item, $over[$item['slug']]);
            }
        }
        return $items;
    }

    /** @return array<string, mixed>|null */
    public static function findLocalized(string $file, string $slug, string $lang): ?array
    {
        $item = self::find($file, $slug);
        if ($item === null || $lang !== 'en') {
            return $item;
        }
        $o = self::find(str_replace('.json', '-en.json', $file), $slug);
        return $o === null ? $item : self::overlay($item, $o);
    }

    private static function overlay(array $base, array $over): array
    {
        foreach ($over as $k => $v) {
            if ($k === 'slug' || $v === '' || $v === [] || $v === null) {
                continue;
            }
            $isAssoc = is_array($v) && array_keys($v) !== range(0, count($v) - 1);
            if ($isAssoc && is_array($base[$k] ?? null)) {
                $base[$k] = array_replace($base[$k], array_filter($v, static fn ($x) => $x !== '' && $x !== null));
            } else {
                $base[$k] = $v;
            }
        }
        return $base;
    }

    /** @return array<string, mixed>|null */
    public static function find(string $file, string $slug): ?array
    {
        if (DbStore::handles($file)) {
            return DbStore::find($file, $slug);
        }
        foreach (self::all($file) as $item) {
            if (($item['slug'] ?? '') === $slug) {
                return $item;
            }
        }
        return null;
    }

    public static function slugExists(string $file, string $slug, string $ignoreSlug = ''): bool
    {
        foreach (self::all($file) as $item) {
            $itemSlug = $item['slug'] ?? '';
            if ($itemSlug === $slug && $itemSlug !== $ignoreSlug) {
                return true;
            }
        }
        return false;
    }

    /**
     * Escritura atómica: escribe en un archivo temporal en el mismo
     * directorio y lo reemplaza con rename(), con flock() para evitar
     * lecturas/escrituras simultáneas pisándose.
     *
     * @param array<int, array<string, mixed>> $items
     */
    public static function save(string $file, array $items): void
    {
        if (DbStore::handles($file)) {
            DbStore::replaceAll($file, $items);
            return;
        }
        $path = self::path($file);
        $json = json_encode(
            array_values($items),
            JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
        );
        if ($json === false) {
            throw new \RuntimeException('No se pudo serializar el contenido a JSON.');
        }

        // El lock vive en un archivo aparte (no el propio JSON): en Windows,
        // rename() no puede reemplazar un archivo que tiene un handle abierto,
        // así que nunca conviene tener el destino abierto mientras se hace el
        // rename atómico.
        $lockHandle = fopen($path . '.lock', 'c');
        if ($lockHandle === false) {
            throw new \RuntimeException('No se pudo abrir el lock del archivo de datos.');
        }

        try {
            if (!flock($lockHandle, LOCK_EX)) {
                throw new \RuntimeException('No se pudo bloquear el archivo de datos.');
            }

            $tmpPath = $path . '.' . bin2hex(random_bytes(6)) . '.tmp';
            if (file_put_contents($tmpPath, $json . "\n", LOCK_EX) === false) {
                throw new \RuntimeException('No se pudo escribir el archivo temporal.');
            }
            if (!rename($tmpPath, $path)) {
                @unlink($tmpPath);
                throw new \RuntimeException('No se pudo reemplazar el archivo de datos.');
            }
        } finally {
            flock($lockHandle, LOCK_UN);
            fclose($lockHandle);
        }
    }

    public static function upsert(string $file, array $item): void
    {
        if (DbStore::handles($file)) {
            DbStore::upsert($file, $item);
            return;
        }
        $items = self::all($file);
        $found = false;
        foreach ($items as $i => $existing) {
            if (($existing['slug'] ?? '') === $item['slug']) {
                $items[$i] = $item;
                $found = true;
                break;
            }
        }
        if (!$found) {
            $items[] = $item;
        }
        self::save($file, $items);
    }

    public static function delete(string $file, string $slug): void
    {
        if (DbStore::handles($file)) {
            DbStore::delete($file, $slug);
            return;
        }
        $items = array_values(array_filter(
            self::all($file),
            static fn (array $item): bool => ($item['slug'] ?? '') !== $slug
        ));
        self::save($file, $items);
    }
}
