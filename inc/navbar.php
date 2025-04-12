
<style>
    .logo, .navbar-ite {
        width: 165px; /* Ancho del SVG original */
        height: 70px; /* Alto del SVG original */
    }
</style>

<nav class="navbar" role="navigation" aria-label="main navigation">
<div class="navbar-brand">
    <a class="navbar-ite p-0" href="index.php?view=home">
        <img src="img/logo_ferreteria_navbar.png" class="logo">
    </a>
    <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
    </a>
</div>

<div id="navbarBasicExample" class="navbar-menu">
    <div class="navbar-start">

        <a href="index.php?view=home" class="navbar-item">
            Inicio
        </a>

        <div class="navbar-item has-dropdown is-hoverable">
            <a class="navbar-link">Personas</a>

            <div class="navbar-dropdown">
                <a class="navbar-item" href="index.php?view=user_op">Usuario</a>           
                <a class="navbar-item" href="index.php?view=client_op">Clientes</a>
                <a class="navbar-item" href="index.php?view=supplier_op">Proveedores</a>
            </div>
        </div>

        <a class="navbar-item" href="index.php?view=bill_op"> Facturación </a>

        <div class="navbar-item has-dropdown is-hoverable">
            <a class="navbar-link">Servicios</a>
            
            <div class="navbar-dropdown">
                <a href="index.php?view=product_op" class="navbar-item">Productos</a>
                <a href="index.php?view=category_op" class="navbar-item">Categoria de Productos</a>             
            </div>
        </div>                 
            <?php 
                require_once "php/main.php";

                $check_product_stock = conexion();
                $check_product_stock = $check_product_stock->query("SELECT producto_stock FROM producto WHERE producto_stock = 0");
                $amount_alert = $check_product_stock->rowCount();

                if($check_product_stock->rowCount()>0){
                    $alert = '<i class="fa-solid fa-circle-exclamation has-text-danger"></i>';
                    $band = 1;
                }else{
                    $alert = '<i class="fa-solid fa-check has-text-success"></i>';
                    $band = 0;
                }
            ?>
        <a class="navbar-item" href="index.php?view=report_analysis_op"><?= $band == 1 ? $alert : ''?>Reportes y Analisis </a>     

    </div>
    <div class="navbar-end">
        <div class="navbar-item">
            <div class="buttons">
            <a href="index.php?view=user_update&user_id_up=<?= $_SESSION['id'];?>" class="button is-link is-rounded">
                Mi Cuenta
            </a>
            <a class="button is-danger is-rounded" href="index.php?view=logout">
                Salir
            </a>
            </div>
        </div>
    </div>
</div>
</nav>