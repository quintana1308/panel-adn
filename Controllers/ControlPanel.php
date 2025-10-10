<?php 

class ControlPanel extends Controllers{
	public function __construct()
	{
		parent::__construct();
		session_start();
		//session_regenerate_id(true);
		if(empty($_SESSION['login']))
		{
			header('Location: '.base_url().'/login');
		}
		 getPermisos(1);
	}

    public function controlPanelDesing()
    {

        $this->views->getView($this,"desingControlPanel");

    }

    public function controlPanelView()
    {

        $data['page_id'] = 2;
        $data['page_tag'] = "Panel de Control";
        $data['page_title'] = "Panel de Control";
        $data['page_name'] = "tabla";
        $data['graficaDashboardLine'] = $this->model->selectLineParams();
        $data['graficaDashboardColumn'] = $this->model->selectColumnParams();
        $data['graficaDashboardDonut'] = $this->model->selectDonutParams();
        $data['graficaDashboardPie'] = $this->model->selectPieParams();

        
        $stimulDashGet = $this->model->getStimulDash(1);

        /*$data['dataxml1'] = $data['graficaDashboardLine'];
        $data['dataxml2'] = $data['graficaDashboardPie'];*/
        
        $data['nameArchive'] =  $stimulDashGet['ARCHIVO'];
        $data['reportId'] = 1;
        $data['dataReport'] = $stimulDashGet;

        $this->views->getView($this,"viewControlPanel", $data);
    }

    public function controlPanelSave()
    {
        // Recibir los datos enviados por AJAX
        $data = json_decode(file_get_contents("php://input"), true);

        $report = $data['report'];
        $reportName = $data['reportName'];
        $name = $data['Name'];
        $reportDescription = $data['reportDescription'];

        $response = $this->model->saveControlPanel($report, $reportName, $name, $reportDescription);

        echo json_encode(['status' => $response['status'], 'message' => $response['message']]);

    }
}

?>