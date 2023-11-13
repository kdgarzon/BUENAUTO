<header>
    <nav class="navbar navbar-expand-lg" style = "background-color:#4682B4">
        <div class="container-fluid">
            <a class="navbar-brand d-flex" href="../Inicio/Inicio.php">
                <img src="../../Imagenes/coche.png" alt="Logo" width="45px" height="45px" class="d-inline-block align-text-top">
                <h1 class="titulo_logotipo">BUENAUTO</h1>
            </a>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="../Inicio/Inicio.php" style = "color:#FFF" id = "item">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../Usuarios/GestionUsuarios.php" style = "color:#FFF" id = "item">Usuarios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../Sucursales/GestionSucursales.php" style = "color:#FFF" id = "item">Sucursales</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../Empleados/GestionEmpleados.php" style = "color:#FFF" id = "item">Empleados</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../Clientes/GestionClientes.php" style = "color:#FFF" id = "item">Clientes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../Automotor/GestionAutomotores.php" style = "color:#FFF" id = "item">Automotores</a>
                    </li>
                    <!--<li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false" style = "color:#FFF" id = "item">
                            Animales
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="GestionAnimales.php">Gestión de animales</a></li>
                            <li><a class="dropdown-item" href="GestionFamilias.php">Gestión de familias</a></li>
                        </ul>
                    </li>-->
                </ul>
                <form class="float-sm-end" role="cerrarSesion" method="POST" action="../../config/CerrarSesion.php">
                    <button class="navbar-brand d-flex btn" type="submit" id = "boton" style = "background-color:#ADD8E6">
                        <img src="../../Imagenes/cerrar-sesion.png" alt="Logo" width="35px" height="35px" class="d-inline-block align-text-top">
                        <h6 class="ultimo">Cerrar Sesión</h6> 
                    </button>
                </form>
            </div>
        </div>
    </nav>
</header>