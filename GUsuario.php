<?php

    error_reporting(E_ALL);
    ini_set('display_errors', '1');

    require_once './vendor/autoload.php';
    require_once './php/funciones.php';

    $usu = ObtenerTodosUsuarios();
    session_start();
    $loader = new \Twig\Loader\FilesystemLoader('.');
    $twig = new \Twig\Environment($loader);
    $argumentosTwig = ['usuarios' => $usu ,'tipo' => null ];

    if(isset($_SESSION["Nombre"])){
        
        $Usuario =$_SESSION["Nombre"];
        $id = getidusuario($Usuario);
        $tipo = getipousuario($id);
        $argumentosTwig['tipo']=$tipo;
    }

    if( isset($_POST['Entrar'])){
        $User = $_POST['user'];
        $Psw = $_POST['Psw'];
        $inicio = IniciarSesion($User,$Psw);
        if($inicio == true){
            echo "entro";
            
            $_SESSION["Nombre"] = $User;
            $Usuario =$_SESSION["Nombre"];
            echo $Usuario;
            $id = getidusuario($Usuario);
            $tipo = getipousuario($id);
            $argumentosTwig['tipo']=$tipo;
            header("Location: ./GUsuario.php");
        }

    }
    if( isset($_POST['Salir'])){
        if(session_status()==PHP_SESSION_NONE){
            session_start();
        } 

        session_unset(); 
        //$param= session_get_cookie_params(); 
        //setcookie(session_name(), $_COOKIE[session_name()], time()-2592000, $param['path'], $param['domain'], $param['secure'], $param['httponly']);
        session_destroy();
        header("Location: ./index.php");
    }
    

    if( isset($_POST['Editar'])){
        $id = $_POST['id'];
    }

    if( isset($_POST['Eliminar'])){
        $id = $_POST['id'];
        
        EliminarUsuarioporid($id);
        
    }
    
    
    if($argumentosTwig['tipo'] != "Administrador"){
        $template = $twig->load('/html/Error.html');
    }else{
    $template = $twig->load('/html/GUsuario.html');
    }
    echo $template->render($argumentosTwig);
    

?>