<?php
session_start();
include("configurarIdiomaJS.php");
?>

Ext.onReady(inicializar);
var nodoSel=null;

function inicializar()
{
	
	
    var idComite=gE('idComite').value;
    
    if(idComite!='-1')
    {
    	var tabs = new Ext.TabPanel	(
                                        {
                                            renderTo: 'spComites',
                                            activeTab: 0,
                                            width:700,
                                            height:500,
                                            items:	[	 
                                                        {
                                                            contentEl:'tblComites', 
                                                            title:'Datos comit&eacute;'
                                                        },
                                                        {
                                                            contentEl:'tblFunciones', 
                                                            title:'Funciones comit&eacute;'
                                                        }
                                                     ]
                                          }
                                     )
								
    }
    else
    {
    	var tabs = new Ext.TabPanel	(
                                        {
                                            renderTo: 'spComites',
                                            activeTab: 0,
                                            width:700,
                                            height:500,
                                            items:	[	 
                                                        {
                                                            contentEl:'tblComites', 
                                                            title:'Datos comit&eacute;'
                                                        }
                                                     ]
                                          }
                                     )
    }
    
    
    gE('_nombreComitevch').focus();
    crearArbolFunciones();
}   
    
function validar()
{
	if(validarFormularios('frmEnvio'))
	{
    	
		gE('frmEnvio').submit();
	}
}

function crearArbolFunciones()
{
	var idComiteV=gE('idComite').value;
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
																funcion:'7',
                                                                idComite:idComiteV
															},
												dataUrl:'../paginasFunciones/funcionesProyectos.php'
											}
										)		
										
	var arbolOpciones=new Ext.tree.TreePanel	(
														{
															x:10,
															y:40,
															id:'arbolFunciones',
															el:'spFunciones',
															height:400,
															width:590,
															useArrows:true,
															autoScroll:true,
															animate:true,
															enableDD:true,
															containerScroll: true,
															root:raiz,
															loader: cargadorArbol,
															rootVisible:false,
															tbar:
															[
																{
																	id:'tAgregarRol',
																	text :'Agregar Rol',
																	icon:'../images/user_add.png',
																	cls:'x-btn-text-icon',
                                                                    width :100,
																	handler:function()
																			{
																				agregarRol();
																			}
																},
																{
																	id:'tAgregarFuncion',
																	text :'Agregar Funci&oacute;n',
																	icon:'../images/process_accept.png',
																	cls:'x-btn-text-icon',
                                                                    disabled:true,
                                                                    width :100,
																	handler:function()
																			{
																				agregarFuncion();
																			}
																},
																
																{
																	id:'tEliminarRolFuncion',
																	text :'Remover Rol/Funci&oacute;n',
																	icon:'../images/delete.png',
																	cls:'x-btn-text-icon',
                                                                    width :100,
																	handler:function()
																			{
																				eliminarRolFuncion();
																			}
																},'-',
                                                                {
																	id:'tModificarConfRol',
																	text :'Modificar configuraci&oacute;n del rol',
																	icon:'../images/pencil.png',
																	cls:'x-btn-text-icon',
                                                                    width :100,
                                                                    hidden:true,
																	handler:function()
																			{
																				modificarConfRol();
																			}
																}
																
															]
														}
													)
	arbolOpciones.render();		
    arbolOpciones.expandAll();
    arbolOpciones.on('click',funcClikArbol);	
	
}

function funcClikArbol(nodo, evento)
{
	nodoSel=nodo;
    if(nodo.attributes.tipo=='1')
    {
    	Ext.getCmp('tAgregarFuncion').enable();
        gEx('tModificarConfRol').show();
    }
    else
    {
    	Ext.getCmp('tAgregarFuncion').disable();
    }
}

<?php
		$consulta="select concat(idRol,'_',extensionRol),nombreGrupo from 8001_roles where idIdioma=".$_SESSION["leng"]." order by nombreGrupo";
		$arrRoles=uEJ($con->obtenerFilasArreglo($consulta));
		
		$consulta="select valor,texto from 1004_siNo where idIdioma=".$_SESSION["leng"];
		$arrSiNo=$con->obtenerFilasArreglo($consulta);
		
?>
var arrSiNo=<?php echo $arrSiNo?>;
var arrUnidades=[['1','D\xEDas'],['2','Meses'],['3','A\xF1os']];    

