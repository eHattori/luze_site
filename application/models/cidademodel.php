<?php
class CidadeModel extends EC9_Model{
	function getForState($entidade,$uf){
		$this->db->where("id_uf",$uf);
		$this->db->order_by("nome");	
		return $this->db->get($entidade->__tabela)->result();
	}
	
	function getForId($id){
		$this->db->where("id", $id);
		return $this->db->get("cidades")->row();
	}	
}