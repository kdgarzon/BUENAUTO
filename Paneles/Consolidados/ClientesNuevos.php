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
    <title>Clientes nuevos</title>
    <?php include '../../config/encabezado.php';?>
    <title>Compras</title>
    <style>
        .EntradaDatos, .informacion{
            margin-left: 8%;
            margin-right: 8%;
        }
    </style>
</head>
<body>
    <?php include '../../config/header.php';?>
    <div class="informacion">
        <h1 class = "titulo_principal">Consolidado clientes nuevos</h1>
        <hr class="linea">
        <p>
            A continuación se muestra el determinado reporte relacionado al 
            consolidado mensual de la cantidad de clientes nuevos a nivel nacional.
        </p>
        <h2 class = "tit">Registros</h2>
        <table class = "table table-striped">
            <thead class = "table-light">
                <th>ID</th>
                <th>Mes</th>
                <th>Cantidad (clientes nuevos)</th>
            </thead>
            <?php
                $consultar = "SELECT * FROM CantClientesNuevos;";
                $registros = pg_query($link, $consultar) or die('La consulta de clientes nuevos fallo: ' . pg_last_error($link));

                while($fila = pg_fetch_array($registros)){ ?>
                    <tr>
                        <td><?= $fila[0]; ?></td>
                        <td><?= $fila[1]; ?></td>
                        <td><?= $fila[2]; ?></td>
                    </tr>
                <?php } ?>
        </table>
    </div>
</body>
</html>