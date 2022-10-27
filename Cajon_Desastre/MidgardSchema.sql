drop schema if exists midgard;
create schema midgard;


use midgard;

Create table Usuario(
username varchar(80) primary key,
permiso tinyint not null default 1,
clave enum('texto', 'sha1', 'md5') not null,
email varchar(120) Unique not null,
departamento varchar(30) not null
);

Create table Pantalla(
idPantalla int AUTO_INCREMENT primary key,
departamento varchar(30) not null
);

Create table Categoria(
idCategoria int AUTO_INCREMENT primary key,
nombre varchar(50) not null,
descripcion varchar(200)
);

Create table Publicacion(
idPublicacion int AUTO_INCREMENT primary key,
usuario varchar(80),
estado tinyint not null default 0,
titulo varchar(200) not null,
fechaInicio date not null,
fechaFin date not null,
mensaje varchar(3000) not null,
imagen varchar(500) default null,

foreign key(usuario) references usuario(username)
);

Create table Mostrar(
publicacion int,
pantalla int,

primary key (publicacion, pantalla),
foreign key(publicacion) references Publicacion(idPublicacion),
foreign key(pantalla) references Pantalla(idPantalla)
);

Create table Categorizar(
publicacion int,
categoria int,

primary key (publicacion, categoria),
foreign key(publicacion) references Publicacion(idPublicacion),
foreign key(categoria) references Categoria(idCategoria)
);

