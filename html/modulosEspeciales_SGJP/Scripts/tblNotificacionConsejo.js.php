<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$consulta="SELECT idEtapaProcesal,descripcionEtapa,orden FROM 7009_etapasProcesales ORDER BY orden";
	$arrEtapasProcesales=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT idCategoria,nombreCategoria FROM 908_categoriasDocumentos";
	$arrCategorias=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT idCategoria,nombreCategoria FROM 908_categoriasDocumentos order by nombreCategoria";
	$arrTipoDocumento=$con->obtenerFilasArreglo($consulta);
?>	
var uploadControl;
var arrTipoDocumento=<?php echo $arrTipoDocumento?>;
var arrEtapasProcesales=<?php echo $arrEtapasProcesales?>;
var arrCategorias=<?php echo $arrCategorias?>;

var arrSituacionActual=[['1','En espera de envio a CJF'],['2','Enviado a CJF'],['3','No enviado al CJF (Error)']];
Ext.onReady(inicializar);

function inicializar()
{
	var arrPaneles=[];
    arrPaneles.push	(
    					{
                          xtype:'panel',
                          region:'center',
                          layout:'border',
                          items:	[
                                      crearGridNotificacionesConsejo()
                                     
                                  	]
                      	}
    				)
                    
	           

	 	arrPaneles.push	(
     						{
                                xtype:'panel',
                                region:'east',
                                border:false,
                                width:280,
                                layout:'border',
                                items:	[
                                            crearGridRespuestasJuecesCJF()
                                        ]
                            }
	    				)                    
               
    new Ext.Viewport(	{
                                layout: 'border',
                                border:false,
                                items: arrPaneles
                            }
                        )   
}


