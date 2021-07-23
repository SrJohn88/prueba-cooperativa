CREATE DATABASE dbasociados;
USE dbasociados;

CREATE TABLE usuarios(
    id          int(255) auto_increment NOT NULL,
    nombre      varchar(60) NOT NULL,
    apellido    varchar(60) NOT NULL,
    email       varchar(60) NOT NULL,
    password    varchar(255) NOT NULL,
    CONSTRAINT pk_usuarios PRIMARY KEY(id),
    CONSTRAINT uq_email UNIQUE(email)
)ENGINE=InnoDb;

CREATE TABLE profesiones(
    id              int(255) auto_increment NOT NULL,
    profesion      varchar(60) NOT NULL,
    CONSTRAINT pk_profesion PRIMARY KEY(id)
)ENGINE=InnoDb;

CREATE TABLE agencias(
    id           int(255) auto_increment NOT NULL,
    agencia      varchar(60) NOT NULL,
    CONSTRAINT pk_agencia PRIMARY KEY(id)
)ENGINE=InnoDb;

CREATE TABLE asociados(
    id              int(255) auto_increment NOT NULL,
    nombre          varchar(60) NOT NULL,
    apellido        varchar(60) NOT NULL,
    direccion       text NOT NULL,
    edad            int NOT NULL,
    dui             varchar(25) NOT NULL,
    nit             varchar(25) NOT NULL,
    profesion_id    int(255) NOT NULL,
    agencia_id      int(255) NOT NULL,
    created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT pk_asociados PRIMARY KEY(id),
    CONSTRAINT pk_asociados_agencia FOREIGN KEY(agencia_id) REFERENCES agencias(id),
    CONSTRAINT pk_asociados_profesion FOREIGN KEY(profesion_id) REFERENCES profesiones(id)
)ENGINE=InnoDb;

CREATE TABLE historial(
    id              int(255) auto_increment NOT NULL,
    fecha           datetime NOT NULL,
    usuario_id      int(255) NOT NULL,
    asociado_id     int(255) NOT NULL,
    campo           varchar(20) NOT NULL,
    antiguo         varchar(60) NOT NULL,
    nuevo           varchar(60) NOT NULL,
    CONSTRAINT pk_historial PRIMARY KEY(id),
    CONSTRAINT pk_historial_usuario FOREIGN KEY(usuario_id) REFERENCES usuarios(id),
    CONSTRAINT pk_historial_asociado FOREIGN KEY(asociado_id) REFERENCES asociados(id)
)ENGINE=InnoDb;

INSERT INTO agencias (agencia) VALUES('Chalatenango');
INSERT INTO agencias (agencia) VALUES('Nueva Concepcion');
INSERT INTO agencias (agencia) VALUES('Concepcion Quezalpeque');
INSERT INTO agencias (agencia) VALUES('La Palma');

INSERT INTO profesiones (profesion) VALUES('Agronomo');
INSERT INTO profesiones (profesion) VALUES('Agricultor');
INSERT INTO profesiones (profesion) VALUES('Ganadero');
INSERT INTO profesiones (profesion) VALUES('Ingeniero Civil');

DELIMITER //
CREATE PROCEDURE saveAsociado
(
    _nombre         varchar(60),
    _apellido       varchar(60),
    _direccion      TEXT,
    _edad           INT,
    _dui            varchar(25),
    _nit            varchar(25),
    _profesion_id   INT,
    _agencia_id     INT,
    _id             INT
)BEGIN
IF _id IS NULL THEN
    INSERT INTO asociados (nombre, apellido, direccion, edad, dui, nit, profesion_id, agencia_id) VALUES (_nombre, _apellido, _direccion, _edad, _dui, _nit, _profesion_id, _agencia_id);
    SET @id = LAST_INSERT_ID();
    SELECT a.id, a.nombre,a.apellido, a.edad, a.direccion, a.dui, a.nit, p.profesion, u.agencia FROM asociados as a inner join profesiones as p on a.profesion_id=p.id INNER join agencias as u on a.agencia_id=u.id WHERE a.id=@id;
ELSEIF _id IS NOT NULL THEN
    UPDATE asociados SET nombre=_nombre, apellido=_apellido, direccion=_direccion, edad=_edad, dui=_dui, nit=_nit, profesion_id=_profesion_id, agencia_id=_agencia_id WHERE id=_id;
    SELECT a.id, a.nombre,a.apellido, a.edad, a.direccion, a.dui, a.nit, p.profesion, u.agencia FROM asociados as a inner join profesiones as p on a.profesion_id=p.id INNER join agencias as u on a.agencia_id=u.id WHERE a.id=_id;
END IF;
END; //
