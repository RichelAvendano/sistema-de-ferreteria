<script src="js/package/dist/chart.umd.js"></script> <!-- Ruta local a Chart.js -->
<style>
    .opacity-box {
        opacity: 0.9; /* Ajusta el valor entre 0 (completamente transparente) y 1 (completamente opaco) */
    }
</style>
<div class = "background-image" style="height: 100%;min-height: 100vh;">
    <div class="columns is-mobile is-multiline is-centered mt-4 box p-2 opacity-box">
        <div class="column is-narrow pr-0 ">
            <div class="box has-background-link-light title is-4 has-text-black">Inventario Total:</div>
            
            <?php
                require_once "php/main.php";

                $check_stock_total = conexion();
                $check_stock_total = $check_stock_total->query("SELECT SUM(producto_stock) as stock_total FROM producto");
                $check_stock_total = $check_stock_total->fetch();
                $stock_total = $check_stock_total['stock_total'];
                $check_stock_total = null;

                $check_monto_total = conexion();
                $check_monto_total = $check_monto_total->query("SELECT SUM(producto_precio * producto_stock) as monto_total FROM producto");
                $check_monto_total = $check_monto_total->fetch();
                $monto_total = $check_monto_total['monto_total'];
                $check_monto_total = null;
                $monto_total = number_format($monto_total, 2, ',', '.');
               
            ?>
        </div>
        <div class="column is-narrow ">
            <div class="box has-background-link-95 title is-4 has-text-black has-text-center"><?=$stock_total?> Productos</div>
        </div>
        <div class="column is-narrow pr-0">
            <div class="box has-background-link-light title is-4 has-text-black">Monto Total:</div>
        </div>
        <div class="column is-narrow ">
            <div class="box has-background-link-95 title is-4 has-text-black has-text-center">$ <?=$monto_total?></div>
        </div>
    </div>
    <?php
        $check_product_stock = conexion();
        $check_product_stock = $check_product_stock->query("SELECT producto_stock FROM producto WHERE producto_stock = 0");
        $amount_alert = $check_product_stock->rowCount();
        $plural = "";
        if($amount_alert > 1){
            $plural = "s";
        }
        if($check_product_stock->rowCount()>0){
            echo '
                <div class="columns is-mobile is-multiline is-centered mt-4 box p-2 opacity-box">
                    <div class="column is-narrow pr-0">
                        <div class="box has-background-danger-light p-4 title is-4 has-text-black"><i class="fa-solid fa-circle-exclamation has-text-danger"></i> '.$amount_alert.' Producto'.$plural.' con Inventario en 0:</div>
                    </div>
                    <div class="column is-narrow pr-0">
                        
                        <a class="button is-danger p-4 title is-4 has-text-white" href="index.php?view=product_stock_price&alert_product=1"><i class="fa-solid fa-magnifying-glass-arrow-right"></i> Ver Productos</a>
                    </div>
                </div>
                
            ';
        }else{
            echo '
            <div class="columns is-mobile is-multiline is-centered mt-4 box p-2 opacity-box">
                <div class="column is-narrow pr-0">
                    <div class="box has-background-success-light p-4 title is-4 has-text-black"><i class="fa-regular fa-circle-check has-text-success"></i> Ningun Producto se Encuentra con Inventario en 0</div>
                </div>
            </div>
            
            ';
        }
    ?>
    <section class="section box p-5 opacity-box">
        <div class="columns is-centered mt-4">
            <div class="column is-half pr-0">
                <div class="box title is-4 has-text-black" style="text-align:center; background-color:rgba(75, 192, 192, 0.2)">10 Productos Con Menor Cantidad de Inventario</div>
                <?php
                    require_once "php/main.php";

                    $conexion = conexion();

                    // Obtener 10 productos con menor stock
                    $check_stock_min = $conexion->query("SELECT producto_nombre, producto_stock, producto_precio FROM producto WHERE producto_stock >= 1 ORDER BY producto_stock  ASC LIMIT 10");
                    $resultados_min = $check_stock_min->fetchAll(PDO::FETCH_ASSOC);

                    // Obtener 10 productos con mayor stock
                    $check_stock_max = $conexion->query("SELECT producto_nombre, producto_stock, producto_precio FROM producto WHERE producto_stock >= 1 ORDER BY producto_stock DESC LIMIT 10");
                    $resultados_max = $check_stock_max->fetchAll(PDO::FETCH_ASSOC);

                    $check_stock_min = null;
                    $check_stock_max = null;

                    // Crear arrays para nombres y stocks
                    $productNamesMin = [];
                    $productStocksMin = [];
                    $productNamesMax = [];
                    $productStocksMax = [];

                    foreach ($resultados_min as $fila) {
                        $productNamesMin[] = $fila['producto_nombre'];
                        $productStocksMin[] = $fila['producto_stock'];
                        $productPrecioMin[] = $fila['producto_precio'];
                    }

                    foreach ($resultados_max as $fila) {
                        $productNamesMax[] = $fila['producto_nombre'];
                        $productStocksMax[] = $fila['producto_stock'];
                        $productPrecioMax[] = $fila['producto_precio'];
                    }

                    // Pasar los datos a JavaScript
                    $dataMin = [
                        'names' => $productNamesMin,
                        'stocks' => $productStocksMin,
                        'precio' => $productPrecioMin
                    ];
                    $dataMax = [
                        'names' => $productNamesMax,
                        'stocks' => $productStocksMax,
                        'precio' => $productPrecioMax
                    ];
                ?>
            </div>

        </div>

        
        <canvas id="chartMin" width="330" height="110"></canvas>
    </section>
    <section class="section box p-5 opacity-box">
        <div class="columns is-centered mt-4">
            <div class="column is-half pr-0">
                <div class="box has-background-warning-light title is-4 has-text-black" style="text-align:center">10 Productos Con Mayor Cantidad de Inventario</div>
            </div>
        </div>
        <canvas id="chartMax" width="330" height="110"></canvas>
    </section>
