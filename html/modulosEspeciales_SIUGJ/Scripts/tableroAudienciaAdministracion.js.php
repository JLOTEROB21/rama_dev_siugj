<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$consulta="SELECT idEtapaProcesal,descripcionEtapa,orden FROM 7009_etapasProcesales ORDER BY orden";
	$arrEtapasProcesales=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT idCategoria,nombreCategoria,idPerfilMetaDatos FROM 908_categoriasDocumentos order by nombreCategoria";
	$arrCategorias=$con->obtenerFilasArreglo($consulta);

	$arrPerfilMetadato="";
	$consulta="SELECT idPerfilMetaDato,nombrePerfil FROM 20005_perfilesMetaDatos";
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_assoc($res))
	{
		$consulta="SELECT m.idMetaDato,obligatorio FROM 20006_metaDatoPerfil m,20003_catalogoMetaDatos cM 
				WHERE idPerfilMetaDato=".$fila["idPerfilMetaDato"]." and cM.idMetaDato=m.idMetaDato and cM.metodoResolucion<>1";
		$arrMetaDatos=$con->obtenerFilasArreglo($consulta);
		$o="['".$fila["idPerfilMetaDato"]."','".cv($fila["nombrePerfil"])."',".$arrMetaDatos."]";
		if($arrPerfilMetadato=="")
			$arrPerfilMetadato=$o;
		else
			$arrPerfilMetadato.=",".$o;
	}
	$arrPerfilMetadato="[".$arrPerfilMetadato."]";
	$arrTipoDocumentos=$arrCategorias;

	$carpetaAdministrativa=bD($_GET["cA"]);
	$idCarpetaAdministrativa=bD($_GET["iC"]);
	
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

	if($minFechaAlerta=="")
		$minFechaAlerta=date("Y-m-d");

	$consulta="SELECT MAX(r.fechaRecordatorio) FROM 7037_recordatoriosPreviosNotificacion r,7036_alertasNotificaciones a WHERE 
				a.carpetaAdministrativa='".$carpetaAdministrativa."' AND r.idAlertaNotificacion=a.idRegistro and a.situacion=1";
	$maxFechaAlerta=$con->obtenerValor($consulta);
	if($maxFechaAlerta=="")
		$maxFechaAlerta=date("Y-m-d");
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
	
	$consulta="SELECT tipoProceso FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaAdministrativa."'";
	$tipoProceso=$con->obtenerValor($consulta);
	
	
	$consulta="SELECT id__1250_tablaDinamica FROM _1250_tablaDinamica WHERE idReferencia=".$tipoProceso;
	$idConfiguracion=$con->obtenerValor($consulta);
	$tipoFigura="2,4,5,6,11";
	
	if($idConfiguracion=="")
	{
		if($tipoProceso==6)
		{
			$tipoFigura="7,8,10,11";
		}
		if(($tipoProceso==18)||($tipoProceso==15)||($tipoProceso==21)||($tipoProceso==22))
			$tipoFigura="2,4,6,11";		
	}
	else
	{
		$consulta="SELECT figuraJuridica FROM _1250_gridSujetosProcesales WHERE idReferencia=".$idConfiguracion;
		$tipoFigura=$con->obtenerListaValores($consulta);
		if($tipoFigura=="")
			$tipoFigura=-1;
	}
	
	
	
	

	$consulta="SELECT id__5_tablaDinamica,nombreTipo  FROM _5_tablaDinamica where id__5_tablaDinamica in	(".$tipoFigura.") order by prioridad";
	$arrTipoFigura=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT id__5_tablaDinamica,
	if((SELECT nombreSingular FROM _5_aliasTiposFiguras WHERE idFigura=t.id__5_tablaDinamica AND materia='".$tipoMateria."') is null
			,nombreTipo,(SELECT nombreSingular FROM _5_aliasTiposFiguras WHERE idFigura=t.id__5_tablaDinamica AND materia='PT')) as nombreTipo 
			 FROM _5_tablaDinamica t where id__5_tablaDinamica in(".$tipoFigura.") order by nombreTipo";
	
	
	
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
	
	$etiquetaCarpeta="Proceso Judicial";
	$lblDocumentosAsociados="Documentos Asociados al Proceso Judicial";
	$lblExpedientesAsociados="Procesos Judiciales Asociados";
	
	$consulta="SELECT id__659_tablaDinamica,nombrePerfil FROM _659_tablaDinamica";
	$arrPerfilesAcceso=$con->obtenerFilasArreglo($consulta);
	$consulta="SELECT idRegistro,tipoAlertaNotificacion FROM 7038_tiposAlertaNotificaciones WHERE considerarNotificacionDelDia=1 ORDER BY tipoAlertaNotificacion";
	$arrTipoNotificaciones=$con->obtenerFilasArreglo($consulta);
	
	$arrConfMetaDatos="";
	$consulta="SELECT idMetaDato,nombreMetaDato,metodoResolucion,tipoDatoEntrada,funcionSistema,fuenteDatos 
				FROM 20003_catalogoMetaDatos WHERE situacionActual=1 ORDER BY nombreMetaDato";
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_assoc($res))
	{
		$arrOpciones="";
		
		if($fila["metodoResolucion"]==2)
		{
			switch($fila["fuenteDatos"])
			{
				case 0:
					$arrOpciones="";
					$cacheCalculos=NULL;
					$cadParametros='{"idMetaDato":"'.$fila["idMetaDato"].'","carpetaAdministrativa":"'.$carpetaAdministrativa.
									'","idCarpetaAdministrativa":"'.$idCarpetaAdministrativa.'"}';
					$objParametros=json_decode($cadParametros);
					$aOpciones=resolverExpresionCalculoPHP($fila["funcionSistema"],$objParametros,$cacheCalculos);
					foreach($aOpciones as $o)
					{
						$o="['".$o["clave"]."','".cv($o["valor"])."']";
						if($arrOpciones=="")
							$arrOpciones=$o;
						else
							$arrOpciones.=",".$o;
					}
					
					$arrOpciones='['.$arrOpciones.']';
				break;
				case 1:
					$consulta="SELECT valor,etiqueta FROM 20004_opcionesMetaDatos WHERE idMetaDatos=".$fila["idMetaDato"]." ORDER BY etiqueta";
					$arrOpciones=$con->obtenerFilasArreglo($consulta);
				break;
				
			}
		}
		else
		{
			$arrOpciones='[]';
		}
		$oMeta="['".$fila["idMetaDato"]."','".cv($fila["nombreMetaDato"])."',".$fila["tipoDatoEntrada"].",".$arrOpciones."]";
		if($arrConfMetaDatos=="")
			$arrConfMetaDatos=$oMeta;
		else
			$arrConfMetaDatos.=",".$oMeta;
	}
	$arrConfMetaDatos="[".$arrConfMetaDatos."]";
	
	
	$consulta="SELECT id__857_tablaDinamica,medidaCautelar FROM _857_tablaDinamica WHERE tipoMedida=5 ORDER BY id__857_tablaDinamica";
	$arrGrupoEtnico=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT id__857_tablaDinamica,medidaCautelar FROM _857_tablaDinamica WHERE tipoMedida=6 ORDER BY id__857_tablaDinamica";
	$arrDiscapacidad=$con->obtenerFilasArreglo($consulta);
	
	
	$consulta="SELECT idPais,nombre FROM 238_paises ORDER BY nombre";
	$arrPaises=$con->obtenerFilasArreglo($consulta);
	
	$permiteEditarPerfilAcceso=(existeRol("'56_0'")||existeRol("'96_0'")||existeRol("'94_0'"))?"true":"false";
?>
var arrStatusAlertaCombo=[['0','Todas'],['1,4','Activas'],['2','Canceladas'],['3','Atendidas']];
var permiteEditarSecretarioJuez=<?php echo $permiteEditarPerfilAcceso?>;
var arrGrupoEtnico=<?php echo $arrGrupoEtnico?>;
var arrDiscapacidad=<?php echo $arrDiscapacidad?>;
var arrPaises=<?php echo $arrPaises?>;
var arrObjetosMetaData=[];
var arrPerfilMetadato=<?php echo $arrPerfilMetadato?>;
var arrConfMetaDatos=<?php echo $arrConfMetaDatos?>;
var tipoProceso=<?php echo $tipoProceso?>;
var arrTipoFigura=<?php echo $arrTipoFigura?>;
var arrTipoNotificaciones=<?php echo $arrTipoNotificaciones?>;
var arrPerfilesAcceso=<?php echo $arrPerfilesAcceso?>;
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
var arrMetaDatos=[];
var arrSemaforo=<?php echo $arrSituaciones?>;
var seleccionarSujeto=false;
var cancelarBusquedaDatosPersona=false;

Ext.onReady(inicializar);

