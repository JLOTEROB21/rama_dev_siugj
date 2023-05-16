<?php session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>
var arrEstructuras=new Array();
	
function mostrarVentanaEstructuraDatos()
{
	var gridEstructuraDatos=crearGridEstructuraDatos();
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'border',
											defaultType: 'label',
											items: 	[
														gridEstructuraDatos

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Administraci&oacute;n de estructuras de datos',
										width: 1200,
										height:400,
                                        cls:'msgHistorialSIUGJ',
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
															text: 'Cerrar',
                                                            cls:'btnSIUGJCancel',
                                                            width:140,
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

var regEstructura=crearRegistro(	[
                                        {name: 'idEstructura'},
                                        {name: 'nombreEstructura'},
                                        {name: 'estructura'},
                                        {name: 'tipoEstructura'},
                                        {name: 'idReferencia'}
                                    ]
                               )

function crearGridEstructuraDatos()
{
	var dsDatos=arrEstructuras;
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'idEstructura'},
                                                                    {name: 'nombreEstructura'},
                                                                    {name: 'estructura'},
                                                                    {name: 'tipoEstructura'},
                                                                    {name: 'idReferencia'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel({singleSelect:true,width:40});
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer({width:40}),
														chkRow,
														{
															header:'Nombre estructura',
															width:280,
															sortable:true,
															dataIndex:'nombreEstructura'
														},
                                                        {
															header:'Tipo Estructura',
															width:320,
															sortable:true,
															dataIndex:'tipoEstructura',
                                                            renderer:function(val)
                                                            		{
                                                                    	switch(val)
                                                                        {
                                                                        	case '0':
                                                                            	return 'Definida por usuario';
                                                                            break;
                                                                            case '1':
                                                                            	return 'Importada de almac&eacute;n de datos';
                                                                            break;
                                                                            case '2':
                                                                            	return 'Importada de tabla de base de datos';
                                                                            break;
                                                                        }
                                                                    }
														},
														{
															header:'Estructura',
															width:400,
															sortable:true,
															dataIndex:'estructura',
                                                            renderer:function(val)
                                                            		{
                                                                    	var cadAttr='';
                                                                        var x;
                                                                        for(x=0;x<val.length;x++)
                                                                        {
                                                                        	if(cadAttr=='')
                                                                            	cadAttr=val[x][1];
                                                                            else
                                                                            	cadAttr+=', '+val[x][1];
                                                                        }
                                                                        return mostrarValorDescripcion(cadAttr);
                                                                    }
                                                            
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gAdminEstructuras',
                                                            store:alDatos,
                                                            frame:false,
                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            stripeRows :false,
                                                            columnLines : false,
                                                            region:'center',
                                                            cls:'gridSiugjPrincipal',
                                                            sm:chkRow,
                                                            tbar:	[
                                                            			{
                                                                        	icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Crear nueva estructura',
                                                                            handler:function()
                                                                            		{
                                                                                    	mostrarVentanaEditarEtructura();
                                                                                    }
                                                                            
                                                                        },'-',
                                                                        {
                                                                        	icon:'../images/table_row_insert.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Importar estructura',
                                                                           	menu:	[
                                                                            			{
                                                                                            icon:'../images/database.png',
                                                                                            cls:'x-btn-text-icon',
                                                                                            text:'De almac&eacute;n de datos',
                                                                                            handler:function()
                                                                                                    {
                                                                                                    	mostrarVentanaImpEstructuraAlmacenDatos();    
                                                                                                    }
                                                                                            
                                                                                        },
                                                                                        {
                                                                                            icon:'../images/database_table.png',
                                                                                            cls:'x-btn-text-icon',
                                                                                            text:'De tabla de base de datos',
                                                                                            handler:function()
                                                                                                    {
                                                                                                     	mostrarVentanaImpEstructuraTablaBD();   
                                                                                                    }
                                                                                            
                                                                                        }
                                                                            		]
                                                                            
                                                                        },'-',
                                                                        {
                                                                        	id:'btnImportarEstruc',
                                                                        	icon:'../images/pencil.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Modificar estructura',
                                                                            disabled:true,
                                                                            handler:function()
                                                                            		{
                                                                                    	var fila=tblGrid.getSelectionModel().getSelected();
                                                                                        if(fila==null)	
                                                                                        {
                                                                                        	msgBox('Debe seleccionar la estructura que desea modificar');
                                                                                        	return;
                                                                                        }
                                                                                        mostrarVentanaEditarEtructura(fila);
                                                                                        
                                                                                    }
                                                                            
                                                                        },'-',
                                                                        {
                                                                        	id:'btnReImportarEstruc',
                                                                        	icon:'../images/arrow_refresh.PNG',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Reimportar estructura',
                                                                            disabled:true,
                                                                            handler:function()
                                                                            		{
                                                                                    	var arrArtributos=new Array();
                                                                                        var x;
                                                                                    	var fila=tblGrid.getSelectionModel().getSelected();
                                                                                        if(fila==null)	
                                                                                        {
                                                                                        	msgBox('Debe seleccionar la estructura que desea reimportar');
                                                                                        	return;
                                                                                        }
                                                                                        if(fila.get('tipoEstructura')=='1')
                                                                                        {
                                                                                        	var nodoAlmacen=buscarAlmacen(fila.get('idReferencia'));
                                                                                            for(x=0;x<nodoAlmacen.attributes.children[0].children.length;x++)
                                                                                            {
                                                                                                f=nodoAlmacen.attributes.children[0].children[x];
                                                                                                arrArtributos.push([f.nCampo.replace(".","_"),f.text]);
                                                                                            }
                                                                                            fila.set('estructura',arrArtributos);
                                                                                            var pos=existeValorMatriz(arrEstructuras,fila.get('idEstructura'));
                                                                                            if(pos!=-1)
                                                                                                arrEstructuras[pos]=[fila.get('idEstructura'),fila.get('nombreEstructura'),arrArtributos,fila.get('tipoEstructura'),fila.get('idReferencia')];
                                                                                            else
                                                                                                arrEstructuras.push([fila.get('idEstructura'),fila.get('nombreEstructura'),arrArtributos,fila.get('tipoEstructura'),fila.get('idReferencia')]);
                                                                                             msgBox('La estructura ha sido reimportada');
                                                                                        }
                                                                                        else
                                                                                        {
                                                                                        	function funcAjax()
                                                                                            {
                                                                                                var resp=peticion_http.responseText;
                                                                                                arrResp=resp.split('|');
                                                                                                if(arrResp[0]=='1')
                                                                                                {
                                                                                                    var arrCampos=eval(arrResp[1]);
                                                                                                    
                                                                                                    for(x=0;x<arrCampos.length;x++)
                                                                                                    {
                                                                                                        f=arrCampos[x];
                                                                                                       
                                                                                                        arrArtributos.push([f[0],f[1]]);
                                                                                                    }
                                                                                                   fila.set('estructura',arrArtributos);
                                                                                                    var pos=existeValorMatriz(arrEstructuras,fila.get('idEstructura'));
                                                                                                    if(pos!=-1)
                                                                                                        arrEstructuras[pos]=[fila.get('idEstructura'),fila.get('nombreEstructura'),arrArtributos,fila.get('tipoEstructura'),fila.get('idReferencia')];
                                                                                                    else
                                                                                                        arrEstructuras.push([fila.get('idEstructura'),fila.get('nombreEstructura'),arrArtributos,fila.get('tipoEstructura'),fila.get('idReferencia')]); 
                                                                                                    msgBox('La estructura ha sido reimportada');
                                                                                                    
                                                                                                }
                                                                                                else
                                                                                                {
                                                                                                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                }
                                                                                            }
                                                                                            obtenerDatosWeb('../paginasFunciones/funcionesThot.php',funcAjax, 'POST','funcion=8&nTabla='+bE(fila.get('idReferencia')),true);

                                                                                        }
                                                                                        
                                                                                    }
                                                                            
                                                                        },'-',
                                                                        {
                                                                        	icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Remover estructura',
                                                                            handler:function()
                                                                            		{
                                                                                    	var fila=tblGrid.getSelectionModel().getSelected();
                                                                                        if(fila==null)	
                                                                                        {
                                                                                        	msgBox('Debe seleccionar la estrutura que desea remover');
                                                                                        	return;
                                                                                        }
                                                                                        function resp(btn)
                                                                                        {
                                                                                        	if(btn=='yes')
                                                                                            {
                                                                                            	tblGrid.getStore().remove(fila);
                                                                                                var x;
                                                                                                var pos=existeValorMatriz(arrEstructuras,fila.get('idEstructura'));
                                                                                                if(pos!=-1)
                                                                                                {
                                                                                                	arrEstructuras.splice(pos,1);
                                                                                                }
                                                                                                
                                                                                                
                                                                                            }
                                                                                        }
                                                                                        msgConfirm('Est&aacute; seguro de querer remover la estructura seleccionada?',resp)
                                                                                    }
                                                                            
                                                                        }
                                                                        
                                                            		]
                                                        }
                                                    );
	chkRow.on('rowselect',function(sm,fila,registro)
    						{
                            	if(registro.get('tipoEstructura')=='0')
                                {
                               		gEx('btnImportarEstruc').enable();
                                    gEx('btnReImportarEstruc').disable();
                                }
                                else
                                {
                                	gEx('btnImportarEstruc').disable();
                                    gEx('btnReImportarEstruc').enable();
                                }
                            }
    		)                                                    
	return 	tblGrid;		
}

var regAtributo=crearRegistro	([{'name':'nombreCampo'},{'name':'nombreUsr'}]);

function mostrarVentanaEditarEtructura(fila)
{
	var gridDefEstructura=crearGridDefinicionEstructura();
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
                                                            html:'Nombre estructura:'
                                                        },
                                                        {
                                                        	x:200,
                                                            y:15,
                                                            xtype:'textfield',
                                                            cls:'controlSIUGJ',
                                                            id:'txtNombreEstructura',
                                                            enableKeyEvents :true,
                                                            maskRe:/^[_a-zA-Z0-9]$/,
                                                            width:300
                                                        },
                                                        gridDefEstructura

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Definir estructura',
										width: 560,
										height:420,
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
                                                                	gEx('txtNombreEstructura').focus(false,500);
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
																		var x;
                                                                        var f;
                                                                        var arrArtributos=new Array();
                                                                        
                                                                        var txtNombreEstructura=gEx('txtNombreEstructura');
                                                                        
                                                                        if(txtNombreEstructura.getValue()=='')
                                                                        {
                                                                        	function resp2()
                                                                            {
                                                                            	function resp2()
                                                                                {
                                                                                	txtNombreEstructura.focus();
                                                                                }
                                                                            }
                                                                            msgBox('Debe indicar el nombre de la estructura',resp2);
                                                                            return;
                                                                        }
                                                                        var idEstructura=-1;
                                                                        if(fila!=undefined)
                                                                        	idEstructura=fila.get('idEstructura');
                                                                        if(existeEstructura(gEx('txtNombreEstructura').getValue(),idEstructura))
                                                                        {
                                                                            return;
                                                                        }
                                                                        
                                                                        if(gridDefEstructura.getStore().getCount()==0)
                                                                        {
                                                                        	msgBox('Debe indicar al menos un atributo de la estructura');
                                                                        	return;
                                                                        }
                                                                        for(x=0;x<gridDefEstructura.getStore().getCount();x++)
                                                                        {
                                                                        	f=gridDefEstructura.getStore().getAt(x);
                                                                            if(f.get('nombreCampo')=='')
                                                                            {
                                                                            	function resp()
                                                                                {
                                                                                	gridDefEstructura.startEditing(x,1);
                                                                                }
                                                                            	msgBox('Debe ingresar el nombre del atributo',resp);
                                                                            	return;
                                                                            }
                                                                            arrArtributos.push([f.get('nombreCampo'),f.get('nombreUsr')]);
                                                                        }
                                                                        var gAdminEstructuras=gEx('gAdminEstructuras');
                                                                        var idEstructuraAux=new Date().format('YmdHi')+'_'+Math.floor((Math.random()*1000)+1);
                                                                        if(fila==undefined)
                                                                        {
                                                                            var rEstructura=new regEstructura	(
                                                                                                                    {	
                                                                                                                        idEstructura:idEstructuraAux,
                                                                                                                        nombreEstructura:txtNombreEstructura.getValue(),
                                                                                                                        estructura:arrArtributos,
                                                                                                                        tipoEstructura:'0',
                                                                                                                        idReferencia:''
                                                                                                                    }
                                                                                                                )
                                                                           
                                                                            gAdminEstructuras.getStore().add(rEstructura);
                                                                            arrEstructuras.push([idEstructuraAux,txtNombreEstructura.getValue(),arrArtributos,'0','']);
                                                                        }
                                                                        else
                                                                        {
                                                                        	fila.set('nombreEstructura',txtNombreEstructura.getValue());
                                                                            fila.set('estructura',arrArtributos);
                                                                            var x;
                                                                            var pos=existeValorMatriz(arrEstructuras,fila.get('idEstructura'));
                                                                            if(pos!=-1)
                                                                                arrEstructuras[pos]=[idEstructuraAux,txtNombreEstructura.getValue(),arrArtributos,'0',''];
                                                                            else
                                                                            	arrEstructuras.push([idEstructuraAux,txtNombreEstructura.getValue(),arrArtributos,'0','']);
                                                                            
                                                                            
                                                                        }
                                                                        ventanaAM.close();
                                                                        
																	}
														}
														
													]
									}
								);
	ventanaAM.show();		
    if(fila!=undefined)
    {
    	gEx('txtNombreEstructura').setValue(fila.get('nombreEstructura'));
        gridDefEstructura.getStore().loadData(fila.get('estructura'));
    }
}

