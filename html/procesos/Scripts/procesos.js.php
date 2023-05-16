<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php"); 
	
	$consulta="select idTipoProceso,tipoProceso from 921_tiposProceso order by tipoProceso";
	$arrTiposProceso=uEJ($con->obtenerFilasArreglo($consulta));
?>

Ext.onReady(inicializar);

var keyMap = new Ext.KeyMap(document, 
									{
										key: 13, 
										fn: funValidar,
										scope: this
									}
							);

function funValidar()
{
	validar('frmEnvio');
}

function inicializar()
{
	var permitirFormularioDinamicos=gE('permitirFormularioDinamicos').value;
    var permitirRegistro=gE('permitirRegistro').value;
    var idProceso=gE('idProceso').value;
    var tProceso=gE('tipoProceso').value;
    if(idProceso!='-1')
    {
    	
    	var arrTabs=new Array();
        
        arrTabs[0]={
                      contentEl:'tblProceso', 
                      title:'Proceso',
                      height:500,
                      id:'tbProcesos'
                  };
        var x=1;
        if(permitirRegistro=='1')
        {        
            
            arrTabs[x]=	{
            				xtype:'panel',
                            title:'Etapas',
                            layout:'border',
                            items:	[
                            			crearGridEtapas()
                            		]
            			}
            
            
					
            x++;
		}   
             
        if(permitirFormularioDinamicos=='1')
        {
        	arrTabs[x]=	{
            				xtype:'panel',
                            title:'Formularios',
                            layout:'border',
                            items:	[
                            			crearGridFormulariosTabla()
                            		]
            			}
           
            x++;            
        }
        
        if(tProceso!='1')
        {        
            arrTabs[x]={
                          
                          id:'tbMenus',
                          region:'center',
                          layout:'border',
                          items:	[
                          				inicializarTablaMenus('center')
                          			],
                          title:'Configuraci&oacute;n de Men&uacute;s'
                      } ;
            x++;
           
		      
           
		}  
        
       
        var tabActivo=gE('tabActivo').value;
        var tabs = new Ext.TabPanel({
                                    renderTo: 'tabProcesos',
                                    activeTab: parseInt(tabActivo),
                                    cls:'tabPanelSIUGJ',
                                    width:980,
                                    border:false,
                                    height:500,
                                    listeners:	{
                                    				tabchange:function(tab,panel)
                                                    			{
                                                                	switch(panel.id)
                                                                    {
                                                                    	case 'tbProcesos':	
                                                                        	actualizarTabActivo(0);
                                                                        	
                                                                        break;
                                                                        case 'tbEtapas':	
                                                                        	gEx('grid_tblTablaEtapa').getView().refresh();
                                                                            
                                                                            actualizarTabActivo(1);
                                                                        break;
                                                                        case 'tbFormulario':	
                                                                        	actualizarTabActivo(2);
                                                                            gEx('grid_tblTablaFormularios').getView().refresh();
                                                                            
                                                                        	
                                                                        break;
                                                                        case 'tbMenus':	
                                                                        	actualizarTabActivo(3);
                                                                        	
                                                                        break;
                                                                        
                                                                    }
                                                                }
                                    			},
                                    items:	arrTabs
                                    
                                    });
	}                                    
    else
    {
    	
        var tabs = new Ext.TabPanel({
                                    renderTo: 'tabProcesos',
                                    activeTab: 0,
                                    width:980,
                                    border:false,
                                    cls:'tabPanelSIUGJ',
                                    height:500,
                                    items:	[	 
                                                {
                                                    contentEl:'tblProceso', 
                                                    title:'Procesos'
                                                }
                                            ]
                                    
                                    });
    }
    try
    {
		gE('_nombrevch').focus();
    }
    catch(e)
    {
    	
    }
    
}

function validar(formulario)
{
	if(validarFormularios(formulario))
	{
    
    	var oConf={};
        oConf.tabla='4001_procesos';
        oConf.campoBusqueda='cveProceso';
        oConf.valor=gE('_cveProcesovch').value;
        oConf.campoIRegistro='idProceso';
        oConf.iRegistroIgnorar=gEN('id')[0].value;
        oConf.functionExisteRegistro=function()
                                    {
                                        function respAux()
                                        {
                                            gE('_cveProcesovch').focus();
                                        }
                                        msgBox('La clave del proceso ingresada ya ha sido registrada anteriormente',respAux);
                                    
                                    }

         oConf.functionNoExisteRegistro=function()
                                    {
                                        gE(formulario).submit();
                                    }
        
        validarNoExistenciaRegistro(oConf)
    
    
    
		
	}
}

