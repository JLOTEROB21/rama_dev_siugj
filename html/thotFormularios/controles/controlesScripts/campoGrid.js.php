<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	$idFormulario=bD($_GET["idFormulario"]);
	$consulta="SELECT nombreCampo,nombreCampo FROM 901_elementosFormulario WHERE tipoElemento IN(22) AND idFormulario=".$idFormulario." order by nombreCampo";
	$arrCamposDisponibles=$con->obtenerFilasArreglo($consulta);
	$arrCamposDisponibles=substr($arrCamposDisponibles,1);
	
	if($arrCamposDisponibles[0]=="[")
		$arrCamposDisponibles="[['','Ninguno'],".$arrCamposDisponibles;
	else
		$arrCamposDisponibles="[['','Ninguno']".$arrCamposDisponibles;
	
	$consulta="SELECT nombreCampo,nombreCampo FROM 901_elementosFormulario WHERE tipoElemento IN(22,30) AND idFormulario=".$idFormulario." order by nombreCampo";
	$arrCamposDisponibles2=$con->obtenerFilasArreglo($consulta);
	
			
		
?>	

var arrControles25=<?php echo $arrCamposDisponibles2?>;

function mostrarVentanaNombreGrid(iE)
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
                                                            html:'Ingrese el ID del Grid:'
                                                        },
                                                        {
                                                        	x:140,
                                                            y:5,
                                                            id:'txtID',
                                                            xtype:'textfield',
                                                            width:250,
                                                            maskRe:/^[a-zA-Z0-9]$/
                                                        }

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Ingrese ID de Grid',
										width: 430,
										height:120,
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
                                                                	gEx('txtID').focus(500);
																}
															}
												},
										buttons:	[
														{
															
															text: 'Siguiente >>',
															handler: function()
																	{
																		var txtId=gEx('txtID');
                                                                        if(txtId.getValue()=='')
                                                                        {
                                                                        	function funcResp()
                                                                            {
                                                                            	txtId.focus();
                                                                            }
                                                                        	msgBox('De ingresar el ID del grid',funcResp);
                                                                        	return;
                                                                        }
                                                                        
                                                                        var id=gE(txtId.getValue());
                                                                        if(id!=null)
                                                                        {
                                                                        	msgBox('El ID ingresado ya est&aacute; siendo usado por otro elemento del formulario');
                                                                        	return;
                                                                        }
                                                                        
                                                                        mostrarVentanaConfiguracionGrid(txtId.getValue(),iE);
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

function mostrarVentanaConfiguracionGrid(nID,iE)
{

	var ocultarBotonConfOrigenD=false;
    if(iE=='-1')
    	ocultarBotonConfOrigenD=true;
	var gridConf=crearGridConfiguracionCampoGrid(nID,iE);
    var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														gridConf,
                                                        
                                                        {
                                                        	x:590,
                                                            y:340,
                                                            width:260,
                                                            height:35,
                                                            hidden:ocultarBotonConfOrigenD,
                                                            xtype:'button',
                                                            icon:'../images/pencil.png',
                                                            cls:'x-btn-text-icon',
                                                            text:'&nbsp;&nbsp;Configurar Vinculaci&oacute;n con origen de datos',
                                                            handler:function()
                                                            		{
                                                                    	modificarConfiguracionOrigenDatosGrid(iE);
                                                                    }

                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Configurar grid',
										width: 880,
										height:460,
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
																		if(iE!=-1)
                                                                        {
                                                                        	ventanaAM.close();
                                                                        }
                                                                        else
                                                                        {
                                                                        	var idFormulario=gE('idFormulario').value;
                                                                            var x;
                                                                            var cadObj='';
                                                                            var obj;
                                                                            var fila;
                                                                            var cadObj=obtenerConfColumnasCamposGrid(iE,nID);
                                                                            
                                                                            cadObj='{"ajustarPosicion":"1","tipoElemento":"29","posX":"@posX","posY":"@posY","idFormulario":"'+idFormulario+'","nID":"'+nID+'","arrCampos":['+cadObj+']}';
                                                                            h.objControl=cadObj;
                                                                            ventanaAM.close();
                                                                            
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
	if(iE==-1)                              
		ventanaAM.show();	
    else
    {
    	function funcAjax()
        {
            var resp=peticion_http.responseText;
            arrResp=resp.split('|');
            if(arrResp[0]=='1')
            {
                ventanaAM.show();	
                var cadObj=arrResp[1];
                cadObj=cadObj.replace(/___/gi,'|');
            	gEx('gridCampoGrid').getStore().loadData(eval(cadObj));
            	
            }
            else
            {
                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
            }
        }
        obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=57&idElemento='+iE,true);
    }
}

function obtenerConfColumnasCamposGrid(iE,nID)
{
	var obj;
    var cadObj='';
    var gridConf=gEx('gridCampoGrid');
    var idFormulario=gE('idFormulario').value;
    
	for(x=0;x<gridConf.getStore().getCount();x++)
    {
        fila=gridConf.getStore().getAt(x);
        
         obj='{"objComp":"'+bE(fila.get('complementario'))+'","idFormulario":"'+idFormulario+'","idElemento":"'+iE+'","idControl":"'+nID+'","idCampo":"'+fila.get('idCampo')+'","cabecera":"'+cv(fila.get('cabecera'))+'","ancho":"'+fila.get('ancho')+
                '","tipoCampo":"'+fila.get('tipoCampo')+'","obligatorio":"'+fila.get('obligatorio')+'",'+
               '"tablaOriginalVinculada":"'+fila.get('tablaOriginalVinculada')+'","tablaVinculada":"'+fila.get('tablaVinculada')+'","campoVinculado":"'+fila.get('campoVinculado')+'",'+
               '"campoUsrVinculado":"'+fila.get('campoUsrVinculado')+'","campoLlave":"'+fila.get('campoLlave')+'","campoUsrLlave":"'+fila.get('campoUsrLlave')+'","visible":"'+fila.get('visible')+
               '","param":"'+bE(fila.get('param'))+'","pieColumna":"'+fila.get('pieColumna')+'","formatoColumna":"'+fila.get('formatoColumna')+'","textoPie":"'+fila.get('textoPie')+'","campoDepositoPie":"'+fila.get('campoDepositoPie')+'"}';
        if(cadObj=='')
            cadObj=obj;
        else
            cadObj+=','+obj;
              
    }
    return cadObj;
}

function crearGridConfiguracionCampoGrid(nID,iE)
{
	
    var dsDatos=[];
    
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                        			{name: 'idRegistroCampo'},
                                                        			{name: 'idCampo'},
                                                                    {name: 'cabecera'},
                                                                    {name: 'ancho'},
                                                                    {name: 'tipoCampo'},
                                                                    {name: 'obligatorio'},
                                                                    {name: 'tablaVinculada'},
                                                                    {name: 'tablaOriginalVinculada'},
                                                                    {name: 'campoVinculado'},
                                                                    {name: 'campoUsrVinculado'},
                                                                    {name: 'campoUsrLlave'},
                                                                    {name: 'campoLlave'},
                                                                    {name: 'visible'},
												                    {name: 'orden'},
                                                                    {name: 'param'},
                                                                    {name: 'pieColumna'},
                                                                    {name: 'formatoColumna'},
                                                                    {name: 'textoPie'},
                                                                    {name: 'campoDepositoPie'},
                                                                    {name: 'complementario'}
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
                                                        	header:'ID Campo',
                                                            width:150,
                                                            sortable:true,
															dataIndex:'idCampo'
                                                        },
														{
															header:'Encabezado',
															width:150,
															sortable:true,
															dataIndex:'cabecera'
                                                            
														},
                                                        {
                                                        	header:'Ancho',
															width:80,
															sortable:true,
															dataIndex:'ancho'
                                                        },
                                                        {
                                                        	header:'Visible',
															width:80,
															sortable:true,
															dataIndex:'visible',
                                                            renderer:function(val,meta,registro)
                                                            		{
                                                                    	
                                                                    	var pos=existeValorMatriz(arrSiNo,val,0);
                                                                        if(pos!=-1)
	                                                                        return arrSiNo[pos][1];
                                                                        else
                                                                        	return "";
                                                                    }
                                                            
                                                        },
														{
															header:'Tipo de campo',
															width:130,
															sortable:true,
															dataIndex:'tipoCampo',
                                                            renderer:function(val,meta,registro)
                                                            		{
                                                                    	
                                                                    	switch(val)
                                                                        {
                                                                        	case '4':
                                                                            case '8':
                                                                            case '10':
                                                                            break;
                                                                            default:
                                                                                registro.set('tablaVinculada','');
                                                                                registro.set('tablaOriginalVinculada','');
                                                                                
                                                                                registro.set('campoVinculado','');
                                                                                
                                                                                registro.set('campoUsrVinculado','');
                                                                                
                                                                                registro.set('campoUsrLlave','');
                                                                                registro.set('campoLlave','');
                                                                        	break;
                                                                        }
                                                                       
                                                                    	var pos=existeValorMatriz(arrTipoCampo,val,0);
                                                                        if(pos!=-1)
	                                                                        return arrTipoCampo[pos][1];
                                                                        else
                                                                        	return "";
                                                                    }
														},
                                                        {
                                                        	header:'Obligatorio',
															width:100,
															sortable:true,
															dataIndex:'obligatorio',
                                                            renderer:function(val,meta,registro)
                                                            		{
                                                                    	
                                                                    	var pos=existeValorMatriz(arrSiNo,val,0);
                                                                        if(pos!=-1)
	                                                                        return arrSiNo[pos][1];
                                                                        else
                                                                        	return "";
                                                                    }
                                                        	
                                                        },
                                                        {
                                                        	header:'Tabla vinculada',
															width:190,
															sortable:true,
															dataIndex:'tablaVinculada'
                                                        },
                                                        {
                                                        	header:'Campo vinculado / Tipo c&aacute;lculo',
															width:200,
															sortable:true,
															dataIndex:'campoVinculado',
                                                            renderer:function(val,meta,registro)
                                                            		{
                                                                    	
                                                                    	return registro.get('campoUsrVinculado');
                                                                    }
                                                        },
                                                        {
                                                        	header:'Campo llave / C&aacute;lculo',
															width:200,
															sortable:true,
															dataIndex:'campoLlave',
                                                            renderer:function(val,meta,registro)
                                                            		{
                                                                    	return registro.get('campoUsrLlave');
                                                                    }
	                                                    }
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gridCampoGrid',
                                                            store:alDatos,
                                                            frame:true,
                                                            x:5,
                                                            y:10,
                                                            cm: cModelo,
                                                            height:320,
                                                            width:850,
                                                            sm:chkRow,
                                                            tbar:	[
                                                            			{
                                                                        	
                                                                        	text:'Agregar nueva columna',
                                                                            icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            handler:function()
                                                                            		{
                                                                                    	mostrarVentanaNuevaFila(tblGrid,nID,iE,null);
                                                                                    }
                                                                        },
                                                                        {
                                                                        	
                                                                        	text:'Modificar columna',
                                                                            icon:'../images/pencil.png',
                                                                            cls:'x-btn-text-icon',
                                                                            handler:function()
                                                                            		{
                                                                                    	var fila=tblGrid.getSelectionModel().getSelected();
                                                                                        if(fila==null)
                                                                                        {
                                                                                        	msgBox('Debe seleccionar la columna a modificar');
                                                                                        	return;
                                                                                        }
                                                                                        mostrarVentanaNuevaFila(tblGrid,nID,iE,fila);
                                                                                    }
                                                                        },
                                                                        {
                                                                        	text:'Remover columna',
                                                                            icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            handler:function()
                                                                            		{
                                                                                    	var fila=tblGrid.getSelectionModel().getSelected();
                                                                                        if(fila==null)
                                                                                        {
                                                                                        	msgBox('Debe seleccionar la columna a modificar');
                                                                                        	return;
                                                                                        }
                                                                                        function resp(btn)
                                                                                        {
                                                                                        	if(btn=='yes')
                                                                                            {
                                                                                                if(fila.get('idRegistroCampo')=='-1')
                                                                                                {
                                                                                                	tblGrid.getStore().remove(fila);
                                                                                                }
                                                                                                else
                                                                                                {
                                                                                                	function funcAjax()
                                                                                                    {
                                                                                                        var resp=peticion_http.responseText;
                                                                                                        arrResp=resp.split('|');
                                                                                                        if(arrResp[0]=='1')
                                                                                                        {
                                                                                                        	tblGrid.getStore().remove(fila);
                                                                                                            var cadObj=obtenerConfColumnasCamposGrid(iE,nID);
                                                                                                            var divGrid=h.gE('div_'+iE);
                                                                                                            if(divGrid!=null)
                                                                                                            {
                                                                                                                
                                                                                                                posX=divGrid.style.left.replace('px','');
                                                                                                                posY=divGrid.style.top.replace('px','');
                                                                                                                var idFormulario=h.gE('idFormulario');
                                                                                                                var gridCampo=h.gEx('grid_'+iE);
                                                                                                                cadObj='{"ajustarPosicion":"0","ancho":"'+gridCampo.getWidth()+'","alto":"'+gridCampo.getHeight()+'","posX":"'+posX+'","posY":"'+posY+'","idFormulario":"'+idFormulario+'","nID":"'+nID+'","arrCampos":['+cadObj+']}';
                                                                                                                divGrid.parentNode.removeChild(divGrid);
                                                                                                                crearControlGridFormulario(cadObj,iE,'_'+nID);
                                                                                                            }
                                                                                                            
                                                                                                            
                                                                                                            
                                                                                                        }
                                                                                                        else
                                                                                                        {
                                                                                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                        }
                                                                                                    }
                                                                                                    obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=59&idRegistroCampo='+fila.get('idRegistroCampo'),true);
                                                                                                    

                                                                                                }
                                                                                        	}
                                                                                       	}
                                                                                        msgConfirm('Est&aacute; seguro de querer remover la columna seleccionada?',resp);
                                                                                    }
                                                                        }
                                                                        
                                                            		]
                                                        }
                                                    );
	                                                
	return 	tblGrid;		
}

function mostrarVentanaNuevaFila(grid,nID,iE,fila)
{
	var arrPieColumna=[['0','Ninguno'],['6','Etiqueta'],['1','M\xE1ximo'],['2','M\xEDnimo'],['3','No. Registros'],['4','Promedio'],['5','Sumatoria']];
    var arrFormato=[['0','Ninguno'],['1','Moneda'],['2','N\xFAmero entero'],['3','N\xFAmero decimal']];
	var lblModificar='Sin tabla vinculada';

    var lblBtnModificar='<a href="javascript:mostrarVentanaTablasCampoGrid()"><img width="13" heigth="13" src="../images/pencil.png" title="Vincular con tabla" alt="Vincular con tabla"></a>';
	var cmbPieColumna=crearComboExt('cmbPieColumna',arrPieColumna,120,5,125);
    cmbPieColumna.setValue('0');
    cmbPieColumna.on('select',function(combo,registro,indice)
    							{
                                	gEx('txtTextoPie').setValue('');
                                	gEx('txtTextoPie').disable();
                                	switch(registro.get('id'))
                                    {
                                    	case '6':
                                        	gEx('txtTextoPie').enable();
                                            gEx('txtTextoPie').focus(false,500);
                                        break;
                                    }
                                }
    				)
	var arrAlmacenes=obtenerAlmacenesDatosDisponibles('1');
    var comboAlmacenes=crearComboExt('comboAlmacenes',arrAlmacenes,120,5,250);                    
    comboAlmacenes.hide();
    
	var comboTipoCampo=crearComboExt('comboTipoCampo',arrTipoCampo,120,125,200);
    var cmbFormatoColumna=crearComboExt('cmbFormatoColumna',arrFormato,120,35,150);
    cmbFormatoColumna.setValue('0');
    comboTipoCampo.on('select',function(combo,registro,indice)
    							{
                                	var comboCampoVinculado=gEx('comboCampoVinculado');
                                    var comboCampoLlave=gEx('comboCampoLlave');
                                	comboAlmacenes.reset();
                                    comboAlmacenes.hide();
                                    comboCampoVinculado.reset();
                                    comboCampoVinculado.getStore().removeAll();
                                    comboCampoVinculado.disable();
                                    var etiqueta=Ext.getCmp('etiquetaCombo');
                                    etiqueta.setText('Campo vinculado');
                                    comboCampoLlave.reset();
                                    comboCampoLlave.getStore().removeAll();
                                    comboCampoLlave.disable();
                                    gEx('lblTablaVinculada').show();
                                    gEx('lblTablaVinculada').setText(lblModificar);
                                    gEx('confArchivo').hide();
                                    gEx('confAlmacen').hide();
                                    
                                    switch(registro.get('id'))
                                    {
                                        case '4':  //Tabla
                                            gEx('lblTablaVinculada').setText(lblModificar+' '+lblBtnModificar,false);
                                            comboCampoVinculado.reset();
                                            comboCampoVinculado.getStore().removeAll();
                                            comboCampoVinculado.enable();
                                            var etiqueta=Ext.getCmp('etiquetaCombo');
                                            etiqueta.setText('Campo vinculado');
                                            comboCampoLlave.reset();
                                            comboCampoLlave.getStore().removeAll();
                                            comboCampoLlave.enable();
                                            var etiqueta=Ext.getCmp('etiquetaCampo');
                                            etiqueta.setText('Campo llave:');
                                            gEx('confAlmacen').show();
                                        break;
                                        case '8':  //Calculo
                                           function funcAjax()
                                            {
                                                var resp=peticion_http.responseText;
                                                arrResp=resp.split('|');
                                                if(arrResp[0]=='1')
                                                {
                                                    var arreglo=eval(arrResp[1]);
                                                    comboCampoVinculado.reset();
                                                    comboCampoVinculado.getStore().removeAll();
                                                    comboCampoVinculado.getStore().loadData(arreglo);
                                                    comboCampoVinculado.enable();
                                                    var etiqueta=Ext.getCmp('etiquetaCombo');
                                                    etiqueta.setText('Categoria');
                                                    gEx('confAlmacen').show();
                                                }
                                                else
                                                {
                                                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                }
                                            }
                                            obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=200',true);
                                        break;
                                        case '10':  //Almacen de datos
											gEx('lblTablaVinculada').hide();
											comboAlmacenes.show();
                                            gEx('etTablaV').setText('Almac&eacute;n vinculado:',false);
                                            gEx('confAlmacen').show();
                                        break;
                                        case '12':
                                        	 gEx('confArchivo').show();
                                        break;
                                        default:
                                            comboCampoVinculado.reset();
                                            comboCampoVinculado.getStore().removeAll();
                                            comboCampoVinculado.disable();
                                            comboCampoLlave.reset();
                                            comboCampoLlave.getStore().removeAll();
                                            comboCampoLlave.disable();
                                        break;    
                                    }	
                                }		
                      );
    var comboCampoVinculado=crearComboExt('comboCampoVinculado',[],120,35,250);
    comboCampoVinculado.disable();
    comboCampoVinculado.on('select',function(combo,registro,indice)
    							{
                                	
                                	switch(comboTipoCampo.getValue())
                                    {
                                    	case '8':
                                            var categoria=registro.get('id');
                                            if(categoria!='')
                                            {
                                               var comboCampoLlave=gEx('comboCampoLlave');
                                               function funcAjax()
                                                {
                                                    var resp=peticion_http.responseText;
                                                    arrResp=resp.split('|');
                                                    if(arrResp[0]=='1')
                                                    {
                                                        var arreglo=eval(arrResp[1]);
                                                        comboCampoLlave.reset();
                                                        comboCampoLlave.getStore().removeAll();
                                                        comboCampoLlave.getStore().loadData(arreglo);
                                                        comboCampoLlave.enable();
                                                        var etiqueta=Ext.getCmp('etiquetaCampo');
                                                        etiqueta.setText('Calculo:');
                                                    }
                                                    else
                                                    {
                                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                    }
                                                }
                                                obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=201&idCategoria='+categoria,true);
                                            }	
										break; 
                                        case '10':
                                        	/*var comboCampoLlave=gEx('comboCampoLlave');
                                        	var arreglo=obtenerCamposDisponibles(registro.get('id'));
                                        	*/
                                        break; 
                                	}                                          
                                	
                                }
                          );
    var comboCampoLlave=crearComboExt('comboCampoLlave',[],120,65,250);
    comboCampoLlave.disable();
    var comboSiNo=crearComboExt('comboSiNo',arrSiNo,120,155,115);
    comboSiNo.setValue(0);
    var cmbVisibleSiNo=crearComboExt('cmbVisibleSiNo',arrSiNo,120,95,115);
    cmbVisibleSiNo.setValue(1);
    
    comboAlmacenes.on('select',function(combo,registro,indice)
    							{
                             	    comboCampoVinculado.reset();
                                    comboCampoLlave.reset();
									var arrCampo=obtenerCamposDisponibles(registro.get('id'));
                                    comboCampoVinculado.getStore().loadData(arrCampo);
                                    comboCampoVinculado.enable();
                                    comboCampoLlave.getStore().loadData(arrCampo);
                                    comboCampoLlave.enable()
                               	}
                      )
                      
                      
	var tVentana='Agregar columna';
    if(fila)                      
    	tVentana='Modificar columna';
    var arrUnidades=[['B','Bytes'],['KB','KB'],['MB','MB'],['GB','GB']];
	var cmbUnidad=crearComboExt('cmbUnidad',arrUnidades,250,35,85)  ;  
    cmbUnidad.setValue('KB');
    var cmbControlDisponible=crearComboExt('cmbControlDisponible',<?php echo $arrCamposDisponibles?>,120,65,200);
    cmbControlDisponible.setValue('');
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            html:'ID Campo:'
                                                        },
                                                        {
                                                        	id:'txtCampoID',
                                                        	x:120,
                                                            y:5,
                                                            xtype:'textfield',
                                                            width:200,
                                                            maskRe:/^[a-zA-Z0-9]$/
                                                        },
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            html:'Encabezado:'
                                                        },
                                                        {
                                                        	x:120,
                                                            y:35,
                                                            id:'txtEncabezado',
                                                            xtype:'textfield',
                                                            width:200
                                                        },
                                                        {
                                                        	x:10,
                                                            y:70,
                                                            html:'Ancho:'
                                                            
                                                        },
                                                        {
                                                        	x:120,
                                                            y:65,
                                                            id:'txtAncho',
                                                            xtype:'numberfield',
                                                            value:150,
                                                            width:80
                                                        },
                                                        {
                                                        	x:10,
                                                            y:100,
                                                            html:'Visible:'
                                                            
                                                        },
                                                        cmbVisibleSiNo,
                                                        
                                                        
                                                         {
                                                        	x:10,
                                                            y:130,
                                                            html:'Tipo de campo:'
                                                        },
                                                        comboTipoCampo,
                                                         {
                                                        	x:10,
                                                            y:160,
                                                            html:'Obligatorio:'
                                                        },
                                                        comboSiNo,
                                                        {
                                                        	x:10,
                                                            y:180,
                                                            hidden:true,
                                                            id:'confAlmacen',
                                                        	xtype:'fieldset',
                                                            width:490,
                                                            height:125,
                                                            defaultType: 'label',
                                                            title:'Configuraci&oacute;n de tipo de campo',
                                                            layout:'absolute',
                                                            items:	[
                                                            			 {
                                                                            x:10,
                                                                            y:10,
                                                                            html:'Tabla vinculada:',
                                                                            id:'etTablaV'
                                                                        },
                                                                        {
                                                                            x:120,
                                                                            y:10,
                                                                            id:'lblTablaVinculada',
                                                                            html:lblModificar
                                                                        },
                                                                        comboAlmacenes,
                                                                         {
                                                                            x:10,
                                                                            y:40,
                                                                            html:'Campo vinculado:',
                                                                            id:'etiquetaCombo'
                                                                        },
                                                                        comboCampoVinculado,
                                                                         {
                                                                            x:10,
                                                                            y:70,
                                                                            html:'Campo llave:',
                                                                            id:'etiquetaCampo'
                                                                        },
                                                                        comboCampoLlave,
                                                                        {
                                                                            id:'hTablaUsrVinculada',
                                                                            value:'',
                                                                            xtype:'hidden'
                                                                        
                                                                        },
                                                                        {
                                                                            id:'hTablaOriVinculada',
                                                                            value:'',
                                                                            xtype:'hidden'
                                                                        
                                                                        }
                                                            		]
                                                        },
                                                        {
                                                        	x:10,
                                                            y:180,
                                                            id:'confArchivo',
                                                            hidden:true,
                                                        	xtype:'fieldset',
                                                            width:490,
                                                            height:125,
                                                            defaultType: 'label',
                                                            title:'Configuraci&oacute;n de tipo de campo',
                                                            layout:'absolute',
                                                            items:	[
                                                            			 {
                                                                            x:10,
                                                                            y:10,
                                                                            html:'Extensiones permitidas:',
                                                                        },
                                                                        {
                                                                        	x:140,
                                                                            y:5,
                                                                            xtype:'textfield',
                                                                            id:'txtExtensiones',
                                                                            width:300
                                                                        },
                                                                        {
                                                                            x:10,
                                                                            y:40,
                                                                            html:'Tam. m&aacute;x. del archivo:',
                                                                        },
                                                                        {
                                                                        	x:140,
                                                                            y:35,
                                                                            xtype:'numberfield',
                                                                            id:'txtTamMax',
                                                                            width:100
                                                                        },
                                                                        cmbUnidad
                                                            		]
                                                        },
                                                        {
                                                        	x:10,
                                                            y:310,
                                                        	xtype:'fieldset',
                                                            title:'Configuraci&oacute;n de columna',
                                                            width:490,
                                                            height:140,
                                                            layout:'absolute',
                                                            items:	[
                                                                        {	
                                                                        	xtype:'label',
                                                                            x:10,
                                                                            y:10,
                                                                            html:'Pie de columna:'
                                                                        },
                                                                        cmbPieColumna,
                                                                        {
                                                                        	xtype:'label',
                                                                            x:265,
                                                                            y:5,
                                                                            xtype:'textfield',
                                                                            id:'txtTextoPie',
                                                                            width:200,
                                                                            disabled:true
                                                                        },
                                                                        {
                                                                        	xtype:'label',
                                                                            x:10,
                                                                            y:40,
                                                                            html:'Formato de columna:'
                                                                        },
                                                                        cmbFormatoColumna,
                                                                        {
                                                                        	xtype:'label',
                                                                            x:10,
                                                                            y:70,
                                                                            html:'Copiar pie en:'
                                                                        },
                                                                        cmbControlDisponible
                                                                 	]
                                                            
                                                        }
                                                        
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: tVentana,
										width: 530,
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
                                                                        gEx('txtCampoID').focus(500);
                                                                    }
                                                                }
                                                    },
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
																		if(validarDatosColumna())
                                                                        {
                                                                        	var txtCampoID=gEx('txtCampoID');
                                                                            var txtEncabezado=gEx('txtEncabezado');
                                                                            var txtAncho=gEx('txtAncho');
                                                                            var comboTipoCampo=gEx('comboTipoCampo');
                                                                            var hTablaUsrVinculada=gEx('hTablaUsrVinculada');
                                                                            var hTablaOriVinculada=gEx('hTablaOriVinculada');
                                                                            var comboCampoVinculado=gEx('comboCampoVinculado');
                                                                            var comboCampoLlave=gEx('comboCampoLlave');
                                                                          	var idFormulario=gE('idFormulario').value;
                                                                            var idElemento=iE;
                                                                            var tipoCampoA=comboTipoCampo.getValue();
                                                                            var cVinculado=comboCampoVinculado.getValue();
                                                                            var cLLave=comboCampoLlave.getValue();
                                                                            var arbol=gEx('arbolDataSet');
                                                                            
                                                                            objComp='{}';
                                                                            switch(comboTipoCampo.getValue())
                                                                            {
                                                                            	case '10':
                                                                                	hTablaUsrVinculada.setValue(comboAlmacenes.getRawValue());
                                                                                    hTablaOriVinculada.setValue(comboAlmacenes.getValue());
                                                                                    var nodo=buscarNodoID(arbol.getRootNode(),cVinculado);
                                                                                    cVinculado=nodo.nCampo;
                                                                                    nodo=buscarNodoID(arbol.getRootNode(),cLLave);
                                                                                    cLLave=nodo.nCampo;
                                                                                break;
                                                                            	case '12':
                                                                                	var txtTamMax=gEx('txtTamMax');
                                                                                    if(txtTamMax.getValue()=='')
                                                                                    {
                                                                                    	function resp()
                                                                                        {
                                                                                        	txtTamMax.focus();
                                                                                        }
                                                                                        msgBox('Debe indicar el tam&ntilde;o m&aacute;ximo permitido del archivo',resp);
                                                                                        return;
                                                                                    }
                                                                                    
                                                                                
                                                                                	objComp='{"tamMaxArchivo":"'+gEx('txtTamMax').getValue()+'","unidadTamMaximo":"'+cmbUnidad.getValue()+'","extensionesPermitidas":"'+gEx('txtExtensiones').getValue()+'"}';
                                                                                break;
                                                                            }
                                                                            var regGrid=new registroCampoGrid(
                                                                                                                {
                                                                                                                    idRegistroCampo:'-1',
                                                                                                                    idCampo:txtCampoID.getValue(),
                                                                                                                    cabecera:txtEncabezado.getValue(),
                                                                                                                    ancho:txtAncho.getValue(),
                                                                                                                    tipoCampo:comboTipoCampo.getValue(),
                                                                                                                    obligatorio:comboSiNo.getValue(),
                                                                                                                    tablaOriginalVinculada:hTablaOriVinculada.getValue(),
                                                                                                                    tablaVinculada:hTablaUsrVinculada.getValue(),
                                                                                                                    campoVinculado:cVinculado,
                                                                                                                    campoUsrVinculado:comboCampoVinculado.getRawValue(),
                                                                                                                    campoLlave:cLLave,
                                                                                                                    campoUsrLlave:comboCampoLlave.getRawValue(),
                                                                                                                    visible:cmbVisibleSiNo.getValue(),
                                                                                                                    orden:(grid.getStore().getCount()+1),
                                                                                                                    param:'',
                                                                                                                    pieColumna:cmbPieColumna.getValue(),
                                                                                                                    formatoColumna:cmbFormatoColumna.getValue(),
                                                                                                                    textoPie:gEx('txtTextoPie').getValue(),
                                                                                                                    campoDepositoPie:cmbControlDisponible.getValue(),
                                                                                                                    complementario:objComp
                                                                                                                }
                                                                                                             )
                                                                            var objRegistro={};
                                                                            objRegistro.reg=regGrid;
                                                                            objRegistro.idElemento=idElemento;  
                                                                            objRegistro.nID=nID; 
                                                                            
                                                                            
                                                                                                       
                                                                            if(idElemento==-1) //Nuevo grid
                                                                            {
                                                                                
                                                                                switch(tipoCampoA+'')                                     
                                                                                {
                                                                                	case '8':
                                                                                    	var idCalculo=comboCampoLlave.getValue();
                                                                                        var pos=obtenerPosFila(comboCampoLlave.getStore(),'id',idCalculo);
                                                                                        var arrParam=comboCampoLlave.getStore().getAt(pos).get('valorComp');
                                                                                        if(arrParam=='')
	                                                                                        grid.getStore().add(regGrid);
                                                                                        else
                                                                                        {
                                                                                        	arrParam=eval(arrParam);
                                                                                            objRegistro.accion=1;
                                                                                            modificarParametrosEntrada2(arrParam,objRegistro);
                                                                                            
                                                                                        }
                                                                                    break;
                                                                                    default:
                                                                                    	grid.getStore().add(regGrid);
                                                                                    break;
                                                                                }
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                var idRegistroCampo='-1';
                                                                                if(fila!=null)
                                                                                    idRegistroCampo=fila.get('idRegistroCampo');
                                                                                 
                                                                                 if((fila==null)||(idRegistroCampo!='-1'))//Grid existente,nuevo fila
                                                                                 {
                                                                                     var cadObj='{"objComp":"'+bE(objComp)+'","idRegistroCampo":"'+idRegistroCampo+'","idElemento":"'+idElemento+'","idCampo":"'+txtCampoID.getValue()+'","cabecera":"'+cv(txtEncabezado.getValue())+'","ancho":"'+txtAncho.getValue()+'","tipoCampo":"'+comboTipoCampo.getValue()+
                                                                                                '","obligatorio":"'+comboSiNo.getValue()+'",'+'"tablaOriginalVinculada":"'+hTablaOriVinculada.getValue()+'","tablaVinculada":"'+hTablaUsrVinculada.getValue()+
                                                                                                '","campoVinculado":"'+cVinculado+'",'+'"campoUsrVinculado":"'+comboCampoVinculado.getRawValue()+'","campoLlave":"'+cLLave+
                                                                                                '","campoUsrLlave":"'+comboCampoLlave.getRawValue()+'","visible":"'+cmbVisibleSiNo.getValue()+'","orden":"'+(grid.getStore().getCount()+1)+'","param":"","formatoColumna":"'+
                                                                                                cmbFormatoColumna.getValue()+'","pieColumna":"'+cmbPieColumna.getValue()+'","textoPie":"'+cv(gEx('txtTextoPie').getValue())+'","campoDepositoPie":"'+cmbControlDisponible.getValue()+'"}';
                                                                                    var guardarDatos=true;
                                                                                    switch(tipoCampoA+'')                                     
                                                                                    {
                                                                                        case '8':
                                                                                            var idCalculo=comboCampoLlave.getValue();
                                                                                            var pos=obtenerPosFila(comboCampoLlave.getStore(),'id',idCalculo);
                                                                                            var arrParam=comboCampoLlave.getStore().getAt(pos).get('valorComp');
                                                                                            if(arrParam!='[]')
                                                                                            {
                                                                                            	guardarDatos=false;
                                                                                                arrParam=eval(arrParam);
                                                                                                objRegistro.accion=2;
                                                                                                objRegistro.reg.set('idRegistroCampo',idRegistroCampo);
                                                                                                modificarParametrosEntrada2(arrParam,objRegistro);
                                                                                                ventanaAM.close();
                                                                                            }
                                                                                        break;
                                                                                    }
                                                                                    if(guardarDatos)
                                                                                    {
                                                                                        function funcAjax()
                                                                                        {
                                                                                            var resp=peticion_http.responseText;
                                                                                            arrResp=resp.split('|');
                                                                                            if(arrResp[0]=='1')
                                                                                            {
                                                                                                if(fila==null)
                                                                                                {
                                                                                                	regGrid.set('idRegistroCampo',arrResp[1]);
                                                                                                    grid.getStore().add(regGrid);
                                                                                                }
                                                                                                else
                                                                                                {
                                                                                                	
                                                                                                    fila.set('idCampo',txtCampoID.getValue());
                                                                                                    fila.set('cabecera',txtEncabezado.getValue());
                                                                                                    fila.set('ancho',txtAncho.getValue());
                                                                                                    fila.set('tipoCampo',comboTipoCampo.getValue());
                                                                                                    fila.set('obligatorio',comboSiNo.getValue());
                                                                                                    fila.set('tablaOriginalVinculada',hTablaOriVinculada.getValue());
                                                                                                    fila.set('tablaVinculada',hTablaUsrVinculada.getValue());
                                                                                                    fila.set('campoVinculado',cVinculado);
                                                                                                    fila.set('campoUsrVinculado',comboCampoVinculado.getRawValue());
                                                                                                    fila.set('campoLlave',cLLave);
                                                                                                    fila.set('campoUsrLlave',comboCampoLlave.getRawValue());
                                                                                                    fila.set('visible',cmbVisibleSiNo.getValue());
                                                                                                    fila.set('param','');
                                                                                                    fila.set('formatoColumna',cmbFormatoColumna.getValue());
                                                                                                    fila.set('pieColumna',cmbPieColumna.getValue());
                                                                                                    fila.set('textoPie',gEx('txtTextoPie').getValue());
                                                                                                    fila.set('campoDepositoPie',cmbControlDisponible.getValue());
                                                                                                    fila.set('complementario',objComp);
                                                                                                     
                                                                                                }
                                                                                                
                                                                                                var cadObj=obtenerConfColumnasCamposGrid(iE,nID);
                                                                                                var divGrid=h.gE('div_'+iE);
                                                                                                var idFormulario=gE('idFormulario').value;
                                                                                                if(divGrid!=null)
                                                                                                {
                                                                                                    var gridAux=h.gEx('grid_'+iE);
                                                                                                    posX=divGrid.style.left.replace('px','');
                                                                                                    posY=divGrid.style.top.replace('px','');
                                                                                                    
                                                                                                    cadObj='{"ajustarPosicion":"0","ancho":"'+gridAux.getWidth()+'","alto":"'+gridAux.getHeight()+'","posX":"'+posX+'","posY":"'+posY+'","idFormulario":"'+idFormulario+'","nID":"'+nID+'","arrCampos":['+cadObj+']}';
                                                                                                }
                                                                                                divGrid.parentNode.removeChild(divGrid);
                                                                                                ventanaAM.close();
                                                                                                crearControlGridFormulario(cadObj,iE,'_'+nID);
                                                                                                
                                                                                            }
                                                                                            else
                                                                                            {
                                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                            }
                                                                                        }
                                                                                        obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=58&cadObj='+cadObj,true);
                                                                                 	}
                                                                                }
                                                                                else  //Grid existente; registro existente
                                                                                {
                                                                                
                                                                                	var actualizarDatos=true;
                                                                                	switch(tipoCampoA+'')                                     
                                                                                    {
                                                                                        case '8':
                                                                                            var idCalculo=comboCampoLlave.getValue();
                                                                                            var pos=obtenerPosFila(comboCampoLlave.getStore(),'id',idCalculo);
                                                                                            var arrParam=comboCampoLlave.getStore().getAt(pos).get('valorComp');
                                                                                            if(arrParam=='')
                                                                                                grid.getStore().add(regGrid);
                                                                                            else
                                                                                            {
                                                                                            	actualizarDatos=false;
                                                                                                arrParam=eval(arrParam);
                                                                                                objRegistro.accion=3;
                                                                                                modificarParametrosEntrada2(arrParam,objRegistro);
                                                                                                
                                                                                            }
                                                                                        break;
                                                                                        default:
                                                                                            grid.getStore().add(regGrid);
                                                                                        break;
                                                                                    }
                                                                                    if(actualizarDatos)
                                                                                    {
                                                                                        fila.set('idCampo',txtCampoID.getValue());
                                                                                        fila.set('cabecera',txtEncabezado.getValue());
                                                                                        fila.set('ancho',txtAncho.getValue());
                                                                                        fila.set('tipoCampo',comboTipoCampo.getValue());
                                                                                        fila.set('obligatorio',comboSiNo.getValue());
                                                                                        fila.set('tablaOriginalVinculada',hTablaOriVinculada.getValue());
                                                                                        fila.set('tablaVinculada',hTablaUsrVinculada.getValue());
                                                                                        fila.set('campoVinculado',cVinculado);
                                                                                        fila.set('campoUsrVinculado',comboCampoVinculado.getRawValue());
                                                                                        fila.set('campoLlave',cLLave);
                                                                                        fila.set('campoUsrLlave',comboCampoLlave.getRawValue());
                                                                                        fila.set('visible',cmbVisibleSiNo.getValue());
                                                                                        fila.set('param','');
                                                                                        fila.set('formatoColumna',cmbFormatoColumna.getValue());
                                                                                        fila.set('pieColumna',cmbPieColumna.getValue());
                                                                                        fila.set('textoPie',gEx('txtTextoPie').getValue());
                                                                                        fila.set('campoDepositoPie',cmbControlDisponible.getValue());
                                                                                        fila.set('complementario',objComp);
                                                                                    }
                                                                                    ventanaAM.close();
                                                                                    
                                                                                }
                                                                            }
                                                                            
                                                                            
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
	if(fila!=null)                                
    {
    	var txtCampoID=gEx('txtCampoID');
        txtCampoID.setValue(fila.get('idCampo'));
        var txtEncabezado=gEx('txtEncabezado');
        txtEncabezado.setValue(fila.get('cabecera'));
        var txtAncho=gEx('txtAncho');
        txtAncho.setValue(fila.get('ancho'));
        cmbVisibleSiNo.setValue(fila.get('visible'));
        var comboTipoCampo=gEx('comboTipoCampo');
        comboTipoCampo.setValue(fila.get('tipoCampo'));
        dispararEventoSelectCombo('comboTipoCampo');
      
        comboSiNo.setValue(fila.get('obligatorio'));
        cmbFormatoColumna.setValue(fila.get('formatoColumna'));
        cmbPieColumna.setValue(fila.get('pieColumna'));
        gEx('txtTextoPie').setValue(fila.get('textoPie'));
        if(fila.get('pieColumna')=='6')
        	gEx('txtTextoPie').enable();
        cmbControlDisponible.setValue(fila.get('campoDepositoPie'))

        switch(fila.get('tipoCampo'))
        {
        	
        	case '4':
                gEx('lblTablaVinculada').setText(fila.get('tablaVinculada')+' '+lblBtnModificar,false);

                function funcResp()
                {
                    var arrResp=peticion_http.responseText.split('|');
                    if(arrResp[0]=='1')
                    {
                            var arrTablas=eval(arrResp[1]);
                            var arrTablasCmb=eval(arrResp[2]);
                            Ext.getCmp('comboCampoVinculado').getStore().loadData(arrTablasCmb);
                            Ext.getCmp('comboCampoVinculado').enable();
                            Ext.getCmp('comboCampoLlave').getStore().loadData(arrTablasCmb);
                            Ext.getCmp('comboCampoLlave').enable();
                            var hTablaUsrVinculada=gEx('hTablaUsrVinculada');
                            hTablaUsrVinculada.setValue(fila.get('tablaVinculada'));
                            var hTablaOriVinculada=gEx('hTablaOriVinculada');
                            hTablaOriVinculada.setValue(fila.get('tablaOriginalVinculada'));
                            var comboCampoVinculado=gEx('comboCampoVinculado');
                            comboCampoVinculado.setValue(fila.get('campoVinculado'));
                            var comboCampoLlave=gEx('comboCampoLlave');
                            comboCampoLlave.setValue(fila.get('campoLlave'));
                            ventanaSelTabla.close();
                    }
                    else
                    {
                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                    }
                }
                obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcResp, 'POST','funcion=13&nomTabla='+fila.get('tablaOriginalVinculada'),true);
			break;  
            case '10':
            	gEx('lblTablaVinculada').hide();
                comboAlmacenes.show();
                comboAlmacenes.setValue(fila.get('tablaOriginalVinculada'));
				var arrCampo=obtenerCamposDisponibles(fila.get('tablaOriginalVinculada'));
                gEx('etTablaV').setText('Almac&eacute;n vinculado:',false);
                dispararEventoSelectCombo('comboAlmacenes');
                var pos=existeValorMatriz(arrCampo,fila.get('campoUsrVinculado'),1);
                
                comboCampoVinculado.setValue(arrCampo[pos][0]);
                pos=existeValorMatriz(arrCampo,fila.get('campoUsrLlave'),1);
                comboCampoLlave.setValue(arrCampo[pos][0]);
            break;
            case '12':
            	if(fila.get('complementario')=='')
                	fila.set('complementario','{"tamMaxArchivo":"1","unidadTamMaximo":"GB","extensionesPermitidas":"*.*"}');
            	var oConf=eval('['+fila.get('complementario')+']')[0];
            	gEx('txtTamMax').setValue(oConf.tamMaxArchivo);
                gEx('cmbUnidad').setValue(oConf.unidadTamMaximo);
                gEx('txtExtensiones').setValue(oConf.extensionesPermitidas);
            break; 
            default:
            	var hTablaUsrVinculada=gEx('hTablaUsrVinculada');
                hTablaUsrVinculada.setValue(fila.get('tablaVinculada'));
                var hTablaOriVinculada=gEx('hTablaOriVinculada');
                hTablaOriVinculada.setValue(fila.get('tablaOriginalVinculada'));
                var comboCampoVinculado=gEx('comboCampoVinculado');
                comboCampoVinculado.setValue(fila.get('campoVinculado'));
                var comboCampoLlave=gEx('comboCampoLlave');
                comboCampoLlave.setValue(fila.get('campoLlave'));
            break;          
        }
    }
		
}

