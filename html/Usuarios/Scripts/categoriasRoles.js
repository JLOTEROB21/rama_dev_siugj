function agregar()
{
	gE('frmEnvio').submit();	
}

function modificar(id)
{
	gE('categoria').value=id;
	gE('frmEnvio').submit();	
}


function eliminarRol(id,tabla)
{
	function respPregunta(btn)
	{
		if(btn=='yes')
		{
			function funcAjax()
			{
				var resp=peticion_http.responseText;
				arrResp=resp.split('|');
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
			obtenerDatosWeb('../paginasFunciones/funcionesUsuarios.php',funcAjax, 'POST','funcion=14&id='+id,true)
		}
	}
	Ext.MessageBox.confirm(lblAplicacion,'Est&aacute; seguro de querer eliminar este registro',respPregunta);
	
}

