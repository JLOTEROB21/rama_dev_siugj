<?php session_start();
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
	
	
	$arrLineas="[]";
	$arrLineasInv="[]";
?>
Ext.onReady(inicializar);
var g;
var aLineasAccion=null;
function inicializar()
{
	var inicializar=gE('inicializar').value;
    var sl=gE('slB64').value;
    if(inicializar=='1')
    {
        g = new JSGantt.GanttChart('g',document.getElementById('GanttDiv'), 'week');
    
        JSGantt.taskLink=function(pRef) 
                      {
	                  	  if(pRef.indexOf('|')==-1)
                        	  abrirVentana(pRef);
                          else
                          {	
                              var arrRef=pRef.split("|");
                              var idActividad=arrRef[1];
                              var arrDatos=[['idActividad',idActividad],['cPagina','mR1=fase']];
                              window.open('',"vAuxiliar", "toolbar=no,directories=no,menubar=no,status=no,scrollbars=yes,fullscreen=yes");
                              enviarFormularioDatos(arrRef[0],arrDatos,'POST','vAuxiliar');
                          }
                      }
                        
        g.setShowRes(0); // Show/Hide Responsible (0/1)
        g.setShowDur(1); // Show/Hide Duration (0/1)
        g.setCaptionType('Caption');  
        g.setShowComp(0); // Show/Hide % Complete(0/1)
        g.setShowStartDate(1); // Show/Hide Start Date(0/1)
        g.setShowEndDate(1); // Show/Hide End Date(0/1)
        g.setDateInputFormat('dd/mm/yyyy')  ;
        g.setDateDisplayFormat('dd/mm/yyyy') ;
        var idUsuario=gE('idUsuarioB64').value;
        var fIni=gE('fIniB64').value;
        var fFin=gE('fFinB64').value;
        g.setFormatArr("day","week","month","quarter") // Set format options (up to 4 : "minute","hour","day","week","month","quarter");
        JSGantt.parseXML("../gantt/obtenerProgramaTrabajo.php?u="+idUsuario+'&param='+sl+'&fIni='+fIni+'&fFin='+fFin,g);
        g.Draw();	
        g.DrawDependencies();
	}
    crearCampoFecha('spDel','fIni');
    crearCampoFecha('spAl','fFin');
}

function agregarActividadHija(idPadre)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var objDatos=eval(arrResp[1])[0];
            aLineasAccion=objDatos.lineasAcccion;
            // fechaMax:objDatos.fechaMax,
            var obj={
            			tipoActividad:objDatos.tipoAct,
                        idProceso:objDatos.idProceso,
                        idObjeto:objDatos.idObjeto,
                        idPadre:idPadre,
                        fechaI:objDatos.fechaMinI,
                        fechaMax:null,
                        fechaFinPadre:objDatos.fechaMax,
                        actividadHija:true
            		}
            
        	mostrarVentanaActividad(obj);
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
	obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=94&idActividad='+idPadre,true);
}

