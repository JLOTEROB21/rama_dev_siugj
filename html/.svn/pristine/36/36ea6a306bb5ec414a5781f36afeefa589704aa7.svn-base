<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>


Ext.onReady(inicializar);

function inicializar()
{
    new Ext.Viewport(	{
                                layout: 'border',
                                items: [
                                            {
                                                xtype:'panel',
                                                region:'center',
                                                border:false,
                                                layout:'border',
                                                items:	[
                                                             new Ext.ux.IFrameComponent({ 

                                                                                        id: 'frameContenido', 
                                                                                        anchor:'100% 100%',
                                                                                        border:false,
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
                        
                        
	gEx('frameContenido').load({url:'../reportes/reportViewer2.php',params:{dispararEventos:0,cPagina:'sFrm=true',iR:gE('iR').value}});                        
}


function compartirReporte()
{
	var idUsuario=-1;
	
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
                                            cls:'panelSiugj',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Indique el usuario con el cual se compartir&aacute; el reporte'
                                                        },
                                                        {
                                                        	xtype:'label',
                                                            x:10,
                                                            y:50,
                                                            id:'lblDivAsignaTarea',
                                                            html:'<div id="divUsuarioAsigna" style="width:475px"></div>'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:110,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Comentarios adicionales'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:140,
                                                            width:600,
                                                            height:90,
                                                            cls:'SIUGJ_ControlEtiqueta',
                                                            xtype:'textarea',
                                                            id:'txtComentariosAdicionales'
                                                            
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Compartir reporte',
										width: 650,
										height:400,
										layout: 'fit',
										plain:true,
										modal:true,
                                        closable:false,
                                        cls:'msgHistorialSIUGJ',
										bodyStyle:'padding:5px;',
										buttonAlign:'center',
										items: form,
										listeners : {
													show : {
																buffer : 10,
																fn : function() 
																{
                                                                	 var oConf=	{
                                                                                    idCombo:'cmbUsuarioResponsable',
                                                                                    anchoCombo:450,
                                                                                    posX:0,
                                                                                    posY:0,
                                                                                    raiz:'registros',
                                                                                    campoDesplegar:'nombreUsuario',
                                                                                    campoID:'idRegistro',
                                                                                    funcionBusqueda:5,
                                                                                    renderTo:'divUsuarioAsigna',
                                                                                    ctCls:'campoComboWrapSIUGJAutocompletar',
                                                                                    listClass:'listComboSIUGJ',
                                                                                    paginaProcesamiento:'../paginasFunciones/funcionesProcesos.php',
                                                                                    confVista:'<tpl for="."><div class="search-item">[{idUsuario}] {nombreUsuario}<br>{adscripcion}<br>----</div></tpl>',
                                                                                    campos:	[
                                                                                                {name:'idUsuario'},
                                                                                                {name:'nombreUsuario'},
                                                                                                {name: 'adscripcion'}
                                                                  
                                                                                            ],
                                                                                    funcAntesCarga:function(dSet,combo)
                                                                                                {
                                                                                                    idUsuario=-1;
                                                                                                    var aValor=combo.getRawValue();
                                                                                                    dSet.baseParams.criterio=aValor;
                                                                                                    
                                                                                                                                          
                                                                                                    
                                                                                                },
                                                                                    funcElementoSel:function(combo,registro)
                                                                                                {
                                                                                                    idUsuario=registro.data.idUsuario;
                                                                                                    
                                                                                                }  
                                                                                };
                                                                                
                                                                                
                                                                		var cmbUsuarioResponsable=crearComboExtAutocompletar(oConf); 
                                                                        
                                                                        
                                                                        cmbUsuarioResponsable.focus(false,500);                
																}
															}
												},
										buttons:	[
                                        				{
															text: '<?php echo $etj["lblBtnCancelar"]?>',
                                                            cls:'btnSIUGJCancel',
                                                            width:140,
															handler:function()
																	{
																		ventanaAM.close();
																	}
														},
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            cls:'btnSIUGJ',
                                                            width:140,
															handler: function()
																	{
																		if(idUsuario==-1)
                                                                        {
                                                                        	msgBox('Debe seleccionar el usuario con el cual se compartira el reporte');
                                                                        	return;
                                                                        }
                                                                        
                                                                        
                                                                        var cadObj='{"idUsuarioDestinatario":"'+idUsuario+'","idReporte":"'+gE('iR').value+
                                                                        			'","comentariosAdicionales":"'+(gEx('txtComentariosAdicionales').getValue())+'"}';
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                                function resp()
                                                                                {
                                                                                	ventanaAM.close();
                                                                                }
                                                                                msgBox('Se ha compartido el reporte',resp);
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../modulosEspeciales_SIUGJ/paginasFunciones/funcionesSIUGJ.php',funcAjax, 'POST','funcion=36&cadObj='+cadObj,true);

                                                                        
                                                                        
																	}
														}
														
													]
									}
								);
	ventanaAM.show();
}