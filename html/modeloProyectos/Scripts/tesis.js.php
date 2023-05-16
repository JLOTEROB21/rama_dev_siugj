<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>



function enviarVista(p)
{
	
	var arrDatos=[['param',p],['cPagina','sFrm=true|mR1=true']];
    enviarFormularioDatos('../modeloProyectos/tesisEtapa.php',arrDatos);
}