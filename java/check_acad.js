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
			chkinv=0;
			chequed=false;
			switch (document.post1.elements[i].type){
				case "text":
					var mess="especificar: campo";
					cont=document.post1.elements[i].value; 
					  switch (nam){
						case "ntitulo":
							if (chfa1){erro=check_any('Nombre Titulo 1',cont,erro);};
						break;
						case "ninstitucion":
							if (chfa1){erro=check_any('Institucion 1',cont,erro);};
						break;
						case "codigo":
							if (chfa1){erro=check_any('Codigo Registro Senescyt 1',cont,erro);};
						break;
						case "ftitulo":
							if (cont!=''){erro=check_date('Fecha Graduacion 1',cont,erro);};
						break;
						case "ntitulo2":
							if (chfa2==1){erro=check_any('Nombre Titulo 2',cont,erro);};
						break;
						case "ninstitucion2":
							if (chfa2==1){erro=check_any('Institucion 2',cont,erro);};
						break;
						case "codigo2":
							if (chfa2==1){erro=check_any('Codigo Registro Senescyt 2',cont,erro);};
						break;
						case "ftitulo2":
							if (cont!=''){erro=check_date('Fecha Graduacion 2',cont,erro);};
						break;
						case "ntitulo3":
							if (chfa3==1){erro=check_any('Nombre Titulo 3',cont,erro);};
						break;
						case "ninstitucion3":
							if (chfa3==1){erro=check_any('Institucion 3',cont,erro);};
						break;
						case "codigo3":
							if (chfa3==1){erro=check_any('Codigo Registro Senescyt 3',cont,erro);};
						break;
						case "ftitulo3":
							if (cont!=''){erro=check_date('Fecha Graduacion 3',cont,erro);};
						break;
						case "ntitulo4":
							if (chfa4==1){erro=check_any('Nombre Titulo 4',cont,erro);};
						break;
						case "ninstitucion4":
							if (chfa4==1){erro=check_any('Institucion 4',cont,erro);};
						break;
						case "codigo4":
							if (chfa4==1){erro=check_any('Codigo Registro Senescyt 4',cont,erro);};
						break;
						case "ftitulo4":
							if (chfa4==1){erro=check_date('Fecha Graduacion 4',cont,erro);};
						break;
						case "ntitulo5":
							if (chfa5==1){erro=check_any('Nombre Titulo 5',cont,erro);};
						break;
						case "ninstitucion5":
							if (chfa5==1){erro=check_any('Institucion 5',cont,erro);};
						break;
						case "codigo5":
							if (chfa5==1){erro=check_any('Codigo Registro Senescyt 5',cont,erro);};
						break;
						case "ftitulo5":
							if (chfa5==1){erro=check_date('Fecha Graduacion 5',cont,erro);};
						break;
						case "ntitulo6":
							if (chfa6==1){erro=check_any('Nombre Titulo 6',cont,erro);};
						break;
						case "ninstitucion6":
							if (chfa6==1){erro=check_any('Institucion 6',cont,erro);};
						break;
						case "codigo6":
							if (chfa6==1){erro=check_any('Codigo Registro Senescyt 6',cont,erro);};
						break;
						case "ftitulo6":
							if (chfa6==1){erro=check_date('Fecha Graduacion 6',cont,erro);};
						break;

					  };
					if(chkinv){
						if (invalid_chars(cont)){erro=true;};
					};
				break;
				case "select-one":

				break;
				case "select-multiple":

				break;
				case "checkbox":
					erro=erro;
				break;
				case "hidden":
					cont=document.post1.elements[i].value;
					  switch (nam){
						case "fa1":
						        chfa1=cont*1;
						break;
						case "fa2":
						        chfa2=cont*1;
						break;
						case "fa3":
						        chfa3=cont*1;
						break;
						case "fa4":
						        chfa4=cont*1;
						break;
						case "fa5":
						        chfa5=cont*1;
						break;
						case "fa6":
						        chfa6=cont*1;
						break;
					  };
				break;
				case "textarea":

				break;
			};
			if (erro){
				document.post1.elements[i].focus();
				break;
			};
		};
		if(!erro){
			if(typeof post1.idPaisr !== 'undefined'){

			}else{
				if(!chfa1 && !chfa2){
					erro=true;
					alert('Debe proporcionar al menos un nuevo  Titulo obtenido');
				}
			
			}
		}
		if(!erro){
			if(confirm('Seguro de los datos a Ingresar??\n\nPara confirmar ponga Aceptar')){
				return !erro
			}else{
				return erro
			}
		};
	};
