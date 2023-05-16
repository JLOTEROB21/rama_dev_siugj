<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	$query="select propiedadUsr,propiedadCss,categoriaEstilo,valorDefault from 934_propiedadesCSS where idIdioma=".$_SESSION["leng"]." order by categoriaEstilo,propiedadUsr";	
	$arrPropiedadesEst=uEJ($con->obtenerFilasArreglo($query));
	
	$query="select opcionUsr,opcionUsr,opcionCss from 935_opcionesCSS where  idIdioma=".$_SESSION["leng"]." and categoria='SiNo' order by orden";
	$arrSiNoCss=uEJ($con->obtenerFilasArreglo($query));
	$query="select opcionUsr,opcionUsr,opcionCss from 935_opcionesCSS where  idIdioma=".$_SESSION["leng"]." and categoria='vAlineacion' order by orden";
	$arrVAlineacion=uEJ($con->obtenerFilasArreglo($query));
	$query="select opcionUsr,opcionUsr,opcionCss from 935_opcionesCSS where  idIdioma=".$_SESSION["leng"]." and categoria='hAlineacion' order by orden";
	$arrHAlineacion=uEJ($con->obtenerFilasArreglo($query));
	$query="select * from (select opcionUsr as nombreFuente,opcionUsr,opcionCss from 935_opcionesCSS where  idIdioma=".$_SESSION["leng"]." and categoria='fuente'
			union
			SELECT nombreFuente,nombreFuente AS opcionUsr,nombreFuente AS opcionCss FROM 932_definicionFuentes) as tmp order by opcionUsr";
	$arrFuentes=uEJ($con->obtenerFilasArreglo($query));
	$query="select opcionUsr,opcionUsr,opcionCss from 935_opcionesCSS where  idIdioma=".$_SESSION["leng"]." and categoria='estiloBorde' order by orden";
	$arrEstilosBorde=uEJ($con->obtenerFilasArreglo($query));
?>

var regEdicionManual=crearRegistro	(	[
                                        {name: 'atributo'},
                                        {name: 'valor'}
                                    ])

function mostrarVentanaAdmonEstilos()
{
	var gridAdmonEstilos=crearGridAdmonEstilos();
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														gridAdmonEstilos

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Administraci&oacute;n de estilos',
										width: 670,
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
																		ventanaAM.close();
																	}
														}
													]
									}
								);
	ventanaAM.show();	
}

