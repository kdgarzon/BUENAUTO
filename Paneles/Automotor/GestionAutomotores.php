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
    <title>Gestion de Automotores</title>
    <style>
        .EntradaDatos, .informacion{
            margin-left: 8%;
            margin-right: 8%;
        }
    </style>
</head>
<body>
    <?php include '../../config/header.php';?>
    <h1 class = "titulo_principal">Gestión de Automotores</h1>
    <hr class="linea">
    <div class = "EntradaDatos">
        <form action="GestionAutomotores.php" method = "POST" name = "formulario" class = "row g-3">
            <h2 class = "tit">Información general</h2>
            <div class="col-md-4">
                <label for="txtNumChasis" class="form-label">Número de chasis:</label>
                <input type="text" class="form-control" id="txtNumChasis" name="txtNumChasis" placeholder="Número de chasis..." required>
            </div>
            <?php
                $sqlColores = "SELECT ID, Color FROM Color";
                $Colores = pg_query($link, $sqlColores) or die('La consulta de colores fallo: ' . pg_last_error($link));
            ?>
            <div class="col-md-4"><!--Lista desplegable-->
                <label for="ListaColores" class="form-label">Color: </label>
                <select id="ListaColores" name="ListaColores" class="form-select" required>
                    <option selected>Seleccionar...</option>
                    <?php
                    while ($row_color = pg_fetch_object($Colores)) { ?>
                        <option value = "<?php echo $row_color->id ?>"><?php echo $row_color->color; ?></option>;
                    <?php } 
                    ?>
                </select>
            </div>
            <?php
                $sqlLinea = "SELECT ID, Linea FROM Linea";
                $Linea = pg_query($link, $sqlLinea) or die('La consulta de líneas fallo: ' . pg_last_error($link));
            ?>
            <div class="col-md-4"><!--Lista desplegable-->
                <label for="ListaLinea" class="form-label">Línea: </label>
                <select id="ListaLinea" name="ListaLinea" class="form-select" required>
                    <option selected>Seleccionar...</option>
                    <?php
                    while ($row_linea = pg_fetch_object($Linea)) { ?>
                        <option value = "<?php echo $row_linea->id ?>"><?php echo $row_linea->linea; ?></option>;
                    <?php } 
                    ?>
                </select>
            </div>
            <?php
                $sqlTipos = "SELECT ID, Tipo FROM Tipo";
                $Tipos = pg_query($link, $sqlTipos) or die('La consulta de tipos fallo: ' . pg_last_error($link));
            ?>
            <div class="col-md-4"><!--Lista desplegable-->
                <label for="ListaTipo" class="form-label">Tipo: </label>
                <select id="ListaTipo" name="ListaTipo" class="form-select" required>
                    <option selected>Seleccionar...</option>
                    <?php
                    while ($row_tipo = pg_fetch_object($Tipos)) { ?>
                        <option value = "<?php echo $row_tipo->id ?>"><?php echo $row_tipo->tipo; ?></option>;
                    <?php } 
                    ?>
                </select>
            </div>
            <?php
                $sqlMarca = "SELECT ID, Marca FROM Marca";
                $Marca = pg_query($link, $sqlMarca) or die('La consulta de marcas fallo: ' . pg_last_error($link));
            ?>
            <div class="col-md-4"><!--Lista desplegable-->
                <label for="ListaMarca" class="form-label">Marca: </label>
                <select id="ListaMarca" name="ListaMarca" class="form-select" required>
                    <option selected>Seleccionar...</option>
                    <?php
                    while ($row_marca = pg_fetch_object($Marca)) { ?>
                        <option value = "<?php echo $row_marca->id ?>"><?php echo $row_marca->marca; ?></option>;
                    <?php } 
                    ?>
                </select>
            </div>
            <div class="col-md-4">
                <label for="txtModelo" class="form-label">Modelo: </label>
                <input type="number" class="form-control" placeholder="Modelo..." id="txtModelo" name="txtModelo" required>
            </div>
            <div class="col-md-4">
                <label for="txtIdentInterna" class="form-label">Número de Identificación interna: </label>
                <input type="text" class="form-control" placeholder="Identificación interna..." id="txtIdentInterna" name="txtIdentInterna">
            </div>
            <div class="col-md-4">
                <label for="txtPlaca" class="form-label">Placa: </label>
                <input type="text" class="form-control" placeholder="Placa..." id="txtPlaca" name="txtPlaca">
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
                <th>Número de Chasis</th>
                <th>Color</th>
                <th>Línea</th>
                <th>Tipo</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Identificación interna</th>
                <th>Placa</th>
                <th>Acciones</th>
            </thead>
            <?php
                $consultar = "SELECT * FROM Vista_Automotor;";
                $registros = pg_query($link, $consultar) or die('La consulta de automotores fallo: ' . pg_last_error($link));

                while($fila = pg_fetch_array($registros)){ ?>
                    <tr>
                        <td><?= $fila[0]; ?></td>
                        <td><?= $fila[1]; ?></td>
                        <td><?= $fila[2]; ?></td>
                        <td><?= $fila[3]; ?></td>
                        <td><?= $fila[4]; ?></td>
                        <td><?= $fila[5]; ?></td>
                        <td><?= $fila[6]; ?></td>
                        <td><?= $fila[7]; ?></td>
                        <td>
                            <a href="ModificarAutomotor.php?numero_chasis=<?= $fila[0] ?>" class="btn btn-warning" style = "margin-right:7px;">
                                <img src = "../../Imagenes/editar.png" width = "20px" height = "20px">
                            </a>
                            <a href="GestionAutomotores.php?numero_chasis=<?= $fila[0] ?>" class="btn btn-danger">
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
            $Chasis = $_POST['txtNumChasis'];
            $Color = $_POST['ListaColores'];
            $Linea = $_POST['ListaLinea'];
            $Tipo = $_POST['ListaTipo'];
            $Marca = $_POST['ListaMarca'];
            $Modelo = $_POST['txtModelo'];
            $Interna = $_POST['txtIdentInterna'];
            $Placa = $_POST['txtPlaca'];

            //Formulo la consulta SQL
            $sql = "INSERT INTO automotor (numero_chasis, id_color, id_linea, id_tipo, id_marca, modelo, identificacion_interna, placa) 
                VALUES ('$Chasis', '$Color', '$Linea', '$Tipo', '$Marca', '$Modelo', '$Interna', '$Placa');";

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
                        window.location.href = 'GestionAutomotores.php';
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
                        window.location.href = 'GestionAutomotores.php';
                    }, 1800);
                </script>";
            }
        }

        //ELIMINAR DATOS
        if(isset($_GET['numero_chasis'])){
            $ID_u = (isset($_GET['numero_chasis'])?$_GET['numero_chasis']:"");
            
            //Formulamos la sentencia SQL
            $primer_sql = "SELECT * FROM automotor WHERE numero_chasis = '".$ID_u."'";
            $registros = pg_query($link, $primer_sql) or die('La consulta de automotores para eliminar fallo: ' . pg_last_error($link));

            if($respuesta = pg_fetch_array($registros)){
                //Formulamos la sentencia SQL
                $segundo_sql = "DELETE FROM automotor WHERE numero_chasis = '".$ID_u."'";

                pg_query($link, $segundo_sql);
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
                        window.location.href = 'GestionAutomotores.php';
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
                        window.location.href = 'GestionAutomotores.php';
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