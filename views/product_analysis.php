<script src="js/package/dist/chart.umd.js"></script> <!-- Ruta local a Chart.js -->
<style>
    .opacity-box {
        opacity: 0.95; /* Ajusta el valor entre 0 (completamente transparente) y 1 (completamente opaco) */
    }
    .fade-out {
        animation: fadeOut 0.2s forwards;
    }
    @keyframes fadeOut {
        from { opacity: 1; }
        to { opacity: 0; }
    }
</style>
<div class = "background-image pb-4" style="height: 100%;min-height: 100vh;">
    <div class="columns is-mobile is-multiline is-centered mt-4 box p-2 opacity-box">
        <div class="column is-narrow pr-0 ">
            <div class="box has-background-link-light title is-4 has-text-black">Analisis de Productos</div>   
        </div>
    </div>
    <div class="columns is-mobile is-multiline is-centered mt-4 box p-2 opacity-box">
        <div class="column is-narrow pr-0 ">
            <div class="buttons">
                <button id="btn1" class="button is-primary title is-4 m-0 is-focused"><i class="fa-solid fa-magnifying-glass mr-3"></i>Mostrar Cantidades Vendidas</button>
                <button id="btn2" class="button is-primary is-light title is-4 m-0"><i class="fa-solid fa-magnifying-glass mr-3"></i>Mostrar Recaudacion Monetaria</button>
            </div>  
       </div>
    </div>
    <div id="etiqueta1">
        <section class="section box p-5 opacity-box m-4">
            <div class="columns is-centered mt-4">
                <div class="column is-half pr-0">
                    <div class="box has-background-warning-light title is-4 has-text-black" style="text-align:center; background-color:rgba(75, 192, 192, 0.2)">10 Productos con Mas Cantidades Vendidas</div>
                    <?php
                        require_once "php/main.php";

                        $conexion = conexion();

                        // Obtener 10 productos con menor y mayor cantidad de vendidos

                        $check_cant_min = $conexion->query("SELECT 
                            producto_nombre,
                            producto_precio,  
                            SUM(producto_cantidad) AS cantidad_total 
                        FROM 
                            factura_producto
                        GROUP BY 
                            producto_id, 
                            producto_nombre
                        ORDER BY 
                            cantidad_total ASC LIMIT 10
                        ");

                        $resultados_cant_min = $check_cant_min->fetchAll(PDO::FETCH_ASSOC);

                        $check_cant_max = $conexion->query("SELECT 
                            producto_nombre, 
                            producto_precio, 
                            SUM(producto_cantidad) AS cantidad_total 
                        FROM 
                            factura_producto
                        GROUP BY 
                            producto_id, 
                            producto_nombre
                        ORDER BY 
                            cantidad_total DESC LIMIT 10
                        ");

                        $resultados_cant_max = $check_cant_max->fetchAll(PDO::FETCH_ASSOC);

                        $check_cant_min = null;
                        $check_cant_max = null;

                        foreach ($resultados_cant_min as $fila) {
                            $productNamesMin[] = $fila['producto_nombre'];
                            $productCantMin[] = $fila['cantidad_total'];
                            $productPrecioMin[] = $fila['producto_precio'];
                        }

                        foreach ($resultados_cant_max as $fila) {
                            $productNamesMax[] = $fila['producto_nombre'];
                            $productCantMax[] = $fila['cantidad_total'];
                            $productPrecioMax[] = $fila['producto_precio'];
                        }

                        // Pasar los datos a JavaScript
                        $dataMin = [
                            'names' => $productNamesMin,
                            'stocks' => $productCantMin,
                            'precio' => $productPrecioMin
                        ];
                        $dataMax = [
                            'names' => $productNamesMax,
                            'stocks' => $productCantMax,
                            'precio' => $productPrecioMax
                        ];

                        // Obtener 10 productos con menor y mayor cantidad de monto vendido

                        $check_amount_min = $conexion->query("SELECT 
                            producto_nombre,
                            producto_precio,   
                            SUM(producto_cantidad * producto_precio) AS monto_total
                        FROM 
                            factura_producto
                        GROUP BY 
                            producto_id, 
                            producto_nombre
                        ORDER BY 
                            monto_total ASC LIMIT 10
                        ");

                        $resultados_amount_min = $check_amount_min->fetchAll(PDO::FETCH_ASSOC);

                        $check_amount_max = $conexion->query("SELECT 
                            producto_nombre, 
                            producto_precio,  
                            SUM(producto_cantidad * producto_precio) AS monto_total
                        FROM 
                            factura_producto
                        GROUP BY 
                            producto_id, 
                            producto_nombre
                        ORDER BY 
                            monto_total DESC LIMIT 10
                        ");

                        $resultados_amount_max = $check_amount_max->fetchAll(PDO::FETCH_ASSOC);

                        $check_amount_min = null;
                        $check_amount_max = null;

                        foreach ($resultados_amount_min as $fila) {
                            $productAmountNamesMin[] = $fila['producto_nombre'];
                            $productAmountMin[] = $fila['monto_total'];
                            $productAmountPrecioMin[] = $fila['producto_precio'];
                        }

                        $productAmountMax = [];
                        $productAmountMax = [];
                        $productAmountPrecioMax = [];

                        foreach ($resultados_amount_max as $fila) {
                            $productAmountNamesMax[] = $fila['producto_nombre'];                     
                            $productAmountMax[] = $fila['monto_total'];                        
                            $productAmountPrecioMax[] = $fila['producto_precio'];
                        }

                        // Pasar los datos a JavaScript
                        $dataMin2 = [
                            'names' => $productAmountNamesMin,
                            'stocks' => $productAmountMin,
                            'precio' => $productAmountPrecioMin
                        ];
                        $dataMax2 = [
                            'names' => $productAmountNamesMax,
                            'stocks' => $productAmountMax,
                            'precio' => $productAmountPrecioMax
                        ];
                    ?>
                </div>

            </div>       
            <canvas id="chartMax" width="330" height="110"></canvas>
        </section>
        <section class="section box p-5 opacity-box m-4">
            <div class="columns is-centered mt-4">
                <div class="column is-half pr-0">
                    <div class="box title is-4 has-text-black" style="text-align:center;background-color:rgba(75, 192, 192, 0.2)">10 Productos con Menos Cantidades Vendidas</div>
                </div>
            </div>
            <canvas id="chartMin" width="330" height="110"></canvas>
        </section>
    </div>
    <div id="etiqueta2" style="display:none">
        <section class="section box p-5 opacity-box m-4">
            <div class="columns is-centered mt-4">
                <div class="column is-half pr-0">
                    <div class="box has-background-warning-light title is-4 has-text-black" style="text-align:center; background-color:rgba(75, 192, 192, 0.2)">10 Productos con Mayor Recaudación Monetaria</div>
                </div>

            </div>       
            <canvas id="chartMax2" width="330" height="110"></canvas>
        </section>
        <section class="section box p-5 opacity-box m-4">
            <div class="columns is-centered mt-4">
                <div class="column is-half pr-0">
                    <div class="box title is-4 has-text-black" style="text-align:center;background-color:rgba(75, 192, 192, 0.2)">10 Productos con Menor Recaudación Monetaria</div>
                </div>
            </div>
            <canvas id="chartMin2" width="330" height="110"></canvas>
        </section>
    </div>
</div>

<script id="cantidad-vendida">
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
                label: 'Cantidad Total Vendida',
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
                label: 'Cantidad Total Vendida',
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

<script id="monto-vendido">
    // Obtener los datos de PHP en formato JSON
    const dataMin2 = <?php echo json_encode($dataMin2); ?>;
    const dataMax2 = <?php echo json_encode($dataMax2); ?>;

    // Configurar el gráfico para productos con menor stock
    const ctxMin2 = document.getElementById('chartMin2').getContext('2d');

    const combinedLabels3 = dataMin2.names.map((name, index) => `${name} - Precio C/U: $${dataMin2.precio[index]}`);

    const chartMin2 = new Chart(ctxMin2, {
        type: 'bar',
        data: {
            labels: combinedLabels3,  // Usar los nombres de los productos con menor stock
            datasets: [{
                label: 'Monto Total Vendido $',
                data: dataMin2.stocks,  // Usar los stocks de los productos con menor stock
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
                    const name = dataMin2.names[index];;
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
    const ctxMax2 = document.getElementById('chartMax2').getContext('2d');
    const combinedLabels4 = dataMax2.names.map((name, index) => `${name} - Precio C/U: $${dataMax2.precio[index]}`);

    const chartMax2 = new Chart(ctxMax2, {
        type: 'bar',
        data: {
            labels: combinedLabels4,  // Usar los nombres de los productos con mayor stock
            datasets: [{
                label: 'Monto Total Vendido $',
                data: dataMax2.stocks,  // Usar los stocks de los productos con mayor stock
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
                    const name = dataMax2.names[index];;
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

<script>
    document.getElementById('btn1').addEventListener('click', function() {
        mostrarEtiqueta('etiqueta1', 'etiqueta2', 'btn1', 'btn2');
    });

    document.getElementById('btn2').addEventListener('click', function() {
        mostrarEtiqueta('etiqueta2', 'etiqueta1', 'btn2', 'btn1');
    });

    function mostrarEtiqueta(mostrarId, ocultarId, botonActivoId, botonInactivoId) {
        const mostrar = document.getElementById(mostrarId);
        const ocultar = document.getElementById(ocultarId);
        const botonActivo = document.getElementById(botonActivoId);
        const botonInactivo = document.getElementById(botonInactivoId);

        ocultar.classList.add('fade-out');
        botonInactivo.classList.remove('is-focused');
        botonInactivo.classList.add('is-light');
        
        botonActivo.classList.add('is-focused');
        botonActivo.classList.remove('is-light');

        ocultar.addEventListener('animationend', function() {
            ocultar.style.display = 'none';
            mostrar.style.display = 'block';
            mostrar.classList.remove('fade-out');
        }, { once: true });
    }
</script>
