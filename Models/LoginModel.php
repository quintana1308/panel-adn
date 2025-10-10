<?php 

	class LoginModel extends Mysql
	{
		private $intIdUsuario;
		private $strUsuario;
		private $strPassword;
		private $strToken;

		public function __construct()
		{
			parent::__construct();
		}	

		public function loginUser(string $usuario, string $password)
		{
			$this->strUsuario = $usuario;
			$this->strPassword = $password;
			$sql = "SELECT ID,STATUS FROM user WHERE 
					USERNAME = '$this->strUsuario' and 
					PASSWORD = '$this->strPassword' and 
					STATUS != 0 ";
			$request = $this->select($sql);
			return $request;
		}

		public function loginUserToken(string $token)
		{
			$this->strToken = $token;
			$sql = "SELECT ID,STATUS FROM user WHERE 
					USERTOKEN = '$this->strToken' and 
					STATUS != 0 ";
			$request = $this->select($sql);
			return $request;
		}


		public function sessionLogin(int $iduser){
			$this->intIdUsuario = $iduser;
			//BUSCAR ROLE 
			$sql = "SELECT  u.ID,
							u.USERNAME,
							u.ROLID,
							u.ID_DASHBOARD,
							u.DESSCRIPCION AS DESCRIPCION_USER,
							r.idrol,r.nombrerol,
							u.STATUS,
							e.NOMBRE AS EMPRESA,
							e.ID AS ID_EMPRESA,
							u.COLOR1 AS COLOR,
							u.USERTOKEN,
							u.URL_WEBVIEW,
							u.VEN_CODIGO AS SUPERVISOR,
							u.RESUMEN,
							u.MAPA,
							u.CDF,
							u.STIMULDASH,
							u.DESING_STIMULDASH,
							d.DESCRIPCION as DASHBOARD_NAME
					FROM user u
					INNER JOIN rol r
					ON u.ROLID = r.idrol
					LEFT JOIN enterprise e 
					ON u.ID_ENTERPRISE = e.ID
					LEFT JOIN dashboard d
					ON d.ID_DASHBOARD = u.ID_DASHBOARD
					WHERE u.ID = $this->intIdUsuario";
			$request = $this->select($sql);
			$_SESSION['userData'] = $request;
			$_SESSION['userData']['VENCODIGO_WEBVIEW'] = !empty($_GET['vencodigo'])?$_GET['vencodigo']:'001';
			$_SESSION['userData']['EXPORT'] = !empty($_GET['export']) ? 1 : 0;
			return $request;
		}

		public function sessionUserDasboards(int $iduser){
			$this->intIdUsuario = $iduser;
			 
			$sql = "SELECT  ID,
							DASHBOARD_ID,
							DASHBOARD_NAME,
							DASHBOARD_IMAGE
					FROM user_dashboards
					WHERE USER_ID = $this->intIdUsuario
					ORDER BY ORDER_DASHBOARD";
			$request = $this->select_all($sql);
			$_SESSION['userDashboards'] = $request;
			return $request;
		}

		public function insertInfoSession(int $iduser){
			$this->intIdUsuario = $iduser;
			$log_in = date('Y-m-d H:i');
			$ip = $_SERVER['REMOTE_ADDR'];
			$user_agent = $_SERVER['HTTP_USER_AGENT'];

			$query_insert  = "INSERT INTO log_sessions(session_name,user_id,log_in,ip_address,user_agent) 
			VALUES(?,?,?,?,?) ON DUPLICATE KEY UPDATE log_in = '$log_in'";
			$arrData = array(session_id(),
				$this->intIdUsuario,
				$log_in,
				$ip,
				$user_agent
			);
			$request_insert = $this->insert($query_insert,$arrData);
			return $request_insert;
		}
		
		public function loginEnterpriseToken(string $token)
		{

			$this->strToken = $token;
			$sql = "SELECT 
					enterprise.ID,
					user.`ID` AS ID_USER,
					user.`STATUS` 
					FROM enterprise 
					INNER JOIN user ON enterprise.`ID` = user.`ID_ENTERPRISE`
					WHERE TOKENPANEL = '$this->strToken'";
			$request = $this->select($sql);
			return $request;
		}

	}
 ?>