CREATE DATABASE IF NOT EXISTS proy_change;

USE proy_change;

CREATE TABLE IF NOT EXISTS pais(
    nombrePais char(25) NOT NULL,
    PRIMARY KEY (nombrePais)
);
CREATE TABLE IF NOT EXISTS rol(
    nombreRol char(10) NOT NULL PRIMARY KEY,
    privilegios int NOT NULL DEFAULT 1
);
CREATE TABLE IF NOT EXISTS tematica(
    nombreTem char(20) NOT NULL,
    descr char(40) DEFAULT NULL,
    estado int(1) DEFAULT 0,
    PRIMARY KEY (nombreTem)
);

CREATE TABLE IF NOT EXISTS encuesta(
    nroEnc int AUTO_INCREMENT,
    fecha date DEFAULT CURRENT_DATE,
    PRIMARY KEY (nroEnc)
);

CREATE TABLE IF NOT EXISTS reporte(
    nroRep int AUTO_INCREMENT,
    fechaDesde date DEFAULT NULL,
    fechaHasta date DEFAULT NULL,
    PRIMARY KEY (nroRep)
);

CREATE TABLE IF NOT EXISTS destino(
    nombreDest char(30) NOT NULL,
    descr char(40) DEFAULT NULL,
    estado int(1) DEFAULT 0,
    PRIMARY KEY (nombreDest)
);

CREATE TABLE IF NOT EXISTS provincia(
    nombrePais char(25) NOT NULL,
    nombreProv char(25) NOT NULL,
    PRIMARY KEY (nombrePais,nombreProv),
    FOREIGN KEY (nombrePais) REFERENCES pais (nombrePais)
    ON UPDATE CASCADE
    ON DELETE RESTRICT
);

CREATE TABLE IF NOT EXISTS localidad(
    nombrePais char(25) NOT NULL,
    nombreProv char(25) NOT NULL,
    nombreLoc char(30) NOT NULL,
    FOREIGN KEY (nombrePais,nombreProv) REFERENCES departamento (nombrePais,nombreProv)
    ON UPDATE CASCADE
    ON DELETE RESTRICT,
    PRIMARY KEY (nombrePais,nombreProv,nombreLoc)
);

CREATE TABLE IF NOT EXISTS usuario(
    correo char(40) NOT NULL,
    nombreUsuario char(20) DEFAULT NULL,
    verificado int(1) NOT NULL DEFAULT 0,
    sancion int(3) NOT NULL DEFAULT 0,
    imagen char(39) DEFAULT NULL,
    valoracion int NOT NULL DEFAULT 0,
    nombreRol char(10) DEFAULT 'user',
    PRIMARY KEY (correo),
    FOREIGN KEY (nombreRol) REFERENCES rol (nombreRol)
    ON UPDATE CASCADE
    ON DELETE RESTRICT
);

CREATE TABLE IF NOT EXISTS afiliado(
    correo char(40) NOT NULL,
    fechaN date DEFAULT NULL,
    firmaAnon int(1) DEFAULT 0,
    TFA int(1) DEFAULT 0,
    nombrePais char(25) NOT NULL,
    nombreProv char(25) NOT NULL,
    nombreLoc char(30) NOT NULL,
    FOREIGN KEY (nombrePais,nombreProv,nombreLoc) REFERENCES localidad (nombrePais,nombreProv,nombreLoc)
    ON UPDATE CASCADE
    ON DELETE RESTRICT,
    FOREIGN KEY (correo) REFERENCES usuario (correo)
    ON UPDATE CASCADE
    ON DELETE RESTRICT,
    PRIMARY KEY (correo)
);

