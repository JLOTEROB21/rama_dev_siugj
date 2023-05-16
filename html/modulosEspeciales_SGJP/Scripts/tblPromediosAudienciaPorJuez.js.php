<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	
	$arrTiposAudiencia=array();
	$arrTiposAudiencia[1]=1;
	$arrTiposAudiencia[15]=1;
	$arrTiposAudiencia[26]=1;
	$arrTiposAudiencia[18]=1;
	$arrTiposAudiencia[52]=1;
	$arrTiposAudiencia[31]=1;
	
	
	
?>


Ext.onReady(inicializar);

function inicializar()
{
	
}


function crearGridComputoTipoAudiencia()
{
	
}