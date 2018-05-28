<?php

require 'Registro.php';

if($_SERVER["REQUEST_METHOD"]=="POST"){
	$datos = json_decode(file_get_contents("php://input"), true);

	$respuesta = Registro::insertUsuarios($datos["id_usuario"], $datos["password"], $datos["nombre"], $datos["apellidos"], $datos["correo"], $datos["token"]);

	if($respuesta){
		echo json_encode(array('resultado'=>'Usuario registrado correctamente'));
	}
	else{
		echo json_encode(array('resultado'=>'El usuario ya existe'));
	}
}

?>
