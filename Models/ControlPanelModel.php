<?php 

class ControlPanelModel extends Mysql
{
	public function __construct()
	{
		parent::__construct();
	}

    public function getStimulDash($reportId)
    {
        $id_user = $_SESSION['userData']['ID'];
		$sql = "SELECT ds.ID, ds.NOMBRE, ds.DESCRIPCION, ds.ARCHIVO, ds.STATUS, ds.DELETE, ds.TIPO
				FROM user_stimulsoft us
				INNER JOIN dashboard_stimulsoft ds ON ds.ID = us.ID_STIMULSOFT
				INNER JOIN user u ON u.ID = us.ID_USER
				WHERE u.ID = $id_user
                AND ds.ID = $reportId";
		$request = $this->select($sql);

        return $request;
    }

    public function getGraphicData(int $idGrafica)
    {

		$ven_codigo =  !empty($_SESSION['userData']['VENCODIGO_WEBVIEW'])?$_SESSION['userData']['VENCODIGO_WEBVIEW']:'001';
		$id_user = $_SESSION['userData']['ID'];
		$sql = "SELECT kpi.ID_KPI, dashboard.BD, dashboard_kpi.DESCRIPTION, dashboard_kpi.OCULTO, kpi.DESCRIPTION as DESCRIPTIONKPI, dashboard_kpi.POSICION, dashboard_kpi.ANCHO, kpi.PARAM1,kpi.PARAM2,kpi.PARAM3,kpi.PARAM4,kpi.PARAM5
				FROM kpi 
				INNER JOIN dashboard_kpi  ON kpi.ID_KPI = dashboard_kpi.ID_KPI
				INNER JOIN dashboard ON dashboard_kpi.`ID_DASHBOARD` = dashboard.`ID_DASHBOARD`
				INNER JOIN `user` ON dashboard_kpi.ID_DASHBOARD = `user`.ID_DASHBOARD
				WHERE kpi.ID_GRAFICA = $idGrafica
				AND kpi.GRAFICA_PRINCIPAL = 1
				AND kpi.DESCRIPTION = 'DASHBOARD-STIMULSOFT-GRAFICA'
				AND `user`.ID =  $id_user";

		$request = $this->select($sql);
		if(!empty($request)){
			$bd = $request['BD'];
			
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

			// Crear el XML de datos
			$dataXml = new SimpleXMLElement('<root/>');

			// Obtener los datos de PARAM3, PARAM4 y PARAM5
			$param3 = $request['PARAM3']; // Meses
		 	$param4 = $request['PARAM4']; // Lara1 y Lara2
			$param5 = $request['PARAM5']; // Valores
			
			if($idGrafica == 3){

				// Verifica que los arrays tengan el mismo tamaño
				if (count($param3) === count($param5)) {
					for ($i = 0; $i < count($param3); $i++) {
						$mesNode = $dataXml->addChild('hoja1');
						// Asigna el mes correspondiente de PARAM3
						$mesNode->addChild('Meses', $this->getMesName($param3[$i]['MES']));
						// Asigna el valor correspondiente de PARAM5 a Lara1 y Lara2
						$mesNode->addChild('Lara1', $param5[$i]['MES1']);
						$mesNode->addChild('Lara2', $param5[$i]['MES1']); // Como mencionaste, Lara1 y Lara2 tendrán el mismo valor
					}
				}

			}
            if($idGrafica == 5){

				// Verifica que los arrays tengan el mismo tamaño
				for ($i = 0; $i < count($param3); $i++) {
					$vendedorNode = $dataXml->addChild('hoja2');
					$vendedorNode->addChild('Vendedores', $param3[$i]['SALDO VENCIDO']);
					$vendedorNode->addChild('Porcentaje', $param4[$i]['SALDO VENCIDO']);
				}

			}

			// Convertir a XML y guardar en una variable
			$xmlString = $dataXml->asXML();
		 
			// Pasar los datos XML a la vista
			return $xmlString;
		} else {
			return array();
		}
	}

    private function getMesName($numMes) 
    {
		$meses = [
			1 => 'Enero',
			2 => 'Febrero',
			3 => 'Marzo',
			4 => 'Abril',
			5 => 'Mayo',
			6 => 'Junio',
			7 => 'Julio',
			8 => 'Agosto',
			9 => 'Septiembre',
			10 => 'Octubre',
			11 => 'Noviembre',
			12 => 'Diciembre'
		];

		return isset($meses[$numMes]) ? $meses[$numMes] : 'Desconocido';
	}

    public function saveControlPanel($report, $reportName, $name, $reportDescription)
    {
		$id_user = $_SESSION['userData']['ID'];

        // Verificar si ya existe un archivo con el mismo nombre
        $fileName = $reportName;
        $filePath = __DIR__ .'/../Views/ControlPanel/Plantillas/'. $reportName. '.mrt';
        $counter = 1;

        // Añadir un sufijo si el archivo ya existe
        while (file_exists($filePath)) {
            $fileName = $reportName . '-' . $counter;
            $filePath = __DIR__ .'/../Views/ControlPanel/Plantillas/'. $fileName. '.mrt';
            $counter++;
        }

        $query = "INSERT INTO dashboard_stimulsoft (NOMBRE, DESCRIPCION, ARCHIVO) VALUES (?, ?, ?)";
		$arrValues = [$name, $reportDescription, $reportName];
		$insertId = $this->insert($query, $arrValues);

        $query1 = "INSERT INTO user_stimulsoft (ID_USER, ID_STIMULSOFT) VALUES (?, ?)";
		$arrValues1 = [$id_user, $insertId];
		$this->insert($query1, $arrValues1);

        if (file_put_contents($filePath, $report) !== false) {
            $response['status'] = 'success';
            $response['message'] = '¡El Dashboard se ha creado de manera correcta!';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Error al guardar el archivo en la carpeta.';
        }

        return $response;

	}

    public function selectLineParams()
	{	
		return self::getGraphicData(1);
	}

	public function selectColumnParams()
	{
		return self::getGraphicData(3);
	}

	public function selectPieParams()
	{
		return self::getGraphicData(5);
	}

	public function selectDonutParams()
	{
		return self::getGraphicData(7);
	}
}

?>