<?php  	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	$idNomina=bD($_GET["iN"]);
	
	
	$consulta="select id__633_tablaDinamica,nombreZona from _633_tablaDinamica order by NombreZona";
	$arrZonas=$con->obtenerFilasArreglo($consulta);
	
	$arrTipoContrata="";
	$arrPuestos="";
	$arrOrganigrama="";
	$rendererPuesto="";
	$consulta="SELECT tipoNomina,institucion,idPerfil,etapa,idUsuarioCreacion,idCentroCosto,folioNomina,ciclo,quincenaAplicacion FROM 672_nominasEjecutadas WHERE idNomina=".$idNomina;
	$fNomina=$con->obtenerPrimeraFila($consulta);
	$tipoNomina=$fNomina[0];
	$institucion=$fNomina[1];
	$folioNomina=$fNomina[6];
	$ciclo=$fNomina[7];
	$idPerfil=$fNomina[2];
	$quincena=$fNomina[8];
	
	$consulta="SELECT idPeriodicidad FROM 662_perfilesNomina WHERE idPerfilesNomina=".$idPerfil;
	$fPerfilNomina=$con->obtenerPrimeraFila($consulta);
	$consulta="SELECT nombreElemento FROM _642_gElementosPeriodicidad WHERE idReferencia=".$fPerfilNomina[0]." AND noOrdinal=".$quincena;
	$lblPeriodo=$con->obtenerValor($consulta);
	

	$consulta="SELECT id__638_tablaDinamica,tipoContratacion FROM _638_tablaDinamica ORDER BY tipoContratacion";
	$arrTipoContrata=$con->obtenerFilasArreglo($consulta);

	$consulta="SELECT id__632_tablaDinamica,nombrePuesto FROM _632_tablaDinamica order by nombrePuesto";
	$arrPuestos=$con->obtenerFilasArreglo($consulta);
	$consulta="SELECT id__632_tablaDinamica,cvePuesto FROM _632_tablaDinamica order by nombrePuesto";
	$arrCvePuestos=$con->obtenerFilasArreglo($consulta);

	$consulta="select codigoUnidad,concat('[',replace(claveDepartamental,'.',''),'] ',unidad) as unidad  from 817_organigrama";
	$arrOrganigrama=$con->obtenerFilasArreglo($consulta);
	$rendererPuesto=",renderer:function(val,meta,registro)
								{
									if(val!='-1')
										return val;
								}
					";
		
	
	
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
	
	$idEtapaCambioCalculoNomina="0";
	$pCalcularNomina="false";
	$consulta="SELECT configuracion FROM 662_accionesActorEtapaNomina WHERE idActorEtapa IN (".$listActores.") AND accion=2";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$conf=$fila[0];
		if($conf!="")
		{
			$oConf=json_decode($conf);	
			if(cumpleAmbitoAplicacion($oConf,$fNomina))
			{
				if(isset($oConf->etapaCambio))
					$idEtapaCambioCalculoNomina=$oConf->etapaCambio;
				$pCalcularNomina="true";
				break;	
			}
			
		}
	}
	
	$pReCalcularNomina="false";
	$consulta="SELECT configuracion FROM 662_accionesActorEtapaNomina WHERE idActorEtapa IN (".$listActores.") AND accion=10";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$conf=$fila[0];
		if($conf!="")
		{
			$oConf=json_decode($conf);	
			if(cumpleAmbitoAplicacion($oConf,$fNomina))
			{
				$pReCalcularNomina="true";
				break;	
			}
			
		}
	}
	
	$pCalcularNominaIndividual="false";
	$consulta="SELECT configuracion FROM 662_accionesActorEtapaNomina WHERE idActorEtapa IN (".$listActores.") AND accion=11";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$conf=$fila[0];
		if($conf!="")
		{
			$oConf=json_decode($conf);	
			if(cumpleAmbitoAplicacion($oConf,$fNomina))
			{
				$pCalcularNominaIndividual="true";
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



	$consulta="SELECT id__641_tablaDinamica,formaPago FROM _641_tablaDinamica";
	$arrMetodoPago=$con->obtenerFilasArreglo($consulta);	
?>
var arrTipoCalculo=[['1','Deducci&oacute;n'],['2','Percepci&oacute;n'],['0','C&aacute;lculo Auxiliar']];
var idEtapaCambioCalculoNomina=<?php echo $idEtapaCambioCalculoNomina?>;
var pCalcularNominaIndividual=<?php echo $pCalcularNominaIndividual?>;
var arrCvePuestos=<?php echo $arrCvePuestos?>;
var arrMetodoPago=<?php echo $arrMetodoPago ?>;
var pIgnorarIndividual=<?php echo $pIgnorarIndividual?>;
var pCalcularNomina=<?php echo $pCalcularNomina?>;
var pReCalcularNomina=<?php echo $pReCalcularNomina?>;
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
    
    
    var checkColumn2 = new Ext.grid.CheckColumn	(
	 												{
													   header: 'Ignorar al calcular',
													   dataIndex: 'ignorarCalculo',
													   width: 120,
                                                       hidden:!pCalcularNomina && !pReCalcularNomina && !pCalcularNominaIndividual
                                                      
													}
												);
    
	 var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name: 'puesto'},
                                                        {name: 'tipoPuesto'},
                                                        {name: 'titular'},
                                                        {name: 'totalDeducciones'},
                                                        {name: 'totalPercepciones'},
                                                        {name: 'sueldoNeto'},
                                                        {name: 'codigoDepto'},
                                                        {name: 'idUsuario'},
                                                        {name: 'situacion'},
                                                        {name: 'identificador'},
                                                        {name: 'descriptorIdentificador'},
                                                        {name: 'idComprobante'},
                                                        {name: 'situacionComprobante'},
                                                        {name: 'comentarios'},
                                                        {name: 'idAsientoNomina'},
                                                        {name: 'fechaPago', type:'date', dateFormat:'Y-m-d'},
                                                        {name: 'ignorarTimbrado'},
                                                        {name: 'metodoPago'},
                                                        {name: 'idZona'},
                                                        {name: 'ignorarCalculo'}
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
                                    	proxy.baseParams.funcion=100;
                                        proxy.baseParams.idNomina=gE('idNomina').value;
                                        
                                    }
                        );                                                        
                        
	alDatos.on('load',function(proxy)
    								{
                                    	
                                    	gE('lblPlazas').innerHTML=Ext.util.Format.number(proxy.reader.jsonData.infoAdicional.numReg,'0,000');
                                    	gE('lblTPercepciones').innerHTML=Ext.util.Format.usMoney(proxy.reader.jsonData.infoAdicional.tPercepciones);
                                    	gE('lblTDeducciones').innerHTML=Ext.util.Format.usMoney(proxy.reader.jsonData.infoAdicional.tDeducciones);
                                    	gE('lblSNeto').innerHTML=Ext.util.Format.usMoney(proxy.reader.jsonData.infoAdicional.sueldoNeto);
                                    	
                                    
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
	var chkRow=new Ext.grid.CheckboxSelectionModel({singleSelect:false});      
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
													 	new  Ext.grid.RowNumberer({width:50}),
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
															width:250,
															sortable:true,
															dataIndex:'situacionComprobante',
                                                            renderer:formatearSituacionComprobante
                                                        },
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
                                                            hidden:true,
															dataIndex:'descriptorIdentificador'
														},
														{
															header:'Cve. Puesto',
															width:90,
															sortable:true,
															dataIndex:'puesto',
                                                            renderer:function(val,meta,registro)
                                                            		{
                                                                    	
                                                                    	return formatearValorRenderer(arrCvePuestos,registro.get('puesto'));
                                                                    }
                                                           
														},
                                                        {
															header:'Puesto',
															width:250,
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
                                                                        	return '<a href="javascript:verDetalle(\''+bE('P')+'\',\''+bE(Math.abs(registro.data.idUsuario))+'\',\''+bE(registro.data.titular)+'\',\''+bE(registro.data.idAsientoNomina)+'\')">'+Ext.util.Format.usMoney(val)+"</a>";
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
                                                                        	return '<a href="javascript:verDetalle(\''+bE('D')+'\',\''+bE(Math.abs(registro.data.idUsuario))+'\',\''+bE(registro.data.titular)+'\',\''+bE(registro.data.idAsientoNomina)+'\')">'+Ext.util.Format.usMoney(val)+"</a>";
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
                                                            summaryType:'sum',
                                                            renderer:function(val,meta,registro)
                                                            		{
                                                                    	if((registro.data.idUsuario==undefined)||(val==0))
                                                                        	return Ext.util.Format.usMoney(val);
                                                                        else
                                                                        	return '<a href="javascript:verDetalle(\''+bE('T')+'\',\''+bE(Math.abs(registro.data.idUsuario))+'\',\''+bE(registro.data.titular)+'\',\''+bE(registro.data.idAsientoNomina)+'\')">'+Ext.util.Format.usMoney(val)+"</a>";
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
                                                        checkColumn2,
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
                                                            loadMask:true,
                                                            stripeRows :true,
                                                            columnLines : true,
                                                            sm:chkRow,
                                                            region:'center',
                                                            clicksToEdit:1,
                                                            plugins:[checkColumn,expander,summary,checkColumn2],
                                                            tbar:	[
                                                            			{
                                                                        	icon:'../images/salir.gif',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Salir',
                                                                            handler:function()
                                                                            		{
                                                                                    	regresarPagina();
                                                                                    }
                                                                            
                                                                        },'-',
                                                            			{
                                                                        	icon:'../images/user_go.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Calcular N&oacute;mina',
                                                                            hidden:!pCalcularNomina,
                                                                            handler:function()
                                                                            		{
                                                                                    	function resp(btn)
                                                                                        {
                                                                                        	if(btn=='yes')
                                                                                            {
                                                                                            	generarCalculoNominaIndividual(gE('idNomina').value);
                                                                                            }
                                                                                        }
                                                                                        msgConfirm('Est&aacute; seguro de querer calcular la actual n&oacute;mina?',resp);
                                                                                    }
                                                                            
                                                                        },
                                                                        '-',
                                                                        {
                                                                        	icon:'../images/arrow_refresh.PNG',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Recalcular N&oacute;mina',
                                                                            hidden:!pReCalcularNomina,
                                                                            handler:function()
                                                                            		{
                                                                                    	function resp(btn)
                                                                                        {
                                                                                        	if(btn=='yes')
                                                                                            {
                                                                                            	generarReCalculoNominaIndividual(gE('idNomina').value);
                                                                                            }
                                                                                        }
                                                                                        msgConfirm('Est&aacute; seguro de querer calcular de nuevo la actual n&oacute;mina?',resp);
                                                                                    }
                                                                            
                                                                        },
                                                                        '-',
                                                                        {
                                                                        	icon:'../images/users.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Calcular/Recalcular N&oacute;minas Seleccionadas',
                                                                            hidden:!pCalcularNominaIndividual,
                                                                            handler:function()
                                                                            		{
                                                                                    	function resp(btn)
                                                                                        {
                                                                                        	if(btn=='yes')
                                                                                            {
                                                                                            	generarCalculoNominaElementosSeleccionados(gE('idNomina').value);
                                                                                            }
                                                                                        }
                                                                                        msgConfirm('Est&aacute; seguro de querer calcular las n&oacute;minas de los elementos seleccionados? (Se ignorar&aacute;n aquellos elementos marcados como "Ignorar al calcular")',resp);
                                                                                    }
                                                                            
                                                                        },
                                                                        '-',
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
                                                            
                                                            
                                                            /* 
                                                                                            
                                                                   new Ext.ux.grid.BufferView({
                                                                                                rowHeight: 34,
                                                                                                scrollDelay: false
                                                                                            	}
                                                                                              )                         
                                                                   */
                                                           
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
                                    case 'ignorarCalculo':
                                       campo=10;
                                       if(e.value)
	                                       valor=1;
                                       else
	                                       	valor=0;
                                   
                                   		mostrarMensajeProcesando();
                                        function funcAjax()
                                        {
                                            var resp=peticion_http.responseText;
                                            arrResp=resp.split('|');
                                            if(arrResp[0]=='1')
                                            {
                                                ocultarMensajeProcesando();
                                                
                                            }
                                            else
                                            {
                                                ocultarMensajeProcesando();
                                                function resp1010()
                                                {
                                                    e.record.set('ignorarCalculo',e.originalValue);
                                                }
                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0],resp1010);
                                                
                                            }
                                        }
                                        obtenerDatosWeb('../paginasFunciones/funcionesEspecialesNomina.php',funcAjax, 'POST','funcion=101&idUsuario='+e.record.data.idUsuario+'&idNomina='+gE('idNomina').value+'&valor='+valor,true);
                                        
                                   
                                   
                                   		return;
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



	new Ext.Viewport(	{
                                layout: 'border',
                                items: [
                                
                                			{
                                            	xtype:'panel',
                                                region:'center',
                                                layout:'border',
                                                tbar:	[
                                                			{
                                                                xtype:'label',
                                                                html:'<b>Folio de Nomina:</b>&nbsp;&nbsp;<span style="color:#900; font-weight:bold;"><?php echo $folioNomina?></span>'
                                                            },'-',
                                                            {
                                                                xtype:'label',
                                                                html:'<b>Ciclo:</b>&nbsp;&nbsp;<span style="color:#900; font-weight:bold;"><?php echo $ciclo?></span>'
                                                            },'-',
                                                             {
                                                                xtype:'label',
                                                                html:'<b>Periodo:</b>&nbsp;&nbsp;<span style="color:#900; font-weight:bold;"><?php echo $lblPeriodo?></span>'
                                                            },
                                                		],
                                                	
                                                items:	[
                                                			{
                                                                xtype:'panel',
                                                                region:'center',
                                                                layout:'border',
                                                                tbar:	[
                                                                            
                                                                            {
                                                                                xtype:'label',
                                                                                html:'<b># Plazas/Empleados:</b>&nbsp;&nbsp;<span style="color:#900; font-weight: bold" id="lblPlazas"></span>'
                                                                            },'-',
                                                                            {
                                                                                xtype:'label',
                                                                                html:'<b>Total Percenciones:</b>&nbsp;&nbsp;<span style="color:#900; font-weight: bold" id="lblTPercepciones"></span>'
                                                                            },'-',
                                                                            {
                                                                                xtype:'label',
                                                                                html:'<b>Total Deducciones:</b>&nbsp;&nbsp;<span style="color:#900; font-weight: bold" id="lblTDeducciones"></span>'
                                                                            },'-',
                                                                            {
                                                                                xtype:'label',
                                                                                html:'<b>Sueldo Neto:</b>&nbsp;&nbsp;<span style="color:#900; font-weight: bold" id="lblSNeto"></span>'
                                                                            }
                                                                        ],
                                                                items:	[
                                                                            tblGrid
                                                                        ]
                                                            }
                                                            
                                                            
                                                            
                                                		],
                                                bbar:	[
                                                            {
                                                                xtype:'label',
                                                                id:'lblAvance1',
                                                                html:'<b>Realizando operaci&oacute;n:</b>&nbsp;&nbsp;'
                                                            },
                                                            {
                                                                xtype:'label',
                                                                id:'lblAvance2',
                                                                html:'<span  style="color:#900" id="lblOperacion"></span>'
                                                            },'-',
                                                            {
                                                                xtype:'label',
                                                                id:'lblAvance3',
                                                                html:'<b>Avance de la operaci&oacute;n:</b>&nbsp;&nbsp;'
                                                            },
                                                            {
                                                                id:'pbar',
                                                                width:430,
                                                                height:20,
                                                                xtype:'progress'
                                                            },
                                                            {
                                                                xtype:'label',
                                                                id:'lblAvance4',
                                                                html:'&nbsp;&nbsp;<a href="javascript:setDetenerOperacion()"><img src="../images/control_stop_blue.png" title="Detener operaci&oacute;n" alt="Detener operaci&oacute;n" /></a>'
                                                            }
                                                           
                                                        ]
                                            }
                                
                                            
                                         ]
                            }
                        )



	
   
    
	ocultarBarraAvance();
}