function mostrarVentanaTablasCampoGrid()
{
	 
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
                                                        new  Ext.grid.RowNumberer(),
                                                        {
                                                            header:'Tabla',
                                                            width:250,
                                                            dataIndex:'tabla',
                                                            sortable:true
                                                        },
                                                        {
                                                        	header:'Tipo',
                                                            width:150,
                                                            sortable:true,
                                                            dataIndex:'tipoTabla'
                                                        },
                                                        {
                                                        	header:'Proceso',
                                                            width:200,
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
                                                            width:700,
                                                            plugins: filters
                                                            
                                                        }
                                                    );
    
    panelGrid=new Ext.Panel	(
                                {
                                    y:10,
                                    width:700,
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
                                        id:'btnFinalizar',
                                        listeners:	{
                                                        click:
                                                                {
                                                                    fn:function()
                                                                    {
                                                                        var filaSel= tblOpciones.getSelectionModel().getSelected();
                                                                        if(filaSel==null)
                                                                        {
                                                                        	msgBox('Debe seleccionar la tabla con la cual se vincular&aacute; el campo del grid');
                                                                        	return;
                                                                        }
                                                                        var nomTabla=filaSel.get('nomTablaOriginal');
                                                                        var tablaUsr=filaSel.get('tabla');
                                                                        
                                                                        gEx('lblTablaVinculada').setText(tablaUsr+' <a href="javascript:mostrarVentanaTablasCampoGrid()"><img width="13" heigth="13" src="../images/pencil.png" title="Vincular con tabla" alt="Vincular con tabla"></a>',false);
                                                                        gEx('hTablaUsrVinculada').setValue(tablaUsr);
                                                                        gEx('hTablaOriVinculada').setValue(nomTabla);

                                                                        
                                                                        function funcResp()
                                                                        {
                                                                            var arrResp=peticion_http.responseText.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                                    var arrTablas=eval(arrResp[1]);
                                                                                    var arrTablasCmb=eval(arrResp[2]);
                                                                                    Ext.getCmp('comboCampoVinculado').getStore().loadData(arrTablasCmb);
                                                                                    Ext.getCmp('comboCampoVinculado').enable();
                                                                                    Ext.getCmp('comboCampoLlave').getStore().loadData(arrTablasCmb);
                                                                                    Ext.getCmp('comboCampoLlave').enable();
                                                                                    ventanaSelTabla.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcResp, 'POST','funcion=13&nomTabla='+nomTabla,true);
                                                                        
                                                                        
                                                                        
                                                                    }
                                                                }
                                                    }
                                    }
                                )
    
    ventanaSelTabla = new Ext.Window(
                                            {
                                                title: 'Seleccione la tabla en la cual se basar&aacute; su consulta',
                                                width: 730 ,
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
                                                                btnSiguiente,
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
                                            		funcion:46,
                                                    idConexion:0
                                        		}	
                                    }
                               );                                        	
	ventanaSelTabla.show();	
}

