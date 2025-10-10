<?php 

	class ResumenModel extends Mysql
	{
        public function __construct()
		{
			parent::__construct();
		}

        /*funcion para obtener la data de las graficas*/
		public function getGraphicData(int $idGrafica, string $empresa){


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

                if($empresa == ''){
                    $bd = $request['BD'];
                }else{
                    $bd = $empresa;
                }
				
				$description = substr($request['DESCRIPTION'],0,6) != "SELECT" ? "SELECT ''":$request['DESCRIPTION'];
				$result = $this->select($description);
				$request['DESCRIPTION'] = implode($result);

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

        public  function getKpiDataResumen(string $empresa) 
		{   
			$cwhere =  !empty($_GET['where'])?$_GET['where']:'';
			$ven_codigo =  !empty($_SESSION['userData']['VENCODIGO_WEBVIEW'])?$_SESSION['userData']['VENCODIGO_WEBVIEW']:'001';
			$supervisor =  !empty($_SESSION['userData']['SUPERVISOR'])?$_SESSION['userData']['SUPERVISOR']:'001';
			$id_user = $_SESSION['userData']['ID'];

            $sql = "SELECT 
            kpi.ID_KPI, 
            dashboard_kpi.ID_KPI_DD,
            dashboard_kpi.LABEL,
            dashboard_kpi.DESCRIPTION,
            kpi.SQL_VALUE,
			kpi.MODULO,
            kpi.SQL_TABLA,
            dashboard_kpi.OCULTO,
            dashboard_kpi.ICON,
            dashboard_kpi.TOTALIZAR,
            dashboard_kpi.OCULTAR,
            kpi.UPD,
            dashboard.`BD`
            FROM kpi 
            INNER JOIN dashboard_kpi  ON kpi.ID_KPI = dashboard_kpi.ID_KPI
            INNER JOIN dashboard ON dashboard_kpi.`ID_DASHBOARD` = dashboard.`ID_DASHBOARD`
            INNER JOIN `user` ON dashboard_kpi.ID_DASHBOARD = user.ID_DASHBOARD
            WHERE dashboard_kpi.OCULTO = 0
            AND kpi.DESCRIPTION = 'RESUMEN'
            AND user.ID= $id_user
            ORDER BY dashboard_kpi.POSICION,kpi.ID_KPI";

			/*$sql = "SELECT K.ID_KPI, K.DESCRIPTION, K.LABEL,K.SQL_VALUE, K.SQL_TABLA, K.UPD, K.ICON,K.MODULO			
			FROM kpi K 
			INNER JOIN dashboard D ON K.ID_KPI = D.ID_KPI
			INNER JOIN user U ON D.ID_DASHBOARD = U.ID_DASHBOARD
			WHERE K.SUC = 'RESUMEN'
			AND K.ID_GRAFICA = 0
			AND	U.ID =  $id_user
			ORDER BY K.MODULO";*/

			$request = $this->select_all($sql);

			for ($i=0; $i <count($request); $i++) { 

                if($empresa == ''){
                    $bd = $request[$i]['BD'];
                }else{
                    $bd = $empresa;
                }

               // $bd = $request[$i]['BD'];
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
				$request[$i]['SQL_VALUE'] = implode($result);

				$sql_value = $request[$i]['SQL_TABLA'];
				$sql_value = str_replace("'@BD'", $bd, $sql_value);
                
				$sql_value = str_replace("'@VENCODIGO'", $ven_codigo, $sql_value);
				$result = $this->select($sql_value);
				$request[$i]['SQL_TABLA'] = implode($result);

				$upd = $request[$i]['UPD'];
				$upd = str_replace("'@BD'", $bd, $upd); 
				$upd = str_replace("'@VENCODIGO'", $ven_codigo, $upd);
				$result = $this->select($upd);
				$request[$i]['UPD'] = implode($result);

                
                
			}
		
                 
			return $request;
		}

        /******************** KPI Resumen ***************/

        public function selectKpisResumen($empresa)
		{
			return self::getKpiDataResumen($empresa);
		}


        /*********************graficas*******************/
		
		public function selectLineParamsResumen($empresa)
		{	
			return self::getGraphicData(14, $empresa);

		}

		public function selectLineParamsResumen2($empresa)
		{	
			return self::getGraphicData(15, $empresa);

		}

		public function selectColumnParamsResumen($empresa)
		{
			return self::getGraphicData(16, $empresa);
		}

		public function selectColumnParamsResumen2($empresa)
		{
			return self::getGraphicData(17, $empresa);
		}

		public function selectDonutParamsResumen($empresa)
		{
			return self::getGraphicData(18, $empresa);
		}
		
		public function selectDonutParamsResumen2($empresa)
		{
			return self::getGraphicData(19, $empresa);
		}	

		public function selectPieParamsResumen($empresa)
		{
			return self::getGraphicData(20, $empresa);			
		}

		public function selectPieParamsResumen2($empresa)
		{
			return self::getGraphicData(21, $empresa);			
		}
    }
?>