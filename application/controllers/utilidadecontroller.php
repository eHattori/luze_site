<?php
class UtilidadeController extends EC9_Base{
	function index(){
		$this->template->write_view("conteudo", "utilidade/utilidade_index.php");
		$this->template->render();
	}
}