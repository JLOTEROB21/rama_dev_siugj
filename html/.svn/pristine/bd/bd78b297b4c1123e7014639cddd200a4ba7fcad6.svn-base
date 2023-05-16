<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>

function mostrarOcultarEtapas(pr)
{
	var img=gE('imgEtapas_'+pr);
    if(img.title=='Ver registros por etapas')
    {
    	mE('tbl_'+pr);
        img.src='../images/verMenos.png';
        img.title='Ocultar registros por etapas';
        img.alt='Ocultar registros por etapas';
        
    }
    else
    {
    	oE('tbl_'+pr);
        img.src='../images/verMas.gif';
        img.title='Ver registros por etapas';
        img.alt='Ver registros por etapas';
    }
}



function enviarVista(p)
{
	
	var arrDatos=[['param',p],['cPagina','sFrm=true|mR1=true']];
    enviarFormularioDatos('../modeloProyectos/registrosRevisorEtapa.php',arrDatos);
}