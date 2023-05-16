<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	
	$consulta="SELECT idTiempoPresupuestal,nombreTiempo FROM 524_tiemposPresupuestales ORDER BY nombreTiempo";
	$arrTiempo=$con->obtenerFilasArreglo($consulta);
	
	$res5=$con->obtenerFilas("select idIdioma,idioma,imagen from 8002_idiomas");
	$columnas="";
	$ancho=670;
	while($fila5=mysql_fetch_row($res5))
	{
		if($columnas=="")
			$columnas= "{header:'<center><img src=\"../images/banderas/".$fila5[2]."\" title=\"".$fila5[1]."\" /></center>',width:210,dataIndex:'idioma_".$fila5[0]."',editor: new Ext.form.TextField ({  style: 'text-align:left'})}";
		else
			$columnas.=","."{header:'<center><img src=\"../images/banderas/".$fila5[2]."\" title=\"".$fila5[1]."\" /></center>',width:210,dataIndex:'idioma_".$fila5[0]."',editor: new Ext.form.TextField ({  style: 'text-align:left'})}";
	$ancho+=210;	
	}	
	if($ancho==255)
		$ancho+=210;
	
	$columnas.=",{header:'Pasa a etapa:',width:200,dataIndex:'numEtapa',editor:cmbPasaEtapa,renderer:formatearEtapa},{header:'Funci&oacute;n de acci&oacute;n',width:200,dataIndex:'funcionEjecucion',editor:cmbFuncionesAccion,renderer:formatearFunciones}";	
	$columnas=uEJ($columnas);
	
	$campos="{name:'valorOpt'}";
	$camposOpciones="valorOpt:''";
	$filaDefault="''";
	if(mysql_data_seek($res5,0))
	{
		while($fila5=mysql_fetch_row($res5))
		{
			$campos.=",{name:'idioma_".$fila5[0]."'}";
			$camposOpciones.=",idioma_".$fila5[0].":''";
			$filaDefault.=",''";
		}	
	}
	$filaDefault.=",''";
	$campos.=",{name:'numEtapa'},{name:'funcionEjecucion'}";
	$campos=uEJ($campos);
	$camposOpciones.=",numEtapa:'',funcionEjecucion:'0'";
	$camposOpciones=uEJ($camposOpciones);
	$consulta="SELECT idFuncion,nombreFuncion FROM 9033_funcionesScriptsSistema WHERE idCategoria=100 ORDER BY  nombreFuncion";
	$arrFuncionesAccion=$con->obtenerFilasArreglo($consulta);
?>
var arrFuncionesAccion=<?php echo $arrFuncionesAccion?>;
var arrFunciones=[
					['1','Ver n\xF3minas'],
                    ['2','Calcular N\xF3mina'],
                    ['10','Recalcular N\xF3mina'],
                    ['11','Calcular/Recalcular N\xF3mina Individual'],
                    ['3','Dictaminar N\xF3mina'],
                    ['4','Eliminar N\xF3mina'],
                    ['5','Cancelar Timbrado Individual'],
                    ['9','Marcar Registros para NO ser Timbrados'],
                    ['6','Modifica Par\xE1metros de N\xF3mina'],
                    ['7','Modifica Fecha de Pago'],
                    ['8','Modifica Fecha de Pago Individual']
                 ];
var arrFunciones2=[['5','Crear n\xF3mina']];
var arrAmbito=[['1','Generadas por el usuario'],['2','Pertenecientes a la instituci\xF3n del usuario'],['3','Pertenecientes a la instituci\xF3n y subinstituciones del usuario'],['4','Pertenecientes a instituciones especificadas'],['5','Todas']];//,['7','Pertenecientes al centro de costo del usuario']
var arrTiempo=<?php echo $arrTiempo?>;
var nodoSel=null;
var arrEtapas=null;
var RegistroOpciones =Ext.data.Record.create	(
												[
													<?php 
														echo $campos;
													?>
												]
											)

Ext.onReady(inicializar);

function inicializar()
{
	arrFuncionesAccion.splice(0,0,['0','Ninguno']);
    
	var arbolActores=crearArbolCategorias();
	new Ext.Viewport(	{
                            layout: 'border',
                            items: [
                            			{
                                        	xtype:'panel',
                                            title:'<span class="letraRojaSubrayada8" style="font-size:14px !important"><b>Escenario de nómina</b></span>',	
                                            region:'center',
                                            layout:'border',
                                            items:	[
                                            			arbolActores,
                                                        {
                                                            id: 'content',
                                                            region: 'center',
                                                            xtype:'iframepanel',
                                                            border:false,
                                                            frame:false,
                                                            tbar:	[
                                                            			{
                                                                        	icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Agregar nueva etapa',
                                                                            handler:function()
                                                                            		{
                                                                                    	agregarEtapa();	
                                                                                    }
                                                                            
                                                                        }
                                                            		],
                                                            autoLoad:	{
                                                            				url:'../nomina/tblEtapaNomina.php',
                                                                            params:	{
                                                                            			idPerfil:gE('idPerfil').value,
                                                                                        cPagina:'sFrm=true'
                                                                            		}
                                                            		
                                                            			},
                                                            loadMask:	{
                                                                            msg:'Cargando'
                                                                        }
                                                        }
                                            		]   
										}                                     
                                     ]
						}
                    )   
}


