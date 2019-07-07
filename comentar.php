<?php

    error_reporting(E_ALL);
    ini_set('display_errors', '1');

    require_once './vendor/autoload.php';
    require_once './php/funciones.php';
    session_start();


    
    //var_dump($comentarios);
    $loader = new \Twig\Loader\FilesystemLoader('.');
    $twig = new \Twig\Environment($loader);

    $argumentosTwig = ['tipo' => null , 'incidencia' =>null, 'comentarios'=>null];

    if(isset($_SESSION["Nombre"])){
        
        echo $_SESSION["Nombre"];
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
            
            
            $_SESSION["Nombre"] = $User;
            $Usuario =$_SESSION["Nombre"];
            $id = getidusuario($Usuario);
            $tipo = getipousuario($id);
            $argumentosTwig['tipo']=$tipo;
            header("Location: ./comentar.php");
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
    

    
    if( isset($_POST['Comentario'])){
        $idincidencia = $_POST['id'];
        $incidencia = getincidenciaporid($idincidencia);
        $argumentosTwig['incidencia']=$incidencia;
        $comentarios = ObtenerTodosComentarios($idincidencia);
        $argumentosTwig['comentarios']=$comentarios;
    }
    
    if( isset($_POST['comentar'])){
        $comentario = $_POST['comentario'];
        $id = $_POST['id'];
        
        CrearComentario($id,$Usuario,$comentario);
        header("Location: ./index.php");
    }

    if( isset($_POST['Eliminar'])){
        $id = $_POST['id'];
        
        EliminaComentarioporid($id);
        header("Location: ./index.php");
    }

    
    if($argumentosTwig['tipo'] != "Administrador"  && $argumentosTwig['tipo'] != "Colaborador"){
        $template = $twig->load('/html/Error.html');
    }else{
    $template = $twig->load('/html/Comentar.html');
    }
    echo $template->render($argumentosTwig);
    

?>