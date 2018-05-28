<?php

	require "Login.php";

	if($_SERVER["REQUEST_METHOD"]=="GET"){

		//Si está deifnida la variable id
		if(isset($_GET["id_usuario"])){
			//Se obtiene
			$ident = $_GET["id_usuario"];

			$respuesta = Login::getUsuariosID($ident);

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