<?php
    session_start();
    include ('../config/Conexion.php');
    $link = conectar();
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
    <title>Login</title>
</head>
<body>
    <div class="card_principal">
        <div class = imagen>
            <img src="../Imagenes/Login.jpg" alt="Automovil" width="65%" height="80%">
            <h1 class="prin">Concesionario BUENAUTO</h1>
        </div>
        <?php
            $sqlRoles = "SELECT ID, Rol FROM Rol";
            $Roles = pg_query($link, $sqlRoles) or die('La consulta de roles fallo: ' . pg_last_error($link));
        ?>
        <form class = "entradas" method="POST" action="Login.php">
            <h1 class="primer_titulo">Bienvenido!</h1>
            <p class="subtitulo">Nos alegra tenerte de vuelta</p>
            <div class="mb-3">
                <label for="txtUser" class="form-label">Nombre de usuario: </label>
                <input type="text" class="form-control" id="txtUser" name="txtUser" placeholder="Username..." required>
            </div>
            <div class="mb-3">
                <label for="txtPass" class="form-label">Contraseña: </label>
                <input type="password" class="form-control" id="txtPass" name="txtPass" placeholder="Password..." required>
            </div>
            <select name="listaRoles" id="listaRoles" class="form-select" required>
                <option selected>Seleccionar...</option>
                <?php
                while ($row_rol = pg_fetch_object($Roles)) { ?>
                    <option value = "<?php echo $row_rol->id ?>"><?php echo $row_rol->rol; ?></option>;
                <?php } 
                ?>
            </select>
            <input type="submit" value="Iniciar Sesión" id="btnIngresar" name="btnIngresar">
        </form>
    </div>
    <?php include '../../config/footer.php';?>
    <?php
        if(isset($_POST['btnIngresar'])){
            // Obtengo los datos cargados en el formulario de login.
            $user = $_POST['txtUser'];
            $pass = $_POST['txtPass'];
            $rol = $_POST['listaRoles']; 
            $sql = "SELECT * FROM usuario WHERE id_rol = '$rol' AND username ='$user' AND pass = '$pass'";


            $queryusuario = pg_query($link, $sql) or die('La consulta para iniciar sesión fallo: ' . pg_last_error($link));
            $nr = pg_num_rows($queryusuario);

            if($nr > 0){
                $_SESSION['txtUser'] = $user;
                if($rol == 101){
                    header('Location: ../Paneles/Inicio/Inicio.php');
                    exit;
                }else
                if($rol == 102){
                    header('Location: Login.php');
                    exit;
                }
            }else{
                echo "<script type='text/javascript'>
                    Swal.fire({
                        title: 'ERROR!!',
                        text :'Usuario, contraseña o rol incorrecto. Intente de nuevo.',
                        width: 600,
                        padding: '2em',
                        icon: 'error',
                        showConfirmButton: false,
                        timer: 1800
                    });
                    setTimeout(function() {
                        // Redirige o realiza otra acción después de cerrar la alerta
                        window.location.href = 'Login.php';
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