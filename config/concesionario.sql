CREATE DATABASE concesionario;

USE concesionario;

CREATE SEQUENCE Rol_Auto
    START 101
    INCREMENT 1;
CREATE TABLE Rol(
	ID INT DEFAULT nextval('Rol_Auto'),
	Rol varchar(30) NOT NULL,
	PRIMARY KEY (ID)
);
INSERT INTO Rol (Rol) VALUES ('Administrador');

CREATE SEQUENCE Cargo_Auto
    START 201
    INCREMENT 1;
CREATE TABLE Cargo(
	ID INT DEFAULT nextval('Cargo_Auto'),
	Cargo varchar(20) NOT NULL,
    PRIMARY KEY (ID)
);
INSERT INTO Cargo (Cargo) VALUES ('Gerente');
INSERT INTO Cargo (Cargo) VALUES ('Empleado');

CREATE SEQUENCE Ciudad_Auto
    START 801
    INCREMENT 1;
CREATE TABLE Ciudad_Residencia(
	ID INT DEFAULT nextval('Ciudad_Auto'),
	Ciudad varchar(25) NOT NULL,
    PRIMARY KEY (ID)
);

INSERT INTO Ciudad_Residencia (Ciudad) VALUES ('Barranquilla');
INSERT INTO Ciudad_Residencia (Ciudad) VALUES ('Cali');
INSERT INTO Ciudad_Residencia (Ciudad) VALUES ('Cartagena');
INSERT INTO Ciudad_Residencia (Ciudad) VALUES ('Leticia');
INSERT INTO Ciudad_Residencia (Ciudad) VALUES ('Manizales');
INSERT INTO Ciudad_Residencia (Ciudad) VALUES ('Medellin');
INSERT INTO Ciudad_Residencia (Ciudad) VALUES ('Pasto');
INSERT INTO Ciudad_Residencia (Ciudad) VALUES ('Popayan');
INSERT INTO Ciudad_Residencia (Ciudad) VALUES ('Riohacha');
INSERT INTO Ciudad_Residencia (Ciudad) VALUES ('Sincelejo');
INSERT INTO Ciudad_Residencia (Ciudad) VALUES ('Villavicencio');

CREATE SEQUENCE Sucursal_Auto
    START 301
    INCREMENT 1;
CREATE TABLE Sucursal(
	ID INT DEFAULT nextval('Sucursal_Auto'),
	NombreSucursal varchar(50) NOT NULL,
    CiudadSucursal INT, 
    PRIMARY KEY (ID),
    FOREIGN KEY (CiudadSucursal) REFERENCES Ciudad_Residencia(ID) ON DELETE SET NULL ON UPDATE CASCADE
);
INSERT INTO Sucursal (nombresucursal, CiudadSucursal) VALUES ('Sucursal de Barranquilla', 801);
INSERT INTO Sucursal (nombresucursal, CiudadSucursal) VALUES ('Sucursal de Cali', 802);
INSERT INTO Sucursal (nombresucursal, CiudadSucursal) VALUES ('Sucursal de Cartagena', 803);
INSERT INTO Sucursal (nombresucursal, CiudadSucursal) VALUES ('Sucursal de Leticia', 804);
INSERT INTO Sucursal (nombresucursal, CiudadSucursal) VALUES ('Sucursal de Manizales', 805);
INSERT INTO Sucursal (nombresucursal, CiudadSucursal) VALUES ('Sucursal de Medellín', 806);
INSERT INTO Sucursal (nombresucursal, CiudadSucursal) VALUES ('Sucursal de Pasto', 807);
INSERT INTO Sucursal (nombresucursal, CiudadSucursal) VALUES ('Sucursal de Popayan', 808);
INSERT INTO Sucursal (nombresucursal, CiudadSucursal) VALUES ('Sucursal de Riohacha', 809);
INSERT INTO Sucursal (nombresucursal, CiudadSucursal) VALUES ('Sucursal de Sincelejo', 810);
INSERT INTO Sucursal (nombresucursal, CiudadSucursal) VALUES ('Sucursal de Villavicencio', 811);

