<?php
class GaleriaModel extends EC9_Model{
	function get_itens_galeria(array $params = array(), $limit = false){
		if($limit && isset($params['limite'])){
			$this->db->limit($params['limite'], ($params['limite'] * ($params['pagina'] - 1)));
		}
		if(isset($params['tipo'])){
			$this->db->where("tipo", $params['tipo']);
		}
		return $this->db->get("galeria")->result();
	}
	
	function get_by_id($id){
		return $this->db->where("galeria_id", $id)->get("galeria")->row();
	}
}