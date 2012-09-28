<fieldset>
	<legend>Categorias</legend>
	<?php if($categorias){?>
		<table class="table table-striped">
			<thead>
				<tr>
					<th width="70%">Categoria</th>
					<th width="30%">Ações</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($categorias as $id=>$item){?>
				<tr>
					<td><?php echo htmlspecialchars($item)?></td>
					<td>
						<a href="<?php echo site_url("admin/categoriacontroller/alterar/".$id)?>" title="Editar"><span class="icon-edit"></span></a>
						<a href="#" id="btnExcluir_<?php echo $id?>" onclick="return false;" title="Excluir"><span class="icon-remove-sign"></span></a>
					</td>
				</tr>
				<?php }?>
			</tbody>
		</table>
	<?php }else{ echo "Nenhum registro encontrado";}?>
	<div align="right">
		<a href="<?php echo site_url("admin/categoriacontroller/incluir")?>" class="btn btn-primary">Nova categoria</a>
	</div>
</fieldset>