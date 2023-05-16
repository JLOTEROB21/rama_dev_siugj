<?php session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$consulta="select idValorSesion,descripcionValor,valorReemplazo from 8003_valoresSesion where tipo=1 order by descripcionValor ";
	$arrValorSesion=uEJ($con->obtenerFilasArreglo($consulta));
	$consulta="select idValorSesion,descripcionValor,valorReemplazo from 8003_valoresSesion where tipo=2 order by descripcionValor ";
	$arrValorSistema=uEJ($con->obtenerFilasArreglo($consulta));
	$tDataSet=5;
	if(isset($_GET["tDataSet"]))
		$tDataSet=$_GET["tDataSet"];
	
?>
var filtroUsuario=new Array();
var filtroMysql=new Array(); 
var filtroTipoValor;
var arrOperaciones=[['6','Contabilizar elementos'],['1','Promedio'],['2','Proyecci\xF3n'],['7','Ra\xEDz cuadrada'],['3','Sumatoria'],['4','Valor m\xE1ximo'],['5','Valor m\xEDnimo']];
var arrParametrosAlmacen;
var arrProceso=[['1','idFormulario'],['2','idProceso'],['3','idRegistro'],['4','numEtapa'],['5','idReferencia'],['6','Usuario registro']];
var regTabla=crearRegistro(
                                [
                                  {name:'nomTablaOriginal'},
                                  {name:'tabla'}, 
                                  {name:'tipoTabla'},
                                  {name:'proceso'}
                              ]
                          );
                          
function crearArbolAlmacen()
{
	var iR=gE('idFormulario').value;
	var cargadorArbol=new Ext.tree.TreeLoader(
												{
													baseParams:{
																	funcion:'7',
                                                                    idReporte:iR,
                                                                    tipoDataSet:<?php echo $tDataSet?>
																},
													dataUrl:'../paginasFunciones/funcionesThot.php'
												}
											)	



    var raiz=new  Ext.tree.AsyncTreeNode	(
                                                  {
                                                      id:'-1',
                                                      text:'DTD',
                                                      draggable:false,
                                                      expanded :true
                                                  }
                                            )

	panelArbol=new Ext.tree.TreePanel	(
                                              {
                                              	  id:'arbolDataSet',
                                                  useArrows:true,
                                                  autoScroll:true,
                                                  animate:false,
                                                  enableDD:true,
                                                  height:550,
                                                  containerScroll:true,
                                                  root:raiz,
                                                  rootVisible:false,
												  loader: cargadorArbol
                                                                                                
                                               }
                                          );      
    panelArbol.on('click',funcClickArbol);
    return panelArbol;
}

function funcClickArbol(nodo)
{
	nodoSel=nodo;
    gEx('addDataSet').disable();
    gEx('delDataSet').disable();
    gEx('linkDataSet').disable();
    gEx('modficarValorParametro').hide();
    gEx('addCamposProy').hide();
    gEx('delCamposProy').hide();
    gEx('modificarFiltroAlmacen').hide();
    gEx('modificarNombreAlmacen').hide();
    switch(nodoSel.attributes.tipo)
    {
    	case 'p':
        	gEx('modficarValorParametro').show();
        break;
        case 'cc':
        	gEx('addCamposProy').show();
        break;
        case 'c':
            gEx('delCamposProy').show();
        break;
        case 't':
        	gEx('modificarFiltroAlmacen').show();
            gEx('delDataSet').enable();
            gEx('linkDataSet').enable();
            gEx('modificarNombreAlmacen').show();
        break;
        case 'ad':
        	gEx('addDataSet').enable();
        break;
        case 'ca':
        	gEx('addDataSet').enable();
        break;
        case 'ar':
        	gEx('addDataSet').enable();
        break;
        case 'ct':
        	
        break;
    }
}

function verParametrosReporte()
{
	var gridParametrosReporte=crearGridParametros();
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														gridParametrosReporte

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Par&aacute;metros del reporte',
										width: 600,
										height:350,
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
															text: 'Aceptar',
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

function crearGridParametros()
{
	var dsDatos=eval(gE('param').value);
    var alDatos=	new Ext.data.SimpleStore	(
                                                {
                                                    fields:	[
                                                                {name: 'idParametro'},
                                                                {name: 'parametro'},
                                                                {name: 'descripcion'}
                                                            ]
                                                }
                                            );

    alDatos.loadData(dsDatos);
	
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														
														{
															header:'Par&aacute;metro',
															width:150,
															sortable:true,
															dataIndex:'parametro'
														},
														{
															header:'Descripci&oacute;n',
															width:300,
															sortable:true,
															dataIndex:'descripcion'
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.GridPanel	(
                                                        {
                                                            id:'gridParametros',
                                                            store:alDatos,
                                                            frame:true,
                                                            x:10,
                                                            y:10,
                                                            cm: cModelo,
                                                            height:260,
                                                            width:550,
                                                            
                                                            tbar:	[
                                                            			{
                                                                        	text:'Agregar par&aacute;metro',
                                                                            icon:'../images/add.png',
			                                                                cls:'x-btn-text-icon',
                                                                            handler:function()
                                                                            		{
                                                                                    	mostrarVAgrergaParam(-1);
                                                                                    }
                                                                        },
                                                                        {
                                                                        	text:'Modificar par&aacute;metro',
                                                                            icon:'../images/pencil.png',
			                                                                cls:'x-btn-text-icon',
                                                                            handler:function()
                                                                            		{
                                                                                    	var fila=tblGrid.getSelectionModel().getSelected();
                                                                                        if(fila==null)
                                                                                        {
                                                                                        	msgBox('Debe seleccionar el par&aacute;metro que desea modificar');
                                                                                            return;
                                                                                        }
                                                                                    	mostrarVAgrergaParam(fila.get('idParametro'),fila);
                                                                                    }
                                                                        },
                                                                        {
                                                                        	text:'Remover par&aacute;metro',
                                                                            icon:'../images/delete.png',
			                                                                cls:'x-btn-text-icon',
                                                                            handler:function()
                                                                            		{
                                                                                    	var fila=tblGrid.getSelectionModel().getSelected();
                                                                                        if(fila==null)
                                                                                        {
                                                                                        	msgBox('Debe seleccionar el par&aacute;metro que desea eliminar');
                                                                                            return;
                                                                                        }	
                                                                                        var iP=fila.get('idParametro');
                                                                                        var idReporte=gE('idFormulario').value;
                                                                                        function respDel(btn)
                                                                                        {
                                                                                            function funcAjax()
                                                                                            {
                                                                                                var resp=peticion_http.responseText;
                                                                                                arrResp=resp.split('|');
                                                                                                if(arrResp[0]=='1')
                                                                                                {
                                                                                                    var arrDatos=arrResp[1];
                                                                                                    gE('param').value=arrDatos;
                                                                                                    gEx('gridParametros').getStore().loadData(eval(arrDatos));
                                                                                                    
                                                                                                }
                                                                                                else
                                                                                                {
                                                                                                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                }
                                                                                            }
                                                                                            obtenerDatosWeb('../paginasFunciones/funcionesThot.php',funcAjax, 'POST','funcion=11&idReporte='+idReporte+'&idParametro='+iP,true);
                                                                            
                                                                        
                                                                                        }
                                                                                        msgConfirm('Est&aacute; seguro de querer eliminar el par&aacute;metro seleccionado?',respDel)
                                                                                    }
                                                                        }
                                                            		]
                                                        }
                                                    );
	return 	tblGrid;
}

function mostrarVAgrergaParam(iP,fila)
{

	var textParam='';
    var textDesc='';
    if(iP!='-1')
    {
    	textParam=fila.get('parametro');
        textDesc=fila.get('descripcion');
    }
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                        	html:'Par&aacute;metro:'
                                                        },
                                                        {
                                                        	xtype:'textfield',
                                                            x:100,
                                                            y:5,
                                                            width:300,
                                                            id:'txtParametro',
                                                            value:textParam
                                                        },
                                                        {
                                                        	x:10,
                                                            y:40,
                                                        	html:'Descripci&oacute;n:'
                                                        },
                                                        {
                                                        	xtype:'textarea',
                                                            x:100,
                                                            y:35,
                                                            width:300,
                                                            height:100,
                                                            id:'txtDescripcion',
                                                            value:textDesc
                                                        }

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Registrar par&aacute;metro del reporte',
										width: 500,
										height:250,
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
                                                                	gEx('txtParametro').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
																		var txtParametro=gEx('txtParametro');
                                                                        if(txtParametro.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	txtParametro.focus();
                                                                            }
                                                                        	msgBox('Debe ingresar el nombre del par&aacute;metro',resp)
                                                                        }
                                                                        var txtDescripcion=gEx('txtDescripcion').getValue();
                                                                        var idReporte=gE('idFormulario').value;
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	var arrDatos=arrResp[1];
                                                                                gE('param').value=arrDatos;
                                                                                gEx('gridParametros').getStore().loadData(eval(arrDatos));
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesThot.php',funcAjax, 'POST','funcion=10&idReporte='+idReporte+'&nombre='+cv(txtParametro.getValue())+'&descripcion='+cv(txtDescripcion)+'&idParametro='+iP,true);
                                                                        
                                                                    
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



var arrOrigenesDatos=[['1','Almac\xE9n de datos'],['2','Consulta auxiliar']];

function mostrarVentanaVinculacionCampoEspecial()
{
	var cmbOrigenDatosCampo=crearComboExt('cmbOrigenDatosCampo',arrOrigenesDatos,340,5);
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:'Ingrese el origen del cual obtendr&aacute; el valor el campo especial:'
                                                        },
                                                        cmbOrigenDatosCampo
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Vincular campo especial',
										width: 600,
										height:125,
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
																		if(cmbOrigenDatosCampo.getValue()=='')
                                                                        {
                                                                        	msgBox('Debe seleccionar el origen de datos del cual el campo especial obtendr&aacute; su valor');
                                                                        	return;
                                                                        }
                                                                        
                                                                        switch(cmbOrigenDatosCampo.getValue())
                                                                        {
                                                                        	case '1':
                                                                            case '2':
                                                                            	mostrarVentanaSeleccionOrigenDato(cmbOrigenDatosCampo.getValue());
                                                                                ventanaAM.close();
                                                                            break;
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

function mostrarVentanaSeleccionOrigenDato(tipo)
{
	var lblTipo='Seleccione el almac&eacute;n de datos que desea vincular al campo especial';
	if(tipo=='2')
    	lblTipo='Seleccione la consulta auxiliar que desea vincular al campo especial';
    
    var gridOrigenes=crearGridOrigenesDatos();
    
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:lblTipo
                                                        },
                                                        gridOrigenes
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Selecci&oacute;n de origen de datos',
										width: 400,
										height:390,
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
																	 	var filaSel=gridOrigenes.getSelectionModel().getSelected();
                                                                     	if(filaSel==null)
                                                                        {
                                                                        	msgBox('Debe seleccionar el almac&eacute;n de datos con el cual se vincular&aacute; el campo especial');
                                                                            return;
                                                                        }
                                                                        var idAlmacen=filaSel.get('idAlmacen');
                                                                        ventanaAM.close();
                                                                        if(tipo=='1')
                                                                        	mostrarVentanaCamposAlmacen(idAlmacen,tipo,filaSel.get('camposProy'));
                                                                        else
                                                                        {
                                                                        	validarVinculacionAlmacen(idAlmacen,tipo,eval(filaSel.get('camposProy'))[0][0]);
                                                                        }
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
                                
	llenarGridAlmacen(gridOrigenes,tipo,ventanaAM);                                

}

function crearGridOrigenesDatos(tipo)
{
	var lblTitulo='Almac&eacute;n de datos';
    if(tipo=='2')
    	lblTitulo='Consulta auxiliar';
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'idAlmacen'},
                                                                    {name: 'nombre'},
                                                                    {name: 'camposProy'}
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
															header:lblTitulo,
															width:250,
															sortable:true,
															dataIndex:'nombre'
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gridOrigenDatos',
                                                            store:alDatos,
                                                            frame:true,
                                                            x:10,
                                                            y:40,
                                                            cm: cModelo,
                                                            height:260,
                                                            width:350,
                                                            sm:chkRow
                                                        }
                                                    );
	return 	tblGrid;	
	
}

function llenarGridAlmacen(grid,tipo,ventana)
{
	var arrOrigenesDatos=[];
    var camposProy='';
	var arbolDataSet=gEx('arbolDataSet');
    var nodoRaiz=arbolDataSet.getRootNode();
    var nodoOrigen;
	if(tipo=='1')
    	nodoOrigen=obtenerHijosNodoArbol(nodoRaiz)[0];
    else
    	nodoOrigen=obtenerHijosNodoArbol(nodoRaiz)[1];

	var x;
    var obj
    var y;
    var camposProy='';
    var nodoAlmacen;
    var nodoCampos;
    var arrHijosOrigen=obtenerHijosNodoArbol(nodoOrigen);
    for(x=0;x<arrHijosOrigen.length;x++)
    {
    	camposProy='';
    	obj=new Array();
        nodoAlmacen=arrHijosOrigen[x];
        obj[0]=nodoAlmacen.id;
        obj[1]=nodoAlmacen.attributes.nombreDataSet;
        
        var nodoCampos=obtenerHijosNodoArbol(nodoAlmacen)[0];
        var arrNodosCamposProy=obtenerHijosNodoArbol(nodoCampos);
        var nCampoProy;
        for(y=0;y<arrNodosCamposProy.length;y++)
        {
        	if(arrNodosCamposProy[y].attributes!=undefined)
	        	nCampoProy=arrNodosCamposProy[y].attributes.nCampo;
            else
            	nCampoProy=arrNodosCamposProy[y].nCampo;    
        	
            cadObj="['"+nCampoProy+"','"+arrNodosCamposProy[y].text+"']";
            
        	if(camposProy=='')
            	camposProy=cadObj;
            else
            	camposProy+=','+cadObj;
            
        }
        
        obj[2]='['+camposProy+']';
        arrOrigenesDatos.push(obj);
    }        
     gEx('gridOrigenDatos').getStore().loadData(arrOrigenesDatos); 
     ventana.show();
}

