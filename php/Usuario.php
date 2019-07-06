
<?php

class Usuario {
    
    private $Id;
    private $Nombre;
    private $Papellido;
    private $Sapellido;
    private $Psw;
    private $Email;
    private $Usuario;
    private $Ciudad;
    private $Pais;
    private $Tipo;
    private $Estado;
    private $Fotos;
    private $Conexion;
    
    function __construct($Id,$Nombre,$Papellido,$Sapellido,$Psw,$Email,$Usuario,$Ciudad,$Pais,$Tipo,$Estado,$Fotos,$Conexion){
    $this->Id = $Id;
    $this->Nombre=$Nombre;
    $this->Papellido=$Papellido;
    $this->Sapellido=$Sapellido;
    $this->Psw=$Psw;
    $this->Email=$Email;
    $this->Usuario=$Usuario;
    $this->Ciudad=$Ciudad;
    $this->Pais=$Pais;
    $this->Tipo=$Tipo;
    $this->Estado=$Estado;
    $this->Fotos=$Fotos;
    $this->Conexion=$Conexion;
    }

    function getId(){
        return $this->Id;
    }
    function getNombre(){
        return $this->Nombre;
    }
    function getPapellido(){
        return $this->Papellido;
    }
    function getSapellido(){
        return $this->Sapellido;
    }
    function getPsw(){
        return $this->Psw;
    }
    function getEmail(){
        return $this->Email;
    }
    function getUsuario(){
        return $this->Usuario;
    }
    function getCiudad(){
        return $this->Ciudad;
    }
    function getPais(){
        return $this->Pais;
    }
    function getTipo(){
        return $this->Tipo;
    }
    function getEstado(){
        return $this->Estado;
    }
    function getFotos(){
        return $this->Fotos;
    }
    function getConexion(){
        return $this->Conexion;
    }
   
}


?> 