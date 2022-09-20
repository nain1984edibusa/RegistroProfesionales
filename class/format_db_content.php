<?php
	$db_host = "localhost";  // Change as required
#	$db_user = "rpc-inpc-adm-app";  // Change as required
	$db_user = "c1regprof";  // Change as required
	$db_pass = "BL8Vt!4cMpb";  // Change as required
#	$db_name = "RpcInpcDB";	// Change as required
	$db_name = "c1regprof";	// Change as required

	//$dbcon = @mysql_connect($db_host,$db_user,$db_pass);  // mysql_connect() with variables defined at the start of Database class 
	try {
		$db=new PDO('mysql:host='.$db_host.';dbname='.$db_name.';',$db_user,$db_pass);
	} catch (PDOException $e) {
		echo 'Falló la conexión: ' . $e->getMessage();
	}

//----------------------------------------------------------------------------------------------------------------------------------
	function format_cont_db($field,$content)             //PARA CREAR COMBOS A PARTIR DE UNA TABLA
	{
		global 
			$db;
		$size="1";
		$aler=1;
		$formated='';
		switch($field){
			case 'ProfesionalGenero':
				switch ($content){
					case 'F':
						$formated='Femenino';
					break;
					case 'M':
						$formated='Masculino';
					break;
				};
			break;
			case 'PostulacioncCumpleInfoP':
			case 'PostulacionCumpleInfoA':
				switch ($content){
					case '0':
						$formated='No Cumple';
					break;
					case '1':
						$formated='Cumple';
					break;
					default:
						$formated='---';
					break;
				};
			break;
			case 'FAcademicaNivel':
				switch ($content){
					case '0':
						$formated='Nivel T&eacute;cnico o Tecnol&oacute;gico Superior';
					break;
					case '3':
						$formated='Tercer Nivel';
					break;
					case '4':
						$formated='Cuarto Nivel';
					break;
				};
			break;
			case 'PostulacionEstado':
				switch ($content){
					case '0':
						$formated='En proceso';
					break;
					case '1':
						$formated='Despachado';
					break;
				};
			break;
			case 'userEstado':
				switch ($content){
					case '0':
						$formated='Inhabilitado';
					break;
					case '1':
						$formated='Activo';
					break;
				};
			break;
			case 'PostulacionAsignado':
				switch ($content){
					case '0':
						$formated='Por Asignar Validador y Validar';
					break;
					case '1':
						$formated='Asignado y en Proceso de Validacion';
					break;
				};
			break;
			case 'PostulacionVerificado':
				switch ($content){
					case '0':
						$formated='Por Verificar';
					break;
					case '1':
						$formated='Verificado';
					break;
				};
			break;
			case 'PostulacionAprobado':
				switch ($content){
					case NULL:
						$formated='----';
					break;
					default:
						$formated=ucfirst($content);
					break;
				};
			break;
			case 'Tipousuario_idTipoUsuario':
			case 'idTipoUsuario':
				$sql = $db->query("SELECT TipoUsuarioTipo FROM TipoUsuario WHERE idTipoUsuario= ".$content." ");
				$tipo= $sql->fetch(PDO::FETCH_ASSOC);
				$formated=$tipo['TipoUsuarioTipo'];
			break;
			case 'TipoProfesionalId':
				$sql = $db->query("SELECT TipoProfesionalNombre FROM TipoProfesional WHERE TipoProfesionalId= ".$content." ");
				$tipo= $sql->fetch(PDO::FETCH_ASSOC);
				$formated=$tipo['TipoProfesionalNombre'];
			break;
			case 'idCiudadr':
				$sql = $db->query("SELECT CiudadrNombre FROM Ciudadr WHERE idCiudadr= ".$content." ");
				$tipo= $sql->fetch(PDO::FETCH_ASSOC);
				$formated=$tipo['CiudadrNombre'];
			break;
			case 'idPaisr':
				$sql = $db->query("SELECT PaisrNombre FROM Paisr WHERE idPaisr= '".$content."' ");
				$tipo= $sql->fetch(PDO::FETCH_ASSOC);
				$formated=$tipo['PaisrNombre'];
			break;
			case 'idNacionalidad':
				$sql = $db->query("SELECT NacionalidadNombre FROM Nacionalidad WHERE idNacionalidad= '".$content."' ");
				$tipo= $sql->fetch(PDO::FETCH_ASSOC);
				$formated=$tipo['NacionalidadNombre'];
			break;
			case 'username':
				$sql = $db->query("SELECT realname FROM user WHERE username= '".$content."' ");
				$tipo= $sql->fetch(PDO::FETCH_ASSOC);
				$formated=$tipo['realname'];
			break;
			case 'Profesional_idProfesional':
			case 'idProfesional':
				$sql = $db->query("SELECT concat(ProfesionalNombres,' ',ProfesionalApellidos) as nombresap FROM Profesional WHERE idProfesional= '".$content."' ");
				$tipo= $sql->fetch(PDO::FETCH_ASSOC);
				$formated=$tipo['nombresap'];
			break;
			default:
				$adic="";
				$where="";
			break;
        	};
	return utf8_decode(utf8_encode($formated));
	};
//----------------------------------------------------------------------------------------------------------------------------------

?>


