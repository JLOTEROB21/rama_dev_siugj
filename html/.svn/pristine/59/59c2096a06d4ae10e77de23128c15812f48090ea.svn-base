<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$consulta="SELECT DISTINCT anioExpediente,anioExpediente FROM 7006_usuariosVSCarpetasAdministrativas WHERE idUsuario=".$_SESSION["idUsr"].
				" ORDER BY anioExpediente";
	$arrAnio=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT anioExpediente FROM 7006_usuariosVSCarpetasAdministrativas WHERE idUsuario=".$_SESSION["idUsr"].
				" ORDER BY anioExpediente desc";
	$anioExpediente=$con->obtenerValor($consulta);
	
	$consulta="SELECT claveMateria,materia,promocioneFirmadas FROM _480_tablaDinamica";
	$arrMateriasPromociones="[]";
	
	$consulta="SELECT id__17_tablaDinamica,UPPER(nombreUnidad) FROM _17_tablaDinamica";
	$arrJuzgados=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT idSituacion,icono,tamano FROM 7011_situacionEventosAudiencia";
	$arrSituaciones=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT idSituacion,descripcionSituacion FROM 7011_situacionEventosAudiencia";
	$arrSituacionEvento=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT idCategoria,nombreCategoria FROM 908_categoriasDocumentos";
	$arrCategorias=$con->obtenerFilasArreglo($consulta);
	
	
	$consulta="SELECT claveUnidad,nombreUnidad FROM _17_tablaDinamica WHERE categoriaDespacho in(2,3,4) and idEstado=2 ORDER BY nombreUnidad";
	$arrDespachos=$con->obtenerFilasArreglo($consulta);
	
	$arrEspecialidades="";
	$consulta="SELECT id__637_tablaDinamica,nombreEspecialidadDespacho FROM _637_tablaDinamica ORDER by nombreEspecialidadDespacho";
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$consulta="SELECT id__625_tablaDinamica,nombreTipoProceso FROM _625_tablaDinamica WHERE especialidad=".$fila[0]." ORDER BY nombreTipoProceso";
		$arrTiposProceso=$con->obtenerFilasArreglo($consulta);
		$o="['".$fila[0]."','".cv($fila[1])."',".$arrTiposProceso."]";
		if($arrEspecialidades=="")
			$arrEspecialidades=$o;
		else
			$arrEspecialidades.=",".$o;
	}
	$consulta="SELECT cveEstado,estado FROM 820_estados ORDER BY estado";
	$arrEstados=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT id__625_tablaDinamica,nombreTipoProceso FROM _625_tablaDinamica ORDER BY nombreTipoProceso";
	$arrTiposProcesoGlobal=$con->obtenerFilasArreglo($consulta);	

	$consulta="SELECT idTipoCarpeta,nombreTipoCarpeta FROM 7020_tipoCarpetaAdministrativa";
	$arrTipoCarpeta=$con->obtenerFilasArreglo($consulta);	
?>

var arrTipoCarpeta=<?php echo $arrTipoCarpeta?>;
var idNodoSeleccionado=-1;
var arrTiposProcesoGlobal=<?php echo $arrTiposProcesoGlobal?>;
var arrEstados=<?php echo $arrEstados?>;
var arrEstadoProceso=[['1','Abierto'],['3','Cerrado']];
var arrEstadoProcesoGlobal=[['0','No Iniciado'],['1','Abierto'],['3','Cerrado']];
var arrEspecialidades=[<?php echo $arrEspecialidades?>];
var arrDespachos=<?php echo $arrDespachos?>;
var arrCategorias=<?php echo $arrCategorias?>;
var arrSituacionEvento=<?php echo $arrSituacionEvento?>;
var arrSemaforo=<?php echo $arrSituaciones?>;
var arrTipoSeguimiento=[['1','Acuerdo'],['2','Promoci&oacute;n registrada']];
var enviarPromocion=-1;
var arrJuzgados=<?php echo $arrJuzgados?>;
var IdDocumento='';
var nombreDocumento='';
var arrMateriasPromociones=<?php echo $arrMateriasPromociones?>;
var anioExpediente='<?php echo $anioExpediente?>';
var arrAnio=<?php echo $arrAnio?>;

var arrSituacionPromocion=[['1','En espera de env&iacute;o a juzgado','../images/bullet-grey.png'],['2','En espera de atenci\xF3n','../images/bullet-yellow.png'],
							['3','Atendida','../images/bullet-green.png']];
var nodoExpedienteSel=null;

Ext.onReady(inicializar);

