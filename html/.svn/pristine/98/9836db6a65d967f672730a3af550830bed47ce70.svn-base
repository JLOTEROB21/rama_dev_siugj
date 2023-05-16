<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	$consulta="select idTipoReporte,tipoReporte from 980_tiposReporte";
	$arrDuracion=uEJ($con->obtenerFilasArreglo($consulta));
	$consulta="select idPrioridad,actividad from 967_prioridadActividad order by actividad";
	$arrTipoActividad=uEJ($con->obtenerFilasArreglo($consulta));
	$consulta="select idProceso,nombre from 4001_procesos  where idTipoProceso=4 order by nombre";
	$arrProcesosCV=uEJ($con->obtenerFilasArreglo($consulta));
	$consulta="select idTipoProceso,tipoProceso from 921_tiposProceso where idTipoProceso in (select tipoProceso from 201_modulosPredefinidosVSProcesos where idGrupoModulo=6) order by tipoProceso";
	$arrTiposProc=$con->obtenerFilasArreglo($consulta);
	$consulta="select valor,texto from 1004_siNo where idIdioma=".$_SESSION["leng"];
	$arrSiNo=$con->obtenerFilasArreglo($consulta);
?>
Ext.onReady(inicializar);
var nodoSelActividad=null;
var aLineasAccion=null;
function inicializar()
{
	Ext.QuickTips.init();
	var fInicioProy=gE('fInicioProy').value;
    if(fInicioProy=='')
    	fInicioProy=null;
    var fFinProy=gE('fFinProy').value;
    if(fFinProy=='')
    	fFinProy=null;
	var idFrm=gE('idFormulario').value;
    var idReg=gE('idReferencia').value;
	var cargadorArbol=new Ext.tree.TreeLoader(
												{
													baseParams:{
																	funcion:'73',
																	idFormulario:idFrm,
                                                                    idReferencia:idReg
																},
													dataUrl:'../paginasFunciones/funcionesProyectos.php',
                                                    uiProviders:	{
                                                                        'col': Ext.ux.tree.ColumnNodeUI
                                                                    }
												}
											)	

    var raiz=new  Ext.tree.AsyncTreeNode	(
                                                  {
                                                      id:'-1',
                                                      text:'Actividades',
                                                      draggable:false,
                                                      expanded :true,
                                                      icon:'../images/gantt.png',
                                                      fInicio:fInicioProy,
                                                      fFin:fFinProy
                                                  }
                                            )

	var panelActividades=new Ext.ux.tree.ColumnTree	(
                                                          {
                                                              id:'arbolActividades',
                                                              useArrows:true,
                                                              autoScroll:true,
                                                              animate:false,
                                                              enableDD:true,
                                                              containerScroll:true,
                                                              height:400,
                                                              width:650,
                                                              root:raiz,
                                                              rootVisible:false,
                                                              rootVisible:true,
                                                              loader: cargadorArbol,
                                                              title:'',
                                                              collapsible: true,
                                                              draggable:false,
                                                              columns:[
                                                                                 
                                                                            {
                                                                                header: 'Actividad',
                                                                                dataIndex: 'text',
                                                                                width: 400
                                                                                
                                                                            },
                                                                            {
                                                                                header: 'Fecha de inicio',
                                                                                width: 100,
                                                                                dataIndex: 'fInicio',
                                                                                align: 'center'
                                                                            },
                                                                            {
                                                                                header: 'Fecha de t&eacute;rmino',
                                                                                width: 100,
                                                                                dataIndex: 'fFin',
                                                                                align: 'center'
                                                                            }
                                                                       ]
                                                          }
                                                      );   
    var panel=new Ext.Panel	(
        							{
                                    	id:'divPanel',
                                        renderTo:'tblArbolGantt',
                                        items:	[
                                                    panelActividades
                                        		],
                                        tbar:	[
                                                  			{
                                                            	id:'btnAgregarActividad',
                                                            	text:'Agregar actividad',
                                                                icon:'../images/add.png',
																cls:'x-btn-text-icon',
                                                                disabled:true,
                                                                handler:function()
                                                                        {
                                                                        	if(nodoSelActividad==null)
                                                                            {
                                                                            	msgBox('Primero debe seleccionar la actividad que ser&aacute; padre de la nueva actividad');
                                                                                return;
                                                                            }
                                                                        	var idReferencia=gE('idReferencia').value;
                                                                            var idProceso=gE('idProceso').value;
                                                                            
                                                                            var fInicio=null;
                                                                            if(nodoSelActividad.attributes.fInicio!=undefined)
                                                                            	fInicio=nodoSelActividad.attributes.fInicio;
                                                                            
                                                                            var fFin=null;
                                                                            if(nodoSelActividad.attributes.fFin!=undefined)
                                                                            	fFin=nodoSelActividad.attributes.fFin;
                                                                            
                                                                            
                                                                            if((fInicio==null)&&(frmModuloFecha!='-1'))
                                                                            {
                                                                            	msgBox('Primero debe ingresar las fechas de inicio y t&eacute;rmino del registro en el m&oacute;dulo "control de fechas"');
                                                                                return;
                                                                            }
                                                                            
                                                                        	var obj={
                                                                                        tipoActividad:2,
                                                                                        idProceso:idProceso,
                                                                                        idObjeto:idReferencia,
                                                                                        idPadre:nodoSelActividad.id,
                                                                                        fechaI:fInicio,
                                                                                        fechaF:fFin
                                                                                    }
                                                                        	mostrarVentanaActividad(obj);
                                                                        }
                                                            },
                                                            {
                                                            	id:'btnModificarActividad',
                                                            	text:'Modificar Actividad',
                                                                icon:'../images/pencil.png',
																cls:'x-btn-text-icon',
                                                                disabled:true,
                                                                handler:function()
                                                                        {
                                                                        	modificarActividad();
                                                                        }
                                                                        	
                                                            },
                                                            {
                                                            	id:'btnRemoverActividad',
                                                            	text:'Remover Actividad',
                                                                icon:'../images/delete.png',
																cls:'x-btn-text-icon',
                                                                disabled:true,
                                                                handler:function()
                                                                        {
                                                                        	function resp(btn)
                                                                            {
                                                                            	if(btn=='yes')
                                                                                {
                                                                                	function funcAjax()
{                                                                                   var resp=peticion_http.responseText;
                                                                                    arrResp=resp.split('|');
                                                                                    if(arrResp[0]=='1')
                                                                                    {
                                                                                    	nodoSelActividad.remove();
                                                                                        nodoSelActividad=null;
                                                                                        Ext.getCmp('btnAgregarActividad').disable();
                                                                                        Ext.getCmp('btnModificarActividad').disable();
                                                                                        Ext.getCmp('btnRemoverActividad').disable();
                                                                                        if(typeof(funcAgregar)!='undefined')
		                                                                                	funcAgregar();
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                    }
                                                                                }
                                                                                obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=75&idActividad='+nodoSelActividad.id,true);
                                                                                	
                                                                                }
                                                                                
                                                                            }
                                                                            msgConfirm('Est&aacute; seguro de querer eliminar esta actividad?',resp);
                                                                        }
                                                            },
                                                            {
                                                            	id:'btnVerGantt',
                                                            	text:'Ver programa de trabajo',
                                                                icon:'../images/gantt.png',
																cls:'x-btn-text-icon',
                                                                
                                                                handler:function()
                                                                        {
                                                                        	verGantt();
                                                                        }
                                                                        	
                                                            }
                                                  		]
        							}
                             )                                              	  
    panelActividades.render();
    panelActividades.expandAll();
    panelActividades.on('click',funcClikArbolActividades);  
}

