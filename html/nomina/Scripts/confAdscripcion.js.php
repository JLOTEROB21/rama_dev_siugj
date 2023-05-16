<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	$consulta="select ciclo,ciclo from 550_cicloFiscal order by ciclo";// where ciclo in (select ciclo from 655_fechasNomina  where situacion=1) order by ciclo";
	$arrCiclo=uEJ($con->obtenerFilasArreglo($consulta));
	
	$consulta="SELECT idTipoContratacion,concat('[',cveTipoContratacion,'] ',tipoContratacion) FROM 690_tiposContratacionEmpresa ORDER BY tipoContratacion";
	$arrTiposContratacion=$con->obtenerFilasArreglo($consulta);
	$consulta="SELECT id__824_tablaDinamica,txtMotivo FROM _824_tablaDinamicaV2 ORDER BY txtMotivo";
	$arrMotivos=$con->obtenerFilasArreglo($consulta);
	$consulta="SELECT idTipoContrato,tipoContrato FROM 686_tiposContrato ORDER BY tipoContrato";
	$arrTipoContrato=$con->obtenerFilasArreglo($consulta);
	$consulta="SELECT idTipoJornada,tipoJornada FROM 689_tipoJornadas ORDER BY tipoJornada";
	$arrTipoJornada=$con->obtenerFilasArreglo($consulta);
	$consulta="SELECT idTipoPuesto,tipoPuesto FROM 801_tiposPuesto ORDER BY tipoPuesto";
	$arrTipoPuesto=$con->obtenerFilasArreglo($consulta);
?>
Ext.onReady(inicializar);
var nodoSel=null;
var arrTipoJornada=<?php echo $arrTipoJornada?>;
var arrTipoPuesto=<?php echo $arrTipoPuesto?>;
var arrMotivos=<?php echo $arrMotivos?>;
var arrTipoContrato=<?php echo $arrTipoContrato?>;
function inicializar()
{
	arrTipoJornada.splice(0,0,['0','No Especificado']);
    arrTipoContrato.splice(0,0,['0','No Especificado']);
	var tab=new Ext.Panel	(
                                        {
                                            renderTo: 'tblAdscripcionTab',
                                            width:700,
                                            contentEl:'tblAdscripcion' ,
                                           	height:450,
                                            tbar:	[
                                            			{
                                                                        	
                                                            text:'Alta de puesto',
                                                            icon:'../images/add.png',
                                                            cls:'x-btn-text-icon',
                                                            handler:function()
                                                                    {
                                                                    	if(gE('tblPuestoAdscripcion')!=null)
                                                                        {
                                                                        	msgBox('Para asignar un puesto al usuario seleccionado, primero debe dar de baja su puesto anterior');
                                                                        	return;
                                                                        }
                                                                       mostrarVentanaAgregarPuesto();
                                                                    }
                                                        },'-',
                                                       /*{
                                                           
                                                            text:'Modificar sueldo',
                                                            icon:'../images/pencil.png',
                                                            cls:'x-btn-text-icon',	
                                                            handler:function()
                                                                    {
                                                                    	if(gE('tblPuestoAdscripcion')==null)
                                                                        {
                                                                        	msgBox('Actualmente el usuario no cuenta con un puesto al cual pueda modificar su sueldo');
                                                                        	return;
                                                                        }
                                                                        mostrarVentanaModificarSueldo();
                                                                    }
                                                        },*/
                                                        {
                                                           
                                                            text:'Baja de puesto',
                                                            icon:'../images/delete.png',
                                                            cls:'x-btn-text-icon',	
                                                            handler:function()
                                                                    {
                                                                    	if(gE('tblPuestoAdscripcion')==null)
                                                                        {
                                                                        	msgBox('Actualmente el usuario no cuenta con un puesto del cual pueda ser dado de baja');
                                                                        	return;
                                                                        }
                                                                        mostrarVentanaBajaPuesto();
                                                                    }
                                                        }
                                            		]
                                            	
                                        }
                                 )
}

