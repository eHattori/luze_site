<fieldset>
	<legend>Cadastro de Idiomas</legend><br>
	<form id="form_idioma" class="form-horizontal" method="post" action="<?php echo site_url("admin/idiomacontroller/salvar");?>">
		<input type="hidden" id="idioma_id" name="idioma_id" value="<?php echo @$idioma->idioma_id?>" />
		<input type="hidden" id="imagem" name="imagem" value="<?php echo @$imagem?>" />
		<input type="hidden" id="imagem_old" name="imagem_old" value="<?php echo @$imagem?>" />
		<div class="control-group">
			<label class="control-label" for="descricao">Idioma:<span class="campo_obg">*</span></label>
			<div class="controls">
				<input type="text" id="idioma" name="idioma" class="input-large required" maxlength="45" value="<?php echo @htmlspecialchars($idioma->idioma)?>" />
				<span class="help-inline"></span>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="sigla">Sigla:<span class="campo_obg">*</span></label>
			<div class="controls">
				<input type="text" id="sigla" name="sigla" class="input-small required" maxlength="2" value="<?php echo @$idioma->sigla?>" />
				<span><img border="none" id="img_bandeira" alt="Bandeira" style="display:none"/></span>
				<span class="help-inline"></span>
			</div>
		</div>
	</form>
	<form id="form_bandeira" class="form-horizontal" action="<?php echo site_url("admin/uploadcontroller/upload")?>" method="POST" enctype="multipart/form-data">
		<div class="control-group">
			<div class="controls">
				<span id="span_img" class="btn btn-mini btn-success fileinput-button">
                    <i class="icon-plus icon-white"></i>
                    <span>Add imagem...</span>
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
</fieldset>
<br/><br/>