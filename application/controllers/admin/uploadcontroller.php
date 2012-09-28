<?php
class UploadController extends CI_Controller{
	function upload(){
		$this->load->library("EC9_Upload");
		$_POST["upload_path"] 	= UPLOAD_TMP;
		$_POST["encrypt_name"] 	= true;
		$this->ec9_upload->initialize($_POST);
		if($this->ec9_upload->do_upload("arquivo")){
			$data	 = $this->ec9_upload->data();
			$retorno = array("status" => true, "nome_arquivo" => $data["file_name"], "arquivo_original" => $data['orig_name']);
		}else{
			$retorno = array("status" => false, "msg" => $this->ec9_upload->display_errors());
		}
		echo json_encode($retorno);		
	}
}