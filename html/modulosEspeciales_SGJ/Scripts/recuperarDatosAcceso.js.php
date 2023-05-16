<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>

Ext.onReady(inicializar);

function inicializar()
{
	//gE('email').focus();
    
    new Ext.Panel	(
    					{
                        	renderTo:'spContenedor',
                            width:800,
                            height:170,
                            border:false,
                            layout:'absolute',
                            items:	[
                            			
                                     ]
                             }
                             
                    )
    
}

function recuperarDatosAcceso()
{
	var mail=gEx('email');
    if(!validarCorreo(mail.getValue()))
    {
    	function resp1()
        {
            gEx('email').focus();
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
                msgBox('Sus datos de acceso han sido enviados a la cuenta de correo electr&oacute;nico registrada',resp3);
                return;
            break;
            /*case '2':
            
            	function resp2()
                {
                	gEx('email').focus();
                }
                msgBox('La direcci&oacute;n de correo electr&oacute;nico ingresada no se encuentra registrada en el sistema',resp2);
                return;
            break;*/
            default:
            	 msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
            break;
        }
    }
    obtenerDatosWeb('../modulosEspeciales_SGJ/paginasFunciones/funcionesModulosEspeciales_SGJ.php',funcAjax, 'POST','funcion=7&mail='+mail.getValue(),true);
    
}
