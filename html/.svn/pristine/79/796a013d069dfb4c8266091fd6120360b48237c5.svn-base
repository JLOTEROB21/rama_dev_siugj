<?php  	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	$idNomina=bD($_GET["iN"]);
	
	
	$consulta="select id_650_zonas,NombreZona from 650_zonas order by NombreZona";
	$arrZonas=$con->obtenerFilasArreglo($consulta);
	
	$arrTipoContrata="";
	$arrPuestos="";
	$arrOrganigrama="";
	$rendererPuesto="";
	$consulta="SELECT tipoNomina,institucion,idPerfil,etapa,idUsuarioCreacion,idCentroCosto FROM 672_nominasEjecutadas WHERE idNomina=".$idNomina;
	$fNomina=$con->obtenerPrimeraFila($consulta);
	$tipoNomina=$fNomina[0];
	$institucion=$fNomina[1];
	switch($tipoNomina)
	{
		case 2:
			$consulta="SELECT idRegimen,descripcion FROM 683_regimenContratacionSAT  ORDER BY idRegimen";
			$arrTipoContrata=$con->obtenerFilasArreglo($consulta);
			//$consulta="SELECT cvePuesto,puesto FROM 819_puestosOrganigrama WHERE codigoUnidad='".$_SESSION["codigoInstitucion"]."' order by puesto";
			$consulta="SELECT idPuesto,puesto,cvePuesto FROM 692_puestosNominaV2 WHERE idEmpresa=".$institucion." ORDER BY idPuesto";
			$arrPuestos=$con->obtenerFilasArreglo($consulta);
			//$consulta="select codigoUnidad,concat('[',replace(codigoDepto,'.',''),'] ',unidad) as unidad  from 817_organigrama where codigoInstitucion='".$_SESSION["codigoInstitucion"]."' ";
			$consulta="SELECT idDepartamento,nombreDepartamento FROM 691_departamentosNominaV2 WHERE idEmpresa=".$institucion." order by idDepartamento";
			$arrOrganigrama=$con->obtenerFilasArreglo($consulta);
			
			$rendererPuesto=",renderer:function(val,meta,registro)
										{
											var pos=existeValorMatriz(arrPuestos,val);
											if(pos!=-1)
											{
												return 	arrPuestos[pos][2];
											}
										}
							";
		break;
		default:
			$consulta="SELECT id__669_tablaDinamica,txtTipoContratacion FROM _669_tablaDinamica ORDER BY txtTipoContratacion";
			$arrTipoContrata=$con->obtenerFilasArreglo($consulta);
			//$consulta="SELECT cvePuesto,puesto FROM 819_puestosOrganigrama WHERE codigoUnidad='".$_SESSION["codigoInstitucion"]."' order by puesto";
			$consulta="SELECT cvePuesto,puesto FROM 819_puestosOrganigrama order by puesto";
			$arrPuestos=$con->obtenerFilasArreglo($consulta);
			//$consulta="select codigoUnidad,concat('[',replace(codigoDepto,'.',''),'] ',unidad) as unidad  from 817_organigrama where codigoInstitucion='".$_SESSION["codigoInstitucion"]."' ";
			$consulta="select codigoUnidad,concat('[',replace(codigoDepto,'.',''),'] ',unidad) as unidad  from 817_organigrama";
			$arrOrganigrama=$con->obtenerFilasArreglo($consulta);
			$rendererPuesto=",renderer:function(val,meta,registro)
										{
											if(val!='-1')
												return val;
										}
							";
		break;
	}
	
	
	$consulta="SELECT idActorEtapaNomina FROM 662_actoresEtapaNomina WHERE actor IN(".$_SESSION["idRol"].") AND idPerfil=".$fNomina[2]." AND etapa='".$fNomina[3]."'";
	
	$listActores=$con->obtenerListaValores($consulta);
	if($listActores=="")
		$listActores=-1;
	
	
	
	$pCancelarInd="false";
	$pCancelarIndividual=false;
	
	$consulta="SELECT configuracion FROM 662_accionesActorEtapaNomina WHERE idActorEtapa IN (".$listActores.") AND accion=5";
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$conf=$fila[0];
		if($conf!="")
		{
			$oConf=json_decode($conf);	
			if(cumpleAmbitoAplicacion($oConf,$fNomina))
			{
				$pCancelarIndividual=true;
				$pCancelarInd="true";
				break;	
			}
			
		}
	}
	
	$pIgnorarIndividual="false";
	$consulta="SELECT configuracion FROM 662_accionesActorEtapaNomina WHERE idActorEtapa IN (".$listActores.") AND accion=9";
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$conf=$fila[0];
		if($conf!="")
		{
			$oConf=json_decode($conf);	
			if(cumpleAmbitoAplicacion($oConf,$fNomina))
			{
				$pIgnorarIndividual="true";
				break;	
			}
			
		}
	}
	
	
	
	$consulta="SELECT idSituacion,descripcion,imagen FROM 712_situacionComprobantesFiscales";
	$arrSituacionComprobante=$con->obtenerFilasArreglo($consulta);
	
	
	
	
	$pCambioFechaPagoIndividual="false";
	$consulta="SELECT configuracion FROM 662_accionesActorEtapaNomina WHERE idActorEtapa IN (".$listActores.") AND accion=8";
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$conf=$fila[0];
		if($conf!="")
		{
			$oConf=json_decode($conf);	
			if(cumpleAmbitoAplicacion($oConf,$fNomina))
			{
				$pCambioFechaPagoIndividual="true";
				break;	
			}
			
		}
	}
	
	function cumpleAmbitoAplicacion($objConf,$fNomina)
	{
		switch($objConf->ambitoAccion)
		{
			case 1:	//Generadas por el usuario
				if($fNomina[4]==$_SESSION["idUsr"])
					return true;
			
			break;
			case 2://Pertenecientes a la instituci\xF3n del usuario
				if($fNomina[1]==$_SESSION["codigoInstitucion"])
					return true;
			break;
			case 3://Pertenecientes a la instituci\xF3n y subinstituciones del usuario
			
				$consulta="SELECT codigoUnidad FROM 817_organigrama WHERE codigoUnidad LIKE '".$_SESSION["codigoInstitucion"]."%' AND institucion=1";
				$res=$con->obtenerFilas($conulta);
				while($fila[0]=mysql_fetch_row($res))
				{
					if($fNomina[1]==$fila[0])
						return true;
				}
			break;
			case 4://Pertenecientes a instituciones especificadas
				$arrInstituciones=explode(",",$objConf->arrInstituciones);
				foreach($arrInstituciones as $i)
				{
					if($i==$fNomina[1])	
						return true;
				}
			break;
			case 5: //Todas
				return true;
			break;
			case 7:	//Pertenecientes al centro de costo del usuario
				/*if($fNomina[5]==$_SESSION["idUsr"])
					return true;*/
			break;
				
		}
		return false;
	}



	$consulta="SELECT idFormaPago,formaPago FROM 710_metodoPagoNomina";
	$arrMetodoPago=$con->obtenerFilasArreglo($consulta);	