CREATE TABLE IF NOT EXISTS peticion(
	nroPet int AUTO_INCREMENT,
    estado int(1) NOT NULL DEFAULT 0,
    objFirmas int NOT NULL DEFAULT 0,
    titulo char(100) DEFAULT NULL,
    cuerpo text DEFAULT NULL,
    fecha date NOT NULL DEFAULT CURRENT_DATE,
    correo char(40) NOT NULL,
    nombreDest char(30) DEFAULT NULL,
    nombrePais char(25) DEFAULT NULL,
    nombreProv char(25) DEFAULT NULL,
    nombreLoc char(30) DEFAULT NULL,
    nroPet_multiple int DEFAULT NULL,
    PRIMARY KEY (nroPet),
    FOREIGN KEY (correo) REFERENCES usuario (correo)
    ON UPDATE CASCADE
    ON DELETE RESTRICT,
    FOREIGN KEY (nombreDest) REFERENCES destino (nombreDest)
    ON UPDATE CASCADE
    ON DELETE SET NULL,
    FOREIGN KEY (nombrePais,nombreProv,nombreLoc) REFERENCES localidad (nombrePais,nombreProv,nombreLoc) 
    ON UPDATE CASCADE
);
    
CREATE TABLE IF NOT EXISTS peticionPlus(
    nroPet int NOT NULL,
    FOREIGN KEY (nroPet) REFERENCES peticion (nroPet)
    ON UPDATE RESTRICT
    ON DELETE CASCADE,
    PRIMARY KEY (nroPet)
);

CREATE TABLE IF NOT EXISTS peticionMultiple(
    nroPet int NOT NULL,
    FOREIGN KEY (nroPet) REFERENCES peticion (nroPet)
    ON UPDATE RESTRICT
    ON DELETE CASCADE,
    PRIMARY KEY (nroPet)
);

ALTER TABLE peticion 
ADD FOREIGN KEY IF NOT EXISTS (nroPet_multiple) REFERENCES peticionMultiple (nroPet);

CREATE TABLE IF NOT EXISTS abarca(
    nroEnc int NOT NULL,
    nombreTem char(20) NOT NULL,
    puestoInt int DEFAULT 0,
    FOREIGN KEY (nroEnc) REFERENCES encuesta (nroEnc)
    ON UPDATE CASCADE
    ON DELETE RESTRICT,
    FOREIGN KEY (nombreTem) REFERENCES tematica (nombreTem)
    ON UPDATE CASCADE
    ON DELETE RESTRICT,
    PRIMARY KEY (nroEnc,nombreTem)
);
    
CREATE TABLE IF NOT EXISTS interesa(
    correo char(40) NOT NULL,
    nombreTem char(20) NOT NULL,
    FOREIGN KEY (correo) REFERENCES usuario (correo)
    ON UPDATE CASCADE
    ON DELETE RESTRICT,
    FOREIGN KEY (nombreTem) REFERENCES tematica (nombreTem)
    ON UPDATE CASCADE
    ON DELETE RESTRICT,
    PRIMARY KEY (correo,nombreTem)
);
    
CREATE TABLE IF NOT EXISTS firma(
    idFirma int not NULL AUTO_INCREMENT PRIMARY KEY,
    nroPet int NOT NULL,
    correo char(40) NOT NULL DEFAULT '',
    ip char(45) NOT NULL DEFAULT '0.0.0.0',
    comentario text(50) DEFAULT NULL,
    anon int(1) NOT NULL DEFAULT 0,
    fecha date NOT NULL DEFAULT CURRENT_DATE,
    FOREIGN KEY (nroPet) REFERENCES peticion (nroPet)
    ON UPDATE RESTRICT
    ON DELETE RESTRICT,
    UNIQUE (nroPet,correo,ip)
    -- FOREIGN KEY (correo) REFERENCES usuario (correo)
    -- ON UPDATE CASCADE
    -- ON DELETE RESTRICT,
    -- PRIMARY KEY (nroPet,correo)
);

CREATE TABLE IF NOT EXISTS imagen(
    nroPet int NOT NULL,
    nroImg int NOT NULL,
    extension char(5) NOT NULL
    FOREIGN KEY (nroPet) REFERENCES peticion (nroPet)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
    PRIMARY KEY (nroPet,nroImg)
);

