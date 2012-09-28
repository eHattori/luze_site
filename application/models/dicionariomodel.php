<?php
class DicionarioModel extends EC9_Model{
	
	public function recuperaUltimaKey(){
		$this->db->select_max('dicionario_key');
		return $this->db->get('dicionario')->row()->dicionario_key;
	}
	
	public function salvar($dicionario){
		$this->db->insert('dicionario', $dicionario); 
	}
	
	public function saveOrUpdate($dicionario){
		
		$salvar = false;
		
		$this->_preencheWhere($dicionario);
		
		if(!$this->db->get('dicionario')->row()){
			$salvar = true;
		}
		
		$this->_preencheWhere($dicionario);
		
		$this->db->set('dicionario_key', $dicionario['dicionario_key'])
				 ->set('idioma_id', $dicionario['idioma_id'])
				 ->set('texto', $dicionario['texto']);
				 
		$salvar == false ?  $this->db->update('dicionario') : $this->db->insert('dicionario');
	}
	
	private function _preencheWhere($dicionario){

		$this->db->where('dicionario_key', $dicionario['dicionario_key'])
				 ->where('idioma_id', $dicionario['idioma_id']);			
		
	}
	
	public function excluir($idioma_id, $dicionario_key){
		
		$this->db->where('dicionario_key', $dicionario_key)
				 ->where('idioma_id', $idioma_id)
				 ->delete('dicionario');	
	}
	
}