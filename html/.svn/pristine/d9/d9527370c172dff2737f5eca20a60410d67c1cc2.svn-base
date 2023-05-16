<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
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
	if($ancho==255)
		$ancho+=150;
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
	$campos=uEJ($campos);
	$camposOpciones=uEJ($camposOpciones);
?>

RegistroOpciones =Ext.data.Record.create	(
												[
													<?php 
														echo $campos;
													?>
												]
											)

function mostrarVentanaPreguntasCerradas()
{

	idOrigenD=1;
	var opcion1=new Ext.form.Radio	(
                                            {
                                                id:'opcion1',
                                                name:'origenD',
                                                value:1,
                                                boxLabel:'Opciones ingresadas manualmente por m&iacute;',
                                                x:40,
                                                y:45,
                                                
                                                checked:true
                                            }
                                        );
                                        
	opcion1.on('check',opcionClick);                                        
	var opcion2= new Ext.form.Radio	(
                                            {
                                                id:'opcion2',
                                                name:'origenD',
                                                value:2,
                                                boxLabel:'Opciones generadas en un intervalo de n&uacute;meros',
                                                x:40,
                                                y:75
                                            }
                                        );
	opcion2.on('check',opcionClick);                                            
	var opcion3=new Ext.form.Radio	(
                                            {
                                                id:'opcion3',
                                                name:'origenD',
                                                value:3,
                                                boxLabel:'Opciones tomadas de un almac\xE9n de datos',
                                                x:40,
                                                y:105
                                            }
                                        );   
	opcion3.on('check',opcionClick);   
    
    var opcion4=new Ext.form.Radio	(
                                            {
                                                id:'opcion4',
                                                name:'origenD',
                                                value:4,
                                                boxLabel:'Opciones tomadas de un almac\xE9n de datos (Autocompletar)',
                                                x:40,
                                                y:135
                                            }
                                        );   
	opcion4.on('check',opcionClick);                                           
    
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
                                                                    html:'Por favor seleccione el origen de datos de su control de selecci&oacute;n:'
                                                                },
                                                    			opcion1,
                                                                opcion2,
                                                                opcion3,
                                                                opcion4
                                                    			
                                                    		]
												}
											);
		
	ventanaOrigenDatosSel = new Ext.Window(
											{
												title: 'Origen de datos del control de selecci&oacute;n',
												width: 450,
												height:270,
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
																	text: 'Siguiente >>',
																	listeners:	{
																					click:function()
																						{
																							ventanaOrigenDatosSel.hide();
                                                                                            switch(idOrigenD)
                                                                                            {
                                                                                            	case 1:
                                                                                                	mostrarVEntCerrada();
                                                                                                break;
                                                                                                case 2:
                                                                                                	mostrarVIntervalo();
                                                                                                break;
                                                                                                case 3:
                                                                                                	mostrarVentanaSelAlmacenDatos(1,0,4);
                                                                                                break;
                                                                                                case 4:
                                                                                                	mostrarVentanaSelAlmacenDatos(1,1,4);
                                                                                                break;
                                                                                           
                                                                                            }
																							
																							
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

function opcionClick(combo,checado)
{
	if(checado)
    {
    	idOrigenD=combo.value;
    }
}

function mostrarVEntCerrada(tipoElemento)
{
	
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
                                                            header:'Valor opci&oacute;n',
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
    
    var txtNombreCampo=new Ext.form.TextField	(
                                                    {
                                                        id:'txtNombreCampo',
                                                        x:140,
                                                        y:5,
                                                        width:160,
                                                        hideLabel:true,
                                                        maskRe:/^[a-zA-Z0-9]$/
                                                       
                                                    }
                                                )
    
    tblOpciones=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gridOpcionesManuales',
                                                            store:alOpciones,
                                                            frame:true,
                                                            clicksToEdit: 2,
                                                            cm: cmFrmDTD,
                                                            height:300,
                                                            width:<?php echo $ancho+35 ?>,
                                                            title:'Escriba la opci&oacute;n a presentar en cada uno de los idiomas:',
                                                            tbar: [
                                                                    {
                                                                        text: 'Agregar opci&oacute;n',
                                                                        icon:'../images/add.png',
                                                                        cls:'x-btn-text-icon',
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
                                                                        text:'Eliminar opci&oacute;n',
                                                                        icon:'../images/delete.png',
                                                                        cls:'x-btn-text-icon',
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
                                                                                        msgConfirm('¿Est&aacute; seguro de querer eliminar esta registro?',funcConfirmDel);
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                        msgBox('Primero debe elegir una fila o elemento');
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
                msgBox('El valor ingresado, ya esta siendo ocupado por otra opci&oacute;n',funcOK);
            }
        }
    }
    tblOpciones.on('afteredit',funcEdicion);
    
    panelGrid=new Ext.Panel	(
                                {
                                    y:65,
                                    items:	[
                                                tblOpciones
                                            ]
                                }
                            );
                            
    var comboSiNo=crearComboExt('idComboSiNo',arrSiNo,140,35,120);
    comboSiNo.setValue('0');
    
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
                                                                                    text:'ID Control:'
                                                                                }
                                                                            ) ,
                                                        txtNombreCampo,
                                                        new Ext.form.Label	(
                                                                                    {
                                                                                        x:5,
                                                                                        y:40,
                                                                                        text:'¿Campo obligatorio?:'
                                                                                    }
                                                                                ) , 
                                                        comboSiNo,
                                                        panelGrid
                                                        
                                                    ]
                                        }
                                    );
    
    

    
    
    
    btnSiguiente=new Ext.Button	(
                                    {
                                        text: 'Finalizar',
                                        minWidth:80,
                                        id:'btnFinalizarPCerradas',
                                        listeners:	{
                                                        click:
                                                                {
                                                                    fn:function()
                                                                    {
                                                                        if(btnSiguiente.getText()!='Finalizar')
                                                                        {
                                                                            var resul=validarOpciones(tblOpciones.getStore(),tblOpciones);
                                                                            if(resul)
                                                                                mostrarVAyuda(ventanaPregCerradas,tblOpciones);
                                                                        }
                                                                        else
                                                                        {
                                                                        
                                                                            var txtNombreCampo=Ext.getCmp('txtNombreCampo').getValue();
                                                                            if(txtNombreCampo=='')
                                                                            {
                                                                                function resp()
                                                                                {
                                                                                    Ext.getCmp('txtNombreCampo').focus(false,10);
                                                                                }
                                                                                msgBox('El valor ingresado no es v&aacute;lido',resp);
                                                                                return;
                                                                            }
                                                                            
                                                                            
                                                                            var resul=validarOpciones(tblOpciones.getStore(),tblOpciones);
                                                                            
                                                                            if(resul)
                                                                            {
                                                                                var opciones=obtenerValoresOpcionesManuales();
                                                                                if(tipoElemento==undefined)
                                                                                	var objFinal='{"idFormulario":"'+idFormulario+'","nomCampo":"'+txtNombreCampo+'","pregunta":null,"tipoElemento":"2","posX":"@posX","posY":"@posY","obligatorio":"'+comboSiNo.getValue()+'","opciones":'+opciones+'}';
                                                                               	else
                                                                               		var objFinal='{"idFormulario":"'+idFormulario+'","nomCampo":"'+txtNombreCampo+'","pregunta":null,"tipoElemento":"'+tipoElemento+'","posX":"@posX","posY":"@posY","obligatorio":"'+comboSiNo.getValue()+'","opciones":'+opciones+'}'; 
                                                                               
                                                                                h.objControl=objFinal;
                                                                                gEx('ventanaPregCerradas').close();
                                                                            }
                                                                        }
                                                                        
                                                                    }
                                                                }
                                                    }
                                    }
                                )
    
    ventanaPregCerradas = new Ext.Window(
                                            {
                                            	id:'ventanaPregCerradas',
                                                title: 'Opciones posibles',
                                                width: <?php echo ($ancho+65) ?> ,
                                                height:470,
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
                                                                            txtNombreCampo.focus();
                                                                        }
                                                                    }
                                                        },
                                                buttons:	[
                                                                btnSiguiente,
                                                                {
                                                                    text: '<?php echo $etj["lblBtnCancelar"] ?>',
                                                                    handler:function()
                                                                    {
                                                                    	ventanaOrigenDatosSel.close();
                                                                        ventanaPregCerradas.close();
                                                                    }
                                                                }
                                                            ]
                                            }
                                        );
	
	
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
            var numColums=cm.getColumnCount();
           
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
                                Ext.getCmp('btnFinalizarPCerradas').fireEvent('click');
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
        var valColumnas=obtenerValoresColumnasRegistro(cm,reg);
        cadTemp='{"vOpcion":"'+reg.get('valorOpt')+'",'+
                '"columnas":['+valColumnas+']'+
                '}';
        if(opciones=='')
            opciones=cadTemp;
        else
            opciones+=','+cadTemp;
    }
    return '['+opciones+']';
}