/*Se inserta solo el nombre porque después de creado el empleado se hará un UPDATE para el ID_Gerente*/

CREATE SEQUENCE Empleado_Auto
    START 1001
    INCREMENT 1;
CREATE TABLE Empleado(
	Codigo INT DEFAULT nextval('Empleado_Auto'),
	ID_cargo INT,
	Identificacion INT NOT NULL,
	NombreEmp varchar(35) NOT NULL,
	Fecha_nacimiento DATE NOT NULL,
	Fecha_ingreso DATE NOT NULL,
	Salario FLOAT NOT NULL,
    ID_Sucursal INT,
    PRIMARY KEY (Codigo),
	FOREIGN KEY(ID_cargo) REFERENCES Cargo(ID) ON DELETE SET NULL ON UPDATE CASCADE
);
/*Se utiliza SET NULL Y CASCADE para que cuando se elimine una fila en la tabla Cargo su valor en
la tabla Empleado se establecerá en NULL. Así mismo, si se actualiza algún dato en la tabla Cargo
se actualizará automáticamente en la tabla Empleado*/

INSERT INTO Empleado (ID_cargo, Identificacion, NombreEmp, Fecha_nacimiento, Fecha_ingreso, Salario, ID_Sucursal) VALUES (201, 1000472996, 'Karen Garzon', '2002-10-17', '2023-06-20', 2500000, 301);
INSERT INTO Empleado (ID_cargo, Identificacion, NombreEmp, Fecha_nacimiento, Fecha_ingreso, Salario, ID_Sucursal) VALUES (201, 5958329, 'Carlos Rodriguez', '1995-03-21', '2018-07-10', 2800000, 302);
INSERT INTO Empleado (ID_cargo, Identificacion, NombreEmp, Fecha_nacimiento, Fecha_ingreso, Salario, ID_Sucursal) VALUES (201, 65792946, 'Laura Hernandez', '1988-12-05', '2017-08-15', 3000000, 303);
INSERT INTO Empleado (ID_cargo, Identificacion, NombreEmp, Fecha_nacimiento, Fecha_ingreso, Salario, ID_Sucursal) VALUES (201, 5478213, 'Juan Perez', '1990-06-12', '2023-09-25', 2600000, 304);
INSERT INTO Empleado (ID_cargo, Identificacion, NombreEmp, Fecha_nacimiento, Fecha_ingreso, Salario, ID_Sucursal) VALUES (201, 42578962, 'Maria Gutierrez', '1987-09-28', '2021-10-05', 2700000, 305);
INSERT INTO Empleado (ID_cargo, Identificacion, NombreEmp, Fecha_nacimiento, Fecha_ingreso, Salario, ID_Sucursal) VALUES (201, 9458762, 'Andres Martinez', '1998-02-14', '2022-11-12', 2900000, 306);
INSERT INTO Empleado (ID_cargo, Identificacion, NombreEmp, Fecha_nacimiento, Fecha_ingreso, Salario, ID_Sucursal) VALUES (201, 7985642, 'Gabriel Ramirez', '1993-08-08', '2023-12-01', 2800000, 307);
INSERT INTO Empleado (ID_cargo, Identificacion, NombreEmp, Fecha_nacimiento, Fecha_ingreso, Salario, ID_Sucursal) VALUES (201, 8456324, 'Paola Gonzalez', '1985-05-15', '2022-01-07', 3000000, 308);
INSERT INTO Empleado (ID_cargo, Identificacion, NombreEmp, Fecha_nacimiento, Fecha_ingreso, Salario, ID_Sucursal) VALUES (201, 1000378956, 'Ricardo Vargas', '1996-11-20', '2020-02-15', 2600000, 309);
INSERT INTO Empleado (ID_cargo, Identificacion, NombreEmp, Fecha_nacimiento, Fecha_ingreso, Salario, ID_Sucursal) VALUES (201, 9856320, 'Camila Lopez', '1989-04-02', '2019-03-22', 2700000, 310);
INSERT INTO Empleado (ID_cargo, Identificacion, NombreEmp, Fecha_nacimiento, Fecha_ingreso, Salario, ID_Sucursal) VALUES (201, 124501, 'Alejandro Castro', '1994-01-10', '2015-04-30', 2900000, 311);

