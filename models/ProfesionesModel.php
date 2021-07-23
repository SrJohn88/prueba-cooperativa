<?php 

require_once 'DB/config.php';


class ProfesionesModel
{
    private $db;

    function __construct(){
        $db = Conexion::conectar();
        if($db != NULL ){
            $this->db = $db;
        }
    }

    function getAllProfesiones(){
        $sql = "SELECT * FROM profesiones";
        $pdo = $this->db->prepare( $sql );
        $pdo->execute();

        return $pdo->fetchAll( PDO::FETCH_OBJ) ;
    }
}