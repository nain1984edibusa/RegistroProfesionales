<?php
	$es_hijo=1;
	require_once ('session.php');
	require("include/header.inc.php");
	require("css/main-style.inc.php");
   require('class/mysql_table.php');
//	require('class/mysql_crud.php');
	require('class/format_db_content.php');
	require('css/css-func.inc.php');
	require('maneja-archivos.php');
	if($_SERVER['REQUEST_METHOD']!='POST'){
		//echo 'ataque';
		#header("Location: http://regprof.inpc.gob.ec/");
		header ("Location: http://".$_SERVER['SERVER_NAME']);
		exit;
	};
/*cambio*/	function get_espec($idProf){
/*cambio*/		global $db, $pusmaneja, $area_espec;
/*cambio*/		$sql="SELECT ProfesionalEspec FROM Profesional WHERE idProfesional = '".$idProf."'";
/*cambio*/		$valor_=$db->query($sql);		
/*cambio*/		$valor=$valor_->fetch(PDO::FETCH_ASSOC);
/*cambio*/		return $valor['ProfesionalEspec'];
/*cambio*/	};

	function is_RestSinT($idProf){
		global $db;
		$sql="SELECT ProfesionalRestSinT FROM Profesional WHERE idProfesional = '".$idProf."'";
		$valor_=$db->query($sql);		
		$valor=$valor_->fetch(PDO::FETCH_ASSOC);
		return $valor['ProfesionalRestSinT'];
	};
	
	function get_reg_code($tipop,$prof_pre_reg_cod){
/*cambio*/		global $db,$espec,$cod_en_curso,$abc;

/*cambio*/		$prfx='';
/*cambio*/		switch($espec){
/*cambio*/			case 'P':
/*cambio*/				$prfx='Paleon-';
/*cambio*/			break;
/*cambio*/			case 'A':
/*cambio*/				$prfx='Arqueo-';
/*cambio*/			break;
/*cambio*/			default:
/*cambio*/				$prfx='RestM-';
/*cambio*/			break;
/*cambio*/		};
#if($abc=='1716317159'){$prfx='Paleon-';};
		$select="<SELECT title='Escoja codigo' NAME='cod_pro' size='1' onFocus=\"set_bgcolor(this,'#99ffff')\" onBlur=\"set_bgcolor(this,'');\">";

		$pre_reg_cod="SELECT RegistroPCodigo FROM RegistroP WHERE RegistroPProfesionalID = ".$tipop." and Profesional_idProfesional = '".$prof_pre_reg_cod."'";
		$pre_r_cod_=$db->query($pre_reg_cod);
		if($pre_r_cod_->rowCount()>0){
			$pre_r_cod=$pre_r_cod_->fetch(PDO::FETCH_ASSOC);
				$select.="<OPTION  value='".$pre_r_cod['RegistroPCodigo']."'>".$pre_r_cod['RegistroPCodigo']."</OPTION>";
		}else{
			$codes_sql="SELECT CodProfesionalPrefijo, CodProfesionalInicio FROM CodProfesional WHERE TipoProfesional_TipoProfesionalId=".$tipop." and CodProfesionalPrefijo='".$prfx."'";
			$codes_=$db->query($codes_sql);
			while($_code = $codes_->fetch(PDO::FETCH_ASSOC)) {
#		if($abc=='1721981437'){echo $cod_en_curso.'  prueba '.$prfx.' '.$_code['CodProfesionalInicio'].' '.$_code['CodProfesionalPrefijo'].' '.$sql_code_posted.' '.$codes_sql;};
				$num_=0;
				$j=0;
	if($_code['CodProfesionalPrefijo']==$prfx){
					if(isset($num)){unset($num);};
					$code_used=$db->query("SELECT RegistroPCodigo FROM RegistroP WHERE RegistroPProfesionalID = ".$tipop." and RegistroPCodigo like '".$_code['CodProfesionalPrefijo']."%'");
					while($codes = $code_used->fetch(PDO::FETCH_ASSOC)) {
						$num[$j]=substr($codes['RegistroPCodigo'],stripos($codes['RegistroPCodigo'],'-')+1,strlen($codes['RegistroPCodigo'])-stripos($codes['RegistroPCodigo'],'-'));
						$j++;
					};
					$sql_code_posted="SELECT InformeTecnicoCodPro FROM InformeTecnico WHERE InformeTecnicoCodPro like '".$_code['CodProfesionalPrefijo']."%'";
					$code_posted=$db->query($sql_code_posted);
					while($codesu = $code_posted->fetch(PDO::FETCH_ASSOC)) {
						$num[$j]=substr($codesu['InformeTecnicoCodPro'],stripos($codesu['InformeTecnicoCodPro'],'-')+1,strlen($codesu['InformeTecnicoCodPro'])-stripos($codesu['InformeTecnicoCodPro'],'-'));
						$j++;
					};
					$ini_= (int) $_code['CodProfesionalInicio'];
					if(isset($num) ){
						$num_= (int) (max ($num));
						$next=($num_ > $ini_)?$num_+1:$ini_+1;
/*cambio*/				if($cod_en_curso==''){$cod_en_curso=$next;$cod_en_curso++;}else{$next=$cod_en_curso;$cod_en_curso++;};
					}else{
						$next=$ini_;
					};
					$snext=(string) $next;
					$snext=(strlen($snext)<3)?((strlen($snext)==2)?'0'.$snext:'00'.$snext):$snext;
					$ncode=$_code['CodProfesionalPrefijo'].$snext;
/*cambio*/				if($prfx==$_code['CodProfesionalPrefijo']){$seleted='selected';};
/*cambio*/				$select.="<OPTION $seleted value='".$ncode."'>".$ncode."</OPTION>";
				};		
			};
		};
		return $select.="</SELECT>";
	};
