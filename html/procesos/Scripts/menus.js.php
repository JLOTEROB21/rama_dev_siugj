<?php session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	$consulta="select idRol,nombreGrupo from 8001_roles where idIdioma=".$_SESSION["leng"]." order by nombreGrupo";
	$resGrupo=$con->obtenerFilas($consulta);
	$objGrupo="";
	$arrGrupos="";
	$numReg=mysql_num_rows($resGrupo);
	$ct=1;
	while($filaGrupos=mysql_fetch_row($resGrupo))
	{
		$objGrupo="{boxLabel: '".uEJ($filaGrupos[1])."',name:'".$filaGrupos[0]."', id: 'opcion_".$ct."'}";	
		if($arrGrupos=="")
			$arrGrupos=$objGrupo;
		else
			$arrGrupos.=",".$objGrupo;
		$ct++;
	}
	$ct--;
	if($numReg>=4)
		$numReg=4;
	$listaGrupos=$arrGrupos;
	
	$consulta="select idProceso,nombre from 4001_procesos order by nombre";
	$arrProcesos=uEJ($con->obtenerFilasArreglo($consulta));
	$consulta="select idProceso,nombre from 4001_procesos where idTipoProceso<>1 order by nombre";
	$arrProcesosComplejos=uEJ($con->obtenerFilasArreglo($consulta));
	$consulta="SELECT idConsulta,nombreConsulta FROM 991_consultasSql WHERE idTipoConcepto=7";
	$arrCalculos=$con->obtenerFilasArreglo($consulta);

?>
var uploadControl;
var arrCalculos=<?php echo $arrCalculos?>;
var arrProcesos=<?php echo $arrProcesos ?>;
Ext.onReady(inicializar);

var colorOpciones='#000099';
var colorMenus='#006600';
var colorPagina='#990000';
var colorPermisos='gray';
var colorNomPagina='#000000';
var tipoMenu=['<?php echo $etj["lblOpcion"] ?>','<?php echo $etj["lblMenu"] ?>'];
var swfu;
var nodoSel=null;
function cambiarColor(val)
{
	 return '<img src="../images/banderas/'+val+'" />';
}

function inicializar()
{
	Ext.QuickTips.init();
   
	inicializarTablaMenus();

}

var alNameDTD;
var chkRow;
	

var regPag =Ext.data.Record.create	(
											[
												{name: 'idPagina'},
												{name: 'pagina'},
												{name: 'descripcion'},
												{name: 'checado'}
											]
										)

var regRol =Ext.data.Record.create	(
											[
												{name: 'codigoRol'},
												{name: 'rol'}
											]
										)

function inicializarTablaMenus(regionPanel)
{

	if(!gE('gridMenus') && !regionPanel)
    {
    	return;
    }


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
																funcion:'53'
															},
												dataUrl:'../paginasFunciones/funcionesPortal.php'
											}
										)		
										
	cargadorArbol.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.idProceso=gE('idProceso').value;
                                            
                                        
                                        
                                    }
                     )   											

	
	var objConf=	{
                        
                        id:'arbolOpciones',                        
                        useArrows:true,
                        autoScroll:true,
                        animate:true,
                        enableDD:true,
                        containerScroll: true,
                        root:raiz,
                        border:true,
                        cls:'gridSiugjPrincipal cssArbol',
                        loader: cargadorArbol,
                        rootVisible:false,
                        tbar:
                        [
                            {
                                id:'tAgregarMenu',
                                disabled:false,
                                width:50,
                                tooltip :'<?php echo $etj["lblNuevoMenu"]?>',
                                icon:'../images/addMenu.gif',
                                cls:'x-btn-icon',
                                handler:function()
                                        {
                                            agregarMenu();
                                        }
                            },
                            {
                                id:'tModificarMenu',
                                disabled:true,
                                width:50,
                                tooltip :'<?php echo $etj["lblModMenu"]?>',
                                icon:'../images/modificaMenu.gif',
                                cls:'x-btn-icon',
                                handler:function()
                                        {
                                            modificarMenu(raiz);
                                        }
                            },
                            
                            {
                                id:'tEliminarMenu',
                                disabled:true,
                                width:50,
                                tooltip :'<?php echo $etj["lblDelMenu"]?>',
                                icon:'../images/eliminaMenu.gif',
                                cls:'x-btn-icon',
                                handler:function()
                                        {
                                            eliminarOpcion(id,raiz,'0');	
                                        }
                            },
                            '-',
                            {
                                id:'tAsociar',
                                disabled:true,
                                width:50,
                                tooltip :'<?php echo $etj["lblAsociar"]?>',
                                icon:'../images/code.png',
                                cls:'x-btn-icon',
                                handler:function()
                                        {
                                            var nodoSel=obtenerNodoSel(raiz);
                                            asociarMenu(nodoSel);
                                        }
                            },
                            '-',
                            {
                                id:'tAgregar',
                                disabled:true,
                                width:50,
                                tooltip :'<?php echo $etj["lblNuevaOp"]?>',
                                icon:'../images/agregaOpcion.gif',
                                cls:'x-btn-icon',
                                handler:function()
                                        {
                                            var nodoSel=obtenerNodoSel(raiz);
                                            mostrarTipoOpcion(nodoSel);
    
                                        }
                            },
                            '-',
                            {
                                id:'tModificar',
                                disabled:true,
                                width:50,
                                tooltip :'<?php echo $etj["lblModificarOpcion"]?>',
                                icon:'../images/modificaOpcion.gif',
                                cls:'x-btn-icon',
                                handler:function()
                                        {	
                                            modificarOpcion(raiz);
                                        }
                            },
                            {
                                id:'tEliminar',
                                disabled:true,
                                width:50,
                                tooltip :'<?php echo $etj["lblDelOp"]?>',
                                icon:'../images/eliminaOpcion.gif',
                                cls:'x-btn-icon',
    
                                handler:function()
                                        {
                                            eliminarOpcion(id,raiz,'1');	
                                        }
                            }
                            
                            
                        ]
                    }


	if(!regionPanel)
    {
    	objConf.x=10;
        objConf.y=40;
        objConf.el='gridMenus';
        objConf.height=310;
        objConf.width=650;
	}			
    else
    {
    	objConf.region=regionPanel;
    }						
	var arbolOpciones=new Ext.tree.TreePanel	(
													objConf		
												)
	
							
	arbolOpciones.on('click',funcClikArbol);							
	if(!regionPanel)
    {
    	arbolOpciones.render();			
    }
    
    return arbolOpciones;
}

var nodoSeleccionadoAgregar=null;

function mostrarTipoOpcion(nodoSel)
{
	nodoSeleccionadoAgregar=nodoSel;
	var tablaTiposEnlace=[['1','<?php echo $etj["lblOpContenido"] ?>'],['11','Documento'],['0','<?php echo $etj["lblOpPagina"] ?>']];
	
	var dsTipoEnlace= new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name:'id'},
                                                                    {name:'nombre'}
                                                                    
                                                                ]
                                                    }
                                                )
	dsTipoEnlace.loadData(tablaTiposEnlace);	
	var selectTipoEnlace=document.createElement('select');
	var cmbTipoEnlace=new Ext.form.ComboBox	(
												{
													x:130,
													y:5,
													id:'cmbTipoEnlace',
													mode:'local',
													emptyText:'<?php echo $etj["lblElijaOpcion"] ?>',
													store:dsTipoEnlace,
													displayField:'nombre',
													valueField:'id',
													transform:selectTipoEnlace,
													editable:false,
													typeAhead: true,
													triggerAction: 'all',
													lazyRender:true,
													value:0
												
												}
											)
	
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'textfield',
											items: 	[
														new Ext.form.Label	(
																				{
																					x:5,
																					y:10,
																					text:'<?php echo $etj["lblOpcionA"]?>:'
																				}
																			),
														cmbTipoEnlace
											
													]
										}
									);

	


	var ventanaTO = new Ext.Window(
								{
									title: '<?php echo $etj["lblAplicacion"]?>',
									width: 400,
									height:150,
									minWidth: 300,
									minHeight: 100,
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
																cmbTipoEnlace.focus();
															}
														}
											},
									buttons:	[
													{
														id:'btnAceptar',
														text: '<?php echo $etj["lblBtnAceptar"]?>',
														listeners:	{
																		click:function()
																			{
                                                                            
                                                                            	switch(cmbTipoEnlace.getValue())
                                                                                {
                                                                                	case '2':
                                                                                    	mostrarVentanaFormulariosDinamicos(nodoSel);
                                                                                    break;
                                                                                    case '4':
                                                                                    	mostrarVentanaProcesos(nodoSel);
                                                                                    break;
                                                                                    case '5':
                                                                                    	mostrarVentanaProcesosProyecto(nodoSel);
                                                                                    break;
                                                                                    case '6':
                                                                                    	
                                                                                    	mostrarVentanaProcesosFrm(nodoSel,9);
                                                                                    break;
                                                                                    case '10':
                                                                                    	mostrarVentanaProcesoSel(nodoSel);
                                                                                    break;
                                                                                    case '11':
                                                                                    	mostrarVentanaDocumento(nodoSel);
                                                                                    break;
                                                                                    default:
                                                                                    	agregarOpcion(nodoSel,cmbTipoEnlace.getValue());
                                                                                }
																				
																				ventanaTO.close();
																			}
																	}
													},
													{
														text: '<?php echo $etj["lblBtnCancelar"]?>',
														handler:function()
																{
																	ventanaTO.close();
																}
													}
												]
								}
							);
		ventanaTO.show();
	
}

