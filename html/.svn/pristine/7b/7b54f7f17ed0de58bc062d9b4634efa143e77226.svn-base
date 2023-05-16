<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$ocultarGeneraNomina="true";
	$consulta="SELECT idPerfil FROM 662_accionesActorEtapaNomina WHERE idActorEtapa IN 
			(SELECT idActorEtapaNomina FROM 662_actoresEtapaNomina WHERE actor IN (".$_SESSION["idRol"].") AND etapa=0) AND accion=5";
	$res=$con->obtenerFilas($consulta);
	$listPerfiles="";
	while($fila=mysql_fetch_row($res))
	{
		if($listPerfiles=="")
			$listPerfiles=$fila[0];
		else
			$listPerfiles.=",".$fila[0];
	}
	if($listPerfiles!="")
		$ocultarGeneraNomina="false";
	else
		$listPerfiles=-1;
	
	$consulta="SELECT idPerfilesNomina,nombrePerfil FROM 662_perfilesNomina where idPerfilesNomina in (".$listPerfiles.") ORDER BY nombrePerfil";	
	$arrPerfiles=$con->obtenerFilasArreglo($consulta);
	$x=0;
	$arrQuincenas="";
	$nQuincena="";
	for($x=1;$x<=24;$x++)
	{
		$nQuincena=$x;
		if($x<10)
			$nQuincena="0".$x;
		if($arrQuincenas=="")
			$arrQuincenas="['".$nQuincena."','".$nQuincena.".- ".$arrMesLetra[ceil($x/2)-1]."']";
		else
			$arrQuincenas.=",['".$nQuincena."','".$nQuincena.".- ".$arrMesLetra[ceil($x/2)-1]."']";
	}
	$arrQuincenas="[".$arrQuincenas."]";
	$consulta="SELECT codigoUnidad,unidad FROM 817_organigrama WHERE institucion=0 AND codigoInstitucion='".$_SESSION["codigoInstitucion"]."' and STATUS=1 ORDER BY unidad";
	$arrDeptos=$con->obtenerFilasArreglo($consulta);
	$consulta="SELECT cvePuesto,puesto FROM 819_puestosOrganigrama ORDER BY puesto";
	$arrPuestos=$con->obtenerFilasArreglo($consulta);
	$consulta="SELECT id__669_tablaDinamica,txtTipoContratacion FROM _669_tablaDinamica ORDER BY txtTipoContratacion";
	$arrTipoContratacion=$con->obtenerFilasArreglo($consulta);
	$consulta="SELECT idConsulta,nombreConsulta FROM 991_consultasSql WHERE idTipoConcepto=6";
	$arrCriterios=$con->obtenerFilasArreglo($consulta);
	$codigoInstitucion=obtenerInstitucionPadre($_SESSION["codigoInstitucion"]);
	
	$consulta="SELECT idEmpresa,
				IF(e.tipoEmpresa=1,CONCAT('[',cveEmpresa,'] ',e.razonSocial,' ',e.apPaterno,' ',e.apMaterno),concat('[',cveEmpresa,'] ',e.razonSocial)) AS nombreEmpresa
			 ,concat(rfc1,'-',rfc2,'-',rfc3) as rfc,nominasIndividuales FROM 6927_empresas e WHERE referencia='".$referenciaFiltros."'";
	$arrInstituciones=$con->obtenerFilasArreglo($consulta);
	
	
	$consulta="SELECT ciclo,ciclo FROM 550_cicloFiscal order by ciclo";
	$arrCiclo=$con->obtenerFilasArreglo($consulta);
	$consulta="select MAX(ultimaSincronizacion) FROM 9105_sincronizacionSistema ";
	$ultimaActualizacion=$con->obtenerValor($consulta);
	$arrEntidadesAgrupadora="";
	$consulta="SELECT idEntidadNomina,nombreEntidadNomina,permiteSeleccionUnidades,'[]' as funciones FROM 679_entidadesAgrupadorasNomina where situacion=1";
	$res=$con->obtenerFilas($consulta);
	while($f=mysql_fetch_row($res))
	{
		$consulta="SELECT idConsulta,nombreConsulta FROM 991_consultasSql WHERE idConsulta IN (SELECT idFuncionBusqueda FROM 680_funcionesBusqueda WHERE idEntidad=".$f[0].") ORDER BY nombreConsulta";
		$arrCriteriosBusqueda=$con->obtenerFilasArreglo($consulta);
		$obj="['".$f[0]."','".cv($f[1])."','".$f[2]."',".$arrCriteriosBusqueda."]";
		if($arrEntidadesAgrupadora=="")
			$arrEntidadesAgrupadora=$obj;
		else
			$arrEntidadesAgrupadora.=",".$obj;
	}
	
	
	
		
?>
var arrTiposEntidades=[];
var arrInstituciones=<?php echo $arrInstituciones?>;
var arrDeptos=<?php echo $arrDeptos?>;
var arrPuestos=<?php echo $arrPuestos?>;
var arrPerfiles=<?php echo $arrPerfiles?>;
var arrQuincenas=<?php echo $arrQuincenas?>;
var arrTipoContratacion=<?php echo $arrTipoContratacion?>;
var arrCriterios=<?php echo $arrCriterios?>;
var arrCriterioCombina=<?php echo $arrCriterios?>;
var ultimaActualizacion='<?php echo $ultimaActualizacion?>';
var ocultarGeneraNomina=<?php echo $ocultarGeneraNomina?>;
var arrEntidadesAgrupadora=[<?php echo $arrEntidadesAgrupadora?>];
Ext.onReady(inicializar);

