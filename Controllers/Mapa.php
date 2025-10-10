<?php 
    class Mapa extends Controllers{
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

        public function mapa()
		{
			$grupos    	= array();
			$productos 	= array();
			$vendedores = array();
			$estados = array();
			$municipios = array();
			$clientes = array();
			$transportistas = array();
			

			$start = !empty($_GET['start']) ? $_GET['start'] : '' ;
			$end = !empty($_GET['end']) ? $_GET['end'] : '' ;
			
			if(isset($_GET['grupos'])) {

     		   $grupos = is_array($_GET['grupos']) ? $_GET['grupos'] : explode(',', $_GET['grupos']);
		    }

		    if(isset($_GET['productos'])) {
     		   $productos = is_array($_GET['productos']) ? $_GET['productos'] : explode(',', $_GET['productos']);
		    }

		    if(isset($_GET['vendedores'])) {
     		   $vendedores = is_array($_GET['vendedores']) ? $_GET['vendedores'] : explode(',', $_GET['vendedores']);
		    }

		    if(isset($_GET['estados'])) {
     		   $estados = is_array($_GET['estados']) ? $_GET['estados'] : explode(',', $_GET['estados']);
		    }

		    if(isset($_GET['municipios'])) {
     		   $municipios = is_array($_GET['municipios']) ? $_GET['municipios'] : explode(',', $_GET['municipios']);
		    }

			if(isset($_GET['clientes'])) {
     		   $clientes = is_array($_GET['clientes']) ? $_GET['clientes'] : explode(',', $_GET['clientes']);
		    }

			if(isset($_GET['transportistas'])) {
     		   $transportistas = is_array($_GET['transportistas']) ? $_GET['transportistas'] : explode(',', $_GET['transportistas']);
		    }

            $frecuencia = [];
            $semana = [];
            $diavisita = [];

		    if(isset($_GET['frecuencia'])) {
     		   $frecuencia = is_array($_GET['frecuencia']) ? $_GET['frecuencia'] : explode(',', $_GET['frecuencia']);
		    }

		    if(isset($_GET['semana'])) {
     		   $semana = is_array($_GET['semana']) ? $_GET['semana'] : explode(',', $_GET['semana']);
		    }

		    if(isset($_GET['diavisita'])) {
     		   $diavisita = is_array($_GET['diavisita']) ? $_GET['diavisita'] : explode(',', $_GET['diavisita']);
		    }

			
			$grupos    			= is_array($grupos) 	? array_map(function($grupo) 	 { return "'$grupo'"; }, $grupos) 		   : array();
			$productos 			= is_array($productos) 	? array_map(function($producto)  { return "'$producto'"; }, $productos)    : array();//return '001','002','003'
			$vendedores 		= is_array($vendedores) ? array_map(function($vendedor)  { return "'$vendedor'"; }, $vendedores)   : array();//return '001','002','003'
			$estados 			= is_array($estados) 	? array_map(function($estado) 	 { return "'$estado'"; }, $estados) 	   : array();//return '001','002','003'
			$municipios 		= is_array($municipios) ? array_map(function($municipio) { return "'$municipio'"; }, $municipios) : array();//return '001','002','003'
			$clientes 			= is_array($clientes) 	? array_map(function($cliente)   { return "'$cliente'"; }, $clientes) 	   : array();//return '001','002','003'
			$transportistas 	= is_array($transportistas) 	? array_map(function($transportista)   { return "'$transportista'"; }, $transportistas) 	   : array();//return '001','002','003'
			$frecuencia 		= is_array($frecuencia) ? array_map(function($frecuencia){ return "'$frecuencia'"; }, $frecuencia) : array();//return '001','002','003'
			$semana     		= is_array($semana)     ? array_map(function($semana)    { return "'$semana'"; }, $semana) : array();//return '001','002','003'
			$diavisita  		= is_array($diavisita)  ? array_map(function($diavisita) { return "'$diavisita'"; }, $diavisita) : array();//return '001','002','003'

		

			$data['page_id'] = 1;
			$data['page_tag'] = "mapa";
			$data['page_title'] = "Mapa";
			$data['page_name'] = "mapa";
			$data['page_functions_js'] = "functions_mapa.js";
			$data['grupos'] = $this->model->selectGrupos();
			$data['vendedores'] = $this->model->selectVendedores();
			$data['estados'] = $this->model->selectEstados();
			$data['municipios'] = $this->model->selectMunicipios();
			$data['clientes'] = $this->model->selectClientes();
			$data['transportistas'] = $this->model->selectTransportistas();
			$data['frecuencia'] = $this->model->selectFrecuencia();
			$data['semana'] = $this->model->selectSemana();
			$data['diavisita'] = $this->model->selectDiaVisita();

			$data['mapa'] = $this->model->selectDataMapa($start, $end, $grupos, $productos, $vendedores, $estados, $municipios, $clientes, $transportistas, $frecuencia, $semana, $diavisita) 
								? $this->model->selectDataMapa($start, $end, $grupos, $productos, $vendedores, $estados, $municipios, $clientes, $transportistas, $frecuencia, $semana, $diavisita)
								: array();


			if(isset($_GET['debug'])){
				echo 'PARAM2'; 
				dep($data['mapa']);
			}

			
			$data['cards'] = $this->model->selectDataInfo($start, $end, $grupos, $productos, $vendedores, $estados, $municipios, $clientes, $transportistas, $frecuencia, $semana, $diavisita) 
								? $this->model->selectDataInfo($start, $end, $grupos, $productos, $vendedores, $estados, $municipios, $clientes, $transportistas, $frecuencia, $semana, $diavisita)
								: array() ;

			if(isset($_GET['debug'])){
				echo 'PARAM3';
				dep($data['cards']); die();
			}
			$this->views->getView($this,"mapa",$data);
			

		}

        public function getProductosByGrupos(){

			if(empty($_POST['grupos'])){
				$_POST['grupos'] = array();
			}else{
				$_POST['grupos'] = array_map(function($grupo) { return "'$grupo'"; }, $_POST['grupos']);
			}
			
			//dep($_POST['grupos']);
			echo json_encode($this->model->selectProductosGrupo($_POST['grupos']),JSON_UNESCAPED_UNICODE);
		}

		public function getMunicipiosByEstado(){

			if(empty($_POST['estados'])){
				$_POST['estados'] = array();
			}else{
				$_POST['estados'] = array_map(function($estado) { return "'$estado'"; }, $_POST['estados']);
			}
			echo json_encode($this->model->selectMunicipiosEstado($_POST['estados']),JSON_UNESCAPED_UNICODE);
		}

		public function getClientesByEstados(){

			if(empty($_POST['estados'])){
				$_POST['estados'] = array();
			}else{
				$_POST['estados'] = array_map(function($estado) { return "'$estado'"; }, $_POST['estados']);
			}

			echo json_encode($this->model->selectClientesEstado($_POST['estados']),JSON_UNESCAPED_UNICODE);
		}

		public function getClientesByMunicipios(){

			$_POST['municipios'] = array_map(function($municipio) { return "'$municipio'"; }, $_POST['municipios']);

			echo json_encode($this->model->selectClientesMunicipios($_POST['municipios']),JSON_UNESCAPED_UNICODE);
		}

        public function setMapa(){

			if($_POST){
				
				$start = $_POST['start'];
				$end = $_POST['end'];
				$grupo = $_POST['grupos'];
				$producto = $_POST['productos'];
				$vendedor = $_POST['vendedores'];

				$dataMapa = $this->model->selectDataMapa($start, $end, $grupo, $producto, $vendedor);
				//dep($dataMapa); die();

				if(!empty($dataMapa)){
					$arrResponse = array('status' => true, 'data' => $dataMapa);
				} else {
					$arrResponse = array('status' => false, 'msg' => 'no se encontraron datos');
				}

				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			
			die();
		}
    }
?>