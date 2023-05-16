<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$consulta="SELECT DISTINCT anio,anio FROM 7004_seriesUnidadesGestion ORDER BY anio ASC";
	$arrCiclosCarpeta=$con->obtenerFilasArreglo($consulta);
	$anio=date("Y");
	
	$consulta="SELECT idRegistro,descripcion FROM 7014_situacionCarpetaAdministrativa";
	$arrSituacionCarpeta=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT idEtapaProcesal,descripcionEtapa FROM 7009_etapasProcesales";
	$arrEtapaProcesal=$con->obtenerFilasArreglo($consulta);
	
	$arrRolesSL[0]="181_0";
	$arrRolesSL[0]="182_0";
	$arrRolesUgas[0]="1_0";
	$arrRolesUgas[1]="90_0";
	$arrRolesUgas[2]="112_0";
	$arrRolesUgas[3]="159_0";
	$arrRolesUgas[4]="181_0";
	$arrRolesUgas[5]="182_0";
	$arrRolesUgas[6]="208_0";
	$comp=" and claveUnidad='".$_SESSION["codigoInstitucion"]."'";
	$comp2=" c.unidadGestion='".$_SESSION["codigoInstitucion"]."' and ";
	foreach($arrRolesUgas as $idRol=>$rol)
	{
		if(existeRol("'".$rol."'"))
		{
			$comp="";
			$comp2="";
			break;
		}
	}
	if(existeRol("'182_0'"))
	{
		$comp=' and id__17_tablaDinamica in(SELECT idPadre FROM _17_tiposCarpetasAdministra WHERE idOpcion=1) and id__17_tablaDinamica not in(50,49)';
	}
	
	if(existeRol("'208_0'"))
	{
		$comp=' and id__17_tablaDinamica in(SELECT idPadre FROM _17_tiposCarpetasAdministra WHERE idOpcion in (1,6)) and id__17_tablaDinamica not in(50,49,52)';
	}
	
	
	if(existeRol("'219_0'"))
	{
		$comp=' and id__17_tablaDinamica in(SELECT id__17_tablaDinamica FROM _17_tablaDinamica t,_17_gridDelitosAtiende d 
										WHERE cmbCategoria=1 AND t.id__17_tablaDinamica=d.idReferencia AND d.tipoDelito  IN(\'E\',\'EA\',\'D\')) ';
		$comp2="idTipoCarpeta in(SELECT idOpcion FROM _17_tiposCarpetasAdministra t,_17_gridDelitosAtiende d 
										WHERE  t.idPadre=d.idReferencia AND d.tipoDelito  IN('E','EA','D')) and ";
	}
	
	$consulta="SELECT claveUnidad,nombreUnidad FROM _17_tablaDinamica WHERE cmbCategoria in(1,2) ".$comp." ORDER BY prioridad";

	$arrUnidadesGestion=$con->obtenerFilasArreglo($consulta);
	$consulta=" SELECT DISTINCT t.idTipoCarpeta,nombreTipoCarpeta  FROM 7006_carpetasAdministrativas c,7020_tipoCarpetaAdministrativa t 
				 WHERE ".$comp2." c.tipoCarpetaAdministrativa=t.idTipoCarpeta order by prioridad";

	$arrTiposCarpetas=$con->obtenerFilasArreglo($consulta);
	
	$tCarpertaDefault=$con->obtenerValor($consulta);
	
?>

var tCarpertaDefault='<?php echo $tCarpertaDefault ?>';
var arrTiposCarpetas=<?php echo $arrTiposCarpetas?>;
var arrUnidadesGestion=<?php echo $arrUnidadesGestion?>;
var arrEtapaProcesal=<?php echo $arrEtapaProcesal ?>;
var arrSituacionCarpeta=<?php echo $arrSituacionCarpeta ?>;
var anio='<?php echo $anio ?>';
var arrCiclosCarpeta=<?php echo $arrCiclosCarpeta?>;
Ext.onReady(inicializar);

function inicializar()
{
	var cmbUnidadGestion=crearComboExt('cmbUnidadGestion',arrUnidadesGestion,0,0,400);
    cmbUnidadGestion.setValue(arrUnidadesGestion[0][0]);
    
    var cmbTipoCarpeta=crearComboExt('cmbTipoCarpeta',arrTiposCarpetas,0,0,250);
    cmbTipoCarpeta.setValue(tCarpertaDefault);
    
    cmbUnidadGestion.on('select',recargarGrid);
    cmbTipoCarpeta.on('select',function(cmb,registro)
    							{
                                	ajustarColumna(registro.data.id);
                                	recargarGrid();
                                }
    				);
    
    
	new Ext.Viewport(	{
                                layout: 'border',
                                items: [
                                            {
                                                xtype:'panel',
                                                region:'center',
                                                layout:'border',
                                                tbar:	[
                                                			{
                                                                xtype:'label',
                                                                html:'<b>Unidad de Gesti&oacute;n Judicial:</b>&nbsp;&nbsp;&nbsp;'
                                                            },cmbUnidadGestion,
                                                            '-',
                                                            {
                                                            
                                                                xtype:'label',
                                                                html:'<b>Tipo de carpeta:</b>&nbsp;&nbsp;&nbsp;'
                                                            },
                                                            cmbTipoCarpeta
                                                           
                                                		],
                                                items:	[
                                                            crearGridCarpetasAdministrativas()
                                                        ]
                                            }
                                         ]
                            }
                        )   

	ajustarColumna(tCarpertaDefault);	
}

