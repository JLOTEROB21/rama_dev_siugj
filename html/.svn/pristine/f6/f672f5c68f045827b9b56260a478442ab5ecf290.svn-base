<?php 	include("conexionBD.php");
		include_once("sgjp/funcionesAlgoritmosAsignacion.php");
	ini_set("memory_limit","3000M");
	set_time_limit(999000);
	
	$fechaActual=date("Y-m-d H:i:s");
	$tipoTarea=5;
	$mE=0;
	if(isset($_GET["mE"]))
		$mE=$_GET["mE"];
	$idRegistroTarea=registrarBitacoraEjecucionActividadTemporal($tipoTarea);
	try
	{
		$_SESSION["idUsr"]=1;
		$consulta="select codigoRol from 807_usuariosVSRoles where idUsuario=".$_SESSION["idUsr"];
		$resRoles=$con->obtenerFilas($consulta);
		$listaGrupo="";
		while($fRoles=mysql_fetch_row($resRoles))
		{
			$arrRol=explode("_",$fRoles[0]);
			$rol="'".$fRoles[0]."'";
			if($arrRol[1]!="0")
				$rol.=",'".$arrRol[0]."_-1'";
			
			if($listaGrupo=="")
				$listaGrupo=$rol;
			else
				$listaGrupo.=",".$rol;
		}
		if($listaGrupo=="")
			$listaGrupo='-1';
		$_SESSION["idRol"]=$listaGrupo.",'-100_0'";
		$_SESSION["codigoUnidad"]="001";
		$_SESSION["codigoInstitucion"]="001";	
		
		$arrTiposCarpeta[1]="";
		$arrTiposCarpeta[2]="EX";
		$arrTiposCarpeta[3]="AC,AT";
		$arrTiposCarpeta[4]="APEL";
		$arrTiposCarpeta[5]="TE";
		$arrTiposCarpeta[6]="EJEC";
		$arrTiposCarpeta[9]="LN";
		$anio=date("Y");
		$tDelito="";
		
		foreach($arrTiposCarpeta as  $tipoCarpeta=>$extension)
		{
			$consulta=" SELECT u.id__17_tablaDinamica,u.claveUnidad,u.nombreUnidad,claveFolioCarpetas FROM _17_tablaDinamica u,
						_17_tiposCarpetasAdministra tC WHERE tC.idPadre=u.id__17_tablaDinamica AND tC.idOpcion=".$tipoCarpeta." ORDER BY prioridad";
			$res=$con->obtenerFilas($consulta);
			while($fila=mysql_fetch_assoc($res))
			{
				$arrExtension=explode(",",$extension);
				foreach($arrExtension as $tDelito)
				{
				
					$consulta="SELECT * FROM 7004_seriesUnidadesGestion WHERE anio=".$anio." AND idUnidadGestion=".$fila["id__17_tablaDinamica"].
								" AND tipoDelito='".$tDelito."'";
					
					$fRegFolio=$con->obtenerPrimeraFila($consulta);
					$maxNoFolio=$fRegFolio[3];
					if(($maxNoFolio!="")&&($maxNoFolio>0))
					{
						$formatoCarpeta="%/[folio]/".$anio."%";
						switch($tDelito)
						{
							case "AT":
								$formatoCarpeta="%AT/[folio]/".$anio."%";
							break;
							case "AC":
								$formatoCarpeta="%AC/[folio]/".$anio."%";
							break;
						}
						
						$valFolioInicial=$maxNoFolio-25;
						if($valFolioInicial<=0)
							$valFolioInicial=1;
						for($nFolio=$valFolioInicial; $nFolio<=$maxNoFolio;$nFolio++)
						{
							$folio=str_pad($nFolio,4,"0",STR_PAD_LEFT);
							$folio=str_replace("[folio]",$folio,$formatoCarpeta);
							$consulta="SELECT COUNT(*) FROM 7006_carpetasAdministrativas WHERE fechaCreacion>='".$anio."-01-01' AND fechaCreacion<='".$anio.
										"-12-31 23:59:59' AND unidadGestion='".$fila["claveUnidad"]."' AND tipoCarpetaAdministrativa=".$tipoCarpeta.
										" AND carpetaAdministrativa LIKE '".$folio."'";
							$nCarpetas=$con->obtenerValor($consulta);
							if($nCarpetas==0)
							{
								$consulta="UPDATE 7004_seriesUnidadesGestion SET folioActual=".($nFolio-1)." WHERE idSerie=".$fRegFolio[0];
								$con->ejecutarConsulta($consulta);

								$consulta="INSERT INTO 9076_registrosAsociados(idTarea,iFormulario,iRegistro,situacion,tipoTarea,datosComplementarios) 
											VALUES(".$idRegistroTarea.",7004,".$fRegFolio[0].",1,".$tipoTarea.",'[".$nFolio."]')";
								$con->ejecutarConsulta($consulta);								

								
								break;
							}
						}
					}
				}
			}
		}

		
		actualizarRegistroBitacoraEjecucionActividadTemporal($idRegistroTarea,1,"");
		if($mE==1)
		{
			echo "<body><script>window.parent.cerrarVentanaFancy();</script></body>";
		}
	}
	catch(Exception $e)
	{
		if($mE==1)
		{
			echo $e->getMessage();
		}
		actualizarRegistroBitacoraEjecucionActividadTemporal($idRegistroTarea,2,$e->getMessage());
	}
?>