function mostrarVIntervalo(tipoElemento)
{
	var txtNombreCampo=new Ext.form.TextField	(
                                                    {
                                                        id:'txtNombreCampo',
                                                        x:140,
                                                        y:5,
                                                        width:160,
                                                        hideLabel:true,
                                                        maskRe:/^[a-zA-Z0-9]$/
                                                       
                                                    }
                                                )
	
	var comboSiNo=crearComboExt('idComboSiNo',arrSiNo,140,35,120);
    comboSiNo.setValue('0');

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
                                                                                    text:'ID Control:'
                                                                                }
                                                                            ) ,
                                                                txtNombreCampo,
                                                                new Ext.form.Label	(
                                                                                            {
                                                                                                x:5,
                                                                                                y:40,
                                                                                                text:'¿Campo obligatorio?:'
                                                                                            }
                                                                                        ) , 
                                                                comboSiNo,
                                                    
                                                    			{
                                                                	x:5,
                                                                    y:70,
                                                                	xtype:'label',
                                                                    text:'Valor inicial:'
                                                                },
                                                                {
                                                                	x:140,
                                                                    y:65,
                                                                    xtype:'numberfield',
                                                                    id:'txtInicio',
                                                                    allowDecimals:true,
                                                                    width:100
                                                                },
                                                                {
                                                                	x:5,
                                                                    y:100,
                                                                	xtype:'label',
                                                                    text:'Valor final:'
                                                                },
                                                                {
                                                                	x:140,
                                                                    y:95,
                                                                    xtype:'numberfield',
                                                                    id:'txtFin',
                                                                    allowDecimals:true,
                                                                    width:100
                                                                },
                                                                {
                                                                	x:5,
                                                                    y:130,
                                                                	xtype:'label',
                                                                    text:'Espaciado entre valores de:'
                                                                },
                                                                {
                                                                	x:187,
                                                                    y:125,
                                                                    xtype:'numberfield',
                                                                    id:'txtIncremento',
                                                                    value:'1',
                                                                    width:80,
                                                                    allowDecimals:true,
                                                                    width:100
                                                                    
                                                                }
                                                    			
                                                    			
                                                    		]
												}
											);
		
	ventanaIntervalo = new Ext.Window(
											{
                                            	id:'ventanaIntervalo',
												title: 'Configuraci&oacute;n de intervalos',
												width: 340,
												height:260,
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
																			txtNombreCampo.focus();
																		}
																	}
														},
												buttons:	[
																{
																	id:'btnAceptar',
																	text: 'Finalizar',
																	listeners:	{
																					click:function()
																						{
																							
																							var inicio=Ext.getCmp('txtInicio').getRawValue();
																						    var final=Ext.getCmp('txtFin').getRawValue();
                                                                                            var incremento=Ext.getCmp('txtIncremento').getRawValue();
                                                                                            var txtNombreCampo=Ext.getCmp('txtNombreCampo').getValue();
                                                                                            if(txtNombreCampo=='')
                                                                                            {
                                                                                                function resp()
                                                                                                {
                                                                                                    Ext.getCmp('txtNombreCampo').focus(false,10);
                                                                                                }
                                                                                                msgBox('El valor ingresado no es v&aacute;lido',resp);
                                                                                                return;
                                                                                            }
                                                                                            if(!esEntero(inicio))
                                                                                            {
                                                                                            	function resp2()
                                                                                                {
                                                                                                	Ext.getCmp('txtInicio').focus();
                                                                                                }
                                                                                                msgBox('El valor ingresado no es v&aacute;lido',resp2);
                                                                                                return;
                                                                                            }
                                                                                            if(!esEntero(final))
                                                                                            {
                                                                                            	function resp3()
                                                                                                {
                                                                                                	Ext.getCmp('txtFin').focus();
                                                                                                }
                                                                                                msgBox('El valor ingresado no es v&aacute;lido',resp3);
                                                                                                return;
                                                                                            }
                                                                                            if(!esEntero(incremento))
                                                                                            {
                                                                                            	function resp4()
                                                                                                {
                                                                                                	Ext.getCmp('txtIncremento').focus();
                                                                                                }
                                                                                                msgBox('El valor ingresado no es v&aacute;lido',resp4);
                                                                                                return;
                                                                                            }
                                                                                            var objIntervalo='{"inicio":"'+inicio+'","fin":"'+final+'","intervalo":"'+incremento+'"}';
                                                                                            
                                                                                            if(tipoElemento==undefined)
	                                                                                            var objFinal='{"idFormulario":"'+idFormulario+'","pregunta":null,"tipoElemento":"3","objInt":'+objIntervalo+',"posX":"@posX","posY":"@posY","nomCampo":"'+txtNombreCampo+'","obligatorio":"'+comboSiNo.getValue()+'"}';
                                                                                            else
                                                                                            	var objFinal='{"idFormulario":"'+idFormulario+'","pregunta":null,"tipoElemento":"'+tipoElemento+'","objInt":'+objIntervalo+',"posX":"@posX","posY":"@posY","nomCampo":"'+txtNombreCampo+'","obligatorio":"'+comboSiNo.getValue()+'"}';
                                                                                             h.objControl=objFinal;
                                                                                             gEx('ventanaIntervalo').close();
																						}
																				}
																},
																{
																	text: '<?php echo $etj["lblBtnCancelar"]?>',
																	handler:function()
																			{
                                                                            	ventanaOrigenDatosSel.close();
																				ventanaIntervalo.close();
																			}
																}
															]
											}
										);

		ventanaIntervalo.show();
}

function obtenerValoresVentanaIntervalo()
{
	var inicio=Ext.getCmp('txtInicio').getValue();
    var final=Ext.getCmp('txtFin').getValue();
	var obj='{"inicio":"'+inicio+'","fin":"'+final+'"}';
    return obj;
}

