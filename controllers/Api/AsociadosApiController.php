<?php 

require_once '../../models/AsociadoModel.php';
require_once '../../helpers/Validacion.php';

// CONTROLADOR QUE UNICAMENTE RETORNA JSON
class AsociadosApiController
{
    function getAsociado( $id ) {

    }

    function save($id, $nombre, $apellido, $direccion, $edad, $dui, $nit, $profesion_id, $agencia_id){
        
        $data = new stdClass();

        $asociado = new AsociadoModel();
        $asociado->setNombre( $nombre );
        $asociado->setApellido( $apellido );
        $asociado->setDireccion( $direccion );
        $asociado->setEdad( $edad );
        $asociado->setDui( $dui );
        $asociado->setNit( $nit );
        $asociado->setProfesion($profesion_id);
        $asociado->setAgencia( $agencia_id );
        $asociado->setId( null );

            $accion = $asociado->getId() == null ? 'insert': 'update';
            $data->accion = $accion;

            $response = $asociado->save();

            if (  $response->status ) {
                $data->status = true;
                $data->objeto = $response->object;
            }else {
                $data->status = false;
                $data->mensaje = "Algo salio mal en el modelo";
            }
        echo json_encode( $data );
    }
} 

$asociadoApi = new AsociadosApiController();
if ( isset($_POST) ){
    
    $id = null;

    if( isset($_POST['id'] ) && $_POST['id'] != null ){
        $id = $_POST['id'];
    }

    $nombre = $_POST['nombre']; 
    $apellido = $_POST['apellido'];
    $direccion = $_POST['direccion'];
    $edad = $_POST['edad'];
    $dui = $_POST['dui'];
    $nit = $_POST['nit'];
    $profesion_id = $_POST['profesion_id'];
    $agencia_id = $_POST['agencia_id'];

    $asociadoApi->save($id, $nombre, $apellido, $direccion, $edad, $dui, $nit, $profesion_id, $agencia_id);
    //echo json_encode( $_POST['nombre'] );
}