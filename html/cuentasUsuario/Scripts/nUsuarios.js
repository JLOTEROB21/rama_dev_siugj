
Ext.onReady(Inicializar);

function Inicializar()
{
	generaLogin();
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
