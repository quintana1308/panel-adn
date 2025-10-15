<?php 

require_once("Models/EnterModel.php");
require_once("Libraries/Core/Mysql3.php");

class EnterpriseModel extends Mysql
{
	private $intIdUsuario;
	private $strNombre;
	private $intDashboard;
	private $strDashboardName;
	private $strColor;
	private $strPassword;
	private $intTipoId;
	private $intStatus;
	private $strToken;
	private $strWebView;

	public function __construct()
	{
		parent::__construct();
	}	
	public function selectEnterprises()
	{		
		$sql = "SELECT ID, TOKEN, BD, RIF, NOMBRE, URLPANEL, TOKENPANEL 
				FROM enterprise";
		$request = $this->select_all($sql);
		return $request;
	}

	public function insertEnterprise($token, $bd, $rif, $nombre, $bdSincro,$urlpanel, $tokenpanel){

		$enterpriseModel = new EnterModel();
		$mysql3 = new Mysql3();

		$dataIdEnterprise = $enterpriseModel->data($token, $bd, $rif, $bdSincro, $nombre, $urlpanel, $tokenpanel);

		$currentDate = date("Y-m-d");

		$return = 0;
		$query_insert  = "INSERT INTO enterprise(
									ID,
									TOKEN,
									BD,
									RIF,
									NOMBRE,
									FECHA_R,
									BDSINCRO,
									URLPANEL,
									TOKENPANEL) 
						VALUES(?,?,?,?,?,?,?,?,?)";

		$arrData = array(
						$dataIdEnterprise,
						$token,
						$bd,
						$rif,
						$nombre,
						$currentDate,
						$bdSincro,
						$urlpanel,
						$tokenpanel);
						
		$request_insert = $this->insert($query_insert,$arrData);

		if($request_insert)
	{	
		$query_insert_2  = "INSERT INTO enterprise(
									ID,
									TOKEN,
                                    BD,
                                    RIF,
                                    NOMBRE,
                                    TOKEN_CK,
                                    TOKEN_CS,
                                    URL,
                                    FECHA_R,
                                    THIRDPARTY,
                                    BDSINCRO,
                                    URLPANEL,
                                    TOKENPANEL) 
						VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)";

		$arrData_2 = array(
					$dataIdEnterprise,
					$token,
					$bd,
					$rif,
					$nombre,
                        '',
                        '',
                        '',
                        $currentDate,
                        '',
                        $bdSincro,
						$urlpanel,
						$tokenpanel);

			$request_insert_2 = $mysql3->insert($query_insert_2,$arrData_2);

		$return = $request_insert_2;
	}
		// Liberar recursos
		unset($enterpriseModel);
		unset($mysql3);
		return $return;

	}

	public function selectEnterprise(int $idEnterprise){

		$sql = "SELECT ID , TOKEN, BD, RIF, NOMBRE, URLPANEL, TOKENPANEL 
				FROM `enterprise`
				WHERE ID = $idEnterprise";
		$request = $this->select($sql);
		return $request;
	}

	public function updateDEnterpriseData($idEnterprise,$token,$bd,$rif,$nombre, $bdSincro, $tokenpanel,$urlpanel)
	{	

		$enterpriseModel = new EnterModel();
		$mysql3 = new Mysql3();
		
		$dataIdEnterprise = $enterpriseModel->updateEnterprise($token,$bd, $rif, $nombre,  $bdSincro, $urlpanel, $tokenpanel, $idEnterprise);

		$sql = "UPDATE enterprise SET 
								TOKEN = ?,
								BD = ?,
								RIF = ?,
								NOMBRE = ?,
								BDSINCRO = ?,
								URLPANEL = ?,
								TOKENPANEL = ?
					WHERE ID = ?";

		$arrData = array($token,$bd, $rif, $nombre, $bdSincro, $urlpanel, $tokenpanel, $idEnterprise);
		$request = $this->update($sql,$arrData);

		$request_2 = 0;
		if($request){
			$sql_2 = "UPDATE enterprise SET 
							TOKEN = ?,
							BD = ?,
							RIF = ?,
							NOMBRE = ?,
							BDSINCRO = ?,
							URLPANEL = ?,
							TOKENPANEL = ?
					WHERE ID = ?";

			$arrData_2 = array($token,$bd, $rif, $nombre, $bdSincro, $urlpanel, $tokenpanel, $idEnterprise);

			$update_2 = $mysql3->insert($sql_2,$arrData_2);
			$request_2 = $update_2;
		}

		// Liberar recursos
		unset($enterpriseModel);
		unset($mysql3);
		return $request_2;
	}

	public function deleteEnterprise(int $idEnterprise)
	{
		$enterpriseModel = new EnterModel();
		$mysql3 = new Mysql3();

		$dataIdEnterprise = $enterpriseModel->deleteEnterprise($idEnterprise);

		$sql = "DELETE FROM enterprise WHERE ID = $idEnterprise";
		$request = $this->delete($sql);

		$request_2 = 0;
		if($request){
			$sql_2 = "DELETE FROM enterprise WHERE ID = $idEnterprise";
			$request_2 = $mysql3->delete($sql_2);

		}
		
		// Liberar recursos
		unset($enterpriseModel);
		unset($mysql3);
		return $request_2;
	}

}
?>