function crearGridCarpetasAdministrativas()
{
	var cmbAnio=crearComboExt('cmbAnio',arrCiclosCarpeta,0,0,120);
    
    cmbAnio.setValue(anio);
    cmbAnio.on('select',recargarGrid);
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name: 'carpetaAdministrativa'},
		                                                {name: 'situacion'},
                                                        {name: 'carpetaBase'},
                                                        {name: 'accionesCarpeta'},
                                                        {name: 'fechaCreacion', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name: 'etapaProcesal'},
                                                        {name: 'carpetaInicial'},
                                                        {name: 'carpetaOralidad'},
                                                        {name: 'carpetaEjecucion'},
                                                        {name: 'imputados'},
                                                        {name: 'victimas'},
                                                        {name: 'delitos'},
                                                        {name: 'carpetaInvestigacion'},
                                                        {name: 'cierreInvestigacion', type:'date', dateFormat:'Y-m-d'},
                                                        {name: 'ultimoJuez'},
                                                        {name: 'tipoCarpeta'},
                                                        {name: 'idCarpetaAdministrativa'},
                                                        {name: 'fechaAcusacion', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name: 'juezResponsable'},
                                                        {name: 'unidadGestion'},
                                                        {name: 'carpetaLeyNacional'},
                                                        {name: 'remiteIncompentencia'},
                                                        {name: 'carpetaIncompetencia'}
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
                                              remoteSort: true,
                                              autoLoad:false                                              
                                          }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	
                                        if(gEx('btnIncompetencia'))
	                                        gEx('btnIncompetencia').disable();

                                        if(gEx('btnUnidadGestion'))
	                                        gEx('btnUnidadGestion').disable();

                                        if(gEx('btnTribunalEnjuiciamiento'))
	                                        gEx('btnTribunalEnjuiciamiento').disable();
                                            
                                        if(gEx('btnEjecucion'))    
	                                        gEx('btnEjecucion').disable();
                                        
                                        if(gEx('btnEjecucionPP'))    
	                                        gEx('btnEjecucionPP').disable();  
                                          
                                            
                                    	proxy.baseParams.funcion='50';
                                        proxy.baseParams.uG=gEx('cmbUnidadGestion').getValue();
                                        proxy.baseParams.anio=cmbAnio.getValue();
                                        proxy.baseParams.tC=gEx('cmbTipoCarpeta').getValue();
                                        
                                    }
                        )   
       
       
       
	var paginador=	new Ext.PagingToolbar	(
                                              {
                                                    pageSize: 200,
                                                    store: alDatos,
                                                    displayInfo: true,
                                                    disabled:false
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
                                                                            	type:'list',
                                                                                dataIndex:'etapaProcesal',
                                                                                options:arrEtapaProcesal,
                                                                                phpMode:true
                                                                            },
                                                                            {
                                                                            	type:'string',
                                                                                dataIndex:'carpetaBase'
                                                                            },
                                                                            {
                                                                            	type:'list',
                                                                                dataIndex:'situacion',
                                                                                options:arrSituacionCarpeta,
                                                                                phpMode:true
                                                                            }
                                                            			]
                                                        }
                                                    );         
       
       var chkRow=new Ext.grid.CheckboxSelectionModel({singleSelect:true});       
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer({width:40}),
                                                            chkRow,
                                                            {
                                                                header:'',
                                                                width:60,
                                                                sortable:true,
                                                                dataIndex:'accionesCarpeta',
                                                                renderer:function(val)
                                                                			{
                                                                            	return val
                                                                            }
                                                            },
                                                            {
                                                                header:'Carpeta Judicial',
                                                                width:170,
                                                                sortable:true,
                                                                dataIndex:'carpetaAdministrativa',
                                                                renderer:function(val)
                                                                			{
                                                                            	return '<a href="javascript:abrirPanelAdministracionCarpeta(\''+bE(val)+'\')">'+val+'</a>';
                                                                            }
                                                            },
                                                            {
                                                                header:'Carpeta Origen',
                                                                width:140,
                                                                sortable:true,
                                                                dataIndex:'carpetaBase',
                                                                renderer:function(val)
                                                                			{
                                                                            	return val;
                                                                            }
                                                            },
                                                            {
                                                                header:'Fecha Creaci&oacute;n',
                                                                width:130,
                                                                sortable:true,
                                                                dataIndex:'fechaCreacion',
                                                                renderer:function(val,meta,registro)
                                                                	{
                                                                    	if(val)
                                                                        	return val.format('d/m/Y H:i:s');
                                                                    }
                                                            },
                                                            {
                                                                header:'Juez Responsable',
                                                                width:250,
                                                                hidden:true,
                                                                sortable:true,
                                                                dataIndex:'juezResponsable',
                                                                renderer:function(val,meta,registro)
                                                                	{
                                                                    	return mostrarValorDescripcion(val);
                                                                    }
                                                            },
                                                            {
                                                                header:'Time Line',
                                                                width:70,
                                                                sortable:true,
                                                                dataIndex:'carpetaAdministrativa',
                                                                renderer:function(val,meta,registro)
                                                                	{
                                                                    	if(val.indexOf('-EX')==-1)
                                                                        {
                                                                        	return '<a href="javascript:visualizarTimeLine(\''+bE(val)+'\')"><img src="../images/magnifier.png" /> Ver</a>';
                                                                        }
                                                                    }
                                                            },                                                           
                                                            
                                                            {
                                                                header:'Etapa procesal',
                                                                width:230,
                                                                sortable:true,
                                                                hidden:true,
                                                                dataIndex:'etapaProcesal',
                                                                renderer:function(val,meta,registro)
                                                                	{
                                                                    	return formatearValorRenderer(arrEtapaProcesal,val);
                                                                    }
                                                            },
                                                            {
                                                                header:'Situaci&oacute;n carpeta',
                                                                width:220,
                                                                sortable:true,
                                                                dataIndex:'situacion',
                                                                renderer:function(val)
                                                                	{
                                                                    	return formatearValorRenderer(arrSituacionCarpeta,val);
                                                                    }
                                                            },
                                                            {
                                                                header:'Carpeta de Investigaci&oacute;n',
                                                                width:300,
                                                                sortable:true,
                                                                dataIndex:'carpetaInvestigacion',
                                                                renderer:function(val,meta,registro)
                                                                	{
                                                                    	return val;
                                                                    }
                                                            },
                                                            {
                                                                header:'Juez sentenciador',
                                                                width:250,
                                                                sortable:true,
                                                                dataIndex:'ultimoJuez',
                                                                renderer:function(val,meta,registro)
                                                                	{
                                                                    	return val;
                                                                    }
                                                            },
                                                            {
                                                                header:'Carpeta Inicial',
                                                                width:140,
                                                                sortable:true,
                                                                dataIndex:'carpetaInicial',
                                                                renderer:function(val)
                                                                		{
                                                                        	var arrCarpetas=val.split(',');
                                                                            var carpetas='';
                                                                            var x;
                                                                            var l;
                                                                            for(x=0;x<arrCarpetas.length;x++)
                                                                            {
                                                                            	l='<a href="javascript:abrirPanelAdministracionCarpeta(\''+bE(arrCarpetas[x])+'\')">'+arrCarpetas[x]+'</a>';
                                                                                if(carpetas=='')
                                                                                	carpetas=l;
                                                                                else
                                                                                	carpetas+=', '+l;
                                                                            }
                                                                            return carpetas;
                                                                        }
                                                            },
                                                            {
                                                                header:'Carpeta de Tribunal de Enjuiciamiento',
                                                                width:230,
                                                                sortable:true,
                                                                dataIndex:'carpetaOralidad',
                                                                renderer:function(val)
                                                                		{
                                                                        	var arrCarpetas=val.split(',');
                                                                            var carpetas='';
                                                                            var x;
                                                                            var l;
                                                                            for(x=0;x<arrCarpetas.length;x++)
                                                                            {
                                                                            	l='<a href="javascript:abrirPanelAdministracionCarpeta(\''+bE(arrCarpetas[x])+'\')">'+arrCarpetas[x]+'</a>';
                                                                                if(carpetas=='')
                                                                                	carpetas=l;
                                                                                else
                                                                                	carpetas+=', '+l;
                                                                            }
                                                                            return carpetas;
                                                                        }
                                                            },
                                                            {
                                                                header:'Carpeta de Ejecuci&oacute;n',
                                                                width:140,
                                                                sortable:true,
                                                                dataIndex:'carpetaEjecucion',
                                                                renderer:function(val)
                                                                		{
                                                                        	var arrCarpetas=val.split(',');
                                                                            var carpetas='';
                                                                            var x;
                                                                            var l;
                                                                            for(x=0;x<arrCarpetas.length;x++)
                                                                            {
                                                                            	l='<a href="javascript:abrirPanelAdministracionCarpeta(\''+bE(arrCarpetas[x])+'\')">'+arrCarpetas[x]+'</a>';
                                                                                if(carpetas=='')
                                                                                	carpetas=l;
                                                                                else
                                                                                	carpetas+=', '+l;
                                                                            }
                                                                            return carpetas;
                                                                        }
                                                            },
                                                            {
                                                                header:'Carpeta de Ley Nacional',
                                                                width:170,
                                                                sortable:true,
                                                                dataIndex:'carpetaLeyNacional',
                                                                renderer:function(val)
                                                                		{
                                                                        	var arrCarpetas=val.split(',');
                                                                            var carpetas='';
                                                                            var x;
                                                                            var l;
                                                                            for(x=0;x<arrCarpetas.length;x++)
                                                                            {
                                                                            	l='<a href="javascript:abrirPanelAdministracionCarpeta(\''+bE(arrCarpetas[x])+'\')">'+arrCarpetas[x]+'</a>';
                                                                                if(carpetas=='')
                                                                                	carpetas=l;
                                                                                else
                                                                                	carpetas+='<br> '+l;
                                                                            }
                                                                            return carpetas;
                                                                        }
                                                            },
                                                            {
                                                                header:'Carpetas Incompetencia',
                                                                width:170,
                                                                sortable:true,
                                                                dataIndex:'carpetaIncompetencia',
                                                                renderer:function(val)
                                                                		{
                                                                        	var arrCarpetas=val.split(',');
                                                                            var carpetas='';
                                                                            var x;
                                                                            var l;
                                                                            for(x=0;x<arrCarpetas.length;x++)
                                                                            {
                                                                            	l='<a href="javascript:abrirPanelAdministracionCarpeta(\''+bE(arrCarpetas[x])+'\')">'+arrCarpetas[x]+'</a>';
                                                                                if(carpetas=='')
                                                                                	carpetas=l;
                                                                                else
                                                                                	carpetas+='<br> '+l;
                                                                            }
                                                                            return carpetas;
                                                                        }
                                                            },
                                                            {
                                                                header:'Imputados',
                                                                width:450,
                                                                sortable:true,
                                                                dataIndex:'imputados',
                                                                renderer:function(val,meta,registro)
                                                                	{
                                                                    	
                                                                    	return val;
                                                                    }
                                                            },
                                                            {
                                                                header:'Victimas',
                                                                width:350,
                                                                sortable:true,
                                                                dataIndex:'victimas',
                                                                renderer:function(val,meta,registro)
                                                                	{
                                                                    	
                                                                    	return val;
                                                                    }
                                                            },
                                                            {
                                                                header:'Delitos',
                                                                width:350,
                                                                sortable:true,
                                                                dataIndex:'delitos',
                                                                renderer:function(val,meta,registro)
                                                                	{
                                                                    	
                                                                    	return val;
                                                                    }
                                                            },
                                                             {
                                                                header:'Cierre de investigaci&oacute;n',
                                                                width:150,
                                                                sortable:true,
                                                                dataIndex:'cierreInvestigacion',
                                                                renderer:function(val,meta,registro)
                                                                	{
                                                                    	if(val)
                                                                        	return val.format('d/m/Y')
                                                                    	return val;
                                                                    }
                                                            },
                                                             {
                                                                header:'Fecha de acusaci&oacute;n',
                                                                width:150,
                                                                sortable:true,
                                                                dataIndex:'fechaAcusacion',
                                                                renderer:function(val,meta,registro)
                                                                	{
                                                                    	if(val)
                                                                        	return val.format('d/m/Y')
                                                                    	return val;
                                                                    }
                                                            }
                                                            
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'dCarpetas',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                cm: cModelo,
                                                                bbar:[paginador],
                                                                sm:chkRow,
                                                                stripeRows :false,
                                                                loadMask:true,
                                                                columnLines : true,      
                                                                plugins:	[filters],
                                                                tbar:	[
                                                                			 {
                                                                                xtype:'label',
                                                                                html:'<b>A&ntilde;o:</b>&nbsp;&nbsp;&nbsp;'
                                                                            },
                                                                            cmbAnio,'-'
                                                                            <?php
																			if(existeRol("'159_0'")||existeRol("'69_0'")||existeRol("'1_0'")||existeRol("'12_0'")||existeRol("'112_0'"))
																			{
																			?>
                                                                            
                                                                            ,
                                                                            {
                                                                                icon:'../images/folder_table.png',
                                                                                cls:'x-btn-text-icon',
                                                                                id:'btnRemitir',
                                                                                text:'Remitir carpeta judicial...',
                                                                                menu:	[
                                                                                			{
                                                                                                icon:'../images/arrow_switch.png',
                                                                                                cls:'x-btn-text-icon',
                                                                                                disabled:true,
                                                                                                id:'btnIncompetencia',
                                                                                                text:'Por Incompetencia',
                                                                                                handler:function()
                                                                                                        {
                                                                                                            registrarRemisionCarpetaJudicial();
                                                                                                        }
                                                                                                
                                                                                            },'-',
                                                                                            
                                                                                            
                                                                                                /*'-'
                                                                                                {
                                                                                                    icon:'../images/user_go.png',
                                                                                                    cls:'x-btn-text-icon',
                                                                                                    disabled:true,
                                                                                                    hidden:true,
                                                                                                    id:'btnUnidadGestion',
                                                                                                    text:'Por vinculaci&oacute;n a proceso',
                                                                                                    handler:function()
                                                                                                            {
                                                                                                                registrarRemisionCarpetaJudicialUnidadGestion();
                                                                                                            }
                                                                                                    
                                                                                                }
                                                                                                
                                                                                                ,'-',
                                                                                                {
                                                                                                    icon:'../images/world.png',
                                                                                                    cls:'x-btn-text-icon',
                                                                                                    disabled:true,
                                                                                                    hidden:true,
                                                                                                    id:'btnUnidadGestionZT',
                                                                                                    text:'Por zona territorial',
                                                                                                    handler:function()
                                                                                                            {
                                                                                                                registrarRemisionCarpetaJudicialUnidadGestionZonaTerritorial();
                                                                                                            }
                                                                                                    
                                                                                                }*/
                                                                                               
                                                                                            {
                                                                                                icon:'../images/group.png',
                                                                                                cls:'x-btn-text-icon',
                                                                                                disabled:true,
                                                                                                id:'btnTribunalEnjuiciamiento',
                                                                                                text:'A Tribunal de Enjuiciamiento',
                                                                                                handler:function()
                                                                                                        {
                                                                                                            registrarRemisionCarpetaTribunal();
                                                                                                        }
                                                                                                
                                                                                            },
                                                                                            '-'
                                                                                           	
                                                                                            ,{
                                                                                                icon:'../images/user_gray.png',
                                                                                                cls:'x-btn-text-icon',
                                                                                                id:'btnEjecucion',
                                                                                                text:'A Unidad de Ejecuci&oacute;n',
                                                                                                handler:function()
                                                                                                        {
                                                                                                            registrarRemisionCarpetaEjecucionV2();
                                                                                                        }
                                                                                                
                                                                                            }
                                                                                            
                                                                                            ,
                                                                                            {
                                                                                                icon:'../images/vcard.png',
                                                                                                cls:'x-btn-text-icon', 
                                                                                                id:'btnEjecucionPP',
                                                                                                text:'Reportar Unidad de Ejecuci&oacute;n Prisi&oacute;n preventiva',
                                                                                                handler:function()
                                                                                                        {
                                                                                                            registrarRemisionCarpetaEjecucionPP();
                                                                                                        }
                                                                                                
                                                                                            }
                                                                                            
                                                                                             
                                                                                		]
                                                                                
                                                                            }
                                                                            <?php
																			
																			}
																			?>
                                                                		]/*,
                                                                view:new Ext.ux.grid.BufferView({
                                                                                                    // custom row height
                                                                                                    rowHeight: 29,
                                                                                                    // render rows as they come into viewable area.
                                                                                                    scrollDelay: false
                                                                                                })*/
                                                            }
                                                        );
        
        
        tblGrid.getSelectionModel().on('rowselect',function(sm,nFila,registro)
        											{
                                                    	if(gEx('btnIncompetencia'))
                                                            gEx('btnIncompetencia').disable();
                
                                                        if(gEx('btnUnidadGestion'))
                                                            gEx('btnUnidadGestion').disable();
				
                										if(gEx('btnUnidadGestionZT'))
                                                            gEx('btnUnidadGestionZT').disable();
                
                
                                                        if(gEx('btnTribunalEnjuiciamiento'))
                                                            gEx('btnTribunalEnjuiciamiento').disable();
                                                            
                                                        if(gEx('btnEjecucion'))    
                                                            gEx('btnEjecucion').disable();
                                                        
                                                        if(gEx('btnEjecucionPP'))    
                                                            gEx('btnEjecucionPP').disable();
                                                            
                                                    	if(parseFloat(registro.data.situacion)==1)	
                                                        {                                                     	
                                                            
                                                        	switch(registro.data.tipoCarpeta)
                                                            {
                                                            	case '1':
                                                                
                                                                	if(gEx('btnIncompetencia'))
	                                                                	gEx('btnIncompetencia').enable();
                                                                        
                                                                   	if(gEx('btnUnidadGestion'))
	                                                                    gEx('btnUnidadGestion').enable();
                                                                    
                                                                    if(gEx('btnUnidadGestionZT'))
	                                                                    gEx('btnUnidadGestionZT').enable(); 
                                                                    
                                                                    if(registro.data.unidadGestion!='012')
                                                                    { 
                                                                        if(gEx('btnTribunalEnjuiciamiento'))
                                                                            gEx('btnTribunalEnjuiciamiento').enable();
                                                                            
                                                                        
                                                                        if(gEx('btnEjecucion'))    
                                                                            gEx('btnEjecucion').enable();
																	}                                                                        
                                                                        
                                                                        
                                                                    if(
                                                                    	(registro.data.unidadGestion!='012')||
                                                                    	((registro.data.unidadGestion=='012')&&(registro.data.carpetaIncompetencia!=''))
                                                                       )
                                                                    { 
                                                                        if(gEx('btnEjecucionPP'))    
                                                                            gEx('btnEjecucionPP').enable();
																	}
                                                                break;
                                                                case '5':
                                                                	
                                                                	if(gEx('btnEjecucion'))
	                                                                	gEx('btnEjecucion').enable();
                                                                    if(gEx('btnEjecucionPP'))    
	                                                                    gEx('btnEjecucionPP').enable();
                                                                    if(gEx('btnIncompetencia'))
	                                                                	gEx('btnIncompetencia').enable();
                                                                break;
                                                                case '6':

                                                                	if(gEx('btnIncompetencia'))
	                                                                	gEx('btnIncompetencia').enable();
                                                                	

                                                                break;
                                                                
                                                            }
                                                        }
                                                        else
                                                        {
                                                        	switch(registro.data.tipoCarpeta)
                                                            {
                                                            	case '1':
                                                                
                                                                	if(
                                                                    	(registro.data.unidadGestion!='012')||
                                                                    	((registro.data.unidadGestion=='012')&&(registro.data.carpetaIncompetencia!=''))
                                                                       )
                                                                    { 
                                                                        if(gEx('btnEjecucionPP'))    
                                                                            gEx('btnEjecucionPP').enable();
																	}
                                                                break;
                                                                
                                                                
                                                            }
                                                        }
                                                    }
        								)
        
       tblGrid.getSelectionModel().on('rowdeselect',function(sm,nFila,registro)
        											{
                                                    	if(gEx('btnIncompetencia'))
                                                            gEx('btnIncompetencia').disable();
                
                                                        if(gEx('btnUnidadGestion'))
                                                            gEx('btnUnidadGestion').disable();
				
                										if(gEx('btnUnidadGestionZT'))
                                                            gEx('btnUnidadGestionZT').disable();
                
                
                                                        if(gEx('btnTribunalEnjuiciamiento'))
                                                            gEx('btnTribunalEnjuiciamiento').disable();
                                                            
                                                        if(gEx('btnEjecucion'))    
                                                            gEx('btnEjecucion').disable();
                                                        
                                                        if(gEx('btnEjecucionPP'))    
                                                            gEx('btnEjecucionPP').disable();
                                                    }
                                      )
       

	tblGrid.getStore().load(	{
    								params:	{
                                    			url:'../paginasFunciones/funcionesModulosEspeciales_SGP.php',
                                                start:0, 
                                                limit:200
                                                
                                    		}
    							}
                           )       
        return 	tblGrid;
}