function validarDatosColumna()
{
	var txtCampoID=gEx('txtCampoID');
    var txtEncabezado=gEx('txtEncabezado');
    var txtAncho=gEx('txtAncho');
    var comboTipoCampo=gEx('comboTipoCampo');
    var hTablaUsrVinculada=gEx('hTablaUsrVinculada');
    var comboCampoVinculado=gEx('comboCampoVinculado');
    var comboCampoLlave=gEx('comboCampoLlave');
    var comboAlmacenes=gEx('comboAlmacenes');
    if(txtCampoID.getValue()=='')
    {
    	function funcRespID()
        {
        	txtCampoID.focus();
        }
    	msgBox('El ID del campo es obligatorio',funcRespID);
        return false;
    }
    
    if(txtEncabezado.getValue()=='')
    {
    	function funcRespEncabezado()
        {
        	txtEncabezado.focus();
        }
    	msgBox('El encabezado de la columna es obligatoria',funcRespEncabezado);
        return false;
    }
    
    if(txtAncho.getRawValue()=='')
    {
    	function funcRespAncho()
        {
        	txtAncho.focus();
        }
    	msgBox('El ancho de la columna es obligatorio',funcRespAncho);
        return false;
    }
    
    if(comboTipoCampo.getValue()=='')
    {
    	function funcRespTipoCol()
        {
        	comboTipoCampo.focus();
        }
    	msgBox('Debe indicar el tipo de columna',funcRespTipoCol);
        return false;
    }
    
    if((comboTipoCampo.getValue()=='4')||(comboTipoCampo.getValue()=='10'))
    {
    	if(comboTipoCampo.getValue()=='4')
        {
            if(hTablaUsrVinculada.getValue()=='')
            {
                function funcRespTablaUsr()
                {
                    
                }
                msgBox('Debe indicar la tabla con la cual se vincula la columna',funcRespTablaUsr);
                return false;
            }
		}
            
        if(comboTipoCampo.getValue()=='10')
        {
            if(comboAlmacenes.getValue()=='')
            {
                function funcRespTablaUsr2()
                {
                    comboAlmacenes
                }
                msgBox('Debe indicar el almac&eacute;n de datos con el cual se vincular&aacute; la columna',funcRespTablaUsr2);
                return false;
            }
		}
            
        if(comboCampoVinculado.getValue()=='')
        {
        	function funcCampoVinculado()
            {
            	comboCampoVinculado.focus();
            }
            msgBox('Debe indicar el campo con el cual se vincular&aacute; la columna',funcCampoVinculado);
        	return false;
        }
        
        if(comboCampoLlave.getValue()=='')
        {
        	function funcCampoLlave()
            {
            	comboCampoLlave.focus();
            }
            msgBox('Debe indicar el campo llave con el cual se vincular&aacute; la columna',funcCampoLlave);
        	return false;
        }
	}
    return true;
}

