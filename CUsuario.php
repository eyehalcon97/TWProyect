<?php

    error_reporting(E_ALL);
    ini_set('display_errors', '1');

    require_once './vendor/autoload.php';
    require_once './php/funciones.php';

    session_start();

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
         $Tipo = "Visitante";
         $Estado = "SinVerificar";
         $Foto = $_POST['Foto'];
         $Votos = 0;
         $Reportes = 0;
         $Comentarios = 0;

        CrearUsuario($Nombre,$Papellido,$Sapellido,$Psw,$email,$Usuario,$Ciudad,$Pais,$Tipo,$Estado,$Foto,$Votos,$Reportes,$Comentarios);
        
        

        
    }
    if( isset($_POST['Entrar'])){
        $User = $_POST['user'];
        $Psw = $_POST['Psw'];
        $inicio = IniciarSesion($User,$Psw);
        
        if($inicio == true){
            echo "entro";
            $_SESSION["Nombre"] = $User;
            $Usuario =$_SESSION["Nombre"];
            $id = getidusuario($Usuario);
            $tipo = getipousuario($id);
            $argumentosTwig['tipo']=$tipo;
            $user = BuscarUsuario($Usuario);
            $argumentosTwig['user']=$user;
            CrearLog($User,"Entrar");
            header("Location: ./CUsuario.php");
        }

    }

    $template = $twig->load('/html/CUsuario.html');

    echo $template->render();
    

?>