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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" 
        rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" 
        crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.8.0/dist/sweetalert2.all.min.js"></script> 
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.8.0/dist/sweetalert2.min.css" rel="stylesheet">
    <title>Color y Marca</title>
</head>
<body>
    <?php include '../../config/header.php';?>
    <h1 class = "titulo_principal">Gestión de linea y tipo de automotor</h1>
    <hr class="Color">
    <div class = "ContenedorPrincipal">
        <div class="Color">
            <div class = "EntradaDatos">
                <form action="ColorYMarca.php" method = "POST" name = "formulario" class = "row g-3">
                    <h2 class = "tit">Información general de Color</h2>
                    <div class="col-md-4">
                        <label for="txtColor" class="form-label">Color</label>
                        <input type="text" class="form-control" id="txtColor" name="txtColor" placeholder="Color..." required>
                    </div>
                    <div class="col-md-2" id = "boton">
                        <input type="submit" class = "btn" style = "background-color:#A6FB7E" value = "INSERTAR" id = "btnAgregarColor" name = "btnAgregarColor">
                    </div>
                    <div class="col-md-2" id = "boton">
                        <input type="reset" class = "btn" style = "background-color:#F6DB4C" value = "RESTABLECER CAMPOS" id = "btnBorrar" name = "btnBorrar">
                    </div>
                </form>
            </div>
            <div class = "informacion">
                <h2 class = "tit">Registro de Color</h2>
                <table class = "table table-striped">
                    <thead class = "table-light">
                        <th>ID Color</th>
                        <th>Color</th>
                        <th>Acciones</th>
                    </thead>
                    <?php
                        $consultar = "SELECT * FROM Color;";
                        $registros = pg_query($link, $consultar) or die('La consulta de Color de automotor fallo: ' . pg_last_error($link));

                        while($fila = pg_fetch_array($registros)){ ?>
                            <tr>
                                <td><?= $fila[0]; ?></td>
                                <td><?= $fila[1]; ?></td>
                                <td>
                                    <a href="ModificarColor.php?ID=<?= $fila[0] ?>" class="btn btn-warning" style = "margin-right:7px;">
                                        <img src = "../../Imagenes/editar.png" width = "20px" height = "20px">
                                    </a>
                                    <a href="ColorYMarca.php?ID=<?= $fila[0] ?>" class="btn btn-danger">
                                        <img src = "../../Imagenes/eliminar.png" width = "20px" height = "20px">
                                    </a>
                                </td>
                            </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
        <div class="Marca">
            <div class = "EntradaDatos">
                <form action="ColorYMarca.php" method = "POST" name = "formulario" class = "row g-3">
                    <h2 class = "tit">Información de Marca del automotor</h2>
                    <div class="col-md-4">
                        <label for="txtMarca" class="form-label">Marca:</label>
                        <input type="text" class="form-control" id="txtMarca" name="txtMarca" placeholder="Marca..." required>
                    </div>
                    <div class="col-md-2" id = "boton">
                        <input type="submit" class = "btn" style = "background-color:#A6FB7E" value = "INSERTAR" id = "btnAgregarMarca" name = "btnAgregarMarca">
                    </div>
                    <div class="col-md-2" id = "boton">
                        <input type="reset" class = "btn" style = "background-color:#F6DB4C" value = "RESTABLECER CAMPOS" id = "btnBorrar" name = "btnBorrar">
                    </div>
                </form>
            </div>
            <div class = "informacion">
                <h2 class = "tit">Registro de Marca</h2>
                <table class = "table table-striped">
                    <thead class = "table-light">
                        <th>ID</th>
                        <th>Tipo</th>
                        <th>Acciones</th>
                    </thead>
                    <?php
                        $consultar = "SELECT * FROM Marca;";
                        $registros = pg_query($link, $consultar) or die('La consulta del tipo de automotor fallo: ' . pg_last_error($link));

                        while($fila = pg_fetch_array($registros)){ ?>
                            <tr>
                                <td><?= $fila[0]; ?></td>
                                <td><?= $fila[1]; ?></td>
                                <td>
                                    <a href="ModificarMarca.php?ID=<?= $fila[0] ?>" class="btn btn-warning" style = "margin-right:7px;">
                                        <img src = "../../Imagenes/editar.png" width = "20px" height = "20px">
                                    </a>
                                    <a href="ColorYMarca.php?ID=<?= $fila[0] ?>" class="btn btn-danger">
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
        if(isset($_POST['btnAgregarColor'])){
            
            // Obtengo los datos cargados en el formulario de Linea Tipo
            $Color = $_POST['txtColor'];

            //Formulo la consulta SQL
            $sql = "INSERT INTO Color (Color) VALUES ('$Color');";

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
                        window.location.href = 'ColorYMarca.php';
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
                        window.location.href = 'ColorYMarca.php';
                    }, 1800);
                </script>";
            }
        }

        // INSERTAR MARCA DE AUTOMOTOR

        if(isset($_POST['btnAgregarMarca'])){
            
            // Obtengo los datos cargados en el formulario de Linea Tipo
            $Marca = $_POST['txtMarca'];

            //Formulo la consulta SQL
            $sql = "INSERT INTO Marca (Marca) VALUES ('$Marca');";

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
                        window.location.href = 'ColorYMarca.php';
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
                        window.location.href = 'ColorYMarca.php';
                    }, 1800);
                </script>";
            }
        }

        //ELIMINAR DATOS DEL COLOR
        if(isset($_GET['ID'])){
            $ID_Color = (isset($_GET['ID'])?$_GET['ID']:"");
            
            //Formulamos la sentencia SQL
            $primer_sql = "SELECT * FROM Color WHERE ID = '".$ID_Color."'";
            $registros = pg_query($link, $primer_sql) or die('La consulta de Linea para eliminar fallo: ' . pg_last_error($link));
            if($respuesta = pg_fetch_array($registros)){
                //Formulamos la sentencia SQL
                $segundo_sql = "DELETE FROM Color WHERE ID = '".$ID_Color."'";

                pg_query($link, $segundo_sql);
                echo "<script type='text/javascript'>
                    Swal.fire({
                        title: '¡Datos eliminados correctamente!',
                        text: 'Los registros de Color fueron eliminados de manera exitosa',
                        width: 600,
                        padding: '2em',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 1800
                    });
                    setTimeout(function() {
                        // Redirige o realiza otra acción después de cerrar la alerta
                        window.location.href = 'ColorYMarca.php';
                    }, 1800);
                </script>";
            }else{

                echo "<script type='text/javascript'>
                    Swal.fire({
                        title: 'ERROR!!',
                        text :'Los registros de Color no fueron eliminados.',
                        width: 600,
                        padding: '2em',
                        icon: 'error',
                        showConfirmButton: false,
                        timer: 1800
                    });
                    setTimeout(function() {
                        // Redirige o realiza otra acción después de cerrar la alerta
                        window.location.href = 'ColorYMarca.php';
                    }, 1800);
                </script>";
            }
        }

        // ELIMINAR DATOS MARCA

        if(isset($_GET['ID'])){
            $ID_Marca = (isset($_GET['ID'])?$_GET['ID']:"");
            
            //Formulamos la sentencia SQL
            $primer_sql = "SELECT * FROM Marca WHERE ID = '".$ID_Marca."'";
            $registros = pg_query($link, $primer_sql) or die('La consulta de Marca para eliminar fallo: ' . pg_last_error($link));
            
            if($respuesta = pg_fetch_array($registros)){
                //Formulamos la sentencia SQL
                $segundo_sql = "DELETE FROM Marca WHERE ID = '".$ID_Marca."'";

                pg_query($link, $segundo_sql);
                echo "<script type='text/javascript'>
                    Swal.fire({
                        title: '¡Datos eliminados correctamente!',
                        text: 'Los registros de Marca fueron eliminados de manera exitosa',
                        width: 600,
                        padding: '2em',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 1800
                    });
                    setTimeout(function() {
                        // Redirige o realiza otra acción después de cerrar la alerta
                        window.location.href = 'ColorYMarca.php';
                    }, 1800);
                </script>";
            }else{
                echo "<script type='text/javascript'>
                    Swal.fire({
                        title: 'ADVERTENCIA ',
                        text :'Los registros de Color no fueron eliminados, pero los de Marca si.',
                        width: 600,
                        padding: '2em',
                        icon: 'info',
                        showConfirmButton: false,
                        timer: 1800
                    });
                    setTimeout(function() {
                        // Redirige o realiza otra acción después de cerrar la alerta
                        window.location.href = 'ColorYMarca.php';
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