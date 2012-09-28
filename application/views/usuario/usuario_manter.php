<form id="form_usuario" method="post" class="form-horizontal" action="<?php echo site_url("admin/usuariocontroller/salvar");?>">
	<fieldset>
	<legend>Cadastro de Usuário</legend>

		<input type="hidden" id="usuario_id" name="usuario_id" value="<?php echo @$usuario->usuario_id?>" />
		<div class="control-group">
			<label class="control-label" for="nome">Nome:<span class="campo_obg">*</span></label>
			<div class="controls">
				<input type="text" id="nome" name="nome" maxlength="100" class="required" value="<?php echo @$usuario->nome?>" />
				<span class="help-inline"></span>
			</div>
		</div>
	
		<div class="control-group">
			<label class="control-label" for="email">E-mail:<span class="campo_obg">*</span></label>
			<div class="controls">
				<input type="text" id="email" name="email" maxlength="100" class="email required" value="<?php echo @$usuario->email?>" />
				<span class="help-inline"></span>
			</div>
		</div>
	
		<div class="control-group">
			<label class="control-label" for="senha">Senha:<span class="campo_obg">*</span></label>
			<div class="controls">
				<input type="password" id="senha" name="senha" maxlength="32" class="<?php echo isset($usuario->usuario_id) ? "" : "required"?>" value="" />
				<span class="help-inline"></span>
			</div>
		</div>
	
		<div class="control-group">
			<label class="control-label" for="confSenha">Confirme a Senha:<span class="campo_obg">*</span></label>
			<div class="controls">
				<input type="password" id="confSenha" name="confSenha" maxlength="32" class="<?php echo isset($usuario->usuario_id) ? "" : "required"?>" value="" />
				<span class="help-inline"></span>
			</div>
		</div>
		<label><span class="campo_obg">*</span> Campos obrigatórios</label><br>
		<button type="button" id="btnCadastrar" class="btn btn-primary">Salvar</button>
		
	</fieldset>
</form>