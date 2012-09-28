<div class="slider_bg">
	<div class="slider">
		<ul class="items">
			<?php if(count(@$produtos)):?>
				<?php foreach (@$produtos as $key=>$produto):?>
					<li>
						<img src="<?php echo url_arquivos("produtos/".$produto->arquivo)?>" alt="" width="250" />
						<div class="banner" style="word-wrap:break-word;">
							<strong style="font-size: 37px;">
								<?php echo htmlspecialchars($produto->categoria); ?>
							</strong>
							<b>A escolha certa é aqui!</b>
							<p>
								<span><?php echo htmlspecialchars($produto->texto);  ?></span>
							</p>
						</div>
					</li>
				<?php endforeach;?>
			<?php else:;?>
				<li>
					<img src="<?php echo url_arquivos("produtos/padrao.jpg");?>" alt="" width="250" />
					<div class="banner">
						<strong style="font-size: 37px;">Baldan</strong>
						<b>A Desde 1921!</b>
						<p>
							<span>Tradição em máquinas para madeira</span>
						</p>
					</div>
				</li>
			<?php endif;?>
		</ul>
	</div>
</div>
<div class="wrap">
	<section class="cols">
		<div class="box pad_bottom_30">
			<div>
				<h2>Seja <span>Bem Vindo!</span></h2>
				<figure><img src="<?php echo url_img("bem_vindo.png")?>" alt="" ></figure>
				<p class="pad_bot1">Somos pioneiros em venda de maquinas para madeira!</p>
				<a href="<?php echo prep_url('http://issuu.com/maquinasbaldan/docs/catalogo?mode=embed"')?>" target="_blank" class="button1" style="margin-top: 31px">Conheça nosso catalogo</a>
			</div>
		</div>
	</section>
	<section class="cols pad_left1">
		<div class="box pad_bottom_30">
			<div>
				<h2>Quem <span>Somos</span></h2>
				<figure><div align="center"><img src="<?php echo url_img("baldan_img_ini.png")?>" alt=""></div></figure>
				<p class="pad_bot1">A baldan é uma empresa que esta a mais de 90 anos no mercado produzindo equipamentos de alta qualidade pra você!</p>
				<a href="<?php echo site_url("empresacontroller")?>" class="button1">Conheça nossa história</a>
			</div>
		</div>
	</section>
	<section class="cols pad_left1">
		<div class="box pad_bottom_30">
			<div>
				<h2>Nossa <span>Empresa</span></h2>
				<div style="padding-bottom: 28px;">
					<object	type="application/x-shockwave-flash" style="width: 250px; height: 255px;" data="http://youtube.googleapis.com/v/IwcOQfZbG60?fs=1&amp;hl=en_US&amp;rel=0">
						<param name="movie"	value="http://youtube.googleapis.com/v/IwcOQfZbG60?fs=1&amp;hl=en_US&amp;rel=0" />
						<param value="application/x-shockwave-flash" name="type" />
						<param value="true" name="allowfullscreen" />
						<param value="always" name="allowscriptaccess" />
						<param value="opaque" name="wmode" />
					</object>
				</div>
			</div>
		</div>
	</section>
</div>