<?php
ini_set("memory_limit","3000M");
set_time_limit(999000);

include("conexionBD.php");

$arrUnidades=array();
$fechaInicio=$_POST["fechaInicio"];
$fechaFin=$_POST["fechaFin"];

$tC=$_POST["tCarpeta"];

$unidadGestion=$_POST["unidadGestion"];

$consulta="";
if($unidadGestion==0)
{
	$consulta="SELECT 	id__17_tablaDinamica,claveUnidad,nombreUnidad FROM _17_tablaDinamica t,	_17_tiposCarpetasAdministra tC WHERE 
				cmbCategoria=1 and tC.idPadre=t.id__17_tablaDinamica AND tC.idOpcion=".$tC." ORDER BY prioridad";
}
else
{
	$consulta="SELECT 	id__17_tablaDinamica,claveUnidad,nombreUnidad FROM _17_tablaDinamica t where claveUnidad='".$unidadGestion."'";
}

$res=$con->obtenerFilas($consulta);

while($fila=mysql_fetch_row($res))
{
	$arrUnidades[$fila[1]]=$fila[2];
}


$nFila=2;
$numReg=1;
$libro=new cExcel("../modulosEspeciales_SGJP/formatos/plantillaInformeCarpeta.xlsx",true,"Excel2007");	

