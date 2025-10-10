<?php 

	class Dashboard extends Controllers{
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

		public function dashboard()
		{	
			if(empty($_SESSION['permisosMod']['r'])){
				header("Location:".base_url().'/home');
			}
			$data['page_id'] = 2;
			$data['page_tag'] = "Dashboard";
			$data['page_title'] = "Administración de Dashboard";
			$data['page_name'] = "dashboard";
			$data['page_functions_js'] = "functions_dashboard.js";
			$this->views->getView($this,"dashboard",$data);
		}

		public function duplicateDashboard()
		{
			if($_POST){
				$idDashboardClonar = intval($_POST['idDashboardClonar']);
				$descripcionClonar = $_POST['descripcionClonar'];
				$baseDeDatosClonar = $_POST['baseDeDatosClonar'];
				$credencialesConex = $_POST['servidorClonar'];
				$tipoClonacion = $_POST['tipoClonacion'];

				$dbCredentials = explode(',', $credencialesConex);

				$newhost = $dbCredentials[0] ?? null;
				$newdatabase = $dbCredentials[1] ?? null;
				$newusername = $dbCredentials[2] ?? null;
				$newpassword = $dbCredentials[3] ?? null;

				if($tipoClonacion == 1){
					$requestInsert = $this->model->insertDuplicateServidorKpi($idDashboardClonar, $descripcionClonar, $baseDeDatosClonar, $newhost, $newdatabase, $newusername, $newpassword);
				}else{
					$requestInsert = $this->model->insertDuplicateKpi($idDashboardClonar, $descripcionClonar, $baseDeDatosClonar);
				}

				if($requestInsert > 0)
				{
					$arrResponse = array('status' => true, 'msg' => 'El Dashboard se ha clonado de manera exitosa');
				}else{
					$arrResponse = array('status' => false, 'msg' => 'Error al Duplicar Dashboard.');
				}

				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function setDashboard()
		{
			if($_POST){

				$descripcion = $_POST['descripcion'];
				$baseDeDatos = $_POST['baseDeDatos'];

				$requestInsert = $this->model->insertDashboard($descripcion, $baseDeDatos);

				if($requestInsert > 0)
				{
					$arrResponse = array('status' => true, 'msg' => 'Dashboard creado!');
				}else{
					$arrResponse = array('status' => false, 'msg' => 'Error al Crear Dashboard.');
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function getDashboards()
		{
			if($_SESSION['permisosMod']['r']){
				$arrData = $this->model->selectDashboards();
				for ($i=0; $i < count($arrData); $i++) {
					$btnEdit = '';

					if($_SESSION['permisosMod']['u']){
						
						$btnEdit = '<button class="btn text-info mb-0 p-1" onClick="openModalClonar('.$arrData[$i]['ID_DASHBOARD'].')">Clonar <i class="fas fa-clone"></i></button>';
					}else{
						$btnEdit = '<button class="btn btn-info" disabled style="cursor:not-allowed;"><i class="fas fa-clone"></i></button>';
					}

					$arrData[$i]['options'] = '<div class="text-center">'.$btnEdit.'</div>';
				}
				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function getDashboard($dashboard){
			if($_SESSION['permisosMod']['r']){
				$iDashboard = intval($dashboard);
				if($iDashboard > 0)
				{
					$arrData = $this->model->selectDashboard($iDashboard);
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

		

		public function delDashboard(){

			if($_POST){
				if($_SESSION['permisosMod']['d']){
					$intIdDashboard = intval($_POST['idDashboard']);
					$requestDeleteDashboardKpi = $this->model->deleteDashboardsKpi($intIdDashboard);
					$requestDeleteDashboard = $this->model->deleteDashboard($intIdDashboard);

					if($requestDeleteDashboard && $requestDeleteDashboardKpi)
					{
						$arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el dashboard.');
					}else{
						$arrResponse = array('status' => false, 'msg' => 'Error al eliminar el dashboard.');
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}




		public function getDashboardKpi(int $dashboard)
		{
			$iDashboard = intval($dashboard);
			$arrData = array('iDashboard' => $iDashboard);
			if($iDashboard > 0)
			{
				
				$arrAllkpiDashboard = $this->model->selectAllkpisDashboard();
				$arrkpisDashboard = $this->model->selectkpisDashboard($iDashboard);

				$arrAllkpiDashboardcolumn = array_column($arrAllkpiDashboard, 'ID_KPI');
				$arrkpisDashboardcolumn =  array_column($arrkpisDashboard, 'ID_KPI');
			
				foreach($arrAllkpiDashboardcolumn as $key => $value){
					if(in_array($value, $arrkpisDashboardcolumn)){

						$arrAllkpiDashboard[$key]['CHECKED'] = 'YES';
					}
				}

				$arrData['ID_KPI'] = $arrAllkpiDashboard;
				//dep($arrData);
				$html = getModal("modalDashboardKpi",$arrData);

			}
			die();
		}

		public function setDashboardKpi()
		{
			if ($_POST) {

				$iDashboard = $_POST['idDashboard'];
				$arrkpi = empty($_POST['kpi'])?array():$_POST['kpi'];
				
				if(empty($arrkpi)){
					$requestDeleteDashboard = $this->model->deleteDashboard($iDashboard);
					$arrResponse = array('status' => true, 'msg' => 'Dashboard modificado!');
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
					die();
				}

				$requestDeleteDashboard = $this->model->deleteDashboard($iDashboard);

				$insert = "INSERT INTO dashboard (ID_DASHBOARD, ID_KPI, DESCRI) VALUES";
					
					for ($i=0; $i < count($arrkpi) ; $i++) { 
						$insert = $insert. '('.$iDashboard.','.$arrkpi[$i].',"" )';
					
						if ($i < (count($arrkpi))-1) {
							$insert = $insert . ",";
						}
					}
					//echo $insert;die();
					$requestInsert = $this->model->insertDashboard($insert);

					if($requestInsert > 0)
					{
						$arrResponse = array('status' => true, 'msg' => 'Dashboard modificado!');
					}else{
						$arrResponse = array('status' => false, 'msg' => 'Error al modificar Dashboard.');
					}

				}else{
					$arrResponse = array('status' => false, 'msg' => 'Error en el proceso.');
				}	

				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			die();	
		}
	}
 ?>