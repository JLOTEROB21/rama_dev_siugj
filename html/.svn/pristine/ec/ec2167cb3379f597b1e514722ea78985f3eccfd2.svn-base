<?php	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	$idUsuario=bD($_GET["iU"]);
	$idProceso=bD($_GET["iP"]);
	$actor=bD($_GET["ac"]);
	$idFormBase=obtenerFormularioBase($idProceso);
	
	$consulta="select vistaListadoRegistros from 900_formularios where idFormulario=".$idFormBase;
	$vistaRegistro=$con->obtenerValor($consulta);
	
	$roles="";
	if($actor=="-1")
	{
		$consulta="select codigoRol from 807_usuariosVSRoles where idUsuario=".$idUsuario. " and codigoRol not like '%_-1'";
		$roles=$con->obtenerListaValores($consulta,"'");
		if($roles=="")
			$roles=-1;
	}
	else
	{
		$roles=$actor;
	}
	$consulta="select p.idProceso,p.nombre,tp.tipoProceso,p.idTipoProceso from 4001_procesos p,921_tiposProceso tp where tp.idTipoProceso=p.idTipoProceso and p.idProceso =".$idProceso." order by tp.tipoProceso,p.nombre";
	$filaProc=$con->obtenerPrimeraFila($consulta);
	$titulo="";
	$funcion="";
	$vListadoRegistros="false";
	if($vistaRegistro!="0")
	{
		
		$tProceso=$filaProc[3];
		$evaluar=true;
		switch($tProceso)
		{
			case 27:
			break;
			case 28:
			case 21:
			case 9:
				$evaluar=false;
			break;    
			default:
			break;    
		
		}
		$complementario="";
		$ocultarVistasUsr="false";
		if($evaluar)
		{
			
			$arrRolesUsr=explode(",",str_replace("'","",$roles));
			
			$consulta="select distinct(actor) from 949_actoresVSAccionesProceso where actor in (".$roles.") and idProceso=".$idProceso;
			
			$resRolIni=$con->obtenerListaValores($consulta,"'");
			if($resRolIni=="")
				$resRolIni="-1";
			$mostrarVistaRegistro=false;
			$relacionReg="";
			$nVistas=0;
			$funcion="";
			
			if($con->filasAfectadas>0)
			{
				$mostrarVistaRegistro=true;
				$relacionReg=1;
				$nVistas++;
			}
			else
			{
				$consulta="select nombreTabla,idFormulario from 900_formularios where idProceso=".$idProceso." and formularioBase=1";
				$filaFrm=$con->obtenerPrimeraFila($consulta);
				$nTabla=$filaFrm[0];
				$idFormularioBase=$filaFrm[1];
				$idFrmAutores=incluyeModulo($idProceso,3);
				if($idFrmAutores=="-1")
					$condWhere=" where responsable=".$idUsuario;
				else
					$condWhere=" where id_".$nTabla." in (select distinct idReferencia from 246_autoresVSProyecto where idUsuario=".$idUsuario." and idFormulario=".$idFormularioBase.")";
				$consulta="select id_".$nTabla." from ".$nTabla." ".$condWhere;
				$con->obtenerFilas($consulta);
				if($con->filasAfectadas>0)
				{
					$mostrarVistaRegistro=true;
					$relacionReg=2;
					$nVistas++;
				}
			}
			
			$consulta="select distinct(actor) from 944_actoresProcesoEtapa where actor in (".$roles.") and actor not in (".$resRolIni.") and tipoActor=1 and idProceso=".$idProceso;
	
			$rolesProceso=$con->obtenerFilas($consulta);
			$nRolesProceso=$con->filasAfectadas;
			$mostrarVistaRoles=false;
			if($con->filasAfectadas>0)
			{
				$mostrarVistaRoles=true;
				$nVistas++;
			}
			$arrRolesDispIni=array();
			$consulta="select idComite from 234_proyectosVSComitesVSEtapas pc where pc.idProyecto=".$idProceso;
			$lComite=$con->obtenerListaValores($consulta);
			$arrRolesComiteDisp=array();
			$mostrarVistaComite=false;
			if($lComite!='')
			{
				$consulta="select distinct(idComite) from 2007_rolesVSComites rc where rc.rol in(".$roles.") and idComite in (".$lComite.")";
				$lComite=$con->obtenerListaValores($consulta);
				if($con->filasAfectadas>0)
				{
					$mostrarVistaComite=true;
					$nVistas+=$con->filasAfectadas;
				}
			}
			
			
			
			 $consulta="select distinct idUsuarioRevisor,idActorProcesoEtapa from 955_revisoresProceso where idUsuarioRevisor=".$idUsuario." and idProceso=".$idProceso." and estado in (1,2)"; 
			 $resRevisor=$con->obtenerFilas($consulta);
			 $nRevisor=$con->filasAfectadas;
			 $mostrarVistaRevisor=false;
			 if($con->filasAfectadas>0)
			 {
				$mostrarVistaRevisor=true;
				$consulta="select distinct idActorProcesoEtapa from 955_revisoresProceso where idUsuarioRevisor=".$idUsuario." and idProceso=".$idProceso." and estado in (1,2)";
				$con->obtenerFilas($consulta);
				if($con->filasAfectadas>1)
					$nVistas=$con->filasAfectadas;
				else
					$nVistas++;
			 }
			$vista;
			$relacion;
			$rol;
			
			$ocultarVistas=false;
			
			if(($mostrarVistaRegistro)&&($nVistas<2))
			{
				if($relacionReg=="1")
				{
					$arrRoles=explode(",",$resRolIni);
					$nVistas=sizeof($arrRoles);
					if($nVistas==1)
					{
						$vista=1;
						$relacion=1;
						$rol=$arrRoles[0];
						$funcion='enviarVistaProcesoActor("'.base64_encode($idProceso).'","'.base64_encode($vista).'","'.bE($relacion).'","'.bE($rol).'");';
					}
					else
					{
						$funcion="";	
					}
				}
				else
				{
					$nVistas=1;
					$vista=1;
					$relacion=2;
					$funcion='enviarVistaProceso("'.base64_encode($idProceso).'","'.base64_encode($vista).'","'.bE($relacion).'");';
				}						
				
			}
			
			if($nVistas==1)
			{
				if($mostrarVistaComite)
				{
					$consulta="select nombreComite,idComite from 2006_comites where idComite in (".$lComite.")";
					$resC=$con->obtenerFilas($consulta);
					$nVistas=$con->filasAfectadas;
					if($nVistas==1)
					{
						$fila=mysql_fetch_row($resC);
						$vista=2;
						$idComite=$fila[1];
						$funcion='enviarVistaProceso("'.base64_encode($idProceso).'","'.base64_encode($vista).'","'.bE($idComite).'");';
					}
					else
						$funcion="";
				}	
			
				if($mostrarVistaRoles)
				{
					$nVistas=$nRolesProceso;
					if($nVistas==1)
					{
						$fila=mysql_fetch_row($rolesProceso);
						$vista=3;
						$funcion='enviarVistaProceso("'.base64_encode($idProceso).'","'.base64_encode($vista).'");';
					}
					else
						$funcion="";
					
				}
				
				if($mostrarVistaRevisor)
				{
					$nVistas=$nRevisor;
					if($nVistas==1)
					{
						$fila=mysql_fetch_row($resRevisor);
						$vista=4;
						$idActor=$fila[1];
						$funcion='enviarVistaProceso("'.base64_encode($idProceso).'","'.base64_encode($vista).'","'.bE($idActor).'");';
					}
					else
						$funcion="";
				}
			}
			$ocultarVistasUsr="false";
			$complementario='<td><span class="letraExt"><b>Bienvenido: </b>&nbsp;'.obtenerNombreUsuario($idUsuario).' </span></td>';
			$autoLoad="";
			$titulo="";
		}
		else
			$nVistas=2;
	}
	else
	{
		$nVistas=1;
		$ocultarVistasUsr="true";
		$vListadoRegistros="true";
		$funcion="enviarListadoRegistros(".$idProceso.");";
	}
	if($nVistas==1)
	{
		
		$complementario="";
		$autoLoad="	url:'../modeloPerfiles/bienvenido.php',
					params:	{
								idUsuario:'".bE($idUsuario)."'
							}";
		
	}
	else
	{
		$titulo="- Vistas disponibles";
		$autoLoad="url:'../modeloPerfiles/actoresDisponibles.php',
					params:	{
								idProceso:'".bE($idProceso)."',
								idUsuario:'".bE($idUsuario)."',
								actor:'".bE($actor)."'
							}";
	}
	
	
