INSERT INTO modulo (modulo, nombre, activo, orden, add_usuario, add_fecha) VALUES ('usuarios', 'Usuarios', 'Y', 1, 1, now());

INSERT INTO pantalla (pantalla, pantalla_padre, modulo, nombre, link, activo, orden, add_usuario, add_fecha) VALUES 
('usuarios_usuario', NULL, 'usuarios', 'Usuarios', 'usuario.php', 'Y', 1, 1, now());

CREATE TABLE usuario (
  usuario int(11) NOT NULL AUTO_INCREMENT,
  nombre varchar(75) NOT NULL,
  cuenta varchar(75) NOT NULL,
  password varchar(33) NOT NULL,
  tipo_usuario enum('administrador','normal') NOT NULL DEFAULT 'normal',
  activo enum('Y','N') NOT NULL DEFAULT 'N',
  eliminado enum('Y','N') NOT NULL DEFAULT 'N',
  email varchar(75) NOT NULL,
  direccion text,
  telefono varchar(255) NULL,
  add_usuario int(11) NOT NULL,
  add_fecha datetime NOT NULL,
  mod_usuario int(11) NULL,
  mod_fecha datetime NULL,
  PRIMARY KEY (usuario)
) ENGINE=InnoDB;

INSERT INTO usuario (usuario, nombre, cuenta, password, tipo_usuario, activo, eliminado, email, add_usuario, add_fecha) VALUES
(1, 'Ludbyn Haroldo Marroquin Arevalo', 'lmarroquin', '098f6bcd4621d373cade4e832627b4f6', 'administrador', 'Y', 'N', 'lhmarroquin@gmail.com', 1, now()),
(2, 'Abraham Lopez', 'alopez', '098f6bcd4621d373cade4e832627b4f6', 'administrador', 'Y', 'N', 'abralc@gmail.com', 1, now());

CREATE TABLE usuario_pantalla (
  usuario int(11) NOT NULL,
  pantalla varchar(75) NOT NULL,
  add_usuario int(11) NOT NULL,
  add_fecha datetime NOT NULL,
  PRIMARY KEY (usuario,pantalla)
) ENGINE=InnoDB;

CREATE TABLE rol (
  rol int(11) NOT NULL AUTO_INCREMENT,
  nombre varchar(75) NOT NULL,
  activo enum('Y','N') NOT NULL,
  add_usuario int(11) NOT NULL,
  add_fecha datetime NOT NULL,
  mod_usuario int(11) NULL,
  mod_fecha datetime NULL,
  PRIMARY KEY (rol)
) ENGINE=InnoDB;

CREATE TABLE usuario_rol (
  usuario int(11) NOT NULL,
  rol int(11) NOT NULL,
  add_usuario int(11) NOT NULL,
  add_fecha datetime NOT NULL,
  PRIMARY KEY (usuario,rol)
) ENGINE=InnoDB;

INSERT INTO rol (rol, nombre, activo, add_usuario, add_fecha) VALUES 
(NULL, 'Gerente de ventas', 'Y', 1, now()),
(NULL, 'Ejecutivo de ventas', 'Y', 1, now());