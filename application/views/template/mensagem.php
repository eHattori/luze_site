<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<label><strong>Mensagem enviada por:</strong> <?php echo $nome?> [<?php echo $email?>]</label><br/>
<?php if(isset($telefone) && $telefone){?>
	<label><strong>Telefone:</strong> <?php echo $telefone?></label><br/>
<?php }?>
<label><strong>Assunto:</strong> <?php echo $assunto?></label><br/>
<label><strong>Mensagem:</strong></label><br/>
<div>
	<?php echo str_replace("\n", "<br>", htmlspecialchars($textarea))?>
</div>
</body>
</html>