function mostrarVentanaSelColumnaCombo(obj)
{
	var autocompletar;
	listUsuario=new Array();
	listApp=new Array();
    arrCampo=null;
	var cmbCampoLlave=crearComboExt('cmbCampoLlave',obj.campos,135,240);
    var cmbCampoBusqueda=crearComboExt('cmbCampoBusqueda',obj.campos,135,270);
    var lblBtn='Finalizar';
    var comboSiNo=crearComboExt('idComboSiNo',arrSiNo,140,35,120);
    comboSiNo.setValue('0');
    var txtNombreCampo=new Ext.form.TextField	(
                                                  {
                                                      id:'txtNombreCampo',
                                                      x:140,
                                                      y:5,
                                                      width:160,
                                                      hideLabel:true,
                                                      maskRe:/^[a-zA-Z0-9]$/
                                                  }
                                              )
    var valorOculto=false;
    if(obj.auto=='0')
    {
    	autocompletar=0;
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
                                                                                    text:'ID Control:'
                                                                                }
                                                                            ) ,
                                                        txtNombreCampo,
                                                        new Ext.form.Label	(
                                                                                    {
                                                                                        x:5,
                                                                                        y:40,
                                                                                        text:'¿Campo obligatorio?:'
                                                                                    }
                                                                                ) , 
                                                        comboSiNo,
                                                        
                                                        {
                                                        	xtype:'label',
                                                            x:5,
                                                            y:105,
                                                            html:'Configure el texto a mostrar como opci&oacute;n:'
                                                        }
                                                        ,
                                                        {
                                                        	xtype:'panel',
                                                            x:20,
                                                            y:135,
                                                            height:100,
                                                            width:400,
                                                            baseCls: 'x-plain',
                                                            items:	[
                                                            			{
                                                                        	xtype:'button',
                                                                        	icon:'../images/add.png',
                                                                            tooltip:'Agregar campo',
                                                                        	handler:function()
                                                                            		{
                                                                                    	mostrarVentanaSelCampoCombo(obj.campos);
                                                                                    }
                                                                        }
                                                            		]
                                                        },
                                                        {
                                                        	xtype:'panel',
                                                            x:45,
                                                            y:135,
                                                            height:100,
                                                            width:400,
                                                            baseCls: 'x-plain',
                                                            items:	[
                                                            			{
                                                                        	xtype:'button',
                                                                        	icon:'../images/font_add.png',
                                                                            tooltip:'Agregar frase',
                                                                        	handler:function()
                                                                            		{
                                                                                    	mostrarVentanaFrase();
                                                                                    }
                                                                        }
                                                            		]
                                                        },
                                                        {
                                                        	xtype:'panel',
                                                            x:70,
                                                            y:135,
                                                            height:100,
                                                            width:400,
                                                            baseCls: 'x-plain',
                                                            items:	[
                                                            			{
                                                                        	xtype:'button',
                                                                        	icon:'../images/espacio.png',
                                                                            tooltip:'Agregar espacio en blanco',
                                                                        	handler:function()
                                                                            		{
                                                                                    	listUsuario.push('\' \'');
                                                                                        listApp.push('\' \'');
                                                                                        actualizarVistaOpcion();
                                                                                    }
                                                                        }
                                                            		]
                                                        },
                                                        {
                                                        	xtype:'panel',
                                                            x:95,
                                                            y:135,
                                                            height:100,
                                                            width:400,
                                                            baseCls: 'x-plain',
                                                            items:	[
                                                            			{
                                                                        	xtype:'button',
                                                                        	icon:'../images/delete.png',
                                                                            tooltip:'Remover elemento',
                                                                        	handler:function()
                                                                            		{
                                                                                    	listUsuario.pop();
                                                                                        listApp.pop();
                                                                                        actualizarVistaOpcion();
                                                                                    }
                                                                                    
                                                                        }
                                                            		]
                                                        },
                                                        {
                                                        
                                                        	id:'txtVistaElemento',
                                                            xtype:'textarea',
                                                            x:20,
                                                            y:175,
                                                            width:500,
                                                            height:50,
                                                            readOnly:true
                                                        },
                                                        {
                                                        	x:5,
                                                            y:245,
                                                            xtype:'label',
                                                            html:'Campo ID:'
                                                        },
                                                        cmbCampoLlave
                                                    ]
                                        }
                                    );
    }
    else
    {
    	autocompletar=1;
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
                                                                                        text:'ID Control:'
                                                                                    }
                                                                                ) ,
                                                            txtNombreCampo,
                                                            new Ext.form.Label	(
                                                                                    {
                                                                                        x:5,
                                                                                        y:40,
                                                                                        text:'¿Campo obligatorio?:'
                                                                                    }
                                                                                ) , 
                                                            comboSiNo,
                                                            {
                                                                xtype:'label',
                                                                x:5,
                                                                y:105,
                                                                html:'Configure el texto a mostrar como opci&oacute;n:'
                                                            }
                                                            ,
                                                            {
                                                                xtype:'panel',
                                                                x:20,
                                                                y:135,
                                                                height:100,
                                                                width:400,
                                                                baseCls: 'x-plain',
                                                                items:	[
                                                                            {
                                                                                xtype:'button',
                                                                                icon:'../images/add.png',
                                                                                tooltip:'Agregar campo',
                                                                                handler:function()
                                                                                        {
                                                                                            mostrarVentanaSelCampoCombo(obj.campos);
                                                                                        }
                                                                            }
                                                                        ]
                                                            },
                                                            {
                                                                xtype:'panel',
                                                                x:45,
                                                                y:135,
                                                                height:100,
                                                                width:400,
                                                                baseCls: 'x-plain',
                                                                items:	[
                                                                            {
                                                                                xtype:'button',
                                                                                icon:'../images/font_add.png',
                                                                                tooltip:'Agregar frase',
                                                                                handler:function()
                                                                                        {
                                                                                            mostrarVentanaFrase();
                                                                                        }
                                                                            }
                                                                        ]
                                                            },
                                                            {
                                                                xtype:'panel',
                                                                x:70,
                                                                y:135,
                                                                height:100,
                                                                width:400,
                                                                baseCls: 'x-plain',
                                                                items:	[
                                                                            {
                                                                                xtype:'button',
                                                                                icon:'../images/espacio.png',
                                                                                tooltip:'Agregar espacio en blanco',
                                                                                handler:function()
                                                                                        {
                                                                                            listUsuario.push('\' \'');
                                                                                            listApp.push('\' \'');
                                                                                            actualizarVistaOpcion();
                                                                                        }
                                                                            }
                                                                        ]
                                                            },
                                                            {
                                                                xtype:'panel',
                                                                x:95,
                                                                y:135,
                                                                height:100,
                                                                width:400,
                                                                baseCls: 'x-plain',
                                                                items:	[
                                                                            {
                                                                                xtype:'button',
                                                                                icon:'../images/delete.png',
                                                                                tooltip:'Remover elemento',
                                                                                handler:function()
                                                                                        {
                                                                                            listUsuario.pop();
                                                                                            listApp.pop();
                                                                                            actualizarVistaOpcion();
                                                                                        }
                                                                                        
                                                                            }
                                                                        ]
                                                            },
                                                            
                                                            {
                                                            
                                                                id:'txtVistaElemento',
                                                                xtype:'textarea',
                                                                x:20,
                                                                y:175,
                                                                width:500,
                                                                height:50,
                                                                readOnly:true
                                                            },
                                                            {
                                                                x:5,
                                                                y:245,
                                                                xtype:'label',
                                                                html:'Campo ID:'
                                                            },
                                                            cmbCampoLlave,
                                                            {
                                                                x:5,
                                                                y:275,
                                                                xtype:'label',
                                                                html:'Campo de b&uacute;squeda:'
                                                            },
                                                            cmbCampoBusqueda
                                                            
                                                        ]
                                            }
                                        );
    }
    
    
    btnSiguiente=new Ext.Button	(
                                    {
                                        text: lblBtn,
                                        minWidth:80,
                                        id:'btnFinalizar',
                                        listeners:	{
                                                        click:
                                                                {
                                                                    fn:function()
                                                                    {
                                                                        var txtNombreCampo=Ext.getCmp('txtNombreCampo').getValue();
                                                                        if(txtNombreCampo=='')
                                                                        {
                                                                            function resp()
                                                                            {
                                                                                Ext.getCmp('txtNombreCampo').focus(false,10);
                                                                            }
                                                                            msgBox('El ID del campo es obligatorio',resp);
                                                                            return;
                                                                        }
                                                                        
                                                                        if(listApp.length==0)
                                                                        {
                                                                        	msgBox('Al menos debe seleccionar un campo para proyectar como texto de la opci&oacute;n');
                                                                        	return;
                                                                        }
                                                                        var x;
                                                                        var nomColumn='';
                                                                        for(x=0;x<listApp.length;x++)
                                                                        {
                                                                        	if(nomColumn=='')
                                                                        		nomColumn=listApp[x];
                                                                            else
                                                                            	nomColumn+='@@'+listApp[x];
                                                                        }
                                                                        
                                                                        var cLlave=cmbCampoLlave.getValue();
                                                                        if(cLlave=='')
                                                                        {
                                                                        	msgBox('Debe seleccionar el campo ID que identificara de manera unica a cada una de sus opciones');
                                                                        	return;
                                                                        }
                                                                        var nodoMysql=buscarNodoID(gEx('arbolDataSet').getRootNode(),cLlave);
                                                                        
                                                                        if(nodoMysql.nCampo!=undefined)
                                                                        	cLlave=nodoMysql.nCampo;
                                                                        else
                                                                        	cLlave=nodoMysql.attributes.nCampo;
                                                                            
                                                                        
                                                                        var cmbCampoBusqueda=Ext.getCmp('cmbCampoBusqueda');
                                                                        cBusqueda='';
                                                                        if(obj.auto=='1')
                                                                        {
                                                                            if(cmbCampoBusqueda!=null)
                                                                            {
                                                                                cBusqueda=cmbCampoBusqueda.getValue();
                                                                                nodoMysql=buscarNodoID(gEx('arbolDataSet').getRootNode(),cBusqueda);
                                                                            
                                                                                if(nodoMysql.nCampo!=undefined)
                                                                                    cBusqueda=nodoMysql.nCampo;
                                                                                else
                                                                                    cBusqueda=nodoMysql.attributes.nCampo;
                                                                                
                                                                            }
                                                                        }
                                                                        var objTablaConf='{"tabla":"'+obj.idAlmacen+'","columna":"'+cv(nomColumn)+'","cLlave":"'+cLlave+'","autocompletar":"'+autocompletar+'","cBusqueda":"'+cBusqueda+'"}';
                                                                        
                                                                        
                                                                        var objFinal='{"idFormulario":"'+idFormulario+'","pregunta":null,"tipoElemento":"'+obj.tipoElemento+'","objTablaConf":'+objTablaConf+',"posX":"@posX","posY":"@posY","nomCampo":"'+txtNombreCampo+'","obligatorio":"'+comboSiNo.getValue()+'","comboDependiente":"0"}';
                                                                        h.objControl=objFinal;
                                                                        gEx('ventanaSelCol').close();
                                                                        
                                                                        
                                                                    }
                                                                }
                                                    }
                                    }
                                )
    
    ventanaSelCol = new Ext.Window(
                                            {
                                            	id:'ventanaSelCol',
                                                title: 'Selecci&oacute;n de columna que ser&aacute; la fuente de datos',
                                                width: 600 ,
                                                height:400,
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
                                                          			    	Ext.getCmp('txtNombreCampo').focus(false,10);              
                                                                        }
                                                                    }
                                                        },
                                                buttons:	[
                                                                btnSiguiente,
                                                                {
                                                                    text: '<?php echo $etj["lblBtnCancelar"] ?>',
                                                                    handler:function()
                                                                    {
                                                                    	
                                                                        ventanaSelCol.close();
                                                                    }
                                                                }
                                                            ]
                                            }
                                        );
	ventanaSelCol.show();
}

function cargarColumnasCombo(nomTabla,ventana)
{
	function funcResp()
    {
    	var arrResp=peticion_http.responseText.split('|');
        if(arrResp[0]=='1')
		{
            	var arrTablas=eval(arrResp[1]);
                var arrTablasCmb=eval(arrResp[2]);
                Ext.getCmp('cmbCampoLlave').getStore().loadData(arrTablasCmb);
                var cmbCampoBusqueda=Ext.getCmp('cmbCampoBusqueda');
                if(cmbCampoBusqueda!=null)
	                cmbCampoBusqueda.getStore().loadData(arrTablasCmb);
               	ventana.show();
                arrCampo=arrTablas;
		}
		else
		{
			msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
		}
    }
    obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcResp, 'POST','funcion=13&nomTabla='+nomTabla,true);
}

