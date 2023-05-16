<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
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
    var pagRegresar=gE('pagRegresar').value;
    var tb=new Ext.Toolbar	(
    							{
									region: 'north',
                                    height:28,
                                    items:	[
                                    			/*{
                                                	xtype:'spacer',
                                                    width:15
                                                },
                                                {
                                                	xtype:'label',
                                                	html:'<table><tr><td><a href="'+pagRegresar+'"><img src="../images/flechaizq.gif" /></a></td><td>&nbsp;&nbsp;&nbsp;&nbsp;<span class="letraExt"><b>Ficha de adscripci&oacute;n</b>&nbsp; </span></td></tr></table></a>'
                                                    
                                                },
                                                {
                                                	xtype:'spacer',
                                                    width:15
                                                }*/
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
                                            width: 240,
                                            collapsible:true,
                                            hideCollapseTool :false,
                                            layoutConfig:{
                                                            animate:true
                                                        },
                                            title:'Opciones disponibles',
                                            items: [ 
                                            			{
                                                        	id:'OpcionesGral',
                                                            title:'General',
                                                            collapsible:true,
                                                            region:'north',
                                                            autoScroll:true,
                                                            autoLoad:	{
                                                                            url:'../Usuarios/opcionesUsuario.php',
                                                                            params:	{
                                                                                        idUsuario:iU
                                                                                    }
                                                                        }
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
    var iU=gE('iU').value;
    
    var vActores=Ext.getCmp('tblActores');
    vActores.show();
	vActores.load({url:'../modeloPerfiles/actoresDisponibles.php',params:{idProceso:iP,idUsuario:iU},scripts:true});
    vActores.expand();
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
	var content=Ext.getCmp('content');
    content.load(
    				{
                    	url:'../calendario/muestraCal.php',
                        params:	{
                        			cPagina:'sFrm=true'
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

function configurarAdscripcion()
{
	var content=Ext.getCmp('content');
    var iU=gE('iU').value;
    content.load(
    				{
                    	url:'../nomina/confAdscripcion.php',
                        params:	{
                        			cPagina:'sFrm=true',
                                    idUsuario:iU
                        		},
                       scripts:true
                    }
                );	
}

function horarioLaboral()
{
	var content=Ext.getCmp('content');
    var iU=gE('iU').value;
    content.load(
    				{
                    	url:'../Usuarios/confHorarioSemanal.php',
                        params:	{
                        			cPagina:'sFrm=true',
                                    idUsuario:iU
                        		},
                       scripts:true
                    }
                );	
}

function verPercepcionesIndividuales()
{
	var content=Ext.getCmp('content');
    var iU=gE('iU').value;
    content.load(
    				{
                    	url:'../nomina/confPercepciones.php',
                        params:	{
                        			cPagina:'sFrm=true',
                                    idUsuario:iU
                        		},
                       scripts:true
                    }
                );	
	gEx('layout-browser').collapse();
	                
}

function verDeduccionesIndividuales()
{
	var content=Ext.getCmp('content');
    var iU=gE('iU').value;
    content.load(
    				{
                    	url:'../nomina/confDeducciones.php',
                        params:	{
                        			cPagina:'sFrm=true',
                                    idUsuario:iU
                        		},
                       scripts:true
                    }
                );	
	gEx('layout-browser').collapse();                
}

function verFump()
{
	var content=Ext.getCmp('content');
    var iU=gE('iU').value;
    content.load(
    				{
                    	url:'../Usuarios/fump.php',
                        params:	{
                        			cPagina:'sFrm=true',
                                    idUsuario:iU
                        		},
                       scripts:true
                    }
                );	
	gEx('layout-browser').collapse();                
}

function verCuentasBancarias()
{
	var content=Ext.getCmp('content');
    var iU=gE('iU').value;
    content.load(
    				{
                    	url:'../Usuarios/cuentasBancarias.php',
                        params:	{
                        			cPagina:'sFrm=true',
                                    idUsuario:iU
                        		},
                       scripts:true
                    }
                );	
	
}

function verBeneficiarios()
{
	var content=Ext.getCmp('content');
    var iU=gE('iU').value;
    content.load(
    				{
                    	url:'../modeloPerfiles/tblFormularios.php',
                        params:	{
                        			cPagina:'sFrm=true',
                                    idUsuario:bD(iU),
                                    idFormulario:217
                        		},
                       scripts:true
                    }
                );	
	
}

function verCalculosNomina()
{
	var content=Ext.getCmp('content');
    var iU=gE('iU').value;
    content.load(
    				{
                    	url:'../nomina/calculosNomina.php',
                        params:	{
                        			cPagina:'sFrm=true',
                                    idUsuario:iU
                        		},
                       scripts:true
                    }
                );	
	gEx('layout-browser').collapse();                
}


function verDiasEconomicos()
{
	var content=Ext.getCmp('content');
    var iU=gE('iU').value;
    content.load(
    				{
                    	url:'../modeloPerfiles/tblFormularios.php',
                        params:	{
                        			cPagina:'sFrm=true',
                                    idUsuario:bD(iU),
                                    idFormulario:222
                        		},
                       scripts:true
                    }
                );	
	
}

function verLicencias()
{
	var content=Ext.getCmp('content');
    var iU=gE('iU').value;
    content.load(
    				{
                    	url:'../modeloPerfiles/tblFormularios.php',
                        params:	{
                        			cPagina:'sFrm=true',
                                    idUsuario:bD(iU),
                                    idFormulario:223
                        		},
                       scripts:true
                    }
                );	
	
}

function verVacaciones()
{
	var content=Ext.getCmp('content');
    var iU=gE('iU').value;
    content.load(
    				{
                    	url:'../modeloPerfiles/tblFormularios.php',
                        params:	{
                        			cPagina:'sFrm=true',
                                    idUsuario:bD(iU),
                                    idFormulario:225
                        		},
                       scripts:true
                    }
                );	
	
}
