<?php
class CategoriaController extends ControladorBaseAdmin{

	public function __construct(){
		parent::__construct();
		$this->load->model("idiomamodel");
		$this->load->model("dicionariomodel");
		$this->load->model("categoriamodel");

	}

	var $dados = array();
	
	public function index(){

		$this->dados['categorias'] = $this->categoriamodel->getCategorias();
		$categorias = array();
		$controle   = "";
		
		foreach ($this->dados['categorias'] as $item){
			
			if($item->descricao_id == $controle){
				$categorias[$item->descricao_id] .=  "/". $item->texto;
			}else{
				$categorias[$item->descricao_id] = $item->texto;
			}
			$controle = $item->descricao_id;
		}
		
		$this->dados['categorias'] = $categorias;
		
		
		$this->_montaPagina("categoria_index");
	}
	
	public function incluir(){
		
		$this->dados['idiomas'] = $this->idiomamodel->getIdiomas();
		$this->_montaPagina("categoria_manter");
	}
	
	public function excluir($descricao_id){
		
		$sucesso = false;
		if(!$this->categoriamodel->verificaRelacionamento($descricao_id)){
			$this->categoriamodel->excluir($descricao_id);
			$sucesso = true;
		}else{
			$sucesso = false;
		}
		
		echo json_encode($sucesso);
		
	}
	
	public function alterar($descricao_id){
		
		$this->dados['idiomas']    = $this->idiomamodel->getIdiomas();
		$this->dados['categorias'] = $this->categoriamodel->getCategoria($descricao_id);
		
		
		foreach ($this->dados['idiomas'] as $idioma){
			foreach ($this->dados['categorias'] as $categoria){
				if($idioma->idioma_id == $categoria->idioma_id){
					$idioma->texto = $categoria->texto;
					$idioma->descricao_id = $categoria->descricao_id;
				}
			}
		}
		
		$this->dados['descricao_id']   = $this->dados['categorias'][0]->descricao_id;
		$this->dados['dicionario_key'] = $this->dados['categorias'][0]->dicionario_key;
		
		$this->_montaPagina("categoria_manter");
				
	}

	public function salvar(){

		$idiomasExistentes = $this->idiomamodel->getIdiomas();
		$dicionario_key    = $this->dicionariomodel->recuperaUltimaKey() + 1;

		$this->db->trans_begin();

		$descricao_id = $this->input->post("descricao_id");
		
		foreach ($idiomasExistentes as $rowIdioma){
				
			$texto = trim($this->input->post('idioma_'.$rowIdioma->idioma_id));
				
			if(!empty($texto)){
				
				if($this->input->post('dicionario_key')){
					$dicionario['dicionario_key'] = $this->input->post('dicionario_key');
				}else{
					$dicionario['dicionario_key'] = $dicionario_key;
				}
				$dicionario['idioma_id'] 	  = $rowIdioma->idioma_id;
				$dicionario['texto'] 		  = $texto;
				
				if(!$descricao_id){
					$this->dicionariomodel->salvar($dicionario);
				}else{
					$this->dicionariomodel->saveOrUpdate($dicionario);
				}
				
			}
		}

		$categoria = new Categoria();
		$categoria->descricao_id = $dicionario_key;
		
		if(!$descricao_id){
			$this->categoriamodel->save($categoria);
		}

		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			echo 0;
		}
		else{
			$this->db->trans_commit();
			echo 1;
		}
	}
	
	private function _montaPagina($view_js){
		$this->template->add_js("scripts/categoria/".$view_js.".js");
		$this->template->write_view("conteudo", "categoria/".$view_js, $this->dados);
		$this->template->render();
	}
}