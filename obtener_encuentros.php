<?php
/**
 * Obtiene todos los encuentros de la base de datos
 */

require 'Encuentros.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    // Manejar petición GET
    $encuentros = Encuentros::getAll();

    if ($encuentros) {

        $datos["estado"] = 1;
        $datos["encuentros"] = $encuentros;

        print json_encode($datos);
    } else {
        print json_encode(array(
            "estado" => 2,
            "mensaje" => "Ha ocurrido un error"
        ));
    }
}

