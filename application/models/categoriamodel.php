<?php
class CategoriaModel extends EC9_Model{
	
	public function getCategorias(){
		
		$this->db->select("ca.descricao_id, di.texto, id.idioma")
				 ->from("categorias as ca")
				 ->join("dicionario as di", "di.dicionario_key = ca.descricao_id")
				 ->join("idiomas as id", "id.idioma_id = di.idioma_id")
				 ->order_by("ca.descricao_id");
		return $this->db->get()->result();
	}
	
	public function excluir($descricao_id){
		$this->db->where("descricao_id", $descricao_id)
				 ->delete("categorias");
				 
		$this->db->where("dicionario_key", $descricao_id)
				 ->delete("dicionario");
	}
	
	public function getCategoria($descricaoId){
		
		$this->db->select("ca.descricao_id, di.texto, id.idioma, id.idioma_id, di.dicionario_key")
				 ->from("categorias as ca")
				 ->join("dicionario as di", "di.dicionario_key = ca.descricao_id")
				 ->join("idiomas as id", "id.idioma_id = di.idioma_id")
				 ->where("descricao_id", $descricaoId);
		return $this->db->get()->result();
	}
	
	public function getDescricoesCategorias(){
		$idiomas = $this->db->order_by("idioma_id")->get("idiomas", 2)->result();
		$retorno = array();
		if($idiomas){
			$ids = array();
			foreach($idiomas as $item){
				$ids[] = $item->idioma_id;	
			}
			$retorno =  $this->db->select("cat.categoria_id, GROUP_CONCAT( dic.texto SEPARATOR '/') as descricao")
									->from("categorias cat")
									->join("dicionario dic", "dic.dicionario_key = cat.descricao_id")
									->where_in("dic.idioma_id", $ids)
									->group_by("cat.categoria_id")
									->get()->result();
		}
		return $retorno;
	}
	
	public function verificaRelacionamento($descricao_id){
		$categoria_id = $this->db->where('descricao_id', $descricao_id)
					 			 ->get('categorias')->row()->categoria_id;
					 			 
		return $this->db->where('categoria_id', $categoria_id)->get('produtos')->row();
	}
	
	public function get_categorias_idioma($id_idioma){
		
		$this->db->select("ca.categoria_id, ca.descricao_id, di.texto, id.idioma")
				 ->from("categorias as ca")
				 ->join("dicionario as di", "di.dicionario_key = ca.descricao_id")
				 ->join("idiomas as id", "id.idioma_id = di.idioma_id")
				 ->where("id.idioma_id", $id_idioma)
				 ->order_by("ca.descricao_id");
		return $this->db->get()->result();
	}

}