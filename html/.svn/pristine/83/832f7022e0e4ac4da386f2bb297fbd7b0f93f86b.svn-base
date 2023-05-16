<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	$consulta="SELECT id__422_tablaDinamica,nombreLey FROM _422_tablaDinamica";
	$arrLeyes=$con->obtenerFilasArreglo($consulta);
?>

var arrLeyes=<?php echo $arrLeyes?>;
Ext.onReady(inicializar);

function inicializar()
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
                                                                        funcion:'127'
                                                                        
                                                                    },
                                                        dataUrl:'../paginasFunciones/funcionesModulosEspeciales_SGP.php',
                                                        uiProviders:	{
                                                                            'col': Ext.ux.tree.ColumnNodeUI
                                                                        }
                                                    }	


                                             )		                                        
    
   
   	cargadorArbol.on('beforeload',function()
    								{
                                    	gEx('btnAgregarFundamento').disable();
    									gEx('btnRemoverFundamento').disable();
                                        gEx('btnModificarFundamento').disable();
                                        
                                    }
    				)
                                    
    var oMedio = new Ext.ux.tree.TreeGrid	(
                                                  {
                                                      id:'tMedioNotificacion',
                                                      height:500,
                                                      renderTo:'tblPanel',
                                                      width:960,
                                                      useArrows:true,
                                                      autoScroll:false,
                                                      animate:true,
                                                      enableDD:true,
                                                      containerScroll: false,
                                                      root:raiz,
                                                      enableSort:false,
                                                      loader: cargadorArbol,
                                                      rootVisible:false,                                                      
                                                      draggable:false,
                                                      tbar:	[
                                                      			{
                                                                    icon:'../images/add.png',
                                                                    cls:'x-btn-text-icon',
                                                                    disabled:true,
                                                                    id:'btnAgregarFundamento',
                                                                    text:'Agregar fundamento legal',
                                                                    handler:function()
                                                                            {
                                                                                mostrarVentanaFundamentoLegal();
                                                                            }
                                                                    
                                                                },'-',
                                                                {
                                                                    icon:'../images/pencil.png',
                                                                    cls:'x-btn-text-icon',
                                                                    disabled:true,
                                                                    id:'btnModificarFundamento',
                                                                    text:'Modificar fundamento legal',
                                                                    handler:function()
                                                                            {
                                                                                mostrarVentanaFundamentoLegal(nodoSel);
                                                                            }
                                                                    
                                                                },'-',
                                                                {
                                                                    icon:'../images/delete.png',
                                                                    cls:'x-btn-text-icon',
                                                                    disabled:true,
                                                                    id:'btnRemoverFundamento',
                                                                    text:'Remover fundamento legal',
                                                                    handler:function()
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
                                                                                                gEx('tMedioNotificacion').getRootNode().reload();
                                                                                                ventanaAM.close();
                                                                                            }
                                                                                            else
                                                                                            {
                                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                            }
                                                                                        }
                                                                                        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=129&iF='+nodoSel.attributes.idRegistro,true);
                                                                            		}
                                                                             	}
                                                                                msgConfirm('Est&aacute; seguro de querer remover el fundamento legal seleccionado?',resp);
                                                                            
                                                                            }
                                                                    
                                                                }
                                                      		],
                                                      columns:[
                                                                  
                                                                  {
                                                                      header:'Medio de notificaci&oacute;n',
                                                                      width:330,
                                                                      dataIndex:'text'
                                                                  },
                                                                  
                                                                  {
                                                                      header:'Art&iacute;culo',
                                                                      width:60,
                                                                      dataIndex:'articulo'
                                                                  },
                                                                  {
                                                                      header:'Fracci&oacute;n',
                                                                      width:60,
                                                                      dataIndex:'fraccion'
                                                                  },
                                                                  {
                                                                      header:'Inciso',
                                                                      width:60,
                                                                      dataIndex:'inciso'
                                                                  },
                                                                  {
                                                                      header:'Complementario',
                                                                      width:100,
                                                                      dataIndex:'complementario'
                                                                  },
                                                                  {
                                                                      header:'Funci&oacute;n de aplicaci&oacute;n',
                                                                      width:220,
                                                                      dataIndex:'funcionAplicacion'
                                                                  },
                                                                  {
                                                                      header:'Ley',
                                                                      width:450,
                                                                      dataIndex:'ley'
                                                                  }
                                                               ]

                                                     
                                                  }
                                          );
	oMedio.on('click',nodoClick);

}

function nodoClick(nodo)
{
	nodoSel=nodo;
    gEx('btnAgregarFundamento').disable();
    gEx('btnRemoverFundamento').disable();
    gEx('btnModificarFundamento').disable();
    
    switch(parseInt(nodoSel.attributes.tipoNodo))
    {
    	case 1:
        	gEx('btnAgregarFundamento').enable();
        break;
        case 2:
        	gEx('btnRemoverFundamento').enable();
        	gEx('btnModificarFundamento').enable();
        break;
    }
    
}