function agregarEtapa(iE,nEtapa,nombre)
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
                                                            html:'No. etapa:'
                                                            
                                                        },
                                                        {
                                                        	x:100,
                                                            y:5,
                                                        	xtype:'numberfield',
                                                            width:60,
                                                            id:'txtNoEtapa',
                                                            allowDecimals:true,
                                                            allowNegative:false
                                                            
                                                        },
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            html:'T&iacute;tulo etapa:'
                                                            
                                                        },
                                                        {
                                                        	x:100,
                                                            y:35,
                                                        	xtype:'textfield',
                                                            width:300,
                                                            id:'txtTitulo'
                                                        }

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar etapa',
										width: 450,
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
                                                                	gEx('txtNoEtapa').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
															handler: function()
																	{
																		var txtNoEtapa=gEx('txtNoEtapa');
                                                                        if(txtNoEtapa.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	txtNoEtapa.focus();
                                                                            }
                                                                            msgBox('Debe ingresar el n&uacute;mero que identifica a la etapa',resp);
                                                                        	return;
                                                                        }
                                                                        
                                                                        var txtTitulo=gEx('txtTitulo');
                                                                        if(txtTitulo.getValue()=='')
                                                                        {
                                                                        	function resp2()
                                                                            {
                                                                            	txtTitulo.focus();
                                                                            }
                                                                            msgBox('Debe ingresar el t&iacute;tulo de la etapa',resp2);
                                                                        	return;
                                                                        }
                                                                        
                                                                        /*if(txtNoEtapa.getValue()==1000)
                                                                        {
                                                                        	function resp3()
                                                                            {
                                                                            	txtNoEtapa.focus();
                                                                            }
                                                                            msgBox('El n&uacute;mero de etapa 1000, es un n&uacute;mero reservado por sistema',resp3);
                                                                        	return;
                                                                        }*/
                                                                        
                                                                        if(txtNoEtapa.getValue()==0)
                                                                        {
                                                                        	function resp4()
                                                                            {
                                                                            	txtNoEtapa.focus();
                                                                            }
                                                                            msgBox('El n&uacute;mero de etapa 0, es un n&uacute;mero reservado por sistema',resp4);
                                                                        	return;
                                                                        }
                                                                        
                                                                        var idEtapa=-1;
                                                                        if(iE!=undefined)
	                                                                        idEtapa=bD(iE);
                                                                        var obj='{"idPerfil":"'+gE('idPerfil').value+'","idEtapa":"'+idEtapa+'","noEtapa":"'+txtNoEtapa.getValue()+'","tituloEtapa":"'+txtTitulo.getValue()+'"}';
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	ventanaAM.close();
                                                                             	recargarContenedorCentral();  
                                                                                
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesEspecialesNomina.php',funcAjax, 'POST','funcion=2&obj='+obj,true);
                                                                        
                                                                        
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
	if(iE!=undefined)
    {
    	gEx('txtNoEtapa').setValue(bD(nEtapa));
        gEx('txtTitulo').setValue(bD(nombre));
        
    
    }	                                
	ventanaAM.show();
}



function recargarContenedorCentral()
{
	var content=Ext.getCmp('content');
    content.load	(
    					{
                              url:'../nomina/tblEtapaNomina.php',
                              params:	{
                                          idPerfil:gE('idPerfil').value,
                                          cPagina:'sFrm=true'
                                      }
                      
                          }
    				)
}

function eliminarEtapa(iE)
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
                    recargarContenedorCentral();  
                    
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesEspecialesNomina.php',funcAjax, 'POST','funcion=1&idEtapa='+bD(iE),true);
        }
        
        
    }
    msgConfirm('Est&aacute; seguro de querer eliminar la etapa seleccionada?',resp);
}

function modificarEtapa(iE,nE,nombre)
{
	agregarEtapa(iE,nE,nombre);	
}

function agregarAccion(iA,t)
{
	var cmbAccion;
    if(t==1)
    	cmbAccion=crearComboExt('cmbAccion',arrFunciones,230,5,350);
    else
    	cmbAccion=crearComboExt('cmbAccion',arrFunciones2,230,5,350);
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:'Seleccione el permiso que desea asignar:'
                                                        },
                                                        cmbAccion

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar acci&oacute;n',
										width: 630,
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
																		if(cmbAccion.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	cmbAccion.focus();
                                                                           	}
                                                                        	msgBox('Debe indicar la acci&oacute;n que desea agregar',resp)
                                                                            return;
                                                                        }
                                                                        var accion=cmbAccion.getValue();
                                                                        var pos=existeValorMatriz(arrFunciones,accion);
                                                                        var fila=arrFunciones[pos];
                                                                        
                                                                        var obj='{"idPerfil":"'+gE('idPerfil').value+'","idActor":"'+bD(iA)+'","idAccion":"'+accion+'"}';
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	 ventanaAM.close();
                                                                        
                                                                                recargarContenedorCentral();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesEspecialesNomina.php',funcAjax, 'POST','funcion=3&obj='+obj,true);
                                                                        
                                                                       
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


