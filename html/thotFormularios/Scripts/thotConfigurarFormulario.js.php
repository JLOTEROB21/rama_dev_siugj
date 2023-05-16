<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	$consulta="select valor,texto from  1004_siNo where idIdioma=".$_SESSION["leng"];
	$arrSiNo=$con->obtenerFilasArreglo($consulta);
?>
Ext.onReady(inicializar);
var nodoSel=null;
var arrParamConfiguraciones;
var idElementoSel='';
var divCtrlSel=null;
var arrCamposAlmacen;
var h=null;
var arrSiNo=<?php echo $arrSiNo?>;
var objFinal=null;
var idFormulario;

var arrCamposGrid=[
					  {name: 'idRegistroCampo'},
					  {name: 'idCampo'},
                      {name: 'cabecera'},
                      {name: 'ancho'},
                      {name: 'tipoCampo'},
                      {name: 'obligatorio'},
                      {name: 'tablaVinculada'},
                      {name: 'tablaOriginalVinculada'},
                      {name: 'campoVinculado'},
                      {name: 'campoUsrVinculado'},
	                  {name: 'campoUsrLlave'},
                      {name: 'campoLlave'},
                      {name: 'visible'},
                      {name: 'orden'},
                      {name: 'param'},
                      {name: 'pieColumna'},
                      {name: 'formatoColumna'},
                      {name: 'textoPie'},
                      {name: 'campoDepositoPie'},
                      {name: 'complementario'}
                  ]

var registroCampoGrid=crearRegistro	(arrCamposGrid);

var arrTipoCampo=[['14','Area de texto'],['12','Archivo'],['11','Checkbox'],['13','Editor de color'],['2','Decimal'],['1','Entero'],['6','Fecha'],['7','Hora'],['5','Moneda'],['3','Texto'],['8','Vinculado a C\xE1lculo'],['4','Vinculado a tabla'],['10','Vinculado a almac\xe9n de datos']];

Ext.override	(Ext.grid.PropertyColumnModel, 
                                            {
                                                renderCell : function(val, meta, r)
                                                {
                                                    var renderer = this.grid.customRenderers[r.get('name')];
                                                    if(renderer)
                                                    {
                                                        return renderer.apply(this, arguments);
                                                    }
                                                    var rv = val;
                                                    if(Ext.isDate(val))
                                                    {
                                                        rv = this.renderDate(val);
                                                    }
                                                    else 
                                                        if(typeof val == 'boolean')
                                                        {
                                                            rv = this.renderBool(val);
                                                        }
                                                    return Ext.util.Format.htmlEncode(rv);
                                                }
                                            }
				);
                
Ext.override	(Ext.grid.PropertyGrid, 
                                        {
                                            initComponent : function()
                                            {
                                                this.customRenderers = this.customRenderers || {};
                                                this.customEditors = this.customEditors || {};
                                                this.lastEditRow = null;
                                                var store = new Ext.grid.PropertyStore(this);
                                                this.propStore = store;
                                                var cm = new Ext.grid.PropertyColumnModel(this, store);
                                                store.store.sort('name', 'ASC');
                                                this.addEvents
                                                (
                                                    'beforepropertychange',
                                                    'propertychange'
                                                );
                                                this.cm = cm;
                                                this.ds = store.store;
                                                Ext.grid.PropertyGrid.superclass.initComponent.call(this);
                                                this.mon(this.selModel, 'beforecellselect', function(sm, rowIndex, colIndex)
                                                                                            {
                                                                                                if(colIndex === 0)
                                                                                                {
                                                                                                    this.startEditing.defer(200, this, [rowIndex, 1]);
                                                                                                    return false;
                                                                                                }
                                                                                            }, 
                                                         this);
                                            },
                                            setProperty: function(property, value)
                                            {
                                                this.propStore.source[property] = value;
                                                var r = this.propStore.store.getById(property);
                                                if(r)
                                                {
                                                    r.set('value', value);
                                                }
                                                else
                                                {
                                                    r = new Ext.grid.PropertyRecord({name: property, value: value}, property);
                                                    this.propStore.store.add(r);
                                                }
                                            },
                                            removeProperty: function(property)
                                            {
                                                delete this.propStore.source[property];
                                                var r = this.propStore.store.getById(property);
                                                if(r)
                                                {
                                                    this.propStore.store.remove(r);
                                                }
                                            }
                                        }
					);

