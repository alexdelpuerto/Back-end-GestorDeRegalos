<?php
	require 'Database.php';

	class Regalos{

		function _construct(){}

		public static function getRegalos($id_evento){
    		$consulta = "SELECT id_regalo, nombre, descripcion, foto, precio, comprado, evento, comprador FROM Regalo WHERE Regalo.evento=?";
    		try{
    			$resultado = Database::getInstance()->getDb()->prepare($consulta);
    			$resultado->execute(array($id_evento));

    			$datos = $resultado->fetchAll(PDO::FETCH_ASSOC);

    			return $datos;
    		} catch (PDOException $e){
    			return false;
    		}
    	}

    	public static function deleteRegalos($id_regalo){
            $consulta = "DELETE FROM Regalo WHERE Regalo.id_regalo=?";
    		try{
    			$resultado = Database::getInstance()->getDb()->prepare($consulta);

    			return $resultado->execute(array($id_regalo));
    		
    		}catch(PDOException $e){
    			return false;
    		}
    	}

        public static function comprarRegalos($usuarios){
            $pago;
            $conex = Database::getInstance()->getDb();
            $conex->beginTransaction();
            try {

                $conex->query("UPDATE Regalo SET comprado=1, comprador='$usuarios[2]' WHERE id_regalo='$usuarios[0]'");

                for($i=3; $i<count($usuarios); $i++){

                    $conex->query("INSERT INTO Participa(usuario, evento, regalo) VALUES('$usuarios[$i]','$usuarios[1]', '$usuarios[0]')");
                }

                $conex->commit();
                return true;

            } catch(Exception $e){
                $conex->rollBack();
                return false;
            }
        }

        public static function getDeben($id_usuario){
            $Nom_regalo = "Nom_regalo";
            $Num_usuarios = "Num_usuarios";
            $consulta = "SELECT Participa.usuario, nombre as $Nom_regalo, precio, id_regalo,
            COUNT(Pertenencia.usuario) as $Num_usuarios
            FROM Regalo RIGHT JOIN Participa ON Regalo.id_regalo=Participa.regalo
            INNER JOIN Pertenencia ON Participa.evento=Pertenencia.evento
            WHERE Participa.usuario<>comprador AND regalo IN(SELECT id_regalo FROM Regalo WHERE comprador=?)
            GROUP BY Participa.usuario, Participa.evento, regalo";

            try{
                $resultado = Database::getInstance()->getDb()->prepare($consulta);
                $resultado->execute(array($id_usuario));

                $datos = $resultado->fetchAll(PDO::FETCH_ASSOC);
                return $datos;

            } catch(PDOException $e){
                return false;
            }
        }

        public static function getDebes($id_usuario){
            $Nom_regalo = "Nom_regalo";
            $Num_usuarios = "Num_usuarios";
            $consulta = "SELECT nombre as $Nom_regalo, precio, comprador,
            COUNT(Pertenencia.usuario) as $Num_usuarios
            FROM Regalo RIGHT JOIN Participa ON Regalo.id_regalo=Participa.regalo
            INNER JOIN Pertenencia ON Participa.evento=Pertenencia.evento
            WHERE Participa.usuario<>comprador AND Participa.usuario=?
            GROUP BY Participa.usuario, Participa.evento, regalo";

            try{
                $resultado = Database::getInstance()->getDb()->prepare($consulta);
                $resultado->execute(array($id_usuario));

                $datos = $resultado->fetchAll(PDO::FETCH_ASSOC);
                return $datos;

            } catch(PDOException $e){
                return false;
            }
        }

        public static function deletePago($id_regalo, $id_usuario){
            $consulta = "DELETE FROM Participa WHERE regalo=? AND usuario=?";
            try{
                $resultado = Database::getInstance()->getDb()->prepare($consulta);

                return $resultado->execute(array($id_regalo, $id_usuario));
            
            }catch(PDOException $e){
                return false;
            }
        }

        public static function insertRegalo($nombre, $descripcion, $foto, $precio, $evento){
            $consulta = "INSERT INTO Regalo(nombre, descripcion, foto, precio, comprado, evento, comprador) VALUES (?, ?, ?, ?, 0, ?, NULL)";
            try {
                $resultado = Database::getInstance()->getDb()->prepare($consulta);

                return $resultado->execute(array($nombre, $descripcion, $foto, $precio, $evento));

            } catch (PDOException $e) {
                return false;
            }
        }
	}

?>