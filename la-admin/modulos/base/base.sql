CREATE TABLE modulo (
  modulo varchar(75) NOT NULL,
  nombre varchar(100) NOT NULL,
  activo enum('Y','N') NOT NULL,
  orden smallint NOT NULL,
  add_usuario int(11) NOT NULL,
  add_fecha datetime NOT NULL,
  mod_usuario int(11) NULL,
  mod_fecha datetime NULL,
  PRIMARY KEY (modulo)
) ENGINE=InnoDB;

CREATE TABLE pantalla (
  pantalla varchar(75) NOT NULL,
  pantalla_padre varchar(75) NULL,
  modulo varchar(75) NOT NULL,
  nombre varchar(100) NOT NULL,
  link varchar(255) NULL,
  activo enum('Y','N') NOT NULL,
  orden smallint NOT NULL,
  add_usuario int(11) NOT NULL,
  add_fecha datetime NOT NULL,
  mod_usuario int(11) NULL,
  mod_fecha datetime NULL,
  PRIMARY KEY (pantalla)
) ENGINE=InnoDB;