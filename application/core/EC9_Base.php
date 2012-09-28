<?php
/**
 * Controller base 
 *
 * @author Eduardo Hattori
 * @email eduardo.hattori@hotmail.com	
 *
 * Fun��es base do portal e admin 
 * 
 */
class EC9_Base extends CI_Controller{
	
	public function __construct(){		
		parent::__construct();
		if(isset($this->uri->segments[1]) && strcasecmp($this->uri->segments[1], "maincontroller") != 0){
			$this->template->set_template("public");
		}else{
			$this->template->set_template("public_inicial");
		}
	}
}