function inicializar()
{
	var arrCiclo=<?php echo $arrCiclo?>;
	var cmbCiclo=crearComboExt('cmbCiclo',arrCiclo,0,0,120);
    cmbCiclo.setValue(gE('ciclo').value);
    cmbCiclo.on('select',function(cmb,registro)
    					{
                        	gEx('gridNominas').getStore().reload();
                        }
    			)
	arrCriterioCombina.splice(0,0,['0','No combinar']);
	
    var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name: 'idNomina',type:'int'},
                                                        {name: 'nomina'},
                                                        {name: 'fInicioInc'},
                                                        {name: 'fFinInc'},
                                                        {name: 'fEstPago'},
                                                        {name: 'fPago'},
                                                        {name: 'etapa'},
                                                        {name: 'descripcion'},
                                                        {name: 'descEtapa'},
                                                        {name: 'descripcionNomina'},
                                                        {name: 'folio'},
                                                        {name: 'quincena', type:'int'},
                                                        {name: 'lblQuincena'},
                                                        {name: 'permisos'},
                                                        {name: 'fechaUltimaEjecucion'},
                                                        {name: 'plantel'},
                                                        {name: 'fInicioFalta', type:'date', dateFormat:'Y-m-d'},
                                                        {name: 'fFinFalta', type:'date', dateFormat:'Y-m-d'}
                                                        
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../paginasFunciones/funcionesEspecialesNomina.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'quincena', direction: 'DESC'},
                                                            groupField: 'lblQuincena',
                                                            remoteGroup:false,
				                                            remoteSort: true,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='26';
                                        proxy.baseParams.esNominaPorEmpresa=1;
                                        proxy.baseParams.ciclo=cmbCiclo.getValue();
                                    }
                        )   
    
    
    var expander = new Ext.ux.grid.RowExpander(	
    												{
    
                                                		column:3,
                                                		tpl : new Ext.Template	(
							                            	                        '<br /><span class="copyrigthSinPadding">{descripcion}</span>'
							                                	                )			
                                            		}
                                               );
	var chkRow=new Ext.grid.CheckboxSelectionModel({singleSelect:true});
    chkRow.on('rowselect',function(sm,nFila,registro)
    						{
                            	gEx('btnCalcular').disable();
                                gEx('btnVer').disable();
                                gEx('btnRemover').disable();
                            	var permisos=registro.get('permisos');
                                if(permisos.indexOf('E')!=-1)
                                {
                                	gEx('btnRemover').enable();
                                }
                                if(permisos.indexOf('G')!=-1)
                                {
                                	gEx('btnCalcular').enable();
                                }
                            	if(registro.get('fechaUltimaEjecucion')!='')
                                {
                                	gEx('btnVer').enable();
                                }
                                
                                /*switch(registro.get('etapa'))
                                {
                                	case '0':
                                        gEx('btnCalcular').enable();
                                        gEx('btnRemover').enable();
                                    break;
                                    default:
                                    	gEx('btnVer').enable();
                                        gEx('btnVer').enable();
                                        gEx('btnRemover').enable();
                                    break;
                                }*/
                                
                            }
    		)
 	chkRow.on('rowdeselect',function(sm,nFila,registro)            
                        {
                        	gEx('btnCalcular').disable();
                            gEx('btnVer').disable();
                            gEx('btnRemover').disable();
	            
                        }
        	)
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														chkRow,
                                                        expander,
                                                        {
															header:'Folio',
															width:100,
															sortable:true,
															dataIndex:'folio'
														},
                                                        {
															header:'Periodo',
															width:60,
															sortable:true,
															dataIndex:'lblQuincena'
														},
                                                        {
															header:'Quincena',
															width:60,
                                                            hidden:true,
															sortable:true,
															dataIndex:'quincena',
                                                            renderer:function(val)
                                                            			{
                                                                        	return val;
                                                                        }
														},
                                                        {
															header:'Descripci&oacute;n',
															width:280,
                                                            hidden:true,
															sortable:true,
															dataIndex:function(val)
                                                            		{
                                                                    	return mostrarValorDescripcion(val);
                                                                    }
														},
														{
															header:'Tipo de n&oacute;mina',
															width:140,
															sortable:true,
															dataIndex:'nomina'
														},
                                                        {
															header:'Empresa',
															width:220,
															sortable:true,
															dataIndex:'plantel',
                                                            renderer:function(val)
                                                            		{
                                                                    	return formatearValorRenderer(arrInstituciones,val);
                                                                    }
														},
														{
															header:'Fecha inicio <br />Incidencias',
															width:85,
															sortable:true,
                                                            align:'center',
															dataIndex:'fInicioInc'
														},
                                                        {
															header:'Fecha fin <br />Incidencias',
															width:85,
															sortable:true,
                                                            align:'center',
															dataIndex:'fFinInc'
														}
                                                        ,
                                                        {
															header:'Fecha <br /> de pago',
															width:85,
															sortable:true,
                                                            align:'center',
															dataIndex:'fEstPago'
														},
                                                        {
															header:'Fecha inicio <br />de faltas',
															width:85,
															sortable:true,
                                                            align:'center',
															dataIndex:'fInicioFalta',
                                                            renderer:function(val)
                                                            		{
                                                                    	if(val!=null)
	                                                                    	return val.format("d/m/Y");
                                                                        else
                                                                        	return "N/A";
                                                                    }
														},
                                                        {
															header:'Fecha fin <br />de faltas',
															width:85,
															sortable:true,
                                                            align:'center',
															dataIndex:'fFinFalta',
                                                            renderer:function(val)
                                                            		{
                                                                    	if(val!=null)
	                                                                    	return val.format("d/m/Y");
                                                                        else
                                                                        	return "N/A";
                                                                    }
														},
                                                        {
															header:'Situaci&oacute;n',
															width:195,
															sortable:true,
															dataIndex:'descEtapa',
                                                            renderer:function(val,meta,registro)
                                                            		{
                                                                    	if(parseFloat(registro.get('etapa'))!=1000)
	                                                                    	return val;
                                                                        else
                                                                        	return 'Pagada';
                                                                           
                                                                    }
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gridNominas',
                                                            store:alDatos,
                                                            frame:false,
                                                            renderTo:'tblNominas',
                                                            width:960,
                                                            border:true,
                                                            height:500,
                                                            cm: cModelo,
                                                            sm:chkRow,
                                                            loadMask:true,
                                                            view:new Ext.grid.GroupingView({
                                                                                                    forceFit: false,
                                                                                                    enableGrouping :true,
                                                                                                    hideGroupedColumn : true
                                                                                                }),
                                                            stripeRows :true,
                                                            columnLines :true,
                                                            plugins:[expander],
                                                            tbar:	[
                                                            			{
                                                                        	xtype:'label',
                                                                            html:'<span class="letraRojaSubrayada8"><b>Ciclo fiscal:</b></span>&nbsp;&nbsp;'
                                                                        },
                                                                        cmbCiclo,
                                                                        '-',
                                                            			{
                                                                        	icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Generar nueva plantilla de nomina',
                                                                            hidden:ocultarGeneraNomina,
                                                                            handler:function()
                                                                            		{
                                                                                    	mostrarVentanaNuevaNomina();
                                                                                    }
                                                                            
                                                                        },'-',
                                                                        {
                                                                        	id:'btnCalcular',
                                                                        	icon:'../images/process_accept.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Calcular n&oacute;mina',
                                                                            disabled:true,
                                                                            handler:function()
                                                                            		{
                                                                                    	var fila=tblGrid.getSelectionModel().getSelected();
                                                                                        if(fila==null)
                                                                                        {
                                                                                        	msgBox('Debe indicar el registro de n&oacute;mina que desea ejecutar');
                                                                                        	return;
                                                                                        }
                                                                                        var arrParam=[['idNomina',fila.get('idNomina')],['calcular','1']];
                                                                                        enviarFormularioDatos('../nomina/generarNominaPerfil.php',arrParam);
                                                                                    }
                                                                            
                                                                        },'-',
                                                                        {
                                                                        	id:'btnVer',
                                                                        	icon:'../images/magnifier.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Ver n&oacute;mina calculada',
                                                                            disabled:true,
                                                                            handler:function()
                                                                            		{
                                                                                    	var fila=tblGrid.getSelectionModel().getSelected();
                                                                                        if(fila==null)
                                                                                        {
                                                                                        	msgBox('Debe indicar el registro de n&oacute;mina cuyo resultado desea observar');
                                                                                        	return;
                                                                                        }
                                                                                        var fila=tblGrid.getSelectionModel().getSelected();
                                                                                        if(fila==null)
                                                                                        {
                                                                                        	msgBox('Debe indicar el registro de n&oacute;mina que desea ejecutar');
                                                                                        	return;
                                                                                        }
                                                                                        var arrParam=[['idNomina',fila.get('idNomina')],['calcular','0']];
                                                                                        enviarFormularioDatos('../nomina/generarNominaPerfil.php',arrParam);	
                                                                                    }
                                                                            
                                                                        },'-',
                                                                        
                                                                        {
                                                                        	id:'btnRemover',
                                                                        	icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Remover plantilla de nomina',
                                                                            disabled:true,
                                                                            handler:function()
                                                                            		{
                                                                                    	var fila=tblGrid.getSelectionModel().getSelected();
                                                                                        if(fila==null)
                                                                                        {
                                                                                        	msgBox('Debe indicar el registro de n&oacute;mina que desea eliminar');
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
                                                                                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                    }
                                                                                                }
                                                                                                obtenerDatosWeb('../paginasFunciones/funcionesEspecialesNomina.php',funcAjax, 'POST','funcion=9&idNomina='+fila.get('idNomina'),true);
                                                                                            }
                                                                                        }
                                                                                        msgConfirm('Est&aacute; seguro de querer remover el registro de n&oacute;mina seleccionado?',resp);
                                                                                    }
                                                                            
                                                                        }
                                                                        
                                                            		]
                                                        }
                                                    );
	
    //var gridBiometricos=crearGridBiometricos();                                                    

	

}

