function nuevo()
{
	gE('roma').action='../Usuarios/nuevoUsuario.php';
	gE('roma').submit();
}

function inscribe(valor1,valor2,valor3)
{
	if(valor3==1)
	{
		gE('roma').action='../InscripAlumno/nuevoAspirante.php';
		gE('programa').value=valor1;
		gE('programaname').value=valor2;
		gE('roma').submit();
	}
	if(valor3==0)
	{
		gE('roma').action='../InscripAlumno/reinscribe.php';
		gE('programa').value=valor1;
		gE('programaname').value=valor2;
		gE('roma').submit();
	}
}
