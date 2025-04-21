create database proyecto;
use proyecto;

CREATE TABLE Usuario (
    Idusu int primary key auto_increment not null,
    Nombreusu VARCHAR(50) NOT NULL,
    Apellidousu varchar(100) NOT NULL,
    Usuario  varchar(100) NOT NULL,
    Identificacionusu enum('C.C','T.I','C.E','P.P.T') NOT NULL,
	Documentousu varchar(100) NOT NULL,
	Telefonousu varchar(100) NOT NULL,
	Emailusu varchar(100) NOT NULL,
	Fichausu varchar(100) NOT NULL,
    Contraseña VARCHAR(255) NOT NULL
);
describe Usuario;

CREATE TABLE Instructores (
    Idins INT AUTO_INCREMENT PRIMARY KEY,
    Nombreins VARCHAR(50) NOT NULL,
    Apellidoins varchar(100) NOT NULL,
	Identificacionins enum('C.C','C.E','P.P.T') NOT NULL,
	Documentoins varchar(100) NOT NULL,
	Emailins varchar(100) NOT NULL,
	Usuario varchar(100) NOT NULL,
    Contraseña VARCHAR(255) NOT NULL
);


CREATE TABLE Administradores (
    Idad INT AUTO_INCREMENT PRIMARY KEY,
    Nombread VARCHAR(50) NOT NULL,
    Apellidoad varchar(100) not null,
	Identificacionad enum('C.C','C.E','P.P.T') NOT NULL,
	Documentoad varchar(100) NOT NULL,
	Emailad varchar(100) NOT NULL,
	Usuario  varchar(100) NOT NULL,
    Contraseña VARCHAR(255) NOT NULL
);

create table Tabletas(
CodEquipo int primary key auto_increment not null,
Placa text,
Descripcion text,
Tableta enum('PEN TABLET PTH-65','PEN TABLET PTH-850','Wacom One') NOT NULL,
Usua int unique
);

CREATE TABLE Reservas (
    IDReserva INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    IDUsuario INT,
    CodEquipo INT,
    Fichausu VARCHAR(100) NOT NULL,
    FechaReserva TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (IDUsuario) REFERENCES Usuario(Idusu),
    FOREIGN KEY (CodEquipo) REFERENCES Tabletas(CodEquipo)
	ON DELETE SET NULL);