function mostrarVentanaNuevaNomina()
{
	var considerarFalta=0;
	var cmbTipoNomina=crearComboExt('cmbTipoNomina',arrPerfiles,140,5);
    cmbTipoNomina.on('select',function(combo,registro)
    						{
                            	var cmbQuincena=gEx('cmbQuincena');
                                var dteFaltaDesde=gEx('dteFaltaDesde');
                                dteFaltaDesde.setValue('');
                                dteFaltaDesde.disable();
                                
                                
                                var dteFechaEstPago=gEx('dteFechaEstPago');
                                dteFechaEstPago.setValue('');
                                dteFechaEstPago.disable();
                                
                                var dteIniInc=gEx('dteIniInc');
                                dteIniInc.setValue('');
                                dteIniInc.disable();
                                
                                var dteFinInc=gEx('dteFinInc');
                                dteFinInc.setValue('');
                                dteFinInc.disable();
                                
                                cmbQuincena.getStore().loadData([]);
                                cmbQuincena.reset();
                                gEx('lblConsiderarFalta').hide();
                                gEx('lblAlFalta').hide();
                                gEx('dteFaltaDesde').hide();
                                gEx('dteFaltaHasta').hide();
                                
                                
                                function funcAjax()
                                {
                                    var resp=peticion_http.responseText;
                                    arrResp=resp.split('|');
                                    if(arrResp[0]=='1')
                                    {
                                        cmbQuincena.getStore().loadData(eval(arrResp[1]));
                                        considerarFalta=arrResp[2];
                                        if(considerarFalta=='1')
                                        {
                                        	gEx('lblConsiderarFalta').show();
                                            gEx('lblAlFalta').show();
                                            gEx('dteFaltaDesde').show();
                                            gEx('dteFaltaHasta').show();
                                        }
                                        
                                    }
                                    else
                                    {
                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                    }
                                }
                                obtenerDatosWeb('../paginasFunciones/funcionesEspecialesNomina.php',funcAjax, 'POST','funcion=29&ciclo='+gEx('cmbCiclo').getValue()+'&idPerfil='+registro.get('id'),true);
                                
                                
                                if(cmbQuincena.getValue()!='')
                                {
                                	obtenerFechaInicioFalta();
                                }
                            }
					)                            
    
    
    var objConf={};
    objConf.arrCampos=	[
    						{name:'id'},
                            {name:'nombre'},
                            {name:'valorComp'},
                            {name:'fechaFin'}
                              
    					]
    var cmbQuincena=crearComboExt('cmbQuincena',[],480,5,200,objConf);
    cmbQuincena.on('select',function(combo,registro)
    						{
                            	var dteFinInc=gEx('dteFinInc');
                            	var dteFechaInicio=gEx('dteIniInc');
                                var dteFechaEstPago=gEx('dteFechaEstPago');
                                var dteFaltaHasta=gEx('dteFaltaHasta');
                                dteFechaInicio.enable();
                                var dteFaltaDesde=gEx('dteFaltaDesde');
                                dteFaltaDesde.setValue('');
                                dteFaltaDesde.disable();
                                
                                if(cmbTipoNomina.getValue()!='')
                                {
                                	obtenerFechaInicioFalta();
                                }
                            	
                                /*var quincena=parseInt(registro.get('id'),10);
                                var mes=(Math.ceil(quincena/2))+'';
                                if(mes.length==1)
                                	mes='0'+mes;
                                var dia='01';
                                var ultimoDia='14';
                                if((quincena%2)==0)
                                {
                                	dia='15';
                                }
                                var ciclo=gE('ciclo').value;
                            	
                                if((quincena%2)==0)
                                {
                                	ultimoDia=dteFechaInicio.getValue().getDaysInMonth();
                                }*/
                                //dteFechaInicio.setMinValue(dteFechaInicio.getValue());
                                
                                var fecha=registro.get('valorComp');
                                dteFechaInicio.setValue(fecha);
                                var fechaFin=registro.get('fechaFin');
                                dteFechaInicio.setMaxValue(fechaFin);
                                dteFinInc.setMinValue(fecha);
                                //dteFinInc.setMaxValue(ciclo+'-'+mes+'-'+ultimoDia);
                            	
                                dteFinInc.setValue(fecha);
                                dteFinInc.enable();
                                dteFaltaHasta.enable();
                                /*dteFechaEstPago.setMinValue(dteFechaInicio.getValue());
                                dteFechaEstPago.setMaxValue(ciclo+'-'+mes+'-'+ultimoDia);*/
                                dteFechaEstPago.enable();
                                dteFechaEstPago.setValue(fecha);
                            }
                   )  
	var gridAplicaNomina=crearGridAplicaNomina();
    var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:'Tipo de n&oacute;mina:'
                                                        },
                                                        cmbTipoNomina,
                                                        {
                                                        	x:370,
                                                            y:10,
                                                            html:'Periodo a ejecutar:'
                                                        },
                                                        cmbQuincena,
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            html:'Considerar incidencias del:'
                                                        },
                                                        {
                                                        	xtype:'datefield',
                                                            id:'dteIniInc',
                                                            disabled:true,
                                                            x:140,
                                                            y:35
                                                        },
                                                        {
                                                        	x:250,
                                                            y:40,
                                                            html:'Al:'
                                                        },
                                                        {
                                                        	xtype:'datefield',
                                                            id:'dteFinInc',
                                                            disabled:true,
                                                            listeners:	{
                                                            				change:function(campo,nuevoValor)
                                                                            		{
                                                                                    	gEx('dteFaltaHasta').setValue('');
                                                                                    	gEx('dteFaltaHasta').setMaxValue(nuevoValor);
                                                                                    }
                                                            			},
                                                            x:280,
                                                            y:35
                                                        },
                                                        {
                                                        	x:420,
                                                            y:40,
                                                            html:'Fecha estimada de pago:'
                                                        },
                                                        {
                                                        	xtype:'datefield',
                                                            id:'dteFechaEstPago',
                                                            disabled:true,
                                                            x:550,
                                                            y:35
                                                        },
                                                        {
                                                        	x:10,
                                                            y:70,
                                                            id:'lblConsiderarFalta',
                                                            hidden:true,
                                                            html:'Considerar faltas del:'
                                                        },
                                                        {
                                                        	xtype:'datefield',
                                                            id:'dteFaltaDesde',
                                                            disabled:true,
                                                            hidden:true,
                                                            
                                                            x:140,
                                                            y:65
                                                        },
                                                        {
                                                        	x:250,
                                                            y:70,
                                                            hidden:true,
                                                            id:'lblAlFalta',
                                                            html:'Al:'
                                                        },
                                                        {
                                                        	xtype:'datefield',
                                                            id:'dteFaltaHasta',
                                                            disabled:true,
                                                            hidden:true,
                                                            x:280,
                                                            y:65
                                                        },
                                                        {
                                                        	xtype:'label',
                                                            x:10,
                                                            y:110,
                                                            html:'Descripci&oacute;n:'
                                                        },
                                                        {
                                                        	id:'txtDescripcion',
                                                        	xtype:'textarea',
                                                            width:470,
                                                            height:80,
                                                            x:140,
                                                            y:105,
                                                        },
                                                        {
                                                        	x:10,
                                                            y:200,
                                                            html:'Aplicar n&oacute;mina a:'
                                                        },
                                                        {
                                                        	x:140,
                                                            y:195,
                                                            
                                                            id:'chkNominaIndividual',
                                                            xtype:'checkbox',
                                                            hidden:true,
                                                            boxLabel:'Generar n&oacute;minas indiviuales por entidad',
                                                            checked:true
                                                        },
                                                        gridAplicaNomina
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Generar nueva plantilla de n&oacute;mina',
										width: 720,
										height:540,
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
                                                                    	if(cmbTipoNomina.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	cmbTipoNomina.focus();
                                                                            }
                                                                            msgBox('Debe seleccionar el tipo de n&oacute;mina que desea utilizar',resp);
                                                                            return;
                                                                        }
                                                                        if(cmbQuincena.getValue()=='')
                                                                        {
                                                                        	function resp2()
                                                                            {
                                                                            	cmbQuincena.focus();
                                                                            }
                                                                            msgBox('Debe seleccionar la quincena en la cual aplicar&aacute; la n&oacute;mina que desea utilizar',resp2);
                                                                            return;
                                                                        }
                                                                        var dteIniInc=gEx('dteIniInc');
                                                                        var dteFinInc=gEx('dteFinInc');
                                                                        if(dteIniInc.getValue()>dteFinInc.getValue())
                                                                        {
                                                                        	function resp3()
                                                                            {
                                                                            	dteIniInc.focus();
                                                                            }
                                                                            msgBox('La fecha de inicio de inciencias no puede ser mayor que la fecha de t&eacute;rmino',resp3);
                                                                            return;
                                                                        
                                                                        }
                                                                        var dteFechaEstPago=gEx('dteFechaEstPago');
                                                                    	
                                                                        var tipoAplicacion='0';
                                                                        var entidadesAplica='';
                                                                        
                                                                        var dteFaltaDesde=gEx('dteFaltaDesde');
                                                                        var dteFaltaHasta=gEx('dteFaltaHasta');
                                                                        var fDesde='';
                                                                        var fHasta='';
                                                                        if(considerarFalta=='1')
                                                                        {
                                                                            if(dteFaltaDesde.getValue()=='')
                                                                            {
                                                                                function resp40()
                                                                                {
                                                                                    dteFaltaDesde.focus();
                                                                                }
                                                                                msgBox('Debe indicar las fecha desde la cual debe considerarse las faltas',resp40);
                                                                                return;
                                                                            
                                                                            }
                                                                            
                                                                            
                                                                            if(dteFaltaHasta.getValue()=='')
                                                                            {
                                                                                function resp30()
                                                                                {
                                                                                    dteFaltaHasta.focus();
                                                                                }
                                                                                msgBox('Debe indicar las fecha hasta la cual debe considerarse las faltas',resp30);
                                                                                return;
                                                                            
                                                                            }
                                                                            
                                                                            if(dteFaltaDesde.getValue()>dteFaltaHasta.getValue())
                                                                            {
                                                                                function resp41()
                                                                                {
                                                                                    dteFaltaDesde.focus();
                                                                                }
                                                                                msgBox('La fecha de inicio para considerar las faltas no puede ser mayor que la fecha de t&eacute;rmino',resp41);
                                                                                return;
                                                                            
                                                                            }
                                                                            fDesde=dteFaltaDesde.getValue().format("Y-m-d");
                                                                            fHasta=dteFaltaHasta.getValue().format("Y-m-d");
                                                                        }
                                                                       
                                                                        var x;
                                                                        var fila;
                                                                        var obj;
                                                                        
                                                                        var aFilasSel=gridAplicaNomina.getSelectionModel().getSelections();
                                                                        if(aFilasSel.length==0)
                                                                        {
                                                                        	msgBox('Almenos debe seleccionar una empresa para la generaci&oacuten de la n&oacute;mina');
                                                                        	return;
                                                                        }
                                                                        for(x=0;x<aFilasSel.length;x++)
                                                                        {
                                                                        	fila=aFilasSel[x];
                                                                            obj="['10','"+fila.get('idEmpresa')+"','0']";
                                                                            if(entidadesAplica=='')
                                                                            	entidadesAplica=obj;
                                                                            else
                                                                            	entidadesAplica+=','+obj;
                                                                        }
                                                                        var nominasIndividuales=0;
                                                                        if(gEx('chkNominaIndividual').getValue())
                                                                        	nominasIndividuales=1;
                                                                        
                                                                        entidadesAplica='['+entidadesAplica+']';
                                                                        var cadObj='{"esquemaNomina":"2","nominasIndividuales":"'+nominasIndividuales+'","fechaFaltaDesde":"'+fDesde+'","fechaFalta":"'+fHasta+'","ciclo":"'+gE('ciclo').value+
                                                                        			'","quincenaAplicacion":"'+cmbQuincena.getValue()+'","tipoNomina":"'+cmbTipoNomina.getValue()+'","quincenaAplica":"'+cmbQuincena.getValue()+
                                                                        			'","fechaIniInc":"'+dteIniInc.getValue().format('Y-m-d')+'","fechaFinInc":"'+dteFinInc.getValue().format('Y-m-d')+
                                                                                    '","fechaPago":"'+dteFechaEstPago.getValue().format('Y-m-d')+'","tipoAplicacion":"'+tipoAplicacion+
                                                                                    '","entidadesAplica":"'+bE(entidadesAplica)+'","descripcion":"'+gEx('txtDescripcion').getValue()+'"}';
                                                                      
                                                                       function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	gEx('gridNominas').getStore().reload();
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesEspecialesNomina.php',funcAjax, 'POST','funcion=8&cadObj='+cadObj,true);
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