function enviarEtapa(idEtapa)
{
    var idProceso=gE('hIdProceso').value;
    var arrParam=[['idEtapa',idEtapa],['idProceso',idProceso]];
	enviarFormularioDatos('etapas.php',arrParam);
}

function eliminarEtapa(idEtapa)
{
	function resp(btn)
    {
        if(btn=='yes')
        {
            function funcAjax()
            {
                var resp=peticion_http.responseText;
                arrResp=resp.split('|');
                if((arrResp[0]=='1')||(arrResp[0]==1))
                {
                    var fila=gE('fila_'+bD(idEtapa));
                    fila.parentNode.removeChild(fila);
                }
                else
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
            }
            obtenerDatosWeb('../paginasFunciones/funcionesAdministracion.php',funcAjax, 'POST','funcion=20&idEtapa='+idEtapa,true);
        }
    }
    Ext.MessageBox.confirm(lblAplicacion,'&iquest;Est&aacute; seguro de querer eliminar esta Etapa?, esta acci&oacute;n eliminar&aacute; todas aquellas configuraciones asociadas a la etapa',resp)
}

function eliminarFormulario(idElemento)
{
    function respPregunta(btn)
	{
		if(btn=='yes')
		{
			function funcResp()
			{
				var arrResp=peticion_http.responseText.split('|');
				if(arrResp[0]=='1')
				{
                	var filaDel=gE('fila_'+idElemento);
                    filaDel.parentNode.removeChild(filaDel);
                    
				}
				else
				{
					 msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);				}
			}
			obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcResp, 'POST','funcion=44&idFormulario='+idElemento,true);
		}
	}
	Ext.MessageBox.confirm('<?php echo $etj["lblAplicacion"] ?>','<?php echo $etj["msgConfirmDel"] ?>',respPregunta);
}

function nuevoFormulario()
{
	var idProceso=gE('idProceso').value;
    var arrParam=[['idFormulario','-1'],['idProceso',idProceso]];
    enviarFormularioDatos('../modeloPerfiles/formularios.php',arrParam);
    
}

function modificarFormulario(idElemento)
{
    var idProceso=gE('idProceso').value;
	var arrParam=[['idFormulario',idElemento],['idProceso',idProceso]];
    enviarFormularioDatos('../modeloPerfiles/formularios.php',arrParam);
}


function configurarProcesoCita()
{
	var idProceso=gE('idProceso').value;
	var arrParam=[['idProceso',idProceso]];
    enviarFormularioDatos('../modeloCitas/configurarProcesoCita.php',arrParam);
}


function configurarProcesoProyecto()
{
	var idProceso=gE('idProceso').value;
	var arrParam=[['hAccion','1'],['hTArticulo','1'],['hId','1'],['idProceso',idProceso],['cPagina','sFrm=true'],['vistaIframe',1]];
    
    if(window.parent)
    {
    	var obj={};
        obj.ancho='100 %';
        obj.alto='100 %';
        obj.url='../modeloProyectos/cfgDTD.php';
        obj.params=arrParam;
        window.parent.abrirVentanaFancy(obj);
        
        
    }
    else
	    enviarFormularioDatos('../modeloProyectos/cfgDTD.php',arrParam);
}

function modificarProcesoProyecto()
{
	var idProceso=gE('idProceso').value;
	var arrParam=[['hAccion','1'],['hTArticulo','1'],['hId',idProceso]];
    enviarFormularioDatos('../modeloProyectos/cfgDTD.php',arrParam);
}


function configurarProcesoPAT()
{
	var idProceso=gE('idProceso').value;
    var arrParam=[['idProceso',idProceso]];
    enviarFormularioDatos('../modeloProyectos/confPresupuesto.php',arrParam);
}

function  configurarProcesoConvocatoriaFrmDinamico()
{
	var idProceso=gE('idProceso').value;
    var arrParam=[['idProceso',idProceso]];
    enviarFormularioDatos('../modeloProyectos/confConvocatoriaFD.php',arrParam);
    
}

