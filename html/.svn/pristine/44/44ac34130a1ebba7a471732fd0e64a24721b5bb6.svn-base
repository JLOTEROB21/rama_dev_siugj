<?php session_start();
	include_once("conexionBD.php");
	include_once("utiles.php");
	


	
	if(isset($_POST["parametros"]))
		$parametros=$_POST["parametros"];
	if(isset($_POST["funcion"]))
		$funcion=$_POST["funcion"];
	$lenguaje=$_SESSION["leng"];
	
	switch($funcion)
	{
		case 1:
			obtenerDemandasProgramaTrabajoAccionPublica();
		break;
		case 2:
			obtenerDemandasDisponiblesProgramaTrabajoAccionPublica();
		break;
		case 3:
			agregarDemandaProgramaTrabajoAccionPublica();
		break;
		case 4:
			removerDemandaProgramaTrabajoAccionPublica();
		break;
		case 5:
			ejecutarRepartoDespachoProgramaTrabajo();
		break;
		
	}
	




	function obtenerDemandasProgramaTrabajoAccionPublica()
	{
		global $con;
		
		$numReg=0;
		$idRegistro=$_POST["idRegistro"];
		$arrRegistros="";
		$consulta="SELECT * FROM 04000_demandasProgramaTrabajo WHERE idFormulario=1108 AND idReferencia=".$idRegistro;
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_assoc($res))
		{
			
			$consulta="SELECT * FROM _1004_tablaDinamica WHERE id__1004_tablaDinamica=".$fila["iRegistro"];
			$fDemanda=$con->obtenerPrimeraFilaAsoc($consulta);
			
			$consulta="SELECT fechaCambio FROM 941_bitacoraEtapasFormularios WHERE idFormulario=1004 AND idRegistro=".$fila["iRegistro"]." AND etapaActual=4";
			$fechaRegistro=$con->obtenerValor($consulta);
			$idActividad=$fDemanda["idActividad"];
			
			$demantante="";
			$consulta="SELECT upper(CONCAT(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno))) 
						FROM _47_tablaDinamica p,7005_relacionFigurasJuridicasSolicitud r WHERE r.idParticipante=p.id__47_tablaDinamica
						AND r.idActividad=".$idActividad." AND r.idFiguraJuridica in(SELECT id__5_tablaDinamica FROM _5_tablaDinamica WHERE naturalezaFigura='A') ORDER BY nombre,nombre,apellidoMaterno";
			
			$res=$con->obtenerFilas($consulta);
			while($filaImputado=mysql_fetch_row($res))
			{
				$nombre=trim($filaImputado[0]);
				if($demantante=="")
					$demantante=$nombre;
				else
					$demantante.=", ".$nombre;
			}
		
			$demandados="";
			$consulta="SELECT upper(CONCAT(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno))) 
						FROM _47_tablaDinamica p,7005_relacionFigurasJuridicasSolicitud r WHERE r.idParticipante=p.id__47_tablaDinamica
						AND r.idActividad=".$idActividad." AND r.idFiguraJuridica in(SELECT id__5_tablaDinamica FROM _5_tablaDinamica WHERE naturalezaFigura='D') ORDER BY nombre,nombre,apellidoMaterno";
			
			$res=$con->obtenerFilas($consulta);
			while($filaImputado=mysql_fetch_row($res))
			{
				$nombre=trim($filaImputado[0]);
				if($demandados=="")
					$demandados=$nombre;
				else
					$demandados.=", ".$nombre;
			}
			
			$o='{"idRegistro":"'.$fila["iRegistro"].'","folioRegistro":"'.$fDemanda["codigo"].
				'","fechaRegistro":"'.$fechaRegistro.'","demandante":"'.cv($demantante).
				'","demandado":"'.cv($demandados).'","normaInconstitucional":"'.cv($fDemanda["normaInconstitucional"]).
				'","despachoAsignado":"'.$fila["despachoAsignado"].'","carpetaAdministrativa":"'.$fDemanda["carpetaAdministrativa"].'"}';	
		
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			$numReg++;
		}
		
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
			
	}
	
	
	function obtenerDemandasDisponiblesProgramaTrabajoAccionPublica()
	{
		global $con;
		
		$numReg=0;

		$arrRegistros="";
		$consulta="SELECT * FROM _1004_tablaDinamica WHERE idEstado=5 and id__1004_tablaDinamica not in(SELECT iRegistro FROM 04000_demandasProgramaTrabajo)";
		$res=$con->obtenerFilas($consulta);
		while($fDemanda=mysql_fetch_assoc($res))
		{
			
			
			
			$consulta="SELECT fechaCambio FROM 941_bitacoraEtapasFormularios WHERE idFormulario=1004 AND idRegistro=".
					$fDemanda["id__1004_tablaDinamica"]." AND etapaActual=5";
			$fechaRegistro=$con->obtenerValor($consulta);
			$idActividad=$fDemanda["idActividad"];
			
			$demantante="";
			$consulta="SELECT upper(CONCAT(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno))) 
						FROM _47_tablaDinamica p,7005_relacionFigurasJuridicasSolicitud r WHERE r.idParticipante=p.id__47_tablaDinamica
						AND r.idActividad=".$idActividad." AND r.idFiguraJuridica in(SELECT id__5_tablaDinamica FROM _5_tablaDinamica WHERE naturalezaFigura='A') ORDER BY nombre,nombre,apellidoMaterno";
			
			$res=$con->obtenerFilas($consulta);
			while($filaImputado=mysql_fetch_row($res))
			{
				$nombre=trim($filaImputado[0]);
				if($demantante=="")
					$demantante=$nombre;
				else
					$demantante.=", ".$nombre;
			}
		
			$demandados="";
			$consulta="SELECT upper(CONCAT(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno))) 
						FROM _47_tablaDinamica p,7005_relacionFigurasJuridicasSolicitud r WHERE r.idParticipante=p.id__47_tablaDinamica
						AND r.idActividad=".$idActividad." AND r.idFiguraJuridica in(SELECT id__5_tablaDinamica FROM _5_tablaDinamica WHERE naturalezaFigura='D') ORDER BY nombre,nombre,apellidoMaterno";
			
			$res=$con->obtenerFilas($consulta);
			while($filaImputado=mysql_fetch_row($res))
			{
				$nombre=trim($filaImputado[0]);
				if($demandados=="")
					$demandados=$nombre;
				else
					$demandados.=", ".$nombre;
			}
			
			$o='{"idRegistro":"'.$fDemanda["id__1004_tablaDinamica"].'","folioRegistro":"'.$fDemanda["codigo"].
				'","fechaRegistro":"'.$fechaRegistro.'","demandante":"'.cv($demantante).
				'","demandado":"'.cv($demandados).'","normaInconstitucional":"'.cv($fDemanda["normaInconstitucional"]).
				'"}';	
		
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			$numReg++;
		}
		
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
			
	}
	
	function agregarDemandaProgramaTrabajoAccionPublica()
	{
		global $con;
		$iP=$_POST["iP"];
		$l=$_POST["l"];
		
		$x=0;
		$query[$x]="begin";
		$x++;
		$arrDemandas=explode(",",$l);
		
		foreach($arrDemandas as $d)
		{
			$consulta="SELECT COUNT(*) FROM 04000_demandasProgramaTrabajo WHERE iFormulario=1004 AND iRegistro=".$d;
			$numReg=$con->obtenerValor($consulta);
			if($numReg==0)
			{
				$query[$x]="INSERT INTO 04000_demandasProgramaTrabajo(idFormulario,idReferencia,iFormulario,iRegistro) 
							values(1108,".$iP.",1004,".$d.")";
				$x++;
			}
		}
		$query[$x]="commit";
		$x++;
		eB($query);
		
	}
	
	function removerDemandaProgramaTrabajoAccionPublica()
	{
		global $con;
		$iP=$_POST["iP"];
		$iR=$_POST["iR"];
		$consulta="DELETE FROM 04000_demandasProgramaTrabajo WHERE idReferencia=".$iP." AND iRegistro=".$iR;
		eC($consulta);
	}
	
	function ejecutarRepartoDespachoProgramaTrabajo()
	{
		global $con;
		$iP=$_POST["iP"];
		$d=$_POST["d"];
		
		
		$x=0;
		$query[$x]="begin";
		$x++;
		
		$consulta="SELECT id__992_tablaDinamica,nombreSala FROM _992_tablaDinamica WHERE tipoSala=3 AND id__992_tablaDinamica>=29 AND id__992_tablaDinamica<=37";
		$universoDespachos=$con->obtenerListaValores($consulta);
		
		$arrDemandas=explode(",",$d);
		foreach($arrDemandas as $demanda)
		{
		
			$arrConfiguracion["tipoAsignacion"]="";
			$arrConfiguracion["serieRonda"]="Grupo_ProgramaTrabajo";
			$arrConfiguracion["universoAsignacion"]=$universoDespachos;
			$arrConfiguracion["idObjetoReferencia"]=-1;
			$arrConfiguracion["pagarDeudasAsignacion"]=false;
			$arrConfiguracion["considerarDeudasMismaRonda"]=false;
			$arrConfiguracion["limitePagoRonda"]=0;
			$arrConfiguracion["escribirAsignacion"]=true;
			$arrConfiguracion["idFormulario"]=1004;
			$arrConfiguracion["idRegistro"]=$demanda;
			$resultado= obtenerSiguienteAsignacionObjeto($arrConfiguracion,true);
		//	$consulta="SELECT despachoAsigando FROM _993_tablaDinamica WHERE idReferencia=".$resultado["idUnidad"]." and presideSala=1";
			//$despachoAsigando=$con->obtenerValor($consulta);
		
			$query[$x]="UPDATE 04000_demandasProgramaTrabajo SET despachoAsignado='".$resultado["idUnidad"]."' WHERE iFormulario=1004 AND iRegistro=".$demanda;
			$x++;
		}
		
		$query[$x]="commit";
		$x++;
		
		eB($query);
		
	}
?>