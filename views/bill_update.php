<style>
    
    .producto-seleccionado {
        margin-bottom: 10px;
    }

    .resultado:hover {
        background-color: #eee;
        cursor: pointer;
    }

    .resultado{
        padding: 5px;
    }

    .resultado-producto{
      padding: 5px;
    }

    .resultado-producto:hover {
        background-color: #eee;
        cursor: pointer;
    }

    .desaparecer {
      opacity: 0;
      transition: opacity 1.5s ease; /* Transición de desvanecimiento rápida */
    } 
</style>
<div class = "background-image" style="height: 100%;min-height: 100vh;">
  <div class="box is-inline-block has-background-link-95 ml-3 mb-3 mt-2 p-4"  >
    <h1 class="title is-4 has-text-black has-text-centered">Factura</h1>
    <h2 class="subtitle has-text-black has-text-centered">Actualizar Factura</h2>
  </div>
  <section class="hero ">

    <?php 
        require_once "php/main.php";
        date_default_timezone_set("America/Caracas");

        if(isset($_GET['bill_id_up']) && !empty($_GET['bill_id_up'])){
            $bill_id = $_GET['bill_id_up'];

            $check_bill_id = conexion();
            $check_bill_id = $check_bill_id->query("SELECT factura_id FROM factura WHERE factura_id = '$bill_id'");

            if($check_bill_id->rowCount() == 1){

                $check_factura = conexion();
                $check_factura = $check_factura->query("SELECT cliente.cliente_cedula, cliente.cliente_nombre,cliente.cliente_ubicacion,cliente.cliente_telefono, factura.factura_monto, factura.factura_fecha,factura.factura_concepto,factura.factura_observacion,factura.cliente_id FROM factura INNER JOIN cliente ON factura.cliente_id = cliente.cliente_id WHERE factura.factura_id = ".$bill_id."" ); 
                
                $check_producto = conexion();
                $check_producto = $check_producto->query("SELECT factura_producto.producto_cantidad, factura_producto.factura_id , producto.producto_nombre, producto.producto_precio,producto.producto_foto, producto.producto_id, producto.producto_stock FROM factura_producto INNER JOIN producto ON factura_producto.producto_id = producto.producto_id WHERE factura_producto.factura_id = ".$bill_id."");
                
                $check_factura = $check_factura->fetch();
                $check_producto = $check_producto->fetchAll()
    ?>

    <div class="hero-body" style="flex-grow:0; padding-top: 0;padding-bottom: 10px;">
      <div class="container">
        <div class="columns is-centered">
          <div class="column ">
            <div class="box has-background-link-light">
            <form autocomplete="off" id="myForm" onsubmit="return confirmSubmit()" data-confirm="true">
              <input type="hidden" id="cliente_id" value="<?= $check_factura['cliente_id'] ?>">

              <div class="title has-text-centered is-size-2 has-text-black">Factura</div>
              <div class="title is-size-4 has-text-black">Buscar o Agregar Cliente</div>
              <div class="subtitle is-size-5 has-text-black mt-2 mb-2">Nota: Coloque la Cedula para buscar en los Registros o Escriba una nueva Cedula Nueva para Agregarla</div>
              <div class="columns is-multiline  ">
                <div class="column is-half">
                  <div class="field">
                    <label for="cedula" class="subtitle is-12 has-text-weight-bold has-text-black">Cédula</label>
                    <div class="control has-icons-left">
                      <input type="number" class="input is-focused" required id="cedula" pattern="[0-9]{9,}" maxlength="9" name="cliente_cedula" value="<?= $check_factura['cliente_cedula']?>">
                      <span class="icon is-small is-left">
                        <i class="fa fa-id-card"></i>
                      </span>
                    </div>
                    <div id="resultados" class="box title is-6 has-background-text-90 p-2">Resultados</div>
                  </div>
                </div>
                <div class="column is-half">
                  <div class="field">
                    <label for="nombre" class="subtitle is-12 has-text-weight-bold has-text-black">Nombre</label>
                    <div class="control has-icons-left">
                      <input type="text" class="input" required id="nombre" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="40" name="cliente_nombre" value="<?= $check_factura['cliente_nombre']?>">
                      <span class="icon is-small is-left">
                        <i class="fas fa-user"></i>
                      </span>
                    </div>
                  </div>
                </div>
                <div class="column is-half">
                  <div class="field">
                    <label for="ubicacion" class="subtitle is-12 has-text-weight-bold has-text-black">Ubicación</label>
                    <div class="control has-icons-left">
                      <input type="text" class="input" id="ubicacion" maxlength="200" name="cliente_ubicacion" value="<?= $check_factura['cliente_ubicacion']?>">
                      <span class="icon is-small is-left">
                        <i class="fa fa-map-marker"></i>
                      </span>
                    </div>
                  </div>
                </div>
                <div class="column is-half">
                  <div class="field">
                    <label for="telefono" class="subtitle is-12 has-text-weight-bold has-text-black">Telefono</label>
                    <div class="control has-icons-left">
                      <input type="text" class="input" id="telefono" maxlength="200" name="cliente_telefono" value="<?= $check_factura['cliente_telefono']?>">
                      <span class="icon is-small is-left">
                        <i class="fa-solid fa-phone"></i>
                      </span>
                    </div>
                  </div>
                </div>
              </div>

              <!-- <div class="columns">
                <div class="column has-text-centered">
                    <button type="submit" class="button is-warning is-large is-responsive" name="Enviar">Guardar</button>
                </div>
              </div> -->
              <hr class="divider">
              <div class="title is-size-4 has-text-black">Buscar y Agregar Productos</div>
              <div class="subtitle is-size-5 has-text-black mt-2 mb-2">Nota: busque productos por su nombre (debe ser preciso)</div>
              <div class="columns is-multiline  ">
                <div class="column is-full">
                  <div class="field">
                    <label for="producto" class="subtitle is-12 has-text-weight-bold has-text-black">Nombre de Producto</label>
                    <div class="control has-icons-left">
                      <input type="text" class="input is-focused" id="producto" placeholder="Producto">
                      <span class="icon is-small is-left">
                        <i class="fa-solid fa-box"></i>
                      </span>
                    </div>
                    <div id="resultadosProductos" class="box title is-6 has-background-text-90 p-2">Resultados</div>
                    <span id="padreProductoDuplicado"><span id="productoDuplicado"></span></span>
                  </div>
                </div>
                <div class="column is-full">                               
                  <div id="productosSeleccionados" class=" box has-background-text-90">
                    <div class="box title is-6 has-background-link-70 p-2 mb-2 has-text-white">Productos Seleccionados</div>
                    <div class="table-container">
                      <table class="table is-bordered is-fullwidth table-custom-bordered" style="min-width:650px">
                        <thead>
                          <tr class="has-background-link-90">
                            <th class="has-text-black" style = "text-align: center">ID</th>
                            <th class="has-text-black" style = "text-align: center">Nombre</th>
                            <th class="has-text-black" style = "text-align: center">Imagen</th>
                            <th class="has-text-black" style = "text-align: center">Precio C/U</th>
                            <th class="has-text-black" style = "text-align: center">Precio C/U en Bs</th>
                            <th class="has-text-black" style = "text-align: center">Cantidad</th>
                            <th class="has-text-black" style = "text-align: center">Monto</th>
                            <th class="has-text-black" style = "text-align: center">Opcion</th>
                          </tr>
                        </thead>
                        <tbody id="tabla">
                      <?php
                          $tabla="";
                          foreach($check_producto as $rows){
                              if (file_exists('img/productos/'.$rows['producto_foto']) && $rows['producto_foto']!= "") {
                                $url_foto = "img/productos/".$rows['producto_foto'];
                              } else {
                                $url_foto = "img/producto.png";
                              }
                              
                              $valorUnitarioProductoBCV = $_SESSION['dolar_valor_bcv'] * $rows['producto_precio'];
                              $valorUnitarioProductoMonitor = $_SESSION['dolar_valor_paralelo'] * $rows['producto_precio'];
                              
                              $valorTotalProductoRef = round(($rows['producto_cantidad']*$rows['producto_precio']) , 2);
                              $valorTotalProductoRef = number_format($valorTotalProductoRef, 2, ',', '.');

                              $valorTotalProductoMonitor = round(($rows['producto_cantidad']*$valorUnitarioProductoMonitor) , 2);
                              $valorTotalProductoMonitor = number_format($valorTotalProductoMonitor, 2, ',', '.');

                              $valorTotalProductoBCV = round(($rows['producto_cantidad']*$valorUnitarioProductoBCV) , 2);
                              $valorTotalProductoBCV = number_format($valorTotalProductoBCV, 2, ',', '.');

                              $tabla .='
                                      <tr class="producto-seleccionado has-text-centered has-background-link-100">
                                        <td class="has-text-black" >'.$rows['producto_id'].'</td>
                                          <td class="has-text-black" >'.$rows['producto_nombre'].'</td>
                                          <td class="has-text-black has-text-weight-bold" >
                                              <figure class="media-left is-flex is-justify-content-center">
                                                  <p class="image is-64x64">
                                                      <img src='.$url_foto.'>
                                                  </p>
                                              </figure>
                                          </td>
                                          <td class="has-text-black" >'.$rows['producto_precio'].'$</td>
                                          <td class="has-text-black" >BCV: '.$valorUnitarioProductoBCV.'bs <br> Monitor: '.$valorUnitarioProductoMonitor.'bs</td>
                                          <td class="has-text-black" >
                                            <div class="is-flex is-flex-direction-column mr-4">
                                              <input type="number" value="'.$rows['producto_cantidad'].'" min="1" max="'.$rows['producto_stock'].'" data-id="'.$rows['producto_id'].'" data-precio="'.$rows['producto_precio'].' "class="cantidad input is-small" oninput="actualizarMonto()">
                                              <div class="mt-1">Inventario: '.$rows['producto_stock'].'</div>
                                            </div>
                                          </td>
                                          <td class="has-text-black" id="'.$rows['producto_id'].'">
                                            Ref: '.$valorTotalProductoRef.'$<br>
                                            BCV:  '.$valorTotalProductoBCV.'bs<br>
                                            Monitor:  '.$valorTotalProductoMonitor.'bs<br>
                                          </td>
                                          <td>
                                            <div class="is-flex is-justify-content-center eliminarProducto" data-idproducto="'.$rows['producto_id'].'" data-idfactura="'.$rows['factura_id'].'" data-stock="'.$rows['producto_stock'].'">
                                              <button class="button is-danger is-small" type="button" onclick="eliminarProducto(this)">Eliminar</button>
                                            </div>
                                          </td>
                                      </tr>
                              ';
                          }
                          
                          $check_producto = conexion();
                          $check_producto = $check_producto->query("SELECT producto_cantidad, producto_nombre, producto_precio FROM factura_producto WHERE factura_id = $bill_id AND producto_id IS NULL");
                          
                          if($check_producto->rowCount()>0){
                            $check_producto = $check_producto->fetchAll();
                            $band_id = 100000;

                            foreach($check_producto as $rows){   
                              
                              $valorUnitarioProductoBCV = $_SESSION['dolar_valor_bcv'] * $rows['producto_precio'];
                              $valorUnitarioProductoMonitor = $_SESSION['dolar_valor_paralelo'] * $rows['producto_precio'];
                              
                              $valorTotalProductoRef = round(($rows['producto_cantidad']*$rows['producto_precio']) , 2);
                              $valorTotalProductoRef = number_format($valorTotalProductoRef, 2, ',', '.');

                              $valorTotalProductoMonitor = round(($rows['producto_cantidad']*$valorUnitarioProductoMonitor) , 2);
                              $valorTotalProductoMonitor = number_format($valorTotalProductoMonitor, 2, ',', '.');

                              $valorTotalProductoBCV = round(($rows['producto_cantidad']*$valorUnitarioProductoBCV) , 2);
                              $valorTotalProductoBCV = number_format($valorTotalProductoBCV, 2, ',', '.');
                              
                              $tabla .='
                                <tr class="producto-seleccionado has-text-centered has-background-link-100">
                                  <td class="has-text-black" >Nulo</td>
                                    <td class="has-text-black" ><p>'.$rows['producto_nombre'].'</p><p class="has-text-danger"><i class="fa-solid fa-circle-exclamation has-text-danger"></i> Producto Eliminado</p></td>
                                    <td class="has-text-black has-text-weight-bold" >
                                        <figure class="media-left is-flex is-justify-content-center">
                                            <p class="image is-64x64">
                                                <img src="img/producto_eliminado.jpg">
                                            </p>
                                        </figure>
                                    </td>
                                    <td class="has-text-black" >'.$rows['producto_precio'].'$</td>
                                    <td class="has-text-black" >BCV: '.$valorUnitarioProductoBCV.'bs <br> Monitor: '.$valorUnitarioProductoMonitor.'bs</td>
                                    <td class="has-text-black" >
                                      <div class="is-flex is-flex-direction-column mr-4">
                                        <input readonly type="number" value="'.$rows['producto_cantidad'].'" min="1" max="nulo" class="cantidad input is-small" data-id="'.$band_id.'" data-precio="'.$rows['producto_precio'].'" oninput="actualizarMonto()">
                                        <div class="mt-1">Inventario: Ninguno</div>
                                      </div>
                                    </td>
                                    <td class="has-text-black" id="nulo">
                                      Ref: '.$valorTotalProductoRef.'$<br>
                                      BCV:  '.$valorTotalProductoBCV.'bs<br>
                                      Monitor:  '.$valorTotalProductoMonitor.'bs<br>
                                    </td>
                                    <td>
                                      <div class="is-flex is-justify-content-center eliminarProducto" data-idproducto="'.$band_id.'" data-idfactura="'.$bill_id.'" data-stock="0" data-nombre="'.$rows['producto_nombre'].'">
                                        <button class="button is-danger is-small" type="button" onclick="eliminarProducto(this)">Eliminar</button>
                                      </div>
                                    </td>
                                </tr>
                              ';
                            }
                            $band_id++;
                          }
                          echo $tabla;
                      ?>
                        </tbody>
                      </table>
                    </div>                   
                  </div>                  
                </div>
                <div class="column is-half">
                  <div class="field">
                    <label for="concepto" class="subtitle is-12 has-text-weight-bold has-text-black">Concepto (opcional)</label>
                    <div class="control has-icons-left">
                      <input type="text" class="input" id="concepto" value="<?= $check_factura['factura_concepto'] ?>">
                      <span class="icon is-small is-left">
                        <i class="fa-solid fa-circle-info"></i>
                      </span>
                    </div>
                  </div>
                </div>
                <div class="column is-half">
                  <div class="field">
                    <label for="observacion" class="subtitle is-12 has-text-weight-bold has-text-black">Observacion (opcional)</label>
                    <div class="control has-icons-left">
                      <input type="text" class="input" id="observacion" value="<?= $check_factura['factura_observacion'] ?>">
                      <span class="icon is-small is-left">
                        <i class="fa-solid fa-circle-info"></i>
                      </span>
                    </div>
                  </div>
                </div>
                <div class="column is-half">
                  <div class="field">
                    <label for="fecha" class="subtitle is-12 has-text-weight-bold has-text-black">Fecha(Solo Ver)</label>
                    <div class="control has-icons-left">
                      <input type="text" class="input" id="fecha" maxlength="200" name="factura_fecha" value="<?= $check_factura['factura_fecha']?>" readonly>
                      <span class="icon is-small is-left" >
                        <i class="fa-solid fa-calendar-days"></i>
                      </span>
                    </div>
                  </div>
                </div>
              </div>
              <hr class="divider">
              <div class="title is-size-3 has-text-black mb-2">BI G16,00%</div>
              <div class="box p-4 has-text-left">
                <div class="columns is-multiline is-centered is-vcentered">
                  <div class="column is-narrow">
                      <div class="box has-background-text-90 p-2">
                          <p class="subtitle is-4">Ref: <span id="totalMontoRef" class="has-text-weight-bold">0.00$</span></p>
                      </div>
                  </div>
                  <div class="column is-narrow">
                      <div class="box has-background-text-90 p-2">
                          <p class="subtitle is-4">BCV: <span id="totalMontoBCV" class="has-text-weight-bold">0.00bs</span></p>
                      </div>
                  </div>
                  <div class="column is-narrow">
                      <div class="box has-background-text-90 p-2">
                          <p class="subtitle is-4">Monitor: <span id="totalMontoMonitor" class="has-text-weight-bold">0.00bs</span></p>
                      </div>
                  </div>
                </div>
              </div>
              <div class="title is-size-3 has-text-black mb-2">IVA 16%</div>
              <div class="box p-4 has-text-left">
                <div class="columns is-multiline is-centered is-vcentered">
                  <div class="column is-narrow">
                      <div class="box has-background-text-90 p-2">
                          <p class="subtitle is-4">BCV: <span id="totalMontoBCVIVA" class="has-text-weight-bold">0.00bs</span></p>
                      </div>
                  </div>
                  <div class="column is-narrow">
                      <div class="box has-background-text-90 p-2">
                          <p class="subtitle is-4">Monitor: <span id="totalMontoMonitorIVA" class="has-text-weight-bold">0.00bs</span></p>
                      </div>
                  </div>
                </div>
              </div>
              <div class="title is-size-3 has-text-black mb-2">Monto Total</div>
              <div class="box p-4 has-text-left">
                <div class="columns is-multiline is-centered is-vcentered">
                  <div class="column is-narrow">
                      <div class="box has-background-text-90 p-2">
                          <p class="subtitle is-4">Ref: <span id="totalMontoRef2" class="has-text-weight-bold">0.00$</span></p>
                      </div>
                  </div>
                  <div class="column is-narrow">
                      <div class="box has-background-text-90 p-2">
                          <p class="subtitle is-4">BCV: <span id="totalMontoBCVPLus" class="has-text-weight-bold">0.00bs</span></p>
                      </div>
                  </div>
                  <div class="column is-narrow">
                      <div class="box has-background-text-90 p-2">
                          <p class="subtitle is-4">Monitor: <span id="totalMontoMonitorPlus" class="has-text-weight-bold">0.00bs</span></p>
                      </div>
                  </div>
                </div>
              </div>             
              <div class="field">
                <div class="control has-text-centered" id="prueba">
                  <button class="button is-success is-large" type="button" onclick="guardarFactura()">Guardar Factura</button>
                </div>
              </div>
              <div class="field">
                <div class="control has-text-centered">
                    <div id="facturaResult"></div>
                </div>
              </div>
              <div class="field" style="position: absolute; top: 12px; left: 0;">
                  <a href="#" class="button is-link is-responsive btn-back" name="IrLogin">
                      <i class="fas fa-arrow-left" style="margin-right: 7px;"></i>Regresar atrás
                  </a>
              </div>
              <?php include "inc/btn_back.php" ?>
            </form>
              <form class="form" method="POST" action="php/invoice.php" target="_blank">
                <div class="field">          
                  <div class="control has-text-centered">
                      <button type="submit" href="php/invoice.php" target="_blank" class="button is-success is-light is-large"><i class="fa-solid fa-file-pdf"></i>|Imprimir</a></button>    
                      <input type="hidden" value="<?=$bill_id?>" name="bill_id">
                      <input type="hidden" name="cliente_cedula" value="<?= $check_factura['cliente_cedula']?>">
                      <input type="hidden" name="cliente_nombre" value="<?= $check_factura['cliente_nombre']?>">
                      <input type="hidden" name="cliente_ubicacion" value="<?= $check_factura['cliente_ubicacion']?>">
                      <input type="hidden" name="cliente_telefono" value="<?= $check_factura['cliente_telefono']?>">
                      <input type="hidden" name="factura_fecha" value="<?= $check_factura['factura_fecha']?>">                                                    
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <?php 
        }else{
        echo '  <div class="notification is-danger is-light animate-bounce" style="margin-top: 15px;">
                            <strong class="is-size-4">!Esta Factura No Existe!</strong><br>
                            
                    </div>';
        }
    }
        $check_producto = null;
        $check_factura = null;
        $check_bill_id = null;
    ?>  
