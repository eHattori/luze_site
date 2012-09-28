<?php
class GaleriaController extends ControladorBaseAdmin{
	function __construct(){
		parent::__construct();
		$this->load->helper("form");
	}
	
	function index(){
		$this->template->add_js("plugins/jgrid.js");
		$this->template->add_js("scripts/galeria/galeria_index.js");
		$this->_render("galeria/galeria_index");
	}

	function incluir(){
		$dados['tipo'] = $this->_drop_down_tipo();
		$this->_addRecursos();
		$this->_render("galeria/galeria_manter", $dados);
	}

	function alterar($id){
		$this->load->model("galeriamodel");
		$dados['galeria'] 	= $this->galeriamodel->get_by_id($id);
		$dados['imagem']	= strcasecmp($dados['galeria']->tipo, "F") == 0 ? md5($id).".png" : "";
		$dados['tipo'] = $this->_drop_down_tipo($dados['galeria']->tipo);
		$this->_addRecursos();
		$this->_render("galeria/galeria_manter", $dados);
	}

	function salvar(){
		$this->load->model("galeriamodel");
		$post 		= $this->input->post();
		$galeria	= new Galeria();
		$galeria->galeria_id 	= $post['galeria_id'];
		$galeria->descricao	 	= $post['descricao'];
		$galeria->tipo			= $post['tipo'];
		$galeria->name_arquivo	= $post['name_arquivo'];
		$new		= ! $galeria->galeria_id;
		$this->galeriamodel->save($galeria);
		if($new  || $post["imagem"] != $post["imagem_old"]){
			@copy(UPLOAD_TMP.$post["imagem"], UPLOAD_GALERIA.md5($galeria->galeria_id).".png");
		}
		if($post["imagem_old"] && $post["name_arquivo"]){
			delete_file("galeria/", md5($galeria->galeria_id).".png");
		}
		echo json_encode(array("status" => true));
	}

	function ajax_consultar(){
		$this->load->model("galeriamodel");
		$retorno['total'] 	= $this->galeriamodel->get_itens_galeria();
		$retorno['data']	= array();
		$galeria			= $this->galeriamodel->get_itens_galeria($this->input->get(), true);
		foreach($galeria as $key => $item){
			$retorno['data'][$key][1] = htmlspecialchars($item->descricao);
			$retorno['data'][$key][2] = strcasecmp($item->tipo, "F") == 0 ? "Foto" : "Vídeo";
			$retorno['data'][$key][3] = $this->_create_action($item->galeria_id);
		}
		echo json_encode($retorno);
	}

	function excluir(){
		$this->load->model("galeriamodel");
		$post 				= $this->input->post();
		$galeria 			= new Galeria();
		$galeria->galeria_id= $post['galeria_id'];
		$this->galeriamodel->delete($galeria);
		delete_file("galeria/", md5($post['galeria_id']).".png");
		echo json_encode(array("status" => true));				
	}

	private function _render($pagina, $dados = array()){
		$this->template->write_view("conteudo", $pagina, $dados);
		$this->template->render();
	}

	private function _addRecursos(){
		$this->template->add_js("plugins/vendor/jquery.ui.widget.js");
		$this->template->add_js("plugins/jquery.iframe-transport.js");
		$this->template->add_js("plugins/jquery.fileupload.js");
		$this->template->add_js("scripts/galeria/galeria_manter.js");
		$this->template->add_css("jquery.fileupload-ui.css");
	}

	private function _create_action($id){
		return '<a href="'.site_url("admin/galeriacontroller/alterar/".$id).'" title="Editar"><span class="icon-edit"></span></a>'.
				'<a href="#" id="btnExcluir_'.$id.'" onclick="return false;" title="Excluir"><span class="icon-remove-sign"></span></a>';
	}
	
	private function _drop_down_tipo($selected = ""){
		$options["F"] = "Foto";
		$options["V"] = "Vídeo"; 
		return form_dropdown("tipo", $options, $selected, 'id="tipo"');
	}
}