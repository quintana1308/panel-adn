<?php 

	class Usuarios extends Controllers{
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

		public function usuarios()
		{	
			if(empty($_SESSION['permisosMod']['r'])){
				header("Location:".base_url().'/home');
			}
			$data['page_tag'] = "Usuarios";
			$data['page_title'] = "USUARIOS ";
			$data['page_name'] = "usuarios";
			$data['page_functions_js'] = "functions_usuarios.js";
			$this->views->getView($this,"usuarios",$data);
		}

		public function setUsuario(){
			if($_POST){	

				$descripcion = strClean($_POST['descripcion']);
				$username = strClean($_POST['username']);
				$idEnterprise = intval(strClean($_POST['idEnterprise']));
				$Dashboard = $_POST['idDashboard'];
				if(empty($_POST['userToken'])){
					$userToken = '';
				}else{
					$userToken = strClean($_POST['userToken']);
				}
				if(empty($_POST['urlWebView'])){
					$urlWebView = '';
				}else{
					$urlWebView = strClean($_POST['urlWebView']);
				}

				$strPassword =  empty($_POST['password']) ? hash("SHA256",passGenerator()) : hash("SHA256",$_POST['password']);
				$request_user = "";

				$request_user = $this->model->insertUsuario($descripcion, 
															$username,
															$strPassword, 
															$idEnterprise,
															$Dashboard, 
															$userToken,
															$urlWebView);
				
				if($request_user > 0 )
				{
					$arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
				}else if($request_user == 'exist'){
					$arrResponse = array('status' => false, 'msg' => '¡Atención! el username ya existe para este dashboard!.');		
				}else{
					$arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
				}
			
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function getUsuarios()
		{	

			if($_SESSION['permisosMod']['r']){
				$arrData = $this->model->selectUsuarios();

				for ($i=0; $i < count($arrData); $i++) {
					$btnView = '';
					$btnEdit = '';
					$btnDelete = '';

					/*if($_SESSION['permisosMod']['r']){
						$btnView = '<button class="btn btn-default btn-sm btnViewUsuario" onClick="fntViewUsuario('.$arrData[$i]['ID'].')" title="Ver usuario"><i class="far fa-eye"></i></button>';
					}*/

					if($_SESSION['permisosMod']['u']){
						$btnEdit = '<button class="btn text-info p-0 me-2 mb-0" onClick="fntEditUsuario(this,'.$arrData[$i]['ID'].')" title="Editar usuario"><i class="fas fa-pencil-alt"></i></button>';
					}

					if($_SESSION['permisosMod']['d']){
						if($arrData[$i]['STATUS'] == 1)
						{
							$btnDelete = '<button class="btn text-danger p-0 mb-0" onClick="fntDelUsuario('.$arrData[$i]['ID'].')" title="Desactivar usuario"><i class="fa-solid fa-ban"></i></button>';
						}else{
							$btnDelete = '<button class="btn text-success p-0 mb-0" onClick="fntDelUsuario('.$arrData[$i]['ID'].')" title="Activar usuario"><i class="fa-regular fa-circle-check"></i></button>';
						}
					}

					if($arrData[$i]['STATUS'] == 1)
					{
						$arrData[$i]['STATUS'] = '<span class="badge badge-success text-success">Activo</span>';
					}else{
						$arrData[$i]['STATUS'] = '<span class="badge badge-danger text-danger">Inactivo</span>';
					}

					$arrData[$i]['options'] = '<div class="text-center">'.$btnEdit.' '.$btnDelete.'</div>';
				}
				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function getSelect($idpersona)
		{	
			$arrData['Dashboard'] = $this->model->selectDashboardUser($idpersona);
			$arrData['Enterprise'] = $this->model->selectEnterpriseUser();
			echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			die();
		}

		public function getSelectNew()
		{	
			$arrData['Dashboard'] = $this->model->selectDashboard();
			$arrData['Enterprise'] = $this->model->selectEnterpriseUser();
			echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			die();
		}

		public function getUsuario($idpersona){
			if($_SESSION['permisosMod']['r']){
				$idusuario = intval($idpersona);
				if($idusuario > 0)
				{
					$arrData['dataUsuario'] = $this->model->selectUsuario($idusuario);
					$arrData['dataDashboard'] = $this->model->selectDashboard();
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

		public function delUsuario()
		{
			if($_POST){
				if($_SESSION['permisosMod']['d']){
					$intIdpersona = intval($_POST['idUsuario']);
					$requestDelete = $this->model->deleteUsuario($intIdpersona);
					if($requestDelete > 0)
					{
						$arrResponse = array('status' => true, 'msg' => 'Se ha actualizado el estado del usuario');
					}else{
						$arrResponse = array('status' => false, 'msg' => 'Error al cambiar el estado del usuario.');
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}

		public function perfil(){
			$data['page_tag'] = "Perfil";
			$data['page_title'] = "Perfil de usuario";
			$data['page_name'] = "perfil";
			$data['page_functions_js'] = "functions_usuarios.js";
			$data['dataUsuario'] = $this->model->selectUsuario($_SESSION['idUser']);
			$this->views->getView($this,"perfil",$data);
		}

		public function putDUser(){
			if($_POST){
				if(empty($_POST['intDashboard']))
				{
					$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
				}else{

					
					$idUsuario = $_SESSION['idUser'];
					$intDashboard = intval($_POST['intDashboard']);
					$strPassword = "";
					if(!empty($_POST['txtPassword'])){
						$strPassword = hash("SHA256",$_POST['txtPassword']);
					}
					$request_user = $this->model->updateDUser($idUsuario, 
																$intDashboard,
																$strPassword);
					if($request_user)
					{
						sessionUser($_SESSION['idUser']);
						
						$arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
					}else{
						$arrResponse = array("status" => false, "msg" => 'No es posible actualizar los datos.');
					}
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function putUserData(){
			if($_POST){

				$idUsuario = intval($_POST['idUsuarioEdit']);
				$Descripcion = $_POST['descripcionEdit'];
				$Username = $_POST['usernameEdit'];
				$Enterprise = intval($_POST['idEnterpriseEdit']);
				$Dashboard = $_POST['idDashboardEdit'];
				$TokenUser = $_POST['userTokenEdit'];
				$urlWebView = $_POST['urlWebViewEdit'];

				$strPassword = "";
				if(!empty($_POST['passwordEdit'])){
					$strPassword = hash("SHA256",$_POST['passwordEdit']);
				}
				$request_user = $this->model->updateDUserData($idUsuario, 
															$Descripcion,
															$Username,
															$Enterprise,
															$Dashboard,
															$TokenUser,
															$strPassword,
															$urlWebView);
				if($request_user)
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