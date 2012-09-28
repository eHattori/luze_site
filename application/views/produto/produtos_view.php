<div class="conteudo_portal">
	<article id="content2">
		<div class="wrapper content_site" style="min-height: 680px;">
			<h2>Produtos</h2>
			<div id="top_nav">
				<div style="float: right;">
				<?php echo get_idiomas_site()?>
				</div>
			</div>
			<div class="col2">
				<div class="menu_produtos_top" align="center">
					<h3>Categorias</h3>
				</div>
				<div id="categorias" class='menu_produtos'>
					<ul>
						<?php  foreach(@$categorias as $cat):?>
						<li><a href="<?php echo site_url("produtoscontroller/index/?categoria=".$cat->categoria_id)?>"><?php echo $cat->texto; ?></a></li>
						<?php endforeach;?>
					</ul>
				</div>
				<div class="menu_produtos_bottom"></div>
			</div>
			<div class="col4">
				<div class="wBox grid ">
					<div class="paginacao">
						<?php echo @$paginacao; ?>
					</div>
					<div class="box01">
						<div class="wrap_1">
							<?php if($produtos){ ?>
								<?php foreach (@$produtos as $prod){?>
									<a title="<?php echo $prod->texto?>" href="<?php echo site_url()."produtoscontroller/visualizar/".$prod->produto_id; ?>">
										<section class="cols box_image_produto">
											<div class="box">
												<div>
													<h2 class="letter_spacing"><?php echo htmlspecialchars($prod->texto)?></h2>
													<figure>
														<?php if($prod->arquivo){?>
														<img width="250px" height="180px" class="photo" src="<?php echo url_arquivos("produtos/".$prod->arquivo);?>" alt="<?php echo $prod->texto;?>">
														<?php }?>
													</figure>
													<p class="pad_bot1"><?php echo htmlspecialchars($prod->categoria)?></p>
												</div>
											</div>
										</section>
									</a>
								<?php }?>
							<?php }else{?>
									Nenhum produto cadastrado
							<?php }?>
						</div>
					</div>
					<div class="paginacao">
						<?php echo @$paginacao; ?>
					</div>
				</div>
			</div>
		</div>
	</article>
</div>