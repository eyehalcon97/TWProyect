<?php

    error_reporting(E_ALL);
    ini_set('display_errors', '1');

    require_once './vendor/autoload.php';
    require_once './php/funciones.php';

    $idUsuario = "eyehalcon";
    $usuario = BuscarUsuario($idUsuario);
    

    $loader = new \Twig\Loader\FilesystemLoader('.');
    $twig = new \Twig\Environment($loader);
    if( isset($_POST['btnCrear'])){
        
        $Nombre = $_POST['Nombre'];
        $Papellido = $_POST['Papellido'];
        $Sapellido = $_POST['Sapellido'];
        $Psw = $_POST['Psw'];
        $Psw = $_POST['CPsw'];
        $email = $_POST['Email'];
        $Usuario = $_POST['User'];
        $Ciudad = $_POST['Ciudad'];
        $Pais = $_POST['Pais'];
        $Tipo = "Administrador";
        $Estado = "SinVerificar";
        $Foto = $_POST['Foto'];


       ModificarUsuario($id,$Nombre,$Papellido,$Sapellido,$Psw,$email,$Usuario,$Ciudad,$Pais,$Tipo,$Estado,$Foto);
       
       

       
   }

    $argumentosTwig = ['user' => $usuario ];

    $template = $twig->load('/html/MUsuario.html');

    echo $template->render($argumentosTwig);
    

?>