<script src="js/package/dist/chart.umd.js"></script> <!-- Ruta local a Chart.js -->
    <section class="section pt-4 pb-0">
        <div class="columns is-mobile is-multiline is-centered">
            <div class="column is-narrow">
                <div class="box has-background-link-light title is-4 has-text-black">Ventas Totales en facturas</div>
            </div>
            <?php
                require_once "php/main.php";

                $check_ventas_totales = conexion();
                $check_ventas_totales = $check_ventas_totales->query("SELECT SUM(factura_monto) as venta_total FROM factura");

                if($check_ventas_totales->rowCount()>=1){
                    $check_ventas_totales = $check_ventas_totales->fetch();
                    $ventas_totales = $check_ventas_totales['venta_total'];
                    $ventas_totales = number_format($ventas_totales, 2, ',', '.');
                }
                $check_ventas_totales = null;
            ?>
            <div class="column is-narrow pl-0">
                <div class="box has-background-link-95 title is-4 has-text-black ">$<?=$ventas_totales?></div>
            </div>
    </section>
    <section class="section pt-4 pb-4">
        <div class="container">
            <span class="box has-background-warning-light title is-4 has-text-black is-inline-block">Ventas Diarias</span>
            <div class="field">
                <label class="label">Selecciona una Dia</label>
                <div class="control is-inline-block">
                    <input class="input" type="date" id="fecha">
                </div>
            </div>
            <div class="field">
                <div class="control">
                    <button type="button" class="button is-primary" onclick="actualizarGrafico()">Actualizar</button>
                </div>
            </div>
            <div class="field">
                <span id="fechaSeleccionada" class="title is-5"></span><span id="monto-total" class="title is-5"></span>
            </div>
            <canvas id="myChart" width="350" height="130"></canvas>
            
        </div>
    </section>
    <section class="section pt-0">
        <div class="container">
            <span class="box has-background-warning-light title is-4 has-text-black is-inline-block">Ventas Semanales</span>
            <div class="field">
                <label class="label">Selecciona una semana</label>
                <div class="control is-inline-block">
                    <input class="input" type="week" id="semana">
                </div>
            </div>
            <div class="field">
                <div class="control">
                    <button class="button is-primary" type="button" onclick="actualizarGrafico2()">Actualizar</button>
                </div>
            </div>
            <div class="field">
                <span id="fechaSeleccionada" class="title is-5"></span><span id="monto-total-week" class="title is-5"></span>
            </div>
            <canvas id="myChart2" width="350" height="130"></canvas>
        </div>
    </section>

    <section class="section pt-0">
        <div class="container">
            <span class="box has-background-warning-light title is-4 has-text-black is-inline-block">Ventas Mensuales</span>
            <div class="field">
                <label class="label">Selecciona un mes</label>
                <div class="control is-inline-block">
                    <input class="input" type="month" id="mes">
                </div>
            </div>
            <div class="field">
                <div class="control">
                    <button class="button is-primary" type="button" onclick="actualizarGraficoMes()">Actualizar</button>
                </div>
            </div>
            <div class="field">
                <span id="fechaSeleccionada" class="title is-5"></span><span id="monto-total-mes" class="title is-5"></span>
            </div>
            <canvas id="myChartMes" width="350" height="130"></canvas>
        </div>
    </section>

    <section class="section pt-0">
        <div class="container">
            <span class="box has-background-warning-light title is-4 has-text-black is-inline-block">Ventas Anuales</span>
            <div class="field">
                <label class="label">Selecciona un año</label>
                <div class="control is-inline-block">
                    <div class="select">
                        <select name="yearpicker" id="yearpicker">
                            <option value="2025">2025</option>
                            <option value="2026">2026</option>
                            <option value="2027">2027</option>
                            <option value="2028">2028</option>
                            <option value="2029">2029</option>
                            <option value="2030">2030</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="field">
                <div class="control">
                    <button class="button is-primary" type="button" onclick="actualizarGraficoAnio()">Actualizar</button>
                </div>
            </div>
            <div class="field">
                <span id="fechaSeleccionada" class="title is-5"></span><span id="monto-total-anio" class="title is-5"></span>
            </div>
            <canvas id="myChartAnio" width="350" height="130"></canvas>
        </div>
    </section>

    <script id="dia">
        let myChart; // Declaramos la variable fuera de la función para que sea accesible

        document.addEventListener('DOMContentLoaded', function() {
            // Definir la fecha por defecto en JavaScript
            const fechaInput = document.getElementById('fecha');
            const today = new Date();
            const yyyy = today.getFullYear();
            const mm = String(today.getMonth() + 1).padStart(2, '0'); // Meses empiezan en 0
            const dd = String(today.getDate()).padStart(2, '0');
            fechaInput.value = `${yyyy}-${mm}-${dd}`;

            fechaInput.addEventListener('change', actualizarGrafico);
            actualizarGrafico();
        });

        function actualizarGrafico() {
            const fecha = document.getElementById('fecha').value;
            document.getElementById('fechaSeleccionada').innerText = `Fecha: ${fecha}`;
            fetch(`php/sales_history_day_sent.php?fecha=${fecha}`) // Ajusta la ruta aquí según sea necesario
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.error) {
                        throw new Error(data.error);
                    }
                    const ctx = document.getElementById('myChart').getContext('2d');
                    if (myChart) { // Verificamos si myChart ya existe
                        myChart.destroy(); // Destruimos la instancia anterior
                    }

                    if(data.monto_total == null){
                        document.getElementById('monto-total').innerHTML = " | Ventas: $0.00";
                    }else{
                        monto_total_dia = parseFloat(data.monto_total);
                        document.getElementById('monto-total').innerHTML = " | Ventas: $" + monto_total_dia.toFixed(2);
                    }                 

                    myChart = new Chart(ctx, {
                        type: 'bar', // Utilizamos un gráfico de líneas
                        data: {
                            labels: Array(data.fechas.length).fill(''), // Dejar el eje x vacío
                            datasets: [{
                                label: 'Ventas',
                                data: data.montos, // Utilizamos los montos como datos
                                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                x: {
                                    title: {
                                        display: true,
                                        text: `Fecha: ${fecha}`
                                    }
                                },
                                y: {
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'Monto'
                                    }
                                }
                            },
                            plugins: {
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            const fecha = data.fechas[context.dataIndex];
                                            const monto = context.raw;
                                            return `Fecha: ${fecha} | Venta: $${monto}`;
                                        }
                                    }
                                }
                            },
                            onClick: (e, elements) => {
                                if (elements.length > 0) {
                                    const index = elements[0].index;
                                    const fecha = data.fechas[index];
                                    // Redirigir a otra página
                                    window.location.href = `index.php?view=bill_search_op_2&busqueda=${fecha}`;
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
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
    </script>

    <script id="semana">
        let myChart2; // Declaramos la variable fuera de la función para que sea accesible

        document.addEventListener('DOMContentLoaded', function() {
            const semanaInput = document.getElementById('semana');
            const today = new Date();
            const yyyy = today.getFullYear();

            // Función para obtener el número de la semana según ISO 8601
            function getWeekNumber(date) {
                const d = new Date(date);
                d.setHours(0, 0, 0, 0);
                d.setDate(d.getDate() + 4 - (d.getDay() || 7));
                const yearStart = new Date(d.getFullYear(), 0, 1);
                const weekNumber = Math.ceil((((d - yearStart) / 86400000) + 1) / 7);
                return weekNumber;
            }

            const weekNumber = getWeekNumber(today);
            const weekString = weekNumber < 10 ? '0' + weekNumber : weekNumber;
            semanaInput.value = `${yyyy}-W${weekString}`;

            semanaInput.addEventListener('change', actualizarGrafico2);
            actualizarGrafico2();
        });

        function getDatesOfWeek(year, weekNumber) {
            const firstDayOfYear = new Date(year, 0, 1);
            const daysOffset = ((weekNumber - 1) * 7) - firstDayOfYear.getDay() + 1;
            const startOfWeek = new Date(year, 0, 1 + daysOffset);

            const dayMillis = 86400000; // Un día en milisegundos
            const dates = [];
            for (let i = 0; i < 7; i++) {
                const day = new Date(startOfWeek.getTime() + i * dayMillis);
                const dayString = `${day.getFullYear()}-${(day.getMonth() + 1).toString().padStart(2, '0')}-${day.getDate().toString().padStart(2, '0')}`;
                dates.push(dayString);
            }
            return dates;
        }

        function actualizarGrafico2() {
            const semana = document.getElementById('semana').value;
            const [year, week] = semana.split('-W');
            const datesOfWeek = getDatesOfWeek(Number(year), Number(week));

            fetch(`php/sales_history_week_sent.php?semana=${semana}`) // Ajusta la ruta aquí según sea necesario
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.error) {
                        throw new Error(data.error);
                    }

                    // Crear un mapa de fechas para los montos
                    const montosPorFecha = {};
                    data.fechas.forEach((fecha, index) => {
                        montosPorFecha[fecha] = data.montos[index];
                    });

                    // Crear array de montos alineados con los días de la semana
                    const montosAlineados = datesOfWeek.map(fecha => montosPorFecha[fecha] || 0);

                    document.getElementById('monto-total-week').innerText = `Semana: ${semana} | Ventas: $${data.monto_total.toFixed(2)}`;
                    const ctx = document.getElementById('myChart2').getContext('2d');
                    if (myChart2) { // Verificamos si myChart2 ya existe
                        myChart2.destroy(); // Destruimos la instancia anterior
                    }

                    const dias = ["lunes", "martes", "miércoles", "jueves", "viernes", "sábado", "domingo"];
            
                    myChart2 = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: dias,
                            datasets: [{
                                label: 'Ventas',
                                data: montosAlineados,
                                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                x: {
                                    title: {
                                        display: false,
                                        text: 'Fecha'
                                    }
                                },
                                y: {
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'Monto'
                                    }
                                }
                            },
                            plugins: {
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            const fecha = datesOfWeek[context.dataIndex];
                                            const monto = context.raw;
                                            return `Fecha: ${fecha} | Venta: $${monto}`;
                                        }
                                    }
                                }
                            },
                            onClick: (e, elements) => {
                                if (elements.length > 0) {
                                    const index = elements[0].index;
                                    const fecha = datesOfWeek[index];
                                    // Redirigir a otra página
                                    window.location.href = `index.php?view=bill_search_op_2&busqueda=${fecha}`;
                                }
                            }
                        }
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
    </script>

    <script id="mes">
        let myChartMes;

        document.addEventListener('DOMContentLoaded', function() {
            const mesInput = document.getElementById('mes');
            const today = new Date();
            const yyyy = today.getFullYear();
            const mm = String(today.getMonth() + 1).padStart(2, '0');
            mesInput.value = `${yyyy}-${mm}`;

            mesInput.addEventListener('change', actualizarGraficoMes);
            actualizarGraficoMes();
        });

        function actualizarGraficoMes() {
            const mes = document.getElementById('mes').value;
            
            fetch(`php/sales_history_month_sent.php?mes=${mes}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.error) {
                        throw new Error(data.error);
                    }
                    
                    document.getElementById('monto-total-mes').innerText = `Mes: ${mes}` + " | Ventas: $" + data.monto_total.toFixed(2);
                    const ctx = document.getElementById('myChartMes').getContext('2d');
                    if (myChartMes) {
                        myChartMes.destroy();
                    }

                    const dias = Array.from({ length: data.fechas.length }, (_, i) => data.fechas[i]);
                    
                    myChartMes = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: dias,
                            datasets: [{
                                label: 'Ventas',
                                data: data.montos,
                                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1,
                                pointRadius: 6,  // Tamaño de los puntos
                                pointHoverRadius: 8,
                            }]
                        },
                        options: {
                            scales: {
                                x: {
                                    title: {
                                        display: false,
                                        text: 'Fecha'
                                    }
                                },
                                y: {
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'Monto'
                                    }
                                }
                            },
                            plugins: {
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            const fecha = data.fechas[context.dataIndex];
                                            const monto = context.raw;
                                            return `Fecha: ${fecha} | Venta: $${monto}`;
                                        }
                                    }
                                }
                            },
                            onClick: (e, elements) => {
                                if (elements.length > 0) {
                                    const index = elements[0].index;
                                    const fecha = data.fechas[index];
                                    // Redirigir a otra página
                                    window.location.href = `index.php?view=bill_search_op_2&busqueda=${fecha}`;
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
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
    </script>

    <script id="Año">

        let myChartAnio;

        document.addEventListener('DOMContentLoaded', function() {           
            actualizarGraficoAnio();
        });

        function actualizarGraficoAnio() {
            const anioSelect = document.getElementById('yearpicker');
            const anio = document.getElementById('yearpicker').value;

            anioSelect.addEventListener('change', actualizarGraficoAnio);

            fetch(`php/sales_history_year_sent.php?anio=${anio}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.error) {
                        throw new Error(data.error);
                    }

                    document.getElementById('monto-total-anio').innerText = `Año: ${anio} | Ventas: $${data.monto_total.toFixed(2)}`;
                    const ctx = document.getElementById('myChartAnio').getContext('2d');
                    if (myChartAnio) {
                        myChartAnio.destroy();
                    }

                    const meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];

                    myChartAnio = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: meses,
                            datasets: [{
                                label: 'Ventas',
                                data: data.montos,
                                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                x: {
                                    title: {
                                        display: false,
                                        text: 'Mes'
                                    }
                                },
                                y: {
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'Monto'
                                    }
                                }
                            },
                            plugins: {
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            const mes = context.label;
                                            const monto = context.raw;
                                            return `Mes: ${mes} | Venta: $${monto}`;
                                        }
                                    }
                                }
                            },
                            onClick: (e, elements) => {
                                if (elements.length > 0) {
                                    const index = elements[0].index;
                                    const mes = (index + 1).toString().padStart(2, '0');
                                    const fecha = `${anio}-${mes}`;
                                    // Redirigir a otra página
                                    window.location.href = `index.php?view=bill_search_op_2&busqueda=${fecha}`;
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
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
    </script>   




    

    

