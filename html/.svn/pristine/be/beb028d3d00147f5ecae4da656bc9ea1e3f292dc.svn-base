<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	
	
?>




function inyeccionCodigo()
{
	obtenerFolioRegistro()
    

}




function obtenerFolioRegistro()
{

	if(gEN('_iFormulariovch')[0].value!='N/E')
    {
		
        function funcAjax()
        {
            var resp=peticion_http.responseText;
            arrResp=resp.split('|');
            if(arrResp[0]=='1')
            {
            	if(gEx('ext__carpetaAdministrativavch'))
                {
                    gEx('ext__carpetaAdministrativavch').setRawValue(gE('_carpetaAdministrativavch').value);
                    gEx('ext__carpetaAdministrativavch').disable();
	                gE('_idEventovch').disabled='disabled';
                    gE('sp_3851').innerHTML='<a href="javascript:mostrarProcesoReferencia()">'+arrResp[1]+'</a>';
                }
                else
                
	                gE('_[iRegistro]vch').innerHTML='<a href="javascript:mostrarProcesoReferencia()">'+arrResp[1]+'</a>';
                
            }
            else
            {
                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
            }
        }
        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=44&iF='+gEN('_iFormulariovch')[0].value+
        '&iR='+gEN('_iRegistrovch')[0].value,true);
    }
    else
    {
    	oE('div_3846');
        oE('div_3847');
    }
}

function mostrarProcesoReferencia()
{
	var obj={};
    obj.ancho='100%';
    obj.alto='100%';
    obj.params=[['idFormulario',gEN('_iFormulariovch')[0].value],['idRegistro',gEN('_iRegistrovch')[0].value],['actor',bE(0)],['dComp',bE('auto')]];
    obj.url='../modeloPerfiles/vistaDTDv3.php';
    window.parent.abrirVentanaFancy(obj);
}
