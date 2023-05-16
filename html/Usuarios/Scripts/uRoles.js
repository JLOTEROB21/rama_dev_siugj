function validarFrm(name)
{
	
	if(!validarFormularios(name))
	alert ('error', 'formulario no valido');
	
	else
	gE(name).submit();
}