function inicializar()
{

	arrConfMetaDatos.splice(0,0,['0','Tipo Documental',arrCategorias]);
    var vista=new Ext.Viewport(	{
                                layout: 'border',
                                border:false,
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
                                                border:false,
                                                layout:'border',
                                                items:	[	
                                                			
                                                            {
                                                            	xtype:'panel',
                                                                region:'center',
                                                                 border:false,
                                                                layout:'border',
                                                                items:	[
                                                                			{
                                                                            	xtype:'panel',
                                                                                region:'center',
                                                                                layout:'border',
                                                                                cls:'panelSiugjExpediente',
                                                                                border:false,
                                                                                title:etiquetaCarpeta+': <span style="color:#900"><b>'+gE('carpetaAdministrativa').value+'</b></span>',
                                                                                items:	[
                                                                                            {
                                                                                                xtype:'tabpanel',
                                                                                                activeTab:0,
                                                                                                region:'center',
                                                                                                split:true,
                                                                                                cls:'tabPanelSIUGJ',
                                                                                                enableTabScroll:true,
                                                                                                height:200,
                                                                                                id:'tabGeneral',
                                                                                                border:false,                                                                                
                                                                                                items:	[
                                                                                                			{
                                                                                                            	xtype:'panel',
                                                                                                                layout:'border',
                                                                                                                title:'<?php echo $lblDocumentosAsociados ?>',
                                                                                                                items:	[
                                                                                                                			{
                                                                                                                            	xtype:'panel',
                                                                                                                                width:300,
                                                                                                                                region:'west',
                                                                                                                                layout:'border',
                                                                                                                                items:	[
                                                                                                                                			crearArbolCarpetasJudiciales(),
                                                                                                                                            crearGridPropiedadesProceso()
                                                                                                                                		]
                                                                                                                            },
                                                                                                                            {
                                                                                                                            	xtype:'panel',
                                                                                                                                border:false,
                                                                                                                                cls:'panelSiugjExpedienteUsuario',
                                                                                                                                layout:'border',
                                                                                                                                region:'center',
                                                                                                                                bbar:	[
                                                                                                                                            new Ext.Toolbar	(
                                                                                                                                                        
                                                                                                                                                                {
                                                                                                                                                                    buttonAlign:'center',
                                                                                                                                                                    items:	[
                                                                                                                                                                                {
                                                                                                                                                                                    icon:'../principalPortal/imagesSIUGJ/addTransparente.png',
                                                                                                                                                                                    cls:'x-btn-text-icon btnSIUGJ',
                                                                                                                                                                                    disabled:true,
                                                                                                                                                                                    hidden:gE('sL').value=='1',
                                                                                                                                                                                    id:'btnAdjuntar',
                                                                                                                                                                                    text:'Adjuntar documento',
                                                                                                                                                                                    width:130,
                                                                                                                                                                                    handler:function()
                                                                                                                                                                                            {
                                                                                                                                                                                                //mostrarVentanaMetaDato1();
                                                                                                                                                                                                mostrarVentanaAgregarDocumento();
                                                                                                                                                                                            }
                                                                                                                                                                                    
                                                                                                                                                                                },
                                                                                                                                                                                {
                                                                                                                                                                                	xtype:'tbspacer',
                                                                                                                                                                                    width:15
                                                                                                                                                                                }
                                                                                                                                                                                ,
                                                                                                                                                                                {
                                                                                                                                                                                    icon:'../principalPortal/imagesSIUGJ/cameraScan.png',
                                                                                                                                                                                    cls:'x-btn-text-icon btnSIUGJCancel',
                                                                                                                                                                                    disabled:true,
                                                                                                                                                                                    hidden:gE('sL').value=='1',
                                                                                                                                                                                    id:'btnScanDocumento',
                                                                                                                                                                                    width:130,
                                                                                                                                                                                    text:'Escanear documento',
                                                                                                                                                                                    handler:function()
                                                                                                                                                                                            {
                                                                                                                                                                                                var cadObj='{"afterScanFunction":"scanCorrectoDocument"}';
                                                                                                                                                                                                var obj={};
                                                                                                                                                                                                obj.ancho='100%';
                                                                                                                                                                                                obj.alto='100%';
                                                                                                                                                                                                obj.url='../scan/tLatisScanner.php';
                                                                                                                                                                                                obj.params=[['cadObj',bE(cadObj)]];
                                                                                                                                                                                                abrirVentanaFancy(obj);
                                                                                                                                                                                            }
                                                                                                                                                                                    
                                                                                                                                                                                }
                                                                                                                                                                            ]
                                                                                                                                                                }
                                                                                                                                                             )
                                                                                                                                        ],
                                                                                                                                items:	[
                                                                                                                							crearArbolCarpetaAdministrativa()
                                                                                                                                        ]
                                                                                                                            },
                                                                                                                            {
                                                                                                                            	xtype:'panel',
                                                                                                                                width:350,
                                                                                                                                border:true,
                                                                                                                                cls:'gridSiugjVistaExpedienteUsuario gridSiugjVistaExpedienteUsuarioExpediente',
                                                                                                                                title:'Meta data del documento',
                                                                                                                                collapsible:true,
                                                                                                                                layout:'border',
                                                                                                                                region:'east',
                                                                                                                                id:'panelMeta',
                                                                                                                                items:	[
                                                                                                                                			crearGridPropiedadesDocumento()
                                                                                                                                
                                                                                                                                		]
                                                                                                                            }
                                                                                                                		]
                                                                                                            }
                                                                                                            ,
                                                                                                            
                                                                                                            crearGridEventos(),
                                                                                                            crearGridGeneracionDocumentos(),
																											crearPanelPartesProcesales(),
                                                                                                            
                                                                                                            {
                                                                                                            	xtype:'panel',
                                                                                                                layout:'border',
                                                                                                                listeners:	{
                                                                                                                				activate:function(p)
                                                                                                                                        {
                                                                                                                                            if(!p.visualizado)
                                                                                                                                            {
                                                                                                                                                p.visualizado=1;
                                                                                                                                                gEx('frameRegistroNotificaciones').load	(
                                                                                                                                                                                        {
                                                                                                                                                                                            scripts:true,
                                                                                                                                                                                            url:'../modeloProyectos/visorRegistrosProcesosV2.php',
                                                                                                                                                                                            params:	{
                                                                                                                                                                                                        cPagina: 'sFrm=true',
                                                                                                                                                                                                        idProceso: 274,
                                                                                                                                                                                                        pantallaCompleta:'1',
                                                                                                                                                                                                        idFormulario: -1,
                                                                                                                                                                                                        actor:"'230_0'",
                                                                                                                                                                                                        sL:gE('sL').value,
                                                                                                                                                                                                        parametrosProceso:bE('{"carpetaAdministrativa":"'+nodoCarpetaSel.id.split('_')[0]+'"}'),
                                                                                                                                                                                                        contentIframe:0
                                                                                                                                                                                                    }
                                                                                                                                                                                       }
                                                                                                                                                                                    )
                                                                                                                                        
                                                                                                                                                
                                                                                                                                            }
                                                                                                                                        }
                                                                                                                			},
                                                                                                                title:'Notificaciones',
                                                                                                                items:	[
                                                                                                                			new Ext.ux.IFrameComponent({ 

                                                                                                                                                            id: 'frameRegistroNotificaciones', 
                                                                                                                                                            anchor:'100% 100%',
                                                                                                                                                            region:'center',
                                                                                                                                                            loadFuncion:function(iFrame)
                                                                                                                                                                        {
                                                                                                                                                                            
                                                                                                                                                                            
                                                                                                                                                                           
                                                                                                                                                                            
                                                                                                                                                                        },
                                                                    
                                                                                                                                                            url: '../paginasFunciones/white.php',
                                                                                                                                                            style: 'width:100%;height:100%' 
                                                                                                                                                    })
                                                                                                                		]
                                                                                                            },
                                                                                                            {
                                                                                                            	xtype:'panel',
                                                                                                                layout:'border',
                                                                                                                listeners:	{
                                                                                                                				activate:function(p)
                                                                                                                                        {
                                                                                                                                            if(!p.visualizado)
                                                                                                                                            {
                                                                                                                                                p.visualizado=1;
                                                                                                                                                gEx('frameAccesoExpedientes').load	(
                                                                                                                                                                                        {
                                                                                                                                                                                            scripts:true,
                                                                                                                                                                                            url:'../modeloProyectos/visorRegistrosProcesosV2.php',
                                                                                                                                                                                            params:	{
                                                                                                                                                                                                        cPagina: 'sFrm=true',
                                                                                                                                                                                                        idProceso: 317,
                                                                                                                                                                                                        pantallaCompleta:'1',
                                                                                                                                                                                                        idFormulario: -1,
                                                                                                                                                                                                        actor:"'230_0'",
                                                                                                                                                                                                        sL:gE('sL').value,
                                                                                                                                                                                                        parametrosProceso:bE('{"paramCAdministrativa":"'+nodoCarpetaSel.id.split('_')[0]+'","carpetaAdministrativa":"'+nodoCarpetaSel.id.split('_')[0]+'"}'),
                                                                                                                                                                                                        contentIframe:0
                                                                                                                                                                                                    }
                                                                                                                                                                                       }
                                                                                                                                                                                    )
                                                                                                                                        
                                                                                                                                                
                                                                                                                                            }
                                                                                                                                        }
                                                                                                                			},
                                                                                                                title:'Accesos a Proceso Judiciales',
                                                                                                                items:	[
                                                                                                                			new Ext.ux.IFrameComponent({ 

                                                                                                                                                            id: 'frameAccesoExpedientes', 
                                                                                                                                                            anchor:'100% 100%',
                                                                                                                                                            region:'center',
                                                                                                                                                            loadFuncion:function(iFrame)
                                                                                                                                                                        {
                                                                                                                                                                            
                                                                                                                                                                            
                                                                                                                                                                           
                                                                                                                                                                            
                                                                                                                                                                        },
                                                                    
                                                                                                                                                            url: '../paginasFunciones/white.php',
                                                                                                                                                            style: 'width:100%;height:100%' 
                                                                                                                                                    })
                                                                                                                		]
                                                                                                            },
                                                                                                            crearPanelNotificacionesDia()
                                                                                                            
                                                                                                            
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

function crearGridPropiedadesDocumento()
{
	var cmbPerfilAcceso=crearComboExt('cmbPerfilAcceso',arrPerfilesAcceso,0,0);
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name: 'idMeta'},
		                                                {name: 'metaData'},
		                                                {name:'valor'},
                                                        {name: 'perfilMetadata'},
                                                        {name:'arrOpciones'},
                                                        {name:'tipoEntrada'},
                                                        {name:'valorEtiqueta'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../modulosEspeciales_SGJ/paginasFunciones/funcionesModulosEspeciales_SGJ.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'metaData', direction: 'ASC'},
                                                            groupField: 'metaData',
                                                            remoteGroup:false,
				                                            remoteSort: true,
                                                            autoLoad:false
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='4';
                                        
                                    }
                        )   
       
    var cModelo= new Ext.grid.ColumnModel   	(
                                                    [
                                                        {
                                                            header:'Meta Data',
                                                            width:180,
                                                            sortable:true,
                                                            menuDisabled : true,
                                                            dataIndex:'metaData'
                                                        },
                                                        {
                                                            header:'',
                                                            width:140,
                                                            menuDisabled : true,
                                                            sortable:true,
                                                            dataIndex:'valor',
                                                            editor:cmbPerfilAcceso,
                                                            renderer:function(val,meta,registro)
                                                            		{
                                                                    	if(registro.data.idMeta=='-4')
                                                                        	return bytesToSize(parseInt(val),0);
                                                                        else
                                                                        {
                                                                        	if(registro.data.idMeta=='-9')
                                                                        		return mostrarValorDescripcion(formatearValorRenderer(arrPerfilesAcceso,val));
                                                                    		else
                                                                            {

                                                                            	if(registro.data.tipoEntrada=='5')
                                                                                {
                                                                                	if(val.format)
                                                                                    	return val.format('d/m/Y');
                                                                                    else
                                                                                    {
                                                                                    	
                                                                                    	if(val!='')
		                                                                                	return Date.parseDate(val,'Y-m-d').format('d/m/Y');
                                                                                	}
                                                                                }
                                                                                else
                                                                                	if(registro.data.arrOpciones.length>0)
                                                                                    	return formatearValorRenderer(registro.data.arrOpciones,val);
                                                                                    else
                                                                                    {
		                                                                            	return mostrarValorDescripcion(escaparEnter((registro.data.valorEtiqueta?registro.data.valorEtiqueta:val)+''));
                                                                    				}
                                                                            }
                                                                        }
                                                                    }
                                                        },
                                                    ]
                                                );
                                                
    var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gMetaData',
                                                            store:alDatos,
                                                            region:'center',
                                                            frame:false,
                                                            border:false,
                                                            cls:'gridSiugjPrincipal gridSiugjExpediente',
                                                            cm: cModelo,
                                                            stripeRows :false,
                                                            loadMask:true,
                                                            columnLines : false,
                                                            clicksToEdit:1,
                                                            hideHeaders : true,
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
    
    tblGrid.on('beforeedit',function(e)
    						{
                            
                            	<?php
								if(!existeRol("'52_0'"))
								{
								?>
                                	if((gE('sL').value=='1')||(permiteEditarSecretarioJuez && !((e.record.data.idMeta=='-9')|| (e.record.data.idMeta=='1'))))
                                    {
                                        e.cancel=true;
                                        return ;	
                                    }
                                <?php
								}
								?>
                            	var ctrl=null;
                            	if(e.record.data.idMeta!='-9')
                                {
                                	if(e.record.data.perfilMetadata)
                                    {

                                    	var posFila=existeValorMatriz(arrConfMetaDatos,e.record.data.idMeta);
                                        var filaConf=arrConfMetaDatos[posFila];
                                        e.record.set('tipoEntrada',filaConf[2]);
                                        e.record.set('arrOpciones',filaConf[3]);
                                        
                                        switch(parseInt(e.record.data.tipoEntrada))
                                        {
                                            case 1:
                                            	e.record.set(e.field,escaparBR(e.record.get(e.field),true));
                                                ctrl=new Ext.form.TextArea (
                                                                                {
                                                                                    height:40,
                                                                                    cls:'controlSIUGJ'
                                                                                }
                                                                            )
                                            break;
                                            case 2:
                                                ctrl=new Ext.form.NumberField (
                                                                                {
                                                                                    allowDecimals:false,
                                                                                    cls:'controlSIUGJ'
                                                                                }
                                                                            )
                                            break;
                                            case 3:
                                                ctrl=new Ext.form.NumberField (
                                                                                {
                                                                                    allowDecimals:true,
                                                                                    cls:'controlSIUGJ'
                                                                                }
                                                                            )
                                            break;
                                            case 4:
                                                ctrl=new Ext.form.NumberField (
                                                                                {
                                                                                    allowDecimals:true,
                                                                                    cls:'controlSIUGJ'
                                                                                }
                                                                            )
                                            break;
                                            case 5:
                                                ctrl=new Ext.form.DateField ({ctCls:'campoFechaSIUGJ'});
                                            break;
                                            case 6:
                                                ctrl=new Ext.form.TextField ({cls:'controlSIUGJ'});
                                            break;
                                            default:
                                                if(e.record.data.arrOpciones.length>0)
                                                {
                                                    ctrl=crearComboExt('cmbEditor',e.record.data.arrOpciones,0,0,null,{transform:false,ctCls:'comboWrapSIUGJGrid',cls:'comboSIUGJGrid',listClass:'listComboSIUGJGrid listComboSIUGJGridExpediente'});
                                                }
                                            break;
                                       
                                        }
                                        
                                    }
                                   
                                }
                               	else
                                  {
                                      ctrl=crearComboExt('cmbPerfilAcceso',arrPerfilesAcceso,0,0,null,{transform:false,ctCls:'comboWrapSIUGJGrid',cls:'comboSIUGJGrid',listClass:'listComboSIUGJGrid listComboSIUGJGridExpediente'});
                                  }	
                                if(ctrl)
                                    e.grid.getColumnModel().setEditor(1,ctrl);
                                else
                                    e.cancel=true;
                            }
    
    			)
    
     tblGrid.on('afteredit',function(e)
    						{
                            	
                            	var fila=gEx('gridCarpetaAdministrativa').getSelectionModel().getSelected();
                            	
                                if(e.record.perfilMetadata=='')
                                {
                                    function funcAjax()
                                    {
                                        var resp=peticion_http.responseText;
                                        arrResp=resp.split('|');
                                        if(arrResp[0]=='1')
                                        {
                                            gEx('gMetaData').getStore().reload();
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
                                    obtenerDatosWeb('../modulosEspeciales_SGJ/paginasFunciones/funcionesModulosEspeciales_SGJ.php',funcAjax, 'POST','funcion=5&iM=1&valor='+
                                                    e.value+'&idDocumento='+fila.data.idDocumento,true);
                                }
                                else
                                {
                                	var valorEtiqueta='';
                                	var valor=e.value;
                                                                                                                                                    
                                    if((e.record.data.tipoEntrada=='5')&&(valor.format))
                                    {
                                        valor=valor.format('Y-m-d');
                                        
                                    }
                                    
                                    if(e.record.data.arrOpciones.length>0)
                                    {
                                        valorEtiqueta=formatearValorRenderer(e.record.data.arrOpciones,e.value);
                                    }
                                    
                                    if(valorEtiqueta=='')
                                    	valorEtiqueta=valor;
                                    
                                	var cadObj='{"idRegistroContenido":"'+fila.data.idRegistroContenido+'","idDocumento":"'+fila.data.idDocumento+'","idMetadato":"'+e.record.data.idMeta+'","valor":"'+cv(valor)+'","valorEtiqueta":"'+cv(valorEtiqueta)+'"}';
                                	function funcAjax()
                                    {
                                        var resp=peticion_http.responseText;
                                        arrResp=resp.split('|');
                                        if(arrResp[0]=='1')
                                        {
                                            gEx('gMetaData').getStore().reload();
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
                                    obtenerDatosWeb('../modulosEspeciales_SGJ/paginasFunciones/funcionesModulosEspeciales_SGJ.php',funcAjax, 'POST','funcion=34&cadObj='+cadObj,true);
                                }
                            }
    
    			)
    
    return 	tblGrid;
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
                                                        {name:'idRegistroContenido'},
                                                        {name:'ocr'},
		                                                {name: 'etapaProcesal'},
		                                                {name:'nomArchivoOriginal'},
		                                                {name: 'tamano'},
                                                        {name: 'fechaRegistro', type:'date', dateFormat:'Y-m-d'},
                                                        {name: 'fechaCreacion', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name: 'descripcion'},
                                                        {name:'idFormulario'},
                                                        {name:'idRegistro'},
                                                        {name:'idDocumento'},
                                                        {name: 'categoriaDocumentos'},
                                                        {name:'idDocumento'},
                                                        {name: 'ordenDocumento'},
                                                        {name: 'noPaginas'},
                                                        {name: 'paginaInicio'},
                                                        {name: 'paginaFin'},
                                                        {name: 'eliminadoRepositorio'}
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
                                                            groupField: 'etapaProcesal',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:false
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	gEx('gMetaData').getStore().removeAll();
                                    	var arrCarpeta=nodoCarpetaSel.id.split('_');
                                    	proxy.baseParams.funcion='19';
                                        proxy.baseParams.cA=bE(arrCarpeta[0]);
                                        proxy.baseParams.idCarpetaAdministrativa=<?php echo  $registrarIDCarpeta?"arrCarpeta[1]":"-1"?>;
                                        
                                        
                                        
                                        if((nodoCarpetaSel.attributes.tipoRelacion)&&(nodoCarpetaSel.attributes.tipoRelacion=='6'))
                                        {
                                        	proxy.baseParams.idCarpetaAdministrativa=(arrCarpeta[1]);
                                        }
                                        
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
       
	    

    var chkRow=new Ext.grid.CheckboxSelectionModel({singleSelect:true,hidden:true});     
    var cModelo= new Ext.grid.ColumnModel   	(
                                                    [
														chkRow,
                                                    	new  Ext.grid.RowNumberer({width:40}),
                                                        
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
                                                            dataIndex:'ocr',
                                                            renderer:function(val,meta,registro)
                                                            		{
                                                                    	
                                                                    	if(registro.data.eliminadoRepositorio=='1')
                                                                        {
                                                                        	return '<img src="../images/page_white_delete.png"  title="Eliminado de archivo central" alt="Eliminado de archivo central" />'
                                                                        }
                                                                    	if(val=='1')
	                                                                        return '<img src="../principalPortal/imagesSIUGJ/ojo.png" width="15" height="11" title="OCR" alt="OCR" />'
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
                                                                    	var arrNombre=registro.data.nomArchivoOriginal.split('.');
                                                                        return '<img src="../imagenesDocumentos/16/file_extension_'+arrNombre[1].toLowerCase()+'.png" />'
                                                                    }
                                                        },
                                                        
                                                        {
                                                            header:'Fecha de registro',
                                                            width:160,
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
                                                            //editor:cmbTipoDocumento,
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
                                                            width:280,
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
                                                                    	if((registro.data.etapaProcesal=='-1000')||(registro.data.eliminadoRepositorio=='1'))
                                                                        	return '';
                                                                        if(gE('sL').value=='1')
                                                                           	return '';
	                                                                    return '<a href="javascript:removerDocumento(\''+bE(val)+'\')"><img src="../principalPortal/imagesSIUGJ/delete.png" title="Remover documento" alt="Remover documento" /></a>';
                                                                        
                                                                    }
                                                        },
                                                        {
                                                            header:'Proceso',
                                                            width:80,
                                                            sortable:true,
                                                            align:'center',
                                                            dataIndex:'idDocumento',
                                                            renderer:function(val,meta,registro)
                                                            		{
                                                                    	if(registro.data.eliminadoRepositorio=='1')
                                                                        	return '';
                                                                        if(parseFloat(registro.data.idFormulario)>0)
	                                                                       	return '<a href="javascript:abrirProcesoOrigen(\''+bE(registro.data.idFormulario)+'\',\''+bE(registro.data.idRegistro)+'\')"><img src="../principalPortal/imagesSIUGJ/magnifier.png" title="Abrir proceso origen" alt="Abrir proceso origen" /></a>';
                                                                    }
                                                        },
                                                        {
                                                            header:'Orden',
                                                            width:80,
                                                            sortable:true,
                                                            align:'center',
                                                            dataIndex:'ordenDocumento',
                                                            renderer:mostrarValorDescripcion
                                                        },
                                                        {
                                                            header:'# P&aacute;ginas',
                                                            width:80,
                                                            align:'center',
                                                            sortable:true,
                                                            dataIndex:'noPaginas',
                                                            renderer:mostrarValorDescripcion
                                                        },
                                                        {
                                                            header:'P&aacute;g. Inicio',
                                                            width:110,
                                                            align:'center',
                                                            sortable:true,
                                                            dataIndex:'paginaInicio',
                                                            renderer:mostrarValorDescripcion
                                                        },
                                                        {
                                                            header:'P&aacute;g. Fin',
                                                            width:100,
                                                            align:'center',
                                                            sortable:true,
                                                            dataIndex:'paginaFin',
                                                            renderer:mostrarValorDescripcion
                                                        }
                                                        
                                                        
                                                        
                                                    ]
                                                );
                                                
    var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gridCarpetaAdministrativa',
                                                            store:alDatos,
                                                            border:false,
                                                            region:'center',
                                                            frame:false,
                                                            clicksToEdit:1,
                                                            cm: cModelo,
                                                            stripeRows :false,
                                                            loadMask:true,
                                                            columnLines : false, 
                                                            ddGroup:'grupoDrop',
                                                            cls:'gridSiugjPrincipal gridSiugjExpediente', 
                                                            sm:chkRow,
                                                            enableDragDrop:true,//
                                                            plugins:[filters],
                                                            sm:new Ext.grid.RowSelectionModel({singleSelect:true}),   
                                                            view:new Ext.grid.GroupingView({
                                                                                                forceFit:false,
                                                                                                showGroupName: false,
                                                                                                enableGrouping :true,
                                                                                                enableNoGroups:false,
                                                                                                enableGroupingMenu:false,
                                                                                                hideGroupedColumn: true,
                                                                                                startCollapsed:false,
                                                                                                groupTextTpl:'{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Documentos" : "Documento"]})</span>'
                                                                                            })
                                                        }
                                                    );
                                                    
	
    
    tblGrid.getSelectionModel().on('rowselect',function(sm,nFila,registro)
    											{
                                                	var arrCarpeta=nodoCarpetaSel.id.split('_');
                                                	gEx('gMetaData').getStore().load	(
                                                    										{
                                                                                            	url: '../modulosEspeciales_SGJ/paginasFunciones/funcionesModulosEspeciales_SGJ.php',
                                                                                                params:	{
                                                                                                			function:'4',
                                                                                                            idRegistroContenido:registro.data.idRegistroContenido,
                                                                                                            iD:registro.data.idDocumento
                                                                                                		}
                                                                                            }
                                                    									)
                                                }
    								)
  		
        
	tblGrid.getSelectionModel().on('rowdeselect',function(sm,nFila,registro)
    											{
                                                	gEx('gMetaData').getStore().removeAll();
                                                }
    								)        
          
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
                                    if((registro.data.etapaProcesal=='-1000')||(registro.data.eliminadoRepositorio=='1'))
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
                                                            autoLoad:false
                                                            
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
    
    if(gE('iframe-frameRegistroNotificaciones'))
    {
    	gEx('frameRegistroNotificaciones').getFrameWindow().recargarContenedorCentral();
    }
    
    if(gE('iframe-frameAccesoExpedientes'))
    {
    	gEx('frameAccesoExpedientes').getFrameWindow().recargarContenedorCentral();
    }

	
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
                                                        {name: 'audienciaVirtual'} ,
                                                        {name: 'urlVideoConferencia'}   
                                                        
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
                                                                width:110,
                                                                sortable:true,
                                                                dataIndex:'idEvento',
                                                                renderer:function(val)
                                                                		{
                                                                        	
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
                                                                width:190,
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
                                                                            
                                                                            	case '1':
                                                                                	if(registro.data.urlVideoConferencia!='')
                                                                                		comp2='<a href="javascript:abrirVideoConferencia(\''+bE(registro.data.urlVideoConferencia)+'\')"><img src="../images/user_go.png" title="Ingresar a Audiencia" alt="Ingresar a Audiencia" /></a>'
                                                                                break;
                                                                            	case '4':
                                                                                	if(registro.data.urlCanal!='')
                                                                                		comp2='<a href="javascript:abrirVentanaSala(\''+bE(registro.data.sala)+'\')"><img src="../images/film_go.png" title="Visualizar audiencia" alt="Visualizar audiencia" /></a>'
                                                                                break;
                                                                                case '2':
                                                                                	if(registro.data.urlMultimedia!='')
                                                                                    {
                                                                                    	if(registro.data.urlMultimedia.indexOf('sharepoint')==-1)
	                                                                                		comp2='<a href="javascript:abrirVideoGrabacion(\''+bE(registro.data.idEvento)+'\')"><img src="../images/control_play_blue.png" title="Visualizar grabaci&oacute;n" alt="Visualizar grabaci&oacute;n" /></a>'
                                                                              			else
                                                                                        	comp2='<a href="javascript:abrirVideoGrabacionTeams(\''+bE(registro.data.urlMultimedia)+'\')"><img src="../images/control_play_blue.png" title="Visualizar grabaci&oacute;n" alt="Visualizar grabaci&oacute;n" /></a>'
                                                                                	}
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
                                                                header:'Fecha de<br>la audiencia',
                                                                width:140,
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
                                                                header:'Sede',
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
                                                            
                                                            {
                                                                header:((tipoCarpetaAdministrativa=='2')||(tipoCarpetaAdministrativa=='3'))?'Magistrado':'Juez',
                                                                width:320,
                                                                sortable:true,
                                                                dataIndex:'juez',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	var etiqueta='';
                                                                            return etiqueta+val;
                                                                        	
                                                                        }
                                                            },
                                                            {
                                                                header:'URL Video Conferencia',
                                                                width:900,
                                                                align:'left',
                                                                sortable:true,
                                                                dataIndex:'urlVideoConferencia',
                                                                css:'text-align:left;vertical-align:middle !important;',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	if(registro.data.urlVideoConferencia!='')
	                                                                        	return '<a href="javascript:abrirVideoConferencia(\''+bE(val)+'\')">'+mostrarValorDescripcion(val)+'</a>';
                                                                        }
                                                            }
                                                            
                                                            
                                                            
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
                                                                cls:'gridSiugjPrincipal',
                                                                stripeRows :false,
                                                                loadMask:true,
                                                                columnLines : true,      
                                                                plugins:	[filters],
                                                                tbar:	[
                                                                			
                                                                            {
                                                                                icon:'../images/calendar_edit.jpg',
                                                                                cls:'x-btn-text-icon',
                                                                                id:'btnNewAudiencia',
                                                                                hidden:gE('sL').value=='1',
                                                                                text:'Programar Nueva Audiencia',
                                                                                handler:function()
                                                                                        {
                                                                                        	registrarNuevaSolicitudAudienciaPenalTradicional();
                                                                                            
                                                                                         	  
                                                                                        }
                                                                                
                                                                            },
                                                                            {
                                                                            	xtype:'tbspacer',
                                                                                width:30
                                                                            },
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
                                                                                                text: 'Modificar/Reprogramar Audiencia',
                                                                                                handler:function()
                                                                                                        {
                                                                                                        	
                                                                                                        	var fila;
                                                                                                            
                                                                                                            fila=gEx('gridAudiencias').getSelectionModel().getSelected();
                                                                                                        	
                                                                                                            var obj={};    
                                                                                                            obj.ancho='100%';
                                                                                                            obj.alto='100%';
                                                                                                            obj.url='../modulosEspeciales_SGJ/tblAgendaAudiencias.php';
                                                                                                            obj.params=[['idFormulario',185],['idRegistro',fila.data.iRegistro]	];
                                                                                                            abrirVentanaFancy(obj);
                                                                                                            return;
                                                                                                           
                                                                                                        }
                                                                                                
                                                                                            }
                                                                                            
                                                                                            
                                                                                            ,'-',
                                                                                            {
                                                                                            	id:'btnFinalizarAudiencia',
                                                                                                icon:formatearValorRenderer(arrSemaforo,'2'),
                                                                                                cls:'x-btn-text-icon',
                                                                                                disabled:true,
                                                                                                text:'Registrar Finalizaci&oacute;n de Audiencia',
                                                                                                handler:function()
                                                                                                        {
                                                                                                        	var fila;
                                                                                                            
                                                                                                            fila=gEx('gridAudiencias').getSelectionModel().getSelected();
                                                                                                            
                                                                                                            mostrarVentanaFinalizarAudiencia(fila);
                                                                                                        }
                                                                                                
                                                                                            },
                                                                                            
                                                                                            '-',
                                                                                            {
                                                                                            	id:'btnCancelarAudiencia',
                                                                                                icon:formatearValorRenderer(arrSemaforo,'3'),
                                                                                                cls:'x-btn-text-icon',
                                                                                                disabled:true,
                                                                                                text:'Suspender/Aplazar Audiencia',
                                                                                                handler:function()
                                                                                                        {
                                                                                                        	var fila;                                                                                                            
                                                                                                            fila=gEx('gridAudiencias').getSelectionModel().getSelected();                                                                                                            
                                                                                                            mostrarVentanaCancelarAudiencia(fila);
                                                                                                        }
                                                                                                
                                                                                            }
                                                                                            
                                                                                           
                                                                                            
                                                                                		]
                                                                                
                                                                            },
                                                                             {
                                                                            	xtype:'tbspacer',
                                                                                width:30
                                                                            },
                                                                            {
                                                                                icon:'../images/arrow_refresh.PNG',
                                                                                cls:'x-btn-text-icon',
                                                                                text:'Refrescar',
                                                                                handler:function()
                                                                                        {
                                                                                            gEx('gridAudiencias').getStore().reload();
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

var uploader;
	
function mostrarVentanaAgregarDocumento()
{
	var arrCarpeta=nodoCarpetaSel.id.split('_');
    var iCarpetaAdministrativa=arrCarpeta[1];
	var form = new Ext.form.FormPanel(	
										{

											layout:'absolute',
                                            cls:'panelSiugj',
											defaultType: 'label',
                                            tbar:	[
                                                        {
                                                            id:'btnSelect',	
                                                            icon:'../images/add.png',
                                                            cls:'x-btn-text-icon',
                                                            text: 'Seleccionar Documentos',                                                            
                                                            handler: function()
                                                                    {
                                                                        $('#uploader_container').click()
                                                                       
    
                                                                        
                                                                    }
                                                        },'-',
                                                        {
                                                            id:'btnStart',	
                                                            disabled:true,
                                                            icon:'../images/SignUp.gif',
                                                            cls:'x-btn-text-icon',
                                                            text: 'Iniciar Carga',                                                            
                                                            handler: function()
                                                                    {
                                                                        mostrarVentanaMetadaDataDocumentos();
                                                                        
                                                                        //uploader.start();
                                                                    }
                                                        },
                                                        '-',
                                                        {
                                                            id:'btnPause',	
                                                            icon:'../images/control_pause.png',
                                                            cls:'x-btn-text-icon',
                                                            text: 'Pausar',
                                                            disabled:true,                                                           
                                                            handler: function()
                                                                    {
                                                                        
                                                                       
                                                                        gEx('btnStart').enable();
                                                                        gEx('btnSelect').enable();
                                                                        gEx('btnPause').disable();
                                                                        uploader.stop();
                                                                        
                                                                    }
                                                        },
                                                        {
                                                            xtype:'label',
                                                            hidden:true,
                                                            html:'<a id="linkTest">Prueba 2</a>'
                                                        }
                                                    ],
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
										height:430,
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
                                                                	$("#uploader").pluploadQueue({
                                    
                                                                                                            runtimes : 'html5,flash,silverlight,html4',
                                                                                                            browse_button:'linkTest',
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
                                                                                                                		Init:function(up) 
                                                                                                                          {
                                                                                                                                uploader=up;
                                                                                                                                
                                                                                                                            
                                                                                                                          },
                                                                                                                        UploadFile:function(up,archivos)
                                                                                                                                        {
                                                                                                                                        	gEx('btnPause').enable();
                                                                                                                                            gEx('btnStart').disable();
                                                                                                                                            gEx('btnSelect').disable();
                                                                                                                                           
                                                                                                                                        },
                                                                                                                        UploadComplete:function(up,archivos)
                                                                                                                                        {
                                                                                                                                        	gEx('btnStart').disable();
                                                                                                                                            gEx('btnSelect').enable();
                                                                                                                                            gEx('btnPause').disable();
                                                                                                                                            gEx('gridCarpetaAdministrativa').getStore().reload();
                                                                                                                                        },
                                                                                                                        FileUploaded:function(up,archivos,response)
                                                                                                                                        {
                                                                                                                                            var arrResp=response.response.split('|');
                                                                                                                                            if(arrResp[0]=='1')
                                                                                                                                            {
                                                                                                                                                var idArchivo=archivos.id;
                                                                                                                                                var pos=existeValorArregloObjetos(arrObjetosMetaData,'idDocumento',idArchivo);
                                                                                                                                                
                                                                                                                                                var fila;
                                                                                                                                                var objRegistro=arrObjetosMetaData[pos];
                                                                                                                                                var x;
                                                                                                                                                var objMetada='';
                                                                                                                                                var valor='';
                                                                                                                                                var valorEtiqueta=''
                                                                                                                                                var arrMetaDataArchivo='';
                                                                                                                                                var tipoDocumental='';
                                                                                                                                                for(x=0;x<objRegistro.metaData.length;x++)
                                                                                                                                                {
                                                                                                                                                	valorEtiqueta='';
                                                                                                                                                    fila=objRegistro.metaData[x];
                                                                                                                                                    valor=fila.data.valor;
                                                                                                                                                    
                                                                                                                                                    if((fila.data.tipoEntrada=='5')&&(valor.format))
                                                                                                                                                    {
                                                                                                                                                        valor=valor.format('Y-m-d');
                                                                                                                                                        
                                                                                                                                                    }
                                                                                                                                                    
                                                                                                                                                    if(fila.data.arrOpciones.length>0)
                                                                                                                                                    {
                                                                                                                                                        valorEtiqueta=formatearValorRenderer(fila.data.arrOpciones,fila.data.valor);
                                                                                                                                                    }
                                                                                                                                                    
                                                                                                                                                    if(fila.data.idPropiedad=='0')
                                                                                                                                                    {
                                                                                                                                                        tipoDocumental=valor;
                                                                                                                                                    }
                                                                                                                                                    
                                                                                                                                                    if(valorEtiqueta=='')
                                                                                                                                                        valorEtiqueta=valor;
                                                                                                                                                    objMetada='{"idPropiedad":"'+fila.data.idPropiedad+'","tipoEntrada":"'+fila.data.tipoEntrada+
                                                                                                                                                            '","valor":"'+cv(valor)+'","valorEtiqueta":"'+cv(valorEtiqueta)+'"}';
                                                                                                                                                    if(arrMetaDataArchivo=='')
                                                                                                                                                        arrMetaDataArchivo=objMetada;
                                                                                                                                                    else
                                                                                                                                                        arrMetaDataArchivo+=','+objMetada;
                                                                                                                                                }
                                                                                                                                                
                                                                                                                                                var cadObj='{"idDocumento":"'+arrResp[1]+'","tipoDocumental":"'+tipoDocumental+
                                                                                                                                                			'","metaDatos":['+arrMetaDataArchivo+'],"carpetaAdministrativa":"<?php echo cv($carpetaAdministrativa)
																																							?>","idCarpetaAdministrativa":"<?php echo $idCarpetaAdministrativa?>"}';
                                                                                                                                                
                                                                                                                                                
                                                                                                                                                function funcAjax(peticion_http)
                                                                                                                                                {
                                                                                                                                                    var resp=peticion_http.responseText;
                                                                                                                                                    arrResp=resp.split('|');
                                                                                                                                                    if(arrResp[0]=='1')
                                                                                                                                                    {
                                                                                                                                                        up.removeFile(archivos);
                                                                                                                                                        if(up.files.length==0)
                                                                                                                                                        {
                                                                                                                                                            gEx('btnPause').disable();
                                                                                                                                                            gEx('btnStart').disable();
                                                                                                                                                            gEx('btnSelect').enable();
                                                                                                                                                        }
                                                                                                                                                    }
                                                                                                                                                    else
                                                                                                                                                    {
                                                                                                                                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                                                                    }
                                                                                                                                                }
                                                                                                                                                obtenerDatosWebV2('../modulosEspeciales_SGJ/paginasFunciones/funcionesModulosEspeciales_SGJ.php',funcAjax, 'POST','funcion=33&cadObj='+cadObj,true);
                                                                                                                                                    
                                                                                                                                                
                                                                                                                                            }
                                                                                                                                        }
                                                                                                                    },
                                                                                                            filters : 	{
                                                                                                                            // Maximum file size
                                                                                                                            max_file_size : '512mb',
                                                                                                                            // Specify what files to browse for
                                                                                                                            mime_types: [
                                                                                                                                            {title : "Archivos de audio", extensions : "mp3,wav,ogg"},
                                                                                                                                            {title : "Archivos de video", extensions : "mp4,avi,3gp,flv,mov,mpg,mpeg"},
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
                                                                        
                                                                	
                                                                                                          
                                                                                                          
                                                                }
															}
												},
										buttons:	[
                                        				
														{
															text: 'Cerrar',
                                                            cls:'btnSIUGJCancel',
                                                            width:140,
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
                                                                    mD:1,
                                                                    iCarpeta:gE('idCarpetaAdministrativa').value,
                                                                    cA:bE(gE('carpetaAdministrativa').value)
                                                                },
                                                    dataUrl:'../paginasFunciones/funcionesModulosEspeciales_SGP.php'
                                                }
                                            )		
										
	
    cargadorArbol.on('load',function(l,raiz)
    						{
                            	gEx('btnAddCuadernillo').disable();
                                gEx('btnModifyCuadernillo').disable();
                                gEx('btnDeleteCuadernillo').disable();
                            	nodoCarpetaSel=buscarNodoID(raiz.childNodes[0],gE('carpetaAdministrativa').value+'_'+gE('idCarpetaAdministrativa').value);
                                nodoCarpetaSel.select();
                            	funcClickCarpetaJudicial(nodoCarpetaSel);
                            }
    				)
    											
										
	var arbolCarpetas=new Ext.tree.TreePanel	(
                                                            {
                                                                
                                                                id:'arbolCarpetas',
                                                                region:'center',
                                                                cls:'treeVistaExpedienteUsuario',
                                                                useArrows:true,
                                                                animate:true,
                                                                width:280,
                                                                title:'<?php echo $lblExpedientesAsociados?>',
                                                                cls:'gridSiugjVistaExpedienteUsuario gridSiugjVistaExpedienteUsuarioExpediente',
                                                                enableDD: gE('sL').value=='0',
                                                            	ddGroup:'grupoDrop',
                                                                ddScroll:true,
                                                                containerScroll: true,
                                                                autoScroll:true,
                                                                border:false,
                                                                root:raiz,
                                                                dropConfig:	{
                                                                				appendOnly:true,
                                                                                ddGroup:'grupoDrop',
                                                                                allowContainerDrop:false,
                                                                                 
                                                                                onContainerOver:function( source, e, data )
                                                                                				{
                                                                                                	return this.dropNotAllowed;
                                                                                                },
                                                                                onNodeOver:function( nodeData,source, e, data )
                                                                                				{
                                                                                                	
                                                                                                	if(source.tree)
                                                                                                	{
                                                                                                    
                                                                                                        if(data.node.id==(gE('carpetaAdministrativa').value+'_'+gE('idCarpetaAdministrativa').value))
                                                                                                        {
                                                                                                            return this.dropNotAllowed;
                                                                                                        }
                                                                                                    
                                                                                                    	if(nodeData.node.id==data.node.id)
                                                                                                        {
                                                                                                        	return this.dropNotAllowed;
                                                                                                        }
                                                                                                    	if((typeof(nodeData.node.attributes.sL)!='undefined')&&(nodeData.node.attributes.sL=='0'))
                                                                                                        {
                                                                                                        	return this.dropAllowed;
                                                                                                        }
                                                                                                        else
                                                                                                        	return this.dropNotAllowed;
                                                                                                    
                                                                                                    	var nodoEnc=buscarNodoID(data.node,nodeData.node.id);
                                                                                                        if(nodoEnc)
                                                                                                        	return this.dropNotAllowed;
                                                                                                    
                                                                                                    }
                                                                                                    else
                                                                                                    {
                                                                                                        if((typeof(nodeData.node.attributes.sL)!='undefined')&&(nodeData.node.attributes.sL=='0'))
                                                                                                            return this.dropAllowed;
                                                                                                        else
                                                                                                        {
                                                                                                            if(nodeData.node.id==(gE('carpetaAdministrativa').value+'_'+gE('idCarpetaAdministrativa').value))
                                                                                                            {
                                                                                                                return this.dropAllowed;
                                                                                                            }
                                                                                                        }
                                                                                                        return this.dropNotAllowed;
                                                                                                    }
                                                                                                    return this.dropNotAllowed;
                                                                                                },
                                                                                                
                                                                                onNodeDrop:function( nodeData,source, e, data )
                                                                                				{
                                                                                                	if(!data.node)
                                                                                                    {
                                                                                                        if((nodeData.node.id==gE('carpetaAdministrativa').value+'_'+gE('idCarpetaAdministrativa').value)&&(gE('sL').value=='0'))
                                                                                                        {
                                                                                                        
                                                                                                        }
                                                                                                        else
                                                                                                        {
            
                                                                                                            if(	
                                                                                                                (typeof(nodeData.node.attributes.sL)=='undefined')||(nodeData.node.attributes.sL=='1')
                                                                                                                
                                                                                                              )
                                                                                                            {
                                                                                                                
                                                                                                                return false;
                                                                                                            }
                                                                                                        }
                                                                                                    }
                                                                                                    else
                                                                                                    {
                                                                                                    	if(data.node.id==(gE('carpetaAdministrativa').value+'_'+gE('idCarpetaAdministrativa').value))
                                                                                                        {
                                                                                                            return false;
                                                                                                        }
                                                                                                    	if(nodeData.node.id==data.node.id)
                                                                                                        {
                                                                                                        	return false;
                                                                                                        }
                                                                                                        
                                                                                                        
                                                                                                        if(	
                                                                                                              (typeof(nodeData.node.attributes.sL)=='undefined')||(nodeData.node.attributes.sL=='1')
                                                                                                              
                                                                                                            )
                                                                                                          {
                                                                                                              
                                                                                                              return false;
                                                                                                          }
                                                                                                        
                                                                                                        var nodoEnc=buscarNodoID(data.node,nodeData.node.id);
                                                                                                        if(nodoEnc)
                                                                                                        	return false;
                                                                                                        
                                                                                                    }
                                                                                                   /* if((!nodeData.node.attributes.tipoRelacion)||(nodeData.node.attributes.tipoRelacion!='6'))
                                                                                                    {
                                                                                                    	return false;
                                                                                                    }*/
                                                                                                	                                                                                               
                                                                                                	mostrarVentanaMovimientoElemento(nodeData.node,data)
                                                                                                	
                                                                                                    
                                                                                                }                
                                                                			},
                                                                tbar:	[
                                                                			new Ext.Toolbar	(
                                                                            			
                                                                            					{
                                                                                                	buttonAlign:'center',
                                                                                                	items:	[
                                                                                                                {
                                                                                                                    hidden:gE('sL').value=='1',
                                                                                                                    text:'Acciones',
                                                                                                                    width:290,
                                                                                                                    cls:'btnMenuEspecialExpediente',
                                                                                                                    menu:	[
                                                                                                                                {
                                                                                                                                    icon:'../images/book_spelling.png',
                                                                                                                                    cls:'x-btn-text-icon',
                                                                                                                                    text:'Exportar Indice Electr&oacute;nico...',
                                                                                                                                    menu:	[
                                                                                                                                                {
                                                                                                                                                    cls:'x-btn-text-icon',
                                                                                                                                                    text:'Formato PDF',
                                                                                                                                                    handler:function()
                                                                                                                                                            {
                                                                                                                                                                 exportarIndiceElectronico(1);
                                                                                                                                                            }
                                                                                                                                                    
                                                                                                                                                },
                                                                                                                                                {
                                                                                                                                                    cls:'x-btn-text-icon',
                                                                                                                                                    text:'Formato XML',
                                                                                                                                                    handler:function()
                                                                                                                                                            {
                                                                                                                                                                 exportarIndiceElectronico(2);
                                                                                                                                                            }
                                                                                                                                                    
                                                                                                                                                },
                                                                                                                                                
                                                                                                                                                {
                                                                                                                                                    cls:'x-btn-text-icon',
                                                                                                                                                    text:'Formato JSON',
                                                                                                                                                    handler:function()
                                                                                                                                                            {
                                                                                                                                                                 exportarIndiceElectronico(3);
                                                                                                                                                            }
                                                                                                                                                    
                                                                                                                                                }
                                                                                                                                                
                                                                                                                                            ]
                                                                                                                                    
                                                                                                                                    
                                                                                                                                }  
                                                                                                                                ,
                                                                                                                                {
                                                                                                                                    icon:'../images/script_go.png',
                                                                                                                                    cls:'x-btn-text-icon',
                                                                                                                                    text:'Exportar Expediente Electr&oacute;nico (XML)',
                                                                                                                                    handler:function()
                                                                                                                                            {
                                                                                                                                                var arrParametros=[['cA',gE('carpetaAdministrativa').value],['idCarpeta',gE('idCarpetaAdministrativa').value],['formato','1']];
                                                                                                                                                enviarFormularioDatos('../modulosEspeciales_SIUGJ/exportarExpedienteElectronico.php',arrParametros,'POST');
                                                                                                                                                primeraCargaFrame=false;
                                                                                                                                                 //mostrarVentanaExportacionExpediente();
                                                                                                                                            }
                                                                                                                                    
                                                                                                                                },
                                                                                                                                {
                                                                                                                                    icon:'../images/add.png',
                                                                                                                                    cls:'x-btn-text-icon',
                                                                                                                                    id:'btnAddCuadernillo',
                                                                                                                                    text:'Crear Cuadernillo',
                                                                                                                                    handler:function()
                                                                                                                                            {
                                                                                                                                                if((nodoCarpetaSel.attributes.tipoCarpeta)&&(nodoCarpetaSel.attributes.tipoCarpeta=='11'))
                                                                                                                                                {
                                                                                                                                                    msgBox('No se permite la creaci&oacute;n de un segundo nivel de cuadernillo');
                                                                                                                                                    return;
                                                                                                                                                }
                                                                                                                                                mostrarVentanaCrearCuadernillo();
                                                                                                                                            }
                                                                                                                                    
                                                                                                                                },
                                                                                                                                {
                                                                                                                                    icon:'../images/pencil.png',
                                                                                                                                    cls:'x-btn-text-icon',
                                                                                                                                    id:'btnModifyCuadernillo',
                                                                                                                                    text:'Modificar Cuadernillo',
                                                                                                                                    handler:function()
                                                                                                                                            {
                                                                                                                                               mostrarVentanaCrearCuadernillo(nodoCarpetaSel);
                                                                                                                                            }
                                                                                                                                    
                                                                                                                                },
                                                                                                                                {
                                                                                                                                    icon:'../images/delete.png',
                                                                                                                                    cls:'x-btn-text-icon',
                                                                                                                                    id:'btnDeleteCuadernillo',
                                                                                                                                    text:'Remover Cuadernillo',
                                                                                                                                    handler:function()
                                                                                                                                            {
                                                                                                                                                var arrCarpeta=nodoCarpetaSel.id.split('_');
                                                                                                                                            
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
                                                                                                                                                                gEx('arbolCarpetas').getRootNode().reload();
                                                                                                                                                                
                                                                                                                                                            }
                                                                                                                                                            else
                                                                                                                                                            {
                                                                                                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                                                                            }
                                                                                                                                                        }
                                                                                                                                                        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=404&iC='+arrCarpeta[1],true);
                                                                                                                                                    }
                                                                                                                                                }	
                                                                                         msgConfirm('¿Est&aacute; seguro de querer remover el cuadernillo seleccionado?',resp);
                                                                                                                                               
                                                                                                                                            }
                                                                                                                                    
                                                                                                                                },
                                                                                                                                '-',
                                    
                                                                                                                                {
                                                                                                                                    icon:'../images/page_white_magnify.png',
                                                                                                                                    cls:'x-btn-text-icon',
                                                                                                                                    id:'btnAuditoria',
                                                                                                                                    text:'Auditoria...',
                                                                                                                                    handler:function()
                                                                                                                                            {
                                                                                                                                                mostrarVentanaRegistrosExpediente();
                                                                                                                                            }
                                                                                                                                    
                                                                                                                                }
                                                                                                                            ]
                                                                                                                    
                                                                                                                }
                                                                											]
                                                                                                }
                                                                                             )
                                                                        ]
                                                                        ,
                                                                

                                                                loader: cargadorArbol,
                                                                rootVisible:false
                                                            }
                                                        )
         
         
                                                    
	arbolCarpetas.on('click',funcClickCarpetaJudicial);	                                                    
                                                    
	return  arbolCarpetas;
}

function scanCorrectoDocument(idDocumento,nombreDocumento)
{
	cerrarVentanaFancy();
	var arrCarpeta=nodoCarpetaSel.id.split('_');
    var iCarpetaAdministrativa=<?php echo  $registrarIDCarpeta?"arrCarpeta[1]":"-1"?>;
    
    
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            
    		gEx('gridCarpetaAdministrativa').getStore().reload();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=400&cA='+arrCarpeta[0]+
    				'&iC='+iCarpetaAdministrativa+'&n='+nombreDocumento+'&iD='+idDocumento,true);
    
    
	
}

function funcClickCarpetaJudicial(nodo, evento)
{
	lblCarpeta='';
    
    if(nodo.attributes.tipoCarpeta=='10')
    {
    	if(nodoCarpetaSel)
        {
        	setTimeout(function()
            			{                                                                                                       								
					    	nodoCarpetaSel.select();
                        },500
                      )
    	}
        return;
    }
    
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
    
	gEx('btnAdjuntar').enable();
    gEx('btnScanDocumento').enable();
    gEx('btnAddCuadernillo').enable();
    arrDatosCarpeta=nodoCarpetaSel.id.split('_');
    if(arrDatosCarpeta[0]!=gE('carpetaAdministrativa').value)
    {
    	gEx('btnAdjuntar').disable();
    	gEx('btnScanDocumento').disable();
        gEx('btnAddCuadernillo').disable();
    }
    
    if((nodoCarpetaSel.attributes.sL)&&(nodoCarpetaSel.attributes.sL=='0')&&(nodoCarpetaSel.attributes.tipoCarpeta=='10'))
    {
    	gEx('btnAddCuadernillo').enable();
    }
    
    if((nodoCarpetaSel.attributes.sL)&&(nodoCarpetaSel.attributes.sL=='0')&&(nodoCarpetaSel.attributes.tipoCarpeta=='11'))
    {
    	gEx('btnModifyCuadernillo').enable();
        gEx('btnDeleteCuadernillo').enable();
        gEx('btnAdjuntar').enable();
    	gEx('btnScanDocumento').enable();
    }
    

    gEx('gridCarpetaAdministrativa').getStore().reload();
    gEx('gridAudiencias').getStore().reload();
    gEx('gMetaDataProceso').getStore().reload();
    if(gE('iframe-frameRegistroNotificaciones'))
    {
        gEx('frameRegistroNotificaciones').load	(
                                                    {
                                                        scripts:true,
                                                        url:'../modeloProyectos/visorRegistrosProcesosV2.php',
                                                        params:	{
                                                                    cPagina: 'sFrm=true',
                                                                    idProceso: 274,
                                                                    pantallaCompleta:'1',
                                                                    idFormulario: -1,
                                                                    parametrosProceso:bE('{"carpetaAdministrativa":"'+nodoCarpetaSel.id.split('_')[0]+'"}'),
                                                                    contentIframe:0
                                                                }
                                                   }
                                                )
    
    }
    

    
}

function removerDocumento(iD)
{
	var arrCarpeta=nodoCarpetaSel.id.split('_');
    var cAdministrativa=arrCarpeta[0];
    var iCarpetaAdministrativa=<?php echo  $registrarIDCarpeta?"arrCarpeta[1]":"-1"?>;
    
    
    if((nodoCarpetaSel.attributes.tipoRelacion)&&(nodoCarpetaSel.attributes.tipoRelacion=='6'))
    {
    	iCarpetaAdministrativa=arrCarpeta[1];
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
                                                                                obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=56&iC='+iCarpetaAdministrativa+'&motivo='+cv(txtMotivo.getValue())+'&cA='+cAdministrativa+'&iD='+bD(iD),true);
                                                                                
                                                                            
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
            obj.modal=true;
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
            obj.modal=true;
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
            obj.modal=true;
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
    obj.funcionCerrar=function()
    				{	
                    	gEx('gridAudiencias').getStore().reload();
                    }
    obj.url='../modulosEspeciales_SIUGJ/tableroAudiencia.php';
    obj.params=[['idEventoAudiencia',bD(iE)],['idActividad',gE('idActividad').value]];    

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

function abrirVideoGrabacionTeams(url)
{
	var winFeatures = 'screenX=0,screenY=0,top=0,left=0,scrollbars,width=100,height=100';
    var winName = 'window';
    var win = window.open(bD(url),winName, winFeatures); 
    var extraWidth = win.screen.availWidth - win.outerWidth;
    var extraHeight = win.screen.availHeight - win.outerHeight;
    win.resizeBy(extraWidth, extraHeight);
    
    var timer = setInterval(function() { 
                                            if(win.closed) 
                                            {
                                                clearInterval(timer);
                                                
                                            }
                                        }, 1000);
    
    return win;
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
                                                width:40,
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
                                                            new  Ext.grid.RowNumberer({width:40}),
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
                                                                width:170,
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
                                                                cls:'gridSiugjPrincipal',
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
                                                                                                        functionAfterSignDocument:function()
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
                        functionAfterSignDocument:function()
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
                                                                header:'Situaci&oacute;n',
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
																			msgBox('Debe indicar al menos un imputado cuyo status desea modificar',respAux2);
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


function crearPanelNotificacionesDia()
{
	
	var panel= new Ext.Panel(	{
                                    xtype:'panel',
                                    cls:'panelSiugj',
                                    id:'panelNotificaciones',
                                    title:'Alertas/Notificaciones',
                                    layout:'border',
                                    listeners:	{
                                                  activate:function(p)
                                                          {
                                                             	setTimeout(function()
                                                                		{
                                                                        	var cmbStatusAlertas=crearComboExt('cmbStatusAlertas',arrStatusAlertaCombo,0,0,200,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'spStatusNotificacion'});
                                                                            cmbStatusAlertas.setValue('1,4');
                                                                            cmbStatusAlertas.on('select',recargarGridAlertas);
                                                                        
                                                                        	
                                                                            new Ext.form.DateField	(
                                                                                                        {
                                                                                                            
                                                                                                            id:'txtFechaInicio',
                                                                                                            ctCls:'campoFechaSIUGJ',
                                                                                                            renderTo:'spFechaInicio',
                                                                                                            listeners:  {
                                                                                                                            select:recargarGridAlertas
                                                                                                                        },
                                                                                                            value:minFechaAlerta
                                                                                                        }
                                                                                                    )
                                                                        	new Ext.form.DateField	(
                                                                                                    {
                                                                                                        
                                                                                                        id:'txtFechaFin',
                                                                                                        ctCls:'campoFechaSIUGJ',
                                                                                                        renderTo:'spFechaFin',
                                                                                                        listeners:  {
                                                                                                                        select:recargarGridAlertas
                                                                                                                    },
                                                                                                        value:maxFechaAlerta
                                                                                                    }
                                                                                                 )
                                                                        
                                                                        	recargarGridAlertas();
                                                                        },100);
                                                                        
                                                                        
                                                                        
                                                                        
                                                          }
                                              },
                                    tbar:	[
                                                {
                                                    html:'<div class="letraNombreTableroNegro">Alertas/notificaciones del:&nbsp;&nbsp;</div>'
                                                },
                                                
                                                 {
                                                    xtype:'tbspacer',
                                                    width:15
                                                  },
                                                  {
                                                    xtype:'label',
                                                    html:'<div id="spFechaInicio"></div>'
                                                },
                                                {
                                                    xtype:'tbspacer',
                                                    width:15
                                                  },
                                                {
                                                    html:'<div class="letraNombreTableroNegro">al</div>'
                                                },
                                                 {
                                                    xtype:'tbspacer',
                                                    width:15
                                                  },
                                                  {
                                                    xtype:'label',
                                                    html:'<div id="spFechaFin"></div>'
                                                },
                                                
                                                 {
                                                    xtype:'tbspacer',
                                                    width:15
                                                  },
                                                {
                                                    xtype:'label',
                                                    html:'<div id="spStatusNotificacion"></div>'
                                                }
                                            ],
                                    items:	[
                                                crearGridNotificacionesDia()
                                            ]
                                }
                          )
    
	return panel;
            
                                                                                                            
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
                                                        {name: 'recordarPreviamente'},
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
                                                            autoLoad:false
                                                            
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
                                                            new  Ext.grid.RowNumberer({width:40}),
                                                            
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
                                                                width:180,
                                                                sortable:true,
                                                                dataIndex:'fechaAlerta',
                                                                renderer:function(val)
                                                                		{
                                                                			return val.format('d/m/Y');
                                                                		}
                                                            },
                                                            {
                                                                header:'Recordar desde',
                                                                width:180,
                                                                sortable:true,
                                                                dataIndex:'recordarPreviamente',
                                                                renderer:function(val)
                                                                		{
                                                                			return val;
                                                                		}
                                                            },
                                                            {
                                                                header:'Proceso Judicial',
                                                                width:260,
                                                                hidden:true,
                                                                sortable:true,
                                                                dataIndex:'carpetaAdministrativa'
                                                                
                                                            },
                                                            {
                                                                header:'Fecha de registro',
                                                                width:180,
                                                                
                                                                sortable:true,
                                                                dataIndex:'fechaRegistro',
                                                                renderer:function(val)
                                                                		{
                                                                			return val.format('d/m/Y H:i:s');
                                                                		}
                                                            },
                                                            {
                                                                header:'Registrado por',
                                                                width:350,
                                                                sortable:true,
                                                                dataIndex:'responsableRegistro'
                                                            },
                                                             {
                                                                header:'Status alerta',
                                                                width:190,
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
                                                                region:'center',
                                                                frame:false,
                                                                cm: cModelo,
                                                                stripeRows :true,
                                                                loadMask:true,
                                                                cls:'gridSiugjPrincipal',
                                                                columnLines : true,                                                                 
                                                                tbar: 	[
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
                                                               				 {
                                                                                xtype:'tbspacer',
                                                                                width:15
                                                                              },
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
                                                               				 {
                                                                                xtype:'tbspacer',
                                                                                width:15
                                                                              },
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
                                            				y:20,
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
										width: 600,
										height:280,
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
																	gEx('txtComentariosAdicionales').focus(false,500);
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
                                            				y:20,
                                                            cls:'SIUGJ_Etiqueta',
                                            				html:'Motivo de la cancelaci&oacute;n:'
                                            				
                                            			},
                                            			{
                                            				xtype:'textarea',
                                            				x:10,
                                            				y:50,
                                            				width:550,
                                            				height:100,
                                                            cls:'controlSIUGJ',
                                            				id:'txtMotivoCancelacionAlerta'
                                            			}
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Cancelar alerta/notificaci&oacute;n',
										width: 600,
										height:280,
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
																	gEx('txtMotivoCancelacionAlerta').focus(false,500);
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
														}
														
													]
									}
								);
	ventanaAM.show();	
}

function mostrarVentanaCrearAlerta()
{
	
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                            				x:10,
                                                            cls:'SIUGJ_Etiqueta',
                                            				y:20,
                                            				html:'Fecha de alerta/notificaci&oacute;n:'
                                            			},
                                            			{
                                                        	x:270,
                                                            y:15,
                                                            html:'<div id="spFechaAlerta" style="width:140px"></div>'
                                                        },
                                                        {
                                            				x:460,
                                            				y:20,
                                                            cls:'SIUGJ_Etiqueta',
                                            				html:'Recordar (D&iacute;as antes):'
                                            			},
                                                        {
                                                        	x:660,
                                                            y:15,
                                                            cls:'controlSIUGJ',
                                                            xtype:'numberfield',
                                                            width:50,
                                                            value:0,
                                                            allowDecimals:false,
                                                            allowNegative:false,
                                                            id:'txtNumDias'
                                                        },
                                                        
                                            			{
                                            				x:10,
                                            				y:70,
                                                            cls:'SIUGJ_Etiqueta',
                                            				html:'Comentario de alerta/notificaci&oacute;n:'
                                            			},
                                            			{
                                            				x:10,
                                            				y:100,
                                            				width:700,
                                            				xtype:'textarea',
                                            				height:80,
                                                            cls:'controlSIUGJ',
                                            				id:'txtComentarioAlerta'
                                            			},
                                            			{
                                            				x:10,
                                            				y:200,
                                                            cls:'SIUGJ_Etiqueta',
                                            				html:'&Aacute;mbito de alerta/notificaci&oacute;n:'
                                            			},
                                            			{
                                                        	x:320,
                                                            y:195,
                                                            html:'<div id="spAmbitoAlerta"></div>'
                                                        },
                                                        
                                            			{
                                            				x:10,
                                            				y:250,
                                                            cls:'SIUGJ_Etiqueta',
                                            				html:'Tipo de alerta/notificaci&oacute;n:'
                                            			},
                                                        {
                                                        	x:320,
                                                            y:245,
                                                            html:'<div id="spTipoAlerta"></div>'
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Crear alerta/notificaci&oacute;n',
										width: 750,
										height:420,
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
                                                                	
                                                                    
                                                                    new Ext.form.DateField (
                                                                    							{
                                                                                                   	width:130,
                                                                                                    xtype:'datefield',
                                                                                                    ctCls:'campoFechaSIUGJ',
                                                                                                    value:'<?php echo $fechaActual?>',
                                                                                                    id:'dteFechaAlerta',
                                                                                                    renderTo:'spFechaAlerta'
                                                                                                }
                                                                    						)
                                                                                            
                                                                                            
                                                                                            
                                                                 	var cmbTipoAlerta=crearComboExt('cmbTipoAlerta',[['1','General'],['2','Personal']],0,0,250,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'spAmbitoAlerta'});
																	var cmbTipoNotificacion=crearComboExt('cmbTipoNotificacion',arrTipoNotificaciones,0,0,300,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'spTipoAlerta'});                           
                                                                    
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
																		var dteFechaAlerta=gEx('dteFechaAlerta');
																		var txtComentarioAlerta=gEx('txtComentarioAlerta');
                                                                        var cmbTipoAlerta=gEx('cmbTipoAlerta');
                                                                        var cmbTipoNotificacion=gEx('cmbTipoNotificacion');
                                                                        
                                                                        
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
																			msgBox('Debe ingresar el &aacute;mbito de la alerta/notificaci&oacute;n',resp3);
																			return;
																		}
																		
                                                                        var txtNumDias=gEx('txtNumDias');
                                                                        
                                                                        if(txtNumDias.getValue()==='')
																		{
																			function resp30()
																			{
																				txtNumDias.focus();
																			}
																			msgBox('Debe ingresar el n&uacute;mero de dias con anticipaci&oacute;n que debe recordarse la alerta/notificaci&oacute;n',resp30);
																			return;
																		}
                                                                        
                                                                        if(cmbTipoNotificacion.getValue()=='')
																		{
																			function resp31()
																			{
																				cmbTipoNotificacion.focus();
																			}
																			msgBox('Debe ingresar el tipo de alerta/notificaci&oacute;n a programar',resp31);
																			return;
																		}
                                                                        
																		var cadObj='{"carpetaAdministrativa":"'+gE('carpetaAdministrativa').value+
																				'","fechaAlerta":"'+dteFechaAlerta.getValue().format('Y-m-d')+
																				'","comentarios":"'+cv(txtComentarioAlerta.getValue())+
																				'","tipoAlerta":"'+cmbTipoAlerta.getValue()+'","categoriaAlerta":"'+
                                                                                cmbTipoNotificacion.getValue()+'","diasRecordatorios":"'+txtNumDias.getValue()+'"}';
																		
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
                                    functionAfterSignDocument:function()
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
	tipoParticipante='0';
	var panel= new Ext.Panel	(
    								{
                                    	layout:'border',
                                        id:'panelPartes_C',
                                        listeners:	{
                                                        activate:function(p)
                                                                {
                                                                	                                            
                                                                    if(!p.visualizado)
                                                                    {
                                                                        
                                                                        p.visualizado=1;
                                                                        gEx('tblPersona_C').setActiveTab(1);
                                                                        gEx('tblPersona_C').setActiveTab(2);
                                                                        gEx('tblPersona_C').setActiveTab(3);
                                                                        gEx('tblPersona_C').setActiveTab(0);
                                                                        
                                                                        new Ext.form.DateField	(
                                                                                                    {
                                                                                                        renderTo:'dteFechaDocumento_C',
                                                                                                        width:130,
                                                                                                        id:'fechaIdentificacion_C',
                                                                                                        maxValue:'<?php echo date("Y-m-d")?>',
                                                                                                        ctCls:'campoFechaSIUGJ'
                                                                                                    }
                                                                                                )
                                                                        
                                                                    
                                                                    	var cmbTipoPersona=crearComboExt('cmbTipoPersona_C',[],0,0,180,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divTipoPersona_C'});
                                                                    
                                                                    
                                                                        cmbTipoPersona.on('select',function(cmb,registro)
                                                                                                    {
                                                                                                        tipoPersonaComboCP_C(cmb,registro);
                                                                                                    }
                                                                                        )
                                                                        
                                                                        
                                                                        var cmbIdentificacion=crearComboExt('cmbIdentificacion_C',[],0,0,310,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboIdentificacion_C'});
                                                                        cmbIdentificacion.on('select',function(cmb,registro)					
                                                                                                        {
                                                                                                        
                                                                                                            var pos=existeValorMatriz(arrTipoIdentificacionConfiguracion,registro.data.id);
                                                                                                            
                                                                                                            var fila=arrTipoIdentificacionConfiguracion[pos];
                                                                                                            
                                                                                                            
                                                                                                            if(fila[7]=='1')
                                                                                                            {
                                                                                                                gEx('lblFechaExpedicion_C').show();
                                                                                                                gEx('divFechaDocumento_C').show();
                                                                                                                
                                                                                                                
                                                                                                                gEx('lblValFechaExpedicion_C').show();
                                                                                                                    
                                                                                                            }
                                                                                                            else
                                                                                                            {
                                                                                                                gEx('lblFechaExpedicion_C').hide();
                                                                                                                gEx('divFechaDocumento_C').hide();
                                                                                                                gEx('lblValFechaExpedicion_C').hide();	
                                                                                                            }
                                                                                                            
                                                                                                            gEx('txtEspecifique_C').setValue('');
                                                                                                            gEx('txtEspecifique_C').ultimaValidacion='';
                                                                                                            gEx('txtEspecifique_C').ultimaBusqueda='';
                                                                                                            
                                                                                                            if(fila[3]!='')
                                                                                                            {
                                                                                                                eval(fila[3]+'('+registro.data.id+',registro);');
                                                                                                            }
                                                                                                            
                                                                                                        }
                                                                                                )
                                                                    
                                                                    
                                                                    	var cmbTipoEntidad=crearComboExt('cmbTipoEntidad_C',arrTipoEntidad,0,0,220,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboTipoEntidad_C'});
                                                                        cmbTipoEntidad.setValue('2');
                                                                        gEx('tblPersona_C').setActiveTab(1);
                                                                        
                                                                        var cmbGenero=crearComboExt('cmbGenero_C',arrGeneroCP,0,0,180,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboGenero_C'});
                                                                        var cmbGrupoEtnico=crearComboExt('cmbGrupoEtnico_C',arrGrupoEtnico,0,0,180,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divGrupoEtnico_C'});  
                                                                        var cmbDiscapacidad=crearComboExt('cmbDiscapacidad_C',arrDiscapacidad,0,0,250,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divDiscapacidad_C'});  
                                                                        new Ext.form.DateField	( {
                                                                                  
                                                                                                      renderTo:'divComboFecha_C',
                                                                                                      width:130,
                                                                                                      ctCls:'campoFechaSIUGJ',
                                                                                                      xtype:'datefield',
                                                                                                      id:'fechaNacimiento_C',
                                                                                                      maxValue:'<?php echo date("Y-m-d")?>',
                                                                                                      listeners:	{
                                                                                                                      change:function(dte)
                                                                                                                              {
                                                                                                                                  var edad=calcularEdadParticipante(dte.getValue());
                                                                                                                                  gEx('txtEdad_C').setValue(edad);
                                                                                                                              }
                                                                                                                  }
                                                                                                  }
                                                                                                 )
                                                                         
                                                                        gEx('tblPersona_C').setActiveTab(2);
                                                                        
                                                                        var cmbEstadoCParticipante=crearComboExt('cmbEstadoCParticipante_C',arrEstadosCParticipante,0,0,260,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboDepartamento_C'});
                                                                        cmbEstadoCParticipante.on('select',obtenerMunicipiosCParticipante);
                                                                        var cmbMunicipioCParticipante=crearComboExt('cmbMunicipioCParticipante_C',[],0,0,260,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divComboCiudad_C'});         
                                                                        
                                                                        gEx('tblPersona_C').setActiveTab(0);
                                                                   		gEx('txtNombre_C').focus();
                                                                        
                                                                    
                                                                    }
                                                               }
                                                      },
                                        title:'Partes procesales',
                                        items:	[
                                        			{
                                                        xtype:'panel',
                                                        layout:'border',
                                                        region:'west',
                                                        width:370,
                                                        cls:'gridPanelSIUGJCabecera',
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
                                                                        xtype:'tabpanel',
                                                                        id:'tblPersona_C',
                                                                        border:false,
                                                                        disabled:true,
                                                                        cls:'tabPanelSIUGJ',
                                                                        region:'center',
                                                                        activeTab:0,
                                                                        tbar:	[
                                                                        			{
                                                                                        icon:'../images/guardar.JPG',
                                                                                        cls:'x-btn-text-icon',
                                                                                        hidden:gE('sL').value=='1',
                                                                                        id:'btnGuardarIdentificacion',
                                                                                        text:'Guardar datos',
                                                                                        handler:function()
                                                                                                {
                                                                                                	//limpiarDatosIdentificacion_C();
                                                                                                    guardarDatosPersona();
                                                                                                }
                                                                                        
                                                                                    }
                                                                        		],
                                                                        items:	[
                                                                                    {
                                                                                        xtype:'panel',
                                                                                        defaultType: 'label',
                                                                                        layout:'absolute',
                                                                                        baseCls: 'x-plain',
                                                                                        id:'panelDatosGenerales',
                                                                                        title:'Datos generales',
                                                                                        items:	[
                                                                                                    {
                                                                                                        x:10,
                                                                                                        y:20,
                                                                                                        cls:'SIUGJ_Etiqueta',
                                                                                                        html:'Sujeto Procesal: <span style="color:#F00"></span>'
                                                                                                    },
                                                                                                    {
                                                                                                        x:200,
                                                                                                        y:20,
                                                                                                        cls:'SIUGJ_ControlEtiqueta',
                                                                                                        id:'lblFiguraJuridica_C',
                                                                                                        html:''
                                                                                                    },
                                                                                                    {
                                                                                                        x:350,
                                                                                                        y:15,
                                                                                                        cls:'controlSIUGJ',
                                                                                                        id:'lblDescripcionFiguraJuridica_C',
                                                                                                        html:''
                                                                                                    },
                                                                                                    {
                                                                                                        x:10,
                                                                                                        y:70,
                                                                                                        cls:'SIUGJ_Etiqueta',
                                                                                                        html:'Tipo de persona:'
                                                                                                    },
                                                                                                    {
                                                                                                        x:200,
                                                                                                        y:65,
                                                                                                        html:'<div id="divTipoPersona_C"></div>'
                                                                                                    },
                                                                                                    {
                                                                                                        x:610,
                                                                                                        y:90,
                                                                                                        id:'lblErrorCedula_1_C',
                                                                                                        hidden:true,
                                                                                                        cls:'SIUGJ_Etiqueta',
                                                                                                        html:'<span style="color:#F00">Tarjeta Profesional no existe</span>'//'<span style="color:#900">El n&uacute;mero de c&eacute;dula ingresada NO existe</span>'
                                                                                                    },
                                                                                                    {
                                                                                                        x:610,
                                                                                                        y:90,
                                                                                                        id:'lblErrorCedula_2_C',
                                                                                                        cls:'SIUGJ_Etiqueta',
                                                                                                        hidden:true,
                                                                                                        html:'<span style="color:#F00">Tarjeta profesional No vigente</span>'
                                                                                                    },
                                                                                                     {
                                                                                                        x:610,
                                                                                                        y:90,
                                                                                                        id:'lblErrorCedula_3_C',
                                                                                                        cls:'SIUGJ_Etiqueta',
                                                                                                        hidden:true,
                                                                                                        html:'<span style="color:#030">Tarjeta profesional vigente</span>'
                                                                                                    },
                                                                                                    {
                                                                                                        x:610,
                                                                                                        y:90,
                                                                                                        id:'lblErrorCedula_4_C',
                                                                                                        cls:'SIUGJ_Etiqueta',
                                                                                                        hidden:true,
                                                                                                        html:'<span style="color:#F00">Tarjeta profesional sin validar</span>'
                                                                                                    },
                                                                                                    {
                                                                                                        x:500,
                                                                                                        y:140,
                                                                                                        id:'lblErrorCedula_5_C',
                                                                                                        cls:'SIUGJ_Etiqueta',
                                                                                                        hidden:true,
                                                                                                        html:'<span style="color:#F00">No existe</span>'
                                                                                                    },
                                                                                                    {
                                                                                                        x:500,
                                                                                                        y:140,
                                                                                                        id:'lblErrorCedula_6_C',
                                                                                                        cls:'SIUGJ_Etiqueta',
                                                                                                        hidden:true,
                                                                                                        html:'<span style="color:#F00">Error en servicio de consulta</span>'
                                                                                                    },
                                                                                                    {
                                                                                                          x:10,
                                                                                                          y:120,
                                                                                                          hidden:true,
                                                                                                          cls:'SIUGJ_Etiqueta',
                                                                                                          id:'lblTipoEntidad_C',
                                                                                                          html:'Tipo de Entidad: <span style="color:#F00"></span>'
                                                                                                      },
                                                                                                      {
                                                                                                          x:200,
                                                                                                          y:115,
                                                                                                          id:'divTipoEntidad_C',
                                                                                                          hidden:true,
                                                                                                          html:'<div id="divComboTipoEntidad_C" style="width:230px"></div>'
                                                                                                      },
                                                                                                    {
                                                                                                        x:10,
                                                                                                        y:120,
                                                                                                        cls:'SIUGJ_Etiqueta',
                                                                                                        id:'lblIdentificacion_C',
                                                                                                        xtype:'label',
                                                                                                        html:'Tipo de identificaci&oacute;n: <span style="color:#F00"></span>'
                                        
                                                                                                        
                                                                                                    },
                                                                                                    {
                                                                                                        x:230,
                                                                                                        y:115,
                                                                                                        id:'lblDivComboIdentificacion_C',
                                                                                                        html:'<div id="divComboIdentificacion_C"></div>'
                                                                                                    }, 
                                                                                                    {
                                                                                                        x:400,
                                                                                                        y:165,
                                                                                                        hidden:true,
                                                                                                        id:'txtNIT_C',
                                                                                                        cls:'controlSIUGJ',
                                                                                                        xtype:'textfield',
                                                                                                        enableKeyEvents :true,
                                                                                                        listeners:	{
                                                                                                                        keypress:function(txt,e)
                                                                                                                            {
            
                                                                                                                                if(e.charCode=='46')
                                                                                                                                {
                                                                                                                                    e.stopEvent();
                                                                                                                                    return;
                                                                                                                                }
                                                                                                                                if(e.charCode=='13')
                                                                                                                                {
                                                                                                                                    if(txt.getValue()=='')
                                                                                                                                        return;
                                                                                                                                    
                                                                                                                                    if(validarNIT(txt.getValue(),1))
                                                                                                                                    {   
                                                                                                                                        if(txt.ultimaBusqueda!=txt.getValue())
                                                                                                                                        {
                                                                                                                                            txt.ultimaBusqueda=txt.getValue();
                                                                                                                                            buscarPersona(txt.getValue(),14,tipoParticipante);
                                                                                                                                        }
                                                                                                                                    }
                                                                                                                                }
                                                                                                                                
                                                                                                                                var posDocumento=existeValorMatriz(arrTipoIdentificacionConfiguracion,'14');
                                                                                                                                var filaDocumento=arrTipoIdentificacionConfiguracion[posDocumento];
                                                                                                                                
                                                                                                                                if(filaDocumento[4]!='')
                                                                                                                                {
                                                                                                                                    if((txt.getValue().length+1)>parseInt(filaDocumento[4]))
                                                                                                                                    {
                                                                                                                                        e.stopEvent();
                                                                                                                                    }
                                                                                                                                }
                                                                                                                                if(filaDocumento[5]!='')
                                                                                                                                {
                                                                                                                                    var re =null;
                                                                                                                                    
                                                                                                                                    eval('re=/['+filaDocumento[5]+']/;');
                                                                                                                                    var caracter=String.fromCharCode(e.charCode);
                                                                                                                                    if(!re.test(caracter))
                                                                                                                                    {
                                                                                                                                        e.stopEvent();
                                                                                                                                    }
                                                                                                                                    
                                                                                                                                }
                                                                                                                                
                                                                                                                                
                                                                                                                            },
                                                                                                                        blur:function(txt)
                                                                                                                            {
                                                                                                                                if(txt.getValue()=='')
                                                                                                                                    return;
                                                                                                                                if(validarNIT(txt.getValue(),1))
                                                                                                                                {  
                                                                                                                                    if(txt.ultimaBusqueda!=txt.getValue())
                                                                                                                                    {
                                                                                                                                        txt.ultimaBusqueda=txt.getValue();
                                                                                                                                        buscarPersona(txt.getValue(),'14',tipoParticipante);
                                                                                                                                    }
                                                                                                                                }
                                                                                                                                
                                                                                                                            }
                                                                                                                    },
                                                                                                        
                                                                                                        width:200
                                                                                                    },
                                                                                                    {
                                                                                                        x:50,
                                                                                                        y:190,
                                                                                                        cls:'controlSIUGJ',
                                                                                                        id:'lblSinDigito_C',
                                                                                                        hidden:true,
                                                                                                        xtype:'label',
                                                                                                        html:'(Ingrese el NIT sin d&iacute;gito verificador)'
                                        
                                                                                                        
                                                                                                    },             
                                                                                                    {
                                                   														x:575,
                                                                                                        y:120,
                                                                                                        cls:'SIUGJ_Etiqueta',
                                                                                                        id:'lblNoIdentificacion_C',
                                                                                                        xtype:'label',
                                                                                                        html:'No. de Identificaci&oacute;n: <span style="color:#F00"></span>'
                                        
                                                                                                        
                                                                                                    },
                                                                                                    {
                                                                                                        xtype:'textfield',
                                                                                                        x:770,
                                                                                                        y:115,
                                                                                                        cls:'controlSIUGJ',
                                                                                                        id:'txtEspecifique_C',
                                                                                                        width:170,
                                                                                                        enableKeyEvents :true,
                                                                                                        listeners:	{
                                                                                                                        keypress:function(txt,e)
                                                                                                                            {
            
                                                                                                                                if(e.charCode=='46')
                                                                                                                                {
                                                                                                                                    e.stopEvent();
                                                                                                                                    return;
                                                                                                                                }
                                                                                                                                if(e.charCode=='13')
                                                                                                                                {
                                                                                                                                    if(txt.getValue()=='')
                                                                                                                                        return;
                                                                                                                                    
                                                                                                                                    if(validarNoIdentificacion(1))
                                                                                                                                    {   
                                                                                                                                        if(txt.ultimaBusqueda!=txt.getValue())
                                                                                                                                        {
                                                                                                                                            txt.ultimaBusqueda=txt.getValue();
                                                                                                                                            buscarPersona(txt.getValue(),cmbIdentificacion.getValue(),tipoParticipante);
                                                                                                                                        }
                                                                                                                                    }
                                                                                                                                }
                                                                                                                                
                                                                                                                                var posDocumento=existeValorMatriz(arrTipoIdentificacionConfiguracion,gEx('cmbIdentificacion').getValue());
                                                                                                                                var filaDocumento=arrTipoIdentificacionConfiguracion[posDocumento];
                                                                                                                                
                                                                                                                                if(filaDocumento[4]!='')
                                                                                                                                {
                                                                                                                                    if((txt.getValue().length+1)>parseInt(filaDocumento[4]))
                                                                                                                                    {
                                                                                                                                        e.stopEvent();
                                                                                                                                    }
                                                                                                                                }
                                                                                                                                if(filaDocumento[5]!='')
                                                                                                                                {
                                                                                                                                    var re =null;
                                                                                                                                    
                                                                                                                                    eval('re=/['+filaDocumento[5]+']/;');
                                                                                                                                    var caracter=String.fromCharCode(e.charCode);
                                                                                                                                    if(!re.test(caracter))
                                                                                                                                    {
                                                                                                                                        e.stopEvent();
                                                                                                                                    }
                                                                                                                                    
                                                                                                                                }
                                                                                                                                
                                                                                                                                
                                                                                                                            },
                                                                                                                        blur:function(txt)
                                                                                                                            {
                                                                                                                                if(txt.getValue()=='')
                                                                                                                                    return;
                                                                                                                                
                                                                                                                                if(validarNoIdentificacion(1))
                                                                                                                                {  
                                                                                                                                    if(txt.ultimaBusqueda!=txt.getValue())
                                                                                                                                    {
                                                                                                                                        txt.ultimaBusqueda=txt.getValue();
                                                                                                                                        buscarPersona(txt.getValue(),cmbIdentificacion.getValue(),tipoParticipante);
                                                                                                                                    }
                                                                                                                                }
                                                                                                                                
                                                                                                                            }
                                                                                                                    }
                                                                                                    },
                                                                                                    {
                                                                                                          x:10,
                                                                                                          y:200,
                                                                                                          cls:'SIUGJ_Etiqueta',
                                                                                                          id:'lblFechaExpedicion_C',
                                                                                                          html:'Fecha de expedición del documento de identidad:'
                                                                                                      },
                                                                                                      
                                                                                                       {
                                                                                                          x:435,
                                                                                                          y:200,
                                                                                                          cls:'SIUGJ_Etiqueta',
                                                                                                          id:'lblValFechaExpedicion_C',
                                                                                                          html:'<span style="color:#F00"></span>'
                                                                                                      },
                                                                                                      {
                                                                                                          x:455,
                                                                                                          y:195,
                                                                                                          id:'divFechaDocumento_C',
                                                                                                          html:'<div id="dteFechaDocumento_C" style="width:140px"></div>'
                                                                                                      },
                                                                                                      {
                                                                                                          x:620,
                                                                                                          y:200,
                                                                                                          hidden:true,
                                                                                                          cls:'SIUGJ_Etiqueta',
                                                                                                          id:'lblTarjetaProfesional_C',
                                                                                                          html:'Tarjeta profesional: <span style="color:#F00"></span>'
                                                                                                      },
                                                                                                      {
                                                                                                          xtype:'textfield',
                                                                                                          width:140,
                                                                                                          hidden:true,
                                                                                                          disabled:true,
                                                                                                          cls:'controlSIUGJ',
                                                                                                          id:'txtTarjetaProfesional_C',
                                                                                                          x:800,
                                                                                                          y:195
                                                                                                      },
                                                                                                     {
                                                                                                          x:10,
                                                                                                          y:250,
                                                                                                          cls:'SIUGJ_Etiqueta',
                                                                                                          id:'lblNombre_C',
                                                                                                          html:'Nombre: <span style="color:#F00"></span>'
                                                                                                      },
                                                                                                      {
                                                                                                          xtype:'textfield',
                                                                                                          width:220,
                                                                                                          cls:'controlSIUGJ',
                                                                                                          id:'txtNombre_C',
                                                                                                          enableKeyEvents:true,
                                                                                                          maskRe:/^[A-Za-zÁÉÍÓÚáéíóú\s\u00f1\u00d1]$/,
                                                                                                          listeners:	{
                                                                                                                            keypress:function(txt,e)
                                                                                                                                {
                                                                                                                                    
                
                                                                                                                                    if((e.charCode>='33')&&(e.charCode<='38')||(e.charCode=='40'))
                                                                                                                                    {
                                                                                                                                        e.stopEvent( );
                                                                                                                                        return;
                                                                                                                                    }
                                                                                                                                    
                                                                                                                                }
                                                                                                                           },
                                                                                                          x:180,
                                                                                                          y:245
                                                                                                      },
                                                                                                      {
                                                                                                          x:10,
                                                                                                          y:240,
                                                                                                          hidden:true,
                                                                                                          cls:'SIUGJ_Etiqueta',
                                                                                                          id:'lblRazonSocial_C',
                                                                                                          html:'Raz&oacute;n Social: <span style="color:#F00"></span>'
                                                                                                      },
                                                                                                      {
                                                                                                          xtype:'textfield',
                                                                                                          width:740,
                                                                                                          hidden:true,
                                                                                                          cls:'controlSIUGJ',
                                                                                                          id:'txtRazonSocial_C',
                                                                                                          x:200,
                                                                                                          y:235
                                                                                                      },
                                                                                                       
                                                                                                      
                                                                                                      {
                                                                                                          x:455,
                                                                                                          y:250,
                                                                                                          cls:'SIUGJ_Etiqueta',
                                                                                                          id:'lblApPaterno_C',
                                                                                                          html:'Primer Apellido: <span style="color:#F00"></span>'
                                                                                                      },
                                                                                                      {
                                                                                                          xtype:'textfield',
                                                                                                          width:220,
                                                                                                          cls:'controlSIUGJ',
                                                                                                          id:'txtApPaterno_C',
                                                                                                          x:610,
                                                                                                          y:245,
                                                                                                          enableKeyEvents:true,
                                                                                                          maskRe:/^[A-Za-zÁÉÍÓÚáéíóú\s\u00f1\u00d1]$/,
                                                                                                          listeners:	{
                                                                                                                            keypress:function(txt,e)
                                                                                                                                {
                                                                                                                                    
                
                                                                                                                                    if((e.charCode>='33')&&(e.charCode<='38')||(e.charCode=='40'))
                                                                                                                                    {
                                                                                                                                        e.stopEvent( );
                                                                                                                                        return;
                                                                                                                                    }
                                                                                                                                    
                                                                                                                                }
                                                                                                                           }
                                                                                                      },
                                                                                                      {
                                                                                                          x:10,
                                                                                                          y:300,
                                                                                                          cls:'SIUGJ_Etiqueta',
                                                                                                          id:'lblApMaterno_C',
                                                                                                          html:'Segundo Apellido:'
                                                                                                      },
                                                                                                      {
                                                                                                          xtype:'textfield',
                                                                                                          width:220,
                                                                                                          cls:'controlSIUGJ',
                                                                                                          id:'txtApMaterno_C',
                                                                                                          x:180,
                                                                                                          y:295,
                                                                                                          enableKeyEvents:true,
                                                                                                          maskRe:/^[A-Za-zÁÉÍÓÚáéíóú\s\u00f1\u00d1]$/,
                                                                                                          listeners:	{
                                                                                                                            keypress:function(txt,e)
                                                                                                                                {
                                                                                                                                    
                
                                                                                                                                    if((e.charCode>='33')&&(e.charCode<='38')||(e.charCode=='40'))
                                                                                                                                    {
                                                                                                                                        e.stopEvent( );
                                                                                                                                        return;
                                                                                                                                    }
                                                                                                                                    
                                                                                                                                }
                                                                                                                           },
                                                                                                      }
                                                                                                          
                                                                                                      
                                                                                                ]
                                                                                    },
                                                                                    {
                                                                                        xtype:'panel',
                                                                                        defaultType: 'label',
                                                                                        layout:'absolute',
                                                                                        baseCls: 'x-plain',
                                                                                        id:'panelDatosSociodemograficos',
                                                                                        title:'Sociodemogr&aacute;ficos',
                                                                                        items:	[
                                                                                                    
                                                                                                    {
                                                                                                        x:10,
                                                                                                        y:20,
                                                                                                        cls:'SIUGJ_Etiqueta',
                                                                                                        id:'lblGenero_C',
                                                                                                        html:'G&eacute;nero: <span style="color:#F00"></span>'
                                                                                                    },
                                                                                                    {
                                                                                                        x:150,
                                                                                                        y:15,
                                                                                                        html:'<div id="divComboGenero_C"></div>'
                                                                                                    },
                                                                                                    
                                                                                                    {
                                                                                                        x:370,
                                                                                                        y:20,
                                                                                                        cls:'SIUGJ_Etiqueta',
                                                                                                        id:'lblFechaNac_C',
                                                                                                        html:'Fecha de nacimiento:'
                                                                                                    },
                                                                                                    {
                                                                                                        x:570,
                                                                                                        y:15,
                                                                                                        html:'<div id="divComboFecha_C" style="width:140px"></div>'
                                                                                                        
                                                                                                    },
                                                                                                    {
                                                                                                        x:740,
                                                                                                        y:20,
                                                                                                        cls:'SIUGJ_Etiqueta',
                                                                                                        id:'lblEdad_C',
                                                                                                        html:'Edad:'
                                                                                                    },
                                                                                                    {
                                                                                                        xtype:'numberfield',
                                                                                                        width:60,
                                                                                                        x:810,
                                                                                                        y:15,
                                                                                                        cls:'controlSIUGJ',
                                                                                                        id:'txtEdad_C'
                                                                                                    },
                                                                                                    {
                                                                                                        x:10,
                                                                                                        y:70,
                                                                                                        cls:'SIUGJ_Etiqueta',
                                                                                                        id:'lblGrupoEtnico_C',
                                                                                                        html:'Grupo &Eacute;tnico:'
                                                                                                    },
                                                                                                    {
                                                                                                        x:150,
                                                                                                        y:65,
                                                                                                        html:'<div id="divGrupoEtnico_C"></div>'
                                                                                                        
                                                                                                    },
                                                                                                    
                                                                                                    {
                                                                                                        x:370,
                                                                                                        y:70,
                                                                                                        cls:'SIUGJ_Etiqueta',
                                                                                                        id:'lblDiscapacidad_C',
                                                                                                        html:'Discapacidad:'
                                                                                                    },
                                                                                                    {
                                                                                                        x:570,
                                                                                                        y:65,
                                                                                                        html:'<div id="divDiscapacidad_C"></div>'
                                                                                                        
                                                                                                    }
                                                                                                    
                                                                                                ]
                                                                                    },
                                                                                    {
                                                                                        xtype:'panel',
                                                                                        defaultType: 'label',
                                                                                        layout:'absolute',
                                                                                        baseCls: 'x-plain',
                                                                                        id:'panelDatosContacto',
                                                                                        title:'Datos de contacto',
                                                                                        items:	[
                                                                                                    
                                                                                        
                                                                                                        {
                                                                                                            x:10,
                                                                                                            y:10,
                                                                                                            height:280,
                                                                                                            border:false,
                                                                                                            id:'panelContacto_C',
                                                                                                            xtype:'tabpanel',
                                                                                                            listeners:	{
                                                                                                                            tabchange:function( panel, tab )
                                                                                                                                        {
                                                                                                                                            
                                                                                                                                        }
                                                                                                                        },
                                                                                                            activeTab:0,
                                                                                                            items:	[
                                                                                                                        {
                                                                                                                            title:'Datos de domicilio',
                                                                                                                            layout:'absolute',
                                                                                                                            xtype:'panel',
                                                                                                                            defaultType: 'label',
                                                                                                                            items:	[
                                                                                                                                        {
                                                                                                                                            x:10,
                                                                                                                                            y:20,
                                                                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                                                                            id:'lblDireccion_C',
                                                                                                                                            html:'Direcci&oacute;n de residencia:'
                                                                                                                                        },
                                                                                                                                        {
                                                                                                                                            x:210,
                                                                                                                                            y:20,
                                                                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                                                                            id:'lblValDireccion_C',

                                                                                                                                            html:' <span style="color:#F00"></span>'
                                                                                                                                        },
                                                                                                                                        {
                                                                                                                                            x:300,
                                                                                                                                            y:15,
                                                                                                                                            xtype:'textfield',
                                                                                                                                            width:610,
                                                                                                                                            cls:'controlSIUGJ',
                                                                                                                                            id:'txtCalleCParticipante_C'
                                                                                                                                        },
                                                                                                                                        
                                                                                                                                        {
                                                                                                                                            x:10,
                                                                                                                                            y:60,
                                                                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                                                                            html:'Departamento de residencia:'
                                                                                                                                        },
                                                                                                                                        {
                                                                                                                                            x:255,
                                                                                                                                            y:60,
                                                                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                                                                            id:'lblValDepto_C',
                                                                                                                                            html:'<span style="color:#F00"></span>'
                                                                                                                                        },
                                                                                                                                         {
                                                                                                                                            x:300,
                                                                                                                                            y:55,
                                                                                                                                            html:'<div id="divComboDepartamento_C"></div>'
                                                                                                                                        },
                                                                                                                                        
                                                                                                                                        
                                                                                                                                        {
                                                                                                                                            x:10,
                                                                                                                                            y:110,
                                                                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                                                                            html:'Ciudad/municipio de residencia:'
                                                                                                                                        },
                                                                                                                                        {
                                                                                                                                            x:280,
                                                                                                                                            y:110,
                                                                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                                                                            id:'lblValCiudad_C',
                                                                                                                                            html:' <span style="color:#F00"></span>'
                                                                                                                                        },
                                                                                                                                       {
                                                                                                                                            x:300,
                                                                                                                                            y:105,
                                                                                                                                            html:'<div id="divComboCiudad_C"></div>'
                                                                                                                                        }
                                                                                                                                        
                                                                                                                                    ]
                                                                                                                        },	
                                                                                                                        {
                                                                                                                            xtype:'panel',
                                                                                                                            title:'Tel&eacute;fonos de contacto',
                                                                                                                            layout:'border',
                                                                                                                            items:	[
                                                                                                                                        crearGridTelefonoCParticipante_C()
                                                                                                                                    ]
                                                                                                                        }
                                                                                                                        ,
                                                                                                                        {
                                                                                                                            xtype:'panel',
                                                                                                                            title:'Correos electr&oacute;nicos de contacto',
                                                                                                                            layout:'border',
                                                                                                                            items:	[
                                                                                                                                        crearGridMailCParticipante_C()
                                                                                                                                    ]
                                                                                                                        }
                                                                                                                        
                                                                                                                    ]
                                                                                                        },
                                                                                                        {
                                                                                                            x:10,
                                                                                                            y:300,
                                                                                                            cls:'SIUGJ_Etiqueta',
                                                                                                            id:'lblAceptaNotificacion_C',
                                                                                                            xtype:'label',
                                                                                                            html:'¿Acepta la Notificaci&oacute;n por Correo Electr&oacute;nico?: <span style="color:#F00"></span>'
                                            
                                                                                                            
                                                                                                        },  
                                                                                                        
                                                                                                                                                                                                    
                                                                                                         {
                                                                                                              xtype:'radio',
                                                                                                              checked:true,
                                                                                                              name:'aceptaNotificacion',
                                                                                                              ctCls:'controlSIUGJ',
                                                                                                              id: 'aceptaNotificacion_1_C',
                                                                                                              inputValue: 1,
                                                                                                              x:430,
                                                                                                              y:295,      
                                                                                                              boxLabel: 'S&iacute;'
                                                                                                          }, 
                                                                                                          {	
                                                                                                              xtype:'radio',
                                                                                                              name:'aceptaNotificacion',
                                                                                                              ctCls:'controlSIUGJ',
                                                                                                              id: 'aceptaNotificacion_0_C',
                                                                                                              inputValue: 0,
                                                                                                              x:530,
                                                                                                              y:295,
                                                                                                              boxLabel: 'No'
                                                                                                          }
                                                                                                    
                                                                                                    
                                                                                                    ]
                                                                                    }
                                                                                    ,
                                                                                    {
                                                                                        xtype:'panel',
                                                                                        defaultType: 'label',
                                                                                        layout:'border',
                                                                                        baseCls: 'x-plain',
                                                                                        id:'tabRelacionado',
                                                                                        title:'Relacionado con',
                                                                                        items:	[


                                                                                                    crearArbolSujetosProcesalesRelacion_C()
                                                                                                ]
                                                                                        
                                                                                    }
                                                                                ]
                                                                    }
                                                        			
                                                                ]
                                                    }
                                        		]
                                    }
    							)
	
   
    
    return panel;                                
}

function crearArbolSujetosProcesalesRelacion_C()
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
                                                                    funcion:'19'
                                                                    
                                                                },
                                                    dataUrl:'../paginasFunciones/funcionesModulosEspeciales_Notificaciones.php'
                                                }
                                            )		
										
	cargadorArbol.on('beforeload',function(c)
    						{
                            	var listPartes=buscarPartesAsociar_C(nodoSujetoSel?nodoSujetoSel.attributes.personaJuridica:-1);
                            	c.baseParams.sujetosProcesales=listPartes;
                                c.baseParams.iC=gE('idCarpetaAdministrativa')?gE('idCarpetaAdministrativa').value:-1;
                                c.baseParams.cA=gE('carpetaAdministrativa')?gE('carpetaAdministrativa').value:-1;
                                c.baseParams.iA=idActividadCarpeta;
                                c.baseParams.check=1;
                                c.baseParams.iP=nodoSujetoSel?nodoSujetoSel.attributes.idPersona:-1;
                                
                                
                                
                                if(listPartes=='-1')
                                {
                                	gEx('tblPersona_C').hideTabStripItem(3);
                                }
                                else
                                	gEx('tblPersona_C').unhideTabStripItem(3);

                            }
    				)	
    										
	cargadorArbol.on('load',function(c,nodoCarga)
    						{
                            	
                            }
    				)										
	var arbolSujetosJuridicos=new Ext.tree.TreePanel	(
                                                            {
                                                                id:'arbolSujetosRelacion_C',
                                                                useArrows:true,
                                                                animate:true,
                                                                enableDD:false,
                                                                ddScroll:true,
																region:'center',
                                                                containerScroll: true,
                                                                autoScroll:true,
                                                                border:true,
                                                                root:raiz,
                                                                cls:'treeControlSIUGJ',
                                                                loader: cargadorArbol,
                                                                rootVisible:false
                                                            }
                                                        )
         
         
                                                    
	return  arbolSujetosJuridicos;
}

function buscarPartesAsociar_C(parteProcesal)
{
	var listPartes='';
	if(parteProcesal=='-1')
    {
    	return '-1';
    }
    pos=existeValorMatriz(arrParteProcesalCP,parteProcesal);
    
    var x;
    if(arrParteProcesalCP[pos][3]!='')
    {
        var aFiguras=arrParteProcesalCP[pos][3].split(',');
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
    
    return listPartes;
    
    
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
                                    selPersona='';
                                }
                                else
                                {
                                	limpiarDatosIdentificacion_C();
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

                                                                cls:'arbolNotificacion panelSiugj',
                                                                loader: cargadorArbol,
                                                                rootVisible:false,
                                                                tbar:	[
                                                                			{
                                                                                icon:'../images/add.png',
                                                                                cls:'x-btn-text-icon',
                                                                                hidden:gE('sL').value=='1',
                                                                                text:'Agregar...',
                                                                                menu:	<?php echo $arrPartes?>
                                                                                
                                                                            },'-',
                                                                            {
                                                                                icon:'../images/cog.png',
                                                                                cls:'x-btn-text-icon',
                                                                                hidden:gE('sL').value=='1',
                                                                                text:'Otras acciones',
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
		if(!cancelarBusquedaDatosPersona)
	        obtenerDatosIdentificacion_C(idParticipanteSel);
        cancelarBusquedaDatosPersona=false;
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
    }
}

function crearGridTelefonoCParticipante_C()
{
	var cmbTipoTelefonoCParticipante=crearComboExt('cmbTipoTelefonoCParticipante_C',arrTelefonosCParticipante,0,0,null,{transform:false,ctCls:'comboWrapSIUGJGrid',cls:'comboSIUGJGrid',listClass:'listComboSIUGJGrid'});
	var cmbPais=crearComboExt('cmbPais_C',arrPaises,0,0,null,{transform:false,ctCls:'comboWrapSIUGJGrid',cls:'comboSIUGJGrid',listClass:'listComboSIUGJGrid'});
	
    var dsDatos=[];
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'tipoTelefono'},
                                                                    {name: 'pais'},
                                                                    {name: 'lada'},
                                                                    {name: 'numero'},
                                                                    {name: 'extension'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel({width:40});
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	
														chkRow,
														{
															header:'Tipo',
															width:90,
															sortable:true,
															dataIndex:'tipoTelefono',
                                                            editor:cmbTipoTelefonoCParticipante,
                                                            renderer:function(val)
                                                            		{
                                                                    	return formatearValorRenderer(arrTelefonosCParticipante,val);
                                                                    }
														},
														{
															header:'Lada',
															width:45,
                                                            hidden:true,
															sortable:true,
															dataIndex:'lada',
                                                            editor:	{
                                                            			xtype:'textfield'
                                                            		}
														},
                                                        {
															header:'Pa&iacute;s',
															width:200,
                                                            editor:cmbPais,
                                                            sortable:true,
															dataIndex:'pais',
                                                            renderer:function(val)
                                                            		{
                                                                    	return mostrarValorDescripcion(formatearValorRenderer(arrPaises,val));
                                                                    }
														},
                                                        {
															header:'N&uacute;mero',
															width:280,
															sortable:true,
															dataIndex:'numero',
                                                            editor:	{
                                                            			xtype:'textfield',
                                                                        enableKeyEvents:true,
                                                                        maskRe:/^[0-9]$/,
                                                                        listeners:	{
                                                                        				keypress:function(ctrl,e)
                                                                                        		{
                                                                                                	if(ctrl.getValue().length==10)
                                                                                                    {
                                                                                                    	e.stopEvent();
                                                                                                    }
                                                                                                }
                                                                        			},
                                                                        cls:'controlSIUGJ'
                                                            		}
														},
                                                        {
															header:'Extensi&oacute;n',
															width:100,
															sortable:true,
															dataIndex:'extension',
                                                            editor:	{
                                                            			xtype:'numberfield',
                                                                        allowDecimals:false,
                                                                        cls:'controlSIUGJ',
                                                                        allowNegative:false
                                                            		}
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gTelefonosCParticipante_C',
                                                            store:alDatos,
                                                            frame:false,
                                                            border:true,
                                                            region:'center',
                                                            clicksToEdit:1,
                                                            cls:'gridSiugjPrincipal',
                                                            cm: cModelo,
                                                            loadMask:true,
                                                            stripeRows :false,                                                            
                                                            columnLines : false,                                                            
                                                            sm:chkRow,
                                                            tbar:	[
                                                            			{
                                                                        	icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Agregar tel&eacute;fono',
                                                                            handler:function()
                                                                            		{
                                                                                    	var reg=crearRegistro	(
                                                                                        							[
                                                                                                                    	{name: 'tipoTelefono'},
                                                                                                                        {name: 'lada'},
                                                                                                                        {name: 'pais'},
                                                                                                                        {name: 'numero'},
                                                                                                                        {name: 'extension'}
                                                                                                                    ]
                                                                                        						)
                                                                                   		var r=new reg	(
                                                                                        					{
                                                                                                            	tipoTelefono:'1',
                                                                                                                lada:'',
                                                                                                                pais:'52',
                                                                                                                numero:'',
                                                                                                                extension:''
                                                                                                            }
                                                                                        				)
                                                                                   
                                                                                    	gEx('gTelefonosCParticipante_C').getStore().add(r);
                                                                                        gEx('gTelefonosCParticipante_C').startEditing(gEx('gTelefonosCParticipante').getStore().getCount()-1,1);
                                                                                    }
                                                                            
                                                                        },'-',
                                                                        {
                                                                        	icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Remover tel&eacute;fono',
                                                                            handler:function()
                                                                            		{
                                                                                    	var fila=gEx('gTelefonosCParticipante_C').getSelectionModel().getSelected();
                                                                                        if(!fila)
                                                                                        {
                                                                                        	msgBox('Debe seleccionar el tel&eacute;fono a remover');
                                                                                        	return;
                                                                                        }
                                                                                        function resp(btn)
                                                                                        {
                                                                                        	if(btn=='yes')
                                                                                            {
                                                                                            	gEx('gTelefonosCParticipante_C').getStore().remove(fila);
                                                                                            }
                                                                                        }
                                                                                        msgConfirm('Est&aacute; seguro de querer remover el tel&eacute;fono seleccionado?',resp);
                                                                                       
                                                                                        
                                                                                    }
                                                                            
                                                                        }
                                                                        
                                                            		]
                                                        }
                                                    );

	tblGrid.on('afteredit',function(e)
    						{
                            	e.record.set(e.field,(e.value+'').replace("'",""));
                            }
    		)

	return 	tblGrid;	
}

function crearGridMailCParticipante_C()
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
	var chkRow=new Ext.grid.CheckboxSelectionModel({width:40});
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	chkRow,
                                                        {
															header:'Correo electr&oacute;nico',
															width:500,
															sortable:true,
															dataIndex:'mail',
                                                            editor:	{
                                                            			xtype:'textfield',
                                                                        cls:'controlSIUGJ'
                                                            		}
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gMailCParticipante_C',
                                                            store:alDatos,
                                                            frame:false,
                                                            border:true,
                                                            region:'center',
                                                            cm: cModelo,
                                                            
                                                            cls:'gridSiugjPrincipal',
                                                            stripeRows :false,
                                                            loadMask:true,
                                                            columnLines : false,
                                                            sm:chkRow,
                                                            tbar:	[
                                                            			{
                                                                        	icon:'../images/add.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Agregar correo electr&oacute;nico',
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
                                                                                   
                                                                                    	gEx('gMailCParticipante_C').getStore().add(r);
                                                                                        gEx('gMailCParticipante_C').startEditing(gEx('gMailCParticipante_C').getStore().getCount()-1,1);
                                                                                    }
                                                                            
                                                                        },'-',
                                                                        {
                                                                        	icon:'../images/delete.png',
                                                                            cls:'x-btn-text-icon',
                                                                            text:'Remover correo electr&oacute;nico',
                                                                            handler:function()
                                                                            		{
                                                                                    	var fila=gEx('gMailCParticipante_C').getSelectionModel().getSelected();
                                                                                        if(!fila)
                                                                                        {
                                                                                        	msgBox('Debe seleccionar la direcci&oacute;n de correo electr&oacute;nico a remover');
                                                                                        	return;
                                                                                        }
                                                                                        
                                                                                        function resp(btn)
                                                                                        {
                                                                                        	if(btn=='yes')
                                                                                            {
                                                                                            	gEx('gMailCParticipante_C').getStore().remove(fila);
                                                                                            }
                                                                                        }
                                                                                        msgConfirm('¿Est&aacute; seguro de querer remover el correo electr&oacute;nico seleccionado?',resp);
                                                                                       
                                                                                        
                                                                                    }
                                                                            
                                                                        },
                                                                        {
                                                                        	xtype:'label',
                                                                            id:'etNoCorreo_C',
                                                                            html:'<div id="lblNoCorreo_C" class="SIUGJ_Etiqueta" style="color:#F00 !important;"></div>'

                                                                        }
                                                                        
                                                            		]
                                                        }
                                                    );
	return 	tblGrid;	
}