function mostrarVentanaRealizaDictamen(iE,accion,iA)
{
	var gridOpcionesDictamen=crearGridDictamen();
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:'Ingrese las posibles opciones de dict&aacute;men'
                                                        },
                                                        gridOpcionesDictamen	

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Realiza dict&aacute;men',
										width:610,
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
																		var x;
                                                                        var almacen=gridOpcionesDictamen.getStore();
                                                                        if(almacen.getCount()==0)
                                                                        {
                                                                        	msgBox('Al menos  debe ingresar una opci&oacute;n de dict&aacute;men');
                                                                        	return;
                                                                        }
                                                                        var arrDatos;
                                                                        var fila;
                                                                        var arrOpciones='';
                                                                        var obj;
                                                                        for(x=0;x<almacen.getCount();x++)
                                                                        {
                                                                        	fila=almacen.getAt(x);
                                                                            if(fila.get('opcion')=='')
                                                                            {
                                                                            	function resp1()
                                                                                {
                                                                                	tblGrid.startEditing(x,1);
                                                                                }
                                                                                msgBox('La opci&oacute;n ingresada no  es v&aacute;lida',resp1);
                                                                                return;
                                                                            }
                                                                            
                                                                            obj="[\""+fila.get('idOpcion')+"\",\""+fila.get('opcion')+"\",\""+fila.get('enviaEtapa')+"\"]";
                                                                            if(arrOpciones=='')
                                                                            	arrOpciones=obj;
                                                                            else
                                                                            	arrOpciones+=','+obj;
                                                                            
                                                                        }
                                                                        
                                                                        arrOpciones='['+arrOpciones+']';
                                                                        var idAccion='-1';
                                                                        if(iA!=undefined)	
                                                                        	idAccion=bD(iA);
                                                                        var cadObj='{"opciones":'+arrOpciones+'}';	
                                                                        
                                                                        var obj='{"idPerfil":"'+gE('idPerfil').value+'","idAccionEtapa":"'+idAccion+'","idEtapa":"'+(iE)+'","idAccion":"'+accion+'","obj":"'+bE(cadObj)+'"}';
                                                                        
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
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesEspecialesNomina.php',funcAjax, 'POST','funcion=3&obj='+obj,true);
                                                                        
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

function removerAccion(idAccion)
{
	function resp(btn)
    {
        function funcAjax()
        {
            var resp=peticion_http.responseText;
            arrResp=resp.split('|');
            if(arrResp[0]=='1')
            {
                var fila=gE('fila_Accion_'+bD(idAccion));
                fila.parentNode.removeChild(fila);
                
            }
            else
            {
                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
            }
        }
        obtenerDatosWeb('../paginasFunciones/funcionesEspecialesNomina.php',funcAjax, 'POST','funcion=4&idAccion='+bD(idAccion),true);
	}
    msgConfirm('Est&aacute; seguro de querer remover la acci&oacute;n seleccionada?',resp);
}

var registroGrid=crearRegistro(
									[
                                    	{name: 'idOpcion'},
                                     	{name: 'opcion'},
                                        {name: 'enviaEtapa'}
                                    ]
                               )

function crearGridDictamen()
{
	
	var arrEtapas=eval(bD(gE('arrEtapas').value));
	var cmbEnviaEtapa=crearComboExt('cmbEnviaEtapa',arrEtapas);
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'idOpcion'},
                                                                    {name: 'opcion'},
                                                                    {name: 'enviaEtapa'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel();
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	
														chkRow,
														{
															header:'Opci&oacute;n dict&aacute;men',
															width:240,
															sortable:true,
															dataIndex:'opcion',
                                                            editor:{
                                                            			xtype:'textfield',
                                                                        
                                                            		}
														},
                                                        {
															header:'Env&iacute;a a etapa',
															width:250,
															sortable:true,
															dataIndex:'enviaEtapa',
                                                            editor:cmbEnviaEtapa,
                                                            renderer:function(val)
                                                            			{
                                                                        	if(val=='')
                                                                            	return 'Ninguna';
                                                                            else
                                                                        		return formatearValorRenderer(arrEtapas,val);
                                                                        }
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            
                                                            store:alDatos,
                                                            frame:true,
                                                            y:40,
                                                            cm: cModelo,
                                                            height:270,
                                                            width:550,
                                                            sm:chkRow,
                                                            tbar:	[
                                                            			{
                                                                        	icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Agregar opci&oacute;n',
                                                                            handler:function()
                                                                            		{
                                                                                    	var r=new registroGrid({idOpcion:tblGrid.getStore().getCount()+1,opcion:'','enviaEtapa':''});
                                                                                        tblGrid.getStore().add(r);
                                                                                        tblGrid.startEditing(tblGrid.getStore().getCount()-1,1);
                                                                                        
                                                                                    }
                                                                            
                                                                        },
                                                                        {
                                                                        	icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Remover opci&oacute;n',
                                                                            handler:function()
                                                                            		{
                                                                                    	var fila=tblGrid.getSelectionModel().getSelections();
                                                                                        if(fila.length==0)
                                                                                        {
                                                                                        	msgBox('Debe seleccionar al menos una opci&oacute;n a remover');
                                                                                        	return;
                                                                                        }
                                                                                    	function resp(btn)
                                                                                        {
                                                                                        	if(btn=='yes')
                                                                                            {
                                                                                            	tblGrid.getStore().remove(fila);
                                                                                            }
                                                                                        }
                                                                                        msgConfirm('Est&aacute; seguro de querer remover la opci&oacute;n seleccionada?',resp);
                                                                                        return;
                                                                                    }
                                                                            
                                                                        }
                                                                        
                                                            		]
                                                        }
                                                    );
	return 	tblGrid;
}