function crearControlGridFormulario(cadObj,idElem,nControl)
{
	h.idElemento=idElem;
	var obj=eval('['+cadObj+']')[0];
    var arrObjCampos=obj.arrCampos;
    var x;
    var asterisco;
    var fila;
    var oculto;
    var arrCampos=new Array();
    var arrCabeceras=new Array();
    for (x=0;x<arrObjCampos.length;x++)
    {
        asterisco="";
        fila=arrObjCampos[x];
        
        if(fila.obligatorio=="1")
            asterisco=' <font color="red">*</font>';
        oculto=false;
        if(fila.visible=="0")
        {
            oculto=true;
            asterisco="";
        }
        arrCampos.push({name:fila.idCampo});
        arrCabeceras.push({
                                            header:decodeURIComponent(fila.cabecera+asterisco),
                                            width:parseInt(fila.ancho),
                                            sortable:true,
                                            dataIndex:fila.idCampo,
                                            hidden:oculto
                        });
        
            
    }
    
    var arrEliminar=document.createElement('div');
    var arrElem=new Array();
    var span1=cE('span');
    span1.id='contenedorSpanGrid_'+idElem;
    span1.setAttribute('permiteModificar','1');
    span1.setAttribute('permiteEliminar','1');
    span1.setAttribute('val','');
    var span2=cE('span');
    span2.id='spanGrid_'+idElem;
	span1.appendChild(span2);
    arrElem.push(span1);
    var arrContenido=new Array();
    arrContenido[0]=arrElem;
    arrContenido[1]=arrEliminar;
    arrContenido[2]=null;
    arrContenido[3]=idElem;
    arrContenido[4]='_pGrid';
    arrContenido[5]='29';
    var ancho=560;
    var alto=300;
    arrContenido[6]=null;
    arrContenido[7]=obj.posX;
    arrContenido[8]=obj.posY;
    arrContenido[9]=arrCabeceras;
    arrContenido[10]=arrObjCampos;
    arrContenido[11]=ancho;
    arrContenido[12]=alto;
    arrContenido[13]=obj.ajustarPosicion;
    if(typeof(obj.ancho)!='undefined')
        arrContenido[11]=obj.ancho;
    if(typeof(obj.alto)!='undefined')
        arrContenido[12]=obj.alto;
    h.tipoElemento='29';
    h.insertarControl(arrContenido);
}

