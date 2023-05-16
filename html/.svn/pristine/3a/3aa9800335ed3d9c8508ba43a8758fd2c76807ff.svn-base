<?php 
include("conexionBD.php");

$periodoInicial="";
$periodoInicial=$_POST["fechaInicio"];

$periodoFinal="";
$periodoFinal=$_POST["fechaFin"];

$libro=new cExcel("../modulosEspeciales_SGJP/formatos/plantillaIncompetencias.xlsx",true,"Excel2007");	
$libro->setValor("C2","Periodo del ".date("d/m/Y",strtotime($periodoInicial))." al ".date("d/m/Y",strtotime($periodoFinal)));

$consulta="SELECT carpetaTribunalEnjuiciamiento FROM _320_tablaDinamica s,7006_carpetasAdministrativas c
WHERE c.carpetaAdministrativa=s.carpetaAdministrativa AND c.tipoCarpetaAdministrativa=5 AND s.idEstado>1";
$listaCarpetas=$con->obtenerListaValores($consulta,"'");
if($listaCarpetas=="")
	$listaCarpetas=-1;



$consulta="select * from (SELECT 
REPLACE(s.carpetaAdministrativa,'.','') AS carpetaDestino,
(SELECT GROUP_CONCAT(u.nombreUnidad) FROM 7006_carpetasAdministrativas c,_17_tablaDinamica u 
WHERE c.carpetaAdministrativa=REPLACE(s.carpetaRemitida,'.','') AND u.claveUnidad=c.unidadGestion) AS unidadRemitente,
REPLACE(s.carpetaRemitida,'.','') AS carpetaRemitida,
(SELECT tipoAudiencia FROM _4_tablaDinamica WHERE id__4_tablaDinamica=s.tipoAudiencia) AS tipoIncompetencia,
c.fechaCreacion,
s.folioCarpetaInvestigacion,


 (SELECT COUNT(e.idRegistroEvento) FROM 7007_contenidosCarpetaAdministrativa co,7000_eventosAudiencia e,3014_registroMedidasCautelares r 
 WHERE co.carpetaAdministrativa=s.carpetaAdministrativa 
 AND tipoContenido=3 AND e.idRegistroEvento=co.idRegistroContenidoReferencia AND r.idEventoAudiencia=e.idRegistroEvento
 AND tipoMedida=14 LIMIT 0,1) AS conSinDetenido,

(
SELECT GROUP_CONCAT(CONCAT(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',
IF(apellidoMaterno IS NULL,'',apellidoMaterno))) FROM _47_tablaDinamica p,7005_relacionFigurasJuridicasSolicitud r
WHERE p.id__47_tablaDinamica=r.idParticipante AND r.idActividad=s.idActividad AND idFiguraJuridica=4

) AS imputados,
(
SELECT GROUP_CONCAT(CONCAT(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',
IF(apellidoMaterno IS NULL,'',apellidoMaterno))) FROM _47_tablaDinamica p,7005_relacionFigurasJuridicasSolicitud r
WHERE p.id__47_tablaDinamica=r.idParticipante AND r.idActividad=s.idActividad AND idFiguraJuridica=2

) AS victimas,
(
SELECT GROUP_CONCAT(CONCAT(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',
IF(apellidoMaterno IS NULL,'',apellidoMaterno))) FROM _47_tablaDinamica p,7005_relacionFigurasJuridicasSolicitud r
WHERE p.id__47_tablaDinamica=r.idParticipante AND r.idActividad=s.idActividad AND idFiguraJuridica=1

) AS denunciantes,
(
	SELECT GROUP_CONCAT(de.denominacionDelito) FROM _35_denominacionDelito de,_61_tablaDinamica d WHERE 
	d.denominacionDelito=de.id__35_denominacionDelito AND d.idActividad=s.idActividad
) AS delitos,
(
	CASE iFormulario
	WHEN 329 THEN
		(SELECT comentariosAdicionales FROM _329_tablaDinamica WHERE carpetaAdministrativa=s.carpetaRemitida LIMIT 0,1)
	WHEN 307 THEN
		(SELECT txtMotivoRemision FROM _307_tablaDinamica WHERE carpetaAdministrativa=s.carpetaRemitida LIMIT 0,1)
	WHEN 382 THEN
		(SELECT motivoRemision FROM _382_tablaDinamica WHERE carpetaAdministrativa=s.carpetaRemitida LIMIT 0,1)
	WHEN 554 THEN
		(SELECT comentariosAdicionales FROM _554_tablaDinamica WHERE id__554_tablaDinamica=s.iReferencia LIMIT 0,1)
	ELSE
		''
	END

) AS comentariosAdicionales,

