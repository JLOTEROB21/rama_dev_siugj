<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$consultas="SELECT codigoUnidad,unidad FROM 817_organigrama WHERE institucion=10 AND codigoUnidad LIKE '10000003%' ORDER BY unidad";
	$arrDistritos=$con->obtenerFilasArreglo($consultas);
	
	$consultas="SELECT codigoUnidad,unidad FROM 817_organigrama WHERE institucion=12 AND codigoUnidad LIKE '10000003%' ORDER BY unidad";
	$arrCircuitos=$con->obtenerFilasArreglo($consultas);
	
	$consultas="SELECT codigoUnidad,unidad FROM 817_organigrama WHERE institucion=13 AND codigoUnidad LIKE '10000003%' ORDER BY unidad";
	$arrMunicipios=$con->obtenerFilasArreglo($consultas);
	
	$consultas="SELECT claveUnidad,nombreUnidad FROM _17_tablaDinamica ORDER BY nombreUnidad";
	$arrDespachos=$con->obtenerFilasArreglo($consultas);
	
	
?>


var arrDistritos=<?php echo $arrDistritos?>;
var arrCircuitos=<?php echo $arrCircuitos?>;
var arrMunicipios=<?php echo $arrMunicipios?>;
var arrDespachos=<?php echo $arrDespachos?>;


var arrSiNo=[['1','S\xED'],['0','No']];
var arrSituacionFecha=[['1','Activo'],['2','Inactivo']];
Ext.onReady(inicializar);

function inicializar()
{
    new Ext.Viewport(	{
                                layout: 'border',
                                items: [
                                            {
                                                xtype:'panel',
                                                region:'center',
                                                layout:'border',
                                                cls:'panelSiugj',
                                                title:'Configuraci&oacute;n de fechas inh&aacute;biles',
                                               
                                                items:	[
                                                            crearGridFechas()
                                                        ]
                                            }
                                         ]
                            }
                        )   
}


