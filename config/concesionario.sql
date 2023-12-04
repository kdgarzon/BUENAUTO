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

CREATE SEQUENCE Sucursal_Auto
    START 301
    INCREMENT 1;
CREATE TABLE Sucursal(
	ID INT DEFAULT nextval('Sucursal_Auto'),
	ID_Gerente INT,
	Nombre varchar(50) NOT NULL,
    PRIMARY KEY (ID)
);
INSERT INTO Sucursal (Nombre) VALUES ('Sucursal La Floresta');
/*Se inserta solo el nombre porque después de creado el empleado se hará un UPDATE para el ID_Gerente*/

CREATE SEQUENCE Empleado_Auto
    START 1001
    INCREMENT 1;
CREATE TABLE Empleado(
	Codigo INT DEFAULT nextval('Empleado_Auto'),
	ID_cargo INT,
	ID_Sucursal INT,
	Identificacion INT NOT NULL,
	Nombre varchar(35) NOT NULL,
	Fecha_nacimiento DATE NOT NULL,
	Fecha_ingreso DATE NOT NULL,
	Salario FLOAT NOT NULL,
    PRIMARY KEY (Codigo),
	FOREIGN KEY(ID_cargo) REFERENCES Cargo(ID) ON DELETE SET NULL ON UPDATE CASCADE
);
/*Se utiliza SET NULL Y CASCADE para que cuando se elimine una fila en la tabla Cargo su valor en
la tabla Empleado se establecerá en NULL. Así mismo, si se actualiza algún dato en la tabla Cargo
se actualizará automáticamente en la tabla Empleado*/

INSERT INTO Empleado (ID_cargo, Identificacion, Nombre, Fecha_nacimiento, Fecha_ingreso, Salario, ID_Sucursal) VALUES (201, 1000472996, 'Karen Garzon', '2002-10-17', '2023-06-20', 2500000, 301);
UPDATE Sucursal SET ID_Gerente = 1001 WHERE Nombre = 'Sucursal La Floresta';

CREATE TABLE Telefono_Emp(
	ID_Empleado INT NOT NULL,
	Telefono INT,
    PRIMARY KEY (ID_Empleado),
	FOREIGN KEY(ID_Empleado) REFERENCES Empleado(Codigo) ON DELETE CASCADE ON UPDATE CASCADE
);

INSERT INTO Telefono_Emp (ID_Empleado, Telefono) VALUES (1001, 3142101);

ALTER TABLE Sucursal ADD CONSTRAINT FK_Empleado FOREIGN KEY (ID_Gerente) REFERENCES Empleado(Codigo) ON UPDATE SET NULL ON DELETE SET NULL;
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
INSERT INTO Tipo (Tipo) VALUES ('Camión');

CREATE SEQUENCE Color_Auto
    START 601
    INCREMENT 1;
CREATE TABLE Color(
	ID INT DEFAULT nextval('Color_Auto'),
	Color varchar(15) NOT NULL,
    PRIMARY KEY (ID)
);
INSERT INTO Color (Color) VALUES ('Plata');

CREATE SEQUENCE Marca_Auto
    START 701
    INCREMENT 1;
CREATE TABLE Marca(
	ID INT DEFAULT nextval('Marca_Auto'),
	Marca varchar(50) NOT NULL,
    PRIMARY KEY (ID)
);
INSERT INTO Marca (Marca) VALUES ('Chevrolet');

CREATE TABLE Automotor(
	Numero_Chasis VARCHAR(20) NOT NULL,
	ID_Color INT,
	ID_Linea INT,
	ID_Tipo INT,
	ID_Marca INT,
	Modelo INT NOT NULL,
	Identificacion_interna VARCHAR(10),
	Placa VARCHAR(8),
    PRIMARY KEY (Numero_Chasis),
	FOREIGN KEY(ID_Color) REFERENCES Color(ID) ON DELETE SET NULL ON UPDATE CASCADE,
	FOREIGN KEY(ID_Linea) REFERENCES Linea(ID) ON DELETE SET NULL ON UPDATE CASCADE,
	FOREIGN KEY(ID_Tipo) REFERENCES Tipo(ID) ON DELETE SET NULL ON UPDATE CASCADE,
	FOREIGN KEY(ID_Marca) REFERENCES Marca(ID) ON DELETE SET NULL ON UPDATE CASCADE
);
INSERT INTO Automotor (Numero_Chasis, ID_Color, ID_Linea, ID_Tipo, ID_Marca, Modelo, Identificacion_interna, Placa) 
	VALUES ('1HGCM82633A123456', 601, 401, 501, 701, 2020, 'ABC100', NULL);

