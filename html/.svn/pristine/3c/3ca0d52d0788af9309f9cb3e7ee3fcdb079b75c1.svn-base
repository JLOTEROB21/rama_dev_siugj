<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	
	$consulta="SELECT idRegistroPerfil,nombrePerfilExportacion FROM 20007_perfilesImportacionExportacionExpedientes WHERE tipoPerfil=2";
	$arrPerfilesExportacion=$con->obtenerFilasArreglo($consulta);
	
?>
var arrPerfilesExportacion=<?php echo $arrPerfilesExportacion?>;

function mostrarVentanaExportacionExpediente()
{
	var cmbPerfilExportacion=crearComboExt('cmbPerfilExportacion',arrPerfilesExportacion,180,5,300);
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            html:'Perfil de Exportaci&oacute;n:'
                                                        },
                                                        cmbPerfilExportacion,
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            layout:'border',
                                                            xtype:'fieldset',
                                                            height:300,
                                                            title:'Resumen de Exportaci&oacute;n',
                                                            items:	[
                                                            			crearGridResumenExportacion()
                                                            		]
                                                        },
                                                        {
                                                        	x:10,
                                                            y:350,
                                                            html:'% Avance:'
                                                        },
                                                        {
                                                        	x:90,
                                                            y:345,
                                                            xtype:'progress',
                                                            width:300
                                                            
                                                        }
                                                        
                                                        
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Exportaci&oacute;n Expediente Electr&oacute;nico',
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
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
															handler: function()
																	{
																		var cmbPerfilExportacion=gEx('cmbPerfilExportacion');
                                                                        
                                                                        if(cmbPerfilExportacion.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	cmbPerfilExportacion.focus();
                                                                            }
                                                                            msgBox('Debe seleccionar el perfil de exportaci&oacute;n a utilizar',resp);
                                                                            return;
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
}

function crearGridResumenExportacion()
{
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'idResumen'},
                                                                    {name: 'resumen'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel();
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer({width:40}),
														
														{
															header:'',
															width:500,
															sortable:true,
															dataIndex:'resumen'
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gridResumen',
                                                            store:alDatos,
                                                            frame:false,
                                                           	region:'center',
                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            stripeRows :true,
                                                            columnLines : true
                                                        }
                                                    );
	return 	tblGrid;	
}