</div>

<script id="animacion-alerta">
  function eliminarConTransicion(elemento) {
      elemento.classList.add('desaparecer');
      setTimeout(function() {
          elemento.remove();
      }, 500); // 500ms es la duración de la transición
  }

  // Configurar el observador de mutaciones
  var observer = new MutationObserver(function(mutationsList) {
      for (var mutation of mutationsList) {
          if (mutation.type === 'childList') {
              // Revisar los nodos agregados
              for (var node of mutation.addedNodes) {
                  if (node.nodeType === 1 && node.classList.contains('animate-bounce')) {
                      // Iniciar temporizador de 5 segundos para eliminar el div
                      setTimeout(function() {
                          eliminarConTransicion(node);
                      }, 4000);
                  }
              }
          }
      }
  });

  // Configurar el observador para observar cambios en el cuerpo del documento
  observer.observe(document.body, { childList: true, subtree: true });
 
</script>

<script id="cliente">

    function eliminarDatosCliente(){
      document.getElementById('cedula').value = "";
      document.getElementById('nombre').value = "";
      document.getElementById('ubicacion').value = "";
      document.getElementById('telefono').value = "";
      document.getElementById('cliente_id').value = "";
    }

    document.getElementById('resultados').innerHTML = 
      `<div class='has-text-centered '>
          <a class='button is-success' onclick='actualizarCliente()'>Modificar Cliente</a>
          <div id='result' class='pt-3'></div>
      </div>
      <div class='has-text-centered '>
          <a class='button is-danger is-light is-small' onclick='eliminarDatosCliente()'>Eliminar Datos</a>
          <div id='result' class='pt-3'></div>
      </div>          
      `;     
    
    document.getElementById('cedula').addEventListener('input', function() {
        var query = this.value;
        if (query === "") {
            document.getElementById('resultados').innerHTML = "Resultados";
            return;
        }
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'php/factura_nueva_cliente.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                document.getElementById('resultados').innerHTML = xhr.responseText;
                var resultados_clientes = document.getElementById('result');
                if (resultados_clientes) {
                    // El elemento existe, vaciamos su contenido
                    resultados_clientes.innerHTML = "";
                } 
            }
        };
        xhr.send('query=' + encodeURIComponent(query));
    });

    document.getElementById('resultados').addEventListener('click', function(e) {
        if (e.target && e.target.matches("div.resultado")) {
            var data = e.target.dataset;
            document.getElementById('cedula').value = data.cedula;
            document.getElementById('nombre').value = data.nombre;
            document.getElementById('ubicacion').value = data.ubicacion;
            document.getElementById('telefono').value = data.telefono;
            document.getElementById('cliente_id').value = data.cliente_id;
            document.getElementById('resultados').innerHTML = 
              `<div class='has-text-centered '>
                    <a class='button is-success' onclick='actualizarCliente()'>Modificar Cliente</a>
                  <div id='result' class='pt-3'></div>
              </div>
              <div class='has-text-centered '>
                  <a class='button is-danger is-light is-small' onclick='eliminarDatosCliente()'>Eliminar Datos</a>
                  <div id='result' class='pt-3'></div>
              </div>
              `;                    
        }
    });

    function guardarCliente() {
        var cedula = document.getElementById('cedula').value;
        var nombre = document.getElementById('nombre').value;
        var ubicacion = document.getElementById('ubicacion').value;
        var telefono = document.getElementById('telefono').value;

        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'php/factura_nueva_cliente_guardar.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var response = JSON.parse(xhr.responseText);
                document.getElementById('cliente_id').value = response.cliente_id; // Asignar el ID del cliente al campo oculto
                
                document.getElementById('resultados').innerHTML = 
                  `<div class='has-text-centered '>
                        <a class='button is-success' onclick='actualizarCliente()'>Modificar Cliente</a>
                      <div id='result' class='pt-3'></div>
                  </div>
                  <div class='has-text-centered '>
                      <a class='button is-danger is-light is-small' onclick='eliminarDatosCliente()'>Eliminar Datos</a>
                      <div id='result' class='pt-3'></div>
                  </div>
                  `;

                if (response.error) {
                    document.getElementById('result').innerHTML = `<div class="notification p-2 mb-2  title is-6 is-danger is-light animate-bounce">La Cedula ya Esta Registrada</div>`;
                }else{
                    document.getElementById('result').innerHTML = `<div class="notification p-2 mb-2  title is-6 is-success is-light animate-bounce">Guardado Correctamente</div>`;
                }
            }
        };
        xhr.send('cedula=' + encodeURIComponent(cedula) + '&nombre=' + encodeURIComponent(nombre) + '&ubicacion=' + encodeURIComponent(ubicacion) + '&telefono=' + encodeURIComponent(telefono));
    }

    function actualizarCliente() {
        var cedula = document.getElementById('cedula').value;
        var nombre = document.getElementById('nombre').value;
        var ubicacion = document.getElementById('ubicacion').value;
        var telefono = document.getElementById('telefono').value;
        var cliente_id = document.getElementById('cliente_id').value;

        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'php/factura_nueva_cliente_actualizar.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var response = JSON.parse(xhr.responseText);
                document.getElementById('cliente_id').value = response.cliente_id; // Asignar el ID del cliente al campo oculto
                if (response.error) {
                    document.getElementById('result').innerHTML = `<div class="notification p-2 mb-2  title is-6 is-danger is-light animate-bounce">Datos Imcompletos</div>`;
                }else{
                    document.getElementById('result').innerHTML = `<div class="notification p-2 mb-2  title is-6 is-success is-light animate-bounce">Actualizado Correctamente</div>`;
                }
            }
        };
        xhr.send('cedula=' + encodeURIComponent(cedula) + '&nombre=' + encodeURIComponent(nombre) + '&ubicacion=' + encodeURIComponent(ubicacion) + '&cliente_id=' + encodeURIComponent(cliente_id) + '&telefono=' + encodeURIComponent(telefono));
    }

