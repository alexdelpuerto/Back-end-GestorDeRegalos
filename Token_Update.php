<?php

require 'Login.php';

if($_SERVER["REQUEST_METHOD"]=="POST"){
	$datos = json_decode(file_get_contents("php://input"), true);

	$respuesta = Login::updateToken($datos["id_usuario"], $datos["token"]);

	if($respuesta){
		echo json_encode(array('resultado'=>'Token actualizado'));
	}
	else{
		echo json_encode(array('resultado'=>'Error'));
	}
}

?>