CREATE SEQUENCE Ciudad_Auto
    START 801
    INCREMENT 1;
CREATE TABLE Ciudad_Residencia(
	ID INT DEFAULT nextval('Ciudad_Auto'),
	Ciudad varchar(25) NOT NULL,
    PRIMARY KEY (ID)
);
INSERT INTO Ciudad_Residencia (Ciudad) VALUES ('Bogota D.C');

CREATE TABLE Cliente(
	Identificacion INT NOT NULL,
	ID_Ciudad INT,
	Nombre varchar(60) NOT NULL,
	Fecha_Registro DATE NOT NULL,
    PRIMARY KEY (Identificacion),
	FOREIGN KEY(ID_Ciudad) REFERENCES Ciudad_Residencia(ID) ON DELETE SET NULL ON UPDATE CASCADE
);
INSERT INTO Cliente (Identificacion, ID_Ciudad, Nombre, Fecha_Registro) VALUES (1000472996, 801, 'Daniel Caicedo', '2023-11-03');

CREATE TABLE Telefono_Clie(
	ID_Cliente INT NOT NULL,
	Telefono INT NOT NULL,
    PRIMARY KEY (ID_Cliente),
	FOREIGN KEY(ID_Cliente) REFERENCES Cliente(Identificacion) ON DELETE CASCADE ON UPDATE CASCADE
);
INSERT INTO Telefono_Clie (ID_Cliente, Telefono) VALUES (1000472996, 7184562);

CREATE TABLE Adquirir(
	ID_Cliente INT,
	ID_Automotor VARCHAR(20),
    PRIMARY KEY (ID_Cliente, ID_Automotor),
	FOREIGN KEY(ID_Cliente) REFERENCES Cliente(Identificacion) ON DELETE SET NULL ON UPDATE CASCADE,
	FOREIGN KEY(ID_Automotor) REFERENCES Automotor(Numero_chasis) ON DELETE SET NULL ON UPDATE CASCADE
);
INSERT INTO Adquirir (ID_Cliente, ID_Automotor) VALUES (1000472996, '1HGCM82633A123456');

CREATE SEQUENCE Compra_Auto
    START 901
    INCREMENT 1;
CREATE TABLE Compra(
	ID INT DEFAULT nextval('Compra_Auto'),
    ID_Cliente INT,
    ID_Sucursal INT,
    Fecha_Compra DATE NOT NULL,
	Valor FLOAT NOT NULL,
    PRIMARY KEY (ID),
    FOREIGN KEY (ID_Cliente) REFERENCES Cliente (Identificacion) ON DELETE SET NULL ON UPDATE CASCADE,
    FOREIGN KEY (ID_Sucursal) REFERENCES Sucursal (ID) ON DELETE SET NULL ON UPDATE CASCADE
);
INSERT INTO Compra (ID_Cliente, ID_Sucursal, Fecha_Compra, Valor) VALUES (1000472996, 301, '2023-11-03', 44500000);

/*TRIGGERS*/

/*TRIGGER PARA ACTUALIZAR EL ID_GERENTE EN SUCURSAL CUANDO SE INSERTE UN NUEVO EMPLEADO*/
--Se utiliza cuando la sucursal no tiene un gerente asignado
CREATE OR REPLACE FUNCTION actualizarGerente()
RETURNS TRIGGER AS $$
BEGIN
    -- Se verifica si la sucursal ya tiene un gerente asignado
    IF NEW.ID_Gerente IS NOT NULL THEN
        UPDATE Sucursal
        SET ID_Gerente = NEW.Codigo
        WHERE ID_Sucursal = NEW.ID_Sucursal;
    ELSE
        -- Si no hay gerente asignado, establecer ID_Gerente como NULL
        UPDATE Sucursal
        SET ID_Gerente = NULL
        WHERE ID_Sucursal = NEW.ID_Sucursal;
    END IF;

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER actualizarGerenteSucursal
AFTER INSERT ON Empleado
FOR EACH ROW
WHEN (NEW.ID_cargo = 201)
EXECUTE FUNCTION actualizarGerente();

/*TRIGGER QUE ASIGNA SUCURSAL A EMPLEADO*/
/*Se aplica cuando el gerente de la sucursal aún no tiene una ID_Sucursal asignada
En caso de que no encuentre una sucursal asignada el asignará el valor de NULL*/

