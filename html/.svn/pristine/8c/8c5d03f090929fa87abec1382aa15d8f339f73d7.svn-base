<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	$consulta="SELECT id__642_tablaDinamica,nombreGrupo FROM _642_tablaDinamica ORDER BY nombreGrupo";
	$arrGruposReparto=$con->obtenerFilasArreglo($consulta);
	
	
	$consulta="SELECT DISTINCT claveDepartamental,unidad FROM 817_organigrama WHERE institucion=12 ORDER BY unidad";
	$arrCircuitosJudiciales=$con->obtenerFilasArreglo($consulta);
	
	
	$consulta="SELECT id__636_tablaDinamica,nombreAtributo FROM _636_tablaDinamica ORDER BY nombreAtributo";
	$arrAtributosDespacho=$con->obtenerFilasArreglo($consulta);
?>
var cveMunicipio='';
var arrAtributosDespacho=<?php echo $arrAtributosDespacho?>;
var arrCircuitosJudiciales=<?php echo $arrCircuitosJudiciales?>;
var arrGruposReparto=<?php echo $arrGruposReparto?>;


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
                                                cls:'panelSiugjWrap',
                                                title: 'Bit&aacute;cora de reparto',
                                                tbar:	[
                                                			{
                                                                xtype:'label',
                                                                html:'<div class="letraNombreTablero">Periodo de:</div>'
                                                            },
                                                            {
                                                            	xtype:'tbspacer',
                                                                width:10
                                                            },
                                                            {
                                                                xtype:'datefield',
                                                                ctCls:'campoFechaSIUGJ',
                                                                value:'<?php echo date('Y-m-d')?>',
                                                                id:'fechaInicio'
                                                            },
                                                            {
                                                            	xtype:'tbspacer',
                                                                width:10
                                                            },
                                                               
                                                            {
                                                                xtype:'label',
                                                                html:'<div class="letraNombreTablero">al:</div>'
                                                            },
                                                            {
                                                                xtype:'datefield',
                                                                ctCls:'campoFechaSIUGJ',
                                                                value:'<?php echo date('Y-m-d')?>',
                                                                id:'fechaFin'
                                                            }, 
                                                            {
                                                            	xtype:'tbspacer',
                                                                width:10
                                                            },
                                                            {
                                                                xtype:'label',
                                                                html:'<div class="letraNombreTablero">Grupo de reparto:</div>'
                                                            },
                                                            {
                                                            	xtype:'tbspacer',
                                                                width:10
                                                            },
                                                            {
                                                                xtype:'label',
                                                                html:'<div id="divComboGrupo"></div>'
                                                            },
                                                            {
                                                            	xtype:'tbspacer',
                                                                width:10
                                                            },
                                                            {
                                                                icon:'../principalPortal/imagesSIUGJ/magnifier.png',
                                                                cls:'x-btn-text-icon',
                                                                text:'Buscar',
                                                                handler:function()
                                                                        {
                                                                        	mostrarMensajeProcesando();
                                                                            recargarGrid();
                                                                        }
                                                                
                                                            }
                                                        ], 
                                                items:	[
                                                			{
                                                            	xtype:'panel',
                                                                region:'center',
                                                                layout:'border',
                                                                cls:'panelSiugjWrap',
                                                                tbar:	[
                                                                			{
                                                                                xtype:'label',
                                                                                html:'<div class="letraNombreTablero">Circuito Judicial:</div>'
                                                                            },
                                                                            {
                                                                                xtype:'tbspacer',
                                                                                width:10
                                                                            },
                                                                            {
                                                                                xtype:'label',
                                                                                html:'<div id="divCircuito"></div>'
                                                                            },
                                                                            {
                                                                                xtype:'tbspacer',
                                                                                width:10
                                                                            },
                                                                            {
                                                                                xtype:'label',
                                                                                html:'<div class="letraNombreTablero">Tipo de despacho:</div>'
                                                                            },
                                                                            {
                                                                                xtype:'tbspacer',
                                                                                width:10
                                                                            },
                                                                            {
                                                                                xtype:'label',
                                                                                html:'<div id="divTipoDespacho"></div>'
                                                                            },
                                                                            {
                                                                                xtype:'tbspacer',
                                                                                width:10
                                                                            },
                                                                             {
                                                                                xtype:'label',
                                                                                html:'<div class="letraNombreTablero">Municipio:</div>'
                                                                            },
                                                                            {
                                                                                xtype:'tbspacer',
                                                                                width:10
                                                                            },
                                                                            {
                                                                                xtype:'label',
                                                                                html:'<div id="divMunicipios"></div>'
                                                                            },
                                                                		],
                                                                items:	[
                                                                			crearGridBitacora(),
                                                            				crearGridTotalDespachos()

                                                                		]
                                                            
                                                            }

                                                        ]
                                            }
                                         ]
                            }
                        )   
                        
	cmbGrupoReparto=crearComboExt('cmbGrupoReparto',arrGruposReparto,0,0,350,{multiSelect:true,ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboGrupo'});                                          
//    cmbGrupoReparto.on('change',recargarGrid);  
    
    var cmbCircuitos=crearComboExt('cmbCircuitos',arrCircuitosJudiciales,0,0,280,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divCircuito'});                        	        
	//cmbCircuitos.on('change',recargarGrid);  
    
    var cmbAtributosDespacho=crearComboExt('cmbAtributosDespacho',arrAtributosDespacho,0,0,350,{multiSelect:true,ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divTipoDespacho'});                        	    
    //cmbAtributosDespacho.on('change',recargarGrid);  
    
	var oConf=	{
    					idCombo:'cmbMunicipios',
                        anchoCombo:250,
                        renderTo:'divMunicipios',
                        raiz:'registros',
                        campoDesplegar:'nombreMunicipio',
                        campoID:'codigoMunicipio',
                        funcionBusqueda:72,
                        ctCls:'campoComboWrapSIUGJAutocompletar',
                        listClass:'listComboSIUGJ',
                        paginaProcesamiento:'../paginasFunciones/funcionesOrganigrama.php',
                        confVista:'<tpl for="."><div class="search-item">{nombreMunicipio}<br></div></tpl>',
                        campos:	[
                                   	{name:'codigoMunicipio'},
                                    {name:'nombreMunicipio'}

                                ],
                       	funcAntesCarga:function(dSet,combo)
                    				{
                                    	cveMunicipio='';
                                    	var aValor=combo.getRawValue();
										dSet.baseParams.criterio=aValor;
                                        
                                                                              
                                        
                                    },
                      	funcElementoSel:function(combo,registro)
                        				{
                                        	cveMunicipio=registro.data.codigoMunicipio;

                                            
                                        }
    				};

	var cmbMunicipios=crearComboExtAutocompletar(oConf);                      
}

function recargarGrid()
{
	gEx('gBitacoraReparto').getStore().load(	{
    												url:'../modulosEspeciales_SIUGJ/paginasFunciones/funcionesScriptsFormularios.php',
                                                    params:	{
                                                    			fechaInicio:gEx('fechaInicio').getValue().format('Y-m-d'),
                                                                fechaFin:gEx('fechaFin').getValue().format('Y-m-d'),
                                                                grupoReparto:gEx('cmbGrupoReparto').getValue(),
                                                                circuitoJuicial:gEx('cmbCircuitos').getValue(),
                                                                tipoDespacho:gEx('cmbAtributosDespacho').getValue(),
                                                                municipio:cveMunicipio
                                                    		}
    											});
}


function crearGridBitacora()
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idAsignacion'},
		                                                {name: 'idFormulario'},
		                                                {name:'idRegistro'},
                                                        {name:'idObjetoReferido'},
                                                        {name:'idUnidadReferida'},
                                                        {name:'tipoRonda'},
                                                        {name:'noRonda'},
		                                                {name:'fechaAsignacion', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name: 'situacion'},
                                                        {name: 'rondaPagada'},
                                                        {name: 'comentariosAdicionales'},
                                                        {name:'tipoAsignacion'},
                                                        {name:'idAsignacionPagada'},
                                                        {name: 'objParametros'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../modulosEspeciales_SIUGJ/paginasFunciones/funcionesScriptsFormularios.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'idAsignacion', direction: 'ASC'},
                                                            groupField: 'idAsignacion',
                                                            remoteGroup:false,
				                                            remoteSort: true,
                                                            autoLoad:false
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='21';

                                    }
                        )   

	alDatos.on('load',function(proxy)
    								{
										ocultarMensajeProcesando();
                                        gEx('gridDespachosTotal').getStore().loadData(proxy.reader.jsonData.arrStadisticas);

                                    }
                        )          
       
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer({width:70}),
                                                            {
                                                                header:'ID asignaci&oacute;n',
                                                                width:180,
                                                                sortable:true,
                                                                dataIndex:'idAsignacion',
                                                                renderer:mostrarValorDescripcion
                                                                
                                                            },
                                                            {
                                                                header:'Fecha de asignaci&oacute;n',
                                                                width:210,
                                                                sortable:true,
                                                                dataIndex:'fechaAsignacion',
                                                                renderer:function(val)
                                                                		{
                                                                        	if(val)
                                                                            	return val.format('d/m/Y H:i');
                                                                        }
                                                                
                                                            },
                                                            {
                                                                header:'Despacho asignado',
                                                                width:500,
                                                                sortable:true,
                                                                dataIndex:'idUnidadReferida',
                                                                renderer:mostrarValorDescripcion
                                                                
                                                            },
                                                            {
                                                                header:'Cve. ronda',
                                                                width:250,
                                                                sortable:true,
                                                                dataIndex:'tipoRonda',
                                                                renderer:mostrarValorDescripcion
                                                                
                                                            },
                                                            {
                                                                header:'Ciclo',
                                                                width:150,
                                                                sortable:true,
                                                                dataIndex:'noRonda',
                                                                renderer:mostrarValorDescripcion
                                                                
                                                            },
                                                            {
                                                                header:'Situaci&oacute;n',
                                                                width:180,
                                                                sortable:true,
                                                                dataIndex:'situacion'
                                                                
                                                            },
                                                            {
                                                                header:'Pago de ronda',
                                                                width:180,
                                                                sortable:true,
                                                                dataIndex:'rondaPagada',
                                                                renderer:function(val)
                                                                		{
                                                                        	if(val=='1')
                                                                            	return 'S&iacute;';
                                                                            return 'No';
                                                                        }
                                                                
                                                            },
                                                             {
                                                                header:'Comentarios',
                                                                width:400,
                                                                sortable:true,
                                                                dataIndex:'comentariosAdicionales',
                                                                renderer:mostrarValorDescripcion
                                                                
                                                            },
                                                            {
                                                                header:'ID Asignaci&oacute;n pagada',
                                                                width:190,
                                                                sortable:true,
                                                                dataIndex:'idAsignacionPagada',
                                                                renderer:function(val)
                                                                		{
                                                                        	if(val=='-1')
                                                                            	return '------';
                                                                            return val;
                                                                        }
                                                            },
                                                            {
                                                                header:'Condiciones de asignaci&oacute;n',
                                                                width:400,
                                                                sortable:true,
                                                                renderer:mostrarValorDescripcion,
                                                                dataIndex:'objParametros'
                                                                
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gBitacoraReparto',
                                                                store:alDatos,
                                                                cls:'gridSiugjPrincipal',
                                                                region:'center',
                                                                frame:false,
                                                                cm: cModelo,
                                                                stripeRows :true,
                                                                loadMask:false,
                                                                columnLines : false,  
                                                                                                                             
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

function crearGridTotalDespachos()
{
	var dsDatos=[];
    var alDatos=	new Ext.data.JsonStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'despacho'},
                                                                    {name: 'situacion_1'},
                                                                    {name: 'situacion_2'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer({width:70}),

														{
															header:'Despacho',
															width:600,
															sortable:true,
															dataIndex:'despacho',
                                                            renderer:mostrarValorDescripcion
														},
														{
															header:'Total asignaciones',
															width:180,
															sortable:true,
															dataIndex:'situacion_1'
														},
														{
															header:'Rondas ignoradas',
															width:180,
															sortable:true,
															dataIndex:'situacion_2'
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            
                                                            store:alDatos,
                                                            frame:true,
                                                            region:'south',
                                                            height:300,
                                                            id:'gridDespachosTotal',
                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            cls:'gridSiugjPrincipal',
                                                            stripeRows :false,
                                                            columnLines : false
                                                        }
                                                    );
	return 	tblGrid;
}