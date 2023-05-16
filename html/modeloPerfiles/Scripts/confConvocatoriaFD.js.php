<?php session_start();
include("configurarIdiomaJS.php");
?>
Ext.onReady(inicializar);

var nodoSel=null;
var recargarTab=true;
function inicializar()
{
	var idProceso=gE('idProceso').value;
	Ext.QuickTips.init();
    var tabs = new Ext.TabPanel	(
                                      {
                                      	  id:'tabPanel',
                                          renderTo: 'divPanel',
                                          activeTab: 0,
                                          width:880,
                                          height:3000,
                                          padding:1,
                                          items:	[
	                                          			{id:'tab0',contentEl:'divConfGral', title:'1.- Configuracion Gral.'},
                                                      	{id:'tab1',contentEl:'divElementos', title:'2.- Elementos convocatoria'},
                                                      	{id:'tab3',contentEl:'divEstructura', title:'3.- Puntajes por rubro'}

                                                  	]
                                          
                                      }
                                  );
	inicializarComboElementos();
    inicializarComboEstructuraTabla();
    function  tabCambiado(panel,tab)
    {
    	if(tab.id=='tab2')
        {
        	if(recargarTab)
            {
            	
            	cargarConfEscenario(idProceso);
            }
        }
        else
        {
        	
        }
            	
    }                                 
	tabs.on('tabchange',tabCambiado); 
    
}

function cargarConfEscenario(idP)
{
    var iFrame=gE('frameDestino');
    iFrame.src='../modeloPerfiles/configuracionConvocatoria.php?idProceso='+idP+'&cPagina='+cv('sFrm=true');
}

function inicializarComboEstructuraTabla()
{
	var idPr=gE('idProceso').value;
	var cargadorArbol=new Ext.tree.TreeLoader(
												{
													baseParams:{
																	funcion:'312',
																	idProceso:idPr
																},
													dataUrl:'../paginasFunciones/funcionesProyectos.php'
												}
											)	
    
    
    var raiz=new  Ext.tree.AsyncTreeNode	(
                                                  {
                                                      id:'-1',
                                                      text:'',
                                                      draggable:false,
                                                      expanded :true,
                                                      icon:'../images/Icono_txt.gif'
                                                  }
                                            )

	panelArbol=new Ext.tree.TreePanel	(
                                              {
                                              	  id:'arbolEstructura',
                                                  el:'divElementosEstructura',
                                                  useArrows:true,
                                                  autoScroll:true,
                                                  animate:false,
                                                  enableDD:true,
                                                  containerScroll:true,
                                                  root:raiz,
												  height:600,
												  width:720,
                                                  loader: cargadorArbol,
                                                  rootVisible:false,
                                                  tbar:	[
                                                  			{
                                                            	id:'btnPuntaje',
                                                                icon:'../images/pencil.png',
                                                                cls:'x-btn-text-icon',
                                                                text:'Modificar puntaje',
                                                                disabled:true,
                                                                handler:function()
                                                                        {
                                                                            mostrarVentanaPuntaje();
                                                                        }
                                                                
                                                            }
                                                  		]
                                             }
                                          );                                                 	  
      panelArbol.render();
      Ext.getCmp('arbolEstructura').expandAll();
      panelArbol.on('click',funcClikArbolEstructura);

    
}

function funcClikArbolEstructura(nodo, evento)
{
	nodoSel=nodo;
    gEx('btnPuntaje').disable();
    if(nodoSel.attributes.puntos!='')
    {
   	    gEx('btnPuntaje').enable();
    }	
    
}

