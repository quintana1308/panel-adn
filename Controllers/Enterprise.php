<?php 

	class Enterprise extends Controllers{
		public function __construct()
		{
			parent::__construct();
			session_start();
			//session_regenerate_id(true);
			if(empty($_SESSION['login']))
			{
				header('Location: '.base_url().'/login');
			}
			 getPermisos(1);
		}

		public function enterprise()
		{	
			if(empty($_SESSION['permisosMod']['r'])){
				header("Location:".base_url().'/home');
			}
			$data['page_tag'] = "Empresas";
			$data['page_title'] = "Empresas";
			$data['page_name'] = "empresas";
			$data['page_functions_js'] = "functions_enterprise.js";
			$this->views->getView($this,"enterprise",$data);
		}

		public function setEnterprise(){
			if($_POST){	

				$token = $_POST['token'];
				$bd = $_POST['bd'];
				$rif = $_POST['rif'];
				$nombre = $_POST['nombre'];
                $urlpanel = $_POST['urlpanel'];
                $tokenpanel = $_POST['tokenpanel'];
				$bdSincro = $_POST['bdSincro'];

				$request = "";

				$request = $this->model->insertEnterprise($token, 
															$bd,
															$rif, 
															$nombre,
															$bdSincro,
															$urlpanel,
															$tokenpanel);
				
				if($request > 0 )
				{
					$arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
				}else{
					$arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
				}
			
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function getEnterprises()
		{	 
			if($_SESSION['permisosMod']['r']){
				$arrData = $this->model->selectEnterprises();

				for ($i=0; $i < count($arrData); $i++) {
					$btnView = '';
					$btnEdit = '';
					$btnDelete = '';

					if($_SESSION['permisosMod']['u']){
						$btnEdit = '<button class="btn text-info p-0 me-2 mb-0" onClick="fntEditEnterprise(this,'.$arrData[$i]['ID'].')" title="Editar empresa"><i class="fas fa-pencil-alt"></i></button>';
					}

					if($_SESSION['permisosMod']['d']){
						$btnDelete = '<button class="btn text-danger p-0 mb-0" onClick="fntDelEnterprise('.$arrData[$i]['ID'].')" title="Eliminar empresa"><i class="fa-solid fa-trash"></i></button>';
					}

					$arrData[$i]['options'] = '<div class="text-center">'.$btnEdit.' '.$btnDelete.'</div>';
				}

				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function getSelect()
		{	
			$arrData['Dashboard'] = $this->model->selectDashboardUser();
			$arrData['Enterprise'] = $this->model->selectEnterpriseUser();
			echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			die();
		}

		public function getEnterprise($idEmpresa){
			if($_SESSION['permisosMod']['r']){
				$idEnterprise = intval($idEmpresa);
				if($idEnterprise > 0)
				{	
					$arrData = $this->model->selectEnterprise($idEnterprise);

					if(empty($arrData))
					{
						$arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
					}else{
						$arrResponse = array('status' => true, 'data' => $arrData);
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}

		public function delEnterprise()
		{
			if($_POST){
				if($_SESSION['permisosMod']['d']){
					$idEnterprise = intval($_POST['idEnterprise']);
					$requestDelete = $this->model->deleteEnterprise($idEnterprise);
					if($requestDelete > 0)
					{
						$arrResponse = array('status' => true, 'msg' => 'Se ha eliminado la empresa');
					}else{
						$arrResponse = array('status' => false, 'msg' => 'Error al eliminar la empresa.');
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}

		public function putEnterpriseData(){
			if($_POST){

				$idEnterprise = $_POST['idEnterpriseEdit'];
				$token = $_POST['tokenEdit'];
				$bd = $_POST['bdEdit'];
				$rif = $_POST['rifEdit'];
				$nombre = $_POST['nombreEdit'];
				$tokenpanel = $_POST['tokenpanelEdit'];
				$urlpanel = $_POST['urlpanelEdit'];
				$bdSincro = $_POST['bdSincroEdit'];

				$request = $this->model->updateDEnterpriseData($idEnterprise, 
																	$token,
																	$bd,
																	$rif,
																	$nombre,
																	$bdSincro,
																	$tokenpanel,
																	$urlpanel);
				if($request)
				{					
					$arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
				}else{
					$arrResponse = array("status" => false, "msg" => 'No es posible actualizar los datos.');
				}
				
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}


	}
 ?>