<?php
if(isset($_SESSION['id'])){
  session_destroy();
}
?>

<section class="hero has-background-light is-fullheight background-image" style="height:100%;min-height: 100vh;">
  <div id="resultado"></div>
  <div class="hero-body">
    <div class="container">
      <div class="columns is-centered">
        <div class="column is-three-quarters-desktopis-two-thirds-tablet">

          <form action="./php/usuario_register.php" class="FormularioAjax box has-background-link-light" autocomplete="off" method="POST" id="myForm" onsubmit="return confirmSubmit()" data-confirm="true">

            <div class="title has-text-centered is-size-2 has-text-weight-bold has-text-black">Registrarse</div>
            <div class="columns is-multiline">
              <div class="column is-half">
                <div class="field">
                  <label for="usuario" class="subtitle is-12 has-text-weight-bold has-text-black">Usuario</label>
                  <div class="control has-icons-left">
                    <input type="text" class="input" required id="usuario" pattern="[a-zA-Z0-9]{4,20}" maxlength="20" name="usuario_usuario">
                    <span class="icon is-small is-left">
                      <i class="fas fa-user"></i>
                    </span>
                  </div>
                </div>
              </div>
              <div class="column is-half">
                <label for="password" class="subtitle is-12 has-text-weight-bold has-text-black">Password</label>
                <div class="field is-grouped">
                  <div class="control is-expanded has-icons-left">
                    <input type="password" class="input" placeholder="*******" required id="password_1" maxlength="100" name="usuario_clave_1">
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
                    <input type="password" class="input" placeholder="*******" required id="repetir_password" maxlength="100" name="usuario_clave_2">
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
            <div class="columns">
                <div class="column has-text-centered">
                    <button type="submit" class="button is-warning is-medium is-responsive" name="Enviar">Registrarse</button>
                    <div class="field" style="position: absolute; top: 0; left: 0;">
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

<div id="myModal" class="modal-css">
    <div class="modal-content-css">
        <span class="close-css" onclick="closeModal()">&times;</span>
        <p style="color:black">¿Estás seguro de que quieres enviar el formulario?</p>
        <button class="btn btn-confirm" onclick="submitForm()">Sí</button>
        <button class="btn btn-cancel" onclick="closeModal()">No</button>
    </div>
</div>
