<?php	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	$idUsuario=bD($_GET["iU"]);
	$consulta="select codigoRol from 807_usuariosVSRoles where idUsuario=".$idUsuario. " and codigoRol not like '%_-1'";
	$roles=$con->obtenerListaValores($consulta,"'");
	
	$consulta="SELECT DISTINCT idProceso FROM 9116_responsablesPAT WHERE idResponsable=".$idUsuario;
	$procesos=$con->obtenerListaValores($consulta);
	
	
	$consulta="select idComite from 2007_rolesVSComites where rol in (".$roles.")";

	$idComites=$con->obtenerListaValores($consulta);
	if($idComites=='')
		$idComites="-1";
	
	$consulta="select distinct(idProceso)  from 943_rolesActoresProceso where rol in (".$roles.")";
	$idProcesos=$con->obtenerListaValores($consulta);
	if($idProcesos=="")
		$idProcesos="-1";
	
	$consulta="select distinct(idProyecto) as idProceso from 235_proyectosVSComites where idComite in (".$idComites.")";
	$resAux=$con->obtenerListaValores($consulta);
	if($resAux!="")
		$idProcesos.=",".$resAux;
		
	$consulta="SELECT DISTINCT(idProceso) FROM 955_revisoresProceso WHERE idUsuarioRevisor=".$idUsuario." and estado in (1,2)";
	$resAux=$con->obtenerListaValores($consulta);
	if($resAux!="")
		$idProcesos.=",".$resAux;
				
	$consulta="select f.idProceso from 246_autoresVSProyecto a,900_formularios f where f.idFormulario=a.idFormulario and idProceso not  in(".$idProcesos.") and a.idUsuario=".$idUsuario;
	$resAux=$con->obtenerListaValores($consulta);
	if($resAux!="")
		$idProcesos.=",".$resAux;
	
	if($procesos!="")
	{
		if($idProcesos!="")
			$idProcesos.=",".$procesos;
		else	
			$idProcesos=$procesos;
	}				
	$consulta="select p.idProceso,p.nombre,tp.tipoProceso from 4001_procesos p,921_tiposProceso tp where tp.idTipoProceso=p.idTipoProceso and p.idProceso in(".$idProcesos.") order by tp.tipoProceso,p.nombre";
	
	$res=$con->obtenerFilas($consulta);
	$arrProcesos=array();
	while($fila=mysql_fetch_row($res))
	{
		if(!isset($arrProcesos[$fila[2]]))
			$arrProcesos[$fila[2]]=array();
		$obj[0]=$fila[0];
		$obj[1]=$fila[1];
		array_push($arrProcesos[$fila[2]],$obj);
	}
	
?>
Ext.onReady(inicializar);
var nodoSel=null;
var criterioB=1;
var idProcesoC=130;
function inicializar()
{
	
	Ext.QuickTips.init();
	var detailEl;
    var iU=gE('iU').value;
    var nUsuario=gE('nUsuario').value;
	/*	,*/
                                                
/*    var menu1=new Ext.menu.Menu(
    									{
                                        	items:	[
                                            			{
                                                        	text:'Prueba 1'
                                                            
                                                        },
                                                        {
                                                        	text:'Prueba 2'
                                                        }
                                                        
                                            		]
    									}
                                        
                                    )*/
    
    var pagRegresar=gE('pagRegresar').value;
    var tb=new Ext.Toolbar	(
    							{
									region: 'north',
                                    height:28,
                                    items:	[
                                    			{
                                                	xtype:'spacer',
                                                    width:15
                                                },
                                                {
                                                	xtype:'label',
                                                	html:'<table><tr><td><a href="'+pagRegresar+'"><img src="../images/flechaizq.gif" /></a></td><td>&nbsp;&nbsp;&nbsp;&nbsp;<span class="letraExt"><b>Bienvenido: </b>&nbsp;'+nUsuario+' </span></td></tr></table></a>'
                                                    
                                                },
                                                {
                                                	xtype:'spacer',
                                                    width:15
                                                }
                                                /*,
                                                {
                                                	text:'Sistema',
                                                    menu:menu1
                                                }*/
                                            ]
                                }
    						);
    
    new Ext.Viewport(	{
                            layout: 'border',
                            title: '',
                            items: [
                            			tb,
                                        
                                        {
                                            layout: 'accordion',
                                            id: 'layout-browser',
                                            region:'west',
                                            border: false,
                                            split:true,
                                            margins: '2 0 5 5',
                                            width: 255,
                                            collapsible:true,
                                            hideCollapseTool :false,
                                            layoutConfig:{
                                                            animate:true
                                                        },
                                            title:'Opciones disponibles',
                                            items: [ 
                                            			{
                                                        	id:'OpcionesGral',
                                                            title:'- General',
                                                            collapsible:true,
                                                            region:'north',
                                                            autoScroll:true,
                                                            autoLoad:	{
                                                                            url:'../modeloPerfiles/opcionesGenerales.php',
                                                                            params:	{
                                                                                        idUsuario:iU
                                                                                    }
                                                                        }
                                                        },
                                            			{
                                                            id: 'tblProcesos',
                                                            collapsible:true,
                                                            title: '- Procesos disponibles',
                                                            region: 'center',
                                                            autoScroll: true,
                                                            layout: 'accordion',
                                                            layoutConfig:{
                                                                            animate:true
                                                                        },
                                                            items:	[
                                                            
                                                            			<?php
																			$x=1;
																			$nProcesos=sizeof($arrProcesos);
																			foreach($arrProcesos as $tipoProceso=>$objProc)
																			{
																			
																			?>
                                                                                {
                                                                                    id: 'tProceso_<?php echo $x?>',
                                                                                    collapsible:true,
                                                                                    title: '<img src="../images/flecha_azul_corta.gif" />&nbsp;&nbsp;<?php echo $tipoProceso?>',
                                                                                    region: 'center',
                                                                                    autoScroll: true,
                                                                                    collapsed:true,
                                                                                    autoLoad: 	{
                                                                                    				url:'../modeloPerfiles/procesosDisponibles.php',
                                                                                                    params:	{
                                                                                                    			procesos:'<?php echo bE(json_encode($objProc)) ?>'
                                                                                                    		}
                                                                                    
                                                                                    			}
                                                                                   
                                                                                }
																			<?php
																				if($nProcesos!=$x)
																					echo ",";
																				$x++;
																			}
																		?>
                                                                        
                                                            		]
                                                        },
                                                        {
                                                              id: 'tblActores',
                                                              collapsible:true,
                                                              title: '- Actores disponibles',
                                                              region: 'center',
                                                              autoScroll: true,
                                                              hidden:true
                                                         }
                                            		]
                                            
                                        },
                                        {
                                            id: 'content',
                                            region: 'center',
                                            xtype:'iframepanel',
                                            loadMask:	{
                                                            msg:'Cargando'
                                                        }
                                        }
                                    ]
						}
                    );

	
                    
	//inicializarVentanaPendientes();
    					           
}

