<?php
ini_set("memory_limit","3000M");
set_time_limit(999000);

include("conexionBD.php");

$arrUnidades=array();
$fechaInicio=$_POST["fechaInicio"];
$fechaFin=$_POST["fechaFin"];

$finicioDte=strtotime($fechaInicio);
$fechaFinDte=strtotime($fechaFin);

$lblInicio=date("d",$finicioDte)." de ".$arrMesLetra[(date("m",$finicioDte)*1)-1]." de ".date("Y",$finicioDte);
$lblFin=date("d",$fechaFinDte)." de ".$arrMesLetra[(date("m",$fechaFinDte)*1)-1]." de ".date("Y",$fechaFinDte);

$nFila=5;
$libro=new cExcel("../formatos/plantillaEstadistica.xlsx",true,"Excel2007");	
$libro->setValor("B2","Del ".$lblInicio." al ".$lblFin);

$consulta="SELECT id__17_tablaDinamica,claveUnidad,nombreUnidad FROM _17_tablaDinamica u,_17_tiposCarpetasAdministra tC 
		WHERE tC.idPadre=u.id__17_tablaDinamica AND tC.idOpcion=5 ORDER BY prioridad";
$res=$con->obtenerFilas($consulta);
while($fila=mysql_fetch_row($res))
{
	$consulta="SELECT COUNT(DISTINCT e.idRegistroEvento) FROM 7000_eventosAudiencia e,7007_contenidosCarpetaAdministrativa con,7006_carpetasAdministrativas c 
				WHERE fechaEvento>='".$fechaInicio."' AND fechaEvento<='".$fechaFin."' AND e.situacion IN(0,1,2,4,5) 
				AND con.tipoContenido=3 AND con.idRegistroContenidoReferencia=e.idRegistroEvento AND
				con.carpetaAdministrativa=c.carpetaAdministrativa AND c.unidadGestion='".$fila[1]."'
				and tipoCarpetaAdministrativa=5	";

	$audiencias=$con->obtenerValor($consulta);
	
	
	$consulta="SELECT COUNT(DISTINCT e.idRegistroEvento) FROM 7000_eventosAudiencia e,7007_contenidosCarpetaAdministrativa con,
			7006_carpetasAdministrativas c,3013_registroResolutivosAudiencia r 
			WHERE fechaEvento>='".$fechaInicio."' AND fechaEvento<='".$fechaFin."' AND e.situacion IN(0,1,2,4,5) 
			AND con.tipoContenido=3 AND con.idRegistroContenidoReferencia=e.idRegistroEvento AND
			con.carpetaAdministrativa=c.carpetaAdministrativa AND c.unidadGestion='".$fila[1]."' AND 
			r.idEvento=e.idRegistroEvento AND r.tipoResolutivo=92 and tipoCarpetaAdministrativa=5	";
	$sentenciasAbsolutorioas=$con->obtenerValor($consulta);
	
	$consulta="SELECT COUNT(DISTINCT e.idRegistroEvento) FROM 7000_eventosAudiencia e,7007_contenidosCarpetaAdministrativa con,
			7006_carpetasAdministrativas c,3013_registroResolutivosAudiencia r 
			WHERE fechaEvento>='".$fechaInicio."' AND fechaEvento<='".$fechaFin."' AND e.situacion IN(0,1,2,4,5) 
			AND con.tipoContenido=3 AND con.idRegistroContenidoReferencia=e.idRegistroEvento AND
			con.carpetaAdministrativa=c.carpetaAdministrativa AND c.unidadGestion='".$fila[1]."' AND 
			r.idEvento=e.idRegistroEvento AND r.tipoResolutivo=93 and tipoCarpetaAdministrativa=5	";
	$sentenciasCondenatorias=$con->obtenerValor($consulta);
	
	$consulta="SELECT COUNT(*) FROM 7006_carpetasAdministrativas c WHERE fechaCreacion>='".$fechaInicio.
			"' AND fechaCreacion<='".$fechaFin." 23:59:59' AND c.unidadGestion='".$fila[1]."' AND tipoCarpetaAdministrativa=4 
			AND carpetaAdministrativaBase IN(SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas 
			WHERE unidadGestion='".$fila[1]."' AND tipoCarpetaAdministrativa=5)";
	$apelaciones=$con->obtenerValor($consulta);
	
	
	$consulta="SELECT COUNT(*) FROM 7006_carpetasAdministrativas c WHERE fechaCreacion>='".$fechaInicio.
			"' AND fechaCreacion<='".$fechaFin." 23:59:59' AND c.unidadGestion='".$fila[1]."' AND tipoCarpetaAdministrativa=3 
			AND carpetaAdministrativaBase IN(SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas 
			WHERE unidadGestion='".$fila[1]."' AND tipoCarpetaAdministrativa=5)";
	$amparos=$con->obtenerValor($consulta);
	
	$libro->setValor("A".$nFila,$fila[2]);	
	$libro->setValor("B".$nFila,$audiencias);		
	$libro->setValor("C".$nFila,$sentenciasAbsolutorioas);	
	$libro->setValor("D".$nFila,$sentenciasCondenatorias);	
	$libro->setValor("E".$nFila,$apelaciones);	
	$libro->setValor("F".$nFila,$amparos);	
	$nFila++;
}


