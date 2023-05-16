function report(idUsr)
{
	function mostrarThick()
		  {
			  
			  TB_show(lblAplicacion,'../modulosUsuario/reportes.php?idUsr='+idUsr+'&TB_iframe=true&height=550&width=800',"","");
		  
		  }
mostrarThick();
}
function fich(idUsr)
{
	function mostrarThick()
		  {
			  
			  TB_show(lblAplicacion,'../Alumno/fichaMedica.php?idAlumno='+idUsr+'&TB_iframe=true&height=550&width=600',"","");
		  
		  }
mostrarThick();
}

function just(idUsr)
{
	function mostrarThick()
		  {
			  
			  TB_show(lblAplicacion,'../modulosUsuario/&TB_iframe=true&height=550&width=800',"","");
		  
		  }
mostrarThick();
}
function hist(idUsr)
{
	var arrDatos=[['idUsuario',idUsr],['cPagina','sFrm=true']];
	enviarFormularioDatos('../controlEscolar/kardex.php',arrDatos);
	//TB_show(lblAplicacion,?idUsuario='+idUsr+'&cPagina='+cv('sFrm=true')+'&TB_iframe=true&height=550&width=800',"","");
}
function doc(idUsr)
{
	function mostrarThick()
		  {
			  
			  TB_show(lblAplicacion,'../Alumno/documentosAlumno.php?idAlumno='+idUsr+'&TB_iframe=true&height=550&width=800',"","");
		  
		  }
mostrarThick();
}
function histinst(idUsr)
{
	function mostrarThick()
		  {
			  
			  TB_show(lblAplicacion,'../modulosUsuario/&TB_iframe=true&height=550&width=800',"","");
		  
		  }
mostrarThick();
}
function curri(idUsr)
{
	function mostrarThick()
		  {
			  
			  TB_show(lblAplicacion,'../modulosUsuario/cv.php?idUsr='+idUsr+'&TB_iframe=true&height=550&width=900',"","");
		  
		  }
mostrarThick();
}

function verCronograma(iU)
{
	var arrParam=[['idUsuario',iU],['sl','1']];
	enviarFormularioDatos('../modeloProyectos/programaTrabajo.php',arrParam);
}

function verElemento(iP,iU)
{
	var arrParam=[['idProceso',iP],['idUsuario',iU],['sl','1'],['vCV','1'],['cPagina','mR1=false']];
	window.open('',"vAuxiliar", "toolbar=no,directories=no,menubar=no,status=no,scrollbars=yes,fullscreen=yes");
	enviarFormularioDatosV('../modeloProyectos/registros.php',arrParam,'POST','vAuxiliar');
}

function verElementoProy(iP,iU)
{
	var arrParam=[['idProceso',iP],['idUsuario',iU],['sl','1'],['vCV','1']];
	enviarFormularioDatos('../modeloProyectos/proyectos.php',arrParam);
}

function verPerfil(iU)
{
	var sC=gE('soloContenido').value;
	if(sC=='0')
		var arrParam=[['idUsuario',iU]];
	else
		var arrParam=[['idUsuario',iU],['cPagina','sFrm=true|mR1=true']];
	enviarFormularioDatos('../Usuarios/verPerfil.php',arrParam);
}

function verHistorialProf(iU)
{
	var arrParam=[['idUsuario',iU],['sL','1']];
	window.open('',"vAuxiliar", "toolbar=no,directories=no,menubar=no,status=no,scrollbars=yes,fullscreen=yes");
    enviarFormularioDatosV('../Profesores/vistaProfesor.php',arrParam,'POST','vAuxiliar');
}

function adscripcion(iU)
{
	var arrParam=[['idUsuario',bD(iU)]];
	enviarFormularioDatos('../Usuarios/fichaAdscripcion.php',arrParam);
}

function enviarMail()
{
	var idUsr=generarObjetoUsuarioMail(bD(gE('idUsr').value));
	TB_show(lblAplicacion,'../correos/enviarMail.php?d='+idUsr+'&cPagina=sFrm=true&TB_iframe=true&height=550&width=900',"","");
}

//fich,just,hist,doc,histinst,curri