function modificarParametrosEntrada2(arregloC,objRegistro)
{
    var gridParametros=crearGridParametros2(arregloC);
   
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														gridParametros	
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Modificaci&oacute;n de parametros de entrada',
										width: 620,
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
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
                                                                    	var filaVacia=validarCampoNoVacio(gridParametros.getStore(),'valor');
																		if(filaVacia==-1)
                                                                        {
                                                                        	var x;
                                                                            var arrP=new Array();
                                                                            var obj;
                                                                            var fila;
                                                                            var comp='';
                                                                            var cadParam;
                                                                            var arrParam='';
                                                                            for(x=0;x<gridParametros.getStore().getCount();x++)
                                                                            {
                                                                            	fila=gridParametros.getStore().getAt(x);
                                                                            	obj=new Array();
                                                                                cadParam='{"parametro":"'+fila.get('parametro')+'","valor":"'+fila.get('asigna')+'","tipoValor":"'+fila.get('tipoParam')+'","valorSistema":"'+fila.get('valorSistema')+'"}';
                                                                                if(arrParam=='')
                                                                                	arrParam=cadParam;
                                                                                else
                                                                                	arrParam+=','+cadParam;    
                                                                            }
                                                                            arrParam='['+arrParam+']';
                                                                            objRegistro.reg.set('param',arrParam)
                                                                            var cadObj='{"idRegistroCampo":"'+objRegistro.reg.get('idRegistroCampo')+'","idElemento":"'+objRegistro.idElemento+'","idCampo":"'+objRegistro.reg.get('idCampo')+'","cabecera":"'+cv(objRegistro.reg.get('cabecera'))+'","ancho":"'+objRegistro.reg.get('ancho')+'","tipoCampo":"'+objRegistro.reg.get('tipoCampo')+
                                                                                                '","obligatorio":"'+objRegistro.reg.get('obligatorio')+'",'+'"tablaOriginalVinculada":"'+objRegistro.reg.get('tablaOriginalVinculada')+'","tablaVinculada":"'+objRegistro.reg.get('tablaVinculada')+
                                                                                                '","campoVinculado":"'+objRegistro.reg.get('campoVinculado')+'",'+'"campoUsrVinculado":"'+objRegistro.reg.get('campoUsrVinculado')+'","campoLlave":"'+objRegistro.reg.get('campoLlave')+
                                                                                                '","campoUsrLlave":"'+objRegistro.reg.get('campoUsrLlave')+'","visible":"'+objRegistro.reg.get('visible')+'","orden":"'+objRegistro.reg.get('orden')+'","param":"'+bE(arrParam)+'","formatoColumna":"'+objRegistro.reg.get('formatoColumna')+'","pieColumna":"'+objRegistro.reg.get('pieColumna')+
                                                                                                '","textoPie":"'+objRegistro.reg.get('textoPie')+'","campoDepositoPie":"'+objRegistro.reg.get('campoDepositoPie')+'"}';
                                                                            
                                                                            switch(objRegistro.accion)
                                                                            {
                                                                            	case 1://Nuevo grid
                                                                              		gEx('gridCampoGrid').getStore().add(objRegistro.reg);  
                                                                              		ventanaAM.close();  
                                                                                break;
                                                                                case 2://Grid existente nueva fila
                                                                                	function funcAjaxAux()
                                                                                    {
                                                                                        var resp=peticion_http.responseText;
                                                                                        arrResp=resp.split('|');
                                                                                        var iE=objRegistro.idElemento;
                                                                                        if(arrResp[0]=='1')
                                                                                        {
                                                                                        	if(objRegistro.reg.get('idRegistroCampo')=='-1')
                                                                                            {
                                                                                                objRegistro.reg.set('idRegistroCampo',arrResp[1]);
                                                                                                gEx('gridCampoGrid').getStore().add(objRegistro.reg);  
                                                                                            }
                                                                                            else
                                                                                            {
                                                                                            	var filaDest=gEx('gridCampoGrid').getSelectionModel().getSelected();
                                                                                                filaDest.set('idCampo',objRegistro.reg.get('idCampo'));
                                                                                                filaDest.set('cabecera',objRegistro.reg.get('cabecera'));
                                                                                                filaDest.set('ancho',objRegistro.reg.get('ancho'));
                                                                                                filaDest.set('tipoCampo',objRegistro.reg.get('tipoCampo'));
                                                                                                filaDest.set('obligatorio',objRegistro.reg.get('obligatorio'));
                                                                                                filaDest.set('tablaVinculada',objRegistro.reg.get('tablaVinculada'));
                                                                                                filaDest.set('tablaOriginalVinculada',objRegistro.reg.get('tablaOriginalVinculada'));
                                                                                                filaDest.set('campoVinculado',objRegistro.reg.get('campoVinculado'));
                                                                                                filaDest.set('campoUsrVinculado',objRegistro.reg.get('campoUsrVinculado'));
                                                                                                filaDest.set('campoUsrLlave',objRegistro.reg.get('campoUsrLlave'));
                                                                                                filaDest.set('campoLlave',objRegistro.reg.get('campoLlave'));
                                                                                                filaDest.set('visible',objRegistro.reg.get('visible'));
                                                                                                filaDest.set('orden',objRegistro.reg.get('orden'));
                                                                                                filaDest.set('param',objRegistro.reg.get('param'));
                                                                                                filaDest.set('formatoColumna',objRegistro.reg.get('formatoColumna'));
                                                                                                filaDest.set('pieColumna',objRegistro.reg.get('pieColumna'));
                                                                                                filaDest.set('textoPie',objRegistro.reg.get('textoPie'));
                                                                                                filaDest.set('campoDepositoPie',objRegistro.reg.get('campoDepositoPie'));
                                                                                                
                                                                                            }
                                                                                            
                                                                                            var cadObj=obtenerConfColumnasCamposGrid(iE,objRegistro.nID);
                                                                                            var divGrid=h.gE('div_'+iE);
                                                                                            var idFormulario=gE('idFormulario').value;
                                                                                            if(divGrid!=null)
                                                                                            {
                                                                                                var gridAux=h.gEx('grid_'+iE);
                                                                                                posX=divGrid.style.left.replace('px','');
                                                                                                posY=divGrid.style.top.replace('px','');
                                                                                                cadObj='{"ajustarPosicion":"0","ancho":"'+gridAux.getWidth()+'","alto":"'+gridAux.getHeight()+'","posX":"'+posX+'","posY":"'+posY+'","idFormulario":"'+idFormulario+'","nID":"'+objRegistro.nID+'","arrCampos":['+cadObj+']}';
                                                                                            }
                                                                                            divGrid.parentNode.removeChild(divGrid);
                                                                                            ventanaAM.close();
                                                                                            crearControlGridFormulario(cadObj,iE,'_'+objRegistro.nID);
                                                                                        }
                                                                                        else
                                                                                        {
                                                                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                        }
                                                                                    }
                                                                                    obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjaxAux, 'POST','funcion=58&cadObj='+cadObj,true);
                                                                                	 
                                                                                break;
                                                                                case 3: //Grid y fila existente 
                                                                                	var filaDest=gEx('gridCampoGrid').getSelectionModel().getSelected();
                                                                                    filaDest.set('idCampo',objRegistro.reg.get('idCampo'));
                                                                                    filaDest.set('cabecera',objRegistro.reg.get('cabecera'));
                                                                                    filaDest.set('ancho',objRegistro.reg.get('ancho'));
                                                                                    filaDest.set('tipoCampo',objRegistro.reg.get('tipoCampo'));
                                                                                    filaDest.set('obligatorio',objRegistro.reg.get('obligatorio'));
                                                                                    filaDest.set('tablaVinculada',objRegistro.reg.get('tablaVinculada'));
                                                                                    filaDest.set('tablaOriginalVinculada',objRegistro.reg.get('tablaOriginalVinculada'));
                                                                                    filaDest.set('campoVinculado',objRegistro.reg.get('campoVinculado'));
                                                                                    filaDest.set('campoUsrVinculado',objRegistro.reg.get('campoUsrVinculado'));
                                                                                    filaDest.set('campoUsrLlave',objRegistro.reg.get('campoUsrLlave'));
                                                                                    filaDest.set('campoLlave',objRegistro.reg.get('campoLlave'));
                                                                                    filaDest.set('visible',objRegistro.reg.get('visible'));
                                                                                    filaDest.set('orden',objRegistro.reg.get('orden'));
                                                                                    filaDest.set('param',objRegistro.reg.get('param'));
                                                                                    filaDest.set('formatoColumna',objRegistro.reg.get('formatoColumna'));
                                                                                    filaDest.set('pieColumna',objRegistro.reg.get('pieColumna'));
                                                                                    filaDest.set('textoPie',objRegistro.reg.get('textoPie'));
                                                                                    filaDest.set('campoDepositoPie',objRegistro.reg.get('campoDepositoPie'));
                                                                                	/*function funcAjax3()
                                                                                    {
                                                                                        var resp=peticion_http.responseText;
                                                                                        arrResp=resp.split('|');
                                                                                        var iE=objRegistro.idElemento;
                                                                                        if(arrResp[0]=='1')
                                                                                        {
                                                                                        	
                                                                                            var cadObj=obtenerConfColumnasCamposGrid(iE,objRegistro.nID);
                                                                                            var divGrid=h.gE('div_'+iE);
                                                                                            var idFormulario=gE('idFormulario').value;
                                                                                            if(divGrid!=null)
                                                                                            {
                                                                                                var gridAux=h.gEx('grid_'+iE);
                                                                                                posX=divGrid.style.left.replace('px','');
                                                                                                posY=divGrid.style.top.replace('px','');
                                                                                                cadObj='{"ajustarPosicion":"0","ancho":"'+gridAux.getWidth()+'","alto":"'+gridAux.getHeight()+'","posX":"'+posX+'","posY":"'+posY+'","idFormulario":"'+idFormulario+'","nID":"'+objRegistro.nID+'","arrCampos":['+cadObj+']}';
                                                                                            }
                                                                                            divGrid.parentNode.removeChild(divGrid);
                                                                                            ventanaAM.close();
                                                                                            crearControlGridFormulario(cadObj,iE,'_'+objRegistro.nID);
                                                                                        }
                                                                                        else
                                                                                        {
                                                                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                        }
                                                                                    }
                                                                                    obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax3, 'POST','funcion=58&cadObj='+cadObj,true);
                                                                                	*/
                                                                                break;
                                                                            }
                                                                            
                                                                            	
                                                                        }
                                                                        else	
                                                                        	msgBox('Algunos valores de par&aacute;metros no han sido especificados');
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