var ctrlDestino=null;
var tVSesion=[['1','Idioma activo en el sistema'],['2','Rol del usuario activo en el sistema'],['3','Identificador del usuario activo en el sistema'],['4','Login del usuario activo en el sistema'],['5','Nombre del usuario activo en el sistema'],['6','Fecha del sistema'],['7','Hora del sistema']];

function inicializar()
{
	var valorAncho=gE('ancho').value;
    var valorAlto=gE('alto').value;
    var idFrm=gE('idFormulario').value;
    idFormulario=idFrm;
	Ext.QuickTips.init();
    var obj={};
    obj.permitirRegistroParametro=true;
    altura=obtenerDimensionesNavegador()[1];
    obj.alto=altura;
    obj.idReferencia=idFrm;
    obj.tDataSet=5;
    obj.region='east';
    obj.collapsible=true;
    obj.title='<b>Almacenes de datos</b>';
    obj.tituloConcepto='el formulario';

    var gridPropiedades=inicializarGrid();    
    
    var arbolAlmacen=crearArbolAlmacen(obj);
	var pagRegresar=gE('pagRegresar').value;    
    var nUsuario=gE('nUsuario').value;
    
    <?php 
		$arrDesHablitado=array();
	?>
    
    var viewport = new Ext.Viewport({
                                        layout: 'border',
                                        
                                        items: [
                                                	{
                                                    	xtype:'panel',
                                                        layout:'border',
                                                        region:'center',
                                                    	tbar:	[
                                                                    {
                                                                        icon:'../images/salir.gif',
                                                                        cls:'x-btn-text-icon',
                                                                        text:'Cerrar',
                                                                        hidden:(gE('vistaIframe').value=='0'),
                                                                        handler:function()
                                                                                {
                                                                                    window.parent.cerrarVentanaFancy();
                                                                                }
                                                                        
                                                                    },
                                                                    {
                                                                        icon:'../images/regresar.png',
                                                                        cls:'x-btn-text-icon',
                                                                        text:'Regresar',
                                                                         hidden:(gE('vistaIframe').value=='1'),
                                                                        handler:function()
                                                                                {
                                                                                    regresarPagina();
                                                                                }
                                                                        
                                                                    }
                                                                ],
                                                                items:	[
                                                                            {
                                                                                layout: 'fit',
                                                                                id: 'layout-browser',
                                                                                region:'west',
                                                                                
                                                                                border: true,
                                                                                split:true,
                                                                                width: 350,
                                                                                collapsible:true,
                                                                                title: 'Propiedades del grid',
                                                                                hideCollapseTool :false,
                                                                                layoutConfig:{
                                                                                                animate:true
                                                                                            },
                                                                               
                                                                                items: 	[
                                                                                            
                                                                                            {
                                                                                                layout:'border',
                                                                                                region: 'north',
                                                                                                id: 'menuDTD', 
                                                                                                border: false,
                                                                                                split:true,
                                                                                                width: 250,
                                                                                                
                                                                                                collapsible:false,
                                                                                                items:	[
                                                                                                            {
                                                                                                                layout:'absolute',
                                                                                                                xtype:'form',
                                                                                                               
                                                                                                                region: 'north',
                                                                                                                height: 160,
                                                                                                                bodyStyle:'background-color:#DFE8F6;border-color:#DFE8F6',
                                                                                                                items:	[
                                                                                                                            {
                                                                                                                                x:15,
                                                                                                                                y:15,
                                                                                                                                html:'Ancho:',
                                                                                                                                bodyStyle:'background-color:#DFE8F6;border-color:#DFE8F6'
                                                                                                                            },
                                                                                                                            {
                                                                                                                                id:'txtAncho',
                                                                                                                                xtype:'numberfield',
                                                                                                                                width:55,
                                                                                                                                x:75,
                                                                                                                                y:12,
                                                                                                                                value:valorAncho,
                                                                                                                                listeners:	{
                                                                                                                                                change:function(ctrl,valor)
                                                                                                                                                        {
                                                                                                                                                            h.setAncho(valor);
                                                                                                                                                        }
                                                                                                                                            }
                                                                                                                            },
                                                                                                                            {
                                                                                                                                xtype:'label',
                                                                                                                                x:140,
                                                                                                                                y:15,
                                                                                                                                html:'px'
                                                                                                                            },
                                                                                                                            {
                                                                                                                                x:15,
                                                                                                                                y:45,
                                                                                                                                html:'Alto:',
                                                                                                                                bodyStyle:'background-color:#DFE8F6;border-color:#DFE8F6'
                                                                                                                            },
                                                                                                                            {
                                                                                                                                id:'txtAlto',
                                                                                                                                xtype:'numberfield',
                                                                                                                                width:55,
                                                                                                                                x:75,
                                                                                                                                y:42,
                                                                                                                                value:valorAlto,
                                                                                                                                listeners:	{
                                                                                                                                                change:function(ctrl,valor)
                                                                                                                                                        {
                                                                                                                                                            h.setAlto(valor);
                                                                                                                                                        
                                                                                                                                                        }
                                                                                                                                            }
                                                                                                                            },
                                                                                                                             {
                                                                                                                                xtype:'label',
                                                                                                                                x:140,
                                                                                                                                y:45,
                                                                                                                                html:'px'
                                                                                                                            },
                                                                                                                            {
                                                                                                                                xtype:'checkbox',
                                                                                                                                id:'chkMostrarRejilla',
                                                                                                                                x:15,
                                                                                                                                y:75,
                                                                                                                                checked:true,
                                                                                                                                handler:function(chk,valor)
                                                                                                                                        {
                                                                                                                                            h.mostrarRejila(valor);
                                                                                                                                        }
                                                                                                                                
                                                                                                                            },
                                                                                                                            {
                                                                                                                                x:35,
                                                                                                                                y:80,
                                                                                                                                xtype:'label',
                                                                                                                                html:'Mostrar rejilla'
                                                                                                                            },
                                                                                                                            {
                                                                                                                                xtype:'checkbox',
                                                                                                                                id:'chkMostrarMarco',
                                                                                                                                x:15,
                                                                                                                                y:105,
                                                                                                                                checked:true,
                                                                                                                                handler:function(chk,valor)
                                                                                                                                        {
                                                                                                                                            h.mostrarMarco(valor);
                                                                                                                                        }
                                                                                                                                
                                                                                                                            },
                                                                                                                            {
                                                                                                                                x:35,
                                                                                                                                y:110,
                                                                                                                                xtype:'label',
                                                                                                                                html:'Mostrar marco'
                                                                                                                            },
                                                                                                                            {
                                                                                                                                x:30,
                                                                                                                                y:140,
                                                                                                                                xtype:'label',
                                                                                                                                html:'<a href="javascript:obtenerURLLlenado()">Obtener XML informaci&oacute;n</a>'
                                                                                                                            },
                                                                                                                            {
                                                                                                                                x:190,
                                                                                                                                y:140,
                                                                                                                                xtype:'label',
                                                                                                                                html:'<a href="javascript:normalizarFormulario()">Normalizar formulario</a>'
                                                                                                                            }
                                                                                                                        ]
                                                                                                                
                                                        
                                                        
                                                                                                            },
                                                                                                            gridPropiedades
                                                                                                        ]
                                                                                            }
                                                                                            
                                                                                        ]
                                                                            },
                                                                            {
                                                                                layout: 'fit',
                                                                                id: 'layout-browser2',
                                                                                region:'east',
                                                                                border: true,
                                                                                split:false,
                                                                               
                                                                                width: 255,
                                                                                collapsible:true,
                                                                                hideCollapseTool :false,
                                                                                layoutConfig:{
                                                                                                animate:true
                                                                                            },
                                                                                items: 	[
                                                                                            
                                                                                            {
                                                                                                layout:'accordion',
                                                                                                region: 'north',
                                                                                                id: 'menuDTD2', 
                                                                                                border: false,
                                                                                                split:true,
                                                                                                width: 250,
                                                                                                collapsible:false,
                                                                                                items:	[
                                                                                                            
                                                                                                            {
                                                                                                                layout:'absolute',
                                                                                                                xtype:'form',
                                                                                                                title: '<b>Cuadro de herramientas</b>',
                                                                                                                region: 'south',
                                                                                                                height: 225,
                                                                                                                bodyStyle:'background-color:#DFE8F6;border-color:#DFE8F6',
                                                                                                                items:	[
                                                                                                                            <?php
                                                                                                                                echo generarControlesFormulario($arrDesHablitado);
                                                                                                                            ?>
                                                                                                                            
                                                                                                                        ]
                                                                                                                
                                                                          
                                                                          
                                                                                                            },
                                                                                                            arbolAlmacen
                                                                                                                       
                                                                                                             
                                                        
                                                                                                        ]
                                                                                            }
                                                                                            
                                                                                        ]
                                                                            }
                                                                            ,
                                                                            {
                                                                                
                                                                                region:'center',
                                                                                id:'tblCenter',
                                                                                title:'',
                                                                                autoScroll: true,
                                                                                xtype:'iframepanel',
                                                                                deferredRender: false,
                                                                                loadMask:	{
                                                                                                msg:'Cargando'
                                                                                            },
                                                                                autoLoad:	{
                                                                                                url:'../thotFormularios/configurarFormulario.php',
                                                                                                scripts:true,
                                                                                                params:	{
                                                                                                            cPagina:'sFrm=true',
                                                                                                            idFormulario:idFrm,
                                                                                                            anchoGrid:valorAncho,
                                                                                                            altoGrid:valorAlto
                                                                                                        }
                                                                                            }
                                                                            }
                                                                        ]
                                                    }
                                                    
                                                
                                              ]
                                    });
        
        <?php
			foreach($arrDesHablitado as $btn)
			{
				echo "gEx('".$btn."').disable();";	
			}
		?>
        
        gridPropiedades.setHeight (obtenerDimensionesNavegador()[0]-250);
}


