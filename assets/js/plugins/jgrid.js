$.unparam = function (value) { 
    if(value){
        var 
        // Object that holds names => values. 
        params = {}, 
        // Get query string pieces (separated by &) 
        pieces = value.split('&'), 
        // Temporary variables used in loop. 
        pair, i, l; 
        // Loop through query string pieces and assign params. 
        for (i = 0, l = pieces.length; i < l; i++) { 
            pair = pieces[i].split('=', 2); 
            // Repeated parameters with the same name are overwritten. Parameters 
            // with no value get set to boolean true. 
            params[pair[0]] = (pair.length == 2 ? pair[1].replace(/\+/g, ' ') : true); 
        } 
    }else{
        params = false;
    }
    
    return params; 
}; 

$.fn.jGrid = function(options) {
    var isto = this;
    var opts = $.extend({},$.fn.jGrid.defaults,options);    
    var html = '';
    var objDataCache = {};    
    var namespace = 'jGrid'+isto[0].id;
    
    GtCookie = {

        criar: function(name,value,days) {

            var expires;

            if (days) {
                var date = new Date();
                date.setTime(date.getTime()+(days*24*60*60*1000));
                expires = "; expires="+date.toGMTString();

            } else {
                expires = "";
            }

            document.cookie = name+"="+value+expires+"; path=/";
        },

        ler: function(name) {

            var nameEQ = name + "=";

            var ca = document.cookie.split(';');

            for(var i=0;i < ca.length;i++) {
                    var c = ca[i];

                    while (c.charAt(0)==' ') {
                        c = c.substring(1,c.length);
                    }

                    if (c.indexOf(nameEQ) == 0) {
                        return c.substring(nameEQ.length,c.length);
                    }
            }

            return null;
        },

        apagar: function(name) {
            GtCookie.criar(name,"",-1);
        }

    };
    
    var jGrid = {
        
        montaTbody: function(response, naoExibir){
            var limite = opts.limite;
            var html = '';
            var classCss, align, y;
            
            if(response.data) {            
                if(response.data.length < opts.limite){
                    limite = response.data.length;
                }
            }else{
                limite = 0;
            }
            
            if(limite > 0){
                
                for(var i = 0; i < limite; i++){                    
                    html += '<tr>';
                    y = 0;
                    for(var k in response.data[i]){
                    	width  = (opts.colluns[y].width)  ? 'style="word-wrap:break-word; width:'+opts.colluns[y].width+'%"' : '';
                        align  = (opts.colluns[y].align)  ? 'align="'+opts.colluns[y].align+'"' : 'align="center"';
                        html += '<td><div '+width+' '+align+'>'+response.data[i][k]+'</div></td>';
                        y++;
                    }
                    html += '</tr>';
                }
                
                $(isto).find('tbody').html(html);
                jGrid.__atualizaCookie(response);
            }else{
                $(isto).text(opts.msgExcessao);
            }                        
        },
        
        __atualizaCookie : function(response){
        	if(opts.cacheCookie){
        		var totalPaginas = Math.ceil(parseFloat(response.total) / parseFloat(opts.limite));
            	var cookie	= $.unparam(GtCookie.ler(namespace));
            	if(totalPaginas > 0 && cookie.pagina > totalPaginas){
            		jGrid.reload({pagina: totalPaginas});
            	}
        	}
        },
        
        __montaPaginacao_1: function(response, paginaAtual, limite){
            var html = '';
             
            var iniPage = paginaAtual-2;
            if(iniPage < 1){
                iniPage = 1;
            }
            
            var numPage   = iniPage+5;
            var totalPage = Math.ceil(response.total/opts.limite);
            
            if(numPage > totalPage){
                numPage = totalPage+1;
                iniPage = totalPage-4;
            }
            
            if(iniPage < 1){
                iniPage = 1;
            }
            
            html += '<div class="btn-toolbar" id="gt-grid-paginacao" align="center">';
            
            if(totalPage > 1){
            	html += '<div class="btn-group">';
            
	            if(paginaAtual == 1){
	            	html += '<button class="btn disabled">&lt;&lt;</button>';
					html += '<button class="btn disabled">&lt;</button>';
	            }else{
	            	html += '<button class="btn" id="gt-grid-inicio">&lt;&lt;</button>';
	            	html += '<button class="btn" id="gt-grid-aterior">&lt;</button>';            					               
	            }
	            
	            for(var i = iniPage; i < numPage; i++ ){
	                if(i != paginaAtual){
	                    html += '<button class="btn gt-grid-paginas">'+i+'</button>';                                       
	                }else{
	                	html += '<button class="btn btn-info">'+i+'</button>';                    
	                }
	            }
	            
	            if(paginaAtual == totalPage || totalPage == '0'){
	            	html += '<button class="btn disabled">&gt;</button>';
					html += '<button class="btn disabled">&gt;&gt;</button>';                           
	            }else{
	                html += '<button class="btn" id="gt-grid-proximo">&gt;</button>';
					html += '<button class="btn" id="gt-grid-fim">&gt;&gt;</button>';            
	            }
            	html += '</div>';
            }            
            html += '</div>';
			
            $('#gt-grid-paginacao').remove();
            $(isto).append(html);                                 
            
            $(isto).find('.gt-grid-paginas').each(function(){
                $(this).bind('click', function(){
                    jGrid.reload({pagina:$(this).text()});
                });
            });
            
            if(paginaAtual != 1){
                $(isto).find('#gt-grid-inicio').click(function(){
                    jGrid.reload({pagina: 1});
                });

                $(isto).find('#gt-grid-aterior').click(function(){
                    jGrid.reload({pagina: paginaAtual-1});
                });
            }
            
            if(paginaAtual != (totalPage) && totalPage != '0'){
                $(isto).find('#gt-grid-proximo').click(function(){
                    jGrid.reload({pagina: paginaAtual+1});
                });

                $(isto).find('#gt-grid-fim').click(function(){
                    jGrid.reload({pagina: totalPage});
                });
            }
        },        
        
        montaTfoot: function(response, paginaAtual){
            //response.total = 2000;
            paginaAtual    = (paginaAtual) ? paginaAtual : 1;
            response.total = (response.total) ? response.total : 0;
            
            var limite = opts.limite*paginaAtual;            
            if(limite > response.total){
                limite = response.total;
            }
            this.__montaPaginacao_1(response, paginaAtual, limite);
         },

        __detectOrder: function(data, cache){
            var order;
            
            if(data && data.order){                                                
                var orderUrl = (cache) ? cache.order.split(' ') : ['1', 'DESC'];                
                order = (orderUrl[0] == data.order && orderUrl[1] == 'ASC') ? data.order+' DESC' : data.order+' ASC';
            }else{            
                order = (cache.order) ? cache.order : '1 ASC';                                                                                    
            }
                        
            $(isto).find('.gt-grid-order-asc, .gt-grid-order-desc').removeClass('gt-grid-order-asc gt-grid-order-desc'); 
             
            var orderNow =  order.split(' ');
            
            if(orderNow[1] == 'ASC'){
                $(isto).find('#gt-grid-order-'+orderNow[0]+' span').addClass('gt-grid-order-asc');
            }else{
                $(isto).find('#gt-grid-order-'+orderNow[0]+' span').addClass('gt-grid-order-desc');
            }
            
            return order;
            
        },
        
        __setStorage: function(objData){
            
            var dataSer = $.param(objData);
            
            if(opts.cacheUrl){
                window.location.hash = dataSer;
            }
            
            if(opts.cacheCookie){
                GtCookie.criar(namespace, dataSer, 0);
            }                        
            
            return dataSer;
        },
        
        __renderGrid: function(data){
        	
        	var dataSerialized = this.__setStorage(objDataCache);
        	        	
        	if(opts.type == 'url'){
        		        	
        		$.ajax({
                    url: opts.url,
                    async: false,
                    type:'get',
                    data: dataSerialized,
                    dataType:'json',
                    success: function(response) {
        				jGrid.build_table();
                        jGrid.montaTbody(response, true);
                        jGrid.montaTfoot(response, objDataCache.pagina);
                        
                        if(opts.success){
                        	opts.success(response);
                        }
                        
                        if(data && data.callback){
                            data.callback(response);
                        }
                    }
                });
        		        		
        	}else{
        		
        		var arrObj   = opts.json();
        		var response = {total:0, data:[]};
        		
        		if(arrObj != null){
        			
	        		response.total = arrObj.length;
	        		
	        		var inicio = opts.limite*(objDataCache.pagina-1);
	        		var fim    = inicio+opts.limite;
	        		if(fim > response.total){
	        			fim = response.total;
	        		}
	        		
	        		for(var i = inicio; i < fim; i++){	        			
	        			response.data.push(arrObj[i]);
	        		}
        		}

        		jGrid.montaTbody(response);
                jGrid.montaTfoot(response, objDataCache.pagina);
                
                if(opts.success){
                	opts.success();
                }
                
                if(data && data.callback){
                    data.callback(data.data);
                }        		        		        
        	}
        },
        
        show_message : function(msg){
    		var html = '<div class="mensagem">'+
    						'<div class="mensagem_frase">'+msg+'</div>'+
    				   '</div>'
    		$("#erros").html(html);	
    		window.scrollTo(0, 0);
    	},
        
        reload: function(data){
            if(data && data.consultar){
                for(i in opts.data){                	
                    if(opts.data[i].val() != '' && opts.data[i].attr('disabled') != 'disabled'){
                        objDataCache[i] = unescape(opts.data[i].val());                        
                    }else{
                        delete objDataCache[i];
                    }                                         
                }
                var cookie = $.unparam(GtCookie.ler(namespace));
                objDataCache.pagina = cookie.pagina ? cookie.pagina : 1;                               
            }
            
            if(data){
            	if(data.pagina){
            		objDataCache.pagina = parseInt(data.pagina);
            	}
            	
            	objDataCache.limite = (data.limite) ? data.limite : opts.limite;
            	objDataCache.order  = this.__detectOrder(data, objDataCache);
            }
                                  
           this.__renderGrid(data);
        },
        
        build_table : function(){
        	html = '<table id="gt-grid-table" class="table" width="'+opts.width+'" cellpadding="0" cellspacing="0" border="0">';
            html += '<thead>';
            html += '<tr class="tr_th">';
            
            var align, classe;
            for(var i in opts.colluns){        
                align  = (opts.colluns[i].align) ? 'align="'+opts.colluns[i].align+'"' : 'align="center"';
                classe = (opts.colluns[i].classe) ? 'class="'+opts.colluns[i].classe+'"' : '';
                html += '<th '+classe+' height="25" width="'+opts.colluns[i].width+'%" '+align+'><div id="gt-grid-order-'+(parseInt(i)+1)+'">'+opts.colluns[i].header+' <span class="gt-icons"></span></div></th>';
            }
            html += '</tr>';
            html += '</thead>';
            
            html += '<tbody>';    
            html += '</tbody>';
            
            html += '<tfoot>';    
            html += '</tfoot>';
                
            html += '</table>';
            
            $(isto).html(html);                
            
            $(isto).find('thead span[class!="gt-icons"]').each(function(i){
            	if(opts.colluns[i].order){
        	        $(this).bind('click', function(){
        	            jGrid.reload({pagina:1,order:(i+1)});
        	        });
            	}
            });
        }
    };           
    
    var hash = {};            
    
    if(opts.cacheUrl || opts.cacheCookie){
        hash = $.unparam(window.location.hash.substring(1));
    }               
    
    if(opts.IniReload || hash.jgrid){
    	
    	if(hash.jgrid){
            var cookieSer = GtCookie.ler(namespace);
            
            if(cookieSer){
                hash = $.unparam(cookieSer);  
            }
			            
            //window.location.hash = '';
            if(opts.cacheUrl){
                window.location.hash = cookieSer;
            }
        }
    	
        /*popula inputs*/
        for(i in hash){        	
            if(hash[i] && $.inArray(i, ['pagina', 'limite', 'order']) == -1 && opts.data[i]){
                opts.data[i].val(decodeURIComponent(hash[i]));               
            }                
        }
        /*popula inputs*/
        
        var objDataUrl = {consultar:true};
        
        if(hash){
            objDataCache = hash;
        }
        
        if(hash.pagina){
            objDataUrl.pagina = hash.pagina;
            //objDataUrl.consultar = true;
        }

        if(hash.limite) {
            objDataUrl.limite = hash.limite;
            //objDataUrl.consultar = true;
        }                                
        
        jGrid.reload(objDataUrl);       
        
    }else{
    	jGrid.montaTbody({data:[]}, false);
        jGrid.montaTfoot({total:0}, 1);
    }
    
    return jGrid;
};


$.fn.jGrid.defaults = {
    limite: 15
    ,success: false
    ,type: 'url'
    ,source: ''
    ,colluns: []
    ,data : {}
    ,IniReload : true
    ,cacheUrl: false
    ,cacheCookie: true
    ,msgExcessao: 'Nenhum registro encontrado' 
    ,width: ''
};