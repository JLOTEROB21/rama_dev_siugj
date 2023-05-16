<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>

function agregarConcepto()
{
	var arrDatos=[['idConsulta',('-1')],['categoria',gE('categoria').value],['lblCalculoP',gE('lblCalculoP').value],['lblCalculoS',gE('lblCalculoS').value]];
    enviarFormularioDatos('../Sistema/calculoSistema.php',arrDatos);
}

function modificar()
{
	var grid_tblTabla=gEx('grid_tblTabla');
    var fila=grid_tblTabla.getSelectionModel().getSelected();
    if(fila==null)
    {
    	msgBox('Debe seleccionar el elemento que desea modificar');
    	return;
    }
	var arrDatos=[['idConsulta',fila.get('idConsulta')],['cPagina','sFrm=true|mR1=true'],['categoria',gE('categoria').value],['lblCalculoP',gE('lblCalculoP').value],['lblCalculoS',gE('lblCalculoS').value]];
    enviarFormularioDatos('../Sistema/calculoSistema.php',arrDatos);
}

function eliminar()
{
	var grid_tblTabla=gEx('grid_tblTabla');
    var fila=grid_tblTabla.getSelectionModel().getSelected();
    if(fila==null)
    {
    	msgBox('Debe seleccionar el registro que desea remover');
    	return;
    }
    
	function resp(btn)
    {
    	if(btn=='yes')
        {
        	function funcAjax()
            {
                var resp=peticion_http.responseText;
                arrResp=resp.split('|');
                if(arrResp[0]=='1')
                {
                	grid_tblTabla.getStore().remove(fila)	;
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=149&idConsulta='+fila.get('idConsulta'),true);

        }
    }
    msgConfirm('Est&aacute; seguro de querer eliminar el elemento seleccionado?',resp);
}