function agregarRol()
{
	
    var arrRoles=<?php echo $arrRoles;?>;
    var arrSiNo=<?php echo $arrSiNo?>;
    var arrUnidades=[['1','D\xEDas'],['2','Meses'],['3','A\xF1os']];
    var cmbExtensiones=crearComboExt('cmbExtensiones',[],100,35,250);
	cmbExtensiones.hide();
	var cmbRoles=crearComboExt('cmbRoles',arrRoles,100,5,250);
    var cmbSiNo=crearComboExt('cmbSiNo',arrSiNo,100,65);
    var cmdTiempo=crearComboExt('cmbTiempo',arrUnidades,190,95);
    cmdTiempo.setWidth(120);
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
                                                        cmbExtensiones,
                                                        {
                                                        	xtype:'label',
                                                        	id:'lblEvaluado',
                                                            x:10,
                                                            y:70,
                                                            html:'&iquest;Es evaluado:?'
                                                        
                                                        },
                                                        cmbSiNo,
                                                        {
                                                        	xtype:'label',
                                                        	id:'lblTiempoPermanencia',
                                                            x:10,
                                                            y:100,
                                                            html:'Tiempo de permanencia:'
                                                        },
                                                        {
                                                        	x:140,
                                                            y:95,
                                                            xtype:'numberfield',
                                                            allowDecimals:false,
                                                            id:'txtTiempo',
                                                            width:40
                                                        },
                                                        cmdTiempo
                                                        
													]
										}
									)
	var ventana=new Ext.Window(
							   		{
										title:'Agregar rol',
										width:380,
										height:210,
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
                                                               
                                                                var codigoRolN=arrId[0]+'_'+extension;
                                                                var raiz=Ext.getCmp('arbolFunciones').getRootNode();
                                                                var rolExiste=existeRolArbol(raiz,codigoRolN);
                                                                if(!rolExiste)
                                                                {
                                                                
                                                                	if(evaluado=='')
                                                                     {
                                                                            function funcEvaluado()
                                                                            {
                                                                                cmbSiNo.focus();
                                                                            }
                                                                            msgBox('Debe indicar si el miembro del comit&eacute; es evaluado',funcEvaluado);
                                                                      }
                                                                      
                                                                      var tiempoPermanencia=gEx('txtTiempo').getRawValue()+'_'+cmdTiempo.getValue();
                                                                      if(tiempoPermanencia=='')
                                                                      {
                                                                            function funcTiempoPermanencia()
                                                                            {
                                                                                gEx('txtTiempo').focus();
                                                                            }
                                                                            msgBox('Debe indicar el tiempo de permanencia del miembro',funcTiempoPermanencia);
                                                                      }
                                                                      
                                                                      if(cmdTiempo.getValue()=='')
                                                                      {
                                                                            function funcTiempo()
                                                                            {
                                                                                cmdTiempo.focus();
                                                                            }
                                                                            msgBox('Debe indicar  la unidad de tiempo a emplear como tiempo de permanencia del miembro',funcTiempo);
                                                                      }
                                                                      
                                                                
                                                                	var evaluado=cmbSiNo.getValue();
                                                                    var tiempoPermanencia=gEx('txtTiempo').getValue()+'_'+cmdTiempo.getValue();
                                                                   
                                                                   	if(evaluado=='')
                                                                     {
                                                                            function funcEvaluado()
                                                                            {
                                                                                cmbSiNo.focus();
                                                                            }
                                                                            msgBox('Debe indicar si el miembro del comit&eacute; es evaluado',funcEvaluado);
                                                                            return;
                                                                      }
                                                                      
                                                                      var tiempoPermanencia=gEx('txtTiempo').getRawValue()+'_'+cmdTiempo.getValue();
                                                                      if(tiempoPermanencia=='')
                                                                      {
                                                                            function funcTiempoPermanencia()
                                                                            {
                                                                                gEx('txtTiempo').focus();
                                                                            }
                                                                            msgBox('Debe indicar el tiempo de permanencia del miembro',funcTiempoPermanencia);
                                                                             return;
                                                                      }
                                                                      
                                                                      if(cmdTiempo.getValue()=='')
                                                                      {
                                                                            function funcTiempo()
                                                                            {
                                                                                cmdTiempo.focus();
                                                                            }
                                                                            msgBox('Debe indicar  la unidad de tiempo a emplear como tiempo de permanencia del miembro',funcTiempo);
                                                                             return;
                                                                      }
                                                                
                                                                	var nExtension=cmbExtensiones.getValue();
                                                                    var txtExtension='';
                                                                    if(nExtension!='')
                                                                    {
                                                                    	txtExtension=' ('+cmbExtensiones.getRawValue()+')';
                                                                    }
                                                                    var textoRol=cmbRoles.getRawValue()+txtExtension;
                                                                    guardarRol(raiz,ventana,codigoRolN,evaluado,tiempoPermanencia);
                                                                    
                                                                    
                                                                    
                                                                   
                                                                    
                                                                }
                                                                else
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

function existeRolArbol(raiz,valor)
{
	var x;
    for(x=0;x<raiz.childNodes.length;x++)
    {
    	var nodo=raiz.childNodes[x];
        if(nodo.id==valor)
        	return true;
    }
    return false;
}

function guardarRol(raiz,ventana,codigoRol,evaluado,tiempoPermanencia)
{
	var idComite=gE('idComite').value;
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	raiz.reload();
            var arbolOpciones=Ext.getCmp('arbolFunciones');
		    arbolOpciones.expandAll();
        	ventana.close();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=8&idComite='+idComite+'&rol='+codigoRol+'&evaluado='+evaluado+'&tiempoPermanencia='+tiempoPermanencia,true);
}

function eliminarRolFuncion()
{
	if(nodoSel==null)
    {
    	msgBox('Debe elegir el rol/funci&oacute;n a eliminar');
        return;
    }

	var msg;
   	var idComite=gE('idComite').value;
	if(nodoSel.attributes.tipo=='1')
    	msg='Est&aacute; seguro de querer remover el rol seleccionado?';
    else
    	msg='Est&aacute; seguro de querer remover la funci&oacute;n seleccionada?';
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
                	var arbolOpciones=Ext.getCmp('arbolFunciones');
		
                	var raiz=arbolOpciones.getRootNode();
                	raiz.reload();	
       			    arbolOpciones.expandAll();
                    nodoSel=null;
                    Ext.getCmp('tAgregarFuncion').disable();
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=9&idComite='+idComite+'&id='+nodoSel.attributes.id+'&tipo='+nodoSel.attributes.tipo,true);
        }
    }
    Ext.MessageBox.confirm('<?php echo $etj["lblAplicacion"]?>',msg,resp);
}

