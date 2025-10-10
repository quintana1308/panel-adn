<?php 

	class CenterModel extends Mysql
	{	


		public function __construct()
		{
			parent::__construct();
		}


		public function getKpiDasbhoard($dashboard){

			$query= "SELECT kpi.ID_KPI 
            FROM kpi 
            INNER JOIN dashboard_kpi  ON kpi.ID_KPI = dashboard_kpi.ID_KPI
            INNER JOIN dashboard ON dashboard_kpi.`ID_DASHBOARD` = dashboard.`ID_DASHBOARD`
            WHERE dashboard_kpi.ID_DASHBOARD = '$dashboard' AND kpi.DESCRIPTION = 'CDF';";
			$select = $this->select($query);
			$kpi = isset($select['ID_KPI'])? $select['ID_KPI'] : 0; 

			return $kpi;

		}
		
	


	}


 ?>