function verDetalle(t,iU,nE,iA)
{

	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'border',
											defaultType: 'label',
											items: 	[
                                            			crearGridPercepcionesDeducciones(t,iU,iA)
													]
										}
									);
	
    
    var titulo='';
    switch(bD(t))
    {
    	case 'D':
        	titulo='Deducciones';
        break;
        case 'P':
        	titulo='Percepciones';
        break;
        case 'T':
        	titulo='Sueldo Neto';
        break;
    }
    
	var ventanaAM = new Ext.Window(
									{
										title: '<span style="color:#900; font-weight:bold">'+titulo+'</span> (<span style="color:#000; font-weight:bold">'+bD(nE)+'</span>)',
										width: 800,
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
																		ventanaAM.close();
																	}
														}
													]
									}
								);
	ventanaAM.show();

}

function crearGridPercepcionesDeducciones(t,iU,iA)
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idCalculo'},
                                                        {name: 'cveCalculo'},
		                                                {name: 'nombreCalculo'},
                                                        {name: 'montoCalculado'},
                                                        {name: 'tipoCalculo'}
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
                                                            sortInfo: {field: 'cveCalculo', direction: 'ASC'},
                                                            groupField: 'tipoCalculo',
                                                            remoteGroup:false,
				                                            remoteSort: true,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='107';
                                        proxy.baseParams.tipo=bD(t);
                                        proxy.baseParams.idAsiento=bD(iA);
                                    }
                        )   
        var summary = new Ext.ux.grid.HybridSummary();
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer(),
                                                            {
                                                                header:'',
                                                                width:100,
                                                                sortable:true,
                                                                dataIndex:'tipoCalculo',
                                                                renderer:function(val)
                                                                		{
                                                                        	return formatearValorRenderer(arrTipoCalculo,val);
                                                                        }
                                                            },
                                                            {
                                                                header:'Cve Calculo',
                                                                width:100,
                                                                sortable:true,
                                                                dataIndex:'cveCalculo'
                                                            },
                                                            {
                                                                header:(t=='P'?'Percepci&oacute;n':'Deducci&oacute;n'),
                                                                width:450,
                                                                sortable:true,
                                                                dataIndex:'nombreCalculo',
                                                                renderer:mostrarValorDescripcion
                                                            },
                                                            {
                                                                header:'Monto Calculado',
                                                                width:160,
                                                                align:'right',
                                                                sortable:true,
                                                                summaryType:'sum',
                                                                renderer:'usMoney',
                                                                dataIndex:'montoCalculado'
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gPercepcionesDeducciones',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                cm: cModelo,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                plugins:[summary],
                                                                columnLines : true,                                                                
                                                                view:new Ext.grid.GroupingView({
                                                                                                    forceFit:false,
                                                                                                    showGroupName: false,
                                                                                                    enableGrouping :true,
                                                                                                    enableNoGroups:false,
                                                                                                    enableGroupingMenu:false,
                                                                                                    hideGroupedColumn: true,
                                                                                                    startCollapsed:false
                                                                                                })
                                                            }
                                                        );
        return 	tblGrid;	
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