function agregarFuncion()
{
	var tblGrid=crearGridFunciones();
	var form = new Ext.form.FormPanel(	
												{
													baseCls: 'x-plain',
													layout:'absolute',
													defaultType: 'textfield',
													items: 	[
																tblGrid
															]
												}
											);
	ventanaAM = new Ext.Window(
									{
										title: 'Agregar funciones',
										width: 400,
										height:380,
										minHeight: 520,
										layout: 'fit',
										plain:true,
										modal:true,
										bodyStyle:'padding:5px;',
										buttonAlign:'center',
										items: form,
										buttons:	[
														{
															id:'btnAceptar',
															text: 'Aceptar',
															listeners:	{
																			click:function()
																				{
																					var filas=tblGrid.getSelectionModel().getSelections();
                                                                                    if(filas.length==0)
                                                                                    {
                                                                                    	msgBox('Al menos debe seleccionar una función para asociarla al rol');
                                                                                        return;
                                                                                    }
                                                                                    
                                                                                    
                                                                                    var x;
                                                                                    var arrFunciones='';
                                                                                    for(x=0;x<filas.length;x++)
                                                                                    {
                                                                                    	if(arrFunciones=='')
                                                                                        	arrFunciones=filas[x].get('idFuncion');
                                                                                        else
                                                                                        	arrFunciones+=','+filas[x].get('idFuncion');
                                                                                    }
                                                                                    var idComite=gE('idComite').value;
                                                                                    
                                                                                    function funcAjax()
                                                                                    {
                                                                                        var resp=peticion_http.responseText;
                                                                                        arrResp=resp.split('|');
                                                                                        if(arrResp[0]=='1')
                                                                                        {
                                                                                            var raiz=Ext.getCmp('arbolFunciones').getRootNode();
                                                                                           	raiz.reload();
                                                                                            var arbolOpciones=Ext.getCmp('arbolFunciones');
																						    arbolOpciones.expandAll();
                                                                                            ventanaAM.close();
                                                                                        }
                                                                                        else
                                                                                        {
                                                                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                        }
                                                                                    }
                                                                                    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=11&idComite='+idComite+'&rol='+nodoSel.id+'&funciones='+arrFunciones,true);
                                                                                    
                                                                                    
                                                                                    
                                                                                    
																				}
																		}
														},
														{
															text: 'Cancelar',
															handler:function()
																	{
																		ventanaAM.close();
																	}
														}
													]
									}
								);

	llenarGridFunciones(ventanaAM,tblGrid.getStore());                                
                    
}

