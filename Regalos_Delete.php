<?php

require 'Regalos.php';

if($_SERVER["REQUEST_METHOD"]=="POST"){
	$datos = json_decode(file_get_contents("php://input"), true);

	$respuesta = Regalos::deleteRegalos($datos["id_regalo"]);

	if($respuesta){
		echo json_encode(array('resultado'=>'Regalo borrado correctamente'));
	}
	else{
		echo json_encode(array('resultado'=>'Error'));
	}
}

?>