function clonarFormulario()
{
	var arrTiposProc=<?php echo $arrTiposProceso?>;
	var cmbTipoProceso=crearComboExt('cmbTipoProceso',arrTiposProc,120,5);
    cmbTipoProceso.setWidth(350);
    cmbTipoProceso.on('select',cmbTipoProcesoChange);
	var cmbProceso=crearComboExt('cmbProceso',[],120,35);
    cmbProceso.setWidth(300);
    cmbProceso.on('select',cmbProcesoChange);
    var gridFormularios=crearGridFormularios();
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                        	html:'Tipo de proceso:'
                                                        },
                                                        cmbTipoProceso,
                                                        {
                                                        	x:10,
                                                            y:40,
                                                        	html:'Proceso:'
                                                        },
                                                        cmbProceso,
                                                        {
                                                        	x:10,
                                                            y:70,
                                                        	html:'Seleccione los formularios que desea clonar:'
                                                        },
                                                        gridFormularios

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Clonar formulario',
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
                                                                    	var idProceso=gE('idProceso').value;
																		var filas=gridFormularios.getSelectionModel().getSelections();
                                                                        if(filas.length==0)
                                                                        {
                                                                        	msgBox('Al menos debe seleccionar un formulario para clonar');
                                                                        	return;
                                                                        }
                                                                        var x;
                                                                        var cadFrm='';
                                                                        for(x=0;x<filas.length;x++)
                                                                        {
                                                                        	if(cadFrm=='')
                                                                            	cadFrm=filas[x].get('idFormulario');
                                                                            else
                                                                            	cadFrm+=','+filas[x].get('idFormulario');
                                                                        }
                                                                        
                                                                        var obj='{"idProceso":"'+idProceso+'","formularios":"'+cadFrm+'"}';
                                                                        
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
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=125&obj='+obj,true);
                                                                        
                                                                        
                                                                        
                                                                        
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

function cmbTipoProcesoChange(combo,registro)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	Ext.getCmp('cmbProceso').getStore().loadData(eval(arrResp[1]));
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=123&tP='+registro.get('id'),true);
    
	
}

function cmbProcesoChange(combo,registro)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	Ext.getCmp('gridFormularios').getStore().loadData(eval(arrResp[1]));
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=124&proc='+registro.get('id'),true);
}

function crearGridFormularios()
{
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'idFormulario'},
                                                                    {name: 'nombre'},
                                                                    {name: 'descripcion'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel();
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														chkRow,
														{
															header:'Nombre formulario',
															width:250,
															sortable:true,
															dataIndex:'nombre'
														},
														{
															header:'Descripci&oacute;n',
															width:400,
															sortable:true,
															dataIndex:'descripcion'
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gridFormularios',
                                                            store:alDatos,
                                                            frame:true,
                                                            y:100,
                                                            cm: cModelo,
                                                            height:260,
                                                            width:750,
                                                            sm:chkRow
                                                        }
                                                    );
	return 	tblGrid;		
}

function agregarCategoria(accion,cadObj)
{
    var nCategoria='';
    var numCategoria='';
    var descripcion='';
    if(cadObj!=undefined)
    {
    	var obj=eval(bD(cadObj))[0];
        nCategoria=obj.nCategoria;
        numCategoria=obj.numCategoria;
        descripcion=obj.descripcion;
    }
    
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	html:'N&uacute;m. categor&iacute;a:',
                                                            x:10,
                                                            y:10
                                                        },
                                                        {
                                                        	x:140,
                                                            y:5,
                                                        	xtype:'numberfield',
                                                            id:'txtNumCategoria',
                                                            width:80,
                                                            allowDecimals:true,
                                                            allowNegative:false,
                                                            value:numCategoria
                                                        },
                                                        {
                                                        	html:'Nombre categor&iacute;a:',
                                                            x:10,
                                                            y:40
                                                        },
                                                        {
                                                        	x:140,
                                                            y:35,
                                                        	xtype:'textfield',
                                                            id:'txtNomCategoria',
                                                            width:250,
                                                            value:nCategoria
                                                        },
                                                        {
                                                        	html:'Descripci&oacute;n:',
                                                            x:10,
                                                            y:70
                                                        },
                                                        {
                                                        	x:140,
                                                            y:65,
                                                        	xtype:'textarea',
                                                            width:300,
                                                            height:100,
                                                            id:'txtDescripcion',
                                                            value:descripcion
                                                        }
                                                        

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar categor&iacute;a',
										width: 470,
										height:270,
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
                                                                	Ext.getCmp('txtNumCategoria').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
                                                                    	var idProceso=gE('hIdProceso').value;
                                                                    	var txtNumCategoria=Ext.getCmp('txtNumCategoria');
                                                                        var idConf=gE('nConfActual').value;
                                                                        if(txtNumCategoria.getValue()=='')
                                                                        {
                                                                        	function respCat()
                                                                            {
                                                                            	Ext.getCmp('txtNumCategoria').focus();
                                                                            }
																			msgBox('Debe ingresar el n&uacute;mero de la categor&iacute; a agregar',respCat);
                                                                        	return false;
                                                                        }
                                                                        
                                                                        var txtNomCategoria=Ext.getCmp('txtNomCategoria');
                                                                        if(txtNomCategoria.getValue()=='')
                                                                        {
                                                                        	function respCat()
                                                                            {
                                                                            	Ext.getCmp('txtNomCategoria').focus();
                                                                            }
																			msgBox('Debe ingresar el nombre de la categor&iacute; a agregar',respCat);
                                                                        	return false;
                                                                        }
                                                                    
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
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=159&idConf='+idConf+'&numCategoria='+cv(txtNumCategoria.getValue())+'&nCategoria='+cv(txtNomCategoria.getValue())+'&idProceso='+idProceso+'&idCategoria='+accion+'&descripcion='+cv(gEx('txtDescripcion').getValue()),true);
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

