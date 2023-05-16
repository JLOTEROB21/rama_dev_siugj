<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");

	$consulta="SELECT valor,texto FROM 1004_siNo";
	$arrSiNo=$con->obtenerFilasArreglo($consulta);
	
	$idUsuario=$_SESSION["idUsr"];
		
	$consulta="SELECT Institucion FROM 801_adscripcion WHERE idUsuario=".$idUsuario;
	$unidadGestion=$con->obtenerValor($consulta);
	
	$fechaActual=$_GET["fechaConsulta"];	
	
	$consulta="SELECT idRegistro FROM 7038_tiposAlertaNotificaciones";// WHERE considerarNotificacionDelDia=1
	$listaAlertasMostrar=$con->obtenerListaValores($consulta);
	if($listaAlertasMostrar=="")
		$listaAlertasMostrar=-1;
	
	
	$consulta="SELECT MIN(r.fechaRecordatorio) FROM 7036_alertasNotificaciones a,7006_carpetasAdministrativas c,7037_recordatoriosPreviosNotificacion r 
				WHERE c.carpetaAdministrativa=a.carpetaAdministrativa AND c.unidadGestion='".$unidadGestion."' AND a.situacion in(1,4) 
				AND (idTitularAlerta=".$idUsuario." OR idTitularAlerta IS NULL) and r.idAlertaNotificacion=a.idRegistro
				AND r.fechaRecordatorio<='".$fechaActual." 23:59:59' and a.tipoAlerta in(".$listaAlertasMostrar.")";
		
	$minFechaAlerta=$con->obtenerValor($consulta);

	$consulta="SELECT max(r.fechaRecordatorio) FROM 7036_alertasNotificaciones a,7006_carpetasAdministrativas c,7037_recordatoriosPreviosNotificacion r 
				WHERE c.carpetaAdministrativa=a.carpetaAdministrativa AND c.unidadGestion='".$unidadGestion."' AND a.situacion in(1,4) 
				AND (idTitularAlerta=".$idUsuario." OR idTitularAlerta IS NULL) and r.idAlertaNotificacion=a.idRegistro
				AND r.fechaRecordatorio<='".$fechaActual." 23:59:59' and a.tipoAlerta in(".$listaAlertasMostrar.")";
	$maxFechaAlerta=$fechaActual;//$con->obtenerValor($consulta);
?>

var minFechaAlerta=<?php echo $minFechaAlerta==""?"'".date("Y-m-d")."'":"'".date("Y-m-d",strtotime($minFechaAlerta))."'"?>;
var maxFechaAlerta=<?php echo $maxFechaAlerta==""?"'".date("Y-m-d")."'":"'".date("Y-m-d",strtotime($maxFechaAlerta))."'"?>;

var arrStatusAlerta=[['1','En espera de atenci&oacute;n'],['3','Atendida'],['2','Cancelada'],['4','En espera de atenci&oacute;n']];
var arrSiNo=<?php echo $arrSiNo?>;
Ext.onReady(inicializar);

