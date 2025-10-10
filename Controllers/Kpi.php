<?php 

class Kpi extends Controllers{
	public function __construct()
	{
		parent::__construct();
		session_start();
		//session_regenerate_id(true);
		if(empty($_SESSION['login']))
		{
			header('Location: '.base_url().'/login');
		}
		getPermisos(4);

	}

	public function kpi()
	{
		if(empty($_SESSION['permisosMod']['r'])){
				header("Location:".base_url().'/home');
			}
		$data['page_id'] = 4;
		$data['page_tag'] = "Administración Kpi";
		$data['page_title'] = "Administración Kpi";
		$data['page_name'] = "kpi";
		$data['page_functions_js'] = "functions_kpi.js";
		$this->views->getView($this,"kpi",$data);
		
	}

	public function setKpi(){

			if($_POST){	 
					$idKpi = intval($_POST['id']);
					$idKpiDD = intval($_POST['intIdKpiDD']);
					$idKpiPadre = intval($_POST['intIdKpiPadre']);
					$strLabel = strClean($_POST['txtLabel']);
					$strDescription = strClean($_POST['txtDescription']);
					$strSqlValue = strClean($_POST['txtSqlValue']);
					$strSqltabla = strClean($_POST['txtSqlTabla']);
					$intOculto = intval(strClean($_POST['intOculto']));
					$intTotalizar = strClean($_POST['txtTotalizar']);
					$strIcon = ($_POST['txtIcon']);
					$intModulo = intval(strClean($_POST['intModulo']));
					$intPosicion = intval(strClean($_POST['intPosicion']));
					$intGraficaPrincipal = intval(strClean($_POST['intGraficaPrincipal']));
					$intIdGrafica = intval(strClean($_POST['listIdGrafica']));
					$strParam1 = strClean($_POST['txtParam1']);
					$strParam2 = strClean($_POST['txtParam2']);
					$strParam3 = strClean($_POST['txtParam3']);
					$strParam4 = strClean($_POST['txtParam4']);
					$strParam5 = strClean($_POST['txtParam5']);
					$strUpd = strClean($_POST['txtUpd']) == ''?"select ''":strClean($_POST['txtUpd']);

					
					if($idKpi == 0){
						
						$option = 1;
					
						if($_SESSION['permisosMod']['w']){
							$request_kpi = $this->model->insertKpi(
							$idKpiDD, 
							$idKpiPadre,
							$strLabel, 
							$strDescription, 
							$strSqlValue, 
							$strSqltabla,
							$intOculto,
							$intTotalizar,
							$strIcon,
							$intModulo, 
							$intPosicion,
							$intGraficaPrincipal,
							$intIdGrafica,
							$strParam1,
							$strParam2,
							$strParam3,
							$strParam4,
							$strParam5,
							$strUpd);
						}

					} else {

						$option = 2;
						
						if($_SESSION['permisosMod']['u']){
							$request_kpi = $this->model->updateKpi( $idKpi,
							$idKpiDD, 
							$strLabel, 
							$strDescription, 
							$strSqlValue, 
							$strSqltabla,
							$intOculto,
							$intTotalizar,
							$strIcon,
							$intModulo,
							$intPosicion,
							$intGraficaPrincipal,
							$intIdGrafica,
							$strParam1,
							$strParam2,
							$strParam3,
							$strParam4,
							$strParam5,
							$strUpd );

						}
					}	
					


					if($request_kpi > 0 )
					{
						if($option == 1){
							$arrResponse = array("status" => true, "msg" => "Datos guardados correctamente ID_KPI = ". $request_kpi);
						}if($option == 2){
							$arrResponse = array("status" => true, "msg" => "Datos Actualizados correctamente.");
						}
					}else if($request_kpi == 'exist'){
						$arrResponse = array("status" => false, "msg" => "¡Atención! el kpi  con este id ya existe.");		
					}else{
						$arrResponse = array("status" => false, "msg" => "No es posible almacenar los datos.");
					}
				
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			
			die();
		}

	public function getKpis()
	{
		if($_SESSION['permisosMod']['r']){
			$arrData = $this->model->selectKpis();
			for ($i=0; $i < count($arrData); $i++) {
				$btnView = '';
				$btnEdit = '';
				$btnDelete = '';


					if($arrData[$i]['OCULTO'] == 1)
					{
						$arrData[$i]['OCULTO'] = '<span class="badge badge-primary">Si</span>';
					}else{
						$arrData[$i]['OCULTO'] = '<span class="badge badge-default">No</span>';
					}

						if($_SESSION['permisosMod']['r']){
							$btnView = '<button class="btn btn-default btn-sm btnViewKpi" onClick="fntViewKpi('.$arrData[$i]['ID_KPI'].')" title="Ver Kpi"><i class="far fa-eye"></i></button>';
						}
						if($_SESSION['permisosMod']['u']){
							
								$btnEdit = '<button class="btn btn-info  btn-sm btnEditKpi" onClick="fntEditKpi(this,'.$arrData[$i]['ID_KPI'].')" title="Editar Kpi"><i class="fas fa-pencil-alt"></i></button>';
						
					}
					if($_SESSION['permisosMod']['d']){
						
							$btnDelete = '<button class="btn btn-danger btn-sm btnDelKpi" onClick="fntDelKpi('.$arrData[$i]['ID_KPI'].')" title="Eliminar Kpi"><i class="far fa-trash-alt"></i></button>';
					
				}
				$arrData[$i]['options'] = '<div class="text-center">'.$btnEdit.' '.$btnDelete.'</div>';
			}
			echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
		}
	die();
	}

	public function getKpi($idKpi){
	if($_SESSION['permisosMod']['r']){
		$idKpi = intval($idKpi);
		if($idKpi > 0)
		{
			$arrData = $this->model->selectKpi($idKpi);
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

	public function delKpi()
		{
			if($_POST){
				if($_SESSION['permisosMod']['d']){
					$intIdKpi = intval($_POST['idKpi']);
					$requestDelete = $this->model->deleteKpi($intIdKpi);
					if($requestDelete)
					{
						$arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el kpi');
					}else{
						$arrResponse = array('status' => false, 'msg' => 'Error al eliminar el kpi.');
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}

}
?>