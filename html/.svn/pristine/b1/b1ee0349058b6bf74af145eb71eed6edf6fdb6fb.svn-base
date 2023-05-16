<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>

var arrVisores=	[
					['pdf','pdf_viewer.php'],
                    ['png','images_viewer.php'],
                    ['gif','images_viewer.php'],
                    ['jpg','images_viewer.php'],
                    ['jpeg','images_viewer.php']
                ];
Ext.onReady(inicializar);

function inicializar()
{
	
	var oDocumento=eval('['+bD(gE('datosDocumento').value)+']')[0];  
    
    oComp={};
   
    var objConf=	{
                        xtype:'panel',
                        region:'center',
                        layout:'border',
                        cls:'panelSiugj',
                        items:	[
                                    new Ext.ux.IFrameComponent({ 
    
                                                                      id: 'frameContenido', 
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
                    
                       

    new Ext.Viewport(	{
                                layout: 'border',
                                items: [
                                           objConf 
                                       ]
                            }
                        ) 
	
    var parametros={};
	var urlViewer='../visoresGaleriaDocumentos/';                        
	var pos=existeValorMatriz(arrVisores,'pdf');                        
	if(pos==-1)                        
    {
    	urlViewer+='noViewer.php';
    }
    else
    {
    	urlViewer+=arrVisores[pos][1];
        
        
        parametros={urlDoc:bE(oDocumento.urlContenido+'?idRegistroFormato='+gE('idRegistroFormato').value+'&nombreDocumento='+gE('nombreDocumento').value+
        					'&printer='+gE('printer').value+'&nombreDocumentoPlantilla='+gE('nombreDocumentoPlantilla').value)}
     }                   
	gEx('frameContenido').load	(
    
    								{
    									url:urlViewer,
                                        params:parametros	
                                     }
    							)                        
                          
}

