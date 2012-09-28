<?php
if( ! function_exists('imprimir')){
	function imprimir($str){
		echo "<pre>";
		var_dump($str);
		exit;
	}
}

if( ! function_exists('url_css')){
	function url_css($arquivo = ""){
		return base_url("assets/css/".$arquivo);
	}
}

if( ! function_exists('url_img')){
	function url_img($arquivo = ""){
		return base_url("assets/img/".$arquivo);
	}
}

if( ! function_exists('url_js')){
	function url_js($arquivo = ""){
		return base_url("assets/js/".$arquivo);
	}
}

if( ! function_exists('url_arquivos')){
	function url_arquivos($arquivo = ""){
		return base_url("assets/arquivos/".$arquivo);
	}
}

if( ! function_exists('image_exist')){
	function image_exist($path, $img){
		$caminho = "assets/arquivos/".$path;
		return file_exists($caminho.$img) ? url_arquivos($path.$img) : url_arquivos($path."no_image.png");
	}
}

if( ! function_exists('delete_file')){
	function delete_file($path, $img){
		$caminho = "assets/arquivos/".$path;
		if(file_exists($caminho.$img)){
			unlink($caminho.$img);
		}
	}
}

if(! function_exists("file_transfer")){
	function file_transfer($origem, $destino){
		if(file_exists($origem) && (! file_exists($destino))){
			@copy($origem, $destino);
		}
	}
}

if ( ! function_exists('str_cut'))
{
	function str_cut($str,$number = 150,$delimiter = '...'){
		if(strlen($str) >= $number){
			// se a string for maior que o numero especificado corto com o delimitador
			$str = substr($str,0,$number).$delimiter;
		}
		return $str;
	}
}

if( ! function_exists("enviar_email")){
	function enviar_email($assunto, $mensagem){
		$ci =& get_instance();
		$ci->load->library("email");
		$config['smtp_host'] 	= _cfg_email_host;
		$config['protocol']		= "smtp";
		$config['smtp_user']	= _cfg_email_user;
		$config['smtp_pass']	= _cfg_email_pass;
		$config['smtp_port']	= 587;
		$config['mailtype']		= "html";
		try{
			$ci->email->initialize($config);
			$ci->email->from(_cfg_email_user, "Baldan[CONTATO]");
			$ci->email->to(_cfg_email_to);

			$ci->email->subject($assunto);
			$ci->email->message($mensagem);

			$ci->email->send();
			$retorno = true;
		}catch(Exception $e){
			$retorno = false;
		}
		return $retorno;
	}
}

if( ! function_exists("retorna_nome_video_youtube")){
	function retorna_nome_video_youtube($str){
		return substr($str, (strpos($str, "=") + 1));
	}
}