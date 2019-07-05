<?php
    
class BasedeDatos
{
    private static $linkBase ="localhost";
    private static $usuario = "root";
    private static $passw = "";
    private static $basededatos = "basedatos";
    
    private static $BD = null;



    private static function Conectar(){
        BasedeDatos::$BD =  new mysqli("localhost", "root", "","basedatos");
        
            if (!BasedeDatos::$BD) {
                die('No pudo conectarse: ' . mysqli_error());
            }
        
        return BasedeDatos::$BD;

    }

    public static function ejecutar($operacion) {
        BasedeDatos::Conectar();
        if($resultado = (BasedeDatos::$BD)->query($operacion)){
            return $resultado;
        }else{
            echo 'Error en la sentencia ' ;
        }

    }


}

?>
