<?php
class ContatoModel extends EC9_Model{
	function get($entidade){
		$this->db->order_by("nome");
		return $this->db->get($entidade->__tabela)->result();
	}

	function validaDuplicidade($entidade){
		if($entidade->contato_id){
			$this->db->where("contato_id !=",$entidade->contato_id);
		}
		$this->db->where("email",$entidade->email);
		return ($this->db->count_all_results($entidade->__tabela) > 0);
	}

	function getForId($id){
		$this->db->where("contato_id",$id);
		return $this->db->get("contatos")->row();
	}

	function getForEmail($email){
		return $this->db->where("email",$email)->get("contatos")->row();
	}

	function pesquisar($dados, $get_limit = false){
		if($get_limit && isset($dados['limite'])){
			$this->db->limit($dados['limite'], ($dados['limite'] * ($dados['pagina'] - 1)));
		}
		if(isset($dados['nome']) && $dados['nome']){
			$this->db->like("nome", $dados['nome']);
		}
		if(isset($dados['email']) && $dados['email']){
			$this->db->where("email", $dados['email']);
		}
		return $this->db->get("contatos")->result();
	}
}