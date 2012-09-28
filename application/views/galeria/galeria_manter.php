<fieldset>
	<legend>Cadastro de Fotos e Vídeos</legend><br>
	<div class="row">
		<div class="width_600_left">
			<form id="form_galeria" class="form-horizontal" method="post" action="<?php echo site_url("admin/galeriacontroller/salvar");?>">
				<input type="hidden" id="galeria_id" 	name="galeria_id" 	value="<?php echo @$galeria->galeria_id?>" />
				<input type="hidden" id="imagem" 		name="imagem" 		value="<?php echo @$imagem?>" />
				<input type="hidden" id="imagem_old" 	name="imagem_old" 	value="<?php echo @$imagem?>" />
				<div class="control-group">
					<label class="control-label" for="descricao">Descrição:</label>
					<div class="controls">
						<input type="text" id="descricao" name="descricao" class="input-large" maxlength="200" value="<?php echo @htmlspecialchars($galeria->descricao)?>" />
						<span class="help-inline"></span>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="tipo">Tipo:</label>
					<div class="controls">
						<?php echo $tipo?>
						<span class="help-inline"></span>
					</div>
				</div>
				<div class="control-group" id="input_arquivo">
					<label class="control-label" for="name_arquivo">Arquivo:<span class="campo_obg">*</span></label>
					<div class="controls">
						<input type="text" id="name_arquivo" name="name_arquivo" class="input-large required url_youtube" maxlength="250" value="<?php echo @htmlspecialchars($galeria->name_arquivo)?>" />
						<span class="help-inline"></span>
					</div>
				</div>
			</form>
			<form id="form_foto_galeria" class="form-horizontal" action="<?php echo site_url("admin/uploadcontroller/upload")?>" method="POST" enctype="multipart/form-data">
				<div class="control-group">
					<div class="controls">
						<span id="span_img" class="btn btn-mini btn-success fileinput-button">
		                    <i class="icon-plus icon-white"></i>
		                    <span>Add foto...</span>
		                    <input type="file" id="arquivo" name="arquivo">
		                </span>
		                <span class="campo_obg">*</span>
		                <span class="help-inline"></span>
					</div>
				</div>
			</form>
			<label><span class="campo_obg">*</span> Campos obrigatórios</label><br>
			<button type="button" id="btnSalvar" class="btn btn-primary">Salvar</button>
			<button type="button" id="btnCancelar" class="btn">Cancelar</button>
		</div>
		<div class='span4'>
			<img border="none" id="img_galeria" alt="Foto" style="display:none"/>
		</div>
	</div>
</fieldset>
<br/><br/>