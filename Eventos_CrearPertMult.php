<?php

require 'Eventos.php';

if($_SERVER["REQUEST_METHOD"]=="POST"){
	$datos = json_decode(file_get_contents("php://input"), true);
	
	$respuesta = Eventos::insertPertMult($datos["usuarios"]);
	
	if($respuesta){
		echo json_encode(array('resultado'=>'Usuarios agregados correctamente'));
	}
	else{
		echo json_encode(array('resultado'=>'Error al agregar usuarios'));
		}
}
?>