<?php

require 'Amigos.php';

if($_SERVER["REQUEST_METHOD"]=="POST"){
$datos = json_decode(file_get_contents("php://input"), true);

$respuesta = Amigos::crearSolicitud($datos["amigo1"], $datos["amigo2"], $datos["aceptado"]);
$tokenAux = Amigos::getToken($datos["amigo2"]);
$token = $tokenAux["token"];
$emisor = $datos["amigo1"];
$acepta = $datos["aceptado"];
$cuerpo = " quiere ser tu amigo";

	if($respuesta){
		echo json_encode(array('resultado'=>'Solicitud creada correctamente'));
		if($acepta == false){
			Amigos::enviarNotificacion($token, $emisor, $cuerpo);
		}
	}
	else{
		echo json_encode(array('resultado'=>'Error al crear solicitud'));
	}
}

?>
