<?php
class Main extends ControladorBaseAdmin{
	public function __construct(){
		parent::__construct();
	}
	
	public function index(){
		$this->template->write_view("conteudo", "main/main", array());
		$this->template->render();
	}

}