?>

var arrMetodoPago=<?php echo $arrMetodoPago ?>;
var pIgnorarIndividual=<?php echo $pIgnorarIndividual?>;
var pCancelarIndividual=<?php echo $pCancelarInd?>;
var pCambioFechaPagoIndividual=<?php echo $pCambioFechaPagoIndividual?>;
var idAsientoSeleccionado=-1;
var arrSituacionComprobante=<?php echo $arrSituacionComprobante?>;
var arrZonas=<?php echo $arrZonas?>;
var arrTipoContrata=<?php echo $arrTipoContrata?>;
var arrPuestos=<?php echo $arrPuestos?>;
var arrOrganigrama=<?php echo $arrOrganigrama?>;
var arrDictamenes=[];
var arrEtapa=[];
var arrUnidadAgrupadora=[];
var ocultarDictamenNomina=true;
var idUnidadAGrupadora=0;
var detenerOperacion=false;
var timer;
var totalRepeticiones=0;

Ext.onReady(inicializar);

function verDesgloce(tipo,g,i,iU)
{
	var arrParam=[['g',g],['i',i],['idUsuario',iU],['tipo',tipo]];
	window.open('',"vAuxiliar", "toolbar=no,directories=no,menubar=no,status=no,scrollbars=yes,fullscreen=yes");
    enviarFormularioDatosV('../nomina/verDesgloceCalculo.php',arrParam,'POST','vAuxiliar');
}

