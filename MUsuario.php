<?php

    error_reporting(E_ALL);
    ini_set('display_errors', '1');

    require_once './vendor/autoload.php';
    require_once './php/funciones.php';
    require_once './php/Usuario.php';

    session_start();
    $loader = new \Twig\Loader\FilesystemLoader('.');
    $twig = new \Twig\Environment($loader);

    
    $argumentosTwig = ['tipo' => null , 'user' => null];

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
            header("Location: ./index.php");
        }

    }
    if( isset($_POST['Crear'])){
        header("Location: ./CUsuario.php");
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

    if( isset($_POST['MUsuario'])){
        header("Location: ./MUsuario.php");
    }
    
    
    if( isset($_POST['Editar'])){
        $idUsuario = $_POST['id'];


        $Usuario = obtenerUsuarioporId($idUsuario);
        
        $argumentosTwig['user']=$Usuario;

        

    }

    if( isset($_POST['btnModificar'])){
        
        $Nombre = $_POST['Nombre'];
        $Papellido = $_POST['Papellido'];
        $Sapellido = $_POST['Sapellido'];
        $Psw = $_POST['Psw'];
        $Psw = $_POST['CPsw'];
        $email = $_POST['Email'];
        $User = $_POST['User'];
        $Ciudad = $_POST['Ciudad'];
        $Pais = $_POST['Pais'];
        $Tipo = $_POST['Tipo'];
        $Estado = $_POST['Estado'];
        $Foto = $_POST['Foto'];


       ModificarUsuario($id,$Nombre,$Papellido,$Sapellido,$Psw,$email,$User,$Ciudad,$Pais,$Tipo,$Estado,$Foto);
       
       

       
   }

    
    if($argumentosTwig['tipo'] != "Administrador" && $argumentosTwig['tipo'] != "Colaborador" ){
        $template = $twig->load('/html/Error.html');
    }else{
    $template = $twig->load('/html/MUsuario.html');

    }

    

    
    echo $template->render($argumentosTwig);
    

?>