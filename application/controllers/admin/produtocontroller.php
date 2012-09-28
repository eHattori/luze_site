<?php
class ProdutoController extends ControladorBaseAdmin{
	function index(){
		$this->template->add_js("plugins/jgrid.js");
		$this->template->add_js("scripts/produto/produto_index.js");
		$this->_render("produto/produto_index");
	}

	function ajax_consultar(){
		$this->load->model("produtomodel");
		$retorno['total'] 	= count($this->produtomodel->getProdutos());
		$produtos 			= $this->produtomodel->getProdutos($_REQUEST);
		foreach($produtos as $key => $item){
			$retorno['data'][$key][1] = htmlspecialchars($item->descricao);
			$retorno['data'][$key][2] = $this->_create_action($item->produto_id);
		}
		echo json_encode($retorno);
	}

	function incluir(){
		$dados['categorias'] 	= $this->_getCategorias();
		$dados['idiomas'] 		= $this->_getIdiomas();
		$dados['especificacoes']= $this->_getEspecificacoes();
		$this->_addRecursos();
		$this->_render("produto/produto_manter", $dados);
	}

	function alterar($id=""){
		$dados['produto']		= $this->_getProdutoId($id);
		$dados["manual"] 		= md5($dados["produto"]->produto_id).".png"; 
		$dados['categorias'] 	= $this->_getCategorias($dados['produto']->categoria_id);
		$dados['idiomas'] 		= $this->_getIdiomas();
		$dados['especificacoes']= $this->_getEspecificacoes();
		$this->_addRecursos();
		$this->_render("produto/produto_manter", $dados);
	}

	function excluir(){
		$this->load->model("produtomodel");
		$post 		= $this->input->post();
		$produto 	= $this->produtomodel->getProdutoId($post['produto_id']);
		$this->produtomodel->delete_relationship($produto);
		$imagens = $this->produtomodel->getImagensProdutoId($post['produto_id']);
		foreach($imagens as $item){
			delete_file('produtos/', $item->arquivo);
		}
		delete_file('manuais/', md5($produto->produto_id).".pdf");
		$this->produtomodel->deleteImagem(array("produto_id" => $post['produto_id']));
		echo json_encode(array("status" => $this->produtomodel->delete($produto)));
	}