function recargarContenedorCentral()
{
	recargarGrid();
}

function recargarGrid()
{
	gEx('dCarpetas').getStore().reload();
}

function registrarRemisionCarpetaJudicial()
{
	var arrFormularios=[['1','554'],['5','556'],['6','556']];
    
	
	var dCarpetas=gEx('dCarpetas');
    var fila=dCarpetas.getSelectionModel().getSelected();
    
    if(!fila)
    {
    	msgBox('Debe seleccionar la carpeta judicial sobre la cual desea realizar la operaci&oacute;n');
    	return;
    }
    
    var pos=existeValorMatriz(arrFormularios,fila.data.tipoCarpeta);
    
    
    var carpetaAdministrativa=fila.data.carpetaAdministrativa;
    
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            var obj={};    
            obj.ancho='100%';
            obj.alto='100%';
            obj.url='../modeloPerfiles/vistaDTDv3.php';
            obj.params=[['carpetaAdministrativa',carpetaAdministrativa],['idFormulario',arrFormularios[pos][1]],['idRegistro',arrResp[1]],['idReferencia',-1],
            		['dComp',arrResp[2]],['actor',arrResp[3]],['iCarpeta',fila.data.idCarpetaAdministrativa]];
            window.parent.abrirVentanaFancy(obj);
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=51&idFormulario='+arrFormularios[pos][1]+'&cA='+carpetaAdministrativa,true);
}