function funcClikArbolActividades(nodo, evento)
{
	nodoSelActividad=nodo;
    if(nodoSelActividad.id=='-1')
    {
        Ext.getCmp('btnAgregarActividad').enable();
        Ext.getCmp('btnModificarActividad').disable();
        Ext.getCmp('btnRemoverActividad').disable();
    }
    else
    {
    	Ext.getCmp('btnAgregarActividad').enable();
        Ext.getCmp('btnModificarActividad').enable();
        Ext.getCmp('btnRemoverActividad').enable();
    }
}

function crearVentanaActividad()
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
                                                            html:'Actividad: <font color="red">*</font>'
                                                        },
                                                        {
                                                        	id:'txtActividad',
                                                        	x:110,
                                                            y:5,
                                                            xtype:'textfield',
                                                            width:250,
                                                            maxLength:255
                                                        },
                                                        {
                                                        	x:10,
                                                            y:35,
                                                            html:'Descripci&oacute;n:'
                                                        },
                                                        {
                                                        	id:'txtDescripcion',
                                                        	x:110,
                                                            y:30,
                                                            xtype:'textarea',
                                                            width:280,
                                                            height:80
                                                        },
                                                        {
                                                        	x:10,
                                                            y:120,
                                                            html:'Fecha Inicial: <font color="red">*</font>'
                                                        },
                                                        {
                                                        	id:'dteFechaInicio',
                                                            xtype:'datefield',
                                                            x:110,
                                                            y:115,
                                                            editable:false,
                                                            format:'d/m/Y'
                                                            
                                                        },
                                                        {
                                                        	x:10,
                                                            y:145,
                                                            html:'Fecha Final: <font color="red">*</font>'
                                                        },
                                                        {
                                                        	id:'dteFechaFin',
                                                            xtype:'datefield',
                                                            x:110,
                                                            y:140,
                                                            editable:false,
                                                            format:'d/m/Y'
                                                            
                                                        }
                                                        
														

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar actividad',
										width: 500,
										height:260,
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
                                                                	Ext.getCmp('txtActividad').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															id:'btnAceptar',
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
                                                                    	var idPadre=nodoSelActividad.id;
                                                                        var txtActividad=Ext.getCmp('txtActividad');
                                                                        var txtDescripcion=Ext.getCmp('txtDescripcion');
                                                                        var dteFechaInicio=Ext.getCmp('dteFechaInicio');
                                                                        var dteFechaFin=Ext.getCmp('dteFechaFin');
                                                                        var idFormulario=gE('idFormulario').value;
                                                                        var idReferencia=gE('idReferencia').value;
                                                                        if(txtActividad.getValue()=='')
                                                                        {
                                                                        	function respAct()
                                                                            {
                                                                            	txtActividad.focus();
                                                                            }
                                                                            
                                                                        	msgBox('Debe ingresar la actividad a desempe&ntilde;ar',respAct);
                                                                            return;
                                                                        }
                                                                        
                                                                        if(dteFechaInicio.getValue()=='')
                                                                        {
                                                                        	function respFechaI()
                                                                            {
                                                                            	dteFechaInicio.focus();
                                                                            }
                                                                            
                                                                        	msgBox('Debe ingresar la fecha de inicio de la actividad',respFechaI);
                                                                            return;
                                                                        }
                                                                        
                                                                        if(dteFechaFin.getValue()=='')
                                                                        {
                                                                        	function respFechaF()
                                                                            {
                                                                            	dteFechaFin.focus();
                                                                            }
                                                                            
                                                                        	msgBox('Debe ingresar la fecha final de la actividad',respFechaF);
                                                                            return;
                                                                        }
                                                                        
                                                                        if(dteFechaInicio.getValue()>dteFechaFin.getValue())
                                                                        {
                                                                        	function respFecha()
                                                                            {
                                                                            	dteFechaInicio.focus();
                                                                            }
                                                                            
                                                                        	msgBox('La fecha inicial no puede ser mayor que la fecha final',respFecha);
                                                                            return;
                                                                        }
                                                                        
                                                                        var f=new  Date(dteFechaInicio.getValue());
		
                                                                        var fechaI=f.format('Y-m-d');
                                                                        f=new  Date(dteFechaFin.getValue());
		
                                                                        var fechaF=f.format('Y-m-d');
                                                                        
																		var obj='{"idFormulario":"'+idFormulario+'","idReferencia":"'+idReferencia+'","idPadre":"'+idPadre+'","actividad":"'+cv(txtActividad.getValue())+'","descripcion":"'+cv(txtDescripcion.getValue())+'","fechaInicio":"'+fechaI+'","fechaFin":"'+fechaF+'"}';
                                                                        
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	var raiz=Ext.getCmp('arbolActividades');
                                                                            	raiz.getRootNode().reload();
                                                                                raiz.expandAll();
                                                                                ventanaAM.close();
                                                                                if(typeof(funcAgregar)!='undefined')
                                                                                	funcAgregar();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=74&obj='+obj,true);
																		
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

