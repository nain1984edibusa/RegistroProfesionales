<!--
//--------------------------CONVIERTE UNA HORA AMINUTOS O VICEVERSA
	function hor_min_hor(h_o_m,hora_min)
	{
	        switch (h_o_m)
	        {
	                case 'htm':
	                        var time=hora_min*60;
	                break;
	                case 'mth':
	                        var time=hora_min/60;
	                break;
		};
		return time;
	};
//----------------------------------------
	function refrescar()
	{
		if (!(window.name=='main'))
		{
			window.parent.opener.location.reload()	
		} ;
	};

					//	COMPARA DOS HORASY DEVUELVE SI ES MAYOR[2] MENOR[0] O IGUAL[1] Y LA HORA1 Y SI ES POR SEGUNDO MINUTO U HORA
					//	SINTAXIS ARRAY RESPUESTAS ( [><=] , [horas] , [minutos] , [segundos])

	function compare_time(hora1,hora2)
	{
		var h1=parseInt(hora1.substr(0,2),10);
		var m1=parseInt(hora1.substr(3,2),10);
		var s1=parseInt(hora1.substr(6,2),10);
		var h2=parseInt(hora2.substr(0,2),10);
		var m2=parseInt(hora2.substr(3,2),10);
		var s2=parseInt(hora2.substr(6,2),10);
		if (h1 >h2)
		{
			var result= 2;
		};
		if (h1< h2)
		{
			var result= 0;
		};
		if (h1==h2)
		{
			if (m1>m2)
			{
				var result= 2;
			};
			if (m1 < m2 )
			{
				var result= 0;
			};
			if (m1==m2)
			{
				if (s1 > s2)
				{
					var result= 2;
				};
				if (s1 < s2)
				{
					var result= 0;
				};
				if (s1==s2)
				{
					var result= 1;
				};
			};
		};
		return result;
	};

	function dif_time(hora1,hora2)
	{
		var h1=parseInt(hora1.substr(0,2),10);
		var m1=parseInt(hora1.substr(3,2),10);
		var s1=parseInt(hora1.substr(6,2),10);
		var h2=parseInt(hora2.substr(0,2),10);
		var m2=parseInt(hora2.substr(3,2),10);
		var s2=parseInt(hora2.substr(6,2),10);
		var min;
		var hora;
		var seg;
		if (h1>=h2)
		{
			if (s1<=s2)
			{
				var seg=s2-s1;
			}else
			{
				s2+=60;
				seg=s2-s1;
				m2--;
			};
			if (m1 >= m2 )
			{
				 min=m1-m2;
			}else
			{
				m1+=60;
				min=m1-m2;
				h1--;
			};
			var hora=h1-h2
		};
		var result= new Array(hora,min,seg)
		return result

	};

	function compare_date(f1,f2)
	{
		var a1=parseInt(f1.substr(0,4),10);
		var m1=parseInt(f1.substr(5,2),10);
		var d1=parseInt(f1.substr(8,2),10);
		var a2=parseInt(f2.substr(0,4),10);
		var m2=parseInt(f2.substr(5,2),10);
		var d2=parseInt(f2.substr(8,2),10);
		if (a1 > a2)
		{
			var result=2
		};
		if (a1 < a2)
		{
			var result=0
		};
		if (a1 == a2)
		{
			if (m1 > m2)
			{
				var result=2
			};
			if (m1 < m2)
			{
				var result=0
			};
			if (m1 == m2)
			{
				if (d1 > d2)
				{
					var result=2
				};
				if (d1 < d2)
				{
					var result=0
				};
				if (d1 == d2)
				{
					var result=1
				};
			};
		};
		return result
	};

	function dif_date(f1,f2)
	{
		var ai=parseInt(f1.substr(0,4),10);
		var mi=parseInt(f1.substr(5,2),10);
		var di=parseInt(f1.substr(8,2),10);
		var af=parseInt(f2.substr(0,4),10);
		var mf=parseInt(f2.substr(5,2),10);
		var df=parseInt(f2.substr(8,2),10);
		var dias
		var mes
		var anio
		if (af >= ai)
		{
			if (di <= df)
			{
				dias=df-di;
			}else
			{
				df+=30;
				dias=df-di;
				mf--;
			};
			if (mi <= mf)
			{
				mes=mf-mi;
			}else
			{
				mf+=12;
				mes=mf-mi;
				af--;
			};
			anio=af-ai;
		};
		var result= new Array(anio,mes,dias)
		return result
	};

	function invalid_chars(cont){
		var flag=false;
		for (var cu=0; cu<=cont.length-1; cu++)
		{
		  if (cont.charAt(cu)=='"' || cont.charAt(cu)=="'" || cont.charAt(cu)=="\\" || cont.charAt(cu)=='*'  || cont.charCodeAt(cu)==243 || cont.charCodeAt(cu)==211 || cont.charCodeAt(cu)==225 || cont.charCodeAt(cu)==193 || cont.charCodeAt(cu)==201 || cont.charCodeAt(cu)==233 || cont.charCodeAt(cu)==205 || cont.charCodeAt(cu)==250 || cont.charCodeAt(cu)==237 || cont.charCodeAt(cu)==218 || cont.charCodeAt(cu)==209 || cont.charCodeAt(cu)==241)
		  {		   
//			alert(cont.charCodeAt(cu+1));
			flag=true;
			alert('Para evitar visulaizacion incorrecta de caracteres\nlatinos evite ingresar vocales y enies \n\n Caracteres no permitidos -> '+cont.charAt(cu)+' <- cambielo para poder continuar');
			return flag;
		  }
		};
	};

	function check_date(message,cont,lerr)
	{
		var flag=false;
		if ( cont.length < 10 ) { flag=true; };
		for (var cu=0; cu<=cont.length-1; cu++)
		{
			if (cont.charAt(cu)!='/')
			{var nu=parseInt(cont.charAt(cu),10);
				if ( isNaN(nu))
				{
					flag=true;
				};
			}
		};
		var fec=new Array(5);
		fec[0]=cont.substr(0,4);//año
		var bis=fec[0]%4;
		fec[1]=cont.substr(5,2);//mes
		fec[2]=cont.substr(8,2);//dia
		fec[3]=cont.substr(4,1);
		fec[4]=cont.substr(7,1);
		switch(fec[1]){
			case '02':
				if ( bis==0 ) { var md=29; } else { var md = 28 ; };
			break;
			case '04':
				var md=30;
			break;
			case '06':
				var md=30;
			break;
			case '09':
				var md=30;
			break;
			case '11':
				var md=30;
			break;
			default:
				var md=31;
			break;
		};
		for ( var j=0; j<=4; j++ )
		{
			if ( j<3 )
			{
				var nu=parseInt(fec[j]);
				if ( isNaN(nu) || nu < 0)
				{
					flag=true;
				};
				if ( j==0 )
				{
					var yr;
					Today = new Date();
					yr = Today.getFullYear();
					ms= Today.getMonth()+1;
					if(ms < 10)
					{
						ms='0'+ms;
					};
					di= Today.getDate();
					if(di < 10)
					{
						di='0'+di;
					};
					var edad=yr-parseInt(fec[j],10);
					if (message=="nacimiento")
					{
						if (edad < 18 || edad < 0 || edad > 90) { flag = true;};
					}else
					{
						if (parseInt(fec[j],10) > yr   || (parseInt(fec[j],10) ==0))
						{
							flag = true;
						}else
						{
							if (parseInt(fec[j],10) == yr  )
							{
								if (parseInt(fec[1],10) > ms  )
								{
									flag=true;
								}else
								{
									if (parseInt(fec[1],10) == ms  )
									{
										if (parseInt(fec[2],10) > di  )
										{
											flag=true;
										};
									};
								};
							};
						};
					};
				};
				if (j==1)
				{
					if ( parseInt(fec[j],10) >12 || (parseInt(fec[j],10) ==0) ){ flag=true;  };
				}else
				{
					if (j==2)
					{
				 		if ( (parseInt(fec[j],10) > md) || (parseInt(fec[j],10) ==0) ){ flag=true; };
				 	};
				};
			}else
			{
				if ( fec[j]!="/" )
				{
					flag = true;
				};
			};
		};
			if ( flag )
			{
				var hoy_=yr+'/'+ms+'/'+di;
				alert ('\t Verifique fecha de ' + message+'\n FORMATO: AÑO-MES-DÍA (aaaa/mm/dd)\n\nLA fecha de su computador es '+hoy_);
				lerr=true;
			};
		return lerr;
	};

	function check_date_hijo(message,cont,lerr)
	{
		var flag=false;
		if ( cont.length < 10 ) { flag=true; };
		for (var cu=0; cu<=cont.length-1; cu++)
		{
			if (cont.charAt(cu)!='/')
			{var nu=parseInt(cont.charAt(cu),10);
				if ( isNaN(nu))
				{
					flag=true;
				};
			}
		};
		var fec=new Array(5);
		fec[0]=cont.substr(0,4);//año
		var bis=fec[0]%4;
		fec[1]=cont.substr(5,2);//mes
		fec[2]=cont.substr(8,2);//dia
		fec[3]=cont.substr(4,1);
		fec[4]=cont.substr(7,1);
		switch(fec[1]){
			case '02':
				if ( bis==0 ) { var md=29; } else { var md = 28 ; };
			break;
			case '04':
				var md=30;
			break;
			case '06':
				var md=30;
			break;
			case '09':
				var md=30;
			break;
			case '11':
				var md=30;
			break;
			default:
				var md=31;
			break;
		};
		for ( var j=0; j<=4; j++ )
		{
			if ( j<3 )
			{
				var nu=parseInt(fec[j]);
				if ( isNaN(nu) || nu < 0)
				{
					flag=true;
				};
				if ( j==0 )
				{
					var yr;
					Today = new Date();
					yr = Today.getFullYear();
					ms= Today.getMonth()+1;
					if(ms < 10)
					{
						ms='0'+ms;
					};
					di= Today.getDate();
					if(di < 10)
					{
						di='0'+di;
					};
					var edad=yr-parseInt(fec[j],10);
					/*if (message=="nacimiento")
					{
						// if (edad < 18 || edad < 0 || edad > 90) { flag = true;};
					}else
					{*/
						if (parseInt(fec[j],10) > yr   || (parseInt(fec[j],10) ==0))
						{
							flag = true;
						}else






						{
							if (parseInt(fec[j],10) == yr  )
							{
								if (parseInt(fec[1],10) > ms  )
								{
									flag=true;
								}else
								{
									if (parseInt(fec[1],10) == ms  )
									{
										if (parseInt(fec[2],10) > di  )
										{
											flag=true;
										};
									};
								};
							};
						};
					//};
				};
				if (j==1)
				{
					if ( parseInt(fec[j],10) >12 || (parseInt(fec[j],10) ==0) ){ flag=true;  };
				}else
				{
					if (j==2)
					{
				 		if ( (parseInt(fec[j],10) > md) || (parseInt(fec[j],10) ==0) ){ flag=true; };
				 	};
				};
			}else
			{
				if ( fec[j]!="/" )
				{
					flag = true;
				};
			};
		};
			if ( flag )
			{
				var hoy_=yr+'/'+ms+'/'+di;
				alert ('\t Verifique fecha de ' + message+'\n FORMATO: AÑO-MES-DÍA (aaaa/mm/dd)\n\nLA fecha de su computador es '+hoy_);
				lerr=true;
			};
		return lerr;
	};

	function check_date_2(message,cont,lerr)
	{
		var flag=false;
		var yr;
		Today = new Date();
		yr = Today.getFullYear();
		ms= Today.getMonth()+1;
		if(ms < 10)
		{
			ms='0'+ms;
		};
		di= Today.getDate();
		if(di < 10)
		{
			di='0'+di;
		};
		if ( cont.length < 10 ) { flag=true; };
		for (var cu=0; cu<=cont.length-1; cu++)
		{
			if (cont.charAt(cu)!='/')
			{var nu=parseInt(cont.charAt(cu),10);
				if ( isNaN(nu))
				{
					flag=true;
				};
			}
		};
		var fec=new Array(5);
		fec[0]=cont.substr(0,4);
		var bis=fec[0]%4;
		fec[1]=cont.substr(5,2);
		fec[2]=cont.substr(8,2);
		fec[3]=cont.substr(4,1);
		fec[4]=cont.substr(7,1);
		switch(fec[1]){
			case '02':
				if ( bis==0 ) 
				{ 
					var md = 29; 
				}
				else
				{
					var md = 28 ;
				};
			break;
			case '04':
				var md=30;
			break;
			case '06':
				var md=30;
			break;
			case '09':
				var md=30;
			break;
			case '11':
				var md=30;
			break;
			default:
				var md=31;
			break;
		};
		var anio=parseInt(fec[0],10);
		var mes=parseInt(fec[1],10);
		var dia=parseInt(fec[2],10);
		if ( isNaN(anio) || isNaN(mes) || isNaN(dia)||  fec[3]!='/'|| fec[4]!='/'||(mes > 12)||(dia > md))
		{
			flag=true;
		};
		if ( flag )
		{
			var hoy_=yr+'/'+ms+'/'+di;
			alert ('\t Verifique fecha ' + message+'\n FORMATO: AÑO-MES-DÍA (aaaa/mm/dd)\n\nLA fecha de su computador es '+hoy_);
			lerr=true;
		};
		return lerr;
	};

	function check_formule(message,cont,lerr)
	{
		var flag=false;
		var falta="";
		var par=0;
		var mal=0;
		for ( var j=0; j<=cont.length-1; j++ )
		{
			if ( cont.charAt(j) == "(" )
			{
				par++;
			}else{
				if ( cont.charAt(j) == ")" )
				{
					par--;
				}else{
					if ( (cont.charCodeAt(j) >= 65 && cont.charCodeAt(j) <= 90) || (cont.charCodeAt(j) >= 97 && cont.charCodeAt(j) <= 122) || (cont.charCodeAt(j) >= 48 && cont.charCodeAt(j) <= 57) || cont.charCodeAt(j) == 43 || cont.charCodeAt(j) == 42 || cont.charCodeAt(j) == 45 || cont.charCodeAt(j) == 47 )
					{
						mal=1;
					}else{
						mal=100;
						break;
					};
				};
			};
		};
		if ( mal > 1 )
		{
			flag=true;
			falta+= "Caracter prohibido: \t"+cont.charAt(j);
		};
		if (document.forms[0].valor != '')
		{
			if ((j>0 && document.forms[0].valor.value.length > 0 ) /*&& document.URL.indexOf("edit_param")==-1*/)
			{
				flag=true;
				falta+="\n si ya ingreso un valor, no puede ingresar una formula, no pueden ir ambos";
			};
			if ((j<=0 && document.forms[0].valor.value.length <= 0) /*&& document.URL.indexOf("edit_param")==-1*/)
			{
				flag=true;
				falta+="\n Debe ingresar un valor o una formula";
			};
		};
/*		if ((j==0 && document.forms[0].valor.value.length == 0 ))
		{
			flag=true;
			falta+="\n Debe ingresar una fórmula o un valor";
		};*/
		/*if (j<=0 && document.URL.indexOf("edit_param")!=-1)
		{
			flag=true;
			falta+="\n Debe ingresar una formula";
		};*/

		if ( par != 0 )
		{
			flag=true;
			falta+= "\nFalta abrir o cerrar algun parentesis";
		};
		if ( flag )
		{
			alert ('Verifique ' + message+'\n'+falta);
			lerr=true;
		};
		return lerr;
	};

	function check_login_name(message,cont,lerr)
	{
		var flag=false;
		var falta="";
		var par=0;
		var mal=0;
		for ( var j=0; j<=cont.length-1; j++ )
		{
			if ( (cont.charCodeAt(j) >= 65 && cont.charCodeAt(j) <= 90) || (cont.charCodeAt(j) >= 97 && cont.charCodeAt(j) <= 122) || (cont.charCodeAt(j) >= 48 && cont.charCodeAt(j) <= 57) || cont.charCodeAt(j) == 95 )
			{
				mal=1;
			}else{
				mal=100;
				break;
			};
		};
		if ( mal > 1 )
		{
			flag=true;
			falta+= "Caracter prohibido: \t"+cont.charAt(j)+" sólo se admiten letras, números y el caracter de subrayado (_)";
		};
		if ( flag )
		{
			alert ('Verifique ' + message+'\n'+falta);
			lerr=true;
		};
		return lerr;
	};

	function check_time(message,cont,lerr)
	{
		var flag=false;
		var adic_mes='';
		if ( cont.length < 8 ) { flag=true; };
		for (var cu=0; cu<=cont.length-1; cu++)
		{
			if (cont.charAt(cu)!=':')
			{var nu=parseInt(cont.charAt(cu),10);
				if ( isNaN(nu))
				{
					flag=true;
				};
			}
		};
		var fec=new Array(5);
		fec[0]=cont.substr(0,2);
		fec[1]=cont.substr(3,2);
		fec[2]=cont.substr(6,2);
		fec[3]=cont.substr(2,1);
		fec[4]=cont.substr(5,1);
		for ( var j=0; j<=4; j++ )
		{
			if ( j<3 )
			{
				var nu=parseFloat(fec[j]);
				if ( isNaN(nu) || nu < 0)
				{
					flag=true;
				};
				if ( j==0 )
				{
					if ( parseInt(fec[j],10) > 24) { flag=true;};
				};
				if (j==1)
				{
					if ( parseInt(fec[j],10) > 59 ){ flag=true;};
				}else
				{
					if (j==2)
					{
				 		if ( parseInt(fec[j],10) != 0 )
						{ 
							flag=true; 
							adic_mes=' \n No se puede actuar sobre los segundos, debe ser 00\n';
						};
				 	};
				};
			}else
			{
				if ( fec[j]!=":" )
				{
					flag = true;
				};
			};
		};
		if ( flag )
		{
			alert ('\t Verifique la ' + message+'\n FORMATO: HORA-MIN-SEC (hh:mm:00)'+adic_mes);
			lerr=true;
		};
		return lerr;
	};


