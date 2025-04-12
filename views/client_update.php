<?php 

  require_once "php/main.php";

  $id = (isset($_GET['client_id_up'])) ? $_GET['client_id_up'] : 0 ;
  $id = limpiar_cadena($id);
  $check_cliente = conexion();
  $check_cliente = $check_cliente->query("SELECT * FROM cliente WHERE cliente_id = '$id'");

  if($check_cliente->rowCount()>0){
    $datos = $check_cliente->fetch();
    
?>
<div class=" background-image" style="height:100%;min-height: 100vh;">
  <div class="box is-inline-block has-background-link-95 ml-3 mb-0 mt-2 p-4"  >
    <h1 class="title is-4 has-text-black has-text-centered">Cliente</h1>
    <h2 class="subtitle has-text-black has-text-centered">Actualizar Cliente</h2>
  </div>
  <section class="hero" >
    <div class="hero-body pt-5 pb-2
    ">
      <div class="container">
        <div class="columns is-centered">
          <div class="column is-three-quarters-desktopis-two-thirds-tablet">

            <form action="php/cliente_actualizar.php" class="FormularioAjax box has-background-link-light" autocomplete="off" method="POST" id="myForm" onsubmit="return confirmSubmit()" data-confirm="true">
              <input type="hidden" value="<?php echo $datos['cliente_id'];?>" name="cliente_id" required >

              <div class="title has-text-centered is-size-2 has-text-weight-bold has-text-black">Actualizar Datos</div>
              <div class="columns is-multiline">
                <div class="column is-half">
                  <div class="field">
                    <label for="nombre" class="subtitle is-12 has-text-weight-bold has-text-black">Nombre</label>
                    <div class="control has-icons-left">
                      <input type="text" class="input" value="<?php echo $datos['cliente_nombre'];?>" required id="nombre" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="40" name="cliente_nombre">
                      <span class="icon is-small is-left">
                        <i class="fas fa-user"></i>
                      </span>
                    </div>
                  </div>
                </div>
                <div class="column is-half">
                  <div class="field">
                    <label for="cedula" class="subtitle is-12 has-text-weight-bold has-text-black">Cédula</label>
                    <div class="control has-icons-left">
                      <input type="number" class="input" value="<?php echo $datos['cliente_cedula'];?>" required id="cedula" pattern="^[0-9]{1,8}$" maxlength="40" name="cliente_cedula">
                      <span class="icon is-small is-left">
                        <i class="fa fa-id-card"></i>
                      </span>
                    </div>
                  </div>
                </div>                  
                <div class="column is-half">
                  <div class="field">
                    <label for="ubicacion" class="subtitle is-12 has-text-weight-bold has-text-black">Ubicacion</label>
                    <div class="control has-icons-left">
                      <input type="text" class="input" value="<?php echo $datos['cliente_ubicacion'];?>" required id="cliente_ubicacion" maxlength="200" name="cliente_ubicacion">
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
                      <input type="text" class="input" id="telefono" maxlength="200" name="cliente_telefono" value="<?php echo $datos['cliente_telefono'];?>">
                      <span class="icon is-small is-left">
                        <i class="fa-solid fa-phone"></i>
                      </span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="field px-2 pb-4" style="width:100%;margin:0">
                <p id = "resultado" class="subtitle container is-fluid"></p>    
              </div>        
              <div class="columns">
                <div class="column has-text-centered">
                    <button type="submit" class="button is-warning is-medium is-responsive" name="Enviar">Actualizar</button>
                    <div class="field" style="position: absolute; top: 12px; left: 0;">
                        <a href="#" class="button is-link is-responsive btn-back" name="IrLogin">
                            <i class="fas fa-arrow-left" style="margin-right: 7px;"></i>Regresar atrás
                        </a>
                    </div>
                    <?php include "inc/btn_back.php" ?>
                </div>         
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<?php 
  }else{
    echo '<div class="column notification is-danger my-2">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            No podemos obtener la información solicitada
          </div> ';
  }
  $check_cliente = null;
?>
<div id="myModal" class="modal-css">
    <div class="modal-content-css">
        <span class="close-css" onclick="closeModal()">&times;</span>
        <p style="color:black">¿Estás seguro de que quieres enviar el formulario?</p>
        <button class="btn btn-confirm" onclick="submitForm()">Sí</button>
        <button class="btn btn-cancel" onclick="closeModal()">No</button>
    </div>
</div>
