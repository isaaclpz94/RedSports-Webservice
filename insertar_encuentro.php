<?php
/**
 * Insertar un nuevo encuentro en la base de datos
 */

require 'Encuentros.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Decodificando formato Json
    $body = json_decode(file_get_contents("php://input"), true);

    // Insertar encuentro
    $retorno = Encuentros::insert(
        $body['descripcion'],
        $body['deporte_id'],
        $body['apuntados'],
        $body['capacidad'],
        $body['fecha'],
        $body['hora'],
        $body['lat'],
        $body['lon']);

    if ($retorno == -1 || $retorno == -2) {
		print json_encode(array(
            "estado" => 2,
            "mensaje" => "Ha ocurrido un error"
        ));
	}else{
		$datos["estado"] = 1;
        $datos["encuentro"] = $retorno;
		print json_encode($datos);
	}
}

?>