<?php
/**
 * Controller Contato
 *
 * @author Eduardo Hattori
 * @email eduardo.hattori@hotmail.com
 *
 * Administra os contatos acessados no portal
 *
 */
class ContatoController extends  ControladorBaseAdmin {
		
	public function __construct(){
		parent::__construct();
		$this->load->model("EstadoModel");
		$this->load->model("CidadeModel");
		$this->load->model("ContatoModel");				
	}
	
	public function index(){
		$this->_loadInicial();
	}
	
	public function inserir(){
		$dados = array(
					   "estados"=>$this->EstadoModel->get(new Estado()),
					   "contato"=>new Contato());		
		$this->template->add_script_js("contato/contato_inserir_admin.js");		
		$this->template->write_view("conteudo", "contato/contato_inserir_admin", $dados);
		$this->template->render();		
	}
	
	public function editar($id){
		$contato = $this->ContatoModel->getForId($id);
		$estado  = $this->EstadoModel->get(new Estado());
		$cidades = $this->CidadeModel->getForState(new Cidade(),$contato->estado);
		$cidade  = $this->CidadeModel->getForId($contato->cidade_id);
		
		$dados   = array(
					   "estados"=> $estado,
					   "cidades"=> $cidades,
					   "contato"=> $contato,
					   "cidade" => $cidade);
				
		$this->template->add_script_js("contato/contato_inserir_admin.js");		
		$this->template->write_view("conteudo", "contato/contato_inserir_admin", $dados);
		$this->template->render();		
	}
	
	public function salvar(){
			$post    = $this->input->post();
			$retorno = array();		
			$contato = new Contato();
			
			$contato->preencherObj($post);
			
			$duplicidade = $this->ContatoModel->validaDuplicidade($contato);
			if($duplicidade){
				$retorno['status'] = false;
			} else {
				$retorno['status'] = $this->ContatoModel->save($contato);
				$api = new MCAPI('19f5941fb87fbfce2856575b0c24e842-us5');
				$list_id = "47f24297bf";
				$api->listSubscribe($list_id, $contato->email, '');
			}
			echo json_encode($retorno);
			exit;
	}
	
	public function ajaxcarregacidade(){
		$uf = $this->input->post("id");
		
		$cidades = $this->CidadeModel->getForState(new Cidade(),$uf);		
		echo json_encode($cidades);
		exit;
	}
	
	public function ajaxvisualizar(){
		$id = $this->input->post("id");
		
		$contato  = $this->ContatoModel->getForId($id);
		echo json_encode($contato);
		exit;
	}
	
	public function ajaxconsultar(){
		$dados 			= $this->input->get();
		$result['total']= count($this->ContatoModel->pesquisar($dados));
		$result['data']	= array();
		$contatos  		= $this->ContatoModel->pesquisar($dados, true);
		foreach($contatos as $key => $item){
			$result['data'][$key][1] = $item->contato_id;
			$result['data'][$key][2] = htmlspecialchars($item->nome);
			$result['data'][$key][3] = htmlspecialchars($item->email);
			$result['data'][$key][4] = $this->_create_action($item->contato_id);
		}
		echo json_encode($result);
	}
	
	public function ajax_excluir(){
		$id 					= $this->input->post("id");
		$contato 				= new Contato();
		$contato->contato_id 	= $id;
		echo json_encode(array("status" => $this->ContatoModel->delete($contato))); 
	}
	
	private function _loadInicial(){
		$this->template->add_js("plugins/jgrid.js");		
		$this->template->add_script_js("contato/contato_listar_admin.js");
		$this->template->write_view("conteudo", "contato/contato_listar_admin", array());
		$this->template->render();		
	}
	
	private function _create_action($id){
		return '<a id="visualizar_grid_'.$id.'" onclick="return false;" href="#" title="Visualizar">'.
					'<i class="icon-search"></i>'.
				'</a>'.
				'<a id="editar_grid_'.$id.'" href="'.site_url("admin/contatocontroller/editar/".$id).'" title="Editar">'.
					'<i class="icon-edit"></i>'.
				'</a>'.
				'<a id="excluir_grid_'.$id.'" onclick="return false;" href="#" title="Excluir">'.
					'<i class="icon-remove-sign"></i>'.
				'</a>';
	}
}