CREATE TABLE IF NOT EXISTS trata(
    nroPet int NOT NULL,
    nombreTem char(20) NOT NULL,
    FOREIGN KEY (nroPet) REFERENCES peticion (nroPet)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
    FOREIGN KEY (nombreTem) REFERENCES tematica (nombreTem)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
    PRIMARY KEY (nroPet,nombreTem)
);
CREATE VIEW peticion_objetivo AS
SELECT 
    p.nroPet AS numero,
    p.estado,
    p.objFirmas AS objetivo,
    COUNT(f.nroPet) AS firmas
FROM 
    peticion p
LEFT JOIN 
    firma f ON p.nroPet = f.nroPet
GROUP BY 
    p.nroPet, p.estado, p.objFirmas;



CREATE VIEW informe AS
SELECT 
    mes.mes,
    COALESCE(pets.cantidadPeticiones, 0) AS cantidadPeticiones,
    COALESCE(bajas.cantidadBajas, 0) AS cantidadBajas,
    COALESCE(admitidas.cantidadAdmitidas, 0) AS cantidadAdmitidas,
    COALESCE(exitosas.cantidadExitosas, 0) AS cantidadExitosas,
    COALESCE(noAdmitidas.cantidadNoAdmitidas, 0) AS cantidadNoAdmitidas,
    COALESCE(usuarios.cantidadUsuariosNuevos, 0) AS cantidadUsuariosNuevos,
    COALESCE(firmas.cantidadFirmas, 0) AS cantidadFirmas,
    COALESCE(registradas.cantidadRegistradas, 0) AS cantidadRegistradas,
    COALESCE(noRegistradas.cantidadNoRegistradas, 0) AS cantidadNoRegistradas,
    COALESCE(publicas.cantidadPublicas, 0) AS cantidadPublicas,
    COALESCE(anonimas.cantidadAnonimas, 0) AS cantidadAnonimas
FROM 
    (
        -- Subconsulta para generar la lista de meses
        SELECT DISTINCT DATE_FORMAT(fecha, "%Y-%m") AS mes
        FROM peticion
        UNION
        SELECT DISTINCT DATE_FORMAT(fechaCreacion, "%Y-%m") AS mes
        FROM usuario
        UNION
        SELECT DISTINCT DATE_FORMAT(fecha, "%Y-%m") AS mes
        FROM firma
    ) AS mes
LEFT JOIN 
    (
        -- Contar peticiones
        SELECT 
            DATE_FORMAT(fecha, "%Y-%m") AS mes,
            COUNT(nroPet) AS cantidadPeticiones
        FROM peticion 
        GROUP BY mes
    ) pets ON mes.mes = pets.mes
LEFT JOIN 
    (
        -- Contar bajas
        SELECT 
            DATE_FORMAT(fecha, "%Y-%m") AS mes,
            COUNT(nroPet) AS cantidadBajas
        FROM peticion 
        WHERE estado = -2
        GROUP BY mes
    ) bajas ON mes.mes = bajas.mes
LEFT JOIN 
    (
        -- Contar admitidas
        SELECT 
            DATE_FORMAT(fecha, "%Y-%m") AS mes,
            COUNT(nroPet) AS cantidadAdmitidas
        FROM peticion 
        WHERE estado >= 0
        GROUP BY mes
    ) admitidas ON mes.mes = admitidas.mes
LEFT JOIN 
    (
        -- Contar no admitidas
        SELECT 
            DATE_FORMAT(fecha, "%Y-%m") AS mes,
            COUNT(nroPet) AS cantidadNoAdmitidas
        FROM peticion 
        WHERE estado = -1
        GROUP BY mes
    ) noAdmitidas ON mes.mes = noAdmitidas.mes
LEFT JOIN 
    (
        -- Contar exitosas
        SELECT 
            DATE_FORMAT(fecha, "%Y-%m") AS mes,
            COUNT(nroPet) AS cantidadExitosas
        FROM peticion 
        WHERE estado >= 1
        GROUP BY mes
    ) exitosas ON mes.mes = exitosas.mes
