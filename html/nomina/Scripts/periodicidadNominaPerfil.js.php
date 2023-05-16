<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>
var registroDimension;
Ext.onReady(inicializar);

function validarFrm()
{
	
	if(validarFormularios('frmEnvio'))
    {
    	var x;
    	var id=gE('id').value;
        var gridCategoriasConcepto=gEx('gridCategoriasConcepto');
        var fila;
        var cadCategoria='';
        var obj='';
        
        for(x=0;x<gridCategoriasConcepto.getStore().getCount();x++)
        {
        	fila=gridCategoriasConcepto.getStore().getAt(x);
            if((fila.get('cveElemento')+'').trim()=='')
            {
            	function resp1()
                {
                	gridCategoriasConcepto.startEditing(x,2);
                }
                msgBox('Debe ingresar la clave del elemento',resp1);
            	return;
            }
            
            if((fila.get('tituloElemento')+'').trim()=='')
            {
            	function resp2()
                {
                	gridCategoriasConcepto.startEditing(x,3);
                }
                msgBox('Debe ingresar el t&iacute;tulo del elemento',resp2);
            	return;
            }
            obj='{"cveElemento":"'+fila.get('cveElemento')+'","tituloElemento":"'+fila.get('tituloElemento')+'","diaInicio":"'+fila.get('diaInicio')+'","mesInicio":"'+fila.get('mesInicio')+'"}';
            if(cadCategoria=='')
            	cadCategoria=obj;
            else
            	cadCategoria+=','+obj;
        }
        var objArr='{"arrElementos":['+cadCategoria+']}';
        if(id=='-1')
        {
        	gE('funcPHPEjecutarNuevo').value=bE('asociarElementosPeriodicidad(@idRegPadre,\''+bE(objArr)+'\')');
        }
        else
        {
        	gE('funcPHPEjecutarModif').value=bE('asociarElementosPeriodicidad('+id+',\''+bE(objArr)+'\')');
        }
    	
    	gE('frmEnvio').submit();
    }
}

function inicializar()
{
	registroDimension=crearRegistro([{name: 'idCategoria'},{name: 'categoria'}])
	crearGridCategorias();
}