function mostrarVentanaCamposAlmacen(idAlmacen,tipo,campoProy)
{
	var gridCamposProy=crearGridCamposProy();
    gridCamposProy.getStore().loadData(eval(campoProy));
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:'Seleccione el campo que desea proyectar en el control a agregar:'
                                                        },
                                                        gridCamposProy

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Selecci&oacute;n de campo a proyectar',
										width: 390,
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
																		var filaSel=gridCamposProy.getSelectionModel().getSelected();
                                                                        if(filaSel==null)
                                                                        {
                                                                        	msgBox('Debe seleccionar el campo a proyectar en el control a agregar');
                                                                        	return;
                                                                        }
                                                                        
                                                                        var campoProy=filaSel.get('nCampoO');
                                                                        ventanaAM.close();
                                                                        validarVinculacionAlmacen(idAlmacen,tipo,campoProy);
                                                                        
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

function crearGridCamposProy()
{
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                {
                                                    fields:	[
                                                                {name: 'nCampoO'},
                                                                {name: 'nCampo'}
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
															header:'Campo',
															width:250,
															sortable:true,
															dataIndex:'nCampo'
														}													
                                                   ]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            
                                                            store:alDatos,
                                                            frame:true,
                                                            y:40,
                                                            cm: cModelo,
                                                            height:260,
                                                            width:360,
                                                            sm:chkRow
                                                        }
                                                    );
	return 	tblGrid;	
}

function validarVinculacionAlmacen(idAlmacen,tipo,campoProy)
{
	var arrDiv=divCtrlSel.id.split('_');
    var idReporte=gE('idFormulario').value;
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	if(arrResp[1]=='')
            {
            	objFinal='{"campoProy":"'+campoProy+'","idPadre":"@idPadre","idReporte":"'+idReporte+'","pregunta":[],"tipoElemento":"28","obligatorio":"0","posX":"@posX","posY":"@posY","tipo":"'+tipo+'","idAlmacen":"'+idAlmacen+'"}';
                g.objControl=objFinal;	
            }
            else
            {
            
            	var arrParam=eval(arrResp[1]);
                arrCamposAlmacen=eval(arrResp[2]);
                if(arrParam.length>0)
	             	mostrarVentanaAsignarParametro(arrParam,idAlmacen,tipo,campoProy); 
                else
                {
                	objFinal='{"campoProy":"'+campoProy+'","idPadre":"@idPadre","idReporte":"'+idReporte+'","pregunta":[],"tipoElemento":"28","obligatorio":"0","posX":"@posX","posY":"@posY","tipo":"'+tipo+'","idAlmacen":"'+idAlmacen+'"}';
                	g.objControl=objFinal;
                }
            }
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesThot.php',funcAjax, 'POST','funcion=25&idAlmacen='+idAlmacen+'&idAlmacenPadre='+arrDiv[1],true);
}

function mostrarVentanaAsignarParametro(datos,idAlmacen,tipo,campoProy)
{
	var idReporte=gE('idFormulario').value;
	var gridParam=crearGridAsignaParametro(idAlmacen);
    gridParam.getStore().loadData(datos)
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:'Indique los valores que se asignar&aacute;n a los siguientes par&aacute;metros:'
                                                        },
                                                        gridParam
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Asignaci&oacute;n de valor a par&aacute;metros',
										width: 500,
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
															handler:function()
																	{
                                                                    	objFinal='{"campoProy":"'+campoProy+'","idPadre":"@idPadre","idReporte":"'+idReporte+'","pregunta":[],"tipoElemento":"28","obligatorio":"0","posX":"@posX","posY":"@posY","tipo":"'+tipo+'","idAlmacen":"'+idAlmacen+'"}';
                														g.objControl=objFinal;
																		ventanaAM.close();
																	}
														}
													]
									}
								);
	ventanaAM.show();
}

function crearGridAsignaParametro(idAlmacen)
{
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'idParametro'},
                                                                    {name: 'parametro'},
                                                                    {name: 'asigna'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel({singleSelect:true});
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														{
															header:'Par&aacute;metro',
															width:170,
															sortable:true,
															dataIndex:'parametro'
														},
                                                        {
															header:'Valor',
															width:200,
															dataIndex:'asigna',
                                                            renderer:function(val,metaData,registro,nFila)
                                                            		{
                                                                    	return val+'<a href="javascript:asignarValorParametroAlmacen(\''+bE(idAlmacen)+'\',\''+bE(registro.get('parametro'))+'\',\''+bE(nFila)+'\')">&nbsp;&nbsp;<img src="../images/pencil.png" width="13" height="13" alt="Modificar valor del par&aacute;metro" title="Modificar valor del par&aacute;metro"></a>';
                                                                    }
														}

													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gridAsignaParametros',
                                                            store:alDatos,
                                                            frame:true,
                                                            x:10,
                                                            y:40,
                                                            cm: cModelo,
                                                            height:260,
                                                            width:460,
                                                            sm:chkRow
                                                        }
                                                    );
	return 	tblGrid;	
	
}

function asignarValorParametroAlmacen(iAlmacen,parametro,nFila)
{
    var arrTipoEntrada=[['7','Consulta auxiliar'],['1','Valor Constante'],['16','Par\xE1metro de proceso'],['11','Valor de almac\xE9n'],['3','Valor de sesi\xF3n'],['4','Valor de sistema']];
    var cmbTipoValor=crearComboExt('cmbTipoValor',arrTipoEntrada,140,5);
    cmbTipoValor.on('select',funcTipoEntradaChange2);
    var cmbValor=crearComboExt('cmbValor',[],140,35);
    cmbValor.setWidth(250);
    cmbValor.hide();
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:'Tipo de valor a asignar:'
                                                        },
                                                        cmbTipoValor,
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            html:'Valor a asignar:'
                                                        },
                                                        {
                                                        	xtype:'textfield',
                                                        	id:'txtValorConstante',
                                                            x:140,
                                                            y:35
                                                        },
                                                        cmbValor
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Asignar valor a par&aacute;metro',
										width: 430,
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
																		if(cmbTipoValor.getValue()=='')
                                                                        {
                                                                        	msgBox('Debe seleccionar el tipo de entrada al que pertenece el valor a asignar');
                                                                        	return;
                                                                        }
                                                                        var valorUsr;
                                                                        var valor;
                                                                        switch(cmbTipoValor.getValue())
                                                                        {
                                                                        	case '1':
                                                                            	valor=gEx('txtValorConstante').getValue();
                                                                                valorUsr=valor;
                                                                            break;
                                                                            default:
                                                                            	if(cmbValor.getValue()=='')
                                                                                {
                                                                                	msgBox('Debe seleccionar el valor que desea asignar');
                                                                                	return;
                                                                                }
                                                                                valor=cmbValor.getValue();
                                                                                valorUsr=cmbValor.getRawValue();
                                                                            break;
                                                                        }                                                                        
                                                                        var tipo=cmbTipoValor.getValue();
                                                                        var almacen=iAlmacen;
                                                                        var param=parametro;
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            
                                                                            	var fila=gEx('gridAsignaParametros').getStore().getAt(bD(nFila));
                                                                            	if(tipo=='1')
	                                                                            	fila.set('asigna',''+valorUsr);
                                                                                else
                                                                                	fila.set('asigna','['+valorUsr+']');
                                                                                gEx('arbolDataSet').getRootNode().reload();
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesThot.php',funcAjax, 'POST','funcion=16&valor='+valor+'&valorUsr='+valorUsr+'&parametro='+param+'&tipo='+tipo+'&almacen='+bD(almacen),true);
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

function funcTipoEntradaChange2(combo,registro)
{
	var txtValorConstante=gEx('txtValorConstante');
    txtValorConstante.hide();
    var cmbValor=gEx('cmbValor');
    cmbValor.hide();
    
	switch(registro.get('id'))
    {
    	case '1':
        	txtValorConstante.show();
        break;
        case '2':
        	cmbValor.getStore().loadData(arrParametrosRep);
        	cmbValor.show();
        break;
        case '3':
        	cmbValor.getStore().loadData(arrValorSesion);
        	cmbValor.show();
        break;
        case '4':
        	cmbValor.getStore().loadData(arrValorSistema);
        	cmbValor.show();
        break;
        case '7':
        	var arrConsultaAux=new Array();
            var arbolDataSet=gEx('arbolDataSet');
            var raiz=arbolDataSet.getRootNode();
            var nodoConsulta=raiz.childNodes[1];
            var x;
            var obj;
            for(x=0;x<nodoConsulta.childNodes.length;x++)
            {
            	
                    obj=new Array();
                    obj[0]=nodoConsulta.childNodes[x].id;
                    obj[1]='Consulta: '+nodoConsulta.childNodes[x].text;
                    arrConsultaAux.push(obj);
                
           	}
        	cmbValor.getStore().loadData(arrConsultaAux);
        	cmbValor.show();
        break;
        case '8':
        	cmbValor.getStore().loadData(arrCamposAlmacen);
        	cmbValor.show();
        break;
        
    }
}

function mostrarVentanaTablasInvolucradas(ocultarProy)
{
	var gridTablasInv= crearGridConsiderarTablas(ocultarProy,false);
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														gridTablasInv
													]
										}
									);
	
    
     btnSiguiente=new Ext.Button	(
                                        {
                                            text: 'Siguiente >>',
                                            minWidth:80,
                                            id:'btnFinalizar',
                                            listeners:	{
                                                            click:
                                                                    {
                                                                        fn:function()
                                                                        {
                                                                            if(gridTablasInv.getStore().getCount()==0)
                                                                            {
                                                                                Ext.MessageBox.alert(lblAplicacion,'Debe almenos selecionar una tabla en la cual se basar&aacute; su almac&eacute;n');
                                                                                return;
                                                                            }
                                                                            var x;
                                                                            var nomTabla='';
                                                                            var nTablaUsr='';
                                                                            var tTabla='';
                                                                            var filaSel;
                                                                            for(x=0;x<gridTablasInv.getStore().getCount();x++)
                                                                            {
                                                                            	filaSel=gridTablasInv.getStore().getAt(x);
                                                                            	if(nomTabla=='')
                                                                                {
                                                                                	nomTabla=filaSel.get('nomTablaOriginal');
                                                                                    nTablaUsr=filaSel.get('tabla');
                                                                                    if(filaSel.get('tipoTabla')=='Sistema')
                                                                                        tTabla='0';
                                                                                    else
                                                                                        tTabla='1';
                                                                                }
                                                                               	else
                                                                                {
                                                                                	nomTabla+=','+filaSel.get('nomTablaOriginal');
                                                                                    nTablaUsr+=','+filaSel.get('tabla');
                                                                                    if(filaSel.get('tipoTabla')=='Sistema')
                                                                                        tTabla+=',0';
                                                                                    else
                                                                                        tTabla+=',1';
                                                                                }
                                                                            }
                                                                            ventanaSelTabla.close();
                                                                            var obj={};
                                                                            obj.nTablaO=nomTabla;
                                                                            obj.nTablaUsr=nTablaUsr;
                                                                            obj.tipoTabla=tTabla;
                                                                            
                                                                            if(ocultarProy==undefined)
                                                                                mostrarVentanaFiltro(obj,false);
                                                                            else
                                                                                mostrarVentanaFiltro(obj,ocultarProy);
                                                                            ventanaAM.close();
                                                                        }
                                                                    }
                                                        }
                                        }
                                    )
    
	var ventanaAM = new Ext.Window(
									{
										title: 'Tabla involucadas en el almac&eacute;n',
										width: 700,
										height:370,
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
														btnSiguiente,
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

function crearGridConsiderarTablas(ocultarProy,validarDelete)
{
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'nomTablaOriginal'},
                                                                    {name: 'tabla'},
                                                                    {name:'tipoTabla'},
	                                                                {name:'proceso'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel({singleSelect:true});
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
														 new  Ext.grid.RowNumberer({width:35}),
                                                        {
                                                            header:'Tabla',
                                                            width:250,
                                                            dataIndex:'tabla',
                                                            sortable:true
                                                        },
                                                        {
                                                        	header:'Tipo',
                                                            width:130,
                                                            sortable:true,
                                                            dataIndex:'tipoTabla'
                                                        },
                                                        {
                                                        	header:'Proceso',
                                                            width:180,
                                                            sortable:true,
                                                            dataIndex:'proceso'
                                                        }													
                                                    ]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                        	id:'gridConsidera',
                                                            x:10,
                                                            store:alDatos,
                                                            frame:true,
                                                            y:10,
                                                            cm: cModelo,
                                                            height:260,
                                                            width:650,
                                                            sm:chkRow,
                                                            tbar:	[
                                                            			{
                                                                        	icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                        	text:'Agregar tabla',
                                                                            handler:function()
                                                                            		{
                                                                                    	mostrarVentanaSelTabla(ocultarProy);
                                                                                    }
                                                                        },
                                                                        {
                                                                        	
                                                                        	icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                        	text:'Remover tabla',
                                                                            handler:function()
                                                                            		{
                                                                                      	var idReporte=gE('idFormulario').value;
                                                                                    	var filaSel= tblGrid.getSelectionModel().getSelected();
                                                                                        if(filaSel==null)
                                                                                        {
                                                                                            Ext.MessageBox.alert(lblAplicacion,'Debe selecionar la tabla en la cual se basar&aacute; su consulta');
                                                                                            return;
                                                                                        }
                                                                                        
                                                                                        if(!validarDelete)
                                                                                        {
                                                                                        
                                                                                            function resp(btn)
                                                                                            {
                                                                                                if(btn=='yes')
                                                                                                {
                                                                                                    tblGrid.getStore().remove(filaSel);
                                                                                                }
                                                                                            }
                                                                                            msgConfirm('Est&aacute; seguro de querer remover la tabla seleccionada?',resp);
                                                                                    	}
                                                                                        else
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
                                                                                                    obtenerDatosWeb('../paginasFunciones/funcionesThot.php',funcAjax, 'POST','funcion=24&idReporte='+idReporte+'&idAlmacen='+nodoSel.id+'&nTabla='+filaSel.get('nomTablaOriginal'),true);
                                                                                                }
                                                                                            }
                                                                                            msgConfirm('Al remover la tabla seleccionada se eliminar&aacute; toda informaci&oacute;n relacionada con dicha tabla dentro del almac&eacute;n (referencias en etiquetas, en almac&eacute;, etc..), desea continuar?',resp);
                                                                                        
                                                                                        }
                                                                                    }
                                                                        }
                                                            		]
                                                        }
                                                    );
	return 	tblGrid;		
}