function crearGridNotificacionesConsejo()
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idNotificacion'},
		                                                {name:'fechaCreacion', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name: 'fechaEnvioCJF',type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name: 'situacion'},
                                                        {name: 'comentariosAdicionales'},                                                        
                                                        {name: 'lblDocumentosAdjuntos'},
                                                        {name: 'responsableCreacion'},
                                                        {name: 'responsableEnvio'},
                                                        {name: 'folioRecepcion'},
                                                        {name: 'mensajeCJF'},
                                                        {name: 'etiquetaJuez'},
                                                        {name: 'arrDocumentosAsociados'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
    
	var expander = new Ext.ux.grid.RowExpander({
                                                column:1,
                                                expandOnDblClick:false,
                                                tpl : new Ext.Template(
                                                    '<table >'+
														
                                                   		'<tr><td ><span class="TSJDF_Etiqueta"><b>Documentos adjuntos:</b><br><br></span><span class="TSJDF_Control">{lblDocumentosAdjuntos}</span><br /></td></tr>'+
                                                        '<tr><td ><span class="TSJDF_Etiqueta"><b>Comentarios Adicionales:</b><br><br></span><span class="TSJDF_Control">{comentariosAdicionales}</span><br /></td></tr>'+
                                                    '</table>'
                                                )
                                            });                                                                                         
                                                                                                                                                                                                                                                          
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../paginasFunciones/funcionesModulosEspeciales_SGP.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'fechaCreacion', direction: 'ASC'},
                                                            groupField: 'etiquetaJuez',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                   	
                                   		
                                    	proxy.baseParams.funcion='196';
                                        proxy.baseParams.idFormulario=gE('iFormulario').value;
                                        proxy.baseParams.idReferencia=gE('iRegistro').value;
                                        gEx('btnModifyNotificacion').disable();
                                        gEx('btnDeleteNotificacion').disable();
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer(),
                                                            expander,
                                                            
                                                            {
                                                                header:'',
                                                                width:130,
                                                                sortable:true,
                                                                dataIndex:'etiquetaJuez'
                                                            },
                                                            {
                                                                header:'ID Notificaci&oacute;n',
                                                                width:100,
                                                                sortable:true,
                                                                dataIndex:'idNotificacion'
                                                            },
                                                            {
                                                                header:'Fecha de registro',
                                                                width:130,
                                                                sortable:true,
                                                                dataIndex:'fechaCreacion',
                                                                renderer:function(val)
                                                                		{
                                                                        	if(val)
	                                                                			return val.format('d/m/Y H:i:s')
                                                                		}
                                                            },
                                                            {
                                                                header:'Responsable registro',
                                                                width:250,
                                                                sortable:true,
                                                                renderer:mostrarValorDescripcion,
                                                                dataIndex:'responsableCreacion'
                                                            },
                                                            {
                                                                header:'Situaci&oacute;n actual',
                                                                width:230,
                                                                sortable:true,
                                                                renderer:mostrarValorDescripcion,
                                                                dataIndex:'situacion',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	var comp='';
                                                                            if(registro.data.situacion=='3')
                                                                            	comp='&nbsp;<img src="../images/icon_comment.gif" title="'+registro.data.mensajeCJF+'" alt="'+registro.data.mensajeCJF+'">';
                                                                			return formatearValorRenderer(arrSituacionActual,val)+comp;
                                                                		}
                                                            },
                                                            {
                                                                header:'',
                                                                width:40,
                                                                sortable:true,
                                                                dataIndex:'idNotificacion',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	switch(registro.data.situacion)
                                                                            {
                                                                            	case '1':
                                                                                	return '<a href="javascript:enviarNotificacionCJF(\''+bE(val)+'\')"><img src="../images/email_go.png" title="Enviar Notificaci&oacute;n al CJF" alt="Enviar Notificaci&oacute;n al CJF"></a>';
                                                                                break;
                                                                                case '3':
                                                                                	return '<a href="javascript:enviarNotificacionCJF(\''+bE(val)+'\')"><img src="../images/arrow_refresh.PNG" title="Reenviar Notificaci&oacute;n al CJF" alt="Reenviar Notificaci&oacute;n al CJF"></a>'
                                                                                break;
                                                                                
                                                                            }
                                                                        }
                                                            },
                                                            {
                                                                header:'Fecha de env&iacute;o a CJF',
                                                                width:130,
                                                                sortable:true,
                                                                dataIndex:'fechaEnvioCJF',
                                                                renderer:function(val)
                                                                		{
                                                                        	if(val)
                                                                				return val.format('d/m/Y H:i:s')
                                                                		}
                                                            },
                                                            {
                                                                header:'Responsable envio a CJF',
                                                                width:250,
                                                                sortable:true,
                                                                renderer:mostrarValorDescripcion,
                                                                dataIndex:'responsableEnvio'
                                                            },
                                                             {
                                                                header:'Folio de recepci&oacute;n CJF',
                                                                width:160,
                                                                sortable:true,
                                                                renderer:mostrarValorDescripcion,
                                                                dataIndex:'folioRecepcion'
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gNotificaciones',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                border:false,
                                                                cm: cModelo,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                columnLines : true,
                                                                plugins:[expander] ,  
                                                                tbar:	[
																			{
																				icon:'../images/add.png',
																				cls:'x-btn-text-icon',
																				text:'Crear Notificaci&oacute;n',
																				handler:function()
																						{
																							mostrarVentanaNotificacion();
																						}

																			},'-',
																			{
																				id:'btnModifyNotificacion',
																				icon:'../images/pencil.png',
																				cls:'x-btn-text-icon',
																				text:'Modificar Notificaci&oacute;n',
																				handler:function()
																						{
																							var fila=gEx('gNotificaciones').getSelectionModel().getSelected();
																							if(!fila)
																							{
																								msgBox('Debe seleccionar la notificaci&oacute;n que desea modificar');
																								return;
																							}
																							
																							
																							
																							mostrarVentanaNotificacion(fila);
																						}

																			},'-',
																			{
																				icon:'../images/delete.png',
																				id:'btnDeleteNotificacion',
																				cls:'x-btn-text-icon',
																				text:'Remover Notificaci&oacute;n',
																				handler:function()
																						{
																							var fila=gEx('gNotificaciones').getSelectionModel().getSelected();
																							if(!fila)
																							{
																								msgBox('Debe seleccionar la notificaci&oacute;n que desea remover');
																								return;
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
																											gEx('gNotificaciones').getStore().reload();
                                                                                                            gEx('gReporteJuez').getStore().reload();
																										}
																										else
																										{
																											msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
																										}
																									}
																									obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=197&idNotificacion='+fila.data.idNotificacion,true);
																								}
																							}
																							msgConfirm('Est&aacute; seguro de querer remover la notificaci&oacute;n seleccionada?',resp);
																						}

																			}

																		]   ,                                                          
                                                                view:new Ext.grid.GroupingView({
                                                                                                    forceFit:false,
                                                                                                    showGroupName: false,
                                                                                                    enableGrouping :true,
                                                                                                    enableNoGroups:false,
                                                                                                    enableGroupingMenu:false,
                                                                                                    hideGroupedColumn: true,
                                                                                                    startCollapsed:false
                                                                                                })
                                                            }
                                                        );
        
        
        
	tblGrid.getSelectionModel().on('rowselect',function(sm,nFila,registro)
       												{
       													gEx('btnModifyNotificacion').disable();
                                   						gEx('btnDeleteNotificacion').disable();
                                   						if(registro.data.situacion=='1')
                                   						{
                                   							gEx('btnModifyNotificacion').enable();
                                   							gEx('btnDeleteNotificacion').enable();
                                   						}
       												}
        								)        
	
    tblGrid.getSelectionModel().on('rowdeselect',function(sm,nFila,registro)
       												{
       													gEx('btnModifyNotificacion').disable();
                                   						gEx('btnDeleteNotificacion').disable();
                                   						
       												}
        								)   
    
    return 	tblGrid;
}