function crearGridCategorias()
{
	var arrDias=[];
    var x;
    for(x=1;x<=31;x++)
    {
    	arrDias.push([x,x]);
    }
	var cmbMes=crearComboExt('cmbMes',arrMeses);
    var cmbDia=crearComboExt('cmbDia',arrDias);
	var dsDatos=eval(bD(gE('arrCategorias').value));
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'cveElemento'},
                                                                    {name: 'tituloElemento'},
                                                                    {name: 'diaInicio'},
                                                                    {name: 'mesInicio'},
                                                                    {name: 'eliminable'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel({singleSelect:true});
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														chkRow,
														{
															header:'Clave elemento <span class="letraRoja">*</span>',
															width:100,
															sortable:true,
															dataIndex:'cveElemento',
                                                            
                                                            editor:{xtype:'numberfield',allowDecimals:false,allowNegative:false}
														},
                                                        {
															header:'T&iacute;tulo elemento <span class="letraRoja">*</span>',
															width:180,
															sortable:true,
															dataIndex:'tituloElemento',
                                                            renderer:function(val,meta,registro)
                                                            		{
                                                                    	var comp='';
                                                                    	if(registro.get('eliminable')!='0')
                                                                        {
                                                                        	comp='<img src="../images/lock.png" width="13" height="13" alt="Este elemento no puede ser modificado ni eliminado ya que esta siendo referido por otros procesos del sistema" title="Este elemento no puede ser modificado ni eliminado ya que esta siendo referido por otros procesos del sistema"> ';
                                                                        }
                                                                        return comp+val;
                                                                    },
                                                            editor:{xtype:'textfield'}
														},
                                                        {
															header:'D&iacute;a inicio',
															width:80,
															sortable:true,
															dataIndex:'diaInicio',
                                                            editor:cmbDia
														},
                                                        {
															header:'Mes inicio',
															width:80,
															sortable:true,
															dataIndex:'mesInicio',
                                                            editor:cmbMes,
                                                            renderer:function(val)
                                                            		{
                                                                    	return formatearValorRenderer(arrMeses,val);
                                                                    }
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            
                                                            store:alDatos,
                                                            frame:false,
                                                            id:'gridCategoriasConcepto',
                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            stripeRows :true,
                                                            columnLines : true,
                                                            renderTo:'tblCategorias',
                                                            height:280,
                                                            width:550,
                                                            clickToEdit:1,
                                                            sm:chkRow,
                                                            tbar:	[
                                                            			{
                                                                        	id:'btnAgregar',
                                                                        	icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Agregar elemento',
                                                                            handler:function()
                                                                            		{
                                                                                    	var reg=crearRegistro	(
                                                                                        							[
                                                                                                                        {name: 'cveElemento'},
                                                                                                                        {name: 'tituloElemento'},
                                                                                                                        {name: 'diaInicio'},
                                                                                                                        {name: 'mesInicio'},
                                                                                                                        {name: 'eliminable'}
                                                                                                                    ]
                                                                                        						)
                                                                                     	var r=new   reg	(
                                                                                        					{
                                                                                                            	cveElemento:'',
                                                                                                                tituloElemento:'',
                                                                                                                diaInicio:'',
                                                                                                                mesInicio:'',
                                                                                                                eliminable:'0'
                                                                                                            }	
                                                                                        				)  
																						tblGrid.getStore().add(r);                                                                                                                               
                                                                                        tblGrid.startEditing(tblGrid.getStore().getCount()-1,2);
                                                                                    }
                                                                            
                                                                        },'-',
                                                                        {
                                                                        	id:'btnEliminar',
                                                                            disabled:true,
                                                                        	icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Eliminar elemento',
                                                                            handler:function()
                                                                            		{
                                                                                    	var filas=tblGrid.getSelectionModel().getSelections();
                                                                                        if(filas.length==0)	
                                                                                        {
                                                                                        	msgBox('Debe seleccionar al menos un elemento a remover');
                                                                                            return;
                                                                                        }
                                                                                        function resp(btn)
                                                                                        {
                                                                                        	if(btn=='yes')
                                                                                            {
                                                                                            	gEx('btnEliminar').disable();
                                                                                            	tblGrid.getStore().remove(filas);
                                                                                            }
                                                                                           
                                                                                        }
                                                                                        msgConfirm('Est&aacute; seguro de querer remover el elemento seleccionado?',resp);
                                                                                    }
                                                                            
                                                                        }
                                                                        
                                                            		]
                                                        }
                                                    );
	
    chkRow.on('rowselect',function(sm,nFila,fila)
    						{
                            	gEx('btnEliminar').disable();
                                if(fila.get('eliminable')=='0')
                                	gEx('btnEliminar').enable();
                                
                            }
    			);    

	tblGrid.on('beforeedit',function(e)
    						{
                            	if(e.record.get('eliminable')!='0')
                                {
                                	e.cancel=true;
                                }
                            }
    			)                
                
	tblGrid.on('afteredit',function(e)
    						{
                            	if(e.field=='cveElemento')
                                {
                                	var x;
                                    var fila;
                                    for(x=0;x<e.grid.getStore().getCount();x++)
                                    {
                                    	if((e.value+'').trim()=='')
                                        {
                                        	function resp3()
                                            {
                                                e.grid.startEditing(e.row,e.column);
                                            }
                                            e.grid.stopEditing();
                                            msgBox('La clave ingresada no puede ser vac&iacute;a',resp3);
                                            return false;
                                        }
                                    	if(x!=e.row)
                                        {
                                        	fila=e.grid.getStore().getAt(x);
                                            if(fila.get('cveElemento')==e.value)
                                            {
                                            	e.record.set('cveElemento',e.originalValue);
                                                function resp2()
                                                {
                                                	e.grid.startEditing(e.row,e.column);
                                                }
                                                 e.grid.stopEditing();
                                                msgBox('La clave ingresada ya est&aacute; siendo utilizada por otro elemento',resp2);
                                            	return false;
                                            }
                                        }
                                    }
                                }
                                
                                if(e.field=='tituloElemento')
                                {
                                	if((e.value+'').trim()=='')
                                    {
                                        function resp4()
                                        {
                                            e.grid.startEditing(e.row,e.column);
                                        }
                                         e.grid.stopEditing();
                                        msgBox('La descripci&oacute;n del elemento no puede ser vac&iacute;o',resp4);
                                        return false;
                                    }
                                }
                            }
    			)                                                                
	return 	tblGrid;
}
