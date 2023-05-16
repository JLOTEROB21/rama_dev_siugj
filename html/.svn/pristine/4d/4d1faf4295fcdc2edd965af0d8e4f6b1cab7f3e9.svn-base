<?php
ini_set("session.cookie_lifetime","60");
ini_set("session.gc_maxlifetime","60");
session_start();

if(!isset($_SESSION["creado"]))
{
	echo "Se crea sesion";	
	$_SESSION["creado"]=1;
	$_SESSION["fechaCreacion"]=date("Y-m-d H:i:s");

}
else
{
	echo "existe sesion";	
}




?>