function mostrarVentanaAgregarPuesto()
{
	var arrCiclo=<?php echo $arrCiclo?>;
	var cmbCiclo=crearComboExt('cmbCiclo',arrCiclo,220,310,115);
    cmbCiclo.disable();
    cmbCiclo.on('select',funcCicloSelect);
    var cmbQuincena=crearComboExt('cmbQuincena',[],415,310,120);
    cmbQuincena.disable();
	var gridPuesto=crearGridPuestos();
    var cmbTipoContratacion=crearComboExt('cmbTipoContratacion',<?php echo $arrTiposContratacion?>,415,340,200);
    var nDepartamento=gE('nDepartamento').value;
    
    var cmbTipoJornada=crearComboExt('cmbTipoJornada',arrTipoJornada,180,370,200);
    cmbTipoJornada.setValue('0');
    var cmbTipoContrato=crearComboExt('cmbTipoContrato',arrTipoContrato,520,370,200);
    cmbTipoContrato.setValue('0');
    var dteFechaInicio=new Ext.form.DateField	(
    												{
                                                    	x:180,
                                                        y:340,
                                                    	id:'dteFechaInicio',
                                                        format:'d/m/Y',
                                                        disabled:true
                                                    }
    											)
                                                
	cmbQuincena.on('select',function(combo,registro)
    						{
                            	dteFechaInicio.enable();
                            	var quincena=parseInt(registro.get('id'));
                                var mes=(Math.ceil(quincena/2))+'';
                                if(mes.length==1)
                                	mes='0'+mes;
                                var dia='01';
                                var ultimoDia='14';
                                if((quincena%2)==0)
                                {
                                	dia='15';
                                }
                            	var fecha=cmbCiclo.getValue()+'-'+mes+'-'+dia;
                                
                            	dteFechaInicio.setValue(fecha);
                                if((quincena%2)==0)
                                {
                                	ultimoDia=dteFechaInicio.getValue().getDaysInMonth();
                                }
                                dteFechaInicio.setMinValue(dteFechaInicio.getValue());
                                dteFechaInicio.setMaxValue(cmbCiclo.getValue()+'-'+mes+'-'+ultimoDia);
                            }
                   )                                                   
    
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:'Departamento/&aacute;rea al cual pertenece el puesto que desea asignar:'
                                                        },
                                                        {
                                                        	id:'lblDepartamentoPuesto',
                                                        	x:400,
                                                            y:5,
                                                            html:nDepartamento+' <a href="javascript:asignarDepartamento()"><img src="../images/pencil.png" alt="Seleccionar departamento/&aacute;rea" title="Seleccionar departamento/&aacute;rea"></a>'
                                                        },
                                                        gridPuesto,
                                                        {
                                                        	x:10,
                                                            y:315,
                                                            html:'Primera quincena de aplicaci&oacute;n:'
                                                        },
                                                        {
                                                        	x:180,
                                                            y:315,
                                                            html:'Ciclo:'
                                                        },
                                                        cmbCiclo,
                                                        {
                                                        	x:350,
                                                            y:315,
                                                            html:'Quincena:'
                                                        },
                                                        cmbQuincena,
                                                        {
                                                        	x:570,
                                                            y:315,
                                                            html:'Sueldo:'
                                                        }
                                                        ,
                                                        {
                                                        	x:630,
                                                            y:310,
                                                        	id:'txtSueldo',
                                                        	xtype:'numberfield',
                                                            allowDecimals:true,
                                                            allowNegative:false,
                                                            disabled:true,
                                                            width:100
                                                        },
                                                        {
                                                        	x:85,
                                                            y:345,
                                                            html:'Fecha de inicio:'
                                                        },
                                                        dteFechaInicio,
                                                        {
                                                        	x:300,
                                                            y:345,
                                                            html:'Tipo de contratación:'
                                                        },
                                                        cmbTipoContratacion,
                                                        {
                                                        	x:640,
                                                            y:345,
                                                            html:'Horas de contrataci&oacute;n:'
                                                            
                                                        },
                                                        {
                                                        	xtype:'numberfield',
                                                            id:'txtHorasC',
                                                            x:770,
                                                            y:340,
                                                            width:80,
                                                            allowDecimal:false,
                                                            disabled:true
                                                            
                                                        },
                                                        {
                                                        	xtype:'hidden',
                                                            id:'hDepto',
                                                            value:gE('departamento').value
                                                        },
                                                        {
                                                        	xtype:'hidden',
                                                            id:'hInstitucion',
                                                            value:gE('institucion').value
                                                        },
                                                        {
                                                        	x:85,
                                                            y:375,
                                                            html:'Tipo de jornada:'
                                                        },
                                                        cmbTipoJornada,
                                                        {
                                                        	x:415,
                                                            y:375,
                                                            html:'Tipo de contrato:'
                                                        },
                                                        cmbTipoContrato
                                                        
                                                        
                                                        
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Asignaci&oacute;n de puesto',
										width: 900,
										height:480,
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
                                                                    	var txtSueldo=gEx('txtSueldo');
																		var fila=gridPuesto.getSelectionModel().getSelections();
                                                                        if(fila.length==0)
                                                                        {
                                                                        	function resp(btn)
                                                                            {
                                                                            	if(btn=='yes')
                                                                                {
                                                                                	guardarPuesto(fila,false,ventanaAM);
                                                                               	}
                                                                           	}
                                                                        	msgConfirm('No ha seleccionado el puesto a asignar al usuario, si contin&uacute;a s&oacute;lo se asociar&aacute; al usuario al departamento e instituci&oacute;n seleccionado, desea continuar?',resp)
                                                                            return;
                                                                        }
                                                                        guardarPuesto(fila,true,ventanaAM);
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