function agregarActividad(idPadre)
{
	aLineasAccion=null;
	var arrProcesos=[];
	var arrTipoActividad=[['1','Libre'],['2','Asociada a un objeto de un proceso']];
	var cmbTipoActividad=crearComboExt('cmbTipoActividad',arrTipoActividad,260,5);
    cmbTipoActividad.setWidth(250);
    cmbTipoActividad.on('select',actividadCambiada);
    var cmbProceso=crearComboExt('cmbProceso',arrProcesos,150,75);
    cmbProceso.setWidth(360);
    cmbProceso.on('select',buscarObjetosProceso);
    cmbProceso.hide();
    var arrTipoProceso=<?php echo $arrTiposProc ?>;
    var cmbTipoProceso=crearComboExt('cmbTipoProceso',arrTipoProceso,150,40);
    cmbTipoProceso.setWidth(360);
    cmbTipoProceso.on('select',buscarProceso);
    cmbTipoProceso.hide();
    var cmbProyecto=crearComboExt('cmbProyecto',[],150,110);
	cmbProyecto.hide();    
    cmbProyecto.setWidth(360);
    minFechaInicio=null;
	
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                        	html:'Seleccione el tipo de actividad a agregar:'
                                                        },
                                                        cmbTipoActividad,
                                                        {
                                                        	id:'selTipoProceso',
                                                        	x:10,
                                                            y:45,
                                                            html:'Tipo de proceso:',
                                                            hidden:true
                                                        },
                                                        cmbTipoProceso                                                        
                                                        ,
                                                        {
                                                        	id:'selProceso',
                                                        	x:10,
                                                            y:80,
                                                            html:'Seleccione el proceso:',
                                                            hidden:true
                                                        },
                                                        cmbProceso,
                                                        {
                                                        	id:'lblSelProyecto',
                                                        	x:10,
                                                            y:115,
                                                            html:'Seleccione el objeto:',
                                                            hidden:true
                                                           
                                                        },
                                                        cmbProyecto
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
                                    	id:'ventanaSeleccion',
										title: 'Agregar actividad',
										width: 600,
										height:130,
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
															id:'btnAceptar',
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
                                                                    	var tipoActividad=cmbTipoActividad.getValue();
                                                                        if(tipoActividad=='')
                                                                        {
                                                                        	msgBox('Debe selccionar el tipo de actividad a agregar');
                                                                            return;
                                                                        }
                                                                        var iP=idPadre;
                                                                        if(tipoActividad=='1')
                                                                        {
                                                                        	ventanaAM.close();
                                                                            var obj={
                                                                            			tipoActividad:1,
                                                                                        idProceso:-1,
                                                                                        idObjeto:-1,
                                                                                        idPadre:iP,
                                                                                        fechaI:null
                                                                                        
                                                                            		}
                                                                        	mostrarVentanaActividad(obj);
                                                                            
                                                                        }
                                                                        else
                                                                        {
                                                                        	var idProceso=cmbProceso.getValue();
                                                                            
                                                                            if(idProceso=='')
                                                                            {
                                                                            	msgBox('Debe seleccionar el proceso al cual pertenece el objeto cuya actividad desea vincular');
                                                                            	return;
                                                                            }
                                                                            
                                                                            var idObjeto=cmbProyecto.getValue();
                                                                            if(idObjeto=='')
                                                                            {
                                                                            	msgBox('Debe seleccionar el objeto al cual desea vincular la actividad');
                                                                            	return;
                                                                            }
                                                                            var nomObjeto=cmbProyecto.getRawValue();
                                                                        	ventanaAM.close();
                                                                            
                                                                            mostrarVentanaActividadesProceso(idProceso,idObjeto,idPadre,nomObjeto);
                                                                        	
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

function mostrarVentanaActividadesProceso(idProceso,idObjeto,idPadre,nomObjeto)
{
	var panelActividades=inicializarArbolActividades(idProceso,idObjeto);
    var raizUsuario;
    
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                            x:10,
                                                            y:10,
                                                            html:'Seleccione la actividad del objeto "'+nomObjeto+'" con la cual se vincular&aacute; su nueva actividad:'
                                                        },
                                                        panelActividades

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Actividades del objeto '+nomObjeto,
										width: 700,
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
                                                                    	
                                                                    	var fechaMinI;
                                                                        var arrNodosCheck=Ext.getCmp('arbolActividades').getChecked();
                                                                        if(arrNodosCheck.length==0)
                                                                        {
                                                                        	msgBox('Debe seleccionar la actividad del objeto "'+nomObjeto+'" con la cual vincular&amp; la nueva actividad');
                                                                            return;
                                                                        }
                                                                        
                                                                        var iP=arrNodosCheck[0].id;
                                                                        ventanaAM.close();
                                                                        agregarActividadHija(iP);
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
	panelActividades. on('checkchange' , nodoCheck);

    panelActividades.expandAll();                                
	ventanaAM.show();
}

function nodoCheck(nodo,check)
{
	if(check)
    {
    	var arrNodosCheck=Ext.getCmp('arbolActividades').getChecked();
        if(arrNodosCheck.length>1)
        {
        	var x;
            for(x=0;x<arrNodosCheck.length;x++)
            {
            	arrNodosCheck[x].getUI().toggleCheck(false);
            }
            nodo.getUI().toggleCheck(true);
        }
    }
}

