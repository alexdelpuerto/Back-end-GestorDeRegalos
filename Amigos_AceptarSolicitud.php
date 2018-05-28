<?php

require 'Amigos.php';

if($_SERVER["REQUEST_METHOD"]=="POST"){
	$datos = json_decode(file_get_contents("php://input"), true);

	$respuesta = Amigos::aceptarSolicitud($datos["amigo1"], $datos["amigo2"]);
	$tokenAux = Amigos::getToken($datos["amigo1"]);
	$token = $tokenAux["token"];
	$emisor = $datos["amigo2"];
	$cuerpo = " te ha aceptado como amigo";

	if($respuesta){
		echo json_encode(array('resultado'=>'Solicitud aceptada'));
		Amigos::enviarNotificacion($token, $emisor, $cuerpo);
	}
	else{
		echo json_encode(array('resultado'=>'Error'));
	}
}

?>