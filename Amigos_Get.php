<?php

	require "Amigos.php";

	if($_SERVER["REQUEST_METHOD"]=="GET"){

		if(isset($_GET["id_usuario"])){
			//Se obtiene
			$ident = $_GET["id_usuario"];

			$respuesta = Amigos::getAmigos($ident);

			if($respuesta){
				$contenedor["resultado"] = "OK";
				$contenedor["datos"] = $respuesta;
				echo json_encode($contenedor);	
			}
			else{
				echo json_encode(array("resultado" => "El usuario no tiene amigos registrados"));
			}

		} else{
			echo json_encode(array("resultado" => "Falta el ID"));
		}

	}

?>