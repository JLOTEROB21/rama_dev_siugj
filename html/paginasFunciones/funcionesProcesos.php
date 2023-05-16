<?php session_start();

	include("conexionBD.php"); 
	include("configurarIdioma.php");

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
				buscarProcesos();
			break;
			case 2:
				buscarFolioRegistro();
			break;
			case 3:
				obtenerTareasGeneradasProceso();
			break;
			case 4:
				registroMovimientoCambioEtapaProceso();
			break;
			case 5:
				buscarUsuarioAsignarTarea();
			break;
			case 6:
				aplicarOperacionTarea();
			break;
			
			
		}
	}
	
	
	function buscarProcesos()
	{
		global $con;
		$criterio=$_POST["criterio"];
		$arrRegistros="";
		$numReg=0;
		$consulta="SELECT idProceso,cveProceso,nombre,descripcion,
				(SELECT idFormulario FROM 900_formularios WHERE idProceso=p.idProceso AND formularioBase=1 limit 0,1) as idFormularioPrincipal 
				FROM 4001_procesos p WHERE nombre like '%".$criterio."%' and  situacion=1 AND idTipoProceso <>1 ORDER BY nombre";
		
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_assoc($res))
		{
			$arrEtapas="";
			$consulta="SELECT numEtapa,nombreEtapa FROM 4037_etapas WHERE idProceso=".$fila["idProceso"]." ORDER BY numEtapa";
			$resEtapas=$con->obtenerFilas($consulta);
			while($filaEtapa=mysql_fetch_row($resEtapas))
			{
				$o="[".$filaEtapa[0].",'".removerCerosDerecha($filaEtapa[0]).".- ".$filaEtapa[1]."']";
				if($arrEtapas=="")
					$arrEtapas=$o;
				else
					$arrEtapas.=",".$o;
			}
			$o='{"idProceso":"'.$fila["idProceso"].'","cveProceso":"'.cv($fila["cveProceso"]).'","nombre":"'.cv($fila["nombre"]).
				'","descripcion":"'.cv($fila["descripcion"]).'","idFormularioPrincipal":"'.$fila["idFormularioPrincipal"].
				'","arrEtapas":['.$arrEtapas.']}';	
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			$numReg++;
		}
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
	}
	
	function buscarFolioRegistro()
	{
		global $con;
		$criterio=$_POST["criterio"];
		$idProceso=bD($_POST["iP"]);
		$iFormulario=obtenerFormularioBase($idProceso);
		$nombreTabla=obtenerNombreTabla($iFormulario);
		
		$consulta="SELECT id_".$nombreTabla." as idRegistro,fechaCreacion,idEstado,codigo as folioProceso FROM ".$nombreTabla." WHERE codigo LIKE '%".$criterio."%'";
		
		$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));
		
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrRegistros.'}';
	}
	
	
	function obtenerTareasGeneradasProceso()
	{
		global $con;
		$idFormulario=bD($_POST["iF"]);
		$idRegistro=bD($_POST["iR"]);
		
		$arrRegistros="";
		$numReg=0;
		$consulta="SELECT * FROM 9060_tableroControl_4 WHERE iFormulario=".$idFormulario." AND iRegistro=".$idRegistro." and idUsuarioDestinatario<>1 ORDER BY idRegistro DESC";
		
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_assoc($res))
		{
			$o='{"idTarea":"'.$fila["idRegistro"].'","fechaRegistro":"'.cv($fila["fechaAsignacion"]).'","fechaLimiteAtencion":"'.cv($fila["fechaLimiteAtencion"]).
				'","codigoUnicoProceso":"'.$fila["numeroCarpetaAdministrativa"].
				'","actividad":"'.cv($fila["tipoNotificacion"]).'","responsableAtencion":"'.cv($fila["usuarioDestinatario"]).
				'","statusActual":"'.$fila["idEstado"].'","remitente":"'.cv($fila["usuarioRemitente"]).'"}';	
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			$numReg++;
		}
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
	}
	
	function registroMovimientoCambioEtapaProceso()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$leyenda="";
		
		

		switch($obj->tipoAccion)
		{
			case 1:
				$consulta="SELECT idEstado,codigo FROM _".$obj->idFormulario."_tablaDinamica WHERE id__".$obj->idFormulario."_tablaDinamica=".$obj->idRegistro;
				$fRegistroBase=$con->obtenerPrimeraFilaAsoc($consulta);
				$estadoActual=$fRegistroBase["idEstado"];
				$idProceso=obtenerIdProcesoFormularioBase($obj->idFormulario);
				$consulta="SELECT numEtapa,nombreEtapa FROM 4037_etapas WHERE idProceso=".$idProceso." AND numEtapa=".$estadoActual;
				$fRegistroActual=$con->obtenerPrimeraFilaAsoc($consulta);
				
				$consulta="SELECT numEtapa,nombreEtapa FROM 4037_etapas WHERE idProceso=".$idProceso." AND numEtapa=".$obj->etapaCambio;
				$fRegistroCambio=$con->obtenerPrimeraFilaAsoc($consulta);
				
				$consulta="SELECT cveProceso,nombre FROM 4001_procesos WHERE idProceso=".$idProceso;
				$fRegistroProceso=$con->obtenerPrimeraFilaAsoc($consulta);
				
				$leyenda="Cambio de etapa del proceso: \"".("[".$fRegistroProceso["cveProceso"]." ".$fRegistroProceso["nombre"]."]")."\" con folio: \"".cv($fRegistroBase["codigo"])."\" de etapa \"".($fRegistroActual["numEtapa"].".- ".$fRegistroActual["nombreEtapa"]).
						"\" a etapa \"".($fRegistroCambio["numEtapa"].".- ".$fRegistroCambio["nombreEtapa"])."\".<br><br>Motivo de la operaci&oacute;n:<br><br>".$obj->motivoCambio;
			break;
			case 2:
				$idProceso=obtenerIdProcesoFormularioBase($obj->idFormulario);
				$consulta="SELECT idEstado,codigo FROM _".$obj->idFormulario."_tablaDinamica WHERE id__".$obj->idFormulario."_tablaDinamica=".$obj->idRegistro;
				$fRegistroBase=$con->obtenerPrimeraFilaAsoc($consulta);

				
				$consulta="SELECT cveProceso,nombre FROM 4001_procesos WHERE idProceso=".$idProceso;
				$fRegistroProceso=$con->obtenerPrimeraFilaAsoc($consulta);
				
				$leyenda="Reinicio del proceso: \"".("[".$fRegistroProceso["cveProceso"]." ".$fRegistroProceso["nombre"]."]")."\" con folio: \"".cv($fRegistroBase["codigo"]).
						"\".<br><br>Motivo de la operaci&oacute;n:<br><br>".$obj->motivoCambio;
						
						
				$consulta="update 9060_tableroControl_4 set fechaAtencion='".date("Y-m-d H:i:s")."',idEstado=0,llaveTarea='' WHERE iFormulario=".$obj->idFormulario." AND iRegistro=".$obj->idRegistro;
				$con->ejecutarConsulta($consulta);
									
			break;
			case 3:
				$idProceso=obtenerIdProcesoFormularioBase($obj->idFormulario);
				$consulta="SELECT idEstado,codigo FROM _".$obj->idFormulario."_tablaDinamica WHERE id__".$obj->idFormulario."_tablaDinamica=".$obj->idRegistro;
				$fRegistroBase=$con->obtenerPrimeraFilaAsoc($consulta);

				
				$consulta="SELECT cveProceso,nombre FROM 4001_procesos WHERE idProceso=".$idProceso;
				$fRegistroProceso=$con->obtenerPrimeraFilaAsoc($consulta);
				
				$leyenda="Pausa del proceso: \"".("[".$fRegistroProceso["cveProceso"]." ".$fRegistroProceso["nombre"]."]")."\" con folio: \"".cv($fRegistroBase["codigo"]).
						"\".<br><br>Motivo de la operaci&oacute;n:<br><br>".$obj->motivoCambio;
						
						
				$consulta="update 9060_tableroControl_4 set fechaAtencion='".date("Y-m-d H:i:s")."',idEstado=10 WHERE iFormulario=".$obj->idFormulario." AND iRegistro=".$obj->idRegistro." and idEstado=1";
				$con->ejecutarConsulta($consulta);
				$obj->etapaCambio=500;
				$consulta="SELECT COUNT(*) FROM 4037_etapas WHERE idProceso=".$idProceso." AND numEtapa=500";
				$numRegAux=$con->obtenerValor($consulta);
				
				if($numRegAux==0)
				{
					$consulta="INSERT INTO 4037_etapas(idProceso,numEtapa,nombreEtapa,eliminable,situacion,marcaFinProceso) VALUES(".$idProceso.
						",500,'Proceso Pausado',0,1,0)";
					$con->ejecutarConsulta($consulta);
				}
									
			break;
			case 4:
				$idProceso=obtenerIdProcesoFormularioBase($obj->idFormulario);
				$consulta="SELECT idEstado,codigo FROM _".$obj->idFormulario."_tablaDinamica WHERE id__".$obj->idFormulario."_tablaDinamica=".$obj->idRegistro;
				$fRegistroBase=$con->obtenerPrimeraFilaAsoc($consulta);

				
				$consulta="SELECT cveProceso,nombre FROM 4001_procesos WHERE idProceso=".$idProceso;
				$fRegistroProceso=$con->obtenerPrimeraFilaAsoc($consulta);
				
				$leyenda="Reanudaci&oacute;n del proceso: \"".("[".$fRegistroProceso["cveProceso"]." ".$fRegistroProceso["nombre"]."]")."\" con folio: \"".cv($fRegistroBase["codigo"]).
						"\".<br><br>Motivo de la operaci&oacute;n:<br><br>".$obj->motivoCambio;
						
						
				
				
				$consulta="SELECT etapaAnterior FROM 941_bitacoraEtapasFormularios WHERE idFormulario=".$obj->idFormulario." AND idRegistro=".$obj->idRegistro.
							" AND etapaActual=500 order by idRegistroEstado desc";
				$obj->etapaCambio=$con->obtenerValor($consulta);
									
			break;
			case 5:
				$idProceso=obtenerIdProcesoFormularioBase($obj->idFormulario);
				$consulta="SELECT idEstado,codigo FROM _".$obj->idFormulario."_tablaDinamica WHERE id__".$obj->idFormulario."_tablaDinamica=".$obj->idRegistro;
				$fRegistroBase=$con->obtenerPrimeraFilaAsoc($consulta);

				
				$consulta="SELECT cveProceso,nombre FROM 4001_procesos WHERE idProceso=".$idProceso;
				$fRegistroProceso=$con->obtenerPrimeraFilaAsoc($consulta);
				
				$leyenda="Terminaci&oacute;n del proceso: \"".("[".$fRegistroProceso["cveProceso"]." ".$fRegistroProceso["nombre"]."]")."\" con folio: \"".cv($fRegistroBase["codigo"]).
						"\".<br><br>Motivo de la operaci&oacute;n:<br><br>".$obj->motivoCambio;
						
						
				$consulta="update 9060_tableroControl_4 set fechaAtencion='".date("Y-m-d H:i:s")."',idEstado=5 WHERE iFormulario=".$obj->idFormulario." AND iRegistro=".$obj->idRegistro." and idEstado=1";
				$con->ejecutarConsulta($consulta);
				$obj->etapaCambio=510;
				$consulta="SELECT COUNT(*) FROM 4037_etapas WHERE idProceso=".$idProceso." AND numEtapa=510";
				$numRegAux=$con->obtenerValor($consulta);
				
				if($numRegAux==0)
				{
					$consulta="INSERT INTO 4037_etapas(idProceso,numEtapa,nombreEtapa,eliminable,situacion,marcaFinProceso) VALUES(".$idProceso.
						",510,'Proceso Abortado/Cerrado',0,1,0)";
					$con->ejecutarConsulta($consulta);
				}
									
			break;
		}
		if(cambiarEtapaFormulario($obj->idFormulario,$obj->idRegistro,$obj->etapaCambio,$obj->motivoCambio,-1,"NULL","NULL",0))
		{
			
			guardarRegistroBitacoraSistema("../procesos/frmMovimientoProcesos.php",bE($cadObj),14,$leyenda);
			echo "1|".$obj->etapaCambio;
		}
	}
	
	function buscarUsuarioAsignarTarea()
	{
		global $con;
		$criterio=$_POST["criterio"];
		$numReg=0;
		$consulta="SELECT u.idUsuario,u.Nombre AS nombreUsuario,o.unidad AS adscripcion FROM 800_usuarios u,801_adscripcion a,817_organigrama o 
					WHERE u.Nombre LIKE '%".$criterio."%' 
					AND a.idUsuario=u.idUsuario AND o.codigoUnidad=a.Institucion AND o.codigoUnidad<>'10000004' ORDER BY u.Nombre";
					
		$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));			
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrRegistros.'}';					
	}
	
	function aplicarOperacionTarea()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$consulta="SELECT * FROM 9060_tableroControl_4 WHERE idRegistro=".$obj->idTarea;
		$fTarea=$con->obtenerPrimeraFilaAsoc($consulta);
		switch($obj->tipoOperacion)
		{
			case 1:
				setTareaAtendida($obj->idTarea,4,$_SESSION["idUsr"]);
				$leyenda="Se marca la tarea con ID: \"".$obj->idTarea." asignada al usuario ".$fTarea["usuarioDestinatario"]."\" como \"Atendida\"";
			break;
			case 2:
				$consulta="UPDATE 9060_tableroControl_4 SET idEstado=1 WHERE idRegistro=".$obj->idTarea;
				$con->ejecutarConsulta($consulta);
				$leyenda="Se marca la tarea con ID: \"".$obj->idTarea." asignada al usuario ".$fTarea["usuarioDestinatario"]."\" como \"En espera de atenci&oacute;n\"";
			break;
			case 3:
				$consulta="UPDATE 9060_tableroControl_4 SET idUsuarioDestinatario=".$obj->responsableAsignacion.
						",usuarioDestinatario='".cv(obtenerNombreUsuario($obj->responsableAsignacion)).
						"',contenidoMensaje=REPLACE(contenidoMensaje,'".cv($fTarea["usuarioDestinatario"]).
						"','".cv(obtenerNombreUsuario($obj->responsableAsignacion)).
						"'),fechaLimiteAtencion=".($obj->fechaVencimiento==""?"NULL":"'".$obj->fechaVencimiento."'")." WHERE idRegistro=".$obj->idTarea;

				$con->ejecutarConsulta($consulta);
				$leyenda="Se reasigna la tarea con ID: \"".$obj->idTarea." asignada al usuario ".$fTarea["usuarioDestinatario"]."\" al usuario \"".obtenerNombreUsuario($obj->responsableAsignacion)."\"";
			break;
			case 4:
				$arrCampos="";
				$arrValores="";
				foreach($fTarea as $llave=>$valor)
				{
					if($llave!="idRegistro")
					{
						$valorFinal=$valor;
						
						switch($llave)
						{
							case 'idUsuarioDestinatario':
								$valorFinal=$obj->responsableAsignacion;
							break;
							case 'usuarioDestinatario':
								$valorFinal="'".obtenerNombreUsuario($obj->responsableAsignacion)."'";
							break;
							case 'contenidoMensaje':
								$valorFinal="REPLACE(contenidoMensaje,'".cv($fTarea["usuarioDestinatario"]).
											"','".cv(obtenerNombreUsuario($obj->responsableAsignacion))."')";

							break;
							case 'fechaLimiteAtencion':
								$valorFinal=($obj->fechaVencimiento==""?"NULL":$obj->fechaVencimiento);
								if($valorFinal!="")
									$valorFinal="'".$valorFinal."'";
							break;
							case 'fechaAsignacion':
								$valorFinal="'".date("Y-m-d H:i:s")."'";
							break;
							default:
								if($valorFinal!="")
									$valorFinal="'".cv($valorFinal)."'";
							break;
						}
						
						if($valorFinal=="")	
							$valorFinal="NULL";
						
							
						if($arrCampos=="")
						{
							$arrCampos=$llave;
							$arrValores=$valorFinal;
						}
						else
						{
							$arrCampos.=",".$llave;
							$arrValores.=",".$valorFinal;
						}
					}
					
				}
				$consulta="insert into 9060_tableroControl_4(".$arrCampos.") values(".$arrValores.")";

				$con->ejecutarConsulta($consulta);
				
				$leyenda="Se clona la tarea con ID: \"".$obj->idTarea." asignada al usuario ".$fTarea["usuarioDestinatario"]."\" al usuario \"".obtenerNombreUsuario($obj->responsableAsignacion)."\"";
			break;
		}
		guardarRegistroBitacoraSistema("../procesos/frmMovimientoProcesos.php",bE($cadObj),14,$leyenda.".<br><br>Motivo de la operaci&oacute;n:<br><br>".$obj->motivoOperacion);
		echo "1|";
	}
	
?>