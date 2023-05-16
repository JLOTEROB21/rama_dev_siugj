<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>




function funcionAntesCargaInyeccion(id)
{

	gE('_txtSDIflo').value='';
    gE('_txtCuentaBancariaint').value='';
    gE('_cmbTipohonorariovch').selectedIndex=0;
}


function funcionSeleccionInyeccion(combo,registro)
{
	var cadObj='{"idUsuario":"'+registro.get('id')+'","plantel":"<?php echo $_SESSION["codigoInstitucion"]?>"}';
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            gE('_txtSDIflo').value=arrResp[1];
		    gE('_txtCuentaBancariaint').value=arrResp[2];
            gE('_txtSDIflo').focus();
            gE('_cmbTipohonorariovch').focus();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesRecursosHumanos.php',funcAjax, 'POST','funcion=55&cadObj='+cadObj,true);

    
}
