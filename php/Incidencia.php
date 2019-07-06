


<?php

class Incidencia {
    
    private $Id;
    private $Titulo;
    private $Descripcion;
    private $Lugar;
    private $Fecha;
    private $IdUsuario;
    private $Estado;
    private $Likes;
    private $Dislikes;
    private $Fotos;
    private $Palabras;

    function __construct($Id,$Titulo,$Descripcion,$Lugar,$Fecha,$IdUsuario,$Estado,$Likes,$Dislikes,$Fotos,$Palabras){
    
    
    $this->Id = $Id;
    $this->Titulo=$Titulo;
    $this->Descripcion=$Descripcion;
    $this->Lugar=$Lugar;
    $this->Fecha=$Fecha;
    $this->IdUsuario=$IdUsuario;
    $this->Estado=$Estado;
    $this->Likes=$Likes;
    $this->Dislikes=$Dislikes;
    $this->Fotos=$Fotos;
    $this->Palabras=$Palabras;
    
    }

    function getId(){
        return $this->Id;
    }
    function getTitulo(){
        return $this->Titulo;
    }
    function getDescripcion(){
        return $this->Descripcion;
    }
    function getLugar(){
        return $this->Lugar;
    }
    function getFecha(){
        return $this->Fecha;
    }
    function getIdUsuario(){
        return $this->IdUsuario;
    }
    function getEstado(){
        return $this->Estado;
    }
    function getLikes(){
        return $this->Likes;
    }
    function getDislikes(){
        return $this->Dislikes;
    }
    function getFotos(){
        return $this->Fotos;
    }
    function getPalabras(){
        return $this->Palabras;
    }
   
}


?> 