<?php 

require_once 'DB/config.php';
require_once 'Persona.php';

class AsociadoModel extends Persona
{

    private $db;
    public $profesion_id;
    public $agencia_id;

    function __construct(){
        $db = Conexion::conectar();
        if($db != NULL ){
            $this->db = $db;
        }
    }

    function getAll(){
        $sql = "call getAsociados(?)";
        $pdo = $this->db->prepare( $sql );
        $pdo->bindValue(1, $this->id, PDO::PARAM_INT);
        $pdo->execute();

        if ( $this->id == NULL ) {
            return $pdo->fetchAll( PDO::FETCH_OBJ) ;
        }
        return $pdo->fetch(PDO::FETCH_OBJ);
    }

    function save(){
        $sql = "CALL saveAsociado(?,?,?,?,?,?,?,?,?)";
        $pdo = $this->db->prepare( $sql );
        $pdo->bindValue(1, $this->nombre, PDO::PARAM_STR);
        $pdo->bindValue(2, $this->apellido, PDO::PARAM_STR);
        $pdo->bindValue(3, $this->direccion, PDO::PARAM_STR);
        $pdo->bindValue(4, $this->edad, PDO::PARAM_INT);
        $pdo->bindValue(5, $this->dui, PDO::PARAM_STR);
        $pdo->bindValue(6, $this->nit, PDO::PARAM_STR);
        $pdo->bindValue(7, $this->profesion_id, PDO::PARAM_INT);
        $pdo->bindValue(8, $this->agencia_id, PDO::PARAM_INT);
        $pdo->bindValue(9, $this->id, PDO::PARAM_INT);
        
        $response = new stdClass();
        //var_dump($this); die;

        if( $pdo->execute() ) {
            $response->status = true;
            $response->object = $pdo->fetch(PDO::FETCH_OBJ);
        }

        return $response;
    }

    function eliminar() {
        
        $response = new stdClass();

        $sql = "call eliminarAsociado(?)";
        $pdo = $this->db->prepare( $sql );
        $pdo->bindValue(1, $this->id, PDO::PARAM_INT);
        
        if ( $pdo->execute() ){
            $response->mensaje = "El usuario fue eliminado";
            $response->status = true;
        } else {
            $response->mensaje = "Algo salio mal";
            $response->status = false;
        }
        
        return $response;
    }
    

    function setProfesion($profesion_id) { $this->profesion_id = $profesion_id; }

    function getProfesion(){ return $this->profesion_id ; }

    function setAgencia($agencia_id) { $this->agencia_id = $agencia_id; }

    function getAgencia(){ return $this->agencia_id ; }


}
?>