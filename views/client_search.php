<div class="background-image" style="height:100%;min-height: 100vh;">
    <div class="field" style="position: absolute; top: 10px; right: 10px;">
        <a href="#" class="button is-link is-responsive btn-back" name="IrLogin">
            <i class="fas fa-arrow-left" style="margin-right: 7px;"></i>Regresar atrás
        </a>
        <?php include "inc/btn_back.php" ?>
    </div>
    <div class="box is-inline-block has-background-link-95 ml-3 mb-0 mt-2 p-4">
        <h1 class="title is-4 has-text-black has-text-centered">Cliente</h1>
        <h2 class="subtitle has-text-black has-text-centered">Buscar Clientes</h2>
    </div>

    <div class="container pb-3 pt-3">

        <?php
            require_once "php/main.php";
            include "inc/script_confirm.php";
        
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
                    <input type="hidden" name="modulo_buscador" value="cliente">  
                    <div class="field is-grouped">
                        <div class="control">
                            <div class="select">
                                <select name="search_op">
                                    <option value="cedula" <?php echo ($search_op === 'cedula') ? 'selected' : ''; ?>>Cédula</option>
                                    <option value="nombre" <?php echo ($search_op === 'nombre') ? 'selected' : ''; ?>>Nombre</option>
                                    <option value="ubicacion" <?php echo ($search_op === 'ubicacion') ? 'selected' : ''; ?>>Ubicación</option>
                                </select>
                            </div>
                        </div>
                        <p class="control is-expanded">
                            <input class="input is-rounded" type="text" name="txt_buscador" placeholder="Buscar..." pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}" maxlength="30" value="<?php echo isset($_SESSION['busqueda_cliente']) ? htmlspecialchars($_SESSION['busqueda_cliente']) : ''; ?>">
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
                    <input type="hidden" name="modulo_buscador" value="cliente"> 
                    <input type="hidden" name="eliminar_buscador" value="cliente">
                    
                    <?php
                        if(isset($_SESSION['busqueda_cliente'])){
                            echo '
                                <div class="container is-fluid">
                                    <span class="subtitle has-background-white p-2">Estas buscando: <strong>'.$_SESSION['busqueda_cliente'].'</strong></span>
                                </div>
                                <hr style="margin:13px">
                                <button type="submit" class="button is-link is-light is-rounded">Mostrar Todos los Registros</button>
                            ' ;
                            $busqueda = $_SESSION['busqueda_cliente'];
                        }
                    ?>     
                </form>
            </div>
        </div>
        
        <?php
            if(isset($_GET['user_id_del'])){
                require_once "php/cliente_eliminar.php";
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
            $url = "index.php?view=client_search&page=";
            $registros = 10;

            require_once "php/cliente_lista.php";  
        ?>
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