function inicializar()
{
	Ext.QuickTips.init();

	arrAnio.splice(0,0,['0','Cualquiera']);
	var cmbAnio=crearComboExt('cmbAnio',arrAnio,0,0,110);
    cmbAnio.setValue('0');
    
    cmbAnio.on('select',function(cmb,registro)
    					{
                        	idNodoSeleccionado=-1;
                        	gEx('arbolExpedientes').getRootNode().reload();
                        }
    			)
    new Ext.Viewport(	{
                                layout: 'border',
                                items: [
                                			{
                                            	xtype:'tabpanel',
                                                id:'panelGeneral',
                                                activeTab:0,
                                                region:'center',
                                                items:	[
                                                			
                                                			 {
                                                                xtype:'panel',                                                                
                                                                layout:'border',
                                                                title:'Procesos Judiciales',
                                                                items:	[
                                                                            {
                                                                                xtype:'panel',
                                                                                width:300,
                                                                                region:'west',
                                                                                layout:'border',
                                                                                tbar:	[
                                                                                            {
                                                                                                xtype:'label',
                                                                                                html:'<b>A&ntilde;o del Proceso:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
                                                                                                
                                                                                            },
                                                                                            cmbAnio,'-',
                                                                                            {
                                                                                                icon:'../images/magnifier.png',
                                                                                                cls:'x-btn-text-icon',
                                                                                                width:25,
                                                                                                tooltip:'B&uacute;squeda de Proceso Avanzada',
                                                                                                handler:function()
                                                                                                        {
                                                                                                            mostrarBusquedaProcesoJudicial();
                                                                                                        }
                                                                                                
                                                                                            },
                                                                                             {
                                                                                                icon:'../images/find_remove.png',
                                                                                                cls:'x-btn-text-icon',
                                                                                                tooltip:'Remover Filtros',
                                                                                                width:25,
                                                                                                handler:function()
                                                                                                        {
                                                                                                            gEx('cmbAnio').setValue('0');
                                                                                                            gEx('txtNumeroExpediente').setValue('');
                                                                                                            gEx('arbolExpedientes').getRootNode().reload();
                                                                                                            gEx('gridAudiencias').getStore().removeAll();
                                                                                                            gEx('gridCarpetaAdministrativa').getStore().removeAll();
                                                                                                            recargarGridEscritos();
                                                                                                        }
                                                                                                
                                                                                            },
                                                                                        ],
                                                                                items:	[
                                                                                                
                                                                                            crearArbolExpedientes()
                                                                                           ]
                                                                            },
                                                                            {
                                                                            	xtype:'panel',
                                                                                title: '<span class="letraRojaSubrayada8" style="font-size:11px"><b>Procesos Judiciales</b></span> <span id="lblExpediente" style="color:#000; font-weight:bold;font-size:10px"></span><span id="lblNoExpediente" style="color:#900; font-weight:bold;font-size:10px"></span>',
                                                                				region:'center',
                                                                                layout:'border',
                                                                                items:	[
                                                                                			{
                                                                                                  xtype:'tabpanel',
                                                                                                  region:'center',
                                                                                                  id:'panelGrids',
                                                                                                  activeTab:2,
                                                                                                  
                                                                                                  items:	[
                                                                                                  				crearArbolCarpetaAdministrativa(),
                                                                                                                crearGridEventos(),
                                                                                                                
                                                                                                                {
                                                                                                                    xtype:'panel',
                                                                                                                    id:'pActuaciones',
                                                                                                                    title:'Actuaciones/Escritos',
                                                                                                                    listeners:	{
                                                                                                                                    activate:function(p)
                                                                                                                                                {
                                                                                                                                                    if(!p.visualizado)
                                                                                                                                                    {
                                                                                                                                                        p.visualizado=1;
                                                                                                                                                        gEx('frameRegistroEscritos').load	(
                                                                                                                                                                                                {
                                                                                                                                                                                                    scripts:true,
                                                                                                                                                                                                    url:'../modeloProyectos/visorRegistrosProcesosV2.php',
                                                                                                                                                                                                    params:	{
                                                                                                                                                                                                                cPagina: 'sFrm=true',
                                                                                                                                                                                                                idProceso: 285,
                                                                                                                                                                                                                pantallaCompleta:'1',
                                                                                                                                                                                                                actor:"'23_0'",
                                                                                                                                                                                                        		parametrosProceso:bE('{"cAdministrativa":"'+(nodoExpedienteSel?nodoExpedienteSel.attributes.expediente:-1)+'"}'),
                                                                                                                                                                                                               	idFormulario: -1,
                                                                                                                                                                                                                contentIframe:1
                                                                                                                                                                                                            }
                                                                                                                                                                                               }
                                                                                                                                                                                            )
                                                                                                                                                
                                                                                                                                                        
                                                                                                                                                    }
                                                                                                                                                }
                                                                                                                                },
                                                                                                                    items:	[
                                                                                                                    
                                                                                                                                new Ext.ux.IFrameComponent({ 
                                                    
                                                                                                                                                                id: 'frameRegistroEscritos', 
                                                                                                                                                                anchor:'100% 100%',
                                                                                                                                                                loadFuncion:function(iFrame)
                                                                                                                                                                            {
                                                                                                                                                                                
                                                                                                                                                                                
                                                                                                                                                                               
                                                                                                                                                                                
                                                                                                                                                                            },
                                                                        
                                                                                                                                                                url: '../paginasFunciones/white.php',
                                                                                                                                                                style: 'width:100%;height:100%' 
                                                                                                                                                        })
                                                                                                                    
                                                                                                                    
                                                                                                                                
                                                                                                                                
                                                                                                                            ]
                                                                                                                }
                                                                                                            ]
                                                                                              },
                                                                                            crearGridPropiedadesProceso()  
                                                                                		]
                                                                            }
                                                                            
                                                                            
                                                                        ]
                                                            }
                                                			,
                                                            {
                                                                xtype:'panel',
                                                                title:'Registro de Procesos Judiciales',
                                                                listeners:	{
                                                                				activate:function(p)
                                                                                			{
                                                                                            	if(!p.visualizado)
                                                                                                {
                                                                                                	p.visualizado=1;
                                                                                                    gEx('frameRegistroProcesosV2').load	(
                                                                                                                                            {
                                                                                                                                                scripts:true,
                                                                                                                                                url:'../modeloProyectos/visorRegistrosProcesosV2.php',
                                                                                                                                                params:	{
                                                                                                                                                            cPagina: 'sFrm=true',
                                                                                                                                                            idProceso: 284,
                                                                                                                                                            pantallaCompleta:'1',
                                                                                                                                                            idFormulario: -1,
                                                                                                                                                            contentIframe:1
                                                                                                                                                        }
                                                                                                                                           }
                                                                                                                                        )
                                                                                            
                                                                                            		
                                                                                            	}
                                                                                            }
                                                                			},
                                                                items:	[
                                                                
                                                                			new Ext.ux.IFrameComponent({ 

                                                                                                            id: 'frameRegistroProcesosV2', 
                                                                                                            anchor:'100% 100%',
                                                                                                            loadFuncion:function(iFrame)
                                                                                                                        {
                                                                                                                            
                                                                                                                            
                                                                                                                           
                                                                                                                            
                                                                                                                        },
                    
                                                                                                            url: '../paginasFunciones/white.php',
                                                                                                            style: 'width:100%;height:100%' 
                                                                                                    })
                                                                
                                                                
                                                                			
                                                                			
                                                                		]
                                                            }
                                                            ,
                                                            {
                                                                xtype:'panel',
                                                                title:'Registro de Tutelas',
                                                                listeners:	{
                                                                				activate:function(p)
                                                                                			{
                                                                                            	if(!p.visualizado)
                                                                                                {
                                                                                                	p.visualizado=1;
                                                                                                    gEx('frameRegistroProcesosTutelas').load	(
                                                                                                                                            {
                                                                                                                                                scripts:true,
                                                                                                                                                url:'../modeloProyectos/visorRegistrosProcesosV2.php',
                                                                                                                                                params:	{
                                                                                                                                                            cPagina: 'sFrm=true',
                                                                                                                                                            idProceso: 296,
                                                                                                                                                            pantallaCompleta:'1',
                                                                                                                                                            idFormulario: -1,
                                                                                                                                                            contentIframe:1
                                                                                                                                                        }
                                                                                                                                           }
                                                                                                                                        )
                                                                                            
                                                                                            		
                                                                                            	}
                                                                                            }
                                                                			},
                                                                items:	[
                                                                
                                                                			new Ext.ux.IFrameComponent({ 

                                                                                                            id: 'frameRegistroProcesosTutelas', 
                                                                                                            anchor:'100% 100%',
                                                                                                            loadFuncion:function(iFrame)
                                                                                                                        {
                                                                                                                            
                                                                                                                            
                                                                                                                           
                                                                                                                            
                                                                                                                        },
                    
                                                                                                            url: '../paginasFunciones/white.php',
                                                                                                            style: 'width:100%;height:100%' 
                                                                                                    })
                                                                
                                                                
                                                                			
                                                                			
                                                                		]
                                                            } ,
                                                            {
                                                                xtype:'panel',
                                                                title:'Acci&oacute;n P&uacute;blica',
                                                                listeners:	{
                                                                				activate:function(p)
                                                                                			{
                                                                                            	if(!p.visualizado)
                                                                                                {
                                                                                                	p.visualizado=1;
                                                                                                    gEx('frameRegistroProcesosAccion').load	(
                                                                                                                                            {
                                                                                                                                                scripts:true,
                                                                                                                                                url:'../modeloProyectos/visorRegistrosProcesosV2.php',
                                                                                                                                                params:	{
                                                                                                                                                            cPagina: 'sFrm=true',
                                                                                                                                                            idProceso: 344,
                                                                                                                                                            pantallaCompleta:'1',
                                                                                                                                                            idFormulario: -1,
                                                                                                                                                            contentIframe:1
                                                                                                                                                        }
                                                                                                                                           }
                                                                                                                                        )
                                                                                            
                                                                                            		
                                                                                            	}
                                                                                            }
                                                                			},
                                                                items:	[
                                                                
                                                                			new Ext.ux.IFrameComponent({ 

                                                                                                            id: 'frameRegistroProcesosAccion', 
                                                                                                            anchor:'100% 100%',
                                                                                                            loadFuncion:function(iFrame)
                                                                                                                        {
                                                                                                                            
                                                                                                                            
                                                                                                                           
                                                                                                                            
                                                                                                                        },
                    
                                                                                                            url: '../paginasFunciones/white.php',
                                                                                                            style: 'width:100%;height:100%' 
                                                                                                    })
                                                                
                                                                
                                                                			
                                                                			
                                                                		]
                                                            },

                                                            {
                                                                xtype:'panel',
                                                                title:'Exequ&aacute;tur',
                                                                listeners:	{
                                                                				activate:function(p)
                                                                                			{
                                                                                            	if(!p.visualizado)
                                                                                                {
                                                                                                	p.visualizado=1;
                                                                                                    gEx('frameRegistroExecuatur').load	(
                                                                                                                                            {
                                                                                                                                                scripts:true,
                                                                                                                                                url:'../modeloProyectos/visorRegistrosProcesosV2.php',
                                                                                                                                                params:	{
                                                                                                                                                            cPagina: 'sFrm=true',
                                                                                                                                                            idProceso: 346,
                                                                                                                                                            pantallaCompleta:'1',
                                                                                                                                                            idFormulario: -1,
                                                                                                                                                            contentIframe:1
                                                                                                                                                        }
                                                                                                                                           }
                                                                                                                                        )
                                                                                            
                                                                                            		
                                                                                            	}
                                                                                            }
                                                                			},
                                                                items:	[
                                                                
                                                                			new Ext.ux.IFrameComponent({ 

                                                                                                            id: 'frameRegistroExecuatur', 
                                                                                                            anchor:'100% 100%',
                                                                                                            loadFuncion:function(iFrame)
                                                                                                                        {
                                                                                                                            
                                                                                                                            
                                                                                                                           
                                                                                                                            
                                                                                                                        },
                    
                                                                                                            url: '../paginasFunciones/white.php',
                                                                                                            style: 'width:100%;height:100%' 
                                                                                                    })
                                                                
                                                                
                                                                			
                                                                			
                                                                		]
                                                            },
                                                            {
                                                                xtype:'panel',
                                                                title:'Medio de Control del Nulidad',
                                                                listeners:	{
                                                                				activate:function(p)
                                                                                			{
                                                                                            	if(!p.visualizado)
                                                                                                {
                                                                                                	p.visualizado=1;
                                                                                                    gEx('frameRegistroControlNulidad').load	(
                                                                                                                                            {
                                                                                                                                                scripts:true,
                                                                                                                                                url:'../modeloProyectos/visorRegistrosProcesosV2.php',
                                                                                                                                                params:	{
                                                                                                                                                            cPagina: 'sFrm=true',
                                                                                                                                                            idProceso: 347,
                                                                                                                                                            pantallaCompleta:'1',
                                                                                                                                                            idFormulario: -1,
                                                                                                                                                            contentIframe:1
                                                                                                                                                        }
                                                                                                                                           }
                                                                                                                                        )
                                                                                            
                                                                                            		
                                                                                            	}
                                                                                            }
                                                                			},
                                                                items:	[
                                                                
                                                                			new Ext.ux.IFrameComponent({ 

                                                                                                            id: 'frameRegistroControlNulidad', 
                                                                                                            anchor:'100% 100%',
                                                                                                            loadFuncion:function(iFrame)
                                                                                                                        {
                                                                                                                            
                                                                                                                            
                                                                                                                           
                                                                                                                            
                                                                                                                        },
                    
                                                                                                            url: '../paginasFunciones/white.php',
                                                                                                            style: 'width:100%;height:100%' 
                                                                                                    })
                                                                
                                                                
                                                                			
                                                                			
                                                                		]
                                                            },
                                                            {
                                                                xtype:'panel',
                                                                title:'Suspensi&oacute;n/Cese de Trabajo',
                                                                listeners:	{
                                                                				activate:function(p)
                                                                                			{
                                                                                            	if(!p.visualizado)
                                                                                                {
                                                                                                	p.visualizado=1;
                                                                                                    gEx('frameRegistroSuspensionTrabajo').load	(
                                                                                                                                            {
                                                                                                                                                scripts:true,
                                                                                                                                                url:'../modeloProyectos/visorRegistrosProcesosV2.php',
                                                                                                                                                params:	{
                                                                                                                                                            cPagina: 'sFrm=true',
                                                                                                                                                            idProceso: 348,
                                                                                                                                                            pantallaCompleta:'1',
                                                                                                                                                            idFormulario: -1,
                                                                                                                                                            contentIframe:1
                                                                                                                                                        }
                                                                                                                                           }
                                                                                                                                        )
                                                                                            
                                                                                            		
                                                                                            	}
                                                                                            }
                                                                			},
                                                                items:	[
                                                                
                                                                			new Ext.ux.IFrameComponent({ 

                                                                                                            id: 'frameRegistroSuspensionTrabajo', 
                                                                                                            anchor:'100% 100%',
                                                                                                            loadFuncion:function(iFrame)
                                                                                                                        {
                                                                                                                            
                                                                                                                            
                                                                                                                           
                                                                                                                            
                                                                                                                        },
                    
                                                                                                            url: '../paginasFunciones/white.php',
                                                                                                            style: 'width:100%;height:100%' 
                                                                                                    })
                                                                
                                                                
                                                                			
                                                                			
                                                                		]
                                                            },
                                                            {
                                                                xtype:'panel',
                                                                title:'Casaci&oacute;n',
                                                                listeners:	{
                                                                				activate:function(p)
                                                                                			{
                                                                                            	if(!p.visualizado)
                                                                                                {
                                                                                                	p.visualizado=1;
                                                                                                    gEx('frameRegistroCasacion').load	(
                                                                                                                                            {
                                                                                                                                                scripts:true,
                                                                                                                                                url:'../modeloProyectos/visorRegistrosProcesosV2.php',
                                                                                                                                                params:	{
                                                                                                                                                            cPagina: 'sFrm=true',
                                                                                                                                                            idProceso: 277,
                                                                                                                                                            pantallaCompleta:'1',
                                                                                                                                                            idFormulario: -1,
                                                                                                                                                            contentIframe:1
                                                                                                                                                        }
                                                                                                                                           }
                                                                                                                                        )
                                                                                            
                                                                                            		
                                                                                            	}
                                                                                            }
                                                                			},
                                                                items:	[
                                                                
                                                                			new Ext.ux.IFrameComponent({ 

                                                                                                            id: 'frameRegistroCasacion', 
                                                                                                            anchor:'100% 100%',
                                                                                                            loadFuncion:function(iFrame)
                                                                                                                        {
                                                                                                                            
                                                                                                                            
                                                                                                                           
                                                                                                                            
                                                                                                                        },
                    
                                                                                                            url: '../paginasFunciones/white.php',
                                                                                                            style: 'width:100%;height:100%' 
                                                                                                    })
                                                                
                                                                
                                                                			
                                                                			
                                                                		]
                                                            }
                                                            ,
                                                            {
                                                                xtype:'panel',
                                                                title:'Recurso de Revisi&oacute;n',
                                                                listeners:	{
                                                                				activate:function(p)
                                                                                			{
                                                                                            	if(!p.visualizado)
                                                                                                {
                                                                                                	p.visualizado=1;
                                                                                                    gEx('frameRegistroProcesosRevision').load	(
                                                                                                                                            {
                                                                                                                                                scripts:true,
                                                                                                                                                url:'../modeloProyectos/visorRegistrosProcesosV2.php',
                                                                                                                                                params:	{
                                                                                                                                                            cPagina: 'sFrm=true',
                                                                                                                                                            idProceso: 362,
                                                                                                                                                            pantallaCompleta:'1',
                                                                                                                                                            idFormulario: -1,
                                                                                                                                                            contentIframe:1
                                                                                                                                                        }
                                                                                                                                           }
                                                                                                                                        )
                                                                                            
                                                                                            		
                                                                                            	}
                                                                                            }
                                                                			},
                                                                items:	[
                                                                
                                                                			new Ext.ux.IFrameComponent({ 

                                                                                                            id: 'frameRegistroProcesosRevision', 
                                                                                                            anchor:'100% 100%',
                                                                                                            loadFuncion:function(iFrame)
                                                                                                                        {
                                                                                                                            
                                                                                                                            
                                                                                                                           
                                                                                                                            
                                                                                                                        },
                    
                                                                                                            url: '../paginasFunciones/white.php',
                                                                                                            style: 'width:100%;height:100%' 
                                                                                                    })
                                                                
                                                                
                                                                			
                                                                			
                                                                		]
                                                            } 
                                                            
                                                        ]
                                            }
                                
                                
                                           
                                         ]
                            }
                        )   


	gEx('panelGrids').setActiveTab(0);
    gEx('panelGrids').hideTabStripItem('pActuaciones');
}


