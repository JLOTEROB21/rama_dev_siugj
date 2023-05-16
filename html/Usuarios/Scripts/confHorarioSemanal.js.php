<?php 	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
?>
Ext.onReady(inicializar);
var alDatosDiasLibres;
var cmbHoraInicio;
var cmbHoraFin;
var intervalo;

function inicializar()
{	
	var hI=new Date('01/01/2010 00:00 AM');
    var hF=new Date('01/01/2010 11:59 PM');
	intervalo=generarIntervaloHoras(hI,hF,15);
	cmbHoraInicio=crearComboExt('cmbHoraInicio',intervalo);
    cmbHoraFin=crearComboExt('cmbHoraFin',intervalo);
	dsDatos=arrDiasConf;
    alDatos=	new Ext.data.SimpleStore	(
                                                {
                                                    fields:	[
                                                                {name: 'idDiaTrabajo'},
                                                                {name: 'dia'},
                                                                {name: 'hInicio'},
                                                                {name: 'hFin'},
                                                                {name: 'numDia'}
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
															header:'D&iacute;a',
															width:130,
															sortable:true,
															dataIndex:'dia'
														},
														{
															header:'Hora de inicio',
															width:120,
															sortable:true,
															dataIndex:'hInicio',
                                                            editor:cmbHoraInicio,
                                                            renderer:formatHora
														},
                                                        {
															header:'Hora de t&eacute;rmino',
															width:120,
															sortable:true,
															dataIndex:'hFin',
                                                            editor:cmbHoraFin,
                                                            renderer:formatHora
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gridDiasTrabajo',
                                                            store:alDatos,
                                                            clicksToEdit:1,
                                                            frame:true,
                                                            y:40,
                                                            cm: cModelo,
                                                            height:260,
                                                            width:460,
                                                            sm:chkRow,
                                                            renderTo:'tblDiasTrabajo',
                                                            tbar:	[
                                                            			{
                                                                        	text:'Agregar d&iacute;a laboral',
                                                                            icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            handler:function()
                                                                            		{
                                                                                    	mostrarVentanaAgregarDia();
                                                                                    }
                                                                        },
                                                                        {
                                                                        	text:'Remover d&iacute;a laboral',
                                                                            icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            handler:function()
                                                                            		{
                                                                                    	function resp(btn)
                                                                                        {
                                                                                        	var filasDias=tblGrid.getSelectionModel().getSelections();
                                                                                            if(filasDias.length==0)
                                                                                            {
                                                                                                msgBox('Al menos debe seleccionar un d&iacute;a para remover');
                                                                                                return;
                                                                                            }
                                                                                        	if(btn=='yes')
                                                                                            {
                                                                                            	var x;
                                                                                                var dias='';
                                                                                                for(x=0;x<filasDias.length;x++)
                                                                                                {
                                                                                                    if(dias=='')
                                                                                                        dias=filasDias[x].get('idDiaTrabajo');
                                                                                                    else
                                                                                                        dias+=','+filasDias[x].get('idDiaTrabajo');
                                                                                                }
                                                                                            	function funcAjax()
                                                                                                {
                                                                                                    var resp=peticion_http.responseText;
                                                                                                    arrResp=resp.split('|');
                                                                                                    if(arrResp[0]=='1')
                                                                                                    {
                                                                                                    	tblGrid.getStore().remove(filasDias);
                                                                                                        actualizarHoras();
                                                                                                    }
                                                                                                    else
                                                                                                    {
                                                                                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                    }
                                                                                                }
                                                                                                obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=116&idDias='+dias,true);
                                                                                            }
                                                                                        }
                                                                                    	msgConfirm('Est&aacute; seguro de querer remover el d&iacute;a seleccionado?',resp);
                                                                                    }
                                                                        }
                                                            		]
                                                        }
                                                    );
                                                    
	
 	alDatosDiasLibres=	new Ext.data.SimpleStore	(
                                                            {
                                                                fields:	[
                                                                            {name: 'numDia'},
                                                                            {name: 'dia'}
                                                                        ]
                                                            }
                                                        );

    alDatosDiasLibres.loadData(arrDiasLibres);                                                    
	tblGrid.on('afteredit',funcTblEdit);
}

function formatHora(valor)
{
	var h=new Date('01/01/2010 '+valor);
    
	return h.format('h:i A');
}

function funcTblEdit(e)
{
	var campoMod=0;
	if(e.column==3)
    {
    	var hI=new Date('01/01/2010 '+e.value);
        var hF=new Date('01/01/2010 '+e.record.get('hFin'));
        if(hI>hF)
        {
            function respHI()
            {
                e.record.set('hInicio',e.originalValue);
            }
            msgBox('La hora inicial no puede ser mayor que la hora de t&eacute;rmino',respHI);
            return;
        }
        else
        {
        	
            if(hI.format('H:i')==hF.format('H:i'))
            {
                function respHF()
                {
                    e.record.set('hInicio',e.originalValue);
                }
                msgBox('La hora de t&eacute;rmino no puede ser igual a la hora de inicio',respHF);
                return;
            }
        }
        campoMod=1;
    }
    else
    {
    	var hI=new Date('01/01/2010 '+e.record.get('hInicio'));
        var hF=new Date('01/01/2010 '+e.value);
        if(hI>hF)
        {
            function respHI()
            {
                e.record.set('hFin',e.originalValue);
            }
            msgBox('La hora inicial no puede ser mayor que la hora de t&eacute;rmino',respHI);
            return;
        }
        else
        {
            if(hI.format('H:i')==hF.format('H:i'))
            {
                function respHF()
                {
                    e.record.set('hFin',e.originalValue);
                }
                msgBox('La hora de t&eacute;rmino no puede ser igual a la hora de inicio',respHF);
                return;
            }
        }
        campoMod=2;
    }
    
    if(campoMod!=0)
    {
    	function funcAjax()
        {
            var resp=peticion_http.responseText;
            arrResp=resp.split('|');
            if(arrResp[0]=='1')
            {
            	actualizarHoras();
            }
            else
            {
                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                if(campoMod==1)
                	e.record.set('hInicio',e.originalValue);
                else
                	e.record.set('hFin',e.originalValue);
                
            }
        }
        obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=117&idDia='+e.record.get('idDiaTrabajo')+'&campoMod='+campoMod+'&hora='+e.value,true);
    }
}

function mostrarVentanaAgregarDia()
{
	var hInicio=crearComboExt('hInicio',intervalo,175,10,130);
    hInicio.setWidth(120);
    var hFin=crearComboExt('hFin',intervalo,175,40,130);
    hFin.setWidth(120);
	var gDias=crearGridDiasTrabajo();
    gDias.getStore().loadData(arrDiasLibres);
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:15,
                                                        	html:'Hora de inicio de labores:'
                                                        },
                                                        hInicio,
                                                        
                                                        {
                                                        	x:10,
                                                            y:45,
                                                        	html:'Hora de t&eacute;rmino de labores:'
                                                        },
                                                        hFin,
                                                        gDias

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar d&iacute;a laboral',
										width: 360,
										height:400,
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
																		var hInicio=Ext.getCmp('hInicio');
                                                                        var hFin=Ext.getCmp('hFin');
                                                                        
                                                                        var hI=new Date('01/01/2010 '+hInicio.getValue());
                                                                        var hF=new Date('01/01/2010 '+hFin.getValue());
                                                                        var idUsuario=gE('idUsuario').value;
                                                                        if(hI=='')
                                                                        {
                                                                        	function respHIO()
                                                                            {
                                                                           		hInicio.focus();   
                                                                            }
                                                                        	msgBox('La hora de inicio es obligatoria',respHIO)
                                                                            return;
                                                                        }
                                                                        
                                                                        if(hF=='')
                                                                        {
                                                                        	function respHFO()
                                                                            {
                                                                           		hFin.focus();   
                                                                            }
                                                                        	msgBox('La hora de t&eacute;rmino es obligatoria',respHFO)
                                                                            return;
                                                                        }
                                                                        
                                                                        if(hI>hF)
                                                                        {
                                                                        	function respHI()
                                                                            {
                                                                            	hInicio.focus();
                                                                            }
                                                                        	msgBox('La hora inicial no puede ser mayor que la hora de t&eacute;rmino',respHI);
                                                                            return;
                                                                        }
                                                                        else
                                                                        {
                                                                       	 	if(hI.format('H:i')==hF.format('H:i'))
                                                                            {
                                                                                function respHF()
                                                                                {
                                                                                    hF.focus();
                                                                                }
                                                                                msgBox('La hora de t&eacute;rmino no puede ser igual a la hora de inicio',respHF);
                                                                                return;
                                                                            }
                                                                        }
                                                                        var filasDias=gDias.getSelectionModel().getSelections();
                                                                        if(filasDias.length==0)
                                                                        {
                                                                        	msgBox('Al menos debe seleccionar un d&iacute;a');
                                                                            return;
                                                                        }
                                                                        var horaI=hI;
                                                                        var horaF=hF;
                                                                        hI=hI.format('H:i');
                                                                        hF=hF.format('H:i');
                                                                        var dias='';
                                                                        var x;
                                                                        var pos;
                                                                        var almacen=gEx('gridDiasTrabajo').getStore();
                                                                        var ct=0;
                                                                        var fDia;
                                                                        var hInicio;
                                                                        var hFin;
                                                                        for(x=0;x<filasDias.length;x++)
                                                                        {
                                                                        	if(dias=='')
                                                                            	dias=filasDias[x].get('numDia');
                                                                            else
                                                                            	dias+=','+filasDias[x].get('numDia');
                                                                             
                                                                            for(ct=0;ct<almacen.getCount();ct++)
                                                                            {
                                                                            	fDia=almacen.getAt(ct);
                                                                                
                                                                                if(fDia.get('numDia')==filasDias[x].get('numDia'))
                                                                                {
                                                                                	if(colisionaTiempo('01/01/2010 '+fDia.get('hInicio'),'01/01/2010 '+fDia.get('hFin'),horaI.format('d/m/Y H:i'),horaF.format('d/m/Y H:i'),false,'d/m/Y H:i'))
                                                                                    {
                                                                                    	msgBox("El horario colisiona con el dia "+arrDias[parseInt(fDia.get('numDia'))]+" en el horario de "+fDia.get('hInicio')+"-"+fDia.get('hFin'));
                                                                                    	return false;
                                                                                    }
                                                                                	
                                                                                }
                                                                            }
                                                                            
                                                                                
                                                                                
                                                                                
                                                                        }
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	var arrDatos=eval(arrResp[1]);
                                                                                Ext.getCmp('gridDiasTrabajo').getStore().loadData(arrDatos);
                                                                            	gDias.getStore().remove(filasDias);
                                                                                actualizarHoras();
                                                                                ventanaAM.close();
                                                                                
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=100&hInicio='+hI+'&hFin='+hF+'&dias='+dias+'&idUsuario='+idUsuario,true);
                                                                        
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

function crearGridDiasTrabajo()
{
	var chkRow=new Ext.grid.CheckboxSelectionModel();
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														chkRow,
														{
															header:'D&iacute;a',
															width:150,
															sortable:true,
															dataIndex:'dia'
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            x:10,
                                                            y:80,
                                                            id:'gridDias',
                                                            store:alDatosDiasLibres,
                                                            frame:true,
                                                           
                                                            cm: cModelo,
                                                            height:220,
                                                            width:260,
                                                            sm:chkRow
                                                        }
                                                    );
	return 	tblGrid;
}

