<?php
	session_start();
	include("configurarIdiomaJS.php");
?>
function nuevaConfiguracion()
{
	var idFormulario=gE('idFormulario').value;
	var arrParam=[['idConfiguracion','-1'],['idFormulario',idFormulario]];
	enviarPagina(arrParam,'../formularios/configuracionesGrid.php',true);
}

function modificarConfiguracion(idConfiguracion)
{
	var idFormulario=gE('idFormulario').value;
	var arrParam=[['idConfiguracion',idConfiguracion],['idFormulario',idFormulario]];
	enviarPagina(arrParam,'../formularios/configuracionesGrid.php',true);
}

function eliminarConfiguracion(idConf)
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
                	var fila=gE('fila_'+idConf) ;
                    fila.parentNode.removeChild(fila); 
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=31&idConf='+idConf,true);
            
        }
    }
    Ext.MessageBox.confirm('<?php echo $etj["lblAplicacion"]?>','<?php echo $etj["lblConfDelReg"]?>',resp);
}

function regresar()
{
	var idFormulario=gE('idFormulario').value;
	var arrParam=[['idFormulario',idFormulario]];
	enviarPagina(arrParam,'../formularios/formularios.php',true);
}