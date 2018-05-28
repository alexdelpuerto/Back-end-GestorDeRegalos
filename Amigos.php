<?php
	require 'Database.php';

	class Amigos{

		function _construct(){}


		public static function getAmigos($id_usuario){
    		$consulta = "SELECT id_usuario, nombre, apellidos, imagen FROM Usuario INNER JOIN Amigo WHERE Usuario.id_usuario=Amigo.amigo2 AND Amigo.amigo1=? AND Amigo.aceptado=1";
    		try{
    			$resultado = Database::getInstance()->getDb()->prepare($consulta);
    			$resultado->execute(array($id_usuario));

    			$datos = $resultado->fetchAll(PDO::FETCH_ASSOC);

    			return $datos;
    		} catch (PDOException $e){
    			return false;
    		}
    	}

        public static function getAmigosAgregar($id_usuario, $id_evento){
            $consulta = "SELECT id_usuario, nombre, apellidos, imagen FROM Usuario INNER JOIN Amigo WHERE Usuario.id_usuario=Amigo.amigo2 AND Amigo.amigo1=? AND Amigo.aceptado=1 
                        AND Usuario.id_usuario NOT IN (SELECT usuario FROM Pertenencia WHERE evento=?)";
            try{
                $resultado = Database::getInstance()->getDb()->prepare($consulta);
                $resultado->execute(array($id_usuario, $id_evento));

                $datos = $resultado->fetchAll(PDO::FETCH_ASSOC);

                return $datos;
            } catch (PDOException $e){
                return false;
            }
        }

        public static function crearSolicitud($amigo1, $amigo2, $aceptado){
            $consulta = "INSERT INTO Amigo(amigo1, amigo2, aceptado) VALUES (?, ?, ?)";
            try{
                $resultado = Database::getInstance()->getDb()->prepare($consulta);
                return $resultado->execute(array($amigo1, $amigo2, $aceptado));

            }catch(PDOException $e){
                return false;
            }
        }

        public static function getSolicitudes($amigo2){
            $consulta = "SELECT amigo1, imagen FROM Amigo INNER JOIN Usuario ON Amigo.amigo1=Usuario.id_usuario WHERE Amigo.amigo2=? AND Amigo.aceptado=0";
            try{
                $resultado = Database::getInstance()->getDb()->prepare($consulta);
                $resultado->execute(array($amigo2));

                $datos = $resultado->fetchAll(PDO::FETCH_ASSOC);
                return $datos;

            }catch(PDOException $e){
                return false;
            }
        }

        public static function aceptarSolicitud($amigo1, $amigo2){
            $consulta = "UPDATE Amigo SET aceptado=1 WHERE Amigo.amigo1=? AND Amigo.amigo2=?";

            $resultado = Database::getInstance()->getDb()->prepare($consulta);
            return $resultado->execute(array($amigo1, $amigo2));
        }

        public static function cancelarSolicitud($amigo1, $amigo2){
            try{
                $consulta = "DELETE FROM Amigo WHERE Amigo.amigo1=? AND Amigo.amigo2=?";

                $resultado = Database::getInstance()->getDb()->prepare($consulta);
                return $resultado->execute(array($amigo1, $amigo2));

            }catch(PDOException $e){
                return false;
            }
        }
        //Es igual que la de Login pero la necesito tambien aqui
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

        public static function enviarNotificacion($token, $usuario_emisor, $cuerpo){
            ignore_user_abort();
            ob_start();

            $url = 'https://fcm.googleapis.com/fcm/send';

            $fields = array('to' => $token ,
             'data' => array('cabecera' => 'Solicitud de Amistad', 'cuerpo' => $usuario_emisor.$cuerpo));

            define('GOOGLE_API_KEY', 'AIzaSyBE7xacTmZ7gl1mPxYQtW0J3nWoBqik8z4');

            $headers = array(
                'Authorization:key='.GOOGLE_API_KEY,
                'Content-Type: application/json'
            );      

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

            $result = curl_exec($ch);
            if($result === false)
              die('Curl failed ' . curl_error());
            curl_close($ch);
            return $result;
        }
	}

?>