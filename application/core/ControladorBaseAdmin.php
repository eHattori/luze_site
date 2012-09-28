<?php
/**
 * Controller base admin
 *
 * @author Eduardo Hattori
 * @email eduardo.hattori@hotmail.com
 *
 * Fun��es espec�ficas do administrativo
 *
 */
class ControladorBaseAdmin extends EC9_Base{

	public function __construct(){
		parent::__construct();
		$this->template->set_template("admin");
		if(!_not_login){
			validaLogin();
		}
	}
}