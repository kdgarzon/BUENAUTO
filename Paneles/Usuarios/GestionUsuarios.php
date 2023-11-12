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
    <title>Gestion de Usuarios</title>
</head>
<body>
    <?php include '../../config/header.php';?>
    <h1 class = "titulo_principal">Gestión de Usuarios</h1>
    <hr class="linea">
    <div class = "EntradaDatos">
        <form action="GestionUsuarios.php" method = "POST" name = "formulario" class = "row g-3">
            <h2 class = "tit">Información general</h2>
            <div class="col-md-4">
                <label for="txtEmp" class="form-label">Código del empleado:</label>
                <input type="number" class="form-control" id="txtEmp" name="txtEmp" placeholder="ID empleado..." required>
            </div>
            <div class="col-md-4">
                <label for="txtUser" class="form-label">Nombre del usuario: </label>
                <input type="text" class="form-control" placeholder="Username..." id="txtUser" name="txtUser" required>
            </div>
            <div class="col-md-4">
                <label for="txtPass" class="form-label">Contraseña: </label>
                <input type="password" class="form-control" placeholder="Password..." id="txtPass" name="txtPass" required>
            </div>
            <?php
                $sqlRoles = "SELECT ID, Rol FROM Rol";
                $Roles = pg_query($link, $sqlRoles) or die('La consulta de roles fallo: ' . pg_last_error($link));
            ?>
            <div class="col-md-6"><!--Lista desplegable-->
                <label for="ListaRoles" class="form-label">Rol: </label>
                <select id="ListaRoles" name="ListaRoles" class="form-select" required>
                    <option selected>Seleccionar...</option>
                    <?php
                    while ($row_rol = pg_fetch_object($Roles)) { ?>
                        <option value = "<?php echo $row_rol->id ?>"><?php echo $row_rol->rol; ?></option>;
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
                <th>ID Usuario</th>
                <th>Código del empleado</th>
                <th>Username</th>
                <th>Contraseña</th>
                <th>Rol</th>
                <th>Acciones</th>
            </thead>
            <?php
                $consultar = "SELECT u.id, e.nombre, u.username, u.pass, r.rol
                    FROM Usuario u
                    JOIN Empleado e ON u.Id_empleado = e.codigo
                    JOIN Rol r ON u.Id_rol = r.id
                    ORDER BY u.id ASC";
                $registros = pg_query($link, $consultar) or die('La consulta de usuarios fallo: ' . pg_last_error($link));

                while($fila = pg_fetch_array($registros)){ ?>
                    <tr>
                        <td><?= $fila[0]; ?></td>
                        <td><?= $fila[1]; ?></td>
                        <td><?= $fila[2]; ?></td>
                        <td><?= $fila[3]; ?></td>
                        <td><?= $fila[4]; ?></td>
                        <td>
                            <a href="ModificarUsuario.php?id=<?= $fila[0] ?>" class="btn btn-warning" style = "margin-right:7px;">
                                <img src = "../../Imagenes/editar.png" width = "20px" height = "20px">
                            </a>
                            <a href="GestionUsuarios.php?id=<?= $fila[0] ?>" class="btn btn-danger">
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
            $Codigo = $_POST['txtEmp'];
            $Usu = $_POST['txtUser'];
            $Contra = $_POST['txtPass'];
            $Rol = $_POST['ListaRoles'];

            //Formulo la consulta SQL
            $sql = "INSERT INTO usuario (id_empleado, username, pass, id_rol) 
                VALUES ('$Codigo', '$Usu', '$Contra', '$Rol');";

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
                        window.location.href = 'GestionUsuarios.php';
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
                        window.location.href = 'GestionUsuarios.php';
                    }, 1800);
                </script>";
            }
        }

        //ELIMINAR DATOS
        if(isset($_GET['id'])){
            $ID_u = (isset($_GET['id'])?$_GET['id']:"");
            
            //Formulamos la sentencia SQL
            $primer_sql = "SELECT * FROM usuario WHERE id = '".$ID_u."'";
            $registros = pg_query($link, $primer_sql) or die('La consulta de usuarios para eliminar fallo: ' . pg_last_error($link));

            if($respuesta = pg_fetch_array($registros)){
                //Formulamos la sentencia SQL
                $segundo_sql = "DELETE FROM usuario WHERE id = '".$ID_u."'";

                $link->pg_query($segundo_sql);
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
                        window.location.href = 'GestionUsuarios.php';
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
                        window.location.href = 'GestionUsuarios.php';
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