function inicializar()
{
   
    new Ext.Viewport(	{
                                layout: 'border',
                                xtype:'panel',
                                items: 	[
                                			{
                                            	region:'north',
                                                height:280,
                                                layout:'absolute',
                                                items:	[
                                                			{
                                                            	x:10,
                                                                y:10,
                                                                cls:'frameSiugj',
                                                                xtype:'fieldset',
                                                                height:180,
                                                                width:900,
                                                                layout:'absolute',
                                                                items:	[
                                                                			{
                                                                            	x:10,
                                                                                y:10,
                                                                                xtype:'label',
                                                                                html:'<span class="letraTituloCampoRegistro">Desde</span>'
                                                                            },
                                                                            {	
                                                                            	x:10,
                                                                                y:40,
                                                                                xtype:'label',
                                                                                html:'<div id="dteFechaDesde" style="width:250px"></div>'
                                                                            },
                                                                            {
                                                                            	x:300,
                                                                                y:10,
                                                                                xtype:'label',
                                                                                html:'<span class="letraTituloCampoRegistro">Hasta</span>'
                                                                            },
                                                                            {	
                                                                            	x:300,
                                                                                y:40,
                                                                                xtype:'label',
                                                                                html:'<div id="dteFechaHasta" style="width:250px"></div>'
                                                                            },
                                                                            {
                                                                            	x:590,
                                                                                y:10,
                                                                                xtype:'label',
                                                                                html:'<span class="letraTituloCampoRegistro">Tipo de alerta</span>'
                                                                            },
                                                                            {	
                                                                            	x:590,
                                                                                y:40,
                                                                                xtype:'label',
                                                                                html:'<div id="divComboStatusAlerta"></div>'
                                                                            },
                                                                            {
                                                                            	xtype:'button',
                                                                                x:280,
                                                                                y:100,
                                                                                width:160,
                                                                                height:45,
                                                                                cls:'btnSIUGJCancel',
                                                                                text:'Limpiar filtros',
                                                                                handler: function()
                                                                                        {
                                                                                            gEx('txtFechaInicio').setValue(minFechaAlerta);
                                                                                            gEx('txtFechaFin').setValue(maxFechaAlerta);
                                                                                            gEx('cmbStatusAlertas').setValue('1,4');
                                                                                            gEx('gAlertasNotificaciones').getStore().removeAll();
                                                                                        }
                                                                            },
                                                                            {
                                                                            	xtype:'button',
                                                                                x:460,
                                                                                y:100,
                                                                                width:160,
                                                                                cls:'btnSIUGJ',
                                                                                height:40,
                                                                                text:'Buscar',
                                                                                handler: function()
                                                                                        {
                                                                                            recargarGridAlertas();
                                                                                        }
                                                                            }
                                                                            
                                                                            
                                                                		]
                                                            },
                                                            {
                                                                x:10,
                                                                y:210,
                                                                xtype:'label',
                                                                html:'<span class="letraTituloCampoRegistro">Marcar notificaci&oacute;n como:</span>'
                                                            },
                                                            {
                                                            	xtype:'radio',
                                                                x:10,
                                                                y:240,
                                                                name:'marcarNotifciacion',
                                                                id:'rdo_1',
                                                                listeners:	{
                                                                				check:function(rdo,checado)
                                                                                		{
                                                                                        	if(checado)
                                                                                            {
                                                                                            	var gAlertasNotificaciones=gEx('gAlertasNotificaciones');
                                                                                                var fila=gAlertasNotificaciones.getSelectionModel().getSelected();
                                                                                                if(!fila)
                                                                                                {	
                                                                                                	function resp()
                                                                                                    {
                                                                                                    	rdo.setValue(false);
                                                                                                    }
                                                                                                	msgBox('Debe seleccionar la alerta/notificaci&oacute;n a marcar como "Atendida"',resp);
                                                                                                	return;
                                                                                                }
                                                                                                if(fila.data.situacion!='3')
	                                                                                                mostrarVentanaAtendida(fila);
                                                                                            }
                                                                                            
                                                                                        	
                                                                                        }
                                                                			},
                                                                boxLabel:'<span class="letraTituloCampoRegistro">Atendida</span>'
                                                            },
                                                            {
                                                            	xtype:'radio',
                                                                name:'marcarNotifciacion',
                                                                id:'rdo_2',
                                                                x:150,
                                                                y:240,
                                                                listeners:	{
                                                                				check:function(rdo,checado)
                                                                                		{
                                                                                        	if(checado)
                                                                                            {
                                                                                            	var gAlertasNotificaciones=gEx('gAlertasNotificaciones');
                                                                                                var fila=gAlertasNotificaciones.getSelectionModel().getSelected();
                                                                                                if(!fila)
                                                                                                {	
                                                                                                	function resp()
                                                                                                    {
                                                                                                    	rdo.setValue(false);
                                                                                                    }
                                                                                                	msgBox('Debe seleccionar la alerta/notificaci&oacute;n a marcar como "En espera de atenci&oacute;n"',resp);
                                                                                                	return;
                                                                                                }
                                                                                                console.log(fila.data.situacion);
                                                                                                if(fila.data.situacion!='4')
	                                                                                            {
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
                                                                                                                    gEx('gAlertasNotificaciones').getStore().reload();
                                                                                                                    if(window.parent.verificarAlertas)
                                                                                                                        window.parent.verificarAlertas();
                                                                                                                    
                                                                                                                }
                                                                                                                else
                                                                                                                {
                                                                                                                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                                }
                                                                                                            }
                                                                                                            obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=407&iR='+fila.data.idRegistro,true);
                                                                                                        }
                                                                                                        else
                                                                                                        {
                                                                                                        	gEx('rdo_1').setValue(false);
                                                                                                            gEx('rdo_0').setValue(false);
                                                                                                        }
                                                                                                    }
                                                                                                    msgConfirm('¿Est&aacute; seguro de querer marcar la alerta/notificaci&oacute;n como "En espera de atenci&oacute;n"?',respAux);
                                                                                                
                                                                                                }
                                                                                            }
                                                                                        }
                                                                			},
                                                                boxLabel:'<span class="letraTituloCampoRegistro">En espera de atenci&oacute;n</span>'
                                                            }
                                                		]
                                            },
                                            crearGridNotificacionesDia()
                                        ]
                            }
                        )   
                        
	new Ext.form.DateField	(
                                {
                                    xtype:'datefield',
                                    id:'txtFechaInicio',
                                    renderTo:'dteFechaDesde',
                                    width:240,
                                    ctCls:'campoFechaSIUGJ',
                                    value:minFechaAlerta
                                }
                            )
    
    new Ext.form.DateField	(
                                {
                                    xtype:'datefield',
                                    id:'txtFechaFin',
                                    width:240,
                                    ctCls:'campoFechaSIUGJ',
                                    renderTo:'dteFechaHasta',
                                    value:maxFechaAlerta
                                }
                            )
    
	var arrStatusAlertaCombo=[['0','Todas'],['1,4','Activas'],['2','Canceladas'],['3','Atendidas']];
	var cmbStatusAlertas=crearComboExt('cmbStatusAlertas',arrStatusAlertaCombo,0,0,240,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboStatusAlerta'});
	cmbStatusAlertas.setValue('1,4');
	
    recargarGridAlertas();                          
                        
}

