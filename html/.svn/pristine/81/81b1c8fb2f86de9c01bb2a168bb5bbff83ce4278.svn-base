<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>

Ext.onReady(inicializar);

function inicializar()
{
	gE('nombre').focus();
}

function enviarMensajeContacto()
{
	if(validarFormularios('frmEnvio'))
    {
    	if(!validarCorreo(gE('mail').value))
        {
        	function resp()
            {
            	gE('mail').focus();
            }
            msgBox('El E-mail ingresado no es v&aacute;lido',resp);
        	return;
        }
    	var cadObj='{"idZona":"'+gE('idZona').value+'","nombre":"'+cv(gE('nombre').value)+'","empresa":"'+cv(gE('empresa').value)+'","email":"'+cv(gE('mail').value)+
        			'","telefono":"'+cv(gE('telefono').value)+'","comentarios":"'+cv(gE('comentarios').value)+'"}';
        
        function funcAjax()
        {
            var resp=peticion_http.responseText;
            arrResp=resp.split('|');
            if(arrResp[0]=='1')
            {
                function resp2()
                {
                	window.parent.cerrarVentanaFancy();
                }
                msgBox("Sus datos han sido recibidos, en breve nuestro personal se pondr&aacute; en contacto con usted, gracias por su inter&eacute;s",resp2)
                return;
            }
            else
            {
                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
            }
        }
        obtenerDatosWeb('../paginasFunciones/funcionesPortal.php',funcAjax, 'POST','funcion=84&cadObj='+cadObj,true);
    }
}