function inicializar()
{
	var cmbMetodoPago=crearComboExt('cmbMetodoPago',arrMetodoPago);
	idUnidadAGrupadora=gE('idUnidadAGrupadora').value;
    var ocultarUnidadAgrupadora=true;
    var campoAgrupador='codigoDepto';
    if(idUnidadAGrupadora!='0')
    {
    	ocultarUnidadAgrupadora=false;
        campoAgrupador='idUnidadAgrupadora';
    }

	arrUnidadAgrupadora=eval(bD(gE('arrUnidadesAgrupadoras').value));
    
	arrEtapa=eval(bD(gE('arrEtapa').value));
	arrDictamenes=eval(bD(gE('arrDictamenes').value));
    if(arrDictamenes.length>0)
    {
    	ocultarDictamenNomina=false;
    }
    
    
    var checkColumn = new Ext.grid.CheckColumn	(
	 												{
													   header: 'Ignorar para timbrado',
													   dataIndex: 'ignorarTimbrado',
													   width: 120,
                                                       hidden:!pIgnorarIndividual
                                                      
													}
												);
    
    
	 var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name: 'puesto'},
                                                        {name: 'tipoPuesto'},
                                                        {name: 'zona'},
                                                        {name: 'titular'},
                                                        {name: 'totalDeducciones'},
                                                        {name: 'totalPercepciones'},
                                                        {name: 'sueldoNeto'},
                                                        {name: 'codigoDepto'},
                                                        {name: 'idUsuario'},
                                                        {name: 'sueldoCompactado'},
                                                        {name: 'tipoPago'},
                                                        {name: 'situacion'},
                                                        {name: 'horasTrabajador'},
                                                        {name: 'idUnidadAgrupadora'},
                                                        {name: 'identificador'},
                                                        {name: 'descriptorIdentificador'},
                                                        {name: 'idComprobante'},
                                                        {name: 'situacionComprobante'},
                                                        {name: 'comentarios'},
                                                        {name: 'idAsientoNomina'},
                                                        {name: 'fechaPago', type:'date', dateFormat:'Y-m-d'},
                                                        {name: 'ignorarTimbrado'},
                                                        {name: 'metodoPago'}
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
                                                            sortInfo: {field: 'titular', direction: 'ASC'},
                                                            groupField: campoAgrupador,
                                                            autoLoad:true
                                                        })  
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion=7;
                                        proxy.baseParams.idNomina=gE('idNomina').value;
                                        
                                    }
                        );                                                        
                        
	alDatos.on('load',function(proxy)
    								{
                                    	var x;
                                        var fila;
                                        var enc=false;
                                        for(x=0;x<gEx('gNomina').getStore().getCount();x++)
                                        {
                                        	fila=gEx('gNomina').getStore().getAt(x);
                                            if(fila.data.situacionComprobante=='2')
                                            {
                                            	enc=true;
                                                break;
                                            }
                                        }
                                        
                                    	if(enc)
                                        {
                                        	gEx('btnDescargarXML').show();
                                        }
                                        else
                                        	gEx('btnDescargarXML').hide();
                                    
                                    	
                                    }
                        );                                                        
                                                
    var summary = new Ext.ux.grid.HybridSummary();
	var chkRow=new Ext.grid.CheckboxSelectionModel({singleSelect:true});      
    chkRow.on('rowselect',function(sm,nFila,registro)
    						{
                            	idAsientoSeleccionado=registro.data.idAsientoNomina;
                                gEx('btnCancelarTimbrado').hide();
                                switch(registro.data.situacionComprobante)
                                {
                                	
                                	case '1':
                                    	
                                    	if(registro.data.idComprobante!='')
                                        {
                                        	gEx('btnReCrearXML').show();
                                        	gEx('btnReintentarT').hide();
                                        }
                                    break;
                                    case '2':
                                    	gEx('btnReCrearXML').hide();
	                                	gEx('btnReintentarT').hide();
                                        <?php
										if($pCancelarIndividual)
										{
										?>
                                        if(gEx('btnCancelarTimbrado'))
	                                        gEx('btnCancelarTimbrado').show();
                                         <?php
										}
										 ?>
                                    break;
                                    case '3':
                                    	gEx('btnReCrearXML').show();
                                    break;
                                    case '5':
                                    	gEx('btnReCrearXML').show();
                                    break;
                                    default:
                                    	gEx('btnReCrearXML').hide();
	                                	gEx('btnReintentarT').hide();
                                    break;
                                }
                                
                            	
                            }
    		)       
            
	chkRow.on('rowdeselect',function(sm,nFila,registro)
    						{
                            	idAsientoSeleccionado=-1;
                               	gEx('btnReintentarT').hide();
                                gEx('btnReCrearXML').hide();
                                if(gEx('btnCancelarTimbrado'))
                                	gEx('btnCancelarTimbrado').hide();
                            }
    		) 
            

	var expander = new Ext.ux.grid.RowExpander({
                                                column:2,
                                                tpl : new Ext.Template(
                                                    '<br /><span class=""><b>Comentarios:</b> {comentarios}</span><br /><br />'
                                                )
                                            });
                                                        
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer({width:35}),
                                                        chkRow,
                                                        expander,
                                                        {
															header:'',
															width:70,
															sortable:true,
															dataIndex:'idComprobante',
                                                            renderer:formatearRecibo
														},
                                                         {
                                                        	header:'Situaci&oacute;n',
															width:170,
															sortable:true,
															dataIndex:'situacionComprobante',
                                                            renderer:formatearSituacionComprobante
                                                        },
														{
															header:'Cve. Puesto',
															width:70,
															sortable:true,
															dataIndex:'puesto'
                                                            <?php
																echo $rendererPuesto;
															?>
														},
                                                        {
															header:'Puesto',
															width:150,
															sortable:true,
															renderer:function(val,meta,registro)
                                                            		{
                                                                    	
                                                                    	return formatearValorRenderer(arrPuestos,registro.get('puesto'));
                                                                    }
														},
                                                        {
															header:'Departamento',
															width:200,
															sortable:true,
                                                            dataIndex:'codigoDepto',
															renderer:function(val,meta,registro)
                                                            		{
                                                                    	return formatearValorRenderer(arrOrganigrama,val);
                                                                    }
														},
														{
															header:'Tipo contrataci&oacute;n',
															width:150,
															sortable:true,
															dataIndex:'tipoPuesto',
                                                            renderer:function(val)
                                                            		{
                                                                    	return formatearValorRenderer(arrTipoContrata,val);
                                                                    }
														},
                                                        {
															header:'Zona',
															width:80,
															sortable:true,
															dataIndex:'zona',
                                                            hidden:true,
                                                            renderer:function(val)
                                                            		{
                                                                    	return formatearValorRenderer(arrZonas,val);
                                                                    }
														}
                                                         ,
                                                        {
															header:'Cve. empleado',
															width:90,
															sortable:true,
															dataIndex:'idUsuario',
                                                            renderer:function(val)
                                                            		{
                                                                    	return Math.abs(val);
                                                                    }
														}
                                                        ,
                                                        {
															header:'Nombre empleado',
															width:250,
															sortable:true,
															dataIndex:'titular',
                                                            renderer:function(val,meta,registro)
                                                            		{
                                                                    	if(parseFloat(registro.data.idUsuario)<0)
                                                                        {
                                                                        	return '<span style="color:#F00">Empleado NO registrado en sistema</span>';
                                                                        }
                                                                        else
                                                                        	return val;
                                                                    }
														},
                                                        {
															header:'',
															width:150,
															sortable:true,
															dataIndex:'descriptorIdentificador'
														},
                                                        {
															header:'Horas trabajador',
															width:100,
															sortable:true,
                                                            hidden:true,
															dataIndex:'horasTrabajador'
														},
                                                        {
                                                        	header:'Tipo pago',
															width:120,
															sortable:true,
															dataIndex:'tipoPago',
                                                            hidden:true
                                                        },
                                                        {
															header:'Sueldo compactado',
															width:120,
															sortable:true,
                                                             hidden:true,
                                                             css:'text-align:right;',
															dataIndex:'sueldoCompactado',
                                                            renderer:'usMoney'
														},
                                                       
                                                        {
															header:'Total percepciones',
															width:120,
															sortable:true,
                                                             css:'text-align:right;',
															dataIndex:'totalPercepciones',
                                                            renderer:function(val,meta,registro)
                                                            		{
																		if((registro.data.idUsuario==undefined)||(val==0))
																			return Ext.util.Format.usMoney(val);
                                                                        else
                                                                        	return '<a href="javascript:verDetalle(\''+bE(1)+'\',\''+bE(Math.abs(registro.data.idUsuario))+'\',\''+bE(registro.data.codigoDepto)+'\',\''+bE(registro.data.idUnidadAgrupadora)+'\',\''+bE(registro.data.identificador)+'\')">'+Ext.util.Format.usMoney(val)+"</a>";
                                                                    },
                                                            summaryType:'sum'
														},
                                                        {
															header:'Total deducciones',
															width:120,
															sortable:true,
                                                             css:'text-align:right;',
															dataIndex:'totalDeducciones',
                                                            renderer:function(val,meta,registro)
                                                            		{
                                                                    	if((registro.data.idUsuario==undefined)||(val==0))
                                                                        	return Ext.util.Format.usMoney(val);
                                                                        else
                                                                        	return '<a href="javascript:verDetalle(\''+bE(-1)+'\',\''+bE(Math.abs(registro.data.idUsuario))+'\',\''+bE(registro.data.codigoDepto)+'\',\''+bE(registro.data.idUnidadAgrupadora)+'\',\''+bE(registro.data.identificador)+'\')">'+Ext.util.Format.usMoney(val)+"</a>";
                                                                    },
                                                            summaryType:'sum'
														},
                                                        {
															header:'Sueldo neto',
															width:120,
															sortable:true,
                                                             css:'text-align:right;',
															dataIndex:'sueldoNeto',
                                                            renderer:'usMoney',
                                                            summaryType:'sum'
														},
                                                        {
															header:'',
															width:120,
                                                            hidden:ocultarUnidadAgrupadora,
															sortable:true,
															dataIndex:'idUnidadAgrupadora',
                                                            renderer:function(val)
                                                            		{
                                                                    	return Ext.util.Format.ellipsis(formatearValorRenderer(arrUnidadAgrupadora,val),160);
                                                                    }
                                                            
														},
                                                        {
															header:'Fecha de pago',
															width:120,
															sortable:true,
															dataIndex:'fechaPago',
                                                            editor:	{
                                                            			xtype:'datefield'
                                                                        
                                                            		},
                                                            renderer:function(val)
                                                            		{
                                                                    	if(val)
	                                                                    	return val.format('d/m/Y');
                                                                    }
														},
                                                        checkColumn,
                                                        {
															header:'M&eacute;todo de pago',
															width:220,
															sortable:true,
															dataIndex:'metodoPago',
                                                            editor:cmbMetodoPago,
                                                            renderer:function(val)
                                                            		{
                                                                    	return formatearValorRenderer(arrMetodoPago,val);
                                                                    }
														}
													]
												);
	
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gNomina',
                                                            store:alDatos,
                                                            frame:false,
                                                            cm: cModelo,
                                                            height:500,
                                                            width:940,
                                                            loadMask:true,
                                                            stripeRows :true,
                                                            columnLines : true,
                                                            sm:chkRow,
                                                            renderTo:'tblNomina',
                                                            clicksToEdit:1,
                                                            plugins:[checkColumn,expander,summary],
                                                            tbar:	[
                                                            			{
                                                                            text :'Documentos de n&oacute;mina',
                                                                            cls:'x-btn-text-icon',
                                                                            icon:'../images/icon_documents.gif',
                                                                            menu:	[
                                                                                        {
                                                                                            icon:'../images/vcard.png',
                                                                                            cls:'x-btn-text-icon',
                                                                                            text:'Generar tal&oacute;n de pago individual',
                                                                                            handler:function()
                                                                                                    {
                                                                                                        var idNomina=gE('idNomina').value;
                                                                                                        var fila=tblGrid.getSelectionModel().getSelected();
                                                                                                        if(fila==null)
                                                                                                        {
                                                                                                            msgBox('Debe seleccionar el empleado cuyo tal&oacute;n de pago desea obtener');
                                                                                                            return;
                                                                                                        }
                                                                                                        
                                                                                                        var idUsuario=fila.get('idUsuario');
                                                                                                        var arrParam=[['identificador',fila.get('identificador')],['idNomina',idNomina],['idUsuario',idUsuario],['codigoUnidad',fila.get('codigoDepto')]];
                                                                                                        enviarFormularioDatos('../reportes/generarTalonPago.php',arrParam);
                                                                                                    }
                                                                                            
                                                                                        },'-',
                                                                                        {
                                                                                            icon:'../images/page_excel.png',
                                                                                            cls:'x-btn-text-icon',
                                                                                            text:'Exportar n&oacute;mina a Excel',
                                                                                            handler:function()
                                                                                                    {
                                                                                                        var idNomina=gE('idNomina').value;
                                                                                                        var arrParam=[['idNomina',idNomina]];
                                                                                                        enviarFormularioDatos('../reportes/generarReporteNomina.php',arrParam);
                                                                                                    }
                                                                                            
                                                                                        }
		                                                                                        
                                                                        			]
                                                                        }                
                                                                        ,'-',
                                                                        {
                                                                        	icon:'../images/page_accept.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Ejecutar acci&oacute;n',
                                                                            hidden:ocultarDictamenNomina,

                                                                            handler:function()
                                                                            		{
                                                                                    	mostrarVentanaDictamenNomina();
                                                                                    }
                                                                            
                                                                        },
                                                                        '-',
                                                                        {
                                                                        	icon:'../images/Icono_txt.gif',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Historial de n&oacute;mina',
                                                                            handler:function()
                                                                            		{
                                                                                    	mostrarVentanaHistorialNomina();
                                                                                    }
                                                                            
                                                                        },
                                                                        '-',
                                                                        {
                                                                        	icon:'../images/icon_changelog.gif',
                                                                            cls:'x-btn-text-icon',
                                                                            id:'btnReCrearXML',
                                                                            hidden:true,
                                                                            text:'Volver a Generar XML',
                                                                            listeners:	{
                                                                                            click:function()
                                                                                                    {
                                                                                                        function resp(btn)
                                                                                                        {
                                                                                                            if(btn=='yes')
                                                                                                            {
                                                                                                                
                                                                                                                var fila=tblGrid.getSelectionModel().getSelected();
                                                                                                                
                                                                                                                recrearXMLNomina(fila);
                                                                                                            }
                                                                                                        }
                                                                                                        msgConfirm('Est&aacute; seguro de querer generar el XML del elemento seleccionado?',resp);
                                                                                                    }
                                                                            			}
                                                                        },
                                                                         '-',
                                                                        {
                                                                        	icon:'../images/arrow_refresh.PNG',
                                                                            cls:'x-btn-text-icon',
                                                                            id:'btnReintentarT',
                                                                            hidden:true,
                                                                            text:'Reintentar timbrado',
                                                                            handler:function()
                                                                            		{
                                                                                    
                                                                                    	function resp(btn)
                                                                                    	{
                                                                                        	if(btn=='yes')
                                                                                            {
                                                                                            	mostrarMensajeProcesando();
                                                                                                var fila=tblGrid.getSelectionModel().getSelected();
                                                                                                function funcAjax()
                                                                                                {
                                                                                                    var resp=peticion_http.responseText;
                                                                                                    arrResp=resp.split('|');
                                                                                                    if(arrResp[0]=='1')
                                                                                                    {
                                                                                                        gEx('btnReCrearXML').hide();
                                                                                                        gEx('btnReintentarT').hide();
                                                                                                        fila.set('idComprobante',arrResp[1]);
                                                                                                        fila.set('situacionComprobante',arrResp[2]);
                                                                                                        fila.set('comentarios',arrResp[3]);
                                                                                                        var pos=obtenerPosFila(tblGrid.getStore(),'idAsientoNomina',fila.data.idAsientoNomina);
                                                                                                        gEx('gNomina').getView().refresh();
                                                                                                        gEx('gNomina').getSelectionModel().fireEvent('rowselect',gEx('gNomina').getSelectionModel(),pos,fila);
                                                                                                        ocultarMensajeProcesando();
                                                                                                    }
                                                                                                    else
                                                                                                    {
                                                                                                    	ocultarMensajeProcesando();
                                                                                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                    }
                                                                                                }
                                                                                                obtenerDatosWeb('../paginasFunciones/funcionesEspecialesNomina.php',funcAjax, 'POST','funcion=35&idAsiento='+fila.data.idAsientoNomina,true);
                                                                                    		}
                                                                                        }
                                                                                        msgConfirm('Est&aacute; seguro de querer reintentar el timbrado del elemento seleccionado?',resp);
                                                                                    }
                                                                            
                                                                        },
                                                                       
                                                                       
                                                                        
                                                                        '-',
                                                                        {
                                                                        	icon:'../images/page_remove.png',
                                                                            cls:'x-btn-text-icon',
                                                                            id:'btnCancelarTimbrado',
                                                                            hidden:true,
                                                                            text:'Cancelar timbrado',
                                                                            handler:function()
                                                                            		{
                                                                                    	function resp(btn)
                                                                                    	{
                                                                                        	if(btn=='yes')
                                                                                            {
                                                                                            	mostrarMensajeProcesando();
                                                                                                var fila=tblGrid.getSelectionModel().getSelected();
                                                                                                function funcAjax()
                                                                                                {
                                                                                                    var resp=peticion_http.responseText;
                                                                                                    arrResp=resp.split('|');
                                                                                                    if(arrResp[0]=='1')
                                                                                                    {
                                                                                                        
                                                                                                        fila.set('idComprobante',arrResp[1]);
                                                                                                        fila.set('situacionComprobante',arrResp[2]);
                                                                                                        var pos=obtenerPosFila(tblGrid.getStore(),'idAsientoNomina',fila.data.idAsientoNomina);
                                                                                                        gEx('gNomina').plugins[1].collapseRow(pos);
                                                                                                        gEx('gNomina').getView().refresh();
                                                                                                        gEx('gNomina').getSelectionModel().fireEvent('rowselect',gEx('gNomina').getSelectionModel(),pos,fila);
                                                                                                        ocultarMensajeProcesando();
                                                                                                    }
                                                                                                    else
                                                                                                    {
                                                                                                    	ocultarMensajeProcesando();
                                                                                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                    }
                                                                                                }
                                                                                                obtenerDatosWeb('../paginasFunciones/funcionesEspecialesNomina.php',funcAjax, 'POST','funcion=44&idAsiento='+fila.data.idAsientoNomina,true);
                                                                                    		}
                                                                                        }
                                                                                        msgConfirm('Est&aacute; seguro de querer cancelar el timbrado del elemento seleccionado?',resp);
                                                                                    }
                                                                            
                                                                        },
                                                                       
                                                                       
                                                                        
                                                                        '-',
                                                                        
                                                                        
                                                                        {
                                                                        	icon:'../images/download.png',
                                                                            cls:'x-btn-text-icon',
                                                                            id:'btnDescargarXML',
                                                                            hidden:false,
                                                                            text:'Descargar XML de empleados',
                                                                            handler:function()
                                                                            		{

                                                                                        var arrParam=[['idNomina',gE('idNomina').value]];
                                                                                    	enviarFormularioDatos('../nomina/descargarComprobantesNomina.php',arrParam);
                                                                                    }
                                                                            
                                                                        }
                                                            		],
                                                            view: new Ext.grid.GroupingView(	{
                                                                                                    forceFit:false,
                                                                                                    showGroupName: true,
                                                                                                    enableNoGroups:false,
                                                                                                    enableGroupingMenu:true,
                                                                                                    hideGroupedColumn: true,
                                                                                                    startCollapsed:false
                                                                                            	}   
                                                                                            ) 
                                                           
                                                        }
                                                    );



	tblGrid.on('beforeedit',function(e)
    						{
                            	switch(e.field)
                                {
                                	case 'metodoPago':
                                        if(e.record.data.situacionComprobante=='2')
                                            e.cancel=true;
                                    break;
                                	case 'fechaPago':
                                    
                                        if((e.record.data.situacionComprobante=='2')||(e.record.data.situacionComprobante=='6')||(!pCambioFechaPagoIndividual))
                                            e.cancel=true;
                                    break;
                                    case 'ignorarTimbrado':
                                    
                                        if((e.record.data.situacionComprobante=='2')||(e.record.data.situacionComprobante=='6')||(!pIgnorarIndividual))
                                            e.cancel=true;
                                    break;
								}                            	
                            }
    			)



	tblGrid.on('afteredit',function(e)
    						{
                            	var campo='';
                                var valor='';
                            	switch(e.field)
                                {
                                	case 'fechaPago':
                                    	campo=1;
                                        valor=e.value.format('Y-m-d');
                                    break;
                                    case 'ignorarTimbrado':
                                       campo=2;
                                       if(e.value)
	                                       valor=1;
                                       else
	                                       	valor=0;
                                    break;
                                    case 'metodoPago':
                                       campo=3;
                                       valor=e.value;
                                    break;
                                
                                }
                            	mostrarMensajeProcesando();
                            	function funcAjax()
                                {
                                    var resp=peticion_http.responseText;
                                    arrResp=resp.split('|');
                                    if(arrResp[0]=='1')
                                    {
                                        ocultarMensajeProcesando();
                                        if(campo==3)
                                        {
                                        	
                                            switch(e.record.data.situacionComprobante)
                                            {
                                            	case '1':
                                                	if(e.record.data.idComprobante!='')
                                                    {
                                                    	recrearXMLNomina(e.record);
                                                    }
                                                break;
                                                case '3':
                                                case '5':
													recrearXMLNomina(e.record);

                                                break;
                                            }
                                            
                                        }
                                    }
                                    else
                                    {
                                    	ocultarMensajeProcesando();
                                    	function resp10()
                                        {
                                        	e.record.set('fechaPago',e.originalValue);
                                       	}
                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0],resp10);
                                        
                                    }
                                }
                                obtenerDatosWeb('../paginasFunciones/funcionesEspecialesNomina.php',funcAjax, 'POST','funcion=46&idAsiento='+e.record.data.idAsientoNomina+'&campo='+campo+'&valor='+valor,true);
                                
                            	
                            }
    			)

	new  Ext.ProgressBar	(
    							{
                                	id:'pbar',
                                    width:430,
                                    height:20,
                                    renderTo:'tAvance'
                                }
    						);
                            
                            
	
    oE('tblAvance');
   
    

}