function crearGridAdmonEstilos()
{
	 var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idEstilo'},
		                                                {name: 'nombreEstilo'},
		                                                {name:'responsableCreacion'},
		                                                {name:'fechaCreacion', type:'date', dateFormat:'Y-m-d'},
                                                        {name: 'definicionEstilo'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../paginasFunciones/funcionesThot.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'nombreEstilo', direction: 'ASC'},
                                                            groupField: 'nombreEstilo',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='53';
                                        
                                    }
                        )   
       
    var cModelo= new Ext.grid.ColumnModel   	(
                                                    [
                                                        new  Ext.grid.RowNumberer(),
                                                        
                                                        {
                                                            header:'Nombre estilo',
                                                            width:200,
                                                            sortable:true,
                                                            dataIndex:'nombreEstilo',
                                                            renderer:function(val)
                                                            		{
                                                                    	return '<span class="'+val+'">'+val+'</span>';
                                                                    }
                                                        },
                                                        {
                                                            header:'Creado por',
                                                            width:220,
                                                            sortable:true,
                                                            dataIndex:'responsableCreacion'
                                                        },
                                                        {
                                                            header:'Fecha creaci&oacute;n',
                                                            width:110,
                                                            sortable:true,
                                                            dataIndex:'fechaCreacion',
                                                            renderer:formatearSoloFecha
                                                        }
                                                    ]
                                                );
                                                
    var tblGrid=	new Ext.grid.GridPanel	(
                                                        {
                                                            id:'gridEstilosAdmon',
                                                            store:alDatos,
                                                            region:'center',
                                                            frame:true,
                                                            cm: cModelo,
                                                            width:620,
                                                            height:350,
                                                            x:10,
                                                            y:10,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            columnLines : true,
                                                             tbar:	[
                                                            			{
                                                                        	icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Crear nuevo estilo',
                                                                            handler:function()
                                                                            		{
                                                                                    	mostrarVentanaEstilos();
                                                                                    }
                                                                            
                                                                        },'-',
                                                                        {
                                                                        	icon:'../images/pencil.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Modificar estilo',
                                                                            handler:function()
                                                                            		{
                                                                                    	var fila=tblGrid.getSelectionModel().getSelected();
                                                                                        if(fila==null)
                                                                                        {
                                                                                        	msgBox('Debe seleccionar  el estilo que desea modificar');
                                                                                            return;
                                                                                        }
                                                                                    	mostrarVentanaEstilos(fila);
                                                                                    }
                                                                            
                                                                        },'-',
                                                                        {
                                                                        	icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Remover estilo',
                                                                            handler:function()
                                                                            		{
                                                                                    	var fila=tblGrid.getSelectionModel().getSelected();
                                                                                        if(fila==null)
                                                                                        {
                                                                                        	msgBox('Debe seleccionar  el estilo que desea remover');
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
                                                                                                        tblGrid.getStore().remove(fila);
                                                                                                        actualizarValoresEstilo();
                                                                                                    }
                                                                                                    else
                                                                                                    {
                                                                                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                    }
                                                                                                }
                                                                                                obtenerDatosWeb('../paginasFunciones/funcionesThot.php',funcAjax, 'POST','funcion=54&idEstilo='+fila.get('idEstilo'),true);
                                                                                            }
                                                                                        }
                                                                                        msgConfirm('Est&aacute; seguro de querer remover el estilo seleccionado?',resp);
                                                                                    }
                                                                            
                                                                        }
                                                                        
                                                            		],
                                                            view:new Ext.grid.GroupingView({
                                                                                                forceFit: false,
                                                                                                enableGrouping :false
                                                                                            })
                                                        }
                                                    );
    return 	tblGrid;	
}

