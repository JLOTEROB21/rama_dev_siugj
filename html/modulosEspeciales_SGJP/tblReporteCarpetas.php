<?php include("sesiones.php");
include("conexionBD.php"); 
include("configurarIdioma.php");
include("funcionesPortal.php");

$fechaInicio="";
if(isset($_POST["fechaInicio"]))
	$fechaInicio=$_POST["fechaInicio"];
	

$fechaFin="";
if(isset($_POST["fechaFin"]))
	$fechaFin=$_POST["fechaFin"];
	
	
$nFila=4;
$libro=new cExcel("../modulosEspeciales_SGJP/formatos/plantillaInformeUgasApelaciones.xlsx",true,"Excel2007");	

$fechaCreacion=strtotime($fila["fechaCreacion"]);
$libro->setValor("A".$nFila,date("H:i",$fechaCreacion));
$libro->setValor("B1","Del ".(convertirFechaLetra($fechaInicio))." al ".(convertirFechaLetra($fechaFin)));	

$arrTiposCarpeta[1]="Unidades de Gesti&oacute;n Judicial";
$arrTiposCarpeta[5]="Tribunal de Enjuciamiento";


foreach($arrTiposCarpeta as $tCarpeta=>$etiqueta)
{
	$consulta="SELECT id__17_tablaDinamica,nombreUnidad,claveUnidad FROM _17_tablaDinamica u,_17_tiposCarpetasAdministra c 
			WHERE c.idPadre=u.id__17_tablaDinamica and  c.idOpcion=".$tCarpeta." ORDER BY prioridad";
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		$libro->setValor("A".$nFila,$fila[1].($tCarpeta==5?" (Tribunal Enjuiciamiento)":""));
		
		
		$consulta="SELECT COUNT(*) from 7006_carpetasAdministrativas WHERE fechaCreacion>='".$fechaInicio.
				"' AND fechaCreacion<='".$fechaFin." 23:59:59' AND unidadGestionOriginal='".$fila[2]."' AND tipoCarpetaAdministrativa=".$tCarpeta;
		$rTotal=$con->obtenerValor($consulta);
		
		$libro->setValor("B".$nFila,$rTotal);
		
		$consulta="SELECT COUNT(e.idRegistroEvento) FROM 7000_eventosAudiencia e,7007_contenidosCarpetaAdministrativa co,7006_carpetasAdministrativas c 
					WHERE e.fechaEvento>='".$fechaInicio."' AND e.fechaEvento<='".$fechaFin."' AND co.tipoContenido=3 AND co.idRegistroContenidoReferencia=e.idRegistroEvento AND 
					co.carpetaAdministrativa=c.carpetaAdministrativa AND e.idCentroGestion=".$fila[0]." AND c.tipoCarpetaAdministrativa=".$tCarpeta.
					" and e.situacion in(1,2,4,5)";
		
		$rTotal=$con->obtenerValor($consulta);
		
		$libro->setValor("C".$nFila,$rTotal);
		
		$consulta="SELECT COUNT(DISTINCT c.carpetaAdministrativa) FROM 7000_eventosAudiencia e,7007_contenidosCarpetaAdministrativa co,7006_carpetasAdministrativas c,3013_registroResolutivosAudiencia a 
					WHERE e.fechaEvento>='".$fechaInicio."' AND e.fechaEvento<='".$fechaFin."' AND co.tipoContenido=3 AND co.idRegistroContenidoReferencia=e.idRegistroEvento AND 
					co.carpetaAdministrativa=c.carpetaAdministrativa AND e.idCentroGestion=".$fila[0]." AND  a.idEvento=e.idRegistroEvento AND tipoResolutivo IN(93,24) AND c.tipoCarpetaAdministrativa=".$tCarpeta;

		$rTotal=$con->obtenerValor($consulta);
		
		$libro->setValor("D".$nFila,$rTotal);
		
		
		$consulta="SELECT COUNT(DISTINCT c.carpetaAdministrativa) FROM 7000_eventosAudiencia e,7007_contenidosCarpetaAdministrativa co,7006_carpetasAdministrativas c,3013_registroResolutivosAudiencia a 
					WHERE e.fechaEvento>='".$fechaInicio."' AND e.fechaEvento<='".$fechaFin."' AND co.tipoContenido=3 AND co.idRegistroContenidoReferencia=e.idRegistroEvento AND 
					co.carpetaAdministrativa=c.carpetaAdministrativa AND e.idCentroGestion=".$fila[0]." AND  a.idEvento=e.idRegistroEvento AND tipoResolutivo IN(92) AND c.tipoCarpetaAdministrativa=".$tCarpeta;
		
		$rTotal=$con->obtenerValor($consulta);
		
		$libro->setValor("E".$nFila,$rTotal);
		
		$consulta="SELECT COUNT(*) FROM 7006_carpetasAdministrativas c WHERE c.fechaCreacion>='".$fechaInicio."' AND c.fechaCreacion<='".$fechaFin.
				" 23:59:59' AND unidadGestion='".$fila[2]."' AND tipoCarpetaAdministrativa=4";
		
		$rTotal=$con->obtenerValor($consulta);
		
		$libro->setValor("F".$nFila,$rTotal);
		
		
		$nFila++;
		
	}

}



$libro->generarArchivo("Excel2007","informe.xlsx");
?>