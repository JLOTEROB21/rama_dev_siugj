<?php
	function obtenerSalarioMinimo_SIUGJ($fecha)
	{
		global $con;
		$consulta="SELECT salarioMinimo FROM _1128_tablaDinamica WHERE fechaAplica<='".$fecha."' ORDER BY fechaAplica desc";
		$salarioMinimo=$con->obtenerValor($consulta);
		
		
		return $salarioMinimo;
	}
?>