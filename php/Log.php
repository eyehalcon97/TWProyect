


<?php

class Log {
    
    private $Id;
    private $Usuario;
    private $Tipo;
    private $Fecha;

    
    function __construct($Id,$Usuario,$Tipo,$Fecha){
    $this->Id = $Id;
    $this->Usuario = $Usuario;
    $this->Tipo = $Tipo;
    $this->Fecha = $Fecha;
    }

    function getId(){
        return $this->Id;
    }
    function getUsuario(){
        return $this->Usuario;
    }
    function getTipo(){
        return $this->Tipo;
    }
    function getFecha(){
        return $this->Fecha;
    }
}


?> 