function inicializarTablaDescripcion()
{
	var tblDescripcion=new Ext.Panel	(
													{
														id:'fStDescripcion',
														x:100,
														y:100,
														height:700,
														width:400,
														renderTo:'tblDescripcion',
														layout: 'absolute',
														header:true,
														title:'<font color="#990000"><?php echo $etj["lblTitulo"]?>: </font>',
														items:	[
																	{
																		x:10,
																		y:10,
																		xtype:'label',
																		text:'<?php echo $etj["lblTipo"] ?>:',
																		cls:'letraEtiqueta'
																	},
																	{
																		id:'lblTipo',
																		x:60,
																		y:25,
																		xtype:'label',
																		text:'',
																		cls:'letraRespuesta'
																	},
																	{
																		x:10,
																		y:60,
																		xtype:'label',
																		text:'<?php echo ($etj["lblDescripcion"]) ?>:',
																		cls:'letraEtiqueta'
																	},
																	{
																		id:'lblDescripcion',
																		x:60,
																		y:85,
																		xtype:'label',
																		text:'',
																		cls:'letraRespuesta'
																	},	
																	{
																		id:'idURL',
																		x:10,
																		y:150,
																		xtype:'label',
																		text:'URL:',
																		cls:'letraEtiqueta'
																	},
																	{
																		id:'lblURL',
																		x:60,
																		y:165,
																		xtype:'label',
																		text:'',
																		cls:'letraRespuesta'
																	},
																	{
																		id:'idContenido',
																		x:120,
																		y:220,
																		hidden :'false',
																		xtype:'label',
																		html :'<a href="" id="lnkContenido"><img src="../images/Icono_Photoshop.gif" />&nbsp;&nbsp;<?php echo $etj["lblEditarC"] ?></a>',
																		cls:'letraEtiqueta'
																	},
                                                                    {
																		id:'idProceso',
																		x:10,
																		y:250,
																		xtype:'label',
																		text:'Proceso al que pertenece:',
																		cls:'letraEtiqueta'
																	},
                                                                    {
																		id:'lblIdProceso',
																		x:120,
																		y:265,
																		xtype:'label',
																		text:'',
																		cls:'letraRespuesta'
																	},
                                                                    {
																		id:'idPaginas',
																		x:10,
																		y:310,
																		xtype:'label',
																		text:'Vinculadas con las paginas:',
																		cls:'letraEtiqueta'
																	},
                                                                    {
																		id:'lblPaginas',
																		x:120,
																		y:325,
																		xtype:'label',
																		text:'',
																		cls:'letraRespuesta'
																	},
																	{
																		id:'idMacroprocesos',
																		x:10,
																		y:400,
																		xtype:'label',
																		text:'Vinculado en macroprocesos:',
																		cls:'letraEtiqueta'
																	},
                                                                     {
																		id:'lblMacroProcesos',
																		x:120,
																		y:415,
																		xtype:'label',
																		text:'',
																		cls:'letraRespuesta'
																	}
																	
																]
													}
												)
}

function funcClikArbol(nodo, evento)
{
	nodoSel=nodo;
	var tAgregar;
	var tEliminar;
	var tModificar;
	var tAsociar;
	var lblContenido=Ext.getCmp('idContenido');

    
	switch(nodo.attributes.cls)
	{
		case '1':  //opciones
		case '2':
			desHabilitarBotonesMenus();
			desHabilitarBotonesOpcion();
			tEliminar=Ext.getCmp('tEliminar');
			tModificar=Ext.getCmp('tModificar');
			tEliminar.enable();
			tModificar.enable();
			
		break;
		case '3': //menu lateral
			desHabilitarBotonesMenus();
			desHabilitarBotonesOpcion();
			tAgregar=Ext.getCmp('tAgregar');			
			tEliminar=Ext.getCmp('tEliminarMenu');
			tModificar=Ext.getCmp('tModificarMenu');
			tAsociar=Ext.getCmp('tAsociar');
			tAgregar.enable();
			tEliminar.enable();
			tModificar.enable();
			tAsociar.enable();
			
		break;
	}
}

function agregarMenu()
{
	crearVentanaNuevoMenu(null);
}

function modificarMenu(raiz)
{
	var nodoSel=obtenerNodoSel(raiz);
	if(nodoSel!=null)
	{
		crearVentanaNuevoMenu(nodoSel)
	}
	else
	{
		msgBox('<?php echo $etj["msgDebeSelElemento"]?>');
	}
}


var alRolesAsoc= new Ext.data.SimpleStore	(
											 	{
													fields:	[
															 	{name:'codigoRol'},
																{name:'rol'},
                                                                {name:'tipoActor'}
																
															]
												}
                                             )
var regRol=crearRegistro(	[
                              {name:'codigoRol'},
                              {name:'rol'},
                              {name:'tipoActor'}
                              
                          	]
                        )                                             

function crearTablaRelaciones()
{
	var dSRolesAsociados=[];
	alRolesAsoc.loadData(dSRolesAsociados);	
	var cmRolesAsoc= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer(),
                                                            {
                                                                header:'Actor',
                                                                width:250,
                                                                sortable:true,
                                                                dataIndex:'rol'
    
                                                            },
                                                            {
                                                                header:'Tipo Actor',
                                                                width:150,
                                                                sortable:true,
                                                                dataIndex:'tipoActor',
                                                                renderer:renderTipoUsuario
    
                                                            }
                                                        ]
                                                    );
											
												
	tblRoles=	new Ext.grid.GridPanel	(
                                                    {
                                                    	x:190,
                                                        y:190,
														id:'tblRoles',
                                                        store:alRolesAsoc,
                                                        frame:true,
                                                        cm: cmRolesAsoc,
                                                        height:170,
                                                        width:500,
                                                        tbar:
                                                        [
                                                        	{
                                                            	text:'&nbsp;Agregar actor',
                                                                icon:'../images/accept_green.png',
                                                                cls:'x-btn-text-icon',
                                                                handler:function()
                                                                		{

                                                                        	agregarActorProceso(gE('idProceso').value);
                                                                        }
                                                            },
                                                            {
                                                            	text:'&nbsp;Remover actor',
                                                                icon:'../images/cancel_round.png',
                                                                cls:'x-btn-text-icon',
                                                                handler:function()
                                                                		{
                                                                        	removerRol();
                                                                        }
                                                            }
                                                        ]
															
													}
					
    											);
	return tblRoles;
}


function crearVentanaNuevoMenu(nodoSel)
{
	function obtenerIdiomas()
	{
    
    	var cmbFuncionVisualizacion=crearComboExt('cmbFuncionVisualizacion',arrCalculos,220,385,350);
    	var tablaRol=crearTablaRelaciones();
    	
		var resp=eval(peticion_http.responseText);
		var tblGrid=crearGridMenu(resp);
		var form = new Ext.form.FormPanel(	
												{
													baseCls: 'x-plain',
													layout:'absolute',
													defaultType: 'label',
													items: 	[
																tblGrid,
                                                                
                                                               
                                                                {
                                                                	x:10,
                                                                    y:190,
                                                                	xtype:'label',
                                                                    html:'Actores que ver&aacute;n este men&uacute;:'
                                                                },
                                                                
                                                                tablaRol,
                                                                {
                                                                	x:10,
                                                                    y:390,
                                                                	xtype:'label',
                                                                    html:'Funci&oacute;n que condiciona la visualizaci&oacute;n:'
                                                                },
                                                                cmbFuncionVisualizacion
                                                                
                                                                
																

															]
												}
											);
		
			ventana = new Ext.Window(
											{
												title: 'Men&uacute; del proceso',
												width: 750,
												height:500,
												minWidth: 300,
												minHeight: 100,
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
																			pIdioma=obtenerPosFila(alNameDTD,'idIdioma',gE('hLeng').value);
																			if(pIdioma!=-1)
																			{
																				//tblGrid.startEditing(pIdioma,1);
																			}
																		}
																	}
														},
												buttons:	[
																{
																	id:'btnAceptar',
																	text: '<?php echo $etj["lblBtnAceptar"]?>',
																	listeners:	{
																					click:function()
																						{
																							if(validarGridMenus(tblGrid))
																							{
																								if(nodoSel==null)
																									guardarDatosMenu(tblGrid,ventana);
																								else
																									modificarDatosMenu(tblGrid,ventana,nodoSel);
																							}
																						}
																				}
																},
																{
																	text: '<?php echo $etj["lblBtnCancelar"]?>',
																	handler:function()
																			{
																				ventana.close();
																			}
																}
															]
											}
										);

		ventana.show();
		if(nodoSel!=null)
		{
			llenarDatosMenu(tblGrid,nodoSel);
		}
        							
	}
	obtenerDatosWeb('../paginasFunciones/funciones.php',obtenerIdiomas, 'POST','funcion=4',true);
}

function crearGridMenu(datos)
{
	var dsNameDTD= 	[];					
    alNameDTD=		new Ext.data.SimpleStore(
    											{
    												fields:	[
    															{name: 'idioma'},
																{name: 'idIdioma'},
																{name: 'etiqueta'},
																{name: 'descripcion'}
    														]
    											}
    										);
    alNameDTD.loadData(dsNameDTD);
	llenarDatos(datos);
	
	var cmFrmDTD= new Ext.grid.ColumnModel   	(
												 	[
													 	{
															header:'<?php echo $etj["lblLenguaje"]?>',
															width:80,
															dataIndex:'idioma',
															renderer: cambiarColor
														},
														{
															header:'<?php echo $etj["lblEtiquetaOpcion"]?> *',
															width:160,
															dataIndex:'etiqueta',
															editor: new Ext.form.TextField   (
																									{
																									   maxLength:100,
																									   style: 'text-align:left'
																									}
																								)
														}
														,
														
														{
															header:'<?php echo $etj["lblDescripcion"]?>',
															width:380,
															dataIndex:'descripcion',
															editor: new Ext.form.TextField   (
																									{
																									   maxLength:200,
																									   style: 'text-align:left'
																									}
																								)
														}
													]
												);
											
	tblFrmDTD=	new Ext.grid.EditorGridPanel	(
                                                    {
                                                        store:alNameDTD,
                                                        frame:true,
                                                        clicksToEdit: 1,
                                                        cm: cmFrmDTD,
                                                        height:150,
                                                        width:700
                                                    }
							                    );
	
	return tblFrmDTD;	
}	

