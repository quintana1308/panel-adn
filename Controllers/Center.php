<?php

require_once('Models/TablaModel.php');
class Center extends Controllers
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        //session_regenerate_id(true);
        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . '/login');
        }

        //error_reporting(0);
        getPermisos(1);
    }

    public function center($params)
    {

        $tabla = new TablaModel();

        $idKpiCenter = $this->model->getKpiDasbhoard($_SESSION['userData']['ID_DASHBOARD']);

        
        $id_kpi = intval($params);
        $data['page_id'] = 7;
        $data['page_tag'] = "center";
        $data['page_title'] = "center";
        $data['page_name'] = "tabla";
        $data['page_functions_js'] = "functions_center.js";

        $data['kpi'] = $tabla->selectkpi($idKpiCenter);

        if ($data['kpi']['FILTER'] == 1) {
                
            $data['filtros'] = $tabla->selectFilter($data['kpi']['ID_KPI_DD']);
        } else {
           
            $data['filtros'] = $tabla->selectFilter($id_kpi);
        }
        
        

        if ($idKpiCenter != 0) {

            $this->views->getView($this, "center", $data);
        } else {

            require_once 'Controllers/Error.php';

            $error = new Error();

            $error->views->getView("error", "error");
        }

    }

    public function getCenterData()
    {

        $tabla = new TablaModel();

        $_GET['where'] = $_POST['cwhere'];


        $data = $tabla->selectkpi($_POST['kpi']);

        echo json_encode($data, JSON_UNESCAPED_UNICODE);

        die();
    }
}
