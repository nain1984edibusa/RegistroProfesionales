<?php
// Transforma una cédula del formato nnnnnnnnnn al formato nnnnnnnnn-n
function transformar_cedula1($cedula)
{
	$ret = substr($cedula, 0, 9);
	$ret = $ret . '-' . substr($cedula, 9, 1);
	return $ret;
}

// Transforma una cédula del formato nnnnnnnnn-n al formato nnnnnnnnnn
function transformar_cedula2($cedula)
{
	$ret = str_replace("-","",$cedula);
	return $ret;
}
?>