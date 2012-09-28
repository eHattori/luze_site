<?php
class EmpresaController extends EC9_Base{
	
	public function __construct(){
		parent::__construct();
		$this->load->model("IdiomaModel", "model_idioma");
		$this->load->model("ProdutoModel", "model_produto");
	}
	
	function index(){
		$this->template->set_template("public");
		$this->template->write_view("conteudo", "portal/empresa");
		$this->template->render();
	}
}