function crearGridParametros2(arregloC)
{
    var arrTipoEntrada=[['7','Consulta auxiliar'],['17','Par\xE1metro de c\xE1lculo'],['1','Valor Constante'],['3','Valor de sesi\xF3n'],['4','Valor de sistema'],['21','Valor de variable acumuladora']];
	var cmbTipoEntrada=crearComboExt('cmbTipoEntrada',arrTipoEntrada);
    var dsDatos=arregloC;
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'parametro'},
                                                                    {name: 'asigna'},
                                                                    {name: 'tipoParam'},
                                                                    {name: 'valorSistema'}

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
														}
                                                        ,
                                                        {
                                                        	header:'Valor',
															width:200,
															sortable:true,
                                                            dataIndex:'asigna',
                                                            renderer:function(val,ambito,registro,nFila)
                                                            		{
																		var idTipoC=registro.get('idTipoValor');
                                                                        var idParam=registro.get('idParametro');
                                                                        return val+' <a href="javascript:mostrarVentana(\''+bE(nFila)+'\')"><img height="16" width="16" src="../images/pencil.png" alt="Modificar" title="Modificar" /></a>'; 
                                                                    }
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
                                                            width:590,
                                                            id:'gParametros12'
                                                        }
                                                    );
	                                            
	return 	tblGrid;	
}

