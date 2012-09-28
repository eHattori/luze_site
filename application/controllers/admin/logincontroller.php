<?php
/**
 * Controller Login
 *
 * @author Eduardo Hattori
 * @email eduardo.hattori@hotmail.com
 *
 * Login e Logout 
 *
 */
class LoginController extends  EC9_Base {
		
	public function __construct(){
		parent::__construct();			
		$this->template->set_template("admin");			
	}
	
	public function index(){
		$this->template->add_script_js("login/login.js");
		$this->template->write_view("conteudo", "login/login", array());
		$this->template->render();
	}
	
	public function logar(){
		
		$email = $this->input->post("email");
		$senha = $this->input->post("senha");
		
		if($email && $senha){
			$this->load->model("UsuarioModel");
			$usuario = $this->UsuarioModel->logar($email,@hash(sha256, $senha));
			
			if(@$usuario['usuario_id']){
				$_SESSION['user'] = $usuario;
				echo 1;
				exit;
			}
			echo 0;
			exit;
		}
	}
	
	public function logout() 
	{
		session_destroy();
		ob_start();
		header("Location: ".site_url()."admin/logincontroller");		
		exit;
	}   
}
