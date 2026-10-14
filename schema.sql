-- Esquema MySQL/MariaDB de Super Walter (se puede re-ejecutar: usa IF NOT EXISTS).
-- Lo aplica backend/tools/migrar-a-mysql.php; también se puede importar a mano desde phpMyAdmin.

CREATE TABLE IF NOT EXISTS categorias (
  slug   VARCHAR(60)  NOT NULL PRIMARY KEY,
  nombre VARCHAR(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT IGNORE INTO categorias (slug, nombre) VALUES
  ('granos-finos', 'Grano fino'),
  ('granos-gruesos', 'Grano grueso'),
  ('general', 'Maquinaria general');

-- Catálogo de maquinaria nueva y usada (productos-nuevos / productos-usados / catalogo/{slug})
CREATE TABLE IF NOT EXISTS catalogo_productos (
  id               INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  slug             VARCHAR(190) NOT NULL UNIQUE,
  wc_id            VARCHAR(20)  NOT NULL DEFAULT '',
  titulo           VARCHAR(255) NOT NULL,
  condicion        ENUM('nuevo','usado') NOT NULL DEFAULT 'usado',
  categoria        VARCHAR(60)  NOT NULL DEFAULT 'general',
  precio           DECIMAL(14,2) NULL,
  sku              VARCHAR(80)  NOT NULL DEFAULT '',
  descripcion_html MEDIUMTEXT   NULL,
  image_alt        VARCHAR(255) NOT NULL DEFAULT '',
  orden            INT UNSIGNED NOT NULL DEFAULT 0,
  actualizado      TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY idx_condicion_categoria (condicion, categoria),
  CONSTRAINT fk_prod_categoria FOREIGN KEY (categoria) REFERENCES categorias (slug) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS catalogo_imagenes (
  id          INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  producto_id INT UNSIGNED NOT NULL,
  ruta        VARCHAR(255) NOT NULL,
  orden       SMALLINT UNSIGNED NOT NULL DEFAULT 0,
  KEY idx_producto (producto_id, orden),
  CONSTRAINT fk_img_producto FOREIGN KEY (producto_id) REFERENCES catalogo_productos (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabla de especificaciones: etiqueta vacía = fila de texto completo
CREATE TABLE IF NOT EXISTS catalogo_specs (
  id          INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  producto_id INT UNSIGNED NOT NULL,
  etiqueta    VARCHAR(190) NOT NULL DEFAULT '',
  valor       TEXT NOT NULL,
  orden       SMALLINT UNSIGNED NOT NULL DEFAULT 0,
  KEY idx_producto (producto_id, orden),
  CONSTRAINT fk_spec_producto FOREIGN KEY (producto_id) REFERENCES catalogo_productos (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Páginas de producto de línea (coleccion = 'productos') y novedades (coleccion = 'novedades').
-- "data" guarda el contenido completo de la página en JSON.
CREATE TABLE IF NOT EXISTS contenido (
  id        INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  coleccion VARCHAR(40)  NOT NULL,
  slug      VARCHAR(190) NOT NULL,
  titulo    VARCHAR(255) NOT NULL DEFAULT '',
  orden     INT UNSIGNED NOT NULL DEFAULT 0,
  data      LONGTEXT     NOT NULL,
  UNIQUE KEY uq_coleccion_slug (coleccion, slug)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Usuarios del panel admin (login). Si la base está activa, el login valida contra esta tabla.
CREATE TABLE IF NOT EXISTS usuarios (
  id            INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  usuario       VARCHAR(60)  NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  nombre        VARCHAR(120) NOT NULL DEFAULT '',
  activo        TINYINT(1)   NOT NULL DEFAULT 1,
  ultimo_acceso DATETIME     NULL,
  creado        TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
