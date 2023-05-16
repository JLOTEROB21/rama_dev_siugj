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
	
	$arrPerfiles="";
	$consulta="SELECT idPerfilesNomina,nombrePerfil,limitarFechasPeriodo FROM 662_perfilesNomina where idPerfilesNomina in (".$listPerfiles.") ORDER BY nombrePerfil";	
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$consulta="SELECT idPerfilImportacionNomina,concat(nombrePerfil,' [',f.formatoImportacion,']'),extensionesValidas,p.formatoImportacion,pImp.considerarSoloEmpleadosImportados FROM 662_perfilesImportacionNomina pImp,720_perfilesImportacion p,721_formatosImportacion f 
					WHERE pImp.idPerfilNomina=".$fila[0]." AND pImp.idPerfilImportacion=p.idPerfilConfiguracion AND f.idFormato=p.formatoImportacion ORDER BY nombrePerfil";
		$aPerfiles=$con->obtenerFilasArreglo($consulta);
		
		$o="['".$fila[0]."','".cv($fila[1])."','".$fila[2]."',".$aPerfiles."]";
		if($arrPerfiles=="")
			$arrPerfiles=$o;
		else
			$arrPerfiles.=",".$o;
	}

	$arrPerfiles="[".$arrPerfiles."]";
	
	
	
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
	$consulta="SELECT codigoUnidad,unidad FROM 817_organigrama WHERE institucion in(1,11)  and STATUS=1 ORDER BY unidad";
	$arrDeptos=$con->obtenerFilasArreglo($consulta);
	$consulta="SELECT id__632_tablaDinamica,nombrePuesto FROM _632_tablaDinamica ORDER BY nombrePuesto";
	$arrPuestos=$con->obtenerFilasArreglo($consulta);
	$consulta="SELECT id__638_tablaDinamica,tipoContratacion FROM _638_tablaDinamica ORDER BY tipoContratacion";
	$arrTipoContratacion=$con->obtenerFilasArreglo($consulta);
	$consulta="SELECT idConsulta,nombreConsulta FROM 991_consultasSql WHERE idTipoConcepto=6";
	$arrCriterios=$con->obtenerFilasArreglo($consulta);
	
	$codigoInstitucion=obtenerInstitucionPadre($_SESSION["codigoInstitucion"]);
	$consulta="SELECT codigoUnidad,unidad FROM 817_organigrama WHERE institucion in (1,11) AND codigoUnidad like '".$codigoInstitucion."%' and STATUS=1 ORDER BY unidad";
	$arrInstituciones=$con->obtenerFilasArreglo($consulta);
	if(existeRol("'72_0'"))
	{
		$codigoInstitucion="0001";
		$consulta="SELECT codigoUnidad,unidad FROM 817_organigrama WHERE institucion=1 AND codigoUnidad like '".$codigoInstitucion."%' and STATUS=1 ORDER BY unidad";
		$arrInstituciones=$con->obtenerFilasArreglo($consulta);
	}
	$consulta="SELECT ciclo,ciclo FROM 550_cicloFiscal order by ciclo";
	$arrCiclo=$con->obtenerFilasArreglo($consulta);
	//$consulta="select MAX(ultimaSincronizacion) FROM 9105_sincronizacionSistema ";
	$ultimaActualizacion='';
	$arrEntidadesAgrupadora="";
	$consulta="SELECT idEntidadNomina,nombreEntidadNomina,permiteSeleccionUnidades,'[]' as funciones FROM 679_entidadesAgrupadorasNomina where situacion=1";
	$res=$con->obtenerFilas($consulta);
	while($f=mysql_fetch_row($res))
	{
		$consulta="SELECT idConsulta,nombreConsulta FROM 991_consultasSql WHERE idConsulta IN 
			(SELECT idFuncionBusqueda FROM 680_funcionesBusqueda WHERE idEntidad=".$f[0].") ORDER BY nombreConsulta";
		$arrCriteriosBusqueda=$con->obtenerFilasArreglo($consulta);
		$obj="['".$f[0]."','".cv($f[1])."','".$f[2]."',".$arrCriteriosBusqueda."]";
		if($arrEntidadesAgrupadora=="")
			$arrEntidadesAgrupadora=$obj;
		else
			$arrEntidadesAgrupadora.=",".$obj;
	}
	
	$consulta="SELECT id__641_tablaDinamica,formaPago FROM _641_tablaDinamica ORDER BY formaPago";
	$arrMetodoPago=$con->obtenerFilasArreglo($consulta);
	
		
?>

