<?php

    error_reporting(E_ALL);
    ini_set('display_errors', '1');

    require_once './vendor/autoload.php';
    require_once './php/funciones.php';

    $usu = ObtenerTodosUsuarios();

    $loader = new \Twig\Loader\FilesystemLoader('.');
    $twig = new \Twig\Environment($loader);

    

    if( isset($_POST['Editar'])){
        $id = $_POST['id'];
    }

    if( isset($_POST['Eliminar'])){
        $id = $_POST['id'];
        
        EliminarUsuarioporid($id);
        
    }
    
    $argumentosTwig = ['usuarios' => $usu ];

    $template = $twig->load('/html/GUsuario.html');

    echo $template->render($argumentosTwig);
    

?>