function crearGridFechas()
{
	var cmbAnio=crearComboExt('cmbAnio',[['2022','2022'],['2023','2023'],['2024','2024'],['2025','2025'],['2026','2026']],0,0,200,{listClass:"listComboSIUGJ", fieldClass:"comboSIUGJ",ctCls:"comboWrapSIUGJ"});
	cmbAnio.setValue('<?php echo date("Y")?>')
    cmbAnio.on('select',function(cmb,registro)
    					{
                        	gEx('gridComentarios').getStore().reload();
                        }
    			)
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idRegistro'},
		                                                {name: 'fechaInicio', type:'date', dateFormat:'Y-m-d'},
		                                                {name: 'fechaTermino', type:'date', dateFormat:'Y-m-d'},
		                                                {name: 'motivoDiaNoHabil'},
                                                        {name: 'situacionActual'},
                                                        {name: 'distrito'},
                                                        {name: 'circuito'},
                                                        {name: 'municipio'},
                                                        {name: 'despacho'},
                                                        {name: 'general'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../modulosEspeciales_SIUGJ/paginasFunciones/funcionesSIUGJ.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'fechaInicio', direction: 'ASC'},
                                                            groupField: 'fechaInicio',
                                                            remoteGroup:false,
				                                            remoteSort: true,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='19';
                                        proxy.baseParams.anio=cmbAnio.getValue();
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer({width:70}),
                                                            
                                                            {
                                                                header:'Fecha de Inicio',
                                                                width:170,
                                                                sortable:true,
                                                                dataIndex:'fechaInicio',
                                                                renderer:function(val)
                                                                		{
                                                                        	return val.format('d/m/Y');
                                                                        }
                                                            },
                                                            {
                                                                header:'Fecha de T&eacute;rmino',
                                                                width:170,
                                                                sortable:true,
                                                                dataIndex:'fechaTermino',
                                                                renderer:function(val)
                                                                		{
                                                                        	return val.format('d/m/Y');
                                                                        }
                                                            },
                                                            {
                                                                header:'Evento',
                                                                width:300,
                                                                sortable:true,
                                                                dataIndex:'motivoDiaNoHabil',
                                                                renderer:function(val)
                                                                		{
                                                                        	return mostrarValorDescripcion(val)
                                                                        }
                                                            },
                                                            {
                                                                header:'&Aacute;mbito General',
                                                                width:170,
                                                                sortable:true,
                                                                dataIndex:'general',
                                                                renderer:function(val)
                                                                		{
                                                                        	return (val=='1'?'S&iacute;':'No');
                                                                        }
                                                            },
                                                            {
                                                                header:'Distrito al cual aplica',
                                                                width:350,
                                                                sortable:true,
                                                                dataIndex:'distrito',
                                                                renderer:function(val)
                                                                		{
                                                                        	return mostrarValorDescripcion(val)
                                                                        }
                                                            },
                                                            {
                                                                header:'Circuito al cual aplica',
                                                                width:350,
                                                                sortable:true,
                                                                dataIndex:'circuito',
                                                                renderer:function(val)
                                                                		{
                                                                        	return mostrarValorDescripcion(val)
                                                                        }
                                                            },
                                                            {
                                                                header:'Municipio al cual aplica',
                                                                width:350,
                                                                sortable:true,
                                                                dataIndex:'municipio',
                                                                renderer:function(val)
                                                                		{
                                                                        	return mostrarValorDescripcion(val)
                                                                        }
                                                            },
                                                            {
                                                                header:'Despacho al cual aplica',
                                                                width:350,
                                                                sortable:true,
                                                                dataIndex:'despacho',
                                                                renderer:function(val)
                                                                		{
                                                                        	return mostrarValorDescripcion(val)
                                                                        }
                                                            },
                                                            {
                                                                header:'Situaci&oacute;n actual',
                                                                width:300,
                                                                sortable:true,
                                                                dataIndex:'situacionActual',
                                                                renderer:function(val)
                                                                		{
                                                                        	return formatearValorRenderer(arrSituacionFecha,val);
                                                                        }
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gridComentarios',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                cm: cModelo,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                columnLines : true,
                                                                cls:'gridSiugjSeccion',
                                                                 
                                                                tbar:	[
                                                                			{	
                                                                                xtype:'label',
                                                                                html:'A&ntilde;o:&nbsp;&nbsp;'
                                                                            },
                                                                            cmbAnio,
                                                                			{
                                                                                icon:'../principalPortal/imagesSIUGJ/add.png',
                                                                                cls:'x-btn-text-icon',
                                                                                height:50,
                                                                                text:'Registrar Fecha Inh&aacute;bil',
                                                                                handler:function()
                                                                                        {
                                                                                        	mostrarVentanaAgregarFecha(-1)
                                                                                        }
                                                                            
                                                                            },
                                                                            {
                                                                                icon:'../principalPortal/imagesSIUGJ/pencil.png',
                                                                                cls:'x-btn-text-icon',
                                                                                height:50,
                                                                                text:'Modificar Fecha Inh&aacute;bil',
                                                                                handler:function()
                                                                                        {
                                                                                        	var fila=tblGrid.getSelectionModel().getSelected();
                                                                                        	mostrarVentanaAgregarFecha(fila.data.idRegistro,fila)
                                                                                        }
                                                                            
                                                                            },
                                                                            {
                                                                                icon:'../principalPortal/imagesSIUGJ/delete.png',
                                                                                cls:'x-btn-text-icon',
                                                                                height:50,
                                                                                id:'btnRemoveDocumento',
                                                                                text:'Remover Fecha Inh&aacute;bil',
                                                                                handler:function()
                                                                                        {
                                                                                    		var fila=tblGrid.getSelectionModel().getSelected()
                                                                                            if(!fila)
                                                                                            {
                                                                                            	msgBox('Debe seleccionar la fecha que desea remover');
                                                                                            	return;
                                                                                            }
                                                                                            
                                                                                            
                                                                                            function respAux(btn)
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
                                                                                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                        }
                                                                                                    }
                                                                                                    obtenerDatosWeb('../modulosEspeciales_SIUGJ/paginasFunciones/funcionesSIUGJ.php',funcAjax, 'POST','funcion=26&iR='+fila.data.idRegistro,true);
                                                                                                    
                                                                                                }
                                                                                            }
                                                                                            msgConfirm('Est&aacute; seguro de querer remover la fecha seleccionada?',respAux);
                                                                                            
                                                                                    	}
                                                                            
                                                                            }
                                                                		],
                                                                view:new Ext.grid.GroupingView({
                                                                                                    forceFit:false,
                                                                                                    showGroupName: false,
                                                                                                    enableGrouping :false,
                                                                                                    enableNoGroups:false,
                                                                                                    enableGroupingMenu:false,
                                                                                                    hideGroupedColumn: false,
                                                                                                    startCollapsed:false
                                                                                                })
                                                            }
                                                        );
        return 	tblGrid;
}


