<?php
session_start();
include("configurarIdiomaJS.php");

$res5=$con->obtenerFilas("select idIdioma,idioma,imagen from 8002_idiomas");
$columnas="";
$ancho=105;
while($fila5=mysql_fetch_row($res5))
{
	if($columnas=="")
		$columnas= "{header:'<center><img src=\"../images/banderas/".$fila5[2]."\" title=\"".$fila5[1]."\" /></center>',width:150,dataIndex:'idioma_".$fila5[0]."',editor: new Ext.form.TextField ({  style: 'text-align:left'})}";
	else
		$columnas.=","."{header:'<center><img src=\"../images/banderas/".$fila5[2]."\" title=\"".$fila5[1]."\" /></center>',width:150,dataIndex:'idioma_".$fila5[0]."',editor: new Ext.form.TextField ({  style: 'text-align:left'})}";
$ancho+=150;	
}	
$columnas=utf8_decode($columnas);

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
$campos=utf8_decode($campos);
$camposOpciones=utf8_decode($camposOpciones);


?>

function ajustarPorcentaje(idCombo)
{
	var numS=gE('numSecciones').value;
    var x;
    var totalP=0;
    var combo=gE(idCombo);
    var grupoSeccion=gE(idCombo).getAttribute('idSeccion');
    var idCuestionario=gE('idCuestionario').value;
    var porcentaje=combo.options[combo.selectedIndex].value;
    for(x=1;x<=numS;x++)
    {
    	combo=gE('porcentaje_'+x);
        totalP+=parseInt(combo.options[combo.selectedIndex].value);
    }
    
     function funcGuardar()
    {
        arrResp=peticion_http.responseText.split('|');
        if(arrResp[0]=='1')
        {
       	    gE('lblTotal').innerHTML=totalP+' %';
            if(totalP>100)
            {
                function funcResp()
                {
                    gE(idCombo).focus();
                }
                Ext.MessageBox.alert('<?php echo $etj["lblAplicacion"] ?>','<?php echo $etj["msgPorcM"] ?>',funcResp);
                return;
            }
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
            return;
        }
    }
    obtenerDatosWeb("../paginasFunciones/funcionesRevistaE.php",funcGuardar,'POST','funcion=90&'+'&idCuestionario='+idCuestionario+'&idGrupoSeccion='+grupoSeccion+'&porcentaje='+porcentaje,true);		


    
}

RegistroOpciones =Ext.data.Record.create	(
												[
													<?php 
														echo $campos;
													?>
												]
											)

RegistroSimple =Ext.data.Record.create	(
											[
												{name:'id'},
												{name:'nombre'}
											]
										)

function buscarFila(tabla,idFila)
{
	var x;
    for(x=0;x<tabla.rows.length;x++)
    {
    	if(tabla.rows[x].id==idFila)
        	return x;

    }
	return -1;
}

function crearFila(tabla,posicion,contenidos,idElemento)
{
	tabla.insertRow(posicion);
    var fila=tabla.rows[posicion];
    fila.id='fila_'+idElemento.trim();
    tablaContenido='<td><br /><table><tbody><tr>';
    var x;
    for(x=0;x<contenidos.length;x++)
    {
		tablaContenido+='<td>'+contenidos[x]+'</td>';  
    }
    tablaContenido+='</tr></tbody></table></td>'; 
    fila.innerHTML=tablaContenido;
}

