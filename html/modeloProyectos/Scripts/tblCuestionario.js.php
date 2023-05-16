function enviarFormulario(idCuestionario)
{
	if(validarFormularios(idCuestionario))
        gE(idCuestionario).submit();
}
function modificarCuestionario(idCuestionario)
{
	var arrParam=[['idCuestionario',idCuestionario]];
    enviarFormularioDatos('../modeloProyectos/cuestinarioDictamen.php',arrParam);
}