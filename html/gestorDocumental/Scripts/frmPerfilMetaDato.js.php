<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");

	$arrMetaDatos="";
	$consulta="SELECT idMetaDato,cveMetaDato,nombreMetaDato,metodoResolucion,tipoDatoEntrada,funcionSistema,fuenteDatos FROM 20003_catalogoMetaDatos";
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_assoc($res))
	{
		$lblDetalle="Tipo de Entrada: ";
		switch($fila["metodoResolucion"])
		{
			case 0:
				$lblDetalle="Campo Abierto";
				switch($fila["tipoDatoEntrada"])
				{
					case 6:
						$lblDetalle.=" (Texto Corto)";
					break;
					case 1:
						$lblDetalle.=" (Texto Largo)";
					break;
					case 2:
						$lblDetalle.=" (Entero)";
					break;
					case 3:
						$lblDetalle.=" (Decimal)";
					break;
					case 4:
						$lblDetalle.=" (Moneda)";
					break;
					case 5:
						$lblDetalle.=" (Fecha)";
					break;
					
				}
			break;
			case 1:
				$lblDetalle="Mediante Funci&oacute;n de Sistema";
				$consulta="SELECT nombreConsulta FROM 991_consultasSql WHERE idConsulta=".$fila["funcionSistema"];
				$lblFuncion=$con->obtenerValor($consulta);
				$lblDetalle.=" (".$lblFuncion.")";
			break;
			case 2:
				$lblDetalle="Opciones Cerradas (Combo)";
				
			break;	
		}
		
		
		$o="['".$fila["idMetaDato"]."','[".cv($fila["cveMetaDato"]."] ".$fila["nombreMetaDato"])."','".cv($lblDetalle)."']";
		if($arrMetaDatos=="")
			$arrMetaDatos=$o;
		else
			$arrMetaDatos.=",".$o;
	}
	
	$arrMetaDatos='['.$arrMetaDatos.']';
	
	$consulta="SELECT valor,texto FROM 1004_siNo";
	$arrSiNo=$con->obtenerFilasArreglo($consulta);
?>
var arrSiNo=<?php echo $arrSiNo?>;
var arrMetaDatosGlobal=<?php echo $arrMetaDatos?>;
Ext.onReady(inicializar);

function inicializar()
{
	new Ext.Button (
                                {
                                    cls:'btnSIUGJ',
                                    text:'Guardar',
                                    width:150,
                                    height:50,
                                    id:'btnGuardarForm',
                                    renderTo:'contenedor1',
                                    handler:function()
                                            {
                                                validarFrm('frmEnvio')
                                            }
                                    
                                }
                            )
	
    
    new Ext.Button (
                                {
                                    cls:'btnSIUGJCancel',
                                    text:'Cancelar',
                                    width:150,
                                    height:50,
                                    id:'btnCancelarForm',
                                    renderTo:'contenedor2',
                                    handler:function()
                                            {
                                            	function  resp(btn)
                                                {
                                                	if(btn=='yes')
                                                    {
                                                    	location.href='../gestorDocumental/tbPerfileslMetaDatos.php';
                                                    }
                                                }
                                                msgConfirm('Est&aacute; seguro de querer cancelar la operaci&oacute;n?',resp)
                                                
                                            }
                                    
                                }
                            )

	
    
    crearGridMetaDatos();
}


