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

    $ID_u = (isset($_GET['ID'])?$_GET['ID']:"0");

    $sqlSeleccionar = "SELECT * FROM Color WHERE ID = $ID_u";
    $registros = pg_query($link, $sqlSeleccionar) or die('La consulta de el Color fallo: ' . pg_last_error($link));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include '../../config/encabezado.php';?>
    <title>Modificar Color</title>
</head>
<body>
    <div class = "contenedor_principal">
        <div class="logotipo">
            <img src="../../Imagenes/coche.png" alt="Logo" width="45px" height="45px" class="d-inline-block align-text-top">
            <h1 class="titulo_logotipo">BUENAUTO</h1>
        </div>
        <div class = "segundo">
            <div class="cabecera">
                <h1 class="titulo">Editar Color</h1>
            </div>
            <form method="POST" name = "formulario" class = "col-4 p-3 m-auto">
                <?php while ($fila = pg_fetch_array($registros)) { ?>
                    <input type="hidden" id="id" name="id" value="<?= $fila[0]; ?>">

                    <div class="mb-1">
                        <label for="txtColor" class="form-label">Color: </label>
                        <input type="text" value="<?= $fila[1]; ?>" class="form-control" id="txtColor" name="txtColor" placeholder="Color..." required>
                    </div>

                <?php } ?>
                <div class="col-md-2 d-flex justify-content-between" id="boton">
                    <input type="submit" class="btn" style="background-color:#38A843" value="ACTUALIZAR" id="btnActualizar" name="btnActualizar">
                </div>
            </form>
        </div>
    </div>
    <?php include '../../config/footer.php';?>
    <?php
        if(isset($_POST['btnActualizar'])){
            $ID = $_POST['id'];
            $Color = $_POST['txtColor'];

            $sql_actualizar = "UPDATE Color
                SET id = $ID, Color = '$Color'
                WHERE id = '$ID'";
            $res = pg_query($link, $sql_actualizar) or die('La edición de datos de Linea fallo: ' . pg_last_error($link));

            if($res){
                echo "<script type='text/javascript'>
                    Swal.fire({
                        title: '¡Los datos se actualizaron correctamente!',
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
                        text :'Algo salió mal y los datos no pudieron ser actualizados. Intente de nuevo.',
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
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" 
        crossorigin="anonymous"></script>
</body>
</html>