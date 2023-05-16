<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>

var arrSituacionActual=[['1','Activo'],['2','Inactivo']];
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
                                                cls:'panelSiugj',
                                                title: 'Configuraciones Servidores de Correo Electr&oacute;nico',
                                                items:	[
                                                            crearGridConexionesServidorCorreo()
                                                        ]
                                            }
                                         ]
                            }
                        )   
}

function crearGridConexionesServidorCorreo()
{
	 var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idRegistro'},
                                                        {name: 'mail'},
		                                                {name:'descripcion'},                                                        
		                                                {name: 'hostSMTP'},
                                                        {name: 'puertoSMTP'},
                                                        {name: 'hostIMAP'},
                                                        {name: 'puertoIMAP'},
                                                        {name: 'situacionActual'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                reader: lector,
                                                proxy : new Ext.data.HttpProxy	(

                                                                                  {

                                                                                      url: '../paginasFunciones/funcionesModulosEspeciales_CorreoElectronico.php'

                                                                                  }

                                                                              ),
                                                sortInfo: {field: 'descripcion', direction: 'ASC'},
                                                groupField: 'descripcion',
                                                remoteGroup:false,
                                                remoteSort: false,
                                                autoLoad:true
                                                
                                            }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='3';
                                     	gEx('btnActivaCuenta').hide();   
                                        gEx('btnDesActivaCuenta').hide();
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer({width:40}),
                                                            {
                                                                header:'Nombre de la conexi&oacute;n',
                                                                width:350,
                                                                sortable:true,
                                                                dataIndex:'descripcion',
                                                                renderer:mostrarValorDescripcion
                                                            },
                                                            {
                                                                header:'Correo Electr&oacute;nico',
                                                                width:250,
                                                                sortable:true,
                                                                dataIndex:'mail'
                                                            },
                                                            
                                                            {
                                                                header:'Host SMTP',
                                                                width:250,
                                                                sortable:true,
                                                                dataIndex:'hostSMTP'
                                                            },
                                                            {
                                                                header:'Puerto SMTP',
                                                                width:150,
                                                                sortable:true,
                                                                dataIndex:'puertoSMTP'
                                                            },
                                                            {
                                                                header:'Host IMAP',
                                                                width:250,
                                                                sortable:true,
                                                                dataIndex:'hostSMTP'
                                                            },
                                                            {
                                                                header:'Puerto IMAP',
                                                                width:150,
                                                                sortable:true,
                                                                dataIndex:'puertoIMAP'
                                                            },
                                                            {
                                                                header:'Situaci&oacute;n Actual',
                                                                width:200,
                                                                sortable:true,
                                                                dataIndex:'situacionActual',
                                                                renderer:function(val)
                                                                		{
                                                                        	return formatearValorRenderer(arrSituacionActual,val);
                                                                        }
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gridConexiones',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                cm: cModelo,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                columnLines : true,
                                                                cls:'gridSiugj',
                                                                tbar:	[		
                                                                			{
                                                                                icon:'../images/add.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Configurar Conexi&oacute;n',
                                                                                handler:function()
                                                                                        {
                                                                                            mostrarVentanaConfiguracionCorreoSaliente();
                                                                                        }
                                                                                
                                                                            },
                                                                            {
                                                                                xtype:'tbspacer',
                                                                                width:10
                                                                            },
                                                                            {
                                                                                icon:'../images/pencil.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Modificar Conexi&oacute;n',
                                                                                handler:function()
                                                                                        {
                                                                                        	var fila=gEx('gridConexiones').getSelectionModel().getSelected();
                                                                                            if(!fila)
                                                                                            {	
                                                                                            	msgBox('Debe seleccionar la conexi&oacute;n que desea modificar');
                                                                                            	return;
                                                                                            }
                                                                                            mostrarVentanaConfiguracionCorreoSaliente(fila.data.idRegistro);
                                                                                        }
                                                                                
                                                                            },
                                                                            {
                                                                                xtype:'tbspacer',
                                                                                width:10
                                                                            },
                                                                            {
                                                                                icon:'../images/delete.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Remover Conexi&oacute;n',
                                                                                handler:function()
                                                                                        {
                                                                                        	var fila=gEx('gridConexiones').getSelectionModel().getSelected();
                                                                                            if(!fila)
                                                                                            {	
                                                                                            	msgBox('Debe seleccionar la cuenta que desea remover');
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
                                                                                                            gEx('gridConexiones').getStore().reload();
                                                                                                        }
                                                                                                        else
                                                                                                        {
                                                                                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                        }
                                                                                                    }
                                                                                                    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_CorreoElectronico.php',funcAjax, 'POST','funcion=8&iR='+fila.data.idRegistro,true);

                                                                                                	
                                                                                                }
                                                                                            }
                                                                                            
                                                                                            msgConfirm('¿Est&aacute; seguro de querer remover la cuenta seleccionada?',resp)
                                                                                        }
                                                                                
                                                                            },
                                                                            {
                                                                                xtype:'tbspacer',
                                                                                width:10
                                                                            },

                                                                            {
                                                                                icon:'../images/cross.png',
                                                                                cls:'x-btn-text-icon',
                                                                                id:'btnDesActivaCuenta',
                                                                                hidden:true,
                                                                                text:'Desactivar Cuenta',
                                                                                handler:function()
                                                                                        {
                                                                                        	var fila=gEx('gridConexiones').getSelectionModel().getSelected();
                                                                                            if(!fila)
                                                                                            {	
                                                                                            	msgBox('Debe seleccionar la cuenta que desea desactivar');
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
                                                                                                            gEx('gridConexiones').getStore().reload();
                                                                                                        }
                                                                                                        else
                                                                                                        {
                                                                                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                        }
                                                                                                    }
                                                                                                    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_CorreoElectronico.php',funcAjax, 'POST','funcion=9&s=2&iR='+fila.data.idRegistro,true);

                                                                                                	
                                                                                                }
                                                                                            }
                                                                                            
                                                                                            msgConfirm('¿Est&aacute; seguro de querer desactivar la cuenta seleccionada?',resp)
                                                                                        }
                                                                                
                                                                            },
                                                                            {
                                                                                icon:'../images/icon_big_tick.gif',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Activar Cuenta',
                                                                                hidden:true,
                                                                                id:'btnActivaCuenta',
                                                                                handler:function()
                                                                                        {
                                                                                        	var fila=gEx('gridConexiones').getSelectionModel().getSelected();
                                                                                            if(!fila)
                                                                                            {	
                                                                                            	msgBox('Debe seleccionar la cuenta que desea activar');
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
                                                                                                            gEx('gridConexiones').getStore().reload();
                                                                                                        }
                                                                                                        else
                                                                                                        {
                                                                                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                        }
                                                                                                    }
                                                                                                    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_CorreoElectronico.php',funcAjax, 'POST','funcion=9&s=1&iR='+fila.data.idRegistro,true);

                                                                                                	
                                                                                                }
                                                                                            }
                                                                                            
                                                                                            msgConfirm('¿Est&aacute; seguro de querer activar la cuenta seleccionada?',resp)
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

	tblGrid.getSelectionModel().on('rowselect',function(sm,nfila,registro)
    											{
                                                	if(registro.data.situacionActual=='1')
                                                    {
                                                    	gEx('btnActivaCuenta').hide();
                                                        gEx('btnDesActivaCuenta').show();
                                                    }
                                                    else
                                                    {
                                                    	gEx('btnActivaCuenta').show();
                                                        gEx('btnDesActivaCuenta').hide();
                                                    }
                                                }
    								)
        return 	tblGrid;
}


