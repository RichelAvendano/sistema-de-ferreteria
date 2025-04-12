<?php 

  require_once "php/main.php";

  $id = (isset($_GET['user_id_up'])) ? $_GET['user_id_up'] : 0 ;
  $id = limpiar_cadena($id);
  $check_usuario = conexion();
  $check_usuario = $check_usuario->query("SELECT * FROM usuario WHERE usuario_id = '$id'");

  if($check_usuario->rowCount()>0){
    $datos = $check_usuario->fetch();
    
?>
<div class=" background-image" style="height:100%;min-height: 100vh;">
  <div class="box is-inline-block has-background-link-95 ml-3 mb-0 mt-2 p-4">
    <?php if($id==$_SESSION['id']) {?>
      <h1 class="title is-4 has-text-black has-text-centered">Mi Cuenta</h1>
      <h2 class="subtitle has-text-black has-text-centered">Actualizar Datos de Cuenta</h2>
    <?php }else{ ?>
      <h1 class="title is-4 has-text-black has-text-centered">Usuarios</h1>
      <h2 class="subtitle has-text-black has-text-centered">Actualizar Usuario</h2>
    <?php }?>
  </div>
  <section class="hero">
    <div class="hero-body pt-5 pb-2
    ">
      <div class="container">
        <div class="columns is-centered">
          <div class="column is-three-quarters-desktopis-two-thirds-tablet">

            <form action="php/usuario_actualizar.php" class="FormularioAjax box has-background-link-light" autocomplete="off" method="POST" id="myForm" onsubmit="return confirmSubmit()" data-confirm="true">
              <input type="hidden" value="<?php echo $datos['usuario_id'];?>" name="usuario_id" required >

              <div class="title has-text-centered is-size-2 has-text-weight-bold has-text-black">Actualizar Datos</div>
              <div class="columns is-multiline">  
                
                <div class="column is-half">
                  <div class="field">
                    <label for="usuario" class="subtitle is-12 has-text-weight-bold has-text-black">Usuario</label>
                    <div class="control has-icons-left">
                      <input type="text" class="input" value="<?php echo $datos['usuario_usuario'];?>" required id="usuario_up" pattern="[a-zA-Z0-9]{4,20}" maxlength="20" name="usuario_usuario">
                      <span class="icon is-small is-left">
                        <i class="fas fa-user"></i>
                      </span>
                    </div>
                  </div>
                </div>
                <div class="field px-2 pt-3 pb" style="width:100%;margin:0">
                  <hr class="m-2">
                  <p class="has-text-centered has-text-weight-bold has-text-black">
                      SI desea actualizar la clave de este usuario por favor llene los 2 campos. Si NO desea actualizar la clave deje los campos vacíos.
                  </p>    
                </div>
                <div class="column is-half">
                  <label for="password" class="subtitle is-12 has-text-weight-bold has-text-black">Contraseña</label>
                  <div class="field is-grouped">
                    <div class="control is-expanded has-icons-left">
                      <input type="password" class="input" placeholder="*******" id="password_1" maxlength="100" name="usuario_clave_1">
                      <span class="icon is-small is-left">
                        <i class="fas fa-lock""></i>
                      </span>
                    </div>
                    <div class="control">
                    <button type="button" class="button is-link is-light toggle-password" data-target="password_1">
                        <span class="icon"> 
                          <i class="fas fa-eye"></i> 
                        </span>
                      </button>
                    </div>
                  </div>
                </div>
                <div class="column is-half">
                  <label for="password" class="subtitle is-12 has-text-weight-bold has-text-black">Repetir Contraseña</label>
                  <div class="field is-grouped">
                    <div class="control is-expanded has-icons-left">
                      <input type="password" class="input" placeholder="*******" id="repetir_password" maxlength="100" name="usuario_clave_2">
                      <span class="icon is-small is-left">
                        <i class="fas fa-lock""></i>
                      </span>
                    </div>
                    <div class="control">
                    <button type="button" class="button is-link is-light toggle-password" data-target="repetir_password">
                        <span class="icon"> 
                          <i class="fas fa-eye"></i> 
                        </span>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
              <div class="field px-2 pb-4" style="width:100%;margin:0">
                <p id = "resultado" class="subtitle container is-fluid"></p>    
              </div>        
              <div class="columns is-multiline is-vcentered">
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
  $check_usuario = null;
?>
<div id="myModal" class="modal-css">
    <div class="modal-content-css">
        <span class="close-css" onclick="closeModal()">&times;</span>
        <p style="color:black">¿Estás seguro de que quieres enviar el formulario?</p>
        <button class="btn btn-confirm" onclick="submitForm()">Sí</button>
        <button class="btn btn-cancel" onclick="closeModal()">No</button>
    </div>
</div>
