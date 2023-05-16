<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>

function mostrarOcultarEtapas(pr,co)
{
	var img=gE('imgEtapas_'+pr+'_'+co);
    if(img.title=='Ver registros por etapas')
    {
    	mE('tbl_'+pr+'_'+co);
        img.src='../images/verMenos.png';
        img.title='Ocultar registros por etapas';
        img.alt='Ocultar registros por etapas';
        
    }
    else
    {
    	oE('tbl_'+pr+'_'+co);
        img.src='../images/verMas.gif';
        img.title='Ver registros por etapas';
        img.alt='Ver registros por etapas';
    }
}

function enviarVista(p)
{
	var arrDatos=[['param',p],['cPagina','sFrm=true|mR1=true']];
    enviarFormularioDatos('../modeloProyectos/registrosComiteEtapa.php',arrDatos);
}