function crearGridNotificacionesDia()
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idRegistro'},
		                                                {name: 'carpetaAdministrativa'},
		                                                {name:'descripcion'},
		                                                {name:'valorReferencia1'},
                                                        {name: 'valorReferencia2'},
                                                        {name: 'fechaRegistro', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name: 'responsableRegistro'},
                                                        {name: 'tipoAlerta'},
                                                        {name: 'fechaAlerta', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name: 'idTitularAlerta'},
                                                        {name: 'objConfiguracion'},
                                                        {name: 'situacion'},
                                                        {name: 'comentariosAlerta'},
                                                        {name: 'responsableCancelacion'},
                                                        {name: 'detallesAdicionales'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../paginasFunciones/funcionesTblFormularios.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'fechaAlerta', direction: 'ASC'},
                                                            groupField: 'fechaAlerta',
                                                            remoteGroup:false,
				                                            remoteSort: true,
                                                            autoLoad:false
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                   		proxy.baseParams.funcion='12';
                                        gEx('rdo_1').setValue(false);
                                        gEx('rdo_2').setValue(false);
                                        
                                        
                                    }
                        )   
       var chkRow=new Ext.grid.CheckboxSelectionModel({width:40,singleSelect:true});
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            /*{
                                                                header:'',
                                                                width:30,
                                                                sortable:true,
                                                                align:'center',
                                                                dataIndex:'idTitularAlerta',
                                                                renderer:function(val)
                                                                		{
                                                                			if(val=='')
                                                                				return '<img src="../images/users.png" title="Alerta General">';
                                                                			return '<img src="../images/user.png" title="Alerta Personal">';
                                                                		}
                                                            },
                                                            {
                                                                header:'',
                                                                width:30,
                                                                sortable:true,
                                                                align:'center',
                                                                dataIndex:'objConfiguracion',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                			
                                                                			
                                                                			if(val!='')
                                                                			{
                                                                				
                                                                				var objConfiguracion=eval('['+bD(val)+']')[0];
                                                                				
																				return '<a href="javascript:'+objConfiguracion.funcion+'(\''+val+'\')"><img src="../images/magnifier.png"></a>'	;
                                                                			}
                                                                			
                                                                			
                                                                		}
                                                            },*/
                                                            new  Ext.grid.RowNumberer({width:40}),
                                                            chkRow,
                                                            {
                                                                header:'',
                                                                width:160,
                                                                sortable:false,
                                                                menuDisabled :true,
                                                                dataIndex:'fechaAlerta',
                                                                renderer:function(val)
                                                                		{
                                                                			return val.format('d/m/Y');
                                                                		}
                                                            },
                                                            {
                                                                header:'Fecha de alerta',
                                                                width:160,
                                                                sortable:false,
                                                                menuDisabled :true,
                                                                dataIndex:'idTitularAlerta',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                			return '<span style="font-size:14px; font-weight:400">'+registro.data.fechaAlerta.format('d/m/Y')+'</span>';
                                                                		}
                                                            },
                                                            {
                                                                header:'C&oacute;digo Unico de Proceso',
                                                                width:250,
                                                                sortable:false,
                                                                menuDisabled :true,
                                                                dataIndex:'carpetaAdministrativa',
                                                                renderer:function(val)
                                                                		{
                                                                			return '<span style="font-size:14px; font-weight:400">'+val+'</span>';
                                                                		}
                                                                
                                                            },
                                                            {
                                                                header:'Fecha de registro',
                                                                width:160,
                                                                menuDisabled :true,
                                                                sortable:false,
                                                                dataIndex:'fechaRegistro',
                                                                renderer:function(val)
                                                                		{
                                                                        	return '<span style="font-size:14px; font-weight:400">'+val.format('d/m/Y H:i:s')+'</span>';
                                                                			
                                                                		}
                                                            },
                                                            {
                                                                header:'Registrado por',
                                                                width:300,
                                                                sortable:false,
                                                                menuDisabled :true,
                                                                dataIndex:'responsableRegistro',
                                                                renderer:function(val)
                                                                		{
                                                                			return '<span style="font-size:14px; font-weight:400">'+val+'</span>';
                                                                		}
                                                            },
                                                             {
                                                                header:'Status alerta',
                                                                width:200,
                                                                menuDisabled :true,
                                                                sortable:false,
                                                                dataIndex:'situacion',
                                                                renderer:function(val)
                                                                		{
																			return '<span style="font-size:14px; font-weight:400; color:#1A3E9A">'+formatearValorRenderer(arrStatusAlerta,val)+'</span>';
                                                                		}
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gAlertasNotificaciones',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                cm: cModelo,
                                                                cls:'gridSiugjSeccion',
                                                                stripeRows :false,
                                                                loadMask:true,
                                                                columnLines : false, 
                                                                sm:chkRow,                                                                		                                                               
                                                                view:new Ext.grid.GroupingView({
                                                                                                    forceFit:false,
                                                                                                    showGroupName: false,
                                                                                                    enableGrouping :true,
                                                                                                    enableNoGroups:false,
                                                                                                    enableGroupingMenu:false,
                                                                                                    hideGroupedColumn: true,
                                                                                                    enableRowBody:true,
                                                                                                    groupTextTpl: ' <span style="font-weight:600 !important">{text}</span> <span style="font-weight:normal !important">({[values.rs.length]} {[values.rs.length > 1 ? "alertas/notificaciones" : "alerta/notificaci&oacute;n"]})</span>',
						                                                                            getRowClass : formatearFilaNotificacion,
                                                                                                    startCollapsed:false
                                                                                                })
                                                            }
                                                        );
        
        

	chkRow.on('rowselect',function(sm,numFila,registro)
    						{
                            	switch(registro.data.situacion)
                                {
                                	case '1':
                                    	gEx('rdo_1').setValue(false);
		                                gEx('rdo_2').setValue(true);
                                    break;
                                    case '2':
                                    	gEx('rdo_1').setValue(false);
                                		gEx('rdo_2').setValue(false);
                                    break;
                                    case '3':
                                    	gEx('rdo_1').setValue(true);
		                                gEx('rdo_2').setValue(false);
                                    break;
                                    case '4':
                                    	gEx('rdo_1').setValue(false);
                                		gEx('rdo_2').setValue(true);
                                    break;
                                }
                            }
    			)
	
    chkRow.on('rowdeselect',function(sm,numFila,registro)
    						{
                            	gEx('rdo_1').setValue(false);
                                gEx('rdo_2').setValue(false);
                            }
    			)
        return 	tblGrid;	
}