function agregarRol()
{
	<?php
		if(!existeRol("'1_0'"))
			$consulta="select concat(idRol,'_',extensionRol),nombreGrupo from 8001_roles where vistosAdmin=1 and idIdioma=".$_SESSION["leng"]." order by nombreGrupo";
		else
			$consulta="select concat(idRol,'_',extensionRol),nombreGrupo from 8001_roles where idIdioma=".$_SESSION["leng"]." order by nombreGrupo";
		$arrRoles=uEJ($con->obtenerFilasArreglo($consulta));
	?>
    var arrRoles=<?php echo $arrRoles;?>;
    var cmbExtensiones=crearComboExt('cmbExtensiones',[],100,35,250);
	cmbExtensiones.hide();
	var cmbRoles=crearComboExt('cmbRoles',arrRoles,100,5,250);
    function rolSeleccionado(combo,registro,indice)
    {
    	cmbExtensiones.reset();
    	var idRegistro=registro.get('id');
        var arrId=idRegistro.split('_');
        if(arrId[1]!=0)
        {
        	function funcAjax()
            {
                var resp=peticion_http.responseText;
                arrResp=resp.split('|');
                if(arrResp[0]=='1')
                {
					var arrExtensiones=eval(arrResp[1]);
                    cmbExtensiones.getStore().loadData(arrExtensiones);                
                	cmbExtensiones.show();
		            Ext.getCmp('lblExtension').show();
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesUsuarios.php',funcAjax, 'POST','funcion=20&extension='+arrId[1],true);
        
        	
        }
        else
        {
        	cmbExtensiones.hide();
            Ext.getCmp('lblExtension').hide();
        }
        
    }
    
    cmbRoles.on('select',rolSeleccionado);
    
	var form=new Ext.form.FormPanel(
										{
											baseCls: 'x-plain',
											layout:'absolute',
											disabled:false,
											items:
													[
													 	{
                                                        	id:'lblRol',
                                                            x:10,
                                                            y:10,
                                                            xtype:'label',
                                                            html:'Rol:'
                                                        },
                                                        cmbRoles,
                                                        {
                                                        	id:'lblExtension',
                                                        	x:10,
                                                            y:40,
                                                            xtype:'label',
                                                            html:'Extensi&oacute;n:',
                                                            hidden:true
                                                        },
                                                        cmbExtensiones
													]
										}
									)
	var ventana=new Ext.Window(
							   		{
										title:'Agregar rol',
										width:380,
										height:150,
										layout:'fit',
										buttonAlign:'center',
										items:[form],
										modal:true,
										plain:true,
										listeners:
											{
												show:
												{
													buffer:10,fn:function()
															{
																
															}
												}
											},
										buttons:
												[
												 	{
														text:'Aceptar',
														handler:function ()
															{
                                                            	var rol=cmbRoles.getValue();
                                                                var arrId=rol.split('_');
                                                                var extension='0';
                                                                if(arrId[1]!=0)
                                                                	extension=cmbExtensiones.getValue();	
                                                                if(extension=='')
                                                                {
                                                                	function resp()
                                                                    {
                                                                    	cmbExtensiones.focus();
                                                                    }
                                                                	Ext.MessageBox.alert('<?php echo $etj["lblAplicacion"]?>','Debe seleccionar una extensi&oacute;n del rol',resp);
                                                                    return;
                                                                }
                                                                var listRoles=gE('listRoles');
                                                                var codigoRolN=arrId[0]+'_'+extension;
                                                                var tblRoles=Ext.getCmp('tblRoles');
                                                                var almacenRoles=tblRoles.getStore();
                                                                var rolExiste=existeRol(almacenRoles,codigoRolN);
                                                                if(!rolExiste)
                                                                {
                                                                	var nExtension=cmbExtensiones.getValue();
                                                                    var txtExtension='';
                                                                    if(nExtension!='')
                                                                    {
                                                                    	txtExtension=' ('+cmbExtensiones.getRawValue()+')';
                                                                    }
                                                                    var textoRol=cmbRoles.getRawValue()+txtExtension;
                                                                    var registro=new regRol	(
                                                                    							{
                                                                    								codigoRol:codigoRolN,
                                                                                                    rol:textoRol
                                                                                                }
                                                                    						);
                                                                    
                                                                    almacenRoles.add(registro);
                                                                    
                                                                }
                                                                
                                                                ventana.close();
																
															}
													},
													{
														text:'Cancelar',
														handler:function ()
															{
																ventana.close();
															}
													}
												 ]
									}
							   )
	ventana.show();

}

function removerRol()
{
	var tblRoles=Ext.getCmp('tblRoles');
	var filaSel=tblRoles.getSelectionModel().getSelected();

	if(filaSel==null)
	{
		Ext.MessageBox.alert('<?php echo $etj["lblAplicacion"]?>','<?php echo $etj["msgDebeSelRolRem"]?>');
        return;
	}
    
    function resp(btn)
    {
    	if(btn=='yes')
        {
        	tblRoles.getStore().remove(filaSel);
        }
    }
    Ext.MessageBox.confirm('<?php echo $etj["lblAplicacion"]?>','<?php echo $etj["msgConfRemoverRol"]?>',resp);
    
    
}

function existeRol(almacen,valor)
{
	
    var x;
    for(x=0;x<almacen.getCount();x++)
    {
    	if(almacen.getAt(x).get('codigoRol')==valor)
        	return true;
    }
    return false;

}


var rgIdiomas = Ext.data.Record.create	
(
	[
			{name: 'idioma'},
			{name: 'idIdioma'},
			{name: 'etiqueta'},
			{name: 'pEnlace'},
			{name: 'descripcion'}
	  ]
 );

var alNameDTD;
function llenarDatos(datos)
{
	for (x=0;x<datos.length;x++)
	{
		
		var FilaRegistro = new rgIdiomas(
                                            {
                                                    idioma:datos[x].imagen,
                                                    idIdioma: datos[x].idIdioma,
                                                    etiqueta: '',
													pEnlace: '',
													descripcion:''
                                               }
                                          );
                                                  
        alNameDTD.add(FilaRegistro); 
	}
}

function guardarDatosMenu(tblGrid,ventana)
{
	var dsGrid=tblGrid.getStore();
	var fila;
	var idIdioma;
	var etiqueta;
	var pEnlace;
	var descripcion;
	var arrObj="";
	var obj;
	var idioma=gE('hLeng').value;
	for(x=0;x<dsGrid.getCount();x++)
	{
		fila=dsGrid.getAt(x);
		idIdioma=fila.get('idIdioma');
		etiqueta=fila.get('etiqueta');
		descripcion=fila.get('descripcion');
		obj='{"idIdioma":"'+idIdioma+'","etiqueta":"'+cv(etiqueta)+'","descripcion":"'+cv(descripcion)+'"}';
		if(arrObj=="")
			arrObj=obj;
		else
			arrObj+=','+obj;
	}
    
    var permisos=obtenerPermisos();
    var idFuncionVisualiza=gEx('cmbFuncionVisualizacion').getValue();
    if(idFuncionVisualiza=="")
    	idFuncionVisualiza=-1;
	arrObj='{"permisosGrupos":"'+permisos+'","arreglo":['+arrObj+'],"colorFondo":"","idProceso":"'+gE('idProceso').value+'","funcionVisualizacion":"'+idFuncionVisualiza+'"}';
	function funcAjax()
	{
		var resp=peticion_http.responseText;
		arrResp=resp.split('|');
		if(arrResp[0]=='1')
		{
			var arbol=Ext.getCmp('arbolOpciones');
			var raizArbol=arbol.getRootNode();
			raizArbol.reload();
            nodoSel=null;
			ventana.close();
		}
		else
		{
			msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
		}
	}
	obtenerDatosWeb('../paginasFunciones/funcionesPortal.php',funcAjax, 'POST','funcion=45&param='+arrObj,true);
}

function modificarDatosMenu(tblGrid,ventana,nodoSel)
{
	var dsGrid=tblGrid.getStore();
	var idOpcion=nodoSel.id;
	var fila;
	var idIdioma;
	var etiqueta;
	var pEnlace;
	var descripcion;
	var arrObj="";
	var obj;
	var idioma=gE('hLeng').value;
	for(x=0;x<dsGrid.getCount();x++)
	{
		fila=dsGrid.getAt(x);
		idIdioma=fila.get('idIdioma');
		etiqueta=fila.get('etiqueta');
		descripcion=fila.get('descripcion');
		obj='{"idIdioma":"'+idIdioma+'","etiqueta":"'+cv(etiqueta)+'","descripcion":"'+cv(descripcion)+'"}';
		if(arrObj=="")
			arrObj=obj;
		else
			arrObj+=','+obj;
	}
	var permisos=obtenerPermisos();
    var cadPermisos=obtenerPermisosCadenas();
    var idFuncionVisualiza=gEx('cmbFuncionVisualizacion').getValue();
    if(idFuncionVisualiza=='')
    	idFuncionVisualiza=-1;
	arrObj='{"permisosGrupos":"'+permisos+'","idOpcion":"'+idOpcion+'","arreglo":['+arrObj+'],"colorFondo":"","idFuncionVisualiza":"'+idFuncionVisualiza+'"}';
    
	function funcAjax()
	{
		var resp=peticion_http.responseText;
		arrResp=resp.split('|');
		if(arrResp[0]=='1')
		{
        	nodoSel=null;
			gEx('arbolOpciones').getRootNode().reload();
            ventana.close();
		}
		else
		{
			msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
		}
	}
	obtenerDatosWeb('../paginasFunciones/funcionesPortal.php',funcAjax, 'POST','funcion=48&param='+arrObj,true);
}

function validarCampos(tblGrid)		
{
	var idIdioma=gE('hLeng').value;
	var dSet=tblGrid.getStore();
	var fila=obtenerFilaIdioma(dSet,idIdioma);
	
	if(fila!=null)
	{
		var cModelo=tblGrid.getColumnModel();
		var tituloColumna='';
		var campo;
		var valor;
		var posFila=obtenerPosFila(dSet,'idIdioma',idIdioma);
		var arrCampos='';
		
		for(x=0;x<cModelo.getColumnCount();x++)
		{
			tituloColumna=cModelo.getColumnHeader(x);
			if(tituloColumna.indexOf('*')>=0)
			{
				
				campo=cModelo.getDataIndex(x);
				valor=fila.get(campo);
				if(arrCampos=='')
					arrCampos=campo;
				else
					arrCampos+='|'+campo;
				if(trim(valor)=='')
				{
					filaError=posFila;
					celdaError=x;
					return 1;	
				}
			}
		}
		aCampo=arrCampos.split('|');
		for(x=0;x<dSet.getCount();x++)
		{
			if(x!=posFila)
			{
				fila=dSet.getAt(x);
				for(y=0;y<aCampo.length;y++)
				{
					valor=fila.get(aCampo[y]);
					if(trim(valor)=='')
					{
						filaError=posFila;
						celdaError=x;
						return 2;
					}
				}
			}
		}
	}
	return 0;
}

function validarGridMenus(tblGrid)
{
	var res=validarCampos(tblGrid);
	switch(res)
	{
		case 0: //Sin problemas
			return true;	
		break;
		case 1: //Algun campo obligatorio del idioma original no fue ingresado
		
			function funcAceptar()
			{
				tblGrid.startEditing(filaError,celdaError);
				return false;
			}
			Ext.Msg.alert('<?php echo $etj["lblAplicacion"] ?>','<?php echo $etj["msgErrorCeldaVacia"] ?>',funcAceptar);
			
		break;
		case 2: //Algun campo obligatorio de idioma NO original fue ingresado
			function funcConfirmacion(btn)
			{
				if(btn=='yes')
				{
					var dSet=tblGrid.getStore();
					var fIdioma=obtenerFilaIdioma(dSet,gE('hLeng').value);
					var cModelo=tblGrid.getColumnModel();
					var campo='';
					var valor='';
					var col;
					for(col=0;col<cModelo.getColumnCount();col++)
					{
						campo=cModelo.getDataIndex(col);
						valor=fIdioma.get(campo);
						if(valor!='')
						{
							rellenarValoresVacios(dSet,campo,'['+valor+']');
						}
					}
					
					
					
					Ext.getCmp('btnAceptar').fireEvent('click');
				}
				else
					return false;
			}
			Ext.MessageBox.confirm('<?php echo $etj["lblAplicacion"] ?>', '<?php echo $etj["msgErrorOpcionV"] ?>', funcConfirmacion);
		break;
	}
}

function generarPermisosGrupo()
{
	var grupos='';
	var permisos='';
	var checkbox;
	for(x=1;x<=<?php echo $ct ?>;x++)
	{	
		checkbox=Ext.getCmp('opcion_'+x);
		if(checkbox.getValue())
		{
			
			if(grupos=='')
			{
				grupos=checkbox.getName();
				permisos=checkbox.boxLabel;
			}
			else
			{
				grupos+='|'+Ext.getCmp('opcion_'+x).getName();
				permisos+=','+checkbox.boxLabel;
			}
		}
	}
	return grupos+'_'+permisos;
}

function obtenerOpcionesAsociadas(nivelSel)
{
	function funcAjax()
	{
		var arrNodos=new Array();
		var resp=eval(peticion_http.responseText);
		var reg;
		var ct=resp.length;
		var x;
		var arbolM=Ext.getCmp('arbolOpciones');
		var raiz=arbolM.getRootNode();
		limpiarNodo(raiz);
		tipo=nivelSel;
		if(tipo<3)
			font='<font color='+colorOpciones+'>';
		else
			font='<font color='+colorMenus+'>';		
		if(ct>0)
		{

			for(x=0;x<ct;x++)
			{
				
				reg=resp[x];
				
				var nodo=new Ext.tree.TreeNode(
												{
													
													id:reg.idOpcion,
													text:font+'<b>'+reg.etiqueta+'</b></fon><font color='+colorPermisos+'><I>'+reg.permisos+'</font></I>',
													icon:"images/s.gif",
													qtip:reg.descripcion,
													descripcion:reg.descripcion,
													expanded:false,
													cls:tipo
												}
											);
											
				arrNodos[x]=nodo;
				if(reg.opciones!=null)
				{
					llenarHijosNodo(nodo,reg.opciones);
				}						
				raiz.appendChild(nodo);	
			}
			raiz.appendChild(arrNodos);
		}
	}
	obtenerDatosWeb("../paginasFunciones/funcionesPortal.php",funcAjax,'POST','funcion=53&nivel='+nivelSel,true);
}

function llenarHijosNodo(nodo,opciones)
{
	var ct=opciones.length;
	var y;
	for(y=0;y<ct;y++)
	{
		reg=opciones[y];
		var nodoHijo=new Ext.tree.TreeNode(
											{
												
												id:reg.idOpcion,
												text:'<font color='+colorOpciones+'><b>'+reg.etiqueta+'</b></fon><font color='+colorPermisos+'><I>'+reg.permisos+'</font></I>',
												icon:"images/s.gif",
												qtip:reg.descripcion,
												descripcion:reg.descripcion,
												URL:reg.URL,
												expanded:true,
												cls:'1'
											}
										);
		nodo.appendChild(nodoHijo);		
	}
}

function habilitarBotonesOpcion()
{
	var tAgregar=Ext.getCmp('tAgregar');
	var tEliminar=Ext.getCmp('tEliminar');
	var tModificar=Ext.getCmp('tModificar');

	tAgregar.enable();
	tEliminar.enable();
	tModificar.enable();

}

function desHabilitarBotonesOpcion()
{
	var tAgregar=Ext.getCmp('tAgregar');
	var tEliminar=Ext.getCmp('tEliminar');
	var tModificar=Ext.getCmp('tModificar');
	tAgregar.disable();
	tEliminar.disable();
	tModificar.disable();
}

function habilitarBotonesMenus()
{
	var tAgregar=Ext.getCmp('tAgregarMenu');
	var tEliminar=Ext.getCmp('tEliminarMenu');
	var tModificar=Ext.getCmp('tModificarMenu');
	var tAsociar=Ext.getCmp('tAsociar');
	tAgregar.enable();
	tEliminar.enable();
	tModificar.enable();
	tAsociar.enable();

}

function desHabilitarBotonesMenus()
{
	var tAgregar=Ext.getCmp('tAgregarMenu');
	var tEliminar=Ext.getCmp('tEliminarMenu');
	var tModificar=Ext.getCmp('tModificarMenu');
	var tAsociar=Ext.getCmp('tAsociar');
	//tAgregar.disable();
	tEliminar.disable();
	tModificar.disable();
	tAsociar.disable();
}

function llenarDatosMenu(grid,nodoSel)
{
	var idFila=nodoSel.id;
	var idIdioma;
	var etiqueta;
	var pEnlace;
	var descripcion;
	var dSet=grid.getStore();
	var fila;
	function funcAjax()
	{
    	
		var resultado=eval(peticion_http.responseText);
		var resp=resultado[0].opciones;
		var permisos=resultado[0].permisos;
		var x;

        
		for(x=0;x<resp.length;x++)
		{
			var f=resp[x];
			idIdioma=f.idIdioma;
			etiqueta=f.etiqueta;
			descripcion=f.descripcion;
			fila=obtenerFilaIdioma(dSet,idIdioma);
            
            try
            {
                fila.set('etiqueta',etiqueta);
                fila.set('descripcion',descripcion);
            }
            catch(error)
            {
            }
		}
        
		if(permisos!='')
		{
			var arrPermisos=eval(permisos);
            var tblRoles=Ext.getCmp('tblRoles');
            tblRoles.getStore().loadData(arrPermisos);
		}
       if(resultado[0].idFuncionVisualizacion!='-1')
       		gEx('cmbFuncionVisualizacion').setValue(resultado[0].idFuncionVisualizacion);
	}
	obtenerDatosWeb('../paginasFunciones/funcionesPortal.php',funcAjax, 'POST','funcion=49&id='+idFila,true);
}

function eliminarOpcion(id,raiz,tAsoc)
{
	var nodoSel=obtenerNodoSel(raiz);
	if(nodoSel!=null)
	{
		function funcConfirmDel(btn)
		{
			if(btn=="yes")
			{
				function funcEliminar()
				{
					var resp=peticion_http.responseText;
					var arrRes=resp.split('|');
					if(arrRes[0]=='1')
					{
						raiz.removeChild(nodoSel);	
					}
					else
					{
						msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+resp[0]);
					}		
				}
				obtenerDatosWeb("../paginasFunciones/funcionesPortal.php",funcEliminar,'POST','funcion=56&idOpcion='+nodoSel.id+'&tAsociacion='+tAsoc+'&idContenido='+nodoSel.attributes.idContenido,true);
			}
		}
		Ext.Msg.confirm('<?php echo $etj["lblAplicacion"] ?>','<?php echo $etj["msgConfirmDel"]?>',funcConfirmDel);
	}
	else
	{
		msgBox('<?php echo $etj["msgDebeSelElemento"]?>');
	}
}

function agregarOpcion(nodoSel,tipoOpcion,param1)
{

	if(nodoSel!=null)
	{
		crearVentanaNuevaOpcion(null,nodoSel,tipoOpcion,param1);
	}
	else
		crearVentanaNuevaOpcion(null,null,tipoOpcion,param1);
}

var nPadre=null;
var accion=0;
var tOpcion;
var parametro1Opcion;

function crearVentanaNuevaOpcion(nodoSel,nodoPadre,tipoOpcion,param1)
{

	if(nodoSel==null)
    	accion=1;
    else
    	accion=0;
	tOpcion=tipoOpcion
    
	nPadre=nodoPadre;
    parametro1Opcion=param1;
    var cmbFuncionVisualizacion=crearComboExt('cmbFuncionVisualizacion',arrCalculos,220,235,350);
	function obtenerIdiomas()
	{
		var resp=eval(peticion_http.responseText);
        
        if((nodoSel==null)&&((tipoOpcion=='1')||(tipoOpcion=='2')||(tipoOpcion=='3')||(tipoOpcion=='4'))||(tipoOpcion=='5')||(tipoOpcion=='9')||(tipoOpcion=='10')||(tipoOpcion=='11'))
			var tblGrid=crearGrid(resp,tipoOpcion,true,param1);
		else
			var tblGrid=crearGrid(resp,tipoOpcion,false,param1);
        var cmbPosicion=crearComboExt('cmbPosicion',[],110,165,120);
       
		var form = new Ext.form.FormPanel(	
												{
													baseCls: 'x-plain',
													layout:'absolute',
													defaultType: 'label',
													items: 	[
																tblGrid,
                                                                {
                                                                	x:10,
                                                                    y:170,
                                                                	html:'Posici&oacute;n:'
                                                                },
                                                                cmbPosicion,
                                                                {
                                                                	x:10,
                                                                    y:200,
                                                                    html:'Imagen bullet: '
                                                                },
                                                                {
                                                                    x:110,
                                                                    y:195,
                                                                    html:	'<table width="290"><tr><td><div id="uploader"><p>Your browser doesn\'t have Flash, Silverlight or HTML5 support.</p></div></td></tr></table>'
                                                                },
                                                               
                                                                {
                                                                    x:405,
                                                                    y:196,
                                                                    id:'btnUploadFile',
                                                                    xtype:'button',
                                                                    text:'Seleccionar...',
                                                                    handler:function()
                                                                            {
                                                                                $('#containerUploader').click();
                                                                            }
                                                                },
                                                                
                                                                {
                                                                    x:330,
                                                                    y:200,
                                                                    html:	'<table width="290"><tr id="filaAvance" style="display:none"><td align="right">Porcentaje de avance: <span id="porcentajeAvance"> 0%</span></td></tr></table>'
                                                                },
                                                                
                                                                {
                                                                    x:185,
                                                                    y:10,
                                                                    hidden:true,
                                                                    html:	'<div id="containerUploader"></div><input type="hidden" name="hidFileID" id="hidFileID" value="" />'
                                                                },
                                                                {
                                                                	x:10,
                                                                    y:240,
                                                                    html:'Función que condiciona la visualización: '
                                                                },
                                                                cmbFuncionVisualizacion
                                                               
															]
												}
											);
		
			ventana = new Ext.Window(
											{
												title: '<?php echo $etj["lblOpcionesSistema"]?>',
												width: 750,
												height:350,
												minWidth: 300,
												minHeight: 100,
												layout: 'fit',
                                                id:'vAgregarOpcion',
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
																			pIdioma=obtenerPosFila(alNameDTD,'idIdioma',gE('hLeng').value);
																			if(pIdioma!=-1)
																			{
																				tblGrid.startEditing(pIdioma,1);
																			}
																		}
																	}
														},
												buttons:	[
																{
																	id:'btnAceptar',
																	text: '<?php echo $etj["lblBtnAceptar"]?>',
																	listeners:	{
																					click:function()
																						{
                                                                                        	
			
																							if(validarGridMenus(tblGrid))
																							{
                                                                                            	if((uploadControl!=undefined)&&(uploadControl.files.length>0))
                                                                                            		uploadControl.start();
	                                                                                           else
                                                                                               {
                                                                                                    if(nodoSel==null)
                                                                                                        guardarDatos(tblGrid,ventana,nodoPadre,tipoOpcion);
                                                                                                    else
                                                                                                        modificarDatos(tblGrid,ventana,nodoSel);
                                                                                               }
																								
																							}
																						}
																				}
																},
																{
																	text: '<?php echo $etj["lblBtnCancelar"]?>',
																	handler:function()
																			{
																				ventana.close();
																			}
																}
															]
											}
										);

		
		if(nodoSel!=null)
		{
			llenarDatosOpcion(tblGrid,nodoSel,ventana);
		}
        else
        {
        	inicializarNumElementos(nodoPadre,ventana);
            
        }
		
	}
	obtenerDatosWeb('../paginasFunciones/funciones.php',obtenerIdiomas, 'POST','funcion=4',true);
}


