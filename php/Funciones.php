<?php
require_once'./BasedeDatos.php';
$fecha = new DateTime();
echo "hola";
CrearUsuario("manuel","yo","yo","1234","example@ugr","eyehalcon","cantabria","Lisboa","Administrador","Activo",$fecha->getTimestamp(),"Foto");
$user = getidusuario("eyehalcon");
echo $user;
CrearIncidencia("Una incidencia","esta es la descripcion","tu casa",$fecha->getTimestamp(),$user,"Pendiente",0,0,null);
$idin = getidincidencia("Una incidencia");
echo $idin;
CrearComentario($idin,$user,$fecha->getTimestamp(),"Este es un comentario");
echo "Eliminar";

EliminarComentariosdeUsuario($user);
EliminarIncidenciasdeusuario($user);
EliminarUsuario($user);
echo $user;


function CrearUsuario($nombre,$Papellido,$Sapellido,$Psw,$email,$Usuario,$Ciudad,$Pais,$Tipo,$Estado,$fecha,$Foto){
    $sentencia = "INSERT INTO usuarios(nombre,Papellido,Sapellido,Psw,email,Usuario,Ciudad,Pais,Tipo,Estado,Conexion,Foto)
    VALUES ('$nombre','$Papellido','$Sapellido','$Psw','$email','$Usuario','$Ciudad','$Pais','$Tipo','$Estado','$fecha','$Foto');";
    BasedeDatos::ejecutar($sentencia);
}

function CrearIncidencia($titulo,$descripcion,$lugar,$fecha,$idUsuario,$estado,$likes,$dislikes,$Foto){
    $sentencia = "INSERT INTO incidencias(titulo,descripcion,lugar,fecha,idUsuario,estado,likes,dislikes,Foto)
    VALUES ('$titulo','$descripcion','$lugar','$fecha','$idUsuario','$estado','$likes','$dislikes','$Foto');";
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


function EliminarIncidenciaportitulo($titulo){
    $id = getidincidencia($titulo);
    $sentencia = "DELETE FROM incidencias WHERE id = '$id';";
    BasedeDatos::ejecutar($sentencia);
}

function EliminarIncidenciasdeusuario($idUsuario){
    $sentencia = "DELETE FROM incidencias WHERE idUsuario = '$idUsuario';";
    BasedeDatos::ejecutar($sentencia);
}


function getidincidencia($titulo){
    $sentencia= "SELECT id FROM incidencias WHERE titulo = '$titulo';";
    $resultado = BasedeDAtos::ejecutar($sentencia);
    $elemento = $resultado->fetch_assoc();
    return $elemento['id'];
}

function EliminarUsuario($id){
    $sentencia = "DELETE FROM usuarios WHERE id = '$id';";
    BasedeDatos::ejecutar($sentencia);
}

function getidusuario($Usuario){
    $sentencia= "SELECT id FROM usuarios WHERE Usuario = '$Usuario';";
    $resultado = BasedeDatos::ejecutar($sentencia);
    $elemento = $resultado->fetch_assoc();
    return $elemento['id'];
}









?>