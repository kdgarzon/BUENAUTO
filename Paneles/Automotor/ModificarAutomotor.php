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

    $sqlColores = "SELECT ID, Color FROM Color";
    $Colores = pg_query($link, $sqlColores) or die('La consulta de colores fallo: ' . pg_last_error($link));

    $sqlLinea = "SELECT ID, Linea FROM Linea";
    $Linea = pg_query($link, $sqlLinea) or die('La consulta de líneas fallo: ' . pg_last_error($link));

    $sqlTipos = "SELECT ID, Tipo FROM Tipo";
    $Tipos = pg_query($link, $sqlTipos) or die('La consulta de tipos fallo: ' . pg_last_error($link));

    $sqlMarca = "SELECT ID, Marca FROM Marca";
    $Marca = pg_query($link, $sqlMarca) or die('La consulta de marcas fallo: ' . pg_last_error($link));

    $ID_u = (isset($_GET['numero_chasis'])?$_GET['numero_chasis']:"0");

    $sqlSeleccionar = "SELECT * FROM automotor WHERE numero_chasis = '$ID_u'";
    $registros = pg_query($link, $sqlSeleccionar) or die('La consulta de automotor fallo: ' . pg_last_error($link));
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
    <title>Modificar automotor</title>
</head>
<body>
    <div class = "contenedor_principal">
        <div class="logotipo">
            <img src="../../Imagenes/coche.png" alt="Logo" width="45px" height="45px" class="d-inline-block align-text-top">
            <h1 class="titulo_logotipo">BUENAUTO</h1>
        </div>
        <div class = "segundo">
            <div class="cabecera">
                <h1 class="titulo">Editar automotor</h1>
            </div>
            <form method="POST" name = "formulario" class = "col-4 p-3 m-auto">
                <?php while ($fila = pg_fetch_array($registros)) { ?>
                    <input type="hidden" id="id" name="id" value="<?= $fila[0]; ?>">

                    <div class="mb-1">
                        <label for="ListaColores" class="form-label">Color: </label>
                        <select id="ListaColores" name="ListaColores" class="form-select" required>
                            <option selected>Seleccionar...</option>
                            <?php
                                while ($row_color = pg_fetch_object($Colores)) {
                                    $selected = ($row_color->id == $fila[1]) ? 'selected' : ''; // Verifica si coincide con el valor que esta en la posición 7
                            ?>
                            <option value="<?php echo $row_color->id ?>" <?php echo $selected; ?>>
                                <?= $row_color->color; ?>
                            </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="mb-1">
                        <label for="ListaLinea" class="form-label">Linea: </label>
                        <select id="ListaLinea" name="ListaLinea" class="form-select" required>
                            <option selected>Seleccionar...</option>
                            <?php
                                while ($row_linea = pg_fetch_object($Linea)) {
                                    $selected = ($row_linea->id == $fila[2]) ? 'selected' : ''; // Verifica si coincide con el valor que esta en la posición 7
                            ?>
                            <option value="<?php echo $row_linea->id ?>" <?php echo $selected; ?>>
                                <?= $row_linea->linea; ?>
                            </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="mb-1">
                        <label for="ListaTipo" class="form-label">Tipo: </label>
                        <select id="ListaTipo" name="ListaTipo" class="form-select" required>
                            <option selected>Seleccionar...</option>
                            <?php
                                while ($row_tipo = pg_fetch_object($Tipos)) {
                                    $selected = ($row_tipo->id == $fila[3]) ? 'selected' : ''; // Verifica si coincide con el valor que esta en la posición 7
                            ?>
                            <option value="<?php echo $row_tipo->id ?>" <?php echo $selected; ?>>
                                <?= $row_tipo->tipo; ?>
                            </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="mb-1">
                        <label for="ListaMarca" class="form-label">Marca: </label>
                        <select id="ListaMarca" name="ListaMarca" class="form-select" required>
                            <option selected>Seleccionar...</option>
                            <?php
                                while ($row_marca = pg_fetch_object($Marca)) {
                                    $selected = ($row_marca->id == $fila[4]) ? 'selected' : ''; // Verifica si coincide con el valor que esta en la posición 7
                            ?>
                            <option value="<?php echo $row_marca->id ?>" <?php echo $selected; ?>>
                                <?= $row_marca->marca; ?>
                            </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="mb-1">
                        <label for="txtModelo" class="form-label">Modelo: </label>
                        <input type="number" value="<?= $fila[5]; ?>" class="form-control" id="txtModelo" name="txtModelo" placeholder="Modelo..." required>
                    </div>

                    <div class="mb-1">
                        <label for="txtIdentInterna" class="form-label">Número de identificación interna: </label>
                        <input type="text" value="<?= $fila[6]; ?>" class="form-control" id="txtIdentInterna" name="txtIdentInterna" placeholder="Identificación interna...">
                    </div>

                    <div class="mb-1">
                        <label for="txtPlaca" class="form-label">Placa: </label>
                        <input type="text" value="<?= $fila[7]; ?>" class="form-control" id="txtPlaca" name="txtPlaca" placeholder="Número de placa...">
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
            $Color = $_POST['ListaColores'];
            $Linea = $_POST['ListaLinea'];
            $Tipo = $_POST['ListaTipo'];
            $Marca = $_POST['ListaMarca'];
            $Modelo = $_POST['txtModelo'];
            $Interna = $_POST['txtIdentInterna'];
            $Placa = $_POST['txtPlaca'];

            $sql_actualizar = "UPDATE automotor 
                SET id_color = $Color, id_linea = $Linea, id_tipo = $Tipo, id_marca = $Marca, modelo = $Modelo, identificacion_interna = '$Interna', placa = '$Placa'
                WHERE numero_chasis = '$ID'";
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
                        window.location.href = 'GestionAutomotores.php';
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
                        window.location.href = 'ModificarAutomotor.php';
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