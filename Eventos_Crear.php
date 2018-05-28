<?php

	require 'Eventos.php';

	if($_SERVER["REQUEST_METHOD"]=="POST"){
	$datos = json_decode(file_get_contents("php://input"), true);

	$respuesta = Eventos::insertEvento($datos["nombre"], $datos["presupuesto"], $datos["creador"]);

		if($respuesta){
			echo json_encode(array('resultado'=>'Evento creado correctamente'));
		}
		else{
			echo json_encode(array('resultado'=>'Error al crear evento'));
		}
	}

?>