function verDetalle(tipo,iU,cD,iA,i)
{
	var titulo;
    var nTipo;
    if(bD(tipo)=='1')
    {
    	titulo='Detalle percepciones';
        nTipo=2;
    }
    else
    {
    	titulo='Detalle deducciones';	
        nTipo=1;
    }
	var url='../nomina/verDesgloceCalculo.php?idNomina='+gE('idNomina').value+'&cPagina=sFrm=true&identificador='+bD(i)+'&idAgrupador='+bD(iA)+'&codDepto='+bD(cD)+'&tipo='+nTipo+'&idUsuario='+bD(iU)+'&ciclo='+gE('ciclo').value+'&quincena='+gE('quincena').value+'&idPerfil='+gE('idPerfil').value;
	
    $.fancybox({
    			'href'				: url,
				'title'    			: titulo,			
				'width'				: 800,
				'height'			: 440,
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe',
                'modal':false
			});	

}

function mostrarVentanaDictamenNomina()
{
	var cmbDictamen=crearComboExt('cmbDictamen',arrDictamenes,230,5,300);
    if(arrDictamenes.length==1)
    	cmbDictamen.setValue(arrDictamenes[0][0]);
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
                                                            html:'Indique el dict&aacute;men sobre esta n&oacute;mina:'
                                                        },
                                                        cmbDictamen,
                                                        {
                                                        	xtype:'label',
                                                            x:10,
                                                            y:40,
                                                            html:'Comentarios:'
                                                            
                                                        },
                                                        {
                                                        	x:10,
                                                            y:70,
                                                            xtype:'textarea',
                                                            width:550,
                                                            height:80,
                                                            id:'txtComentarios'
                                                        }

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Dictaminar n&oacute;mina',
										width: 600,
										height:250,
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
																		if(cmbDictamen.getValue()=='')
                                                                        {
                                                                        	msgBox('Debe indicar el dict&aacute;men a aplicar a esta n&oacute;mina');
                                                                        	return;
                                                                        }
                                                                        var nEtapa;
                                                                        var pos=existeValorMatriz(arrDictamenes,cmbDictamen.getValue());
                                                                        nEtapa=arrDictamenes[pos][2];
                                                                        funcionEjecucion=arrDictamenes[pos][3];
                                                                        var comentarios=gEx('txtComentarios').getValue();
                                                                        if(comentarios=='')
	                                                                        comentarios='Sin comentarios';
                                                                        function resp(btn)
                                                                        {
                                                                            if(btn=='yes')
                                                                            {
                                                                        
                                                                                if(funcionEjecucion=='')
                                                                                {
                                                                                    function funcAjax()
                                                                                    {
                                                                                        var resp=peticion_http.responseText;
                                                                                        arrResp=resp.split('|');
                                                                                        if(arrResp[0]=='1')
                                                                                        {
                                                                                            gE('frmRecargarPagina').submit();
                                                                                        }
                                                                                        else
                                                                                        {
                                                                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                        }
                                                                                    }
                                                                                    obtenerDatosWeb('../paginasFunciones/funcionesEspecialesNomina.php',funcAjax, 'POST','funcion=21&idNomina='+gE('idNomina').value+'&nEtapa='+nEtapa+'&comentarios='+cv(comentarios),true);
                                                                                    
                                                                                
                                                                                }
                                                                                else
                                                                                {
                                                                                    eval(funcionEjecucion+"(gE('idNomina').value,nEtapa,comentarios);");
                                                                                    ventanaAM.close();
                                                                                
                                                                                }
                                                                           	}
                                                                      	}
                                                                      	msgConfirm('Est&aacute; seguro de querer dictaminar esta n&oacute;mina?',resp);
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

