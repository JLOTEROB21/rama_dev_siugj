<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>

Ext.onReady(inicializar);

function inicializar()
{
	crearCampoFecha('spFechaInicio','fechaInicio');
   crearCampoFecha('spFechaFin','fechaFin');
}

function guardarFechas()
{
	var fInicio=gEx('f_spFechaInicio');
    if(fInicio.getValue()=='')
    {
    	function respFI()
        {
        	fInicio.focus();
        }
        msgBox('La fecha de inicio es obligatoria',respFI);
        return;
    }
   	var fFin=gEx('f_spFechaFin');
     if(fFin.getValue()=='')
    {
    	function respFF()
        {
        	fFin.focus();
        }
        msgBox('La fecha de t&eacute;rmino es obligatoria',respFF);
        return;
    }
    
    if(fInicio.getValue()>fFin.getValue())
    {
    	function respFF2()
        {
        	fFin.focus();
        }
        msgBox('La fecha de inicio no puede ser mayor que la fecha de t&eacute;rmino',respFF2);
        return;
    }
    
    var obj='{"idFormulario":"'+gE('idFormulario').value+'","idReferencia":"'+gE('idReferencia').value+'","fechaInicio":"'+fInicio.getValue().format('Y-m-d')+'","fechaFin":"'+fFin.getValue().format('Y-m-d')+'"}';
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	if(typeof(funcAgregar)!='undefined')
		      	funcAgregar();
        	msgBox('Las fechas han sido guardadas correctamente');
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=197&obj='+obj,true);
}