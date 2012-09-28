<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('validaLogin'))
{
	function validaLogin()
	{
		$CI = &get_instance();
		$CI->load->library("uri");
		if($CI->uri->segment(1) == "admin")
		{
			if(!isset($_SESSION["user"])){
				ob_start();
				header("Location: ".site_url()."admin/logincontroller");		
				exit;
			}			
		}
	}   
}

if ( ! function_exists('getUsuarioLogin'))
{
	function getUsuarioLogin() 
	{	
		$user = @$_SESSION["user"];
		return array_to_object($user);		
	}   
}

if (! function_exists('getNomeUsuarioLogin'))
{
	function getNomeUsuarioLogin() 
	{	
		$user = @$_SESSION["user"]["nome"];
		return $user;		
	}   
}