function obtenerDatosIdentificacion_C(idParticipanteContacto)
{

	idPersonaEncontrada=idParticipanteContacto;
    
    var posFila=existeValorMatriz(arrParteProcesal,nodoSujetoSel.attributes.personaJuridica);
    var filaConf=arrParteProcesal[posFila];
    
    var posIdentificacion=existeValorMatriz(arrParteProcesalCP,nodoSujetoSel.attributes.personaJuridica+'');
    var filaFiguraJuridicaConf=arrParteProcesalCP[posIdentificacion];
	var lblFiguraJuridica=arrParteProcesal[posFila][1];
	

	function funcAjax(peticion_http)
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
	        cObjeto=eval('['+bD(arrResp[2])+']')[0];
            
        	limpiarDatosIdentificacion_C();
			gEx('cmbTipoPersona_C').getStore().loadData(filaFiguraJuridicaConf[5]);
			gEx('cmbIdentificacion_C').getStore().loadData(filaFiguraJuridicaConf[6]);
            gEx('lblFiguraJuridica_C').setText(lblFiguraJuridica,false);  
            
        	esBusquedaPersona=true;
            var arrMails=[];
            
            if(typeof(cObjeto.datosParticipante.nombre)!='undefined')
            {
                
                gEx('txtNombre_C').setValue(cObjeto.datosParticipante.nombre);
                
                gEx('txtApPaterno_C').setValue(cObjeto.datosParticipante.apellidoPaterno);
                
                gEx('txtApMaterno_C').setValue(cObjeto.datosParticipante.apellidoMaterno);
                
                gEx('cmbIdentificacion_C').setValue(cObjeto.datosParticipante.tipoIdentificacion);
                gEx('txtEspecifique_C').setValue(cObjeto.datosParticipante.folioIdentificacion);
                gEx('txtTarjetaProfesional_C').setValue(cObjeto.datosParticipante.tarjetaProfesional);
                gEx('fechaNacimiento_C').setValue(cObjeto.datosParticipante.fechaNacimiento);
                gEx('fechaIdentificacion_C').setValue(cObjeto.datosParticipante.fechaIdentificacion);
                gEx('cmbTipoEntidad_C').setValue(cObjeto.datosParticipante.tipoEntidad);
            }
            
            if(typeof(cObjeto.datosParticipante.fechaNacimiento)!='undefined')
            {
                if(cObjeto.datosParticipante.fechaNacimiento!='')
                {
                    gEx('fechaNacimiento_C').fireEvent('change',gEx('fechaNacimiento_C'),gEx('fechaNacimiento_C').getValue());
                }
                
                gEx('cmbGenero_C').setValue(cObjeto.datosParticipante.genero);
                gEx('cmbGrupoEtnico_C').setValue(cObjeto.datosParticipante.grupoEtnico);
                gEx('cmbDiscapacidad_C').setValue(cObjeto.datosParticipante.discapacidad);

                var txtCalle=gEx('txtCalleCParticipante_C');
                txtCalle.setValue(cObjeto.datosContacto.calle);

                var cmbEstado=gEx('cmbEstadoCParticipante_C');
                cmbEstado.setValue(cObjeto.datosContacto.estado);
                var cmbMunicipio=gEx('cmbMunicipioCParticipante_C');
            
                var posFila=obtenerPosFila(cmbEstado.getStore(),'id',cObjeto.datosContacto.estado);
                if(posFila!=-1)
                {
                    var registro=cmbEstado.getStore().getAt(posFila);
                    obtenerMunicipiosCParticipante_C(cmbEstado,registro,function()
                                                                        {
                                                                            cmbMunicipio.setValue(cObjeto.datosContacto.municipio);
                                                                        }
                                                )
                }            
                
                
                
                var arrDatosTelefono=[];
                var x;
                var f;
                for(x=0;x<cObjeto.datosContacto.telefonos.length;x++)
                {
                    f=cObjeto.datosContacto.telefonos[x];
                    if(f.numero!='No registra información.')
                    {
                        arrDatosTelefono.push([f.tipoTelefono,f.idPais,f.lada,f.numero,f.extension]);
                        
                    }
                    
                }
                
                
                gEx('gTelefonosCParticipante_C').getStore().loadData(arrDatosTelefono);
                
                
                for(x=0;x<cObjeto.datosContacto.correos.length;x++)
                {
                    f=cObjeto.datosContacto.correos[x];

                    if(validarCorreo(f.mail))
                    {
                        arrMails.push([f.mail]);
                    }
                    
                }
                
                gEx('gMailCParticipante_C').getStore().loadData(arrMails);
            
            }
            if(cObjeto.datosParticipante.tipoPersona)
            {
                gEx('cmbTipoPersona_C').setValue(cObjeto.datosParticipante.tipoPersona);
                dispararEventoSelectCombo('cmbTipoPersona_C');
            
                if(cObjeto.datosParticipante.tipoPersona!='1')
                {
                    gEx('txtRazonSocial_C').setValue(cObjeto.datosParticipante.nombre);
                }
            }                
            
            
            if(cObjeto.validaCedulaProfesional=='1')
            {
                if(cObjeto.situacionCedula=='-1') //La cedula no existe
                {
                    gEx('lblErrorCedula_1_C').show();
                    gEx('btnAceptarAddPersona').disable();
                    esBusquedaPersona=true;
                    
                }
                
                if(cObjeto.situacionCedula=='2') //no vigente
                {

                    gEx('lblErrorCedula_2_C').show();
                }
                
                if(cObjeto.situacionCedula=='1') //vigente
                {
                    gEx('lblErrorCedula_3_C').show();
                }
                
                if(cObjeto.situacionCedula=='0') //Error en consulta
                {

                    gEx('lblErrorCedula_4_C').show();
                }
                
                if(cObjeto.situacionCedula=='-1000') //La cedula no existe
                {
                    gEx('lblErrorCedula_5_C').show();
                }
                
                if(cObjeto.situacionCedula=='-1001') //Error en consulta
                {
                    gEx('lblErrorCedula_6_C').show();
                }
                
                if(cObjeto.situacionCedula=='-1002')
                {
                }
            }
            
            if(arrMails.length==0)
            {
                
            	gEx('etNoCorreo_C').setText('<div id="lblNoCorreo" class="SIUGJ_Etiqueta" style="color:#F00 !important;">&nbsp;&nbsp;No registra información de correo electrónico</div>',false);
            }
            gEx('tblPersona_C').enable();
            gEx('arbolSujetosRelacion_C').getRootNode().reload();
            
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWebV2('../modulosEspeciales_SIUGJ/paginasFunciones/funcionesModuloRegistroPartes.php',funcAjax, 'POST','funcion=4&idActividad='+gE('idActividad').value+
    				'&figuraJuridica='+nodoSujetoSel.attributes.personaJuridica+'&idParticipante='+idParticipanteContacto,true);

}

