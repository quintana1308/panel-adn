<?php 

class Tabla extends Controllers{
	public function __construct()
	{
		parent::__construct(); 
		session_start();
		//session_regenerate_id(true);
		if(empty($_SESSION['login']))
		{
			header('Location: '.base_url().'/login');
		} 
			//getPermisos(6);
	}

	public function kpi($params)
	{	
		if(empty($params)){
			header("Location:".base_url());
		} else {
			$id_kpi = intval($params);
			
			$data['page_id'] = 7;
			$data['page_tag'] = "Tabla";
			$data['page_title'] = "Tabla";
			$data['page_name'] = "tabla";
			$data['page_functions_js'] = "functions_tabla.js";
			//$data['formato_condicional'] = $this->model->selectFormatoCondicional($id_kpi);
			$data['kpi'] = $this->model->selectkpi($id_kpi);
			if($data['kpi']['FILTER'] == 1){	
				$data['filtros'] = $this->model->selectFilter($data['kpi']['ID_KPI_DD']);
			}else{
				$data['filtros'] = $this->model->selectFilter($id_kpi);
			}

			/*/////////////////////////grafica de line/////////////////////////*/
			if($data['kpi']['ID_GRAFICA'] == 22){
				$data['paramsLine'] = $this->model->selectLineParams($id_kpi);
				/*************************param3**************************/
				if(count($data['paramsLine']['PARAM3'])==1){

					$param3 = "'".implode($data['paramsLine']['PARAM3'][0])."'";

				}	else {
					$a3= (array_map(null, ...$data['paramsLine']['PARAM3']));
					$p3 =implode("','",$a3[0]);
					$param3 = "'".$p3."'";	
				}
				$data['paramsLine']['PARAM3'] = $param3;

				/*************************param4**************************/
				$a4 = (array_map(null, ...$data['paramsLine']['PARAM4']));
				$p4 = $a4[0];
				$data['paramsLine']['PARAM4'] = $p4;

				/*************************param5**************************/
				if(count($data['paramsLine']['PARAM5'])==1){

					$p5 =(array_map(null, ...$data['paramsLine']['PARAM5']));
					$param5 = array_map(null, $data['paramsLine']['PARAM4'],$p5);
					for ($i=0; $i < count($param5); $i++) { 
						unset($param5[$i][0]);
					}

				}else {
					$param5 =(array_map(null, ...$data['paramsLine']['PARAM5']));
				}
				$data['paramsLine']['PARAM5'] = $param5;			
			}

			/*/////////////////////grafica tipo column/////////////////////////*/
			if($data['kpi']['ID_GRAFICA'] == 25) {
				$data['paramsColumn'] = $this->model->selectColumnParams($id_kpi);
				/*************************param3**************************/
				if(count($data['paramsColumn']['PARAM3'])==1){

					$param3 = "'".implode($data['paramsColumn']['PARAM3'][0])."'";

				}	else {
					$a3= (array_map(null, ...$data['paramsColumn']['PARAM3']));
					$p3 =implode("','",$a3[0]);
					$param3 = "'".$p3."'";	
				}
				$data['paramsColumn']['PARAM3'] = $param3;

				/*************************param4**************************/
				$a4 = (array_map(null, ...$data['paramsColumn']['PARAM4']));
				$p4 = $a4[0];
				$data['paramsColumn']['PARAM4'] = $p4;

				/*************************param5**************************/
				if(count($data['paramsColumn']['PARAM5'])==1){

					$p5 =(array_map(null, ...$data['paramsColumn']['PARAM5']));
					$param5 = array_map(null, $data['paramsColumn']['PARAM4'],$p5);
					for ($i=0; $i < count($param5); $i++) { 
						unset($param5[$i][0]);
					}

				}else {
					$param5 =(array_map(null, ...$data['paramsColumn']['PARAM5']));
				}
				$data['paramsColumn']['PARAM5'] = $param5;			
			}

			/*/////////////////////grafica tipo pie/////////////////////////*/
			if($data['kpi']['ID_GRAFICA'] == 23) {
				$data['paramsPie'] = $this->model->selectPieParams($id_kpi);
				$a3= (array_map(null, ...$data['paramsPie']['PARAM3']));
				$p3 =$a3[0];
				$data['paramsPie']['PARAM3'] = $p3;

				$a4 = (array_map(null, ...$data['paramsPie']['PARAM4']));
				$p4 = $a4[0];
				$data['paramsPie']['PARAM4'] = $p4;

				$param5 =(array_map(null, ...$data['paramsPieparamsPie']['PARAM5']));
				$data['paramsPie']['PARAM5'] = $param5;	
			}

			/*/////////////////////grafica tipo donut/////////////////////////*/
			if($data['kpi']['ID_GRAFICA'] == 24) {
				$data['paramsDonut'] = $this->model->selectDonutParams($id_kpi);
				$a3= (array_map(null, ...$data['paramsDonut']['PARAM3']));
				$p3 =$a3[0];
				$data['paramsDonut']['PARAM3'] = $p3;

				$a4 = (array_map(null, ...$data['paramsDonut']['PARAM4']));
				$p4 = $a4[0];
				$data['paramsDonut']['PARAM4'] = $p4;

				$param5 =(array_map(null, ...$data['paramsDonut']['PARAM5']));
				$data['paramsDonut']['PARAM5'] = $param5;	
			}

			/*//////////////////////grafica de line pie//////////////////////*/
			if($data['kpi']['ID_GRAFICA'] == 26) {
				$data['paramsLinePie'] = $this->model->selectLinePieParams($id_kpi);
				/*************************param3**************************/
				if(count($data['paramsLinePie']['PARAM3'])==1){

					$param3 = "'".implode($data['paramsLinePie']['PARAM3'][0])."'";

				}	else {
					$a3= (array_map(null, ...$data['paramsLinePie']['PARAM3']));
					$p3 =implode("','",$a3[0]);
					$param3 = "'".$p3."'";	
				}
				$data['paramsLinePie']['PARAM3'] = $param3;

				/*************************param4**************************/
				$a4 = (array_map(null, ...$data['paramsLinePie']['PARAM4']));
				$p4 = $a4[0];
				$data['paramsLinePie']['PARAM4'] = $p4;

				/*************************param5**************************/
				if(count($data['paramsLinePie']['PARAM5'])==1){

					$p5 =(array_map(null, ...$data['paramsLinePie']['PARAM5']));
					$param5 = array_map(null, $data['paramsLinePie']['PARAM4'],$p5);
					for ($i=0; $i < count($param5); $i++) { 
						unset($param5[$i][0]);
					}

				}else {
					$param5 =(array_map(null, ...$data['paramsLinePie']['PARAM5']));
				}
				$data['paramsLinePie']['PARAM5'] = $param5;			

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

				$data['paramsLinePie']['PARAM6'] = implode(",",averageArrays($param5));

				/*************************param7**************************/				
				$data['paramsLinePie']['PARAM7'] = [];
				foreach($data['paramsLinePie']['PARAM4'] as $key => $value){
					$data['paramsLinePie']['PARAM7'][] = array($value, array_sum($data['paramsLinePie']['PARAM5'][$key]));
				}

			}
			/*///////////////////////////MAPA GOOGLE///////////////////////////////*/
			if($data['kpi']['ID_GRAFICA'] == 13) {
				$data['paramsMap'] = $this->model->selectMapParams($id_kpi);
			}else{
				$data['paramsMap'] = '';
			}

		}

		$this->views->getView($this,"tabla",$data);

	}
}




?>