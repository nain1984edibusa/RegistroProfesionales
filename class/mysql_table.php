<?php
	$db_host = "localhost";  // Change as required
#	$db_user = "rpc-inpc-adm-app";  // Change as required
	$db_user = "c1regprof";  // Change as required
#	$db_user = "root";
	$db_pass = "BL8Vt!4cMpb";  // Change as required
#	$db_pass = "root";
#	$db_name = "RpcInpcDB";	// Change as required
	$db_name = "c1regprof";	// Change as required


	//$dbcon = @mysql_connect($db_host,$db_user,$db_pass);  // mysql_connect() with variables defined at the start of Database class 
	try {
		$db=new PDO('mysql:host='.$db_host.';dbname='.$db_name.';',$db_user,$db_pass);
	} catch (PDOException $e) {
		echo 'Falló la conexión: ' . $e->getMessage();
	}

//----------------------------------------------------------------------------------------------------------------------------------
	function load_of_db($field,$content)             //PARA CREAR COMBOS A PARTIR DE UNA TABLA
	{
		global 
			$db,$wlayer;
		$size="1";
		$aler=1;
		$db_f_='';		
        	switch($field){
                case 'ftiprof':
                case 'TipoProfesionalId':
                    $tabla='TipoProfesional';
                    $db_f='TipoProfesionalNombre';
                    $sort=$db_f;
#                    if ($FILTRO=='all'){
#                        $where='';
#                    }else{
#                        $where="";
#                    };
                    $adic='TipoProfesionalId';
                break;
                case 'idTipoDocID':
                    $tabla='TipoDocID';
                    $db_f='TipoDocIDNombre';
                    $sort=$db_f;
                    $adic='idTipoDocID';
                    $size='1';
                break;
                case 'idNacionalidad':
                    $tabla='Nacionalidad';
                    $db_f='NacionalidadNombre';
                    $sort=$db_f;
                    $adic='idNacionalidad';
                    $size='1';
                break;
                case 'idPaisr':
                    $tabla='Paisr';
                    $db_f='PaisrNombre';
                    $sort=$db_f;
                    $adic='idPaisr';
                    $size='1';
                break;
                case 'idCiudadr':
                    $tabla='Ciudadr';
                    $db_f=" concat (CiudadrNombre,' (',Paisr_idPaisr,') ') as CiudadrNombre_";
                    $db_f_='CiudadrNombre_';
                    $sort= 'Paisr_idPaisr,CiudadrNombre';
                    $adic='idCiudadr';
                    $size='1';
                break;
                case 'ftus':
                case 'TipoUsuario_idTipoUsuario':
                    $tabla='TipoUsuario';
                    $db_f='TipoUsuarioTipo';
                    $sort='TipoUsuarioTipo';
                    $adic='idTipousuario';
                    $size="1";
                    $where="where idTipousuario <> 3";
                break;
                case 'Validador_Postulacion':
                    $tabla='user';
                    $db_f='realname';
                    $sort='realname';
                    $adic='username';
                    $where="where TipoUsuario_idTipoUsuario= 4 ";
                    $size="1";
                break;
                case "dependencia":
                        	$tabla="dependencia";
                        	$db_f="nombre";
                        	$adic="id_dep";
                break;
                case "donde_firma":
                        	$tabla="dependencia";
                        	$db_f="nombre";
                        	$adic="id_dep";
                break;
                case "n_digni":
                        	$tabla="dignidades";
                        	$db_f="nom_dig";
                        	$adic="cod_dig";
                break;
                case "bachiller":
                        	$tabla="TIT_ESP";
                        	$db_f="nombreTE";
                        	$adic="cod";
                            $where="WHERE tit_esp='t' and niv_est='s'";
                break;
                case "titulos":
                        	$tabla="TIT_ESP";
                        	$db_f="nombreTE";
                        	$adic="cod";
                        $where="WHERE tit_esp='e' and niv_est like '%s%'";
                break;
                case "grado4":
                        	$tabla="TIT_ESP";
                        	$db_f="nombreTE";
                        	$adic="cod";
                        $where="WHERE tit_esp='t' and niv_est='4'";
                break;
                case "nivel_v":
                        	$tabla="nivel_prof";
                        	$db_f="nivel_prof";
                        	$adic="nivel_prof";
                break;
                case "jerar":
                        	$tabla="jerarquia";
                        	$db_f="nom_jer";
                        	$adic="cod_jer";
                break;
                case "nom_cat":
                        	$tabla="categoria";
                        	$db_f="nom_cat";
                        	$adic="cod_cat";
                break;
                case "area":
                        	$tabla="asistencia";
                        	$db_f="area";
                        	$adic="area";
                        	$where="where id_dep='$dependencia'";
                break;
                case "unit_rota":
                        	$tabla="parametro";
                        	$db_f="nomb_p";
                            $adic="symbol";
                        	$where="where symbol like '%ROTIME%'";
                break;
                  case "IDNacionalidad":
                        	$tabla="NacionIndigena";
                        	$db_f="NombreNacionalidad";
                        $adic="IDNacionalidad";
                        	$where="";
                	break;
                default:
                    $adic="";
                    $where="";
                break;
        	};
            (!isset($where))?$where='':TRUE;
            ($db_f_=='')?$db_f_=$db_f:TRUE;
            $i=0;
?>
		<SELECT NAME="<?php echo $field;?>" size="<?php echo $size;?>"  <?php echo put_bgcolor();?>>
<?php
        $query = $db->query("SELECT $db_f,$adic FROM $tabla $where ORDER BY $sort");  
        	if ($query->rowCount()>0){
	        	while ($row = $query->fetch(PDO::FETCH_ASSOC)){
		       		if ($content==""){
						if ($i==0){
							$sel="selected";
							switch ($field){
								case 'ftus':
								case 'ftiprof':
								case "IdDiscapacidadF":
								$sel="";
?>
								<OPTION selected value=""></OPTION>
<?php
								break;
							};
							$i++;
						};
?>
						<OPTION <?php echo $sel;?> value="<?php echo $row[$adic];?>"><?php echo $row[$db_f_];?></OPTION>
<?php
						$sel="";
						$aler--;
//					};
                   }else{
							$sel="";
							if ($content==$row[$adic]){$sel="selected";};
?>
                        <OPTION <?php echo $sel;?> value="<?php echo $row[$adic];?>"><?php echo $row[$db_f];?></OPTION>
<?php
					$aler--;
                    };
                };
        	}else{
	        	$con=0;
	        	while ($con<=$query->rowCount()){
  	        	     $sel="";
   	        	     if ($content==mysql_result($res,$con,$adic)){$sel="selected";};
?>
    	        	    <OPTION <?php echo $sel?> value="<?php echo mysql_result($res,$con,$adic)?>"><?php echo mysql_result($res,$con,$db_f)?></OPTION>
<?php
    	        	    $con++;
                    $aler--;
                };
            };
?>
        	</SELECT>
<?php
	};
?>