function mostrarVentanaAgregarFecha(idFecha,fila)
{
	
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:15,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Fecha de Inicio: <span style="color:#F00">*</span>'
                                                        },
                                                        {
                                                        	x:210,
                                                            y:10,
                                                            html:'<div id="divFechaInicio"></div>'
                                                        },
                                                        {
                                                        	x:400,
                                                            y:15,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Fecha de T&eacute;rmino:  <span style="color:#F00">*</span>'
                                                        },
                                                        {
                                                        	x:600,
                                                            y:10,
                                                            html:'<div id="divFechaFin"></div>'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:65,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Nombre del Evento:  <span style="color:#F00">*</span>'
                                                        },
                                                        {
                                                        	x:210,
                                                            y:60,
                                                            xtype:'textfield',
                                                            width:400,
                                                            cls:'controlSIUGJ',
                                                            id:'txtNombreEvento'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:110,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'&Aacute;mbito General:'
                                                        },
                                                        {
                                                        	x:210,
                                                            y:105,
                                                            html:'<div id="divComboAmbito"></div>'
                                                        },
                                                        {
                                                        	xtype:'tabpanel',
                                                            x:10,
                                                            id:'tpanelAmbito',
                                                            disabled:true,
                                                            cls:'tabPanelSIUGJ',
                                                            title:'&Aacute;mbito de Aplicaci&oacute;n',
                                                            y:155,
                                                            width:710,
                                                            height:300,
                                                            activeTab:0,
                                                            items:	[
                                                            			{
                                                                        	xtype:'panel',
                                                                            title:'Distritos',
                                                                            items:	[
                                                                            			crearGridCatalogos(idFecha,1)
                                                                            		]
                                                                        },
                                                                        {
                                                                        	xtype:'panel',
                                                                            title:'Circuitos',
                                                                            items:	[
                                                                            			crearGridCatalogos(idFecha,2)
                                                                            		]
                                                                        },
                                                            			{
                                                                        	xtype:'panel',
                                                                            title:'Municipios',
                                                                            items:	[
                                                                            			crearGridCatalogos(idFecha,3)
                                                                            		]
                                                                        },
                                                            			{
                                                                        	xtype:'panel',
                                                                            title:'Despachos',
                                                                            items:	[
                                                                            			crearGridCatalogos(idFecha,4)
                                                                            		]
                                                                        }
                                                            		]
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: idFecha==-1?'Registrar Fecha Inh&aacute;bil':'Modificar Fecha Inh&aacute;bil',
										width: 770,
										height:570,
										layout: 'fit',
										plain:true,
										modal:true,
                                        cls:'msgHistorialSIUGJ',
										bodyStyle:'padding:5px;',
										buttonAlign:'center',
										items: form,
										listeners : {
													show : {
																buffer : 10,
																fn : function() 
																{
                                                                
                                                                	var cmbSiNo=crearComboExt('cmbSiNo',arrSiNo,0,0,150,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboAmbito'});    
                                                                    cmbSiNo.on('select',function(cmb,registro)
                                                                                        {
                                                                                            if(registro.data.id=='1')
                                                                                            {
                                                                                                gEx('tpanelAmbito').disable();
                                                                                                var x;
                                                                                                for(x=1;x<=4;x++)
                                                                                                {
                                                                                                    gEx('gridCatalogo_'+x).getStore().removeAll();
                                                                                                }
                                                                                            }
                                                                                            else
                                                                                            {
                                                                                                gEx('tpanelAmbito').enable();
                                                                                            }
                                                                                        }
                                                                                )
                                                                    
                                                                    cmbSiNo.setValue('1');
    
                                                                
                                                                	
                                                                	new Ext.form.DateField	(
                                                                                                {
                                                                                                    renderTo:'divFechaInicio',
                                                                                                    width:130,
                                                                                                    xtype:'datefield',
                                                                                                    id:'dteFechaInicio',
                                                                                                    ctCls:'campoFechaSIUGJ',
                                                                                                    listeners:	{
                                                                                                                    select:function(dte,fecha)
                                                                                                                            {
                                                                                                                                if(gEx('dteFechaTermino').getValue()=='')
                                                                                                                                {
                                                                                                                                    gEx('dteFechaTermino').setValue(fecha);
                                                                                                                                }
                                                                                                                            }
                                                                                                                }
                                                                                                }
                                                                                              )
                                                                	
                                                                    
                                                                    new Ext.form.DateField	(
                                                                                                {
                                                                                                	renderTo:'divFechaFin',
                                                                                                    width:130,
                                                                                                    xtype:'datefield',
                                                                                                    ctCls:'campoFechaSIUGJ',
                                                                                                    id:'dteFechaTermino'
                                                                                                }
                                                                                             )
                                                                    
                                                                    
                                                                
                                                                
                                                                    if(fila)
                                                                    {
                                                                        gEx('dteFechaInicio').setValue(fila.data.fechaInicio);
                                                                        gEx('dteFechaTermino').setValue(fila.data.fechaTermino);
                                                                        gEx('txtNombreEvento').setValue(fila.data.motivoDiaNoHabil);
                                                                        cmbSiNo.setValue(fila.data.general);
                                                                        dispararEventoSelectCombo('cmbSiNo');
                                                                    }
																}
															}
												},
										buttons:	[
                                        				{
															text: '<?php echo $etj["lblBtnCancelar"]?>',
                                                            cls:'btnSIUGJCancel',
                                                            width:140,
															handler:function()
																	{
																		ventanaAM.close();
																	}
														},
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            cls:'btnSIUGJ',
                                                            width:140,
															handler: function()
																	{
																		var dteFechaInicio=gEx('dteFechaInicio');
                                                                        var dteFechaTermino=gEx('dteFechaTermino');	
                                                                        var txtNombreEvento=gEx('txtNombreEvento');
                                                                        var cmbSiNo=gEx('cmbSiNo');
                                                                        if(dteFechaInicio.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	dteFechaInicio.focus();
                                                                            }
                                                                        	msgBox('Debe indicar la fecha de inicio del evento',resp);	
                                                                        	return;
                                                                        }
                                                                        
                                                                        if(dteFechaTermino.getValue()=='')
                                                                        {
                                                                        	function resp2()
                                                                            {
                                                                            	dteFechaTermino.focus();
                                                                            }
                                                                        	msgBox('Debe indicar la fecha de t&eacute;rmino del evento',resp2);	
                                                                        	return;
                                                                        }
                                                                        
                                                                        if(dteFechaInicio.getValue()>dteFechaTermino.getValue())
                                                                        {
                                                                        	function resp3()
                                                                            {
                                                                            	dteFechaInicio.focus();
                                                                            }
                                                                            msgBox('La fecha de t&eacute;rmino del evento no puede ser mayor que la fecha de t&eacute;rmino',resp3);	
                                                                        	return;
                                                                        }
                                                                        
                                                                        
                                                                        if(txtNombreEvento.getValue()=='')
                                                                        {
                                                                        	function resp3()
                                                                            {
                                                                            	txtNombreEvento.focus();
                                                                            }
                                                                        	msgBox('Debe indicar el nombre del evento del evento',resp3);	
                                                                        	return;
                                                                        }
                                                                        
                                                                        
                                                                        var arrDistritos='';
                                                                        
                                                                        var o='';
                                                                        var fila;
                                                                        var gridCatalogo=gEx('gridCatalogo_1');
                                                                        var x;
                                                                        
                                                                        for(x=0;x<gridCatalogo.getStore().getCount();x++)
                                                                        {
                                                                        	fila=gridCatalogo.getStore().getAt(x);
                                                                            o='{"cveElemento":"'+fila.data.cveElemento+'"}';
                                                                            if(arrDistritos=='')
                                                                            	arrDistritos=o;
                                                                            else
                                                                            	arrDistritos+=','+o;
                                                                        }
                                                                        
                                                                        
                                                                        var arrCircuitos='';
                                                                        
                                                                        o='';
                                                                        
                                                                        gridCatalogo=gEx('gridCatalogo_2');
                                                                        for(x=0;x<gridCatalogo.getStore().getCount();x++)
                                                                        {
                                                                        	fila=gridCatalogo.getStore().getAt(x);
                                                                            o='{"cveElemento":"'+fila.data.cveElemento+'"}';
                                                                            if(arrCircuitos=='')
                                                                            	arrCircuitos=o;
                                                                            else
                                                                            	arrCircuitos+=','+o;
                                                                        }
                                                                        
                                                                        
                                                                        var arrMunicipios='';
                                                                        
                                                                         o='';
                                                                        
                                                                        gridCatalogo=gEx('gridCatalogo_3');
                                                                        for(x=0;x<gridCatalogo.getStore().getCount();x++)
                                                                        {
                                                                        	fila=gridCatalogo.getStore().getAt(x);
                                                                            o='{"cveElemento":"'+fila.data.cveElemento+'"}';
                                                                            if(arrMunicipios=='')
                                                                            	arrMunicipios=o;
                                                                            else
                                                                            	arrMunicipios+=','+o;
                                                                        }
                                                                        
                                                                        var arrDespachos='';
                                                                        
                                                                        
                                                                        gridCatalogo=gEx('gridCatalogo_4');
                                                                        for(x=0;x<gridCatalogo.getStore().getCount();x++)
                                                                        {
                                                                        	fila=gridCatalogo.getStore().getAt(x);
                                                                            o='{"cveElemento":"'+fila.data.cveElemento+'"}';
                                                                            if(arrDespachos=='')
                                                                            	arrDespachos=o;
                                                                            else
                                                                            	arrDespachos+=','+o;
                                                                        }
                                                                        
                                                                        
                                                                        var cadObj='{"idRegistro":"'+idFecha+'","fechaInicio":"'+cv(dteFechaInicio.getValue().format('Y-m-d'))+
                                                                        			'","fechaFin":"'+cv(dteFechaInicio.getValue().format('Y-m-d'))+
                                                                        			'","nombreEvento":"'+cv(txtNombreEvento.getValue())+'","ambitoGeneral":"'+cmbSiNo.getValue()+
                                                                                    '","arrDistritos":['+arrDistritos+'],"arrCircuitos":['+arrCircuitos+'],"arrMunicipios":['+arrMunicipios+
                                                                                    '],"arrDespachos":['+arrDespachos+']}'
                                                                        
                                                                        
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	gEx('gridComentarios').getStore().reload();
                                                                                function resp()
                                                                                {
                                                                                	ventanaAM.close();
                                                                                }
                                                                                msgBox('La informaci&oacute;n ha sido guardada corretamente',resp);
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../modulosEspeciales_SIUGJ/paginasFunciones/funcionesSIUGJ.php',funcAjax, 'POST','funcion=25&cadObj='+cadObj,true);

																	}
														}
														
													]
									}
								);
	ventanaAM.show();	
}