function limpiarDatosIdentificacion_C()
{
	gEx('lblFiguraJuridica_C').setText('');
	gEx('cmbTipoPersona_C').setValue('');
    gEx('cmbIdentificacion_C').setValue('');
    gEx('txtEspecifique_C').setValue('');
    gEx('txtNombre_C').setValue('');
    gEx('txtApPaterno_C').setValue('');
    gEx('txtApPaterno_C').setValue('');
    gEx('txtApMaterno_C').setValue('');
    gEx('txtTarjetaProfesional_C').setValue('');
    gEx('fechaNacimiento_C').setValue('');
    gEx('fechaIdentificacion_C').setValue('');
    gEx('txtEdad_C').setValue('');
    gEx('cmbTipoEntidad_C').setValue('');
    gEx('cmbGenero_C').setValue('');
    gEx('cmbGrupoEtnico_C').setValue('');
    gEx('cmbDiscapacidad_C').setValue('');
   	var txtCalle=gEx('txtCalleCParticipante_C');
    txtCalle.setValue('');

    gEx('txtRazonSocial_C').setValue('');
    
    var cmbEstado=gEx('cmbEstadoCParticipante_C');
    cmbEstado.setValue('');
    var cmbMunicipio=gEx('cmbMunicipioCParticipante_C'); 
    cmbMunicipio.setValue('');
    
    gEx('etNoCorreo_C').setText('');
    gEx('arbolSujetosRelacion_C').getRootNode().reload();
    
    gEx('lblErrorCedula_1_C').hide();
    gEx('lblErrorCedula_2_C').hide();
    gEx('lblErrorCedula_3_C').hide();
    gEx('lblErrorCedula_4_C').hide();
    gEx('lblErrorCedula_5_C').hide();
    gEx('lblErrorCedula_6_C').hide();
    gEx('aceptaNotificacion_1_C').setValue(false);
    gEx('aceptaNotificacion_0_C').setValue(false);
    gEx('gTelefonosCParticipante_C').getStore().removeAll;
    gEx('gMailCParticipante_C').getStore().removeAll();
    gEx('tblPersona_C').setActiveTab(0);
    gEx('tblPersona_C').disable();
    
}