function mostrarVentana(nFila)
{
	var arrTipoEntrada=[['7','Consulta auxiliar'],['16','Par\xE1metro de proceso'],['11','Valor de almac\xE9n'],['25','Valor de control'],['24','Valor de celda Grid'],['1','Valor constante'],['3','Valor de sesi\xF3n'],['4','Valor de sistema']];
    var cmbTipoValor=crearComboExt('cmbTipoValor',arrTipoEntrada,180,5);
    cmbTipoValor.setValue('1');
    cmbTipoValor.on('select',funcTipoEntradaChangeParamCal);
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
                                                                    	if(cmbTipoValor.getValue()=='')
                                                                        {
                                                                        	msgBox('Debe seleccionar el tipo de entrada al que pertenece el valor a asignar');
                                                                        	return;
                                                                        }
                                                                        var valorUsr;
                                                                        var valor;
                                                                        var valorSistema='';
                                                                        switch(cmbTipoValor.getValue())
                                                                        {
                                                                        	case '1':
                                                                            	valor=gEx('txtValorConstante').getValue();
                                                                                valorUsr=valor;
                                                                                valorSistema=valor;
                                                                            break;
                                                                            case '11':
                                                                            case '7':
                                                                            	if(cmbCampoParametro.getValue()=='')
                                                                                {
                                                                                	msgBox('Debe seleccionar el campo que desea asignar como par&aacute;metro');
                                                                                	return;
                                                                                }
                                                                                if(cmbTipoValor.getValue()=='7')
	                                                                                valorSistema=cmbAlmacen.getValue();
                                                                                else
                                                                                {
                                                                                	var idCampo=cmbCampoParametro.getValue();
                                                                                    var nodo=buscarNodoID(gEx('arbolDataSet').getRootNode(),idCampo);
                                                                                	valorSistema=cmbAlmacen.getValue()+'|'+nodo.nCampo;
                                                                                }
                                                                                valorUsr=cmbCampoParametro.getRawValue();
                                                                            break;
                                                                            default:
                                                                            	if(cmbValor.getValue()=='')
                                                                                {
                                                                                	msgBox('Debe seleccionar el valor que desea asignar');
                                                                                	return;
                                                                                }
                                                                                valorSistema=cmbValor.getValue();
                                                                                valorUsr=cmbValor.getRawValue();
                                                                            break;
                                                                        }            
                                                                        var fila=gEx('gParametros12').getStore().getAt(bD(nFila));
                                                                        var tipo=cmbTipoValor.getValue();
                                                                        if(tipo=='1')
                                                                            fila.set('asigna',''+valorUsr);
                                                                        else
                                                                            fila.set('asigna','['+valorUsr+']');
                                                                       fila.set('tipoParam',cmbTipoValor.getValue());
                                                                       fila.set('valorSistema',valorSistema);
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

function funcTipoEntradaChangeParamCal(combo,registro)
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
	switch(registro.get('id'))
    {
    	case '0':
        	cmbValor.getStore().loadData(arrCamposTablas);
            cmbValor.show();
            lblValorAsigna.show();
        break;
    	case '1':
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
        	var arrAlmacenes=obtenerAlmacenesDatosDisponibles('2');
            cmbAlmacen.reset();
            cmbAlmacen.getStore().loadData(arrAlmacenes);
        	cmbAlmacen.show();
            lblAlmacen.show();
            lblCampo.show();
            cmbCampo.show();
            cmbCampo.reset();
        break;
        case '11':
        	var arrAlmacenes=obtenerAlmacenesDatosDisponibles('1');
            cmbAlmacen.reset();
            cmbAlmacen.getStore().loadData(arrAlmacenes);
        	cmbAlmacen.show();
            lblAlmacen.show();
            lblCampo.show();
            cmbCampo.show();
            cmbCampo.reset();
            cmbCampo.setRawValue('');
        break;
        case '16':
        	cmbValor.getStore().loadData(arrProceso);
        	cmbValor.show();
            lblValorAsigna.show();
        break;
        case '24':
        	var gridCampoGrid=gEx('gridCampoGrid');
            var filaSel=gridCampoGrid.getSelectionModel().getSelected();
            var arrColumnas=new Array();
            var x;
            var fila;
            var obj;
            for(x=0;x<gridCampoGrid.getStore().getCount();x++)
            {
            	fila=gridCampoGrid.getStore().getAt(x);
                if((filaSel==null)||(filaSel.get('idCampo')!=fila.get('idCampo')))
                {
                    obj=new Array();
                    obj[0]=fila.get('idCampo');
                    obj[1]=fila.get('idCampo');
                    arrColumnas.push(obj);
				}
            }
            
        	cmbValor.getStore().loadData(arrColumnas);
        	cmbValor.show();
            lblValorAsigna.show();
        break;
        case '25':
        	cmbValor.getStore().loadData(arrControles25);
        	cmbValor.show();
            lblValorAsigna.show();
        break;
        
    }
}

