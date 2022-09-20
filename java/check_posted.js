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
						case "docid":
						   if(checkci){erro=check_ci(cont,erro,1);}else{erro=check_any('Documento Identificacion',cont,erro);};
						break;
						case "name":
							erro=check_any('Nombres',cont,erro);
						break;
						case "lname":
							erro=check_any('Apellidos',cont,erro);
						break;
						break;
						case "ciudadr":
							chkinv=0;
							erro=check_any('Ciudad Residencia',cont,erro);
						break;
						case "direc":
							erro=check_any('Direccion',cont,erro);
						break;
						case "fnac":
							erro=check_date('Fecha Nacimiento',cont,erro);
						break;
						case "ntitulo":
							if (post1.profes.value==2){
								if (cont !='' || chfa1){erro=check_any('Nombre Titulo 1',cont,erro);chfa1=1;};
							}else{
								erro=check_any('Nombre Titulo 1',cont,erro);chfa1=1;
							};
						break;
						case "ninstitucion":
							if (post1.profes.value==2){
								if (cont !='' || chfa1){erro=check_any('Institucion 1',cont,erro);chfa1=1;};
							}else{
								erro=check_any('Institucion 1',cont,erro);
							}
						break;
						case "codigo":
							if (post1.profes.value==2){
								if (cont !='' || chfa1){erro=check_any('Codigo Registro Senescyt 1',cont,erro);chfa1=1;};
							}else
							{	
								erro=check_any('Codigo Registro Senescyt 1',cont,erro);
							};
						break;
						case "ftitulo":
							if (post1.profes.value==2){
								if (cont!='' || chfa1){erro=check_date('Fecha Graduacion 1',cont,erro);chfa1=1;};
							}else
							{
								erro=check_date('Fecha Graduacion 1',cont,erro);
							};
						break;
						case "ntitulo2":
							if (cont!='' || chfa2){erro=check_any('Nombre Titulo 2',cont,erro);chfa2=1;};
						break;
						case "ninstitucion2":
							if (cont!='' || chfa2){erro=check_any('Institucion 2',cont,erro);chfa2=1;};
						break;
						case "codigo2":
							if (cont!='' || chfa2){erro=check_any('Codigo Registro Senescyt 2',cont,erro);chfa2=1;};
						break;
						case "ftitulo2":
							if (cont!='' || chfa2){erro=check_date('Fecha Graduacion 2',cont,erro);chfa2=1;};
						break;
						case "ntitulo3":
							if (cont!='' || chfa3){erro=check_any('Nombre Titulo 3',cont,erro);chfa3=1;};
						break;
						case "ninstitucion3":
							if (cont!='' || chfa3){erro=check_any('Institucion 3',cont,erro);chfa3=1;};
						break;
						case "codigo3":
							if (cont!='' || chfa3){erro=check_any('Codigo Registro Senescyt 3',cont,erro);chfa3=1;};
						break;
						case "ftitulo3":
							if (cont!='' || chfa3){erro=check_date('Fecha Graduacion 3',cont,erro);chfa3=1;};
						break;
						case "ntitulo4":
							if (cont!='' || chfa4){erro=check_any('Nombre Titulo 4',cont,erro);chfa4=1;};
						break;
						case "ninstitucion4":
							if (cont!='' || chfa4){erro=check_any('Institucion 4',cont,erro);chfa4=1;};
						break;
						case "codigo4":
							if (cont!='' || chfa4){erro=check_any('Codigo Registro Senescyt 4',cont,erro);chfa4=1;};
						break;
						case "ftitulo4":
							if (cont!='' || chfa4){erro=check_date('Fecha Graduacion 4',cont,erro);chfa4=1;};
						break;
						case "ntitulo5":
							if (cont!='' || chfa5){erro=check_any('Nombre Titulo 5',cont,erro);chfa5=1;};
						break;
						case "ninstitucion5":
							if (cont!='' || chfa5){erro=check_any('Institucion 5',cont,erro);chfa5=1};
						break;
						case "codigo5":
							if (cont!='' || chfa5){erro=check_any('Codigo Registro Senescyt 5',cont,erro);chfa5=1};
						break;
						case "ftitulo5":
							if (cont!='' || chfa5){erro=check_date('Fecha Graduacion 5',cont,erro);chfa5=1};
						break;
						case "ntitulo6":
							if (cont!='' || chfa6){erro=check_any('Nombre Titulo 6',cont,erro);chfa6=1};
						break;
						case "ninstitucion6":
							if (cont!='' || chfa6){erro=check_any('Institucion 6',cont,erro);chfa6=1};
						break;
						case "codigo6":
							if (cont!='' || chfa6){erro=check_any('Codigo Registro Senescyt 6',cont,erro);chfa6=1};
						break;
						case "ftitulo6":
							if (cont!='' || chfa6){erro=check_date('Fecha Graduacion 6',cont,erro);chfa6=1};
						break;
						case "tmovil":
							if(cont!=''){erro=check_tlf('Tlf movil',cont,erro);};
						break;
						case "tfijo":
							if (cont!=''){erro=check_tlf('Tlf fijo',cont,erro);};						
					        break;
						case "email":
							chkinv=1;
							erro=check_mail('Correo electronico principal',cont,erro);
						break;
						case "email2":
							chkinv=1;
							if (cont!=''){erro=check_mail("Correo electronico Alternativo, si no tiene deje el campo de texto en blanco\n",cont,erro);};
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
					cont=document.post1.elements[i].value;
					  switch (nam){
/*						case "fa1":
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
						break;*/
					  };
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
			if(typeof post1.idPaisr !== 'undefined'){
				if(document.post1.ciu_co.value!=document.post1.idPaisr.options[document.post1.idPaisr.selectedIndex].value){
					erro=true;
					alert('La ciudad de residencia no corresponde al pais de residencia: '+document.post1.idPaisr.options[document.post1.idPaisr.selectedIndex].value+' << >> '+document.post1.ciu_co.value);
				}
				if(document.post1.tmovil.value=='' && document.post1.tfijo.value==''){
					erro=true;
					alert('Debe proporcionar al menos un telefono de contacto ');
				}
			
				if(!chfa1 && !chfa2 && !chfa3 && !chfa4 && !chfa5 && !chfa6 ){
//					erro=true;
//					alert('Debe proporcionar al menos un Titulo obtenidos');
					if (!confirm('No ha especificado ningún título (Si usted poseía registro previamente y fue carnetizado sin título, deje los campos de informacióna cademica en blanco)\n Está completamente seguro?')){
						return false;
					};
				}
			}else{
				if(!chfa1 && !chfa2 && !chfa3 && !chfa4 && !chfa5 && !chfa6 ){
//					erro=true;
//					alert('Debe proporcionar al menos un nuevo  Titulo obtenido');
					if (!confirm('No ha especificado ningún título (Si usted poseía registro previamente y fue carnetizado sin título, deje los campos de informacióna cademica en blanco)\n está completamente seguro?')){
						return false;
					};
				}
			
			}
		}
		if(!erro){
			if(confirm('Esta seguro que los datos editados son correctos,Por favor compruebe!!')){
				return !erro
			}else{
				return erro
			}
		};
	};