function crearGridDefinicionEstructura()
{
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'nombreCampo'},
                                                                    {name: 'nombreUsr'}

                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel({singleSelect:true,width:40});
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	
														chkRow,
														{
															header:'Atributo',
															width:400,
															sortable:true,
															dataIndex:'nombreUsr',
                                                            editor:{xtype:'textfield',cls:'controlSIUGJ',enableKeyEvents :true,maskRe:/^[_a-zA-Z0-9]$/}
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            
                                                            store:alDatos,
                                                            frame:false,
                                                            y:50,
                                                            x:10,
                                                            cm: cModelo,
                                                            stripeRows :false,
                                                            loadMask:true,
                                                            cls:'gridSiugjPrincipal',
                                                            columnLines : false,
                                                            height:260,
                                                            width:500,
                                                            sm:chkRow,
                                                            tbar:	[
                                                            			{
                                                                        	icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Agregar atributo',
                                                                            handler:function()
                                                                            		{
                                                                                    	var r=new regAtributo({'nombreCampo':'','nombreUsr':''});
                                                                                        tblGrid.getStore().add(r);
                                                                                     	tblGrid.startEditing(tblGrid.getStore().getCount()-1,1);   
                                                                                    }
                                                                            
                                                                        },
                                                                        {
                                                                        	xtype:'tbspacer',
                                                                            width:10
                                                                        }
                                                                        ,
                                                                        {
                                                                        	icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Remover atributo',
                                                                            handler:function()
                                                                            		{
                                                                                    	var fila=tblGrid.getSelectionModel().getSelected();
                                                                                        if(fila==null)	
                                                                                        {
                                                                                        	msgBox('Debe seleccionar el atributo que desea remover');
                                                                                        	return;
                                                                                        }
                                                                                        function resp(btn)
                                                                                        {
                                                                                        	if(btn=='yes')
                                                                                            {
                                                                                            	tblGrid.getStore().remove(fila);
                                                                                            }
                                                                                        }
                                                                                        msgConfirm('Est&aacute; seguro de querer remover el atributo seleccionado?',resp)
                                                                                    }
                                                                            
                                                                        }
                                                                        
                                                            		]
                                                        }
                                                    );
	tblGrid.on('afteredit',function(e)
    						{
                            	e.record.set('nombreCampo',e.value);
                            }
    			)                                                    
	return 	tblGrid;		
}

