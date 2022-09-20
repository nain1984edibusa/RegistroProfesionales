<?php

	$file_prefix='cert-post-';  //PARA UBICAR Y MANEJAR ARCHIVOS SUBIDOS AL APP
	function exist_doc($id){
		$doc_dir=$_SERVER['DOCUMENT_ROOT'].'/storage/';
		if(file_exists($doc_dir.$id)){return TRUE;}else{return FALSE;}	
	}

?>
