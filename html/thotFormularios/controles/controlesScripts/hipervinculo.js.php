<?php
session_start();
include("conexionBD.php"); 
include("configurarIdiomaJS.php");

$idFormulario=bD($_GET["idFormulario"]);

$consulta="select idValorSesion,descripcionValor,valorReemplazo from 8003_valoresSesion where tipo=1 order by descripcionValor ";
$arrValorSesion=uEJ($con->obtenerFilasArreglo($consulta));
$consulta="select idValorSesion,descripcionValor,valorReemplazo from 8003_valoresSesion where tipo=2 order by descripcionValor ";
$arrValorSistema=uEJ($con->obtenerFilasArreglo($consulta));

$query="select idEnlace,titulo,enlace,descripcion,tipoReferencia from 9040_listadoEnlaces where idFormulario=".$idFormulario." and tipoEnlace=0 order by titulo";
$arrEnlaces=$con->obtenerFilasArreglo($query);
if($arrEnlaces!="[]")
	$arrEnlaces="[['','Ninguno'],".substr($arrEnlaces,1);
else
	$arrEnlaces="[['','Ninguno']]";

?>

function mostrarVentanaHipervinculo()
{
	var gridEnlace=crearGridEnlace();
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														gridEnlace

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Listado de enlaces',
										width: 600,
										height:370,
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
															text: 'Cerrar',
															handler:function()
																	{
																		ventanaAM.close();
																	}
														}
													]
									}
								);
	ventanaAM.show();	
    
	llenarDatosEnlaces(ventanaAM);
}

function llenarDatosEnlaces(ventana)
{
	var idFormulario=gE('idFormulario').value;
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            var arrDatos=eval(arrResp[1]);
            gEx('gridListadoEnlaces').getStore().loadData(arrDatos);
            ventana.show();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=61&tEnlace=0&idFormulario='+idFormulario,true);
}

function crearGridEnlace()
{
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                {
                                                    fields:	[
                                                                {name: 'idEnlace'},
                                                                {name: 'titulo'},
                                                                {name: 'url'},
                                                                {name: 'descripcion'},
                                                                {name: 'tipoEnlace'}
                                                                 
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
															header:'T&iacute;tulo',
															width:150,
															sortable:true,
															dataIndex:'titulo'
														},
														{
															header:'Enlace',
															width:200,
															sortable:true,
															dataIndex:'url'
														},
                                                        {
															header:'Descripci&oacute;n',
															width:300,
															sortable:true,
															dataIndex:'descripcion'
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                        	id:'gridListadoEnlaces',
                                                            store:alDatos,
                                                            frame:true,
                                                            y:10,
                                                            cm: cModelo,
                                                            height:260,
                                                            width:560,
                                                            sm:chkRow,
                                                            tbar:	[
                                                            			{
                                                                        	icon:'../images/add.png',
                                                                            text:'Crear enlace',
                                                                            cls:'x-btn-text-icon',
                                                                            handler:function()
                                                                            		{
                                                                                    	mostrarVentanaNuevoEnlace();
                                                                                    
                                                                                    }
                                                                        },
                                                                         {
                                                                        	icon:'../images/pencil.png',
                                                                            text:'Modificar enlace',
                                                                            cls:'x-btn-text-icon',
                                                                            handler:function()
                                                                            		{
                                                                                    	var fila=tblGrid.getSelectionModel().getSelections();
                                                                                        if(fila.length==0)
                                                                                        {
                                                                                            msgBox('Primero debe seleccionar el par&aacute;metro a modificar');
                                                                                            return;	
                                                                                        }
                                                                                        mostrarVentanaConfiguracionEnlace(fila[0].get('tipoEnlace'),fila[0].get('idEnlace'),null);
                                                                                    
                                                                                    }
                                                                        },
                                                                        {
                                                                        	icon:'../images/delete.png',
                                                                            text:'Eliminar enlace',
                                                                            cls:'x-btn-text-icon',
                                                                            handler:function()
                                                                            		{
                                                                                    	var fila=tblGrid.getSelectionModel().getSelections();
                                                                                        if(fila.length==0)
                                                                                        {
                                                                                            msgBox('Primero debe seleccionar el enlace a eliminar');
                                                                                            return;	
                                                                                        }
                                                                                        var idEnlace=obtenerListadoArregloFilas(fila,'idEnlace');
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
                                                                                                        var arrDatosCombo=new Array();
                                                                                                        arrDatosCombo.push(['','Ninguno']);
                                                                                                        var x;
                                                                                                        var filaTemp;
                                                                                                        for(x=0;x<tblGrid.getStore().getCount();x++)
                                                                                                        {
                                                                                                        	filaTemp=tblGrid.getStore().getAt(x);
                                                                                                        	arrDatosCombo.push([filaTemp.get('idEnlace'),filaTemp.get('titulo')]);
                                                                                                            
                                                                                                        }
                                                                                                        gEx('cmbListadoEnlaces').getStore().loadData(arrDatosCombo);
                                                                                                        arrEnlaces=arrDatosCombo;
                                                                                                    }
                                                                                                    else
                                                                                                    {
                                                                                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                    }
                                                                                                }
                                                                                                obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=62&idEnlace='+idEnlace,true);
                                                                                            }
                                                                                        }
                                                                                        msgConfirm('Est&aacute; seguro de querer eliminar el enlace seleccionado?',resp);
                                                                                    }
                                                                        }
                                                                       
                                                            		]
                                                        }
                                                    );

	return 	tblGrid;	
}