function recargarArbolParticipantes(iP,tP)
{
	selPersona='p_'+iP+'_'+tP;
	gEx('arbolSujetosAdmon').getRootNode().reload();
    if(gEx('gCuentasUsuario'))
	    gEx('gCuentasUsuario').getStore().reload();
	 if(gEx('gridAutorizacionAudienciaVirtual'))
	    gEx('gridAutorizacionAudienciaVirtual').getStore().reload();        
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
                case 2:
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
                case 2:
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
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Ingrese el motivo de la operaci&oacute;n:'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            width:650,
                                                            heght:60,
                                                            cls:'controlSIUGJ',
                                                            id:'txtComentariosAdicionales',
                                                            xtype:'textarea'
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: leyenda,
										width: 700,
										height:260,
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
                                                                	gEx('txtComentariosAdicionales').focus(false,500);
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
                                                                        	msgBox('Debe seleccionar al menos una persona a agregar como nueva relaci&oacute;n');
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
                                                                        	msgBox('Debe agregar al menos un documento de notificaci&oacute;n');
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
                                                                        	msgBox('Debe seleccionar al menos un documento a adjuntar a la orden de notificaci&oacute;n');
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
                
                
    if((nodoCarpetaSel.attributes.tipoRelacion)&&(nodoCarpetaSel.attributes.tipoRelacion=='6'))
    {
    	obj.params=	[['iD',bE('iD_'+idDocumento)],['cPagina','sFrm=true'],['idCarpeta',arrCarpeta[1]],
    			['carpetaJudicial',bE(arrCarpeta[0])]];
    }        
                
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
            obj.url='../modulosEspeciales_SGJ/tblAgendaAudiencias.php';
            obj.params=[['idFormulario',185],['idRegistro',arrResp[1]],['idReferencia',-1],
            		['dComp',arrResp[2]],['actor',arrResp[3]],['idCarpetaAdministrativa',gE('idCarpetaAdministrativa').value]];
            abrirVentanaFancy(obj);
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../modulosEspeciales_SGJ/paginasFunciones/funcionesModulosEspeciales_SGJ.php',funcAjax, 'POST','funcion=15&cA=<?php echo $carpetaAdministrativa?>&iE=-1&idCarpeta='+gE('idCarpetaAdministrativa').value,true);
 
 
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


function abrirHistorialDocumento(iD)
{
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'border',
                                            frame:false,
											defaultType: 'label',
											items: 	[
														crearGridHistorial(iD)

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Historial del Documento',
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

function crearGridHistorial(iD)
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idRegistro'},
                                                        {name:'fechaOperacion', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name:'etapaOriginal'},
		                                                {name:'etapaCambio'},
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

                                                                                                  url: '../paginasFunciones/funcionesFormulario.php'

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
                                    	proxy.baseParams.funcion='301';
                                        proxy.baseParams.idDocumento=bD(iD);
                                        
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
                                                                header:'Etapa original',
                                                                width:200,
                                                                sortable:true,
                                                                dataIndex:'etapaOriginal',
                                                                renderer:formatoTitulo2
                                                            },
                                                            {
                                                                header:'Etapa cambio',
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
                                                        id:'gridHistorial',
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
    p.body = '<BR><p style="margin-left: 4em;margin-right: 4em;text-align:justify"><br><span class="menu"><span style="color: #001C02">Comentarios:</span><br><br><span style="color: #3B3C3B">' + ((record.data.comentarios.trim()=="")?"(Sin comentarios)":record.data.comentarios) + '</span></p><br><br><br>';
    return 'x-grid3-row-expanded';
}

function formatoTitulo(val)
{
	return '<span style="font-size:11px; color:#040033">'+val+'</span>';
}

function formatoTitulo2(val)
{
	return '<div style="font-size:11px; color:#040033;; height:45px; word-wrap: break-word;white-space: normal; ">'+val+'</div>';
}

function formatoTitulo3(val)
{
	return '<div style="font-size:11px; height:45px; color:#040033; word-wrap: break-word;white-space: normal;"><img src="../images/user_gray.png">'+(val)+'</div>';
}

function crearGridPropiedadesProceso()
{
	var cmbPerfilAccesoProcesoJudicial=crearComboExt('cmbPerfilAccesoProcesoJudicial',arrPerfilesAcceso,0,0,null,{transform:false,ctCls:'comboWrapSIUGJGrid',cls:'comboSIUGJGrid',listClass:'listComboSIUGJGrid listComboSIUGJGridExpediente'});
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name: 'idMeta'},
		                                                {name: 'metaData'},
		                                                {name:'valor'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../modulosEspeciales_SGJ/paginasFunciones/funcionesModulosEspeciales_SGJ.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'metaData', direction: 'ASC'},
                                                            groupField: 'metaData',
                                                            remoteGroup:false,
				                                            remoteSort: true,
                                                            autoLoad:false
                                                            
                                                        }) 
	alDatos.on('beforeload',function(proxy)
    								{
                                    	proxy.baseParams.funcion='30';
                                        var arrCarpeta=nodoCarpetaSel.id.split('_');
                                    	proxy.baseParams.cA=bE(arrCarpeta[0]);
                                        proxy.baseParams.tipoCarpeta=nodoCarpetaSel.attributes.tipoCarpeta;
                                        proxy.baseParams.idCarpeta=arrCarpeta[1];
                                       
                                        
                                    }
                        )   
       
    var cModelo= new Ext.grid.ColumnModel   	(
                                                    [
                                                        {
                                                            header:'',
                                                            width:125,
                                                            sortable:true,
                                                            dataIndex:'metaData'
                                                        },
                                                        {
                                                            header:'',
                                                            width:150,
                                                            sortable:true,
                                                            dataIndex:'valor',
                                                            editor:cmbPerfilAccesoProcesoJudicial,
                                                            renderer:function(val,meta,registro)
                                                            		{
                                                                    	if(registro.data.idMeta=='100')
                                                                        {
                                                                        	return formatearValorRenderer(arrPerfilesAcceso,val);
                                                                        }
                                                                        else
                                                                    		return mostrarValorDescripcion(val);
                                                                    }
                                                        },
                                                    ]
                                                );
                                                
    var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            id:'gMetaDataProceso',
                                                            store:alDatos,
                                                            region:'south',
                                                            frame:false,
                                                            cm: cModelo,
                                                            clicksToEdit:1,
                                                            height:250,
                                                            hideHeaders : true,
                                                            cls:'gridSiugjPrincipal gridSiugjExpediente',
                                                            stripeRows :false,
                                                            loadMask:true,
                                                            columnLines : false,
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
    
   
	tblGrid.on('beforeedit',function(e)
    						{
                            	if((e.field!='valor')||(e.record.data.idMeta!='100')|| (gE('sL').value=='1')|| (!permiteEditarSecretarioJuez))
                                {
                                	e.cancel=true;
                                    return;
                                }
                                
                                
                                
                            }
    			)   

	tblGrid.on('afteredit',function(e)
    						{
                            	if(e.field=='valor')
                                {
                                	switch(e.record.data.idMeta)
                                    {
                                    	
                                    	case '100':
                                        	var arrCarpeta=nodoCarpetaSel.id.split('_');
                                        	var cadObj='{"carpetaAdministrativa":"'+arrCarpeta[0]+'","idCarpetaAdministrativa":"'+arrCarpeta[1]+
                                            		'","perfilAcceso":"'+e.value+'"';
                                        	function respPermisos(btn)
                                            {
                                                if(btn=='yes')
                                                {
                                                    cadObj+=',"modificarPerfilContenido":"1"}';
                                                }
                                                else
                                                {
                                                    cadObj+=',"modificarPerfilContenido":"0"}';
                                                }
                                                
                                                function funcAjax()
                                                {
                                                	function funcAjax()
                                                    {
                                                        var resp=peticion_http.responseText;
                                                        arrResp=resp.split('|');
                                                        if(arrResp[0]=='1')
                                                        {
                                                            /*if(btn=='yes')
                                                            {
                                                            	gEx('gridCarpetaAdministrativa').getStore().reload();
                                                            }*/
                                                        }
                                                        else
                                                        {
                                                            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                        }
                                                    }
                                                    obtenerDatosWeb('../modulosEspeciales_SGJ/paginasFunciones/funcionesModulosEspeciales_SGJ.php',funcAjax, 'POST','funcion=35&cadObj='+cadObj,true);

                                                    
                                                }
                                                obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=403&cadObj='+cadObj,true);
                                            }
                                            msgConfirm('¿Desea aplicar el perfil '+formatearValorRenderer(arrPerfilesAcceso,e.value)+
                                                        ' a todos los documentos contenidos en la carpeta?',respPermisos);
                                        
                                        
                                        	
                                        break;
                                    }
                                }
                            }
              )
    
    return 	tblGrid;
}