?>
	<SCRIPT LANGUAGE="JavaScript1.2" src="java/type.js"></SCRIPT>
	<SCRIPT LANGUAGE="JavaScript1.2" src="java/formsm.js"></SCRIPT>
	<SCRIPT LANGUAGE="JavaScript1.2" src="java/check_fun.js"></SCRIPT>
	<SCRIPT LANGUAGE="JavaScript1.2" src="java/dinamico.js"></SCRIPT>
	<SCRIPT LANGUAGE="JavaScript1.2"  src="java/check_valid.js"  charset="ISO-8859-1"></SCRIPT>
	<SCRIPT LANGUAGE="JavaScript1.2">
 	 	var url;
 	 	var url_base="http://www.senescyt.gob.ec/web/guest/consultas/";
 	 	function refresh(donde){
 	 		document.cher.action=donde;
 	 		document.cher.submit();
 	 	}
	</SCRIPT>

 <HTML>
<BODY onLoad="alert('Ayuda: Si una solicitud es rechazada antes de llenar las referencias a los documentos, cargue del archivo PDF');">
<div style="position:absolute"><a href="Javascript:" onMouseOver="swap('reloadi.png','reload.png','rld');" onClick="cher.action='<?php echo $_SERVER['PHP_SELF']?>';cher.target='_self';cher.submit();"><img name='rld' height='19' src='image/reload.png' alt='refrescar pantalla' title='Refrescar pantalla'></a></div>	<form name="cher" action=" " method="post" >
         <input type="hidden" name="subsys">
         <input type="hidden" name="prof">
         <input type="hidden" name="idpost">
         <input type='hidden' name='basecod' >
         <input type='hidden' name='act_dea' >
		<input type='hidden' name='us_maneja' value="<?php echo $_POST['us_maneja']?>" >
         <input type="hidden" name="pagina" value="<?php if(isset($_POST['pagina'])){echo $_POST['pagina']; };?>">
        </form>

	
