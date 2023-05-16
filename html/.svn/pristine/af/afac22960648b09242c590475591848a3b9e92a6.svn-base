var primeraVez=true;


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
                                                items:	[
                                                            new Ext.ux.IFrameComponent({ 
                
                                                                                            id: 'frameContenidoAudiencia', 
                                                                                            anchor:'100% 100%',
                                                                                            region:'center',
                                                                                            loadFuncion:function(iFrame)
                                                                                                        {
                                                                                                           if(primeraVez)
                                                                                                           {
                                                                                                        		var arrParametros=bD(gE('params').value);
																												gE('iframe-frameContenidoAudiencia').src=bD(gE('url').value)+'?'+arrParametros;
                                                                                                           		primeraVez=false;
                                                                                                           }
                                                                                                        },

                                                                                            url: '../paginasFunciones/white.php',
                                                                                            style: 'width:100%;height:100%' 
                                                                                    })
                                                        ]
                                            }
                                         ]
                            }
                        )   

	
}


