<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>


function agregarTipoProceso()
{
	gE('frmEnvio').submit();
}

function modificar(iT)
{
	gE('idTipoProceso').value=bD(iT);
	gE('frmEnvio').submit()
}

function eliminar(iC)
{
	function resp(btn)
    {
    	if(btn=='yes')
        {
        	function funcAjax()
            {
                var resp=peticion_http.responseText;
                arrResp=resp.split('|');
                if(arrResp[0]=='1')
                {
                	var fila=gE('fila_'+bD(iC));
                    fila.parentNode.removeChild(fila);
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=161&iC='+iC,true);
        }
    }
    msgConfirm('Est&aacute; seguro de querer eliminar la categor&iacute;a del proceso seleccionado?',resp)
}
