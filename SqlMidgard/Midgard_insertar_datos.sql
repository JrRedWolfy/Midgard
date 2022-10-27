use midgard;

DELETE FROM PANTALLA_PUBLICACION WHERE id_publicacion IS NOT NULL AND ip_pantalla IS NOT NULL;
DELETE FROM PUBLICACION WHERE id_publicacion IS NOT NULL;
DELETE FROM ROL_USUARIO WHERE username IS NOT NULL AND id_rol IS NOT NULL;
DELETE FROM DEPARTAMENTO_USUARIO WHERE username IS NOT NULL AND id_departamento IS NOT NULL;
DELETE FROM USUARIO WHERE username IS NOT NULL;
DELETE FROM ROL WHERE id_rol IS NOT NULL;
DELETE FROM PANTALLA WHERE ip IS NOT NULL;
DELETE FROM ESTADO WHERE id_estado IS NOT NULL;
DELETE FROM DEPARTAMENTO WHERE id_departamento IS NOT NULL;

INSERT INTO DEPARTAMENTO VALUES 
(1, 'Administrativo'),
(2, 'Automoción'),
(3, 'Electricidad'),
(4, 'Informática'),
(5, 'Sanitaria');

INSERT INTO ESTADO VALUES 
(1, "Activo"),
(2, "Pendiente"),
(3, "Denegado");

INSERT INTO PANTALLA VALUES 
("192.168.4.168", "Edificio de Servicios Centrales"),
("192.168.4.169", "Edificio Botánico LOSCOS"),
("192.168.4.170", "Edificio Cardenal RAM"),
("192.168.4.171", "Edificio Cardenal RAM");

INSERT INTO ROL VALUES 
(1, "Admin"),
(2, "Aprobador"),
(3, "Publicador");

INSERT INTO USUARIO VALUES 
("mario", "123", "Mario Aguirre", "marioaguirre516@gmail.com", '12345678'),
("david", "123", "David Lucea", "redcatter554@gmail.com", '21345678S'),
("ruben", "123", "Ruben Sancho Puig", "rubeensanchoopuigg18@gmail.com", '31245678G'),
("pablo", "123", "Gil Pablo Blanco", "gilpablo2000.GPBP@gmail.com", '43215678E');

INSERT INTO DEPARTAMENTO_USUARIO VALUES 
("mario", 4),
("mario", 5),
("david", 4),
("ruben", 4),
("pablo", 4);

INSERT INTO ROL_USUARIO VALUES 
("mario", 3),
("mario", 2),
("mario", 1),
("david", 2),
("david", 1),
("ruben", 1),
("pablo", 1);

 /* FORMATO FECHA MYSQL: AAAA-MM-DD */
INSERT INTO PUBLICACION VALUES
(1, "2022-10-29", "Titulo 1", "2022-10-29", "2022-11-10", "Mensaje 1", null, "2022-11-02", "mario", "ruben", 1),
(2, "2022-10-29", "Titulo 2", "2022-10-29", "2022-11-05", "Mensaje 2", null, null,"david", null, 2),
(3, "2022-10-31", "Titulo 3", "2022-10-31", "2022-11-04", "Mensaje 3", null, null, "pablo", null, 2),
(4, "2022-11-03", "Titulo 4", "2022-11-03", "2022-11-04", "Mensaje 4", null, "2022-11-03", "ruben", "david", 3),
(5, "2022-11-04", "Titulo 5", "2022-11-04", "2022-11-07", "Mensaje 5", null, "2022-11-04", "david", "mario", 1);

INSERT INTO PANTALLA_PUBLICACION VALUES 
(1, "192.168.4.168"),
(1, "192.168.4.169"),
(1, "192.168.4.170"),
(1, "192.168.4.171"),
(2, "192.168.4.171"),
(3, "192.168.4.170"),
(3, "192.168.4.171"),
(5, "192.168.4.168"),
(5, "192.168.4.169"),
(6, "192.168.4.168");