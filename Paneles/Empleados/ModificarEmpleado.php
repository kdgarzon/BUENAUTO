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

    $sqlCargo = "SELECT ID, Cargo FROM Cargo";
    $Cargos = pg_query($link, $sqlCargo) or die('La consulta de cargos fallo: ' . pg_last_error($link));

    $sqlSucursal = "SELECT ID, Nombre FROM Sucursal";
    $Sucursales = pg_query($link, $sqlSucursal) or die('La consulta de sucursales fallo: ' . pg_last_error($link));

    $ID_u = (isset($_GET['codigo'])?$_GET['codigo']:"0");

    $sqlSeleccionar = "SELECT * FROM empleado WHERE codigo = $ID_u";
    $registros = pg_query($link, $sqlSeleccionar) or die('La consulta de empleados fallo: ' . pg_last_error($link));
    
    $sqlTelefono = "SELECT * FROM Telefono_Emp WHERE id_empleado = $ID_u";
    $Telefono = pg_query($link, $sqlTelefono) or die('La consulta de telefonos fallo: ' . pg_last_error($link));;
    
    $telefonoEmpleado = '';
    while ($rowTelefono = pg_fetch_array($Telefono)) {
        $telefonoEmpleado = $rowTelefono['telefono'];
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" 
        rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" 
        crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.8.0/dist/sweetalert2.all.min.js"></script> 
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.8.0/dist/sweetalert2.min.css" rel="stylesheet">
    <title>Modificar empleado</title>
</head>
<body>
    <div class = "contenedor_principal">
        <div class="logotipo">
            <img src="../../Imagenes/coche.png" alt="Logo" width="45px" height="45px" class="d-inline-block align-text-top">
            <h1 class="titulo_logotipo">BUENAUTO</h1>
        </div>
        <div class = "segundo">
            <div class="cabecera">
                <h1 class="titulo">Editar empleado</h1>
            </div>
            <form method="POST" name = "formulario" class = "col-4 p-3 m-auto">
                <?php while ($fila = pg_fetch_array($registros)) { ?>
                    <input type="hidden" id="id" name="id" value="<?= $fila[0]; ?>">
                    
                    <div class="mb-1">
                        <label for="txtIdent" class="form-label">Número de identificación: </label>
                        <input type="number" value="<?= $fila[3]; ?>" class="form-control" id="txtIdent" name="txtIdent" placeholder="Identificación..." required>
                    </div>

                    <div class="mb-1">
                        <label for="txtNombre" class="form-label">Nombre del empleado: </label>
                        <input type="text" value="<?= $fila[4]; ?>" class="form-control" id="txtNombre" name="txtNombre" placeholder="Nombre..." required>
                    </div>

                    <div class="mb-1">
                        <label for="ListaCargos" class="form-label">Cargo: </label>
                        <select id="ListaCargos" name="ListaCargos" class="form-select" required>
                            <option selected>Seleccionar...</option>
                            <?php
                                while ($row_cargo = pg_fetch_object($Cargos)) {
                                    $selected = ($row_cargo->id == $fila[1]) ? 'selected' : ''; // Verifica si coincide con el valor que esta en la posición 7
                            ?>
                            <option value="<?php echo $row_cargo->id ?>" <?php echo $selected; ?>>
                                <?= $row_cargo->cargo; ?>
                            </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="mb-1">
                        <label for="ListaSucursales" class="form-label">Sucursal: </label>
                        <select id="ListaSucursales" name="ListaSucursales" class="form-select" required>
                            <option selected>Seleccionar...</option>
                            <?php
                                while ($row_sucursal = pg_fetch_object($Sucursales)) {
                                    $selected = ($row_sucursal->id == $fila[2]) ? 'selected' : ''; // Verifica si coincide con el valor que esta en la posición 7
                            ?>
                            <option value="<?php echo $row_sucursal->id ?>" <?php echo $selected; ?>>
                                <?= $row_sucursal->nombre; ?>
                            </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="mb-1">
                        <label for="txtNacimiento" class="form-label">Fecha de nacimiento: </label>
                        <input type="date" value="<?= $fila[5]; ?>" class="form-control" id="txtNacimiento" name="txtNacimiento" placeholder="Fecha de nacimiento..." required>
                    </div>

                    <div class="mb-1">
                        <label for="txtIngreso" class="form-label">Fecha de ingreso: </label>
                        <input type="date" value="<?= $fila[6]; ?>" class="form-control" id="txtIngreso" name="txtIngreso" placeholder="Fecha de ingreso..." required>
                    </div>

                    <div class="mb-1">
                        <label for="txtSalario" class="form-label">Salario: </label>
                        <input type="number" value="<?= $fila[7]; ?>" class="form-control" id="txtSalario" name="txtSalario" placeholder="Salario..." required>
                    </div>

                    <div class="mb-1">
                        <label for="txtTelefono" class="form-label">Telefono: </label>
                        <input type="number" value="<?= $telefonoEmpleado; ?>" class="form-control" id="txtTelefono" name="txtTelefono" placeholder="Telefono..." required>
                    </div>

                <?php } ?>
                <div class="col-md-2 d-flex justify-content-between" id="boton">
                    <input type="submit" class="btn" style="background-color:#38A843" value="ACTUALIZAR" id="btnActualizar" name="btnActualizar">
                </div>
            </form>
        </div>
    </div>
    <?php include '../../config/footer.php';?>
    <?php
        if(isset($_POST['btnActualizar'])){
            if(!empty($_POST['txtIdent']) && !empty($_POST['txtNombre']) && !empty($_POST['ListaCargos']) && !empty($_POST['ListaSucursales']) && !empty($_POST['txtNacimiento']) && !empty($_POST['txtIngreso']) && !empty($_POST['txtSalario']) && !empty($_POST['txtTelefono'])){
                $ID = $_POST['id'];
                $Identificacion = $_POST['txtIdent'];
                $Nombre = $_POST['txtNombre'];
                $Cargo = $_POST['ListaCargos'];
                $Sucursal = $_POST['ListaSucursales'];
                $FechaNacimiento = $_POST['txtNacimiento'];
                $FechaIngreso = $_POST['txtIngreso'];
                $Salario = $_POST['txtSalario'];
                $Telefono = $_POST['txtTelefono'];

                $sql_actualizar = "UPDATE empleado 
                SET id_cargo = $Cargo, id_sucursal = $Sucursal, identificacion = $Identificacion, nombre = '$Nombre', fecha_nacimiento = '$FechaNacimiento', fecha_ingreso = '$FechaIngreso', salario = $Salario
                WHERE codigo = $ID";
                $res = pg_query($link, $sql_actualizar) or die('La edición de datos fallo: ' . pg_last_error($link));

                $sqlActualizarTelefono = "UPDATE telefono_emp
                    SET telefono = '$Telefono'
                    WHERE id_empleado = $ID";

                $resTelefono = pg_query($link, $sqlActualizarTelefono);

                if($res && $resTelefono){

                    echo "<script type='text/javascript'>
                        Swal.fire({
                            title: '¡Los datos se actualizaron correctamente!',
                            width: 600,
                            padding: '2em',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        setTimeout(function() {
                            // Redirige o realiza otra acción después de cerrar la alerta
                            window.location.href = 'GestionEmpleados.php';
                        }, 1500);
                    </script>";  
                }else{
                    echo "<script type='text/javascript'>
                        Swal.fire({
                            title: 'ERROR!!',
                            text :'Algo salió mal y los datos no pudieron ser actualizados. Intente de nuevo.',
                            width: 600,
                            padding: '2em',
                            icon: 'error',
                            showConfirmButton: false,
                            timer: 1800
                        });
                        setTimeout(function() {
                            // Redirige o realiza otra acción después de cerrar la alerta
                            window.location.href = 'ModificarEmpleado.php';
                        }, 1800);
                    </script>";
                }
            }else{
                //Alerta de que hay campos vacios
                echo "<script type='text/javascript'>
                    Swal.fire({
                        title: 'ERROR!!',
                        text :'Hay campos vacíos. Intente de nuevo.',
                        width: 600,
                        padding: '2em',
                        icon: 'error',
                        showConfirmButton: false,
                        timer: 1800
                    });
                    setTimeout(function() {
                        // Redirige o realiza otra acción después de cerrar la alerta
                        window.location.href = 'ModificarEmpleado.php';
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