<?php
require_once'./php/BasedeDatos.php';
require_once'./php/Incidencia.php';
require_once'./php/Usuario.php';
require_once'./php/Comentario.php';
require_once'./php/Log.php';


//Permite almacenar un usuario con la información obtenida con el formulario.
function CrearUsuario($nombre,$Papellido,$Sapellido,$Psw,$email,$Usuario,$Ciudad,$Pais,$Tipo,$Estado,$Foto,$Votos,$Reportes,$Comentarios){
    $sentencia = "INSERT INTO usuarios(nombre,Papellido,Sapellido,Psw,email,Usuario,Ciudad,Pais,Tipo,Estado,Foto,Votos,Reportes,Comentarios)
    VALUES ('$nombre','$Papellido','$Sapellido','$Psw','$email','$Usuario','$Ciudad','$Pais','$Tipo','$Estado','$Foto','$Votos','$Reportes','$Comentarios');";
    BasedeDatos::ejecutar($sentencia);
}

//Permite almacenar una incidencia con la información obtenida con el formulario.
function CrearIncidencia($titulo,$descripcion,$lugar,$idUsuario,$estado,$likes,$dislikes,$Foto,$Palabras){
    $sentencia = "INSERT INTO incidencias(titulo,descripcion,lugar,idUsuario,estado,likes,dislikes,Foto,Palabras)
    VALUES ('$titulo','$descripcion','$lugar','$idUsuario','$estado','$likes','$dislikes','$Foto','$Palabras');";
    BasedeDatos::ejecutar($sentencia);
}

//Permite almacenar los datos de un comentario con la información obtenida con el formulario.
function CrearComentario($idIncidencia,$idusuario,$comentario){
    $sentencia = "INSERT INTO comentarios(idIncidencia,idusuario,comentario)
    VALUES ('$idIncidencia','$idusuario','$comentario');";
    BasedeDatos::ejecutar($sentencia);
}

//Guarda la actividad de un usuario.
function CrearLog($Usuario,$Tipo){
    $sentencia = "INSERT INTO logg(Usuario,Tipo)
    VALUES ('$Usuario','$Tipo');";
    BasedeDatos::ejecutar($sentencia);
}

//Devuelve las incidencias según se quiera ordenar por likes, ordenar por resultado neto (likes-dislikes) o si se quiere ordenar por fecha.
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

//Devuelve la actividad de todos los usuarios
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

//Elimina de la base de datos los datos de un comentario de cierta incidencia.
function EliminarComentariosdeIncidencia($idIncidencia){
    $sentencia = "DELETE FROM comentarios WHERE idIncidencia = '$idIncindecia';";
    BasedeDatos::ejecutar($sentencia);
}

//Elimina de la base de datos los datos de un comentario de cierto usuario.
function EliminarComentariosdeUsuario($idusuario){
    $sentencia = "DELETE FROM comentarios WHERE idusuario = '$idusuario';";
    BasedeDatos::ejecutar($sentencia);
}

//Elimina de la base de datos los datos del comentario con cierto ID.
function EliminaComentarioporid($idComentario){
    $sentencia = "DELETE FROM comentarios WHERE idComentario = '$idComentario';";
    BasedeDatos::ejecutar($sentencia);
}

//Elimina de la base de datos los datos de una incidencia con cierto ID.
function EliminarIncidenciaporid($id){

    $sentencia = "DELETE FROM incidencias WHERE id = '$id';";
    BasedeDatos::ejecutar($sentencia);
}

//Elimina de la base de datos los datos de una incidencia con cierto título.
function EliminarIncidenciaportitulo($titulo){

    $sentencia = "DELETE FROM incidencias WHERE titulo = '$titulo';";
    BasedeDatos::ejecutar($sentencia);
}

//Elimina de la base de datos los datos de todas las incidencias creadas por un usuario con cierto ID.
function EliminarIncidenciasdeusuario($idUsuario){
    $sentencia = "DELETE FROM incidencias WHERE idUsuario = '$idUsuario';";
    BasedeDatos::ejecutar($sentencia);
}

