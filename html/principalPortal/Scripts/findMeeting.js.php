<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>

var idTareaInicioReunion=0;

Ext.onReady(inicializar);

function inicializar()
{
	gE('txtNumReunion').focus();
}


function buscarReunion()
{
	var continuar=true;
	 if(gE('txtNumReunion').value.trim()=='')
     {
     	gE('txtNumReunion').focus();
     	mE('lblNumeroReunion');
        continuar=false;
     }
     
      if(gE('txtPassReunion').value.trim()=='')
     {
     	gE('txtPassReunion').focus();
     	mE('lblPasswdReunion');
        continuar=false;
     }
     
     if(!continuar)
     {
     	return;
     }
     
     
    function funcAjax(peticion_http)
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            if(arrResp[1]=='1')
            {
            	var arrParam=[[arrResp[3],arrResp[4]]];
                enviarFormularioDatos(arrResp[2],arrParam,'GET');
            }
            else
            {
            	gE('lblResultado').innerHTML='El ID/contrase&ntilde;a de de reuni&oacute;n NO es v&aacute;lido'
            }
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWebV2('../paginasFunciones/funcionesModulosEspeciales_VideoConferencias.php',funcAjax, 'POST','funcion=9&meetID='+gE('txtNumReunion').value+'&passwd='+gE('txtPassReunion').value,false);
    
         
}

function enmascararCodigoReunion(ctrl)
{

	var cadenaMascara='';
    var x;
    var totalNumero=0;
    var totalGuiones=0;
    for(x=0;x<ctrl.value.length;x++)
    {
    	if(ctrl.value[x]!='-')
        {
            cadenaMascara+=ctrl.value[x];
            totalNumero++;
            if((totalNumero==4)&&(totalGuiones<3))
            {
                cadenaMascara+='-';
                totalNumero=0;
                totalGuiones++;
            }
		}
    }
    ctrl.value=cadenaMascara;
}


function numReunionKeyPress(evt,decimal,guion,control)
{
	
	oE('lblNumeroReunion');
	return soloNumero(evt,decimal,guion,control);
}

function passwdReunionKeyPress(evt)
{
	oE('lblPasswdReunion');
	return soloLetrasNumeros(evt);
}

