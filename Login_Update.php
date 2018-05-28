<?php

require 'Login.php';

if($_SERVER["REQUEST_METHOD"]=="POST"){
	$datos = json_decode(file_get_contents("php://input"), true);

	$respuesta = Login::updateUsuarios($datos["id_usuario"], $datos["password"], $datos["nombre"], $datos["apellidos"], $datos["correo"]);

	if($respuesta){
		echo json_encode(array('resultado'=>'Se actualizó correctamente'));
	}
	else{
		echo json_encode(array('resultado'=>'Error'));
	}
}

?>