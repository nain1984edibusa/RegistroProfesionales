<?php
// Method: POST, PUT, GET etc
function CallAPI($method, $url, $data = false){
	$curl = curl_init();		//INICIO SESION DE CURL
	switch ($method){
		case "POST":
		    curl_setopt($curl, CURLOPT_POST, 1);
		    if ($data)
		        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		    break;
		case "PUT":
		    curl_setopt($curl, CURLOPT_PUT, 1);
		    break;
		default:
		    if ($data)
		        $url = sprintf("%s?%s", $url, http_build_query($data));
	}
	curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);	//  Authentication:
	//    curl_setopt($curl, CURLOPT_USERPWD, "username:password");
	curl_setopt($curl, CURLOPT_USERPWD, "INPC:20r3gpr0f141nPc");
	curl_setopt($curl, CURLOPT_SSLVERSION,3);			//ESTABLECIMIENTO DE PARAMETROS DE PROTOCOLO HTPPS
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); 
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);			//ESTABLECIMIENTO DE PARAMETROS DE PROTOCOLO HTPPS 
	curl_setopt($curl, CURLOPT_HEADER, false); 			//PERMITE MOSTRAR ENCABEZADO DE RESPUESTA CON INFORMACION DEL SERVICIO
	curl_setopt($curl, CURLOPT_URL, $url);			//SETEA LA URL DE CONSULTA
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);			//INDICA QUE LA RESPUESTA SE RECIBE COMO UNA VARIABLE. NO SE VUELCA EN EL BROWSER

	$result = curl_exec($curl);			//EJECUTA URL DE CONSULTA Y ALMACENA LOS DATOS EN RESULT
	curl_close($curl);			//TERMINA LA SESION 
	return $result;
};
?>