function mostrarVentanaImpEstructuraAlmacenDatos()
{
	var arrAlmacenesDatos=obtenerAlmacenesDisponibles();
	
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
                                                            html:'Nombre estructura:'
                                                        },
                                                        {
                                                        	x:210,
                                                            y:15,
                                                            xtype:'textfield',
                                                            cls:'controlSIUGJ',
                                                            id:'txtNombreEstructura',
                                                            enableKeyEvents :true,maskRe:/^[_a-zA-Z0-9]$/,
                                                            width:200
                                                        },
														{
                                                        	x:10,
                                                            y:70,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Almac&eacute;n de datos:'
                                                        },
                                                        {	
                                                        	xtype:'label',
                                                            x:210,
                                                            y:65,
                                                            html:'<div id="divComboAlmacen"></div>'
                                                        }

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Importar estructura de almacen de datos',
										width: 620,
										height:240,
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
                                                                	gEx('txtNombreEstructura').focus(false,500);
                                                                    var cmbAlmacenDatos=crearComboExt('cmbAlmacenDatos',arrAlmacenesDatos,0,0,350,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboAlmacen'});
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
																		var x;
                                                                        var f;
                                                                        var arrArtributos=new Array();
                                                                        
                                                                        var txtNombreEstructura=gEx('txtNombreEstructura');
                                                                        
                                                                        if(txtNombreEstructura.getValue()=='')
                                                                        {
                                                                        	function resp2()
                                                                            {
                                                                            	function resp2()
                                                                                {
                                                                                	txtNombreEstructura.focus();
                                                                                }
                                                                            }
                                                                            msgBox('Debe indicar el nombre de la estructura',resp2);
                                                                            return;
                                                                        }
                                                                        
                                                                        if(existeEstructura(gEx('txtNombreEstructura').getValue(),-1))
                                                                        {
                                                                            return;
                                                                        }
                                                                        var cmbAlmacenDatos=gEx('cmbAlmacenDatos');
                                                                        
                                                                        if(cmbAlmacenDatos.getValue()=='')
                                                                        {
                                                                        	msgBox('Debe indicar el almac&eacute;n de datos del cual ser&aacute; importada la estructura');
                                                                        	return;
                                                                        }
                                                                        
                                                                        var nodoAlmacen=buscarAlmacen(cmbAlmacenDatos.getValue());
                                                                       
                                                                        
                                                                        for(x=0;x<nodoAlmacen.attributes.children[0].children.length;x++)
                                                                        {
                                                                        	f=nodoAlmacen.attributes.children[0].children[x];
                                                                           
                                                                            arrArtributos.push([f.nCampo.replace(".","_"),f.text]);
                                                                        }
                                                                        
                                                                        var gAdminEstructuras=gEx('gAdminEstructuras');
                                                                       
                                                                        var idEstructuraAux=new Date().format('YmdHi')+'_'+Math.floor((Math.random()*1000)+1);
                                                                        
                                                                        var rEstructura=new regEstructura	(
                                                                                                                {	
                                                                                                                    idEstructura:idEstructuraAux,
                                                                                                                    nombreEstructura:txtNombreEstructura.getValue(),
                                                                                                                    estructura:arrArtributos,
                                                                                                                    tipoEstructura:'1',
                                                                                                                    idReferencia:cmbAlmacenDatos.getValue()
                                                                                                                }
                                                                                                            )
                                                                       
                                                                        gAdminEstructuras.getStore().add(rEstructura);
                                                                        arrEstructuras.push([idEstructuraAux,txtNombreEstructura.getValue(),arrArtributos,'1',cmbAlmacenDatos.getValue()]);
                                                                        
                                                                        ventanaAM.close();
																	}
														}
														
													]
									}
								);
	ventanaAM.show();		
}

