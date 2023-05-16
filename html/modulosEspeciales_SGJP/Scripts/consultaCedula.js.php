<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>


function mostrarVentanaVerificarCedulaProfesional()
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
                                                            html:'No. de c&eacute;dula profesional:'
                                                        },
                                                        {
                                                        	x:180,
                                                            y:5,
                                                            allowDecimals:false,
                                                            allowNegative:false,
                                                            id:'txtCedula',
                                                            xtype:'numberfield',
                                                            width:130
                                                        },
                                                        {
                                                        	x:330,
                                                            y:2,
                                                            baseCls: 'x-plain',
                                                            border:false,
                                                            xtype:'panel',
                                                            width:120,
                                                            height:30,
                                                            items:	[
                                                            			{
                                                                        	icon:'../images/magnifier.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Buscar',
                                                                            width:80,
                                                                            xtype:'button',
                                                                            height:20,
                                                                            handler:function()
                                                                            		{
                                                                                    
                                                                                    	if(gEx('txtCedula').getValue()=='')
                                                                                        {
                                                                                        	msgBox('Debe indicar el n&uacute;mero de c&eacute;dula que desea buscar');
                                                                                        	return;
                                                                                        }
                                                                                        
                                                                                        gEx('gBusqueda').getStore().removeAll();
                                                                                        
                                                                                    	function funcAjax()
                                                                                        {
                                                                                            var resp=peticion_http.responseText;
                                                                                            arrResp=resp.split('|');
                                                                                            if(arrResp[0]=='1')
                                                                                            {
                                                                                                var resultado=eval('['+arrResp[1]+']')[0];
                                                                                                if(resultado.items.length==0)
                                                                                                {
                                                                                                	function resp()
                                                                                                    {
                                                                                                    	gEx('txtCedula').focus();
                                                                                                    }
                                                                                                    msgBox('No se encontraron coincidencias',resp);
                                                                                                	return;
                                                                                                }
                                                                                                
                                                                                                
                                                                                                var arrDatos=[];
                                                                                               	var x=0;
                                                                                                var o;
                                                                                                for(x=0;x<resultado.items.length;x++) 
                                                                                                {
                                                                                                	o=[resultado.items[x].desins,resultado.items[x].paterno,resultado.items[x].materno,resultado.items[x].nombre,resultado.items[x].titulo];
                                                                                                    arrDatos.push(o);
                                                                                                }
                                                                                                
                                                                                                
                                                                                                gEx('gBusqueda').getStore().loadData(arrDatos);
                                                                                                
                                                                                            }
                                                                                            else
                                                                                            {
                                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                            }
                                                                                        }
                                                                                        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=32&noCedula='+gEx('txtCedula').getValue(),true);
                                                                                    }
                                                                            
                                                                        }
                                                            		]
                                                        },
                                                        gridResultadoBusqueda()

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Verificar c&eacute;dula profesional',
										width: 930,
										height:310,
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
                                                                	gEx('txtCedula').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
															handler: function()
																	{
																		
                                                                        ventanaAM.close();
																	}
														}
													]
									}
								);
	ventanaAM.show();
}

function gridResultadoBusqueda()
{
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'institucion'},
                                                                    {name: 'paterno'},
                                                                    {name: 'materno'},
                                                                    {name: 'nombre'},
                                                                    {name: 'titulo'}
                                                                    
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel();
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														
														{
															header:'Instituci&oacute;n',
															width:250,
															sortable:true,
															dataIndex:'institucion',
                                                            renderer:mostrarValorDescripcion
														},
														{
															header:'T&iacute;tulo',
															width:250,
															sortable:true,
															dataIndex:'titulo',
                                                            renderer:mostrarValorDescripcion
														},
														{
															header:'Nombre',
															width:180,
															sortable:true,
															dataIndex:'nombre',
                                                            renderer:mostrarValorDescripcion
														}
                                                        ,
														{
															header:'Ap. Paterno',
															width:130,
															sortable:true,
															dataIndex:'paterno',
                                                            renderer:mostrarValorDescripcion
														}
                                                        ,
														{
															header:'Ap. Materno',
															width:130,
															sortable:true,
															dataIndex:'materno',
                                                            renderer:mostrarValorDescripcion
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gBusqueda',
                                                            store:alDatos,
                                                            frame:false,
                                                            y:40,
                                                            x:10,
                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            stripeRows :true,                                                            
                                                            columnLines : true,
                                                            height:180,
                                                            width:880,
                                                            sm:chkRow
                                                        }
                                                    );
	return 	tblGrid;	
}