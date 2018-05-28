<?php

require 'Regalos.php';

if($_SERVER["REQUEST_METHOD"]=="POST"){
	$datos = json_decode(file_get_contents("php://input"), true);

	$respuesta = Regalos::insertRegalo($datos["nombre"], $datos["descripcion"], $datos["foto"], $datos["precio"], $datos["evento"]);

	if($respuesta){
		echo json_encode(array('resultado'=>'Regalo creado correctamente'));
	}
	else{
		echo json_encode(array('resultado'=>'No se pudo crear el regalo'));
	}
}

?>