function generarCalculoNominaIndividual(iN)
{
	var gNomina=gEx('gNomina');    
	arrTimbrar=[];
	gE('lblOperacion').innerHTML='Calculando N&oacute;mina';
    var fila;
	
    for(x=0;x<gNomina.getStore().getCount();x++)
    {
    	fila=gNomina.getStore().getAt(x);
        if((fila.data.situacionComprobante=='7')&&(!fila.data.ignorarCalculo))
        {
        	arrTimbrar.push(fila);
        
        }
    }
    totalProceso=arrTimbrar.length;
    totalProcesados=0;
    mostrarBarraAvance();
    gEx('pbar').updateProgress(0,'Procesando 0/'+totalProceso);
    //gEx('gNomina').disable();
    detenerOperacion=false;

    calcularNominaEmpleado(arrTimbrar,iN,idEtapaCambioCalculoNomina!=0?true:false,idEtapaCambioCalculoNomina);
    calcularTotalesNomina(gNomina.getStore().getCount()-1);
}


function generarCalculoNominaElementosSeleccionados(iN)
{
	var gNomina=gEx('gNomina');    
	arrTimbrar=[];
	gE('lblOperacion').innerHTML='Calculando N&oacute;mina';
    var fila;
	var arrFilas=gNomina.getSelectionModel().getSelections();
    for(x=0;x<arrFilas.length;x++)
    {
    	fila=arrFilas[x];
        if(!fila.data.ignorarCalculo)
        {
        	fila.set('situacionComprobante','7');
            fila.set('totalDeducciones','0');
            fila.set('totalPercepciones','0');
            fila.set('sueldoNeto','0');
        	arrTimbrar.push(fila);
        
        }
    }
    
    if(arrTimbrar.length==0)
    {	
    	msgBox('Debe seleccionar almenos un elemento cuya n&oacute;mina desea calcular (Se ignoran elementos marcados como "Ignorar al calcular")');
    	return;
    }
    
    totalProceso=arrTimbrar.length;
    totalProcesados=0;
    mostrarBarraAvance();
    gEx('pbar').updateProgress(0,'Procesando 0/'+totalProceso);
    //gEx('gNomina').disable();
    detenerOperacion=false;

    calcularNominaEmpleado(arrTimbrar,iN,false,0);
    
    calcularTotalesNomina(gNomina.getStore().getCount()-1);
    
}



