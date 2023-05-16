<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>

var oSeleccionado=null;
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
                                                title: '<span class="letraRojaSubrayada8" style="font-size:14px"><b>Arbol de problemas</b></span>',
                                                tbar:	[
                                                            {
                                                                icon:'../images/especial.png',
                                                                cls:'x-btn-text-icon',
                                                                disabled:gE('problemaCentral').value=='1',
                                                                text:'Agregar Problema Central',
                                                                handler:function()
                                                                        {
                                                                            mostrarVentanaProblemaCentral();
                                                                        }
                                                                
                                                            },'-',
                                                            {
                                                                icon:'../images/add.png',
                                                                cls:'x-btn-text-icon',
                                                                text:'Agregar Efecto',
                                                                disabled:gE('problemaCentral').value=='0',
                                                                handler:function()
                                                                        {
                                                                            mostrarVentanaEfecto();
                                                                        }
                                                                
                                                            },'-',
                                                            {
                                                                icon:'../images/area.png',
                                                                cls:'x-btn-text-icon',
                                                                text:'Agregar Causa',
                                                                disabled:gE('problemaCentral').value=='0',
                                                                handler:function()
                                                                        {
                                                                            mostrarVentanaCausa();
                                                                        }
                                                                
                                                            },'-',
                                                            {
                                                                icon:'../images/delete.png',
                                                                cls:'x-btn-text-icon',
                                                                id:'btnRemover',
                                                                disabled:true,
                                                                text:'Remover elemento seleccionado',
                                                                handler:function()
                                                                        {
                                                                            removerElementoSeleccionado();
                                                                        }
                                                                
                                                            }
                                                            
                                                        ],
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
                                         ]
                            }
                        )   

	gEx('frameContenido').load	(
    								{
                                    	url:'../planeacionEstrategica/canvasArbolProblemas.php',
                                        params:	{
                                        			idFormulario: gE('idFormulario').value,
                                                    idRegistro: gE('idRegistro').value,
                                                    cPagina:'sFrm=true'
                                        		}
    								}
    							)
                        
}


function mostrarVentanaProblemaCentral(iP,valorTexto)
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
                                                            html:'Problema Central:'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            xtype:'textarea',
                                                            width:600,
                                                            height:80,
                                                            value:valorTexto?escaparBR(valorTexto,true):'',
                                                            id:'txtProblemaCentral'
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: iP?'Editar Problema Central':'Agregar Problema Central',
										width: 650,
										height:225,
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
                                                                	gEx('txtProblemaCentral').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
																		var txtProblemaCentral=gEx('txtProblemaCentral');
                                                                        if(txtProblemaCentral.getValue()=='')
                                                                        {
                                                                        	function resp1()
                                                                            {
                                                                            	txtProblemaCentral.focus();
                                                                            }
                                                                            msgBox('Debe indicar el problema central a agregar/modificar',resp1);
                                                                            return;
                                                                        }
                                                                        
                                                                        var cadObj='{"idRegistro":"'+(iP?iP:-1)+'","iFormulario":"'+gE('idFormulario').value+'","iRegistro":"'+gE('idRegistro').value+'","problemaCentral":"'+cv(gEx('txtProblemaCentral').getValue())+'"}';
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                                redibujarEstructura(iP?iP:-1,'P');
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesPlaneacionEstrategica.php',funcAjax, 'POST','funcion=39&cadObj='+cadObj,true);
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

function mostrarVentanaEfecto(iP,valorTexto)
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
                                                            html:'Efecto:'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            xtype:'textarea',
                                                            width:600,
                                                            height:80,
                                                            value:valorTexto?escaparBR(valorTexto,true):'',
                                                            id:'txtEfecto'
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: iP?'Editar Efecto':'Agregar Efecto',
										width: 650,
										height:225,
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
                                                                	gEx('txtEfecto').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
																		var txtEfecto=gEx('txtEfecto');
                                                                        if(txtEfecto.getValue()=='')
                                                                        {
                                                                        	function resp1()
                                                                            {
                                                                            	txtEfecto.focus();
                                                                            }
                                                                            msgBox('Debe indicar el efecto a agregar/modificar',resp1);
                                                                            return;
                                                                        }
                                                                        
                                                                        var cadObj='{"idRegistro":"'+(iP?iP:-1)+'","iFormulario":"'+gE('idFormulario').value+'","iRegistro":"'+gE('idRegistro').value+'","efecto":"'+cv(gEx('txtEfecto').getValue())+'"}';
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                                redibujarEstructura(iP?iP:-1,'E');
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesPlaneacionEstrategica.php',funcAjax, 'POST','funcion=40&cadObj='+cadObj,true);
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

