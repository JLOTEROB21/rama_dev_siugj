<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$consulta="SELECT DISTINCT anio,anio FROM 7004_seriesUnidadesGestion s ORDER BY anio ASC";
			
	$arrCiclosCarpeta=$con->obtenerFilasArreglo($consulta);
	$anio=date("Y");
	$consulta=" SELECT DISTINCT t.idTipoCarpeta,nombreTipoCarpeta  FROM 7006_carpetasAdministrativas c,7020_tipoCarpetaAdministrativa t 
				 WHERE c.unidadGestion='".$_SESSION["codigoInstitucion"]."' and c.tipoCarpetaAdministrativa=t.idTipoCarpeta";
	$arrTiposCarpetas=$con->obtenerFilasArreglo($consulta);
	
	$tCarpertaDefault=$con->obtenerValor($consulta);
	
	$consulta="SELECT idSituacion,descripcionSituacion FROM 7011_situacionEventosAudiencia";
	$arrSituacionEvento=$con->obtenerFilasArreglo($consulta);
	
	
	$consulta="SELECT idSituacion,icono,tamano FROM 7011_situacionEventosAudiencia";
	$arrSituaciones=$con->obtenerFilasArreglo($consulta);
	
	
	$fechaActual=date("Y-m-d");
	$diaActual=date("N",strtotime($fechaActual));
	$fechaFinal=7-$diaActual;
	
	$fechaFinal=date("Y-m-d",strtotime("+".$fechaFinal." days",strtotime($fechaActual)));
	$fechaActual=date("Y-m-d",strtotime("-6 days",strtotime($fechaFinal)));
?>
var arrSituacionEvento=<?php echo $arrSituacionEvento?>;
var carpetaAdministrativa='';
var tCarpertaDefault='<?php echo $tCarpertaDefault ?>';
var arrTiposCarpetas=<?php echo $arrTiposCarpetas?>;
var anio='<?php echo $anio ?>';
var arrCiclosCarpeta=<?php echo $arrCiclosCarpeta?>;
var arrSemaforo=<?php echo $arrSituaciones?>;

Ext.onReady(inicializar);

function inicializar()
{
	var cmbTipoCarpeta=crearComboExt('cmbTipoCarpeta',arrTiposCarpetas,0,0,250);
    cmbTipoCarpeta.setValue(tCarpertaDefault);
    cmbTipoCarpeta.on('select',recargarGrid);
    
    var cmbAnio=crearComboExt('cmbAnio',arrCiclosCarpeta,0,0,120);    
    cmbAnio.setValue(anio);
    cmbAnio.on('select',recargarGrid);
    
    var oConf=	{
    					idCombo:'cmbCarpetaJudicial',
                        anchoCombo:200,
                        raiz:'registros',
                        campoDesplegar:'carpetaAdministrativa',
                        campoID:'carpetaAdministrativa',
                        funcionBusqueda:47,
                        paginaProcesamiento:'../paginasFunciones/funcionesModulosEspeciales_SGP.php',
                        confVista:'<tpl for="."><div class="search-item">{carpetaAdministrativa}<br></div></tpl>',
                        campos:	[
                                    {name:'carpetaAdministrativa'}

                                ],
                       	funcAntesCarga:function(dSet,combo)
                    				{
                                    	carpetaAdministrativa=-1;
                                    	var aValor=combo.getRawValue();
										dSet.baseParams.criterio=aValor;
                                        dSet.baseParams.tC=cmbTipoCarpeta.getValue();
                                        dSet.baseParams.ciclo=cmbAnio.getValue();
                                        
                                    },
                      	funcElementoSel:function(combo,registro)
                    				{
                                    	carpetaAdministrativa=registro.data.carpetaAdministrativa;
                                        recargarGrid();
                                    }  
    				};

	var carpetaJudicial=crearComboExtAutocompletar(oConf)
    
    new Ext.Viewport(	{
                                layout: 'border',
                                items: [
                                            {
                                                xtype:'panel',
                                                region:'center',
                                                layout:'border',
                                                title: '<span class="letraRojaSubrayada8" style="font-size:14px"><b></b></span>',
                                               	tbar: 	[
                                                            {
                                                                xtype:'label',
                                                                html:'&nbsp;&nbsp;&nbsp;<b>A&ntilde;o:</b>&nbsp;&nbsp;&nbsp;'
                                                            },
                                                            cmbAnio,'-',
                                                            {
                                            
                                                                xtype:'label',
                                                                html:'<b>Tipo de carpeta:</b>&nbsp;&nbsp;&nbsp;'
                                                            },
                                                            cmbTipoCarpeta,'-',
                                                            {
                                            
                                                                xtype:'label',
                                                                html:'<b>Carpeta Judicial:</b>&nbsp;&nbsp;&nbsp;'
                                                            },
                                                            carpetaJudicial
                                                            
                                                        ],
                                                items:	[
                                                            crearGridAudienciasAdministracion()
                                                        ]
                                            }
                                         ]
                            }
                        )   
                        
	gEx('cmbCarpetaJudicial').focus(false,500);                        
}


