<?php
class EspecificacaoController extends ControladorBaseAdmin{

	public function __construct(){
		parent::__construct();
		$this->load->model("idiomamodel");
		$this->load->model("dicionariomodel");
		$this->load->model("especificacaomodel");

	}

	public function index(){
		$this->template->add_js("plugins/jgrid.js");
		$this->template->add_js("scripts/especificacao/especificacao_index.js");
		$this->template->write_view("conteudo", "especificacao/especificacao_index");
		$this->template->render();
	}

	function ajax_consultar(){
		$this->load->model("especificacaomodel");
		$retorno['total'] 	= count($this->especificacaomodel->getEspeficicacoes());
		$especificacoes		= $this->especificacaomodel->getEspeficicacoes($_GET);
		foreach($especificacoes as $key => $item){
			$retorno['data'][$key][1] = htmlspecialchars($item->descricao);
			$retorno['data'][$key][2] = $this->_create_action($item->especificacao_id);
		}
		echo json_encode($retorno);
	}

	public function incluir(){
		$this->_render_manter();
	}

	public function alterar($id){
		$dados['especificacao'] = $this->especificacaomodel->getEspeficicaoId($id);
		$this->_render_manter($dados);
	}

	public function excluir(){
		$post 			= $this->input->post();
		$especificacao 	= new Especificacao();
		$especificacao->especificacao_id = $post['especificacao_id'];
		echo json_encode(array("status" => $this->especificacaomodel->delete($especificacao)));
	}
	
	public function salvar(){

		$idiomasExistentes = $this->idiomamodel->getIdiomas();
		$dicionario_key    = $this->dicionariomodel->recuperaUltimaKey() + 1;

		$this->db->trans_begin();

		$especificacao 						= new Especificacao();
		$especificacao->especificacao_id	= $this->input->post('especificacao_id');
		$this->especificacaomodel->delete_relationship($especificacao);
		$especificacao->descricao_id 		= $dicionario_key;
		foreach ($idiomasExistentes as $rowIdioma){

			$texto = trim($this->input->post('idioma_'.$rowIdioma->idioma_id));

			if(!empty($texto)){

				$dicionario['dicionario_key'] 	= $dicionario_key;
				$dicionario['idioma_id'] 	  	= $rowIdioma->idioma_id;
				$dicionario['texto'] 			= $texto;

				$this->dicionariomodel->salvar($dicionario);
			}
		}
		$this->especificacaomodel->save($especificacao);

		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			echo 0;
		}
		else{
			$this->db->trans_commit();
			echo 1;
		}

	}

	private function _render_manter($dados = array()){
		$dados['idiomas'] = $this->idiomamodel->getIdiomas();
		$this->template->add_js("scripts/especificacao/especificacao_manter.js");
		$this->template->write_view("conteudo", "especificacao/especificacao_manter", $dados);
		$this->template->render();
	}

	private function _create_action($id){
		return '<a href="'.site_url("admin/especificacaocontroller/alterar/".$id).'" title="Editar"><span class="icon-edit"></span></a>'.
				'<a href="#" id="btnExcluir_'.$id.'" onclick="return false;" title="Excluir"><span class="icon-remove-sign"></span></a>';
	}
}