function inicializarVentanaPendientes()
{
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: '',
										width: 500,
										height:450,
										layout: 'fit',
										plain:true,
										modal:false,
                                        bodyStyle:'padding:5px;',
										buttonAlign:'center',
										items: form,
                                        collapsible  :true,
                                        collapsed:true,
                                        draggable:false,
                                        closable  :false,
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
																		ventanaAM.collapse(true);
																	}
														}
													]
									}
								);
	ventanaAM.show();
}

function procesoSel(iP)
{
	desSeleccionarProcesos();
    setClase('filaProc_'+bD(iP),'corpo8_bold');
    var iU=gE('iU').value;
    gEx('content').load({url:'../paginasFunciones/white.php'});
    var vActores=Ext.getCmp('tblActores');
    vActores.show();
	vActores.load({url:'../modeloPerfiles/actoresDisponibles.php',params:{idProceso:iP,idUsuario:iU},scripts:true});
    vActores.expand();
}

function desSeleccionarProcesos()
{
	var arrOpciones=document.getElementsByName('opcProceso');
    var x;
    for(x=0;x<arrOpciones.length;x++)
	{
    	setClase(arrOpciones[x],'');
    }
}

function recargarContenedorCentral()
{
	var content=Ext.getCmp('content');
    content.getFrameWindow().recargarPagina();
}

function regresarContenedorCentral()
{
	var content=Ext.getCmp('content');
    content.getFrameWindow().regresarPagina();
}



function mostrarAgenda()
{
	var iU=bD(gE('iU').value);
	var content=Ext.getCmp('content');
    content.load(
    				{
                    	url:'../agenda/agenda.php',
                        params:	{
                        			cPagina:'sFrm=true',
                                    idUsuario:iU
                        		},
                       scripts:true
                    }
                );
    
}

function mostrarHorarioTrabajo()
{
	var content=Ext.getCmp('content');
    content.load(
    				{
                    	url:'../Usuarios/confHorarioSemanal.php',
                        params:	{
                        			cPagina:'sFrm=true'
                        		},
                       scripts:true
                    }
                );

}

function mostrarProgramaTrabajo()
{
	var content=Ext.getCmp('content');
    content.load(
    				{
                    	url:'../modeloProyectos/programaTrabajo.php',
                        params:	{
                        			cPagina:'sFrm=true'
                        		},
                       scripts:true
                    }
                );
}

function mostrarReporteMenciones()
{
	var content=Ext.getCmp('content');
    content.load(
    				{
                    	url:'../reportes/mencionesPrev.php',
                        params:	{
                        			cPagina:'sFrm=true'
                        		},
                       scripts:true
                    }
                );
    
}

function mostrarReporteProgramaTrabajo()
{
	var content=Ext.getCmp('content');
    content.load(
    				{
                    	url:'../reportes/programaTrabajo.php',
                        params:	{
                        			cPagina:'sFrm=true'
                        		},
                       scripts:true
                    }
                );
    
}

function mostrarReporteUsuarios()
{
	var content=Ext.getCmp('content');
    content.load(
    				{
                    	url:'../Usuarios/buscarUsuario.php',
                        params:	{
                        			cPagina:'sFrm=true'
                        		},
                       scripts:true
                    }
                );
    
}

function enviarAsignacionResponsable(iP,iA)
{
	var content=Ext.getCmp('content');
    var iP=gE('idProceso').value;	
    content.load({url:'../planeacion/asignacionResponsables.php',scripts:true,params:{idProceso:bD(iP),idAccion:bD(iA),cPagina:'sFrm=true'}})
}