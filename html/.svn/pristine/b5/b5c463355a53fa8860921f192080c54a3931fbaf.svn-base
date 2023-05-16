<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>


function insertarControlGaleriaImagen()
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
                                                            x:100,
                                                            y:5,
                                                        	xtype: 'textfield',
                                                            id: 'idControl',
                                                            width:130,
                                                            maskRe:/^[a-zA-Z0-9]$/
                                                            
                                                        },
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            html:'Ancho:'
                                                        },
                                                        {
                                                        	x:100,
                                                            y:35,
                                                            id:'txtAncho',
                                                            xtype:'numberfield',
                                                            allowDecimals:false,
                                                            width:80,
                                                            allowNegative:false
                                                        },
                                                        {
                                                        	x:10,
                                                            y:70,
                                                            html:'Alto:'
                                                        },
                                                        {
                                                        	x:100,
                                                            y:65,
                                                            id:'txtAlto',
                                                            width:80,
                                                            xtype:'numberfield',
                                                            allowDecimals:false,
                                                            allowNegative:false
                                                        }

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar galeria imagen',
										width:360,
                                    	height:185,
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
                                                                	gEx('idControl').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
															handler: function()
																	{
																		
                                                                        var ancho=gEx('txtAncho').getValue();
                                                                        var alto=gEx('txtAlto').getValue();
                                                                        var idControl=gEx('idControl').getValue();
                                                                        if(idControl=='')
                                                                        {
                                                                        	function respID()
                                                                            {
                                                                            	Ext.getCmp('idControl').focus();
                                                                            }
                                                                            msgBox('El ID del control es obligatorio',respID);
                                                                            return;
                                                                        }
                                                                        
                                                                        if(ancho=='')
                                                                        {
                                                                        	function respAncho()
                                                                            {
                                                                            	gEx('txtAncho').focus();
                                                                            }
                                                                            msgBox('El ancho del control es obligatorio',respAncho);
                                                                            return;
                                                                        }
                                                                        
                                                                        if(alto=='')
                                                                        {
                                                                        	function respAlto()
                                                                            {
                                                                            	gEx('txtAlto').focus();
                                                                            }
                                                                            msgBox('El alto del control es obligatorio',respAlto);
                                                                            return;
                                                                        }
                                                                        var objFinal='{"idFormulario":"'+idFormulario+'","pregunta":null,"tipoElemento":"33","nomCampo":"'+idControl+'","obligatorio":"0","posX":"@posX","posY":"@posY","confCampo":{"ancho":"'+ancho+'","alto":"'+alto+'"}}';
                                                                        
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