function mostrarVentanaNuevoElemento(idSeccion,idEA,idES,idFila)
{
	var porcentaje=gE("lblTotal").innerHTML;
    
	if(porcentaje!='100 %')
    {
    	msgBox('<?php echo $etj["lblErrorPond"] ?>');
    	return;
    }
	var tablaTipoE=[['1','<?php echo $etj["lblEtiqueta"] ?>'],['2','<?php echo $etj["lblPregunta"] ?>']];
	var dsTipoE= new Ext.data.SimpleStore	(
											 	{
													fields:	[
															 	{name:'id'},
																{name:'nombre'}
															]
												}
											)

	

	dsTipoE.loadData(tablaTipoE);	
	
	var cmbTipoE=document.createElement('select');
	
	var comboElementos=new Ext.form.ComboBox	(
                                                    {
                                                        x:120,
                                                        y:5,
                                                        id:'cmbTipoElemento',
                                                        mode:'local',
                                                        emptyText:'<?php echo $etj["lblElijaOpcion"] ?>',
                                                        store:dsTipoE,
                                                        displayField:'nombre',
                                                        valueField:'id',
                                                        transform:cmbTipoE,
                                                        editable:false,
                                                        typeAhead: true,
                                                        triggerAction: 'all',
                                                        lazyRender:true,
                                                        width:200
                                                    
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
																						text:'<?php echo $etj["lblTipoElemento"]?>:'
																					}
																				)
															,
                                                            comboElementos
														]
											}
										);
	
	
	ventanaE = new Ext.Window	(
									{
										title: '<?php echo $etj["lblAplicacion"] ?>',
										width: 400,
										height:150,
										minWidth: 280,
										minHeight: 100,
										layout: 'fit',
										plain:true,
										bodyStyle:'padding:5px;',
										buttonAlign:'center',
										items: form,
										modal:true,
										buttons:	[
														{
															text: '<?php echo $etj["lblBtnAceptar"] ?>',
															handler:function()
																	{
                                                                    	if(comboElementos.getValue()!='')
                                                                        {
																			mostrarVentanaPreguna(comboElementos.getValue(),idSeccion,idEA,idES,idFila);
                                                                        	ventanaE.close();
                                                                        }
                                                                        else
                                                                        {
                                                                        	function funcResp(btn)
                                                                            {
                                                                            	if (btn=='yes')
                                                                                {
                                                                                	comboElementos.focus();
                                                                                }
                                                                            }
                                                                            Ext.MessageBox.alert('<?php echo $etj["lblAplicacion"] ?>','<?php echo $etj["msgDebeSTE"] ?>',funcResp);
                                                                        }
																	}
														},
														{
															text: '<?php echo $etj["lblBtnCancelar"]?>',
															handler:function()
																	{
																		ventanaE.close();
																	}
														}
													]
    								}
								);

    ventanaE.show();
}

function mostrarVentanaPreguna(tipoElemento,idSeccion,idEA,idES,idFila)
{
	crearVentanaNuevoElemento(-1,tipoElemento,idSeccion,idEA,idES,idFila);
}

