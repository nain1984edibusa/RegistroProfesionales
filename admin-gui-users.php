<?php
	$es_hijo=1;
	require_once ('session.php');
	require("include/header.inc.php");
	require("css/main-style.inc.php");
   require('class/mysql_table.php');
	require('class/format_db_content.php');
	require('css/css-func.inc.php');


	if($_SERVER['REQUEST_METHOD']!='POST'){
		//echo 'ataque';
		//header("Location: http://regprof.inpc.gob.ec/");
		header ("Location: http://".$_SERVER['SERVER_NAME']);
		exit;
	};
	
?>
         <SCRIPT LANGUAGE="JavaScript1.2" src="java/type.js">
         </SCRIPT>
         <SCRIPT LANGUAGE="JavaScript1.2" src="java/dinamico.js">
         </SCRIPT>
         <SCRIPT LANGUAGE="JavaScript1.2" src="java/formsm.js">
         </SCRIPT>
         <script>
			function addop(sel) {
				var x = sel;
				var option = document.createElement("option");
				option.text = "";
				x.add(option);
				x.selectedIndex=x.length;
			}
		</script>
 <HTML>
<BODY>
<div style="position:absolute"><a href="Javascript:" onMouseOver="swap('reloadi.png','reload.png','rld');" onClick="cher.action='<?php echo $_SERVER['PHP_SELF']?>';cher.target='_self';cher.submit();"><img name='rld' height='19' src='image/reload.png' alt='refrescar pantalla' title='Refrescar pantalla'></a></div>	<form name="cher" action=" " method="post" >	<form name="cher" action=" " method="post" >	
<form name="cher" action=" " method="post" >
         <input type="hidden" name="clos">
         <input type="hidden" name="subsys">
         <input type="hidden" name="usr_">
         <input type="hidden" name="pagina" value="<?php if(isset($_POST['pagina'])){echo $_POST['pagina']; };?>">
<?php
	$fusername='';
	$cfusername='';
	$frname='';
	$cfrname='';
	$ftus='';
	$cftus='';
	$fmails='';
	$cfmails='';
	$ftiprof='';
	$cftiprof='';
	$fstatus='';
	$cfstatus='';
	$hayf=0;
	$filtro='';
	if(isset($_POST['fusername']) and $_POST['fusername']){
		$fusername="username like '%".$_POST['fusername']."%'";
		$hayf++;
	};
	if(isset($_POST['frname']) and $_POST['frname']){
		if($hayf){$cfusername=' AND';}
		$frname="realname like '%".$_POST['frname']."%'";
		$hayf++;
	};
	if(isset($_POST['ftus']) and $_POST['ftus']){
		if($frname or $hayf){$cfrname=' AND';}
		$ftus="TipoUsuario_idTipoUsuario = ".$_POST['ftus'];
		$hayf++;
	};
	if(isset($_POST['fmails']) and $_POST['fmails']){
		if($ftus or $hayf){$cftus=' AND';}
		$fmails="(email like '%".$_POST['fmails']."%' or email2 like '%".$_POST['fmails']."%' )";
		$hayf++;
	};
	if(isset($_POST['ftiprof']) and $_POST['ftiprof']){
		if($fmails or $hayf){$cfmails=' AND';}
		$ftiprof=" subselect like '%".$_POST['ftiprof']."%'";
		$hayf++;
	};
	if(isset($_POST['fstatus']) and $_POST['fstatus']!=''){
		if($fmails or $hayf){$cfmails=' AND';}
		$fstatus="userEstado = ".$_POST['fstatus']." ";
		$hayf++;
	};
	if ($hayf){
		$filtro=" AND ( $fusername $cfusername $frname $cfrname $ftus $cftus $fmails $cfmails $fstatus )";
	};
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
		$sql_tot="select count(username) as tot from user WHERE TipoUsuario_idTipoUsuario <> 3 $filtro order by userEstado DESC, username ASC";
        $stotp_= $db->query($sql_tot);
        $stotp=$stotp_->fetch(PDO::FETCH_ASSOC);
		//calculo el total de páginas
		$total_paginas = ceil($stotp['tot'] / $TAMANO_PAGINA);

		$sql_sql="SELECT * FROM user WHERE TipoUsuario_idTipoUsuario <> 3  $filtro order by userEstado DESC, username ASC LIMIT ".$inicio."," . $TAMANO_PAGINA;
        $stfac = $db->query($sql_sql);

