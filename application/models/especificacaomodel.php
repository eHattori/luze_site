<?php
class EspecificacaoModel extends EC9_Model{

	function getEspeficicacoes(){
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
			$retorno = $this->db->select("e.especificacao_id, GROUP_CONCAT( dic.texto SEPARATOR '/') as descricao")
						->join("dicionario dic", "dic.dicionario_key = e.descricao_id")
						->where_in("dic.idioma_id", $ids)
						->group_by("e.especificacao_id")
						->get("especificacoes e")->result();	
		}
		return $retorno;
	}
	
	function getEspeficicaoId($id){
		$especificacao 	= $this->db->where("especificacao_id", $id)->get("especificacoes")->row();
		$dicionarios	= $this->db->where("dicionario_key", $especificacao->descricao_id)->get("dicionario")->result();
		foreach($dicionarios as $item){
			$especificacao->{"idioma_".$item->idioma_id} = htmlspecialchars($item->texto);	
		}
		return $especificacao;
	}
	
	function salvar_dicionario($dicionario){
         $this->db->insert('dicionario', $dicionario);
         return $this->retornar_max_id('dicionario');
     }

	function salvar_especificacao($id){
         $this->db->set('descricao_id', $id);
        $this->save($this->db);
    }

    function getDescricoesEspecificacoes(){
    	$idiomas = $this->db->order_by("idioma_id")->get("idiomas", 2)->result();
		$retorno = array();
		if($idiomas){
			$ids = array();
			foreach($idiomas as $item){
				$ids[] = $item->idioma_id;	
			}
			$retorno =  $this->db->select("esp.especificacao_id , GROUP_CONCAT( dic.texto SEPARATOR  '/' ) AS descricao")
									->from("especificacoes esp")
									->join("dicionario dic", "dic.dicionario_key = esp.descricao_id")
									->where_in("dic.idioma_id", $ids)
									->group_by("esp.especificacao_id")
									->get()->result();
		}
		return $retorno;
    }
    
	function delete_relationship(Especificacao $obj){
		if($obj->especificacao_id){
			$especificacao = $this->db->where("especificacao_id", $obj->especificacao_id)->get($obj->__tabela)->row();
			$this->db->set("descricao_id", NULL)->where("especificacao_id", $obj->especificacao_id)->update($obj->__tabela);
			$this->db->where("dicionario_key", $especificacao->descricao_id)->delete("dicionario");
		}
	}
	
	function delete(Especificacao $obj){
		if(! $this->hasRelationship($obj->especificacao_id)){
			$retorno = true;
			$this->delete_relationship($obj);
			parent::delete($obj);	
		}else{
			$retorno = false;
		}
		return $retorno;
	}
	
	function hasRelationship($id){
		return $this->db->where("especificacao_id", $id)->count_all_results("produto_has_especificacoes") != 0;
	}
}