//Suma uno a los likes de una incidencia con cierto ID.
function Like($id){
    $Likes = getLikes($id);
    $Lik = $Likes +1;
    $sentencia = "UPDATE incidencias SET likes='$Lik' where id = '$id' ;";
    BasedeDAtos::ejecutar($sentencia);
}

//Devuelve el número de likes de una incidencia con cierto ID.
function getLikes($id){
    $sentencia= "SELECT likes FROM incidencias WHERE id = '$id';";
    $resultado = BasedeDAtos::ejecutar($sentencia);
    $elemento = $resultado->fetch_assoc();
    return $elemento['likes'];
}

//Suma uno a los dislikes de una incidencia con cierto ID.
function Dislike($id){
    $dislikes = getDislikes($id);
    $Lik = $dislikes +1;
    $sentencia = "UPDATE incidencias SET dislikes='$Lik' where id = '$id' ;";
    BasedeDAtos::ejecutar($sentencia);
}

//Devuelve el número de dislikes de una incidencia con cierto ID.
function getDislikes($id){
    $sentencia= "SELECT dislikes FROM incidencias WHERE id = '$id';";
    $resultado = BasedeDAtos::ejecutar($sentencia);
    $elemento = $resultado->fetch_assoc();
    return $elemento['dislikes'];
}

//Devuelve el ID de una incidencia con cierto título.
function getidincidencia($titulo){
    $sentencia= "SELECT id FROM incidencias WHERE titulo = '$titulo';";
    $resultado = BasedeDAtos::ejecutar($sentencia);
    $elemento = $resultado->fetch_assoc();
    return $elemento['id'];
}

//Devuelve todas las incidencias creadas por cierto usuario.
function getincidenciaUsuario($idUsuario){
    $sentencia= "SELECT * FROM incidencias WHERE idUsuario = '$idUsuario';";
    $resultado = BasedeDAtos::ejecutar($sentencia);
    $arrayDevolucion = array();
    
    
    while( $elemento = $resultado->fetch_assoc() ){
        $incidencia = new Incidencia($elemento['id'],$elemento['titulo'],$elemento['descripcion'],$elemento['lugar'],$elemento['fecha'],$elemento['idUsuario'],$elemento['estado'],$elemento['likes'],$elemento['dislikes'],$elemento['Foto'],$elemento['Palabras']);
        array_push($arrayDevolucion,$incidencia);
    }

    return $arrayDevolucion;
}

//Devuelve todas las incidencias con cierto título.
function getincidenciaportitulo($Titulo){
    $sentencia= "SELECT * FROM incidencias WHERE titulo = '$Titulo';";
    $resultado = BasedeDAtos::ejecutar($sentencia);
    $arrayDevolucion = array();
    
    
    while( $elemento = $resultado->fetch_assoc() ){
        $incidencia = new Incidencia($elemento['id'],$elemento['titulo'],$elemento['descripcion'],$elemento['lugar'],$elemento['fecha'],$elemento['idUsuario'],$elemento['estado'],$elemento['likes'],$elemento['dislikes'],$elemento['Foto'],$elemento['Palabras']);
        array_push($arrayDevolucion,$incidencia);
    }

    return $arrayDevolucion;
}

//Devuelve la incidencia con cierto ID.
function getincidenciaporid($id){
    $sentencia= "SELECT * FROM incidencias WHERE  id = '$id';";
    $resultado = BasedeDAtos::ejecutar($sentencia);
    $arrayDevolucion = array();
    
    
    $elemento = $resultado->fetch_assoc();
        $incidencia = new Incidencia($elemento['id'],$elemento['titulo'],$elemento['descripcion'],$elemento['lugar'],$elemento['fecha'],$elemento['idUsuario'],$elemento['estado'],$elemento['likes'],$elemento['dislikes'],$elemento['Foto'],$elemento['Palabras']);
        
    

    return $incidencia;
}

//Elimina de la base de datos los datos de un usuario con cierto ID.
function EliminarUsuarioporid($id){
    $sentencia = "DELETE FROM usuarios WHERE id = '$id';";
    BasedeDatos::ejecutar($sentencia);
}

