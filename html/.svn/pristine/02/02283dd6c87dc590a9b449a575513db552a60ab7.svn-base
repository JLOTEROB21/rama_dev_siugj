<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	$consulta="SELECT idNivelInsvestigador,nivel FROM 9007_nivelInvestigador ORDER BY nivel";
	$arrNivelInv=$con->obtenerFilasArreglo($consulta);
	$consulta="select idNivelSNI,nivelSNI from 9007_nivelSNI";
	$arrSNI=$con->obtenerFilasArreglo($consulta);
?>

Ext.onReady(inicializar);
var arrNivelInv=<?php echo $arrNivelInv?>;
var arrSNI=<?php echo $arrSNI?>;
function inicializar()
{
	crearGridNivelInvestigador();
    crearGridNivelSNI();
}

function crearGridNivelInvestigador()
{
	var cmbNivelInv=crearComboExt('cmbNivelInv',arrNivelInv);
    var arrNivelInvGrid=eval(bD(gE('arrNivelInv').value));
	var dsDatos=arrNivelInvGrid;
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'idNivelInvUsuario'},
                                                                    {name: 'idNivelInvestigador'},
                                                                    {name: 'fechaNombramiento'},
                                                                    {name: 'fechaVigencia'}
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
															header:'Nivel del investigador *',
															width:200,
															sortable:true,
															dataIndex:'idNivelInvestigador',
                                                            editor: cmbNivelInv,
                                                            renderer:function(val)
                                                            		{
                                                                    	return formatearValorRenderer(arrNivelInv,val);
                                                                    }
														},
														{
															header:'Fecha nombramiento *',
															width:130,
															sortable:true,
															dataIndex:'fechaNombramiento',
                                                            editor:	{
                                                            			xtype:'datefield',
                                                                        format:'d/m/Y'
                                                            		},
                                                            renderer:function(val)
                                                            		{
                                                                    	if(val=='')
                                                                        	return '';
                                                                        return Ext.util.Format.date(val,'d/m/Y');
                                                                    }
														},
                                                        {
															header:'Vigencia hasta *',
															width:130,
															sortable:true,
															dataIndex:'fechaVigencia',
                                                            editor:	{
                                                            			xtype:'datefield',
                                                                        format:'d/m/Y'
                                                            		},
                                                            renderer:function(val)
                                                            		{
                                                                    	if(val=='')
                                                                        	return '';
                                                                        return Ext.util.Format.date(val,'d/m/Y');
                                                                    }
														}
													]
												);

	var editorFila=new Ext.ux.grid.RowEditor	(
    												{
														
                                                        saveText: 'Guardar',
                                                        cancelText:'Cancelar',
                                                        clicksToEdit:2
                                                    }
                                                );
	editorFila.on('afteredit',funcEditorFilaNivelAfterEdit)                                                
    editorFila.on('beforeedit',funcEditorFilaNivelBeforeEdit)
    editorFila.on('validateedit',funcEditorFilaNivelValida);
    editorFila.on('canceledit',funcEditorFilaNivelCancelEdit);
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                        	id:'gNivelInv',
                                                            renderTo:'gridNivelInvestigador',
                                                            store:alDatos,
                                                            frame:true,
                                                            cm: cModelo,
                                                            height:260,
                                                            width:550,
                                                            sm:chkRow,
                                                            plugins:[editorFila],
                                                            tbar:	[
                                                            			{
                                                                        	id:'btnAddNivel',
                                                                        	icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Agregar nombramiento de nivel',
                                                                            handler:function()
                                                                            		{
                                                                                    	var registroGrid=crearRegistro(
                                                                                        								[
                                                                                                                        	{name: 'idNivelInvUsuario'},
                                                                                                                            {name: 'idNivelInvestigador'},
                                                                                                                            {name: 'fechaNombramiento'},
                                                                                                                            {name: 'fechaVigencia'}
                                                                                                                        ]
                                                                                                                       );
                                                                                    	var nReg=new registroGrid	(
                                                                                        								{
                                                                                                                            idNivelInvUsuario:'-1',
                                                                                                                            idNivelInvestigador:'1',
                                                                                                                            fechaNombramiento:'',
                                                                                                                            fechaVigencia:''
                                                                                                                        }	
                                                                                                                    )
                                                                                    	editorFila.stopEditing();
                                                                                        tblGrid.getStore().add(nReg);
                                                                                        tblGrid.nuevoRegistro=true;
                                                                                        editorFila.startEditing(tblGrid.getStore().getCount()-1);	
                                                                                        Ext.getCmp('btnAddNivel').disable();
                                                                                        Ext.getCmp('btnDelNivel').disable();																	
                                                                                    }
                                                                            
                                                                        },
                                                                        {
                                                                        	id:'btnDelNivel',
                                                                        	icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Remover nombramiento de nivel',
                                                                            handler:function()
                                                                            		{
                                                                                    	var fila=tblGrid.getSelectionModel().getSelected();
                                                                                        if(fila==null)
                                                                                        {
                                                                                            msgBox('Primero debe seleccionar la fila a eliminar');
                                                                                            return;	
                                                                                        }
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
                                                                                                        tblGrid.getStore().remove(fila);	
                                                                                                    }
                                                                                                    else
                                                                                                    {
                                                                                                        msgBox('No se ha podido llevar a cabo la operaci&oacute;n debido al siguiente programa:'+' <br />'+arrResp[0]);
                                                                                                    }
                                                                                                }
                                                                                                obtenerDatosWeb('../paginasFunciones/funcionesUsuarios.php',funcAjax, 'POST','funcion=33&tipo=0&idRegistro='+fila.get('idNivelInvUsuario'),true);
                                                                                            }
                                                                                        }
                                                                                        msgConfirm('Est&aacute; seguro de querer eliminar la fila seleccionada?',resp);
                                                                                    }
                                                                            
                                                                        }
                                                                        
                                                            		]
                                                        }
                                                    );
	tblGrid.nuevoRegistro=false;                                                    
	return 	tblGrid;	
}

