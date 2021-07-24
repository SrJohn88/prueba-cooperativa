<?php 

require_once 'DB/config.php';

class HistorialModel
{
    private $db;
    private $usuario_id;
    private $asociado_id;
    private $campo;
    private $new;
    private $old;

    function __construct(){
        $db = Conexion::conectar();
        if($db != NULL ){
            $this->db = $db;
        }
    }

    //Llamado al PROCEDIMIENTO PARA INSERTAR LOS DATOS
    function save(){
        $sql = "CALL saveHistorial(?,?,?,?,?)";
        $pdo = $this->db->prepare( $sql );
        $pdo->bindValue(1, $this->usuario_id, PDO::PARAM_INT);
        $pdo->bindValue(2, $this->asociado_id, PDO::PARAM_INT);
        $pdo->bindValue(3, $this->campo, PDO::PARAM_STR);
        $pdo->bindValue(4, $this->old, PDO::PARAM_STR);
        $pdo->bindValue(5, $this->new, PDO::PARAM_STR);
        
        return $pdo->execute();
    }

    //SELECT al Historial de registros de un asociado
    function getHistorial(){
        $sql = "CALL getHistorial(?)";
        $pdo = $this->db->prepare( $sql );
        $pdo->bindValue(1, $this->asociado_id, PDO::PARAM_INT);
        $pdo->execute();
        return $pdo->fetchAll(PDO::FETCH_OBJ);
    }

    // METODOS SET AND GET DE LA CLASE

    function setUsuario($usuario_id) { $this->usuario_id = $usuario_id; }

    function getUsuario(){ return $this->usuario_id ; }

    function setAsociado($asociado_id) { $this->asociado_id = $asociado_id; }

    function getAsociado(){ return $this->asociado_id ; }

    function setCampo($campo) { $this->campo = $campo; }

    function getCampo(){ return $this->campo ; }

    function setNew($new) { $this->new = $new; }

    function getNew(){ return $this->new ; }

    function setOld($old) { $this->old = $old; }

    function getOld(){ return $this->old ; }
}