function actualizarHoras()
{
	var	gridDiasTrabajo=Ext.getCmp('gridDiasTrabajo');
    var almacenDatos=gridDiasTrabajo.getStore();
    var x;
    var totalHoras=0;
    var totalMinutos=0;
    var fila;
    var hInicio;
    var hFin;
    var diferencia;
    var difFecha;
    for(x=0;x<almacenDatos.getCount();x++)
    {
    	fila=almacenDatos.getAt(x);
        hInicio=new Date('01/01/2010 '+fila.get('hInicio'));
        hFin=new Date('01/01/2010 '+fila.get('hFin'));
        diferencia=hFin.add(Date.HOUR,-hInicio.getHours()).add(Date.SECOND,-hInicio.getMinutes());
        totalHoras+=parseInt(diferencia.format('g'));
        totalMinutos+=parseInt(diferencia.format('i'));
    }
    
    var hExtra=Math.floor((totalMinutos/60));
    totalHoras+=hExtra;
    totalMinutos-=(hExtra*60);
    gE('lblTotalHoras').innerHTML=totalHoras;
    gE('lblTotalMinutos').innerHTML=totalMinutos;
}

function registraEntradaChange(combo)
{
	var idUsuario=gE('idUsuario').value;
	var valor=obtenerValorSelect(combo);
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	if(valor=='0')
            {
            	
            	oE('filaTol');
            }
            else
            {
            	mE('filaTol');
            }
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=156&idUsuario='+idUsuario+'&valor='+valor+'&accion=1',true);
}