$libro->cambiarHojaActiva(1);
$libro->setValor("B2","Del ".$lblInicio." al ".$lblFin);
$nFila=5;

$consulta="SELECT id__26_tablaDinamica,clave,usuarioJuez,(SELECT nombre FROM 800_usuarios WHERE idUsuario=t.usuarioJuez) AS nombreJuez
		FROM _26_tablaDinamica t,_26_tipoJuez tj WHERE t.usuarioJuez<>-1 and t.usuarioJuez is not null 
		 AND tj.idPadre=t.id__26_tablaDinamica and tj.idOpcion=1 and usuarioJuez<>3122  order by clave";
$res=$con->obtenerFilas($consulta);
while($fila=mysql_fetch_row($res))
{
	$consulta="SELECT COUNT(*) FROM 3000_formatosRegistrados WHERE firmado=1 AND fechaRegistro>='".$fechaInicio.
				"' AND fechaRegistro<='".$fechaFin." 23:59:59' AND  responsableFirma=".$fila[2];
	$totalFirmas=$con->obtenerValor($consulta);
	
	$libro->setValor("A".$nFila,"[".$fila[1]."] ".$fila[3]);
	$libro->setValor("B".$nFila,$totalFirmas);	
	
	$nFila++;
}


$nFila=5;
$consulta="SELECT id__26_tablaDinamica,clave,usuarioJuez,(SELECT nombre FROM 800_usuarios WHERE idUsuario=t.usuarioJuez) AS nombreJuez
		  FROM _26_tablaDinamica t,_26_tipoJuez tj WHERE t.usuarioJuez<>-1 and t.usuarioJuez is not null 
		  AND tj.idPadre=t.id__26_tablaDinamica and tj.idOpcion=2 and usuarioJuez<>3122  order by clave";
$res=$con->obtenerFilas($consulta);
while($fila=mysql_fetch_row($res))
{
	$consulta="SELECT COUNT(*) FROM 3000_formatosRegistrados WHERE firmado=1 AND fechaRegistro>='".$fechaInicio.
				"' AND fechaRegistro<='".$fechaFin." 23:59:59' AND  responsableFirma=".$fila[2];
	$totalFirmas=$con->obtenerValor($consulta);
	
	$libro->setValor("C".$nFila,"[".$fila[1]."] ".$fila[3]);
	$libro->setValor("D".$nFila,$totalFirmas);	
	
	$nFila++;
}

$nFila=5;
$consulta="SELECT id__26_tablaDinamica,clave,usuarioJuez,(SELECT nombre FROM 800_usuarios WHERE idUsuario=t.usuarioJuez) AS nombreJuez
			FROM _26_tablaDinamica t,_26_tipoJuez tj WHERE t.usuarioJuez<>-1 and t.usuarioJuez is not null 
			AND tj.idPadre=t.id__26_tablaDinamica and tj.idOpcion=3 and usuarioJuez<>3122 order by clave";
$res=$con->obtenerFilas($consulta);
while($fila=mysql_fetch_row($res))
{
	$consulta="SELECT COUNT(*) FROM 3000_formatosRegistrados WHERE firmado=1 AND fechaRegistro>='".$fechaInicio.
				"' AND fechaRegistro<='".$fechaFin." 23:59:59' AND  responsableFirma=".$fila[2];
	$totalFirmas=$con->obtenerValor($consulta);
	
	$libro->setValor("E".$nFila,"[".$fila[1]."] ".$fila[3]);
	$libro->setValor("F".$nFila,$totalFirmas);	
	
	$nFila++;
}


