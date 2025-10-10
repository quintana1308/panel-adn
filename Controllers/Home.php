<?php 

	class Home extends Controllers{
		public function __construct()
		{
			parent::__construct();
			session_start();
			//session_regenerate_id(true);
			if(empty($_SESSION['login']))
			{
				header('Location: '.base_url().'/login');
			}

			//error_reporting(0);
			getPermisos(1);
		}
 	
		public function home()
		{
			$data['page_id'] = 1;
			$data['page_tag'] = "Home";
			$data['page_title'] = "Página principal";
			$data['page_name'] = "home";
			$data['page_functions_js'] = "functions_admin.js";
			$data['inventarioLabel'] = $this->model->inventarioLabel();
			$data['comprasLabel'] = $this->model->comprasLabel();
			$data['ventasLabel'] = $this->model->ventasLabel();
			$data['finanzasLabel'] = $this->model->finanzasLabel();
			$data['cobranzaLabel'] = $this->model->cobranzaLabel();
			$data['logisticaLabel'] = $this->model->logisticaLabel();
			$data['auditoriaLabel'] = $this->model->auditoriaLabel();
			$data['mainKpisLimit4'] = $this->model->mainKpisLimit4();
			
			$data['graf']['graficaPricipalLine'] = $this->model->selectLineParams();
			$data['graf']['graficaPricipalLine2'] = $this->model->selectLineParams2();
			$data['graf']['graficaPricipalColumn'] = $this->model->selectColumnParams();
			$data['graf']['graficaPricipalColumn2'] = $this->model->selectColumnParams2();
			$data['graf']['graficaPricipalPie'] = $this->model->selectPieParams();
			$data['graf']['graficaPricipalPie2'] = $this->model->selectPieParams2();
			$data['graf']['graficaPricipalDonut'] = $this->model->selectDonutParams();
			$data['graf']['graficaPricipalDonut2'] = $this->model->selectDonutParams2();
			$data['graf']['graficaPricipalLinePie'] = $this->model->selectLinePieParams();
			$data['graf']['graficaPricipalLinePie2'] = $this->model->selectLinePieParams2();
			$data['graf']['graficaPricipalHeat'] = $this->model->selectHeatParams();
			$data['graf']['graficaPricipalHeat2'] = $this->model->selectHeatParams2();
	
			/*/////////////////////////grafica de line /////////////////////////*/
			if(!empty($data['graficaPricipalLine'])) {
				/*************************param3**************************/
				if(count($data['graficaPricipalLine']['PARAM3'])==1){

					$param3 = "'".implode($data['graficaPricipalLine']['PARAM3'][0])."'";

				}	else {
					$a3= (array_map(null, ...$data['graficaPricipalLine']['PARAM3']));
					$p3 =implode("','",$a3[0]);
					$param3 = "'".$p3."'";	
				}
				$data['graficaPricipalLine']['PARAM3'] = $param3;

				/*************************param4**************************/
				$a4 = (array_map(null, ...$data['graficaPricipalLine']['PARAM4']));
				$p4 = $a4[0];
				$data['graficaPricipalLine']['PARAM4'] = $p4;

				/*************************param5**************************/
				if(count($data['graficaPricipalLine']['PARAM5'])== 1){

					$p5 =(array_map(null, ...$data['graficaPricipalLine']['PARAM5']));
					$param5 = array_map(null, $data['graficaPricipalLine']['PARAM4'],$p5);
					for ($i=0; $i < count($param5); $i++) { 
						unset($param5[$i][0]);
					}

				}else {
					$param5 =(array_map(null, ...$data['graficaPricipalLine']['PARAM5']));
				}
				$data['graficaPricipalLine']['PARAM5'] = $param5;			
			}

			/*/////////////////////////grafica de line 2 /////////////////////////*/
			if(!empty($data['graficaPricipalLine2'])) {
				/*************************param3**************************/
				if(count($data['graficaPricipalLine2']['PARAM3'])==1){

					$param3 = "'".implode($data['graficaPricipalLine2']['PARAM3'][0])."'";

				}	else {
					$a3= (array_map(null, ...$data['graficaPricipalLine2']['PARAM3']));
					$p3 =implode("','",$a3[0]);
					$param3 = "'".$p3."'";	
				}
				$data['graficaPricipalLine2']['PARAM3'] = $param3;

				/*************************param4**************************/
				$a4 = (array_map(null, ...$data['graficaPricipalLine2']['PARAM4']));
				$p4 = $a4[0];
				$data['graficaPricipalLine2']['PARAM4'] = $p4;

				/*************************param5**************************/
				if(count($data['graficaPricipalLine2']['PARAM5'])== 1){

					$p5 =(array_map(null, ...$data['graficaPricipalLine2']['PARAM5']));
					$param5 = array_map(null, $data['graficaPricipalLine2']['PARAM4'],$p5);
					for ($i=0; $i < count($param5); $i++) { 
						unset($param5[$i][0]);
					}

				}else {
					$param5 =(array_map(null, ...$data['graficaPricipalLine2']['PARAM5']));
				}
				$data['graficaPricipalLine2']['PARAM5'] = $param5;			
			}

			/*/////////////////////grafica tipo column/////////////////////////*/
			if(!empty($data['graficaPricipalColumn'])) {

				
				/*************************param3**************************/
				if(count($data['graficaPricipalColumn']['PARAM3'])==1){

					$param3 = "'".implode($data['graficaPricipalColumn']['PARAM3'][0])."'";

				}	else {
					$a3= (array_map(null, ...$data['graficaPricipalColumn']['PARAM3']));
					$p3 =implode("','",$a3[0]);
					$param3 = "'".$p3."'";	
				}
				$data['graficaPricipalColumn']['PARAM3'] = $param3;

				/*************************param4**************************/
				$a4 = (array_map(null, ...$data['graficaPricipalColumn']['PARAM4']));
				$p4 = $a4[0];
				$data['graficaPricipalColumn']['PARAM4'] = $p4;

				/*************************param5**************************/
				if(count($data['graficaPricipalColumn']['PARAM5'])==1){

					$p5 =(array_map(null, ...$data['graficaPricipalColumn']['PARAM5']));
					$param5 = array_map(null, $data['graficaPricipalColumn']['PARAM4'],$p5);
					for ($i=0; $i < count($param5); $i++) { 
						unset($param5[$i][0]);
					}

				}else {
					$param5 =(array_map(null, ...$data['graficaPricipalColumn']['PARAM5']));
				}
				$data['graficaPricipalColumn']['PARAM5'] = $param5;			
			}

			/*/////////////////////grafica tipo column 2 /////////////////////////*/
			if(!empty($data['graficaPricipalColumn2'])) {

				
				/*************************param3**************************/
				if(count($data['graficaPricipalColumn2']['PARAM3'])==1){

					$param3 = "'".implode($data['graficaPricipalColumn2']['PARAM3'][0])."'";

				}	else {
					$a3= (array_map(null, ...$data['graficaPricipalColumn2']['PARAM3']));
					$p3 =implode("','",$a3[0]);
					$param3 = "'".$p3."'";	
				}
				$data['graficaPricipalColumn2']['PARAM3'] = $param3;

				/*************************param4**************************/
				$a4 = (array_map(null, ...$data['graficaPricipalColumn2']['PARAM4']));
				$p4 = $a4[0];
				$data['graficaPricipalColumn2']['PARAM4'] = $p4;

				/*************************param5**************************/
				if(count($data['graficaPricipalColumn2']['PARAM5'])==1){

					$p5 =(array_map(null, ...$data['graficaPricipalColumn2']['PARAM5']));
					$param5 = array_map(null, $data['graficaPricipalColumn2']['PARAM4'],$p5);
					for ($i=0; $i < count($param5); $i++) { 
						unset($param5[$i][0]);
					}

				}else {
					$param5 =(array_map(null, ...$data['graficaPricipalColumn2']['PARAM5']));
				}
				$data['graficaPricipalColumn2']['PARAM5'] = $param5;			
			}

			/*/////////////////////grafica tipo pie/////////////////////////*/
			if(!empty($data['graficaPricipalPie'])) {
				$a3= (array_map(null, ...$data['graficaPricipalPie']['PARAM3']));
				$p3 =$a3[0];
				$data['graficaPricipalPie']['PARAM3'] = $p3;

				$a4 = (array_map(null, ...$data['graficaPricipalPie']['PARAM4']));
				$p4 = $a4[0];
				$data['graficaPricipalPie']['PARAM4'] = $p4;

				$param5 =(array_map(null, ...$data['graficaPricipalPie']['PARAM5']));
				$data['graficaPricipalPie']['PARAM5'] = $param5;	
			}

			/*/////////////////////grafica tipo pie 2 /////////////////////////*/
			if(!empty($data['graficaPricipalPie2'])) {
				$a3= (array_map(null, ...$data['graficaPricipalPie2']['PARAM3']));
				$p3 =$a3[0];
				$data['graficaPricipalPie2']['PARAM3'] = $p3;

				$a4 = (array_map(null, ...$data['graficaPricipalPie2']['PARAM4']));
				$p4 = $a4[0];
				$data['graficaPricipalPie2']['PARAM4'] = $p4;

				$param5 =(array_map(null, ...$data['graficaPricipalPie2']['PARAM5']));
				$data['graficaPricipalPie2']['PARAM5'] = $param5;	
			}

			/*/////////////////////grafica tipo donut /////////////////////////*/
			if(!empty($data['graficaPricipalDonut'])) {
				$a3= (array_map(null, ...$data['graficaPricipalDonut']['PARAM3']));
				$p3 =$a3[0];
				$data['graficaPricipalDonut']['PARAM3'] = $p3;

				$a4 = (array_map(null, ...$data['graficaPricipalDonut']['PARAM4']));
				$p4 = $a4[0];
				$data['graficaPricipalDonut']['PARAM4'] = $p4;

				$param5 =(array_map(null, ...$data['graficaPricipalDonut']['PARAM5']));
				$data['graficaPricipalDonut']['PARAM5'] = $param5;	
			}

			/*/////////////////////grafica tipo donut 2 /////////////////////////*/
			if(!empty($data['graficaPricipalDonut2'])) {
				$a3= (array_map(null, ...$data['graficaPricipalDonut2']['PARAM3']));
				$p3 =$a3[0];
				$data['graficaPricipalDonut2']['PARAM3'] = $p3;

				$a4 = (array_map(null, ...$data['graficaPricipalDonut2']['PARAM4']));
				$p4 = $a4[0];
				$data['graficaPricipalDonut2']['PARAM4'] = $p4;

				$param5 =(array_map(null, ...$data['graficaPricipalDonut2']['PARAM5']));
				$data['graficaPricipalDonut2']['PARAM5'] = $param5;	
			}

			/*//////////////////////grafica de line pie//////////////////////*/
			if(!empty($data['graficaPricipalLinePie'])) {
				/*************************param3**************************/
				if(count($data['graficaPricipalLinePie']['PARAM3'])==1){

					$param3 = "'".implode($data['graficaPricipalLinePie']['PARAM3'][0])."'";

				}	else {
					$a3= (array_map(null, ...$data['graficaPricipalLinePie']['PARAM3']));
					$p3 =implode("','",$a3[0]);
					$param3 = "'".$p3."'";	
				}
				$data['graficaPricipalLinePie']['PARAM3'] = $param3;

				/*************************param4**************************/
				$a4 = (array_map(null, ...$data['graficaPricipalLinePie']['PARAM4']));
				$p4 = $a4[0];
				$data['graficaPricipalLinePie']['PARAM4'] = $p4;

				/*************************param5**************************/
				if(count($data['graficaPricipalLinePie']['PARAM5'])==1){

					$p5 =(array_map(null, ...$data['graficaPricipalLinePie']['PARAM5']));
					$param5 = array_map(null, $data['graficaPricipalLinePie']['PARAM4'],$p5);
					for ($i=0; $i < count($param5); $i++) { 
						unset($param5[$i][0]);
					}

				}else {
					$param5 =(array_map(null, ...$data['graficaPricipalLinePie']['PARAM5']));
				}
				$data['graficaPricipalLinePie']['PARAM5'] = $param5;			

				/*************************param6**************************/
				function averageArrays($arrays) {
				    $result = array();
				    $count = count($arrays);
				    foreach ($arrays as $array) {
				        foreach ($array as $key => $value) {
				            if (!isset($result[$key])) {
				                $result[$key] = 0;
				            }
				            $result[$key] += round($value / $count,2);
				        }
				    }
				    return $result;
				}

				$data['graficaPricipalLinePie']['PARAM6'] = implode(",",averageArrays($param5));

				/*************************param7**************************/				
				$data['graficaPricipalLinePie']['PARAM7'] = [];
				foreach($data['graficaPricipalLinePie']['PARAM4'] as $key => $value){
					$data['graficaPricipalLinePie']['PARAM7'][] = array($value, array_sum($data['graficaPricipalLinePie']['PARAM5'][$key]));
				}

			}

			/*//////////////////////grafica de line pie 2 //////////////////////*/
			if(!empty($data['graficaPricipalLinePie2'])) {
				/*************************param3**************************/
				if(count($data['graficaPricipalLinePie2']['PARAM3'])==1){

					$param3 = "'".implode($data['graficaPricipalLinePie2']['PARAM3'][0])."'";

				}	else {
					$a3= (array_map(null, ...$data['graficaPricipalLinePie2']['PARAM3']));
					$p3 =implode("','",$a3[0]);
					$param3 = "'".$p3."'";	
				}
				$data['graficaPricipalLinePie2']['PARAM3'] = $param3;

				/*************************param4**************************/
				$a4 = (array_map(null, ...$data['graficaPricipalLinePie2']['PARAM4']));
				$p4 = $a4[0];
				$data['graficaPricipalLinePie2']['PARAM4'] = $p4;

				/*************************param5**************************/
				if(count($data['graficaPricipalLinePie2']['PARAM5'])==1){

					$p5 =(array_map(null, ...$data['graficaPricipalLinePie2']['PARAM5']));
					$param5 = array_map(null, $data['graficaPricipalLinePie2']['PARAM4'],$p5);
					for ($i=0; $i < count($param5); $i++) { 
						unset($param5[$i][0]);
					}

				}else {
					$param5 =(array_map(null, ...$data['graficaPricipalLinePie2']['PARAM5']));
				}
				$data['graficaPricipalLinePie2']['PARAM5'] = $param5;			

				/*************************param6**************************/
				function averageArrays($arrays) {
				    $result = array();
				    $count = count($arrays);
				    foreach ($arrays as $array) {
				        foreach ($array as $key => $value) {
				            if (!isset($result[$key])) {
				                $result[$key] = 0;
				            }
				            $result[$key] += round($value / $count,2);
				        }
				    }
				    return $result;
				}

				$data['graficaPricipalLinePie2']['PARAM6'] = implode(",",averageArrays($param5));

				/*************************param7**************************/				
				$data['graficaPricipalLinePie2']['PARAM7'] = [];
				foreach($data['graficaPricipalLinePie2']['PARAM4'] as $key => $value){
					$data['graficaPricipalLinePie2']['PARAM7'][] = array($value, array_sum($data['graficaPricipalLinePie2']['PARAM5'][$key]));
				}

			}

			/*//////////////////////grafica de heat//////////////////////*/
			if(!empty($data['graficaPricipalHeat'])) {

				$xAxis = [];
				foreach ($data['graficaPricipalHeat']['PARAM3'] as $item) {
					$xAxis[] = "Mes " . $item["MES"];
				}

				// Preparar el array para yAxis (SCS)
				$yAxis = [];
				foreach ($data['graficaPricipalHeat']['PARAM4'] as $item) {
					if (!in_array($item["SCS"], $yAxis)) {
						$yAxis[] = $item["SCS"];
					}
				}

				/*************************param3**************************/
				if(count($data['graficaPricipalHeat']['PARAM3'])==1){

					$param3 = "'".implode($data['graficaPricipalHeat']['PARAM3'][0])."'";

				}	else {
					$a3= (array_map(null, ...$data['graficaPricipalHeat']['PARAM3']));
					$p3 =implode("','",$a3[0]);
					$param3 = "'".$p3."'";	
				}
				
				$data['graficaPricipalHeat']['PARAM3'] = $param3;

				/*************************param4**************************/
				$a4 = (array_map(null, ...$data['graficaPricipalHeat']['PARAM4']));
				$p4 =implode("','",$a4[0]);
				$param4 = "'".$p4."'";

				$data['graficaPricipalHeat']['PARAM4'] = $param4;

				/*************************param5**************************/
				// Preparar el array para xAxis (meses)
				$dataGrafica = [];
				for ($i = 0; $i < count($data['graficaPricipalHeat']['PARAM5']); $i++) {
					
					$dataGrafica[] = [$i % count($xAxis), 0, doubleval($data['graficaPricipalHeat']['PARAM5'][$i]["MES1"])];
				}
				$data['graficaPricipalHeat']['PARAM5'] = $dataGrafica;
			}

			/*//////////////////////grafica de heat 2 //////////////////////*/
			if(!empty($data['graficaPricipalHeat2'])) {

				$xAxis = [];
				foreach ($data['graficaPricipalHeat2']['PARAM3'] as $item) {
					$xAxis[] = "Mes " . $item["MES"];
				}

				// Preparar el array para yAxis (SCS)
				$yAxis = [];
				foreach ($data['graficaPricipalHeat2']['PARAM4'] as $item) {
					if (!in_array($item["SCS"], $yAxis)) {
						$yAxis[] = $item["SCS"];
					}
				}

				/*************************param3**************************/
				if(count($data['graficaPricipalHeat2']['PARAM3'])==1){

					$param3 = "'".implode($data['graficaPricipalHeat2']['PARAM3'][0])."'";

				}	else {
					$a3= (array_map(null, ...$data['graficaPricipalHeat2']['PARAM3']));
					$p3 =implode("','",$a3[0]);
					$param3 = "'".$p3."'";	
				}
				
				$data['graficaPricipalHeat2']['PARAM3'] = $param3;

				/*************************param4**************************/
				$a4 = (array_map(null, ...$data['graficaPricipalHeat2']['PARAM4']));
				$p4 =implode("','",$a4[0]);
				$param4 = "'".$p4."'";

				$data['graficaPricipalHeat2']['PARAM4'] = $param4;

				/*************************param5**************************/
				// Preparar el array para xAxis (meses)
				$dataGrafica = [];
				for ($i = 0; $i < count($data['graficaPricipalHeat2']['PARAM5']); $i++) {
					
					$dataGrafica[] = [$i % count($xAxis), 0, doubleval($data['graficaPricipalHeat2']['PARAM5'][$i]["MES1"])];
				}
				$data['graficaPricipalHeat2']['PARAM5'] = $dataGrafica;
			}

			$this->views->getView($this,"home",$data);
			

		}
		

		public function compras()
		{
			unset($_SESSION['breadcrumb']);
			$_SESSION['modulo'] = 'compras';

			$data['page_id'] = 4;
			$data['page_tag'] = "Compras";
			$data['page_title'] = "Compras";
			$data['page_name'] = "compras";
			$data['kpi']=$this->model->selectKpiCompras();
			$this->views->getView($this,"compras",$data);
		}

		public function finanzas()
		{
			unset($_SESSION['breadcrumb']);
			$_SESSION['modulo'] = 'finanzas';

			$data['page_id'] = 6;
			$data['page_tag'] = "Finanzas";
			$data['page_title'] = "Finanzas";
			$data['page_name'] = "finanzas";
			$data['kpi']=$this->model->selectKpiFinanzas();
			$this->views->getView($this,"finanzas",$data);
		}

		public function inventario()
		{
			unset($_SESSION['breadcrumb']);
			$_SESSION['modulo'] = 'inventario';

			$data['page_id'] = 3;
			$data['page_tag'] = "Inventario";
			$data['page_title'] = "Inventario";
			$data['page_name'] = "inventario";
			$data['kpi']=$this->model->selectKpiInventario();
			$this->views->getView($this,"inventario",$data);
		}

		public function ventas()
		{
			unset($_SESSION['breadcrumb']);
			$_SESSION['modulo'] = 'ventas';

			$data['page_id'] = 5;
			$data['page_tag'] = "Ventas";
			$data['page_title'] = "Ventas";
			$data['page_name'] = "ventas";
			$data['kpi']=$this->model->selectKpiVentas();
			$this->views->getView($this,"ventas",$data);
		}

		public function cobranza()
		{
			unset($_SESSION['breadcrumb']);
			$_SESSION['modulo'] = 'cobranza';

			$data['page_id'] = 7;
			$data['page_tag'] = "Cobranza";
			$data['page_title'] = "Cobranza";
			$data['page_name'] = "cobranza";
			$data['kpi']=$this->model->selectKpiCobranza();
			$this->views->getView($this,"cobranza",$data);
		}
		
		public function logistica()
		{
			unset($_SESSION['breadcrumb']);
			$_SESSION['modulo'] = 'logistica';

			$data['page_id'] = 7;
			$data['page_tag'] = "Logística";
			$data['page_title'] = "Logística";
			$data['page_name'] = "logistica";
			$data['kpi']=$this->model->selectKpiLogistica();
			$this->views->getView($this,"logistica",$data);
		}	

		public function auditoria()
		{
			unset($_SESSION['breadcrumb']);
			$_SESSION['modulo'] = 'auditoria';

			$data['page_id'] = 7;
			$data['page_tag'] = "auditoria";
			$data['page_title'] = "Auditoria";
			$data['page_name'] = "auditoria";
			$data['kpi']=$this->model->selectKpiAuditoria();
			$this->views->getView($this,"auditoria",$data);
		}

	}
?>