function modificarActividad()
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
                                                            html:'Actividad: <font color="red">*</font>'
                                                        },
                                                        {
                                                        	id:'txtActividad',
                                                        	x:110,
                                                            y:5,
                                                            xtype:'textfield',
                                                            width:250,
                                                            maxLength:255,
                                                            value:nodoSelActividad.text
                                                        },
                                                        {
                                                        	x:10,
                                                            y:35,
                                                            html:'Descripci&oacute;n:'
                                                        },
                                                        {
                                                        	id:'txtDescripcion',
                                                        	x:110,
                                                            y:30,
                                                            xtype:'textarea',
                                                            width:280,
                                                            height:80,
                                                            value:nodoSelActividad.descripcion
                                                        },
                                                        {
                                                        	x:10,
                                                            y:120,
                                                            html:'Fecha Inicial: <font color="red">*</font>'
                                                        },
                                                        {
                                                        	id:'dteFechaInicio',
                                                            xtype:'datefield',
                                                            x:110,
                                                            y:115,
                                                            editable:false,
                                                            format:'d/m/Y',
                                                            value:nodoSelActividad.attributes.fInicio
                                                            
                                                        },
                                                        {
                                                        	x:10,
                                                            y:145,
                                                            html:'Fecha Final: <font color="red">*</font>'
                                                        },
                                                        {
                                                        	id:'dteFechaFin',
                                                            xtype:'datefield',
                                                            x:110,
                                                            y:140,
                                                            editable:false,
                                                            format:'d/m/Y',
                                                            value:nodoSelActividad.attributes.fFin
                                                            
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Modificar actividad',
										width: 500,
										height:260,
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
                                                                	Ext.getCmp('txtActividad').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															id:'btnAceptar',
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
                                                                    	var idNodo=nodoSelActividad.id;
                                                                        var txtActividad=Ext.getCmp('txtActividad');
                                                                        var txtDescripcion=Ext.getCmp('txtDescripcion');
                                                                        var dteFechaInicio=Ext.getCmp('dteFechaInicio');
                                                                        var dteFechaFin=Ext.getCmp('dteFechaFin');
                                                                        
                                                                        if(txtActividad.getValue()=='')
                                                                        {
                                                                        	function respAct()
                                                                            {
                                                                            	txtActividad.focus();
                                                                            }
                                                                            
                                                                        	msgBox('Debe ingresar la actividad a desempe&ntilde;ar',respAct);
                                                                            return;
                                                                        }
                                                                        
                                                                        if(dteFechaInicio.getValue()=='')
                                                                        {
                                                                        	function respFechaI()
                                                                            {
                                                                            	dteFechaInicio.focus();
                                                                            }
                                                                            
                                                                        	msgBox('Debe ingresar la fecha de inicio de la actividad',respFechaI);
                                                                            return;
                                                                        }
                                                                        
                                                                        if(dteFechaFin.getValue()=='')
                                                                        {
                                                                        	function respFechaF()
                                                                            {
                                                                            	dteFechaFin.focus();
                                                                            }
                                                                            
                                                                        	msgBox('Debe ingresar la fecha final de la actividad',respFechaF);
                                                                            return;
                                                                        }
                                                                        
                                                                        if(dteFechaInicio.getValue()>dteFechaFin.getValue())
                                                                        {
                                                                        	function respFecha()
                                                                            {
                                                                            	dteFechaInicio.focus();
                                                                            }
                                                                            
                                                                        	msgBox('La fecha inicial no puede ser mayor que la fecha final',respFecha);
                                                                            return;
                                                                        }
                                                                        
                                                                        var f=new  Date(dteFechaInicio.getValue());
		
                                                                        var fechaI=f.format('Y-m-d');
                                                                        f=new  Date(dteFechaFin.getValue());
		
                                                                        var fechaF=f.format('Y-m-d');
                                                                        
																		var obj='{"idActividad":"'+idNodo+'","actividad":"'+cv(txtActividad.getValue())+'","descripcion":"'+cv(txtDescripcion.getValue())+'","fechaInicio":"'+fechaI+'","fechaFin":"'+fechaF+'"}';
                                                                        
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	var raiz=Ext.getCmp('arbolActividades');
                                                                            	raiz.getRootNode().reload();
                                                                                raiz.expandAll();
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=76&obj='+obj,true);
																		
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


function verGantt()
{
	var idFrm=gE('idFormulario').value;
    var idRef=gE('idReferencia').value;
    var param=Base64.encode('idFormulario='+idFrm+'&idReferencia='+idRef);
	window.parent.abrirVentana('../gantt/showGantt.php?param='+param);
}



/////
function mostrarVentanaActividad(conf)
{
	var arrSiNo=<?php echo $arrSiNo?>;
	var raizUsuario;
	if(conf.actividadHija==undefined)
    	raizUsuario='1';
    else
    	raizUsuario='0';
	var fechaMinI=null;
    if(conf.fechaI!=undefined)
    	fechaMinI=conf.fechaI;
    var fechaMaxI=null;
    if(conf.fechaF!=undefined)
    	fechaMaxI=conf.fechaF;
	arrDuracion=<?php echo $arrDuracion?>;
    var arrTipoActividad=<?php echo $arrTipoActividad?>;
    var cmbReportes=crearComboExt('cmbReportes',[],120,115,300);
    cmbReportes.on('select',tipoReporteChange);
    cmbReportes.getStore().loadData(arrDuracion);
    var cmbTipoActividad=crearComboExt('cmbTipoActividad',arrTipoActividad,120,50);
    var cmbSiNo=crearComboExt('cmbSiNo',arrSiNo,520,150,120);
    cmbSiNo.hide();
    var gridLineasAccion=crearGridLineasAccion();
    var gridDiasSemana=crearGridDiasSemana();
    var gridMetasEsperadas=crearGridMetasEsperadas();
    var gridProductosEsperados=crearGridProductosEsperados();
    var gridElementosCV=crearGridElementosCV();
    var cmbResponsable=crearComboExt('cmbResponsable',arrUsuarios,120,210,300);
    
    var panelObjeto=true;
    var datosAct=		{
                          title:'Datos de la actividad',
                          layout:'absolute',
                          bodyStyle: 'background-color:#DFE8F6',
                          items:	[
                                      {
                                          x:10,
                                          y:20,
                                          bodyStyle: 'background-color:#DFE8F6;border-color:#DFE8F6',
                                          html:'Actividad: <font color="red">*</font>'
                                      },
                                      {
                                          id:'txtActividad',
                                          x:120,
                                          y:15,
                                          xtype:'textfield',
                                          width:355,
                                          maxLength:255
                                      },
                                      {
                                          x:10,
                                          y:55,
                                          bodyStyle: 'background-color:#DFE8F6;border-color:#DFE8F6',
                                          html:'Prioridad: <font color="red">*</font>'
                                      },
                                      cmbTipoActividad
                                      ,
                                      {
                                      
                                          x:10,
                                          y:85,
                                          bodyStyle: 'background-color:#DFE8F6;border-color:#DFE8F6',
                                          html:'Fecha Inicial: <font color="red">*</font>'
                                      },
                                      {
                                          id:'dteFechaInicio',
                                          xtype:'datefield',
                                          x:120,
                                          y:80,
                                          editable:false,
                                          format:'d/m/Y',
                                          minValue:fechaMinI,
                                          maxValue:fechaMaxI
                                      },
                                      {
                                          x:290,
                                          y:85,
                                          bodyStyle: 'background-color:#DFE8F6;border-color:#DFE8F6',
                                          html:'Fecha Final: <font color="red">*</font>'
                                      },
                                      {
                                          id:'dteFechaFin',
                                          xtype:'datefield',
                                          x:380,
                                          y:80,
                                          editable:false,
                                          format:'d/m/Y',
                                          minValue:fechaMinI,
                                          maxValue:fechaMaxI
                                      },
                                      {
                                          x:10,
                                          y:120,
                                          bodyStyle: 'background-color:#DFE8F6;border-color:#DFE8F6',
                                          html:'Tipo de reporte:'
                                      },
                                     
                                      cmbReportes,
                                      {
                                      	  id:'lblReportar',
                                          x:10,
                                          y:155,
                                          bodyStyle: 'background-color:#DFE8F6;border-color:#DFE8F6',
                                          html:'Reportar cada:<font color="red">*</font>',
                                          hidden:false
                                      },
                                      {
										x:120,
                                        y:150,
                                        xtype:'numberfield',
                                        id:'txtDiasReporte',
                                        width:'40',
                                        allowDecimals:false,
                                        hidden:true
                                        
                                      },
                                      {
                                      	id:'lblDiasComienzo',
                                      	x:175,
                                        y:155,
                                        bodyStyle: 'background-color:#DFE8F6;border-color:#DFE8F6',
                                        html:'d&iacute;as, comenzando el d&iacute;a :',
                                        hidden:false
                                      },
                                      {
                                          id:'dteFechaInicioReporte',
                                          xtype:'datefield',
                                          x:310,
                                          y:150,
                                          width:100,
                                          editable:false,
                                          format:'d/m/Y',
                                          disabled:true,
                                          hidden:true
                                      },
                                      {
                                      	id:'lblReporteFinal',
                                      	x:420,
                                        y:155,
                                        bodyStyle: 'background-color:#DFE8F6;border-color:#DFE8F6',
                                        html:'con reporte final:',
                                        hidden:false
                                      },
                                      cmbSiNo
                                      ,
                                      {
                                      	x:10,
                                        y:190,
                                        html:'Duraci&oacute;n (hrs.):',
                                        bodyStyle: 'background-color:#DFE8F6;border-color:#DFE8F6'
                                      },
                                      {
                                      	id:'txtDuracion',
                                        x:120,
                                        y:185,
                                        xtype:'numberfield',
                                        width:40,
                                        allowDecimals:false
                                      },
                                      //gridElementosCV,
                                      {
                                      	x:10,
                                        y:215,
                                        html:'Responsable:',
                                        bodyStyle: 'background-color:#DFE8F6;border-color:#DFE8F6'
                                      },
                                      cmbResponsable
                                  ]
                                  
                      } ;
                      
                      
    var datosProductos= {
                            title:'Productos esperados',
                            layout:'absolute',
                            width:650,
                            height:530,
                            bodyStyle: 'background-color:#DFE8F6',
                            items:	[
                                    	 gridProductosEsperados
                                    ]
                            
                        }    ;
	var datosMetas= {
                            title:'Metas esperadas',
                            layout:'absolute',
                            width:650,
                            height:500,
                            bodyStyle: 'background-color:#DFE8F6',
                            items:	[
                                    	 gridMetasEsperadas
                                    ]
                            
                        }                           
                                         
    var datosObjeto=    {
                            title:'L&iacute;neas de acci&oacute;n ',
                            width:650,
                            height:500,
                            layout:'absolute',
                            hidden:true,
                            bodyStyle: 'background-color:#DFE8F6',
                            items:	[
                                        gridLineasAccion
                                    ]
                            
                        }      
   	
      var form = new Ext.form.FormPanel(	
                                          {
                                              baseCls: 'x-plain',
                                              layout:'absolute',
                                              defaultType: 'label',
                                              items: 	[
                                                          new Ext.TabPanel(	
                                                                              {
                                                                                  id:'tabContenedor',
                                                                                  activeItem:0,
                                                                                  height:540,
                                                                                  items:	[
                                                                                              datosAct,
                                                                                              datosProductos,
                                                                                              datosMetas,
                                                                                              datosObjeto
                                                                                          ]
                                                                              }
                                                                          )
                                                      ]
                                          }
                                      );
    
   	    
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar actividad',
										width: 680,
										height:540,
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
                                                                	Ext.getCmp('txtActividad').focus(false,1000);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
                                                                    	var idUsuario=cmbResponsable.getValue();
                                                                        var txtActividad=Ext.getCmp('txtActividad');
                                                                        var dteFechaInicio=Ext.getCmp('dteFechaInicio');
                                                                        var dteFechaFin=Ext.getCmp('dteFechaFin');
                                                                        var txtDuracion=Ext.getCmp('txtDuracion');
                                                                        var tActividad=cmbTipoActividad.getValue();
                                                                        var reporte=cmbReportes.getValue();
                                                                        var txtDiasReporte=Ext.getCmp('txtDiasReporte');
                                                                        var diasReporte=txtDiasReporte.getValue();
                                                                        var dteFechaInicioReporte=Ext.getCmp('dteFechaInicioReporte');
                                                                        var fechaInicioReporte=dteFechaInicioReporte.getRawValue();
                                                                        var cmbSiNo=Ext.getCmp('cmbSiNo');
                                                                        var reporteFinal=cmbSiNo.getValue();
                                                                        if(idUsuario=='')
                                                                        	idUsuario='-1';
                                                                        idUsuario=bE(idUsuario);
                                                                        if(txtActividad.getValue()=='')
                                                                        {
                                                                        	function respAct()
                                                                            {
                                                                            	txtActividad.focus();
                                                                            }
                                                                            
                                                                        	msgBox('Debe ingresar la actividad a desempe&ntilde;ar',respAct);
                                                                            return;
                                                                        }
                                                                        
                                                                        if(cmbTipoActividad.getValue()=="")
                                                                        {
                                                                          		function respTAct()
                                                                                {
                                                                                	Ext.getCmp('tabContenedor').setActiveTab(0);
                                                                                    cmbTipoActividad.focus();
                                                                                }
                                                                                msgBox('Debe indicar la prioridad de la actividad',respTAct);
                                                                                return;
                                                                          }
                                                                        
                                                                        if(dteFechaInicio.getValue()=='')
                                                                        {
                                                                        	function respFechaI()
                                                                            {
                                                                            	Ext.getCmp('tabContenedor').setActiveTab(0);
                                                                            	dteFechaInicio.focus();
                                                                            }
                                                                            
                                                                        	msgBox('Debe ingresar la fecha de inicio de la actividad',respFechaI);
                                                                            return;
                                                                        }
                                                                        
                                                                        if(dteFechaFin.getValue()=='')
                                                                        {
                                                                        	function respFechaF()
                                                                            {
                                                                            	Ext.getCmp('tabContenedor').setActiveTab(0);
                                                                            	dteFechaFin.focus();
                                                                            }
                                                                            
                                                                        	msgBox('Debe ingresar la fecha final de la actividad',respFechaF);
                                                                            return;
                                                                        }
                                                                        
                                                                        if(dteFechaInicio.getValue()>dteFechaFin.getValue())
                                                                        {
                                                                        	function respFecha()
                                                                            {
                                                                            	Ext.getCmp('tabContenedor').setActiveTab(0);
                                                                            	dteFechaInicio.focus();
                                                                            }
                                                                            
                                                                        	msgBox('La fecha inicial no puede ser mayor que la fecha final',respFecha);
                                                                            return;
                                                                        }
                                                                        
                                                                      /*  if(cmbReportes.getValue()=='')
                                                                        {
                                                                        
                                                                        	function respReportes()
                                                                            {
                                                                            	Ext.getCmp('tabContenedor').setActiveTab(0);
                                                                            	cmbReportes.focus();
                                                                            }
                                                                            
                                                                        	msgBox('Debe indicar la periodicidad de los reportes',respReportes);
                                                                            return;
                                                                        }
                                                                        */
                                                                        switch(reporte)
                                                                        {
                                                                        	
                                                                            case '3':
                                                                            case '4':
																				if(diasReporte=='')
                                                                                	diasReporte='0';
                                                                                diasReporte=parseInt(diasReporte);
                                                                                if(diasReporte<1)
                                                                                {
                                                                                	function funcRespDiasR()
                                                                                    {
                                                                                    	Ext.getCmp('tabContenedor').setActiveTab(0);
                                                                                    	txtDiasReporte.focus();
                                                                                    }
                                                                                	msgBox('El n&uacute;mero de d&iacute;as de periodicidad de reportes no es v&aacute;lido',funcRespDiasR)
                                                                                    return;
                                                                                }
                                                                                if(fechaInicioReporte=='')
                                                                                {
                                                                                	function funcRespFechaI()
                                                                                    {
                                                                                    	Ext.getCmp('tabContenedor').setActiveTab(0);
                                                                                    	dteFechaInicioReporte.focus();
                                                                                    }
                                                                                	msgBox('La fecha de inicio de reportes no es v&aacute;lido',funcRespFechaI)
                                                                                    return;
                                                                                }
                                                                                
                                                                                if(reporteFinal=='')
                                                                                {
                                                                                	function funcRespReporteF()
                                                                                    {
                                                                                    	Ext.getCmp('tabContenedor').setActiveTab(0);
                                                                                    	cmbSiNo.focus();
                                                                                    }
                                                                                	msgBox('Debe seleccionar si existir&aacute; un reporte final',funcRespReporteF)
                                                                                    return;
                                                                                }
                                                                            break;
                                                                        }
                                                                                                                                                
                                                                        /*if((txtDuracion.getValue()=='')||(txtDuracion.getValue()<1))
                                                                        {
                                                                        	function funcDuracion()
                                                                            {
                                                                            	txtDuracion.focus();
                                                                            }
                                                                        	msgBox('La duraci&oacute;n ingresada no es v&aacute;lida',funcDuracion)
                                                                            return;
                                                                        }*/
                                                                        if(txtDuracion.getValue()=='')
                                                                        {
                                                                        	txtDuracion.setValue(0);
                                                                        }
                                                                        var lAccion='';
                                                                        
                                                                        var filas=gridLineasAccion.getSelectionModel().getSelections();
                                                                        var x;
                                                                        
                                                                        for(x=0;x<filas.length;x++)
                                                                        {
                                                                            if(lAccion=='')
                                                                                lAccion=filas[x].get('idLineaAccion');
                                                                            else
                                                                                lAccion+=','+filas[x].get('idLineaAccion');
                                                                        }
                                                                        
                                                                        if((lAccion=='')&&(gridLineasAccion.getStore().getCount>0))
                                                                        {
                                                                            function resplA()
                                                                            {
                                                                                Ext.getCmp('tabContenedor').setActiveTab(1);
                                                                            }
                                                                            msgBox('Debe seleccionar las l&iacute;neas de acci&oacute;n con las cuales su actividad se vincula',resplA)
                                                                            return;
                                                                        }

                                                                        var f=new  Date(dteFechaInicio.getValue());
		                                                                var fechaI=f.format('Y-m-d');
                                                                        f=new  Date(dteFechaFin.getValue());
		                                                                var fechaF=f.format('Y-m-d');
        																var obj;
                                                                        var productos=obtenerListadoProductosEsperados();
                                                                        var metas=obtenerListadoMetasEsperadas();
                                                                        if(reporte=='')
                                                                        	reporte='NULL';
                                                                        
                                                                        var elementosCV=recoletarValoresGrid(gridElementosCV,'idProceso');
																		obj='{"tipoActividad":"'+conf.tipoActividad+'","duracion":"'+txtDuracion.getValue()+
                                                                                '","idUsuario":"'+idUsuario+'","lAccion":"'+lAccion+'","idProceso":"'+conf.idProceso+
                                                                                '","idReferencia":"'+conf.idObjeto+'","idPadre":"'+conf.idPadre+'","actividad":"'+cv(txtActividad.getValue())+
                                                                                '","fechaInicio":"'+fechaI+'","fechaFin":"'+fechaF+'","tActividad":"'+tActividad+'","reporte":"'+reporte+
                                                                                '","productos":'+productos+',"metas":'+metas+',"elementosCV":"'+elementosCV+'","raizUsuario":"'+raizUsuario+
                                                                            '","diasReporte":"'+diasReporte+'","fechaInicioReporte":"'+fechaInicioReporte+'","reporteFinal":"'+reporteFinal+'"}';                                                                        
                                                                       	
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	
                                                                                var raiz=Ext.getCmp('arbolActividades');
                                                                            	raiz.getRootNode().reload();
                                                                                raiz.expandAll();
                                                                                ventanaAM.close();
                                                                                if(typeof(funcAgregar)!='undefined')
                                                                                	funcAgregar();
                                                                                
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=87&obj='+obj,true);
																		
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
	var dteFechaInicio=Ext.getCmp('dteFechaInicio');                                
    var dteFechaFin=Ext.getCmp('dteFechaFin');
    dteFechaInicio.on('select',fechaCambiada);
    dteFechaFin.on('select',fechaCambiada);
   	//
    if(aLineasAccion==null)
    {                            
        if(conf.tipoActividad=='1')
            llenarLineasAccionLibre(ventanaAM,gridLineasAccion.getStore());
        else
            llenarLineasAccion(ventanaAM,gridLineasAccion.getStore(),conf.idProceso,conf.idObjeto);
	}
    else
    {
    	gridLineasAccion.getStore().loadData(aLineasAccion);
        ventanaAM.show();
        ocultarFilaTReporte();
    }
    //
}

function tipoReporteChange(combo,registro)
{
	switch(registro.get('id'))
    {
    	case '1':
        case '2':
        	ocultarFilaTReporte();
        break;
        case '3':
        case '4':
        	mostrarFilaTReporte();
        break;
    }
}

function mostrarFilaTReporte()
{
	var lblReportar=Ext.getCmp('lblReportar');
    var txtDiasReporte=Ext.getCmp('txtDiasReporte');
    var lblDiasComienzo=Ext.getCmp('lblDiasComienzo');
    var dteFechaInicioReporte=Ext.getCmp('dteFechaInicioReporte');
    var lblReporteFinal=Ext.getCmp('lblReporteFinal');
    var cmbSiNo=Ext.getCmp('cmbSiNo');
    
    lblReportar.show();
    txtDiasReporte.show();
    lblDiasComienzo.show();
    dteFechaInicioReporte.show();
    lblReporteFinal.show();
    cmbSiNo.show();
}

function ocultarFilaTReporte()
{
	var lblReportar=Ext.getCmp('lblReportar');
    var txtDiasReporte=Ext.getCmp('txtDiasReporte');
    var lblDiasComienzo=Ext.getCmp('lblDiasComienzo');
    var dteFechaInicioReporte=Ext.getCmp('dteFechaInicioReporte');
    var lblReporteFinal=Ext.getCmp('lblReporteFinal');
    var cmbSiNo=Ext.getCmp('cmbSiNo');
    
    lblReportar.hide();
    txtDiasReporte.hide();
    lblDiasComienzo.hide();
    dteFechaInicioReporte.hide();
    lblReporteFinal.hide();
    cmbSiNo.hide();
}

function fechaCambiada(campo,valor)
{
	var dteFechaInicio=Ext.getCmp('dteFechaInicio');                                
    var dteFechaFin=Ext.getCmp('dteFechaFin');
    var dteFechaInicioReporte=Ext.getCmp('dteFechaInicioReporte');
    if((dteFechaInicio.getRawValue()!='')&&(dteFechaFin.getRawValue()!=''))    
    {
        var fInicio=dteFechaInicio.getValue();
        var fFin=dteFechaFin.getValue();
        dteFechaInicioReporte.reset();
        dteFechaInicioReporte.setMaxValue(fFin);
        dteFechaInicioReporte.setMinValue(fInicio);
        dteFechaInicioReporte.enable();
	}   
}

function llenarLineasAccion(ventanaAM,almacen,idProceso,idRegistro)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	almacen.loadData(eval(arrResp[1]));
            
            ventanaAM.show();
            ocultarFilaTReporte();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=86&idProceso='+idProceso+'&idRegistro='+idRegistro,true);
}