function visualizarTimeLine(cA)
{
	var obj={};
    obj.ancho='100%';
    obj.alto='100%';
    obj.openEffect='fade';
    obj.url='../modulosEspeciales_SGJ/frameHistorialCarpetaJudicial.php';
    obj.params=[['cA',cA],['cPagina','sFrm=true']];
    obj.titulo='Time Line, Proceso Judicial: '+bD(cA);
    abrirVentanaFancy(obj);
}

function recargarGridParticipantes()
{
	gEx('arbolSujetosAdmon').getRootNode().reload();
}


function exportarIndiceElectronico(formato)
{
	
	switch(formato)
    {
    	case 1:
            var arrParametros=[['cA',gE('carpetaAdministrativa').value],['idCarpeta',gE('idCarpetaAdministrativa').value]];
            enviarFormularioDatos('../modulosEspeciales_SIUGJ/generarIndiceElectronicoPDF.php',arrParametros,'POST','frameDTD');
            primeraCargaFrame=false;
		break;
       	case 2:

            var arrParametros=[['cA',gE('carpetaAdministrativa').value],['idCarpeta',gE('idCarpetaAdministrativa').value],['formato','1']];
            enviarFormularioDatos('../modulosEspeciales_SIUGJ/exportarIndiceElectronico.php',arrParametros,'POST');
            primeraCargaFrame=false;
		break;
        case 3:

            var arrParametros=[['cA',gE('carpetaAdministrativa').value],['idCarpeta',gE('idCarpetaAdministrativa').value],['formato','2']];
            enviarFormularioDatos('../modulosEspeciales_SIUGJ/exportarIndiceElectronico.php',arrParametros,'POST');
            primeraCargaFrame=false;
		break;
	}    
}


