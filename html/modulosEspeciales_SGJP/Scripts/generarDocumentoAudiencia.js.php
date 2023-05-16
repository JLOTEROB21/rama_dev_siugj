<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>


function generarDocumentoAudiencia(idDocumento,registroUnico)
{
	
	var cadObj='{"idEvento":"'+gE('idEventoAudiencia').value+'","carpetaAdministrativa":"'+gE('carpetaAdministrativa').value+'","idDocumento":"'+idDocumento+'","registroUnico":"'+registroUnico+'"}';
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
         	 var obj={};
            var params=[['idRegistro',arrResp[1]],['idFormulario',101],['dComp',bE('auto')],['actor',bE('304')]];
            obj.ancho='90%';
            obj.alto='95%';
            obj.url='../modeloPerfiles/vistaDTDv3.php';
            obj.params=params;
            obj.modal=true;
            abrirVentanaFancy(obj); 
            recargarGrids();  
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=26&cadObj='+cadObj,true);
}