function crearGridMetaDatos()
{
	var cmbObligatorio=crearComboExt('cmbObligatorio',arrSiNo,0,0);
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'idMetaDato'},
                                                                    {name: 'obligatorio'}
                                                                ]
                                                    }
                                                );


	var arrMetaDatos=eval(bD(gE('arrMetaDatos').value));

    alDatos.loadData(arrMetaDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel({checkOnly:true,width:40});
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer({width:40}),
														chkRow,
														{
															header:'MetaDato',
															width:250,
															sortable:true,
                                                            dataIndex:'idMetaDato',
                                                            renderer:function(val)
                                                            		{
                                                                    	
                                                                    	return formatearValorRenderer(arrMetaDatosGlobal,val);
                                                                    }
														},
                                                        {
															header:'Obligatorio',
															width:160,
															sortable:true,
                                                            dataIndex:'obligatorio',
                                                            editor:cmbObligatorio,
                                                            renderer:function(val)
                                                            		{
                                                                    	
                                                                    	return formatearValorRenderer(arrSiNo,val);
                                                                    }
														},
														{
															header:'Detalles',
															width:350,
															sortable:true,
                                                            dataIndex:'idMetaDato',
                                                            renderer:function(val,meta,registro)
                                                            		{

                                                                    	return formatearValorRenderer(arrMetaDatosGlobal,val,2);
                                                                    }
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gMetaDatos',
                                                            store:alDatos,
                                                            frame:false,
                                                           	renderTo:'lblOpciones',
                                                            cm: cModelo,
                                                            clicksToEdit:1,
                                                            loadMask:true,
                                                            stripeRows :false,
                                                            columnLines : false,
                                                           	cls:'gridSiugjPrincipal',
                                                            height:240,
                                                            width:860,
                                                            sm:chkRow,
                                                            tbar:	[
                                                            			{
                                                                        	icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Agregar MetaDato',
                                                                            handler:function()
                                                                            		{
                                                                                    	mostrarVentanaAgregarMetaDato();
                                                                                    }
                                                                            
                                                                        },'-',
                                                                        {
                                                                        	icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Remover Opción',
                                                                            handler:function()
                                                                            		{
                                                                                    	var fila=gEx('gMetaDatos').getSelectionModel().getSelected();
                                                                                        if(!fila)
                                                                                        {
                                                                                        	msgBox('Debe seleccinar el metaDato que desea remover');
                                                                                        	return;
                                                                                        }
                                                                                        
                                                                                        function resp(btn)
                                                                                        {
                                                                                        	gEx('gMetaDatos').getStore().remove(fila);
                                                                                        }
                                                                                        msgConfirm('Est&aacute; seguro de querer remover el metaDato seleccionado?',resp);
                                                                                        
                                                                                    }
                                                                            
                                                                        }
                                                                        
                                                            		]
                                                        }
                                                    );
	return 	tblGrid;	
}


function validarFrm()
{
	if(validarFormularios('frmEnvio'))
    {
    
    	var objArr='';
        
        var x=0;
        var gMetaDatos=gEx('gMetaDatos');
        var fila;
        var o;
        for(x=0;x<gMetaDatos.getStore().getCount();x++)
        {
        	fila=gMetaDatos.getStore().getAt(x);
            o='{"idMetaDato":"'+fila.data.idMetaDato+'","obligatorio":"'+fila.data.obligatorio+'"}';
            
            
            if(objArr=='')
            	objArr=o;
            else
            	objArr+=','+o;
            
            
        }
        
        objArr='{"registros":['+objArr+']}';
        var id=gE('id').value;
        if(id=='-1')
        {
        	gE('funcPHPEjecutarNuevo').value=bE('asociarMetaDatoPerfil(@idRegPadre,\''+bE(objArr)+'\')');
        }
        else
        {
        	gE('funcPHPEjecutarModif').value=bE('asociarMetaDatoPerfil('+id+',\''+bE(objArr)+'\')');
        }
    
    	gE('frmEnvio').submit();
    }
}

function abrirVentanaFuncion(tipo)
{
	mostrarVentanaExpresion(	function(fila,ventana)
    							{
                                	gE('txtFuncionSistema').value=fila.get('nombreConsulta');
                                    gE('_funcionSistemavch').value=fila.get('idConsulta');
                                    ventana.close();
                            	}
    							,true
                          );
}

function removerFuncion(tipo)
{
	gE('txtFuncionSistema').value='';
    gE('_funcionSistemavch').value='';
}


function metodoSeleccionChange(cmb)
{
	oE('fila_1');
    gE('_tipoDatoEntradaint').setAttribute('val','');
    oE('fila_2');
    gE('_fuenteDatosint').setAttribute('val','');
    oE('fila_3');
    gE('_funcionSistemavch').setAttribute('val','');
    oE('fila_4');
    
    
    gE('_tipoDatoEntradaint').selectedIndex=0;
    gE('_fuenteDatosint').selectedIndex=0;
    gE('txtFuncionSistema').value='';
    gE('_funcionSistemavch').value='';
    gEx('gOpciones').getStore().removeAll();
    
	var valor=cmb.options[cmb.selectedIndex].value;
    switch(valor)
    {
    	case '0': //Campo Abierto
        	mE('fila_1');
            gE('_tipoDatoEntradaint').setAttribute('val','obl');
        break;
        case '1':  //Mediante funcion de sistema
        	mE('fila_3');
            gE('_funcionSistemavch').setAttribute('val','obl');
        break;
        case '2': //Opciones Cerradas
        	mE('fila_2');
        break;
    }
}


