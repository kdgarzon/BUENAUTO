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

    if(isset($_POST['btnBackup'])){
        echo 'El boton fue presionado.';    
            // Definir las credenciales de la base de datos
            $dbHost = "localhost";
            $dbNombre = "concesionario";
            $dbUsuario = "postgres";
            $dbPassword = "123456";
    
            // Crear el nombre del archivo de backup
            $fecha = new DateTime();

            //$nombreArchivo = "backup_" . $fecha->format('Y-m-d_H-i-s') . ".sql";
    
            $nombreArchivo = __DIR__ . "/backup_" . $fecha->format('Y-m-d_H-i-s') . ".sql";

            // Comando para realizar el backup
            $comando = "pg_dump -h $dbHost -U $dbUsuario $dbNombre > $nombreArchivo";

            // Ejecutar el comando
            system($comando, $output);
    }


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include '../../config/encabezado.php';?>
    <title>Inicio</title>
</head>
<body>
    <?php include '../../config/header.php';?>  
    <h1 class = "titulo_principal">Backup</h1>
    <hr class="linea">
    <div class="contenedor_principal">
        <div class="segundo">
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