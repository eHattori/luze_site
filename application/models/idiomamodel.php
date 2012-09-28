<?php
class IdiomaModel extends EC9_Model{
	function getIdiomas(){
		return $this->db->get("idiomas")->result();
	}
	
	function getIdiomaId($id){
		return $this->db->where("idioma_id", $id)->get("idiomas")->row();
	}
	
	function validaIdiomaSigla($obj){
		$where = $obj->{$obj->__primaria} ? $obj->__primaria." != ".$obj->{$obj->__primaria}." AND " : "";

		$sql = "SELECT COUNT(*) as total 
				FROM ".$obj->__tabela." 
				WHERE ".$where." (idioma = ".$this->db->escape($obj->idioma)." 
				OR sigla = ".$this->db->escape($obj->sigla).")";
		
		return $this->db->query($sql)->row()->total == 0;
	}
	
	function delete($obj){
		if(! $this->hasRelationship($obj->idioma_id)){
			$retorno = true;
			parent::delete($obj);	
		}else{
			$retorno = false;
		}
		return $retorno;
	}
	
	function hasRelationship($id){
		return $this->db->where("idioma_id", $id)->count_all_results("dicionario") != 0;
	}
	
	function getLastIdiomaId(){
		$this->db->order_by("idioma_id","ASC");
		return @$this->db->get("idiomas",1)->row()->idioma_id;
	}
	
	function getFirstLanguage(){
		return $this->db->order_by("idioma_id")->get("idiomas", 1)->row();
	}
}