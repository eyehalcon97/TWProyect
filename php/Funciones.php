<?php
require_once'./php/BasedeDatos.php';
require_once'./php/Incidencia.php';
require_once'./php/Usuario.php';
require_once'./php/Comentario.php';
require_once'./php/Log.php';

//echo "hola";
//CrearUsuario("manuel","yo","yo","1234","example@ugr","eyehalcon97","cantabria","Lisboa","Administrador","Activo","Foto");
//$user = getidusuario("eyehalcon");
//echo $user;
//CrearIncidencia("Una inciden0efefcia","esta es la descripcion","tu casa","eyehalcon97","Pendiente",0,0,null,"coche");
//$idin = getidincidencia("Una incidencia");
//echo $idin;
//CrearComentario($idin,$user,$fecha->getTimestamp(),"Este es un comentario");
//echo "Eliminar";

//EliminarComentariosdeUsuario($user);
//EliminarIncidenciasdeusuario($user);
//EliminarUsuario($user);
//echo $user;


function CrearUsuario($nombre,$Papellido,$Sapellido,$Psw,$email,$Usuario,$Ciudad,$Pais,$Tipo,$Estado,$Foto,$Votos,$Reportes,$Comentarios){
    $sentencia = "INSERT INTO usuarios(nombre,Papellido,Sapellido,Psw,email,Usuario,Ciudad,Pais,Tipo,Estado,Foto,Votos,Reportes,Comentarios)
    VALUES ('$nombre','$Papellido','$Sapellido','$Psw','$email','$Usuario','$Ciudad','$Pais','$Tipo','$Estado','$Foto','$Votos','$Reportes','$Comentarios');";
    BasedeDatos::ejecutar($sentencia);
}

function CrearIncidencia($titulo,$descripcion,$lugar,$idUsuario,$estado,$likes,$dislikes,$Foto,$Palabras){
    $sentencia = "INSERT INTO incidencias(titulo,descripcion,lugar,idUsuario,estado,likes,dislikes,Foto,Palabras)
    VALUES ('$titulo','$descripcion','$lugar','$idUsuario','$estado','$likes','$dislikes','$Foto','$Palabras');";
    BasedeDatos::ejecutar($sentencia);
}

function CrearComentario($idIncidencia,$idusuario,$comentario){
    $sentencia = "INSERT INTO comentarios(idIncidencia,idusuario,comentario)
    VALUES ('$idIncidencia','$idusuario','$comentario');";
    BasedeDatos::ejecutar($sentencia);
}
function CrearLog($Usuario,$Tipo){
    $sentencia = "INSERT INTO logg(Usuario,Tipo)
    VALUES ('$Usuario','$Tipo');";
    BasedeDatos::ejecutar($sentencia);
}

function ObtenerTodasIncidenciasFiltro($valor){
    $sentencia =null;
    
    if($valor == "positiva"){

        $sentencia= "SELECT * FROM incidencias ORDER BY likes DESC;";
    }
    if($valor == "netas"){

        $sentencia= "SELECT * FROM incidencias ORDER BY (likes-dislikes) DESC;";
    }
    if($valor == "antiguedad"){
 
        $sentencia= "SELECT * FROM incidencias ORDER BY fecha DESC;";
    }
    
    
    $resultado = BasedeDatos::ejecutar($sentencia);

    $arrayDevolucion = array();
    
    
    while( $elemento = $resultado->fetch_assoc() ){
        $incidencia = new Incidencia($elemento['id'],$elemento['titulo'],$elemento['descripcion'],$elemento['lugar'],$elemento['fecha'],$elemento['idUsuario'],$elemento['estado'],$elemento['likes'],$elemento['dislikes'],$elemento['Foto'],$elemento['Palabras']);
        array_push($arrayDevolucion,$incidencia);
    }

    
    return $arrayDevolucion;
}
function obtenerLog(){
    $sentencia= "SELECT * FROM logg ;";
    $resultado = BasedeDatos::ejecutar($sentencia);

    $arrayDevolucion = array();
    
    
    while( $elemento = $resultado->fetch_assoc() ){
        $incidencia = new Log($elemento['idLog'],$elemento['Usuario'],$elemento['Tipo'],$elemento['Fecha']);
        array_push($arrayDevolucion,$incidencia);
    }

    return $arrayDevolucion;

}