function mostrarVentanaPuntaje()
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
                                                            html:'Puntaje: '
                                                        },
                                                        {
                                                        	id:'txtPuntos',
                                                        	xtype:'numberfield',
                                                            x:80,
                                                            y:5,
                                                            width:40,
                                                            allowDecimals:true,
                                                            allowNegative:true,
                                                            value:parseFloat(nodoSel.attributes.puntos)
                                                        },
                                                        {
                                                        	x:10,
                                                            y:35,
                                                            html:'# productos m&aacute;x. permitidos:'
                                                        },
                                                        {
                                                        	id:'txtMaximo',
                                                        	xtype:'numberfield',
                                                            x:150,
                                                            y:30,
                                                            width:40,
                                                            value:parseFloat(nodoSel.attributes.maximo)
                                                        }

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Asignar puntaje a criterio',
										width: 230,
										height:160,
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
                                                                	gEx('txtPuntos').focus(true,500);
																}
															}
												},
										buttons:	[
														{
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
																		var txtPuntos=gEx('txtPuntos');
                                                                        if(txtPuntos.getRawValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	txtPuntos.focus();
                                                                            }
                                                                            msgConfirm('El valor de puntaje ingresado no es v&aacute;lido',resp);
                                                                            return;
                                                                        }
                                                                        var txtMaximo=gEx('txtMaximo');
                                                                        if(txtMaximo.getRawValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	txtMaximo.focus();
                                                                            }
                                                                            msgConfirm('El n&uacute;mero de productos m&aacute;ximo permitido no es v&aacute;lido',resp);
                                                                            return;
                                                                        }
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                                nodoSel.attributes.puntos=txtPuntos.getValue();
                                                                                gE('sp'+nodoSel.id).innerHTML=txtPuntos.getValue()+',  M&aacute;x. productos: '+txtMaximo.getValue();
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=314&ruta='+nodoSel.id+'&proceso='+gE('idProceso').value+'&maximo='+txtMaximo.getValue()+'&valor='+txtPuntos.getValue(),true);
                                                                        
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

function modificarOrden(o,iC,tV)
{
	var arrOrden=new Array();
    var nHijos=parseInt(nodoSel.parentNode.attributes.nNodosOrden);
    var x;
    var obj;
    for(x=1;x<=nHijos;x++)
    {
    	obj=[x,x];
        arrOrden.push(obj);
    }
	var cmbOrden=crearComboExt('cmbOrden',arrOrden,185,5,125);
    cmbOrden.setValue(o);
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:'Orden en la estructura de puntaje:'
                                                        },
                                                        cmbOrden	

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Modificar orden',
										width: 380,
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
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
															handler: function()
																	{
																		if(cmbOrden.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	cmbOrden.focus();
                                                                            }
                                                                            msgBox('Debe indicar el orden en el cual se desea colocar el campo',resp);
                                                                            return;
                                                                        }	
                                                                        var idPuntaje=gE('idPuntaje').value;
                                                                        var idProceso=gE('idProceso').value;
                                                                        var obj='{"idProceso":"'+idProceso+'","orden":"'+cmbOrden.getValue()+'","idConf":"'+iC+'","tValor":"'+tV+'"}';		
                                                                        if(idPuntaje=='')
                                                                        {
                                                                        
                                                                            guardarPuntaje(obj,ventanaAM);
                                                                    	}
                                                                        else
                                                                        {
                                                                        	function respP(btn)
                                                                            {
                                                                            	if(btn=='yes')
                                                                                {
                                                                                	guardarPuntaje(obj,ventanaAM);
                                                                                }
                                                                                
                                                                            }
                                                                            msgConfirm('El modificar el orden de este rubro ocasionar&aacute; que la informaci&oacute;n de puntajes almacenada anteriorment sea eliminada, desea continuar?',respP);
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

function guardarPuntaje(obj,ventana)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            gEx('arbolElementos').getRootNode().reload();
            gEx('arbolElementos').expandAll();
            gE('idPuntaje').value='';
            ventana.close();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=313&obj='+obj,true);	
}

