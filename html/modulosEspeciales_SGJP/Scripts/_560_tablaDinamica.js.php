<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");

	$fechaActual=date("Y-m-d")	;
	$horaActual=date("H:i");
	
	$idFormulario=bD($_GET["iF"]);
	$idRegistro=bD($_GET["iR"]);
	$idReferencia=($_GET["iRef"]);
	
	
		
	$consulta="SELECT idExpediente FROM _560_tablaDinamica WHERE id__560_tablaDinamica=".$idRegistro;
	$idExpediente=$con->obtenerValor($consulta);
	
	$consulta="SELECT idActividad FROM 7006_carpetasAdministrativas WHERE idCarpeta=".$idExpediente;
	$idActividad=$con->obtenerValor($consulta);
	
	$consulta="SELECT GROUP_CONCAT(CONCAT(IF(p.nombre IS NULL,'',p.nombre),' ',IF(p.apellidoPaterno IS NULL,'',p.apellidoPaterno),' ',IF(p.apellidoMaterno IS NULL,'',p.apellidoMaterno))) AS actores 
				FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica p 
				WHERE r.idActividad=".$idActividad." AND r.idFiguraJuridica=2 AND  
				p.id__47_tablaDinamica=r.idParticipante ORDER BY p.nombre,p.apellidoPaterno,p.apellidoMaterno";
	$listaImputados=$con->obtenerListaValores($consulta);
	
	$consulta="SELECT GROUP_CONCAT(CONCAT(IF(p.nombre IS NULL,'',p.nombre),' ',IF(p.apellidoPaterno IS NULL,'',p.apellidoPaterno),' ',IF(p.apellidoMaterno IS NULL,'',p.apellidoMaterno))) AS actores 
				FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica p 
				WHERE r.idActividad=".$idActividad." AND r.idFiguraJuridica=4 AND  
				p.id__47_tablaDinamica=r.idParticipante ORDER BY p.nombre,p.apellidoPaterno,p.apellidoMaterno";
	$listaVictimas=$con->obtenerListaValores($consulta);
		
		
		
		
?>	
var listaImputados='<?php echo $listaImputados?>';
var listaVictimas='<?php echo $listaVictimas?>';

function inyeccionCodigo()
{
	
	gE('sp_9067').innerHTML=listaImputados;
    gE('sp_9068').innerHTML=listaVictimas;
	
}	