function mostrarVentanaNuevoEnlace()
{
	var arrTipoEnlace=[['1','A pagina'],['2','Hacia reporte thot']];
	var cmbTipoEnlace=crearComboExt('cmbTipoEnlace',arrTipoEnlace,100,5);
    cmbTipoEnlace.setValue('1');
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            xtype:'label',
                                                            html:'Tipo de enlace'
                                                        },
                                                        cmbTipoEnlace

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Crear enlace',
										width: 330,
										height:120,
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
																		var tipoEnlace=	cmbTipoEnlace.getValue();
                                                                        switch(tipoEnlace)	
                                                                        {
                                                                        	case '1':
                                                                            	mostrarVentanaConfiguracionEnlace(1,-1,null);
                                                                            break;
                                                                            case '2':
                                                                            	mostrarVentanaSelReporte();
                                                                            break;
                                                                        }
                                                                        ventanaAM.close();
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

function mostrarVentanaConfiguracionEnlace(tipoEnlace,idEnlace,objParam)
{
	var arrFormasApertura=[['1','En una nueva ventana'],['2','Embebido en el formulario'],['3','Redirecci\xF3n de p\xE1gina']];
	var cmbFormaApertura=crearComboExt('cmbFormaApertura',arrFormasApertura,110,140);
    cmbFormaApertura.setValue('1');
    var gridParametros=crearGridParametrosEnlace(tipoEnlace);
    var desHabilitado=false;
    var valUrl='';
    if(objParam!=null)
    {
    	gridParametros.getStore().loadData(objParam.arrParam);
        valUrl=objParam.url;
        
    } 
    
    if(tipoEnlace!='1')
    	desHabilitado=true;
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:'T&iacute;tulo:'
                                                        },
                                                        {
                                                        	xtype:'textfield',
                                                            x:110,
                                                            y:5,
                                                            id:'txtTitulo',
                                                            width:250
                                                        },
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            html:'Enlace:'
                                                        },
                                                        {
                                                        	xtype:'textfield',
                                                            x:110,
                                                            y:35,
                                                            id:'txtEnlace',
                                                            width:330,
                                                            value:valUrl,
                                                            disabled:desHabilitado
                                                        },
                                                        {
                                                        	x:10,
                                                            y:70,
                                                            html:'Decripci&oacute;n:'
                                                        },
                                                        {
                                                        	xtype:'textarea',
                                                            x:110,
                                                            y:65,
                                                            id:'txtDescripcion',
                                                            width:330,
                                                            height:70
                                                        },
                                                        {
                                                        	x:10,
                                                            y:145,
                                                            html:'Forma de apertura:'
                                                        },
                                                        cmbFormaApertura,
                                                        gridParametros

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Configuraci&oacute;n del enlace',
										width: 570,
										height:550,
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
                                                                	gEx('txtTitulo').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
																		var txtTitulo=gEx('txtTitulo');
                                                                        var txtEnlace=gEx('txtEnlace');
                                                                        var txtDescripcion=gEx('txtDescripcion');
                                                                        
                                                                        if(txtTitulo.getValue()=='')
                                                                        {
                                                                        	function respTitulo()
                                                                            {
                                                                            	txtTitulo.focus();
                                                                            }
                                                                            msgBox('Debe ingresar el t&iacute;tulo del enlace',respTitulo);
                                                                        }
                                                                        if(txtEnlace.getValue()=='')
                                                                        {
                                                                        	function respEnlace()
                                                                            {
                                                                            	txtEnlace.focus();
                                                                            }
                                                                            msgBox('Debe ingresar la URL del enlace',respEnlace);
                                                                        }
                                                                        var arrParam='';
                                                                        var x;
                                                                        var obj;
                                                                        var fila;
                                                                        
                                                                        for(x=0;x<gridParametros.getStore().getCount();x++)
                                                                        {
                                                                        	fila=gridParametros.getStore().getAt(x);
                                                                            if(fila.get('parametro')=='')
                                                                            {
                                                                            	function respNomParametro()
                                                                                {
                                                                                	gridParametros.starEditing(x,2);
                                                                                }
                                                                            	msgBox('El nombre del par&aacute;metro es obligatorio',respNomParametro);
                                                                            	return;
                                                                            }
                                                                            
                                                                            if(fila.get('tipoValor')=='')
                                                                            {
                                                                            	function respTipoValor()
                                                                                {
                                                                                	gridParametros.starEditing(x,3);
                                                                                }
                                                                            	msgBox('Debe indicar el tipo de valor a asignar al par&aacute;metro',respTipoValor);
                                                                            	return;
                                                                            }
                                                                            
                                                                            if(fila.get('valor')=='')
                                                                            {
                                                                            	function respValor()
                                                                                {
                                                                                	gridParametros.starEditing(x,4);
                                                                                }
                                                                            	msgBox('Debe ingresar el valor del par&aacute;metro',respValor);
                                                                            	return;
                                                                            }
                                                                        }
                                                                        
                                                                        for(x=0;x<gridParametros.getStore().getCount();x++)
                                                                        {
                                                                        	fila=gridParametros.getStore().getAt(x);
                                                                        	obj='{"parametro":"'+fila.get('parametro')+'","tipo":"'+fila.get('tipoValor')+'","valor":"'+fila.get('valor')+'"}';
                                                                            if(arrParam=='')
                                                                            	arrParam=obj;
                                                                            else
                                                                            	arrParam+=','+obj;
                                                                       	}
                                                                        
                                                                        
                                                                        var cadObj='{"tipoReferencia":"'+tipoEnlace+'","idFormulario":"'+gE('idFormulario').value+'","idEnlace":"'+idEnlace+'","titulo":"'+cv(txtTitulo.getValue())+'","enlace":"'+cv(txtEnlace.getValue())+'","descripcion":"'+cv(txtDescripcion.getValue())+'","fApertura":"'+cmbFormaApertura.getValue()+'","arrParam":['+arrParam+']}';
                                                                        
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	var arrDatos=eval(arrResp[1]);
                                                                                gEx('gridListadoEnlaces').getStore().loadData(arrDatos);
                                                                                
                                                                                arrDatos.splice(0,0,['','Ninguno','','','']);
                                                                                gEx('cmbListadoEnlaces').getStore().loadData(arrDatos);
                                                                                arrEnlaces=arrDatos;
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=60&tEnlace=0&cadObj='+cadObj,true);
                                                                        

                                                                        
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
	if(idEnlace=="-1")                                
		ventanaAM.show();	
    else
    	llenarDatosEnlaceModificacion(ventanaAM,idEnlace);

}

