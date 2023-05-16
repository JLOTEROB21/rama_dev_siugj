function Mostrar()
{
	var sol=gE('chkSolicitud');
	if(sol.checked)
	{
		mE('Solicitud');
		mE('Aceptar');
		gE('Solicitud').focus();
	}
	else
	{
		oE('Solicitud');
		oE('Aceptar');
	}
}


function solicitudDatos(IdAlumno,IdPersona)
{
	var Solicitud=gE('Solicitud');
	if(Solicitud.value.trim()=='')
	{
		function funcOK()
		{
			Solicitud.focus();
		}
		Ext.MessageBox.alert(lblAplicacion,'Por favor llene la solicitud',funcOK);
		return;
	}
	function funcTratarRespuesta()
	{
		var resp=peticion_http.responseText;
		if(resp=='1' || resp==1)
		{
			function miFuncion()
			{
				parent.parent.GB_hide();
			}
			Ext.MessageBox.alert(lblAplicacion,'Su solicitud ha sido enviada',miFuncion);
		}
		else
		{
			Ext.MessageBox.alert(lblAplicacion,'Ha ocurrido un problema con el servidor y la operación no ha podido llevarse a cabo');
		}
		
	}
obtenerDatosWeb('../paginasFunciones/procesarSolicitudDatos.php',funcTratarRespuesta, 'POST','funcion=1&IdAlumno='+IdAlumno+'&IdPersona='+IdPersona+'&Solicitud='+Solicitud.value);
}