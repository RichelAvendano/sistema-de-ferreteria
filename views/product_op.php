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
<div class="box title is-2 p-2 mb-2 has-background-link-95" style="text-align: left; position: relative;">
    <p class="has-text-centered">Ferre COPART</p>

    <div class="field p-3" style="display: flex; justify-content: flex-start; align-items: flex-start; position: absolute; top: 0; left: 0;">
        <a href="#" class="button is-link is-responsive btn-back" name="IrLogin">
            <i class="fas fa-arrow-left" style="margin-right: 7px;"></i>Regresar atrás
        </a>
    </div>
    <?php include "inc/btn_back.php" ?>
</div>

<section class="section pt-0 mt-5 ml-6 mr-6">
  <div class="columns is-mobile is-centered">
    <div class="column is-full is-one-quarter p-2 is-flex is-flex-direction-column is-align-items-center is-justify-content-center has-text-centered has-background-white" style="min-width:180px">     
      <figure class="image is-128x128">
        <img id="categoria-imagen" src="img/carrusel_productos/producto-1.jpg" class="fade-transition"/>        
      </figure>
      <div class="box title is-5 p-2 has-background-warning-95" style="text-align:center">Estas en Productos</div>  
    </div>
  </div>

  <div class="columns is-mobile is-multiline is-centered">
    
    <div class="column is-narrow is-one-quarter p-5 is-flex is-flex-direction-column is-align-items-center is-justify-content-center has-text-centered" style="min-width:180px">
      <a href="index.php?view=product_new" class="hover-effect p-2 has-background-white">
        <figure class="image is-128x128">
          <img src="img/nuevo.png"/>         
        </figure>
        <div class="box title is-5 p-2 has-background-link-95" style="text-align:center;max-width:150px">Nuevo</div>
      </a>  
    </div>
    <div class="column is-narrow is-one-quarter p-5 is-flex is-flex-direction-column is-align-items-center is-justify-content-center has-text-centered" style="min-width:180px">
      <a href="index.php?view=product_list" class="hover-effect p-2 has-background-white">
        <figure class="image is-128x128">
          <img src="img/lista.jpg"/>         
        </figure>
        <div class="box title is-5 p-2 has-background-link-95" style="text-align:center;max-width:150px">Lista</div>
      </a>  
    </div>
    <div class="column is-narrow is-one-quarter p-5 is-flex is-flex-direction-column is-align-items-center is-justify-content-center has-text-centered" style="min-width:180px">
      <a href="index.php?view=product_search" class="hover-effect p-2 has-background-white">
        <figure class="image is-128x128 ml-4">
          <img src="img/buscar_monto.png"/>         
        </figure>
        <div class="box title is-6 p-2 has-background-link-95 " style="text-align:center;max-width:170px">Buscar por Nombre,Precio o Inventario</div>
      </a>  
    </div>
    <div class="column is-narrow is-one-quarter p-5 is-flex is-flex-direction-column is-align-items-center is-justify-content-center has-text-centered" style="min-width:180px">
      <a href="index.php?view=product_stock_price" class="hover-effect p-2 has-background-white">
        <figure class="image is-128x128 ml-4">
          <img src="img/buscar_monto.png"/>         
        </figure>
        <div class="box title is-6 p-2 has-background-link-95 " style="text-align:center;max-width:170px">Buscar Precio o Inventario por Rango de Valores</div>
      </a>  
    </div>
    <div class="column is-narrow is-one-quarter p-5 is-flex is-flex-direction-column is-align-items-center is-justify-content-center has-text-centered" style="min-width:180px">
      <a href="index.php?view=product_category" class="hover-effect p-2 has-background-white">
        <figure class="image is-128x128 ml-2">
          <img src="img/buscar_categoria.png"/>         
        </figure>
        <div class="box title is-5 p-2 has-background-link-95" style="text-align:center;max-width:150px">Buscar por Categoria</div>
      </a>  
    </div>
    <div class="column is-narrow is-one-quarter p-5 is-flex is-flex-direction-column is-align-items-center is-justify-content-center has-text-centered" style="min-width:180px">
      <a href="index.php?view=product_supplier" class="hover-effect p-2 has-background-white">
        <figure class="image is-128x128 ml-2">
          <img src="img/proveedor_buscar.jpg"/>         
        </figure>
        <div class="box title is-5 p-2 has-background-link-95" style="text-align:center;max-width:150px">Buscar por Proveedor</div>
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