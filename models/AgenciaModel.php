<?php 

require_once 'DB/config.php';


class AgenciaModel
{
    private $db;
    
    function __construct(){
        $db = Conexion::conectar();
        if($db != NULL ){
            $this->db = $db;
        }
    }

    function getAllAgencias(){
        $sql = "SELECT * FROM agencias";
        $pdo = $this->db->prepare( $sql );
        $pdo->execute();

        return $pdo->fetchAll( PDO::FETCH_OBJ) ;
    }
}