LEFT JOIN 
    (
        -- Contar usuarios nuevos
        SELECT 
            DATE_FORMAT(fechaCreacion, "%Y-%m") AS mes,
            COUNT(correo) AS cantidadUsuariosNuevos
        FROM usuario
        GROUP BY mes
    ) usuarios ON mes.mes = usuarios.mes
LEFT JOIN 
    (
        -- Contar firmas
        SELECT 
            DATE_FORMAT(fecha, "%Y-%m") AS mes,
            COUNT(idFirma) AS cantidadFirmas
        FROM firma
        GROUP BY mes
    ) firmas ON mes.mes = firmas.mes
LEFT JOIN 
    (
        -- Contar firmas registradas
        SELECT 
            DATE_FORMAT(fecha, "%Y-%m") AS mes,
            COUNT(idFirma) AS cantidadRegistradas
        FROM firma
        WHERE correo!='' AND ip='0.0.0.0'
        GROUP BY mes
    ) registradas ON mes.mes = registradas.mes
LEFT JOIN 
    (
        -- Contar firmas no registradas
        SELECT 
            DATE_FORMAT(fecha, "%Y-%m") AS mes,
            COUNT(idFirma) AS cantidadNoRegistradas
        FROM firma
        WHERE correo='' AND ip!='0.0.0.0'
        GROUP BY mes
    ) noRegistradas ON mes.mes = noRegistradas.mes
LEFT JOIN 
    (
        -- Contar firmas publicas
        SELECT 
            DATE_FORMAT(fecha, "%Y-%m") AS mes,
            COUNT(idFirma) AS cantidadPublicas
        FROM firma
        WHERE anon=0
        GROUP BY mes
    ) publicas ON mes.mes = publicas.mes
LEFT JOIN 
    (
        -- Contar firmas anonimas
        SELECT 
            DATE_FORMAT(fecha, "%Y-%m") AS mes,
            COUNT(idFirma) AS cantidadAnonimas
        FROM firma
        WHERE anon=1
        GROUP BY mes
    ) anonimas ON mes.mes = anonimas.mes;

-- Inserciones NECESARIAS

INSERT INTO `rol` (`nombreRol`, `privilegios`) VALUES
('admin', 10),
('moderador', 5),
('user', 1);

-- Inserciones para pruebas en local

INSERT INTO `tematica` (`nombreTem`, `descr`, `estado`) VALUES
('economia', 'dolar, peso, inflacion', 1),
('impuestos', 'tarifas, boletas, iva', 1),
('inseguridad', 'robos, miedo, delincuentes', 1),
('medio ambiente', 'hojas, poda, riego, suciedad', 1),
('obras publicas', 'veredas, calles, alumbrado', 1),
('prueba', '', 0),
('religion', '', 0);

INSERT INTO `destino` (`nombreDest`, `descr`, `estado`) VALUES
('gobierno de san juan', '', 1),
('intendente de chimbas', '', 0),
('javier milei', 'presidente de la republica arg', 1),
('javueb maluco', '', 0),
('min de salud', 'enfermedades, salud publica, hospitales', 1),
('romina rosas', 'Intendente de caucete 2022-2026', 1),
('si funciono', '', 1);


INSERT INTO `pais` (`nombrePais`) VALUES
('argentina'),
('bolivia'),
('brasil'),
('chile'),
('colombia'),
('costa rica'),
('cuba'),
('dominicana'),
('ecuador'),
('el salvador'),
('guatemala'),
('honduras'),
('méxico'),
('nicaragua'),
('panamá'),
('paraguay'),
('perú'),
('puerto rico'),
('uruguay'),
('venezuela');