function crearGridFunciones()
{
	dsFunciones=[];
	alFunciones=	new Ext.data.SimpleStore(
    											{
    												fields:	[
    															{name: 'idFuncion'},
																{name: 'funcion'}
    														]
    											}
    										);

    alFunciones.loadData(dsFunciones);
	chkRow=new Ext.grid.CheckboxSelectionModel();
	var cmFunciones= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
                                                        chkRow,
														{
															header:'Funci&oacute;n',
															width:250,
															sortable:true,
															dataIndex:'funcion'
														}
													]
												);
                                                
	var tblFunciones=	new Ext.grid.EditorGridPanel	(
                                                            {
                                                                store:alFunciones,
                                                                frame:true,
                                                                y:10,
                                                                cm: cmFunciones,
                                                                height:275,
                                                                width:370,
                                                                sm:chkRow
                                                            }
                                                        );
											
										
	return 	tblFunciones;									
}

function llenarGridFunciones(ventana,almacen)
{
	var idComite=gE('idComite').value;
    rol=nodoSel.id;
 	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var arrDatos=eval(arrResp[1]);
			almacen.loadData(arrDatos);            
            ventana.show();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=10&idComite='+idComite+'&rol='+rol,true);   
}


function modificarConfRol()
{
	
    var arrSiNo=<?php echo $arrSiNo?>;
    var arrUnidades=[['1','D\xEDas'],['2','Meses'],['3','A\xF1os']];
    var cmbSiNo=crearComboExt('cmbSiNo',arrSiNo,100,5);
    var cmdTiempo=crearComboExt('cmbTiempo',arrUnidades,190,35);
    cmdTiempo.setWidth(120);
    
	var form=new Ext.form.FormPanel(
										{
											baseCls: 'x-plain',
											layout:'absolute',
											disabled:false,
											items:
													[
													 	
                                                        {
                                                        	xtype:'label',
                                                        	id:'lblEvaluado',
                                                            x:10,
                                                            y:10,
                                                            html:'&iquest;Es evaluado:?'
                                                        
                                                        },
                                                        cmbSiNo,
                                                        {
                                                        	xtype:'label',
                                                        	id:'lblTiempoPermanencia',
                                                            x:10,
                                                            y:40,
                                                            html:'Tiempo de permanencia:'
                                                        },
                                                        {
                                                        	x:140,
                                                            y:35,
                                                            xtype:'numberfield',
                                                            allowDecimals:false,
                                                            id:'txtTiempo',
                                                            width:40
                                                        },
                                                        cmdTiempo
                                                        
													]
										}
									)
	var ventana=new Ext.Window(
							   		{
										title:'Modificar configuraci&oacute;n del rol',
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
                                                            	
                                                                  var evaluado=cmbSiNo.getValue();
                                                                  
                                                                  if(evaluado=='')
                                                                  {
                                                                        function funcEvaluado()
                                                                        {
                                                                            cmbSiNo.focus();
                                                                        }
                                                                        msgBox('Debe indicar si el miembro del comit&eacute; es evaluado',funcEvaluado);
                                                                        return;
                                                                  }
                                                                  
                                                                  var tiempoPermanencia=gEx('txtTiempo').getRawValue()+'_'+cmdTiempo.getValue();
                                                                  if(tiempoPermanencia=='')
                                                                  {
                                                                        function funcTiempoPermanencia()
                                                                        {
                                                                            gEx('txtTiempo').focus();
                                                                        }
                                                                        msgBox('Debe indicar el tiempo de permanencia del miembro',funcTiempoPermanencia);
                                                                        return;
                                                                  }
                                                                  
                                                                  if(cmdTiempo.getValue()=='')
                                                                  {
                                                                  		function funcTiempo()
                                                                        {
                                                                        	cmdTiempo.focus();
                                                                        }
                                                                        msgBox('Debe indicar  la unidad de tiempo a emplear como tiempo de permanencia del miembro',funcTiempo);
                                                                        return;
                                                                  }
                                                                  
                                                                  
                                                                    function funcAjax()
                                                                    {
                                                                        var resp=peticion_http.responseText;
                                                                        arrResp=resp.split('|');
                                                                        if(arrResp[0]=='1')
                                                                        {
                                                                        	gEx('arbolFunciones').getRootNode().reload();
                                                                            ventana.close();
                                                                        }
                                                                        else
                                                                        {
                                                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                        }
                                                                    }
                                                                    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=185&evaluado='+evaluado+'&tiempoPermanencia='+tiempoPermanencia+'&idRolVSComite='+nodoSel.attributes.idRolComite,true);

                                                              
                                                                  
                                                                    
                                                                    
                                                                    
                                                                   
                                                                    
                                                              
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
	obtenerDatosConfRolComite(ventana);
}

function obtenerDatosConfRolComite(ventana)
{

    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	gEx('cmbSiNo').setValue(arrResp[1]);
            gEx('txtTiempo').setValue(arrResp[2]);
            gEx('cmbTiempo').setValue(arrResp[3]);
            ventana.show();
        
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=186&idRolComite='+nodoSel.attributes.idRolComite,true);
    
	
}