?>
Ext.onReady(inicializar);
var nodoSel=null;
var criterioB=1;
var idProcesoC=130;
var vListadoRegistros=<?php echo $vListadoRegistros?>;
function inicializar()
{
	var pagRegresar=gE('pagRegresar').value;
    var detailEl;
    var iU=gE('iU').value;
    var nUsuario=gE('nUsuario').value;
	var lblProceso='<table><tr><td><a href="'+pagRegresar+'"><img src="../images/flechaizq.gif" /></a></td><td>&nbsp;&nbsp;&nbsp;&nbsp;<u><span style="font-size:13px; font-weight:bold; color:#900;"><?php echo $filaProc[1]?></span></u></td><td width="100"></td><?php echo $complementario ?></tr></table></a>';
	if(gE('idProcesoPadre').value!='-1')
		lblProceso='<table><tr height="21"><td>&nbsp;<u><span style="font-size:13px; font-weight:bold; color:#900;"><?php echo $filaProc[1]?></span></u></td><td width="100"></td><?php echo $complementario ?></tr></table></a>';    	
    
    
    Ext.QuickTips.init();
	

    
    
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
                                                	html:lblProceso
                                                    
                                                },
                                                {
                                                	xtype:'spacer',
                                                    width:15
                                                }
                                               
                                            ]
                                }
    						);


	var arrElementos=	[
    						tb,
                            {
                                  id: 'tblActores',
                                  collapsible:true,
                                  split:true,
                                  title: '<?php echo $titulo?>',
                                  region: 'west',
                                  autoScroll: true,
                                  hidden:<?php echo $ocultarVistasUsr ?>,
                                  width:255,
                                  autoLoad:	{
                                                <?php echo $autoLoad;?>
                                            }
                             }
                            ,
                            {
                                id: 'content',
                                region: 'center',
                                xtype:'iframepanel',
                                border:false,
                                frame:false,
                                loadMask:	{
                                                msg:'Cargando'
                                            }
                            }
    					]
                            
	if(gE('ocultarTitulo').value=='1')                            
    	arrElementos.splice(0,1);	
                            
    
    new Ext.Viewport(	{
                            layout: 'border',
                            xtype:'panel',
                            border:false,
                            frame:false,
                            items: arrElementos
						}
                    );

	<?php
    if($nVistas==1)
	{
		echo $funcion;
	}    
	?>        
	
    					           
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
    if(!vListadoRegistros)
	    content.getFrameWindow().regresarPagina();
    else
    	content.getFrameWindow().recargarContenedorCentral();

}

function regresarContenedorCentral()
{
	var content=Ext.getCmp('content');
	if(!vListadoRegistros)
	    content.getFrameWindow().regresarPagina();
    else
    	content.getFrameWindow().recargarContenedorCentral();
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

function enviarListadoRegistros(iP)
{
	var content=Ext.getCmp('content');
    var objParam={};
    objParam.idProceso=iP;
    objParam.cPagina='sFrm=true';
    objParam.ciclo=gE('ciclo').value;
    objParam.idReferencia=gE('idReferencia').value;
    objParam.idFormulario=gE('idFormulario').value;
    objParam.idProcesoPadre=gE('idProcesoPadre').value;
    objParam.idUsuario=gE('idUsuario').value;
    objParam.actor=gE('actor').value;
    objParam.sL=gE('sL').value;
    objParam.tipoVista=gE('tipoVista').value;
    
    content.load({url:'../modeloProyectos/visorRegistrosProcesos.php',scripts:true,params:objParam})
}