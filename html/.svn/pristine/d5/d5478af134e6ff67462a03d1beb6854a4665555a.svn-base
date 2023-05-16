<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>

function agregarConcepto(bandera)
{
	var arrDatos=[['idConsulta',('-1')],['bandera',bandera]];
    enviarFormularioDatos('../nomina/conceptosNomina.php',arrDatos);
}

function modificar(iC,bandera)
{
	var arrDatos=[['idConsulta',bD(iC)],['bandera',bandera],['cPagina','sFrm=true|mR1=true']];
    enviarFormularioDatos('../nomina/conceptosNomina.php',arrDatos);
}

function eliminar()
{
	var grid_tblTabla=gEx('grid_tblTabla');
    var fila=grid_tblTabla.getSelectionModel().getSelected();
    if(fila==null)
    {
    	msgBox('Debe seleccionar el concepto que desea remover');
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
    msgConfirm('Est&aacute; seguro de querer eliminar el concepto seleccionado?',resp);
}