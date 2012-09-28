<?php
class ContatoController extends EC9_Base{
	function __construct(){
		parent::__construct();
		$this->load->helper("form");
	}

	function index(){
		$dados['estados'] = $this->_drop_down_estados();
		$this->template->add_js("libs/jquery.form.js");
		$this->template->add_js("libs/jquery.validate.js");
		$this->template->add_js("libs/jquery.maskedinput.js");
		$this->template->add_js("plugins/bootstrap-alert.js");
		$this->template->add_js("plugins/util_validate.js");
		$this->template->add_js("plugins/uteis.js");
		$this->template->add_js("plugins/MI.js");
		$this->template->add_js("scripts/portal/contato.js");
		$this->template->write_view("conteudo", "portal/contato", $dados);
		$this->template->render();
	}

	function enviar(){
		$this->load->model("contatomodel");
		$contato 			= new Contato();
		$post				= $this->input->post();
		$contato->nome 		= $post['nome'];
		$contato->email		= $post['email'];
		$contato->endereco 	= $post['endereco'];
		$contato->telefone	= $post['telefone'];
		$contato->cidade_id	= $post['cidade_id'] ? $post['cidade_id'] : NULL;

		$duplicidade = $this->contatomodel->getForEmail($contato->email);
		if( ! $duplicidade){
			$api = new MCAPI('19f5941fb87fbfce2856575b0c24e842-us5');
			$list_id = "47f24297bf";
			$api->listSubscribe($list_id, $contato->email, '');
		}else{
			$contato->contato_id = $duplicidade->contato_id;	
		}
		if(enviar_email($post['assunto'], $this->load->view("template/mensagem",$post, true))){
			$retorno['status'] 	= true;
			$retorno['mensagem']= "Mensagem enviada com sucesso";
		}else{
			$retorno['status'] = false;
			$retorno['mensagem']= "Erro ao enviar mensagem";
		}
		$this->contatomodel->save($contato);
		echo json_encode(array("status" => $retorno['status'], "msg" => $retorno['mensagem']));
	}

	function ajax_get_cidades(){
		$id = $this->input->post("id_estado");
		echo $this->_drop_down_cidades($id);
	}

	private function _drop_down_estados(){
		$this->load->model("EstadoModel");
		$estados  	= $this->EstadoModel->get(new Estado());
		$options 	= array("" => "Selecione");
		foreach($estados as $item){
			$options[$item->id] = $item->sigla." - ".$item->nome;
		}
		return form_dropdown("estados", $options, "", 'id="estados" style="width:174px"');
	}

	private function _drop_down_cidades($id_estado){
		$this->load->model("CidadeModel");
		$estado = $id_estado;
		$cidades = $this->CidadeModel->getForState(new Cidade(), $estado);
		$options 	= array("" => "Selecione");
		foreach($cidades as $item){
			$options[$item->id] = $item->nome;
		}
		return form_dropdown("cidade_id", $options, "", 'id="cidade_id" style="width:174px"');
	}
}