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
							erro=check_any('Informe Técnico ',cont,erro);
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
									alert('La respuesta recomendada debe ser o Aceptada o Rechazada')
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
				if (!confirm('Va a rechazar la solicitud, esta completamante seguro?')){
				erro=true;
				}
			}
		}
		if(!erro){
			if(confirm('Se va a notificar al profesional solicitante\nEsta accion no puede ser revertida\nEstá seguro?')){
				return !erro;
			}else{
				return erro;
			}
		};
	};
