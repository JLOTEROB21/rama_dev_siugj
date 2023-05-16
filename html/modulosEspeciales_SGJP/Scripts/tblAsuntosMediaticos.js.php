<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$consulta="SELECT idSituacion,descripcionSituacion FROM 7011_situacionEventosAudiencia";
	$arrSituacionEvento=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT  id__4_tablaDinamica,tipoAudiencia FROM _4_tablaDinamica";
	$arrAudiencias=$con->obtenerFilasArreglo($consulta);
	
	
	$consulta="SELECT id__15_tablaDinamica, concat(nombreSala, ' [',e.nombreInmueble,']') FROM _15_tablaDinamica s,_1_tablaDinamica e 
			where e.id__1_tablaDinamica=s.idReferencia and id__15_tablaDinamica in(SELECT DISTINCT idSala FROM 7000_eventosAudiencia) 
			order by nombreSala,nombreInmueble";
	$arrSalasBusqueda=$con->obtenerFilasArreglo($consulta);

	$consulta="SELECT id__1_tablaDinamica,nombreInmueble FROM _1_tablaDinamica";
	$arrEdificios=$con->obtenerFilasArreglo($consulta);

	$consulta="SELECT id__17_tablaDinamica,nombreUnidad FROM _17_tablaDinamica";
	$arrUnidades=$con->obtenerFilasArreglo($consulta);
	
	
	$consulta="SELECT idSituacion,icono,tamano FROM 7011_situacionEventosAudiencia";
	$arrSituaciones=$con->obtenerFilasArreglo($consulta);
	
	
	$consulta="SELECT id__15_tablaDinamica,nombreSala FROM _15_tablaDinamica";
	$arrSalas=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT valor,texto FROM 1004_siNo";
	$arrSiNo=$con->obtenerFilasArreglo($consulta);
	
?>
var uploadControl;
var arrTipoRecurso=[['1','Publicaci\xF3n en twitter','../images/twitter.png'],
    					['2','Publicaci\xF3n de facebook','../images/facebook.png'],
                        ['3','Video de youtube','../images/youtube.png'],
                        ['5','Documento PDF','../imagenesDocumentos/16/file_extension_pdf.png'],
                        ['6','URL a pagina WEB','../images/Icono_html.gif']];
var arrTipoCumplimiento=[['1','Inmediato'],['2','Diferido']];
var arrSiNo=<?php echo $arrSiNo?>;
var arrSalas=<?php echo $arrSalas?>;
var arrSemaforo=<?php echo $arrSituaciones?>;
var arrSalasBusqueda=<?php echo $arrSalasBusqueda?>;
var arrEdificios=<?php echo $arrEdificios?>;
var arrUnidades=<?php echo $arrUnidades?>;
var arrSituaciones=<?php echo $arrSituaciones?>;
var arrAudiencias=<?php echo $arrAudiencias?>;
var arrSituacionEvento=<?php echo $arrSituacionEvento?>;
Ext.onReady(inicializar);

function inicializar()
{
	window.parent.autoScroll=150;
    new Ext.Viewport(	{
                                layout: 'border',
                                items: [
                                            {
                                                xtype:'panel',
                                                region:'center',
                                                layout:'border',
                                                title: '<span class="letraRojaSubrayada8" style="font-size:14px"><b>Seguimiento a asuntos medi&aacute;ticos</b></span>',
                                                items:	[
                                                        	crearGridSeguimientoMediatico()
                                                        ]
                                            }
                                         ]
                            }
                        )  
	obtenerInformacionCarpetasMediaticas();                         
}

