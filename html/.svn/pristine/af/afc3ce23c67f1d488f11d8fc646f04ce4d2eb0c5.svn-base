<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>


Ext.onReady(inicializar);

function inicializar()
{
	new Ext.Button (
                                {
                                    cls:'btnSIUGJ',
                                    text:'Guardar',
                                    width:150,
                                    height:50,
                                    id:'btnGuardarForm',
                                    renderTo:'contenedor1',
                                    handler:function()
                                            {
                                                validarFrm('frmEnvio')
                                            }
                                }
                            )
	
    
    new Ext.Button (
                                {
                                    cls:'btnSIUGJCancel',
                                    text:'Cancelar',
                                    width:150,
                                    height:50,
                                    id:'btnCancelarForm',
                                    renderTo:'contenedor2',
                                    handler:function()
                                            {
                                            	function  resp(btn)
                                                {
                                                	if(btn=='yes')
                                                    {
                                                    	location.href='../gestorDocumental/tblMetaDatos.php';
                                                    }
                                                }
                                                msgConfirm('Est&aacute; seguro de querer cancelar la operaci&oacute;n?',resp)
                                            }
                                }
                            )
    
    crearGridOpciones();
}


function crearGridOpciones()
{
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'valorOpcion'},
                                                                    {name: 'etiqueta'}
                                                                ]
                                                    }
                                                );


	var arrOpciones=eval(bD(gE('arrOpciones').value));

    alDatos.loadData(arrOpciones);
	var chkRow=new Ext.grid.CheckboxSelectionModel({checkOnly:true,width:40});
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer({width:40}),
														chkRow,
														{
															header:'Valor Opci&oacute;n',
															width:150,
															sortable:true,
                                                            editor:	{xtype:'textfield',cls:'controlSIUGJ'},
															dataIndex:'valorOpcion'
														},
														{
															header:'Etiqueta',
															width:300,
															sortable:true,
                                                            editor:	{xtype:'textfield',cls:'controlSIUGJ'},
															dataIndex:'etiqueta'
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gOpciones',
                                                            store:alDatos,
                                                            frame:false,
                                                           	renderTo:'lblOpciones',
                                                            cm: cModelo,
                                                            cls:'gridSiugjPrincipal',
                                                            clicksToEdit:1,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            stripeRows :false,
                                                            columnLines : false,
                                                            height:240,
                                                            width:650,
                                                            sm:chkRow,
                                                            tbar:	[
                                                            			{
                                                                        	icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Agregar Opcion',
                                                                            handler:function()
                                                                            		{
                                                                                    	var gOpciones=gEx('gOpciones');
                                                                                        
                                                                                        var reg=crearRegistro	(
                                                                                        							[
                                                                                                                        {name: 'valorOpcion'},
                                                                                                                        {name: 'etiqueta'}
                                                                                                                    ]
                                                                                        						)
                                                                                     	
                                                                                        var r=new  reg	(
                                                                                        					{
                                                                                                            	valorOpcion:'',
                                                                                                                etiqueta:''
                                                                                                            }
                                                                                        				)  	
                                                                                    
                                                                                    
                                                                                    	var gOpciones=gEx('gOpciones');
                                                                                        gOpciones.getStore().add(r);
                                                                                        gOpciones.startEditing(gOpciones.getStore().getCount()-1,2);
                                                                                    }
                                                                            
                                                                        },'-',
                                                                        {
                                                                        	icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Remover Opcion',
                                                                            handler:function()
                                                                            		{
                                                                                    	var fila=gEx('gOpciones').getSelectionModel().getSelected();
                                                                                        if(!fila)
                                                                                        {
                                                                                        	msgBox('Debe seleccinar la opci&oacute;n que desea remover');
                                                                                        	return;
                                                                                        }
                                                                                        
                                                                                        function resp(btn)
                                                                                        {
                                                                                        	gEx('gOpciones').getStore().remove(fila);
                                                                                        }
                                                                                        msgConfirm('Est&aacute; seguro de querer remover la opci&oacute;n seleccionada?',resp);
                                                                                        
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
    
    	var objArr='';
        
        var x=0;
        var gOpciones=gEx('gOpciones');
        var fila;
        var o;
        for(x=0;x<gOpciones.getStore().getCount();x++)
        {
        	fila=gOpciones.getStore().getAt(x);
            o='{"valorOpcion":"'+fila.data.valorOpcion+'","etiqueta":"'+fila.data.etiqueta+'"}';
            
            
            if(fila.data.valorOpcion=='')
            {
            	function resp1()
                {
                	gOpciones.startEditing(x,2);
                }
                msgBox('Debe ingresar la clave de la opci&oacute;n',resp1);
            	return;
            }
            
            if(fila.data.etiqueta=='')
            {
            	function resp2()
                {
                	gOpciones.startEditing(x,3);
                }
                msgBox('Debe ingresar la etiqueta de la opci&oacute;n',resp2);
            	return;
            }
            
            if(objArr=='')
            	objArr=o;
            else
            	objArr+=','+o;
            
            
        }
        
        objArr='{"registros":['+objArr+']}';
        var id=gE('id').value;
        if(id=='-1')
        {
        	gE('funcPHPEjecutarNuevo').value=bE('asociarOpcionesMetaDato(@idRegPadre,\''+bE(objArr)+'\')');
        }
        else
        {
        	gE('funcPHPEjecutarModif').value=bE('asociarOpcionesMetaDato('+id+',\''+bE(objArr)+'\')');
        }
    
    	gE('frmEnvio').submit();
    }
}





function abrirVentanaFuncion(tipo)
{
	mostrarVentanaExpresion(	function(fila,ventana)
    							{
                                	gE('txtFuncionSistema').value=fila.get('nombreConsulta');
                                    gE('_funcionSistemavch').value=fila.get('idConsulta');
                                    ventana.close();
                            	}
    							,true
                          );
}

function removerFuncion(tipo)
{
	gE('txtFuncionSistema').value='';
    gE('_funcionSistemavch').value='';
}


function metodoSeleccionChange(cmb)
{
	gE('_tipoDatoEntradaint').selectedIndex=0;
    gE('_fuenteDatosint').selectedIndex=0;
    gE('txtFuncionSistema').value='';
    gE('_funcionSistemavch').value='';
    gEx('gOpciones').getStore().removeAll();
    
	var valor=cmb.options[cmb.selectedIndex].value;
    
    

    
    oE('lblLeyenda_0');
    oE('spTipoEntrada_0');
    oE('fila_3');
	oE('fila_4');
    
    gE('_funcionSistemavch').setAttribute('val','');
    gE('txtFuncionSistema').value='';
    gE('_funcionSistemavch').value='';

	
    oE('lblLeyenda_2');
    oE('spTipoEntrada_2');
    
   
    if(valor=='1')
    {
    	mE('fila_3');
    	gE('_funcionSistemavch').setAttribute('val','obl');
    }
    else
    {
    	mE('lblLeyenda_'+valor);
	    mE('spTipoEntrada_'+valor);
    }
}


function fuenteDatosChange(cmb)
{
	
    oE('fila_3');
	oE('fila_4');
    gE('_funcionSistemavch').setAttribute('val','');
    gE('txtFuncionSistema').value='';
    gE('_funcionSistemavch').value='';
    gEx('gOpciones').getStore().removeAll();
    
	var valor=cmb.options[cmb.selectedIndex].value;
    switch(valor)
    {
    	case '0': //Funci&oacute;n de Sistema
        	mE('fila_3');
            gE('_funcionSistemavch').setAttribute('val','obl');
        break;
        case '1':  //Opciones Manuales
        	mE('fila_4');
        break;
       
    }
}