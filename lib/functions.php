<?php

	/**
	 * [conexion description]
	 * Conexion a base de datos MongoDB
	 * @return conexion
	 */
	function conexion(){
		$mongo =  new MongoClient(); //Crear objeto DB
		$db = $mongo->keeprunning; // Seleccion de base de datos
		return $db; 
	}


	/**
	 * [insertarUsuario description]
	 * Guardar Usuario en MongoDB
	 * @param  json $documento objeto que se almacena
	 * @return boolean		   parametro para saber si se ha realizado con exito
	 */
	function insertarUsuario($documento){
		try{
			$mongo = conexion();
			$coleccion = $mongo->usuarios; // Decimos a que tabla queremos acceder
			$coleccion->insert($documento);
			return true;
		}catch(MongoCursorException $e){
			return false;
		}		
	}


	/**
	 * [mostrarDatos description]
	 * [TEST]
	 * @return [type] [description]
	 */
	function mostrarDatos(){
		$mongo = conexion(); //Recibo la conexion
		$coleccion = $mongo->usuarios; //Establezco con que tabla quiero trabajar
		$cursor = $coleccion->find();
		foreach($cursor as $documento){
			echo "ID Usuario: " .$documento["_id"]." Nombre: ". $documento["nombre"]." <br>";
		}
	}



	/** [ FUNCIONES PARA PROXIMAS CARERAS y SINGLE ] **/

	/**
	 * [proximasCarreras description]
	 * Obtener todos los datos de las carreras que existen el sistema actualmente
	 * @return json 
	 */
	function proximasCarreras(){
		// Funcion que recoge el nombre la imagen de portada y el id de las carreras
		$mongo = conexion(); //Recibo la conexion
		$coleccion = $mongo->carreras; //Establezco con que tabla quiero trabajar
		$cursor = $coleccion->find();
		$json = [];
		$objeto = [];
		foreach($cursor as $documento){
			$objeto['id']           = (string)$documento['_id']; 
			$objeto['nombre']       = $documento["edicion"]." ".$documento["nombre"];
			$objeto['imagenCartel'] = $documento["imagenCartel"]; 
			$json[]                 = $objeto;
		}
		return $json;
	}


	/**
	 * [datosCarreraUnica description]
	 * Obtener objeto json con los datos de cada carrera
	 * @param  entero $identificador
	 * @return json                
	 */	
	function datosCarreraUnica($identificador){ 
		$mongo = conexion(); 
		$coleccion = $mongo->carreras;		
		//$fruitQuery = array("_id" => "551c5430d0d795443a42a2d8"); //Query
		//$identificador = "551c5430d0d795443a42a2d8";
		$item = $coleccion ->find(array('_id' => new MongoId($identificador)));
		$json = [];
		$objeto = [];
		foreach($item as $documento){
			$objeto['nombre']         = $documento['nombre'];
			$objeto['edicion']        = $documento['edicion'];
			$objeto['fecha']          = $documento['fecha'];
			$objeto['hora']           = $documento['hora'];
			$objeto['descripcion']    = $documento['descripcion'];
			$objeto['localizacion']   = $documento['localizacion'];
			$objeto['contactoEmail']  = $documento['contactoEmail'];
			$objeto['contactoTelef']  = $documento['contactoTelef'];
			$objeto['imagenCabecera'] = $documento['imagenCabecera'];
			$objeto['imagenCartel']   = $documento['imagenCartel'];
			$json[]                   = $objeto;
		}
		return $json;
	}





?>