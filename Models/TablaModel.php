<?php 

	class TablaModel extends Mysql
	{
		private $idKpi;
		
		public function __construct()
		{
			parent::__construct();
		}

		public function selectFIlter(int $idkpi){

			$usuario 	= $_SESSION['userData']['ID'];
			$sql = "SELECT param.SQL_SINCE, 
							param.TYPE_PARAM, 
							param.LABEL,
							param.ORDER_PARAM,
							param.NAME_COLUMN,
							dashboard.BD
			FROM param
			INNER JOIN dashboard_kpi ON dashboard_kpi.ID_KPI = param.ID_KPI
			INNER JOIN dashboard ON dashboard.ID_DASHBOARD = dashboard_kpi.ID_DASHBOARD
			INNER JOIN `user` ON dashboard.`ID_DASHBOARD` = user.`ID_DASHBOARD`
			WHERE param.ID_KPI = $idkpi 
			AND user.`ID` = $usuario
			order by param.order_param asc";

			$request = $this->select_all($sql);
			
			for ($i=0; $i <count($request); $i++) { 

				$sql_value = $request[$i]['SQL_SINCE'];
				$sql_value = str_replace("'@BD'", $request[$i]['BD'], $sql_value);
				$result = $this->select_all($sql_value);
				$request[$i]['SQL_SINCE'] = $result==null? array():$result;
			}
			return $request;
		}

		public  function selectKpi(int $idkpi) 
		{	
			$cwhere = !empty($_GET['where'])?$_GET['where']:'';
			
			
			$usuario 	= $_SESSION['userData']['ID'];
			$ven_codigo =  !empty($_SESSION['userData']['VENCODIGO_WEBVIEW'])?$_SESSION['userData']['VENCODIGO_WEBVIEW']:'001';
			$supervisor =  !empty($_SESSION['userData']['SUPERVISOR'])?$_SESSION['userData']['SUPERVISOR']:'001';

			$this->idkpi = $idkpi;
			$sql = "SELECT 
					dashboard.`BD`,
					kpi.`ID_KPI`,
					dashboard_kpi.`ID_KPI_DD`,
					dashboard_kpi.`LABEL`,
					dashboard_kpi.`DESCRIPTION`,
					kpi.`SQL_VALUE`,
					kpi.`SQL_TABLA`,
					dashboard_kpi.`ICON`,
					dashboard_kpi.`TOTALIZAR`,
					dashboard_kpi.`OCULTAR`,
					dashboard_kpi.`OCULTO`,
					kpi.`MODULO`,
					dashboard_kpi.`POSICION`,
					kpi.`GRAFICA_PRINCIPAL`,
					kpi.`ID_GRAFICA`,
					kpi.`PARAM1`,
					kpi.`PARAM2`,
					kpi.`PARAM3`,
					kpi.`PARAM4`,
					kpi.`PARAM5`,
					kpi.`UPD`,
					kpi.`FILTER`
					FROM kpi
					INNER JOIN dashboard_kpi ON kpi.`ID_KPI` = dashboard_kpi.`ID_KPI`
					INNER JOIN dashboard ON dashboard_kpi.`ID_DASHBOARD` = dashboard.`ID_DASHBOARD`
					INNER JOIN `user` ON dashboard.`ID_DASHBOARD` = user.`ID_DASHBOARD`
					WHERE kpi.`ID_KPI`= $this->idkpi
					AND user.`ID` = $usuario";

			$request = $this->select($sql);
			$bd = $request['BD'];
			
			$label = $request['LABEL'] ==  NULL ?  'SELECT "QUERY REQUIRED"' : $request['LABEL'];
			$label = str_replace("'@BD'", $bd, $label);
			$label = str_replace("'@CWHERE'", $cwhere, $label);
			$result = $this->select($label);
			$request['LABEL'] = implode($result==null? array():$result);

			
			$description = $request['DESCRIPTION'] == NULL  ? 'SELECT "QUERY REQUIRED"' : $request['DESCRIPTION'];
			$description = str_replace("'@BD'", $bd, $description);
			$description = str_replace("'@CWHERE'", $cwhere, $description);
			$result = $this->select($description);
			$request['DESCRIPTION'] = implode($result==null? array():$result);

		
			$sql_value = $request['SQL_VALUE']  == NULL  ? 'SELECT "QUERY REQUIRED"' : $request['SQL_VALUE'];
			$sql_value = str_replace("'@BD'", $bd, $sql_value);
			$result = $this->select($sql_value);
			$request['SQL_VALUE'] = implode($result=='null'? array():$result);
			
			

			$sql_tabla = $request['SQL_TABLA']  == NULL  ? 'SELECT "QUERY REQUIRED"' : $request['SQL_TABLA'];
			$sql_tabla = str_replace("'@BD'", $bd, $sql_tabla);
			$sql_tabla = str_replace("'@CWHERE'", $cwhere, $sql_tabla);
			$sql_tabla = str_replace("'@VENCODIGO'", $ven_codigo, $sql_tabla);
			$sql_tabla = str_replace("'@SUPERVISOR'", $supervisor, $sql_tabla);
			
		
			$result = $this->select_all($sql_tabla);

			$request['SQL_TABLA'] = $result==null? array():$result;
			
			

			$upd = $request['UPD'];
			$upd = str_replace("'@BD'", $bd, $upd);
			$upd = str_replace("'@VENCODIGO'", $ven_codigo, $upd);
			$result = $this->select($upd);
			$request['UPD'] = implode($result);
			

			return $request;
		}

		public function selectFormatoCondicional(int $idKpi)
		{
			$sql = "SELECT 
					ID_KPI,
					COLUMNA,
					CONDICION,
					VALOR,
					MINIMO,
					MAXIMO,
					COLOR,
					HEXADECIMAL,
					TIPO,
					ACTIVO
					FROM formato_condicional
					WHERE ID_KPI = $idKpi AND ACTIVO = 1";
			$request = $this->select_all($sql);

			return $request;

		}

		public function getGraphicData(int $idkpi, int $idGrafica){

			$this->idkpi = $idkpi;
			$ven_codigo =  !empty($_SESSION['userData']['VENCODIGO_WEBVIEW'])?$_SESSION['userData']['VENCODIGO_WEBVIEW']:'001';
			$id_user = $_SESSION['userData']['ID'];
			$sql = "SELECT dashboard.BD, kpi.PARAM1,kpi.PARAM2,kpi.PARAM3,kpi.PARAM4,kpi.PARAM5
					FROM kpi 
					INNER JOIN dashboard_kpi  ON kpi.ID_KPI = dashboard_kpi.ID_KPI
					INNER JOIN dashboard ON dashboard_kpi.`ID_DASHBOARD` = dashboard.`ID_DASHBOARD`
					INNER JOIN `user` ON dashboard_kpi.ID_DASHBOARD = `user`.ID_DASHBOARD
					WHERE kpi.ID_GRAFICA = $idGrafica
					AND kpi.GRAFICA_PRINCIPAL = 0
					AND `user`.ID =  $id_user
					AND kpi.ID_KPI = $this->idkpi";

			$request = $this->select($sql);

			if(!empty($request)){
				$bd = $request['BD'];

				$param2 = substr($request['PARAM2'],0,6) != "SELECT" ? "SELECT ''":$request['PARAM2'];
				$param2 = str_replace("'@BD'", $bd, $param2);
				$param2 = str_replace("'@VENCODIGO'", $ven_codigo, $param2);
				$result = $this->select($param2);
				$request['PARAM2'] = implode($result);

				$param3 = $request['PARAM3'];
				$param3 = str_replace("'@BD'", $bd, $param3);
				$param3 = str_replace("'@VENCODIGO'", $ven_codigo, $param3);
				$result = $this->select_all($param3);
				$request['PARAM3'] = $result;

				$param4 = $request['PARAM4'];
				$param4 = str_replace("'@BD'", $bd, $param4);
				$param4 = str_replace("'@VENCODIGO'", $ven_codigo, $param4);
				$result = $this->select_all($param4);
				$request['PARAM4'] = $result;

				$param5 = $request['PARAM5'];
				$param5 = str_replace("'@BD'", $bd, $param5);
				$param5 = str_replace("'@VENCODIGO'", $ven_codigo, $param5);
				$result = $this->select_all($param5);
				$request['PARAM5'] = $result;	
				return $request;
			} else {
				return array();
			}
		}		

		/*********************graficas*******************/
		
		public function selectLineParams(int $idkpi)
		{
			return self::getGraphicData($idkpi,22);
		}


		public function selectPieParams(int $idkpi)
		{
			return self::getGraphicData($idkpi,23);
		}	


		public function selectDonutParams(int $idkpi)
		{
			return self::getGraphicData($idkpi,24);			
		}

		
		public function selectColumnParams(int $idkpi)
		{
			return self::getGraphicData($idkpi,25);
		}

		public function selectLinePieParams(int $idkpi)
		{
			return self::getGraphicData($idkpi,26);
		}		


		public function selectMapParams(int $idkpi){

			$cwhere =  !empty($_GET['where'])?$_GET['where']:'';
			$ven_codigo =  !empty($_SESSION['userData']['VENCODIGO_WEBVIEW'])?$_SESSION['userData']['VENCODIGO_WEBVIEW']:'001';
			$this->idkpi = $idkpi;
			$id_user = $_SESSION['userData']['ID'];
			$sql = "SELECT dashboard.BD, kpi.PARAM1,kpi.PARAM2,kpi.PARAM3,kpi.PARAM4,kpi.PARAM5
					FROM kpi 
					INNER JOIN dashboard_kpi  ON kpi.ID_KPI = dashboard_kpi.ID_KPI
					INNER JOIN dashboard ON dashboard_kpi.`ID_DASHBOARD` = dashboard.`ID_DASHBOARD`
					INNER JOIN `user` ON dashboard_kpi.ID_DASHBOARD = `user`.ID_DASHBOARD
					WHERE kpi.ID_GRAFICA = 13
					AND kpi.GRAFICA_PRINCIPAL = 0
					AND `user`.ID =  $id_user
					AND kpi.ID_KPI = $this->idkpi";
			
			//echo $sql;

			$request = $this->select($sql);

			$bd = $request['BD'];
			$param2 = $request['PARAM2'];
			$param2 = str_replace("'@BD'", $bd, $param2);
			$param2 = str_replace("'@CWHERE'", $cwhere, $param2);
			$param2 = str_replace("'@VENCODIGO'", $ven_codigo, $param2);
			$result = $this->select_all($param2);
			$request['PARAM2'] = $result;
			$param3 = $request['PARAM3'];
			$param3 = str_replace("'@BD'", $bd, $param3);
			$param3 = str_replace("'@CWHERE'", $cwhere, $param3);
			$param3 = str_replace("'@VENCODIGO'", $ven_codigo, $param3);
			$result3 = $this->select_all($param3);
			$request['PARAM3'] = $result3;
			return $request;
		}

		

	}
 ?>