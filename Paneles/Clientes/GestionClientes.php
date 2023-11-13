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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" 
        rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" 
        crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.8.0/dist/sweetalert2.all.min.js"></script> 
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.8.0/dist/sweetalert2.min.css" rel="stylesheet">
    <title>Gestion de Clientes</title>
</head>
<body>
    <?php include '../../config/header.php';?>
    <h1 class = "titulo_principal">Gestión de Clientes</h1>
    <hr class="linea">
    <div class = "EntradaDatos">
        <form action="GestionClientes.php" method = "POST" name = "formulario" class = "row g-3">
            <h2 class = "tit">Información general</h2>
            <div class="col-md-4">
                <label for="txtIdentificacion" class="form-label">Número de identificación:</label>
                <input type="number" class="form-control" id="txtIdentificacion" name="txtIdentificacion" placeholder="Identificación..." required>
            </div>
            <div class="col-md-4">
                <label for="txtNombre" class="form-label">Nombre:</label>
                <input type="text" class="form-control" id="txtNombre" name="txtNombre" placeholder="Nombre del cliente..." required>
            </div>
            <?php
                $sqlCiudades = "SELECT ID, Ciudad FROM Ciudad_Residencia";
                $Ciudades = pg_query($link, $sqlCiudades) or die('La consulta de ciudades fallo: ' . pg_last_error($link));
            ?>
            <div class="col-md-4"><!--Lista desplegable-->
                <label for="ListaCiudades" class="form-label">Ciudad de Residencia: </label>
                <select id="ListaCiudades" name="ListaCiudades" class="form-select" required>
                    <option selected>Seleccionar...</option>
                    <?php
                    while ($row_ciudad = pg_fetch_object($Ciudades)) { ?>
                        <option value = "<?php echo $row_ciudad->id ?>"><?php echo $row_ciudad->ciudad; ?></option>;
                    <?php } 
                    ?>
                </select>
            </div>
            <div class="col-md-4">
                <label for="txtFechaRegistro" class="form-label">Fecha de Registro: </label>
                <input type="date" class="form-control" placeholder="Fecha de registro..." id="txtFechaRegistro" name="txtFechaRegistro" required>
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
                <th>Número de Identificación</th>
                <th>Nombre del cliente</th>
                <th>Ciudad de residencia</th>
                <th>Fecha de registro</th>
                <th>Acciones</th>
            </thead>
            <?php
                $consultar = "SELECT c.identificacion, c.nombre, cr.ciudad, c.fecha_registro
                    FROM Cliente c
                    JOIN Ciudad_Residencia cr ON c.id_ciudad = cr.id
                    ORDER BY c.identificacion ASC";
                $registros = pg_query($link, $consultar) or die('La consulta de clientes fallo: ' . pg_last_error($link));

                while($fila = pg_fetch_array($registros)){ ?>
                    <tr>
                        <td><?= $fila[0]; ?></td>
                        <td><?= $fila[1]; ?></td>
                        <td><?= $fila[2]; ?></td>
                        <td><?= $fila[3]; ?></td>
                        <td>
                            <a href="ModificarCliente.php?identificacion=<?= $fila[0] ?>" class="btn btn-warning" style = "margin-right:7px;">
                                <img src = "../../Imagenes/editar.png" width = "20px" height = "20px">
                            </a>
                            <a href="GestionClientes.php?identificacion=<?= $fila[0] ?>" class="btn btn-danger">
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
            $Identificacion = $_POST['txtIdentificacion'];
            $Nombre = $_POST['txtNombre'];
            $Ciudad = $_POST['ListaCiudades'];
            $FechaRegistro = $_POST['txtFechaRegistro'];

            //Formulo la consulta SQL
            $sql = "INSERT INTO cliente (identificacion, id_ciudad, nombre, fecha_registro) 
                VALUES ('$Identificacion', '$Ciudad', '$Nombre', '$FechaRegistro');";

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
                        window.location.href = 'GestionClientes.php';
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
                        window.location.href = 'GestionClientes.php';
                    }, 1800);
                </script>";
            }
        }

        //ELIMINAR DATOS
        if(isset($_GET['identificacion'])){
            $ID_u = (isset($_GET['identificacion'])?$_GET['identificacion']:"");
            
            //Formulamos la sentencia SQL
            $primer_sql = "SELECT * FROM cliente WHERE identificacion = '".$ID_u."'";
            $registros = pg_query($link, $primer_sql) or die('La consulta de clientes para eliminar fallo: ' . pg_last_error($link));

            if($respuesta = pg_fetch_array($registros)){
                //Formulamos la sentencia SQL
                $segundo_sql = "DELETE FROM cliente WHERE identificacion = '".$ID_u."'";

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
                        window.location.href = 'GestionClientes.php';
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
                        window.location.href = 'GestionClientes.php';
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