<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
//constructor donde se carga el modelo de usuarios
	public function __construct(){
        parent::__construct();//Con parent se hereda 
        $this->load->model("Usuarios_model"); // con load se cargan archivos
    }
/*================FUNCION DE INDEX================*/
	public function index()
	{
//si el usuario establece inicio de sesion 
        if ($this->session->userdata("login")) {
//se le direcciona a la vista del dashboard         
            redirect(base_url()."dashboard");
        }
        else{
//si no establece sesion se vuelve a la vista de login
        $this->load->view('admin/login');
        }

    }
/*================FUNCION DE INICIO DE SESION================*/
    public function login(){
        $username = $this->input->post("username");//se envian los datos por medio de la clase input metodo de envio post
        $password = $this->input->post("password");
        $res= $this->Usuarios_model->login($username, sha1($password));
//si se retorna un valor falso en el resultado
        if (!$res) {
//establecer un mensaje de validacion
            $this->session->set_flashdata("error","El usuario y/o contraseña son incorrectos");
//redireccionar a la vista de login
            redirect(base_url());
        }
        else{
//se almacenan en un vector los datos de usuario
            $data = array(
                'id' => $res->id,
                'nombre' => $res->nombres,
                'rol'=> $res->rol_id,
                'login'=> true
            );
//se establece la sesion con el vector anterior
            $this->session->set_userdata($data);
/*se redirecciona a la vista del dashboard si el usuario se
loguea correctamente*/
            redirect(base_url()."dashboard");
        }
    }

/*================FUNCION DE CIERRE DE SESION================*/
    public function logout(){
//aqui se elimina todas las sesiones
        $this->session->sess_destroy();
//se redirecciona la vista del login
        redirect(base_url());
    }
}