function mostrarVentanaSelCampoCombo(arrCampo)
{
	
	var alOpciones=		new Ext.data.SimpleStore(
                                                    {
                                                        fields:	[
                                                                 	{name:'campoMysql'},
                                                                    {name:'campoUsr'},
                                                                    {name:'idNodo'}
                                                                ]
                                                    }
                                                );
    alOpciones.loadData(arrCampo);
   
    var cmFrmDTD= new Ext.grid.ColumnModel   	(
                                                    [
                                                        new  Ext.grid.RowNumberer(),
                                                        
                                                        {
                                                            header:'Campo',
                                                            width:400,
                                                            dataIndex:'campoUsr'
                                                        }
                                                       
                                                    ]
                                                );
    
    var tblOpciones=	new Ext.grid.GridPanel	(
                                                        {
                                                            id:'gridTabla',
                                                            store:alOpciones,
                                                            frame:true,
                                                            cm: cmFrmDTD,
                                                            height:220,
                                                            width:490,
                                                            title:'Seleccione el campo a insertar'
                                                        }
                                                    );
  
    panelGrid=new Ext.Panel	(
                                {
                                    y:10,
                                    x:10,
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

	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar campo',
										width: 530,
										height:330,
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
																		var fila=tblOpciones.getSelectionModel().getSelected();
                                                                        var campo=fila.get('campoUsr');
                                                                        
                                                                        
                                                                        var nodoMysql=buscarNodoID(gEx('arbolDataSet').getRootNode(),fila.get('idNodo'));
                                                                        console.log(nodoMysql);
                                                                        var campoMysql;
                                                                        if(nodoMysql.nCampo!=undefined)
                                                                        	campoMysql=nodoMysql.nCampo;
                                                                        else
                                                                        	campoMysql=nodoMysql.attributes.nCampo;
                                                                        listUsuario.push(campo);
                                                                        listApp.push(campoMysql);
                                                                        actualizarVistaOpcion();
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

function actualizarVistaOpcion()
{
	var x;
    var cadena='';
    for(x=0;x<listUsuario.length;x++)
    {
    	cadena+=listUsuario[x];	
    }
    Ext.getCmp('txtVistaElemento').setValue(cadena);
}

function mostrarVentanaFiltroCombo(objFinal,nomTabla)
{

	idOrigenD=1;
	var opcion1=new Ext.form.Radio	(
                                            {
                                                id:'opcion1F',
                                                name:'origenD',
                                                value:1,
                                                boxLabel:'De otro control del formulario',
                                                x:40,
                                                y:45,
                                                
                                                checked:true
                                            }
                                        );
                                        
	opcion1.on('check',opcionClick);                                        
	var opcion2= new Ext.form.Radio	(
                                            {
                                                id:'opcion2F',
                                                name:'origenD',
                                                value:2,
                                                boxLabel:'De un valor seleccionado por m&iacute;',
                                                x:40,
                                                y:75
                                            }
                                        );
	opcion2.on('check',opcionClick);                                            
	                                          
    
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
                                                                    text:'Seleccione el tipo de filtrado de los datos:'
                                                                },
                                                    			opcion1,
                                                                opcion2
                                                    		]
												}
											);
		
	ventanaOrigenDatosSel = new Ext.Window(
											{
												title: 'Origen de filtro de datos',
												width: 450,
												height:250,
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
																	text: 'Siguiente >>',
																	listeners:	{
																					click:function()
																						{
																							ventanaOrigenDatosSel.hide();
                                                                                            switch(idOrigenD)
                                                                                            {
                                                                                            	case 1:
                                                                                                	mostrarVentanaSelComboDep(objFinal,nomTabla);
                                                                                                break;
                                                                                                case 2:
                                                                                                	mostrarVentanaCondFiltroCombo(objFinal,nomTabla);
                                                                                                	
                                                                                                break;
                                                                                              
                                                                                           
                                                                                            }
																							
																							
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

function mostrarVentanaSelComboDep(objFinal,tabla)
{
	var siguiente=0;
	var alOpciones=		new Ext.data.SimpleStore(
                                                    {
                                                        fields:	[
                                                                 	{name:'campo'},
                                                                    {name:'tipo'}
                                                                ]
                                                    }
                                                );
    
    
    var dsOpciones= [];
    
    alOpciones.loadData(dsOpciones);
    
    var cmFrmDTD= new Ext.grid.ColumnModel   	(
                                                    [
                                                        new  Ext.grid.RowNumberer(),
                                                        {
                                                            header:'Nombre del control',
                                                            width:150,
                                                            dataIndex:'campo'
                                                        },
                                                        {
                                                        	header:'Origen de datos',
                                                            width:300,
                                                            dataIndex:'tipo'
                                                        }
                                                       
                                                    ]
                                                );
    
    
    var tblOpciones=	new Ext.grid.GridPanel	(
                                                        {
                                                            id:'gridTabla',
                                                            store:alOpciones,
                                                            frame:true,
                                                            clicksToEdit: 2,
                                                            cm: cmFrmDTD,
                                                            height:300,
                                                            width:550,
                                                            title:'Elija el control select que servir&aacute; de base para los datos a presentar en el nuevo control:'
                                                            
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
                            
    var lblBtn='Finalizar';
    
    
	
    
    var cmbCampo=crearComboCampos();
    
    
    var form = new Ext.form.FormPanel(	
                                        {
                                            baseCls: 'x-plain',
                                            layout:'absolute',
                                            defaultType: 'textfield',
                                            items: 	[
                                                        panelGrid,
                                                        {
                                                        	x:10,
                                                            y:320,
                                                        	xtype:'label',
                                                            html:'<b>Condicion filtrado:  </b><br><br><font color="brown">Donde el campo </font>'
                                                            
                                                            
                                                        },
                                                        cmbCampo,
                                                        {
                                                        	x:10,
                                                            y:365,
                                                        	xtype:'label',
                                                            html:'<font color="brown">de su fuente de datos sea igual que el valor seleccionado del combo del cual depende.</font>'
                                                            
                                                            
                                                        }
                                                        
                                                        
                                                    ]
                                        }
                                    );
    
    

    
    
    
    btnSiguiente=new Ext.Button	(
                                    {
                                        text: lblBtn,
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
                                                                        	msgBox('Primero debe seleccionar el control del cual dependender&aacute;n los valores de su nuevo control select');
                                                                        	return;
                                                                        }
                                                                        var campoCondicion=cmbCampo.getValue();
                                                                        if(campoCondicion=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	cmbCampo.getValue().focus(false,10);
                                                                            }
                                                                        	msgBox('Debe seleccionar el campo bajo el cual se filtrara la informaci&aacute;n',resp);
                                                                        	return;
                                                                        }
                                                                        
                                                                        var nomColumn=filaSel.get('campo');
                                                                        objFinal="{"+objFinal+','+'"controlDependiente":"'+nomColumn+'","condicion":"=","campoCondicion":"'+campoCondicion+'"}';
                                                                        
                                                                         h.objControl=objFinal;
                                                                         gEx('ventanaSelComboDep').close();
                                                                       
                                                                    }
                                                                }
                                                    }
                                    }
                                )
    
    ventanaSelComboDep = new Ext.Window(
                                            {
                                            	id:'ventanaSelComboDep',
                                                title: 'Selecci&oacute;n de columna que ser&aacute; la fuente de datos',
                                                width: 600 ,
                                                height:480,
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
                                                                    	
                                                                        ventanaSelComboDep.close();
                                                                    }
                                                                }
                                                            ]
                                            }
                                        );
	
    
	cargarControlesSelect(alOpciones,idFormulario,ventanaSelComboDep,tabla,dsDatosCampos);
}

function cargarControlesSelect(almacen,idFormulario,ventana,tabla,almacenCampos)
{
	function funcResp()
    {
    	var arrResp=peticion_http.responseText.split('|');
        if(arrResp[0]=='1')
		{
            	var arrTablas=eval(arrResp[1]);
                var arrCampos=eval(arrResp[2]);
                almacen.loadData(arrTablas);
                almacenCampos.loadData(arrCampos);
               	ventana.show();
		}
		else
		{
			msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
		}
    }
    obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcResp, 'POST','funcion=15&idFormulario='+idFormulario+'&tabla='+tabla,true);
}

