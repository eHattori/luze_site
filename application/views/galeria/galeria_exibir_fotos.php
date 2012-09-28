<div class="conteudo_portal">
	<article id="content2">
		<div class="wrapper content_site" style="min-height: 400px;">
			<h2>Galeria de Fotos</h2>
			<div  style="margin-top: 20px; padding-top: 20px">
				<?php if($galerias){?>
				<div style="max-width: 300px;" class="left">
					<ul class="thumbnails">
						<?php $itens_carousel = '';?>
						<?php foreach($galerias as $key => $item){?>
							<li class="span2">
								<a class="thumbnail" href="#" id="link_img_<?php echo $item->galeria_id?>">
							    	<img alt="<?php echo htmlspecialchars($item->descricao)?>" 
							        	title="<?php echo htmlspecialchars($item->descricao)?>" 
										src="<?php echo url_arquivos("galeria/".md5($item->galeria_id).".png")?>">
								</a>
							</li>
							<?php
								$class = $key == 0 ? "active" : "";
								$itens_carousel .= '<div class="item '.$class.'" id="item_carousel_'.$item->galeria_id.'">
														<img alt="" src="'.url_arquivos("galeria/".md5($item->galeria_id).".png").'">
														<div class="carousel-caption">
															<p>'.htmlspecialchars($item->descricao).'</p>
														</div>
													</div>'?>
						<?php }?>
					</ul>
				</div>
				<div class="left" style="width:60%; padding-left: 40px;">
					<div id="myCarousel" class="carousel slide">
						<div class="carousel-inner">
						  	<?php echo $itens_carousel;?>
					  	</div>
					  	<a class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a>
					  	<a class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a>
					</div>
				</div>
				<?php }else{ echo "Nenhuma foto cadastrada"; }?>
			</div>
		</div>
	</article>
</div>