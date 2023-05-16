<?php session_start();
	include("conexionBD.php");
	include("configurarIdiomaJS.php");
?>
function crearNuevo()
{
	gE('frmEnvio').submit();
}

function modificarRegistro(id)
{
	gE('idRol').value=id;
	gE('frmEnvio').submit();
}

function eliminarRegistro(id)
{
	
	function funcRespSiNo(btn)
	{
		if(btn=='yes')
		{
			function funcResp()
			{
				var arrResp=peticion_http.responseText.split('|');
				if(arrResp[0]=='1')
				{
					var fila=gE('fila_'+id);
					fila.parentNode.removeChild(fila);
				}
				else
				{
					Ext.MessageBox.alert(lblAplicacion,'No se ha podido llevar a cabo la operaci&oacute;n debido al siguiente problema: <br>'+arrResp[0]);
				}
			}
			obtenerDatosWeb('../paginasFunciones/funcionesPortal.php',funcResp, 'POST','funcion=4&idRol='+id,true);
		}
	}
	Ext.MessageBox.confirm(lblAplicacion,'Est&aacute; seguro de querer eliminar el registro?',funcRespSiNo);

}