function obtenerFechaInicioFalta()
{
   	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            var dteFaltaDesde=gEx('dteFaltaDesde');
            dteFaltaDesde.setValue(arrResp[1]);
            dteFaltaDesde.enable();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesEspecialesNomina.php',funcAjax, 'POST','funcion=28&idPerfil='+gEx('cmbTipoNomina').getValue()+'&quincena='+gEx('cmbQuincena').getValue()+'&ciclo='+gEx('cmbCiclo').getValue(),true);
}

function crearGridBiometricos()
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idTerminal'},
		                                                {name: 'nombreTerminal'},
		                                                {name:'ip'},
		                                                {name:'unidad'},
                                                        {name:'ultimaActualizacion', type:'date', dateFormat:'Y-m-d H:i:s'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../paginasFunciones/funcionesPlanteles.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'unidad', direction: 'ASC'},
                                                            groupField: 'unidad',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='63';
                                       
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer(),
                                                            
                                                            {
                                                                header:'No. Terminal',
                                                                width:110,
                                                                sortable:true,
                                                                dataIndex:'idTerminal'
                                                            },
                                                            {
                                                                header:'Descripci&oacute;n',
                                                                width:200,
                                                                sortable:true,
                                                                dataIndex:'nombreTerminal'
                                                            },
                                                            {
                                                                header:'Direcci&oacute;n IP',
                                                                width:110,
                                                                sortable:true,
                                                                dataIndex:'ip'
                                                            },
                                                            {
                                                                header:'Plantel',
                                                                width:220,
                                                                sortable:true,
                                                                dataIndex:'unidad'
                                                            },
                                                            {
                                                                header:'&Uacute;ltima actualizaci&oacute;n',
                                                                width:120,
                                                                sortable:true,
                                                                dataIndex:'ultimaActualizacion',
                                                                renderer:function(val)
                                                                		{
                                                                        	if((val!='')&&(val!=null))
                                                                            {
                                                                            	return val.format('d/m/Y H:i');
                                                                            }

                                                                        }
                                                            }
                                                            
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gridBiometricos',
                                                                title:'<span class="letraRojaSubrayada8">Ultima sincronizaci&oacute;n con terminales biom&eacute;tricas: </span><span style="color:#000"><b><?php if($ultimaActualizacion!=""){echo date("d/m/Y [ H:i ]",strtotime($ultimaActualizacion)); }else {echo "&nbsp;[No sincronizado]";}?></b></span>',
                                                                store:alDatos,
                                                                region:'south',
                                                                 collapsible:true,
                                                                frame:true,
                                                                height:280,
                                                                cm: cModelo,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                columnLines : true,
                                                                view:new Ext.grid.GroupingView({
                                                                                                    forceFit: false,
                                                                                                    enableGrouping :true,
                                                                                                    getRowClass:formatearFila
                                                                                                })
                                                            }
                                                        );
        return 	tblGrid;	
}

