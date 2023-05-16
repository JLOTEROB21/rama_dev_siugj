<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>

Ext.onReady(inicializar);

function inicializar()
{
	gE('email').focus();
}

function recuperarDatosAcceso()
{
	var mail=gE('email');
    if(!validarCorreo(mail.value))
    {
    	function resp1()
        {
            gE('email').focus();
        }
    	msgBox('La direcci&oacute;n de correo electr&oacute;nico ingresada no es v&aacute;lida',resp1);
    	return;
    }
 	
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        
        switch(arrResp[0])
        {
        	case '1':
            	function resp3()
                {
                	window.parent.cerrarVentanaFancy();
                }
                msgBox('Sus datos de acceso han sido enviados a su cuenta de correo electr&oacute;nico',resp3);
                return;
            break;
            case '2':
            
            	function resp2()
                {
                	gE('email').focus();
                }
                msgBox('La direcci&oacute;n de correo electr&oacute;nico ingresada no se encuentra registrada en el sistema',resp2);
                return;
            break;
            default:
            	 msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
            break;
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SICORE.php',funcAjax, 'POST','funcion=13&mail='+mail.value,true);
    
}