<?php
	
	//Limito la busqueda
	$TAMANO_PAGINA = 5;

	//examino la página a mostrar y el inicio del registro a mostrar
	$pagina = $_POST["pagina"];
	if (!$pagina) {
	   $inicio = 0;
	   $pagina = 1;
	}
	else {
	   $inicio = ($pagina - 1) * $TAMANO_PAGINA;
	};
		$stotp_=$db->query("SELECT count(t1.Postulacion_idPostulacion) as tot FROM AccionEnPostulacion as t1, Postulacion as t2, Profesiones as t3 WHERE (t1.Postulacion_idPostulacion=t2.idPostulacion and t1.user_username='".$_SESSION['user']."' and t1.AccionEnPostulacionAccion =4 and t2.PostulacionVerificado=0 and AccionEnPostulacionActiva=1) and (t2.Profesiones_idProfesiones=t3.idProfesiones and t3.TipoProfesional_TipoProfesionalId=".$_POST['us_maneja'].")");
        $stotp=$stotp_->fetch(PDO::FETCH_ASSOC);
		//calculo el total de páginas
		$total_paginas = ceil($stotp['tot'] / $TAMANO_PAGINA);

	$st_base_cod = $db->query("SELECT TipoProfesionalPrefijoCodigo FROM TipoProfesional WHERE TipoProfesionalId=".$_POST['us_maneja'] );	
	$basecod= $st_base_cod->fetch(PDO::FETCH_ASSOC);
	$stfac = $db->query("SELECT t1.Postulacion_idPostulacion, t2.*, t1.AccionEnPostulacionFechaAs, timediff(CONVERT_TZ(concat(CURDATE(),' ',CURTIME()),'+00:00','-05:00'),t1.AccionEnPostulacionFechaAs) as demora  FROM AccionEnPostulacion as t1, Postulacion as t2, Profesiones as t3 WHERE (t1.Postulacion_idPostulacion=t2.idPostulacion and t1.user_username='".$_SESSION['user']."' and t1.AccionEnPostulacionAccion =4 and t2.PostulacionVerificado=0 and AccionEnPostulacionActiva=1) and (t2.Profesiones_idProfesiones=t3.idProfesiones and t3.TipoProfesional_TipoProfesionalId=".$_POST['us_maneja'].") LIMIT ".$inicio."," . $TAMANO_PAGINA);

?>
	<center><img height='30' src='image/proces2.png'></center><br>
		<center><strong>Solicitudes por Revisar: <?php echo $stotp['tot']?></strong></center>
		<table width ='96%' height="226" border='1' align='center' cellpadding='5' cellspacing='1' class='seccion1'>
			<tr bgcolor='#ffffff'><tH><B>Solicitante:</b></th>
				<th width><b>Fecha y Hora Asignaci&oacute;n:</b></th>
<!--				<th><b>Base de Datos:</b></th>-->
				<th><b>Revisi&oacute;n de Datos:</b></th>
				<th><b>Respuesta a Solicitud:</b></th>
				<th><b> Informe T&eacute;cnico:</b></th>
				<th width='15%'><b>Acciones:</b></th>
			</tr>