function mostrarVentanaHistorialNomina()
{
	var gridComentarios=crearGridComentarios();
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'anchor',
											defaultType: 'label',
											items: 	[
														gridComentarios
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Historial de n&oacute;mina',
										width: 890,
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

function crearGridComentarios()
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                            			{name: 'idHistorialNomina', type:'int'},
                                            			{name:'fechaCambioEtapa', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name: 'responsableCambio'},
                                                        {name: 'etapaAnterior'},
                                                        {name: 'etapaCambio'},
                                                        {name: 'comentarios'}
                                                        
                                                        
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
                                                            sortInfo: {field: 'fechaCambioEtapa', direction: 'DESC'},
                                                            groupField: 'fechaCambioEtapa',
                                                            remoteGroup:false,
				                                            remoteSort: true,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='27';
                                        proxy.baseParams.idNomina=gE('idNomina').value;
                                        
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer(),
                                                            {
                                                                header:'Fecha de operaci&oacute;n',
                                                                width:125,
                                                                sortable:true,
                                                                dataIndex:'fechaCambioEtapa',
                                                                renderer:formatearfechaColor
                                                            },
                                                            {
                                                                header:'Etapa anterior',
                                                                width:220,
                                                                sortable:true,
                                                                dataIndex:'etapaAnterior',
                                                                renderer:formatearEtapa,
                                                                
                                                            },
                                                            {
                                                                header:'Etapa cambio',
                                                                width:220,
                                                                sortable:true,
                                                                dataIndex:'etapaCambio',
                                                                renderer:formatearEtapa
                                                            },
                                                             {
                                                                header:'Responsable de operaci&oacute;n',
                                                                width:220,
                                                                sortable:true,
                                                                dataIndex:'responsableCambio'
                                                            }
                                                             
                                                           
                                                            
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gridComentarios',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:true,
                                                                cm: cModelo,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                columnLines : true,
                                                                anchor:'100% 100%',
                                                                viewConfig: {
                                                                            forceFit:false,
                                                                            enableRowBody:true,
                                                                            getRowClass : formatearFila
                                                                        }
                                                            }
                                                        );
        return 	tblGrid;	
}

