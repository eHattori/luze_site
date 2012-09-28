<form id="form_especificacao" class="form-horizontal" method="post" action="<?php echo site_url("admin/especificacaocontroller/salvar");?>">
	<fieldset>
	<legend>Cadastro de Especificações</legend>

	<input type="hidden" id="especificacao_id" name="especificacao_id" value="<?php echo @$especificacao->especificacao_id?>" />

<?php
	foreach ($idiomas as $rowIdioma){
	$idName = 'idioma_'.$rowIdioma->idioma_id; 
?>
		<div class="control-group">
			<label class="control-label" for="<?php echo $idName;?>"><?php echo $rowIdioma->idioma;?>:<span class="campo_obg">**</span></label>
			<div class="controls">
				<input type="text" id="<?php echo $idName;?>" name="<?php echo $idName;?>" value="<?php echo @$especificacao->{$idName}?>" placeholder="Especificações em <?php echo $rowIdioma->idioma?>"/>
				<span class="help-inline"></span>
			</div>
		</div>
<?php }?>
		<label><span class="campo_obg">**</span> Pelo menos um campo deve ser preenchido</label><br>
		<button type="button" id="btnCadastrar" class="btn btn-primary">Salvar</button>
		
	</fieldset>
</form>