function crearGridSeguimientoMediatico()
{
	var cmbSiNo=crearComboExt('cmbSiNo',arrSiNo,0,0);
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idCarpeta'},
		                                                {name: 'carpetaAdministrativa'},
                                                        {name: 'carpetaInvestigacion'},
                                                        {name: 'imputados'},
                                                        {name: 'victimas'},
                                                        {name: 'delitos'},
		                                                {name: 'totalAudiencias'},		                                                
                                                        {name: 'totalPromociones'},
                                                        {name: 'totalApelaciones'},
                                                        {name: 'totalAmparos'},
                                                        {name: 'totalPromocionesAmparos'},
                                                        {name: 'totalOrdenesAprehension'},
                                                        {name: 'totalAcuerdosReparatorios'},
                                                        {name:'seguirPorMail'},
                                                        {name:'idRegistro'},
                                                        {name: 'notificacionesMail'},
                                                        {name: 'numComentarios'}
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
                                              sortInfo: {field: 'carpetaAdministrativa', direction: 'ASC'},
                                              groupField: 'carpetaAdministrativa',
                                              remoteGroup:false,
                                              remoteSort: false,
                                              autoLoad:false
                                              
                                          }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='253';
                                        
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer(),
                                                              
                                                           {
                                                                header:'Carpeta Administrativa',
                                                                width:200,
                                                                sortable:true,
                                                                dataIndex:'carpetaAdministrativa',
                                                                renderer:function(val)
                                                                		{
                                                                        	return '<a href="javascript:abrirVentanaCarpetaJudicial(\''+bE(val)+'\')">'+val+'</a>';
                                                                        }
                                                            },
                                                            {
                                                                header:'Carpeta de Investigaci&oacute;n',
                                                                width:280,
                                                                sortable:true,
                                                                dataIndex:'carpetaInvestigacion'
                                                            },
                                                            {
                                                                header:'Total anotaciones',
                                                                width:120,
                                                                sortable:true,
                                                                align:'center',
                                                                dataIndex:'numComentarios',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	return '<a href="javascript:abrirVentanaComentarios(\''+bE(registro.data.carpetaAdministrativa)+'\')">'+val+'</a>';
                                                                        }
                                                            },
                                                            {
                                                                header:'Total audiencias',
                                                                width:120,
                                                                align:'center',
                                                                sortable:true,
                                                                dataIndex:'totalAudiencias',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	return '<a href="javascript:mostrarVentanaAudiencias(\''+bE(registro.data.carpetaAdministrativa)+'\')">'+val+'</a>';
                                                                        }
                                                            },
                                                            {
                                                                header:'Total promociones',
                                                                width:120,
                                                                align:'center',
                                                                sortable:true,
                                                                dataIndex:'totalPromociones',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	return '<a href="javascript:mostrarVentanaProcesoSistema(\''+bE(registro.data.carpetaAdministrativa)+'\',\''+bE(96)+'\')">'+val+'</a>';
                                                                        }
                                                            },
                                                            {
                                                                header:'Total apelaciones',
                                                                width:120,
                                                                align:'center',
                                                                sortable:true,
                                                                dataIndex:'totalApelaciones',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	return '<a href="javascript:mostrarVentanaProcesoSistema(\''+bE(registro.data.carpetaAdministrativa)+'\',\''+bE(451)+'\')">'+val+'</a>';
                                                                        }
                                                            },
                                                            {
                                                                header:'Total amparos',
                                                                width:120,
                                                                align:'center',
                                                                sortable:true,
                                                                dataIndex:'totalAmparos',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	return '<a href="javascript:mostrarVentanaProcesoSistema(\''+bE(registro.data.carpetaAdministrativa)+'\',\''+bE(346)+'\')">'+val+'</a>';
                                                                        }
                                                            },
                                                            {
                                                                header:'Total promociones<br /> de amparos',
                                                                width:120,
                                                                align:'center',
                                                                sortable:true,
                                                                dataIndex:'totalPromocionesAmparos',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	return '<a href="javascript:mostrarVentanaProcesoSistema(\''+bE(registro.data.carpetaAdministrativa)+'\',\''+bE(460)+'\')">'+val+'</a>';
                                                                        }
                                                            },
                                                            {
                                                                header:'Total &oacute;rdenes<br>de aprehensi&oacute;n',
                                                                width:120,
                                                                align:'center',
                                                                sortable:true,
                                                                dataIndex:'totalOrdenesAprehension',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	return '<a href="javascript:mostrarVentanaProcesoSistema(\''+bE(registro.data.carpetaAdministrativa)+'\',\''+bE(434)+'\')">'+val+'</a>';
                                                                        }
                                                            },
                                                            {
                                                                header:'Total acuerdos<br>reparatorios',
                                                                width:120,
                                                                sortable:true,
                                                                align:'center',
                                                                dataIndex:'totalAcuerdosReparatorios',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	return '<a href="javascript:mostrarVentanaAcuerdosReparatorios(\''+bE(registro.data.carpetaAdministrativa)+'\')">'+val+'</a>';
                                                                        }
                                                            },
                                                            {
                                                                header:'Imputados',
                                                                width:220,
                                                                sortable:true,
                                                                dataIndex:'imputados',
                                                                renderer:function(val)
                                                                		{
                                                                        	return mostrarValorDescripcion(val)
                                                                        }
                                                            },
                                                            {
                                                                header:'V&iacute;ctimas',
                                                                width:220,
                                                                sortable:true,
                                                                dataIndex:'victimas',
                                                                renderer:function(val)
                                                                		{
                                                                        	return mostrarValorDescripcion(val)
                                                                        }
                                                            },
                                                            {
                                                                header:'Delitos',
                                                                width:220,
                                                                sortable:true,
                                                                dataIndex:'delitos',
                                                                renderer:function(val)
                                                                		{
                                                                        	return mostrarValorDescripcion(val)
                                                                        }
                                                            },
                                                            {
                                                                header:'Notificar por mail a',
                                                                width:500,
                                                                sortable:true,
                                                                dataIndex:'notificacionesMail',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	meta.attr='style="min-height:21px;height:auto;"';
                                                                        	return mostrarValorDescripcion(val);
                                                                        }
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                            {
                                                                id:'gAsuntosMediaticos',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                cm: cModelo,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                columnLines : true,
                                                                clicksToEdit:1,
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
                                                        
		tblGrid.on('afterEdit',function(e)
        						{
                                	function funcAjax()
                                    {
                                        var resp=peticion_http.responseText;
                                        arrResp=resp.split('|');
                                        if(arrResp[0]=='1')
                                        {
                                            
                                        }
                                        else
                                        {
                                        	function resp()
                                            {
                                            	e.record.set(e.field,e.originalValue);
                                            }
                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0],resp);
                                        }
                                    }
                                    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=256&iS='+e.record.data.idRegistro+'&valor='+e.value,true);
                                }
                                	
        			)                                                        
                                                        
        return 	tblGrid;
}

function obtenerInformacionCarpetasMediaticas()
{
	gEx('gAsuntosMediaticos').getStore().load	(
    												{
                                                    	url:'../paginasFunciones/funcionesModulosEspeciales_SGP.php',
                                                        params:	{
                                                        			
                                                        		}
                                                    }
    											)
}

	
    
function abrirVentanaCarpetaJudicial(cA)
{
	var obj={};
    obj.ancho='100%';
    obj.alto='100%';
    obj.url='../modulosEspeciales_SGJP/tableroAudienciaAdministracionMediaticos.php';
    obj.params=[['cA',cA],['idCarpetaAdministrativa',-1],['sL','1']];
    obj.titulo='Carpeta Judicial: '+bD(cA);
    abrirVentanaFancySuperior(obj);
}  