//Devuelve el ID de usuario con cierto nombre de usuario.
function getidusuario($Usuario){
    $sentencia= "SELECT id FROM usuarios WHERE Usuario = '$Usuario';";
    $resultado = BasedeDatos::ejecutar($sentencia);
    $elemento = $resultado->fetch_assoc();
    return $elemento['id'];
}

//Devuelve el tipo de usuario con cierto ID.
function getipousuario($id){
    $sentencia= "SELECT Tipo FROM usuarios WHERE id = '$id';";
    $resultado = BasedeDatos::ejecutar($sentencia);
    $elemento = $resultado->fetch_assoc();
    return $elemento['Tipo'];
}

//Comprueba si existe un usuario con cierto nombre de usuario.
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

//Devuelve el número de incidencias totales.
function obtenernumeroIncidencias(){
    $sentencia= "SELECT * FROM incidencias;";
    $resultado = BasedeDatos::ejecutar($sentencia);
    $numero = $resultado->num_rows;
    return $numero;
}

//Devuelve el número de usuarios totales.
function obtenernumeroUsuarios(){
    $sentencia= "SELECT * FROM usuarios;";
    $resultado = BasedeDatos::ejecutar($sentencia);
    $numero = $resultado->num_rows;
    return $numero;
}

//Devuelve el número de incidencias totales de un usuario con cierto ID.
function obtenernumeroIncidenciasUsuario($idUsuario){
    $sentencia= "SELECT * FROM incidencias WHERE idUsuario = '$idUsuario';";
    $resultado = BasedeDatos::ejecutar($sentencia);
    $numero = $resultado->num_rows;
    return $numero;
}

//Devuelve todas las incidencias.
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

//Devuelve todos los comentarios asociados a una incidencia con cierto ID.
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

//Devuelve todos los comentarios existentes en la base de datos.
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

//Devuelve todos los usuarios existentes en la base de datos.
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

//Comprueba que el usuario y la contraseña es correcta.
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

//Devuelve una incidencia con cierta palabra clave asignada.
function BuscarIncidencia($palabra){
    $sentencia= "SELECT * FROM incidencias where Palabras = '$palabra';";
    $resultado = BasedeDatos::ejecutar($sentencia);

    
    
    
    $elemento = $resultado->fetch_assoc();
        $incidencia = new Incidencia($elemento['id'],$elemento['titulo'],$elemento['descripcion'],$elemento['lugar'],$elemento['fecha'],$elemento['idUsuario'],$elemento['estado'],$elemento['likes'],$elemento['dislikes'],$elemento['Foto'],$elemento['Palabras']);
        
    

    return $incidencia;

}

//Comprueba si una incidencia con cierto ID tiene o no comentarios.
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

//Devuelve todos los comentarios de una incidencia con cierto ID.
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

//Devuelve el usuario con cierto nombre de usuario.
function BuscarUsuario($Usuario){
    $sentencia= "SELECT * FROM usuarios where Usuario = '$Usuario';";
    $resultado = BasedeDatos::ejecutar($sentencia);

    
    
    
    $elemento = $resultado->fetch_assoc();
    $usuario = new Usuario($elemento['id'],$elemento['nombre'],$elemento['Papellido'],$elemento['Sapellido'],$elemento['Psw'],$elemento['email'],$elemento['Usuario'],$elemento['Ciudad'],$elemento['Pais'],$elemento['Tipo'],$elemento['Estado'],$elemento['Foto'],$elemento['Votos'],$elemento['Reportes'],$elemento['Comentarios']);
        
    

    return $usuario;
}

//Devuelve el usuario con cierto ID.
function obtenerUsuarioporId($idUsuario){
    $sentencia= "SELECT * FROM usuarios where id = '$idUsuario';";
    $resultado = BasedeDatos::ejecutar($sentencia);

    
    
    
    $elemento = $resultado->fetch_assoc();
    $usuario = new Usuario($elemento['id'],$elemento['nombre'],$elemento['Papellido'],$elemento['Sapellido'],$elemento['Psw'],$elemento['email'],$elemento['Usuario'],$elemento['Ciudad'],$elemento['Pais'],$elemento['Tipo'],$elemento['Estado'],$elemento['Foto'],$elemento['Votos'],$elemento['Reportes'],$elemento['Comentarios']);
        
    

    return $usuario;
}


