<?php

require 'Amigos.php';

if($_SERVER["REQUEST_METHOD"]=="POST"){
	$datos = json_decode(file_get_contents("php://input"), true);

	$respuesta = Amigos::cancelarSolicitud($datos["amigo1"], $datos["amigo2"]);

	if($respuesta){
		echo json_encode(array('resultado'=>'Solicitud cancelada'));
	}
	else{
		echo json_encode(array('resultado'=>'Error'));
	}
}

?>