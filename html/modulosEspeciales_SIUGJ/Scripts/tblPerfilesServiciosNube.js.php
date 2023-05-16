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
	
	$consulta="SELECT idConexion,nombreConexion	FROM 20001_conexionesServiciosNube c WHERE conexionSistema=1 and situacion=1 ORDER BY nombreConexion";
	$arrServicios=$con->obtenerFilasArreglo($consulta);

?>

var arrServicios=<?php echo $arrServicios?>;
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
                                                title:'Configuraci&oacute;n de perfiles de servicios hacia nube',
                                               
                                                items:	[
                                                            crearGridPerfiles()
                                                        ]
                                            }
                                         ]
                            }
                        )   
}




function crearGridPerfiles()
{
	
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idRegistro'},
		                                                {name: 'cuentaServicio'},
                                                        {name: 'situacionActual'},
                                                        {name: 'distrito'},
                                                        {name: 'circuito'},
                                                        {name: 'municipio'},
                                                        {name: 'despacho'},
                                                        {name: 'general'},
                                                        {name: 'comentariosAdicionales'}
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
                                                            sortInfo: {field: 'perfilHorario', direction: 'ASC'},
                                                            groupField: 'perfilHorario',
                                                            remoteGroup:false,
				                                            remoteSort: true,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='41';
                                        
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer({width:70}),
                                                            
                                                            {
                                                                header:'Cuenta de servicio',
                                                                width:420,
                                                                sortable:true,
                                                                dataIndex:'cuentaServicio',
                                                                renderer:function(val)
                                                                		{
                                                                        	return formatearValorRenderer(arrServicios,val)
                                                                        }
                                                            },
                                                            {
                                                                header:'Comentarios adicionales',
                                                                width:420,
                                                                sortable:true,
                                                                dataIndex:'comentariosAdicionales',
                                                                renderer:function(val)
                                                                		{
                                                                        	return mostrarValorDescripcion(val);
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
                                                                id:'gridPerfiles',
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
                                                                                icon:'../principalPortal/imagesSIUGJ/add.png',
                                                                                cls:'x-btn-text-icon',
                                                                                height:50,
                                                                                text:'Registrar perfil de servicio',
                                                                                handler:function()
                                                                                        {
                                                                                        	mostrarVentanaAgregarPerfil(-1)
                                                                                        }
                                                                            
                                                                            },
                                                                            {
                                                                                icon:'../principalPortal/imagesSIUGJ/pencil.png',
                                                                                cls:'x-btn-text-icon',
                                                                                height:50,
                                                                                text:'Modificar perfil de servicio',
                                                                                handler:function()
                                                                                        {
                                                                                        	var fila=tblGrid.getSelectionModel().getSelected();
                                                                                        	mostrarVentanaAgregarPerfil(fila.data.idRegistro,fila)
                                                                                        }
                                                                            
                                                                            },
                                                                            {
                                                                                icon:'../principalPortal/imagesSIUGJ/delete.png',
                                                                                cls:'x-btn-text-icon',
                                                                                height:50,
                                                                                id:'btnRemoveDocumento',
                                                                                text:'Remover perfil de servicio',
                                                                                handler:function()
                                                                                        {
                                                                                    		var fila=tblGrid.getSelectionModel().getSelected()
                                                                                            if(!fila)
                                                                                            {
                                                                                            	msgBox('Debe el perfil de servicio que desea remover');
                                                                                            	return;
                                                                                            }
                                                                                            
                                                                                            
                                                                                            var fila=tblGrid.getSelectionModel().getSelected()
                                                                                            if(!fila)
                                                                                            {
                                                                                            	msgBox('Debe seleccionar el perfil de servicio que desea remover');
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
                                                                                                    obtenerDatosWeb('../modulosEspeciales_SIUGJ/paginasFunciones/funcionesSIUGJ.php',funcAjax, 'POST','funcion=42&iR='+fila.data.idRegistro,true);
                                                                                                    
                                                                                                }
                                                                                            }
                                                                                            msgConfirm('Est&aacute; seguro de querer remover el perfil de servicio seleccionado?',respAux);
                                                                                            
                                                                                            
                                                                                            
                                                                                            
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


function mostrarVentanaAgregarPerfil(idPerfil,fila)
{
	
    
    
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
                                            
											defaultType: 'label',
											items: 	[
                                            
                                            			{	
                                                        	xtype:'tabpanel',
                                                            activeTab:0,
                                                            height:420,
                                                            cls:'tabPanelSIUGJ',
                                                            region:'center',
                                                            items:	[
                                                            			{
                                                                        	xtype:'panel',
                                                                            title:'Datos Generales',
                                                                            layout:'absolute',
                                                                            defaultType: 'label',
                                                                            items:	[
                                                                            			{
                                                                                            x:10,
                                                                                            y:20,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            html:'Cuenta de servicio:'
                                                                                        },
                                                                                        {
                                                                                            x:200,
                                                                                            y:15,                                                                                            
                                                                                            html:'<div id="divCmbCuentaServicio"></div>'
                                                                                        },
                                                                            			{
                                                                                            x:10,
                                                                                            y:70,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            html:'&Aacute;mbito General:'
                                                                                        },
                                                                                        {
                                                                                            x:200,
                                                                                            y:65,                                                                                            
                                                                                            html:'<div id="divCmbAmbitoGeneral"></div>'
                                                                                        },
                                                                                        
                                                                                        {
                                                                                            x:10,
                                                                                            y:120,
                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                            html:'Comentarios adicionales:'
                                                                                        },
                                                                                        {
                                                                                        	xtype:'textarea',
                                                                                            width:650,
                                                                                            x:10,
                                                                                            y:150,
                                                                                            cls:'controlSIUGJ',
                                                                                            value:fila?escaparBR(fila.data.comentariosAdicionales):'',
                                                                                            id:'txtComentariosAdicionales'
                                                                                        }
                                                                            		]
                                                                        },
                                                            
                                                            			
                                                                        {
                                                                            xtype:'tabpanel',
                                                                            x:10,
                                                                            cls:'tabPanelSIUGJ',
                                                                            id:'tpanelAmbito',
                                                                            disabled:true,
                                                                            title:'&Aacute;mbito de Aplicaci&oacute;n',
                                                                            y:220,
                                                                            width:630,
                                                                            height:250,
                                                                            activeTab:0,
                                                                            items:	[
                                                                                        {
                                                                                            xtype:'panel',
                                                                                            title:'Distritos',
                                                                                            layout:'border',
                                                                                            items:	[
                                                                                                        crearGridCatalogos(idPerfil,1)
                                                                                                    ]
                                                                                        },
                                                                                        {
                                                                                            xtype:'panel',
                                                                                            title:'Circuitos',
                                                                                            layout:'border',
                                                                                            items:	[
                                                                                                        crearGridCatalogos(idPerfil,2)
                                                                                                    ]
                                                                                        },
                                                                                        {
                                                                                            xtype:'panel',
                                                                                            title:'Municipios',
                                                                                            layout:'border',
                                                                                            items:	[
                                                                                                        crearGridCatalogos(idPerfil,3)
                                                                                                    ]
                                                                                        },
                                                                                        {
                                                                                            xtype:'panel',
                                                                                            title:'Despachos',
                                                                                            layout:'border',
                                                                                            items:	[
                                                                                                        crearGridCatalogos(idPerfil,4)
                                                                                                    ]
                                                                                        }
                                                                                    ]
                                                                        }
                                                            		]
                                                        }
                                            
                                            			
                                                        
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: idPerfil==-1?'Registrar perfil de servicio hacia nube':'Modificar perfil de servicio hacia nube',
										width: 700,
										height:550,
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
                                                                
                                                                	var cmbCuentaServicio=crearComboExt('cmbCuentaServicio',arrServicios,0,0,450,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divCmbCuentaServicio'});    
                                                                
                                                                	var cmbAmbitoGeneral=crearComboExt('cmbAmbitoGeneral',arrSiNo,0,0,150,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divCmbAmbitoGeneral'});    
                                                                    cmbAmbitoGeneral.on('select',function(cmb,registro)
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
                                                                    
                                                                    cmbAmbitoGeneral.setValue('1');
                                                                    if(fila)
                                                                    {
                                                                        
                                                                        
                                                                        
                                                                        cmbCuentaServicio.setValue(fila.data.cuentaServicio);
                                                                        
                                                                        cmbAmbitoGeneral.setValue(fila.data.general);
                                                                        dispararEventoSelectCombo('cmbAmbitoGeneral');
                                                                        
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
																		var cmbCuentaServicio=gEx('cmbCuentaServicio');
                                                                        
                                                                        
                                                                        if(cmbCuentaServicio.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	cmbCuentaServicio.focus();
                                                                            }
                                                                        	msgBox('Debe seleccionar la cuenta de servicio a configurar',resp);	
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
                                                                        
                                                                        var cadObj='{"idRegistro":"'+idPerfil+'","cuentaServicio":"'+cv(gEx('cmbCuentaServicio').getValue())+'","ambitoGeneral":"'+
                                                                        			gEx('cmbAmbitoGeneral').getValue()+
                                                                                    '","arrDistritos":['+arrDistritos+'],"arrCircuitos":['+arrCircuitos+'],"arrMunicipios":['+arrMunicipios+
                                                                                    '],"arrDespachos":['+arrDespachos+'],"comentariosAdicionales":"'+cv(gEx('txtComentariosAdicionales').getValue())+'"}';
                                                                        
                                                                        
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	gEx('gridPerfiles').getStore().reload();
                                                                                function resp()
                                                                                {
                                                                                	ventanaAM.close();
                                                                                }
                                                                                msgBox('La informaci&oacute;n ha sido guardada correctamente',resp);
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../modulosEspeciales_SIUGJ/paginasFunciones/funcionesSIUGJ.php',funcAjax, 'POST','funcion=40&cadObj='+cadObj,true);

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
                                    	proxy.baseParams.funcion='33';
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
                                                                cls:'gridSiugjPrincipal',
                                                                stripeRows :false,
                                                                loadMask:true,
                                                                columnLines : false,
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
                                                                                
                                                                            },'-',
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
										width: 610,
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
                                    	proxy.baseParams.funcion='27';
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
                                                                cls:'gridSiugjPrincipal',
                                                                stripeRows :false,
                                                                loadMask:true,
                                                                columnLines : false,
                                                                height:280,
                                                                sm:chkRow,
                                                                width:570,
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
										width: 610,
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
                                    	proxy.baseParams.funcion='28';
                                        proxy.baseParams.iR=idFecha;
                                        
                                    }
                        )   
       var chkRow=new Ext.grid.CheckboxSelectionModel( {width:40});
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
                                                                region:'center',
                                                                frame:false,
                                                                cm: cModelo,
                                                                x:10,
                                                                y:40,
                                                                stripeRows :false,
                                                                loadMask:true,
                                                                columnLines : false,
                                                                height:280,
                                                                sm:chkRow,
                                                                width:570,
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
										width: 610,
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
                                    	proxy.baseParams.funcion='29';
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
                                                                columnLines : false,
                                                                height:280,
                                                                sm:chkRow,
                                                                cls:'gridSiugjPrincipal',
                                                                width:570,
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
	var claveUnidad='';
    var oConf=	{
    					idCombo:'cmbDespacho',
                        anchoCombo:700,
                        renderTo:'divComboDespacho',
                        listClass:"listComboSIUGJControl", 
                        cls:"comboSIUGJControl",
                        ctCls:"comboWrapSIUGJControl",
                        raiz:'registros',
                        campoDesplegar:'nombreUnidad',
                        campoID:'claveUnidad',
                        funcionBusqueda:30,
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

	
    
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:20,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Despacho que desea agregar:'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:60,
                                                            html:'<div id="divComboDespacho"></div>'
                                                        }
                                                        
                                                       
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar Municipio',
										width: 750,
										height:250,
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
                                                                	var cmbDespacho=crearComboExtAutocompletar(oConf);
                                                                    cmbDespacho.focus();
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
                                                                    
                                                                    	if(claveUnidad=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	gEx('cmbDespacho').focus();
                                                                            }
                                                                            msgBox('Debe seleccionar el despacho que desea agregar',resp);
                                                                        	return;
                                                                        }
                                                                    
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