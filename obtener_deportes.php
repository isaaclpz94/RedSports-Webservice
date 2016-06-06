<?php
/**
 * Obtiene todos los deportes de la base de datos
 */

require 'Deportes.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    // Manejar petición GET
    $deportes = Deportes::getAll();

    if ($deportes) {

        $datos["estado"] = 1;
        $datos["deportes"] = $deportes;

        print json_encode($datos);
    } else {
        print json_encode(array(
            "estado" => 2,
            "mensaje" => "Ha ocurrido un error"
        ));
    }
}