//	function check_mail(message,cont,lerr)
//	{
//			if (( cont.indexOf('@')==-1)||(cont.indexOf(' ')!=-1))
//			{
//				alert ('Verifique el '+message+', no puede contener espacios,\nni caracteres especiales a excepción de "_"  y "." ');
//				lerr=true;
//			};
//		return lerr;
//	};

function check_mail( message,cont,lerr ) {
	expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	if ( !expr.test(cont) ){
		alert("Verifique el "+message+".  La dirección de correo " + cont + " es incorrecta.");
		lerr=true;
	}
	return lerr;
}

	function check_usrname(message,cont,lerr){
		var alpha = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789._";
		if (cont.length < 8){
				alert ('Verifique el '+message+', debe tener almenos 8 caracteres');
				lerr=true;
				return lerr;		
		}
		for (var cu=0; cu<=cont.length-1; cu++){
			if (alpha.indexOf(cont.charAt(cu))==-1){
				alert ('Verifique el '+message+', no puede contener espacios,\nni caracteres especiales a excepción de \n'+alpha);
				lerr=true;
				return lerr;
			};
		};
	};

	function check_pwd(cont,cont_rep,lerr)
	{
		if ( cont.length == 0 || cont.length < 6 || cont=='') 
		{
			alert ('La longitud de la clave de usuario debe ser por lo menos de 6 caracteres, no puede ser vacio');
			lerr=true;
		};
		if (cont_rep!='old_pwd')
		{
			if (!lerr)
			{
				if ( cont.indexOf(' ')!=-1 || cont_rep.indexOf(' ')!=-1) 
				{
					alert ('No se permiten espacios en la clave de usuario y/o confirmación de clave');
					lerr=true;
				};
			};
			if (!lerr)
			{
				if ( cont != cont_rep) 
				{
					alert ('La confirmación no coincide');
					lerr=true;
				};
			};
		};
		return lerr;
	};

	function check_symb(message,cont,lerr)
	{
		if ( cont.length < 1 )
		{
			lerr=true;
		}else
		{
			for ( var j=0; j<=cont.length-1; j++ )
			{
				if (!((cont.charCodeAt(j) >= 65 && cont.charCodeAt(j) <= 90) || (cont.charCodeAt(j) >= 97 && cont.charCodeAt(j) <= 122)))
				{
					lerr=true;
				};
			};
		};
		if (lerr)
		{
			alert ('Verifique el '+message+', el nombre solo puede tener letras');
		};
		return lerr;
	};


	function check_any(message,cont,lerr)
	{
		if ( cont.length<2)
		{
			alert ('Debe especificar  '+message);
			lerr=true;
		};
		return lerr;
	};

	function check_tlf(message,cont,lerr){
		if(cont.length==0 || cont.length < 7 || cont.length > 13){
			lerr=true
		}
		for (var j=0; j<=cont.length-1; j++){
			var nu=parseInt(cont.charAt(j),10);
			if ( isNaN(nu)){
				lerr=true;
			};
		};
		if(lerr){
			alert ('Verifique el numero de '+message);
		}
		return lerr;
	};

	function check_number(message,cont,lerr){
		if(cont.length==0){
			lerr=true
		}
		for (var j=0; j<=cont.length-1; j++){
			var nu=parseInt(cont.charAt(j),10);
			if ( isNaN(nu)){
				lerr=true;
			};
		};
		if(lerr){
			alert ('Verifique el número de '+message);
		}
		return lerr;
	};

	function check_number_2(message,cont,lerr)
	{
		if (cont=="")
		{
			lerr=true;
		};
		for (var j=0; j<=cont.length-1; j++)
		{
			if ( cont.charAt(j)!='.' )
			{
				var nu=parseFloat(cont.charAt(j));
				if ( isNaN(nu) || nu < 0)
				{
					lerr=true;
				};
			};
		};
		if (lerr)
		{
			alert ('Verifique el número de '+message);
		};
		return lerr;
	};

	function check_vacation_days(message,cont,lerr)
	{
		if (cont=="")
		{
			lerr=true;
		};
		for (var cu=0; cu<=cont.length-1; cu++)
		{
			if (cont.charAt(cu)!='/' && cont.charAt(cu)!='-')
			{var nu=parseInt(cont.charAt(cu),10);
				if ( isNaN(nu))
				{
					flag=true;
				};
			}
		};
		parts=cont.split('/');
		nu=parseFloat(parts[0]);
		if ( isNaN(nu) )
		{
			lerr=true;
		};
		var hay_slash=false
		for (var j=0; j<=cont.length-1; j++)
		{
			if ( cont.charAt(j)=='/' )
			{
				hay_slash=true
			}
		}
		if ( !hay_slash)
		{
			lerr=true;
		};

		if (lerr)
		{
			alert ('Verifique el número de '+message);
		};
		return lerr;
	};

	function check_value(message,cont,lerr)
	{
		var flag=false;
		for (var cu=0; cu<=cont.length-1; cu++)
		{
			if (cont.charAt(cu)!='.')
			{var nu=parseInt(cont.charAt(cu),10);
				if ( isNaN(nu))
				{
					flag=true;
				};
			}
		};
		if (cont.length > 0 /*&& document.URL.indexOf("edit_param")==-1*/)
		{
			var nu=parseFloat(cont);
			if ( isNaN(nu) || document.forms[0].formula.value.length > 0)
			{
				flag=true;
			};

		};
		if (cont.length > 0 /*&& document.URL.indexOf("edit_param")!=-1*/)
		{
			var nu=parseFloat(cont);
			if (document.forms[0].formula.value != '')
			{
				if ( isNaN(nu) || document.forms[0].formula.value.length > 0)
				{
					flag=true;
				};
			};

		};
		/*if (cont.length <= 0 && document.URL.indexOf("edit_param")!=-1)
		{
			flag=true;
		};*/

/*		if ((cu==0 && document.forms[0].formula.value.length == 0 ))


		{
			flag=true;
			falta+="\n Debe ingresar una fórmula o un valor";
		};*/
		if (flag)
		{
			alert ('Verifique '+message+'\t, '+cont+' \n El valor puede ser el correcto pero \nsi ha ingresado una formula tal vez deba eliminarla, no pueden ir ambos');
			lerr=true;
		};
		return lerr;
	};

	function check_ci(cont,lerr,isci)
	{
		var imp=0;
		var ver="";
		var flag=false;
		var dig=0;
		var sum=0;
		var last_dig;
		if (cont.length<1){flag=true;};
		if (cont.length<10 && isci){flag=true;};
		if(isci ){last_dig=parseInt(cont.charAt(9),10);};
		for (var j=0; j<=cont.length-1; j++)
		{
			dig= parseInt(cont.charAt(j),10);
			if (!isNaN(dig))
			{
				if (j < cont.length-1)
				{
					if (j%2==0 )
					{
						imp=dig*2;
						if (imp>=10)
						{
							imp-=9;
						};
						sum+=imp;
					}else
					{
						sum+=dig;
					};
				};
			}else
			{
				flag=true;
			};
		}; // end for
		var res=sum%10;
		if (res!=0)
		{
			res=10-res;
		};
		if (res!=last_dig && isci)
		{
			flag=true;
			ver+="\nAlgún dígito es incorrecto";
		};
		if (flag)
		{
			alert ('Verifique el número de cédula'+ver);
			lerr=true;
		};
		return lerr;
	};


	function is_ci(cont)
	{
		var imp=0;
		var lerr=0;
		var ver="";
		var flag=false;
		var dig=0;
		var sum=0;
		for (var j=0; j<=cont.length-1; j++)
		{
			dig= parseInt(cont.charAt(j),10);
			if (!isNaN(dig))
			{
				if (j < cont.length-1)
				{
					if (j%2==0 )
					{
						imp=dig*2;
						if (imp>=10)
						{
							imp-=9;
						};
						sum+=imp;
					}else
					{
						sum+=dig;
					};
				};
			}else
			{
				flag=true;
			};
		}; // end for
		var res=sum%10;
		if (res!=0)
		{
			res=10-res;
		};
		if (res!=dig )
		{
			flag=true;
		};
		if (!flag)
		{
			lerr=true;
		};
		return lerr;
	};

	function calc_days(f_ini,n_dias,maximo)
	{
		var tot_dias=0;
		var f_desde=new Array(5);
		f_desde[0]=f_ini.substr(0,4);//año
		var bis=f_desde[0]%4;
		f_desde[1]=f_ini.substr(5,2);//mes
		f_desde[2]=f_ini.substr(8,2);//dia
		f_desde[3]=f_ini.substr(4,1);//separador
		f_desde[4]=f_ini.substr(7,1);//separador
		switch(f_desde[1]){
			case "02":
				if ( bis==0 ) { var max_di=29; } else { var max_di = 28 ; };
			break;
			case "04":
				var max_di=30;
			break;
			case "06":
				var max_di=30;
			break;
			case "09":
				var max_di=30;
			break;
			case "11":
				var max_di=30;
			break;
			default:
				var max_di=31;
			break;
		};
		var anio=parseInt(f_desde[0],10);
		var mes=parseInt(f_desde[1],10);
		var dia=parseInt(f_desde[2],10);
		n_dias=parseInt(n_dias,10);
		if ( n_dias > maximo)
		{
			alert('El número de días no puede ser mayor a '+maximo)
			return false;
			exit;
		};
		if ( isNaN(anio) || isNaN(mes) || isNaN(dia)||  f_desde[3]!='/'|| f_desde[4]!='/'||(mes>12)||(dia>max_di))
		{
			alert('Verifique el formato de fecha de inicio(aaaa/mm/dd)')
			return false;
			exit;
		};
		tot_dias=dia+n_dias;
		while ( tot_dias > max_di )
		{
			tot_dias=tot_dias-max_di;
			mes=mes+1;
			if ( mes > 12 )
			{
				mes=mes-12;
				anio=anio+1;
			}else
			{
				if ( (anio%4)!=0 )
				{
					if ( mes == 2 )
					{
						if (tot_dias > 28 )
						{
							tot_dias=tot_dias-28;
							mes=mes+1;
						};
					}
				}else
				{
					if ( mes==2 )
					{
						if( tot_dias > 29 )
						{
							tot_dias=tot_dias-29;
							mes=mes+1;
						};
					}
				}
			};
			bis=anio%4;
			switch(mes)
			{
				case 2:
					if ( bis==0 ) { max_di=29; } else { max_di = 28 ; };
				break;
				case 4:
					max_di=30;
				break;
				case 6:
					max_di=30;
				break;
				case 9:
					max_di=30;
				break;
				case 11:
					max_di=30;
				break;
				default:
					max_di=31;
				break;
			};
		};
		mes=String(mes);
		tot_dias=String(tot_dias);
		if (mes.length==1)
		{
			mes='0'+mes
		};
		if (tot_dias.length==1)
		{
			tot_dias='0'+tot_dias
		};
		f_hasta=anio+'/'+mes+'/'+tot_dias;
		return f_hasta;

	};
	
	function calc_hours(h_ini,n_hours)
	{
		var tot_hours=0;
		var h_desde=new Array(3);
		h_desde[0]=h_ini.substr(0,2);//hora
		h_desde[1]=h_ini.substr(3,2);//min
		h_desde[2]=h_ini.substr(6,2);//seg
		h_desde[3]=h_ini.substr(2,1);//:
		h_desde[4]=h_ini.substr(5,1);//:
		var hora=parseInt(h_desde[0],10);
		var minu=parseInt(h_desde[1],10);
		var seg=parseInt(h_desde[2],10);
		n_hours=parseInt(n_hours,10);
		if ( isNaN(hora) || isNaN(minu) || isNaN(seg)||  h_desde[3]!=':'|| h_desde[4]!=':'||(minu>59)||(seg>59))
		{
			alert('Verifique la hora(hh:mm:ss)'+hora+' '+minu+' '+seg+' '+h_desde[3]+' '+h_desde[4]+' ')
			return false;
			exit;
		};
		tot_hours=hora+n_hours;
		seg=String(seg)
		minu=String(minu);
		tot_hours=String(tot_hours);
		if (tot_hours.length==1)
		{
			tot_hours='0'+tot_hours
		};
		if (minu.length==1)
		{
			minu='0'+minu
		};
		if (seg.length==1)
		{
			seg='0'+seg
		};
		h_hasta=tot_hours+':'+minu+':'+seg;
		return h_hasta;
	};
	
	function dia_y_mes(fecha_ac)
	{
		var DOM = (document.getElementById) ? 1 : 0;
		var browser = navigator.appName.substring(0,9);
		
		var DIAC=fecha_ac.substr(8,2)
		var DIA=parseInt(DIAC,10)
		var MESC=fecha_ac.substr(5,2);
		var MES=parseInt(MESC,10);
		var ANIOC=fecha_ac.substr(0,4);
		var ANIO=parseInt(ANIOC,10);

			MES--

		var fecha=new Date(ANIO,MES,DIA)
		var year=fecha.getFullYear()
		var ndia=fecha.getDay()
		var nmes=fecha.getMonth()
		var dia=''
		var mes=''
		switch(ndia){
			case 0:
				dia='DOMINGO';
			break;
			case 1:
				dia='LUNES';
			break;
			case 2:
				dia='MARTES';
			break;
			case 3:
				dia='MIERCOLES';
			break;
			case 4:
				dia='JUEVES';
			break;
			case 5:
				dia='VIERNES';
			break;
			case 6:
				dia='SABADO';
			break;
		};
		switch(nmes){
			case 0:
				mes='ENERO';
			break;
			case 1:
				mes='FEBRERO';
			break;
			case 2:
				mes='MARZO';
			break;
			case 3:
				mes='ABRIL';
			break;
			case 4:
				mes='MAYO';
			break;
			case 5:
				mes='JUNIO';
			break;
			case 6:
				mes='JULIO';
			break;
			case 7:
				mes='AGOSTO';
			break;
			case 8:
				mes='SEPTIEMBRE';
			break;
			case 9:
				mes='OCTUBRE';
			break;
			case 10:
				mes='NOVIEMBRE';
			break;
			case 11:
				mes='DICIEMBRE';
			break;
		};
		var fecha_f=dia+' '+fecha_ac.substr(8,2)+' de '+mes+' de '+year
		return fecha_f
	};

	function dia_d_fecha(fecha_ac)
	{
		var DOM = (document.getElementById) ? 1 : 0;
		var browser = navigator.appName.substring(0,9);
		
		var DIAC=fecha_ac.substr(8,2)
		var DIA=parseInt(DIAC,10)
		var MESC=fecha_ac.substr(5,2);
		var MES=parseInt(MESC,10);
		var ANIOC=fecha_ac.substr(0,4);
		var ANIO=parseInt(ANIOC,10);
		MES--

		var fecha=new Date(ANIO,MES,DIA)
		var year=fecha.getFullYear()
		var ndia=fecha.getDay()
		var nmes=fecha.getMonth()

		return ndia;
	};


	function human_day(day)
	{
		var dia=''
		switch(day){
			case 0:
				dia='DOMINGO';
			break;
			case 1:
				dia='LUNES';
			break;
			case 2:
				dia='MARTES';
			break;
			case 3:
				dia='MIERCOLES';
			break;
			case 4:
				dia='JUEVES';
			break;
			case 5:
				dia='VIERNES';
			break;
			case 6:
				dia='SABADO';
			break;
		};
		return dia;
	};

						//CALCULA FECHAS FUTURAS DE ACUERDO A UNA FECHA INCIAL Y LA CANTIDAD DE HORAS, DIAS, MESES O AÑOS QUE SE QUIERA INGRESAR
	function calc_fec_hora(fec_in,hor_in,canti,tiempo)
	{
		var cant=parseInt(canti,10);
		if (tiempo=='años')
		{
		        tiempo='anios';
		};
		switch(tiempo){
			case "minutos":
				var c_min=0;
				var min_c
				var cont_horas=0;
				var fecha=fec_in;
				var min_=parseInt(hor_in.substr(3,2),10);
				c_min=cant+min_;
				while (c_min > 59 )
				{
					c_min-=60;
					cont_horas++;
				};
				if (c_min < 10)
				{
					min_c='0'+String(c_min);
				}else
				{
					min_c=String(c_min);
				};
				min_c=hor_in.substr(0,2)+':'+min_c+':'+hor_in.substr(6,2);
				if((min_ + cant) > 59)
				{
					var f_h_in=calc_fec_hora(fecha,min_c,cont_horas,'horas');
					fecha= f_h_in[0];
					hora= f_h_in[1];
				}else
				{
					hora= min_c;
				};
			break;
			case "horas":
				var c_hora=0;
				var hora_c
				var cont_dias=0;
				var fecha=fec_in;
				var hora_=parseInt(hor_in.substr(0,2),10);
				c_hora=cant+hora_;
				while (c_hora > 23 )
				{
					c_hora-=24;
					cont_dias++;
				};
				if (c_hora < 10)
				{
					hora_c='0'+String(c_hora);
				}else
				{
					hora_c=String(c_hora);
				};
				hora_c=hora_c+hor_in.substr(2,6);
				if((hora_ + cant) > 23)
				{
					var f_h_in=calc_fec_hora(fecha,hora_c,cont_dias,'dias');
					fecha= f_h_in[0];
					hora= f_h_in[1];
				}else
				{
					hora= hora_c;
				};
				
			break;
			case "dias":
				var dia=0;
				var hora=hor_in;
				var max_di;
				var DIAC=fec_in.substr(8,2)
				var DIA=parseInt(DIAC,10)
				var MESC=fec_in.substr(5,2);
				var MES=parseInt(MESC,10);
				var ANIOC=fec_in.substr(0,4);
				var ANIO=parseInt(ANIOC,10);
				var bis=ANIO % 4;
				switch(MES){
					case 2:
						if ( bis==0 ) { max_di=29; } else { max_di = 28 ; };
					break;
					case 4:
						max_di=30;
					break;
					case 6:
						max_di=30;
					break;
					case 9:
						max_di=30;
					break;
					case 11:
						max_di=30;
					break;
					default:
						max_di=31;
					break;
				};
				dia=cant+DIA;
				while ( dia > max_di )
				{
					dia=dia-max_di;
					MES=MES+1;
					if ( MES > 12 )
					{
						MES=MES-12;
						ANIO=ANIO+1;
					}else
					{
						if ( (ANIO % 4) != 0 )
						{
							if ( MES == 2 )
							{
								if (dia > 28 )
								{
									dia=dia-28;
									MES=MES+1;
								};
							}
						}else
						{
							if ( MES==2 )
							{
								if( dia > 29 )
								{
									dia=dia-29;
									MES=MES+1;
								};
							}
						}
					};
					bis=ANIO % 4;
					switch(MES){
						case 2:
							if ( bis==0 ) { max_di=29; } else { max_di = 28 ; };
						break;
						case 4:
							max_di=30;
						break;
						case 6:
							max_di=30;
						break;
						case 9:
							max_di=30;
						break;
						case 11:
							max_di=30;
						break;
						default:
							max_di=31;
						break;
					};
				};
				if(MES < 10)
				{
					MESC='0'+String(MES);
				}else
				{
					MESC=String(MES);
				};
				if(dia < 10 )
				{
					DIAC='0'+String(dia)
				}else
				{
					DIAC=String(dia);
				};
				var fecha=String(ANIO)+'/'+MESC+'/'+DIAC;
			break;
			case "meses":
				var dia=0;
				var NDIAS=0;
				var hora=hor_in;
				var DIAC=fec_in.substr(8,2)
				var DIA=parseInt(DIAC,10)
				var MESC=fec_in.substr(5,2);
				var MES=parseInt(MESC,10);
				var ANIOC=fec_in.substr(0,4);
				var ANIO=parseInt(ANIOC,10);
				var ANIO2=ANIO; 
				var MES2=MES;
				for (var cont_mes=0; cont_mes < cant; cont_mes++)
				{
					bis=ANIO2%4;
					switch(MES2){
						case 2:
							if ( bis==0 ) { max_di=29; } else { max_di = 28; };
						break;
						case 4:
							max_di=30;
						break;
						case 6:
							max_di=30;
						break;
						case 9:
							max_di=30;
						break;
						case 11:
							max_di=30;
						break;
						default:
							max_di=31;
						break;
					};
					if (MES2 == 12)
					{
						ANIO2++;
						MES2=1;
					}else
					{
						MES2++;
					};
					NDIAS+=max_di;
				};
				bis=ANIO%4;
				switch(MES){
					case 2:
						if ( bis==0 ) { max_di=29; } else { max_di = 28; };
					break;
					case 4:
						max_di=30;
					break;
					case 6:
						max_di=30;
					break;
					case 9:
						max_di=30;
					break;
					case 11:
						max_di=30;
					break;
					default:
						max_di=31;
					break;
				};
				dia=NDIAS+DIA;
				while ( dia > max_di )
				{
					dia=dia-max_di;
					MES=MES+1;
					if ( MES > 12 )
					{
						MES=MES-12;
						ANIO=ANIO+1;
					}else
					{
						if ( (ANIO%4)!=0 )
						{
							if ( MES == 2 )
							{
								if (dia > 28 )
								{
									dia=dia-28;
									MES=MES+1;
								};
							}
						}else
						{
							if ( MES==2 )
							{
								if( dia > 29 )
								{
									dia=dia-29;
									MES=MES+1;
								};
							}
						}
					};
					bis=ANIO%4;
					switch(MES){
						case 2:
							if ( bis==0 ) { max_di=29; } else { max_di = 28 ; };
						break;
						case 4:
							max_di=30;
						break;
						case 6:
							max_di=30;
						break;
						case 9:
							max_di=30;
						break;
						case 11:
							max_di=30;
						break;
						default:
							max_di=31;
						break;
					};					
				};
				if(MES < 10)
				{
					MESC='0'+String(MES);
				}else
				{
					MESC=String(MES);
				};
				if(dia < 10)
				{
					DIAC='0'+String(dia);
				}else
				{
					DIAC=String(dia);
				};				
				var fecha=ANIO+'/'+MESC+'/'+DIAC;
			break;
			case "anios":
				var anio=0;
				var hora=hor_in;
				var DIAC=fec_in.substr(8,2)
				var DIA=parseInt(DIAC,10)
				var MESC=fec_in.substr(5,2);
				var MES=parseInt(MESC,10);
				var ANIOC=fec_in.substr(0,4);
				var ANIO=parseInt(ANIOC,10)+parseInt(cant,10);				
				if ((ANIO%4)!=0 && MES==2 && DIA==29)
				{
					DIA--;
				};
				if(MES < 10)
				{
					MESC='0'+String(MES);
				}else
				{
					MESC=String(MES);
				};
				if(DIA < 10)
				{
					DIAC='0'+String(DIA);
				}else
				{
					DIAC=String(DIA);
				};
				ANIOC=String(ANIO);
				var fecha=ANIOC+'/'+MESC+'/'+DIAC;				
			break;
		};
		var f_h_in=new Array(fecha,hora)
		return f_h_in;
	};

						//CALCULA FECHAS PASADAS DE ACUERDO A UNA FECHA INCIAL Y LA CANTIDAD DE HORAS, DIAS, MESES O AÑOS QUE SE QUIERA INGRESAR
	function calc_fec_hora_neg(fec_in,hor_in,cant,tiempo)
	{
		switch(tiempo){
			case "horas":
				var c_hora=0;
				var hora_c
				var cont_dias=0;
				var fecha=fec_in;
				var hora_=parseInt(hor_in.substr(0,2),10);
				c_hora=hora_-cant;
				while (c_hora < 0 )
				{
					c_hora+=24;
					cont_dias++;
				};
				if (c_hora < 10)
				{
					hora_c='0'+String(c_hora);
				}else
				{
					hora_c=String(c_hora);
				};
				hora_c=hora_c+hor_in.substr(2,6);
				if((hora_-cant) < 0)
				{
					var f_h_in=calc_fec_hora_neg(fecha,hora_c,cont_dias,'dias');
					fecha= f_h_in[0];
					hora= f_h_in[1];
				}else
				{
					hora= hora_c;
				};
			break;
			case "dias":
				var dia=0;
				var hora=hor_in;
				var max_di;
				var DIAC=fec_in.substr(8,2)
				var DIA=parseInt(DIAC,10)
				var MESC=fec_in.substr(5,2);
				var MES=parseInt(MESC,10);
				var ANIOC=fec_in.substr(0,4);
				var ANIO=parseInt(ANIOC,10);
				dia=DIA-cant;
				while ( dia <= 0 )
				{
					MES--;
					if ( MES < 1 )
					{
						MES=MES+12;
						ANIO--;
					};
					bis=ANIO % 4;
					switch(MES){
						case 2:
							if ( bis==0 ) { max_di=29; } else { max_di = 28 ; };
						break;
						case 4:
							max_di=30;
						break;
						case 6:
							max_di=30;
						break;
						case 9:
							max_di=30;
						break;
						case 11:
							max_di=30;
						break;
						default:
							max_di=31;
						break;
					};
					dia=dia+max_di;
				};
				if(MES < 10)
				{
					MESC='0'+String(MES);
				}else
				{
					MESC=String(MES);
				};
				if(dia < 10 )
				{
					DIAC='0'+String(dia)
				}else
				{
					DIAC=String(dia);
				};
				var fecha=String(ANIO)+'/'+MESC+'/'+DIAC;
			break;
			case "meses":
				var dia=0;
				var NDIAS=0;
				var hora=hor_in;
				var DIAC=fec_in.substr(8,2)
				var DIA=parseInt(DIAC,10)
				var MESC=fec_in.substr(5,2);
				var MES=parseInt(MESC,10);
				var ANIOC=fec_in.substr(0,4);
				var ANIO=parseInt(ANIOC,10);
				var ANIO2=ANIO; 
				var MES2=MES;
				for (var cont_mes=cant; cont_mes > 0; cont_mes--)
				{
					MES2--;
					if (MES2 < 1)
					{
						ANIO2--;
						MES2+=12;
					};
					bis=ANIO2 % 4;
					switch(MES2){
						case 2:
							if ( bis==0 ) { max_di=29; } else { max_di = 28; };
						break;
						case 4:
							max_di=30;
						break;
						case 6:
							max_di=30;
						break;
						case 9:
							max_di=30;
						break;
						case 11:
							max_di=30;
						break;
						default:
							max_di=31;
						break;
					};
					NDIAS+=max_di;
				};
				dia=DIA-NDIAS;
				while ( dia <= 0 )
				{
					MES--;
					if ( MES < 1 )
					{
						MES=MES+12;
						ANIO--;
					};
					bis= ANIO % 4;
					switch(MES){
						case 2:
							if ( bis==0 ) { max_di=29; } else { max_di = 28 ; };
						break;
						case 4:
							max_di=30;
						break;
						case 6:
							max_di=30;
						break;
						case 9:
							max_di=30;
						break;
						case 11:
							max_di=30;
						break;
						default:
							max_di=31;
						break;
					};
					dia=dia+max_di;
				};
				if(MES < 10)
				{
					MESC='0'+String(MES);
				}else
				{
					MESC=String(MES);
				};
				if(dia < 10 )
				{
					DIAC='0'+String(dia)
				}else
				{
					DIAC=String(dia);
				};
				var fecha=String(ANIO)+'/'+MESC+'/'+DIAC;
			break;
			case "anios":
				var anio=0;
				var hora=hor_in;
				var DIAC=fec_in.substr(8,2)
				var DIA=parseInt(DIAC,10)
				var MESC=fec_in.substr(5,2);
				var MES=parseInt(MESC,10);
				var ANIOC=fec_in.substr(0,4);
				var ANIO=parseInt(ANIOC,10);
				anio=ANIO-cant;
				if ((anio % 4)!=0 && MES==2 && DIA==29)
				{
					DIA--;
				};
				if(MES < 10)
				{
					MESC='0'+String(MES);
				}else
				{
					MESC=String(MES);
				};
				if(DIA < 10 )
				{
					DIAC='0'+String(DIA)
				}else
				{
					DIAC=String(DIA);
				};
				var fecha=String(ANIO)+'/'+MESC+'/'+DIAC;
			break;
		};
		var f_h_in=new Array(fecha,hora)
		return f_h_in;
	};

//-->