function mostrarVentanaNotificacion(fila)
{
	var almacenDatos=eval(bD(gE('arrJuecesNotifica').value));
    if(fila)
    {
    	almacenDatos=[[true,fila.data.juezNotifica,fila.data.etiquetaJuez]];
    }
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:5,
                                                            y:10,
                                                            html:'Documentos a adjuntar en la notificaci&oacute;n:'
                                                        },
                                                        crearGridDocumentosNotificacion(fila),
                                                        {
                                                        	x:5,
                                                            y:160,
                                                            html:'La notificaci&oacute;n responde a la solicitudes hechas a los jueces:'
                                                        },
                                                        crearGridJuecesNotifica(almacenDatos),
                                                        {
                                                        	x:10,
                                                            y:300,
                                                            html:'Comentarios adicionales:'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:320,
                                                            xtype:'textarea',
                                                            width:600,
                                                            height:45,
                                                            id:'txtComentariosAdicionales',
                                                            value:fila?escaparBR(fila.data.comentariosAdicionales,true):''
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: fila?'Modificar notificaci&oacute;n':'Crear notificaci&oacute;n',
										width: 650,
										height:460,
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
																		var gDocumentosAdjuntar=gEx('gDocumentosAdjuntar');
                                                                        
                                                                        if(gDocumentosAdjuntar.getStore().getCount()==0)
                                                                        {
                                                                        	msgBox('Debe seleccionar almenos un documento a adjuntar');
                                                                        	return;
                                                                        }
                                                                        
                                                                        var filaAux;
                                                                       	var arrDocumentos='';
                                                                        var oDoc='';
                                                                        var x;
                                                                        for(x=0;x<gDocumentosAdjuntar.getStore().getCount();x++)
                                                                        {
                                                                        	filaAux=gDocumentosAdjuntar.getStore().getAt(x);
                                                                        	oDoc='{"idDocumento":"'+filaAux.data.idDocumento+'"}';	
                                                                            if(arrDocumentos=='')
                                                                            	arrDocumentos=oDoc;
                                                                            else
                                                                            	arrDocumentos+=','+oDoc;
                                                                        }
                                                                        var arrJuecesNotifica='';
                                                                        var gJuecesNotifica=gEx('gJuecesNotifica');
                                                                        for(x=0;x<gJuecesNotifica.getStore().getCount();x++)
                                                                        {
                                                                        	filaAux=gJuecesNotifica.getStore().getAt(x);
                                                                            if(filaAux.data.juezNotifica)
                                                                            {
                                                                                oDoc='{"idJuez":"'+filaAux.data.idJuez+'"}';	
                                                                                if(arrJuecesNotifica=='')
                                                                                    arrJuecesNotifica=oDoc;
                                                                                else
                                                                                    arrJuecesNotifica+=','+oDoc;
                                                                            }
                                                                        }
                                                                        
                                                                        if(arrJuecesNotifica=='')
                                                                        {
                                                                        	msgBox('Debe seleccionar almenos un juez asociado a la notificaci&oacute;n');
                                                                        	return;
                                                                        }
                                                                        
                                                                        var cadObj='{"idNotificacion":"'+(fila?fila.data.idNotificacion:-1)+
                                                                        			'","comentariosAdicionales":"'+cv(gEx('txtComentariosAdicionales').getValue())+
                                                                                    '","arrDocumentos":['+arrDocumentos+'],"idFormulario":"'+gE('iFormulario').value+
                                                                                    '","idReferencia":"'+gE('iRegistro').value+'","arrJuecesNotifica":['+arrJuecesNotifica+']}';
																	
                                                                    	
                                                                    	function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                                gEx('gNotificaciones').getStore().reload();
                                                                                gEx('gReporteJuez').getStore().reload();
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=195&cadObj='+cadObj,true);
                                                                    
                                                                    
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
    
    var reg=crearRegistro(	[
                            	{name:'idDocumento'},
		                        {name: 'nombreDocumento'}
                            ]
                          )
    
    var x;
    var r;
    for(x=0;x<fila.data.arrDocumentosAsociados.length;x++)
    {
    	r=new reg(fila.data.arrDocumentosAsociados[x]);
        gEx('gDocumentosAdjuntar').getStore().add(r);
    }
    gEx('gJuecesNotifica').disable();
}