CREATE OR REPLACE FUNCTION asignarSucursalEmp()
RETURNS TRIGGER AS $$
BEGIN
    
    SELECT ID_Sucursal INTO NEW.ID_Sucursal
    FROM Sucursal
    WHERE ID_Gerente = NEW.ID_Gerente;

    EXCEPTION
    WHEN NO_DATA_FOUND THEN
        NEW.ID_Sucursal := NULL;

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER trigAsignarSucursalEmp
BEFORE INSERT ON Empleado
FOR EACH ROW
EXECUTE FUNCTION asignarSucursalEmp();

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

/*TRIGGER QUE SE ENCARGA DE ASIGNAR EL ID_SUCURSAL AL CLIENTE DEPENDIENDO DE DONDE FUE 
SU PRIMERA COMPRA*/
CREATE OR REPLACE FUNCTION PrimeraCompra()
RETURNS TRIGGER AS $$
DECLARE
    id_PrimeraCompra INT;
BEGIN
    -- Obtener el ID de la sucursal de la primera compra del cliente
    SELECT c.ID_Sucursal
    INTO id_PrimeraCompra
    FROM Compra c
    WHERE c.ID_Cliente = NEW.Identificacion
    ORDER BY c.Fecha_Compra
    LIMIT 1;

    -- Si no hay compras realizadas, obtener la sucursal según la fecha de registro del 
	--cliente
    IF id_PrimeraCompra IS NULL THEN
        SELECT c.ID_Sucursal
        INTO id_PrimeraCompra
        FROM Compra c
        WHERE c.ID_Cliente = NEW.Identificacion
        ORDER BY c.Fecha_Compra
        LIMIT 1;
    END IF;

    -- Asignar el ID de la sucursal al cliente
    IF id_PrimeraCompra IS NOT NULL THEN
        UPDATE Cliente
        SET ID_Sucursal = id_PrimeraCompra
        WHERE Identificacion = NEW.Identificacion;
    END IF;

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER triggerPrimeraCompra
AFTER INSERT ON Compra
FOR EACH ROW
EXECUTE FUNCTION PrimeraCompra();

/*TRIGGER PARA INSERTAR UN NUEVO TELEFONO DESPUÉS DE INSERTAR UN NUEVO EMPLEADO*/
CREATE OR REPLACE FUNCTION TelefonoEmpleadoInsertar()
RETURNS TRIGGER AS $$
BEGIN
    
    IF NEW.Telefono IS NOT NULL THEN
        INSERT INTO Telefono_Emp (ID_Empleado, Telefono)
        VALUES (NEW.Codigo, NEW.Telefono);
    ELSE
        INSERT INTO Telefono_Emp (ID_Empleado, Telefono)
        VALUES (NEW.Codigo, NULL);
    END IF;

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER triggerInsertarTel
AFTER INSERT ON Empleado
FOR EACH ROW
EXECUTE FUNCTION TelefonoEmpleadoInsertar();

/*TRIGGER PARA INSERTAR UN TELEFONO DE CLIENTE DESPUÉS DE INSERTAR UN NUEVO CLIENTE*/
CREATE OR REPLACE FUNCTION TelefonoClienteInsertar()
RETURNS TRIGGER AS $$
BEGIN
    
    IF NEW.Telefono IS NOT NULL THEN
        INSERT INTO Telefono_Clie (ID_Cliente, Telefono)
        VALUES (NEW.Identificacion, NEW.Telefono);
    ELSE
        INSERT INTO Telefono_Clie (ID_Cliente, Telefono)
        VALUES (NEW.Identificacion, NULL);
    END IF;

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER triggerInsertarTelCliente
AFTER INSERT ON Cliente
FOR EACH ROW
EXECUTE FUNCTION TelefonoClienteInsertar();

/*PROCEDIMIENTOS ALMACENADOS*/
/*Este procedimiento se encargará de calcular el valor total de todas las compras realizadas
por un cliente sin importar el número de compras que haya realizado*/

CREATE OR REPLACE FUNCTION TotalCompras()
RETURNS TABLE (
    ID_Cliente INT,
    Valor_Total FLOAT
) AS $$
BEGIN
    -- Seleccionar el ID del cliente y la suma de los valores de todas las compras
    RETURN QUERY
    SELECT ID_Cliente, COALESCE(SUM(Valor), 0) AS Valor_Total
    FROM Compra
    GROUP BY ID_Cliente;
