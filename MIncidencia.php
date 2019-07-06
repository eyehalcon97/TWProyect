<?php

    error_reporting(E_ALL);
    ini_set('display_errors', '1');

    require_once './vendor/autoload.php';
    require_once './php/funciones.php';

    $idUsuario = "eyehalcon";
    $incidencias = getincidenciaUsuario($idUsuario);
    $numeroincidencias = obtenernumeroIncidenciasUsuario($idUsuario);

    $loader = new \Twig\Loader\FilesystemLoader('.');
    $twig = new \Twig\Environment($loader);

    $argumentosTwig = ['incidencias' => $incidencias ,'nincidencia' => $numeroincidencias ];

    $template = $twig->load('/html/MIncidencia.html');

    echo $template->render($argumentosTwig);
    

?>