function crearGridCatalogos(idFecha,tA)
{

	var lblEtiqueta='';
    switch(tA)
    {
    	case 1:
        	lblEtiqueta='Distrito';
        break;
        case 2:
        	lblEtiqueta='Circuito';
        break;
        case 3:
        	lblEtiqueta='Municipio';
        break;
        case 4:
        	lblEtiqueta='Despacho';
        break;
    }



	 var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'cveElemento'},
		                                                {name: 'nombreElemento'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../modulosEspeciales_SIUGJ/paginasFunciones/funcionesSIUGJ.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'nombreElemento', direction: 'ASC'},
                                                            groupField: 'nombreElemento',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='20';
                                        proxy.baseParams.iR=idFecha;
                                        proxy.baseParams.tA=tA;
                                    }
                        )   
       
       
       
       var chkRow=new Ext.grid.CheckboxSelectionModel({width:40});
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer({width:40}),
                                                            chkRow,
                                                            {
                                                                header:lblEtiqueta,
                                                                width:450,
                                                                sortable:true,
                                                                dataIndex:'nombreElemento',
                                                                renderer:mostrarValorDescripcion
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gridCatalogo_'+tA,
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                cm: cModelo,
                                                                sm:chkRow,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                cls:'gridSiugjPrincipal',
                                                                columnLines : true,
                                                                height:350,
                                                                tbar:	[
                                                                            {
                                                                                icon:'../images/add.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Agregar '+lblEtiqueta,
                                                                                handler:function()
                                                                                        {
                                                                                            switch(tA)
                                                                                            {
                                                                                                case 1:
                                                                                                    mostrarVentanaAgregarDistrito(idFecha)
                                                                                                break;
                                                                                                case 2:
                                                                                                	mostrarVentanaAgregarCircuito(idFecha)
                                                                                                   
                                                                                                break;
                                                                                                case 3:
                                                                                                    mostrarVentanaAgregarMunicipio(idFecha)
                                                                                                break;
                                                                                                case 4:
                                                                                                   mostrarVentanaAgregarDespacho(idFecha);
                                                                                                break;
                                                                                            }
                                                                                        }
                                                                                
                                                                            },
                                                                            {
                                                                            	xtype:'tbspacer',
                                                                                width:10
                                                                            },
                                                                            {
                                                                                icon:'../images/delete.png',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Remover '+lblEtiqueta,
                                                                                handler:function()
                                                                                        {
                                                                                        	var filas=tblGrid.getSelectionModel().getSelections();
                                                                                            
                                                                                            if(filas.length==0)
                                                                                            {
                                                                                            	msgBox('Debe seleccionar almenos un elemento a remover');
                                                                                            	return;
                                                                                            }
                                                                                            
                                                                                            function resp(btn)
                                                                                            {
                                                                                            	if(btn=='yes')
                                                                                                {
                                                                                                	tblGrid.getStore().remove(filas);
                                                                                                }
                                                                                            }
                                                                                            msgConfirm('Est&aacute; seguro de querer remover los elementos seleccionados?',resp);
                                                                                        }
                                                                                
                                                                            }
                                                                            
                                                                        ],
                                                                view:new Ext.grid.GroupingView({
                                                                                                    forceFit:false,
                                                                                                    showGroupName: false,
                                                                                                    enableGrouping :false,
                                                                                                    enableNoGroups:false,
                                                                                                    enableGroupingMenu:false,
                                                                                                    hideGroupedColumn: false,
                                                                                                    startCollapsed:false
                                                                                                })
                                                            }
                                                        );
        return 	tblGrid;
}

