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

    $sqlCiudades = "SELECT ID, Ciudad FROM Ciudad_Residencia";
    $Ciudades = pg_query($link, $sqlCiudades) or die('La consulta de ciudades fallo: ' . pg_last_error($link));

    $ID_u = (isset($_GET['identificacion'])?$_GET['identificacion']:"0");

    $sqlSeleccionar = "SELECT * FROM cliente WHERE identificacion = $ID_u";
    $registros = pg_query($link, $sqlSeleccionar) or die('La consulta de clientes fallo: ' . pg_last_error($link));
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
    <title>Modificar cliente</title>
</head>
<body>
    <div class = "contenedor_principal">
        <div class="logotipo">
            <img src="../../Imagenes/coche.png" alt="Logo" width="45px" height="45px" class="d-inline-block align-text-top">
            <h1 class="titulo_logotipo">BUENAUTO</h1>
        </div>
        <div class = "segundo">
            <div class="cabecera">
                <h1 class="titulo">Editar cliente</h1>
            </div>
            <form method="POST" name = "formulario" class = "col-4 p-3 m-auto">
                <?php while ($fila = pg_fetch_array($registros)) { ?>
                    <input type="hidden" id="id" name="id" value="<?= $fila[0]; ?>">
                    
                    <div class="mb-1">
                        <label for="txtNombre" class="form-label">Nombre del cliente: </label>
                        <input type="text" value="<?= $fila[2]; ?>" class="form-control" id="txtNombre" name="txtNombre" placeholder="Nombre..." required>
                    </div>

                    <div class="mb-1">
                        <label for="ListaCiudades" class="form-label">Ciudad de residencia: </label>
                        <select id="ListaCiudades" name="ListaCiudades" class="form-select" required>
                            <option selected>Seleccionar...</option>
                            <?php
                                while ($row_ciudad = pg_fetch_object($Ciudades)) {
                                    $selected = ($row_ciudad->id == $fila[1]) ? 'selected' : ''; // Verifica si coincide con el valor que esta en la posición 7
                            ?>
                            <option value="<?php echo $row_ciudad->id ?>" <?php echo $selected; ?>>
                                <?= $row_ciudad->ciudad; ?>
                            </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="mb-1">
                        <label for="txtFechaRegistro" class="form-label">Fecha de registro: </label>
                        <input type="date" value="<?= $fila[3]; ?>" class="form-control" id="txtFechaRegistro" name="txtFechaRegistro" placeholder="Fecha de registro..." required>
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
            if(!empty($_POST['txtNombre']) && !empty($_POST['ListaCiudades']) && !empty($_POST['txtFechaRegistro'])){
                $ID = $_POST['id'];
                $Nom = $_POST['txtNombre'];
                $Ciudad = $_POST['ListaCiudades'];
                $FechaRegistro = $_POST['txtFechaRegistro'];

                $sql_actualizar = "UPDATE cliente 
                SET id_ciudad = $Ciudad, nombre = '$Nom', fecha_registro = '$FechaRegistro'
                WHERE identificacion = $ID";
                $res = pg_query($link, $sql_actualizar) or die('La edición de datos fallo: ' . pg_last_error($link));

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
                            window.location.href = 'GestionClientes.php';
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
                            window.location.href = 'ModificarCliente.php';
                        }, 1800);
                    </script>";
                }
            }else{
                //Alerta de que hay campos vacios
                echo "<script type='text/javascript'>
                    Swal.fire({
                        title: 'ERROR!!',
                        text :'Hay campos vacíos. Intente de nuevo.',
                        width: 600,
                        padding: '2em',
                        icon: 'error',
                        showConfirmButton: false,
                        timer: 1800
                    });
                    setTimeout(function() {
                        // Redirige o realiza otra acción después de cerrar la alerta
                        window.location.href = 'ModificarCliente.php';
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