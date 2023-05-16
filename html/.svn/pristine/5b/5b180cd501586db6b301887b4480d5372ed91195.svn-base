<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>
function anioChange(combo)
{
	var idFormulario=gE('idFormulario').value;
    var idReferencia=gE('idReferencia').value;
    var anio=combo.options[combo.selectedIndex].value;
    var idUsuario=gE('idUsuario').value;
    var idProceso=gE('idProceso').value;
    
    var cmbActividades=gE('actividad');
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var arrDatos=eval(arrResp[1]);
            llenarCombo(cmbActividades,arrDatos);
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=104&idUsuario='+idUsuario+'&idProceso='+idProceso+'&anio='+anio,true);
}

function guardarActividad()
{
	var idFormulario=gE('idFormulario').value;
    var idReferencia=gE('idReferencia').value;
    var combo=gE('anioAct');
    var anio=combo.options[combo.selectedIndex].value;
    var cmbActividad=gE('actividad');
    var idActividad=cmbActividad.options[cmbActividad.selectedIndex].value;
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	function resp1()
            {
            	
            	if(typeof(funcAgregar)!='undefined')
					funcAgregar();
            }
			msgBox('Los datos han sido guardados correctamente',resp1);
            return;
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=105&anio='+anio+'&idFormulario='+idFormulario+'&idReferencia='+idReferencia+'&idActividad='+idActividad,true);
}