function mostrarVentanaSelTabla(ocultarProy)
{
    arrParametrosAlmacen=new Array();
	var alDatos = new Ext.data.JsonStore	(
                                                {
                                                    root: 'registros',
                                                    totalProperty: 'numReg',
                                                    idProperty: 'nomTablaOriginal',
                                                    fields:	[
                                                                {name:'nomTablaOriginal'},
                                                                {name:'tabla'}, 
                                                                {name:'tipoTabla'},
                                                                {name:'proceso'}
                                                            ],
                                                    remoteSort:false,
                                                    proxy: new Ext.data.HttpProxy	(
                                                                                        {
                                                                                            url: '../paginasFunciones/funcionesFormulario.php'
                                                                                            
                                                                                        }
                                                                                    )
                                                }
                                            );  
                                            
                                            
	var filters = new Ext.ux.grid.GridFilters	(
    												{
                                                    	filters:	[
                                                        				{
                                                                            type:'string',
                                                                           	dataIndex:'tabla' 
																		},
                                                                        {
                                                                            type:'list',
                                                                           	dataIndex:'tipoTabla',
                                                                            phpMode:true,
                                                                            options:	[
                                                                            				{
                                                                                            	id:'1',
                                                                                                text:'Formulario Din&aacute;mico'
                                                                                            },
                                                                            				{
                                                                                            	id:'2',
                                                                                                text:'Sistema'
                                                                                            }
                                                                            			] 
																		},
                                                                        {
                                                                            type:'string',
                                                                           	dataIndex:'proceso' 
																		}
                                                        			]
                                                    }
                                                );                                                                                                                           
   
   
    var cmFrmDTD= new Ext.grid.ColumnModel   	(
                                                    [
                                                        new  Ext.grid.RowNumberer({width:35}),
                                                        {
                                                            header:'Tabla',
                                                            width:250,
                                                            dataIndex:'tabla',
                                                            sortable:true
                                                        },
                                                        {
                                                        	header:'Tipo',
                                                            width:130,
                                                            sortable:true,
                                                            dataIndex:'tipoTabla'
                                                        },
                                                        {
                                                        	header:'Proceso',
                                                            width:180,
                                                            sortable:true,
                                                            dataIndex:'proceso'
                                                        }
                                                       
                                                    ]
                                                );
    
    
    var tblOpciones=	new Ext.grid.GridPanel	(
                                                        {
                                                            id:'gridTabla',
                                                            store:alDatos,
                                                            frame:true,
                                                            cm: cmFrmDTD,
                                                            height:300,
                                                            width:630,
                                                            plugins: filters
                                                            
                                                        }
                                                    );
    tblOpciones.on('dblclick',function()
    							{
                                	gEx('btnAgregar').fireEvent('click');
                                }
    				);
    panelGrid=new Ext.Panel	(
                                {
                                    y:10,
                                    width:630,
                                    items:	[
                                                tblOpciones
                                            ]
                                }
                            );
                            
    
    
    
    
    
    
    var form = new Ext.form.FormPanel(	
                                        {
                                            baseCls: 'x-plain',
                                            layout:'absolute',
                                            defaultType: 'textfield',
                                            items: 	[
                                                        panelGrid
                                                    ]
                                        }
                                    );
    
   
   
    btnAgregar=new Ext.Button	(
                                        {
                                            text: 'Agregar tabla',
                                            minWidth:80,
                                            id:'btnAgregar',
                                            listeners:	{
                                                            click:
                                                                    {
                                                                        fn:function()
                                                                        {
                                                                            
                                                                            var filaSel= tblOpciones.getSelectionModel().getSelected();
                                                                            if(filaSel==null)
                                                                            {
                                                                                Ext.MessageBox.alert(lblAplicacion,'Debe selecionar la tabla en la cual se basar&aacute; su consulta');
                                                                                return;
                                                                            }
                                                                            var nomTablaOriginal=filaSel.get('nomTablaOriginal');
                                                                            var almacenDestino=gEx('gridConsidera').getStore();

                                                                            if(obtenerPosFila(almacenDestino,'nomTablaOriginal',nomTablaOriginal)==-1)
                                                                            {
                                                                                var nFila=new regTabla  (
                                                                                                            {
                                                                                                                nomTablaOriginal:filaSel.get('nomTablaOriginal'),
                                                                                                                tabla:filaSel.get('tabla'),
                                                                                                                tipoTabla:filaSel.get('tipoTabla'),
                                                                                                                proceso:filaSel.get('proceso')
                                                                                                            }
                                                                                                        )
                                                                                almacenDestino.add(nFila);
                                                                            }
                                                                            ventanaSelTabla.close();
                                                                        }
                                                                    }
                                                        }
                                        }
                                    )
   
    
    ventanaSelTabla = new Ext.Window(
                                            {
                                                title: 'Seleccione la tabla en la cual se basar&aacute; su consulta',
                                                width: 660 ,
                                                height:390,
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
                                                                btnAgregar,
                                                                {
                                                                    text: 'Cancelar',
                                                                    handler:function()
                                                                    {
                                                                        ventanaSelTabla.close();
                                                                    }
                                                                }
                                                            ]
                                            }
                                        );
                                        
	tblOpciones.getStore().load(
    								{	
                                    	params:	{
                                            		funcion:46
                                        		}	
                                    }
                               );                                        	
	ventanaSelTabla.show();                                        
	
}

function mostrarVentanaFiltro(objTabla,ocultarProy)
{
	var gridCampos=crearGridCampos(ocultarProy);
    var cmbOperacion=crearComboExt('cmbOperacion',arrOperaciones,180,5);
    cmbOperacion.on('select',funcCmbSelect);
    ocultarEt=false;
    if(ocultarProy)
    {
    	cmbOperacion.setValue('2');
        cmbOperacion.hide();
		ocultarEt=true;
        gridCampos.enable();
    }
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	id:'lblOperacion',
                                                        	x:10,
                                                            y:10,
                                                            html:'Indique la operaci&oacute;n a realizar:',
                                                            hidden:ocultarEt
                                                        },
                                                        cmbOperacion,
                                            			{
                                                        	x:10,
                                                            y:40,
                                                            html:'Seleccione los campos que desea proyectar en su consulta:'
                                                        },
														gridCampos
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Configuraci&oacute;n de filtro de consulta [<b>Tabla:</b> '+objTabla.nTablaUsr+']',
										width: 600,
										height:380,
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
															disabled:!ocultarEt,
                                                            id:'btnSiguiente',
															text: 'Siguiente',
															handler: function()
																	{
                                                                    	var op=cmbOperacion.getValue();
                                                                    	var filas=gridCampos.getSelectionModel().getSelections();
                                                                        if((filas.length==0)&&(op!='6'))
                                                                        {
                                                                        	msgBox('Debe seleccionar al menos un campo para relizar la operaci&oacute;n indicada');
                                                                        	return;
                                                                        }
                                                                        var cadCampos='';
                                                                        var x;
                                                                        for(x=0;x<filas.length;x++)
                                                                        {
                                                                        	if(cadCampos=='')
                                                                            	cadCampos=filas[x].get('nCamposO');
                                                                            else
                                                                            	cadCampos+=','+filas[x].get('nCamposO');
                                                                        }
                                                                        
                                                                    	var objCondiciones=	{
                                                                        						campos:cadCampos,
                                                                        						operacion:op,
                                                                                                arrCamposProy:filas,
                                                                        						dTabla:objTabla,
                                                                                                camposProy:arrCampos
                                                                        					};
                                                                       	ventanaAM.close();
                                                                        
																		mostrarVentanaCondFiltro(objCondiciones);
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
	llenarDatosCampos(ventanaAM,objTabla);                                

}

function crearGridCampos(ocultarProy)
{
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'nCamposO'},
                                                                    {name: 'nombreCampo'},
                                                                    {name: 'tipoDato'},
                                                                    {name: 'tipoCtrl'},
                                                                    {name: 'campoLlave'},
                                                                    {name: 'tablaO'},
                                                                    {name: 'tipoTabla'}
                                                                    
                                                                    
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel({singleSelect:!ocultarProy});
	chkRow.on('beforerowselect',filaSeleccionada);
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														chkRow,
														{
															header:'Campo',
															width:250,
															sortable:true,
															dataIndex:'nombreCampo'
														},
                                                        {
															header:'Campo llave',
															width:100,
															sortable:true,
															dataIndex:'campoLlave'
														},
                                                        {
                                                        	header:'Tipo',
                                                            width:100,
                                                            dataIndex:'tipoDato'
                                                        }
                                                        
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gridCampos',
                                                            store:alDatos,
                                                            frame:true,
                                                            x:10,
                                                            y:60,
                                                            cm: cModelo,
                                                            height:230,
                                                            width:550,
                                                            sm:chkRow,
                                                            disabled:true
                                                        }
                                                    );
	return 	tblGrid;
}

var arrEnteros=['int','float','decimal','double','bigint','numeric','real','smallint','tinyint','year'];
var arrTiempo=['date','time','timestamp'];

function filaSeleccionada(cm,fila,kExist,registro)
{
	var cmbOperacion=gEx('cmbOperacion');
    if(cmbOperacion==null)
    	return;
    var accion=cmbOperacion.getValue();
    var tipoDato=registro.get('tipoDato');
    switch(accion)	
    {
    	case '1':
        	if(validarCampoUnico())
            {
            	if(existeValorArreglo(arrEnteros,tipoDato)==-1)
                {
                	msgBox('El tipo de dato del campo seleccionado no es compatible con la operaci&oacute;n a realizar');
                	return false;
                }
            }
            else
            	return false;
        break;
        case '2':
        break;
        case '3':
        	if(validarCampoUnico())
            {
            	if(existeValorArreglo(arrEnteros,tipoDato)==-1)
                {
                	msgBox('El tipo de dato del campo seleccionado no es compatible con la operaci&oacute;n a realizar');
                	return false;
                }
            
            }
            else
            	return false;
        break;
        case '4':
        	if(validarCampoUnico())
            {
	          	if(existeValorArreglo(arrEnteros,tipoDato)==-1)
                {
                	if(existeValorArreglo(arrTiempo,tipoDato)==-1)
                    {
                        msgBox('El tipo de dato del campo seleccionado no es compatible con la operaci&oacute;n a realizar');
                        return false;
                    }
                }
            
            }
            else
            	return false;            
        break;
        case '5':
        	if(validarCampoUnico())
            {
            	if(existeValorArreglo(arrEnteros,tipoDato)==-1)
                {
                	if(existeValorArreglo(arrTiempo,tipoDato)==-1)
                    {
                        msgBox('El tipo de dato del campo seleccionado no es compatible con la operaci&oacute;n a realizar');
                        return false;
                    }
                }
            }
            else
            	return false;            
        break;
        case '6':
        break;
        case '7':
        	if(validarCampoUnico())
            {
            	if(existeValorArreglo(arrEnteros,tipoDato)==-1)
                {
                	msgBox('El tipo de dato del campo seleccionado no es compatible con la operaci&oacute;n a realizar');
                	return false;
                }
            
            }
            else
            	return false;            
        break;
    }
}

function validarCampoUnico()
{
	var grid=gEx('gridCampos');
	var fila=grid.getSelectionModel().getSelections();
    if(fila.length==0)
    	return true;
    else
    {
    	msgBox('La operaci&oacute;n seleccionada requiere que sea elegido solo un campo para su ejecuci&oacute;n');
    	return false;
    }
}

function funcCmbSelect(combo,registro)
{
	gEx('gridCampos').getSelectionModel().clearSelections();
	switch(registro.get('id'))
    {
    	case '1':
        	gEx('gridCampos').enable();
        break;
        case '2':
        	gEx('gridCampos').enable();
        break;
        case '3':
        	gEx('gridCampos').enable();
        break;
        case '4':
        	gEx('gridCampos').enable();
        break;
        case '5':
        	gEx('gridCampos').enable();
        break;
    	case '6':
        
        	gEx('gridCampos').disable();
        break;
        case '7':
        	gEx('gridCampos').enable();
        break;
    }
   	
    gEx('btnSiguiente').enable();
}

var arrCampos=null;

function llenarDatosCampos(ventana,objTabla)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	arrCampos=eval(arrResp[1]);
            gEx('gridCampos').getStore().loadData(arrCampos);
            ventana.show();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesThot.php',funcAjax, 'POST','funcion=8&nTabla='+bE(objTabla.nTablaO)+'&tTabla='+objTabla.tipoTabla,true);
}

var tipoCampoF;

var arrVarchar=[['<>','Distinto a'],['=','Igual a'],['in','Est\xE9 en'],['not in','No est\xE9 en'],['like \'valor%\'','Inicie con'],['like \'%valor\' ','Termine con'],['like \'%valor%\'','Contenga']];
var arrInt=[['>','Mayor que'],['>=','Mayor o igual que'],['<','Menor a'],['<=','Menor o igual que'],['<>','Distinto a'],['=','Igual a'],['in','Est\xE9 en'],['not in','No est\xE9 en']];
var arrCombo=[['<>','Distinto a'],['=','Igual a']];

var arrCamposTablas;