function obtenerURLLlenado()
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
                                                            html:'<b>ID de Proceso:</b>'
                                                        },
                                                        {
                                                        	x:150,
                                                            y:10,
                                                            html:'<span style="color:#900"><b>'+gE('idProceso').value+'</b></span>'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            html:'<b>ID de Formulario:</b>'
                                                        },
                                                        {
                                                        	x:150,
                                                            y:40,
                                                            html:'<span style="color:#900"><b>'+gE('idFormulario').value+'</b></span>'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:70,
                                                            html:'<b>XML de informaci&oacute;n:</b>'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:100,
                                                            readOnly:true,
                                                            xtype:'textarea',
                                                            width:700,
                                                            height:350,
                                                            id:'txtXMLFormulario'
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'XML de informaci&oacute;n',
										width: 750,
										height:550,
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
                                                                	cargarXMLFormulario();
																}
															}
												},
										buttons:	[
														
														{
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler:function()
																	{
																		ventanaAM.close();
																	}
														}
													]
									}
								);
	ventanaAM.show();	
    return;
    
    var arrAcciones=[[bE('window.parent.cargarRegistro('+idFormulario+',@idRegistro);return;'),'Mostrar ficha de informaci\xF3n capturada'],[bE('window.close();return;'),'Cerrar ventana de captura']];
	var cmbAccion=crearComboExt('cmbAccion',arrAcciones,300,95,290);
    cmbAccion.setValue(bE('window.parent.cargarRegistro('+idFormulario+',@idRegistro);return;'));
    cmbAccion.on('select',function()
    						{
                            	generarURLLlenado()
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
                                                            html:'URL de llenado:'
                                                        },
                                                        {
                                                        	x:120,
                                                            y:5,
                                                            xtype:'textarea',
                                                            width:500,
                                                            height:80,
                                                            readOnly:true,
                                                            id:'urlLlenado'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:100,
                                                            xtype:'fieldset',
                                                            width:630,
                                                            height:180,
                                                            layout:'absolute',
                                                            title:'Opciones de configuraci&oacute;n:',
                                                            items:	[		
                                                            			{
                                                                        	x:10,
                                                                            y:10,
                                                                            id:'chkOcultaMarco',
                                                                            xtype:'checkbox',
                                                                            boxLabel :'Ocultar encabezados y marco del sitio',
                                                                            listeners:	{
                                                                            				check:function()
                                                                                            		{
                                                                                                    	generarURLLlenado()
                                                                                                    }
                                                                            			}
                                                                        },
                                                                        {
                                                                        	x:10,
                                                                            y:40,
                                                                            id:'chkPasoReferencia',
                                                                            xtype:'checkbox',
                                                                            boxLabel :'Permitir paso de valor de referencia',
                                                                            listeners:	{
                                                                            				check:function(chk,valor)
                                                                                            		{
                                                                                                    	if(valor)
                                                                                                        	gEx('chkMismoValor').enable();
                                                                                                        else
                                                                                                        	gEx('chkMismoValor').disable();
                                                                                                    	generarURLLlenado()
                                                                                                    }
                                                                            			}
                                                                        },
                                                                        {
                                                                        	x:300,
                                                                            y:40,
                                                                            disabled:true,
                                                                            id:'chkMismoValor',
                                                                            xtype:'checkbox',
                                                                            boxLabel :'Evitar registros con el mismo valor de referencia',
                                                                            listeners:	{
                                                                            				check:function()
                                                                                            		{
                                                                                                    	generarURLLlenado()
                                                                                                    }
                                                                            			}
                                                                        },
                                                                        {
                                                                        	x:10,
                                                                            y:70,
                                                                            id:'chkBotonCerrar',
                                                                            xtype:'checkbox',
                                                                            boxLabel :'Mostrar bot&oacute;n de cierre de ventana',
                                                                            listeners:	{
                                                                            				check:function()
                                                                                            		{
                                                                                                    	generarURLLlenado()
                                                                                                    }
                                                                            			}
                                                                        },
                                                                        {
                                                                        	x:10,
                                                                            y:100,
                                                                            xtype:'label',
                                                                            html:'Acci&oacute;n a realizar despu&eacute;s de guardar informaci&oacute;n:'
                                                                        },
                                                                        cmbAccion
                                                            		]
                                                        }

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'URL de llenado',
										width: 700,
										height:370,
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
															handler:function()
																	{
																		ventanaAM.close();
																	}
														}
													]
									}
								);
	ventanaAM.show();
    generarURLLlenado();	
}

