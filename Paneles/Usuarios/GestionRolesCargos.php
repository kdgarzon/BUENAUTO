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
    <title>Gestion de Usuarios</title>
    <style>
        .EntradaDatos, .informacion{
            margin-left: 8%;
            margin-right: 8%;
        }
    </style>
</head> 
<body>
    <?php include '../../config/header.php';?> 
    
    <h1 class = "titulo_principal">Gestión de Roles y Cargos</h1>
    <!-- Formulario para agregar cargos -->
    <div class="EntradaDatos">
        <form action="GestionRolesCargos.php" method="POST" name="formularioCargo" class="row g-3">
            <h2 class="tit">Cargos</h2>
            <div class="col-md-4">
                <label for="txtCargo" class="form-label">Nombre del Cargo: </label>
                <input type="text" class="form-control" placeholder="Cargo..." id="txtCargo" name="txtCargo" required>
            </div>
            <div class="col-md-2" id="botonCargo">
                <input type="submit" class="btn" style="background-color:#A6FB7E" value="INSERTAR" id="btnAgregarCargo" name="btnAgregarCargo">
            </div>
            <div class="col-md-2" id="botonBorrarCargo">
                <input type="reset" class="btn" style="background-color:#F6DB4C" value="RESTABLECER CAMPOS" id="btnBorrarCargo" name="btnBorrarCargo">
            </div>
        </form>
    </div>

    <!-- Tabla para mostrar cargos existentes -->
    <div class="informacion">
        <h2 class="tit">Registros de Cargos</h2>
        <table class="table table-striped">
            <thead class="table-light">
                <th>ID Cargo</th>
                <th>Nombre del Cargo</th>  
                <th>Acciones</th>             
            </thead>
            <?php
                $consultarCargo = "SELECT c.id, c.cargo FROM cargo c ORDER BY c.id ASC;";
                $registrosCargo = pg_query($link, $consultarCargo) or die('La consulta de cargos falló: ' . pg_last_error($link));

                while($filaCargo = pg_fetch_array($registrosCargo)){ ?>
                    <tr>
                        <td><?= $filaCargo[0]; ?></td>
                        <td><?= $filaCargo[1]; ?></td>                       
                        <td>
                            <a href="ModificarCargo.php?id=<?= $filaCargo[0] ?>" class="btn btn-warning" style = "margin-right:7px;">
                                <img src = "../../Imagenes/editar.png" width = "20px" height = "20px">
                            </a>
                            <a href="GestionRolesCargos.php?idCargo=<?= $filaCargo[0] ?>&accion=eliminarCargo" class="btn btn-danger">
                                <img src = "../../Imagenes/eliminar.png" width = "20px" height = "20px">
                            </a>
                        </td>
                    </tr>
                <?php } ?>
        </table>
    </div>
    <hr class="linea">
    </div>
    <hr class="linea">
    <div class = "EntradaDatos">
        <form action="GestionRolesCargos.php" method = "POST" name = "formulario" class = "row g-3">
            <h2 class = "tit">Roles</h2>
            <div class="col-md-4">
                <label for="txtRol" class="form-label">Rol del empleado: </label>
                <input type="text" class="form-control" placeholder="Rol..." id="txtRol" name="txtRol" required>
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
                <th>ID Rol</th>
                <th>Rol del empleado</th>  
                <th>Acciones</th>             
            </thead>
            <?php
                $consultar = "SELECT r.id, r.rol
                FROM rol r 
                ORDER BY r.id ASC;";                
                $registros = pg_query($link, $consultar) or die('La consulta de roles fallo: ' . pg_last_error($link));

                while($fila = pg_fetch_array($registros)){ ?>
                    <tr>
                        <td><?= $fila[0]; ?></td>
                        <td><?= $fila[1]; ?></td>                       
                        <td>
                            <a href="ModificarRol.php?id=<?= $fila[0] ?>" class="btn btn-warning" style = "margin-right:7px;">
                                <img src = "../../Imagenes/editar.png" width = "20px" height = "20px">
                            </a>
                            <a href="GestionRolesCargos.php?id=<?= $fila[0] ?>" class="btn btn-danger">
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
            $Rol = $_POST['txtRol'];

            //Formulo la consulta SQL
            $sql = "INSERT INTO rol (rol) 
                VALUES ('$Rol');";

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
                        window.location.href = 'GestionRolesCargos.php';
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
                        window.location.href = 'GestionRolesCargos.php';
                    }, 1800);
                </script>";
            }
        }

        //ELIMINAR DATOS
        if(isset($_GET['id'])){
            $ID_u = (isset($_GET['id'])?$_GET['id']:"");
            
            //Formulamos la sentencia SQL
            $primer_sql = "SELECT * FROM rol WHERE id = '".$ID_u."'";
            $registros = pg_query($link, $primer_sql) or die('La consulta de usuarios para eliminar fallo: ' . pg_last_error($link));

            if($respuesta = pg_fetch_array($registros)){
                //Formulamos la sentencia SQL
                $segundo_sql = "DELETE FROM rol WHERE id = '".$ID_u."'";

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
                        window.location.href = 'GestionRolesCargos.php';
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
                        window.location.href = 'GestionRolesCargos.php';
                    }, 1800);
                </script>";
            }
        }
    ?>
  
  <?php
    //INSERTAR DATOS PARA CARGOS
    if(isset($_POST['btnAgregarCargo'])){
        $Cargo = $_POST['txtCargo'];
        $sqlCargo = "INSERT INTO cargo (cargo) VALUES ('$Cargo');";
        $respuestaCargo = pg_query($link, $sqlCargo);
        if($respuestaCargo){
            echo "<script type='text/javascript'>
                Swal.fire({
                    title: '¡Cargo insertado correctamente!',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 1500
                });
                setTimeout(function() {
                    window.location.href = 'GestionRolesCargos.php';
                }, 1500);
            </script>";
        } else {
            echo "<script type='text/javascript'>
                Swal.fire({
                    title: 'ERROR!!',
                    text :'Algo salió mal y el cargo no pudo ser insertado. Intente de nuevo.',
                    icon: 'error',
                    showConfirmButton: false,
                    timer: 1800
                });
                setTimeout(function() {
                    window.location.href = 'GestionRolesCargos.php';
                }, 1800);
            </script>";
        }
    }

    //ELIMINAR DATOS PARA CARGOS
    if(isset($_GET['idCargo'])){
        $ID_c = $_GET['idCargo'];
        $sqlEliminarCargo = "DELETE FROM cargo WHERE id = '".$ID_c."'";
        $respuestaEliminarCargo = pg_query($link, $sqlEliminarCargo);
        if($respuestaEliminarCargo){
            echo "<script type='text/javascript'>
                Swal.fire({
                    title: '¡Cargo eliminado correctamente!',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 1800
                });
                setTimeout(function() {
                    window.location.href = 'GestionRolesCargos.php';
                }, 1800);
            </script>";
        } else {
            echo "<script type='text/javascript'>
                Swal.fire({
                    title: 'ERROR!!',
                    text: 'El cargo no pudo ser eliminado. Intente de nuevo.',
                    icon: 'error',
                    showConfirmButton: false,
                    timer: 1800
                });
                setTimeout(function() {
                    window.location.href = 'GestionRolesCargos.php';
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