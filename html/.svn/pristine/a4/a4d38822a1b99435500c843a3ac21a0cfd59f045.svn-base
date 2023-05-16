<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>
var moduloCertificacionCargado=true;

function firmaElectronicaDocumental(objConf)
{

	var objConf=eval('['+(objConf)+']')[0];
    var arrAccionesFirma=[];
    
    var x;
    var oAccion;
    for(x=0;x<objConf.arrAcciones.length;x++)
    {
    	oAccion=objConf.arrAcciones[x];
    	arrAccionesFirma.push([oAccion.idAccion,oAccion.etiquetaAccion]);
    }
    
   
    
   	var cmbAccionFirma=crearComboExt('cmbAccionFirma',arrAccionesFirma,150,5,300);
    cmbAccionFirma.on('select',function(cmb,registro)
    							{
                                	gEx('fSetFirma').disable();
                                	switch(registro.data.id)
                                    {
                                    	case '1':
                                        	gEx('fSetFirma').enable();
                                        break;
                                        case '2':
                                        break;
                                        case '3':
                                        break;
                                    }
                                }
    				)
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	
                                                            x:10,
                                                            y:10,
                                                            html:'Acci&oacute;n a realizar:'
                                                            
                                                        },
                                                        cmbAccionFirma,
                                                        {
                                                        	
                                                            x:10,
                                                            y:40,
                                                            html:'Comentarios adicionales:'
                                                            
                                                        },
                                                        {
                                                        	x:10,
                                                            y:70,
                                                            width:580,
                                                            heigt:60,
                                                            xtype:'textarea',
                                                            id:'txtComentariosAdicionales'
                                                        },
                                                        {
                                                        	id:'fSetFirma',
                                                        	xtype:'fieldset',
                                                            width:580,
                                                            x:10,
                                                            y:150,
                                                            height:110,
                                                            defaultType: 'label',
                                                            layout:'absolute',
                                                            disabled:true,
                                                            items:	[
                                                         				{
                                                                            x:10,
                                                                            y:10,
                                                                            html:'Ingrese su archivo de llave privada (*.key):'
                                                                        },
                                                                        {
                                                                            x:250,
                                                                            y:10,
                                                                            html:'<input type="file" style="width:250px">'
                                                                        },
                                                                        {
                                                                            x:10,
                                                                            y:40,
                                                                            html:'Ingrese su archivo de certificado digital (*.cer):'
                                                                        },
                                                                        {
                                                                            x:250,
                                                                            y:40,
                                                                            html:'<input type="file" style="width:250px">'
                                                                        },
                                                                        {
                                                                            x:10,
                                                                            y:70,
                                                                            html:'Ingrese la contrase&ntilde;a de llave privada:'
                                                                        },
                                                                        {
                                                                            x:250,
                                                                            y:65,
                                                                            width:250,
                                                                            id:'txtPassword',
                                                                            xtype:'textfield',
                                                                            inputType:'password'
                                                                        }   
                                                            		]
                                                        }
														

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Firmar documento',
										width: 625,
										height:350,
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
																	gEx('txtPassword').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: 'Aceptar',                                                            
															handler: function()
																	{
																		if(cmbAccionFirma.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	cmbAccionFirma.focus();
                                                                            }
                                                                            msgBox('Debe indicar la acci&oacute;n a realizar',resp);
                                                                            return;
                                                                        }
																		var objResultado={};
                                                                        objResultado.accion=cmbAccionFirma.getValue();
                                                                        objResultado.comentarios=gEx('txtComentariosAdicionales').getValue();
                                                                        objResultado.cadenaFirma='';
                                                                        
                                                                        
                                                                        if(cmbAccionFirma.getValue()=='1')
                                                                        {
                                                                        	objResultado.cadenaFirma='tOSe+Ex/wvn33YIGwtfmrJwQ31Crd7II9VcH63TGjHfxk5cfb3q9uSbDUGk9TXvo70ydOpikRVw+9B2Six0mbu3PjoPpO909oAYITrRyomdeUGJ4vmA2/12L86EJLWpU7vlt4cL8HpkEw7TOFhSdpzb/890+jP+C1adBsHU1VHc='
                                                                        }
                                                                        
                                                                        
                                                                        eval(objConf.funcionManejoResultado+'(objResultado);')
                                                                        
                                                                        ventanaAM.close();
																		
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