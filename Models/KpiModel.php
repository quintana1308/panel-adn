<?php 

class KpiModel extends Mysql
{
	private $intIdKpi;
	private $intIdKpiDD;
	private $strlabel;
	private $strDescription;
	private $strSqlValue;
	private $strSqltabla;
	private $intOculto;
	private $strTotalizar;
	private $strIcon;
	private $intPosicion;
	private $intGraficaPrincipal;
	private $intIdGrafica;
	private $strParam1;
	private $strParam2;
	private $strParam3;
	private $strParam4;
	private $strParam5;
	private $strUpd;
	private $intOrigen;

	public function __construct()
	{
		parent::__construct();
	}	

	public function selectKpis()
	{
		$id_user = $_SESSION['userData']['ID'];
		$sql = "SELECT K.ID_KPI, K.ID_KPI_DD,K.LABEL,K.DESCRIPTION,u.ID_DASHBOARD,K.OCULTO,K.POSICION
		FROM kpi K
		INNER JOIN dashboard d ON K.ID_KPI = d.ID_KPI
		INNER JOIN user u ON d.id_dashboard = u.id_dashboard
		AND	u.ID=$id_user";
		$request = $this->select_all($sql);
		return $request;
	}

	public function selectKpi(int $idKpi){
		$this->intIdKpi = $idKpi;
		$sql = "SELECT * 
				FROM kpi
				WHERE ID_KPI = $this->intIdKpi";
		$request = $this->select($sql);
		return $request;
		}

	public function insertkpi(int $idKpiDD, int $kpiPadre, string $label, string $description, string $sqlValue, string $sqlTabla, int $oculto, string $totalizar, string $icon, int $modulo, int $posicion, int $graficaPrincipal, int $idGrafica, string $param1, string $param2, string $param3, string $param4, string $param5,string $upd){

		$id_dashboard = $_SESSION['userData']['ID_DASHBOARD'];
		$id_user = $_SESSION['userData']['ID'];
		
		$this->intIdKpiDD = $idKpiDD == NULL ? NULL:$idKpiDD;
		$this->strlabel = $label;
		$this->strDescription = $description;
		$this->strSqlValue = $sqlValue;
		$this->strSqltabla = $sqlTabla;
		$this->intOculto = $oculto;
		$this->strTotalizar = $totalizar == NULL ? '':$totalizar;
		$this->strIcon = $icon;
		$this->intModulo = $modulo;
		$this->intPosicion = $posicion;
		$this->intGraficaPrincipal = $graficaPrincipal;
		$this->intIdGrafica = $idGrafica;
		$this->strParam1 = $param1;
		$this->strParam2 = $param2;
		$this->strParam3 = $param3;
		$this->strParam4 = $param4;
		$this->strParam5 = $param5;
		$this->strUpd = $upd;
		$this->intOrigen = 2147483647-$id_user;
		$return = '';

		$sql = "SELECT * FROM kpi WHERE 
					ID_KPI = '{$this->intIdKpi}'";
			$request = $this->select_all($sql);

		$sql2 = "SELECT * FROM dashboard WHERE 
					ID_KPI = '{$this->intIdKpi}'";
			$request2 = $this->select_all($sql);	

		if(empty($request) && empty($request2)) {

		$query_insert  = "INSERT INTO kpi(ID_KPI_DD,LABEL,DESCRIPTION,SQL_VALUE,SQL_TABLA,OCULTO,TOTALIZAR,ICON,MODULO,POSICION,GRAFICA_PRINCIPAL,ID_GRAFICA,PARAM1,PARAM2,PARAM3,PARAM4,PARAM5,UPD,ORIGEN) 
		VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
		$arrData = array(
			$this->intIdKpiDD,
			$this->strlabel,
			$this->strDescription,
			$this->strSqlValue,
			$this->strSqltabla,
			$this->intOculto,
			$this->strTotalizar,
			$this->strIcon,
			$this->intModulo,
			$this->intPosicion,
			$this->intGraficaPrincipal,
			$this->intIdGrafica,
			$this->strParam1,
			$this->strParam2,
			$this->strParam3,
			$this->strParam4,
			$this->strParam5,
			$this->strUpd,
			$this->intOrigen
		);

		$request_insert = $this->insert($query_insert,$arrData);

		$sqlId_kpi = "SELECT ID_KPI FROM kpi WHERE ORIGEN = $this->intOrigen";
		$request_Idkpi= $this->select($sqlId_kpi);

		$id_kpi = implode($request_Idkpi);

		$query_insert_dashboard = "INSERT INTO dashboard(ID_DASHBOARD,ID_KPI,DESCRI) VALUES(?,?,?)";
		$arrDataDashboard = array($id_dashboard,$id_kpi,'');
		$request_insert_dashboard = $this->insert($query_insert_dashboard,$arrDataDashboard);

		$update = "UPDATE kpi SET ORIGEN = NULL WHERE ORIGEN = $this->intOrigen";
		$request_update = $this->update_massive($update);

		
		if(!empty($kpiPadre)){
			$sqlkpipadre = "SELECT K.ID_KPI FROM kpi K
			INNER JOIN dashboard d ON K.ID_KPI = d.ID_KPI
			WHERE K.ID_KPI = $kpiPadre
			AND	d.ID_DASHBOARD=$id_dashboard";
			$requestKpipadre = $this->select_all($sqlkpipadre);

			if(!empty($requestKpipadre)){
				$updateKpiPadre = "UPDATE kpi SET ID_KPI_DD = $id_kpi WHERE ID_KPI = $kpiPadre";
				$requesUpdtKpipadre	= $this->update_massive($updateKpiPadre);
			}
			
		}
		

		$return = $id_kpi;
		} else {
			$return = "exist";
		}
		return $return;
	}

