var __html_grid = '<div class="well">RESULTADO</h3>&nbsp;&nbsp;&nbsp;<button id="btnCadastrar" class="btn btn-primary">INSERIR</button></div><table class="table">'+
				'<thead>'+
				'</thead>'+
				'<tbody>'+		        
				'</tbody>'+
				'</table>'+
				'<div class="well" id="paginacao">'+
				'</div>';

$(function(){
	$(document).ajaxStart(function(){
		$('body').append("<div id='mask'><div id='mask_back'></div><div>");
		$("#mask_back").css({
			background 	: 'white',
			opacity		: 0.35,
			position	: 'fixed',
			zIndex		: 9990,
			top			: 0,
			left		: 0,
			width		: $(window).width(),
			height		: $(window).height() 	
		});
		var div = $("<div id='mask_img'></div>").css({
			position	: 'absolute',
			zIndex		: 9999,
			top			: ($(window).height() / 2) - 35,
			left		: ($(window).width() / 2) - 75
		}).html("<img alt='carregando' src='"+url_img+"/carregando.gif'/>");
		$("#mask").append(div);
		
	}).ajaxStop(function(){
		$("#mask").remove();
	});
});

Uteis = {
	removeItemArray : function (array, removerIndice){
		for(var i = removerIndice; i < (array.length - 1); i++){
			array[i] = array[i+1];
		}
		array.pop();
		return array;
	}
}
