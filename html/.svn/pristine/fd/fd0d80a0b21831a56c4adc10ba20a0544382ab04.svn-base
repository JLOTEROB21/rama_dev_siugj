<?php session_start();
	include_once("conexionBD.php");
	include_once("SIUGJ/libreriaFuncionesIntegraciones.php");
	aperturarSesionUsuario(2);
	
	$x=0;
	$query[$x]="begin";
	$x++;
	
	$fechaActual=date("Y-m-d H:i:s");
	$consulta="SELECT * FROM 801_adscripcion WHERE institucionAbierto IS NOT NULL AND institucionAbierto<>''";
	
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchAssoc($res))
	{
		$consulta="SELECT noIdentificacion FROM 802_identifica WHERE idUsuario=".$fila["idUsuario"]." AND tipoIdentificacion=4";
		$noIdentificacion=$con->obtenerValor($consulta);
		if($noIdentificacion!="")
		{
			$resultado=buscarInformacionEFinomina($noIdentificacion);
			if($resultado["Respuesta"]==1)
			{
				if($resultado["ultimaDependencia"]=="")
				{
					$resultado["ultimaDependencia"]=$fila["institucionAbierto"];
				}
				
				if($resultado["ultimoCargo"]=="")
				{
					$resultado["ultimoCargo"]=$fila["puestoAbierto"];
				}
				$resultado["estatusActualNomina"]=mb_strtoupper($resultado["estatusActualNomina"]);
				$query[$x]="UPDATE 801_adscripcion SET institucionAbierto='".cv($resultado["ultimaDependencia"])."',puestoAbierto='".cv($resultado["ultimoCargo"]).
							"',statusNomina='".cv($resultado["estatusActualNomina"])."' WHERE idUsuario=".$fila["idUsuario"];
				$x++;
				$con->ejecutarConsulta($consulta);
				if($resultado["estatusActualNomina"]=="")
				{
					$query[$x]="UPDATE 800_usuarios SET cuentaActiva=0 WHERE idUsuario=".$fila["idUsuario"];
					$x++;
				}
				
				
			}
		}
	}
	
	
	$query[$x]="commit";
	$x++;
	$con->ejecutarBloque($query);
?>