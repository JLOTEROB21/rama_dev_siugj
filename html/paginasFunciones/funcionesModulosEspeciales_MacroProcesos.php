<?php
	session_start();
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
				guardarDatosMacroProceso();
			break;
			case 2:
				obtenerProcesosAsociadosMacroProceso();
			break;
			case 3:	
				obtenerActuacionesMacroProceso();
			break;
			case 4:
				registrarActuacionMacroProceso();
			break;
			case 5:
				removerActuacionesMacroProceso();
			break;
			case 6:
				obtenerNotificacionesMacroProceso();
			break;
			case 7:
				obtenerTerminosProcesalesMacroProceso();
			break;
			case 8:
				removerTerminoProcesalMacroProceso();
			break;
			case 9:
				registrarTerminoProcesalMacroProceso();
			break;
			case 10:
				removerNotificacionMacroProceso();
			break;
			case 11:
				obtenerEtapasProcesalesMacroProceso();
			break;
			case 12:
				removerEtapaProcesalMacroProceso();
			break;
			case 13:
				registrarEtapaProcesalMacroProceso();
			break;
			case 14:
				registrarProcesoMacroProceso();
			break;
			case 15:
				removerProcesoMacroProceso();
			break;
			case 16:
				obtenerEscenarioProcesoMacroProceso();
			break;
			case 17:
				obtenerEtapasProcesoEscenario();
			break;
			case 18;
				obtenerCamposFormularioProceso();
			break;
			case 19;
				registrarProcesoEtapaMacropoceso();
			break;
			case 20:
				removerProcesoEtapaMacroproceso();
			break;
			case 21:
				registrarActuacionProcesoEtapaMacroproceso();
			break;
			case 22:
				removerElementoProcesoEtapaMacroproceso();
			break;
			case 23:
				registrarEtapaProcesalProcesoEtapaMacroproceso();
			break;
			case 24:
				obtenerCamposProcesoArranqueMacroProceso();
			break;
			case 25:
				registrarTerminoProcesalProcesoEtapaMacroproceso();
			break;
			case 26:
				obtenerTemporizadorProcesalesMacroProceso();
			break;
			case 27:
				registrarTemporizadorProcesalMacroProceso();
			break;
			case 28:
				removerTemporizadorProcesalMacroProceso();
			break;
			case 29:
				registrarNotificacionProcesoEtapaMacroproceso();
			break;
			case 30:
				obtenerEventosDespacho();
			break;
			case 31:
				obtenerEventosCarpetaJudicial();
			break;
			case 32:
				cambiarSituacionEventosCarpetaJudicial();
			break;
			
		}
		
	}
	
	function guardarDatosMacroProceso()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		$x=0;
		$consulta[$x]="begin";
		$x++;
		if($obj->idRegistro==-1)
		{
			$consulta[$x]="INSERT INTO 00001_macroProcesos(cveMacroProceso,nombreMacroProceso,descripcion,fechaCreacion,responsableCreacion,situacionActual,idFuncionAplicacion)
						VALUES('".cv($obj->cveMacroProceso)."','".cv($obj->nombreMacroProceso)."','".cv($obj->descripcion)."','".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",".$obj->situacion.
						",".$obj->funcionAplicacion.")";
			$x++;
			$consulta[$x]="set @idRegistro:=(select last_insert_id())";
			$x++;
		}
		else
		{
			$consulta[$x]="UPDATE 00001_macroProcesos SET cveMacroProceso='".cv($obj->cveMacroProceso)."',nombreMacroProceso='".cv($obj->nombreMacroProceso)."',descripcion='".cv($obj->descripcion).
						"',fechaCreacion='".date("Y-m-d H:i:s")."',responsableCreacion=".$_SESSION["idUsr"].",situacionActual=".$obj->situacion.
						",idFuncionAplicacion=".$obj->funcionAplicacion." where idRegistro=".$obj->idRegistro;

			$x++;
			$consulta[$x]="set @idRegistro:=".$obj->idRegistro;
			$x++;
		}
		
		$consulta[$x]="commit";
		$x++;
		
		if($con->ejecutarBloque($consulta))
		{
			
			$query="select  @idRegistro";
			$obj->idRegistro=$con->obtenerValor($query);
			
			echo "1|".$obj->idRegistro;
		}
		
	}
	
	
	function obtenerProcesosAsociadosMacroProceso()
	{
		global $con;
		$idMacroProceso=$_POST["iM"];
		
		$consulta="SELECT p.idProceso,p.cveProceso,p.nombre as nombreProceso,pA.campoProcesoJudicial,
				(select nombreConsulta from 991_consultasSql WHERE idConsulta=pA.idFuncionDeterminadoraProcesoJudicia) as funcionProcesoJudicial  
				FROM 00002_procesosAsociadosMacroProceso pA,4001_procesos p WHERE pA.idMacroProceso=".$idMacroProceso."
					AND p.idProceso=pA.idProceso ORDER BY p.cveProceso,p.nombre";
		$arrRegistros=$con->obtenerFilasJSON($consulta);
		
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrRegistros).'}';
		
		
		
		
	}
	
	function obtenerActuacionesMacroProceso()
	{
		global $con;
		$idMacroProceso=$_POST["iM"];
		
		$consulta="SELECT e.idRegistro,e.cveEtiquetaActuacion,e.etiquetaActuacion,e.descripcion FROM 00003_etiquetasActuaciones e  ORDER BY e.cveEtiquetaActuacion";
		if($idMacroProceso==-1)
		{
			$consulta="SELECT e.idRegistro,e.cveEtiquetaActuacion,e.etiquetaActuacion,e.descripcion FROM 00003_etiquetasActuaciones e where 1=2 ORDER BY e.cveEtiquetaActuacion";
		}
		$arrRegistros=$con->obtenerFilasJSON($consulta);
		
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrRegistros).'}';
		
	}
	
	
	function registrarActuacionMacroProceso()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		$x=0;
		$consulta[$x]="begin";
		$x++;
		if($obj->idRegistro==-1)
		{
		
			$consulta[$x]="INSERT INTO 00003_etiquetasActuaciones(cveEtiquetaActuacion,etiquetaActuacion,descripcion) VALUES('".cv($obj->cveActuacion)."','".cv($obj->tituloActuacion)."','".cv($obj->descripcion)."')";
			$x++;
			$consulta[$x]="set @idRegistro:=(select last_insert_id())";
			$x++;
			$consulta[$x]="INSERT INTO 00004_etiquetasActuacionesMacroProcesos(idMacroProceso,idEtiquetaActuacion) VALUES(".$obj->idMacroProceso.",@idRegistro)";
			$x++;
		}
		else
		{
			$consulta[$x]="update 00003_etiquetasActuaciones set cveEtiquetaActuacion='".cv($obj->cveActuacion)."',etiquetaActuacion='".cv($obj->tituloActuacion)."',descripcion='".cv($obj->descripcion)."' where idRegistro=".$obj->idRegistro;
			$x++;
		}
		
		$consulta[$x]="commit";
		$x++;
		
		eB($consulta);
		
	}
	
	function removerActuacionesMacroProceso()
	{
		global $con;
		$iA=$_POST["iA"];
		$iM=$_POST["iM"];
		
		$query="SELECT COUNT(*) FROM 00004_etiquetasActuacionesMacroProcesos WHERE idEtiquetaActuacion=".$iA;
		$numReg=$con->obtenerValor($query);
		
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="DELETE FROM 00004_etiquetasActuacionesMacroProcesos WHERE idMacroProceso=".$iM." AND idEtiquetaActuacion=".$iA;
		$x++;
		if($numReg<=1)
		{
			$consulta[$x]="DELETE FROM 00003_etiquetasActuaciones WHERE idRegistro=".$iA;
			$x++;	
		}
		
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
		
		
	}
	
	function obtenerNotificacionesMacroProceso()
	{
		global $con;
		$iM=$_POST["iM"];
		$consulta="SELECT idNotificacion as idRegistro,cveNotificacion,tituloNotificacion,descripcion FROM 9067_notificacionesProceso WHERE idMacroProceso=".$iM;
		$arrRegistros=$con->obtenerFilasJSON($consulta);
		
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrRegistros).'}';
		
		
	}
	
	function obtenerTerminosProcesalesMacroProceso()
	{
		global $con;
		global $con;
		$idMacroProceso=$_POST["iM"];
		
		//$consulta="SELECT e.idRegistro,e.cveTermino,e.tituloTermino,e.descripcion FROM 00006_etiquetasTerminosMacroProcesos eA,00005_etiquetaTerminosProcesales e WHERE  eA.idMacroProceso=".$idMacroProceso."
		//		AND e.idRegistro=eA.idEtiquetaTermino ORDER BY e.cveTermino";
		$consulta="SELECT e.idRegistro,e.cveTermino,e.tituloTermino,e.descripcion FROM 00005_etiquetaTerminosProcesales e ORDER BY e.cveTermino";		
		if($idMacroProceso==-1)
		{
			$consulta="SELECT e.idRegistro,e.cveTermino,e.tituloTermino,e.descripcion FROM 00005_etiquetaTerminosProcesales e where 1=2 ORDER BY e.cveTermino";
		}
		
		$arrRegistros=$con->obtenerFilasJSON($consulta);
		
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrRegistros).'}';
		
	}
	
	
	function removerTerminoProcesalMacroProceso()
	{
		global $con;
		$iT=$_POST["iT"];
		$iM=$_POST["iM"];
		
		$query="SELECT COUNT(*) FROM 00006_etiquetasTerminosMacroProcesos WHERE idEtiquetaTermino=".$iT;
		$numReg=$con->obtenerValor($query);
		
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="DELETE FROM 00006_etiquetasTerminosMacroProcesos WHERE idMacroProceso=".$iM." AND idEtiquetaTermino=".$iT;
		$x++;
		if($numReg<=1)
		{
			$consulta[$x]="DELETE FROM 00005_etiquetaTerminosProcesales WHERE idRegistro=".$iT;
			$x++;	
		}
		
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
		
		
	}
	
	
	function removerNotificacionMacroProceso()
	{
		global $con;

		$iN=$_POST["iN"];
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="DELETE FROM 9067_notificacionesProceso WHERE idNotificacion=".$iN;
		$x++;
		$consulta[$x]="DELETE FROM 9068_configuracionNotificacionTableroControl WHERE idNotificacion=".$iN;
		$x++;
		$consulta[$x]="DELETE FROM 9069_valoresReferenciaNotificaciones WHERE idNotificacion=".$iN;
		$x++;
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
		
		
	}
	
	
	function registrarTerminoProcesalMacroProceso()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		$x=0;
		$consulta[$x]="begin";
		$x++;
		if($obj->idRegistro==-1)
		{
		
			$consulta[$x]="INSERT INTO 00005_etiquetaTerminosProcesales(cveTermino,tituloTermino,descripcion) VALUES('".cv($obj->cveTermino)."','".cv($obj->tituloTermino)."','".cv($obj->descripcion)."')";
			$x++;
			$consulta[$x]="set @idRegistro:=(select last_insert_id())";
			$x++;
			$consulta[$x]="INSERT INTO 00006_etiquetasTerminosMacroProcesos(idMacroProceso,idEtiquetaTermino) VALUES(".$obj->idMacroProceso.",@idRegistro)";
			$x++;
		}
		else
		{
			$consulta[$x]="update 00005_etiquetaTerminosProcesales set cveTermino='".cv($obj->cveTermino)."',tituloTermino='".cv($obj->tituloTermino)."',descripcion='".cv($obj->descripcion)."' where idRegistro=".$obj->idRegistro;
			$x++;
		}
		
		$consulta[$x]="commit";
		$x++;
		
		eB($consulta);
		
	}
	
	function obtenerEtapasProcesalesMacroProceso()
	{
		global $con;
		global $con;
		$idMacroProceso=$_POST["iM"];
		
		
		$consulta="SELECT e.idRegistro,e.cveEtiquetaEtapa,e.etiquetaEtapa,e.descripcion FROM 00007_etiquetasEtapasProcesales e ORDER BY e.cveEtiquetaEtapa";
		if($idMacroProceso==-1)
		{
			$consulta="SELECT e.idRegistro,e.cveEtiquetaEtapa,e.etiquetaEtapa,e.descripcion FROM 00007_etiquetasEtapasProcesales e where 1=2 ORDER BY e.cveEtiquetaEtapa";
		}

		$arrRegistros=$con->obtenerFilasJSON($consulta);
		
		
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrRegistros).'}';
		
	}
	
	function removerEtapaProcesalMacroProceso()
	{
		global $con;
		$iE=$_POST["iE"];
		$iM=$_POST["iM"];
		
		$query="SELECT COUNT(*) FROM 00008_etiquetasEtapasProcesalesMacroProcesos WHERE idEtiquetaEtapa=".$iE;
		$numReg=$con->obtenerValor($query);
		
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="DELETE FROM 00008_etiquetasEtapasProcesalesMacroProcesos WHERE idMacroProceso=".$iM." AND idEtiquetaEtapa=".$iE;
		$x++;
		if($numReg<=1)
		{
			$consulta[$x]="DELETE FROM 00007_etiquetasEtapasProcesales WHERE idRegistro=".$iE;
			$x++;	
		}
		
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
		
		
	}
	
	function registrarEtapaProcesalMacroProceso()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		$x=0;
		$consulta[$x]="begin";
		$x++;
		if($obj->idRegistro==-1)
		{
		
			$consulta[$x]="INSERT INTO 00007_etiquetasEtapasProcesales(cveEtiquetaEtapa,etiquetaEtapa,descripcion) VALUES('".cv($obj->cveEtapa)."','".cv($obj->etiquetaEtapa)."','".cv($obj->descripcion)."')";
			$x++;
			$consulta[$x]="set @idRegistro:=(select last_insert_id())";
			$x++;
			$consulta[$x]="INSERT INTO 00008_etiquetasEtapasProcesalesMacroProcesos(idMacroProceso,idEtiquetaEtapa) VALUES(".$obj->idMacroProceso.",@idRegistro)";
			$x++;
		}
		else
		{
			$consulta[$x]="update 00007_etiquetasEtapasProcesales set cveEtiquetaEtapa='".cv($obj->cveEtapa)."',etiquetaEtapa='".cv($obj->etiquetaEtapa)."',descripcion='".cv($obj->descripcion)."' where idRegistro=".$obj->idRegistro;
			$x++;
		}
		
		$consulta[$x]="commit";
		$x++;
		
		eB($consulta);
		
	}
	
	function registrarProcesoMacroProceso()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="INSERT INTO 00002_procesosAsociadosMacroProceso(idMacroProceso,idProceso,campoProcesoJudicial,idFuncionDeterminadoraProcesoJudicia) 
					VALUES(".$obj->iM.",".$obj->iP.",'".cv($obj->cExpediente)."','".($obj->iFExpediente==''?-1:$obj->iFExpediente)."')";
		$x++;
		
		$consulta[$x]="commit";
		$x++;
		
		eB($consulta);
		
	}
	
	function removerProcesoMacroProceso()
	{
		global $con;
		$iM=$_POST["iM"];
		$iP=$_POST["iP"];
		
		
		$consulta="DELETE FROM 00002_procesosAsociadosMacroProceso WHERE idMacroProceso=".$iM." AND idProceso=".$iP;
		eC($consulta);
	}
	
	function obtenerEscenarioProcesoMacroProceso()
	{
		global $con;
		$iM=$_POST["iM"];
		$arrRegistros="";
		$consulta="SELECT e.idRegistro,p.nombre,e.etapa,p.idProceso,p.cveProceso,e.metodoAplicacion,e.idFuncionAplicacion,e.condicionesAplicacion
				FROM 00009_etapasProcesosMacroprocesos e,4001_procesos p WHERE idRegistroMacroproceso=".$iM." and p.idProceso=e.idProceso ORDER BY idRegistro";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_assoc($res))
		{
			$consulta="SELECT numEtapa,nombreEtapa FROM 4037_etapas WHERE idProceso=".$fila["idProceso"]." AND numEtapa=".$fila["etapa"];
			$fEtapa=$con->obtenerPrimeraFilaAsoc($consulta);
			
			$consulta="SELECT nombreConsulta FROM 991_consultasSql WHERE idConsulta=".$fila["idFuncionAplicacion"];
			$lblFuncionAplicacion=$con->obtenerValor($consulta);
			
			$lblMetodoAplicacion="";
			switch($fila["metodoAplicacion"])
			{
				case 0:
					$lblMetodoAplicacion="(Ninguno)";
				break;
				case 1:
					$lblMetodoAplicacion="Mediante Funci&oacute;n de Sistema";
				break;
				case 2:
					$lblMetodoAplicacion="Mediante Regla de Comparaci&oacute;n";
				break;
			}
			
			$objCondiciones='{"condiciones":'.($fila["condicionesAplicacion"]==""?"[]":$fila["condicionesAplicacion"]).'}';
			$oCondiciones=json_decode($objCondiciones);
			$condicionAplicacion="";
			foreach($oCondiciones->condiciones as $c)
			{
				if($condicionAplicacion=="")
					$condicionAplicacion=$c->tokenUsuario;
				else
					$condicionAplicacion.=" and ".$c->tokenUsuario;
			}
			if($condicionAplicacion!="")
			{
				$lblMetodoAplicacion.=' <span title="Condici&oacute;n: '.$condicionAplicacion.'" alt="Condici&oacute;n:  '.$condicionAplicacion.'"><img src="../images/icon_comment.gif" width="14" height="14"></span>';
			}
			else
				if($lblFuncionAplicacion!="")
				{
					$lblMetodoAplicacion.=' (Funci&oacute;n de aplicaci&oacute;n: '.$lblFuncionAplicacion.')';
				}
			
			$arrChildren="";
			$consulta="SELECT idRegistro,tipoElemento,idRegistroElemento,idFuncionAplicacion,idFuncionRenderer,idFuncionDetalle,
						(SELECT nombreConsulta FROM 991_consultasSql WHERE idConsulta=e.idFuncionAplicacion) AS lblFuncionAplicacion,
						(SELECT nombreConsulta FROM 991_consultasSql WHERE idConsulta=e.idFuncionRenderer) AS lblFuncionRenderer,
						e.objConfiguracion,
						(SELECT nombreConsulta FROM 991_consultasSql WHERE idConsulta=e.idFuncionDetalle) AS lblMetodoDetalle,
						idFuncionUsuarioAsignado, (SELECT nombreConsulta FROM 991_consultasSql WHERE idConsulta=e.idFuncionUsuarioAsignado) AS lblMetodoUsuarioAsignado
						 FROM 00010_elementosEtapasProcesosMacroprocesos e WHERE idRegistroEtapaProcesoMacroproceso=".$fila["idRegistro"];

			$rElementosHijos=$con->obtenerFilas($consulta);
			while($fElementoHijo=mysql_fetch_assoc($rElementosHijos))
			{
				$tipoElemento="";
				$lblElemento="";
				$cveElemento="";
				$lblEtiquetaElemento="";
				$idRegistroElemento="";
				switch($fElementoHijo["tipoElemento"])
				{
					case 2:
						$tipoElemento="Actuaci&oacute;n";
						$consulta="SELECT cveEtiquetaActuacion,etiquetaActuacion,idRegistro FROM 00003_etiquetasActuaciones WHERE idRegistro=".$fElementoHijo["idRegistroElemento"];
						$fElemento=$con->obtenerPrimeraFilaAsoc($consulta);
						
						$lblElemento="[".$fElemento["cveEtiquetaActuacion"]."] ".$fElemento["etiquetaActuacion"];
						$cveElemento=$fElemento["cveEtiquetaActuacion"];
						$lblEtiquetaElemento=$fElemento["etiquetaActuacion"];
						$idRegistroElemento=$fElemento["idRegistro"];
						
					break;
					case 3:
						$tipoElemento="Cambio de Etapa Procesal";
						$consulta="SELECT cveEtiquetaEtapa,etiquetaEtapa,idRegistro FROM 00007_etiquetasEtapasProcesales WHERE idRegistro=".$fElementoHijo["idRegistroElemento"];
						$fElemento=$con->obtenerPrimeraFilaAsoc($consulta);
						$lblElemento="[".$fElemento["cveEtiquetaEtapa"]."] ".$fElemento["etiquetaEtapa"];
						$cveElemento=$fElemento["cveEtiquetaEtapa"];
						$lblEtiquetaElemento=$fElemento["etiquetaEtapa"];
						$idRegistroElemento=$fElemento["idRegistro"];
					break;
					case 4:
						$tipoElemento="T&eacute;rmino Procesal";
						$consulta="SELECT cveTermino,tituloTermino,idRegistro FROM 00005_etiquetaTerminosProcesales WHERE idRegistro=".$fElementoHijo["idRegistroElemento"];
						$fElemento=$con->obtenerPrimeraFilaAsoc($consulta);
						$lblElemento="[".$fElemento["cveTermino"]."] ".$fElemento["tituloTermino"];
						$cveElemento=$fElemento["cveTermino"];
						$lblEtiquetaElemento=$fElemento["tituloTermino"];
						$idRegistroElemento=$fElemento["idRegistro"];
					break;
					case 5:
						$tipoElemento="Temporizador";
						$consulta="SELECT cveTemporizador,tituloTemporizador,idRegistro FROM 00011_etiquetaTemporizadores WHERE idRegistro=".$fElementoHijo["idRegistroElemento"];
						$fElemento=$con->obtenerPrimeraFilaAsoc($consulta);
						$lblElemento="[".$fElemento["cveTemporizador"]."] ".$fElemento["tituloTemporizador"];
						$cveElemento=$fElemento["cveTemporizador"];
						$lblEtiquetaElemento=$fElemento["tituloTemporizador"];
						$idRegistroElemento=$fElemento["idRegistro"];
					break;
					case 6:
						$tipoElemento="Notificaci&oacute;n";
						$consulta="SELECT cveNotificacion,tituloNotificacion,idNotificacion as idRegistro FROM 9067_notificacionesProceso WHERE idNotificacion=".$fElementoHijo["idRegistroElemento"];
						$fElemento=$con->obtenerPrimeraFilaAsoc($consulta);
						$lblElemento="[".$fElemento["cveNotificacion"]."] ".$fElemento["tituloNotificacion"];
						$cveElemento=$fElemento["cveNotificacion"];
						$lblEtiquetaElemento=$fElemento["tituloNotificacion"];
						$idRegistroElemento=$fElemento["idRegistro"];
					break;
				}
				
				$cadObjComp="";
				$cadObjConf="";
				if($fElementoHijo["objConfiguracion"]!="")
				{
					$lblFuncionAuxiliar="";
					$lblFuncionCumplimiento="";
					$lblFuncionVencimiento="";
					$cadObjConf=$fElementoHijo["objConfiguracion"];
					$objConf=json_decode($cadObjConf);
					$cadObjComp="";
					if(isset($objConf->datosGenerales))
					{
						$consulta="SELECT nombreConsulta FROM 991_consultasSql WHERE idConsulta=".$objConf->datosGenerales->txtFuncionPeriodoTermino;
						$lblFuncionAuxiliar=$con->obtenerValor($consulta);
						
						$consulta="SELECT nombreConsulta FROM 991_consultasSql WHERE idConsulta=".$objConf->cumplimientoTermino->funcionEjecucion;
						$lblFuncionCumplimiento=$con->obtenerValor($consulta);
						
						$consulta="SELECT nombreConsulta FROM 991_consultasSql WHERE idConsulta=".$objConf->vencimientoTermino->funcionEjecucion;
						$lblFuncionVencimiento=$con->obtenerValor($consulta);
						
						$lblFuncionArranque="";
						if(isset($objConf->arranqueTermino))
						{
							$consulta="SELECT nombreConsulta FROM 991_consultasSql WHERE idConsulta=".$objConf->arranqueTermino->funcionEjecucion;
							$lblFuncionArranque=$con->obtenerValor($consulta);
						}
						$lblFuncionCondicionalArranqueTermino="";
						if(isset($objConf->arranqueTermino->funcionCondicionalArranque))
						{
							$consulta="SELECT nombreConsulta FROM 991_consultasSql WHERE idConsulta=".$objConf->arranqueTermino->funcionCondicionalArranque;
							$lblFuncionCondicionalArranqueTermino=$con->obtenerValor($consulta);
						}
						$lblFuncionCondicionalCumplimientoTermino="";
						if(isset($objConf->cumplimientoTermino->funcionCondicionalArranque))
						{
							$consulta="SELECT nombreConsulta FROM 991_consultasSql WHERE idConsulta=".$objConf->cumplimientoTermino->funcionCondicionalArranque;
							$lblFuncionCondicionalCumplimientoTermino=$con->obtenerValor($consulta);
						}
						$lblFuncionCondicionalVencimientoTermino="";
						if(isset($objConf->vencimientoTermino->funcionCondicionalArranque))
						{
							$consulta="SELECT nombreConsulta FROM 991_consultasSql WHERE idConsulta=".$objConf->vencimientoTermino->funcionCondicionalArranque;
							$lblFuncionCondicionalVencimientoTermino=$con->obtenerValor($consulta);
						}
						$cadObjComp='{"lblFuncionPeriodoTermino":"'.cv($lblFuncionAuxiliar).'","lblFuncionCumplimiento":"'.cv($lblFuncionCumplimiento).
								'","lblFuncionVencimiento":"'.cv($lblFuncionVencimiento).'","lblFuncionArranque":"'.cv($lblFuncionArranque).
								'","lblFuncionCondicionalArranqueTermino":"'.cv($lblFuncionCondicionalArranqueTermino).
								'","lblFuncionCondicionalCumplimientoTermino":"'.cv($lblFuncionCondicionalCumplimientoTermino).
								'","lblFuncionCondicionalVencimientoTermino":"'.cv($lblFuncionCondicionalVencimientoTermino).'"';
					}

					if(isset($objConf->funcionAsignacionDestinatario))
					{
						$consulta="SELECT nombreConsulta FROM 991_consultasSql WHERE idConsulta=".$objConf->funcionAsignacionDestinatario;
						$lblFuncionAsignacionDestinatario=$con->obtenerValor($consulta);
						
						
						$cadObjComp='{"lblFuncionAsignacionDestinatario":"'.cv($lblFuncionAsignacionDestinatario).'"';
					}
					
					if(isset($objConf->confComplementaria) && isset($objConf->confComplementaria->funcionAplicacion))
					{
						$consulta="SELECT nombreConsulta FROM 991_consultasSql WHERE idConsulta=".$objConf->confComplementaria->funcionAplicacion;
						$lblFuncionAplicacionMarcaAsignacion=$con->obtenerValor($consulta);
						$cadObjComp.=',"lblFuncionAplicacionMarcaAsignacion":"'.cv($lblFuncionAplicacionMarcaAsignacion).'"';
					}
					
					$cadObjComp.="}";

					
				}
				$o='{"id":"e_'.$fElementoHijo["idRegistro"].'","text":"'.cv($lblElemento).'","tipoElemento":"'.cv($tipoElemento).'","idTipoElemento":"'.$fElementoHijo["tipoElemento"].
					'","etapa":"","idFuncionAplicacion":"'.$fElementoHijo["idFuncionAplicacion"].'","lblMetodoAplicacion":"'.cv($fElementoHijo["lblFuncionAplicacion"]).
					'","funcionRenderer":"'.$fElementoHijo["idFuncionRenderer"].'","lblFuncionRenderer":"'.cv($fElementoHijo["lblFuncionRenderer"]).'","allowDrop":false,leaf:true,"btnRemover":"<span onclick=\"javascript:removerElementoProcesoEscenario(\''.
					bE($fElementoHijo["idRegistro"]).'\')\"><img src=\"../images/delete.png\" height=\"14\" width=\"14\"></span>","espacio":"","btnEditar":"<span onclick=\"javascript:modificarElementoProcesoEscenario(\''.bE($fElementoHijo["idRegistro"]).
				'\')\"><img src=\"../images/pencil.png\" height=\"14\" width=\"14\"></a>","cveElemento":"'.cv($cveElemento).'","lblElemento":"'.cv($lblElemento).
				'","idElemento":"'.$idRegistroElemento.'","objConfiguracion":"'.bE($cadObjConf).'","objConfiguracionComplementaria":"'.bE($cadObjComp).
				'","idFuncionDetalle":"'.$fElementoHijo["idFuncionDetalle"].'","lblMetodoDetalle":"'.cv($fElementoHijo["lblMetodoDetalle"]).
				'","idFuncionUsuarioAsignado":"'.$fElementoHijo["idFuncionUsuarioAsignado"].'","lblMetodoUsuarioAsignado":"'.$fElementoHijo["lblMetodoUsuarioAsignado"].'"}';
				if($arrChildren=="")
					$arrChildren=$o;
				else
					$arrChildren.=",".$o;
					
			}
			
			$arrChildren="[".$arrChildren."]";

			$descripcion="<span style='color:#000; font-weight:bold'>[".cv($fila["cveProceso"])."] ".$fila["nombre"]."</span>";
			$o='{"icon":"../images/add.png","id":"p_'.$fila["idRegistro"].'","idRegistroProceso":"'.$fila["idRegistro"].'","leaf":'.($arrChildren=="[]"?"true":"false").',"iProceso":"'.$fila["idProceso"].
					'","espacio":"","lblTipoProceso":"['.cv($fila["cveProceso"]).'] '.cv($fila["nombre"]).
				'","numEtapa":"'.$fila["etapa"].'","tipoElemento":"Proceso","idTipoElemento":"1","text":"'.cv($descripcion).
				'","etapa":"' .removerCerosDerecha($fEtapa["numEtapa"].".- ".$fEtapa["nombreEtapa"]).
				'","btnEditar":"<span onclick=\"javascript:modificarProcesoEscenario(\''.bE($fila["idRegistro"]).
				'\')\"><img src=\"../images/pencil.png\" height=\"14\" width=\"14\"></a>","btnRemover":"<span onclick=\"javascript:removerProcesoEscenario(\''.bE($fila["idRegistro"]).
				'\')\"><img src=\"../images/delete.png\" height=\"14\" width=\"14\"></span>","metodoAplicacion":"'.$fila["metodoAplicacion"].'","iFuncionAplicacion":"'.$fila["idFuncionAplicacion"].
				'","condiciones":"'.bE($fila["condicionesAplicacion"]).'","lblFuncionAplicacion":"'.cv($lblFuncionAplicacion).'","lblMetodoAplicacion":"'.cv($lblMetodoAplicacion).
				'","condicionAplicacion":"'.$condicionAplicacion.'","children":'.$arrChildren.',"allowDrop":true,"expanded":true,"lblFuncionRenderer":""}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
		}
		
		echo "[".$arrRegistros."]";
		
	}
	
	function obtenerEtapasProcesoEscenario()
	{
		global $con;
		
		$arrRegistros="";
		$iP=$_POST["iP"];
		$consulta="SELECT numEtapa,nombreEtapa FROM 4037_etapas WHERE idProceso=".$iP." ORDER BY numEtapa";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_assoc($res))
		{
			$o="['".removerCerosDerecha($fila["numEtapa"])."','".removerCerosDerecha($fila["numEtapa"]).".- ".cv($fila["nombreEtapa"])."']";
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
		}
		
		$arrCamposFinal=array();
		$idFormulario=obtenerFormularioBase($iP);
		$nTabla=obtenerNombreTabla($idFormulario);
		$arrCampos=$con->obtenerCamposTabla($nTabla,true,false,true,1);
		if(sizeof($arrCampos)>0)
		{
			foreach($arrCampos as $tmp=>$resto)
			{
				$arrCamposFinal[$tmp]=$resto;
			}
		}
		
		
		ksort($arrCamposFinal);
		$arrObj="";
		foreach($arrCamposFinal as $nCampo=>$objCampo)
		{
			$obj="['".$objCampo[0]."','".$nCampo."','".$objCampo[1]."','".$objCampo[2]."','".$objCampo[3]."','".$objCampo[4]."','".$objCampo[5]."']";
			if($arrObj=="")
				$arrObj=$obj;
			else
				$arrObj.=",".$obj;
		}
		
		echo "1|[".$arrRegistros."]|[".uEJ($arrObj)."]";
	}
	
	
	function obtenerCamposFormularioProceso()
	{
		global $con;
		$iProceso=$_POST["iP"];
		
		$idFormularioBase=obtenerFormularioBase($iProceso);
		
		$arrRegistros="";
		$nombreTabla=obtenerNombreTabla($idFormularioBase);
		$consulta="SELECT COLUMN_NAME FROM information_schema.COLUMNS c WHERE TABLE_SCHEMA='".$con->bdActual."' AND  TABLE_NAME='".$nombreTabla."'";

		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_assoc($res))
		{
			$o="['".$fila["COLUMN_NAME"]."','".$fila["COLUMN_NAME"]."']";
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
		}
		
		echo "1|[".$arrRegistros."]";
	}
	
	function registrarProcesoEtapaMacropoceso()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);

		switch($obj->metodoAplicacion)
		{
			case 0:
				$obj->consultaAplicacion="";
				$obj->funcionAplicacion="-1";
			break;
			case 1:
				$obj->consultaAplicacion="";
				
			break;
			case 2:
				$obj->funcionAplicacion="-1";
			break;
			
		}
		$consulta="";
		if($obj->idRegistroProceso==-1)
		{
			$consulta="INSERT INTO 00009_etapasProcesosMacroprocesos(idRegistroMacroproceso,idProceso,etapa,idFuncionAplicacion,condicionesAplicacion,metodoAplicacion)
					VALUES(".$obj->idMacroProceso.",".$obj->idProceso.",".$obj->etapaProceso.",".$obj->funcionAplicacion.",'[".cv(urldecode(bD($obj->consultaAplicacion)))."]',".$obj->metodoAplicacion.")";
		}
		else
		{
			$consulta="update 00009_etapasProcesosMacroprocesos set idProceso=".$obj->idProceso.",etapa=".$obj->etapaProceso.",idFuncionAplicacion=".$obj->funcionAplicacion.
					",condicionesAplicacion='[".cv(urldecode(bD($obj->consultaAplicacion)))."]',metodoAplicacion=".$obj->metodoAplicacion." where idRegistro=".$obj->idRegistroProceso;
				
		}

		eC($consulta);			
	}
	
	function removerProcesoEtapaMacroproceso()
	{
		global $con;
		$iP=$_POST["iP"];
		
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="DELETE FROM 00009_etapasProcesosMacroprocesos WHERE idRegistro=".bD($iP);
		$x++;
		$consulta[$x]="DELETE FROM 00010_elementosEtapasProcesosMacroprocesos WHERE idRegistroEtapaProcesoMacroproceso=".bD($iP);
		$x++;
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
	}
	
	
	function registrarActuacionProcesoEtapaMacroproceso()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		if($obj->idRegistro==-1)
		{
			$consulta="INSERT INTO 00010_elementosEtapasProcesosMacroprocesos(idRegistroEtapaProcesoMacroproceso,tipoElemento,idRegistroElemento,idFuncionRenderer,idFuncionAplicacion,idFuncionDetalle)
						values(".$obj->idNodoProceso.",2,".$obj->idActuacion.",".$obj->funcionRenderer.",".$obj->funcionAplicacion.",".$obj->funcionDetalle.")";
		}
		else
		{
			$consulta="UPDATE 00010_elementosEtapasProcesosMacroprocesos SET idFuncionRenderer=".$obj->funcionRenderer.",idFuncionAplicacion=".$obj->funcionAplicacion.",idFuncionDetalle=".$obj->funcionDetalle.
					" WHERE idRegistro=".$obj->idRegistro;
		}
		eC($consulta);
		
	}
	
	function removerElementoProcesoEtapaMacroproceso()
	{
		global $con;
		$iE=$_POST["iE"];
		
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="DELETE FROM 00010_elementosEtapasProcesosMacroprocesos WHERE idRegistro=".bD($iE);
		$x++;
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
	}
	
	function registrarEtapaProcesalProcesoEtapaMacroproceso()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$consulta="";
		if($obj->idRegistro==-1)
		{
			$consulta="INSERT INTO 00010_elementosEtapasProcesosMacroprocesos(idRegistroEtapaProcesoMacroproceso,tipoElemento,idRegistroElemento,idFuncionRenderer,idFuncionAplicacion)
						values(".$obj->idNodoProceso.",3,".$obj->idEtapaProcesal.",".$obj->funcionRenderer.",".$obj->functionAplicacion.")";
		}
		else
		{
			$consulta="update 00010_elementosEtapasProcesosMacroprocesos  set idFuncionRenderer=".$obj->funcionRenderer.",idFuncionAplicacion=".$obj->functionAplicacion." where idRegistro=".$obj->idRegistro;
						
		}
		eC($consulta);
		
	}
	
	function obtenerCamposProcesoArranqueMacroProceso()
	{
		global $con;
		$idProcesoDestino=bD($_POST["idProcesoDestino"]);	
		$idProcesoOrigen=bD($_POST["idProcesoOrigen"]);		
		$idRegistro=bD($_POST["idEtapaProcesoMacropoceso"]);
		$tipoGrid=bD($_POST["tipoGrid"]);
		$idRegistroEdita=bD($_POST["idRegistro"]);
		$numReg=0;
		$arrTipoDatos=array();
		$consulta="SELECT tipoDatoServidor,nombreTipoDato FROM 9063_tiposValoresDato ORDER BY tipoDatoServidor";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_assoc($res))
		{
			$arrTipoDatos[$fila["tipoDatoServidor"]]=$fila["nombreTipoDato"];
		}
		
		$idFormularioBase=obtenerFormularioBase($idProcesoDestino);
		if($idFormularioBase=="")
		{
			echo '{"numReg":"0","registros":[]}';
			return;
		}
		$arrValoresTabla=array();
		$arrCumplimientoTermino=array();
		$arrVencimientoTermino=array();
		$arrValoresArranque=array();
		$objConfiguracion=NULL;
		$consulta="SELECT objConfiguracion FROM 00010_elementosEtapasProcesosMacroprocesos WHERE idRegistro=".$idRegistroEdita;
		$cadObjConfiguracion=$con->obtenerValor($consulta);
		
		if($cadObjConfiguracion!="")
		{
			$objConfiguracion=json_decode($cadObjConfiguracion);
			
			switch($tipoGrid)
			{
				case 1:
					if(isset($objConfiguracion->cumplimientoTermino))
					{
						foreach($objConfiguracion->cumplimientoTermino->valoresArranque as $v)
						{
							$arrValoresTabla[$v->campoDestino]=array();
							$arrValoresTabla[$v->campoDestino]["tipoLlenado"]=$v->tipoLlenado;
							$arrValoresTabla[$v->campoDestino]["valor"]=$v->valor;
							
						}
					}
				break;
				case 2://Vencimiento
					if(isset($objConfiguracion->vencimientoTermino))
					{
						foreach($objConfiguracion->vencimientoTermino->valoresArranque as $v)
						{
							$arrValoresTabla[$v->campoDestino]=array();
							$arrValoresTabla[$v->campoDestino]["tipoLlenado"]=$v->tipoLlenado;
							$arrValoresTabla[$v->campoDestino]["valor"]=$v->valor;
							
						}
					}
				break;
				case 3:
					if(isset($objConfiguracion->arranqueTermino))
					{
						foreach($objConfiguracion->arranqueTermino->valoresArranque as $v)
						{
							$arrValoresTabla[$v->campoDestino]=array();
							$arrValoresTabla[$v->campoDestino]["tipoLlenado"]=$v->tipoLlenado;
							$arrValoresTabla[$v->campoDestino]["valor"]=$v->valor;
							
						}
					}
				break;
				case 4:
					if(isset($objConfiguracion->valoresArranque))
					{
						foreach($objConfiguracion->valoresArranque as $v)
						{
							$arrValoresTabla[$v->campoDestino]=array();
							$arrValoresTabla[$v->campoDestino]["tipoLlenado"]=$v->tipoLlenado;
							$arrValoresTabla[$v->campoDestino]["valor"]=$v->valor;
							
						}
					}
				break;
				
			}
			
			
				
		}
		
		/*$consulta="SELECT idRegistroArrancador FROM 9080_arrancadoresProceso WHERE idProcesoOrigen=".$idProcesOrigen." AND idProcesoDestino=".$idProcesoDestino." AND numEtapaProcesoOrigen=".$numEtapa;
		$idRegistroArrancador=$con->obtenerValor($consulta);
		if($idRegistroArrancador=="")*/
			$idRegistroArrancador=$idRegistro;

		$arrRegistros="";
		$nombreTabla=obtenerNombreTabla($idFormularioBase);
		$consulta="SELECT COLUMN_NAME,DATA_TYPE,(select count(*) FROM 9017_camposControlFormulario where campoMysql=c.COLUMN_NAME) esCampoDefault  
					FROM information_schema.COLUMNS c WHERE TABLE_SCHEMA='".$con->bdActual."' AND  TABLE_NAME='".$nombreTabla."' AND COLUMN_NAME not in('id_".$nombreTabla."','idReferenciaArrancador') ";

		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_assoc($res))
		{
			
			/*$consulta="SELECT * FROM 9081_parametrosInicialesArrancadoresProceso WHERE idRegistroArrancador=".$idRegistroArrancador." and campoTablaDestino='".$fila["COLUMN_NAME"]."'";
			$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);*/
			$fRegistro=NULL;
			
			if(isset($arrValoresTabla[$fila["COLUMN_NAME"]]))
			{
				$fRegistro=array();
				$fRegistro["tipoLlenado"]=$arrValoresTabla[$fila["COLUMN_NAME"]]["tipoLlenado"];
				$fRegistro["valor"]=$arrValoresTabla[$fila["COLUMN_NAME"]]["valor"];
			}
			$valorAux=-1;
			$tipoLlenado="0";
			$etiquetaValor="";
			$valor="";
			if($fRegistro)
			{
				$tipoLlenado=$fRegistro["tipoLlenado"];
				$valorAux=$fRegistro["valor"];
				if($valorAux=="")
					$valorAux=-1;
				
				switch($tipoLlenado)
				{
					case 1:					
					case 2:	
						$consulta="SELECT descripcionValor FROM 8003_valoresSesion WHERE idValorSesion=".$valorAux;
						$etiquetaValor=$con->obtenerValor($consulta);
					break;
					case 3:
						$consulta="SELECT nombreDataSet FROM 9014_almacenesDatos WHERE idDataSet=".$valorAux;
						$etiquetaValor=$con->obtenerValor($consulta);
						
					break;
					case 4:
						if($valorAux!=-1)
						{
							$objValor=json_decode($valorAux);
							$consulta="SELECT nombreDataSet FROM 9014_almacenesDatos WHERE idDataSet=".$objValor->idAlmacen;
							$etiquetaValor=$con->obtenerValor($consulta)." (Campo: ".$objValor->campoUsr.")";
							
						}
					break;
					case 5:
						switch($valorAux)
						{
							case "idUsuarioDestinatario":
								$etiquetaValor="ID usuario destinatario";
							break;
							case "nombreUsuarioDestinatario":
								$etiquetaValor="Nombre usuario destinatario";
							break;
							case "idUsuarioRemitente":
								$etiquetaValor="ID usuario remitente";
							break;
							case "nombreUsuarioRemitente":
								$etiquetaValor="Nombre usuario remitente";
							break;
							case "idFormulario":
								$etiquetaValor="ID formulario";
							break;
							case "idRegistro":
								$etiquetaValor="ID registro";
							break;
							case "idReferencia":
								$etiquetaValor="ID registro referencia";
							break;
							case "idProceso":
								$etiquetaValor="ID proceso";
							break;
						}
					break;
					case 6:
						if($valorAux<0)
						{
							$consulta="SELECT campoUsr FROM 9017_camposControlFormulario WHERE tipoElemento=".$valorAux;
							
							$etiquetaValor=$con->obtenerValor($consulta);
						}
						else
						{
							$consulta="SELECT nombreCampo FROM 901_elementosFormulario WHERE idGrupoElemento=".$valorAux;
							$etiquetaValor=$con->obtenerValor($consulta);
						}
					break;
					case 7:
						$consulta="SELECT nombreConsulta FROM 991_consultasSql WHERE idConsulta=".$valorAux;
						$etiquetaValor=$con->obtenerValor($consulta);
					break;
					case 8:
						if($valorAux!=-1)
							$etiquetaValor=$valorAux;
					break;
				}
				
				
			}
			
			$o='{"nombreCampo":"'.$fila["COLUMN_NAME"].'","esCampoDefault":"'.($fila["esCampoDefault"]>0?"1":"0").'","tipoDato":"'.(isset($arrTipoDatos[$fila["DATA_TYPE"]])?$arrTipoDatos[$fila["DATA_TYPE"]]:"Otro").
				'","tipoLlenado":"'.$tipoLlenado.'","etiquetaValor":"'.cv($etiquetaValor).'","valor":"'.$valorAux.'"}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			
			$numReg++;
		}
		
		
		$idFormularioBase=obtenerFormularioBase($idProcesoOrigen);
		
		//$arrRegistrosCamposBase="";
		//$nombreTabla=obtenerNombreTabla($idFormularioBase);
		
		
		$consulta="select * from(SELECT idGrupoElemento as idGrupoElemento,nombreCampo FROM 901_elementosFormulario WHERE idFormulario=".$idFormularioBase." AND tipoElemento IN(2,3,4,5,6,7,8,9,10,11,12,14,15,16,21,22,24,25,31)
			union
			SELECT tipoElemento as idGrupoElemento,campoUsr as nombreCampo FROM 9017_camposControlFormulario) as tmp order by nombreCampo 
		";
		$arrCamposFormularioBase=$con->obtenerFilasArreglo($consulta);
		
		
		
		/*$consulta="SELECT COLUMN_NAME FROM information_schema.COLUMNS c WHERE TABLE_SCHEMA='".$con->bdActual."' AND  TABLE_NAME='".$nombreTabla."'";

		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_assoc($res))
		{
			$o="['".$fila["COLUMN_NAME"]."','".$fila["COLUMN_NAME"]."']";
			if($arrRegistrosCamposBase=="")
				$arrRegistrosCamposBase=$o;
			else
				$arrRegistrosCamposBase.=",".$o;
		}*/
		
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.'],"camposFormularioBase":'.$arrCamposFormularioBase.'}';
		
	}
	
	
	function registrarTerminoProcesalProcesoEtapaMacroproceso()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);

		
		$consulta="";
		if($obj->idRegistro==-1)
		{
			$consulta="INSERT INTO 00010_elementosEtapasProcesosMacroprocesos(idRegistroEtapaProcesoMacroproceso,tipoElemento,idRegistroElemento,idFuncionRenderer,
						idFuncionAplicacion,objConfiguracion,idFuncionDetalle,idFuncionUsuarioAsignado)
						values(".$obj->idPadre.",".$obj->tipoElemento.",".$obj->idTerminoProcesal.",".$obj->funcionRenderer.",".$obj->functionAplicacion.",'".cv(bD($obj->objConfiguracionAccion)).
						"','".$obj->funcionDetalle."',".((!isset($obj->funcionAsignacionUsuario) || $obj->funcionAsignacionUsuario=='')?-1:$obj->funcionAsignacionUsuario).")";
		}
		else
		{
			$consulta="update 00010_elementosEtapasProcesosMacroprocesos set idFuncionRenderer=".$obj->funcionRenderer.",idFuncionAplicacion=".$obj->functionAplicacion.",objConfiguracion='".
					cv(bD($obj->objConfiguracionAccion))."',idFuncionDetalle='".$obj->funcionDetalle."',idFuncionUsuarioAsignado=".
					((!isset($obj->funcionAsignacionUsuario) || $obj->funcionAsignacionUsuario=='')?-1:$obj->funcionAsignacionUsuario)." where idRegistro=".$obj->idRegistro;
						
		}
		eC($consulta);
		
	}
	
	function obtenerTemporizadorProcesalesMacroProceso()
	{
		global $con;
		global $con;
		$idMacroProceso=$_POST["iM"];
		
		$consulta="SELECT e.idRegistro,e.cveTemporizador,e.tituloTemporizador,e.descripcion FROM 00011_etiquetaTemporizadores e ORDER BY e.cveTemporizador";
		if($idMacroProceso==-1)
		{
			$consulta="SELECT e.idRegistro,e.cveTemporizador,e.tituloTemporizador,e.descripcion FROM 00011_etiquetaTemporizadores eA where 1=2 ORDER BY e.cveTemporizador";
		}

		$arrRegistros=$con->obtenerFilasJSON($consulta);
		
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrRegistros).'}';
		
	}
	
	function registrarTemporizadorProcesalMacroProceso()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		$x=0;
		$consulta[$x]="begin";
		$x++;
		if($obj->idRegistro==-1)
		{
		
			$consulta[$x]="INSERT INTO 00011_etiquetaTemporizadores(cveTemporizador,tituloTemporizador,descripcion) VALUES('".cv($obj->cveTemporizador)."','".cv($obj->tituloTemporizador)."','".cv($obj->descripcion)."')";
			$x++;
			$consulta[$x]="set @idRegistro:=(select last_insert_id())";
			$x++;
			$consulta[$x]="INSERT INTO 00012_etiquetasTemporizadoresMacroProcesos(idMacroProceso,idEtiquetaTemporizador) VALUES(".$obj->idMacroProceso.",@idRegistro)";
			$x++;
		}
		else
		{
			$consulta[$x]="update 00011_etiquetaTemporizadores set cveTemporizador='".cv($obj->cveTemporizador)."',tituloTemporizador='".cv($obj->tituloTemporizador)."',descripcion='".cv($obj->descripcion).
						"' where idRegistro=".$obj->idRegistro;
			$x++;
		}
		
		$consulta[$x]="commit";
		$x++;
		
		eB($consulta);
		
	}
	
	function removerTemporizadorProcesalMacroProceso()
	{
		global $con;
		$iT=$_POST["iT"];
		$iM=$_POST["iM"];
		
		$query="SELECT COUNT(*) FROM 00012_etiquetasTemporizadoresMacroProcesos WHERE idEtiquetaTemporizador=".$iT;
		$numReg=$con->obtenerValor($query);
		
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="DELETE FROM 00012_etiquetasTemporizadoresMacroProcesos WHERE idMacroProceso=".$iM." AND idEtiquetaTemporizador=".$iT;
		$x++;
		if($numReg<=1)
		{
			$consulta[$x]="DELETE FROM 00011_etiquetaTemporizadores WHERE idRegistro=".$iT;
			$x++;	
		}
		
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
		
		
	}
	
	function registrarNotificacionProcesoEtapaMacroproceso()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$consulta="";
		
		$obj->funcionAplicacion=$obj->funcionAplicacion==""?-1:$obj->funcionAplicacion;
		if($obj->idRegistro==-1)
		{
			$consulta="INSERT INTO 00010_elementosEtapasProcesosMacroprocesos(idRegistroEtapaProcesoMacroproceso,tipoElemento,idRegistroElemento,idFuncionRenderer,idFuncionAplicacion,objConfiguracion)
						values(".$obj->idPadre.",6,".$obj->idNotificacion.",".$obj->funcionRenderer.",".$obj->funcionAplicacion.",'".cv(bD($obj->objConfiguracionAccion))."')";
		}
		else
		{
			$consulta="update 00010_elementosEtapasProcesosMacroprocesos set idFuncionRenderer=".$obj->funcionRenderer.",idFuncionAplicacion=".$obj->funcionAplicacion.",objConfiguracion='".
					cv(bD($obj->objConfiguracionAccion))."' where idRegistro=".$obj->idRegistro;
		
		}
		eC($consulta);
		
	}
	
	function obtenerEventosDespacho()
	{
		global $con;
		$start=$_POST["start"];
		$end=$_POST["end"];
		$arrEventos="";
		$consulta="SELECT r.* FROM 00013_registrosMacroProceso r
					WHERE  r.codigoInstitucion='".$_SESSION["codigoInstitucion"]."' AND r.fechaMaximaAtencion IS NOT NULL 
					AND '".$start."'<=r.fechaMaximaAtencion AND '".$end." 23:59:59' >=r.fechaMaximaAtencion and r.situacionActual<>0";
					
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_assoc($res))
		{
			$imagen="";
			$titulo=$fila["carpetaAdministrativa"]."__".$fila["lblEtiquetaRegistro"];
			if($fila["detalleComplementario"]!="")
			{
				$titulo.="__".$fila["detalleComplementario"];
			}
			$color="";
			switch($fila["situacionActual"])
			{
				case 1: //
					$color="B0F2C8";
				break;
				case 2: //Cumplido
					$color="CFDFFC";
				break;
				case 3: //Venbcido
					$color="FF8383";
				break;
			}
			$e='{"id":"e_'.$fila["idRegistro"].'","carpetaAdministrativa":"'.$fila["carpetaAdministrativa"].'","allDay":true,"editable":false,"title":"'.($titulo).'","start":"'.date("Y-m-d",strtotime($fila["fechaMaximaAtencion"])).'","color":"#'.$color.'"}';	
				if($arrEventos=="")
					$arrEventos=$e;
				else
					$arrEventos.=",".$e;
		}
		
		echo '['.$arrEventos.']';
	}
	
	function obtenerEventosCarpetaJudicial()
	{
		global $con;
		$carpetaAdministrativa=$_POST["carpetaAdministrativa"];
		
		
		$consulta="SELECT idRegistro,fechaRegistro,iFormulario,iRegistro,tipoRegistro,lblEtiquetaRegistro,situacionActual,detalleComplementario,
					(SELECT Nombre FROM 800_usuarios WHERE idUsuario=r.idUsuarioAsignacion) AS idUsuarioAsignacion,fechaMaximaAtencion 
					FROM 00013_registrosMacroProceso r WHERE carpetaAdministrativa='".$carpetaAdministrativa."'
					ORDER BY idRegistro";
		$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrRegistros.'}'	;				
		
	}
	
	function cambiarSituacionEventosCarpetaJudicial()
	{
		global $con;
		$idRegistro=$_POST["idRegistro"];
		$situacion=$_POST["situacion"];
		$iFormulario=$_POST["iFormulario"];
		$iRegistro=$_POST["iRegistro"];
		
		$idProceso=obtenerIdProcesoFormulario($iFormulario);
		$cadParametros='{"idFormulario":"'.$iFormulario.'","idRegistro":"'.$iRegistro.'","idProceso":"'.$idProceso.
						'","idActorProceso":"0","campoTablaDestino":"","etapa":"0","idMacroProceso":"",
						"idRegistroProcesoEtapaMacroProceso":"","idElementoEvaluacion":"","tipoElemento":"",
						"idRegistroElemento":"","lblEtiquetaElemento":"","iFormulario":"'.$iFormulario.'","iRegistro":"'.$iRegistro.'"}';
		$objParametros=json_decode($cadParametros);	

		$cAdmonMacroProceso=new cMacroProcesoAdmon($iFormulario,$iRegistro,$objParametros);
		
		switch($situacion)
		{
			case 1:
				$cAdmonMacroProceso->marcarRegistroMacroProcesoArranque($idRegistro);
			break;
			case 2:
				$cAdmonMacroProceso->marcarRegistroMacroProcesoAtendido($idRegistro);
			break;
			case 3:
				$cAdmonMacroProceso->marcarRegistroMacroProcesoIncumplido($idRegistro);
			break;	
		}
			
			
		echo "1|";	
	}
?>