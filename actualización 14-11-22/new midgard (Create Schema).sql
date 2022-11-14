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
  mac_pantalla varchar(17) PRIMARY KEY NOT NULL,
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
  email varchar(200) UNIQUE NOT NULL,
  dni varchar(11) UNIQUE KEY,
  inactivo boolean NOT NULL,
  id_rol int,
  CONSTRAINT FK1 FOREIGN KEY (id_rol) references ROL (id_rol) on delete restrict on update cascade
); 

/* TABLA 5 */
drop table if exists PUBLICACION;
CREATE TABLE PUBLICACION (
  id_publicacion int PRIMARY KEY NOT NULL AUTO_INCREMENT,
  fechaCreacion date NOT NULL,
  titulo varchar(200),
  fechaInicio date NOT NULL,
  fechaFin date NOT NULL,
  mensaje varchar(5000),
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
  mac_pantalla varchar(17) NOT NULL,
  PRIMARY KEY (id_publicacion, mac_pantalla),
  CONSTRAINT FK5 FOREIGN KEY (id_publicacion) references PUBLICACION (id_publicacion) on delete restrict on update cascade,
  CONSTRAINT FK6 FOREIGN KEY (mac_pantalla) references PANTALLA (mac_pantalla) on delete restrict on update cascade
);

/* ELIMINA LOS REGISTROS M:N DE PANTALLA_PUBLICACION TRAS UN DELETE DE UNA PUBLICACIÓN */
delimiter $$
drop trigger if exists gestionDeletePublicacion $$
create trigger gestionDeletePublicacion before delete on PUBLICACION for each row
	begin
   	 declare CONTADOR_PANTALLA_PUBLICACION int;
   	 select ifnull(count(PANTALLA_PUBLICACION.id_publicacion), 0) into CONTADOR_PANTALLA_PUBLICACION from PUBLICACION, PANTALLA_PUBLICACION where PUBLICACION.id_publicacion = PANTALLA_PUBLICACION.id_publicacion; /* Si da mayor a 0 es porque ese nombre en especifico esta en ambas tablas */
   	 if (CONTADOR_PANTALLA_PUBLICACION > 0) then
   		 delete from PANTALLA_PUBLICACION where id_publicacion=old.id_publicacion;
   	 end if;
	end;
$$

/* ELIMINA LOS REGISTROS M:N DE PANTALLA_PUBLICACION TRAS UN DELETE DE UNA PANTALLA */
delimiter $$
drop trigger if exists gestionDeletePantalla $$
create trigger gestionDeletePantalla before delete on PANTALLA for each row
	begin
   	 declare CONTADOR_PANTALLA_PUBLICACION int;
   	 select ifnull(count(PANTALLA_PUBLICACION.mac_pantalla), 0) into CONTADOR_PANTALLA_PUBLICACION from PANTALLA, PANTALLA_PUBLICACION where PANTALLA.mac_pantalla = PANTALLA_PUBLICACION.mac_pantalla; /* Si da mayor a 0 es porque ese nombre en especifico esta en ambas tablas */
   	 if (CONTADOR_PANTALLA_PUBLICACION > 0) then
   		 delete from PANTALLA_PUBLICACION where mac_pantalla=old.mac_pantalla;
   	 end if;
	end;
$$

/* PROCEDURE que me muestra las publicaciones que están activas en función de la pantalla */
DROP PROCEDURE IF exists publicacionPantalla;
delimiter $$
CREATE PROCEDURE publicacionPantalla (in mac_enviada varchar(17), in fechaActual date) BEGIN
    
select p.id_publicacion, p.fechaCreacion, p.titulo, p.fechaInicio, p.fechaFin, p.mensaje, p.imagen, p.fechaAprobacion, p.escritor, p.aprobador FROM PUBLICACION p, PANTALLA_PUBLICACION pp WHERE p.id_publicacion = pp.id_publicacion and mac_enviada= pp.mac_pantalla and p.id = '1' and fechaActual between fechaInicio and fechaFin;

end $$