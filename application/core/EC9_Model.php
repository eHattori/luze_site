<?php
class EC9_Model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	function save($obj){
		$objeto = clone ($obj);
	unset($objeto->__tabela, $objeto->__primaria, $objeto->{$obj->__primaria});
		if(!$obj->{$obj->__primaria}){
			$retorno = $this->db->insert($obj->__tabela, $objeto);
			$obj->{$obj->__primaria} = $this->db->insert_id();	
		}else{
			$retorno = $this->db->where($obj->__primaria, $obj->{$obj->__primaria})->update($obj->__tabela, $objeto);
		}
		return $retorno;
	}
	
	function delete($obj){
		return $this->db->where($obj->__primaria, $obj->{$obj->__primaria})->delete($obj->__tabela);
	}
}