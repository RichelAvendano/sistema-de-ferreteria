<?php 
    require "inc/session_start.php";
    require "inc/api_dolar.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "inc/head.php"?>
    
</head>
<body>
    <?php
        

        if(!isset($_GET['view']) || $_GET['view'] == ""){
            $_GET['view'] = "login";
        }

        if(file_exists("views/".$_GET['view'].".php") && $_GET['view']!="login" && $_GET['view']!="404" && $_GET['view']!="register"){

            if(!isset($_SESSION['id']) || $_SESSION['id'] == "" || !isset($_SESSION['usuario']) || $_SESSION['usuario'] == ""){

                include "views/logout.php";
                exit();
            }
            
            include "inc/navbar.php";

            include "views/".$_GET['view'].".php";

            include "inc/script.php";
        }else{
            if($_GET['view'] == "login"){
                
                include "views/login.php";
            }
            else if($_GET['view'] == 'register'){

                
                include "views/register.php";

                include "inc/script.php";
                
            }
            else{
                
                include "views/404.php";
            }
        }

        
    ?>
    
</body>
</html>
