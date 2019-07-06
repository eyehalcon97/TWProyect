<?php
require_once'./php/BasedeDatos.php';
require_once'./php/Incidencia.php';
require_once'./php/Usuario.php';
require_once'./php/Comentario.php';

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


function CrearUsuario($nombre,$Papellido,$Sapellido,$Psw,$email,$Usuario,$Ciudad,$Pais,$Tipo,$Estado,$Foto){
    $sentencia = "INSERT INTO usuarios(nombre,Papellido,Sapellido,Psw,email,Usuario,Ciudad,Pais,Tipo,Estado,Foto)
    VALUES ('$nombre','$Papellido','$Sapellido','$Psw','$email','$Usuario','$Ciudad','$Pais','$Tipo','$Estado','$Foto');";
    BasedeDatos::ejecutar($sentencia);
}

function CrearIncidencia($titulo,$descripcion,$lugar,$idUsuario,$estado,$likes,$dislikes,$Foto,$Palabras){
    $sentencia = "INSERT INTO incidencias(titulo,descripcion,lugar,idUsuario,estado,likes,dislikes,Foto,Palabras)
    VALUES ('$titulo','$descripcion','$lugar','$idUsuario','$estado','$likes','$dislikes','$Foto','$Palabras');";
    BasedeDatos::ejecutar($sentencia);
}

function CrearComentario($idIncidencia,$idusuario,$fecha,$comentario){
    $sentencia = "INSERT INTO incidencias(idIncidencia,idusuario,fecha,comentario)
    VALUES ('$idIncidencia','$idusuario','$fecha','$comentario');";
}

function EliminarComentariosdeIncidencia($idIncidencia){
    $sentencia = "DELETE FROM comentarios WHERE idIncidencia = '$idIncindecia';";
    BasedeDatos::ejecutar($sentencia);
}

function EliminarComentariosdeUsuario($idusuario){
    $sentencia = "DELETE FROM comentarios WHERE idusuario = '$idusuario';";
    BasedeDatos::ejecutar($sentencia);
}

function EliminarComentarioporid($idComentario){
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
    $sentencia= "SELECT * FROM comentarios WHERE IdIncidencia = '$IdIncidencia';";
    $resultado = BasedeDatos::ejecutar($sentencia);

    $arrayDevolucion = array();
    
    
    while( $elemento = $resultado->fetch_assoc() ){
        $comentario = new Comentario($elemento['idComentario'],$elemento['idIncidencia'],$elemento['idUsuario'],$elemento['fecha'],$elemento['comentario'],);
        array_push($arrayDevolucion,$comentario);
    }
    //echo $arrayDevolucion;
    return $arrayDevolucion;


}

function ObtenerTodosUsuarios(){
    $sentencia= "SELECT * FROM usuarios;";
    $resultado = BasedeDatos::ejecutar($sentencia);

    $arrayDevolucion = array();
    
    
    while( $elemento = $resultado->fetch_assoc() ){
        
        $usuario = new Usuario($elemento['id'],$elemento['nombre'],$elemento['Papellido'],$elemento['Sapellido'],$elemento['Psw'],$elemento['email'],$elemento['Usuario'],$elemento['Ciudad'],$elemento['Pais'],$elemento['Tipo'],$elemento['Estado'],$elemento['Foto'],$elemento['Conexion']);
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

    $arrayDevolucion = array();
    
    
    while( $elemento = $resultado->fetch_assoc() ){
        $incidencia = new Incidencia($elemento['id'],$elemento['titulo'],$elemento['descripcion'],$elemento['lugar'],$elemento['fecha'],$elemento['idUsuario'],$elemento['estado'],$elemento['likes'],$elemento['dislikes'],$elemento['Foto'],$elemento['Palabras']);
        array_push($arrayDevolucion,$incidencia);
    }

    return $arrayDevolucion;

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
        $comentario = new Comentario($elemento['idComentario'],$elemento['idIncidencia'],$elemento['idUsuario'],$elemento['fecha'],$elemento['comentario'],);
        array_push($arrayDevolucion,$comentario);
    }
    //echo $arrayDevolucion;
    return $arrayDevolucion;

}

function BuscarUsuario($Usuario){
    $sentencia= "SELECT * FROM usuarios where Usuario = '$Usuario';";
    $resultado = BasedeDatos::ejecutar($sentencia);

    $arrayDevolucion = array();
    
    
    while($elemento = $resultado->fetch_assoc()){
        $usuario = new Usuario($elemento['id'],$elemento['nombre'],$elemento['Papellido'],$elemento['Sapellido'],$elemento['Psw'],$elemento['email'],$elemento['Usuario'],$elemento['Ciudad'],$elemento['Pais'],$elemento['Tipo'],$elemento['Estado'],$elemento['Foto'],$elemento['Conexion']);
        array_push($arrayDevolucion,$usuario);
    }

    return $arrayDevolucion;

}

//function Like($id){
//    $Likes = getLikes($id);
//    $Lik = $Likes +1;
//    $sentencia = "UPDATE incidencias SET likes='$Lik' where id = '$id' ;";
//    BasedeDAtos::ejecutar($sentencia);

//}

function ModificarUsuario($id,$Nombre,$Papellido,$Sapellido,$Psw,$email,$Usuario,$Ciudad,$Pais,$Tipo,$Estado,$Foto){
    $sentencia = "UPDATE incidencias SET likes='$Lik' where id = '$id' ;";
    BasedeDAtos::ejecutar($sentencia);

}

?>