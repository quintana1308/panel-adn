<?php 
require_once "Config/Config.php";
require_once("Libraries/Core/Mysql4.php");

class DashboardModel extends Mysql
{
	private $intIdDashboard;
	
	public function __construct()
	{
		parent::__construct();
	}	

	public function insertDashboard($descripcion, $baseDeDatos)
	{
		$query_insert  = "INSERT INTO dashboard(DESCRIPCION, BD) 
			VALUES(?,?)";
			$arrData = array($descripcion,$baseDeDatos);
		$request_insert = $this->insert($query_insert,$arrData);

		return $request_insert;

	}

	public function selectDashboards()
	{
		$sql = "SELECT * FROM dashboard";
		$request = $this->select_all($sql);
		return $request;
	}


	public function selectkpisDashboard(int $dashboard)
	{
		$this->intIdDashboard = $dashboard;

		$sql = "SELECT K.ID_KPI FROM kpi K
				INNER JOIN dashboard D ON K.ID_KPI = D.ID_KPI
				WHERE D.ID_DASHBOARD = $this->intIdDashboard";
		$request = $this->select_all($sql);
		return $request;
	}


	public function selectAllkpisDashboard()
	{
		$sql = "SELECT K.ID_KPI FROM kpi K";
		$request = $this->select_all($sql);
		return $request;
	}


	public function selectDashboard(int $dashboard){
		$this->intIdDashboard = $dashboard;
		$sql = "SELECT ID_DASHBOARD, GROUP_CONCAT(DISTINCT ID_KPI) KPIS FROM dashboard WHERE ID_DASHBOARD = $this->intIdDashboard;";
		$request = $this->select($sql);
		return $request;
	}

	public function selectDashboarKpi(int $dashboard)
	{
	
		$this->intIdDashboard = $dashboard;
		$sql = "SELECT 
				2147483647 AS ID_KPI_DD,
				K.SUC, 
				K.VEN, 
				K.LABEL, 
				K.DESCRIPTION, 
				K.SQL_VALUE, 
				K.SQL_TABLA, 
				K.ICON, 
				K.OCULTO, 
				K.TOTALIZAR, 
				K.FILAS, 
				K.MODULO, 
				K.POSICION, 
				K.GRAFICA_PRINCIPAL, 
				K.ID_GRAFICA, 
				K.PARAM1, 
				K.PARAM2, 
				K.PARAM3, 
				K.PARAM4, 
				K.PARAM5,
				K.UPD,
				K.ID_KPI AS ORIGEN 
				FROM kpi K
				LEFT JOIN dashboard D ON K.ID_KPI = D.ID_KPI
				WHERE D.ID_DASHBOARD = $this->intIdDashboard";
		$request = $this->select_all($sql);
		return $request;
	}

	public function insertDuplicateKpi($idDashboardClonar, $descripcionClonar, $baseDeDatosClonar)
	{	

		$nombreBaseDeDatos = DB_NAME;

		$query_insert  = "INSERT INTO dashboard(DESCRIPCION, BD) 
			VALUES(?,?)";
			$arrData = array($descripcionClonar,$baseDeDatosClonar);
		$request_insert = $this->insert($query_insert,$arrData);

		if($request_insert > 0){

			$query_select_id = "SELECT MAX(ID_DASHBOARD) AS ultimo_id FROM dashboard";
			$request_select_id = $this->select($query_select_id);

			if (!empty($request_select_id)) {

				$ultimoId = $request_select_id['ultimo_id'];

				$sqlInsert = "INSERT INTO $nombreBaseDeDatos.dashboard_kpi(
																	ID_DASHBOARD, 
																	ID_KPI, 
																	ID_KPI_DD, 
																	LABEL, 
																	DESCRIPTION, 
																	ICON, 
																	OCULTO, 
																	POSICION, 
																	TOTALIZAR, 
																	OCULTAR, 
																	PRINCIPAL, 
																	ANCHO)
								SELECT $ultimoId AS ID_DASHBOARD, 
											ID_KPI, 
											ID_KPI_DD, 
											LABEL, 
											DESCRIPTION, 
											ICON, 
											OCULTO, 
											POSICION, 
											TOTALIZAR, 
											OCULTAR, 
											PRINCIPAL, 
											ANCHO 
								FROM $nombreBaseDeDatos.dashboard_kpi 
								WHERE ID_DASHBOARD = ?;";

				$arrData = array($idDashboardClonar);
				$request_insert = $this->insert($sqlInsert,$arrData);

				$return = $request_insert;

				return $return;
			}
		}