function mostrarVentanaEstilos(filaEstilo)
{
	controlVPActivo=1;
	var tblAtributos=crearGridAtributosEstilo();
    var tblManual=crearGridEstiloManual();
    var panelVPrevia=new Ext.Panel	(
    								{
                                    	id:'panelVP',
                                    	x:470,
                                        y:40,
                                        width:250,
                                        height:220,
                                        title:'Vista previa',
                                        
                                        autoLoad: {url: '../estilos/vistaPreviaEstilos.php', params: 'control=1'},
                                        tbar:	[
                                        			{
                                                    	xtype:'label',
                                                        html:'&nbsp;<b>Control:</b>&nbsp;&nbsp;'
                                                    },
                                        			{
                                                    	text:'Etiqueta',
                                                        handler:function()
                                                        		{
																	actualizarCss('estilo_tmp');
                                                                	Ext.getCmp('panelVP').load({url: '../estilos/vistaPreviaEstilos.php', params: 'control=1'});
                                                                    controlVPActivo=1;
                                                                }
                                                    },'-',
                                                    {
                                                    	text:'Bot&oacute;n',
                                                        handler:function()
                                                        		{
                                                                	actualizarCss('estilo_tmp');
                                                                	Ext.getCmp('panelVP').load({url: '../estilos/vistaPreviaEstilos.php', params: 'control=2'});
                                                                    controlVPActivo=2;
                                                                }
                                                    },'-',
                                                    {
                                                    	text:'Tabla',
                                                        handler:function()
                                                        		{
                                                                	actualizarCss('estilo_tmp');
                                                                	Ext.getCmp('panelVP').load({url: '../estilos/vistaPreviaEstilos.php', params: 'control=3'});
                                                                    controlVPActivo=3;
                                                                }
                                                    }
                                                    ,'-',
                                                    {
                                                    	text:'Celda',
                                                        handler:function()
                                                        		{
                                                                	actualizarCss('estilo_tmp');
                                                                	Ext.getCmp('panelVP').load({url: '../estilos/vistaPreviaEstilos.php', params: 'control=4'});
                                                                    controlVPActivo=4;
                                                                }
                                                    }
                                        		]
                                    }
    							);
                                
	var desHabilitarNombreEstilo=false;
    if(filaEstilo)
    	desHabilitarNombreEstilo=true;	                                
                                
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'textfield',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:'Nombre del estilo:',
                                                            xtype:'label'
                                                        },
                                                        {
                                                        	x:130,
                                                            y:5,
                                                        	xtype:'textfield',
                                                            id:'txtNombreEstilo',
                                                            width:250,
                                                            disabled:desHabilitarNombreEstilo,
                                                            maskRe:/^[a-zA-Z0-9_]$/
                                                            
                                                        },
                                                        {
                                                        	xtype:'tabpanel',
                                                            x:10,
                                                            y:40,
                                                            width:450,
                                                            height:390,
                                                            activeTab: 0,
                                                            items:	[
                                                            			tblAtributos,
                                                                        tblManual
                                                                    ]
                                                        },
                                                        panelVPrevia
													]
										}
									);
	var ventana = new Ext.Window(
									{
										title: 'Crear estilo',
										width: 750,
										height:520,
										minWidth: 300,
										minHeight: 100,
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
                                                                        Ext.getCmp('txtNombreEstilo').focus(false,100);
                                                                    }
                                                                }
													},
										buttons:	[
														{
															id:'btnAceptar',
															text: 'Aceptar',
															listeners:	{
																			click:function()
																				{
                                                                                	var txtNombreEstilo=Ext.getCmp('txtNombreEstilo');
                                                                                    if(txtNombreEstilo.getValue()=='')
                                                                                    {
                                                                                    	function funcResp()
                                                                                        {
                                                                                        	txtNombreEstilo.focus();
                                                                                        }
                                                                                        
                                                                                    	msgBox('Debe ingresar el nombre del estilo a crear',funcResp);
                                                                                        return;
                                                                                    }
                                                                                    var cadEstilo=generarEstiloFinal(txtNombreEstilo.getValue());
                                                                                    var idEstilo=-1;
                                                                                    if(filaEstilo)
                                                                                    {
                                                                                    	idEstilo=filaEstilo.get('idEstilo');
                                                                                    }
                                                                                    function funcAjax()
                                                                                    {
                                                                                        var resp=peticion_http.responseText;
                                                                                        arrResp=resp.split('|');
                                                                                        if(arrResp[0]=='1')
                                                                                        {
                                                                                        	if(arrResp[1]=='1')
																							{
                                                                                                gEx('gridEstilosAdmon').getStore().reload();
                                                                                                actualizarValoresEstilo();
	                                                                                            ventana.close();
                                                                                            }
                                                                                            else
                                                                                            {
                                                                                            	function resp()
                                                                                                {
                                                                                                	txtNombreEstilo.focus();
                                                                                                }
                                                                                            	msgBox('El nombre de la clase ya se encuentra registrado, por favor ingrese uno diferente',resp);
                                                                                                return;
                                                                                            }                                                                                           
                                                                                        }
                                                                                        else
                                                                                        {
                                                                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                        }
                                                                                    }
                                                                                    obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=41&idEstilo='+idEstilo+'&defEstilo='+cadEstilo,true);
																				}
																		}
														},
														{
															text: 'Cancelar',
															handler:function()
																	{
																		ventana.close();
																	}
														}
													]
									}
								);
		ventana.show();	
        if(filaEstilo)
        {
        	gEx('txtNombreEstilo').setValue(filaEstilo.get('nombreEstilo'));
            descomponerCSS(filaEstilo.get('definicionEstilo'));
			sincronizarAtributosManuales();
            
        }
}

