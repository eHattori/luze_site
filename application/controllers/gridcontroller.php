<?php

class GridController extends  ControladorBaseAdmin {
		
	public function __construct(){
		parent::__construct();		
	}
	
	const ALL               = 0;
	const VISUALIZAR        = 1;
	const EDITAR            = 2;
	const EXCLUIR           = 3;
	
	public function ajaxPesquisaGrid(){
		$post         = $this->input->post();
		$data         = json_decode(@$post['dados']);
		
		if($data){
			$dados = array();
			$dados['chave']      = $data->chave;
			$dados['offset']     = $data->offset;
			$dados['limite']     = $data->limite;
			$dados['pesquisa']   = $data->pesquisa;
			$dados['campos']     = $data->colunas;
			$dados['ordem']      = $data->ordem;
			$dados['direcao']    = $data->direcao;
			$dados['acoes']      = $data->acoes;
			
			$this->load->model("GridModel");
			
			$entidade = new $data->entidade;		
			
			$retorno = array();
			
			$retorno['dados']  = $this->GridModel->pesquisaGrid($entidade, $dados);
			
			$retorno['total']  =  $this->GridModel->pesquisaGrid($entidade, $dados, true);		 
			$retorno['limite'] = $dados['limite'];
			
			$this->gridJsonEncode($retorno, $dados);			
		}
		echo false;
	}
	
	public function gridJsonEncode($dados, $opcoes = array()){
		
		$retorno 	   = array();
		$aObj 	 	   = $dados['dados'];
		$acoes  	   = $opcoes['acoes'];
		$chavePrimaria = $opcoes['chave'];
		$campos        = $opcoes['campos'];
		
		if($acoes){
			$acoes = $this->_montaColunaAcao($aObj, $chavePrimaria, $acoes);
		}
		
		if(is_array($aObj) && count($aObj)){
			foreach ($aObj as $key=>$value) {
				if(is_object($value)){
					
					$array = $this->_preparaObjUtf((array)$value, $campos);
					if($acoes){
						$array['acoes'] = $acoes[$key];
					}
					$retorno[] = $array;
				}
			}
			$dados['dados'] = $retorno;
		}

		echo json_encode($dados);
	}
	
	public function _montaColunaAcao($dados, $chave = "id", $acoes){		
		$retorno = array();	

		foreach ($dados as $value) {
			$id = $value->{$chave};
			$html ='';
			foreach ($acoes as $value) {				
				switch ($value) {
					case GridController::VISUALIZAR:
					$html  .= '<a title="Visualizar" id="visualizar_grid_'.$id.'" href="#" onclick="return false;"><i class="icon-search"></i></a>';									
					break;
					
					case GridController::EDITAR:
					$html  .= '<a title="Editar"     id="editar_grid_'.$id.'" href="#" onclick="return false;"><i class="icon-edit"></i></a>';				
					break;

					case GridController::EXCLUIR:
						$html  .= '<a title="Excluir"  id="excluir_grid_'.$id.'" href="#" onclick="return false;"><i class="icon-trash"></i></a>';
						break;

					case GridController::ALL:
						$html  = '<a title="Visualizar" class="btn" id="visualizar_grid_'.$id.'" href="#" onclick="return false;"><i class="icon-info-sign"></i></a>';
						$html  .= '<a title="Editar" class="btn" id="editar_grid_'.$id.'" href="#" onclick="return false;"><i class="icon-minus-sign"></i></a>';
						$html  .= '<a title="Excluir" class="btn" id="excluir_grid_'.$id.'" href="#" onclick="return false;"><i class="icon-remove-sign"></i></a>';
					break;
				}
			}
			$retorno[] = $html;
		}			
		return $retorno;	
	}
	
	public function excluir($id){
		$post         = $this->input->post();
		$data         = json_decode(@$post['dados']);
		
		if($data){			
			$this->load->model("GridModel");
			$obj = new $data->entidade; 			 		
			$obj->{$obj->__primaria} = $id;
			echo $this->GridModel->delete($obj);				
		}
		echo false;
	}
	
	private function _preparaObjUtf($aObj,$campos){
		
		foreach ($aObj as $key=>$value) {
				foreach ($campos as $campo) {
					
					if(isset($campo->campo) && $key == $campo->campo){
						if(!isset($campo->html)){
							$aObj[$key] = utf8_decode(htmlentities($value));						
						}
						if(isset($campo->wrap) && !isset($campo->html)){
							$aObj[$key] = str_cut($aObj[$key],$campo->wrap);
						}
					}
				}			
		}
		return $aObj;
	}
	
	private function verificaCampos($key, $array = array()){
		
		foreach ($array as $a){
			if($a == $key){
				return false;
			}
		}		
		return true;
	}
	
	//Variaveis Validacao Controlador
	protected $_campos = array();
	const OBRIGATORIO        = 1;
	const NUMERICO           = 2;
	
	protected function _validaCampo(){
		
		$isValido = true;			
		foreach ($this->_campos as $campo=>$validacao){						
			$valor = $_POST[$campo];
			if(!$this->_processaValidacao($valor, $validacao)){
				$isValido = false;
			}
		}			
		return $isValido;
	}	
	
	private function _processaValidacao($valor, $tipoValidacao){
		$isValido = true;

		foreach ($tipoValidacao as $validacao) {
			switch ($validacao) {
				case GridController::OBRIGATORIO:					
					if($valor == "")									
					$isValido = false;	
					break;
				case GridController::NUMERICO:
					if(!is_numeric($valor))
					$isValido = false;
					break;
			}
		}		
		return $isValido;
	}

}