function crearArbolExpedientes()
{
	var raiz=new  Ext.tree.AsyncTreeNode(
											{
												id:'-1',
												text:'Raiz',
												draggable:false,
												expanded :false,
												cls:'-1'
											}
										)
										
	var cargadorArbol=new Ext.tree.TreeLoader(
                                                {
                                                    baseParams:{
                                                                    funcion:'8'
                                                                    
                                                                },
                                                    dataUrl:'../modulosEspeciales_SGJ/paginasFunciones/funcionesModulosEspeciales_SGJ.php'
                                                }
                                            )		
										
	cargadorArbol.on('beforeload',function(c)
    						{
                            	
                            	c.baseParams.anio=gEx('cmbAnio').getValue();
                                c.baseParams.noExpediente=gEx('txtNumeroExpediente').getValue();
                            	nodoExpedienteSel=null;
                                gE('lblExpediente').innerHTML='';
                                gE('lblNoExpediente').innerHTML='';
                                gEx('panelGrids').hideTabStripItem('pActuaciones');
                                
                            }
    				)	
    										
	cargadorArbol.on('load',function(c,nodoCarga)
    						{
                            	if(idNodoSeleccionado!=-1)
                                {
                                
                                    setTimeout(function()
                                                {
                                                    nodoSel=buscarNodoID(gEx('arbolExpedientes').getRootNode(),idNodoSeleccionado);
                                                    gEx('arbolExpedientes'). selectPath(nodoSel.getPath());
                                                    funcExpediente(nodoSel);
                                                   
                                                },500);
                                    
                                }
                            }
    				)										
	var arbolExpedientes=new Ext.tree.TreePanel	(
                                                            {
                                                                id:'arbolExpedientes',
                                                                useArrows:true,
                                                                animate:true,
                                                                enableDD:false,
                                                                ddScroll:true,
                                                                containerScroll: true,
                                                                autoScroll:true,
                                                                border:false,
                                                                region:'center',
                                                                root:raiz,
                                                                tbar:	[
                                                                			{
                                                                            	xtype:'label',
                                                                                html:'<b>N&uacute;mero de Proceso:</b>&nbsp;&nbsp;&nbsp;&nbsp;'
                                                                                
                                                                            },
                                                                            {
                                                                            	xtype:'textfield',
                                                                                width:140,
                                                                                enableKeyEvents:true,
                                                                                id:'txtNumeroExpediente',
                                                                                listeners:	{
                                                                                				keypress:function(txt,e)
                                                                                                	{
                                                                                                    	if(e.charCode=='13')
                                                                                                        {
                                                                                                        	if(txt.ultimaBusqueda!=txt.getValue())
                                                                                                            {
                                                                                                            	idNodoSeleccionado=-1;
                                                                                                            	gEx('arbolExpedientes').getRootNode().reload();
                                                                                                        		txt.ultimaBusqueda=txt.getValue();
                                                                                                            }
                                                                                                        }
                                                                                                    },
                                                                                                blur:function(txt)
                                                                                                	{
                                                                                                    	
                                                                                                    	if(txt.ultimaBusqueda!=txt.getValue())
                                                                                                        {
                                                                                                        	idNodoSeleccionado=-1;
                                                                                                        	gEx('arbolExpedientes').getRootNode().reload();
                                                                                                        	txt.ultimaBusqueda=txt.getValue();
                                                                                                        }
                                                                                                        
                                                                                                    }
                                                                                			}
                                                                            }
                                                                		],
                                                                loader: cargadorArbol,
                                                                rootVisible:false
                                                            }
                                                        )
         
         
                                                    
	arbolExpedientes.on('click',funcExpediente);
	return  arbolExpedientes;
}

function funcExpediente(nodo, evento)
{

	nodoExpedienteSel=nodo;

    if(nodoExpedienteSel.attributes.tipo=='3')
    {

        if(nodoExpedienteSel.attributes.accesoVideograbaciones==0)
        {
        	gEx('panelGrids').hideTabStripItem('gridAudiencias');
            gEx('panelGrids').setActiveTab(0);
        }
        else
        {
        	gEx('panelGrids').unhideTabStripItem('gridAudiencias');
            gEx('panelGrids').unhideTabStripItem('pActuaciones');
        
        }
        recargarGridAudiencias();
        recargarGridDocumentos();
        recargarGridEscritos();
        gEx('gMetaDataProceso').getStore().reload();
        gE('lblExpediente').innerHTML=' [Proceso Judicial: ';
        gE('lblNoExpediente').innerHTML=nodoExpedienteSel.attributes.expediente+', '+nodoExpedienteSel.parentNode.attributes.juzgado+'<span style="color:#000; font-weight:bold">]</span>';
    }
    else
    {

        
        gEx('gSeguimiento').getStore().removeAll();
        gEx('gridAudiencias').getStore().removeAll();
        gEx('gMetaDataProceso').getStore().removeAll();
        gE('lblExpediente').innerHTML='';
        gE('lblNoExpediente').innerHTML='';
    }
    
    
    
}

function recargarGridEscritos()
{
	if(gEx('frameRegistroEscritos'))
    {
        gEx('frameRegistroEscritos').load	(
                                                {
                                                    scripts:true,
                                                    url:'../modeloProyectos/visorRegistrosProcesosV2.php',
                                                    params:	{
                                                                cPagina: 'sFrm=true',
                                                                idProceso: 285,
                                                                pantallaCompleta:'1',
                                                                parametrosProceso:bE('{"cAdministrativa":"'+(nodoExpedienteSel?nodoExpedienteSel.attributes.expediente:-1)+'"}'),
                                                                idFormulario: -1,
                                                                actor:"'23_0'",
                                                                contentIframe:1
                                                            }
                                               }
                                            )
	
    	 
    
    }
    
    
   
}

function recargarGridDocumentos()
{
	gEx('gridCarpetaAdministrativa').getStore().load	(
    														{
                                                            	url:'../modulosEspeciales_SGJ/paginasFunciones/funcionesModulosEspeciales_SGJ.php',
                                                                params:	{
                                                                			cA:bE(nodoExpedienteSel.attributes.expediente)
                                                                		}
                                                            }
    													)
}