function mostrarVentanaFundamentoLegal(nodo)
{

	var cmbLey=crearComboExt('cmbLey',arrLeyes,120,5,550);
    
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            html:'Ley:'
                                                        },
                                                        cmbLey,
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            html:'Art&iacute;culo:'
                                                        },
                                                        {
                                                        	x:120,
                                                            y:35,
                                                            xtype:'textfield',
                                                            width:100,
                                                            id:'txtArticulo'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:70,
                                                            html:'Fracci&oacute;n:'
                                                        },
                                                        {
                                                        	x:120,
                                                            y:65,
                                                            xtype:'textfield',
                                                            width:100,
                                                            id:'txtFraccion'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:100,
                                                            html:'Inciso:'
                                                        },
                                                        {
                                                        	x:120,
                                                            y:95,
                                                            xtype:'textfield',
                                                            width:100,
                                                            id:'txtInciso'
                                                        },
                                                        {
                                                        	x:250,
                                                            y:100,
                                                            html:'Complementario:'
                                                        },
                                                        {
                                                        	x:350,
                                                            y:95,
                                                            xtype:'textfield',
                                                            width:250,
                                                            id:'txtComplementario'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:130,
                                                            html:'Funci&oacute;n de aplicaci&oacute;n:'
                                                        },
                                                        {
                                                        	x:150,
                                                            y:125,
                                                            readOnly:true,
                                                            xtype:'textfield',
                                                            width:350,
                                                            id:'txtConcepto'
                                                        },
                                                        
                                                        {
                                                        	x:515,
                                                            y:125,
                                                            html:'<a href="javascript:mostrarVentanaFuncionSistema()"><img src="../images/pencil.png" title="Asignar funci&oacute;n de aplicaci&oacute;n" alt="Asignar funci&oacute;n de aplicaci&oacute;n" /></a>&nbsp;&nbsp;<a href="javascript:removerFuncion()"><img src="../images/cross.png" title="Remover funci&oacute;n de aplicaci&oacute;n" alt="Remover funci&oacute;n de aplicaci&oacute;n"/></a>'
                                                        }
                                                        
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Fundamento Legal',
										width: 780,
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
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',                                                            
															handler: function()
																	{
																		if(cmbLey.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	cmbLey.focus();
                                                                            }
                                                                            msgConfirm('Debe ingresar la ley en la cual se basa el fundamento legal',resp);
                                                                            return;
                                                                        }
                                                                        if(!gEx('txtConcepto').idConsulta)
                                                                        {
                                                                        	gEx('txtConcepto').idConsulta='';
                                                                        }
                                                                        var idFundamento=-1;
                                                                        if(nodo)
                                                                        	idFundamento=nodo.attributes.idRegistro;
                                                                        
                                                                        var cadObj='{"idFundamento":"'+idFundamento+'","idMedio":"'+nodoSel.id+'","idLey":"'+cmbLey.getValue()+'","articulo":"'+cv(gEx('txtArticulo').getValue().trim())+
                                                                        			'","fraccion":"'+cv(gEx('txtFraccion').getValue().trim())+'","inciso":"'+cv(gEx('txtInciso').getValue().trim())+
                                                                                    '","funcionAplicacion":"'+gEx('txtConcepto').idConsulta+'","complementario":"'+cv(gEx('txtComplementario').getValue())+'"}';
                                                                        
																		
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                                gEx('tMedioNotificacion').getRootNode().reload();
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=128&cadObj='+cadObj,true);
                                                                        
                                                                        
                                                                    
                                                                    
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
    
    if(nodo)	
    {
    	cmbLey.setValue(nodo.attributes.idLey);
        gEx('txtArticulo').setValue(nodo.attributes.articulo);
        gEx('txtFraccion').setValue(nodo.attributes.fraccion);
        gEx('txtInciso').setValue(nodo.attributes.inciso);
        gEx('txtComplementario').setValue(nodo.attributes.complementario);
        gEx('txtConcepto').setValue(nodo.attributes.funcionAplicacion);
        gEx('txtConcepto').idConsulta=nodo.attributes.idFuncionAplicacion;
    }
}


function mostrarVentanaFuncionSistema()
{
	
    asignarFuncionNuevoConceptoInyeccion=function(idConsulta,nombre,ventana)
                                            {
                                             	gEx('txtConcepto').setValue(nombre);
                                                gEx('txtConcepto').idConsulta=idConsulta;
                                                
                                                if(gEx('vAgregarExp'))
	                                                gEx('vAgregarExp').close();
                                            }
    mostrarVentanaExpresion(function(filaSelec,ventana)
    						{
                            	
                                
                                gEx('txtConcepto').setValue(filaSelec.data.nombreConsulta);
                                gEx('txtConcepto').idConsulta=filaSelec.data.idConsulta;
                                                
                                ventana.close();
                            }
    						,true);
    
}

function removerFuncion()
{
	gEx('txtConcepto').setValue('');
    gEx('txtConcepto').idConsulta='';
}