function eliminarCategoria(iC)
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
                	var fila=gE('filaCat_'+bD(iC));
                    fila.parentNode.removeChild(fila);
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=160&iC='+iC,true);
        }
    }
    msgConfirm('Est&aacute; seguro de querer remover la categor&iacute;a seleccionada?',resp)
}

function crearPerfil()
{
	var idProceso=gE('idProceso').value;
	var arrDatos=[['idPerfil','-1'],['idProceso',idProceso]];
    enviarFormularioDatos('../modeloPerfiles/perfilExportacion.php',arrDatos);
}

function modificarPerfil(iP)
{
	var idProceso=gE('idProceso').value;
	var arrDatos=[['idPerfil',bD(iP)],['idProceso',idProceso]];
    enviarFormularioDatos('../modeloPerfiles/perfilExportacion.php',arrDatos);

}

function eliminarPerfil(iP)
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
                	var fila=gE('fila_'+bD(iP));
                    fila.parentNode.removeChild(fila);
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=49&idPerfil='+iP,true);
            
        }
    }
    msgConfirm('Est&aacute; seguro de querer eliminar el perfil de exportacion seleccionado',resp)
}

function configurarProcesoRegistroUsr()
{
	var idProceso=gE('idProceso').value;
	var arrParam=[['idProceso',idProceso]];
    enviarFormularioDatos('../modeloProyectos/cfgProcesoRegistro.php',arrParam);	
}


function crearGridMacroProcesos()
{
	var dsDatos=eval(bD(gE('arrMacro').value));
    
    var alDatos=	new Ext.data.SimpleStore	(
                                                {
                                                    fields:	[
                                                    			{name: 'idMacroProceso'},
                                                                {name: 'macroproceso'},
                                                                {name: 'etiqueta'}
                                                            ]
                                                }
                                            );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel({singleSelect:true});
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														chkRow,
														{
															header:'Macroproceso',
															width:200,
															sortable:true,
															dataIndex:'macroproceso'
														},
														{
															header:'Leyenda',
															width:300,
															sortable:true,
															dataIndex:'etiqueta'
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gridMacro',
                                                            store:alDatos,
                                                            frame:false,
                                                            renderTo:'gridMacro2',
                                                            cm: cModelo,
                                                            height:300,
                                                            width:650,
                                                            sm:chkRow,
                                                            tbar:	[
                                                            			{
                                                                        	icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Agregar macroproceso',
                                                                            handler:function()
                                                                            		{
                                                                                    	mostrarVentanaMacroProceso();
                                                                                    }
                                                                            
                                                                        },'-',
                                                                        {
                                                                        	icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Remover macroproceso',
                                                                            handler:function()
                                                                            		{
                                                                                    	var filas=tblGrid.getSelectionModel().getSelected();
                                                                                        if(filas==null)
                                                                                        {
                                                                                        	msgBox('Debe seleccionar el macroproceso a remover');
                                                                                        	return;
                                                                                        }
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
                                                                                                     	tblGrid.getStore().remove(filas);   
                                                                                                    }
                                                                                                    else
                                                                                                    {
                                                                                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                    }
                                                                                                }
                                                                                                obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=75&idProceso='+gE('hIdProceso').value+'&idMacroProceso='+filas.get('idMacroProceso'),true);
                                                                                                
                                                                                            }
                                                                                        	
                                                                                        }
                                                                                        msgConfirm('Est&aacute; seguro de querer remover el macroproceso seleccionado?',resp);
                                                                                    }
                                                                            
                                                                        }
                                                                        
                                                            		]
                                                        }
                                                    );
	return 	tblGrid;	
}