foreach($arrUnidades as $uG=>$resto)
{

	$unidadGestion=$resto;
	$consulta="SELECT carpetaAdministrativa,situacion,etapaProcesalActual,tipoCarpetaAdministrativa,carpetaAdministrativaBase,
				fechaCreacion,idActividad, carpetaInvestigacion,idCarpeta,date_format(fechaCreacion,'%Y') as anio,
				if(tipoCarpetaAdministrativa=1,(SELECT tA.tipoAudiencia FROM _46_tablaDinamica sI,_4_tablaDinamica tA WHERE id__46_tablaDinamica=c.idRegistro AND 
 tA.id__4_tablaDinamica=sI.tipoAudiencia ),'') as tipoAudiencia	
	
				 FROM 7006_carpetasAdministrativas  c
				WHERE unidadGestion='".$uG."' and tipoCarpetaAdministrativa='".$tC."' and fechaCreacion>='".$fechaInicio."' 
				and fechaCreacion<='".$fechaFin." 23:59:59' ORDER BY carpetaAdministrativa";
	
	
	$res=$con->obtenerFilas($consulta);

	while($fila=mysql_fetch_row($res))
	{
		
		$consulta="SELECT GROUP_CONCAT(carpetaAdministrativa) FROM 7006_carpetasAdministrativas WHERE 
					carpetaAdministrativaBase='".$fila[0]."' AND tipoCarpetaAdministrativa=".$tC;
		$remisiones=$con->obtenerListaValores($consulta);		
		$consulta="SELECT descripcion FROM 7014_situacionCarpetaAdministrativa WHERE idRegistro=".$fila[1];
		$situacionCarpeta=$con->obtenerValor($consulta);
		$carpetaInicial="";
		$carpetaOralidad="";
		$carpetaEjecucion="";	
		$lblAcciones="";	
		switch($fila[3])
		{
			case 1:
				
					$carpetaInicial=$fila[0];
					$consulta="SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas 
							WHERE carpetaAdministrativaBase='".$carpetaInicial."' AND tipoCarpetaAdministrativa=5";
					$carpetaOralidad=$con->obtenerListaValores($consulta,"'");
					$carpetaAux="'".$carpetaInicial."'";
	
					if($carpetaOralidad!="")
					{
						$carpetaAux.=",".$carpetaOralidad;
						
					}
					
					$consulta="SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas 
								WHERE carpetaAdministrativaBase in(".$carpetaAux.") AND 
								tipoCarpetaAdministrativa=6";
					$carpetaEjecucion=$con->obtenerListaValores($consulta);
					$carpetaOralidad=str_replace("'","",$carpetaOralidad);
				
			break;
			case 5:
				$carpetaInicial=$fila[4];
				$carpetaOralidad=$fila[0];
				
				$consulta="SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas 
						WHERE carpetaAdministrativaBase='".$carpetaOralidad."' 
						AND tipoCarpetaAdministrativa=6";
				$carpetaEjecucion=$con->obtenerListaValores($consulta,"'");
				$carpetaEjecucion=str_replace("'","",$carpetaEjecucion);
			break;
			case 6:
				$carpetaEjecucion=$fila[0];				
				$carpetaInicial="";
				$carpetaOralidad="";
				
				$consulta="SELECT tipoCarpetaAdministrativa,carpetaAdministrativaBase FROM 7006_carpetasAdministrativas 
							WHERE carpetaAdministrativa='".$fila[4]."'";
				$fCarpeta=$con->obtenerPrimeraFila($consulta);	
				switch($fCarpeta[0])	
				{
					case 1:
						$carpetaInicial=$fila[4];
					break;
					case 5:
						$carpetaOralidad=$fila[4];
						$carpetaInicial=$fCarpeta[1];
					break;
				}
				
			break;
		}
		$folioCarpetaInvestigacion=$fila[7];
		$cInicial="";
		
		$imputados="";
		if($fila[6]=="")	
			$fila[6]=-1;
		$consulta="SELECT CONCAT(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno)) ,r.situacionProcesal,detalleSituacion
					FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica p 
				WHERE r.idActividad=".$fila[6]." and idFiguraJuridica=4 AND r.idParticipante=p.id__47_tablaDinamica order 
				by nombre,apellidoPaterno,apellidoMaterno";

		$rImputados=$con->obtenerFilas($consulta);
		while($fImputado=mysql_fetch_row($rImputados))
		{
			$i=$fImputado[0];
			$consulta="SELECT situacion FROM 7014_situacionImputado WHERE idRegistro=".$fImputado[1];

			$situacion=$con->obtenerValor($consulta);
			$i.=" (Situación: ".$situacion;
			if($fImputado[2]!="")
			{
				$consulta="SELECT detalleSituacionImputado FROM 7014_detalleSituacionImputado WHERE idRegistro=".$fImputado[2];
				$detalle=$con->obtenerValor($consulta);
				$i.=" - ".$detalle;
			}
			$i.=")";
			if($imputados=="")
				$imputados=$i;
			else
				$imputados.="<br>".$i;
			
		}
		//$imputados=$con->obtenerValor($consulta);
		
		$consulta="SELECT GROUP_CONCAT(CONCAT(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',IF(apellidoMaterno IS NULL,'',apellidoMaterno))) FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica p 
				WHERE r.idActividad=".$fila[6]." and idFiguraJuridica=2 AND r.idParticipante=p.id__47_tablaDinamica order 
				by nombre,apellidoPaterno,apellidoMaterno";
		
		$victimas=$con->obtenerValor($consulta);
		
		
		$consulta="SELECT GROUP_CONCAT(dl.denominacionDelito) FROM _61_tablaDinamica d,_35_denominacionDelito dl WHERE d.idActividad=".$fila[6]." AND
					dl.id__35_denominacionDelito=d.denominacionDelito";
		
		$delitos=$con->obtenerValor($consulta);

		$ultimoJuez="";
		/*if($fila[3]==6)
		{
			$consulta="SELECT u.Nombre FROM _385_tablaDinamica s, 7000_eventosAudiencia e,7001_eventoAudienciaJuez j,800_usuarios u 
					WHERE carpetaEjecucion='".$fila[0]."' AND j.idRegistroEvento=e.idRegistroEvento AND e.idRegistroEvento=s.fechaAudiencia
					AND u.idUsuario=j.idJuez";
			$ultimoJuez=$con->obtenerValor($consulta);
		}*/
		
		$cierreInvestigacion="";
		$fechaAcusacion="";
		$consulta="SELECT fechaReferencia FROM 3013_registroResolutivosAudiencia r,7000_eventosAudiencia e,7007_contenidosCarpetaAdministrativa c 
					WHERE e.idRegistroEvento=r.idEvento AND tipoResolutivo=71 AND c.tipoContenido=3 AND c.idRegistroContenidoReferencia=e.idRegistroEvento
					AND c.carpetaAdministrativa='".$fila[0]."' AND fechaReferencia<>''  ORDER BY r.idRegistro LIMIT 0,1";
		$cierreInvestigacion=$con->obtenerValor($consulta);
		if($cierreInvestigacion!="")
		{
			$fechaAcusacion=obtenerHorasAjusteDiasNoHabiles($cierreInvestigacion,date("Y-m-d",strtotime("+15 days",strtotime($cierreInvestigacion))));

		}
		
			
		$libro->setValor("A".$nFila,$numReg);	
		$libro->setValor("B".$nFila,$fila[9]);	
		$libro->setValor("C".$nFila,$unidadGestion);	
		$libro->setValor("D".$nFila,$fila[0]);	
		$libro->setValor("E".$nFila,$fila[4]);	
		$libro->setValor("F".$nFila,$fila[5]);	
		$libro->setValor("G".$nFila,$situacionCarpeta);	
		$libro->setValor("H".$nFila,$folioCarpetaInvestigacion);	
		$libro->setValor("I".$nFila,$carpetaOralidad);	
		$libro->setValor("J".$nFila,$carpetaEjecucion);	
		$libro->setValor("J".$nFila,$remisiones);	
		$libro->setValor("L".$nFila,$imputados);	
		$libro->setValor("M".$nFila,$victimas);	
		$libro->setValor("N".$nFila,$delitos);	
		$libro->setValor("O".$nFila,$cierreInvestigacion);	
		$libro->setValor("P".$nFila,$fechaAcusacion);	
		$libro->setValor("Q".$nFila,$fila[10]);	
		$nFila++;
		$numReg++;
	}
	
}
	
$libro->generarArchivo("Excel2007","informeCarpetas.xlsx");
?>