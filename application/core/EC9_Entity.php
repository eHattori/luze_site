<?php
class EC9_Entity{
	function __construct(){
		$CI =& get_instance();
		$fields = $CI->db->field_data($this->__tabela);
		if (count($fields)>0){
			foreach ($fields as $field=>$attribute)
			{
				if ($attribute->primary_key){
					$this->__primaria = $attribute->name;
				}
			   	$this->{$attribute->name} = NULL;
			}
		}
		return $this;
	}
	
	function preencherObj($post){
		$vars 	= get_object_vars($this);
		$not	= array("__tabela", "__primaria");
		foreach($vars as $key => $item){
			if(! in_array($key, $not)){
				if($post[$key] == "" && $key != $this->{"__primaria"}){
					unset($this->{$key});
				}else{
					$this->{$key} = $post[$key];
				}
			}
		}
	}
}