?>
<br>                <table border='0' width ='98%' align='center' cellpadding='5' cellspacing='2' class='seccion'>
							<tr bgcolor='#ffffff'>
								<tH colspan='7'><B>Total Usuarios: <?php echo $stotp['tot'];?></b>
							</tr>
							<tr bgcolor='#ffffff'>
								<tH><B>Nombre Usuario:</b>
								</th>
								<th><b>Nombre Real:</b>
								</th>
								<th><b>Tipo Usuario:</b>
								</th>
								<th><b>Corrreo(s) Electr&oacute;nico(s):</b>
								</th>
								<th><b>Atiende Solicitudes De:</b>
								</th>
								<th><b>Estado:</b>
								</th>
								<th><b>Acciones:</b>
								</th>
							</tr>
							<tr bgcolor='#e3f2dd' align='center'>
								<td>
									<input type="text" name="fusername" value="<?php if(isset($_POST['fusername'])){echo $_POST['fusername'];}?>" size="13" maxlength="45" onFocus="set_bgcolor(this,'<?php echo $usr_bgc?>')" onBlur="set_bgcolor(this,'')" onClick="">
								</td>
								<td>
									<input type="text" name="frname" value="<?php if(isset($_POST['frname'])){echo $_POST['frname'];}?>" size="13" maxlength="45" onFocus="set_bgcolor(this,'<?php echo $usr_bgc?>')" onBlur="set_bgcolor(this,'')" onClick="">
								</td>
								<td>
<?php
	 if(isset($_POST['ftus'])){
	 	$ftus_=$_POST['ftus'];
	 }else{
	 	$ftus_='';
	 };
?>
									<?php load_of_db('ftus',$ftus_);?>
								</td>
								<td>
									<input type="text" name="fmails" value="<?php if(isset($_POST['fmails'])){echo $_POST['fmails'];}?>" size="13" maxlength="45" onFocus="set_bgcolor(this,'<?php echo $usr_bgc?>')" onBlur="set_bgcolor(this,'')" onClick="">
								</td>
								<td>
									<!--<input type="text" name="ftiprof" value="<?php if(isset($_POST['ftiprof'])){echo $_POST['ftiprof'];}?>" size="13" maxlength="45" onFocus="set_bgcolor(this,'<?php echo $usr_bgc?>')" onBlur="set_bgcolor(this,'')" onClick="">-->
								</td>
								<td>
									<SELECT NAME="fstatus" size="1"  onFocus="set_bgcolor(this,'#cFcFcF')" onBlur="set_bgcolor(this,'')">
									<OPTION  value="" selected></OPTION>
									<OPTION  value="1" <?php if(isset($_POST['fstatus']) && $_POST['fstatus']=='1'){echo 'selected';}?> >Activo</OPTION>
									<OPTION  value="0" <?php if(isset($_POST['fstatus']) && $_POST['fstatus']=='0'){echo 'selected';}?> >Inhabilitado</OPTION>
						        	</SELECT>
								</td>
							</tr>
							<tr bgcolor='#e3f2dd'><td colspan='7' align='center'><B>
								<a class='elipse' href='JavaScript:' onClick="cher.target='_self';cher.action='admin-gui-users.php';cher.submit();return false">&nbsp;Filtrar&nbsp;</a> 
<?php
						if($hayf){
?>
								<a class='elipse' href='JavaScript:' onClick="cher.fstatus.selectedIndex='0';/*cher.ftiprof.value='';*/cher.fmails.value='';addop(cher.ftus);cher.frname.value='';cher.fusername.value='';cher.target='_self';cher.action='admin-gui-users.php';cher.submit();return false">&nbsp;Quitar filtro&nbsp;</a> 
<?php
						
						}
?>
							</b></td> </tr>
	        </form>
