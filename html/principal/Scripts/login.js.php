<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>

Ext.onReady(inicializar);

var map = new Ext.KeyMap(document, 
								{
									key: 13, 
									fn: autentificarUsuario,
									scope: this
								}
							);

function inicializar()
{
	var campo=gE('txtLogin');
    
    if(campo==null)
    	campo=gE('email');
    
    if(campo!=null)
		campo.focus();
}

function autentificarUsuario()
{
	var login=gE('txtLogin').value;
	var passwd=gE('txtPass').value;
	var param=	'{'+
					'"L":"'+login+'",'+
					'"P":"'+passwd+'"'+
				'}';
	
	obtenerDatosWeb('../paginasFunciones/funciones.php',procResp,'POST','funcion=1&param='+param,true);
	function procResp()
	{
		var resp=peticion_http.responseText;
        if(resp==-100)
        {
             msgBox('No puede accesar al sistema, ya que no cuenta con datos de adscripci&oacute;n');
        }
        else
        {
			var objResp=eval(resp);
            if(objResp!=false)
            {
            	window.parent.location.href="<?php if($paginaInicioLogin=="") echo "../principal/inicio.php"; else echo $paginaInicioLogin;  ?>";
            	//window.parent.recargarPagina();
                window.parent.cerrarVentanaFancy();
                
                
            }
            else
            {
                  mE('filaErrorLogin');
                  gE('txtLogin').focus();
            }        
        }
	}			
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
    	msgBox('La direcci&oacute;n de E-mail ingresada no es v&aacute;lida',resp1);
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
                msgBox('La direcci&oacute;n de E-mail ingresada no se encuentra registrada en el sistema',resp2);
                return;
            break;
            default:
            	 msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
            break;
        }
    }
    obtenerDatosWeb('../paginasFunciones/funciones.php',funcAjax, 'POST','funcion=7&mail='+mail.value,true);
    
}


function mostrarVentanaNuevoRegistro()
{
	oE('tblLogin');
    mE('tblRegistro');
}

function regresarLogin()
{
	mE('tblLogin');
    oE('tblRegistro');
}