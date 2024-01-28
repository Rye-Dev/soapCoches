<?php
// How to Create a SOAP Client/Server in PHP (Added Authentification) - Part 02
// https://www.youtube.com/watch?v=6V_myufS89A

class Client {
    private $instance;
    public function __construct() {
        $params = array('location' => 'http://localhost/soapCochesDefinitivo/gestionAutomovilesAUTH.php',
            'uri' => 'http://localhost/soapCochesDefinitivo/gestionAutomovilesAUTH.php',
            'trace' => 1);
        $this->instance = new SoapClient(null, $params);

        // set the header 
        // https://www.php.net/manual/en/reserved.classes.php
        $auth_params = new stdClass();
        $auth_params->username = 'ies';
        $auth_params->password = 'daw';

        // https://www.php.net/manual/en/class.soapheader.php
        // https://www.php.net/manual/en/class.soapvar.php

        $header_params = new SoapVar($auth_params, SOAP_ENC_OBJECT);
        $header = new SoapHeader('http://localhost/soapCochesDefinitivo/gestionAutomovilesAUTH.php', 'authenticate', $header_params, false);
        $this->instance->__setSoapHeaders(array($header));

    }

    public function ObtenerMarcasUrl() {
        return $this->instance->__soapCall('ObtenerMarcasUrl', []);
    }

    public function ObtenerModelosPorMarca($marca) {
        return $this->instance->__soapCall('ObtenerModelosPorMarca', array($marca));
    }
    public function ObtenerMarcas() {
        return $this->instance->__soapCall('ObtenerMarcas', []);
    }


}

$client = new client();

