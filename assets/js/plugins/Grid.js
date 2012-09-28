//CONSTANTES DE ACOES
var ALL        = 0;
var VISUALIZAR = 1;
var EDITAR     = 2;
var EXCLUIR    = 3;

//CONSTANTES DE TIPOS
var LIKE  = 4;
var WHERE = 5;

function GridDinamica(options) {
		this.defaults = {
		    		id 				: '',
		    		chave			: 'id',
		    		limite          : 10,
		    		offset          : 1,
		    		entidade		: '',
		    		ordem   		: '',
		    		sortable   		: true,
		    		direcao 		: 'ASC',
		    		url           	: '/gridcontroller/ajaxPesquisaGrid',
		    		showBtnCadastrar: true,
		    		colunas			: new Array(),
		    		acoes			: new Array(),
		    		pesquisa        : new Array(),
		    		visualizar      : null,
		    		editar          : null
	            };
		this.tipoTabela	= __html_grid;
		this.classes 	= {
				tr_th : '',
				td    : 'td',
				acoes : 'btn-group',
				thead : ' thead',
				tbody : ' tbody',
				paginacao : '#paginacao',
				tr_escura : '',
				tr_clara  : ''
		};
		this.callback = function() {};
		this.current  = this.defaults.offset;
		this.data = new Array();
		this.carregar = function(obj_param){	
			
			if(obj_param == null){
				obj_param  = {pagina: 1};
			};
			
			this.renderGrid();
			this.defaults.offset = calculaOffset(obj_param.pagina, this.defaults.limite);
			var _this  = this;
			if(this.defaults.ordem == ''){
				this.defaults.ordem = this.defaults.chave;
			}
			$("#hdDados").val(JSON.stringify(this.defaults));		
			
			$.ajax({
				url: site_url+_this.defaults.url,
				type: "post",
				async: false,
			    data: $('form').serialize(),
			    dataType: "json",
			    success: function(json){
						if (!json.dados.length > 0) {			    		
								json.total = 0;
						}
						_this.total = json.total;
						_this.montaTr(json);					    		
					    _this.montaPaginacao(json.total,_this.defaults.limite, obj_param.pagina);
					    _this.bind();
					},
					complete: function(){
						_this.callback();						
					}
			});
			{
				
			}
		};
		this.renderGrid = function(){
			
			var id = "#" + this.defaults.id;
			var colunas  = this.defaults.colunas;
			var classes  = this.classes;
			
			if(!$(id).attr("class")){
				
				var tbhtml = this.tipoTabela;
				$(id).html(tbhtml);
				$(id).addClass("grid");
				$(id).prepend("<input type='hidden' id='hdDados' name='dados'value='' />");
				
				if(!this.defaults.showBtnCadastrar){
                    $(id+" #btnCadastrar").hide();
                }

				var thead = "<tr class='"+classes.tr_th+"'>";
				count = 0;
				
				var tam = colunas.length;
				
				for(var i in colunas){					
					++count;
					if(this.defaults.acoes.length > 0 && count == tam){						
						thead += '<th width="'+colunas[i].tamanho+'" height="25"><div style="width:'+colunas[i]+';" class="'+classes.acoes+'">'+colunas[i].titulo+'</div></th>';
					} else {
						thead += '<th width="'+colunas[i].tamanho+'" height="25"><div style="width:'+colunas[i].tamanho+';"><a id="orderBy" href="#" title="'+colunas[i].campo+'" >'+colunas[i].titulo+'</a></div></th>';
					}
				}
				thead += "</tr>";		
					$(id + " "+classes.thead).html(thead);
			}
		};
		this.montaTr =  function(json){
			var limite = json.dados.length;			
			var html = '';
			var aObjs = json.dados;
			var colunas  = this.defaults.colunas;
			
			if(limite > 0){	
				for(var i = 0; i < limite; i++){
					classCss = (i % 2 == 0) ? this.classes.tr_escura : this.classes.tr_clara;
					html += '<tr class="'+classCss+'">';
					var count = 0;
					
					for(var key in aObjs[i]){
						
						if(isChave(key, colunas) || key == "acoes"){

							aObjs[i][key] = replaceAll(aObjs[i][key], '&lt;br /&gt;', '');
							var tam = (colunas.length-1);
							
							++count;							
							
							if(this.defaults.acoes.length && count == tam){								
								html += '<td height="25"><div class="'+this.classes.acoes+'">'+aObjs[i][key]+'</div></td>';
								
							} else {
								html += '<td height="25" class="td" ><div class="'+this.classes.td+'">'+aObjs[i][key]+'<div></td>';							
							}
						}
					}
					html += "</tr>";	
				}
				
			} else {
				var colunas = colunas.length;
				html += '<tr class="'+this.classes.tr_clara+'"><td height="25" colspan="'+colunas+'">Nenhum registro encontrado!</td></tr>';
			}			
			var id = "#" + this.defaults.id + " "+this.classes.tbody;
			$(id).html(html);
		};
		this.montaPaginacao =  function(total, limite, paginaAtual){			
			var html = '';
			var limite = Math.ceil(total/limite);
			var qtd = 5; 
			
			if (total > limite && this.defaults.limite < total){
				if((paginaAtual - 1) != 0){
					paginaAnterior = parseInt(paginaAtual-1);
					html += '<div class="btn"><a href="#" title="1"><i class="icon-fast-backward"></i></a></div>';
					html += '<div class="btn"><a href="#" title="'+paginaAnterior+'"><i class="icon-step-backward"></i></a></div>';
				}else{
					html = '<div class="btn"><i class="icon-fast-backward"></i></div>';
					html += '<div class="btn"><i class="icon-step-backward"></i></div>';
				}
				
				if(paginaAtual > 3){
					var link = paginaAtual - 2;
				} else {
					var link = 1;
				}
				
				for(var i = 0; i < qtd; i++){
					pag = link++;				
						if(paginaAtual == pag){
							html += '<div class="btn btn-primary">'+pag+'</a></div>';
						} else {							
							html += '<div class="btn">';
							html += '<a href="#" title="'+pag+'">'+pag+'</a></div>'; 
						}					
					if(pag >= limite){
						break;
					}
				}

				if(paginaAtual != limite){
					paginaProx = parseInt(paginaAtual+1);
					html += '<div class="btn">';
						html +=	'<a href="#" title="'+paginaProx+'"><i class="icon-step-forward"></i></a></div>';
					html += '<div class="btn">';
						html += '<a href="#" title="'+limite+'"><i class="icon-fast-forward"></i></a></div>';
				}else{
					html += '<div class="btn"><i class="icon-step-forward"></i></div>';
					html += '<div class="btn"><i class="icon-fast-forward"></i></div>';
				}

			}           
			var id = "#" + this.defaults.id + " " + this.classes.paginacao;
			
			$(id).html(html);
		};
		this.visualizar = function(id){
			if(this.defaults.visualizar == null){
				window.location.href = site_url + this.defaults.entidade.toLocaleLowerCase()+"controller/visualizar/"+id;				
			} else {
				this.defaults.visualizar(id);
			}
		};
		this.editar = function(id){			
			if(this.defaults.editar == null){
				window.location.href = site_url + "admin/"+this.defaults.entidade.toLocaleLowerCase()+"controller/editar/"+id;
			} else {
				this.defaults.editar(id);
			}
		};
		this.bind = function(){
			var id = "#"+this.defaults.id+" "+this.classes.paginacao+" a";
			var _this = this;
			$(id).die().live('click',function(){
				 _this.carregar({pagina: $(this).attr("title")});
				 return false;
			});
			
			$("#"+this.defaults.id+" a[id^='visualizar_grid_']").die().live("click",function(){
				var id = retornaId($(this));		
				_this.visualizar(id);
			});
			
			$("#"+this.defaults.id+" a[id^='editar_grid_']").die().live("click",function(){
				var id = retornaId($(this));		
				_this.editar(id);
			});
			
			$("#"+this.defaults.id+" a[id='orderBy']").die().live("click",function(){
				var ordem = $(this).attr("title");
				if(_this.defaults.ordem){
					if(_this.defaults.direcao == "ASC"){
						_this.defaults.direcao = "DESC";
					} else {
						_this.defaults.direcao = "ASC";
					}
				}
				
				_this.defaults.ordem = ordem;
				_this.carregar({pagina:1});
				return false;
				
			});

			
			$("#"+this.defaults.id+" a[id^='excluir_grid_']").die().live("click",function(){
				if(confirm("Deseja excluir este registro?")){
					
					var id = retornaId($(this));		
					$.ajax({
						url: site_url + "/gridcontroller/excluir/"+id,
						type: "post",
						async: false,
					    data: $('form').serialize(),
					    dataType: "json",
					    success: function(result){
							if(result == 1){								
								alert("Exclusão realizada com sucesso");
								_this.carregar({pagina: calculaOffset(_this.defaults.offset,_this.defaults.limite)});
							}
						}
					});
				}
				return false;				
			});
				
		};
		{
			this.defaults = $.extend(this.defaults, options);
			this.carregar();
		}		
};

function lengthJson(objJson) {

	var count = 0;

	for ( var key in objJson) {
		count++;
	}

	return count;
};

function replaceAll(string, token, newtoken) {
        while (string.indexOf(token) != -1) {
              string = string.replace(token, newtoken);
        }
        return string;
};

function calculaOffset(pagina , limite){
	var offset = 0;
	if(pagina > 1){
		offset = (pagina -1) * limite;
	}			
	return offset;
};

function retornaId(elemento){
	var array =  elemento.attr("id").split('_');	
	return array[2];
};

function isChave(key, colunas){
	for(i in colunas){
		if(colunas[i].campo == key){
			return true;
		}
	}
	return false;
}