$libro->cambiarHojaActiva(2);
$libro->setValor("B2","Del ".$lblInicio." al ".$lblFin);
$nFila=5;


$consulta="SELECT id__17_tablaDinamica,claveUnidad,nombreUnidad FROM _17_tablaDinamica u 
		WHERE cmbCategoria=1 ORDER BY prioridad";
$res=$con->obtenerFilas($consulta);
while($fila=mysql_fetch_row($res))
{
	$consulta="SELECT COUNT(DISTINCT e.idRegistroEvento) FROM 7000_eventosAudiencia e,7007_contenidosCarpetaAdministrativa con,7006_carpetasAdministrativas c 
				WHERE fechaEvento>='".$fechaInicio."' AND fechaEvento<='".$fechaFin."' AND e.situacion IN(0,1,2,4,5) 
				AND con.tipoContenido=3 AND con.idRegistroContenidoReferencia=e.idRegistroEvento AND
				con.carpetaAdministrativa=c.carpetaAdministrativa AND c.unidadGestion='".$fila[1]."'";

	$audiencias=$con->obtenerValor($consulta);
	
	
	$consulta="SELECT COUNT(DISTINCT e.idRegistroEvento) FROM 7000_eventosAudiencia e,7007_contenidosCarpetaAdministrativa con,
			7006_carpetasAdministrativas c,3013_registroResolutivosAudiencia r 
			WHERE fechaEvento>='".$fechaInicio."' AND fechaEvento<='".$fechaFin."' AND e.situacion IN(0,1,2,4,5) 
			AND con.tipoContenido=3 AND con.idRegistroContenidoReferencia=e.idRegistroEvento AND
			con.carpetaAdministrativa=c.carpetaAdministrativa AND c.unidadGestion='".$fila[1]."' AND 
			r.idEvento=e.idRegistroEvento AND r.tipoResolutivo=92";
	$sentenciasAbsolutorioas=$con->obtenerValor($consulta);
	
	$consulta="SELECT COUNT(DISTINCT e.idRegistroEvento) FROM 7000_eventosAudiencia e,7007_contenidosCarpetaAdministrativa con,
			7006_carpetasAdministrativas c,3013_registroResolutivosAudiencia r 
			WHERE fechaEvento>='".$fechaInicio."' AND fechaEvento<='".$fechaFin."' AND e.situacion IN(0,1,2,4,5) 
			AND con.tipoContenido=3 AND con.idRegistroContenidoReferencia=e.idRegistroEvento AND
			con.carpetaAdministrativa=c.carpetaAdministrativa AND c.unidadGestion='".$fila[1]."' AND 
			r.idEvento=e.idRegistroEvento AND r.tipoResolutivo=93";
	$sentenciasCondenatorias=$con->obtenerValor($consulta);
	
	$consulta="SELECT COUNT(*) FROM 7006_carpetasAdministrativas c WHERE fechaCreacion>='".$fechaInicio.
			"' AND fechaCreacion<='".$fechaFin." 23:59:59' AND c.unidadGestion='".$fila[1]."' AND tipoCarpetaAdministrativa=4";
	$apelaciones=$con->obtenerValor($consulta);
	
	
	$consulta="SELECT COUNT(*) FROM 7006_carpetasAdministrativas c WHERE fechaCreacion>='".$fechaInicio.
			"' AND fechaCreacion<='".$fechaFin." 23:59:59' AND c.unidadGestion='".$fila[1]."' AND tipoCarpetaAdministrativa=3";
	$amparos=$con->obtenerValor($consulta);
	
	$consulta="SELECT COUNT(DISTINCT e.idRegistroEvento) FROM 7000_eventosAudiencia e,7007_contenidosCarpetaAdministrativa con,
						7006_carpetasAdministrativas c,3014_registroResutadoAudiencia rA 
				WHERE fechaEvento>='".$fechaInicio."' AND fechaEvento<='".$fechaFin."' AND e.situacion IN(0,1,2,4,5) 
				AND con.tipoContenido=3 AND con.idRegistroContenidoReferencia=e.idRegistroEvento AND
				con.carpetaAdministrativa=c.carpetaAdministrativa AND c.unidadGestion='".$fila[1]."'
				and rA.idEvento=e.idRegistroEvento and rA.situacion=1";
	$resolutivos=$con->obtenerValor($consulta);
	
	$actividadesRemitidas=0;
	
	
	$consulta="SELECT COUNT(*) FROM 7035_informacionDocumentos i,7006_carpetasAdministrativas c,3000_formatosRegistrados f WHERE 
			  i.carpetaAdministrativa=c.carpetaAdministrativa AND c.unidadGestion='".$fila[1]."' AND 
			  f.idFormulario=-2 AND f.idRegistro=i.idRegistro
			  AND f.fechaRegistro>='".$fechaInicio."' AND f.fechaRegistro<='".$fechaFin." 23:59:59' and firmado=1";
	$documentosFirmados=$con->obtenerValor($consulta);
	
	
	
	
	$consulta="SELECT COUNT(*) FROM _293_tablaDinamica i,7006_carpetasAdministrativas c,3000_formatosRegistrados f  WHERE 
				i.carpetaAdministrativa=c.carpetaAdministrativa AND c.unidadGestion='".$fila[1]."' AND f.idFormulario=293 AND 
				f.idRegistro=i.id__293_tablaDinamica AND f.fechaRegistro>='".$fechaInicio."' AND f.fechaRegistro<='".$fechaFin." 23:59:59' and firmado=1";
	
	$documentosFirmados+=$con->obtenerValor($consulta);
	
	
	
	
	$consulta="SELECT COUNT(*) FROM 7028_actaNotificacion i,7006_carpetasAdministrativas c,3000_formatosRegistrados f  WHERE 
				i.carpetaAdministrativa=c.carpetaAdministrativa AND c.unidadGestion='".$fila[1]."' AND 
				f.idFormulario=-1 AND f.idRegistro=i.idRegistro
				AND f.fechaRegistro>='".$fechaInicio."' AND f.fechaRegistro<='".$fechaFin." 23:59:59' and firmado=1";
	
	$documentosFirmados+=$con->obtenerValor($consulta);
	
	
	$consulta="SELECT COUNT(*) FROM 7006_carpetasAdministrativas WHERE fechaCreacion>='".$fechaInicio."' AND fechaCreacion<='".$fechaFin.
			" 23:59:59' AND tipoCarpetaAdministrativa=1 AND carpetaAdministrativaBase 
			 IN(SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE unidadGestion='".$fila[1].
			 "' AND tipoCarpetaAdministrativa=1)";
	$actividadesRemitidas=$con->obtenerValor($consulta);
	
	$consulta="SELECT COUNT(*) FROM 7006_carpetasAdministrativas WHERE fechaCreacion>='".$fechaInicio."' AND fechaCreacion<='".$fechaFin.
			" 23:59:59' AND tipoCarpetaAdministrativa=5 AND carpetaAdministrativaBase 
			 IN(SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE unidadGestion='".$fila[1].
			 "' AND tipoCarpetaAdministrativa=5)";
	$actividadesRemitidas+=$con->obtenerValor($consulta);
	
	$consulta="SELECT COUNT(*) FROM 7006_carpetasAdministrativas WHERE fechaCreacion>='".$fechaInicio."' AND fechaCreacion<='".$fechaFin.
			" 23:59:59' AND tipoCarpetaAdministrativa=6 AND carpetaAdministrativaBase 
			 IN(SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE unidadGestion='".$fila[1].
			 "' AND tipoCarpetaAdministrativa=6)";
	$actividadesRemitidas+=$con->obtenerValor($consulta);
	
	$consulta="SELECT COUNT(*) FROM 7035_informacionDocumentos i,7006_carpetasAdministrativas c,3000_formatosRegistrados f,_10_tablaDinamica cF WHERE 
			  i.carpetaAdministrativa=c.carpetaAdministrativa AND c.unidadGestion='".$fila[1]."' AND 
			  f.idFormulario=-2 AND f.idRegistro=i.idRegistro and cF.id__10_tablaDinamica=f.tipoFormato and cF.categoriaDocumento=52
			  AND f.fechaRegistro>='".$fechaInicio."' AND f.fechaRegistro<='".$fechaFin." 23:59:59' and firmado=1";
	$oficiosMedidas=$con->obtenerValor($consulta);
	
	$consulta="SELECT COUNT(*) FROM 7028_actaNotificacion i,7006_carpetasAdministrativas c,3000_formatosRegistrados f  WHERE 
				i.carpetaAdministrativa=c.carpetaAdministrativa AND c.unidadGestion='".$fila[1]."' AND 
				f.idFormulario=-1 AND f.idRegistro=i.idRegistro
				AND f.fechaRegistro>='".$fechaInicio."' AND f.fechaRegistro<='".$fechaFin." 23:59:59' and firmado=1";
	
	$actasCircunstanciadas=$con->obtenerValor($consulta);
	
	$consulta="SELECT COUNT(*) FROM 3300_respuestasSolicitudPromocion rp,_96_tablaDinamica p,7006_carpetasAdministrativas c WHERE
				rp.idRegistro=p.id__96_tablaDinamica AND c.carpetaAdministrativa=p.carpetaAdministrativa AND c.unidadGestion='".$fila[1]."'
				AND rp.notificadoPGJ=1 AND rp.fechaNotificacion>='".$fechaInicio."' AND rp.fechaNotificacion<='".$fechaFin." 23:59:59'";
	
	$respuestasPGJ=$con->obtenerValor($consulta);
	
	$consulta="SELECT COUNT(*) FROM 7005_bitacoraCambiosFigurasJuridicas b,7006_carpetasAdministrativas c
				WHERE c.idActividad=b.idActividad AND b.fechaCambio>='".$fechaInicio."' AND b.fechaCambio<='".$fechaFin." 23:59:59' 
				AND c.unidadGestion='".$fila[1]."'";
	$statusImputados=$con->obtenerValor($consulta);

	$libro->setValor("A".$nFila,$fila[2]);	
	$libro->setValor("B".$nFila,$audiencias);		
	$libro->setValor("C".$nFila,$resolutivos);		
	$libro->setValor("D".$nFila,$actividadesRemitidas);		
	$libro->setValor("E".$nFila,$documentosFirmados);		
	$libro->setValor("F".$nFila,$oficiosMedidas);		
	$libro->setValor("G".$nFila,$respuestasPGJ);		
	$libro->setValor("H".$nFila,$actasCircunstanciadas);	
	
	$libro->setValor("I".$nFila,$statusImputados);		
	$libro->setValor("J".$nFila,$sentenciasAbsolutorioas);	
	$libro->setValor("K".$nFila,$sentenciasCondenatorias);	
	$libro->setValor("L".$nFila,$apelaciones);	
	$libro->setValor("M".$nFila,$amparos);	
	$nFila++;
}


$libro->cambiarHojaActiva(3);
$libro->setValor("B2","Del ".$lblInicio." al ".$lblFin);
$nFila=5;

$consulta="select * from (SELECT id__26_tablaDinamica,clave,usuarioJuez,(SELECT nombre FROM 800_usuarios WHERE idUsuario=t.usuarioJuez) AS nombreJuez
		  FROM _26_tablaDinamica t,_26_tipoJuez tj WHERE t.usuarioJuez<>-1 and t.usuarioJuez is not null 
		  AND  usuarioJuez<>3122 and tj.idPadre=t.id__26_tablaDinamica AND tj.idOpcion<>5) as tmp  order by nombreJuez";
$res=$con->obtenerFilas($consulta);
while($fila=mysql_fetch_row($res))
{
	$totalAudienciasExtraHorario=0;
	$consulta="SELECT fechaEvento,horaInicioEvento FROM 7000_eventosAudiencia e,7001_eventoAudienciaJuez j WHERE
				j.idRegistroEvento=e.idRegistroEvento AND e.fechaEvento>='".$fechaInicio."' AND 
				e.fechaEvento<='".$fechaFin."' AND j.idJuez=".$fila[2]." AND e.situacion IN(0,1,2,4,5)";
	$rAudiencias=$con->obtenerFilas($consulta);
	$totalAudiencias=$con->filasAfectadas;
	while($fAudiencia=mysql_fetch_row($rAudiencias))
	{
		$hILaboral=strtotime($fAudiencia[0]." 09:00");
		$hFLaboral=strtotime($fAudiencia[0]." 16:00");
		
		$hAudiencia=strtotime($fAudiencia[1]);
		
		
		if(!(($hAudiencia>=$hILaboral)&&($hAudiencia<=$hFLaboral)))
		{
			
			$totalAudienciasExtraHorario++;
		}
	}
	$libro->setValor("A".$nFila,"[".$fila[1]."] ".$fila[3]);
	$libro->setValor("B".$nFila,$totalAudiencias);	
	$libro->setValor("C".$nFila,$totalAudienciasExtraHorario);	
	
	$nFila++;
}


$libro->generarArchivo("Excel2007","informeEstadisticas_".str_replace("-","_",$fechaInicio)."_".str_replace("-","_",$fechaFin).".xlsx");



?>