function mostrarVentanaAgregarDistrito(idFecha)
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
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Seleccione los distritos que desea agregar al &aacute;mbito de aplicaci&oacute;n:'
                                                        },
                                                        crearGridDistritosAdd(idFecha)
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar Distrito',
										width: 650,
										height:450,
										layout: 'fit',
										plain:true,
										modal:true,
                                        cls:'msgHistorialSIUGJ',
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
															text: '<?php echo $etj["lblBtnCancelar"]?>',
                                                            cls:'btnSIUGJCancel',
                                                            width:140,
															handler:function()
																	{
																		ventanaAM.close();
																	}
														},
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            cls:'btnSIUGJ',
                                                            width:140,
															handler: function()
																	{
                                                                    	var pos;
                                                                        var r;
                                                                        var registro=crearRegistro	(		
                                                                                                        [
                                                                                                            {name:'cveElemento'},
                                                                                                            {name: 'nombreElemento'}
                                                                                                        ]
                                                                                                    );
																		var filas=gEx('gridCatalogoAddDistrito').getSelectionModel().getSelections();
                                                                        var x;
                                                                        for(x=0;x<filas.length;x++)
                                                                        {
                                                                        	pos=obtenerPosFila(gEx('gridCatalogo_1').getStore(),'cveElemento',filas[x].data.cveDistrito);
                                                                            if(pos==-1)
                                                                            {
                                                                            	r=new registro	(
                                                                                					{
                                                                                                    	cveElemento:filas[x].data.cveDistrito,
                                                                                                        nombreElemento:filas[x].data.nombreDistrito
                                                                                                    }
                                                                                				)
                                                                            
                                                                            	gEx('gridCatalogo_1').getStore().add(r);	
                                                                            }
                                                                            
                                                                        }
                                                                        
                                                                        ventanaAM.close();
                                                                        	
																	}
														}
														
													]
									}
								);
	ventanaAM.show();	
}