/*UPDATE Sucursal SET ID_Gerente = 1001 WHERE nombresucursal = 'Sucursal de Barranquilla';
UPDATE Sucursal SET ID_Gerente = 1002 WHERE nombresucursal = 'Sucursal de Cali';
UPDATE Sucursal SET ID_Gerente = 1003 WHERE nombresucursal = 'Sucursal de Cartagena';
UPDATE Sucursal SET ID_Gerente = 1004 WHERE nombresucursal = 'Sucursal de Leticia';
UPDATE Sucursal SET ID_Gerente = 1005 WHERE nombresucursal = 'Sucursal de Manizales';
UPDATE Sucursal SET ID_Gerente = 1006 WHERE nombresucursal = 'Sucursal de Medellín';
UPDATE Sucursal SET ID_Gerente = 1007 WHERE nombresucursal = 'Sucursal de Pasto';
UPDATE Sucursal SET ID_Gerente = 1008 WHERE nombresucursal = 'Sucursal de Popayan';
UPDATE Sucursal SET ID_Gerente = 1009 WHERE nombresucursal = 'Sucursal de Riohacha';
UPDATE Sucursal SET ID_Gerente = 1010 WHERE nombresucursal = 'Sucursal de Sincelejo';
UPDATE Sucursal SET ID_Gerente = 1011 WHERE nombresucursal = 'Sucursal de Villavicencio';*/

CREATE TABLE Telefono_Emp(
	ID_Empleado INT NOT NULL,
	Telefono INT,
    PRIMARY KEY (ID_Empleado),
	FOREIGN KEY(ID_Empleado) REFERENCES Empleado(Codigo) ON DELETE CASCADE ON UPDATE CASCADE
);

INSERT INTO Telefono_Emp (ID_Empleado, Telefono) VALUES (1001, 3142101);

/*ALTER TABLE Sucursal ADD CONSTRAINT FK_Empleado FOREIGN KEY (ID_Gerente) REFERENCES Empleado(Codigo) ON UPDATE SET NULL ON DELETE SET NULL;*/
ALTER TABLE Empleado ADD CONSTRAINT FK_Sucursal FOREIGN KEY (ID_Sucursal) REFERENCES Sucursal(ID) ON UPDATE SET NULL ON DELETE SET NULL;

CREATE SEQUENCE Linea_Auto
    START 401
    INCREMENT 1;
CREATE TABLE Linea(
	ID INT DEFAULT nextval('Linea_Auto'),
	Linea varchar(20) NOT NULL,
    PRIMARY KEY (ID)
);
INSERT INTO Linea (Linea) VALUES ('Spark');

CREATE SEQUENCE Usuario_Auto
    START 7001
    INCREMENT 1;
CREATE TABLE Usuario(
	ID INT DEFAULT nextval('Usuario_Auto'),
	ID_empleado INT NOT NULL,
	Username VARCHAR(15),
	Pass VARCHAR(15),
	ID_Rol INT,
    PRIMARY KEY (ID),
	FOREIGN KEY(ID_empleado) REFERENCES Empleado(Codigo) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY(ID_Rol) REFERENCES Rol(ID) ON DELETE SET NULL ON UPDATE CASCADE
);
INSERT INTO Usuario (ID_empleado, Username, Pass, ID_Rol) VALUES (1001, 'kdgarzong', 'ab123', 101);

CREATE SEQUENCE Tipo_Auto
    START 501
    INCREMENT 1;
CREATE TABLE Tipo(
	ID INT DEFAULT nextval('Tipo_Auto'),
	Tipo varchar(20) NOT NULL,
    PRIMARY KEY (ID)
);
INSERT INTO Tipo (Tipo) VALUES ('Automóvil');
INSERT INTO Tipo (Tipo) VALUES ('Camión');
INSERT INTO Tipo (Tipo) VALUES ('Camioneta');

CREATE SEQUENCE Color_Auto
    START 601
    INCREMENT 1;