function guardarPuesto(fila,validar,ventanaAM)
{
	var idUsuario=gE('idUsuario').value;
	if(validar)
    {
    	var depto=gEx('hDepto').getValue();
        var institucion=gEx('hInstitucion').getValue();
    	var dteFechaInicio=gEx('dteFechaInicio');
        var cmbCiclo=gEx('cmbCiclo');
        /*if(cmbCiclo.getValue()=='')
        {
            function respCiclo()
            {
                cmbCiclo.focus();
            }
            msgBox('Debe seleccionar el ciclo en el cual comenzar&aacute; a aplicarse la asignaci&oacute;n del puesto',respCiclo);
            return;
        }*/
        var cmbQuincena=gEx('cmbQuincena');
        /* if(cmbQuincena.getValue()=='')
        {
            function respQuincena()
            {
                cmbQuincena.focus();
            }
            msgBox('Debe seleccionar la quincena en el cual comenzar&aacute; a aplicarse la asignaci&oacute;n del puesto',respQuincena);
            return;
        }*/
        var txtSueldo=gEx('txtSueldo');
        if(txtSueldo.getRawValue()=='')
        {
            function respSueldo()
            {
                txtSueldo.focus();
            }
            msgBox('El sueldo ingresado no es v&aacute;lido',respSueldo);
            return;
        }
        var cmbTipoContratacion=gEx('cmbTipoContratacion');
        if(cmbTipoContratacion.getValue()=='')
        {
            function resptC()
            {
                cmbTipoContratacion.focus();
            }
            msgBox('Debe seleccionar un tipo de contrataci&oacute;n de la persona',resptC);
            return;
        }
        
        /*if(gEx('txtHorasC').getValue()=='')
        {
            function respHC()
            {
                gEx('txtHorasC').focus();
            }
            msgBox('Debe seleccionar un tipo de contrataci&oacute;n de la persona',respHC);
            return;
        }*/
    
        var sueldoMax=parseFloat(fila[0].get('salarioMaximo'));
        var sueldoMin=parseFloat(fila[0].get('salarioMinimo'));
        
        /*if(!((txtSueldo.getValue()>=sueldoMin)&&(txtSueldo.getValue()<=sueldoMax)))
        {
            function resSueldo1()
            {
                txtSueldo.focus();
            }
            msgBox('El sueldo ingresado no se encuentra dentro del rango permitido, el cual debe estar entre: $'+formatearNumero(sueldoMin,2,'.',',',false)+' y $'+formatearNumero(sueldoMax,2,'.',',',false),resSueldo1);
            return;
        }*/
        var fechaInicio='';
        if(dteFechaInicio.getValue()!="")
        	fechaInicio=dteFechaInicio.getValue().format('Y-m-d');
            
        var obj='{"tipoJornada":"'+gEx('cmbTipoJornada').getValue()+'","tipoContrato":"'+gEx('cmbTipoContrato').getValue()+'","departamento":"'+depto+'","institucion":"'+institucion+'","salario":"'+txtSueldo.getValue()+'","idUsuario":"'+idUsuario+'","idTabulacion":"'+fila[0].get('idPuesto')+'","ciclo":"'+cmbCiclo.getValue()+
                '","quincena":"'+cmbQuincena.getValue()+'","fechaInicio":"'+fechaInicio+'","tipoContratacion":"'+cmbTipoContratacion.getValue()+
                '","horasContratacion":"'+gEx('txtHorasC').getValue()+'"}';
    	
    }
    else
    {
    	var depto=gEx('hDepto').getValue();
        var institucion=gEx('hInstitucion').getValue();
    	obj='{"departamento":"'+depto+'","institucion":"'+institucion+'","idUsuario":"'+idUsuario+'"}';
    }
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            ventanaAM.close();
            gE('frmActualizar').submit();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesOrganigrama.php',funcAjax, 'POST','funcion=47&obj='+obj,true);
    
   

}

