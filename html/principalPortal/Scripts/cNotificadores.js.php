<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>

var arrTipoSolicitud=[['1','Derivada de Determinaci\xF3n'],['2','Derivada de audiencia']];

function mostrarVentanaAperturaNotificacionJUD(obj)
{
	var obj=eval('['+bD(obj)+']')[0];


	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            html:'Carpeta Judicial:'
                                                        },
                                                        {
                                                        	x:180,
                                                            y:10,
                                                            html:'<span style="color:#900; font-weight:bold" id="lblCarpeta"></span>'
                                                        },
                                                        
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            html:'Tipo notificaci&oacute;n:'
                                                        },
                                                         {
                                                        	x:180,
                                                            y:40,
                                                            html:'<span style="color:#900; font-weight:bold" id="lblTipoCarpeta"></span>'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:70,
                                                            hidden:true,
                                                            id:'lblNombreDeterminacion',
                                                            html:'Nombre de la determinaci&oacute;n:'
                                                        },
                                                        
                                                        {
                                                            x:10,
                                                            y:100,
                                                            id:'lblFechaDeterminacion',
                                                            xtype:'label',
                                                            html:''
                                                        },
                                                        {
                                                            x:10,
                                                            y:70,
                                                            hidden:true,
                                                            xtype:'label',
                                                            id:'lblAudienciaDeriva',
                                                            html:'Audiencia de la cual deriva:'
                                                        },
                                                        {
                                                        	x:180,
                                                            y:70,                                                           
                                                            id:'lblFechaAudiencia',
                                                            html:'<span style="color:#900; font-weight:bold" title="" alt="" id="etLblFecha"></span>'
                                                        },
                                                        {
                                                            xtype:'label',
                                                            x:180,
                                                            y:100,                                                           
                                                            id:'dteFechaDterminacion',
                                                            html:'<span style="color:#900; font-weight:bold" id="etLblFechaDeterminacion"></span>'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:130,
                                                            html:'Comentarios adicionales:'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:150,
                                                            xtype:'textarea',
                                                            id:'txtComentariosAdicionales',
                                                            readOnly:true,
                                                           	width:820,
                                                            hight:25,
                                                            value:''
                                                        },
                                                        {
                                                        	xtype:'tabpanel',
                                                            id:'fArchivos',
                                                            x:10,
                                                            y:225,
                                                            width:820,
                                                            height:165,
                                                            activeTab:0,
                                                            items:	[
                                                            			{
                                                                        	xtype:'panel',
                                                                            layout:'border',                                                                           
                                                                            region:'center',
                                                                            title:'Documentos a notificar',
                                                                            items:	[
                                                                            
                                                                            			crearVistaDocumentosAdjuntos(obj.idOrden)
                                                                            		]
                                                                        },
                                                                        {
                                                                        	xtype:'panel',
                                                                            layout:'border',                                                                           
                                                                            region:'center',
                                                                            title:'Notificadores asignados',
                                                                            items:	[
                                                                            			crearGridNotificadoresAsignados(obj.idOrden)
                                                                            			
                                                                            		]
                                                                        }
                                                                        
                                                                        
                                                            		]
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Orden de notificaci&oacute;n, Folio: <b><span style="color:#900" id="lblFolio"></span></b>',
										width: 880,
										height:470,
										layout: 'fit',
										plain:true,
										modal:true,
                                        id:'vOrden',
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
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        
            var objSol=eval(arrResp[1])[0];
            gE('lblFolio').innerHTML=objSol.folioOrden;
            gE('lblCarpeta').innerHTML=objSol.carpetaJudicial;
            gE('lblTipoCarpeta').innerHTML=formatearValorRenderer(arrTipoSolicitud,objSol.tipoNotificacion);
            gEx('txtComentariosAdicionales').setValue(escaparBR(objSol.comentariosAdicionales));
            gE('etLblFecha').innerHTML=objSol.descripcionNotificacion.substr(0,100)+(objSol.length>100?'...':'');
            gE('etLblFechaDeterminacion').innerHTML=Date.parseDate(objSol.fechaDeterminacion,'Y-m-d').format('d/m/Y');
            if(objSol.tipoNotificacion=='1')
            {
            	gE('lblFechaDeterminacion').innerHTML='Fecha de la determinaci&oacute;n:'
                gEx('lblNombreDeterminacion').show();
            }
            else
            {
            	gE('lblFechaDeterminacion').innerHTML='Fecha del auto:';
                gEx('lblAudienciaDeriva').show();
            }
           

        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_Notificaciones.php',funcAjax, 'POST','funcion=13&iO='+obj.idOrden,true);
   
    	
}