function crearGridAplicaNomina()
{
	var dsDatos=arrInstituciones;
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'idEmpresa'},
                                                                    {name: 'empresa'},
                                                                    {name: 'rfc'},
                                                                    {name: 'nominasIndividuales'}
    
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel({singleSelect:false});
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														chkRow,
														{
															header:'RFC',
															width:150,
															sortable:true,
															dataIndex:'rfc',
                                                            renderer:mostrarValorDescripcion 
														},
														{
															header:'Empresa',
															width:350,
															sortable:true,
															dataIndex:'empresa',
                                                            renderer:mostrarValorDescripcion 
														},
														
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gridEntidad',
                                                            stripeRows :true,
                                                            columnLines : true,
                                                            store:alDatos,
                                                            frame:false,
                                                            border:true,
                                                            x:10,
                                                            y:220,
                                                            cm: cModelo,
                                                            height:230,
                                                            width:650,
                                                            sm:chkRow
                                                        }
                                                    );
	return 	tblGrid;	
}

function mostrarVentanaSelTipoEntidad()
{
	//['6','Criterio de b\xFAsqueda',0,0,arrCriterioCombina],
	var arrTipoEntidad=[['2','Departamento/\xC1rea',0,0,arrCriterioCombina],['3','Empleado',0,0,arrCriterioCombina],['4','Puesto',0,0,arrCriterioCombina],['5','Tipo contrataci\xF3n',0,0,arrCriterioCombina],['7','Instituciones hijas',0,0,arrCriterioCombina]];
    var x;
    for(x=0;x<arrEntidadesAgrupadora.length;x++)
    {
    	arrTipoEntidad.push(['-'+arrEntidadesAgrupadora[x][0],arrEntidadesAgrupadora[x][1],'1',arrEntidadesAgrupadora[x][2],arrEntidadesAgrupadora[x][3]]);
    }
    arrTiposEntidades=arrTipoEntidad;
    var cmbCriterio2=crearComboExt('cmbCriterio2',[],220,35,350);
    cmbCriterio2.hide();
    var objConf={};
    objConf.confVista='<tpl for="."><div class="search-item"><tpl if="valorComp==1"><img src="../images/sitemap_color.png" width="12" height="12"> </tpl><tpl if="valorComp!=1"><img src="../images/s.gif" width="12" height="12"> </tpl>{nombre}</div></tpl>';
	var cmbTipoEntidad=crearComboExt('cmbTipoEntidad',arrTipoEntidad,220,5,350,objConf);
    cmbTipoEntidad.on('select',function(cmb,r)
    							{
                                
                                	if(parseFloat(r.get('id'))<0)
                                    {
                                    	gEx('lblCombina').show();
                                        gEx('cmbCriterio2').show();
                                        var pos=existeValorMatriz(arrTipoEntidad,r.get('id'));
                                        cmbCriterio2.getStore().loadData(arrTipoEntidad[pos][4]);
                                        gEx('vAgregaEntidad').setHeight(160);
                                    }
                                    else
                                    {
                                    	gEx('lblCombina').hide();
                                        gEx('cmbCriterio2').hide();
                                        gEx('vAgregaEntidad').setHeight(130);
                                    }
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
                                                            html:'Indique el tipo de entidad a agregar:'
                                                        },
                                                        cmbTipoEntidad,
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            id:'lblCombina',
                                                            hidden:true,
                                                            html:'Combinar con criterio de b&uacute;squeda:'
                                                        },
                                                       	cmbCriterio2

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
                                    	id:'vAgregaEntidad',
										title: 'Agregar entidad',
										width: 750,
										height:130,
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
																		if(cmbTipoEntidad.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	cmbTipoEntidad.focus();
                                                                            }
                                                                            msgBox('Debe indicar el tipo de entidad que desea agregar',resp);
                                                                        	return;
                                                                        }
                                                                        var gridEntidad=gEx('gridEntidad'); 
                                                                        var tEntidad=parseFloat(cmbTipoEntidad.getValue());
                                                                        if(tEntidad>0)
                                                                        {
                                                                        	var x;
                                                                            var fEntidad;
                                                                            for(x=0;x<gridEntidad.getStore().getCount();x++)
                                                                            {
                                                                            	fEntidad=gridEntidad.getStore().getAt(x);
                                                                                if(parseInt(fEntidad.get('tEntidad'))<0)
                                                                                {
                                                                                	msgBox('Los tipos de entidad catalogados como "<b>Entidades de agrupaci&oacute;n</b>" (Marcados con: <img src="../images/sitemap_color.png">) NO pueden combinarse con tipos de entidad diferentes al mismo');
                                                                                	return;
                                                                                }
                                                                            }
                                                                        
                                                                            switch(tEntidad)
                                                                            {
                                                                                case 2:
                                                                                case 4:
                                                                                case 5:
                                                                                case 6:
                                                                                case 7:
                                                                                    mostrarVentanaElementoSel(cmbTipoEntidad.getValue());
                                                                                    ventanaAM.close();
                                                                                break;
                                                                                case 3:
                                                                                    mostrarVentanaBuscarEmpleado();
                                                                                    ventanaAM.close();
                                                                                break;
                                                                            }
                                                                        }
                                                                        else
                                                                        {
                                                                        	
                                                                        	var x;
                                                                            var fEntidad;
                                                                            for(x=0;x<gridEntidad.getStore().getCount();x++)
                                                                            {
                                                                            	fEntidad=gridEntidad.getStore().getAt(x);
                                                                                if(fEntidad.get('tEntidad')!=(tEntidad+''))
                                                                                {
                                                                                	msgBox('Los tipos de entidad catalogados como "<b>Entidades de agrupaci&oacute;n</b>" (Marcados con: <img src="../images/sitemap_color.png">) NO pueden combinarse con tipos de entidad diferentes al mismo');
                                                                                	return;
                                                                                }
                                                                            }
                                                                        
                                                                        	var pos=existeValorMatriz(arrTipoEntidad,cmbTipoEntidad.getValue());
                                                                            if(arrTipoEntidad[pos][3]=='1')
                                                                            {
	                                                                        	 mostrarVentanaElementoSel(cmbTipoEntidad.getValue());
                                                                            }
                                                                            else
                                                                            {
                                                                            
                                                                            	if(gEx('cmbCriterio2').getValue()=='')
                                                                                {
                                                                                    function resp()
                                                                                    {
                                                                                        gEx('cmbCriterio2').focus();
                                                                                    }
                                                                                    msgBox('Debe indicar el criterio con el que ser&aacute; combinado la entidad',resp);
                                                                                    return;
                                                                                }
                                                                                
                                                                            	var registroGridEntidad=crearRegistro([
                                                                                                                            {name: 'tEntidad'},
                                                                                                                            {name: 'entidad'},
                                                                                                                            {name: 'codigoEntidad'},
                                                                                                                            {name: 'idRegistro'},
                                                                                                                            {name: 'lblCriterio'},
                                                                                                                            {name: 'idCriterio'}
                                                                                                                        ])
                                                                                 
                                                                                var tipoElemento= tEntidad;                                    
                                                                            	if(obtenerPosFila(gridEntidad.getStore(),'idRegistro',tipoElemento+'_0')==-1)
                                                                                {
                                                                                    r=new registroGridEntidad(
                                                                                                                {
                                                                                                                    tEntidad:tipoElemento,
                                                                                                                    entidad:'Todas las unidades',
                                                                                                                    codigoEntidad:'0',
                                                                                                                    idRegistro:tipoElemento+'_0',
                                                                                                                    idCriterio:gEx('cmbCriterio2').getValue(),
                                                                                                                    lblCriterio:gEx('cmbCriterio2').getRawValue()
                                                                                                                }
                                                                                                            );
                                                                                    gridEntidad.getStore().add(r);
                                                                                }
                                                                                                                            
                                                                            }
                                                                            ventanaAM.close();
                                                                        }
                                                                        
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

