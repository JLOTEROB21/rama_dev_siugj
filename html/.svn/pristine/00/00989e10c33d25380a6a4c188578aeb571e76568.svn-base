Ext.onReady(inicializar);

function inicializar()
{
	var dsDatos=eval(bD(gE('arrCalculos').value));
    var alDatos=	new Ext.data.SimpleStore	(
                                                {
                                                    fields:	[
                                                                {name: 'nomCalculo'},
                                                                {name: 'monto'}
                                                            ]
                                                }
                                            );

    alDatos.loadData(dsDatos);
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														
														{
															header:'Concepto',
															width:460,
															sortable:true,
															dataIndex:'nomCalculo'
														},
														{
															header:'Total',
															width:120,
															sortable:true,
															dataIndex:'monto',
                                                            renderer:'usMoney',
                                                            css:'text-align:right;',
                                                            summaryType: 'sum'
														}
													]
												);
	var summary = new Ext.ux.grid.GridSummary();                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            
                                                            store:alDatos,
                                                            frame:false,
                                                            stripeRows :true,
                                                            columnLines : true,
                                                            cm: cModelo,
                                                            height:360,
                                                            width:780,
                                                            renderTo:'tblGrid',
                                                            plugins:[summary]
                                                            
                                                        }
                                                    );
	return 	tblGrid;

}