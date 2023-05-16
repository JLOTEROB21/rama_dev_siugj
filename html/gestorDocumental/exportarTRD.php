<?php session_start();
include("conexionBD.php");
$idTablaRetencion=$_POST["idTablaRetencion"];
$version=$_POST["version"];
$formatoExportacion=$_POST["formatoExportacion"];
switch($formatoExportacion)
{
	case 1://Excel	
		$arrSeriesTipoProceso=array();
	
		$arrColumnas["A"]=1;
		$arrColumnas["B"]=1;
		$arrColumnas["C"]=1;
		$arrColumnas["D"]=1;
		$arrColumnas["E"]=1;
		$arrColumnas["F"]=1;
		$arrColumnas["G"]=1;
		$arrColumnas["H"]=1;
		$arrColumnas["I"]=1;
		$arrColumnas["J"]=1;
		$arrColumnas["K"]=1;
		$arrColumnas["L"]=1;

		
		$libro=new cExcel("./plantillas/formatoExportacionTRDExcel.xlsx",true,"Excel2007");	
		
		$consulta="SELECT * FROM 908_tablasRetencionDocumental WHERE idTablaRetencion=".$idTablaRetencion;
		$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
		
		$consulta="SELECT fechaAplicacion,situacionActual FROM 908_versionesTablasRetencionDocumental WHERE idTablaRetencion=".$idTablaRetencion." AND VERSION=".$version;
		$fRegistroVersion=$con->obtenerPrimeraFilaAsoc($consulta);
		
		
		
		$libro->setValor("L7","Fecha: ".date("Y"));
		$libro->setValor("C5",$fRegistro["nombreTabla"]);
		$libro->setValor("C6",$fRegistro["cveTabla"]);
		$libro->setValor("C7",$version);
		$libro->setValor("C8",$fRegistroVersion["fechaAplicacion"]==""?"--":date("d/m/Y",strtotime($fRegistroVersion["fechaAplicacion"])));
		
		$numFila=11;
		$consulta="SELECT * FROM 908_registrosTablasRetencionDocumental WHERE idTablaRetencion=".$idTablaRetencion." AND VERSION=".$version." and tipoElemento=1";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_assoc($res))
		{
			$libro->setValor("A".$numFila,"'".$fila["cveElemento"]);
			$libro->setValor("B".$numFila,"");
			$libro->setValor("C".$numFila,$fila["tituloElemento"]);
			$libro->setValor("D".$numFila,($fila["soporteFisico"]==1?"X":""));
			$libro->setValor("E".$numFila,($fila["soporteElectronico"]==1?"X":""));
			$libro->setValor("F".$numFila,$fila["retencionArchivoGestion"]);
			$libro->setValor("G".$numFila,$fila["retencionArchivoCentral"]);
			$libro->setValor("H".$numFila,($fila["conservacionTotal"]==1?"X":""));
			$libro->setValor("I".$numFila,($fila["eliminacion"]==1?"X":""));
			$libro->setValor("J".$numFila,($fila["microfilmacionDigitalizacion"]==1?"X":""));
			$libro->setValor("K".$numFila,($fila["seleccion"]==1?"X":""));
			$libro->setValor("L".$numFila,$fila["procedimiento"]);			
			$libro->setBorde("A".$numFila.":L".$numFila,"DE");
			
			
			$libro->setFuente("A".$numFila.":L".$numFila,"Century Gothic");
			$libro->setTamano("A".$numFila.":L".$numFila,10);
			$libro->setHAlineacion("D".$numFila.":K".$numFila,"C");
			
			
			$consulta="SELECT '".$fila["cveElemento"]."' as serie,'' as subserie,es.claveEspecialidadDespacho,es.nombreEspecialidadDespacho,tP.claveTipoProceso,tP.nombreTipoProceso 
						FROM 908_seriesTiposProcesos s,_625_tablaDinamica tP,_637_tablaDinamica es 
						WHERE idSerie=".$fila["idRegistro"]." AND tP.id__625_tablaDinamica=s.tipoProceso AND es.id__637_tablaDinamica=tP.especialidad";
			$resRelacion=$con->obtenerFilas($consulta);
			while($filaRelacion=mysql_fetch_assoc($resRelacion))
			{
				array_push($arrSeriesTipoProceso,$filaRelacion);
			}
			
			$numFila++;
			$consulta="SELECT * FROM 908_registrosTablasRetencionDocumental WHERE idTablaRetencion=".$idTablaRetencion.
						" AND VERSION=".$version." and ((tipoElemento=2 and idSerie=".$fila["idRegistro"].
						") or (tipoElemento=3 and idSerie=".$fila["idRegistro"]." and idSubSerie=0)) order by idSerie asc,idSubSerie desc";
			
			$resSerie=$con->obtenerFilas($consulta);
			while($filaSerie=mysql_fetch_assoc($resSerie))
			{
				$filaSubSerie=$numFila;
				
				$tipoElemento="";
				
				if($filaSerie["tipoElemento"]==3)
				{
					$consulta="SELECT nombreCategoria FROM 908_categoriasDocumentos WHERE idCategoria=".$filaSerie["tipoDocumento"];
					$tipoElemento=$con->obtenerValor($consulta);
					
				}
				else
				{
					$tipoElemento=$filaSerie["tituloElemento"];
				}
				
				$libro->setValor("A".$numFila,($filaSerie["tipoElemento"]==3?"":"'".$fila["cveElemento"]));
				$libro->setValor("B".$numFila,($filaSerie["cveElemento"]==""?"":"'".$filaSerie["cveElemento"]));
				$libro->setValor("C".$numFila,$tipoElemento);
				$libro->setValor("D".$numFila,($filaSerie["soporteFisico"]==1?"X":""));
				$libro->setValor("E".$numFila,($filaSerie["soporteElectronico"]==1?"X":""));
				$libro->setValor("F".$numFila,$filaSerie["retencionArchivoGestion"]);
				$libro->setValor("G".$numFila,$filaSerie["retencionArchivoCentral"]);
				$libro->setValor("H".$numFila,($filaSerie["conservacionTotal"]==1?"X":""));
				$libro->setValor("I".$numFila,($filaSerie["eliminacion"]==1?"X":""));
				$libro->setValor("J".$numFila,($filaSerie["microfilmacionDigitalizacion"]==1?"X":""));
				$libro->setValor("K".$numFila,($filaSerie["seleccion"]==1?"X":""));
				$libro->setValor("L".$numFila,$filaSerie["procedimiento"]);
				$libro->setFuente("A".$numFila.":L".$numFila,"Century Gothic");
				$libro->setTamano("A".$numFila.":L".$numFila,10);
				$libro->setHAlineacion("D".$numFila.":K".$numFila,"C");
				
				$consulta="SELECT  '".$fila["cveElemento"]."' as serie,'".$filaSerie["cveElemento"]."' as subserie,es.claveEspecialidadDespacho,
							es.nombreEspecialidadDespacho,tP.claveTipoProceso,tP.nombreTipoProceso 
						FROM 908_seriesTiposProcesos s,_625_tablaDinamica tP,_637_tablaDinamica es 
						WHERE idSerie=".$filaSerie["idRegistro"]." AND tP.id__625_tablaDinamica=s.tipoProceso AND es.id__637_tablaDinamica=tP.especialidad";
				$resRelacion=$con->obtenerFilas($consulta);
				while($filaRelacion=mysql_fetch_assoc($resRelacion))
				{
					array_push($arrSeriesTipoProceso,$filaRelacion);
				}

				$numFila++;
				$consulta="SELECT * FROM 908_registrosTablasRetencionDocumental WHERE idTablaRetencion=".$idTablaRetencion.
						" AND VERSION=".$version." and tipoElemento=3 and idSerie=".$fila["idRegistro"]." and idSubSerie=".$filaSerie["idRegistro"];
				$resTipoDocumental=$con->obtenerFilas($consulta);
				while($filaTipoDocumental=mysql_fetch_assoc($resTipoDocumental))
				{
					
					$consulta="SELECT nombreCategoria FROM 908_categoriasDocumentos WHERE idCategoria=".$filaTipoDocumental["tipoDocumento"];
					$tipoDocumental=$con->obtenerValor($consulta);
					
					$libro->setValor("A".$numFila,"");
					$libro->setValor("B".$numFila,"");
					$libro->setValor("C".$numFila,$tipoDocumental);
					$libro->setValor("D".$numFila,($filaTipoDocumental["soporteFisico"]==1?"X":""));
					$libro->setValor("E".$numFila,($filaTipoDocumental["soporteElectronico"]==1?"X":""));
					$libro->setValor("F".$numFila,$filaTipoDocumental["retencionArchivoGestion"]);
					$libro->setValor("G".$numFila,$filaTipoDocumental["retencionArchivoCentral"]);
					$libro->setValor("H".$numFila,($filaTipoDocumental["conservacionTotal"]==1?"X":""));
					$libro->setValor("I".$numFila,($filaTipoDocumental["eliminacion"]==1?"X":""));
					$libro->setValor("J".$numFila,($filaTipoDocumental["microfilmacionDigitalizacion"]==1?"X":""));
					$libro->setValor("K".$numFila,($filaTipoDocumental["seleccion"]==1?"X":""));
					$libro->setValor("L".$numFila,$filaTipoDocumental["procedimiento"]);
					$libro->setFuente("A".$numFila.":L".$numFila,"Century Gothic");
					$libro->setTamano("A".$numFila.":L".$numFila,10);
					$libro->setHAlineacion("D".$numFila.":K".$numFila,"C");
					$numFila++;
				}
				
				
				
				foreach($arrColumnas as $columna=>$resto)
				{
					$libro->setBorde($columna.$filaSubSerie.":".$columna.$numFila,"DE","000000","right");
					$libro->setBorde($columna.$filaSubSerie.":".$columna.$numFila,"DE","000000","left");
				}
				
				
				$libro->setBorde("A".$filaSubSerie.":L".$filaSubSerie,"DE","000000","top");
				$libro->setBorde("A".$numFila.":L".$numFila,"DE","000000","bottom");

			}
			
			
			

		}
		
		
		$numFila=2;
		$libro->cambiarHojaActiva(1);
		$consulta="SELECT o.codigoUnidad,o.unidad,o.claveDepartamental FROM 908_despachosTablaRetencion d,817_organigrama o 
				WHERE idTablaRetencion=".$idTablaRetencion." AND VERSION=".$version." AND o.codigoUnidad=d.despacho ORDER BY o.unidad";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_assoc($res))
		{
			$libro->setValor("A".$numFila,"'".$fila["codigoUnidad"]);
			$libro->setValor("B".$numFila,"'".$fila["claveDepartamental"]);
			$libro->setValor("C".$numFila,$fila["unidad"]);
			$numFila++;
		}
		$libro->cambiarHojaActiva(2);
		$numFila=2;
		foreach($arrSeriesTipoProceso as $fila)
		{
			$libro->setValor("A".$numFila,"'".$fila["serie"]);
			$libro->setValor("B".$numFila,$fila["subserie"]!=""?("'".$fila["subserie"]):"");
			$libro->setValor("C".$numFila,"'".$fila["claveEspecialidadDespacho"]);
			$libro->setValor("D".$numFila,$fila["nombreEspecialidadDespacho"]);
			$libro->setValor("E".$numFila,"'".$fila["claveTipoProceso"]);
			$libro->setValor("F".$numFila,$fila["nombreTipoProceso"]);
			$numFila++;
		}
		$libro->cambiarHojaActiva(0);
		$libro->generarArchivo("Excel2007","TRD_".str_replace(" ","_",$fRegistro["nombreTabla"]."_V".$version.".xlsx"));
		
		
	break;
	case 2://JSON
		$arrSeriesTipoProceso=array();
	
		$arrColumnas["A"]=1;
		$arrColumnas["B"]=1;
		$arrColumnas["C"]=1;
		$arrColumnas["D"]=1;
		$arrColumnas["E"]=1;
		$arrColumnas["F"]=1;
		$arrColumnas["G"]=1;
		$arrColumnas["H"]=1;
		$arrColumnas["I"]=1;
		$arrColumnas["J"]=1;
		$arrColumnas["K"]=1;
		$arrColumnas["L"]=1;

		
		
		$consulta="SELECT * FROM 908_tablasRetencionDocumental WHERE idTablaRetencion=".$idTablaRetencion;
		$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
		
		$consulta="SELECT fechaAplicacion,situacionActual FROM 908_versionesTablasRetencionDocumental WHERE idTablaRetencion=".$idTablaRetencion." AND VERSION=".$version;
		$fRegistroVersion=$con->obtenerPrimeraFilaAsoc($consulta);
		
		$cadObj='{"fecha":"'.date("Y").'","fechaAplicacion":"'.$fRegistroVersion["fechaAplicacion"].'","situacionActual":"'.$fRegistroVersion["situacionActual"].
				'","nombreTabla":"'.cv($fRegistro["nombreTabla"]).'","cveTabla":"'.cv($fRegistro["cveTabla"]).'","version":"'.$version.'"';
		
		
		$arrRegistros='';
		
		$numFila=9;
		$consulta="SELECT * FROM 908_registrosTablasRetencionDocumental WHERE idTablaRetencion=".$idTablaRetencion." AND VERSION=".$version." and tipoElemento=1";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_assoc($res))
		{

			$consulta="SELECT '".$fila["cveElemento"]."' as serie,'' as subserie,es.claveEspecialidadDespacho,es.nombreEspecialidadDespacho,
						tP.claveTipoProceso,tP.nombreTipoProceso 
						FROM 908_seriesTiposProcesos s,_625_tablaDinamica tP,_637_tablaDinamica es 
						WHERE idSerie=".$fila["idRegistro"]." AND tP.id__625_tablaDinamica=s.tipoProceso AND es.id__637_tablaDinamica=tP.especialidad";
			$resRelacion=$con->obtenerFilas($consulta);
			while($filaRelacion=mysql_fetch_assoc($resRelacion))
			{
				array_push($arrSeriesTipoProceso,$filaRelacion);
			}
			
			$arrSubseries="";
			$consulta="SELECT * FROM 908_registrosTablasRetencionDocumental WHERE idTablaRetencion=".$idTablaRetencion.
						" AND VERSION=".$version." and ((tipoElemento=2 and idSerie=".$fila["idRegistro"].
						") or (tipoElemento=3 and idSerie=".$fila["idRegistro"]." and idSubSerie=0))";
			$resSerie=$con->obtenerFilas($consulta);
			while($filaSerie=mysql_fetch_assoc($resSerie))
			{
				$consulta="SELECT  '".$fila["cveElemento"]."' as serie,'".$filaSerie["cveElemento"]."' as subserie,es.claveEspecialidadDespacho,
							es.nombreEspecialidadDespacho,tP.claveTipoProceso,tP.nombreTipoProceso 
						FROM 908_seriesTiposProcesos s,_625_tablaDinamica tP,_637_tablaDinamica es 
						WHERE idSerie=".$filaSerie["idRegistro"]." AND tP.id__625_tablaDinamica=s.tipoProceso AND es.id__637_tablaDinamica=tP.especialidad";
				$resRelacion=$con->obtenerFilas($consulta);
				while($filaRelacion=mysql_fetch_assoc($resRelacion))
				{
					array_push($arrSeriesTipoProceso,$filaRelacion);
				}

				$arrTiposDocumentales="";
				$consulta="SELECT * FROM 908_registrosTablasRetencionDocumental WHERE idTablaRetencion=".$idTablaRetencion.
						" AND VERSION=".$version." and tipoElemento=3 and idSerie=".$fila["idRegistro"]." and idSubSerie=".$filaSerie["idRegistro"];
				$resTipoDocumental=$con->obtenerFilas($consulta);
				while($filaTipoDocumental=mysql_fetch_assoc($resTipoDocumental))
				{
					
					$consulta="SELECT nombreCategoria FROM 908_categoriasDocumentos WHERE idCategoria=".$filaTipoDocumental["tipoDocumento"];
					$tipoDocumental=$con->obtenerValor($consulta);
					
					$oTipoDocumental='{"serie":"'.$fila["cveElemento"].'","subserie":"'.$filaSerie["cveElemento"].'","tituloElemento":"'.cv($tipoDocumental).
							'","soporteFisico":"'.cv($filaTipoDocumental["soporteFisico"]).'","soporteElectronico":"'.cv($filaTipoDocumental["soporteElectronico"]).
							'","retencionArchivoGestion":"'.cv($filaTipoDocumental["retencionArchivoGestion"]).'","retencionArchivoCentral":"'.cv($filaTipoDocumental["retencionArchivoCentral"]).
							'","conservacionTotal":"'.cv($filaTipoDocumental["conservacionTotal"]).'","eliminacion":"'.cv($filaTipoDocumental["eliminacion"]).
							'","microfilmacionDigitalizacion":"'.cv($filaTipoDocumental["microfilmacionDigitalizacion"]).
							'","seleccion":"'.cv($filaTipoDocumental["seleccion"]).'","procedimiento":"'.cv($filaTipoDocumental["procedimiento"]).
							'","tipoElemento":"'.$filaTipoDocumental["tipoElemento"].'","arrElementosHijos":[]}';	
				
					if($arrTiposDocumentales=="")
						$arrTiposDocumentales=$oTipoDocumental;
					else
						$arrTiposDocumentales.=",".$oTipoDocumental;
					
				}
				
				$tituloElemento="";
				if($filaSerie["tipoElemento"]==3)
				{
					$consulta="SELECT nombreCategoria FROM 908_categoriasDocumentos WHERE idCategoria=".$filaSerie["tipoDocumento"];
					$tituloElemento=$con->obtenerValor($consulta);
				}
				else
				{
					$tituloElemento=$filaSerie["tituloElemento"];
				}
				
				$oSubSerie='{"serie":"'.$fila["cveElemento"].'","subserie":"'.$filaSerie["cveElemento"].'","tituloElemento":"'.cv($tituloElemento).
						'","soporteFisico":"'.cv($filaSerie["soporteFisico"]).'","soporteElectronico":"'.cv($filaSerie["soporteElectronico"]).
						'","retencionArchivoGestion":"'.cv($filaSerie["retencionArchivoGestion"]).'","retencionArchivoCentral":"'.cv($filaSerie["retencionArchivoCentral"]).
						'","conservacionTotal":"'.cv($filaSerie["conservacionTotal"]).'","eliminacion":"'.cv($filaSerie["eliminacion"]).
						'","microfilmacionDigitalizacion":"'.cv($filaSerie["microfilmacionDigitalizacion"]).
						'","seleccion":"'.cv($filaSerie["seleccion"]).'","procedimiento":"'.cv($filaSerie["procedimiento"]).
						'","tipoElemento":"'.$filaSerie["tipoElemento"].'","arrElementosHijos":['.$arrTiposDocumentales.']}';	
				
				if($arrSubseries=="")
					$arrSubseries=$oSubSerie;
				else
					$arrSubseries.=",".$oSubSerie;
			}
			
			$oRegistros='{"serie":"'.$fila["cveElemento"].'","subserie":"","tituloElemento":"'.cv($fila["tituloElemento"]).'","soporteFisico":"'.cv($fila["soporteFisico"]).
						'","soporteElectronico":"'.cv($fila["soporteElectronico"]).'","retencionArchivoGestion":"'.cv($fila["retencionArchivoGestion"]).
						'","retencionArchivoCentral":"'.cv($fila["retencionArchivoCentral"]).'","conservacionTotal":"'.cv($fila["conservacionTotal"]).
						'","eliminacion":"'.cv($fila["eliminacion"]).'","microfilmacionDigitalizacion":"'.cv($fila["microfilmacionDigitalizacion"]).
						'","seleccion":"'.cv($fila["seleccion"]).'","procedimiento":"'.cv($fila["procedimiento"]).
						'","tipoElemento":"'.$fila["tipoElemento"].'","arrElementosHijos":['.$arrSubseries.']}';	
			
			if($arrRegistros=="")
				$arrRegistros=$oRegistros;
			else
				$arrRegistros.=",".$oRegistros;
			

		}
		
		$cadObj.=',"registrosTRD":['.$arrRegistros.']';
		$arrOficinasProductoras="";
		$consulta="SELECT o.codigoUnidad,o.unidad,o.claveDepartamental FROM 908_despachosTablaRetencion d,817_organigrama o 
				WHERE idTablaRetencion=".$idTablaRetencion." AND VERSION=".$version." AND o.codigoUnidad=d.despacho ORDER BY o.unidad";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_assoc($res))
		{
			
			$oOficina='{"codigoUnidad":"'.$fila["codigoUnidad"].'","claveDepartamental":"'.$fila["claveDepartamental"].'","unidad":"'.$fila["unidad"].'"}';
			if($arrOficinasProductoras=="")
				$arrOficinasProductoras=$oOficina;
			else
				$arrOficinasProductoras.=",".$oOficina;
		}
		
		$cadObj.=',"oficinasProductoras":['.$arrOficinasProductoras.']';
		
		$arrSeriesTiposProceso="";
		foreach($arrSeriesTipoProceso as $fila)
		{
			
			$oTipoProceso='{"serie":"'.$fila["serie"].'","subserie":"'.$fila["subserie"].'","claveEspecialidadDespacho":"'.$fila["claveEspecialidadDespacho"].
							'","nombreEspecialidadDespacho":"'.$fila["nombreEspecialidadDespacho"].'","claveTipoProceso":"'.$fila["claveTipoProceso"].
							'","nombreTipoProceso":"'.$fila["nombreTipoProceso"].'"}';
			if($arrSeriesTiposProceso=="")
				$arrSeriesTiposProceso=$oTipoProceso;
			else
				$arrSeriesTiposProceso.=",".$oTipoProceso;
		}
		
		$cadObj.=',"Series_Subseries_Tipos":['.$arrSeriesTiposProceso.']}';
		$nombreArchivo="TRD_".str_replace(" ","_",$fRegistro["nombreTabla"]."_V".$version.".json");
		
		header("Content-type: application/json");
		header("Content-length: ".strlen($cadObj)); 

		header("Content-Disposition: attachment; filename=".$nombreArchivo);
		echo $cadObj;
	
	break;
	case 3://XML
		$arrSeriesTipoProceso=array();
	
		$arrColumnas["A"]=1;
		$arrColumnas["B"]=1;
		$arrColumnas["C"]=1;
		$arrColumnas["D"]=1;
		$arrColumnas["E"]=1;
		$arrColumnas["F"]=1;
		$arrColumnas["G"]=1;
		$arrColumnas["H"]=1;
		$arrColumnas["I"]=1;
		$arrColumnas["J"]=1;
		$arrColumnas["K"]=1;
		$arrColumnas["L"]=1;
		
		$consulta="SELECT * FROM 908_tablasRetencionDocumental WHERE idTablaRetencion=".$idTablaRetencion;
		$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
		
		
		$consulta="SELECT fechaAplicacion,situacionActual FROM 908_versionesTablasRetencionDocumental WHERE idTablaRetencion=".$idTablaRetencion." AND VERSION=".$version;
		$fRegistroVersion=$con->obtenerPrimeraFilaAsoc($consulta);
		
		$cadObj='<?xml version="1.0" encoding="UTF-8"?><TRDschema><fecha>'.date("Y").'</fecha><nombreTabla><![CDATA['.cv($fRegistro["nombreTabla"]).
				']]></nombreTabla><cveTabla><![CDATA['.cv($fRegistro["cveTabla"]).']]></cveTabla><version>'.$version.
				'</version><fechaAplicacion>'.$fRegistroVersion["fechaAplicacion"].'</fechaAplicacion><situacionActual>'.$fRegistroVersion["situacionActual"].
				'</situacionActual>';
		
		$arrRegistros='';
		$consulta="SELECT * FROM 908_registrosTablasRetencionDocumental WHERE idTablaRetencion=".$idTablaRetencion." AND VERSION=".$version." and tipoElemento=1";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_assoc($res))
		{

			$consulta="SELECT '".$fila["cveElemento"]."' as serie,'' as subserie,es.claveEspecialidadDespacho,es.nombreEspecialidadDespacho,tP.claveTipoProceso,tP.nombreTipoProceso 
						FROM 908_seriesTiposProcesos s,_625_tablaDinamica tP,_637_tablaDinamica es 
						WHERE idSerie=".$fila["idRegistro"]." AND tP.id__625_tablaDinamica=s.tipoProceso AND es.id__637_tablaDinamica=tP.especialidad";
			$resRelacion=$con->obtenerFilas($consulta);
			while($filaRelacion=mysql_fetch_assoc($resRelacion))
			{
				array_push($arrSeriesTipoProceso,$filaRelacion);
			}
			
			$arrSubseries="";
			$consulta="SELECT * FROM 908_registrosTablasRetencionDocumental WHERE idTablaRetencion=".$idTablaRetencion.
						" AND VERSION=".$version." and ((tipoElemento=2 and idSerie=".$fila["idRegistro"].
						") or (tipoElemento=3 and idSerie=".$fila["idRegistro"]." and idSubSerie=0))";
			$resSerie=$con->obtenerFilas($consulta);
			while($filaSerie=mysql_fetch_assoc($resSerie))
			{
				$consulta="SELECT  '".$fila["cveElemento"]."' as serie,'".$filaSerie["cveElemento"]."' as subserie,es.claveEspecialidadDespacho,
							es.nombreEspecialidadDespacho,tP.claveTipoProceso,tP.nombreTipoProceso 
						FROM 908_seriesTiposProcesos s,_625_tablaDinamica tP,_637_tablaDinamica es 
						WHERE idSerie=".$filaSerie["idRegistro"]." AND tP.id__625_tablaDinamica=s.tipoProceso AND es.id__637_tablaDinamica=tP.especialidad";
				$resRelacion=$con->obtenerFilas($consulta);
				while($filaRelacion=mysql_fetch_assoc($resRelacion))
				{
					array_push($arrSeriesTipoProceso,$filaRelacion);
				}

				$arrTiposDocumentales="";
				$consulta="SELECT * FROM 908_registrosTablasRetencionDocumental WHERE idTablaRetencion=".$idTablaRetencion.
						" AND VERSION=".$version." and tipoElemento=3 and idSerie=".$fila["idRegistro"]." and idSubSerie=".$filaSerie["idRegistro"];
				$resTipoDocumental=$con->obtenerFilas($consulta);
				while($filaTipoDocumental=mysql_fetch_assoc($resTipoDocumental))
				{
					
					$consulta="SELECT nombreCategoria FROM 908_categoriasDocumentos WHERE idCategoria=".$filaTipoDocumental["tipoDocumento"];
					$tipoDocumental=$con->obtenerValor($consulta);
					
					$oTipoDocumental='<elementoTRD><serie>'.$fila["cveElemento"].'</serie><subserie>'.$filaSerie["cveElemento"].'</subserie><tituloElemento><![CDATA['.cv($tipoDocumental).
						']]></tituloElemento><soporteFisico>'.cv($filaTipoDocumental["soporteFisico"]).'</soporteFisico><soporteElectronico>'.cv($filaTipoDocumental["soporteElectronico"]).
						'</soporteElectronico><retencionArchivoGestion>'.cv($filaTipoDocumental["retencionArchivoGestion"]).'</retencionArchivoGestion><retencionArchivoCentral>'.
						cv($filaTipoDocumental["retencionArchivoCentral"]).'</retencionArchivoCentral><conservacionTotal>'.cv($filaTipoDocumental["conservacionTotal"]).
						'</conservacionTotal><eliminacion>'.cv($filaTipoDocumental["eliminacion"]).'</eliminacion><microfilmacionDigitalizacion>'.cv($filaTipoDocumental["microfilmacionDigitalizacion"]).
						'</microfilmacionDigitalizacion><seleccion>'.cv($filaTipoDocumental["seleccion"]).'</seleccion><procedimiento><![CDATA['.cv($filaTipoDocumental["procedimiento"]).
						']]></procedimiento><tipoElemento>'.$filaTipoDocumental["tipoElemento"].'</tipoElemento><arrElementosHijos></arrElementosHijos></elementoTRD>';	
					
					$arrTiposDocumentales.=$oTipoDocumental;
				
					
						
					
				}
				
				$tituloElemento="";
				if($filaSerie["tipoElemento"]==3)
				{
					$consulta="SELECT nombreCategoria FROM 908_categoriasDocumentos WHERE idCategoria=".$filaSerie["tipoDocumento"];
					$tituloElemento=$con->obtenerValor($consulta);
				}
				else
				{
					$tituloElemento=$filaSerie["tituloElemento"];
				}

				$oSubSerie='<elementoTRD><serie>'.$fila["cveElemento"].'</serie><subserie>'.$filaSerie["cveElemento"].'</subserie><tituloElemento><![CDATA['.cv($tituloElemento).
						']]></tituloElemento><soporteFisico>'.cv($filaSerie["soporteFisico"]).'</soporteFisico><soporteElectronico>'.cv($filaSerie["soporteElectronico"]).
						'</soporteElectronico><retencionArchivoGestion>'.cv($filaSerie["retencionArchivoGestion"]).'</retencionArchivoGestion><retencionArchivoCentral>'.
						cv($filaSerie["retencionArchivoCentral"]).'</retencionArchivoCentral><conservacionTotal>'.cv($filaSerie["conservacionTotal"]).'</conservacionTotal><eliminacion>'.
						cv($filaSerie["eliminacion"]).'</eliminacion><microfilmacionDigitalizacion>'.cv($filaSerie["microfilmacionDigitalizacion"]).
						'</microfilmacionDigitalizacion><seleccion>'.cv($filaSerie["seleccion"]).'</seleccion><procedimiento><![CDATA['.cv($filaSerie["procedimiento"]).
						']]></procedimiento><tipoElemento>'.$filaSerie["tipoElemento"].'</tipoElemento><arrElementosHijos>'.$arrTiposDocumentales.'</arrElementosHijos></elementoTRD>';		
				$arrSubseries.=$oSubSerie;	
			}
			
			$oRegistros='<elementoTRD><serie>'.$fila["cveElemento"].'</serie><subserie></subserie><tituloElemento><![CDATA['.cv($fila["tituloElemento"]).
						']]></tituloElemento><soporteFisico>'.cv($fila["soporteFisico"]).'</soporteFisico><soporteElectronico>'.cv($fila["soporteElectronico"]).
						'</soporteElectronico><retencionArchivoGestion>'.cv($fila["retencionArchivoGestion"]).'</retencionArchivoGestion><retencionArchivoCentral>'.
						cv($fila["retencionArchivoCentral"]).'</retencionArchivoCentral><conservacionTotal>'.cv($fila["conservacionTotal"]).'</conservacionTotal><eliminacion>'.
						cv($fila["eliminacion"]).'</eliminacion><microfilmacionDigitalizacion>'.cv($fila["microfilmacionDigitalizacion"]).
						'</microfilmacionDigitalizacion><seleccion>'.cv($fila["seleccion"]).'</seleccion><procedimiento><![CDATA['.cv($fila["procedimiento"]).
						']]></procedimiento><tipoElemento>'.$fila["tipoElemento"].'</tipoElemento><arrElementosHijos>'.$arrSubseries.'</arrElementosHijos></elementoTRD>';	
			
			$arrRegistros.=$oRegistros;
			

		}
		
		
		
		$cadObj.='<registrosTRD>'.$arrRegistros.'</registrosTRD>';
		$arrOficinasProductoras="";
		$consulta="SELECT o.codigoUnidad,o.unidad,o.claveDepartamental FROM 908_despachosTablaRetencion d,817_organigrama o 
				WHERE idTablaRetencion=".$idTablaRetencion." AND VERSION=".$version." AND o.codigoUnidad=d.despacho ORDER BY o.unidad";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_assoc($res))
		{
			
			$oOficina='<oficinaProductora><codigoUnidad>'.$fila["codigoUnidad"].'</codigoUnidad><claveDepartamental>'.$fila["claveDepartamental"].
					'</claveDepartamental><unidad><![CDATA['.$fila["unidad"].']]></unidad></oficinaProductora>';
			$arrOficinasProductoras.=$oOficina;
		}
		
		$cadObj.='<oficinasProductoras>'.$arrOficinasProductoras.'</oficinasProductoras>';
		
		$arrSeriesTiposProceso="";
		foreach($arrSeriesTipoProceso as $fila)
		{
			
			$oTipoProceso='<relacion><serie>'.$fila["serie"].'</serie><subserie>'.$fila["subserie"].'</subserie><claveEspecialidadDespacho><![CDATA['.$fila["claveEspecialidadDespacho"].
							']]></claveEspecialidadDespacho><nombreEspecialidadDespacho><![CDATA['.$fila["nombreEspecialidadDespacho"].
							']]></nombreEspecialidadDespacho><claveTipoProceso><![CDATA['.$fila["claveTipoProceso"].
							']]></claveTipoProceso><nombreTipoProceso><![CDATA['.$fila["nombreTipoProceso"].']]></nombreTipoProceso></relacion>';
			
			$arrSeriesTiposProceso.=$oTipoProceso;
		}
		
		$cadObj.='<Series_Subseries_Tipos>'.$arrSeriesTiposProceso.'</Series_Subseries_Tipos>';
		$cadObj.='</TRDschema>';
		
		$nombreArchivo="TRD_".str_replace(" ","_",$fRegistro["nombreTabla"]."_V".$version.".xml");
		header("Content-type: application/xml");
		header("Content-length: ".strlen($cadObj)); 

		header("Content-Disposition: attachment; filename=".$nombreArchivo);
		echo $cadObj;
	break;
}


?>