var regMetaEsperada=	Ext.data.Record.create	(
                                                    [
                                                        {name: 'idMeta'},
                                                        {name: 'metaEsperada'}
                                                    ]
                                                )

var regProdEsperado=	Ext.data.Record.create	(
                                                    [
                                                        {name: 'idProducto'},
                                                        {name: 'productoEsperada'}
                                                    ]
                                                )                                                

var regElementosCV=		Ext.data.Record.create	(
                                                    [
                                                        {name: 'idProceso'},
                                                        {name: 'elementoCV'}
                                                    ]
                                                ) 

function crearGridElementosCV()
{
	dsDatos=[];
    alDatos=	new Ext.data.SimpleStore	(
                                                {
                                                    fields:	[
                                                                {name: 'idProceso'},
                                                                {name: 'elementoCV'}
                                                            ]
                                                }
                                            );

    alDatos.loadData(dsDatos);
	
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														
														{
															header:'Elemento de CV',
															width:420,
															sortable:true,
															dataIndex:'elementoCV'
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.GridPanel	(
                                                        {
                                                        	title:'Seleccione los elementos de CV con los que esta actividad se puede vincular:',
                                                            id:'gridElementosCV',
                                                            store:alDatos,
                                                            frame:true,
                                                            x:10,
                                                            y:250,
                                                            cm: cModelo,
                                                            height:170,
                                                            width:630,
                                                            
                                                            tbar:	[
                                                            			{
                                                                        	text:'Agregar elemento de CV',
                                                                            icon:'../images/add.png',
                                                                            handler:function()
                                                                            		{
                                                                                    	mostrarVentanaAgregarElementoCV();
                                                                                    }
                                                                        },
                                                                        {
                                                                        	text:'Remover elemento de CV',
                                                                            icon:'../images/delete.png',
                                                                            handler:function()
                                                                            		{
                                                                                    	var fila=tblGrid.getSelectionModel().getSelected();
                                                                                        if(fila==null)
                                                                                        {
                                                                                            msgBox('Primero debe seleccionar el elemento de CV a remover');
                                                                                            return;
                                                                                        }
                                                                                        
                                                                                        function resp(btn)
                                                                                        {
                                                                                            if(btn=='yes')
                                                                                                tblGrid.getStore().remove(fila);
                                                                                                
                                                                                        }
                                                                                        msgConfirm('Est&aacute; seguro de querer remover el elemento de CV seleccionado?',resp);
                                                                                    }
                                                                        }
                                                            		]
                                                            
                                                        }
                                                    );
	return 	tblGrid;		
}

function crearGridProductosCVSeleccion()
{
	dsDatos=<?php echo $arrProcesosCV ?>;
    alDatos=	new Ext.data.SimpleStore	(
                                                {
                                                    fields:	[
                                                                {name: 'idProceso'},
                                                                {name: 'elementoCV'}
                                                            ]
                                                }
                                            );

    alDatos.loadData(dsDatos);
	chkRow=new Ext.grid.CheckboxSelectionModel();
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),chkRow,
														{
															header:'Elemento de CV',
															width:300,
															sortable:true,
															dataIndex:'elementoCV'
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.GridPanel		(
                                                    {
                                                        title:'Seleccione los elementos de CV que desea agregar a la actividad:',
                                                        id:'gridElementosCVSel',
                                                        store:alDatos,
                                                        frame:true,
                                                        x:10,
                                                        y:10,
                                                        cm: cModelo,
                                                        sm:chkRow,
                                                        height:300,
                                                        width:390
                                                    }
                                                );
	return 	tblGrid;		
}

function crearGridMetasEsperadas()
{
	dsDatos=[];
    alDatos=	new Ext.data.SimpleStore	(
                                                {
                                                    fields:	[
                                                                {name: 'idMeta'},
                                                                {name: 'metaEsperada'}
                                                            ]
                                                }
                                            );

    alDatos.loadData(dsDatos);
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														{
															header:'Meta esperada',
															width:455,
															sortable:true,
															dataIndex:'metaEsperada'
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.GridPanel	(
                                                        {
                                                        	title:'Metas esperadas:',
                                                            id:'gridMetaEsperada',
                                                            store:alDatos,
                                                            frame:true,
                                                            x:60,
                                                            y:10,
                                                            cm: cModelo,
                                                            height:330,
                                                            width:530,
                                                            tbar:	[
                                                            			{
                                                                        	text:'Agregar meta',
                                                                            icon:'../images/add.png',
                                                                            handler:	function()
                                                                            			{
                                                                                        	mostrarVentanaAgregarMeta(tblGrid);
                                                                                        }
                                                                            
                                                                        },
                                                                        {
                                                                        	text:'Remover meta',
                                                                             icon:'../images/delete.png',
                                                                            handler:	function()
                                                                            			{
                                                                                        	var fila=tblGrid.getSelectionModel().getSelected();
                                                                                            if(fila==null)
                                                                                            {
                                                                                            	msgBox('Primero debe seleccionar la meta a remover');
                                                                                            	return;
                                                                                            }
                                                                                            
                                                                                            function resp(btn)
                                                                                            {
                                                                                            	if(btn=='yes')
                                                                                                	tblGrid.getStore().remove(fila);
                                                                                                	
                                                                                            }
                                                                                            msgConfirm('Est&aacute; seguro de querer remover la meta seleccionada?',resp);
                                                                                            
                                                                                        }
                                                                            
                                                                        }
                                                                        
                                                            		]
                                                            
                                                        }
                                                    );
	return 	tblGrid;	
}

function crearGridProductosEsperados()
{
	dsDatos=[];
    alDatos=	new Ext.data.SimpleStore	(
                                                {
                                                    fields:	[
                                                                {name: 'idProducto'},
                                                                {name: 'productoEsperado'}
                                                            ]
                                                }
                                            );

    alDatos.loadData(dsDatos);
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														{
															header:'Producto esperado',
															width:455,
															sortable:true,
															dataIndex:'productoEsperado'
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.GridPanel	(
                                                        {
                                                        	title:'Productos esperados:',
                                                            id:'gridProductosEsperados',
                                                            store:alDatos,
                                                            frame:true,
                                                            x:60,
                                                            y:10,
                                                            cm: cModelo,
                                                            height:330,
                                                            width:530,
                                                            tbar:	[
                                                            			{
                                                                        	text:'Agregar producto',
                                                                            icon:'../images/add.png',
                                                                            handler:	function()
                                                                            			{
                                                                                        	mostrarVentanaAgregarProducto(tblGrid);
                                                                                        }
                                                                            
                                                                        },
                                                                        {
                                                                        	text:'Remover producto',
                                                                             icon:'../images/delete.png',
                                                                            handler:	function()
                                                                            			{
                                                                                        	var fila=tblGrid.getSelectionModel().getSelected();
                                                                                            if(fila==null)
                                                                                            {
                                                                                            	msgBox('Primero debe seleccionar el producto a remover');
                                                                                            	return;
                                                                                            }
                                                                                            
                                                                                            function resp(btn)
                                                                                            {
                                                                                            	if(btn=='yes')
                                                                                                	tblGrid.getStore().remove(fila);
                                                                                                	
                                                                                            }
                                                                                            msgConfirm('Est&aacute; seguro de querer remover el objetivo seleccionado?',resp);
                                                                                        }
                                                                            
                                                                        }
                                                                        
                                                            		]
                                                            
                                                        }
                                                    );
	return 	tblGrid;	
}

function crearGridLineasAccion()
{
	dsDatos=[];
    alDatos=	new Ext.data.SimpleStore	(
                                                {
                                                    fields:	[
                                                                {name: 'idLineaAccion'},
                                                                {name: 'lineaAccion'},
                                                                {name: 'lineaInvestigacion'}
                                                            ]
                                                }
                                            );

    alDatos.loadData(dsDatos);
	chkRow=new Ext.grid.CheckboxSelectionModel({singleSelect:true});
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														chkRow,
														{
															header:'L&iacute;nea de acci&oacute;n',
															width:260,
															sortable:true,
															dataIndex:'lineaAccion'
														},
                                                        {
															header:'L&iacute;nea de investigaci&oacute;n',
															width:260,
															sortable:true,
															dataIndex:'lineaInvestigacion'
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                        	title:'Seleccione las l&iacute;neas de acci&oacute;n con las cuales trabajar&aacute;:',
                                                            id:'gridLineaAccion',
                                                            store:alDatos,
                                                            frame:true,
                                                            x:10,
                                                            y:10,
                                                            cm: cModelo,
                                                            height:330,
                                                            width:630,
                                                            sm:chkRow
                                                        }
                                                    );
	return 	tblGrid;		
}

function crearGridDiasSemana()
{
	dsDatos=[['1','Lunes','0'],['2','Martes','0'],['3','Mi&eacute;rcoles','0'],['4','Jueves','0'],['5','Viernes','0'],['6','S&aacute;bado','0'],['7','Domingo','0']];
    alDatos=	new Ext.data.SimpleStore	(
                                                {
                                                    fields:	[
                                                                {name: 'idDia'},
                                                                {name: 'dia'},
                                                                {name: 'porcentaje'}
                                                            ]
                                                }
                                            );

    alDatos.loadData(dsDatos);
	chkRow=new Ext.grid.CheckboxSelectionModel();
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														
														{
															header:'D&iacute;a',
															width:150,
															sortable:true,
															dataIndex:'dia'
														},
                                                        {
                                                        	header:'% de tiempo dedicado',
                                                            width:170,
															sortable:true,
															dataIndex:'porcentaje',
                                                            editor:new Ext.form.NumberField({allowDecimals:true})
                                                        }                                                      
                                                        
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {

                                                            id:'gridDiasActividad',
                                                            store:alDatos,
                                                            frame:true,
                                                            clicksToEdit:1,
                                                            columnLines:true,
                                                            x:10,
                                                            y:90,
                                                            cm: cModelo,
                                                            height:210,
                                                            width:470
                                                            
                                                        }
                                                    );
	tblGrid.on('afterEdit',sumarPorcentajes);                                                    
	return 	tblGrid;		
}

function mostrarVentanaAgregarMeta(grid)
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
                                                            html:'Ingrese la meta esperada:'
                                                        },
                                                        {
                                                        	id:'txtMeta',
                                                        	x:10,
                                                            y:35,
                                                            width:280,
                                                            height:90,
                                                            xtype:'textarea'
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar meta',
										width: 330,
										height:220,
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
                                                                	Ext.getCmp('txtMeta').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
																		if(Ext.getCmp('txtMeta').getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	Ext.getCmp('txtMeta').focus();
                                                                            }
                                                                        	msgBox('Debe ingresar la meta que espera cumplir',resp);
                                                                        	return;
                                                                        }
                                                                        var reg= new regMetaEsperada(
                                                                        								{
                                                                                                        	idMeta:'-1',
                                                                                                            metaEsperada:Ext.getCmp('txtMeta').getValue()
                                                                                                        }
                                                                        							);
                                                                       grid.getStore().add(reg); 
                                                                       ventanaAM.close();
                                                                        
                                                                        
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