function crearArbolCarpetaAdministrativa()
{
	var cmbTipoDocumento=crearComboExt('cmbTipoDocumento',arrCategorias);
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idDocumento'},
		                                                {name: 'etapaProcesal'},
		                                                {name:'nomArchivoOriginal'},
		                                                {name: 'tamano'},
                                                        {name: 'fechaRegistro', type:'date', dateFormat:'Y-m-d'},
                                                        {name: 'fechaCreacion', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name: 'descripcion'},
                                                        {name:'idFormulario'},
                                                        {name:'idRegistro'},
                                                        {name:'idDocumento'},
                                                        {name: 'categoriaDocumentos'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../modulosEspeciales_SGJ/paginasFunciones/funcionesModulosEspeciales_SGJ.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'fechaRegistro', direction: 'ASC'},
                                                            groupField: 'fechaRegistro',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:false
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='29';
                                        proxy.baseParams.idCarpetaAdministrativa=-1;
                                    }
                        )   
       
    
    
    var filters = new Ext.ux.grid.GridFilters	(
    												{
                                                    	filters:	[ 
                                                        				{type: 'date', dataIndex: 'fechaCreacion'},
                                                                        {type: 'string', dataIndex: 'nomArchivoOriginal'},
                                                                        {type: 'list', dataIndex: 'categoriaDocumentos', phpMode:true, options:arrCategorias}
                                                                    ]
                                                    }
                                                );    
       
	var expander = new Ext.ux.grid.RowExpander({
                                                column:2,
                                                expandOnDblClick:false,
                                                tpl : new Ext.Template(
                                                    '<table >'+
                                                    '<tr><td ><span class="TSJDF_Control">{descripcion}</span><br /><br /></td></tr>'+
                                                    '</table>'
                                                )
                                            });        

	var chkRow=new Ext.grid.CheckboxSelectionModel({singleSelect:true});       
    var cModelo= new Ext.grid.ColumnModel   	(
                                                    [
                                                    	new  Ext.grid.RowNumberer({width:30}),
                                                        chkRow,
                                                        expander,
                                                        {
                                                            header:'ID Documento',
                                                            width:100,
                                                            hidden:true,
                                                            sortable:true,
                                                            dataIndex:'idDocumento'
                                                        },
                                                        {
                                                            header:'',
                                                            width:30,
                                                            sortable:true,
                                                            dataIndex:'idDocumento',
                                                            renderer:function(val,meta,registro)
                                                            		{
                                                                    	
                                                                    	var arrNombre=registro.data.nomArchivoOriginal.split('.');
                                                                        return '<img src="../imagenesDocumentos/16/file_extension_'+arrNombre[1].toLowerCase()+'.png" />'
                                                                    }
                                                        },
                                                        
                                                        {
                                                            header:'Fecha de registro',
                                                            width:120,
                                                            sortable:true,
                                                            dataIndex:'fechaCreacion',
                                                            renderer:function(val)
                                                            		{
                                                                    	if(val)
                                                                    		return val.format('d/m/Y H:i');
                                                                    }
                                                        },{
                                                            header:'Tipo documento',
                                                            width:150,
                                                            sortable:true,
                                                            dataIndex:'categoriaDocumentos',
                                                            editor:cmbTipoDocumento,
                                                            renderer:function(val)
                                                            		{
                                                                    	return formatearValorRenderer(arrCategorias,val);
                                                                    }
                                                        },
                                                        
                                                        {
                                                            header:'Documento',
                                                            width:350,
                                                            sortable:true,
                                                            dataIndex:'nomArchivoOriginal',
                                                            renderer:mostrarValorDescripcion
                                                        },
                                                        
                                                        {
                                                            header:'Tama&ntilde;o',
                                                            width:100,
                                                            sortable:true,
                                                            dataIndex:'tamano',
                                                            renderer:function(val,meta,registro)
                                                            		{
                                                                    	
                                                                    	return bytesToSize(parseInt(val),0);
                                                                    }
                                                        },
                                                       
                                                        {
                                                            header:'',
                                                            width:30,
                                                            sortable:true,
                                                            dataIndex:'idDocumento',
                                                            renderer:function(val,meta,registro)
                                                            		{
                                                                    	
                                                                        if(parseFloat(registro.data.idFormulario)>0)
	                                                                       	return '<a href="javascript:abrirProcesoOrigen(\''+bE(registro.data.idFormulario)+'\',\''+bE(registro.data.idRegistro)+'\')"><img src="../images/magnifier.png" title="Abrir proceso origen" alt="Abrir proceso origen" /></a>';
                                                                    }
                                                        }
                                                        
                                                    ]
                                                );
                                                
    var tblGrid=	new Ext.grid.GridPanel	(
                                                        {
                                                            id:'gridCarpetaAdministrativa',
                                                            title:'Documentos del Proceso',
                                                            store:alDatos,
                                                            region:'center',
                                                            frame:false,
                                                            clicksToEdit:1,
                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            columnLines : true,  
                                                            sm:chkRow,
                                                            tbar:	[
                                                            			{
                                                                              icon:'../images/magnifier.png',
                                                                              cls:'x-btn-text-icon',
                                                                              width:25,
                                                                              text:'B&uacute;squeda de Documentos Avanzada',
                                                                              handler:function()
                                                                                      {
                                                                                          mostrarBusquedaDocumentosProcesoJudicial();
                                                                                      }
                                                                              
                                                                          },
                                                            		],
                                                            plugins:[expander,filters],
                                                                                                              
                                                            view:new Ext.grid.GroupingView({
                                                                                                forceFit:false,
                                                                                                showGroupName: false,
                                                                                                enableGrouping :false,
                                                                                                enableNoGroups:false,
                                                                                                enableGroupingMenu:false,
                                                                                                hideGroupedColumn: true,
                                                                                                startCollapsed:false,
                                                                                                groupTextTpl:'<span style="color:#900"><b>{text}</b> ({[values.rs.length]} {[values.rs.length > 1 ? "Documentos" : "Documento"]})</span>'
                                                                                            })
                                                        }
                                                    );
                                                    
	
    
    
    
    tblGrid.on('rowdblclick',function(grid,rowIndex)
                              {
                              		
                              		var registro=grid.getStore().getAt(rowIndex);
                                    var arrNombre=registro.data.nomArchivoOriginal.split('.');
                                  	mostrarVisorDocumentoProcesoIndice(arrNombre[1].toLowerCase(),registro.data.idDocumento,registro);
                                  
                              }
                  )                                                    
                                                    
    return 	tblGrid;	
}

function mostrarVisorDocumentoProcesoIndice(extension,idDocumento,registro,nombreArchivo,cA)
{
	var obj={};
    obj.url='../visoresGaleriaDocumentos/visorDocumentosGeneralIndice.php';
    obj.ancho='100%';
    obj.alto='100%';
    

     
    obj.params=	[['iD',bE('iD_'+idDocumento)],['cPagina','sFrm=true'],['idCarpeta','-1'],
    			['carpetaJudicial',cA?cA:bE(nodoExpedienteSel.attributes.expediente)]];
    if(extension!='')
    	obj.params.push(['extension',extension]);
    if(nombreArchivo)
    	obj.params.push(['nombreArchivo',nombreArchivo]);
    window.parent.abrirVentanaFancy(obj);
	
}

function obtenerVersionCompletaDocumentos(iDocumento)
{
	
	
    var arrParametros=[['iDocumento',iDocumento]]
    enviarFormularioDatos('../modulosEspeciales_SICORE/obtenerDocumentoCompletoImpresion.php',arrParametros,'POST','frameDTD');
    primeraCargaFrame=false;
    
}

function frameLoad(iFrame)
{
	if(!primeraCargaFrame)
    {
    	setTimeout(function()
        			{
                       
                        iFrame.contentWindow.print();
                    },2000
                   );

    }
    else
    	primeraCargaFrame=false;
	
}

function crearGridEventos()
{
	 var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name: 'idEvento'},
                                                        {name: 'carpetaAdministrativa'},
		                                                {name: 'fechaEvento', type:'date', dateFormat:'Y-m-d'},
		                                                {name: 'horaInicial', type:'date', dateFormat:'Y-m-d H:i:s'},
		                                               	{name: 'horaFinal', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name: 'horaInicioReal', type:'date', dateFormat:'Y-m-d H:i:s'},
		                                               	{name: 'horaTerminoReal', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name: 'urlMultimedia'},
                                                        {name: 'tipoAudiencia'},
                                                        {name: 'sala'},
                                                        {name: 'unidadGestion'},
                                                        {name: 'situacion'},
                                                        {name: 'juez'}  ,
                                                        {name: 'edificio'},
                                                        {name: 'comentariosAdicionales'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                reader: lector,
                                                proxy : new Ext.data.HttpProxy	(

                                                                                  {

                                                                                      url: '../modulosEspeciales_SGJ/paginasFunciones/funcionesModulosEspeciales_SGJ.php'

                                                                                  }

                                                                              ),
                                                sortInfo: {field: 'fechaEvento', direction: 'ASC'},
                                                groupField: 'fechaEvento',
                                                remoteGroup:false,
                                                remoteSort: false,
                                                autoLoad:false
                                                
                                            }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='28';
                                    }
                        )   
       
       
       
       
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer({width:40}),
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
                                                                            if(registro.data.comentariosAdicionales!='')
                                                                            {
                                                                            	comp='&nbsp;&nbsp;<img src="../images/icon_comment.gif" title="'+cv(registro.data.comentariosAdicionales,true,true)+'" alt="'+cv(registro.data.comentariosAdicionales,true,true)+'" />';
                                                                            }
                                                                            return mostrarValorDescripcion(formatearValorRenderer(arrSituacionEvento,val))+comp;
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
                                                                            	case '2':
                                                                                	if(registro.data.urlMultimedia!='')
                                                                                		comp2='<a href="javascript:abrirVideoGrabacion(\''+bE(registro.data.idEvento)+'\')"><img src="../images/control_play_blue.png" title="Visualizar grabaci&oacute;n" alt="Visualizar grabaci&oacute;n" /></a>'
                                                                              	break;
                                                                            }
                                                                        	return comp2;
                                                                        	
                                                                        }
                                                            },
                                                            {
                                                                header:'Expediente',
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
                                                                dataIndex:'horaInicioReal',
                                                                renderer:function(val,meta,registro)
                                                                	{

                                                                    	if(!val)
                                                                        {
                                                                        	return '(Datos no disponibles)';
                                                                        }
                                                                    	var comp='';
                                                                        if(val.format('d')!=registro.data.horaTerminoReal.format('d'))
                                                                        {
                                                                        	comp=' del '+registro.data.horaTerminoReal.format('d/m/Y');
                                                                        }

                                                                    	return 'De las '+val.format('H:i')+' hrs. a las '+registro.data.horaTerminoReal.format('H:i')+' hrs.'+comp
                                                                    }
                                                            },
                                                            {
                                                                header:'Tipo de audiencia',
                                                                width:350,
                                                                sortable:true,
                                                                dataIndex:'tipoAudiencia',
                                                                renderer:function(val)
                                                                		{
                                                                        
                                                                        	return mostrarValorDescripcion(val);
                                                                        }
                                                            },
                                                            {
                                                                header:'Edificio',
                                                                width:250,
                                                                sortable:true,
                                                                dataIndex:'edificio',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	var lblSala=mostrarValorDescripcion(val);
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
                                                                        	return mostrarValorDescripcion(val);
                                                                        }
                                                            },
                                                            {
                                                                header:'Juez',
                                                                width:320,
                                                                sortable:true,
                                                                dataIndex:'juez'
                                                            }
                                                            
                                                           
                                                            
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gridAudiencias',
                                                                store:alDatos,
                                                                region:'center',
                                                                title:'Audiencias',
                                                                frame:false,
                                                                cm: cModelo,
                                                                stripeRows :false,
                                                                loadMask:true,
                                                                columnLines : true,      
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