var arrVersionNomina=[['1.1','1.1'],['1.2','1.2']];
var arrTipoGeneracion=[['O','Ordinaria'],['E','Extraordinaria']];
var idNominaUpload=-1;
var swfu=null;
var arrMetodoPago=<?php echo $arrMetodoPago?>;
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
                
    var arrPerfilesFiltro=arrPerfiles.slice(0);
    
    
    
    arrPerfilesFiltro.splice(0,0,['0','Cualquiera']);            
	var cmbPerfilFiltro=crearComboExt(cmbPerfilFiltro,arrPerfilesFiltro,0,0,300);                
    cmbPerfilFiltro.setValue('0');
    cmbPerfilFiltro.on('select',function(cmb,registro)
                                {
                                    gEx('gridNominas').getStore().reload();
                                }
                        )
                
	var cmbPerfil=crearComboExt('cmbPerfil',arrPerfiles);                
	var cmbMetodoPago= crearComboExt('cmbMetodoPago',arrMetodoPago);                               
	arrCriterioCombina.splice(0,0,['0','No combinar']);
	
    var cmbVersionNomina=crearComboExt('cmbVersionNomina',arrVersionNomina);
    
    var cmbTipoGeneracion=crearComboExt('cmbTipoGeneracion',arrTipoGeneracion);
    
    
    
    var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name: 'idNomina',type:'int'},
                                                        {name: 'nomina'},
                                                        {name: 'fInicioInc', type:'date', dateFormat:'d/m/Y'},
                                                        {name: 'fFinInc', type:'date', dateFormat:'d/m/Y'},
                                                        {name: 'fEstPago', type:'date', dateFormat:'d/m/Y'},
                                                        {name: 'fPago', type:'date', dateFormat:'d/m/Y'},
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
                                                        {name: 'fFinFalta', type:'date', dateFormat:'Y-m-d'},
                                                        {name: 'metodoPago'},
                                                        {name: 'archivoImportacion'},
                                                        {name: 'idArchivoImportacion'},
                                                        {name: 'admiteImportacion'},
                                                        {name: 'versionNomina'},
                                                        {name: 'tipoEjecucionNomina'}
                                                        
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
                                        proxy.baseParams.ciclo=cmbCiclo.getValue();
                                        proxy.baseParams.idPerfil=cmbPerfilFiltro.getValue();
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
                            	
                               // gEx('btnVer').disable();
                                gEx('btnRemover').disable();
                            	var permisos=registro.get('permisos');
                                if(permisos.indexOf('E')!=-1)
                                {
                                	gEx('btnRemover').enable();
                                }
                                
                            	if(registro.get('fechaUltimaEjecucion')!='')
                                {
                                	//gEx('btnVer').enable();
                                }
                                
                                
                                
                            }
    		)
            
	chkRow.on('rowdeselect',function(sm,nFila,registro)            
                            {
                                
                                //gEx('btnVer').disable();
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
															sortable:true,
															dataIndex:'descripcionNomina',
                                                            editor:{xtype:'textfield'}
														},
														{
															header:'Perfil de n&oacute;mina',
															width:170,
															sortable:true,
															dataIndex:'nomina',
                                                            editor:cmbPerfil,
                                                            renderer:function(val)
                                                            		{
                                                                    	return formatearValorRenderer(arrPerfiles,val);
                                                                    }
														},
                                                        {
															header:'Plantel',
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
															dataIndex:'fInicioInc',
                                                            editor:	{xtype:'datefield'},
                                                            renderer:function(val)
                                                            		{
                                                                    	if(val)
	                                                                    	return val.format('d/m/Y');
                                                                    }
														},
                                                        {
															header:'Fecha fin <br />Incidencias',
															width:85,
															sortable:true,
                                                            align:'center',
															dataIndex:'fFinInc',
                                                            editor:	{xtype:'datefield'},
                                                            renderer:function(val)
                                                            		{
                                                                    	return val.format('d/m/Y');
                                                                    }
														}
                                                        ,
                                                        {
															header:'Fecha<br /> de pago',
															width:85,
															sortable:true,
                                                            align:'center',
															dataIndex:'fEstPago',
                                                            editor:	{xtype:'datefield'},
                                                            renderer:function(val)
                                                            		{
                                                                    	if(val)
	                                                                    	return val.format('d/m/Y');
                                                                    }
														},
                                                        {
															header:'Fecha inicio <br />de faltas',
															width:85,
															sortable:true,
                                                            align:'center',
															dataIndex:'fInicioFalta',
                                                            editor:	{xtype:'datefield'},
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
                                                            editor:	{xtype:'datefield'},
                                                            renderer:function(val)
                                                            		{
                                                                    	if(val!=null)
	                                                                    	return val.format("d/m/Y");
                                                                        else
                                                                        	return "N/A";
                                                                    }
														},
                                                        {
															header:'M&eacute;todo de pago',
															width:170,
															sortable:true,
															dataIndex:'metodoPago',
                                                            editor:	cmbMetodoPago,
                                                            renderer:function(val)
                                                            		{
                                                                    	return formatearValorRenderer(arrMetodoPago,val);
                                                                    }
														},
                                                        {
															header:'Archivo de importaci&oacute;n',
															width:170,
															sortable:true,
															dataIndex:'archivoImportacion',
                                                            renderer:function(val,meta,registro)
                                                            		{
                                                                    	var sL=false;
                                                                        
                                                                        if(registro.data.permisos.indexOf('M')==-1)
                                                                        {
                                                                            sL=true;
                                                                        }
                                                                        
                                                                    	if(sL)
                                                                        {
                                                                        	return '<a href="javascript:descargarArchivoImportacion(\''+bE(registro.data.idArchivoImportacion)+'\')">'+mostrarValorDescripcion(val)+'</a>';
                                                                        }
                                                                        else
                                                                        {
                                                                            var compArchivo='';
                                                                            if(registro.data.admiteImportacion!='0')
                                                                            {
                                                                                compArchivo='<a href="javascript:uploadArchivoImportacion(\''+bE(registro.data.idNomina)+'\')"><img width="13" height="13" src="../images/pencil.png" title="Ingresar archivo de importaci&oacute;n" alt="Ingresar archivo de importaci&oacute;n" /></a>&nbsp;&nbsp;';
                                                                            }
                                                                            
                                                                            if((registro.data.idArchivoImportacion!='')&&(registro.data.idArchivoImportacion!='-1'))
                                                                                return '<a href="javascript:removerArchivoImportacion(\''+bE(registro.data.idNomina)+'\')"><img width="13" height="13" src="../images/delete.png" title="Remover archivo de importaci&oacute;n" alt="Remover archivo de importaci&oacute;n" /></a>&nbsp;&nbsp;'+compArchivo+'<a href="javascript:descargarArchivoImportacion(\''+bE(registro.data.idArchivoImportacion)+'\')">'+mostrarValorDescripcion(val)+'</a>';
                                                                            else
                                                                                 return compArchivo;
                                                                         }
                                                                    }
														},
                                                        {
															header:'Versi&oacute;n de n&oacute;mina',
															width:120,
															sortable:true,
                                                            hidden:true,
															dataIndex:'versionNomina',
                                                            editor:cmbVersionNomina,
                                                            renderer:function(val,meta,registro)
                                                            		{
                                                                    	return formatearValorRenderer(arrVersionNomina,val);
                                                                           
                                                                    }
														},
                                                        {
															header:'Tipo de generaci&oacute;n',
															width:120,
															sortable:true,
                                                            editor:cmbTipoGeneracion,
															dataIndex:'tipoEjecucionNomina',
                                                            renderer:function(val,meta,registro)
                                                            		{
                                                                    	return formatearValorRenderer(arrTipoGeneracion,val);
                                                                           
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
                                                            region:'center',
                                                            border:false,
                                                            cm: cModelo,
                                                            sm:chkRow,
                                                            clicksToEdit:1,
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
                                                                        	id:'btnVer',
                                                                        	icon:'../images/magnifier.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Ingresar a N&oacute;mina',
                                                                            //disabled:true,
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
                                                                                        var arrParam=[['idNomina',fila.get('idNomina')]];
                                                                                        enviarFormularioDatos('../nomina/tblAdmonNominaPerfil.php',arrParam);	
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
	
    
    
    tblGrid.on('beforeedit',function(e)
    						{
                            	if(e.record.data.permisos.indexOf('M')==-1)
                                {
                                	if(e.field=='fEstPago')
                                    {
                                    	if(e.record.data.permisos.indexOf('P')==-1)
                                        {
                                        	e.cancel=true;
                                        }
                                    }
                                    else
                                    	e.cancel=true;
                                }
                                	
                            }
    			)
                
                
	 tblGrid.on('afteredit',function(e)
    						{
                            
                            	if(e.value=='')
                                {
                                	function resp1()
                                    {
                                    	e.record.set(e.field,e.originalValue);
                                        e.grid.startEditing(e.row,e.column);
                                    }
                                    msgBox('Es valor ingresado NO puede ser vac&iacute;o',resp1);
                                	return;
                                }
                            	
                            	var campo='';
                                var valor=e.value;
                            	switch(e.field)
                                {
                                	case 'descripcionNomina':
                                    	campo='descripcion';
                                    break;
                                    case 'nomina':
                                    	campo='idPerfil';
                                    break;
                                    case 'fInicioInc':
                                    	campo='fechaInicioIncidencias';
                                        valor=e.value.format('Y-m-d');
                                    break;
                                    case 'fFinInc':
                                    	campo='fechaFinIncidencias';
                                         valor=e.value.format('Y-m-d');
                                    break;
                                    case 'fEstPago':
                                    	campo='fechaEstimadaPago';
                                         valor=e.value.format('Y-m-d');
                                    break;
                                    case 'fInicioFalta':
                                    	campo='fechaInicioFalta';
                                         valor=e.value.format('Y-m-d');
                                    break;
                                    case 'fFinFalta':
                                    	campo='fechaCorteAsistencia';
                                         valor=e.value.format('Y-m-d');
                                    break;
                                    case 'metodoPago':
                                    	campo='idFormaPago';
                                    break;
                                    case 'versionNomina':
                                    	campo='versionNomina';
                                    break;
                                    case 'tipoEjecucionNomina':
                                    	campo='tipoEjecucionNomina';
                                    break;
                                	
                                }
                                	
                                    
                                    
                                function funcAjax()
                                {
                                    var resp=peticion_http.responseText;
                                    arrResp=resp.split('|');
                                    if(arrResp[0]=='1')
                                    {
                                        
                                    }
                                    else
                                    {
                                    	function resp2()
                                        {
                                            e.record.set(e.field,e.originalValue);
                                            
                                        }
                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0],resp2);
                                    }
                                }
                                obtenerDatosWeb('../paginasFunciones/funcionesEspecialesNomina.php',funcAjax, 'POST','funcion=45&i='+bE(e.record.data.idNomina)+'&c='+bE(campo)+'&v='+bE(valor),true);
                                    
                                    
                            }
    			)                
                
    
    var gridBiometricos=crearGridBiometricos();                                                    

	new Ext.Viewport(	{
                            layout: 'border',
                            items: [
                            			{
                                        	xtype:'panel',
                                            region:'center',
                                            layout:'border',
                                            title:'<span class="letraRojaSubrayada8">Administraci&oacute;n de n&oacute;minas </span>',
                                            tbar:	[
                                            			{
                                                            xtype:'label',
                                                            html:'<span class="letraRojaSubrayada8"><b>Ciclo fiscal:</b></span>&nbsp;&nbsp;'
                                                        },
                                                        cmbCiclo,
                                                        '-',
                                                        {
                                                            xtype:'label',
                                                            html:'<span class="letraRojaSubrayada8"><b>Perfil de nómina:</b></span>&nbsp;&nbsp;'
                                                        },
                                                        cmbPerfilFiltro
                                            		],
                                            
                                            
                                            items:	[
                                           				tblGrid
                                                        <?php
															if(existeRol("'72_0'"))
															{
														?>
                                                        //,
                                                        //gridBiometricos
                                                        <?php
															}
														?>
	                                           		]
                                        }
                                     ]
						}
                    )   

}

