<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>	
var validado=false;


var cadenaFuncionValidacion='funcionPrepararGuardado';

function funcionPrepararGuardado()
{
	if(validado)
    	return true;
        
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            if(arrResp[1]=='')
            {
            	validado=true;
                validarFrm('frmEnvio')
            }
            else
            {	
	            msgBox(arrResp[1]);
            }
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=169',true);
    
	return false;
}