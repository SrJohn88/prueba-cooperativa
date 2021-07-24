<?php 

require_once 'models/AgenciaModel.php';
require_once 'models/HistorialModel.php';
require_once 'models/ProfesionesModel.php';
require_once 'models/AsociadoModel.php';
require_once 'models/HistorialModel.php';

class AsociadosController{

    function __construct()
    {
        if ( !isset( $_SESSION['auth'] )){
            header('Location:index.php?controller=Auth&action=login');
        }

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

    function historial(){
        if( isset( $_GET['id'] ) ){
            $historial = new HistorialModel();
            $historial->setAsociado( $_GET['id'] );
            $historials = $historial->getHistorial();
            //var_dump($historials); // die;
            require_once('views/asociados/historial.php');
        }
    }

    //Metodos de pruebas 
    function verificarObjetos(){

        $object = new stdClass();
        $object->id = '1';
        $object->nombre = 'messi';
        $object->apellido = 'Messi';
        $object->edad = '34';
        $object->direccion = 'argentina';
        $object->dui = '00000000-8';
        $object->nit = '0909-090909-191-0';
        $object->nombre = 'messi';
        $object->profesion_id = '1';
        $object->agencia_id = '1';

        $asociadoModel = new AsociadoModel();
        $asociadoModel->setId( 1 );
        $asociados = $asociadoModel->getAll();
        unset($asociados->profesion);
        unset($asociados->agencia);
        $asociados = (array)$asociados;
        $object = (array) $object;

        $data = [];

        foreach ($asociados as $key => $value) {
            //echo $key.'-'.$value;
            if( $value != $object[$key]){
                $data[] = ['campo' => $key, 'old' => $value, 'new' => $object[$key] ];
            } 
        }
        $usuario_id = isset($_SESSION['auth']) ? $_SESSION['auth']->id : null;
        var_dump($usuario_id);
        var_dump($data);
        var_dump($asociados);
        var_dump($object);


    }

    function save(){
        
        $data = new stdClass();

        $asociado = new AsociadoModel();
        $asociado->setNombre( 'Leonel Andres' );
        $asociado->setApellido( 'Messi' );
        $asociado->setDireccion( 'Argentina' );
        $asociado->setEdad( '34' );
        $asociado->setDui( '00000000-9' );
        $asociado->setNit( '1000-234567-121-0' );
        $asociado->setProfesion('2');
        $asociado->setAgencia( '2' );
        $asociado->setId( 1 );

        $accion = $asociado->getId() == null ? 'insert': 'update';
        $data->accion = $accion;

        if ($asociado->getId() != null ){
        
            $asociadoBd =   $asociado->getAll();
            $asociadoNew =  $asociado;

            unset($asociadoBd->id);
            unset($asociadoBd->profesion);
            unset($asociadoBd->agencia);
            unset($asociadoNew->id);

            $asociadoBd = (array) $asociadoBd;
            $asociadoNew = (array) $asociadoNew;
            
            $datosHistorial = [];
            $usuario_id = isset($_SESSION['auth']) ? $_SESSION['auth']->id : null;

            foreach ($asociadoBd as $key => $value) {
                if ( $value != $asociadoNew[$key] ){
                    echo $asociadoNew[$key];
                    $datosHistorial[] = [
                        'usuario_id' => $usuario_id,
                        'asociado_id' => 1, 
                        'campo' => $key, 
                        'old' => $value, 
                        'new' => $asociadoNew[$key] 
                    ];
                }
            }

            //var_dump($datosHistorial); die;
            foreach ($datosHistorial as $key => $value) {
                $historialModel = new HistorialModel();
                $historialModel->setUsuario($value['usuario_id']);
                $historialModel->setAsociado($value['asociado_id']);
                $historialModel->setCampo($value['campo']);
                $historialModel->setOld($value['old']);
                $historialModel->setNew($value['new']);
                $historialModel->save();
            }
            $asociado->setId(1);

        }
        
        //var_dump($asociado);
        //die;
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



