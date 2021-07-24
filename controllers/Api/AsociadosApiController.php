<?php 

//Este session start Me quita la felicidad 40min 
session_start();

require_once '../../models/AsociadoModel.php';
require_once '../../models/HistorialModel.php';
require_once '../../helpers/Validacion.php';

// CONTROLADOR QUE UNICAMENTE RETORNA JSON
class AsociadosApiController
{
    // llamada al modelo para obtener un asociado por id
    function getAsociado( $id ) {

        $asociadoModel = new AsociadoModel();
        $asociadoModel->setId( $id );
        $asociados = $asociadoModel->getAll();

        echo json_encode($asociados);
    }

    // llamada al modelo para insert y update de un asociado
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
        $asociado->setId( $id );

        $accion = $asociado->getId() == null ? 'insert': 'update';
        $data->accion = $accion;

        if( $asociado->uniqueDui() ){
                $data->status = false;
                $data->mensaje = "Dui ya existe";
        }else {
            if ($asociado->getId() != null ){
        
                $asociadoBd =   $asociado->getAll();
                $asociadoNew =  $asociado;
    
                unset($asociadoBd->id);
                unset($asociadoBd->profesion);
                unset($asociadoBd->agencia);
                unset($asociadoNew->id);
    
                $asociadoBd = (array) $asociadoBd;
                $asociadoNew = (array) $asociadoNew;
                
                $usuario_id = isset($_SESSION['auth']) ? $_SESSION['auth']->id : null;
    
    
                foreach ($asociadoBd as $key => $value) {
                    if ( $value != $asociadoNew[$key] ){
                        $historialModel = new HistorialModel();
                        $historialModel->setUsuario( $usuario_id);
                        $historialModel->setAsociado( $id );
                        $historialModel->setCampo($key);
                        $historialModel->setOld($value);
                        $historialModel->setNew($asociadoNew[$key]);
                        $historialModel->save();
                    }
                }
                $asociado->setId( $id );
            }
            
            $response = $asociado->save();
    
                if (  $response->status ) {
                    $data->status = true;
                    $data->objeto = $response->object;
                }else {
                    $data->status = false;
                    $data->mensaje = "Algo salio mal en el modelo";
                }
        }

        
        echo json_encode( $data );
    }

    //Llamada al Modelo para eliminar asociado
    function eliminar( $id ){

        $asociadoModel = new AsociadoModel();
        $asociadoModel->setId( $id );

        echo json_encode($asociadoModel->eliminar());
    }

    function verificarObjetos( $id, $object ){
        $asociadoModel = new AsociadoModel();
        $asociadoModel->setId( $id );
        $asociados = $asociadoModel->getAll();
    }
} 

$asociadoApi = new AsociadosApiController();

//Recibiendo peticiones GET
if ( isset( $_GET['id']) && isset( $_GET['metodo'] ) ){
    if ( $_GET['metodo'] == 'GET' )
    {
        //obetener usuario
        $asociadoApi->getAsociado( $_GET['id'] );

    } else if ( $_GET['metodo'] == 'DELETE')
    {
        //eliminar usuario
        $asociadoApi->eliminar( $_GET['id']);
    }

}else if ( isset($_POST) ){
    
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
}