CREATE TABLE Color(
	ID INT DEFAULT nextval('Color_Auto'),
	Color varchar(15) NOT NULL,
    PRIMARY KEY (ID)
);
INSERT INTO Color (Color) VALUES ('Amarillo');
INSERT INTO Color (Color) VALUES ('Azul');
INSERT INTO Color (Color) VALUES ('Beige');
INSERT INTO Color (Color) VALUES ('Blanco');
INSERT INTO Color (Color) VALUES ('Gris plateado');
INSERT INTO Color (Color) VALUES ('Gris oscuro');
INSERT INTO Color (Color) VALUES ('Marrón');
INSERT INTO Color (Color) VALUES ('Negro');
INSERT INTO Color (Color) VALUES ('Rojo');
INSERT INTO Color (Color) VALUES ('Verde');

CREATE SEQUENCE Marca_Auto
    START 701
    INCREMENT 1;
CREATE TABLE Marca(
	ID INT DEFAULT nextval('Marca_Auto'),
	Marca varchar(50) NOT NULL,
    PRIMARY KEY (ID)
);
INSERT INTO Marca (Marca) VALUES ('Audi');
INSERT INTO Marca (Marca) VALUES ('BMW');
INSERT INTO Marca (Marca) VALUES ('Chevrolet');
INSERT INTO Marca (Marca) VALUES ('Ford');
INSERT INTO Marca (Marca) VALUES ('Honda');
INSERT INTO Marca (Marca) VALUES ('Hyundai');
INSERT INTO Marca (Marca) VALUES ('Mercedes-Benz');
INSERT INTO Marca (Marca) VALUES ('Nissan');
INSERT INTO Marca (Marca) VALUES ('Toyota');
INSERT INTO Marca (Marca) VALUES ('Volkswagen');

CREATE TABLE Automotor(
	Numero_Chasis VARCHAR(20) NOT NULL,
	ID_Color INT,
	ID_Linea INT,
	ID_Tipo INT,
	ID_Marca INT,
	Modelo INT NOT NULL,
	Identificacion_interna VARCHAR(10),
	Placa VARCHAR(8),
    SucursalDondeEsta INT,
    PRIMARY KEY (Numero_Chasis),
	FOREIGN KEY(ID_Color) REFERENCES Color(ID) ON DELETE SET NULL ON UPDATE CASCADE,
	FOREIGN KEY(ID_Linea) REFERENCES Linea(ID) ON DELETE SET NULL ON UPDATE CASCADE,
	FOREIGN KEY(ID_Tipo) REFERENCES Tipo(ID) ON DELETE SET NULL ON UPDATE CASCADE,
	FOREIGN KEY(ID_Marca) REFERENCES Marca(ID) ON DELETE SET NULL ON UPDATE CASCADE,
    FOREIGN KEY(SucursalDondeEsta) REFERENCES Sucursal(ID) ON DELETE SET NULL ON UPDATE CASCADE
);
INSERT INTO Automotor (Numero_Chasis, ID_Color, ID_Linea, ID_Tipo, ID_Marca, Modelo, Identificacion_interna, Placa, SucursalDondeEsta) 
	VALUES ('1HGCM82633A123456', 601, 401, 501, 701, 2020, 'ABC100', NULL, 303);


CREATE TABLE Cliente(
	Identificacion INT NOT NULL,
	ID_Ciudad INT,
	Nombre varchar(60) NOT NULL,
	Fecha_Registro DATE NOT NULL,
    ID_Sucursal INT,
    PRIMARY KEY (Identificacion),
	FOREIGN KEY(ID_Ciudad) REFERENCES Ciudad_Residencia(ID) ON DELETE SET NULL ON UPDATE CASCADE,
    FOREIGN KEY(ID_Sucursal) REFERENCES Sucursal(ID) ON DELETE SET NULL ON UPDATE CASCADE
);
INSERT INTO Cliente (Identificacion, ID_Ciudad, Nombre, Fecha_Registro, ID_Sucursal) VALUES (1000472996, 801, 'Daniel Caicedo', '2023-11-03', 305);