function mostrarVentanaProcesoSistema(iF,cA)
{
	var leyenda='';
	switch(bD(iF))
    {
    	case '96':
        	leyenda='Promociones';
        break;
        case '451':
        	leyenda='Apelaciones';
        break; 
        case '346':
        	leyenda='Amparos';
        break; 
        case '434':
        	leyenda='&Oacute;rdenes de aprehensi&oacute;n';
        break; 
         case '460':
        	leyenda='Promociones de Juicios de Amparo';
        break;
    }
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'border',
											defaultType: 'label',
											items: 	[
                                            			crearGridRegistrosProcesos(cA,iF)
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: leyenda,
										width: 980,
										height:430,
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

function crearGridRegistrosProcesos(iF,cA)
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name: 'iFormulario'},
                                                        {name: 'carpetaAdministrativa'},
		                                                {name: 'iRegistro'},
		                                                {name: 'folioRegistro'},
		                                                {name: 'fechaCreacion', type:'date', dateFormat:'Y-m-d H:i:s'},                                                       
                                                        {name: 'detalles'},
                                                        {name: 'situacionActual'}
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
                                              sortInfo: {field: 'fechaCreacion', direction: 'ASC'},
                                              groupField: 'carpetaAdministrativa',
                                              remoteGroup:false,
                                              remoteSort: true,
                                              autoLoad:true
                                              
                                          }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='254';
                                        proxy.baseParams.cA=bD(cA);
                                        proxy.baseParams.iF=bD(iF);
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer(),
                                                            
                                                            {
                                                                header:'Folio de registro',
                                                                width:110,
                                                                sortable:true,
                                                                dataIndex:'folioRegistro',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	return '<a href="javascript:abrirRegistroSolicitud(\''+bE(registro.data.iFormulario)+'\',\''+bE(registro.data.iRegistro)+'\')">'+val+'</a>';
                                                                        }
                                                            },
                                                            {
                                                                header:'Carpeta Judicial',
                                                                width:110,
                                                                sortable:true,
                                                                dataIndex:'carpetaAdministrativa',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	return val;
                                                                        }
                                                            },
                                                            {
                                                                header:'Fecha de registro',
                                                                width:120,
                                                                sortable:true,
                                                                dataIndex:'fechaCreacion',
                                                                renderer:function(val)
                                                                		{
                                                                        	return val.format('d/m/Y H:i');
                                                                        }
                                                            },
                                                            {
                                                                header:'',
                                                                width:480,
                                                                sortable:true,
                                                                dataIndex:'detalles',
                                                                renderer:function(val)
                                                                		{
                                                                        	return mostrarValorDescripcion(val);
                                                                        }
                                                            },
                                                            {
                                                                header:'Situaci&oacute;n actual',
                                                                width:350,
                                                                sortable:true,
                                                                dataIndex:'situacionActual',
                                                                renderer:function(val)
                                                                		{
                                                                        	return val;
                                                                        }
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gRegistrosProceso',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                cm: cModelo,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                columnLines : true,                                                                
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

function abrirRegistroSolicitud(iF,iR)
{
	if(window.parent.parent)
		window.parent.parent.abrirFormularioProcesoFancy(iF,iR,bE(0));
    else
    	abrirFormularioProcesoFancy(iF,iR,bE(0));
}

function mostrarVentanaAudiencias(cA)
{
	var leyenda='';
	
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'border',
											defaultType: 'label',
											items: 	[
                                            			crearGridEventos(bD(cA))
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Audiencias progradas',
										width: 980,
										height:430,
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

function crearGridEventos(cA)
{

	 var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name: 'idEvento'},
                                                        {name: 'carpetaAdministrativa'},
		                                                {name: 'fechaEvento', type:'date', dateFormat:'Y-m-d'},
		                                                {name: 'horaInicial', type:'date', dateFormat:'Y-m-d H:i:s'},
		                                               	{name: 'horaFinal', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name: 'horaInicialReal', type:'date', dateFormat:'Y-m-d H:i:s'},
		                                               	{name: 'horaFinalReal', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name: 'urlMultimedia'},
                                                        {name: 'tipoAudiencia'},
                                                        {name: 'sala'},
                                                        {name: 'unidadGestion'},
                                                        {name: 'situacion'},
                                                        {name: 'juez'}  ,
                                                        {name: 'tImputados' },
                                                        {name: 'iFormulario' }, 
                                                        {name: 'iRegistro' },
                                                        {name: 'iFormularioSituacion'},                                                     
                                                        {name: 'iRegistroSituacion'},
                                                        {name: 'notificacionMAJO'},
                                                        {name: 'mensajeMAJO'},
                                                        {name: 'delitos'} ,
                                                        {name: 'edificio'}, 
                                                        {name: 'carpetaInvestigacion'},        
                                                        {name: 'imputado'}     
                                                        
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
                                                            sortInfo: {field: 'fechaEvento', direction: 'ASC'},
                                                            groupField: 'carpetaAdministrativa',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	
                                    	proxy.baseParams.funcion='53';
                                        proxy.baseParams.cJ=cA;
										proxy.baseParams.mostrarDerivadas=1;
                                        proxy.baseParams.idCarpetaAdministrativa=-1;
                                        
                                        
                                        
                                    }
                        )   
       
       
       var filters = new Ext.ux.grid.GridFilters	(
                                                        {
                                                            filters:	[
                                                            				{
                                                                            	type:'string',
                                                                                dataIndex:'carpetaAdministrativa'
                                                                            },
                                                                            {
                                                                            	type:'date',
                                                                                dataIndex:'fechaEvento'
                                                                            },
                                                                            {
                                                                            	type:'list',
                                                                                dataIndex:'tipoAudiencia',
                                                                                options:arrAudiencias,
                                                                                phpMode:true
                                                                            },
                                                                            {
                                                                            	type:'list',
                                                                                dataIndex:'sala',
                                                                                options:arrSalasBusqueda,
                                                                                phpMode:true
                                                                            },
                                                                            {
                                                                            	type:'list',
                                                                                dataIndex:'edificio',
                                                                                options:arrEdificios,
                                                                                phpMode:true
                                                                            },
                                                                            {
                                                                            	type:'string',
                                                                                dataIndex:'juez'
                                                                            }
                                                            			]
                                                        }
                                                    );  
       
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer({width:40}),
                                                            {
                                                                header:'ID Evento',
                                                                width:70,
                                                                sortable:true,
                                                                dataIndex:'idEvento',
                                                                renderer:function(val)
                                                                		{
                                                                        	
                                                                            return val;
                                                                                
                                                                            
                                                                        }
                                                                
                                                            },
                                                            {
                                                                header:'Carpeta Judicial',
                                                                width:180,
                                                                sortable:true,
                                                                dataIndex:'carpetaAdministrativa',
                                                                renderer:function(val)
                                                                		{
                                                                        	
                                                                            return val;
                                                                                
                                                                            
                                                                        }
                                                                
                                                            },
                                                            
                                                            {
                                                                header:'',
                                                                width:30,
                                                                sortable:true,
                                                                align:'center',
                                                                dataIndex:'situacion',
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
                                                                dataIndex:'situacion',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        
                                                                        	var comp='';
                                                                            
                                                                        	return comp+mostrarValorDescripcion(formatearValorRenderer(arrSituacionEvento,val));
                                                                        }
                                                            },
                                                            
                                                            {
                                                                header:'',
                                                                width:60,
                                                                sortable:true,
                                                                dataIndex:'situacion',
                                                                css:'text-align:left;vertical-align:middle !important;',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	
                                                                            var comp2='';
                                                                            
                                                                            
                                                                           	switch(val)
                                                                            {
                                                                            	case '4':
                                                                                	if(registro.data.urlCanal!='')
                                                                                		comp2='<a href="javascript:abrirVentanaSala(\''+bE(registro.data.sala)+'\')"><img src="../images/film_go.png" title="Visualizar audiencia" alt="Visualizar audiencia" /></a>'
                                                                                break;
                                                                                case '2':
                                                                                	if(registro.data.urlMultimedia!='')
                                                                                		comp2='<a href="javascript:abrirVideoGrabacion(\''+bE(registro.data.idEvento)+'\')"><img src="../images/control_play_blue.png" title="Visualizar grabaci&oacute;n" alt="Visualizar grabaci&oacute;n" /></a>'
                                                                              	break;
                                                                            }
                                                                            
                                                                            var comp='';
                                                                            if(registro.data.iRegistroSituacion!='-1')
                                                                            {
                                                                            	comp='<a href="javascript:abrirFormatoRegistro(\''+bE(registro.data.iFormularioSituacion)+'\',\''+
                                                                                		bE(registro.data.iRegistroSituacion)+'\')"><img src="../images/magnifier.png" title="Ver detalles..."'+
                                                                                        ' alt="Ver detalles..."></a> ';
                                                                            
                                                                            	if(comp2!='')
                                                                                	comp='&nbsp;&nbsp;'+comp;
                                                                            }
                                                                            
                                                                        	return comp2+comp;
                                                                        	
                                                                        }
                                                            },
                                                            {
                                                                header:'Carpeta Judicial',
                                                                width:150,
                                                                sortable:true,
                                                                hidden:true,
                                                                dataIndex:'carpetaAdministrativa'
                                                            },
                                                            {
                                                                header:'Fecha audiencia',
                                                                width:150,
                                                                sortable:true,
                                                                dataIndex:'fechaEvento',
                                                                renderer:function(val)
                                                                	{
                                                                    	return val.format('d/m/Y');
                                                                    }
                                                            },
                                                            {
                                                                header:'Hora programada de audiencia',
                                                                width:280,
                                                                sortable:true,
                                                                dataIndex:'horaInicial',
                                                                renderer:function(val,meta,registro)
                                                                	{
                                                                    	var comp='';
                                                                        if(val.format('d')!=registro.data.horaFinal.format('d'))
                                                                        {
                                                                        	comp=' del '+registro.data.horaFinal.format('d/m/Y');
                                                                        }

                                                                    	return 'De las '+val.format('H:i')+' hrs. a las '+registro.data.horaFinal.format('H:i')+' hrs.'+comp
                                                                    }
                                                            },
                                                           
                                                            {
                                                                header:'Hora de realizaci&oacute;n de audiencia',
                                                                width:280,
                                                                sortable:true,
                                                                dataIndex:'horaInicialReal',
                                                                renderer:function(val,meta,registro)
                                                                	{
                                                                    	if(!val)
                                                                        {
                                                                        	return '(Datos no disponibles)';
                                                                        }
                                                                    	var comp='';
                                                                        if(val.format('d')!=registro.data.horaFinalReal.format('d'))
                                                                        {
                                                                        	comp=' del '+registro.data.horaFinalReal.format('d/m/Y');
                                                                        }

                                                                    	return 'De las '+val.format('H:i')+' hrs. a las '+registro.data.horaFinalReal.format('H:i')+' hrs.'+comp
                                                                    }
                                                            },
                                                            {
                                                                header:'Tipo de audiencia',
                                                                width:350,
                                                                sortable:true,
                                                                dataIndex:'tipoAudiencia',
                                                                renderer:function(val)
                                                                		{
                                                                        
                                                                        	return mostrarValorDescripcion(formatearValorRenderer(arrAudiencias,val));
                                                                        }
                                                            },
                                                            {
                                                                header:'Edificio',
                                                                width:250,
                                                                sortable:true,
                                                                dataIndex:'edificio',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	var lblSala=mostrarValorDescripcion(formatearValorRenderer(arrEdificios,val));
                                                                            
                                                                            
                                                                            
                                                                        	return lblSala;
                                                                        }
                                                            },
                                                            
                                                            {
                                                                header:'Sala',
                                                                width:110,
                                                                sortable:true,
                                                                dataIndex:'sala',
                                                                renderer:function(val)
                                                                		{
                                                                        	return mostrarValorDescripcion(formatearValorRenderer(arrSalas,val));
                                                                        }
                                                            },
                                                            {
                                                                header:'Juez',
                                                                width:320,
                                                                sortable:true,
                                                                dataIndex:'juez',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	var etiqueta='';
                                                                            
                                                                            
                                                                            return etiqueta+val;
                                                                        	
                                                                        }
                                                            }
                                                            
                                                            
                                                            
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gridAudiencias',
                                                                store:alDatos,
                                                                region:'center',
                                                                title:'Historial de audiencias',
                                                                frame:false,
                                                                cm: cModelo,
                                                                stripeRows :false,
                                                                loadMask:true,
                                                                columnLines : true,      
                                                                plugins:	[filters],
                                                                
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
                                                	
                                                }
    							)

	tblGrid.getSelectionModel().on('rowdeselect',function()
    											{
                                                	
                                                }
    							)

        return 	tblGrid;

}