function mostrarVentanaElementoSel(tipoElemento)
{
	var titulo;
    var msg;
    var lblGrid='';
    var gridElemento=crearGridElemento(lblGrid);
    tipoElemento=parseFloat(tipoElemento);
    var pos=existeValorMatriz(arrTiposEntidades,tipoElemento);
    
    var cmbCriterio=crearComboExt('cmbCriterio',arrTiposEntidades[pos][4],150,335,350);
    cmbCriterio.setValue('0');
    if(tipoElemento>0)
    {
        switch(tipoElemento)
        {
            case 2:
                titulo='Agregar departamento/&aacute;rea';
                msg='Seleccione el departamento/&aacute;rea que desee agregar:';
                lblGrid='Departamento/&aacute;rea';
                gridElemento.getStore().loadData(arrDeptos);
                
            break;
            case 4:
                titulo="Agregar puesto";
                msg='Seleccione el puesto que desee agregar:';
                lblGrid='Puesto';
                gridElemento.getStore().loadData(arrPuestos);
                
            break;
            case 5:
                titulo="Agregar tipo contrataci&oacute;n";
                msg='Seleccione el tipo de contrataci&oacute;n que desee agregar:';
                lblGrid='Tipo de contrataci&oacute;n';
                gridElemento.getStore().loadData(arrTipoContratacion);
            break;
            case 6:
                titulo="Agregar criterio de b&uacute;squeda";
                msg='Seleccione el criterio de b&uacute;squeda que desee agregar:';
                lblGrid='Criterio de b&uacute;squeda';
                gridElemento.getStore().loadData(arrCriterios);
            break;
            case 7:
                titulo="Agregar Instituci&oacute;n hija";
                msg='Seleccione la instituci&oacute;n que desea agregar:';
                lblGrid='Instituci&oacute;n';
                gridElemento.getStore().loadData(arrInstituciones);
            break;
        }
   	} 
    else
    {
    	titulo="Agregar "+gEx('cmbTipoEntidad').getRawValue();
        lblGrid=gEx('cmbTipoEntidad').getRawValue();
        msg='Seleccione la entidad que desea agregar:';
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
                                                            html:msg
                                                        },
                                                        gridElemento,
                                                        {
                                                        	x:10,
                                                            y:340,
                                                            html:'Combinar con criterio:'
                                                        },
                                                        cmbCriterio

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: titulo,
										width: 680,
										height:470,
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
                                                                    	
                                                                        var registroGridEntidad=crearRegistro([
                                                                                                                {name: 'tEntidad'},
                                                                                                                {name: 'entidad'},
                                                                                                                {name: 'codigoEntidad'},
                                                                                                                {name: 'idRegistro'},
                                                                                                                {name: 'lblCriterio'},
                                                                                                                {name: 'idCriterio'}
                                                                                                            ])
																		var filas=gridElemento.getSelectionModel().getSelections();
                                                                        if(filas.length==0)
                                                                        {
                                                                        	msgBox('Debe seleccionar un elemento a considerar en la n&oacute;mina');
                                                                        	return;
                                                                        }
                                                                        
                                                                        if(tipoElemento<0)
                                                                        {
                                                                        	if(cmbCriterio.getValue()=='')
                                                                            {
                                                                            	function resp()
                                                                                {
                                                                                	cmbCriterio.focus();
                                                                                }
                                                                                msgBox('Debe indicar el criterio con el que ser&aacute; combinado la entidad',resp);
                                                                                return;
                                                                            }
                                                                        }
                                                                        
                                                                        var x;
                                                                        var r;
                                                                        var gridEntidad=gEx('gridEntidad');
                                                                        for(x=0;x<filas.length;x++)
                                                                        {
                                                                        	if(obtenerPosFila(gridEntidad.getStore(),'idRegistro',tipoElemento+'_'+filas[x].get('codigo'))==-1)
                                                                            {
                                                                                r=new registroGridEntidad(
                                                                                                            {
                                                                                                                tEntidad:tipoElemento,
                                                                                                                entidad:filas[x].get('elemento'),
                                                                                                                codigoEntidad:filas[x].get('codigo'),
                                                                                                                idRegistro:tipoElemento+'_'+filas[x].get('codigo'),
                                                                                                                idCriterio:cmbCriterio.getValue(),
                                                                                                                lblCriterio:cmbCriterio.getRawValue()
                                                                                                            }
	                                                                                                    );
                                                                                gridEntidad.getStore().add(r);
                                                                        	}
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
	if(tipoElemento>0)   
    {                             
		ventanaAM.show();	
         gE('lblTituloElemento').innerHTML=lblGrid;
    }
    else
    {
    	function funcAjax()
        {
            var resp=peticion_http.responseText;
            arrResp=resp.split('|');
            if(arrResp[0]=='1')
            {
                gridElemento.getStore().loadData(eval(arrResp[1]));
                ventanaAM.show();	
                 gE('lblTituloElemento').innerHTML=lblGrid;
            }
            else
            {
                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
            }
        }
        obtenerDatosWeb('../paginasFunciones/funcionesEspecialesNomina.php',funcAjax, 'POST','funcion=31&tipoElemento='+(-1*tipoElemento),true);

    }
}

function crearGridElemento(titulo)
{
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                {
                                                    fields:	[
                                                                {name: 'codigo'},
                                                                {name: 'elemento'}
                                                            ]
                                                }
                                            );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel();
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer({width:25}),
														chkRow,
														{
															header:'<span id="lblTituloElemento"></span>',
															width:550,
															sortable:true,
															dataIndex:'elemento',
                                                            renderer:mostrarValorDescripcion
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            
                                                            store:alDatos,
                                                            frame:true,
                                                            x:10,
                                                            y:35,
                                                            stripeRows :true,
                                                            cm: cModelo,
                                                            height:290,
                                                            width:640,
                                                            sm:chkRow
                                                        }
                                                    );
	return 	tblGrid;
}