//Modifica los datos de un usuario.
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

//Modifica los datos de una incidencia.
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

//Devueve los usuarios ordenados por orden descendente de votos.
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

//Devueve los usuarios ordenados por orden descendente de incidencias.
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

//Devueve los usuarios ordenados por orden descendente de comentarios.
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

//Suma uno al número de comentarios de un usuario con cierto ID.
function UsuarioComentario($id){
    $numero = getUsuarioComentario($id);
    $num = $numero +1;
    $sentencia = "UPDATE usuarios SET Comentarios='$num' where Usuario = '$id' ;";
    BasedeDAtos::ejecutar($sentencia);
}

//Devuelve el número de comentarios actuales de un usuario con cierto ID.
function getUsuarioComentario($id){
    $sentencia= "SELECT Comentarios FROM usuarios WHERE Usuario = '$id';";
    $resultado = BasedeDAtos::ejecutar($sentencia);
    $elemento = $resultado->fetch_assoc();
    return $elemento['Comentarios'];
}

//Suma uno al número de incidencias de un usuario con cierto ID.
function UsuarioReporte($id){
    $numero = getUsuarioComentario($id);
    $num = $numero +1;
    $sentencia = "UPDATE usuarios SET Reportes='$num' where Usuario = '$id' ;";
    BasedeDAtos::ejecutar($sentencia);

}

//Devuelve el número de incidencias actuales de un usuario con cierto ID.
function getUsuarioReporte($id){
    $sentencia= "SELECT Reportes FROM usuarios WHERE Usuario = '$id';";
    $resultado = BasedeDAtos::ejecutar($sentencia);
    $elemento = $resultado->fetch_assoc();
    return $elemento['Reportes'];
}

//Suma uno al número de votos de un usuario con cierto ID.
function UsuarioVoto($id){
    $numero = getUsuarioVoto($id);
    $num = $numero +1;
    $sentencia = "UPDATE usuarios SET Votos='$num' where Usuario = '$id' ;";
    BasedeDAtos::ejecutar($sentencia);

}

//Devuelve el número de votos actuales de un usuario con cierto ID.
function getUsuarioVoto($id){
    $sentencia= "SELECT Votos FROM usuarios WHERE Usuario = '$id';";
    $resultado = BasedeDAtos::ejecutar($sentencia);
    $elemento = $resultado->fetch_assoc();
    return $elemento['Votos'];
}

//Exporta la base de datos.
function salvar(){
    $tablas = array();
    $result= BasedeDAtos::ejecutar('SHOW TABLES');
    while($row = mysqli_fetch_row($result))$tablas[] = $row[0];
    // Salvar cada tabla
    $salida = '';foreach($tablas as$tab) {
        $result= BasedeDAtos::ejecutar('SELECT * FROM '.$tab  );
        $num= mysqli_num_fields($result);$salida .= 'DROP TABLE '.$tab.';';
        $row2 = mysqli_fetch_row(BasedeDAtos::ejecutar('SHOW CREATE TABLE '.$tab));
        $salida .= "\n\   n".$row2[1].";\n\  n";  
        // row2[0]=nombre de tabla
        while($row   = mysqli_fetch_row($result)) {
            $salida .= 'INSERT INTO '.$tab.' VALUES(';for($j=0; $j<$num; $j++) {
                $row[$j] = addslashes($row[$j]);$row[$j] = preg_replace("/\n/","\\  n",$row[$j]);
                if(isset($row[$j]))$salida .= '"'.$row[$j].'"';else$salida .= '""';if($j < ($num-1))  $salida .= ',';
                }
                $salida .= ");\   n"; }$salida .= "\n\n\n";
            }

            return $salida;

}

//Comprueba si el usuario es administrador para poder eliminar un usuario.
function PoderEliminarUsuario(){
    $sentencia= "SELECT * FROM usuarios WHERE Tipo = 'Administrador';";
    $resultado = BasedeDatos::ejecutar($sentencia);
    $numero = $resultado->num_rows;
    if($numero > 1){
        
        return true;
    }
    else{
        
        return false;
    }

}


?>