<?php
/**
 * Obtiene el detalle de un encuentro especificado por
 * su identificador "idusuario"
 */

require 'Usuarios_Encuentros.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    if (isset($_GET['idusuario'])) {

        // Obtener parámetro idusuario
        $parametro = $_GET['idusuario'];

        // Tratar retorno
        $retorno = Usuarios_encuentros::getEncuentrosByUserID($parametro);


        if ($retorno) {

            $encuentro["estado"] = 1;		
            $encuentro["encuentros"] = $retorno;
            // Enviar objeto json del encuentro
            print json_encode($encuentro);
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

