<div class="background-image" style="height:100%;min-height: 100vh">
    <div class="columns">      
        <?php
            require_once "php/main.php";
            include "inc/script_confirm.php";

            if(isset($_GET['busqueda']) && !empty($_GET['busqueda'])){
                unset($_SESSION['search_op']);
                $_SESSION['busqueda_factura_1'] = $_GET['busqueda'];
                $busqueda_cliente = $_GET['busqueda'];
                $check_cliente = conexion();
                $check_cliente = $check_cliente->query("SELECT * FROM cliente WHERE cliente_cedula = $busqueda_cliente");
                $check_cliente = $check_cliente->fetch();
                $cliente_id = $check_cliente['cliente_id'];
                $cliente_nombre = $check_cliente['cliente_nombre'];
                $cliente_cedula = $check_cliente['cliente_cedula'];
                $cliente_ubicacion = $check_cliente['cliente_ubicacion'];
                $cliente_telefono = $check_cliente['cliente_telefono'];

                $check_cliente = conexion();
                $check_cliente = $check_cliente->query("SELECT SUM(factura_monto) as monto_total, COUNT(factura_id) as total_facturas FROM factura WHERE cliente_id = $cliente_id");
                $check_cliente = $check_cliente->fetch();
                $cliente_total_facturas = $check_cliente['total_facturas'];
                $cliente_monto_total = $check_cliente['monto_total'];
                $cliente_monto_total = number_format($cliente_monto_total, 2, ',', '.');

                $check_cliente = conexion();
                $check_cliente = $check_cliente->query("SELECT SUM(factura_producto.producto_cantidad) as cantidad_total FROM factura_producto INNER JOIN factura ON factura_producto.factura_id = factura.factura_id INNER JOIN cliente ON factura.cliente_id = cliente.cliente_id WHERE factura.cliente_id = $cliente_id");
                $check_cliente = $check_cliente->fetch();
                $cliente_cantidad_total = $check_cliente['cantidad_total'];

                $check_cliente = conexion();
                $check_cliente = $check_cliente->query("SELECT SUM(factura_monto) as monto_total, COUNT(factura_id) as total_facturas FROM factura WHERE cliente_id = $cliente_id");

                $informacion = '
                    <div class="column is-one-quarter m-0 p-5">
                        <div class="box has-background-warning-95">
                            <p class="title is-4 mb-2 has-text-centered">Datos de '.$cliente_nombre.'</p>
                            <p class="subtitle is-4">N° de Facturas: '.$cliente_total_facturas.'</p>
                            <p class="subtitle is-4">Monto Total de las Facturas: $ '.$cliente_monto_total.'</p>
                            <p class="subtitle is-4">N° Total de Productos Comprados: '.$cliente_cantidad_total.'</p>
                        </div>
                    </div>
                ';
                echo $informacion;
            }

        ?>
        <div class="column <?php echo (isset($_GET['busqueda']) && !empty($_GET['busqueda'])) ? 'is-three-quarters' : 'is-full'; ?> m-0 p-4">
            <div class="field" style="position: absolute; top: 30px; right: 10px;">
                <a href="#" class="button is-link is-responsive btn-back" name="IrLogin">
                    <i class="fas fa-arrow-left" style="margin-right: 7px;"></i>Regresar atrás
                </a>
                <?php include "inc/btn_back.php" ?>
            </div>
            <div class="box is-inline-block has-background-link-95 ml-3 mb-0 mt-2 p-4">
                <h1 class="title is-4 has-text-black has-text-centered">Factura</h1>
                <h2 class="subtitle has-text-black has-text-centered">Lista Factura</h2>
            </div>
            <div class="section p-3"> 

                <?php                    
                
                    // Establecer un valor predeterminado para la opción seleccionada
                    $search_op = isset($_SESSION['search_op']) ? $_SESSION['search_op'] : 'cedula';

                    if(isset($_POST['search_op'])){
                        $_SESSION['search_op'] = $_POST['search_op'];
                    }
                    
                    if(isset($_POST['modulo_buscador'])){
                        require_once "php/buscador.php";
                    }         
                ?>
                <div class="columns">
                    <div class="column">
                        <form action="" method="POST" autocomplete="off">
                            <input type="hidden" name="modulo_buscador" value="factura_1">  
                            <div class="field is-grouped">
                                <div class="control">
                                    <div class="select">
                                        <select name="search_op">
                                            <option value="cedula" <?php echo ($search_op === 'cedula') ? 'selected' : ''; ?>>Cedula</option>
                                            <option value="nombre" <?php echo ($search_op === 'nombre') ? 'selected' : ''; ?>>Nombre</option>
                                            
                                        </select>
                                    </div>
                                </div>
                                <p class="control is-expanded">
                                    <input class="input is-rounded" type="text" name="txt_buscador" placeholder="Buscar..." pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}" maxlength="30" value="<?php echo isset($_SESSION['busqueda_factura_1']) ? htmlspecialchars($_SESSION['busqueda_factura_1']) : ''; ?>">
                                </p>
                                <p class="control">
                                    <button class="button is-link is-light" type="submit">
                                        <span class="icon">
                                            <i class="fas fa-search"></i>
                                        </span>
                                    </button>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
                    
                <div class="columns" style="margin-bottom:0px">
                    <div class="column">
                        <form class="has-text-centered" action="" method="POST" autocomplete="off" >
                            <input type="hidden" name="modulo_buscador" value="factura_1"> 
                            <input type="hidden" name="eliminar_buscador" value="factura_1">
                            
                            <?php
                                if(isset($_SESSION['busqueda_factura_1']) && !empty($_SESSION['busqueda_factura_1'])){
                                    echo '
                                        <div class="container is-fluid ">
                                            <span class="subtitle has-background-white p-2">Estas buscando: <strong>'.$_SESSION['busqueda_factura_1'].'</strong></span>
                                        </div>
                                        <hr style="margin:13px">
                                        <button type="submit" class="button is-link is-light is-rounded">Mostrar Todos los Registros</button>
                                    ' ;
                                    $busqueda = $_SESSION['busqueda_factura_1'];
                                }
                            ?>     
                        </form>
                    </div>
                </div>
                <?php 
                    if(isset($_GET['bill_id_del'])){
                        require_once "php/factura_eliminar.php";
                    }

                    if(!isset($_GET['page'])){
                        $pagina = 1;
                    }else{
                        $pagina = (int) $_GET['page'];
                        if($pagina<=1){
                            $pagina = 1;
                        }
                    }

                    $pagina = limpiar_cadena($pagina);
                    $url = "index.php?view=bill_search_op_1&page=";
                    $registros = 20;

                    require_once "php/factura_lista.php";

                ?>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="modal-js-confirm-1">
    <div class="modal-background"></div>
    <div class="modal-card">
        <header class="modal-card-head p-3">
            <p class="modal-card-title">Confirmación</p>
            <button class="delete" aria-label="close" onclick="closeModal('modal-js-confirm-1')"></button>
        </header>
        <section class="modal-card-body p-3">
            <p>¿Quieres Actualizar los Datos?</p>
        </section>
        <footer class="modal-card-foot p-3">
            <div class="buttons">
                <button class="button is-success is-responsive confirm-yes" data-href="">Sí</button>
                <button class="button is-danger is-responsive" onclick="closeModal('modal-js-confirm-1')">No</button>
            </div>
        </footer>
    </div>
</div>

<div class="modal" id="modal-js-confirm-2">
    <div class="modal-background"></div>
    <div class="modal-card">
        <header class="modal-card-head p-3">
            <p class="modal-card-title">Confirmación</p>
            <button class="delete" aria-label="close" onclick="closeModal('modal-js-confirm-2')"></button>
        </header>
        <section class="modal-card-body p-3">
            <p>¿Quieres Eliminar este Registro?</p>
        </section>
        <footer class="modal-card-foot p-3">
            <div class="buttons">
                <button class="button is-success is-responsive confirm-yes" data-href="">Sí</button>
                <button class="button is-danger is-responsive" onclick="closeModal('modal-js-confirm-2')">No</button>
            </div>
        </footer>
    </div>
</div>