function llenarDatosEnlaceModificacion(ventana,idEnlace)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var cadObj='['+arrResp[1]+']';
            var obj=eval(cadObj)[0];
            gEx('txtTitulo').setValue(obj.txtTitulo);
            gEx('txtEnlace').setValue(obj.txtEnlace);
            gEx('txtDescripcion').setValue(obj.txtDescripcion);
            gEx('cmbFormaApertura').setValue(obj.formaApertura);
            
        	gEx('gridParametrosEnlace').getStore().loadData(obj.arrParametros);
            ventana.show();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=63&idEnlace='+idEnlace,true);
}


var registroGridParametro=crearRegistro([
                                            {name: 'idParametro'},
                                            {name: 'parametro'},
                                            {name: 'tipoValor'},
                                            {name: 'valor'}

                                        ])

var arrValorSesion=<?php echo $arrValorSesion ?>;
var arrValorSistema=<?php echo $arrValorSistema ?>; 
var arrValoresFormulario=[['1','idFormulario'],['4','idProceso'],['5','idProcesoPadre'],['2','idRegistro'],['3','idReferencia']];

function crearGridParametrosEnlace(tipoEnlace)
{
	var ocultarBotones=false;
    if(tipoEnlace!='1')
    	ocultarBotones=true;
	var arrTipoValor=[['1','Valor constante'],['3','Valor de sesi\xF3n'],['4','Valor de sistema'],['5','Valor de formulario']];
	var cmbTipoValor=crearComboExt('cmbTipoValor',arrTipoValor);
    
    cmbTipoValor.on('select',funcTipoValorChange);
    
    var txtEditor=new Ext.form.TextField({id:'txtEditor'});
    var cmbEditor=crearComboExt('cmbEditor',[],0,0,200);
    
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                {
                                                    fields:	[
                                                                {name: 'idParametro'},
                                                                {name: 'parametro'},
                                                                {name: 'tipoValor'},
                                                                {name: 'valor'}
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
															header:'Par&aacute;metro',
															width:150,
															sortable:true,
															dataIndex:'parametro',
                                                            editor:new Ext.form.TextField({id:'txtParametro'})
														},
														{
															header:'Tipo de valor',
															width:150,
															sortable:true,
															dataIndex:'tipoValor',
                                                            editor:cmbTipoValor,
                                                            renderer:function(val)
                                                            		{
                                                                    	if(val!='')
                                                                        {
                                                                        	var pos=existeValorMatriz(arrTipoValor,val);
                                                                        	return arrTipoValor[pos][1];
                                                                    	}
                                                                        else
	                                                                        return '';
                                                                    }
														},
                                                        {
															header:'Valor',
															width:150,
															sortable:true,
															dataIndex:'valor',
                                                            editor:null,
                                                            renderer:function(val,meta,registro)
                                                            				{
                                                                            	var arrValores;
                                                                                switch(registro.get('tipoValor'))
                                                                                {
                                                                                	case '3':
                                                                                    	arrValores=arrValorSesion;
                                                                                    break;
                                                                                    case '4':
                                                                                    	arrValores=arrValorSistema;
                                                                                    break;
                                                                                    case '5':
                                                                                    	arrValores=arrValoresFormulario;
                                                                                    break;
                                                                                    default:
                                                                                    	arrValores=null;
                                                                                }
                                                                                if(arrValores!=null)
                                                                                {
                                                                                    if(val!='')
                                                                                    {
                                                                                        var pos=existeValorMatriz(arrValores,val);
                                                                                        return arrValores[pos][1];
                                                                                    }
                                                                                    else
                                                                                        return '';
                                                                            	}
                                                                                return val;
                                                                            }
														}
													]
												);
	
    
	
    
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gridParametrosEnlace',
                                                            store:alDatos,
                                                            frame:true,
                                                            y:180,
                                                            cm: cModelo,
                                                            height:260,
                                                            width:540,
                                                            sm:chkRow,
                                                           
                                                            tbar: 	[
                                                            			{
                                                                        	id:'btnAddParametrosEnlace',
                                                                        	icon:'../images/add.png',
                                                                            text:'Agregar par&aacute;metro',
                                                                            cls:'x-btn-text-icon',
                                                                            hidden:ocultarBotones,
                                                                            handler:function()
                                                                            		{
                                                                                    	var nReg=new registroGridParametro	(
                                                                                                                                {
                                                                                                                                	idParametro:'-1',
                                                                                                                                    parametro:'',
                                                                                                                                    tipoValor:'',
                                                                                                                                    valor:''
                                                                                                                                    
                                                                                                                                }
                                                                                                                            )
                                                                                        
                                                                                       
                                                                                        tblGrid.getStore().add(nReg);
                                                                                        tblGrid.nuevoRegistro=true;
                                                                                        tblGrid.startEditing(tblGrid.getStore().getCount()-1,2);
                                                                                        
                                                                                    
                                                                                    }
                                                                        },
                                                                        {
                                                                        	id:'btnDelParametrosEnlace',
                                                                        	icon:'../images/delete.png',
                                                                            text:'Eliminar par&aacute;metro',
                                                                            cls:'x-btn-text-icon',
                                                                            hidden:ocultarBotones, 
                                                                            handler:function()
                                                                            		{
                                                                                    	var fila=tblGrid.getSelectionModel().getSelections();
                                                                                        if(fila.length==0)
                                                                                        {
                                                                                            msgBox('Primero debe seleccionar el par&aacute;metro a eliminar');
                                                                                            return;	
                                                                                        }
                                                                                        
                                                                                        function resp(btn)
                                                                                        {
                                                                                            if(btn=='yes')
                                                                                            {
                                                                                                tblGrid.getStore().remove(fila);
                                                                                            }
                                                                                        }
                                                                                        msgConfirm('Est&aacute; seguro de querer eliminar el par&aacute;metro seleccionado?',resp);
                                                                                    
                                                                                    }
                                                                        }
                                                            		]
                                                            
                                                        }
                                                    );
	tblGrid.nuevoRegistro=false;                                                    
    if(tipoEnlace!='1')
    	tblGrid.on('beforeedit',funcAntesEditParam);
	     
	return 	tblGrid;
}

