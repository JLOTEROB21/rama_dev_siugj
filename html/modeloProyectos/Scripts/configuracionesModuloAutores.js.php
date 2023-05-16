<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	$idPerfil=$_GET["idPerfil"];
	$consulta="select clave,descParticipacion from 953_elementosPerfilesParticipacionAutor where idPerfilAutor=".$idPerfil;
	$arrParticipacion=uEJ($con->obtenerFilasArreglo($consulta));
?>
Ext.onReady(iniciar);
var idPerfil='-1';
function iniciar()
{
	gE('_nombrePerfilvch').focus();
	idPerfil=gE('idPerfil').value;
    inicializarGridElementos();
}

function guardarFrm(idFrm)
{
	var tblGrid=Ext.getCmp('gridParticipacion');
	if(validarFormularios(idFrm))
    {
    	var cVacios=validarCampoNoVacio(Ext.getCmp('gridParticipacion').getStore(),'clave');
		if(cVacios!=-1)
        {
        	function resp()
            {
            	tblGrid.startEditing(cVacios-1,2);
                return;
            }
        	msgBox('El campo clave no puede permanecer vac&iacute;o',resp);
            return;
        }
        
        var cVacios=validarCampoNoVacio(Ext.getCmp('gridParticipacion').getStore(),'participacion');
		if(cVacios!=-1)
        {
        	function resp2()
            {
            	tblGrid.startEditing(cVacios-1,3);
                return;
            }
        	msgBox('El campo participaci&oacute;n no puede permanecer vac&iacute;o',resp2);
            return;
        }
    
    	
        
        var elementos='';
        
        var x;
        var obj;
        for(x=0;x<tblGrid.getStore().getCount();x++)
        {
        	var fila=tblGrid.getStore().getAt(x);
            obj=fila.get('clave')+'|'+fila.get('participacion');
            if(elementos=='')
            	elementos=obj;
            else
          		elementos+='@!'+obj;
        }
        gE('hElementos').value=elementos;
    
    
    	gE(idFrm).submit();
    }
}


var registroElemento=Ext.data.Record.create	(
											[
												{name: 'clave'},
												{name: 'participacion'}
											]
										)

function inicializarGridElementos()
{
	dsDatos=<?php echo $arrParticipacion?>;
    alDatos=	new Ext.data.SimpleStore	(
                                                {
                                                    fields:	[
                                                                {name: 'clave'},
                                                                {name: 'participacion'}
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
															header:'Clave *',
															width:100,
															sortable:true,
															dataIndex:'clave',
                                                            editor:new Ext.form.TextField()
														},
														{
															header:'Participaci&oacute;n *',
															width:280,
															sortable:true,
															dataIndex:'participacion',
                                                            editor:new Ext.form.TextField()
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gridParticipacion',
                                                            store:alDatos,
                                                            frame:true,
                                                            y:40,
                                                            cm: cModelo,
                                                            height:260,
                                                            width:510,
                                                            sm:chkRow,
                                                            renderTo:'tblElementos',
                                                            columnLines :true,
                                                            clicksToEdit:true,
                                                            tbar:[
                                                            		{
                                                                    	icon:'../images/add.png',
                                                                        text:'Agregar participaci&oacute;n',
                                                                    	handler:function()
                                                                        		{
                                                                                	
                                                                                    var el=new registroElemento(
                                                                                    								{
                                                                                                                    	clave:'',
                                                                                                                        participacion:''
                                                                                                                    }
                                                                                    							)
                                                                                    tblGrid.getStore().add(el);
                                                                                	tblGrid.startEditing(tblGrid.getStore().getCount()-1,2);
                                                                                }
                                                                    },
                                                                    {
                                                                    	icon:'../images/delete.png',
                                                                        text:'Eliminar participaci&oacute;n',
                                                                    	handler:function()
                                                                        		{
                                                                                	var filas=tblGrid.getSelectionModel().getSelections();
                                                                                    if(filas.length==0)
                                                                                    {
                                                                                    	msgBox('Al menos debe seleccionar un tipo de participación a eliminar');
                                                                                        return;
                                                                                    }
                                                                                        
                                                                                    function resp(btn)
                                                                                    {
                                                                                    	if(btn=='yes')
                                                                                        {
                                                                                        	tblGrid.getStore().remove(filas);
                                                                                        }
                                                                                    }
                                                                                    msgConfirm('Est&aacute; seguro de querer eliminar los tipos de participaci&oacute;n seleccionados?',resp);
                                                                                
                                                                        		}
                                                                    }
                                                            	]
                                                            
                                                        }
                                                    );
	
}