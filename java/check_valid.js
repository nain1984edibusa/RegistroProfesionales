 <!--
	function validate(forma)
	{
		var erro=false;
		var elem=document.forms[forma].length-1;
		var cont="";
		var alerta=0;
		var chkcod=0;
		var chkupl=0;
		var chkofr=0;
		var chkinv;
		var nam,cpip,cpfa;
		var ms='';
		for (var i=0; i <= elem; i++){
			nam= document.forms[forma].elements[i].name;
			chkinv=1;
			chequed=false;
			switch (document.forms[forma].elements[i].type){
				case "text":
					var mess="especificar: campo";
					cont=document.forms[forma].elements[i].value; 
					  switch (nam){
						case "doc-ref":
							erro=check_any('Referencia Informe Técnico ',cont,erro);
						break;
						case "resp_ref":
							if (chkofr){
								erro=check_any('Oficio Respuesta ',cont,erro);
							}							
						break;
/*						case "cod_pro":
							if(chkcod){
								if(cont==cher.basecod.value || cont==''){
									alert('Debe Especificar un Nuevo Codigo de registro')
									document.forms[forma].elements[i].value=cher.basecod.value;
									erro=true;
								}								
							};
						break;*/
					  };
					if(chkinv){
						if (invalid_chars(cont)){erro=true;};
					};
				break;
				case "select-one":
					erro=erro;
					cont=String(document.forms[forma].elements[i].options[document.forms[forma].elements[i].selectedIndex].value);
					var sol_est=cont;
					switch (document.forms[forma].elements[i].name){
						case "recomendacion":
							switch (cont){
								case "rechazada":
									alerta=1;
									chkupl=1;
									chkofr=1;
								break;
								case "0":
									alert('La respuesta recomendada debe ser o ACEPTADA o RECHAZADA')
									erro=true;
								break;
								default:
									chkcod=1;									
								break;
							}
							document.forms[forma].recomendacion_.value=cont;
						break;
						case "cod_pro":
							if (chkcod && document.forms[forma].elements[i].length > 1)
							ms+='\nAsegúrese de escoger el código correcto, ya que en éste registro hay dos alternativas\n';
						break;
					};
				break;
				case "hidden":
					cont=document.forms[forma].elements[i].value; 
					switch (nam){
						case "floaded":
							switch (cont){
								case "0":
									if (chkupl){
										alert('Debe cargar el Archivo PDF de Oficio de Respuesta RECHAZADA')
										erro=true;
									};
								break;								
							}
						break;
						case "valdp":
							switch (cont){
								case "":
									alert('Debe validar Datos Personales, use INFODIGITAL')
									erro=true;
								break;								
							}
							cpip=cont;
						break;
						case "valacad":
							switch (cont){
								case "":
									alert('Debe validar Datos Académicos, use INFODIGITAL')
									erro=true;
								break;
							}
							cpfa=cont
						break;
					};
				break;
				case "textarea":
					var mess="llenar el campo";
					cont=document.forms[forma].elements[i].value;
//					if(!invalid_chars(cont)){
					  switch (nam){
						case "mot_resci":
						        var mot_res=cont;
						break;
					  };
//					}else{
//					  erro=true;
//					};
				break;
			};
			if (erro){
				document.forms[forma].elements[i].focus();
				break;
			};
		};
var isok=1;
/*		if(cpip==0 || cpfa==0){
			ms+='Con base en el resultado de la validacion esta solicitud se debe RECHAZAR '
			isok=0;
		}
		if((cpip==0 || cpfa==0) and sol_est=='aprobada'){
			alert('Con base en el resultado de la validacion esta solicitud se debe RECHAZAR ')
			isok=0;
		}*/

		if(!erro){
			if(alerta){
				if (!confirm('Va a RECHAZAR la solicitud, desea continuar?')){
				erro=true;
			}
		}
			if(!alerta && ms!='')
				alert(ms);
			}
		if(!erro){
			if(confirm('Una vez realizada esta acción, no puede ser revertida')){
				return !erro
			}else{
				return erro
			}
		};
	};