function registrarRemisionCarpetaJudicialUnidadGestion()
{
	var dCarpetas=gEx('dCarpetas');
    var fila=dCarpetas.getSelectionModel().getSelected();
    
    if(!fila)
    {
    	msgBox('Debe seleccionar la carpeta judicial sobre la cual desea realizar la operaci&oacute;n');
    	return;
    }
    
    var carpetaAdministrativa=fila.data.carpetaAdministrativa;
    
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            var obj={};    
            obj.ancho='100%';
            obj.alto='100%';
            obj.url='../modeloPerfiles/vistaDTDv3.php';
            obj.params=[['carpetaAdministrativa',carpetaAdministrativa],['idFormulario',329],['idRegistro',arrResp[1]],['idReferencia',-1],
            		['dComp',arrResp[2]],['actor',arrResp[3]]];
            window.parent.abrirVentanaFancy(obj);
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=70&cA='+carpetaAdministrativa,true);
}


function registrarRemisionCarpetaTribunal()
{
	var dCarpetas=gEx('dCarpetas');
    var fila=dCarpetas.getSelectionModel().getSelected();
    
    if(!fila)
    {
    	msgBox('Debe seleccionar la carpeta judicial sobre la cual desea realizar la operaci&oacute;n');
    	return;
    }
    
    var carpetaAdministrativa=fila.data.carpetaAdministrativa;
    
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            var obj={};    
            obj.ancho='100%';
            obj.alto='100%';
            obj.url='../modeloPerfiles/vistaDTDv3.php';
            obj.params=[['carpetaAdministrativa',carpetaAdministrativa],['idFormulario',320],['idRegistro',arrResp[1]],['idReferencia',-1],
            		['dComp',arrResp[2]],['actor',arrResp[3]]];
            window.parent.abrirVentanaFancy(obj);
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=72&cA='+carpetaAdministrativa,true);
}