function formatearFilaNotificacion(record, rowIndex, p, ds) 
{
	var xf = Ext.util.Format;   
    
	p.body = 	'<table width="100%"><tr><td width="20"></td><td>';
   	p.body +=		'<table width="800">';
	p.body +=			'<tr height="21"><td valign="top" ><span class="x-grid3-cell-inner" style="font-weight:400; font-size:14px">'+record.data.descripcion+'<br></span></td></tr>';
	
	switch(record.data.situacion)
	{
		case '2':
			p.body +=			'<tr height="21"><td valign="top" ><span class="x-grid3-cell-inner" style="font-weight:600; font-size:14px"><br>Motivo de la cancelaci&oacute;n (Cancelado por: '+record.data.responsableCancelacion+'):</span></td></tr>';
			p.body +=			'<tr height="21"><td valign="top" ><span class="x-grid3-cell-inner" style="font-weight:400; font-size:14px">'+record.data.comentariosAlerta+'<br></span></td></tr>';
		break;
		case '3':
			p.body +=			'<tr height="21"><td valign="top" ><span class="x-grid3-cell-inner" style="font-weight:600; font-size:14px"><br>Comentarios de la atenci&oacute;n (Atendido por: '+record.data.responsableCancelacion+'):</span></td></tr>';
			p.body +=			'<tr height="21"><td valign="top" ><span class="x-grid3-cell-inner" style="font-weight:400; font-size:14px">'+(record.data.comentariosAlerta.trim()==''?'(Sin comentarios)':record.data.comentariosAlerta.trim())+'<br></span></td></tr>';
		break;
	}
	
	if(record.data.detallesAdicionales!='')
	{
		p.body +=				'<tr height="21"><td valign="top" ><span class="x-grid3-cell-inner" style="font-weight:400; font-size:14px">>'+record.data.detallesAdicionales+'<br></span></td></tr>';
	}
	
   	p.body +=		'</table>';
    p.body +=	'</p>';
	p.body +=	'</td></tr></table><br>';
    return 'x-grid3-row-expanded';
}