function funcEditorFilaNivelAfterEdit(rowEdit,obj,registro,nFila)
{
	
}

function funcEditorFilaNivelBeforeEdit(rowEdit,fila)
{
	var grid=Ext.getCmp('gNivelInv');
    grid.copiaRegistro=grid.getStore().getAt(fila).copy();
    grid.registroEdit=grid.getStore().getAt(fila);
	if((grid.soloLectura)&&(!grid.nuevoRegistro))
		return false;
}

function funcEditorFilaNivelValida(rowEdit,obj,registro,nFila)
{
	var grid=Ext.getCmp('gNivelInv');
	var cm=grid.getColumnModel();
	var nColumnas=cm.getColumnCount(false);
	var x;
	var editor;
	var dataIndex;
	var valor;
	for(x=0;x<nColumnas;x++)
	{
		if(cm.getColumnHeader(x).indexOf('*')!=-1)
		{
			dataIndex=cm.getDataIndex(x);
			valor=(eval('obj.'+dataIndex));
			if(valor=='')
			{
				function funcResp()
				{
					
				}
				msgBox('La columna "'+cm.getColumnHeader(x).replace('*','')+'" no puede ser vac&iacute;a',funcResp);
				return false;
			}
		}	
	}
    
    
    if(obj.fechaNombramiento>obj.fechaVigencia)
    {
    	msgBox('La fecha de nombramiento no puede ser mayor que la fecha de vigencia');
    	return false;
    }
    var idUsuario=gE('idUsuario').value;
    var obj='{"idUsuario":"'+idUsuario+'","idNivelInvUsuario":"'+registro.get('idNivelInvUsuario')+'","idNivelInvestigador":"'+obj.idNivelInvestigador+
    		'","fechaNombramiento":"'+obj.fechaNombramiento.format('Y-m-d')+'","fechaVigencia":"'+obj.fechaVigencia.format('Y-m-d')+'"}';
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            Ext.getCmp('btnDelNivel').enable();
            Ext.getCmp('btnAddNivel').enable();
            registro.set('idNivelInvUsuario',arrResp[1]);
            grid.nuevoRegistro=false;
        }
        else
        {
        	/*var copiaRegistro=grid.copiaRegistro;
            var x=0;
            var arrCampos=grid.getStore().fields;
            var filaDestino=grid.registroEdit;
        
            for(x=0;x<arrCampos.items.length;x++)
            {
                filaDestino.set(arrCampos.items[x].name,copiaRegistro.get(arrCampos.items[x].name));
        
            }
            grid.nuevoRegistro=false;*/
            function respErr()
            {
            	rowEdit.startEditing(nFila);	
           	}
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0],respErr);
             grid.nuevoRegistro=false;
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesUsuarios.php',funcAjax, 'POST','funcion=31&obj='+obj,true);
	return true;
}

