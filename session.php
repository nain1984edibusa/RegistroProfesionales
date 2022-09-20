<?php //Inicio la sesin
	session_start();
#	if($_SESSION['user']!='0902194570'){
#		header("Location: http://regprof.inpc.gob.ec/index-mant.php");
#	};

	if($_SERVER['REQUEST_METHOD']!='POST'){
		session_destroy();
		#header("Location: http://regprof.inpc.gob.ec/");
		header ("Location: http://".$_SERVER['SERVER_NAME']);
		exit;
	};
	require("include/time-funct.php");
	$ahora_d=date('Y/m/d'); //momento actual dia  
	$ahora_h=date('h:i:s'); //momento actual horae
	//echo "ahora: ".$ahora_d."/".$ahora_h."/ acceso ".$_SESSION['laccess']."\n";
	//$_SESSION['laccess'];
	$lacces=explode("***",$_SESSION['laccess']);
	$sesion_timeout=30;  //maximo minutos en estatus idle- cambio solicitado por Michele Arroyo el 19/12/2014
	$time_out_d=compare_date($ahora_d,$lacces[0]);  //diferencia de acceso en años:meses:dias
	$time_out_h=compare_time($ahora_h,$lacces[1]);  //diferencia de acceso en horas:min:seg
	$time_outd=($time_out_d[1]*365)+($time_out_d[2]*30)+$time_out_d[3]; //diferencia de horas solo en dias
	$time_outd=$time_outd*1440; //paso diferencia en dias a minutos
	$time_outh=($time_out_h[1]*60)+$time_out_h[2]; //diferencia de horas solo en minutos
	$time_out=$time_outd+$time_outh; //diferencia total en minutos
	$timeout_mess='Tiempo de inactividad sobrepasado ';
	//echo "DIFERENCIA EN AÑOS: ".$time_out_d[1]."-".$time_out_d[2]."-".$time_out_d[3]." en minutos".$time_out_h[1]."-".$time_out_h[2]."-".$time_out_h[3]." total".$time_out."-".$sesion_timeout."\n";
	if ($time_out > $sesion_timeout){  // si el status idle a pasado el tiempo maximo se cierra la sesion
		session_destroy(); //destruyo sesion
?>
		<script>
				alert('<?php echo $timeout_mess?>');

<?php
		if(isset($es_hijo) and $es_hijo==1){
?>
	 	 		parent.location='index.php'
<?php
		}else
		{
			if(isset($es_hijo) and $es_hijo==2){
?>
		 	 		opener.parent.location='index.php'
		 	 		window.close();
<?php
			}else{
?>
	 	 		location='index.php'
<?php		
			};
		};
?>
		</script>
<?php
		//ademas salgo de este script
		exit();
	}else{
		$_SESSION['laccess']=date('Y/m/d***h:i:s');
	};
	//COMPRUEBA QUE EL USUARIO ESTA AUTENTIFICADO
	if (isset($_POST["clos"])){
		if($_POST['clos']){
			session_destroy();
?>
			<script>
			location='index.php';
			</script>
<?php
			//ademas salgo de este script
			exit();
		};
	};
	if (!isset($_SESSION["logged"]) or !$_SESSION["logged"]){
		//si no existe, envio a la pagina de autentificacion
		session_destroy();
?>
		<script>
		location='index.php';
		alert('Imposible iniciar sesion');
	</script>
<?php
		//ademas salgo de este script 
		exit(); 
	};

?>