function mostrarVentanaMacroProceso()
{
	var cmbMacroProceso=crearComboExt('cmbMacroProceso',[],145,5,300);
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:'Macroproceso a agregar:'
                                                            
                                                        },
                                                        cmbMacroProceso,
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            html:'Leyenda:'
                                                        },
                                                        {
                                                        	x:145,
                                                            y:35,
                                                            xtype:'textfield',
                                                            width:300,
                                                            id:'txtLeyenda',
                                                            value:gE('_nombrevch').value
                                                        }

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar Macroproceso',
										width: 500,
										height:150,
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
																		if(cmbMacroProceso.getValue()=='')
                                                                        {
                                                                        	msgBox('Debe seleccionar el macroproceso a agregar');
                                                                            return;
                                                                        }
                                                                        var txtLeyenda=gEx('txtLeyenda');
                                                                        if(txtLeyenda.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	gEx('txtLeyenda').focus();
                                                                            }
                                                                        	msgBox('La leyenda ingresada no e v&aacute;lida',resp);
                                                                        	return;
                                                                        }
                                                                        
                                                                        var gridMacro=gEx('gridMacro');
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                                var arrDatos=eval(arrResp[1]);
                                                                                gridMacro.getStore().loadData(arrDatos);
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=74&idProceso='+gE('hIdProceso').value+'&idMacroProceso='+cmbMacroProceso.getValue()+'&leyenda='+cv(txtLeyenda.getValue()),true);
                                                                        
                                                                        
                                                                        
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
	llenarMacroProcesos(ventanaAM);
}

function llenarMacroProcesos(ventana)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var arrDatos=eval(arrResp[1]);
            gEx('cmbMacroProceso').getStore().loadData(arrDatos);
            ventana.show();	
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=73&idProceso='+gE('hIdProceso').value,true);

	
}

function actualizarTabActivo(nTab)
{
	function funcAjax(peticion_http)
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        		
        }
        else
        {
           
        }
    }
    obtenerDatosWebV2('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=348&iT='+nTab+'&c='+gEN('configuracion')[1].value,false);
}