iFormulario,iReferencia

 FROM _46_tablaDinamica s,7006_carpetasAdministrativas c WHERE tipoAudiencia IN(91,102,114) AND s.idEstado>1.4 AND c.fechaCreacion>='".$periodoInicial.
 "' AND c.fechaCreacion<='".$periodoFinal." 23:59:59' and c.carpetaAdministrativa=s.carpetaAdministrativa
 
 UNION

SELECT c.carpetaAdministrativa AS carpetaDestino ,(SELECT GROUP_CONCAT(u.nombreUnidad) FROM 7006_carpetasAdministrativas c,_17_tablaDinamica u WHERE c.idCarpeta=s.carpetaJudicialOrigen AND u.claveUnidad=c.unidadGestion) AS unidadRemitente,
( SELECT cR.carpetaAdministrativa FROM 7006_carpetasAdministrativas cR WHERE idCarpeta=s.carpetaJudicialOrigen) AS carpetaRemitida, (SELECT tipoAudiencia FROM _4_tablaDinamica WHERE id__4_tablaDinamica=s.tipoSolicitud) AS tipoIncompetencia,
c.fechaCreacion,(SELECT carpetaInvestigacion FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa=s.carpetaJudicialOrigen) AS folioCarpetaInvestigacion,
imputadoPrivadoLibertad AS conSinDetenido,
( SELECT GROUP_CONCAT(CONCAT(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ', IF(apellidoMaterno IS NULL,'',apellidoMaterno))) FROM _47_tablaDinamica p,7005_relacionFigurasJuridicasSolicitud r WHERE p.id__47_tablaDinamica=r.idParticipante AND r.idActividad=s.idActividad AND idFiguraJuridica=4 ) AS imputados, 
( SELECT GROUP_CONCAT(CONCAT(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ', IF(apellidoMaterno IS NULL,'',apellidoMaterno))) FROM _47_tablaDinamica p,7005_relacionFigurasJuridicasSolicitud r WHERE p.id__47_tablaDinamica=r.idParticipante AND r.idActividad=s.idActividad AND idFiguraJuridica=2 ) AS victimas, 
( SELECT GROUP_CONCAT(CONCAT(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ', IF(apellidoMaterno IS NULL,'',apellidoMaterno))) FROM _47_tablaDinamica p,7005_relacionFigurasJuridicasSolicitud r WHERE p.id__47_tablaDinamica=r.idParticipante AND r.idActividad=s.idActividad AND idFiguraJuridica=1 ) AS denunciantes, 
( SELECT GROUP_CONCAT(de.denominacionDelito) FROM _35_denominacionDelito de,_61_tablaDinamica d WHERE d.denominacionDelito=de.id__35_denominacionDelito AND d.idActividad=s.idActividad ) AS delitos, 
'' AS comentariosAdicionales,538 AS iFormulario,id__538_tablaDinamica AS iReferencia

FROM _538_tablaDinamica s,7006_carpetasAdministrativas c WHERE c.carpetaAdministrativa=s.carpetaAdministrativa and c.fechaCreacion>='".$periodoInicial.
"' AND c.fechaCreacion<='".$periodoFinal." 23:59:59' AND tipoExpediente=1

union
SELECT c.carpetaAdministrativa AS carpetaDestino ,
(SELECT GROUP_CONCAT(u.nombreUnidad) FROM 7006_carpetasAdministrativas ,_17_tablaDinamica u WHERE 
carpetaAdministrativa=c.carpetaAdministrativaBase AND u.claveUnidad=unidadGestion) AS unidadRemitente, 
carpetaAdministrativaBase AS carpetaRemitida, 
(SELECT tipoAudiencia FROM _4_tablaDinamica WHERE id__4_tablaDinamica=91) AS tipoIncompetencia, 
c.fechaCreacion,carpetaInvestigacion AS folioCarpetaInvestigacion, 

 (SELECT COUNT(e.idRegistroEvento) FROM 7007_contenidosCarpetaAdministrativa co,7000_eventosAudiencia e,3014_registroMedidasCautelares r 
 WHERE co.carpetaAdministrativa=c.carpetaAdministrativaBase 
 AND tipoContenido=3 AND e.idRegistroEvento=co.idRegistroContenidoReferencia AND r.idEventoAudiencia=e.idRegistroEvento
 AND tipoMedida=14 LIMIT 0,1) AS conSinDetenido,
( SELECT GROUP_CONCAT(CONCAT(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ', 
IF(apellidoMaterno IS NULL,'',apellidoMaterno))) FROM _47_tablaDinamica p,7005_relacionFigurasJuridicasSolicitud r 
WHERE p.id__47_tablaDinamica=r.idParticipante AND r.idActividad=c.idActividad AND idFiguraJuridica=4 ) AS imputados, 
( SELECT GROUP_CONCAT(CONCAT(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ', 
IF(apellidoMaterno IS NULL,'',apellidoMaterno))) FROM _47_tablaDinamica p,7005_relacionFigurasJuridicasSolicitud r 
WHERE p.id__47_tablaDinamica=r.idParticipante AND r.idActividad=c.idActividad AND idFiguraJuridica=2 ) AS victimas, 
( SELECT GROUP_CONCAT(CONCAT(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ', 
IF(apellidoMaterno IS NULL,'',apellidoMaterno))) FROM _47_tablaDinamica p,7005_relacionFigurasJuridicasSolicitud r 
WHERE p.id__47_tablaDinamica=r.idParticipante AND r.idActividad=c.idActividad AND idFiguraJuridica=1 ) AS denunciantes, 
( SELECT GROUP_CONCAT(de.denominacionDelito) FROM _35_denominacionDelito de,_61_tablaDinamica d WHERE 
d.denominacionDelito=de.id__35_denominacionDelito AND d.idActividad=c.idActividad ) AS delitos, '' AS comentariosAdicionales,
-1 AS iFormulario,idCarpeta AS iReferencia FROM 7006_carpetasAdministrativas c WHERE 
 c.fechaCreacion>='".$periodoInicial."' AND c.fechaCreacion<='".$periodoFinal." 23:59:59' AND tipoCarpetaAdministrativa IN(5,6) AND
 idFormulario=-1 and unidadGestion<>302
union

SELECT c.carpetaAdministrativa AS carpetaDestino,(SELECT GROUP_CONCAT(u.nombreUnidad) FROM 7006_carpetasAdministrativas cA,_17_tablaDinamica u 
 WHERE cA.carpetaAdministrativa=c.carpetaAdministrativaBase AND u.claveUnidad=cA.unidadGestion) AS unidadRemitente,
c.carpetaAdministrativaBase AS carpetaRemitida,mI.motivoIncompetencia AS tipoIncompetencia, c.fechaCreacion,c.carpetaInvestigacion AS folioCarpetaInvestigacion,
imputadoPrivadoLibertad AS conSinDetenido,
( SELECT GROUP_CONCAT(CONCAT(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ', 
 IF(apellidoMaterno IS NULL,'',apellidoMaterno))) FROM _47_tablaDinamica p,7005_relacionFigurasJuridicasSolicitud r WHERE 
 p.id__47_tablaDinamica=r.idParticipante AND r.idActividad=c.idActividad AND idFiguraJuridica=4 ) AS imputados, 
 ( SELECT GROUP_CONCAT(CONCAT(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ', 
 IF(apellidoMaterno IS NULL,'',apellidoMaterno))) FROM _47_tablaDinamica p,7005_relacionFigurasJuridicasSolicitud r WHERE 
 p.id__47_tablaDinamica=r.idParticipante AND r.idActividad=c.idActividad AND idFiguraJuridica=2 ) AS victimas, 
 ( SELECT GROUP_CONCAT(CONCAT(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ', 
 IF(apellidoMaterno IS NULL,'',apellidoMaterno))) FROM _47_tablaDinamica p,7005_relacionFigurasJuridicasSolicitud r WHERE 
 p.id__47_tablaDinamica=r.idParticipante AND r.idActividad=c.idActividad AND idFiguraJuridica=1 ) AS denunciantes,
 ( SELECT GROUP_CONCAT(de.denominacionDelito) FROM _35_denominacionDelito de,_61_tablaDinamica d WHERE 
 d.denominacionDelito=de.id__35_denominacionDelito AND d.idActividad=c.idActividad ) AS delitos, ''
 AS comentariosAdicionales,558 AS iFormulario,id__558_tablaDinamica AS iReferencia
  FROM 
 7006_carpetasAdministrativas c, _558_tablaDinamica mI WHERE 
c.fechaCreacion>='".$periodoInicial."' AND  c.fechaCreacion<='".$periodoFinal." 23:59:59' AND c.idFormulario=558 
AND mI.id__558_tablaDinamica=c.idRegistro AND c.tipoCarpetaAdministrativa IN(5,6)

union


SELECT c.carpetaAdministrativa AS carpetaDestino ,(SELECT GROUP_CONCAT(u.nombreUnidad) FROM 7006_carpetasAdministrativas c,_17_tablaDinamica u WHERE c.carpetaAdministrativa=s.carpetaAdministrativa AND u.claveUnidad=c.unidadGestion) AS unidadRemitente,
s.carpetaAdministrativa AS carpetaRemitida, (SELECT tipoAudiencia FROM _4_tablaDinamica WHERE id__4_tablaDinamica=91) AS tipoIncompetencia,
c.fechaCreacion,carpetaInvestigacion AS folioCarpetaInvestigacion,
prisionPreventiva AS conSinDetenido,
( SELECT GROUP_CONCAT(CONCAT(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ', IF(apellidoMaterno IS NULL,'',apellidoMaterno))) FROM _47_tablaDinamica p,7005_relacionFigurasJuridicasSolicitud r WHERE p.id__47_tablaDinamica=r.idParticipante AND r.idActividad=c.idActividad AND idFiguraJuridica=4 ) AS imputados, 
( SELECT GROUP_CONCAT(CONCAT(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ', IF(apellidoMaterno IS NULL,'',apellidoMaterno))) FROM _47_tablaDinamica p,7005_relacionFigurasJuridicasSolicitud r WHERE p.id__47_tablaDinamica=r.idParticipante AND r.idActividad=c.idActividad AND idFiguraJuridica=2 ) AS victimas, 
( SELECT GROUP_CONCAT(CONCAT(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ', IF(apellidoMaterno IS NULL,'',apellidoMaterno))) FROM _47_tablaDinamica p,7005_relacionFigurasJuridicasSolicitud r WHERE p.id__47_tablaDinamica=r.idParticipante AND r.idActividad=c.idActividad AND idFiguraJuridica=1 ) AS denunciantes, 
( SELECT GROUP_CONCAT(de.denominacionDelito) FROM _35_denominacionDelito de,_61_tablaDinamica d WHERE d.denominacionDelito=de.id__35_denominacionDelito AND d.idActividad=c.idActividad ) AS delitos, 
comentariosAdicionales,320 AS iFormulario,id__320_tablaDinamica AS iReferencia

FROM _320_tablaDinamica s,7006_carpetasAdministrativas c WHERE c.carpetaAdministrativa=s.carpetaTribunalEnjuiciamiento 
AND c.fechaCreacion>='".$periodoInicial."' AND c.fechaCreacion<='".$periodoFinal." 23:59:59' AND s.carpetaTribunalEnjuiciamiento IN
(".$listaCarpetas.")
) as tmp 




  order by fechaCreacion
 ";


$numFilas=6;
$noIncompetencia=1;


$res=$con->obtenerFilas($consulta);
while($fila=mysql_fetch_row($res))
{
	$libro->setValor("B".$numFilas,$noIncompetencia);
	$libro->setValor("C".$numFilas,$fila[0]);
	$libro->setValor("D".$numFilas,$fila[1]);
	$libro->setValor("E".$numFilas,$fila[2]);
	$libro->setValor("F".$numFilas,$fila[3]);
	$libro->setValor("G".$numFilas,$fila[4]);
	$libro->setValor("H".$numFilas,$fila[5]);
	$libro->setValor("I".$numFilas,$fila[6]==0?"Sin detenido":"Con detenido");
	$libro->setValor("J".$numFilas,$fila[7]);
	$libro->setValor("K".$numFilas,$fila[8]);
	$libro->setValor("L".$numFilas,$fila[9]);
	$libro->setValor("M".$numFilas,$fila[10]);
	$libro->setValor("N".$numFilas,$fila[11]);
	
	$noIncompetencia++;
	$numFilas++;
}

$libro->cambiarHojaActiva(1);
$numFilas=4;
$noIncompetencia=1;

$consulta="select * from (SELECT c.carpetaAdministrativa,
(SELECT di.juzgado FROM _222_tablaDinamica di WHERE idReferencia=s.id__46_tablaDinamica LIMIT 0,1 ) AS juzgado,
(SELECT tipoAudiencia FROM _4_tablaDinamica WHERE id__4_tablaDinamica=s.tipoAudiencia) AS motivo,
c.fechaCreacion,
s.folioCarpetaInvestigacion,
 (SELECT COUNT(e.idRegistroEvento) FROM 7007_contenidosCarpetaAdministrativa co,7000_eventosAudiencia e,3014_registroMedidasCautelares r 
 WHERE co.carpetaAdministrativa=s.carpetaAdministrativa 
 AND tipoContenido=3 AND e.idRegistroEvento=co.idRegistroContenidoReferencia AND r.idEventoAudiencia=e.idRegistroEvento
 AND tipoMedida=14 LIMIT 0,1) AS conSinDetenido,

(
SELECT GROUP_CONCAT(CONCAT(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',
IF(apellidoMaterno IS NULL,'',apellidoMaterno))) FROM _47_tablaDinamica p,7005_relacionFigurasJuridicasSolicitud r
WHERE p.id__47_tablaDinamica=r.idParticipante AND r.idActividad=s.idActividad AND idFiguraJuridica=4

) AS imputados,
(
SELECT GROUP_CONCAT(CONCAT(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',
IF(apellidoMaterno IS NULL,'',apellidoMaterno))) FROM _47_tablaDinamica p,7005_relacionFigurasJuridicasSolicitud r
WHERE p.id__47_tablaDinamica=r.idParticipante AND r.idActividad=s.idActividad AND idFiguraJuridica=2

) AS victimas,
(
SELECT GROUP_CONCAT(CONCAT(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ',
IF(apellidoMaterno IS NULL,'',apellidoMaterno))) FROM _47_tablaDinamica p,7005_relacionFigurasJuridicasSolicitud r
WHERE p.id__47_tablaDinamica=r.idParticipante AND r.idActividad=s.idActividad AND idFiguraJuridica=1

) AS denunciantes,
(
	SELECT GROUP_CONCAT(de.denominacionDelito) FROM _35_denominacionDelito de,_61_tablaDinamica d WHERE 
	d.denominacionDelito=de.id__35_denominacionDelito AND d.idActividad=s.idActividad
) AS delitos
FROM _46_tablaDinamica s,7006_carpetasAdministrativas c WHERE c.carpetaAdministrativa=s.carpetaAdministrativa AND tipoAudiencia=24 AND idEstado>1.4 AND  c.fechaCreacion>='".$periodoInicial.
"' AND c.fechaCreacion<='".$periodoFinal." 23:59:59'
union

SELECT c.carpetaAdministrativa, 
juzgadoOrigen AS juzgado, 
(SELECT tipoAudiencia FROM _4_tablaDinamica WHERE id__4_tablaDinamica=s.tipoSolicitud) AS motivo, 
c.fechaCreacion, s.noExpediente AS folioCarpetaInvestigacion, 
imputadoPrivadoLibertad AS conSinDetenido, 
( SELECT GROUP_CONCAT(CONCAT(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ', 
IF(apellidoMaterno IS NULL,'',apellidoMaterno))) FROM _47_tablaDinamica p,7005_relacionFigurasJuridicasSolicitud r 
WHERE p.id__47_tablaDinamica=r.idParticipante AND r.idActividad=s.idActividad AND idFiguraJuridica=4 ) AS imputados, 
( SELECT GROUP_CONCAT(CONCAT(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ', 
IF(apellidoMaterno IS NULL,'',apellidoMaterno))) FROM _47_tablaDinamica p,7005_relacionFigurasJuridicasSolicitud r 
WHERE p.id__47_tablaDinamica=r.idParticipante AND r.idActividad=s.idActividad AND idFiguraJuridica=2 ) AS victimas, 
( SELECT GROUP_CONCAT(CONCAT(IF(nombre IS NULL,'',nombre),' ',IF(apellidoPaterno IS NULL,'',apellidoPaterno),' ', 
IF(apellidoMaterno IS NULL,'',apellidoMaterno))) FROM _47_tablaDinamica p,7005_relacionFigurasJuridicasSolicitud r 
WHERE p.id__47_tablaDinamica=r.idParticipante AND r.idActividad=s.idActividad AND idFiguraJuridica=1 ) AS denunciantes, 
( SELECT GROUP_CONCAT(de.denominacionDelito) FROM _35_denominacionDelito de,_61_tablaDinamica d WHERE 
d.denominacionDelito=de.id__35_denominacionDelito AND d.idActividad=s.idActividad ) AS delitos 
FROM _538_tablaDinamica s, 7006_carpetasAdministrativas c WHERE c.carpetaAdministrativa=s.carpetaAdministrativa AND
 tipoExpediente=2 AND idEstado>1.4 AND c.fechaCreacion>='".$periodoInicial."' AND 
c.fechaCreacion<='".$periodoFinal." 23:59:59') as tmp order by fechaCreacion

";
$res=$con->obtenerFilas($consulta);
while($fila=mysql_fetch_row($res))
{
	$libro->setValor("B".$numFilas,$noIncompetencia);
	$libro->setValor("C".$numFilas,$fila[0]);
	$libro->setValor("D".$numFilas,$fila[1]);
	$libro->setValor("E".$numFilas,$fila[2]);
	$libro->setValor("F".$numFilas,$fila[3]);
	$libro->setValor("G".$numFilas,$fila[4]);
	$libro->setValor("H".$numFilas,$fila[5]==0?"Sin detenido":"Con detenido");
	$libro->setValor("I".$numFilas,$fila[6]);
	$libro->setValor("J".$numFilas,$fila[7]);
	$libro->setValor("K".$numFilas,$fila[8]);
	$libro->setValor("L".$numFilas,$fila[9]);
	$libro->setValor("M".$numFilas,"");
	
	
	$noIncompetencia++;
	$numFilas++;
}
$libro->cambiarHojaActiva(0);
$libro->generarArchivo("Excel2007","informe.xlsx");

?>