<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>


function mostrarProcesoPadre()
{
	var cadObj='{"idFormulario":"'+gE('idFormularioAux').value+'","idRegistro":"'+gE('idRegistroAux').value+'"}';
	function funcAjax(peticion_http)
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            var objResp=eval('['+arrResp[1]+']')[0];
            
           	var obj={};
		
            obj.ancho='100%';
            obj.alto='100%';
            obj.url='../modeloPerfiles/vistaDTDv3.php';
            obj.params=[['idFormulario',objResp.iFormulario],['idRegistro',objResp.iRegistro],['actor',bE(0)],['dComp',bE('auto')]];
            abrirVentanaFancy(obj);
            
            
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWebV2('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=43&cadObj='+cadObj,true);
}