create database proyecto;
use proyecto;

create table Usuario(
IDUsuario int primary key auto_increment not null,
Nombre varchar (100) not null,
Apellido varchar(100) not null,
Documento varchar(100) not null,
Telefono varchar(100) not null,
Email varchar(100) not null,
Ficha varchar(100) not null,
Usuario  varchar(100) not null,
Contraseña  varchar(100) not null
);
describe Usuario;
create table Equipos(
CodEquipo int primary key auto_increment not null,
Descripcion text,
Usua int unique,
foreign key(Usua) references  Usuario(IDUsuario) on delete cascade
);
create table Administrador(
idAdministrador int primary key auto_increment not null,
Anotaciones varchar(100),
idUsuario int,
codequipo int,
foreign key (idUsuario) references  Usuario(IDUsuario) on delete cascade,
foreign key (codequipo) references  Equipos(CodEquipo) on delete cascade
);


create table prestamo(
Codreser int primary key auto_increment,
idusua int,
idequi int, 
foreign key (idusua) references  Usuario(IDUsuario) on delete cascade,
foreign key (idequi) references  Equipos(CodEquipo) on delete cascade
);
