<?php

	require "Login.php";

	if($_SERVER["REQUEST_METHOD"]=="GET"){

		$buscar = $_GET["buscar"];
		$id_usuario = $_GET["id_usuario"];

		$respuesta = Login::buscarUsuarios($buscar, $id_usuario);

		if($respuesta){
			$contenedor["resultado"] = "OK";
			$contenedor["datos"] = $respuesta;
			echo json_encode($contenedor);	
		}
		else{
			echo json_encode(array("resultado" => "No hay resultados"));
		}
	}

?>