<?php

	require "Login.php";

	if($_SERVER["REQUEST_METHOD"]=="GET"){

		try{
			$datos = Login::getUsuarios();
			echo json_encode($datos);

		}catch(PDOException $e){
			echo "error";
		}
	}

?>