function mostrarVentanaImpEstructuraTablaBD()
{
	 arrParametrosAlmacen=new Array();
	var alDatos = new Ext.data.JsonStore	(
                                                {
                                                    root: 'registros',
                                                    totalProperty: 'numReg',
                                                    idProperty: 'nomTablaOriginal',
                                                    fields:	[
                                                                {name:'nomTablaOriginal'},
                                                                {name:'tabla'}, 
                                                                {name:'tipoTabla'},
                                                                {name:'proceso'}
                                                            ],
                                                    remoteSort:false,
                                                    proxy: new Ext.data.HttpProxy	(
                                                                                        {
                                                                                            url: '../paginasFunciones/funcionesFormulario.php'
                                                                                            
                                                                                        }
                                                                                    )
                                                }
                                            );  
                                            
                                            
	var filters = new Ext.ux.grid.GridFilters	(
    												{
                                                    	filters:	[
                                                        				{
                                                                            type:'string',
                                                                           	dataIndex:'tabla' 
																		},
                                                                        {
                                                                            type:'list',
                                                                           	dataIndex:'tipoTabla',
                                                                            phpMode:true,
                                                                            options:	[
                                                                            				{
                                                                                            	id:'1',
                                                                                                text:'Formulario Din&aacute;mico'
                                                                                            },
                                                                            				{
                                                                                            	id:'2',
                                                                                                text:'Sistema'
                                                                                            }
                                                                            			] 
																		},
                                                                        {
                                                                            type:'string',
                                                                           	dataIndex:'proceso' 
																		}
                                                        			]
                                                    }
                                                );                                                                                                                           
   
   
    var cmFrmDTD= new Ext.grid.ColumnModel   	(
                                                    [
                                                        new  Ext.grid.RowNumberer({width:40}),
                                                        {
                                                            header:'Tabla',
                                                            width:420,
                                                            dataIndex:'tabla',
                                                            sortable:true
                                                        },
                                                        {
                                                        	header:'Tipo',
                                                            width:130,
                                                            sortable:true,
                                                            dataIndex:'tipoTabla'
                                                        },
                                                        {
                                                        	header:'Proceso',
                                                            width:180,
                                                            sortable:true,
                                                            dataIndex:'proceso'
                                                        }
                                                       
                                                    ]
                                                );
    
    
    var tblOpciones=	new Ext.grid.GridPanel	(
                                                        {
                                                        	y:50,
                                                            id:'gridTabla',
                                                            store:alDatos,
                                                            frame:false,
                                                            cm: cmFrmDTD,
                                                            height:260,
                                                            cls:'gridSiugjPrincipal',
                                                            width:800,
                                                            loadMask:true,
                                                            stripeRows :false,
                                                            columnLines : false,
                                                            plugins: filters
                                                            
                                                        }
                                                    );
    tblOpciones.on('dblclick',function()
    							{
                                	gEx('btnAgregar').fireEvent('click');
                                }
    				);
    
    var form = new Ext.form.FormPanel(	
                                        {
                                            baseCls: 'x-plain',
                                            layout: 'absolute',
                                            defaultType: 'textfield',
                                            items: 	[
                                                        {
                                                            x:10,
                                                            y:20,
                                                            xtype:'label',
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Nombre estructura:'
                                                        },
                                                        {
                                                            x:200,
                                                            y:15,
                                                            xtype:'textfield',
                                                            id:'txtNombreEstructura',
                                                            cls:'controlSIUGJ',
                                                            enableKeyEvents :true,maskRe:/^[_a-zA-Z0-9]$/,
                                                            width:400
                                                        },
                                                        tblOpciones
                                                    ]
                                        }
                                    );
    
   
   
    btnAgregar=new Ext.Button	(
                                        {
                                            text: '<?php echo $etj["lblBtnAceptar"]?>',
                                            minWidth:80,
                                            cls:'btnSIUGJ',
                                            width:140,
                                            id:'btnAgregar',
                                            listeners:	{
                                                            click:
                                                                    {
                                                                        fn:function()
                                                                        {
                                                                            var x;
                                                                            var f;
                                                                            var arrArtributos=new Array();
                                                                            
                                                                            var txtNombreEstructura=gEx('txtNombreEstructura');
                                                                            
                                                                            if(txtNombreEstructura.getValue()=='')
                                                                            {
                                                                                function resp2()
                                                                                {
                                                                                    function resp2()
                                                                                    {
                                                                                        txtNombreEstructura.focus();
                                                                                    }
                                                                                }
                                                                                msgBox('Debe indicar el nombre de la estructura',resp2);
                                                                                return;
                                                                            }
                                                                            
                                                                            if(existeEstructura(gEx('txtNombreEstructura').getValue(),-1))
                                                                            {
                                                                            	return;
                                                                            }
                                                                            
                                                                            var filaSel= tblOpciones.getSelectionModel().getSelected();
                                                                            if(filaSel==null)
                                                                            {
                                                                                msgBox(lblAplicacion,'Debe selecionar la tabla de la cual ser&aacute; importada la estructura');
                                                                                return;
                                                                            }
                                                                            var nomTablaOriginal=filaSel.get('nomTablaOriginal');
                                                                           	var nomTabla=filaSel.get('tabla');
                                                                            
                                                                            function funcAjax()
                                                                            {
                                                                                var resp=peticion_http.responseText;
                                                                                arrResp=resp.split('|');
                                                                                if(arrResp[0]=='1')
                                                                                {
                                                                                	var arrCampos=eval(arrResp[1]);
                                                                                    var x;
                                                                                    for(x=0;x<arrCampos.length;x++)
                                                                                    {
                                                                                        f=arrCampos[x];
                                                                                       
                                                                                        arrArtributos.push([f[0],f[1]]);
                                                                                    }
                                                                                    
                                                                                    var gAdminEstructuras=gEx('gAdminEstructuras');
                                                                                    var idEstructuraAux=new Date().format('YmdHi')+'_'+Math.floor((Math.random()*1000)+1);
                                                                                    
                                                                                    
                                                                                    var rEstructura=new regEstructura	(
                                                                                                                            {	
                                                                                                                                idEstructura:idEstructuraAux,
                                                                                                                                nombreEstructura:txtNombreEstructura.getValue(),
                                                                                                                                estructura:arrArtributos,
                                                                                                                                tipoEstructura:'2',
                                                                                                                                idReferencia:nomTablaOriginal
                                                                                                                            }
                                                                                                                        )
                                                                                   
                                                                                    gAdminEstructuras.getStore().add(rEstructura);
                                                                                    arrEstructuras.push([idEstructuraAux,txtNombreEstructura.getValue(),arrArtributos,'2',nomTablaOriginal]);
                                                                                    gEx('vImportarTabla').close();
                                                                                    
                                                                                }
                                                                                else
                                                                                {
                                                                                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                }
                                                                            }
                                                                            obtenerDatosWeb('../paginasFunciones/funcionesThot.php',funcAjax, 'POST','funcion=8&nTabla='+bE(nomTablaOriginal),true);

                                                                            
                                                                            
                                                                            
                                                                        }
                                                                    }
                                                        }
                                        }
                                    )
   
    
    ventanaSelTabla = new Ext.Window(
                                            {
                                            	id:'vImportarTabla',
                                                title: 'Importar estructura de tabla de BD',
                                                width: 830 ,
                                                height:430,
                                                minWidth: 300,
                                                minHeight: 100,
                                                layout: 'fit',
                                                plain:true,
                                                modal:true,
                                                cls:'msgHistorialSIUGJ',
                                                bodyStyle:'padding:5px;',
                                                buttonAlign:'center',
                                                items: 	[
                                                            form
                                                        ],
                                                listeners : {
                                                            show : {
                                                                        buffer : 10,
                                                                        fn : function() 
                                                                        {
                                                          			    	gEx('txtNombreEstructura').focus(false,500);        
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
                                                                        ventanaSelTabla.close();
                                                                    }
                                                                },
                                                                btnAgregar
                                                            ]
                                            }
                                        );
                                        
	tblOpciones.getStore().load(
    								{	
                                    	params:	{
                                            		funcion:46
                                        		}	
                                    }
                               );                                        	
	ventanaSelTabla.show();   
}

function existeEstructura(nEstructura,idEstructura)
{
	var pos=obtenerPosFila(gEx('gAdminEstructuras').getStore(),'nombreEstructura',nEstructura);
	if(pos==-1)	
    	return false;
    else
    {
    	var fila=gEx('gAdminEstructuras').getStore().getAt(pos);
        if(fila.get('idEstructura')!=idEstructura)
        {
        	function resp()
            {
                gEx('txtNombreEstructura').focus();
            }
            msgBox('Ya existe una estructura con el nombre ingresado',resp);
            return true;
        }
    }    
    return false;   
}