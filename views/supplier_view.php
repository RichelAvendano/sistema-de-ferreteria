<?php
    require_once "php/main.php";

    // Obtener el ID del proveedor desde la URL
    $supplier_id = $_GET['supplier_id'];

    // Consulta para obtener los datos del proveedor
    $conexion = conexion();
    $consulta = $conexion->prepare("SELECT * FROM proveedor WHERE proveedor_id = :supplier_id");
    $consulta->execute([':supplier_id' => $supplier_id]);

    // Obtener los datos del proveedor
    if ($consulta->rowCount() == 1) {
        $proveedor = $consulta->fetch();
    } else {
        echo '<div class="notification is-danger">Error: Proveedor no encontrado.</div>';
        exit();
    }
?>

<div class = "background-image" style="height: 100%;min-height: 100vh;">
  <section class="hero ">
    <div class="container is-fluid" style="margin-bottom:10px">
      <h1 class="title has-text-black">Proveedor</h1>
      <h2 class="subtitle has-text-black">Detalles del Proveedor</h2>
    </div>

    <div class="hero-body" style="flex-grow:0; padding-top: 0;padding-bottom: 10px;">
      <div class="container">
        <div class="columns is-centered">
          <div class="column is-three-quarters-desktopis-two-thirds-tablet">

            <form class="box has-background-link-light">
              <div class="title has-text-centered is-size-2 has-text-black">
                <i class="fa-regular fa-square-plus has-text-success"></i> Detalles del Proveedor
              </div>
              <div class="columns is-multiline">
                <div class="column is-half">
                  <div class="field">
                    <label for="nombre" class="subtitle is-12 has-text-weight-bold has-text-black">Nombre del Proveedor</label>
                    <div class="control has-icons-left">
                      <input type="text" class="input" id="nombre" maxlength="20" name="proveedor_nombre" value="<?php echo htmlspecialchars($proveedor['proveedor_nombre']); ?>" readonly>
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
                      <input type="text" class="input" id="rif" maxlength="20" name="proveedor_rif" value="<?php echo htmlspecialchars($proveedor['proveedor_rif']); ?>" readonly style="padding-left:55px">
                      <span class="icon is-small is-left" style="width:60px">
                        <i class="fa-solid fa-id-card"></i>
                        <span class="ml-2">J -</span>
                      </span>
                    </div>
                  </div>
                </div>
                <div class="column is-half">
                  <div class="field">
                    <label for="direccion" class="subtitle is-12 has-text-weight-bold has-text-black">Dirección del Proveedor</label>
                    <div class="control has-icons-left">
                      <input type="text" class="input" id="direccion" maxlength="20" name="proveedor_direccion" value="<?php echo htmlspecialchars($proveedor['proveedor_direccion']); ?>" readonly>
                      <span class="icon is-small is-left">
                        <i class="fa-solid fa-location-dot"></i>
                      </span>
                    </div>
                  </div>
                </div>
                <div class="column is-half">
                  <div class="field">
                    <label for="telefono" class="subtitle is-12 has-text-weight-bold has-text-black">Teléfono del Proveedor</label>
                    <div class="control has-icons-left">
                      <input type="text" class="input" id="telefono" maxlength="20" name="proveedor_telefono" value="<?php echo htmlspecialchars($proveedor['proveedor_telefono']); ?>" readonly>
                      <span class="icon is-small is-left">
                        <i class="fa-solid fa-phone"></i>
                      </span>
                    </div>
                  </div>
                </div>
                <div class="column is-half">
                  <div class="field">
                    <label for="contacto_telefono" class="subtitle is-12 has-text-weight-bold has-text-black">Teléfono del Contacto</label>
                    <div class="control has-icons-left">
                      <input type="text" class="input" id="contacto_telefono" maxlength="20" name="proveedor_contacto_telefono" value="<?php echo htmlspecialchars($proveedor['proveedor_contacto_telefono']); ?>" readonly>
                      <span class="icon is-small is-left">
                        <i class="fa-solid fa-phone"></i>
                      </span>
                    </div>
                  </div>
                </div>              
                <div class="column is-half">
                  <div class="field">
                    <label for="contacto_persona" class="subtitle is-12 has-text-weight-bold has-text-black">Persona de Contacto</label>
                    <div class="control has-icons-left">
                      <input type="text" class="input" id="contacto_persona" maxlength="20" name="proveedor_contacto_persona" value="<?php echo htmlspecialchars($proveedor['proveedor_contacto_persona']); ?>" readonly>
                      <span class="icon is-small is-left">
                        <i class="fas fa-user"></i>
                      </span>
                    </div>
                  </div>
                </div>
                <div class="column is-half">
                  <div class="field">
                    <label for="condicion_pago" class="subtitle is-12 has-text-weight-bold has-text-black"><i class="fa-solid fa-money-bill"></i> Condición de Pago</label>
                    <div class="control has-icons-left">
                        <textarea class="textarea has-fixed-size" id="condicion_pago" name="proveedor_condicion_pago" rows="3" readonly><?php echo htmlspecialchars($proveedor['proveedor_condicion_pago']); ?></textarea>
                    </div>
                  </div>
                </div> 
                <div class="column is-half">
                  <div class="field">
                    <label for="observacion" class="subtitle is-12 has-text-weight-bold has-text-black"><i class="fa-regular fa-comment"></i> Observación del Proveedor</label>
                    <div class="control has-icons-left">
                        <textarea class="textarea has-fixed-size" id="proveedor_observacion" name="proveedor_observacion" rows="3" readonly><?php echo htmlspecialchars($proveedor['proveedor_observacion']); ?></textarea>
                    </div>
                  </div>
                </div>
              </div>
              <div class="columns">
                <div class="column has-text-centered">
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
