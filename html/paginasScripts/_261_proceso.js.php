<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>
var msgEspere;
var primeraCargaFrame=true;
function obtenerAcuseRadicacion()
{
	primeraCargaFrame=false;
	var idRegistroAux=gE('idRegistroAux').value;
    var arrParametros=[['idRegistro',idRegistroAux]]
    enviarFormularioDatos('../modulosEspeciales_SGJ/generarAcuseRadicacion.php',arrParametros,'POST','frameDTD');
   
    
}


function frameLoad(iFrame)
{
	if(!primeraCargaFrame)
    {
    	setTimeout(function()
        			{
						
                        iFrame.contentWindow.print();
                    },2000
                   );

    }
    else
    	primeraCargaFrame=false;
	
}

