<?php

    header('Content-Type: text/html; charset=utf-8'); // Asegura que la respuesta se envíe como HTML
    require_once "main.php";

    $usuario = limpiar_cadena($_POST['login_usuario']);
    $clave = limpiar_cadena($_POST['login_password']);

    if(empty($usuario) || empty($clave)){
        echo '<div class="notification is-danger" style="margin-top: 15px;">
                <strong class="is-size-4 animate-bounce">!!!Ocurrio un Error!!!</strong><br>
                No has llenado todos los campos
            </div>';
        exit();
    }

    if(verificar_datos("[a-zA-Z0-9]{4,20}", $usuario)){
        echo '<div class="notification is-danger" style="margin-top: 15px;">
                <strong class="is-size-4 animate-bounce">!!!Ocurrio un Error!!!</strong><br>
                No has Introducido los datos correctamente
            </div>';
        exit();
    }else{
        $check_usuario = conexion();
        $check_usuario = $check_usuario->prepare("SELECT * FROM usuario WHERE usuario_usuario = :usuario");
        $check_usuario->execute(array(':usuario'=>$usuario));
        if($check_usuario->rowCount() == 1){
            $check_usuario = $check_usuario->fetch();
            if($check_usuario['usuario_usuario'] == $usuario && password_verify($clave, $check_usuario['usuario_clave'])){

                $_SESSION['id'] = $check_usuario['usuario_id'];
                $_SESSION['usuario'] = $check_usuario['usuario_usuario'];
                $_SESSION['dolar_valor_bcv'] = $data_oficial['monitors']['usd']['price']; // Cambia esto según la estructura real
                $_SESSION['euro_valor'] = $data_oficial['monitors']['eur']['price'];
                $_SESSION['dolar_fecha'] = $data_oficial['datetime']['date']; 
                $_SESSION['dolar_valor_paralelo'] = $data_paralelo['monitors']['enparalelovzla']['price']; // Cambia esto según la estructura real

                if(headers_sent()){
                    echo "<script>window.location.href='index.php?view=home';</script>";
                }else{
                    header("Location: index.php?view=home");
                    
                }
            }else{
                echo '<div class="notification is-danger animate-bounce" style="margin-top: 15px;">
                        <strong class="is-size-4">!!!Ocurrio un Error!!!</strong><br>
                        Usuario o Clave Incorrecta
                    </div>';
            }
        }else{
            echo '<div class="notification is-danger animate-bounce" style="margin-top: 15px;">
                    <strong class="is-size-4">!!!Ocurrio un Error!!!</strong><br>
                    Usuario o Clave Incorrecta
                </div>';
        }
    }
    $check_usuario = null;