function mostrarVentanaCondFiltro(objFinal)
{
	filtroUsuario=new Array();
    filtroMysql=new Array();
    filtroTipoValor=new Array();
    var dsDatos= new Ext.data.SimpleStore	(
													{
														fields:	[
																	{name: 'nCamposO'},
                                                                    {name: 'nombreCampo'},
                                                                    {name: 'tipoDato'},
                                                                    {name: 'tipoCtrl'},
                                                                    {name: 'campoLlave'},
                                                                    {name: 'tablaO'},
                                                                    {name: 'tipoTabla'}
																]
													}
												);
	arrCamposTablas=objFinal.camposProy;                                           
    dsDatos.loadData(objFinal.camposProy);
	var comboEtapas=document.createElement('select');
    var comboTmp=document.createElement('select');
	var cmbCampo=new Ext.form.ComboBox	(
													{
														id:'cmbCampo',
														mode:'local',
														emptyText:'Elija una opci\xF3n',
														store:dsDatos,
														displayField:'nombreCampo',
														valueField:'nCamposO',
														transform:comboTmp,
														editable:false,
														typeAhead: true,
														triggerAction: 'all',
														lazyRender:true,
                                                        width:120,
														listWidth:270
													}
												)
    
    cmbCampo.setPosition(10,40);
    cmbCampo.setWidth(180);
    function setCondicionValor(combo,registro,indice)
    {
    	var nTabla=objFinal.dTabla.nTablaO;
        var cmbCondicion=Ext.getCmp('cmbCondicion');
        var arr;
        cmbCondicion.reset();
        tipoCampoF=registro.get('tipoDato');
        switch(tipoCampoF)
        {
            case 'optM':
            case 'optT':
                arr=arrCombo;
                mostrarCampoF('cmbValor');
                Ext.getCmp('cmbValor').reset();
                llenarOpciones(registro);
            break;
            case 'varchar':
            case 'text':
                arr=arrVarchar;
                Ext.getCmp('txtValor').setValue('');
                mostrarCampoF('txtValor');
            break;
            case 'smallint':
            case 'year':
            case 'bigint':
            case 'tinyint':
            case 'int':
            case 'varbinary':
                arr=arrInt;
                Ext.getCmp('intValor').setValue('0');
                mostrarCampoF('intValor');
            break;
            case 'numeric':
            case 'real':
            case 'double':
            case 'float':
            case 'decimal':
                arr=arrInt;
                Ext.getCmp('decValor').setValue('0.0');
                mostrarCampoF('decValor');
            break;
            case 'datetime':
            case 'date':
                arr=arrInt;
                mostrarCampoF('dteValor');
            break;
        }
        cmbCondicion.getStore().loadData(arr);
        cmbCondicion.focus(false,10);
    }
    
    
    cmbCampo.on('select',setCondicionValor);
    var condicion=crearComboGeneral('cmbCondicion',null,'<?php echo $etj["lblElijaOpcion"]?>');
    condicion.setPosition(200,40);
    condicion.setWidth(125);
    
    function setFocoValor(combo,registro,indice)
    {
    	switch(tipoCampoF)
        {
            case'optM':
            case 'optT':
                Ext.getCmp('cmbValor').focus(false,10);
            break;
            case 'varchar':
            case 'text':
            	Ext.getCmp('txtValor').focus(false,10);
            break;
            case 'smallint':
            case 'year':
            case 'bigint':
            case 'tinyint':
            case 'int':
            case 'varbinary':
                Ext.getCmp('intValor').focus(false,10);
            break;
            case 'numeric':
            case 'real':
            case 'double':
            case 'float':
            case 'decimal':
                Ext.getCmp('decValor').focus(false,10);
            break;
            case 'datetime':
            case 'date':
                Ext.getCmp('dteValor').focus(false,10);
            break;
        }
    	
    }
    
    condicion.on('select',setFocoValor);
    var valor=crearComboGeneral('cmbValor',null,'<?php echo $etj["lblElijaOpcion"]?>');
    valor.setPosition(335,40);
    valor.setWidth(185);
    
    var valorTxt=new Ext.form.TextField	(
    										{
                                            	id:'txtValor',
                                                width:130,
                                                x:335,
                                                y:40,
                                                hidden:true
                                                
                                            }	
    									)
    
    var valorDte=new Ext.form.DateField	(
    										{
                                            	id:'dteValor',
                                                width:100,
                                                x:335,
                                                y:40,
                                                hidden:true
                                            }
    									)
                                        
    var valorInt= new Ext.form.NumberField	(
                                                {
                                                    id:'intValor',
                                                    width:100,
                                                    x:335,
	                                                y:40,
                                                    hidden:true,
                                                    allowDecimals:false
                                                    
                                                }	
                                            )
                                            
	var valorDec= new Ext.form.TextField	(
                                                {
                                                    id:'decValor',
                                                    width:100,
                                                    x:335,
	                                                y:40,
                                                    hidden:true,
                                                    allowDecimals:true
                                                    
                                                }	
	                                           )                                                                            
    
    var gridOrden=crearGridOrden(objFinal.camposProy);
	
    var form = new Ext.form.FormPanel(	
                                        {
                                            baseCls: 'x-plain',
                                            layout:'absolute',
                                            defaultType: 'textfield',
                                            items: 	[
                                            
                                                        {
                                                            x:50,
                                                            y:15,
                                                            xtype:'label',
                                                            text:'Campo filtro:'
                                                        },
                                                        cmbCampo,
                                                        {
                                                            x:225,
                                                            y:15,
                                                            xtype:'label',
                                                            html:'Condici&oacute;n:'
                                                        },
                                                        condicion,
                                                        {
                                                            x:375,
                                                            y:15,
                                                            xtype:'label',
                                                            html:'Valor: <a href="javascript:ingresarParametroAlmacen()"><img src="../images/database_connect.png" title="Ingresar parametro de referencia" alt="Ingresar parametro de referencia"></a>'
                                                        },
                                                        valor,
                                                        valorTxt,
                                                        valorDte,
                                                        valorInt,
                                                        valorDec,
                                                        {
                                                            xtype:'panel',
                                                            x:10,
                                                            y:70,
                                                            baseCls: 'x-plain',
                                                            items:	[
                                                                         {
                                                                            xtype:'button',
                                                                            text:'Agregar',
                                                                            icon:'../images/mas.gif',
                                                                            cls:'x-btn-text-icon',
                                                                            handler:function()
                                                                                    {
                                                                                        if(cmbCampo.getValue()=='')
                                                                                        {
                                                                                            function resp()
                                                                                            {
                                                                                                cmbCampo.focus(false,10);
                                                                                            }
                                                                                            Ext.MessageBox.alert(lblAplicacion,'Debe seleccionar el campo bajo el cual se filtrar&aacute;a la informaci&oacute;n',resp);
                                                                                            return;
                                                                                        }
                                                                                        var campoMysql=cmbCampo.getValue();
                                                                                        var campoUsr=cmbCampo.getRawValue();
                                                                                        var condicionU;
                                                                                        var condicionM;
                                                                                        if(condicion.getValue()=='')
                                                                                        {
                                                                                            function resp()
                                                                                            {
                                                                                                condicion.focus(false,10);
                                                                                            }
                                                                                            Ext.MessageBox.alert(lblAplicacion,'Debe seleccionar la condici&oacute;n de comparaci&oacute;n',resp);
                                                                                            return;
                                                                                        }
                                                                                        condicionU=condicion.getRawValue();
                                                                                        condicionM=condicion.getValue();
                                                                                        var valorU='';
                                                                                        var valorM='';
                                                                                        
                                                                                        switch(tipoCampoF)
                                                                                        {
                                                                                            case 'optM':
                                                                                            case 'optT':
                                                                                                if(valor.getValue()=='')
                                                                                                {
                                                                                                    function resp()
                                                                                                    {
                                                                                                        valor.focus(false,10);
                                                                                                    }
                                                                                                    Ext.MessageBox.alert(lblAplicacion,'Debe ingresar el valor bajo el cual de filtrar&aacute; la informaci&oacute;n',resp);
                                                                                                    return;
                                                                                                }
                                                                                                valorM=valor.getValue();
                                                                                                valorU=valor.getRawValue();
                                                                                            break;
                                                                                            case 'varchar':
                                                                                            case 'text':
                                                                                                valorU="'"+valorTxt.getValue()+"'";
                                                                                                valorM="'"+valorTxt.getValue()+"'";
                                                                                            break;
                                                                                            case 'smallint':
                                                                                            case 'year':
                                                                                            case 'bigint':
                                                                                            case 'tinyint':
                                                                                            case 'int':
                                                                                            case 'varbinary':
                                                                                                if(valorInt.getRawValue()=='')
                                                                                                {
                                                                                                    function resp()
                                                                                                    {
                                                                                                        valorInt.focus(false,10);
                                                                                                    }
                                                                                                    Ext.MessageBox.alert(lblAplicacion,'Debe ingresar el valor bajo el cual de filtrar&aacute; la informaci&oacute;n',resp);
                                                                                                    return;
                                                                                                }
                                                                                                valorU=valorInt.getValue();
                                                                                                valorM=valorInt.getValue();
                                                                                                
                                                                                            break;
                                                                                            case 'numeric':
                                                                                            case 'real':
                                                                                            case 'double':
                                                                                            case 'float':
                                                                                            case 'decimal':
                                                                                                if(valorDec.getRawValue()=='')
                                                                                                {
                                                                                                    function resp()
                                                                                                    {
                                                                                                        valorDec.focus(false,10);
                                                                                                    }
                                                                                                    Ext.MessageBox.alert(lblAplicacion,'Debe ingresar el valor bajo el cual de filtrar&aacute; la informaci&oacute;n',resp);
                                                                                                    return;
                                                                                                }
                                                                                                valorU=valorDec.getValue();
                                                                                                valorM=valorDec.getValue();
                                                                                            break;
                                                                                            case 'date':
                                                                                            case 'datetime':
                                                                                                if(valorDte.getValue()=='')
                                                                                                {
                                                                                                    function resp()
                                                                                                    {
                                                                                                        valorDte.focus(false,10);
                                                                                                    }
                                                                                                    Ext.MessageBox.alert(lblAplicacion,'Debe ingresar el valor bajo el cual de filtrar&aacute; la informaci&oacute;n',resp);
                                                                                                    return;
                                                                                                }
                                                                                                valorU=valorDte.getValue().format('d/m/Y');
                                                                                                valorM="'"+valorDte.getValue().format('Y-m-d')+"'";
                                                                                                
                                                                                            break;
                                                                                            
                                                                                        }
                                                                                        var compA='';
                                                                                        var compC='';
                                                                                        if((condicionM=='in')||(condicionM=='not in'))
                                                                                        {
                                                                                        	compA='(';
                                                                                            compC=')';
                                                                                        }
                                                                                        var cadM='';
                                                                                        var cadU='';
                                                                                        if((condicionM.indexOf('like')!=-1))
                                                                                        {
                                                                                        	cadM=campoMysql+' '+condicionM.replace('valor',valorM.replace(/\'/gi,''));
                                                                                       	}
                                                                                        else
                                                                                        {
                                                                                            cadM=campoMysql+' '+condicionM+' '+compA+valorM+compC;
                                                                                            
                                                                                        }
                                                                                        cadU=campoUsr+' '+condicionU+' '+compA+valorU+compC;
                                                                                        filtroUsuario[filtroUsuario.length]=cadU;
                                                                                        filtroMysql[filtroMysql.length]=cadM;
                                                                                        filtroTipoValor[filtroTipoValor.length]='1|0';
                                                                                        generarSentencia();
                                                                                    }
                                                                         }
                                                                    ]
                                                            
                                                        
                                                               
                                                        },
                                                        {
                                                            xtype:'panel',
                                                            x:100,
                                                            y:70,
                                                            baseCls: 'x-plain',
                                                            items:	[
                                                                         {
                                                                             xtype:'button',
                                                                             text:'Remover',
                                                                             icon:'../images/menos.gif',
                                                                             cls:'x-btn-text-icon',
                                                                             handler:function()
                                                                                    {
                                                                                        if(filtroUsuario.length>0)
                                                                                        {
                                                                                            filtroUsuario.splice(filtroUsuario.length-1,1);
                                                                                            filtroMysql.splice(filtroMysql.length-1,1);
                                                                                            filtroTipoValor.splice(filtroTipoValor.length-1,1);
                                                                                            generarSentencia();
                                                                                        }
                                                                                    }
                                                                         }
                                                                    ]
                                                        },
                                                        {
                                                            xtype:'panel',
                                                            x:195,
                                                            y:70,
                                                            baseCls: 'x-plain',
                                                            items:	[
                                                                         {
                                                                         	 width:25,
                                                                             xtype:'button',
                                                                             text:'(',
                                                                             handler:function()
                                                                                    {
                                                                                        filtroUsuario[filtroUsuario.length]='(';
                                                                                        filtroMysql[filtroMysql.length]='(';
                                                                                        filtroTipoValor[filtroTipoValor.length]='0|0';
                                                                                        generarSentencia();
                                                                                    }
                                                                         }
                                                                    ]
                                                        },
                                                        {
                                                            xtype:'panel',
                                                            x:230,
                                                            y:70,
                                                            baseCls: 'x-plain',
                                                            items:	[
                                                                         {
                                                                         	width:25,
                                                                            xtype:'button',
                                                                            text:')',
                                                                            handler:function()
                                                                                    {
                                                                                        filtroUsuario[filtroUsuario.length]=')';
                                                                                        filtroMysql[filtroMysql.length]=')';
                                                                                        filtroTipoValor[filtroTipoValor.length]='0|0';
                                                                                        generarSentencia();
                                                                                    }
                                                                         }
                                                                    ]
                                                        },
                                                        {
                                                            xtype:'panel',
                                                            x:265,
                                                            y:70,
                                                            baseCls: 'x-plain',
                                                            items:	[
                                                                         {
                                                                         	width:25,
                                                                            xtype:'button',
                                                                            text:'Y',
                                                                            handler:function()
                                                                                    {
                                                                                        filtroUsuario[filtroUsuario.length]='Y';
                                                                                        filtroMysql[filtroMysql.length]='AND';
                                                                                        filtroTipoValor[filtroTipoValor.length]='0|0';
                                                                                        generarSentencia();
                                                                                    }
                                                                         }
                                                                    ]
                                                        },
                                                        {
                                                            xtype:'panel',
                                                            x:300,
                                                            y:70,
                                                            baseCls: 'x-plain',
                                                            items:	[
                                                                         {
                                                                         	 width:25,
                                                                             xtype:'button',
                                                                             text:'O',
                                                                             handler:function()
                                                                                    {
                                                                                        filtroUsuario[filtroUsuario.length]='O';
                                                                                        filtroMysql[filtroMysql.length]='OR';
                                                                                        filtroTipoValor[filtroTipoValor.length]='0|0';
                                                                                        generarSentencia();
                                                                                    }
                                                                         }
                                                                    ]
                                                        },
                                                        {
                                                            id:'txtConsulta',
                                                            xtype:'textarea',
                                                            x:10,
                                                            y:105,
                                                            width:500,
                                                            height:90,
                                                            readOnly:true
                                                        },
                                                        {
                                                        	x:10,
                                                            y:210,
                                                            html:'Orden registros:',
                                                            xtype:'label'
                                                        },
                                                        gridOrden
                                                    ]
                                        }
                                    );
		
	var ventanaOrigenDatosSel = new Ext.Window(
											{
												title: 'Generar Almac&eacute;n de datos [Tabla: '+objFinal.dTabla.nTablaO+']',
												width: 550,
												height:440,
												minWidth: 300,
												minHeight: 100,
												layout: 'fit',
												plain:true,
												modal:true,
												bodyStyle:'padding:5px;',
												buttonAlign:'center',
												items: form,
												buttons:	[
																{
																	id:'btnAceptar',
																	text: 'Finalizar',
																	listeners:	{
																					click:function()
																						{
                                                                                        	var sentenciaMysql='';
                                                                                            function funcAjax()
                                                                                            {
                                                                                            	var idReporte=gE('idFormulario').value;
                                                                                                var resp=peticion_http.responseText;
                                                                                                arrResp=resp.split('|');
                                                                                                var cadObj;
                                                                                                if(arrResp[0]=='1')
                                                                                                {
                                                                                                 	var x;
                                                                                                    var token;
                                                                                                    var arrTokens='';
                                                                                                    var datosTValor;
                                                                                                    var cadParametros='';
                                                                                                    var arrParamAux=new Array();
                                                                                                    for(x=0;x<filtroUsuario.length;x++)
                                                                                                    {
                                                                                                    	token='{"tokenUsuario":"'+(filtroUsuario[x])+'","tokenMysql":"'+(filtroMysql[x])+'","tokenTipo":"'+filtroTipoValor[x]+'"}';
                                                                                                        if(arrTokens=='')
                                                                                                        	arrTokens=token;
                                                                                                        else
                                                                                                        	arrTokens+=','+token;
                                                                                                        datosTValor=filtroTipoValor[x].split("|");
                                                                                                        if((datosTValor[0]=='5')||(datosTValor[0]=='6'))
                                                                                                        {
                                                                                                        	if(existeValorArreglo(arrParamAux,datosTValor[1])==-1)
                                                                                                            {
                                                                                                                if(cadParametros=='')
                                                                                                                    cadParametros=datosTValor[1];
                                                                                                                else
                                                                                                                    cadParametros+=','+datosTValor[1];  
                                                                                                                arrParamAux.push(datosTValor[1]); 
                                                                                                            }
                                                                                                    	}
                                                                                                    }
                                                                                                   
                                                                                                    var cadOrden='';
                                                                                                    var obj;
                                                                                                    var fila;
                                                                                                    for(x=0;x<gridOrden.getStore().getCount();x++)
                                                                                                    {
                                                                                                    	fila=gridOrden.getStore().getAt(x);
                                                                                                    	obj='{"campo":"'+fila.get('campo')+'","orden":"'+fila.get('orden')+'"}';
                                                                                                        if(cadOrden=='')
                                                                                                        	cadOrden=obj;
                                                                                                        else
                                                                                                        	cadOrden+=','+obj;
                                                                                                    
                                                                                                    }
                                                                                                    var x;
                                                                                                    var tAlmacen;
                                                                                                    if(nodoSel.attributes.tipo=='ad')
                                                                                                    	tAlmacen=0;
                                                                                                    else
                                                                                                    	tAlmacen=1;
                                                                                                    cadObj='"tipoDataSet":"<?php echo $tDataSet?>","tipoAlmacen":"'+tAlmacen+'","parametros":"'+cadParametros+'","nombreDataSet":"@nombreDS","descripcion":"@descripcion","idReporte":"'+idReporte+'","tabla":"'+objFinal.dTabla.nTablaO+'","camposProy":"'+objFinal.campos+'","operacion":"'+objFinal.operacion+'","arrOrden":"'+bE('['+cadOrden+']')+'","tokenSql":['+arrTokens+']';
                                                                                                    cadObj="{"+cadObj+"}";
                                                                                                    
                                                                                                    mostrarVentadaDatosDataSet(cadObj,ventanaOrigenDatosSel);
                                                                                                    
                                                                                                }
                                                                                                else
                                                                                                {
                                                                                                    Ext.MessageBox.alert(lblAplicacion,'La consulta ingresada presenta errores de sintaxis, por favor verifiquela');
                                                                                                    return;
                                                                                                }
                                                                                            }
                                                                                            obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=27&tb='+objFinal.dTabla.nTablaO+'&qry='+sentenciaMysql,true);
                                                                                            
																						}
																				}
																},
																{
																	text: '<?php echo $etj["lblBtnCancelar"]?>',
																	handler:function()
																			{
																				ventanaOrigenDatosSel.close();
																			}
																}
															]
											}
										);
                                        
	ventanaOrigenDatosSel.show();
}


var regOrden=crearRegistro([
                              {name: 'campo'},
                              {name: 'orden'}
                          ]
						);	

function crearGridOrden(aCampos)
{
	arrCampos=[];
	if(aCampos!=undefined)
    	arrCampos=aCampos;
        
	var arrOrden=[['0','Ascendente'],['1','Descendente']];
	var cmbOrden=crearComboExt('cmbOrden',arrOrden);
    var cmbCampos=crearComboExt('cmbCamposOrdenQuery',arrCampos);
    var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                {
                                                    fields:	[
                                                                {name: 'campo'},
                                                                {name: 'orden'}
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
															header:'Campo',
															width:220,
															sortable:true,
															dataIndex:'campo',
                                                            editor:cmbCampos,
                                                            renderer:function(val)
                                                            			{
                                                                        	return formatearValorRendererCombo(cmbCampos.getStore(),val,'id','nombre');
                                                                        }
														},
														{
															header:'Orden',
															width:90,
															sortable:true,
															dataIndex:'orden',
                                                            editor:cmbOrden,
                                                            renderer:function(val)
                                                            			{
                                                                        	return formatearValorRenderer(arrOrden,val);
                                                                        }
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                        	id:'gridOrden',
                                                            store:alDatos,
                                                            frame:true,
                                                            x:110,
                                                            y:205,
                                                            cm: cModelo,
                                                            height:150,
                                                            width:400,
                                                            sm:chkRow,
                                                            tbar:	[
                                                            			{
                                                                        	icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Agregar criterio de orden',
                                                                            handler:function()
                                                                            		{
                                                                                    	var r=new regOrden(
                                                                                        						{
                                                                                                                	campo:'',
                                                                                                                    orden:'0'
                                                                                                                }
                                                                                                           )
                                                                                   		tblGrid.getStore().add(r);
                                                                                    }
                                                                            
                                                                        },
                                                                        {
                                                                        	icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Remover criterio de orden',
                                                                            handler:function()
                                                                            		{
                                                                                    	var filas=tblGrid.getSelectionModel().getSelections();
                                                                                        if(filas.length==0)
                                                                                        {
                                                                                        	msgBox('Debe seleccionar almenos un criterio de orden a remover');
                                                                                        	return;
                                                                                        }
                                                                                        function resp(btn)
                                                                                        {
                                                                                        	if(btn=='yes')
                                                                                            {
                                                                                            	tblGrid.getStore().remove(filas);
                                                                                            }
                                                                                        }
                                                                                        msgConfirm('Est&aacute; seguro de querer remover los criterios seleccionados?',resp);
                                                                                    }
                                                                            
                                                                        }
                                                                        
                                                            		]
                                                        }
                                                    );
	return 	tblGrid;
}


function mostrarCampoF(idCampo)
{
	Ext.getCmp('cmbValor').hide();
	Ext.getCmp('txtValor').hide();
    Ext.getCmp('dteValor').hide();
    Ext.getCmp('intValor').hide();
    Ext.getCmp('decValor').hide();
    Ext.getCmp(idCampo).show();
}

function llenarOpciones(registro)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var datos=eval(arrResp[1]);
     		Ext.getCmp('cmbValor').getStore().loadData(datos);		   	  
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=26&tb='+registro.get('tablaO')+'&tipoTabla='+registro.get('tipoTabla')+'&campo='+registro.get('nCamposO'),true);
}

var sentenciaMysql;

function generarSentencia()
{
	var x;
    var txtConsulta='';
    sentenciaMysql='';
	for(x=0;x<filtroUsuario.length;x++)
    {
    	txtConsulta+=' '+filtroUsuario[x];
        sentenciaMysql+=' '+filtroMysql[x];
    }
    Ext.getCmp('txtConsulta').setValue(txtConsulta);
}

function guardarPreguntaAlmacen(objFinal,ventana)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	gEx('arbolDataSet').getRootNode().reload();
        	ventana.close();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesThot.php',funcAjax, 'POST','funcion=9&obj='+objFinal,true);
}