function abrirVentanaSala(iS)
{
	var obj={};    
    obj.ancho='100%';
    obj.alto='100%';
    obj.url='../modulosEspeciales_SGJP/visorStreamSalaAudiencia.php';
    obj.params=[['idSala',iS],['cPagina','sFrm=true']]
    abrirVentanaFancy(obj);
}

function abrirVideoGrabacion(idEventoAudiencia)
{
	var obj={};    
    obj.ancho='100%';
    obj.alto='100%';
    obj.url='../modulosEspeciales_SGJP/visorGrabacionAudiencia.php';
    obj.params=[['idEvento',idEventoAudiencia],['cPagina','sFrm=true']]
    abrirVentanaFancy(obj);
}

function mostrarVentanaAcuerdosReparatorios(cA)
{

	var leyenda='';
	
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'border',
											defaultType: 'label',
											items: 	[
                                            			crearGridAcuerdosReparatorios(bD(cA))
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Acuerdos reparatorios',
										width: 980,
										height:430,
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



function crearGridAcuerdosReparatorios(cA)
{
	var chkRow=new Ext.grid.CheckboxSelectionModel();
	 var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'imputados'},
		                                                {name: 'resumenAcuerdo'},
		                                                {name:'tipoCumplimiento'},
		                                                {name:'acuerdoAprobado'},
                                                        {name: 'fechaExtincionAccionPenal', type:'date', dateFormat:'Y-m-d'},
                                                        {name: 'arrDocumentos'},
                                                        {name: 'comentariosAdicionales'},
                                                        {name: 'idRegistro'},
                                                        {name: 'carpetaAdministrativa'},
                                                        {name: 'idEventoAudiencia'}
                                                        
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
                                                            sortInfo: {field: 'imputados', direction: 'ASC'},
                                                            groupField: 'carpetaAdministrativa',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='255';
                                        proxy.baseParams.cA=cA;
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            
                                                            chkRow,
                                                            {
                                                                header:'Carpeta Judicial',
                                                                width:100,
                                                                sortable:true,
                                                                dataIndex:'carpetaAdministrativa',
                                                                renderer:function(val)
                                                                		{
                                                                        	return mostrarValorDescripcion(val);
                                                                        }
                                                            },
                                                             {
                                                                header:'Folio de registro',
                                                                width:100,
                                                                sortable:true,
                                                                dataIndex:'idEventoAudiencia',
                                                                renderer:function(val)
                                                                		{
                                                                        	return mostrarValorDescripcion(val);
                                                                        }
                                                            },
                                                            {
                                                                header:'Imputados',
                                                                width:300,
                                                                sortable:true,
                                                                dataIndex:'imputados',
                                                                renderer:function(val)
                                                                		{
                                                                        	return mostrarValorDescripcion(val);
                                                                        }
                                                            },
                                                            {
                                                                header:'Tipo de cumplimiento',
                                                                width:150,
                                                                sortable:true,
                                                                dataIndex:'tipoCumplimiento',
                                                                renderer:function(val)
                                                                		{
                                                                        	return formatearValorRenderer(arrTipoCumplimiento,val);
                                                                        }
                                                            },
                                                            {
                                                                header:'Acuerdo aprobado',
                                                                width:150,
                                                                sortable:true,
                                                                dataIndex:'acuerdoAprobado',
                                                                renderer:function(val)
                                                                		{
                                                                        	return formatearValorRenderer(arrSiNo,val);
                                                                        }
                                                            },
                                                            {
                                                                header:'Fecha de extinci&oacute;n de<br>la acci&oacute;n penal',
                                                                width:180,
                                                                sortable:true,
                                                                dataIndex:'fechaExtincionAccionPenal',
                                                                renderer:function(val)
                                                                		{
                                                                        	if(val)
                                                                            	return val.format('d/m/Y');
                                                                        }
                                                            },
                                                            
                                                              {
                                                                  header:'Comentarios adicionales',
                                                                  width:600,
                                                                  sortable:true,
                                                                  dataIndex:'comentariosAdicionales',
                                                                  renderer:function(val)
                                                                          {
                                                                              return val;
                                                                          }
                                                              }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gridAcuerdosReparatorios',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                cm: cModelo,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                sm:chkRow,
                                                                columnLines : true,
                                                                title:'Acuerdos reparatorios',                                                                
                                                                view:new Ext.grid.GroupingView({
                                                                                                    forceFit:false,
                                                                                                    showGroupName: false,
                                                                                                    enableGrouping :true,
                                                                                                    enableNoGroups:false,
                                                                                                    enableGroupingMenu:false,
                                                                                                    hideGroupedColumn: true,
                                                                                                    startCollapsed:false,
                                                                                                    enableRowBody:true,
                                                                                                    getRowClass : formatearFila
                                                                                                })
                                                            }
                                                        );
        return 	tblGrid;	
}

