<?php

	require "Regalos.php";

	if($_SERVER["REQUEST_METHOD"]=="GET"){

		if(isset($_GET["id_evento"])){
			//Se obtiene
			$ident = $_GET["id_evento"];

			$respuesta = Regalos::getRegalos($ident);

			if($respuesta){
				$contenedor["resultado"] = "OK";
				$contenedor["datos"] = $respuesta;
				echo json_encode($contenedor);	
			}
			else{
				echo json_encode(array("resultado" => "El evento no existe"));
			}

		} else{
			echo json_encode(array("resultado" => "Falta el ID"));
		}

	}

?>