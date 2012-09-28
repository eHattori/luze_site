<form id="formContato" action="" method="post" class="form-horizontal">
<input type="hidden" id="contato_id" name="contato_id" value="<?php echo @$contato->contato_id;?>" />
<div class="control-group">	
		<label class="control-label">Nome:<span class="campo_obg">*</span></label>
		<div class="controls">
			<input type="text" class="input-xlarge required" id="nome" name="nome" maxlength="80" value="<?php echo htmlspecialchars(@$contato->nome);?>" />	
			<span class="help-inline"></span>
		</div>
</div>
<div class="control-group" id="grupoEmail">
		<label class="control-label">E-mail:<span class="campo_obg">*</span></label>
		<div class="controls">
			<input type="text" class="input-xlarge required" id="email" name="email" maxlength="80"  value="<?php echo htmlspecialchars(@$contato->email);?>"/>
			<span class="help-inline"></span>
		</div>
</div>
<div class="control-group">	
		<label class="control-label">Celular:</label>
		<div class="controls">
			<input type="text" class="input-xlarge" id="celular" name="celular" maxlength="17" value="<?php echo htmlspecialchars(@$contato->celular);?>"/>
		</div>
</div>
<div class="control-group">
		<label class="control-label">Telefone:</label>
		<div class="controls">
			<input type="text" class="input-xlarge" id="telefone" name="telefone"  maxlength="17" value="<?php echo htmlspecialchars(@$contato->telefone);?>"/>
		</div>
</div>
<div class="control-group">
	<label class="control-label">Estado:<span class="campo_obg">*</span></label>
	<div class="controls">
		<select name="estado" id="estado" class="input-xlarge required">
			<option value="">Selecione</option>
			<?php  foreach ($estados as $estado): ?>
				<option <?php (@$estado->id == @$cidade->id_uf) ? print "selected='selected'": print ""; ?> value="<?php echo @$estado->id;?>"><?php echo @$estado->sigla;?> - <?php echo htmlspecialchars(@$estado->nome);?></option>
			<?php endforeach;?>
		</select>
		<span class="help-inline"></span>
	</div>
</div>
	
<div id="complemento" <?php (@$cidade) ? print '' : print 'style="display: none;"'; ?>>		
	<div class="control-group">
		<label class="control-label">Cidade:<span class="campo_obg">*</span></label>
		<div class="controls">
			<select name="cidade_id" id="cidade" class="input-xlarge required">
				<option value="">Selecione</option>	
				<?php  foreach ($cidades as $city): ?>
					<option <?php (@$cidade->id == @$city->id) ? print "selected='selected'": print ""; ?> value="<?php echo @$city->id;?>"><?php echo htmlspecialchars(@$city->nome);?></option>
				<?php endforeach;?>	
			</select>
			<span class="help-inline"></span>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label">Endereço:<span class="campo_obg">*</span></label>
		<div class="controls">
			<input type="text" class="input-xlarge required" id="endereco" name="endereco" maxlength="120"  value="<?php echo htmlspecialchars(@$contato->endereco);?>"/>
			<span class="help-inline"></span>
		</div>
	</div>
</div>	
<label><span class="campo_obg">*</span> Campos obrigatórios</label><br>
<a href="#" class="btn btn-primary" id="btnSalvar">Salvar</a>
<a href="#" class="btn" id="btnCancelar">Cancelar</a>
</form>