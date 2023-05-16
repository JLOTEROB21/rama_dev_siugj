function verIdentificacion(usr)
{
	var arrParam=[['idUsuario',usr],['accion','modificar']];
	enviarFormularioDatos('nIdentifica.php',arrParam);
}

function verAdscripcion(usr,tipo)
{
	var arrParam=[['idUsuario',usr]];
	enviarFormularioDatos('../Usuarios/fichaAdscripcion.php',arrParam);
	if(tipo==5)
		enviarFormularioDatos('nAdscripcion.php',arrParam);
	else
		enviarFormularioDatos('../Usuarios/fichaAdscripcion.php',arrParam);
	/*if(tipo==5)
		enviarFormularioDatos('nAdscripcion.php',arrParam);
	else
		enviarFormularioDatos('nAdscripcionInterno.php',arrParam);*/
	
}

function verUsuario(usr)
{
	var arrParam=[['idUsuario',usr],['accion','modificar']];
	enviarFormularioDatos('nUsuarios.php',arrParam);
}

function verAlumno(usr)
{
	var arrParam=[['idUsuario',usr]];
	enviarFormularioDatos('datosAlumnos.php',arrParam);
}

function removerUsuario(u)
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
					window.location.href='../Usuarios/bUsuarios.php';
				}
				else
				{
					msgBox('No se ha podido llevar a cabo la operaci&oacute;n debido al siguiente problema:'+' <br />'+arrResp[0]);
				}
			}
			obtenerDatosWeb('../paginasFunciones/funcionesUsuarios.php',funcAjax, 'POST','funcion=26&usr='+u,true);
		}
	}
	msgConfirm('Est&aacute; seguro de querer eliminar del sistema al usuario seleccionado?',resp)
}

function verDatosPadre(usr)
{
	var arrParam=[['idUsuario',usr]];
	enviarFormularioDatos('datosPadre.php',arrParam);
}

function verDatosInvestigador(usr)
{
	var arrParam=[['idUsuario',usr]];
	enviarFormularioDatos('../Usuarios/datosInvestigador.php',arrParam);
}