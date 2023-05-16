<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>


function mostrarVentanaRegistroCedulaIdentificacion(iR,fJ,iE,iU,d,a)
{
	var obj={};
    obj.ancho='100%';
    obj.alto='100%';
    obj.url='../modeloPerfiles/vistaDTDv3.php';
  	obj.params=[['idFormulario','225'],['idRegistro',iR],['figuraJuridica',fJ],['idEvento',iE],['idUsuario',iU],['dComp',d],['actor',a]];
    abrirVentanaFancy(obj);
    	
}

function mostrarVentanaRegistroProtocoloAudienica()
{
	var obj={};
    obj.ancho='100%';
    obj.alto='100%';
    obj.url='../modulosEspeciales_SGJP/tblProtocoloAudiencia.php';
  	obj.params=[['idEvento',gE('idEventoAudiencia').value],['cPagina','sFrm=true']];
    abrirVentanaFancy(obj);
}