function crearVistaDocumentosAdjuntos(idOrden)
{
	var plantilla=new Ext.XTemplate(
                                        '<ul>',
                                            '<tpl for=".">',
                                                '<li class="elemento" title="{nombreDocumento}" alt="{nombreDocumento}">',
                                                    '<img src="../imagenesDocumentos/32/file_extension_{extension}.png"><br>',
                                                    '<span>{nombreDocumentoCorto}</span><br>',
                                                    '<span>{tamanoDocumento}</span>',
                                                '</li>',
                                            '</tpl>',
                                        '</ul>'
                                    );    
   
                                                                                      
	var alDatos=new Ext.data.JsonStore({
                                            root:'registros',
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name: 'idDocumento'},
		                                                {name: 'nombreDocumento'},
                                                        {name: 'nombreDocumentoCorto'},
		                                                {name: 'tamanoDocumento'},
		                                                {name: 'fechaDocumento'},
                                                        {name: 'extension'}
                                                        
                                            		],
                                            proxy : new Ext.data.HttpProxy	(
                                                                                  {
                                                                                      url: '../paginasFunciones/funcionesModulosEspeciales_Notificaciones.php'
                                                                                  }

                                                                              ),
                                            autoLoad:true
                                        })   
       
     
	    
     
    alDatos.on('beforeload',function(proxy)
    								{
                                    	registroDocumentoSel=null;
                                    	proxy.baseParams.funcion='3';
                                        proxy.baseParams.iO=idOrden;
                                        
                                    }
                        )   
       
    var vista=new Ext.DataView(
                                    {
                                        tpl: plantilla,                                        
                                        id:'vistaDocuentosAdjuntos',
                                       	width:800,
                                        height:155,
                                        autoScroll  : true,
                                        singleSelect: true,
                                        region:'center',
                                        border:true,
                                        overClass:'x-view-over',
                                        itemSelector: 'li.elemento',
                                        emptyText : '<div style="padding:10px;">No existen documentos registrados</div>',
                                        store:alDatos
                                    }
                                 )    
                                 
	vista.on('dblclick',function(dv,idx,nodo,e)
                      {
                          registroDocumentoSel=gEx('vistaDocuentosAdjuntos').getRecord(nodo);
                          mostrarVisorDocumentoProceso(registroDocumentoSel.data.extension,registroDocumentoSel.data.idDocumento,registroDocumentoSel);
                      }
              )                                  
                                                                        
     vista.on('click',function(dv,idx,nodo,e)
                      {
                          registroDocumentoSel=gEx('vistaDocuentosAdjuntos').getRecord(nodo);
                          
                      }
              )
                                             
	return   vista;                                 
                                    
}


function mostrarVentanaAsignacionNotificador(idOrden)
{
	var cmbNotificadores=crearComboExt('cmbNotificadores',[],180,5,330);
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            html:'Notificador a asignar:'
                                                        },
                                                        cmbNotificadores,
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            html:'Comentarios adicionales:'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:70,
                                                            xtype:'textarea',
                                                            width:580,
                                                            height:80,
                                                            id:'txtComentariosAdicionales'
                                                        }	
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Asignar notificador',
										width: 630,
										height:230,
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
                                                                	gEx('cmbNotificadores').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
															handler: function()
																	{
																		if(cmbNotificadores.getValue()=='')
                                                                        {
                                                                        	msgBox('Debe seleccionar al notificador al cual asignar&aacute; la orden de notificaci&oacute;n');
                                                                        	return;
                                                                        }
                                                                        
                                                                        
                                                                        function respConf(btn)
                                                                        {
                                                                        	if(btn=='yes')
                                                                            {
                                                                                var cadObj='{"idOrden":"'+idOrden+'","idNotificador":"'+cmbNotificadores.getValue()+
                                                                                        '","comentariosAdicionales":"'+cv(gEx('txtComentariosAdicionales').getValue())+'"}';
                                                                                
                                                                                function funcAjax()
                                                                                {
                                                                                    var resp=peticion_http.responseText;
                                                                                    arrResp=resp.split('|');
                                                                                    if(arrResp[0]=='1')
                                                                                    {
                                                                                        gEx('gridNotificadores').getStore().reload();
                                                                                        if(gEx('gOrdenesNotificacion'))
                                                                                        {
                                                                                        	gEx('gOrdenesNotificacion').getStore().reload();
                                                                                        }
                                                                                        ventanaAM.close();
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                    }
                                                                                }
                                                                                obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_Notificaciones.php',funcAjax, 'POST','funcion=16&cadObj='+cadObj,true); 
                                                                         	}
                                                                        }
                                                                    	msgConfirm('Est&aacute; seguro de querer asignar el notificador: <b>'+cmbNotificadores.getRawValue()+'</b>?',respConf);
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
                                

                                                                     
    
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            var arrRegistros=eval(arrResp[1]);
            gEx('cmbNotificadores').getStore().loadData(arrRegistros);
            ventanaAM.show();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_Notificaciones.php',funcAjax, 'POST','funcion=15&idOrden='+idOrden,true);                                
		
}

