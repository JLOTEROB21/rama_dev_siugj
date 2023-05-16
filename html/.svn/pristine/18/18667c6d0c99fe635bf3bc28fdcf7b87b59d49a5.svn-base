<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php"); 
	$consulta="select idPais,nombre from 238_paises order by nombre";
	$arrPaises=uEJ($con->obtenerFilasArreglo($consulta));
	$consulta="select codigoCompleto,tituloCentroC from 506_centrosCosto order by tituloCentroC";
	$arrCentroC=uEJ($con->obtenerFilasArreglo($consulta));
?>
var idCodRaiz;
Ext.onReady(inicializar)

function inicializar()
{
	idCodRaiz=gE('idCodRaiz').value;
	crearOrganigrama();
}

var nodoSel=null;

function crearOrganigrama()
{
		var raiz=new  Ext.tree.AsyncTreeNode	(
                                                      {
                                                          id:'-1',
                                                          text:'Raiz',
                                                          draggable:false,
                                                          expanded :true
                                                      }
                                              	)
                                        
		var cargadorArbol=new Ext.tree.TreeLoader(
                                                        {
                                                            baseParams:{
                                                                            funcion:'21'
                                                                        },
                                                            dataUrl:'../paginasFunciones/funcionesOrganigrama.php',
                                                            uiProviders:	{
                                                                            	'col': Ext.ux.tree.ColumnNodeUI
                                                                        	}
                                                        }	


		                                         )		                                        
		var tpl = new Ext.Template	(
                                        '  	<br /><br />'+
                                        '	<table><tr><td width="20"></td><td>'+
                                        '	<table>'+
                                        '    <tr height="25" >'+
                                        '    <td width="150" class="letraFicha" valign="top"><b>Nombre Unidad</b>:</td><td class="copyrigth" width="350">{text}{desc}</td>'+
                                        '    </tr>'+
                                        '    <tr height="25" >'+
                                        '    <td width="150" class="letraFicha" valign="top"><b>Tel&eacute;fonos</b>:</td><td class="copyrigth" width="350">{descTel}</td>'+
                                        '    </tr>'+
                                        '    <tr height="25">'+
                                        '    <td class="letraFicha"><b>C&oacute;digo Unidad</b>:</td><td class="copyrigth">{codigoU}</td>'+
                                        '    </tr>'+
                                        '    <tr height="25">'+
                                        '    <td class="letraFicha"><b>C&oacute;digo Funcional</b>:</td><td class="copyrigth">{codigoF}</td>'+
                                        '    </tr>'+
                                        '    <tr height="25">'+
                                        '    <td class="letraFicha"><b>Centro de costo</b>:</td><td class="copyrigth">{CCDescrip}</td>'+
                                        '    </tr>'+
                                        '    <tr height="25" >'+
                                        '    <td class="letraFicha" valign="top"><b>Descripci&oacute;n</b>:</td><td class="copyrigth">{descripcion}</td>'+
                                        '    </tr>'+
                                        '    </table>'+
                                        '	</td></tr></table>'
                                    );
    	tpl.compile();
                                                 
                                        
		var organigrama = new Ext.ux.tree.ColumnTree	(
                                                            {
                                                                id:'tOrganigrama',
                                                                title:' ',
                                                                height:400,
                                                                width:670,
                                                                useArrows:true,
                                                                autoScroll:true,
                                                                animate:true,
                                                                enableDD:true,
                                                                containerScroll: true,
                                                                root:raiz,
                                                                loader: cargadorArbol,
                                                                rootVisible:false,
                                                                collapsible: true,
                                                                draggable:false,
                                                                columns:[
                                                                			{
                                                                                header:'Unidades Organigrama',
                                                                                width:500,
                                                                                dataIndex:'text'
                                                                            },
                                                                            {
                                                                                header:'Codigo Funcional',
                                                                                width:165,
                                                                                dataIndex:'codigoF'
                                                                            }
                                                                        ],
                                                                 listeners: 	{
                                                                                    'render': 	function(tp)
                                                                                    			{
                                                                                        			tp.getSelectionModel().on('selectionchange', function(tree, node)
                                                                                                    											{
                                                                                                                                                	nodoSel=node;
                                                                                                                                                    var btnEliminar=Ext.getCmp('btnEliminar');
                                                                                                                                                    
                                                                                                                                                    var el = Ext.getCmp('panel_detalle').body;
                                                                                                                                                    if(node)
                                                                                                                                                    {
                                                                                                                                                    	if(idCodRaiz==node.attributes.codigoF)
                                                                                                                                                            btnEliminar.disable();
                                                                                                                                                        else
                                                                                                                                                            btnEliminar.enable();
                                                                                               	 														tpl.overwrite(el, node.attributes);
                                                                                            														}
                                                                                                                                                    else
                                                                                                                                                    {
                                                                                                                                                        el.update(detailsText);
                                                                                                                                                    }
                                                                                        														}
                                                                                                                              )
                                                                                                 }
                                                                                    }

                                                               
                                                            }
                                                    );
		
        
       var detailsText = '<i>Elija una unidad para ver su descripci&oacute;n</i>';

        
        var panel=new Ext.Panel	(
        							{
                                    	id:'divPanel',
                                        renderTo:'tblOrganigrama',
                                        items:	[
                                                    organigrama,
                                                    {
                                                        region: 'south',
                                                        title: 'Descripci&oacute;n Unidad',
                                                        id: 'panel_detalle',
                                                        autoScroll: true,
                                                        collapsible: true,
                                                        split: true,
                                                        margins: '2 2 2 2',
                                                        cmargins: '2 2 2 2',
                                                        height: 220,
                                                        html: detailsText
                                                    }
                                        		],
                                        tbar:	[
                                        
                                                    {
                                                        text:'Agregar Unidad',
                                                        icon:'../images/icon_big_tick.gif',
                                                        cls:'x-btn-text-icon',
                                                        handler:function()
                                                                {
                                                                	if(nodoSel==null)
                                                                    {
                                                                    	Ext.MessageBox.alert('<?php echo $etj["lblAplicacion"]?>','Primero debe seleccionar el elemento al cual se le agregará la unidad');
                                                                        return;
                                                                    }
                                                                    agregarInstitucion(nodoSel);
                                                                    
                                                                    
                                                                }
                                                    },
                                                    {
                                                    	text:'Modificar Unidad',
                                                        icon:'../images/notes_edit.png',
                                                        cls:'x-btn-text-icon',
                                                        handler:function()
                                                                {
                                                                	if(nodoSel==null)
                                                                    {
                                                                    	Ext.MessageBox.alert('<?php echo $etj["lblAplicacion"]?>','Primero debe seleccionar el elemento al cual se le agregará la unidad');
                                                                        return;
                                                                    }
                                                                    agregarInstitucion(nodoSel,1);
                                                                }
                                                    
                                                    },
                                                    {
                                                    	id:'btnEliminar',
                                                        text:'Eliminar Unidad',
                                                        icon:'../images/cancel_round.png',
                                                        cls:'x-btn-text-icon',	
                                                        handler:function()
                                                                {
                                                                	if(nodoSel==null)
                                                                    {
                                                                    	Ext.MessageBox.alert('<?php echo $etj["lblAplicacion"]?>','Primero debe seleccionar el elemento al cual se le agregará la unidad');
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
                                                                                if((arrResp[0]=='1')||(arrResp[0]==1))
                                                                                {
                                                                                    nodoSel.remove();
                                                                                    nodoSel=null;
                                                                                }
                                                                                else
                                                                                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                            obtenerDatosWeb('../paginasFunciones/funcionesOrganigrama.php',funcAjax, 'POST','funcion=23&codUnidad='+nodoSel.attributes.codigoU,true);
                                                                        }
                                                                    }
                                                                    Ext.MessageBox.confirm('<?php echo $etj["lblAplicacion"]?>','&iquest;Est&aacute; seguro de querer eliminar esta Unidad?',resp)
                                                                    
                                                                }
                                                    },'-',
                                                   {
                                                      text:'Listado de puestos',
                                                      id:'btnPuesto',
                                                      icon:'../images/vcard.png',
                                                      cls:'x-btn-text-icon',
                                                      disabled:true,
                                                      handler:function()
                                                      {
                                                      		if(nodoSel==null)
                                                            {
                                                                Ext.MessageBox.alert('<?php echo $etj["lblAplicacion"]?>','Primero debe seleccionar la unidad cuyo listado de puestos desea ver');
                                                                return;
                                                            }
                                                            mostrarListadoPuestos();
                                                      }
                                                   }
                                                ]
                                    }
        						)
        organigrama.on('click',nodoClick);
        organigrama.expandAll();       
}

