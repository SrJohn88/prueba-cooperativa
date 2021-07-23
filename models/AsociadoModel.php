<?php 

require_once 'DB/config.php';
require_once 'Persona.php';

class AsociadoModel extends Persona
{

    private $db;
    private $profesion_id;
    private $agencia_id;

    function __construct(){
        $db = Conexion::conectar();
        if($db != NULL ){
            $this->db = $db;
        }
    }

    function getAll(){
        $sql = "SELECT a.id, a.nombre,a.apellido, a.edad, a.direccion, a.dui, a.nit, p.profesion, u.agencia FROM asociados as a inner join profesiones as p on a.profesion_id=p.id INNER join agencias as u on a.agencia_id=u.id";
        $pdo = $this->db->prepare( $sql );
        $pdo->execute();

        return $pdo->fetchAll( PDO::FETCH_OBJ) ;
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

    function setProfesion($profesion_id) { $this->profesion_id = $profesion_id; }

    function getProfesion(){ return $this->profesion_id ; }

    function setAgencia($agencia_id) { $this->agencia_id = $agencia_id; }

    function getAgencia(){ return $this->agencia_id ; }


}
?>