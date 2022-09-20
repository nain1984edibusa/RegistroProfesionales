 <!--
	function validate()
	{
		var erro=false;
		var elem=document.post1.length-1;
		var cont="";
		var chequed;
		var chkinv;
		var nam;
		var chfa1=0;
		var chfa2=0;
		var chfa3=0;
		var chfa4, chfa5,chfa6,m1;
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
						   if(checkci){erro=check_ci(cont,erro,1);}else{erro=check_any('Documento Identificación',cont,erro);};
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
							erro=check_any('Dirección',cont,erro);
						break;
						case "fnac":
							erro=check_date('Fecha Nacimiento',cont,erro);
						break;
						case "ntitulo":
							if (post1.TipoProfesionalId.value==2){
								if (cont!='' || chfa1 ){erro=check_any('Nombre Título 1',cont,erro);chfa1=1;};
							}else{
								erro=check_any('Nombre Título 1',cont,erro);
								chfa1=1;							
							}
						break;
						case "ninstitucion":
							if (post1.TipoProfesionalId.value==2){
								if (cont!='' || chfa1){erro=check_any('Institución 1',cont,erro);chfa1=1;};
							}else{
								erro=check_any('Institución 1',cont,erro);
							};
						break;
						case "ftitulo":
							if (post1.TipoProfesionalId.value==2){
								if (cont!='' || chfa1){erro=check_date('Fecha Graduación 1',cont,erro);chfa1=1;};
							}else{
								erro=check_date('Fecha Graduación 1',cont,erro);
							};
						break;
						case "codigo":
							if (post1.TipoProfesionalId.value==2){
								if (cont!='' || chfa1){erro=check_any('Código Registro SENESCYT 1',cont,erro);chfa1=1;};
							}else{
								erro=check_any('Código Registro SENESCYT 1',cont,erro);
							};
						break;
						case "ntitulo2":
							if (cont!='' || chfa2 ){erro=check_any('Nombre Título 2',cont,erro);chfa2=1;};
						break;
						case "ninstitucion2":
							if (cont!='' || chfa2 ){erro=check_any('Institución 2',cont,erro);chfa2=1;};
						break;
						case "ftitulo2":
							if (cont!='' || chfa2 ){erro=check_date('Fecha Graduación 2',cont,erro);chfa2=1;};
						break;
						case "codigo2":
							if (cont!='' || chfa2 ){
								erro=check_any('Código Registro SENESCYT 2',cont,erro);chfa2=1;
								erro=check_any('Nombre Título 2',post1.ntitulo2.value,erro);
							};
						break;
						case "ntitulo3":
							if (cont!='' || chfa3 ){erro=check_any('Nombre Título 3',cont,erro);chfa3=1;};
						break;
						case "ninstitucion3":
							if (cont!='' || chfa3 ){erro=check_any('Institución 3',cont,erro);chfa3=1;};
						break;
						case "ftitulo3":
							if (cont!='' || chfa3){erro=check_date('Fecha Graduación 3',cont,erro);chfa3=1;};
						break;
						case "codigo3":
							if (cont!='' || chfa3 ){
								erro=check_any('Código Registro SENESCYT 3',cont,erro);chfa3=1;
								erro=check_any('Nombre Título 3',post1.ntitulo3.value,erro);
							};
						break;
/*						case "ntitulo4":
							if (chfa4==1){erro=check_any('Nombre Título 4',cont,erro);};
						break;
						case "ninstitucion4":
							if (chfa4==1){erro=check_any('Institución 4',cont,erro);};
						break;
						case "Código4":
							if (chfa4==1){erro=check_any('Código Registro SENESCYT 4',cont,erro);};
						break;
						case "ftitulo4":
							if (chfa4==1){erro=check_date('Fecha Graduación 4',cont,erro);};
						break;
						case "ntitulo5":
							if (chfa5==1){erro=check_any('Nombre Título 5',cont,erro);};
						break;
						case "ninstitucion5":
							if (chfa5==1){erro=check_any('Institución 5',cont,erro);};
						break;
						case "Código5":
							if (chfa5==1){erro=check_any('Código Registro SENESCYT 5',cont,erro);};
						break;
						case "ftitulo5":
							if (chfa5==1){erro=check_date('Fecha Graduación 5',cont,erro);};
						break;
						case "ntitulo6":
							if (chfa6==1){erro=check_any('Nombre Título 6',cont,erro);};
						break;
						case "ninstitucion6":
							if (chfa6==1){erro=check_any('Institución 6',cont,erro);};
						break;
						case "Código6":
							if (chfa6==1){erro=check_any('Código Registro SENESCYT 6',cont,erro);};
						break;
						case "ftitulo6":
							if (chfa6==1){erro=check_date('Fecha Graduación 6',cont,erro);};
						break;*/
						case "tmovil":
							if(cont!=''){erro=check_tlf('Teléfono móvil',cont,erro);};
						break;
						case "tfijo":
							if (cont!=''){erro=check_tlf('Teléfono fijo',cont,erro);};						
					        break;
						case "email":
							chkinv=1;
							erro=check_mail('correo electrónico principal',cont,erro);
							m1=cont;
						break;
						case "email2":
							chkinv=1;
							if (cont!=''){
								erro=check_mail('correo electrónico alternativo',cont,erro);
								if(cont==m1){
									alert('El correo electrónico principal y el alternativo deben ser diferentes');
									erro=true;
								};
							};
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
						case "espec":
							if(cont==''){
								erro=true;
								alert('Debe escoger una Especialidad');
							}
						break;
					};
				break;
				case "select-multiple":
					var mess="escoger una opción en ";
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
					  /*switch (nam){
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
					  };*/
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
					alert('La ciudad de residencia no corresponde al país de residencia: '+document.post1.idPaisr.options[document.post1.idPaisr.selectedIndex].value+' << >> '+document.post1.ciu_co.value);
				}
			};
			if(post1.tmovil.value=='' && post1.tfijo.value==''){
				erro=true;
				alert('Debe proporcionar al menos un teléfono de contacto ');
			}
/*			if(!chfa1 && !chfa2 && !chfa3 && !chfa4 && !chfa5 && !chfa6 ){
				erro=true;
				alert('Debe proporcionar al menos un Título obtenido');
			}*/
			if(!chfa1 && !chfa2 && !chfa3){
				//erro=true;
				//post1.ntitulo.focus();   por los sin titulo
				//alert('Debe proporcionar al menos un Título obtenido');   por los sin titulo
				if (!confirm('No ha especificado ningún título está completamente seguro?\nSU SOLICITUD PODRIA SER RECHAZADA')){
					return false;
				};
			}
			if (chfa1){post1.fa1.value=1;}
			if (chfa2){post1.fa2.value=1;}
			if (chfa3){post1.fa3.value=1;}
		}
		if(!erro){
			if(confirm('Ingresó una solicitud al Registro de Profesionales '+post1.spe.value+'\nPara confirmar esta solicitud ponga Aceptar')){
				return !erro
			}else{
				return erro
			}
		};
	};
