<?php include("sesiones.php");
include("conexionBD.php"); 


$libro=new cExcel("../modulosEspeciales_SGJP/formatos/sabanaAudiencias.xlsx",true,"Excel2007");

$nFila=2;
$consulta="SELECT c.carpetaAdministrativa,e.* FROM 7006_carpetasAdministrativas c,7007_contenidosCarpetaAdministrativa con ,7000_eventosAudiencia e
			WHERE unidadGestion='009' AND tipoCarpetaAdministrativa=6 AND con.carpetaAdministrativa=c.carpetaAdministrativa
			AND con.tipoContenido=3 AND con.idRegistroContenidoReferencia=e.idRegistroEvento AND e.situacion IN (1,2,4,5)";
$res=$con->obtenerFilas($consulta);
while($fila=mysql_fetch_assoc($res))
{
	$consulta="SELECT tipoAudiencia FROM _4_tablaDinamica WHERE id__4_tablaDinamica=".$fila["tipoAudiencia"];
	$tipoAudiencia=$con->obtenerValor($consulta);
	$consulta="SELECT nombreSala FROM _15_tablaDinamica WHERE id__15_tablaDinamica=".$fila["idSala"];
	$sala=$con->obtenerValor($consulta);
	
	$consulta="SELECT Nombre FROM 800_usuarios u,7001_eventoAudienciaJuez e WHERE idUsuario=e.idJuez AND e.idRegistroEvento=".$fila["idRegistroEvento"];
	$nombre=$con->obtenerValor($consulta);	
	
	$idActividad=obtenerIDActividadCarpetaJudicial($fila["carpetaAdministrativa"]);
	$libro->setValor("A".$nFila,$fila["carpetaAdministrativa"]);	
	$libro->setValor("B".$nFila,$tipoAudiencia);	
	$libro->setValor("C".$nFila,$fila["fechaSolicitud"]!=""?date("d/m/Y",strtotime($fila["fechaSolicitud"])):"N/D");	
	$libro->setValor("D".$nFila,$fila["fechaSolicitud"]!=""?date("H:i:s",strtotime($fila["fechaSolicitud"])):"N/D");
	$libro->setValor("E".$nFila,$fila["fechaEvento"]);
	$libro->setValor("F".$nFila,$arrMesLetra[(date("m",strtotime($fila["fechaEvento"]))*1)-1]);
	$libro->setValor("G".$nFila,date("H:i",strtotime($fila["horaInicioEvento"])));	
	$libro->setValor("H".$nFila,$sala);	
	$libro->setValor("J".$nFila,$nombre);	

	if($idActividad==-1)
	{
		$libro->setValor("K".$nFila,"N/D");	
		$libro->setValor("M".$nFila,"N/D");	
		$nFila++;
	}
	else
	{
		$consulta="SELECT GROUP_CONCAT(de.denominacionDelito) FROM _61_tablaDinamica d,_35_denominacionDelito de WHERE d.idActividad= ".$idActividad."
					AND de.id__35_denominacionDelito=d.denominacionDelito ORDER BY d.denominacionDelito";
		$lblDelitos=$con->obtenerValor($consulta);
		$libro->setValor("K".$nFila,$lblDelitos);
		
		$consulta="SELECT p.*,r.idFiguraJuridica as tipoFiguraRelacion FROM  7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica p WHERE r.idActividad=".$idActividad." 
					AND idFiguraJuridica in(1,2) AND p.id__47_tablaDinamica=r.idParticipante";
		
		$resParticipante=$con->obtenerFilas($consulta);
		if($con->filasAfectadas==0)
		{
			$nFila++;
		}
		else
		{
			while($filaP=mysql_fetch_assoc($resParticipante))
			{
				$lblNombre="";
				if($filaP["tipoFiguraRelacion"]==1)
				{
					$lblNombre="(D) ";
				}
				$lblNombre.=$filaP["nombre"];
				if($filaP["tipoPersona"]!=2)
				{
					$lblNombre.=" ".$filaP["apellidoPaterno"]." ".$filaP["apellidoMaterno"];
					if($filaP["genero"]==1)
					{
						$libro->setValor("P".$nFila,"X");
					}
					else
					{
						$libro->setValor("O".$nFila,"X");
					}
					if($filaP["edad"]<18)
						$libro->setValor("Q".$nFila,"X");
				}
				else
				{
					$libro->setValor("N".$nFila,"X");
				}
				$libro->setValor("M".$nFila,trim($lblNombre));
				$nFila++;
			}
		}
	}
	
}

$libro->generarArchivo("Excel2007","informe.xlsx");
?>