function descargarArchivoImportacion(iA)
{
	obtenerDocumentoUsr((iA));
}


function uploadArchivoImportacion(iN)
{
	idNominaUpload=bD(iN);

	  
	var cmbTipoArchivoImportacion=crearComboExt('cmbTipoArchivoImportacion',[],140,5,300);  
    
    cmbTipoArchivoImportacion.on('select',	function(cmb,registro)
    										{
                                            	if(registro.data.id!='0')
                                                {
                                                    
                                                  	gEx('tblArchivoControl').show();
                                                    gEx('btnUploadFile').show();
                                                    gEx('tblArchivoControl').setText('<table width="290"><tr><td><div id="uploader"><p>Your browser doesn\'t have Flash, Silverlight or HTML5 support.</p></div></td></tr><tr id="filaAvance" style="display:none"><td align="right">Porcentaje de avance: <span id="porcentajeAvance"> 0%</span></td></tr></table>',false);
                                                    gEx('lblContainerUploader').setText('<div id="containerUploader"></div>',false);
                                                    crearFileUpload(registro.data.valorComp.replace(/,/gi,';'),uploadFileDoneV2)
                                                   
                                                    
                                                }
                                                else
                                                {
                                                	gEx('tblArchivoControl').hide();
                                                    gEx('btnUploadFile').hide();
                                                    
                                                    
                                                }
                                                
                                            }      
                                 )
    
    
	var pos=obtenerPosFila(gEx('gridNominas').getStore(),'idNomina',bD(iN));
	var fila=gEx('gridNominas').getStore().getAt(pos);
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            id:'lblArchivoImportacion',
                                                            html:'Archivo de importaci&oacute;n:'
                                                        },
                                                        cmbTipoArchivoImportacion,
                                                        
                                                        {
                                                            x:140,
                                                            y:38,
                                                            hidden:true,
                                                            id:'tblArchivoControl',
                                                            html:	'<table width="290"><tr><td><div id="uploader"><p>Your browser doesn\'t have Flash, Silverlight or HTML5 support.</p></div></td></tr><tr id="filaAvance" style="display:none"><td align="right">Porcentaje de avance: <span id="porcentajeAvance"> 0%</span></td></tr></table>'
                                                        },
                                                       
                                                        {
                                                            x:435,
                                                            y:39,
                                                            id:'btnUploadFile',
                                                            xtype:'button',
                                                            hidden:true,
                                                            text:'Seleccionar...',
                                                            handler:function()
                                                                    {
                                                                        $('#containerUploader').click();
                                                                    }
                                                        },
							 {
                                                            x:185,
                                                            y:10,
                                                            hidden:true,
                                                            id:'lblContainerUploader',
                                                            html:	'<div id="containerUploader"></div>'
                                                        },
                                                        
                                                        {
                                                            x:0,
                                                            y:0,
                                                            xtype:'hidden',
                                                            id:'idArchivo',
                                                            value:-1

                                                        },
                                                        {
                                                            x:0,
                                                            y:0,
                                                            xtype:'hidden',
                                                            id:'nombreArchivo'
                                                        }

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										id:'vUploadFile',
                                        title: 'Ingresar archivo de importaci&oacute;n [Nomina: '+fila.data.folio+', '+formatearValorRenderer(arrInstituciones,fila.data.plantel)+']',
										width: 600,
										height:170,
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
															handler:function()
																	{
																		ventanaAM.close();
																	}
														}
													]
									}
								);
	
    
    
    obtenerPerfilesImportacionPerfilNomina(bD(iN),ventanaAM);
	
}