function crearVentanaNuevoElemento(idElemento,tipoElemento,idSeccion,idEA,idES,idFila)
{
	var tituloVentana='<?php echo $etj["lblAgregarNElem"] ?>';

	function obtenerIdiomas()
	{
		var resp=eval(peticion_http.responseText);
		var tblGrid=crearGridElemento(resp,tipoElemento,idElemento,idSeccion,idEA,idES);
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
		
			ventana = new Ext.Window(
											{
												title: tituloVentana,
												width: 750,
												height:250,
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
																							if(validar(tblGrid))
																							{
																								guardarDatosElemento(tblGrid,ventana,tipoElemento,idFila,idSeccion);
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
		if(idElemento!=-1)
		{
			//llenarDatosMenu(tblGrid,nodoSel);
		}
	}
	obtenerDatosWeb('../paginasFunciones/funciones.php',obtenerIdiomas, 'POST','funcion=4',true);
}

function cambiarColor(val)
{
	 return '<img src="../images/banderas/'+val+'" />';
}

var alNameDTD;

var rgIdiomas = Ext.data.Record.create	
(
	[
			{name: 'idioma'},
			{name: 'idIdioma'},
			{name: 'etiqueta'},
            {name: 'idElemento'},
			{name: 'idSeccion'},
			{name: 'idElemAnt'},
            {name: 'idElemSig'}
            
	  ]
 );

function llenarDatos(datos,idElem,idSecc,idEA,idES)
{
	for (x=0;x<datos.length;x++)
	{
		
		var FilaRegistro = new rgIdiomas(
                                            {
                                                    idioma:datos[x].imagen,
                                                    idIdioma: datos[x].idIdioma,
                                                    etiqueta: '',
                                                    idElemento:idElem,
                                                    idSeccion:idSecc,
                                                    idElemAnt:idEA,
                                                    idElemSig:idES
                                                    
                                               }
                                          );
                                                  
        alNameDTD.add(FilaRegistro); 
	}
}

function crearGridElemento(datos,tipoTabla,idElemento,idSeccion,idEA,idES)
{
	var tituloElemento;
    if(tipoTabla==1)
    	tituloElemento='<?php echo $etj["lblIngContE"] ?>';
    else
    	tituloElemento='<?php echo $etj["lblIngPregunta"] ?>';

	var dsNameDTD= 	[];					
    alNameDTD=		new Ext.data.SimpleStore(
    											{
    												fields:	[
    															{name: 'idioma'},
																{name: 'idIdioma'},
																{name: 'etiqueta'}
    														]
    											}
    										);
    alNameDTD.loadData(dsNameDTD);
	llenarDatos(datos,idElemento,idSeccion,idEA,idES);
	
	var cmFrmDTD= new Ext.grid.ColumnModel   	(
												 	[
													 	{
															header:'<?php echo $etj["lblLenguaje"]?>',
															width:80,
															dataIndex:'idioma',
															renderer: cambiarColor
														},
														{
															header:tituloElemento+' *',
															width:600,
															dataIndex:'etiqueta',
															editor: new Ext.form.TextField   (
																									{
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
                                                        width:740
                                                    }
							                    );
	
	return tblFrmDTD;	
}	

function validar(tblGrid)
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

function guardarDatosElemento(tblGrid,ventana,tipoElemento,idFila,idSeccion)
{
	
    var dsGrid=tblGrid.getStore();
    var fila;
	var idIdioma;
	var etiqueta;
    var idElemento;
    var idSeccion;
    var idElemAnt;
    var idElemSig;
	var arrObj="";
	var obj;
	var x;
    for(x=0;x<dsGrid.getCount();x++)
	{
		fila=dsGrid.getAt(x);
		idIdioma=fila.get('idIdioma');
		etiqueta=fila.get('etiqueta');
        idElemento=fila.get('idElemento');
    	idSeccion=fila.get('idSeccion');
    	idElemAnt=fila.get('idElemAnt');
    	idElemSig=fila.get('idElemSig');
        
		obj='{"idIdioma":"'+idIdioma+'","etiqueta":"'+cv(etiqueta)+'","idElemento":"'+idElemento+'","idSeccion":"'+idSeccion+'","idElemAnt":"'+idElemAnt+'","idElemSig":"'+idElemSig+'"}';
		if(arrObj=="")
			arrObj=obj;
		else
			arrObj+=','+obj;
	}
    arrEtiqueta='['+arrObj+']';

    if(tipoElemento=='1')
    {
    	var idCuestionario=gE('idCuestionario').value;
    	objFinal='{"idCuestionario":"'+idCuestionario+'","pregunta":'+arrEtiqueta+'}';
												
    	guardarPregunta(objFinal,ventana,idElemento,idFila,idSeccion);
    
    
    	 ventana.close();
    }
    else
    {
   	    mostrarVEntCerrada(arrEtiqueta,idElemento,idFila,idSeccion);
        ventana.close();
    }
}

function mostrarVEntCerrada(objPregunta,accion,idFila,idSeccion)
{
	
		var dsOpciones= [<?php echo "[".$filaDefault."]" ?>];
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
																header:'<?php echo $etj["titValorOp"]?>',
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
																store:alOpciones,
																frame:true,
																clicksToEdit: 2,
																cm: cmFrmDTD,
																height:300,
																width:420,
																title:'<?php echo $etj["titIngOpt"]?>:',
																tbar: [
																		{
																			text: '<?php echo $etj["lblNuevaOp"] ?>',
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
																			text:'<?php echo $etj["lblDelOp"] ?>',
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
																							Ext.Msg.confirm('<?php echo $etj["lblAplicacion"] ?>','<?php echo $etj["msgConfirmDel"]?>',funcConfirmDel);
																						}
																						else
																						{
																							msgBox('<?php echo $etj["msgDebeSelElem"]?>');
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
					Ext.MessageBox.alert('<?php echo $etj["lblAplicacion"]?>','<?php echo $etj["msgErrorOpcionRep"]?>',funcOK);
				}
			}
		}
		tblOpciones.on('afteredit',funcEdicion);
		
		panelGrid=new Ext.Panel	(
									{
										y:5,
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
											text: '<?php echo $etj["lblFinalizar"] ?>',
											minWidth:80,
											id:'btnFinalizarPCerradas',
											listeners:	{
															click:
																	{
																		fn:function()
																		{
                                                                        	
																			if(btnSiguiente.getText()!='<?php echo $etj["lblFinalizar"]?>')
																			{
																				var resul=validarOpciones(tblOpciones.getStore(),tblOpciones);
																				if(resul)
																					mostrarVAyuda(ventanaPregCerradas,tblOpciones);
																			}
																			else
																			{
																				var resul=validarOpciones(tblOpciones.getStore(),tblOpciones);

																				if(resul)
																				{
																					var opciones='';
																					var cadTemp='';
																					var cm=tblOpciones.getColumnModel();
																					var ct=tblOpciones.getStore().getCount();
																					var reg;
																					var x;
                                                                                    
																					for(x=0;x<ct;x++)
																					{
																						reg=tblOpciones.getStore().getAt(x);
																						var valColumnas=obtenerValoresColumnasRegistro(cm,reg);
																						cadTemp='{"vOpcion":"'+reg.get('valorOpt')+'",'+
																								'"columnas":['+valColumnas+']'+
																								'}';
																						if(opciones=='')
																							opciones=cadTemp;
																						else
																							opciones+=','+cadTemp;
																					}
																					var idCuestionario=gE('idCuestionario').value;
                                                                                    objFinal='{"idCuestionario":"'+idCuestionario+'","pregunta":'+objPregunta+',"opciones":['+opciones+']}';
																					
                                                                                    guardarPregunta(objFinal,ventanaPregCerradas,accion,idFila,idSeccion);
																					
																					
																				}
																			}
																			
																		}
																	}
														}
										}
									)
		
		ventanaPregCerradas = new Ext.Window(
												{
													title: '<?php echo $etj["titOpcionesP"]?>',
													width: 450 ,
													height:430,
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
																				/*if(regPropiedadesGuardado.ayuda!=undefined)
																					comboAyuda.setValue(regPropiedadesGuardado.ayuda);
																				else
																					comboAyuda.setValue('2');*/
																				tblOpciones.startEditing(0,1);
																			}
																		}
															},
													buttons:	[
																	btnSiguiente,
																	{
																		text: '<?php echo $etj["lblBtnCancelar"] ?>',
																		handler:function()
																		{
																			ventanaPregCerradas.close();
																		}
																	}
																]
												}
											);
	
	//if(regPropiedadesGuardado.opciones!=undefined)
		//llenarInfoOpciones(alOpciones,regPropiedadesGuardado.opciones);
	ventanaPregCerradas.show();
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
		Ext.MessageBox.alert('<?php echo $etj["lblAplicacion"]?>','<?php echo $etj["msgErrorCeldaVacia"]?>',funcClickOk);
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
			Ext.MessageBox.alert('<?php echo $etj["lblAplicacion"]?>','<?php echo $etj["msgErrCeldaIdiVac"]?>',funcClickOk);	
			
		}
		else
		{
			var colName='';
			for(x=2;x<cm.getColumnCount();x++)
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
								Ext.getCmp('btnFinalizarPCerradas').fireEvent('click');
							}
							return false;
						}
						Ext.MessageBox.confirm('<?php echo $etj["lblAplicacion"] ?>', '<?php echo $etj["msgErrorOpciones"] ?>', funcConfirmacion);
					}
					else
						return true;
				}
			}
            
            
            return true;
		}
	}
}

