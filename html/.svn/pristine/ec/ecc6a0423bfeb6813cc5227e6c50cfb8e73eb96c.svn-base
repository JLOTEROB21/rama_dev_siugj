function ejecutarAccionProceso(id,accion)
{
	switch(accion)
	{
		case '-1':
			eliminarRegistro(id);
		break;
		case '1':
			gE('idProceso').value=id;
			gE('frmEnvio').submit();
		break;
		case '2':
			gE('idProceso').value='-1';
			gE('frmEnvio').submit();
		break;
	}
}


function eliminarRegistro(id,tabla)
{
	function respPregunta(btn)
	{
		if(btn=='yes')
		{
			function funcAjax()
			{
				var resp=peticion_http.responseText;
				if(resp=='1')
				{
					var fila=gE('fila_'+id);
                    fila.parentNode.removeChild(fila);
				}
				else
				{
					Ext.MessageBox.alert(lblAplicacion,'No se ha podido llevar a cabo la operaci&oacute;n debido al siguiente problema: <br>'+resp);
				}
			}
			obtenerDatosWeb('../paginasFunciones/funcionesAdministracion.php',funcAjax, 'POST','funcion=1&id='+id,true)
		}
	}
	Ext.MessageBox.confirm(lblAplicacion,'Est&aacute; seguro de querer eliminar este registro',respPregunta);
	
}

function ejecutarAccionNivel(id,accion)
{
	switch(accion)
	{
		case '-1':
			eliminarNivel(id);
		break;
		case '1':
			gE('idNivel').value=id;
			gE('frmEnvio').submit();
		break;
		case '2':
			gE('idNivel').value='-1';
			gE('frmEnvio').submit();
		break;
	}
}


function eliminarNivel(id,tabla)
{
	function respPregunta(btn)
	{
		if(btn=='yes')
		{
			function funcAjax()
			{
				var resp=peticion_http.responseText;
				if(resp=='1')
				{
					location.reload();
				}
				else
				{
					Ext.MessageBox.alert(lblAplicacion,'No se ha podido llevar a cabo la operaci&oacute;n debido al siguiente problema: <br>'+resp);
				}
			}
			obtenerDatosWeb('../paginasFunciones/funcionesAdministracion.php',funcAjax, 'POST','funcion=2&id='+id,true)
		}
	}
	Ext.MessageBox.confirm(lblAplicacion,'Est&aacute; seguro de querer eliminar este registro',respPregunta);
	
}


function ejecutarAccionPrograma(id,accion)
{
	switch(accion)
	{
		case '-1':
			eliminarPrograma(id);
		break;
		case '1':
			gE('idPrograma').value=id;
			gE('frmEnvio').submit();
		break;
		case '2':
			gE('idPrograma').value='-1';
			gE('frmEnvio').submit();
		break;
	}
}


function eliminarPrograma(id,tabla)
{
	function respPregunta(btn)
	{
		if(btn=='yes')
		{
			function funcAjax()
			{
				var resp=peticion_http.responseText;
				if(resp=='1')
				{
					location.reload();
				}
				else
				{
					Ext.MessageBox.alert(lblAplicacion,'No se ha podido llevar a cabo la operaci&oacute;n debido al siguiente problema: <br>'+resp);
				}
			}
			obtenerDatosWeb('../paginasFunciones/funcionesAdministracion.php',funcAjax, 'POST','funcion=3&id='+id,true)
		}
	}
	Ext.MessageBox.confirm(lblAplicacion,'Est&aacute; seguro de querer eliminar este registro',respPregunta);
	
}

function ejecutarAccionHabilidad(id,accion)
{
	switch(accion)
	{
		case '-1':
			eliminarHabilidad(id);
		break;
		case '1':
			gE('idHabilidad').value=id;
			gE('frmEnvio').submit();
		break;
		case '2':
			gE('idHabilidad').value='-1';
			gE('frmEnvio').submit();
		break;
	}
}


function eliminarHabilidad(id,tabla)
{
	function respPregunta(btn)
	{
		if(btn=='yes')
		{
			function funcAjax()
			{
				var resp=peticion_http.responseText;
				if(resp=='1')
				{
					location.reload();
				}
				else
				{
					Ext.MessageBox.alert(lblAplicacion,'No se ha podido llevar a cabo la operaci&oacute;n debido al siguiente problema: <br>'+resp);
				}
			}
			obtenerDatosWeb('../paginasFunciones/funcionesAdministracion.php',funcAjax, 'POST','funcion=4&id='+id,true)
		}
	}
	Ext.MessageBox.confirm(lblAplicacion,'Est&aacute; seguro de querer eliminar este registro',respPregunta);
	
}