function recargarGridAudiencias()
{
	gEx('gridAudiencias').getStore().load	(
                                                {
                                                    url:'../modulosEspeciales_SGJ/paginasFunciones/funcionesModulosEspeciales_SGJ.php',
                                                    params:	{
                                                                funcion:'28',
                                                                exp:nodoExpedienteSel.attributes.expediente
                                                            }
                                                }
                                            );
}

function abrirVideoGrabacion(idEventoAudiencia)
{
	var obj={};    
    obj.ancho='100%';
    obj.alto='100%';
    obj.url='../modulosEspeciales_SGJP/visorGrabacionAudiencia.php';
    obj.params=[['idEvento',idEventoAudiencia],['cPagina','sFrm=true']]
    window.parent.abrirVentanaFancy(obj);
}

function abrirProcesoOrigen(iF,iR)
{
	var obj={};
    obj.ancho='100%';
    obj.alto='100%';
    obj.url='../modeloPerfiles/vistaDTDv3.php';
    obj.params=[['idFormulario',bD(iF)],['idRegistro',bD(iR)],['actor',bE(0)],['dComp',bE('auto')]];
    window.parent.abrirVentanaFancy(obj);
    
    
}

function abrirProcesoBusqueda(iF,iR)
{
	var obj={};
    obj.ancho='100%';
    obj.alto='100%';
    obj.url='../modeloPerfiles/vistaDTDv3.php';
    obj.params=[['idFormulario',bD(iF)],['idRegistro',bD(iR)],['actor',bE(0)],['dComp',bE('auto')]];
    window.parent.abrirVentanaFancy(obj);
    
    
}


function recargarContenedorCentral()
{

	if((gE('iframe-frameRegistroProcesosV2'))&&(gEx('frameRegistroProcesosV2').getFrameWindow) &&(gEx('frameRegistroProcesosV2').getFrameWindow().recargarContenedorCentral))
		gEx('frameRegistroProcesosV2').getFrameWindow().recargarContenedorCentral();
    if((gE('iframe-frameRegistroEscritos'))&&(gEx('frameRegistroEscritos').getFrameWindow)&&(gEx('frameRegistroEscritos').getFrameWindow().recargarContenedorCentral))
    	gEx('frameRegistroEscritos').getFrameWindow().recargarContenedorCentral();
        
	if((gE('iframe-frameRegistroProcesosTutelas'))&&(gEx('frameRegistroProcesosTutelas').getFrameWindow) &&(gEx('frameRegistroProcesosTutelas').getFrameWindow().recargarContenedorCentral))
		gEx('frameRegistroProcesosTutelas').getFrameWindow().recargarContenedorCentral();
    
    if((gE('iframe-frameRegistroProcesosAccion'))&&(gEx('frameRegistroProcesosAccion').getFrameWindow) &&(gEx('frameRegistroProcesosAccion').getFrameWindow().recargarContenedorCentral))
		gEx('frameRegistroProcesosAccion').getFrameWindow().recargarContenedorCentral();
        
    if((gE('iframe-frameRegistroExecuatur'))&&(gEx('frameRegistroExecuatur').getFrameWindow) &&(gEx('frameRegistroExecuatur').getFrameWindow().recargarContenedorCentral))
		gEx('frameRegistroExecuatur').getFrameWindow().recargarContenedorCentral();        
     
    
    if((gE('iframe-frameRegistroControlNulidad'))&&(gEx('frameRegistroControlNulidad').getFrameWindow) &&(gEx('frameRegistroControlNulidad').getFrameWindow().recargarContenedorCentral))
		gEx('frameRegistroControlNulidad').getFrameWindow().recargarContenedorCentral();    
      
    if((gE('iframe-frameRegistroSuspensionTrabajo'))&&(gEx('frameRegistroSuspensionTrabajo').getFrameWindow) &&(gEx('frameRegistroSuspensionTrabajo').getFrameWindow().recargarContenedorCentral))
		gEx('frameRegistroSuspensionTrabajo').getFrameWindow().recargarContenedorCentral();        
	        

	 if((gE('iframe-frameRegistroProcesosRevision'))&&(gEx('frameRegistroProcesosRevision').getFrameWindow) &&(gEx('frameRegistroProcesosRevision').getFrameWindow().recargarContenedorCentral))
		gEx('frameRegistroProcesosRevision').getFrameWindow().recargarContenedorCentral();    
        
    gEx('arbolExpedientes').getRootNode().reload();
}

function mostrarBusquedaProcesoJudicial()
{
	var arrFiltroFecha=[['>=','>='],['>','>'],['=','='],['<','<'],['<=','<=']];
	var cmbDespachos=crearComboExt('cmbDespachos',arrDespachos,130,5,300);
    var cmbEspecialidad=crearComboExt('cmbEspecialidad',arrEspecialidades,540,5,300);
    cmbEspecialidad.on('select',function(cmb,registro)
    							{
                                	gEx('cmbTipoProceso').setValue('');
                                	gEx('cmbTipoProceso').getStore().loadData(registro.data.valorComp);
                                }
    					)
    var cmbTipoProceso=crearComboExt('cmbTipoProceso',[],130,35,300);
    var cmbEstadoProceso=crearComboExt('cmbEstadoProceso',arrEstadoProceso,590,35,250);
    var cmbInicioFiltro=crearComboExt('cmbInicioFiltro',arrFiltroFecha,130,65,90);
    var cmbFinFiltro=crearComboExt('cmbFinFiltro',arrFiltroFecha,380,65,90);
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            html:'Despacho:'
                                                        },
                                                        cmbDespachos,
                                                        {
                                                        	x:460,
                                                            y:10,
                                                            html:'Especialidad:'
                                                        },
                                                        cmbEspecialidad,
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            html:'Tipo de Proceso:'
                                                        },
                                                        
                                                        cmbTipoProceso,
                                                        {
                                                        	x:460,
                                                            y:40,
                                                            html:'Estado del Proceso:'
                                                        },
                                                        cmbEstadoProceso,
                                                        {
                                                        	x:10,
                                                            y:70,
                                                            html:'Fecha de Registro:'
                                                        },
                                                        cmbInicioFiltro,
                                                        {
                                                        	x:230,
                                                            y:65,
                                                            xtype:'datefield',
                                                            id:'fInicioFiltro'
                                                        },
                                                        {
                                                        	x:360,
                                                            y:70,
                                                            html:'Y'
                                                        },
                                                        cmbFinFiltro,
                                                         {
                                                        	x:480,
                                                            y:65,
                                                            xtype:'datefield',
                                                            id:'fFinFiltro'
                                                        },
                                                        {
                                                        	x:610,
                                                            y:65,
                                                            xtype:'button',
                                                            icon:'../images/magnifier.png',
                                                            cls:'x-btn-text-icon',
                                                            text:'Buscar',
                                                            handler:function()
                                                                    {
                                                                    	if((gEx('fInicioFiltro').getValue()!='')&&(cmbInicioFiltro.getValue()==''))
                                                                        {
                                                                        	function resp1()
                                                                            {
                                                                            	cmbInicioFiltro.focus();
                                                                            }
                                                                            msgBox('Debe seleccionar la condici&oacute;n de b&uacute;squeda por fecha',resp1);
                                                                            return;
                                                                        }
                                                                        
                                                                        if((gEx('fFinFiltro').getValue()!='')&&(cmbFinFiltro.getValue()==''))
                                                                        {
                                                                        	function resp2()
                                                                            {
                                                                            	cmbFinFiltro.focus();
                                                                            }
                                                                            msgBox('Debe seleccionar la condici&oacute;n de b&uacute;squeda por fecha',resp2);
                                                                            return;
                                                                        }
                                                                    
                                                                        var cadObj='{"depacho":"'+cmbDespachos.getValue()+'","especialidad":"'+cmbEspecialidad.getValue()+
                                                                        '","tipoProceso":"'+cmbTipoProceso.getValue()+'","estadoProceso":"'+cmbEstadoProceso.getValue()+
                                                                        '","fechaInicioRegistro":"'+(gEx('fInicioFiltro').getValue()?gEx('fInicioFiltro').getValue().format('Y-m-d'):'')+
                                                                        '","fechaFinRegistro":"'+(gEx('fFinFiltro').getValue()?gEx('fFinFiltro').getValue().format('Y-m-d'):'')+
                                                                        '","condFInicioFiltro":"'+cmbInicioFiltro.getValue()+'","condFFinFiltro":"'+cmbFinFiltro.getValue()+'"}';
																	
                                                                    
                                                                    	gEx('gResultadoBusqueda').getStore().load	(
                                                                        												{
                                                                                                                            url:'../modulosEspeciales_SGJ/paginasFunciones/funcionesModulosEspeciales_SGJ.php',
                                                                                                                            params:	{
                                                                                                                                        criterioBusqueda:cadObj
                                                                                                                                    }
                                                                                                                         }

                                                                        											)
                                                                    }
                                                            
                                                        },
                                                        {
                                                        	x:675,
                                                            y:65,
                                                            xtype:'button',
                                                            icon:'../images/find_remove.png',
                                                            cls:'x-btn-text-icon',
                                                            text:'Limpiar Filtros',
                                                            handler:function()
                                                                    {
                                                                        cmbDespachos.setValue('');
                                                                        cmbEspecialidad.setValue('');
                                                                        cmbTipoProceso.setValue('');
                                                                        cmbEstadoProceso.setValue('');
                                                                        cmbInicioFiltro.setValue('');
                                                                        gEx('fInicioFiltro').setValue('');
                                                                        cmbFinFiltro.setValue('');
                                                                        gEx('fFinFiltro').setValue('');
                                                                        var cadObj='{"depacho":"'+cmbDespachos.getValue()+'","especialidad":"'+cmbEspecialidad.getValue()+
                                                                        '","tipoProceso":"'+cmbTipoProceso.getValue()+'","estadoProceso":"'+cmbEstadoProceso.getValue()+
                                                                        '","fechaInicioRegistro":"'+(gEx('fInicioFiltro').getValue()?gEx('fInicioFiltro').getValue().format('Y-m-d'):'')+
                                                                        '","fechaFinRegistro":"'+(gEx('fFinFiltro').getValue()?gEx('fFinFiltro').getValue().format('Y-m-d'):'')+
                                                                        '","condFInicioFiltro":"'+cmbInicioFiltro.getValue()+'","condFFinFiltro":"'+cmbFinFiltro.getValue()+'"}';
																	
                                                                    
                                                                    	gEx('gResultadoBusqueda').getStore().load	(
                                                                        												{
                                                                                                                            url:'../modulosEspeciales_SGJ/paginasFunciones/funcionesModulosEspeciales_SGJ.php',
                                                                                                                            params:	{
                                                                                                                                        criterioBusqueda:cadObj
                                                                                                                                    }
                                                                                                                         }

                                                                        											)
                                                                    }
                                                            
                                                        },
                                                        crearGridResultadoProcesos()
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
                                    	id:'vBusquedaProcesos',
										title: 'B&uacute;squeda de Procesos Avanzada',
										width: 880,
										height:425,
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