function obtenerValoresColumnasRegistro(cm,reg)
{
	var columnas='';
	var idLeng='';
	var tColum='';
	var x;
	for(x=2;x<cm.getColumnCount();x++)
	{
		tColumn=cm.getDataIndex(x);
		idLeng=cm.getDataIndex(x).split('_')[1];
		if(columnas=='')
			columnas='{"idLeng":"'+idLeng+'","texto":"'+reg.get(tColumn)+'"}';
		else
			columnas+=',{"idLeng":"'+idLeng+'","texto":"'+reg.get(tColumn)+'"}';
	}
	return columnas;
}

function guardarPregunta(datosP,ventanaPregCerradas,accion,idFila,idSeccion)//accion 0 guardar Nuevo;1 modificar
{
	
	
    
   function funcResp()
    {
    
    	var arrResp=peticion_http.responseText.split('|');
        if(arrResp[0]=='1')
		{
			if(accion==-1)
        	{
            	var tabla=gE('tabla_'+idSeccion);
				var posFila=buscarFila(tabla,idFila);
                var arrContenido=crearArregloContenido(datosP,idSeccion,arrResp[1]);
                gE('frmRecarga').submit();
                //crearFila(tabla,posFila+1,arrContenido,arrResp[1]);
                
            }
        
        	ventanaPregCerradas.close();
		}
		else
		{
			msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
		}
    }
    obtenerDatosWeb('../paginasFunciones/funcionesRevistaE.php',funcResp, 'POST','funcion=91&datosP='+datosP,true);
}

