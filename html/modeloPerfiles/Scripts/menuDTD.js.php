<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>

Ext.onReady(inicializar)

function inicializar()
{
	
	funcionInicio();
}

/*function marcarEnlace(id)
{
	var x;
    x=1;
    while(true)
    {
    	var td=gE('td_'+x);
        if(td==null)
         	return;
            
       	if(id=='td_'+x)
			setClase(td,'letraRoja');				     
        else
            setClase(td,'letraFicha');				     
        x++; 
    }
}*/

function reportarCambios(iP)
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
                    recargarMenuDTD();
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesEspeciales.php',funcAjax, 'POST','funcion=13&idProyecto='+bD(iP),true);
        }
    }
    msgConfirm('Est&aacute; seguro de querer reportar que los cambios solicitados fueron llevados a cabo?',resp)
}