<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>

var primeraCargaFrame=true;
function obtenerAcuseInscripcion()
{
	var idRegistroAux=gE('idRegistroAux').value;
    var arrParametros=[['idRegistro',idRegistroAux]]
    enviarFormularioDatos('../modulosEspeciales_EstudiosJudiciales/generarAcuseInscripcionAlumno.php',arrParametros,'POST','frameDTD');
    
}


function frameLoad(iFrame)
{
	if(!primeraCargaFrame)
    {
    	iFrame.contentWindow.print();
    }
    else
    	primeraCargaFrame=false;
	
}