</script>

<script id="producto">
  document.getElementById('producto').addEventListener('input', function() {
      var query = this.value;
      if (query === "") {
          document.getElementById('resultadosProductos').innerHTML = "Resultados";
          return;
      }
      var xhr = new XMLHttpRequest();
      xhr.open('POST', 'php/factura_nueva_producto.php', true);
      xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
      xhr.onreadystatechange = function() {
          if (xhr.readyState == 4 && xhr.status == 200) {
              document.getElementById('resultadosProductos').innerHTML = xhr.responseText;
          }
      };
      xhr.send('query=' + encodeURIComponent(query));
  });

  document.getElementById('resultadosProductos').addEventListener('click', function(e) {
      if (e.target && e.target.matches("div.resultado-producto")) {
          var data = e.target.dataset;
          agregarProducto(data.id, data.nombre, data.precio, data.foto,data.stock);
          document.getElementById('resultadosProductos').innerHTML = 'Resultados';
          document.getElementById('producto').value = '';
      }
  });

  function agregarProducto(id, nombre, precio, foto, stock) {

    var cantidades = document.querySelectorAll('.cantidad'); // Obtener todos los elementos con la clase 'cantidad'
    var producto_existe = false;

    cantidades.forEach(function(cantidad) {
        if (cantidad.dataset.id === id) {
          producto_existe = true;
        }
    });

    if(producto_existe == false){

      let producto_id = id;
      var contenedorProductos = document.getElementById('tabla');
      var divProducto = document.createElement('tr');
      var factura_id = <?=$_GET['bill_id_up']?>;
      divProducto.classList.add('producto-seleccionado');
      divProducto.classList.add('has-text-centered');
      divProducto.classList.add('has-background-link-100');

      // Verificar si la foto existe en la carpeta
      function verificarFoto(foto) {
          return new Promise((resolve, reject) => {
              var img = new Image();
              img.src = `img/productos/${foto}`;
              img.onload = function() {
                  // La imagen existe
                  resolve(`img/productos/${foto}`);
              };
              img.onerror = function() {
                  // La imagen no existe, usar la imagen predeterminada
                  resolve("img/producto.png");
              };
          });
      }

      verificarFoto(foto).then(rutaFoto => {
          
          var dolarValorBCV = <?php echo json_encode($_SESSION['dolar_valor_bcv']); ?>;
          dolarValorBCV = dolarValorBCV * precio;

          var dolarValorParalelo = <?php echo json_encode($_SESSION['dolar_valor_paralelo']); ?>;
          dolarValorParalelo = dolarValorParalelo * precio;

          function formatearNumero(numero) {
              return numero.toLocaleString('de-DE', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
          }
          precio = formatearNumero(precio);
          dolarValorBCV = formatearNumero(dolarValorBCV);
          dolarValorParalelo = formatearNumero(dolarValorParalelo);

          divProducto.innerHTML = `
              <td class="has-text-black" >${id}</td>
              <td class="has-text-black" >${nombre}</td>
              <td class="has-text-black has-text-weight-bold" >
                  <figure class="media-left is-flex is-justify-content-center">
                      <p class="image is-64x64">
                          <img src="${rutaFoto}">
                      </p>
                  </figure>
              </td>
              <td class="has-text-black" >${precio}$</td>
              <td class="has-text-black" >BCV: ${dolarValorBCV}bs <br> Monitor: ${dolarValorParalelo}bs</td>
              <td class="has-text-black" >
                <div class="is-flex is-flex-direction-column mr-4">
                  <input type="number" value="1" min="1" max="${stock}" class="cantidad input is-small" data-id="${id}"  data-precio="${precio}" oninput="actualizarMonto()">
                  <div class="mt-1">Inventario: ${stock}</div>
                </div>
              </td>
              <td class="has-text-black" id="${id}">Monto</td>
              <td>
                <div class="is-flex is-justify-content-center eliminarProducto" data-idproducto="${id}" data-idfactura="${factura_id}">
                  <button class="button is-danger is-small" type="button" onclick="eliminarProducto(this)">Eliminar</button>
                </div>
              </td>
          `;
          contenedorProductos.appendChild(divProducto);
          actualizarMonto();
      });
    }else{
      function mostrarProductoDuplicado() {
        let productoDuplicado = document.getElementById("productoDuplicado");
        let padreProductoDuplicado = document.getElementById("padreProductoDuplicado");
        
        
        // Si el elemento ya existe, eliminarlo primero
        if (productoDuplicado) {
            productoDuplicado.remove();
        }
        
        // Crear el elemento de nuevo
        productoDuplicado = document.createElement('span');
        productoDuplicado.id = "productoDuplicado";
        productoDuplicado.innerHTML = `<div class="notification title is-5 is-danger is-light animate-bounce">Este Producto ya fue Seleccionado</div>`;
        
        padreProductoDuplicado.appendChild(productoDuplicado);

        // Añadir la clase 'desaparecer' después de 3500 ms
        setTimeout(function() {
            productoDuplicado.classList.add("desaparecer");
        }, 3500);

        // Eliminar el elemento después de 5000 ms
        setTimeout(function() {
            productoDuplicado.remove();
        }, 5000);
      }
      // Llamar a la función
      mostrarProductoDuplicado();

    }
  }

  function actualizarMonto() {
      
      function formatearNumero(numero) {
        return numero.toLocaleString('de-DE', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
      }
  
      var totalMonto = 0;
      var cantidades = document.querySelectorAll('.cantidad');

      cantidades.forEach(function(input) {
          var precio = parseFloat(input.dataset.precio);
          var cantidad = parseInt(input.value);
          var producto_id = parseInt(input.dataset.id);

          console.log("precio: " + precio + " cantidad: " + cantidad + " producto_id: " + producto_id);

          if(producto_id < 100000){
            if (!isNaN(precio) && !isNaN(cantidad)) {
            totalMonto += precio * cantidad;
            
            var dolarValorBCV = <?php echo json_encode($_SESSION['dolar_valor_bcv']); ?>;
            var dolarValorBCV = dolarValorBCV * (cantidad*precio).toFixed(2);
            
            var dolarValorParalelo = <?php echo json_encode($_SESSION['dolar_valor_paralelo']); ?>;
            var dolarValorParalelo = dolarValorParalelo * (cantidad*precio).toFixed(2);   

            totalMontoProducto = formatearNumero((cantidad*precio));
            dolarValorBCV = formatearNumero(dolarValorBCV);
            dolarValorParalelo = formatearNumero(dolarValorParalelo);

            document.getElementById(producto_id).innerHTML = `Ref: ${totalMontoProducto}$<br>`;
            document.getElementById(producto_id).innerHTML += `BCV: ${dolarValorBCV}bs<br>`;
            document.getElementById(producto_id).innerHTML += `Monitor: ${dolarValorParalelo}bs<br>`;                      

            }else{
              document.getElementById(producto_id).innerText = "0.00$";
            }
          }else{
            totalMonto += precio * cantidad;
            
            var dolarValorBCV = <?php echo json_encode($_SESSION['dolar_valor_bcv']); ?>;
            var dolarValorBCV = dolarValorBCV * (cantidad*precio).toFixed(2);
            
            var dolarValorParalelo = <?php echo json_encode($_SESSION['dolar_valor_paralelo']); ?>;
            var dolarValorParalelo = dolarValorParalelo * (cantidad*precio).toFixed(2);   

            totalMontoProducto = formatearNumero((cantidad*precio));
            dolarValorBCV = formatearNumero(dolarValorBCV);
            dolarValorParalelo = formatearNumero(dolarValorParalelo);                     
           
          }
          
          
      });

      var dolarValorBCV = <?php echo json_encode($_SESSION['dolar_valor_bcv']); ?>;
      var dolarValorBCV = dolarValorBCV * totalMonto.toFixed(2);
      
      var dolarValorParalelo = <?php echo json_encode($_SESSION['dolar_valor_paralelo']); ?>;
      var dolarValorParalelo = dolarValorParalelo * totalMonto.toFixed(2);   
      
      totalMontoBCVIVA = (dolarValorBCV/100)*16;
      totalMontoMonitorIVA = (dolarValorParalelo/100)*16;

      totalMontoBCVPlus = totalMontoBCVIVA + dolarValorBCV;
      totalMontoMonitorPlus = totalMontoMonitorIVA + dolarValorParalelo;

      totalMontoBCVPlus = formatearNumero(totalMontoBCVPlus);
      totalMontoMonitorPlus = formatearNumero(totalMontoMonitorPlus);

      totalMontoBCVIVA = formatearNumero(totalMontoBCVIVA);
      totalMontoMonitorIVA = formatearNumero(totalMontoMonitorIVA);

      totalMontoReturn = totalMonto;
      totalMonto = formatearNumero(totalMonto);
      dolarValorBCV = formatearNumero(dolarValorBCV);
      dolarValorParalelo = formatearNumero(dolarValorParalelo);

      document.getElementById('totalMontoRef').innerText = totalMonto + "$";
      document.getElementById('totalMontoRef2').innerText = totalMonto + "$";

      document.getElementById('totalMontoBCV').innerText = dolarValorBCV + "bs";
      document.getElementById('totalMontoMonitor').innerText = dolarValorParalelo + "bs";

      document.getElementById('totalMontoBCVIVA').innerText = totalMontoBCVIVA + "bs";
      document.getElementById('totalMontoMonitorIVA').innerText = totalMontoMonitorIVA + "bs";

      document.getElementById('totalMontoBCVPLus').innerText = totalMontoBCVPlus + "bs";
      document.getElementById('totalMontoMonitorPlus').innerText = totalMontoMonitorPlus + "bs";

      return totalMontoReturn;
  }

  function eliminarProducto(button) {

    var producto_id = button.closest('.eliminarProducto').dataset.idproducto;
    var factura_id = button.closest('.eliminarProducto').dataset.idfactura;
    var producto_stock = button.closest('.eliminarProducto').dataset.stock;
    var producto_nombre = button.closest('.eliminarProducto').dataset.nombre;
    
    var producto_cantidad = parseInt(document.querySelector(`input[data-id="${producto_id}"]`).value);

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'php/factura_actualizar_eliminar_producto.php', true);
    xhr.setRequestHeader('Content-type', 'application/json');
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {

            const resultadoSeleccionado = button.closest('.producto-seleccionado');
            if (resultadoSeleccionado) {
              setTimeout(function() {      
                resultadoSeleccionado.remove();
                actualizarMonto();
              }, 2000);
              button.closest('.eliminarProducto').innerHTML = xhr.responseText;
                           
            }            
        }
    };
    var data = JSON.stringify({ producto_id:producto_id, factura_id:factura_id, producto_cantidad:producto_cantidad, producto_stock:producto_stock, producto_nombre:producto_nombre});

    xhr.send(data);
        
  }


