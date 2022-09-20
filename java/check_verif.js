 <!--
	function validate(forma)
	{
		var erro=false;
		var elem=document.forms[forma].length-1;
		var cont="";
		var alerta=0;
		var chkcod=0;
		var chkinv;
		var nam;
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
							erro=check_any('Oficio Respuesta ',cont,erro);
						break;
					  };
					if(chkinv){
						if (invalid_chars(cont)){erro=true;};
					};
				break;
				case "select-one":
					erro=erro;
					cont=String(document.forms[forma].elements[i].options[document.forms[forma].elements[i].selectedIndex].value);
					switch (document.forms[forma].elements[i].name){
						case "recomendacion":
							switch (cont){
								case "rechazada":
									alerta=1;
								break;
								case "0":
									alert('La respuesta debe ser o ACEPTADA o RECHAZADA')
									erro=true;
								break;
								default:
									chkcod=1;									
								break;
							}
						break;
					};
				break;
				case "hidden":

				break;
				case "textarea":
					var mess="llenar el campo";
					cont=document.forms[forma].elements[i].value;
					if(!invalid_chars(cont)){
					  switch (nam){
						case "mot_resci":
						        var mot_res=cont;
						break;
					  };
					}else{
					  erro=true;
					};
				break;
			};
			if (erro){
				document.forms[forma].elements[i].focus();
				break;
			};
		};
		if(!erro){
			if(alerta){
				if (!confirm('Va a RECHAZAR la solicitud, desea continuar?')){
				erro=true;
				}
			}
		}
		if(!erro){
			if(confirm('Una vez realizada esta acción, no puede ser revertida')){
				return !erro
			}else{
				return erro
			}
		};
	};