function modificarPregunta(objFinal,ventana)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	gEx('arbolDataSet').getRootNode().reload();
        	ventana.close();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesThot.php',funcAjax, 'POST','funcion=20&obj='+objFinal,true);
}

function mostrarVentadaDatosDataSet(cadObj,ventanaOrigenDatosSel)
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
                                                            html:'Nombre:'
                                                        },
                                                        {
                                                        	x:100,
                                                            y:5,
                                                            xtype:'textfield',
                                                            id:'txtNombre',
                                                            width:300
                                                            
                                                        },
                                                        
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            html:'Descripci&oacute;n:'
                                                        },
                                                        {
                                                        	x:100,
                                                            y:35,
                                                            xtype:'textarea',
                                                            id:'txtDescripcion',
                                                            width:300,
                                                            height:80
                                                            
                                                        }

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Guardar almac&eacute;n de datos',
										width: 500,
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
                                                                	gEx('txtNombre').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
                                                                    	var txtNombre=gEx('txtNombre') ;
                                                                        var txtDescripcion=gEx('txtDescripcion');
                                                                        if(txtNombre.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	txtNombre.focus();
                                                                            }
                                                                        	msgBox('Debe ingresar el nombre del almacen de datos',resp);
                                                                        }
                                                                        var nombre=txtNombre.getValue();
                                                                        var descripcion=txtDescripcion.getValue();
                                                                        var cadAux=cadObj.replace('@nombreDS',cv(nombre));
                                                                        cadAux=cadAux.replace('@descripcion',cv(descripcion));
                                                                        ventanaAM.close();
																		guardarPreguntaAlmacen(cadAux,ventanaOrigenDatosSel);
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

