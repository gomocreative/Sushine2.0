INSERT INTO modulo (modulo, nombre, activo, orden, add_usuario, add_fecha) VALUES ('catalogo', 'Catálogo', 'Y', 5, 1, now());

INSERT INTO pantalla (pantalla, pantalla_padre, modulo, nombre, link, activo, orden, add_usuario, add_fecha) VALUES 
('catalogo_categoria', NULL, 'catalogo', 'Categorias', 'catalogo_categoria.php', 'Y', 1, 1, now());

INSERT INTO pantalla (pantalla, pantalla_padre, modulo, nombre, link, activo, orden, add_usuario, add_fecha) VALUES 
('catalogo_sub_categoria', NULL, 'catalogo', 'Sub-Categorias', 'catalogo_sub_categoria.php', 'Y', 2, 1, now());

INSERT INTO pantalla (pantalla, pantalla_padre, modulo, nombre, link, activo, orden, add_usuario, add_fecha) VALUES 
('catalogo_marca', NULL, 'catalogo', 'Marcas', 'catalogo_marca.php', 'Y', 3, 1, now());

INSERT INTO pantalla (pantalla, pantalla_padre, modulo, nombre, link, activo, orden, add_usuario, add_fecha) VALUES 
('catalogo_caracteristica', NULL, 'catalogo', 'Características', 'catalogo_caracteristica.php', 'Y', 4, 1, now());

INSERT INTO pantalla (pantalla, pantalla_padre, modulo, nombre, link, activo, orden, add_usuario, add_fecha) VALUES 
('catalogo_producto', NULL, 'catalogo', 'Producto', 'catalogo_producto.php', 'Y', 5, 1, now());

CREATE TABLE catalogo_categoria (
  catalogo_categoria smallint unsigned NOT NULL AUTO_INCREMENT,
  catalogo_categoria_padre smallint DEFAULT NULL,
  nombre varchar(75) NOT NULL,
  activo enum('Y','N') NOT NULL,
  PRIMARY KEY (catalogo_categoria)
) ENGINE=InnoDB;

CREATE TABLE catalogo_caracteristica (
  catalogo_caracteristica smallint unsigned NOT NULL AUTO_INCREMENT,
  nombre varchar(75) NOT NULL,
  activo enum('Y','N') NOT NULL,
  PRIMARY KEY (catalogo_caracteristica)
) ENGINE=InnoDB;

CREATE TABLE catalogo_marca (
  catalogo_marca smallint unsigned NOT NULL AUTO_INCREMENT,
  nombre varchar(75) NOT NULL,
  imagen varchar(255) NULL,
  activo enum('Y','N') NOT NULL,
  PRIMARY KEY (catalogo_marca)
) ENGINE=InnoDB;

CREATE TABLE catalogo (
  catalogo int unsigned NOT NULL AUTO_INCREMENT,
  codigo varchar(25) NOT NULL,
  nombre varchar(75) NOT NULL,
  precio decimal(10,2) NOT NULL,
  precio_oferta decimal(10,2) NULL,
  en_oferta enum('Y','N') NOT NULL,
  cantidad int NULL,
  descripcion text,
  especificacion text,
  imagen varchar(255) NULL,
  catalogo_categoria smallint NULL,
  catalogo_sub_categoria smallint NULL,
  catalogo_marca smallint NULL,
  activo enum('Y','N') NOT NULL,
  destacar enum('Y','N') NOT NULL,
  nuevo enum('Y','N') NOT NULL,
  recomendar enum('Y','N') NOT NULL,
  add_usuario int(11) NOT NULL,
  add_fecha datetime NOT NULL,
  mod_usuario int(11) NULL,
  mod_fecha datetime NULL,
  PRIMARY KEY (catalogo)
) ENGINE=InnoDB;

CREATE TABLE catalogo_c (
  catalogo_c int unsigned NOT NULL AUTO_INCREMENT,
  catalogo int unsigned NOT NULL,
  catalogo_caracteristica smallint unsigned NOT NULL,
  valor varchar(255) NOT NULL,
  PRIMARY KEY (catalogo_c)
) ENGINE=InnoDB;

CREATE TABLE catalogo_imagen (
  catalogo_imagen smallint unsigned NOT NULL AUTO_INCREMENT,
  catalogo int unsigned NOT NULL,
  imagen varchar(255) NOT NULL,
  PRIMARY KEY (catalogo_imagen)
) ENGINE=InnoDB;


ALTER TABLE `catalogo_categoria` ADD `nombre_en` VARCHAR(75) NULL AFTER `nombre`;

ALTER TABLE `catalogo` ADD `nombre_en` VARCHAR(75) NULL AFTER `nombre`;
ALTER TABLE `catalogo` ADD `descripcion_en` TEXT NULL AFTER `descripcion`;