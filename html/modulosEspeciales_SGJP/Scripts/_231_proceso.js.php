<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>
var msgEspere;
var primeraCargaFrame=true;
function obtenerDocumentoAccesoVideoGrabacion()
{
	mostrarMensajeEspereAccesoVG();
	var idRegistroAux=gE('idRegistroAux').value;
    var arrParametros=[['idRegistro',idRegistroAux],['idFormulario',gE('idFormularioAux').value]]
    enviarFormularioDatos('../modulosEspeciales_SGJP/generarAccesoVideoGrabacion.php',arrParametros,'POST','frameDTD');
    
}


function frameLoadPersonalizado(iFrame)
{
	if(!primeraCargaFrame)
    {
    	setTimeout(function()
        			{

                        ocultarMensajeEspereAccesoVG();

                        iFrame.contentWindow.print();
                    },2000
                   );

    }
    else
    	primeraCargaFrame=false;
	
}


function mostrarMensajeEspereAccesoVG()
{
	try
	{
		msgEspere=Ext.MessageBox.wait('Espere por favor...',lblAplicacion)
	}
	catch(err)
	{
		
	}
}

function ocultarMensajeEspereAccesoVG()
{
	try
	{
		msgEspere.hide()
	}
	catch(err)
	{
		alert(err);
	}
}