function inicializarComboElementos()
{
	var idPr=gE('idProceso').value;
	var cargadorArbol=new Ext.tree.TreeLoader(
												{
													baseParams:{
																	funcion:'200',
																	idProceso:idPr
																},
													dataUrl:'../paginasFunciones/funcionesProyectos.php'
												}
											)	
    
    
    var raiz=new  Ext.tree.AsyncTreeNode	(
                                                  {
                                                      id:'-1',
                                                      text:'',
                                                      draggable:false,
                                                      expanded :true,
                                                      icon:'../images/Icono_txt.gif'
                                                  }
                                            )

	panelArbol=new Ext.tree.TreePanel	(
                                              {
                                              	  id:'arbolElementos',
                                                  el:'divElementosArbol',
                                                  useArrows:true,
                                                  autoScroll:true,
                                                  animate:false,
                                                  enableDD:true,
                                                  containerScroll:true,
                                                  root:raiz,
												  height:300,
												  width:720,
                                                  loader: cargadorArbol,
                                                  rootVisible:false,
                                                  tbar:	[
                                                  			{
                                                            	text:'Agregar elemento',
                                                                icon:'../images/add.png',
																cls:'x-btn-text-icon',
                                                                handler:function()
                                                                        {
                                                                        	agregarElemento();
                                                                        }
                                                            },
                                                            {
                                                            	id:'btnRemoverElem',
                                                            	text:'Remover elemento',
                                                                icon:'../images/delete.png',
                                                                disabled:true,
																cls:'x-btn-text-icon',
                                                                handler:function()
                                                                        {
                                                                        	quitarElemento();
                                                                        }
                                                            }
                                                            ,
                                                            {
                                                            	id:'btnConfElem',
                                                            	text:'Configurar elemento',
                                                                icon:'../images/pencil.png',
																cls:'x-btn-text-icon',
                                                                disabled:true,
                                                                handler:function()
                                                                        {
                                                                        	configurarElemento();
                                                                        }
                                                            },
                                                            {
                                                            	id:'btnModificarOrden',
                                                            	text:'Modificar orden',
                                                                icon:'../images/pencil.png',
																cls:'x-btn-text-icon',
                                                                disabled:true,
                                                                handler:function()
                                                                        {
                                                                        	modificarOrden(nodoSel.attributes.orden,nodoSel.attributes.idConf,nodoSel.attributes.tValor);	
                                                                        }
                                                            }
                                                            
                                                            
                                                  		]
                                              }
                                          );                                                 	  
      panelArbol.render();
      Ext.getCmp('arbolElementos').expandAll();
      panelArbol.on('click',funcClikArbol);

    
}

function funcClikArbol(nodo, evento)
{
	nodoSel=nodo;
    if(nodoSel.attributes.tipo=='0')
    {
    	Ext.getCmp('btnRemoverElem').enable();
        Ext.getCmp('btnConfElem').enable();
        Ext.getCmp('btnModificarOrden').disable();
    }	
    else
    {
       	Ext.getCmp('btnRemoverElem').disable();
        Ext.getCmp('btnConfElem').disable();
        if(nodoSel.attributes.tValor!='5')
        {
        	Ext.getCmp('btnModificarOrden').enable();
        }
        else
			Ext.getCmp('btnModificarOrden').disable();
    }
}


function quitarElemento()
{
	if(nodoSel==null)
    {
    	msgBox('Debe seleccionar el elemento a eliminar');
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
                    nodoSel.remove();
                    nodoSel=null;
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=204&idElemento='+nodoSel.id,true);
		}
    }
    msgConfirm('Est&aacute; seguro de querer eliminar el elemento seleccionado',resp);
}

function configurarElemento()
{
	var idPr=gE('idProceso').value;
	if(nodoSel==null)
    {
    	msgBox('Debe seleccionar el elemento a configurar');
        return;
    }
    var arrSino=[['0','No'],['1','Si']];
    var idConf=nodoSel.attributes.idConf;
    var comboTipo=crearComboExt('cmbTipo',[],155,5);
    comboTipo.setWidth(230);
    var comboEstado=crearComboExt('cmbEstado',[],155,30);
    comboEstado.setWidth(230);
    var comboAnio=crearComboExt('cmbAnio',[],155,55);
    comboAnio.setWidth(230);
   
    var comboNivel=crearComboExt('comboNivel',arrSino,155,80);
	comboNivel.setValue(0);
    var comboParticipacion=crearComboExt('cmbParticipacion',arrSino,155,105);
    comboParticipacion.setValue(0);
    var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            html:'Campo Criterio 1:'
                                                        },
                                                        comboTipo,
                                                        {
                                                        	x:10,
                                                            y:35,
                                                            html:'Campo Criterio 2:'
                                                        },
                                                        comboEstado,
                                                        {
                                                        	x:10,
                                                            y:60,
                                                            html:'Campo A&ntilde;o:'
                                                        },
                                                        comboAnio,
                                                        {
                                                        	id:'lblConsiderarNivel',
                                                        	x:10,
                                                            y:85,
                                                            html:'Considerar nivel investigador:'
                                                        },
                                                        comboNivel,
                                                        
                                                        {
                                                        	id:'lblConsiderarP',
                                                        	x:10,
                                                            y:110,
                                                            html:'Considerar participaci&oacute;n:'
                                                        },
                                                        comboParticipacion
                                                        
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'ConfigurarElemento',
										width: 430,
										height:230,
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
                                                                    	var tipo=comboTipo.getValue();
                                                                        var estado=comboEstado.getValue();
                                                                        var anio=comboAnio.getValue();
                                                                        var participacion=comboParticipacion.getValue();
                                                                        var obj='{"nivelInvestigador":"'+comboNivel.getValue()+'","idElementoConvocatoria":"'+nodoSel.id+'","idProceso":"'+idPr+'","idProcesoRef":"'+nodoSel.attributes.idProcesoRef+'","idConf":"'+idConf+'","tipo":"'+tipo+'","estado":"'+estado+'","anio":"'+anio+'","participacion":"'+participacion+'","idPerfil":"'+parseInt(idPerfil)+'"}';
																		function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	Ext.getCmp('arbolElementos').getRootNode().reload();
                                                                                Ext.getCmp('arbolElementos').expandAll();
                                                                                nodoSel=null;
                                                                                Ext.getCmp('btnRemoverElem').disable();
                                                                                Ext.getCmp('btnConfElem').disable();
                                                                            	ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=206&obj='+obj,true);

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
	llenarDatosConfiguracion(ventanaAM);                                

}