function crearGridAtributosEstilo()
{
	
	var dsNameDTD= 	<?php echo $arrPropiedadesEst?>;					
    
    var lector=new Ext.data.ArrayReader({},	[	{name:'propiedadUsr'},
                                                {name: 'propiedadCss'},
                                                {name: 'categoria'},
                                                {name: 'valor'}
                                             ]
                                         );
    
	var cmFrmDTD= new Ext.grid.ColumnModel   	(
												 	[
													 	{
                                                        	id:'colAtributo',
															header:'Propiedad',
															width:210,
															dataIndex:'propiedadUsr'
														},
														{
                                                        	id:'colValor',
															header:'Valor',
															width:180,
															dataIndex:'valor',
                                                            editor:new Ext.form.TextField({})
														},
                                                        {
                                                        	id:'colCategoria',
															header:'Categor&iacute;a',
															width:180,
															dataIndex:'categoria',
                                                            hidden:true
														}
													]
												);
											
	tblFrmDTD=	new Ext.grid.EditorGridPanel	(
                                                    {
                                                    	border:true,
                                                    	id:'gridAtributosEstilos',
                                                        store:new Ext.data.GroupingStore({
                                                                                            reader: lector,
                                                                                            data: dsNameDTD,
                                                                                            sortInfo:{field: 'propiedadUsr', direction: "ASC"},
                                                                                            groupField:'categoria'
                                                                                        }),
                                                        frame:true,
                                                        clicksToEdit: 1,
                                                        cm: cmFrmDTD,
                                                        height:370,
                                                        columnLines :true,
                                                        width:450,
                                                        title:'Editor de estilos',
                                                        view: new Ext.grid.GroupingView({
                                                                                            forceFit:false,
                                                                                            groupTextTpl: '{text}'
                                                                                        })
                                                    }
							                    );
	tblFrmDTD.on('beforeedit',funcEdicion);    
    tblFrmDTD.on('afteredit',funcEditado);                                                 
	return tblFrmDTD;	
}

