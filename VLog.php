<?php

    error_reporting(E_ALL);
    ini_set('display_errors', '1');

    require_once './vendor/autoload.php';
    require_once './php/funciones.php';
    
    $loader = new \Twig\Loader\FilesystemLoader('.');
    $twig = new \Twig\Environment($loader);
    session_start();
    $argumentosTwig = ['tipo' => null , 'user' => null , 'Log' => null ];
    $Log= obtenerLog();
    $argumentosTwig['Logs']=$Log;

    if(isset($_SESSION["Nombre"])){

        $Usuario =$_SESSION["Nombre"];
        $id = getidusuario($Usuario);
        $tipo = getipousuario($id);
        $argumentosTwig['tipo']=$tipo;
        $user = BuscarUsuario($Usuario);
        $argumentosTwig['user']=$user;
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
            header("Location: ./VLog.php");
        }

    }
    if( isset($_POST['Crear'])){
        header("Location: ./CUsuario.php");
    }
    if( isset($_POST['Salir'])){
        CrearLog($_SESSION["Nombre"],"Salir");
        if(session_status()==PHP_SESSION_NONE){
            session_start();
        } 

        session_unset(); 
        //$param= session_get_cookie_params(); 
        //setcookie(session_name(), $_COOKIE[session_name()], time()-2592000, $param['path'], $param['domain'], $param['secure'], $param['httponly']);
        session_destroy();
        header("Location: ./index.php");
    }

    if( isset($_POST['MUsuario'])){
        header("Location: ./MUsuario.php");
    }
    $Votos = ObtenerTopVotos();
    $argumentosTwig['Votos']=$Votos;
    $comentarios = ObtenerTopComentarios();
    $argumentosTwig['Comentarios']=$comentarios;
    $Reportes = ObtenerTopReportes();
    $argumentosTwig['Reportes']=$Reportes;

    if($argumentosTwig['tipo'] != "Administrador"){
        $template = $twig->load('/html/Error.html');
    }
    else{
    $template = $twig->load('/html/VLog.html');
    }

    echo $template->render($argumentosTwig);
    

?>