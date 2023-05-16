<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>
function modificar(c,a)
{
	var arrDatos;
	if(bD(a)=='1')
    {
    	arrDatos=[['ciclo',c]];
        enviarFormularioDatos('../nomina/fechasNomina.php',arrDatos);        
    }
    else
	{
    	function funcAjax()
        {
            var resp=peticion_http.responseText;
            arrResp=resp.split('|');
            if(arrResp[0]=='1')
            {
            	arrDatos=[['ciclo',c]];
		        enviarFormularioDatos('../nomina/fechasNomina.php',arrDatos);        
            }
            else
            {
                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
            }
        }
        obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=150&ciclo='+c,true);
    }
	
}

function modificar2(c,a)
{
	var arrDatos;
	if(bD(a)=='1')
    {
    	arrDatos=[['ciclo',c]];
        enviarFormularioDatos('../nomina/fechasVacaciones.php',arrDatos);        
    }
    else
	{
    	function funcAjax()
        {
            var resp=peticion_http.responseText;
            arrResp=resp.split('|');
            if(arrResp[0]=='1')
            {
            	arrDatos=[['ciclo',c]];
		        enviarFormularioDatos('../nomina/fechasVacaciones.php',arrDatos);        
            }
            else
            {
                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
            }
        }
        obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=150&ciclo='+c,true);
    }
	
}