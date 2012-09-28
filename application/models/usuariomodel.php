<?php
class UsuarioModel extends EC9_Model{
	
	public function verificaUsuarioExistente($email, $id){
		if($id){
			$this->db->where("usuario_id != ", $id);
		}
		$this->db->where('email', $email);
		return $this->db->get('usuarios')->row();
	}
	
	public function logar($email,$senha){
		
		$this->db->where('email', $email);
		$this->db->where('senha', $senha);
		
		return $this->db->get('usuarios')->row_array();
	}
	
	public function getUsuarioId($id){
		return $this->db->where("usuario_id", $id)->get("usuarios")->row();
	}
}