function formatearFila(record, rowIndex, p, ds) 
{
	var xf = Ext.util.Format;
    var comp='';
    if(record.data.comentarios=='')
    	record.data.comentarios='Sin comentarios';
    p.body = '<br /><p style="margin-left: 10em;margin-right: 3em;text-align:left"><span class="copyrigthSinPaddingNegro"><table>'+
    		'<tr height="21"><td width="20"></td><td><span class="letraRojaSubrayada8">Comentarios: </span></td><td align="justify"  ><span class="copyrigthSinPaddingNegro">'+record.data.comentarios+'</span></td></tr></table></span></p>';
    return 'x-grid3-row-expanded'+comp;
}




function formatearfechaColor(value, p, record)
{
	return '<span class="letraRojaSubrayada8">'+formatearfecha(value, p, record)+'</span>';
}

function formatearEtapa(val)
{
	var x;
    var etapa='';
    for(x=0;x<arrEtapa.length;x++)
    {
    	if(parseFloat(arrEtapa[x][0])==parseFloat(val))
        {
        	etapa=removerCerosDerecha(arrEtapa[x][0])+'.- '+arrEtapa[x][1]; 
        }
    }
    return etapa;
}



function formatearSituacionComprobante(val,meta,registro)
{
	var pos=existeValorMatriz(arrSituacionComprobante,val);
    if(pos!=-1)
    {
    	var comentarios='';
        if(val=='5')
        	comentarios=registro.data.comentarios;
        var reg=arrSituacionComprobante[pos];
        return '<span title="'+comentarios+'" alt="'+comentarios+'"><img src="'+arrSituacionComprobante[pos][2]+'" width="14" height="14" > '+arrSituacionComprobante[pos][1]+'</span>';
    }
}


