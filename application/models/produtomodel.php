<?php
class ProdutoModel extends EC9_Model{
	function delete_relationship($obj){
		$this->db->set("descricao_id", NULL)->where("produto_id", $obj->produto_id)->update("produtos");
		$this->db->where("dicionario_key", $obj->descricao_id)->delete("dicionario");
		$this->db->where("produto_id", $obj->produto_id)->delete("produto_has_especificacoes");
	}
	
	function save_relationship($especificacao){
		$this->db->insert('produto_has_especificacoes', $especificacao); 
	}
	
	function getProdutoId($id){
		$idiomas = $this->db->order_by("idioma_id")->get("idiomas", 2)->result();
		$ids = array();
		foreach($idiomas as $item){
			$ids[] = $item->idioma_id;	
		}
		$produto 					= $this->db->where("produto_id", $id)->get("produtos")->row();
		$produto->especificacoes 	= $this->db->select("phe.*, GROUP_CONCAT( dic.texto SEPARATOR '/') as texto")
												->where("produto_id", $id)
												->where_in("dic.idioma_id", $ids)
												->join("especificacoes esp", "esp.especificacao_id = phe.especificacao_id")
												->join("dicionario dic", "dic.dicionario_key = esp.descricao_id")
												->group_by("esp.especificacao_id")
												->get("produto_has_especificacoes phe")->result();
		$dicionarios				= $this->db->where("dicionario_key", $produto->descricao_id)->get("dicionario")->result();
		foreach($dicionarios as $item){
			$produto->{"idioma_".$item->idioma_id} = htmlspecialchars($item->texto);	
		}
		$produto->imagens		= $this->getImagensProdutoId($id);
		return $produto;
	}
	
	function getProdutos($parametros = array()){
		$idiomas 	= $this->db->order_by("idioma_id")->get("idiomas", 2)->result();
		$ids 		= array();
		$retorno 	= array();
		foreach($idiomas as $item){
			$ids[] = $item->idioma_id;	
		}
		
		if(isset($parametros['limite'])){
			$this->db->limit($parametros['limite'], ($parametros['limite'] * ($parametros['pagina'] - 1)));
		}
		if($ids){
			$retorno = $this->db->select("p.produto_id, GROUP_CONCAT( dic.texto SEPARATOR '/') as descricao")
						->join("dicionario dic", "dic.dicionario_key = p.descricao_id")
						->where_in("dic.idioma_id", $ids)
						->group_by("p.produto_id")
						->get("produtos p")->result();	
		}
		return $retorno;
	}
	
	function delete($produto){
		return $this->db->where("produto_id", $produto->produto_id)->delete("produtos");
	}
	
	function getImagensProdutoId($idProduto){
		return $this->db->where("produto_id", $idProduto)->get("produto_imagens")->result();
	}
	
	function deleteImagem($params){
		if(isset($params["arquivo"])){
			$this->db->where("arquivo", $params["arquivo"]);
		}
		if(isset($params["produto_id"])){
			$this->db->where("produto_id", $params["produto_id"]);
		}
		return $this->db->delete("produto_imagens");
	}
	
	function save_image($image){
		$this->db->insert('produto_imagens', $image);
	}
	
	function get_produtos_portal(array $params, $limit = false){
		$idioma = $this->db->escape($params['idioma']);
		if($limit && isset($params['limit'])){
			$this->db->limit($params['limit'], $params['offset']);	
		}
		if(isset($params['categoria']) && $params['categoria'] != ""){
			$this->db->where("cat.categoria_id", $params['categoria']);
		}
		if(isset($params['order_by'])){
			$this->db->order_by($params['order_by']['campo'], $params['order_by']['sentido']);
		}
		$only_with_image = isset($params['with_only_image']) ? "INNER" : "LEFT";
		return $this->db->select("prod.produto_id, dic.texto, img.arquivo as arquivo, cat_dic.texto as categoria")
						->join("dicionario as dic", "dic.dicionario_key = prod.descricao_id")
						->join("idiomas as idi", "idi.idioma_id = dic.idioma_id")
						->join("categorias as cat", "cat.categoria_id = prod.categoria_id")
						->join("dicionario as cat_dic", "cat_dic.dicionario_key = cat.descricao_id")
						->join("produto_imagens as img", "img.produto_id = prod.produto_id  AND img.destaque = 1", $only_with_image)
						->where("idi.idioma_id", $params['idioma'])
						->where("cat_dic.idioma_id", $params['idioma'])
						->get("produtos as prod")->result();
	}
	
	function get_produto_id_portal(array $params){
		$produto = $this->db->select("prod.*, cat_dic.texto as categoria, dic.texto as descricao")
							->join("dicionario dic", "dic.dicionario_key = prod.descricao_id")
							->join("categorias cat", "cat.categoria_id = prod.categoria_id")
							->join("dicionario cat_dic", "cat_dic.dicionario_key = cat.descricao_id")
							->where("dic.idioma_id", $params['idioma'])
							->where("cat_dic.idioma_id", $params['idioma'])
							->where("produto_id", $params['id'])->get("produtos prod")->row();
							
		$produto->especificacoes = $this->db->select("prod_esp.valor, dic.texto")
											->join("especificacoes esp", "esp.especificacao_id = prod_esp.especificacao_id")
											->join("dicionario dic", "dic.dicionario_key = esp.descricao_id")
											->where("produto_id", $params['id'])
											->where("idioma_id", $params['idioma'])
											->get("produto_has_especificacoes prod_esp")->result();
		
		$produto->imagens		= $this->getImagensProdutoId($params['id']);
		return $produto;
	}
	
	function get_total(){
		return $this->db->count_all_results("produtos");
	}
	
	function get_by_id($id){
		return $this->db->where("produto_id", $id)->get("produtos")->row();
	}
}