$(function() {
	jQuery
			.extend(
					jQuery.validator.messages,
					{
						required : MI.M03,
						remote : "Por favor, arrume este campo.",
						email : "Email incorreto",
						url : "Por favor, informe uma URL válida.",
						date : "Por favor, informe uma data válida.",
						dateISO : "Por favor, informe uma data válida (ISO).",
						number : "Por favor, informe um número válido.",
						digits : "Por favor, apenas dígitos.",
						creditcard : "Por favor, informe um número de Cartão de Crédito válido.",
						equalTo : "Por favor, informe o mesmo valor novamente.",
						accept : "Por favor, informe um valor com uma extensão válida.",
						maxlength : jQuery.validator
								.format("Por favor, no máximo {0} caracteres."),
						minlength : jQuery.validator
								.format("Por favor, pelo menos {0} caracteres."),
						rangelength : jQuery.validator
								.format("Por favor, um valor entre {0} e {1}."),
						range : jQuery.validator
								.format("Por favor, um valor entre {0} e {1}."),
						max : jQuery.validator
								.format("Por favor, no máximo {0}."),
						min : jQuery.validator
								.format("Por favor, no mínimo {0}.")
					});
	
	$.validator
		.setDefaults( {
			onfocusout : false,
			focusInvalid : false,
			onkeyup : false,
			onclick : false,
			validClass : '',
			showErrors : function(errorMap, errorList) {
				Validate.clear_erros();
				for (i in errorList) {
					if(this.settings.errorPlacement){
						var label = this.errorsFor( errorList[i].element );
						this.settings.errorPlacement(errorList[i].element, errorList[i].message);
					}
					Validate.show_errors(errorList[i].element, errorList[i].message);
				}
				
				if(errorList.length > 0){
					scrollTo(0, 0);
				}
			}
	});

	Validate._addMethods();
});
Validate = {
	_addMethods : function() {
		jQuery.validator
				.addMethod(
						"cpf",
						function(value, element) {
							var retorno = true;
							value = jQuery.trim(value);

							value = value.replace('.', '');
							value = value.replace('.', '');
							cpf = value.replace('-', '');
							if (cpf.length > 0) {
								while (cpf.length < 11)
									cpf = "0" + cpf;
								var expReg = /^0+$|^1+$|^2+$|^3+$|^4+$|^5+$|^6+$|^7+$|^8+$|^9+$/;
								var a = [];
								var b = new Number;
								var c = 11;
								for (i = 0; i < 11; i++) {
									a[i] = cpf.charAt(i);
									if (i < 9)
										b += (a[i] * --c);
								}
								if ((x = b % 11) < 2) {
									a[9] = 0;
								} else {
									a[9] = 11 - x;
								}
								b = 0;
								c = 11;
								for (y = 0; y < 10; y++)
									b += (a[y] * c--);
								if ((x = b % 11) < 2) {
									a[10] = 0;
								} else {
									a[10] = 11 - x;
								}

								if ((cpf.charAt(9) != a[9])
										|| (cpf.charAt(10) != a[10])
										|| cpf.match(expReg)) {
									retorno = false;
								}
							}
							return retorno;
						}, "CPF incorreto");

		jQuery.validator.addMethod("url_youtube", function(value, element){
			if($.trim(value) == ""){
				return true;
			}
			return value.indexOf("youtube.com/watch?v") != -1;			
		}, "Url inválida"),
		
		
		jQuery.validator
				.addMethod(
						"cnpj",
						function(cnpj, element) {
							cnpj = jQuery.trim(cnpj);// retira espaços em
							// branco
							// DEIXA APENAS OS NÚMEROS
							cnpj = cnpj.replace('/', '');
							cnpj = cnpj.replace('.', '');
							cnpj = cnpj.replace('.', '');
							cnpj = cnpj.replace('-', '');

							var numeros, digitos, soma, i, resultado, pos, tamanho, digitos_iguais;
							digitos_iguais = 1;

							if (cnpj.length < 14 && cnpj.length < 15) {
								return false;
							}
							for (i = 0; i < cnpj.length - 1; i++) {
								if (cnpj.charAt(i) != cnpj.charAt(i + 1)) {
									digitos_iguais = 0;
									break;
								}
							}

							if (!digitos_iguais) {
								tamanho = cnpj.length - 2;
								numeros = cnpj.substring(0, tamanho);
								digitos = cnpj.substring(tamanho);
								soma = 0;
								pos = tamanho - 7;

								for (i = tamanho; i >= 1; i--) {
									soma += numeros.charAt(tamanho - i) * pos--;
									if (pos < 2) {
										pos = 9;
									}
								}
								resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
								if (resultado != digitos.charAt(0)) {
									return false;
								}
								tamanho = tamanho + 1;
								numeros = cnpj.substring(0, tamanho);
								soma = 0;
								pos = tamanho - 7;
								for (i = tamanho; i >= 1; i--) {
									soma += numeros.charAt(tamanho - i) * pos--;
									if (pos < 2) {
										pos = 9;
									}
								}
								resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
								if (resultado != digitos.charAt(1)) {
									return false;
								}
								return true;
							} else {
								return false;
							}
						}, "CNPJ incorreto"); // Mensagem padrão
	},
	
	show_errors : function(element, msg){
		var obj = $(element);
		obj.parents(".control-group").addClass("error");
		obj.siblings("span.help-inline").text(msg);
	},
	
	clear_erros : function(){
		$("div.error").removeClass("error");
		$("fieldset .error").removeClass("error");
		$("span.help-inline").text("");
	}
};