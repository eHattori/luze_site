<div class="conteudo_portal">
	<article id="content2">
		<div class="wrapper content_site" style="min-height: 680px;">
		
		<br><br><br>
			<div id="top_nav">
				<div style="float: right;">
				<?php echo get_idiomas_site()?>
				</div>
			</div>
			<div style="max-width: 300px;" class="left">
				<ul class="thumbnails">
					<?php foreach($produto->imagens as $item){?>
						<li class="span2">
			    			<a class="thumbnail" href="#" id="link_img_<?php echo $item->id?>">
			    				<input type="hidden" id="hdd_img_<?php echo $item->id?>" value="<?php echo url_arquivos("produtos/".$item->arquivo)?>"/> 
			        			<img alt="<?php echo htmlspecialchars($produto->descricao)?>" 
			        					title="<?php echo htmlspecialchars($produto->descricao)?>" 
			        					src="<?php echo url_arquivos("produtos/".$item->arquivo)?>">
							</a>
						</li>
					<?php }?>
				</ul>
			</div>
			<div class="left conteudo_detalhe_produto" style="width:60%">
				<h4><?php echo htmlspecialchars($produto->categoria)?></h4>
				<?php echo htmlspecialchars($produto->descricao)?>
				<div class="conteudo_table">
					<table width="100%">
						<thead>
							<tr>
								<th width="50%"></th>
								<th width="50%"></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($produto->especificacoes as $item){?>
								<tr>
									<td><?php echo htmlspecialchars($item->texto)?></td>
									<td><?php echo htmlspecialchars($item->valor)?></td>
								</tr>
							<?php }?>
						</tbody>
					</table>
				</div>
				<div class="download_manual">
					<?php if($produto->manual){?>	
						<a href="<?php echo site_url("produtoscontroller/download_manual/".$produto->produto_id)?>" title="Download - Manual">
							<img src="<?php echo url_img("download_32x32.png")?>" border="none" alt="Download - Manual"/>
							&nbsp;&nbsp;DOWNLOAD - MANUAL
						</a>
					<?php }?>
				</div>
			</div>
			<div style="clear:both; text-align:right;">
				<a href="<?php echo $url_voltar?>" class="button1">Voltar</a>
			</div>
		</div>
	</article>
</div>
<div class="modal hide" id="myModal">
  <div class="modal-header">
  	<div align="right">
    	<button type="button" class="close" data-dismiss="modal">×</button>
    </div>
    <h3><?php echo htmlspecialchars($produto->descricao)?></h3>
  </div>
  <div class="modal-body">
    <img alt="" src="#" id="img_modal">
  </div>
</div>