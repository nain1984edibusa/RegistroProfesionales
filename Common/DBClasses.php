<?php
require_once 'Common/Config.php';

class UtilidadBaseDeDatos
{
  var $conexion;
  
  function UtilidadBaseDeDatos()
  {
  }
  
  function Open()
  {
		$this->conexion = mysql_connect($GLOBALS['nombre_host_SARH'], $GLOBALS['nombre_usuario'], $GLOBALS['contrasena'])
		                    or die("Conexion fallida
		                            Error: " . mysql_error());
		mysql_select_db ($GLOBALS['nombre_bd_SARH'])
		  or die("No se puede seleccionar BD
		         Error: " . mysql_error());

  }
  function Close()
  {
		return mysql_close($this->conexion);
  }

  function ExecQuery($SQL)
  {
    $this->Open();
    $console = mysql_query("set old_passwords=0", $this->conexion)  or die("Operación inválida: $SQL<br>  Error: " . mysql_error());
    $result = mysql_query($SQL, $this->conexion)  or die("Operación inválida: $SQL<br>  Error: " . mysql_error());
	mysql_query ("SET NAMES 'utf8'");								  
    
    $this->Close();
    return $result;
  }

}


?>