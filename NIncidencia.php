<?php

    error_reporting(E_ALL);
    ini_set('display_errors', '1');

    require_once './vendor/autoload.php';
    require_once './php/funciones.php';


    if( isset($_POST['btnCrear'])){

         
        CrearIncidencia($_POST['Titulo'],$_POST['Descripcion'],$_POST['Lugar'],"eyehalcon97","Pendiente",0,0,null,$_POST['Palabras']);
        
        

        
    }

    $loader = new \Twig\Loader\FilesystemLoader('.');
    $twig = new \Twig\Environment($loader);

    $template = $twig->load('/html/NIncidencia.html');

    echo $template->render();
    

?>