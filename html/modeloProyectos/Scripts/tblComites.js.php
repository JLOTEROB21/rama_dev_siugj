<?php
session_start();
include("configurarIdiomaJS.php");
include("conexionBD.php");
//include("funcionesComunescentrogeoE.php");
?>

function ejecutarAccion(accion,idSeccion)
{
	switch(accion)
	{
		case '-1':
			eliminarSeccion(idSeccion);
		break;
		case '0':
			var form=gE('frmEnvio');
			gE('idComite').value=idSeccion;
			gE('ficha').value=1;
			form.action='comites.php';
			form.submit();
		break;
		case '1':
			var form=gE('frmEnvio');
			gE('idComite').value=idSeccion;
			gE('ficha').value=0;
			form.action='comites.php';
			form.submit();
		break;
		case 2:
			var form=gE('frmEnvio');
			gE('idComite').value='-1';
			gE('ficha').value=0;
			form.action='comites.php';
			form.submit();
		break;
			
	}
}

function eliminarSeccion(idComite)
{
	function funcRespuesta(btn)
	{
		if(btn=='yes')
		{
			function funcAjax()
			{
				var resp=peticion_http.responseText;
				if((resp=='1')||(resp==1))
				{
					var fila=gE('fila_'+idComite);
                    fila.parentNode.removeChild(fila);
				}
				else
				{
					msgBox('<?php echo $etj["msgError2"]?>'+' <br />'+resp);
				}
			}
			obtenerDatosWeb("../paginasFunciones/funcionesRevistaE.php",funcAjax,'POST','funcion=62&idSeccion='+idComite,true);
		}
	}
	
	Ext.MessageBox.confirm('<?php echo $etj["lblAplicacion"]?>','<?php echo $etj["lblConDelSec"]?>',funcRespuesta);
}

function verProcesosAsociados(idComite)
{
	var arrParam=[['idComite',idComite]];
    enviarFormularioDatos('../modeloProyectos/procesosAsocComite.php',arrParam);
}