function EliminarComentariosdeIncidencia($idIncidencia){
    $sentencia = "DELETE FROM comentarios WHERE idIncidencia = '$idIncindecia';";
    BasedeDatos::ejecutar($sentencia);
}

function EliminarComentariosdeUsuario($idusuario){
    $sentencia = "DELETE FROM comentarios WHERE idusuario = '$idusuario';";
    BasedeDatos::ejecutar($sentencia);
}

function EliminaComentarioporid($idComentario){
    $sentencia = "DELETE FROM comentarios WHERE idComentario = '$idComentario';";
    BasedeDatos::ejecutar($sentencia);
}

function EliminarIncidenciaporid($id){

    $sentencia = "DELETE FROM incidencias WHERE id = '$id';";
    BasedeDatos::ejecutar($sentencia);
}

function EliminarIncidenciaportitulo($titulo){

    $sentencia = "DELETE FROM incidencias WHERE titulo = '$titulo';";
    BasedeDatos::ejecutar($sentencia);
}

function EliminarIncidenciasdeusuario($idUsuario){
    $sentencia = "DELETE FROM incidencias WHERE idUsuario = '$idUsuario';";
    BasedeDatos::ejecutar($sentencia);
}

function Like($id){
    $Likes = getLikes($id);
    $Lik = $Likes +1;
    $sentencia = "UPDATE incidencias SET likes='$Lik' where id = '$id' ;";
    BasedeDAtos::ejecutar($sentencia);

}

function getLikes($id){
    $sentencia= "SELECT likes FROM incidencias WHERE id = '$id';";
    $resultado = BasedeDAtos::ejecutar($sentencia);
    $elemento = $resultado->fetch_assoc();
    return $elemento['likes'];
}
function Dislike($id){
    $dislikes = getDislikes($id);
    $Lik = $dislikes +1;
    $sentencia = "UPDATE incidencias SET dislikes='$Lik' where id = '$id' ;";
    BasedeDAtos::ejecutar($sentencia);

}

function getDislikes($id){
    $sentencia= "SELECT dislikes FROM incidencias WHERE id = '$id';";
    $resultado = BasedeDAtos::ejecutar($sentencia);
    $elemento = $resultado->fetch_assoc();
    return $elemento['dislikes'];
}



function getidincidencia($titulo){
    $sentencia= "SELECT id FROM incidencias WHERE titulo = '$titulo';";
    $resultado = BasedeDAtos::ejecutar($sentencia);
    $elemento = $resultado->fetch_assoc();
    return $elemento['id'];
}

function getincidenciaUsuario($idUsuario){
    $sentencia= "SELECT * FROM incidencias WHERE idUsuario = '$idUsuario';";
    $resultado = BasedeDAtos::ejecutar($sentencia);
    $arrayDevolucion = array();
    
    
    while( $elemento = $resultado->fetch_assoc() ){
        $incidencia = new Incidencia($elemento['id'],$elemento['titulo'],$elemento['descripcion'],$elemento['lugar'],$elemento['fecha'],$elemento['idUsuario'],$elemento['estado'],$elemento['likes'],$elemento['dislikes'],$elemento['Foto'],$elemento['Palabras']);
        array_push($arrayDevolucion,$incidencia);
    }

    //echo $arrayDevolucion;
    return $arrayDevolucion;

}

function getincidenciaportitulo($Titulo){
    $sentencia= "SELECT * FROM incidencias WHERE titulo = '$Titulo';";
    $resultado = BasedeDAtos::ejecutar($sentencia);
    $arrayDevolucion = array();
    
    
    while( $elemento = $resultado->fetch_assoc() ){
        $incidencia = new Incidencia($elemento['id'],$elemento['titulo'],$elemento['descripcion'],$elemento['lugar'],$elemento['fecha'],$elemento['idUsuario'],$elemento['estado'],$elemento['likes'],$elemento['dislikes'],$elemento['Foto'],$elemento['Palabras']);
        array_push($arrayDevolucion,$incidencia);
    }

    //echo $arrayDevolucion;
    return $arrayDevolucion;

}

