<?php
class MainController extends EC9_Base{
	
	public function __construct(){
		parent::__construct();
		$this->load->model("IdiomaModel", "model_idioma");
		$this->load->model("ProdutoModel", "model_produto");
	}
	
	public function index(){
		$this->_render_portal_inicial();
	}
	
	public function set_idioma($idioma){
		$_SESSION['idioma'] = $idioma;
		redirect($_SERVER['HTTP_REFERER'], "refresh");
	}
	
	
	private function _render_portal_inicial(){
		$this->load->model("idiomamodel");
		$firstLanguage 		= $this->idiomamodel->getFirstLanguage();
		$params['idioma']	= @$firstLanguage->idioma_id;
		$params['order_by'] = array("campo" => "produto_id", "sentido" => "desc");
		$params['limit'] 	= 3;
		$params['offset'] 	= 0;
		$params['with_only_image'] = true;
		$produtos = $this->model_produto->get_produtos_portal($params, true);
		
		$dados = array("produtos"=>$produtos);
		$this->template->write_view("conteudo", "main/main_portal", $dados);
		$this->template->render();		
	}
}