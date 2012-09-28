<?php
class ProdutosController extends EC9_Base{
	public function __construct(){
		parent::__construct();
		$this->load->model("ProdutoModel", "model_produto");
		$this->load->model("CategoriaModel", "model_categoria");
	}

	function index(){		
		$this->template->set_template("public");
		if(isset($_SESSION['idioma'])){
			$idioma = $_SESSION['idioma'];
		}else{
			$this->load->model("idiomamodel");
			$firstLanguage 	= $this->idiomamodel->getFirstLanguage();
			$idioma 		= @$firstLanguage->idioma_id;
		}		
		$categorias = $this->model_categoria->get_categorias_idioma($idioma);
		$this->load->library('EC9_Pagination');		

		$queryString			= parse_url($_SERVER['REQUEST_URI']);
		@parse_str($queryString['query'], $params);
		$params['limit']		= 10;
		$params['idioma'] 		= $idioma;
		$params['offset']		= $this->uri->segment(3) ? $this->uri->segment(3) : '';
		$config['base_url']   	= site_url()."produtoscontroller/index/";
		$config['total_rows'] 	= count($this->model_produto->get_produtos_portal($params));
		$config['per_page']   	= $params['limit'];
		$config['enable_params'] = true;
		$config['params_query_string'] = @$queryString['query'];


		$this->ec9_pagination->initialize($config);

		$produtos  = $this->model_produto->get_produtos_portal($params, true);
		$paginacao =  $this->ec9_pagination->create_links();

		$dados = array(
						"categorias" =>$categorias,
						"produtos"   =>$produtos,
						"paginacao"  =>$paginacao);

		$this->template->write_view("conteudo", "produto/produtos_view", $dados);
		$this->template->render();
	}

	function visualizar($id){
		$this->template->set_template("public");
		if(isset($_SESSION['idioma'])){
			$params['idioma']	= $_SESSION['idioma'];
		}else{
			$this->load->model("idiomamodel");
			$firstLanguage 		= $this->idiomamodel->getFirstLanguage();
			$params['idioma']	=  @$firstLanguage->idioma_id;
		}
		$params['id'] 		= $id;
		
		$produto 			= $this->model_produto->get_produto_id_portal($params);
		$dados   			= array("produto"=>$produto);
		$dados['url_voltar']= isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : site_url("produtoscontroller"); 

		$this->template->add_js("plugins/bootstrap-modal.js");
		$this->template->add_js("scripts/produto/produto_detalhe_portal.js");
		$this->template->write_view("conteudo", "produto/produto_visualizar", $dados);
		$this->template->render();
	}
	
	function download_manual($id){
		$this->load->helper("download");
		$produto 	= $this->model_produto->get_by_id($id);
		$conteudo 	= file_get_contents(UPLOAD_MANUAIS.md5($id).".pdf");
		force_download($produto->manual, $conteudo);		
	}
}
