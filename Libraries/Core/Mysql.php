<?php 
	
	class Mysql extends Conexion
	{
		private $conexion;
		private $strquery;
		private $arrValues;

		function __construct()
		{
			$conexionInstance = Conexion::getInstance();
			$this->conexion = $conexionInstance->conect();

			$sql_mode = $this->conexion->prepare("SET sql_mode = ''");
			$sql_mode->execute();
			$sql_mode->closeCursor();
			
			$set_session = $this->conexion->prepare("SET SESSION group_concat_max_len = 1000000");
            $set_session->execute();
			$set_session->closeCursor();
		}

		//Insertar un registro
		public function insert(string $query, array $arrValues)
		{
			$this->strquery = $query;
			$this->arrVAlues = $arrValues;
        	$insert = $this->conexion->prepare($this->strquery);
        	$resInsert = $insert->execute($this->arrVAlues);
        	if($resInsert)
	        {
	        	$lastInsert = 1;
	        }else{
	        	$lastInsert = 0;
	        }
			$insert->closeCursor();
	        return $lastInsert; 
		}

		public function insert_Id(string $query, array $arrValues)
		{
			$this->strquery = $query;
			$this->arrVAlues = $arrValues;
        	$insert = $this->conexion->prepare($this->strquery);
        	$resInsert = $insert->execute($this->arrVAlues);
        	if($resInsert)
	        {
	        	$lastInsertId = $this->conexion->lastInsertId();
				$insert->closeCursor();
        		return $lastInsertId; 
	        }else{
	        	$lastInsert = 0;
	        }
			$insert->closeCursor();
	        return $lastInsert; 
		}
		
		//Insertar varios registors
		public function insert_massive(string $query){
			$this->strquery = $query;
			$insert = $this->conexion->prepare($this->strquery);
			$insert->execute();
			if($insert)
	        {
	        	$lastInsert = 1;
	        }else{
	        	$lastInsert = 0;
	        }
			$insert->closeCursor();
	        return $lastInsert; 
		}
		//Busca un registro
		public function select(string $query)
		{
			try {
				$this->strquery = $query;
				$result = $this->conexion->prepare($this->strquery);
				$result->execute();
				$data = $result->fetch(PDO::FETCH_ASSOC);
				$result->closeCursor();

				return $data;
				
			} catch (\Throwable $th) {
				if(isset($_GET['debug'])){
					echo $th;
					throw $th;
				}
			}
		}
		//Devuelve todos los registros
		public function select_all(string $query)
		{
			$this->strquery = $query;
			try {
				
				$result = $this->conexion->prepare($this->strquery);
				$result->execute();
	        	$data = $result->fetchall(PDO::FETCH_ASSOC);
				$result->closeCursor();
	        	return $data;

			} catch (Exception $e) {
				
				if ($_GET['debug'] == 1) {
					echo 'CHECK THIS QUERY: '. $this->strquery. '</br></br>';
					echo $e;
				}	
				
			}	
        	
		}
		//Actualiza registros
		public function update(string $query, array $arrValues)
		{
			$this->strquery = $query;
			$this->arrVAlues = $arrValues;
			$update = $this->conexion->prepare($this->strquery);
			$resExecute = $update->execute($this->arrVAlues);
			$update->closeCursor();
	        return $resExecute;
		}
		//actualizar varios registors
		public function update_massive(string $query){
			$this->strquery = $query;
			$update = $this->conexion->prepare($this->strquery);
			$resExecute = $update->execute();
			$update->closeCursor();
	        return $resExecute; 
		}
		//Eliminar un registros
		public function delete(string $query)
		{
			$this->strquery = $query;
        	$result = $this->conexion->prepare($this->strquery);
			$del = $result->execute();
			$result->closeCursor();
        	return $del;
		}

		public function closeConnection()
		{
			if($this->conexion !== null) {
				$this->conexion = null;
			}
			// Cerrar la instancia singleton de conexión si existe
			if(class_exists('Conexion')) {
				$conexionInstance = Conexion::getInstance();
				if($conexionInstance->isConnected()) {
					$conexionInstance->closeConnection();
				}
			}
		}

		public function __destruct()
		{
			$this->conexion = null;
		}
	}


 ?>