function recargarGridAlertas()
{
	gEx('gAlertasNotificaciones').getStore().load	(
														{
															url:'../paginasFunciones/funcionesTblFormularios.php',
															params: {
																		funcion:'12',
                                                                        esRecordatorioDia:1,
																		fI:gEx('txtFechaInicio').getValue().format('Y-m-d'),
																		fF:gEx('txtFechaFin').getValue().format('Y-m-d'),
                                                                        status:gEx('cmbStatusAlertas').getValue()
																	}
														}
													)
}

function mostrarDocumento(cadConf)
{
	var oConf=eval('['+bD(cadConf)+']')[0];
	switch(oConf.tipoVisor)
	{
		case '1':
			mostrarVisorDocumentoProceso(oConf.extension,oConf.idDocumento);
		break;
		case '2':
			var o={};
			o.tipoDocumento=oConf.tipoDocumento;
			o.idRegistroFormato=oConf.idDocumento;
			o.rol='0_0';
			mostrarVentanaGeneracionDocumentos(o);
		break;
	}
}

function mostrarPrescripcion(cadConf)
{
	var oConf=eval('['+bD(cadConf)+']')[0];
	switch(oConf.tipoVisor)
	{
		case '1':
			mostrarVentanPrescripcion(oConf.idPrescripcion)
		break;
		case '2':
			var obj={};    
            obj.ancho='100%';
            obj.alto='100%';
            obj.url='../modeloPerfiles/vistaDTDv3.php';
            obj.params=[['idFormulario',oConf.idFormulario],['idRegistro',oConf.idReferencia],['idReferencia',-1],
            		['dComp',bE('auto')],['actor',bE(0)]];
            abrirVentanaFancy(obj);
			
		break;
	}
}