function ejecutarAccionCompetencia(id,accion)
{
	switch(accion)
	{
		case '-1':
			eliminarCompetencia(id);
		break;
		case '1':
			gE('idCompetencia').value=id;
			gE('frmEnvio').submit();
		break;
		case '2':
			gE('idCompetencia').value='-1';
			gE('frmEnvio').submit();
		break;
	}
}


function eliminarCompetencia(id,tabla)
{
	function respPregunta(btn)
	{
		if(btn=='yes')
		{
			function funcAjax()
			{
				var resp=peticion_http.responseText;
				if(resp=='1')
				{
					location.reload();
				}
				else
				{
					Ext.MessageBox.alert(lblAplicacion,'No se ha podido llevar a cabo la operaci&oacute;n debido al siguiente problema: <br>'+resp);
				}
			}
			obtenerDatosWeb('../paginasFunciones/funcionesAdministracion.php',funcAjax, 'POST','funcion=5&id='+id,true)
		}
	}
	Ext.MessageBox.confirm(lblAplicacion,'Est&aacute; seguro de querer eliminar este registro',respPregunta);
	
}

function ejecutarAccionActitud(id,accion)
{
	switch(accion)
	{
		case '-1':
			eliminarActitud(id);
		break;
		case '1':
			gE('idActitud').value=id;
			gE('frmEnvio').submit();
		break;
		case '2':
			gE('idActitud').value='-1';
			gE('frmEnvio').submit();
		break;
	}
}


function eliminarActitud(id,tabla)
{
	function respPregunta(btn)
	{
		if(btn=='yes')
		{
			function funcAjax()
			{
				var resp=peticion_http.responseText;
				if(resp=='1')
				{
					location.reload();
				}
				else
				{
					Ext.MessageBox.alert(lblAplicacion,'No se ha podido llevar a cabo la operaci&oacute;n debido al siguiente problema: <br>'+resp);
				}
			}
			obtenerDatosWeb('../paginasFunciones/funcionesAdministracion.php',funcAjax, 'POST','funcion=6&id='+id,true)
		}
	}
	Ext.MessageBox.confirm(lblAplicacion,'Est&aacute; seguro de querer eliminar este registro',respPregunta);
	
}

function ejecutarAccionRecurso(id,accion)
{
	switch(accion)
	{
		case '-1':
			eliminarRecurso(id);
		break;
		case '1':
			gE('idRecurso').value=id;
			gE('frmEnvio').submit();
		break;
		case '2':
			gE('idRecurso').value='-1';
			gE('frmEnvio').submit();
		break;
	}
}


function eliminarRecurso(id,tabla)
{
	function respPregunta(btn)
	{
		if(btn=='yes')
		{
			function funcAjax()
			{
				var resp=peticion_http.responseText;
				if(resp=='1')
				{
					location.reload();
				}
				else
				{
					Ext.MessageBox.alert(lblAplicacion,'No se ha podido llevar a cabo la operaci&oacute;n debido al siguiente problema: <br>'+resp);
				}
			}
			obtenerDatosWeb('../paginasFunciones/funcionesAdministracion.php',funcAjax, 'POST','funcion=7&id='+id,true)
		}
	}
	Ext.MessageBox.confirm(lblAplicacion,'Est&aacute; seguro de querer eliminar este registro',respPregunta);
	
}

function ejecutarAccionEvaluacion(id,accion)
{
	switch(accion)
	{
		case '-1':
			eliminarEvaluacion(id);
		break;
		case '1':
			gE('idEvaluacion').value=id;
			gE('frmEnvio').submit();
		break;
		case '2':
			gE('idEvaluacion').value='-1';
			gE('frmEnvio').submit();
		break;
	}
}


function eliminarEvaluacion(id,tabla)
{
	function respPregunta(btn)
	{
		if(btn=='yes')
		{
			function funcAjax()
			{
				var resp=peticion_http.responseText;
				if(resp=='1')
				{
					location.reload();
				}
				else
				{
					Ext.MessageBox.alert(lblAplicacion,'No se ha podido llevar a cabo la operaci&oacute;n debido al siguiente problema: <br>'+resp);
				}
			}
			obtenerDatosWeb('../paginasFunciones/funcionesAdministracion.php',funcAjax, 'POST','funcion=8&id='+id,true)
		}
	}
	Ext.MessageBox.confirm(lblAplicacion,'Est&aacute; seguro de querer eliminar este registro',respPregunta);
	
}

