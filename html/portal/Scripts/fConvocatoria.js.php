Ext.onReady(inicializar);

function inicializar()
{
      
       var contenido=new Ext.Panel	(
                                                    {
                                                        renderTo:'tPortal',
                                                        height:800,
                                                        border:false,
                                                        items:	[
                                                                    {
                                                                        id:'frameContenido',
                                                                        xtype:'iframepanel',
                                                                        height:750,
                                                                        border:false,
                                                                        autoLoad:	{	
                                                                        				url:'../portal/portalConvocatoria.php',
																                        scripts:true
                                                                                        
                                                                                        
                                                                                    },
                                                                         loadMask:	{
                                                                                        msg:'Cargando'
                                                                                    }
                                                                    }	
                                                                ]		
                                                    }
                                                )
}