function formatearFila(record, rowIndex, p, ds) 
{
	var xf = Ext.util.Format;
    p.body = '<br><br><table width="100%"><tr><td width="30"></td><td><b>Resumen del acuerdo</b><br><br>'+record.data.resumenAcuerdo+'</td></tr></table><br><br>';
    return 'x-grid3-row-expanded';
}  


function abrirVentanaComentarios(cA)
{
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'border',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	xtype:'panel',
                                                            layout:'border',
                                                            region:'center',
                                                            items:	[
                                                            			crearGridAnotacionesCarpeta(bD(cA))
                                                            		]
                                                        }
                                            			
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Anotaciones',
										width: 980,
										height:480,
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
	
}

////


function crearGridAnotacionesCarpeta(carpetaAdministrativa)
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idRegistro'},
		                                                {name:'fechaRegistro', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name: 'responsableRegistro'},
                                                        {name: 'comentarios'},
                                                        {name: 'recursos'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../paginasFunciones/funcionesModulosEspeciales_ModulosPredefinidos.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'fechaRegistro', direction: 'ASC'},
                                                            groupField: 'fechaRegistro',
                                                            remoteGroup:false,
				                                            remoteSort: true,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='15';
                                        proxy.baseParams.carpetaAdministrativa=carpetaAdministrativa;
                                    }
                        )   


		var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer(),
                                                            
                                                            {
                                                                header:'',
                                                                width:900,
                                                                sortable:true,
                                                                dataIndex:'fechaRegistro',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	var lblRenderer='<table width="100%">'+
                                                                                                '<tr>'+
                                                                                                    '<td align="right"><span class="TSJDF_Control" style="font-size:11px !important;">'+
                                                                                                    '('+registro.data.fechaRegistro.format('d/m/Y H:i')+' hrs.) <b>'+registro.data.responsableRegistro+':</b>&nbsp;&nbsp(<a href="javascript:mostrarVentanaRecursos(\''+bE(registro.data.idRegistro)+'\')">'+registro.data.recursos.length+(registro.data.recursos.length==1?' recurso adjunto':' recursos adjuntos')+'</a>)'+
                                                                                                    '</span>'+
                                                                                                    '</td>'+
                                                                                                '</tr>'+
                                                                                                '<tr>'+
                                                                                                    '<td align="justify"><p class="triangle-border top"><span class="TSJDF_Control" style="font-size:11px !important;">'+registro.data.comentarios+'</span></p></td>'+
                                                                                                '</tr>'+
                                                                                                '<tr>'+
                                                                                                    '<td align="right"><span class="TSJDF_Control" style="font-size:11px !important;"></span></p></td>'+
                                                                                                '</tr>'+
                                                                                            '</table>';
                                                                     		return lblRenderer;
                                                                        }
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gridNotas',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                cm: cModelo,
                                                                
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                columnLines : true,
                                                                tbar:	[
                                                                            {
                                                                                icon:'../images/comments_add.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Agregar Nota',
                                                                                handler:function()
                                                                                        {
                                                                                            mostrarVentanaAgregarNota(carpetaAdministrativa);
                                                                                        }
                                                                                
                                                                            },'-',
                                                                            {
                                                                                icon:'../images/delete.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Remover Nota',
                                                                                handler:function()
                                                                                        {
                                                                                            var fila=gEx('gridNotas').getSelectionModel().getSelected();
                                                                                            if(!fila)
                                                                                            {
                                                                                            	msgBox('Debe selecionar la nota que desea remover');
                                                                                            	return;
                                                                                            }
                                                                                            
                                                                                            function resp1(btn)
                                                                                            {
                                                                                            	if(btn=='yes')
                                                                                                {
                                                                                                    function funcAjax()
                                                                                                    {
                                                                                                        var resp=peticion_http.responseText;
                                                                                                        arrResp=resp.split('|');
                                                                                                        if(arrResp[0]=='1')
                                                                                                        {
                                                                                                            gEx('gridNotas').getStore().reload();
                                                                                                            
                                                                                                        }
                                                                                                        else
                                                                                                        {
                                                                                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                        }
                                                                                                    }
                                                                                                    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_ModulosPredefinidos.php',funcAjax, 'POST','funcion=14&iR='+fila.data.idRegistro,true);
                                                                                            	}
                                                                                            }
                                                                                            msgConfirm('Est&aacute; seguro de querer remover la nota seleccionada?',resp1);
                                                                                            
                                                                                            
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


function mostrarVentanaRecursos(iR)
{
	var pos=obtenerPosFila(gEx('gridNotas').getStore(),'idRegistro',bD(iR));
    var fila=gEx('gridNotas').getStore().getAt(pos);
    
   var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			crearGridRecursosAdjuntos(fila.data.recursos)
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Recursos Adjuntos',
										width: 830,
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


function crearGridRecursosAdjuntos(dsDatos)
{

    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'recurso'},
                                                                    {name: 'tipoRecurso'},
                                                                    {name: 'descripcion'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel();
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														{
															header:'',
															width:30,
															sortable:true,
                                                            align:'center',
															dataIndex:'tipoRecurso',
                                                            renderer:function(val,meta)
                                                            			{
                                                                        	meta.attr='style="vertical-align: top !important; min-height:21px;height:auto;white-space: normal;"';
                                                                    	
                                                                        	var pos=existeValorMatriz(arrTipoRecurso,val);
                                                                            return '<img src="'+arrTipoRecurso[pos][2]+'">';
                                                                        }
														},
														{
															header:'Descripci&oacute;n',
															width:330,
															sortable:true,
															dataIndex:'descripcion',
                                                            renderer:function(val,meta,registro)
                                                            		{
                                                                    	meta.attr='style=" vertical-align: top !important;min-height:21px;height:auto;white-space: normal;"';
                                                                    	return mostrarValorDescripcion(escaparEnter(val==''?'(Sin comentarios)':val));
                                                                    }
														},
														{
															header:'Recurso',
															width:370,
															sortable:true,
															dataIndex:'recurso',
                                                            renderer:function(val,meta,registro)
                                                            		{
                                                                    	meta.attr='style=" vertical-align: top !important;min-height:21px;height:auto;white-space: normal;"';
                                                                    	
                                                                        switch(registro.data.tipoRecurso)
                                                                        {
                                                                        	case '1':
                                                                            	return formatearTeewt(val);
                                                                            break;
                                                                        	case '6':
                                                                            	return '<a href="javascript:abrirURLEnlace(\''+bE(val)+'\')">'+val+'</a>';
                                                                            break;
                                                                        	case '3':
                                                                            	return formatearVideoYoutube(val,300);
                                                                            break;
                                                                            case '2':
                                                                            	return formatearPublicacionFaceBook(val,300);
                                                                            break;
                                                                            case '5':
                                                                            	var arrDatos=val.split('|');
                                                                            	return '<a href="javascript:visualizarDocumentoRecursoProceso(\''+bE(arrDatos[0])+'\',\''+bE(arrDatos[1])+'\')">'+arrDatos[1]+'</a>';
                                                                            break;
                                                                        }
                                                                    	return val;
                                                                    }
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            
                                                            store:alDatos,
                                                            frame:false,
                                                            y:10,
                                                            x:10,
                                                            id:'gRecursosAdjuntos',
                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            stripeRows :true,                                                            
                                                            columnLines : true,
                                                            height:350,
                                                            width:800,
                                                            sm:chkRow
                                                        }
                                                    );
	return 	tblGrid;
}
function mostrarVentanaAgregarNota(cAdministrativa)
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
                                                            html:'Ingrese la nota que desea agregar:'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            width:800,
                                                            height:80,
                                                            id:'txtNota',
                                                            xtype:'textarea'
                                                        },
                                                        crearGridRecursoNota()
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar nota',
										width: 850,
										height:470,
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
                                                                	gEx('txtNota').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
																		var txtNota=gEx('txtNota');
                                                                        
                                                                        if(txtNota.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	txtNota.focus();
                                                                            }
                                                                            msgBox('Debe ingresar la nota que desea agregar');
                                                                            return;
                                                                        }
                                                                        var arrRecursos='';
                                                                        var x;
                                                                        var f;
                                                                        var gRecursos=gEx('gRecursos');
                                                                        var o;
                                                                        for(x=0;x<gRecursos.getStore().getCount();x++)
                                                                        {
                                                                        	f=gRecursos.getStore().getAt(x);
                                                                            o='{"recurso":"'+cv(f.data.recurso)+'","tipoRecurso":"'+f.data.tipoRecurso+'","descripcion":"'+cv(f.data.descripcion)+'"}';
                                                                        
                                                                        	if(arrRecursos=='')
                                                                            	arrRecursos=o;
                                                                            else
                                                                            	arrRecursos+=','+o;
                                                                        }
                                                                        var cadObj='{"carpetaAdministrativa":"'+cAdministrativa+'","comentario":"'+cv(txtNota.getValue())+
                                                                        		'","arrRecursos":['+arrRecursos+']}';
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                                gEx('gridNotas').getStore().reload();
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_ModulosPredefinidos.php',funcAjax, 'POST','funcion=13&cadObj='+cadObj,true);
                                                                        
                                                                        
                                                                        
                                                                        
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

function crearGridRecursoNota()
{
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'recurso'},
                                                                    {name: 'tipoRecurso'},
                                                                    {name: 'descripcion'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel();
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														{
															header:'',
															width:30,
															sortable:true,
                                                            align:'center',
															dataIndex:'tipoRecurso',
                                                            renderer:function(val,meta)
                                                            			{
                                                                        	meta.attr='style="vertical-align: top !important; min-height:21px;height:auto;white-space: normal;"';
                                                                    	
                                                                        	var pos=existeValorMatriz(arrTipoRecurso,val);
                                                                            return '<img src="'+arrTipoRecurso[pos][2]+'">';
                                                                        }
														},
														{
															header:'Descripci&oacute;n',
															width:330,
															sortable:true,
															dataIndex:'descripcion',
                                                            renderer:function(val,meta,registro)
                                                            		{
                                                                    	meta.attr='style=" vertical-align: top !important;min-height:21px;height:auto;white-space: normal;"';
                                                                    	return mostrarValorDescripcion(escaparEnter(val==''?'(Sin comentarios)':val));
                                                                    }
														},
														{
															header:'Recurso',
															width:370,
															sortable:true,
															dataIndex:'recurso',
                                                            renderer:function(val,meta,registro)
                                                            		{
                                                                    	meta.attr='style=" vertical-align: top !important;min-height:21px;height:auto;white-space: normal;"';
                                                                    	
                                                                        switch(registro.data.tipoRecurso)
                                                                        {
                                                                        	case '1':
                                                                            	return formatearTeewt(val);
                                                                            break;
                                                                        	case '6':
                                                                            	return '<a href="javascript:abrirURLEnlace(\''+bE(val)+'\')">'+val+'</a>';
                                                                            break;
                                                                        	case '3':
                                                                            	return formatearVideoYoutube(val,300);
                                                                            break;
                                                                            case '2':
                                                                            	return formatearPublicacionFaceBook(val,300);
                                                                            break;
                                                                            case '5':
                                                                            	var arrDatos=val.split('|');
                                                                            	return '<a href="javascript:visualizarDocumentoRecursoProceso(\''+bE(arrDatos[0])+'\',\''+bE(arrDatos[1])+'\')">'+arrDatos[1]+'</a>';
                                                                            break;
                                                                        }
                                                                    	return val;
                                                                    }
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            
                                                            store:alDatos,
                                                            frame:false,
                                                            y:130,
                                                            x:10,
                                                            id:'gRecursos',
                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            stripeRows :true,                                                            
                                                            columnLines : true,
                                                            height:230,
                                                            width:800,
                                                            sm:chkRow,
                                                            tbar:	[
                                                            			{
                                                                        	icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Agregar recurso',
                                                                            handler:function()
                                                                            		{
                                                                                    	mostrarVentanaAgregarRecursoNota();
                                                                                    }
                                                                            
                                                                        },'-',
                                                                        {
                                                                        	icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Remover recurso',
                                                                            handler:function()
                                                                            		{
                                                                                    	var fila=gEx('gRecursos').getSelectionModel().getSelected();
                                                                                        if(!fila)
                                                                                        {
                                                                                            msgBox('Debe selecionar el recurso que desea remover');
                                                                                            return;
                                                                                        }
                                                                                        
                                                                                        function respAux(btn)
                                                                                        {
                                                                                        	if(btn=='yes')
                                                                                            {
                                                                                            	tblGrid.getStore().remove(fila);
                                                                                            }
                                                                                        }
                                                                                        msgConfirm('Est&aacute; seguro de querer remover el recurso seleccionado?',respAux);
                                                                                        
                                                                                        
                                                                                    }
                                                                            
                                                                        }
                                                                        
                                                            		]
                                                        }
                                                    );
	return 	tblGrid;
}


