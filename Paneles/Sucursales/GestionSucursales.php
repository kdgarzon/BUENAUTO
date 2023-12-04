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
    <title>Gestion de Sucursales</title>
</head>
<body>
    <?php include '../../config/header.php';?>
    <h1 class = "titulo_principal">Gestión de Sucursales</h1>
    <hr class="linea">
    <div class = "EntradaDatos">
        <form action="GestionSucursales.php" method = "POST" name = "formulario" class = "row g-3">
            <h2 class = "tit">Información general</h2>
            <div class="col-md-4">
                <label for="txtNombre" class="form-label">Nombre de la sucursal:</label>
                <input type="text" class="form-control" id="txtNombre" name="txtNombre" placeholder="Nombre..." required>
            </div>
            <?php
                $sqlEmpleados = "SELECT Codigo, Nombre FROM Empleado WHERE ID_cargo = 201";
                $Empleados = pg_query($link, $sqlEmpleados) or die('La consulta de empleados fallo: ' . pg_last_error($link));
            ?>
            <div class="col-md-4"><!--Lista desplegable-->
                <label for="ListaEmpleados" class="form-label">Gerente asignado: </label>
                <select id="ListaEmpleados" name="ListaEmpleados" class="form-select" required>
                    <option selected>Seleccionar...</option>
                    <?php
                    while ($row_emp = pg_fetch_object($Empleados)) { ?>
                        <option value = "<?php echo $row_emp->codigo ?>"><?php echo $row_emp->nombre; ?></option>;
                    <?php } 
                    ?>
                </select>
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
                <th>ID sucursal</th>
                <th>Nombre sucursal</th>
                <th>Gerente</th>
                <th>Acciones</th>
            </thead>
            <?php
                $consultar = "SELECT s.id, s.nombre, e.nombre
                    FROM Sucursal s
                    JOIN Empleado e ON s.id_gerente = e.codigo
                    ORDER BY s.id ASC";
                $registros = pg_query($link, $consultar) or die('La consulta de sucursales fallo: ' . pg_last_error($link));

                while($fila = pg_fetch_array($registros)){ ?>
                    <tr>
                        <td><?= $fila[0]; ?></td>
                        <td><?= $fila[1]; ?></td>
                        <td><?= $fila[2]; ?></td>
                        <td>
                            <a href="ModificarSucursal.php?id=<?= $fila[0] ?>" class="btn btn-warning" style = "margin-right:7px;">
                                <img src = "../../Imagenes/editar.png" width = "20px" height = "20px">
                            </a>
                            <a href="GestionSucursales.php?id=<?= $fila[0] ?>" class="btn btn-danger">
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
            $Nombre = $_POST['txtNombre'];
            $Gerente = $_POST['ListaEmpleados'];

            //Formulo la consulta SQL
            $sql = "INSERT INTO sucursal (id_gerente, nombre) 
                VALUES ('$Gerente', '$Nombre');";

            $respuesta = pg_query($link, $sql) or die('La inserción de datos fallo: ' . pg_last_error($link));

            if($respuesta){
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
                        // Redirige o realiza otra acción después de cerrar la alerta
                        window.location.href = 'GestionSucursales.php';
                    }, 1500);
                </script>";
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
                        window.location.href = 'GestionSucursales.php';
                    }, 1800);
                </script>";
            }
        }

        //ELIMINAR DATOS
        if(isset($_GET['id'])){
            $ID_u = (isset($_GET['id'])?$_GET['id']:"");
            
            //Formulamos la sentencia SQL
            $primer_sql = "SELECT * FROM sucursal WHERE id = '".$ID_u."'";
            $registros = pg_query($link, $primer_sql) or die('La consulta de sucursales para eliminar fallo: ' . pg_last_error($link));

            if($respuesta = pg_fetch_array($registros)){
                //Formulamos la sentencia SQL
                $segundo_sql = "DELETE FROM sucursal WHERE id = '".$ID_u."'";

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
                        window.location.href = 'GestionSucursales.php';
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
                        window.location.href = 'GestionSucursales.php';
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