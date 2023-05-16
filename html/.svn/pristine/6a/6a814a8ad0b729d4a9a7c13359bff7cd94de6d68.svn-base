<?php
	function inicializarTemporizadorIngresoDespacho3Dias($idFormulario,$idRegistro)
	{
		global $con;
		
		$arrDatosBase=obtenerRegistroPadre($idFormulario,$idRegistro);
		
		$consulta="SELECT carpetaAdministrativa,codigoInstitucion FROM _696_tablaDinamica WHERE id__696_tablaDinamica=".$idRegistro;
		$fCarpeta=$con->obtenerPrimeraFilaAsoc($consulta);
		$consulta="UPDATE 7006_carpetasAdministrativas SET unidadGestion=CONCAT('[',unidadGestion,']') WHERE carpetaAdministrativa='".$fCarpeta["carpetaAdministrativa"].
				"' AND unidadGestion='".$fCarpeta["codigoInstitucion"]."'";
		return $con->ejecutarConsulta($consulta);

	}
	
	
	function cumplimientoTemporizadorIngresoDespacho3Dias($idFormulario,$idRegistro)
	{
		global $con;

		$arrDatosBase=obtenerRegistroPadre($idFormulario,$idRegistro);
		
		$consulta="SELECT carpetaAdministrativa,codigoInstitucion FROM _696_tablaDinamica WHERE id__696_tablaDinamica=".$idRegistro;
		$fCarpeta=$con->obtenerPrimeraFilaAsoc($consulta);
		
		cambiarEtapaFormulario($arrDatosBase["idFormulario"],$arrDatosBase["idRegistro"],7.5,"",-1,"NULL","NULL",0);
		$consulta="UPDATE 7006_carpetasAdministrativas SET unidadGestion='".$fCarpeta["codigoInstitucion"]."' WHERE carpetaAdministrativa='".$fCarpeta["carpetaAdministrativa"].
				"' AND unidadGestion='[".$fCarpeta["codigoInstitucion"]."]'";
		return $con->ejecutarConsulta($consulta);
	}
	
	function esDestinatarioNotificacionDemandante($idFormulario,$idRegistro)
	{
		global $con;
		
		$consulta="SELECT carpetaAdministrativa FROM _665_tablaDinamica WHERE id__665_tablaDinamica=".$idRegistro;
		$carpetaAdministrativa=$con->obtenerValor($consulta);
		
		$consulta="SELECT idPersona FROM _665_gPersonasNotificar WHERE idReferencia=".$idRegistro;
		$idPersona=$con->obtenerValor($consulta);
		if($idPersona=="")
			$idPersona=-1;
		
		$consulta="SELECT idActividad FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaAdministrativa."'";
		$idActividad=$con->obtenerValor($consulta);
		
		
		$consulta="SELECT idRelacion,idFiguraJuridica FROM 7005_relacionFigurasJuridicasSolicitud WHERE idActividad=".$idActividad." AND idParticipante=".$idPersona;
		$fDatosRelacion=$con->obtenerPrimeraFilaAsoc($consulta);
		if(!$fDatosRelacion)
			return 0;
		$idFiguraJuridica=$fDatosRelacion["idFiguraJuridica"];
		
		$consulta="SELECT naturalezaFigura FROM _5_tablaDinamica WHERE id__5_tablaDinamica=".$idFiguraJuridica;
		$naturalezaFigura=$con->obtenerValor($consulta);

		if($naturalezaFigura=="A")	
			return 1;
	
		if($naturalezaFigura=="N")
		{
			$consulta="SELECT idActorRelacionado FROM 7005_relacionParticipantes  WHERE idActividad=".$idActividad.
						" AND idParticipante=".$fDatosRelacion["idRelacion"]." AND situacion=1";
			$res=$con->obtenerFilas($consulta);
			while($fila=mysql_fetch_assoc($res))
			{
				$consulta="SELECT idFiguraJuridica FROM 7005_relacionFigurasJuridicasSolicitud WHERE idRelacion=".$fila["idActorRelacionado"];
				$fDatosRelacion=$con->obtenerPrimeraFilaAsoc($consulta);
				
				$idFiguraJuridica=$fDatosRelacion["idFiguraJuridica"];
				
				$consulta="SELECT naturalezaFigura FROM _5_tablaDinamica WHERE id__5_tablaDinamica=".$idFiguraJuridica;
				$naturalezaFigura=$con->obtenerValor($consulta);
				
				if($naturalezaFigura=="A")	
					return 1;
				
			}
		}
		
	
		return 0;
		
		
		
		
		                                                                             
	}
	
	function esDestinatarioNotificacionDemandado($idFormulario,$idRegistro)
	{
		global $con;
		
		$consulta="SELECT carpetaAdministrativa FROM _665_tablaDinamica WHERE id__665_tablaDinamica=".$idRegistro;
		$carpetaAdministrativa=$con->obtenerValor($consulta);
		
		$consulta="SELECT idPersona FROM _665_gPersonasNotificar WHERE idReferencia=".$idRegistro;
		$idPersona=$con->obtenerValor($consulta);
		if($idPersona=="")
			$idPersona=-1;
		
		$consulta="SELECT idActividad FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaAdministrativa."'";
		$idActividad=$con->obtenerValor($consulta);
		
		
		$consulta="SELECT idRelacion,idFiguraJuridica FROM 7005_relacionFigurasJuridicasSolicitud WHERE idActividad=".$idActividad." AND idParticipante=".$idPersona;
		$fDatosRelacion=$con->obtenerPrimeraFilaAsoc($consulta);
		if(!$fDatosRelacion)
			return 0;
		$idFiguraJuridica=$fDatosRelacion["idFiguraJuridica"];
		
		$consulta="SELECT naturalezaFigura FROM _5_tablaDinamica WHERE id__5_tablaDinamica=".$idFiguraJuridica;
		$naturalezaFigura=$con->obtenerValor($consulta);
		
		if($naturalezaFigura=="D")	
			return 1;
	
		if($naturalezaFigura=="N")
		{
			$consulta="SELECT idActorRelacionado FROM 7005_relacionParticipantes  WHERE idActividad=".$idActividad.
						" AND idParticipante=".$fDatosRelacion["idRelacion"]." AND situacion=1";
			$res=$con->obtenerFilas($consulta);
			while($fila=mysql_fetch_assoc($res))
			{
				$consulta="SELECT idFiguraJuridica FROM 7005_relacionFigurasJuridicasSolicitud WHERE idRelacion=".$fila["idActorRelacionado"];
				$fDatosRelacion=$con->obtenerPrimeraFilaAsoc($consulta);
				
				$idFiguraJuridica=$fDatosRelacion["idFiguraJuridica"];
				
				$consulta="SELECT naturalezaFigura FROM _5_tablaDinamica WHERE id__5_tablaDinamica=".$idFiguraJuridica;
				$naturalezaFigura=$con->obtenerValor($consulta);
				
				if($naturalezaFigura=="D")	
					return 1;
				
			}
		}
		
	
		return 0;
		
		
		                                                                             
	}
	
	
	function esDestinatarioNotificacionMinisterioPublico($idFormulario,$idRegistro)
	{
		global $con;
		
		$consulta="SELECT carpetaAdministrativa FROM _665_tablaDinamica WHERE id__665_tablaDinamica=".$idRegistro;
		$carpetaAdministrativa=$con->obtenerValor($consulta);
		
		$consulta="SELECT idPersona FROM _665_gPersonasNotificar WHERE idReferencia=".$idRegistro;
		$idPersona=$con->obtenerValor($consulta);
		if($idPersona<0)
		{
			$consulta="SELECT COUNT(*) FROM 807_usuariosVSRoles r where idUsuario=".abs($idPersona)." and codigoRol='240_0'";
			$numRegistros=$con->obtenerValor($consulta);
			
			
			return $numRegistros==0?0:1;
		}
		else
		{
			if($idPersona>0)
			{
				$consulta="SELECT COUNT(*) FROM _665_gPersonasNotificar WHERE idReferencia=".$idRegistro." AND idPersona=480593";
				$numRegistros=$con->obtenerValor($consulta);
				return $numRegistros==0?0:1;
			}
			
			return 0;
		}
		
		
		
		
		return 0;
		
		
		                                                                             
	}
	
	function esDestinatarioNotificacionVinculado($idFormulario,$idRegistro)
	{
		global $con;
		
		$consulta="SELECT carpetaAdministrativa FROM _665_tablaDinamica WHERE id__665_tablaDinamica=".$idRegistro;
		$carpetaAdministrativa=$con->obtenerValor($consulta);
		
		$consulta="SELECT idPersona FROM _665_gPersonasNotificar WHERE idReferencia=".$idRegistro;
		$idPersona=$con->obtenerValor($consulta);
		if($idPersona=="")
			$idPersona=-1;
		
		$consulta="SELECT idActividad FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaAdministrativa."'";
		$idActividad=$con->obtenerValor($consulta);
		
		$consulta="SELECT COUNT(*) FROM 7005_relacionFigurasJuridicasSolicitud r,_5_tablaDinamica f WHERE r.idActividad=".$idActividad." AND r.idParticipante=".$idPersona."
					AND f.id__5_tablaDinamica=r.idFiguraJuridica AND f.naturalezaFigura='V'";
		$numRegistros=$con->obtenerValor($consulta);
		
		
		return $numRegistros==0?0:1;
		
		
		                                                                             
	}
	
	function obtenerUsuarioDestinatarioNotificacion($idFormulario,$idRegistro)
	{
		global $con;
		$idCuentaAcceso=-1;
		$consulta="SELECT carpetaAdministrativa FROM _665_tablaDinamica WHERE id__665_tablaDinamica=".$idRegistro;
		$carpetaAdministrativa=$con->obtenerValor($consulta);
		
		$consulta="SELECT idPersona FROM _665_gPersonasNotificar WHERE idReferencia=".$idRegistro;
		$idPersona=$con->obtenerValor($consulta);
		if($idPersona!="")
		{
			if($idPersona<0)
			{
				return abs($idPersona);
			}
			$consulta="SELECT idActividad FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaAdministrativa."'";
			$idActividad=$con->obtenerValor($consulta);
			
			$consulta="SELECT r.idCuentaAcceso FROM 7005_relacionFigurasJuridicasSolicitud r WHERE r.idActividad=".$idActividad." AND r.idParticipante=".$idPersona;
			$idCuentaAcceso=$con->obtenerValor($consulta);
			
			if($idCuentaAcceso=="")
				$idCuentaAcceso=-1;
		}
		return $idCuentaAcceso;
		
		
		                                                                             
	}
	
	
	function obtenerActorDestinatarioNotificacion($idFormulario,$idRegistro)
	{
		global $con;
		
		$consulta="SELECT carpetaAdministrativa FROM _665_tablaDinamica WHERE id__665_tablaDinamica=".$idRegistro;
		$carpetaAdministrativa=$con->obtenerValor($consulta);
		
		$consulta="SELECT idPersona FROM _665_gPersonasNotificar WHERE idReferencia=".$idRegistro;
		$idPersona=$con->obtenerValor($consulta);
		if($idPersona=="")
			$idPersona=-1;
		
		
		return $idPersona;
	}
	
	
	function esCarpetaAdministrativaCasacion($idFormulario,$idRegistro)
	{
		global $con;
		$cAdminitrativa=obtenerCarpetaAdministrativaProceso($idFormulario,$idRegistro);
		$consulta="SELECT tipoCarpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$cAdminitrativa."'";
		$tipoCarpetaAdministrativa=$con->obtenerValor($consulta);
		if($tipoCarpetaAdministrativa==20)
			return 1;
		return 0;
		
	}
	
	
	function esDestinatarioNotificacionTribunalAndino($idFormulario,$idRegistro)
	{
		global $con;
		
		$consulta="SELECT carpetaAdministrativa FROM _665_tablaDinamica WHERE id__665_tablaDinamica=".$idRegistro;
		$carpetaAdministrativa=$con->obtenerValor($consulta);
		
		$consulta="SELECT idPersona FROM _665_gPersonasNotificar WHERE idReferencia=".$idRegistro;
		
		$idPersona=$con->obtenerValor($consulta);
		if($idPersona<0)
		{
			$consulta="SELECT COUNT(*) FROM 807_usuariosVSRoles r where idUsuario=".abs($idPersona)." and codigoRol='242_0'";
			$numRegistros=$con->obtenerValor($consulta);
			
			
			return $numRegistros==0?0:1;
		}
		else
		{
			if($idPersona>0)
			{
				$consulta="SELECT COUNT(*) FROM _665_gPersonasNotificar WHERE idReferencia=".$idRegistro." AND idPersona=480594";
				$numRegistros=$con->obtenerValor($consulta);
				return $numRegistros==0?0:1;
			}
			
			return 0;
		}
		
		
		
		
		return 0;
		
		
		                                                                             
	}
	
	
	function esDestinatarioNotificacionDemandanteUnicaInstancia($idFormulario,$idRegistro)
	{
		global $con;
		
		$consulta="SELECT carpetaAdministrativa FROM _665_tablaDinamica WHERE id__665_tablaDinamica=".$idRegistro;
		$carpetaAdministrativa=$con->obtenerValor($consulta);
		
		$consulta="SELECT tipoProceso FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaAdministrativa."'";
		$tipoProceso=$con->obtenerValor($consulta);
		
		if($tipoProceso!=20)
			return 0;
		
		return esDestinatarioNotificacionDemandante($idFormulario,$idRegistro);
		
		
		                                                                             
	}
?>
