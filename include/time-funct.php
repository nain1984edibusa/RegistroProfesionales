<?php
//----------------------------------------------------------------------------------------------------------------------------------
					//OBTIENE LAS HORAS QUE HAN PASADO DESDE UNA HORA DADA HASTA LA ESPECIFICADA COMO FINAL

	function cal_horas($hor_ini,$hor_fin){
		$fhora =substr($hor_fin,0,2);//hora final
		$fminu=substr($hor_fin,3,2);
		$fseg  =substr($hor_fin,6,2);//hora final
		$ihora=substr($hor_ini,0,2);//hora inicial
		$iminu=substr($hor_ini,3,2);
		$iseg =substr($hor_ini,6,2);//hora inicial
		if ($fhora >= $ihora){
			if ($iseg <= $fseg){
				$seg=$fseg-$iseg;
			}else{
				$fseg+=60;
				$seg=$fseg-$iseg;
				$fminu--;
			};
			if ($iminu <= $fminu){
				$min=$fminu-$iminu;
			}else{
				$fminu+=60;
				$min=$fminu-$iminu;
				$fhora--;
			};
			$hora=$fhora-$ihora;
		};
		return array($hora,$min,$seg);
	};

//----------------------------------------------------------------------------------------------------------------------------------
					//OBTIENE LOS AnioS QUE HAN PASADO DESDE UNA FECHA DADA HASTA LA ESPECIFICADA COMO FINAL

	function cal_years_serv($fec_ini,$fec_fin){
		$fyear =substr($fec_fin,0,4);//fecha final
		$fmonth=substr($fec_fin,5,2);
		$fday  =substr($fec_fin,8,2);//fecha final
		$iyear=substr($fec_ini,0,4);//fecha inicial
		$imon =substr($fec_ini,5,2);
		$iday =substr($fec_ini,8,2);//fecha inicial
		if ($fyear >= $iyear){
			if ($iday <= $fday){
				$dias=$fday-$iday;
			}else{
				$fday+=30;
				$dias=$fday-$iday;
				$fmonth--;
			};
			if ($imon <= $fmonth){
				$mes=$fmonth-$imon;
			}else{
				$fmonth+=12;
				$mes=$fmonth-$imon;
				$fyear--;
			};
			$anio=$fyear-$iyear;
			if($mes==12){
			  $anio++;
			  $mes=0;
			};
		};
		return array($anio,$mes,$dias);
	};

//----------------------------------------------------------------------------------------------------------------------------------
					//	COMPARA DOS FECHAS Y DEVUELVE SI ES MAYOR[2] MENOR[0] O IGUAL[1] Y LA FECHA1 Y SI ES POR MES DIA O ANIO
					//	SINTAXIS ARRAY RESPUESTAS ( [><=] , [anios] , [meses] , [dias])

	function compare_date($f1,$f2)
	{
		if (strstr($f1,'/')){
			$fecha1=explode('/',$f1);
		}else{
			$fecha1=explode('-',$f1);
		};
		if (strstr($f2,'-')){
			$fecha2=explode('/',$f2);
		}else{
			$fecha2=explode('-',$f2);
		};		//FECHA[0] =ANIO FECHA[1] =MES	FECHA[2]=DIA
		
		if ($fecha1[0]>$fecha2[0]){
			$cant=cal_years_serv($f2,$f1);
			$result= array(2,$cant[0],$cant[1],$cant[2]);
		};
		if ($fecha1[0]<$fecha2[0]){
			$cant=cal_years_serv($f1,$f2);
			$result= array(0,$cant[0],$cant[1],$cant[2]);
		};
		if ($fecha1[0]==$fecha2[0]){
			if ($fecha1[1]>$fecha2[1]){
				$cant=cal_years_serv($f2,$f1);
				$result= array(2,$cant[0],$cant[1],$cant[2]);
			};
			if ($fecha1[1]<$fecha2[1]){
				$cant=cal_years_serv($f1,$f2);
				$result= array(0,$cant[0],$cant[1],$cant[2]);
			};
			if ($fecha1[1]==$fecha2[1]){
				if ($fecha1[2]>$fecha2[2]){
					$cant=cal_years_serv($f2,$f1);
					$result= array(2,$cant[0],$cant[1],$cant[2]);
				};
				if ($fecha1[2]<$fecha2[2]){
					$cant=cal_years_serv($f1,$f2);
					$result= array(0,$cant[0],$cant[1],$cant[2]);
				};
				if ($fecha1[2]==$fecha2[2]){
					$cant=cal_years_serv($f2,$f1);
					$result= array(1,$cant[0],$cant[1],$cant[2]);
				};
			};
		};
		return $result;
	};
//----------------------------------------------------------------------------------------------------------------------------------
					//	COMPARA DOS HORASY DEVUELVE SI ES MAYOR[2] MENOR[0] O IGUAL[1] Y LA HORA1 Y SI ES POR SEGUNDO MINUTO U HORA
					//	SINTAXIS ARRAY RESPUESTAS ( [><=] , [horas] , [minutos] , [segundos])

	function compare_time($h1,$h2){
		//echo "se comparan".$h1.$h2."\n";
		$hora1=explode(':',$h1);
		$hora2=explode(':',$h2);
						//HORA[0] =HORA	 HORA[1] =MINUTO	HORA[2]=SEGUNDO
		if ($hora1[0]>$hora2[0]){
			$cant=cal_horas($h2,$h1);
			$result= array(2,$cant[0],$cant[1],$cant[2]);
		};
		if ($hora1[0]<$hora2[0]){
			$cant=cal_horas($h1,$h2);
			$result= array(0,$cant[0],$cant[1],$cant[2]);
		};
		if ($hora1[0]==$hora2[0]){
			if ($hora1[1]>$hora2[1]){
				$cant=cal_horas($h2,$h1);
				$result= array(2,$cant[0],$cant[1],$cant[2]);
			};
			if ($hora1[1]<$hora2[1]){
				$cant=cal_horas($h1,$h2);
				$result= array(0,$cant[0],$cant[1],$cant[2]);
			};
			if ($hora1[1]==$hora2[1]){
				if ($hora1[2]>$hora2[2]){
					$cant=cal_horas($h2,$h1);
					$result= array(2,$cant[0],$cant[1],$cant[2]);
				};
				if ($hora1[2]<$hora2[2]){
					$cant=cal_horas($h1,$h2);
					$result= array(0,$cant[0],$cant[1],$cant[2]);
				};
				if ($hora1[2]==$hora2[2]){
					$cant=cal_horas($h2,$h1);
					$result= array(1,$cant[0],$cant[1],$cant[2]);
				};
			};
		};
		//echo $result[0]." horas,".$result[1]." minutos, ".$result[2]." segundos\n";
		return $result;
	};
//----------------------------------------------------------------------------------------------------------------------------------

?>
