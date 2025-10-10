<?php 

class EnterModel extends Mysql2
{

	public function __construct()
	{
		parent::__construct();
	}	

    public function data($token, $bd, $rif, $bdSincro, $nombre, $urlpanel, $tokenpanel)
    {
        $return = 0;
        
        $currentDate = date("Y-m-d");

		$query_insert  = "INSERT INTO enterprise(
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
						VALUES(?,?,?,?,?,?,?,?,?,?,?,?)";
		$arrData = array($token,
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

		$request_insert = $this->insert($query_insert,$arrData);
		$return = $request_insert;
		return $return;
    }

    public function updateEnterprise($token,$bd, $rif, $nombre,  $bdSincro, $urlpanel, $tokenpanel, $idEnterprise)
    {
        $return = 0;
        
        $sql = "UPDATE enterprise SET 
								TOKEN = ?,
								BD = ?,
								RIF = ?,
								NOMBRE = ?,
                                BDSINCRO = ?,
								URLPANEL = ?,
								TOKENPANEL = ?
					WHERE ID = ?";

		$arrData = array($token,$bd, $rif, $nombre,  $bdSincro, $urlpanel, $tokenpanel, $idEnterprise);

		$request_insert = $this->insert($sql,$arrData);
		$return = $request_insert;
		return $return;
    }

    public function deleteEnterprise($idEnterprise)
    {
        $sql = "DELETE FROM enterprise WHERE ID = $idEnterprise";
		$request = $this->delete($sql);

		return $request;
    }

}
?>