function crearGridDocumentosNotificacion(fila)
{
	 var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idDocumento'},
		                                                {name: 'nombreDocumento'}
                                                   ],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../paginasFunciones/funcionesModulosEspeciales_SGP.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'nombreDocumento', direction: 'ASC'},
                                                            groupField: 'nombreDocumento',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:false
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	
                                    	proxy.baseParams.funcion='194';
                                        proxy.baseParams.idFormulario=gE('iFormulario').value;
                                        proxy.baseParams.idRegistro=gE('iRegistro').value;
                                        proxy.baseParams.idNotificacion=fila?fila.data.idNotificacion:-1;
                                        
                                    }
                        )   
       
       var chkRow=new Ext.grid.CheckboxSelectionModel();
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer(),
                                                            chkRow,
                                                            {
                                                                header:'',
                                                                width:30,
                                                                sortable:true,
                                                                dataIndex:'idDocumento',
                                                                renderer:function(val,meta,registro)
                                                                        {
                                                                            var arrNombre=registro.data.nombreDocumento.split('.');
                                                                            return '<img src="../imagenesDocumentos/16/file_extension_'+arrNombre[1].toLowerCase()+'.png" />'
                                                                        }
                                                            },
                                                            {
                                                                header:'Nombre del documento',
                                                                width:430,
                                                                sortable:true,
                                                                dataIndex:'nombreDocumento'
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gDocumentosAdjuntar',
                                                                store:alDatos,
                                                                x:10,
                                                                y:30,
                                                                width:600,
                                                                height:120,
                                                                frame:false,
                                                                cm: cModelo,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                columnLines : true,
                                                                sm:chkRow,
                                                                tbar:	[
                                                                            {
                                                                                icon:'../images/add.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Agregar documento',
                                                                                handler:function()
                                                                                        {
                                                                                            mostrarVentanaDocumentos();
                                                                                        }
                                                                                
                                                                            },'-',
                                                                            {
                                                                                icon:'../images/delete.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Remover documento',
                                                                                handler:function()
                                                                                        {
                                                                                         	var fila=gEx('gDocumentosAdjuntar').getSelectionModel().getSelected();
                                                                                            if(!fila)
                                                                                            {
                                                                                            	msgBox('Debe seleccionar el documento que nesea remover');
                                                                                            	return;
                                                                                            }   
                                                                                            
                                                                                            function resp(btn)
                                                                                            {
                                                                                            	if(btn=='yes')
                                                                                                {
                                                                                                	gEx('gDocumentosAdjuntar').getStore().remove(fila);
                                                                                                }
                                                                                           	}
                                                                                            msgConfirm('Est&aacute; seguro de querer remover el documento seleccionado?',resp);
                                                                                            
                                                                                        }
                                                                                
                                                                            }
                                                                            
                                                                        ],
                                                                view:new Ext.grid.GroupingView({
                                                                                                    forceFit:false,
                                                                                                    showGroupName: false,
                                                                                                    enableGrouping :false,
                                                                                                    enableNoGroups:false,
                                                                                                    enableGroupingMenu:false,
                                                                                                    hideGroupedColumn: false,
                                                                                                    startCollapsed:false
                                                                                                })
                                                            }
                                                        );
	
    
     tblGrid.on('rowdblclick',function(grid,rowIndex)
                              {
                              		var registro=grid.getStore().getAt(rowIndex);
                                    var arrNombre=registro.data.nombreDocumento.split('.');
                                  	mostrarVisorDocumentoProceso(arrNombre[1].toLowerCase(),registro.data.idDocumento,registro);
                                  
                              }
                  ) 
    
    return 	tblGrid;
}

function enviarNotificacionCJF(iN)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            gEx('gNotificaciones').getStore().reload();
            gEx('gReporteJuez').getStore().reload();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=198&idNotificacion='+bD(iN),true);
}

function crearGridRespuestasJuecesCJF()
{
	 var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idJuez'},
		                                                {name: 'etiquetaJuez'},
                                                        {name: 'statusNotificacion'}
                                                   ],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                              reader: lector,
                                              proxy : new Ext.data.HttpProxy	(

                                                                                {

                                                                                    url: '../paginasFunciones/funcionesModulosEspeciales_SGP.php'

                                                                                }

                                                                            ),
                                              sortInfo: {field: 'etiquetaJuez', direction: 'ASC'},
                                              groupField: 'etiquetaJuez',
                                              remoteGroup:false,
                                              remoteSort: true,
                                              autoLoad:true
                                              
                                          }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	
                                    	proxy.baseParams.funcion='225';
                                        proxy.baseParams.idFormulario=gE('iFormulario').value;
                                        proxy.baseParams.idRegistro=gE('iRegistro').value;
                                        
                                        
                                    }
                        )   
       
       

        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [		
                                                        	{
                                                                header:'Status<br>notificaci&oacute;n',
                                                                width:80,
                                                                align:'center',
                                                                sortable:true,
                                                                dataIndex:'statusNotificacion',
                                                                renderer:function(val)
                                                                			{
                                                                            	switch(val)
                                                                                {
                                                                                	case '0':
                                                                                    	return '<img src="../images/exclamation.png" width="14" height="14" title="Sin notificaci&oacute;n programada" alt="Sin notificaci&oacute;n programada">';
                                                                                    break;
                                                                                    case '2':
                                                                                    	return '<img src="../images/icon_big_tick.gif" width="14" height="14" title="Enviado a CJF" alt="Enviado a CJF">';
                                                                                    break;
                                                                                    case '1':
                                                                                    	return '<img src="../images/control_pause.png" width="14" height="14" title="En espera de env&iacute;o a CJF" alt="En espera de env&iacute;o a CJF">';
                                                                                    break;
                                                                                    case '3':
                                                                                    	return '<img src="../images/cancel_round.png" width="14" height="14" title="No enviado al CJF (Error)" alt="No enviado al CJF (Error)">';
                                                                                    break;
                                                                                }
                                                                            }
                                                            },
                                                            {
                                                                header:'Juez',
                                                                width:180,
                                                                sortable:true,
                                                                dataIndex:'etiquetaJuez'
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gReporteJuez',
                                                                store:alDatos,
                                                               	region:'center',
                                                                width:280,
                                                                frame:false,
                                                                cm: cModelo,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                columnLines : true,

                                                                view:new Ext.grid.GroupingView({
                                                                                                    forceFit:false,
                                                                                                    showGroupName: false,
                                                                                                    enableGrouping :false,
                                                                                                    enableNoGroups:false,
                                                                                                    enableGroupingMenu:false,
                                                                                                    hideGroupedColumn: false,
                                                                                                    startCollapsed:false
                                                                                                })
                                                            }
                                                        );
        return 	tblGrid;
}