function crearGridEstiloManual()
{
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'atributo'},
                                                                    {name: 'valor'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel();
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														chkRow,
														{
															header:'Atributo',
															width:160,
															sortable:true,
															dataIndex:'atributo',
                                                            editor:{xtype:'textfield'}
														},
                                                        {
															header:'Valor',
															width:200,
															sortable:true,
															dataIndex:'valor',
                                                            editor:{xtype:'textfield'}
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gridEstiloManual',
                                                            store:alDatos,
                                                            frame:true,
                                                            border:true,
                                                            title:'Edici&oacute;n manual',
                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            stripeRows :true,
                                                            columnLines : true,
                                                            clicksToEdit:1,
                                                            sm:chkRow,
                                                            tbar:	[
                                                            			{
                                                                        	icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Agregar atributo',
                                                                            handler:function()
                                                                            		{
                                                                                    	var r=new regEdicionManual({atributo:'',valor:''});
                                                                                        tblGrid.getStore().add(r);
                                                                                        tblGrid.startEditing(tblGrid.getStore().getCount()-1,2);
                                                                                    }
                                                                            
                                                                        },'-',
                                                                        {
                                                                        	icon:'../images/table_row_insert.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Importar definici&oacute;n de estilo',
                                                                            handler:function()
                                                                            		{
                                                                                    	mostrarVentanaImportarEstilo();
                                                                                    }
                                                                            
                                                                        },'-',
                                                                        {
                                                                        	icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Remover atributo',
                                                                            handler:function()
                                                                            		{
                                                                                    	var filas=tblGrid.getSelectionModel().getSelections();
                                                                                        if(filas.length==0)
                                                                                        {
                                                                                        	msgBox('Debe seleccionar al menos un atributo para remover');
                                                                                        	return;
                                                                                        }
                                                                                    	function resp(btn)
                                                                                        {
                                                                                        	if(btn=='yes')
                                                                                            {
                                                                                            
                                                                                            	var x;
                                                                                                var propiedad;
                                                                                                var valor="";
                                                                                                var posFila;
                                                                                                var gridAtributosEstilos=gEx('gridAtributosEstilos');
                                                                                                for(x=0;x<filas.length;x++) 
                                                                                                {
                                                                                                	valor="";
                                                                                                	propiedad=filas[x].get('atributo');
                                                                                                	switch(propiedad)
                                                                                                    {
                                                                                                        case 'height':
                                                                                                        case 'width':
                                                                                                        case 'padding-right':
                                                                                                        case 'padding-bottom':
                                                                                                        case 'padding-left':
                                                                                                        case 'padding-top':
                                                                                                        case 'border-right-width':
                                                                                                        case 'border-left-width':
                                                                                                        case 'border-bottom-width':
                                                                                                        case 'border-top-width':
                                                                                                        case 'line-height':
                                                                                                        case 'border-bottom-color':
                                                                                                        case 'border-top-color':
                                                                                                        case 'border-right-color':
                                                                                                        case 'border-left-color':
                                                                                                        case 'color':
                                                                                                        case 'background-color':
                                                                                                           valor='';
                                                                                                        break;
                                                                                                        case 'text-decoration:underline':
                                                                                                        case 'font-weight:bold':
                                                                                                        case 'font-style:italic':
                                                                                                            valor='No';	
                                                                                                        break;
                                                                                                        case 'text-align':
                                                                                                        case 'vertical-align':
                                                                                                            valor='Normal';
                                                                                                        break;
                                                                                                        case 'border-top-style':
                                                                                                        case 'border-bottom-style':
                                                                                                        case 'border-left-style':
                                                                                                        case 'border-right-style':
                                                                                                            valor='Ninguno';
                                                                                                        break;
                                                                                                	}
                                                                                                    
                                                                                                    posFila=obtenerPosFila(gridAtributosEstilos.getStore(),'propiedadCss',filas[x].get('valor'));
                                                                                                    if(posFila!=-1)
                                                                                                    {
                                                                                                    	gridAtributosEstilos.getStore().getAt(posFila).set('valor',valor);
                                                                                                    }	
                                                                                                }
                                                                                            	tblGrid.getStore().remove(filas);
                                                                                                actualizarCss('estilo_tmp');

                                                                                            }
                                                                                        }
                                                                                        msgConfirm('Est&aacute; seguro de querer remover los atributos seleccionados?',resp);
                                                                                    }
                                                                            
                                                                        }
                                                                        
                                                            		]
                                                        }
                                                    );
	tblGrid.on('afteredit',function(e)
    						{
                            	var atributo;
                                var valor;
                                var fila;
                                var valorNormalizado;
                                var atributo=e.record.get('atributo');
                                if(e.field=='valor')	
                                {
                                	var pos=buscarAtributoEditor(e.record.get('atributo'));
                                    if(pos!=-1)
                                    {
                                    	var gridAtributosEstilos=gEx('gridAtributosEstilos');
                                        fila=gridAtributosEstilos.getStore().getAt(pos);
                                        valorNormalizado=e.value.replace(" !important","");
                                        valorNormalizado=valorNormalizado.replace("px","");
                                        switch(atributo)
                                        {
                                            case 'text-decoration:underline':
                                            case 'font-weight:bold':
                                            case 'font-style:italic':
                                                valorNormalizado='Si';
                                            break;
                                            case 'text-align':
                                            	var posArreglo=existeValorMatriz(arrHAlineacion,valorNormalizado.toLowerCase(),2);
                                                if(posArreglo!=-1)
	                                                valorNormalizado=arrHAlineacion[posArreglo][1];
                                            break;
                                            case 'vertical-align':
                                                var posArreglo=existeValorMatriz(arrVAlineacion,valorNormalizado.toLowerCase(),2);
                                                if(posArreglo!=-1)
	                                                valorNormalizado=arrVAlineacion[posArreglo][1];
                                            break;
                                            case 'border-top-style':
                                            case 'border-bottom-style':
                                            case 'border-left-style':
                                            case 'border-right-style':
	                                            var posArreglo=existeValorMatriz(arrEstilosBorde,valorNormalizado.toLowerCase(),2);
                                                if(posArreglo!=-1)
	                                                valorNormalizado=arrEstilosBorde[posArreglo][1];

                                            break;
                                        }
                                        
                                        fila.set('valor',valorNormalizado);
                                        
                                    }
                                    actualizarCss('estilo_tmp');
                                }
                            }
    		)                                                    
	return 	tblGrid;	
}

var arrSiNoCss=<?php echo $arrSiNoCss?>;
var arrVAlineacion=<?php echo $arrVAlineacion?>;
var arrHAlineacion=<?php echo $arrHAlineacion?>;
var arrFuentes=<?php echo $arrFuentes?>;
var arrEstilosBorde=<?php echo $arrEstilosBorde?>;