function crearGridPuestos()
{
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    
                                                                    {name: 'puesto'},
                                                                    {name: 'codTabulacion'},
                                                                    {name: 'tipoPuesto'},
                                                                    {name: 'zona'},
                                                                    {name: 'salarioMinimo'},
                                                                    {name: 'salarioMaximo'},
                                                                    {name: 'idPuesto'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel({singleSelect:true});
    chkRow.on('rowselect',filaSelClick);
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														chkRow,
                                                        {
															header:'C&oacute;digo tabulaci&oacute;n',
															width:150,
															sortable:true,
															dataIndex:'codTabulacion'
														},
														{
															header:'Puesto',
															width:350,
															sortable:true,
															dataIndex:'puesto'
														},
														{
															header:'Tipo puesto',
															width:130,
															sortable:true,
															dataIndex:'tipoPuesto',
                                                             renderer:function(val)
                                                            		{
                                                                    	var pos=existeValorMatriz(arrTipoPuesto,val,0);
                                                                        if(pos==-1)
                                                                        	return '';
                                                                        return arrTipoPuesto[pos][1];
                                                                    }
														},
														{
															header:'Zona',
															width:160,
															sortable:true,
															dataIndex:'zona'
														},
                                                        {
															header:'Sueldo m&iacute;nimo',
															width:100,
															sortable:true,
															dataIndex:'salarioMinimo',
                                                            renderer:'usMoney'
														},
                                                        {
															header:'Sueldo m&aacute;ximo',
															width:100,
															sortable:true,
															dataIndex:'salarioMaximo',
                                                            renderer:'usMoney'
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gridPuesto',
                                                            store:alDatos,
                                                            frame:true,
                                                            y:40,
                                                            cm: cModelo,
                                                            height:260,
                                                            width:880,
                                                            sm:chkRow,
                                                            title:'Seleccione el puesto a asignar:'
                                                        }
                                                    );
	return 	tblGrid;	
}

function llenarDatosPuesto(codUnidad)
{
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	Ext.getCmp('gridPuesto').getStore().loadData(eval(arrResp[1]));
            
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesOrganigrama.php',funcAjax, 'POST','funcion=45&codUnidad='+codUnidad,true);
}

function funcCicloSelect(combo,registro)
{
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
			Ext.getCmp('cmbQuincena').getStore().loadData(eval(arrResp[1]));
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesOrganigrama.php',funcAjax, 'POST','funcion=46&ciclo='+registro.get('id'),true);
}

function filaSelClick(sm,nFila,registro)
{
	var txtSueldo=gEx('txtSueldo');
    var txtHorasC=gEx('txtHorasC');
    txtHorasC.enable();
    txtHorasC.setValue(0);
    if(registro.get('salarioMaximo')!=registro.get('salarioMinimo'))
    {
        txtSueldo.enable();
        txtSueldo.setReadOnly(false);
        txtSueldo.setMaxValue(parseFloat(registro.get('salarioMaximo')));
        txtSueldo.setMinValue(parseFloat(registro.get('salarioMinimo')));
        txtSueldo.focus(true,300);
        
    }
    else
    {
    	txtSueldo.enable();
        txtSueldo.setReadOnly(true);
    	txtSueldo.setValue(parseFloat(registro.get('salarioMinimo')));
        txtHorasC.disabled();
        
    }
}

