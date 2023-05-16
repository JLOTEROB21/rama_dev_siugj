<?php session_start();
	include("conexionBD.php");
	ini_set("memory_limit","8000M");
	set_time_limit(999000);
	
	aperturarSesionUsuario(1);
	
	$fechaActual=date("Y-m-d H:i");
	$horaInicio=date("H:i",strtotime("-4 minutes",strtotime($fechaActual)));
	$horaFin=date("H:i",strtotime("+5 minutes",strtotime($fechaActual)));
	$dia=date("w");
	
	$consulta="SELECT r.* FROM _1214_tablaDinamica r,_1214_reporteDiaSemana d WHERE d.idReferencia=r.id__1214_tablaDinamica
				AND d.diaSemana=".$dia." AND horaReporte>='".$horaInicio."' AND horaReporte<='".$horaFin."' and r.idEstado=2";

	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_assoc($res))
	{
		
		$consulta="SELECT rolNotificacion FROM _1214_intervinienteNotificacion WHERE idReferencia=".$fila["id__1214_tablaDinamica"];
		$rRol=$con->obtenerFilas($consulta);
		while($filaRol=mysql_fetch_assoc($rRol))
		{
			$consulta="SELECT idUsuario FROM 807_usuariosVSRoles WHERE idRol=".$filaRol["rolNotificacion"];

			$resUsuario=$con->obtenerFilas($consulta);
			while($filaRol=mysql_fetch_assoc($resUsuario))
			{
				$arrDocumentos=array();
				$arrValores=array();
				$arrValores["tipoReporte"]=$fila["tipoReporte"];
				$arrValores["destinatarioReporte"]=$filaRol["idUsuario"];
				$arrValores["responsable"]=$filaRol["idUsuario"];
				$arrValores["detallesAdicionalesReporte"]="";
				
				$idRegistroInstancia=crearInstanciaRegistroFormulario(1212,-1,2,$arrValores,$arrDocumentos,-1,0);
			}
		}
	}
	
?>	