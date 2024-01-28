<!DOCTYPE html>
<html>
<head>
    <style>
        figure {
            border: 1px #cccccc solid;
            padding: 4px;
            margin: auto;
        }

        figcaption {
            background-color: navy;
            color: white;
            font-weight: bolder;
            font-style: italic;
            padding: 2px;
            text-align: center;
        }
    </style>
</head>
<body>
<?php

include 'client.php';

$client = new client();

$marca = $_GET['marca'];
?>
<h1>Modelos disponibles marca: <?php echo $marca ?></h1>
<?php

$modelos = $client->ObtenerModelosPorMarca($marca);

foreach($modelos as $modelo) {
     echo '<figure>
         <img src="images/'.$marca.'.png" alt="logo '.$marca.'" />
         <figcaption>'.$modelo.'</figcaption>
     </figure>';
}







