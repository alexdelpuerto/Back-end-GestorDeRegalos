<?php

require "Amigos.php";

if($_SERVER["REQUEST_METHOD"]=="GET"){

	$usuario = $_GET["id_usuario"];
	$evento = $_GET["id_evento"];

	$respuesta = Amigos::getAmigosAgregar($usuario, $evento);

	if($respuesta){
		$contenedor["resultado"] = "OK";
		$contenedor["datos"] = $respuesta;
		echo json_encode($contenedor);	
	}
	else{
		echo json_encode(array("resultado" => "Error al obtener los datos"));
	}
}

?>