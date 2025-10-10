<?php 

	class HomeModel extends Mysql
	{	

		public function __construct()
		{
			parent::__construct();
		}	


		/*funcion para obtener los labaels de los modulos*/
		public function getLabels(int $modulo){

			$id_user = $_SESSION['userData']['ID'];
			$sql = "SELECT dashboard_kpi.LABEL
					FROM kpi 
					INNER JOIN dashboard_kpi  ON kpi.ID_KPI = dashboard_kpi.ID_KPI
					INNER JOIN user  ON dashboard_kpi.ID_DASHBOARD = user.ID_DASHBOARD
					WHERE dashboard_kpi.OCULTO = 0
					AND kpi.MODULO = $modulo
					AND user.ID = $id_user
					ORDER BY dashboard_kpi.POSICION, kpi.ID_KPI
					LIMIT 3";
			
			return $request = $this->select_all($sql);
		}

		/*funcion para obtener la data de los kpi*/
		public function getKpiData(int $modulo){

			$ven_codigo =  !empty($_SESSION['userData']['VENCODIGO_WEBVIEW'])?$_SESSION['userData']['VENCODIGO_WEBVIEW']:'001';
			$id_user = $_SESSION['userData']['ID'];
			$sql = "SELECT 
					kpi.ID_KPI, 
					dashboard_kpi.ID_KPI_DD,
					dashboard_kpi.LABEL,
					dashboard_kpi.DESCRIPTION,
					kpi.SQL_VALUE,
					kpi.SQL_TABLA,
					dashboard_kpi.OCULTO,
					dashboard_kpi.ICON,
					dashboard_kpi.TOTALIZAR,
					dashboard_kpi.OCULTAR,
					kpi.UPD,
					dashboard.`BD`,
					kpi.TIPO_DASHBOARD
					FROM kpi 
					INNER JOIN dashboard_kpi  ON kpi.ID_KPI = dashboard_kpi.ID_KPI
					INNER JOIN dashboard ON dashboard_kpi.`ID_DASHBOARD` = dashboard.`ID_DASHBOARD`
					INNER JOIN `user` ON dashboard_kpi.ID_DASHBOARD = user.ID_DASHBOARD
					WHERE dashboard_kpi.OCULTO = 0
					AND kpi.MODULO = $modulo
					AND user.ID= $id_user
					ORDER BY dashboard_kpi.POSICION,kpi.ID_KPI";
			
			$request = $this->select_all($sql);

			for ($i=0; $i <count($request); $i++) { 

				$bd = $request[$i]['BD'];

				$label = $request[$i]['LABEL'];
				$result = $this->select($label);
				$request[$i]['LABEL'] = implode($result);

				$description = $request[$i]['DESCRIPTION'];
				$result = $this->select($description);
				$request[$i]['DESCRIPTION'] = implode($result);

				$sql_value = $request[$i]['SQL_VALUE'];
				$sql_value = str_replace("'@BD'", $bd, $sql_value);
				$sql_value = str_replace("'@VENCODIGO'", $ven_codigo, $sql_value);
				$result = $this->select($sql_value);
				$request[$i]['SQL_VALUE'] = $result == ''? implode(array()): implode($result);

				$upd = $request[$i]['UPD'];
				$upd = str_replace("'@BD'", $bd, $upd);
				$upd = str_replace("'@VENCODIGO'", $ven_codigo, $upd);
				$result = $this->select($upd);
				$request[$i]['UPD'] = $result == ''? implode(array()): implode($result);
			}
			
			return $request;
		}

		/*funcion para obtener la data de las graficas*/
		public function getGraphicData(int $idGrafica){


			$ven_codigo =  !empty($_SESSION['userData']['VENCODIGO_WEBVIEW'])?$_SESSION['userData']['VENCODIGO_WEBVIEW']:'001';
			$id_user = $_SESSION['userData']['ID'];
			$sql = "SELECT kpi.ID_KPI, dashboard.BD, dashboard_kpi.DESCRIPTION, dashboard_kpi.OCULTO, kpi.DESCRIPTION as DESCRIPTIONKPI, dashboard_kpi.POSICION, dashboard_kpi.ANCHO, kpi.PARAM1,kpi.PARAM2,kpi.PARAM3,kpi.PARAM4,kpi.PARAM5
					FROM kpi 
					INNER JOIN dashboard_kpi  ON kpi.ID_KPI = dashboard_kpi.ID_KPI
					INNER JOIN dashboard ON dashboard_kpi.`ID_DASHBOARD` = dashboard.`ID_DASHBOARD`
					INNER JOIN `user` ON dashboard_kpi.ID_DASHBOARD = `user`.ID_DASHBOARD
					WHERE kpi.ID_GRAFICA = $idGrafica
					AND kpi.GRAFICA_PRINCIPAL = 1
					AND `user`.ID =  $id_user";

			$request = $this->select($sql);

			if(!empty($request)){
				$bd = $request['BD'];
				
				$description = substr($request['DESCRIPTION'],0,6) != "SELECT" ? "SELECT ''":$request['DESCRIPTION'];
				$result = $this->select($description);
				$request['DESCRIPTION'] = $result == '' ? 'No Disponible' : implode($result);

				$param2 = substr($request['PARAM2'],0,6) != "SELECT" ? "SELECT ''":$request['PARAM2'];
				$param2 = str_replace("'@BD'", $bd, $param2);
				$param2 = str_replace("'@VENCODIGO'", $ven_codigo, $param2);
				$result = $this->select($param2);
				$request['PARAM2'] = $result == ''? 'Fecha no disponible': implode($result);

				$param3 = $request['PARAM3'];
				$param3 = str_replace("'@BD'", $bd, $param3);
				$param3 = str_replace("'@VENCODIGO'", $ven_codigo, $param3);
				$result = $this->select_all($param3);
				if($result == ''){
					$request['statusGrafic'] = 1;
					$request['PARAM3'] = array();
				}else{
					$request['PARAM3'] = $result;
				}
				
				$param4 = $request['PARAM4'];
				$param4 = str_replace("'@BD'", $bd, $param4);
				$param4 = str_replace("'@VENCODIGO'", $ven_codigo, $param4);
				$result = $this->select_all($param4);
				if($result == ''){
					$request['statusGrafic'] = 1;
					$request['PARAM4'] = array();
				}else{
					$request['PARAM4'] = $result;
				}

				$param5 = $request['PARAM5'];
				$param5 = str_replace("'@BD'", $bd, $param5);
				$param5 = str_replace("'@VENCODIGO'", $ven_codigo, $param5);
				$result = $this->select_all($param5);
				if($result == ''){
					$request['statusGrafic'] = 1;
					$request['PARAM5'] = array();
				}else{
					$request['PARAM5'] = $result;
				}
				
				return $request;
			} else {
				return array();
			}
		}		

		/***********kpis principales que se van a mostrar en le home**********/
		public function mainKpisLimit4(){
			$id_user = $_SESSION['userData']['ID'];
			$ven_codigo =  !empty($_SESSION['userData']['VENCODIGO_WEBVIEW'])?$_SESSION['userData']['VENCODIGO_WEBVIEW']:'001';
			$sql = "SELECT 
					kpi.ID_KPI, 
					dashboard_kpi.LABEL,
					dashboard_kpi.ICON,
					kpi.MODULO,
					kpi.UPD,
					dashboard.`BD`
					FROM kpi 
					INNER JOIN dashboard_kpi  ON kpi.ID_KPI = dashboard_kpi.ID_KPI
					INNER JOIN dashboard ON dashboard_kpi.`ID_DASHBOARD` = dashboard.`ID_DASHBOARD`
					INNER JOIN `user` ON dashboard_kpi.ID_DASHBOARD = user.ID_DASHBOARD
					WHERE dashboard_kpi.OCULTO = 0
					AND dashboard_kpi.PRINCIPAL = 1
					AND user.ID= $id_user
					GROUP BY kpi.MODULO
					LIMIT 12";

					$request = $this->select_all($sql);
					for ($i=0; $i <count($request); $i++) { 
						
						$bd = $request[$i]['BD'];

						if($request[$i]['MODULO'] == 1 ){

							$request[$i]['NAME_MODULO'] = 'Inventario';
							$request[$i]['URL'] = 'inventario';
							$request[$i]['BACKGROUND'] = 'bg-gradient-warning';
							$request[$i]['ICON'] = '<i class="fas fa-box-open"></i>';
								

						} elseif ($request[$i]['MODULO'] == 2) {

							$request[$i]['NAME_MODULO'] = 'Compras';
							$request[$i]['URL'] = 'compras';
							$request[$i]['BACKGROUND'] = 'bg-gradient-danger';
							$request[$i]['ICON'] = '<i class="fas fa-money-check-alt"></i>';

						} elseif ($request[$i]['MODULO'] == 3) {

							$request[$i]['NAME_MODULO'] = 'Ventas';
							$request[$i]['URL'] = 'ventas';
							$request[$i]['BACKGROUND'] = 'bg-gradient-success';
							$request[$i]['ICON'] = '<i class="fas fa-hand-holding-usd"></i>';

						} elseif ($request[$i]['MODULO'] == 4) {

							$request[$i]['NAME_MODULO'] = 'Finanzas';
							$request[$i]['URL'] = 'finanzas';
							$request[$i]['BACKGROUND'] = 'bg-gradient-info';
							$request[$i]['ICON'] = '<i class="fas fa-money-bill-wave"></i>';

						} elseif ($request[$i]['MODULO'] == 5) {

							$request[$i]['NAME_MODULO'] = 'Cobranzas';
							$request[$i]['URL'] = 'cobranza';
							$request[$i]['BACKGROUND'] = 'bg-gradient-dark';
							$request[$i]['ICON'] = '<i class="fas fa-money-bill-wave"></i>';

						} elseif ($request[$i]['MODULO'] == 6) {

							$request[$i]['NAME_MODULO'] = 'Logística';
							$request[$i]['URL'] = 'logistica';
							$request[$i]['BACKGROUND'] = 'bg-gradient-warning';
							$request[$i]['ICON'] = '<i class="fas fa-box-open"></i>';

						} elseif ($request[$i]['MODULO'] == 7) {

							$request[$i]['NAME_MODULO'] = 'Auditoria';
							$request[$i]['URL'] = 'auditoria';
							$request[$i]['BACKGROUND'] = 'bg-gradient-secondary';
							$request[$i]['ICON'] = '<i class="fa-solid fa-timeline"></i>';
						}

						$label = $request[$i]['LABEL'];
						$result = $this->select($label);
						$request[$i]['LABEL'] = implode($result);

						$upd = $request[$i]['UPD'];
						$upd = str_replace("'@BD'", $bd, $upd);
						$upd = str_replace("'@VENCODIGO'", $ven_codigo, $upd);
						$result = $this->select($upd);
						$request[$i]['UPD'] = $result == ''? implode(array()): implode($result);
					}

					return $request;
		}

		/*********************Labels y menus******************/
 
		public function inventarioLabel()
		{
			
			$request = self::getLabels(1);	
			
			if(!empty($request)){
				$_SESSION['menu']['inventario'] = true;	
			} else {
				$_SESSION['menu']['inventario'] = false;	
			}

			return $request;
		}

		public function comprasLabel()
		{
			$request = self::getLabels(2);	
			
			if(!empty($request)){
				$_SESSION['menu']['compras'] = true;	
			}else {
				$_SESSION['menu']['compras'] = false;	
			}

			return $request;
		}

		public function ventasLabel()
		{
			$request = self::getLabels(3);	

			if(!empty($request)){
				$_SESSION['menu']['ventas'] = true;	
			}else {
				$_SESSION['menu']['ventas'] = false;	
			}

			return $request;
		}

		public function finanzasLabel()
		{
			
			$request = self::getLabels(4);	

			if(!empty($request)){
				$_SESSION['menu']['finanzas'] = true;	
			}else {
				$_SESSION['menu']['finanzas'] = false;	
			}

			return $request;
		}

		public function cobranzaLabel()
		{
			
			$request = self::getLabels(5);

			if(!empty($request)){
				$_SESSION['menu']['cobranza'] = true;	
			}else {
				$_SESSION['menu']['cobranza'] = false;	
			}

			return $request;
		}

		public function logisticaLabel()
		{
			
			$request = self::getLabels(6);

			if(!empty($request)){
				$_SESSION['menu']['logistica'] = true;	
			}else {
				$_SESSION['menu']['logistica'] = false;	
			}

			return $request;
		}
		
		public function auditoriaLabel()
		{
			
			$request = self::getLabels(7);

			if(!empty($request)){
				$_SESSION['menu']['auditoria'] = true;	
			}else {
				$_SESSION['menu']['auditoria'] = false;	
			}

			return $request;
		}

		/************data de los kpi de cada modulo****************/

		public function selectKpiInventario()
		{	
			return self::getKpiData(1);
		}	

		public function selectKpiCompras()
		{
			return self::getKpiData(2);
		}		

		public function selectKpiVentas()
		{
			return self::getKpiData(3);
		}	

		public function selectKpiFinanzas()
		{
			return self::getKpiData(4);
		}	

		public function selectKpiCobranza()
		{
			return self::getKpiData(5);
		}		

		public function selectKpiLogistica()
		{
			return self::getKpiData(6);
		}	

		public function selectKpiAuditoria()
		{
			return self::getKpiData(7);
		}

		
		/*********************graficas*******************/
		
		public function selectLineParams()
		{	
			return self::getGraphicData(1);

		}

		public function selectLineParams2()
		{	
			return self::getGraphicData(2);

		}

		public function selectColumnParams()
		{
			return self::getGraphicData(3);
		}

		public function selectColumnParams2()
		{
			return self::getGraphicData(4);
		}

		public function selectPieParams()
		{
			return self::getGraphicData(5);
		}
		
		public function selectPieParams2()
		{
			return self::getGraphicData(6);
		}	

		public function selectDonutParams()
		{
			return self::getGraphicData(7);			
		}

		public function selectDonutParams2()
		{
			return self::getGraphicData(8);			
		}

		public function selectLinePieParams()
		{
			return self::getGraphicData(9);
		}

		public function selectLinePieParams2()
		{
			return self::getGraphicData(10);
		}
		
		public function selectHeatParams()
		{
			return self::getGraphicData(11);
		}

		public function selectHeatParams2()
		{
			return self::getGraphicData(12);
		}

	}


 ?>
