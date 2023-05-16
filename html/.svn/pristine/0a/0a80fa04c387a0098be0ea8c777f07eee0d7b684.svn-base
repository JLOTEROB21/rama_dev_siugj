<?php session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>

function enviarVista(p)
{
	var cPagina=gE('cPagina').value;
    var arrDatos;
    if(cPagina.indexOf('sFrm')!=-1)
		arrDatos=[['param',p],['cPagina','sFrm=true|mR1=true']];
    else
    	arrDatos=[['param',p]];
    enviarFormularioDatos('../modeloProyectos/registrosEtapa.php',arrDatos);
}