function crearArbolCategorias()
{
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
                                                                    funcion:'17',
                                                                    idPerfil:gE('idPerfil').value
                                                                    
                                                                },
                                                    dataUrl:'../paginasFunciones/funcionesEspecialesNomina.php'
                                                }
                                            );		
	cargadorArbol.on('load',function(proxy)
    								{
                                    	nodoSel=null;
                                        
                                    }
                     )                
                
	var arbolOpciones=new Ext.tree.TreePanel	(
														{
															x:10,
															y:40,
                                                            title:'Actores participantes',
															id:'arbolActores',
															region:'west',
															width:220,
															useArrows:true,
															autoScroll:true,
															animate:true,
															enableDD:true,
															containerScroll: true,
															root:raiz,
															loader: cargadorArbol,
															rootVisible:false,
                                                            collapsible:true,
                                                            split:true,
                                                            tbar:
															[
                                                            	{
                                                                	id:'addCategoria',
                                                                    icon:'../images/user_add.png',
                                                                    cls:'x-btn-text-icon',
                                                                    tooltip :'Agregar actor',
                                                                    handler:function()
                                                                            {
                                                                                agregarRol();
                                                                            }
                                                                    
                                                                },'-',
                                                                {
                                                                	id:'delCategoria',
                                                                    icon:'../images/user_remove.png',
                                                                    cls:'x-btn-text-icon',
                                                                    tooltip :'Remover actor',
                                                                    handler:function()
                                                                            {
                                                                                if(nodoSel==null)
                                                                                {
                                                                                	msgBox('Debe seleccionar la categor&iacute;a que desea remover');
                                                                                	return;
                                                                                }
                                                                                var idPerfil=gE('idPerfil').value;
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
                                                                                        obtenerDatosWeb('../paginasFunciones/funcionesEspecialesNomina.php',funcAjax, 'POST','funcion=16&idPerfil='+idPerfil+'&idRol='+nodoSel.id,true);
                                                                                	}
                                                                                }
                                                                                msgConfirm('Est&aacute; seguro de querer remover al actor seleccionado?',resp);
                                                                            }
                                                                    
                                                                }
															]
														}
													)
		
							
	arbolOpciones.on('click',funcClikArbol);	
    return arbolOpciones ;              

}

function funcClikArbol(nodo, evento)
{
	nodoSel=nodo;
}

function agregarRol()
{

	<?php
		$consulta="select concat(idRol,'_',extensionRol),nombreGrupo from 8001_roles where  idIdioma=".$_SESSION["leng"]." order by nombreGrupo";
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
            obtenerDatosWeb('../paginasFunciones/funcionesUsuarios.php',funcAjax, 'POST','funcion=20&noTodos=true&extension='+arrId[1],true);
        
        	
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
                                                                	msgBox('Debe seleccionar una extensi&oacute;n del rol',resp);
                                                                    return;
                                                                }
                                                                var listRoles=gE('listRoles');
                                                                var codigoRol=arrId[0]+'_'+extension;
                                                                
                                                                var rolExiste=existeRol(codigoRol);
                                                                
                                                                if(!rolExiste)
                                                                {
                                                                	var idPerfil=gE('idPerfil').value;
                                                                    function funcAjax()
                                                                    {
                                                                        var resp=peticion_http.responseText;
                                                                        arrResp=resp.split('|');
                                                                        if(arrResp[0]=='1')
                                                                        {
                                                                            gEx('arbolActores').getRootNode().reload();
                                                                        }
                                                                        else
                                                                        {
                                                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                        }
                                                                    }
                                                                    obtenerDatosWeb('../paginasFunciones/funcionesEspecialesNomina.php',funcAjax, 'POST','funcion=15&idPerfil='+idPerfil+'&idRol='+codigoRol,true);
                                                                	
                                                                }
                                                                else
                                                                {
                                                                	msgBox('El rol seleccionado ya ha sido agregado previamente')
                                                                    return;
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

function existeRol(idNodo)
{
	var arbolActores=gEx('arbolActores').getRootNode();
 	var arrNodos= arbolActores.childNodes;
    var x;
    for(x=0;x<arrNodos.length;x++)
    {
    	if(arrNodos[x].id==idNodo)
        {
        	return true;
        }
    }
    return false;	
}

function agregarActor(et)
{

	
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
										width: 530,
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
															id:'btnAceptar',
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
																		var filas=gridActores.getSelectionModel().getSelections();
                                                                        if(filas.length==0)
                                                                        {
                                                                        	msgBox('Debe seleccionar al menos un actor para agregar a la etapa');
                                                                        	return;
                                                                        }
                                                                        
                                                                        var x;
                                                                        var etapa=et;
                                                                        var id;
                                                                        var tipo;
                                                                        var cadActores='';
                                                                        for(x=0;x<filas.length;x++)
                                                                        {
                                                                        	id=filas[x].get('id');
                                                                            tipo=filas[x].get('tipo');
                                                                            
                                                                            if(cadActores=='')
                                                                            	cadActores=id+'|'+tipo;
                                                                            else
                                                                            	cadActores+=','+id+'|'+tipo;
                                                                        }
                                                                        
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	ventanaAM.close();
                                                                                recargarContenedorCentral();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesEspecialesNomina.php',funcAjax, 'POST','funcion=18&idPerfil='+gE('idPerfil').value+'&numEtapa='+bD(et)+'&cadActores='+cadActores,true);
                                                                        
                                                                        
                                                                        
                                                                        
                                                                        
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
                       
	obtenerActoresDisponibles(ventanaAM,gridActores.getStore());
}

function obtenerActoresDisponibles(ventana,almacen)
{
	var arbol=gEx('arbolActores').getRootNode();
    var x;
    var r=crearRegistro([
                              {name: 'id'},
                              {name: 'actor'},
                              {name: 'tipo'} //1 rol; 2 comite
                          ]);
	
    for(x=0;x<arbol.childNodes.length;x++)
    {
    	almacen.add(new r({"id":arbol.childNodes[x].id,"actor":arbol.childNodes[x].text,"tipo":"1"}));
    }
    ventana.show();
}


function crearGridActores()
{
	dsDatos=[];
    alDatos=	new Ext.data.SimpleStore	(
                                                {
                                                    fields:	[
                                                                {name: 'id'},
                                                                {name: 'actor'},
                                                                {name: 'tipo'} //1 rol; 2 comite
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
                                                        	header:'Tipo actor',
															width:200,
															sortable:true,
															dataIndex:'tipo',
                                                            renderer:renderTipoUsuario
                                                        }
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gridActores',
                                                            store:alDatos,
                                                            frame:true,
                                                            x:10,
                                                            y:40,
                                                            cm: cModelo,
                                                            height:260,
                                                            width:490,
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

function removerActorEtapa(iA)
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
                    recargarContenedorCentral();
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesEspecialesNomina.php',funcAjax, 'POST','funcion=19&idActorEtapa='+bD(iA),true);
        }
    }
    msgConfirm('Est&aacute; seguro de querer remover al actor seleccionado?',resp)
}

function removerEtapa(iE)
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
                    recargarContenedorCentral();
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesEspecialesNomina.php',funcAjax, 'POST','funcion=20&idPerfil='+gE('idPerfil').value+'&noEtapa='+bD(iE),true);
        }
    }
    msgConfirm('Est&aacute; seguro de querer remover la etapa seleccionada?',resp)
}

