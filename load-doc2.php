<?php
	$es_hijo=2;
	require_once ('session.php');
	require("include/header.inc.php");
	require("css/main-style.inc.php");
#   require('class/mysql_table.php');
//	require('class/mysql_crud.php');
#	require('class/format_db_content.php');
	require('css/css-func.inc.php');
	if($_SERVER['REQUEST_METHOD']!='POST'){
		//echo 'ataque';
		#header("Location: http://regprof.inpc.gob.ec/");
		header ("Location: http://".$_SERVER['SERVER_NAME']);
		exit;
	};
?>
<hmtl>
<BODY >
	<center>
	<form>
<?php
	$file_prefix='cert-post-';
	$doc_dir=$_SERVER['DOCUMENT_ROOT'].'/storage/';
	if(!$_POST['rmdoc']){		
		if ($_FILES['userfile']['error']==0 ){
			if (!is_dir($doc_dir))		//SI NO EXISTE EL DIRECTORIO......
			{echo 'crea';
				mkdir($doc_dir,0755);			//.......LO CREA
			};
			$tmpfile=$_FILES['userfile']['tmp_name'];
			$destfile=$doc_dir.$file_prefix.$_POST['idpost'].'.pdf';
			if (move_uploaded_file($tmpfile,$destfile )){
?>
				<p align="center">
					<b>
						Documento Cargado exitosamente
					</b>
				</p>
				<script>
					window.opener.refresh('validador-gui-xvalidar.php');
				</script>
<?php
	      
#	      $lcuserfile=strtolower($userfile_name);
#	      $mv="mv ".$doc_dir.$userfile_name." ".$doc_dir.$lcuserfile;
#	      system ($mv);
				$label='Aceptar';
				$action='window.close()';
			}else{
				$label='Reintentar';
				$action="history.go(-1)";
?>
				<p align="center">
					<b>
						Hubo alg&uacute;n problema con la transferencia del archivo <?php echo $_FILES['userfile']['name']?><br>
						Verfique el formato o tipo de archivo sea PDF y que no sea mayor a 2 MBytes.
					</b>
				</p>
<?php
			};
?>
		<p align="center">
			<b>
				<input class='buton' type="button" name="ok" value="<?php echo $label?>" onClick="<?php echo $action?>">
			</b>
		</p>	
<?php
		};
	}else
	{

	  $mv="rm -f ".$doc_dir.$file_prefix.$_POST['idpost'].".pdf";
	  system ($mv);
?>
		<script>
			window.opener.refresh('validador-gui-xvalidar.php');
			window.close();
		</script>
<?php
	};
?>
	</form>
	</center>
</BODY>
</HTML>