function funcEdicion(e)
{
	var ctrlColor=new Ext.grid.GridEditor(new Ext.form.ColorField(	{
                                                                        id: 'color'
                                                                    }
                                                                 )
                                         );
	
	var ctrlNumero=new Ext.form.NumberField({allowDecimals:false,allowNegative:false});
    var ctrlNumeroF=new Ext.form.NumberField({allowDecimals:true,allowNegative:false});
    var ctrlImagen;
    var ctrlHorizontal=crearComboExt('cmbAHorizontal',arrHAlineacion);
    var ctrlVertical=crearComboExt('cmbAVertical',arrVAlineacion);
    var ctrlSiNo=crearComboExt('cmbSiNoAtt',arrSiNoCss);
    var ctrlFuente=crearComboExt('cmbFuentes',arrFuentes);
    var cmbEstilosB=crearComboExt('cmbEstilosB',arrEstilosBorde);
    
	var grid=e.grid;
    var cModel=grid.getColumnModel();
    var fila=e.record;
    var propiedad=fila.get('propiedadCss');
    switch(propiedad)
    {
    	case 'height':
        case 'width':
        case 'padding-right':
	    case 'padding-bottom':
        case 'padding-left':
        case 'padding-top':
        case 'border-right-width':
        case 'border-left-width':
        case 'border-bottom-width':
        case 'border-top-width':
        case 'font-size':
        	cModel.setEditor(1,ctrlNumero);
		break;
        case 'line-height':
        	cModel.setEditor(1,ctrlNumeroF);
        break;
        case 'text-decoration:underline':
        case 'font-weight:bold':
        case 'font-style:italic':
        	cModel.setEditor(1,ctrlSiNo);
        break;
        case 'text-align':
        	cModel.setEditor(1,ctrlHorizontal);
        break;
        case 'vertical-align':
        	cModel.setEditor(1,ctrlVertical);
        break;
        case 'font-family':
        	cModel.setEditor(1,ctrlFuente);
        break;
        case 'border-top-style':
        case 'border-bottom-style':
        case 'border-left-style':
        case 'border-right-style':
        	cModel.setEditor(1,cmbEstilosB);
        break;
        case 'border-bottom-color':
        case 'border-top-color':
        case 'border-right-color':
        case 'border-left-color':
        case 'color':
        case 'background-color':
        	cModel.setEditor(1,ctrlColor);
        break;
        default:
        	e.cancel=true;
    }
}	

function funcEditado(e)
{
    actualizarCss('estilo_tmp');
	Ext.getCmp('panelVP').load({url: '../estilos/vistaPreviaEstilos.php', params: 'control='+controlVPActivo});
}

function generarEstilo(nombreEstilo)
{
	var x;
    var dSet=Ext.getCmp('gridAtributosEstilos').getStore();
    var propiedad;
    var fila;
	var cuerpo='';
    var vPropiedad='';
    var estilo='';
    for(x=0;x<dSet.getCount();x++)
    {
    	fila=dSet.getAt(x);
        propiedad=fila.get('propiedadCss');
        valor=fila.get('valor');
        vPropiedad='';
        switch(propiedad)
        {
            case 'height':
            case 'width':
            case 'padding-right':
            case 'padding-bottom':
            case 'padding-left':
            case 'padding-top':
            case 'border-right-width':
            case 'border-left-width':
            case 'border-bottom-width':
            case 'border-top-width':
            case 'font-size':
               if((valor!='')&&(valor!='0'))
               		vPropiedad=propiedad+':'+valor+'px'+' !important';	
            break;
            case 'line-height':
               if((valor!='')&&(parseInt(valor)>0))
               		vPropiedad=propiedad+':'+valor+'px'+' !important';		
            break;
            case 'text-decoration:underline':
            case 'font-weight:bold':
            case 'font-style:italic':
            	if(valor=='Si')
                	vPropiedad=propiedad+' !important';	
            break;
            case 'text-align':
            	if(valor!='Normal')
                {
                	var pos=existeValorMatriz(arrHAlineacion,valor,0);
                    valor=arrHAlineacion[pos][2];
               		vPropiedad=propiedad+':'+valor+' !important';	
                }
            break;
            case 'vertical-align':
                if(valor!='Normal')
                {
                	var pos=existeValorMatriz(arrVAlineacion,valor,0);
                    valor=arrVAlineacion[pos][2];
                	vPropiedad=propiedad+':'+valor+' !important';	
                }
            break;
            case 'font-family':
               	vPropiedad=propiedad+':'+valor+' !important'	;
            break;
            case 'border-top-style':
            case 'border-bottom-style':
            case 'border-left-style':
            case 'border-right-style':
                if(valor!='Ninguno')
                {
                	var pos=existeValorMatriz(arrEstilosBorde,valor,0);
                    valor=arrEstilosBorde[pos][2];
                	vPropiedad=propiedad+':'+valor+' !important';		
                }
            break;
            case 'border-bottom-color':
            case 'border-top-color':
            case 'border-right-color':
            case 'border-left-color':
            case 'color':
            case 'background-color':
            	if((valor!=''))
               		vPropiedad=propiedad+':'+valor+' !important';		
               
            break;
            
        }
        
        if(vPropiedad!='')
        {
        	if(cuerpo=='')
            	cuerpo=vPropiedad;
            else
            	cuerpo+=';'+vPropiedad;
        }
        else
        {
        	var pos=buscarAtributo(propiedad);
            if(pos!=-1)
            {
            	var gridEstiloManual=gEx('gridEstiloManual');
            	var fila=gridEstiloManual.getStore().getAt(pos);
                gridEstiloManual.getStore().remove(fila);
            }
        }
        
	}    
    estilo='.'+nombreEstilo+'{'+cuerpo+'}';
    
    return estilo;
}