function configurarDisparador(iE)
{
	var arrParam=[['idEtapa',bD(iE)],['cPagina','sFrm=true|mR1=true']];
    enviarFormularioDatos('../nomina/configurarDisparadoresNomina.php',arrParam);
}

function removerAccion(iA)
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
                     recargarContenedorCentral();    
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesEspecialesNomina.php',funcAjax, 'POST','funcion=4&idAccion='+bD(iA),true);
		}
	}
    msgConfirm('Est&aacute; seguro de querer remover la acci&oacute;n seleccionada?',resp);
}

function modificarAmbito(iA,iAcc)
{
	var idAccion=bD(iAcc);
	var cmbAmbito=crearComboExt('cmbAmbito',arrAmbito,240,5,350);
    cmbAmbito.on('select',function(combo,registro)
    						{
                            	if(registro.get('id')=='4')
                                {
                                	gEx('lblEspecifique').show();
                                    gEx('gridInstituciones').show();
                                    gEx('gridInstituciones').getStore().reload();

                                    gEx('vAccion').setHeight(430);
                                    gEx('vAccion').center();
                                }
                                else
                                {
                                	gEx('lblEspecifique').hide();
                                    gEx('gridInstituciones').hide();
                                    gEx('gridInstituciones').getStore().removeAll();
                                    gEx('vAccion').setHeight(130);
                                    gEx('vAccion').center();
                                    
                                }
                            }
    			)
    var gridInstituciones=crearGridInstituciones(bD(iA));
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:'La acci&oacute;n ser&aacute; aplicada sobre n&oacute;minas:'
                                                        },
                                                        cmbAmbito,
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            id:'lblEspecifique',
                                                            hidden:true,
                                                            html:'Especifique las instituciones sobre las cuales er&aacute; aplicada la acci&oacute;n:'
                                                        },
                                                        gridInstituciones

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
                                    	id:'vAccion',
										title: '&Aacute;mbito de la acci&oacute;n',
										width: 630,
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
																		if(cmbAmbito.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	cmbAmbito.focus();
                                                                           	}
                                                                        	msgBox('Debe indicar el &aacute;mbito que desea asignar a la acci&oacute;n',resp)
                                                                            return;
                                                                        }
                                                                        var accion=cmbAmbito.getValue();
                                                                        var cadInstituciones="";
                                                                        
                                                                        if(accion=='4')
                                                                        {
                                                                        	var x;
                                                                        	var filasInstituciones=new Array();
                                                                            var f;
                                                                           
                                                                            for(x=0;x<gridInstituciones.getStore().getCount();x++)
                                                                            {
                                                                            	f=gridInstituciones.getStore().getAt(x);
                                                                                if(f.get('aplicaAccion'))
                                                                                {
                                                                                    if(cadInstituciones=='')
                                                                                        cadInstituciones=f.get('codigoInstitucion');
                                                                                    else
                                                                                    	cadInstituciones+=','+f.get('codigoInstitucion');
                                                                                }
                                                                            }
                                                                            
                                                                            if(cadInstituciones=='')
                                                                            {
                                                                            	msgBox('Debe indicar al menos una instituci&oacute;n sobre la cual aplicar&aacute; la acci&oacute;n');
                                                                            	return;
                                                                            }
                                                                           
                                                                            
                                                                        }
                                                                        
                                                                        var obj='{"idActor":"'+bD(iA)+'","idAccion":"'+accion+'","instituciones":"'+cadInstituciones+'"}';
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	 ventanaAM.close();
                                                                        
                                                                                recargarContenedorCentral();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesEspecialesNomina.php',funcAjax, 'POST','funcion=23&obj='+obj,true);
                                                                        
                                                                       
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
	if(idAccion!='')                                
    {
    	cmbAmbito.setValue(idAccion);
        if(idAccion=='4')
        {
            gEx('lblEspecifique').show();
            gEx('gridInstituciones').show();
            gEx('gridInstituciones').getStore().reload();
			gEx('vAccion').setSize(630,430);
        }
        else
        {
            gEx('lblEspecifique').hide();
            gEx('gridInstituciones').hide();
            gEx('gridInstituciones').getStore().removeAll();
            gEx('vAccion').setSize(630,130);
        }
        
    }
	ventanaAM.show();	
}