function uploadFileDoneV2(file, serverData)
{
	
	try 
    {

    	var cadObj='';
    	file.id = "singlefile";	// This makes it so FileProgress only makes a single UI element, instead of one for each file
        var arrDatos=serverData.split('|');
        
		if ( arrDatos[0]!='1') 
		{
			
		} 
		else 
		{
        	
        	cadObj='{"idArchivo":"'+arrDatos[1]+'","nombreArchivo":"'+arrDatos[2]+'","idNomina":"'+idNominaUpload+'"}';
            var nArchivo=arrDatos[2];
            function funcAjax()
            {
                var resp=peticion_http.responseText;
                arrResp=resp.split('|');
                if(arrResp[0]=='1')
                {
            		gEx("idArchivo").setValue(arrDatos[1]);
                    gEx("nombreArchivo").setValue(arrDatos[2]);
                    
                    
                   
                    
                    var gridNominas=gEx('gridNominas');
                    
                    var pos=obtenerPosFila(gridNominas.getStore(),'idNomina',idNominaUpload);
                    var fila=gridNominas.getStore().getAt(pos);
                    
                    fila.set('archivoImportacion',nArchivo+' ('+gEx('cmbTipoArchivoImportacion').getRawValue()+')');
                    fila.set('idArchivoImportacion',arrResp[1]);
                    
                    gEx('vUploadFile').close();        
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesEspecialesNomina.php',funcAjax, 'POST','funcion=55&cadObj='+cadObj,true);
            
		}
		
	} 
    catch (e) 
	{
	
	}
}


function obtenerPerfilesImportacionPerfilNomina(iN,v)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            gEx('cmbTipoArchivoImportacion').getStore().loadData(eval(arrResp[1]));
            v.show();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesEspecialesNomina.php',funcAjax, 'POST','funcion=54&iN='+iN,true);
}

function mostrarVentanaNuevaNomina()
{
	var considerarFalta=0;
	var cmbTipoNomina=crearComboExt('cmbTipoNomina',arrPerfiles,140,5,300);
    cmbTipoNomina.on('select',function(combo,registro)
    						{
                            	var cmbQuincena=gEx('cmbQuincena');
                                var dteFaltaDesde=gEx('dteFaltaDesde');
                                dteFaltaDesde.setValue('');
                               // dteFaltaDesde.disable();
                                
                                
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
                                
                                
                                var pos=existeValorMatriz(arrPerfiles,registro.data.id);
                               
                                var aPerfiles=arrPerfiles[pos][3].slice(0);
                                aPerfiles.splice(0,0,['0','Ninguno']);
                                gEx('cmbTipoArchivoImportacion').getStore().loadData(aPerfiles);
                                if(aPerfiles.length>1)
                                {
                                	gEx('lblArchivoImportacion').show();
                                    gEx('cmbTipoArchivoImportacion').show();
                                    
                                    
                                    
                                }
                                else
                                {
                                	gEx('lblArchivoImportacion').hide();
                                    gEx('cmbTipoArchivoImportacion').hide();
                                    
                                }
                                gEx('cmbTipoArchivoImportacion').setValue('0');
								dispararEventoSelectCombo('cmbTipoArchivoImportacion');
                                
                                
                            }
					)                            
    
    
    var objConf={};
    objConf.arrCampos=	[
    						{name:'id'},
                            {name:'nombre'},
                            {name:'valorComp'},
                            {name:'fechaFin'}
                              
    					]
    var cmbQuincena=crearComboExt('cmbQuincena',[],600,5,240,objConf);
    cmbQuincena.on('select',function(combo,registro)
    						{
                            	var dteFinInc=gEx('dteFinInc');
                            	var dteFechaInicio=gEx('dteIniInc');
                                var dteFechaEstPago=gEx('dteFechaEstPago');
                                var dteFaltaHasta=gEx('dteFaltaHasta');
                                dteFechaInicio.enable();
                                var dteFaltaDesde=gEx('dteFaltaDesde');
                                dteFaltaDesde.setValue('');
                                //dteFaltaDesde.disable();
                                
                                if(cmbTipoNomina.getValue()!='')
                                {
                                	obtenerFechaInicioFalta();
                                }
                            	
                                var fecha=registro.get('valorComp');
                                dteFechaInicio.setValue(fecha);
                                var fechaFin=registro.get('fechaFin');
                                
                                
                                var pos=existeValorMatriz(arrPerfiles,gEx('cmbTipoNomina').getValue());
                                
                                if((pos!=-1)&&(arrPerfiles[pos][2]=='1'))
                                {
                                    dteFechaInicio.setMaxValue(fechaFin);
                                    dteFinInc.setMinValue(fecha);
								}                                
                                
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
                   
	var cmbMetodoPago=crearComboExt('cmbMetodoPago',arrMetodoPago,140,95,350);                   
    cmbMetodoPago.setValue('1');
                   
	var cmbTipoArchivoImportacion=crearComboExt('cmbTipoArchivoImportacion',[],140,200,300);                   
	cmbTipoArchivoImportacion.hide();             
    
    
    cmbTipoArchivoImportacion.on('select',	function(cmb,registro)
    										{
                                            	if(registro.data.id!='0')
                                                {
                                                    var pos=existeValorMatriz(arrPerfiles,gEx('cmbTipoNomina').getValue());
                                                    var aPerfiles=arrPerfiles[pos][3].slice(0);
                                                    
                                                    pos=existeValorMatriz(aPerfiles,registro.data.id);
                                                    gEx('tblArchivoControl').show();
                                                    gEx('btnUploadFile').show();
                                                    gEx('tblArchivoControl').setText('<table width="290"><tr><td><div id="uploader"><p>Your browser doesn\'t have Flash, Silverlight or HTML5 support.</p></div></td></tr><tr id="filaAvance" style="display:none"><td align="right">Porcentaje de avance: <span id="porcentajeAvance"> 0%</span></td></tr></table>',false);
                                                    gEx('lblContainerUploader').setText('<div id="containerUploader"></div>',false);
                                                    crearFileUpload(aPerfiles[pos][2].replace(/,/gi,';'))
                                                    
                                                    if(aPerfiles[pos][4]=='1')
                                                    {
                                                    	gEx('chkAplicaInstitucion').hide();
                                                        gEx('chkNominaIndividual').hide();
                                                        gEx('gridEntidad').getStore().removeAll();
                                                        gEx('gridEntidad').disable();
                                                        gEx('cmbPlantelesImportacion').show();
                                                        
                                                    }
                                                    else
                                                    {
                                                    	gEx('chkAplicaInstitucion').show();
                                                        gEx('chkAplicaInstitucion').fireEvent('check',gEx('chkAplicaInstitucion'),gEx('chkAplicaInstitucion').getValue());
                                                        gEx('cmbPlantelesImportacion').hide();
                                                    }
                                                    
                                                    
                                                }
                                                else
                                                {
                                                	 gEx('tblArchivoControl').hide();
                                                     gEx('btnUploadFile').hide();
                                                	gEx('chkAplicaInstitucion').show();
                                                    gEx('chkAplicaInstitucion').fireEvent('check',gEx('chkAplicaInstitucion'),gEx('chkAplicaInstitucion').getValue());
                                                    gEx('cmbPlantelesImportacion').hide();
                                                }
                                                
                                            }      
                                 )
	

	var cmbPlantelesImportacion=crearComboExt('cmbPlantelesImportacion',arrInstituciones,140,225,280);
	cmbPlantelesImportacion.hide();          
    var cmbVersion=crearComboExt('cmbVersion',arrVersionNomina,400,65,130);         
    cmbVersion.setValue('1.2');
    cmbVersion.hide();
    var cmbTipoGeneracion=crearComboExt('cmbTipoGeneracion',arrTipoGeneracion,660,65,150);
    cmbTipoGeneracion.setValue('O');
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
                                                        	x:480,
                                                            y:10,
                                                            html:'Periodo a ejecutar:'
                                                        },
                                                        cmbQuincena,
                                                        
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            html:'Periodo de incidencias:'
                                                        },
                                                        {
                                                        	xtype:'datefield',
                                                            id:'dteIniInc',
                                                           // disabled:true,
                                                            x:140,
                                                            y:35
                                                        },
                                                        {
                                                        	x:255,
                                                            y:40,
                                                            html:'Al:'
                                                        },
                                                        {
                                                        	xtype:'datefield',
                                                            id:'dteFinInc',
                                                            //disabled:true,
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
                                                            id:'lblConsiderarFalta',
                                                            hidden:true,
                                                            html:'Considerar faltas del:'
                                                        },
                                                        {
                                                        	xtype:'datefield',
                                                            id:'dteFaltaDesde',
                                                            //disabled:true,
                                                            hidden:true,
                                                            
                                                            x:550,
                                                            y:35
                                                        },
                                                        {
                                                        	x:660,
                                                            y:45,
                                                            hidden:true,
                                                            id:'lblAlFalta',
                                                            html:'Al:'
                                                        },
                                                        {
                                                        	xtype:'datefield',
                                                            id:'dteFaltaHasta',
                                                            //disabled:true,
                                                            hidden:true,
                                                            x:690,
                                                            y:35
                                                        },
                                                        {
                                                        	x:10,
                                                            y:70,
                                                            html:'Fecha de pago:'
                                                        },
                                                        {
                                                        	xtype:'datefield',
                                                            id:'dteFechaEstPago',
                                                            disabled:true,
                                                            x:140,
                                                            y:65
                                                        },
                                                        {
                                                        	x:280,
                                                            y:70,
                                                            hidden:true,
                                                            html:'Versi&oacute;n de n&oacute;mina:'
                                                        },
                                                        cmbVersion,
                                                        {
                                                        	x:560,
                                                            y:70,
                                                            html:'Tipo generaci&oacute;n:'
                                                        },
                                                        cmbTipoGeneracion,
                                                        {
                                                        	xtype:'label',
                                                            x:10,
                                                            y:100,
                                                            html:'M&eacute;todo de pago:'
                                                        },
                                                        cmbMetodoPago,
                                                        {
                                                        	xtype:'label',
                                                            x:10,
                                                            y:130,
                                                            html:'Descripci&oacute;n:'
                                                        },
                                                        {
                                                        	id:'txtDescripcion',
                                                        	xtype:'textarea',
                                                            width:670,
                                                            height:60,
                                                            x:140,
                                                            y:125,
                                                        },
                                                        {
                                                        	x:10,
                                                            y:205,
                                                            id:'lblArchivoImportacion',
                                                            hidden:true,
                                                            html:'Archivo de importaci&oacute;n:'
                                                        },
                                                        cmbTipoArchivoImportacion,
                                                        
                                                        {
                                                            x:460,
                                                            y:200,
                                                            hidden:true,
                                                            id:'tblArchivoControl',
                                                            html:	'<table width="290"><tr><td><div id="uploader"><p>Your browser doesn\'t have Flash, Silverlight or HTML5 support.</p></div></td></tr><tr id="filaAvance" style="display:none"><td align="right">Porcentaje de avance: <span id="porcentajeAvance"> 0%</span></td></tr></table>'
                                                        },
                                                       
                                                        {
                                                            x:755,
                                                            y:201,
                                                            id:'btnUploadFile',
                                                            xtype:'button',
                                                            hidden:true,
                                                            text:'Seleccionar...',
                                                            handler:function()
                                                                    {
                                                                        $('#containerUploader').click();
                                                                    }
                                                        },
														 {
                                                            x:185,
                                                            y:10,
                                                            hidden:true,
                                                            id:'lblContainerUploader',
                                                            html:	'<div id="containerUploader"></div>'
                                                        },
                                                        
                                                       
                                                        
                                                        {
                                                            x:0,
                                                            y:0,
                                                            xtype:'hidden',
                                                            id:'idArchivo',
                                                            value:-1

                                                        },
                                                        {
                                                            x:0,
                                                            y:0,
                                                            xtype:'hidden',
                                                            id:'nombreArchivo'
                                                        },
                                                        
                                                        {
                                                        	x:10,
                                                            y:230,
                                                            html:'Aplicar n&oacute;mina a:'
                                                        },
                                                        cmbPlantelesImportacion,
                                                        
                                                        
                                                        
                                                        {
                                                        	x:140,
                                                            y:225,
                                                            id:'chkAplicaInstitucion',
                                                            xtype:'checkbox',
                                                            boxLabel:'Toda la instituci&oacute;n',
                                                            checked:true,
                                                            listeners:	{
                                                            				check:function(ch,valor)
                                                                            {
                                                                            	if(valor)
                                                                                {
                                                                                	gridAplicaNomina.disable();
                                                                                    gridAplicaNomina.getStore().removeAll();
                                                                                    gEx('chkNominaIndividual').hide();
                                                                                }
                                                                                else
                                                                                {
                                                                                	gridAplicaNomina.enable();
                                                                                    gEx('chkNominaIndividual').show();
                                                                                }
                                                                            }		
                                                            			}
                                                        },
                                                        {
                                                        	x:280,
                                                            y:225,
                                                            hidden:true,
                                                            id:'chkNominaIndividual',
                                                            xtype:'checkbox',
                                                            boxLabel:'Generar n&oacute;minas indiviuales por entidad',
                                                            checked:true
                                                        },
                                                        gridAplicaNomina
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Generar Nueva Plantilla de N&oacute;mina',
										width: 900,
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
                                                        	id:'btnAceptarNomina',
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
                                                                    	var chkAplicaInstitucion=gEx('chkAplicaInstitucion');
                                                                        var tipoAplicacion='1';
                                                                        var entidadesAplica='';
                                                                        if(!chkAplicaInstitucion.getValue())
                                                                        {
                                                                        	tipoAplicacion=0;
                                                                        	if(gridAplicaNomina.getStore().getCount()==0)
                                                                            {
                                                                            	msgBox('Debe indicar al menos una entidad a la cual se aplicar&aacute; la n&oacute;mina');
                                                                            	return;
                                                                            }
                                                                        }
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
                                                                       
                                                                       
                                                                       if(cmbMetodoPago.getValue()=='')
                                                                       {
                                                                       		function respErr()
                                                                            {
                                                                            	cmbMetodoPago.focus();
                                                                            }
                                                                            msgBox('Debe especificar el m&eacute;todo de pago de la n&oacute;mina',respErr);
                                                                            return;
                                                                       }
                                                                       
                                                                       var nominasIndividuales=0;
                                                                       var entidadesAplica='';
                                                                       var cmbTipoArchivoImportacion=gEx('cmbTipoArchivoImportacion');
                                                                       var totalEntidadesAplica=0;
                                                                       if(cmbTipoArchivoImportacion.getValue()!='0')
                                                                       {
	                                                                       	nominasIndividuales=1;
                                                                       		tipoAplicacion=0;
                                                                            
                                                                            if((gEx('idArchivo').getValue()=='')||(gEx('idArchivo').getValue()=='-1'))
                                                                            {
                                                                            	msgBox('Debe ingresar el archivo de importaci&oacute;n');
                                                                                return;
                                                                            
                                                                            }
                                                                            
                                                                            if((cmbPlantelesImportacion.isVisible())&&(cmbPlantelesImportacion.getValue()==''))
                                                                            {
                                                                            	function respErrInstitucion()
                                                                                {
                                                                                	cmbPlantelesImportacion.focus();
                                                                                }
                                                                            	msgBox('Debe indicar la entidad de aplicaci&oacute;n de la n&oacute;mina ',respErrInstitucion);
                                                                                return;
                                                                            }
                                                                            
                                                                            entidadesAplica="[['7',"+cmbPlantelesImportacion.getValue()+",'0']]";
                                                                            
                                                                       
                                                                       }
                                                                       else
                                                                       {
                                                                       		if(gEx('chkNominaIndividual').getValue())
	                                                                        	nominasIndividuales=1;
                                                                                
                                                                            
                                                                            var x;
                                                                            var fila;
                                                                            var obj;
                                                                            for(x=0;x<gridAplicaNomina.getStore().getCount();x++)
                                                                            {
	                                                                           
                                                                                fila=gridAplicaNomina.getStore().getAt(x);
                                                                                obj="['"+fila.get('tEntidad')+"','"+fila.get('codigoEntidad')+"','"+fila.get('idCriterio')+"']";
                                                                                if(entidadesAplica=='')
                                                                                    entidadesAplica=obj;
                                                                                else
                                                                                    entidadesAplica+=','+obj;
                                                                                 totalEntidadesAplica++;
                                                                            }
                                                                           
                                                                            
                                                                            
                                                                            entidadesAplica='['+entidadesAplica+']';
                                                                                
                                                                                
                                                                       }
                                                                      
                                                                       
                                                                        var idPerfilImportacion=0;
                                                                        
                                                                        if(cmbTipoArchivoImportacion.getValue()!='')
                                                                        	idPerfilImportacion=cmbTipoArchivoImportacion.getValue();
                                                                        
                                                                        var cadObj='{"idPerfilImportacion":"'+idPerfilImportacion+'","idArchivoImportacion":"'+gEx('idArchivo').getValue()+
                                                                        			'","nombreArchivoImportacion":"'+cv(gEx("nombreArchivo").getValue())+'","metodoPago":"'+cmbMetodoPago.getValue()+
                                                                                    '","nominasIndividuales":"'+nominasIndividuales+'","fechaFaltaDesde":"'+fDesde+'","fechaFalta":"'+fHasta+
                                                                                    '","ciclo":"'+gE('ciclo').value+'","quincenaAplicacion":"'+cmbQuincena.getValue()+'","tipoNomina":"'+cmbTipoNomina.getValue()+
                                                                                    '","quincenaAplica":"'+cmbQuincena.getValue()+
                                                                        			'","fechaIniInc":"'+dteIniInc.getValue().format('Y-m-d')+'","fechaFinInc":"'+dteFinInc.getValue().format('Y-m-d')+
                                                                                    '","fechaPago":"'+dteFechaEstPago.getValue().format('Y-m-d')+'","tipoAplicacion":"'+tipoAplicacion+
                                                                                    '","entidadesAplica":"'+bE(entidadesAplica)+'","descripcion":"'+gEx('txtDescripcion').getValue()+
                                                                                    '","versionNomina":"'+cmbVersion.getValue()+'","tipoGeneracion":"'+cmbTipoGeneracion.getValue()+'"}';
                                                                      
                                                                       function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            
                                                                            	if((tipoAplicacion=='1')||(nominasIndividuales=='0')||((nominasIndividuales=='1')&&(totalEntidadesAplica==1)))
                                                                            	{
                                                                                	var arrParam=[['idNomina',arrResp[1]]];
                                                                                    enviarFormularioDatos('../nomina/tblAdmonNominaPerfil.php',arrParam);	
                                                                                }
                                                                                else
                                                                                {
                                                                                	gEx('gridNominas').getStore().reload();
                                                                                	ventanaAM.close();
                                                                                }
                                                                            	
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

function crearFileUpload(extensiones,funcionOK)
{
	var subidaCorrectaFuncion=subidaCorrecta;
    if(funcionOK)
    	subidaCorrectaFuncion=funcionOK;
    
	var cObj={

                          upload_url: "../paginasFunciones/procesarDocumento.php", //lquevedor
                          file_post_name: "archivoEnvio",
                          file_size_limit : "500 MB",
                          file_types : extensiones,			// or you could use something like: "*.doc;*.wpd;*.pdf",
                          file_types_description : "Todos los archivos",
                          file_upload_limit : 0,
                          file_queue_limit : 1,   
                          useUpdateV2:true,                      
                          upload_success_handler : subidaCorrectaFuncion,
                          onFilesAdded:function(up, files)
                          				{
                                        	up.start();
                                        }
                      };
                      
	crearControlUploadHTML5(cObj);                      
                      
}


function subidaCorrecta(file, serverData) 
{
	try 
    {
    	
    	file.id = "singlefile";	// This makes it so FileProgress only makes a single UI element, instead of one for each file
        var arrDatos=serverData.split('|');
		if ( arrDatos[0]!='1') 
		{
			
		} 
		else 
		{
        	
			gEx("idArchivo").setValue(arrDatos[1]);
            gEx("nombreArchivo").setValue(arrDatos[2]);
            gEx('btnAceptarNomina').enable();
            
		}
		
	} 
    catch (e) 
	{
		alert(e);
	}
}



function obtenerFechaInicioFalta()
{
   	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            
            var oFechas=eval('['+arrResp[1]+']')[0];           
            gEx('dteIniInc').setValue(oFechas.fechaInicioIncidencia);
            gEx('dteFinInc').setValue(oFechas.fechaFinIncidencia);
            gEx('dteFaltaDesde').setValue(oFechas.fechaInicioFalta);
            gEx('dteFaltaHasta').setValue(oFechas.fechaFinFalta);
            
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
                                                                frame:false,
                                                                border:true,
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
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'tEntidad'},
                                                                    {name: 'entidad'},
                                                                    {name: 'codigoEntidad'},
                                                                    {name: 'idRegistro'},
                                                                    {name: 'lblCriterio'},
                                                                    {name: 'idCriterio'}
    
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
															header:'Tipo entidad',
															width:150,
															sortable:true,
															dataIndex:'tEntidad',
                                                            renderer:function(val)
                                                            		{
                                                                    	

                                                                    	return mostrarValorDescripcion(formatearValorRenderer(arrTiposEntidades,(val+'')));
                                                                    }
														},
														{
															header:'Entidad',
															width:350,
															sortable:true,
															dataIndex:'entidad',
                                                            renderer:mostrarValorDescripcion 
														},
														{
															header:'Combinar con criterio de b&uacute;squeda',
															width:270,
															sortable:true,
															dataIndex:'lblCriterio',
                                                            renderer:mostrarValorDescripcion 
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gridEntidad',
                                                            stripeRows :true,
                                                            columnLines : true,
                                                            store:alDatos,
                                                            frame:false,
                                                            x:10,
                                                            y:250,
                                                            cm: cModelo,
                                                            height:200,
                                                            width:850,
                                                            sm:chkRow,
                                                            disabled:true,
                                                            tbar:	[
                                                            			{
                                                                        	icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Agregar Entidad',
                                                                            handler:function()
                                                                            		{
                                                                                    	mostrarVentanaSelTipoEntidad();
                                                                                    }
                                                                            
                                                                        },'-',
                                                                        {
                                                                        	icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Remover Entidad',
                                                                            handler:function()
                                                                            		{
                                                                                    	var fila=tblGrid.getSelectionModel().getSelected();
                                                                                        if(fila==null)
                                                                                        {
                                                                                        	msgBox('Debe seleccionar la entidad que desea remover');
                                                                                        	return;
                                                                                        }
                                                                                        
                                                                                        function resp(btn)
                                                                                        {
                                                                                        	if(btn=='yes')
                                                                                            {
                                                                                            	tblGrid.getStore().remove(fila);  
                                                                                            }
                                                                                        }
                                                                                        msgConfirm('Est&aacute; seguro de querer remover la entidad seleccionada?',resp);
                                                                                    }
                                                                            
                                                                        }
                                                                        
                                                            		]
                                                        }
                                                    );
	return 	tblGrid;	
}

