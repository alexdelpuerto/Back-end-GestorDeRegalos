<?php 
 
 	require 'Regalos.php';

 	$Nombre_Archivo = 'file';
 	$Carpeta = "/Fotos/";
 	$URL = "https://alexregalos.000webhostapp.com";

 	if($_SERVER['REQUEST_METHOD']=='POST'){
 		$nombre = $_POST['nombre'];
 		$descripcion = $_POST['descripcion'];
 		$precio = $_POST['precio'];
 		$evento = $_POST['evento'];
 		if(isset($_FILES[$Nombre_Archivo])){
 			//Si existe el Archivo, se obtiene
	 		$file = $_FILES[$Nombre_Archivo];

	 		//Propiedades: Nombre, ubicacion, tamaño, error
	 		$file_name = $file['name'];
	 		$file_tmp = $file['tmp_name'];
	 		$file_size = $file['size'];
	 		$file_error = $file['error'];

	 		//Extension del archivo
	 		$file_ext = explode('.',$file_name);
			$file_ext = strtolower(end($file_ext));

			//Extensiones permitidas
			$permitir = array('png','jpg');

			//Comprobar extensiones permitidas
			if(in_array($file_ext,$permitir)){
				//Comprobar errores
				if($file_error===0){
					//Maximo tamaño de imagenes 5 Mb
					if($file_size<=5242880){
						//Se le da un nombre único a cada imagen, para que no haya error cuando dos usuarios suban una foto con el mismo nombre
						$file_name_new = uniqid('',true).'.'.$file_ext;
						$file_destino = $_SERVER['DOCUMENT_ROOT'].$Carpeta.$file_name_new;
						try{
							if(move_uploaded_file($file_tmp,$file_destino)){
								$URL_FOTO = $URL.$Carpeta.$file_name_new;
								Regalos::insertRegalo($nombre, $descripcion, $URL_FOTO, $precio, $evento);
								echo json_encode(array('respuesta'=>"OK",'estado'=>"Imagen subida correctamente"));
							}else{
								echo json_encode(array('respuesta'=>"-1",'estado'=>"Error al subir la imagen"));
							}
						}catch(PDOException $e){
							echo json_encode(array('respuesta'=>"-1",'estado'=>"Error: "+$e->getMessage()));
						}
					}else{
						echo json_encode(array('respuesta'=>"-1",'estado'=>"Error: Supera el tamanio maximo, limite de 5Mb"));
					}
				}else{
					echo json_encode(array('respuesta'=>"-1",'estado'=>"Error: Archivo no valido"));
				}
			}else{
				echo json_encode(array('respuesta'=>"-1",'estado'=>"Error: El archivo no es compatible"));
			}

	 	}
 	}

?>