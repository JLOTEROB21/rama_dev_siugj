function imprimirPagina()
{
	var ctrl=gE('btnImprimir');
    if(ctrl!=null)
    	ctrl.style.display='none';
	var navegador=window.navigator;
    if(navegador.appName=='Opera')
    {
    	
    	setTimeout('window.print()',1000);
    }
    else
		window.print();
    if(window.parent.tb_remove!=undefined)
		window.parent.tb_remove();
}