function modificarCodigo()
{
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            html:'Ingrese el c&oacute;digo de identificaci&oacute;n:'
                                                        },
														{
                                                        	xtype:'textfield',
                                                            id:'txtCodigo1',
                                                            width:200,
                                                            x:220,
                                                            y:5
                                                        },
                                                        {
                                                        	xtype:'textfield',
                                                            id:'txtCodigo2',
                                                            width:200,
                                                            x:220,
                                                            y:35
                                                        },
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            html:'Confirme el c&oacute;digo de identificaci&oacute;n:'
                                                        }

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Modificar c&oacute;digo de identificaci&oacute;n',
										width: 450,
										height:150,
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
                                                                	gEx('txtCodigo1').focus(true,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
																		var txtCodigo1=gEx('txtCodigo1');
                                                                        var txtCodigo2=gEx('txtCodigo2');
                                                                        if(txtCodigo1.getValue()=='')
                                                                        {
                                                                        	function respC1()
                                                                            {
                                                                            	txtCodigo1.focus();
                                                                            }
                                                                        	msgBox('El c&oacute;digo de identificaci&oacute;n ingresado no es v&aacute;lido',respC1);
                                                                            return;
                                                                        }
                                                                        if(txtCodigo1.getValue()!=txtCodigo2.getValue())
                                                                        {
                                                                        	function respC2()
                                                                            {
                                                                            	txtCodigo2.focus();
                                                                            }
                                                                        	msgBox('Los c&oacute;digos de identificaci&oacute;n ingresados no coinciden',respC2);
                                                                            return;
                                                                        }
                                                                        
                                                                        function resp(btn)
                                                                        {
                                                                        	if(btn=='yes')
                                                                            {
                                                                                var idUsuario=gE('idUsuario').value;
                                                                                var valor=txtCodigo1.getValue();
                                                                                function funcAjax()
                                                                                {
                                                                                    var resp=peticion_http.responseText;
                                                                                    arrResp=resp.split('|');
                                                                                    if(arrResp[0]=='1')
                                                                                    {
                                                                                    	gE('lblCodigo').innerHTML=valor;
                                                                                        ventanaAM.close();
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                    }
                                                                                }
                                                                                obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=156&idUsuario='+idUsuario+'&valor='+valor+'&accion=2',true);
                                                                       		}
                                                                       }
                                                                       msgConfirm('Est&aacute; seguro de querer modificar el c&oacute;digo de identificaci&oacute;n del usuario seleccionado?',resp);
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

function cmbToleranciaChange(combo)
{
	
	var valor=obtenerValorSelect(combo);
    if(valor=='0')
    {
    	var idUsuario=gE('idUsuario').value;
        var valor='';
        function funcAjax()
        {
            var resp=peticion_http.responseText;
            arrResp=resp.split('|');
            if(arrResp[0]=='1')
            {
	            gE('lblTolerancia').innerHTML=gE('toleranciaGral').value;
                gE('esquemaTolerancia').value='0';
                oE('btnModificar');
            }
            else
            {
                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
            }
        }
        obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=156&idUsuario='+idUsuario+'&valor=0&accion=3&tolerancia='+valor,true);
    	
    }
    else
    {
    	mostrarVentanaTolerancia('');
    }
}

function mostrarVentanaTolerancia(val)
{
	var valTolerancia='';
	if(val!='')
    {
    	valTolerancia=bD(val);
    }
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            html:'Ingrese la tolerancia de retardo:'
                                                        },
														{
                                                        	xtype:'numberfield',
                                                            id:'txtTolerancia',
                                                            width:40,
                                                            x:220,
                                                            y:5,
                                                            allowDecimals:false,
                                                            allowNegative:false,
                                                            value:valTolerancia
                                                        },
                                                        {
                                                        	x:270,
                                                            y:10,
                                                            html:'minutos'
                                                        }

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Tolerancia de retardo personal',
										width: 450,
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
                                                                	gEx('txtTolerancia').focus(true,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
																		var txtTolerancia=gEx('txtTolerancia');
                                                                       
                                                                        if(txtTolerancia.getRawValue()=='')
                                                                        {
                                                                        	function respC1()
                                                                            {
                                                                            	txtTolerancia.focus();
                                                                            }
                                                                        	msgBox('El valor ingresado no es v&aacute;lido',respC1);
                                                                            return;
                                                                        }
                                                                        
                                                                        var idUsuario=gE('idUsuario').value;
                                                                        var valor=txtTolerancia.getValue();
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                                gE('lblTolerancia').innerHTML=valor;
                                                                                gE('esquemaTolerancia').value='1';
                                                                                mE('btnModificar');
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesProyectos.php',funcAjax, 'POST','funcion=156&idUsuario='+idUsuario+'&valor=1&accion=3&tolerancia='+valor,true);
                                                                       		
																	}
														},
														{
															text: '<?php echo $etj["lblBtnCancelar"]?>',
															handler:function()
																	{
                                                                    	var esquemaTolerancia=gE('esquemaTolerancia').value;
                                                                    	if(esquemaTolerancia=='0')
                                                                        {
                                                                        	selElemCombo(gE('cmbTolerancia'),'0');
                                                                        }
																		ventanaAM.close();
																	}
														}
													]
									}
								);
	ventanaAM.show();	
}