function modificarAmbitoEnvioEtapa(iA,iAcc,arrEtapas,eSeleccionada)
{

	var arrEtapasCambio=eval(bD(arrEtapas));
    arrEtapasCambio.splice(0,0,['0','No Cambia Etapa']);
	var cmbEtapaCambio=crearComboExt('cmbEtapaCambio',arrEtapasCambio,240,35,300);
    cmbEtapaCambio.setValue(bD(eSeleccionada));
	var idAccion=bD(iAcc);
	var cmbAmbito=crearComboExt('cmbAmbito',arrAmbito,240,5,350);
    cmbAmbito.on('select',function(combo,registro)
    						{
                            	if(registro.get('id')=='4')
                                {
                                	gEx('lblEspecifique').show();
                                    gEx('gridInstituciones').show();
                                    gEx('gridInstituciones').getStore().reload();

                                    gEx('vAccion').setHeight(460);
                                    gEx('vAccion').center();
                                }
                                else
                                {
                                	gEx('lblEspecifique').hide();
                                    gEx('gridInstituciones').hide();
                                    gEx('gridInstituciones').getStore().removeAll();
                                    gEx('vAccion').setHeight(160);
                                    gEx('vAccion').center();
                                    
                                }
                            }
    			)
    var gridInstituciones=crearGridInstituciones(bD(iA));
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:'La acci&oacute;n ser&aacute; aplicada sobre n&oacute;minas:'
                                                        },
                                                        cmbAmbito,
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            html:'Enviar a etapa:'
                                                        },
                                                        cmbEtapaCambio,
                                                        {
                                                        	x:10,
                                                            y:70,
                                                            id:'lblEspecifique',
                                                            hidden:true,
                                                            html:'Especifique las instituciones sobre las cuales er&aacute; aplicada la acci&oacute;n:'
                                                        },
                                                        gridInstituciones

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
                                    	id:'vAccion',
										title: '&Aacute;mbito de la acci&oacute;n',
										width: 630,
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
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
															handler: function()
																	{
																		if(cmbAmbito.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	cmbAmbito.focus();
                                                                           	}
                                                                        	msgBox('Debe indicar el &aacute;mbito que desea asignar a la acci&oacute;n',resp)
                                                                            return;
                                                                        }
                                                                        
                                                                        
                                                                        if(cmbEtapaCambio.getValue()==='')
                                                                        {
                                                                        	function resp2()
                                                                            {
                                                                            	cmbEtapaCambio.focus();
                                                                           	}
                                                                        	msgBox('Debe indicar la etapa a la cual cambia la n&oacute;mina al ejecutarse la acci&oacute;n',resp2)
                                                                            return;
                                                                        }
                                                                        var accion=cmbAmbito.getValue();
                                                                        var cadInstituciones="";
                                                                        
                                                                        if(accion=='4')
                                                                        {
                                                                        	var x;
                                                                        	var filasInstituciones=new Array();
                                                                            var f;
                                                                           
                                                                            for(x=0;x<gridInstituciones.getStore().getCount();x++)
                                                                            {
                                                                            	f=gridInstituciones.getStore().getAt(x);
                                                                                if(f.get('aplicaAccion'))
                                                                                {
                                                                                    if(cadInstituciones=='')
                                                                                        cadInstituciones=f.get('codigoInstitucion');
                                                                                    else
                                                                                    	cadInstituciones+=','+f.get('codigoInstitucion');
                                                                                }
                                                                            }
                                                                            
                                                                            if(cadInstituciones=='')
                                                                            {
                                                                            	msgBox('Debe indicar al menos una instituci&oacute;n sobre la cual aplicar&aacute; la acci&oacute;n');
                                                                            	return;
                                                                            }
                                                                           
                                                                            
                                                                        }
                                                                        
                                                                        var obj='{"idActor":"'+bD(iA)+'","idAccion":"'+accion+'","instituciones":"'
                                                                        		+cadInstituciones+'","etapaCambio":"'+cmbEtapaCambio.getValue()+'"}';
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	 ventanaAM.close();
                                                                        
                                                                                recargarContenedorCentral();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesEspecialesNomina.php',funcAjax, 'POST','funcion=23&obj='+obj,true);
                                                                        
                                                                       
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
	if(idAccion!='')                                
    {
    	cmbAmbito.setValue(idAccion);
        if(idAccion=='4')
        {
            gEx('lblEspecifique').show();
            gEx('gridInstituciones').show();
            gEx('gridInstituciones').getStore().reload();
			gEx('vAccion').setSize(630,430);
        }
        else
        {
            gEx('lblEspecifique').hide();
            gEx('gridInstituciones').hide();
            gEx('gridInstituciones').getStore().removeAll();
            gEx('vAccion').setSize(630,160);
        }
        
    }
	ventanaAM.show();	
}