function fuenteDatosChange(cmb)
{
	
    oE('fila_3');
    gE('_funcionSistemavch').setAttribute('val','');
    oE('fila_4');
    
    
    gE('txtFuncionSistema').value='';
    gE('_funcionSistemavch').value='';
    gEx('gOpciones').getStore().removeAll();
    
	var valor=cmb.options[cmb.selectedIndex].value;
    switch(valor)
    {
    	case '0': //Funci&oacute;n de Sistema
        	mE('fila_3');
            gE('_funcionSistemavch').setAttribute('val','obl');
        break;
        case '1':  //Opciones Manuales
        	mE('fila_4');
        break;
       
    }
}


function mostrarVentanaAgregarMetaDato()
{

	var idMetaDato=-1;
	

	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:20,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Indique el metaDato a agregar al perfil:'
                                                        },
                                                        {
                                                            x:370,
                                                            y:15,
                                                            html:'<div id="divComboMetaDato">'
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar MetaDato',
										width: 850,
										height:180,
										layout: 'fit',
										plain:true,
										modal:true,
                                        cls:'msgHistorialSIUGJ',
										bodyStyle:'padding:5px;',
										buttonAlign:'center',
										items: form,
										listeners : {
													show : {
																buffer : 10,
																fn : function() 
																{
                                                                
                                                                	var oConf=	{
                                                                                    idCombo:'cmbMetaDato',
                                                                                    anchoCombo:400,
                                                                                    posX:0,
                                                                                    posY:0,
                                                                                    raiz:'registros',
                                                                                    campoDesplegar:'nombreMetaDato',
                                                                                    campoID:'idMetaDato',
                                                                                    funcionBusqueda:24,
                                                                                    ctCls:'campoComboWrapSIUGJAutocompletar',
                                                                                    listClass:'listComboSIUGJ',
                                                                                    renderTo:'divComboMetaDato',
                                                                                    paginaProcesamiento:'../paginasFunciones/funcionesGestorDocumental.php',
                                                                                    confVista:'<tpl for="."><div class="search-item">{nombreMetaDato}<br>--<br>{detallesAdicionales}</div></tpl>',
                                                                                    campos:	[
                                                                                                {name:'idMetaDato'},
                                                                                                {name:'nombreMetaDato'},
                                                                                                {name:'detallesAdicionales'}
                                                            
                                                                                            ],
                                                                                    funcAntesCarga:function(dSet,combo)
                                                                                                {
                                                                                                    idMetaDato=-1;
                                                                                                    var aValor=combo.getRawValue();
                                                                                                    dSet.baseParams.criterio=aValor;
                                                                                                    dSet.baseParams.funcion=5;
                                                                                                    
                                                                                                                                          
                                                                                                    
                                                                                                },
                                                                                    funcElementoSel:function(combo,registro)
                                                                                                {
                                                                                                    idMetaDato=registro.data.idMetaDato;
                                                                                                    
                                                                                                }  
                                                                                };
                                                            
                                                                	var cmbMetaDato=crearComboExtAutocompletar(oConf);
                                                                
                                                               		cmbMetaDato.focus(false,500);
																}
															}
												},
										buttons:	[
											{
															text: '<?php echo $etj["lblBtnCancelar"]?>',
															cls:'btnSIUGJCancel',
															width:140,
															handler:function()
																	{
																		ventanaAM.close();
																	}
														},
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            cls:'btnSIUGJ',
															width:140,
															handler: function()
																	{
																		if(idMetaDato==-1)
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	cmbMetaDato.focus();
                                                                            }
                                                                            msgBox('Debe indicar el metaDato que desea agregar al perfil',resp);
                                                                        	return;
                                                                        }
                                                                        
                                                                        var iMetaDato=idMetaDato;
                                                                        var pos=obtenerPosFila(gEx('gMetaDatos').getStore(),'idMetaDato',idMetaDato);
                                                                        if(pos==-1)
                                                                        {
                                                                        	var reg=crearRegistro	(
                                                                            							 {name: 'idMetaDato'},
                                                                                                         {name: 'obligatorio'}
                                                                            						);
                                                                        
                                                                        
                                                                        
                                                                        	var r=new reg	(
                                                                            					{
                                                                                                	idMetaDato:iMetaDato,
                                                                                                    obligatorio:'1'
                                                                                                }
                                                                            				)
                                                                        
                                                                        	gEx('gMetaDatos').getStore().add(r);
                                                                        
                                                                        }
                                                                        
                                                                        ventanaAM.close();
																	}
														}
														
													]
									}
								);
	ventanaAM.show();	
}