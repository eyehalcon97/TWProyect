<?php

    error_reporting(E_ALL);
    ini_set('display_errors', '1');

    require_once './vendor/autoload.php';
    require_once './php/funciones.php';
    
    $loader = new \Twig\Loader\FilesystemLoader('.');
    $twig = new \Twig\Environment($loader);

    $Usuario ="eyehalcon97";
    $id = getidusuario($Usuario);
    $tipo = getipousuario($id);

    $argumentosTwig = [ 'tipo' => $tipo];
    if($tipo != "Administrador"){
        $template = $twig->load('/html/Error.html');
    }
    else{
    $template = $twig->load('/html/VLog.html');
    }

    echo $template->render($argumentosTwig);
    

?>