function crearGrid(datos,tipoOpcion,llenarColumna,param1)
{
	var dsNameDTD= 	[];					
    alNameDTD=		new Ext.data.SimpleStore(
    											{
    												fields:	[
    															{name: 'idioma'},
																{name: 'idIdioma'},
																{name: 'etiqueta'},
																{name: 'pEnlace'},
																{name: 'descripcion'}
    														]
    											}
    										);
    alNameDTD.loadData(dsNameDTD);
	llenarDatos(datos);
	if(llenarColumna)
	{
    	var url='';

        switch(tipoOpcion)
        {
        
        	case '1':
            	url='../portal/paginaContenido.php';
            break;
            case '2':
            	url='../modeloPerfiles/tblFormularios.php?idFormulario='+param1; 
            break;
            case '3':
            	url='../modeloPerfiles/tblEtapasProceso.php?idProceso='+param1; 
            break;
            case '4':
            	url='../modeloCitas/administrarHorarioUnidadApartado.php?idFormulario='+param1; 
            break;
            case '5':
            	url='../modeloPerfiles/tblFormularios.php?idFormulario='+param1; 
            	//url='../modeloProyectos/tblProyectos.php?idTipoProyecto='+param1;
            break;
            case '9':
            	url="javascript:enviarProceso('"+Base64.encode(tipoOpcion)+"','"+Base64.encode(param1)+"')";
            break;
            case '10':
            	url="javascript:ingresarProceso('"+bE(param1)+"')";
            break;
            case '11':
            	if(param1!=undefined)
	            	url=param1.url;
                else
                	url=nodoSel.attributes.URL;
            break;
        }
        
    	
		var numReg=alNameDTD.getCount();
		var x;
		var fila;
		for(x=0;x<numReg;x++)
		{
			fila=alNameDTD.getAt(x);
			fila.set('pEnlace',url);
		}
	}

	
	if(tipoOpcion==0)
	{
		var txtEditor=new Ext.form.TextField   (
													{
													   maxLength:255,
													   style: 'text-align:left'
													}
												)
	}
	else
	{
		var txtEditor=null;
	}
	
	var cmFrmDTD= new Ext.grid.ColumnModel   	(
												 	[
													 	{
															header:'<?php echo $etj["lblLenguaje"]?>',
															width:80,
															dataIndex:'idioma',
															renderer: cambiarColor
														},
														{
															header:'<?php echo $etj["lblEtiquetaOpcion"]?> *',
															width:160,
															dataIndex:'etiqueta',
															editor: new Ext.form.TextField   (
																									{
																									   maxLength:100,
																									   style: 'text-align:left'
																									}
																								)
														}
														,
														{
															header:'<?php echo $etj["lblPaginaAsociada"]?> *',
															width:180,
															dataIndex:'pEnlace',
															editor: txtEditor
														},
														{
															header:'<?php echo $etj["lblDescripcion"]?>',
															width:280,
															dataIndex:'descripcion',
															editor: new Ext.form.TextField   (
																									{
																									   maxLength:200,
																									   style: 'text-align:left'
																									}
																								)
														}
													]
												);
											
		tblFrmDTD=	new Ext.grid.EditorGridPanel	(
														{
                                                        	id:'gridIdiomas',
															store:alNameDTD,
															frame:true,
															clicksToEdit: 1,
															cm: cmFrmDTD,
															height:150,
															width:740
														}
													);
	
	
	return tblFrmDTD;	
}	

