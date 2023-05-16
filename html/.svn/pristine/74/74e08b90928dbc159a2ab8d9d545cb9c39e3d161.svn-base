<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>	

function registrarNotificacionRealizada(fila)
{
	function funcAjax2(peticion_http)
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            
			recargarGridRegistros();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWebV2('../modulosEspeciales_SIUGJ/paginasFunciones/funcionesSIUGJ.php',funcAjax2, 'POST','funcion=8&iF='+fila.data.iFormulario+'&iR='+fila.data.iRegistro,false);

}