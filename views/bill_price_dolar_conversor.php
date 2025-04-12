<section class="hero is-small">
  <div class="hero-body pt-2">
    <div class="columns is-centered">
      <div class="column">
        <div class="block mb-2">
          <h1 class="title has-text-centered is-1" >Precio Dolar Hoy</h1>
        </div>
        <div class="block">
          <h2 class="subtitle has-text-centered is-4 "><?= $_SESSION['dolar_fecha'] ?></h2>
        </div>
        <div class="columns is-justify-content-center is-align-items-center is-centered">
          <div class="column is-flex is-flex-direction-column is-align-items-center is-justify-content-center has-text-centered" >
            <figure class="image is-128x128 is-centered">
              <img src="img/dolar_bcv.png" alt="Imagen 1">
            </figure>
              <p class="title is-5 mb-2">Banco Central de Venezuela</p>
              <div class="box title is-4 has-background-text-90"><?=$_SESSION['dolar_valor_bcv']?>bs</div>
          </div>
          <div class="column is-flex is-flex-direction-column is-align-items-center has-text-centered" >
            <figure class="image is-128x128">
              <img src="img/dolar_paralelo.jpg" alt="Imagen 2">
            </figure>
              <p class="title is-5 mb-2">Monitor | Paralelo</p>
              <div class="box title is-4 has-background-text-90"><?=$_SESSION['dolar_valor_paralelo']?>bs</div>
          </div>
          <div class="column is-flex is-flex-direction-column is-align-items-center has-text-centered" >
            <figure class="image is-128x128">
              <img src="img/euro.jpg" alt="Imagen 3">
            </figure>
              <p class="title is-5 mb-2">Euro</p>
              <div class="box title is-4 has-background-text-90"><?=$_SESSION['dolar_valor_paralelo']?>bs</div>
          </div>
        </div>
      </div>

      <div class="column is-two-fifths">
    
          <div class="block mb-2">
              <h1 class="title has-text-centered is-2">Conversor de Moneda</h1>
          </div>
        <form id="convertForm">
            <div class="field is-flex is-justify-content-center is-align-items-center">
                <label class="subtitle mb-0 mr-2 is-5 has-text-weight-bold">Tasa de Cambio</label>
                <div class="control">
                    <div class="select">
                        <select id="rate_type">
                            <option value="bcv">BCV</option>
                            <option value="monitor">Monitor</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="field">
                <label class="label">Cantidad en USD</label>
                <div class="control">
                    <input class="input" type="number" id="amount_usd" placeholder="Ingrese la cantidad en dólares" autocomplete="off">
                </div>
            </div>
            <div id="result_usd_to_bolivares" class="box title is-5 has-background-text-90">
              <p>USD a Bolívares: <span id="resultUsdToBolivares"></span> Bolívares</p>
            </div>
            <div class="field">
                <label class="label">Cantidad en Bolívares</label>
                <div class="control">
                    <input class="input" type="number" id="amount_bolivares" placeholder="Ingrese la cantidad en bolívares" autocomplete="off">
                </div>
            </div>
            <div id="result_bolivares_to_usd" class="box mb-2 title is-5 has-background-text-90">
              <p>Bolívares a USD: <span id="resultBolivaresToUsd"></span> USD</p>
            </div>
            
        </form>      
      </div>
    </div>
  </div>
</section>

<script>
    // Definir las tasas de cambio (estos valores normalmente vienen de la sesión PHP)
    const bcvRate = <?php echo $_SESSION['dolar_valor_bcv']; ?>;
    const monitorRate = <?php echo $_SESSION['dolar_valor_paralelo']; ?>;

    document.getElementById('amount_usd').addEventListener('input', function () {
        convertCurrency();
    });

    document.getElementById('amount_bolivares').addEventListener('input', function () {
        convertCurrency();
    });

    document.getElementById('rate_type').addEventListener('change', function () {
        convertCurrency();
    });

    function convertCurrency() {
        const amountUsd = parseFloat(document.getElementById('amount_usd').value) || 0;
        const amountBolivares = parseFloat(document.getElementById('amount_bolivares').value) || 0;
        const rateType = document.getElementById('rate_type').value;
        let rate = 0;

        if (rateType === 'bcv') {
            rate = bcvRate;
        } else if (rateType === 'monitor') {
            rate = monitorRate;
        }

        const usdToBolivares = amountUsd * rate;
        const bolivaresToUsd = amountBolivares / rate;

        document.getElementById('resultUsdToBolivares').textContent = usdToBolivares.toLocaleString('es-VE', { minimumFractionDigits: 2 });
        document.getElementById('resultBolivaresToUsd').textContent = bolivaresToUsd.toLocaleString('es-VE', { minimumFractionDigits: 2 });
    }

    // Realizar la conversión inicial
    convertCurrency();
</script>

