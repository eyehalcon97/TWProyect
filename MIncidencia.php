<?php

    error_reporting(E_ALL);
    ini_set('display_errors', '1');

    require_once './vendor/autoload.php';
    require_once './php/funciones.php';

    $Usuario ="eyehalcon97";
    $incidencias = getincidenciaUsuario($Usuario);
    $numeroincidencias = obtenernumeroIncidenciasUsuario($Usuario);
    
    $id = getidusuario($Usuario);
    $tipo = getipousuario($id);

    $loader = new \Twig\Loader\FilesystemLoader('.');
    $twig = new \Twig\Environment($loader);

    $argumentosTwig = ['incidencias' => $incidencias ,'nincidencia' => $numeroincidencias , 'tipo' => $tipo ];
    if($tipo != "Administrador"  && $tipo != "Colaborador"){
        $template = $twig->load('/html/Error.html');
    }else{
    $template = $twig->load('/html/MIncidencia.html');
    }
    echo $template->render($argumentosTwig);
    

?>