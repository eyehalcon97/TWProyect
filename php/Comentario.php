




<?php

class Comentario {
    
    private $idComentario;
    private $idIncidencia;
    private $idUsuario;
    private $Fecha;
    private $Comentario;

    function __construct($idComentario,$idIncidencia,$idUsuario,$Fecha,$Comentario){
    $this->$idComentario = $idComentario;
    $this->idIncidencia=$idIncidencia;
    $this->idUsuario=$idUsuario;
    $this->Fecha=$Fecha;
    $this->Comentario=$Comentario;
    }

    function getidComentario(){
        return $this->idComentario;
    }
    function getidIncidencia(){
        return $this->idIncidencia;
    }
    function getidUsuario(){
        return $this->idUsuario;
    }
    function getFecha(){
        return $this->Fecha;
    }
    function getComentario(){
        return $this->Comentario;
    }


   
}


?> 