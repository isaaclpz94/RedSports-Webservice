<?php
/**
 * Insertar un nuevo usuario_encuentro en la base de datos
 */

require 'Usuarios_Encuentros.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	

    // Decodificando formato Json
    $body = json_decode(file_get_contents("php://input"), true);
	
	$retorno = Usuarios_Encuentros::asiste($body['usuario_id'],$body['encuentro_id']);
	
	if(!$retorno){ //No asiste al encuentro, insertamos la asistencia
		$retorno = Usuarios_Encuentros::insert(
		$body['usuario_id'],
		$body['encuentro_id']);
		
		if ($retorno) {
			$json_string = json_encode(array("estado" => 1,"mensaje" => "Creacion correcta"));
			echo $json_string;
		} else {
			$json_string = json_encode(array("estado" => 2,"mensaje" => "No se creo el registro"));
			echo $json_string;
		}
	}else{
		$json_string = json_encode(array("estado" => 3,"mensaje" => "Ya asiste"));
		echo $json_string;
	}
}
?>