function mostrarVentanaAgregarProducto(grid)
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
                                                            html:'Ingrese el producto esperado:'
                                                        },
                                                        {
                                                        	id:'txtProducto',
                                                        	x:10,
                                                            y:35,
                                                            width:280,
                                                            height:90,
                                                            xtype:'textarea'
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar producto',
										width: 330,
										height:220,
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
                                                                	Ext.getCmp('txtProducto').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
																		if(Ext.getCmp('txtProducto').getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	Ext.getCmp('txtProducto').focus();
                                                                            }
                                                                        	msgBox('Debe ingresar el producto esperado',resp);
                                                                        	return;
                                                                        }
                                                                        
                                                                        var reg= new regProdEsperado(
                                                                        								{
                                                                                                        	idProducto:'-1',
                                                                                                            productoEsperado:Ext.getCmp('txtProducto').getValue()
                                                                                                        }
                                                                        							);
                                                                       grid.getStore().add(reg); 
                                                                       ventanaAM.close();
                                                                        
                                                                        
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

function mostrarVentanaAgregarElementoCV()
{
	var gridProductosSel=crearGridProductosCVSeleccion();
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														gridProductosSel
													]
										}
									);
	
	var vent= new Ext.Window(
									{
										title: 'Agregar elemento de CV',
										width: 440,
										height:400,
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
																		var filas=gridProductosSel.getSelectionModel().getSelections();
                                                                        var gridElementosCV=Ext.getCmp('gridElementosCV');
                                                                        var x;
                                                                        var posFila;
                                                                        for(x=0;x<filas.length;x++)
                                                                        {
                                                                        	posFila=obtenerPosFila(gridElementosCV.getStore(),'idProceso',filas[x].get('idProceso'));
                                                                            if(posFila==-1)
                                                                            {
                                                                                var reg=new regElementosCV(	
                                                                                                                {
                                                                                                                    idProceso:filas[x].get('idProceso'),
                                                                                                                    elementoCV:filas[x].get('elementoCV')
                                                                                                                }
                                                                                                          )
                                                                                gridElementosCV.getStore().add(reg);			                                                                                                      
																			}                                                                                
                                                                        }
                                                                    	vent.close();
																	}
														},
														{
															text: '<?php echo $etj["lblBtnCancelar"]?>',
															handler:function()
																	{
																		vent.close();
																	}
														}
													]
									}
								);
	vent.show();	
}

