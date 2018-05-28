<?php

require "Eventos.php";

if($_SERVER["REQUEST_METHOD"]=="GET"){

	$usuario = $_GET["id_usuario"];
	$evento = $_GET["id_evento"];

	$respuesta = Eventos::getUsersPertenencia($evento, $usuario);

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