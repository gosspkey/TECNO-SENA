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


CREATE TABLE Reservas (
    IDReserva INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    IDUsuario INT NOT NULL,
    CodTableta INT NULL,
    CodPortatil INT NULL,
    CodCamara INT NULL,
    CodLuces INT NULL,
    CodProyector INT NULL,
    CodTripode INT NULL,
    CodSonido INT NULL,
    Fichausu VARCHAR(100) NOT NULL,
    FechaReserva TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (IDUsuario) REFERENCES Usuario(Idusu) ON DELETE CASCADE
);

ALTER TABLE Reservas 
ADD CONSTRAINT fk_tableta FOREIGN KEY (CodTableta) REFERENCES Tabletas(CodEquipo) ON DELETE SET NULL,
ADD CONSTRAINT fk_portatil FOREIGN KEY (CodPortatil) REFERENCES Portatil(CodEquipo) ON DELETE SET NULL,
ADD CONSTRAINT fk_camara FOREIGN KEY (CodCamara) REFERENCES Camaras(CodEquipo) ON DELETE SET NULL,
ADD CONSTRAINT fk_luces FOREIGN KEY (CodLuces) REFERENCES Luces(CodEquipo) ON DELETE SET NULL,
ADD CONSTRAINT fk_proyector FOREIGN KEY (CodProyector) REFERENCES Proyectores(CodEquipo) ON DELETE SET NULL,
ADD CONSTRAINT fk_tripode FOREIGN KEY (CodTripode) REFERENCES Tripodes(CodEquipo) ON DELETE SET NULL,
ADD CONSTRAINT fk_sonido FOREIGN KEY (CodSonido) REFERENCES Sonido(CodEquipo) ON DELETE SET NULL;


CREATE TABLE Reservasins (
    IDReserva INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    Idins INT NOT NULL, -- Relacionado con la tabla Instructores
    CodTableta INT NULL,
    CodPortatil INT NULL,
    CodCamara INT NULL,
    CodLuces INT NULL,
    CodProyector INT NULL,
    CodTripode INT NULL,
    CodSonido INT NULL,
    FechaReserva TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (Idins) REFERENCES Instructores(Idins) ON DELETE CASCADE
);

ALTER TABLE Reservasins
ADD CONSTRAINT fk_tableta_inst FOREIGN KEY (CodTableta) REFERENCES Tabletas(CodEquipo) ON DELETE SET NULL,
ADD CONSTRAINT fk_portatil_inst FOREIGN KEY (CodPortatil) REFERENCES Portatil(CodEquipo) ON DELETE SET NULL,
ADD CONSTRAINT fk_camara_inst FOREIGN KEY (CodCamara) REFERENCES Camaras(CodEquipo) ON DELETE SET NULL,
ADD CONSTRAINT fk_luces_inst FOREIGN KEY (CodLuces) REFERENCES Luces(CodEquipo) ON DELETE SET NULL,
ADD CONSTRAINT fk_proyector_inst FOREIGN KEY (CodProyector) REFERENCES Proyectores(CodEquipo) ON DELETE SET NULL,
ADD CONSTRAINT fk_tripode_inst FOREIGN KEY (CodTripode) REFERENCES Tripodes(CodEquipo) ON DELETE SET NULL,
ADD CONSTRAINT fk_sonido_inst FOREIGN KEY (CodSonido) REFERENCES Sonido(CodEquipo) ON DELETE SET NULL;


CREATE TABLE Portatil (
    CodEquipo INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    Placa TEXT,
    Descripcion TEXT,
    Portatil ENUM('HP ProBook') NOT NULL,
    Usua INT UNIQUE,
    IDReserva INT NULL,
    FOREIGN KEY (IDReserva) REFERENCES Reservas(IDReserva) ON DELETE SET NULL
);
create table Tabletas(
CodEquipo int primary key auto_increment not null,
Placa text,
Descripcion text,
Tableta enum('PEN TABLET PTH-65','PEN TABLET PTH-850','Wacom One') NOT NULL,
Usua int unique,
IDReserva INT NULL,
FOREIGN KEY (IDReserva) REFERENCES Reservas(IDReserva) ON DELETE SET NULL
);
create table Camaras(
CodEquipo int primary key auto_increment not null,
Placa text,
Descripcion text,
Camaras enum('SONY','NIKON','Canon T3','Canon T5','Panasonic') NOT NULL,
Usua int unique,
IDReserva INT NULL,
    FOREIGN KEY (IDReserva) REFERENCES Reservas(IDReserva) ON DELETE SET NULL
);
create table Luces(
CodEquipo int primary key auto_increment not null,
Placa text,
Descripcion text,
Luces enum('Neewer','ARRI') NOT NULL,
Usua int unique,
IDReserva INT NULL,
    FOREIGN KEY (IDReserva) REFERENCES Reservas(IDReserva) ON DELETE SET NULL
);
create table Proyectores(
CodEquipo int primary key auto_increment not null,
Placa text,
Descripcion text,
Proyectores enum('Vivitek','Epson Pro','Epson Powerlite','Epson PowerlitePro') NOT NULL,
Usua int unique,
IDReserva INT NULL,
    FOREIGN KEY (IDReserva) REFERENCES Reservas(IDReserva) ON DELETE SET NULL
);
create table Tripodes(
CodEquipo int primary key auto_increment not null,
Placa text,
Descripcion text,
Tripodes enum('Manfrotto') NOT NULL,
Usua int unique,
IDReserva INT NULL,
    FOREIGN KEY (IDReserva) REFERENCES Reservas(IDReserva) ON DELETE SET NULL
);
create table Sonido(
CodEquipo int primary key auto_increment not null,
Placa text,
Descripcion text,
Sonido enum('BEHRINGER','PRO DJ') NOT NULL,
Usua int unique,
IDReserva INT NULL,
    FOREIGN KEY (IDReserva) REFERENCES Reservas(IDReserva) ON DELETE SET NULL
);