function ejecutarAccionTecnicaColaborativa(id,accion)
{
	switch(accion)
	{
		case '-1':
			eliminarTecnicaColaborativa(id);
		break;
		case '1':
			gE('idTecnicaC').value=id;
			gE('frmEnvio').submit();
		break;
		case '2':
			gE('idTecnicaC').value='-1';
			gE('frmEnvio').submit();
		break;
	}
}


function eliminarTecnicaColaborativa(id,tabla)
{
	function respPregunta(btn)
	{
		if(btn=='yes')
		{
			function funcAjax()
			{
				var resp=peticion_http.responseText;
				if(resp=='1')
				{
					location.reload();
				}
				else
				{
					Ext.MessageBox.alert(lblAplicacion,'No se ha podido llevar a cabo la operaci&oacute;n debido al siguiente problema: <br>'+resp);
				}
			}
			obtenerDatosWeb('../paginasFunciones/funcionesAdministracion.php',funcAjax, 'POST','funcion=9&id='+id,true)
		}
	}
	Ext.MessageBox.confirm(lblAplicacion,'Est&aacute; seguro de querer eliminar este registro',respPregunta);
	
}

function ejecutarAccionProducto(id,accion)
{
	switch(accion)
	{
		case '-1':
			eliminarProducto(id);
		break;
		case '1':
			gE('idProducto').value=id;
			gE('frmEnvio').submit();
		break;
		case '2':
			gE('idProducto').value='-1';
			gE('frmEnvio').submit();
		break;
	}
}


function eliminarProducto(id,tabla)
{
	function respPregunta(btn)
	{
		if(btn=='yes')
		{
			function funcAjax()
			{
				var resp=peticion_http.responseText;
				if(resp=='1')
				{
					location.reload();
				}
				else
				{
					Ext.MessageBox.alert(lblAplicacion,'No se ha podido llevar a cabo la operaci&oacute;n debido al siguiente problema: <br>'+resp);
				}
			}
			obtenerDatosWeb('../paginasFunciones/funcionesAdministracion.php',funcAjax, 'POST','funcion=10&id='+id,true)
		}
	}
	Ext.MessageBox.confirm(lblAplicacion,'Est&aacute; seguro de querer eliminar este registro',respPregunta);
	
}

function ejecutarAccionMateria(id,accion)
{
	switch(accion)
	{
		case '-1':
			eliminarMateria(id);
		break;
		case '1':
			gE('idMateria').value=id;
			gE('frmEnvio').submit();
		break;
		case '2':
			gE('idMateria').value='-1';
			gE('frmEnvio').submit();
		break;
	}
}


function eliminarMateria(id,tabla)
{
	function respPregunta(btn)
	{
		if(btn=='yes')
		{
			function funcAjax()
			{
				var resp=peticion_http.responseText;
				if(resp=='1')
				{
					location.reload();
				}
				else
				{
					Ext.MessageBox.alert(lblAplicacion,'No se ha podido llevar a cabo la operaci&oacute;n debido al siguiente problema: <br>'+resp);
				}
			}
			obtenerDatosWeb('../paginasFunciones/funcionesAdministracion.php',funcAjax, 'POST','funcion=11&id='+id,true)
		}
	}
	Ext.MessageBox.confirm(lblAplicacion,'Est&aacute; seguro de querer eliminar este registro',respPregunta);
	
}

function ejecutarAccionGrado(id,accion)
{
	switch(accion)
	{
		case '-1':
			eliminarGrado(id);
		break;
		case '1':
			gE('idGrado').value=id;
			gE('frmEnvio').submit();
		break;
		case '2':
			gE('idGrado').value='-1';
			gE('frmEnvio').submit();
		break;
	}
}


function eliminarGrado(id,tabla)
{
	function respPregunta(btn)
	{
		if(btn=='yes')
		{
			function funcAjax()
			{
				var resp=peticion_http.responseText;
				if(resp=='1')
				{
					location.reload();
				}
				else
				{
					Ext.MessageBox.alert(lblAplicacion,'No se ha podido llevar a cabo la operaci&oacute;n debido al siguiente problema: <br>'+resp);
				}
			}
			obtenerDatosWeb('../paginasFunciones/funcionesAdministracion.php',funcAjax, 'POST','funcion=12&id='+id,true)
		}
	}
	Ext.MessageBox.confirm(lblAplicacion,'Est&aacute; seguro de querer eliminar este registro',respPregunta);
	
}

