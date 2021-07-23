<?php 

require_once 'DB/config.php';
require_once 'Persona.php';


class UsuarioModel extends Persona
{
    private $email;
    private $password;
    private $db;

    function __construct(){
        $db = Conexion::conectar();
        if($db != NULL ){
            $this->db = $db;
        }
    }

    function login(){

        $response = false; 

        $sql = "SELECT * FROM usuarios WHERE email=?";
        $pdo = $this->db->prepare( $sql );
        $pdo->bindValue(1, $this->email, PDO::PARAM_STR);
        $pdo->execute();

        if ( $pdo->rowCount() > 0 ){
            $usuario = $pdo->fetch(PDO::FETCH_OBJ);
            if( $this->password === $usuario->password ) {
                $response = $usuario;
            }
        }
        return $response;
    }

    function setEmail( $email ){ $this->email = $email; }

    function getEmail(){ return $this->email ; }

    function setPassword( $password ){ 
        $this->password = crypt($password, '$2a$07$usesomesillystringforsalt$' ); 
    }
    function getPassword(){ return $this->password ; }

}