function mostrarVentanaAgregarRecursoNota()
{
	
                    
	var arrTipoRecurso2=[['5','Documento PDF','../imagenesDocumentos/16/file_extension_pdf.png'],['6','URL a recurso WEB','../images/Icono_html.gif']];
	var cmbTipoRecurso=crearComboExt('cmbTipoRecurso',arrTipoRecurso2,145,5,300);
    cmbTipoRecurso.on('select',function(cmb,registro)
    							{
                                	if(registro.data.id=='5')
                                    {
                                    	gE('lblDocumento').innerHTML='Ingrese documento:';
                                        gEx('txtURL').hide();
                                        gEx('lblTablaAdjunta').show();
                                        gEx('btnUploadFile').show();
                                    }
                                    else
                                    {
                                    	gE('lblDocumento').innerHTML='Ingrese URL:';
                                        gEx('txtURL').show();
                                        gEx('lblTablaAdjunta').hide();
                                        gEx('btnUploadFile').hide();
                                    }
                                }
    				)
    cmbTipoRecurso.setValue('6');
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            html:'Tipo de recurso:'
                                                        },
                                                        cmbTipoRecurso,
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            html:'<span id="lblDocumento">Ingrese URL:</span>'
                                                        },
                                                        {
                                                        	x:145,
                                                            y:35,
                                                            
                                                            xtype:'textfield',
                                                            width:500,
                                                            id:'txtURL',
                                                            
                                                        },
                                                        {
                                                            x:145,
                                                            y:35,
                                                            hidden:true,
                                                            id:'lblTablaAdjunta',
                                                            html:	'<table width="290"><tr><td><div id="uploader"><p>Your browser doesn\'t have Flash, Silverlight or HTML5 support.</p></div></td></tr><tr id="filaAvance" style="display:none"><td align="right">Porcentaje de avance: <span id="porcentajeAvance"> 0%</span></td></tr></table>'
                                                        },
                                                       
                                                        {
                                                            x:435,
                                                            y:36,
                                                            hidden:true,
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
                                                        },
                                                        {
                                                        	x:10,
                                                            y:70,
                                                            html:'Ingrese la descripci&oacute;n del recurso:'
                                                        },
                                                        {
                                                        	x:10,
                                                          	y:100,
                                                            xtype:'textarea',
                                                            width:650,
                                                            height:60,
                                                            id:'txtDescripcionRecurso'
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar Recurso',
										width: 700,
										height:250,
										layout: 'fit',
										plain:true,
                                        id:'vAddRecurso',
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
                                                                                            file_types : "*.pdf;",			// or you could use something like: "*.doc;*.wpd;*.pdf",
                                                                                            file_types_description : "Todos los archivos",
                                                                                            file_upload_limit : 0,
                                                                                            file_queue_limit : 1,
                                                                             
                                                                                            
                                                                                            upload_success_handler : subidaCorrectaRecurso
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
																		if(cmbTipoRecurso.getValue()!='5')
                                                                        {
                                                                        	var txtURL=gEx('txtURL');
                                                                        	if(txtURL.getValue()=='')
                                                                            {
                                                                                function resp()
                                                                                {
                                                                                    txtURL.focus();
                                                                                }
                                                                                msgBox('Debe ingresar la URL del recurso',resp);
                                                                                return;
                                                                            }
                                                                            
                                                                            
                                                                            var registro=crearRegistro(	[
                                                                        								{name:'recurso'},
                                                                                                        {name:'tipoRecurso'},
                                                                                                        {name:'descripcion'}
                                                                        							]);
                                                                                                    
                                                                            var tRecurso=cmbTipoRecurso.getValue();
                                                                            
                                                                            if(tRecurso!='5')
                                                                            {
                                                                                if(txtURL.getValue().indexOf('youtube.com')!=-1)
                                                                                {
                                                                                    tRecurso='3';
                                                                                }
                                                                                else
                                                                                    if(txtURL.getValue().indexOf('twitter.com')!=-1)
                                                                                    {
                                                                                        tRecurso='1';
                                                                                    }	
                                                                                    else
                                                                                        if(txtURL.getValue().indexOf('facebook.com')!=-1)
                                                                                        {
                                                                                            tRecurso='2';
                                                                                        }		
                                                                            }
                                                                            
                                                                        
                                                                            var r=new registro	(
                                                                                                    {
                                                                                                        recurso:txtURL.getValue(),
                                                                                                        tipoRecurso:tRecurso,
                                                                                                        descripcion:gEx('txtDescripcionRecurso').getValue()
                                                                                                    }
                                                                                                )
                                                                        
                                                                            gEx('gRecursos').getStore().add(r);
                                                                            ventanaAM.close();
                                                                        }
                                                                        else
                                                                        {
                                                                        	if(uploadControl.files.length==0)
                                                                            {
                                                                                msgBox('Debe ingresar el documento que desea adjuntar');
                                                                                return;
                                                                            }
                                                                            uploadControl.start();
                                                                        	
                                                                        }
                                                                        
                                                                        
                                                                        
                                                                    
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


function formatearTeewt(val)
{
	return '<iframe border=0 frameborder=0   height="400" width=300  src="https://twitframe.com/show?url='+val+'"></iframe>';

}

function formatearVideoYoutube(val,tam)
{
	var ancho=956;
    var alto=538;
    var porcentaje=(tam/ancho);
    var url=val;
	var anchoFinal=ancho*porcentaje;
    var altoFinal=alto*porcentaje;
	if(val.indexOf('iframe')!=-1)
    {
    	var anchoLBL='';
        var altoLBL='';
    	
    	if(val.indexOf('width')!=-1)
        {
        	var arrDatos=val.split('width="');
            arrDatos=arrDatos[1].split('"');
    		anchoLBL='width="'+arrDatos[0]+'"';
            
            url=url.replace(anchoLBL,'width="'+anchoFinal+'"');
            
        }
        
        if(val.indexOf('height')!=-1)
        {
        	var arrDatos=val.split('height="');
            arrDatos=arrDatos[1].split('"');
    		altoLBL='height="'+arrDatos[0]+'"';
            url=url.replace(altoLBL,'height="'+altoFinal+'"');
            
        }
        
        if(anchoLBL=='')
        {
        	url=url.replace('src="',' width="'+anchoFinal+'" src="');
        }
        
        if(altoLBL=='')
        {
        	url=url.replace('src="',' height="'+altoFinal+'" src="');
        }
        
    }
    else
    {
    	var urlVideo='';
        var arrDatos=val.split('?v=');
        urlVideo=arrDatos[1];
    	url='<iframe width="'+anchoFinal+'" height="'+altoFinal+'" src="https://www.youtube.com/embed/'+urlVideo+
        	'" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
    }
    
    return url;
    
}


function formatearPublicacionFaceBook(val,tam)
{
	var ancho=560;
    var alto=558;
    var porcentaje=(tam/ancho);
    var url=val;
	var anchoFinal=ancho*porcentaje;
    var altoFinal=alto*porcentaje;
	if(val.indexOf('iframe')!=-1)
    {
    	var anchoLBL='';
        var altoLBL='';
    	
    	if(val.indexOf('width')!=-1)
        {
        	var arrDatos=val.split('width="');
            arrDatos=arrDatos[1].split('"');
            ancho=parseInt(arrDatos[0]);
            porcentaje=(tam/ancho);
    		anchoLBL='width="'+arrDatos[0]+'"';
            anchoFinal=ancho*porcentaje;
            url=url.replace(anchoLBL,'width="'+anchoFinal+'"');
            url=url.replace("width="+arrDatos[0],'width='+anchoFinal);
            
        }
        
        if(val.indexOf('height')!=-1)
        {
        	var arrDatos=val.split('height="');
            arrDatos=arrDatos[1].split('"');
    		altoLBL='height="'+arrDatos[0]+'"';
            alto=parseInt(arrDatos[0]);
           
    		anchoLBL='width="'+arrDatos[0]+'"';
            altoFinal=alto*porcentaje;
            
            url=url.replace(altoLBL,'height="'+altoFinal+'"');
            
        }
        
        if(anchoLBL=='')
        {
        	url=url.replace('src="',' width="'+anchoFinal+'" src="');
        }
        
        if(altoLBL=='')
        {
        	url=url.replace('src="',' height="'+altoFinal+'" src="');
        }
        
    }
   
    return url;
    
}

function abrirURLEnlace(URL)
{

	var arrParam=[];
    enviarFormularioDatos(bD(URL),arrParam,'GET','_blank');
}

function subidaCorrectaRecurso(file, serverData) 
{
	
	try 
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
            if(gE('txtFileName'))
	            gE('txtFileName').value=arrDatos[2];
            
			
            
            var registro=crearRegistro(	[
                                        {name:'recurso'},
                                        {name:'tipoRecurso'},
                                        {name:'descripcion'}
                                    ]);
                                    
           
            var r=new registro	(
                                    {
                                        recurso:arrDatos[1]+'|'+arrDatos[2],
                                        tipoRecurso:'5',
                                        descripcion:gEx('txtDescripcionRecurso').getValue()
                                    }
                                )
        
            gEx('gRecursos').getStore().add(r);
            gEx('vAddRecurso').close();
            
		}
		
	} 
    catch (e) 
	{
		alert(e);
	}
}

function visualizarDocumentoRecursoProceso(idDocumento,nombreArchivo)
{
	if(window.parent)
		window.parent.mostrarVisorDocumentoProceso('pdf',bD(idDocumento),null,bD(nombreArchivo));
    else
    	mostrarVisorDocumentoProceso('pdf',bD(idDocumento),null,bD(nombreArchivo));
}