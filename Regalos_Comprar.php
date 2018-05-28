<?php

require 'Regalos.php';

if($_SERVER["REQUEST_METHOD"]=="POST"){
	$datos = json_decode(file_get_contents("php://input"), true);
	
	$respuesta = Regalos::comprarRegalos($datos["usuarios"]);
	
	if($respuesta){
		echo json_encode(array('resultado'=>'Pago completado'));
	}
	else{
		echo json_encode(array('resultado'=>'Error en el pago'));
		}
}
?>