function crearGridInstituciones(iA)
{
	var dsDatos=[];
   
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                                          {name: 'codigoInstitucion'},
                                                          {name: 'institucion'},
                                                          {name: 'aplicaAccion'}
                                                      ],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../paginasFunciones/funcionesEspecialesNomina.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'institucion', direction: 'ASC'},
                                                            groupField: 'institucion',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='22';
                                        proxy.baseParams.idAccion=iA;
                                    }
                        )   
       


	var checkColumn = new Ext.grid.CheckColumn	(
	 												{
													   header: 'Aplicar acci&oacute;n',
													   dataIndex: 'aplicaAccion',
													   width: 120

													}
												);
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer({width:40}),
														
														{
															header:'Institucion',
															width:320,
															sortable:true,
															dataIndex:'institucion'
														},
                                                        checkColumn
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            
                                                            store:alDatos,
                                                            frame:true,
                                                            y:100,
                                                            x:10,
                                                            id:'gridInstituciones',
                                                            cm: cModelo,
                                                            hidden:true,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            stripeRows :true,
                                                            columnLines : true,
                                                            height:260,
                                                            width:580,
                                                            plugins:[checkColumn],
                                                            view:new Ext.grid.GroupingView({
                                                                                                    forceFit: false,
                                                                                                    enableGrouping :false
                                                                                                })
                                                        }
                                                    );
	return 	tblGrid;	
}


function formatearFunciones(val)
{
	return formatearValorRenderer(arrFuncionesAccion,val)
}

function mostrarVentanaOpcionesDictamen(iA)
{
	var cmbFuncionesAccion=crearComboExt('cmbFuncionesAccion',arrFuncionesAccion);
	arrEtapas=eval(bD(gEx('content').getFrameWindow().document.getElementById('arrEtapas').value));
    var cmbPasaEtapa=crearComboExt('cmbPasaEtapa',arrEtapas);
    var dsOpciones= [];
    alOpciones=		new Ext.data.SimpleStore(
                                                {
                                                    fields:	[
                                                                <?php 
                                                                    echo $campos;
                                                                ?>
                                                            ]
                                                }
                                            );
    
    alOpciones.loadData(dsOpciones);
    var cmFrmDTD= new Ext.grid.ColumnModel   	(
                                                    [
                                                        new  Ext.grid.RowNumberer(),
                                                        {
                                                            header:'Clave',
                                                            width:100,
                                                            dataIndex:'valorOpt',
                                                            editor: new Ext.form.TextField   (
                                                                                                    {
                                                                                                      
                                                                                                       style: 'text-align:left'
                                                                                                    }
                                                                                                )
                                                        }
                                                        ,
                                                        <?php 
                                                            echo $columnas;
                                                        ?>
                                                    ]
                                                );
    
    
    
    tblOpciones=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gridOpcionesManuales',
                                                            store:alOpciones,
                                                            frame:true,
                                                            clicksToEdit: 1,
                                                            cm: cmFrmDTD,
                                                            height:300,
                                                            columnLines:true,
                                                            width:<?php echo $ancho+35 ?>,
                                                            title:'Ingrese los posibles valores de dict&aacute;men:',
                                                            tbar: [
                                                                    {
                                                                        text: 'Agregar opci&oacute;n',
                                                                        icon:'../images/add.png',
                                                                        handler : function()
                                                                                  {
                                                                                        var r=new RegistroOpciones	(
                                                                                                                        {
                                                                                                                            <?php echo $camposOpciones?>
                                                                                                                        }
                                                                                                                    ) 	
                                                                                        alOpciones.add(r);	
                                                                                        tblOpciones.startEditing(alOpciones.getCount()-1,1);
                                                                                  }
                                                                    }
                                                                    ,
                                                                    {
                                                                        text:'Eliminar Opci&oacute;n',
                                                                        icon:'../images/cancel_round.png',
                                                                        handler:function()
                                                                                {
                                                                                    var fila=tblOpciones.getSelectionModel().getSelectedCell();
                                                                                    if(fila!=null)
                                                                                    {
                                                                                        var posFila=alOpciones.getAt(fila[0]);
                                                                                        function funcConfirmDel(btn)
                                                                                        {
                                                                                        	
                                                                                            if(btn=="yes")
                                                                                            {
                                                                                                alOpciones.remove(posFila);
                                                                                            }
                                                                                        }
                                                                                       msgConfirmWin('Est&aacute; seguro de querer eliminar esta opci&oacute;n?',funcConfirmDel);
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                        msgBox('Debe seleccionar la opci&oacute;n a remover');
                                                                                    }
                                                                                    
                                                                                }  
                                                                    }
                                                                    
                                                                  ]
                                                        }
                                                    );
    
    function funcEdicion(e)
    {
        if(e.field=='valorOpt')
        {
            var res=obtenerPosFila(e.grid.getStore(),'valorOpt',e.value);
            if((res!='-1')&&(e.row!=res))
            {
                function funcOK()
                {
                    e.record.set('valorOpt',e.originalValue);
                    e.grid.getView().refresh();
                    e.grid.startEditing(e.row,e.column);
                }
                Ext.MessageBox.alert('<?php echo $etj["lblAplicacion"]?>','La opci&oacute;n ingresada ya se encuentra registrada',funcOK);
            }
        }
    }
    tblOpciones.on('afteredit',funcEdicion);
    
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
                                        text: 'Aceptar',
                                        minWidth:80,
                                        id:'btnAceptar',
                                        listeners:	{
                                                        click:
                                                                {
                                                                    fn:function()
                                                                    {
                                                                        var resul=validarOpciones(tblOpciones.getStore(),tblOpciones);
                                                                            
                                                                        if(resul)
                                                                        {
                                                                            var opciones=obtenerValoresOpcionesManuales();
                                                                            function funcAjax()
                                                                            {
                                                                                var resp=peticion_http.responseText;
                                                                                arrResp=resp.split('|');
                                                                                if(arrResp[0]=='1')
                                                                                {
                                                                                	ventanaPregCerradas.close();
                                                                                    recargarContenedorCentral();
                                                                                }
                                                                                else
                                                                                {
                                                                                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                }
                                                                            }
                                                                            obtenerDatosWeb('../paginasFunciones/funcionesEspecialesNomina.php',funcAjax, 'POST','funcion=24&objOpciones={"opciones":'+opciones+'}&idAccion='+bD(iA),true);
                                                                            
                                                                            
                                                                            
                                                                        }
                                                                        
                                                                    }
                                                                }
                                                    }
                                    }
                                )
    
    var ventanaPregCerradas = new Ext.Window(
                                            {
                                                title: 'Opciones de dictamen',
                                                width: <?php echo ($ancho+65) ?> ,
                                                height:410,
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
                                                                    text: 'Cancelar',
                                                                    handler:function()
                                                                    {
                                                                    	
                                                                        ventanaPregCerradas.close();
                                                                    }
                                                                }
                                                            ]
                                            }
                                        );
	obtenerOpcionesDictamen(bD(iA),ventanaPregCerradas,tblOpciones.getStore());	                                       

}