var idPerfil;

function llenarDatosConfiguracion(ventana)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var arrEstadoTipo=eval(arrResp[1]);
            var arrAnio=eval(arrResp[2]);
            Ext.getCmp('cmbTipo').getStore().loadData(arrEstadoTipo);
            Ext.getCmp('cmbEstado').getStore().loadData(arrEstadoTipo);
            Ext.getCmp('cmbAnio').getStore().loadData(arrAnio);
            if(arrResp[3]=='0')
            {
            	Ext.getCmp('lblConsiderarP').hide();
                Ext.getCmp('cmbParticipacion').hide();
            }
            Ext.getCmp('cmbTipo').setValue(arrResp[4]);
            Ext.getCmp('cmbEstado').setValue(arrResp[5]);
            Ext.getCmp('cmbAnio').setValue(arrResp[6]);  
            if(arrResp[7]!='')          
	            Ext.getCmp('cmbParticipacion').setValue(arrResp[7]);     
            else
            	Ext.getCmp('cmbParticipacion').setValue('0');     
            if(arrResp[9]!='')          
            	Ext.getCmp('comboNivel').setValue(arrResp[9]);
            else
            	Ext.getCmp('comboNivel').setValue('0');
            idPerfil=  arrResp[8];
            ventana.show();
            
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=205&idElemento='+nodoSel.id,true);

}

function validarSituacion(combo)
{
	var situacion=combo.options[combo.selectedIndex].value;
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=40&idProceso='+idProceso+'&situacion='+situacion,true);

}

function guardarConfGral()
{
	var idProceso=gE('idProceso').value;
	var cmbSituacion=gE('situacionProceso');
    var situacion=cmbSituacion.options[cmbSituacion.selectedIndex].value;
    var cmbTipoProceso=gE('tipoProcesoConvoca');
    var tipoProceso=cmbTipoProceso.options[cmbTipoProceso.selectedIndex].value;
    var chkNivelInv=gE('chkNivelInv');
    
    if(tipoProceso=='-1')
    {
    	function resp()
        {
        	cmbTipoProceso.focus();
        }
    	msgBox('Debe seleccionar el tipo de proceso sobre el cual funcionar&aacute; la convocatoria',resp);
    	return;
    }
    var chkPIC;
    if(gE('chkPIC').checked)
	    chkPIC=1;
    else
    	chkPIC=0;
    var chkPINC;
    if(gE('chkPINC').checked) 	
    	chkPINC=1;
    else
    	chkPINC=0;
    var chkMMC;
    if(gE('chkMMC').checked)
    	chkMMC=1;
    else
    	chkMMC=0;
    var chkMMNC;
    if(gE('chkMMNC').checked)    
		chkMMNC=1;
    else
    	chkMMNC=0;
    var chkOPC=0;
    if(gE('chkOPC').checked)
    	chkOPC=1;
    var chkOPNC=0;
    if(gE('chkOPNC').checked)
    	chkOPNC=1;
    var chkConsideraNivel=0;
    if(chkNivelInv.checked)
    	chkConsideraNivel=1;
    
    var objDatos='{"situacion":"'+situacion+'","tipoProceso":"'+tipoProceso+'","chkPIC":"'+chkPIC+'","chkPINC":"'+chkPINC+
    				'","chkMMC":"'+chkMMC+'","chkMMNC":"'+chkMMNC+'","chkOPC":"'+chkOPC+'","chkOPNC":"'+chkOPNC+'","chkConsideraNivel":"'+chkConsideraNivel+'"}';
	alert(objDatos);
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	gE('tProceso').value=tipoProceso;
        	msgBox('Los datos han sido guardados correctamente');
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=201&datos='+objDatos+'&idProceso='+idProceso,true);
}