function registrarRemisionCarpetaEjecucion()
{
	var dCarpetas=gEx('dCarpetas');
    var fila=dCarpetas.getSelectionModel().getSelected();
    
    if(!fila)
    {
    	msgBox('Debe seleccionar la carpeta judicial sobre la cual desea realizar la operaci&oacute;n');
    	return;
    }
    
    var carpetaAdministrativa=fila.data.carpetaAdministrativa;
    
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            var obj={};    
            obj.ancho='100%';
            obj.alto='100%';
            obj.url='../modeloPerfiles/vistaDTDv3.php';
            obj.params=[['carpetaAdministrativa',carpetaAdministrativa],['idFormulario',316],['idRegistro',arrResp[1]],['idReferencia',-1],
            		['dComp',arrResp[2]],['actor',arrResp[3]]];
            window.parent.abrirVentanaFancy(obj);
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=73&cA='+carpetaAdministrativa,true);
}

function registrarRemisionCarpetaEjecucionV2()
{
	var dCarpetas=gEx('dCarpetas');
    var fila=dCarpetas.getSelectionModel().getSelected();

    if(!fila)
    {
    	msgBox('Debe seleccionar la carpeta judicial sobre la cual desea realizar la operaci&oacute;n');
    	return;
    }
    
    var carpetaAdministrativa=fila.data.carpetaAdministrativa;
    
    
    
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            var obj={};    
            obj.ancho='100%';
            obj.alto='100%';
            obj.url='../modeloPerfiles/vistaDTDv3.php';
            var campoCarpeta='';
            switch(arrResp[4])
            {
            	case '385':
                	campoCarpeta='carpetaAdministrativa';
                break;
                case '516':
                	campoCarpeta='carpetaJudicialDeclinaCompetencia';
                break;
            }
            obj.params=[[campoCarpeta,carpetaAdministrativa],['idFormulario',arrResp[4]],['idRegistro',arrResp[1]],['idReferencia',-1],
            		['dComp',arrResp[2]],['actor',arrResp[3]]];
            window.parent.abrirVentanaFancy(obj);
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=112&tipoCarpeta='+fila.data.tipoCarpeta+'&cA='+carpetaAdministrativa,true);
}


