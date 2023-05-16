<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>

function mostrarVentanaParametro()
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
                                                            html:'ID Control:'
                                                            
                                                        },
                                                        {
                                                        	x:125,
                                                            y:5,
                                                        	xtype:'textfield',
                                                            id:'txtID',
                                                            width:220,
                                                            maskRe:/^[a-zA-Z0-9]$/
                                                        },
                                                        {
                                                        	x:10,
                                                            y:35,
                                                            html:'Par&aacute;metro asociado:'
                                                        },
                                                        {
                                                        	x:125,
                                                            y:30,
                                                        	xtype:'textfield',
                                                            id:'txtParametro',
                                                            maskRe:/^[a-zA-Z0-9]$/,
                                                            width:220
                                                        }
                                                        

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar campo de par&aacute;metro',
										width: 390,
										height:160,
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
                                                                	gEx('txtID').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
															handler: function()
																	{
																		var txtID=gEx('txtID');
                                                                        if(txtID.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	txtID.focus();
                                                                            }
                                                                        	msgBox('El ID del control es obligatorio',resp);
                                                                        	return;
                                                                        }
                                                                        
                                                                        var txtParametro=gEx('txtParametro');
                                                                        if(txtParametro.getValue()=='')
                                                                        {
                                                                        	function resp2()
                                                                            {
                                                                            	txtParametro.focus();
                                                                            }
                                                                        	msgBox('El par&aacute;metro a asociar al control es obligatorio',resp2);
                                                                        	return;
                                                                        }
                                                                         objConfCampo='{"parametro":"'+txtParametro.getValue()+'"}'	
                                                                         var objFinal='{"idFormulario":"'+idFormulario+'","tipoElemento":"31","confCampo":'+objConfCampo+',"nomCampo":"'+txtID.getValue()+'","posX":"@posX","posY":"@posY","obligatorio":"0","pregunta":null}';
                                                            			h.objControl=objFinal;
                                                                        ventanaAM.close();
                                                                        
																	}
														},
														{
															text: '<?php echo $etj["lblBtnCancelar"]?>',
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