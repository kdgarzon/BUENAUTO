<?php
    session_start();

    if(!isset($_SESSION['txtUser'])){
        echo '<script>
                alert("Por favor debes iniciar sesión");
                window.location = "../../Login/Login.php";
            </script>';
        header('location: ../../Login/Login.php');
        session_destroy();
        die();
    }

    require ('../../config/Conexion.php');
    $link = conectar();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php include '../../config/encabezado.php';?>
    <title>Gestion de Empleados</title>
</head>
<body>
    <?php include '../../config/header.php';?>
    <h1 class = "titulo_principal">Gestión de Empleados</h1>
    <hr class="linea">
    <div class = "EntradaDatos">
        <form action="GestionEmpleados.php" method = "POST" name = "formulario" class = "row g-3">
            <h2 class = "tit">Información general</h2>
            <div class="col-md-4">
                <label for="txtIdent" class="form-label">Número de identificación:</label>
                <input type="number" class="form-control" id="txtIdent" name="txtIdent" placeholder="Identificación..." required>
            </div>
            <div class="col-md-4">
                <label for="txtNombre" class="form-label">Nombre del empleado: </label>
                <input type="text" class="form-control" placeholder="Nombre..." id="txtNombre" name="txtNombre" required>
            </div>
            <?php
                $sqlCargo = "SELECT ID, Cargo FROM Cargo";
                $Cargos = pg_query($link, $sqlCargo) or die('La consulta de cargos fallo: ' . pg_last_error($link));
            ?>
            <div class="col-md-4"><!--Lista desplegable-->
                <label for="ListaCargos" class="form-label">Cargo: </label>
                <select id="ListaCargos" name="ListaCargos" class="form-select" required>
                    <option selected>Seleccionar...</option>
                    <?php
                    while ($row_cargo = pg_fetch_object($Cargos)) { ?>
                        <option value = "<?php echo $row_cargo->id ?>"><?php echo $row_cargo->cargo; ?></option>;
                    <?php } 
                    ?>
                </select>
            </div>
            <?php
                $sqlSucursal = "SELECT ID, Nombre FROM Sucursal";
                $Sucursales = pg_query($link, $sqlSucursal) or die('La consulta de sucursales fallo: ' . pg_last_error($link));
            ?>
            <div class="col-md-4"><!--Lista desplegable-->
                <label for="ListaSucursales" class="form-label">Sucursal: </label>
                <select id="ListaSucursales" name="ListaSucursales" class="form-select" required>
                    <option selected>Seleccionar...</option>
                    <?php
                    while ($row_sucursal = pg_fetch_object($Sucursales)) { ?>
                        <option value = "<?php echo $row_sucursal->id ?>"><?php echo $row_sucursal->nombre; ?></option>;
                    <?php } 
                    ?>
                </select>
            </div>
            <div class="col-md-4">
                <label for="txtNacimiento" class="form-label">Fecha de nacimiento: </label>
                <input type="date" class="form-control" placeholder="Fecha de nacimiento..." id="txtNacimiento" name="txtNacimiento" required>
            </div>
            <div class="col-md-4">
                <label for="txtIngreso" class="form-label">Fecha de ingreso del empleado: </label>
                <input type="date" class="form-control" placeholder="Fecha de ingreso..." id="txtIngreso" name="txtIngreso" required>
            </div>
            <div class="col-md-4">
                <label for="txtSalario" class="form-label">Salario del empleado: </label>
                <input type="number" class="form-control" placeholder="Salario..." id="txtSalario" name="txtSalario" required>
            </div>
            <div class="col-md-4">
                <label for="txtTelefono" class="form-label">Teléfono del empleado: </label>
                <input type="number" class="form-control" placeholder="Teléfono..." id="txtTelefono" name="txtTelefono" required>
            </div>
            <div class="col-md-2" id = "boton">
                <input type="submit" class = "btn" style = "background-color:#A6FB7E" value = "INSERTAR" id = "btnAgregar" name = "btnAgregar">
            </div>
            <div class="col-md-2" id = "boton">
                <input type="reset" class = "btn" style = "background-color:#F6DB4C" value = "RESTABLECER CAMPOS" id = "btnBorrar" name = "btnBorrar">
            </div>
        </form>
    </div>
    <div class = "informacion">
        <h2 class = "tit">Registros</h2>
        <table class = "table table-striped">
            <thead class = "table-light">
                <th>Código del empleado</th>
                <th>No. Identificación</th>
                <th>Nombre</th>
                <th>Cargo</th>
                <th>Sucursal</th>
                <th>Fecha de nacimiento</th>
                <th>Fecha de ingreso</th>
                <th>Salario</th>
                <th>Telefono</th>
                <th>Acciones</th>
            </thead>
            <?php
                $consultar = "SELECT e.codigo, e.identificacion, e.nombre, c.cargo, s.nombre, e.fecha_nacimiento, e.fecha_ingreso, e.salario, t.telefono
                    FROM Empleado e
                    JOIN Cargo c ON e.id_cargo = c.id
                    JOIN Sucursal s ON e.id_sucursal = s.id
                    JOIN Telefono_Emp t ON e.codigo = t.id_empleado
                    ORDER BY e.codigo ASC";
                $registros = pg_query($link, $consultar) or die('La consulta de empleados fallo: ' . pg_last_error($link));

                while($fila = pg_fetch_array($registros)){ ?>
                    <tr>
                        <td><?= $fila[0]; ?></td>
                        <td><?= $fila[1]; ?></td>
                        <td><?= $fila[2]; ?></td>
                        <td><?= $fila[3]; ?></td>
                        <td><?= $fila[4]; ?></td>
                        <td><?= $fila[5]; ?></td>
                        <td><?= $fila[6]; ?></td>
                        <td><?= $fila[7]; ?></td>
                        <td><?= $fila[8]; ?></td>
                        <td>
                            <a href="ModificarEmpleado.php?codigo=<?= $fila[0] ?>" class="btn btn-warning" style = "margin-right:7px;">
                                <img src = "../../Imagenes/editar.png" width = "20px" height = "20px">
                            </a>
                            <a href="GestionEmpleados.php?codigo=<?= $fila[0] ?>" class="btn btn-danger">
                                <img src = "../../Imagenes/eliminar.png" width = "20px" height = "20px">
                            </a>
                        </td>
                    </tr>
                <?php } ?>
        </table>
    </div>
    <?php include '../../config/footer.php';?>
    <?php
        //INSERTAR DATOS
        if(isset($_POST['btnAgregar'])){
            
            // Obtengo los datos cargados en el formulario de Gestionar Usuarios
            $Identificacion = $_POST['txtIdent'];
            $Nombre = $_POST['txtNombre'];
            $Cargo = $_POST['ListaCargos'];
            $Sucursal = $_POST['ListaSucursales'];
            $FechaNac = $_POST['txtNacimiento'];
            $FechaIngr = $_POST['txtIngreso'];
            $Salario = $_POST['txtSalario'];
            $Telefono = $_POST['txtTelefono'];

            //Formulo la consulta SQL
            $sql = "INSERT INTO empleado (id_cargo, id_sucursal, identificacion, nombre, fecha_nacimiento, fecha_ingreso, salario) 
                VALUES ('$Cargo', '$Sucursal', '$Identificacion', '$Nombre', '$FechaNac', '$FechaIngr', '$Salario' ) RETURNING codigo;";
            $respuesta = pg_query($link, $sql) or die('La inserción de datos fallo: ' . pg_last_error($link));

            if($respuesta){
                $row = pg_fetch_assoc($respuesta);
                $idEmpleado = $row['codigo'];
        
                // Formulo la consulta SQL para insertar en la tabla telefono_emp
                $sqlTelefono = "INSERT INTO telefono_emp (id_empleado, telefono) VALUES ('$idEmpleado', '$Telefono');";
        
                $resultadoTelefono = pg_query($link, $sqlTelefono);
        
                if($resultadoTelefono){
                    echo "<script type='text/javascript'>
                        Swal.fire({
                            title: '¡Datos insertados correctamente!',
                            width: 600,
                            padding: '2em',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        setTimeout(function() {
                            window.location.href = 'GestionEmpleados.php';
                        }, 1500);
                    </script>";
                }else{
                    echo "<script type='text/javascript'>
                    Swal.fire({
                        title: 'ERROR!!',
                        text :'Algo salió mal y el telefono no pudo ser insertado. Intente de nuevo.',
                        width: 600,
                        padding: '2em',
                        icon: 'error',
                        showConfirmButton: false,
                        timer: 1800
                    });
                    setTimeout(function() {
                        // Redirige o realiza otra acción después de cerrar la alerta
                        window.location.href = 'GestionEmpleados.php';
                    }, 1800);
                </script>";
                }
            }else{
                echo "<script type='text/javascript'>
                    Swal.fire({
                        title: 'ERROR!!',
                        text :'Algo salió mal y los datos no pudieron ser insertados. Intente de nuevo.',
                        width: 600,
                        padding: '2em',
                        icon: 'error',
                        showConfirmButton: false,
                        timer: 1800
                    });
                    setTimeout(function() {
                        // Redirige o realiza otra acción después de cerrar la alerta
                        window.location.href = 'GestionEmpleados.php';
                    }, 1800);
                </script>";
            }
        }

        //ELIMINAR DATOS
        if(isset($_GET['codigo'])){
            $ID_u = (isset($_GET['codigo'])?$_GET['codigo']:"");
            
            //Formulamos la sentencia SQL
            $primer_sql = "SELECT * FROM empleado WHERE codigo = '".$ID_u."'";
            $registros = pg_query($link, $primer_sql) or die('La consulta de empleados para eliminar fallo: ' . pg_last_error($link));

            if($respuesta = pg_fetch_array($registros)){
                //Formulamos la sentencia SQL
                $segundo_sql = "DELETE FROM empleado WHERE codigo = '".$ID_u."'";

                pg_query($link, $segundo_sql);
                echo "<script type='text/javascript'>
                    Swal.fire({
                        title: '¡Datos eliminados correctamente!',
                        text: 'Los registros fueron eliminados de manera exitosa',
                        width: 600,
                        padding: '2em',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 1800
                    });
                    setTimeout(function() {
                        // Redirige o realiza otra acción después de cerrar la alerta
                        window.location.href = 'GestionEmpleados.php';
                    }, 1800);
                </script>";
            }else{
                echo "<script type='text/javascript'>
                    Swal.fire({
                        title: 'ERROR!!',
                        text :'Los registros no fueron eliminados. Intente de nuevo.',
                        width: 600,
                        padding: '2em',
                        icon: 'error',
                        showConfirmButton: false,
                        timer: 1800
                    });
                    setTimeout(function() {
                        // Redirige o realiza otra acción después de cerrar la alerta
                        window.location.href = 'GestionEmpleados.php';
                    }, 1800);
                </script>";
            }
        }
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" 
        crossorigin="anonymous"></script>
</body>
</html>