function ejecutarAccionCiclo(id,accion)
{
	switch(accion)
	{
		case '-1':
			eliminarCiclo(id);
		break;
		case '1':
			gE('idCiclo').value=id;
			gE('frmEnvio').submit();
		break;
		case '2':
			gE('idCiclo').value='-1';
			gE('frmEnvio').submit();
		break;
	}
}


function eliminarCiclo(id,tabla)
{
	function respPregunta(btn)
	{
		if(btn=='yes')
		{
			function funcAjax()
			{
				var resp=peticion_http.responseText;
				if(resp=='1')
				{
					location.reload();
				}
				else
				{
					Ext.MessageBox.alert(lblAplicacion,'No se ha podido llevar a cabo la operaci&oacute;n debido al siguiente problema: <br>'+resp);
				}
			}
			obtenerDatosWeb('../paginasFunciones/funcionesAdministracion.php',funcAjax, 'POST','funcion=13&id='+id,true)
		}
	}
	Ext.MessageBox.confirm(lblAplicacion,'Est&aacute; seguro de querer eliminar este registro',respPregunta);
	
}

function ejecutarAccionDocumento(id,accion)
{
	switch(accion)
	{
		case '-1':
			eliminarDocumento(id);
		break;
		case '1':
			gE('idDocumento').value=id;
			gE('frmEnvio').submit();
		break;
		case '2':
			gE('idDocumento').value='-1';
			gE('frmEnvio').submit();
		break;
	}
}


function eliminarDocumento(id,tabla)
{
	function respPregunta(btn)
	{
		if(btn=='yes')
		{
			function funcAjax()
			{
				var resp=peticion_http.responseText;
				if(resp=='1')
				{
					location.reload();
				}
				else
				{
					Ext.MessageBox.alert(lblAplicacion,'No se ha podido llevar a cabo la operaci&oacute;n debido al siguiente problema: <br>'+resp);
				}
			}
			obtenerDatosWeb('../paginasFunciones/funcionesAdministracion.php',funcAjax, 'POST','funcion=14&id='+id,true)
		}
	}
	Ext.MessageBox.confirm(lblAplicacion,'Est&aacute; seguro de querer eliminar este registro',respPregunta);
	
}

function ejecutarAccionUnidadMedida(id,accion)
{
	switch(accion)
	{
		case '-1':
			eliminarUnidadMedida(id);
		break;
		case '1':
			gE('idUnidadMedida').value=id;
			gE('frmEnvio').submit();
		break;
		case '2':
			gE('idUnidadMedida').value='-1';
			gE('frmEnvio').submit();
		break;
	}
}


function eliminarUnidadMedida(id,tabla)
{
	function respPregunta(btn)
	{
		if(btn=='yes')
		{
			function funcAjax()
			{
				var resp=peticion_http.responseText;
				if(resp=='1')
				{
					location.reload();
				}
				else
				{
					Ext.MessageBox.alert(lblAplicacion,'No se ha podido llevar a cabo la operaci&oacute;n debido al siguiente problema: <br>'+resp);
				}
			}
			obtenerDatosWeb('../paginasFunciones/funcionesAdministracion.php',funcAjax, 'POST','funcion=15&id='+id,true)
		}
	}
	Ext.MessageBox.confirm(lblAplicacion,'Est&aacute; seguro de querer eliminar este registro',respPregunta);
	
}

function ejecutarAccionPeriodo(id,accion)
{
	switch(accion)
	{
		case '-1':
			eliminarPeriodo(id);
		break;
		case '1':
			gE('idPeriodo').value=id;
			gE('frmEnvio').submit();
		break;
		case '2':
			gE('idPeriodo').value='-1';
			gE('frmEnvio').submit();
		break;
	}
}


function eliminarPeriodo(id,tabla)
{
	function respPregunta(btn)
	{
		if(btn=='yes')
		{
			function funcAjax()
			{
				var resp=peticion_http.responseText;
				if(resp=='1')
				{
					location.reload();
				}
				else
				{
					Ext.MessageBox.alert(lblAplicacion,'No se ha podido llevar a cabo la operaci&oacute;n debido al siguiente problema: <br>'+resp);
				}
			}
			obtenerDatosWeb('../paginasFunciones/funcionesAdministracion.php',funcAjax, 'POST','funcion=16&id='+id,true)
		}
	}
	Ext.MessageBox.confirm(lblAplicacion,'Est&aacute; seguro de querer eliminar este registro',respPregunta);
	
}