	function salvar(){
		$this->load->model("idiomamodel");
		$this->load->model("dicionariomodel");
		$this->load->model("produtomodel");
		$idiomas 				= $this->idiomamodel->getIdiomas();

		$post					= $this->input->post();
		$produto 				= new Produto();
		$produto->produto_id	= $post['produto_id'];
		$new					= ! $produto->produto_id;
		$produto->categoria_id 	= $post['categoria_id'];
		$produto->manual	 	= $post['manual'];
		//remove dicionarios antigos
		$produto->descricao_id 	= $post['descricao_id'];
		$this->db->trans_begin();
		$this->produtomodel->delete_relationship($produto);
		//novos dicionarios
		$produto->descricao_id 	= $this->dicionariomodel->recuperaUltimaKey() + 1;
		foreach ($idiomas as $item){
			$idioma = trim($post['idioma_'.$item->idioma_id]);
			if($idioma != ""){
				$dicionario['dicionario_key'] = $produto->descricao_id;
				$dicionario['idioma_id'] 	  = $item->idioma_id;
				$dicionario['texto'] 		  = $idioma;
				$this->dicionariomodel->salvar($dicionario);
			}
		}
		$this->produtomodel->save($produto);
		$especificacoes = json_decode($post['especificacoes_produtos']);
		if($especificacoes){
			foreach($especificacoes as $item){
				$especificacao['produto_id'] 		= $produto->produto_id;
				$especificacao['especificacao_id'] 	= $item->id;
				$especificacao['valor'] 		  	= $item->texto;
				$this->produtomodel->save_relationship($especificacao);
			}
		}
		if($new  || $post["arq_manual"] != $post["arq_manual_old"]){
			@copy(UPLOAD_TMP.$post["arq_manual"], UPLOAD_MANUAIS.md5($produto->produto_id).".pdf");
		} 
		$novasImagens = json_decode($post['imagens']);
		$this->_atualizaImagens($produto->produto_id, $novasImagens);

		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$status = 0;
		}else{
			$this->db->trans_commit();
			$status = 1;
		}
		echo json_encode(array("status" => $status));
	}

	private function _atualizaImagens($idProduto, $novaImagens){
		$this->load->model("produtomodel");
		$imagens = $this->produtomodel->getImagensProdutoId($idProduto);
		$imagensBanco = array();
		$imagensNovas = array();
		$this->produtomodel->deleteImagem(array("produto_id" => $idProduto));
		foreach($imagens as $item){
			$imagensBanco[] = $item->arquivo;
		}
		if($novaImagens){
			foreach($novaImagens as $item){
				$imagensNovas[]			= $item->nome;
				$imagem['produto_id'] 	= $idProduto;
				$imagem['arquivo'] 		= $item->nome;
				$imagem['destaque'] 	= $item->destaque;
				$this->produtomodel->save_image($imagem);
				file_transfer(UPLOAD_TMP.$item->nome, UPLOAD_PRODUTOS.$item->nome);
			}
		}
		$excluirImagens = array_diff($imagensBanco, $imagensNovas);
		foreach($excluirImagens as $item){
			delete_file('produtos/', $item);
		}
	}

	private function _render($pagina, $dados = array()){
		$this->template->write_view("conteudo", $pagina, $dados);
		$this->template->render();
	}

	private function _getCategorias($selected = ""){
		$this->load->model("categoriamodel");
		$this->load->helper("form");
		$categorias = $this->categoriamodel->getDescricoesCategorias();
		$options 	= array("" => "Selecione");
		foreach($categorias as $item){
			$options[$item->categoria_id] = $item->descricao;
		}
		return form_dropdown("categoria_id", $options, $selected, 'id="categoria_id" class="required"');
	}

	private function _addRecursos(){
		$this->template->add_js("plugins/vendor/jquery.ui.widget.js");
		$this->template->add_js("plugins/jquery.iframe-transport.js");
		$this->template->add_js("plugins/jquery.fileupload.js");
		$this->template->add_css("jquery.fileupload-ui.css");
		$this->template->add_js("scripts/produto/produto_manter.js");
	}

	private function _getEspecificacoes(){
		$this->load->model("especificacaomodel");
		$this->load->helper("form");
		$categorias = $this->especificacaomodel->getDescricoesEspecificacoes();
		$options 	= array("" => "Selecione");
		foreach($categorias as $item){
			$options[$item->especificacao_id] = $item->descricao;
		}
		return form_dropdown("especificacao", $options, "", 'id="especificacao" class="required"');
	}

	private function _getIdiomas(){
		$this->load->model("idiomamodel");
		return $this->idiomamodel->getIdiomas();
	}

	private function _getProdutoId($id){
		if($id){
			$this->load->model("produtomodel");
			$produto = $this->produtomodel->getProdutoId($id);
			$especificacoes = array();
			foreach($produto->especificacoes as $item){
				$array = array(
					"id" 			=> $item->especificacao_id,
					"descricao_esp"	=> htmlspecialchars($item->texto),
					"texto"			=> htmlspecialchars($item->valor)
				);
				$especificacoes[] = $array;
			}
			$imagens = array();
			foreach($produto->imagens as $item){
				$destaque = $item->destaque == 1;
				$imagens[] = array("nome" => htmlspecialchars($item->arquivo), "id" => $item->id, "destaque" => $destaque);
			}
			$produto->especificacoes_string = json_encode($especificacoes);
			$produto->imagens_string		= json_encode($imagens);
			return $produto;
		}
	}

	private function _create_action($id){
		return '<a href="'.site_url("admin/produtocontroller/alterar/".$id).'" title="Editar"><span class="icon-edit"></span></a>'.
				'<a href="#" id="btnExcluir_'.$id.'" onclick="return false;" title="Excluir"><span class="icon-remove-sign"></span></a>';
	}
}