CREATE TABLE Telefono_Clie(
	ID_Cliente INT NOT NULL,
	Telefono INT NOT NULL,
    PRIMARY KEY (ID_Cliente),
	FOREIGN KEY(ID_Cliente) REFERENCES Cliente(Identificacion) ON DELETE CASCADE ON UPDATE CASCADE
);
INSERT INTO Telefono_Clie (ID_Cliente, Telefono) VALUES (1000472996, 7184562);

/*CREATE TABLE Adquirir(
	ID_Cliente INT,
	ID_Automotor VARCHAR(20),
    PRIMARY KEY (ID_Cliente, ID_Automotor),
	FOREIGN KEY(ID_Cliente) REFERENCES Cliente(Identificacion) ON DELETE SET NULL ON UPDATE CASCADE,
	FOREIGN KEY(ID_Automotor) REFERENCES Automotor(Numero_chasis) ON DELETE SET NULL ON UPDATE CASCADE
);
INSERT INTO Adquirir (ID_Cliente, ID_Automotor) VALUES (1000472996, '1HGCM82633A123456');*/

CREATE SEQUENCE Compra_Auto
    START 901
    INCREMENT 1;
CREATE TABLE Compra(
	ID_Compra INT DEFAULT nextval('Compra_Auto'),
    ID_Cliente INT,
    ID_Auto VARCHAR,
    ID_Empleado INT,
    Fecha_Compra DATE NOT NULL,
	Valor FLOAT NOT NULL,
    PRIMARY KEY (ID_Compra),
    FOREIGN KEY (ID_Cliente) REFERENCES Cliente (Identificacion) ON DELETE SET NULL ON UPDATE CASCADE,
    FOREIGN KEY (ID_Auto) REFERENCES Automotor (Numero_Chasis) ON DELETE SET NULL ON UPDATE CASCADE,
    FOREIGN KEY (ID_Empleado) REFERENCES Empleado (Codigo) ON DELETE SET NULL ON UPDATE CASCADE
);
INSERT INTO Compra (ID_Cliente, ID_Auto, ID_Empleado, Fecha_Compra, Valor) VALUES (1000472996, '1HGCM82633A123456', 1001, '2023-11-03', 44500000);

/*TRIGGERS*/

--Asigna la sucursal al cliente nuevo

CREATE OR REPLACE FUNCTION SucursalCliente() RETURNS TRIGGER AS $$
BEGIN
    IF NEW.ID_Cliente IS NOT NULL AND (SELECT ID_Sucursal FROM Cliente WHERE Identificacion = NEW.ID_Cliente) IS NULL THEN
        UPDATE Cliente SET ID_Sucursal = (SELECT ID_Sucursal FROM Empleado WHERE codigo = NEW.ID_Empleado) WHERE Identificacion = NEW.ID_Cliente;
    END IF;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER trigger_asignar_sucursal
AFTER INSERT ON Compra
FOR EACH ROW
EXECUTE FUNCTION SucursalCliente();

-- Crear una función que devuelve cantidad de clientes nuevos (Consolidado mensual)

CREATE TABLE CantClientesNuevos(
    ID_cant SERIAL PRIMARY KEY NOT NULL,
    Mes int not null,
    Cantidad int not null
);

ALTER TABLE CantClientesNuevos ADD CONSTRAINT uk_Mes UNIQUE (Mes);

CREATE OR REPLACE FUNCTION fechas() RETURNS TRIGGER AS $$
    DECLARE
        mesRegistro INT;
    BEGIN
        mesRegistro := EXTRACT(MONTH FROM NEW.Fecha_Registro);

        INSERT INTO CantClientesNuevos(Mes, Cantidad) VALUES (mesRegistro, 1)
        ON CONFLICT (Mes) 
        DO UPDATE SET Cantidad = CantClientesNuevos.Cantidad + 1;

        RETURN NEW;
    END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER trigger_fechas
AFTER INSERT ON Cliente
FOR EACH ROW
EXECUTE FUNCTION fechas();

--Clientes nuevos por sucursal