function crearGridDistritosAdd(idFecha)
{
	 var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'cveDistrito'},
		                                                {name: 'nombreDistrito'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../modulosEspeciales_SIUGJ/paginasFunciones/funcionesSIUGJ.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'nombreDistrito', direction: 'ASC'},
                                                            groupField: 'nombreDistrito',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='21';
                                        proxy.baseParams.iR=idFecha;
                                        
                                    }
                        )   
       var chkRow=new Ext.grid.CheckboxSelectionModel({width:40});
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer({width:40}),
                                                            chkRow,
                                                            {
                                                                header:'Distrito',
                                                                width:450,
                                                                sortable:true,
                                                                dataIndex:'nombreDistrito',
                                                                renderer:mostrarValorDescripcion
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gridCatalogoAddDistrito',
                                                                store:alDatos,
                                                                x:10,
                                                                y:40,
                                                                frame:false,
                                                                cm: cModelo,
                                                                stripeRows :false,
                                                                loadMask:true,
                                                                columnLines : false,
                                                                height:300,
                                                                sm:chkRow,
                                                                width:610,
                                                                cls:'gridSiugjPrincipal',
                                                                view:new Ext.grid.GroupingView({
                                                                                                    forceFit:false,
                                                                                                    showGroupName: false,
                                                                                                    enableGrouping :false,
                                                                                                    enableNoGroups:false,
                                                                                                    enableGroupingMenu:false,
                                                                                                    hideGroupedColumn: false,
                                                                                                    startCollapsed:false
                                                                                                })
                                                            }
                                                        );
        return 	tblGrid;	
}

function mostrarVentanaAgregarCircuito(idFecha)
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
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Seleccione los circuitos que desea agregar al &aacute;mbito de aplicaci&oacute;n:'
                                                        },
                                                        crearGridCircuitosAdd(idFecha)
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar Circuito',
										width: 650,
										height:450,
										layout: 'fit',
										plain:true,
										modal:true,
                                        cls:'msgHistorialSIUGJ',
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
															text: '<?php echo $etj["lblBtnCancelar"]?>',
                                                            cls:'btnSIUGJCancel',
                                                            width:140,
															handler:function()
																	{
																		ventanaAM.close();
																	}
														},
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            cls:'btnSIUGJ',
                                                            width:140,
															handler: function()
																	{
                                                                    	var pos;
                                                                        var r;
                                                                        var registro=crearRegistro	(		
                                                                                                        [
                                                                                                            {name:'cveElemento'},
                                                                                                            {name: 'nombreElemento'}
                                                                                                        ]
                                                                                                    );
																		var filas=gEx('gridCatalogoAddCircuito').getSelectionModel().getSelections();
                                                                        var x;
                                                                        for(x=0;x<filas.length;x++)
                                                                        {
                                                                        	pos=obtenerPosFila(gEx('gridCatalogo_2').getStore(),'cveElemento',filas[x].data.cveCircuito);
                                                                            if(pos==-1)
                                                                            {
                                                                            	r=new registro	(
                                                                                					{
                                                                                                    	cveElemento:filas[x].data.cveCircuito,
                                                                                                        nombreElemento:filas[x].data.nombreCircuito
                                                                                                    }
                                                                                				)
                                                                            
                                                                            	gEx('gridCatalogo_2').getStore().add(r);	
                                                                            }
                                                                            
                                                                        }
                                                                        
                                                                        ventanaAM.close();
                                                                        	
																	}
														}
														
													]
									}
								);
	ventanaAM.show();	
}


