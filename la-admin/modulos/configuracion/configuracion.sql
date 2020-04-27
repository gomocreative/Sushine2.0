INSERT INTO modulo (modulo, nombre, activo, orden, add_usuario, add_fecha) VALUES ('configuracion', 'Configuración', 'Y', 2, 1, now());

INSERT INTO pantalla (pantalla, pantalla_padre, modulo, nombre, link, activo, orden, add_usuario, add_fecha) VALUES 
('configuracion_general', NULL, 'configuracion', 'General', 'configuracion_general.php', 'Y', 1, 1, now());

CREATE TABLE configuracion_general (
  codigo varchar(255) NOT NULL,
  nombre varchar(255) NOT NULL,
  valor varchar(255) NULL,
  orden smallint NOT NULL,
  tipo enum('text','textarea','file','checkbox','img') NOT NULL,
  ancho int NULL,
  alto  int NULL,
  activo enum('Y','N') NOT NULL,
  add_usuario int(11) NOT NULL,
  add_fecha datetime NOT NULL,
  mod_usuario int(11) NULL,
  mod_fecha datetime NULL,
  PRIMARY KEY (codigo)
) ENGINE=InnoDB;

INSERT INTO configuracion_general(codigo, nombre, valor, orden, tipo, ancho, alto, activo, add_usuario, add_fecha) VALUES ('nombre_empresa', 'Nombre empresa', NULL, 1, 'text', NULL, NULL, 'Y', 1, now());
INSERT INTO configuracion_general(codigo, nombre, valor, orden, tipo, ancho, alto, activo, add_usuario, add_fecha) VALUES ('direccion_empresa', 'Dirección empresa', NULL, 2, 'text', NULL, NULL, 'Y', 1, now());
INSERT INTO configuracion_general(codigo, nombre, valor, orden, tipo, ancho, alto, activo, add_usuario, add_fecha) VALUES ('email_empresa', 'Correo electrónico', NULL, 3, 'text', NULL, NULL, 'Y', 1, now());
INSERT INTO configuracion_general(codigo, nombre, valor, orden, tipo, ancho, alto, activo, add_usuario, add_fecha) VALUES ('telefono_empresa', 'Teléfono', NULL, 4, 'text', NULL, NULL, 'Y', 1, now());
INSERT INTO configuracion_general(codigo, nombre, valor, orden, tipo, ancho, alto, activo, add_usuario, add_fecha) VALUES ('fax_empresa', 'Fax', NULL, 5, 'text', NULL, NULL, 'Y', 1, now());
INSERT INTO configuracion_general(codigo, nombre, valor, orden, tipo, ancho, alto, activo, add_usuario, add_fecha) VALUES ('logo_empresa', 'Logo', NULL, 6, 'img', 100, 100, 'Y', 1, now());
INSERT INTO configuracion_general(codigo, nombre, valor, orden, tipo, ancho, alto, activo, add_usuario, add_fecha) VALUES ('eslogan_empresa', 'Eslogan', NULL, 7, 'text', NULL, NULL, 'Y', 1, now());
INSERT INTO configuracion_general(codigo, nombre, valor, orden, tipo, ancho, alto, activo, add_usuario, add_fecha) VALUES ('favicon_empresa', 'Favicon', NULL, 8, 'img', 16, 16, 'Y', 1, now());
INSERT INTO configuracion_general(codigo, nombre, valor, orden, tipo, ancho, alto, activo, add_usuario, add_fecha) VALUES ('descripcion_empresa', 'Descripción de la empresa', NULL, 9, 'textarea', NULL, NULL, 'Y', 1, now());
INSERT INTO configuracion_general(codigo, nombre, valor, orden, tipo, ancho, alto, activo, add_usuario, add_fecha) VALUES ('keyword_empresa', 'Palabras claves', NULL, 10, 'text', NULL, NULL, 'Y', 1, now());
INSERT INTO configuracion_general(codigo, nombre, valor, orden, tipo, ancho, alto, activo, add_usuario, add_fecha) VALUES ('facebook_empresa', 'Facebook', NULL, 11, 'text', NULL, NULL, 'Y', 1, now());
INSERT INTO configuracion_general(codigo, nombre, valor, orden, tipo, ancho, alto, activo, add_usuario, add_fecha) VALUES ('twitter_empresa', 'Twitter', NULL, 11, 'text', NULL, NULL, 'Y', 1, now());
INSERT INTO configuracion_general(codigo, nombre, valor, orden, tipo, ancho, alto, activo, add_usuario, add_fecha) VALUES ('gplus_empresa', 'Google+', NULL, 12, 'text', NULL, NULL, 'Y', 1, now());
INSERT INTO configuracion_general(codigo, nombre, valor, orden, tipo, ancho, alto, activo, add_usuario, add_fecha) VALUES ('youtube_empresa', 'YouTube+', NULL, 13, 'text', NULL, NULL, 'Y', 1, now());

INSERT INTO pantalla (pantalla, pantalla_padre, modulo, nombre, link, activo, orden, add_usuario, add_fecha) VALUES 
('configuracion_multimedia', NULL, 'configuracion', 'Multimedia', 'configuracion_multimedia.php', 'Y', 2, 1, now());