function mostrarVentanaSelTipoEntidad()
{
	var arrTipoEntidad=[['2','Instituci\xF3n / Centro de Trabajo',0,0,arrCriterioCombina],['3','Empleado',0,0,arrCriterioCombina],['4','Puesto',0,0,arrCriterioCombina],['5','Tipo contrataci\xF3n',0,0,arrCriterioCombina]];//,['7','Instituciones hijas',0,0,arrCriterioCombina]
    
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
                titulo='Agregar Instituci&oacute;n / Centro de Trabajo';
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
	gE('cBusquedaP').value='3';
	
	
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
                                                                                        checked:true,
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
                                                                                                                {name: 'idRegistro'},
                                                                                                                {name: 'lblCriterio'},
                                                                                                                {name: 'idCriterio'}
                                                                                                            ])
                                                                        if(obtenerPosFila(gridEntidad.getStore(),'idRegistro','3_'+gE('idEmpleado').value)==-1)
                                                                        {
                                                                            r=new registroGridEntidad(
                                                                                                        {
                                                                                                            tEntidad:'3',
                                                                                                            entidad:comboPapa.getRawValue(),
                                                                                                            codigoEntidad:gE('idEmpleado').value,
                                                                                                            idRegistro:'3_'+gE('idEmpleado').value,
                                                                                                            lblCriterio:'',
                                                                                                            idCriterio:''
                                                                                                            
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
        dSet.baseParams.listRoles="'1000_0'";
       
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

function removerArchivoImportacion(iN)
{
	var pos=obtenerPosFila(gEx('gridNominas').getStore(),'idNomina',bD(iN));
	var fila=gEx('gridNominas').getStore().getAt(pos);
    
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
                    fila.set('archivoImportacion','');
                    fila.set('idArchivoImportacion','');
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesEspecialesNomina.php',funcAjax, 'POST','funcion=56&iN='+bD(iN),true);
        }
    }
    msgConfirm('Est&aacute; seguro de querer remover el archivo de importaci&oacute;n de la n&oacute;mina: <b>'+fila.data.folio+'</b>, '+formatearValorRenderer(arrInstituciones,fila.data.plantel),resp);
}
