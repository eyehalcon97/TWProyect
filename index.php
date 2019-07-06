<?php

    error_reporting(E_ALL);
    ini_set('display_errors', '1');

    require_once './vendor/autoload.php';
    require_once './php/funciones.php';

    $incidencias = ObtenerTodasIncidencias();
    $numeroincidencias = obtenernumeroIncidencias();



    $loader = new \Twig\Loader\FilesystemLoader('.');
    $twig = new \Twig\Environment($loader);
    
    $Usuario ="eyehalcon97";
    $id = getidusuario($Usuario);
    $tipo = getipousuario($id);


    if( isset($_POST['Like'])){
        $id = $_POST['id'];
        Like($id);
    }
    if( isset($_POST['Dislike'])){
        $id = $_POST['id'];
        Dislike($id);
    }
    if( isset($_POST['Editar'])){
        $id = $_POST['id'];
    }
    if( isset($_POST['Comentar'])){
        $id = $_POST['id'];
    }
    if( isset($_POST['Eliminar'])){
        $id = $_POST['id'];
        EliminarIncidenciaporid($id);
        
    }
    $argumentosTwig = ['incidencias' => $incidencias ,'nincidencia' => $numeroincidencias , 'tipo' => $tipo];

    $template = $twig->load('/html/index.html');


    echo $template->render($argumentosTwig);
    

?>