function crearGridEtapas()
{
    var chkRow=new Ext.grid.CheckboxSelectionModel({singleSelect:true,checkOnly :true,width:40});
    var camposJava=new Array( {name:'idEtapa'},{name:'numEtapa'},{name:'nombreEtapa'},{name:'marcaFinProceso'});
    var columnasJava=new Array(new  Ext.grid.RowNumberer({width:60}),chkRow,	{
        header:'',
        width:100,
        sortable:true,
        dataIndex:'idEtapa',
        align:'left',
        renderer:function (val)
                {
                    return val;
                },
        hidden:true,
        editor:null
        
    },	{
        header:'N&uacute;mero de Etapa',
        width:180,
        sortable:true,
        dataIndex:'numEtapa',
        align:'left',
        renderer:removerCerosDerecha,
        hidden:false,
        editor:null
        
    },	{
        header:'Nombre de la Etapa',
        width:500,
        sortable:true,
        dataIndex:'nombreEtapa',
        align:'left',
        renderer:function (val)
                {
                    return val;
                },
        hidden:false,
        editor:null
        
    },	{
        header:'Fin de Proceso',
        width:135,
        sortable:true,
        dataIndex:'marcaFinProceso',
        align:'left',
        renderer:function (val)
                {
                    return val;
                },
        hidden:false,
        editor:null
        
    });
    var dsTablaRegistros = new Ext.data.JsonStore	(
                                                            {
                                                                root: 'registros',
                                                                totalProperty: 'numReg',
                                                                idProperty: 'idEtapa',
                                                                fields: camposJava,
                                                                remoteSort:true,
                                                                autoLoad:true,
                                                                proxy: new Ext.data.HttpProxy	(
                                                                                                    {
                                                                                                        url: '../paginasFunciones/funcionesProyectos.php',
                                                                                                        timeout :600000
                                                                                                    }
                                                                                                )
                                                            }
                                                        );																	
    var filters = new Ext.ux.grid.GridFilters	(
                                                    {
                                                        filters:	[ {type: 'string', dataIndex: 'idEtapa'},{type: 'string', dataIndex: 'numEtapa'},{type: 'string', dataIndex: 'nombreEtapa'},{type: 'string', dataIndex: 'marcaFinProceso'}]
                                                    }
                                                );                                                    
                                    
    dsTablaRegistros.setDefaultSort('numEtapa', 'ASC');
    
    function cargarDatos(proxy,parametros)
    {
        proxy.baseParams.funcion=364;
        proxy.baseParams.idProceso=gE('idProceso').value
        
        
    }                                      
                                                    
    dsTablaRegistros.on('beforeload',cargarDatos);                                                 
    var modelColumn= new Ext.grid.ColumnModel   	(
                                                        columnasJava
                                                    );
    var tamPagina =	100;     
                                                                            
    var paginador=	new Ext.PagingToolbar	(
                                                {
                                                      pageSize: tamPagina,
                                                      store: dsTablaRegistros,
                                                      displayInfo: true,
                                                      disabled:false
                                                  }
                                               )                                                    
    
    
                                        
    var gridRegistros=	new Ext.grid.EditorGridPanel	(
                                                  {
                                                      id:'grid_tblTablaEtapa',
                                                      store:dsTablaRegistros,
                                                      cls:'gridSiugj',
                                                      frame:false,
                                                      border:true,
                                                      cm: modelColumn,
                                                      sm:chkRow,
                                                      region:'center',
                                                      trackMouseOver:false,
                                                      loadMask: true,
                                                      plugins: [filters],
                                                      enableColLock: false,
                                                      stripeRows:true,
                                                      clicksToEdit:1,
                                                      columnLines:true,
                                                      bbar: [paginador]
                                                      ,"tbar":[	{
                                                                    id:"btnAgregar",
                                                                    text:"Agregar Etapa",
                                                                    icon:"../principalPortal/imagesSIUGJ/add.png",
                                                                    hidden:false,
                                                                    disabled:false,
                                                                    cls:"x-btn-text-icon",
                                                                    handler:function()
                                                                            {
                                                                                
                                                                        var arrDatos=[['idEtapa','-1'],['idProceso',gE('idProceso').value]];
                                                                        enviarFormularioDatos('../procesos/etapas.php',arrDatos);
                                                                        
                                                                    
                                                                            }
                                                                }, 
                                                                {
                                                                    xtype:'tbspacer',
                                                                    width:30
                                                                }
                                                          ,		{
                                                                    id:"btnModificar",
                                                                    text:"Modificar Etapa",
                                                                    icon:"../principalPortal/imagesSIUGJ/pencil.png",
                                                                    hidden:false,
                                                                    disabled:false,
                                                                    cls:"x-btn-text-icon",
                                                                    handler:function()
                                                                            {
                                                                                
                                                                        var gridDestino=gEx('grid_tblTablaEtapa');
                                                                        var fila=gridDestino.getSelectionModel().getSelected();
                                                                        if(fila==null)
                                                                        {
                                                                            msgBox('Primero debe seleccionar el elemento a modificar');
                                                                            return;
                                                                        }
                                                                        var id=fila.get('idEtapa');
                                                                        var arrDatos=[['idEtapa',id]];
                                                                        enviarFormularioDatos('../procesos/etapas.php',arrDatos);
                                                                        
                                                                    
                                                                            }
                                                                }, 
                                                                {
                                                                    xtype:'tbspacer',
                                                                    width:30
                                                            	}
                                                          ,		{
                                                                    id:"btnRemover",
                                                                    text:"Remover Etapa",
                                                                    icon:"../principalPortal/imagesSIUGJ/delete.png",
                                                                    hidden:false,
                                                                    disabled:false,
                                                                    cls:"x-btn-text-icon",
                                                                    handler:function()
                                                                            {
                                                                                
                                                                                var gridDestino=gEx('grid_tblTablaEtapa');
                                                                                var fila=gridDestino.getSelectionModel().getSelected();
                                                                                if(fila==null)
                                                                                {
                                                                                    msgBox('Primero debe seleccionar el elemento que desea eliminar');
                                                                                    return;
                                                                                }
                                                                                
                                                                                function resp(btn)
                                                                                {
                                                                                    if(btn=='yes')
                                                                                    {
                                                                                        var id=fila.get('idEtapa');
                                                                                        var idReferencia=fila.get('idEtapa');
                                                                                        function funcAjax()
                                                                                        {
                                                                                            var resp=peticion_http.responseText;
                                                                                            arrResp=resp.split('|');
                                                                                            if(arrResp[0]=='1')
                                                                                            {
                                                                                                gridDestino.getStore().remove(fila);
                                                                                            }
                                                                                            else
                                                                                            {
                                                                                                msgBox('No se ha podido llevar cabo la operaci&oacute;n debido al siguiente problema: <br /><br>'+arrResp[0]);
                                                                                            }
                                                                                        }
                                                                                        obtenerDatosWeb('../paginasFunciones/funcionesGridDinamico.php',funcAjax, 'POST','funcion=2&tblVal=&msgError=La etapa&tb=NDAzN19ldGFwYXM=&id='+id+'&idReferencia='+idReferencia+'&cId=aWRFdGFwYQ==',true);
                                                                                    }
                                                                                }
                                                                                msgConfirm('Est&aacute; seguro de querer eliminar el elemento seleccionado?',resp);
                                                                        
                                                                    
                                                                            }
                                                                }
                                                      ],
            view: 	new Ext.grid.GridView	(
                                              {
                                                  
                                                  showGroupName: false
                                              }   
                                          )
            
                                                  }
                                              );
    gridRegistros.on('beforeedit',function(e)
                        {
                            
                            if(typeof(gridBeforeEdit)!='undefined')
                            {
                                gridBeforeEdit(e);
                            }
                        }
        )		
    gridRegistros.on('afteredit',function(e)
                    {
                        
                        if(typeof(gridAfterEdit)!='undefined')
                        {
                            gridAfterEdit(e);
                        }
                    }
        )
    
                                                      
    
    
    return gridRegistros;
		
					
					
					
}