function funcAntesEditParam(e)
{
	if(e.field=='parametro')
    	e.cancel=true;
}

function funcTipoValorChange(combo,registro)
{
	var gridParametrosEnlace=gEx('gridParametrosEnlace');
    var txtEditor=gEx('txtEditor');
    var cmbEditor=gEx('cmbEditor');
    registro.set('valor','');
	switch(registro.get('id'))
    {
    	case '1':
			txtEditor.setValue('');
            gridParametrosEnlace.getColumnModel().setEditor(4,txtEditor);
        break;
        case '3':
        	cmbEditor.getStore().loadData(arrValorSesion);
            gridParametrosEnlace.getColumnModel().setEditor(4,cmbEditor);
        break;
        case '4':
        	cmbEditor.getStore().loadData(arrValorSistema);
            gridParametrosEnlace.getColumnModel().setEditor(4,cmbEditor);
        break;
        case '5':
        	cmbEditor.getStore().loadData(arrValoresFormulario);
            gridParametrosEnlace.getColumnModel().setEditor(4,cmbEditor);
        break;
    }
    
    
}

function mostrarVentanaSelReporte()
{
	var gridReportes=crearGridReportes();
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            html:'Seleccione el reporte hacia el cual desea crear el enlace:',
                                                            xtype:'label'
                                                        },
                                                        gridReportes
														

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Selecci&oacute;n de reporte a vincular',
										width: 680,
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
																		var fila=gridReportes.getSelectionModel().getSelected();
                                                                        if(fila==null)
                                                                        {
                                                                        	msgBox('Debe seleccionar el reporte con el cual desea generar el enlace');
                                                                        	return;
                                                                        }
                                                                        
                                                                        var arrParam=eval(bD(fila.get('parametros')));
                                                                        var url=bD(fila.get('url'));
                                                                        var objParam={};
                                                                        objParam.arrParam=arrParam;
                                                                        objParam.url=url;
                                                                        mostrarVentanaConfiguracionEnlace(2,-1,objParam);
                                                                        ventanaAM.close();
                                                                        
                                                                        
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

    
    llenarGridReportes(ventanaAM)
}

function crearGridReportes()
{
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                {
                                                    fields:	[
                                                                {name: 'idReporte'},
                                                                {name: 'nombreReporte'},
                                                                {name: 'descripcion'},
                                                                {name: 'fechaCreacion'},
                                                                {name: 'parametros'},
                                                                {name: 'url'}
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
															header:'Nombre del reporte',
															width:150,
															sortable:true,
															dataIndex:'nombreReporte'
														},
														{
															header:'Descripci&oacute;n',
															width:300,
															sortable:true,
															dataIndex:'descripcion'
														},
                                                        {
															header:'Fecha de creaci&oacute;n',
															width:110,
															sortable:true,
															dataIndex:'fechaCreacion'
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                         	id:'gridReportes' ,  
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

function llenarGridReportes(ventana)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var arrDatos=eval(arrResp[1]);
            gEx('gridReportes').getStore().loadData(arrDatos);
            ventana.show();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesFormulario.php',funcAjax, 'POST','funcion=64',true);

}

