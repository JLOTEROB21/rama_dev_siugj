Ext.onReady(inicializar);

var registro

function inicializar()
{
	registro=crearRegistro([{name: 'parametro'}]);
	var dsDatos=eval(gE('arrParametros').value);
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'parametro'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer({width:40}),
														
														{
															header:'Parametro',
															width:300,
															sortable:true,
															dataIndex:'parametro',
                                                            editor:{
                                                            			xtype:'textfield'
                                                                        
                                                            		}
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gridParametros',
                                                            store:alDatos,
                                                            frame:false,
                                                            renderTo:'tblParametros',
                                                            cm: cModelo,
                                                            stripeRows :false,
                                                            loadMask:true,
                                                            columnLines : false,
                                                            cls:'gridSiugjPrincipal',
                                                            height:200,
                                                            clicksToEdit:2,
                                                            width:450,
                                                            tbar:	[
                                                            			{
                                                                        	icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Agregar par&aacute;metro',
                                                                            handler:function()
                                                                            		{
                                                                                    	var r=new registro({parametro:''});
                                                                                        tblGrid.getStore().add(r);
                                                                                        tblGrid.startEditing(tblGrid.getStore().getCount()-1,1);
                                                                                    }
                                                                            
                                                                        },
                                                                        {
                                                                        	icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Remover par&aacute;metro',
                                                                            handler:function()
                                                                            		{
                                                                                    	var nFila=tblGrid.getSelectionModel().getSelectedCell();
                                                                                        if(nFila==null)
                                                                                        {
                                                                                        	msgBox('Debe seleccionar el par&aacute;metro que desea remover');
                                                                                        	return;
                                                                                        }
                                                                                        var fila=tblGrid.getStore().getAt(nFila[0]);
                                                                                        tblGrid.getStore().remove(fila);
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
    	var gridParametros=gEx('gridParametros');
        var cadParametros='';
        var x;
        var fila;
        var arrParametros=new Array();
        for(x=0;x<gridParametros.getStore().getCount();x++)
        {
        	fila=gridParametros.getStore().getAt(x);
            if(fila.get('parametro')=='')
            {
            	function resp()
                {
                	gridParametros.startEditing(x,1);
                }
            	msgBox('El par&aacute;metro no puede ser vac&iacute;o',resp);
            	return;
            }
            if(existeValorArreglo(arrParametros,fila.get('parametro'))==-1)
            {
            	arrParametros.push(fila.get('parametro'));
                if(cadParametros=='')
                	cadParametros=fila.get('parametro');
                else
                	cadParametros+=","+fila.get('parametro');
            }
            else
            {
            	function resp2()
                {
                	gridParametros.startEditing(x,1);
                }
            	msgBox('No puede ingresar dos veces el mismo par&aacute;metro',resp2);
            	return;
            }
            
        }
        gE('cadParametros').value=cadParametros;
        gE('frmEnvio').submit();
    }
}