CREATE OR REPLACE FUNCTION SucursalClientesNuevos(mes INT, anio INT) RETURNS TABLE (
    SucursalDondeRegistro INT,
    Identificacion INT,
    NombreCliente VARCHAR,
    FechaRegistro DATE
) AS $$
BEGIN
    RETURN QUERY
        SELECT
            s.NombreSucursal AS SucursalDondeRegistro,
            c.Identificacion AS Identificacion,
            c.Nombre AS NombreCliente,
            c.Fecha_Registro AS FechaRegistro
        FROM Cliente c
        JOIN Sucursal s ON c.ID_Sucursal = s.ID
        WHERE EXTRACT(MONTH FROM c.Fecha_Registro) = mes
        AND EXTRACT(YEAR FROM c.Fecha_Registro) = anio;

    RETURN;
END;
$$ LANGUAGE plpgsql;

--SELECT * FROM datos_clientes_nuevos(10, 2023);

/*TRIGGER PARA CREAR UN NUEVO USUARIO DESPUÉS DE INSERTAR UN NUEVO EMPLEADO*/
--Este trigger funcionará de manera que cuando se inserte un nuevo empleado se inserte
--automáticamente un nuevo usuario con valores nulos que puedan ser modificados posteriormente

CREATE OR REPLACE FUNCTION InsertarUsuario()
RETURNS TRIGGER AS $$
BEGIN
    -- Insertar un nuevo usuario con valores nulos
    INSERT INTO Usuario (ID_empleado, Username, Pass, ID_Rol)
    VALUES (NEW.Codigo, NULL, NULL, NULL);

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER triggerInsertarUsuario
AFTER INSERT ON Empleado
FOR EACH ROW
EXECUTE FUNCTION InsertarUsuario();

/*VISTAS*/

--Vista para mostrar el nombre del gerente junto a la tabla sucursal en base a su ID
CREATE VIEW VistaGerente AS
SELECT 
    s.id, s.nombresucursal, c.ciudad
FROM Sucursal s
JOIN Ciudad_Residencia c ON s.CiudadSucursal = c.id
ORDER BY s.id ASC;

--Vista para mostrar el nombre de la sucursal, el telefono y el cargo en la tabla empleado con base a su ID
CREATE OR REPLACE VIEW Vista_Empleado AS
SELECT 
    e.codigo, e.identificacion, e.nombreemp, c.cargo, s.nombresucursal, e.fecha_nacimiento, 
    e.fecha_ingreso, e.salario, t.telefono
FROM Empleado e
JOIN Cargo c ON e.id_cargo = c.id
JOIN Sucursal s ON e.id_sucursal = s.id
LEFT JOIN Telefono_Emp t ON e.codigo = t.id_empleado
ORDER BY s.id, c.id, e.fecha_ingreso ASC;


--Vista para visualizar la tabla Usuario de manera cómoda
CREATE VIEW Vista_Usuario AS
SELECT 
    u.id, e.nombreemp, u.username, u.pass, r.rol
FROM Usuario u
JOIN Empleado e ON u.Id_empleado = e.codigo
JOIN Rol r ON u.Id_rol = r.id
ORDER BY u.id ASC;

--Vista general de automotor
CREATE VIEW Vista_Automotor AS
SELECT 
    a.numero_chasis, c.color, l.linea, t.tipo, m.marca, a.Modelo, 
    a.Identificacion_interna, a.Placa, s.nombresucursal
FROM Automotor a
JOIN Color c ON a.id_color = c.id
JOIN Linea l ON a.id_linea = l.id
JOIN Tipo t ON a.id_tipo = t.id
JOIN Marca m ON a.id_marca = m.id
JOIN Sucursal s ON a.SucursalDondeEsta = s.id
ORDER BY a.numero_chasis ASC;

--Vista general de cliente
CREATE VIEW Vista_Cliente AS
SELECT 
    c.identificacion, c.nombre, cr.ciudad, c.fecha_registro, t.Telefono, s.nombresucursal
FROM Cliente c
JOIN Ciudad_Residencia cr ON c.id_ciudad = cr.id
JOIN Telefono_Clie t ON c.identificacion = t.ID_Cliente
JOIN Sucursal s ON c.id_sucursal = s.ID
ORDER BY c.identificacion ASC;