function funcEditorFilaNivelCancelEdit(rowEdit,cancelado)
{
	var grid=Ext.getCmp('gNivelInv');
	if((grid.nuevoRegistro)||(grid.registroEdit.get('idNivelInvUsuario')=="-1"))
		grid.getStore().removeAt(grid.getStore().getCount()-1);
	Ext.getCmp('btnDelNivel').enable();
    Ext.getCmp('btnAddNivel').enable();
    var copiaRegistro=grid.copiaRegistro;
    var x=0;
    var arrCampos=grid.getStore().fields;
    var filaDestino=grid.registroEdit;

    for(x=0;x<arrCampos.items.length;x++)
    {
    	filaDestino.set(arrCampos.items[x].name,copiaRegistro.get(arrCampos.items[x].name));

    }
	grid.nuevoRegistro=false;
}

function crearGridNivelSNI()
{
	var cmbNivelSNI=crearComboExt('cmbNivelSNI',arrSNI);
    var arrNivelSNI=eval(bD(gE('arrNivelSNI').value));
	var dsDatos=arrNivelSNI;
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'idNivelSNIUsuario'},
                                                                    {name: 'idNivelSNI'},
                                                                    {name: 'fechaNombramiento'},
                                                                    {name: 'fechaVigencia'}
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
															header:'Nivel SNI *',
															width:200,
															sortable:true,
															dataIndex:'idNivelSNI',
                                                            editor:cmbNivelSNI,
                                                             renderer:function(val)
                                                            		{
                                                                    	return formatearValorRenderer(arrSNI,val);
                                                                    }
														},
														{
															header:'Fecha nombramiento *',
															width:130,
															sortable:true,
															dataIndex:'fechaNombramiento',
                                                            editor:	{
                                                            			xtype:'datefield',
                                                                        format:'d/m/Y'
                                                            		},
                                                            renderer:function(val)
                                                            		{
                                                                    	if(val=='')
                                                                        	return '';
                                                                        return Ext.util.Format.date(val,'d/m/Y');
                                                                    }
                                                                    
														},
                                                        {
															header:'Vigencia hasta *',
															width:130,
															sortable:true,
															dataIndex:'fechaVigencia',
                                                            editor:	{
                                                            			xtype:'datefield',
                                                                        format:'d/m/Y'
                                                            		},
                                                            renderer:function(val)
                                                            		{
                                                                    	if(val=='')
                                                                        	return '';
                                                                        return Ext.util.Format.date(val,'d/m/Y');
                                                                    }
														}
													]
												);
	var editorFila=new Ext.ux.grid.RowEditor	(
    												{
														
                                                        saveText: 'Guardar',
                                                        cancelText:'Cancelar',
                                                        clicksToEdit:2
                                                    }
                                                );    
	editorFila.on('afteredit',funcEditorFilaSNIAfterEdit)                                                
    editorFila.on('beforeedit',funcEditorFilaSNIBeforeEdit)
    editorFila.on('validateedit',funcEditorFilaSNIValida);
    editorFila.on('canceledit',funcEditorFilaSNICancelEdit);                
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                        	id:'gSNI',
                                                            renderTo:'gridSNI',
                                                            store:alDatos,
                                                            frame:true,
                                                            cm: cModelo,
                                                            height:260,
                                                            width:550,
                                                            sm:chkRow,
                                                            plugins:[editorFila],
                                                            tbar:	[
                                                            			{
                                                                        	id:'btnAddSNI',
                                                                        	icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Agregar nombramiento SNI',
                                                                            handler:function()
                                                                            		{
                                                                                    	var registroGrid=crearRegistro(
                                                                                        								[
                                                                                                                        	{name: 'idNivelSNIUsuario'},
                                                                                                                            {name: 'idNivelSNI'},
                                                                                                                            {name: 'fechaNombramiento'},
                                                                                                                            {name: 'fechaVigencia'}
                                                                                                                        ]
                                                                                                                       );
                                                                                    	var nReg=new registroGrid	(
                                                                                        								{
                                                                                                                            idNivelSNIUsuario:'-1',
                                                                                                                            idNivelSNI:'1',
                                                                                                                            fechaNombramiento:'',
                                                                                                                            fechaVigencia:''
                                                                                                                        }	
                                                                                                                    )
                                                                                    	editorFila.stopEditing();
                                                                                        tblGrid.getStore().add(nReg);
                                                                                        tblGrid.nuevoRegistro=true;
                                                                                        editorFila.startEditing(tblGrid.getStore().getCount()-1);	
                                                                                        Ext.getCmp('btnAddSNI').disable();
                                                                                        Ext.getCmp('btnDelSNI').disable();		
                                                                                    }
                                                                            
                                                                        },
                                                                        
                                                                        {
                                                                        	id:'btnDelSNI',
                                                                        	icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Remover nombramiento SNI',
                                                                            handler:function()
                                                                            		{
                                                                                    	var fila=tblGrid.getSelectionModel().getSelected();
                                                                                        if(fila==null)
                                                                                        {
                                                                                            msgBox('Primero debe seleccionar la fila a eliminar');
                                                                                            return;	
                                                                                        }
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
                                                                                                        tblGrid.getStore().remove(fila);	
                                                                                                    }
                                                                                                    else
                                                                                                    {
                                                                                                        msgBox('No se ha podido llevar a cabo la operaci&oacute;n debido al siguiente programa:'+' <br />'+arrResp[0]);
                                                                                                    }
                                                                                                }
                                                                                                obtenerDatosWeb('../paginasFunciones/funcionesUsuarios.php',funcAjax, 'POST','funcion=33&tipo=1&idRegistro='+fila.get('idNivelSNIUsuario'),true);
                                                                                            }
                                                                                        }
                                                                                        msgConfirm('Est&aacute; seguro de querer eliminar la fila seleccionada?',resp);
                                                                                    }
                                                                            
                                                                        }
                                                                        
                                                            		]
                                                        }
                                                    );
	return 	tblGrid;	
}

