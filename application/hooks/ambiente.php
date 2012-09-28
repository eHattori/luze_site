<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Ambiente {
	public function loadConfig() 
	{
		if(file_exists($file = FCPATH.APPPATH.'config/ambiente/'.AMBIENTE.EXT))
			require($file);
		else
			throw new Exception("Arquivo de configura��o inexistente");
	}
}