function guardarDatos(tblGrid,ventana,nodoPadre,tipoOpcion)
{
	var dsGrid=tblGrid.getStore();
	var fila;
	var idIdioma;
	var etiqueta;
	var pEnlace;
	var descripcion;
	var arrObj="";
	var obj;
	var idioma=gE('hLeng').value;
	for(x=0;x<dsGrid.getCount();x++)
	{
		fila=dsGrid.getAt(x);
		idIdioma=fila.get('idIdioma');
		etiqueta=(fila.get('etiqueta'));
		pEnlace=cv(fila.get('pEnlace'));
		descripcion=fila.get('descripcion');
		obj='{"idIdioma":"'+idIdioma+'","etiqueta":"'+cv(etiqueta)+'","pEnlace":"'+pEnlace+'","descripcion":"'+cv(descripcion)+'","tipoOpcion":"'+tipoOpcion+'"}';
		if(arrObj=="")
			arrObj=obj;
		else
			arrObj+=','+obj;
	}
	var posicion='3'
	
	var idPadre='';
	if(nodoPadre!=null)
		idPadre=nodoPadre.id;
    var idDocumento=-1;
    if(tipoOpcion=='11')
    {
    	idDocumento=parametro1Opcion.idDocumento;
    }    
    var cmbPosicion=Ext.getCmp('cmbPosicion');
    posicion=cmbPosicion.getValue();  
    var idFuncionVisualiza=gEx('cmbFuncionVisualizacion').getValue();
    if(idFuncionVisualiza=="")
    	idFuncionVisualiza=-1;  
	arrObj='{"idFuncionVisualiza":"'+idFuncionVisualiza+'","idDocumento":"'+idDocumento+'","archivo":"'+gE('hidFileID').value+'","idPadre":"'+idPadre+'","posicion":"'+posicion+'","arreglo":['+arrObj+']}';
	function funcAjax()
	{
		var resp=peticion_http.responseText;
		arrResp=resp.split('|');
		if(arrResp[0]=='1')
		{
			var arbol=Ext.getCmp('arbolOpciones');
			var raizArbol=arbol.getRootNode();
			raizArbol.reload();
            nodoSel=null;
			ventana.close();
		}
		else
		{
			msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
		}
	}
	obtenerDatosWeb('../paginasFunciones/funcionesPortal.php',funcAjax, 'POST','funcion=41&param='+arrObj,true);
}

