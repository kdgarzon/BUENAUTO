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
<html lang="en">
<head>
<meta charset="UTF-8">
    <?php include '../../config/encabezado.php';?>
    <title>Linea y Tipo</title>
    <style>
        .EntradaDatos, .informacion{
            margin-left: 8%;
            margin-right: 8%;
        }
    </style>
</head>
<body>
    <?php include '../../config/header.php';?>
    <h1 class = "titulo_principal">Gestión de linea y tipo de automotor</h1>
    <hr class="linea">
    <div class = "ContenedorPrincipal">
        <div class="Linea">
            <div class = "EntradaDatos">
                <form action="LineaYTipo.php" method = "POST" name = "formulario" class = "row g-3">
                    <h2 class = "tit">Información general de la linea</h2>
                    <div class="col-md-4">
                        <label for="txtLinea" class="form-label">Linea del automotor</label>
                        <input type="text" class="form-control" id="txtLinea" name="txtLinea" placeholder="Linea..." required>
                    </div>
                    <div class="col-md-2" id = "boton">
                        <input type="submit" class = "btn" style = "background-color:#A6FB7E" value = "INSERTAR" id = "btnAgregarLinea" name = "btnAgregarLinea">
                    </div>
                    <div class="col-md-2" id = "boton">
                        <input type="reset" class = "btn" style = "background-color:#F6DB4C" value = "RESTABLECER CAMPOS" id = "btnBorrar" name = "btnBorrar">
                    </div>
                </form>
            </div>
            <div class = "informacion">
                <h2 class = "tit">Registro de linea</h2>
                <table class = "table table-striped">
                    <thead class = "table-light">
                        <th>ID linea</th>
                        <th>Linea</th>
                        <th>Acciones</th>
                    </thead>
                    <?php
                        $consultar = "SELECT * FROM Linea;";
                        $registros = pg_query($link, $consultar) or die('La consulta de linea de automotor fallo: ' . pg_last_error($link));

                        while($fila = pg_fetch_array($registros)){ ?>
                            <tr>
                                <td><?= $fila[0]; ?></td>
                                <td><?= $fila[1]; ?></td>
                                <td>
                                    <a href="ModificarLinea.php?ID=<?= $fila[0] ?>" class="btn btn-warning" style = "margin-right:7px;">
                                        <img src = "../../Imagenes/editar.png" width = "20px" height = "20px">
                                    </a>
                                    <a href="LineaYTipo.php?ID=<?= $fila[0] ?>" class="btn btn-danger">
                                        <img src = "../../Imagenes/eliminar.png" width = "20px" height = "20px">
                                    </a>
                                </td>
                            </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
        <div class="Tipo">
            <div class = "EntradaDatos">
                <form action="LineaYTipo.php" method = "POST" name = "formulario" class = "row g-3">
                    <h2 class = "tit">Información general del tipo de automotor</h2>
                    <div class="col-md-4">
                        <label for="txtTipo" class="form-label">Tipo:</label>
                        <input type="text" class="form-control" id="txtTipo" name="txtTipo" placeholder="Tipo..." required>
                    </div>
                    <div class="col-md-2" id = "boton">
                        <input type="submit" class = "btn" style = "background-color:#A6FB7E" value = "INSERTAR" id = "btnAgregarTipo" name = "btnAgregarTipo">
                    </div>
                    <div class="col-md-2" id = "boton">
                        <input type="reset" class = "btn" style = "background-color:#F6DB4C" value = "RESTABLECER CAMPOS" id = "btnBorrar" name = "btnBorrar">
                    </div>
                </form>
            </div>
            <div class = "informacion">
                <h2 class = "tit">Registro de Tipo</h2>
                <table class = "table table-striped">
                    <thead class = "table-light">
                        <th>ID</th>
                        <th>Tipo</th>
                        <th>Acciones</th>
                    </thead>
                    <?php
                        $consultar = "SELECT * FROM Tipo;";
                        $registros = pg_query($link, $consultar) or die('La consulta del tipo de automotor fallo: ' . pg_last_error($link));

                        while($fila = pg_fetch_array($registros)){ ?>
                            <tr>
                                <td><?= $fila[0]; ?></td>
                                <td><?= $fila[1]; ?></td>
                                <td>
                                    <a href="ModificarTipo.php?ID=<?= $fila[0] ?>" class="btn btn-warning" style = "margin-right:7px;">
                                        <img src = "../../Imagenes/editar.png" width = "20px" height = "20px">
                                    </a>
                                    <a href="LineaYTipo.php?ID=<?= $fila[0] ?>" class="btn btn-danger">
                                        <img src = "../../Imagenes/eliminar.png" width = "20px" height = "20px">
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                </table>
            </div>
        </div>    
    </div>
    <?php include '../../config/footer.php';?>
    <?php
        //INSERTAR DATOS
        if(isset($_POST['btnAgregarLinea'])){
            
            // Obtengo los datos cargados en el formulario de Linea Tipo
            $Linea = $_POST['txtLinea'];

            //Formulo la consulta SQL
            $sql = "INSERT INTO Linea (Linea) VALUES ('$Linea');";

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
                        window.location.href = 'LineaYTipo.php';
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
                        window.location.href = 'LineaYTipo.php';
                    }, 1800);
                </script>";
            }
        }

        // INSERTAR TIPO DE AUTOMOTOR

        if(isset($_POST['btnAgregarTipo'])){
            
            // Obtengo los datos cargados en el formulario de Linea Tipo
            $Tipo = $_POST['txtTipo'];

            //Formulo la consulta SQL
            $sql = "INSERT INTO Tipo (Tipo) VALUES ('$Tipo');";

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
                        window.location.href = 'LineaYTipo.php';
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
                        window.location.href = 'LineaYTipo.php';
                    }, 1800);
                </script>";
            }
        }

        //ELIMINAR DATOS DE LINEA
        if(isset($_GET['ID'])){
            $ID_Linea = (isset($_GET['ID'])?$_GET['ID']:"");
            
            //Formulamos la sentencia SQL
            $primer_sql = "SELECT * FROM Linea WHERE ID = '".$ID_Linea."'";
            $registros = pg_query($link, $primer_sql) or die('La consulta de Linea para eliminar fallo: ' . pg_last_error($link));
            if($respuesta = pg_fetch_array($registros)){
                //Formulamos la sentencia SQL
                $segundo_sql = "DELETE FROM Linea WHERE ID = '".$ID_Linea."'";

                pg_query($link, $segundo_sql);
                echo "<script type='text/javascript'>
                    Swal.fire({
                        title: '¡Datos eliminados correctamente!',
                        text: 'Los registros de LINEA fueron eliminados de manera exitosa',
                        width: 600,
                        padding: '2em',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 1800
                    });
                    setTimeout(function() {
                        // Redirige o realiza otra acción después de cerrar la alerta
                        window.location.href = 'LineaYTipo.php';
                    }, 1800);
                </script>";
            }else{

                echo "<script type='text/javascript'>
                    Swal.fire({
                        title: 'ERROR!!',
                        text :'Los registros DE LINEA no fueron eliminados.',
                        width: 600,
                        padding: '2em',
                        icon: 'error',
                        showConfirmButton: false,
                        timer: 1800
                    });
                    setTimeout(function() {
                        // Redirige o realiza otra acción después de cerrar la alerta
                        window.location.href = 'LineaYTipo.php';
                    }, 1800);
                </script>";
            }
        }

        // ELIMINAR DATOS TIPO

        if(isset($_GET['ID'])){
            $ID_Tipo = (isset($_GET['ID'])?$_GET['ID']:"");
            
            //Formulamos la sentencia SQL
            $primer_sql = "SELECT * FROM Tipo WHERE ID = '".$ID_Tipo."'";
            $registros = pg_query($link, $primer_sql) or die('La consulta de Tipo para eliminar fallo: ' . pg_last_error($link));
            
            if($respuesta = pg_fetch_array($registros)){
                //Formulamos la sentencia SQL
                $segundo_sql = "DELETE FROM Tipo WHERE ID = '".$ID_Tipo."'";

                pg_query($link, $segundo_sql);
                echo "<script type='text/javascript'>
                    Swal.fire({
                        title: '¡Datos eliminados correctamente!',
                        text: 'Los registros de TIPO fueron eliminados de manera exitosa',
                        width: 600,
                        padding: '2em',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 1800
                    });
                    setTimeout(function() {
                        // Redirige o realiza otra acción después de cerrar la alerta
                        window.location.href = 'LineaYTipo.php';
                    }, 1800);
                </script>";
            }else{
                echo "<script type='text/javascript'>
                    Swal.fire({
                        title: 'ADVERTENCIA ',
                        text :'Los registros DE TIPO no fueron eliminados, pero los de Linea si.',
                        width: 600,
                        padding: '2em',
                        icon: 'info',
                        showConfirmButton: false,
                        timer: 1800
                    });
                    setTimeout(function() {
                        // Redirige o realiza otra acción después de cerrar la alerta
                        window.location.href = 'LineaYTipo.php';
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