function crearGridAudienciasAdministracion()
{
	 var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idEventoAudiencia'},
                                                        {name:'fechaAudiencia', type:'date',dateFormat:'Y-m-d'},
                                                        {name:'fechaInicioAudiencia', type:'date',dateFormat:'Y-m-d H:i:s'},
		                                                {name:'leyendaAudiencia'},
		                                                {name:'situacionAudiencia'},
                                                        {name:'situacionResolutivos'},
                                                        {name:'situacionPaseLista'},
                                                        {name:'totalActasMinimas'},
                                                        {name:'totalTranscripciones'},
                                                        {name: 'iFormularioSituacion'},                                                     
                                                        {name: 'iRegistroSituacion'} 
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
                                                            sortInfo: {field: 'fechaAudiencia', direction: 'ASC'},
                                                            groupField: 'fechaAudiencia',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:false
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='164';
                                        proxy.baseParams.cA=carpetaAdministrativa;
                                        proxy.baseParams.fI=gEx('dtePeriodoInicial').getValue().format('Y-m-d');
                                        proxy.baseParams.fF=gEx('dtePeriodoFinal').getValue().format('Y-m-d');
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer(),
                                                            {
                                                                header:'ID Evento',
                                                                width:70,
                                                                sortable:true,
                                                                dataIndex:'idEventoAudiencia',
                                                                renderer:function(val)
                                                                		{
                                                                        	
                                                                        	return val;
                                                                        	
                                                                        }
                                                                
                                                            },
                                                            {
                                                                header:'Fecha de audiencia',
                                                                width:110,
                                                                sortable:true,
                                                                dataIndex:'fechaAudiencia',
                                                                renderer:function(val)
                                                                		{
                                                                        	return val.format('d/m/Y');
                                                                        }
                                                            },
                                                            {
                                                                header:'',
                                                                width:30,
                                                                sortable:true,
                                                                dataIndex:'situacionAudiencia',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	var icono='';
                                                                            meta.attr='style="padding: 0px !important;"';
                                                                        	icono=formatearValorRenderer(arrSemaforo,val);    
                                                                            var tamano=formatearValorRenderer(arrSemaforo,val,2);                                                                            
                                                                            return '<img src="'+icono+'" width="'+tamano+'" height="'+tamano+'" title="'+formatearValorRenderer(arrSituacionEvento,val)+'" alt="'+formatearValorRenderer(arrSituacionEvento,val)+'">';
                                                                        }
                                                            },
                                                            {
                                                                header:'Situaci&oacute;n audiencia',
                                                                width:170,
                                                                sortable:true,
                                                                dataIndex:'situacionAudiencia',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	var comp='';
                                                                            var comp2='';
                                                                            if(registro.data.iRegistroSituacion!='-1')
                                                                            {
                                                                            	comp2=' <a href="javascript:abrirFormatoRegistro(\''+bE(registro.data.iFormularioSituacion)+'\',\''+
                                                                                		bE(registro.data.iRegistroSituacion)+'\')"><img src="../images/magnifier.png" title="Ver detalles..."'+
                                                                                        ' alt="Ver detalles..."></a> ';
                                                                            }
                                                                           return comp+mostrarValorDescripcion(formatearValorRenderer(arrSituacionEvento,val))+comp2;
                                                                        }
                                                            },
                                                            {
                                                                header:'Detalles audiencia',
                                                                width:400,
                                                                sortable:true,
                                                                dataIndex:'leyendaAudiencia',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	meta.attr='style="height:auto !important;overflow:visible;white-space:normal;"';
                                                                        	return val;
                                                                        }
                                                            },
                                                            
                                                            {
                                                                header:'Registro de resolutivos',
                                                                width:170,
                                                                sortable:true,
                                                                dataIndex:'situacionResolutivos',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	
                                                                        	switch(val)
                                                                            {
                                                                            	case '0':
                                                                                	
                                                                                    return '<a href="javascript:abrirTableroAudiencia(\''+bE(registro.data.idEventoAudiencia)+'\')"><img src="../images/pencil.png"> En registro</a>';
                                                                                break;
                                                                                case '1':
                                                                                	return '<a href="javascript:abrirTableroAudiencia(\''+bE(registro.data.idEventoAudiencia)+'\')"><img src="../images/icon_big_tick.gif"> Registrado</a>';
                                                                                break;
                                                                                case '2':
                                                                                	return '<a href="javascript:abrirTableroAudiencia(\''+bE(registro.data.idEventoAudiencia)+'\')"><img src="../images/cross.png"> Sin registro</a>';
                                                                                break;
                                                                            }
                                                                        	
                                                                        }
                                                            },
                                                            {
                                                                header:'Registro de asistencia',
                                                                width:170,
                                                                sortable:true,
                                                                dataIndex:'situacionPaseLista',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	switch(val)
                                                                            {
                                                                            	case '0':                                                                                	
                                                                                    return '<a href="javascript:abrirTableroPaseLista(\''+bE(registro.data.idEventoAudiencia)+'\')"><img src="../images/pencil.png"> En registro</a>';
                                                                                break;
                                                                                case '1':
                                                                                	return '<a href="javascript:abrirTableroPaseLista(\''+bE(registro.data.idEventoAudiencia)+'\')"><img src="../images/icon_big_tick.gif"> Registrado</a>';
                                                                                break;
                                                                                case '2':
                                                                                	return '<a href="javascript:abrirTableroPaseLista(\''+bE(registro.data.idEventoAudiencia)+'\')"><img src="../images/cross.png"> Sin registro</a>';
                                                                                break;
                                                                            } 
                                                                        }
                                                            },
                                                            {
                                                                header:'Total actas<br>m&iacute;nimas',
                                                                width:100,
                                                                sortable:true,
                                                                align:'center',
                                                                dataIndex:'totalActasMinimas',
                                                                renderer:function(val)
                                                                		{
                                                                        	return val;                                                                        }
                                                            },
                                                            {
                                                                header:'Total<br>transcripciones',
                                                                width:100,
                                                                align:'center',
                                                                sortable:true,
                                                                dataIndex:'totalTranscripciones',
                                                                renderer:function(val)
                                                                		{
                                                                        	return val  ;
                                                                         }
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gAdministracionAudiencias',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                cm: cModelo,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                columnLines : true, 
                                                                tbar:	[
                                                                			{
                                                                                xtype:'label',
                                                                                html:'&nbsp;&nbsp;&nbsp;<b>Periodo del:</b>&nbsp;&nbsp;&nbsp;'
                                                                            },
                                                                            {
                                                                                xtype:'datefield',
                                                                                id:'dtePeriodoInicial',
                                                                                value:'<?php echo $fechaActual?>',
                                                                                listeners:	{
                                                                                                select:function()
                                                                                                        {
                                                                                                            recargarGrid();
                                                                                                        }
                                                                                                        
                                                                                            }
                                                                            },'-',
                                                                            {
                                                                                xtype:'label',
                                                                                html:'&nbsp;&nbsp;&nbsp;<b>Periodo al:</b>&nbsp;&nbsp;&nbsp;'
                                                                            },
                                                                            {
                                                                                xtype:'datefield',
                                                                                id:'dtePeriodoFinal',
                                                                                value:'<?php echo $fechaFinal?>',
                                                                                listeners:	{
                                                                                                select:function()
                                                                                                        {
                                                                                                            recargarGrid();
                                                                                                        }
                                                                                                        
                                                                                            }
                                                                            }
                                                                		],                                                               
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
        return 	tblGrid;
}


