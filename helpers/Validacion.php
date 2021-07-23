<?php 

class Validacion{

    private $campos;
    private $errors;

    function __construct( $campos ){
        $this->campos = $campos;
        $errors = [];
    }

    function ejecutar(){

        foreach ($this->campos as $value) {
            
            switch ( $value['validar'] ) {
                case 'texto':
                    $this->isTexto($value['value'], $value['name']);
                    break;
                case 'dui':
                    $this->isNit($value['value'], $value['name']);
                    break;
                case 'nit':
                    $this->isDui($value['value'], $value['name']);
                    break;
                default:
                    # code...
                    break;
            }

        }
    }

    function getResult(){
        if( $this->errors == 0 ){
            return [];
        }
        return $this->errors;
    }

    function isTexto( $value, $name ) {
        if ( ! preg_match( '/^[a-zA-Zñ ]+$/', $value) )  {
            $this->errors[$name] = "Campo ".$name.' no cumple con el formato solictado';
        }
    }

    function isNit( $value, $name ) {
        if ( ! preg_match( '/^[0-9]{4}-[0-9]{6}-[0-9]{3}-[0-9]{1}$/', $value ) )  {
            $this->errors[$name] = "Campo ".$name.' no cumple con el formato solictado';
        }
    }

    function isDui( $value, $name ) {
        if( $value != null ) {
            if ( ! preg_match( '/^[0-9]{8}-[0-9]{1}$/', $value ) )  {
                $this->errors[$name] = "Campo ".$name.' no cumple con el formato solictado';
            }
        }
        
    }

}