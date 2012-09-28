<fieldset>
	<legend>Contatos</legend><br>
	<input type="hidden" id="visualizar" value="">
	<fieldset class="well form-inline">
		<label>Nome:</label>
		<input type="text" class="span3" placeholder="Nome Contato..." id="txtNome" name="nome"  />
		&nbsp;&nbsp;&nbsp;
		<label>E-mail:</label>
		<input type="text" class="span3" placeholder="Email Contato..." id="txtEmail" name="email"  />
		<a href="#" class="btn btn-primary" id="btnPesquisar">Pesquisar</a>
	</fieldset>	
	<fieldset>
		<div id="gridContatos"> </div>
	</fieldset>
	<div align="right">
		<a href="<?php echo site_url("admin/contatocontroller/inserir")?>" class="btn btn-primary">Novo contato</a>
	</div>
	
	<div class="modal hide" id="modalVisualizar">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">×</button>
			<h3 id="nome"></h3>
		</div>
	<div class="modal-body">
		<p id="email"></p>
		<p id="telefone"></p>
		<p id="celular"></p>
	</div>
	<div class="modal-footer"><a href="#" class="btn" data-dismiss="modal">Close</a>
	</div>
	</div>
</fieldset>