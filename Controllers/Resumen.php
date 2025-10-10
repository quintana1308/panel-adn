<?php 
    class Resumen extends Controllers{
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

        public function resumen()
		{   

            if (isset($_GET['empresa']) && !empty($_GET['empresa'])) {
                // Si está presente, depurar o realizar cualquier otra acción
                $empresa = $_GET['empresa'];
            }else{
                $empresa = '';
            }

			$data['page_id'] = 1;
			$data['page_tag'] = "resumen";
			$data['page_title'] = "Resumen";
			$data['page_name'] = "resumen";
			$data['page_functions_js'] = "functions_admin.js";
			$data['labels'] = $this->model->selectKpisResumen($empresa);
			$data['graf']['graficaResumenLine'] = $this->model->selectLineParamsResumen($empresa);
			$data['graf']['graficaResumenLine2'] = $this->model->selectLineParamsResumen2($empresa);
			$data['graf']['graficaResumenColumn'] = $this->model->selectColumnParamsResumen($empresa);
			$data['graf']['graficaResumenColumn2'] = $this->model->selectColumnParamsResumen2($empresa);
			$data['graf']['graficaResumenDonut'] = $this->model->selectDonutParamsResumen($empresa);
            $data['graf']['graficaResumenDonut2'] = $this->model->selectDonutParamsResumen2($empresa);
			$data['graf']['graficaResumenPie'] = $this->model->selectPieParamsResumen($empresa);
			$data['graf']['graficaResumenPie2'] = $this->model->selectPieParamsResumen2($empresa);
			/*$data['graficaPricipalTabla'] = $this->model->selectTableParams();*/


			/*/////////////////////////grafica de line /////////////////////////*/
			if(!empty($data['graficaResumenLine'])) {
				/*************************param3**************************/
				if(count($data['graficaResumenLine']['PARAM3'])==1){

					$param3 = "'".implode($data['graficaResumenLine']['PARAM3'][0])."'";

				}	else {
					$a3= (array_map(null, ...$data['graficaResumenLine']['PARAM3']));
					$p3 =implode("','",$a3[0]);
					$param3 = "'".$p3."'";	
				}
				$data['graficaResumenLine']['PARAM3'] = $param3;

				/*************************param4**************************/
				$a4 = (array_map(null, ...$data['graficaResumenLine']['PARAM4']));
				$p4 = $a4[0];
				$data['graficaResumenLine']['PARAM4'] = $p4;

				/*************************param5**************************/
				if(count($data['graficaResumenLine']['PARAM5'])== 1){

					$p5 =(array_map(null, ...$data['graficaResumenLine']['PARAM5']));
					$param5 = array_map(null, $data['graficaResumenLine']['PARAM4'],$p5);
					for ($i=0; $i < count($param5); $i++) { 
						unset($param5[$i][0]);
					}

				}else {
					$param5 =(array_map(null, ...$data['graficaResumenLine']['PARAM5']));
				}
				$data['graficaResumenLine']['PARAM5'] = $param5;			
			}
			
			/*/////////////////////////grafica de line 2 /////////////////////////*/
			if(!empty($data['graficaResumenLine2'])) {
				/*************************param3**************************/
				if(count($data['graficaResumenLine2']['PARAM3'])==1){

					$param3 = "'".implode($data['graficaResumenLine2']['PARAM3'][0])."'";

				}	else {
					$a3= (array_map(null, ...$data['graficaResumenLine2']['PARAM3']));
					$p3 =implode("','",$a3[0]);
					$param3 = "'".$p3."'";	
				}
				$data['graficaResumenLine2']['PARAM3'] = $param3;

				/*************************param4**************************/
				$a4 = (array_map(null, ...$data['graficaResumenLine2']['PARAM4']));
				$p4 = $a4[0];
				$data['graficaResumenLine2']['PARAM4'] = $p4;

				/*************************param5**************************/
				if(count($data['graficaResumenLine2']['PARAM5'])== 1){

					$p5 =(array_map(null, ...$data['graficaResumenLine2']['PARAM5']));
					$param5 = array_map(null, $data['graficaResumenLine2']['PARAM4'],$p5);
					for ($i=0; $i < count($param5); $i++) { 
						unset($param5[$i][0]);
					}

				}else {
					$param5 =(array_map(null, ...$data['graficaResumenLine2']['PARAM5']));
				}
				$data['graficaResumenLine2']['PARAM5'] = $param5;			
			}

            /*/////////////////////grafica tipo column/////////////////////////*/
			if(!empty($data['graficaPricipalColumn'])) {

				
				/*************************param3**************************/
				if(count($data['graficaResumenColumn']['PARAM3'])==1){

					$param3 = "'".implode($data['graficaResumenColumn']['PARAM3'][0])."'";

				}	else {
					$a3= (array_map(null, ...$data['graficaResumenColumn']['PARAM3']));
					$p3 =implode("','",$a3[0]);
					$param3 = "'".$p3."'";	
				}
				$data['graficaResumenColumn']['PARAM3'] = $param3;

				/*************************param4**************************/
				$a4 = (array_map(null, ...$data['graficaResumenColumn']['PARAM4']));
				$p4 = $a4[0];
				$data['graficaResumenColumn']['PARAM4'] = $p4;

				/*************************param5**************************/
				if(count($data['graficaResumenColumn']['PARAM5'])==1){

					$p5 =(array_map(null, ...$data['graficaResumenColumn']['PARAM5']));
					$param5 = array_map(null, $data['graficaResumenColumn']['PARAM4'],$p5);
					for ($i=0; $i < count($param5); $i++) { 
						unset($param5[$i][0]);
					}

				}else {
					$param5 =(array_map(null, ...$data['graficaResumenColumn']['PARAM5']));
				}
				$data['graficaResumenColumn']['PARAM5'] = $param5;			
			}

			/*/////////////////////grafica tipo column 2 /////////////////////////*/
			if(!empty($data['graficaResumenColumn2'])) {

				
				/*************************param3**************************/
				if(count($data['graficaResumenColumn2']['PARAM3'])==1){

					$param3 = "'".implode($data['graficaResumenColumn2']['PARAM3'][0])."'";

				}	else {
					$a3= (array_map(null, ...$data['graficaResumenColumn2']['PARAM3']));
					$p3 =implode("','",$a3[0]);
					$param3 = "'".$p3."'";	
				}
				$data['graficaResumenColumn2']['PARAM3'] = $param3;

				/*************************param4**************************/
				$a4 = (array_map(null, ...$data['graficaResumenColumn2']['PARAM4']));
				$p4 = $a4[0];
				$data['graficaResumenColumn2']['PARAM4'] = $p4;

				/*************************param5**************************/
				if(count($data['graficaResumenColumn2']['PARAM5'])==1){

					$p5 =(array_map(null, ...$data['graficaResumenColumn2']['PARAM5']));
					$param5 = array_map(null, $data['graficaResumenColumn2']['PARAM4'],$p5);
					for ($i=0; $i < count($param5); $i++) { 
						unset($param5[$i][0]);
					}

				}else {
					$param5 =(array_map(null, ...$data['graficaResumenColumn2']['PARAM5']));
				}
				$data['graficaResumenColumn2']['PARAM5'] = $param5;			
			}

            /*/////////////////////grafica tipo donut /////////////////////////*/
			if(!empty($data['graficaResumenDonut'])) {
				$a3= (array_map(null, ...$data['graficaResumenDonut']['PARAM3']));
				$p3 =$a3[0];
				$data['graficaResumenDonut']['PARAM3'] = $p3;

				$a4 = (array_map(null, ...$data['graficaResumenDonut']['PARAM4']));
				$p4 = $a4[0];
				$data['graficaResumenDonut']['PARAM4'] = $p4;

				$param5 =(array_map(null, ...$data['graficaResumenDonut']['PARAM5']));
				$data['graficaResumenDonut']['PARAM5'] = $param5;	
			}

			/*/////////////////////grafica tipo donut 2 /////////////////////////*/
			if(!empty($data['graficaResumenDonut2'])) {
				$a3= (array_map(null, ...$data['graficaResumenDonut2']['PARAM3']));
				$p3 =$a3[0];
				$data['graficaResumenDonut2']['PARAM3'] = $p3;

				$a4 = (array_map(null, ...$data['graficaResumenDonut2']['PARAM4']));
				$p4 = $a4[0];
				$data['graficaResumenDonut2']['PARAM4'] = $p4;

				$param5 =(array_map(null, ...$data['graficaResumenDonut2']['PARAM5']));
				$data['graficaResumenDonut2']['PARAM5'] = $param5;	
			}

            /*/////////////////////grafica tipo pie/////////////////////////*/
			if(!empty($data['graficaResumenPie'])) {
				$a3= (array_map(null, ...$data['graficaResumenPie']['PARAM3']));
				$p3 =$a3[0];
				$data['graficaResumenPie']['PARAM3'] = $p3;

				$a4 = (array_map(null, ...$data['graficaResumenPie']['PARAM4']));
				$p4 = $a4[0];
				$data['graficaResumenPie']['PARAM4'] = $p4;

				$param5 =(array_map(null, ...$data['graficaResumenPie']['PARAM5']));
				$data['graficaResumenPie']['PARAM5'] = $param5;	
			}

			/*/////////////////////grafica tipo pie 2 /////////////////////////*/
			if(!empty($data['graficaResumenPie2'])) {
				$a3= (array_map(null, ...$data['graficaResumenPie2']['PARAM3']));
				$p3 =$a3[0];
				$data['graficaResumenPie2']['PARAM3'] = $p3;

				$a4 = (array_map(null, ...$data['graficaResumenPie2']['PARAM4']));
				$p4 = $a4[0];
				$data['graficaResumenPie2']['PARAM4'] = $p4;

				$param5 =(array_map(null, ...$data['graficaResumenPie2']['PARAM5']));
				$data['graficaResumenPie2']['PARAM5'] = $param5;	
			}

     

			$this->views->getView($this,"resumen",$data);
			

		}
    }
?>