function mostrarVentanaCrearCuadernillo(nCarpetaSel)
{
	console.log(nCarpetaSel);
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
                                                            html:'Nombre del cuadernillo:'
                                                        },
                                                        {
                                                        	x:250,
                                                            y:15,
                                                            width:400,
                                                            cls:'controlSIUGJ',
                                                            xtype:'textfield',
                                                            value:(nCarpetaSel)? nCarpetaSel.attributes.text:'',
                                                            id:'txtNombreCuadernillo'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:70,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Perfil de acceso:'
                                                        },
                                                        {
                                                        	x:250,
                                                            y:65,
                                                            html:'<div id="divPerfil"></div>'
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Crear Cuadernillo',
										width: 700,
										height:230,
										layout: 'fit',
										plain:true,
										modal:true,
										bodyStyle:'padding:5px;',
										buttonAlign:'center',
                                        cls:'msgHistorialSIUGJ',
										items: form,
										listeners : {
													show : {
																buffer : 10,
																fn : function() 
																{
                                                                	gEx('txtNombreCuadernillo').focus(500,false);
                                                                    
                                                                    var cmbPerfilAccesoCuadernillo=crearComboExt('cmbPerfilAccesoCuadernillo',arrPerfilesAcceso,0,0,350,{ctCls:'comboWrapSIUGJControl',cls:'comboSIUGJControl',listClass:'listComboSIUGJControl',renderTo:'divPerfil'});
                                                                    if(nCarpetaSel)
                                                                    {
                                                                    	cmbPerfilAccesoCuadernillo.setValue(nCarpetaSel.attributes.idPerfilAcceso);
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
																		var txtNombreCuadernillo=gEx('txtNombreCuadernillo');
                                                                        if(txtNombreCuadernillo.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	txtNombreCuadernillo.focus();
                                                                            }
                                                                            msgBox('Debe indicar el nombre del cuadernillo a agregar',resp);
                                                                            return;
                                                                            
                                                                        }
                                                                        
                                                                        var cmbPerfilAccesoCuadernillo=gEx('cmbPerfilAccesoCuadernillo');
                                                                        if(cmbPerfilAccesoCuadernillo.getValue()=='')
                                                                        {
                                                                        	function resp2()
                                                                            {
                                                                            	cmbPerfilAccesoCuadernillo.focus();
                                                                            }
                                                                            msgBox('Debe indicar el perfil de acceso a aplicar al cuadernillo',resp2);
                                                                            return;
                                                                        }
                                                                        
                                                                        if(nCarpetaSel)
                                                                        {
                                                                        
                                                                        	function respConf(btn)
                                                                            {
                                                                        		if(btn=='yes')
                                                                                {
                                                                                    var datosExpediente=nCarpetaSel.id.split('_');
                                                                                    
                                                                                    var cadObj='{"carpetaAdministrativa":"'+datosExpediente[0]+'","idCarpetaAdministrativa":"'+
                                                                                                datosExpediente[1]+'","nombreCarpeta":"'+cv(txtNombreCuadernillo.getValue())+
                                                                                                '","idPerfilAcceso":"'+cmbPerfilAccesoCuadernillo.getValue()+'"';
                                                                                                
                                                                                    if(cmbPerfilAccesoCuadernillo.getValue()!=nCarpetaSel.attributes.idPerfilAcceso)
                                                                                    {
                                                                                        function respPermisos(btn)
                                                                                        {
                                                                                            if(btn=='yes')
                                                                                            {
                                                                                                cadObj+=',"modificarPerfilContenido":"1"}';
                                                                                            }
                                                                                            else
                                                                                            {
                                                                                                cadObj+=',"modificarPerfilContenido":"0"}';
                                                                                            }
                                                                                            
                                                                                            function funcAjax()
                                                                                            {
                                                                                                var resp=peticion_http.responseText;
                                                                                                arrResp=resp.split('|');
                                                                                                if(arrResp[0]=='1')
                                                                                                {
                                                                                                    gEx('arbolCarpetas').getRootNode().reload();
                                                                                                    ventanaAM.close();
                                                                                                }
                                                                                                else
                                                                                                {
                                                                                                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                                }
                                                                                            }
                                                                                            obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=403&cadObj='+cadObj,true);
                                                                                        }
                                                                                        msgConfirm('¿Desea aplicar el perfil '+cmbPerfilAccesoCuadernillo.getRawValue()+
                                                                                                    ' a todos los documentos contenidos en el cuadernillo?',respPermisos);
                                                                                        
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                        cadObj+=',"modificarPerfilContenido":"0"}';
                                                                                        function funcAjax()
                                                                                        {
                                                                                            var resp=peticion_http.responseText;
                                                                                            arrResp=resp.split('|');
                                                                                            if(arrResp[0]=='1')
                                                                                            {
                                                                                                gEx('arbolCarpetas').getRootNode().reload();
                                                                                                ventanaAM.close();
                                                                                            }
                                                                                            else
                                                                                            {
                                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                            }
                                                                                        }
                                                                                        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=403&cadObj='+cadObj,true);
                                                                                    }
                                                                        		}
                                                                            }
                                                                            msgConfirm('¿Est&aacute; seguro de querer modificar la informaci&oacute;n del cuadernillo?',respConf)

                                                                        }
                                                                        else
                                                                        {
                                                                            var cadObj='{"carpetaAdministrativa":"'+gE('carpetaAdministrativa').value+'","idCarpetaAdministrativa":"'+gE('idCarpetaAdministrativaForced').value+
                                                                                        '","carpetaRelacionada":"'+cv(txtNombreCuadernillo.getValue())+
                                                                                        '","tipoCarpeta":"1","idPerfilAcceso":"'+cmbPerfilAccesoCuadernillo.getValue()+'"}';
                                                                            
                                                                            
                                                                            if((nodoCarpetaSel.attributes.tipoRelacion)&&(nodoCarpetaSel.attributes.tipoRelacion=='6'))
                                                                            {
                                                                            	var arrNodo=nodoCarpetaSel.id.split('_');
                                                                            	cadObj='{"carpetaAdministrativa":"'+arrNodo[0]+
                                                                                		'","idCarpetaAdministrativa":"'+arrNodo[1]+
                                                                                        '","carpetaRelacionada":"'+cv(txtNombreCuadernillo.getValue())+
                                                                                        '","tipoCarpeta":"11"}';
                                                                            }
                                                                            
                                                                            
                                                                            function funcAjax()
                                                                            {
                                                                                var resp=peticion_http.responseText;
                                                                                arrResp=resp.split('|');
                                                                                if(arrResp[0]=='1')
                                                                                {
                                                                                    gEx('arbolCarpetas').getRootNode().reload();
                                                                                    ventanaAM.close();
                                                                                }
                                                                                else
                                                                                {
                                                                                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                }
                                                                            }
                                                                            obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=402&cadObj='+cadObj,true);
                                                                        
																		}
                                                                    }
														}
													]
									}
								);
	ventanaAM.show();	
}

function mostrarVentanaMetaDato1()
{
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'border',
											defaultType: 'label',
											items: 	[
                                            			crearGridTipoDocumental()
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Captura de Información de Documento',
										width: 700,
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
															
															text: 'Siguiente >>',
                                                            
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
}


function crearGridTipoDocumental()
{
	var cmbTipoDocumental=crearComboExt('cmbTipoDocumental',arrCategorias,0,0);
	var dsDatos=	[
    					['documento.pdf',''],
                        ['documento.pdf',''],
    				];
    var alDatos=	new Ext.data.SimpleStore	(
                                                    {
                                                        fields:	[
                                                                    {name: 'nombreDocumento'},
                                                                    {name: 'tipoDocumental'}
                                                                ]
                                                    }
                                                );

    alDatos.loadData(dsDatos);
	var chkRow=new Ext.grid.CheckboxSelectionModel();
	
	var cModelo= new Ext.grid.ColumnModel   	(
												 	[
													 	new  Ext.grid.RowNumberer(),
														
														{
															header:'Nombre del Documento',
															width:250,
															sortable:true,
															dataIndex:'nombreDocumento'
														},
														{
															header:'Tipo Documental',
															width:300,
															sortable:true,
															dataIndex:'tipoDocumental',
                                                            renderer:function(val)
                                                            		{
                                                                    	return formatearValorRenderer(arrCategorias,val);
                                                                    },
                                                            editor:cmbTipoDocumental
														}
													]
												);
                                                
	var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                        {
                                                            
                                                            store:alDatos,
                                                            frame:false,
                                                            region:'center',
                                                            cm: cModelo,
                                                            clicksToEdit:1,
                                                            stripeRows :true,
                                                            loadMask:true,
                                                            stripeRows :true,                                                            
                                                            columnLines : true,
                                                            sm:chkRow
                                                        }
                                                    );
	return 	tblGrid;
}


function mostrarVentanaRegistrosExpediente()
{
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'border',
                                            frame:false,
											defaultType: 'label',
											items: 	[
														crearGridHistorialExpediente()

													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Auditoria',
										width: 900,
                                        cls:'msgHistorialSIUGJ',
										height:450,
										layout: 'fit',
										plain:true,
										modal:true,
                                        shadow:false,
                                        closable:false,
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
                                                            cls:'btnSIUGJ',
                                                            width:160,
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

function crearGridHistorialExpediente()
{
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idRegistro'},
                                                        {name:'fechaOperacion', type:'date', dateFormat:'Y-m-d H:i:s'},
                                                        {name:'responsable'},
                                                        {name: 'comentarios'},
                                                        {name: 'carpetaAdmnistrativa'}
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
                                    	proxy.baseParams.funcion='405';
                                        proxy.baseParams.carpetaAdminsitrativa=gE('carpetaAdministrativa').value;
                                        proxy.baseParams.idCarpeta=gE('idCarpetaAdministrativaForced').value;
                                        
                                    }
                        )   
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer({width:40}),
                                                            {
                                                                header:'Fecha',
                                                                width:210,
                                                                sortable:false,
                                                                menuDisabled :true,
                                                                align:'center',
                                                                dataIndex:'fechaOperacion',
                                                                renderer:function(val,meta,attr)
                                                                		{
                                                                        	meta.attr='style="height:auto;"';
                                                                        	return formatoTitulo(val.format('d')+' de '+arrMeses[parseInt(val.format('m'))-1][1]+' de '+val.format('Y')+'<br>'+val.format('H:i:s')+' hrs.');
                                                                        }
                                                            },
                                                            {
                                                                header:'Carpeta Afectada',
                                                                width:220,
                                                                menuDisabled :true,
                                                                sortable:false,
                                                                dataIndex:'carpetaAdmnistrativa',
                                                                renderer:formatoTitulo2Auditoria
                                                            },                                                          
                                                            {
                                                                header:'Responsable',
                                                                width:360,
                                                                menuDisabled :true,
                                                                sortable:false,
                                                                dataIndex:'responsable',
                                                                renderer:formatoTitulo3Auditoria
                                                            }
                                                            
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.GridPanel	(
                                                    {
                                                        id:'gridHistorialAuditoria',
                                                        store:alDatos,
                                                        region:'center',
                                                        frame:false,
                                                        border:true,
                                                        cm: cModelo,
                                                        columnLines : false,
                                                        stripeRows :true,
                                                        loadMask:true,
                                                        cls:'gridSiugjSeccion',                                                                
                                                        view:new Ext.grid.GroupingView({
                                                                                            forceFit:false,
                                                                                            showGroupName: false,
                                                                                            enableGrouping :false,
                                                                                            enableNoGroups:false,
                                                                                            enableGroupingMenu:false,
                                                                                            hideGroupedColumn: false,
                                                                                            startCollapsed:false,
                                                                                            enableRowBody:true,
                                                                                            getRowClass : formatearFilaHistorialAuditoria
                                                                                        })
                                                    }
                                                );
        return 	tblGrid;	
}

function formatearFilaHistorialAuditoria(record, rowIndex, p, ds)
{
	var xf = Ext.util.Format;
    p.body = '<BR><p style="margin-left: 4em;margin-right: 4em;text-align:justify"><br><span class="letraInfoHistorialSIUGJ">Comentarios:<br><br>' + ((record.data.comentarios.trim()=="")?"(Sin comentarios)":record.data.comentarios) + '<span></p><br><br><br>';
    return 'x-grid3-row-expanded';
}

function formatoTituloAuditoria(val)
{
	return '<span class="letraInfoHistorialSIUGJ">'+val+'</span>';
}

function formatoTitulo2Auditoria(val)
{
	return '<div class="letraInfoHistorialSIUGJ">'+val+'</div>';
}

function formatoTitulo3Auditoria(val)
{
	return '<div class="letraInfoHistorialSIUGJ">'+(val)+'</div>';
}


function mostrarVentanaMovimientoElemento(nodoDestino,data)
{

	var nombreElemento=data.grid?data.selections[0].data.nomArchivoOriginal:data.node.text;
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
                                                        	html:'Elemento a Mover:'
                                                        },
                                                        {
                                                        	x:130,
                                                            y:15,
                                                            cls:'SIUGJ_ControlEtiqueta',
                                                        	html:+nombreElemento
                                                        },
                                                        {
                                                        	x:10,
                                                            y:60,
                                                            cls:'SIUGJ_Etiqueta',
                                                        	html:'Carpeta Destino:'
                                                        },
                                                        {
                                                        	x:130,
                                                            y:60,
                                                            cls:'SIUGJ_ControlEtiqueta',
                                                        	html:+nodoDestino.text
                                                        },
                                                        {
                                                        	x:10,
                                                            y:100,
                                                            id:'chkCopia',
                                                            xtype:'checkbox',
                                                            disabled:!data.grid,
                                                            ctCls:'SIUGJ_Etiqueta',
                                                        	boxLabel:'Crear una copia'
                                                        },
                                                        {
                                                        	x:10,
                                                        	y:140,
                                                            cls:'SIUGJ_Etiqueta',
                                                            html:'Ingrese el motivo de la operaci&oacute;n:'
                                                        },
                                                        {
                                                        	xtype:'textarea',
                                                            width:600,
                                                            height:60,
                                                            x:10,
                                                            y:170,
                                                            cls:'controlSIUGJ',
                                                            id:'txtMotivo'
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Mover Elemento',
										width: 660,
										height:330,
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
                                                                	gEx('txtMotivo').focus(false,500);
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
                                                                    	var txtMotivo=gEx('txtMotivo').getValue();
                                                                        if(txtMotivo=='')
                                                                        {
                                                                            function resp3()
                                                                            {
                                                                                gEx('txtMotivo').focus();
                                                                            }
                                                                            msgBox('Debe ingresar el motivo del cambio',resp3);
                                                                            return;
                                                                        }
																		function resp(btn)
                                                                        {
                                                                        	if(btn=='yes')
                                                                            {
                                                                            	
                                                                                
                                                                                var elementoOperacion='';
                                                                                if(data.grid)
                                                                                {
                                                                                	elementoOperacion=data.selections[0].data.idRegistroContenido;
                                                                                }
                                                                                else
                                                                                {
                                                                                	elementoOperacion=data.node.id;
                                                                                }
                                                                            	var cadObj='{"copia":"'+(gEx('chkCopia').getValue()?1:0)+'","elementoOperacion":"'+elementoOperacion+'","tipoElemento":"'+(data.grid?'r':'n')+'","elementoDestino":"'+nodoDestino.id+'","motivoCambio":"'+cv(txtMotivo)+'"}';
                                                                            	function funcAjax()
                                                                                {
                                                                                    var resp=peticion_http.responseText;
                                                                                    arrResp=resp.split('|');
                                                                                    if(arrResp[0]=='1')
                                                                                    {
                                                                                        function resp2()
                                                                                        {
                                                                                        	gEx('arbolCarpetas').getRootNode().reload();
                                                                                            ventanaAM.close();
                                                                                        }
                                                                                        msgBox('La operaci&oacute;n ha sido registrada exitosamente',resp2);
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                                    }
                                                                                }
                                                                                obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=406&cadObj='+cadObj,true);
                                                                                
                                                                                
                                                                            }
                                                                        }
                                                                        msgConfirm('Est&aacute; seguro de querer mover el elemento <b>'+nombreElemento+'</b> hacia la carpeta <b>'+nodoDestino.text+'?</b>',resp);
																	}
														}
														
													]
									}
								);
	ventanaAM.show();	
}


var regMetaDato=crearRegistro	(
										[
                                            {name:'idRegistro'},
                                            {name: 'idPropiedad'},
                                            {name:'valor'},
                                            {name:'nombreDocumento'}
                                        ]
									);

function mostrarVentanaMetadaDataDocumentos()
{
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'border',
											defaultType: 'label',
											items: 	[
                                            			crearGridMetadatos()
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Registro de Meta Data',
										width: 800,
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
                                                                    	var gMetaDatos=gEx('gMetaDatos');
                                                                        var oReg={};
                                                                        var x;
                                                                        var fila;
                                                                        var r;
                                                                        var reg;
                                                                        for(x=0;x<uploader.files.length;x++)
                                                                        {
                                                                        	fila=uploader.files[x];
                                                                            
                                                                            
                                                                            var pos=existeValorArregloObjetos(arrObjetosMetaData,'idDocumento',fila.id);
                                                                            
                                                                            if(pos>-1)
                                                                            {
                                                                            	var objRegistro=arrObjetosMetaData[pos];
                                                                                for(x=0;x<objRegistro.metaData.length;x++)
                                                                                {
                                                                                	reg=objRegistro.metaData[x];
                                                                               		gMetaDatos.getStore().add(reg);
                                                                                }                                                             
                                                                                                                                                    
                                                                            }
                                                                            else
                                                                            {
                                                                                oReg={};
                                                                                oReg.idRegistro=fila.id;
                                                                                oReg.idPropiedad='0';
                                                                                oReg.valor='';
                                                                                oReg.nombreDocumento=fila.name;
                                                                                oReg.arrOpciones=arrCategorias;
                                                                                oReg.obligatorio='1';  
                                                                                oReg.tipoEntrada='0';  
                                                                                oReg.idDocumento =oReg.idRegistro;                                                                         
                                                                                r=new regMetaDato(oReg);
                                                                                gMetaDatos.getStore().add(r);
                                                                            }
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
																		var fila;
                                                                        var x;
                                                                        arrObjetosMetaData=[];
                                                                        
                                                                        var gMetaDatos=gEx('gMetaDatos');
                                                                        
                                                                        for(x=0;x<gMetaDatos.getStore().getCount();x++)
                                                                        {
                                                                        	fila=gMetaDatos.getStore().getAt(x);
                                                                            
                                                                            if((fila.data.obligatorio=='1')&&(fila.data.valor==''))
                                                                            {
                                                                            
                                                                            	function resp()
                                                                                {
                                                                                	
                                                                                	gMetaDatos.startEditing(x,2);
                                                                                }
                                                                            	msgBox('Debe ingresar el valor del meta dato:<br>"'+formatearValorRenderer(arrConfMetaDatos,fila.data.idPropiedad)+
                                                                                		'"<br>Documento: '+fila.data.nombreDocumento+'',resp);
                                                                            	return;
                                                                            }
                                                                            
                                                                            var objRegistro={};
                                                                            var pos=existeValorArregloObjetos(arrObjetosMetaData,'idDocumento',fila.data.idDocumento);
                                                                            if(pos==-1)
                                                                            {
                                                                            	objRegistro={};
                                                                                objRegistro.idDocumento=fila.data.idDocumento;
                                                                                objRegistro.nombreDocumento=fila.data.nombreDocumento;
                                                                                objRegistro.metaData=[];
                                                                                objRegistro.metaData.push(fila);
                                                                                arrObjetosMetaData.push(objRegistro);
                                                                            }
                                                                            else
                                                                            {
                                                                            	objRegistro=arrObjetosMetaData[pos];
                                                                                objRegistro.metaData.push(fila);
                                                                            }
                                                                            
                                                                            
                                                                            
                                                                            
                                                                        }
                                                                        
                                                                        uploader.start();
                                                                        ventanaAM.close();
                                                                        
																	}
														}
														
													]
									}
								);
	ventanaAM.show();	

}

function crearGridMetadatos()
{
	
	var lector= new Ext.data.JsonReader({
                                            
                                            totalProperty:'numReg',
                                            fields: [
                                               			{name:'idRegistro'},
		                                                {name: 'idPropiedad'},
		                                                {name:'valor'},
                                                        {name:'obligatorio'},
                                                        {name:'nombreDocumento'},
                                                        {name:'arrOpciones'},
                                                        {name:'tipoEntrada'},
                                                        {name:'idDocumento'}
                                            		],
                                            root:'registros'
                                            
                                        }
                                      );
	 
                                                                                      
	var alDatos=new Ext.data.GroupingStore({
                                                            reader: lector,
                                                            proxy : new Ext.data.HttpProxy	(

                                                                                              {

                                                                                                  url: '../paginasFunciones/funcionesAlmacen.php'

                                                                                              }

                                                                                          ),
                                                            sortInfo: {field: 'nombreDocumento', direction: 'ASC'},
                                                            groupField: 'nombreDocumento',
                                                            remoteGroup:false,
				                                            remoteSort: false,
                                                            autoLoad:false
                                                            
                                                        }) 
	
       
        var cModelo= new Ext.grid.ColumnModel   	(
                                                        [
                                                            new  Ext.grid.RowNumberer({width:40}),
                                                            
                                                            {
                                                                header:'Meta Dato',
                                                                width:280,
                                                                sortable:true,
                                                                dataIndex:'idPropiedad',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	if(val=='0')
                                                                            {
                                                                            	return '<b>'+formatearValorRenderer(arrConfMetaDatos,val)+'</b>'+(registro.data.obligatorio=='1'?' <span style="color:#F00">*</span>':'');
                                                                            }
                                                                            else
                                                                        		return formatearValorRenderer(arrConfMetaDatos,val)+(registro.data.obligatorio=='1'?' <span style="color:#F00">*</span>':'');
                                                                        }
                                                            },
                                                            {
                                                                header:'Valor',
                                                                width:370,
                                                                sortable:true,
                                                                dataIndex:'valor',
                                                                editor:{xtype:'textfield'},
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	
                                                                        	var lblVal='';
                                                                        	if(registro.data.idPropiedad=='0')
                                                                            {
                                                                            	lblVal='<a href="javascript:asignarTipoDocumental(\''+bE(registro.data.idRegistro)+'\')"><img width="14" height="14" src="../images/pencil.png" title="Asignar Tipo Documental" alt="Asignar Tipo Documental"></a>';    
                                                                            }
                                                                            if(registro.data.arrOpciones.length>0)
                                                                            {
                                                                            	if(lblVal=='')
	                                                                            	lblVal=formatearValorRenderer(registro.data.arrOpciones,val);
                                                                                 else
                                                                                 	lblVal+=' '+formatearValorRenderer(registro.data.arrOpciones,val);
                                                                            }
                                                                            else
                                                                            {
                                                                            	
                                                                                switch(parseInt(registro.data.tipoEntrada))
                                                                                {
                                                                                    case 1:
                                                                                        return escaparEnter(val);
                                                                                    break;
                                                                                    case 2:
                                                                                        return val;
                                                                                    break;
                                                                                    case 3:
                                                                                        return val;
                                                                                    break;
                                                                                    case 4:
                                                                                        return Ext.util.Format.usMoney(val);
                                                                                    break;
                                                                                    case 5:
                                                                                       	if(val!='')
                                                                                        	return val.format('d/m/Y');
                                                                                    break;
                                                                                    case 6:
                                                                                        return val;
                                                                                    break;
                                                                               
                                                                                }
                                                                                
                                                                                	
                                                                            }
                                                                            return (registro.data.idPropiedad=='0')?'<b>'+lblVal+'</b>':lblVal;
                                                                        }
                                                            },
                                                            {
                                                                header:'Documento',
                                                                width:250,
                                                                sortable:true,
                                                                dataIndex:'nombreDocumento',
                                                                renderer:function(val,meta,registro)
                                                                		{
                                                                        	
                                                                        	return 'Nombre del Documento: '+val;
                                                                        }
                                                                
                                                               
                                                            }
                                                        ]
                                                    );
                                                    
        var tblGrid=	new Ext.grid.EditorGridPanel	(
                                                            {
                                                                id:'gMetaDatos',
                                                                store:alDatos,
                                                                region:'center',
                                                                frame:false,
                                                                clicksToEdit:1,
                                                                cm: cModelo,
                                                                cls:'gridSiugjPrincipal gridSiugjExpediente',
                                                                stripeRows :false,
                                                                loadMask:true,
                                                                columnLines : false,                                                                
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
                                	var ctrl=null;
                                	
                                    switch(parseInt(e.record.data.tipoEntrada))
                                    {
                                        case 1:
                                            ctrl=new Ext.form.TextArea (
                                                                            {
                                                                                height:40,
                                                                                cls:'controlSIUGJ'
                                                                            }
                                                                        )
                                        break;
                                        case 2:
                                            ctrl=new Ext.form.NumberField (
                                                                            {
                                                                                allowDecimals:false,
                                                                                cls:'controlSIUGJ'
                                                                            }
                                                                        )
                                        break;
                                        case 3:
                                            ctrl=new Ext.form.NumberField (
                                                                            {
                                                                                allowDecimals:true,
                                                                                cls:'controlSIUGJ'
                                                                            }
                                                                        )
                                        break;
                                        case 4:
                                            ctrl=new Ext.form.NumberField (
                                                                            {
                                                                                allowDecimals:true,
                                                                                cls:'controlSIUGJ'
                                                                            }
                                                                        )
                                        break;
                                        case 5:
                                            ctrl=new Ext.form.DateField ({ctCls:'campoFechaSIUGJ'});
                                        break;
                                        case 6:
                                            ctrl=new Ext.form.TextField ({cls:'controlSIUGJ'});
                                        break;
                                        default:
                                            if((e.record.data.arrOpciones.length>0)&&(e.record.data.idPropiedad!='0'))
                                            {
                                                ctrl=crearComboExt('cmbEditor',e.record.data.arrOpciones,0,0,null,{transform:false,ctCls:'comboWrapSIUGJGrid',cls:'comboSIUGJGrid',listClass:'listComboSIUGJGrid listComboSIUGJGridExpediente'});
                                            }
                                        break;
                                   
                                    }
                                    
                                    if(ctrl)
	                                	e.grid.getColumnModel().setEditor(2,ctrl);
                                    else
                                    	e.cancel=true;
                                }
        			)                                                        
                                                        
		
        return 	tblGrid;
}

