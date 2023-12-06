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
    <h1 class = "titulo_principal">Resumen de compras</h1>
    <hr class="linea">
    <div class="informacion">
        <h2 class = "tit">Registros</h2>
        <table class = "table table-striped">
            <thead class = "table-light">
                <th>ID Compra</th>
                <th>Cliente</th>
                <th>Sucursal</th>
                <th>Fecha de compra</th>
                <th>Valor</th>
                <th>Empleado</th>
                <th>Ciudad</th>
                <th>Fecha de registro</th>
                <th>Telefono</th>

            </thead>
            <?php
                $consultar = "SELECT * FROM Vista_Compra;";
                $registros = pg_query($link, $consultar) or die('La consulta de compras fallo: ' . pg_last_error($link));

                while($fila = pg_fetch_array($registros)){ ?>
                    <tr>
                        <td><?= $fila[0]; ?></td>
                        <td><?= $fila[1]; ?></td>
                        <td><?= $fila[2]; ?></td>
                        <td><?= $fila[3]; ?></td>
                        <td><?= number_format($fila[4]); ?></td>
                        <td><?= $fila[5]; ?></td>
                        <td><?= $fila[6]; ?></td>
                        <td><?= $fila[7]; ?></td>
                        <td><?= $fila[8]; ?></td>
                    </tr>
                <?php } ?>
        </table>
    </div>
</body>
</html>