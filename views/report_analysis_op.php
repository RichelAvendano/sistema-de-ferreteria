<style>

  /* Transición suave para la imagen */
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
          <img src="img/reportes_analisis.jpg"/>         
      </figure>
      <div class="box title is-5 p-2 has-background-warning-95" style="text-align:center">Reportes y Analisis</div>  
    </div>
  </div>

  <div class="columns is-mobile is-multiline is-centered">
    <?php 
      require_once "php/main.php";

      $check_product_stock = conexion();
      $check_product_stock = $check_product_stock->query("SELECT producto_stock FROM producto WHERE producto_stock = 0");
      $amount_alert = $check_product_stock->rowCount();

      if($check_product_stock->rowCount()>0){
          $alert = '<i class="fa-solid fa-circle-exclamation has-text-danger"></i>';
      }else{
          $alert = '<i class="fa-solid fa-check has-text-success"></i>';
      }
    ?>
    <div class="column is-narrow is-one-quarter p-5 is-flex is-flex-direction-column is-align-items-center is-justify-content-center has-text-centered" style="min-width:180px">
      <a href="index.php?view=stock_current" class="hover-effect p-2 has-background-white">
        <figure class="image is-128x128 ml-2">
          <img src="img/stock_current.png"/>         
        </figure>
        <div class="box title is-5 p-2 has-background-link-95" style="text-align:center;max-width:150px"><?=$alert?> Inventario Actual</div>
      </a>  
    </div>
    <div class="column is-narrow is-one-quarter p-5 is-flex is-flex-direction-column is-align-items-center is-justify-content-center has-text-centered" style="min-width:180px">
      <a href="index.php?view=sales_history" class="hover-effect p-2 has-background-white">
        <figure class="image is-128x128">
          <img src="img/sales_history.jpg"/>         
        </figure>
        <div class="box title is-5 p-2 has-background-link-95" style="text-align:center;max-width:150px">Historial de Facturas</div>
      </a>  
    </div>
    <div class="column is-narrow is-one-quarter p-5 is-flex is-flex-direction-column is-align-items-center is-justify-content-center has-text-centered" style="min-width:180px">
      <a href="index.php?view=product_analysis" class="hover-effect p-2 has-background-white">
        <figure class="image is-128x128">
          <img src="img/product_analysis.jpg"/>         
        </figure>
        <div class="box title is-5 p-2 has-background-link-95" style="text-align:center;max-width:150px">Analisis de Productos</div>
      </a>  
    </div>
  </div>
</section>
</div>