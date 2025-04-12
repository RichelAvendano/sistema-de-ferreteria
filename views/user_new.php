<div class = "background-image" style="height: 100%;min-height: 100vh;">
  <div class="box is-inline-block has-background-link-95 ml-3 mb-0 mt-2 p-4"  >
    <h1 class="title is-4 has-text-black has-text-centered">Usuarios</h1>
    <h2 class="subtitle has-text-black has-text-centered">Nuevo Usuario</h2>
  </div>
  <section class="hero ">
    
    <p id = "resultado" class="subtitle container is-fluid"></p>

    <div class="hero-body" style="flex-grow:0; padding-top: 0;padding-bottom: 10px;">
      <div class="container">
        <div class="columns is-centered">
          <div class="column is-three-quarters-desktopis-two-thirds-tablet">

            <form action="./php/usuario_guardar.php" class="FormularioAjax box has-background-link-light" autocomplete="off" method="POST" id="myForm" onsubmit="return confirmSubmit()" data-confirm="true">

              <div class="title has-text-centered is-size-2 has-text-black">Nuevo Usuario</div>
              <div class="columns is-multiline  ">
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
                    <button type="submit" class="button is-warning is-medium is-responsive" name="Enviar">Guardar</button>
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

<div id="myModal" class="modal-css">
    <div class="modal-content-css">
        <span class="close-css" onclick="closeModal()">&times;</span>
        <p style="color:black">¿Estás seguro de que quieres enviar el formulario?</p>
        <button class="btn btn-confirm" onclick="submitForm()">Sí</button>
        <button class="btn btn-cancel" onclick="closeModal()">No</button>
    </div>
</div>
