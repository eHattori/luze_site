<?php
class GaleriaController extends EC9_Base{
	function index(){
		$this->template->write_view("conteudo", "galeria/galeria_index_portal");
		$this->template->render();
	}

	function galeria($tipo = "F"){
		$this->load->model("galeriamodel");
		$dados['galerias'] = $this->galeriamodel->get_itens_galeria(array("tipo" => $tipo));
		if(strcasecmp($tipo, "F") == 0){
			$this->template->add_js("plugins/bootstrap-carousel.js");
		 	$this->template->add_js("scripts/galeria/galeria_exibir_foto.js");
			$this->template->write_view("conteudo", "galeria/galeria_exibir_fotos", $dados);
		}else{
			$this->template->add_js("plugins/bootstrap-modal.js");
			$this->template->add_js("scripts/galeria/galeria_exibir_videos.js");
			$this->template->write_view("conteudo", "galeria/galeria_exibir_videos", $dados);
		}
		$this->template->render();
	}
}