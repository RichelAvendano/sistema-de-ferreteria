<!-- 
<style>
    .invoice-box {
        border: 1px solid #eee;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
        font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
    }
    
    .div-contenedor, .title, .subtitle , .box,  i , td , th{
        color: #1c40c9 !important; /* Cambia este color al que desees */
    }

    .has-border{
        border: 2px solid #1c40c9;
        border-radius: 10px; /* Bordes redondeados */
    }

    table {
        border: 1px solid #1c40c9; /* Borde exterior de la tabla (color azul de Bulma) */
    }

    th, td {
        border: 1px solid #1c40c9 !important; /* Borde de las celdas (color rojo de Bulma) */
    }   

</style>
<section class="is-flex is-justify-content-center div-contenedor">
    <div class="container invoice-box m-0 mt-6 p-5" style="max-width:800px">
        <div class="columns pb-0">
            <div class="column is-two-thirds pb-0">
                <h1 class="title is-2"><i class="fa-solid fa-screwdriver-wrench"></i> FerreCopArt <i class="fa-solid fa-screwdriver-wrench"></i></h1>
                <h2 class="subtitle is-5 mb-0"> Tu Aliado en Construccion y Reparación</h2>
                <div class="box has-background-white has-border p-2 mr-5 mt-3 has-text-centered">
                    Av. Colombia al frente del C.C El Golfito, Barinas Barinas<br>
                    Zona Postal 5201 - Cel. (0426) 413.64.47 / (0273) 532.49.61
                </div>
            </div>
            <div class="column pb-0">
                <div class="is-flex is-justify-content-center">
                    <div class="container invoice-box p-1 has-text-centered has-background-link-100 is-inline" style="max-width:180px">RIF. No. J-50463346</div>
                </div>
                <div class="is-flex is-justify-content-center mt-4">
                    <div class="subtitle is-5">FACTURA <div class="is-inline" style="color:red">Nº 00000001</div></div>
                </div>
            </div>
        </div>
        <div class="columns mt-3">
            <div class="column is-half is-full pt-0 pl-0 is-flex is-flex-wrap-wrap is-align-items-center">
                <div class=" has-text-centered has-text-weight-bold is-inline" style="width:100px">Fecha de Emision</div>
                <div class="table-container" style="width:200px">
                    <table class="table is-bordered" >
                        <thead >
                            <tr class="has-text-centered" style="background-color:#1c40c9">
                                <th class="has-text-centered pt-0 pb-0 has-text-white" style="letter-spacing: 2px;">Dia</th>
                                <th class="has-text-centered pt-0 pb-0 has-text-white" style="letter-spacing: 2px;">Mes</th>
                                <th class="has-text-centered pt-0 pb-0 has-text-white" style="letter-spacing: 2px;">Año</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="has-text-centered pt-1 pb-1">00</td>
                                <td class="has-text-centered pt-1 pb-1">00</td>
                                <td class="has-text-centered pt-1 pb-1">2000</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="column">
                <div class="subtitle is-5">Nº DE CONTROL 00 -<div class="is-inline" style="color:red"> 00000001</div></div>
            </div>
        </div>

        <hr class="divider m-3">

        <div class="table-container mb-0" style="border: 2px solid #1c40c9;padding:2px">
            <table class="table is-fullwidth is-bordered mi-tabla p-3 tabla-1" style="border: 2px solid #1c40c9">
                <tbody>
                    <tr>
                        <td colspan="2" class="has-text-weight-bold" style="font-size:12px;height:41px">Nombre y Apellido o Razón Social del Comprador: <span style="font-size:18px"></span></td>
                    </tr>
                    <tr>
                        <td colspan="2" style="height:41px;"><span style="font-size:18px"></span></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="has-text-weight-bold" style="font-size:12px;height:41px">Domicilio Fiscal: </td>
                    </tr>
                    <tr>
                        <td class="has-text-weight-bold" style="font-size:12px;height:41px;width:40%"></td>
                        <td class="has-text-weight-bold" style="font-size:12px;height:41px;width:60%">N° de Teléfono u Otro Dato</td>
                    </tr>
                    <tr>
                    <td colspan="2" class="has-text-weight-bold" style="font-size:12px;height:41px">N° de RIF o CED N°: o Pasaporte <span style="font-size:18px"></span></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <hr class="divider m-3">

        <div class="table-container">
            <table class="table is-fullwidth is-bordered mi-tabla">
                <thead>
                    <tr>
                        <th>Descripción</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Cautaro de Lucia Antivax</td>
                        <td>2</td>
                        <td>25,000.00</td>
                        <td>50,000.00</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" class="has-text-right">Total:</th>
                        <th>50,000.00</th>
                    </tr>
                    <tr>
                        <th colspan="3" class="has-text-right">Estado:</th>
                        <th>PAGADO</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</section>
 -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Primer PDF con DOMPDF</title>
    <style>
        /* Estilos generales */
        .invoice-box {
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
            max-width: 1000px;
            margin: 24px auto;
            padding: 20px;
        }

        .div-contenedor {
            display: flex;
            justify-content: center;
        }

        .title {
            font-size: 2rem;
            color: #1c40c9;
            text-align: center;
        }

        .subtitle {
            font-size: 1.25rem;
            color: #1c40c9;
            margin-bottom: 0;
        }

        .box {
            background-color: white;
            border: 2px solid #1c40c9;
            border-radius: 10px;
            padding: 8px;
            margin-right: 20px;
            margin-top: 12px;
            text-align: center;
        }

        .has-background-white {
            background-color: white;
        }

        .has-background-link-100 {
            background-color: #e0e0e0;
        }

        .has-text-centered {
            text-align: center;
        }

        .has-text-weight-bold {
            font-weight: bold;
        }

        .has-text-white {
            color: white;
        }

        .has-text-danger {
            color: red;
        }

        .has-border {
            border: 2px solid #1c40c9;
            border-radius: 10px;
        }

        .is-flex {
            display: flex;
        }

        .is-justify-content-center {
            justify-content: center;
        }

        .is-align-items-center {
            align-items: center;
        }

        .is-fullwidth {
            width: 100%;
        }

        .is-inline {
            display: inline;
        }

        /* Estilos de la tabla */
        table {
            border: 1px solid #1c40c9;
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #1c40c9;
            padding: 8px;
            color: #1c40c9;
        }

        th {
            color: #1c40c9;
        }

        .mi-tabla th,
        .mi-tabla td {
            border: 1px solid #1c40c9;
        }


        /* Estilos específicos */
        .columns {
            display: flex;
            gap: 10px;
        }

        .column {
            flex: 1;
        }

        .is-two-thirds {
            flex: 2;
        }

        .is-half {
            flex: 1;
        }

        .pt-0 {
            padding-top: 0;
        }

        .pb-0 {
            padding-bottom: 0;
        }

        .pl-0 {
            padding-left: 0;
        }

        .pr-0 {
            padding-right: 0;
        }

        .mt-3 {
            margin-top: 12px;
        }

        .mt-4 {
            margin-top: 16px;
        }

        .mt-6 {
            margin-top: 24px;
        }

        .mb-0 {
            margin-bottom: 0;
        }

        .p-1 {
            padding: 4px;
        }

        .p-2 {
            padding: 8px;
        }

        .p-5 {
            padding: 20px;
        }

        .mr-5 {
            margin-right: 20px;
        }

        .has-text-link {
            color: #1c40c9;
        }

        .has-text-danger {
            color: red;
        }

        .has-text-weight-bold {
            font-weight: bold;
        }

        .is-bordered {
            border: 1px solid #1c40c9;
        }

        .is-fullwidth {
            width: 100%;
        }

        .is-inline {
            display: inline;
        }

        .has-background-link-100 {
            background-color: #e0e0e0;
        }

        .has-text-weight-bold {
            font-weight: bold;
        }

        .is-flex {
            display: flex;
        }

        .is-justify-content-center {
            justify-content: center;
        }

        .is-align-items-center {
            align-items: center;
        }

        .is-fullwidth {
            width: 100%;
        }

        .is-inline {
            display: inline;
        }

        .has-border {
            border: 2px solid #1c40c9;
            border-radius: 10px;
        }

        .has-background-white {
            background-color: white;
        }

        .has-text-white {
            color: white;
        }

        .has-text-link {
            color: #1c40c9;
        }

        .has-text-danger {
            color: red;
        }

    </style>
