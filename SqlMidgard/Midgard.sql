drop schema if exists midgard;
create schema midgard;
use midgard;

/* TABLA 1 */
CREATE TABLE DEPARTAMENTO (
  id_departamento int PRIMARY KEY NOT NULL AUTO_INCREMENT,
  nombre varchar(200) NOT NULL
);

/* TABLA 2 */
CREATE TABLE ESTADO (
  id_estado int PRIMARY KEY NOT NULL AUTO_INCREMENT,
  nombre_estado varchar(100) NOT NULL
);

/* TABLA 3 */
CREATE TABLE PANTALLA (
  ip int PRIMARY KEY NOT NULL,
  ubicacion varchar(200) NOT NULL
);

/* TABLA 4 */
CREATE TABLE ROL (
  id_rol int PRIMARY KEY NOT NULL AUTO_INCREMENT,
  nombre_rol varchar(100) NOT NULL
); 

/* TABLA 5 */
CREATE TABLE USUARIO (
  username varchar(50) PRIMARY KEY NOT NULL,
  clave varchar(50) NOT NULL,
  nombre varchar(100) NOT NULL,
  email varchar(200) NOT NULL,
  dni varchar(11) UNIQUE KEY
); 

/* TABLA 6 */
CREATE TABLE DEPARTAMENTO_USUARIO ( /* PERTENECER */
  username varchar(50) NOT NULL,
  id_departamento int NOT NULL,
  PRIMARY KEY (username, id_departamento),
  CONSTRAINT FK1 FOREIGN KEY (username) references USUARIO (username) on delete restrict on update cascade,
  CONSTRAINT FK2 FOREIGN KEY (id_departamento) references DEPARTAMENTO (id_departamento) on delete restrict on update cascade
);

/* TABLA 7 */
CREATE TABLE ROL_USUARIO ( /* PERTENECER */
  username varchar(50) NOT NULL,
  id_rol int NOT NULL,
  PRIMARY KEY (username, id_rol),
  CONSTRAINT FK3 FOREIGN KEY (username) references USUARIO (username) on delete restrict on update cascade,
  CONSTRAINT FK4 FOREIGN KEY (id_rol) references ROL (id_rol) on delete restrict on update cascade
);

/* TABLA 8 */
CREATE TABLE PUBLICACION (
  id_publicacion int PRIMARY KEY NOT NULL AUTO_INCREMENT,
  fechaCreacion date NOT NULL,
  titulo varchar(200) NOT NULL,
  fechaInicio date NOT NULL,
  fechaFin date NOT NULL,
  mensaje varchar(5000) NOT NULL,
  imagen varchar(500),
  fechaAprobacion date DEFAULT NULL,
  escritor varchar(50),
  aprobador varchar(50) DEFAULT NULL,
  id int, 
  CONSTRAINT FK5 FOREIGN KEY (escritor) references USUARIO (username) on delete restrict on update cascade,
  CONSTRAINT FK6 FOREIGN KEY (aprobador) references USUARIO (username) on delete restrict on update cascade,
  CONSTRAINT FK7 FOREIGN KEY (id) references ESTADO (id_estado) on delete restrict on update cascade
);

/* TABLA 9 */
CREATE TABLE PANTALLA_PUBLICACION ( /* ESTAR */
  id_publicacion int NOT NULL,
  ip_pantalla int NOT NULL,
  PRIMARY KEY (id_publicacion, ip_pantalla),
  CONSTRAINT FK8 FOREIGN KEY (id_publicacion) references PUBLICACION (id_publicacion) on delete restrict on update cascade,
  CONSTRAINT FK9 FOREIGN KEY (ip_pantalla) references PANTALLA (ip) on delete restrict on update cascade
);