function crearGridResultadoProcesos()
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idRegistro'},
                                                        {name:'idFormulario'},
                                                        {name:'idCarpeta'},
		                                                {name: 'folioRegistro'},
                                                        {name: 'tipoCarpeta'},
		                                                {name:'fechaRegistro', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name: 'codigoUnicoProceso'},
                                                        {name: 'tituloProceso'},
                                                        {name: 'tipoProceso'},
                                                        {name: 'especialidad'},
                                                        {name:'departamento'},
                                                        {name:'despacho'},
                                                        {name: 'estadoProceso'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../modulosEspeciales_SGJ/paginasFunciones/funcionesModulosEspeciales_SGJ.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'fechaRegistro', direction: 'ASC'},
                                                            groupField: 'fechaRegistro',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:false
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='10';
                                        
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer(),
                                                            {
                                                                header:'Folio de Registro',
                                                                width:110,
                                                                sortable:true,
                                                                dataIndex:'folioRegistro',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	return '<a href="javascript:abrirProcesoBusqueda(\''+bE(registro.data.idFormulario)+'\',\''+bE(registro.data.idRegistro)+'\')">'+val+'</a>';
                                                                        }
                                                            },
                                                            {
                                                                header:'Fecha de Registro',
                                                                width:140,
                                                                sortable:true,
                                                                dataIndex:'fechaRegistro',
                                                                renderer:function(val)
                                                                			{
                                                                            	return val.format('d/m/Y H:i')+' hrs.';
                                                                            }
                                                            },
                                                            {
                                                                header:'C&oacute;digo &Uacute;nico de Proceso',
                                                                width:170,
                                                                sortable:true,
                                                                dataIndex:'codigoUnicoProceso',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	return '<a href="javascript:setBusquedaCodigo(\''+bE(val)+'\',\''+bE(registro.data.idCarpeta)+'\')">'+val+'</a>';
                                                                        }
                                                            },
                                                            {
                                                                header:'Tipo de Expediente',
                                                                width:220,
                                                                sortable:true,
                                                                dataIndex:'tipoCarpeta',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	return formatearValorRenderer(arrTipoCarpeta,val);
                                                                        }
                                                            },
                                                            {
                                                                header:'T&iacute;tulo del Proceso',
                                                                width:400,
                                                                sortable:true,
                                                                dataIndex:'tituloProceso'
                                                            },
                                                            
                                                            {
                                                                header:'Tipo de Proceso',
                                                                width:160,
                                                                sortable:true,
                                                                dataIndex:'tipoProceso',
                                                                renderer:function(val)
                                                                			{
                                                                            	return formatearValorRenderer(arrTiposProcesoGlobal,val);
                                                                            }
                                                            },
                                                            {
                                                                header:'Especialidad',
                                                                width:160,
                                                                sortable:true,
                                                                dataIndex:'especialidad',
                                                                renderer:function(val)
                                                                			{
                                                                            	return formatearValorRenderer(arrEspecialidades,val);
                                                                            }
                                                            },
                                                            {
                                                                header:'Departamento',
                                                                width:160,
                                                                sortable:true,
                                                                dataIndex:'departamento',
                                                                renderer:function(val)
                                                                			{
                                                                            	return formatearValorRenderer(arrEstados,val);
                                                                            }
                                                            },
                                                            
                                                            {
                                                                header:'Despacho',
                                                                width:350,
                                                                sortable:true,
                                                                dataIndex:'despacho',
                                                                renderer:function(val)
                                                                			{
                                                                            	return formatearValorRenderer(arrDespachos,val);
                                                                            }
                                                            },
                                                            
                                                            {
                                                                header:'Estado del Proceso',
                                                                width:200,
                                                                sortable:true,
                                                                dataIndex:'estadoProceso',
                                                                renderer:function(val)
                                                                			{
                                                                            	return formatearValorRenderer(arrEstadoProcesoGlobal,val);
                                                                            }
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gResultadoBusqueda',
                                                                store:alDatos,
                                                                x:10,
                                                                y:100,
                                                                height:240,
                                                                frame:false,
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
                                                                                                    hideGroupedColumn: false,
                                                                                                    startCollapsed:false
                                                                                                })
                                                            }
                                                        );
        return 	tblGrid;
}

function setBusquedaCodigo(cU,iE)
{
	gEx('txtNumeroExpediente').setValue(bD(cU));
    gEx('cmbAnio').setValue('0');
    idNodoSeleccionado='e_'+bD(iE);
    
    gEx('arbolExpedientes').getRootNode().reload();
    gEx('vBusquedaProcesos').close();
}

