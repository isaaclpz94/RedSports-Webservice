<?php
/**
 * Insertar un nuevo usuario en la base de datos
 */

require 'Usuarios.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	

    // Decodificando formato Json
    $body = json_decode(file_get_contents("php://input"), true);
	
	$usuario = Usuarios::existeUsuario($body['usuario']);
	
	if(!$usuario){
		// Insertar Usuario
		$retorno = Usuarios::insert(
			$body['usuario'],
			$body['nombre'],
			$body['contrasena']);

		if ($retorno) {
			$json_string = json_encode(array("estado" => 1,"mensaje" => "Creacion correcta"));
			echo $json_string;
		} else {
			$json_string = json_encode(array("estado" => 2,"mensaje" => "No se creo el registro"));
			echo $json_string;
		}
	}else{
		$json_string = json_encode(array("estado" => 3,"mensaje" => "Ya existe"));
		echo $json_string;
	}
}

?>