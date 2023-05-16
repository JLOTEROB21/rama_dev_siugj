<?php
	include_once("conexionBD.php");
	
	$consultaConectores="SELECT archivoInclude FROM 250_conectoresSistemaGestorDocumental";
	$resConector=$con->obtenerFilas($consultaConectores);
	
	while($filaConector=mysql_fetch_row($resConector))
	{
		include_once($filaConector[0]); 	
	}
	
	function generarInstanciaConectorGestor($idConexion)
	{
		global $con;
		$consulta="SELECT * FROM 251_conexionesSistemaGestorDocumental WHERE idConexion=".$idConexion;
		$fConexion=$con->obtenerPrimeraFilaAsoc($consulta);
		
		$consulta="SELECT nombreClase FROM 250_conectoresSistemaGestorDocumental WHERE idTipoConector=".$fConexion["tipoConector"];		
		$nClase=$con->obtenerValor($consulta);
		$conAux=NULL;
		
		eval('$conAux=new '.$nClase.'("'.$fConexion["urlServidor"].'","'.str_replace("\\","\\\\",$fConexion["usuarioServidor"]).'","'.str_replace("\\","\\\\",$fConexion["passwordServidor"]).'","'.$fConexion["raizServidor"].'",$fConexion);');
		return $conAux;
	}
	
	
	function generarInstanciaTipoConectorConectorGestor($tipoConector,$urlServidor,$usuarioServidor,$passwordServidor,$raizServidor,$datosComp=NULL)
	{
		global $con;
		$consulta="SELECT nombreClase FROM 250_conectoresSistemaGestorDocumental WHERE idTipoConector=".$tipoConector;		
		$nClase=$con->obtenerValor($consulta);
		$conAux=NULL;
		
		eval('$conAux=new '.$nClase.'("'.$urlServidor.'","'.$usuarioServidor.'","'.$passwordServidor.'","'.$raizServidor.'",$datosComp);');
		return $conAux;
	}
?>