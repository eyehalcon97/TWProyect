<?php
    
class BasedeDatos
{
    private static $linkBase ="localhost";
    private static $usuario = "root";
    private static $passw = "";
    private static $BD = null;



    private static function Conectar(){
        $BD =  mysql_connect($linkBase, $usuario, $passw);
        
            if (!$BD) {
                die('No pudo conectarse: ' . mysql_error());
            }
        
        return $BD;

    }

    public static function ejecutar($operacion) {
        BasedeDatos::Conectar();
        if($resultado = (BasedeDatos::$BD)->query($operacion)){
            return $resultado;
        }else{
            die('Error en la sentencia ' . mysql_error());
        }

    }

}

?>
