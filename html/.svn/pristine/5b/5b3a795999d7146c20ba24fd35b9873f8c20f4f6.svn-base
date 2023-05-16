<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>

function mostrarOcultarEtapas(pr)
{
	var img=gE('imgEtapas');
    if(img.title=='Ver registros por etapas')
    {
    	mE('tbl_'+pr);
        img.src='../images/verMenos.png';
        img.title='Ocultar registros por etapas';
        img.alt='Ocultar registros por etapas';
        
    }
    else
    {
    	oE('tbl_'+pr);
        img.src='../images/verMas.gif';
        img.title='Ver registros por etapas';
        img.alt='Ver registros por etapas';
    }
}

function mostrarProyectos()
{
	var cmbTipoProyecto=;
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                        	html:'Seleccione los proyectos con el que desea vincularse para realizar actividades:'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:35,
                                                            html:'Tipo de proyecto:'
                                                        },
                                                        cmbTipoProyecto

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Selecci&oacute;n de proyectos',
										width: 500,
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


function crearGridEtapas()
{
	dsDatos=[];
    alDatos=	new Ext.data.SimpleStore	(
                                                {
                                                    fields:	[
                                                                {name: 'idProyecto'},
                                                                {name: 'nombreProyecto'}
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
															header:'No. Etapa',
															width:150,
															sortable:true,
															dataIndex:'numEtapa'
														},
														{
															header:'Etapa',
															width:300,
															sortable:true,
															dataIndex:'nombreEtapa'
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            
                                                            store:alDatos,
                                                            frame:true,
                                                            y:40,
                                                            cm: cModelo,
                                                            height:260,
                                                            width:650,
                                                            sm:chkRow
                                                        }
                                                    );
	return 	tblGrid;		
}