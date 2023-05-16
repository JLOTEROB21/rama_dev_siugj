Ext.onReady(inicializar);

function inicializar()
{
	
	return;
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                {
                                                    fields:	[
                                                                {name: 'numEtapa'},
                                                                {name: 'nombreEtapa'}
                                                            ]
                                                }
                                            );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel();
	
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
                                                            renderTo:'tblPrueba',
                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            stripeRows :true,
                                                            columnLines : true,
                                                            height:260,
                                                            width:650,
                                                            plugins: [Ext.ux.grid.DataDrop],
                                                            sm:chkRow,
                                                            tbar:	[
                                                            			{
                                                                        	icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'',
                                                                            handler:function()
                                                                            		{
                                                                                    	
                                                                                    }
                                                                            
                                                                        },
                                                                        {
                                                                        	icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'',
                                                                            handler:function()
                                                                            		{
                                                                                    	
                                                                                    }
                                                                            
                                                                        }
                                                                        
                                                            		]
                                                        }
                                                    );
	return 	tblGrid;	
}

function mostrarAlert()
{
	var content=gE('iFramePrueba').contentWindow;
	alert(content.document);
}

function enviarArchivo()
{
	SolmetraUploader.flashTriggerUpload('1');

}

function validarFactura()
{
	var arrParam=[['rfc',gE('rfc').value],['folio',gE('folio').value],['serie',gE('serie').value],['nAprobacion',gE('nAprobacion').value],['anioAprobacion',gE('anioAprobacion').value]];
    enviarFormularioDatos('../modulosEspeciales_Censida/validadorCFDI.php',arrParam,'POST','iFramePrueba');
}

function frmCargo()
{
	alert(gE('iFramePrueba').contentWindow.document.cookie);
	gE('iFramePrueba').contentWindow.document.getElementById('btnEnviar').click();
}

function llenarFormulario()
{
	var arrParam=[];
    enviarFormularioDatos('../modulosEspeciales_Censida/validadorCFDI.php',arrParam,'POST','iFramePrueba');
}