function crearGridCircuitosAdd(idFecha)
{
	 var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'cveCircuito'},
		                                                {name: 'nombreCircuito'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../modulosEspeciales_SIUGJ/paginasFunciones/funcionesSIUGJ.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'nombreCircuito', direction: 'ASC'},
                                                            groupField: 'nombreCircuito',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='22';
                                        proxy.baseParams.iR=idFecha;
                                        
                                    }
                        )   
       var chkRow=new Ext.grid.CheckboxSelectionModel({width:40});
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer({width:40}),
                                                            chkRow,
                                                            {
                                                                header:'Circuito',
                                                                width:450,
                                                                sortable:true,
                                                                dataIndex:'nombreCircuito',
                                                                renderer:mostrarValorDescripcion
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gridCatalogoAddCircuito',
                                                                store:alDatos,
                                                                x:10,
                                                                y:40,
                                                                frame:false,
                                                                cm: cModelo,
                                                                cls:'gridSiugjPrincipal',
                                                                stripeRows :false,
                                                                loadMask:true,
                                                                columnLines : false,
                                                                height:300,
                                                                sm:chkRow,
                                                                width:610,
                                                                view:new Ext.grid.GroupingView({
                                                                                                    forceFit:false,
                                                                                                    showGroupName: false,
                                                                                                    enableGrouping :false,
                                                                                                    enableNoGroups:false,
                                                                                                    enableGroupingMenu:false,
                                                                                                    hideGroupedColumn: false,
                                                                                                    startCollapsed:false
                                                                                                })
                                                            }
                                                        );
        return 	tblGrid;	
}


function mostrarVentanaAgregarMunicipio(idFecha)
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
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Seleccione los municipio que desea agregar al &aacute;mbito de aplicaci&oacute;n:'
                                                        },
                                                        crearGridMunicipioAdd(idFecha)
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar Municipio',
										width: 650,
                                        cls:'msgHistorialSIUGJ',
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
															text: '<?php echo $etj["lblBtnCancelar"]?>',
                                                            cls:'btnSIUGJCancel',
                                                            width:140,
															handler:function()
																	{
																		ventanaAM.close();
																	}
														},
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            cls:'btnSIUGJ',
                                                            width:140,
															handler: function()
																	{
                                                                    	var pos;
                                                                        var r;
                                                                        var registro=crearRegistro	(		
                                                                                                        [
                                                                                                            {name:'cveElemento'},
                                                                                                            {name: 'nombreElemento'}
                                                                                                        ]
                                                                                                    );
																		var filas=gEx('gridCatalogoAddMunicipio').getSelectionModel().getSelections();
                                                                        var x;
                                                                        for(x=0;x<filas.length;x++)
                                                                        {
                                                                        	pos=obtenerPosFila(gEx('gridCatalogo_3').getStore(),'cveElemento',filas[x].data.cveMunicipio);
                                                                            if(pos==-1)
                                                                            {
                                                                            	r=new registro	(
                                                                                					{
                                                                                                    	cveElemento:filas[x].data.cveMunicipio,
                                                                                                        nombreElemento:filas[x].data.nombreMunicipio
                                                                                                    }
                                                                                				)
                                                                            
                                                                            	gEx('gridCatalogo_3').getStore().add(r);	
                                                                            }
                                                                            
                                                                        }
                                                                        
                                                                        ventanaAM.close();
                                                                        	
																	}
														}
														
													]
									}
								);
	ventanaAM.show();	
}