function funcEditorFilaSNIAfterEdit(rowEdit,obj,registro,nFila)
{
	
}

function funcEditorFilaSNIBeforeEdit(rowEdit,fila)
{
	var grid=Ext.getCmp('gSNI');
    grid.copiaRegistro=grid.getStore().getAt(fila).copy();
    grid.registroEdit=grid.getStore().getAt(fila);
	if((grid.soloLectura)&&(!grid.nuevoRegistro))
		return false;
}

function funcEditorFilaSNIValida(rowEdit,obj,registro,nFila)
{
	var grid=Ext.getCmp('gSNI');
	var cm=grid.getColumnModel();
	var nColumnas=cm.getColumnCount(false);
	var x;
	var editor;
	var dataIndex;
	var valor;
	for(x=0;x<nColumnas;x++)
	{
		if(cm.getColumnHeader(x).indexOf('*')!=-1)
		{
			dataIndex=cm.getDataIndex(x);
			valor=(eval('obj.'+dataIndex));
			if(valor=='')
			{
				function funcResp()
				{
					
				}
				msgBox('La columna "'+cm.getColumnHeader(x).replace('*','')+'" no puede ser vac&iacute;a',funcResp);
				return false;
			}
		}	
	}
    
    
    if(obj.fechaNombramiento>obj.fechaVigencia)
    {
    	msgBox('La fecha de nombramiento no puede ser mayor que la fecha de vigencia');
    	return false;
    }
    var idUsuario=gE('idUsuario').value;
    var obj='{"idUsuario":"'+idUsuario+'","idNivelSNIUsuario":"'+registro.get('idNivelSNIUsuario')+'","idNivelSNI":"'+obj.idNivelSNI+
    		'","fechaNombramiento":"'+obj.fechaNombramiento.format('Y-m-d')+'","fechaVigencia":"'+obj.fechaVigencia.format('Y-m-d')+'"}';
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            Ext.getCmp('btnDelSNI').enable();
            Ext.getCmp('btnAddSNI').enable();
            registro.set('idNivelSNIUsuario',arrResp[1]);
            grid.nuevoRegistro=false;
        }
        else
        {
        	/*var copiaRegistro=grid.copiaRegistro;
    
            var x=0;
            var arrCampos=grid.getStore().fields;
            var filaDestino=grid.registroEdit;
        
            for(x=0;x<arrCampos.items.length;x++)
            {
                filaDestino.set(arrCampos.items[x].name,copiaRegistro.get(arrCampos.items[x].name));
        
            }*/
            function respErr()
            {
            	rowEdit.startEditing(nFila);	
           	}
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0],respErr);
            grid.nuevoRegistro=false;
            
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesUsuarios.php',funcAjax, 'POST','funcion=32&obj='+obj,true);
	return true;
}

function funcEditorFilaSNICancelEdit(rowEdit,cancelado)
{
	var grid=Ext.getCmp('gSNI');
	if((grid.nuevoRegistro)||(grid.registroEdit.get('idNivelInvUsuario')=="-1"))
		grid.getStore().removeAt(grid.getStore().getCount()-1);
	Ext.getCmp('btnDelSNI').enable();
    Ext.getCmp('btnAddSNI').enable();
    var copiaRegistro=grid.copiaRegistro;
    var x=0;
    var arrCampos=grid.getStore().fields;
    var filaDestino=grid.registroEdit;

    for(x=0;x<arrCampos.items.length;x++)
    {
    	filaDestino.set(arrCampos.items[x].name,copiaRegistro.get(arrCampos.items[x].name));

    }
	grid.nuevoRegistro=false;
}