function formatearRecibo(val,meta,registro)
{
	var comp='';
    var comp2='';
    
    
    if(parseFloat(registro.data.idUsuario)<0)
    {
    	return '<img src="../images/user_remove.png" width="14" height="14"  title="El empleado NO se encuentra registrado en sistema" alt="El empleado NO se encuentra registrado en sistema">';
    }
    else
    {
        if((registro.data.idComprobante!='')&&(registro.data.situacionComprobante!='')&&(registro.data.situacionComprobante!='3')&&(registro.data.situacionComprobante!='5'))
        {
            comp='<a href="../paginasFunciones/obtenerXMLComprobante.php?iC='+bE(val)+'"><img src="../images/Icono_xml.gif" title="Obtener XML del CFDI" alt="Obtener XML del CFDI" width="16" height="16"></a> ';
        }
        if((registro.data.idComprobante!='')&&(registro.data.situacionComprobante!='3')&&(registro.data.situacionComprobante!='')&&(registro.data.situacionComprobante!='5'))
        {
            comp2='<a href="javascript:mostrarReciboNomina(\''+bE(val)+'\')"><img src="../images/vcard.png" width="16" height="16" title="Ver recibo de n&oacute;mina" alt="Ver recibo de n&oacute;mina"></a>';
        }
        return comp+comp2;
   }
}