END;
$$ LANGUAGE plpgsql;

--SELECT * FROM TotalCompras();

/*VISTAS*/

--Vista para mostrar el nombre del gerente junto a la tabla sucursal en base a su ID
CREATE VIEW VistaGerente AS
SELECT
    s.ID,
    s.Nombre AS Nombre_Sucursal,
    e.Nombre AS Nombre_Gerente
FROM Sucursal s
LEFT JOIN Empleado e ON s.ID_Gerente = e.Codigo;

--Vista para mostrar el nombre de la sucursal, el telefono y el cargo en la tabla empleado con base a su ID
CREATE OR REPLACE VIEW Vista_Empleado AS
SELECT
    e.Codigo AS ID_Empleado, e.ID_cargo, e.ID_Sucursal, e.Identificacion,
    e.Nombre AS Nombre_Empleado, e.Fecha_nacimiento, e.Fecha_ingreso, e.Salario,
	s.Nombre AS Nombre_Sucursal, c.Cargo AS Nombre_Cargo, t.Telefono
FROM Empleado e
LEFT JOIN Sucursal s ON e.ID_Sucursal = s.ID
LEFT JOIN Cargo c ON e.ID_cargo = c.ID
LEFT JOIN Telefono_Emp t ON e.Codigo = t.ID_Empleado;

--Vista para visualizar la tabla Usuario de manera cómoda
CREATE VIEW Vista_Usuario AS
SELECT
    u.ID AS ID_Usuario, u.ID_empleado, u.Username,
    u.Pass, r.Rol AS Nombre_Rol, e.Nombre AS Nombre_Empleado
FROM Usuario u
LEFT JOIN Rol r ON u.ID_Rol = r.ID
LEFT JOIN Empleado e ON u.ID_empleado = e.Codigo;

--Vista general de automotor
CREATE VIEW Vista_Automotor AS
SELECT
    a.Numero_Chasis, c.Color AS Nombre_Color, l.Linea AS Nombre_Linea,
    t.Tipo AS Nombre_Tipo, m.Marca AS Nombre_Marca, a.Modelo, a.Identificacion_interna, a.Placa
FROM Automotor a
LEFT JOIN Color c ON a.ID_Color = c.ID
LEFT JOIN Linea l ON a.ID_Linea = l.ID
LEFT JOIN Tipo t ON a.ID_Tipo = t.ID
LEFT JOIN Marca m ON a.ID_Marca = m.ID;

--Vista general de cliente
CREATE VIEW Vista_Cliente AS
SELECT
    cl.Identificacion AS ID_Cliente, cl.Nombre AS Nombre_Cliente,
    t.Telefono, ci.Ciudad AS Nombre_Ciudad, cl.Fecha_Registro
FROM Cliente cl
LEFT JOIN Telefono_Clie t ON cl.Identificacion = t.ID_Cliente
LEFT JOIN Ciudad_Residencia ci ON cl.ID_Ciudad = ci.ID;

--Vista general de tabla adquirir
CREATE OR REPLACE VIEW Vista_Adquirir AS
SELECT
    ad.ID_Cliente, ad.ID_Automotor, va.Numero_Chasis, va.Nombre_Color, va.Nombre_Linea,
    va.Nombre_Tipo, va.Nombre_Marca, va.Modelo, va.Identificacion_interna, va.Placa,
    vc.Nombre_Cliente, vc.Telefono, vc.Nombre_Ciudad, vc.Fecha_Registro
FROM Adquirir ad
LEFT JOIN Vista_Automotor va ON ad.ID_Automotor = va.Numero_Chasis
LEFT JOIN Vista_Cliente vc ON ad.ID_Cliente = vc.ID_Cliente;

--Vista general de tabla compra
CREATE OR REPLACE VIEW Vista_Compra AS
SELECT
    co.ID, co.ID_Cliente, vc.Nombre_Cliente, vc.Telefono,
    vc.Nombre_Ciudad, vc.Fecha_Registro, co.ID_Sucursal, vg.Nombre_Sucursal,
    vg.Nombre_Gerente, co.Fecha_Compra, co.Valor
FROM Compra co
LEFT JOIN Vista_Cliente vc ON co.ID_Cliente = vc.ID_Cliente
LEFT JOIN VistaGerente vg ON co.ID_Sucursal = vg.ID;
