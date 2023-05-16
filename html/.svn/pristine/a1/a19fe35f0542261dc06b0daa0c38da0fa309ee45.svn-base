<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>
var registro;
Ext.onReady(inicializar);

function validarFrm()
{
	if(validarFormularios('frmEnvio'))
    {
    	var x;
    	var id=gE('id').value;
        var gridCategoriasConcepto=gEx('gridConceptos');
        var fila;
        var cadCategoria='';
        var obj='';
        for(x=0;x<gridCategoriasConcepto.getStore().getCount();x++)
        {
        	fila=gridCategoriasConcepto.getStore().getAt(x);
            obj='{"idCategoria":"'+fila.get('idConcepto')+'"}';
            if(cadCategoria=='')
            	cadCategoria=obj;
            else
            	cadCategoria+=','+obj;
        }
        var objArr='{"arrConceptos":['+cadCategoria+']}';
        if(id=='-1')
        {
        	gE('funcPHPEjecutarNuevo').value=bE('asociarEntidadConceptosBusqueda(@idRegPadre,\''+bE(objArr)+'\')');
        }
        else
        {
        	gE('funcPHPEjecutarModif').value=bE('asociarEntidadConceptosBusqueda('+id+',\''+bE(objArr)+'\')');
        }
    	
    	gE('frmEnvio').submit();
    }
}

function inicializar()
{
	registro=crearRegistro([{name: 'idConcepto'},{name: 'concepto'}])
	crearGridConceptos();
}

function crearGridConceptos()
{
	
	var dsDatos=eval(bD(gE('arrConceptos').value));
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'idConcepto'},
                                                                    {name: 'concepto'}
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
															header:'Funci&oacute;n de b&uacute;squeda',
															width:300,
															sortable:true,
															dataIndex:'concepto'
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            
                                                            store:alDatos,
                                                            frame:true,
                                                            id:'gridConceptos',
                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            stripeRows :true,
                                                            columnLines : true,
                                                            renderTo:'tblConceptos',
                                                            height:220,
                                                            width:550,
                                                            sm:chkRow,
                                                            tbar:	[
                                                            			{
                                                                        	icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Agregar funci&oacute;n de b&uacute;squeda',
                                                                            handler:function()
                                                                            		{
                                                                                    	mostrarVentanaAgregar();
                                                                                    }
                                                                            
                                                                        },'-',
                                                                        {
                                                                        	icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Remover funci&oacute;n de b&uacute;squeda',
                                                                            handler:function()
                                                                            		{
                                                                                    	var filas=tblGrid.getSelectionModel().getSelections();
                                                                                        if(filas.length==0)	
                                                                                        {
                                                                                        	msgBox('Debe seleccionar almenos una categor&iacute;a a remover');
                                                                                            return;
                                                                                        }
                                                                                        function resp(btn)
                                                                                        {
                                                                                        	if(btn=='yes')
                                                                                            {
                                                                                            	tblGrid.getStore().remove(filas);
                                                                                            }
                                                                                           
                                                                                        }
                                                                                        msgConfirm('Est&aacute; seguro de querer remover la funci&oacute;n de b&uacute;squeda?',resp);
                                                                                    }
                                                                            
                                                                        }
                                                                        
                                                            		]
                                                        }
                                                    );
	return 	tblGrid;
}

function mostrarVentanaAgregar()
{
	asignarFuncionNuevoConceptoInyeccion=function(idConsulta,nombre)
                                            {
                                                var iConsulta=idConsulta;
                                                var r=new registroConcepto	(
                                                                                {
                                                                                    idConsulta:iConsulta,
                                                                                    nombreConsulta:nombre,
                                                                                    nombreCategoria:'',
                                                                                    descripcion:'',
                                                                                    valorRetorno:'',
                                                                                    parametros:''
                                                                                }
                                                                            )
                                                                            
                                                conceptoSeleccionado(r, gEx('vAgregarExp'));	
                                            }
	mostrarVentanaExpresion(conceptoSeleccionado,true);	

}


function conceptoSeleccionado(fila,ventana)
{
    var gridConceptos=gEx('gridConceptos');
	var pos=obtenerPosFila(gridConceptos.getStore(),'idConcepto',fila.get('idConsulta'));
	if(pos==-1)
    {
    	var r=new registro(	{idConcepto:fila.get('idConsulta'),concepto:fila.get('nombreConsulta')});
        gridConceptos.getStore().add(r);
    }
    ventana.close();
    
}