function getincidenciaporid($id){
    $sentencia= "SELECT * FROM incidencias WHERE  id = '$id';";
    $resultado = BasedeDAtos::ejecutar($sentencia);
    $arrayDevolucion = array();
    
    
    $elemento = $resultado->fetch_assoc();
        $incidencia = new Incidencia($elemento['id'],$elemento['titulo'],$elemento['descripcion'],$elemento['lugar'],$elemento['fecha'],$elemento['idUsuario'],$elemento['estado'],$elemento['likes'],$elemento['dislikes'],$elemento['Foto'],$elemento['Palabras']);
        
    

    //echo $arrayDevolucion;
    return $incidencia;

}



function EliminarUsuarioporid($id){
    $sentencia = "DELETE FROM usuarios WHERE id = '$id';";
    BasedeDatos::ejecutar($sentencia);
}

function getidusuario($Usuario){
    $sentencia= "SELECT id FROM usuarios WHERE Usuario = '$Usuario';";
    $resultado = BasedeDatos::ejecutar($sentencia);
    $elemento = $resultado->fetch_assoc();
    return $elemento['id'];
}
function getipousuario($id){
    $sentencia= "SELECT Tipo FROM usuarios WHERE id = '$id';";
    $resultado = BasedeDatos::ejecutar($sentencia);
    $elemento = $resultado->fetch_assoc();
    return $elemento['Tipo'];
}

function existeUsuario($Usuario){
    $sentencia= "SELECT * FROM usuarios WHERE Usuario = '$Usuario';";
    $resultado = BasedeDatos::ejecutar($sentencia);
    $numero = $resultado->num_rows;
    if( $numero == 0){
        return false;
    }else{
        return true;
    }
}
function obtenernumeroIncidencias(){
    $sentencia= "SELECT * FROM incidencias;";
    $resultado = BasedeDatos::ejecutar($sentencia);
    $numero = $resultado->num_rows;
    return $numero;
}

function obtenernumeroUsuarios(){
    $sentencia= "SELECT * FROM usuarios;";
    $resultado = BasedeDatos::ejecutar($sentencia);
    $numero = $resultado->num_rows;
    return $numero;
}


function obtenernumeroIncidenciasUsuario($idUsuario){
    $sentencia= "SELECT * FROM incidencias WHERE idUsuario = '$idUsuario';";
    $resultado = BasedeDatos::ejecutar($sentencia);
    $numero = $resultado->num_rows;
    return $numero;
}

function ObtenerTodasIncidencias(){
    $sentencia= "SELECT * FROM incidencias;";
    $resultado = BasedeDatos::ejecutar($sentencia);

    $arrayDevolucion = array();
    
    
    while( $elemento = $resultado->fetch_assoc() ){
        $incidencia = new Incidencia($elemento['id'],$elemento['titulo'],$elemento['descripcion'],$elemento['lugar'],$elemento['fecha'],$elemento['idUsuario'],$elemento['estado'],$elemento['likes'],$elemento['dislikes'],$elemento['Foto'],$elemento['Palabras']);
        array_push($arrayDevolucion,$incidencia);
    }

    //echo $arrayDevolucion;
    return $arrayDevolucion;


}