function obtenerListadoMetasEsperadas()
{
	var almacenMetas=Ext.getCmp('gridMetaEsperada').getStore();
    var x;
    var arrMetas='';
    var f;
    for(x=0;x<almacenMetas.getCount();x++)
    {
    	f=almacenMetas.getAt(x);
    	objMetas='{"idMeta":"'+f.get('idMeta')+'","meta":"'+cv(f.get('metaEsperada'))+'"}';
        if(arrMetas=='')
        	arrMetas=objMetas;
        else
       		arrMetas+=','+objMetas;
        
    }
    return '['+arrMetas+']';
}

function obtenerListadoProductosEsperados()
{
	var almacenMetas=Ext.getCmp('gridProductosEsperados').getStore();
    var x;
    var arrProductos='';
    var f;
    for(x=0;x<almacenMetas.getCount();x++)
    {
    	f=almacenMetas.getAt(x);
    	objProd='{"idProducto":"'+f.get('idProducto')+'","producto":"'+cv(f.get('productoEsperado'))+'"}';
        if(arrProductos=='')
        	arrProductos=objProd;
        else
       		arrProductos+=','+objProd;
        
    }
    return '['+arrProductos+']';
}

function sumarPorcentajes(e)
{
	/*var almacen=e.grid.getStore();
    var x;
    var pTotal=0;
    var fila;
    for(x=0;x<almacen.getCount();x++)
    {
    	fila=almacen.getAt(x);
        pTotal+=parseFloat(fila.get('porcentaje'));
    }*/
    
}