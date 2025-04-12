<div class="background-image" style="height:100%;min-height: 100vh;">
    <div class="field" style="position: absolute; top: 10px; right: 10px;">
        <a href="#" class="button is-link is-responsive btn-back" name="IrLogin">
            <i class="fas fa-arrow-left" style="margin-right: 7px;"></i>Regresar atrás
        </a>
        <?php include "inc/btn_back.php" ?>
    </div>
    <div class="box is-inline-block has-background-link-95 ml-3 mb-3 mt-2 p-4">
        <h1 class="title is-4 has-text-black has-text-centered">Producto</h1>
        <h2 class="subtitle has-text-black has-text-centered">Lista Productos</h2>
    </div>

    <div class="container pb-2">
        <?php 
            require_once "php/main.php";
            include "inc/script_confirm.php";

            if(isset($_GET['product_id_del'])){
                require_once "php/producto_eliminar.php";
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
            $url = "index.php?view=product_list&page=";
            $registros = 10;
            $busqueda = "";

            require_once "php/producto_lista.php";
        ?>
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
</div>