function ObtenerTodosComentarios($idIncidencia){
    $sentencia= "SELECT * FROM comentarios WHERE IdIncidencia = '$idIncidencia';";
    $resultado = BasedeDatos::ejecutar($sentencia);

    $arrayDevolucion = array();
    
    
    while( $elemento = $resultado->fetch_assoc() ){
        $comentario = new Comentario($elemento['idComentario'],$elemento['idIncidencia'],$elemento['idusuario'],$elemento['fecha'],$elemento['comentario'],);
        array_push($arrayDevolucion,$comentario);
    }
    //var_dump ($arrayDevolucion);
    return $arrayDevolucion;


}
function ObtenerTodosComentariosdetodo(){
    $sentencia= "SELECT * FROM comentarios;";
    $resultado = BasedeDatos::ejecutar($sentencia);

    $arrayDevolucion = array();
    
    
    while( $elemento = $resultado->fetch_assoc() ){
        $comentario = new Comentario($elemento['idComentario'],$elemento['idIncidencia'],$elemento['idusuario'],$elemento['fecha'],$elemento['comentario'],);
        array_push($arrayDevolucion,$comentario);
    }
    //var_dump ($arrayDevolucion);
    return $arrayDevolucion;


}

function ObtenerTodosUsuarios(){
    $sentencia= "SELECT * FROM usuarios WHERE Usuario != 'Anonimo' ;";
    $resultado = BasedeDatos::ejecutar($sentencia);

    $arrayDevolucion = array();
    
    
    while( $elemento = $resultado->fetch_assoc() ){
        
        $usuario = new Usuario($elemento['id'],$elemento['nombre'],$elemento['Papellido'],$elemento['Sapellido'],$elemento['Psw'],$elemento['email'],$elemento['Usuario'],$elemento['Ciudad'],$elemento['Pais'],$elemento['Tipo'],$elemento['Estado'],$elemento['Foto'],$elemento['Votos'],$elemento['Reportes'],$elemento['Comentarios']);
        array_push($arrayDevolucion,$usuario);
    }
    //echo $arrayDevolucion;
    return $arrayDevolucion;


}

function IniciarSesion($Usuario,$Psw){
    $sentencia= "SELECT * FROM usuarios where Usuario = '$Usuario' and Psw = '$Psw';";
    $resultado = BasedeDatos::ejecutar($sentencia);
    $numero = $resultado->num_rows;
    if( $numero == 0){
        return false;
    }else{
        return true;
    }
}

function BuscarIncidencia($palabra){
    $sentencia= "SELECT * FROM incidencias where Palabras = '$palabra';";
    $resultado = BasedeDatos::ejecutar($sentencia);

    
    
    
    $elemento = $resultado->fetch_assoc();
        $incidencia = new Incidencia($elemento['id'],$elemento['titulo'],$elemento['descripcion'],$elemento['lugar'],$elemento['fecha'],$elemento['idUsuario'],$elemento['estado'],$elemento['likes'],$elemento['dislikes'],$elemento['Foto'],$elemento['Palabras']);
        
    

    return $incidencia;

}

function TieneComentarioIncidencia($IdIncidencia){
    $sentencia= "SELECT * FROM comentarios where idIncidencia = '$IdIncidencia';";
    $resultado = BasedeDatos::ejecutar($sentencia);
    $numero = $resultado->num_rows;
    if($numero == 0){
        return false;
    }else{
        return true;
    }
}

function getComentarios($IdIncidencia){
    $sentencia= "SELECT * FROM comentarios where idIncidencia = '$IdIncidencia';";
    $resultado = BasedeDatos::ejecutar($sentencia);

    $arrayDevolucion = array();
    
    
    while( $elemento = $resultado->fetch_assoc() ){
        $comentario = new Comentario($elemento['idComentario'],$elemento['idIncidencia'],$elemento['idUsuario'],$elemento['fecha'],$elemento['comentario']);
        array_push($arrayDevolucion,$comentario);
    }
    //echo $arrayDevolucion;
    return $arrayDevolucion;

}

function BuscarUsuario($Usuario){
    $sentencia= "SELECT * FROM usuarios where Usuario = '$Usuario';";
    $resultado = BasedeDatos::ejecutar($sentencia);

    
    
    
    $elemento = $resultado->fetch_assoc();
    $usuario = new Usuario($elemento['id'],$elemento['nombre'],$elemento['Papellido'],$elemento['Sapellido'],$elemento['Psw'],$elemento['email'],$elemento['Usuario'],$elemento['Ciudad'],$elemento['Pais'],$elemento['Tipo'],$elemento['Estado'],$elemento['Foto'],$elemento['Votos'],$elemento['Reportes'],$elemento['Comentarios']);
        
    

    return $usuario;

}