--Vista general de tabla adquirir
/*CREATE VIEW Vista_Adquirir AS
SELECT 
    ad.ID_Cliente, ad.ID_Automotor, au.numero_chasis, au.color, au.linea,
    au.tipo, au.marca, au.modelo, au.identificacion_interna, au.placa, cl.nombre,
    cl.ciudad, cl.fecha_registro, tc.telefono
FROM Adquirir ad
JOIN Vista_Automotor au ON ad.ID_Automotor = au.numero_chasis
JOIN Vista_Cliente cl ON ad.ID_Cliente = cl.identificacion
JOIN Telefono_Clie tc ON ad.ID_Cliente = tc.ID_Cliente
ORDER BY ad.ID_Cliente, ad.ID_Automotor ASC;*/

--Vista general de tabla compra
CREATE VIEW Vista_Compra AS
SELECT 
    c.ID_Compra, vc.nombre, ve.nombreemp, c.Fecha_Compra, c.Valor,  vc.ciudad, vc.fecha_registro
FROM Compra c
JOIN Vista_Empleado ve ON c.ID_Empleado = ve.codigo
JOIN Vista_Cliente vc ON c.ID_Cliente = vc.identificacion
JOIN Vista_Automotor va ON c.ID_Auto = va.numero_chasis
ORDER BY c.ID_Compra ASC;

/*PROCEDIMIENTOS DE PRUEBA*/


--TRIGGER DE CONSOLIDADO MENSUAL Y ANUAL DE MARCAS MAS VENDIDAS
CREATE TABLE CantMarcasVendidas(
    ID_marcasVen SERIAL PRIMARY KEY NOT NULL,
    Sucursal_Venta int not null,
    MarcaVendida varchar(15) not null,
    Identificacion_Interna varchar(10),
    placaAuto varchar(8),
    Cantidad int not null
);

CREATE OR REPLACE FUNCTION ExtraerAutomotor(id_automotor VARCHAR(20), OUT marca VARCHAR(50), OUT identificacion_interna VARCHAR(10), OUT placa VARCHAR(8))
RETURNS SETOF RECORD AS $$
BEGIN
    RETURN QUERY
    SELECT m.Marca, a.identificacion_interna, a.placa
    FROM Automotor a
    JOIN Marca m ON a.ID_Marca = m.ID
    WHERE a.Numero_Chasis = id_automotor;

    RETURN;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION marcasSolicitadas() RETURNS TRIGGER AS $$
DECLARE
    info_automotor RECORD;
    mesRegistro INT;
    id_sucursal_compra INT;
BEGIN
    SELECT ID_Sucursal INTO id_sucursal_compra
    FROM Compra
    WHERE ID_Cliente = (SELECT ID_Cliente FROM Adquirir WHERE ID_Automotor = NEW.ID_Automotor LIMIT 1);

    IF id_sucursal_compra IS NOT NULL THEN
        DECLARE
            adquirir_data RECORD;
        BEGIN
            SELECT * INTO adquirir_data
            FROM Adquirir
            WHERE ID_Automotor = NEW.ID_Automotor;

            SELECT * INTO info_automotor
            FROM ExtraerAutomotor(adquirir_data.ID_Automotor);

            mesRegistro := EXTRACT(MONTH FROM NEW.Fecha_Compra);

            INSERT INTO CantMarcasVendidas(Sucursal_Venta, MarcaVendida, Identificacion_Interna, placaAuto, Cantidad)
            VALUES (id_sucursal_compra, info_automotor.marca, info_automotor.identificacion_interna, info_automotor.placa, 1)
            ON CONFLICT (Sucursal_Venta, MarcaVendida, Identificacion_Interna, placaAuto)
            DO UPDATE SET Cantidad = CantMarcasVendidas.Cantidad + 1;
        END;
    END IF;

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER trigger_marcasmensuales
AFTER INSERT ON Adquirir
FOR EACH ROW
EXECUTE FUNCTION marcasSolicitadas();