</script>
<script>actualizarMonto()</script>

<script id="factura">
    function guardarFactura() {
        var cliente_id = document.getElementById('cliente_id').value;
        var concepto = document.getElementById('concepto').value;
        var observacion = document.getElementById('observacion').value;
        var productos = [];
        var cantidades = document.querySelectorAll('.producto-seleccionado');
        var factura_id = <?=$_GET['bill_id_up']?>

        cantidades.forEach(function(divProducto) {
            var id = divProducto.querySelector('.cantidad').dataset.id;
            var cantidad = divProducto.querySelector('.cantidad').value;
            if (id && cantidad) {
                productos.push({ id: id, cantidad: cantidad });
            }
        });

        var totalMonto = actualizarMonto(); // Obtener el monto total calculado

        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'php/factura_actualizar_guardar.php', true);
        xhr.setRequestHeader('Content-type', 'application/json');
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
              console.log(xhr.responseText); // Añadir log de respuesta
              document.getElementById('facturaResult').innerHTML = xhr.responseText;

            }
        };
        var data = JSON.stringify({ cliente_id: cliente_id, concepto: concepto, observacion: observacion, productos: productos, monto: totalMonto , factura_id:factura_id});
        console.log(data); // Añadir log de datos enviados
        xhr.send(data);
    }
</script>