function obtenerUsuarioporId($idUsuario){
    $sentencia= "SELECT * FROM usuarios where id = '$idUsuario';";
    $resultado = BasedeDatos::ejecutar($sentencia);

    
    
    
    $elemento = $resultado->fetch_assoc();
    $usuario = new Usuario($elemento['id'],$elemento['nombre'],$elemento['Papellido'],$elemento['Sapellido'],$elemento['Psw'],$elemento['email'],$elemento['Usuario'],$elemento['Ciudad'],$elemento['Pais'],$elemento['Tipo'],$elemento['Estado'],$elemento['Foto'],$elemento['Votos'],$elemento['Reportes'],$elemento['Comentarios']);
        
    

    return $usuario;

}


function ModificarUsuario($id,$Nombre,$Papellido,$Sapellido,$Psw,$email,$Usuario,$Ciudad,$Pais,$Tipo,$Estado,$Foto){
    $array = array();
    $sentencia = "UPDATE usuarios SET nombre='$Nombre' where id = '$id' ;";
    array_push($array,$sentencia);
    $sentencia = "UPDATE usuarios SET Papellido='$Papellido' where id = '$id' ;";
    array_push($array,$sentencia);
    $sentencia = "UPDATE usuarios SET Sapellido='$Sapellido' where id = '$id' ;";
    array_push($array,$sentencia);
    $sentencia = "UPDATE usuarios SET Psw='$Psw' where id = '$id' ;";
    array_push($array,$sentencia);
    $sentencia = "UPDATE usuarios SET email='$email' where id = '$id' ;";
    array_push($array,$sentencia);
    $sentencia = "UPDATE usuarios SET Usuario='$Usuario' where id = '$id' ;";
    array_push($array,$sentencia);
    $sentencia = "UPDATE usuarios SET Ciudad='$Ciudad' where id = '$id' ;";
    array_push($array,$sentencia);
    $sentencia = "UPDATE usuarios SET Pais='$Pais' where id = '$id' ;";
    array_push($array,$sentencia);
    $sentencia = "UPDATE usuarios SET Tipo='$Tipo' where id = '$id' ;";
    array_push($array,$sentencia);
    $sentencia = "UPDATE usuarios SET Estado='$Estado' where id = '$id' ;";
    array_push($array,$sentencia);
    $sentencia = "UPDATE usuarios SET Foto='$Foto' where id = '$id' ;";
    array_push($array,$sentencia);


    foreach($array as $valor){
        BasedeDAtos::ejecutar($valor);
    }


}

function ModificarIncidencia($id,$Titulo,$Descripcion,$Lugar,$Estado,$Foto,$Palabras){
    $array = array();
    $sentencia = "UPDATE incidencias SET titulo='$Titulo' where id = '$id' ;";
    array_push($array,$sentencia);
    $sentencia = "UPDATE incidencias SET descripcion='$Descripcion' where id = '$id' ;";
    array_push($array,$sentencia);
    $sentencia = "UPDATE incidencias SET Slugar='$Lugar' where id = '$id' ;";
    array_push($array,$sentencia);
    $sentencia = "UPDATE incidencias SET estado='$Estado' where id = '$id' ;";
    array_push($array,$sentencia);
    $sentencia = "UPDATE incidencias SET Foto='$Foto' where id = '$id' ;";
    array_push($array,$sentencia);
    $sentencia = "UPDATE incidencias SET Palabras='$Palabras' where id = '$id' ;";
    array_push($array,$sentencia);


    foreach($array as $valor){
        BasedeDAtos::ejecutar($valor);
    }


}




