function mostrarBusquedaDocumentosProcesoJudicial()
{
	var arrFormatosDocumento=[['pdf','Documentos PDF'],['doc,docx','Documentos de Word'],['jpg,jpeg,gif,bpm,png','Documentos de Imagen'],['wav,mp3','Documentos de Audio'],['mp4,avi,mov,3gp,wav','Documentos de Video']];
	var arrCondicionDocumento=[['1','Inicia con'],['2','Contiene'],['2','Termina con']];
    var arrCondicionDocumentoCuerpo=[['2','Contiene']];
	var arrFiltroFecha=[['>=','>='],['>','>'],['=','='],['<','<'],['<=','<=']];
	var cmbDespachos=crearComboExt('cmbDespachos',arrDespachos,130,5,300);
    var cmbEspecialidad=crearComboExt('cmbEspecialidad',arrEspecialidades,540,5,300);
    cmbEspecialidad.on('select',function(cmb,registro)
    							{
                                	gEx('cmbTipoProceso').setValue('');
                                	gEx('cmbTipoProceso').getStore().loadData(registro.data.valorComp);
                                }
    					)
    var cmbTipoProceso=crearComboExt('cmbTipoProceso',[],130,35,300);
    var cmbEstadoProceso=crearComboExt('cmbEstadoProceso',arrEstadoProceso,590,35,250);
    var cmbInicioFiltro=crearComboExt('cmbInicioFiltro',arrFiltroFecha,130,65,90);
    var cmbFinFiltro=crearComboExt('cmbFinFiltro',arrFiltroFecha,380,65,90);
    
    var cmbInicioFiltroDocumento=crearComboExt('cmbInicioFiltro',arrFiltroFecha,130,95,90);
    var cmbFinFiltroDocumento=crearComboExt('cmbFinFiltro',arrFiltroFecha,380,95,90);
    
    var cmbCondicionDocumento=crearComboExt('cmbCondicionDocumento',arrCondicionDocumento,180,5,110);
    cmbCondicionDocumento.setValue('2');
    
    var cmbCondicionCuerpoDocumento=crearComboExt('cmbCondicionCuerpoDocumento',arrCondicionDocumentoCuerpo,180,65,110);
    cmbCondicionCuerpoDocumento.setValue('2');
    
    var cmbCategoriaDocumentoFiltro=crearComboExt('cmbCategoriaDocumentoFiltro',arrCategorias,180,35,250);
    var cmbFormatoDocumento=crearComboExt('cmbFormatoDocumento',arrFormatosDocumento,580,5,250);
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	xtype:'tabpanel',
                                                            x:0,
                                                            y:0,
                                                            id:'tblFiltros',
                                                            buttonAlign:'right',
                                                            width:850,
                                                            height:190,
                                                            activeTab:0,
                                                            bbar:	new Ext.Toolbar(
                                                            							{
                                                                                        	buttonAlign:'right',
                                                                                        	items:	
                                                            
                                                            
                                                                                                    [
                                                                                                                {
                                                                                                                    xtype:'button',
                                                                                                                    icon:'../images/magnifier.png',
                                                                                                                    cls:'x-btn-text-icon',
                                                                                                                    text:'Buscar',
                                                                                                                    handler:function()
                                                                                                                            {
                                                                                                                                if((gEx('fInicioFiltro').getValue()!='')&&(cmbInicioFiltro.getValue()==''))
                                                                                                                                {
                                                                                                                                    function resp1()
                                                                                                                                    {
                                                                                                                                    	gEx('tblFiltros').setActiveTab(1);
                                                                                                                                        cmbInicioFiltro.focus();
                                                                                                                                    }
                                                                                                                                    msgBox('Debe seleccionar la condici&oacute;n de b&uacute;squeda por fecha',resp1);
                                                                                                                                    return;
                                                                                                                                }
                                                                                                                                
                                                                                                                                if((gEx('fFinFiltro').getValue()!='')&&(cmbFinFiltro.getValue()==''))
                                                                                                                                {
                                                                                                                                    function resp2()
                                                                                                                                    {
                                                                                                                                    	gEx('tblFiltros').setActiveTab(1);
                                                                                                                                        cmbFinFiltro.focus();
                                                                                                                                    }
                                                                                                                                    msgBox('Debe seleccionar la condici&oacute;n de b&uacute;squeda por fecha',resp2);
                                                                                                                                    return;
                                                                                                                                }
                                                                                                                                
                                                                                                                                 if((gEx('fInicioFiltroDocumento').getValue()!='')&&(cmbInicioFiltroDocumento.getValue()==''))
                                                                                                                                {
                                                                                                                                    function resp10()
                                                                                                                                    {
                                                                                                                                    	gEx('tblFiltros').setActiveTab(0);
                                                                                                                                        cmbInicioFiltroDocumento.focus();
                                                                                                                                    }
                                                                                                                                    msgBox('Debe seleccionar la condici&oacute;n de b&uacute;squeda por fecha',resp10);
                                                                                                                                    return;
                                                                                                                                }
                                                                                                                                
                                                                                                                                if((gEx('fFinFiltroDocumento').getValue()!='')&&(cmbFinFiltroDocumento.getValue()==''))
                                                                                                                                {
                                                                                                                                    function resp20()
                                                                                                                                    {
                                                                                                                                    	gEx('fFinFiltroDocumento').setActiveTab(0);
                                                                                                                                        cmbFinFiltroDocumento.focus();
                                                                                                                                    }
                                                                                                                                    msgBox('Debe seleccionar la condici&oacute;n de b&uacute;squeda por fecha',resp20);
                                                                                                                                    return;
                                                                                                                                }
                                                                                                                            
                                                                                                                                var objProceso='{"depacho":"'+cmbDespachos.getValue()+'","especialidad":"'+cmbEspecialidad.getValue()+
                                                                                                                                                '","tipoProceso":"'+cmbTipoProceso.getValue()+'","estadoProceso":"'+cmbEstadoProceso.getValue()+
                                                                                                                                                '","fechaInicioRegistro":"'+(gEx('fInicioFiltro').getValue()?gEx('fInicioFiltro').getValue().format('Y-m-d'):'')+
                                                                                                                                                '","fechaFinRegistro":"'+(gEx('fFinFiltro').getValue()?gEx('fFinFiltro').getValue().format('Y-m-d'):'')+
                                                                                                                                                '","condFInicioFiltro":"'+cmbInicioFiltro.getValue()+'","condFFinFiltro":"'+cmbFinFiltro.getValue()+'"}';
                                                                                                                            
                                                                                                                            
                                                                                                                            
                                                                                                                            	var objDocumento='{"nombreDocumento":"'+cv(gEx('txtNombreDocumento').getValue())+'","condNombreDocumento":"'+cmbCondicionDocumento.getValue()+
                                                                                                                                                '","cuerpoDocumento":"'+cv(gEx('txtCuerpoDocumento').getValue())+'","condCuerpoDocumento":"'+
                                                                                                                                                cmbCondicionCuerpoDocumento.getValue()+'","formato":"'+cmbFormatoDocumento.getValue()+'","categoriaDocumento":"'+cmbCategoriaDocumentoFiltro.getValue()+
                                                                                                                                                '","fechaInicioRegistro":"'+(gEx('fInicioFiltroDocumento').getValue()?gEx('fInicioFiltroDocumento').getValue().format('Y-m-d'):'')+
                                                                                                                                                '","fechaFinRegistro":"'+(gEx('fFinFiltroDocumento').getValue()?gEx('fFinFiltroDocumento').getValue().format('Y-m-d'):'')+
                                                                                                                                                '","condFInicioFiltro":"'+cmbInicioFiltroDocumento.getValue()+'","condFFinFiltro":"'+cmbFinFiltroDocumento.getValue()+
                                                                                                                                                '","registradoPor":"'+(gEx('txtRegistradoPor').getValue())+'"}';
                                                                                                                            	
                                                                                                                                
                                                                                                                                var cadObj='{"objProceso":'+objProceso+',"objDocumento":'+objDocumento+'}';
                                                                                                                                
                                                                                                                                gEx('gResultadoBusquedaDocumento').getStore().load	(
                                                                                                                                                                                {
                                                                                                                                                                                    url:'../modulosEspeciales_SGJ/paginasFunciones/funcionesModulosEspeciales_SGJ.php',
                                                                                                                                                                                    params:	{
                                                                                                                                                                                                criterioBusqueda:cadObj
                                                                                                                                                                                            }
                                                                                                                                                                                 }
                                                        
                                                                                                                                                                            )
                                                                                                                            }
                                                                                                                    
                                                                                                                },'-',
                                                                                                                {
                                                                                                                    xtype:'button',
                                                                                                                    icon:'../images/find_remove.png',
                                                                                                                    cls:'x-btn-text-icon',
                                                                                                                    text:'Limpiar Filtros',
                                                                                                                    handler:function()
                                                                                                                            {
                                                                                                                                cmbDespachos.setValue('');
                                                                                                                                cmbEspecialidad.setValue('');
                                                                                                                                cmbTipoProceso.setValue('');
                                                                                                                                cmbEstadoProceso.setValue('');
                                                                                                                                cmbInicioFiltro.setValue('');
                                                                                                                                gEx('fInicioFiltro').setValue('');
                                                                                                                                cmbFinFiltro.setValue('');
                                                                                                                                gEx('fFinFiltro').setValue('');
                                                                                                                                
                                                                                                                                
                                                                                                                                gEx('txtCuerpoDocumento').setValue('');
                                                                                                                                cmbCondicionDocumento.setValue('');
                                                                                                                                gEx('txtNombreDocumento').setValue('');
                                                                                                                                cmbFormatoDocumento.setValue('');
                                                                                                                                cmbCategoriaDocumentoFiltro.setValue('');
                                                                                                                                gEx('txtRegistradoPor').setValue('');
                                                                                                                                cmbInicioFiltroDocumento.setValue('');
                                                                                                                                gEx('fInicioFiltroDocumento').setValue('');
                                                                                                                                cmbFinFiltroDocumento.setValue('');
                                                                                                                                gEx('fFinFiltroDocumento').setValue('');
                                                                                                                                
                                                                                                                                var objProceso='{"depacho":"'+cmbDespachos.getValue()+'","especialidad":"'+cmbEspecialidad.getValue()+
                                                                                                                                                '","tipoProceso":"'+cmbTipoProceso.getValue()+'","estadoProceso":"'+cmbEstadoProceso.getValue()+
                                                                                                                                                '","fechaInicioRegistro":"'+(gEx('fInicioFiltro').getValue()?gEx('fInicioFiltro').getValue().format('Y-m-d'):'')+
                                                                                                                                                '","fechaFinRegistro":"'+(gEx('fFinFiltro').getValue()?gEx('fFinFiltro').getValue().format('Y-m-d'):'')+
                                                                                                                                                '","condFInicioFiltro":"'+cmbInicioFiltro.getValue()+'","condFFinFiltro":"'+cmbFinFiltro.getValue()+'"}';
                                                                                                                            
                                                                                                                            
                                                                                                                            
                                                                                                                            	var objDocumento='{"nombreDocumento":"'+cv(gEx('txtNombreDocumento').getValue())+'","condNombreDocumento":"'+
                                                                                                                                					cmbCondicionDocumento.getValue()+'","cuerpoDocumento":"'+cv(gEx('txtCuerpoDocumento').getValue())+
                                                                                                                                                    '","condCuerpoDocumento":"'+cv(cmbCondicionCuerpoDocumento.getValue())+'","formato":"'+cmbFormatoDocumento.getValue()+'","categoriaDocumento":"'+cmbCategoriaDocumentoFiltro.getValue()+
                                                                                                                                                '","fechaInicioRegistro":"'+(gEx('fInicioFiltroDocumento').getValue()?gEx('fInicioFiltroDocumento').getValue().format('Y-m-d'):'')+
                                                                                                                                                '","fechaFinRegistro":"'+(gEx('fFinFiltroDocumento').getValue()?gEx('fFinFiltroDocumento').getValue().format('Y-m-d'):'')+
                                                                                                                                                '","condFInicioFiltro":"'+cmbInicioFiltroDocumento.getValue()+'","condFFinFiltro":"'+cmbFinFiltroDocumento.getValue()+
                                                                                                                                                '","registradoPor":"'+(gEx('txtRegistradoPor').getValue())+'"}';
                                                                                                                            	
                                                                                                                                
                                                                                                                                var cadObj='{"objProceso":'+objProceso+',"objDocumento":'+objDocumento+'}';
                                                                                                                                
                                                                                                                            
                                                                                                                            
                                                                                                                                gEx('gResultadoBusquedaDocumento').getStore().load	(
                                                                                                                                                                                {
                                                                                                                                                                                    url:'../modulosEspeciales_SGJ/paginasFunciones/funcionesModulosEspeciales_SGJ.php',
                                                                                                                                                                                    params:	{
                                                                                                                                                                                                criterioBusqueda:cadObj
                                                                                                                                                                                            }
                                                                                                                                                                                 }
                                                        
                                                                                                                                                                            )
                                                                                                                            }
                                                                                                                    
                                                                                                                },
                                                                                                            ]
                                                            							}
                                                                                    ),
                                                            items:	[
                                                            			
                                                                        {
                                                                        	xtype:'panel',
                                                                            defaultType: 'label',
                                                                            title:'Filtros de Documento',
                                                                            layout:'absolute',
                                                                            items:	[
                                                                            			{
                                                                                            x:10,
                                                                                            y:10,
                                                                                            html:'Nombre del Documento:'
                                                                                        },
                                                                                        cmbCondicionDocumento,
                                                                                        
                                                                                        {
                                                                                        	x:300,
                                                                                            y:5,
                                                                                            xtype:'textfield',
                                                                                            width:180,
                                                                                            id:'txtNombreDocumento'
                                                                                        },
                                                                                        {
                                                                                            x:515,
                                                                                            y:10,
                                                                                            html:'Formato:'
                                                                                        },
                                                                                        cmbFormatoDocumento,
                                                                                        {
                                                                                            x:10,
                                                                                            y:40,
                                                                                            html:'Categor&iacute;a del Documento:'
                                                                                        },
                                                                                        cmbCategoriaDocumentoFiltro,       
                                                                                        {
                                                                                            x:10,
                                                                                            y:70,
                                                                                            html:'Cuerpo del Documento:'
                                                                                        },   
                                                                                        cmbCondicionCuerpoDocumento,
                                                                                        {
                                                                                        	x:300,
                                                                                            y:65,
                                                                                            width:400,
                                                                                            xtype:'textfield',
                                                                                            id:'txtCuerpoDocumento'
                                                                                        },                                                                              
                                                                                        {
                                                                                            x:485,
                                                                                            y:40,
                                                                                            html:'Registrado Por:'
                                                                                        },
                                                                                        {
                                                                                        	x:580,
                                                                                            y:35,
                                                                                            xtype:'textfield',
                                                                                            width:250,
                                                                                            id:'txtRegistradoPor'
                                                                                        },
                                                                                        {
                                                                                            x:10,
                                                                                            y:100,
                                                                                            html:'Fecha de Registro:'
                                                                                        },
                                                                                        cmbInicioFiltroDocumento,
                                                                                        {
                                                                                            x:230,
                                                                                            y:95,
                                                                                            xtype:'datefield',
                                                                                            id:'fInicioFiltroDocumento'
                                                                                        },
                                                                                        {
                                                                                            x:355,
                                                                                            y:100,
                                                                                            html:'Y'
                                                                                        },
                                                                                        cmbFinFiltroDocumento,
                                                                                         {
                                                                                            x:480,
                                                                                            y:95,
                                                                                            xtype:'datefield',
                                                                                            id:'fFinFiltroDocumento'
                                                                                        }
                                                                                        
                                                                            		]
                                                                        },
                                                                        {
                                                                        	xtype:'panel',
                                                                            defaultType: 'label',
                                                                            title:'Filtros de Proceso',
                                                                            layout:'absolute',
                                                                            items:	[
                                                                            			{
                                                                                            x:10,
                                                                                            y:10,
                                                                                            html:'Despacho:'
                                                                                        },
                                                                                        cmbDespachos,
                                                                                        {
                                                                                            x:460,
                                                                                            y:10,
                                                                                            html:'Especialidad:'
                                                                                        },
                                                                                        cmbEspecialidad,
                                                                                        {
                                                                                            x:10,
                                                                                            y:40,
                                                                                            html:'Tipo de Proceso:'
                                                                                        },
                                                                                        
                                                                                        cmbTipoProceso,
                                                                                        {
                                                                                            x:460,
                                                                                            y:40,
                                                                                            html:'Estado del Proceso:'
                                                                                        },
                                                                                        cmbEstadoProceso,
                                                                                        {
                                                                                            x:10,
                                                                                            y:70,
                                                                                            html:'Fecha de Registro:'
                                                                                        },
                                                                                        cmbInicioFiltro,
                                                                                        {
                                                                                            x:230,
                                                                                            y:65,
                                                                                            xtype:'datefield',
                                                                                            id:'fInicioFiltro'
                                                                                        },
                                                                                        {
                                                                                            x:355,
                                                                                            y:70,
                                                                                            html:'Y'
                                                                                        },
                                                                                        cmbFinFiltro,
                                                                                         {
                                                                                            x:480,
                                                                                            y:65,
                                                                                            xtype:'datefield',
                                                                                            id:'fFinFiltro'
                                                                                        }
                                                                            		]
                                                                        }
                                                            		]
                                                        },
                                            			
                                                        crearGridResultadoProcesosDocumentos()
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
                                    	id:'vBusquedaProcesos',
										title: 'B&uacute;squeda de Documentos Avanzada',
										width: 880,
										height:460,
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


