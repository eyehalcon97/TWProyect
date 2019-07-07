<?php

    error_reporting(E_ALL);
    ini_set('display_errors', '1');

    require_once './vendor/autoload.php';
    require_once './php/funciones.php';
    session_start();


    


    $argumentosTwig = ['incidencias' => null ,'nincidencia' => null , 'tipo' => null ];

    if(isset($_SESSION["Nombre"])){
        
        $Usuario =$_SESSION["Nombre"];
        $id = getidusuario($Usuario);
        $tipo = getipousuario($id);
        $incidencias = getincidenciaUsuario($Usuario);
        $numeroincidencias = obtenernumeroIncidenciasUsuario($Usuario);
        $argumentosTwig['incidencias']=$incidencias;
        $argumentosTwig['nincidencia']=$numeroincidencias;
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
            header("Location: ./MIncidencia.php");
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
    

    $loader = new \Twig\Loader\FilesystemLoader('.');
    $twig = new \Twig\Environment($loader);

    
    if($argumentosTwig['tipo'] != "Administrador"  && $argumentosTwig['tipo'] != "Colaborador"){
        $template = $twig->load('/html/Error.html');
    }else{
    $template = $twig->load('/html/MIncidencia.html');
    }
    echo $template->render($argumentosTwig);
    

?>