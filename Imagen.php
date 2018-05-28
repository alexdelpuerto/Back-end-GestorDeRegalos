<?php

	require 'Database.php';

	class Imagen{
		function _construct(){
		}

		public static function updateImagen($id, $imagen){
    		$consulta = "UPDATE Usuario SET imagen=? WHERE id_usuario=?";

    		$resultado = Database::getInstance()->getDb()->prepare($consulta);
    		return $resultado->execute(array($imagen, $id));
    }
	}
?>