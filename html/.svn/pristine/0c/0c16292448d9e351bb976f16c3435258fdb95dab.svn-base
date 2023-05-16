<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");

	$fechaActual=date("Y-m-d")	;
	$horaActual=date("H:i");
	
	$idFormulario=bD($_GET["iF"]);
	$idRegistro=bD($_GET["iR"]);
	$idReferencia=($_GET["iRef"]);
	
	
		
	$consulta="SELECT idExpediente FROM _482_tablaDinamica WHERE id__482_tablaDinamica=".$idRegistro;
	$idExpediente=$con->obtenerValor($consulta);
	
	$consulta="SELECT idActividad FROM 7006_carpetasAdministrativas WHERE idCarpeta=".$idExpediente;
	$idActividad=$con->obtenerValor($consulta);
	
	$consulta="SELECT GROUP_CONCAT(CONCAT(IF(p.nombre IS NULL,'',p.nombre),' ',IF(p.apellidoPaterno IS NULL,'',p.apellidoPaterno),' ',IF(p.apellidoMaterno IS NULL,'',p.apellidoMaterno))) AS actores 
				FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica p 
				WHERE r.idActividad=".$idActividad." AND r.idFiguraJuridica=2 AND  
				p.id__47_tablaDinamica=r.idParticipante ORDER BY p.nombre,p.apellidoPaterno,p.apellidoMaterno";
	$listaDemandados=$con->obtenerListaValores($consulta);
	
	$consulta="SELECT GROUP_CONCAT(CONCAT(IF(p.nombre IS NULL,'',p.nombre),' ',IF(p.apellidoPaterno IS NULL,'',p.apellidoPaterno),' ',IF(p.apellidoMaterno IS NULL,'',p.apellidoMaterno))) AS actores 
				FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica p 
				WHERE r.idActividad=".$idActividad." AND r.idFiguraJuridica=4 AND  
				p.id__47_tablaDinamica=r.idParticipante ORDER BY p.nombre,p.apellidoPaterno,p.apellidoMaterno";
	$listaActores=$con->obtenerListaValores($consulta);
		
		
		
		
?>	
var listaDemandados='<?php echo $listaDemandados?>';
var listaActores='<?php echo $listaActores?>';

function inyeccionCodigo()
{
	<?php 
		if($tipoMateria=="F")
		{
	?>
	gE('sp_7668').innerHTML=listaActores;
    gE('sp_7669').innerHTML=listaDemandados;
	<?php
		}
		else
		{
	?>
	gE('sp_7671').innerHTML=listaActores;
    gE('sp_7672').innerHTML=listaDemandados;
	<?php	
		}
	?>
}	