var rdoPaterno;
var rdoMaterno;
var rdoNom;

function mostrarVentanaBuscarEmpleado()
{
	gE('cBusquedaP').value='1';
	
	
	var parametros2=	{
							funcion:'6',
							criterio:''
						};
                        
	var lector=new Ext.data.JsonReader 	(
										 	{
												root:'personas',
												totalProperty:'num',
												id:'idUsuario'
											},
											[
											 	{name:'idUsuario', mapping:'idUsuario'},
												{name:'Paterno', mapping:'Paterno'},
												{name:'Materno', mapping:'Materno'},
												{name:'Nom', mapping:'Nom'},
												{name:'Nombre', mapping:'Nombre'},
												{name:'Status', mapping:'Status'},
                                                {name:'idUsuario',mapping:'idUsuario'}
											]
										);                       
	
    var pPagina=new Ext.data.HttpProxy	(
										 	{
												url:'../Usuarios/procesarbUsuario.php',
												method:'POST'
											}
										 );
    
	var comboPapa=inicializarComboEmpleado(pPagina,lector,parametros2);

	

	var form = new Ext.form.FormPanel(	
										 	{
												baseCls: 'x-plain',
												layout:'absolute',
												defaultType: 'textfield',
												items: 	[
														 	new Ext.form.Label	(
																				 	{
																						x:25,
																						y:50,
																						text:'Empleado: '
																					}
																				)
															,
															comboPapa,
															new Ext.form.Radio	(
																					{
																						x:5,
																						y:5,
																						id:'rdoPaterno',
																						boxLabel:'Ap. Paterno',
																						checked:true,
																						value:1
																						
																					}
																				),
															new Ext.form.Radio	(
																					{
																						x:100,
																						y:5,
																						id:'rdoMaterno',
																						boxLabel:'Ap. Materno',
																						value:2
																					}
																				),
															new Ext.form.Radio	(
																					{
																						x:195,
																						y:5,
																						id:'rdoNombre',
																						boxLabel:'Nombre',
																						value:3
																					}
																				),
                                                            new Ext.form.Radio	(
																					{
																						x:290,
																						y:5,
																						id:'rdoClave',
																						boxLabel:'Cve. Empleado',
																						value:4
																					}
																				),
                                                             new Ext.form.Radio	(
																					{
																						x:395,
																						y:5,
																						id:'rdoCualquier',
																						boxLabel:'Cualquier parte del nombre / Clave    ',
																						value:5
																					}
																				)                    
															
														]
											}
										);
	
	ventana = new Ext.Window	(
									{
										title: lblAplicacion,
										width: 650,
										height:160,
										minWidth: 280,
										minHeight: 100,
										layout: 'fit',
										plain:true,
										bodyStyle:'padding:5px;',
										buttonAlign:'center',
										items: form,
										modal:true,
										listeners : {
														show : {
																	buffer : 10,
																	fn : function() 
																	{
																		comboPapa.focus();
																	}
																}
													},
										buttons:	[
														{
															text: 'Aceptar',
															handler:function()
																	{
																		
																		var idEmpleado=gE('idEmpleado').value;
																		if(idEmpleado==-1)
																		{
																			function funcResp()
																			{
																				comboPapa.focus();
																			}
																			Ext.MessageBox.alert(lblAplicacion,'Debe seleccionar el empleado a agregar como entidad',funcResp)
																			return;
																		}
                                                                        var x;
                                                                        var r;
                                                                        var gridEntidad=gEx('gridEntidad');
                                                                       	var registroGridEntidad=crearRegistro([
                                                                                                        {name: 'tEntidad'},
                                                                                                        {name: 'entidad'},
                                                                                                        {name: 'codigoEntidad'},
                                                                                                        {name: 'idRegistro'}
                                                                                                    ])
                                                                        if(obtenerPosFila(gridEntidad.getStore(),'idRegistro','3_'+gE('idEmpleado').value)==-1)
                                                                        {
                                                                            r=new registroGridEntidad(
                                                                                                        {
                                                                                                            tEntidad:'3',
                                                                                                            entidad:comboPapa.getRawValue(),
                                                                                                            codigoEntidad:gE('idEmpleado').value,
                                                                                                            idRegistro:'3_'+gE('idEmpleado').value
                                                                                                        }
                                                                                                    );
                                                                            gridEntidad.getStore().add(r);
                                                                        }
                                                                        ventana.close();
																	}
														},
														{
															text: 'Cancelar',
															handler:function()
																	{
																		ventana.close();
																	}
														}
													]
    								}
								);

	var rdoPaterno=Ext.getCmp('rdoPaterno');
	var rdoMaterno=Ext.getCmp('rdoMaterno');
	var rdoNombre=Ext.getCmp('rdoNombre');
    var rdoClave=Ext.getCmp('rdoClave');
	var rdoCualquier=Ext.getCmp('rdoCualquier');
	rdoPaterno.on('check',cambiarRadioSel);									
	rdoMaterno.on('check',cambiarRadioSel);									
	rdoNombre.on('check',cambiarRadioSel);	
    rdoClave.on('check',cambiarRadioSel);									
	rdoCualquier.on('check',cambiarRadioSel);							
    ventana.show();
}