function abrirPanelAdministracionCarpeta(cA)
{
	var obj={};
    obj.ancho='100%';
    obj.alto='100%';
    obj.url='../modulosEspeciales_SGJP/tableroAudienciaAdministracion.php';
    obj.params=[['cA',cA]];
    <?php

    foreach($arrRolesSL as $idRol=>$rol)
	{
		if(existeRol("'".$rol."'"))
		{
			echo "obj.params.push(['sL',1]);";
        }
    }
	?>
    obj.titulo='Carpeta Judicial: '+bD(cA);
    window.parent.abrirVentanaFancy(obj);
    
}

function visualizarTimeLine(cA)
{
	var obj={};
    obj.ancho='100%';
    obj.alto='100%';
    obj.openEffect='fade';
    obj.url='../modulosEspeciales_SGJP/historialCarpetaJudicial.php';
    obj.params=[['cA',cA],['cPagina','sFrm=true']];
    obj.titulo='Time Line, Carpeta Judicial: '+bD(cA);
    window.parent.abrirVentanaFancy(obj);
}

function registrarRemisionCarpetaJudicialUnidadGestionZonaTerritorial()
{
	var dCarpetas=gEx('dCarpetas');
    var fila=dCarpetas.getSelectionModel().getSelected();
    
    if(!fila)
    {
    	msgBox('Debe seleccionar la carpeta judicial sobre la cual desea realizar la operaci&oacute;n');
    	return;
    }
    
    var carpetaAdministrativa=fila.data.carpetaAdministrativa;
    
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            var obj={};    
            obj.ancho='100%';
            obj.alto='100%';
            obj.url='../modeloPerfiles/vistaDTDv3.php';
            obj.params=[['carpetaAdministrativa',carpetaAdministrativa],['idFormulario',382],['idRegistro',arrResp[1]],['idReferencia',-1],
            		['dComp',arrResp[2]],['actor',arrResp[3]]];
            window.parent.abrirVentanaFancy(obj);
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=70&iFormulario=382&cA='+carpetaAdministrativa,true);
}


