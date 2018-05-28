<?php

require 'Database.php';

class Registro{
    function _construct(){
        
    }
    
    public static function insertUsuarios($id_usuario, $password, $nombre, $apellidos, $correo, $token){
    	$consulta = "INSERT INTO Usuario(id_usuario, password, nombre, apellidos, correo, token) VALUES(?, ?, ?, ?, ?, ?)";
    	try{
    	$resultado = Database::getInstance()->getDb()->prepare($consulta);

    	return $resultado->execute(array($id_usuario, $password, $nombre, $apellidos, $correo, $token));
    	}catch(PDOException $e){
    		return false;
    	}
    }
}
?>