function crearArregloContenido(datos,idSeccion,idElemento)
{
	var objDatos=eval('['+datos+']')[0];
    var idIdioma=gE('hIdidioma').value;
	var pregunta;
    var clase='';
    
    var arrPregunta=objDatos.pregunta;
    var arrOpc=objDatos.opciones;
    if(arrOpc==undefined)
    	clase='';
    else
    	clase='x-grid-empty';
    var x;
    for(x=0;x<arrPregunta.length;x++)
    {
    	if(arrPregunta[x].idIdioma=idIdioma)
        {
        	pregunta='<span class="'+clase+'">'+dv(arrPregunta[x].etiqueta)+'</span>';
        	break;
        }
    }
	
	var arrContenido=new Array();
    arrContenido[0]=pregunta;
    
    if(arrOpc!=undefined)
    {
    	x=0;
        var valorOpt;
        var arrOpciones='';
        var etiquetaOpt='';
        var y;
        
        for(x=0;x<arrOpc.length;x++)
    	{	
    		valorOpt=arrOpc[x].vOpcion;
            for(y=0;y<arrOpc[x].columnas.length;y++)
            {	
            	if(arrOpc[x].columnas[y].idLeng==idIdioma)
                {
                	etiquetaOpt=arrOpc[x].columnas[y].texto;
                    break;
                }
            }
            if(arrOpciones=='')
            	arrOpciones='<option value="'+valorOpt+'">'+etiquetaOpt+'</option>';
             else
             	arrOpciones+='<option value="'+valorOpt+'">'+etiquetaOpt+'</option>';
        }
    	arrContenido[1]='&nbsp;&nbsp;<select>'+arrOpciones+'</select>';
    }
    else
    	arrContenido[1]='';
    
    arrContenido[2]='&nbsp;&nbsp;<a href="javascript:mostrarVentanaNuevoElemento('+idSeccion+','+idElemento+',-1,\'fila_'+idElemento+'\')"> <img src="../images/agregaOpcion.gif" title="<?php echo $etj["lblAgregarPSig"]?>" alt="<?php echo $etj["lblAgregarPSig"]?>" /></a>'+
    				'&nbsp;&nbsp;<a href="javascript:eliminarElemento('+idElemento+','+idSeccion+')"><img src="../images/eliminaMenu.gif" title="<?php echo $etj["lblEliminarElem"]?>" alt="<?php echo $etj["lblEliminarElem"]?>" /></a>';
    arrContenido[3]='';
    return arrContenido;
}

function eliminarElemento(idElemento,idSeccion)
{
	var porcentaje=gE("lblTotal").innerHTML;
    
	if(porcentaje=='100 %')
    {
        function resp(btn)
        {
            if(btn=='yes')
            {
                function funcResp()
                {
                    arrResp=peticion_http.responseText.split('|');
                    if(arrResp[0]=='1')
                    {
                        var tabla=gE('tabla_'+idSeccion);
                        var pos=buscarFila(tabla,'fila_'+idElemento)
                        tabla.deleteRow(pos);
                    }
                    else
                    {
                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                    }
                }
                obtenerDatosWeb('../paginasFunciones/funcionesRevistaE.php',funcResp, 'POST','funcion=92&idGrupoElemento='+idElemento,true);
            }
        }
        Ext.MessageBox.confirm('<?php echo $etj["lblAplicacion"]?>','<?php echo $etj["msgConfElimEl"]?>',resp);
	}
    else
    {
    	msgBox('<?php echo $etj["lblErrorPond"] ?>');
    }
}