<?php

// obtener los valores de los siguientes par�metros de la tabla jerarquia
// en la base de datos PERSONAL del Sistema de Administraci�n de Recursos Humanos (SARH).

// PAR�METROS GENERALES
// define quienes son considerados adminsitrativos para el Sistema de Evaluaci�n Institucional (SEI)
$grupo_administrativos = "10, 30, 40, 50, 60";
// define quienes son considerados empleados para el Sistema de Evaluaci�n Institucional (SEI)
$grupo_empleados = "70";

// PAR�METROS DE CONEXION DE ESTE WEB SERVICE HACIA MySQL, BASE DE DATOS PERSONAL.
// Debe existir un usurio en MySQL con permisos de selecci�n y con las siguientes credenciales:
// estas son las lineas q tengo q cambiar
$nombre_usuario = "WS_SARH";
$contrasena = "webServiceSARH";
// estas son las lineas q tengo q cambiar
// Host y Base de datos del SARH
$nombre_host_SARH = "localhost";
$nombre_bd_SARH = "PERSONAL";

//VITACORA (Registro de Mensajes SOAP)
$log_enabled = false; //deshabilitar registro de mensajes SOAP

//NAMESPACE DEL SERVICIO (se sugiere no modificar)
// en caso de modificaci�n se necesitar� regenerar los proxies de los clientes del Web Service
$namespace = "http://sarh.espoch.edu.ec/";

?>
