<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$consulta="SELECT idEtapaProcesal,descripcionEtapa,orden FROM 7009_etapasProcesales ORDER BY orden";
	$arrEtapasProcesales=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT idCategoria,nombreCategoria FROM 908_categoriasDocumentos";
	$arrCategorias=$con->obtenerFilasArreglo($consulta);

	$consulta="SELECT idCategoria,nombreCategoria FROM 908_categoriasDocumentos";
	$arrTipoDocumentos=$con->obtenerFilasArreglo($consulta);

	$carpetaAdministrativa=bD($_GET["cA"]);
	
	$consulta="SELECT COUNT(*) FROM _17_tablaDinamica u,7006_carpetasAdministrativas c,_17_gridDelitosAtiende g WHERE claveUnidad=c.unidadGestion
				AND c.carpetaAdministrativa='".$carpetaAdministrativa."' AND g.idReferencia=u.id__17_tablaDinamica AND g.tipoDelito IN('D','EA')";
	$carpetaAdolescentes=$con->obtenerValor($consulta);
	
	$carpetaAdolescentes=$carpetaAdolescentes>0;
	
	
	$consulta="SELECT idSituacion,descripcionSituacion FROM 7011_situacionEventosAudiencia";
	$arrSituacionEvento=$con->obtenerFilasArreglo($consulta);
	
	$fechaActual=date("Y-m-d");
	$diaActual=date("N",strtotime($fechaActual));
	$fechaFinal=7-$diaActual;
	
	$fechaFinal=date("Y-m-d",strtotime("+".$fechaFinal." days",strtotime($fechaActual)));
	
	$consulta="SELECT  id__4_tablaDinamica,tipoAudiencia FROM _4_tablaDinamica";
	$arrAudiencias=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT id__15_tablaDinamica,nombreSala FROM _15_tablaDinamica";
	$arrSalas=$con->obtenerFilasArreglo($consulta);

	$consulta="SELECT id__15_tablaDinamica, concat(nombreSala, ' [',e.nombreInmueble,']') FROM _15_tablaDinamica s,_1_tablaDinamica e 
			where e.id__1_tablaDinamica=s.idReferencia and id__15_tablaDinamica in(SELECT DISTINCT idSala FROM 7000_eventosAudiencia) 
			order by nombreSala,nombreInmueble";
	$arrSalasBusqueda=$con->obtenerFilasArreglo($consulta);

	$consulta="SELECT id__1_tablaDinamica,nombreInmueble FROM _1_tablaDinamica";
	$arrEdificios=$con->obtenerFilasArreglo($consulta);

	$consulta="SELECT id__17_tablaDinamica,nombreUnidad FROM _17_tablaDinamica";
	$arrUnidades=$con->obtenerFilasArreglo($consulta);
	
	
	$consulta="SELECT idSituacion,icono,tamano FROM 7011_situacionEventosAudiencia";
	$arrSituaciones=$con->obtenerFilasArreglo($consulta);

	$consulta="SELECT valor,texto FROM 1004_siNo";
	$arrSiNo=$con->obtenerFilasArreglo($consulta);

	$consulta="SELECT idRegistro,descripcion FROM 7014_situacionCarpetaAdministrativa";
	$arrStuacionCarpeta=$con->obtenerFilasArreglo($consulta);

	$consulta="SELECT idRegistro,descripcion FROM 7014_situacionCarpetaAdministrativa where asociableDocumento=1 order by descripcion";
	$arrSituacionCarpetaDocumento=$con->obtenerFilasArreglo($consulta);

	$consulta="SELECT idRegistro,descripcion FROM 7014_situacionCarpetaAdministrativa";
	$arrSituacionesCarpeta=$con->obtenerFilasArreglo($consulta);


	$consulta="SELECT idRegistro,descripcion FROM 7014_situacionCarpetaAdministrativa where asociableDocumento=1 order by descripcion";
	$arrStatusCarpeta=$con->obtenerFilasArreglo($consulta);

	$consulta="SELECT idActividad,unidadGestion,idCarpeta FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaAdministrativa."'";
	$fInfoCarpeta=$con->obtenerPrimeraFila($consulta);
	
	$idActividadCarpeta=$fInfoCarpeta[0];
	if($idActividadCarpeta=="")
		$idActividadCarpeta=-1;	
	$idCarpetaAdministrativa=$fInfoCarpeta[2];
	$unidadCarpeta=$fInfoCarpeta[1];
	$consulta="SELECT id__47_tablaDinamica,CONCAT(IF(f.nombre IS NULL,'',f.nombre),' ',IF(f.apellidoPaterno IS NULL,'',f.apellidoPaterno),' ',
			IF(f.apellidoMaterno IS NULL,'',f.apellidoMaterno)) FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica f WHERE 
			r.idActividad=".$idActividadCarpeta." AND idFiguraJuridica=4 	AND f.id__47_tablaDinamica=r.idParticipante ORDER BY 
			f.nombre,f.apellidoPaterno,f.apellidoMaterno";	
	$arrImputados=$con->obtenerFilasArreglo($consulta);

	$consulta="SELECT MIN(r.fechaRecordatorio) FROM 7037_recordatoriosPreviosNotificacion r,7036_alertasNotificaciones a WHERE 
				a.carpetaAdministrativa='".$carpetaAdministrativa."' AND r.idAlertaNotificacion=a.idRegistro and a.situacion=1";
	$minFechaAlerta=$con->obtenerValor($consulta);

	$consulta="SELECT MAX(r.fechaRecordatorio) FROM 7037_recordatoriosPreviosNotificacion r,7036_alertasNotificaciones a WHERE 
				a.carpetaAdministrativa='".$carpetaAdministrativa."' AND r.idAlertaNotificacion=a.idRegistro and a.situacion=1";
	$maxFechaAlerta=$con->obtenerValor($consulta);
	
	$tipoCarpetaAdministrativa=bD($_GET["tC"]);
	
	$listParteProcesal="";
	
	$consulta="SELECT id__5_tablaDinamica,
	if((SELECT nombreSingular FROM _5_aliasTiposFiguras WHERE idFigura=t.id__5_tablaDinamica AND materia='".$tipoMateria."') is null
			,nombreTipo,(SELECT nombreSingular FROM _5_aliasTiposFiguras WHERE idFigura=t.id__5_tablaDinamica AND materia='".$tipoMateria."')) as nombreTipo 
			FROM _5_tablaDinamica t order by nombreTipo";
	$arrTipoFigura=$con->obtenerFilasArreglo($consulta);
	
	$arrParteProcesal="";
	
	$res=$con->obtenerFilas($consulta);
	while($filaFigura=mysql_fetch_row($res))
	{
		if(($carpetaAdolescentes)&&($filaFigura[0]==4))
		{
			$filaFigura[1]="Adolescente";
		}
		if($listParteProcesal=="")
			$listParteProcesal=$filaFigura[0];
		else
			$listParteProcesal.=",".$filaFigura[0];
		$consulta="SELECT idDetalle,etiquetaDetalle FROM _5_gDetallesTipo WHERE idReferencia=".$filaFigura[0];
		$arrDetalles=$con->obtenerFilasArreglo($consulta);
		$consulta="SELECT idOpcion FROM _5_tiposFiguras WHERE idPadre=".$filaFigura[0];
		$listFiguras=$con->obtenerListaValores($consulta);
		$o="['".$filaFigura[0]."','".cv($filaFigura[1])."',".$arrDetalles.",'".$listFiguras."']";
		if($arrParteProcesal=="")
			$arrParteProcesal=$o;
		else
			$arrParteProcesal.=",".$o;
		
		
	}
	
	if($listParteProcesal=="")
		$listParteProcesal=-1;
	$arrPartes="";
	
	$consulta="SELECT id__5_tablaDinamica,
	if((SELECT nombreSingular FROM _5_aliasTiposFiguras WHERE idFigura=t.id__5_tablaDinamica AND materia='".$tipoMateria."') is null
			,nombreTipo,(SELECT nombreSingular FROM _5_aliasTiposFiguras WHERE idFigura=t.id__5_tablaDinamica AND materia='PT')) as nombreTipo 
			 FROM _5_tablaDinamica t where id__5_tablaDinamica in(".$listParteProcesal.") order by nombreTipo";
	
	if($carpetaAdolescentes)
	  {
		  $consulta="SELECT id__5_tablaDinamica,if(id__5_tablaDinamica=4,'Adolescente',nombreTipo) FROM _5_tablaDinamica where id__5_tablaDinamica in(".$listParteProcesal.") order by nombreTipo";
	  }
	
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$o="{
				cls:'x-btn-text-icon',
				text:'".$fila[1]."',
				handler:function()
						{	
							var oConf=	{
											idActividad:gE('idActividad').value,
											idCarpeta:".$idCarpetaAdministrativa.",
											afterRegister:recargarArbolParticipantes,
											carpetaAdministrativa:gE('carpetaAdministrativa').value
										}
							agregarParticipanteVentana(".$fila[0].",'".cv($fila[1])."',oConf);
						}
				
			}";
		if($arrPartes=="")
			$arrPartes=$o;
		else			
			$arrPartes.=",".$o;
	}
	
	$arrPartes="[".$arrPartes."]";
	
	$consulta="SELECT id__32_tablaDinamica,tipoIdentificacion FROM _32_tablaDinamica";
	$arrTipoIdentificacion=$con->obtenerFilasArreglo($consulta);
	
	$arrSituacionImputado="";
	$consulta="SELECT idRegistro,situacion FROM 7014_situacionImputado WHERE idRegistro>5";
	$rSituacionImp=$con->obtenerFilas($consulta);
	while($fSituacionImp=mysql_fetch_row($rSituacionImp))
	{
		$consulta="SELECT idRegistro,detalleSituacionImputado FROM 7014_detalleSituacionImputado WHERE idSituacionImputado=".$fSituacionImp[0];
		$arrDetalleSituacionImp=$con->obtenerFilasArreglo($consulta);
		$oImputado="['".$fSituacionImp[0]."','".$fSituacionImp[1]."',".$arrDetalleSituacionImp."]";
		
		if($arrSituacionImputado=="")
			$arrSituacionImputado=$oImputado;
		else
			$arrSituacionImputado.=",".$oImputado;
	}
	
	$consulta="SELECT idRegistro,detalleSituacionImputado FROM 7014_detalleSituacionImputado";
	$arrDetalleSituacionImputado=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT idRegistro,situacion FROM 7014_situacionImputado";
	$arrSituacionImputadoCompleto=$con->obtenerFilasArreglo($consulta);

	
	
	$arrEtapasGeneracionDocumentos="";
	$consulta="SELECT numEtapa,nombreEtapa FROM 4037_etapas WHERE idProceso=234 ORDER BY numEtapa";
	$resEtapas=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($resEtapas))
	{
		$o="[".$fila[0].",'".removerCerosDerecha($fila[0]).".- ".$fila[1]."']";
		if($arrEtapasGeneracionDocumentos=="")
			$arrEtapasGeneracionDocumentos=$o;
		else
			$arrEtapasGeneracionDocumentos.=",".$o;
	}
	$arrEtapasGeneracionDocumentos="[".$arrEtapasGeneracionDocumentos."]";
	$consulta="SELECT valor,contenido FROM 902_opcionesFormulario WHERE idGrupoElemento=8665";
	$arrTiposDocumento=$con->obtenerFilasArreglo($consulta);
	
	$etiquetaCarpeta="";
	$lblDocumentosAsociados="";
	$lblExpedientesAsociados="";
	switch($tipoMateria)
	{
		case "P":
			$etiquetaCarpeta=($tipoCarpetaAdministrativa==8?"Carpeta Judicial de Alzada":"Carpeta Judicial");
			$lblDocumentosAsociados=($tipoCarpetaAdministrativa==8?'Documentos asociados a la Carpeta Judicial de Alzada':'Documentos asociados a la Carpeta Judicial');
			$lblExpedientesAsociados='Carpetas Judiciales Asociadas';
		break;
		case "PT":
			$etiquetaCarpeta="Causa Penal";
			$lblDocumentosAsociados="Documentos asociados a la Causa Penal";
			$lblExpedientesAsociados='Causas Penales Asociadas';
		break;
		default:
			$etiquetaCarpeta="Expediente";
			$lblDocumentosAsociados="Documentos asociados al Expediente";
			$lblExpedientesAsociados='Expedientes Asociados';
		break;
	}

?>
var uploadControl;
var primeraCargaFrame=true;
var unidadCarpeta='<?php echo $unidadCarpeta?>';
var arrTiposDocumento=<?php echo $arrTiposDocumento?>;
var arrEtapasGeneracionDocumentos=<?php echo $arrEtapasGeneracionDocumentos?>;
var arrEtapasGeneracionDocumentos=<?php echo $arrEtapasGeneracionDocumentos?>;
var arrDetalleSituacionImputado=<?php echo $arrDetalleSituacionImputado?>;
var arrSituacionImputado=[<?php echo $arrSituacionImputado?>];
var arrSituacionImputadoCompleto=<?php echo $arrSituacionImputadoCompleto?>;
var arrTipoIdentificacion=<?php echo $arrTipoIdentificacion?>;
var idOrden=-1;
var arrStatusParte=[['0','Baja'],['1','Alta']];
var arrStatusCuenta=[['','Sin Cuenta de Acceso'],['1','Cuenta Activa'],['2','Cuenta Inactiva']];
var arrParteProcesal=[<?php echo $arrParteProcesal?>];
var listParteProcesal='<?php echo $listParteProcesal?>';
var nodoSujetoSel=null;
var tipoCarpetaAdministrativa='<?php echo $tipoCarpetaAdministrativa?>';



var etiquetaCarpeta='<?php echo $etiquetaCarpeta?>';


var arrSalasBusqueda=<?php echo $arrSalasBusqueda?>;
var arrEdificios=<?php echo $arrEdificios?>;
var rolSalas='<?php echo existeRol("'69_0'")?"69_0":(existeRol("'81_0'")?"81_0":"0")?>';
var minFechaAlerta=<?php echo $minFechaAlerta==""?"'".date("Y-m-d")."'":"'".date("Y-m-d",strtotime($minFechaAlerta))."'"?>;
var maxFechaAlerta=<?php echo $maxFechaAlerta==""?"'".date("Y-m-d")."'":"'".date("Y-m-d",strtotime($maxFechaAlerta))."'"?>;
var arrStatusAlerta=[['1','<span style="color:#030">Activa</span>'],['3','<span style="color:#0E3A92">Atendida</span>'],['2','<span style="color:#900">Cancelada</span>']];
var oPenaPrescripcion;
var arrImputados=<?php echo $arrImputados?>;
var idActividadCarpeta=<?php echo $idActividadCarpeta?>;
var arrStatusPrescripcion=[['1','Activo'],['2','Cancelada']];
var arrStatusCarpeta=<?php echo $arrStatusCarpeta?>;
var arrSituacionesCarpeta=<?php echo $arrSituacionesCarpeta?>;
var arrSituacionCarpetaDocumento=<?php echo $arrSituacionCarpetaDocumento?>;
var nodoPlantillaSel=null;
var arrStuacionCarpeta=<?php echo $arrStuacionCarpeta?>;
var arrSiNo=<?php echo $arrSiNo?>;
var nodoCarpetaSel=null;
var arrCategorias=<?php echo $arrCategorias?>;
var arrEtapasProcesales=<?php echo $arrEtapasProcesales?>;
var arrSituacionEvento=<?php echo $arrSituacionEvento?>;
var arrSalas=<?php echo $arrSalas?>;
var arrAudiencias=<?php echo $arrAudiencias?>;
var arrUnidades=<?php echo $arrUnidades?>;
var lblCarpeta='';
var arrTipoActa=[['1','Derivada de Determinaci\xF3n'],['2','Derivada de audiencia']];
var arrSituacionActa=[['1','En registro'],['2','Concluida']];
var arrSituacionOrden=[['1,4','Cualquiera'],['1','En registro'],['4','Concluida']]; 
var arrTipoSolicitud=[['1','Derivada de Determinaci\xF3n'],['2','Derivada de audiencia']];

var arrSemaforo=<?php echo $arrSituaciones?>;



Ext.onReady(inicializar);

function inicializar()
{
	
    var vista=new Ext.Viewport(	{
                                layout: 'border',
                                listeners:	{
                                                show : {
                                                            buffer : 3000,
                                                            fn : function() 
                                                            {
                                                               
                                                                vista.doLayout();
                                                            }
                                                        }
                                             },
                                items: [
                                            {
                                                xtype:'panel',
                                                region:'center',
                                                layout:'border',
                                                items:	[	
                                                			
                                                            {
                                                            	xtype:'panel',
                                                                region:'center',
                                                                layout:'border',
                                                                items:	[
                                                                			{
                                                                            	xtype:'panel',
                                                                                region:'center',
                                                                                layout:'border',
                                                                                title:etiquetaCarpeta+' [<span style="color:#900"><b>'+gE('carpetaAdministrativa').value+'</b></span>]',
                                                                                items:	[
                                                                                            {
                                                                                                xtype:'tabpanel',
                                                                                                activeTab:0,
                                                                                                region:'center',
                                                                                                split:true,
                                                                                                height:200,
                                                                                                id:'tabGeneral',
                                                                                                border:false,                                                                                
                                                                                                items:	[
                                                                                                			{
                                                                                                            	xtype:'panel',
                                                                                                                layout:'border',
                                                                                                                title:'<?php echo $lblDocumentosAsociados ?>',
                                                                                                                items:	[
                                                                                                                			crearArbolCarpetasJudiciales(),
                                                                                                                			crearArbolCarpetaAdministrativa()
                                                                                                                		]
                                                                                                            }
                                                                                                            <?php
																											//if(existeRol("'69_0'")||existeRol("'106_0'")||existeRol("'112_0'")||existeRol("'90_0'"))
																											if($tipoCarpetaAdministrativa!=9)
																											{
																											?>
                                                                                                            ,
                                                                                                            
                                                                                                            crearGridEventos()
                                                                                                            <?php
																											}
																											
																											if(($tipoMateria=="P")&&($tipoCarpetaAdministrativa!=8))
																											{
																											?>
                                                                                                            ,
                                                                                                            {
                                                                                                            	xtype:'panel',
                                                                                                                layout:'border',
                                                                                                                title:'Notificaciones',
                                                                                                                tbar:	[
                                                                                                                			{
                                                                                                                                icon:'../images/add.png',
                                                                                                                                cls:'x-btn-text-icon',
                                                                                                                                id:'btnCrear',
                                                                                                                                hidden:gE('sL').value=='1',
                                                                                                                                text:'Crear orden de notificaci&oacute;n',
                                                                                                                                handler:function()
                                                                                                                                        {
                                                                                                                                            mostrarVentanaOrdenNotificacion();  
                                                                                                                                        }
                                                                                                                                
                                                                                                                            },'-',
                                                                                                                            {
                                                                                                                                id:'btnModificarOrden',
                                                                                                                                icon:'../images/pencil.png',
                                                                                                                                cls:'x-btn-text-icon',
                                                                                                                                disabled:true,
                                                                                                                                hidden:gE('sL').value=='1',
                                                                                                                                text:'Modificar orden de notificaci&oacute;n',
                                                                                                                                handler:function()
                                                                                                                                        {
                                                                                                                                            var fila=gEx('gOrdenesNotificacion').getSelectionModel().getSelected();
                                                                                                                                            if(!fila)
                                                                                                                                            {
                                                                                                                                                msgBox('Debe seleccionar la orden de notificaci&oacute;n que desea remover');
                                                                                                                                                return;
                                                                                                                                            }
                                                                                                                                            mostrarVentanaOrdenNotificacion(fila);
                                                                                                                                        }
                                                                                                                                
                                                                                                                            },'-',
                                                                                                                            {
                                                                                                                                id:'btnModificar',
                                                                                                                                icon:'../images/pencil_go.png',
                                                                                                                                cls:'x-btn-text-icon',
                                                                                                                                disabled:true,
                                                                                                                                hidden:gE('sL').value=='1',
                                                                                                                                text:'Editar acta circunstanciada',
                                                                                                                                handler:function()
                                                                                                                                        {
                                                                                                                                            var fila=gEx('gOrdenesNotificacion').getSelectionModel().getSelected();
                                                                                                                                            if(!fila)
                                                                                                                                            {
                                                                                                                                                msgBox('Debe seleccionar la orden de notificaci&oacute;n que desea editar');
                                                                                                                                                return;
                                                                                                                                            }
                                                                                                                                            var obj={};
                                                                                                                                            obj.ancho='100%';
                                                                                                                                            obj.alto='100%';
                                                                                                                                            obj.url='../modulosEspeciales_SGJP/tblOrdenNotificacionAtencion.php';
                                                                                                                                            obj.params=[['idOrden',fila.data.idOrden],['vTAudiencia','1']];
                                                                                                                                            abrirVentanaFancy(obj);
                                                                                                                                        }
                                                                                                                                
                                                                                                                            }
                                                                                                                            
                                                                                                                            ,'-',
                                                                                                                            {
                                                                                                                                id:'btnRemover',
                                                                                                                                icon:'../images/delete.png',
                                                                                                                                cls:'x-btn-text-icon',
                                                                                                                                disabled:true,
                                                                                                                                hidden:gE('sL').value=='1',
                                                                                                                                text:'Remover orden de notificaci&oacute;n',
                                                                                                                                handler:function()
                                                                                                                                        {
                                                                                                                                            var fila=gEx('gOrdenesNotificacion').getSelectionModel().getSelected();
                                                                                                                                            if(!fila)
                                                                                                                                            {
                                                                                                                                                msgBox('Debe seleccionar la orden de notificaci&oacute;n que desea remover');
                                                                                                                                                return;
                                                                                                                                            }
                                                                                                                                            
                                                                                                                                            function respConf(btn)
                                                                                                                                            {
                                                                                                                                                if(btn=='yes')
                                                                                                                                                {
                                                                                                                                                    function funcAjax()
                                                                                                                                                    {
                                                                                                                                                        var resp=peticion_http.responseText;
                                                                                                                                                        arrResp=resp.split('|');
                                                                                                                                                        if(arrResp[0]=='1')
                                                                                                                                                        {
                                                                                                                                                            gEx('btnRemover').disable();
                                                                                                                                                            gEx('btnModificar').disable();
                                                                                                                                                            gEx('btnModificarOrden').disable();
                                                                                                                                                            gEx('gOrdenesNotificacion').getStore().remove(fila);
                                                                                                                                                        }
                                                                                                                                                        else
                                                                                                                                                        {
                                                                                                                                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                                                                        }
                                                                                                                                                    }
                                                                                                                                                    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_Notificaciones.php',funcAjax, 'POST','funcion=5&iO='+fila.data.idOrden,true);
                                                                                                                                                }
                                                                                                                                            }
                                                                                                                                            msgConfirm('Est&aacute; seguro de querer remover la orden de notificaci&oacute;n seleccionada?',respConf);
                                                                                                                                            
                                                                                                                                        }
                                                                                                                                
                                                                                                                            }
                                                                                                                		],
                                                                                                                items:	[
				                                                                                                            crearGridOrdenesNotificacion()
                                                                                                                        ]
                                                                                                            },//ordenes notificacion
                                                                                                            crearGridGeneracionDocumentos(),                                                                                                            
                                                                                                      		crearGridPrescripciones(),
                                                                                                       		
                                                                                                       		crearGridNotificacionesDia(),
                                                                                                            
                                                                                                            crearPanelPartesProcesales() ,
                                                                                                            crearGridHistorialCarpeta()
                                                                                                            
                                                                                                            
                                                                                                            	                                                                                                            ,crearPanelAutorizacionVideoGrabacion()
                                                                                                            <?php
																													
																											}
																											else
																											{
																											?>
                                                                                                            ,crearPanelPartesProcesales() 
                                                                                                            
                                                                                                            <?php
																											}
																											if($tipoMateria=="SC")
																											{
																											?>
                                                                                                            
                                                                                                            ,crearGridGeneracionDocumentosSicore()
                                                                                                            ,crearPanelPartesProcesales()
                                                                                                             
                                                                                                            <?php
																											}
																											?>
                                                                                                      ]
                                                                                            }
                                                                                          ]
                                                                         }                           
                                                                		]
                                                                
                                                            }
                                                            
                                                        ]
                                            }
                                         ]
                            }
                        )  
	tipoCarpetaAdministrativa=gE('tipoCarpetaAdministrativa').value;

}

function crearPanelAutorizacionVideoGrabacion()
{
	
    
	
	var panel=new Ext.Panel	(
    							{
                                    id:'pVideoGrabacion',
                                    layout:'border',
                                    title:'Audiencias Virtuales',
                                    items:	[
                                    			
                                                crearGridDocumentosPartesProcesales()
                                            ],
                                    tbar:	[
                                    			{
                                                    icon:'../images/add.png',
                                                    cls:'x-btn-text-icon',
                                                    hidden:gE('sL').value=='1',
                                                    text:'Agregar parte...',
                                                    menu:	<?php echo $arrPartes?>
                                                    
                                                },'-',
                                    			{
                                                	
                                                    xtype:'label',
                                                    html:'<b>Permitir agendar audiencias virtuales en esta carpeta:&nbsp;&nbsp;&nbsp;</b>'
                                                },
                                                {
                                                	xtype:'label',
                                                    html:'<span  style="color:#900; font-weight:bold" id="lblPermiteAudienciaVirtual">'+(gE('permiteAudienciaVirtual').value=='1'?'S&iacute':'No')+'</span>&nbsp;&nbsp;'
                                                },
                                                '-',
                                                
                                                {
                                                    icon:'../images/icon_big_tick.gif',
                                                    cls:'x-btn-text-icon',
                                                    id:'btnEnableAudienciaVirtual',
                                                    hidden:gE('permiteAudienciaVirtual').value=='1',
                                                    text:'Habilitar programaci&oacute;n de audiencia virtual',
                                                    handler:function()
                                                            {
                                                            	var totalRestantes=0;
                                                                var x;
                                                                var fila;
                                                                var gridAutorizacionAudienciaVirtual=gEx('gridAutorizacionAudienciaVirtual');
                                                                for(x=0;x<gridAutorizacionAudienciaVirtual.getStore().getCount();x++)
                                                                {
                                                                    fila=gridAutorizacionAudienciaVirtual.getStore().getAt(x);
                                                                    
                                                                    if(!fila.data.noAplica)
                                                                    {
                                                                        if((fila.data.identificacion=='')||(fila.data.documentoAutorizacion==''))
                                                                        {
                                                                            totalRestantes++;
                                                                        }
                                                                    }
                                                                }
                                                                
                                                                
                                                                if(totalRestantes>0)
                                                                {
                                                                    function respAux()
                                                                    {
                                                                        cmbSiNoPermiteAudienciaVirtual.setValue('0');
                                                                    }
                                                                    msgBox('Para permitir agendar audiencias virtuales en esta carpeta, todos los participantes deber&aacute;n ingresar su identificaci&oacute;n y documento de autorizaci&oacute;n o ser marcados como <b>No aplica</b> ',respAux);
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
                                                                                gE('lblPermiteAudienciaVirtual').innerHTML='S&iacute;';
                                                                                gEx('btnEnableAudienciaVirtual').hide();
                                                                                gEx('btnDisableAudienciaVirtual').show();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=318&situacion=1&motivo=&carpetaAdministrativa='+gE('carpetaAdministrativa').value,true);

                                                                    }
                                                                }
                                                                msgConfirm('Est&aacute; seguro de querer habilitar la programaci&oacute;n de la audiencia virtual en esta carpeta',resp);
                                                                   
                                                            }
                                                    
                                                },
                                                {
                                                    icon:'../images/cross.png',
                                                    cls:'x-btn-text-icon',
                                                    id:'btnDisableAudienciaVirtual',
                                                    hidden:gE('permiteAudienciaVirtual').value=='0',
                                                    text:'Deshabilitar programaci&oacute;n de audiencia virtual',
                                                    handler:function()
                                                            {
                                                                mostrarVentanaDehabilitarAudienciaVirtual();
                                                            }
                                                    
                                                },'-',
                                                {
                                                    icon:'../images/report.png',
                                                    cls:'x-btn-text-icon',
                                                    text:'Ver Historial',
                                                    handler:function()
                                                            {
                                                                mostrarHistorialAudienciaVirtual();
                                                            }
                                                    
                                                }
                                                
                                                
                                                
                                                
                                    		]
								}
    						)
	return panel;
}

function crearGridDocumentosPartesProcesales()
{
	 var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idParticipante'},
                                                        {name:'nombreParticipante'},
                                                        {name: 'figuraJuridica'},
                                                        {name: 'tipoIdentificacion'},
                                                        {name: 'nombreDocumentoIdentificacion'},
                                                        {name: 'identificacion'},
                                                        {name: 'nombreDocumentoAutorizacion'},
                                                        {name: 'documentoAutorizacion'},
                                                        {name: 'situacionActual'},
                                                        {name: 'noAplica'},
                                                        {name: 'motivoNoAplica'},
                                                        {name: 'cuentaGenerada'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../paginasFunciones/funcionesModulosEspeciales_SGP.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'figuraJuridica', direction: 'ASC'},
                                                            groupField: 'figuraJuridica',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='312';
                                        proxy.baseParams.idCarpeta=gE('idCarpetaAdministrativa').value;
                                        proxy.baseParams.carpetaAdministrativa=gE('carpetaAdministrativa').value;
                                        
                                    }
                        )   
       

	var checkColumn = new Ext.grid.CheckColumn	(
	 												{
													   header: 'No aplica',
													   dataIndex: 'noAplica',
													   width: 80
													}
												);       
       
      var cModelo= new Ext.grid.ColumnModel   	(
                                                      [
                                                          new  Ext.grid.RowNumberer(),
                                                          {
                                                              header:'Cuenta<br />Generada',
                                                              width:85,
                                                              align:'center',
                                                              sortable:true,
                                                              dataIndex:'cuentaGenerada',
                                                              renderer:function(val,meta,registro)
                                                              			{
                                                                        	
                                                                            var lblCuenta;
                                                                            var lblCuenta2;
                                                                            if(val=='')
                                                                            {
                                                                            	lblCuenta='<img src="../images/control_pause.png" width="14" height="14" title="Sin Cuenta Generada" alt="Sin Cuenta Generada"/>';
                                                                                lblCuenta2='&nbsp;&nbsp;<a href="javascript:generarCuentaVideoGrabacion(\''+bE(registro.data.idParticipante)+'\')"><img src="../images/user_go.png" width="14" height="14" title="Generar Cuenta" alt="Generar Cuenta"/></a>';
                                                                            }
                                                                            else
                                                                            {
                                                                            	lblCuenta='<img src="../images/accept_green.png" title="Cuenta Generada" alt="Cuenta Generada"/>';
                                                                            	lblCuenta2='&nbsp;&nbsp;<a href="javascript:generarDocumentoCuentaVideoGrabacion(\''+bE(registro.data.idParticipante)+'\',\''+bE(1)+'\')"><img src="../images/printer.png" width="14" height="14" title="Imprimir Datos de Cuenta" alt="Imprimir Datos de Cuenta"/></a>';
                                                                            }
                                                                            
                                                                            if((registro.data.noAplica)||(registro.data.identificacion=='' )||(registro.data.documentoAutorizacion=='' ))
                                                                            	lblCuenta2='';
                                                                        	return lblCuenta+lblCuenta2;
                                                                        }
                                                          },
                                                          {
                                                              header:'Figura Jur&iacute;dica',
                                                              width:250,
                                                              sortable:true,
                                                              dataIndex:'figuraJuridica',
                                                              renderer:function(val)
                                                              			{
                                                                        	return formatearValorRenderer(arrParteProcesal,val);
                                                                        }
                                                          },
                                                          {
                                                              header:'',
                                                              width:320,
                                                              sortable:true,
                                                              dataIndex:'nombreParticipante',
                                                              renderer:mostrarValorDescripcion
                                                          },
                                                          {
                                                              header:'Identificaci&oacute;n',
                                                              width:300,
                                                              sortable:true,
                                                              dataIndex:'identificacion',
                                                              renderer:function(val,meta,registro)
                                                              			{
                                                                        	var comp='';
                                                                            var comp2='------';
                                                                            if(val!='')
                                                                            {
                                                                            	var arrExtension=registro.data.nombreDocumentoIdentificacion.split('.');
																				var extension=arrExtension[arrExtension.length-1];
                                                                                
                                                                            	comp='&nbsp;&nbsp;'+'<a href="javascript:visualizarDocumentoAdjunto(\''+bE(extension)+'\',\''+bE(val)+'\')">'+registro.data.nombreDocumentoIdentificacion+' ('+formatearValorRenderer(arrTipoIdentificacion,registro.data.tipoIdentificacion)+')</a>';
                                                                            	if(!registro.data.noAplica)
	                                                                                comp2='<a href="javascript:removerDocumentoAutorizacion(\''+bE(1)+'\',\''+bE(registro.data.idParticipante)+'\',\''+bE(val)+'\')"><img src="../images/delete.png" title="Remover documento" alt="Remover documento"/></a>&nbsp;&nbsp;';
                                                                            }
                                                                            
                                                                            if((gE('lblPermiteAudienciaVirtual').innerHTML=='No')||(registro.data.noAplica))
                                                                            {
                                                                            	return comp2+''+mostrarValorDescripcion(comp);
                                                                            }
                                                                            else
                                                                            {
                                                                            	return comp2+'&nbsp;&nbsp;<a href="javascript:identificacionUpload(\''+bE(registro.data.idParticipante)+'\')"><img title="Subir documento" alt="Subir documento" src="../images/pencil.png" width="14" height="14"/></a>'+mostrarValorDescripcion(comp);
                                                                            }
                                                                            
                                                                        	
                                                                        }
                                                          },
                                                          {
                                                              header:'Documento de autorizaci&oacute;n',
                                                              width:300,
                                                              sortable:true,
                                                              dataIndex:'documentoAutorizacion',
                                                              renderer:function(val,meta,registro)
                                                              			{
                                                                        	var comp2='------';
                                                                        	var comp='';
                                                                            if(val!='')
                                                                            {
                                                                            	var arrExtension=registro.data.nombreDocumentoAutorizacion.split('.');
																				var extension=arrExtension[arrExtension.length-1];
                                                                            	comp='&nbsp;&nbsp;'+'<a href="javascript:visualizarDocumentoAdjunto(\''+bE(extension)+'\',\''+bE(val)+'\')">'+registro.data.nombreDocumentoAutorizacion+'</a>';
                                                                            	if(!registro.data.noAplica)
                                                                                	comp2='<a href="javascript:removerDocumentoAutorizacion(\''+bE(2)+'\',\''+bE(registro.data.idParticipante)+'\',\''+bE(val)+'\')"><img src="../images/delete.png" title="Remover documento" alt="Remover documento"/></a>&nbsp;&nbsp;';
                                                                            
                                                                            }
                                                                            
                                                                             if((gE('lblPermiteAudienciaVirtual').innerHTML=='No')||(registro.data.noAplica))
                                                                            {
                                                                            	return comp2+''+mostrarValorDescripcion(comp);
                                                                            }
                                                                            else
                                                                            {
                                                                            	return comp2+'&nbsp;&nbsp;<a href="javascript:autorizacionUpload(\''+bE(registro.data.idParticipante)+'\')"><img src="../images/pencil.png" width="14" height="14"/></a>'+mostrarValorDescripcion(comp);
                                                                            }
                                                                            
                                                                        	
                                                                        }
                                                          },
                                                          checkColumn,
                                                          {
                                                              header:'Motivo del NO aplica',
                                                              width:350,
                                                              editor:	{
                                                              				xtype:'textarea'
                                                              			},
                                                              sortable:true,
                                                              dataIndex:'motivoNoAplica',
                                                              renderer:function(val)
                                                              			{
                                                                        	return mostrarValorDescripcion(escaparEnter(val));
                                                                        }
                                                          }
                                                      ]
                                                  );
                                                  
      var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                          {
                                                              id:'gridAutorizacionAudienciaVirtual',
                                                              store:alDatos,
                                                              region:'center',
                                                              frame:false,
                                                              cm: cModelo,
                                                              stripeRows :true,
                                                              loadMask:true,
                                                              columnLines : true,
                                                              clicksToEdit:1,
                                                              plugins:[checkColumn],
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
      
      tblGrid.on('beforeedit',function(e)
      						{
                            	
                            	if(((e.field=='motivoNoAplica')&&(!e.record.get('noAplica')))||(gE('lblPermiteAudienciaVirtual').innerHTML=='No'))
                                {
                                	e.cancel=true;
                                }
                                if(e.field=='motivoNoAplica')
                                {
                                	e.record.set('motivoNoAplica',escaparBR(e.record.get('motivoNoAplica'),true));
                                }
                                
                            }
                )
      
      
      tblGrid.on('afteredit',function(e)
      						{
                            	var cadObj='{"campo":"'+e.field+'","valor":"'+(e.field=='noAplica'?(e.value?'1':'0'):cv(e.value))+'","idParticipante":"'+e.record.data.idParticipante+
                                			'","carpetaAdministrativa":"'+gE('carpetaAdministrativa').value+'"}';
                            	function funcAjax()
                                {
                                    var resp=peticion_http.responseText;
                                    arrResp=resp.split('|');
                                    if(arrResp[0]=='1')
                                    {
                                        if((e.field=='noAplica')&&(!e.value))
                                        {
                                        	e.record.set('motivoNoAplica','');
                                        }
                                    }
                                    else
                                    {
                                    	function respAux()
                                        {
                                        	e.record.set(e.field,e.originalValue);
                                        }
                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[1],respAux);
                                    }
                                }
                                obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=314&cadObj='+cadObj,true);	
                            }
      			)
      
      return 	tblGrid;
}

function removerDocumentoAutorizacion(t,iP,iD)
{
	var cadObj='{"tipo":"'+bD(t)+'","idParticipante":"'+bD(iP)+'","idDocumento":"'+bD(iD)+
    			'","carpetaAdministrativa":"'+gE('carpetaAdministrativa').value+'"}';
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
                    gEx('gridAutorizacionAudienciaVirtual').getStore().reload();
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=313&cadObj='+cadObj,true);
        }
    }
    msgConfirm('Est&aacute; seguro de querer remover el documento seleccionado?',resp);	
}

function crearArbolCarpetaAdministrativa()
{
	var cmbTipoDocumento=crearComboExt('cmbTipoDocumento',arrCategorias);
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idDocumento'},
		                                                {name: 'etapaProcesal'},
		                                                {name:'nomArchivoOriginal'},
		                                                {name: 'tamano'},
                                                        {name: 'fechaRegistro', type:'date', dateFormat:'Y-m-d'},
                                                        {name: 'fechaCreacion', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name: 'descripcion'},
                                                        {name:'idFormulario'},
                                                        {name:'idRegistro'},
                                                        {name:'idDocumento'},
                                                        {name: 'categoriaDocumentos'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../paginasFunciones/funcionesModulosEspeciales_SGP.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'fechaRegistro', direction: 'ASC'},
                                                            groupField: 'fechaRegistro',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:false
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	var arrCarpeta=nodoCarpetaSel.id.split('_');
                                    	proxy.baseParams.funcion='19';
                                        proxy.baseParams.cA=bE(arrCarpeta[0]);
                                        proxy.baseParams.idCarpetaAdministrativa=<?php echo  $registrarIDCarpeta?"arrCarpeta[1]":"-1"?>;
                                    }
                        )   
       
    
    
    var filters = new Ext.ux.grid.GridFilters	(
    												{
                                                    	filters:	[ 
                                                        				{type: 'date', dataIndex: 'fechaCreacion'},
                                                                        {type: 'string', dataIndex: 'nomArchivoOriginal'},
                                                                        {type: 'list', dataIndex: 'categoriaDocumentos', phpMode:true, options:arrCategorias}
                                                                    ]
                                                    }
                                                );    
       
	var expander = new Ext.ux.grid.RowExpander({
                                                column:2,
                                                expandOnDblClick:false,
                                                tpl : new Ext.Template(
                                                    '<table >'+
                                                    '<tr><td ><span class="TSJDF_Control">{descripcion}</span><br /><br /></td></tr>'+
                                                    '</table>'
                                                )
                                            });        

	var chkRow=new Ext.grid.CheckboxSelectionModel();       
    var cModelo= new Ext.grid.ColumnModel   	(
                                                    [
                                                    	new  Ext.grid.RowNumberer({width:30}),
                                                        chkRow,
                                                        expander,
                                                        {
                                                            header:'ID Documento',
                                                            width:100,
                                                            hidden:true,
                                                            sortable:true,
                                                            dataIndex:'idDocumento'
                                                        },
                                                        {
                                                            header:'',
                                                            width:30,
                                                            sortable:true,
                                                            dataIndex:'idDocumento',
                                                            renderer:function(val,meta,registro)
                                                            		{
                                                                    	if(registro.data.etapaProcesal=='-1000')
                                                                        	return '';
                                                                    	var arrNombre=registro.data.nomArchivoOriginal.split('.');
                                                                        return '<img src="../imagenesDocumentos/16/file_extension_'+arrNombre[1].toLowerCase()+'.png" />'
                                                                    }
                                                        },
                                                        {
                                                            header:'Fecha de registro',
                                                            width:120,
                                                            hidden:<?php echo ($_SESSION["codigoInstitucion"]=="005")?"false":"true"; ?>,
                                                            sortable:true,
                                                            dataIndex:'fechaRegistro',
                                                            renderer:function(val)
                                                            		{
                                                                    	if(val)
                                                                    		return val.format('d/m/Y');
                                                                    }
                                                        },
                                                        {
                                                            header:'Fecha de registro',
                                                            width:120,
                                                            hidden:<?php echo ($_SESSION["codigoInstitucion"]=="005")?"false":"true"; ?>,
                                                            sortable:true,
                                                            dataIndex:'fechaCreacion',
                                                            renderer:function(val)
                                                            		{
                                                                    	if(val)
                                                                    		return val.format('d/m/Y H:i');
                                                                    }
                                                        },{
                                                            header:'Tipo documento',
                                                            width:150,
                                                            sortable:true,
                                                            dataIndex:'categoriaDocumentos',
                                                            editor:cmbTipoDocumento,
                                                            renderer:function(val)
                                                            		{
                                                                    	return formatearValorRenderer(arrCategorias,val);
                                                                    }
                                                        },
                                                        {
                                                            header:'Etapa procesal',
                                                            width:250,
                                                            hidden:true,
                                                            sortable:true,
                                                            dataIndex:'etapaProcesal',
                                                            renderer:function(val)
                                                            		{
                                                                    	return formatearValorRenderer(arrEtapasProcesales,val);
                                                                    }
                                                        },
                                                        {
                                                            header:'Documento',
                                                            width:500,
                                                            sortable:true,
                                                            dataIndex:'nomArchivoOriginal',
                                                            renderer:mostrarValorDescripcion
                                                        },
                                                        
                                                        {
                                                            header:'Tama&ntilde;o',
                                                            width:100,
                                                            sortable:true,
                                                            dataIndex:'tamano',
                                                            renderer:function(val,meta,registro)
                                                            		{
                                                                    	if(registro.data.etapaProcesal=='-1000')
                                                                        	return '';
                                                                    	return bytesToSize(parseInt(val),0);
                                                                    }
                                                        },
                                                        {
                                                            header:'',
                                                            width:30,
                                                            sortable:true,
                                                            dataIndex:'idDocumento',
                                                            renderer:function(val,meta,registro)
                                                            		{
                                                                    	if(registro.data.etapaProcesal=='-1000')
                                                                        	return '';
                                                                        if(gE('sL').value=='1')
                                                                           	return '';
	                                                                    return '<a href="javascript:removerDocumento(\''+bE(val)+'\')"><img src="../images/delete.png" title="Remover documento" alt="Remover documento" /></a>';
                                                                        
                                                                    }
                                                        },
                                                        {
                                                            header:'',
                                                            width:30,
                                                            sortable:true,
                                                            dataIndex:'idDocumento',
                                                            renderer:function(val,meta,registro)
                                                            		{
                                                                    	
                                                                        if(parseFloat(registro.data.idFormulario)>0)
	                                                                       	return '<a href="javascript:abrirProcesoOrigen(\''+bE(registro.data.idFormulario)+'\',\''+bE(registro.data.idRegistro)+'\')"><img src="../images/magnifier.png" title="Abrir proceso origen" alt="Abrir proceso origen" /></a>';
                                                                    }
                                                        }
                                                        
                                                    ]
                                                );
                                                
    var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gridCarpetaAdministrativa',
                                                            store:alDatos,
                                                            region:'center',
                                                            frame:false,
                                                            clicksToEdit:1,
                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            columnLines : true,  
                                                            sm:chkRow,
                                                            plugins:[expander,filters],   
                                                            bbar:	[
                                                            			{
                                                                            icon:'../images/printer.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Imprimir documentos seleccionados',
                                                                            handler:function()
                                                                                    {
                                                                                        var filas=gEx('gridCarpetaAdministrativa').getSelectionModel().getSelections();
                                                                                        if(filas.length==0)
                                                                                        {
                                                                                            msgBox('De seleccionar almenos un documento para imprimir');
                                                                                            return;
                                                                                        }
                                                                                        var listaDocumento='';
                                                                                        var x;
                                                                                        var fila;
                                                                                        for(x=0;x<filas.length;x++)
                                                                                        {
                                                                                            fila=filas[x];
                                                                                            if(listaDocumento=='')
                                                                                                listaDocumento=fila.data.idDocumento;
                                                                                            else
                                                                                                listaDocumento+=','+fila.data.idDocumento;
                                                                                        }
                                                                                        
                                                                                        if(listaDocumento=='')
                                                                                        {
                                                                                            msgBox('Almenos debe haber un documento para imprimir');
                                                                                            return;
                                                                                        }
                                                                                        
                                                                                        function funcAjax()
                                                                                        {
                                                                                            var resp=peticion_http.responseText;
                                                                                            arrResp=resp.split('|');
                                                                                            if(arrResp[0]=='1')
                                                                                            {
                                                                                                obtenerVersionCompletaDocumentos(arrResp[1]);
                                                                                            }
                                                                                            else
                                                                                            {
                                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                            }
                                                                                        }
                                                                                        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SICORE.php',funcAjax, 'POST','funcion=18&listaDocumento='+listaDocumento,true);
                                                                                        
                                                                                    }
                
                                                                       }
                                                            		],
                                                            tbar:	[
                                                            			
                                                            			{
                                                                        	html:'<div style="height:20px"><b><?php echo $lblDocumentosAsociados.":" ?> <span id="lblCarpetaJudicial" style="color:#900">[]</span></b></div>'
                                                                        }
                                                            		],                                                       
                                                            view:new Ext.grid.GroupingView({
                                                                                                forceFit:false,
                                                                                                showGroupName: false,
                                                                                                enableGrouping :<?php echo ($_SESSION["codigoInstitucion"]=="005")?"true":"false"; ?>,
                                                                                                enableNoGroups:false,
                                                                                                enableGroupingMenu:false,
                                                                                                hideGroupedColumn: true,
                                                                                                startCollapsed:false,
                                                                                                groupTextTpl:'<span style="color:#900"><b>{text}</b> ({[values.rs.length]} {[values.rs.length > 1 ? "Documentos" : "Documento"]})</span>'
                                                                                            })
                                                        }
                                                    );
                                                    
	
    tblGrid.on('afteredit',function(e)
    						{
                            	function funcAjax()
                                {
                                    var resp=peticion_http.responseText;
                                    arrResp=resp.split('|');
                                    if(arrResp[0]=='1')
                                    {
                                        
                                    }
                                    else
                                    {
                                    	function respErr()
                                        {
                                        	e.record.set(e.field,e.originalValue);
                                        }
                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0],respErr);
                                    }
                                }
                                obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=57&iD='+e.record.data.idDocumento+'&tD='+e.value,true);
                                
                            }
    			)
    
    tblGrid.on('rowdblclick',function(grid,rowIndex)
                              {
                              		
                              		var registro=grid.getStore().getAt(rowIndex);
                                    if(registro.data.etapaProcesal=='-1000')
                                    	return ;
                                    var arrNombre=registro.data.nomArchivoOriginal.split('.');
                                  	mostrarVisorDocumentoProcesoIndice(arrNombre[1].toLowerCase(),registro.data.idDocumento,registro);
                                  
                              }
                  )                                                    
                                                    
    return 	tblGrid;	
}

function crearGridAcciones()
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name: 'idAccion'},
		                                                {name: 'etiqueta'},
		                                                {name: 'tipoModulo'},
		                                                {name: 'datosConfiguracion'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../paginasFunciones/funcionesModulosEspeciales_SGP.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'etiqueta', direction: 'ASC'},
                                                            groupField: 'etiqueta',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='20';
                                        proxy.baseParams.iE=bE(gE('idEventoAudiencia').value);
                                        proxy.baseParams.cA=bE(gE('carpetaAdministrativa').value);
                                        proxy.baseParams.iP=bE(idPerfil);
                                    }
                        )   
       
    
    
        
       
    var cModelo= new Ext.grid.ColumnModel   	(
                                                    [
                                                        
                                                        
                                                        {
                                                            header:'Acci&oacute;n',
                                                            width:200,
                                                            sortable:true,
                                                            dataIndex:'etiqueta'
                                                        },
                                                        {
                                                            header:'',
                                                            width:30,
                                                            sortable:true,
                                                            dataIndex:'datosConfiguracion',
                                                            renderer:function(val,meta,registro)
                                                            		{
                                                                    	if(gE('sL').value=='1')
                                                                        	return '';
                                                                    	return '<a href="javascript:dispararAccion(\''+val+'\')"><img src="../images/right1.png" title="Disparar acci&oacute;n" alt="Disparar acci&oacute;n" /></a>'
                                                                    }
                                                        }
                                                        
                                                    ]
                                                );
                                                
    var tblGrid=	new Ext.grid.GridPanel	(
                                                        {
                                                            id:'gridAccionesDisponibles',
                                                            store:alDatos,
                                                            region:'center',
                                                            frame:false,
                                                            cm: cModelo,
                                                            disabled:(gE('sL').value=='1'),
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            columnLines : true,  
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

function dispararAccion(cadConf)
{
	var cadObj=bD(cadConf);
    var oConf=eval('['+cadObj+']')[0];
    var dConf=oConf.objConf;
    if(oConf.ejecutarFuncion.indexOf('(')!==-1)
    {
    	eval(oConf.ejecutarFuncion+';');
    }
    else
    	eval(oConf.ejecutarFuncion+'(dConf);');
}

function crearGridHistorialAcciones()
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name: 'idRegistro'},
                                                        {name: 'iFormulario'},
		                                                {name: 'iRegistro'},
		                                                {name: 'etiqueta'},
                                                        {name: 'situacion'},
                                                        {name: 'actor'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../paginasFunciones/funcionesModulosEspeciales_SGP.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'idRegistro', direction: 'ASC'},
                                                            groupField: 'etiqueta',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='22';
                                        proxy.baseParams.iE=bE(gE('idEventoAudiencia').value);
                                        
                                        
                                    }
                        )   
       
    
    
        
       
    var cModelo= new Ext.grid.ColumnModel   	(
                                                    [
                                                        
                                                        
                                                        {
                                                            header:'Acci&oacute;n',
                                                            width:200,
                                                            sortable:true,
                                                            dataIndex:'etiqueta',
                                                            renderer:mostrarValorDescripcion
                                                        },
                                                        {
                                                            header:'Situaci&oacute;n',
                                                            width:300,
                                                            sortable:true,
                                                            dataIndex:'situacion',
                                                            renderer:mostrarValorDescripcion
                                                        }
                                                        
                                                    ]
                                                );
                                                
    var tblGrid=	new Ext.grid.GridPanel	(
                                                        {
                                                            id:'gridHistorialAcciones',
                                                            store:alDatos,
                                                            region:'center',
                                                            frame:false,
                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            columnLines : true,  
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
                                                    

		tblGrid.on('rowdblclick',function(grid,rowIndex)
                              {
                              		var registro=grid.getStore().getAt(rowIndex);
                                    var obj={};
                                    var params=[['idRegistro',registro.data.iRegistro],['idFormulario',registro.data.iFormulario],['dComp',bE('auto')],['actor',bE(registro.data.actor)]];
                                    obj.ancho='100%';
                                    obj.alto='100%';
                                    obj.url='../modeloPerfiles/vistaDTDv3.php';
                                    obj.params=params;
                                    obj.modal=true;
                                    abrirVentanaFancy(obj);
                              }
                  )                                                    
                               

	                  
    return 	tblGrid;
}

function recargarGrids()
{
	//gEx('gridHistorialAcciones').getStore().reload();
    //gEx('arbolProcesos').getStore().reload();
    if(gEx('gridCarpetaAdministrativa'))
	    gEx('gridCarpetaAdministrativa').getStore().reload();
    if(gEx('gridAudiencias'))
    	gEx('gridAudiencias').getStore().reload();   
    if(gEx('gDocumentosGenerados'))
    	gEx('gDocumentosGenerados').getStore().reload();
    
    
}

function regresar1Pagina()
{
	recargarGrids();
}

function regresar2Pagina()
{
	recargarGrids();
	
}

function recargarContenedorCentral()
{
	recargarGrids();

    
}

function regresar1PaginaContenedor()
{
	recargarGrids();
}

function regresarPagina2Contenedor()
{
	recargarGrids();
}

function regresarContenedorCentral()
{
	recargarGrids();

}

function crearGridEventos()
{

	 var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name: 'idEvento'},
                                                        {name: 'carpetaAdministrativa'},
		                                                {name: 'fechaEvento', type:'date', dateFormat:'Y-m-d'},
		                                                {name: 'horaInicial', type:'date', dateFormat:'Y-m-d H:i:s'},
		                                               	{name: 'horaFinal', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name: 'horaInicialReal', type:'date', dateFormat:'Y-m-d H:i:s'},
		                                               	{name: 'horaFinalReal', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name: 'urlMultimedia'},
                                                        {name: 'tipoAudiencia'},
                                                        {name: 'sala'},
                                                        {name: 'unidadGestion'},
                                                        {name: 'situacion'},
                                                        {name: 'juez'}  ,
                                                        {name: 'tImputados' },
                                                        {name: 'iFormulario' }, 
                                                        {name: 'iRegistro' },
                                                        {name: 'iFormularioSituacion'},                                                     
                                                        {name: 'iRegistroSituacion'},
                                                        {name: 'notificacionMAJO'},
                                                        {name: 'mensajeMAJO'},
                                                        {name: 'delitos'} ,
                                                        {name: 'edificio'}, 
                                                        {name: 'carpetaInvestigacion'},        
                                                        {name: 'imputado'},
                                                        {name: 'recursosAdicionales'},
                                                        {name: 'notificacionCabina'},
                                                        {name: 'mensajeCabina'} ,    
														{name: 'notificacionMail'},
                                                        {name: 'mensajeMail'},
                                                        {name: 'audienciaVirtual'}    
                                                        
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../paginasFunciones/funcionesModulosEspeciales_SGP.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'fechaEvento', direction: 'ASC'},
                                                            groupField: 'fechaEvento',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	if(gEx('btnNewAudiencia'))
	                                    	gEx('btnNewAudiencia').disable();
                                        
                                        if(gEx('btnAccionesAudiencias'))
                                        	gEx('btnAccionesAudiencias').disable();
                                        if(!nodoCarpetaSel) 
                                        {
                                        	nodoCarpetaSel={};
                                        	nodoCarpetaSel.id=gE('carpetaAdministrativa').value+'_'+gE('idCarpetaAdministrativa').value;
                                            nodoCarpetaSel.attributes={};
                                            nodoCarpetaSel.attributes.iCarpeta=gE('idCarpetaAdministrativa').value;
                                        }
                                        
                                        var arrCarpeta=nodoCarpetaSel.id.split('_');
                                        
                                        if(arrCarpeta[0]==gE('carpetaAdministrativa').value)
                                        {
                                        	if(gEx('btnNewAudiencia'))
                                        		gEx('btnNewAudiencia').enable();
                                            if(gEx('btnAccionesAudiencias'))
                                        		gEx('btnAccionesAudiencias').enable();
                                        }
                                    	proxy.baseParams.funcion='53';
                                        proxy.baseParams.cJ=arrCarpeta[0];
                                        proxy.baseParams.idCarpetaAdministrativa=<?php echo  $registrarIDCarpeta?"arrCarpeta[1]":"-1"?>;

                                        if(gEx('btnConfirmarAudiencia'))
	                                        gEx('btnConfirmarAudiencia').disable();
                                    }
                        )   
       
       
       var filters = new Ext.ux.grid.GridFilters	(
                                                        {
                                                            filters:	[
                                                            				{
                                                                            	type:'string',
                                                                                dataIndex:'carpetaAdministrativa'
                                                                            },
                                                                            {
                                                                            	type:'date',
                                                                                dataIndex:'fechaEvento'
                                                                            },
                                                                            {
                                                                            	type:'list',
                                                                                dataIndex:'tipoAudiencia',
                                                                                options:arrAudiencias,
                                                                                phpMode:true
                                                                            },
                                                                            {
                                                                            	type:'list',
                                                                                dataIndex:'sala',
                                                                                options:arrSalasBusqueda,
                                                                                phpMode:true
                                                                            },
                                                                            {
                                                                            	type:'list',
                                                                                dataIndex:'edificio',
                                                                                options:arrEdificios,
                                                                                phpMode:true
                                                                            },
                                                                            {
                                                                            	type:'string',
                                                                                dataIndex:'juez'
                                                                            }
                                                            			]
                                                        }
                                                    );  
       
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer({width:40}),
                                                            {
                                                                header:'ID Evento',
                                                                width:70,
                                                                sortable:true,
                                                                dataIndex:'idEvento',
                                                                renderer:function(val)
                                                                		{
                                                                        	<?php
																			if(($tipoMateria=="F")||($tipoMateria=="C")||($tipoMateria=="PT")||($tipoMateria=="SCC"))
																				echo "return val; ";
																			?>
                                                                        	if(gE('sL').value=='1')
                                                                            	return val;
                                                                                
                                                                            if(nodoCarpetaSel.id!=(gE('carpetaAdministrativa').value+'_'+gE('idCarpetaAdministrativa').value))    
                                                                            	return val;
                                                                                
                                                                        	return '<a href="javascript:abrirTableroAudiencia(\''+bE(val)+'\')">'+val+'</a>';
                                                                        }
                                                                
                                                            },
                                                            
                                                            
                                                            {
                                                                header:'',
                                                                width:30,
                                                                sortable:true,
                                                                align:'center',
                                                                dataIndex:'situacion',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	var icono='';
                                                                            meta.attr='style="padding: 0px !important;"';
                                                                        	icono=formatearValorRenderer(arrSemaforo,val);    
                                                                            var tamano=formatearValorRenderer(arrSemaforo,val,2);                                                                            
                                                                            return '<img src="'+icono+'" width="'+tamano+'" height="'+tamano+'" title="'+formatearValorRenderer(arrSituacionEvento,val)+'" alt="'+formatearValorRenderer(arrSituacionEvento,val)+'">';
                                                                        }
                                                            },
                                                             {
                                                                header:'Situaci&oacute;n audiencia',
                                                                width:150,
                                                                sortable:true,
                                                                dataIndex:'situacion',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        
                                                                        	var comp='';
                                                                            /*if(registro.data.iRegistroSituacion!='-1')
                                                                            {
                                                                            	comp='<a href="javascript:abrirFormatoRegistro(\''+bE(registro.data.iFormularioSituacion)+'\',\''+
                                                                                		bE(registro.data.iRegistroSituacion)+'\')"><img src="../images/magnifier.png" title="Ver detalles..."'+
                                                                                        ' alt="Ver detalles..."></a> ';
                                                                            }*/
                                                                        	return comp+mostrarValorDescripcion(formatearValorRenderer(arrSituacionEvento,val));
                                                                        }
                                                            },
                                                            
                                                            {
                                                                header:'',
                                                                width:60,
                                                                sortable:true,
                                                                dataIndex:'situacion',
                                                                css:'text-align:left;vertical-align:middle !important;',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	
                                                                            var comp2='';
                                                                            
                                                                            
                                                                           	switch(val)
                                                                            {
                                                                            	case '4':
                                                                                	if(registro.data.urlCanal!='')
                                                                                		comp2='<a href="javascript:abrirVentanaSala(\''+bE(registro.data.sala)+'\')"><img src="../images/film_go.png" title="Visualizar audiencia" alt="Visualizar audiencia" /></a>'
                                                                                break;
                                                                                case '2':
                                                                                	if(registro.data.urlMultimedia!='')
                                                                                		comp2='<a href="javascript:abrirVideoGrabacion(\''+bE(registro.data.idEvento)+'\')"><img src="../images/control_play_blue.png" title="Visualizar grabaci&oacute;n" alt="Visualizar grabaci&oacute;n" /></a>'
                                                                              	break;
                                                                            }
                                                                            
                                                                            var comp='';
                                                                            if(registro.data.iRegistroSituacion!='-1')
                                                                            {
                                                                            	comp='<a href="javascript:abrirFormatoRegistro(\''+bE(registro.data.iFormularioSituacion)+'\',\''+
                                                                                		bE(registro.data.iRegistroSituacion)+'\')"><img src="../images/magnifier.png" title="Ver detalles..."'+
                                                                                        ' alt="Ver detalles..."></a> ';
                                                                            
                                                                            	if(comp2!='')
                                                                                	comp='&nbsp;&nbsp;'+comp;
                                                                            }
                                                                            
                                                                        	return comp2+comp;
                                                                        	
                                                                        }
                                                            },
                                                            {
                                                                header:etiquetaCarpeta,
                                                                width:150,
                                                                sortable:true,
                                                                hidden:true,
                                                                dataIndex:'carpetaAdministrativa'
                                                            },
                                                            {
                                                                header:'Fecha de <br>la audiencia',
                                                                width:110,
                                                                align:'center',
                                                                sortable:true,
                                                                dataIndex:'fechaEvento',
                                                                renderer:function(val)
                                                                	{
                                                                    	return val.format('d/m/Y');
                                                                    }
                                                            },
                                                            {
                                                                header:'Hora programada de audiencia',
                                                                width:280,
                                                                sortable:true,
                                                                dataIndex:'horaInicial',
                                                                renderer:function(val,meta,registro)
                                                                	{
                                                                    	var comp='';
                                                                        if(val.format('d')!=registro.data.horaFinal.format('d'))
                                                                        {
                                                                        	comp=' del '+registro.data.horaFinal.format('d/m/Y');
                                                                        }

                                                                    	return 'De las '+val.format('H:i')+' hrs. a las '+registro.data.horaFinal.format('H:i')+' hrs.'+comp
                                                                    }
                                                            },
                                                            <?php
															if(($tipoMateria!="SCC") &&((existeRol("'69_0'"))||(existeRol("'1_0'"))||(existeRol("'107_0'"))||existeRol("'112_0'")||existeRol("'81_0'")||existeRol("'152_0'")||existeRol("'26_0'")))
															{
															?>
                                                            {
                                                                header:'Notificacion<br>Videograbaci&oacute;n',
                                                                width:110,
                                                                align:'center',
                                                                hidden:gE('sL').value=='1',
                                                                sortable:true,
                                                                dataIndex:'notificacionMAJO',
                                                                renderer:function(val,meta,registro)
                                                                	{
                                                                    	
                                                                        if(registro.data.audienciaVirtual=='1')
                                                                        	return '--';
                                                                        
                                                                    	if(nodoCarpetaSel.id!=gE('carpetaAdministrativa').value+'_'+gE('idCarpetaAdministrativa').value)
                                                                        	return;
                                                                    	var comp='';
                                                                        var icono='';
                                                                    	if(val=='1')
                                                                        {
                                                                        	icono='icon_big_tick.gif';
                                                                            registro.data.mensajeMAJO='Enviado MAJO con &eacute;xito';
                                                                        }
                                                                        else
                                                                        {
                                                                        	if(val=='')
                                                                            {
                                                                            	icono='icon_info.gif';
                                                                                registro.data.mensajeMAJO='Sin registro en bit&aacute;cora';

                                                                            }
                                                                            else
                                                                        		icono='cross.png';
                                                                        }
                                                                        
                                                                        
                                                                        
                                                                        return '<a href="javascript:reenviarMAJO(\''+bE(registro.data.idEvento)+'\')"><img src="../images/arrow_refresh.PNG" title="Reenviar a MAJO" alt="Reenviar a MAJO"/></a>&nbsp;&nbsp;<img src="../images/'+icono+
                                                                        	'" title="'+cv(registro.data.mensajeMAJO,true,true)+'" alt="'+cv(registro.data.mensajeMAJO,true,true)+'" />'+comp;
                                                                    }
                                                            },
                                                            {
                                                                header:'Notificacion<br>Cabina',
                                                                width:110,
                                                                align:'center',
                                                                hidden:gE('sL').value=='1',
                                                                sortable:true,
                                                                dataIndex:'notificacionCabina',
                                                                renderer:function(val,meta,registro)
                                                                	{
                                                                    	if(registro.data.recursosAdicionales=='')
                                                                        {
                                                                        	return '--';
                                                                        }
                                                                    	if(nodoCarpetaSel.id!=gE('carpetaAdministrativa').value+'_'+gE('idCarpetaAdministrativa').value)
                                                                        	return;
                                                                    	var comp='';
                                                                        var icono='';
                                                                    	if(val=='1')
                                                                        {
                                                                        	icono='icon_big_tick.gif';
                                                                            registro.data.mensajeMAJO='Enviado a Cabina con &eacute;xito';
                                                                        }
                                                                        else
                                                                        {
                                                                        	if(val=='')
                                                                            {
                                                                            	icono='icon_info.gif';
                                                                                registro.data.mensajeMAJO='Sin registro en bit&aacute;cora';

                                                                            }
                                                                            else
                                                                        		icono='cross.png';
                                                                        }
                                                                        
                                                                        
                                                                        
                                                                        return '<a href="javascript:reenviarCabina(\''+bE(registro.data.idEvento)+'\')"><img src="../images/arrow_refresh.PNG" title="Reenviar a Cabina" alt="Reenviar a Cabina"/></a>&nbsp;&nbsp;<img src="../images/'+icono+
                                                                        	'" title="'+cv(registro.data.mensajeCabina,true,true)+'" alt="'+cv(registro.data.mensajeCabina,true,true)+'" />'+comp;
                                                                    }
                                                            },
                                                            <?php
															}
															
															if($tipoMateria=="PT")
															{
															?>
                                                            {
                                                                header:'Notificacion Mail',
                                                                width:150,
                                                                align:'center',
                                                                
                                                                sortable:true,
                                                                dataIndex:'notificacionMail',
                                                                renderer:function(val,meta,registro)
                                                                	{
                                                                    	if((parseInt(registro.data.situacion)!=1)&&(parseInt(registro.data.situacion)!=3))
                                                                        {
                                                                        	return '----';
                                                                        }
                                                                    	
                                                                    	var comp='';
                                                                        var icono='';
                                                                    	if(val=='1')
                                                                        {
                                                                        	icono='icon_big_tick.gif';
                                                                            registro.data.mensajeMAJO='E-mail de notificaci&oacute;n enviado con &eacute;xito';
                                                                        }
                                                                        else
                                                                        {
                                                                        	if(val=='')
                                                                            {
                                                                            	icono='icon_info.gif';
                                                                                registro.data.mensajeMAJO='Sin registro en bit&aacute;cora';

                                                                            }
                                                                            else
                                                                        		icono='cross.png';
                                                                        }
                                                                        
                                                                        
                                                                        
                                                                        return '<a href="javascript:reenviarNotificacionMail(\''+bE(registro.data.idEvento)+'\')"><img src="../images/arrow_refresh.PNG" title="Reenviar Notificación Mail" alt="Reenviar Notificación Mail"/></a>&nbsp;&nbsp;<img src="../images/'+icono+
                                                                        	'" title="'+cv(registro.data.mensajeMail,true,true)+'" alt="'+cv(registro.data.mensajeMail,true,true)+'" />'+comp;
                                                                    }
                                                            },
                                                            <?php
															}
														 	if($tipoMateria=="P")
															{
																
															?>
                                                            {
                                                                header:'Notificacion<br>DEGT',
                                                                width:110,
                                                                align:'center',
                                                                sortable:true,
                                                                dataIndex:'notificacionMAJO',
                                                                renderer:function(val,meta,registro)
                                                                	{
                                                                    	if(registro.data.audienciaVirtual=='1')
                                                                        	return 	'<img src="../images/icon_big_tick.gif" title="Enviado a DEGT co &eacute;xito" alt="Enviado a DEGT co &eacute;xito">';
                                                                        
                                                                        return '--';
                                                                    	
                                                                    }
                                                            },
                                                            <?php
															}
															?>
                                                            {
                                                                header:'Hora de realizaci&oacute;n de audiencia',
                                                                width:280,
                                                                hidden:<?php echo $tipoMateria=="PT"?"true":"false"?>,
                                                                sortable:true,
                                                                dataIndex:'horaInicialReal',
                                                                renderer:function(val,meta,registro)
                                                                	{
                                                                    	if(!val)
                                                                        {
                                                                        	return '(Datos no disponibles)';
                                                                        }
                                                                    	var comp='';
                                                                        if(val.format('d')!=registro.data.horaFinalReal.format('d'))
                                                                        {
                                                                        	comp=' del '+registro.data.horaFinalReal.format('d/m/Y');
                                                                        }

                                                                    	return 'De las '+val.format('H:i')+' hrs. a las '+registro.data.horaFinalReal.format('H:i')+' hrs.'+comp
                                                                    }
                                                            },
                                                            {
                                                                header:'Tipo de audiencia',
                                                                width:350,
                                                                sortable:true,
                                                                dataIndex:'tipoAudiencia',
                                                                renderer:function(val)
                                                                		{
                                                                        
                                                                        	return mostrarValorDescripcion(formatearValorRenderer(arrAudiencias,val));
                                                                        }
                                                            },
                                                            {
                                                                header:'Edificio',
                                                                width:250,
                                                                sortable:true,
                                                                dataIndex:'edificio',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	var lblSala=mostrarValorDescripcion(formatearValorRenderer(arrEdificios,val));
                                                                            
                                                                            
                                                                            
                                                                        	return lblSala;
                                                                        }
                                                            },
                                                            
                                                            {
                                                                header:'Sala',
                                                                width:220,
                                                                sortable:true,
                                                                dataIndex:'sala',
                                                                renderer:function(val)
                                                                		{
                                                                        	return mostrarValorDescripcion(formatearValorRenderer(arrSalas,val));
                                                                        }
                                                            },
                                                            <?php
																if($tipoMateria=="P")
																{
															?>
                                                            
                                                            {
                                                                header:'Recursos adicionales',
                                                                width:250,
                                                                sortable:true,
                                                                dataIndex:'recursosAdicionales',
                                                                renderer:function(val)
                                                                		{
                                                                        	return val;
                                                                        }
                                                            },
                                                            <?php
																}
															?>
                                                            {
                                                                header:<?php echo ($tipoMateria=="SCC"?"'Magistrado'":"tipoCarpetaAdministrativa=='8'?'Magistrado':'Juez'"); ?>,
                                                                width:320,
                                                                sortable:true,
                                                                dataIndex:'juez',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	var etiqueta='';
                                                                            
                                                                            <?php 
																				if(((existeRol("'1_0'"))||(existeRol("'69_0'"))||(existeRol("'81_0'"))||(existeRol("'12_0'")))&&($tipoMateria!="SCC"))
																				{
																			?>
                                                                        	if(registro.data.tCambioJuez!='0')
                                                                            {
                                                                            	etiqueta+='<a href="javascript:mostrarVentanaHistorialAudiencia(\''+bE(registro.data.idEvento)+'\')"><img src="../images/report.png" width="13" height="13" title="ver historial de cambios de juez" alt="ver historial de cambios de juez"/></a>&nbsp;&nbsp;';
                                                                            }
                                                                            <?php
																				}
																			?>
                                                                            return etiqueta+val;
                                                                        	
                                                                        }
                                                            }
                                                            
                                                            <?php
                                                            if(($tipoMateria=="P")&&($tipoCarpetaAdministrativa!=8))
															{
															?>,
                                                            {
                                                            	header:'Total imputados',
                                                                width:120,
                                                                sortable:true,
                                                                dataIndex:'tImputados'
                                                            },
                                                            {
                                                            	header:'Imputados',
                                                                width:400,
                                                                sortable:true,
                                                                dataIndex:'imputado',
                                                                renderer:mostrarValorDescripcion
                                                            },
                                                            {
                                                            	header:'Delitos',
                                                                width:400,
                                                                sortable:true,
                                                                dataIndex:'delitos',
                                                                renderer:mostrarValorDescripcion
                                                            },
                                                            {
                                                            	header:'Carpeta de investigaci&oacute;n',
                                                                width:400,
                                                                sortable:true,
                                                                dataIndex:'carpetaInvestigacion',
                                                                renderer:mostrarValorDescripcion
                                                            }
                                                           <?php
															}
														   ?>
                                                            
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gridAudiencias',
                                                                store:alDatos,
                                                                region:'center',
                                                                title:'Historial de audiencias',
                                                                frame:false,
                                                                cm: cModelo,
                                                                stripeRows :false,
                                                                loadMask:true,
                                                                columnLines : true,      
                                                                plugins:	[filters],
                                                                tbar:	[
                                                                			<?php
																			if( ($tipoMateria=="SCC") || (existeRol("'69_0'"))||(existeRol("'1_0'"))||(existeRol("'170_0'"))||existeRol("'112_0'")||existeRol("'81_0'")||existeRol("'54_0'")||existeRol("'152_0'")||existeRol("'26_0'")||existeRol("'207_0'")||existeRol("'154_0'"))
																			{
																			?>
                                                                            {
                                                                                icon:'../images/calendar_edit.jpg',
                                                                                cls:'x-btn-text-icon',
                                                                                id:'btnNewAudiencia',
                                                                                hidden:gE('sL').value=='1',
                                                                                text:'Programar nueva audiencia',
                                                                                handler:function()
                                                                                        {
                                                                                        	<?php
																							if($tipoCarpetaAdministrativa!=8)
																							{
																								if($tipoMateria=="PT")
																									echo "registrarNuevaSolicitudAudienciaPenalTradicional(); ";
																								else
																									echo "registrarNuevaSolicitudAudiencia();   ";
																							}
																							else
																							{
																								echo "registrarNuevaSolicitudAudienciaAlzada();  ";
																							}
																							?>
                                                                                            
                                                                                         	  
                                                                                        }
                                                                                
                                                                            },'-',
                                                                            {
                                                                            	id:'btnAccionesAudiencias',
                                                                                icon:'../images/addAccion.png',
                                                                                cls:'x-btn-text-icon',
                                                                                hidden:gE('sL').value=='1',
                                                                                text:'Acciones audiencia',
                                                                                menu:	[
                                                                                			{
                                                                                            	id:'btnConfirmarAudiencia',
                                                                                                icon:formatearValorRenderer(arrSemaforo,'1'),
                                                                                                cls:'x-btn-text-icon',
                                                                                                disabled:true,
                                                                                                text: tipoCarpetaAdministrativa!='8'?'Confirmar/Modificar audiencia':'Modificar audiencia',
                                                                                                handler:function()
                                                                                                        {
                                                                                                        	
                                                                                                        	
                                                                                                        	var fila;
                                                                                                            
                                                                                                            fila=gEx('gridAudiencias').getSelectionModel().getSelected();
                                                                                                            
                                                                                                            <?php
																												if($tipoMateria=="PT")
																												{
																											?>
                                                                                                            		var obj={};    
                                                                                                                    obj.ancho='100%';
                                                                                                                    obj.alto='100%';
                                                                                                                    obj.url='../modulosEspeciales_SGJP/tblAgendaEventosPenalTradicional.php';
                                                                                                                    obj.params=[['idFormulario',185],['idRegistro',fila.data.iRegistro]	];
                                                                                                                    abrirVentanaFancy(obj);
                                                                                                                    return;
                                                                                                            <?php

																												}
																											?>
                                                                                                            
                                                                                                            
                                                                                                            if(tipoCarpetaAdministrativa=='8')
                                                                                                            {
                                                                                                            	var obj={};
                                                                                                                obj.ancho='100%';
                                                                                                                obj.alto='100%';
                                                                                                                obj.params=[['idEvento',fila.data.idEvento]];
                                                                                                                obj.url='../modulosEspeciales_SGJP/tblAgendaEventosAlzada.php';
                                                                                                                abrirVentanaFancy(obj);
                                                                                                                return;
                                                                                                            }
                                                                                                            var obj={};    
                                                                                                            obj.ancho='100%';
                                                                                                            obj.alto='100%';
                                                                                                            obj.url='../modeloPerfiles/vistaDTDv3.php';
                                                                                                            
                                                                                                            
                                                                                                            function funcAjax()
                                                                                                            {
                                                                                                                var resp=peticion_http.responseText;
                                                                                                                arrResp=resp.split('|');
                                                                                                                if(arrResp[0]=='1')
                                                                                                                {
                                                                                                                    var actor=arrResp[1];
                                                                                                                    
                                                                                                                    obj.params=[['idEventoReferencia',-1],['carpetaAdministrativa','<?php echo $carpetaAdministrativa?>'],['idFormulario',fila.data.iFormulario],['idRegistro',fila.data.iRegistro],['idReferencia',-1],
                                                                                                                            ['dComp',bE('auto')],['actor',bE(actor)]];
                                                                                                                    abrirVentanaFancy(obj);
                                                                                                                }
                                                                                                                else
                                                                                                                {
                                                                                                                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                                }
                                                                                                            }
                                                                                                            obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=108&iF='+fila.data.iFormulario+
                                                                                                            '&iR='+fila.data.iRegistro+'&r='+rolSalas,true);
                                                                                                            
                                                                                                            
                                                                                                        }
                                                                                                
                                                                                            }
                                                                                            
                                                                                            
                                                                                            ,'-',
                                                                                            {
                                                                                            	id:'btnFinalizarAudiencia',
                                                                                                icon:formatearValorRenderer(arrSemaforo,'2'),
                                                                                                cls:'x-btn-text-icon',
                                                                                                disabled:true,
                                                                                                text:'Registrar finalizaci&oacute;n de audiencia',
                                                                                                handler:function()
                                                                                                        {
                                                                                                        	var fila;
                                                                                                            
                                                                                                            fila=gEx('gridAudiencias').getSelectionModel().getSelected();
                                                                                                            
                                                                                                            mostrarVentanaFinalizarAudiencia(fila);
                                                                                                        }
                                                                                                
                                                                                            },
                                                                                            <?php
																							if(($tipoCarpetaAdministrativa!=8)&&($tipoCarpetaAdministrativa=="P"))
																							{
																							?>
                                                                                            '-',
                                                                                            {
                                                                                            	id:'btnRegistrarAcuerdo',
                                                                                                icon:formatearValorRenderer(arrSemaforo,'6'),
                                                                                                cls:'x-btn-text-icon',
                                                                                                disabled:true,
                                                                                                text:'Registrar resoluci&oacute;n mediante acuerdo',
                                                                                                handler:function()
                                                                                                        {
                                                                                                        	var fila;
                                                                                                            
                                                                                                            fila=gEx('gridAudiencias').getSelectionModel().getSelected();
                                                                                                            
                                                                                                            mostrarVentanaFinalizarPorAcuerdo(fila);
                                                                                                        }
                                                                                                
                                                                                            }
                                                                                            ,
                                                                                            <?php
																							}
																							?>
                                                                                            '-',
                                                                                            {
                                                                                            	id:'btnCancelarAudiencia',
                                                                                                icon:formatearValorRenderer(arrSemaforo,'3'),
                                                                                                cls:'x-btn-text-icon',
                                                                                                disabled:true,
                                                                                                text:'Cancelar audiencia',
                                                                                                handler:function()
                                                                                                        {
                                                                                                        	var fila;                                                                                                            
                                                                                                            fila=gEx('gridAudiencias').getSelectionModel().getSelected();                                                                                                            
                                                                                                            mostrarVentanaCancelarAudiencia(fila);
                                                                                                        }
                                                                                                
                                                                                            },'-',
                                                                                            {
                                                                                            	id:'btnModificarAudiencia',
                                                                                                icon:'../images/pencil.png',
                                                                                                cls:'x-btn-text-icon',
                                                                                                disabled:true,
                                                                                                hidden:true,
                                                                                                text:'Modificar audiencia',
                                                                                                handler:function()
                                                                                                        {
                                                                                                        	var fila;
                                                                                                            
                                                                                                            fila=gEx('gridAudiencias').getSelectionModel().getSelected();
                                                                                                            
                                                                                                            mostrarVentanaFinalizarAudiencia();
                                                                                                        }
                                                                                                
                                                                                            }
                                                                                            
                                                                                           
                                                                                            
                                                                                		]
                                                                                
                                                                            }
                                                                            <?php
																							}
																						   ?> 
                                                                        ],
                                                                view:new Ext.grid.GroupingView({
                                                                                                    forceFit:false,
                                                                                                    showGroupName: false,
                                                                                                    enableGrouping :true,
                                                                                                    enableNoGroups:false,
                                                                                                    enableGroupingMenu:false,
                                                                                                    hideGroupedColumn: false,
                                                                                                    startCollapsed:false
                                                                                                })
                                                            }
                                                        );

	tblGrid.getSelectionModel().on('rowselect',function(sm,nFila,registro)
    											{
                                                	if(gEx('btnConfirmarAudiencia'))
	                                                	gEx('btnConfirmarAudiencia').disable();

													if(gEx('btnFinalizarAudiencia'))
                                                    	gEx('btnFinalizarAudiencia').disable();
                                                    if(gEx('btnRegistrarAcuerdo'))
	                                                    gEx('btnRegistrarAcuerdo').disable();
                                                        
                                                    if(gEx('btnCancelarAudiencia'))    
	                                                    gEx('btnCancelarAudiencia').disable();
                                                    
                                                    if(gEx('btnModificarAudiencia'))
	                                                    gEx('btnModificarAudiencia').disable();
                                                    
                                                    switch(registro.data.situacion)
                                                    {
                                                    	case '0':  //En espera de confirmación
                                                        	if(gEx('btnConfirmarAudiencia'))
                                                        		gEx('btnConfirmarAudiencia').enable();
                                                            if(gEx('btnRegistrarAcuerdo'))
	                                                            gEx('btnRegistrarAcuerdo').enable();
                                                            if(gEx('btnCancelarAudiencia'))
	                                                            gEx('btnCancelarAudiencia').enable();
                                                            if(gEx('btnModificarAudiencia'))
	                                                            gEx('btnModificarAudiencia').enable();
                                                        break;
                                                        case '1':  //Confirmada
                                                        	if(gEx('btnRegistrarAcuerdo'))
                                                        		gEx('btnRegistrarAcuerdo').enable();
                                                            if(gEx('btnCancelarAudiencia'))
                                                            	gEx('btnCancelarAudiencia').enable();
                                                            if(gEx('btnConfirmarAudiencia'))
	                                                            gEx('btnConfirmarAudiencia').enable();
                                                            if(gEx('btnFinalizarAudiencia'))
	                                                            gEx('btnFinalizarAudiencia').enable();
                                                        break;
                                                        case '2':  //Finalizada
                                                        	
                                                        break;
                                                        case '3':  //Cancelado
                                                        	
                                                        break;
                                                        case '4':  //En desarrollo
                                                        	gEx('btnFinalizarAudiencia').enable();
                                                        break;
                                                        case '5':  //Pausada
                                                        	if(gEx('btnFinalizarAudiencia'))
                                                        		gEx('btnFinalizarAudiencia').enable();
                                                        break;
                                                        case '6':  //Resuelta por acuerdo
                                                        	
                                                        break;
                                                    }
                                                    
                                                }
    							)

	tblGrid.getSelectionModel().on('rowdeselect',function()
    											{
                                                	if(gEx('btnConfirmarAudiencia'))
                                                		gEx('btnConfirmarAudiencia').disable();
                                                    if(gEx('btnFinalizarAudiencia'))
	                                                    gEx('btnFinalizarAudiencia').disable();
                                                    if(gEx('btnRegistrarAcuerdo'))
	                                                    gEx('btnRegistrarAcuerdo').disable();
                                                    if(gEx('btnCancelarAudiencia'))
	                                                    gEx('btnCancelarAudiencia').disable();
                                                    if(gEx('btnModificarAudiencia'))
                                                    	gEx('btnModificarAudiencia').disable();
                                                }
    							)

        return 	tblGrid;

}

function registrarSolicitudAudiencia(iE,cA)
{
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            var obj={};    
            obj.ancho='100%';
            obj.alto='100%';
            obj.url='../modeloPerfiles/vistaDTDv3.php';
            obj.params=[['idEventoReferencia',bD(iE)],['carpetaAdministrativa',bD(cA)],['idFormulario',185],['idRegistro',arrResp[1]],['idReferencia',-1],
            		['dComp',arrResp[2]],['actor',arrResp[3]]];
            abrirVentanaFancy(obj);
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=52&iE='+bD(iE),true);
 
}

function registrarNuevaSolicitudAudiencia()
{
   	
 
 	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            var obj={};    
            obj.ancho='100%';
            obj.alto='100%';
            obj.url='../modeloPerfiles/vistaDTDv3.php';
            obj.params=[['idEventoReferencia',-1],['carpetaAdministrativa','<?php echo $carpetaAdministrativa?>'],['idFormulario',185],['idRegistro',arrResp[1]],['idReferencia',-1],
            		['dComp',arrResp[2]],['actor',arrResp[3]],['idCarpetaAdministrativa',gE('idCarpetaAdministrativa').value]];
            abrirVentanaFancy(obj);
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=54&cA=<?php echo $carpetaAdministrativa?>&iE=-1&idCarpeta='+gE('idCarpetaAdministrativa').value,true);
 
 
}

function mostrarVentanaAgregarDocumento()
{
	var arrCarpeta=nodoCarpetaSel.id.split('_');
    var iCarpetaAdministrativa=<?php echo  $registrarIDCarpeta?"arrCarpeta[1]":"-1"?>;
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:0,
                                                            y:0,
                                                            html:	'<span id="tblUpload">'+
                                                            		'<table width="720"><tr><td><div id="uploader"><p>Your browser doesn\'t have Flash, Silverlight or HTML5 support.</p></div></td></tr></table>'+
                                                                	'</span>'
                                                        }

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar documento a '+etiquetaCarpeta+':&nbsp;&nbsp;&nbsp;'+lblCarpeta,
										width: 750,
										height:350,
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
                                                                	$("#uploader").pluploadQueue({
                                    
                                                                                                    runtimes : 'html5,flash,silverlight,html4',
                                                                                                    url : "../modulosEspeciales_SGJP/procesarDocumentoCarpetaJudicial.php",
                                                                                                    prevent_duplicates:true,
                                                                                                    file_data_name:'archivoEnvio',
                                                                                                    multiple_queues:true,
                                                                                                    max_retries:10,
                                                                                                    
                                                                                                    
                                                                                                    
                                                                                                    
                                                                                                    multipart_params:	{
                                                                                                                            cA:arrCarpeta[0],
                                                                                                                            idCarpetaAdministrativa:iCarpetaAdministrativa
                                                                                                                        },
                                                                                                    
                                                                                                    rename : true,
                                                                                                    dragdrop: true,
                                                                                                    init:	{	
                                                                                                    	
                                                                                                                UploadComplete:function(up,archivos)
                                                                                                                                {
                                                                                                                                 	gEx('gridCarpetaAdministrativa').getStore().reload();
                                                                                                                                },
                                                                                                               	FileUploaded:function(up,archivos,response)
                                                                                                                				{
                                                                                                                                	
                                                                                                                                    if(response.response=='1|')
                                                                                                                                    {
                                                                                                                                    	up.removeFile(archivos);
                                                                                                                                    }
                                                                                                                                }
                                                                                                            },
                                                                                                    filters : 	{
                                                                                                                    // Maximum file size
                                                                                                                    max_file_size : '512mb',
                                                                                                                    // Specify what files to browse for
                                                                                                                    mime_types: [
                                                                                                                        {title : "Archivos de imagen", extensions : "jpg,gif,png"},
                                                                                                                        {title : "Documentos PDF", extensions : "pdf"}
                                                                                                                    ]
                                                                                                                },
                                                                                             
                                                                                                    // Resize images on clientside if we can
                                                                                                    resize: {
                                                                                                                width : 200,
                                                                                                                height : 200,
                                                                                                                quality : 90,
                                                                                                                crop: true // crop to exact dimensions
                                                                                                            },
                                                                                             
                                                                                             
                                                                                                    // Flash settings
                                                                                                    flash_swf_url : '../Scripts/plupload/js/Moxie.swf',
                                                                                                 
                                                                                                    // Silverlight settings
                                                                                                    silverlight_xap_url : '../Scripts/plupload/js/Moxie.xap'
                                                                                                });
																
                                                                	$("#uploader").bind('UploadComplete', function(up, files) 
                                                                                                          {
                                                                                                              // Called when all files are either uploaded or failed
                                                                                                              alert('ok');
                                                                                                         }
                                                                 
                                                                 						)
                                                                                                          
                                                                                                          
                                                                }
															}
												},
										buttons:	[
														{
															
															text: 'Cerrar',
                                                            
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

function crearArbolCarpetasJudiciales()
{
	var raiz=new  Ext.tree.AsyncTreeNode(
											{
												id:'-1',
												text:'Raiz',
												draggable:false,
												expanded :false,
												cls:'-1'
											}
										)
										
	var cargadorArbol=new Ext.tree.TreeLoader(
                                                {
                                                    baseParams:{
                                                                    funcion:'55',
                                                                    iE:-1,
                                                                    iCarpeta:gE('idCarpetaAdministrativa').value,
                                                                    cA:bE(gE('carpetaAdministrativa').value)
                                                                },
                                                    dataUrl:'../paginasFunciones/funcionesModulosEspeciales_SGP.php'
                                                }
                                            )		
										
	
    cargadorArbol.on('load',function(l,raiz)
    						{
                            	nodoCarpetaSel=buscarNodoID(raiz.childNodes[0],gE('carpetaAdministrativa').value+'_'+gE('idCarpetaAdministrativa').value);
                                nodoCarpetaSel.select();
                            	funcClickCarpetaJudicial(nodoCarpetaSel);
                            }
    				)
    											
										
	var arbolCarpetas=new Ext.tree.TreePanel	(
                                                            {
                                                                
                                                                id:'arbolCarpetas',
                                                                region:'west',
                                                                useArrows:true,
                                                                animate:true,
                                                                width:250,
                                                                title:'<?php echo $lblExpedientesAsociados?>',
                                                                enableDD:false,
                                                                ddScroll:true,
                                                                containerScroll: true,
                                                                autoScroll:true,
                                                                border:false,
                                                                root:raiz,
                                                                tbar:	[
                                                                            {
                                                                                icon:'../images/add.png',
                                                                                cls:'x-btn-text-icon',
                                                                                disabled:true,
                                                                                hidden:gE('sL').value=='1',
                                                                                id:'btnAdjuntar',
                                                                                text:'Adjuntar documentos',
                                                                                handler:function()
                                                                                        {
                                                                                            mostrarVentanaAgregarDocumento();
                                                                                        }
                                                                                
                                                                            }
                                                                        ],  
                                                                loader: cargadorArbol,
                                                                rootVisible:false
                                                            }
                                                        )
         
         
                                                    
	arbolCarpetas.on('click',funcClickCarpetaJudicial);	                                                    
                                                    
	return  arbolCarpetas;
}

function funcClickCarpetaJudicial(nodo, evento)
{
	lblCarpeta='';
	nodoCarpetaSel=nodo;
    
    var arrCarpeta=[];
    var nodoAux=nodo;
    arrCarpeta.push(nodoAux.id);
    while(nodoAux.parentNode.id!='-1')
    {
    	arrCarpeta.push(nodoAux.parentNode.id);
    	nodoAux=nodoAux.parentNode;
    }
    var arrDatosCarpeta='';
    var x;
    var color='030';
    for(x=arrCarpeta.length-1;x>=0;x--)
    {
    	arrDatosCarpeta=arrCarpeta[x].split('_');
    	if(x==0)
        	color='900';
    	if(lblCarpeta=="")
        	lblCarpeta='<span style="color:#'+color+'"><b>'+arrDatosCarpeta[0]+'</b></span>';
        else
        	lblCarpeta+='<span style="color:#F00"><b> >> </b></span> <span style="color:#'+color+'"><b>'+arrDatosCarpeta[0]+'</b></span>';
    }
    
    
	gEx('btnAdjuntar').enable();
    arrDatosCarpeta=nodoCarpetaSel.id.split('_');
    if(arrDatosCarpeta[0]!=gE('carpetaAdministrativa').value)
    	gEx('btnAdjuntar').disable();
    
    gE('lblCarpetaJudicial').innerHTML='&nbsp;&nbsp;&nbsp;<b>'+lblCarpeta+'</b>';
    gEx('gridCarpetaAdministrativa').getStore().reload();
    gEx('gridAudiencias').getStore().reload();
    
    
    
    
    
}

function removerDocumento(iD)
{
	var arrCarpeta=nodoCarpetaSel.id.split('_');
    var cAdministrativa=arrCarpeta[0];
    var iCarpetaAdministrativa=<?php echo  $registrarIDCarpeta?"arrCarpeta[1]":"-1"?>;
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
														{
                                                        	x:10,
                                                            y:10,
                                                            html:'Ingrese el motivo por el cual desea remover el documento'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            id:'txtMotivo',
                                                            xtype:'textarea',
                                                            width:500,
                                                            height:80
                                                        }

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Remover documento de '+etiquetaCarpeta.toLowerCase(),
										width: 550,
										height:210,
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
                                                                	gEx('txtMotivo').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
															handler: function()
																	{
																		var txtMotivo=gEx('txtMotivo');	
                                                                        if(txtMotivo.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	txtMotivo.focus();
                                                                            }
                                                                            msgBox('Debe ingresar el motivo por el cual desea remover el documento',resp);
                                                                            return;
                                                                        }
                                                                        
                                                                        
                                                                        function respQuestion(btn)
                                                                        {
                                                                        	if(btn=='yes')
                                                                            {
                                                                            	function funcAjax()
                                                                                {
                                                                                    var resp=peticion_http.responseText;
                                                                                    arrResp=resp.split('|');
                                                                                    if(arrResp[0]=='1')
                                                                                    {
                                                                                    	gEx('gridCarpetaAdministrativa').getStore().reload();
                                                                                        ventanaAM.close();
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                    }
                                                                                }
                                                                                obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=56&motivo='+cv(txtMotivo.getValue())+'&cA='+cAdministrativa+'&iD='+bD(iD),true);
                                                                                
                                                                            
                                                                            }
                                                                        }
                                                                        msgConfirm('Est&aacute; seguro de querer remover el documento <?php echo $tipoMateria=="P"?'de la carpeta judicial':'del expediente' ?>?',respQuestion);
                                                                        
                                                                        
                                                                        
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

function abrirProcesoOrigen(iF,iR)
{
	var obj={};
    obj.ancho='100%';
    obj.alto='100%';
    obj.url='../modeloPerfiles/vistaDTDv3.php';
    obj.params=[['idFormulario',bD(iF)],['idRegistro',bD(iR)],['actor',bE(0)],['dComp',bE('auto')]];
    abrirVentanaFancy(obj);
    
    
}

function mostrarVentanaFinalizarAudiencia(fila)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            var obj={};    
            obj.ancho='100%';
            obj.alto='100%';
            obj.url='../modeloPerfiles/vistaDTDv3.php';
            obj.params=[['idFormulario',321],['idRegistro',arrResp[1]],['idEvento',fila.data.idEvento],
            			['dComp',arrResp[2]],['actor',arrResp[3]]];
            abrirVentanaFancy(obj);
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=58&iFormulario=321&idEstadoIgn=2&iE='+fila.data.idEvento,true);
}

function mostrarVentanaFinalizarPorAcuerdo(fila)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            var obj={};    
            obj.ancho='100%';
            obj.alto='100%';
            obj.url='../modeloPerfiles/vistaDTDv3.php';
            obj.params=[['idFormulario',322],['idRegistro',arrResp[1]],['idEvento',fila.data.idEvento],
            			['dComp',arrResp[2]],['actor',arrResp[3]]];
            abrirVentanaFancy(obj);
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=58&iFormulario=322&iE='+fila.data.idEvento,true);
}

function mostrarVentanaCancelarAudiencia(fila)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            var obj={};    
            obj.ancho='100%';
            obj.alto='100%';
            obj.url='../modeloPerfiles/vistaDTDv3.php';
            obj.params=[['idFormulario',323],['idRegistro',arrResp[1]],['idEvento',fila.data.idEvento],
            			['dComp',arrResp[2]],['actor',arrResp[3]]];
            abrirVentanaFancy(obj);
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=58&iFormulario=323&iE='+fila.data.idEvento,true);
}

function mostrarVentanaModificarAudiencia(fila)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            var obj={};    
            obj.ancho='100%';
            obj.alto='100%';
            obj.url='../modeloPerfiles/vistaDTDv3.php';
            obj.params=[['idFormulario',324],['idRegistro',arrResp[1]],['idEvento',fila.data.idEvento],
            			['dComp',arrResp[2]],['actor',arrResp[3]]];
            abrirVentanaFancy(obj);
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=59&iFormulario=324&iE='+fila.data.idEvento,true);
}


function abrirFormatoRegistro(iF,iR)
{

	var obj={};    
    obj.ancho='100%';
    obj.alto='100%';
    obj.url='../modeloPerfiles/vistaDTDv3.php';
    obj.params=[['idFormulario',bD(iF)],['idRegistro',bD(iR)],
                ['dComp',bE('auto')],['actor',bE(0)]];
    abrirVentanaFancy(obj);
}

function abrirTableroAudiencia(iE)
{
	var obj={};
    obj.ancho='100%';
    obj.alto='100%';
    obj.url='../modulosEspeciales_SGJP/tableroAudiencia.php';
    obj.params=[['idEventoAudiencia',bD(iE)]];    

    abrirVentanaFancy(obj);
}

function reenviarMAJO(iE)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            gEx('gridAudiencias').getStore().reload();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=83&iE='+bD(iE),true);
}

function reenviarCabina(iE)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            gEx('gridAudiencias').getStore().reload();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=306&iE='+bD(iE),true);
}


function abrirVentanaSala(iS)
{
	var obj={};    
    obj.ancho='100%';
    obj.alto='100%';
    obj.url='../modulosEspeciales_SGJP/visorStreamSalaAudiencia.php';
    obj.params=[['idSala',iS],['cPagina','sFrm=true']]
    abrirVentanaFancy(obj);
}

function abrirVideoGrabacion(idEventoAudiencia)
{
	var obj={};    
    obj.ancho='100%';
    obj.alto='100%';
    obj.url='../modulosEspeciales_SGJP/visorGrabacionAudiencia.php';
    obj.params=[['idEvento',idEventoAudiencia],['cPagina','sFrm=true']]
    abrirVentanaFancy(obj);
}

function crearGridOrdenesNotificacion()
{
	var cmbSituacionOrdenes=crearComboExt('cmbSituacionOrdenes',arrSituacionOrden,0,0,300);
    cmbSituacionOrdenes.setValue('1,4');
    cmbSituacionOrdenes.on('select',function(cmb,registro)
    								{
                                    	gEx('gOrdenesNotificacion').getStore().reload();
                                    }
    						)
    
    
    
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idOrden'},
		                                                {name: 'folioOrden'},
		                                                {name: 'carpetaJudicial'},
		                                                {name:'idCarpeta'},
                                                        {name: 'fechaRegistro',  type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name: 'fechaDeterminacion', type:'date', dateFormat:'Y-m-d'},
                                                        {name: 'tipoNotificacion'},
                                                        {name: 'descripcionNotificacion'},
                                                        {name: 'solicitadoPor'},
                                                        {name: 'situacion'},
                                                        {name: 'notificadorAsignado'},
                                                        {name: 'comentariosAdicionales'},
                                                        {name: 'nombreDeterminacion'},
                                                        {name: 'idEventoDeriva'},
                                                        {name: 'actasFirmadas'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../paginasFunciones/funcionesModulosEspeciales_Notificaciones.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'folioOrden', direction: 'ASC'},
                                                            groupField: 'folioOrden',
                                                            remoteGroup:false,
				                                            remoteSort: true,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	gEx('btnRemover').disable();
                                        gEx('btnModificar').disable();
                                        gEx('btnModificarOrden').disable();
                                    	proxy.baseParams.funcion='10';
                                        proxy.baseParams.situacion=cmbSituacionOrdenes.getValue();
                                        proxy.baseParams.idFormulario=-1;
                                        proxy.baseParams.idRegistro=-1;
                                        proxy.baseParams.idCarpeta=gE('idCarpetaAdministrativa').value;
                                        proxy.baseParams.carpetaAdministrativa=gE('carpetaAdministrativa').value;
                                        
                                        
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer(),
                                                            {
                                                                header:'',
                                                                width:90,
                                                                sortable:true,
                                                                dataIndex:'idOrden',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	
                                                                        	if(registro.data.actasFirmadas!='')
                                                                            {
                                                                            	var arrOrdenes=registro.data.actasFirmadas.split(',');
                                                                                var comp='';
                                                                                var o='';
                                                                                var x;
                                                                                var noActa=1;
                                                                                for(x=0;x<arrOrdenes.length;x++)
                                                                                {
                                                                                	o='<a href="javascript:mostrarActaCircunstanciada(\''+bE(arrOrdenes[x])+'\')"><img src="../imagenesDocumentos/16/file_extension_pdf.png" title="Acta circunstaciada '+noActa+'" alt="Acta circunstaciada '+noActa+'"></a>';
                                                                                    if(comp=='')
                                                                                    	comp=o;
                                                                                    else
                                                                                    	comp+=' '+o;
                                                                                    noActa++;
                                                                                }
                                                                                
                                                                                return comp;

                                                                            }
                                                                        }
                                                            },
                                                            {
                                                                header:'Folio',
                                                                width:110,
                                                                sortable:true,
                                                                dataIndex:'folioOrden'
                                                            },
                                                            {
                                                                header:'Carpeta Judicial',
                                                                width:150,
                                                                sortable:true,
                                                                dataIndex:'carpetaJudicial'
                                                            },
                                                            {
                                                                header:'Fecha de solicitud',
                                                                width:140,
                                                                sortable:true,
                                                                dataIndex:'fechaRegistro',
                                                                renderer:function(val)
                                                                		{
                                                                        	return val.format('d/m/Y H:i');
                                                                        }
                                                            },
                                                            {
                                                                header:'Tipo notificaci&oacute;n',
                                                                width:220,
                                                                sortable:true,
                                                                dataIndex:'tipoNotificacion',
                                                                renderer:function(val)
                                                                		{
                                                                        	return formatearValorRenderer(arrTipoSolicitud,val);
                                                                        }
                                                            },
                                                            {
                                                                header:'Nombre determinaci&oacute;n/audiencia',
                                                                width:520,
                                                                sortable:true,
                                                                dataIndex:'descripcionNotificacion',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	meta.attr='style="height:auto !important;white-space: normal;line-height: 14px;"';
                                                                        	return mostrarValorDescripcion(val);
                                                                        	
                                                                        }
                                                            },
                                                            {
                                                                header:'Solicitado por',
                                                                width:250,
                                                                sortable:true,
                                                                dataIndex:'solicitadoPor',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	return mostrarValorDescripcion(val);
                                                                        	
                                                                        }
                                                            },
                                                            {
                                                                header:'Comentarios adicionales',
                                                                width:400,
                                                                sortable:true,
                                                                dataIndex:'comentariosAdicionales',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	return mostrarValorDescripcion(val);
                                                                        	
                                                                        }
                                                            },
                                                            
                                                            {
                                                                header:'Situaci&oacute;n',
                                                                width:320,
                                                                sortable:true,
                                                                dataIndex:'situacion',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	return formatearValorRenderer(arrSituacionOrden,val);
                                                                        	
                                                                        }
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gOrdenesNotificacion',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                border:true,
                                                                cm: cModelo,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                columnLines : true,   
                                                                tbar:	[
                                                                            {
                                                                            	xtype:'label',
                                                                                html:'&nbsp;&nbsp;<b>Mostrar &oacute;rdenes en situaci&oacute;n:</b>&nbsp;&nbsp;&nbsp;'
                                                                            },
                                                                            cmbSituacionOrdenes
                                                                            
                                                                        ] ,                                                            
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
                                                        
		tblGrid.getSelectionModel().on	('rowselect',function(sm,nFila,registro)
                                                    {
                                                        gEx('btnRemover').disable();
                                                        gEx('btnModificar').disable();
                                                        gEx('btnModificarOrden').disable();
                                                        
                                                        if(parseInt(registro.data.situacion)==1)
                                                        {
                                                        	if(registro.data.actasFirmadas=='')
	                                                            gEx('btnRemover').enable();
                                                            gEx('btnModificar').enable();
                                                            gEx('btnModificarOrden').enable();
                                                        }
                                                    }
                               			 )                                                        
                                                        
        return 	tblGrid;	
}

function visualizarActaCircunstanciada(iA)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var arrNombre=arrResp[2].split('.');
            extension=arrNombre[arrNombre.length-1];
            mostrarVisorDocumentoProceso(extension,arrResp[1]);
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=131&tD=214&iF=-1&iR='+bD(iA),true);
}

function crearGridGeneracionDocumentos()
{
	
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idDocumento'},
		                                                {name: 'tipoDocumento'},
		                                                {name:'descripcionDocumento'},
		                                                {name:'fechaCreacion', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name: 'responsableCreacion'},
                                                        {name: 'situacion'},
                                                        {name: 'plazoCumplimiento',type:'date', dateFormat:'Y-m-d'},
                                                        {name: 'modificaSituacionCarpeta'},
                                                        {name: 'situacionCarpeta'},
                                                        {name:'descripcionActuacion'},
                                                        {name:'categoriaDocumento'},
                                                        {name:'idDocumentoServidor'},
                                                        {name: 'documentoBloqueado'},
                                                        {name: 'lblAlertas'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
    
	var expander = new Ext.ux.grid.RowExpander({
                                                column:1,
                                                expandOnDblClick:false,
                                                tpl : new Ext.Template(
                                                    '<table >'+
														'<tr><td ><span class="TSJDF_Control"><b>Descripci&oacute;n de la actuaci&oacute;n:</b><br>{descripcionActuacion}</span><br /><br /></td></tr>'+
                                                   		'<tr><td ><span class="TSJDF_Control"><b>Alertas programadas:</b><br><br>{lblAlertas}</span><br /><br /></td></tr>'+
                                                    '</table>'
                                                )
                                            });                                                                                       
                                                                                                                                                                                                                                                          
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../paginasFunciones/funcionesModulosEspeciales_SGP.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'fechaCreacion', direction: 'ASC'},
                                                            groupField: 'fechaCreacion',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                   	
                                   		gEx('btnModifyDocument').disable();
                                   		gEx('btnDeleteDocument').disable();
                                    	proxy.baseParams.funcion='145';
                                        proxy.baseParams.cA=gE('carpetaAdministrativa').value;
                                        proxy.baseParams.idFormulario=-1;
                                        proxy.baseParams.idReferencia=-1;
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer(),
                                                            expander,
                                                            {
                                                                header:'',
                                                                width:30,
                                                                sortable:true,
                                                                dataIndex:'idDocumentoServidor',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	if(registro.data.documentoBloqueado=='1')
                                                                            {
                                                                            	return '<a href="javascript:visualizarDocumentoFinalizado(\''+bE(registro.data.idDocumento)+'\',\''+bE(registro.data.tipoDocumento)+'\')"><img src="../images/page_white_magnify.png" title="Visualizar documento" alt="Visualizar documento"/></a>';
                                                                            }
                                                                        }
                                                            },
                                                            {
                                                                header:'Fecha de creaci&oacute;n',
                                                                width:130,
                                                                sortable:true,
                                                                dataIndex:'fechaCreacion',
                                                                renderer:function(val)
                                                                		{
                                                                			return val.format('d/m/Y H:i:s')
                                                                		}
                                                            },
                                                            {
                                                                header:'Tipo de documento',
                                                                width:180,
                                                                sortable:true,
                                                                renderer:mostrarValorDescripcion,
                                                                dataIndex:'categoriaDocumento',
                                                                renderer:function(val)
                                                                		{
                                                                			return formatearValorRenderer(arrCategorias,val);
                                                                		}
                                                            },
                                                            {
                                                                header:'T&iacute;tulo del documento',
                                                                width:320,
                                                                sortable:true,
                                                                renderer:mostrarValorDescripcion,
                                                                dataIndex:'descripcionDocumento'
                                                            },
                                                            {
                                                                header:'Registrado por',
                                                                width:250,
                                                                sortable:true,
                                                                renderer:mostrarValorDescripcion,
                                                                dataIndex:'responsableCreacion'
                                                            },
                                                            {
                                                                header:'Situaci&oacute;n actual',
                                                                width:300,
                                                                sortable:true,
                                                                renderer:mostrarValorDescripcion,
                                                                dataIndex:'situacion'
                                                            },
                                                            {
                                                                header:'Plazo cumplimiento',
                                                                width:140,
                                                                sortable:true,
                                                                hidden:true,
                                                                dataIndex:'plazoCumplimiento',
                                                                renderer:function(val)
                                                                		{
                                                                			if(val)
                                                                				return val.format('d/m/Y');
                                                                			return 'N/A';
                                                                		}
                                                            },
                                                            {
                                                                header:'Modifica situaci&oacute;n carpeta',
                                                                width:250,
                                                                hidden:true,
                                                                sortable:true,
                                                                dataIndex:'modificaSituacionCarpeta',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                			var lblResultado=formatearValorRenderer(arrSiNo,val);
                                                                			if(val=='1')
                                                                			{
                                                                				lblResultado+=', '+formatearValorRenderer(arrStuacionCarpeta,registro.data.situacionCarpeta);
                                                                			}
                                                                			return lblResultado;
                                                                		}
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gDocumentos',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                title:'Generaci&oacute;n de documentos',
                                                                cm: cModelo,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                columnLines : true,
                                                                plugins:[expander] ,  
                                                                tbar:	[
																			{
																				icon:'../images/add.png',
																				cls:'x-btn-text-icon',
																				text:'Crear documento',
                                                                                hidden:gE('sL').value=='1',
																				handler:function()
																						{
                                                                                        	
                                                                                            mostrarVentanaAddDocumento();
                                                                                            

																							
																						}

																			},'-',
																			{
																				id:'btnModifyDocument',
																				icon:'../images/pencil.png',
																				cls:'x-btn-text-icon',
																				text:'Modificar documento',
                                                                                hidden:gE('sL').value=='1',
																				handler:function()
																						{
																							var fila=gEx('gDocumentos').getSelectionModel().getSelected();
																							if(!fila)
																							{
																								msgBox('Debe seleccionar el documento que desea modificar');
																								return;
																							}
																							var anchoVentana=(obtenerDimensionesNavegador()[1]*0.9);
                                                                                            var altoVentana=(obtenerDimensionesNavegador()[0]*0.9);
                                                                                            
																							objConf={
																										tipoDocumento:fila.data.tipoDocumento,
																										idFormulario:-2,
                                                                                                        rol:'158_0',
                                                                                                        ancho:anchoVentana,
                                                                                                        alto:altoVentana,
                                                                                                        rolDefault:'158_0',
																										idRegistro: fila.data.idDocumento,
																										functionAfterValidate:function()
																															{
																																gEx('gDocumentos').getStore().reload();
																															},
																										functionAfterTurn:function()
																															{
																																gEx('gDocumentos').getStore().reload();
																															},
																										functionAfterSaveDocument:function()
																														{
																															gEx('gDocumentos').getStore().reload();
																														},
                                                                                                       	functionAfterLoadDocument:function()
                                                                                                        						{
                                                                                                        							setTimeout(function()
                                                                                                       											{
                                                                                                       												var body = CKEDITOR.instances.txtDocumento.editable().$;
                                                                                                        											
																																					var value = (anchoVentana*100)/960;
                                                                                                                                                    

																																					body.style.MozTransformOrigin = "top left";
																																					body.style.MozTransform = "scale(" + (value/100)  + ")";

																																					body.style.WebkitTransformOrigin = "top left";
																																					body.style.WebkitTransform = "scale(" + (value/100)  + ")";

																																					body.style.OTransformOrigin = "top left";
																																					body.style.OTransform = "scale(" + (value/100)  + ")";

																																					body.style.TransformOrigin = "top left";
																																					body.style.Transform = "scale(" + (value/100)  + ")";
																																					// IE
																																					body.style.zoom = value/100;
                                                                                                      											
                                                                                                      												
                                                                                                       											},200
                                                                                                        									)
                                                                                                        							

																																	
                                                                                                        						}

																						 			};
																							
																							
																							mostrarVentanaGeneracionDocumentos(objConf);
																						}

																			},'-',
																			{
																				icon:'../images/delete.png',
																				id:'btnDeleteDocument',
																				cls:'x-btn-text-icon',
                                                                                hidden:gE('sL').value=='1',
																				text:'Remover documento',
																				handler:function()
																						{
																							var fila=gEx('gDocumentos').getSelectionModel().getSelected();
																							if(!fila)
																							{
																								msgBox('Debe seleccionar el documento que desea remover');
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
																											gEx('gDocumentos').getStore().reload();
																										}
																										else
																										{
																											msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
																										}
																									}
																									obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=146&iD='+fila.data.idDocumento,true);
																								}
																							}
																							msgConfirm('Est&aacute; seguro de querer remover el documento seleccionado?',resp);
																						}

																			}

																		]   ,                                                          
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
        
        
        
        tblGrid.getSelectionModel().on('rowselect',function(sm,nFila,registro)
       												{
       													gEx('btnModifyDocument').disable();
                                   						gEx('btnDeleteDocument').disable();
                                   						if(registro.data.documentoBloqueado=='0')
                                   						{
                                   							gEx('btnModifyDocument').enable();
                                   							gEx('btnDeleteDocument').enable();
                                   						}
       												}
        								)
        return 	tblGrid;
}

function mostrarVentanaAddDocumento(iDocumento,importarWord)
{
	if(iDocumento)
    {
    	nodoPlantillaSel={};
    	nodoPlantillaSel.id=iDocumento;
        nodoPlantillaSel.attributes={};
        
        var pos=existeValorMatriz(arrPlatillasDocumentos,iDocumento);
        
    	nodoPlantillaSel.attributes.perfilValidacion=arrPlatillasDocumentos[pos][2];
		nodoPlantillaSel.text=arrPlatillasDocumentos[pos][1];
    	mostrarVentanaDatosDocumento(importarWord?true:false,importarWord);
    	return;
    }
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'border',
											defaultType: 'label',
											items: 	[
                                            			crearArbolPlantillas(),
                                            			{
                                            				xtype:'panel',
                                            				region:'center',
                                            				layout:'absolute',
                                            				items: 	[
                                           								{
                                           									x:0,
                                           									y:0,
                                           									xtype:'label',
																			html:'<textarea id="txtDocumentoDemo"></textarea>'
                                           								}
                                            						]
                                            			}                               			
                                            			
                                            			
													]
										}
									);
	
    
    var anchoVentana=(obtenerDimensionesNavegador()[1]*0.9);
    var altoVentana=(obtenerDimensionesNavegador()[0]*0.9);
    
	var ventanaAM = new Ext.Window(
									{
										title: 'Crear documento',
                                        id:'wCreateDocumentDocument',
										width: anchoVentana,
										height:altoVentana,
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
																	var editor1=	CKEDITOR.replace('txtDocumentoDemo',
																										 {

																											customConfig:'../../modulosEspeciales_SGJP/Scripts/configCKEditorVistaPrevia.js',
																											width:anchoVentana-310,
																											height:altoVentana-100,
																											resize_enabled:false,
																											on:	{
																													instanceReady:function(evt)
																																{
																																	


																																}

																												}
																										 }
																						);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
															handler: function()
																	{
																		if(!nodoPlantillaSel)
																		{
																			msgBox('Debe seleccionar la plantilla a utilizar para generar el documento');
																			return;
																		}
																		ventanaAM.close();
																		mostrarVentanaDatosDocumento(null);
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

function crearArbolPlantillas()
{
	var raiz=new  Ext.tree.AsyncTreeNode(
											{
												id:'-1',
												text:'Raiz',
												draggable:false,
												expanded :false,
												cls:'-1'
											}
										)
										
	var cargadorArbol=new Ext.tree.TreeLoader(
											{
												baseParams:{
																funcion:'142',
                                                                carpetaAdministrativa:gE('carpetaAdministrativa').value,
                                                                idCarpeta:gE('idCarpetaAdministrativa').value
															},
												dataUrl:'../paginasFunciones/funcionesModulosEspeciales_SGP.php'
											}
										)		
										
											
										
	var arbolPlantillas=new Ext.tree.TreePanel	(
														{
															
															id:'arbolPlantillas',
															useArrows:true,
															autoScroll:true,
															animate:true,
															enableDD:true,
															width:280,
															region:'west',
															containerScroll: true,
															root:raiz,
															loader: cargadorArbol,
															rootVisible:false
														}
													)
			
							
	arbolPlantillas.on('click',funcPlantillaClick);	
	
	return arbolPlantillas;
}

function funcPlantillaClick(nodo)
{
	nodoPlantillaSel=nodo;
	
	if(nodo.attributes.tipoNodo=='2')
	{
	
		function funcAjax()
		{
			var resp=peticion_http.responseText;
			arrResp=resp.split('|');
			if(arrResp[0]=='1')
			{
				var objPlantilla=eval('['+arrResp[1]+']')[0];
				CKEDITOR.instances["txtDocumentoDemo"].setData(bD(objPlantilla.cuerpoDocumento));
                setTimeout(	function()
                			{
                            
			                	var anchoVentana=(obtenerDimensionesNavegador()[1]*0.9)-310;
							    var altoVentana=(obtenerDimensionesNavegador()[0]*0.9)-100;                                                                                       											
                                var body = CKEDITOR.instances.txtDocumentoDemo.editable().$;
                
                                var value = anchoVentana*100/860;
                                body.style.MozTransformOrigin = "top left";
                                body.style.MozTransform = "scale(" + (value/100)  + ")";
                                body.style.WebkitTransformOrigin = "top left";
                                body.style.WebkitTransform = "scale(" + (value/100)  + ")";
                                body.style.OTransformOrigin = "top left";
                                body.style.OTransform = "scale(" + (value/100)  + ")";
                                body.style.TransformOrigin = "top left";
                                body.style.Transform = "scale(" + (value/100)  + ")";
                                body.style.zoom = value/100;
                          	},200
                         )


			}
			else
			{
				msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
			}
		}
		obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=143&iD='+nodo.id,true);
	}
	else
	{
		nodoPlantillaSel=null;
		CKEDITOR.instances["txtDocumentoDemo"].setData('');
	}
	
}

function mostrarVentanaDatosDocumento(datosDocumento,importarDocumento)
{
	
	var tabla='<div><input type="text" id="txtFileName" disabled="true" style="border: solid 1px; background-color: #FFFFFF; width: 200px" /></div><div class="flash" id="fsUploadProgress">'+ 
					'</div><input type="hidden" name="hidFileID" id="hidFileID" value="" /> ';       					
					
                    
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                            			
                                            				x:10,
                                            				y:10,
                                                            id:'lblTituloDocumento',
                                                            hidden:importarDocumento,
                                            				html:'T&iacute;tulo del documento:'
                                            			},
                                                        {
                                            			
                                            				x:10,
                                            				y:10,
                                                            id:'lblIngreseDocumento',
                                                            hidden:!importarDocumento,
                                            				html:'Ingrese documento a adjuntar:'
                                            			},
                                            			{
                                            				x:210,
                                            				y:5,
                                            				xtype:'textfield',
                                            				width:300,
                                                            
                                                            hidden:importarDocumento,
                                            				id:'txtTitulo'
                                            			},
                                                        {
                                                        	xtype:'button',
                                                            cls:'x-btn-text-icon',
                                                            icon:'../images/page_word.png',
                                                            text:'Adjuntar documento Word',
                                                            width:160,
                                                            x:540,
                                                            y:5,
                                                            id:'btnAdjuntarDocumento',
                                                            enableToggle : true,
                                                            pressed:importarDocumento,
                                                            toggleHandler:function(btn,presionado)
                                                                            {
                                                                                if(presionado)
                                                                                {
                                                                                   	gEx('lblIngreseDocumento').show();
                                                                                    gEx('lblTituloDocumento').hide();
                                                                                    gEx('txtTitulo').hide();                                                                                    
                                                                                    gEx('lblTablaAdjunta').show();
                                                                                    gEx('btnUploadFile').show();
                                                                                    importarDocumento=true;
                                                                                }
                                                                                else
                                                                                {
                                                                                    gEx('lblIngreseDocumento').hide();
                                                                                    gEx('lblTituloDocumento').show();                                                                                    
                                                                                    gEx('txtTitulo').show();
                                                                                    gEx('lblTablaAdjunta').hide();
                                                                                    gEx('btnUploadFile').hide();
                                                                                    gEx('txtTitulo').focus();
                                                                                    importarDocumento=false;
                                                                                }
                                                                            }
                                                            			
                                                        },
                                                        {
                                                            x:185,
                                                            y:45,
                                                            hidden:true,
                                                            html:	'<div id="containerUploader"></div>'
                                                        },
                                                        {
                                                            x:180,
                                                            y:8,
                                                            hidden:!importarDocumento,
                                                            id:'lblTablaAdjunta',
                                                            xtype:'label',
                                                            html:'<table width="290"><tr><td><div id="uploader"><p>Your browser doesn\'t have Flash, Silverlight or HTML5 support.</p></div></td></tr><tr id="filaAvance" style="display:none"><td align="right">Porcentaje de avance: <span id="porcentajeAvance"> 0%</span></td></tr></table>'
                                                        },
                                                        {
                                                            x:480,
                                                            y:6,
                                                            id:'btnUploadFile',
                                                            xtype:'button',
                                                            text:'...',
                                                            hidden:true,
                                                            width:40,
                                                            handler:function()
                                                                    {
                                                                        $('#containerUploader').click();
                                                                    }
                                                        },
                                                        
                                                        {
                                                            x:290,
                                                            y:0,
                                                            xtype:'hidden',
                                                            id:'idArchivo'


                                                        },
                                                        {
                                                            x:290,
                                                            y:0,
                                                            xtype:'hidden',
                                                            id:'nombreArchivo'
                                                        }, 
                                            			{
                                            			
                                            				x:10,
                                            				y:40,
                                            				html:'Ingrese la descripci&oacute;n de la actuaci&oacute;n:'
                                            			},
                                            			{
                                            				x:10,
                                            				y:70,
                                            				xtype:'textarea',
                                            				width:680,
                                            				height:80,
                                            				id:'txtDescripcion'
                                            			},
                                            			crearGridProgramacionAlerta()
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Informaci&oacute;n del documento',
										width: 730,
                                        id:'vInfoDocumento',
										height:440,
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
                                                                	if(!importarDocumento)
																		gEx('txtTitulo').focus(false,500);
                                                                    
                                                                    
                                                                    var cObj = {
                                                                    
                                                                                    upload_url: "../modulosEspeciales_SGJP/procesarComprobante.php", //lquevedor
                                                                                    file_post_name: "archivoEnvio",
                                                                     
                                                                                    // Flash file settings
                                                                                    file_size_limit : "1000 MB",
                                                                                    file_types : "*.doc;*.docx",			// or you could use something like: "*.doc;*.wpd;*.pdf",
                                                                                    file_types_description : "Todos los archivos",
                                                                                    file_upload_limit : 0,
                                                                                    file_queue_limit : 1,
                                                                     
                                                                                    
                                                                                    upload_success_handler : subidaCorrecta
                                                                                    
                                                                                };  
																
                                                                
                                                                	crearControlUploadHTML5(cObj);
                                                                }
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
															handler: function()
																	{
                                                                    	
																		
																		var txtDescripcion=gEx('txtDescripcion');
																		if(!importarDocumento)
                                                                        {

																			var txtTitulo=gEx('txtTitulo');
                                                                            if(txtTitulo.getValue().trim()=='')
                                                                            {
                                                                                function resp()
                                                                                {
                                                                                    txtTitulo.focus();
                                                                                }
                                                                                msgBox('Debe ingresar el t&iacute;tulo del documento',resp);
                                                                                return;
                                                                            }
                                                                            
                                                                            
                                                                            var arrAlertas='';
                                                                            var gAlertas=gEx('gAlertas');
                                                                            var x;
                                                                            var f;
                                                                            for(x=0;x<gAlertas.getStore().getCount();x++)
                                                                            {
                                                                                f=gAlertas.getStore().getAt(x);
                                                                                
                                                                                if(f.data.fechaAlerta=='')
                                                                                {
                                                                                    function respDoc2()

                                                                                    {
                                                                                        gAlertas.startEditing(x,2);
                                                                                    }
                                                                                    
                                                                                    msgBox('Debe ingresar la fecha de la alerta',respDoc2);
                                                                                    return;
                                                                                }
                                                                                
                                                                                if(f.data.descripcionAlerta.trim()=='')
                                                                                {
                                                                                    function respDoc()
                                                                                    {
                                                                                        gAlertas.startEditing(x,3);
                                                                                    }
                                                                                    msgBox('Debe ingresar la descripci&oacute;n de la alerta',respDoc);
                                                                                    return;
                                                                                }
                                                                                
                                                                                oAlerta='{"fechaAlerta":"'+f.data.fechaAlerta.format('Y-m-d')+'","textoAlerta":"'+cv(f.data.descripcionAlerta)+'"}';
                                                                                if(arrAlertas=='')
                                                                                    arrAlertas=oAlerta;
                                                                                else
                                                                                    arrAlertas+=','+oAlerta;
                                                                            }
                                                                            
                                                                            var cadObj='{"idGeneracionDocumento":"-1","tipoDocumento":"'+nodoPlantillaSel.id+'","tituloDocumento":"'+cv(txtTitulo.getValue().trim())+
                                                                                        '","perfilValidacion":"'+nodoPlantillaSel.attributes.perfilValidacion+'","fechaLimite":"","modificaSituacionCarpeta":"0","situacion":"'+
                                                                                        '","descripcionActuacion":"'+cv(gEx('txtDescripcion').getValue())+'","carpetaAdministrativa":"'+
                                                                                        gE('carpetaAdministrativa').value+'","idFormulario":"-1","idRegistro":"-1","arrAlertas":['+arrAlertas+']}';
                                                                            
                                                                            
                                                                            
                                                                            if((importarDocumento)||(nodoPlantillaSel.attributes.funcionJSParametros==''))
                                                                            {
                                                                            	guardarDatosDocumento(cadObj,'',ventanaAM);
                                                                            }
                                                                            else
                                                                            {
                                                                            
                                                                            	eval(nodoPlantillaSel.attributes.funcionJSParametros+'(cadObj,ventanaAM);');
                                                                            }
                                                                            
																		}
																		else
                                                                        {
                                                                           
	                                                                    
                                                                        	if(uploadControl.files.length==0)
                                                                            {
                                                                                msgBox('Debe ingresar el documento que desea adjuntar');
                                                                                return;
                                                                            }
                                                                            uploadControl.start();
                                                                        
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
	
	
	
	if(!datosDocumento)
	{
		
		gEx('txtTitulo').setValue(nodoPlantillaSel.text);
	}
}

function guardarDatosDocumento(cadObj,parametros,ventana)
{
	cadObj=cadObj.substring(0,cadObj.length-1);
    cadObj+=',"datosParametros":"'+parametros.replace(/"/gi,'\\"',parametros)+'"}';
    

	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var anchoVentana=(obtenerDimensionesNavegador()[1]*0.9);
			var altoVentana=(obtenerDimensionesNavegador()[0]*0.9);
            
        	gEx('gDocumentos').getStore().reload();
            objConf={
                        tipoDocumento:nodoPlantillaSel.id,
                        idFormulario:-2,
                        ancho:anchoVentana,
                        alto:altoVentana,
                        rol:'158_0',
                        rolDefault:'158_0',
                        idRegistro: arrResp[1],
                        functionAfterValidate:function()
                                        {
                                            gEx('gDocumentos').getStore().reload();
                                        },
                        functionAfterTurn:function()
                                        {
                                            gEx('gDocumentos').getStore().reload();
                                        },
                        functionAfterSaveDocument:function()
                                                    {
                                                        gEx('gDocumentos').getStore().reload();
                                                    },
                       	
                        functionAfterLoadDocument:function()
                                                {
                                                    setTimeout(function()
                                                                {
                                                                    var body = CKEDITOR.instances.txtDocumento.editable().$;
                                                                    
                                                                    var value = (anchoVentana*100)/960;
                                                                    

                                                                    body.style.MozTransformOrigin = "top left";
                                                                    body.style.MozTransform = "scale(" + (value/100)  + ")";

                                                                    body.style.WebkitTransformOrigin = "top left";
                                                                    body.style.WebkitTransform = "scale(" + (value/100)  + ")";

                                                                    body.style.OTransformOrigin = "top left";
                                                                    body.style.OTransform = "scale(" + (value/100)  + ")";

                                                                    body.style.TransformOrigin = "top left";
                                                                    body.style.Transform = "scale(" + (value/100)  + ")";
                                                                    // IE
                                                                    body.style.zoom = value/100;
                                                                
                                                                    
                                                                },200
                                                            )
                                                    

                                                    
                                                }                             

                     };
            
            
            
            
            
            
            
            
            
            ventana.close();
            mostrarVentanaGeneracionDocumentos(objConf);
            
            
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=144&cadObj='+cadObj,true);
}

function visualizarDocumentoFinalizado(iD,tD)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var arrNombre=arrResp[2].split('.');
            extension=arrNombre[arrNombre.length-1];
            mostrarVisorDocumentoProceso(extension,arrResp[1]);
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=131&tD='+bD(tD)+'&iF=-2&iR='+bD(iD),true);
}

function crearGridProgramacionAlerta()
{
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                   
                                                                    {name: 'fechaAlerta', type:'date', dateFormat:'Y-m-d'},
                                                                    {name: 'descripcionAlerta'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel();
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														chkRow,
														{
															header:'Fecha de alerta',
															width:120,
															sortable:true,
															dataIndex:'fechaAlerta',
															editor:{xtype:'datefield'},
															renderer:function(val)
																	{
																		if(!val)
																			return '';
																		return val.format('d/m/Y');
																	}
														},
														{
															header:'Descripci&oacute;n de la alerta',
															width:480,
															sortable:true,
															editor:{ xtype:'textarea',height:80},
															dataIndex:'descripcionAlerta',
															renderer:mostrarValorDescripcion
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gAlertas',
                                                            store:alDatos,
                                                            frame:false,
                                                            y:160,
                                                            x:10,
                                                            clicksToEdit:1,
                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            stripeRows :true,                                                            
                                                            columnLines : true,
                                                            height:190,
                                                            width:680,
                                                            sm:chkRow,
                                                            tbar:	[
                                                            			{
                                                                        	icon:'../images/clock_add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Programar alerta',
                                                                            handler:function()
                                                                            		{
                                                                                    	var regAlerta= crearRegistro (
                                                                                   										[
                                                                                   											{name: 'fechaAlerta'},
                                                                    														{name: 'descripcionAlerta'}
                                                                                   										
                                                                                   										]
                                                                                    								)
                                                                                    
                                                                                    	var r=new  regAlerta 	(
                                                                                   									{
                                                                                   										fechaAlerta:'',
                                                                                   										descripcionAlerta:''
                                                                                   									}
                                                                                    							)
                                                                                    
                                                                                    
                                                                                    
                                                                                    	tblGrid.getStore().add(r);
                                                                                    	tblGrid.startEditing(tblGrid.getStore().getCount()-1,2);
                                                                                    	
                                                                                    	
                                                                                    	
                                                                                    	
                                                                                    }
                                                                            
                                                                        },'-',
                                                                        {
                                                                        	icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Remover alerta',
                                                                            handler:function()
                                                                            		{
                                                                                    	var fila=tblGrid.getSelectionModel().getSelected();
                                                                                    	if(!fila)
                                                                                    	{
                                                                                    		msgBox('Debe seleccionar la alerta que desea remover');
                                                                                    		return;
                                                                                    	}
                                                                                    	
                                                                                    	function resp(btn)
                                                                                    	{
                                                                                    		if(btn=='yes')
                                                                                    		{
                                                                                    			tblGrid.getStore().remove(fila);
                                                                                    		}
                                                                                    	}
                                                                                    	msgConfirm('Est&aacute; seguro de querer remover la alerta seleccionada?',resp);
                                                                                    	return;
                                                                                    	
                                                                                    	
                                                                                    }
                                                                            
                                                                        }
                                                                        
                                                            		]
                                                        }
                                                    );
	return 	tblGrid;
}

function crearGridHistorialCarpeta()
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idRegistro'},
		                                                {name: 'fechaCambio', type:'date', dateFormat:'Y-m-d H:i:s'},
		                                                {name:'responsableCambio'},
                                                        {name: 'idEstadoAnterior'},	
                                                        {name: 'detalleSituacionAnterior'},		                                                
                                                        {name: 'idEstadoActual'},
                                                        {name: 'detalleSituacion'},
                                                        {name: 'comentariosAdicionales'},
                                                        {name: 'nombreImputado'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../paginasFunciones/funcionesModulosEspeciales_SGP.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'fechaCambio', direction: 'DESC'},
                                                            groupField: 'nombreImputado',
                                                            remoteGroup:false,
				                                            remoteSort: true,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	
                                    	proxy.baseParams.funcion='155';
                                        proxy.baseParams.idActividad=gE('idActividad').value;
                                        
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer(),  
                                                            
                                                            {
                                                                header:'Fecha de cambio',
                                                                width:130,
                                                                sortable:true,
                                                                dataIndex:'fechaCambio',
                                                                renderer:function(val)
                                                                		{
                                                                        	return val.format('d/m/Y H:i:s');
                                                                        }
                                                            },
                                                            {
                                                                header:'Nombre del imputado',
                                                                width:250,
                                                                sortable:true,
                                                                align:'left',
                                                                dataIndex:'nombreImputado',
                                                                renderer:mostrarValorDescripcion
                                                            },
                                                            
                                                            {
                                                                header:'Situaci&oacute;n anterior',
                                                                width:300,
                                                                sortable:true,
                                                                dataIndex:'idEstadoAnterior',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	meta.attr='style="white-space: normal;"';
                                                                        	var leyenda=formatearValorRenderer(arrSituacionImputado,val);
                                                                            if(registro.data.detalleSituacionAnterior!='')
                                                                            {
                                                                            	leyenda+=': '+formatearValorRenderer(arrDetalleSituacionImputado,registro.data.detalleSituacionAnterior);
                                                                            }
                                                                        	return mostrarValorDescripcion(leyenda);
                                                                        }
                                                            },
                                                            {
                                                                header:'Situaci&oacute;n actual',
                                                                width:300,
                                                                sortable:true,
                                                                dataIndex:'idEstadoActual',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	
                                                                            meta.attr='style="white-space: normal;"';
                                                                            
                                                                            var leyenda=formatearValorRenderer(arrSituacionImputado,val);
                                                                            if(registro.data.detalleSituacionAnterior!='')
                                                                            {
                                                                            	leyenda+=': '+formatearValorRenderer(arrDetalleSituacionImputado,registro.data.detalleSituacion);
                                                                            }
                                                                        	return mostrarValorDescripcion(leyenda);
                                                                        }
                                                            }
                                                            ,
                                                            {
                                                                header:'Responsable cambio',
                                                                width:250,
                                                                sortable:true,
                                                                align:'left',
                                                                dataIndex:'responsableCambio',
                                                                renderer:function(val)
                                                                		{
                                                                        	return val;
                                                                        }
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gHistorialCambiosCarpeta',
                                                                store:alDatos,
                                                                title:'Historial de status de imputado',
                                                                region:'center',
                                                                frame:false,
                                                                cm: cModelo,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                columnLines : true,
                                                                tbar:	[
                                                               				{
																				icon:'../images/add.png',
																				cls:'x-btn-text-icon',
                                                                                hidden:gE('sL').value=='1',
																				text:'Registrar cambio de status de imputado',
																				handler:function()
																						{
																							mostrarVentanaCambioStatus();
																						}

																			}
                                                                		],                                                              
                                                                view:new Ext.grid.GroupingView({
                                                                                                    forceFit:false,
                                                                                                    showGroupName: false,
                                                                                                    enableGrouping :true,
                                                                                                    enableNoGroups:false,
                                                                                                    enableGroupingMenu:false,
                                                                                                    hideGroupedColumn: false,
                                                                                                    enableRowBody:true,
						                                                                            getRowClass : formatearFila,
                                                                                                    startCollapsed:false
                                                                                                })
                                                            }
                                                        );
                                                        
	               
        return 	tblGrid;
}

function formatearFila(record, rowIndex, p, ds) 
{
	var xf = Ext.util.Format;
    
    p.body = '<p style="margin-left: 3em;margin-right: 3em;text-align:left"><span class="copyrigthSinPaddingNegro">'+
                (record.data.comentariosAdicionales.trim()==''?'(Sin comentarios)':record.data.comentariosAdicionales.trim()) +
	        '</span></p>';
    return 'x-grid3-row-expanded';
}

function mostrarVentanaCambioStatus()
{
	var cmbCambioStatusCarpeta=crearComboExt('cmbCambioStatusCarpeta',arrSituacionImputado,160,5,320);
    cmbCambioStatusCarpeta.on('select',function(cmb,registro)
    								{
                                    	gEx('cmbDetalleAdicional').setValue('');
                                        gEx('cmbDetalleAdicional').getStore().removeAll();
                                        if(registro.data.valorComp.length>0)
                                        {
                                        	gEx('cmbDetalleAdicional').getStore().loadData(registro.data.valorComp);
                                            gEx('cmbDetalleAdicional').enable();
                                            gEx('cmbDetalleAdicional').focus();
                                        }
                                        else
                                        {
                                        	gEx('cmbDetalleAdicional').disable();
                                        }
                                    }
    						)
    var cmbImputadosCambio=crearComboExt('cmbImputadosCambio',arrImputados,160,65,320,{multiSelect:true});
    var cmbDetalleAdicional=crearComboExt('cmbDetalleAdicional',arrImputados,160,35,320);
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                            				x:10,
                                            				y:10,
                                            				html:'Cambiar status a:'
                                            			},
                                            			cmbCambioStatusCarpeta,
                                                        {
                                            				x:10,
                                            				y:40,
                                            				html:'Detalle adicional:'
                                            			},
                                                        cmbDetalleAdicional,
                                                        {
                                            				x:10,
                                            				y:70,
                                            				html:'Imputados a modificar:'
                                            			},
                                            			cmbImputadosCambio,
                                            			{
                                            				x:10,
                                            				y:100,
                                            				html:'Comentarios adicionales:'
                                            			},
                                            			{
                                            				x:10,
                                            				y:130,
                                            				width:600,
                                            				height:80,
                                            				xtype:'textarea',
                                            				id:'txtMotivoCambio'
                                            			}
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Cambiar status carpeta',
										width: 650,
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
																		var txtMotivoCambio=gEx('txtMotivoCambio');
																	
																		if(cmbCambioStatusCarpeta.getValue()=='')
																		{
																			function resp()
																			{
																				cmbCambioStatusCarpeta.focus();
																			}
																			msgBox('Debe indicar el status al cual desea cambiar al imputado',resp);
																			return;
																		}
                                                                        
                                                                        if((!cmbDetalleAdicional.disabled)&&(cmbDetalleAdicional.getValue()==''))
																		{
																			function respAux()
																			{
																				cmbDetalleAdicional.focus();
																			}
																			msgBox('Debe indicar el detalle del status al cual desea cambiar al imputado',respAux);
																			return;
																		}
																		
                                                                        if(cmbImputadosCambio.getValue()=='')
																		{
																			function respAux2()
																			{
																				cmbImputadosCambio.focus();
																			}
																			msgBox('Debe indicar almenos un imputado cuyo status desea modificar',respAux2);
																			return;
																		}
																		
																		
																		
																		function respAux(btn)
																		{
																			if(btn=='yes')
																			{
																				var cadObj='{"carpetaAdministrativa":"'+gE('carpetaAdministrativa').value+
																						'","statusImputado":"'+cmbCambioStatusCarpeta.getValue()+
																						'","detalleStatus":"'+cmbDetalleAdicional.getValue()+'","motivoCambio":"'+
                                                                                        cv(txtMotivoCambio.getValue())+'","imputado":"'+cmbImputadosCambio.getValue()+
                                                                                        '","idActividad":"'+gE('idActividad').value+'","idCarpeta":"'+gE('idCarpetaAdministrativa').value+
                                                                                        '"}';
																			
																				
																				function funcAjax()
																				{
																					var resp=peticion_http.responseText;
																					arrResp=resp.split('|');
																					if(arrResp[0]=='1')
																					{
																						ventanaAM.close();
																						gEx('gHistorialCambiosCarpeta').getStore().reload();

																					}
																					else
																					{
																						msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
																					}
																				}
																				obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=156&cadObj='+cadObj,true);
																			
																			}
																		}
																		msgConfirm('Est&aacute; seguro de querer cambiar el status del/los imputados seleccionados?',respAux);
																				
																				
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

function crearGridPrescripciones()
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idPrescripcion'},
		                                                {name: 'sentenciado'},
		                                                {name:'fechaPrescripcion', type:'date', dateFormat:'Y-m-d'},
                                                        {name: 'fechaRegistro', type:'date', dateFormat:'Y-m-d H:i:s'},		                                                
                                                        {name: 'situacion'},
                                                        {name: 'responsableRegistro'},
                                                        {name: 'canceladoPor'},
                                                        {name: 'fechaCancelacion', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name: 'motivoCancelacion'},
                                                        {name: 'pena'},
                                                        {name: 'fechaSustraccion'},
                                                        {name: 'abonoPrisionPreventiva'},
                                                        {name: 'abonoPrisionPunitiva'},
                                                        {name: 'sentenciadoEnCDMX'},
                                                        {name: 'comentariosAdicionales'},
                                                        {name: 'esPrivativaLibertad'},
                                                        {name: 'tipoEntrada'},
                                                        {name: 'fechaInicioPena'},
                                                        {name: 'abonoCumplimientoSentencia'},
                                                        {name: 'comentariosPrisionPunitiva'},
                                                        {name: 'periodoCompurga'},
                                                        {name: 'idFormulario'},
                                                        {name: 'idReferencia'},
                                                        {name: 'fechaUltimoActoAutoridad'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../paginasFunciones/funcionesModulosEspeciales_SGP.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'fechaRegistro', direction: 'DESC'},
                                                            groupField: 'fechaRegistro',
                                                            remoteGroup:false,
				                                            remoteSort: true,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	gEx('btnCancelarPrescripcion').disable();
                                    	proxy.baseParams.funcion='141';
                                        proxy.baseParams.cA=gE('carpetaAdministrativa').value;
                                        
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer(),  
                                                            {
                                                                header:'',
                                                                width:40,
                                                                sortable:true,
                                                                dataIndex:'idFormulario',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	if(val!='-1')
                                                                        	{
                                                                        		return '<a href="javascript:abrirProcesoPrescripcion(\''+bE(val)+'\',\''+bE(registro.data.idReferencia)+'\')"><img src="../images/magnifier.png" title="Ver proceso asociado" alt="Ver proceso asociado"></a>';
                                                                        	}
                                                                        }
                                                            },
                                                            {
                                                                header:'Fecha de registro',
                                                                width:130,
                                                                sortable:true,
                                                                dataIndex:'fechaRegistro',
                                                                renderer:function(val)
                                                                		{
                                                                        	return val.format('d/m/Y H:i:s');
                                                                        }
                                                            },                                                            
                                                            {
                                                                header:'Registrado por',
                                                                width:300,
                                                                sortable:true,
                                                                align:'left',
                                                                dataIndex:'responsableRegistro',
                                                                renderer:function(val)
                                                                		{
                                                                        	return val;
                                                                        }
                                                            },
                                                            {
                                                                header:'Nombre del imputado/sentenciado',
                                                                width:300,
                                                                sortable:true,
                                                                align:'left',
                                                                dataIndex:'sentenciado',
                                                                renderer:function(val)
                                                                		{
                                                                        	return val;
                                                                        }
                                                            },
                                                            {
                                                                header:'Fecha de prescripci&oacute;n',
                                                                width:130,
                                                                sortable:true,
                                                                dataIndex:'fechaPrescripcion',
                                                                renderer:function(val)
                                                                		{
                                                                        	return val.format('d/m/Y');
                                                                        }
                                                            },
                                                            {
                                                                header:'Situaci&oacute;n prescripci&oacute;n',
                                                                width:180,
                                                                sortable:true,
                                                                dataIndex:'situacion',
                                                                renderer:function(val)
                                                                		{
                                                                       		var color='030';
                                                                       		if(val==2)
                                                                       			color='900';
                                                                        	return '<span style="color:#'+color+';"><b>'+formatearValorRenderer(arrStatusPrescripcion,val)+'</b></span>';
                                                                        }
                                                            },
                                                            
                                                            {
                                                                header:'Fecha de cancelaci&oacute;n',
                                                                width:130,
                                                                sortable:true,
                                                                hidden:true,
                                                                dataIndex:'fechaCancelacion',
                                                                renderer:function(val)
                                                                		{
                                                                       		if(val)
                                                                        		return val.format('d/m/Y H:i:s');
                                                                        }
                                                            },
                                                            {
                                                                header:'Cancelado por',
                                                                width:300,
                                                                sortable:true,
                                                                align:'left',
                                                                 hidden:true,
                                                                dataIndex:'canceladoPor',
                                                                renderer:function(val)
                                                                		{
                                                                        	return val;
                                                                        }
                                                            }
                                                            
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gPrescripciones',
                                                                store:alDatos,
                                                                title:'Prescripciones',
                                                                region:'center',
                                                                frame:false,
                                                                cm: cModelo,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                columnLines : true,
                                                                tbar:	[
                                                               				{
																				icon:'../images/add.png',
																				cls:'x-btn-text-icon',
                                                                                hidden:gE('sL').value=='1',
																				text:'Registrar prescripci&oacute;n',
																				handler:function()
																						{
																							mostrarVentanaPrescripcion();
																						}

																			},'-',
                                                               				{
																				icon:'../images/cross.png',
																				cls:'x-btn-text-icon',
                                                                                hidden:gE('sL').value=='1',
																				id:'btnCancelarPrescripcion',
																				text:'Cancelar prescripci&oacute;n',
																				handler:function()
																						{
																							var fila=gEx('gPrescripciones').getSelectionModel().getSelected();
																							if(!fila)
																							{
																								msgBox('Debe seleccionar la prescripci&oacute;n que desea cancelar');
																								return;
																							}
																							mostrarVentanaCancelarPrescripcion(fila);
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
                                                                                                    enableRowBody:true,
						                                                                            getRowClass : formatearFilaPrescripcion,
                                                                                                    startCollapsed:false
                                                                                                })
                                                            }
                                                        );
                                                        
	    tblGrid.getSelectionModel().on('rowselect',function(sm,nFila,registro)
      												{
      													gEx('btnCancelarPrescripcion').disable();
      													if((registro.data.situacion==1)&&(registro.data.idFormulario=='-1'))
      														gEx('btnCancelarPrescripcion').enable();
      													
      												}
       									)           
        
        tblGrid.getSelectionModel().on('rowdeselect',function(sm,nFila,registro)
      												{
      													gEx('btnCancelarPrescripcion').disable();
      													
      													
      												}
       									) 
        
        
        return 	tblGrid;
}


function mostrarVentanaCancelarPrescripcion(fPrescripcion)
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
                                            				html:'Indique el motivo de la cancelaci&oacute;n de la prescripci&oacute;n:'
                                            			},
                                            			{
                                            				x:10,
                                            				y:40,
                                            				xtype:'textarea',
                                            				width:600,
                                            				id:'txtMotivoCancelacion',
                                            				height:90
                                            			}
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Cancelaci&oacute;n de prescripci&oacute;n',
										width: 645,
										height:230,
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
																	gEx('txtMotivoCancelacion').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
															handler: function()
																	{
																		
																		if(gEx('txtMotivoCancelacion').getValue().trim()=='')
																		{
																			function respAux()
																			{
																				gEx('txtMotivoCancelacion').focus();
																			}
																			msgBox('Debe ingresar el motivo de la cancelaci&oacute;n',respAux);
																			return;
																		}
																	
																		var cadObj='{"motivoCancelacion":"'+cv(gEx('txtMotivoCancelacion').getValue().trim())+
																				'","idPrescripcion":"'+fPrescripcion.data.idPrescripcion+'"}';
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
																						gEx('gPrescripciones').getStore().reload();
																						ventanaAM.close();
																					}
																					else
																					{
																						msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
																					}
																				}
																				obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=140&cadObj='+cadObj,true);
																			}
																		}
																		msgConfirm('Est&aacute; seguro de querer cancelar la prescripci&oacute;n seleccionada?',resp);
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

function mostrarVentanaPrescripcion()
{
	
	var cmbImputado=crearComboExt('cmbImputado',arrImputados,160,5,300);
	var cmbSentenciadoCiudadMexico=crearComboExt('cmbSentenciadoCiudadMexico',arrSiNo,360,310,115);
	
	cmbSentenciadoCiudadMexico.on('select',calcularPrescripcion);
	
	cmbImputado.on('select',function(cmb,registro)
							{
								function funcAjax()
								{
									var resp=peticion_http.responseText;
									arrResp=resp.split('|');
									if(arrResp[0]=='1')
									{
										var arrDatos=eval(arrResp[1]);
										gEx('cmbPena').setValue('');
										gEx('cmbPena').getStore().loadData(arrDatos);
										limpiarDatosAbono();
									}
									else
									{
										msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
									}
								}
								obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=137&s='+registro.data.id+'&cA='+gE('carpetaAdministrativa').value,true);
							
							}
							
				)
	
	
	var cmbPena=crearComboExt('cmbPena',[],160,35,600);
	
	cmbPena.on('select',function(cmb,registro)
							{
								function funcAjax()
								{
									var resp=peticion_http.responseText;
									arrResp=resp.split('|');
									if(arrResp[0]=='1')
									{
										oPenaPrescripcion=eval('['+arrResp[1]+']')[0];
										limpiarDatosAbono();
										gEx('txtAniosPunitiva').disable();
										gEx('txtMesesPunitiva').disable();
										gEx('txtDiasPunitiva').disable();
										gEx('txtComentarioPrision').disable();
										gEx('lblFechaInicioPena').hide();
										gEx('dteFechaInicio').hide();
										gEx('lblFechaTerminoPena').hide();
										gEx('dteFechaTermino').hide();
										gEx('fsPeriodoCumplir').hide();
										gEx('lblFechaInicioPena').hide();
										
										gEx('txtFechaSustraccion').disable();
										
										
										gEx('dteFechaInicio').setValue(oPenaPrescripcion.fechaInicioPena);
										gEx('dteFechaTermino').setValue(oPenaPrescripcion.fechaTermino);
										if(oPenaPrescripcion.fechaTermino!='')
										{
											gEx('lblFechaInicioPena').show();
											gEx('dteFechaInicio').show();
											gEx('lblFechaTerminoPena').show();
											gEx('dteFechaTermino').show();
										}
										
										
										var arrDias=oPenaPrescripcion.abonoPrisionPreventiva.split('_');
										gEx('txtAnios').setValue(arrDias[0]);
										gEx('txtMeses').setValue(arrDias[1]);
										gEx('txtDias').setValue(arrDias[2]);
										
										gEx('txtFechaSustraccion').setMinValue(oPenaPrescripcion.fechaInicioPena);
										gEx('txtFechaSustraccion').setMaxValue(oPenaPrescripcion.fechaTermino);
										if(oPenaPrescripcion.tipoEntrada=='5')
										{
											gEx('txtAniosPunitiva').enable();
											gEx('txtMesesPunitiva').enable();
											gEx('txtDiasPunitiva').enable();											
											gEx('txtComentarioPrision').enable();
											gEx('fsPeriodoCumplir').show();
											if(oPenaPrescripcion.esPrivativaLibertad=='1')
											{
												gEx('txtFechaSustraccion').enable();
												gEx('lblFechaSustraccion').setText('Fecha de sustracción del imputado/sentenciado:');
											}
											calcularPenaCumplir();
										}
										else
										{
											gEx('lblFechaSustraccion').setText('Fecha de ejecutoria:');
											gEx('txtFechaSustraccion').setValue(oPenaPrescripcion.fechaInicio);
											calcularPrescripcion();
										}
										
									}
									else
									{
										msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
									}
								}
								obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=138&iP='+registro.data.id,true);
							
							}
							
				)
	
	
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'border',
											defaultType: 'label',
											items: 	[
                                           				{
                                           					xtype:'tabpanel',
                                           					region:'center',
                                           					id:'tblDatosPrescripcion',
                                           					baseCls: 'x-plain',
                                           					activeTab:1,
                                           					items:	[
                                           								{
																			x:10,
																			y:10,
																			baseCls: 'x-plain',
																			layout:'absolute',
																			defaultType: 'label',
																			title:'Datos Generales',
																			xtype:'panel',
																			items:	[
																						{
																							x:10,
																							y:10,
																							html:'Imputado/sentenciado:'
																						},
																						cmbImputado,
																						{
																							x:10,
																							y:40,
																							html:'Pena:'
																						},
																						cmbPena,
																						{
																							x:10,
																							y:70,
																							hidden:true,
																							id:'lblFechaInicioPena',
																							html:'Fecha de inicio de pena:'
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
																							html:'Fecha de t&eacute;rmino de pena:'
																						},
																						{
																							x:450,
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
																							x:520,
																							y:95,
																							
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
																											html:'A&ntilde;os',
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
																											html:'Meses',
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
																											html:'D&iacute;as',
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
                                                                                            hidden:true,
																							title:'Abono cumplimiento sentencia',
																							x:10,
																							y:185,
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
																											html:'A&ntilde;os',
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
																											html:'Meses',
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
																											html:'D&iacute;as',
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
																							x:10,
																							y:95,
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
																											listeners:	{
																															change:calcularPenaCumplir
																														},
																											id:'txtAniosPunitiva'
																										},
																										{
																											xtype:'label',
																											html:'A&ntilde;os',
																											x:15,
																											y:25
																										},
																										{
																											x:60,
																											y:0,
																											xtype:'numberfield',
																											width:40,
																											disabled:true,
																											listeners:	{
																															change:calcularPenaCumplir
																														},
																											allowDecimals:false,
																											alowNegative:false,
																											value:0,

																											id:'txtMesesPunitiva'
																										},
																										{
																											xtype:'label',
																											html:'Meses',
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
																											listeners:	{
																															change:calcularPenaCumplir
																														},
																											allowDecimals:false,
																											alowNegative:false,
																											id:'txtDiasPunitiva'
																										},
																										{
																											xtype:'label',
																											html:'D&iacute;as',
																											x:115,
																											y:25
																										},
																										{
																											x:10,
																											y:45,
																											xtype:'label',
																											html:'Comentarios prisi&oacute;n punitiva:'
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
																							xtype:'fieldset',
																							width:230,
																							border:true,
																							hidden:true,
																							id:'fsPeriodoCumplir',
																							height:80,
																							title:'Pena por complir',
																							x:520,
																							y:185,																							
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
																											id:'txtAniosCumplir'
																										},
																										{
																											xtype:'label',
																											html:'A&ntilde;os',
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
																											id:'txtMesesCumplir'
																										},
																										{
																											xtype:'label',
																											html:'Meses',
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
																											id:'txtDiasCumplir'
																										},
																										{
																											xtype:'label',
																											html:'D&iacute;as',
																											x:115,
																											y:25
																										}
																									]
																						},
																						{
																							x:10,
																							y:285,
																							
																							xtype:'label',
																							id:'lblFechaSustraccion',
																							html:'Fecha de sustracción del imputado/sentenciado:'
																						},
																						{
																							x:280,
																							y:280,
																							disabled:true,
																							xtype:'datefield',
																							id:'txtFechaSustraccion',
																							listeners:	{
																											change:function()
																													{
																														calcularPenaCumplir();
																													}
																										}
																							
																						},
                                                                                        {
																							x:440,
																							y:285,																							
																							xtype:'label',
																							id:'lblFechaUltimoActo',
																							html:'Fecha de último acto de la autoridad:'
																						},
                                                                                        {
																							x:650,
																							y:280,
																							disabled:false,
																							xtype:'datefield',
																							id:'txtFechaUltimoActo'
																						},
																						{
																							x:10,
																							y:315,
																							xtype:'label',
																							html:'¿El imputado/sentenciado se encuentra en la Ciudad de M&eacute;xico?'
																						},
																						cmbSentenciadoCiudadMexico,
																						{
																							x:10,
																							y:345,
																							xtype:'label',
																							html:'Fecha de prescripci&oacute;n:'
																						},
																						{
																							x:280,
																							y:340,
																							disabled:false,
																							xtype:'datefield',
																							id:'txtFechaPrescripcion'
																						}
																						
																					]


																		},
																		{
																			x:10,
																			y:10,
																			layout:'absolute',
																			defaultType: 'label',
																			baseCls: 'x-plain',
																			title:'Comentarios adicionales',
																			xtype:'panel',
																			items:	[
																						{
																							xtype:'textarea',
																							x:10,
																							y:10,
																							width:750,
																							height:200,
																							id:'txtComentarios'

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
										title: 'Registrar prescripci&oacute;n',
										width: 800,
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
                                                                    	var txtFechaUltimoActo=gEx('txtFechaUltimoActo');
																		if(cmbImputado.getValue()=='')
																		{
																			function resp()
																			{
																				cmbImputado.focus();
																			}
																			msgBox('Debe indicar el imputado al cual desea registrar la prescripci&oacute;n',resp);
																			return;
																		}
																		
																		if(cmbPena.getValue()=='')
																		{
																			function resp2()
																			{
																				cmbPena.focus();
																			}
																			msgBox('Debe indicar la pena sobre la cual desea registrar la prescripci&oacute;n',resp2);
																			return;
																		}
																		
																		if(cmbSentenciadoCiudadMexico.getValue()=='')
																		{
																			function resp3()
																			{
																				cmbSentenciadoCiudadMexico.focus();
																			}
																			msgBox('Debe indicar si el imputado/sentenciado se encuentra en la Ciudad de M&eacute;xico',resp3);
																			return;
																		}
																		
																		var txtFechaSustraccion=gEx('txtFechaSustraccion');
																		
																		if(txtFechaSustraccion.getValue()=='')
																		{
																			function resp4()
																			{
																				txtFechaSustraccion.focus();
																			}
																			msgBox('Debe indicar la fecha de sustracci&oacute;n del imputado/sentenciado',resp4);
																			return;
																		}
                                                                        
                                                                        if(txtFechaUltimoActo.getValue()=='')
																		{
																			function resp4_1()
																			{
																				txtFechaUltimoActo.focus();
																			}
																			msgBox('Debe indicar la fecha del &uacute;ltimo acto de la autoridad',resp4_1);
																			return;
																		}
                                                                        
                                                                        if(txtFechaUltimoActo.getValue()<txtFechaSustraccion.getValue())
																		{
																			function resp4_2()
																			{
																				txtFechaUltimoActo.focus();
																			}
																			msgBox('La fecha del &uacute;ltimo acto de la autoridad NO puede ser menor que la fecha de sustracci&oacute;n',resp4_2);
																			return;
																		}
																		
																		var txtAniosPunitiva=gEx('txtAniosPunitiva');	
																		var txtMesesPunitiva=gEx('txtMesesPunitiva');
																		var txtDiasPunitiva=gEx('txtDiasPunitiva');
																		if(txtAniosPunitiva.getValue()=='')
																			txtAniosPunitiva.setValue(0);
																		if(txtMesesPunitiva.getValue()=='')
																			txtMesesPunitiva.setValue(0);
																		if(txtDiasPunitiva.getValue()=='')
																			txtDiasPunitiva.setValue(0);
																		var abonoPrisionPreventiva=gEx('txtAnios').getValue()+'_'+gEx('txtMeses').getValue()+'_'+gEx('txtDias').getValue();
																		var abonoPrisionPunitiva=txtAniosPunitiva.getValue()+'_'+txtMesesPunitiva.getValue()+'_'+txtDiasPunitiva.getValue();
																		var abonoCumplimientoSentencia=gEx('txtAniosCumplimiento').getValue()+'_'+gEx('txtMesesCumplimiento').getValue()+'_'+gEx('txtDiasCumplimiento').getValue();
																		
																		var cadObj='{"sentenciado":"'+cmbImputado.getValue()+'","idPena":"'+cmbPena.getValue()+'","fechaBase":"'+txtFechaSustraccion.getValue().format('Y-m-d')+
																				'","abonoPrisionPreventiva":"'+abonoPrisionPreventiva+'","abonoPrisionPunitiva":"'+abonoPrisionPunitiva+'","abonoCumplimientoSentencia":"'+
																				abonoCumplimientoSentencia+'","comentariosPrisionPunitiva":"'+cv(gEx('txtComentarioPrision').getValue())+'",'+
																				'"fechaPrescripcion":"'+gEx('txtFechaPrescripcion').getValue().format('Y-m-d')+'","sentenciadoEnCDMX":"'+cmbSentenciadoCiudadMexico.getValue()+
																				'","comentariosAdicionales":"'+cv(gEx('txtComentarios').getValue())+'","carpetaAdministrativa":"'+gE('carpetaAdministrativa').value+
																				'","idFormulario":"-1","idRegistro":"-1","fechaUltimoActo":"'+txtFechaUltimoActo.getValue().format('Y-m-d')+'"}';
																		
																	
																		function funcAjax()
																		{
																			var resp=peticion_http.responseText;
																			arrResp=resp.split('|');
																			if(arrResp[0]=='1')
																			{
																				gEx('gPrescripciones').getStore().reload();
																				ventanaAM.close();

																			}
																			else
																			{
																				msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
																			}
																		}
																		obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=139&cadObj='+cadObj,true);
																	
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
	gEx('tblDatosPrescripcion').setActiveTab(0);
}

function calcularPenaCumplir()
{
	var arrPenaBase=oPenaPrescripcion.periodoPena.split('_');
	var arrAbonoPrisionPreventiva=oPenaPrescripcion.abonoPrisionPreventiva.split('_');
	//var diasComputo=obtenerDiferenciaDias(gEx('dteFechaInicio').getValue().format('Y-m-d'),gEx('txtFechaSustraccion').getValue().format('Y-m-d'));
	//diasComputo--;
	//var abonoCumplimientoSentencia=convertirDiasArrComputo(diasComputo);
	//gEx('txtAniosCumplimiento').setValue(abonoCumplimientoSentencia[0]);
	//gEx('txtMesesCumplimiento').setValue(abonoCumplimientoSentencia[1]);
	//gEx('txtDiasCumplimiento').setValue(abonoCumplimientoSentencia[2]);
	
	
	var abonoPrisionPunitiva=[];
	abonoPrisionPunitiva[0]=gEx('txtAniosPunitiva').getValue();
	abonoPrisionPunitiva[1]=gEx('txtMesesPunitiva').getValue();
	abonoPrisionPunitiva[2]=gEx('txtDiasPunitiva').getValue();
	
	var arrResultado=restarComputo(arrPenaBase,arrAbonoPrisionPreventiva);
	//arrResultado=restarComputo(arrResultado,abonoCumplimientoSentencia);
	arrResultado=restarComputo(arrResultado,abonoPrisionPunitiva);
	gEx('txtAniosCumplir').setValue(arrResultado[0]);
	gEx('txtMesesCumplir').setValue(arrResultado[1]);
	gEx('txtDiasCumplir').setValue(arrResultado[2]);
	calcularPrescripcion();
}

function calcularPrescripcion()
{
	var txtFechaPrescripcion=gEx('txtFechaPrescripcion');
	var txtFechaSustraccion=gEx('txtFechaSustraccion');
	var cmbSentenciadoCiudadMexico=gEx('cmbSentenciadoCiudadMexico');
	
	if(txtFechaSustraccion.getValue()=='')
	{
		txtFechaPrescripcion.setValue('');
		return;
	}
	
	if(cmbSentenciadoCiudadMexico.getValue()=='')
	{
		txtFechaPrescripcion.setValue('');
		return;
	}
	
	var fechaBase=null;
	if(txtFechaSustraccion.disabled)
		fechaBase=txtFechaSustraccion.getValue();
	else	
		fechaBase=txtFechaSustraccion.getValue().add(Date.DAY,1);
	var arrSumar=[];
	arrSumar[0]=0;
	arrSumar[1]=0;
	arrSumar[2]=0;
	aniosPrescripcion=parseFloat(oPenaPrescripcion.aniosPrescripcion);
	if(oPenaPrescripcion.tipoEntrada=='5')
	{
		if(parseFloat(gEx('txtAniosCumplir').getValue())<aniosPrescripcion)
		{
			arrSumar[0]=aniosPrescripcion;
			arrSumar[1]=0;
			arrSumar[2]=0;
		}
		else
		{
			arrSumar[0]=parseFloat(gEx('txtAniosCumplir').getValue());
			arrSumar[1]=parseFloat(gEx('txtMesesCumplir').getValue());
			arrSumar[2]=parseFloat(gEx('txtDiasCumplir').getValue());
		}
	}
	else
	{
		arrSumar[0]=aniosPrescripcion;
		arrSumar[1]=0;
		arrSumar[2]=0;
	}
	
	
	fechaBase=fechaBase.add(Date.YEAR,arrSumar[0]);
	fechaBase=fechaBase.add(Date.MONTH,arrSumar[1]);
	fechaBase=fechaBase.add(Date.DAY,arrSumar[2]);
	if(cmbSentenciadoCiudadMexico.getValue()=='0')
	{
		fechaBase=fechaBase.add(Date.YEAR,arrSumar[0]);
		fechaBase=fechaBase.add(Date.MONTH,arrSumar[1]);
		fechaBase=fechaBase.add(Date.DAY,arrSumar[2]);
	}
	
	txtFechaPrescripcion.setValue(fechaBase);
}

function limpiarDatosAbono()
{
	gEx('dteFechaInicio').setValue('');
	gEx('dteFechaTermino').setValue('');
	gEx('txtFechaSustraccion').setValue('');
	gEx('txtFechaPrescripcion').setValue('');
	
	gEx('txtAnios').setValue('0');
	gEx('txtMeses').setValue('0');
	gEx('txtDias').setValue('0');
	
	gEx('txtAniosCumplimiento').setValue('0');
	gEx('txtMesesCumplimiento').setValue('0');
	gEx('txtDiasCumplimiento').setValue('0');
	
	gEx('txtAniosPunitiva').setValue('0');
	gEx('txtMesesPunitiva').setValue('0');
	gEx('txtDiasPunitiva').setValue('0');
	
	gEx('txtComentarioPrision').setValue('');
	
	gEx('cmbSentenciadoCiudadMexico').setValue('');
	
	gEx('txtAniosCumplir').setValue('0');
	gEx('txtMesesCumplir').setValue('0');
	gEx('txtDiasCumplir').setValue('0');
}

function formatearFilaPrescripcion(record, rowIndex, p, ds) 
{
	var xf = Ext.util.Format;
   
    
	p.body = 	'<table width="100%"><tr><td width="20"></td><td>';
   	p.body +=		'<table width="800">';
	p.body +=			'<tr height="21"><td valign="top" width="220"><span class="TSJDF_Etiqueta">Pena:</span></td><td valign="top" width="600"><span class="TSJDF_Control">'+record.data.pena+'</span></td></tr>';
	
   	if(record.data.tipoEntrada=='5')
   	{
   		var aResultado=record.data.periodoCompurga.split('_');
   		aResultado=restarComputo(aResultado,record.data.abonoPrisionPreventiva.split('_'));
   		aResultado=restarComputo(aResultado,record.data.abonoCumplimientoSentencia.split('_'));
   		aResultado=restarComputo(aResultado,record.data.abonoPrisionPunitiva.split('_'));
   		
   		p.body +=			'<tr height="21"><td valign="top"><span class="TSJDF_Etiqueta">Abono prisi&oacute;n preventiva:</span></td><td valign="top" width="600"><span class="TSJDF_Control">'+convertirLeyendaComputo(record.data.abonoPrisionPreventiva.split('_'))+'</span></td></tr>';
   		//p.body +=			'<tr height="21"><td valign="top"><span class="TSJDF_Etiqueta">Abono cumplimiento de sentencia:</span></td><td valign="top" width="600"><span class="TSJDF_Control">'+convertirLeyendaComputo(record.data.abonoCumplimientoSentencia.split('_'))+'</span></td></tr>';
   		p.body +=			'<tr height="21"><td valign="top"><span class="TSJDF_Etiqueta">Abono prisi&oacute;n punitiva:</span></td><td valign="top" width="600"><span class="TSJDF_Control">'+convertirLeyendaComputo(record.data.abonoPrisionPunitiva.split('_'))+'</span></td></tr>';
   		p.body +=			'<tr height="21"><td valign="top"><span class="TSJDF_Etiqueta">Comentarios prisi&oacute;n punitiva:</span></td><td valign="top" width="600"><span class="TSJDF_Control">'+(record.data.comentariosPrisionPunitiva==''?'(Sin comentarios)':record.data.comentariosPrisionPunitiva)+'</span></td></tr>';
   		p.body +=			'<tr height="21"><td valign="top"><span class="TSJDF_Etiqueta">Por compurgar:</span></td><td valign="top" width="600"><span class="TSJDF_Control">'+convertirLeyendaComputo(aResultado)+'</span></td></tr>';
   		p.body +=			'<tr height="21"><td valign="top"><span class="TSJDF_Etiqueta">Fecha de inicio de pena:</span></td><td valign="top" width="600"><span class="TSJDF_Control">'+(record.data.fechaInicioPena!=''?Date.parseDate(record.data.fechaInicioPena,'Y-m-d').format('d/m/Y'):'(NO definido)')+'</span></td></tr>';
   		p.body +=			'<tr height="21"><td valign="top"><span class="TSJDF_Etiqueta">Fecha de substracci&oacute;n:</span></td><td valign="top" width="600"><span class="TSJDF_Control">'+Date.parseDate(record.data.fechaSustraccion,'Y-m-d').format('d/m/Y')+'</span></td></tr>';
   	}
   	else
   	{
   		p.body +=			'<tr height="21"><td valign="top"><span class="TSJDF_Etiqueta">Fecha de ejecutoria:</span></td><td valign="top" width="600"><span class="TSJDF_Control">'+Date.parseDate(record.data.fechaSustraccion,'Y-m-d').format('d/m/Y')+'</span></td></tr>';
   	}
    p.body +=			'<tr height="21"><td valign="top"><span class="TSJDF_Etiqueta">Fecha de &uacute;ltimo acto de la autoridad:</span></td><td valign="top" width="600"><span class="TSJDF_Control">'+(record.data.fechaUltimoActoAutoridad!=''?Date.parseDate(record.data.fechaUltimoActoAutoridad,'Y-m-d').format('d/m/Y'):'')+'</span></td></tr>';
   	p.body +=			'<tr height="21"><td valign="top"><span class="TSJDF_Etiqueta">En Ciudad de M&eacute;xico:</span></td><td valign="top" width="600"><span class="TSJDF_Control">'+formatearValorRenderer(arrSiNo,record.data.sentenciadoEnCDMX)+'</span></td></tr>';
   	if(record.data.situacion=='2')
   	{
		p.body +=			'<tr height="21"><td valign="top"><span class="TSJDF_Etiqueta">Fecha de cancelaci&oacute;:</span></td><td valign="top" width="600"><span class="TSJDF_Control">'+record.data.fechaCancelacion.format('d/m/Y')+'</span></td></tr>';
		p.body +=			'<tr height="21"><td valign="top"><span class="TSJDF_Etiqueta">Cancelado por:</span></td><td valign="top" width="600"><span class="TSJDF_Control">'+record.data.canceladoPor+'</span></td></tr>';
  		p.body +=			'<tr height="21"><td valign="top"><span class="TSJDF_Etiqueta">Motivo de la cancelaci&oacute;n:</span></td><td valign="top" width="600"><span class="TSJDF_Control">'+record.data.motivoCancelacion+'</span></td></tr>';
   	}
   	p.body +=			'<tr height="21"><td valign="top"><span class="TSJDF_Etiqueta">Comentarios adicionales:</span></td><td valign="top" width="600"><span class="TSJDF_Control">'+(record.data.comentariosAdicionales==''?'(Sin comentarios)':record.data.comentariosAdicionales)+'</span></td></tr>';
   	p.body +=		'</table>';
    p.body +=	'</p>';
	p.body +=	'</td></tr></table>';
    return 'x-grid3-row-expanded';
}

function abrirProcesoPrescripcion(iF,iR)
{
	var obj={};
	var params=[['idRegistro',bD(iR)],['idFormulario',bD(iF)],['dComp',bE('auto')],['actor',bE('0')]];
	obj.ancho='100%';
	obj.alto='100%';
	obj.url='../modeloPerfiles/vistaDTDv3.php';
	obj.params=params;
	obj.modal=true;
	abrirVentanaFancy(obj);
}

function crearGridNotificacionesDia()
{
	var arrStatusAlertaCombo=[['0','Todas'],['1,4','Activas'],['2','Canceladas'],['3','Atendidas']];
	var cmbStatusAlertas=crearComboExt('cmbStatusAlertas',arrStatusAlertaCombo,0,0,140);
	cmbStatusAlertas.setValue('1,4');
	cmbStatusAlertas.on('select',recargarGridAlertas);
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
                                                        {name: 'fechaAlerta', type:'date', dateFormat:'Y-m-d'},
                                                        {name: 'idTitularAlerta'},
                                                        {name: 'objConfiguracion'},
                                                        {name: 'situacion'},
                                                        {name: 'comentariosAlerta'},
                                                        {name: 'responsableCancelacion'}
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
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                   		gEx('btnAtendidaAlerta').disable();
                                   		gEx('btnCancelarAlerta').disable();
                                   		
                                    	proxy.baseParams.funcion='12';
                                        proxy.baseParams.fI=gEx('txtFechaInicio').getValue().format('Y-m-d');
                                        proxy.baseParams.fF=gEx('txtFechaFin').getValue().format('Y-m-d');
										
                                                                              
										proxy.baseParams.cA=gE('carpetaAdministrativa').value;
                                        proxy.baseParams.status=gEx('cmbStatusAlertas').getValue();
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer({width:30}),
                                                            
                                                            {
                                                                header:'',
                                                                width:30,
                                                                sortable:true,
                                                                align:'center',
                                                                dataIndex:'idTitularAlerta',
                                                                renderer:function(val)
                                                                		{
                                                                			if(val=='')
                                                                				return '<img src="../images/users.png" title="Alerta General">';
                                                                			return '<img src="../images/user_gray.png" title="Alerta Personal">';
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
                                                            },
                                                            {
                                                                header:'Fecha de alerta',
                                                                width:120,
                                                                sortable:true,
                                                                dataIndex:'fechaAlerta',
                                                                renderer:function(val)
                                                                		{
                                                                			return val.format('d/m/Y');
                                                                		}
                                                            },
                                                            {
                                                                header:etiquetaCarpeta,
                                                                width:120,
                                                                hidden:true,
                                                                sortable:true,
                                                                dataIndex:'carpetaAdministrativa'
                                                                
                                                            },
                                                            {
                                                                header:'Fecha de registro',
                                                                width:130,
                                                                
                                                                sortable:true,
                                                                dataIndex:'fechaRegistro',
                                                                renderer:function(val)
                                                                		{
                                                                			return val.format('d/m/Y H:i:s');
                                                                		}
                                                            },
                                                            {
                                                                header:'Registrado por',
                                                                width:300,
                                                                sortable:true,
                                                                dataIndex:'responsableRegistro'
                                                            },
                                                             {
                                                                header:'Status alerta',
                                                                width:160,
                                                                sortable:true,
                                                                dataIndex:'situacion',
                                                                renderer:function(val)
                                                                		{
																			return '<b>'+formatearValorRenderer(arrStatusAlerta,val)+'</b>';
                                                                		}
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                            {
                                                                id:'gAlertasNotificaciones',
                                                                store:alDatos,
                                                                title:'Alertas/Notificaciones',
                                                                region:'center',
                                                                frame:false,
                                                                cm: cModelo,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                columnLines : true, 
                                                                
                                                                tbar: 	[
                                                               				{
																				html:'<b>Mostrar alertas/notificaciones del:&nbsp;&nbsp;</b>'
                                                               				},
                                                               				{
                                                               					xtype:'datefield',
                                                               					id:'txtFechaInicio',
                                                               					listeners:  {
                                                              									select:recargarGridAlertas
                                                               								},
                                                               					value:minFechaAlerta
                                                               				},
                                                               				{
																				html:'&nbsp;&nbsp;<b>al&nbsp;&nbsp;</b>'
                                                               				},
                                                               				{
                                                               					xtype:'datefield',
                                                               					id:'txtFechaFin',
                                                               					listeners:  {
                                                              									select:recargarGridAlertas
                                                               								},
                                                               					value:maxFechaAlerta
                                                               				},
                                                               				{
																				html:'&nbsp;&nbsp;&nbsp;'
                                                               				},
                                                               				cmbStatusAlertas,
                                                               				
                                                               				'-',
                                                               				{
																				icon:'../images/icon_big_tick.gif',
																				cls:'x-btn-text-icon',
                                                                                hidden:gE('sL').value=='1',
																				id:'btnAtendidaAlerta',
																				text:'Marcar como atendida',
																				handler:function()
																						{
																							var fila=gEx('gAlertasNotificaciones').getSelectionModel().getSelected();
																							if(!fila)
																							{
																								msgBox('Debe seleccionar la alerta/notificaci&oacute;n a marcar como atendida');
																								return;
																							}
																							mostrarVentanaAtendida(fila);
																						}

																			},
                                                               				'-',
                                                               				{
																				icon:'../images/cross.png',
																				cls:'x-btn-text-icon',
                                                                                hidden:gE('sL').value=='1',
																				id:'btnCancelarAlerta',
																				text:'Cancelar alerta/notificaci&oacute;n',
																				handler:function()
																						{
																							var fila=gEx('gAlertasNotificaciones').getSelectionModel().getSelected();
																							if(!fila)
																							{
																								msgBox('Debe seleccionar la alerta/notificaci&oacute;n que desea cancelar');
																								return;
																							}
																							mostrarVentanaCancelar(fila);
																						}

																			},
                                                               				'-',
                                                               				{
																				icon:'../images/clock_add.png',
																				cls:'x-btn-text-icon',
																				id:'btnCrearAlerta',
                                                                                hidden:gE('sL').value=='1',
																				text:'Crear alerta/notificaci&oacute;n',
																				handler:function()
																						{
																							
																							mostrarVentanaCrearAlerta();
																						}

																			}
                                                                		],
                                                                		                                                               
                                                                view:new Ext.grid.GroupingView({
                                                                                                    forceFit:false,
                                                                                                    showGroupName: false,
                                                                                                    enableGrouping :true,
                                                                                                    enableNoGroups:false,
                                                                                                    enableGroupingMenu:false,
                                                                                                    hideGroupedColumn: false,
                                                                                                    enableRowBody:true,
                                                                                                    groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "alertas/notificaciones" : "alerta/notificaci&oacute;n"]})',
						                                                                            getRowClass : formatearFilaNotificacion,
                                                                                                    startCollapsed:false
                                                                                                })
                                                            }
                                                        );
        
        tblGrid.getSelectionModel().on('rowselect',function(sm,nFila,registro)
												{
													gEx('btnAtendidaAlerta').disable();
													if(registro.data.situacion=='1')
													{
														gEx('btnAtendidaAlerta').enable();
														gEx('btnCancelarAlerta').enable();
													}
												}
									)
        tblGrid.getSelectionModel().on('rowdeselect',function(sm,nFila,registro)
													{
														gEx('btnAtendidaAlerta').disable();
														gEx('btnCancelarAlerta').disable();

													}
										)
        return 	tblGrid;	
}

function formatearFilaNotificacion(record, rowIndex, p, ds) 
{
	var xf = Ext.util.Format;   
    
	p.body = 	'<table width="100%"><tr><td width="20"></td><td>';
   	p.body +=		'<table width="800">';
	p.body +=			'<tr height="21"><td valign="top" ><span class="TSJDF_Control">'+record.data.descripcion+'<br></span></td></tr>';
	switch(record.data.situacion)
	{
		case '2':
		p.body +=			'<tr height="21"><td valign="top" ><span class="TSJDF_Etiqueta"><br>Motivo de la cancelaci&oacute;n (Cancelado por: '+record.data.responsableCancelacion+'):</span></td></tr>';
		p.body +=			'<tr height="21"><td valign="top" ><span class="TSJDF_Control">'+record.data.comentariosAlerta+'<br></span></td></tr>';
		break;
		case '3':
		p.body +=			'<tr height="21"><td valign="top" ><span class="TSJDF_Etiqueta"><br>Comentarios de la atenci&oacute;n (Atendido por: '+record.data.responsableCancelacion+'):</span></td></tr>';
		p.body +=			'<tr height="21"><td valign="top" ><span class="TSJDF_Control">'+(record.data.comentariosAlerta.trim()==''?'(Sin comentarios)':record.data.comentariosAlerta.trim())+'<br></span></td></tr>';
		break;
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
																			fI:gEx('txtFechaInicio').getValue().format('Y-m-d'),
																			fF:gEx('txtFechaFin').getValue().format('Y-m-d'),
																			cA:gE('carpetaAdministrativa').value,
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
										title: 'Datos prescripci&oacute;n ['+etiquetaCarpeta+': <span style="color: #900 !important;" id="lblCarpeta"></span>]',
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
                                            				html:'Comentarios adicionales:'
                                            				
                                            			},
                                            			{
                                            				xtype:'textarea',
                                            				x:10,
                                            				y:40,
                                            				width:550,
                                            				height:100,
                                            				id:'txtComentariosAdicionales'
                                            			}
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Marcar alerta/notificaci&oacute;n como atendida',
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
																	gEx('txtComentariosAdicionales').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
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

function mostrarVentanaCancelar(fila)
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
                                            				html:'Motivo de la cancelaci&oacute;n:'
                                            				
                                            			},
                                            			{
                                            				xtype:'textarea',
                                            				x:10,
                                            				y:40,
                                            				width:550,
                                            				height:100,
                                            				id:'txtMotivoCancelacionAlerta'
                                            			}
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Cancelar alerta/notificaci&oacute;n',
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
																	gEx('txtMotivoCancelacionAlerta').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
															handler: function()
																	{
																	
																		if(gEx('txtMotivoCancelacionAlerta').getValue().trim()=='')
																		{
																			function respA()
																			{	
																				gEx('txtMotivoCancelacionAlerta').focus();
																			}
																			msgBox('Debe ingresar el motivo de la cancelaci&oacute;n de la alerta/notificaci&oacute;n',respA);
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
																						gEx('gAlertasNotificaciones').getStore().reload();
																						ventanaAM.close();
																					}
																					else
																					{
																						msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
																					}
																				}
																				obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=159&iA='+fila.data.idRegistro+'&s=2&c='+cv(gEx('txtMotivoCancelacionAlerta').getValue()),true);
																			}
																		}
																		msgConfirm('Est&aacute; seguro de querer cancelar la alerta/notificaci&oacute;n seleccionada',resp);
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

function mostrarVentanaCrearAlerta()
{
	var cmbTipoAlerta=crearComboExt('cmbTipoAlerta',[['1','General'],['2','Personal']],180,175);
	
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                            				x:10,
                                            				y:10,
                                            				html:'Fecha de alerta/notificaci&oacute;n:'
                                            			},
                                            			{
                                            				x:180,
                                            				y:5,
                                            				xtype:'datefield',
                                            				id:'dteFechaAlerta'
                                            			},
                                            			{
                                            				x:10,
                                            				y:40,
                                            				html:'Comentario de alerta/notificaci&oacute;n:'
                                            			},
                                            			{
                                            				x:10,
                                            				y:70,
                                            				width:560,
                                            				xtype:'textarea',
                                            				height:80,
                                            				id:'txtComentarioAlerta'
                                            			},
                                            			{
                                            				x:10,
                                            				y:180,
                                            				html:'Tipo de alerta/notificaci&oacute;n:'
                                            			},
                                            			cmbTipoAlerta
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Crear alerta/notificaci&oacute;n',
										width: 620,
										height:300,
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
																		var dteFechaAlerta=gEx('dteFechaAlerta');
																		var txtComentarioAlerta=gEx('txtComentarioAlerta');
																		if(dteFechaAlerta.getValue()=='')
																		{
																			function resp1()
																			{
																				dteFechaAlerta.focus();
																			}
																			msgBox('Debe ingresar la fecha de la alerta/notificaci&oacute;n',resp1);
																			return;
																		}
																		
																		
																		if(txtComentarioAlerta.getValue().trim()=='')
																		{
																			function resp2()
																			{
																				txtComentarioAlerta.focus();
																			}
																			msgBox('Debe ingresar el comentario de la alerta/notificaci&oacute;n',resp2);
																			return;
																		}
																		
																		
																		if(cmbTipoAlerta.getValue()=='')
																		{
																			function resp3()
																			{
																				cmbTipoAlerta.focus();
																			}
																			msgBox('Debe ingresar el tipo de alerta/notificaci&oacute;n',resp3);
																			return;
																		}
																		
																		var cadObj='{"carpetaAdministrativa":"'+gE('carpetaAdministrativa').value+
																				'","fechaAlerta":"'+dteFechaAlerta.getValue().format('Y-m-d')+
																				'","comentarios":"'+cv(txtComentarioAlerta.getValue())+
																				'","tipoAlerta":"'+cmbTipoAlerta.getValue()+'"}';
																		
																		function funcAjax()
																		{
																			var resp=peticion_http.responseText;
																			arrResp=resp.split('|');
																			if(arrResp[0]=='1')
																			{
                                                                            
                                                                            	if(	(dteFechaAlerta.getValue()<gEx('txtFechaInicio').getValue()))
                                                                                {
                                                                                	gEx('txtFechaInicio').setValue(dteFechaAlerta.getValue());
                                                                                }
                                                                                
                                                                                if(	(dteFechaAlerta.getValue()>gEx('txtFechaFin').getValue()))
                                                                                {
                                                                                	gEx('txtFechaFin').setValue(dteFechaAlerta.getValue());
                                                                                }
                                                                                
                                                                            
																				gEx('gAlertasNotificaciones').getStore().reload();
																				ventanaAM.close();
																			}
																			else
																			{
																				msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
																			}
																		}
																		obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=160&cadObj='+cadObj,true);
																		
																	
																	
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
            if(gE('txtFileName'))
	            gE('txtFileName').value=arrDatos[2];
            
			var arrAlertas='';
            var gAlertas=gEx('gAlertas');
            var x;
            var f;
            for(x=0;x<gAlertas.getStore().getCount();x++)
            {
                f=gAlertas.getStore().getAt(x);
                
                if(f.data.fechaAlerta=='')
                {
                    function respDoc2()
                    {
                        gAlertas.startEditing(x,2);
                    }
                    
                    msgBox('Debe ingresar la fecha de la alerta',respDoc2);
                    return;
                }
                
                if(f.data.descripcionAlerta.trim()=='')
                {
                    function respDoc()
                    {
                        gAlertas.startEditing(x,3);
                    }
                    msgBox('Debe ingresar la descripci&oacute;n de la alerta',respDoc);
                    return;
                }
                
                oAlerta='{"fechaAlerta":"'+f.data.fechaAlerta.format('Y-m-d')+'","textoAlerta":"'+cv(f.data.descripcionAlerta)+'"}';
                if(arrAlertas=='')
                    arrAlertas=oAlerta;
                else
                    arrAlertas+=','+oAlerta;
            }
            
            var cadObj='{"idGeneracionDocumento":"-1","tipoDocumento":"'+nodoPlantillaSel.id+'","tituloDocumento":"'+cv(arrDatos[2])+'","perfilValidacion":"'+
            		nodoPlantillaSel.attributes.perfilValidacion+'","fechaLimite":"","modificaSituacionCarpeta":"0","situacion":"'+
                        '","descripcionActuacion":"'+cv(gEx('txtDescripcion').getValue())+'","carpetaAdministrativa":"'+
                        gE('carpetaAdministrativa').value+'","nombreArchivoTemp":"'+arrDatos[1]+'","nombreArchivo":"'+arrDatos[2]+
                        '","idFormulario":"-1","idRegistro":"-1","arrAlertas":['+arrAlertas+']}';
            
            
            if(nodoPlantillaSel.attributes.funcionJSParametros!='')
            {
            	var ventanaAM=gEx('vInfoDocumento');
            	eval(nodoPlantillaSel.attributes.funcionJSParametros+'(cadObj,ventanaAM);');
            }
            else
            {
                var anchoVentana=(obtenerDimensionesNavegador()[1]*0.9);
                var altoVentana=(obtenerDimensionesNavegador()[0]*0.9);
                
                function funcAjax()
                {
                    var resp=peticion_http.responseText;
                    arrResp=resp.split('|');
                    if(arrResp[0]=='1')
                    {
                        objConf={
                                    tipoDocumento:nodoPlantillaSel.id,
                                    idFormulario:-2,
                                    rol:'158_0',
                                    ancho:anchoVentana,
                                    alto:altoVentana,
                                    rolDefault:'158_0',
                                    idRegistro: arrResp[1],
                                    idRegistroFormato:arrResp[2],
                                    functionAfterValidate:function()
                                                    {
                                                        gEx('gDocumentos').getStore().reload();
                                                    },
                                    functionAfterTurn:function()
                                                    {
                                                        gEx('gDocumentos').getStore().reload();
                                                    },
                                    functionAfterSaveDocument:function()
                                                                {
                                                                    gEx('gDocumentos').getStore().reload();
                                                                }
      
                                 };
                        gEx('gDocumentos').getStore().reload();
                        gEx('vInfoDocumento').close();
                        mostrarVentanaGeneracionDocumentos(objConf);
                        
                        
                    }
                    else
                    {
                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                    }
                }
                obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=144&cadObj='+cadObj,true);
                
			}
            
		}
		
	} 
    catch (e) 
	{
		alert(e);
	}
}


function registrarNuevaSolicitudAudienciaAlzada()
{
	var obj={};
    obj.ancho='100%';
    obj.alto='100%';
    obj.params=[['idCarpeta',gE('idCarpetaAdministrativa').value]];
    obj.url='../modulosEspeciales_SGJP/tblAgendaEventosAlzada.php';
    abrirVentanaFancy(obj);
    
}
var selPersona='';
function accionRegistroAudiencia()
{
	gEx('gridAudiencias').getStore().reload();
	cerrarVentanaFancy();
}

function crearPanelPartesProcesales()
{
	var cmbDetalle_P=crearComboExt('cmbDetalle_P',[],200,5,150);
	if(cmbDetalle_P.getStore().getCount()==0)
    	cmbDetalle_P.hide();
    
    var cmbNacionalidad_P=crearComboExt('cmbNacionalidad_P',arrNacionalidadesCP,160,65,200);
    cmbNacionalidad_P.hide();
    
    cmbNacionalidad_P.on('select',function(cmb,registro)				
    							{
                                	if(registro.data.id=='77777')
                                    {
                                    	gEx('lblNacionalidadEspecifique_P').show();
                                        gEx('txtOtraNacionalidad_P').show();
                                    }
                                    else
                                    {
                                    	gEx('lblNacionalidadEspecifique_P').hide();
                                        gEx('txtOtraNacionalidad_P').hide();
                                        gEx('txtOtraNacionalidad_P').setValue('');
                                    }
                                }
    				)
    var cmbGenero_P=crearComboExt('cmbGenero_P',arrGeneroCP,95,155,130);
    var cmbEstadoCivil_P=crearComboExt('cmbEstadoCivil_P',arrEstadoCivilCP,95,185,135);
    
    var cmbIdentificacion_P=crearComboExt('cmbIdentificacion_P',arrTipoIdentificacion,420,185,280);
    
    cmbIdentificacion_P.on('select',function(cmb,registro)					
    								{
                                    	if(registro.data.id=='99')
                                        {
                                        	gEx('txtEspecifique_P').show();
                                        	gEx('txtEspecifique_P').focus(10,false);
                                        }
                                        else
                                        {
                                        	gEx('txtEspecifique_P').setValue('');
                                        	gEx('txtEspecifique_P').hide();
                                        	
                                        }
                                    }
    						)
        
	var cmbEstado=crearComboExt('cmbEstado',arrEstados,70,65,170);
    cmbEstado.on('select',obtenerMunicipios);
    var cmbMunicipio=crearComboExt('cmbMunicipio',[],320,65,180);
    
    if(gE('sL').value=='1')
    {
    	cmbDetalle_P.disable();
    	cmbNacionalidad_P.disable();
    	cmbGenero_P.disable();
        cmbEstadoCivil_P.disable();
        cmbIdentificacion_P.disable();
    	cmbEstado.disable();
        cmbMunicipio.disable();
    }
	var panel= new Ext.Panel	(
    								{
                                    	layout:'border',
                                        id:'panelPartes',
                                        title:'Partes procesales',
                                        items:	[
                                        			{
                                                        xtype:'panel',
                                                        layout:'border',
                                                        region:'west',
                                                        width:250,
                                                        title:'Partes procesales',
                                                        items:	[
                                                                    crearArbolSujetosProcesalesAdmon()
                                                                ]
                                                    },
                                                    {
                                                        xtype:'panel',
                                                        layout:'border',
                                                        region:'center',
                                                        items:	[
                                                        			{	
                                                                    	xtype:'panel',
                                                                    	region:'center',
                                                                        defaultType: 'label',
                                                                        layout:'absolute',
                                                                        baseCls: 'x-plain',
                                                                        bodyStyle:{"font: normal 11px tahoma,arial,helvetica,sans-serif;background-color":"#E8E8E8","font-size":"11px"},                                                                                                           
                                                                        items:	[
                                                                        			{
                                                                                    	xtype:'tabpanel',
                                                                                        activeTab:1,
                                                                                        height:270,
                                                                                        id:'panelGenerales',
                                                                                        baseCls: 'x-plain',
                                                                        				tbar:	[
                                                                                                    {
                                                                                                        icon:'../images/guardar.JPG',
                                                                                                        cls:'x-btn-text-icon',
                                                                                                        disabled:true,
                                                                                                        hidden:gE('sL').value=='1',
                                                                                                        id:'btnGuardarIdentificacion',
                                                                                                        text:'Guardar datos de identificacion',
                                                                                                        handler:function()
                                                                                                                {
                                                                                                                    guardarDatosIdentificacion();
                                                                                                                }
                                                                                                        
                                                                                                    }
                                                                                                ],
                                                                                        region:'center',
                                                                                        items:	[
                                                                                        			{
                                                                                                    	xtype:'panel',
                                                                                                        baseCls: 'x-plain',
                                                                                                        id:'panelIdentificacion',
                                                                                                        disabled:true,
                                                                                                        listeners:	{
                                                                                                                        show:function(p)
                                                                                                                                {
                                                                                                                                    if(!p.disabled)
                                                                                                                                        gEx('btnGuardarIdentificacion').enable();
                                                                                                                                    
                                                                                                                                    
                                                                                                                                }
                                                                                                                    },
                                                                                                        title:'Datos de identificaci&oacute;n',
                                                                                                        defaultType: 'label',
                                                                                                        layout:'absolute',
                                                                                                        items:	[
                                                                                                        			{
                                                                                                                        x:10,
                                                                                                                        y:10,
                                                                                                                        html:'<b><span style="color:#900" id="lblNombreTipo_P"></span></b>'
                                                                                                                    },
                                                                                                                    cmbDetalle_P,
                                                                                                                    {
                                                                                                                        x:380,
                                                                                                                        y:10,
                                                                                                                        html:'Tipo de persona:'
                                                                                                                    },
                                                                                                                    {
                                                                                                                        xtype:'radio',
                                                                                                                        x:570,
                                                                                                                        y:5,
                                                                                                                        disabled:gE('sL').value=='1',
                                                                                                                        id: 'tipoPersona_1_P',
                                                                                                                        name: 'tipoPersona',
                                                                                                                        inputValue: 1,
                                                                                                                        checked:true,
                                                                                                                        listeners:	{
                                                                                                                                        check:tipoPersonaCheckPanel
                                                                                                                                    },
                                                                                                                        boxLabel: 'F&iacute;sica'
                                                                                                                    }, 
                                                                                                                    {
                                                                                                                        xtype:'radio',
                                                                                                                        x:670,
                                                                                                                        disabled:gE('sL').value=='1',
                                                                                                                        y:5,
                                                                                                                        id: 'tipoPersona_2_P',
                                                                                                                        name: 'tipoPersona',
                                                                                                                        inputValue: 2,
                                                                                                                        listeners:	{
                                                                                                                                        check:tipoPersonaCheckPanel
                                                                                                                                    },
                                                                                                                        boxLabel: 'Moral'
                                                                                                                    },
                                                                                                                    {
                                                                                                                        x:10,
                                                                                                                        y:40,
                                                                                                                        id:'lblNacionalidad_P',
                                                                                                                        html:'¿Es de nacionalidad mexicana?:'
                                                                                                                    },
                                                                                                                    {
                                                                                                                        xtype:'radio',
                                                                                                                        checked:true,
                                                                                                                        name:'nacionalidad',
                                                                                                                        id: 'nacionalidad_1_P',
                                                                                                                        inputValue: 1,
                                                                                                                        x:200,
                                                                                                                        disabled:gE('sL').value=='1',
                                                                                                                        y:35,
                                                                                                                        listeners:	{
                                                                                                                                        check:tipoNacionalidadCheckPanel
                                                                                                                                    },
                                                                                                                        boxLabel: 'S&iacute;'
                                                                                                                    }, 
                                                                                                                    {	
                                                                                                                        xtype:'radio',
                                                                                                                        name:'nacionalidad',
                                                                                                                        id: 'nacionalidad_0_P',
                                                                                                                        inputValue: 0,
                                                                                                                        x:300,
                                                                                                                        disabled:gE('sL').value=='1',
                                                                                                                        y:35,
                                                                                                                        listeners:	{
                                                                                                                                        check:tipoNacionalidadCheckPanel
                                                                                                                                    },
                                                                                                                        boxLabel: 'No'
                                                                                                                    }, 
                                                                                                                    {
                                                                                                                        xtype:'radio',
                                                                                                                        name:'nacionalidad',
                                                                                                                        id: 'nacionalidad_2_P',
                                                                                                                        inputValue: 2,
                                                                                                                        x:380,
                                                                                                                        y:35,
                                                                                                                        disabled:gE('sL').value=='1',
                                                                                                                        listeners:	{
                                                                                                                                        check:tipoNacionalidadCheckPanel
                                                                                                                                    },
                                                                                                                        boxLabel: 'Mexicana / Otro'
                                                                                                                    }, 
                                                                                                                    {
                                                                                                                        xtype:'radio',
                                                                                                                        name:'nacionalidad',
                                                                                                                        id: 'nacionalidad_3_P',
                                                                                                                        inputValue: 3,
                                                                                                                        x:520,
                                                                                                                        disabled:gE('sL').value=='1',
                                                                                                                        y:35,
                                                                                                                        listeners:	{
                                                                                                                                        check:tipoNacionalidadCheckPanel
                                                                                                                                    },
                                                                                                                        boxLabel: 'No especificada'
                                                                                                                    },
                                                                                                                    {
                                                                                                                        x:10,
                                                                                                                        y:70,
                                                                                                                        hidden:true,
                                                                                                                       
                                                                                                                        id:'lblNacionalidadIndique_P',
                                                                                                                        html:'Indique la nacionalidad:'
                                                                                                                    },
                                                                                                                    cmbNacionalidad_P,
                                                                                                                    {
                                                                                                                        x:380,
                                                                                                                        y:70,
                                                                                                                        hidden:true,
                                                                                                                        
                                                                                                                        id:'lblNacionalidadEspecifique_P',
                                                                                                                        html:'Especifique:'
                                                                                                                    },
                                                                                                                    {
                                                                                                                        x:490,
                                                                                                                        y:65,
                                                                                                                        hidden:true,
                                                                                                                        width:200,
                                                                                                                        xtype:'textfield',
                                                                                                                        disabled:gE('sL').value=='1',
                                                                                                                        id:'txtOtraNacionalidad_P'
                                                                                                                    },
                                                                                                                    {
                                                                                                                        x:10,
                                                                                                                        y:100,
                                                                                                                        id:'lblRFC_P',
                                                                                                                        html:'RFC:'
                                                                                                                    },
                                                                                                                    {
                                                                                                                        x:95,
                                                                                                                        y:95,
                                                                                                                        xtype:'textfield',
                                                                                                                        id:'txtRFC_P',
                                                                                                                        width:145,
                                                                                                                        disabled:gE('sL').value=='1',
                                                                                                                        enableKeyEvents:true,
                                                                                                                        listeners:	{
                                                                                                                                        keypress:function(txt,e)
                                                                                                                                            {
                                                                                                                                                if(e.charCode=='13')
                                                                                                                                                {
                                                                                                                                                    if(txt.ultimaBusqueda!=txt.getValue())
                                                                                                                                                    {
                                                                                                                                                        //buscarPorRFC(txt.getValue());
                                                                                                                                                    }
                                                                                                                                                }
                                                                                                                                            },
                                                                                                                                        blur:function(txt)
                                                                                                                                            {
                                                                                                                                                
                                                                                                                                                if(txt.ultimaBusqueda!=txt.getValue())
                                                                                                                                                {
                                                                                                                                                    //buscarPorRFC(txt.getValue());
                                                                                                                                                }
                                                                                                                                                
                                                                                                                                            }
                                                                                                                                    }
                                                                                                                    },
                                                                                                                    {
                                                                                                                        x:255,
                                                                                                                        y:100,
                                                                                                                        id:'lblCURP',
                                                                                                                        html:'CURP:'
                                                                                                                    },
                                                                                                                    {
                                                                                                                        x:350,
                                                                                                                        y:95,
                                                                                                                        disabled:gE('sL').value=='1',
                                                                                                                        xtype:'textfield',
                                                                                                                        id:'txtCURP_P',
                                                                                                                        width:170
                                                                                                                    },
                                                                                                                    {
                                                                                                                        x:535,
                                                                                                                        y:100,
                                                                                                                        id:'lblCedula_P',
                                                                                                                        html:'C&eacute;dula profesional:'
                                                                                                                    },
                                                                                                                    {
                                                                                                                        x:680,
                                                                                                                        y:95,
                                                                                                                        disabled:gE('sL').value=='1',
                                                                                                                        xtype:'numberfield',
                                                                                                                        allowDecimals:false,
                                                                                                                        allowNegative:false,
                                                                                                                        id:'txtCedula_P',
                                                                                                                        
                                                                                                                        width:110,
                                                                                                                        enableKeyEvents:true,
                                                                                                                        listeners:	{
                                                                                                                                        keypress:function(txt,e)
                                                                                                                                            {
                                                                                                                                                if(e.charCode=='13')
                                                                                                                                                {
                                                                                                                                                    if(txt.ultimaBusqueda!=txt.getValue())
                                                                                                                                                    {
                                                                                                                                                        //buscarCedulaProfesional(txt.getValue());
                                                                                                                                                    }
                                                                                                                                                }
                                                                                                                                            },
                                                                                                                                        blur:function(txt)
                                                                                                                                            {
                                                                                                                                                
                                                                                                                                                if(txt.ultimaBusqueda!=txt.getValue())
                                                                                                                                                {
                                                                                                                                                    //buscarCedulaProfesional(txt.getValue());
                                                                                                                                                }
                                                                                                                                                
                                                                                                                                            }
                                                                                                                                    }
                                                                                                                    },
                                                                                                                    {
                                                                                                                        x:10,
                                                                                                                        y:130,
                                                                                                                        id:'lblNombre_P',
                                                                                                                        html:'Nombre: <span style="color:#F00">*</span>'
                                                                                                                    },
                                                                                                                    {
                                                                                                                        xtype:'textfield',
                                                                                                                        width:145,
                                                                                                                        disabled:gE('sL').value=='1',
                                                                                                                        id:'txtNombre_P',
                                                                                                                        x:95,
                                                                                                                        y:125
                                                                                                                    },
                                                                                                                    {
                                                                                                                        xtype:'textfield',
                                                                                                                        width:650,
                                                                                                                        hidden:true,
                                                                                                                        disabled:gE('sL').value=='1',
                                                                                                                        id:'txtRazonSocial_P',
                                                                                                                        x:115,
                                                                                                                        y:125
                                                                                                                    },
                                                                                                                    {
                                                                                                                        x:255,
                                                                                                                        y:130,
                                                                                                                        id:'lblApPaterno_P',
                                                                                                                        html:'Ap. Paterno: <span style="color:#F00">*</span>'
                                                                                                                    },
                                                                                                                    {
                                                                                                                        xtype:'textfield',
                                                                                                                        width:110,
                                                                                                                        disabled:gE('sL').value=='1',
                                                                                                                        id:'txtApPaterno_P',
                                                                                                                        x:350,
                                                                                                                        y:125
                                                                                                                    },
                                                                                                                    {
                                                                                                                        x:535,
                                                                                                                        y:130,
                                                                                                                        id:'lblApMaterno_P',
                                                                                                                        html:'Ap. Materno:'
                                                                                                                    },
                                                                                                                    {
                                                                                                                        xtype:'textfield',
                                                                                                                        width:110,
                                                                                                                        disabled:gE('sL').value=='1',
                                                                                                                        id:'txtApMaterno_P',
                                                                                                                        x:680,
                                                                                                                        y:125
                                                                                                                    },
                                                                                                                    {
                                                                                                                        x:10,
                                                                                                                        y:160,
                                                                                                                        id:'lblGenero_P',
                                                                                                                        html:'G&eacute;nero: <span style="color:#F00">*</span>'
                                                                                                                    },
                                                                                                                    cmbGenero_P,
                                                                                                                    {
                                                                                                                        x:255,
                                                                                                                        y:160,
                                                                                                                        id:'lblFechaNac_P',
                                                                                                                        html:'Fecha Nac.:'
                                                                                                                    },
                                                                                                                    {
                                                                                                                        x:335,
                                                                                                                        y:155,
                                                                                                                        xtype:'datefield',
                                                                                                                        disabled:gE('sL').value=='1',
                                                                                                                        id:'fechaNacimiento_P',
                                                                                                                        listeners:	{
                                                                                                                        				select:function(dte)
                                                                                                                                        		{
                                                                                                                                                	var edad=calcularEdadParticipante(dte.getValue());
                                                                                                                                                    gEx('txtEdad_P').setValue(edad);
                                                                                                                                                }
                                                                                                                        			}
                                                                                                                    },
                                                                                                                    {
                                                                                                                        x:460,
                                                                                                                        y:160,
                                                                                                                        id:'lblEdad_P',
                                                                                                                        html:'Edad:'
                                                                                                                    },
                                                                                                                    {
                                                                                                                        xtype:'numberfield',
                                                                                                                        width:60,
                                                                                                                        x:540,
                                                                                                                        y:155,
                                                                                                                        disabled:gE('sL').value=='1',
                                                                                                                        id:'txtEdad_P'
                                                                                                                    },
                                                                                                                    {
                                                                                                                        x:10,
                                                                                                                        y:190,
                                                                                                                        id:'lblEdoCivil_P',
                                                                                                                        html:'Estado civil:'
                                                                                                                    },
                                                                                                                    cmbEstadoCivil_P,
                                                                                                                    {
                                                                                                                        x:255,
                                                                                                                        y:190,
                                                                                                                        id:'lblIdentificacion_P',
                                                                                                                        xtype:'label',
                                                                                                                        html:'Identificaci&oacute;n presentada:'
                                                        
                                                                                                                        
                                                                                                                    },
                                                                                                                    cmbIdentificacion_P,
                                                                                                                    
                                                                                                                    {
                                                                                                                        xtype:'textfield',
                                                                                                                        x:710,
                                                                                                                        y:185,
                                                                                                                        disabled:gE('sL').value=='1',
                                                                                                                        hidden:true,
                                                                                                                        id:'txtEspecifique_P',
                                                                                                                        widht:250
                                                                                                                    }
                                                                                                        		]
                                                                                                    },
                                                                                                    crearGridAliasPanel()
                                                                                                    <?php
																									if($tipoMateria=="P")
																									{
																									?>
                                                                                                    ,
                                                                                                    crearGridCuentasAcceso()
                                                                                        			<?php
																									}
																									?>
                                                                                                ]
                                                                                    }
                                                                        		]
                                                                    },
                                                        			{
                                                                        id:'pContacto',
                                                                        xtype:'panel',
                                                                        collapsible:true,
                                                                        region:'south',
                                                                        height:250,
                                                                        title:'Datos de contacto',
                                                                        layout:'border',
                                                                        items:	[
                                                                                    {
                                                                                          xtype:'tabpanel',
                                                                                          id:'panelContacto',
                                                                                          activeTab:1,
                                                                                          disabled:true,
                                                                                          region:'center',  
                                                                                          tbar:	[
                                                                                                    {
                                                                                                        icon:'../images/guardar.JPG',
                                                                                                        cls:'x-btn-text-icon',
                                                                                                        hidden:gE('sL').value=='1',
                                                                                                        text:'Guardar datos de contacto',
                                                                                                        handler:function()
                                                                                                                {
                                                                                                                    guardarDatosContacto();
                                                                                                                }
                                                                                                        
                                                                                                    }
                                                                                                ],                                                                                
                                                                                          items:	[
                                                                                                      {
                                                                                                          xtype:'panel',
                                                                                                          id:'pDomicilio',
                                                                                                          layout:'absolute',
                                                                                                          title:'Domicilio',
                                                                                                          
                                                                                                          bodyStyle:{"background-color":"#E8E8E8","font-size":"11px"}, 
                                                                                                          defaultType: 'label',
                                                                                                          items:	[
                                                                                                                      {
                                                                                                                          x:10,
                                                                                                                          y:10,
                                                                                                                          html:'Calle:'
                                                                                                                      },
                                                                                                                      {
                                                                                                                          x:70,
                                                                                                                          y:5,
                                                                                                                          xtype:'textfield',
                                                                                                                          width:410,
                                                                                                                          disabled:gE('sL').value=='1',
                                                                                                                          id:'txtCalle'
                                                                                                                      },
                                                                                                                      {
                                                                                                                          x:510,
                                                                                                                          y:10,
                                                                                                                          html:'No. Ext:'
                                                                                                                      },
                                                                                                                      {
                                                                                                                          x:590,
                                                                                                                          y:5,
                                                                                                                          disabled:gE('sL').value=='1',
                                                                                                                          xtype:'textfield',
                                                                                                                          width:120,
                                                                                                                          id:'txtNoExt'
                                                                                                                      },
                                                                                                                      {
                                                                                                                          x:10,
                                                                                                                          y:40,
                                                                                                                          html:'No. Int:'
                                                                                                                      },
                                                                                                                      {
                                                                                                                          x:70,
                                                                                                                          y:35,
                                                                                                                          disabled:gE('sL').value=='1',
                                                                                                                          xtype:'textfield',
                                                                                                                          width:120,
                                                                                                                          id:'txtNoInt'
                                                                                                                      },
                                                                                                                      {
                                                                                                                          x:250,
                                                                                                                          y:40,
                                                                                                                          html:'Colonia:'
                                                                                                                      },
                                                                                                                      {
                                                                                                                          x:320,
                                                                                                                          y:35,
                                                                                                                          disabled:gE('sL').value=='1',
                                                                                                                          xtype:'textfield',
                                                                                                                          width:160,
                                                                                                                          id:'txtColonia'
                                                                                                                      },
                                                                                                                      {
                                                                                                                          x:510,
                                                                                                                          y:40,
                                                                                                                          html:'C.P.:'
                                                                                                                      },
                                                                                                                      {
                                                                                                                          x:590,
                                                                                                                          y:35,
                                                                                                                          disabled:gE('sL').value=='1',
                                                                                                                          xtype:'textfield',
                                                                                                                          width:100,
                                                                                                                          id:'txtCP'
                                                                                                                      },
                                                                                                                      {
                                                                                                                          x:10,
                                                                                                                          y:70,
                                                                                                                          html:'Estado:'
                                                                                                                      },
                                                                                                                      cmbEstado,
                                                                                                                      
                                                                                                                      {
                                                                                                                          x:250,
                                                                                                                          y:70,
                                                                                                                          html:'Municipio:'
                                                                                                                      },
                                                                                                                     cmbMunicipio,
                                                                                                                      {
                                                                                                                          x:510,
                                                                                                                          y:70,
                                                                                                                          html:'Localidad:'
                                                                                                                      },
                                                                                                                      {
                                                                                                                          x:590,
                                                                                                                          y:65,
                                                                                                                          xtype:'textfield',
                                                                                                                          width:160,
                                                                                                                          disabled:gE('sL').value=='1',
                                                                                                                          id:'txtLocalidad'
                                                                                                                      },
                                                                                                                      {
                                                                                                                          x:10,
                                                                                                                          y:100,
                                                                                                                          html:'Entre la calle:'
                                                                                                                      },
                                                                                                                      {
                                                                                                                          x:105,
                                                                                                                          y:95,
                                                                                                                          xtype:'textfield',
                                                                                                                          width:270,
                                                                                                                          disabled:gE('sL').value=='1',
                                                                                                                          id:'txtEntreCalle'
                                                                                                                      },
                                                                                                                      {
                                                                                                                          x:395,
                                                                                                                          y:100,
                                                                                                                          html:'y la calle:'
                                                                                                                      },
                                                                                                                      {
                                                                                                                          x:470,
                                                                                                                          y:95,
                                                                                                                          disabled:gE('sL').value=='1',
                                                                                                                          xtype:'textfield',
                                                                                                                          width:280,
                                                                                                                          id:'txtYCalle'
                                                                                                                      },
                                                                                                                      {
                                                                                                                          x:10,
                                                                                                                          y:130,
                                                                                                                          html:'Otras referencias:'
                                                                                                                      },
                                                                                                                      {
                                                                                                                          x:130,
                                                                                                                          y:125,
                                                                                                                          xtype:'textarea',
                                                                                                                          width:620,
                                                                                                                          height:35,
                                                                                                                          
                                                                                                                          id:'txtReferencias'
                                                                                                                      }
                                                                                                                  ]
                                                                                                      },
                                                                                                      {
                                                                                                          xtype:'panel',
                                                                                                          layout:'absolute',
                                                                                                          id:'pMail',
                                                                                                          title:'Correo electr&oacute;nico - Tel&eacute;fonos',
                                                                                                          bodyStyle:{"background-color":"#E8E8E8","font-size":"11px"}, 
                                                                                                          defaultType: 'label',
                                                                                                          items:	[
                                                                                                                        crearGridTelefono(),
                                                                                                                        crearGridMail()
                                                                                                                    ]
                                                                                                      }
                                                                                                  ]
                                                                                      }
                                                                                ]
                                                                    }
                                                                ]
                                                    }
                                        		]
                                    }
    							)
	
    gEx('panelGenerales').setActiveTab(0);
    gEx('panelContacto').setActiveTab(0);
    return panel;                                
}

function crearArbolSujetosProcesalesAdmon()
{
	var raiz=new  Ext.tree.AsyncTreeNode(
											{
												id:'-1',
												text:'Raiz',
												draggable:false,
												expanded :false,
												cls:'-1'
											}
										)
										
	var cargadorArbol=new Ext.tree.TreeLoader(
                                                {
                                                    baseParams:{
                                                                    funcion:'19',
                                                                    iC:gE('idCarpetaAdministrativa').value,
                                                                    cA:gE('carpetaAdministrativa').value,
                                                                    sujetosProcesales:listParteProcesal
                                                                },
                                                    dataUrl:'../paginasFunciones/funcionesModulosEspeciales_Notificaciones.php'
                                                }
                                            )		
										
	cargadorArbol.on('beforeload',function(c)
    						{
                            	nodoSujetoSel=null;
                                gEx('btnDelParticipante').disable();
                                gEx('btnAddRelacion').disable();
                                gEx('btnDelRelacion').disable();
                                gEx('btnActivateParticipante').disable();
                                gEx('btnActivateRelacion').disable();
                                gEx('btnHistorialPartes').disable();
                               
                            }
    				)	
    										
	cargadorArbol.on('load',function(c,nodoCarga)
    						{
                            	if(selPersona!='')
                                {
                                	var nodo=gEx('arbolSujetosAdmon').getNodeById(selPersona);
                                    gEx('arbolSujetosAdmon').getSelectionModel().select(nodo);
                                    funcSujeto(nodo);
                                }
                            }
    				)										
	var arbolSujetosJuridicos=new Ext.tree.TreePanel	(
                                                            {
                                                                id:'arbolSujetosAdmon',
                                                                useArrows:true,
                                                                animate:true,
                                                                enableDD:false,
                                                                ddScroll:true,
                                                                containerScroll: true,
                                                                autoScroll:true,
                                                                border:false,
                                                                region:'center',
                                                                root:raiz,
                                                                loader: cargadorArbol,
                                                                rootVisible:false,
                                                                tbar:	[
                                                                			{
                                                                                icon:'../images/add.png',
                                                                                cls:'x-btn-text-icon',
                                                                                hidden:gE('sL').value=='1',
                                                                                text:'Agregar parte...',
                                                                                menu:	<?php echo $arrPartes?>
                                                                                
                                                                            },'-',
                                                                            {
                                                                                icon:'../images/cog.png',
                                                                                cls:'x-btn-text-icon',
                                                                                hidden:gE('sL').value=='1',
                                                                                text:'Otras acciones...',
                                                                                menu:	[
                                                                                			{
                                                                                                icon:'../images/accept_green.png',
                                                                                                cls:'x-btn-text-icon',
                                                                                                id:'btnActivateParticipante',
                                                                                                disabled:true,
                                                                                                text:'Dar de alta participante',
                                                                                                handler:function()
                                                                                                        {
                                                                                                            mostrarVentanaModificarStatusParticipante(1,1);
                                                                                                        }
                                                                                                
                                                                                            },
                                                                                			{
                                                                                                icon:'../images/cancel_round.png',
                                                                                                cls:'x-btn-text-icon',
                                                                                                id:'btnDelParticipante',
                                                                                                disabled:true,
                                                                                                text:'Dar de baja participante',
                                                                                                handler:function()
                                                                                                        {
                                                                                                            mostrarVentanaModificarStatusParticipante(1,2);
                                                                                                        }
                                                                                                
                                                                                            }
                                                                                            ,'-',
                                                                                            {
                                                                                                icon:'../images/bullet_green.png',
                                                                                                cls:'x-btn-text-icon',
                                                                                                id:'btnActivateRelacion',
                                                                                                disabled:true,
                                                                                                text:'Dar de alta relaci&oacute;n',
                                                                                                handler:function()
                                                                                                        {
                                                                                                            mostrarVentanaModificarStatusParticipante(2,1);
                                                                                                        }
                                                                                                
                                                                                            },
                                                                                            {
                                                                                                icon:'../images/bullet_red.png',
                                                                                                cls:'x-btn-text-icon',
                                                                                                id:'btnDelRelacion',
                                                                                                disabled:true,
                                                                                                text:'Dar de baja la relaci&oacute;n',
                                                                                                handler:function()
                                                                                                        {
                                                                                                            mostrarVentanaModificarStatusParticipante(2,2);
                                                                                                        }
                                                                                                
                                                                                            },'-',
                                                                                            {
                                                                                                icon:'../images/user_add.png',
                                                                                                cls:'x-btn-text-icon',
                                                                                                id:'btnAddRelacion',
                                                                                                disabled:true,
                                                                                                text:'Agregar nueva relaci&oacute;n',
                                                                                                handler:function()
                                                                                                        {
                                                                                                            mostrarVentanaAgregarRelacionParticipante();
                                                                                                        }
                                                                                                
                                                                                            },'-',
                                                                                            {
                                                                                                icon:'../images/report.png',
                                                                                                cls:'x-btn-text-icon',
                                                                                                id:'btnHistorialPartes',
                                                                                                disabled:true,
                                                                                                text:'Ver historial',
                                                                                                handler:function()
                                                                                                        {
                                                                                                            verHistorialParte();
                                                                                                        }
                                                                                                
                                                                                            }
                                                                                			
                                                                                		]
                                                                                
                                                                            }
                                                                            
                                                                		]
                                                            }
                                                        )
         
         
                                                    
	arbolSujetosJuridicos.on('click',funcSujeto);
	return  arbolSujetosJuridicos;
}

function funcSujeto(nodo, evento)
{
	nodoSujetoSel=nodo;
	gEx('btnDelParticipante').disable();
    gEx('btnAddRelacion').disable();
    gEx('btnDelRelacion').disable();
    gEx('btnActivateParticipante').disable();
    gEx('btnActivateRelacion').disable();
    
    if(nodo.attributes.tipo=='1')
    {
    	var arrDatosNodo=nodo.id.split('_');
        idParticipanteSel=arrDatosNodo[1];
        obtenerDatosContacto(idParticipanteSel);
        obtenerDatosIdentificacion(idParticipanteSel);
        gEx('panelContacto').enable();
        if(nodo.attributes.situacion=='1')
	        gEx('btnDelParticipante').enable();
        else
        	gEx('btnActivateParticipante').enable()
        
        var pos=existeValorMatriz(arrParteProcesal,nodo.attributes.personaJuridica);

        if((arrParteProcesal[pos][3].length>0)&&(nodo.attributes.situacion=='1'))
	        gEx('btnAddRelacion').enable();
        
        gEx('btnHistorialPartes').enable();

        
    }
    else
    {
    	if(nodo.attributes.tipo=='5')
        {
        	if(nodo.attributes.situacion=='1')
	        	gEx('btnDelRelacion').enable();
            else
            	gEx('btnActivateRelacion').enable();
                
            gEx('btnHistorialPartes').enable();
        }
    	limpiarDatosIdentificacion();
    	limpiarDatosContacto();
        gEx('panelGenerales').setActiveTab(0);
        gEx('panelIdentificacion').disable();
        gEx('btnGuardarIdentificacion').disable();
        gEx('gAliasPanel').disable();
        gEx('panelContacto').disable();
        
    }
    
    
}


function crearGridTelefono()
{
	var cmbTipoTelefono=crearComboExt('cmbTipoTelefono',arrTelefonos);
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'tipoTelefono'},
                                                                    {name: 'lada'},
                                                                    {name: 'numero'},
                                                                    {name: 'extension'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel();
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	
														chkRow,
														{
															header:'Tipo',
															width:100,
															sortable:true,
															dataIndex:'tipoTelefono',
                                                            editor:cmbTipoTelefono,
                                                            renderer:function(val)
                                                            		{
                                                                    	return formatearValorRenderer(arrTelefonos,val);
                                                                    }
														},
														{
															header:'Lada',
															width:45,
															sortable:true,
															dataIndex:'lada',
                                                            editor:	{
                                                            			xtype:'textfield'
                                                            		}
														},
                                                        {
															header:'N&uacute;mero',
															width:130,
															sortable:true,
															dataIndex:'numero',
                                                            editor:	{
                                                            			xtype:'textfield'
                                                            		}
														},
                                                        {
															header:'Extensi&oacute;n',
															width:80,
															sortable:true,
															dataIndex:'extension',
                                                            editor:	{
                                                            			xtype:'numberfield',
                                                                        allowDecimals:false,
                                                                        allowNegative:false
                                                            		}
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gTelefonos',
                                                            store:alDatos,
                                                            frame:false,
                                                            border:true,
                                                            x:10,
                                                            y:10,
                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            stripeRows :true,                                                            
                                                            columnLines : true,
                                                            height:150,
                                                            width:420,
                                                            sm:chkRow,
                                                            tbar:	[
                                                            			{
                                                                        	icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            hidden:gE('sL').value=='1',
                                                                            text:'Agregar tel&eacute;fono',
                                                                            handler:function()
                                                                            		{
                                                                                    	var reg=crearRegistro	(
                                                                                        							[
                                                                                                                    	{name: 'tipoTelefono'},
                                                                                                                        {name: 'lada'},
                                                                                                                        {name: 'numero'},
                                                                                                                        {name: 'extension'}
                                                                                                                    ]
                                                                                        						)
                                                                                   		var r=new reg	(
                                                                                        					{
                                                                                                            	tipoTelefono:'1',
                                                                                                                lada:'',
                                                                                                                numero:'',
                                                                                                                extension:''
                                                                                                            }
                                                                                        				)
                                                                                   
                                                                                    	gEx('gTelefonos').getStore().add(r);
                                                                                        gEx('gTelefonos').startEditing(gEx('gTelefonos').getStore().getCount()-1,1);
                                                                                    }
                                                                            
                                                                        },'-',
                                                                        {
                                                                        	icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            hidden:gE('sL').value=='1',
                                                                            text:'Remover tel&eacute;fono',
                                                                            handler:function()
                                                                            		{
                                                                                    	var fila=gEx('gTelefonos').getSelectionModel().getSelected();
                                                                                        if(!fila)
                                                                                        {
                                                                                        	msgBox('Debe seleccionar el tel&eacute;fono a remover');
                                                                                        	return;
                                                                                        }
                                                                                        function resp(btn)
                                                                                        {
                                                                                        	if(btn=='yes')
                                                                                            {
                                                                                            	gEx('gTelefonos').getStore().remove(fila);
                                                                                            }
                                                                                        }
                                                                                        msgConfirm('Est&aacute; seguro de querer remover el tel&eacute;fono seleccionado?',resp);
                                                                                       
                                                                                        
                                                                                    }
                                                                            
                                                                        }
                                                                        
                                                            		]
                                                        }
                                                    );
	
    tblGrid.on('beforeedit',function(e) 
    						{
                            	
                            	if(gE('sL').value=='1')
                                	e.cancel=true;
                            }
    			)  
    return 	tblGrid;	
}

function crearGridMail()
{
	
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'mail'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel();
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	chkRow,
                                                        {
															header:'E-Mail',
															width:250,
															sortable:true,
															dataIndex:'mail',
                                                            editor:	{
                                                            			xtype:'textfield'
                                                            		}
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gMail',
                                                            store:alDatos,
                                                            frame:false,
                                                            border:true,
                                                            x:440,
                                                            y:10,
                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            stripeRows :true,                                                            
                                                            columnLines : true,
                                                            height:150,
                                                            width:300,
                                                            sm:chkRow,
                                                            tbar:	[
                                                            			{
                                                                        	icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            hidden:gE('sL').value=='1',
                                                                            text:'Agregar E-Mail',
                                                                            handler:function()
                                                                            		{
                                                                                    	var reg=crearRegistro	(
                                                                                        							[
                                                                                                                    	{name: 'mail'}
                                                                                                                    ]
                                                                                        						)
                                                                                   		var r=new reg	(
                                                                                        					{
                                                                                                            	mail:''
                                                                                                            }
                                                                                        				)
                                                                                   
                                                                                    	gEx('gMail').getStore().add(r);
                                                                                        gEx('gMail').startEditing(gEx('gMail').getStore().getCount()-1,1);
                                                                                    }
                                                                            
                                                                        },'-',
                                                                        {
                                                                        	icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            hidden:gE('sL').value=='1',
                                                                            text:'Remover E-Mail',
                                                                            handler:function()
                                                                            		{
                                                                                    	var fila=gEx('gMail').getSelectionModel().getSelected();
                                                                                        if(!fila)
                                                                                        {
                                                                                        	msgBox('Debe seleccionar la direcci&oacute;n de e-mail a remover');
                                                                                        	return;
                                                                                        }
                                                                                        
                                                                                        function resp(btn)
                                                                                        {
                                                                                        	if(btn=='yes')
                                                                                            {
                                                                                            	gEx('gMail').getStore().remove(fila);
                                                                                            }
                                                                                        }
                                                                                        msgConfirm('Est&aacute; seguro de querer remover el e-mail seleccionado?',resp);
                                                                                       
                                                                                        
                                                                                    }
                                                                            
                                                                        }
                                                                        
                                                            		]
                                                        }
                                                    );
                                                    
	tblGrid.on('beforeedit',function(e) 
    						{
                            	
                            	if(gE('sL').value=='1')
                                	e.cancel=true;
                            }
    			)                                                   
	return 	tblGrid;	
}

function obtenerDatosContacto(idParticipanteContacto)
{

	function funcAjax(peticion_http)
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	limpiarDatosContacto();
        	oDatosContacto=eval('['+arrResp[1]+']')[0];

        	var telefonos='';
            var x;
            var o;
            var e;
            if(oDatosContacto.telefonos.length>0)
            {
            	for(x=0;x<oDatosContacto.telefonos.length;x++)	
                {
                	o=oDatosContacto.telefonos[x];
                	var reg=crearRegistro	(
                                                [
                                                    {name: 'tipoTelefono'},
                                                    {name: 'lada'},
                                                    {name: 'numero'},
                                                    {name: 'extension'}
                                                ]
                                            )
                    var r=new reg	(
                                        {
                                            tipoTelefono:o.tipoTelefono,
                                            lada:o.lada,
                                            numero:o.numero,
                                            extension:o.extension
                                        }
                                    )
               
                    gEx('gTelefonos').getStore().add(r);
                
                
                	
                    
                }
                
            }
            
            var email='';
            
            if(oDatosContacto.correos.length>0)
            {
            	
            	for(x=0;x<oDatosContacto.correos.length;x++)	
                {
                	o=oDatosContacto.correos[x];
                    var reg=crearRegistro	(
                                                [
                                                    {name: 'mail'}
                                                ]
                                            )
                    var r=new reg	(
                                        {
                                            mail:o.mail
                                        }
                                    )
               
                    gEx('gMail').getStore().add(r);
                }

            }
            
            gEx('txtCalle').setValue(oDatosContacto.calle);
            gEx('txtNoExt').setValue(oDatosContacto.noExt);
            gEx('txtNoInt').setValue(oDatosContacto.noInt);
            gEx('txtColonia').setValue(oDatosContacto.colonia);
            gEx('txtCP').setValue(oDatosContacto.cp);
			gEx('cmbEstado').setValue(oDatosContacto.estado);
            var pos=obtenerPosFila(gEx('cmbEstado').getStore(),'id',oDatosContacto.estado);
            if(pos>-1)
            {
                var registro=gEx('cmbEstado').getStore().getAt(pos);
                obtenerMunicipios(gEx('cmbEstado'),registro,function()
                                                {
                                                    gEx('cmbMunicipio').setValue(oDatosContacto.municipio);
                                                }
                                    )
                
			}            
            gEx('txtLocalidad').setValue(oDatosContacto.localidad);
            gEx('txtEntreCalle').setValue(oDatosContacto.entreCalle);
            gEx('txtYCalle').setValue(oDatosContacto.yCalle);
            gEx('txtReferencias').setValue(escaparBR(oDatosContacto.referencias));
            
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWebV2('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=116&idParticipante='+idParticipanteContacto,true);


	
}


function limpiarDatosContacto()
{
	gEx('txtCalle').setValue('');
    gEx('txtNoExt').setValue('');
    gEx('txtNoInt').setValue('');
    gEx('txtColonia').setValue('');
    gEx('txtCP').setValue('');
    gEx('txtCalle').setValue('');
    
    gEx('cmbEstado').setValue('');
    gEx('cmbMunicipio').setValue('');
    gEx('txtLocalidad').setValue('');
    gEx('txtEntreCalle').setValue('');
    gEx('txtYCalle').setValue('');
    gEx('txtReferencias').setValue('');
    gEx('gTelefonos').getStore().removeAll();
    gEx('gMail').getStore().removeAll();
}

function guardarDatosContacto()
{
	var txtCalle=gEx('txtCalle');
    var txtNoExt=gEx('txtNoExt');
    var txtNoInt=gEx('txtNoInt');
    var txtColonia=gEx('txtColonia');
    var txtCP=gEx('txtCP');
    var txtLocalidad=gEx('txtLocalidad');
    var txtEntreCalle=gEx('txtEntreCalle');
    var txtYCalle=gEx('txtYCalle');
    var txtReferencias=gEx('txtReferencias');
    var cmbEstado=gEx('cmbEstado');
    var cmbMunicipio=gEx('cmbMunicipio');
    
    var arrTelefonos='';
    
    var x;
    var fila;
    var o;
    for(x=0;x<gEx('gTelefonos').getStore().getCount();x++)
    {
        fila=gEx('gTelefonos').getStore().getAt(x);
        
        if(fila.data.numero=='')
        {
            function respTel()
            {
                gEx('gTelefonos').startEditing(x,3);
            }
            msgBox('Debe ingresar el n&uacute;mero telef&oacute;nico a agregar',respTel);
            return;
        }
        
        o='{"tipoTelefono":"'+fila.data.tipoTelefono+'","lada":"'+fila.data.lada+
            '","numero":"'+fila.data.numero+'","extension":"'+fila.data.extension+'"}';
        if(arrTelefonos=='')
            arrTelefonos=o;
        else
            arrTelefonos+=','+o;
    }
    
    var arrMail='';
    
    for(x=0;x<gEx('gMail').getStore().getCount();x++)
    {
        fila=gEx('gMail').getStore().getAt(x);
        if(!validarCorreo(fila.data.mail))
        {
            function respMail()
            {
            	gEx('panelContacto').setActiveTab(1);
                gEx('gMail').startEditing(x,1);
            }
            msgBox('El e-mail ingresado no es v&aacute;lido',respMail);
            return;
        }
        o='{"mail":"'+fila.data.mail+'"}';
        if(arrMail=='')
            arrMail=o;
        else
            arrMail+=','+o;
    }
    
    
    var cadObj='{"calle":"'+cv(txtCalle.getValue())+'","noExt":"'+cv(txtNoExt.getValue())+
                '","noInt":"'+cv(txtNoInt.getValue())+'","colonia":"'+cv(txtColonia.getValue())+
                '","cp":"'+cv(txtCP.getValue())+'","estado":"'+cmbEstado.getValue()+
                '","municipio":"'+cmbMunicipio.getValue()+'","localidad":"'+cv(txtLocalidad.getValue())+
                '","entreCalle":"'+cv(txtEntreCalle.getValue())+'","yCalle":"'+cv(txtYCalle.getValue())+
                '","referencias":"'+cv(txtReferencias.getValue())+'","arrTelefonos":['+arrTelefonos+
                '],"mail":['+arrMail+'],"idFormulario":"-47",'+
                '"idRegistro":"-1","idParticipante":"'+idParticipanteSel+'"}';
    
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            msgBox('La informaci&oacute;n ha sido almacenada correctamente');
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=117&cadObj='+cadObj,true);
    
}

function obtenerDatosIdentificacion(idParticipanteContacto)
{
	function funcAjax(peticion_http)
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	limpiarDatosIdentificacion();
        	var oDatos=eval(arrResp[1])[0];
			if(oDatos.tipoPersona=='')
            	oDatos.tipoPersona='1';
            gE('lblNombreTipo_P').innerHTML=formatearValorRenderer(arrParteProcesal,nodoSujetoSel.attributes.personaJuridica);
            
            var pos=existeValorMatriz(arrParteProcesal,nodoSujetoSel.attributes.personaJuridica);
            var cmbDetalle_P=gEx('cmbDetalle_P');

            cmbDetalle_P.getStore().loadData(arrParteProcesal[pos][2]);
            cmbDetalle_P.setValue(oDatos.detalleTipo);
            if(cmbDetalle_P.getStore().getCount()==0)
                cmbDetalle_P.hide();
            else
            	cmbDetalle_P.show();
            
            
            gEx('tipoPersona_'+oDatos.tipoPersona+'_P').setValue(true);
            tipoPersonaCheckPanel(gEx('tipoPersona_'+oDatos.tipoPersona+'_P'),true);
            gEx('nacionalidad_'+oDatos.esMexicano+'_P').setValue(true);
            tipoNacionalidadCheckPanel(gEx('nacionalidad_'+oDatos.esMexicano+'_P'),true);
            gEx('cmbNacionalidad_P').setValue(oDatos.nacionalidad);
            dispararEventoSelectCombo('cmbNacionalidad_P');
            gEx('txtOtraNacionalidad_P').setValue(oDatos.otraNacionalidad);
            
            gEx('txtRFC_P').setValue(oDatos.rfcEmpresa);
            gEx('txtCURP_P').setValue(oDatos.curp);
            gEx('txtCedula_P').setValue(oDatos.cedulaProfesional);
            
            gEx('txtNombre_P').setValue(oDatos.nombre);
            gEx('txtRazonSocial_P').setValue(oDatos.nombre);
            gEx('txtApPaterno_P').setValue(oDatos.apellidoPaterno);
            gEx('txtApMaterno_P').setValue(oDatos.apellidoMaterno);
            
            
            gEx('cmbGenero_P').setValue(oDatos.genero);
            gEx('fechaNacimiento_P').setValue(oDatos.fechaNacimiento);
            gEx('txtEdad_P').setValue(oDatos.edad);
            gEx('cmbEstadoCivil_P').setValue(oDatos.estadoCivil);
            gEx('cmbIdentificacion_P').setValue(oDatos.tipoIdentificacion);
            dispararEventoSelectCombo('cmbIdentificacion_P');
            gEx('txtEspecifique_P').setValue(oDatos.otraIdentificacion);
          
          	var x;
            var r;
            var reg=new crearRegistro	(	
            								[
                                                {name: 'nombre'},
                                                {name: 'apPaterno'},
                                                {name: 'apMaterno'}
                                            ]
            							);
            for(x=0;x<oDatos.alias.length;x++)
            {
            	r=new reg(oDatos.alias[x]);
            	gEx('gAliasPanel').getStore().add(r);
            }
            if(gEx('panelGenerales').getActiveTab().id!='gCuentasUsuario')
	            gEx('btnGuardarIdentificacion').enable();
            gEx('panelIdentificacion').enable();
            gEx('gAliasPanel').enable();
            
        	
            
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWebV2('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=210&idActividad='+gE('idActividad').value+
    				'&figuraJuridica='+nodoSujetoSel.attributes.personaJuridica+'&idParticipante='+idParticipanteContacto,true);

}

function guardarDatosIdentificacion()
{
	
	var cmbDetalle=gEx('cmbDetalle_P');
    
	if(cmbDetalle.getStore().getCount()>0)
    {
        if(cmbDetalle.getValue()=='')
        {
            function resp301()
            {
                cmbDetalle.focus();
            }
            msgBox('Debe indicar el "tipo" del participante',resp301);
            return;
        }
        
    }
    
    var personaMoral=gEx('tipoPersona_2_P').getValue();
    
    var cadObj='';
    if(personaMoral)
    {
        if((gEx('txtRFC_P').getValue()!='')&&(gEx('txtRFC_P').getValue().length!=12))
        {
            function respRFC()
            {
                gEx('txtRFC_P').focus();
            }
            msgBox('La logitud del RFC debe ser de 12 caracteres',respRFC);
            return;
        }
        
        if(gEx('txtRazonSocial_P').getValue()=='')
        {
            function resp30()
            {
                gEx('txtRazonSocial_P').focus();
            }
            msgBox('Debe indicar la raz&oacute;n social de la persona moral',resp30);
            return;
        }
        
       cadObj='{"detallePersona":"'+cmbDetalle.getValue()+
                '","tipoPersona":"2","nombre":"'+cv(gEx('txtRazonSocial_P').getValue())+
                '","apPaterno":"","apMaterno":"","genero":"2","otraNacionalidad":"","nacionalidadMexicana":"3",'+
                '"nacionalidad":"","alias":[],"curp":"'+cv(gEx('txtCURP_P').getValue())+'","cedulaProfesional":"'+cv(gEx('txtCedula_P').getValue())+
                '","rfc":"'+cv(gEx('txtRFC_P').getValue())+'","fechaNacimiento":"'+
                (gEx('fechaNacimiento_P').getValue()==''?'':gEx('fechaNacimiento_P').getValue().format('Y-m-d'))+
                '","edad":"'+gEx('txtEdad_P').getValue()+'","estadoCivil":"'+gEx('cmbEstadoCivil_P').getValue()+
                '","identificacionPresentada":"'+gEx('cmbIdentificacion_P').getValue()+'","otraIdentificacion":"'+
                cv(gEx('txtEspecifique_P').getValue())+'","idPersona":"'+nodoSujetoSel.attributes.idPersona+'"}';
    }
    else
    {
        
        if(gEx('nacionalidad_0_P').getValue() || gEx('nacionalidad_2_P').getValue())
        {
            if(gEx('cmbNacionalidad_P').getValue()=='')
            {
                function resp1()
                {
                    gEx('cmbNacionalidad_P').focus();
                }
                msgBox('Debe indicar la nacionalidad de la persona f&iacute;sica',resp1);
                return;
            }
            
            if(gEx('cmbNacionalidad_P').getValue()=='77777')
            {
                if(gEx('txtOtraNacionalidad_P').getValue()=='')
                {
                    function resp2()
                    {
                        gEx('txtOtraNacionalidad_P').focus();
                    }
                    msgBox('Debe indicar la nacionalidad de la persona f&iacute;sica',resp2);
                    return;
                }
            }
        }
                           
        if((gEx('txtCURP_P').getValue()!='')&&(gEx('txtCURP_P').getValue().length!=18))
        {
            function respCURP()
            {
                gEx('txtCURP_P').focus();
            }
            msgBox('La logitud de la CURP debe ser de 18 caracteres',respCURP);
            return;
        }                   
                                                                                    
        if((gEx('txtRFC_P').getValue()!='')&&(gEx('txtRFC_P').getValue().length!=13))
        {
            function respRFC()
            {
                gEx('txtRFC_P').focus();
            }
            msgBox('La logitud del RFC debe ser de 13 caracteres',respRFC);
            return;
        }
        
        
        
        if(gEx('txtNombre_P').getValue()=='')
        {
            function resp3()
            {
                gEx('txtNombre_P').focus();
            }
            msgBox('Debe indicar el nombre de la persona f&iacute;sica',resp3);
            return;
        }
        
        if(gEx('txtApPaterno_P').getValue()=='')
        {
            function resp3AP()
            {
                gEx('txtApPaterno_P').focus();
            }
            msgBox('Debe indicar el apellido paterno de la persona f&iacute;sica',resp3AP);
            return;
        }
        
        if(gEx('cmbGenero_P').getValue()=='')
        {
            function resp4()
            {
                gEx('cmbGenero_P').focus();
            }
            msgBox('Debe indicar el g&eacute;nero de la persona f&iacute;sica',resp4);
            return;
        }
        
        var fila;
        var gAlias=gEx('gAliasPanel');
        var arrAlias='';
        var x=0;
        var o;
        for(x=0;x<gAlias.getStore().getCount();x++)
        {
            fila=gAlias.getStore().getAt(x);
            if((fila.data.nombre.trim()!='')||(fila.data.apPaterno.trim()!='')||(fila.data.apMaterno.trim()!=''))
            {
            
                o='{"nombre":"'+cv(fila.data.nombre)+'","apPaterno":"'+cv(fila.data.apPaterno)+'","apMaterno":"'+cv(fila.data.apMaterno)+'"}';
                if(arrAlias=='')
                    arrAlias=o;
                else
                    arrAlias+=','+o;
            }                                                                           
        }
        
        var nacionalidadMexicana='';
        
        if(gEx('nacionalidad_0_P').getValue())
        {
            nacionalidadMexicana=0;
        }
        
        if(gEx('nacionalidad_1_P').getValue())
        {
            nacionalidadMexicana=1;
        }
        
        if(gEx('nacionalidad_2_P').getValue())
        {
            nacionalidadMexicana=2;
        }
        
        if(gEx('nacionalidad_3_P').getValue())
        {
            nacionalidadMexicana=3;
        }
        
        
        cadObj='{"tipoPersona":"1","nombre":"'+cv(gEx('txtNombre_P').getValue())+'","apPaterno":"'+cv(gEx('txtApPaterno_P').getValue())+
                '","apMaterno":"'+cv(gEx('txtApMaterno_P').getValue())+'","nacionalidadMexicana":"'+nacionalidadMexicana+
                '","nacionalidad":"'+gEx('cmbNacionalidad_P').getValue()+'","otraNacionalidad":"'+cv(gEx('txtOtraNacionalidad_P').getValue())+
                '","genero":"'+gEx('cmbGenero_P').getValue()+'","alias":['+arrAlias+'],"detallePersona":"'+cmbDetalle.getValue()+
                '","curp":"'+cv(gEx('txtCURP_P').getValue())+'","cedulaProfesional":"'+cv(gEx('txtCedula_P').getValue())+
                '","rfc":"'+cv(gEx('txtRFC_P').getValue())+'","fechaNacimiento":"'+
                (gEx('fechaNacimiento_P').getValue()==''?'':gEx('fechaNacimiento_P').getValue().format('Y-m-d'))+
                '","edad":"'+gEx('txtEdad_P').getValue()+'","estadoCivil":"'+gEx('cmbEstadoCivil_P').getValue()+
                '","identificacionPresentada":"'+gEx('cmbIdentificacion_P').getValue()+'","otraIdentificacion":"'+
                cv(gEx('txtEspecifique_P').getValue())+'","idPersona":"'+nodoSujetoSel.attributes.idPersona+'"}';
    }
    
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            recargarArbolParticipantes(nodoSujetoSel.attributes.idPersona,'',nodoSujetoSel.attributes.personaJuridica);
            
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_Notificaciones.php',funcAjax, 'POST','funcion=32&cadObj='+cadObj,true);
}

function limpiarDatosIdentificacion()
{
	gEx('tipoPersona_1_P').setValue(true);
    tipoPersonaCheckPanel(gEx('tipoPersona_1_P'),true);
	gEx('nacionalidad_1_P').setValue(true);
    tipoNacionalidadCheckPanel(gEx('nacionalidad_1_P'),true);
    
    gEx('cmbNacionalidad_P').setValue('');
    gEx('txtOtraNacionalidad_P').setValue('');
    gEx('txtRFC_P').setValue('');
    gEx('txtCURP_P').setValue('');
    gEx('txtCedula_P').setValue('');
    gEx('txtNombre_P').setValue('');
    gEx('txtRazonSocial_P').setValue('');
    gEx('txtApPaterno_P').setValue('');
    gEx('txtApMaterno_P').setValue('');
    gEx('cmbGenero_P').setValue('');
    gEx('fechaNacimiento_P').setValue('');
    gEx('txtEdad_P').setValue('');
    gEx('cmbEstadoCivil_P').setValue('');
    gEx('cmbIdentificacion_P').setValue('');
    gEx('txtEspecifique_P').setValue('');
    gEx('txtEspecifique_P').hide();
    
  	gEx('gAliasPanel').getStore().removeAll();
    
}

function recargarArbolParticipantes(iP,n,tP)
{
	selPersona='p_'+iP+'_'+tP;
	gEx('arbolSujetosAdmon').getRootNode().reload();
    if(gEx('gCuentasUsuario'))
	    gEx('gCuentasUsuario').getStore().reload();
	 if(gEx('gridAutorizacionAudienciaVirtual'))
	    gEx('gridAutorizacionAudienciaVirtual').getStore().reload();        
}

function tipoPersonaCheckPanel(rdo,value)
{
	if(value)
    {
		switch(rdo.id)
        {
        	case 'tipoPersona_1_P':
            	gEx('lblNacionalidadIndique_P').hide();
                gEx('cmbNacionalidad_P').hide();
                gEx('cmbNacionalidad_P').setValue('');
                gEx('lblNacionalidadEspecifique_P').hide();
                gEx('txtOtraNacionalidad_P').hide();
                gEx('txtOtraNacionalidad_P').setValue('');
            	gEx('lblNombre_P').setText('Nombre: <span style="color:#F00">*</span>',false);
                gEx('txtRazonSocial_P').setValue('');
                gEx('txtRazonSocial_P').hide();
                
            	gEx('lblNacionalidad_P').show();
                gEx('nacionalidad_0_P').show();
                gEx('nacionalidad_1_P').show();
                gEx('nacionalidad_2_P').show();
                gEx('nacionalidad_3_P').show();
                gEx('txtNombre_P').show();
                gEx('txtApPaterno_P').show();
                gEx('txtApMaterno_P').show();
                gEx('lblApPaterno_P').show();
                gEx('lblApMaterno_P').show();
                gEx('lblGenero_P').show();
                gEx('cmbGenero_P').show();
                
                gEx('txtRFC_P').setPosition(95,95);
				
                gEx('lblCedula_P').show();
                gEx('txtCedula_P').show();
            
                gEx('lblCURP').show();
                gEx('txtCURP_P').show();
            
                gEx('lblFechaNac_P').show();
                gEx('fechaNacimiento_P').show();
            
                gEx('lblEdad_P').show();
                gEx('txtEdad_P').show();
            
                gEx('lblEdoCivil_P').show();
                gEx('cmbEstadoCivil_P').show();
            
                gEx('lblIdentificacion_P').show();
                gEx('cmbIdentificacion_P').show();
                gEx('txtEspecifique_P').show();
				                
            break;
            case 'tipoPersona_2_P':
            	gEx('lblNacionalidadIndique_P').hide();
                gEx('cmbNacionalidad_P').hide();
                gEx('cmbNacionalidad_P').setValue('');
                gEx('lblNacionalidadEspecifique_P').hide();
                gEx('txtOtraNacionalidad_P').hide();
                gEx('txtOtraNacionalidad_P').setValue('');
	            gEx('txtRazonSocial_P').show();
                gEx('txtRazonSocial_P').focus();
            	gEx('lblNombre_P').setText('Raz&oacute;n social: <span style="color:#F00">*</span>',false);
            	gEx('lblNacionalidad_P').hide();
                gEx('nacionalidad_0_P').hide();
                gEx('nacionalidad_1_P').hide();
                gEx('nacionalidad_2_P').hide();
                gEx('nacionalidad_3_P').hide();
                
                gEx('txtNombre_P').hide();
                gEx('txtApPaterno_P').hide();
                gEx('txtApMaterno_P').hide();
                
                gEx('txtNombre_P').setValue('');
                gEx('txtApPaterno_P').setValue('');
                gEx('txtApMaterno_P').setValue('');
                gEx('cmbGenero_P').setValue('');
                
                gEx('lblApPaterno_P').hide();
                gEx('lblApMaterno_P').hide();
                gEx('lblGenero_P').hide();
                gEx('cmbGenero_P').hide();
                gEx('txtRFC_P').setPosition(115,95);
                gEx('lblCedula_P').hide();
                gEx('txtCedula_P').hide();
                gEx('txtCedula_P').setValue('');
                gEx('lblCURP').hide();
                gEx('txtCURP_P').hide();
                gEx('txtCURP_P').setValue('');
                
                gEx('lblFechaNac_P').hide();
                gEx('fechaNacimiento_P').hide();
                gEx('fechaNacimiento_P').setValue('');
                gEx('lblEdad_P').hide();
                gEx('txtEdad_P').hide();
                gEx('txtEdad_P').setValue('');
                gEx('lblEdoCivil_P').hide();
                gEx('cmbEstadoCivil_P').hide();
                gEx('cmbEstadoCivil_P').setValue('');
                gEx('lblIdentificacion_P').hide();
                gEx('cmbIdentificacion_P').hide();
                gEx('cmbIdentificacion_P').setValue('');
                gEx('txtEspecifique_P').hide();
                gEx('txtEspecifique_P').setValue('');
                
            break;
            
        }
    }
}

function tipoNacionalidadCheckPanel(rdo,value)
{
	if(value)
    {
    	switch(rdo.id)
        {
        	case 'nacionalidad_0_P':
            case 'nacionalidad_2_P':
            	gEx('lblNacionalidadIndique_P').show();
                gEx('cmbNacionalidad_P').show();
            break;
            case 'nacionalidad_1_P':
            case 'nacionalidad_3_P':
            	gEx('lblNacionalidadIndique_P').hide();
                gEx('cmbNacionalidad_P').hide();
                gEx('lblNacionalidadEspecifique_P').hide();
                gEx('txtOtraNacionalidad_P').hide();
                gEx('txtOtraNacionalidad_P').setValue('');
                gEx('cmbNacionalidad_P').setValue('');
            break;
            
           
        }
    }
}


function crearGridAliasPanel()
{
	var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'nombre'},
                                                                    {name: 'apPaterno'},
                                                                    {name: 'apMaterno'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel();
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	chkRow,
														{
															header:'Nombre',
															width:220,
															sortable:true,
                                                            editor:	{xtype:'textfield'},
															dataIndex:'nombre'
														},
														{
															header:'Ap. Paterno',
															width:130,
															sortable:true,
                                                            editor:	{xtype:'textfield'},
															dataIndex:'apPaterno'
														},
														{
															header:'Ap. Materno',
															width:130,
															sortable:true,
                                                            editor:	{xtype:'textfield'},
															dataIndex:'apMaterno'
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                        	id:'gAliasPanel',
                                                            store:alDatos,
                                                            frame:false,
                                                            disabled:true,
                                                            title:'Registro de alias',
                                                            x:10,
                                                            y:190,
                                                            listeners:	{
                                                            				show:function(p)
                                                                            		{
                                                                                    	if(!p.disabled)
	                                                                                        gEx('btnGuardarIdentificacion').enable();
                                                                                    	setTimeout(function()
                                                                                        			{
                                                                                                    	gEx('gAliasPanel').getView().refresh();
                                                                                                    },500
                                                                                                    )
                                                                                    	
                                                                                    }
                                                            			},
                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            stripeRows :true,                                                            
                                                            columnLines : true,
                                                            height:150,
                                                            width:680,
                                                            sm:chkRow,
                                                            tbar:	[
                                                            			{
                                                                        	icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            hidden:gE('sL').value=='1',
                                                                            text:'Agregar alias',
                                                                            handler:function()
                                                                            		{
                                                                                    	var reg=crearRegistro(	[
                                                                                        							{name: 'nombre'},
                                                                                                                    {name: 'apPaterno'},
                                                                                                                    {name: 'apMaterno'}
                                                                                        						]);
                                                                                    
                                                                                    	var r=new reg	(
                                                                                        					{
                                                                                                                nombre:'',
                                                                                                                apPaterno:'',
                                                                                                                apMaterno:''
                                                                                                            }
                                                                                        				)
                                                                                    
                                                                                    	gEx('gAliasPanel').getStore().add(r);
                                                                                        gEx('gAliasPanel').startEditing(gEx('gAliasPanel').getStore().getCount()-1,1);
                                                                                        
                                                                                    }
                                                                            
                                                                        },'-',
                                                                        {
                                                                        	icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            hidden:gE('sL').value=='1',
                                                                            text:'Remover alias',
                                                                            handler:function()
                                                                            		{
                                                                                    	var fila=gEx('gAliasPanel').getSelectionModel().getSelected();
                                                                                        if(!fila)
                                                                                        {
                                                                                        	msgBox('Debe seleccionar el alias que desea remover');
                                                                                            return;
                                                                                        }
                                                                                        
                                                                                       gEx('gAliasPanel').getStore().remove(fila); 
                                                                                    }
                                                                            
                                                                        }
                                                                        
                                                            		]
                                                        }
                                                    );
	return 	tblGrid;		
}

function crearGridCuentasAcceso()
{
   var lector= new Ext.data.JsonReader({
                                        
                                        totalProperty:'numReg',
                                        fields: [
                                                    {name:'idUsuario'},
                                                    {name:'idRelacion'},
                                                    {name: 'nombre'},
                                                    {name:'figuraJuridica'},
                                                    {name: 'situacionCuenta'}
                                                ],
                                        root:'registros'
                                        
                                    }
                                  );
 
                                                                                  
    var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(
    
                                                                                              {
    
                                                                                                  url: '../paginasFunciones/funcionesModulosEspeciales_SGP.php'
    
                                                                                              }
    
                                                                                          ),
                                                            sortInfo: {field: 'nombre', direction: 'ASC'},
                                                            groupField: 'figuraJuridica',
                                                            remoteGroup:false,
                                                            remoteSort: false,
                                                            autoLoad:true
                                                            
                                                        }) 
    alDatos.on('beforeload',function(proxy)
                                    {
                                        proxy.baseParams.funcion='211';
                                        proxy.baseParams.idActividad=gE('idActividad').value;
                                        
                                    }
                        )   
   
    var cModelo= new Ext.grid.ColumnModel   	(
                                                    [
                                                        new  Ext.grid.RowNumberer(),
                                                        
                                                        {
                                                            header:'Nombre',
                                                            width:450,
                                                            sortable:true,
                                                            dataIndex:'nombre'
                                                        },
                                                        {
                                                            header:'Figura Jur&iacute;dica',
                                                            width:250,
                                                            sortable:true,
                                                            dataIndex:'figuraJuridica',
                                                            renderer:function(val)
                                                            		{
                                                                    	return formatearValorRenderer(arrParteProcesal,val);
                                                                    }
                                                        },
                                                        {
                                                            header:'Situaci&oacute;n cuenta',
                                                            width:200,
                                                            sortable:true,
                                                            dataIndex:'situacionCuenta',
                                                            renderer:function(val)
                                                            		{
                                                                    	return formatearValorRenderer(arrStatusCuenta,val);
                                                                    }
                                                        },
                                                        {
                                                            header:'',
                                                            width:30,
                                                            sortable:true,
                                                            dataIndex:'situacionCuenta',
                                                            renderer:function(val,meta,registro)
                                                            		{
                                                                    	if(val!='')
	                                                                    	return '<a href="javascript:verHistorial(\''+bE(registro.data.idRelacion)+'\')"><img src="../images/report.png" title="Ver historial de la cuenta" alt="Ver historial de la cuenta"></a>';
                                                                           
                                                                    }
                                                        },
                                                        {
                                                            header:'',
                                                            width:200,
                                                            sortable:true,
                                                            dataIndex:'situacionCuenta',
                                                            renderer:function(val,meta,registro)
                                                            		{
                                                                    	if(gE('sL').value=='1')
                                                                        	return '';
                                                                    	<?php
																		
                                                                    	if(!$servidorPruebas)
																		{
																			echo "return;";
                                                                        }
																		
																		?>
                                                                    	switch(val)
                                                                        {
                                                                        	case '':
                                                                            	return '<a href="javascript:crearCuentaAcceso(\''+bE(registro.data.idRelacion)+'\')"><img src="../images/user_go.png">&nbsp;&nbsp;Crear cuenta de acceso</a>';
                                                                            break;
                                                                            case '1':
                                                                            	return '<a href="javascript:desactivarCuentaAcceso(\''+bE(registro.data.idRelacion)+'\')"><img src="../images/user_remove.png">&nbsp;&nbsp;Desactivar cuenta de acceso</a>';
                                                                            break;
                                                                            case '2':
                                                                            	return '<a href="javascript:activarCuentaAcceso(\''+bE(registro.data.idRelacion)+'\')"><img src="../images/user.png">&nbsp;&nbsp;Activar cuenta de acceso</a>';
                                                                            break;
                                                                        }
                                                                    }
                                                        }
                                                    ]
                                                );
                                                
    var tblGrid=	new Ext.grid.GridPanel	(
                                                        {
                                                            id:'gCuentasUsuario',
                                                            title:'Adm&oacute;n cuentas de acceso',
                                                            store:alDatos,
                                                            frame:false,
                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            listeners:	{
                                                            				show:function()
                                                                            	{
                                                                                	gEx('btnGuardarIdentificacion').disable();
                                                                                    setTimeout(		function()
                                                                                        			{
                                                                                                    	gEx('gCuentasUsuario').getView().refresh();
                                                                                                    },500
                                                                                                )
                                                                                }
                                                            			},	
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

function crearCuentaAcceso(iR)
{
	/*if(gEx('gMail').getStore().getCount()==0)
    {
    	function respAcceso()
        {
        	gEx('panelContacto').setActiveTab(1);	
        }
        msgBox('Debe registrar almenos una direcci&oacute;n de correo electr&oacute;nico para la creaci&oacute;n de la cuenta',respAcceso);
    	return;
    }*/
	var pos=obtenerPosFila(gEx('gCuentasUsuario').getStore(),'idRelacion',bD(iR));
    var fila=gEx('gCuentasUsuario').getStore().getAt(pos);
	function resp(btn)
    {
    	if(btn=='yes')
        {
        	var cadObj='{"idActividad":"'+gE('idActividad').value+'","idParticipante":"'+fila.data.idUsuario+
            			'","idFiguraJuridica":"'+fila.data.figuraJuridica+'","idCarpeta":"'+gE('idCarpetaAdministrativa').value+
                        '","carpeta":"'+gE('carpetaAdministrativa').value+'"}';
        	function funcAjax()
            {
                var resp=peticion_http.responseText;
                arrResp=resp.split('|');
                if(arrResp[0]=='1')
                {
                    gEx('gCuentasUsuario').getStore().reload();
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=212&cadObj='+cadObj,true);
        }
    }
    msgConfirm('Est&aacute; seguro de querer crear la cuenta de acceso del usuario <b>'+fila.data.nombre+'</b>',resp);
}

function desactivarCuentaAcceso(iR)
{
	var pos=obtenerPosFila(gEx('gCuentasUsuario').getStore(),'idRelacion',bD(iR));
    var fila=gEx('gCuentasUsuario').getStore().getAt(pos);
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            html:'Comentarios adicionales:'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            width:550,
                                                            heght:60,
                                                            id:'txtComentariosAdicionales',
                                                            xtype:'textarea'
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Desactivar cuenta de acceso ['+fila.data.nombre+']',
										width: 600,
										height:200,
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
                                                                	gEx('txtComentariosAdicionales').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
																		function resp(btn)
                                                                        {
                                                                            if(btn=='yes')
                                                                            {
                                                                                var cadObj='{"idActividad":"'+gE('idActividad').value+'","idParticipante":"'+fila.data.idUsuario+
                                                                                			'","idFiguraJuridica":"'+fila.data.figuraJuridica+
                                                                                            '","situacionCuenta":"2","comentariosAdicionales":"'+cv(gEx('txtComentariosAdicionales').getValue())+
                                                                                            '","idCarpeta":"'+gE('idCarpetaAdministrativa').value+'","carpetaAdministrativa":"'+gE('carpetaAdministrativa').value+'"}';
                                                                                function funcAjax()
                                                                                {
                                                                                    var resp=peticion_http.responseText;
                                                                                    arrResp=resp.split('|');
                                                                                    if(arrResp[0]=='1')
                                                                                    {
                                                                                        if(gEx('gCuentasUsuario'))
	                                                                                        gEx('gCuentasUsuario').getStore().reload();
                                                                                        ventanaAM.close();
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                    }
                                                                                }
                                                                                obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=213&cadObj='+cadObj,true);
                                                                            }
                                                                        }
                                                                        msgConfirm('Est&aacute; seguro de querer desactivar la cuenta de acceso del usuario <b>'+fila.data.nombre+'</b>',resp);
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

function activarCuentaAcceso(iR)
{
	var pos=obtenerPosFila(gEx('gCuentasUsuario').getStore(),'idRelacion',bD(iR));
    var fila=gEx('gCuentasUsuario').getStore().getAt(pos);
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            html:'Comentarios adicionales:'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            width:550,
                                                            heght:60,
                                                            id:'txtComentariosAdicionales',
                                                            xtype:'textarea'
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Activar cuenta de acceso ['+fila.data.nombre+']',
										width: 600,
										height:200,
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
                                                                	gEx('txtComentariosAdicionales').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
																		function resp(btn)
                                                                        {
                                                                            if(btn=='yes')
                                                                            {
                                                                                
                                                                                var cadObj='{"idActividad":"'+gE('idActividad').value+'","idParticipante":"'+fila.data.idUsuario+
                                                                                			'","idFiguraJuridica":"'+fila.data.figuraJuridica+
                                                                                            '","situacionCuenta":"1","comentariosAdicionales":"'+cv(gEx('txtComentariosAdicionales').getValue())+
                                                                                            '","idCarpeta":"'+gE('idCarpetaAdministrativa').value+'","carpetaAdministrativa":"'+gE('carpetaAdministrativa').value+'"}';
                                                                                function funcAjax()
                                                                                {
                                                                                    var resp=peticion_http.responseText;
                                                                                    arrResp=resp.split('|');
                                                                                    if(arrResp[0]=='1')
                                                                                    {
                                                                                        if(gEx('gCuentasUsuario'))
	                                                                                        gEx('gCuentasUsuario').getStore().reload();
                                                                                        ventanaAM.close();
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                    }
                                                                                }
                                                                                obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=213&cadObj='+cadObj,true);
                                                                            }
                                                                        }
                                                                        msgConfirm('Est&aacute; seguro de querer activar la cuenta de acceso del usuario <b>'+fila.data.nombre+'</b>',resp);
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


function verHistorial(iR)
{
	var pos=obtenerPosFila(gEx('gCuentasUsuario').getStore(),'idRelacion',bD(iR));
    var fila=gEx('gCuentasUsuario').getStore().getAt(pos);
    
    var cadObj='{"idActividad":"'+gE('idActividad').value+'","idParticipante":"'+fila.data.idUsuario+
				'","idFiguraJuridica":"'+fila.data.figuraJuridica+'"}';

	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'border',
                                            frame:false,
											defaultType: 'label',
											items: 	[
														crearGridHistorial(cadObj)

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Historial',
										width: 900,
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

function crearGridHistorial(cadObj)
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idRegistro'},
                                                        {name:'fechaOperacion', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name:'etapaOriginal'},
		                                                {name:'etapaCambio'},
		                                                {name:'responsable'},
                                                        {name: 'comentariosAdicionales'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../paginasFunciones/funcionesModulosEspeciales_SGP.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'fechaOperacion', direction: 'DESC'},
                                                            groupField: 'fechaOperacion',
                                                            remoteGroup:false,
				                                            remoteSort: true,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='214';
                                        proxy.baseParams.cadObj=cadObj;
                                        
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer(),
                                                            {
                                                                header:'Fecha',
                                                                width:150,
                                                                sortable:true,
                                                                align:'center',
                                                                dataIndex:'fechaOperacion',
                                                                renderer:function(val)
                                                                		{
                                                                        
                                                                        	return formatoTitulo(val.format('d')+' de '+arrMeses[parseInt(val.format('m'))-1][1]+' de '+val.format('Y')+'<br>('+val.format('H:i:s')+' hrs.)');
                                                                        }
                                                            },
                                                            {
                                                                header:'Situaci&oacute;n anterior',
                                                                width:200,
                                                                sortable:true,
                                                                dataIndex:'etapaOriginal',
                                                                renderer:formatoTitulo2
                                                            },
                                                            {
                                                                header:'Situaci&oacute;n cambio',
                                                                width:200,
                                                                sortable:true,
                                                                dataIndex:'etapaCambio',
                                                                renderer:formatoTitulo2
                                                            },                                                            
                                                            {
                                                                header:'Responsable',
                                                                width:250,
                                                                sortable:true,
                                                                dataIndex:'responsable',
                                                                renderer:formatoTitulo3
                                                            }
                                                            
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                    {
                                                        id:'gridHistorialCuenta',
                                                        store:alDatos,
                                                        region:'center',
                                                        frame:false,
                                                        border:true,
                                                        cm: cModelo,
                                                        columnLines : false,
                                                        stripeRows :true,
                                                        loadMask:true,
                                                                                                                        
                                                        view:new Ext.grid.GroupingView({
                                                                                            forceFit:false,
                                                                                            showGroupName: false,
                                                                                            enableGrouping :false,
                                                                                            enableNoGroups:false,
                                                                                            enableGroupingMenu:false,
                                                                                            hideGroupedColumn: false,
                                                                                            startCollapsed:false,
                                                                                            enableRowBody:true,
                                                                                            getRowClass : formatearFilaHistorial
                                                                                        })
                                                    }
                                                );
        return 	tblGrid;	

}

function formatearFilaHistorial(record, rowIndex, p, ds)
{
	var xf = Ext.util.Format;
    p.body = '<BR><p style="margin-left: 4em;margin-right: 4em;text-align:justify"><br><span class="menu"><span style="color: #001C02">Comentarios:</span><br><br><span style="color: #3B3C3B">' + ((record.data.comentariosAdicionales.trim()=="")?"(Sin comentarios)":record.data.comentariosAdicionales) + '</span></p><br><br><br>';
    return 'x-grid3-row-expanded';
}

function formatoTitulo(val)
{
	return '<span style="font-size:11px; color:#040033">'+val+'</span>';
}

function formatoTitulo2(val)
{
	return '<div style="font-size:11px; color:#040033;; height:45px; word-wrap: break-word;white-space: normal; ">'+formatearValorRenderer(arrStatusCuenta,val)+'</div>';
}

function formatoTitulo3(val)
{
	return '<div style="font-size:11px; height:45px; color:#040033; word-wrap: break-word;white-space: normal;"><img src="../images/user_gray.png">'+(val)+'</div>';
}

function mostrarVentanaModificarStatusParticipante(tipoAccion,situacion)
{
	var leyenda='';
    var leyendaConfirmacion;
    var leyendaError='';

	switch(tipoAccion)
    {
    	case 1:
        	switch(situacion)
            {
            	case 1:
                	leyenda='Dar de alta participante ['+nodoSujetoSel.attributes.nombre+']';
                    leyendaConfirmacion=' dar de alta al participante: <b>'+nodoSujetoSel.attributes.nombre+'</b>';
                    
                break;
                case 0:
                	leyenda='Dar de baja participante ['+nodoSujetoSel.attributes.nombre+']';
                    leyendaConfirmacion=' dar de baja al participante: <b>'+nodoSujetoSel.attributes.nombre+'</b>';
                break;
            }
        break;
        case 2:
        	switch(situacion)
            {
            	case 1:
                	leyenda='Dar de alta relaci&oacute;n ['+nodoSujetoSel.parentNode.attributes.nombre+' --> '+nodoSujetoSel.attributes.nombre+']';
                    leyendaConfirmacion=' dar de alta la relaci&oacute;n <b>'+nodoSujetoSel.parentNode.attributes.nombre+' --> '+nodoSujetoSel.attributes.nombre+'</b>';
                break;
                case 0:
                	leyenda='Dar de baja relaci&oacute;n  ['+nodoSujetoSel.parentNode.attributes.nombre+' --> '+nodoSujetoSel.attributes.nombre+']';
                    leyendaConfirmacion=' dar de baja la relaci&oacute;n <b>'+nodoSujetoSel.parentNode.attributes.nombre+' --> '+nodoSujetoSel.attributes.nombre+'</b>';
                break;
            }
        
        break;
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
                                                            html:'Ingrese el motivo de la operaci&oacute;n:'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            width:550,
                                                            heght:60,
                                                            id:'txtComentariosAdicionales',
                                                            xtype:'textarea'
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: leyenda,
										width: 600,
										height:200,
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
                                                                	gEx('txtComentariosAdicionales').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
															handler: function()
																	{
																		var txtComentariosAdicionales=gEx('txtComentariosAdicionales');
                                                                        if(txtComentariosAdicionales.getValue()=='')
                                                                        {
                                                                            function respComentarios()
                                                                            {
                                                                                txtComentariosAdicionales.focus(false,500);
                                                                            }
                                                                            msgBox('Debe indicar el motivo de la operaci&oacute;n',respComentarios);
                                                                            return;
                                                                        }
                                                                        
																		function resp(btn)
                                                                        {
                                                                            if(btn=='yes')
                                                                            {
                                                                            	var idParticipante;
                                                                                var idFiguraJuridica;
                                                                                var idActorRelacionado;
                                                                                
                                                                                if(tipoAccion==1)
                                                                                {
                                                                                	idParticipante=nodoSujetoSel.attributes.idPersona;
                                                                                    idFiguraJuridica=nodoSujetoSel.attributes.personaJuridica;
                                                                                    idActorRelacionado=-1;
                                                                                }
                                                                                else
                                                                                {
                                                                                	idParticipante=nodoSujetoSel.parentNode.attributes.idPersona;
                                                                                    idFiguraJuridica=nodoSujetoSel.parentNode.attributes.personaJuridica;
                                                                                    idActorRelacionado=nodoSujetoSel.attributes.idPersona;
                                                                                }
                                                                                
                                                                                var cadObj='{"tipoAccion":"'+tipoAccion+'","situacion":"'+situacion+'","comentariosAdicionales":"'+
                                                                                		cv(gEx('txtComentariosAdicionales').getValue())+'","idActividad":"'+gE('idActividad').value+
                                                                                        '","idParticipante":"'+idParticipante+'","idFiguraJuridica":"'+idFiguraJuridica+
                                                                                        '","idActorRelacionado":"'+idActorRelacionado+'"}';
                                                                                
                                                                                function funcAjax()
                                                                                {
                                                                                    var resp=peticion_http.responseText;
                                                                                    arrResp=resp.split('|');
                                                                                    if(arrResp[0]=='1')
                                                                                    {
                                                                                        gEx('arbolSujetosAdmon').getRootNode().reload();
                                                                                        if(gEx('gCuentasUsuario'))
	                                                                                        gEx('gCuentasUsuario').getStore().reload();
                                                                                        ventanaAM.close();
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                    }
                                                                                }
                                                                                obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=215&cadObj='+cadObj,true);
                                                                            }
                                                                        }
                                                                        msgConfirm('Est&aacute; seguro de querer'+leyendaConfirmacion,resp);
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

function mostrarVentanaAgregarRelacionParticipante()
{
	var pos=existeValorMatriz(arrParteProcesal,nodoSujetoSel.attributes.personaJuridica);
	var listPartes='';
    var x;
    if(arrParteProcesal[pos][3]!='')
    {
    	var aFiguras=arrParteProcesal[pos][3].split(',');
        for(x=0;x<aFiguras.length;x++)
        {
            if(listPartes=='')
                listPartes=aFiguras[x];
            else   
                listPartes+=','+aFiguras[x];
        }
    }
	if(listPartes=='')
    {
    	listPartes='-1';
    }
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			crearArbolSujetosProcesalesRelacionSeleccionAlta(listPartes),
                                                        {
                                                        	x:10,
                                                            y:160,
                                                            html:'Comentarios adicionales:'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:190,
                                                            xtype:'textarea',
                                                            width:660,
                                                            height:60,
                                                            id:'txtComentarios'
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar nueva relaci&oacute;n',
										width: 720,
										height:340,
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
																		var listaRelacion='';
                                                                        var arrNodos=obtenerNodoChecados(gEx('arbolSujetosRelacionSeleccion').getRootNode());
                                                                        var x;
                                                                        for(x=0;x<arrNodos.length;x++)
                                                                        {
                                                                        	if(listaRelacion=='')
                                                                            {
                                                                            	listaRelacion=arrNodos[x].attributes.idPersona;
                                                                            }
                                                                            else
                                                                            {
                                                                            	listaRelacion+=','+arrNodos[x].attributes.idPersona;
                                                                            }
                                                                        }
                                                                        
                                                                        if(listaRelacion=='')
                                                                        {
                                                                        	msgBox('Debe seleccionar almenos una persona a agregar como nueva relaci&oacute;n');
                                                                        	return;
                                                                        }
                                                                        var idParticipante=nodoSujetoSel.attributes.idPersona;
                                                                        var idFiguraJuridica=nodoSujetoSel.attributes.personaJuridica;
                                                                        var cadObj='{"comentariosAdicionales":"'+cv(gEx('txtComentarios').getValue())+'","idActividad":"'+gE('idActividad').value+
                                                                                        '","idParticipante":"'+idParticipante+'","idFiguraJuridica":"'+idFiguraJuridica+'","listaRelaciones":"'+listaRelacion+'"}';
                                                                        
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                                gEx('arbolSujetosAdmon').getRootNode().reload();
                                                                                if(gEx('gCuentasUsuario'))
	                                                                                gEx('gCuentasUsuario').getStore().reload();
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=216&cadObj='+cadObj,true);
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

function crearArbolSujetosProcesalesRelacionSeleccionAlta(listPartes)
{
	

   	var raiz=new  Ext.tree.AsyncTreeNode(
											{
												id:'-1',
												text:'Raiz',
												draggable:false,
												expanded :false,
												cls:'-1'
											}
										)
										
	var cargadorArbol=new Ext.tree.TreeLoader(
                                                {
                                                    baseParams:{
                                                                    funcion:'19',
                                                                    iC:gE('idCarpetaAdministrativa').value,
                                                                    cA:gE('carpetaAdministrativa').value,
                                                                    check:1,
                                                                    sujetosProcesales:listPartes
                                                                },
                                                    dataUrl:'../paginasFunciones/funcionesModulosEspeciales_Notificaciones.php'
                                                }
                                            )		
										
	cargadorArbol.on('beforeload',function(c)
    						{
                            }
    				)	
    										
	cargadorArbol.on('load',function(c,nodoCarga)
    						{
                            	
                            }
    				)										
	var arbolSujetosRelacionSeleccion=new Ext.tree.TreePanel	(
                                                                    {
                                                                        id:'arbolSujetosRelacionSeleccion',
                                                                        useArrows:true,
                                                                        animate:true,
                                                                        enableDD:false,
                                                                        ddScroll:true,
                                                                        title:'Relacionado con:',
                                                                        containerScroll: true,
                                                                        autoScroll:true,
                                                                        border:true,
                                                                        x:10,
                                                                        y:0,
                                                                        height:150,
                                                                        width:660,
                                                                        root:raiz,
                                                                        loader: cargadorArbol,
                                                                        rootVisible:false
                                                                    }
                                                                )
         
         
                                                    
	return  arbolSujetosRelacionSeleccion;
}

function verHistorialParte()
{
	var idParticipante='';
    var idFiguraJuridica='';
    var idActorRelacionado='';
    
	if(nodoSujetoSel.attributes.tipo=='1')
    {
        idParticipante=nodoSujetoSel.attributes.idPersona;
        idFiguraJuridica=nodoSujetoSel.attributes.personaJuridica;
        idActorRelacionado=-1;
    }
    else
    {
        idParticipante=nodoSujetoSel.parentNode.attributes.idPersona;
        idFiguraJuridica=nodoSujetoSel.parentNode.attributes.personaJuridica;
        idActorRelacionado=nodoSujetoSel.attributes.idPersona;
    }
    
    var cadObj='{"idActividad":"'+gE('idActividad').value+
                  '","idParticipante":"'+idParticipante+'","idFiguraJuridica":"'+idFiguraJuridica+
                  '","idActorRelacionado":"'+idActorRelacionado+'"}';

	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'border',
                                            frame:false,
											defaultType: 'label',
											items: 	[
														crearGridHistorialParte(cadObj)

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Historial',
										width: 900,
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

function crearGridHistorialParte(cadObj)
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idRegistro'},
                                                        {name:'fechaOperacion', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name:'etapaOriginal'},
		                                                {name:'etapaCambio'},
		                                                {name:'responsable'},
                                                        {name: 'detalleSituacionAnterior'},
                                                        {name: 'detalleSituacion'},
                                                        {name: 'comentariosAdicionales'},
                                                        {name: 'iFormulario'},
                                                        {name: 'iReferencia'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../paginasFunciones/funcionesModulosEspeciales_SGP.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'fechaOperacion', direction: 'DESC'},
                                                            groupField: 'fechaOperacion',
                                                            remoteGroup:false,
				                                            remoteSort: true,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='217';
                                        proxy.baseParams.cadObj=cadObj;
                                        
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer(),
                                                            {
                                                                header:'',
                                                                width:30,
                                                                sortable:true,
                                                                align:'center',
                                                                dataIndex:'iFormulario',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	if(val!='-1')
                                                                        		return '<a href="javascript:abrirProcesoOrigen(\''+bE(registro.data.iFormulario)+'\',\''+bE(registro.data.iReferencia)+'\')"><img src="../images/magnifier.png" title="Abrir proceso origen" alt="Abrir proceso origen" /></a>';
                                                                        }
                                                            },
                                                            
                                                            {
                                                                header:'Fecha',
                                                                width:150,
                                                                sortable:true,
                                                                align:'center',
                                                                dataIndex:'fechaOperacion',
                                                                renderer:function(val)
                                                                		{
                                                                        
                                                                        	return formatoTitulo(val.format('d')+' de '+arrMeses[parseInt(val.format('m'))-1][1]+' de '+val.format('Y')+'<br>('+val.format('H:i:s')+' hrs.)');
                                                                        }
                                                            },
                                                            {
                                                                header:'Situaci&oacute;n anterior',
                                                                width:200,
                                                                sortable:true,
                                                                dataIndex:'etapaOriginal',
                                                                renderer:formatoTitulo2PartesSituacionAnterior
                                                            },
                                                            {
                                                                header:'Situaci&oacute;n cambio',
                                                                width:200,
                                                                sortable:true,
                                                                dataIndex:'etapaCambio',
                                                                renderer:formatoTitulo2PartesSituacionActual
                                                            },                                                            
                                                            {
                                                                header:'Responsable',
                                                                width:250,
                                                                sortable:true,
                                                                dataIndex:'responsable',
                                                                renderer:formatoTitulo3
                                                            }
                                                            
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                    {
                                                        id:'gridHistorialParte',
                                                        store:alDatos,
                                                        region:'center',
                                                        frame:false,
                                                        border:true,
                                                        cm: cModelo,
                                                        columnLines : false,
                                                        stripeRows :true,
                                                        loadMask:true,
                                                                                                                        
                                                        view:new Ext.grid.GroupingView({
                                                                                            forceFit:false,
                                                                                            showGroupName: false,
                                                                                            enableGrouping :false,
                                                                                            enableNoGroups:false,
                                                                                            enableGroupingMenu:false,
                                                                                            hideGroupedColumn: false,
                                                                                            startCollapsed:false,
                                                                                            enableRowBody:true,
                                                                                            getRowClass : formatearFilaHistorial
                                                                                        })
                                                    }
                                                );
        return 	tblGrid;	

}

function formatoTitulo2Juez(val)
{
	return '<div style="font-size:11px; color:#040033;; height:45px; word-wrap: break-word;white-space: normal; ">'+val+'</div>';
}


function formatoTitulo2PartesSituacionAnterior(val,meta,registro)
{
	var leyenda=formatearValorRenderer(arrSituacionImputadoCompleto,val);
    if(registro.data.detalleSituacionAnterior!='')
    {
        leyenda+=': '+formatearValorRenderer(arrDetalleSituacionImputado,registro.data.detalleSituacionAnterior);
    }
    
	return '<div style="font-size:11px; color:#040033; height:45px; word-wrap: break-word;white-space: normal; ">'+mostrarValorDescripcion(leyenda,val)+'</div>';
}

function formatoTitulo2PartesSituacionActual(val,meta,registro)
{
	var leyenda=formatearValorRenderer(arrSituacionImputadoCompleto,val);
    if(registro.data.detalleSituacion!='')
    {
        leyenda+=': '+formatearValorRenderer(arrDetalleSituacionImputado,registro.data.detalleSituacion);
    }
    
	return '<div style="font-size:11px; color:#040033; height:45px; word-wrap: break-word;white-space: normal; ">'+mostrarValorDescripcion(leyenda,val)+'</div>';
}

function mostrarVentanaOrdenNotificacion(fila)
{
	carpetaAdministrativa=gE('carpetaAdministrativa').value;
   	idCarpeta=gE('idCarpetaAdministrativa').value;
	if(fila)
    	idOrden=fila.data.idOrden;
    else
        idOrden=-1;
	
	

	var cmbTipoNotificacion=crearComboExt('cmbTipoNotificacion',arrTipoSolicitud,180,35,200);
    
    var cmbAudienciaDeriva=crearComboExt('cmbAudienciaDeriva',[],180,65,480);
    cmbAudienciaDeriva.on('select',function(cmb,registro)
   									{
   										gEx('dteFechaDterminacion').setValue(registro.data.valorComp);
   									}
    					)
    cmbAudienciaDeriva.hide();
    
    cmbTipoNotificacion.on('select',function(cmb,registro)
    								{
                                    	
                                    	switch(registro.data.id)
                                        {
                                            case '1':
                                                gEx('lblNombreDeterminacion').show();
                                                gEx('txtNombreDeterminacion').show();
                                                gEx('lblFechaDeterminacion').setText('Fecha de la determinaci&oacute;n:',false);
                                                gEx('lblFechaDeterminacion').show();
                                                gEx('dteFechaDterminacion').show();
                                                gEx('dteFechaDterminacion').setValue('<?php echo date("Y-m-d")?>');
                                                gEx('dteFechaDterminacion').enable();
                                                gEx('lblAudienciaDeriva').hide();
                                                gEx('cmbAudienciaDeriva').setValue('');
                                                gEx('cmbAudienciaDeriva').hide();
                                                gEx('txtNombreDeterminacion').focus(false,500);
                                                
                                            break;
                                            case '2':

                                                gEx('lblNombreDeterminacion').hide();
                                                gEx('txtNombreDeterminacion').hide();
                                                gEx('txtNombreDeterminacion').setValue('');
                                                gEx('lblFechaDeterminacion').show();
                                                gEx('dteFechaDterminacion').setValue('');
                                                gEx('dteFechaDterminacion').disable();
                                                gEx('lblFechaDeterminacion').setText('Fecha del auto:');
                                                gEx('dteFechaDterminacion').show();                                        
                                                gEx('lblAudienciaDeriva').show();
                                                gEx('cmbAudienciaDeriva').show();
                                                gEx('cmbAudienciaDeriva').focus(false,500);
                                            break;
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
                                                            html:'Carpeta Judicial:'
                                                        },
                                                        {
                                                        	x:180,
                                                            y:10,
                                                            html:'<span style="color:#900; font-weight:bold">'+carpetaAdministrativa+'</span>'
                                                        },
                                                        {
                                                        	x:455,
                                                            y:5,
                                                            width:100,
                                                            hight:35,
                                                            xtype:'button',
                                                            icon:'../images/guardar.JPG',
                                                            cls:'x-btn-text-icon',
                                                            text:'Guardar orden',
                                                            handler:function()
                                                                    {
                                                                        
                                                                        if(gEx('cmbTipoNotificacion').getValue()=='')
                                                                        {
                                                                        	function resp2()
                                                                            {
                                                                            	gEx('cmbTipoNotificacion').focus();
                                                                            }
                                                                        	msgBox('Debe indicar el tipo de notificaci&oacute;n de la cual deriva la orden de notificaci&oacute;n',resp2);
                                                                        	return;
                                                                        }
                                                                        
                                                                        switch(gEx('cmbTipoNotificacion').getValue())
                                                                        {
                                                                        	case '1':
                                                                            	if(gEx('txtNombreDeterminacion').getValue()=='')
                                                                                {
                                                                                	function resp3()
                                                                                    {
                                                                                        gEx('txtNombreDeterminacion').focus();
                                                                                    }
                                                                                    msgBox('Debe indicar el nombre de la determinaci&oacute;n de la cual deriva la orden de notificaci&oacute;n',resp3);
                                                                                    return;
                                                                                }
                                                                                
                                                                                if(gEx('dteFechaDterminacion').getValue()=='')
                                                                                {
                                                                                	function resp4()
                                                                                    {
                                                                                        gEx('dteFechaDterminacion').focus();
                                                                                    }
                                                                                    msgBox('Debe indicar la fecha de la determinaci&oacute;n de la cual deriva la orden de notificaci&oacute;n',resp4);
                                                                                    return;
                                                                                }
                                                                            break;
                                                                            case '2':
                                                                            	if(gEx('cmbAudienciaDeriva').getValue()=='')
                                                                                {
                                                                                	function resp5()
                                                                                    {
                                                                                        gEx('cmbAudienciaDeriva').focus();
                                                                                    }
                                                                                    msgBox('Debe indicar la audiencia de la cual deriva la orden de notificaci&oacute;n',resp5);
                                                                                    return;
                                                                                }
                                                                                
                                                                                if(gEx('dteFechaDterminacion').getValue()=='')
                                                                                {
                                                                                	function resp6()
                                                                                    {
                                                                                        gEx('dteFechaDterminacion').focus();
                                                                                    }
                                                                                    msgBox('Debe indicar la fecha del auto de la cual deriva la orden de notificaci&oacute;n',resp6);
                                                                                    return;
                                                                                }
                                                                            break;
                                                                        }
                                                                        
                                                                        var cadObj='{"idOrden":"'+idOrden+'","carpetaJudicial":"'+carpetaAdministrativa+'","idCarpeta":"'+idCarpeta+'","tipoNotificacion":"'+
                                                                        			gEx('cmbTipoNotificacion').getValue()+'","nombreDeterminacion":"'+cv(gEx('txtNombreDeterminacion').getValue())+
                                                                                    '","fechaDeterminacion":"'+gEx('dteFechaDterminacion').getValue().format('Y-m-d')+'","idEventoAudiencia":"'+
                                                                                    gEx('cmbAudienciaDeriva').getValue()+'","comentariosAdicionales":"'+cv(gEx('txtComentariosAdicionales').getValue())+
                                                                                    '","idFormulario":"-1","idRegistro":"-1"}';
                                                                    
                                                                    	
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	if(idOrden==-1)
                                                                                {
                                                                                	gEx('vOrden').setTitle('Modificar orden de notificaci&oacute;n: , Folio: <b><span style="color:#900">'+arrResp[2]+'</span></b>');
                                                                                }
                                                                                idOrden=parseInt(arrResp[1]);
                                                                                gEx('gOrdenesNotificacion').getStore().reload();
                                                                                gEx('fArchivos').enable();
                                                                                gEx('btnIngresarActa').show();
                                                                                
                                                                                
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[1]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_Notificaciones.php',funcAjax, 'POST','funcion=4&cadObj='+cadObj,true);
                                                                        
                                                                    }
                                                            
                                                        },
                                                        {
                                                        	x:560,
                                                            y:5,
                                                            id:'btnIngresarActa',
                                                            width:100,
                                                            hight:35,
                                                            hidden:!fila,
                                                            xtype:'button',
                                                            icon:'../images/pencil_go.png',
                                                            cls:'x-btn-text-icon',
                                                            text:'Editar acta circunstaciada',
                                                            handler:function()
                                                                    {
                                                                        if(gEx('vistaDocuentosAdjuntos').getStore().getCount()==0)
                                                                        {
                                                                        	msgBox('Debe agregar almenos un documento de notificaci&oacute;n');
                                                                        	return;
                                                                        }
                                                                        
                                                                        gEx('vOrden').close();
                                                                        
                                                                        var obj={};
                                                                        obj.ancho='100%';
                                                                        obj.alto='100%';
                                                                        obj.url='../modulosEspeciales_SGJP/tblOrdenNotificacionAtencion.php';
                                                                        obj.params=[['idOrden',idOrden],['vTAudiencia','1']];
                                                                        abrirVentanaFancy(obj);
                                                                       	
                                                                    }
                                                            
                                                        },
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            html:'Tipo notificaci&oacute;n:'
                                                        },
                                                        cmbTipoNotificacion,
                                                        {
                                                        	x:10,
                                                            y:70,
                                                            hidden:true,
                                                            id:'lblNombreDeterminacion',
                                                            html:'Nombre de la determinaci&oacute;n:'
                                                        },
                                                        {
                                                            id:'txtNombreDeterminacion',
                                                            xtype:'textfield',
                                                            width:480,
                                                            hidden:true,
                                                            x:180,
                                                            y:65
                                                        },
                                                        {
                                                            x:10,
                                                            y:100,
                                                            id:'lblFechaDeterminacion',
                                                            hidden:true,
                                                            xtype:'label',
                                                            html:'Fecha de la determinaci&oacute;n:'
                                                        },
                                                        {
                                                            x:10,
                                                            y:70,
                                                            hidden:true,
                                                            xtype:'label',
                                                            id:'lblAudienciaDeriva',
                                                            html:'Audiencia de la cual deriva:'
                                                        },
                                                        cmbAudienciaDeriva,
                                                        {
                                                            xtype:'datefield',
                                                            x:180,
                                                            y:95,
                                                            id:'dteFechaDterminacion',
                                                            hidden:true,
                                                            value:'<?php echo date("Y-m-d")?>'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:130,
                                                            html:'Comentarios adicionales:'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:150,
                                                            xtype:'textarea',
                                                            id:'txtComentariosAdicionales',
                                                           	width:820,
                                                            hight:25
                                                        },
                                                        {
                                                        	xtype:'fieldset',
                                                            id:'fArchivos',
                                                            x:10,
                                                            y:225,
                                                            width:820,
                                                            height:165,
                                                            layout:'border',
                                                            disabled:true,
                                                            title:'Documentos a notificar',
                                                            items:	[
                                                            			{
                                                                        	xtype:'panel',
                                                                            layout:'border',
                                                                            
                                                                            region:'center',
                                                                            tbar:	[
                                                                                        {
                                                                                            icon:'../images/add.png',
                                                                                            cls:'x-btn-text-icon',
                                                                                            text:'Agregar documento',
                                                                                            handler:function()
                                                                                                    {
                                                                                                     	mostrarVentanaDocumentos();   
                                                                                                    }
                                                                                            
                                                                                        },'-',
                                                                                        {
                                                                                            icon:'../images/delete.png',
                                                                                            cls:'x-btn-text-icon',
                                                                                            text:'Remover documento',
                                                                                            handler:function()
                                                                                                    {
                                                                                                        if(!registroDocumentoSel)
                                                                                                        {
                                                                                                        	msgBox('Debe seleccionar el documento que desea remover');
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
                                                                                                                        gEx('vistaDocuentosAdjuntos').getStore().reload();
                                                                                                                    }
                                                                                                                    else
                                                                                                                    {
                                                                                                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                                    }
                                                                                                                }
                                                                                                                obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_Notificaciones.php',funcAjax, 'POST','funcion=7&iO='+idOrden+'&iD='+registroDocumentoSel.data.idDocumento,true);
                                                                                                            }
                                                                                                        }
                                                                                                        msgConfirm('Est&aacute; seguro de querer remover el documento seleccionado?',resp);
                                                                                                        
                                                                                                    }
                                                                                            
                                                                                        }
                                                                                        
                                                                                    ],
                                                                            items:	[
                                                                            
                                                                            			crearVistaDocumentosAdjuntos()
                                                                            		]
                                                                        }
                                                                        
                                                                        
                                                            		]
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: (fila?'Modificar orden de notificaci&oacute;n':'Nueva orden de notificaci&oacute;n')+', Folio: <b><span style="color:#900">'+(fila?fila.data.folioOrden:'Por asignar')+'</span></b>' ,
										width: 880,
										height:470,
										layout: 'fit',
										plain:true,
										modal:true,
                                        id:'vOrden',
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
                                                            hidden:true,
															handler: function()
																	{
																		
																	}
														},
														{
															text: 'Cerrar',
															handler:function()
																	{
																		ventanaAM.close();
																	}
														}
													]
									}
								);
	ventanaAM.show();
    
    if(fila)
    {
    	carpetaAdministrativa=fila.data.carpetaJudicial;
		idCarpeta=fila.data.idCarpeta;
        
        function funcAjax()
        {
            var resp=peticion_http.responseText;
            arrResp=resp.split('|');
            if(arrResp[0]=='1')
            {
            	
                arrAudiencias=eval(arrResp[1]);
                gEx('cmbAudienciaDeriva').getStore().loadData(arrAudiencias);
                
                gEx('cmbTipoNotificacion').setValue(fila.data.tipoNotificacion);
                dispararEventoSelectCombo('cmbTipoNotificacion');
                gEx('dteFechaDterminacion').setValue(fila.data.fechaDeterminacion);
                gEx('txtNombreDeterminacion').setValue(fila.data.nombreDeterminacion);
                gEx('cmbAudienciaDeriva').setValue(fila.data.idEventoDeriva);
                gEx('txtComentariosAdicionales').setValue(escaparBR(fila.data.comentariosAdicionales));
                gEx('fArchivos').enable();
                
            }
            else
            {
                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
            }
        }
        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_Notificaciones.php',funcAjax, 'POST','funcion=2&iC='+idCarpeta+'&cA='+carpetaAdministrativa,true);
        
    	
        
    }
    else
    {
    	function funcAjax()
        {
            var resp=peticion_http.responseText;
            arrResp=resp.split('|');
            if(arrResp[0]=='1')
            {
            	
                arrAudiencias=eval(arrResp[1]);
                gEx('cmbAudienciaDeriva').getStore().loadData(arrAudiencias);
            }
            else
            {
                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
            }
        }
        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_Notificaciones.php',funcAjax, 'POST','funcion=2&iC='+idCarpeta+'&cA='+carpetaAdministrativa,true);
    }
    	
}


function crearVistaDocumentosAdjuntos()
{

	/*var plantilla=new Ext.XTemplate(
                                        '<tpl for=".">',
                                            '<div class="thumb-wrap" id="{nombreDocumento}">',
                                            '<div class="thumb" style="text-align:center"><img src="../imagenesDocumentos/32/file_extension_{extension}.png" title="{nombreDocumento}" alt="{nombreDocumento}"></div>',
                                            '<div style="width: 110px; text-align:center;" title="{nombreDocumento}" alt="{nombreDocumento}">{nombreDocumentoCorto}</div><span>{fechaDocumento}</span><span>{tamanoDocumento}</span></div>',
                                        '</tpl>'
                                    );*/
	
   	var plantilla=new Ext.XTemplate(
                                        '<ul>',
                                            '<tpl for=".">',
                                                '<li class="elemento" title="{nombreDocumento}" alt="{nombreDocumento}">',
                                                    '<img src="../imagenesDocumentos/32/file_extension_{extension}.png"><br>',
                                                    '<span>{nombreDocumentoCorto}</span><br>',
                                                    '<span>{tamanoDocumento}</span>',
                                                '</li>',
                                            '</tpl>',
                                        '</ul>'
                                    );    
   
                                                                                      
	var alDatos=new Ext.data.JsonStore({
                                            root:'registros',
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name: 'idDocumento'},
		                                                {name: 'nombreDocumento'},
                                                        {name: 'nombreDocumentoCorto'},
		                                                {name: 'tamanoDocumento'},
		                                                {name: 'fechaDocumento'},
                                                        {name: 'extension'}
                                                        
                                            		],
                                            proxy : new Ext.data.HttpProxy	(
                                                                                  {
                                                                                      url: '../paginasFunciones/funcionesModulosEspeciales_Notificaciones.php'
                                                                                  }

                                                                              ),
                                            autoLoad:true
                                        })   
       
     
	    
     
    alDatos.on('beforeload',function(proxy)
    								{
                                    	registroDocumentoSel=null;
                                    	proxy.baseParams.funcion='3';
                                        proxy.baseParams.iO=idOrden;
                                        
                                    }
                        )   
       
    var vista=new Ext.DataView(
                                    {
                                        tpl: plantilla,                                        
                                        id:'vistaDocuentosAdjuntos',
                                       	width:800,
                                        height:155,
                                        autoScroll  : true,
                                        singleSelect: true,
                                        region:'center',
                                        border:true,
                                        overClass:'x-view-over',
                                        itemSelector: 'li.elemento',
                                        emptyText : '<div style="padding:10px;">No existen documentos registrados</div>',
                                        store:alDatos
                                    }
                                 )    
                                 
	vista.on('dblclick',function(dv,idx,nodo,e)
                      {
                          registroDocumentoSel=gEx('vistaDocuentosAdjuntos').getRecord(nodo);
                          mostrarVisorDocumentoProceso(registroDocumentoSel.data.extension,registroDocumentoSel.data.idDocumento,registroDocumentoSel);
                      }
              )                                  
                                                                        
     vista.on('click',function(dv,idx,nodo,e)
                      {
                          registroDocumentoSel=gEx('vistaDocuentosAdjuntos').getRecord(nodo);
                          
                      }
              )
                                             
	return   vista;                                 
                                    
}

function recargarOrdenesNotificacion()
{
	gEx('gOrdenesNotificacion').getStore().reload();
}

function mostrarVentanaDocumentos()
{
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'border',
											defaultType: 'label',
											items: 	[
                                            			crearGridDocumentos()
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar documentos',
										width: 950,
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
                                                            
															handler: function()
																	{
                                                                    	var listaDocumentos='';
																		var filas=gEx('gridDocumentos').getSelectionModel().getSelections();
                                                                        var x;
                                                                        var f;
                                                                        for(x=0;x<filas.length;x++)
                                                                        {
                                                                        	f=filas[x];
                                                                            if(listaDocumentos=='')
                                                                            	listaDocumentos=f.data.idDocumento;
                                                                            else
                                                                            	listaDocumentos+=','+f.data.idDocumento;
                                                                        }
                                                                        
                                                                        if(listaDocumentos=='')
                                                                        {
                                                                        	msgBox('Debe seleccionar almenos un documento a adjuntar a la orden de notificaci&oacute;n');
                                                                        	return;
                                                                        }
                                                                        
                                                                        var cadObj='{"idOrden":"'+idOrden+'","listaDocumentos":"'+listaDocumentos+'"}';
                                                                        
                                                                        
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                            	gEx('vistaDocuentosAdjuntos').getStore().reload();
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_Notificaciones.php',funcAjax, 'POST','funcion=6&cadObj='+cadObj,true);
                                                                        
                                                                        
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
    dispararEventoSelectCombo('cmbOridenDocumentos');
}

function crearGridDocumentos()
{
	var cmbOridenDocumentos=crearComboExt('cmbOridenDocumentos',[['1','Carpeta Judicial']],0,0,250);
    cmbOridenDocumentos.setValue('1');
    cmbOridenDocumentos.on('select',function(cmb,registro)
    								{
                                    	switch(parseInt(registro.data.id))
                                        {
                                        	case 1:
                                            	gEx('gridDocumentos').getStore().load	(
                                                                                            {
                                                                                                url:'funcionesModulosEspeciales_SGP',
                                                                                                params:	{
                                                                                                            funcion:19,
                                                                                                            cA:bE(carpetaAdministrativa),
                                                                                                            idCarpetaAdministrativa:idCarpeta
                                                                                                        }
                                                                                            }
                                                                                        )
                                            	
                                            break;
                                        }
                                    }
    					)
    
    
	var cmbTipoDocumento=crearComboExt('cmbTipoDocumento',arrCategorias);
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idDocumento'},
		                                                {name: 'etapaProcesal'},
		                                                {name:'nomArchivoOriginal'},
		                                                {name: 'tamano'},
                                                        {name: 'fechaRegistro', type:'date', dateFormat:'Y-m-d'},
                                                        {name: 'fechaCreacion', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name: 'descripcion'},
                                                        {name:'idFormulario'},
                                                        {name:'idRegistro'},
                                                        {name:'idDocumento'},
                                                        {name: 'categoriaDocumentos'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                reader: lector,
                                                proxy : new Ext.data.HttpProxy	(

                                                                                  {

                                                                                      url: '../paginasFunciones/funcionesModulosEspeciales_SGP.php'

                                                                                  }

                                                                              ),
                                                sortInfo: {field: 'fechaRegistro', direction: 'ASC'},
                                                groupField: 'fechaRegistro',
                                                remoteGroup:false,
                                                remoteSort: false,
                                                autoLoad:false
                                                
                                            }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='19';
                                        proxy.baseParams.cA=bE(carpetaAdministrativa);
                                        proxy.baseParams.idCarpetaAdministrativa=idCarpeta;
                                    }
                        )   
       
    
    
    var filters = new Ext.ux.grid.GridFilters	(
    												{
                                                    	filters:	[ 
                                                        				{type: 'date', dataIndex: 'fechaCreacion'},
                                                                        {type: 'string', dataIndex: 'nomArchivoOriginal'},
                                                                        {type: 'list', dataIndex: 'categoriaDocumentos', phpMode:true, options:arrCategorias}
                                                                    ]
                                                    }
                                                );    
       
	/*var expander = new Ext.ux.grid.RowExpander({
                                                column:1,
                                                expandOnDblClick:false,
                                                tpl : new Ext.Template(
                                                    '<table >'+
                                                    '<tr><td ><span class="TSJDF_Control">{descripcion}</span><br /><br /></td></tr>'+
                                                    '</table>'
                                                )
                                            });    */    

	var chkRow=new Ext.grid.CheckboxSelectionModel();
       
    var cModelo= new Ext.grid.ColumnModel   	(
                                                    [
                                                    	new  Ext.grid.RowNumberer({width:30}),
                                                        chkRow,
                                                        {
                                                            header:'',
                                                            width:30,
                                                            sortable:true,
                                                            dataIndex:'idDocumento',
                                                            renderer:function(val,meta,registro)
                                                            		{
                                                                    	var arrNombre=registro.data.nomArchivoOriginal.split('.');
                                                                        return '<img src="../imagenesDocumentos/16/file_extension_'+arrNombre[1].toLowerCase()+'.png" />'
                                                                    }
                                                        },
                                                        {
                                                            header:'Fecha de registro',
                                                            width:120,
                                                            sortable:true,
                                                            dataIndex:'fechaRegistro',
                                                            renderer:function(val)
                                                            		{
                                                                    	if(val)
                                                                    		return val.format('d/m/Y');
                                                                    }
                                                        },
                                                        {
                                                            header:'Tipo documento',
                                                            width:150,
                                                            sortable:true,
                                                            dataIndex:'categoriaDocumentos',
                                                            editor:cmbTipoDocumento,
                                                            renderer:function(val)
                                                            		{
                                                                    	return formatearValorRenderer(arrCategorias,val);
                                                                    }
                                                        },
                                                        {
                                                            header:'Etapa procesal',
                                                            width:250,
                                                            hidden:true,
                                                            sortable:true,
                                                            dataIndex:'etapaProcesal',
                                                            renderer:function(val)
                                                            		{
                                                                    	return formatearValorRenderer(arrEtapasProcesales,val);
                                                                    }
                                                        },
                                                        {
                                                            header:'Documento',
                                                            width:420,
                                                            sortable:true,
                                                            dataIndex:'nomArchivoOriginal',
                                                            renderer:mostrarValorDescripcion
                                                        },
                                                        
                                                        {
                                                            header:'Tama&ntilde;o',
                                                            width:100,
                                                            sortable:true,
                                                            dataIndex:'tamano',
                                                            renderer:function(val)
                                                            		{
                                                                    	return bytesToSize(parseInt(val),0);
                                                                    }
                                                        }
                                                        
                                                    ]
                                                );
                                                
    var tblGrid=	new Ext.grid.GridPanel	(
                                                        {
                                                            id:'gridDocumentos',
                                                            store:alDatos,
                                                            region:'center',
                                                            frame:false,
                                                            cm: cModelo,
                                                            sm:chkRow,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            tbar:	[
                                                            			{
                                                                        	xtype:'label',
                                                                            html:'<b>Origen de los documentos:&nbsp;&nbsp;</b>'
                                                                        },
                                                                        cmbOridenDocumentos,'-',
                                                                        {
                                                                            icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Adjuntar documento',
                                                                            handler:function()
                                                                                    {
                                                                                        mostrarVentanaAdjuntarDocumento()
                                                                                    }
                                                                            
                                                                        }
                                                            		],
                                                            columnLines : true,  
                                                            plugins:[filters],   
                                                            view:new Ext.grid.GroupingView({
                                                                                                forceFit:false,
                                                                                                showGroupName: false,
                                                                                                enableGrouping :false,
                                                                                                enableNoGroups:false,
                                                                                                enableGroupingMenu:false,
                                                                                                hideGroupedColumn: false,
                                                                                                startCollapsed:false,
                                                                                                groupTextTpl:'<span style="color:#900"><b>{text}</b> ({[values.rs.length]} {[values.rs.length > 1 ? "Documentos" : "Documento"]})</span>'
                                                                                            })
                                                        }
                                                    );
                                                    
	
    
    
    tblGrid.on('rowdblclick',function(grid,rowIndex)
                              {
                              		var registro=grid.getStore().getAt(rowIndex);
                                    var arrNombre=registro.data.nomArchivoOriginal.split('.');
                                  	mostrarVisorDocumentoProceso(arrNombre[1].toLowerCase(),registro.data.idDocumento,registro);
                                  
                              }
                  )                                                    
                                                    
    return 	tblGrid;	
}

function mostrarActaCircunstanciada(iD)
{
	mostrarVisorDocumentoProceso('pdf',bD(iD));
}

function mostrarVentanaHistorialAudiencia(iE)
{
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'border',
											defaultType: 'label',
											items: 	[
                                            			crearGridHistorialAudienciaJuez(bD(iE))
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Historial de cambios de jueces',
										width: 950,
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
                                                            
															handler: function()
																	{
																		
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

function crearGridHistorialAudienciaJuez(idEvento)
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idRegistro'},
                                                        {name:'fechaOperacion', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name:'juezOriginal'},
		                                                {name:'juezCambio'},
		                                                {name:'responsable'},
                                                        {name: 'comentariosAdicionales'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../paginasFunciones/funcionesModulosEspeciales_SGP.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'fechaOperacion', direction: 'DESC'},
                                                            groupField: 'fechaOperacion',
                                                            remoteGroup:false,
				                                            remoteSort: true,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='224';
                                        proxy.baseParams.idEvento=idEvento;
                                        
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer(),
                                                            {
                                                                header:'Fecha',
                                                                width:150,
                                                                sortable:true,
                                                                align:'center',
                                                                dataIndex:'fechaOperacion',
                                                                renderer:function(val)
                                                                		{
                                                                        
                                                                        	return formatoTitulo(val.format('d')+' de '+arrMeses[parseInt(val.format('m'))-1][1]+' de '+val.format('Y')+'<br>('+val.format('H:i:s')+' hrs.)');
                                                                        }
                                                            },
                                                            {
                                                                header:'Juez original',
                                                                width:200,
                                                                sortable:true,
                                                                dataIndex:'juezOriginal',
                                                                renderer:formatoTitulo2Juez
                                                            },
                                                            {
                                                                header:'Juez cambio',
                                                                width:200,
                                                                sortable:true,
                                                                dataIndex:'juezCambio',
                                                                renderer:formatoTitulo2Juez
                                                            },                                                            
                                                            {
                                                                header:'Responsable',
                                                                width:250,
                                                                sortable:true,
                                                                dataIndex:'responsable',
                                                                renderer:formatoTitulo3
                                                            }
                                                            
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                    {
                                                        id:'gridHistorialJuezAudiencia',
                                                        store:alDatos,
                                                        region:'center',
                                                        frame:false,
                                                        border:true,
                                                        cm: cModelo,
                                                        columnLines : false,
                                                        stripeRows :true,
                                                        loadMask:true,                                                                                                                        
                                                        view:new Ext.grid.GroupingView({
                                                                                            forceFit:false,
                                                                                            showGroupName: false,
                                                                                            enableGrouping :false,
                                                                                            enableNoGroups:false,
                                                                                            enableGroupingMenu:false,
                                                                                            hideGroupedColumn: false,
                                                                                            startCollapsed:false,
                                                                                            enableRowBody:true,
                                                                                            getRowClass : formatearFilaHistorial
                                                                                        })
                                                    }
                                                );
        return 	tblGrid;	

}

function mostrarVisorDocumentoProcesoIndice(extension,idDocumento,registro,nombreArchivo)
{
	var obj={};
    obj.url='../visoresGaleriaDocumentos/visorDocumentosGeneralIndice.php';
    obj.ancho='100%';
    obj.alto='100%';
    
    var arrCarpeta=nodoCarpetaSel.id.split('_');
     
    obj.params=	[['iD',bE('iD_'+idDocumento)],['cPagina','sFrm=true'],['idCarpeta',<?php echo  $registrarIDCarpeta?"arrCarpeta[1]":"-1"?>],
    			['carpetaJudicial',bE(arrCarpeta[0])]];
    if(extension!='')
    	obj.params.push(['extension',extension]);
    if(nombreArchivo)
    	obj.params.push(['nombreArchivo',nombreArchivo]);
    abrirVentanaFancy(obj);
	
}


function crearGridGeneracionDocumentosSicore()
{
	 var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idRegistro'},
		                                                {name: 'idFormulario'},
		                                                {name:'folioRegistro'},
                                                        {name: 'tipoDocumento'},
                                                        {name: 'comentariosAdicionales'},
		                                                {name:'fechaCreacion', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name: 'idEstado'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                reader: lector,
                                                proxy : new Ext.data.HttpProxy	(

                                                                                  {

                                                                                      url: '../paginasFunciones/funcionesModulosEspeciales_SICORE.php'

                                                                                  }

                                                                              ),
                                                sortInfo: {field: 'fechaCreacion', direction: 'ASC'},
                                                groupField: 'fechaCreacion',
                                                remoteGroup:false,
                                                remoteSort: false,
                                                autoLoad:true
                                                
                                            }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='202';
                                        proxy.baseParams.idExpediente=gE('idCarpetaAdministrativa').value;
                                    }
                        )   
       
    var cModelo= new Ext.grid.ColumnModel   	(
                                                    [
                                                        new  Ext.grid.RowNumberer(),
                                                        {
                                                            header:'Folio',
                                                            width:110,
                                                            sortable:true,
                                                            dataIndex:'folioRegistro'
                                                        },
                                                        {
                                                            header:'Fecha de registro',
                                                            width:150,
                                                            sortable:true,
                                                            dataIndex:'fechaCreacion',
                                                            renderer:function(val)
                                                            		{
                                                                    	return val.format('d/m/Y H:i');
                                                                    }
                                                        },
                                                        {
                                                            header:'Tipo de documento',
                                                            width:200,
                                                            sortable:true,
                                                            dataIndex:'tipoDocumento',
                                                            renderer:function(val)
                                                            		{
                                                                    	return formatearValorRenderer(arrTiposDocumento,val);
                                                                    }
                                                        },
                                                        {
                                                            header:'Comentarios adicionales',
                                                            width:350,
                                                            sortable:true,
                                                            dataIndex:'comentariosAdicionales',
                                                            renderer:function(val)
                                                            		{
                                                                    	return mostrarValorDescripcion(val);
                                                                    }
                                                        },
                                                        {
                                                            header:'Situaci&oacute;n actual',
                                                            width:350,
                                                            sortable:true,
                                                            dataIndex:'idEstado',
                                                            renderer:function(val)
                                                            		{
                                                                    	return formatearValorRenderer(arrEtapasGeneracionDocumentos,val);
                                                                    }
                                                        }
                                                    ]
                                                );
                                                
    var tblGrid=	new Ext.grid.GridPanel	(
                                                {
                                                    id:'gDocumentosGenerados',
                                                    store:alDatos,
                                                    region:'center',
                                                    frame:false,
                                                    cm: cModelo,
                                                    title:'Generar documento',
                                                    stripeRows :true,
                                                    loadMask:true,
                                                    columnLines : true, 
                                                    tbar:	[
                                                                {
                                                                    icon:'../images/add.png',
                                                                    cls:'x-btn-text-icon',
                                                                    text:'Crear nuevo documento',
                                                                    handler:function()
                                                                            {
                                                                                abrirProcesoGeneracionDocumentos(bE(552),bE(-1));

                                                                            }
                                                                    
                                                                },'-',
                                                                {
                                                                    icon:'../images/pencil.png',
                                                                    cls:'x-btn-text-icon',
                                                                    text:'Editar documento',
                                                                    handler:function()
                                                                            {
                                                                            	var fila=gEx('gDocumentosGenerados').getSelectionModel().getSelected();
                                                                                
                                                                                if(!fila)
                                                                                {
                                                                                
                                                                                	msgBox('Debe selecciobar el documento que desea editar');
                                                                                	return;
                                                                                }
                                                                                
                                                                                abrirProcesoGeneracionDocumentos(bE(552),bE(fila.data.idRegistro));
                                                                            }
                                                                    
                                                                },'-',
                                                                {
                                                                    icon:'../images/delete.png',
                                                                    cls:'x-btn-text-icon',
                                                                    text:'Remover documento',
                                                                    handler:function()
                                                                            {
                                                                                
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


function abrirProcesoGeneracionDocumentos(iF,iR)
{
	var nFila=obtenerPosFila(gEx('gDocumentosGenerados').getStore(),'idRegistro',bD(iR));
	var fila=gEx('gDocumentosGenerados').getStore().getAt(nFila);
	var obj={};
    var params=[];
	if(bD(iR)=='-1')
    {
    	var actor='501';
        <?php
		
		if(existeRol("'163_0'"))
		{
			echo "actor='502';";
		}
		
		if(existeRol("'164_0'"))
		{
			echo "actor='503';";
		}
		?>
        params=[['idRegistro',-1],['idFormulario',bD(iF)],['dComp',bE('agregar')],['actor',bE(actor)],['iExpediente',gE('idCarpetaAdministrativa').value]];
        obj.ancho='100%';
        obj.alto='100%';
        obj.url='../modeloPerfiles/vistaDTDv3.php';
        obj.params=params;
        obj.modal=true;
        abrirVentanaFancy(obj);  
    }
    else
    {
    	var rol='158_0';
        <?php
    	if(existeRol("'163_0'"))
		{
			echo "rol='163_0';";
		}
		
		if(existeRol("'164_0'"))
		{
			echo "rol='164_0';";
		}
    ?>
    	var cadObj='{"idFormulario":"552","idRol":"'+rol+'","idEtapa":"'+fila.data.idEstado+'"}';
    	function funcAjax()
        {
            var resp=peticion_http.responseText;
            arrResp=resp.split('|');
            if(arrResp[0]=='1')
            {
                params=[['idRegistro',bD(iR)],['idFormulario',bD(iF)],['dComp',bE('auto')],['actor',bE(arrResp[1])]]; 
                obj.ancho='100%';
                obj.alto='100%';
                obj.url='../modeloPerfiles/vistaDTDv3.php';
                obj.params=params;
                obj.modal=true;
                abrirVentanaFancy(obj);  
            }
            else
            {
                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
            }
        }
        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=35&cadObj='+cadObj,true);
              
        
    }
     
}

function obtenerVersionCompletaDocumentos(iDocumento)
{
	
	
    var arrParametros=[['iDocumento',iDocumento]]
    enviarFormularioDatos('../modulosEspeciales_SICORE/obtenerDocumentoCompletoImpresion.php',arrParametros,'POST','frameDTD');
    primeraCargaFrame=false;
    
}

function frameLoad(iFrame)
{
	if(!primeraCargaFrame)
    {
    	setTimeout(function()
        			{
                       
                        iFrame.contentWindow.print();
                    },2000
                   );

    }
    else
    	primeraCargaFrame=false;
	
}


function registrarNuevaSolicitudAudienciaPenalTradicional()
{
   	
 
 	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            var obj={};    
            obj.ancho='100%';
            obj.alto='100%';
            obj.url='../modulosEspeciales_SGJP/tblAgendaEventosPenalTradicional.php';
            obj.params=[['idFormulario',185],['idRegistro',arrResp[1]],['idReferencia',-1],
            		['dComp',arrResp[2]],['actor',arrResp[3]],['idCarpetaAdministrativa',gE('idCarpetaAdministrativa').value]];
            abrirVentanaFancy(obj);
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=310&cA=<?php echo $carpetaAdministrativa?>&iE=-1&idCarpeta='+gE('idCarpetaAdministrativa').value,true);
 
 
}


function reenviarNotificacionMail(iE)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            gEx('gridAudiencias').getStore().reload();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=311&iE='+bD(iE),true);
}

function identificacionUpload(iP)
{
	var uploadControl;
    
	var cmbTipoIdentificacion=crearComboExt('cmbTipoIdentificacion',arrTipoIdentificacion,180,5,200);
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            html:'Tipo de identificaci&oacute;n:'
                                                        },
                                                        cmbTipoIdentificacion,
                                                        
														{
                                                        	x:0,
                                                            y:40,
                                                            html:	'<span id="tblUpload">'+
                                                            		'<table width="720"><tr><td><div id="uploader"><p>Your browser doesn\'t have Flash, Silverlight or HTML5 support.</p></div></td></tr></table>'+
                                                                	'</span>'
                                                        }

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Subir identificaci&oacute;n',
										width: 750,
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
                                                                	$("#uploader").pluploadQueue({
                                    
                                                                                                    runtimes : 'html5,flash,silverlight,html4',
                                                                                                    url : "../modulosEspeciales_SGJP/procesarDocumentoAutorizacionAudiencia.php",
                                                                                                    prevent_duplicates:true,
                                                                                                    file_data_name:'archivoEnvio',
                                                                                                    multiple_queues:true,
                                                                                                    multi_selection:false,
                                                                                                    max_retries:10,
                                                                                                    multipart_params:	{
                                                                                                                           
                                                                                                                           tipoValor:1,
                                                                                                                           idParticipante:bD(iP),
                                                                                                                           cA:gE('carpetaAdministrativa').value
                                                                                                                        },
                                                                                                    
                                                                                                    rename : true,
                                                                                                    dragdrop: true,
                                                                                                    init:	{	
                                                                                                    
                                                                                                    			Init:function(up) 
                                                                                                                		{
                                                                                                                        	uploadControl=up;
                                                                                                                		},
                                                                                                    			FilesAdded: function(up, files) {
                                                                                                                                                    $(".plupload_add").hide();
                                                                                                                                                 	up.splice(1,up.files.length-1);   
                                                                                                                                                },
                                                                                                               	FilesRemoved: function(up, files) {
                                                                                                                									if(up.files.length==0)
	                                                                                                                                                    $(".plupload_add").show();
                                                                                                                                                    
                                                                                                                                                },
                                                                                                    			
                                                                                                                UploadComplete:function(up,archivos)
                                                                                                                                {
                                                                                                                                 	
                                                                                                                                },
                                                                                                               	FileUploaded:function(up,archivos,response)
                                                                                                                				{
                                                                                                                                	
                                                                                                                                    if(response.response=='1|')
                                                                                                                                    {
                                                                                                                                    	gEx('gridAutorizacionAudienciaVirtual').getStore().reload();
                                                                                                                                    	ventanaAM.close();
                                                                                                                                    }
                                                                                                                                }
                                                                                                            },
                                                                                                    filters : 	{
                                                                                                                    // Maximum file size
                                                                                                                    max_file_size : '512mb',
                                                                                                                    // Specify what files to browse for
                                                                                                                    mime_types: [
                                                                                                                                    {title : "Archivos de imagen", extensions : "jpg,gif,png"},
                                                                                                                                    {title : "Documentos PDF", extensions : "pdf"}
                                                                                                                                ]
                                                                                                                },
                                                                                             
                                                                                                    // Resize images on clientside if we can
                                                                                                   
                                                                                             
                                                                                                    // Flash settings
                                                                                                    flash_swf_url : '../Scripts/plupload/js/Moxie.swf',
                                                                                                 
                                                                                                    // Silverlight settings
                                                                                                    silverlight_xap_url : '../Scripts/plupload/js/Moxie.xap'
                                                                                                });
																
                                                                	$("#uploader").bind('UploadComplete', function(up, files) 
                                                                                                          {
                                                                                                              // Called when all files are either uploaded or failed
                                                                                                              alert('ok');
                                                                                                         }
                                                                 
                                                                 						)
                                                                                                          
                                                                    $(".plupload_start").hide(); 
                                                                    $("#uploader_filelist").height('50px');  
                                                                    $("#uploader_filelist").css("line-height", '20px !important');
                                                                    setTimeout(function(){ gE('ID_plupload_droptext').style='line-height: 20px'; }, 500);

                                                                    
                                
                                                                }
															}
												},
										buttons:	[
                                        				{
                                                        	x:400,
                                                            y:5,
                                                            xtype:'button',
                                                            width:100,
                                                            icon:'../images/icon_tick.gif',
                                                            cls:'x-btn-text-icon',
                                                            text:'Subir documento',
                                                            handler:function()
                                                                    {
                                                                    	if(gEx('cmbTipoIdentificacion').getValue()=='')
                                                                        {
                                                                        	msgBox('Debe seleccionar el tipo de identificaci&oacute;n a cargar');
                                                                        	return;
                                                                        }
                                                                        if(uploadControl.files.length==0)
                                                                        {
                                                                        	msgBox('Debe seleccionar el documento a cargar');
                                                                        	return false;
                                                                        }
                                                                        uploadControl.settings.multipart_params.tipoIdentificacion=gEx('cmbTipoIdentificacion').getValue();
                                                                        uploadControl.start();
                                                                        
                                                                    }
                                                        },
														{
															
															text: 'Cancelar',
                                                            
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

function autorizacionUpload(iP)
{
	var uploadControl;
    
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			
                                                        
														{
                                                        	x:0,
                                                            y:10,
                                                            html:	'<span id="tblUpload">'+
                                                            		'<table width="720"><tr><td><div id="uploader"><p>Your browser doesn\'t have Flash, Silverlight or HTML5 support.</p></div></td></tr></table>'+
                                                                	'</span>'
                                                        }

													]

										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Subir documento de autorizaci&oacute;n',
										width: 750,
										height:220,
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
                                                                	$("#uploader").pluploadQueue({
                                    
                                                                                                    runtimes : 'html5,flash,silverlight,html4',
                                                                                                    url : "../modulosEspeciales_SGJP/procesarDocumentoAutorizacionAudiencia.php",
                                                                                                    prevent_duplicates:true,
                                                                                                    file_data_name:'archivoEnvio',
                                                                                                    multiple_queues:true,
                                                                                                    multi_selection:false,
                                                                                                    max_retries:10,
                                                                                                    multipart_params:	{
                                                                                                                           
                                                                                                                           tipoValor:2,
                                                                                                                           idParticipante:bD(iP),
                                                                                                                           cA:gE('carpetaAdministrativa').value
                                                                                                                        },
                                                                                                    
                                                                                                    rename : true,
                                                                                                    dragdrop: true,
                                                                                                    init:	{	
                                                                                                    
                                                                                                    			Init:function(up) 
                                                                                                                		{
                                                                                                                        	uploadControl=up;
                                                                                                                		},
                                                                                                    			FilesAdded: function(up, files) {
                                                                                                                                                    $(".plupload_add").hide();
                                                                                                                                                 	up.splice(1,up.files.length-1);   
                                                                                                                                                },
                                                                                                               	FilesRemoved: function(up, files) {
                                                                                                                									if(up.files.length==0)
	                                                                                                                                                    $(".plupload_add").show();
                                                                                                                                                    
                                                                                                                                                },
                                                                                                    			
                                                                                                                UploadComplete:function(up,archivos)
                                                                                                                                {
                                                                                                                                 	
                                                                                                                                },
                                                                                                               	FileUploaded:function(up,archivos,response)
                                                                                                                				{
                                                                                                                                	
                                                                                                                                    if(response.response=='1|')
                                                                                                                                    {
                                                                                                                                    	gEx('gridAutorizacionAudienciaVirtual').getStore().reload();
                                                                                                                                    	ventanaAM.close();
                                                                                                                                    }
                                                                                                                                }
                                                                                                            },
                                                                                                    filters : 	{
                                                                                                                    // Maximum file size
                                                                                                                    max_file_size : '512mb',
                                                                                                                    // Specify what files to browse for
                                                                                                                    mime_types: [
                                                                                                                        {title : "Archivos de imagen", extensions : "jpg,gif,png"},
                                                                                                                        {title : "Documentos PDF", extensions : "pdf"}
                                                                                                                    ]
                                                                                                                },
                                                                                             
                                                                                                    // Resize images on clientside if we can
                                                                                                   
                                                                                             
                                                                                                    // Flash settings
                                                                                                    flash_swf_url : '../Scripts/plupload/js/Moxie.swf',
                                                                                                 
                                                                                                    // Silverlight settings
                                                                                                    silverlight_xap_url : '../Scripts/plupload/js/Moxie.xap'
                                                                                                });
																
                                                                	$("#uploader").bind('UploadComplete', function(up, files) 
                                                                                                          {
                                                                                                              // Called when all files are either uploaded or failed
                                                                                                              alert('ok');
                                                                                                         }
                                                                 
                                                                 						)
                                                                                                          
                                                                    $(".plupload_start").hide(); 
                                                                    $("#uploader_filelist").height('50px');  
                                                                    $("#uploader_filelist").css("line-height", '20px !important');
                                                                    setTimeout(function(){ gE('ID_plupload_droptext').style='line-height: 20px'; }, 500);

                                                                    
                                
                                                                }
															}
												},
										buttons:	[
                                        				{
                                                        	x:400,
                                                            y:5,
                                                            xtype:'button',
                                                            width:100,
                                                            icon:'../images/icon_tick.gif',
                                                            cls:'x-btn-text-icon',
                                                            text:'Subir documento',
                                                            handler:function()
                                                                    {
                                                                    	
                                                                        if(uploadControl.files.length==0)
                                                                        {
                                                                        	msgBox('Debe seleccionar el documento a cargar');
                                                                        	return false;
                                                                        }
                                                                        uploadControl.start();
                                                                        
                                                                    }
                                                        },
														{
															
															text: 'Cancelar',
                                                            
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

function visualizarDocumentoAdjunto(ext,iD)
{
	mostrarVisorDocumentoProceso(bD(ext),bD(iD));
}


function generarCuentaVideoGrabacion(iP)
{
	var gridAutorizacionAudienciaVirtual=gEx('gridAutorizacionAudienciaVirtual');
	var posFila=obtenerPosFila(gridAutorizacionAudienciaVirtual.getStore(),'idParticipante',bD(iP));
 	if(fila.data.identificacion=='')
    {
    	function resp1()
        {
        	
        	gEx('tabGeneral').setActiveTab('panelPartes');
        }
    	msgBox('Debe ingresar la <b>Identificaci&oacute;n</b> de la persona',resp1);
    	return;
    }   
    
    if(fila.data.documentoAutorizacion=='')
    {
    	function resp2()
        {
        	gEx('tabGeneral').setActiveTab('panelPartes');
        }
    	msgBox('Debe ingresar el <b>Documento de autorizaci&oacute;n de agenda de audiencia virtual</b> de la persona',resp2);
    	return;
    }  
    
    function resp(btn)
    {
    	if(btn=='yes')
        {
        	var cadObj='{"idActividad":"'+gE('idActividad').value+'","idParticipante":"'+bD(iP)+
            			'","idFiguraJuridica":"'+fila.data.figuraJuridica+'","idCarpeta":"'+gE('idCarpetaAdministrativa').value+
                        '","carpeta":"'+gE('carpetaAdministrativa').value+'","validarUsuarioMail":"1"}';
        	function funcAjax()
            {
                var resp=peticion_http.responseText;
                arrResp=resp.split('|');
                if(arrResp[0]=='1')
                {
                	switch(arrResp[1])
                    {
                    	case '1':
                        	gEx('gCuentasUsuario').getStore().reload();
                            gEx('gridAutorizacionAudienciaVirtual').getStore().reload();
                            generarDocumentoCuentaVideoGrabacion(iP,bE(0))
                        break;
                        case '2':
                        	var arrCuentas=eval(arrResp[2]);
                        	mostrarVentanaCuentaAccesoEncontrada(arrCuentas,cadObj,+bD(iP));
                        break;
                    }
                
                    
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=212&cadObj='+cadObj,true);
        }
    }
    msgConfirm('Est&aacute; seguro de querer crear la cuenta de acceso del usuario <b>'+fila.data.nombreParticipante+'</b>',resp);
    
}

function generarDocumentoCuentaVideoGrabacion(iP,eM)
{
	var arrParametros=[['idParticipante',bD(iP)],['carpetaAdministrativa',gE('carpetaAdministrativa').value],['reenviarDatosAcceso',bD(eM)]]
    enviarFormularioDatos('../modulosEspeciales_SGJP/generarCuentaAudienciaVirtual.php',arrParametros,'POST','frameDTD');
    primeraCargaFrame=false;
}


function activarAudienciaVirtualesCarpeta(valor)
{
	var cadObj='{"carpetaAdministrativa":"'+gE('carpetaAdministrativa').value+'","valor":"'+valor+'"}';
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            
        }
        else
        {
        	function respAux()
            {
            	gEx('cmbSiNoPermiteAudienciaVirtual').setValue(valor=='1'?'0':'1');
            }
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[1],respAux);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=315&cadObj='+cadObj,true);
}


function mostrarVentanaDehabilitarAudienciaVirtual()
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
                                                            html:'Ingrese el motivo por el cual se deshabilita la programaci&oacute;n de la audiencia virtual:'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            xtype:'textarea',
                                                            width:550,
                                                            height:60,
                                                            id:'txtMotivoDeshabilitar'
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Deshabilitar programaci&oacute;n de audiencia virtual',
										width: 600,
										height:200,
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
                                                                	gEx('txtMotivoDeshabilitar').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
															handler: function()
																	{
																		var txtMotivoDeshabilitar=gEx('txtMotivoDeshabilitar');
                                                                        
                                                                        if(txtMotivoDeshabilitar.getValue()=='')
                                                                        {
                                                                        	function resp1()
                                                                            {
                                                                            	txtMotivoDeshabilitar.focus();
                                                                            }
                                                                            msgBox('Debe ingresar el motivo por el cual se deshabilita la programaci&oacute;n de la audiencia virtual',resp1);
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
                                                                                    	ventanaAM.close();
                                                                                        gEx('btnEnableAudienciaVirtual').show();
                                                                                        gEx('btnDisableAudienciaVirtual').hide();
                                                                                        gE('lblPermiteAudienciaVirtual').innerHTML='No';
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                    }
                                                                                }
                                                                                obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=318&situacion=0&motivo='+cv(txtMotivoDeshabilitar.getValue())+'&carpetaAdministrativa='+gE('carpetaAdministrativa').value,true);

                                                                            }
                                                                        }
                                                                        msgConfirm('Est&aacute; seguro de querer deshabilita la programaci&oacute;n de la audiencia virtual en esta carpeta',resp);
                                                                        
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


function mostrarHistorialAudienciaVirtual()
{
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'border',
                                            frame:false,
											defaultType: 'label',
											items: 	[
														crearGridHistorialAudienciaVirtual()

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Historial Programaci&oacute;n Audiencia Virtual',
										width: 900,
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

function crearGridHistorialAudienciaVirtual()
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idRegistro'},
                                                        {name:'fechaOperacion', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name:'situacionOriginal'},
		                                                {name:'situacionCambio'},
		                                                {name:'responsable'},
                                                        {name: 'comentarios'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../paginasFunciones/funcionesModulosEspeciales_SGP.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'fechaOperacion', direction: 'DESC'},
                                                            groupField: 'fechaOperacion',
                                                            remoteGroup:false,
				                                            remoteSort: true,
                                                            autoLoad:true
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='319';
                                        proxy.baseParams.carpetaAdministrativa=gE('carpetaAdministrativa').value;
                                        
                                        
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer(),
                                                            {
                                                                header:'Fecha',
                                                                width:150,
                                                                sortable:true,
                                                                align:'center',
                                                                dataIndex:'fechaOperacion',
                                                                renderer:function(val)
                                                                		{
                                                                        
                                                                        	return formatoTitulo(val.format('d')+' de '+arrMeses[parseInt(val.format('m'))-1][1]+' de '+val.format('Y')+'<br>('+val.format('H:i:s')+' hrs.)');
                                                                        }
                                                            },
                                                            {
                                                                header:'Situaci&oacute;n actual',
                                                                width:200,
                                                                sortable:true,
                                                                dataIndex:'situacionOriginal',
                                                                renderer:formatoTitulo2HistorialAudienciasVirtuales
                                                            },
                                                            {
                                                                header:'Situaci&oacute;n cambio',
                                                                width:200,
                                                                sortable:true,
                                                                dataIndex:'situacionCambio',
                                                                renderer:formatoTitulo2HistorialAudienciasVirtuales
                                                            },                                                            
                                                            {
                                                                header:'Responsable',
                                                                width:250,
                                                                sortable:true,
                                                                dataIndex:'responsable',
                                                                renderer:formatoTitulo3HistorialAudienciasVirtuales
                                                            }
                                                            
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                    {
                                                        id:'gridHistorialAudienciaVirtual',
                                                        store:alDatos,
                                                        region:'center',
                                                        frame:false,
                                                        border:true,
                                                        cm: cModelo,
                                                        columnLines : false,
                                                        stripeRows :true,
                                                        loadMask:true,                                                                                                                        
                                                        view:new Ext.grid.GroupingView({
                                                                                            forceFit:false,
                                                                                            showGroupName: false,
                                                                                            enableGrouping :false,
                                                                                            enableNoGroups:false,
                                                                                            enableGroupingMenu:false,
                                                                                            hideGroupedColumn: false,
                                                                                            startCollapsed:false,
                                                                                            enableRowBody:true,
                                                                                            getRowClass : formatearFilaHistorialAudienciaVirtual
                                                                                        })
                                                    }
                                                );
        return 	tblGrid;	
}

function formatearFilaHistorialAudienciaVirtual(record, rowIndex, p, ds)
{
	var xf = Ext.util.Format;
    p.body = '<BR><p style="margin-left: 4em;margin-right: 4em;text-align:justify"><br><span class="menu"><span style="color: #001C02">Comentarios:</span><br><br><span style="color: #3B3C3B">' + ((record.data.comentarios.trim()=="")?"(Sin comentarios)":record.data.comentarios) + '</span></p><br><br><br>';
    return 'x-grid3-row-expanded';
}

function formatoTituloHistorialAudienciasVirtuales(val)
{
	return '<span style="font-size:11px; color:#040033">'+val+'</span>';
}

function formatoTitulo2HistorialAudienciasVirtuales(val)
{
	return '<div style="font-size:11px; color:#040033;; height:45px; word-wrap: break-word;white-space: normal; ">'+val+'</div>';
}

function formatoTitulo3HistorialAudienciasVirtuales(val)
{
	return '<div style="font-size:11px; height:45px; color:#040033; word-wrap: break-word;white-space: normal;"><img src="../images/user_gray.png">'+(val)+'</div>';
}

function mostrarVentanaCuentaAccesoEncontrada(arrCuentas,objAux,iP)
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
                                                            html:'<b>Se ha encontrado que alguna de las direcciones de correo electr&oacute;nico registadas, ya se encuentra registrada en el sistema:</b>'
                                                        },
                                                        crearGridCuentaEncontrada(arrCuentas),
                                                        {
                                                        	x:10,
                                                            y:270,
                                                            html:'<b>Seleccione la acci&oacute;n que desea realizar:</b>'
                                                        },
                                                        {
                                                        	xtype:'radio',
                                                            x:280,
                                                            y:265,
                                                            id:'rdo1',
                                                            name:'radioAccion',
                                                            boxLabel:'Asociar con la cuenta existente seleccionada'
                                                        },
                                                         {
                                                        	xtype:'radio',
                                                            x:280,
                                                            y:295,
                                                            id:'rdo2',
                                                            name:'radioAccion',
                                                            boxLabel:'Crear una nueva cuenta'
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Correo electr&oacute;nico encontrado',
										width: 750,
                                        id:'vCorreoEncontrado',
										height:420,
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
																		var rdo1=gEx('rdo1');
                                                                        var rdo2=gEx('rdo2');
                                                                        
                                                                        if(rdo1.getValue())
                                                                        {
                                                                        	var fila=gEx('gridCuentasEncontradas').getSelectionModel().getSelected();
                                                                            if(!fila)
                                                                            {
                                                                            	msgBox('Debe seleccionar la cuenta con la cual desea asociar la carpeta judicial');
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
                                                                                            switch(arrResp[1])
                                                                                            {
                                                                                                case '1':
                                                                                                	gEx('vCorreoEncontrado').close();
                                                                                                    gEx('gCuentasUsuario').getStore().reload();
                                                                                                    gEx('gridAutorizacionAudienciaVirtual').getStore().reload();
                                                                                                    generarDocumentoCuentaVideoGrabacion(bE(iP),bE(0))
                                                                                                break;
                                                                                                
                                                                                            }
                                                                                        }
                                                                                        else
                                                                                        {
                                                                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                        }
                                                                                    }
                                                                                    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=320&idUsuario='+fila.data.idUsuario+'&cadObj='+objAux.replace('"validarUsuarioMail":"1"','"validarUsuarioMail":"0"'),true);
                                                                                }
                                                                            }
                                                                            msgConfirm('Est&aacute; seguro de querer asociar la cuenta del usuario <b>'+fila.get('nombre')+'</b> a la carpeta judicial?',resp);
                                                                            
                                                                        }
                                                                        else
                                                                        {
                                                                        	if(rdo2.getValue())
                                                                            {
                                                                            	function resp2(btn)
                                                                                {
                                                                                    if(btn=='yes')
                                                                                    {
                                                                                    	
                                                                                        function funcAjax()
                                                                                        {
                                                                                            var resp=peticion_http.responseText;
                                                                                            arrResp=resp.split('|');
                                                                                            if(arrResp[0]=='1')
                                                                                            {
                                                                                                switch(arrResp[1])
                                                                                                {
                                                                                                    case '1':
                                                                                                    	gEx('vCorreoEncontrado').close();
                                                                                                        gEx('gCuentasUsuario').getStore().reload();
                                                                                                        gEx('gridAutorizacionAudienciaVirtual').getStore().reload();
                                                                                                        generarDocumentoCuentaVideoGrabacion(bE(iP),bE(0))
                                                                                                    break;
                                                                                                    
                                                                                                }
                                                                                            }
                                                                                            else
                                                                                            {
                                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                            }
                                                                                        }
                                                                                        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=212&cadObj='+objAux.replace('"validarUsuarioMail":"1"','"validarUsuarioMail":"0"'),true);
                                                                                    }
                                                                                }
                                                                                msgConfirm('Est&aacute; seguro de querer crear una nueva cuenta asociada a la carpeta judicial?',resp2);
                                                                                
                                                                            }
                                                                            else
                                                                            {
                                                                            	msgBox('Debe seleccionar la acci&oacute;n que desea realizar');
                                                                            	return;
                                                                            }
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


function crearGridCuentaEncontrada(arrCuentas)
{
	var dsDatos=arrCuentas;
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'idUsuario'},
                                                                    {name: 'nombre'},
                                                                    {name: 'mails'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel();
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														chkRow,
                                                        {
															header:'ID Usuario',
															width:95,
															sortable:true,
															dataIndex:'idUsuario'
														},
														{
															header:'Nombre de usuario',
															width:250,
															sortable:true,
															dataIndex:'nombre'
														},
														{
															header:'Direcci&oacute;n de correo electr&oacute;nico',
															width:300,
															sortable:true,
															dataIndex:'mails',
                                                            renderer:mostrarValorDescripcion
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gridCuentasEncontradas',
                                                            store:alDatos,
                                                            frame:false,
                                                            y:40,
                                                            x:10,
                                                            cm: cModelo,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            stripeRows :true,
                                                            columnLines : true,
                                                            height:210,
                                                            width:700,
                                                            sm:chkRow
                                                        }
                                                    );
	return 	tblGrid;
}