function generarEstiloFinal(nombreEstilo)
{
	var x;
    var dSet=Ext.getCmp('gridEstiloManual').getStore();
    var propiedad;
    var fila;
	var cuerpo='';
    var vPropiedad='';
    var estilo='';
    for(x=0;x<dSet.getCount();x++)
    {
    	fila=dSet.getAt(x);
        if((fila.get('atributo')!='')&&(fila.get('valor')!="")&&(fila.get('valor')!="0"))
        	cuerpo+=fila.get('atributo')+':'+fila.get('valor')+';';
	}    
    estilo='.'+nombreEstilo+'{'+cuerpo+'}';
    return estilo;
}

function actualizarCss(nEstilo)
{
	var tEstilo=gE(nEstilo);
    if(tEstilo!=null)
    	tEstilo.parentNode.removeChild(tEstilo);
	var estilo = document.createElement("style");
	estilo.type = "text/css";
    estilo.id=nEstilo;
    var contenido=generarEstilo(nEstilo);
    descomponerCSS(contenido);
    contenido=generarEstiloFinal(nEstilo);
    if (estilo.styleSheet)
   		estilo.styleSheet.cssText = contenido;
    else 
	   	estilo.appendChild(document.createTextNode(contenido));
    document.getElementsByTagName("head")[0].appendChild(estilo);
	
}

function actualizarValoresEstilo()
{
	var gridEstilosAdmon=gEx('gridEstilosAdmon');
    var arrEstilos=[];
    var x;
    var fila;
    for(x=0;x<gridEstilosAdmon.getStore().getCount();x++)
    {
    	fila=gridEstilosAdmon.getStore().getAt(x);
    	arrEstilos.push([fila.get('nombreEstilo'),fila.get('nombreEstilo')]);
    }
    gEx('cmbEstilos').getStore().loadData(arrEstilos);
}

function descomponerCSS(estilo)
{
	if(estilo.indexOf('{')==-1)
    	estilo='{'+estilo;
	var arrEstilo=estilo.split('{');
    estilo=arrEstilo[1];
    arrEstilo=estilo.split('}');
    estilo=arrEstilo[0];
	arrEstilo=estilo.split(';');
    var x;
    var estilo;
    var arrAtributo;
    var gridEstiloManual=gEx('gridEstiloManual');
    var r;
    var pos;
    var fila;
    var valorNormalizado;
    for(x=0;x<arrEstilo.length;x++)
    {
    	estilo=arrEstilo[x];
        arrAtributo=estilo.split(':');
        pos=buscarAtributo(arrAtributo[0].trim());
        if(arrAtributo[1]!=undefined)
	        valorNormalizado=arrAtributo[1].trim();
        else
        	continue;
        
        if(pos==-1)
        {
            r=new regEdicionManual({atributo:arrAtributo[0].trim(),valor:valorNormalizado});
            gridEstiloManual.getStore().add(r);
        }
        else
        {
        	fila=gridEstiloManual.getStore().getAt(pos);
            fila.set('atributo',arrAtributo[0].trim());
            fila.set('valor',valorNormalizado);
        }
    }
    
}