function recargarGrid()
{
	gEx('gAdministracionAudiencias').getStore().reload();
}


function abrirFormatoRegistro(iF,iR)
{

	var obj={};    
    obj.ancho='100%';
    obj.alto='100%';
    obj.url='../modeloPerfiles/vistaDTDv3.php';
    obj.params=[['idFormulario',bD(iF)],['idRegistro',bD(iR)],
                ['dComp',bE('auto')],['actor',bE(0)]];
   	if(window.parent)
    	window.parent.abrirVentanaFancy(obj);
    else
	    abrirVentanaFancy(obj);
}

function abrirTableroAudiencia(iE)
{
	var obj={};
    obj.ancho='100%';
    obj.alto='100%';
    obj.url='../modulosEspeciales_SGJP/tableroAudiencia.php';
    obj.params=[['idEventoAudiencia',bD(iE)]]; 
    obj.funcionCerrar=  recargarGrid; 
	if(window.parent)
    	window.parent.abrirVentanaFancy(obj);
    else
    	abrirVentanaFancy(obj);
}

function recargarContenedorCentral()
{
	recargarGrid();
}


function abrirTableroPaseLista(iE)
{
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			crearGridPaseLista()
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Registrar asistencia',
										width: 800,
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

function crearGridPaseLista()
{
	 var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idParticipante'},
		                                                {name: 'nombreParticipante'},
		                                                {name:'folioPedido'},
		                                                {name:'fechaRecepcion', type:'date'},
                                                        {name: 'diferencia', type:'int'},
                                                        {name: 'num_Factura'},
                                                        {name: 'fecha_entrada',type:'date'},
                                                        {name: 'Nombre'},
                                                        {name: 'observaciones'},
                                                        {name:'num_entrega'},
                                                        {name:'cond_pago'},
                                                        {name: 'txtRFC'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../paginasFunciones/funcionesAlmacen.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'fechaRecepcion', direction: 'ASC'},
                                                            groupField: 'fechaRecepcion',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:false
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='87';
                                        proxy.baseParams.idAlmacen=gE('idAlmacen').value;
                                    }
                        )   
       
    var cModelo= new Ext.grid.ColumnModel   	(
                                                    [
                                                        new  Ext.grid.RowNumberer(),
                                                        
                                                        {
                                                            header:'Dict&aacute;men / Resultado',
                                                            width:550,
                                                            sortable:true,
                                                            dataIndex:'dictamen',
                                                            renderer:formatearDictamen
                                                        },
                                                        {
                                                            header:'Fecha comentario',
                                                            width:150,
                                                            sortable:true,
                                                            dataIndex:'fechaComentario',
                                                            renderer:formatearfechaColor
                                                        }
                                                    ]
                                                );
                                                
    var tblGrid=	new Ext.grid.GridPanel	(
                                                        {
                                                            id:'gridComentarios',
                                                            store:alDatos,
                                                            region:'center',
                                                            frame:true,
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
                                                                                                hideGroupedColumn: true,
                                                                                                startCollapsed:false
                                                                                            })
                                                        }
                                                    );
    return 	tblGrid;
}