INSERT INTO `provincia` (`nombrePais`, `nombreProv`) VALUES
('argentina', 'buenos aires'),
('argentina', 'catamarca'),
('argentina', 'córdoba'),
('argentina', 'entre ríos'),
('argentina', 'la rioja'),
('argentina', 'mendoza'),
('argentina', 'san juan'),
('argentina', 'san luis'),
('argentina', 'santa fe'),
('argentina', 'tucumán'),
('bolivia', 'cochabamba'),
('bolivia', 'la paz'),
('bolivia', 'oruro'),
('bolivia', 'potosí'),
('bolivia', 'santa cruz'),
('brasil', 'bahia'),
('brasil', 'minas gerais'),
('brasil', 'paraná'),
('brasil', 'rio de janeiro'),
('brasil', 'são paulo'),
('chile', 'antofagasta'),
('chile', 'atacama'),
('chile', 'biobío'),
('chile', 'santiago'),
('chile', 'valparaíso'),
('colombia', 'antioquia'),
('colombia', 'bogotá'),
('colombia', 'cundinamarca'),
('colombia', 'santander'),
('colombia', 'valle del cauca'),
('costa rica', 'alajuela'),
('costa rica', 'cartago'),
('costa rica', 'heredia'),
('costa rica', 'puntarenas'),
('costa rica', 'san josé'),
('cuba', 'camagüey'),
('cuba', 'holguín'),
('cuba', 'la habana'),
('cuba', 'matanzas'),
('cuba', 'santiago de cuba'),
('dominicana', 'la vega'),
('dominicana', 'puerto plata'),
('dominicana', 'san cristóbal'),
('dominicana', 'santiago'),
('dominicana', 'santo domingo'),
('ecuador', 'azuay'),
('ecuador', 'esmeraldas'),
('ecuador', 'guayas'),
('ecuador', 'manabí'),
('ecuador', 'pichincha'),
('el salvador', 'la libertad'),
('el salvador', 'san salvador'),
('el salvador', 'santa ana'),
('el salvador', 'sonsonate'),
('el salvador', 'usulután'),
('guatemala', 'escuintla'),
('guatemala', 'guatemala'),
('guatemala', 'quetzaltenango'),
('guatemala', 'quiché'),
('guatemala', 'sacatepéquez'),
('honduras', 'atlántida'),
('honduras', 'choluteca'),
('honduras', 'cortés'),
('honduras', 'francisco morazán'),
('honduras', 'yoro'),
('méxico', 'ciudad de méxico'),
('méxico', 'jalisco'),
('méxico', 'nuevo león'),
('méxico', 'puebla'),
('méxico', 'veracruz'),
('nicaragua', 'chontales'),
('nicaragua', 'granada'),
('nicaragua', 'león'),
('nicaragua', 'managua'),
('nicaragua', 'matagalpa'),
('panamá', 'chiriquí'),
('panamá', 'coclé'),
('panamá', 'colón'),
('panamá', 'panamá'),
('panamá', 'veraguas'),
('paraguay', 'alto paraguay'),
('paraguay', 'asunción'),
('paraguay', 'central'),
('paraguay', 'cordillera'),
('paraguay', 'itapúa'),
('perú', 'arequipa'),
('perú', 'cusco'),
('perú', 'la libertad'),
('perú', 'lima'),
('perú', 'piura'),
('puerto rico', 'bayamón'),
('puerto rico', 'caguas'),
('puerto rico', 'mayagüez'),
('puerto rico', 'ponce'),
('puerto rico', 'san juan'),
('uruguay', 'canelones'),
('uruguay', 'colonia'),
('uruguay', 'maldonado'),
('uruguay', 'montevideo'),
('uruguay', 'salto'),
('venezuela', 'bolívar'),
('venezuela', 'caracas'),
('venezuela', 'lara'),
('venezuela', 'miranda'),
('venezuela', 'zulia');

INSERT INTO `localidad` (`nombrePais`, `nombreProv`, `nombreLoc`, `estado`) VALUES
('argentina', 'san juan', 'caucete', 1),
('argentina', 'san juan', 'difunta correa', 1),
('argentina', 'san juan', 'san juan', 1),
('argentina', 'san juan', 'vallecito', 0),
('argentina', 'san juan', 'villa krause', 0);

-- CREATE USER 'usuario'@'localhost' IDENTIFIED BY 'commonuser';