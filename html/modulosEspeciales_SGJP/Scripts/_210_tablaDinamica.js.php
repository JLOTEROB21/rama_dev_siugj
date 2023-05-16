<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>

function inyeccionCodigo()
{
	
	var idEvento=gEN('_idEventovch')[0].value;
    loadScript('../modulosEspeciales_SGJP/Scripts/controlEventos.js.php', function()
    																		{
                                                                            	var objConf={};
                                                                                objConf.idEvento=idEvento;
                                                                                objConf.renderTo='sp_2862';
                                                                                objConf.permiteModificarEdificio=false;  
                                                                                objConf.permiteModificarUnidadGestion=false;  
                                                                                objConf.permiteModificarSala=false;  
                                                                                objConf.permiteModificarFecha=false;    
                                                                                objConf.permiteModificarJuez=false;                                                                               
                                                                                objConf.mostrarFechaAudiencia=true;
                                                                                objConf.mostrarTipoAudiencia=true;
                                                                                objConf.mostrarDuracionAudiencia=true;
                                                                                objConf.mostrarSalaAudiencia=true;
                                                                                objConf.mostrarCentroGestion=true;
                                                                                objConf.mostrarEdificio=true;
                                                                                objConf.mostrarJueces=true;
                                                                                objConf.mostrarDesarrollo=false;
                                                                                objConf.mostrarDuracionDesarrollo=false;
                                                                                objConf.mostrarHorarioDesarrollo=false;
                                                                                objConf.mostrarDocumentoMultimedia=false;
                                                                            	construirTableroEvento(objConf);
                                                                            }
    			);
    
    
}

/*
function obtenerFolioRegistro()
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            gE('_iRegistrovch').innerHTML='<a href="javascript:mostrarProcesoReferencia()">'+arrResp[1]+'</a>';
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=44&iF='+gEN('_iFormulariovch')[0].value+
    '&iR='+'+gEN('_iRegistrovch')[0].value,true);
    
}

function mostrarProcesoReferencia()
{
	var obj={};
    obj.ancho='100%';
    obj.alto='100%';
    obj.params=[['idFormulario',gEN('_iFormulariovch')][0].value,['idRegistro',gEN('_iRegistrovch')][0].value],['actor',bE(0)],['dComp',bE('auto')]];
    obj.url='../modeloPerfiles/vistaDTDv3.php';
    window.parent.abrirVentanaFancy(obj);
}*/
