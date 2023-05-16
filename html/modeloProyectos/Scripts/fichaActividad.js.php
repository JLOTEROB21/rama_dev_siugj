function verSesionesTrabajo(fI,fF,a,s)
{
	var arrParam=[['fI',fI],['fF',fF],['a',a],['s',s]];
    enviarFormularioDatos('../modeloProyectos/sesionesTrabajo.php',arrParam);
}

function verReportes(a)
{
	var arrParam=[['a',a]];
    enviarFormularioDatos('../modeloProyectos/reporteActividades.php',arrParam);
}