<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$consulta="SELECT idTipoRegistro,nombreTipoRegistro FROM 00019_tiposRegistroBitacora order by nombreTipoRegistro";
	$arrTipoEvento=$con->obtenerFilasArreglo($consulta);
?>
var arrTipoEvento=<?php echo $arrTipoEvento?>;
var tamPaginacion=500;
var idUsuario=-1;

Ext.onReady(inicializar);

function inicializar()
{
	arrTipoEvento.splice(0,0,['-1','Cualquiera']);
	
    
	 var oConf=	{
    					idCombo:'cmbUsuario',
                        anchoCombo:350,
                        raiz:'personas',
                        campoDesplegar:'Nombre',
                        campoID:'idUsuario',
                        funcionBusqueda:1,
                        ctCls:'campoComboWrapSIUGJAutocompletar',
		                listClass:'listComboSIUGJ',
                        renderTo:'cmbUsuarioHistorial',
                        paginaProcesamiento:'../Usuarios/procesarbUsuario.php',
                        confVista:'<tpl for="."><div class="search-item">({idUsuario}) {Nombre}<br></div></tpl>',
                        campos:	[
                                    {name:'Nombre'},
                                    {name:'idUsuario'}

                                ],
                       	funcAntesCarga:function(dSet,combo)
                    				{
                                    	idUsuario=-1;
                                    	var aValor=combo.getRawValue();
										dSet.baseParams.campoBusqueda=5;
                                        dSet.baseParams.criterio=aValor;
                                        
                                        
                                        
                                    },
                      	funcElementoSel:function(combo,registro)
                    				{
                                    	idUsuario=registro.data.idUsuario;
                                        
                                    }  
    				};

	
    
    new Ext.Viewport(	{
                                layout: 'border',
                                items: [
                                            {
                                                xtype:'panel',
                                                region:'center',
                                                layout:'border',
                                                cls:'panelSiugj',
                                                border:false,
                                                title: 'Auditoria y monitoreo',
                                                tbar: 	[
                                                			{
                                                            	xtype:'label',
                                                                html:'<div class="letraNombreTableroNegro">Observar historial de acceso del usuario:</div>'
                                                            },
                                                            {
                                                              xtype:'tbspacer',
                                                              width:10
                                                            },
                                                            {
                                                              xtype:'label',
                                                              html:'<div id="cmbUsuarioHistorial"></div>'
                                                            },
                                                            {
                                                              xtype:'tbspacer',
                                                              width:10
                                                            },
                                                            {
                                                            	xtype:'label',

                                                                html:'<div class="letraNombreTableroNegro">Periodo del:</div>'
                                                            },
                                                            {
                                                              xtype:'tbspacer',
                                                              width:10
                                                            },
                                                            {
                                                            	xtype:'label',

                                                                html:'<div id="divDteInicio" style="widows:140"></div>'
                                                            },
                                                            
                                                            {
                                                              xtype:'tbspacer',
                                                              width:10
                                                            },
                                                            {
                                                            	xtype:'label',
                                                                html:'<div class="letraNombreTableroNegro">al:<div class="letraNombreTableroNegro">'
                                                            },
                                                            {
                                                              xtype:'tbspacer',
                                                              width:10
                                                            },
                                                            {
                                                            	xtype:'label',

                                                                html:'<div id="divDteFin" style="widows:140"></div>'
                                                            }
                                                            
                                                		],
                                                items:	[
                                                			 {
                                                                xtype:'panel',
                                                                region:'center',
                                                                layout:'border',
                                                                cls:'panelSiugj',
                                                                border:false,
                                                                tbar: 	[
                                                                			{
                                                                                  xtype:'label',
                                                                                  html:'<div class="letraNombreTableroNegro">Tipo de Eventos:'
                                                                              },
                                                                              {
                                                                              	xtype:'tbspacer',
                                                                                width:10
                                                                              },
                                                                              {
                                                                              	xtype:'label',
                                                                                html:'<div id="divTipoEventos" style="width:300px"></div>'
                                                                              }
                                                                              ,
                                                                              {
                                                                              	xtype:'tbspacer',
                                                                                width:10
                                                                              },
                                                                              
                                                                              {
                                                                                  xtype:'label',
                                                                                  
                                                                                  html:'<div class="letraNombreTableroNegro">P&aacute;gina:</div>'
                                                                              },
                                                                              {
                                                                              	xtype:'tbspacer',
                                                                                width:10
                                                                              },
                                                                              {
                                                                              		xtype:'textfield',
                                                                               	 	id:'txtPagina',
                                                                                    cls:'controlSIUGJ',
                                                                                    width:300
                                                                                
                                                                              },{
                                                                              	xtype:'tbspacer',
                                                                                width:10
                                                                              },
                                                                              {
                                                                                  icon:'../images/magnifier.png',
                                                                                  cls:'x-btn-text-icon',
                                                                                  text:'Filtrar',
                                                                                  handler:function()
                                                                                          {
                                                                                             
                                                                                              
                                                                                              obtenerBitacoraAccesoUsuarios();
                                                                                          }
                                                                                  
                                                                              }	,
                                                                              {
                                                                              	xtype:'tbspacer',
                                                                                width:10
                                                                              },
                                                                              {
                                                                                  icon:'../images/document_go.png',
                                                                                  cls:'x-btn-text-icon',
                                                                                  text:'Exportar...',
                                                                                  menu: [
                                                                                  				{
                                                                                                  icon:'../imagenesDocumentos/16/file_extension_xlsx.png',
                                                                                                  cls:'x-btn-text-icon',
                                                                                                  text:'Excel',
                                                                                                  handler:function()
                                                                                                            {
                                                                                                                var arrParametros=[
                                                                                                                					['idUsuario',idUsuario],
                                                                                                                                    ['fechaInicio',gEx('dteFechaInicio').getValue().format('Y-m-d')],
                                                                                                                                    ['fechaFin',gEx('dteFechaFin').getValue().format('Y-m-d')],
                                                                                                                                    ['tipoEventos',gEx('cmbTipoEventos').getValue()],
                                                                                                                                    ['pagina',gEx('txtPagina').getValue()],
                                                                                                                                    ['formato',2]
                                                                                                                                
                                                                                                                                ]
                                                                                                                enviarFormularioDatos('../Usuarios/exportarBitacoraAcceso.php',arrParametros);
                                                                                                            }
                                                                                                  
                                                                                                  
                                                                                              }	,'-',
                                                                                              {
                                                                                                  icon:'../imagenesDocumentos/16/file_extension_pdf.png',
                                                                                                  cls:'x-btn-text-icon',
                                                                                                  text:'Pdf',
                                                                                                  handler:function()
                                                                                                            {
                                                                                                                var arrParametros=[
                                                                                                                					['idUsuario',idUsuario],
                                                                                                                                    ['fechaInicio',gEx('dteFechaInicio').getValue().format('Y-m-d')],
                                                                                                                                    ['fechaFin',gEx('dteFechaFin').getValue().format('Y-m-d')],
                                                                                                                                    ['tipoEventos',gEx('cmbTipoEventos').getValue()],
                                                                                                                                    ['pagina',gEx('txtPagina').getValue()],
                                                                                                                                    ['formato',1]
                                                                                                                                
                                                                                                                                ]
                                                                                                                enviarFormularioDatos('../Usuarios/exportarBitacoraAcceso.php',arrParametros);
                                                                                                            }
                                                                                                 
                                                                                                  
                                                                                              }
                                                                                  		]
                                                                                  
                                                                              }	 
                                                                		],
                                                                items: [
                                                                			crearGridBitacoraUsuario()
                                                                		]
                                                            }
                                                        ]
                                            }
                                         ]
                            }
                        )   
                        
	var cmbTipoEventos=crearComboExt('cmbTipoEventos',arrTipoEvento,0,0,290,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divTipoEventos',multiSelect:true});
	cmbTipoEventos.setValue('-1');                        
    var cmbUsuario=crearComboExtAutocompletar(oConf)   
    
    new Ext.form.DateField	(
    							{
                                    xtype:'datefield',
                                    id:'dteFechaInicio',
                                    renderTo:'divDteInicio',
                                    width:130,
                                    ctCls:'campoFechaSIUGJ',
                                    value:'<?php echo date("Y-m-d")?>'
                                }
    						)


	new Ext.form.DateField	(
    							{
                                    xtype:'datefield',
                                    id:'dteFechaFin',
                                    renderTo:'divDteFin',
                                    ctCls:'campoFechaSIUGJ',
                                    width:130,
                                    value:'<?php echo date("Y-m-d")?>'
                                }
    						)
                     
	obtenerBitacoraAccesoUsuarios();
}


function crearGridBitacoraUsuario()
{
	
	 var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idLog'},
		                                                {name: 'fecha', type:'date', dateFormat:'Y-m-d'},
		                                                {name:'hora'},
		                                                {name:'pagina'},
                                                        {name: 'consultaSql'},
                                                        {name: 'parametros'},
                                                        {name: 'dirIP'},
                                                        {name: 'nombreUsuario'},
                                                        {name: 'idUsuario'},
                                                        {name: 'tipo'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../paginasFunciones/funcionesUsuarios.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'fecha', direction: 'ASC'},
                                                            groupField: 'fecha',
                                                            remoteGroup:false,
				                                            remoteSort: true,
                                                            autoLoad:false
                                                            
                                                        }) 
                                                        
                                                        
	var paginador=	new Ext.PagingToolbar	(
                                                    {
                                                          pageSize: tamPaginacion,
                                                          store: alDatos,
                                                          displayInfo: true,
                                                          disabled:true
       												}
                                           ) 
                                                                                                   
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='103';
                                        proxy.baseParams.idUsuario=idUsuario;
                                        proxy.baseParams.fechaInicio=gEx('dteFechaInicio').getValue().format('Y-m-d');
                                        proxy.baseParams.fechaFin=gEx('dteFechaFin').getValue().format('Y-m-d');
                                        proxy.baseParams.tipoEventos=gEx('cmbTipoEventos')?gEx('cmbTipoEventos').getValue():'-1';
                                        proxy.baseParams.pagina=gEx('txtPagina').getValue()
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer({width:40}),
                                                            
                                                            {
                                                                header:'Fecha',
                                                                width:130,
                                                                sortable:true,
                                                                dataIndex:'fecha',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	return val.format('d/m/Y');
                                                                        }
                                                            },
                                                            {
                                                                header:'Hora',
                                                                width:110,
                                                                sortable:true,
                                                                dataIndex:'hora',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	return registro.data.hora;
                                                                        }
                                                            },
                                                            {
                                                                header:'Usuario',
                                                                width:280,
                                                                sortable:true,
                                                                dataIndex:'nombreUsuario'
                                                            },
                                                            {
                                                                header:'Tipo Evento',
                                                                width:300,
                                                                sortable:true,
                                                                dataIndex:'tipo',
                                                                renderer:function(val)
                                                                		{
                                                                        	return mostrarValorDescripcion(formatearValorRenderer(arrTipoEvento,val));
                                                                        }
                                                            },
                                                            {
                                                                header:'P&aacute;gina',
                                                                width:450,
                                                                sortable:true,
                                                                dataIndex:'pagina',
                                                                renderer:mostrarValorDescripcion
                                                            },
                                                            {
                                                                header:'Par&aacute;metros',
                                                                width:500,
                                                                sortable:true,
                                                                dataIndex:'parametros',
                                                                renderer:mostrarValorDescripcion
                                                            },
                                                            {
                                                                header:'Direcci&oacute;n IP',
                                                                width:200,
                                                                sortable:true,
                                                                dataIndex:'dirIP'
                                                            },
                                                            {
                                                                header:'Complementario',
                                                                width:500,
                                                                sortable:true,
                                                                dataIndex:'consultaSql',
                                                                renderer:mostrarValorDescripcion
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gBitacora',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                cm: cModelo,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                cls:'gridSiugjPrincipal',
                                                                columnLines : true,
                                                                bbar:	[paginador],
                                                                
                                                                view:new Ext.grid.GroupingView({
                                                                                                    forceFit:false,
                                                                                                    showGroupName: false,
                                                                                                    enableGrouping :true,
                                                                                                    enableNoGroups:false,
                                                                                                    enableGroupingMenu:false,
                                                                                                    hideGroupedColumn: false,
                                                                                                    startCollapsed:false
                                                                                                })
                                                            }
                                                        );
        return 	tblGrid;	
}

function obtenerBitacoraAccesoUsuarios()
{
	var iUsuario=idUsuario;
	gEx('gBitacora').getStore().load	(
    											{
                                                	url:'../paginasFunciones/funcionesUsuarios.php',
                                                	params:	{
                                                                idUsuario:iUsuario,
                                                                fechaInicio:gEx('dteFechaInicio').getValue().format('Y-m-d'),
                                                                fechaFin:gEx('dteFechaFin').getValue().format('Y-m-d'),
                                                                start:0,
                                                                limit:tamPaginacion
                                                            }
                                                }
    										)
}