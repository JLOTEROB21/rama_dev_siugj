<?php	session_start();
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
    new Ext.Viewport(	{
                            layout: 'border',
                            title: '',
                            items: [
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
                                            title:'Convocatorias disponibles',
                                            items: [ 
                                            			{
                                                        	id:'OpcionesGral',
                                                            region:'north',
                                                            autoScroll:true,
                                                            autoLoad:	{
                                                                            url:'../portal/convocatoriasDisponibles.php'
                                                                        }
                                                        },
                                                        {
                                                              id: 'tblProcesoRegistro',
                                                              region: 'center',
                                                              autoScroll: true,
                                                              margins: '2 0 5 5',
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

function verConvocatoria(iRep,iReg,iPR)
{
	var content=Ext.getCmp('content');
    content.load(
    				{
                    	url:'../thotReporter/thotVisor.php',
                        params:	{
                        			cPagina:'sFrm=true',
                                    r:iRep,
                                    idConvocatoria:bD(iReg)
                        		},
                       scripts:true
                    }
                );	
	if(bD(iPR)!='-1')
    {
    	gEx('OpcionesGral').setHeight(380);
        gEx('tblProcesoRegistro').show();
        gEx('tblProcesoRegistro').expand();
        gEx('tblProcesoRegistro').load	(
        									{
                                            	url:'../portal/muestraLinkInscripcion.php',
                                                params:{
                                                			idProceso:iPR
                                                		}
                                            }
        								)
   	}
    else
    {
    	gEx('OpcionesGral').expand();
        gEx('tblProcesoRegistro').hide();
    }                
}

function irRegistroEnLinea(iP)
{
	var idProceso=bD(iP);
    var arrParam=[['param',bE('idProcesoRegistro='+idProceso)]];
    window.parent.enviarFormularioDatos('<?php echo $urlSitio?>/registroUsuario/registroUsuario.php',arrParam);
}