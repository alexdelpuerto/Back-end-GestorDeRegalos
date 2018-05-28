<?php

require 'Eventos.php';

if($_SERVER["REQUEST_METHOD"]=="POST"){
	$datos = json_decode(file_get_contents("php://input"), true);

	$respuesta = Eventos::deleteEventos($datos["id_evento"]);

	if($respuesta){
		echo json_encode(array('resultado'=>'Evento borrado correctamente'));
	}
	else{
		echo json_encode(array('resultado'=>'Error'));
	}
}

?>