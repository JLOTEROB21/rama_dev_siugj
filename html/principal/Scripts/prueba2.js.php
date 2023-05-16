Ext.onReady(inicializar)

function inicializar()
{

	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            xtype:'datefield'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            xtype:'textfield',
                                                            width:200
                                                        }
														

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										
										width: 500,
										height:450,
										layout: 'fit',
										plain:true,
										modal:true,
										bodyStyle:'padding:5px;',
										buttonAlign:'center',
										items: form,
										listeners : {
													show : {
																buffer : 10,
																fn : function() 
																{
																}
															}
												},
										buttons:	[
														{
															
															text: 'Aceptar',
                                                            
															handler: function()
																	{
																		
																	}
														},
														{
															text: 'Cancelar',
															handler:function()
																	{
																		ventanaAM.close();
																	}
														}
													]
									}
								);
	ventanaAM.show();
}