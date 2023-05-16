<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>

Ext.onReady(inicializar);

function inicializar()
{
    new Ext.Viewport(	{
                                layout: 'border',
                                items: [
                                            {
                                                xtype:'panel',
                                                region:'center',
                                                layout:'border',
                                                tbar:	[
                                                			{
                                                                icon:'../imagenesDocumentos/16/file_extension_xlsx.png',
                                                                cls:'x-btn-text-icon',
                                                                text:'Exportar a Excel',
                                                                handler:function()
                                                                        {
                                                                            var arrDatos=[['formato','2'],['disposicion','1']];
                                                                        	enviarFormularioDatos('../reportes/reporte'+gE('idReporte').value+'.php',arrDatos);
                                                                        }
                                                                
                                                            }
                                                		],
                                                items:	[
                                                            	new Ext.ux.IFrameComponent({ 
                
                                                                                                            id: 'frameContenidoReporte', 
                                                                                                            anchor:'100% 100%',
                                                                                                            region:'center',
                                                                                                            loadFuncion:function(iFrame)
                                                                                                            			{
                                                                                                                        	
                                                                                                                        },

                                                                                                            url: '../paginasFunciones/white.php',
                                                                                                            style: 'width:100%;height:100%' 
                                                                                                    })
                                                            
                                                        ]
                                            }
                                         ]
                            }
                        )   

	gEx('frameContenidoReporte').load	(
    										{
                                            	url:'../reportes/reporte'+gE('idReporte').value+'.php',
                                                params: {
                                                			formato:gE('formato').value,
                                                            disposicion:1
                                                		}
                                            }
    									)
}