function nodoClick(nodo)
{

	nodoSel=nodo;
	if((nodoSel.attributes.institucion=='1')||(nodoSel.attributes.institucion=='11'))
    	Ext.getCmp('btnPuesto').enable();
    else
    	Ext.getCmp('btnPuesto').disable();
}

function mostrarListadoPuestos()
{
	var cUnidad=nodoSel.attributes.codigoU;
    
	var gridPuestos=crearGridPuestos();
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'textfield',
											items: 	[
														gridPuestos
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Listado de puestos de la instituci&oacute;n: '+nodoSel.text,
										width: 650,
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
															id:'btnAceptar',
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
																		ventanaAM.close();
																	}
														}
													]
									}
								);
    
   function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var arrDatos=eval(arrResp[1]);
            gridPuestos.getStore().loadData(arrDatos);
        	ventanaAM.show();	
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesOrganigrama.php',funcAjax, 'POST','funcion=28&codigoU='+cUnidad,true);

}

var registroSimple=Ext.data.Record.create	(
                                                [
                                                    {name: 'idPuesto'},
                                                    {name: 'puesto'},
                                                    {name: 'numPuestos'},
                                                    {name: 'cvePuesto'}
                                                ]
                                            )

function crearGridPuestos()
{
	dsDatos=[];
    alDatos=	new Ext.data.SimpleStore	(
                                                {
                                                    fields:	[
                                                                {name: 'idPuesto'},
                                                                {name: 'puesto'},
                                                                {name: 'numPuestos'},
                                                                {name: 'cvePuesto'}
                                                            ]
                                                }
                                            );

    alDatos.loadData(dsDatos);
	chkRow=new Ext.grid.CheckboxSelectionModel({singleSelect:true});
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														chkRow,
                                                        {
															header:'Cve. Puesto',
															width:150,
															sortable:true,
															dataIndex:'cvePuesto'
														},
														{
															header:'Puesto',
															width:250,
															sortable:true,
															dataIndex:'puesto'
														},
                                                        {
															header:'Num. puestos',
															width:120,
															sortable:true,
															dataIndex:'numPuestos'
														}
                                                        
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gridPuesto',
                                                            store:alDatos,
                                                            frame:true,
                                                            y:10,
                                                            cm: cModelo,
                                                            height:350,
                                                            width:620,
                                                            sm:chkRow,
                                                            tbar:	[
                                                            			{
                                                                        	text:'Agregar puesto',
                                                                            icon:'../images/add.png',
						                                                    cls:'x-btn-text-icon',
                                                                            handler:function()
                                                                            		{
                                                                                    	mostrarVentanaAgregarPuesto();
                                                                                    }
                                                                        },
                                                                        {
                                                                        	text:'Modificar puesto',
                                                                            icon:'../images/update_nw.gif',
						                                                    cls:'x-btn-text-icon',
                                                                            handler:function()
                                                                            		{
                                                                                    	var filaSel=tblGrid.getSelectionModel().getSelected();
                                                                                        if(filaSel==null)
                                                                                        {
                                                                                        	msgBox('Debe seleccionar el puesto a modificar');
                                                                                            return;
                                                                                        }
                                                                                    	mostrarVentanaAgregarPuesto(filaSel);
                                                                                    }
                                                                        },
                                                                        
                                                                        {
                                                                        	text:'Remover puesto',
                                                                            icon:'../images/delete.png',
						                                                    cls:'x-btn-text-icon',
                                                                            handler:function()
                                                                            		{
                                                                                    	var filaSel=tblGrid.getSelectionModel().getSelected();
                                                                                        if(filaSel==null)
                                                                                        {
                                                                                        	msgBox('Debe seleccionar el puesto a remover');
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
                                                                                                    	tblGrid.getStore().remove(filaSel);
                                                                                                    }
                                                                                                    else
                                                                                                    {
                                                                                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                    }
                                                                                                }
                                                                                                obtenerDatosWeb('../paginasFunciones/funcionesOrganigrama.php',funcAjax, 'POST','funcion=30&idPuesto='+filaSel.get('idPuesto'),true);
                                                                                             }
                                                                                    	}
                                                                                        msgConfirm('Est&aacute; seguro de querer remover el puesto seleccionado?',resp);   
                                                                                        
                                                                                        
                                                                                    }
                                                                        }
                                                            		]
                                                        }
                                                    );
	return 	tblGrid;		
}