function ejecutarAccionAreaConcentracion(id,accion)
{
	switch(accion)
	{
		case '-1':
			eliminarAreaConcentracion(id);
		break;
		case '1':
			gE('idAreaConcentracion').value=id;
			gE('frmEnvio').submit();
		break;
		case '2':
			gE('idAreaConcentracion').value='-1';
			gE('frmEnvio').submit();
		break;
	}
}


function eliminarAreaConcentracion(id,tabla)
{
	function respPregunta(btn)
	{
		if(btn=='yes')
		{
			function funcAjax()
			{
				var resp=peticion_http.responseText;
				if(resp=='1')
				{
					location.reload();
				}
				else
				{
					Ext.MessageBox.alert(lblAplicacion,'No se ha podido llevar a cabo la operaci&oacute;n debido al siguiente problema: <br>'+resp);
				}
			}
			obtenerDatosWeb('../paginasFunciones/funcionesAdministracion.php',funcAjax, 'POST','funcion=17&id='+id,true)
		}
	}
	Ext.MessageBox.confirm(lblAplicacion,'Est&aacute; seguro de querer eliminar este registro',respPregunta);
	
}

function ejecutarAccionIdioma(id,accion)
{
	switch(accion)
	{
		case '-1':
			eliminarIdiomaMateria(id);
		break;
		case '1':
			gE('idIdiomaMateria').value=id;
			gE('frmEnvio').submit();
		break;
		case '2':
			gE('idIdiomaMateria').value='-1';
			gE('frmEnvio').submit();
		break;
	}
}


function eliminarIdiomaMateria(id,tabla)
{
	function respPregunta(btn)
	{
		if(btn=='yes')
		{
			function funcAjax()
			{
				var resp=peticion_http.responseText;
				if(resp=='1')
				{
					location.reload();
				}
				else
				{
					Ext.MessageBox.alert(lblAplicacion,'No se ha podido llevar a cabo la operaci&oacute;n debido al siguiente problema: <br>'+resp);
				}
			}
			obtenerDatosWeb('../paginasFunciones/funcionesAdministracion.php',funcAjax, 'POST','funcion=18&id='+id,true)
		}
	}
	Ext.MessageBox.confirm(lblAplicacion,'Est&aacute; seguro de querer eliminar este registro',respPregunta);
	
}

function ejecutarAccionEscalaCalificacion(id,accion)
{
	switch(accion)
	{
		case '-1':
			eliminarEscalaCalificacion(id);
		break;
		case '1':
			gE('idEscalaCalificacion').value=id;
			gE('frmEnvio').submit();
		break;
		case '2':
			gE('idEscalaCalificacion').value='-1';
			gE('frmEnvio').submit();
		break;
	}
}

function eliminarEscalaCalificacion(id,tabla)
{
	function respPregunta(btn)
	{
		if(btn=='yes')
		{
			function funcAjax()
			{
				var resp=peticion_http.responseText;
				if(resp=='1')
				{
					location.reload();
				}
				else
				{
					Ext.MessageBox.alert(lblAplicacion,'No se ha podido llevar a cabo la operaci&oacute;n debido al siguiente problema: <br>'+resp);
				}
			}
			obtenerDatosWeb('../paginasFunciones/funcionesAdministracion.php',funcAjax, 'POST','funcion=19&id='+id,true)
		}
	}
	Ext.MessageBox.confirm(lblAplicacion,'Est&aacute; seguro de querer eliminar este registro, al eliminarlo borrar&aacute; sus elementos asociados',respPregunta);
	
}

function ejecutarAccionEtapa(id,accion)
{
	switch(accion)
	{
		case '-1':
			eliminarEtapa(id);
		break;
		case '1':
			gE('idEtapa').value=id;
			gE('frmEnvio').submit();
		break;
		case '2':
			gE('idEtapa').value='-1';
			gE('frmEnvio').submit();
		break;
	}
}

function eliminarEtapa(id,tabla)
{
	function respPregunta(btn)
	{
		if(btn=='yes')
		{
			function funcAjax()
			{
				var resp=peticion_http.responseText;
				if(resp=='1')
				{
					location.reload();
				}
				else
				{
					Ext.MessageBox.alert(lblAplicacion,'No se ha podido llevar a cabo la operaci&oacute;n debido al siguiente problema: <br>'+resp);
				}
			}
			obtenerDatosWeb('../paginasFunciones/funcionesAdministracion.php',funcAjax, 'POST','funcion=20&id='+id,true)
		}
	}
	Ext.MessageBox.confirm(lblAplicacion,'Est&aacute; seguro de querer eliminar este registro, al eliminarlo borrar&aacute; sus elementos asociados',respPregunta);
	
}





