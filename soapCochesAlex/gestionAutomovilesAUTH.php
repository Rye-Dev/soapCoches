<?php

class server {
    private $con;
    private $IsAuthenticated;

    public function __construct() {
        $this->con = (is_null($this->con)) ? self::connect() : $this->con;
        $this->IsAuthenticated = false;
    }

    static function connect() {
        try {
            $user = "root";
            $pass = "";
            $dbname = "coches";
            $host = "127.0.0.1";

            $con = new PDO("mysql:host=$host; dbname=$dbname", $user, $pass);
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $con;
        } catch (PDOException $e) {
            print "<p>Error: " . $e->getMessage() . "</p>\n";
            return null;
        }
    }

    public function ObtenerMarcas() {
        $marcas = array();
        if ($this->con) {
            $result = $this->con->query('select id, marca from marcas');

            while ($row = $result->fetch(PDO::FETCH_ASSOC))
                $marcas[$row['id']] = $row['marca'];
        }
        return $marcas;
    }

    public function ObtenerMarcasUrl() {
        $url = array();
        if ($this->con) {
            $result = $this->con->query('select marca, url from marcas');
    
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $url = $row['url'];
                $marca = $row['marca'];
                $marcas [$marca] = $url;
            }
        }
        return $marcas;
    }
    

    public function ObtenerModelosPorMarca($marca) {
        $query = "SELECT modelo FROM modelos WHERE marca = (SELECT id FROM marcas WHERE marca = '$marca')";
        $result = $this->con->query($query);
        
        if ($result) {
            $modelos = $result->fetchAll(PDO::FETCH_ASSOC);
            return array_column($modelos, 'modelo');
        } else {
            return print 'Error: No output obtained';
        }
    }
    
    
    
    

    public static function authenticate($header_params) {
        if ($header_params->username == 'ies' && $header_params->password == 'daw') {
            return true;
        } else {
            throw new SoapFault('Wrong user/pass combination', 401);
        }
    }

}

$params = array('uri' => 'http://localhost/soapCochesDefinitivo/gestionAutomovilesAUTH.php');
$server = new SoapServer(null, $params);
$server->setClass('server');
$server->handle();