function mostrarReciboNomina(iE)
{
	var obj={};
    obj.titulo='Recibo de N&oacute;mina';
    obj.ancho=900;
    obj.alto=450;
    obj.params=[['iC',iE],['cPagina','sFrm=true']];
    obj.url='../formatosFacturasElectronicas/vistaPreviaReciboNomina.php';
    if(window.parent)
    	window.parent.abrirVentanaFancy(obj);
    else
    	abrirVentanaFancy(obj);
}	

function setDetenerOperacion()
{
	detenerOperacion=true;
    gE('lblOperacion').innerHTML='Deteniendo...';
}


function recrearXMLNomina(fila)
{
	mostrarMensajeProcesando();
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            gEx('btnReCrearXML').hide();
            gEx('btnReintentarT').hide();
            fila.set('idComprobante',arrResp[1]);
            fila.set('situacionComprobante',arrResp[2]);
            fila.set('comentarios',arrResp[3]);
            fila.set('puesto',arrResp[4]);
            fila.set('tipoPuesto',arrResp[5]);
            var pos=obtenerPosFila(gEx('gNomina').getStore(),'idAsientoNomina',fila.data.idAsientoNomina);
            gEx('gNomina').plugins[1].collapseRow(pos);
            gEx('gNomina').getView().refresh();
            gEx('gNomina').getSelectionModel().fireEvent('rowselect',gEx('gNomina').getSelectionModel(),pos,fila);
            ocultarMensajeProcesando();
        }
        else
        {
            ocultarMensajeProcesando();
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesEspecialesNomina.php',funcAjax, 'POST','funcion=43&idAsiento='+fila.data.idAsientoNomina,true);
}