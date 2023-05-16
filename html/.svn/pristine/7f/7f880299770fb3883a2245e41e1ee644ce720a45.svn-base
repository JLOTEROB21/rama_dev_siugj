<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>

function mostrarVentanaValidacionFirma()
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
															html:'Ingrese el documento a validar:'
														},
														{
															x:250,
															y:10,
															html:'<input style="font-size:11px !important;" type="file" id="fileValidate" accept=".pdf" style="width:250px">'
														},
														{
															x:10,
															y:40,
															html:'Resultado de la validaci&oacute;n:'
														},
														{
															x:10,
															y:70,
															html:'<span id="spIcono"></span>'
														},
														{
															x:47,
															y:74,
															html:'<span id="spResultado"></span>'
														}
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Validar documento',
										width: 600,
										height:190,
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
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
															handler: function()
																	{
																		if(gE('fileValidate').value=='')
																		{
																			function resp1Cer()
																			{
																				gE('fileValidate').focus();
																			}
																			msgBox('Debe ingresar el documento que desea validar',resp1Cer);
																			return;
																		}
																		var formData = new FormData();
																				
																		formData.append('fileValidate',gE('fileValidate').files[0]);
																		mostrarMensajeProcesando('Verificando documento, &eacute;sta operaci&oacute;n puede tardar unos minutos...');
																		$.ajax	({
																					url: "../paginasFunciones/validarDocumentoFirmaElectronica.php",
																					data: formData,
																					processData: false,
																					contentType: false,
																					type: 'POST',
																					success: function(data)
																							{
																								ocultarMensajeProcesando();
																								var arrResp=data.split("|");
																								
																								if(arrResp[0]=='1')
																								{
																									var oResp=eval('['+arrResp[1]+']')[0];
																									gE('spIcono').innerHTML='<img src="../images/'+(oResp.resultado=='1'?'001_06.gif':'001_05.gif')+'">';
																									var leyenda='';
																									if(oResp.resultado=='1')
																										leyenda='El documento se encuentra dentro de los registros del TSJCDMX y no ha sido alterado';
																									else
																										leyenda=bD(oResp.comentarios);
																									gE('spResultado').innerHTML=leyenda;
																									
																								}
																								else
																								{
																									msgBox('No se ha podido llevar a cabo la operaci&oacute;n debido al siguiente problema:<br><br>'+arrResp[0]);
																								}
																							}
																				});
																	}
														},
														{
															text: 'Cerrar',
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