<?php
		$cod_en_curso='';
		$pusmaneja=$_POST['us_maneja'];
	while($row = $stfac->fetch(PDO::FETCH_ASSOC)) {
		$post_data = $db->query("SELECT Profesional_idProfesional FROM Profesiones WHERE idProfesiones=".$row['Profesiones_idProfesiones']."");
		$postd=$post_data->fetch(PDO::FETCH_ASSOC);
		$starea = $db->query("SELECT TipoProfesional_TipoProfesionalId FROM Profesiones WHERE idProfesiones=".$row['Profesiones_idProfesiones']."");
		$area=$starea->fetch(PDO::FETCH_ASSOC);
		if (/*TRUE OR*/ ($area['TipoProfesional_TipoProfesionalId']==$_POST['us_maneja'])){
			 $area_espec=$area['TipoProfesional_TipoProfesionalId'];
/*cambio*/		$espec=get_espec($postd['Profesional_idProfesional']);
			$fname='fr_'.$row['Postulacion_idPostulacion'];
			$RestSinT=is_RestSinT($postd['Profesional_idProfesional']);


			$rref_resp='';
			$rresumen='';
			$rref_doc='';
			$rrecom='';
			$oobsr='';
			$sql_resp_exist="SELECT * FROM SolicitudRespuesta WHERE Postulacion_idPostulacion=".$row['idPostulacion'];
			$resp_ex=$db->query($sql_resp_exist);
			if($resp_ex->RowCount()>0){
				$respu=$resp_ex->fetch(PDO::FETCH_ASSOC);
				$rref_resp=$respu['SolicitudRespuestaRefDoc'];
				$rresumen=$respu['SolicitudRespuestaResumen'];
			};
			$sql_inf_exist="SELECT * FROM InformeTecnico WHERE Postulacion_idPostulacion=".$row['idPostulacion'];
			$inf_ex=$db->query($sql_inf_exist);
			if($inf_ex->RowCount()>0){
				$infor=$inf_ex->fetch(PDO::FETCH_ASSOC);
				$rref_doc=$infor['InformeTecnicoRefDoc'];
				$rrecom=$infor['InformeTecnicoRecomendacion'];
				if(!isset($rresumen)){$rresumen=$infor['InformeTecnicoObservacion'];};
				$oobsr=$infor['InformeTecnicoObservacion'];
			};


?>	
			<tr bgcolor='#ffffff' align='center'>
				<td width='14%'><?php echo format_cont_db('idProfesional',$postd['Profesional_idProfesional'])?></td>
				<td width='11%'><?php echo str_replace(' ','<br>', $row['AccionEnPostulacionFechaAs'])?><br><br>Transcurrido:
					<div ID="clock<?php echo $fname?>" style=" margin-right:60; margin-left:60;text-align:center; font-size: 10px;"><?php echo $row['demora']?></div>
<?php
					$cclock=explode(':',$row['demora']);
?>
					<script>Clocks('clock<?php echo $fname?>','<?php echo $cclock[0]?>','<?php echo $cclock[1]?>','<?php echo $cclock[2]?>');</script>
				</td>
<!--				<td width='14%'><?php echo format_cont_db('TipoProfesionalId',$area	['TipoProfesional_TipoProfesionalId'])?></td>-->
				<td width='17%' nowrap> 
					<a class='info'  style="font-size:11px;"  href="Javascript:" onClick="abrir('','val_per<?php echo $row['idPostulacion'] ?>',(ancho*0.9),alto*0.9,0);<?php echo $fname?>.idpost.value='<?php echo $row['idPostulacion'] ?>';<?php echo $fname?>.prof.value='<?php echo $postd['Profesional_idProfesional']?>';<?php echo $fname?>.target='val_per<?php echo $row['idPostulacion'] ?>';<?php echo $fname?>.action='validar-datos.php';<?php echo $fname?>.submit();return false;">Validaci&oacute;n 	INFODIGITAL</a><br><br>
					<font style="font-size:11px;"><b>Datos Personales:</b> <?php echo format_cont_db('PostulacioncCumpleInfoP',$row['PostulacioncCumpleInfoP'])?><br>
					<b>Formaci&oacute;n Acad&eacute;mica:</b> <?php echo format_cont_db('PostulacionCumpleInfoA',$row['PostulacionCumpleInfoA'])?></font><br>
<?php
			if($RestSinT){
?>
					<br><b>Pre-registrado sin t&iacute;tulo</b>
<?php
			};
?>
				</td>
<?php
			$rechazada=0;
			$file=$file_prefix.$row['Postulacion_idPostulacion'].'.pdf'; 
			if (exist_doc($file) or ($row['PostulacionCumpleInfoA']==0 or $row['PostulacioncCumpleInfoP']==0)){
				$rechazada=1;
			};
?>

				<td  width='17%' valign='top'  bgcolor='#dddddd' > <form name='<?php echo $fname?>' method='POST'> <!--FORMA DE VALIDACION-->
					<input type='hidden' name='RestSinT' value='<?php echo $RestSinT?>'>
					<input type='hidden' name='valdp' value='<?php echo $row['PostulacioncCumpleInfoP']?>'>
					<input type='hidden' name='valacad' value='<?php echo $row['PostulacionCumpleInfoA']?>'>

					<SELECT disabled title='Escoger Aceptada o Rechazada' NAME="recomendacion" size="1"  onFocus="set_bgcolor(this,'#99ffff')" onBlur="set_bgcolor(this,'');switch(this.options[this.selectedIndex].value){case 'aprobada': expandit2('<?php echo $fname?>codl',1);expandit2('<?php echo $fname?>respuesta',1);<?php echo $fname?>.cod_pro.focus();expandit2('<?php echo $fname?>loadf',0); break; case '0':expandit2('<?php echo $fname?>codl',0);expandit2('<?php echo $fname?>respuesta',0);expandit2('<?php echo $fname?>loadf',0);break; case 'rechazada': expandit2('<?php echo $fname?>codl',0);expandit2('<?php echo $fname?>respuesta',1);expandit2('<?php echo $fname?>loadf',1);<?php echo $fname?>.resp_ref.focus();break;};" onChange="switch(this.options[this.selectedIndex].value){case 'aprobada': expandit2('<?php echo $fname?>codl',1);expandit2('<?php echo $fname?>respuesta',1);<?php echo $fname?>.cod_pro.focus();expandit2('<?php echo $fname?>loadf',0); break; case '0':expandit2('<?php echo $fname?>codl',0);expandit2('<?php echo $fname?>respuesta',0);expandit2('<?php echo $fname?>loadf',0);break; case 'rechazada': expandit2('<?php echo $fname?>codl',0);expandit2('<?php echo $fname?>respuesta',1);expandit2('<?php echo $fname?>loadf',1);<?php echo $fname?>.cod_pro.value='';<?php echo $fname?>.resp_ref.focus();break;};">
						<OPTION  value="0"> </OPTION>
						<OPTION  value="aprobada" <?php if(!$rechazada){echo 'selected';};?>>Aprobada</OPTION>
						<OPTION  value="rechazada" <?php if($rechazada){echo 'selected';};?>>Rechazada</OPTION>
					</SELECT>
					<input type='hidden' name='recomendacion_'>
					<br>
					<DIV id='<?php echo $fname?>codl' style="DISPLAY: ; head: " >
<?php
		if ($row['PostulacionCumpleInfoA']==1 and $row['PostulacioncCumpleInfoP']==1){
		$abc=$postd['Profesional_idProfesional'];
?>
						<br>C&oacute;digo de Registro: <?php echo get_reg_code($_POST['us_maneja'],$postd['Profesional_idProfesional'])?>
<?php
		};
?>					</div><script>expandit2('<?php echo $fname?>codl',<?php if(!$rechazada){echo '1';}else{echo '0';};?>)</script>
					<DIV id='<?php echo $fname?>respuesta' style="DISPLAY: ; head: " >
						<DIV id='<?php echo $fname?>loadf' style="DISPLAY: ; " >
<?php
		
			$file=$file_prefix.$row['Postulacion_idPostulacion'].'.pdf';
			if (!exist_doc($file)){
?>
					<input type="hidden" name='floaded' value='0'>
						Cargar PDF:<a href='JavaScript:' onClick="abrir('','loadoc',(ancho*0.3),alto*0.3);<?php echo $fname?>.idpost.value='<?php echo $row['Postulacion_idPostulacion'] ?>';<?php echo $fname?>.target='loadoc';<?php echo $fname?>.action='load-doc.php';<?php echo $fname?>.submit();return false;" ><img src='image/upload.png' height='18' alt="Cargar Documento" Title="Cargar Documento"></a>
<?php			
			}else{
?>
					<input type="hidden" name='floaded' value='1'>
						<b><?php echo $file?></b> <a href="http://<?php echo $_SERVER['SERVER_NAME']?>/storage/<?php echo $file?>" target='new'><img src='image/icon_pdf.gif' height='18' alt="Ver Documento" Title="Ver Documento"></a>
						<a href='JavaScript:' onClick="if(confirm('<?php echo utf8_decode('Está')?> Seguro?')){abrir('','loadoc',(ancho*0.5),alto*0.5);<?php echo $fname?>.rmdoc.value='1';<?php echo $fname?>.idpost.value='<?php echo $row['Postulacion_idPostulacion'] ?>';<?php echo $fname?>.target='loadoc';<?php echo $fname?>.action='load-doc2.php';<?php echo $fname?>.submit();}return false;" ><img src='image/icon_delete.gif' height='18' alt="Eliminar Documento" Title="Eliminar Documento"></a>
<?php
			};
?>
						<br> Oficio Respuesta: 
						<br><input type='text' size='20' maxlength='20' name='resp_ref'  value="<?php if(isset($rref_resp) ){echo $rref_resp;};?>" onFocus="set_bgcolor(this,'<?php echo $usr_bgc?>')" onBlur="set_bgcolor(this,'')">
						<br>Observaciones:<br>
						<textarea title='Arrastre esq. inf. derecha para agrandar/achicar' rows="3" cols="20" name='obsr' onFocus="set_bgcolor(this,'<?php echo $usr_bgc?>')" onBlur="set_bgcolor(this,'')"><?php if(isset($rresumen) ){echo $rresumen;};?></textarea>
					</div>
					</div>
				</td>
				<td  width='14%' bgcolor='#dddddd'>
					<input type="hidden" name='prof'>
					<input type='hidden' name='ver_dseguro' value='1' >
					<input type="hidden" name='rmdoc'>
					<input type="hidden" name="pagina" value="<?php if(isset($_POST['pagina'])){echo $_POST['pagina']; };?>">				
					<input type='hidden' name='idpost' value='<?php echo $row['Postulacion_idPostulacion']?>'>
					<input type='hidden' name='us_maneja' value='<?php echo $area['TipoProfesional_TipoProfesionalId']?>'>
					Referencia Informe T&eacute;cnico: <br>
					<input type='text' size='20' maxlength='50' name='doc-ref' value="<?php if(isset($rref_doc) ){echo $rref_doc;};?>" onFocus="set_bgcolor(this,'<?php echo $usr_bgc?>')" onBlur="set_bgcolor(this,'')"><br>
					Observaciones:<br>
					<textarea title='Arrastre esq. inf. derecha para agrandar/achicar' rows="3" cols="20" name='obs' onFocus="set_bgcolor(this,'<?php echo $usr_bgc?>')" onBlur="set_bgcolor(this,'')"><?php if(isset($oobsr) ){echo $oobsr;};?></textarea>
				</td></form><script>expandit2('<?php echo $fname?>respuesta',1);expandit2('<?php echo $fname?>loadf',<?php echo $rechazada?>)</script>
				<td class='menubar' width='13%' align='center'>&nbsp;<a style="font-size: 11px" href="JavaScript:" onClick="<?php echo $fname?>.target='_self';cher.basecod.value='<?php echo $basecod['TipoProfesionalPrefijoCodigo']?>';if(validate('<?php echo $fname?>')){<?php echo $fname?>.action='validar-post.php';<?php echo $fname?>.submit();};return false;">Remitir a Direcci&oacute;n Conservaci&oacute;n</a>&nbsp;</td>
           </tr>
<?php
				};
			};