function mostrarVentanPrescripcion(iP)
{
	var cmbSentenciadoCiudadMexico=crearComboExt('cmbSentenciadoCiudadMexico',arrSiNo,420,290,115);
	cmbSentenciadoCiudadMexico.disable();
	var cmbPena=crearComboExt('cmbPena',[],160,35,600);
	
	
	var form = new Ext.form.FormPanel(
										{
											baseCls: 'x-plain',
											layout:'border',
											defaultType: 'label',
											items: 	[
                                            			
                                            			{
															xtype:'tabpanel',
															baseCls: 'x-plain',
															region:'center',
															id:'tabPrescripcion',
															activeTab:1,
															items: 	[

																		{
																			xtype:'panel',
																			layout:'absolute',
																			baseCls: 'x-plain',
																			title:'Datos Generales',
																			defaultType: 'label',
																			items: 	[
																						  {
																							  x:10,
																							  y:10,
																							  html:'<span class="TSJDF_Etiqueta">Imputado/sentenciado:</span>&nbsp;&nbsp;<span id="lblSentenciado" class="TSJDF_Etiqueta" style="color:#900 !important"></span>'
																						  },

																						  {
																							  x:10,
																							  y:40,
																							  html:'<span class="TSJDF_Etiqueta">Pena:</span>&nbsp;&nbsp;<span id="lblPena" class="TSJDF_Etiqueta" style="color:#900 !important"></span>'
																						  },

																						  {
																							  x:10,
																							  y:70,
																							  hidden:true,
																							  id:'lblFechaInicioPena',
																							  html:'<span class="TSJDF_Etiqueta">Fecha de inicio de pena:</span>'
																						  },
																						  {
																							  x:160,
																							  y:65,
																							  hidden:true,
																							  xtype:'datefield',
																							  id:'dteFechaInicio',
																							  disabled:true

																						  },
																						  {
																							  x:300,
																							  y:70,
																							  hidden:true,
																							  id:'lblFechaTerminoPena',
																							  html:'<span class="TSJDF_Etiqueta">Fecha de t&eacute;rmino de pena:</span>'
																						  },
																						  {
																							  x:475,
																							  y:65,
																							  hidden:true,
																							  xtype:'datefield',
																							  id:'dteFechaTermino',
																							  disabled:true

																						  },
																						  {
																							  xtype:'fieldset',
																							  width:230,

																							  id:'fsPeriodoPena',
																							  height:80,
																							  title:'Abono prisi&oacute;n preventiva',
																							  x:10,
																							  y:70,

																							  layout:'absolute',
																							  items:	[
																										  {
																											  x:10,
																											  y:0,
																											  xtype:'numberfield',
																											  allowDecimals:false,
																											  alowNegative:false,
																											  width:40,
																											  value:0,
																											  disabled:true,
																											  id:'txtAnios'
																										  },
																										  {
																											  xtype:'label',
																											  html:'<span class="TSJDF_Etiqueta" style="font-size:11px !important;">A&ntilde;os</span>',
																											  x:15,
																											  y:25
																										  },
																										  {
																											  x:60,
																											  y:0,
																											  xtype:'numberfield',
																											  width:40,
																											  allowDecimals:false,
																											  alowNegative:false,
																											  value:0,
																											  disabled:true,
																											  id:'txtMeses'
																										  },
																										  {
																											  xtype:'label',
																											  html:'<span class="TSJDF_Etiqueta" style="font-size:11px !important;">Meses</span>',
																											  x:65,
																											  y:25
																										  },
																										  {
																											  x:110,
																											  y:0,
																											  xtype:'numberfield',
																											  width:40,
																											  value:0,
																											  disabled:true,
																											  allowDecimals:false,
																											  alowNegative:false,
																											  id:'txtDias'
																										  },
																										  {
																											  xtype:'label',
																											  html:'<span class="TSJDF_Etiqueta" style="font-size:11px !important;">D&iacute;as</span>',
																											  x:115,
																											  y:25
																										  }
																									  ]
																						  } ,
																						  {
																							  xtype:'fieldset',
																							  width:230,																							
																							  id:'fsAbonoCumplimientoPena',
																							  height:80,
																							  title:'Abono cumplimiento sentencia',
																							  x:10,
																							  y:165,
																							  layout:'absolute',
																							  items:	[
																										  {
																											  x:10,
																											  y:0,
																											  xtype:'numberfield',
																											  allowDecimals:false,
																											  alowNegative:false,
																											  width:40,
																											  value:0,
																											  disabled:true,
																											  id:'txtAniosCumplimiento'
																										  },
																										  {
																											  xtype:'label',
																											  html:'<span class="TSJDF_Etiqueta" style="font-size:11px !important;">A&ntilde;os</span>',
																											  x:15,
																											  y:25
																										  },
																										  {
																											  x:60,
																											  y:0,
																											  xtype:'numberfield',
																											  width:40,
																											  allowDecimals:false,
																											  alowNegative:false,
																											  value:0,
																											  disabled:true,
																											  id:'txtMesesCumplimiento'
																										  },
																										  {
																											  xtype:'label',
																											  html:'<span class="TSJDF_Etiqueta" style="font-size:11px !important;">Meses</span>',
																											  x:65,
																											  y:25
																										  },
																										  {
																											  x:110,
																											  y:0,
																											  xtype:'numberfield',
																											  width:40,
																											  value:0,
																											  disabled:true,
																											  allowDecimals:false,
																											  alowNegative:false,
																											  id:'txtDiasCumplimiento'
																										  },
																										  {
																											  xtype:'label',
																											  html:'<span class="TSJDF_Etiqueta" style="font-size:11px !important;">D&iacute;as</span>',
																											  x:115,
																											  y:25
																										  }
																									  ]
																						  },
																						  {
																							  xtype:'fieldset',
																							  width:490,

																							  id:'fsAbonoPrisionPunitiva',
																							  height:170,
																							  title:'Abono prisi&oacute;n punitiva',
																							  x:260,
																							  y:70,
																							  layout:'absolute',
																							  items:	[
																										  {
																											  x:10,
																											  y:0,
																											  xtype:'numberfield',
																											  allowDecimals:false,
																											  alowNegative:false,
																											  width:40,
																											  value:0,
																											  disabled:true,
																											  id:'txtAniosPunitiva'
																										  },
																										  {
																											  xtype:'label',
																											  html:'<span class="TSJDF_Etiqueta" style="font-size:11px !important;">A&ntilde;os</span>',
																											  x:15,
																											  y:25
																										  },
																										  {
																											  x:60,
																											  y:0,
																											  xtype:'numberfield',
																											  width:40,
																											  disabled:true,
																											  allowDecimals:false,
																											  alowNegative:false,
																											  value:0,

																											  id:'txtMesesPunitiva'
																										  },
																										  {
																											  xtype:'label',
																											  html:'<span class="TSJDF_Etiqueta" style="font-size:11px !important;">Meses</span>',
																											  x:65,
																											  y:25
																										  },
																										  {
																											  x:110,
																											  y:0,
																											  xtype:'numberfield',
																											  width:40,
																											  value:0,
																											  disabled:true,
																											  allowDecimals:false,
																											  alowNegative:false,
																											  id:'txtDiasPunitiva'
																										  },
																										  {
																											  xtype:'label',
																											  html:'<span class="TSJDF_Etiqueta" style="font-size:11px !important;">D&iacute;as</span>',
																											  x:115,
																											  y:25
																										  },
																										  {
																											  x:10,
																											  y:45,
																											  xtype:'label',
																											  html:'<span class="TSJDF_Etiqueta" >Comentarios prisi&oacute;n punitiva:</span>'
																										  },
																										  {
																											  x:10,
																											  y:65,
																											  width:450,
																											  height:65,
																											  disabled:true,
																											  id:'txtComentarioPrision',
																											  xtype:'textarea'
																										  }
																									  ]
																						  } ,
																						  {
																							  x:10,
																							  y:260,                                              
																							  xtype:'label',
																							  id:'lblFechaSustraccion',
																							  html:'<span class="TSJDF_Etiqueta">Fecha de sustracción del imputado/sentenciado:</span>'
																						  },
																						  {
																							  x:320,
																							  y:255,
																							  disabled:true,
																							  xtype:'datefield',
																							  id:'txtFechaSustraccion'
																						  },
																						  {
																							  x:10,
																							  y:290,
																							  xtype:'label',
																							  html:'<span class="TSJDF_Etiqueta">¿El imputado/sentenciado se encuentra en la Ciudad de M&eacute;xico?</span>'
																						  },
																						  cmbSentenciadoCiudadMexico,
																						  {
																							  x:10,
																							  y:320,
																							  xtype:'label',
																							  html:'<span class="TSJDF_Etiqueta">Fecha de prescripci&oacute;n:</span>'
																						  },
																						  {
																							  x:180,
																							  y:315,
																							  disabled:true,
																							  xtype:'datefield',
																							  id:'txtFechaPrescripcion'
																						  }
																					  ]
																		},

																		{
																			xtype:'panel',
																			baseCls: 'x-plain',
																			title:'Comentarios adicionales',
																			layout:'absolute',
																			items: 	[
																						{
																							x:10,
																							y:10,
																							xtype:'textarea',
																							width:765,
																							height:300,
																							readOnly:true,
																							id:'txtComentariosAdicionales'
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
										title: 'Datos prescripci&oacute;n [Carpeta Judicial: <span style="color: #900 !important;" id="lblCarpeta"></span>]',
										width: 820,
										height:460,
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
																		ventanaAM.close();
																	}
														}
													]
									}
								);
	
	ventanaAM.show();
	gEx('tabPrescripcion').setActiveTab(0);
	function funcAjax()
	{
		var resp=peticion_http.responseText;
		arrResp=resp.split('|');
		if(arrResp[0]=='1')
		{
			var o=eval('['+arrResp[1]+']')[0];
			gE('lblCarpeta').innerHTML=o.carpetaAdministrativa;
			gE('lblSentenciado').innerHTML=o.sentenciado;
			gE('lblPena').innerHTML=o.pena;
			var arrAbonoPrisionPreventiva=o.abonoPrisionPreventiva.split('_');
			gEx('txtAnios').setValue(arrAbonoPrisionPreventiva[0]);
			gEx('txtMeses').setValue(arrAbonoPrisionPreventiva[1]);
			gEx('txtDias').setValue(arrAbonoPrisionPreventiva[2]);
			var arrAbonoPrisionPunitiva=o.abonoPrisionPunitiva.split('_');
			gEx('txtAniosPunitiva').setValue(arrAbonoPrisionPunitiva[0]);
			gEx('txtMesesPunitiva').setValue(arrAbonoPrisionPunitiva[1]);
			gEx('txtDiasPunitiva').setValue(arrAbonoPrisionPunitiva[2]);
			var arrAbonoCumplimientoSentencia=o.abonoCumplimientoSentencia.split('_');
			gEx('txtAniosCumplimiento').setValue(arrAbonoCumplimientoSentencia[0]);
			gEx('txtMesesCumplimiento').setValue(arrAbonoCumplimientoSentencia[1]);
			gEx('txtDiasCumplimiento').setValue(arrAbonoCumplimientoSentencia[2]);
			
			gEx('txtFechaSustraccion').setValue(o.fechaSustraccion);
			gEx('cmbSentenciadoCiudadMexico').setValue(o.sentenciadoEnCDMX);
			gEx('txtFechaPrescripcion').setValue(o.fechaPrescripcion);
			gEx('txtComentarioPrision').setValue(escaparBR(o.comentariosPrisionPunitiva));
			gEx('txtComentariosAdicionales').setValue(escaparBR(o.comentariosAdicionales));
		}
		else
		{
			msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
		}
	}
	obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=158&iP='+iP,true);
	
	
}

function mostrarVentanaAtendida(fila)
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
                                            				html:'Comentarios adicionales:'
                                            				
                                            			},
                                            			{
                                            				xtype:'textarea',
                                            				x:10,
                                            				y:50,
                                            				width:550,
                                            				height:100,
                                                            cls:'controlSIUGJ',
                                            				id:'txtComentariosAdicionales'
                                            			}
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Marcar alerta/notificaci&oacute;n como atendida',
										width: 590,
										height:260,
										layout: 'fit',
										plain:true,
										modal:true,
                                        cls:'msgHistorialSIUGJ',
										bodyStyle:'padding:5px;',
										buttonAlign:'center',
										items: form,
										listeners : {
                                        				close:	function()
                                                        		{
                                                                	gEx('rdo_1').setValue(false);
                                                                    gEx('rdo_2').setValue(false);
                                                                },
                                                        show : {
                                                                    buffer : 10,
                                                                    fn : function() 
                                                                    {
                                                                        gEx('txtComentariosAdicionales').focus(false,500);
                                                                    }
                                                                }
												},
										buttons:	[
                                        				{
															text: '<?php echo $etj["lblBtnCancelar"]?>',
                                                            cls:'btnSIUGJCancel',
                                                            width:130,
                                                            height:44,
															handler:function()
																	{
																		ventanaAM.close();
																	}
														},
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            cls:'btnSIUGJ',
                                                            width:130,
                                                            height:40,
															handler: function()
																	{
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
																						gEx('gAlertasNotificaciones').getStore().reload();
                                                                                        if(window.parent.verificarAlertas)
                                                                                        	window.parent.verificarAlertas();
																						ventanaAM.close();
																					}
																					else
																					{
																						msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
																					}
																				}
																				obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=159&iA='+fila.data.idRegistro+'&s=3&c='+cv(gEx('txtComentariosAdicionales').getValue()),true);
																			}
																		}
																		msgConfirm('Est&aacute; seguro de querer marcar la alerta/notificaci&oacute;n como atendida',resp);
																	}
														}
														
													]
									}
								);
	ventanaAM.show();	
}
