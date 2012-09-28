<div class="conteudo_portal">
	<article id="content2">
		<div class="wrapper content_site" style="min-height: 400px;">
			<h2>Galeria de Vídeos</h2>
			<div  style="margin-top: 10px; padding-top: 20px">
				<?php if($galerias){?>
				<ul class="thumbnails">
					<?php foreach($galerias as $item){?>
						<li class="span2">
							<a class="thumbnail" href="#" id="link_img_<?php echo $item->galeria_id?>">
								<input type="hidden" id="hdd_video_<?php echo $item->galeria_id?>" value="<?php echo retorna_nome_video_youtube($item->name_arquivo)?>"/>
								<img alt="<?php echo htmlspecialchars($item->descricao)?>" 
							    	title="<?php echo htmlspecialchars($item->descricao)?>" 
									src="http://i1.ytimg.com/vi/<?php echo retorna_nome_video_youtube($item->name_arquivo)?>/default.jpg">
								<br/>
								<div align="center" id="div_descricao_<?php echo $item->galeria_id?>">
									<?php echo htmlspecialchars($item->descricao);?>
								</div>
							</a>
						</li>
					<?php }?>
				</ul>
				<?php }else{ echo 'Nenhum vídeo cadastrado';}?>
			</div>
		</div>
	</article>
</div>
<div class="modal hide" id="myModal" style="width:670px;">
  <div class="modal-header">
  	<div align="right">
    	<button type="button" class="close" data-dismiss="modal">×</button>
    </div>
    <span id="descricao_video"></span>
  </div>
  <div class="modal-body" id="conteudo_modal_video">
  </div>
</div>