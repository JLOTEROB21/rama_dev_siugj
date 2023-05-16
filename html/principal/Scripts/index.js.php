function ingresarSistema()
{
	var obj={};
    obj.url='../principal/login.php';
    obj.ancho=840;
    obj.alto=420;
    abrirVentanaFancy(obj);
}


function recargarPagina()
{
	location.href="../principal/inicio.php";
}