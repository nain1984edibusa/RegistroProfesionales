 <!--
	function validate()
	{
		var erro=false;
		var elem=document.post1.length-1;
		var cont="";
		var chequed;
		var chkinv;
		var nam,chfa1,chfa2,chfa3,chfa4,chfa5,chfa6;
		for (var i=0; i <= elem; i++){
			nam= document.post1.elements[i].name;
			chkinv=1;
			chequed=false;
			switch (document.post1.elements[i].type){
				case "text":
					var mess="especificar: campo";
					cont=document.post1.elements[i].value; 
					  switch (nam){
						case "docid":
						   if(checkci){erro=check_ci(cont,erro,1);}else{erro=check_any('Documento Identificacion',cont,erro);};
						break;
						case "username":
							erro=check_usrname('Nombre de usuario',cont,erro);
						break;
						case "rname":
							chkinv=0;
							erro=check_any('Nombres y Apellidos',cont,erro);
						break;
						break;
						case "tmovil":
							if(cont!=''){erro=check_tlf('Tlf movil',cont,erro);};
						break;
						case "tfijo":
							if (cont!=''){erro=check_tlf('Tlf fijo',cont,erro);};						
					        break;
						case "mail":
							erro=check_mail('Correo electronico ',cont,erro);
						break;
						case "mail2":
							if (cont!=''){erro=check_mail('Correo electronico 2',cont,erro);};
						break;
						case "fec_resc":
							var f_resc=cont
						break;
					  };
					if(chkinv){
						if (invalid_chars(cont)){erro=true;};
					};
				break;
				case "select-one":
					erro=erro;
					cont=String(document.post1.elements[i].options[document.post1.elements[i].selectedIndex].value);
					switch (document.post1.elements[i].name){
						case "idTipoDocID":
							var un_t_c_cont=''
							switch (cont){
								case "1":
									checkci=1;
								break;
								case "2":
									checkci=0;
								break;
							}
						break;
					};
				break;
				case "select-multiple":
					var mess="escoger una opcion en ";
					cont=String(document.post1.elements[i].options[document.post1.elements[i].selectedIndex].value);
					if ( cont== "undefined" ){
						alert ('Debe  '+mess+' '+nam);
						erro = true;
					};
					erro=erro;
				break;
				case "checkbox":
					erro=erro;
				break;
				case "hidden":

				break;
				case "textarea":
					var mess="llenar el campo";
					cont=document.post1.elements[i].value;
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
				document.post1.elements[i].focus();
				break;
			};
		};
		if(!erro){
//			if(chfa1!=1 && chfa2!=1 && chfa3!=1 && chfa4!=1 && chfa5!=1 && chfa6!=1 ){
//				erro=true;
//				alert('Debe proporcionar al menos un Titulo obtenido');
//			}
		}
		if(!erro){
			if(confirm('Esta seguro de la informacion ingresada?\nAsegurese de que sean correctos especialmente los correos electronicos')){
				return !erro
			}else{
				return erro
			}
		};
	};
