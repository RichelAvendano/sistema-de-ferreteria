<div class="background-image" style="height:100%;min-height: 100vh;">
    <div class="field" style="position: absolute; top: 10px; right: 10px;">
        <a href="#" class="button is-link is-responsive btn-back" name="IrLogin">
            <i class="fas fa-arrow-left" style="margin-right: 7px;"></i>Regresar atrás
        </a>
        <?php include "inc/btn_back.php" ?>
    </div>
    <div class="box is-inline-block has-background-link-95 ml-3 mb-3 mt-2 p-4">
        <h1 class="title is-4 has-text-black has-text-centered">Producto</h1>
        <h2 class="subtitle has-text-black has-text-centered">Lista Productos por Categorias</h2>
    </div>

    <div class="container pb-6 pt-4 ml-6 mr-6">
        <div class="columns">

            <?php 
                require_once "php/main.php";

            ?>
            <div class="column is-one-third">
                <h2 class="title has-text-centered has-background-warning-light p-3">Categorías</h2>
                
                <?php
                    $datos_categorias = conexion();
                    $datos_categorias = $datos_categorias->query("SELECT * FROM categoria");
                    if($datos_categorias->rowCount()>0){
                        $datos_categorias = $datos_categorias->fetchAll();
                        foreach($datos_categorias as $rows){
                            echo '<a href="index.php?view=product_category&category_id='.$rows['categoria_id'].'" class="button is-link is-inverted is-fullwidth mt-1 mb-1 is-inline-block ">'.$rows['categoria_nombre'].'</a>
    ';
                        }
                        
                    }else{
                        echo '
                            <p class="has-text-centered" >No hay categorías registradas</p>
                        ';
                    }
                    $datos_categorias=null;   
                ?>
            </div>
            <div class="column is-three-quarters is-flex is-flex-direction-column is-align-items-center has-text-centered">
                
                <?php 
                    $categoria_id= (isset($_GET['category_id'])) ? $_GET['category_id'] : 0;

                    $categoria = conexion();
                    $categoria = $categoria->query("SELECT * FROM categoria WHERE categoria_id='$categoria_id'");
                    if($categoria->rowCount()>0){
                        $categoria = $categoria->fetch();                   
                        echo '
                            <h2 class="title has-text-centered has-background-warning-light p-3 mb-0" style="width:430px">'.$categoria['categoria_nombre'].'</h2>
                            <p class="title is-6 has-text-centered has-background-warning-95 p-2 m-2" >Ubicacion: '.$categoria['categoria_ubicacion'].'</p>
                        ';

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
                        $url = "index.php?view=product_category&category_id=$categoria_id&page=";
                        $registros = 10;
                        $busqueda_categoria =  $categoria_id;
                
                        require_once "php/producto_lista.php";
                    }else{
                        echo '<h2 class="title has-text-centered has-background-warning-light p-3 mb-0" >Seleccione una Categoria para Empezar</h2>';
                    }
                    $categoria=null;
                ?>

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
</div>