function mostrarVentanaCondFiltroCombo(objFinal,nomTabla)
{
	filtroUsuario=new Array();
    filtroMysql=new Array();
	var cmbCampo=crearComboGeneral('cmbCampo',null,'Elija una opci\xF3n');
    cmbCampo.setPosition(10,40);
    cmbCampo.setWidth(180);
    
    function setCondicionValor(combo,registro,indice)
    {
    	var obj=eval('[{'+objFinal+'}]');
		var nTabla=obj[0].objTablaConf.tabla;
        var cmbCondicion=Ext.getCmp('cmbCondicion');
        var arr;
        cmbCondicion.reset();
        tipoCampoF=registro.get('comp1');
        switch(tipoCampoF)
        {
            case'optM':
            case 'optT':
                arr=arrCombo;
                mostrarCampoF('cmbValor');
                
                Ext.getCmp('cmbValor').reset();
                llenarOpciones(registro.get('id'),nTabla);
            break;
            case 'varchar':
                arr=arrVarchar;
                Ext.getCmp('txtValor').setValue('');
                mostrarCampoF('txtValor');
            break;
            case 'int':
                arr=arrInt;
                Ext.getCmp('intValor').setValue('0');
                mostrarCampoF('intValor');
            break;
            case 'decimal':
                arr=arrInt;
                Ext.getCmp('decValor').setValue('0.0');
                mostrarCampoF('decValor');
            break;
            case 'date':
                arr=arrInt;
                mostrarCampoF('dteValor');
            break;
        }
        cmbCondicion.getStore().loadData(arr);
        cmbCondicion.focus(false,10);
    }
    
    
    cmbCampo.on('select',setCondicionValor);
    var condicion=crearComboGeneral('cmbCondicion',null,'Elija una opci\xF3n');
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
            	Ext.getCmp('txtValor').focus(false,10);
            break;
            case 'int':
                Ext.getCmp('intValor').focus(false,10);
            break;
            case 'decimal':
                Ext.getCmp('decValor').focus(false,10);
            break;
            case 'date':
                Ext.getCmp('dteValor').focus(false,10);
            break;
        }
    	
    }
    
    condicion.on('select',setFocoValor);
    var valor=crearComboGeneral('cmbValor',null,'Elija una opci\xF3n');
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
                                                            text:'Condici&aacute;n:'
                                                        },
                                                        condicion,
                                                        {
                                                            x:375,
                                                            y:15,
                                                            xtype:'label',
                                                            text:'Valor:'
                                                        },
                                                        valor,
                                                        valorTxt,
                                                        valorDte,
                                                        valorInt,
                                                        valorDec,
                                                        {
                                                            xtype:'panel',
                                                            x:10,
                                                            y:80,
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
                                                                                            function respq()
                                                                                            {
                                                                                                cmbCampo.focus(false,10);
                                                                                            }
                                                                                            msgBox('Debe seleccionar el campo bajo el cual se filtrara la informaci&oacute;n',resp1);
                                                                                            return;
                                                                                        }
                                                                                        var campo=cmbCampo.getValue();
                                                                                        var condicionU;
                                                                                        var condicionM;
                                                                                        if(condicion.getValue()=='')
                                                                                        {
                                                                                            function resp2()
                                                                                            {
                                                                                                condicion.focus(false,10);
                                                                                            }
                                                                                            msgBox('Debe seleccionar la condicion de comparaci&oacute;n',resp2);
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
                                                                                                    function resp3()
                                                                                                    {
                                                                                                        valor.focus(false,10);
                                                                                                    }
                                                                                                    msgBox('Debe ingresar el valor bajo el cual de filtrar&aacute; la informaci&oacute;n',resp3);
                                                                                                    return;
                                                                                                }
                                                                                                valorM=valor.getValue();
                                                                                                valorU=valor.getRawValue();
                                                                                            break;
                                                                                            case 'varchar':
                                                                                                valorU="'"+valorTxt.getValue()+"'";
                                                                                                valorM="'"+valorTxt.getValue()+"'";
                                                                                            break;
                                                                                            case 'int':
                                                                                                if(valorInt.getValue()=='')
                                                                                                {
                                                                                                    function resp4()
                                                                                                    {
                                                                                                        valorInt.focus(false,10);
                                                                                                    }
                                                                                                    msgBox('Debe ingresar el valor bajo el cual de filtrar&aacute; la informaci&oacute;n',resp4);
                                                                                                    return;
                                                                                                }
                                                                                                valorU=valorInt.getValue();
                                                                                                valorM=valorInt.getValue();
                                                                                                
                                                                                            break;
                                                                                            case 'decimal':
                                                                                                if(valorDec.getValue()=='')
                                                                                                {
                                                                                                    function resp5()
                                                                                                    {
                                                                                                        valorDec.focus(false,10);
                                                                                                    }
                                                                                                    msgBox('Debe ingresar el valor bajo el cual de filtrar&aacute; la informaci&oacute;n',resp5);
                                                                                                    return;
                                                                                                }
                                                                                                valorU=valorDec.getValue();
                                                                                                valorM=valorDec.getValue();
                                                                                            break;
                                                                                            case 'date':
                                                                                                if(valorDte.getValue()=='')
                                                                                                {
                                                                                                    function resp6()
                                                                                                    {
                                                                                                        valorDte.focus(false,10);
                                                                                                    }
                                                                                                    msgBox('Debe ingresar el valor bajo el cual de filtrar&aacute; la informaci&oacute;n',resp6);
                                                                                                    return;
                                                                                                }
                                                                                                valorU=valorDte.getValue().format('d/m/Y');
                                                                                                valorM="'"+valorDte.getValue().format('Y-m-d')+"'";
                                                                                                
                                                                                            break;
                                                                                            
                                                                                        }
                                                                                        var cadM=campo+' '+condicionM+' '+valorM;
                                                                                        var cadU=campo+' '+condicionU+' '+valorU;
                                                                                        filtroUsuario[filtroUsuario.length]=cadU;
                                                                                        filtroMysql[filtroMysql.length]=cadM;
                                                                                        generarSentencia();
                                                                                    }
                                                                         }
                                                                    ]
                                                            
                                                        
                                                               
                                                        },
                                                        {
                                                            xtype:'panel',
                                                            x:100,
                                                            y:80,
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
                                                                                            generarSentencia();
                                                                                        }
                                                                                    }
                                                                         }
                                                                    ]
                                                        },
                                                        {
                                                            xtype:'panel',
                                                            x:195,
                                                            y:80,
                                                            baseCls: 'x-plain',
                                                            items:	[
                                                                         {
                                                                             xtype:'button',
                                                                             text:'(',
                                                                             handler:function()
                                                                                    {
                                                                                        filtroUsuario[filtroUsuario.length]='(';
                                                                                        filtroMysql[filtroMysql.length]='(';
                                                                                        generarSentencia();
                                                                                    }
                                                                         }
                                                                    ]
                                                        },
                                                        {
                                                            xtype:'panel',
                                                            x:230,
                                                            y:80,
                                                            baseCls: 'x-plain',
                                                            items:	[
                                                                         {
                                                                             xtype:'button',
                                                                             text:')',
                                                                            handler:function()
                                                                                    {
                                                                                        filtroUsuario[filtroUsuario.length]=')';
                                                                                        filtroMysql[filtroMysql.length]=')';
                                                                                        generarSentencia();
                                                                                    }
                                                                         }
                                                                    ]
                                                        },
                                                        
                                                        {
                                                            xtype:'panel',
                                                            x:265,
                                                            y:80,
                                                            baseCls: 'x-plain',
                                                            items:	[
                                                                         {
                                                                             xtype:'button',
                                                                             text:'Y',
                                                                            handler:function()
                                                                                    {
                                                                                        filtroUsuario[filtroUsuario.length]='Y';
                                                                                        filtroMysql[filtroMysql.length]='AND';
                                                                                        generarSentencia();
                                                                                    }
                                                                         }
                                                                    ]
                                                        },
                                                        {
                                                            xtype:'panel',
                                                            x:300,
                                                            y:80,
                                                            baseCls: 'x-plain',
                                                            items:	[
                                                                         {
                                                                             xtype:'button',
                                                                             text:'O',
                                                                             handler:function()
                                                                                    {
                                                                                        filtroUsuario[filtroUsuario.length]='O';
                                                                                        filtroMysql[filtroMysql.length]='OR';
                                                                                        generarSentencia();
                                                                                    }
                                                                         }
                                                                    ]
                                                        },
                                                        {
                                                            id:'txtConsulta',
                                                            xtype:'textarea',
                                                            x:10,
                                                            y:125,
                                                            width:500,
                                                            height:150,
                                                            readOnly:true
                                                        }
                                                    ]
                                        }
                                    );

		
	var ventanaOrigenDatosSel = new Ext.Window(
											{
												title: 'Ingrese su condición de filtrado',
												width: 550,
												height:350,
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
                                                                                            function funcAjax()
                                                                                            {
                                                                                                var resp=peticion_http.responseText;
                                                                                                arrResp=resp.split('|');
                                                                                                if(arrResp[0]=='1')
                                                                                                {
                                                                                                 
                                                                                                 	var x;
                                                                                                    var token;
                                                                                                    var arrTokens='';
                                                                                                    for(x=0;x<filtroUsuario.length;x++)
                                                                                                    {
                                                                                                    	token='{"tokenUsuario":"'+cv(filtroUsuario[x])+'","tokenMysql":"'+cv(filtroMysql[x])+'"}';
                                                                                                        if(arrTokens=='')
                                                                                                        	arrTokens=token;
                                                                                                        else
                                                                                                        	arrTokens+=','+token;
                                                                                                    }
                                                                                                    objFinal+=',"tokenSql":['+arrTokens+']';
                                                                                                    objFinal="{"+objFinal+"}";
                                                                                                    
                                                                                                    h.objControl=objFinal;
                                                                                                    ventanaOrigenDatosSel.close();
                                                                                                }
                                                                                                else
                                                                                                {
                                                                                                    msgBox('La consulta ingresada presenta errores de sintaxis, por favor verifiquela');
                                                                                                    return;
                                                                                                }
                                                                                            }
                                                                                            obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=27&tb='+nomTabla+'&qry='+sentenciaMysql,true);
                                                                                            
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
                                        
	cargarCamposTabla(ventanaOrigenDatosSel,objFinal);
}

function cargarCamposTabla(ventana,objFinal)
{
	var obj=eval('[{'+objFinal+'}]');
	var nTabla=obj[0].objTablaConf.tabla;
    
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	 var arr=arrResp[2];
             var objArr=eval(arr);
             var cmbCampo=Ext.getCmp('cmbCampo');
             var dSet=cmbCampo.getStore();
             dSet.loadData(objArr);
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=25&nomTabla='+nTabla,true);
	ventana.show();
}

function crearComboCampos()
{
	var tEntradas=[];
	dsDatosCampos= new Ext.data.SimpleStore	(
													{
														fields:	[
																	{name:'id'},
																	{name:'tipo'}
																]
													}
												);
	dsDatosCampos.loadData(tEntradas);
	var comboDatos=document.createElement('select');
	var cmbDatos=new Ext.form.ComboBox	(
													{
														x:115,
														y:340,
														id:'idCmbCampo',
														mode:'local',
														emptyText:'<?php echo $etj["lblElijaOpcion"] ?>',
														store:dsDatosCampos,
														displayField:'tipo',
														valueField:'id',
														transform:comboDatos,
														editable:false,
														typeAhead: true,
														triggerAction: 'all',
														lazyRender:true,
														minListWidth:200
													}
												)
	return cmbDatos;	
}

function mostrarVentanaPreguntasOpciones()
{

	idOrigenD=14;
	var opcion1=new Ext.form.Radio	(
                                            {
                                                id:'opcion1',
                                                name:'origenD',
                                                value:14,
                                                boxLabel:'Opciones ingresadas manualmente por m&iacute;',
                                                x:40,
                                                y:45,
                                                checked:true
                                            }
                                        );
                                        
	opcion1.on('check',opcionClick);                                        
	var opcion2= new Ext.form.Radio	(
                                            {
                                                id:'opcion2',
                                                name:'origenD',
                                                value:15,
                                                boxLabel:'Opciones generadas en un intervalo de n&uacute;meros',
                                                x:40,
                                                y:75
                                            }
                                        );
	opcion2.on('check',opcionClick);                                            
	var opcion3=new Ext.form.Radio	(
                                            {
                                                id:'opcion3',
                                                name:'origenD',
                                                value:16,
                                                boxLabel:'Opciones tomadas de un almac\xE9n de datos',
                                                x:40,
                                                y:105
                                            }
                                        );   
	opcion3.on('check',opcionClick);                                            
    
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
                                                                    text:'Por favor seleccione el origen de datos de su control de selecci&oacute;n:'
                                                                },
                                                    			opcion1,
                                                                opcion2,
                                                                opcion3
                                                    			
                                                    		]
												}
											);
		
	ventanaOrigenDatosSel = new Ext.Window(
											{
												title: 'Origen de datos del control de selecci&oacute;n',
												width: 450,
												height:250,
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
																	text: 'Siguiente >>',
																	listeners:	{
																					click:function()
																						{
																							ventanaOrigenDatosSel.hide();
                                                                                            switch(idOrigenD)
                                                                                            {
                                                                                            	case 14:
                                                                                                	
                                                                                                	mostrarVEntCerrada(idOrigenD);
                                                                                                break;
                                                                                                case 15:
                                                                                                	mostrarVIntervalo(idOrigenD);
                                                                                                break;
                                                                                                case 16:
                                                                                                	mostrarVentanaSelAlmacenDatos(1,0,16);
                                                                                                break;
                                                                                           
                                                                                            }
																							
																							
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

function mostrarVentanaPreguntasOpcionesMultiples()
{

	idOrigenD=17;
	var opcion1=new Ext.form.Radio	(
                                            {
                                                id:'opcion1',
                                                name:'origenD',
                                                value:17,
                                                boxLabel:'Opciones ingresadas manualmente por m&iacute;',
                                                x:40,
                                                y:45,
                                                checked:true
                                            }
                                        );
                                        
	opcion1.on('check',opcionClick);                                        
	var opcion2= new Ext.form.Radio	(
                                            {
                                                id:'opcion2',
                                                name:'origenD',
                                                value:18,
                                                boxLabel:'Opciones generadas en un intervalo de n&uacute;meros',
                                                x:40,
                                                y:75
                                            }
                                        );
	opcion2.on('check',opcionClick);                                            
	var opcion3=new Ext.form.Radio	(
                                            {
                                                id:'opcion3',
                                                name:'origenD',
                                                value:19,
                                                boxLabel:'Opciones tomadas de un almac\xE9n de datos',
                                                x:40,
                                                y:105
                                            }
                                        );   
	opcion3.on('check',opcionClick);     
    
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
                                                                    text:'Por favor seleccione el origen de datos de su control de selecci&oacute;n:'
                                                                },
                                                    			opcion1,
                                                                opcion2,
                                                                opcion3
                                                    			
                                                    		]
												}
											);
		
	ventanaOrigenDatosSel = new Ext.Window(
											{
												title: 'Origen de datos del control de selecci&oacute;n',
												width: 450,
												height:250,
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
																	text: 'Siguiente >>',
																	listeners:	{
																					click:function()
																						{
																							ventanaOrigenDatosSel.hide();
                                                                                            switch(idOrigenD)
                                                                                            {
                                                                                            	case 17:
                                                                                                	mostrarVEntCerrada(idOrigenD);
                                                                                                break;
                                                                                                case 18:
                                                                                                	mostrarVIntervalo(idOrigenD);
                                                                                                break;
                                                                                                case 19:
                                                                                                	mostrarVentanaSelAlmacenDatos(1,0,19);
                                                                                                break;
                                                                                            }
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

function modificarOpcionesManuales(idElemento)
{
	
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
                                                            header:'Valor opci&oacute;n',
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
                                                            clicksToEdit: 2,
                                                            cm: cmFrmDTD,
                                                            height:300,
                                                            width:<?php echo $ancho+35 ?>,
                                                            title:'Escriba la opci&oacute;n a presentar en cada uno de los idiomas:',
                                                            tbar: [
                                                                    {
                                                                        text: 'Agregar opci&oacute;n',
                                                                        icon:'../images/add.png',
                                                                        cls:'x-btn-text-icon',
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
                                                                        text:'Eliminar opci&oacute;n',
                                                                        icon:'../images/delete.png',
                                                                        cls:'x-btn-text-icon',
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
                                                                                        msgConfirm('¿Est&aacute; seguro de querer eliminar esta registro?',funcConfirmDel);
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                        msgBox('Primero debe elegir una fila o elemento');
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
                msgBox('El valor ingresado, ya esta siendo ocupado por otra opci&oacute;n',funcOK);
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
                                        text: 'Finalizar',
                                        minWidth:80,
                                        id:'btnFinalizarPCerradas',
                                        listeners:	{
                                                        click:
                                                                {
                                                                    fn:function()
                                                                    {
                                                                        if(btnSiguiente.getText()!='Finalizar')
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
                                                                                var opciones=obtenerValoresOpcionesManuales();
                                                                               	var objFinal='{"opciones":'+opciones+'}';
                                                                                
                                                                                function funcAjax()
                                                                                {
                                                                                    var resp=peticion_http.responseText;
                                                                                    arrResp=resp.split('|');
                                                                                    if(arrResp[0]=='1')
                                                                                    {
                                                                                    	var arrDatos=eval(arrResp[1]);
                                                                                        var div=h.gE('div_'+idElemento);
                                                                                        var controlI=div.getAttribute('controlInterno');
                                                                                        var arrDatosCtrl=controlI.split('_');
                                                                                        var nControl='_'+arrDatosCtrl[1];
                                                                                        var control=h.gE(nControl);
                                                                                        switch(arrDatosCtrl[2])
                                                                                        {
                                                                                        	case '2':
                                                                                                llenarCombo(control,arrDatos,true);
                                                                                            break;
                                                                                            case '14':
                                                                                            case '17':
                                                                                            	var listaElementos=h.gE('lista'+nControl);
                                                                                            	listaElementos.value=arrResp[1];
                                                                                                generarTablaOpcionesCombo(idElemento);
                                                                                            break;
                                                                                           

                                                                                        }
                                                                                      	gEx('ventanaPregCerradas').close();
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                    }
                                                                                }
                                                                                obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=67&idElemento='+idElemento+'&obj='+objFinal,true);
                                                                                
                                                                               
                                                                            }
                                                                        }
                                                                        
                                                                    }
                                                                }
                                                    }
                                    }
                                )
    
    ventanaPregCerradas = new Ext.Window(
                                            {
                                            	id:'ventanaPregCerradas',
                                                title: 'Opciones posibles',
                                                width: <?php echo ($ancho+65) ?> ,
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
	
	cargarOpcionesElemento(idElemento,ventanaPregCerradas);
}

function cargarOpcionesElemento(idElemento,ventanaPregCerradas)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var arrDatos=eval(arrResp[1]);
            gEx('gridOpcionesManuales').getStore().loadData(arrDatos);
            ventanaPregCerradas.show();
            
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=66&idElemento='+idElemento,true);
}

function generarTablaOpcionesCombo(idElemento)
{
	var div=h.gE('div_'+idElemento);
    var controlI=div.getAttribute('controlInterno');
    var arrDatosCtrl=controlI.split('_');
    var nameControl='_'+arrDatosCtrl[1];
    var control=h.gE(nameControl);
	var listaElementos=h.gE('lista'+nameControl);
    var arrElementosSel=listaElementos.value;
    var arrOpc=eval(arrElementosSel);
    var anchoCol=h.gE('anchoCelda'+nameControl).value;
    var numCol=h.gE('numCol'+nameControl).value
    
    var defaultOpt='';
    var ctrlDefault=h.gE('default'+nameControl);
    if(ctrlDefault!=null)
    	defaultOpt=ctrlDefault.value;
    
    var span=document.createElement('span');
    var spanDel=h.gE('span'+nameControl);
    var padre=spanDel.parentNode;
    padre.removeChild(spanDel);
    var tablaCtrl=h.crearTabla(numCol,arrElementosSel,parseInt(arrDatosCtrl[2]),nameControl,anchoCol);
    span.id='span'+nameControl;
    span.appendChild(tablaCtrl);
    padre.appendChild(span);
    if((defaultOpt!='')&&(defaultOpt!='100584'))
    	h.gE('opt'+nameControl+'_'+defaultOpt).checked=true;
}

function mostrarModificarIntervalo(idElemento)
{
	

	var form = new Ext.form.FormPanel(	
												{
													baseCls: 'x-plain',
													layout:'absolute',
													defaultType: 'textfield',
													items: 	[
                                                    			{
                                                                	x:5,
                                                                    y:10,
                                                                	xtype:'label',
                                                                    text:'Valor inicial:'
                                                                },
                                                                {
                                                                	x:140,
                                                                    y:5,
                                                                    xtype:'numberfield',
                                                                    id:'txtInicio',
                                                                    allowDecimals:true,
                                                                    width:100
                                                                },
                                                                {
                                                                	x:5,
                                                                    y:40,
                                                                	xtype:'label',
                                                                    text:'Valor final:'
                                                                },
                                                                {
                                                                	x:140,
                                                                    y:35,
                                                                    xtype:'numberfield',
                                                                    id:'txtFin',
                                                                    allowDecimals:true,
                                                                    width:100
                                                                },
                                                                {
                                                                	x:5,
                                                                    y:70,
                                                                	xtype:'label',
                                                                    text:'Espaciado entre valores de:'
                                                                },
                                                                {
                                                                	x:187,
                                                                    y:65,
                                                                    xtype:'numberfield',
                                                                    id:'txtIncremento',
                                                                    value:'1',
                                                                    width:80,
                                                                    allowDecimals:true,
                                                                    width:100
                                                                }
                                                    		]
												}
											);
		
	ventanaIntervalo = new Ext.Window(
											{
                                            	id:'ventanaIntervalo',
												title: 'Configuraci&oacute;n de intervalos',
												width: 340,
												height:200,
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
																			
																		}
																	}
														},
												buttons:	[
																{
																	id:'btnAceptar',
																	text: 'Finalizar',
																	listeners:	{
																					click:function()
																						{
																							
																							var inicio=Ext.getCmp('txtInicio').getRawValue();
																						    var final=Ext.getCmp('txtFin').getRawValue();
                                                                                            var incremento=Ext.getCmp('txtIncremento').getRawValue();
                                                                                            
                                                                                            if(!esEntero(inicio))
                                                                                            {
                                                                                            	function resp2()
                                                                                                {
                                                                                                	Ext.getCmp('txtInicio').focus();
                                                                                                }
                                                                                                msgBox('El valor ingresado no es v&aacute;lido',resp2);
                                                                                                return;
                                                                                            }
                                                                                            if(!esEntero(final))
                                                                                            {
                                                                                            	function resp3()
                                                                                                {
                                                                                                	Ext.getCmp('txtFin').focus();
                                                                                                }
                                                                                                msgBox('El valor ingresado no es v&aacute;lido',resp3);
                                                                                                return;
                                                                                            }
                                                                                            if(!esEntero(incremento))
                                                                                            {
                                                                                            	function resp4()
                                                                                                {
                                                                                                	Ext.getCmp('txtIncremento').focus();
                                                                                                }
                                                                                                msgBox('El valor ingresado no es v&aacute;lido',resp4);
                                                                                                return;
                                                                                            }
                                                                                            var objIntervalo='{"inicio":"'+inicio+'","fin":"'+final+'","intervalo":"'+incremento+'"}';
                                                                                             function funcAjax()
                                                                                            {
                                                                                                var resp=peticion_http.responseText;
                                                                                                arrResp=resp.split('|');
                                                                                                if(arrResp[0]=='1')
                                                                                                {
                                                                                                    var arrDatos=eval(arrResp[1]);
                                                                                                    var div=h.gE('div_'+idElemento);
                                                                                                    var controlI=div.getAttribute('controlInterno');
                                                                                                    var arrDatosCtrl=controlI.split('_');
                                                                                                    var nControl='_'+arrDatosCtrl[1];
                                                                                                    var control=h.gE(nControl);
                                                                                                    switch(arrDatosCtrl[2])
                                                                                                    {
                                                                                                        case '3':
                                                                                                            llenarCombo(control,arrDatos,true);
                                                                                                        break;
                                                                                                        case '15':
                                                                                                        case '18':
                                                                                                            var listaElementos=h.gE('lista'+nControl);
                                                                                                            listaElementos.value=arrResp[1];
                                                                                                            generarTablaOpcionesCombo(idElemento);
                                                                                                        break;
                                                                                                       
            
                                                                                                    }
                                                                                                    gEx('ventanaIntervalo').close();
                                                                                                }
                                                                                                else
                                                                                                {
                                                                                                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                }
                                                                                            }
                                                                                            obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=69&idElemento='+idElemento+'&obj='+objIntervalo,true);
                                                                                
                                                                                            
                                                                                            
																						}
																				}
																},
																{
																	text: '<?php echo $etj["lblBtnCancelar"]?>',
																	handler:function()
																			{
																				ventanaIntervalo.close();
																			}
																}
															]
											}
										);
	llenarDatosIntervalo(ventanaIntervalo,idElemento);

}

function llenarDatosIntervalo(ventana,idElemento)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var obj=eval(arrResp[1])[0];
            gEx('txtInicio').setValue(obj.inicio);
            gEx('txtFin').setValue(obj.fin);
            gEx('txtIncremento').setValue(obj.intervalo);
            ventana.show();
            
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=68&idElemento='+idElemento,true);
}

