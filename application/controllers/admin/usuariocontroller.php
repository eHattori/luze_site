<?php
class UsuarioController extends ControladorBaseAdmin{
	
	public function __construct(){
		parent::__construct();		
	}
	
	public function index(){
		$this->template->add_js("scripts/usuario/usuario_manter.js");
		$this->template->write_view("conteudo", "usuario/usuario_manter", array());
		$this->template->render();	
	}
	
	public function salvar(){
		$this->load->model("usuariomodel");
		$usuario = new Usuario();
		$usuario->preencherObj($this->input->post());
		
		if($this->usuariomodel->verificaUsuarioExistente($this->input->post('email'), $this->input->post("usuario_id"))){
			$status = false;
		}else{
			if(isset($usuario->senha) && $usuario->senha){
				$usuario->senha = hash("sha256", $usuario->senha);	
			}else{
				unset($usuario->senha);
			}
			$status = $this->usuariomodel->save($usuario);
			if($_SESSION['user']['usuario_id'] == $usuario->usuario_id){
				$_SESSION['user']['nome'] = $usuario->nome;	
			}
		}
		echo json_encode(array("status" => $status));
	}
	
	public function alterar_usuario_logado(){
		$this->load->model("usuariomodel");
		$dados['usuario'] = $this->usuariomodel->getUsuarioId($_SESSION['user']['usuario_id']);
		$this->template->add_js("scripts/usuario/usuario_manter.js");
		$this->template->write_view("conteudo", "usuario/usuario_manter", $dados);
		$this->template->render();
	}
}