function modificarDatos(tblGrid,ventana,nodoSel)
{
	var dsGrid=tblGrid.getStore();
	var idOpcion=nodoSel.id;
	var fila;
	var idIdioma;
	var etiqueta;
	var pEnlace;
	var descripcion;
	var arrObj="";
	var obj;
	var idioma=gE('hLeng').value;
	for(x=0;x<dsGrid.getCount();x++)
	{
		fila=dsGrid.getAt(x);
		idIdioma=fila.get('idIdioma');
		etiqueta=(fila.get('etiqueta'));
		pEnlace=cv(fila.get('pEnlace'));
		descripcion=fila.get('descripcion');
		obj='{"idIdioma":"'+idIdioma+'","etiqueta":"'+cv(etiqueta)+'","pEnlace":"'+pEnlace+'","descripcion":"'+cv(descripcion)+'"}';
		if(arrObj=="")
			arrObj=obj;
		else
			arrObj+=','+obj;
	}
    var cmbPosicion=Ext.getCmp('cmbPosicion');
    posicion=cmbPosicion.getValue();  
    var idFuncionVisualiza=gEx('cmbFuncionVisualizacion').getValue();
    if(idFuncionVisualiza=="")
    	idFuncionVisualiza=-1; 
	arrObj='{"idFuncionVisualiza":"'+idFuncionVisualiza+'","archivo":"'+gE('hidFileID').value+'","idOpcion":"'+idOpcion+'","posicion":"'+posicion+'","arreglo":['+arrObj+']}';
	function funcAjax()
	{
		var resp=peticion_http.responseText;
		arrResp=resp.split('|');
		if(arrResp[0]=='1')
		{
			fila=obtenerFilaIdioma(dsGrid,idioma);
			etiqueta='<font color='+colorOpciones+'><b>'+fila.get('etiqueta')+'</b></font>';
			descripcion=fila.get('descripcion');
			nodoSel.setText(etiqueta);
			nodoSel.attributes.qtip =descripcion;
			nodoSel.attributes.descripcion=fila.get('descripcion');
			nodoSel.attributes.URL=fila.get('pEnlace');
			ventana.close();
			funcClikArbol(nodoSel);
		}
		else
		{
			msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
		}
	}
	obtenerDatosWeb('../paginasFunciones/funcionesPortal.php',funcAjax, 'POST','funcion=44&param='+arrObj,true);
}

function modificarOpcion(raiz)
{
	var nodoSel=obtenerNodoSel(raiz);
	if(nodoSel!=null)
	{
		crearVentanaNuevaOpcion(nodoSel,null,nodoSel.attributes.tipoEnlace);
	}
	else
	{
		msgBox('<?php echo $etj["msgDebeSelElemento"]?>');
	}
}

function inicializarNumElementos(opcionS,ventana)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var nFinal=parseInt(arrResp[1])+1;
        	var arrDatos=generarNumeracion(1,nFinal);
            var cmbNumeracion=Ext.getCmp('cmbPosicion');
            cmbNumeracion.getStore().loadData(arrDatos);
            cmbNumeracion.setValue(nFinal);
        	ventana.show();
            inicializarBotonEnvio();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesPortal.php',funcAjax, 'POST','funcion=38&idMenu='+opcionS.id,true);
	
}

function llenarDatosOpcion(grid,opcionS,ventana)
{
	var idFila=opcionS.id;
	var idIdioma;
	var etiqueta;
	var pEnlace;
	var descripcion;
	var dSet=grid.getStore();
	var fila;
	function funcAjax()
	{
		var resultado=eval(peticion_http.responseText);
		var resp=resultado[0].opciones;
		var permisos=resultado[0].permisos;
        var nOpciones=resultado[0].numOpciones;
        var opcionSel=resultado[0].numOpcion;
		for(x=0;x<resp.length;x++)
		{
			var f=resp[x];
			idIdioma=f.idIdioma;
			etiqueta=f.etiqueta;
			pEnlace=f.pEnlace;
			descripcion=f.descripcion;
			fila=obtenerFilaIdioma(dSet,idIdioma);
			fila.set('etiqueta',etiqueta);
			fila.set('pEnlace',pEnlace);
			fila.set('descripcion',descripcion);
            ventana.show();
           	inicializarBotonEnvio();
		}
        var nOpciones=resultado[0].numOpciones;
        var nFinal=parseInt(nOpciones);
        var arrDatos=generarNumeracion(1,nFinal);
        var cmbNumeracion=Ext.getCmp('cmbPosicion');
        cmbNumeracion.getStore().loadData(arrDatos);
        var nSel=resultado[0].numOpcion;
        if(nSel=='')
	        cmbNumeracion.setValue(1);
        else
        	cmbNumeracion.setValue(nSel);

         
		
	}
	obtenerDatosWeb('../paginasFunciones/funcionesPortal.php',funcAjax, 'POST','funcion=43&id='+idFila,true);
}

function inicializarBotonEnvio()
{
	 var cObj={
				// Backend settings
				upload_url: "../paginasFunciones/procesarBullet.php",
				file_post_name: "archivoEnvio",
 
				// Flash file settings
				file_size_limit : "10 MB",
				file_types : "*.*",			// or you could use something like: "*.doc;*.wpd;*.pdf",
				file_types_description : "All Files",
				file_upload_limit : 0,
				file_queue_limit : 1,
 
				
				upload_success_handler : uploadSuccess
				
 
				
			};
    crearControlUploadHTML5(cObj);
}