function crearGridMunicipioAdd(idFecha)
{
	 var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'cveMunicipio'},
		                                                {name: 'nombreMunicipio'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../modulosEspeciales_SIUGJ/paginasFunciones/funcionesSIUGJ.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'nombreMunicipio', direction: 'ASC'},
                                                            groupField: 'nombreMunicipio',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='23';
                                        proxy.baseParams.iR=idFecha;
                                        
                                    }
                        )   
       var chkRow=new Ext.grid.CheckboxSelectionModel({width:40});
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer({width:40}),
                                                            chkRow,
                                                            {
                                                                header:'Municipio',
                                                                width:450,
                                                                sortable:true,
                                                                dataIndex:'nombreMunicipio',
                                                                renderer:mostrarValorDescripcion
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gridCatalogoAddMunicipio',
                                                                store:alDatos,
                                                                x:10,
                                                                y:40,
                                                                frame:false,
                                                                cm: cModelo,
                                                                stripeRows :false,
                                                                loadMask:true,
                                                                cls:'gridSiugjPrincipal',
                                                                columnLines : false,
                                                                height:300,
                                                                sm:chkRow,
                                                                width:610,
                                                                view:new Ext.grid.GroupingView({
                                                                                                    forceFit:false,
                                                                                                    showGroupName: false,
                                                                                                    enableGrouping :false,
                                                                                                    enableNoGroups:false,
                                                                                                    enableGroupingMenu:false,
                                                                                                    hideGroupedColumn: false,
                                                                                                    startCollapsed:false
                                                                                                })
                                                            }
                                                        );
        return 	tblGrid;	
}


function mostrarVentanaAgregarDespacho(idFecha)
{
	var claveUnidad;
    
    
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:15,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Despacho que agregar:'
                                                        },
                                                        {
                                                        	x:235,
                                                            y:15,
                                                            html:'<div id="divComboDespacho" style="width:410px"></div>'
                                                        }
                                                        
                                                       
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar Municipio',
										width: 700,
										height:180,
                                        cls:'msgHistorialSIUGJ',
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
                                                                	var oConf=	{
                                                                                    idCombo:'cmbDespacho',
                                                                                    anchoCombo:400,
                                                                                    posX:0,
                                                                                    posY:0,
                                                                                    renderTo:'divComboDespacho',
                                                                                    raiz:'registros',
                                                                                    campoDesplegar:'nombreUnidad',
                                                                                    campoID:'claveUnidad',
                                                                                    ctCls:'campoComboWrapSIUGJAutocompletar',
                                                                                    listClass:'listComboSIUGJ',
                                                                                    funcionBusqueda:24,
                                                                                    paginaProcesamiento:'../modulosEspeciales_SIUGJ/paginasFunciones/funcionesSIUGJ.php',
                                                                                    confVista:'<tpl for="."><div class="search-item">{nombreUnidad}<br></div></tpl>',
                                                                                    campos:	[
                                                                                                {name:'claveUnidad'},
                                                                                                {name:'nombreUnidad'}
                                                            
                                                                                            ],
                                                                                    funcAntesCarga:function(dSet,combo)
                                                                                                {
                                                                                                    claveUnidad='';
                                                                                                    var aValor=combo.getRawValue();
                                                                                                    dSet.baseParams.criterio=aValor;
                                                                                                    dSet.baseParams.iR=idFecha;
                                                                                                    
                                                                                                                                          
                                                                                                    
                                                                                                },
                                                                                    funcElementoSel:function(combo,registro)
                                                                                                {
                                                                                                    claveUnidad=registro.data.claveUnidad;
                                                                                                    
                                                                                                }  
                                                                                };
                                                            
                                                                var cmbDespacho=crearComboExtAutocompletar(oConf);
																}
															}
												},
										buttons:	[
                                        				{
															text: '<?php echo $etj["lblBtnCancelar"]?>',
                                                            cls:'btnSIUGJCancel',
                                                            width:140,
															handler:function()
																	{
																		ventanaAM.close();
																	}
														},
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            cls:'btnSIUGJ',
                                                            width:140,
															handler: function()
																	{
                                                                    	var pos;
                                                                        var r;
                                                                        var registro=crearRegistro	(		
                                                                                                        [
                                                                                                            {name:'cveElemento'},
                                                                                                            {name: 'nombreElemento'}
                                                                                                        ]
                                                                                                    );
																		
                                                                        var x;
                                                                        pos=obtenerPosFila(gEx('gridCatalogo_4').getStore(),'cveElemento',claveUnidad);
                                                                        if(pos==-1)
                                                                        {
                                                                            r=new registro	(
                                                                                                {
                                                                                                    cveElemento:claveUnidad,
                                                                                                    nombreElemento:gEx('cmbDespacho').getRawValue()
                                                                                                }
                                                                                            )
                                                                        
                                                                            gEx('gridCatalogo_4').getStore().add(r);	
                                                                        }
                                                                        
                                                                        ventanaAM.close();
                                                                        	
																	}
														}
														
													]
									}
								);
	ventanaAM.show();	
}