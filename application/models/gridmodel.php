<?php
class GridModel extends EC9_Model{
	
	function pesquisaGrid($entidade, $dados, $count = false){
		
		$this->_addPesquisa($dados['pesquisa']);
		if($dados['limite'] && !$count){
			$this->db->limit($dados['limite'], $dados['offset']);
		}
		
		$this->db->order_by($dados['ordem'], $dados['direcao']);
		
		if(!$count){
			$this->db->select($this->_montaCamposPesquisa($dados['campos'], $dados['chave']));
			$retorno =  $this->db->get($entidade->__tabela)->result();
		} else {
			$retorno =  $this->db->count_all_results($entidade->__tabela);
		}	
		return $retorno;			
	}
	
	private function _addPesquisa($pesquisa){
		if(count($pesquisa)){
			foreach ($pesquisa as $obj) {
				if(!empty($obj->valor)){				
					if($obj->tipo ==  LIKE){
						$this->db->like($obj->campo,$obj->valor);
					}
					if($obj->tipo ==  WHERE){
						$this->db->where($obj->campo,$obj->valor);
					}			
				}
			}
		}
	}
	
	private function _montaCamposPesquisa($campos, $chave){
		
		$stringCampos = $chave;
		foreach ($campos as $obj) {
			if(isset($obj->campo) && $obj->campo != $chave){
				$stringCampos .= ", ".$obj->campo;
			}
		}

		return $stringCampos;
	}
}