function abrirDatosEnvioEjecucion(iR)
{
	var obj={};    
    obj.ancho='100%';
    obj.alto='100%';
    obj.url='../modeloPerfiles/vistaDTDv3.php';
    obj.params=[['idFormulario',385],['idRegistro',bD(iR)],['idReferencia',-1],
            ['dComp',bE('auto')],['actor',bE(0)]];
    window.parent.abrirVentanaFancy(obj);
}

function registrarRemisionCarpetaEjecucionPP()
{
	var dCarpetas=gEx('dCarpetas');
    var fila=dCarpetas.getSelectionModel().getSelected();
    
    if(!fila)
    {
    	msgBox('Debe seleccionar la carpeta judicial sobre la cual desea realizar la operaci&oacute;n');
    	return;
    }
    
    var carpetaAdministrativa=fila.data.carpetaAdministrativa;
    
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            var obj={};    
            obj.ancho='100%';
            obj.alto='100%';
            obj.url='../modeloPerfiles/vistaDTDv3.php';
            obj.params=[['carpetaAdministrativa',carpetaAdministrativa],['idFormulario',491],['idRegistro',arrResp[1]],['idReferencia',-1],
            		['dComp',arrResp[2]],['actor',arrResp[3]],['idUnidadOrigen',arrResp[4]]];
            window.parent.abrirVentanaFancy(obj);
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=199&cA='+carpetaAdministrativa,true);
}

