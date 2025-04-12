<?php
if(isset($_SESSION['id'])){
  session_destroy();
}
?>
<style>
  .image{
    width: 250px;
    height: 150px;
    animation: pulse 2s infinite ease-in-out;
    }

    /* Definición de la animación */
    @keyframes pulse {
        0% {
            transform: scale(1); /* Tamaño normal */
        }
        50% {
            transform: scale(1.05); /* Aumenta un 20% */
        }
        100% {
            transform: scale(1); /* Vuelve al tamaño normal */
        }
    }
</style>

<section class="hero is-fullheight has-background-light background-image" style="height:100%;min-height: 100vh;">  
  <div class="hero-body pt-2">  
    <div class="container ">
      <div class="is-flex is-justify-content-center is-align-items-center mb-3">
        <figure >
          <img src="img/logo_ferreteria.png" class="image">
        </figure>
      </div>
      <div class="columns is-centered" >
        
        <div class="column  is-6-tablet is-6-desktop ">         
          <form action="" class="box has-background-link-light" method="POST">
            <div class="title has-text-centered is-size-1 has-text-weight-bold has-text-black">Iniciar Sesión</div>
            <div class="field">
              <label for="usuario" class="label has-text-weight-bold has-text-black">Usuario</label>
              <div class="control has-icons-left">
                <input type="text" placeholder="" class="input" required id="usuario" name="login_usuario" value="<?php echo isset($_POST['login_usuario']) ? htmlspecialchars($_POST['login_usuario']) : ''; ?>">
                <span class="icon is-small is-left">
                  <i class="fas fa-user"></i>
                </span>
              </div>
            </div>
            <div class="field">
              <label for="password" class="label has-text-weight-bold has-text-black">Password</label>
              <div class="field is-grouped">
                <div class="control is-expanded has-icons-left">
                  <input type="password" class="input" placeholder="*******" required id="password" maxlength="100" name="login_password" value="<?php echo isset($_POST['login_password']) ? htmlspecialchars($_POST['login_password']) : ''; ?>">
                  <span class="icon is-small is-left">
                    <i class="fas fa-lock""></i>
                  </span>
                </div>
                <div class="control">
                <button type="button" class="button is-link is-light toggle-password" data-target="password">
                    <span class="icon"> 
                      <i class="fas fa-eye"></i> 
                    </span>
                  </button>
                </div>
              </div>
            </div>
            <div class="field is-grouped">
              <div class="control">
                <button class="button is-warning ">
                  Iniciar
                </button>
              </div>
              <div class="control">
                <a href="index.php?view=register" class="button is-success">Registrarse</a>
              </div>
            </div>
            <div class="field">
              <?php
                if(isset($_POST['login_usuario']) && isset($_POST['login_password'])){
                    require_once "php/main.php";
                    require_once "php/iniciar_sesion.php";
                }
              ?>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

<script id="mostrar_password">
  document.addEventListener('DOMContentLoaded', () => {
      const togglePasswordButtons = document.querySelectorAll('.toggle-password');

      togglePasswordButtons.forEach(button => {
          button.addEventListener('click', () => {
              const targetId = button.getAttribute('data-target');
              const passwordInput = document.getElementById(targetId);
              const togglePasswordIcon = button.querySelector('.fas');

              if (passwordInput) {
                  if (passwordInput.type === 'password') {
                      passwordInput.type = 'text';
                      togglePasswordIcon.classList.remove('fa-eye');
                      togglePasswordIcon.classList.add('fa-eye-slash');
                  } else {
                      passwordInput.type = 'password';
                      togglePasswordIcon.classList.remove('fa-eye-slash');
                      togglePasswordIcon.classList.add('fa-eye');
                  }
              } else {
                  console.error(`No se encontró el elemento de entrada con ID ${targetId}.`);
              }
          });
      });
  });
</script>