<form id="form_categoria" class="form-horizontal" method="post" action="<?php echo site_url("admin/categoriacontroller/salvar");?>">
	<fieldset>
	<legend>Cadastro de Categorias</legend>

	<input type="hidden" id="categoria_id" name="categoria_id" value="" />
	<input type="hidden" id="descricao_id" name="descricao_id" value="<?php echo @$descricao_id?>" />
	<input type="hidden" id="dicionario_key" name="dicionario_key" value="<?php echo @$dicionario_key?>" />

<?php 
	foreach ($idiomas as $rowIdioma){
	$idName = 'idioma_'.$rowIdioma->idioma_id; 
?>
		<div class="control-group">
			<label class="control-label" for="<?php echo $idName;?>"><?php echo $rowIdioma->idioma;?>:<span class="campo_obg">**</span></label>
			<div class="controls">
				<input type="text" id="<?php echo $idName;?>" name="<?php echo $idName;?>" value="<?php echo html_escape(@$rowIdioma->texto)?>" placeholder="Palavra em <?php echo $rowIdioma->idioma?>"/>
				<span class="help-inline"></span>
			</div>
		</div>
<?php }

if(!$idiomas){
	echo "Cadastre algum idioma para incluir uma categoria";	
}else{

?>
<label><span class="campo_obg">**</span> Pelo menos um campo deve ser preenchido</label><br>
<button type="button" id="btnCadastrar" class="btn btn-primary">Salvar</button>

<?php }?>
		<button type="button" id="btnVoltar" class="btn">Voltar</button>
		
	</fieldset>
</form>