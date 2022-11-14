use midgard;

DELETE FROM PANTALLA_PUBLICACION WHERE id_publicacion IS NOT NULL AND mac_pantalla IS NOT NULL;
DELETE FROM PUBLICACION WHERE id_publicacion IS NOT NULL;
DELETE FROM USUARIO WHERE username IS NOT NULL;
DELETE FROM ROL WHERE id_rol IS NOT NULL;
DELETE FROM PANTALLA WHERE mac_pantalla IS NOT NULL;
DELETE FROM ESTADO WHERE id_estado IS NOT NULL;

INSERT INTO ESTADO VALUES 
(1, "Activo"),
(2, "Pendiente"),
(3, "Denegado"),
(4, "Archivada");

INSERT INTO PANTALLA VALUES 
("00:1e:c2:9e:28:1b", "Edificio de Servicios Centrales", "Redondo 1"),
("00:1e:c2:9e:28:2b", "Edificio Botánico LOSCOS", "Loscos 1"),
("00:1e:c2:9e:28:3b", "Edificio Cardenal RAM", "Ram 1"),
("00:1e:c2:9e:28:4b", "Edificio Cardenal RAM", "Ram 2");

INSERT INTO ROL VALUES 
(1, "Admin"),
(2, "Aprobador"),
(3, "Publicador");

INSERT INTO USUARIO VALUES 
("mario", "midgard123", "Mario Aguirre", "marioaguirre516@gmail.com", '12345678Y', false, 1),
("david", "midgard123", "David Lucea", "redcatter554@gmail.com", '21345678S', false, 1),
("ruben", "midgard123", "Ruben Sancho Puig", "rubeensanchoopuigg18@gmail.com", '31245678G', false, 1),
("pablo", "midgard123", "Gil Pablo Blanco", "gilpablo2000.GPBP@gmail.com", '43215678E', false, 1),
("aprobador", "midgard123", "Profesor", "aprobador@gmail.com", '12345678E', false, 2),
("publicador", "midgard123", "Alumno", "publicador@gmail.com", '98765432R', false, 3),
("usuarioInactivo", "midgard123", "Inactivo", "inactivo@gmail.com", '45621378U', true, 3);

/* FORMATO FECHA MYSQL: AAAA-MM-DD */
INSERT INTO PUBLICACION VALUES
(1, "2022-10-29", "Noticia 1", "2022-11-01", "2022-11-30", "Noticia aprobada en todas las pantallas", null, "2022-11-02", "ruben", "ruben", 1),
(2, "2022-10-29", "Noticia 2", "2022-11-11", "2022-11-20", "Noticia de p4 unicamente pero sin aprobar (no deberia mostrarse en ninguna pantalla)", null, null, "publicador", null, 2),
(3, "2022-10-31", "Noticia 3", "2022-10-31", "2022-11-20", "Noticia realizada por un aprobador", null, "2022-11-02", "aprobador", "aprobador", 1),
(4, "2022-11-03", "Noticia 4", "2022-11-10", "2022-11-11", "Noticia inactiva (no deberia mostrarse en ninguna pantalla)", null, "2022-11-03", "pablo", "pablo", 4),
(5, "2022-11-04", "Noticia 5", "2022-11-04", "2022-11-30", "Noticia que se muestra en p1 y p3 con imagen", "logo.png", "2022-11-04", "publicador", "mario", 1),
(6, "2022-11-06", "Noticia 6", "2022-11-04", "2022-11-30", "Noticia denegada (no deberia mostrarse en ninguna pantalla)", null, "2022-11-04", "usuarioInactivo", "pablo", 3),
(7, "2022-11-06", null, "2022-11-04", "2022-11-30", null, "guardias.pdf", "2022-11-04", "aprobador", "aprobador", 1); /* Noticia con solo un archivo */

INSERT INTO PANTALLA_PUBLICACION VALUES 
(1, "00:1e:c2:9e:28:1b"),
(1, "00:1e:c2:9e:28:2b"),
(1, "00:1e:c2:9e:28:3b"),
(1, "00:1e:c2:9e:28:4b"),
(2, "00:1e:c2:9e:28:4b"),
(3, "00:1e:c2:9e:28:3b"),
(3, "00:1e:c2:9e:28:4b"),
(4, "00:1e:c2:9e:28:1b"),
(5, "00:1e:c2:9e:28:1b"),
(5, "00:1e:c2:9e:28:3b"),
(6, "00:1e:c2:9e:28:2b"),
(6, "00:1e:c2:9e:28:3b"),
(7, "00:1e:c2:9e:28:1b"),
(7, "00:1e:c2:9e:28:3b"),
(7, "00:1e:c2:9e:28:4b");