function asignarTipoDocumental(id)
{
	var idTipoDocumento=-1;
	var oConf=	{
    					idCombo:'cmbTipoDocumental',
                        anchoCombo:400,
                        
                        renderTo:'divTipoDocumental',
                        ctCls:'campoComboWrapSIUGJAutocompletar',
                        listClass:'listComboSIUGJ',
                        raiz:'registros',
                        campoDesplegar:'nombreDocumento',
                        campoID:'idTipoDocumento',
                        funcionBusqueda:32,
                        paginaProcesamiento:'../modulosEspeciales_SGJ/paginasFunciones/funcionesModulosEspeciales_SGJ.php',
                        confVista:'<tpl for="."><div class="search-item">{nombreDocumento}<br></div></tpl>',
                        campos:	[
                                   	{name:'idTipoDocumento'},
                                    {name:'nombreDocumento'}

                                ],
                       	funcAntesCarga:function(dSet,combo)
                    				{
                                    	idTipoDocumento=-1;
                                    	var aValor=combo.getRawValue();
										dSet.baseParams.criterio=aValor;
                                        
                                                                              
                                        
                                    },
                      	funcElementoSel:function(combo,registro)
                        				{
                                        	idTipoDocumento=registro.data.idTipoDocumento;
                                            
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
                                                            html:'Tipo Documental:'
                                                        },
                                                        {
                                                        	x:180,
                                                            y:15,
                                                            html:'<div id="divTipoDocumental" style="width:410px"></div>'
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Asignaci&oacute;n de Tipo Documental',
										width: 650,
										height:180,
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
                                                                	var cmbTipoDocumental=crearComboExtAutocompletar(oConf);
                                                                	gEx('cmbTipoDocumental').focus(false,500);
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
																		if(idTipoDocumento==-1)
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	gEx('cmbTipoDocumental').focus(false,500);
                                                                            }
                                                                        	msgBox('Debe indicar el tipo documental a asignar',resp);
                                                                        	return;
                                                                        }
                                                                        
                                                                        var pos=obtenerPosFila(gEx('gMetaDatos').getStore(),'idRegistro',bD(id));
                                                                        var gMetaDatos=gEx('gMetaDatos');
                                                                        var fila;
                                                                        var filaMeta=gMetaDatos.getStore().getAt(pos);
                                                                        filaMeta.set('valor',idTipoDocumento);
                                                                        var arrFilasTmp=[];
                                                                        var arrFilasAux=[];
                                                                        
                                                                        var x;
                                                                        for(x=0;x<gMetaDatos.getStore().getCount();x++)
                                                                        {
                                                                        	fila=gMetaDatos.getStore().getAt(x);
                                                                            if((fila.data.idPropiedad!='0')&&(fila.data.nombreDocumento==filaMeta.data.nombreDocumento))
                                                                            {
                                                                            	arrFilasTmp.push(fila);
                                                                                arrFilasAux.push(fila.copy());
                                                                            }
                                                                        }
                                                                        
                                                                        //arrPerfilMetadato
                                                                        gMetaDatos.getStore().remove(arrFilasTmp);
                                                                        var posFilaTipoDato=existeValorMatriz(arrCategorias,idTipoDocumento);
                                                                        var posFilaPerfil=existeValorMatriz(arrPerfilMetadato,arrCategorias[posFilaTipoDato][2]);
                                                                        var perfil=arrPerfilMetadato[posFilaPerfil];
                                                                        for(x=0;x<perfil[2].length;x++)
                                                                        {
                                                                        	fila=perfil[2][x];
                                                                        	pos=existeValorMatriz(arrConfMetaDatos,fila[0]);
                                                                        
                                                                            oReg={};
                                                                            oReg.idRegistro=bD(id)+'_'+fila[0];
                                                                            oReg.idPropiedad=fila[0];
                                                                            
                                                                            oReg.arrOpciones=arrConfMetaDatos[pos][3];
                                                                            oReg.nombreDocumento=filaMeta.data.nombreDocumento;
                                                                            oReg.obligatorio=fila[1];  
                                                                            oReg.tipoEntrada=arrConfMetaDatos[pos][2];
                                                                            oReg.idDocumento=bD(id);
                                                                            pos=existeValorArregloObjetos(arrFilasAux,'data.idPropiedad', oReg.idPropiedad);
                                                                            if(pos>-1)
                                                                            {
                                                                            	oReg.valor=arrFilasAux[pos].data.valor;
                                                                            }
                                                                            else
                                                                                oReg.valor='';
                                                                                                                                                    
                                                                            r=new regMetaDato(oReg);
                                                                         	gMetaDatos.getStore().add(r);
                                                                            
                                                                        }
                                                                        gMetaDatos.getStore().sort('nombreDocumento','ASC');
                                                                        gMetaDatos.getView().refresh();
                                                                        ventanaAM.close();
                                                                        
																	}
														}
														
													]
									}
								);
	ventanaAM.show();
}

function abrirVideoConferencia(url)
{
	window.open(bD(url), '_blank');

}

function obtenerMunicipiosCParticipante_C(cmb,registro,funcAfterLoad)
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            var arrDatos=eval(arrResp[1]);
            gEx('cmbMunicipioCParticipante_C').setValue('');
            gEx('cmbMunicipioCParticipante_C').getStore().loadData(arrDatos);
            if(funcAfterLoad)
            	funcAfterLoad();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=89&cveEstado='+registro.data.id,true);
    
}

function tipoPersonaComboCP_C(combo,registro)
{
	gEx('lblErrorCedula_1_C').hide();
    gEx('lblErrorCedula_2_C').hide();
    gEx('lblErrorCedula_3_C').hide();
    gEx('lblErrorCedula_4_C').hide();
    gEx('lblErrorCedula_5_C').hide();
    gEx('lblErrorCedula_6_C').hide();
    
	
	switch(registro.data.id)
    {
        case '1':

            gEx('lblTipoEntidad_C').hide();
            gEx('cmbTipoEntidad_C').setValue('');
            gEx('divTipoEntidad_C').hide();
            

            gEx('lblDivComboIdentificacion_C').show();
            gEx('lblNombre_C').show();
            gEx('lblRazonSocial_C').hide();

            gEx('txtRazonSocial_C').setValue('');
            gEx('txtRazonSocial_C').hide();

            gEx('txtNombre_C').show();
            gEx('txtApPaterno_C').show();
            gEx('txtApMaterno_C').show();
            gEx('lblApPaterno_C').show();
            gEx('lblApMaterno_C').show();
            
           	gEx('tblPersona_C').unhideTabStripItem(1);
                
                

            gEx('cmbIdentificacion_C').show();
            gEx('txtEspecifique_C').show();
            gEx('lblIdentificacion_C').setText('Tipo de identificaci&oacute;n: <span style="color:#F00">*</span>',false);
            gEx('lblIdentificacion_C').setPosition(10,120);
            gEx('lblNoIdentificacion_C').show();
            gEx('lblSinDigito_C').hide();
            gEx('txtNIT_C').hide();
            gEx('txtNIT_C').setValue('');  
           	gEx('txtNombre_C').focus();
            
            gEx('lblFechaExpedicion_C').show();
            gEx('lblValFechaExpedicion_C').show();
            gEx('divFechaDocumento_C').show();
            
            if(nodoSujetoSel.attributes.personaJuridica=='5')
            {
            
                gEx('lblTarjetaProfesional_C').show();
                gEx('txtTarjetaProfesional_C').show();
			}            

        break;
        case '2':


            gEx('lblDivComboIdentificacion_C').hide();
            gEx('txtRazonSocial_C').show();
            gEx('divTipoEntidad_C').show();
            gEx('cmbTipoEntidad_C').setValue('2');

            gEx('lblTipoEntidad_C').show();
            gEx('lblNombre_C').hide();
            gEx('lblRazonSocial_C').show();
            
            gEx('txtNombre_C').hide();
            gEx('txtApPaterno_C').hide();
            gEx('txtApMaterno_C').hide();
            
            gEx('txtNombre_C').setValue('');
            gEx('txtApPaterno_C').setValue('');
            gEx('txtApMaterno_C').setValue('');
            gEx('cmbGenero_C').setValue('');
            
            gEx('lblApPaterno_C').hide();
            gEx('lblApMaterno_C').hide();
            gEx('fechaNacimiento_C').setValue('');
            gEx('txtEdad_C').setValue('');
            
            gEx('cmbIdentificacion_C').hide();
            gEx('cmbIdentificacion_C').setValue('');
            gEx('txtEspecifique_C').hide();
            gEx('txtEspecifique_C').setValue('');
            
            gEx('txtEspecifique_C').ultimaValidacion='';
            gEx('txtEspecifique_C').ultimaBusqueda='';
            gEx('lblIdentificacion_C').setText('N&uacute;mero de Identificaci&oacute;n Tributaria (NIT): <span style="color:#F00">*</span>',false);
            gEx('lblIdentificacion_C').setPosition(10,170);
            gEx('lblNoIdentificacion_C').hide();
            gEx('txtNIT_C').show();
            gEx('txtNIT_C').focus();
            gEx('lblSinDigito_C').show();
            gEx('tblPersona_C').hideTabStripItem(1);
            
            
            gEx('lblFechaExpedicion_C').hide();
            gEx('lblValFechaExpedicion_C').hide();
            gEx('divFechaDocumento_C').hide();
            gEx('lblTarjetaProfesional_C').hide();
            gEx('txtTarjetaProfesional_C').hide();
        break;
        
    }
    
}


function guardarDatosPersona()
{
	var campoComp='';
    campoComp=',"idPersona":"'+nodoSujetoSel.attributes.idPersona+'"';
    
    var listaRelacion='';
    var arrNodos=obtenerNodoChecados(gEx('arbolSujetosRelacion_C').getRootNode());
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
    var personaMoral=gEx('cmbTipoPersona_C').getValue()=='2';
    var tipoIdentificacion='';
    
    
    var tipoIdentificacion=gEx('cmbIdentificacion_C').getValue();
    var folioIdentificacion=gEx('txtEspecifique_C').getValue();
    
    var cadObj='';
    if(personaMoral)
    {
    
        
        if(!validarNIT(gEx('txtNIT_C').getValue(),'14'))
        {
            
            return false;
        }
        
        tipoIdentificacion=14;
        folioIdentificacion=gEx('txtNIT_C').getValue();
            
                          
                                                                
        if(gEx('txtRazonSocial_C').getValue()=='')
        {
            function resp30()
            {
                 gEx('tblPersona_C').setActiveTab(0);
                gEx('txtRazonSocial_C').focus();
            }
            msgBox('Debe indicar la raz&oacute;n social de la persona jur&iacute;dica',resp30);
            return;
        }
        
        var aceptaNotificacionMail='0';
        if(gEx('aceptaNotificacion_1_C').getValue())
        {
            aceptaNotificacionMail='1';
        }
        
        var cmbTipoEntidad=gEx('cmbTipoEntidad_C');
        
        if(cmbTipoEntidad.getValue()=='')
        {
            function resp301()
            {
                 gEx('tblPersona_C').setActiveTab(0);
                gEx('cmbTipoEntidad_C').focus();
            }
            msgBox('Debe indicar el tipo de entidad de la persona jur&iacute;dica',resp301);
            return;
        }
        
        var cmbGrupoEtnico=gEx('cmbGrupoEtnico_C');
        var cmbDiscapacidad=gEx('cmbDiscapacidad_C');
        var cmbTipoEntidad=gEx('cmbTipoEntidad_C');
       	cadObj='{"grupoEtnico":"'+cmbGrupoEtnico.getValue()+'","discapacidad":"'+cmbDiscapacidad.getValue()+
                '","aceptaNotificacionMail":"'+aceptaNotificacionMail+'","rfc":"'+cv(gEx('txtNIT_C').getValue())+
                '","datosContacto":@datosContacto,"detallePersona":"","tipoPersona":"2","nombre":"'+cv(gEx('txtRazonSocial_C').getValue())+
                '","apPaterno":"","apMaterno":"","genero":"2","otraNacionalidad":"","nacionalidadMexicana":"3",'+
                '"nacionalidad":"","alias":[],"fechaNacimiento":"'+
                (gEx('fechaNacimiento_C').getValue()==''?'':gEx('fechaNacimiento_C').getValue().format('Y-m-d'))+
                '","edad":"'+gEx('txtEdad_C').getValue()+'","identificacionPresentada":"'+
                tipoIdentificacion+'","tipoFigura":"'+tipoParticipante+'","otraIdentificacion":"'+cv(folioIdentificacion)+'","relacionadoCon":"'+listaRelacion+'"'+
                ',"fechaIdentificacion":"","tarjetaProfesional":"","tipoEntidad":"'+cmbTipoEntidad.getValue()+
                '","idActividad":"'+idActividadCarpeta+'","idCarpeta":"<?php echo $idCarpetaAdministrativa?>"'+campoComp+'}';
    }
    else
    {
        var cmbIdentificacion=gEx('cmbIdentificacion_C');
    
        tipoIdentificacion=cmbIdentificacion.getValue();
        if(cmbIdentificacion.getValue()=='')
        	tipoIdentificacion='13';
                
                
        if(gEx('txtEspecifique_C').isVisible() && (!gEx('txtEspecifique_C').disabled) && gEx('txtEspecifique_C').getValue()=='')
        {
            function resp300()
            {
                gEx('tblPersona_C').setActiveTab(0);
                gEx('txtEspecifique_C').focus();
            }
            msgBox('Debe indicar el n&uacute;mero de identificaci&oacute;n',resp300);
            return;
        }
        
        
        if(gEx('txtTarjetaProfesional_C').isVisible() && (!gEx('txtTarjetaProfesional_C').disabled) && gEx('txtTarjetaProfesional_C').getValue()=='')
        {
            function resp3001()
            {
                gEx('tblPersona_C').setActiveTab(0);
                gEx('txtTarjetaProfesional_C').focus();
            }
            msgBox('Debe ingresar  el n&uacute;mero de tarjeta profesional',resp3001);
            return;
        }

        
        
        if(gEx('txtNombre_C').getValue()=='')
        {
            function resp3()
            {
                gEx('tblPersona_C').setActiveTab(0);
                gEx('txtNombre_C').focus();
            }
            msgBox('Debe indicar el nombre de la persona f&iacute;sica',resp3);
            return;
        }
        
        if(gEx('txtApPaterno_C').getValue()=='')
        {
            function resp3AP()
            {
                gEx('tblPersona_C').setActiveTab(0);
                gEx('txtApPaterno_C').focus();
            }
            msgBox('Debe indicar el primer apellido de la persona f&iacute;sica',resp3AP);
            return;
        }
        
        var cmbTipoEntidad=gEx('cmbTipoEntidad_C');
        
        var fechaIdentificacion=gEx('fechaIdentificacion_C').getValue()==''?'':gEx('fechaIdentificacion_C').getValue().format('Y-m-d');
        var tarjetaProfesional=gEx('txtTarjetaProfesional_C').getValue();
        
        
        if(gEx('cmbGenero_C').getValue()=='')
        {
            function resp4()
            {
                gEx('tblPersona_C').setActiveTab(1);
                gEx('cmbGenero_C').focus();
            }
            msgBox('Debe indicar el g&eacute;nero de la persona f&iacute;sica',resp4);
            return;
        }
        
        
        
        
        var fila;
        var x=0;
        var o;
       
        var nacionalidadMexicana='';                                                                            

       
        
       
        var pos=existeValorMatriz(arrTipoIdentificacionConfiguracion,cmbIdentificacion.getValue());
        nacionalidadMexicana=2;
        if(cmbIdentificacion.getValue()!='')
        {
            nacionalidadMexicana=arrTipoIdentificacionConfiguracion[pos][6];
        }
        
        var aceptaNotificacionMail='0';
        if(gEx('aceptaNotificacion_1_C').getValue())
        {
            aceptaNotificacionMail='1';
        }
        
        var cmbGrupoEtnico=gEx('cmbGrupoEtnico_C');
        var cmbDiscapacidad=gEx('cmbDiscapacidad_C');
        var cmbTipoEntidad=gEx('cmbTipoEntidad_C');
       
        
        cadObj='{"grupoEtnico":"'+cmbGrupoEtnico.getValue()+'","discapacidad":"'+cmbDiscapacidad.getValue()+
                '","aceptaNotificacionMail":"'+aceptaNotificacionMail+'","rfc":"'+cv(gEx('txtNIT_C').getValue())+
                '","datosContacto":@datosContacto,"tipoPersona":"1","nombre":"'+cv(gEx('txtNombre_C').getValue())+'","apPaterno":"'+cv(gEx('txtApPaterno_C').getValue())+
                '","apMaterno":"'+cv(gEx('txtApMaterno_C').getValue())+'","nacionalidadMexicana":"'+nacionalidadMexicana+
                '","nacionalidad":"'+nacionalidadMexicana+'","otraNacionalidad":"","genero":"'+gEx('cmbGenero_C').getValue()+
                '","alias":[],"detallePersona":"","tipoFigura":"'+tipoParticipante+'","fechaNacimiento":"'+
                (gEx('fechaNacimiento_C').getValue()==''?'':gEx('fechaNacimiento_C').getValue().format('Y-m-d'))+
                '","edad":"'+gEx('txtEdad_C').getValue()+'","identificacionPresentada":"'+tipoIdentificacion+'","otraIdentificacion":"'+
                cv(folioIdentificacion)+'","relacionadoCon":"'+listaRelacion+'"'+
                ',"fechaIdentificacion":"'+fechaIdentificacion+'","tarjetaProfesional":"'+tarjetaProfesional+
                '","tipoEntidad":"'+cmbTipoEntidad.getValue()+'","idActividad":"'+idActividadCarpeta+'","idCarpeta":"'+
                <?php echo $idCarpetaAdministrativa?>+'"'+campoComp+'}';
    
    
        
    }
    
    
    
    
    var txtCalle=gEx('txtCalleCParticipante_C');
    var cmbEstado=gEx('cmbEstadoCParticipante_C');
    var cmbMunicipio=gEx('cmbMunicipioCParticipante_C');
    
    var arrTelefonos='';
    var arrMails='';
    
    var x;
    var fila;
    var o;
    for(x=0;x<gEx('gTelefonosCParticipante_C').getStore().getCount();x++)
    {
        fila=gEx('gTelefonosCParticipante_C').getStore().getAt(x);
        
        if(fila.data.pais=='')
        {
            function respTel2()
            {
                gEx('panelContactoCParticipante_C').setActiveTab(2);
                gEx('panelContacto_C').setActiveTab(1);
                gEx('gTelefonosCParticipante_C').startEditing(x,2);
            }
            msgBox('Debe ingresar el pa&iacute;s al cual pertenece el n&uacute;mero telef&oacute;nico',respTel2);
            return;
        }
        
        if(fila.data.numero=='')
        {
            function respTel()
            {
                gEx('panelContactoCParticipante_C').setActiveTab(2);
                gEx('panelContacto_C').setActiveTab(1);
                gEx('gTelefonosCParticipante_C').startEditing(x,3);
            }
            msgBox('Debe ingresar el n&uacute;mero telef&oacute;nico a agregar',respTel);
            return;
        }
        
        o='{"tipoTelefono":"'+fila.data.tipoTelefono+'","lada":"'+fila.data.lada+
            '","numero":"'+fila.data.numero+'","extension":"'+fila.data.extension+
            '","pais":"'+fila.data.pais+'"}';
        if(arrTelefonos=='')
            arrTelefonos=o;
        else
            arrTelefonos+=','+o;
    }
    
    
    
    for(x=0;x<gEx('gMailCParticipante_C').getStore().getCount();x++)
    {
        fila=gEx('gMailCParticipante_C').getStore().getAt(x);
        
        if(fila.data.mail=='')
        {
            function resp101()
            {
                gEx('tblPersona_C').setActiveTab(2);
                gEx('panelContacto_C').setActiveTab(2);
                gEx('gMailCParticipante_C').startEditing(x,1);
            }
            msgBox('Debe ingresar la direcci&oacute;n de correo electr&oacute;nico de contacto',resp101);
            return;
        }
        
        if(!validarCorreo(fila.data.mail))
        {
            function resp103()
            {
                gEx('tblPersona_C').setActiveTab(2);
                gEx('panelContacto_C').setActiveTab(2);
                gEx('gMailCParticipante_C').startEditing(x,1);
                
            }
            msgBox('La direcci&oacute;n de correo electr&oacute;nico de contacto ingresada NO es v&aacute;lida',resp103);
            return;
        }
        var o='{"mail":"'+fila.data.mail+'"}';
        if(arrMails=='')
            arrMails=o;
        else
            arrMails+=','+o;
    }
    
    var cadObjAux='{"calle":"'+cv(txtCalle.getValue())+'","noExt":"","noInt":"","colonia":"","cp":"","estado":"'+cmbEstado.getValue()+
                '","municipio":"'+cmbMunicipio.getValue()+'","localidad":"","entreCalle":"","yCalle":"","referencias":"","arrTelefonos":['+arrTelefonos+
                '],"mail":['+arrMails+'],"idRegistro":"-1","idFormulario":"-47"}';
    
    cadObj=cadObj.replace('@datosContacto',cadObjAux);
   
   	
   
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	selPersona=nodoSujetoSel.id;
        	gEx('arbolSujetosAdmon').getRootNode().reload();
            cancelarBusquedaDatosPersona=true;
            msgBox('Los datos fueron guardados correctamente');
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_Notificaciones.php',funcAjax, 'POST','funcion=43&cadObj='+cadObj,true);
    
}