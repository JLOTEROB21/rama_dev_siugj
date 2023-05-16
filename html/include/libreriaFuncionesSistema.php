<?php
	function reemplazarCadena($cadenaBuscada,$cadenaReemplazo,$cadenaFuente,$utilizarComillas)
	{
		if($utilizarComillas==1)
			return str_replace($cadenaBuscada,'"'.$cadenaReemplazo.'"',$cadenaFuente);	
		else
			return str_replace($cadenaBuscada,$cadenaReemplazo,$cadenaFuente);	
	}
	
	function obtenerParteFecha($fecha,$formato)
	{
		return date($formato,strtotime($fecha));
	}
	
	function obtenerComentariosCambioEtapa($idFormulario,$idRegistro,$etapa)
	{
		global $con;
		$consulta="SELECT comentarios FROM 941_bitacoraEtapasFormularios WHERE idFormulario=".$idFormulario." AND idRegistro=".$idRegistro." AND etapaActual=".$etapa." ORDER BY fechaCambio DESC";
		$comentarios=$con->obtenerValor($consulta);
		return "'".cv($comentarios)."'";
	
	}
?>