function mostrarVentanaSelAlmacenDatos(tipoAlmacen,autocompletar,tElemento)
{
	var gridAlmacenDatos=crearAlmacenDatos();
    var arrAlmacenes=obtenerAlmacenesDatosDisponibles(tipoAlmacen);
    gridAlmacenDatos.getStore().loadData(arrAlmacenes);
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	xtype:'label',
                                                            x:10,
                                                            y:10,
                                                            html:'Elija el almac&eacute;n de datos a utlizar:'
                                                        },
														gridAlmacenDatos

													]
										}
									);
	var ventanaAM = new Ext.Window(
									{
										title: 'Selecci&oacute;n de almac&eacute;n de datos',
										width: 410,
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
															
															text: 'Siguiente >>',
															handler: function()
																	{
                                                                    	var obj={};
                                                                        var fila=gridAlmacenDatos.getSelectionModel().getSelected();
                                                                        if(fila==null)
                                                                        {
                                                                        	msgBox('Debe seleccionar el almac&eacute;n de datos con el cual desea vincular el control');
                                                                            return;
                                                                        }
                                                                        arrCampos=obtenerCamposDisponibles(fila.get('idAlmacen'));
                                                                        
                                                                        obj.campos=arrCampos;
                                                                        obj.idAlmacen=fila.get('idAlmacen');
                                                                        obj.tipoElemento=tElemento;
                                                                        obj.auto=autocompletar;
                                                                        mostrarVentanaSelColumnaCombo(obj);
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

function crearAlmacenDatos()
{
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                {
                                                    fields:	[
                                                                {name: 'idAlmacen'},
                                                                {name: 'almacen'}
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
															header:'Almac&eacute;n de datos',
															width:300,
															sortable:true,
															dataIndex:'almacen'
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            
                                                            store:alDatos,
                                                            frame:true,
                                                            y:40,
                                                            cm: cModelo,
                                                            height:290,
                                                            width:380,
                                                            sm:chkRow
                                                        }
                                                    );
	return 	tblGrid;
}

function mostrarVentanaFrase()
{
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'textfield',
											items: 	[
														{
                                                        	xtype:'label',
                                                            html:'Frase:',
                                                            x:10,
                                                            y:10
                                                        },
                                                        {
                                                        	id:'txtFrase',
                                                            x:70,
                                                            y:5,
                                                            width:280
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar frase',
										width: 400,
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
                                                                	Ext.getCmp('txtFrase').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
																		var frase=Ext.getCmp('txtFrase').getValue();
                                                                        if(frase=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	Ext.getCmp('txtFrase').focus();
                                                                            }
                                                                        	msgBox('Debe ingresar la frase a insertar',resp);
                                                                        }
                                                                        listUsuario.push(frase);
                                                                        listApp.push("'"+frase+"'");
                                                                        actualizarVistaOpcion();
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

function modificarOpcionesAlmacen(obj)
{
	
	var autocompletar;
    var arrTipoCombo=[['0','Normal'],['2','Selecci\xF3n m\xFAltiple'],['1','Autocompletable']];
	listUsuario=new Array();
	listApp=new Array();
    arrCampo=null;
	var cmbCampoLlave=crearComboExt('cmbCampoLlave',[],135,135,370);
    
    var cmbCampoTooltip=crearComboExt('cmbCampoTooltip',[],135,165,370);
    
    var cmbTipoCombo=crearComboExt('cmbTipoCombo',arrTipoCombo,135,195);
    cmbTipoCombo.on('select',	function(combo,registro)
    							{
                                	if(registro.get('id')!='1')
                                    {
                                    	gEx('cmbCampoBusqueda').setValue('');
                                    	gEx('cmbCampoBusqueda').hide();
                                        gEx('lblCampoBusqueda').hide();
                                    }
                                    else
                                    {
                                    	gEx('cmbCampoBusqueda').show();
                                        gEx('lblCampoBusqueda').show();
                                    }
                                }
    				)
    var cmbCampoBusqueda=crearComboExt('cmbCampoBusqueda',[],135,225,370);
    var lblBtn='Finalizar';
    var comboSiNo=crearComboExt('idComboSiNo',arrSiNo,140,35,120);
    comboSiNo.setValue('0');
    var txtNombreCampo=new Ext.form.TextField	(
                                                  {
                                                      id:'txtNombreCampo',
                                                      x:140,
                                                      y:5,
                                                      width:160,
                                                      hideLabel:true,
                                                      maskRe:/^[a-zA-Z0-9]$/
                                                  }
                                              )
    var valorOculto=false;
    var arrControles=[
    					{
                            xtype:'label',
                            x:5,
                            y:10,
                            html:'Configure el texto a mostrar como opci&oacute;n:'
                        }
                        ,
                        {
                            xtype:'panel',
                            x:20,
                            y:40,
                            height:100,
                            width:400,
                            baseCls: 'x-plain',
                            items:	[
                                        {
                                            xtype:'button',
                                            icon:'../images/add.png',
                                            tooltip:'Agregar campo',
                                            handler:function()
                                                    {
                                                    	console.log(obj.arrCampos);
                                                        mostrarVentanaSelCampoCombo(obj.arrCampos);
                                                    }
                                        }
                                    ]
                        },
                        {
                            xtype:'panel',
                            x:45,
                            y:40,
                            height:100,
                            width:400,
                            baseCls: 'x-plain',
                            items:	[
                                        {
                                            xtype:'button',
                                            icon:'../images/font_add.png',
                                            tooltip:'Agregar frase',
                                            handler:function()
                                                    {
                                                        mostrarVentanaFrase();
                                                    }
                                        }
                                    ]
                        },
                        {
                            xtype:'panel',
                            x:70,
                            y:40,
                            height:100,
                            width:400,
                            baseCls: 'x-plain',
                            items:	[
                                        {
                                            xtype:'button',
                                            icon:'../images/espacio.png',
                                            tooltip:'Agregar espacio en blanco',
                                            handler:function()
                                                    {
                                                        listUsuario.push('\' \'');
                                                        listApp.push('\' \'');
                                                        actualizarVistaOpcion();
                                                    }
                                        }
                                    ]
                        },
                        {
                            xtype:'panel',
                            x:95,
                            y:40,
                            height:100,
                            width:400,
                            baseCls: 'x-plain',
                            items:	[
                                        {
                                            xtype:'button',
                                            icon:'../images/delete.png',
                                            tooltip:'Remover elemento',
                                            handler:function()
                                                    {
                                                        listUsuario.pop();
                                                        listApp.pop();
                                                        actualizarVistaOpcion();
                                                    }
                                                    
                                        }
                                    ]
                        },
                        {
                        
                            id:'txtVistaElemento',
                            xtype:'textarea',
                            x:20,
                            y:70,
                            width:500,
                            height:50,
                            readOnly:true
                        },
                        {
                            x:5,
                            y:140,
                            xtype:'label',
                            html:'Campo ID:'
                        },
                        cmbCampoLlave,
                        {
                            x:5,
                            y:170,
                            xtype:'label',
                            html:'Campo tooltip:'
                        },
                        cmbCampoTooltip
                        
                    ]
    if(obj.tipoElemento=='4')
    {
    	arrControles.push({
                        	x:5,
                            y:'200',
                            xtype:'label',
                            html:'Tipo de combo:'
                        })
		arrControles.push(cmbTipoCombo);
        
        arrControles.push(	{
                                x:5,
                                y:230,
                                xtype:'label',
                                id:'lblCampoBusqueda',
                                html:'Campo de b&uacute;squeda:'
                            }
                         );
        arrControles.push(cmbCampoBusqueda);
        
    
    }
	
                                                                                
    
    var form = new Ext.form.FormPanel(	
                                            {
                                                baseCls: 'x-plain',
                                                layout:'absolute',
                                                defaultType: 'textfield',
                                                items: 	arrControles
                                            }
                                        );
    
    btnSiguiente=new Ext.Button	(
                                    {
                                        text: lblBtn,
                                        minWidth:80,
                                        id:'btnFinalizar',
                                        listeners:	{
                                                        click:
                                                                {
                                                                    fn:function()
                                                                    {
                                                                        if(listApp.length==0)
                                                                        {
                                                                        	msgBox('Al menos debe seleccionar un campo para proyectar como texto de la opci&oacute;n');
                                                                        	return;
                                                                        }
                                                                        var x;
                                                                        var nomColumn='';
                                                                        for(x=0;x<listApp.length;x++)
                                                                        {
                                                                        	if(nomColumn=='')
                                                                        		nomColumn=listApp[x];
                                                                            else
                                                                            	nomColumn+='@@'+listApp[x];
                                                                        }
                                                                        
                                                                        var cLlave=cmbCampoLlave.getValue();
                                                                        if(cLlave=='')
                                                                        {
                                                                        	msgBox('Debe seleccionar el campo ID que identificara de manera unica a cada una de sus opciones');
                                                                        	return;
                                                                        }
                                                                        /*var nodoMysql=buscarNodoID(gEx('arbolDataSet').getRootNode(),cLlave);
                                                                        
                                                                        if(nodoMysql.nCampo!=undefined)
                                                                        	cLlave=nodoMysql.nCampo;
                                                                        else
                                                                        	cLlave=nodoMysql.attributes.nCampo;*/
                                                                            
                                                                        
                                                                        cBusqueda='';
                                                                        var autocompletar='0';
                                                                        if(obj.tipoElemento=='4')
                                                                        {
                                                                            if(cmbTipoCombo.getValue()=='1')
                                                                            {
                                                                            	var campoBusqueda=gEx('cmbCampoBusqueda').getValue();
                                                                                if(campoBusqueda=='')
                                                                                {
                                                                                    function resp1()
                                                                                    {
                                                                                        gEx('cmbCampoBusqueda').focus();
                                                                                    }
                                                                                    msgBox('Debe indicar el campo sobre el cual se llevar&aacute; a cabo la b&uacute;squeda',resp1);
                                                                                    return;
                                                                                }
                                                                            	autocompletar='1';
                                                                            	var cmbCampoBusqueda=Ext.getCmp('cmbCampoBusqueda');
                                                                                if(cmbCampoBusqueda!=null)
                                                                                {
                                                                                    cBusqueda=cmbCampoBusqueda.getValue();
                                                                                    /*nodoMysql=buscarNodoID(gEx('arbolDataSet').getRootNode(),cBusqueda);
                                                                                
                                                                                    if(nodoMysql.nCampo!=undefined)
                                                                                        cBusqueda=nodoMysql.nCampo;
                                                                                    else
                                                                                        cBusqueda=nodoMysql.attributes.nCampo;*/
                                                                                    
                                                                                }
                                                                            }
                                                                            
                                                                            if(cmbTipoCombo.getValue()=='2')
                                                                            {
                                                                            	
                                                                            	autocompletar='2';
                                                                            }
                                                                        }
                                                                        
                                                                        var cTooltip=gEx('cmbCampoTooltip').getValue();
                                                                        
                                                                        var objTablaConf='{"cTooltip":"'+cTooltip+'","tipoElemento":"'+obj.tipoElemento+'","idElemento":"'+obj.idElemento+'","columna":"'+cv(nomColumn)+'","cLlave":"'+cLlave+'","autocompletar":"'+autocompletar+'","cBusqueda":"'+cBusqueda+'"}';
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	
                                                                            	gEx('ventanaSelCol').close();
                                                                                establecerFuenteVacia();
                                                                            	h.recargarPagina();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=71&cadObj='+objTablaConf,true);
                                                                        
                                                                    }
                                                                }
                                                    }
                                    }
                                )
    
    ventanaSelCol = new Ext.Window(
                                            {
                                            	id:'ventanaSelCol',
                                                title: 'Selecci&oacute;n de columna que ser&aacute; la fuente de datos',
                                                width: 600 ,
                                                height:340,
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
                                                          			    	Ext.getCmp('txtNombreCampo').focus(false,10);              
                                                                        }
                                                                    }
                                                        },
                                                buttons:	[
                                                                btnSiguiente,
                                                                {
                                                                    text: '<?php echo $etj["lblBtnCancelar"] ?>',
                                                                    handler:function()
                                                                    {
                                                                    	
                                                                        ventanaSelCol.close();
                                                                    }
                                                                }
                                                            ]
                                            }
                                        );
	obtenerConfiguracionAlmacenDatos(ventanaSelCol,obj);                                        	

}

function obtenerConfiguracionAlmacenDatos(ventana,obj)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var objAux=eval(arrResp[1])[0];
            listUsuario=objAux.camposProy.listUsuario;
            listApp=objAux.camposProy.listApp;
            actualizarVistaOpcion();
            obj.arrCampos=obtenerCamposDisponibles(objAux.idAlmacen,true);

            gEx('cmbCampoLlave').getStore().loadData(obj.arrCampos);
            var arrToolTipo=obj.arrCampos.slice();
            arrToolTipo.splice(0,0,['','Ninguno']);
            gEx('cmbCampoTooltip').getStore().loadData(arrToolTipo);
            gEx('cmbCampoBusqueda').getStore().loadData(obj.arrCampos);
            
            
            
            var campId;
            var arrCampoID;
           
            
            if(obj.tipoElemento=='4')
            {
           		gEx('cmbTipoCombo').setValue(objAux.autoCompletable);
                if(objAux.autoCompletable!='1')
                {
                	gEx('cmbCampoBusqueda').hide();
                    gEx('lblCampoBusqueda').hide();
                }
                else
                {
                	var pos2=existeValorMatriz(obj.arrCampos,objAux.campoBusqueda,0);
                    if(pos2!=-1)
			            gEx('cmbCampoBusqueda').setValue(obj.arrCampos[pos2][0]);
                }
            }
            
            
            
            var pos=existeValorMatriz(obj.arrCampos,objAux.columnaId,0);
            if(pos!=-1)
	            gEx('cmbCampoLlave').setValue(obj.arrCampos[pos][0]);
                
            pos=existeValorMatriz(arrToolTipo,objAux.columnaTooltip,0);
            if(pos!=-1)
	            gEx('cmbCampoTooltip').setValue(arrToolTipo[pos][0]); 
            else  
            	gEx('cmbCampoTooltip').setValue(''); 
                
        	ventana.show();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=70&idElemento='+obj.idElemento,true);
}