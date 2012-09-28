<?php
class EstadoModel extends EC9_Model{
function get($entidade){
		$this->db->order_by("sigla");	
		return $this->db->get($entidade->__tabela)->result();
	}
}