function asociarMenu(nodoSel)
{
	var posMenu=[['2','<?php echo $etj["lblLinea1"]?>'],['1','<?php echo $etj["lblLinea2"]?>'],['3','<?php echo $etj["lblIzquierda"]?>'],['4','Macroproceso']];
	var dSetPos= new Ext.data.SimpleStore	(
											 	{
													fields:	[
															 	{name:'id'},
																{name:'nombre'}
																
															]
												}
											)
	dSetPos.loadData(posMenu);	
	var comboPos=document.createElement('select');
	var comboPosM=new Ext.form.ComboBox	(
											{
												
												x:110,
												id:'cmbPosMenu',
												width:170,
												mode:'local',
												emptyText:'<?php echo $etj["lblElijaOpcion"]?>',
											   	store:dSetPos,
												displayField:'nombre',
												valueField:'id',
												transform:comboPos,
												editable:false,
												typeAhead: true,
												triggerAction: 'all',
												lazyRender:true,
												value:2
											}
										)
	
	comboPosM.on('select',funcOpcionSel);
	function funcOpcionSel(combo,registro,indice)
	{
		llenarDatosPaginas(alNameDTD,nodoSel,chkRow,false);
	}
	
	var tblGrid=crearGridPaginas(nodoSel);
	var form = new Ext.form.FormPanel(	
												{
													baseCls: 'x-plain',
													layout:'absolute',
													defaultType: 'textfield',
													items: 	[
																{
																	xtype:'label',
																	text:'<?php echo $etj["lblColocarEn"]?>:'
																},
																comboPosM,
																tblGrid

															]
												}
											);
	ventanaAM = new Ext.Window(
									{
										title: '<?php echo $etj["lblAsociarM"]?>',
										width: 690,
										height:520,
										minWidth: 690,
										minHeight: 520,
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
																	
																	for(x=0;x<arrChecar.length;x++)
																	{
																		chkRow.selectRow(arrChecar[x],true);
																	}
																}
															}
												},
										buttons:	[
														{
															id:'btnAceptar',
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															listeners:	{
																			click:function()
																				{
																					enviarAsociacionMenus(nodoSel,ventanaAM);
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
}

function crearGridPaginas(nodoSel)
{
	dsNameDTD=[];
	alNameDTD=	new Ext.data.SimpleStore(
    											{
    												fields:	[
    															{name: 'idPagina'},
																{name: 'pagina'},
																{name: 'descripcion'},
																{name: 'checado'}
    														]
    											}
    										);

    alNameDTD.loadData(dsNameDTD);
	chkRow=new Ext.grid.CheckboxSelectionModel();
	chkRow.on('rowselect',funFilaSel);
	chkRow.on('rowdeselect',funFilaDesSel);
	var cmPaginas= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														chkRow,
														{
															header:'<?php echo $etj["lblPagina"] ?>',
															width:150,
															sortable:true,
															dataIndex:'pagina'
														},
														{
															header:'<?php echo $etj["lblDescripcion"] ?>',
															width:300,
															sortable:true,
															dataIndex:'descripcion'
														}
													]
												);
	var tblPaginas=	new Ext.grid.EditorGridPanel	(
												{
													store:alNameDTD,
													frame:true,
													y:40,
													cm: cmPaginas,
													height:360,
													width:650,
													sm:chkRow
												}
											);
											
	llenarDatosPaginas(alNameDTD,nodoSel,chkRow,true);										
	return 	tblPaginas;									
}

function funFilaSel(sm,fila,registro)
{
	registro.set('checado','true');
}

function funFilaDesSel(sm,fila,registro)
{
	registro.set('checado','false');
}

var arrChecar;

function llenarDatosPaginas(dSet,nodoSel,chkRow,mostrarVentana)
{
	var posicion=Ext.getCmp('cmbPosMenu').getValue();
	if(!mostrarVentana)
			ventanaAM.hide();
	dSet.removeAll();
	arrChecar=new Array();
	var ct=0;
	function resp()
	{
		var resp=eval(peticion_http.responseText);
		var x;
		var registro;
		for(x=0;x<resp.length;x++)
		{
			registro=new regPag	(
									{
										idPagina:resp[x].idPagina,
										pagina:resp[x].pagina,
										descripcion:resp[x].descripcion,
										checado:resp[x].asociacion
									}
								)
			
			if(resp[x].asociacion=='true')
			{
			 	arrChecar[ct]=x;
				ct++;
				
			}
			
			dSet.add(registro);
		}
		
		
		ventanaAM.show();
		
	}
	obtenerDatosWeb('../paginasFunciones/funcionesPortal.php',resp, 'POST','funcion=70&idOpcion='+nodoSel.id+'&pos='+posicion,true);	
}

function enviarAsociacionMenus(nodoSel,ventana)
{
	var x;
	var nRegistros=alNameDTD.getCount();
	var fila;
	var arrObj='';
	var obj;
	var posicion=Ext.getCmp('cmbPosMenu').getValue();
	for(x=0;x<nRegistros;x++)
	{
		fila=alNameDTD.getAt(x);
		if(fila.get('checado')=='true')
		{
			obj='{"idPagina":"'+fila.get('idPagina')+'"}';
			if(arrObj=='')
				arrObj=obj;
			else
				arrObj+=','+obj;
		}
	}
	var objFinal='{"idMenu":"'+nodoSel.id+'","pos":"'+posicion+'","arrObj":['+arrObj+']}';
	function resp()
	{
		var resp=peticion_http.responseText;
		if(resp=='1')
		{
        	function funcResp()
            {
            	ventana.close();
            }
			msgBox('<?php echo $etj["lblOperacionOK"]?>',funcResp);
            
		}
		else
			msgBox('<?php echo $etj["errOperacion"].' '?>'+peticion_http.responseText);		
		
	}
	obtenerDatosWeb('../paginasFunciones/funcionesPortal.php',resp, 'POST','funcion=71&obj='+cv(objFinal),true);	
}

function obtenerPermisos()
{
	var tblRoles=Ext.getCmp('tblRoles');
    var almacen=tblRoles.getStore();
    var x;
    var permisos="";
    var registro;
    for(x=0;x<almacen.getCount();x++)
    {
    	registro=almacen.getAt(x);
    	if(permisos=='')
        	permisos=registro.get('codigoRol');
        else
       		permisos+=','+registro.get('codigoRol');
    }
    
    return permisos;
    
}

function obtenerPermisosCadenas()
{
	var tblRoles=Ext.getCmp('tblRoles');
    var almacen=tblRoles.getStore();
    var x;
    var permisos="";
    var registro;
    for(x=0;x<almacen.getCount();x++)
    {
    	registro=almacen.getAt(x);
    	if(permisos=='')
        	permisos=registro.get('rol');
        else
       		permisos+=','+registro.get('rol');
    }
    return permisos;
}

function mostrarVentanaFormulariosDinamicos(nodoSel)
{
	
	
    var alOpciones=		new Ext.data.SimpleStore(
                                                    {
                                                        fields:	[
                                                                 	{name:'idFormulario'},
                                                                    {name:'nombre'}, 
                                                                    {name:'titulo'},
                                                                    {name: 'descripcion'},
                                                                    {name:'idProceso'},
                                                                    {name:'formularioBase'}
                                                                      
                                                                ]
                                                    }
                                                );
    
    
    var dsOpciones= [];
    
    alOpciones.loadData(dsOpciones);
    
    var cmFrmDTD= new Ext.grid.ColumnModel   	(
                                                    [
                                                        new  Ext.grid.RowNumberer(),
                                                        {
                                                            header:'<?php echo $etj["lblNomFormulario"]?>',
                                                            width:200,
                                                            dataIndex:'nombre'
                                                        },
                                                        {
                                                        	header:'<?php echo $etj["lblTitulo"]?>',
                                                            width:150,
                                                            dataIndex:'titulo'
                                                        },
                                                        {
                                                        	header:'<?php echo $etj["lblDescripcion"]?>',
                                                            width:350,
                                                            dataIndex:'descripcion'
                                                        }
                                                        
                                                       
                                                    ]
                                                );
    
    
    var tblOpciones=	new Ext.grid.GridPanel	(
                                                        {
                                                            id:'gridFormularios',
                                                            store:alOpciones,
                                                            frame:true,
                                                            cm: cmFrmDTD,
                                                            height:300,
                                                            width:750,
                                                            title:'<?php echo $etj["lblElijaForm"]?>:'
                                                            
                                                        }
                                                    );
    
    panelGrid=new Ext.Panel	(
                                {
                                    y:50,
                                    items:	[
                                                tblOpciones
                                            ]
                                }
                            );
                            
    
    var cmbProcesos=crearComboExt('cmbProcesos',arrProcesos,390,5);
    cmbProcesos.on('select',cargarFormularios);
    
    var form = new Ext.form.FormPanel(	
                                        {
                                            baseCls: 'x-plain',
                                            layout:'absolute',
                                            defaultType: 'textfield',
                                            items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            xtype:'label',
                                                            html:'Elija el proceso al cual pertenece el formulario que desea enlazar:'
                                                        },
                                                        cmbProcesos,
                                                        panelGrid
                                                    ]
                                        }
                                    );
    
    

    
    
    
    btnSiguiente=new Ext.Button	(
                                    {
                                        text: '<?php echo $etj["lblSiguiente"] ?> >>',
                                        minWidth:80,
                                        id:'btnFinalizar',
                                        listeners:	{
                                                        click:
                                                                {
                                                                    fn:function()
                                                                    {
                                                                    	
                                                                        var filaSel= tblOpciones.getSelectionModel().getSelected();
                                                                        if(filaSel==null)
                                                                        {
                                                                        	Ext.MessageBox.alert('<?php echo $etj["lblAplicacion"] ?>','<?php echo $etj["msgErrDebeSF"] ?>');
                                                                        	return;
                                                                        }
                                                                       
                                                                        if(filaSel.get('formularioBase')=='1')
                                                                        {
                                                                        	//var idProceso=filaSel.get('idProceso');
                                                                            var idFormulario=filaSel.get('idFormulario');
                                                                            agregarOpcion(nodoSel,'2',idFormulario);
                                                                            //agregarOpcion(nodoSel,'3',idProceso);
                                                                            
                                                                        }
                                                                        else
                                                                        {
                                                                        	var idFormulario=filaSel.get('idFormulario');
                                                                            agregarOpcion(nodoSel,'2',idFormulario);
                                                                        }
                                                                        
                                                                        ventanaSelForm.close();
                                                                        
                                                                    }
                                                                }
                                                    }
                                    }
                                )
    
    ventanaSelForm = new Ext.Window(
                                            {
                                                title: '<?php echo $etj["lblSelForm"]?>',
                                                width: 780 ,
                                                height:450,
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

function cargarFormularios(combo,registro,indice)
{

	function funcResp()
    {
    	var arrResp=peticion_http.responseText.split('|');
        if(arrResp[0]=='1')
		{
            	var arrTablas=eval(arrResp[1]);
                var almacen=Ext.getCmp('gridFormularios').getStore();
                almacen.loadData(arrTablas);
               	ventana.show();
		}
		else
		{
			msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
		}
    }
    obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcResp, 'POST','funcion=14&idProceso='+registro.get('id'),true);
}

function mostrarVentanaProcesos(nodoSel)
{
	<?php
		$consulta="select p.idProceso,p.nombre,p.descripcion,f.idFormulario from 4001_procesos p,900_formularios f where  f.idProceso=p.idProceso and f.tipoFormulario=1 and p.idTipoProceso=2";
		$arrProcesos=uEJ($con->obtenerFilasArreglo($consulta));
	?>
    var alOpciones=		new Ext.data.SimpleStore(
                                                    {
                                                        fields:	[
                                                                 	{name:'idProceso'},
                                                                    {name:'nombre'}, 
                                                                    {name: 'descripcion'},
                                                                    {name: 'idFrmBase'}
                                                                ]
                                                    }
                                                );
    
    
    var dsOpciones= <?php echo $arrProcesos?>;
    
    alOpciones.loadData(dsOpciones);
    
    var cmFrmDTD= new Ext.grid.ColumnModel   	(
                                                    [
                                                        new  Ext.grid.RowNumberer(),
                                                        {
                                                            header:'Proceso',
                                                            width:150,
                                                            dataIndex:'nombre'
                                                        },
                                                        {
                                                        	header:'Descripci&oacute;n',
                                                            width:300,
                                                            dataIndex:'descripcion'
                                                        }
                                                        
                                                       
                                                    ]
                                                );
    
    
    var tblOpciones=	new Ext.grid.GridPanel	(
                                                        {
                                                            id:'gridFormulariosProc',
                                                            store:alOpciones,
                                                            frame:true,
                                                            cm: cmFrmDTD,
                                                            height:300,
                                                            width:540,
                                                            title:'Elija un proceso:'
                                                            
                                                        }
                                                    );
    
    panelGrid=new Ext.Panel	(
                                {
                                    y:10,
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
    
    

    
    
    
    btnSiguiente=new Ext.Button	(
                                    {
                                        text: '<?php echo $etj["lblSiguiente"] ?> >>',
                                        minWidth:80,
                                        id:'btnFinalizar',
                                        listeners:	{
                                                        click:
                                                                {
                                                                    fn:function()
                                                                    {
                                                                    	
                                                                        var filaSel= tblOpciones.getSelectionModel().getSelected();
                                                                        if(filaSel==null)
                                                                        {
                                                                        	Ext.MessageBox.alert('<?php echo $etj["lblAplicacion"] ?>','Primero debe seleccionar un proceso');
                                                                        	return;
                                                                        }
                                                                       
                                                                                                                                                {
                                                                        	var idFormulario=filaSel.get('idFrmBase');
                                                                            agregarOpcion(nodoSel,'4',idFormulario);
                                                                        }
                                                                        
                                                                        ventanaSelForm.close();
                                                                        
                                                                    }
                                                                }
                                                    }
                                    }
                                )
    
    ventanaSelForm = new Ext.Window(
                                            {
                                                title: 'Selecci&oacute;n de proceso',
                                                width: 580 ,
                                                height:370,
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
	//cargarFormularios(alOpciones,ventanaSelForm);
}

function mostrarVentanaProcesosProyecto(nodoSel)
{
	<?php
		$consulta="select f.idFormulario,p.nombre,p.descripcion from 4001_procesos p,900_formularios f where f.idProceso=p.idProceso and f.formularioBase=1 and p.idTipoProceso=3";
		$arrProcesos=uEJ($con->obtenerFilasArreglo($consulta));
	?>
    var alOpciones=		new Ext.data.SimpleStore(
                                                    {
                                                        fields:	[
                                                                 	{name: 'idFormulario'},
                                                                    {name: 'nombre'}, 
                                                                    {name: 'descripcion'}
                                                                    
                                                                ]
                                                    }
                                                );
    
    
    var dsOpciones= <?php echo $arrProcesos?>;
    
    alOpciones.loadData(dsOpciones);
    
    var cmFrmDTD= new Ext.grid.ColumnModel   	(
                                                    [
                                                        new  Ext.grid.RowNumberer(),
                                                        {
                                                            header:'Proceso',
                                                            width:150,
                                                            dataIndex:'nombre'
                                                        },
                                                        {
                                                        	header:'Descripci&oacute;n',
                                                            width:300,
                                                            dataIndex:'descripcion'
                                                        }
                                                        
                                                       
                                                    ]
                                                );
    
    
    var tblOpciones=	new Ext.grid.GridPanel	(
                                                        {
                                                            id:'gridFormulariosProcProy',
                                                            store:alOpciones,
                                                            frame:true,
                                                            cm: cmFrmDTD,
                                                            height:300,
                                                            width:540,
                                                            title:'Elija un proceso:'
                                                            
                                                        }
                                                    );
    
    panelGrid=new Ext.Panel	(
                                {
                                    y:10,
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
    
    

    
    
    
    btnSiguiente=new Ext.Button	(
                                    {
                                        text: '<?php echo $etj["lblSiguiente"] ?> >>',
                                        minWidth:80,
                                        id:'btnFinalizar',
                                        listeners:	{
                                                        click:
                                                                {
                                                                    fn:function()
                                                                    {
                                                                    	
                                                                        var filaSel= tblOpciones.getSelectionModel().getSelected();
                                                                        if(filaSel==null)
                                                                        {
                                                                        	Ext.MessageBox.alert('<?php echo $etj["lblAplicacion"] ?>','Primero debe seleccionar un proceso de tipo proyecto');
                                                                        	return;
                                                                        }
                                                                        var idFormulario=filaSel.get('idFormulario');
                                                                        agregarOpcion(nodoSel,'5',idFormulario);
                                                                        ventanaSelForm.close();
                                                                    }
                                                                }
                                                    }
                                    }
                                )
    
    ventanaSelForm = new Ext.Window(
                                            {
                                                title: 'Selecci&oacute;n de proceso',
                                                width: 580 ,
                                                height:370,
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
	//cargarFormularios(alOpciones,ventanaSelForm);
}

function mostrarVentanaProcesosFrm(nodoSel,idProceso)
{

    var alOpciones=		new Ext.data.SimpleStore(
                                                    {
                                                        fields:	[
                                                                 	{name: 'idProceso'},
                                                                    {name: 'nombre'}, 
                                                                    {name: 'descripcion'}
                                                                    
                                                                ]
                                                    }
                                                );
    
    
    var dsOpciones= [];
    
    alOpciones.loadData(dsOpciones);
    
    var cmFrmDTD= new Ext.grid.ColumnModel   	(
                                                    [
                                                        new  Ext.grid.RowNumberer(),
                                                        {
                                                            header:'Proceso',
                                                            width:150,
                                                            dataIndex:'nombre'
                                                        },
                                                        {
                                                        	header:'Descripci&oacute;n',
                                                            width:300,
                                                            dataIndex:'descripcion'
                                                        }
                                                        
                                                       
                                                    ]
                                                );
    
    
    var tblOpciones=	new Ext.grid.GridPanel	(
                                                        {
                                                            id:'gridFormulariosProc',
                                                            store:alOpciones,
                                                            frame:true,
                                                            cm: cmFrmDTD,
                                                            height:300,
                                                            width:540,
                                                            title:'Elija un proceso:'
                                                            
                                                        }
                                                    );
    
    panelGrid=new Ext.Panel	(
                                {
                                    y:10,
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
    
    

    
    
    
    btnSiguiente=new Ext.Button	(
                                    {
                                        text: '<?php echo $etj["lblSiguiente"] ?> >>',
                                        minWidth:80,
                                        id:'btnFinalizar',
                                        listeners:	{
                                                        click:
                                                                {
                                                                    fn:function()
                                                                    {
                                                                    	
                                                                        var filaSel= tblOpciones.getSelectionModel().getSelected();
                                                                        if(filaSel==null)
                                                                        {
                                                                        	Ext.MessageBox.alert('<?php echo $etj["lblAplicacion"] ?>','Primero debe seleccionar un proceso');
                                                                        	return;
                                                                        }
                                                                        var idProceso=filaSel.get('idProceso');
                                                                        agregarOpcion(nodoSel,'9',idProceso);
                                                                        ventanaSelForm.close();
                                                                    }
                                                                }
                                                    }
                                    }
                                )
    
    ventanaSelForm = new Ext.Window(
                                            {
                                                title: 'Selecci&oacute;n de proceso',
                                                width: 580 ,
                                                height:370,
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
	llenarDatosFrm(ventanaSelForm,idProceso);

}

function llenarDatosFrm(ventana,idProceso)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var arrDatos=eval(arrResp[1]);
            Ext.getCmp('gridFormulariosProc').getStore().loadData(arrDatos);
            ventana.show();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesPortal.php',funcAjax, 'POST','funcion=73&idProceso='+idProceso,true);
}

function mostrarVentanaProcesoSel(nodoSel)
{
    
    var cmbProcesos=crearComboExt('cmbProcesos',<?php echo $arrProcesosComplejos?>,250,5,350);
    var form = new Ext.form.FormPanel(	
                                        {
                                            baseCls: 'x-plain',
                                            layout:'absolute',
                                            defaultType: 'textfield',
                                            items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            xtype:'label',
                                                            html:'Elija el proceso al desea ligar la opci&oacute;n a crear:'
                                                        },
                                                        cmbProcesos
                                                    ]
                                        }
                                    );
    
    

    
    
    
    btnSiguiente=new Ext.Button	(
                                    {
                                        text: '<?php echo $etj["lblSiguiente"] ?> >>',
                                        minWidth:80,
                                        id:'btnFinalizar',
                                        listeners:	{
                                                        click:
                                                                {
                                                                    fn:function()
                                                                    {
                                                                    	if(cmbProcesos.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	cmbProcesos.focus();
                                                                            }
                                                                            msgBox('Debe seleccionar el proceso al cual desea ligar la opci&oacute;n a agregar',resp);
                                                                            return;
                                                                        }
                                                                        agregarOpcion(nodoSel,'10',cmbProcesos.getValue());
                                                                        ventanaSelForm.close();
                                                                        
                                                                    }
                                                                }
                                                    }
                                    }
                                )
    
    ventanaSelForm = new Ext.Window(
                                            {
                                                title: 'Selecci&oacute;n de proceso',
                                                width: 650 ,
                                                height:130,
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

function mostrarVentanaDocumento(nodoSel)
{
	var conf={};
    conf.url='../galeriaDocumentos/admonDocumentos.php';
    conf.titulo='Galer&iacute;a de documentos';
    conf.ancho='90%';
    conf.alto='95%';
    conf.params=[['cPagina','sFrm=true'],['fSel','window.parent.documentoSeleccionado']];
    abrirVentanaFancy(conf);
    	
}

function documentoSeleccionado(idDocumento,url)
{
	var objConf={};
    objConf.url=url;
    objConf.idDocumento=idDocumento;
	agregarOpcion(nodoSeleccionadoAgregar,'11',objConf);

}


function agregarActorProceso(iP)
{
	var idProceso=(iP);
	var arrActores=[];
	var gridActores=crearGridActores();
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:'Seleccione los actores a agregar:'
                                                        },
                                                        gridActores
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar actores',
										width: 550,
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
																		var filas=gridActores.getSelectionModel().getSelections();
                                                                        if(filas.length==0)
                                                                        {
                                                                        	msgBox('Debe seleccionar al menos un actor para agregar como usuario del menu');
                                                                        	return;
                                                                        }
                                                                        
                                                                        var x;
                                                                       
                                                                        var idProceso=gE('idProceso').value;
                                                                        var id;
                                                                        var tipo;
                                                                        var cadActores='';
                                                                        var llave;
                                                                        var nActor='';
                                                                        var pos;
                                                                        var tblRoles=gEx('tblRoles');
                                                                        for(x=0;x<filas.length;x++)
                                                                        {
                                                                        	id=filas[x].get('idActor');
                                                                            tipo=filas[x].get('tipo');
                                                                            llave=id+'|'+tipo;
                                                                            nActor=filas[x].get('actor');
                                                                            
                                                                            pos=obtenerPosFila(tblRoles.getStore(),'codigoRol',llave);
                                                                            if(pos==-1)
                                                                            {
                                                                            	var r=new regRol	(
                                                                                						{
                                                                                                        	codigoRol:llave,
                                                                                                            rol:nActor,
                                                                                                            tipoActor:tipo
                                                                                                        }
                                                                                					)
                                                                             	tblRoles.getStore().add(r);
                                                                            }
                                                                            
                                                                           
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
	ventanaAM.show();                                
	obtenerActoresDisponiblesProceso(idProceso,ventanaAM,gridActores.getStore());
}

function obtenerActoresDisponiblesProceso(idProceso,ventana,almacen)
{
	
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var datos=eval(arrResp[1]);
            almacen.loadData(datos);
        	ventana.show();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=55&todosActores=1&idProceso='+idProceso,true);	
}

function crearGridActores()
{
	dsDatos=[];
    alDatos=	new Ext.data.SimpleStore	(
                                                {
                                                    fields:	[
                                                                {name: 'idActor'},
                                                                {name: 'actor'},
                                                                {name: 'tipo'}
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
															header:'Actor',
															width:200,
															sortable:true,
															dataIndex:'actor'
														},
														{
															header:'Tipo',
															width:200,
															sortable:true,
															dataIndex:'tipo',
                                                            renderer:renderTipoUsuario
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            
                                                            store:alDatos,
                                                            frame:true,
                                                            x:10,
                                                            y:40,
                                                            cm: cModelo,
                                                            height:260,
                                                            width:500,
                                                            sm:chkRow
                                                        }
                                                    );
	return 	tblGrid;		
}

function renderTipoUsuario(val)
{
	if(val=='1')
    	return "Usuario";
    else
    	return "Comit&eacute;";
}

function uploadSuccess(file, serverData) 
{
	
	file.id = "singlefile";	// This makes it so FileProgress only makes a single UI element, instead of one for each file
	
	var arrDatos=serverData.split('|');
	
		
	if ( arrDatos[0]!='1') 
	{
		
		
	} 
	else 
	{
		var tblGrid=gEx('gridIdiomas');
		document.getElementById("hidFileID").value = arrDatos[1];
		if(accion==1)
			guardarDatos(tblGrid,gEx('vAgregarOpcion'),nPadre,tOpcion);
		else
			modificarDatos(tblGrid,ventana,nodoSel);
		
	}
		

}