function inicializarArbolActividades(idProc,idReg)
{
	
	var cargadorArbol=new Ext.tree.TreeLoader(
												{
													baseParams:{
																	funcion:'93',
																	idReferencia:idReg,
                                                                    idProceso:idProc
																},
													dataUrl:'../paginasFunciones/funcionesProyectos.php'
												}
											)	

    var raiz=new  Ext.tree.AsyncTreeNode	(
                                                  {
                                                      id:'-1',
                                                      text:'Actividades',
                                                      draggable:false,
                                                      expanded :true,
                                                      icon:'../images/gantt.png'
                                                      
                                                  }
                                            )

	var panelActividades=new Ext.tree.TreePanel	(
                                                  {
                                                      id:'arbolActividades',
                                                      x:10,
                                                      y:40,
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
                        
    return panelActividades;        	  
    
    
}

function buscarProceso(combo,registro,indice)
{
	var idTipoProceso=registro.get('id');
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var cmbProceso=Ext.getCmp('cmbProceso');
            cmbProceso.reset();
            var cmbProyecto=Ext.getCmp('cmbProyecto');
            cmbProyecto.reset();
            var arrProcesos=eval(arrResp[1]);
            
            if(arrProcesos.length==0)
            {
            	cmbProceso.getStore().loadData([]);   
                msgBox('No se encuntra registro de algun proceso de tipo '+combo.getRawValue()+' que incluya programa de trabajo en su estructura');
            }
            else
         		cmbProceso.getStore().loadData(arrProcesos);   
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=92&idTipoProceso='+idTipoProceso,true);
}

function buscarObjetosProceso(combo,registro,indice)
{
	var idProceso=registro.get('id');
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	
        	var cmbProyecto=Ext.getCmp('cmbProyecto');
            cmbProyecto.reset();
         	cmbProyecto.getStore().loadData(eval(arrResp[1]));   
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=85&idProceso='+idProceso,true);
    
}

function actividadCambiada(combo,registro,indice)
{
	var cmbProceso=Ext.getCmp('cmbProceso');
    var cmbProyecto=Ext.getCmp('cmbProyecto');
	var selProceso=Ext.getCmp('selProceso');
    var lblSelProyecto=Ext.getCmp('lblSelProyecto');
    var lblTipoProceso=Ext.getCmp('selTipoProceso');
    var cmbTipoProceso=Ext.getCmp('cmbTipoProceso');
    
    var ventana=Ext.getCmp('ventanaSeleccion');
	if(registro.get('id')=='1')
    {
    	cmbProceso.hide();
        cmbProyecto.hide();
        selProceso.hide();
        lblSelProyecto.hide();
        lblTipoProceso.hide();
        cmbTipoProceso.hide();
        ventana.setHeight(130);
        
    }
    else
    {
    	cmbProceso.show();
        cmbProyecto.show();
        selProceso.show();
        lblSelProyecto.show();
        lblTipoProceso.show();
        cmbTipoProceso.show();
        ventana.setHeight(240);
    }
    
    
}

var arrDuracion;
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
    var fechaMax=null;
    if(conf.fechaMax!=undefined)
    	fechaMax=conf.fechaMax;
	arrDuracion=<?php echo $arrDuracion?>;
    var arrTipoActividad=<?php echo $arrTipoActividad?>;
    var cmbReportes=crearComboExt('cmbReportes',[],120,115,300);
    cmbReportes.on('select',tipoReporteChange);
    cmbReportes.getStore().loadData(arrDuracion);
    var cmbTipoActividad=crearComboExt('cmbTipoActividad',arrTipoActividad,120,50);
    var cmbSiNo=crearComboExt('cmbSiNo',arrSiNo,520,150,120);
    cmbSiNo.hide();
    
    var gridLineasAccion=crearGridLineasAccion(conf.idPadre);
    var gridDiasSemana=crearGridDiasSemana();
    var gridMetasEsperadas=crearGridMetasEsperadas();
    var gridProductosEsperados=crearGridProductosEsperados();
    var gridElementosCV=crearGridElementosCV();
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
                                          maxValue:fechaMax
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
                                          maxValue:fechaMax
                                      },
                                      {
                                          x:10,
                                          y:120,
                                          bodyStyle: 'background-color:#DFE8F6;border-color:#DFE8F6',
                                          html:'Tipo de reporte:<font color="red">*</font>'
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
                                          editable:false,
                                          width:100,
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
                                        html:'Duraci&oacute;n (hrs.):<font color="red">*</font>',
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
                                      gridElementosCV
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
	var datosMetas= 	{
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
										height:500,
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
                                                                    	var idUsuario=gE('idUsuario').value;
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
                                                                       
                                                                        
                                                                        
                                                                        if(cmbReportes.getValue()=='')
                                                                        {
                                                                        
                                                                        	function respReportes()
                                                                            {
                                                                            	Ext.getCmp('tabContenedor').setActiveTab(0);
                                                                            	cmbReportes.focus();
                                                                            }
                                                                            
                                                                        	msgBox('Debe indicar la periodicidad de los reportes',respReportes);
                                                                            return;
                                                                        }
                                                                        
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
                                                                                                                                                
                                                                        if((txtDuracion.getValue()=='')||(txtDuracion.getValue()<1))
                                                                        {
                                                                        	function funcDuracion()
                                                                            {
                                                                            	txtDuracion.focus();
                                                                            }
                                                                        	msgBox('La duraci&oacute;n ingresada no es v&aacute;lida',funcDuracion)
                                                                            return;
                                                                        }
                                                                        var lAccion='';
                                                                        
                                                                       
                                                                        var x;
                                                                        if(conf.idPadre!=-1)
                                                                        {
	                                                                       	var filas=gridLineasAccion.getSelectionModel().getSelections();
                                                                            for(x=0;x<filas.length;x++)
                                                                            {
                                                                                if(lAccion=='')
                                                                                    lAccion=filas[x].get('idLineaAccionProy');
                                                                                else
                                                                                    lAccion+=','+filas[x].get('idLineaAccionProy');
                                                                            }
																		}
                                                                        else
                                                                        {
                                                                       	    var almacen=gridLineasAccion.getStore();
                                                                            var fila;
                                                                        	for(x=0;x<almacen.getCount();x++)
                                                                            {
                                                                            	fila=almacen.getAt(x);
                                                                                if(lAccion=='')
                                                                                    lAccion=fila.get('idLineaAccion')+'|'+fila.get('idLineaInvestigacion');
                                                                                else
                                                                                    lAccion+=','+fila.get('idLineaAccion')+'|'+fila.get('idLineaInvestigacion');
                                                                            }
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
                                                                        var elementosCV=recoletarValoresGrid(gridElementosCV,'idProceso');
																		var ajustarFechaFinPadre=0;
                                                                        
                                                                        if(conf.fechaFinPadre!=undefined)
                                                                        {
                                                                        	if(dteFechaFin.getValue()>convertirCadenaFecha(conf.fechaFinPadre))
                                                                            {
                                                                            	function respAjuste(btn)
                                                                                {
                                                                                	if(btn=='yes')
                                                                                    {
                                                                                    	ajustarFechaFinPadre='1';
                                                                                    	obj='{"ajustarFechaFinPadre":"'+ajustarFechaFinPadre+'","tipoActividad":"'+conf.tipoActividad+'","duracion":"'+txtDuracion.getValue()+
                                                                                        '","idUsuario":"'+idUsuario+'","lAccion":"'+lAccion+'","idProceso":"'+conf.idProceso+
                                                                                        '","idReferencia":"'+conf.idObjeto+'","idPadre":"'+conf.idPadre+'","actividad":"'+cv(txtActividad.getValue())+
                                                                                        '","fechaInicio":"'+fechaI+'","fechaFin":"'+fechaF+'","tActividad":"'+tActividad+'","reporte":"'+reporte+
                                                                                        '","productos":'+productos+',"metas":'+metas+',"elementosCV":"'+elementosCV+'","raizUsuario":"'+raizUsuario+
                                                                                    	'","diasReporte":"'+diasReporte+'","fechaInicioReporte":"'+fechaInicioReporte+'","reporteFinal":"'+reporteFinal+'","oPrograma":"1"}';                                                                        
                                                                                        function funcAjax()
                                                                                        {
                                                                                            var resp=peticion_http.responseText;
                                                                                            arrResp=resp.split('|');
                                                                                            if(arrResp[0]=='1')
                                                                                            {
                                                                                                ventanaAM.close();
                                                                                                recargarPagina();
                                                                                            }
                                                                                            else
                                                                                            {
                                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                            }
                                                                                        }
                                                                                        obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=87&obj='+obj,true);
                                                                                    }
                                                                                }
                                                                            	msgConfirm('La fecha fin de la actividad supera la fecha final de la actividad padre, desea ajustar la fecha final de la actividad padre?',respAjuste)
                                                                                return;
                                                                            }
                                                                        }
                                                                        
                                                                        obj='{"ajustarFechaFinPadre":"'+ajustarFechaFinPadre+'","tipoActividad":"'+conf.tipoActividad+'","duracion":"'+txtDuracion.getValue()+
                                                                                '","idUsuario":"'+idUsuario+'","lAccion":"'+lAccion+'","idProceso":"'+conf.idProceso+
                                                                                '","idReferencia":"'+conf.idObjeto+'","idPadre":"'+conf.idPadre+'","actividad":"'+cv(txtActividad.getValue())+
                                                                                '","fechaInicio":"'+fechaI+'","fechaFin":"'+fechaF+'","tActividad":"'+tActividad+'","reporte":"'+reporte+
                                                                                '","productos":'+productos+',"metas":'+metas+',"elementosCV":"'+elementosCV+'","raizUsuario":"'+raizUsuario+
                                                                            '","diasReporte":"'+diasReporte+'","fechaInicioReporte":"'+fechaInicioReporte+'","reporteFinal":"'+reporteFinal+'","oPrograma":"1"}';                                                                        
                                                                       	
                                                                        
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	ventanaAM.close();
                                                                                recargarPagina();
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
   
    if(conf.idPadre!=-1)
    {
    	gridLineasAccion.getStore().loadData(aLineasAccion);
        ventanaAM.show();
    }
    else
    	ventanaAM.show();
    ocultarFilaTReporte();
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

function llenarLineasAccion(ventanaAM,almacen,idPadre)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	almacen.loadData(eval(arrResp[1]));
            ventanaAM.show();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=86&idActividad='+idPadre,true);
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
                                                            y:220,
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
var regLineaAccion=crearRegistro(	[
										{name: 'idLineaAccionProy'},
                                        {name: 'lineaAccion'},
                                        {name: 'lineaInvestigacion'},
                                        {name:'idLineaAccion'},
                                        {name:'idLineaInvestigacion'}
									]
                                 )

function crearGridLineasAccion(idPadre)
{
	dsDatos=[];
    alDatos=	new Ext.data.SimpleStore	(
                                                {
                                                    fields:	[
                                                                {name: 'idLineaAccionProy'},
                                                                {name: 'lineaAccion'},
                                                                {name: 'lineaInvestigacion'},
                                                                {name:'idLineaAccion'},
                                                                {name:'idLineaInvestigacion'}
                                                            ]
                                                }
                                            );

    alDatos.loadData(dsDatos);
	chkRow=new Ext.grid.CheckboxSelectionModel({singleSelect:true});
	var barraTitulo=[];
    if(idPadre==-1)
    {
    	barraTitulo=[
        				{
                        	id:'btnAgregarLAccion',
                        	text:'Agregar l&iacute;nea de acci&oacute;n',
                            icon:'../images/add.png',
                            cls:'x-btn-text-icon',
                            handler:function()
                            		{
                                    	agregarLineaAccion();
                                    }
                        },
                        {
                        	text:'Remover l&iacute;nea de acci&oacute;n',
                            icon:'../images/delete.png',
                            cls:'x-btn-text-icon',
                            handler:function()
                            		{
                                    	var filas=Ext.getCmp('gridLineaAccion').getSelectionModel().getSelections();
                                        if(filas.length==0)
                                        {
                                        	msgBox('Debe seleccionar la l&iacute;nea de acci&oacute;n que desea remover');
                                            return;
                                        }
                                        function resp(btn)
                                        {
                                        	if(btn=='yes')
                                            {
                                            	Ext.getCmp('gridLineaAccion').getStore().remove(filas);
                                            }
                                        }
                                        msgConfirm('Est&aacute; seguro de querer remover las l&iacute;neas de acci&oacute;n seleccionadas?',resp);
                                    	 Ext.getCmp('btnAgregarLAccion').enable();
                                    }
                        }
        			]
    	
    }
    
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
                                                        	title:'L&iacute;neas de acci&oacute;n con las cuales se vincula a la actividad:',
                                                            id:'gridLineaAccion',
                                                            store:alDatos,
                                                            frame:true,
                                                            x:10,
                                                            y:10,
                                                            cm: cModelo,
                                                            height:330,
                                                            width:630,
                                                            sm:chkRow,
                                                            tbar:barraTitulo
                                                        }
                                                    );
	return 	tblGrid;		
}

function agregarLineaAccion()
{
	
    var cmbLineasInvestigacion=crearComboExt('cmbLineasInvestigacion',<?php echo $arrLineasInv?>,260,330);
    cmbLineasInvestigacion.setWidth(300);
    var alLineas=		new Ext.data.SimpleStore(
                                                    {
                                                        fields:	[
                                                                 	{name:'idLinea'},
                                                                    {name:'lineaAccion'}
                                                                ]
                                                    }
                                                );
    
    
    var dsLineas= <?php echo $arrLineas?>;
    
    alLineas.loadData(dsLineas);
    var chkRow=new Ext.grid.CheckboxSelectionModel({singleSelect:true});
    var cmLinea= new Ext.grid.ColumnModel   	(
                                                    [
                                                    	chkRow,
                                                        {
                                                            header:'L&iacute;nea de acci&oacute;n',
                                                            width:465,
                                                            dataIndex:'lineaAccion'
                                                        }
                                                    ]
                                                );
    
    
    var tblLineas=	new Ext.grid.GridPanel	(
                                                        {
                                                            id:'gridLineas',
                                                            store:alLineas,
                                                            frame:true,
                                                            cm: cmLinea,
                                                            height:300,
                                                            width:560,
                                                            sm:chkRow,
                                                            title:'Elija las l&iacute;neas de acci&oacute;n que desea agregar:'
                                                            
                                                        }
                                                    );
    
    
    panelGrid=new Ext.Panel	(
                                {
                                    y:5,
                                    x:5,
                                    items:	[
                                    			
                                                tblLineas
                                            ]
                                }
                            );
                            
    
    var form = new Ext.form.FormPanel(	
                                        {
                                            baseCls: 'x-plain',
                                            layout:'absolute',
                                            defaultType: 'textfield',
                                            items: 	[
                                            			{
                                                        	xtype:'label',
                                                            x:10,
                                                            y:330,
                                                            
                                                            html:'Vincular las l&iacute;neas de acci&oacute;n seleccionadas <br />con la siguiente l&iacute;nea de investigaci&oacute;n:'
                                                        },
                                                        cmbLineasInvestigacion,
                                                        panelGrid
                                                    ]
                                        }
                                    );
    
    btnSiguiente=new Ext.Button	(
                                    {
                                        text: 'Aceptar',
                                        minWidth:80,
                                        listeners:	{
                                                        click:
                                                                {
                                                                    fn:function()
                                                                    {
                                                                        var filas= tblLineas.getSelectionModel().getSelections();
                                                                        if(filas.length==0)
                                                                        {
                                                                        	Ext.MessageBox.alert('<?php echo $etj["lblAplicacion"] ?>','Debe seleccionar al menos una l&iacute;nea de acci&oacute;n');
                                                                        	return;
                                                                        }
                                                                        var idLineaInv=cmbLineasInvestigacion.getValue();
                                                                        if(idLineaInv=='')
                                                                        	idLineaInv='-1';
                                                                        var r;
                                                                        var x;
                                                                        var dSetDestino=Ext.getCmp('gridLineaAccion').getStore();
                                                                        for(x=0;x<filas.length;x++)
                                                                        {
                                                                        
                                                                        	if(!existeRegistro(filas[x].get('idLinea'),idLineaInv))
                                                                            {
                                                                                r=new regLineaAccion	(		
                                                                                                            {
                                                                                                                idLineaAccionProy:'-1',
                                                                                                                lineaAccion:filas[x].get('lineaAccion'),
                                                                                                                lineaInvestigacion:cmbLineasInvestigacion.getRawValue(),
                                                                                                                idLineaAccion:filas[x].get('idLinea'),
                                                                                                                idLineaInvestigacion:idLineaInv
                                                                                                                
                                                                                                            }
                                                                                                        )
                                                                                 dSetDestino.add(r);
                                                                        	}
                                                                        }
                                                                        Ext.getCmp('btnAgregarLAccion').disable();
                                                                        ventanaSelForm.close();
                                                                    }
                                                                }
                                                    }
                                    }
                                )
    
    ventanaSelForm = new Ext.Window(
                                            {
                                                title: 'Selecci&oacute;n de l&iacute;neas de acci&oacute;n',
                                                width: 600 ,
                                                height:460,
                                                minWidth: 300,
                                                minHeight: 100,
                                                layout: 'fit',
                                                plain:true,
                                                modal:true,
                                                bodyStyle:'padding:5px;',
                                                buttonAlign:'center',
                                                items: 	[
                                                            form
                                                        ],
                                                listeners : {
                                                            show : {
                                                                        buffer : 10,
                                                                        fn : function() 
                                                                        {
                                                          			                  
                                                                        }
                                                                    }
                                                        },
                                                buttons:	[
                                                                btnSiguiente,
                                                                {
                                                                    text: '<?php echo $etj["lblBtnCancelar"] ?>',
                                                                    handler:function()
                                                                    {
                                                                    	
                                                                        ventanaSelForm.close();
                                                                        
                                                                    }
                                                                }
                                                            ]
                                            }
                                        );
	ventanaSelForm.show();
	
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

function removerActividad(id)
{
	function resp(btn)
    {
    	if(btn=='yes')
        {
        	function funcAjax()
            {
                var resp=peticion_http.responseText;
                arrResp=resp.split('|');
                if(arrResp[0]=='1')
                {
                	recargarPagina();
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=88&idActividad='+id,true);
        }
    }
	msgConfirm('Est&aacute; seguro de querer eliminar esta actividad de su programa de trabajo?',resp);
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

function refresarPrograma()
{
	var fIni=convertirCadenaFecha(gE('fIni').value);
    var fFin=convertirCadenaFecha(gE('fFin').value);
    if(fIni>fFin)
    {
    	msgBox('La fecha de  inicio no puede ser mayor a la fecha final');
        return;
    }
    gE('fIni').value=fIni.format('Y-m-d');
    gE('fFin').value=fFin.format('Y-m-d');
    gE('frmReenvio').submit();

}

function mostrarOcultarHoras()
{
	var img=gE('imgHora');
	if(img.getAttribute('estado')=='0')
    {
    	img.src='../images/verMas2.png';
        img.title='Mostrar estadísticas de tiempo';
        img.alt='Mostrar estadísticas de tiempo';        
    	img.setAttribute('estado','1');
        oE('tblEstadisticas');
    }
    else
    {
    	img.src='../images/verMenos2.png';
        img.title='Ocultar estadísticas de tiempo';
        img.alt='Ocultar estadísticas de tiempo';                
    	img.setAttribute('estado','0');    
        mE('tblEstadisticas');        
    }
}

function existeRegistro(idLineaA,idLineaInv)
{
	var x;
    var almacen=Ext.getCmp('gridLineaAccion').getStore();
    var fila;
    for(x=0;x<almacen.getCount();x++)
    {
    	fila=almacen.getAt(x);
        if((fila.get('idLineaAccion')==idLineaA)&&(fila.get('idLineaInvestigacion')==idLineaInv))
        {
        	return true;
        }
    }
    return false;
}