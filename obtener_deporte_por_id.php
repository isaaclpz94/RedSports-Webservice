<?php
/**
 * Obtiene el detalle de un deporte especificado por
 * su identificador "deporte_id"
 */

require 'Deportes.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    if (isset($_GET['deporte_id'])) {

        // Obtener parámetro deporte_id
        $parametro = $_GET['deporte_id'];

        // Tratar retorno
        $retorno = Deportes::getById($parametro);


        if ($retorno) {

            $deporte["estado"] = 1;
            $deporte["deporte"] = $retorno;
            // Enviar objeto json del alumno
            print json_encode($deporte);
        } else {
            // Enviar respuesta de error general
            print json_encode(
                array(
                    'estado' => '2',
                    'mensaje' => 'No se obtuvo el registro'
                )
            );
        }

    } else {
        // Enviar respuesta de error
        print json_encode(
            array(
                'estado' => '3',
                'mensaje' => 'Se necesita un identificador'
            )
        );
    }
}

