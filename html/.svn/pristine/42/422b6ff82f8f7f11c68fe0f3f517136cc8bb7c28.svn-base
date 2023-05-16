<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>

var rgIdiomas = Ext.data.Record.create	
(
	[
        {name: 'idioma'},
        {name: 'idIdioma'},
        {name: 'etiqueta'}
	]
 );

function crearVentanaNuevoElemento(tElemento)
{
	var tituloVentana='Agregar nuevo elemento';
	lblBtnAceptar='Finalizar';
	function obtenerIdiomas()
	{
		var resp=eval(peticion_http.responseText);
		var tblGrid=crearGridElemento();
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
		
		ventanaEtiquetas = new Ext.Window(
											{
												title: tituloVentana,
												width: 750,
												height:280,
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
																	text: lblBtnAceptar,
																	listeners:	{
																					click:function()
																						{
                                                                                        	tblGrid.stopEditing(false);
																							if(validar(tblGrid))
																							{
                                                                                                var arrEtiqueta=obtenerValoresVentanaEtiquetas();
                                                                                                if(tElemento==1)
	                                                                                                objFinal='{"idFormulario":"'+idFormulario+'","pregunta":'+arrEtiqueta+',"tipoElemento":"'+tElemento+'","obligatorio":"0","posX":"@posX","posY":"@posY"}';
                                                                                                if(tElemento==13)
	                                                                                                objFinal='{"idFormulario":"'+idFormulario+'","pregunta":'+arrEtiqueta+',"tipoElemento":"'+tElemento+'","obligatorio":"0","posX":"@posX","posY":"@posY","confCampo":{"ancho":"400","alto":"200"}}';
                                                                                                h.objControl=objFinal;
                                                                                                ventanaEtiquetas.close();
																							}
																						}
																				}
																},
																{
																	text: '<?php echo $etj["lblBtnCancelar"]?>',
																	handler:function()
																			{
																				ventanaEtiquetas.close();
																			}
																}
															]
											}
										);
        llenarDatos(resp,ventanaEtiquetas);
	}
	obtenerDatosWeb('../paginasFunciones/funciones.php',obtenerIdiomas, 'POST','funcion=4',true);
}

function llenarDatos(datos,ventanaEtiquetas)
{
	for (x=0;x<datos.length;x++)
	{
		
		var FilaRegistro = new rgIdiomas(
                                            {
                                                    idioma:datos[x].imagen,
                                                    idIdioma: datos[x].idIdioma,
                                                    etiqueta: ''
                                               }
                                          );
                                                  
        alNameDTD.add(FilaRegistro); 
	}
    ventanaEtiquetas.show();
}

function crearGridElemento(datos)
{
	var tituloElemento;
    tituloElemento='Ingrese el contenido de la etiqueta';
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
	
	
	var cmFrmDTD= new Ext.grid.ColumnModel   	(
												 	[
													 	{
															header:'Lenguaje',
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
                                                    	id:'gridEtiquetas',
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

function cambiarColor(val)
{
	 return '<img src="../images/banderas/'+val+'" />';
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
			msgBox('El contenido de esta celda no puede estar vac&iacute;a',funcAceptar);
			
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
			msgBox('Algunos campos obligatorios no han sido especificados en todos los idiomas desea continuar?', funcConfirmacion);
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

function obtenerValoresVentanaEtiquetas()
{
	var dsGrid=Ext.getCmp('gridEtiquetas').getStore();
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
    var arrEtiqueta;
    for(x=0;x<dsGrid.getCount();x++)
	{
		fila=dsGrid.getAt(x);
		idIdioma=fila.get('idIdioma');
		etiqueta=fila.get('etiqueta');
		obj='{"idIdioma":"'+idIdioma+'","etiqueta":"'+cv(etiqueta)+'"}';
		if(arrObj=="")
			arrObj=obj;
		else
			arrObj+=','+obj;
	}
    arrEtiqueta='['+arrObj+']';

	return arrEtiqueta;
}