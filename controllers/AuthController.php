<?php 

require_once 'models/UsuarioModel.php';
require_once 'helpers/Validacion.php';

class AuthController
{
    function login() {
        require_once 'views/auth/login.php';
    }

    function validarLogin() {

        // var_dump($_POST); die;

        if (isset($_POST) ) {
            $email = isset( $_POST['email'] ) ? $_POST['email'] : '';
            $password =  isset( $_POST['password'] ) ? $_POST['password'] : '';

            if ( !Validacion::isEmail( $email ) ) {
                $_SESSION['error'] = "Formato del Email no Valido";
                header('Location:index.php?controller=Auth&action=login');
            }else {
                $usuario = new UsuarioModel();
                $usuario->setEmail( $email );
                $usuario->setPassword( $password );
                $response = $usuario->login();

                if( is_object($response ) ) {
                    $_SESSION['auth'] = $response;
                    header('Location:index.php?controller=Asociados&action=index');
                } else {
                    $_SESSION['error'] = "Credenciales no coinciden";
                    header('Location:index.php?controller=Auth&action=login');
                }
            }
        }
    }

    function logout(){
        if( isset( $_SESSION['auth'] )){
            unset($_SESSION['auth']);
            header('Location:index.php?controller=Auth&action=login');
        }
    }
}
?>