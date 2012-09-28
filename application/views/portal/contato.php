<article id="content">
	<div class="wrap">
		<div class="box">
			<div style="padding: 0 30px 30px 30px;">
				<div class="alert alert-error" style="display:none;">
  						<h4 class="alert-heading">Aviso!</h4>
  						<label id="alert_msg"></label>
				</div>
				<div style="width:45% !important; float:left;">
					<h2 class="letter_spacing">Formulário <span>de Contato</span></h2>
					<form id="ContactForm" method="post" action="<?php echo site_url("contatocontroller/enviar");?>">
						<div>
							<div class="wrapper">
								<span>Nome*:</span>
								<input type="text" id="nome" name="nome" class="required input" maxlength="80" value="" />
							</div>
							<div class="wrapper">
								<span>E-mail*:</span>
								<input type="text" id="email" name="email" class="required email input" maxlength="80" value="" />								
							</div>
							<div class="wrapper">
								<span>Endereço:</span>
								<input type="text" id="endereco" name="endereco" maxlength="120" class="input" value="" />
							</div>
							<div class="wrapper">
								<span>Estado:</span>
								<?php echo $estados?>
							</div>
							<div class="wrapper">
								<span>Cidade:</span>
								<div id="div_cidades">
									<select id="cidade_id" name="cidade_id" style="width:174px">
										<option value="">Selecione</option>
									</select>
								</div>
							</div>
							<div class="wrapper">
								<span>Telefone:</span>
								<input type="text" id="telefone" name="telefone" maxlength="17" value="" class="input"/>
							</div>
							<div class="wrapper">
								<span>Assunto*:</span>
								<input type="text" id="assunto" name="assunto" maxlength="40" class="input required" value=""/>
							</div>
							<div class="textarea_box">
								<span>Mensagem*:</span>
								<textarea name="textarea" id="textarea" class="required" cols="1" rows="1"></textarea>								
							</div>
							<label>* Campos obrigatórios</label>
							<a href="#" class="button1" id="btnEnviar">Enviar</a>
							<a href="#" class="button1" id="btnLimpar">Limpar</a>
						</div>
					</form>
				</div>
				<div id="map" class="content_map"></div>
			</div>
		</div>
	</div>
</article>
