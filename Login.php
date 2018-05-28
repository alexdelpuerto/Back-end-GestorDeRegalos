<?php

require 'Database.php';

class Login{
    function _construct(){
        
    }
    public static function getUsuarios(){
    
 		//La consulta
        $consulta = "SELECT * FROM Usuario";
        $datos = Database::getInstance()->getDb()->prepare($consulta);
        
        $datos->execute();
        
        //Obtener los datos en un array
        $tabla = $datos->fetchAll(PDO::FETCH_ASSOC);

        //Devolver los daots
        return $tabla;

    }

    public static function getUsuariosID($id_usuario){
		
 		
        $consulta = "SELECT id_usuario, password, imagen FROM Usuario WHERE id_usuario=?";
        try{
        	$datos = Database::getInstance()->getDb()->prepare($consulta);
        
        	$datos->execute(array($id_usuario));
                
        	$tabla = $datos->fetch(PDO::FETCH_ASSOC);

        	return $tabla;    	

    	}catch(PDOException $e){
    		return false;
    	}
    }

    public static function getDatosUsuarios($id_usuario){
		
 		
        $consulta = "SELECT password, nombre, apellidos, correo, imagen FROM Usuario WHERE id_usuario=?";
        try{
        	$datos = Database::getInstance()->getDb()->prepare($consulta);
        
        	$datos->execute(array($id_usuario));
                
            $tabla = $datos->fetch(PDO::FETCH_ASSOC);

        	return $tabla;

    	}catch(PDOException $e){
    		return false;
    	}
    }

    public static function updateUsuarios($id_usuario, $password, $nombre, $apellidos, $correo){
    	if(Login::getUsuariosID($id_usuario)){
    		$consulta = "UPDATE Usuario SET password=?, nombre=?, apellidos=?, correo=? WHERE id_usuario=?";

    		$resultado = Database::getInstance()->getDb()->prepare($consulta);
    		return $resultado->execute(array($password, $nombre, $apellidos, $correo, $id_usuario));
    	}
    	else {
    		return false;
    	}
    }

    public static function getToken($id_usuario){
        $consulta = "SELECT token FROM Usuario WHERE id_usuario=?";
        try{
        	$datos = Database::getInstance()->getDb()->prepare($consulta);
        
        	$datos->execute(array($id_usuario));
                
        	$tabla = $datos->fetch(PDO::FETCH_ASSOC);

        	return $tabla;    	

    	}catch(PDOException $e){
    		return false;
    	}
    }

    public static function updateToken($id_usuario, $token){
    	if(self::getUsuariosID($id_usuario)){
    		$consulta = "UPDATE Usuario SET token=? WHERE id_usuario=?";

    		$resultado = Database::getInstance()->getDb()->prepare($consulta);
    		return $resultado->execute(array($token, $id_usuario));
    	}
    }

    public static function buscarUsuarios($buscar, $id_usuario){

        $busqueda = "'%".$buscar."%'";
        $consulta = "SELECT id_usuario, nombre, apellidos, imagen FROM Usuario WHERE id_usuario LIKE $busqueda AND id_usuario NOT IN (SELECT amigo2 FROM Amigo WHERE amigo1=? AND aceptado=1)"; 

        try{
        	$datos = Database::getInstance()->getDb()->prepare($consulta);
        	$datos->execute(array($id_usuario));
                
        	$tabla = $datos->fetchAll(PDO::FETCH_ASSOC);

        	return $tabla;    	

    	}catch(PDOException $e){
    		return false;
    	}
    }
}
?>