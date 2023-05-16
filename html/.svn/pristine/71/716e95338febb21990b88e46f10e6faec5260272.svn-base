<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>
function agregarIndicador()
{
	var arrParam=[['idIndicador','-1']];
    enviarFormularioDatos('../modeloPerfiles/indicadores.php',arrParam);
}

function modificarIndicador(i)
{
	var arrParam=[['idIndicador',bD(i)]];
    enviarFormularioDatos('../modeloPerfiles/indicadores.php',arrParam);
}

function eliminarIndicador(i)
{
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
                	var fila=gE('fila_'+bD(i));
                    fila.parentNode.removeChild(fila);
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=55&idIndicador='+bD(i),true);
        }
    }
    msgConfirm('Est&aacute; seguro de querer eliminar el indicador seleccionado?',resp);
}