<?php session_start();
	include("configurarIdiomaJS.php");
?>

function modificarRegistro(idRegistro)
{

	var idFormulario=gE('idFormulario').value;
	var arrDatos=[['idRegistro',idRegistro],['idFormulario',idFormulario],['paginaRedireccion','../modeloPerfiles/verFichaFormulario.php'],['formularioNormal','1']];
	enviarFormularioDatos('../modeloPerfiles/registroFormulario.php',arrDatos);
}

function eliminarRegistro(idRegistro)
{
	var idFormulario=gE('idFormulario').value;
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
                 	regresarPagina(); 
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=39&idRegistro='+idRegistro+'&idFormulario='+idFormulario,true);
		}        
	}
    Ext.MessageBox.confirm('<?php echo $etj["lblAplicacion"]?>','<?php echo $etj["lblConfDelReg"]?>',resp);

}