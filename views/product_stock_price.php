<div class = "background-image" style="height: 100%;min-height: 100vh;">
    <div class="field" style="position: absolute; top: 20px; right: 10px;">
        <a href="#" class="button is-link is-responsive btn-back" name="IrLogin">
            <i class="fas fa-arrow-left" style="margin-right: 7px;"></i>Regresar atrás
        </a>
        <?php include "inc/btn_back.php" ?>
    </div>
    
    <div class="columns is-mobile is-centered" style="width:68%">
        <div class="column is-half">

            <div class="box is-inline-block has-background-link-95 ml-3 mb-3 mt-2 p-4">
                <h1 class="title is-4 has-text-black has-text-centered">Producto</h1>
                <h2 class="subtitle has-text-black has-text-centered">Buscar Productos</h2>
            </div>

        </div>
        <div class="column is-half">
            <?php 
                require_once "php/main.php";
                include "inc/script_confirm.php";

                // Establecer un valor predeterminado para la opción seleccionada

                if(isset($_GET['alert_product']) && !empty($_GET['alert_product']) && isset($_GET['alert_product'])==1){
                    $_SESSION["txt_min"] = 0;
                    $_SESSION["txt_max"] = 0;
                    
                }

                if(isset($_POST['rango_valor'])){
                    $_SESSION['rango_valor'] = $_POST['rango_valor'];
                }
                $rango_valor = isset($_SESSION['rango_valor']) ? $_SESSION['rango_valor'] : 'rango';
                    

                if(isset($_POST['search_op'])){
                    $_SESSION['search_op'] = $_POST['search_op'];
                }
                $search_op = isset($_SESSION['search_op']) ? $_SESSION['search_op'] : 'stock';
                
                $rango_valor_hidden = isset($_SESSION['rango_valor']) ? $_SESSION['rango_valor'] : 'rango';
                
                if(isset($_POST['modulo_buscador'])){
                    require_once "php/buscador_stock_price.php";
                } 

                $check_product_stock = conexion();
                $check_product_stock = $check_product_stock->query("SELECT producto_stock FROM producto WHERE producto_stock = 0");
                $amount_alert = $check_product_stock->rowCount();

                if($check_product_stock->rowCount()>0){
                echo '
                    <div class="pt-0 pb-3 mt-3 is-flex is-align-items-center is-flex-direction-column">
                        <div class="box has-background-danger-60 title is-5 has-text-white has-text-center mb-0 p-2" style="text-align:center;width:300px">! Alerta !</div>
                        <div class="box has-background-danger-80 title is-6 has-text-white has-text-center p-2" style="text-align:center;width:300px">
                            <p>'.$amount_alert.' Productos se Encuentran con Inventario en 0</p>
                            <a class="button is-warning p-2 mt-2 title is-6 has-text-white" href="index.php?view=product_stock_price&alert_product=1"><i class="fa-solid fa-magnifying-glass-arrow-right"></i> Ver Productos</a>
                        </div>                       
                              
                    </div>
                ';
                $check_product_stock = null;
                }

            ?>
        </div>
    </div>
    
    <div class="container pb-2">
        
        <div class="columns">
            <div class="column">
                <form action="" method="POST" autocomplete="off">
                    <input type="hidden" name="modulo_buscador" value="producto_stock_price">  
                    <div class="field is-grouped">
                        <div class="control">
                            <div class="select">
                                <select name="search_op" >
                                    
                                    <option value="stock" <?php echo (isset($search_op) && $search_op  === 'stock') ? 'selected' : ''; ?>>Inventario</option>
                                    <option value="precio" <?php echo (isset($search_op) && $search_op  === 'precio') ? 'selected' : ''; ?>>Precio</option>
                                </select>
                            </div>
                        </div>
                        <div class="control">
                            <div class="select">
                                <select name="rango_valor" id="miSelect" onchange="actualizarClase()">
                                    <option value="rango" <?php echo (isset($rango_valor_hidden) && $rango_valor_hidden === 'rango') ? 'selected' : ''; ?>>Rango Personalizado</option>
                                    <option value="0 10" <?php echo (isset($rango_valor_hidden) && $rango_valor_hidden === '0 10') ? 'selected' : ''; ?>>0 a 10</option>
                                    <option value="10 25" <?php echo (isset($rango_valor_hidden) && $rango_valor_hidden === '10 25') ? 'selected' : ''; ?>>10 a 25</option>
                                    <option value="25 50" <?php echo (isset($rango_valor_hidden) && $rango_valor_hidden === '25 50') ? 'selected' : ''; ?>>25 a 50</option>
                                    <option value="50 100" <?php echo (isset($rango_valor_hidden) && $rango_valor_hidden === '50 100') ? 'selected' : ''; ?>>50 a 100</option>
                                    <option value="100" <?php echo (isset($rango_valor_hidden) && $rango_valor_hidden === '100') ? 'selected' : ''; ?>>Mas de 100</option>
                                </select>
                            </div>
                        </div>

                        <div id="miEtiqueta" class="control <?php echo $rango_valor_hidden == 'rango' ? '': ' is-hidden'; ?>">
                            <div class="field has-addons">
                                <p class="control ">
                                        <input class="input is-rounded is-small" type="number" name="txt_buscador_min" maxlength="30" placeholder="<?php echo isset($_SESSION["txt_min"]) ? htmlspecialchars($_SESSION["txt_min"]) : 'Minimo...'; ?>">                               
                                </p>
                                <p class="control ">
                                    <input class="input is-rounded is-small" type="number" name="txt_buscador_max"  maxlength="30" placeholder="<?php echo isset($_SESSION["txt_max"]) ? htmlspecialchars($_SESSION["txt_max"]) : 'Maximo...'; ?>">
                                </p>
                            </div>
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
                    <input type="hidden" name="modulo_buscador" value="producto_stock_price"> 
                    <input type="hidden" name="eliminar_buscador" value="producto_stock_price">
                    
                    <?php
                        if(isset($_POST["rango_valor"]) && !empty($_POST["rango_valor"])){        
                            unset($_SESSION["txt_min"]);
                            unset($_SESSION["txt_max"]);
                            $busqueda_min = "";
                            $busqueda_max = "";
                        }
                        if(isset($_SESSION["txt_min"]) && isset($_SESSION["txt_max"])){
                            echo '
                                <div class="container is-fluid">
                                    <p class="subtitle">Estas buscando: Min: <strong>'.$_SESSION["txt_min"].' , Max: '.$_SESSION["txt_max"].'</strong></p>
                                </div>
                                <hr style="margin:13px">
                                <button type="submit" class="button is-link is-light is-rounded">Mostrar Todos los Registros</button>
                            ' ;
                            
                            $busqueda_min = $_SESSION["txt_min"];
                            $busqueda_max = $_SESSION["txt_max"];
                        }else if(isset($_SESSION['rango_valor'])){
                            
                            echo '<button type="submit" class="button is-link is-light is-rounded">Mostrar Todos los Registros</button>';
                        }
                        
                    ?>
                    
                </form>
            </div>
        </div>
            
        
        <?php

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
            $url = "index.php?view=product_stock_price&page=";
            $registros = 15;
            
            require_once "php/producto_lista_stock_precio.php";

        ?>
    </div>


        
    </body>
    </html>

    <script>
        function actualizarClase() {
            // Obtener el valor seleccionado del select
            var select = document.getElementById('miSelect');
            var valorSeleccionado = select.value;
            
            // Obtener la etiqueta
            var etiqueta = document.getElementById('miEtiqueta');

            // Si se selecciona alguna opción, agregar la clase is-hidden a la etiqueta
            
            if (valorSeleccionado!= "rango") {
                etiqueta.classList.add('is-hidden');
            } else {
                etiqueta.classList.remove('is-hidden');
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
</div>