function ObtenerTopVotos(){
    
    $sentencia= "SELECT * FROM usuarios WHERE Usuario != 'Anonimo' ORDER BY Votos DESC ;";

    
    
    $resultado = BasedeDatos::ejecutar($sentencia);

    $arrayDevolucion = array();
    
    
    while( $elemento = $resultado->fetch_assoc() ){
        $incidencia = new Usuario($elemento['id'],$elemento['nombre'],$elemento['Papellido'],$elemento['Sapellido'],$elemento['Psw'],$elemento['email'],$elemento['Usuario'],$elemento['Ciudad'],$elemento['Pais'],$elemento['Tipo'],$elemento['Estado'],$elemento['Foto'],$elemento['Votos'],$elemento['Reportes'],$elemento['Comentarios']);
        array_push($arrayDevolucion,$incidencia);
    }

    
    return $arrayDevolucion;
}

function ObtenerTopReportes(){
    
    $sentencia= "SELECT * FROM usuarios WHERE Usuario != 'Anonimo' ORDER BY Reportes DESC ;";

    
    
    $resultado = BasedeDatos::ejecutar($sentencia);

    $arrayDevolucion = array();
    
    
    while( $elemento = $resultado->fetch_assoc() ){
        $incidencia = new Usuario($elemento['id'],$elemento['nombre'],$elemento['Papellido'],$elemento['Sapellido'],$elemento['Psw'],$elemento['email'],$elemento['Usuario'],$elemento['Ciudad'],$elemento['Pais'],$elemento['Tipo'],$elemento['Estado'],$elemento['Foto'],$elemento['Votos'],$elemento['Reportes'],$elemento['Comentarios']);
        array_push($arrayDevolucion,$incidencia);
    }

    
    return $arrayDevolucion;
}

function ObtenerTopComentarios(){
    
    $sentencia= "SELECT * FROM usuarios WHERE Usuario != 'Anonimo' ORDER BY Comentarios DESC ;";

    
    
    $resultado = BasedeDatos::ejecutar($sentencia);

    $arrayDevolucion = array();
    
    
    while( $elemento = $resultado->fetch_assoc() ){
        $incidencia = new Usuario($elemento['id'],$elemento['nombre'],$elemento['Papellido'],$elemento['Sapellido'],$elemento['Psw'],$elemento['email'],$elemento['Usuario'],$elemento['Ciudad'],$elemento['Pais'],$elemento['Tipo'],$elemento['Estado'],$elemento['Foto'],$elemento['Votos'],$elemento['Reportes'],$elemento['Comentarios']);
        array_push($arrayDevolucion,$incidencia);
    }

    
    return $arrayDevolucion;
}




function UsuarioComentario($id){
    $numero = getUsuarioComentario($id);
    $num = $numero +1;
    $sentencia = "UPDATE usuarios SET Comentarios='$num' where Usuario = '$id' ;";
    BasedeDAtos::ejecutar($sentencia);

}

function getUsuarioComentario($id){
    $sentencia= "SELECT Comentarios FROM usuarios WHERE Usuario = '$id';";
    $resultado = BasedeDAtos::ejecutar($sentencia);
    $elemento = $resultado->fetch_assoc();
    return $elemento['Comentarios'];
}
function UsuarioReporte($id){
    $numero = getUsuarioComentario($id);
    $num = $numero +1;
    $sentencia = "UPDATE usuarios SET Reportes='$num' where Usuario = '$id' ;";
    BasedeDAtos::ejecutar($sentencia);

}

function getUsuarioReporte($id){
    $sentencia= "SELECT Reportes FROM usuarios WHERE Usuario = '$id';";
    $resultado = BasedeDAtos::ejecutar($sentencia);
    $elemento = $resultado->fetch_assoc();
    return $elemento['Reportes'];
}

function UsuarioVoto($id){
    $numero = getUsuarioVoto($id);
    $num = $numero +1;
    $sentencia = "UPDATE usuarios SET Votos='$num' where Usuario = '$id' ;";
    BasedeDAtos::ejecutar($sentencia);

}

function getUsuarioVoto($id){
    $sentencia= "SELECT Votos FROM usuarios WHERE Usuario = '$id';";
    $resultado = BasedeDAtos::ejecutar($sentencia);
    $elemento = $resultado->fetch_assoc();
    return $elemento['Votos'];
}


?>