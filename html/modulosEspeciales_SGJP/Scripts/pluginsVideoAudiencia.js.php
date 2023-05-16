<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>

Ext.onReady(inicializar);

function inicializar()
{
	loadScript('../Scripts/funcionesAjaxV2.js', 	function()
    												{
                                                    		var cVideo=cE('div');
                                                            cVideo.setAttribute('id','spVideo');
                                                            cVideo.setAttribute('style','z-index:100;width:320px;height:176px;position:fixed; top:'+((obtenerDimensionesNavegador()[0]) -180 )+'px; left: '+(obtenerDimensionesNavegador()[1]-350)+'px; display:; background-color:#000; border-color:#CCC; border-width:1px; border-style:solid');
                                                            var hVideo=cE('span');
                                                            hVideo.id='hVideo';
                                                            cVideo.appendChild(hVideo);
                                                            
                                                            gE('frmEnvio').appendChild(cVideo);
                                                            
                                                            
                                                            new Ext.ux.IFrameComponent({ 

                                                                                            id: 'frameContenidoGrabacion', 
                                                                                            renderTo:'hVideo',
                                                                                            anchor:'100% 100%',
                                                                                            url: '../paginasFunciones/white.php',
                                                                                            style: 'width:100%;height:100%',
                                                                                            loadFuncion: function(el)
                                                                                                        {
                                                                                                            
                                                                                                           
                                                                                                        }  
                                                                                    })

                                                   
                                                   		gEx('frameContenidoGrabacion').load	(
                                                                                                  {
                                                                                                      url:'../modulosEspeciales_SGJP/visorGrabacionAudiencia.php',
                                                                                                      params:	{
                                                                                                                  cPagina:'sFrm=true',
                                                                                                                  autoPlay:0,
                                                                                                                  iFramed:1,
                                                                                                                  idEvento:bE(gEN('_idEventovch')[0].value)
                                                                                                              }
                                                                                                  }
                                                                                              )  
                                                   
                                                    }
				);
	
    
                            	
    
}