function formatearEtapa(val)
{
	var pos=existeValorMatriz(arrEtapas,val);
    if(pos>-1)
		return removerCerosDerecha(val+'')+'.- '+arrEtapas[pos][1];
    else
    	return val;
}

function validarOpciones(dSet,tblEditor)
{
	var res=validarCampoNoVacio(tblOpciones.getStore(),'valorOpt');
	if(res!='-1')
	{
		function funcClickOk()
		{
			tblOpciones.startEditing(res-1,1);
			return false
		}
		msgBox('El contenido de esta celda no puede estar vac&iacute;a',funcClickOk);
	}
	else
	{
		var cm=tblEditor.getColumnModel();
		var idIdioma=gE('hLeng').value;
		var nomColumn='idioma_'+idIdioma;
		var posCol=cm.findColumnIndex(nomColumn);
		var x;
		var res=validarCampoNoVacio(dSet,nomColumn);
		if(res!='-1')
		{
			function funcClickOk()
			{
				tblEditor.startEditing(res-1,posCol);
				return false;
			}
			msgBox('El texto a mostrar como opci&oacute;n debe ser ingresado, al menos en su idioma',funcClickOk);	
			
		}
		else
		{
			var colName='';
            var numColums=cm.getColumnCount()-1;
           
            for(x=2;x<numColums;x++)
            {
                colName=cm.getDataIndex(x);
                if(colName!=nomColumn)
                {
                    res=validarCampoNoVacio(dSet,colName);
                    if(res!='-1')
                    {
                        function funcConfirmacion(btn)
                        {
                            if(btn=='yes')
                            {
                                for(x=2;x<cm.getColumnCount();x++)
                                {
                                    colName=cm.getDataIndex(x);
                                    if(colName!=nomColumn)
                                        rellenarValoresVaciosColumna(dSet,colName,nomColumn);
                                }
                                //Ext.getCmp('btnFinalizarPCerradas').fireEvent('click');
                            }
                            return false;
                        }
                        msgBox('El texto a mostrar como opci&oacute;n no ha sido especificado en todos lo idiomas, desea continuar', funcConfirmacion);
                    }
                    else
                        return true;
                }
            }
            return true;
        	
		}
	}
}

function obtenerValoresOpcionesManuales()
{
	var opciones='';
    var cadTemp='';
    
    var tblOpciones=Ext.getCmp('gridOpcionesManuales');
    var cm=tblOpciones.getColumnModel();
    var ct=tblOpciones.getStore().getCount();
    var reg;
    var x;
    
    for(x=0;x<ct;x++)
    {
    
        reg=tblOpciones.getStore().getAt(x);
        if(reg.data.funcionEjecucion=='')
        	reg.data.funcionEjecucion='0';
        var valColumnas=obtenerValoresColumnasRegistro(cm,reg);
        cadTemp='{"vOpcion":"'+cv(reg.get('valorOpt'))+'",'+
                '"columnas":['+valColumnas+'],'+
                '"etapa":"'+reg.get('numEtapa')+'","funcionEjecucion":"'+reg.data.funcionEjecucion+'"}';
        if(opciones=='')
            opciones=cadTemp;
        else
            opciones+=','+cadTemp;
    }
    return '['+opciones+']';
}

function obtenerValoresColumnasRegistro(cm,reg)
{
	var columnas='';
	var idLeng='';
	var tColum='';
	var x;
    var nColDes=2;
    if(cm.getColumnCount()-nColDes-2==0)
    	nColDes=1;
	for(x=2;x<cm.getColumnCount()-nColDes;x++)
	{
		tColumn=cm.getDataIndex(x);
		idLeng=cm.getDataIndex(x).split('_')[1];
		if(columnas=='')
			columnas='{"idLeng":"'+idLeng+'","texto":"'+cv(reg.get(tColumn))+'"}';
		else
			columnas+=',{"idLeng":"'+idLeng+'","texto":"'+cv(reg.get(tColumn))+'"}';
	}
	return columnas;
}

function obtenerOpcionesDictamen(iA,ventana,almacen)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            almacen.loadData(eval(arrResp[1]));
            ventana.show();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesEspecialesNomina.php',funcAjax, 'POST','funcion=25&idAccion='+iA,true);
}