function ingresarParametroAlmacen()
{
	var cmbCampo=gEx('cmbCampo');
    var condicion=gEx('cmbCondicion');
    if(cmbCampo.getValue()=='')
    {
        function resp()
        {
            cmbCampo.focus(false,10);
        }
        Ext.MessageBox.alert(lblAplicacion,'Debe seleccionar el campo bajo el cual se filtrar&aacute; la informaci&oacute;n',resp);
        return;
    }
    
    if(condicion.getValue()=='')
    {
        function resp()
        {
            cmbCondicion.focus(false,10);
        }
        Ext.MessageBox.alert(lblAplicacion,'Debe seleccionar la condici&oacute;n de comparaci&oacute;n',resp);
        return;
    }

    var arrTipoEntrada=[['0','Campo de tabla'],['7','Consulta auxiliar'],['5','Nuevo par\xE1metro'],['6','Par\xE1metro registrado'],['16','Par\xE1metro de proceso'],['11','Valor de almac\xE9n'],['3','Valor de sesi\xF3n'],['4','Valor de sistema']];
    var cmbTipoValor=crearComboExt('cmbTipoValor',arrTipoEntrada,180,5);
    cmbTipoValor.on('select',funcTipoEntradaChangeParam);
    var cmbValor=crearComboExt('cmbValorAlmacen',[],180,35);
    cmbValor.setWidth(250);
    cmbValor.hide();
    var cmbAlmacen=crearComboExt('cmbAlmacen',[],180,35);
    cmbAlmacen.setWidth(250);
    cmbAlmacen.hide();
    
    cmbAlmacen.on('select',function(cmb,registro)
    						{
                            	var arrCampos=obtenerCamposDisponibles(registro.get('id'));
                            	gEx('cmbCampoParametro').getStore().loadData(arrCampos);
                            }
    			 )
    						
    
    var cmbCampoParametro=crearComboExt('cmbCampoParametro',[],180,65);
    cmbCampoParametro.setWidth(250);
    cmbCampoParametro.hide();
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:'Tipo de valor a asignar:'
                                                        },
                                                        cmbTipoValor,
                                                        {
                                                        	id:'lblValorAsigna',
                                                        	x:10,
                                                            y:40,
                                                            html:'Valor a asignar:'
                                                        },
                                                        {
                                                        	xtype:'textfield',
                                                        	id:'txtValorConstante',
                                                            x:180,
                                                            y:35
                                                        },
                                                        cmbValor,
                                                        {
                                                        	id:'lblAlmacen',
                                                        	x:10,
                                                            y:40,
                                                            html:'Seleccione almac&eacute;n:',
                                                            hidden:true
                                                        },
                                                        cmbAlmacen,
                                                        {
                                                        	id:'lblCampo',
                                                        	x:10,
                                                            y:70,
                                                            html:'Seleccione campo a utilizar:',
                                                            hidden:true
                                                        },
                                                        cmbCampoParametro
                                                        
													]
										}
									);
	
    
    var comboTmp=document.createElement('select');
	    
	var ventanaAM = new Ext.Window(
									{
										title: 'Asignar valor a par&aacute;metro',
										width: 470,
										height:180,
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
                                                                    	var compTipoValor='';
																		if(cmbTipoValor.getValue()=='')
                                                                        {
                                                                        	msgBox('Debe seleccionar el tipo de entrada al que pertenece el valor a asignar');
                                                                        	return;
                                                                        }
                                                                        var valorUsr;
                                                                        var valor;
                                                                        switch(cmbTipoValor.getValue())
                                                                        {
                                                                        	case '0':
                                                                            	valor=gEx('cmbValorAlmacen').getValue();
                                                                                valorUsr=gEx('cmbValorAlmacen').getRawValue();
                                                                            	compTipoValor='0';
                                                                            break;
                                                                        	case '5':
                                                                            	valor='@'+gEx('txtValorConstante').getValue();
                                                                                valorUsr='['+gEx('txtValorConstante').getValue()+' ('+valor+')]';
                                                                                var obj=new Array();
                                                                                obj[0]=valor;
                                                                                obj[1]=valor;
                                                                                compTipoValor=valor;
                                                                                arrParametrosAlmacen.push(obj);
                                                                            break;
                                                                            case '6':
                                                                            	valor=''+gEx('cmbValorAlmacen').getValue();
                                                                                valorUsr='['+gEx('cmbValorAlmacen').getValue().substring(1)+' ('+valor+')]';
                                                                                var obj=new Array();
                                                                                obj[0]=valor;
                                                                                obj[1]=valor;
                                                                                compTipoValor=valor;
                                                                                arrParametrosAlmacen.push(obj);
                                                                            break;
                                                                            case '7':
                                                                            	valor='@';
                                                                                valorUsr='['+gEx('cmbValorAlmacen').getRawValue()+']';
                                                                                compTipoValor=gEx('cmbValorAlmacen').getValue();
                                                                            break;
                                                                            case '11':
                                                                            	
                                                                                valor='@';
                                                                                var arbol=gEx('arbolDataSet').getRootNode();
                                                                                valorUsr='[Almac\xE9n: '+gEx('cmbAlmacen').getRawValue()+', Campo:'+gEx('cmbCampoParametro').getRawValue()+']';
                                                                                var nodoCampo=buscarNodoID(arbol,gEx('cmbCampoParametro').getValue());
                                                                                var nCampo;
                                                                                if(nodoCampo.nCampo!=undefined)
                                                                                	nCampo=nodoCampo.nCampo;
                                                                                else
                                                                                	nCampo=nodoCampo.attributes.nCampo;
                                                                                compTipoValor=gEx('cmbAlmacen').getValue()+'|'+nCampo;
                                                                                
                                                                            break;
                                                                            default:
                                                                            	if(cmbValor.getValue()=='')
                                                                                {
                                                                                	msgBox('Debe seleccionar el valor que desea asignar');
                                                                                	return;
                                                                                }
                                                                                var pos=obtenerPosFila(cmbValor.getStore(),'id',cmbValor.getValue());
                                                                                var fila=cmbValor.getStore().getAt(pos);
                                                                                valor='@'+fila.get('valorComp');
                                                                                valorUsr='['+cmbValor.getRawValue()+']';
                                                                                compTipoValor=cmbValor.getValue();
                                                                            break;
                                                                        }            
                                                                        
                                                                        var tipo=cmbTipoValor.getValue();
                                                                        var cmbCampo=gEx('cmbCampo');
                                                                        var campoMysql=cmbCampo.getValue();
                                                                        var campoUsr=cmbCampo.getRawValue();
                                                                        var cmbCondicion=gEx('cmbCondicion');
                                                                        var condicionU;
                                                                        var condicionM;
                                                                        condicionU=condicion.getRawValue();
                                                                        condicionM=condicion.getValue();
                                                                        var valorU=valorUsr;
                                                                        var valorM=valor;
                                                                        var compA='';
                                                                        var compC='';
                                                                         if((condicionM=='in')||(condicionM=='not in'))
                                                                        {
                                                                            compA='(';
                                                                            compC=')';
                                                                        }
                                                                        var cadM='';
                                                                        var cadU='';
                                                                        if((condicionM.indexOf('like')!=-1))
                                                                        {
                                                                            cadM=campoMysql+' '+condicionM.replace('valor',valorM.replace(/\'/gi,''));
                                                                        }
                                                                        else
                                                                        {
                                                                            cadM=campoMysql+' '+condicionM+' '+compA+valorM+compC;
                                                                            
                                                                        }
                                                                        cadU=campoUsr+' '+condicionU+' '+compA+valorU+compC;
                                                                        //var cadM=campoMyql+' '+condicionM+' '+compA+valorM+compC;
                                                                        //var cadU=campoUsr+' '+condicionU+' '+compA+valorU+compC;
                                                                        
                                                                        filtroUsuario[filtroUsuario.length]=cadU;
                                                                        filtroMysql[filtroMysql.length]=cadM;
                                                                        filtroTipoValor[filtroTipoValor.length]=tipo+'|'+compTipoValor;
                                                                        generarSentencia();
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

function funcTipoEntradaChangeParam(combo,registro)
{
	
	var txtValorConstante=gEx('txtValorConstante');
    txtValorConstante.hide();
    var cmbValor=gEx('cmbValorAlmacen');
    cmbValor.hide();
    var lblValorAsigna=gEx('lblValorAsigna');
    lblValorAsigna.hide();
    var lblAlmacen=gEx('lblAlmacen');
    lblAlmacen.hide();
    var cmbAlmacen=gEx('cmbAlmacen');
    cmbAlmacen.hide();
    var cmbCampo=gEx('cmbCampoParametro');
    cmbCampo.hide();
    var lblCampo=gEx('lblCampo');
    lblCampo.hide();
    var datosNodo=nodoSel.id;
	switch(registro.get('id'))
    {
    	case '0':
        	cmbValor.getStore().loadData(arrCamposTablas);
            cmbValor.show();
            lblValorAsigna.show();
        break;
    	case '5':
        	txtValorConstante.show();
            lblValorAsigna.show();
        break;
        
        case '3':
        	cmbValor.getStore().loadData(arrValorSesion);
        	cmbValor.show();
            lblValorAsigna.show();
        break;
        case '4':
        	cmbValor.getStore().loadData(arrValorSistema);
        	cmbValor.show();
            lblValorAsigna.show();
        break;
        case '6':
        	cmbValor.getStore().loadData(arrParametrosAlmacen);
        	cmbValor.show();
            lblValorAsigna.show();
        break;
        case '7':
        	var arrConsultaAux=new Array();
            var arbolDataSet=gEx('arbolDataSet');
            var raiz=arbolDataSet.getRootNode();
            var nodoConsulta=raiz.childNodes[1];
            var x;
            var obj;
            for(x=0;x<nodoConsulta.childNodes.length;x++)
            {
            	if(datosNodo[1]!=nodoConsulta.childNodes[x].id)
                {
                    obj=new Array();
                    obj[0]=nodoConsulta.childNodes[x].id;
                    obj[1]='Consulta: '+nodoConsulta.childNodes[x].text;
                    arrConsultaAux.push(obj);
                }
           	}
        	cmbValor.getStore().loadData(arrConsultaAux);
        	cmbValor.show();
            lblValorAsigna.show();
        break;
        case '11':
        	var arrAlmacenes=obtenerAlmacenesDatosDisponibles('1');
            cmbAlmacen.getStore().loadData(arrAlmacenes);
        	cmbAlmacen.show();
            lblAlmacen.show();
            lblCampo.show();
            cmbCampo.show();
            cmbCampo.reset();
        break;
        case '16':
        	cmbValor.getStore().loadData(arrProceso);
        	cmbValor.show();
            lblValorAsigna.show();
        break;
        
    }
}

function vincularAlmacenDatos(iE)
{
	var gridAlmacenesDatos=crearGridAlmacenDatos();
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                        	html:'Elija el almac&eacute;n de datos que desea vincular a la secci&oacute;n seleccionada:'
                                                        },
                                                        gridAlmacenesDatos
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Vincular secci&oacute;n con almac&eacute;n de datos',
										width: 590,
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
																		var fila=gridAlmacenesDatos.getSelectionModel().getSelected();
                                                                        if(fila==null)
                                                                        {
                                                                        	msgBox('Debe seleccionar el almac&eacute;n de datos que desea asignar como almacen de datos maestro de la secci&oacute;n');
                                                                        	return;
                                                                        }
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	g.gE('div_'+bD(iE)).setAttribute('almacenVinculado','1');
                                                                            	ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesThot.php',funcAjax, 'POST','funcion=13&idElemento='+iE+'&idAlmacen='+fila.get('idAlmacen'),true);
                                                                        
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

function crearGridAlmacenDatos()
{
	var arrAlmacenes=obtenerAlmacenesDisponibles();
	var dsDatos=arrAlmacenes;
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'idAlmacen'},
                                                                    {name: 'almacen'},
                                                                    {name: 'descripcion'}
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
															header:'Almac&eacute;n',
															width:150,
															sortable:true,
															dataIndex:'almacen'
														},
														{
															header:'Descripci&oacute;n',
															width:300,
															sortable:true,
															dataIndex:'descripcion'
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                         	id:'gridAlmacenesDatos' ,  
                                                            store:alDatos,
                                                            frame:true,
                                                            x:10,
                                                            y:40,
                                                            cm: cModelo,
                                                            height:300,
                                                            width:540,
                                                            sm:chkRow
                                                        }
                                                    );
	return 	tblGrid;	
}

function obtenerAlmacenesDisponibles()
{
	var arbolDataSet=gEx('arbolDataSet');
    var raiz=arbolDataSet.getRootNode();
    var x;
    var arrDatos=new Array();
    var obj;
    for(x=0;x<raiz.childNodes[0].childNodes.length;x++)	
    {
    	obj=new Array();
        obj[0]=raiz.childNodes[0].childNodes[x].id;
        obj[1]=raiz.childNodes[0].childNodes[x].text;
        obj[2]=raiz.childNodes[0].childNodes[x].attributes.descripcion;
        arrDatos.push(obj);
    }
	return arrDatos;
}

function administrarAlmacenDatos(iE)
{
	var arbolAlmacenesVinculados=crearAlbolAlmacenesVinculados(iE);
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														arbolAlmacenesVinculados

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
                                    	id:'vVincularDataset2',
										title: 'Almacenes de datos vinculados con la secci&oacute;n',
										width: 500,
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
															text: 'Cerrar',
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

function buscarAlmacen(id)
{
	var arbolDataSet=gEx('arbolDataSet');
    var raiz=arbolDataSet.getRootNode();
    var x;
    var arrDatos=new Array();
    var obj;
    for(x=0;x<raiz.childNodes[0].childNodes.length;x++)	
    {
    	if(raiz.childNodes[0].childNodes[x].id==id)
        	return raiz.childNodes[0].childNodes[x];
    }
	return null;
}

function crearAlbolAlmacenesVinculados(iE)
{
	
	g.setClase('td_'+bD(iE),'');	
	var cargadorArbol=new Ext.tree.TreeLoader(
												{
													baseParams:{
																	funcion:'14',
                                                                    idElemento:bD(iE)
																},
													dataUrl:'../paginasFunciones/funcionesThot.php'
												}
											)	



    var raiz=new  Ext.tree.AsyncTreeNode	(
                                                  {
                                                      
                                                      text:'DTD',
                                                      draggable:false,
                                                      expanded :true
                                                  }
                                            )

	panelArbol=new Ext.tree.TreePanel	(
                                              {
                                              	  id:'arbolAlmacenesV',
                                                  useArrows:true,
                                                  autoScroll:true,
                                                  animate:false,
                                                  enableDD:true,
                                                  height:330,
                                                  containerScroll:true,
                                                  root:raiz,
                                                  rootVisible:false,
												  loader: cargadorArbol,
                                                  tbar:	[
                                                  			{
                                                                icon:'../images/add.png',
                                                                tooltip:'Agregar los campos seleccionados a la secci&oacute;n padre',
                                                                cls:'x-btn-text-icon',
                                                                handler:function()
                                                                        {
                                                                            var arrCampos=panelArbol.getChecked();
                                                                            if(arrCampos.length==0)
                                                                            {
                                                                            	msgBox('Al menos debe seleccionar un campo para agregar a la secci&oacute;n');
                                                                                return;
                                                                            }
                                                                            var x;
                                                                            var cadCampos='';
                                                                            for(x=0;x<arrCampos.length;x++)
                                                                            {
                                                                            	if(cadCampos=='')
	                                                                            	cadCampos=arrCampos[x].text;
                                                                                else
                                                                                	cadCampos+=','+arrCampos[x].text;
                                                                                
                                                                            }
                                                                            tipoElemento=bD(iE);
                                                                            var obj='{"campos":"'+cadCampos+'","idElemento":"'+bD(iE)+'"}';
			                                                                function funcAjax()
                                                                            {
                                                                                var resp=peticion_http.responseText;
                                                                                arrResp=resp.split('|');
                                                                                if(arrResp[0]=='1')
                                                                                {
                                                                                	var arrControles=g.crearControlSeccion(arrResp[1],bD(iE));
                                                                                    g.tipoElemento='26';
																                    var x;
                                                                                    for(x=0;x<arrControles.length;x++)
                                                                                    	g.insertarControl(arrControles[x]);
                                                                                	gEx('vVincularDataset2').close();	
                                                                                }
                                                                                else
                                                                                {
                                                                                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                }
                                                                            }
                                                                            obtenerDatosWeb('../paginasFunciones/funcionesThot.php',funcAjax, 'POST','funcion=15&obj='+obj,true);
                                                                            
                                                                        }
                                                            }
                                                  		]
                                                                                                
                                               }
                                          );      
    //panelArbol.expandAll();
   // panelArbol.on('click',funcClickArbol);
    return panelArbol;	
}

function agregarCampoProy(idData)
{
	var idDataSet=idData;
    var selUnaOpcion;
    var cmbOperacion=crearComboExt('cmbOperacion',arrOperaciones,180,5);    
    var lblAceptar='Aceptar';
    if(idData!=undefined)
    {
   	    idDataSet=idData;
        selUnaOpcion=true;
        cmbOperacion.setValue('2');
        cmbOperacion.hide();
        lblAceptar='Siguiente >>';
    }
    else
    {
	    idDataSet=nodoSel.attributes.dSetPadre;
        if(nodoSel.attributes.categoria=='0')
        {
            selUnaOpcion=true;
            cmbOperacion.setValue('2');
            cmbOperacion.hide();
        }
        else
        {
            cmbOperacion.setValue(nodoSel.parentNode.attributes.operacion);
            selUnaOpcion=false;
        }
    }
	var gridCampos=crearGridCampos(selUnaOpcion);
	gridCampos.enable();
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	id:'lblOperacion',
                                                        	x:10,
                                                            y:10,
                                                            html:'Indique la operaci&oacute;n a realizar:',
                                                            hidden:selUnaOpcion
                                                        },
                                                        cmbOperacion,
                                            			{
                                                        	x:10,
                                                            y:30,
                                                            html:'Seleccione los campos que desea proyectar en su consulta:'
                                                        },
														gridCampos
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar campo a proyectar',
										width: 600,
										height:380,
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
															text: lblAceptar,
															handler: function()
																	{
                                                                          var filas=gridCampos.getSelectionModel().getSelections();
                                                                          if((filas.length==0)&&(lblAceptar=='Aceptar'))
                                                                          {
                                                                              msgBox('Debe seleccionar al menos un campo para relizar la operaci&oacute;n indicada');
                                                                              return;
                                                                          }
                                                                          var cadCampos='';
                                                                          var x;
                                                                          if(filas.length>0)
                                                                          {
                                                                              for(x=0;x<filas.length;x++)
                                                                              {
                                                                                  if(cadCampos=='')
                                                                                      cadCampos=filas[x].get('nCamposO');
                                                                                  else
                                                                                      cadCampos+=','+filas[x].get('nCamposO');
                                                                              }
                                                                              function funcAjax()
                                                                              {
                                                                                  var resp=peticion_http.responseText;
                                                                                  arrResp=resp.split('|');
                                                                                  if(arrResp[0]=='1')
                                                                                  {
                                                                                        gEx('arbolDataSet').getRootNode().reload();
                                                                                        ventanaAM.close();
                                                                                        if(lblAceptar!='Aceptar')
                                                                                            mostrarVentanaModifFiltro();
                                                                                  }
                                                                                  else
                                                                                  {
                                                                                      msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                  }
                                                                              }
                                                                              obtenerDatosWeb('../paginasFunciones/funcionesThot.php',funcAjax, 'POST','funcion=18&idDataSet='+idDataSet+'&cadCampos='+cadCampos+'&categoria='+nodoSel.attributes.categoria+'&operacion='+cmbOperacion.getValue(),true);
																			}																		
                                                                            else
                                                                            {
                                                                            	ventanaAM.close();
                                                                            	mostrarVentanaModifFiltro();
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
	llenarDatosCamposDset(ventanaAM,idData);	                            
}

function llenarDatosCamposDset(ventana,idData)
{
	var idDataSet;
    if(idData==undefined)
    	idDataSet=nodoSel.attributes.dSetPadre;
    else
    	idDataSet=idData;
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	arrCamposComp=eval(arrResp[1]);
            gEx('gridCampos').getStore().loadData(arrCamposComp);
            ventana.show();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesThot.php',funcAjax, 'POST','funcion=17&idDataSet='+idDataSet,true);
}

function mostrarVentanaModifFiltro()
{
	var gridOrden=crearGridOrden();
	filtroUsuario=new Array();
    filtroMysql=new Array();
    filtroTipoValor=new Array();
    var dsDatos= new Ext.data.SimpleStore	(
													{
														fields:	[
																	{name: 'nCamposO'},
                                                                    {name: 'nombreCampo'},
                                                                    {name: 'tipoDato'},
                                                                    {name: 'tipoCtrl'},
                                                                    {name: 'campoLlave'},
                                                                    {name: 'tablaO'},
                                                                    {name: 'tipoTabla'}
																]
													}
												);
	
	var comboEtapas=document.createElement('select');
    var comboTmp=document.createElement('select');
	var cmbCampo=new Ext.form.ComboBox	(
													{
														id:'cmbCampo',
														mode:'local',
														emptyText:'Elija una opci\xF3n',
														store:dsDatos,
														displayField:'nombreCampo',
														valueField:'nCamposO',
														transform:comboTmp,
														editable:false,
														typeAhead: true,
														triggerAction: 'all',
														lazyRender:true,
                                                        width:120,
														listWidth:270
													}
												)
	
    cmbCampo.setPosition(10,40);
    cmbCampo.setWidth(180);
    function setCondicionValor(combo,registro,indice)
	{
    	
		var nTabla=nodoSel.attributes.tabla;
        var cmbCondicion=Ext.getCmp('cmbCondicion');
        var arr;
        cmbCondicion.reset();
        tipoCampoF=registro.get('tipoDato');

        switch(tipoCampoF)
        {
            case 'optM':
            case 'optT':
                arr=arrCombo;
                mostrarCampoF('cmbValor');
                Ext.getCmp('cmbValor').reset();
                llenarOpciones(registro);
            break;
            case 'varchar':
            case 'text':
                arr=arrVarchar;
                Ext.getCmp('txtValor').setValue('');
                mostrarCampoF('txtValor');
            break;
            case 'smallint':
            case 'year':
            case 'bigint':
            case 'tinyint':
            case 'int':
            case 'varbinary':
                arr=arrInt;
                Ext.getCmp('intValor').setValue('0');
                mostrarCampoF('intValor');
            break;
            case 'numeric':
            case 'real':
            case 'double':
            case 'float':
            case 'decimal':
                arr=arrInt;
                Ext.getCmp('decValor').setValue('0.0');
                mostrarCampoF('decValor');
            break;
            case 'datetime':
            case 'date':
                arr=arrInt;
                mostrarCampoF('dteValor');
            break;
        }
        cmbCondicion.getStore().loadData(arr);
        cmbCondicion.focus(false,10);
    }    
    
    cmbCampo.on('select',setCondicionValor);
    var condicion=crearComboGeneral('cmbCondicion',null,'<?php echo $etj["lblElijaOpcion"]?>');
    condicion.setPosition(200,40);
    condicion.setWidth(125);
    
    function setFocoValor(combo,registro,indice)
    {
    	switch(tipoCampoF)
        {
            case'optM':
            case 'optT':
                Ext.getCmp('cmbValor').focus(false,10);
            break;
            case 'text':
            case 'varchar':
            	Ext.getCmp('txtValor').focus(false,10);
            break;
            case 'smallint':
            case 'year':
            case 'bigint':
            case 'tinyint':
            case 'int':
            case 'varbinary':
                Ext.getCmp('intValor').focus(false,10);
            break;
            case 'numeric':
            case 'real':
            case 'double':
            case 'float':
            case 'decimal':
                Ext.getCmp('decValor').focus(false,10);
            break;
            case 'datetime':
            case 'date':
                Ext.getCmp('dteValor').focus(false,10);
            break;
        }
    	
    }
    
    condicion.on('select',setFocoValor);
    var valor=crearComboGeneral('cmbValor',null,'<?php echo $etj["lblElijaOpcion"]?>');
    valor.setPosition(335,40);
    valor.setWidth(185);
    var ocultarLblError=true;
    
    if(nodoSel.attributes.arrErrores.length>0)
		ocultarLblError=false;    	
    
    var valorTxt=new Ext.form.TextField	(
    										{
                                            	id:'txtValor',
                                                width:130,
                                                x:335,
                                                y:40,
                                                hidden:true
                                                
                                            }	
    									)
    
    var valorDte=new Ext.form.DateField	(
    										{
                                            	id:'dteValor',
                                                width:100,
                                                x:335,
                                                y:40,
                                                hidden:true
                                            }
    									)
                                        
    var valorInt= new Ext.form.NumberField	(
                                                {
                                                    id:'intValor',
                                                    width:100,
                                                    x:335,
	                                                y:40,
                                                    hidden:true,
                                                    allowDecimals:false
                                                    
                                                }	
                                            )
                                            
	var valorDec= new Ext.form.TextField	(
                                                {
                                                    id:'decValor',
                                                    width:100,
                                                    x:335,
	                                                y:40,
                                                    hidden:true,
                                                    allowDecimals:true
                                                    
                                                }	
                                            )                                                                            
    
	var form = new Ext.form.FormPanel(	
                                        {
                                            baseCls: 'x-plain',
                                            layout:'absolute',
                                            defaultType: 'textfield',
                                            items: 	[
                                            
                                                        {
                                                            x:50,
                                                            y:15,
                                                            xtype:'label',
                                                            text:'Campo filtro:'
                                                        },
                                                        cmbCampo,
                                                        {
                                                            x:225,
                                                            y:15,
                                                            xtype:'label',
                                                            html:'Condici&oacute;n:'
                                                        },
                                                        condicion,
                                                        {
                                                            x:375,
                                                            y:15,
                                                            xtype:'label',
                                                            html:'Valor: <a href="javascript:ingresarParametroAlmacen()"><img src="../images/database_connect.png" title="Ingresar parametro de referencia" alt="Ingresar parametro de referencia"></a>'
                                                        },
                                                        valor,
                                                        valorTxt,
                                                        valorDte,
                                                        valorInt,
                                                        valorDec,
                                                        {
                                                            xtype:'panel',
                                                            x:10,
                                                            y:70,
                                                            baseCls: 'x-plain',
                                                            items:	[
                                                                         {
                                                                            xtype:'button',
                                                                            text:'Agregar',
                                                                            icon:'../images/mas.gif',
                                                                            cls:'x-btn-text-icon',
                                                                            handler:function()
                                                                                    {
                                                                                        if(cmbCampo.getValue()=='')
                                                                                        {
                                                                                            function resp()
                                                                                            {
                                                                                                cmbCampo.focus(false,10);
                                                                                            }
                                                                                            Ext.MessageBox.alert(lblAplicacion,'Debe seleccionar el campo bajo el cual se filtrar&aacute; la informaci&oacute;n',resp);
                                                                                            return;
                                                                                        }
                                                                                        var campoMysql=cmbCampo.getValue();
                                                                                        var campoUsr=cmbCampo.getRawValue();
                                                                                        var condicionU;
                                                                                        var condicionM;
                                                                                        if(condicion.getValue()=='')
                                                                                        {
                                                                                            function resp()
                                                                                            {
                                                                                                condicion.focus(false,10);
                                                                                            }
                                                                                            Ext.MessageBox.alert(lblAplicacion,'Debe seleccionar la condici&oacute;n de comparaci&oacute;n',resp);
                                                                                            return;
                                                                                        }
                                                                                        condicionU=condicion.getRawValue();
                                                                                        condicionM=condicion.getValue();
                                                                                        var valorU='';
                                                                                        var valorM='';
                                                                                        
                                                                                        switch(tipoCampoF)
                                                                                        {
                                                                                            case 'optM':
                                                                                            case 'optT':
                                                                                                if(valor.getValue()=='')
                                                                                                {
                                                                                                    function resp()
                                                                                                    {
                                                                                                        valor.focus(false,10);
                                                                                                    }
                                                                                                    Ext.MessageBox.alert(lblAplicacion,'Debe ingresar el valor bajo el cual de filtrar&aacute; la informaci&oacute;n',resp);
                                                                                                    return;
                                                                                                }
                                                                                                valorM=valor.getValue();
                                                                                                valorU=valor.getRawValue();
                                                                                            break;
                                                                                            case 'varchar':
                                                                                            case 'text':
                                                                                                valorU="'"+valorTxt.getValue()+"'";
                                                                                                valorM="'"+valorTxt.getValue()+"'";
                                                                                            break;
                                                                                            case 'smallint':
                                                                                            case 'year':
                                                                                            case 'bigint':
                                                                                            case 'tinyint':
                                                                                            case 'int':
                                                                                            case 'varbinary':
                                                                                                if(valorInt.getRawValue()=='')
                                                                                                {
                                                                                                    function resp()
                                                                                                    {
                                                                                                        valorInt.focus(false,10);
                                                                                                    }
                                                                                                    Ext.MessageBox.alert(lblAplicacion,'Debe ingresar el valor bajo el cual de filtrar&aacute; la informaci&oacute;n',resp);
                                                                                                    return;
                                                                                                }
                                                                                                valorU=valorInt.getValue();
                                                                                                valorM=valorInt.getValue();
                                                                                                
                                                                                            break;
                                                                                            case 'numeric':
                                                                                            case 'real':
                                                                                            case 'double':
                                                                                            case 'float':
                                                                                            case 'decimal':
                                                                                                if(valorDec.getRawValue()=='')
                                                                                                {
                                                                                                    function resp()
                                                                                                    {
                                                                                                        valorDec.focus(false,10);
                                                                                                    }
                                                                                                    Ext.MessageBox.alert(lblAplicacion,'Debe ingresar el valor bajo el cual de filtrar&aacute; la informaci&oacute;n',resp);
                                                                                                    return;
                                                                                                }
                                                                                                valorU=valorDec.getValue();
                                                                                                valorM=valorDec.getValue();
                                                                                            break;
                                                                                            case 'datetime':
                                                                                            case 'date':
                                                                                                if(valorDte.getValue()=='')
                                                                                                {
                                                                                                    function resp()
                                                                                                    {
                                                                                                        valorDte.focus(false,10);
                                                                                                    }
                                                                                                    Ext.MessageBox.alert(lblAplicacion,'Debe ingresar el valor bajo el cual de filtrar&aacute; la informaci&oacute;n',resp);
                                                                                                    return;
                                                                                                }
                                                                                                valorU=valorDte.getValue().format('d/m/Y');
                                                                                                valorM="'"+valorDte.getValue().format('Y-m-d')+"'";
                                                                                                
                                                                                            break;
                                                                                            
                                                                                        }
                                                                                        
                                                                                        var compA='';
                                                                                        var compC='';
                                                                                        if((condicionM=='in')||(condicionM=='not in'))
                                                                                        {
                                                                                        	compA='(';
                                                                                            compC=')';
                                                                                        }
                                                                                        
                                                                                        var cadM='';
                                                                                        var cadU='';
                                                                                        if((condicionM.indexOf('like')!=-1))
                                                                                        {
                                                                                        	cadM=campoMysql+' '+condicionM.replace('valor',valorM.replace(/\'/gi,''));
                                                                                       	}
                                                                                        else
                                                                                        {
                                                                                            cadM=campoMysql+' '+condicionM+' '+compA+valorM+compC;
                                                                                            
                                                                                        }
                                                                                        cadU=campoUsr+' '+condicionU+' '+compA+valorU+compC;
                                                                                        filtroUsuario[filtroUsuario.length]=cadU;
                                                                                        filtroMysql[filtroMysql.length]=cadM;
                                                                                        filtroTipoValor[filtroTipoValor.length]='1|0';
                                                                                        generarSentencia();
                                                                                    }
                                                                         }
                                                                    ]
                                                            
                                                        
                                                               
                                                        },
                                                        {
                                                            xtype:'panel',
                                                            x:100,
                                                            y:70,
                                                            baseCls: 'x-plain',
                                                            items:	[
                                                                         {
                                                                             xtype:'button',
                                                                             text:'Remover',
                                                                             icon:'../images/menos.gif',
                                                                             cls:'x-btn-text-icon',
                                                                             handler:function()
                                                                                    {
                                                                                        if(filtroUsuario.length>0)
                                                                                        {
                                                                                            filtroUsuario.splice(filtroUsuario.length-1,1);
                                                                                            filtroMysql.splice(filtroMysql.length-1,1);
                                                                                            filtroTipoValor.splice(filtroTipoValor.length-1,1);
                                                                                            generarSentencia();
                                                                                        }
                                                                                    }
                                                                         }
                                                                    ]
                                                        },
                                                        {
                                                            xtype:'panel',
                                                            x:195,
                                                            y:70,
                                                            baseCls: 'x-plain',
                                                            items:	[
                                                                         {
                                                                         	 width:25,
                                                                             xtype:'button',
                                                                             text:'(',
                                                                             handler:function()
                                                                                    {
                                                                                        filtroUsuario[filtroUsuario.length]='(';
                                                                                        filtroMysql[filtroMysql.length]='(';
                                                                                        filtroTipoValor[filtroTipoValor.length]='0|0';
                                                                                        generarSentencia();
                                                                                    }
                                                                         }
                                                                    ]
                                                        },
                                                        {
                                                            xtype:'panel',
                                                            x:230,
                                                            y:70,
                                                            baseCls: 'x-plain',
                                                            items:	[
                                                                         {
                                                                         	width:25,
                                                                            xtype:'button',
                                                                            text:')',
                                                                            handler:function()
                                                                                    {
                                                                                        filtroUsuario[filtroUsuario.length]=')';
                                                                                        filtroMysql[filtroMysql.length]=')';
                                                                                        filtroTipoValor[filtroTipoValor.length]='0|0';
                                                                                        generarSentencia();
                                                                                    }
                                                                         }
                                                                    ]
                                                        },
                                                        
                                                        {
                                                            xtype:'panel',
                                                            x:265,
                                                            y:70,
                                                            baseCls: 'x-plain',
                                                            items:	[
                                                                         {
                                                                         	width:25,
                                                                            xtype:'button',
                                                                            text:'Y',
                                                                            handler:function()
                                                                                    {
                                                                                        filtroUsuario[filtroUsuario.length]='Y';
                                                                                        filtroMysql[filtroMysql.length]='AND';
                                                                                        filtroTipoValor[filtroTipoValor.length]='0|0';
                                                                                        generarSentencia();
                                                                                    }
                                                                         }
                                                                    ]
                                                        },
                                                        {
                                                            xtype:'panel',
                                                            x:300,
                                                            y:70,
                                                            baseCls: 'x-plain',
                                                            items:	[
                                                                         {
                                                                         	 width:25,
                                                                             xtype:'button',
                                                                             text:'O',
                                                                             handler:function()
                                                                                    {
                                                                                        filtroUsuario[filtroUsuario.length]='O';
                                                                                        filtroMysql[filtroMysql.length]='OR';
                                                                                        filtroTipoValor[filtroTipoValor.length]='1|0';
                                                                                        generarSentencia();
                                                                                    }
                                                                         }
                                                                    ]
                                                        },
                                                         {
                                                            x:10,
                                                            y:80,
                                                            xtype:'label',
                                                            hidden:ocultarLblError,
                                                            html:'<font color="#990000">La consulta presenta errores, para m&aacute;s detalles de click </font><a href="javascript:mostrarVentanaErrores()"><font color="#FF0000"><b>AQU&Iacute;</b></font></a>'
                                                        }
                                                        ,
                                                        {
                                                            id:'txtConsulta',
                                                            xtype:'textarea',
                                                            x:10,
                                                            y:105,
                                                            width:500,
                                                            height:90,
                                                            readOnly:true
                                                        },
                                                        {
                                                        	x:10,
                                                            y:210,
                                                            html:'Orden registros:',
                                                            xtype:'label'
                                                        },
                                                        gridOrden
                                                    ]
                                        }
                                    );
		
	var ventanaOrigenDatosSel = new Ext.Window(
											{
												title: 'Modificar condici&oacute;nes de filtrado',
												width: 550,
												height:440,
												minWidth: 300,
												minHeight: 100,
												layout: 'fit',
												plain:true,
												modal:true,
												bodyStyle:'padding:5px;',
												buttonAlign:'center',
												items: form,
												buttons:	[
																{
																	id:'btnAceptar',
																	text: 'Finalizar',
																	listeners:	{
																					click:function()
																						{
                                                                                        	var sentenciaMysql='';
                                                                                            function funcAjax()
                                                                                            {
                                                                                            	
                                                                                                var resp=peticion_http.responseText;
                                                                                                arrResp=resp.split('|');
                                                                                                var cadObj;
                                                                                                if(arrResp[0]=='1')
                                                                                                {
                                                                                                 	var x;
                                                                                                    var token;
                                                                                                    var arrTokens='';
                                                                                                    var datosTValor='';
                                                                                                    var cadParametros='';
                                                                                                    var arrParamAux=new Array();
                                                                                                    for(x=0;x<filtroUsuario.length;x++)
                                                                                                    {
                                                                                                    	token='{"tokenUsuario":"'+(filtroUsuario[x])+'","tokenMysql":"'+(filtroMysql[x])+'","tokenTipo":"'+filtroTipoValor[x]+'"}';
                                                                                                        if(arrTokens=='')
                                                                                                        	arrTokens=token;
                                                                                                        else
                                                                                                        	arrTokens+=','+token;
                                                                                                        
                                                                                                       	datosTValor=filtroTipoValor[x].split("|");
                                                                                                        if((datosTValor[0]=='5')||(datosTValor[0]=='6'))
                                                                                                        {
                                                                                                        	if(existeValorArreglo(arrParamAux,datosTValor[1])==-1)
                                                                                                            {
                                                                                                                if(cadParametros=='')
                                                                                                                    cadParametros=datosTValor[1];
                                                                                                                else
                                                                                                                    cadParametros+=','+datosTValor[1];  
                                                                                                                arrParamAux.push(datosTValor[1]); 
                                                                                                            }
                                                                                                    	}
                                                                                                    }
                                                                                                    var cadOrden='';
                                                                                                    var obj;
                                                                                                    var fila;
                                                                                                    for(x=0;x<gridOrden.getStore().getCount();x++)
                                                                                                    {
                                                                                                    	fila=gridOrden.getStore().getAt(x);
                                                                                                    	obj='{"campo":"'+fila.get('campo')+'","orden":"'+fila.get('orden')+'"}';
                                                                                                        if(cadOrden=='')
                                                                                                        	cadOrden=obj;
                                                                                                        else
                                                                                                        	cadOrden+=','+obj;
                                                                                                    
                                                                                                    }
                                                                                                    cadObj='"parametros":"'+cadParametros+'","idAlmacen":"'+nodoSel.id+'","arrOrden":"'+bE('['+cadOrden+']')+'","tokenSql":['+arrTokens+']';
                                                                                                    cadObj="{"+cadObj+"}"; 
                                                                                                   	modificarPregunta(cadObj,ventanaOrigenDatosSel);
                                                                                                }
                                                                                                else
                                                                                                {
                                                                                                    Ext.MessageBox.alert(lblAplicacion,'La consulta ingresada presenta errores de sintaxis, por favor verifiquela');
                                                                                                    return;
                                                                                                }
                                                                                            }
                                                                                            obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=27&tb='+nodoSel.attributes.objJava.tabla+'&qry='+sentenciaMysql,true);
                                                                                            
																						}
																				}
																},
																{
																	text: '<?php echo $etj["lblBtnCancelar"]?>',
																	handler:function()
																			{
																				ventanaOrigenDatosSel.close();
																			}
																}
															]
											}
										);
                                        
	llenarCondicionesFiltrado(ventanaOrigenDatosSel);
}

function llenarCondicionesFiltrado(ventana)
{
	var datosTValor='';
    arrParametrosAlmacen=new Array();
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        		var x;
                for(x=0;x<nodoSel.attributes.objJava.condicion.length;x++)
                {
                    filtroUsuario.push(nodoSel.attributes.objJava.condicion[x].tokenUsuario);
                    filtroMysql.push(nodoSel.attributes.objJava.condicion[x].tokenMysql);
                    filtroTipoValor.push(nodoSel.attributes.objJava.condicion[x].tokenTipo);
                    datosTValor=nodoSel.attributes.objJava.condicion[x].tokenTipo.split("|");
                    if((datosTValor[0]=='6')||(datosTValor[0]=='5'))
                    {
                        if(existeValorMatriz(arrParametrosAlmacen,datosTValor[1],0)==-1)
                        {
                            var obj=new Array();
                            obj[0]=datosTValor[1];
                            obj[1]=datosTValor[1];
                            
                            
                            
                            arrParametrosAlmacen.push(obj);
                        }
                	}
                }
                generarSentencia();
                arrCamposTablas=eval(arrResp[1]);
                gEx('cmbCampo').getStore().loadData(arrCamposTablas);
                gEx('cmbCamposOrdenQuery').getStore().loadData(arrCamposTablas);
                gEx('gridOrden').getStore().loadData(nodoSel.attributes.orden);
                ventana.show();

        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesThot.php',funcAjax, 'POST','funcion=8&idDataSet='+nodoSel.attributes.id,true);

}

function mostrarVentanaModificarNombre()
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
                                                            html:'Nombre:'
                                                           
                                                        },
                                                        {
                                                        	x:100,
                                                            y:5,
                                                            xtype:'textfield',
                                                            id:'txtNombre',
                                                            width:300,
                                                            value:nodoSel.text
                                                            
                                                        },
                                                        
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            html:'Descripci&oacute;n:'
                                                        },
                                                        {
                                                        	x:100,
                                                            y:35,
                                                            xtype:'textarea',
                                                            id:'txtDescripcion',
                                                            width:300,
                                                            height:80,
                                                            value:nodoSel.attributes.descripcion
                                                            
                                                        }

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Guardar almac&eacute;n de datos',
										width: 500,
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
                                                                	gEx('txtNombre').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
                                                                    	var txtNombre=gEx('txtNombre') ;
                                                                        var txtDescripcion=gEx('txtDescripcion');
                                                                        if(txtNombre.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	txtNombre.focus();
                                                                            }
                                                                        	msgBox('Debe ingresar el nombre del almacen de datos',resp);
                                                                        }
                                                                        var nombre=txtNombre.getValue();
                                                                        var descripcion=txtDescripcion.getValue();
                                                                        var idAlmacen=nodoSel.id;
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	ventanaAM.close();
                                                                                gEx('arbolDataSet').getRootNode().reload();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesThot.php',funcAjax, 'POST','funcion=21&idAlmacen='+idAlmacen+'&nombre='+cv(nombre)+'&descripcion='+cv(descripcion),true);
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

function mostrarVentanaTablasInvolucradasModif(ocultarProy)
{
	var gridTablasInv=crearGridConsiderarTablas(ocultarProy,true);
    gridTablasInv.getStore().on('add',funcAgregaFila);
    
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														gridTablasInv
													]
										}
									);
	
    
     btnSiguiente=new Ext.Button	(
                                        {
                                            text: 'Siguiente >>',
                                            minWidth:80,
                                            id:'btnFinalizar',
                                            listeners:	{
                                                            click:
                                                                    {
                                                                        fn:function()
                                                                        {	
                                                                        	ventanaAM.close();
                                                                            agregarCampoProy(nodoSel.id);
                                                                            
                                                                        }
                                                                    }
                                                        }
                                        }
                                    )
    
	var ventanaAM = new Ext.Window(
									{
										title: 'Tablas involucradas en el almac&eacute;n',
										width: 850,
										height:370,
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
														btnSiguiente,
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
	llenarTablasInvolucradas(ventanaAM);                                
	
}

function funcAgregaFila(almacen,registro)
{
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
    obtenerDatosWeb('../paginasFunciones/funcionesThot.php',funcAjax, 'POST','funcion=23&nTabla='+registro[0].get('nomTablaOriginal')+'&idAlmacen='+nodoSel.id,true);
}

function llenarTablasInvolucradas(ventanaAM)
{
	var idAlmacen=nodoSel.id;
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	gEx('gridConsidera').getStore().loadData(eval(arrResp[1]));
            ventanaAM.show();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesThot.php',funcAjax, 'POST','funcion=22&idAlmacen='+idAlmacen,true);
}

function mostrarVentanaErrores()
{
	var gridErrores=crearGridErrores();
    var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														gridErrores

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Listado de errores detectados en la consulta',
										width: 880,
										height:380,
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

function crearGridErrores()
{
	var dsDatos=nodoSel.attributes.arrErrores;
    var alDatos=	new Ext.data.SimpleStore	(
                                                {
                                                    fields:	[
                                                                
                                                                {name: 'errores'}
                                                            ]
                                                }
                                            );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel();
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														
														{
															header:'Errores detectados',
															width:780,
															sortable:true,
															dataIndex:'errores'
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            
                                                            store:alDatos,
                                                            frame:true,
                                                            y:10,
                                                            cm: cModelo,
                                                            height:260,
                                                            width:850,
                                                            sm:chkRow
                                                        }
                                                    );
	return 	tblGrid;		
}

function obtenerAlmacenesDatosDisponibles(tAlmacen)
{
	var nodoAlmacen;
	if(tAlmacen=='1')
    	nodoAlmacen=gEx('arbolDataSet').getNodeById('0');
    else
    	nodoAlmacen=gEx('arbolDataSet').getNodeById('-10');
    var arrHijos=obtenerHijosNodoArbol(nodoAlmacen);    
	var x;
    var arrDatos=new Array();
    var obj;
    for(x=0;x<arrHijos.length;x++)	
    {
    	obj=new Array();
        obj[0]=arrHijos[x].id;
        obj[1]=arrHijos[x].text;
        arrDatos.push(obj);
    }
	return arrDatos;
}

function obtenerCamposDisponibles(id)
{
	var nodoAlmacen=buscarNodoID(gEx('arbolDataSet').getRootNode(),'c_'+id);
    var arrHijos=obtenerHijosNodoArbol(nodoAlmacen);    
	var x;
    var arrDatos=new Array();
    var obj;
    for(x=0;x<arrHijos.length;x++)	
    {
    	obj=new Array();
        obj[0]=arrHijos[x].id;
        obj[1]=arrHijos[x].text;
        arrDatos.push(obj);
    }
	return arrDatos;
}

function mostrarVentanaConfigurarAlmacenRemoto()
{
	var arrServidores=[['1','Servidor MySQL'],['2','Servidor SQLServer'],['2','Servidor PostgreSQL'],['3','Servidor IBM DB2']];
    var cmbServidor=crearComboExt('cmbServidor',arrServidores,140,5,250);
    var cmbBaseDatos=crearComboExt('cmbBaseDatos',[],140,125,250);
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:'Tipo de servidor:'
                                                        },
                                                        cmbServidor,
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            html:'Dirección del host:'
                                                        },
                                                        {
                                                        	x:140,
                                                            y:35,
                                                            xtype:'textfield',
                                                            width:200
                                                        },
                                                         {
                                                        	x:10,
                                                            y:70,
                                                            html:'Usuario:'
                                                        },
                                                        {
                                                        	x:140,
                                                            y:65,
                                                            xtype:'textfield',
                                                            width:200
                                                        },
                                                        {
                                                        	x:10,
                                                            y:100,
                                                            html:'Contrase&ntilde;a:'
                                                        },
                                                        {
                                                        	x:140,
                                                            y:95,
                                                            xtype:'textfield',
                                                            inputType :'password',
                                                            width:200
                                                        },
                                                        {
                                                        	x:10,
                                                            y:130,
                                                            html:'Base de datos:'
                                                        },
                                                        cmbBaseDatos

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Conectar con servidor remoto',
										width: 480,
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
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
															handler: function()
																	{
																		msgBox('Usted no cuenta con privilegios suficientes para realizar conexiones remotas');
                                                                        	
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