Ext.onReady(inicializar);

function inicializar()
{
	var parametros=eval(bD(gE('hParam').value))[0];
    var parametrosWord=eval(bD((gE('hParamW').value)));
    var mostrarMarco=true;
    var titulo='Vista previa';
    if(gE('mostrarMarco').value=='0')
    	titulo='';
    var mostrarRegresar=false;
    if(gE('mostrarRegresar').value=='1')
    	mostrarRegresar=true;
    new Ext.Viewport(	{
                            layout: 'border',
                            title: '',
                            items: [
                            			{
                                            layout: 'anchor',
                                            region:'center',
                                            tbar:	[
                                            			{
                                                            icon:'../images/salir.gif',
                                                            cls:'x-btn-text-icon',
                                                            hidden:!mostrarRegresar,
                                                            text:'Regresar',
                                                            handler:function()
                                                                    {
                                                                        regresarPagina();
                                                                    }
                                                            
                                                        },'-',
                                                        {
                                                            icon:'../images/page_word.png',
                                                            cls:'x-btn-text-icon',
                                                            hidden:true,
                                                            text:'Obtener version imprimible',
                                                            handler:function()
                                                                    {
                                                                        enviarFormularioDatos('../thotReporter/visorThot.php',parametrosWord);
                                                                    }
                                                            
                                                        },'-'
                                                    ],
                                            items: [
                                            
                                            			new Ext.ux.IFrameComponent	(
                                                        								{ 
                
                                                                                                id: 'content', 
                                                                                                region:'center',
                                                                                                anchor:'100% 100%',
                                                                                                url: '../paginasFunciones/white.php',
                                                                                                style: 'width:100%;height:100%' 
                                                                                        }
                                                                                    )
                                            			
                                            	]
                                        }
                                   ]
                          }
                      )
	gEx('content').load	(
    									{
                                        	url:'../thotReporter/visorThot.php',
                                            scripts:true,
                                            params:	parametros
                                        }
    								)    
}