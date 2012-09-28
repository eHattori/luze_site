<fieldset>
	<legend>Idiomas</legend>
	<?php if($idiomas){?>
		<table class="table table-striped">
			<thead>
				<tr>
					<th width="5%"></th>
					<th width="65%">Idioma</th>
					<th width="30%">Ações</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($idiomas as $item){?>
				<tr>
					<td>
						<img alt="<?php echo htmlspecialchars($item->idioma).'-'.$item->sigla?>" src="<?php echo image_exist("idiomas/", md5($item->idioma_id).".png")?>" border="none"/>
					</td>
					<td><?php echo htmlspecialchars($item->idioma).'-'.$item->sigla?></td>
					<td>
						<a href="<?php echo site_url("admin/idiomacontroller/alterar/".$item->idioma_id)?>" title="Editar"><span class="icon-edit"></span></a>
						<a href="#" id="btnExcluir_<?php echo $item->idioma_id?>" onclick="return false;" title="Excluir"><span class="icon-remove-sign"></span></a>
					</td>
				</tr>
				<?php }?>
			</tbody>
		</table>
	<?php }else{ echo "Nenhum registro encontrado";}?>
	<div align="right">
		<a href="<?php echo site_url("admin/idiomacontroller/incluir")?>" class="btn btn-primary">Novo idioma</a>
	</div>
</fieldset>