function crearGridResultadoProcesosDocumentos()
{
		var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idDocumento'},
		                                                {name: 'etapaProcesal'},
		                                                {name:'nomArchivoOriginal'},
		                                                {name: 'tamano'},
                                                        {name: 'fechaRegistro', type:'date', dateFormat:'Y-m-d'},
                                                        {name: 'fechaCreacion', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name: 'descripcion'},
                                                        {name:'idFormulario'},
                                                        {name:'idRegistro'},
                                                        {name:'idDocumento'},
                                                        {name: 'carpetaAdministrativa'},
                                                        {name: 'categoriaDocumentos'},
                                                        {name: 'idCarpeta'},
                                                        {name: 'tipoCarpeta'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../modulosEspeciales_SGJ/paginasFunciones/funcionesModulosEspeciales_SGJ.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'fechaRegistro', direction: 'ASC'},
                                                            groupField: 'tipoCarpeta',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:false
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='11';
                                        
                                    }
                        )   

	var expander = new Ext.ux.grid.RowExpander({
                                                column:2,
                                                expandOnDblClick:false,
                                                tpl : new Ext.Template(
                                                    '<table >'+
                                                    '<tr><td ><span class="TSJDF_Control">{descripcion}</span><br /><br /></td></tr>'+
                                                    '</table>'
                                                )
                                            });    
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                           new  Ext.grid.RowNumberer({width:30}),
                                                            expander,
                                                            {
                                                                header:'ID Documento',
                                                                width:100,
                                                                hidden:true,
                                                                sortable:true,
                                                                dataIndex:'idDocumento'
                                                            },
                                                            {
                                                                header:'',
                                                                width:30,
                                                                sortable:true,
                                                                dataIndex:'idDocumento',
                                                                renderer:function(val,meta,registro)
                                                                        {
                                                                            
                                                                            var arrNombre=registro.data.nomArchivoOriginal.split('.');
                                                                            return '<a href="javascript:visualizarDocumento(\''+bE(val)+'\')"><img src="../imagenesDocumentos/16/file_extension_'+arrNombre[1].toLowerCase()+'.png" /></a>'
                                                                        }
                                                            },
                                                            
                                                            {
                                                                header:'Fecha de registro',
                                                                width:120,
                                                                sortable:true,
                                                                dataIndex:'fechaCreacion',
                                                                renderer:function(val)
                                                                        {
                                                                            if(val)
                                                                                return val.format('d/m/Y H:i');
                                                                        }
                                                            },{
                                                                header:'Tipo documento',
                                                                width:150,
                                                                sortable:true,
                                                                dataIndex:'categoriaDocumentos',
                                                                renderer:function(val)
                                                                        {
                                                                            return formatearValorRenderer(arrCategorias,val);
                                                                        }
                                                            },
                                                            
                                                            {
                                                                header:'Documento',
                                                                width:350,
                                                                sortable:true,
                                                                dataIndex:'nomArchivoOriginal',
                                                                renderer:mostrarValorDescripcion
                                                            },
                                                            
                                                            {
                                                                header:'Tama&ntilde;o',
                                                                width:100,
                                                                sortable:true,
                                                                dataIndex:'tamano',
                                                                renderer:function(val,meta,registro)
                                                                        {
                                                                            
                                                                            return bytesToSize(parseInt(val),0);
                                                                        }
                                                            },
                                                            {
                                                                header:'Proceso Judicial',
                                                                width:180,
                                                                sortable:true,
                                                                dataIndex:'carpetaAdministrativa',
                                                                renderer:function(val,meta,registro)
                                                                        {
                                                                            
                                                                            return '<a href="javascript:setBusquedaCodigo(\''+bE(val)+'\',\''+bE(registro.data.idCarpeta)+'\')">'+val+'</a>';
                                                                        }
                                                            },
                                                           {
                                                                header:'Tipo de Expediente',
                                                                width:220,
                                                                sortable:true,
                                                                dataIndex:'tipoCarpeta',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	return formatearValorRenderer(arrTipoCarpeta,val);
                                                                        }
                                                            },
                                                            {
                                                                header:'',
                                                                width:30,
                                                                sortable:true,
                                                                dataIndex:'idDocumento',
                                                                renderer:function(val,meta,registro)
                                                                        {
                                                                            
                                                                            if(parseFloat(registro.data.idFormulario)>0)
                                                                                return '<a href="javascript:abrirProcesoOrigen(\''+bE(registro.data.idFormulario)+'\',\''+bE(registro.data.idRegistro)+'\')"><img src="../images/magnifier.png" title="Abrir proceso origen" alt="Abrir proceso origen" /></a>';
                                                                        }
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gResultadoBusquedaDocumento',
                                                                store:alDatos,
                                                                x:0,
                                                                y:200,
                                                                plugins:	[expander],
                                                                height:210,
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
                                                                                                    hideGroupedColumn: false,
                                                                                                    startCollapsed:false
                                                                                                })
                                                            }
                                                        );
        return 	tblGrid;
}

function setBusquedaCodigoProceso(cU,iE)
{
	gEx('txtNumeroExpediente').setValue(bD(cU));
    gEx('cmbAnio').setValue('0');
    idNodoSeleccionado='e_'+bD(iE);
    
    gEx('arbolExpedientes').getRootNode().reload();
    
}

function visualizarDocumento(iD)
{
	var pos=obtenerPosFila(gEx('gResultadoBusquedaDocumento').getStore(),'idDocumento',bD(iD));
    var registro=gEx('gResultadoBusquedaDocumento').getStore().getAt(pos);
    
    var arrNombre=registro.data.nomArchivoOriginal.split('.');
    var extension=arrNombre[arrNombre.length-1];
    var obj={};
    obj.url='../visoresGaleriaDocumentos/visorDocumentosGeneralBusqueda.php';
    obj.ancho='100%';
    obj.alto='100%';
    obj.params=	[['iD',bE('iD_'+bD(iD))],['cPagina','sFrm=true'],['cPagina','sFrm=true'],['palabraBusqueda',gEx('txtCuerpoDocumento').getValue().trim()]];
    if(extension!='')
    	obj.params.push(['extension',extension]);
    
    window.parent.abrirVentanaFancy(obj);
    
}

function crearGridPropiedadesProceso()
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name: 'idMeta'},
		                                                {name: 'metaData'},
		                                                {name:'valor'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../modulosEspeciales_SGJ/paginasFunciones/funcionesModulosEspeciales_SGJ.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'metaData', direction: 'ASC'},
                                                            groupField: 'metaData',
                                                            remoteGroup:false,
				                                            remoteSort: true,
                                                            autoLoad:false
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='30';
                                    	proxy.baseParams.cA=bE(nodoExpedienteSel.attributes.expediente);
                                       
                                        
                                    }
                        )   
       
    var cModelo= new Ext.grid.ColumnModel   	(
                                                    [
                                                        {
                                                            header:'',
                                                            width:130,
                                                            sortable:true,
                                                            menuDisabled : true,
                                                            dataIndex:'metaData'
                                                        },
                                                        {
                                                            header:'',
                                                            width:300,
                                                            sortable:true,
                                                             menuDisabled : true,
                                                            dataIndex:'valor',
                                                            renderer:function(val,meta,registro)
                                                            		{
                                                                    	return mostrarValorDescripcion(val);
                                                                    }
                                                        },
                                                    ]
                                                );
                                                
    var tblGrid=	new Ext.grid.GridPanel	(
                                                        {
                                                            id:'gMetaDataProceso',
                                                            store:alDatos,
                                                            region:'east',
                                                            collapsible:true,
                                                            title:'Datos del Proceso Judicial',
                                                            frame:false,
                                                            cm: cModelo,
                                                            width:300,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            columnLines : true,

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

function visualizarTimeLine(cA)
{
	var obj={};
    obj.ancho='100%';
    obj.alto='100%';
    obj.openEffect='fade';
    obj.url='../modulosEspeciales_SGJ/frameHistorialCarpetaJudicial.php';
    obj.params=[['cA',cA],['cPagina','sFrm=true']];
    obj.titulo='Time Line, Proceso Judicial: '+bD(cA);
    window.parent.abrirVentanaFancy(obj);
}