<?php
	require 'Database.php';

	class Eventos{

		function _construct(){}

    	public static function insertEvento($nombre, $presupuesto, $creador){

    		$conex = Database::getInstance()->getDb();
    		$conex->beginTransaction();

    		try {
    			$conex->query("INSERT INTO Evento(nombre, presupuesto, creador) VALUES('$nombre', '$presupuesto', '$creador')");
    			$conex->query("INSERT INTO Pertenencia(usuario, evento) VALUES ('$creador', (SELECT MAX(id_evento) FROM Evento WHERE creador='$creador'))");
    			$conex->commit();
    			
    			return true;

    		} catch(Exception $e){
    			$conex->rollBack();
    			return false;
    		}
    	}

    	public static function insertPertMult($usuarios){

    		$conex = Database::getInstance()->getDb();
    		$conex->beginTransaction();
    		try {
    			for($i=1; $i<count($usuarios); $i++){
    				$conex->query("INSERT INTO Pertenencia(usuario, evento) VALUES('$usuarios[$i]','$usuarios[0]')");
    			}
    			$conex->commit();
    			return true;

    		} catch(Exception $e){
    			$conex->rollBack();
    			return false;
    		}
    	}

    	public static function getEventos($id_usuario){
    		$Num_regalos = "Num_regalos";
    		$Regalos_comp = "Regalos_comp";

    		$consulta = "SELECT id_evento, Evento.nombre, presupuesto, creador,
				COUNT(Regalo.id_regalo) as $Num_regalos,
				COUNT(Regalo.comprador) as $Regalos_comp 
				FROM Pertenencia INNER JOIN Evento ON Pertenencia.evento=Evento.id_evento
				LEFT JOIN Regalo ON Evento.id_evento=Regalo.evento
				WHERE Pertenencia.usuario=?
				GROUP BY Evento.id_evento";

    		try{
    			$resultado = Database::getInstance()->getDb()->prepare($consulta);
    			$resultado->execute(array($id_usuario));

    			$datos = $resultado->fetchAll(PDO::FETCH_ASSOC);

    			return $datos;
    		} catch (PDOException $e){
    			return false;
    		}
    	}

    	public static function deleteEventos($id_evento){
    		try{
    			$consulta = "DELETE FROM Evento WHERE Evento.id_evento=?";
    			$resultado = Database::getInstance()->getDb()->prepare($consulta);

    			return $resultado->execute(array($id_evento));
    		
    		}catch(PDOException $e){
    			return false;
    		}
    	}

    	public static function getUsersPertenencia($evento, $usuario){
    		$consulta = "SELECT usuario FROM Pertenencia WHERE Pertenencia.evento=? AND Pertenencia.usuario NOT IN (?)";
    		try{
    			$resultado = Database::getInstance()->getDb()->prepare($consulta);
    			$resultado->execute(array($evento, $usuario));

    			$datos = $resultado->fetchAll(PDO::FETCH_ASSOC);

    			return $datos;
    		} catch(PDOException $e){
    			return false;
    		}
    	}
	}
?>