function mostrarVentanaConfiguracionCorreoSaliente(iC)
{
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                            x:10,
                                                            y:20,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Nombre de la conexi&oacute;n:'
                                                        },
                                                        {
                                                        	x:240,
                                                            y:15,
                                                            width:350,
                                                            cls:'controlSIUGJ',
                                                            xtype:'textfield',
                                                            id:'txtDescripcion'
                                                        },
                                            	
                                            			{
                                                        	xtype:'fieldset',
                                                            x:10,
                                                            y:50,
                                                            defaultType: 'label',
                                                            width:570,
                                                            height:190,
                                                            cls:'frameSiugj',
                                                            title:'Configuraci&oacute;n de correo entrante',
                                                            layout:'absolute',
                                                            items:	[
                                                            			{
                                                                            x:10,
                                                                            y:10,
                                                                            cls:'SIUGJ_Etiqueta',
                                                                            html:'Host servidor IMAP:'
                                                                        },
                                                                        {
                                                                            x:200,
                                                                            y:5,
                                                                            xtype:'textfield',
                                                                            width:300,
                                                                            cls:'controlSIUGJ',
                                                                            value:'imap.gmail.com',
                                                                            id:'hostIMAP'
                                                                        },
                                                                        {
                                                                            x:10,
                                                                            y:45,
                                                                            cls:'SIUGJ_Etiqueta',
                                                                            html:'Puerto:',
                                                                            
                                                                        },
                                                                        {
                                                                            x:200,
                                                                            y:40,
                                                                            cls:'controlSIUGJ',
                                                                            xtype:'numberfield',
                                                                            allowDecimals:false,
                                                                            allowNegative:false,
                                                                            width:60,
                                                                            value:'993',
                                                                            id:'puertoIMAP'
                                                                        },
                                                                       
                                                                        {
                                                                            x:280,
                                                                            y:40,
                                                                            xtype:'checkbox',
                                                                            id:'chkSSL',
                                                                            ctCls:'SIUGJ_Etiqueta',
                                                                            boxLabel:'Utilizar SSL'
                                                                        },
                                                                        {
                                                                        
                                                                            x:10,
                                                                            y:80,
                                                                            cls:'SIUGJ_Etiqueta',
                                                                            html:'Usuario/E-mail:'
                                                                        },
                                                                        {
                                                                            x:200,
                                                                            y:75,
                                                                            xtype:'textfield',
                                                                            width:300,
                                                                            cls:'controlSIUGJ',
                                                                            value:'',
                                                                            id:'txtUsuario'
                                                                        },
                                                                        {
                                                                            x:10,
                                                                            y:115,
                                                                            cls:'SIUGJ_Etiqueta',
                                                                            html:'Contrase&ntilde;a:'
                                                                        },
                                                                        {
                                                                            x:200,
                                                                            y:110,
                                                                            xtype:'textfield',
                                                                            width:120,
                                                                            value:'',
                                                                            cls:'controlSIUGJ',
                                                                            inputType: 'password',
                                                                            id:'txtPassword'
                                                                        }
                                                            		]
                                                        },
                                                        {
                                                        	xtype:'fieldset',
                                                            x:10,
                                                            y:250,
                                                            defaultType: 'label',
                                                            width:570,
                                                            height:120,
                                                            cls:'frameSiugj',
                                                            title:'Configuraci&oacute;n de correo saliente',
                                                            layout:'absolute',
                                                            items:	[
                                                            			{
                                                                            x:10,
                                                                            y:10,
                                                                            cls:'SIUGJ_Etiqueta',
                                                                            html:'Host servidor SMTP:'
                                                                        },
                                                                        {
                                                                            x:200,
                                                                            y:5,
                                                                            xtype:'textfield',
                                                                            width:300,
                                                                            cls:'controlSIUGJ',
                                                                            value:'smtp.gmail.com',
                                                                            id:'hostSMTP'
                                                                        },
                                                                        {
                                                                            x:10,
                                                                            y:45,
                                                                            cls:'SIUGJ_Etiqueta',
                                                                            html:'Puerto:',
                                                                            
                                                                        },
                                                                        {
                                                                            x:200,
                                                                            y:40,
                                                                            cls:'controlSIUGJ',
                                                                            xtype:'numberfield',
                                                                            allowDecimals:false,
                                                                            allowNegative:false,
                                                                            width:60,
                                                                            value:'25',
                                                                            id:'puertoSMTP'
                                                                        },
                                                                       
                                                                        {
                                                                            x:290,
                                                                            y:40,
                                                                            xtype:'checkbox',
                                                                            id:'chkAutenticacion',
                                                                            ctCls:'SIUGJ_Etiqueta',
                                                                            boxLabel:'Utilizar autenticaci&oacute;n'
                                                                        }
                                                            		]
                                                         }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Configuraci&oacute;n de Servidor de Correo',
										width: 630,
										height:480,
										layout: 'fit',
										plain:true,
										modal:true,
                                        cls:'msgHistorialSIUGJ',
										bodyStyle:'padding:5px;',
										buttonAlign:'center',
										items: form,
										listeners : {
													show : {
																buffer : 10,
																fn : function() 
																{
                                                                	gEx('txtDescripcion').focus(false,500);
                                                                    if(iC)
                                                                    {
                                                                    
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                                var arrDatos=eval((arrResp[1]));
                                                                                if(arrDatos.length>0)
                                                                                {
                                                                                    var hostIMAP=gEx('hostIMAP');
                                                                                    var puertoIMAP=gEx('puertoIMAP');
                                                                                    var txtUsuario=gEx('txtUsuario');
                                                                                    var txtPassword=gEx('txtPassword');
                                                                                    
                                                                                    var hostSMTP=gEx('hostSMTP');
                                                                                    var puertoSMTP=gEx('puertoSMTP');
                                                                                    var txtDescripcion=gEx('txtDescripcion');
                                                                                    
                                                                                    
                                                                                    hostIMAP.setValue(arrDatos[0].hostIMAP);
                                                                                    puertoIMAP.setValue(arrDatos[0].puertoIMAP);
                                                                                    txtUsuario.setValue(arrDatos[0].mail);
                                                                                    gEx('chkSSL').setValue(arrDatos[0].utilizarSSL=='1');
                                                                                    hostSMTP.setValue(arrDatos[0].hostSMTP);
                                                                                    puertoSMTP.setValue(arrDatos[0].puertoSMTP);
                                                                                    txtDescripcion.setValue(escaparBR(arrDatos[0].descripcion));
                                                                                    gEx('chkAutenticacion').setValue(arrDatos[0].autenticacionSMTP=='1');
                                                                                    
                                                                                }
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_CorreoElectronico.php',funcAjax, 'POST','funcion=2&iC='+iC,true);
																	}
                                                                }
															}
												},
										buttons:	[
                                                        {
															text: '<?php echo $etj["lblBtnCancelar"]?>',
                                                            cls:'btnSIUGJCancel',
                                                            width:100,
															handler:function()
																	{
																		ventanaAM.close();
																	}
														},
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            cls:'btnSIUGJ',
                                                            width:100,
															handler: function()
																	{
																		var hostIMAP=gEx('hostIMAP');
                                                                        var puertoIMAP=gEx('puertoIMAP');
                                                                        var txtUsuario=gEx('txtUsuario');
                                                                        var txtPassword=gEx('txtPassword');
                                                                        var txtDescripcion=gEx('txtDescripcion');
                                                                        var hostSMTP=gEx('hostSMTP');
                                                                        var puertoSMTP=gEx('puertoSMTP');
                                                                        
                                                                        if(txtDescripcion.getValue()=='')
                                                                        {
                                                                        	function resp100()
                                                                            {
                                                                            	txtDescripcion.focus();
                                                                            }
                                                                            msgBox('Debe ingresar la descripci&oacute;n de la conexi&oacute;n',resp100);
                                                                            return;
                                                                        }
                                                                        if(hostIMAP.getValue()=='')
                                                                        {
                                                                        	function resp1()
                                                                            {
                                                                            	hostIMAP.focus();
                                                                            }
                                                                            msgBox('Debe ingresar la URL del servidor de correo entrante',resp1);
                                                                            return;
                                                                        }
                                                                        
                                                                        if(puertoIMAP.getValue()=='')
                                                                        {
                                                                        	function resp2()
                                                                            {
                                                                            	puertoIMAP.focus();
                                                                            }
                                                                            msgBox('Debe ingresar el puerto del servidor de correo entrante',resp2);
                                                                            return;
                                                                        }
                                                                        
                                                                        if(txtUsuario.getValue()=='')
                                                                        {
                                                                        	function resp3()
                                                                            {
                                                                            	txtUsuario.focus();
                                                                            }
                                                                            msgBox('Debe ingresar el usuario para el servidor de correo saliente',resp3);
                                                                            return;
                                                                        }
                                                                        
                                                                        if(txtPassword.getValue()=='')
                                                                        {
                                                                        	function resp4()
                                                                            {
                                                                            	txtPassword.focus();
                                                                            }
                                                                           	msgBox('Debe ingresar la contrase&ntilde;a para el servidor de correo saliente',resp4);
                                                                            return;
                                                                        }
                                                                        
                                                                        if(hostSMTP.getValue()=='')
                                                                        {
                                                                        	function resp5()
                                                                            {
                                                                            	hostSMTP.focus();
                                                                            }
                                                                            msgBox('Debe ingresar la URL del servidor de correo saliente',resp5);
                                                                            return;
                                                                        }
                                                                        
                                                                        if(puertoSMTP.getValue()=='')
                                                                        {
                                                                        	function resp6()
                                                                            {
                                                                            	puertoSMTP.focus();
                                                                            }
                                                                            msgBox('Debe ingresar el puerto del servidor de correo saliente',resp6);
                                                                            return;
                                                                        }
                                                                        
                                                                        var cadObj='{"idRegistro":"'+(!iC?-1:iC)+'","hostIMAP":"'+cv(hostIMAP.getValue())+
                                                                        '","puertoIMAP":"'+puertoIMAP.getValue()+'","usuario":"'+cv(txtUsuario.getValue())+
                                                                        '","passwd":"'+bE(txtPassword.getValue())+'","utilizarSSL":"'+
                                                                        (gEx('chkSSL').getValue()?'1':0)+'","hostSMTP":"'+cv(hostSMTP.getValue())+
                                                                        '","puertoSMTP":"'+puertoSMTP.getValue()+'","autenticacionSMTP":"'+
                                                                        (gEx('chkAutenticacion').getValue()?'1':0)+'","descripcion":"'+(gEx('txtDescripcion').getValue())+'"}';
                                                                        
                                                                        
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                                gEx('gridConexiones').getStore().reload();
                                                                                ventanaAM.close();
                                                                                
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_CorreoElectronico.php',funcAjax, 'POST','funcion=1&cadObj='+cadObj,true);
                                                                        
																	}
														}
														
													]
									}
								);
	ventanaAM.show();	
}

