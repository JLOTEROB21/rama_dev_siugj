<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>
var msgEspere;
var primeraCargaFrame=true;
function obtenerAcuseExhorto()
{
	//mostrarVentanaEspereExhorto();
	var idRegistroAux=gE('idRegistroAux').value;
    var arrParametros=[['idRegistro',idRegistroAux]]
    enviarFormularioDatos('../modulosEspeciales_SGJP/generarAcuseExhortoV2.php',arrParametros,'POST','frameDTD');
    primeraCargaFrame=false;
    
}


function frameLoad(iFrame)
{
	if(!primeraCargaFrame)
    {
    	setTimeout(function()
        			{
                        //ocultarMensajeEspereExhorto();
                        iFrame.contentWindow.print();
                    },2000
                   );

    }
    else
    	primeraCargaFrame=false;
	
}


function mostrarVentanaEspereExhorto()
{
	try
	{
		msgEspere=Ext.MessageBox.wait('Espere por favor...',lblAplicacion)
	}
	catch(err)
	{
		
	}
}

function ocultarMensajeEspereExhorto()
{
	try
	{
		msgEspere.hide()
	}
	catch(err)
	{
		
	}
}