function cambiarRadioSel(chk, valor)
{
	if(valor==true)
	{
		var rdoPaterno=Ext.getCmp('rdoPaterno');
		var rdoMaterno=Ext.getCmp('rdoMaterno');
		var rdoNom=Ext.getCmp('rdoNombre');
        var rdoClave=gEx('rdoClave');
        var rdoCualquier=gEx('rdoCualquier');
		if(rdoPaterno.id!=chk.id)
			rdoPaterno.setValue(false);
		if(rdoMaterno.id!=chk.id)
			rdoMaterno.setValue(false);
		if(rdoNom.id!=chk.id)
			rdoNom.setValue(false);
        if(rdoClave.id!=chk.id)
        	rdoClave.setValue(false);
        if(rdoCualquier.id!=chk.id)    
        	rdoCualquier.setValue(false);
		gE('cBusquedaP').value=chk.value;
	}
}

function inicializarComboEmpleado(pagina,lector, parametros2)
{

	var ds=new Ext.data.Store	(
								 	{
										proxy:pagina,
										reader:lector,
										baseParams:parametros2
									}
								 );
	
	function cargarDatos(dSet)
	{
		gE('idEmpleado').value='-1';
		var aNombre=Ext.getCmp('cmbNombreEmpleado').getValue();
		dSet.baseParams.criterio=aNombre;
		dSet.baseParams.campoBusqueda=gE('cBusquedaP').value;
        dSet.baseParams.listRoles="'17_0'";
       
	}
	
	ds.on('beforeload',cargarDatos);

	var resultTpl=new Ext.XTemplate	(
									 	'<tpl for="."><div class="search-item">',
											'{Paterno}&nbsp;{Materno}&nbsp;{Nom}&nbsp;<br>{Status}<br>---<br>',
										'</div></tpl>'
									 );
	
	var comboNombre= new Ext.form.ComboBox	(
												 	{
														x:100,
														y:45,
														id:'cmbNombreEmpleado',
														store:ds,
														displayField:'Nombre',
														typeAhead:false,
														minChars:1,
														loadingText:'Procesando, por favor espere...',
														width:350,
                                                        listWidth :350,
														pageSize:10,
														hideTrigger:true,
														tpl:resultTpl,
														itemSelector:'div.search-item',
														listWidth :300
													}
												 );

	function funcElemSeleccionado(combo,registro)
	{	
		gE('idEmpleado').value=registro.get('idUsuario');	
        
	
	}
	
	comboNombre.on('select',funcElemSeleccionado);	
	return comboNombre;
}

function formatearFila(record, rowIndex, p, ds)
{
	var comp='filaRechazado';
    if((record.get('ultimaActualizacion')!='')&&(record.get('ultimaActualizacion')!=null))
    {
    	
        if(record.get('ultimaActualizacion').format('Y-m-d H:i:s')==ultimaActualizacion)
        {
            comp='filaAceptado';
        }
        else
        {
            comp='filaRechazado';
        }
    }
	return 'x-grid3-row-expanded '+comp;
}