function modificarConfiguracionOrigenDatosGrid(iE)
{

	var cadObjConf=bD(h.gE('contenedorSpanGrid_'+iE).getAttribute('origenDatos'));

	var cmbAlmacenDatos=crearComboExt('cmbAlmacenDatos',[],160,35,250);
    cmbAlmacenDatos.on('select',function(combo,registro)
    							{
                                	limpiarGridOrigenDatos();
                                	var arrCampos=obtenerCamposDisponibles(registro.get('id'),true);
                                    arrCampos.splice(0,0,['','No asociado']);
                                    gEx('cmbEditor').getStore().loadData(arrCampos);
                                }
    				)
	cmbAlmacenDatos.hide();                    
	var arrTipoOrigenDatos=[['0','Ninguno'],['1','Almac\xE9n de datos'],['2','Funci\xF3n de sistema']];
    var cmbTipoOrigenDatos=crearComboExt('cmbTipoOrigenDatos',arrTipoOrigenDatos,160,5,250);
    cmbTipoOrigenDatos.setValue('0');
    cmbTipoOrigenDatos.on('select',function(combo,registro)
    								{
                                    	
                                        var txtEditor=gEx('txtEditor');
                                    	limpiarGridOrigenDatos();
                                        gEx('lblFuncion').hide();
                                        gEx('txtFuncion').hide();
                                        gEx('lblAlmacen').hide();
                                        gEx('lblAsignarFuncionOrigen').hide();
                                        cmbAlmacenDatos.hide();
                                        switch(registro.get('id'))
                                        {
                                        	case '0':
                                            	gEx('gridOrigenDatos').disable();
                                            break;
                                            case '1':
                                            	var cmbEditor=crearComboExt('cmbEditor',[],0,0);

                                            	gEx('gridOrigenDatos').enable();
                                                var arrAlmacenes=obtenerAlmacenesDatosDisponibles(1);
                                                cmbAlmacenDatos.reset();
                                                cmbAlmacenDatos.setRawValue('');
                                                cmbAlmacenDatos.getStore().loadData(arrAlmacenes);
                                                gEx('gridOrigenDatos').getColumnModel().config[2].setEditor(cmbEditor);
                                                gEx('lblAlmacen').show();
                                                cmbAlmacenDatos.show();
                                                gEx('lblFuncion').hide();
                                                gEx('txtFuncion').hide();
                                            break;
                                            case '2':
                                                var txtEditor=new Ext.form.TextField	(
                                                                                            {
                                                                                                id:'txtEditor',
                                                                                                enableKeyEvents :true,
                                                                                                maskRe:/^[_a-zA-Z0-9]$/
                                                                                            }
                                                                                        )
                                            	gEx('gridOrigenDatos').enable();
                                                gEx('gridOrigenDatos').getColumnModel().config[2].setEditor(txtEditor);
                                                gEx('lblAlmacen').hide();
                                                cmbAlmacenDatos.hide();
                                                gEx('lblFuncion').show();
                                                gEx('txtFuncion').show();
                                                gEx('lblAsignarFuncionOrigen').show();
                                            break;
                                        }
                                    }
    					)
                        
                        
    var gridOrigenDatos=crearGridOrigenDatos();
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:'Tipo de origen de datos:'
                                                        },
                                                        cmbTipoOrigenDatos,
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            hidden:true,
                                                            id:'lblAlmacen',
                                                            html:'Almac&eacute;n de datos:'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:40,
                                                             hidden:true,
                                                            id:'lblFuncion',
                                                            html:'Funci&oacute;n a asignar:'
                                                        },
                                                        cmbAlmacenDatos,
                                                        {
                                                        	x:160,
                                                            y:35,
                                                            id:'txtFuncion',
                                                            xtype:'textfield',
                                                            readOnly:true,
                                                            hidden:true,
                                                            width:250
                                                        },
                                                        {
                                                        	x:430,
                                                            y:35,
                                                            hidden:true,
                                                            id:'lblAsignarFuncionOrigen',
                                                            html:'<a href="javascript:mostrarVentanaFuncionOrigenGrid()"><img src="../images/pencil.png"></a>'
                                                        },
                                                        gridOrigenDatos

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Configurar origen de datos',
										width: 610,
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
																		var idOrigenDatos=cmbTipoOrigenDatos.getValue();
                                                                        var cadOrigen='{"tipoOrigenDatos":"'+idOrigenDatos+'"';
                                                                        switch(idOrigenDatos)
                                                                        {
                                                                        	case '0':
                                                                            break;
                                                                            case '1':
                                                                            	if(cmbAlmacenDatos.getValue()=='')
                                                                                {
                                                                                	msgBox('Debe indicar el almac&eacute;n de datos a utilizar como origen de datos')
                                                                                	return;
                                                                                }
                                                                                cadOrigen+=',"idOrigenDatos":"'+cmbAlmacenDatos.getValue()+'"'
                                                                            break;
                                                                            case '2':
                                                                            	var txtFuncion=gEx('txtFuncion');
                                                                            	if(txtFuncion.getValue()=='')
                                                                                {
                                                                                	msgBox('Debe indicar la funci&oacute;n a utilizar como origen de datos')
                                                                                	return;
                                                                                }
                                                                                cadOrigen+=',"idOrigenDatos":"'+txtFuncion.idFuncion+'"'
                                                                            break;
                                                                        }
                                                                        var x;
                                                                        var f;
                                                                        var cadCampo='';
                                                                        var oCampo='';
                                                                        var pEditar='';
                                                                        for(x=0;x<gridOrigenDatos.getStore().getCount();x++)
                                                                        {
                                                                        	f=gridOrigenDatos.getStore().getAt(x);
                                                                            if(f.get('valorOrigen')!='')
                                                                            {
                                                                            	pEditar=0;
                                                                            	if(f.get('permiteEditar'))
                                                                                	pEditar=1;
                                                                            	oCampo='{"idCampo":"'+f.get('idCampo')+'","valor":"'+cv(f.get('valorOrigen'))+'","permiteEditar":"'+pEditar+'"}';
                                                                            	if(cadCampo=='')
                                                                                	cadCampo=oCampo;
                                                                                else
                                                                                	cadCampo+=','+oCampo;
                                                                            }
                                                                        }
                                                                        cadOrigen+=',"arrCampos":['+cadCampo+']}';
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	h.gE('contenedorSpanGrid_'+iE).setAttribute('origenDatos',bE(cadOrigen));
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=76&cadObj='+cadOrigen+'&idElemento='+iE,true);

                                                                        
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
	
  	if(cadObjConf!='')	
    {
    	var objConf=eval('['+cadObjConf+']')[0];
        cmbTipoOrigenDatos.setValue(objConf.tipoOrigenDatos);
        dispararEventoSelectCombo('cmbTipoOrigenDatos');
        switch(cmbTipoOrigenDatos.getValue())
        {
        	case '1':
            	cmbAlmacenDatos.setValue(objConf.idOrigenDatos);
                dispararEventoSelectCombo('cmbAlmacenDatos');
                ventanaAM.show();
            break;
            case '2':
            	var txtFuncion=gEx('txtFuncion');
                txtFuncion.idFuncion=objConf.idOrigenDatos;
                obtenerNombreFuncion(objConf.idOrigenDatos,ventanaAM);
            break;
        }
        
        var x;
        var f;
        var pos;
        var arrValores=[];
        var objValor=[];
        for(x=0;x<gridOrigenDatos.getStore().getCount();x++)
        {
        	f=gridOrigenDatos.getStore().getAt(x);
			objValor=new Array();
            objValor[0]=f.get('idCampo');
            objValor[1]=f.get('campo');
            objValor[2]=f.get('valorOrigen');
            objValor[3]=f.get('permiteEditar');
            pos=existeValorArregloObjetos(objConf.arrCampos,'idCampo',f.get('idCampo'));
            if(pos!=-1)
            {
                objValor[2]=objConf.arrCampos[pos].valor;
                if(objConf.arrCampos[pos].permiteEditar=='1')
                	objValor[3]=true;
                else
                	objValor[3]=false;
            }
            arrValores.push(objValor);
        }
        gridOrigenDatos.getStore().loadData(arrValores);
        
    }
    else
    	ventanaAM.show();
}

function crearGridOrigenDatos()
{
	var cmbEditor=crearComboExt('cmbEditor',[],0,0);
	var dsDatos=[];
    var gridCampoGrid=gEx('gridCampoGrid');
    var x;
    var f;
    for(x=0;x<gridCampoGrid.getStore().getCount();x++)
    {
    	f=gridCampoGrid.getStore().getAt(x);
        dsDatos.push([f.get('idRegistroCampo'),f.get('idCampo'),'',true]);
    }
    
    
    
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'idCampo'},
                                                                    {name: 'campo'},
                                                                    {name: 'valorOrigen'},
                                                                    {name: 'permiteEditar'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	
	var checkColumn = new Ext.grid.CheckColumn	(
	 												{
													   header: 'Permite editar',
													   dataIndex: 'permiteEditar',
													   width: 110
													}
												);
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														{
															header:'ID Campo',
															width:170,
															sortable:true,
															dataIndex:'campo'
														},
														{
															header:'Valor asociado',
															width:200,
															sortable:true,
															dataIndex:'valorOrigen',
                                                            renderer:function(val)
                                                            		{
                                                                    	var cmbEditor=gEx('cmbEditor');
                                                                    	var cmbTipoOrigenDatos=gEx('cmbTipoOrigenDatos');
                                                                        if(cmbTipoOrigenDatos.getValue()=='1')
                                                                        {
                                                                        	var pos=obtenerPosFila(cmbEditor.getStore(),'id',val);
                                                                            if(pos!=-1)
	                                                                            return cmbEditor.getStore().getAt(pos).get('nombre');
                                                                            return '';
                                                                        }
                                                                        return val;
                                                                    }
														},
                                                        checkColumn
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gridOrigenDatos',
                                                            store:alDatos,
                                                            frame:true,
                                                            disabled:true,
                                                            x:10,
                                                            y:80,
                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            stripeRows :true,
                                                            columnLines : true,
                                                            height:275,
                                                            width:565,
                                                            clicksToEdit:1,
                                                            plugins:[checkColumn]

                                                        }
                                                    );
	return 	tblGrid;
}

function limpiarGridOrigenDatos()
{
	var gridOrigenDatos=gEx('gridOrigenDatos');
    var x;
    var f;
    for(x=0;x<gridOrigenDatos.getStore().getCount();x++)
    {
    	f=gridOrigenDatos.getStore().getAt(x);
        f.set('valorOrigen','');
        f.set('permiteEditar',true);
        
    }
    
}

function mostrarVentanaFuncionOrigenGrid()
{
	asignarFuncionNuevoConceptoInyeccion=function(idConsulta,nombre)
                                            {
                                                var iConsulta=idConsulta;
                                                var r=new registroConcepto	(
                                                                                {
                                                                                    idConsulta:iConsulta,
                                                                                    nombreConsulta:nombre,
                                                                                    nombreCategoria:'',
                                                                                    descripcion:'',
                                                                                    valorRetorno:'',
                                                                                    parametros:''
                                                                                }
                                                                            )
                                                                            
                                                funcionOrigenDatosSelGrid(r, gEx('vAgregarExp'));	
                                            }
    mostrarVentanaExpresion(funcionOrigenDatosSelGrid,true)
}

function funcionOrigenDatosSelGrid(fila,ventana)
{
	gEx('txtFuncion').setValue(fila.get('nombreConsulta'));
    gEx('txtFuncion').idFuncion=fila.get('idConsulta');
    ventana.close();
}

function obtenerNombreFuncion(idFuncion,ventana)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var txtFuncion=gEx('txtFuncion');
            txtFuncion.setValue(arrResp[1]);
            ventana.show();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesEspecialesSistema.php',funcAjax, 'POST','funcion=2&idFuncion='+idFuncion,true);
    
}