?>
	</table>
<?php
if ($total_paginas > 1) {
	echo "<table border='0' align='center'> <tr valign='middle'><td>";
   if ($pagina != 1)
      echo '<a href="" class="info" style="font-size: 11px" onClick="cher.target=\'idbx'.$_POST['us_maneja'].'\';cher.action=\'validador-gui-xvalidar.php\';cher.pagina.value=\''.($pagina-1).'\';cher.submit();return false"><img src="image/izq.gif" height=\'90%\' border="0"></a>&nbsp;';
      for ($i=1;$i<=$total_paginas;$i++) {
         if ($pagina == $i)
            //si muestro el índice de la página actual, no coloco enlace
            echo $pagina;
         else
            //si el índice no corresponde con la página mostrada actualmente,
            //coloco el enlace para ir a esa página
      echo '<a href=""  class="info" style="font-size: 11px" onClick="cher.target=\'idbx'.$_POST['us_maneja'].'\';cher.action=\'validador-gui-xvalidar.php\';cher.pagina.value=\''.$i.'\';cher.submit();return false">&nbsp;['.$i.']&nbsp;</a>';
      }
      if ($pagina != $total_paginas)
        echo '&nbsp;<a href=""  class="info" style="font-size: 11px" onClick="cher.target=\'idbx'.$_POST['us_maneja'].'\';cher.action=\'validador-gui-xvalidar.php\';cher.pagina.value=\''.($pagina+1).'\';cher.submit();return false"><img height=\'90%\' src="image/der.gif" border="0"></a>';
   echo "</td> </tr></table> ";
};

$db=null;

?>

