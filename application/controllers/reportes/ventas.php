<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//se crea el controlador categorias
class Ventas extends CI_Controller {
//constructor
	public function __construct(){
		parent::__construct();
		$this->load->model("Ventas_model");
    }
    public function index(){
        $fechainicio = $this->input->post("fechainicio");
		$fechafin = $this->input->post("fechafin");
		if ($this->input->post("buscar")) {
			$ventas = $this->Ventas_model->getVentasbyDate($fechainicio,$fechafin);
		}
		else{
			$ventas = $this->Ventas_model->getVentas();
		}
        $data = array(
			"ventas" => $ventas,
			"fechainicio" => $fechainicio,
			"fechafin" => $fechafin
		);
        //$data = array('ventas' => $this->Ventas_model->getVentas());
        $this->load->view("layouts/header");
        $this->load->view("layouts/aside");
        $this->load->view("admin/reportes/ventas",$data);
        $this->load->view("layouts/footer");
    }
}