</head>
<body>
    <section class="">
        <div class="invoice-box">
            <div class="columns">
                <div class="column is-two-thirds pb-0">
                    <h1 class="title" style="margin-top:0px;margin-bottom:10px"> FerreCopArt </h1>
                    <h2 class="subtitle mb-0 has-text-centered">Tu Aliado en Construcción y Reparación</h2>
                    <div class="box has-background-white has-border p-2 mr-5 mt-3 has-text-centered" style="color:#1c40c9">
                        Av. Colombia al frente del C.C El Golfito, Barinas Barinas<br>
                        Zona Postal 5201 - Cel. (0426) 413.64.47 / (0273) 532.49.61
                    </div>
                </div>
                <div class="column pb-0">
                    <div class="is-flex is-justify-content-center">
                        <div class="has-background-link-100 p-1 has-text-centered is-inline has-text-weight-bold" style="max-width:180px;background-color:#dadef5;color:#1c40c9">RIF. No. J-50463346</div>
                    </div>
                    <div class="is-flex is-justify-content-center mt-4">
                        <div class="subtitle">FACTURA <span class="has-text-danger">Nº 00000001</span></div>
                    </div>
                </div>
            </div>
            <div class="columns mt-3">
                <div class="column is-half pt-0 pl-0 is-flex is-align-items-center">
                    <div class="has-text-centered has-text-weight-bold is-inline" style="width:100px;color:#1c40c9">Fecha de Emisión</div>
                    <div class="table-container" style="width:200px">
                        <table class="is-bordered">
                            <thead>
                                <tr class="has-text-centered" style="background-color:#1c40c9">
                                    <th class="has-text-white pt-0 pb-0" style="letter-spacing: 2px">Día</th>
                                    <th class="has-text-white pt-0 pb-0" style="letter-spacing: 2px">Mes</th>
                                    <th class="has-text-white pt-0 pb-0" style="letter-spacing: 2px">Año</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="pt-1 pb-1">00</td>
                                    <td class="pt-1 pb-1">00</td>
                                    <td class="pt-1 pb-1">2000</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="column" style="display:flex; align-items:flex-end">
                    <div class="subtitle">Nº DE CONTROL 00 - <span class="has-text-danger">00000001</span></div>
                </div>
            </div>

            <div class="table-container mb-0" style="border: 2px solid #1c40c9;padding:2px;margin-top:20px">
                <table class="is-fullwidth is-bordered mi-tabla p-3 tabla-1">
                    <tbody>
                        <tr>
                            <td colspan="2" class="has-text-weight-bold" style="font-size:15px;height:41px;">Nombre y Apellido o Razón Social del Comprador: </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="height:41px;font-size:15px;"></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="has-text-weight-bold" style="font-size:15px;height:41px">Domicilio Fiscal: </td>
                        </tr>
                        <tr>
                            <td class="has-text-weight-bold" style="font-size:15px;height:41px;width:40%"></td>
                            <td class="has-text-weight-bold" style="font-size:15px;height:41px;width:60%">N° de Teléfono u Otro Dato</td>
                        </tr>
                        <tr>
                            <td colspan="2" class="has-text-weight-bold" style="font-size:15px;height:41px">N° de RIF o CED N°: o Pasaporte: </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="table-container mb-0" style="margin-top:20px">
                <table class="is-fullwidth is-bordered mi-tabla p-3 tabla-1">
                    <thead style="height:41px">
                        <tr style="height:41px">
                            <th style="height:41px">Cantidad</th>
                            <th style="height:41px">Descripción/Gravado o Exento</th>
                            <th style="height:41px">Precio Unitario</th>
                            <th style="height:41px">Monto del Bien o Servicio</th>
                        </tr>
                    </thead>
                    <tbody style="height:41px">
                        <tr>
                            <td class="has-text-weight-bold" style="font-size:15px;height:41px;"></td>
                            <td class="has-text-weight-bold" style="font-size:15px;height:41px;"></td>
                            <td class="has-text-weight-bold" style="font-size:15px;height:41px;"></td>
                            <td class="has-text-weight-bold" style="font-size:15px;height:41px;"></td>
                        </tr>
                        <tr>
                            <td class="has-text-weight-bold" style="font-size:15px;height:41px;"></td>
                            <td class="has-text-weight-bold" style="font-size:15px;height:41px;"></td>
                            <td class="has-text-weight-bold" style="font-size:15px;height:41px;"></td>
                            <td class="has-text-weight-bold" style="font-size:15px;height:41px;"></td>
                        </tr> 
                        <tr>
                            <td class="has-text-weight-bold" style="font-size:15px;height:41px;"></td>
                            <td class="has-text-weight-bold" style="font-size:15px;height:41px;"></td>
                            <td class="has-text-weight-bold" style="font-size:15px;height:41px;"></td>
                            <td class="has-text-weight-bold" style="font-size:15px;height:41px;"></td>
                        </tr> 
                        <tr>
                            <td class="has-text-weight-bold" style="font-size:15px;height:41px;"></td>
                            <td class="has-text-weight-bold" style="font-size:15px;height:41px;"></td>
                            <td class="has-text-weight-bold" style="font-size:15px;height:41px;"></td>
                            <td class="has-text-weight-bold" style="font-size:15px;height:41px;"></td>
                        </tr> 
                                               
                    </tbody>
                    <tfoot>
                        <tr >
                            <th style="border-bottom:1px solid white;border-right:1px solid white"></th>
                            <th style="border-bottom:1px solid white; text-align:right;font-size:13px" colspan="2" >ADICIONES, DESCUENTOS, BONIFICACIONES AL PRECIO</th>
                            <th></th>                          
                        </tr>
                        <tr >
                        <th style="border-bottom:1px solid white;border-right:1px solid white"></th>
                            <th style="border-bottom:1px solid white; text-align:right;font-size:13px" colspan="2" >MONTO TOTAL EXENTO O EXONERADO</th>
                            <th></th>                          
                        </tr>
                        <tr >
                            <th style="border-bottom:1px solid white;border-right:1px solid white; color:red">ORIGINAL</th>
                            <th style="border-bottom:1px solid white; text-align:right;font-size:13px" colspan="2" >BASE IMPONIBLE SEGÚN ALICUTA <span style="border-bottom:1px solid blue;width:70px;display:inline-block; text-align:center; padding-bottom:3px;font-size:18px"></span><span style="font-size:18px">%</span></th>
                            <th></th>                          
                        </tr>
                        <tr >
                        <th style="border-bottom:1px solid white;border-right:1px solid white"></th>
                            <th style="border-bottom:1px solid white; text-align:right;font-size:13px" colspan="2" >MONTO TOTAL DEL IMPUESTO SEGÚN ALICUOTA <span style="border-bottom:1px solid blue;width:70px;display:inline-block; text-align:center; padding-bottom:3px;font-size:18px"></span><span style="font-size:18px">%</span></th>
                            <th></th>                          
                        </tr>
                        <tr >
                        <th style="border-right:1px solid white"></th>
                            <th style=" text-align:right;font-size:13px" colspan="2" >MONTO TOTAL DE VENTA</th>
                            <th></th>                          
                        </tr>                      
                    </tfoot>
                </table>
            </div>
            <div class="table-container mb-0" style="border: 2px solid #1c40c9;padding:2px;margin-top:20px">
                <table class="is-fullwidth is-bordered mi-tabla p-3 tabla-1">
                    <tbody>
                        <tr>
                            <td colspan="2" class="has-text-weight-bold" style="font-size:15px;height:41px;">Nombre y Apellido o Razón Social del Comprador: </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="height:41px;font-size:15px;"></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="has-text-weight-bold" style="font-size:15px;height:41px">Domicilio Fiscal: </td>
                        </tr>
                        <tr>
                            <td class="has-text-weight-bold" style="font-size:15px;height:41px;width:40%"></td>
                            <td class="has-text-weight-bold" style="font-size:15px;height:41px;width:60%">N° de Teléfono u Otro Dato</td>
                        </tr>
                        <tr>
                            <td colspan="2" class="has-text-weight-bold" style="font-size:15px;height:41px">N° de RIF o CED N°: o Pasaporte: </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</body>
</html>