function crearGridFormulariosTabla()
{
      
      var chkRow=new Ext.grid.CheckboxSelectionModel({singleSelect:true,checkOnly :true,width:40});
      var camposJava=new Array( {name:'idFormulario'},{name:'nombreFormulario'},{name:'descripcion'},{name:'fechaCreacion'});
      var columnasJava=new Array(new  Ext.grid.RowNumberer({width:60}),chkRow,	
                                                              {
                                                                  header:'ID del Formulario',
                                                                  width:100,
                                                                  sortable:true,
                                                                  dataIndex:'idFormulario',
                                                                  align:'left',
                                                                  renderer:function (val)
                                                                          {
                                                                              return val;
                                                                          },
                                                                  hidden:true
                                                                  
                                                              },	
                                                              {
                                                                  header:'Nombre del Formulario',
                                                                  width:250,
                                                                  sortable:true,
                                                                  dataIndex:'nombreFormulario',
                                                                  align:'left',
                                                                  renderer:function (val)
                                                                          {
                                                                              return val;
                                                                          },
                                                                  hidden:false
                                                                  
                                                              },	
                                                              {
                                                                  header:'Descripci&oacute;n',
                                                                  width:450,
                                                                  sortable:true,
                                                                  dataIndex:'descripcion',
                                                                  align:'left',
                                                                  renderer:mostrarValorDescripcion,
                                                                  hidden:false
                                                                  
                                                              },	
                                                              {
                                                                  header:'Fecha de Creaci&oacute;n',
                                                                  width:180,
                                                                  sortable:true,
                                                                  dataIndex:'fechaCreacion',
                                                                  align:'left',
                                                                  renderer:function(val)
                                                                          {
                                                                              if(val=='')
                                                                                  return '';
                                                                              var arrDatosFecha=val.split(' ');
                                                                              
                                                                              var arrFecha=(arrDatosFecha[0]+'').split('-');
                                                                              return arrFecha[2]+'/'+arrFecha[1]+'/'+arrFecha[0];	
                                                                          },
                                                                  hidden:false
                                                                  
                                                              });
      var dsTablaRegistros = new Ext.data.JsonStore	(
                                                              {
                                                                  root: 'registros',
                                                                  totalProperty: 'numReg',
                                                                  idProperty: 'idFormulario',
                                                                  fields: camposJava,
                                                                  remoteSort:true,
                                                                   autoLoad:true,
                                                                  proxy: new Ext.data.HttpProxy	(
                                                                                                      {
                                                                                                          url: '../paginasFunciones/funcionesProyectos.php',
                                                                                                          timeout :600000
                                                                                                      }
                                                                                                  )
                                                              }
                                                          );																	
      var filters = new Ext.ux.grid.GridFilters	(
                                                    {
                                                          filters:	[ {type: 'string', dataIndex: 'idFormulario'},{type: 'string', dataIndex: 'nombreFormulario'},{type: 'string', dataIndex: 'descripcion'},{type: 'string', dataIndex: 'fechaCreacion'}]
                                                      }
                                     			 );                                                    
                                      
      dsTablaRegistros.setDefaultSort('nombreFormulario', 'ASC');
      
      function cargarDatos(proxy,parametros)
      {
          proxy.baseParams.funcion=365;
          proxy.baseParams.idProceso=gE('idProceso').value
          
          
          
      }                                      
                                                      
      dsTablaRegistros.on('beforeload',cargarDatos);                                                 
      var modelColumn= new Ext.grid.ColumnModel   	(
                                                          columnasJava
                                                      );
      var tamPagina =	100;     
                                                                              
      var paginador=	new Ext.PagingToolbar	(
                                                  {
                                                        pageSize: tamPagina,
                                                        store: dsTablaRegistros,
                                                        displayInfo: true,
                                                        disabled:false
                                                    }
                                                 )                                                    
      
      
                                          
    var gridRegistros=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'grid_tblTablaFormularios',
                                                            store:dsTablaRegistros,
                                                            cls:'gridSiugj',
                                                            frame:false,
                                                            border:true,
                                                            cm: modelColumn,
                                                            sm:chkRow,
                                                            region:'center',
                                                            trackMouseOver:false,
                                                            loadMask: true,
                                                            plugins: [filters],
                                                            enableColLock: false,
                                                            stripeRows:true,
                                                            clicksToEdit:1,
                                                            columnLines:true,
                                                            bbar: [paginador],
                                                            tbar:[		
                                                            			{
                                                                              id:"btn_1F",
                                                                              text:"Crear Formulario",
                                                                              icon:"../principalPortal/imagesSIUGJ/add.png",
                                                                              hidden:false,
                                                                              disabled:false,
                                                                              cls:"x-btn-text-icon",
                                                                              handler:function()
                                                                                      {
                                                                                          var arrDatos=[['idFormulario','-1'],['idProceso',gE('idProceso').value]];
                                                                                          enviarFormularioDatos('../modeloPerfiles/formularios.php',arrDatos);
                                                                                      }
                                                                          }, 
                                                                          {
                                                                              xtype:'tbspacer',
                                                                              width:30
                                                                      	},
                                                                    	{
                                                                              id:"btn_3F",
                                                                              text:"Modificar Formulario",
                                                                              icon:"../principalPortal/imagesSIUGJ/pencil.png",
                                                                              hidden:false,
                                                                              disabled:false,
                                                                              cls:"x-btn-text-icon",
                                                                              handler:function()
                                                                                      {
                                                                                          
                                                                                          
                                                                                          
                                                                                          
                                                                                          var fila=gridRegistros.getSelectionModel().getSelected();
                                                                                          
                                                                                          if(fila==null)
                                                                                          {
                                                                                              msgBox('Primero debe seleccionar el elemento a modificar');
                                                                                              return;
                                                                                          }
                                                                                          var id=fila.get('idFormulario');
                                                                                          var arrDatos=[['idFormulario',id]];
                                                                                          enviarFormularioDatos('../modeloPerfiles/formularios.php',arrDatos);
                                                                                          
                                                                                      
                                                                         			}
                                                                         },
                                                                           {
                                                                              xtype:'tbspacer',
                                                                              width:30
                                                                          	},
                                                                    	{
                                                                              id:"btn_5F",
                                                                              text:"Remover Formulario",
                                                                              icon:"../principalPortal/imagesSIUGJ/delete.png",
                                                                              hidden:false,
                                                                              disabled:false,
                                                                              cls:"x-btn-text-icon",
                                                                              handler:function()
                                                                                      {
                                                                                          
                                                                                  
                                                                                          var fila=gridRegistros.getSelectionModel().getSelected();
                                                                                          if(fila==null)
                                                                                          {
                                                                                              msgBox('Primero debe seleccionar el elemento que desea eliminar');
                                                                                              return;
                                                                                          }
                                                                                          function resp(btn)
                                                                                          {
                                                                                              if(btn=='yes')
                                                                                              {
                                                                                                  var id=fila.get('idFormulario');
                                                                                                  var idReferencia=fila.get('idFormulario');
                                                                                                  function funcAjax()
                                                                                                  {
                                                                                                      var resp=peticion_http.responseText;
                                                                                                      arrResp=resp.split('|');
                                                                                                      if(arrResp[0]=='1')
                                                                                                      {
                                                                                                          gridRegistros.getStore().remove(fila);
                                                                                                      }
                                                                                                      else
                                                                                                      {
                                                                                                          msgBox('No se ha podido llevar cabo la operaci&oacute;n debido al siguiente problema: <br /><br>'+arrResp[0]);
                                                                                                      }
                                                                                                  }
                                                                                                  obtenerDatosWeb('../paginasFunciones/funcionesGridDinamico.php',funcAjax, 'POST','funcion=2&tblVal=&msgError=El formulario&tb=OTAwX2Zvcm11bGFyaW9z&id='+id+'&idReferencia='+idReferencia+'&cId=aWRGb3JtdWxhcmlv',true);
                                                                                              }
                                                                                          }
                                                                                          msgConfirm('Est&aacute; seguro de querer eliminar el elemento seleccionado?',resp);
                                                                                  
                                                                              
                                                                                      }
                                                                          }],
                  view: 	new Ext.grid.GridView	(
                                                        {
                                                            
                                                            showGroupName: false
                                                	        }   
                                                	)
                  
                                                        }
                                                    );
    gridRegistros.on('beforeedit',function(e)
                              {
                                  
                                  if(typeof(gridBeforeEdit)!='undefined')
                                  {
                                      gridBeforeEdit(e);
                                  }
                              }
              )		
    gridRegistros.on('afteredit',function(e)
                          {
                              
                              if(typeof(gridAfterEdit)!='undefined')
                              {
                                  gridAfterEdit(e);
                              }
                          }
              )
    
                                                            
   
    
    return gridRegistros;
		
					
					
					
}

