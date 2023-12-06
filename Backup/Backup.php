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

    function realizarBackup() {
        // Definir las credenciales de la base de datos
        $dbHost = 'tu_host';
        $dbNombre = 'nombre_de_tu_base_de_datos';
        $dbUsuario = 'tu_usuario';
        $dbPassword = 'tu_contraseña';

        // Crear el nombre del archivo de backup
        $fecha = new DateTime();
        $nombreArchivo = "backup_" . $fecha->format('Y-m-d_H-i-s') . ".sql";

        // Comando para realizar el backup
        $comando = "pg_dump -h $dbHost -U $dbUsuario $dbNombre > $nombreArchivo";

        // Ejecutar el comando
        system($comando, $output);
        
        // Aquí puedes agregar código para manejar la respuesta
    }

    if(isset($_POST['btnBackup'])){
        realizarBackup();
        // Código para mostrar una alerta de éxito o error después de realizar el backup
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include '../../config/encabezado.php';?>
    <title>Realizar Backup</title>
</head>
<body>
    <div class="contenedor_principal">
        <div class="logotipo">
            <img src="../../Imagenes/coche.png" alt="Logo" width="45px" height="45px" class="d-inline-block align-text-top">
            <h1 class="titulo_logotipo">BUENAUTO</h1>
        </div>
        <div class="segundo">
            <div class="cabecera">
                <h1 class="titulo">Backup de la Base de Datos</h1>
            </div>
            <form method="POST" class="col-4 p-3 m-auto">
                <div class="col-md-2 d-flex justify-content-between" id="boton">
                    <input type="submit" class="btn" style="background-color:#38A843" value="REALIZAR BACKUP" id="btnBackup" name="btnBackup">
                </div>
            </form>
        </div>
    </div>
    <?php include '../../config/footer.php';?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" 
        crossorigin="anonymous"></script>
</body>
</html>
