<?php
if(! function_exists('get_menu')){
	function get_menu(){
		$ci =& get_instance();
		if(isset($ci->uri->segments[1]) && strcasecmp($ci->uri->segments[1], 'admin') == 0){
			$opcoesMenu = array(
				"item_home"	=> array("descricao" => "Home", "url" => "main"),
				"drop"		=> array(
							"titulo"	=> "Cadastro",
							"itensDrop" => array(
									"idiomacontroller" 			=> "Idiomas",
									"especificacaocontroller"	=> "Especificações",
									"categoriacontroller"		=> "Categorias",
									"produtocontroller"			=> "Produtos",
									"contatocontroller" 		=> "Contatos",
									"usuariocontroller"			=> "Usuários"
						)
					),
				"item_galeria" => array("descricao" => "Galeria", "url" => "galeriacontroller")
			);
										
									$controller	= @$ci->uri->segments[2] ? $ci->uri->segments[2] : "main";
									$html		= '<ul class="nav">';
										
									foreach ($opcoesMenu as $key => $item){
										if(stripos($key, "item") !== false){
											$class = strcasecmp($item['url'], $controller) == 0 ? 'active' : '';
											$url   = $item['url'] != '#' ? site_url('admin/'.$item['url']) : "#";
											$html .= '<li class="'.$class.'"><a href="'.$url.'">'.$item['descricao'].'</a></li>';
										}else{
											$class = in_array($controller, array_keys($item['itensDrop'])) ? 'active' : '';
											$html .= '<li class="dropdown '.$class.'">';
											$html .= '<a href="#" class="dropdown-toggle" data-toggle="dropdown">'.$item['titulo'].'<b class="caret"></b></a>';
											$html .= '<ul class="dropdown-menu">';
											foreach($item['itensDrop'] as $chave => $itemDrop){
												$url = stripos($chave, "#") !== false ? "#" : site_url("admin/".$chave);
												$html .= '<li><a href="'.$url.'">'.$itemDrop.'</a></li>';
											}
											$html .= '</ul>';
											$html .= '</li>';
										}
									}
									$html		.= '</ul>';
									return $html;
		}
	}
}
if( ! function_exists("get_menu_portal")){
	function get_menu_portal(){
		$ci =& get_instance();
		$itens = array(
			"maincontroller" 		=> "Início",
			"empresacontroller" 	=> "Empresa",
			"produtoscontroller"	=> "Produtos",
			"galeriacontroller"		=> "Galeria",
			"utilidadecontroller"   => "Utilidades",
			"contatocontroller" 	=> "Contatos",
		);
		$controller	= isset($ci->uri->segments[1]) ? $ci->uri->segments[1] : "maincontroller";
		$html 	=  '<ul id="menu">';
		foreach($itens as $key => $item){
			$classe	 = strcasecmp($key, $controller) == 0 ? "active" : "";
			$html 	.= '<li class="'.$classe.'"><a href="'.site_url($key).'">'.$item.'</a></li>';
		}
		$html 	.= '</ul>';
		return $html;
	}
}

if( ! function_exists("get_idiomas_site")){
	function get_idiomas_site(){
		$ci 		=& get_instance();
		$html 		= '';
		$ci->load->model("idiomamodel");
		if(isset($ci->uri->segments[1]) && strcasecmp($ci->uri->segments[1], 'produtoscontroller') == 0){
			$idiomas 	= $ci->idiomamodel->getIdiomas();
			if($idiomas){
				$html	= '<ul>';
				foreach ($idiomas as $idioma){
					$html .= '<li>'.
								'<a href="'.site_url("maincontroller/set_idioma/".$idioma->idioma_id).'" alt="'.$idioma->idioma."-".$idioma->sigla.'" title="'.$idioma->idioma."-".$idioma->sigla.'">'.
									'<img src="'.image_exist("idiomas/", md5($idioma->idioma_id).".png").'" >'.
								'</a>'.
							'</li>';		
				}
				$html	.= '</ul>';
			}
		}
		return $html;
	}
}