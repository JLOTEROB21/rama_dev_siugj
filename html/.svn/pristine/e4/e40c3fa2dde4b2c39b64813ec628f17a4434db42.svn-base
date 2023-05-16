<?php session_start();
include("configurarIdiomaJS.php");
?>

function nuevo()
{
	gE('frmEnvio').submit();
}

function modificar(idElemento)
{
	
    gE('idFormulario').value=idElemento;
    gE('frmEnvio').submit();
}

function eliminar(idElemento)
{
	var obj='{"tabla":"900_formularios","nombreCampoId":"idFormulario","idRegistro":"'+idElemento+'"}';
    
    function respPregunta(btn)
	{
		if(btn=='yes')
		{
			function funcResp()
			{
				var arrResp=peticion_http.responseText.split('|');
				if(arrResp[0]=='1')
				{
                	var filaDel=gE('fila_'+idElemento);
                    filaDel.parentNode.removeChild(filaDel);
                    
				}
				else
				{
					 msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);				}
			}
			obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcResp, 'POST','funcion=10&param='+obj,true);
		}
	}
	Ext.MessageBox.confirm('<?php echo $etj["lblAplicacion"] ?>','<?php echo $etj["msgConfirmDel"] ?>',respPregunta);
}