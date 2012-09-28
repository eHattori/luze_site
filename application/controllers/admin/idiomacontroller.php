<?php
class IdiomaController extends ControladorBaseAdmin{
	function index(){
		$this->load->model("idiomamodel");
		$dados['idiomas'] = $this->idiomamodel->getIdiomas();
		$this->template->add_js("scripts/idioma/idioma_index.js");
		$this->_render("idioma/idioma_index", $dados);
	}

	public function incluir(){
		$this->_addRecursos();
		$this->_render("idioma/idioma_manter");
	}

	public function alterar($id = ""){
		$this->load->model("idiomamodel");
		$dados["idioma"] = $this->idiomamodel->getIdiomaId($id);
		$dados["imagem"] = md5($dados["idioma"]->idioma_id).".png"; 
		$this->_addRecursos();
		$this->_render("idioma/idioma_manter", $dados);
	}

	function salvar(){
		$this->load->model("idiomamodel");
		$idioma = new Idioma();
		$post	= $this->input->post();
		$idioma->preencherObj($post);
		$new	= ! $idioma->idioma_id;
		$status	= $this->_validaIdioma($idioma) ? $this->idiomamodel->save($idioma) : false;
		if($new  || $post["imagem"] != $post["imagem_old"]){
			@copy(UPLOAD_TMP.$post["imagem"], UPLOAD_BANDEIRA.md5($idioma->idioma_id).".png");
		} 
		echo json_encode(array("status" => $status));
	}
	
	function excluir(){
		$this->load->model("idiomamodel");
		$idioma 			= new Idioma();
		$idioma->idioma_id 	= $this->input->post("idioma_id");
		if($this->idiomamodel->delete($idioma)){
			$status = true;
			delete_file("idiomas/", md5($idioma->idioma_id).".png");
		}else{
			$status = false;
		}
		echo json_encode(array("status" => $status));
	}

	function _render($pagina, $dados = array()){
		$this->template->write_view("conteudo", $pagina, $dados);
		$this->template->render();
	}
	
	function _addRecursos(){
		$this->template->add_js("plugins/vendor/jquery.ui.widget.js");
		$this->template->add_js("plugins/jquery.iframe-transport.js");
		$this->template->add_js("plugins/jquery.fileupload.js");
		$this->template->add_js("scripts/idioma/idioma_manter.js");
		$this->template->add_css("jquery.fileupload-ui.css");
	}
	
	function _validaIdioma($idioma){
		$this->load->model("idiomamodel");
		return $this->idiomamodel->validaIdiomaSigla($idioma);
	}
}