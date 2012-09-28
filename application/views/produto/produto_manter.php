<fieldset>
	<legend>Cadastro de Produtos</legend><br>
	<div class="row">
		<div class="span7">
			<form id="form_produtos" class="form-horizontal" action="<?php echo site_url("admin/produtocontroller/salvar")?>" method="post">
				<input type="hidden" id="produto_id" name="produto_id" value="<?php echo @$produto->produto_id?>" />
				<input type="hidden" id="descricao_id" name="descricao_id" value="<?php echo @$produto->descricao_id?>" />
				<input type="hidden" id="especificacoes_produtos" name="especificacoes_produtos" value='<?php echo @$produto->especificacoes_string?>' />
				<input type="hidden" id="imagens" name="imagens" value='<?php echo @$produto->imagens_string?>' />
				<input type="hidden" id="manual" name="manual" value='<?php echo @$produto->manual?>'/>
				<input type="hidden" id="arq_manual" name="arq_manual" value='<?php echo @$manual?>'/>
				<input type="hidden" id="arq_manual_old" name="arq_manual_old" value='<?php echo @$manual?>'/>
				<h3>Categoria:<span class="campo_obg">*</span></h3>
				<div class="control-group">
					<div class="controls">
						<?php echo $categorias?>
						<span class="help-inline"></span>
					</div>
				</div>
				<h3>Descrições:</h3>
				<?php foreach($idiomas as $item){?>
				<div class="control-group">
					<label class="control-label" for="idioma_<?php echo $item->idioma_id?>"><?php echo $item->idioma?>:<span class="campo_obg">**</span></label>
					<div class="controls">
						<input type="text" id="idioma_<?php echo $item->idioma_id?>" name="idioma_<?php echo $item->idioma_id?>" value="<?php echo @$produto->{"idioma_".$item->idioma_id}?>" />
						<span class="help-inline"></span>
					</div>
				</div>
				<?php }?>
				<br/>
			</form>
			<form id="form_manual" action="<?php echo site_url("admin/uploadcontroller/upload")?>" method="POST" enctype="multipart/form-data">
				<h3 style="width:70px; float:left">Manual:</h3>
				<h4 style="float:left; margin-left:15px; padding-top:6px" id="nome_manual"><?php echo @$produto->manual?></h4>
				<div style="clear:both"></div>
				<div class="control-group">
					<div class="controls">
						<span id="span_img" class="btn btn-mini btn-success fileinput-button">
                    	<i class="icon-plus icon-white"></i>
                    	<span>Add manual...</span>
                    	<input type="file" id="arquivo" name="arquivo">
                	</span>
                	<span class="help-inline"></span>
			</div>
		</div>
			</form>
			<form id="form_especificacoes" class="form-inline">
				<h3>Especificações:</h3>
					<div class="control-group" id="control_especificacoes_produto">
						<div id="erros" style='color: #b94a48;'></div>
						<br/>
						<?php echo $especificacoes?>
						<input type="text" id="descricao_espeficicacao" name="descricao_espeficicacao" class="required" placeholder="Descrição" maxlength="60"/>
						<button type="button" class="btn btn-primary" id="btnAddEspecificacoes">Add</button>
					</div>
			</form>
			<table class='table' id="table_especificacao">
				<thead>
					<tr>
						<th width="40%">Especificação</th>
						<th width="50%">Descrição</th>
						<th width="10%">Ações</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
			<br><br>
			<label><span class="campo_obg">*</span> Campos obrigatórios</label>
			<label><span class="campo_obg">**</span> Pelo menos um campo deve ser preenchido</label>
			<br>
				<button type="button" id="btnSalvar" class="btn btn-primary">Salvar</button>
				<button type="button" id="btnCancelar" class="btn">Cancelar</button>
			<br><br>
		</div>
		<div class='span4'>
			<form id="form_imagens" action="<?php echo site_url("admin/uploadcontroller/upload")?>" method="POST" enctype="multipart/form-data">
				<h3>Imagens:</h3>
				<div class="control-group">
					<div class="controls">
						<span id="span_img" class="btn btn-mini btn-success fileinput-button">
		                    <i class="icon-plus icon-white"></i>
		                    <span>Add imagens...</span>
		                    <input type="file" id="arquivo" name="arquivo" multiple>
		                </span>
		                <span class="help-inline"></span>
					</div>
				</div>
			</form>
			<div style="width:100%">
				<table class='table' id="table_imagens">
					<thead>
						<tr>
							<th width="70%">Imagem</th>
							<th width="30%">Ações</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</fieldset>
