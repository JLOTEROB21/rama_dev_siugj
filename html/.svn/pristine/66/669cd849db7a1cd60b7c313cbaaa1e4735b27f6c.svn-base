<?php
	function esSecretarioPrimeraInstancia()
	{
		global $con;
		$consulta="SELECT tipoUnidad FROM _17_tablaDinamica WHERE claveUnidad='".$_SESSION["codigoInstitucion"]."'";
		$tipoCategoria=$con->obtenerValor($consulta);
		
		return $tipoCategoria==9?1:0;
		
		
	}
	
	function esSecretarioSegundaInstancia()
	{
		global $con;
		$consulta="SELECT tipoUnidad FROM _17_tablaDinamica WHERE claveUnidad='".$_SESSION["codigoInstitucion"]."'";
		$tipoCategoria=$con->obtenerValor($consulta);
		
		return $tipoCategoria==21?1:0;
		
	}
	
	function esSecretarioCorteConstitucional()
	{
		global $con;
		$consulta="SELECT tipoUnidad,unidadPadre FROM _17_tablaDinamica WHERE claveUnidad='".$_SESSION["codigoInstitucion"]."'";
		$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
		$tipoCategoria=$fRegistro["tipoUnidad"];
		if($tipoCategoria==31)
		{
			$unidadPadre=$fRegistro["unidadPadre"];
			$consulta="SELECT institucion FROM 817_organigrama WHERE codigoUnidad='".$unidadPadre."'";
			$tipoCategoria=$con->obtenerValor($consulta);
			if($tipoCategoria==24)
			{

				return 1;
			}
		}
		return $tipoCategoria==25?1:0;
		
	}
	
	
	function existeJuezDespacho($idFormulario,$idRegistro)
	{
		  global $con;
		  $carpetaAdministrativa=obtenerCarpetaAdministrativaProceso($idFormulario,$idRegistro);
			
			
		  if($carpetaAdministrativa!="")
		  {
			  $consulta="SELECT unidadGestion FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaAdministrativa."'";
			  $unidadGestion=$con->obtenerValor($consulta);
		  }
		  else
		  {
			  $consulta="SELECT codigoInstitucion FROM _".$idFormulario."_tablaDinamica WHERE id__".$idFormulario."_tablaDinamica=".$idRegistro;
			  $unidadGestion=$con->obtenerValor($consulta);
	  
		  }
		  
		  
		  $consulta="SELECT count(*) FROM 801_adscripcion ad,807_usuariosVSRoles r WHERE r.idUsuario=ad.idUsuario AND 
				r.codigoRol='56_0' AND ad.Institucion='".$unidadGestion."'";
				
		$numJuez=$con->obtenerValor($consulta);
		
		if($numJuez>0)
		{
			$consulta="SELECT COUNT(*) FROM 7035_informacionDocumentos WHERE idFormulario=757 AND idReferencia=".$idRegistro." AND idFormularioProceso IN(765,1068)";
			$constanciaGuardada=$con->obtenerValor($consulta);
			if($constanciaGuardada>0)
				return 1;
		}
		
		return 0;
				
	}
	
	function existeMagistradoDespacho($idFormulario,$idRegistro)
	{
		  global $con;
		  $carpetaAdministrativa=obtenerCarpetaAdministrativaProceso($idFormulario,$idRegistro);
			
			
		  if($carpetaAdministrativa!="")
		  {
			  $consulta="SELECT unidadGestion FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaAdministrativa."'";
			  $unidadGestion=$con->obtenerValor($consulta);
		  }
		  else
		  {
			  $consulta="SELECT codigoInstitucion FROM _".$idFormulario."_tablaDinamica WHERE id__".$idFormulario."_tablaDinamica=".$idRegistro;
			  $unidadGestion=$con->obtenerValor($consulta);
	  
		  }
		  
		  
		  $consulta="SELECT count(*) FROM 801_adscripcion ad,807_usuariosVSRoles r WHERE r.idUsuario=ad.idUsuario AND 
				r.codigoRol='96_0' AND ad.Institucion='".$unidadGestion."'";
				
		$numJuez=$con->obtenerValor($consulta);
		if($numJuez==0)
			return 0;
		
		$documentoBloqueado=0;
		$consulta="SELECT tipoDocumento FROM 7035_informacionDocumentos WHERE idFormulario=".$idFormulario.
					" AND idReferencia=".$idRegistro." AND tipoDocumento=548";
	
		$iRegistro=$con->obtenerValor($consulta);	
		if($iRegistro!="")
		{
			return 1;
		}
		
		return 0;
		
				
	}
	
	function existeInformeSecretarial($idFormulario,$idRegistro)
	{
		global $con;
		
		$carpetaAdministrativa=obtenerCarpetaAdministrativaProceso($idFormulario,$idRegistro);
		
		$consulta="SELECT tipoProceso FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaAdministrativa."'";
		$tipoProceso=$con->obtenerValor($consulta);
		if($tipoProceso==13)
			return 1;
		return 0;
	}
	
	
	function visualizarOpcionProcesoSIUGJ($idFormulario,$idRegistro,$idOpcion)
	{
		global $con;
		$consulta="SELECT * FROM _".$idFormulario."_tablaDinamica WHERE id__".$idFormulario."_tablaDinamica=".$idRegistro;
		$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
		
		switch($idOpcion)
		{
			case 570:
				if(($fRegistro)&&($fRegistro["idEstado"]>1))
				{
					return 1;
				}
			break;
			
			case 570:
				if(($fRegistro)&&($fRegistro["idEstado"]>=4))
				{
					return 1;
				}
			break;
			case 572:
				if(($fRegistro)&&($fRegistro["idEstado"]>=3.5))
				{
					return 1;
				}
			break;
		}
		
		return 0;
		
	}
	
	
	function existeMagistradoDespachoDocumentoRegistrado($idFormulario,$idRegistro)
	{
		  global $con;
		  $carpetaAdministrativa=obtenerCarpetaAdministrativaProceso($idFormulario,$idRegistro);
			
			
		  if($carpetaAdministrativa!="")
		  {
			  $consulta="SELECT unidadGestion FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaAdministrativa."'";
			  $unidadGestion=$con->obtenerValor($consulta);
		  }
		  else
		  {
			  $consulta="SELECT codigoInstitucion FROM _".$idFormulario."_tablaDinamica WHERE id__".$idFormulario."_tablaDinamica=".$idRegistro;
			  $unidadGestion=$con->obtenerValor($consulta);
	  
		  }
		  
		  
		  $consulta="SELECT count(*) FROM 801_adscripcion ad,807_usuariosVSRoles r WHERE r.idUsuario=ad.idUsuario AND 
				r.codigoRol='96_0' AND ad.Institucion='".$unidadGestion."'";

		$numJuez=$con->obtenerValor($consulta);
		if($numJuez==0)
			return 0;
		
		$documentoBloqueado=0;
		$consulta="SELECT tipoDocumento FROM 7035_informacionDocumentos WHERE idFormulario=".$idFormulario.
					" AND idReferencia=".$idRegistro."";

		$iRegistro=$con->obtenerValor($consulta);	
		if($iRegistro!="")
		{
			return 1;
		}
		
		return 0;
		
				
	}
	
	function existeJuezDespachoDocumentoRegistrado($idFormulario,$idRegistro)
	{
		  global $con;
		  $carpetaAdministrativa=obtenerCarpetaAdministrativaProceso($idFormulario,$idRegistro);
			
			
		  if($carpetaAdministrativa!="")
		  {
			  $consulta="SELECT unidadGestion FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$carpetaAdministrativa."'";
			  $unidadGestion=$con->obtenerValor($consulta);
		  }
		  else
		  {
			  $consulta="SELECT codigoInstitucion FROM _".$idFormulario."_tablaDinamica WHERE id__".$idFormulario."_tablaDinamica=".$idRegistro;
			  $unidadGestion=$con->obtenerValor($consulta);
	  
		  }
		  
		  
		  $consulta="SELECT count(*) FROM 801_adscripcion ad,807_usuariosVSRoles r WHERE r.idUsuario=ad.idUsuario AND 
				r.codigoRol='56_0' AND ad.Institucion='".$unidadGestion."'";
				
		$numJuez=$con->obtenerValor($consulta);
		if($numJuez==0)
			return 0;
		
		$documentoBloqueado=0;
		$consulta="SELECT tipoDocumento FROM 7035_informacionDocumentos WHERE idFormulario=".$idFormulario.
					" AND idReferencia=".$idRegistro."";
	
		$iRegistro=$con->obtenerValor($consulta);	
		if($iRegistro!="")
		{
			return 1;
		}
		
		return 0;
		
				
	}
	
?>