function asignarDepartamento()
{
	
	var arbolOrganizacion=crearArbolOrganizacion();
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                                        arbolOrganizacion
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: '',
										width: 780,
										height:480,
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
																		if(nodoSel==null)
                                                                        {
                                                                        	msgBox('Debe seleccionar el &aacute;rea/departamento al cual adscribir&aacute; al empleado');
                                                                            return;
                                                                        }

                                                                        gEx('hDepto').setValue(nodoSel.attributes.codigoU);
                                                                        gEx('hInstitucion').setValue(nodoSel.attributes.codigoInstitucion);
                                                                        gEx('lblDepartamentoPuesto').setText('<b>'+nodoSel.text+'</b> <a href="javascript:asignarDepartamento()"><img src="../images/pencil.png" alt="Seleccionar departamento/&aacute;rea" title="Seleccionar departamento/&aacute;rea"></a>',false);
                                                                        llenarDatosPuesto(nodoSel.attributes.codigoU);
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

function crearArbolOrganizacion()
{
		var raiz=new  Ext.tree.AsyncTreeNode	(
                                                      {
                                                          id:'-1',
                                                          text:'Raiz',
                                                          draggable:false,
                                                          expanded :true
                                                      }
                                              	)
                                        
		var cargadorArbol=new Ext.tree.TreeLoader(
                                                        {
                                                            baseParams:{
                                                                            funcion:'35',
                                                                            organigramaInst:'1'
                                                                        },
                                                            dataUrl:'../paginasFunciones/funcionesOrganigrama.php',
                                                            uiProviders:	{
                                                                            	'col': Ext.ux.tree.ColumnNodeUI
                                                                        	}
                                                        }	


		                                         )		                                        
		
		var organigrama = new Ext.ux.tree.ColumnTree	(
                                                            {
                                                                id:'tOrganigrama',
                                                                title:'Seleccione el &aacute;rea/departamento al cual desea adscribir al empleado',
                                                                height:400,
                                                                width:750,
                                                                useArrows:true,
                                                                autoScroll:true,
                                                                animate:true,
                                                                enableDD:true,
                                                                containerScroll: true,
                                                                root:raiz,
                                                                loader: cargadorArbol,
                                                                rootVisible:false,
                                                                draggable:false,
                                                                columns:[
                                                                			{
                                                                                header:'Unidades Organigrama',
                                                                                width:500,
                                                                                dataIndex:'text'
                                                                            },
                                                                            {
                                                                                header:'Codigo Funcional',
                                                                                width:220,
                                                                                dataIndex:'codigoF'
                                                                            }
                                                                        ]

                                                               
                                                            }
                                                    );
		
        
      

        
        
        organigrama.on('click',nodoClick);
        organigrama.expandAll();
        return organigrama;       
}

function nodoClick(nodo)
{
	nodoSel=nodo;
}

function mostrarVentanaBajaPuesto()
{
	var arrCiclo=<?php echo $arrCiclo?>;
	var cmbCiclo=crearComboExt('cmbCiclo',arrCiclo,250,5,110);
    cmbCiclo.on('select',funcCicloSelect);
    cmbCiclo.disable();
    var cmbQuincena=crearComboExt('cmbQuincena',[],445,5);
    cmbQuincena.disable();
    var dteFechaInicio=new Ext.form.DateField	(
    												{
                                                    	x:140,
                                                        y:35,
                                                    	id:'dteFechaInicio',
                                                        format:'d/m/Y',
                                                        disabled:true
                                                    }
    											)
	cmbQuincena.on('select',function(combo,registro)
    						{
                            	dteFechaInicio.enable();
                            	var quincena=parseInt(registro.get('id'));
                                var mes=(Math.ceil(quincena/2))+'';
                                if(mes.length==1)
                                	mes='0'+mes;
                                var dia='01';
                                var ultimoDia='14';
                                if((quincena%2)==0)
                                {
                                	dia='15';
                                }
                            	var fecha=cmbCiclo.getValue()+'-'+mes+'-'+dia;
                                
                            	dteFechaInicio.setValue(fecha);
                                if((quincena%2)==0)
                                {
                                	ultimoDia=dteFechaInicio.getValue().getDaysInMonth();
                                }
                                dteFechaInicio.setMinValue(dteFechaInicio.getValue());
                                dteFechaInicio.setMaxValue(cmbCiclo.getValue()+'-'+mes+'-'+ultimoDia);
                            }
                   )                                               
    					
	var cmbMotivoBaja=crearComboExt('cmbMotivoBaja',arrMotivos,140,65,250) ;                                               
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														
                                                        {
                                                        	x:10,
                                                            y:10,
                                                            html:'&Uacute;ltima quincena de pago:'
                                                        },
                                                        {
                                                        	x:210,
                                                            y:10,
                                                            html:'Ciclo:'
                                                        },
                                                        cmbCiclo,
                                                        {
                                                        	x:380,
                                                            y:10,
                                                            html:'Quincena:'
                                                        },
                                                        cmbQuincena,
                                                        
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            html:'Fecha de ejecuci&oacute;n:'
                                                        },
                                                        dteFechaInicio,
                                                        {
                                                        	x:10,
                                                            y:70,
                                                            html:'Motivo baja:'
                                                        },
                                                        cmbMotivoBaja,
                                                        {
                                                        	x:10,
                                                            y:100,
                                                            html:'Comentarios:'
                                                        },
                                                        {
                                                        	id:'txtComentarios',
                                                        	xtype:'textarea',
                                                            x:140,
                                                            y:95,
                                                            width:500,
                                                            height:100
                                                        }
                                                        
                                                        
                                                        
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Baja de puesto',
										width: 700,
										height:310,
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
                                                                    	
																		
                                                                        /*if(cmbCiclo.getValue()=='')
                                                                        {
                                                                        	function respCiclo()
                                                                            {
                                                                            	cmbCiclo.focus();
                                                                            }
                                                                            msgBox('Debe seleccionar el ciclo en el cual comenzar&aacute; a aplicarse la baja del puesto',respCiclo);
                                                                            return;
                                                                        }
                                                                         if(cmbQuincena.getValue()=='')
                                                                        {
                                                                        	function respQuincena()
                                                                            {
                                                                            	cmbQuincena.focus();
                                                                            }
                                                                            msgBox('Debe seleccionar la quincena en el cual comenzar&aacute; a aplicarse la baja del puesto',respQuincena);
                                                                            return;
                                                                        }*/
                                                                        
                                                                        /*if(dteFechaInicio.getValue()=='')
                                                                        {
                                                                        	function respFecha()
                                                                            {
                                                                            	dteFechaInicio.focus();
                                                                            }
                                                                            msgBox('Debe indicar la fecha apartir de la cual se aplicar&aacute; la baja del puesto',respFecha);
                                                                            return;
                                                                        }*/
                                                                        
                                                                        if(cmbMotivoBaja.getValue()=='')
                                                                        {
                                                                        	function respMotivo()
                                                                            {
                                                                            	cmbMotivoBaja.focus();
                                                                            }
                                                                            msgBox('Debe indicar el motivo de la baja',respMotivo);
                                                                            return;
                                                                        }
                                                                        
                                                                        function resp(btn)
                                                                        {
                                                                        	if(btn=='yes')
                                                                            {
                                                                            	var txtComentarios=gEx('txtComentarios');
                                                                                var idUsuario=gE('idUsuario').value;
                                                                                var idFum=gE('idFum').value;
                                                                                var obj='{"motivoBaja":"'+cmbMotivoBaja.getValue()+'","idUsuario":"'+idUsuario+'","idFump":"'+idFum+'","ciclo":"'+cmbCiclo.getValue()+'","quincena":"'+cmbQuincena.getValue()+'","fechaInicio":"","comentarios":"'+cv(txtComentarios.getValue())+'"}';//'+dteFechaInicio.getValue().format('Y-m-d')+'
                                                                                
                                                                                function funcAjax()
                                                                                {
                                                                                    var resp=peticion_http.responseText;
                                                                                    arrResp=resp.split('|');
                                                                                    if(arrResp[0]=='1')
                                                                                    {
                                                                                        ventanaAM.close();
                                                                                        gE('frmActualizar').submit();
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                    }
                                                                                }
                                                                                obtenerDatosWeb('../paginasFunciones/funcionesOrganigrama.php',funcAjax, 'POST','funcion=48&obj='+obj,true);
                                                                                
                                                                            }
                                                                        }
                                                                        msgConfirm('Est&aacute; seguro de querer dar de baja el puesto del usuario seleccionado?',resp);
                                                                        
                                                                        
                                                                       
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

function mostrarVentanaModificarSueldo()
{
	var viejoSueldo=gE('viejoSueldo').value;
    var sueldoMin='$ '+gE('sueldoMin').value;
    var sueldoMax='$ '+gE('sueldoMax').value;   
    var etiqueta ='El nuevo valor de sueldo base deber&aacute; estar comprendido entre '+sueldoMin+' y '+sueldoMax;
	var arrCiclo=<?php echo $arrCiclo?>;
	var cmbCiclo=crearComboExt('cmbCiclo',arrCiclo,190,65,110);
    cmbCiclo.on('select',funcCicloSelect);
    var cmbTipoContratacion=crearComboExt('cmbTipoContratacion',<?php echo $arrTiposContratacion?>,140,35);
    cmbTipoContratacion.setValue(gE('tipoContratacion').value);
     
    var cmbQuincena=crearComboExt('cmbQuincena',[],385,65);
    var dteFechaInicio=new Ext.form.DateField	(
    												{
                                                    	x:140,
                                                        y:95,
                                                    	id:'dteFechaInicio',
                                                        format:'d/m/Y'
                                                    }
    											)
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:'Sueldo base:'
                                                        },
                                                        {
                                                        	x:140,
                                                            y:5,
                                                            width:75,
                                                        	xtype:'numberfield',
                                                            allowDecimals:true,
                                                            allowNegative:false,
                                                            id:'txtSueldoBase',
                                                            value:viejoSueldo
                                                        },
                                                        {
                                                        	x:220,
                                                            y:10,
                                                            html:'<b>Nota:</b> '+etiqueta
                                                        },
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            html:'Tipo de contrataciòn:'
                                                        },
                                                        cmbTipoContratacion,
                                                        {
                                                        	x:380,
                                                            y:40,
                                                            html:'Horas de contratación'
                                                        },
                                                        {
                                                        	xtype:'numberfield',
                                                            id:'txtHorasC',
                                                            x:500,
                                                            y:35,
                                                            width:80,
                                                            allowDecimal:false,
                                                            value:gE('horasTrabajador').value,
                                                            maxValue:parseInt(gE('horasPuesto').value)
                                                            
                                                        },
                                                        {
                                                        	x:600,
                                                            y:40,
                                                            html:'(M&aacute;x. '+parseInt(gE('horasPuesto').value)+' hrs.)'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:70,
                                                            html:'Primera quincena de pago:'
                                                        },
                                                        {
                                                        	x:150,
                                                            y:70,
                                                            html:'Ciclo:'
                                                        },
                                                        cmbCiclo,
                                                        {
                                                        	x:320,
                                                            y:70,
                                                            html:'Quincena:'
                                                        },
                                                        cmbQuincena,
                                                        
                                                        {
                                                        	x:10,
                                                            y:100,
                                                            html:'Fecha de ejecuci&oacute;n:'
                                                        },
                                                        dteFechaInicio,
                                                        {
                                                        	x:10,
                                                            y:130,
                                                            html:'Comentarios:'
                                                        },
                                                        {
                                                        	id:'txtComentarios',
                                                        	xtype:'textarea',
                                                            x:140,
                                                            y:125,
                                                            width:500,
                                                            height:100
                                                        }
                                                        
                                                        
                                                        
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Modificar sueldo base',
										width: 795,
										height:320,
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
                                                                	gEx('txtSueldoBase').focus(true,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
                                                                    	
																		
                                                                        if(cmbCiclo.getValue()=='')
                                                                        {
                                                                        	function respCiclo()
                                                                            {
                                                                            	cmbCiclo.focus();
                                                                            }
                                                                            msgBox('Debe seleccionar el ciclo en el cual comenzar&aacute; a aplicarse la modificaci&oacute;n del sueldo base',respCiclo);
                                                                            return;
                                                                        }
                                                                         if(cmbQuincena.getValue()=='')
                                                                        {
                                                                        	function respQuincena()
                                                                            {
                                                                            	cmbQuincena.focus();
                                                                            }
                                                                            msgBox('Debe seleccionar la quincena en el cual comenzar&aacute; a aplicarse la modificaci&oacute;n del sueldo base',respQuincena);
                                                                            return;
                                                                        }
                                                                        
                                                                        if(dteFechaInicio.getValue()=='')
                                                                        {
                                                                        	function respFecha()
                                                                            {
                                                                            	dteFechaInicio.focus();
                                                                            }
                                                                            msgBox('Debe indicar la fecha apartir de la cual se aplicar&aacute; la modificaci&oacute;n del sueldo base',respFecha);
                                                                            return;
                                                                        }
                                                                        
                                                                        if(cmbTipoContratacion.getValue()=='')
                                                                        {
                                                                        	function resptC()
                                                                            {
                                                                            	cmbTipoContratacion.focus();
                                                                            }
                                                                            msgBox('Debe seleccionar un tipo de contrataci&oacute;n de la persona',resptC);
                                                                            return;
                                                                        }
                                                                        
                                                                        if(gEx('txtHorasC').getValue()=='')
                                                                        {
                                                                        	function respHC()
                                                                            {
                                                                            	gEx('txtHorasC').focus();
                                                                            }
                                                                            msgBox('Debe seleccionar un tipo de contrataci&oacute;n de la persona',respHC);
                                                                            return;
                                                                        }
                                                                        
                                                                        if(parseInt(gE('horasPuesto').value)<gEx('txtHorasC').getValue())
                                                                        {
                                                                        	function respHP()
                                                                            {
                                                                            	gEx('txtHorasC').focus();
                                                                            }
                                                                            msgBox('El total de horas de contrataci&oacute;n no puede ser mayor a '+parseInt(gE('horasPuesto').value)+' hrs.',resHP);
                                                                            return;
                                                                        }
                                                                        
                                                                        var salario=gEx('txtSueldoBase');
                                                                        if((salario.getValue()==''))
                                                                        {
                                                                        	function respSueldo()
                                                                            {
                                                                            	salario.focus();
                                                                            }
                                                                        	msgBox('Debe ingresar el nuevo sueldo base',respSueldo);
                                                                            return;
                                                                        }
                                                                        
                                                                        function resp(btn)
                                                                        {
                                                                        	if(btn=='yes')
                                                                            {
                                                                            	var txtComentarios=gEx('txtComentarios');
                                                                                var idUsuario=gE('idUsuario').value;
                                                                                var idFum=gE('idFum').value;
                                                                                
                                                                                var obj='{"idUsuario":"'+idUsuario+'","idFump":"'+idFum+'","ciclo":"'+cmbCiclo.getValue()+'","quincena":"'+cmbQuincena.getValue()+'","fechaInicio":"'+
                                                                                		dteFechaInicio.getValue().format('Y-m-d')+'","comentarios":"'+cv(txtComentarios.getValue())+'","salario":"'+salario.getValue()+
                                                                                        '","tipoContratacion":"'+cmbTipoContratacion.getValue()+'","horasContratacion":"'+gEx('txtHorasC').getValue()+'"}';
                                                                                
                                                                                function funcAjax()
                                                                                {
                                                                                    var resp=peticion_http.responseText;
                                                                                    arrResp=resp.split('|');
                                                                                    if(arrResp[0]=='1')
                                                                                    {
                                                                                        ventanaAM.close();
                                                                                        gE('frmActualizar').submit();
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                    }
                                                                                }
                                                                                obtenerDatosWeb('../paginasFunciones/funcionesOrganigrama.php',funcAjax, 'POST','funcion=54&obj='+obj,true);
                                                                                
                                                                            }
                                                                        }
                                                                        msgConfirm('Est&aacute; seguro de querer modificar el sueldo base de usuario seleccionado?',resp);
                                                                        
                                                                        
                                                                       
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

function cuentaPagoChange(combo)
{
	var idUsuario=gE('idUsuario').value;
	var valor=obtenerValorSelect(combo);
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
   obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=156&idUsuario='+idUsuario+'&valor='+valor+'&accion=4',true);
    
}