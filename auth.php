<?php
/* Validar login */

require 'Usuarios.php';

if($_SERVER['REQUEST_METHOD'] == 'GET'){
	//Manejar la peticion GET
	if(isset($_GET['usuario'])){
		//Obtener el usuario 
		$user = $_GET['usuario'];
		
		//Tratar retorno
		$retorno = Usuarios::login($user);
		
		if($retorno){
			$datos['estado'] = 1;
			$datos['mensaje'] = $retorno;
			print json_encode($datos);
		}else{
			print json_encode(array('estado'=>'2','mensaje'=>'No existe el usuario'));
		}
	}else{
		print json_encode(array('estado'=>'3','mensaje'=>'Error de parametros'));
	}
	
}

?>