<?php session_start();
	;
	include("funcionesFormularios.php"); 
	include("configurarIdioma.php");
	include_once("cContabilidad.php");
	if(isset($_SESSION["leng"]))
	{
		if(isset($_POST["parametros"]))
			$parametros=$_POST["parametros"];
		if(isset($_POST["funcion"]))
			$funcion=$_POST["funcion"];
		$lenguaje=$_SESSION["leng"];
		
		switch($funcion)
		{
			case 1:
				dictaminarSolicitudProtocolo();
			break;
			case 2:
				obtenerCuentasBancariasProtocolo();
			break;
			case 3:
				obtenerCuentasBancoProtocolo();
			break;
			case 4:
				guardarRelacionCuentaProtocolo();
			break;
			case 5:
				obtenerPatrocinadoresCuentasProtocolo();
			break;
			case 6:
				guardarPatrocinadoresCuenta();
			break;
			case 7:
				removerCuentaBancariaProtocolo();
			break;
			case 8:
				obtenerContratosUsuarioProtocolo();
			break;
			case 9:
				obtenerDatosTipoContrato();
			break;
			case 10:
				obtenerEmpleadosContratosProtocolos();
			break;
			case 11:
				calcularRetencionISR();
			break;
			case 12:
				registrarDepositoBanco();
			break;
			case 13:
				obtenerSituacionPresupuestalProtocolo();
			break;
			case 14:
				obtenerCompensacionesUsuarioProtocolo();
			break;
			case 15:
				cambiarSituacionProtocolo();
			break;
			case 16:
				registrarEventoAdverso();
			break;
			case 17:
				obtenerRegistrosEventosAdversos();
			break;
			case 18:
				dictaminarEventoAdverso();
			break;
			case 19:
				registrarTipoEvento();
			break;
			case 20:
				registrarMedicamento();
			break;
			case 21:
				obtenerDesviacionesInvestigadores();
			break;
			case 22:
				obtenerMedicamentosEventosSerios();
			break;
			
		}
	}
	
	function dictaminarSolicitudProtocolo()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$consulta="UPDATE _979_tablaDinamica SET resultado=".$obj->resultado.",comentariosEvaluacion='".cv($obj->motivo)."' WHERE id__979_tablaDinamica=".$obj->idSolicitud;
		eC($consulta);
	}
	
	function obtenerCuentasBancariasProtocolo()
	{
		global $con;
		$c=new cContabilidad();
		$idProtocolo=$_POST["idProtocolo"];
		$idPerfilPresupuestal=2;
		$consulta="SELECT c.idCuenta AS idCuenta,c.descripcionCuenta AS descripcionCuenta,c.noCuenta AS numCuenta,c.clabeInterbancaria,b.nombreBanco AS banco,t.tipoCuentaBancaria,
				'0' AS saldo,p.idCuentaProtocolo  FROM 3000_cuentasBancariasProtocolos p,6004_cuentasBancarias c,6000_bancos b,6001_sucursales s,6007_tiposCuentaBancaria t 
				WHERE c.idCuenta=p.idCuentaBancaria AND p.idProtocolo=".$idProtocolo." AND b.idBanco=s.idBanco AND s.idSucursal=c.idSucursal AND t.idTipoCuentaBancaria=c.idTipoCuentaBancaria";
		$res=$con->obtenerFilas($consulta);
		$arrRegistros="";
		$nRegistros=0;
		while($fila=mysql_fetch_row($res))
		{
			$consulta="SELECT unidad FROM 817_organigrama WHERE codigoUnidad IN (SELECT codigoPatrocinador FROM 3001_cuentaBancariaPatrocinador WHERE idCuentaBancariaProtocolo=".$fila[7].") ORDER BY unidad";
			$resUnidad=$con->obtenerFilas($consulta);
			$patrocinadores="<table>";
			while($f=mysql_fetch_row($resUnidad))
			{
				$patrocinadores.="<tr height='21'><td>&nbsp;-&nbsp;</td><td><b>".$f[0]."</b></td></tr>";
			}
			$patrocinadores.="</table>";
			
			
			$arrDimensiones["IDProyecto"]=$idProtocolo;
			$arrDimensiones["IDCuentaBancaria"]=$fila[0];
			$consulta="SELECT tiempoSuficiencia FROM 524_perfilesPresupuestales WHERE idPerfilPresupuestal=".$idPerfilPresupuestal;
			$tiempoSuficiencia=$con->obtenerValor($consulta);
			$saldo=$c->obtenerSaldoPresupuesto($tiempoSuficiencia,$arrDimensiones);
			
			
			$consulta="SELECT codigoUnidad,unidad FROM 817_organigrama WHERE codigoUnidad IN (SELECT codigoPatrocinador FROM 3001_cuentaBancariaPatrocinador WHERE idCuentaBancariaProtocolo=".$fila[7].") ORDER BY unidad";
			$arrPatrocinadores=$con->obtenerFilasArreglo($consulta);
			$obj='{"arrPatrocinadores":'.$arrPatrocinadores.',"idCuenta":"'.$fila[0].'","descripcionCuenta":"'.cv($fila[1]).'","numCuenta":"'.$fila[2].'","clabeInterbancaria":"'.$fila[3].'","banco":"'.cv($fila[4]).'","tipoCuentaBancaria":"'.$fila[5].'","saldo":"'.$saldo.'","patrocinadores":"'.$patrocinadores.'"}';
			if($arrRegistros=="")
				$arrRegistros=$obj;
			else
				$arrRegistros.=",".$obj;
			$nRegistros++;
		}
		echo '{"numReg":"'.$nRegistros.'","registros":['.$arrRegistros.']}';

	}
	
	function obtenerCuentasBancoProtocolo()
	{
		global $con;
		$idBanco=$_POST["idBanco"];
		$consulta="SELECT c.idCuenta,CONCAT('[',c.noCuenta,'] ',c.descripcionCuenta) FROM 6004_cuentasBancarias c,6001_sucursales s 
					WHERE s.idSucursal=c.idSucursal AND s.idBanco=".$idBanco;//." and c.idCuenta not in (SELECT idCuentaBancaria FROM 3000_cuentasBancariasProtocolos)";
		echo "1|".$con->obtenerFilasArreglo($consulta);
	}
	
	function guardarRelacionCuentaProtocolo()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		
		$obj=json_decode($cadObj);
		$arrPatrocinadores=explode(",",$obj->patrocinadores);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="INSERT INTO 3000_cuentasBancariasProtocolos(idCuentaBancaria,idProtocolo) VALUES(".$obj->idCuenta.",".$obj->idProtocolo.")";
		$x++;
		$consulta[$x]="set @idRegistro:=(select last_insert_id())";
		$x++;
		foreach($arrPatrocinadores as $p)
		{
			$consulta[$x]="INSERT INTO 3001_cuentaBancariaPatrocinador(idCuentaBancariaProtocolo,codigoPatrocinador) VALUES(@idRegistro,'".$p."')";
			$x++;
		}
		$consulta[$x]="commit";
		$x++;
		eB($consulta);

	}
	
	function obtenerPatrocinadoresCuentasProtocolo()
	{
		global $con;
		$idProtocolo=$_POST["idProtocolo"];
		$idCuentaBancaria=$_POST["idCuentaBancaria"];
		$consulta="SELECT o.codigoUnidad,o.unidad FROM 9036_patrocinadoresProyectos p,817_organigrama o WHERE p.idFormulario=278 AND idReferencia=".$idProtocolo."
					AND o.codigoUnidad=p.codigoInstitucion ORDER BY unidad";
		$res=$con->obtenerFilas($consulta);
		$arrPatrocinadores="";
		while($fila=mysql_fetch_row($res))
		{
			$existe="false";
			$consulta="SELECT COUNT(*) FROM 3000_cuentasBancariasProtocolos c,3001_cuentaBancariaPatrocinador p WHERE c.idCuentaBancaria=".$idCuentaBancaria." AND p.idCuentaBancariaProtocolo=c.idCuentaProtocolo AND 
					p.codigoPatrocinador='".$fila[0]."'";
					
			$nReg=$con->obtenerValor($consulta);
			if($nReg!=0)
				$existe="true";
			$obj="['".$fila[0]."','".$fila[1]."',".$existe."]";
			if($arrPatrocinadores=="")
				$arrPatrocinadores=$obj;
			else
				$arrPatrocinadores.=",".$obj;
			
		}
		echo "1|[".$arrPatrocinadores."]";
	}
	
	function guardarPatrocinadoresCuenta()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		
		$obj=json_decode($cadObj);
		$arrPatrocinadores=explode(",",$obj->patrocinadores);
		$x=0;
		$query="select idCuentaProtocolo from 3000_cuentasBancariasProtocolos where idCuentaBancaria=".$obj->idCuenta." and idProtocolo=".$obj->idProtocolo;
		$idCta=$con->obtenerValor($query);
		if($idCta=="")
			$idCta=-1;
		
		$consulta[$x]="begin";
		$x++;
		
		
		
		$consulta[$x]="delete from 3001_cuentaBancariaPatrocinador where idCuentaBancariaProtocolo=".$idCta;
		$x++;
		$consulta[$x]="set @idRegistro:=".$idCta;
		$x++;
		foreach($arrPatrocinadores as $p)
		{
			$consulta[$x]="INSERT INTO 3001_cuentaBancariaPatrocinador(idCuentaBancariaProtocolo,codigoPatrocinador) VALUES(@idRegistro,'".$p."')";
			$x++;
		}
		$consulta[$x]="commit";
		$x++;
		eB($consulta);

	}
	
	function removerCuentaBancariaProtocolo()
	{
		global $con;
		global $con;
		$idProtocolo=$_POST["idProtocolo"];
		$idCuenta=$_POST["idCuentaBancaria"];
		
		
		$x=0;
		$query="select idCuentaProtocolo from 3000_cuentasBancariasProtocolos where idCuentaBancaria=".$idCuenta." and idProtocolo=".$idProtocolo;
		$idCta=$con->obtenerValor($query);
		if($idCta=="")
			$idCta=-1;
		
		$consulta[$x]="begin";
		$x++;
		
		
		
		$consulta[$x]="delete from 3000_cuentasBancariasProtocolos where idCuentaProtocolo=".$idCta;
		$x++;
		$consulta[$x]="delete from 3001_cuentaBancariaPatrocinador where idCuentaBancariaProtocolo=".$idCta;
		$x++;

		$consulta[$x]="commit";
		$x++;
		eB($consulta);
	}
	
	function obtenerContratosUsuarioProtocolo()
	{
		global $con;
		$idUsuario=$_POST["idUsuario"];
		$idProtocolo=$_POST["idProtocolo"];
		$consulta="SELECT id__988_tablaDinamica AS idContrato,codigo AS  folioContrato,fechaInicio,fechaConclusion AS fechaFin,montoContrato,tipoContrato FROM _988_tablaDinamica WHERE 
					idUsuarioContradado=".$idUsuario." AND idProyecto=".$idProtocolo;
		$arrRegistros=$con->obtenerFilasJSON($consulta);
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrRegistros).'}';
		
	}
	
	function obtenerDatosTipoContrato()
	{
		global $con;
		$tipoContrato=$_POST["tipoContrato"];
		$cadObj='';
		$consulta="SELECT porcentajeIVA FROM 6008_impuestoIVA WHERE  apartirDE <='".date("Y-m-d")."' AND tipoIVA=1 ORDER BY apartirDE desc";
		$pIVA=$con->obtenerValor($consulta);
		$consulta="SELECT porcentajeRetencionISR,porcentajeRetencionIVA,retenerIvaSiNo,tipoRetencionISR,fechaMinimaInicial,fechaMaximaFinal FROM _989_tablaDinamica WHERE id__989_tablaDinamica=".$tipoContrato;
		$fila=$con->obtenerPrimeraFila($consulta);
		if($fila)
		{
			if($fila[0]=="")
				$fila[0]=0;
			if($fila[1]=="")
				$fila[1]=0;
		}
		else
		{
			$fila[0]=0;
			$fila[1]=0;
			$fila[2]=2;
		}
		if($fila[2]==2)
			$pIVA=0;
		$cadObj='{"tipoRetencionISR":"'.$fila[3].'","maxDiaInclude":"'.$fila[5].'","minDiaInclude":"'.$fila[4].'","pIVA":"'.$pIVA.'","porcentajeRetencionISR":"'.$fila[0].'","porcentajeRetencionIVA":"'.$fila[1].'","retenerIvaSiNo":"'.$fila[2].'"}';
		echo "1|".$cadObj;
	}
	
	function obtenerEmpleadosContratosProtocolos()
	{
		global $con;
		$idProtocolo=$_POST["idProtocolo"];
		$consulta="select distinct idUsuario,Paterno as apPaterno,Materno as apMaterno,Nombre as nombre,(SELECT GROUP_CONCAT(CONCAT('(',codArea,') ',Lada,' -',Numero, 'Ext. ',Extension)) 
				FROM 804_telefonos WHERE idUsuario=i.idUsuario)as telefono,(select group_concat(Mail) from 805_mails where idUsuario=i.idUsuario) as email,
				(SELECT count(*) FROM _988_tablaDinamica WHERE 	idUsuarioContradado=i.idUsuario AND idProyecto=t.idProyecto) as noContratos,
				(SELECT count(*) FROM _991_tablaDinamica WHERE 	empleados=i.idUsuario AND idProyecto=t.idProyecto) as noCompensaciones
				 from 802_identifica i,_988_tablaDinamica t 
				where idUsuario=t.idUsuarioContradado and t.idProyecto=".$idProtocolo." order by Paterno,Materno,Nombre";
		$arrRegistros=$con->obtenerFilasJSON($consulta);
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrRegistros).'}';
		
	}
	
	function calcularRetencionISR()
	{
		global $con;
		$montoBase=$_POST["montoBase"];
		$consulta="SELECT ciclo FROM 550_cicloFiscal WHERE STATUS=1";
		$ciclo=$con->obtenerValor($consulta);
		$ISR=calcularISR($montoBase,$ciclo);
		echo "1|".$ISR;
		
	}
	
	function registrarDepositoBanco()
	{
		global $con;
		$arrAsientos=array();
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$consulta="select unidad from 817_organigrama where codigoUnidad='".$obj->idPatrocinador."'";
		$nPatrocinador=$con->obtenerValor($consulta);
		$consulta="INSERT INTO 6010_movimientosCuentasBancarias(fechaMovimiento,descripcion,deposito,retiro,conciliado,idCuentaBancaria,comp,fechaRegistroMovimiento,idResponsableMovimiento)
				VALUES('".$obj->fechaDeposito."','Deposito de patrocinador: ".$nPatrocinador."',".$obj->montoDeposito.",0,1,".$obj->idCuenta.",'','".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].")";
		if($con->ejecutarConsulta($consulta))
		{
			$c=new cContabilidad();
			$consulta="SELECT cmbDeptoProtocolo FROM _278_tablaDinamica WHERE id__278_tablaDinamica=".$obj->idProtocolo;
			$codDepto=$con->obtenerValor($consulta);
			$cadObj='{"tipoMovimiento":"19","montoOperacion":"'.$obj->montoDeposito.'","dimensiones":{"IDDepartamento":"'.$codDepto.'","IDProyecto":"'.$obj->idProtocolo.'","IDPatrocinador":"'.$obj->idPatrocinador.'","IDCuentaBancaria":"'.$obj->idCuenta.'"}}';
			
			$obj=json_decode($cadObj);
			
			array_push($arrAsientos,$obj);
			if($c->asentarArregloMovimientos($arrAsientos))
				echo "1|";
		}
			
	}
	
	function obtenerSituacionPresupuestalProtocolo()
	{
		global $con;
		$c=new cContabilidad();
		$idProtocolo=$_POST["idProtocolo"];
		$consulta="SELECT idTiempoPresupuestal,nombreTiempo FROM 524_tiemposPresupuestales ORDER BY idTiempoPresupuestal";
		$resTiempo=$con->obtenerFilas($consulta);
		$arrRegistros="";
		$consulta="SELECT distinct idConceptoGrid,nombreConcepto FROM 100_gridPresupuesto g,100_conceptosGridPresupuesto c WHERE c.idConceptoGrid=g.idRubro and idFormulario=278 AND idReferencia=".$idProtocolo." order by nombreConcepto";
		$res=$con->obtenerFilas($consulta);
		$nReg=0;
		

		$arrDimensiones["idProyecto"]=$idProtocolo;
		
		while($fila=mysql_fetch_row($res))
		{
			$montoTotal=0;
			$arrDimensiones["idRubroPresupuesto"]=$fila[0];
			$obj='{"idRubro":"'.$fila[0].'","descripcion":"'.$fila[1].'"';
			if(mysql_num_rows($resTiempo)>0)
			{
				mysql_data_seek($resTiempo,0);
			}
			while($f=mysql_fetch_row($resTiempo))
			{
				
				$saldo=$c->obtenerSaldoPresupuesto($f[0],$arrDimensiones);
				$obj.=',"tiempo_'.$f[0].'":"'.$saldo.'"';
				$montoTotal+=$saldo;
			}
			$obj.=',"total":"'.$montoTotal.'"}';
			if($arrRegistros=="")
				$arrRegistros=$obj;
			else
				$arrRegistros.=",".$obj;
			$nReg++;
		}
		echo '{"numReg":"'.$nReg.'","registros":['.$arrRegistros.']}';
	}
	
	function obtenerCompensacionesUsuarioProtocolo()
	{
		global $con;
		$idUsuario=$_POST["idUsuario"];
		$idProtocolo=$_POST["idProtocolo"];
		$consulta="SELECT id__991_tablaDinamica AS idCompensacion,codigo AS  folioCompensacion,fechaInicio,fechaFinal AS fechaFin,montoCompensacion,justificacionCompensacion FROM _991_tablaDinamica WHERE 
					empleados=".$idUsuario." AND idProyecto=".$idProtocolo;
		$arrRegistros=$con->obtenerFilasJSON($consulta);
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrRegistros).'}';
		
	}
	
	function cambiarSituacionProtocolo()
	{
		global $con;
		$idEstado=$_POST["idEstado"];
		$idRegistro=$_POST["idRegistro"];
		cambiarEtapaFormulario(278,$idRegistro,$idEstado);
		echo "1|";
		
		
	}
	
	function registrarEventoAdverso()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$arrAux=array();
		foreach($obj->arrDetalle as $d)
		{
			$c="";
			$fTermino="NULL";
			if(isset($d->fechaTermino))
				$fTermino="'".$d->fechaTermino."'";
			if(($d->idArchivo!="")&&($d->idArchivo!=-1))
			{
				$idDocumento=registrarDocumentoServidor($d->idArchivo,$d->nombreArchivo);
				$cadObj=str_replace('"idArchivo":"'.$d->idArchivo.'"','"idArchivo":"'.$idDocumento.'"',$cadObj);
				$c="INSERT INTO 1021_consecuenciasReporteEventoAdverso(tipoDetalle,detalle,idArchivo,nombreArchivo,fechaTermino,idReporteEvento)
					VALUES(".$d->tipoDetalle.",'".cv($d->detalle)."',".$idDocumento.",'".$d->nombreArchivo."',".$fTermino.",@idReporte)";
				
				
			}
			else
			{
				$c="INSERT INTO 1021_consecuenciasReporteEventoAdverso(tipoDetalle,detalle,idArchivo,nombreArchivo,fechaTermino,idReporteEvento)
					VALUES(".$d->tipoDetalle.",'".cv($d->detalle)."',-1,'',".$fTermino.",@idReporte)";
			}
			array_push($arrAux,$c);
			
		}
		
		$idProyecto=$obj->idProyecto;
		$consulta="SELECT a.idUsuario from 246_autoresVSProyecto a WHERE idFormulario=278 AND idReferencia=".$idProyecto." AND responsable=1";
		$idInvestigador=$con->obtenerValor($consulta);
		$x=0;
		$query[$x]="begin";
		$x++;
		$query[$x]="INSERT INTO 1020_reportesEventoAdverso(fechaCreacion,fechaEvento,idResponsable,idProyecto,objReporte,situacion,fechaDictamen,comentariosRespuesta,tipoEvento,idMedicamento,eventoSerio,idFormatoEventoSerio,idInvestigadorResponsable)
					VALUES('".date("Y-m-d H:i:s")."','".$obj->fechaEvento."',".$_SESSION["idUsr"].",".$obj->idProyecto.",'".cv($cadObj)."',1,null,'',".$obj->tipoEvento.",".$obj->idMedicamento.",".$obj->eventoSerio.",".$obj->idNotificacionEventoAdverso.
					",".$idInvestigador.")";
		$x++;
		$query[$x]="set @idReporte:=(select last_insert_id())";
		$x++;
			
		
		if($obj->eventoSerio==1)
		{
			$query[$x]="UPDATE _1011_tablaDinamica SET idReporte=@idReporte WHERE id__1011_tablaDinamica=".$obj->idNotificacionEventoAdverso;
			$x++;
		}
		
		foreach($arrAux as $c)
		{
			$query[$x]=$c;
			$x++;
		}
		$query[$x]="commit";
		$x++;
		
		if($con->ejecutarBloque($query))	
		{
			if($idInvestigador!="")
			{
				$consulta="SELECT Mail FROM 805_mails WHERE idUsuario=".$idInvestigador;
				$mail=$con->obtenerValor($consulta);
				if($mail!="")
				{
					$consulta="select @idReporte";
					$idEvento=$con->obtenerValor($consulta);
					$nombre=obtenerNombreUsuario($idInvestigador);
					
					$consulta="select concat('[Folio: ',codigo,'] ',tituloProyecto) FROM _278_tablaDinamica t WHERE id__278_tablaDinamica=".$idProyecto;
					$proyecto=$con->obtenerValor($consulta);			
					$folio=str_pad($idEvento,8,"0",STR_PAD_LEFT);
					
					$consulta="SELECT asunto,cuerpo FROM 2004_mensajesAcciones WHERE idAccionEnvio=5";
					$fMail=$con->obtenerPrimeraFila($consulta);
					$mensaje=str_replace("@Investigador",$nombre,$fMail[1]);
					$mensaje=str_replace("@folio",$folio,$mensaje);
					$mensaje=str_replace("@proyecto",$proyecto,$mensaje);
					
					
					
					enviarMail($mail,$fMail[0],$mensaje);
					
				}
				
			}
		}
		echo "1|";
			
	}
	
	function obtenerRegistrosEventosAdversos()
	{
		global $con;
		$situacion=$_POST["idSituacion"];
		$idProyecto=$_POST["idProyecto"];
		
		$comp="";
		if($idProyecto!=0)
		{
			$comp=" and idProyecto=".$idProyecto;
		}
		if(isset($_POST["listaEventos"]))
			$comp=" or idReporteEventoAdverso in(".$_POST["listaEventos"].")";
		$obj='';
		$arrRegistros='';
		$nRegistros=0;
		$consulta="SELECT idReporteEventoAdverso,fechaCreacion,fechaEvento,idResponsable,idProyecto,situacion,fechaDictamen,
				comentariosRespuesta,objReporte,tipoEvento,eventoSerio,idFormatoEventoSerio FROM 1020_reportesEventoAdverso where 
				situacion in (".$situacion.") ".$comp." order by fechaCreacion";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$objReporte=json_decode($fila[8]);

			$detalleReporte="";
			if($fila[9]==1)
			{
				$nomMedicamento="";
				$consulta="SELECT nombreProducto FROM 9101_CatalogoProducto WHERE idProducto=".$objReporte->idMedicamento;
				$nomMedicamento=$con->obtenerValor($consulta);
				$detalleReporte.="<tr height='21'><td></td><td valign='top'><span class='corpo8_bold'>Medicamento involucrado:</span>&nbsp;&nbsp;&nbsp;</td><td valign='top'><span class='copyrigthSinPadding'>".$nomMedicamento."</span></td><tr><tr height='1' style='background-color:#900'><td colspan='3'></td></tr>";
			}
			
			if(sizeof($objReporte->arrDetalle)>0)
			{
				foreach($objReporte->arrDetalle as $d)
				{

					switch($d->tipoDetalle)
					{
						case "1":
							$detalleReporte.="<tr height='21'><td></td><td><span class='corpo8_bold'>Consecuencia:</span>&nbsp;&nbsp;</td><td><span class='copyrigthSinPadding'>Desviaci&oacute;n</span></td><tr>";
							$detalleReporte.="<tr height='21'><td></td><td><span class='corpo8_bold'>Detalle de la Desviación:</span>&nbsp;&nbsp;</td><td><span class='copyrigthSinPadding'>".cv($d->detalle)."</span></td><tr>";
							if(($d->idArchivo!="")&&($d->idArchivo!=-1))
							{
								$detalleReporte.="<tr height='21'><td></td><td><span class='corpo8_bold'>Documento anexo:</span>&nbsp;&nbsp;</td><td><span class='copyrigthSinPadding'><a href='javascript:descargarDocumento(\\\"".bE($d->idArchivo)."\\\")'><img src='../images/download.png'> Descargar documento</a></span></td><tr>";
							}
							$detalleReporte.="<tr height='21'><td colspan='3'></td></tr><tr height='1' style='background-color:#900'><td colspan='3'></td></tr>";
						break;
						case "2":
							$detalleReporte.="<tr height='21'><td></td><td><span class='corpo8_bold'>Consecuencia:</span>&nbsp;&nbsp;</td><td><span class='copyrigthSinPadding'>Violaci&oacute;n</span></td><tr>";
							$detalleReporte.="<tr height='21'><td></td><td><span class='corpo8_bold'>Detalle de la Violaci&oacute;n:</span>&nbsp;&nbsp;</td><td><span class='copyrigthSinPadding'>".cv($d->detalle)."</span></td><tr>";
							if(($d->idArchivo!="")&&($d->idArchivo!=-1))
							{
								$detalleReporte.="<tr height='21'><td></td><td><span class='corpo8_bold'>Documento anexo:</span>&nbsp;&nbsp;</td><td><span class='copyrigthSinPadding'><a href='javascript:descargarDocumento(\\\"".bE($d->idArchivo)."\\\")'><img src='../images/download.png'> Descargar documento</a></span></td><tr>";
							}
							$detalleReporte.="<tr height='21'><td colspan='3'></td></tr><tr height='1' style='background-color:#900'><td colspan='3'></td></tr>";
						break;
						case "3":
							$detalleReporte.="<tr height='21'><td></td><td><span class='corpo8_bold'>Consecuencia:</span>&nbsp;&nbsp;</td><td><span class='copyrigthSinPadding'>Muerte</span></td><tr>";
							$detalleReporte.="<tr height='21'><td></td><td><span class='corpo8_bold'>Detalle de la Muerte:</span>&nbsp;&nbsp;</td><td><span class='copyrigthSinPadding'>".cv($d->detalle)."</span></td><tr>";
							if(($d->idArchivo!="")&&($d->idArchivo!=-1))
							{
								$detalleReporte.="<tr height='21'><td></td><td><span class='corpo8_bold'>Documento anexo:</span>&nbsp;&nbsp;</td><td><span class='copyrigthSinPadding'><a href='javascript:descargarDocumento(\\\"".bE($d->idArchivo)."\\\")'><img src='../images/download.png'> Descargar documento</a></span></td><tr>";
							}
							$detalleReporte.="<tr height='21'><td colspan='3'></td></tr><tr height='1' style='background-color:#900'><td colspan='3'></td></tr>";
						break;
						case "4":
							$detalleReporte.="<tr height='21'><td></td><td><span class='corpo8_bold'>Consecuencia:</span>&nbsp;&nbsp;</td><td><span class='copyrigthSinPadding'>Enmienda</span></td><tr>";
							$detalleReporte.="<tr height='21'><td></td><td><span class='corpo8_bold'>Detalle de la Enmienda:</span>&nbsp;&nbsp;</td><td><span class='copyrigthSinPadding'>".cv($d->detalle)."</span></td><tr>";
							if(($d->idArchivo!="")&&($d->idArchivo!=-1))
							{
								$detalleReporte.="<tr height='21'><td></td><td><span class='corpo8_bold'>Documento anexo:</span>&nbsp;&nbsp;</td><td><span class='copyrigthSinPadding'><a href='javascript:descargarDocumento(\\\"".bE($d->idArchivo)."\\\")'><img src='../images/download.png'> Descargar documento</a></span></td><tr>";
							}
							$detalleReporte.="<tr height='21'><td colspan='3'></td></tr><tr height='1' style='background-color:#900'><td colspan='3'></td></tr>";
						break;
						case "5":
							$detalleReporte.="<tr height='21'><td></td><td><span class='corpo8_bold'>Consecuencia:</span>&nbsp;&nbsp;</td><td><span class='copyrigthSinPadding'>Cambio de consentimiento</span></td><tr>";
							$detalleReporte.="<tr height='21'><td></td><td><span class='corpo8_bold'>Detalle del Cambio de consentimiento:</span>&nbsp;&nbsp;</td><td><span class='copyrigthSinPadding'>".cv($d->detalle)."</span></td><tr>";
							if(($d->idArchivo!="")&&($d->idArchivo!=-1))
							{
								$detalleReporte.="<tr height='21'><td></td><td><span class='corpo8_bold'>Documento anexo:</span>&nbsp;&nbsp;</td><td><span class='copyrigthSinPadding'><a href='javascript:descargarDocumento(\\\"".bE($d->idArchivo)."\\\")'><img src='../images/download.png'> Descargar documento</a></span></td><tr>";
							}
							$detalleReporte.="<tr height='21'><td colspan='3'></td></tr><tr height='1' style='background-color:#900'><td colspan='3'></td></tr>";
						break;
						case "6":
							$detalleReporte.="<tr height='21'><td></td><td><span class='corpo8_bold'>Consecuencia:</span>&nbsp;&nbsp;</td><td><span class='copyrigthSinPadding'>Terminación prematura</span></td><tr>";
							$detalleReporte.="<tr height='21'><td></td><td><span class='corpo8_bold'>Fecha de la Terminación prematura:</span>&nbsp;&nbsp;</td><td><span class='copyrigthSinPadding'>".date("d/m/Y",strtotime($d->fechaTermino))."</span></td><tr>";
							$detalleReporte.="<tr height='21'><td></td><td><span class='corpo8_bold'>Detalle de la Terminación prematura:</span>&nbsp;&nbsp;</td><td><span class='copyrigthSinPadding'>".cv($d->detalle)."</span></td><tr>";
							
							if(($d->idArchivo!="")&&($d->idArchivo!=-1))
							{
								$detalleReporte.="<tr height='21'><td></td><td><span class='corpo8_bold'>Documento anexo:</span>&nbsp;&nbsp;</td><td><span class='copyrigthSinPadding'><a href='javascript:descargarDocumento(\\\"".bE($d->idArchivo)."\\\")'><img src='../images/download.png'> Descargar documento</a></span></td><tr>";
							}
							$detalleReporte.="<tr height='21'><td colspan='3'></td></tr><tr height='1' style='background-color:#900'><td colspan='3'></td></tr>";
						break;
					}
				}
			}
			
			$consulta="SELECT 
				(SELECT Nombre FROM 800_usuarios u,246_autoresVSProyecto a WHERE a.idUsuario=u.idUsuario AND idFormulario=278 AND idReferencia=t.id__278_tablaDinamica AND responsable=1) AS autor,
				concat('[Folio: ',codigo,'] ',tituloProyecto)  
				FROM _278_tablaDinamica t WHERE id__278_tablaDinamica=".$fila[4];

			$fProyecto=$con->obtenerPrimeraFila($consulta);
			$lblEventoSerio="<b>No</b>";
			if($fila[10]==1)
			{
				$lblEventoSerio="<b>Sí</b>&nbsp;&nbsp;&nbsp;<a href='javascript:verFichaNotificacionEventoSerio(\\\"".bE($fila[11])."\\\")'><img width='13' height='13' src='../images/magnifier.png' title='Ver Formato de Notificaci&oacute;n de Evento Adverso Serio' alt='Ver Formato de Notificaci&oacute;n de Evento Adverso Serio' /></a>";
			}
			$obj='{"eventoSerio":"'.$lblEventoSerio.'","tipoEvento":"'.$fila[9].'","fechaDictamen":"'.$fila[6].'","comentariosDictamen":"'.cv($fila[7]).'","situacion":"'.$fila[5].'","idEvento":"'.$fila[0].'","fechaRegistro":"'.$fila[1].'","fechaEvento":"'.$fila[2].
				'","registradoPor":"'.obtenerNombreUsuario($fila[3]).'","folio":"'.str_pad($fila[0],8,"0",STR_PAD_LEFT).
				'","tituloProyecto":"'.cv($fProyecto[1]).'","investigadorPrincipal":"'.cv($fProyecto[0]).'","detalleReporte":"<table>'.$detalleReporte.'</table>","descripcionEvento":"'.cv($objReporte->descripcion).'"}';
			if($arrRegistros=="")
				$arrRegistros=$obj;
			else
				$arrRegistros.=",".$obj;
			$nRegistros++;
		}
		echo '{"numReg":"'.$nRegistros.'","registros":['.$arrRegistros.']}';
	}	
	
	function dictaminarEventoAdverso()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		
		$consulta="UPDATE 1020_reportesEventoAdverso SET idResponsableDictamen=".$_SESSION["idUsr"].",comentariosRespuesta='".cv($obj->comentarios)."',fechaDictamen='".date("Y-m-d H:i:s")."',situacion='".$obj->dictamen."' WHERE idReporteEventoAdverso=".$obj->idEvento;
		if($con->ejecutarConsulta($consulta))
		{
			$consulta="select idProyecto from 1020_reportesEventoAdverso WHERE idReporteEventoAdverso=".$obj->idEvento;
			$idProyecto=$con->obtenerValor($consulta);
			$consulta="SELECT a.idUsuario from 246_autoresVSProyecto a WHERE idFormulario=278 AND idReferencia=".$idProyecto." AND responsable=1";
			$idInvestigador=$con->obtenerValor($consulta);
			if($idInvestigador!="")
			{
				$consulta="SELECT Mail FROM 805_mails WHERE idUsuario=".$idInvestigador;
				$mail=$con->obtenerValor($consulta);
				if($mail!="")
				{
					
					$nombre=obtenerNombreUsuario($idInvestigador);
					$comentario=$obj->comentarios;
					if($comentario=="")
						$comentario="Sin comentarios";
					$resultado="Aprobado";
					if($obj->dictamen=='3')
						$resultado="Rechazado";
					$consulta="select concat('[Folio: ',codigo,'] ',tituloProyecto) FROM _278_tablaDinamica t WHERE id__278_tablaDinamica=".$idProyecto;
					$proyecto=$con->obtenerValor($consulta);			
					$folio=str_pad($obj->idEvento,8,"0",STR_PAD_LEFT);
					
					$consulta="SELECT asunto,cuerpo FROM 2004_mensajesAcciones WHERE idAccionEnvio=4";
					$fMail=$con->obtenerPrimeraFila($consulta);
					$mensaje=str_replace("@Investigador",$nombre,$fMail[1]);
					$mensaje=str_replace("@folio",$folio,$mensaje);
					$mensaje=str_replace("@proyecto",$proyecto,$mensaje);
					$mensaje=str_replace("@resultado",$resultado,$mensaje);
					$mensaje=str_replace("@comentarios",$comentario,$mensaje);
					
					
					enviarMail($mail,$fMail[0],$mensaje);
					
				}
				
			}
			echo "1|";
		}
	}
	
	function registrarTipoEvento()
	{
		global $con;
		$tipoEvento=$_POST["tipoEvento"];
		$descripcion=$_POST["descripcion"];
		$consulta="INSERT INTO 1019_tiposEventoAdverso(nombreEventoAdverso,descripcion) VALUES('".cv($tipoEvento)."','".cv($descripcion)."')";
		if($con->ejecutarConsulta($consulta))
		{
			echo "1|".$con->obtenerUltimoID();
		}
			
	}
	
	function registrarMedicamento()
	{
		global $con;
		$medicamento=$_POST["medicamento"];
		$descripcion=$_POST["descripcion"];
		$consulta="INSERT INTO 9101_CatalogoProducto(nombreProducto,descripcion,idAlmacen)  VALUES('".cv($medicamento)."','".cv($descripcion)."',0)";
		
		if($con->ejecutarConsulta($consulta))
		{
			$idProducto=$con->obtenerUltimoID();
			$consulta="update 9101_CatalogoProducto set clave_Art='".$idProducto."' where idProducto=".$idProducto;
			$con->ejecutarConsulta($consulta);
			echo "1|".$idProducto;
		}
			
	}
	
	function obtenerDesviacionesInvestigadores()
	{
		global $con;
		$fechaInicio=$_POST["fechaInicio"];
		$fechaFin=$_POST["fechaFin"];
		$noIncidencias=$_POST["noIncidencias"];
		
		$arrRegistros="";
		$numReg=0;
		
		
		$consulta="SELECT DISTINCT idInvestigadorResponsable FROM 1020_reportesEventoAdverso r,1021_consecuenciasReporteEventoAdverso  c,800_usuarios u
					WHERE r.situacion=2 and c.idReporteEvento=r.idReporteEventoAdverso AND r.fechaCreacion>='".$fechaInicio."' AND r.fechaCreacion<='".$fechaFin."' 
					AND c.tipoDetalle=1 and u.idUsuario=r.idInvestigadorResponsable order by u.Nombre";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$consulta="SELECT idReporteEventoAdverso FROM 1020_reportesEventoAdverso r,1021_consecuenciasReporteEventoAdverso  c
					WHERE r.situacion=2 and c.idReporteEvento=r.idReporteEventoAdverso AND r.fechaCreacion>='".$fechaInicio."' AND r.fechaCreacion<='".$fechaFin."' 
					AND c.tipoDetalle=1 and idInvestigadorResponsable=".$fila[0];
			$listIncidencias=$con->obtenerListaValores($consulta);
			if($con->filasAfectadas>=$noIncidencias)
			{
				$noIncidencias=$con->filasAfectadas;
				$consulta="SELECT unidad FROM 817_organigrama o,801_adscripcion a WHERE o.codigoUnidad=a.codigoUnidad AND a.idUsuario=".$fila[0];
				
				$departamento=$con->obtenerValor($consulta);
				$obj='{"idInvestigador":"'.$fila[0].'","nombreInvestigador":"'.cv(obtenerNombreUsuario($fila[0])).'","departamento":"'.$departamento.'","noIncidencias":"'.$noIncidencias.'","listIncidencias":"'.$listIncidencias.'"}';
				if($arrRegistros=="")
					$arrRegistros=$obj;
				else
					$arrRegistros.=",".$obj;
				$numReg++;
			}
		}
		
		
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
		
		
	}
	
	function obtenerMedicamentosEventosSerios()
	{
		global $con;
		$fechaInicio=$_POST["fechaInicio"];
		$fechaFin=$_POST["fechaFin"];
		$noIncidencias=$_POST["noIncidencias"];
		
		$arrRegistros="";
		$numReg=0;
		
		
		$consulta="SELECT distinct idMedicamento,nombreProducto,c.descripcion FROM 1020_reportesEventoAdverso r,_1011_tablaDinamica f,9101_CatalogoProducto c
					WHERE r.situacion=2 and c.idProducto=r.idMedicamento and tipoEvento=1 AND r.fechaCreacion>='".$fechaInicio."' AND r.fechaCreacion<='".$fechaFin."' AND eventoSerio=1
					AND f.id__1011_tablaDinamica=idFormatoEventoSerio AND f.relacionFarmaco='1' order by nombreProducto";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			
			$consulta="SELECT idReporteEventoAdverso FROM 1020_reportesEventoAdverso r,_1011_tablaDinamica f
					WHERE r.situacion=2 and tipoEvento=1 AND r.fechaCreacion>='".$fechaInicio."' AND r.fechaCreacion<='".$fechaFin."' AND eventoSerio=1
					AND f.id__1011_tablaDinamica=idFormatoEventoSerio AND f.relacionFarmaco='1' and idMedicamento=".$fila[0];
			$listIncidencias=$con->obtenerListaValores($consulta);
			if($con->filasAfectadas>=$noIncidencias)
			{
				
				$departamento=$con->obtenerValor($consulta);
				$obj='{"idMedicamento":"'.$fila[0].'","medicamento":"'.cv($fila[1]).'","descripcion":"'.cv($fila[2]).'","noIncidencias":"'.$noIncidencias.'","listIncidencias":"'.$listIncidencias.'"}';
				if($arrRegistros=="")
					$arrRegistros=$obj;
				else
					$arrRegistros.=",".$obj;
				$numReg++;
			}
		}
		
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
		
		
	}
?>