function buscarAtributo(atributo)
{
	var gridEstiloManual=gEx('gridEstiloManual');
    var x;
    var fila;
    var pos=-1;
    var valNormalizado;
    for(x=0;x<gridEstiloManual.getStore().getCount();x++)
    {
    	fila=gridEstiloManual.getStore().getAt(x);
        valNormalizado=fila.get('atributo');
        valNormalizado=valNormalizado.replace(/:/gi,'');
        valNormalizado=valNormalizado.toLowerCase();
        if(valNormalizado==atributo.toLowerCase())
        	return x;
    }
    return -1;
}

function buscarAtributoEditor(atributo)
{
	var gridAtributosEstilos=gEx('gridAtributosEstilos');
    var x;
    var fila;
    var pos=-1;
    var valNormalizado;
    for(x=0;x<gridAtributosEstilos.getStore().getCount();x++)
    {
    	fila=gridAtributosEstilos.getStore().getAt(x);
        valNormalizado=fila.get('propiedadCss');
        valNormalizado=valNormalizado.toLowerCase();
        if(valNormalizado==atributo.toLowerCase())
        	return x;
    }
    return -1;
}

function sincronizarAtributosManuales()
{
	var gridEstiloManual=gEx('gridEstiloManual');
    var gridAtributosEstilos=gEx('gridAtributosEstilos');
    var x;
    var pos
    var fila;
    var atributo;
    for(x=0;x<gridEstiloManual.getStore().getCount();x++)
    {
    	filaOrigen=gridEstiloManual.getStore().getAt(x);
        
        pos=buscarAtributoEditor(filaOrigen.get('atributo'));
        if(pos!=-1)
        {
            fila=gridAtributosEstilos.getStore().getAt(pos);
            valorNormalizado=filaOrigen.get('valor').replace(" !important","");
            valorNormalizado=valorNormalizado.replace("px","");
            atributo=filaOrigen.get('atributo');
            switch(atributo)
            {
                case 'text-decoration:underline':
                case 'font-weight:bold':
                case 'font-style:italic':
                    valorNormalizado='Si';
                break;
                case 'text-align':
                    var posArreglo=existeValorMatriz(arrHAlineacion,valorNormalizado.toLowerCase(),2);
                    if(posArreglo!=-1)
                        valorNormalizado=arrHAlineacion[posArreglo][1];
                break;
                case 'vertical-align':
                    var posArreglo=existeValorMatriz(arrVAlineacion,valorNormalizado.toLowerCase(),2);
                    if(posArreglo!=-1)
                        valorNormalizado=arrVAlineacion[posArreglo][1];
                break;
                case 'border-top-style':
                case 'border-bottom-style':
                case 'border-left-style':
                case 'border-right-style':
                    var posArreglo=existeValorMatriz(arrEstilosBorde,valorNormalizado.toLowerCase(),2);
                    if(posArreglo!=-1)
                        valorNormalizado=arrEstilosBorde[posArreglo][1];
                break;
            }
            fila.data.valor=valorNormalizado;
        }
    }
    actualizarCss('estilo_tmp');
}

function mostrarVentanaImportarEstilo()
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
                                                            html:'Ingrese el estilo que desea importar:'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            width:450,
                                                            height:160,
                                                            xtype:'textarea',
                                                            id:'txtEstilo'
                                                        }

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Importar definici&oacute;n de estilo',
										width: 500,
										height:300,
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
                                                                	gEx('txtEstilo').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
																		var txtEstilo=gEx('txtEstilo');
                                                                        if(txtEstilo.getValue().trim()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	txtEstilo.focus();
                                                                            }
                                                                            msgBox('Debe ingresar el estilo que desea importar',resp);
                                                                        }
                                                                        
                                                                        gEx('gridEstiloManual').getStore().removeAll();
                                                                        gEx('gridAtributosEstilos').getStore().loadData(<?php echo $arrPropiedadesEst?>);
                                                                        descomponerCSS(txtEstilo.getValue().trim());
                                                                        sincronizarAtributosManuales();
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

