<div class = "background-image" style="height: 100%;min-height: 100vh;">
  <div class="box is-inline-block has-background-link-95 ml-3 mb-3 mt-2 p-4"  >
    <h1 class="title is-4 has-text-black has-text-centered">Proveedor</h1>
    <h2 class="subtitle has-text-black has-text-centered">NuevoProveedor</h2>
  </div>
  <section class="hero ">
    <div class="hero-body" style="flex-grow:0; padding-top: 0;padding-bottom: 10px;">
      <div class="container">
        <div class="columns is-centered">
          <div class="column is-three-quarters-desktopis-two-thirds-tablet">

            <form action="./php/proveedor_guardar.php" class="FormularioAjax box has-background-link-light" autocomplete="off" method="POST" id="myForm" onsubmit="return confirmSubmit()" data-confirm="true">

              <div class="title has-text-centered is-size-2 has-text-black"><i class="fa-regular fa-square-plus has-text-success"></i> Nuevo Proveedor</div>
              <div class="columns is-multiline  ">
                <div class="column is-half">
                  <div class="field">
                    <label for="nombre" class="subtitle is-12 has-text-weight-bold has-text-black">Nombre del Proveedor</label>
                    <div class="control has-icons-left">
                      <input type="text" class="input" required id="nombre" maxlength="20" name="proveedor_nombre">
                      <span class="icon is-small is-left">
                        <i class="fas fa-user"></i>
                      </span>
                    </div>
                  </div>
                </div>
                <div class="column is-half">
                  <div class="field">
                    <label for="rif" class="subtitle is-12 has-text-weight-bold has-text-black">Rif del Proveedor</label>
                    <div class="control has-icons-left">
                      <input type="number" class="input" required id="rif" maxlength="20" name="proveedor_rif" style="padding-left:55px">
                      <span class="icon is-small is-left" style="width:60px">
                        <i class="fa-solid fa-id-card"></i>
                        <span class="ml-2">J -</span>
                      </span>
                    </div>
                  </div>
                </div>
                <div class="column is-half">
                  <div class="field">
                    <label for="direccion" class="subtitle is-12 has-text-weight-bold has-text-black">Direccion del Proveedor</label>
                    <div class="control has-icons-left">
                      <input type="text" class="input" required id="direccion" maxlength="20" name="proveedor_direccion">
                      <span class="icon is-small is-left">
                        <i class="fa-solid fa-location-dot"></i>
                      </span>
                    </div>
                  </div>
                </div>
                <div class="column is-half">
                  <div class="field">
                    <label for="telefono" class="subtitle is-12 has-text-weight-bold has-text-black">Telefono del Proveedor</label>
                    <div class="control has-icons-left">
                      <input type="text" class="input" required id="telefono" maxlength="20" name="proveedor_telefono">
                      <span class="icon is-small is-left">
                        <i class="fa-solid fa-phone"></i>
                      </span>
                    </div>
                  </div>
                </div>
                <div class="column is-half">
                  <div class="field">
                    <label for="condicion_pago" class="subtitle is-12 has-text-weight-bold has-text-black"><i class="fa-solid fa-money-bill"></i> Condicion de Pago</label>
                    <div class="control has-icons-left">
                        <textarea class="textarea has-fixed-size" id="condicion_pago" name="proveedor_condicion_pago" rows="3"></textarea>
                    </div>
                  </div>
                </div>
                <div class="column is-full">
                    <hr class="divider">
                    <h2 class="title is-4 has-text-centered has-text-black">Estos Datos son Opcionales</h2>
                </div>
                
                <div class="column is-half">
                  <div class="field">
                    <label for="contacto_persona" class="subtitle is-12 has-text-weight-bold has-text-black">Persona de Contacto</label>
                    <div class="control has-icons-left">
                      <input type="text" class="input" id="contacto_persona" maxlength="20" name="proveedor_contacto_persona">
                      <span class="icon is-small is-left">
                        <i class="fas fa-user"></i>
                      </span>
                    </div>
                  </div>
                </div>
                <div class="column is-half">
                  <div class="field">
                    <label for="contacto_telefono" class="subtitle is-12 has-text-weight-bold has-text-black">Telefono del Contacto</label>
                    <div class="control has-icons-left">
                      <input type="text" class="input" id="contacto_telefono" maxlength="20" name="proveedor_contacto_telefono">
                      <span class="icon is-small is-left">
                        <i class="fa-solid fa-phone"></i>
                      </span>
                    </div>
                  </div>
                </div>
                
                <div class="column is-half">
                  <div class="field">
                    <label for="observacion" class="subtitle is-12 has-text-weight-bold has-text-black"><i class="fa-regular fa-comment"></i> Observacion del Proveedor</label>
                    <div class="control has-icons-left">
                        <textarea class="textarea has-fixed-size" id="proveedor_observacion" name="proveedor_observacion" rows="3"></textarea>
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
                    <p id = "resultado" class="subtitle container is-fluid"></p>
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
