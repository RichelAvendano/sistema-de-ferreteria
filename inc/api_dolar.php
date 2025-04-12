<?php
    // URL de las APIs
    $api_url_oficial = "https://pydolarve.org/api/v1/dollar?page=bcv";
    $api_url_paralelo = "https://pydolarve.org/api/v1/dollar?page=enparalelovzla";

    // Definir la carpeta de caché y el tiempo de caché en segundos
    $cache_dir = 'cache/';
    $cache_time = 3600; // 30 minutos en segundos

    // Función para obtener datos de la API y manejar el caché
    function obtener_valor_dolar($url, $cache_file) {
        global $cache_time, $cache_dir;

        // Crear el directorio de caché si no existe
        if (!is_dir($cache_dir)) {
            mkdir($cache_dir, 0777, true);
        }

        // Verificar si existe un archivo de caché válido y no ha expirado
        if (file_exists($cache_file) && (time() - filemtime($cache_file)) < $cache_time) {
            // Usar el valor del caché
            $data = json_decode(file_get_contents($cache_file), true);
            $is_cache_valid = true;
        } else {
            // Obtener datos de la API
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);

            // Verificar si hubo errores en la solicitud
            if (curl_errno($ch)) {
                curl_close($ch);
                return null;
            }

            curl_close($ch);

            // Decodificar la respuesta JSON
            $data = json_decode($response, true);

            // Verificar si el JSON es válido
            if (json_last_error() !== JSON_ERROR_NONE) {
                return null;
            }

            // Guardar los datos en el archivo de caché
            file_put_contents($cache_file, json_encode($data));
            $is_cache_valid = false;
        }

        return [$data, $is_cache_valid];
    }

    // Obtener valores del dólar oficial y paralelo
    list($data_oficial, $cache_valido_oficial) = obtener_valor_dolar($api_url_oficial, $cache_dir . 'cache_dolar_oficial.json');
    list($data_paralelo, $cache_valido_paralelo) = obtener_valor_dolar($api_url_paralelo, $cache_dir . 'cache_dolar_paralelo.json');

    // Solo definir variables de sesión si el archivo de caché ha expirado
    if (!$cache_valido_oficial) {
        if ($data_oficial) {
            $_SESSION['dolar_valor_bcv'] = $data_oficial['monitors']['usd']['price']; // Cambia esto según la estructura real
            $_SESSION['euro_valor'] = $data_oficial['monitors']['eur']['price'];
            $_SESSION['dolar_fecha'] = $data_oficial['datetime']['date'];
        }
    }

    if (!$cache_valido_paralelo) {
        if ($data_paralelo) {
            $_SESSION['dolar_valor_paralelo'] = $data_paralelo['monitors']['enparalelovzla']['price']; // Cambia esto según la estructura real
        }
    }

?>

