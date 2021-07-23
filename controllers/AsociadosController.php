<?php 

require_once 'models/AgenciaModel.php';
require_once 'models/ProfesionesModel.php';
require_once 'models/AsociadoModel.php';

class AsociadosController{

    function __construct()
    {
        if ( !isset( $_SESSION['auth'] )){
            header('Location:index.php?controller=Auth&action=login');
        }

    }

    function saveP(){
        $data = new stdClass();

        $asociado = new AsociadoModel();
        $asociado->setNombre( 'prueba1' );
        $asociado->setApellido( 'okokok' );
        $asociado->setDireccion( 'okokok' );
        $asociado->setEdad( 23 );
        $asociado->setDui( 'jijsijsjs' );
        $asociado->setNit( 'jijsijsjs' );
        $asociado->setProfesion(2);
        $asociado->setAgencia( 4 );
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
        var_dump($data); die;
    }
    function index(){
        $agencia = new AgenciaModel();
        $agencias = $agencia->getAllAgencias();
        $profesion = new ProfesionesModel();
        $profesiones = $profesion->getAllProfesiones();

        $asociado = new AsociadoModel();
        $asociados = $asociado->getAll();

        //var_dump($agencias);
        require_once('views/asociados/index.php');
    }
}



