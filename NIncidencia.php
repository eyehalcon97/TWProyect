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

    
    if( isset($_POST['btnCrear'])){

         
        CrearIncidencia($_POST['Titulo'],$_POST['Descripcion'],$_POST['Lugar'],$Usuario,"Pendiente",0,0,null,$_POST['Palabras']);
        
        

        
    }
    $argumentosTwig = [ 'tipo' => $tipo];


    if($tipo != "Administrador" && $tipo != "Colaborador"){
        $template = $twig->load('/html/Error.html');
    }else{
    $template = $twig->load('/html/NIncidencia.html');
    }
    echo $template->render($argumentosTwig);
    

?>