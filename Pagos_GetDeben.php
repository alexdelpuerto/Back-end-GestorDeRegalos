<?php

	require "Regalos.php";

	if($_SERVER["REQUEST_METHOD"]=="GET"){

		if(isset($_GET["id_usuario"])){
			//Se obtiene
			$ident = $_GET["id_usuario"];

			$respuesta = Regalos::getDeben($ident);

			if($respuesta){
				$contenedor["resultado"] = "OK";
				$contenedor["datos"] = $respuesta;
				echo json_encode($contenedor);	
			}
			else{
				echo json_encode(array("resultado" => "El usuario no existe"));
			}

		} else{
			echo json_encode(array("resultado" => "Falta el ID"));
		}

	}

?>