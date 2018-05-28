<?php

require 'Regalos.php';

if($_SERVER["REQUEST_METHOD"]=="POST"){
	$datos = json_decode(file_get_contents("php://input"), true);

	$respuesta = Regalos::deletePago($datos["id_regalo"], $datos["id_usuario"]);

	if($respuesta){
		echo json_encode(array('resultado'=>'Pago borrado correctamente'));
	}
	else{
		echo json_encode(array('resultado'=>'Error'));
	}
}

?>