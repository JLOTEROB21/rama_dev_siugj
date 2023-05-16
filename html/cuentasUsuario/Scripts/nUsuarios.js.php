<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>

Ext.onReady(Inicializar);

function Inicializar()
{
	var statusCuenta=gE('statusCuenta');
    if(statusCuenta!=null)
    {
        if(statusCuenta.value=='2')
            generaLogin();
	}
}

function guardarUsuario(form)
{
	
	var pwd1=gE('Contrasena');
	var pwd2=gE('Contrasena2');
	if(pwd1.value!=pwd2.value)
	{
		function ponerFoco()
		{
			pwd1.focus();
		}
		Ext.MessageBox.alert(lblAplicacion,'Las contrase&ntilde;as introducidas no son iguales',ponerFoco);
		return;
	}
    var statusCuenta=gE('statusCuenta');
    if(statusCuenta!=null)
    {
        if(gE('statusCuenta').value=='3')
        {
            if(pwd1.value==gE('lblPasswd').value)
            {
                function resp2()
                {
                    gE('pwd1').focus();
                }
                msgBox('Por seguridad es necesario que cambie sus contrae&ntilde;a de acceso',resp2);
                return;
            }
        }
    }

	if (!validarFormularios(form))
	{
		return;
	}
	else
	{
		var formulario=gE(form);
		formulario.submit();
	}
}

function cancelar()
{
	function resp(btn)
	{
		if(btn=='yes')
		{
			cerrarSesion();	
		}
	}
	msgConfirm('Est&aacute; seguro de querer cancelar la actualizaci&oacute;n de su cuenta?',resp)
}

function generaLogin()
{
	var cmbLogin=gE('cmbLogin');
	var idUsr=gE('idUsuario');
	limpiarCombo(cmbLogin);
	function funcTratarRespuesta()
	{
		var resp=peticion_http.responseText;
		var arrOpc=resp.split('|');
		var x;
		var opcion;
		for(x=0;x<arrOpc.length-1;x++)
		{
			opcion=document.createElement('option');
			opcion.value=arrOpc[x];
			opcion.text=arrOpc[x];
			cmbLogin.options[cmbLogin.length]=opcion;
		}
		selElemCombo(cmbLogin,gE('lblLogin').value);
	}
	obtenerDatosWeb('../Usuarios/intermediaProcesar.php',funcTratarRespuesta, 'POST','banderaGuardar=generaLogin&idUsuario='+idUsr.value);		
}