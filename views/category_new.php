<div class=" background-image" style="height:100%;min-height: 100vh;">
    <div class="field" style="position: absolute; top: 10px; right: 10px;">
        <a href="#" class="button is-link is-responsive btn-back" name="IrLogin">
            <i class="fas fa-arrow-left" style="margin-right: 7px;"></i>Regresar atrás
        </a>
        <?php include "inc/btn_back.php" ?>
    </div>
    <div class="box is-inline-block has-background-link-95 ml-3 mb-0 mt-2 p-4">
        <h1 class="title is-4 has-text-black has-text-centered">Categoria</h1>
        <h2 class="subtitle has-text-black has-text-centered">Nueva Categoria</h2>
    </div>
    <section class="hero">
        <p id = "resultado" class="subtitle container is-fluid"></p>
        <div class="hero-body pb-0 pt-3">  
            <div class="container ">
                <div class="columns is-centered" >
                    <div class="column  is-6-tablet is-6-desktop ">         
                    <form action="php/categoria_guardar.php" class="FormularioAjax box has-background-link-light " method="POST">
                        <div class="title has-text-centered is-size-1 has-text-weight-bold has-text-black">Nueva Categoria</div>
                        <div class="field">
                        <label for="usuario" class="label has-text-weight-bold has-text-black">Nombre</label>
                        <div class="control has-icons-left">
                            <input type="text" placeholder="" class="input" required id="categoria_nombre" name="categoria_nombre">
                            <span class="icon is-small is-left">
                            <i class="fas fa-file-alt"></i>
                            </span>
                        </div>
                        </div>
                        <div class="field">
                        <label for="password" class="label has-text-weight-bold has-text-black">Ubicación (Opcional)</label>
                        <div class="field is-grouped">
                            <div class="control is-expanded has-icons-left">
                            <input type="text" class="input" id="categoria_ubicacion" name="categoria_ubicacion" v>
                            <span class="icon is-small is-left">
                                <i class="fas fa-file-alt"></i>
                            </span>
                            </div>
                        </div>
                        </div>
                        <div class="columns">
                            <div class="column has-text-centered">
                                <button type="submit" class="button is-warning is-medium is-responsive" name="Enviar">Enviar</button>
                                
                            </div>         
                        </div>
                        <div class="field" style="position: absolute; top: 12px; left: 0;">
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