function crearGridNotificadoresAsignados(idOrden)
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idNotificador'},
		                                                {name: 'notificador'},
		                                                {name:'fechaAsignacion', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name: 'comentariosAdicionales'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                              reader: lector,
                                              proxy : new Ext.data.HttpProxy	(

                                                                                {

                                                                                    url: '../paginasFunciones/funcionesModulosEspeciales_Notificaciones.php'

                                                                                }

                                                                            ),
                                              sortInfo: {field: 'fechaAsignacion', direction: 'ASC'},
                                              groupField: 'fechaAsignacion',
                                              remoteGroup:false,
                                              remoteSort: false,
                                              autoLoad:true
                                              
                                          }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='14';
                                        proxy.baseParams.idOrden=idOrden;
                                    }
                        )   
       
    var cModelo= new Ext.grid.ColumnModel   	(
                                                    [
                                                        new  Ext.grid.RowNumberer(),
                                                        
                                                        {
                                                            header:'Notificador',
                                                            width:300,
                                                            sortable:true,
                                                            dataIndex:'notificador',
                                                            renderer:mostrarValorDescripcion
                                                        },
                                                        {
                                                            header:'Fecha de asignaci&oacute;n',
                                                            width:150,
                                                            sortable:true,
                                                            dataIndex:'fechaAsignacion',
                                                            renderer:function(val)
                                                            		{
                                                                    	return val.format('d/m/Y H:i');
                                                                    }
                                                        },
                                                         {
                                                            header:'Comentarios adicionales',
                                                            width:450,
                                                            sortable:true,
                                                            dataIndex:'comentariosAdicionales',
                                                            renderer:mostrarValorDescripcion
                                                        }
                                                    ]
                                                );
                                                
    var tblGrid=	new Ext.grid.GridPanel	(
                                                        {
                                                            id:'gridNotificadores',
                                                            store:alDatos,
                                                            region:'center',
                                                            frame:false,
                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            columnLines : true,
                                                            tbar:	[
                                                            			{
                                                                            
                                                                            id:'btnEnviarJUD',
                                                                            xtype:'button',
                                                                            icon:'../images/user_go.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Asignar a Notificador',
                                                                            handler:function()
                                                                                    {
                                                                                        mostrarVentanaAsignacionNotificador(idOrden);
                                                                                        
                                                                                        
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
    return 	tblGrid;
}

function mostrarVentanaAperturaNotificacionNotificador(obj)
{
	var obj=eval('['+bD(obj)+']')[0];
    
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            html:'Carpeta Judicial:'
                                                        },
                                                        {
                                                        	x:180,
                                                            y:10,
                                                            html:'<span style="color:#900; font-weight:bold" id="lblCarpeta"></span>'
                                                        },
                                                        
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            html:'Tipo notificaci&oacute;n:'
                                                        },
                                                         {
                                                        	x:180,
                                                            y:40,
                                                            html:'<span style="color:#900; font-weight:bold" id="lblTipoCarpeta"></span>'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:70,
                                                            hidden:true,
                                                            id:'lblNombreDeterminacion',
                                                            html:'Nombre de la determinaci&oacute;n:'
                                                        },
                                                        
                                                        {
                                                            x:10,
                                                            y:100,
                                                            id:'lblFechaDeterminacion',
                                                            xtype:'label',
                                                            html:''
                                                        },
                                                        {
                                                            x:10,
                                                            y:70,
                                                            hidden:true,
                                                            xtype:'label',
                                                            id:'lblAudienciaDeriva',
                                                            html:'Audiencia de la cual deriva:'
                                                        },
                                                        {
                                                        	x:180,
                                                            y:70,                                                           
                                                            id:'lblFechaAudiencia',
                                                            html:'<span style="color:#900; font-weight:bold" title="" alt="" id="etLblFecha"></span>'
                                                        },
                                                        {
                                                            xtype:'label',
                                                            x:180,
                                                            y:100,                                                           
                                                            id:'dteFechaDterminacion',
                                                            html:'<span style="color:#900; font-weight:bold" id="etLblFechaDeterminacion"></span>'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:130,
                                                            html:'Comentarios adicionales:'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:150,
                                                            xtype:'textarea',
                                                            id:'txtComentariosAdicionales',
                                                            readOnly:true,
                                                           	width:820,
                                                            hight:25,
                                                            value:''
                                                        },
                                                        {
                                                        	xtype:'tabpanel',
                                                            id:'fArchivos',
                                                            x:10,
                                                            y:225,
                                                            width:820,
                                                            height:165,
                                                            activeTab:0,
                                                            items:	[
                                                            			{
                                                                        	xtype:'panel',
                                                                            layout:'border',                                                                           
                                                                            region:'center',
                                                                            title:'Documentos a notificar',
                                                                            items:	[
                                                                            
                                                                            			crearVistaDocumentosAdjuntos(obj.idOrden)
                                                                            		]
                                                                        }
                                                                        
                                                                        
                                                            		]
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Orden de notificaci&oacute;n, Folio: <b><span style="color:#900" id="lblFolio"></span></b>',
										width: 880,
										height:470,
										layout: 'fit',
										plain:true,
										modal:true,
                                        id:'vOrden',
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
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        
            var objSol=eval(arrResp[1])[0];
            gE('lblFolio').innerHTML=objSol.folioOrden;
            gE('lblCarpeta').innerHTML=objSol.carpetaJudicial;
            gE('lblTipoCarpeta').innerHTML=formatearValorRenderer(arrTipoSolicitud,objSol.tipoNotificacion);
            gEx('txtComentariosAdicionales').setValue(escaparBR(objSol.comentariosAdicionales));
            gE('etLblFecha').innerHTML=objSol.descripcionNotificacion.substr(0,100)+(objSol.length>100?'...':'');
            gE('etLblFechaDeterminacion').innerHTML=Date.parseDate(objSol.fechaDeterminacion,'Y-m-d').format('d/m/Y');
            if(objSol.tipoNotificacion=='1')
            {
            	gE('lblFechaDeterminacion').innerHTML='Fecha de la determinaci&oacute;n:'
                gEx('lblNombreDeterminacion').show();
            }
            else
            {
            	gE('lblFechaDeterminacion').innerHTML='Fecha del auto:';
                gEx('lblAudienciaDeriva').show();
            }
           

        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_Notificaciones.php',funcAjax, 'POST','funcion=27&iO='+obj.idOrden,true);
   
    	
}


function mostrarVentanaAtencionOrdenNotificacionAlerta(obj)
{
	var oConf=eval('['+bD(obj)+']')[0];
    
	var obj={};
    obj.ancho='100%';
    obj.alto='100%';
    obj.url='../modulosEspeciales_SGJP/tblOrdenNotificacionAtencion.php';
    obj.params=[['idDiligencia',oConf.idReferencia]];
    abrirVentanaFancy(obj);
}


function mostrarVentanaAtencionOrdenNotificacionNotificador(obj)
{
	var oConf=eval('['+bD(obj)+']')[0];

	var obj={};
    obj.ancho='100%';
    obj.alto='100%';
    obj.url='../modulosEspeciales_SGJP/tblOrdenNotificacionAtencion.php';
    obj.params=[['idOrden',oConf.idOrden]];
    if(oConf.idDiligencia)
    {
    	obj.params.push(['idDiligencia',oConf.idDiligencia]);
    }
    abrirVentanaFancy(obj);
}