function cargarXMLFormulario()
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            gEx('txtXMLFormulario').setValue(bD(arrResp[1]));
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=302&iF='+gE('idFormulario').value,true);
    
}


function generarURLLlenado()
{
	var cadena='<?php echo $urlSitio?>/principal/visorFormulario.php?iF='+bE(idFormulario)+'&iR=-1';
    cadena+='&eJ='+gEx('cmbAccion').getValue();
    var chkOcultaMarco=gEx('chkOcultaMarco');
    if(chkOcultaMarco.getValue())
    	cadena+='&sF='+bE(1);
    var chkPasoReferencia=gEx('chkPasoReferencia');
    if(chkPasoReferencia.getValue())
    {
    	cadena+='&idRef=<valorReferencia>';
    	var chkMismoValor=gEx('chkMismoValor');
        if(chkMismoValor.getValue())
        	cadena+='&refU='+bE(1);
    }
    var chkBotonCerrar=gEx('chkBotonCerrar');
    if(chkBotonCerrar.getValue())
    	cadena+='&mC='+bE(1);
    gEx('urlLlenado').setValue(cadena);
}

function normalizarFormulario()
{
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
                   recargarPagina();
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=307&iF='+gE('idFormulario').value,true);
        }
    }
    msgConfirm('¿Est&aacute; seguro de querer normalizar el formulario?',resp);

}