</div>

<script>
    // Obtener los datos de PHP en formato JSON
    const dataMin = <?php echo json_encode($dataMin); ?>;
    const dataMax = <?php echo json_encode($dataMax); ?>;

    // Configurar el gráfico para productos con menor stock
    const ctxMin = document.getElementById('chartMin').getContext('2d');

    const combinedLabels1 = dataMin.names.map((name, index) => `${name} - Precio C/U: $${dataMin.precio[index]}`);

    const chartMin = new Chart(ctxMin, {
        type: 'bar',
        data: {
            labels: combinedLabels1,  // Usar los nombres de los productos con menor stock
            datasets: [{
                label: 'Productos con Menor Inventario',
                data: dataMin.stocks,  // Usar los stocks de los productos con menor stock
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Nota: Dale Click a un producto para buscarlo'
                    }
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Inventario'
                    }
                }
            },
            onClick: (e, elements) => {
                if (elements.length > 0) {
                    const index = elements[0].index;
                    const name = dataMin.names[index];;
                    // Redirigir a otra página
                    window.location.href = `index.php?view=product_search&busqueda=${name}`;
                }
            },
            onHover: (e, elements) => {
                if (elements.length > 0) {
                    e.native.target.style.cursor = 'pointer';
                } else {
                    e.native.target.style.cursor = 'default';
                }
            }
        }
    });

    // Configurar el gráfico para productos con mayor stock
    const ctxMax = document.getElementById('chartMax').getContext('2d');
    const combinedLabels2 = dataMax.names.map((name, index) => `${name} - Precio C/U: $${dataMax.precio[index]}`);

    const chartMax = new Chart(ctxMax, {
        type: 'bar',
        data: {
            labels: combinedLabels2,  // Usar los nombres de los productos con mayor stock
            datasets: [{
                label: 'Productos con Mayor Inventario',
                data: dataMax.stocks,  // Usar los stocks de los productos con mayor stock
                backgroundColor: 'rgba(255, 206, 86, 0.2)',
                borderColor: 'rgba(255, 206, 86, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Nota: Dale Click a un producto para buscarlo'
                    }
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Inventario'
                    }
                }
            },
            onClick: (e, elements) => {
                if (elements.length > 0) {
                    const index = elements[0].index;
                    const name = dataMax.names[index];;
                    // Redirigir a otra página
                    window.location.href = `index.php?view=product_search&busqueda=${name}`;
                }
            },
            onHover: (e, elements) => {
                if (elements.length > 0) {
                    e.native.target.style.cursor = 'pointer';
                } else {
                    e.native.target.style.cursor = 'default';
                }
            }
        }
    });
</script>

