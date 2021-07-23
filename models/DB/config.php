<?php 

class Conexion {

    static function Conectar() {
        
        try {
            $link = new PDO('mysql:host=localhost;dbname=dbasociados', 'root', '');
            $link->exec("SET NAMES UTF-8");
            return $link;

        } catch( Exception $e){
            echo $e->getMessage();
            return null;
        }

    }
}

?>