function agregarElemento()
{
	var idProceso=gE('idProceso').value;
	var tProceso=gE('tProceso').value;
    if((tProceso=='')||(tProceso=='-1'))
    {
    	function resp()
        {
        	Ext.getCmp('tabPanel').setActiveTab(0);
            gE('tipoProcesoConvoca').focus();
        }
    	msgBox('Primero debe indicar el tipo de proceso sobre el cual recaer&aacute; la convocatoria',resp);
        return;
    }
    var gridElemento=crearGridElementos();
    
    var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'textfield',
											items: 	[
														gridElemento
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar elemento',
										width: 420,
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
																		var filas=gridElemento.getSelectionModel().getSelections();
                                                                        if(filas.length==0)
                                                                        {
                                                                        	msgBox('Al menos debe seleccionar un elemento para agregar al proceso de convocatoria');
                                                                        	return;
                                                                        }
                                                                        var cadElementos='';
                                                                        var x=0;
                                                                        for(x=0;x<filas.length;x++)
                                                                        {
                                                                        	if(cadElementos=='')
                                                                            	cadElementos=filas[x].get('idProceso');
                                                                            else
                                                                            	cadElementos+=','+filas[x].get('idProceso');
                                                                            	
                                                                        }
                                                                        
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	Ext.getCmp('arbolElementos').getRootNode().reload();
                                                                                Ext.getCmp('arbolElementos').expandAll();
                                                                                nodoSel=null;
                                                                                Ext.getCmp('btnRemoverElem').disable();
                                                                                Ext.getCmp('btnConfElem').disable();
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=203&idProceso='+idProceso+'&cadElementos='+cadElementos,true);
                                                                        

                                                                        
                                                                        
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
	llenarDatosElemento(ventanaAM);
}

function llenarDatosElemento(ventanaAM)
{
	var idTipoProceso=gE('tProceso').value;
    var idProceso=gE('idProceso').value;
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var arrDatos=eval(arrResp[1]);
            Ext.getCmp('gridElemento').getStore().loadData(arrDatos);
        	ventanaAM.show();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=202&idProceso='+idProceso+'&idTipoProceso='+idTipoProceso,true);


}

function crearGridElementos()
{
		dsDatos=[];
    alDatos=	new Ext.data.SimpleStore	(
                                                {
                                                    fields:	[
                                                                {name: 'idProceso'},
                                                                {name: 'proceso'}
                                                            ]
                                                }
                                            );

    alDatos.loadData(dsDatos);
	chkRow=new Ext.grid.CheckboxSelectionModel();
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														chkRow,
														{
															header:'Elemento',
															width:300,
															sortable:true,
															dataIndex:'proceso'
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gridElemento',
                                                            store:alDatos,
                                                            frame:true,
                                                            y:10,
                                                            cm: cModelo,
                                                            height:260,
                                                            width:395,
                                                            sm:chkRow
                                                        }
                                                    );
	return 	tblGrid;
}

function redimensionarIframe(iFrame)
{
    iFrame.height='110%';
    if(Ext.isGecko)
    	var the_height=iFrame.contentWindow.innerHeight+iFrame.contentWindow.scrollMaxY+30;
    else
    	var the_height=iFrame.contentWindow.document.body.scrollHeight;
    
    iFrame.scrolling='no';
    var tabPanel= Ext.getCmp('tabPanel');
    if(tabPanel!=null)
    {
        if(the_height>530)
            tabPanel.setHeight(the_height+20);
        else
            tabPanel.setHeight(530);
    }
}

function funcNivelInvestigador(chk)
{
	var arrChkInvestigacion=gEN('chkInvestigacion');
    var x;
	if(chk.checked)
    {
    	for(x=0;x<arrChkInvestigacion.length;x++)
        {
        	arrChkInvestigacion[x].disabled=false;
        }
    }
    else
    {
    	for(x=0;x<arrChkInvestigacion.length;x++)
        {
        	arrChkInvestigacion[x].disabled=true;
            arrChkInvestigacion[x].checked=false;
        }
    }

}