	public function updateKpi(int $idKpi, int $idKpiDD, string $label, string $description, string $sqlValue, string $sqlTabla, int $oculto, string $totalizar, string $icon, int $modulo, int $posicion, int $graficaPrincipal, int $idGrafica, string $param1, string $param2, string $param3, string $param4, string $param5,string $upd){

		$this->intIdKpi = $idKpi;
		$this->intIdKpiDD = $idKpiDD == NULL ? NULL :$idKpiDD;
		$this->strlabel = $label;
		$this->strDescription = $description;
		$this->strSqlValue = $sqlValue;
		$this->strSqltabla = $sqlTabla;
		$this->intOculto = $oculto;
		$this->strTotalizar = $totalizar == NULL ? '' :$totalizar;
		$this->strIcon = $icon;
		$this->intModulo = $modulo;
		$this->intPosicion = $posicion;
		$this->intGraficaPrincipal = $graficaPrincipal;
		$this->intIdGrafica = $idGrafica;
		$this->strParam1 = $param1;
		$this->strParam2 = $param2;
		$this->strParam3 = $param3;
		$this->strParam4 = $param4;
		$this->strParam5 = $param5;
		$this->strUpd = $upd;


			$sql = "UPDATE kpi SET ID_KPI=?, ID_KPI_DD=?, LABEL=?, DESCRIPTION=?, SQL_VALUE=?, SQL_TABLA=?, OCULTO=?, TOTALIZAR=?, ICON=?, MODULO=?,POSICION=?, GRAFICA_PRINCIPAL=?,ID_GRAFICA=?,PARAM1=?,PARAM2=?,PARAM3=?,PARAM4=?,PARAM5=?,UPD=?
					WHERE id_kpi = $this->intIdKpi ";
					$arrData = array($this->intIdKpi,
									$this->intIdKpiDD,
									$this->strlabel,
									$this->strDescription,
									$this->strSqlValue,
									$this->strSqltabla,
									$this->intOculto,
									$this->strTotalizar,
									$this->strIcon,
									$this->intModulo,
									$this->intPosicion,
									$this->intGraficaPrincipal,
									$this->intIdGrafica,
									$this->strParam1,
									$this->strParam2,
									$this->strParam3,
									$this->strParam4,
									$this->strParam5,
									$this->strUpd
									);
		
				$request = $this->update($sql,$arrData);
			
			return $request;
	}		
		
		

	public function deleteKpi(int $ikpi)
		{
			$this->intIdKpi = $ikpi;
				$sql = "DELETE FROM kpi WHERE ID_KPI = $this->intIdKpi";
				$request = $this->delete($sql);

				$sql_dashboard = "DELETE FROM dashboard WHERE ID_KPI = '{$this->intIdKpi}'";
				$request_dashboard = $this->delete($sql_dashboard);


				if($request)
				{
					$request = 'ok';	
				}else{
					$request = 'error';
				}
			
			return $request;
		}


}
?>