function ajustarColumna(tColumna)
{
	var dCarpetas=gEx('dCarpetas');
	
    
    var arrColumnas=[];
    arrColumnas[0]=10;
    arrColumnas[1]=11;
    arrColumnas[2]=12;
    arrColumnas[3]=13;
    arrColumnas[4]=14;
    arrColumnas[5]=15;
    arrColumnas[6]=16;
    arrColumnas[7]=17;
    arrColumnas[8]=18;
    arrColumnas[9]=19;
    arrColumnas[10]=20;
    arrColumnas[11]=21;
    arrColumnas[12]=6;
    
    var x;
    for(x=0;x<arrColumnas.length;x++)
   	{
    	dCarpetas.getColumnModel().setHidden(arrColumnas[x],true);
    }
    
	switch(tColumna)
    {
    	case '1':
        	dCarpetas.getColumnModel().setHidden(4,false);
            dCarpetas.getColumnModel().setHidden(7,false);
        	dCarpetas.getColumnModel().setHidden(10,false);
            dCarpetas.getColumnModel().setHidden(13,false);
            dCarpetas.getColumnModel().setHidden(14,false);
            dCarpetas.getColumnModel().setHidden(15,false);
            dCarpetas.getColumnModel().setHidden(16,false);
            dCarpetas.getColumnModel().setHidden(17,false);
            dCarpetas.getColumnModel().setHidden(18,false);
            dCarpetas.getColumnModel().setHidden(19,false);
            dCarpetas.getColumnModel().setHidden(20,false);
            dCarpetas.getColumnModel().setHidden(21,false);
        break;
        case '2':
        	dCarpetas.getColumnModel().setHidden(4,true);
            dCarpetas.getColumnModel().setHidden(7,true);
            dCarpetas.getColumnModel().setHidden(17,false);
            dCarpetas.getColumnModel().setHidden(18,false);
            dCarpetas.getColumnModel().setHidden(19,false);
            
        break;
        case '3':
        	dCarpetas.getColumnModel().setHidden(4,false);
            dCarpetas.getColumnModel().setHidden(7,false);
        	dCarpetas.getColumnModel().setHidden(10,false);
            dCarpetas.getColumnModel().setHidden(17,false);
            dCarpetas.getColumnModel().setHidden(18,false);
            dCarpetas.getColumnModel().setHidden(19,false);
        break;
        case '4':
        	dCarpetas.getColumnModel().setHidden(4,false);
            dCarpetas.getColumnModel().setHidden(7,false);
        	dCarpetas.getColumnModel().setHidden(10,false);
            dCarpetas.getColumnModel().setHidden(17,false);
            dCarpetas.getColumnModel().setHidden(18,false);
            dCarpetas.getColumnModel().setHidden(19,false);
        break;
        case '5':
        	dCarpetas.getColumnModel().setHidden(4,false);
            dCarpetas.getColumnModel().setHidden(7,false);
        	dCarpetas.getColumnModel().setHidden(10,false);
        	dCarpetas.getColumnModel().setHidden(12,false);
            dCarpetas.getColumnModel().setHidden(14,false);
            dCarpetas.getColumnModel().setHidden(15,false);
            dCarpetas.getColumnModel().setHidden(16,false);
            dCarpetas.getColumnModel().setHidden(17,false);
            dCarpetas.getColumnModel().setHidden(18,false);
            dCarpetas.getColumnModel().setHidden(19,false);
            
        break;
        case '6':
                dCarpetas.getColumnModel().setHidden(4,false);
                dCarpetas.getColumnModel().setHidden(6,false);
                dCarpetas.getColumnModel().setHidden(7,false);
                dCarpetas.getColumnModel().setHidden(10,false);
                dCarpetas.getColumnModel().setHidden(11,false);
                dCarpetas.getColumnModel().setHidden(12,false);
                dCarpetas.getColumnModel().setHidden(13,false);
                dCarpetas.getColumnModel().setHidden(16,false);
                dCarpetas.getColumnModel().setHidden(17,false);
                dCarpetas.getColumnModel().setHidden(18,false);
                dCarpetas.getColumnModel().setHidden(19,false);
                
    
            break;
        case '7':
        	dCarpetas.getColumnModel().setHidden(4,true);
            dCarpetas.getColumnModel().setHidden(7,true);
            
           
        break;
        case '8':
        	dCarpetas.getColumnModel().setHidden(4,false);
            dCarpetas.getColumnModel().setHidden(7,false);
        	dCarpetas.getColumnModel().setHidden(10,false);
            dCarpetas.getColumnModel().setHidden(17,false);
            dCarpetas.getColumnModel().setHidden(18,false);
            dCarpetas.getColumnModel().setHidden(19,false);
        break;
        case '9':
        	dCarpetas.getColumnModel().setHidden(4,false);
            dCarpetas.getColumnModel().setHidden(7,false);
        	dCarpetas.getColumnModel().setHidden(10,false);
            dCarpetas.getColumnModel().setHidden(16,false);
            dCarpetas.getColumnModel().setHidden(17,false);
            dCarpetas.getColumnModel().setHidden(18,false);
            dCarpetas.getColumnModel().setHidden(19,false);
        break;

    }
}