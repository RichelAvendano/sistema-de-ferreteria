<style>
    .selected {
        background-color: #4CAF50; /* Color de fondo cuando el botón está seleccionado */
        color: white;
    }
</style>
<div class="background-image" style="height:100%;min-height: 100vh;" >
    <div class="field" style="position: absolute; top: 10px; right: 10px;">
        <a href="#" class="button is-link is-responsive btn-back" name="IrLogin">
            <i class="fas fa-arrow-left" style="margin-right: 7px;"></i>Regresar atrás
        </a>
        <?php include "inc/btn_back.php" ?>
    </div>
    <div class="box is-inline-block has-background-link-95 ml-3 mb-0 mt-2 p-4">
        <h1 class="title is-4 has-text-black has-text-centered">Factura</h1>
        <h2 class="subtitle has-text-black has-text-centered">Lista Factura</h2>
    </div>
    <div class="container pb-2 pt-2"> 
        <?php
            require_once "php/main.php";
            include "inc/script_confirm.php";
        
            // Establecer un valor predeterminado para la opción seleccionada
           
            $search_op = isset($_SESSION['search_op']) ? $_SESSION['search_op'] : 'fecha';

            if(isset($_POST['search_op'])){
                $_SESSION['search_op'] = $_POST['search_op'];
            }
            
            if(isset($_POST['modulo_buscador'])){
                require_once "php/buscador.php";
            }
            date_default_timezone_set('America/Caracas');

            // Obtener la fecha actual local
            $fecha_actual = date('Y-m-d');
            
            if(isset($_GET['busqueda'])){
                $fecha2 = $_GET['busqueda'];
                $_SESSION['busqueda_factura_2'] = "DESC";
            }
            
        ?>
        <div class="columns">
            <div class="column">
                <form action="" method="POST">
                    <input type="hidden" name="modulo_buscador" value="factura_2">
                    <input type="hidden" name="txt_buscador" id="hiddenInput" value="DESC">                                   

                    <div class="field is-grouped">
                        <div class="control">
                            
                            <div class="box p-2 subtitle has-background-link has-text-white">
                                Fecha
                            </div>
                        </div>
                        <p class="control"> 
                            <input class="input" type="date" name="date-time" value="<?= isset($_SESSION['fecha']) ? $_SESSION['fecha'] : $fecha_actual ?>">
                        </p>
                        <div class="control">
                            <button type="button" id="btnRecientes" class="button <?= (isset($_SESSION['busqueda_factura_2']) && $_SESSION['busqueda_factura_2'] == "DESC") ? "selected": "" ?>" onclick="selectButton('DESC')">Recientes</button>
                            <button type="button" id="btnAntiguos" class="button <?= (isset($_SESSION['busqueda_factura_2']) && $_SESSION['busqueda_factura_2'] == "ASC") ? "selected": "" ?>" onclick="selectButton('ASC')">Antiguos</button>
                        </div>
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
                    <input type="hidden" name="modulo_buscador" value="factura_2"> 
                    <input type="hidden" name="eliminar_buscador" value="factura_2">
                    
                    <?php
                        if(isset($_SESSION['busqueda_factura_2']) && !empty($_SESSION['busqueda_factura_2'])){
                            if(!isset($fecha2) && empty($fecha2)){
                                $fecha = $_SESSION['fecha'];
                                echo '
                                    <div class="container is-fluid">
                                        <span class="subtitle has-background-white p-2">Estas buscando: <strong>'.$fecha.'</strong></span>
                                    </div>
                                    <hr style="margin:13px">
                                    <button type="submit" class="button is-link is-light is-rounded">Mostrar Todos los Registros</button>
                                ' ;
                                $busqueda1 = $_SESSION['busqueda_factura_2'];
                            }else{
                                echo '
                                    <div class="container is-fluid">
                                        <span class="subtitle has-background-white p-2">Estas buscando: <strong>'.$fecha2.'</strong></span>
                                    </div>
                                    <hr style="margin:13px">
                                    <button type="submit" class="button is-link is-light is-rounded">Mostrar Todos los Registros</button>
                                ' ;
                                $busqueda1 = $_SESSION['busqueda_factura_2'];
                            }
                                
                            
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
            $url = "index.php?view=bill_search_op_2&page=";
            $registros = 20;

            require_once "php/factura_lista.php";

        ?>
    </div>
</div>

<script>
    function selectButton(buttonName) {
        var btnRecientes = document.getElementById('btnRecientes');
        var btnAntiguos = document.getElementById('btnAntiguos');
        var hiddenInput = document.getElementById('hiddenInput');

        if (buttonName === 'DESC') {
            btnRecientes.classList.add('selected');
            btnAntiguos.classList.remove('selected');
            hiddenInput.value = 'DESC';
        } else {
            btnRecientes.classList.remove('selected');
            btnAntiguos.classList.add('selected');
            hiddenInput.value = 'ASC';
        }
    }
</script>

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