<?php

        while($row = $stfac->fetch(PDO::FETCH_ASSOC)) {
        	if($row['TipoUsuario_idTipoUsuario']!=1){
				$stpr = $db->query("SELECT TipoProfesional_TipoProfesionalId FROM UsuarioManejaProfesional WHERE user_username ='".$row['username']."'");
        		$fname='fr_'.str_replace('.','_',$row['username']);
        	};

?>
                        <tr bgcolor='#ffffff'>
									<td><?php echo $row['username']?>
                            </td>
                            <td><?php echo $row['realname']?>
                            </td>
                            <td><?php echo format_cont_db('idTipoUsuario',$row['TipoUsuario_idTipoUsuario'])?>
                            </td>
                             <td><?php echo $row['email']?><br><?php echo $row['email2']?>
                            </td>
                            <td>
<?php
			if($row['TipoUsuario_idTipoUsuario']!=1){
				while($tiprof = $stpr->fetch(PDO::FETCH_ASSOC)){
					echo '-'.format_cont_db('TipoProfesionalId',$tiprof['TipoProfesional_TipoProfesionalId']).'<br>';
				};

				if ($row['TipoUsuario_idTipoUsuario']==5 or $row['TipoUsuario_idTipoUsuario']==4 /*and $stpr->rowCount()==0*/){
?>
	<a class='info' href="JavaScript:" onClick="if(<?php echo $fname?>.vis.value==0){expandit2('<?php echo $fname?>l',1);<?php echo $fname?>.vis.value=1;}else{expandit2('<?php echo $fname?>l',0);<?php echo $fname?>.vis.value=0};return false;">[+]</a>
								<DIV id='<?php echo $fname?>l' style="DISPLAY: none; head: ;background-color:#cccccc; " >
								<form name='<?php echo $fname?>' method='POST'><center> 
									<input type='hidden' name='vis' value='0'>
									<input type='hidden' name='usrn_' value='<?php echo $row['username']?>'>
									<?php load_of_db('TipoProfesionalId','')?><br>
									<input type="button" name="send" value="Agregar" onFocus="" onBlur="" onClick="if(confirm('Esta Seguro?')){<?php echo $fname?>.action='asigna-profesional.php';<?php echo $fname?>.submit();}">
								</center></form></div><script>expandit2('<?php echo $fname?>l',0)</script>
<?php
				}
			};
?>                             
                            </td>
                             <td><?php echo format_cont_db('userEstado',$row['userEstado']) ?>
                            </td>
                            <td  align='center'>&nbsp;<a class='info' href="JavaScript:" onClick="abrir('','edi_usr',ancho,alto/2,0);cher.usr_.value='<?php echo $row['username']?>';cher.target='edi_usr';cher.action='edita-usuario.php';cher.submit();return false;">Actualizar</a>&nbsp;
                            </td>
           </tr>

<?php
	};

?>
	</table><br>

<?php
if ($total_paginas > 1) {
	echo "<table border='0' align='center'> <tr valign='middle'><td>";
   if ($pagina != 1)
      echo '<a href="" class="info" onClick="cher.target=\'iusers\';cher.action=\'admin-gui-users.php\';cher.pagina.value=\''.($pagina-1).'\';cher.submit();return false"><img src="image/izq.gif" height=\'90%\' border="0"></a>&nbsp;';
      for ($i=1;$i<=$total_paginas;$i++) {
         if ($pagina == $i)
            //si muestro el índice de la página actual, no coloco enlace
            echo $pagina;
         else
            //si el índice no corresponde con la página mostrada actualmente,
            //coloco el enlace para ir a esa página
      echo '<a href="" class="info" onClick="cher.target=\'iusers\';cher.action=\'admin-gui-users.php\';cher.pagina.value=\''.$i.'\';cher.submit();return false">&nbsp;['.$i.']&nbsp;</a>';
      }
      if ($pagina != $total_paginas)
        echo '&nbsp;<a href="" class="info" onClick="cher.target=\'iusers\';cher.action=\'admin-gui-users.php\';cher.pagina.value=\''.($pagina+1).'\';cher.submit();return false"><img height=\'90%\' src="image/der.gif" border="0"></a>';
   echo "</td> </tr></table> ";
}
$db=null;

//http://wiki.hashphp.org/PDO_Tutorial_for_MySQL_Developers
?>