function generarReCalculoNominaIndividual(iN)
{
	var gNomina=gEx('gNomina');    
	arrTimbrar=[];
	gE('lblOperacion').innerHTML='Calculando N&oacute;mina';
    var fila;
	
    for(x=0;x<gNomina.getStore().getCount();x++)
    {
    	fila=gNomina.getStore().getAt(x);
        if(((fila.data.situacionComprobante=='7')||(fila.data.situacionComprobante=='8')||(fila.data.situacionComprobante=='1'))&&(!fila.data.ignorarCalculo))
        {
        	fila.set('situacionComprobante','7');
            fila.set('totalDeducciones','0');
            fila.set('totalPercepciones','0');
            fila.set('sueldoNeto','0');
        	arrTimbrar.push(fila);
        
        }
    }
    totalProceso=arrTimbrar.length;
    totalProcesados=0;
    mostrarBarraAvance();
    gEx('pbar').updateProgress(0,'Procesando 0/'+totalProceso);
    //gEx('gNomina').disable();
    detenerOperacion=false;

    calcularNominaEmpleado(arrTimbrar,iN,false,0);
    calcularTotalesNomina(gNomina.getStore().getCount()-1);
}

function calcularNominaEmpleado(arrTimbrar,iN,cambiarEtapa,nEtapa)
{
	
	var gNomina=gEx('gNomina');    
	if((arrTimbrar.length==0)&&(esCalculoNominaTotal()))
    {
    	ocultarBarraAvance();
        gEx('gNomina').enable();
        
        
        function respComp()
        {
        
            if(cambiarEtapa)
            {
                function funcAjax()
                {
                    var resp=peticion_http.responseText;
                    arrResp=resp.split('|');
                    if(arrResp[0]=='1')
                    {
                        
                        recargarPagina();
                    }
                    else
                    {
                        msgBox('No se ha podido realizar la operación debido al siguiente problema:'+' <br />'+arrResp[0]);
                    }
                }
                obtenerDatosWeb('../paginasFunciones/funcionesEspecialesNomina.php',funcAjax, 'POST','funcion=21&idNomina='+iN+'&nEtapa='+nEtapa,true);
            }
        }
        msgBox('La operaci&oacute;n ha sido realizada correctamente',respComp);
    }
    else
    {
    	if(arrTimbrar.length==0)
    	{
        	ocultarBarraAvance();
	        gEx('gNomina').enable();
        }
        else
        {
	        var f=arrTimbrar[0];
        	var cadObj='{"idUsuario":"'+f.data.idUsuario+'","idNomina":"'+iN+'","idPuesto":"'+f.data.puesto+'","idZona":"'+f.data.idZona+
            			'","tipoContratacion":"'+f.data.tipoPuesto+'","noRegistroProcesados":"'+(totalProcesados+1)+'","totalProceso":"'+totalProceso+'"}';
            
            function funcAjax2(peticion_http)
            {
            	
                
                var resp=peticion_http.responseText;
                arrResp=resp.split('|');
                if(arrResp[0]=='1')
                {
                	var oUsuario=eval('['+arrResp[1]+']')[0];
                	totalProcesados++;
                    
                    if(oUsuario.noCalculado)
                    {
                    	//f.set('situacionComprobante','7');
                        
                    }
                    else
                    {
                    	var pos=obtenerPosFila(gNomina.getStore(),'idUsuario',arrTimbrar[0].data.idUsuario);
                        var f=gNomina.getStore().getAt(pos);
                        f.set('totalDeducciones',oUsuario.totalDeducciones);
                        f.set('totalPercepciones',oUsuario.totalPercepciones);
                        f.set('sueldoNeto',oUsuario.sueldoNeto);
                        f.set('situacionComprobante','8');
                        f.set('idAsientoNomina',oUsuario.idAsientoNomina);
                        
                        
                         
                    }
                    
                    gEx('gNomina').getView().refresh();
                    arrTimbrar.splice(0,1);
                    gEx('pbar').updateProgress((totalProcesados/totalProceso),'Procesando '+totalProcesados+'/'+totalProceso);
                    if(!detenerOperacion)
                        calcularNominaEmpleado(arrTimbrar,iN,cambiarEtapa,nEtapa);
                    else
                    {
                        ocultarBarraAvance();
                        gEx('gNomina').enable();
                    }
                }
                else
                {
                    msgBox('No se ha podido realizar la operación debido al siguiente problema:'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWebV2('../paginasFunciones/funcionesEspecialesNomina.php',funcAjax2, 'POST','funcion=102&cadObj='+cadObj,false);
    	}
    }
}


function esCalculoNominaTotal()
{
	var gNomina=gEx('gNomina');
    var x;
    var fila;
	
    for(x=0;x<gNomina.getStore().getCount();x++)
    {
    	fila=gNomina.getStore().getAt(x);
        if((fila.data.situacionComprobante=='7')&&(!fila.data.ignorarCalculo))
        	return false;
    }
    return true;
}


function mostrarBarraAvance()
{
	gEx('lblAvance1').show();
    gEx('lblAvance2').show();
    gEx('lblAvance3').show();
    gEx('lblAvance4').show();
    gEx('pbar').show();
}

function ocultarBarraAvance()
{
	gEx('lblAvance1').hide();
    gEx('lblAvance2').hide();
    gEx('lblAvance3').hide();
    gEx('lblAvance4').hide();
    gEx('pbar').hide();
}


function calcularTotalesNomina(posFinal)
{
	var totalDeducciones=0;
    var totalPercepciones=0;
    var sueldoNeto=0;
	var f;
	var pos=0;
    var gNomina=gEx('gNomina');
    for(pos=0;pos<=posFinal;pos++)
    {
    	f=gNomina.getStore().getAt(pos);
        totalDeducciones+=parseFloat(f.data.totalDeducciones);
        totalPercepciones+=parseFloat(f.data.totalPercepciones);
        sueldoNeto+=parseFloat(f.data.sueldoNeto);
        
        
    }
	
	gE('lblTPercepciones').innerHTML=Ext.util.Format.usMoney(totalPercepciones);
	gE('lblTDeducciones').innerHTML=Ext.util.Format.usMoney(totalDeducciones);
	gE('lblSNeto').innerHTML=Ext.util.Format.usMoney(sueldoNeto);                        
}