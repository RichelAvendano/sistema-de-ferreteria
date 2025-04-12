<style>

  /* Transición suave para la imagen */
  .fade-transition {
      transition: opacity 0.3s ease-in-out;
  }

  /* Clase para ocultar la imagen durante la transición */
  .fade-out {
      opacity: 0;
  }

  .fade-transition {
      transition: opacity 0.3s ease-in-out;
  }

  /* Clase para ocultar la imagen durante la transición */
  .fade-out {
      opacity: 0;
  }
  .hover-effect {
    text-decoration: none; /* Elimina el subrayado predeterminado */
    display: block; /* Asegura que todo el bloque esté cubierto por el enlace */
    transition: transform 0.5s;
  }

  .hover-effect:hover {
    border: 5px solid rgb(219, 221, 247);
    border-radius: 5px; /* Opcional: añade un borde redondeado */
    transform: scale(1.07); 
    transition: border 0.5s, transform 0.5s; /* Suaviza la transición */   
  }
</style>
<div class = "background-image" style="height: 100%;min-height: 100vh;">
<div class="box title is-2 p-2 mb-2 has-background-link-95" style="text-align:center">Ferre COPART</div>

<section class="section pt-0 mt-5 ml-6 mr-6">
  
  <div class="columns is-mobile is-multiline is-centered mb-3"><div class="column is-narrow title is-5 has-background-link-95 has-text-centered">Tu Aliado en Construcción y Reparación</div></div>

  <div class="columns is-mobile is-multiline is-centered">
    <div class="column is-narrow is-one-quarter p-5 is-flex is-flex-direction-column is-align-items-center is-justify-content-center has-text-centered" style="min-width:180px;">
      <a href="index.php?view=user_op" class="hover-effect p-2 has-background-white">
        <figure class="image is-128x128 ">
          <img src="img/user.png"/>         
        </figure>
        <div class="box title is-5 p-2 has-background-link-95" style="text-align:center">Usuarios</div>
      </a>
    </div>
    <div class="column is-narrow is-one-quarter p-5 is-flex is-flex-direction-column is-align-items-center is-justify-content-center has-text-centered" style="min-width:180px">
      <a href="index.php?view=client_op" class="hover-effect p-2 has-background-white">
        <figure class="image is-128x128">
          <img src="img/cliente.jpg"/>         
        </figure>
        <div class="box title is-5 p-2 has-background-link-95" style="text-align:center">Clientes</div>
      </a>      
    </div>
    <div class="column is-narrow is-one-quarter p-5 is-flex is-flex-direction-column is-align-items-center is-justify-content-center has-text-centered" style="min-width:180px">
      <a href="index.php?view=supplier_op" class="hover-effect p-2 has-background-white">
        <figure class="image is-128x128 mb-2">
          <img src="img/proveedor.jpg"/>         
        </figure>
        <div class="box title is-5 p-2 has-background-link-95" style="text-align:center">Proveedores</div>
      </a>      
    </div>
    <div class="column is-narrow is-one-quarter p-5 is-flex is-flex-direction-column is-align-items-center is-justify-content-center has-text-centered" style="min-width:180px">
      <a href="index.php?view=bill_op" class="hover-effect p-2 has-background-white">
        <figure class="image is-128x128">
          <img src="img/factura.jpg"/>         
        </figure>
        <div class="box title is-5 p-2 has-background-link-95" style="text-align:center">Facturas</div>
      </a>    
    </div>
    <div class="column is-narrow is-one-quarter p-5 is-flex is-flex-direction-column is-align-items-center is-justify-content-center has-text-centered" style="min-width:180px">
      <a href="index.php?view=product_op" class="hover-effect p-2 has-background-white">
          <figure class="image is-128x128">
              <!-- Imagen inicial -->
              <img id="categoria-imagen" src="img/carrusel_productos/producto-1.jpg" class="fade-transition"/>
          </figure>
          <div class="box title is-5 p-2 has-background-link-95" style="text-align:center;max-width:150px">Productos</div>
      </a>      
    </div>
    <div class="column is-narrow is-one-quarter p-5 is-flex is-flex-direction-column is-align-items-center is-justify-content-center has-text-centered" style="min-width:180px">
      <a href="index.php?view=category_op" class="hover-effect p-2 has-background-white">
        <figure class="image is-128x128 ml-3">
          <img src="img/categoria.jpg"/>         
        </figure>
        <div class="box title is-5 p-2 has-background-link-95" style="text-align:center;max-width:150px">Categorias de Productos</div>
      </a>  
    </div>
    <div class="column is-narrow is-one-quarter p-5 is-flex is-flex-direction-column is-align-items-center is-justify-content-center has-text-centered" style="min-width:180px">
      <a href="index.php?view=report_analysis_op" class="hover-effect p-2 has-background-white">
        <figure class="image is-128x128">
          <img src="img/reportes_analisis.jpg"/>         
        </figure>
        <div class="box title is-5 p-2 has-background-link-95" style="text-align:center;max-width:130px">Reportes y Analisis</div>
      </a>     
    </div>
  </div>
</section>
</div>

<script>
    // Array con las rutas de las imágenes
  const imagenes = [
      "img/carrusel_productos/producto-1.jpg",
      "img/carrusel_productos/producto-2.jpg",
      "img/carrusel_productos/producto-3.jpg",
      "img/carrusel_productos/producto-4.jpg",
      "img/carrusel_productos/producto-5.jpg"
  ];

  // Obtener la referencia a la imagen
  const imagen = document.getElementById("categoria-imagen");

  // Variable para llevar el índice de la imagen actual
  let indiceActual = 0;

  // Función para cambiar la imagen
  function cambiarImagen() {
      // Aplicar la clase para ocultar la imagen con transición
      imagen.classList.add("fade-out");

      // Esperar a que termine la transición antes de cambiar la imagen
      setTimeout(() => {
          // Cambiar la imagen
          indiceActual = (indiceActual + 1) % imagenes.length; // Avanzar al siguiente índice
          imagen.src = imagenes[indiceActual];

          // Quitar la clase para mostrar la nueva imagen con transición
          imagen.classList.remove("fade-out");
      }, 500); // 500ms = duración de la transición
  }

  // Cambiar la imagen cada 1.5 segundos
  setInterval(cambiarImagen, 1500);
</script>

