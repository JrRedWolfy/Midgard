drop schema if exists midgard;
create schema midgard;
use midgard;

/* TABLA 1 */
drop table if exists ESTADO;
CREATE TABLE ESTADO (
  id_estado int PRIMARY KEY NOT NULL AUTO_INCREMENT,
  nombre_estado varchar(100) NOT NULL
);

/* TABLA 2 */
drop table if exists PANTALLA;
CREATE TABLE PANTALLA (
  ip varchar(15) PRIMARY KEY NOT NULL,
  ubicacion varchar(200) NOT NULL,
  nombre varchar(30) NOT NULL
);

/* TABLA 3 */
drop table if exists ROL;
CREATE TABLE ROL (
  id_rol int PRIMARY KEY NOT NULL AUTO_INCREMENT,
  nombre_rol varchar(100) NOT NULL
); 

/* TABLA 4 */
drop table if exists USUARIO;
CREATE TABLE USUARIO (
  username varchar(50) PRIMARY KEY NOT NULL,
  clave varchar(50) NOT NULL,
  nombre varchar(100) NOT NULL,
  email varchar(200) NOT NULL,
  dni varchar(11) UNIQUE KEY,
  id_rol int,
  CONSTRAINT FK1 FOREIGN KEY (id_rol) references ROL (id_rol) on delete restrict on update cascade
); 

/* TABLA 5 */
drop table if exists PUBLICACION;
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
  CONSTRAINT FK2 FOREIGN KEY (escritor) references USUARIO (username) on delete restrict on update cascade,
  CONSTRAINT FK3 FOREIGN KEY (aprobador) references USUARIO (username) on delete restrict on update cascade,
  CONSTRAINT FK4 FOREIGN KEY (id) references ESTADO (id_estado) on delete restrict on update cascade
);

/* TABLA 6 */
drop table if exists PANTALLA_PUBLICACION;
CREATE TABLE PANTALLA_PUBLICACION ( /* ESTAR */
  id_publicacion int NOT NULL,
  ip_pantalla varchar(15) NOT NULL,
  PRIMARY KEY (id_publicacion, ip_pantalla),
  CONSTRAINT FK5 FOREIGN KEY (id_publicacion) references PUBLICACION (id_publicacion) on delete restrict on update cascade,
  CONSTRAINT FK6 FOREIGN KEY (ip_pantalla) references PANTALLA (ip) on delete restrict on update cascade
);