function mostrarVentanaCausa(iP,valorTexto)
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
                                                            html:'Causa:'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            xtype:'textarea',
                                                            width:600,
                                                            height:80,
                                                            value:valorTexto?escaparBR(valorTexto,true):'',
                                                            id:'txtCausa'
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: iP?'Editar Causa':'Agregar Causa',
										width: 650,
										height:225,
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
                                                                	gEx('txtCausa').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
																		var txtCausa=gEx('txtCausa');
                                                                        if(txtCausa.getValue()=='')
                                                                        {
                                                                        	function resp1()
                                                                            {
                                                                            	txtCausa.focus();
                                                                            }
                                                                            msgBox('Debe indicar la causa a agregar/modificar',resp1);
                                                                            return;
                                                                        }
                                                                        
                                                                        var cadObj='{"idRegistro":"'+(iP?iP:-1)+'","iFormulario":"'+gE('idFormulario').value+'","iRegistro":"'+gE('idRegistro').value+'","causa":"'+cv(gEx('txtCausa').getValue())+'"}';
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                                redibujarEstructura(iP?iP:-1,'C');
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesPlaneacionEstrategica.php',funcAjax, 'POST','funcion=41&cadObj='+cadObj,true);
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
function redibujarEstructura(idEditado,tNodo)
{
	desHabilitarBotonEliminar();
	gEx('frameContenido').load	(
    								{
                                    	url:'../planeacionEstrategica/canvasArbolProblemas.php',
                                        params:	{
                                        			idFormulario: gE('idFormulario').value,
                                                    idRegistro: gE('idRegistro').value,
                                                    idNodoEditado:idEditado,
                                                    tipoNodo:tNodo,
                                                    cPagina:'sFrm=true'
                                        		}
    								}
    							)
}

function setObjetoSeleccionado(objSeleccionado)
{
	oSeleccionado=objSeleccionado;
}

function editarObjeto(objSeleccionado)
{
	oSeleccionado=objSeleccionado;
	switch(objSeleccionado.tipo)
    {
    	case 'C':
        	mostrarVentanaCausa(objSeleccionado.id,objSeleccionado.texto);
        break;
        case 'E':
        	mostrarVentanaEfecto(objSeleccionado.id,objSeleccionado.texto);
        break;
        case 'P':
        	mostrarVentanaProblemaCentral(objSeleccionado.id,objSeleccionado.texto);
        break;
        
    }
}

function habilitarBotonEliminar()
{
	gEx('btnRemover').enable();
}

function desHabilitarBotonEliminar()
{
	gEx('btnRemover').disable();
}

function removerElementoSeleccionado()
{
	var cadObj='{"tipo":"'+oSeleccionado.tipo+'","idRegistro":"'+oSeleccionado.id+'"}';
	var lblLeyenda='';
	switch(oSeleccionado.tipo)
    {
    	case 'C':
        	lblLeyenda='Est&aacute; seguro de querer remover la causa seleccionada?';
        break;
        case 'E':
        	lblLeyenda='Est&aacute; seguro de querer remover el efecto seleccionado?';
        break;
        case 'P':
        	lblLeyenda='Est&aacute; seguro de querer remover el problema seleccionado?';
        break;
        
    }
    
    function resp(btn)
    {
    	if(btn=='yes')
        {
        	
            function funcAjax()
            {
                var resp=peticion_http.responseText;
                arrResp=resp.split('|');
                if(arrResp[0]=='1')
                {
                    redibujarEstructura(-1,0);
                    oSeleccionado=null;
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesPlaneacionEstrategica.php',funcAjax, 'POST','funcion=42&cadObj='+cadObj,true);
        }
    }
    msgConfirm(lblLeyenda,resp);
}