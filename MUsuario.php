<?php

    error_reporting(E_ALL);
    ini_set('display_errors', '1');

    require_once './vendor/autoload.php';
    require_once './php/funciones.php';

    var_dump ($usuario);
    $loader = new \Twig\Loader\FilesystemLoader('.');
    $twig = new \Twig\Environment($loader);

    
    $Usuario ="eyehalcon97";
    $id = getidusuario($Usuario);
    $tipo = getipousuario($id);


    if( isset($_POST['btnModificar'])){
        
        $Nombre = $_POST['Nombre'];
        $Papellido = $_POST['Papellido'];
        $Sapellido = $_POST['Sapellido'];
        $Psw = $_POST['Psw'];
        $Psw = $_POST['CPsw'];
        $email = $_POST['Email'];
        $Usuario = $_POST['User'];
        $Ciudad = $_POST['Ciudad'];
        $Pais = $_POST['Pais'];
        $Tipo = $_POST['Tipo'];
        $Estado = $_POST['Estado'];
        $Foto = $_POST['Foto'];


       ModificarUsuario($id,$Nombre,$Papellido,$Sapellido,$Psw,$email,$Usuario,$Ciudad,$Pais,$Tipo,$Estado,$Foto);
       
       

       
   }

    $argumentosTwig = ['user' => $usuario  ,'tipo' => $tipo ];
    if($tipo != "Administrador" && $tipo != "Colaborador" ){
        $template = $twig->load('/html/Error.html');
    }else{
    $template = $twig->load('/html/MUsuario.html');
    }
    echo $template->render($argumentosTwig);
    

?>