/////
function mostrarVentanaDocumentos()
{
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'border',
											defaultType: 'label',
											items: 	[
                                            			crearGridDocumentos()
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar documentos',
                                        id:'vAddDocumentos',
										width: 950,
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
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
															handler: function()
																	{
                                                                    	var filas=gEx('gridDocumentos').getSelectionModel().getSelections();
                                                                       
                                                                       	if(filas.length==0)
                                                                        {
                                                                        	msgBox('Debe seleccionar almenos un documento a adjuntar en la notificaci&oacute;n');
                                                                        	return;
                                                                        }
                                                                       	
                                                                        var x;
                                                                        var f;
                                                                        var r;
                                                                        var pos;
                                                                        var reg=crearRegistro(
                                                                        						[
                                                                                                	{name:'idDocumento'},
                                                                                                    {name:'nombreDocumento'}
                                                                                                ]
                                                                        					)
                                                                        for(x=0;x<filas.length;x++)
                                                                        {
                                                                        	f=filas[x];
                                                                            pos=obtenerPosFila(gEx('gDocumentosAdjuntar').getStore(),'idDocumento',f.data.idDocumento);
                                                                            if(pos==-1)
                                                                            {
                                                                            
                                                                                r=new reg	(
                                                                                                {
                                                                                                    idDocumento:f.data.idDocumento,
                                                                                                    nombreDocumento:f.data.nomArchivoOriginal
                                                                                                }	
                                                                                            )
                                                                                gEx('gDocumentosAdjuntar').getStore().add(r);
                                                                           	}
                                                                            
                                                                            
                                                                        }
                                                                        
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
    dispararEventoSelectCombo('cmbOridenDocumentos');
}

function crearGridDocumentos()
{
	var cmbOridenDocumentos=crearComboExt('cmbOridenDocumentos',[['1','Carpeta de Amparo'],['2','Documentos del proceso']],0,0,250);
    cmbOridenDocumentos.setValue('2');
    cmbOridenDocumentos.on('select',function(cmb,registro)
    								{
                                    	switch(parseInt(registro.data.id))
                                        {
                                        	case 1:
                                            	urlConsultaDocumentos='../paginasFunciones/funcionesModulosEspeciales_SGP.php';                                            	
                                            	gEx('gridDocumentos').getStore().load	(
                                                                                            {
                                                                                                params:	{
                                                                                                            funcion:19,
                                                                                                            cA:bE(gE('carpetaAdministrativa').value),
                                                                                                            idCarpetaAdministrativa:gE('idCarpetaAdministrativa').value
                                                                                                        }
                                                                                            }
                                                                                        )
                                            	
                                            break;
                                            case 2:
												urlConsultaDocumentos='../paginasFunciones/funcionesModulosEspeciales_Notificaciones.php';
                                                gEx('gridDocumentos').getStore().load	(
                                                                                            {
                                                                                                
                                                                                                params:	{
                                                                                                            funcion:11,
                                                                                                            idFormulario:gE('iFormulario').value,
                                                                                                            idRegistro:gE('iRegistro').value
                                                                                                        }
                                                                                            }
                                                                                        )
                                            	
                                            break;
                                        }
                                    }
    					)
    
    
	var cmbTipoDocumento=crearComboExt('cmbTipoDocumento',arrCategorias);
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idDocumento'},
		                                                {name: 'etapaProcesal'},
		                                                {name:'nomArchivoOriginal'},
		                                                {name: 'tamano'},
                                                        {name: 'fechaRegistro', type:'date', dateFormat:'Y-m-d'},
                                                        {name: 'fechaCreacion', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name: 'descripcion'},
                                                        {name:'idFormulario'},
                                                        {name:'idRegistro'},
                                                        {name:'idDocumento'},
                                                        {name: 'categoriaDocumentos'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                reader: lector,
                                                proxy : new Ext.data.HttpProxy	(

                                                                                  {

                                                                                      url: '../paginasFunciones/funcionesModulosEspeciales_SGP.php'

                                                                                  }

                                                                              ),
                                                sortInfo: {field: 'fechaRegistro', direction: 'ASC'},
                                                groupField: 'fechaRegistro',
                                                remoteGroup:false,
                                                remoteSort: false,
                                                autoLoad:false
                                                
                                            }) 
	alDatos.on('beforeload',function(proxy)
    								{

                                    	proxy.proxy.conn.url=urlConsultaDocumentos;
                                    }
                        )   
       
    
    
    var filters = new Ext.ux.grid.GridFilters	(
    												{
                                                    	filters:	[ 
                                                        				{type: 'date', dataIndex: 'fechaCreacion'},
                                                                        {type: 'string', dataIndex: 'nomArchivoOriginal'},
                                                                        {type: 'list', dataIndex: 'categoriaDocumentos', phpMode:true, options:arrCategorias}
                                                                    ]
                                                    }
                                                );    
       
	  

	var chkRow=new Ext.grid.CheckboxSelectionModel();
       
    var cModelo= new Ext.grid.ColumnModel   	(
                                                    [
                                                    	new  Ext.grid.RowNumberer({width:30}),
                                                        chkRow,
                                                        {
                                                            header:'',
                                                            width:30,
                                                            sortable:true,
                                                            dataIndex:'idDocumento',
                                                            renderer:function(val,meta,registro)
                                                            		{
                                                                    	var arrNombre=registro.data.nomArchivoOriginal.split('.');
                                                                        return '<img src="../imagenesDocumentos/16/file_extension_'+arrNombre[1].toLowerCase()+'.png" />'
                                                                    }
                                                        },
                                                        {
                                                            header:'Fecha de registro',
                                                            width:120,
                                                            sortable:true,
                                                            dataIndex:'fechaRegistro',
                                                            renderer:function(val)
                                                            		{
                                                                    	if(val)
                                                                    		return val.format('d/m/Y');
                                                                    }
                                                        },
                                                        {
                                                            header:'Tipo documento',
                                                            width:150,
                                                            sortable:true,
                                                            dataIndex:'categoriaDocumentos',
                                                            editor:cmbTipoDocumento,
                                                            renderer:function(val)
                                                            		{
                                                                    	return formatearValorRenderer(arrCategorias,val);
                                                                    }
                                                        },
                                                        {
                                                            header:'Etapa procesal',
                                                            width:250,
                                                            hidden:true,
                                                            sortable:true,
                                                            dataIndex:'etapaProcesal',
                                                            renderer:function(val)
                                                            		{
                                                                    	return formatearValorRenderer(arrEtapasProcesales,val);
                                                                    }
                                                        },
                                                        {
                                                            header:'Documento',
                                                            width:420,
                                                            sortable:true,
                                                            dataIndex:'nomArchivoOriginal',
                                                            renderer:mostrarValorDescripcion
                                                        },
                                                        
                                                        {
                                                            header:'Tama&ntilde;o',
                                                            width:100,
                                                            sortable:true,
                                                            dataIndex:'tamano',
                                                            renderer:function(val)
                                                            		{
                                                                    	return bytesToSize(parseInt(val),0);
                                                                    }
                                                        }
                                                        
                                                    ]
                                                );
                                                
    var tblGrid=	new Ext.grid.GridPanel	(
                                                        {
                                                            id:'gridDocumentos',
                                                            store:alDatos,
                                                            region:'center',
                                                            frame:false,
                                                            cm: cModelo,
                                                            sm:chkRow,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            tbar:	[
                                                            			{
                                                                        	xtype:'label',
                                                                            html:'<b>Origen de los documentos:&nbsp;&nbsp;</b>'
                                                                        },
                                                                        cmbOridenDocumentos,'-',
                                                                        {
                                                                            icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Adjuntar documento',
                                                                            handler:function()
                                                                                    {
                                                                                        mostrarVentanaAdjuntarDocumento()
                                                                                    }
                                                                            
                                                                        }
                                                            		],
                                                            columnLines : true,  
                                                            plugins:[filters],   
                                                            view:new Ext.grid.GroupingView({
                                                                                                forceFit:false,
                                                                                                showGroupName: false,
                                                                                                enableGrouping :false,
                                                                                                enableNoGroups:false,
                                                                                                enableGroupingMenu:false,
                                                                                                hideGroupedColumn: false,
                                                                                                startCollapsed:false,
                                                                                                groupTextTpl:'<span style="color:#900"><b>{text}</b> ({[values.rs.length]} {[values.rs.length > 1 ? "Documentos" : "Documento"]})</span>'
                                                                                            })
                                                        }
                                                    );
                                                    
	
    
    
    tblGrid.on('rowdblclick',function(grid,rowIndex)
                              {
                              		var registro=grid.getStore().getAt(rowIndex);
                                    var arrNombre=registro.data.nomArchivoOriginal.split('.');
                                  	mostrarVisorDocumentoProceso(arrNombre[1].toLowerCase(),registro.data.idDocumento,registro);
                                  
                              }
                  )                                                    
                                                    
    return 	tblGrid;	
}

function mostrarVentanaAdjuntarDocumento()
{

	/*var idRegistroAux=gE('idRegistroAux').value;
    if(idRegistroAux=='-1')
    {
    	msgBox('Primero debe guardar el formato de captura');
    	return;
    }*/

	var tabla='<div><input type="text" id="txtFileName" disabled="true" style="border: solid 1px; background-color: #FFFFFF; width: 290px" /></div><div class="flash" id="fsUploadProgress">'+ 
					'</div><input type="hidden" name="hidFileID" id="hidFileID" value="" /> ';       					
					
	var cmbTipoDocumento=crearComboExt('cmbTipoDocumento',arrTipoDocumento,185,5,350);

	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	xtype:'label',
                                                            x:10,
                                                            y:10,
                                                            html:'Tipo de documento a adjuntar:'
                                                        },
                                                        cmbTipoDocumento,
                                                        {
                                                        	xtype:'label',
                                                            x:10,
                                                            y:40,
                                                            html:'Ingrese el documento a adjuntar:'
                                                        },
                                                        {
                                                            x:185,
                                                            y:35,
                                                            html:	'<table width="290"><tr><td><div id="uploader"><p>Your browser doesn\'t have Flash, Silverlight or HTML5 support.</p></div></td></tr><tr id="filaAvance" style="display:none"><td align="right">Porcentaje de avance: <span id="porcentajeAvance"> 0%</span></td></tr></table>'
                                                        },
                                                       
                                                        {
                                                            x:480,
                                                            y:36,
                                                            id:'btnUploadFile',
                                                            xtype:'button',
                                                            text:'Seleccionar...',
                                                            handler:function()
                                                                    {
                                                                        $('#containerUploader').click();
                                                                    }
                                                        },
							 {
                                                            x:185,
                                                            y:10,
                                                            hidden:true,
                                                            html:	'<div id="containerUploader"></div>'
                                                        },
							
                                                        
                                                        {
                                                            x:290,
                                                            y:0,
                                                            xtype:'hidden',
                                                            id:'idArchivo'

                                                        },
                                                        {
                                                            x:290,
                                                            y:0,
                                                            xtype:'hidden',
                                                            id:'nombreArchivo'
                                                        } ,
                                                        {
                                                        	xtype:'label',
                                                            x:10,
                                                            y:70,
                                                            html:'Descripci&oacute;n:'
                                                        },
                                                        {
                                                        	xtype:'textarea',
                                                            x:10,
                                                            y:100,
                                                            width:600,
                                                            height:60,
                                                            id:'txtDescripcion'
                                                        }

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Adjuntar documento',
										width: 650,
                                        id:'vDocumento',
										height:250,
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
                                                                
                                                                	var cObj={
                                                                    // Backend settings
                                                                                            upload_url: "../modulosEspeciales_SGJP/procesarComprobante.php", //lquevedor
                                                                                            file_post_name: "archivoEnvio",
                                                                             
                                                                                            // Flash file settings
                                                                                            file_size_limit : "1000 MB",
                                                                                            file_types : "*.pdf;*.jpg;*.jpeg;*.gif;*.png",			// or you could use something like: "*.doc;*.wpd;*.pdf",
                                                                                            file_types_description : "Todos los archivos",
                                                                                            file_upload_limit : 0,
                                                                                            file_queue_limit : 1,
                                                                             
                                                                                           
                                                                                            upload_success_handler : subidaCorrecta
                                                                                        };
                                                                	crearControlUploadHTML5(cObj);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
															handler: function()
																	{
                                                                    	if(cmbTipoDocumento.getValue()=='')
                                                                        {
                                                                        	function resp1()
                                                                            {
                                                                            	cmbTipoDocumento.focus();
                                                                            }
                                                                            msgBox('Debe indicar el tipo de documento adjuntar');
                                                                            return;
                                                                        }
                                                                    	
																		
                                                                        if(uploadControl.files.length==0)
                                                                        {
                                                                            msgBox('Debe ingresar el documento que desea adjuntar');
                                                                            return;
                                                                        }
                                                                        uploadControl.start();
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

function subidaCorrecta(file, serverData) 
{


    file.id = "singlefile";	// This makes it so FileProgress only makes a single UI element, instead of one for each file
    var arrDatos=serverData.split('|');

    if ( arrDatos[0]!='1') 
    {
    	
      
    } 
    else 
    {
        
        gEx("idArchivo").setValue(arrDatos[1]);
        gEx("nombreArchivo").setValue(arrDatos[2]);
       	if( gE('txtFileName'))
        	gE('txtFileName').value=arrDatos[2];
        
        
        if(gEx('cmbOridenDocumentos').getValue()=='1')
        {
            var cadObj='{"carpetaAdministrativa":"'+carpetaAdministrativa+'","idFormulario":"-1","idRegistro":"-1","idArchivo":"'+arrDatos[1]+'","nombreArchivo":"'+arrDatos[2]+
            '","tipoDocumento":"'+gEx('cmbTipoDocumento').getValue()+'","descripcion":"'+cv(gEx('txtDescripcion').getValue())+
            '","idOrden":"0","noDocumentoNotificacion":"1"}';
        
            function funcAjax2(peticion_http)
            {
                var resp=peticion_http.responseText;
                
                arrResp=resp.split('|');
                if(arrResp[0]=='1')
                {
                    var reg=crearRegistro(
                                            [
                                                {name:'idDocumento'},
                                                {name:'nombreDocumento'}
                                            ]
                                        )
                    
                        
                    r=new reg	(
                                    {
                                        idDocumento:arrResp[1],
                                        nombreDocumento:arrDatos[2]
                                    }	
                                )
                    gEx('gDocumentosAdjuntar').getStore().add(r);
                    gEx('vAddDocumentos').close();
                    gEx('vDocumento').close();                
                }
                else
                {
                    
                    msgBox('No se pudo guardar el documento debido al siguiente error: <br><br />'+arrResp[0]);
                }
            }
            obtenerDatosWebV2('../paginasFunciones/funcionesModulosEspeciales_Notificaciones.php',funcAjax2, 'POST','funcion=8&cadObj='+cadObj,false);
        }
        else
        {
        	var cadObj='{"carpetaAdministrativa":"'+carpetaAdministrativa+'","idFormulario":"'+gE('iFormulario').value+'","idRegistro":"'+gE('iRegistro').value+'","idArchivo":"'+arrDatos[1]+'","nombreArchivo":"'+arrDatos[2]+
            '","tipoDocumento":"'+gEx('cmbTipoDocumento').getValue()+'","descripcion":"'+cv(gEx('txtDescripcion').getValue())+
            '","idOrden":"0","noDocumentoNotificacion":"1"}';
        
            function funcAjax2(peticion_http)
            {
                var resp=peticion_http.responseText;
                
                arrResp=resp.split('|');
                if(arrResp[0]=='1')
                {
                   var reg=crearRegistro(
                                            [
                                                {name:'idDocumento'},
                                                {name:'nombreDocumento'}
                                            ]
                                        )
                    
                        
                    r=new reg	(
                                    {
                                        idDocumento:arrResp[1],
                                        nombreDocumento:arrDatos[2]
                                    }	
                                )
                    gEx('gDocumentosAdjuntar').getStore().add(r);
                    gEx('vAddDocumentos').close();
                    gEx('vDocumento').close();                     
                }
                else
                {
                    
                    msgBox('No se pudo guardar el documento debido al siguiente error: <br><br />'+arrResp[0]);
                }
            }
            obtenerDatosWebV2('../paginasFunciones/funcionesModulosEspeciales_Notificaciones.php',funcAjax2, 'POST','funcion=12&cadObj='+cadObj,false);
        }
        
        
    }
		
	
}


function crearGridJuecesNotifica(dsDatos)
{

    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'juezNotifica'},
                                                                    {name: 'idJuez'},
                                                                    {name: 'nombreJuez'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var checkColumn = new Ext.grid.CheckColumn	(
	 												{
													   header: '',
													   dataIndex: 'juezNotifica',
													   width: 60

													}
												);
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	checkColumn,
														{
															header:'Juez',
															width:350,
															sortable:true,
															dataIndex:'nombreJuez'
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            
                                                            store:alDatos,
                                                            frame:false,
                                                            y:180,
                                                            x:10,
                                                            plugins:checkColumn,
                                                            id:'gJuecesNotifica',
                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            stripeRows :true,
                                                            columnLines : false,
                                                            height:110,
                                                            width:600

                                                        }
                                                    );
	return 	tblGrid;	
}


function mostrarDocumentoListado(nomArchivoOriginal,idDocumento)
{
	var arrNombre=bD(nomArchivoOriginal).split('.');
	mostrarVisorDocumentoProceso(arrNombre[1].toLowerCase(),bD(idDocumento));
}