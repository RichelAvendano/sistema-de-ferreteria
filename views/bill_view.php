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
    <h2 class="subtitle has-text-black has-text-centered">Ver Factura</h2>
  </div>
  <section class="hero ">

    <?php 
        require_once "php/main.php";
        date_default_timezone_set("America/Caracas");

        if(isset($_GET['bill_id']) && !empty($_GET['bill_id'])){
            $bill_id = $_GET['bill_id'];

            $check_bill_id = conexion();
            $check_bill_id = $check_bill_id->query("SELECT factura_id FROM factura WHERE factura_id = '$bill_id'");

            if($check_bill_id->rowCount() == 1){

                $check_factura = conexion();
                $check_factura = $check_factura->query("SELECT cliente.cliente_cedula, cliente.cliente_nombre,cliente.cliente_ubicacion, cliente.cliente_telefono, factura.factura_monto, factura.factura_fecha,factura.factura_concepto,factura.factura_observacion,factura.cliente_id FROM factura INNER JOIN cliente ON factura.cliente_id = cliente.cliente_id WHERE factura.factura_id = ".$bill_id."" ); 
                
                $flag = false;

                $check_producto = conexion();
                $check_producto = $check_producto->query("SELECT factura_producto.producto_cantidad, factura_producto.factura_id , producto.producto_nombre, producto.producto_precio,producto.producto_foto, producto.producto_id, producto.producto_stock FROM factura_producto INNER JOIN producto ON factura_producto.producto_id = producto.producto_id WHERE factura_producto.factura_id = ".$bill_id."");
                
                $check_factura = $check_factura->fetch();
                $check_producto = $check_producto->fetchAll();

                
    ?>

    <div class="hero-body" style="flex-grow:0; padding-top: 0;padding-bottom: 10px;">
      <div class="container">
        <div class="columns is-centered">
          <div class="column ">

            <form class="box has-background-link-light" method="POST" action="php/invoice.php" target="_blank">
              <input type="hidden" id="cliente_id" value="<?= $check_factura['cliente_id'] ?>">

              <div class="title has-text-centered is-size-2 has-text-black">Factura</div>
              <div class="title is-size-4 has-text-black">Cliente</div>
              <div class="columns is-multiline  ">
                <div class="column is-half">
                  <div class="field">
                    <label for="cedula" class="subtitle is-12 has-text-weight-bold has-text-black">Cédula</label>
                    <div class="control has-icons-left">
                      <input type="number" class="input is-focused" required id="cedula" pattern="[0-9]{9,}" maxlength="9" name="cliente_cedula" value="<?= $check_factura['cliente_cedula']?>" readonly>
                      <span class="icon is-small is-left">
                        <i class="fa fa-id-card"></i>
                      </span>
                    </div>
                  </div>
                </div>
                <div class="column is-half">
                  <div class="field">
                    <label for="nombre" class="subtitle is-12 has-text-weight-bold has-text-black">Nombre</label>
                    <div class="control has-icons-left">
                      <input type="text" class="input" required id="nombre" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="40" name="cliente_nombre" value="<?= $check_factura['cliente_nombre']?>" readonly>
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
                      <input type="text" class="input" id="ubicacion" maxlength="200" name="cliente_ubicacion" value="<?= $check_factura['cliente_ubicacion']?>" readonly>
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
              <div class="title is-size-4 has-text-black">Productos</div>
              <div class="columns is-multiline  ">
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
                                              <input readonly type="number" value="'.$rows['producto_cantidad'].'" min="1" max="'.$rows['producto_stock'].'" class="cantidad input is-small" data-id="'.$rows['producto_id'].'"  data-precio="'.$rows['producto_precio'].'" oninput="actualizarMonto() ">
                                              <div class="mt-1">Inventario: '.$rows['producto_stock'].'</div>
                                            </div>
                                          </td>
                                          <td class="has-text-black" id="'.$rows['producto_id'].'">
                                            Ref: '.$valorTotalProductoRef.'$<br>
                                            BCV:  '.$valorTotalProductoBCV.'bs<br>
                                            Monitor:  '.$valorTotalProductoMonitor.'bs<br>
                                          </td>
                                      </tr>
                              ';
                          }

                          $check_producto = conexion();
                          $check_producto = $check_producto->query("SELECT producto_cantidad, producto_nombre, producto_precio FROM factura_producto WHERE factura_id = $bill_id AND producto_id IS NULL");
                          
                          if($check_producto->rowCount()>0){
                            $check_producto = $check_producto->fetchAll();

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
                                        <input readonly type="number" value="'.$rows['producto_cantidad'].'" min="1" max="nulo" class="cantidad input is-small" data-id="nulo"  data-precio="'.$rows['producto_precio'].'" oninput="actualizarMonto() ">
                                        <div class="mt-1">Inventario: Ninguno</div>
                                      </div>
                                    </td>
                                    <td class="has-text-black" id="nulo">
                                      Ref: '.$valorTotalProductoRef.'$<br>
                                      BCV:  '.$valorTotalProductoBCV.'bs<br>
                                      Monitor:  '.$valorTotalProductoMonitor.'bs<br>
                                    </td>
                                </tr>
                              ';
                            }
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
                      <input type="text" class="input" id="concepto" value="<?= $check_factura['factura_concepto'] ?>" readonly>
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
                      <input type="text" class="input" id="observacion" value="<?= $check_factura['factura_observacion'] ?>" readonly>
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
              
                  
              <div class="field" style="position: absolute; top: 12px; left: 0;">
                  <a href="#" class="button is-link is-responsive btn-back" name="IrLogin">
                      <i class="fas fa-arrow-left" style="margin-right: 7px;"></i>Regresar atrás
                  </a>
              </div>
              <?php include "inc/btn_back.php" ?>
              <div class="field">          
                <div class="control has-text-centered">
                     <input type="hidden" value="<?=$bill_id?>" name="bill_id">    
                    <button type="submit" href="php/invoice.php" target="_blank" class="button is-success is-light is-large"><i class="fa-solid fa-file-pdf"></i>|Imprimir</a></button>                                   
                </div>
              </div>
            </form>            
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


<script id="producto">

  function actualizarMonto() {
      
      function formatearNumero(numero) {
        return numero.toLocaleString('de-DE', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
      }
  
      var totalMonto = 0;
      var cantidades = document.querySelectorAll('.cantidad');
      cantidades.forEach(function(input) {
          var precio = parseFloat(input.dataset.precio);
          var cantidad = parseInt(input.value);

          if (!isNaN(precio) && !isNaN(cantidad)) {
            totalMonto += precio * cantidad;
            
            var dolarValorBCV = <?php echo json_encode($_SESSION['dolar_valor_bcv']); ?>;
            var dolarValorBCV = dolarValorBCV * (cantidad*precio).toFixed(2);
            
            var dolarValorParalelo = <?php echo json_encode($_SESSION['dolar_valor_paralelo']); ?>;
            var dolarValorParalelo = dolarValorParalelo * (cantidad*precio).toFixed(2);   

            totalMontoProducto = formatearNumero((cantidad*precio));
            dolarValorBCV = formatearNumero(dolarValorBCV);
            dolarValorParalelo = formatearNumero(dolarValorParalelo);                              

          }else{
            document.getElementById(producto_id).innerText = "0.00$";
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
    


</script>
<script>actualizarMonto()</script>

