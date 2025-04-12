<script is="navbar">
    document.addEventListener('DOMContentLoaded', () => {

    // Get all "navbar-burger" elements
    const $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);

    // Add a click event on each of them
    $navbarBurgers.forEach( el => {
    el.addEventListener('click', () => {

        // Get the target from the "data-target" attribute
        const target = el.dataset.target;
        const $target = document.getElementById(target);

        // Toggle the "is-active" class on both the "navbar-burger" and the "navbar-menu"
        el.classList.toggle('is-active');
        $target.classList.toggle('is-active');

    });
    });

    });
</script>

<script id="modal-img">
    document.addEventListener('DOMContentLoaded', () => {
    // Functions to open and close a modal
    function openModal($el) {
      $el.classList.add('is-active');
    }
  
    function closeModal($el) {
      $el.classList.remove('is-active');
    }
  
    function closeAllModals() {
      (document.querySelectorAll('.modal') || []).forEach(($modal) => {
        closeModal($modal);
      });
    }
  
    // Add a click event on buttons to open a specific modal
    (document.querySelectorAll('.js-modal-trigger-img') || []).forEach(($trigger) => {
      const modal = $trigger.dataset.target;
      const $target = document.getElementById(modal);
  
      $trigger.addEventListener('click', () => {
        openModal($target);
      });
    });
  
    // Add a click event on various child elements to close the parent modal
    (document.querySelectorAll('.modal-background, .modal-close, .modal-card-head .delete, .modal-card-foot .button') || []).forEach(($close) => {
      const $target = $close.closest('.modal');
  
      $close.addEventListener('click', () => {
        closeModal($target);
      });
    });
  
    // Add a keyboard event to close all modals
    document.addEventListener('keydown', (event) => {
      if(event.key === "Escape") {
        closeAllModals();
      }
    });
  });
</script>

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

<script src="./js/ajax.js"></script>

<script id="previsualizar_img">
    document.addEventListener('DOMContentLoaded', function() {
    var fileInputElement = document.getElementById('fileInput');
    if (fileInputElement) {
          fileInputElement.addEventListener('change', function(event) {
              const file = event.target.files[0];
              if (file) {
                  document.getElementById('fileName').textContent = file.name;

                  const reader = new FileReader();
                  reader.onload = function(e) {
                      const imagePreview = document.getElementById('imagePreview');
                      if (imagePreview) {
                          imagePreview.src = e.target.result;
                          const imagePreviewContainer = document.getElementById('imagePreviewContainer');
                          if (imagePreviewContainer) {
                              imagePreviewContainer.style.display = 'block';
                          }
                      }
                  };
                  reader.readAsDataURL(file);
              }
          });
      }
  });

</script>
