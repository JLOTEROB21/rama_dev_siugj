<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>

var primeraCargaFrame=true;
function obtenerAcuseAudienciaJuez()
{
	var idRegistroAux=gE('idRegistroAux').value;
    var idFormulario=gE('idFormularioAux').value;
    var arrParametros=[['tipoOficio',1],['idRegistro',idRegistroAux],['idFormulario',idFormulario]];
    
    enviarDatosFormularioIframe('../modulosEspeciales_SGJP/generarDocumentosOficios.php',arrParametros,'POST');
}


function obtenerFormatoAudienciaProgramada()
{
	var idRegistroAux=gE('idRegistroAux').value;
    var idFormulario=gE('idFormularioAux').value;
    var arrParametros=[['tipoOficio',2],['idRegistro',idRegistroAux],['idFormulario',idFormulario]];
   
    enviarDatosFormularioIframe('../modulosEspeciales_SGJP/generarDocumentosOficios.php',arrParametros,'POST');
}

function frameLoad(iFrame)
{
	if(!primeraCargaFrame)
    {
    	setTimeout(
                        function()
                        {
                            iFrame.contentWindow.print()
                        }, 10
                   );
    	
        
    }
    else
    	primeraCargaFrame=false;
	
}


function enviarDatosFormularioIframe(url,param,method)
{
	var iFrame=gE('frameEnvio');
    if(iFrame)
    {
    	iFrame.parentNode.removeChild(iFrame);
    }
    
    primeraCargaFrame=false;
    iFrame=cE('iFrame');
    iFrame.name='frameEnvio';
    iFrame.id='frameEnvio';
    iFrame.style='width:1px; height:1px;';
    document.body.appendChild(iFrame);
    asignarEvento(iFrame,'load',frameLoad);
    enviarFormularioDatos(url,param,method,'frameDTD');
        
    
}