function mostrarVentanaAgregarPuesto(filaSel)
{
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'textfield',
											items: 	[
                                            			{
                                                        	html:'Clave puesto: <font color="red">*</font>',
                                                            x:10,
                                                            y:10,
                                                            xtype:'label'
                                                            
                                                        },
                                                        {
                                                        	x:115,
                                                            y:5,
                                                            id:'txtCvePuesto',
                                                            width:150
                                                        },
														{
                                                        	html:'Puesto: <font color="red">*</font>',
                                                            x:10,
                                                            y:45,
                                                            xtype:'label'
                                                        },
                                                        {
                                                        	x:115,
                                                            y:40,
                                                            id:'txtPuesto',
                                                            width:250
                                                        },
                                                        {
                                                        	html:'N&uacute;m. Puestos: <font color="red">*</font>',
                                                            x:10,
                                                            y:80,
                                                            xtype:'label'
                                                        },
                                                        {
                                                        	x:115,
                                                            y:75,
                                                            xtype:'numberfield',
                                                            id:'txtNumPuestos',
                                                            width:80
                                                        }

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar puesto',
										width: 450,
										height:190,
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
                                                                	Ext.getCmp('txtCvePuesto').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															id:'btnAceptar',
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
																		var txtPuesto=Ext.getCmp('txtPuesto');
                                                                        var txtNumPuestos=Ext.getCmp('txtNumPuestos');
                                                                        var txtCvePuesto=Ext.getCmp('txtCvePuesto');
                                                                        
                                                                        if(txtCvePuesto.getValue()=='')
                                                                        {
                                                                        	function respCPuesto()
                                                                            {
                                                                            	txtCvePuesto.focus();
                                                                            }
                                                                        	msgBox('Debe ingresar la clave del puesto a agregar',respCPuesto);
                                                                        	return;
                                                                        }
                                                                        
                                                                        if(txtPuesto.getValue()=='')
                                                                        {
                                                                        	function respNPuesto()
                                                                            {
                                                                            	txtPuesto.focus();
                                                                            }
                                                                        	msgBox('Debe ingresar el nombre del puesto a agregar',respNPuesto);
                                                                        	return;
                                                                        }
                                                                        if(txtNumPuestos.getValue()=='')
                                                                        {
                                                                        	function respPuesto()
                                                                            {
                                                                            	txtNumPuestos.focus();
                                                                            }
                                                                        	msgBox('El n&uacute;mero de puestos ingresado no es v&aacute;lido',respPuesto);
                                                                        	return;
                                                                        }
                                                                        
                                                                        
                                                                        if(filaSel==undefined)
                                                                        {
                                                                            function funcAjax()
                                                                            {
                                                                                var resp=peticion_http.responseText;
                                                                                arrResp=resp.split('|');
                                                                                if(arrResp[0]=='1')
                                                                                {
                                                                                    var reg=new registroSimple(
                                                                                                                {
                                                                                                                    idPuesto:arrResp[1],
                                                                                                                    numPuestos:txtNumPuestos.getValue(),
                                                                                                                    puesto:txtPuesto.getValue(),
                                                                                                                    cvePuesto:txtCvePuesto.getValue()
                                                                                                                }
                                                                                                               );
                                                                                    Ext.getCmp('gridPuesto').getStore().add(reg);
                                                                                    ventanaAM.close();
                                                                                     
                                                                                }
                                                                                else
                                                                                {
                                                                                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                }
                                                                            }
                                                                            obtenerDatosWeb('../paginasFunciones/funcionesOrganigrama.php',funcAjax, 'POST','funcion=29&codigoU='+nodoSel.attributes.codigoU+'&numPuestos='+txtNumPuestos.getValue()+'&puesto='+cv(txtPuesto.getValue())+'&cvePuesto='+cv(txtCvePuesto.getValue()),true);
                                                                   		}
                                                                        else
                                                                        {
                                                                        	function funcAjax2()
                                                                            {
                                                                                var resp=peticion_http.responseText;
                                                                                arrResp=resp.split('|');
                                                                                if(arrResp[0]=='1')
                                                                                {
                                                                                  
                                                                                  	filaSel.set('numPuestos',txtNumPuestos.getValue());
                                                                                    filaSel.set('puesto',txtPuesto.getValue());
                                                                                    filaSel.set('cvePuesto',txtCvePuesto.getValue());
                                                                                    ventanaAM.close();
                                                                                     
                                                                                }
                                                                                else
                                                                                {
                                                                                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                }
                                                                            }
                                                                            obtenerDatosWeb('../paginasFunciones/funcionesOrganigrama.php',funcAjax2, 'POST','funcion=31&idPuesto='+filaSel.get('idPuesto')+'&numPuestos='+txtNumPuestos.getValue()+'&puesto='+cv(txtPuesto.getValue())+'&cvePuesto='+cv(txtCvePuesto.getValue()),true);
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
    if(filaSel!=undefined)
    {
    	var txtPuesto=Ext.getCmp('txtPuesto');
        txtPuesto.setValue(filaSel.get('puesto'));
		var txtNumPuestos=Ext.getCmp('txtNumPuestos');
        txtNumPuestos.setValue(filaSel.get('numPuestos'));
        var txtCvePuesto=Ext.getCmp('txtCvePuesto');
        txtCvePuesto.setValue(filaSel.get('cvePuesto'));
    }
	ventanaAM.show();	
}


function agregarInstitucion(nodoSel,accion)
{
	var arrCentrosC=<?php echo $arrCentroC?>;
	var arrPaises=<?php echo $arrPaises?>;
    var arrUnidades=[['1','Departamento'],['2','Instituci\u00F3n']];
    var cmbTipoU=crearComboExt('cmbTipoU',arrUnidades,120,15);
    cmbTipoU.setWidth(125);
	var cmbPais=crearComboExt('cmbPais',arrPaises,110,225);
    cmbPais.setWidth(220);
    cmbPais.minListWidth=220;
    cmbPais.setValue('146');
	var cmbCentroCosto=crearComboExt('cmbCentroCosto',arrCentrosC,110,250,250);
	function funcTpoUnidad(combo,registro,posicion)
    {
    	if(registro.get('id')=="1")
        {
        	Ext.getCmp('panelUnidad').show();
            ventana.setHeight(400);
            Ext.getCmp('panelInst').hide();
            Ext.getCmp('txtDeptoNuevo').focus(false,100);
        }
        else
        {
        	Ext.getCmp('panelInst').show();
            ventana.setHeight(490);
            Ext.getCmp('panelUnidad').hide();
            Ext.getCmp('txtInstitucionNueva').focus(false,100);
           
        }
    }
     
    cmbTipoU.on('select',funcTpoUnidad);
    
    
    var controlTelefono='<table  border="0" cellspacing="1" cellpadding="1">'+
                        '<tr><td  >&nbsp;<select name="cmbTelefonoInst" id="cmbTelefonoInst" size="5" style="width:240px"></select><input type="hidden" name="telefonos" id="telefonos" value="" />'+
                        '</td><td width="5"  align="left">&nbsp;</td><td width="19"><table><tr><td>'+
                        '<a href="javaScript:solicitarTel(\'cmbTelefonoInst\')"><img src="../images/icon_big_tick.gif" alt="Agregar" height="15" title="Agregar Teléfono" border="0"/></a>'+
                        '</td></tr><tr><td>'+
                        '<a href="javaScript:eliminarTelefono(\'cmbTelefonoInst\')"><img src="../images/cancel_round.png" alt="Eliminar" title="Eliminar Teléfono" border="0"/></a>'+
                        '</td></tr></table><br /></td></tr></table>';
                        
	var controlTelefonoD='<table  border="0" cellspacing="1" cellpadding="1">'+
                        '<tr><td  >&nbsp;<select name="cmbTelefonoDepto" id="cmbTelefonoDepto" size="5" style="width:240px"></select><input type="hidden" name="telefonos" id="telefonos" value="" />'+
                        '</td><td width="5"  align="left">&nbsp;</td><td width="19"><table><tr><td>'+
                        '<a href="javaScript:solicitarTel(\'cmbTelefonoDepto\')"><img src="../images/icon_big_tick.gif" alt="Agregar" height="15" title="Agregar Teléfono" border="0"/></a>'+
                        '</td></tr><tr><td>'+
                        '<a href="javaScript:eliminarTelefono(\'cmbTelefonoDepto\')"><img src="../images/cancel_round.png" alt="Eliminar" title="Eliminar Teléfono" border="0"/></a>'+
                        '</td></tr></table><br /></td></tr></table>';                        
    
    var panelUnidad=new Ext.Panel(
    								{
                                    	id:'panelUnidad',
                                    	x:10,
                                        y:40,
                                        
										layout:'absolute',
                                        width:385,
                                        height:290,
                                        hidden:true,
                                        baseCls: 'x-plain',
                                    	items:[
                                                  {
                                                      x:10,
                                                      y:15,
                                                      baseCls: 'x-plain',
                                                      html:'Departamento:<font color="red">*</font>'
                                                  },
                                                  {
                                                      x:110,
                                                      y:10,
                                                      id:'txtDeptoNuevo',
                                                      xtype:'textfield',
                                                      width:230
                                                  },
                                                  {
	                                               	  x:10,
                                                      y:45,
                                                      baseCls: 'x-plain',
                                                      html:'Descripci&oacute;n:'
                                                  },
                                                  {
                                                  	x:110,
                                                    y:40,
                                                    xtype:'textarea',
                                                    id:'txtDescripcionDepto',
                                                    width:240,
                                                    height:100
                                                  },
                                                  {
                                                  	x:10,
                                                    y:160,
                                                    baseCls: 'x-plain',
                                                    html:'Tel&eacute;fono:'
                                                  },
                                                  {
                                                  	x:110,
                                                    y:155,
                                                    baseCls: 'x-plain',
                                                    html:controlTelefonoD
                                                  },
                                                  {
                                                  	x:10,
                                                    y:255,
                                                    baseCls: 'x-plain',
                                                    html:'Cento de costo:'
                                                  },
                                                  cmbCentroCosto
                                               ]
                                      }
                                   )
    
    var panelInst=new Ext.Panel(
    								{
                                    	id:'panelInst',
                                    	x:10,
                                        y:40,
                                        baseCls: 'x-plain',
										layout:'absolute',
                                        width:385,
                                        height:360,
                                        hidden:true,
                                    	items:[
                                                  {
                                                      x:10,
                                                      y:15,
                                                      baseCls: 'x-plain',
                                                      html:'Instituci&oacute;n:<font color="red">*</font>'
                                                  },
                                                  {
                                                      x:110,
                                                      y:10,
                                                      id:'txtInstitucionNueva',
                                                      xtype:'textfield',
                                                      width:230
                                                  },
                                                  {
	                                               	  x:10,
                                                      y:45,
                                                      baseCls: 'x-plain',
                                                      html:'Descripci&oacute;n:'
                                                  },
                                                  {
                                                  	x:110,
                                                    y:40,
                                                    xtype:'textarea',
                                                    width:240,
                                                    height:100,
                                                    id:'txtDescripcion'
                                                  },
                                                  {
                                                      x:10,
                                                      y:150,
                                                      html:'CP.:',
                                                      baseCls: 'x-plain'
                                                  },
                                                  {
                                                      x:110,
                                                      y:145,
                                                      id:'txtCp',
                                                      xtype:'numberfield',
                                                      width:80,
                                                      allowDecimals:false,
                                                      allowNegative:false
                                                  }
                                                  ,
                                                  {
                                                      x:10,
                                                      y:175,
                                                      baseCls: 'x-plain',
                                                      html:'Ciudad:<font color="red">*</font>'
                                                  },
                                                  {
                                                      x:110,
                                                      y:170,
                                                      id:'txtCiudad',
                                                      xtype:'textfield',
                                                      width:200
                                                  },
                                                  {
                                                      x:10,
                                                      y:200,
                                                      baseCls: 'x-plain',
                                                      html:'Estado:<font color="red">*</font>'
                                                  },
                                                  {
                                                      x:110,
                                                      y:195,
                                                      id:'txtEstado',
                                                      xtype:'textfield',
                                                      width:200
                                                  },
                                                  {
                                                      x:10,
                                                      y:230,
                                                      baseCls: 'x-plain',
                                                      html:'Pa&iacute;s:<font color="red">*</font>'
                                                  }
                                                  ,
                                                  cmbPais,
                                                  {
                                                  	x:10,
                                                    y:260,
                                                    baseCls: 'x-plain',
                                                    html:'Tel&eacute;fono:'
                                                  },
                                                  {
                                                  	x:110,
                                                    y:255,
                                                    baseCls: 'x-plain',
                                                    html:controlTelefono
                                                  }
                                              ]
                                    }
                                )
    
    
	var form=new Ext.form.FormPanel(
										{
											baseCls: 'x-plain',
											layout:'absolute',
											disabled:false,
                                            defaultType:'label',
											items:	[
                                            			{
                                                        	x:20,
                                                            y:20,
                                                            baseCls: 'x-plain',
                                                            html:'Tipo de unidad:'
                                                        },cmbTipoU,
                                            			panelInst,
                                                        panelUnidad
                                                   ]
										}
									)
	var ventana=new Ext.Window(
							   		{
										title:'Agregar Unidad',
										width:420,
										height:490,
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
																cmbTipoU.focus(false,1000);
															}
												}
											},
										buttons:
												[
												 	{
														text:'Aceptar',
														handler:function ()
															{
                                                            	var codigoPadre=nodoSel.attributes.codigoU;
                                                                
                                                                
                                                            	if(cmbTipoU.getValue()=="2")
                                                                {
                                                            		var telefonos=recoletarValoresCombo('cmbTelefonoInst');
                                                                    var txtInstitucion=Ext.getCmp('txtInstitucionNueva');
                                                                    var txtCp=Ext.getCmp('txtCp');
                                                                    var txtCiudad=Ext.getCmp('txtCiudad');
                                                                    var txtEstado=Ext.getCmp('txtEstado');
                                                                    if(txtInstitucion.getValue()=='')
                                                                    {
                                                                        function resp()
                                                                        {
                                                                            txtInstitucion.focus();
                                                                        }
                                                                        msgBox("El campo de institución es obligatorio",resp);
                                                                        return;
                                                                    }
                                                                    
                                                                    if(txtCiudad.getValue()=='')
                                                                    {
                                                                        function resp()
                                                                        {
                                                                            txtCiudad.focus();
                                                                        }
                                                                        msgBox("El campo de ciudad es obligatorio",resp);
                                                                        return;
                                                                    }
                                                                    
                                                                    if(txtEstado.getValue()=='')
                                                                    {
                                                                        function resp()
                                                                        {
                                                                            txtEstado.focus();
                                                                        }
                                                                        msgBox("El campo de estado es obligatorio",resp);
                                                                        return;
                                                                    }
                                                                    var descripcion=Ext.getCmp('txtDescripcion').getValue();
                                                                    var codUnidad='';
                                                                    if(accion!=undefined)
                                                                    	codUnidad=nodoSel.attributes.codigoU;
                                                                    var objIns='{"ciudad":"'+cv(txtCiudad.getValue())+'","estado":"'+cv(txtEstado.getValue())+'","idPais":"'+cmbPais.getValue()+'","cp":"'+txtCp.getValue()+'"}';
                                                                    var objParam='{"codUnidad":"'+codUnidad+'","codigoUPadre":"'+codigoPadre+'","nombre":"'+cv(txtInstitucion.getValue())+'","descripcion":"'+descripcion+'","institucion":"1","objInst":'+objIns+',"telefonos":"'+telefonos+'"}';
                                                                    guardarInstitucion(objParam,ventana);    
                                                            	}  
                                                                else
                                                                {
                                                                	var telefonos=recoletarValoresCombo('cmbTelefonoDepto');
                                                                	var codUnidad='';
                                                                    if(accion!=undefined)
                                                                    	codUnidad=nodoSel.attributes.codigoU;
                                                                	var depto=Ext.getCmp('txtDeptoNuevo').getValue();
                                                                    var descripcion=Ext.getCmp('txtDescripcionDepto').getValue();
                                                                    var objParam='{"codUnidad":"'+codUnidad+'","codigoUPadre":"'+codigoPadre+'","nombre":"'+cv(depto)+'","descripcion":"'+descripcion+'","institucion":"0"'+',"telefonos":"'+telefonos+'","CC":"'+cmbCentroCosto.getValue()+'"}';
                                                                    guardarDepartamento(objParam,ventana);
                                                                }
                                                                                                                          
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
	if(accion!=undefined)
    	llenarDatosUnidad(ventana,nodoSel);
    else
    {                               
		ventana.show();   
        ventana.setHeight(125);                            
    }
}

function guardarInstitucion(objInst,ventana)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            var tOrganigrama=Ext.getCmp('tOrganigrama');
            tOrganigrama.getRootNode().reload();
            tOrganigrama.expandAll();
        	ventana.close();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesOrganigrama.php',funcAjax, 'POST','funcion=22&param='+objInst,true);
}

function guardarDepartamento(obj,ventana)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var tOrganigrama=Ext.getCmp('tOrganigrama');
            tOrganigrama.getRootNode().reload();
            tOrganigrama.expandAll();
        	ventana.close();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesOrganigrama.php',funcAjax, 'POST','funcion=22&param='+obj,true);
}

function llenarDatosUnidad(ventana,nodoSel)
{
	
	cmbUnidad=Ext.getCmp('cmbTipoU');
	cmbUnidad.setValue(parseInt(nodoSel.attributes.institucion)+1);
    cmbUnidad.disable();
    var alto;
    
    var telefonos=nodoSel.attributes.telefonos;
   
    var descTel=nodoSel.attributes.descTel;
    var arrTelefonos=new Array();
    if(telefonos!='')
    {
    	
        var arrTel=telefonos.split(',');
        var arrDescTel=descTel.split('<br>');
        
        
        var arr;
        var x;
        for(x=0;x<arrTel.length;x++)
        {
            arr=new Array();
            arr[0]=arrTel[x];
            arr[1]=arrDescTel[x];
            arrTelefonos[x]=arr;
        }
	}    
    var combo;

    

	if(nodoSel.attributes.institucion=='0')
    {
		
    	Ext.getCmp('panelUnidad').show();
        Ext.getCmp('cmbCentroCosto').setValue(nodoSel.attributes.CC);
        alto=390;
    	ventana.setSize(420,alto);
        Ext.getCmp('txtDeptoNuevo').setValue(nodoSel.text);
        Ext.getCmp('txtDescripcionDepto').setValue(nodoSel.descripcion);
        ventana.show();   
        combo=gE('cmbTelefonoDepto');
        
        rellenarCombo( combo,arrTelefonos)
        Ext.getCmp('txtDeptoNuevo').focus(false,1000);
    }
    else
    {
    	ventana.show();   

    	Ext.getCmp('panelInst').show();
        combo=gE('cmbTelefonoInst');
       	rellenarCombo(combo,arrTelefonos)
        alto=490;
        ventana.setSize(420,alto);
        var codigoU=nodoSel.attributes.codigoU;
        function funcAjax()
        {
            var resp=peticion_http.responseText;
            arrResp=resp.split('|');
            if(arrResp[0]=='1')
            {
            	var datosIns=eval(arrResp[1])[0];
                var txtInstitucion=Ext.getCmp('txtInstitucionNueva');
                txtInstitucion.setValue(datosIns.institucion);
                var txtCp=Ext.getCmp('txtCp');
                txtCp.setValue(datosIns.cp);
                var txtCiudad=Ext.getCmp('txtCiudad');
                txtCiudad.setValue(datosIns.ciudad);
                var txtEstado=Ext.getCmp('txtEstado');
                txtEstado.setValue(datosIns.estado);
                var cmbPais=Ext.getCmp('cmbPais');
                cmbPais.setValue(datosIns.idPais);
                var descripcion=Ext.getCmp('txtDescripcion');
                descripcion.setValue(nodoSel.attributes.descripcion);
                ventana.show();   
                txtInstitucion.focus(false,1000);
            }
            else
            {
                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
            }
        }
        obtenerDatosWeb('../paginasFunciones/funcionesOrganigrama.php',funcAjax, 'POST','funcion=27&codU='+codigoU,true);
    }
}

var tipoTel;

function solicitarTel(idCombo)
{
	tipoTel='0';
	var form=new Ext.form.FormPanel(
										{
											baseCls: 'x-plain',
											layout:'absolute',
											disabled:false,
											items:
													[
                                                    	new Ext.form.Label(
																		   		{
																					x:5,
																					y:20,
																					html: 'C&oacute;digo de &aacute;rea:'
																				}
																		   ),
                                                       	 new Ext.form.NumberField
														(
															{
																x:100,
                                                                y:15,
                                                                width:40,
                                                                height:20,
                                                                id:'txtCodArea',
                                                                allowDecimals:false,
                                                                allowNegative:false,
                                                                value:52,
                                                                maxLength:3
															}
														),   
                                                    
													 	new Ext.form.Label(
																		   		{
																					x:5,
																					y:43,
																					html: 'Lada/Tel&eacute;fono:'
																				}
																		   ),
                                                        
                                                        new Ext.form.NumberField
														(
															{
                                                                x:100,
                                                                y:38,
                                                                width:40,
                                                                height:20,
                                                                id:'txtLada',
                                                                maxLengthText:'La lada debe contener solo 3 n&uacute;meros',
                                                                maxLength:3,
                                                                allowDecimals:false,
                                                                allowNegative:false
															}
														),     
                                                        
                                                        new Ext.form.NumberField
														(
															{
																x:150,
                                                                y:38,
                                                                width:100,
                                                                height:20,
                                                                id:'txtTelefono',
                                                                allowDecimals:false,
                                                                allowNegative:false
															}
														),                   
                                                                           
                                                                      
                                                                           
														new Ext.form.Label(
																		   		{
																					x:5,
																					y:66,
																					html: 'Extensi&oacute;n:'
																				}
																		   ),
                                                      	new Ext.form.NumberField
														(
															{
                                                                x:100,
                                                                y:61,
                                                                width:100,
                                                                height:20,
                                                                id:'txtExtensiones',
                                                                allowDecimals:false,
                                                                allowNegative:false
															}
														),
														
														new Ext.form.Label(
																		   		{
																					x:5,
																					y:90,
																					text: 'Tipo:'
																				}
																		   ),
														new Ext.form.Radio
														(
															{
                                                                x:100,
                                                                y:85,
                                                                checked:true,
                                                                boxLabel:'Tel.',
                                                                allowBlank :true,
                                                                value:'0',
                                                                id:'Tel'
															}
														),
														
														new Ext.form.Radio
														(
															{
                                                                x:150,
                                                                y:85,
                                                                checked:false,
                                                                boxLabel:'Fax',
                                                                allowBlank :true,
                                                                value:'2',
                                                                id:'Fax'
															}
														)
													]
										}
									)
	var ventana=new Ext.Window(
							   		{
										title:'Agregar N&uacute;mero Telef&oacute;nico',
										width:300,
										height:190,
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
																Ext.getCmp('txtLada').focus(false,1000);
															}
												}
											},
										buttons:
												[
												 	{
														text:'Aceptar',
														handler:function ()
															{
                                                            	var codArea=Ext.getCmp('txtCodArea').getValue();
																var tel=Ext.getCmp('txtTelefono').getValue();
																var exten=Ext.getCmp('txtExtensiones').getValue();
																var lada=Ext.getCmp('txtLada').getValue();
                                                                if(codArea.length==0)
                                                                {
                                                                	function enfocarCodArea()
                                                                    {
                                                                    	Ext.getCmp('txtCodArea').focus();
                                                                    }
                                                                	msgBox('El c&oacute;digo de &aacute;rea ingresado no es v&aacute;lido',enfocarCodArea);
                                                                    return;
                                                                }
                                                                
                                                                if(tel.length==0)
                                                                {
                                                                	function enfocarTelefono()
                                                                    {
                                                                    	Ext.getCmp('txtTelefono').focus();
                                                                    }
                                                                	msgBox('El n&uacute;mero de tel&eacute;fono ingresado no es v&aacute;lido',enfocarTelefono);
                                                                    return;
                                                                }
                                                                
                                                                if(lada.length==0)
                                                                {
                                                                	function enfocarLada()
                                                                    {
                                                                    	Ext.getCmp('txtLada').focus();
                                                                    }
                                                                	msgBox('El n&uacute;mero Lada ingresado no es v&aacute;lido',enfocarLada);
                                                                    return;
                                                                }
                                                                
                                                                var opcion;
                                                                
                                                                opcion=cE('option');
                                                                opcion.value=tipoTel+'_'+codArea+'_'+lada+'_'+tel+'_'+exten;
                                                                var extens='Ext.: '+exten;
                                                                
                                                                switch(tipoTel)
                                                                {
                                                                    case "0":
                                                                        tipoTel='Tel\u00E9fono';
                                                                    break;
                                                                    /*case "1":
                                                                        tipoTel='Celular';
                                                                    break;*/
                                                                    case "2":
                                                                        tipoTel='Fax';
                                                                    break;
                                                                }
                                                                
                                                                if (exten!="")
                                                                    opcion.text='['+tipoTel+'] ('+codArea+') '+lada+"-"+tel + " ("+extens+")";
                                                                else
                                                                    opcion.text='['+tipoTel+'] ('+codArea+') '+lada+"-"+tel+" ()";

                                                               var cmbTelefono=gE(idCombo);
                                                               var resp=existeValor(cmbTelefono,opcion.value);
                                                               if(resp==-1)
                                                               {
                                                               		cmbTelefono.options[cmbTelefono.options.length]=opcion;
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
	
	var tel=Ext.getCmp('Tel');
	var fax=Ext.getCmp('Fax');
	//var movil=Ext.getCmp('Movil');
	tel.on('check',radioCheck);
	fax.on('check',radioCheck);
	//movil.on('check',radioCheck);
	ventana.show();
	
}

function radioCheck(chk,valor)
{
	if(valor==true)
	{
		var tel=Ext.getCmp('Tel');
		var fax=Ext.getCmp('Fax');
		//var movil=Ext.getCmp('Movil');
		tipoTel=chk.value;
		if(tel.id!=chk.id)
			tel.setValue(false);
		if(fax.id!=chk.id)
			fax.setValue(false);
		/*if(movil.id!=chk.id)
			movil.setValue(false);*/
	}
	
}

function eliminarTelefono(idCombo)
{
	var cmbTelefono;
	cmbTelefono=gE(idCombo);
	if(cmbTelefono.selectedIndex==-1)
	{
		msgBox('Debe seleccionar el n&uacute;mero telef&oacute;nico a eliminar');
		return;
	}
	function resp(btn)
	{
		if(btn=='yes')
		{
			cmbTelefono.options[cmbTelefono.selectedIndex]=null;
		}
	}
	Ext.MessageBox.confirm('<?php echo $etj["lblAplicacion"]?>','Est&aacute; seguro de querer eliminar el n&uacute;mero telef&oacute;nico seleccionado?',resp);
	
}