		return false;
	}
	
	//funciones para clonacion

	public function insertDuplicateServidorKpi($idDashboardClonar, $descripcionClonar, $baseDeDatosClonar, $newhost, $newdatabase, $newusername, $newpassword)
	{	
		$path = dirname(__DIR__) . '/Config/Config.php';

		// Definir las variables que se actualizarán
		$variables = [
			'DB_HOST_DINAMICO' => $newhost,
			'DB_NAME_DINAMICO' => $newdatabase,
			'DB_USER_DINAMICO' => $newusername,
			'DB_PASSWORD_DINAMICO' => $newpassword
		];
	
		// Leer el archivo y actualizar las variables con define()
		$envContent = file_get_contents($path);
		foreach ($variables as $key => $value) {
			$pattern = "/define\('{$key}',\s*['\"](.*?)['\"]\);/";
			$envContent = preg_replace($pattern, "define('{$key}', '{$value}');", $envContent);
		}
	
		// Guardar los cambios en el archivo
		file_put_contents($path, $envContent);
	
		// Limpiar caché para asegurar los cambios
		exec('php artisan config:clear');
		exec('php artisan cache:clear');

		$nombreBaseDeDatos = $newdatabase;

		// Crear instancia temporal de Mysql4 para operaciones en base de datos dinámica
		require_once("Libraries/Core/Mysql4.php");
		$mysql4 = new Mysql4();

		$query_insert  = "INSERT INTO $nombreBaseDeDatos.dashboard(DESCRIPCION, BD) 
			VALUES(?,?)";
			$arrData = array($descripcionClonar,$baseDeDatosClonar);

		$request_insert = $mysql4->insert($query_insert,$arrData);

		if($request_insert > 0){

			$query_select_id = "SELECT MAX(ID_DASHBOARD) AS ultimo_id FROM $nombreBaseDeDatos.dashboard";
			$request_select_id = $mysql4->select($query_select_id);
			
			$selectMaxKpiDestino = "SELECT MAX(ID_KPI) AS ultimoKpiDestino FROM $nombreBaseDeDatos.kpi";

			$requestMaxKpiDestino = $mysql4->select($selectMaxKpiDestino);

			$maxKpiDestino = $requestMaxKpiDestino['ultimoKpiDestino'];

			if (!empty($request_select_id)) {
				
				$ultimoId = $request_select_id['ultimo_id'];

				$selectKpiOrigen = "SELECT kpi.`DESCRIPTION`,
										kpi.`SQL_VALUE`,
										kpi.`SQL_TABLA`,
										kpi.`MODULO`,
										kpi.`GRAFICA_PRINCIPAL`,
										kpi.`ID_GRAFICA`,
										kpi.`TIPO_DASHBOARD`,
										kpi.`PARAM1`,
										kpi.`PARAM2`,
										kpi.`PARAM3`,
										kpi.`PARAM4`,
										kpi.`PARAM5`,
										kpi.`PARAM6`,
										kpi.`PARAM7`,
										kpi.`UPD`,
										dashboard_kpi.`ID_KPI` as ORIGEN,
										kpi.`FILTER`
								FROM kpi
								INNER JOIN dashboard_kpi ON kpi.`ID_KPI` = dashboard_kpi.`ID_KPI`
								WHERE dashboard_kpi.`ID_DASHBOARD` = $idDashboardClonar";
				$requestSelectKpiOrigen = $this->select_all($selectKpiOrigen);

				foreach ($requestSelectKpiOrigen as $key => $campo) {
		
					$insertKpiDestino = "INSERT INTO $nombreBaseDeDatos.kpi(`DESCRIPTION`,
														`SQL_VALUE`,
														`SQL_TABLA`,
														`MODULO`,
														`GRAFICA_PRINCIPAL`,
														`ID_GRAFICA`,
														`TIPO_DASHBOARD`,
														`PARAM1`,
														`PARAM2`,
														`PARAM3`,
														`PARAM4`,
														`PARAM5`,
														`PARAM6`,
														`PARAM7`,
														`UPD`,
														`ORIGEN`,
														`FILTER`)
										VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

					$arrDataKpiDestino = array(
									$campo['DESCRIPTION'],
									$campo['SQL_VALUE'],
									$campo['SQL_TABLA'],
									$campo['MODULO'],
									$campo['GRAFICA_PRINCIPAL'],
									$campo['ID_GRAFICA'],
									$campo['TIPO_DASHBOARD'],
									$campo['PARAM1'],
									$campo['PARAM2'],
									$campo['PARAM3'],
									$campo['PARAM4'],
									$campo['PARAM5'],
									$campo['PARAM6'],
									$campo['PARAM7'],
									$campo['UPD'],
									$campo['ORIGEN'],
									$campo['FILTER']
								);
						
					$requestInsertKpiDestino = $mysql4->insert($insertKpiDestino,$arrDataKpiDestino);
				}

				$selectDashboardKpiOrigen = "SELECT * FROM dashboard_kpi
											WHERE ID_DASHBOARD = $idDashboardClonar";
				$requestSelectDashboardKpiOrigen = $this->select_all($selectDashboardKpiOrigen);

				foreach ($requestSelectDashboardKpiOrigen as $key => $campo) {
		
					$insertDashKpiTempDestino = "INSERT INTO $nombreBaseDeDatos.dashboard_kpi_temp(`ID_DASHBOARD`,
														`ID_KPI`,
														`ID_KPI_DD`,
														`LABEL`,
														`DESCRIPTION`,
														`ICON`,
														`OCULTO`,
														`POSICION`,
														`TOTALIZAR`,
														`OCULTAR`,
														`PRINCIPAL`,
														`ANCHO`)
										VALUES(?,?,?,?,?,?,?,?,?,?,?,?)";

					$arrDataDashKpiTempDestino = array(
									$campo['ID_DASHBOARD'],
									$campo['ID_KPI'],
									$campo['ID_KPI_DD'],
									$campo['LABEL'],
									$campo['DESCRIPTION'],
									$campo['ICON'],
									$campo['OCULTO'],
									$campo['POSICION'],
									$campo['TOTALIZAR'],
									$campo['OCULTAR'],
									$campo['PRINCIPAL'],
									$campo['ANCHO']
								);
						
					$requestInsertDashKpiTempDestino = $mysql4->insert($insertDashKpiTempDestino,$arrDataDashKpiTempDestino);
				}

				

				$sqlInsert = "INSERT INTO $nombreBaseDeDatos.dashboard_kpi(ID_DASHBOARD, ID_KPI, ID_KPI_DD, LABEL, DESCRIPTION, ICON, OCULTO, POSICION, TOTALIZAR, OCULTAR, PRINCIPAL, ANCHO)
					SELECT 
					$ultimoId AS ID_DASHBOARD, 
					KPI_NEW1.ID_KPI,
					IF(ORIGEN.ID_KPI_DD IS NULL, NULL, KPI_NEW2.ID_KPI ) AS ID_KPI_DD,
					ORIGEN.LABEL, 
					ORIGEN.DESCRIPTION, 
					ORIGEN.ICON, 
					ORIGEN.OCULTO, 
					ORIGEN.POSICION, 
					ORIGEN.TOTALIZAR, 
					ORIGEN.OCULTAR, 
					ORIGEN.PRINCIPAL, 
					ORIGEN.ANCHO 
					FROM $nombreBaseDeDatos.dashboard_kpi_temp AS ORIGEN

					LEFT JOIN  $nombreBaseDeDatos.kpi AS KPI_NEW1 ON KPI_NEW1.ORIGEN = ORIGEN.ID_KPI AND KPI_NEW1.ID_KPI > $maxKpiDestino
					LEFT JOIN  $nombreBaseDeDatos.kpi AS KPI_NEW2 ON KPI_NEW2.ORIGEN = ORIGEN.ID_KPI_DD AND KPI_NEW2.ID_KPI > $maxKpiDestino

					WHERE ID_DASHBOARD = ?";

				$arrData = array($idDashboardClonar);

				$request_insert = $mysql4->insert($sqlInsert,$arrData);
				
				$deleteTempDashboardKpi = "DELETE FROM $nombreBaseDeDatos.dashboard_kpi_temp";
				$requestDelete = $mysql4->delete($deleteTempDashboardKpi);

				$return = $request_insert;
			
				// Liberar recursos y cerrar conexión dinámica
				unset($mysql4);

				return $return;
			}
		}

		return false;
	}

	public function selectKpiCloneDashboard(int $idNewDashboard)
	{
		$this->intIdDashboard = $idNewDashboard;
		$sql = "SELECT K.ID_KPI, K.ID_KPI_DD, K.ORIGEN 
				FROM kpi K
				LEFT JOIN dashboard D ON K.ID_KPI = D.ID_KPI
				WHERE D.ID_DASHBOARD = $this->intIdDashboard";
		$request = $this->select_all($sql);
		return $request;		
	}

	public function selectKpiOrigin(int $dashboard)
	{
		$this->intIdDashboard = $dashboard;
		$sql = "SELECT 
				K.ID_KPI, 
				K.ID_KPI_DD
				FROM kpi K
				LEFT JOIN dashboard D ON K.ID_KPI = D.ID_KPI
				WHERE D.ID_DASHBOARD = $this->intIdDashboard";
		$request = $this->select_all($sql);		
		return $request;

	}

	public function deleteDashboard(int $dashboard)
	{
		$this->intIdDashboard = $dashboard;
		$sql = "DELETE FROM dashboard WHERE ID_DASHBOARD = $this->intIdDashboard";
		$request = $this->delete($sql);

		return $request;			
	}
	
	public function deleteDashboardsKpi(int $dashboard)
	{
		$this->intIdDashboard = $dashboard;
		$sqlKpi = "	SELECT K.ID_KPI
					FROM kpi K
					INNER JOIN dashboard d ON K.ID_KPI = d.ID_KPI
					WHERE d.ID_DASHBOARD = $this->intIdDashboard";
		$requestKpi = $this->select_all($sqlKpi);
		$arr = array_column($requestKpi, 'ID_KPI');
		$strKpis = implode(",",$arr);

		$deleteKpi = "DELETE FROM kpi WHERE ID_KPI IN($strKpis)";
		$request = $this->delete($deleteKpi);

		return $request;
	}


	public function lastIdDashboard()
	{

		$sqlMaxDashboard = "SELECT MAX(ID_DASHBOARD) FROM dashboard";
		$requestMaxDashboard = $this->select($sqlMaxDashboard);
		$newDashboard = intval(implode($requestMaxDashboard))+1;

		return $newDashboard;

	}

}
?>