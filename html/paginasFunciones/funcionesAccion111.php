<?php session_start();
	include("conexionBD.php"); 
	include("configurarIdioma.php");
	if(isset($_SESSION["leng"]))
	{
		if(isset($_POST["parametros"]))
			$parametros=$_POST["parametros"];
		if(isset($_POST["funcion"]))
			$funcion=$_POST["funcion"];
		$lenguaje=$_SESSION["leng"];
		
		switch($funcion)
		{
			case 1:
				obtenerClientes();
			break;
			case 2:
				obtenerAccionesCliente();
			break;
			case 3:
				obtenerClientesVolverLlamar();
			break;
			case 4:
				obtenerClientesSinCita();
			break;
			case 5:
				obtenerClientesEsperaPromotor();
			break;
			case 6:
				obtenerClientesEsperaResultadoCita();
			break;
		}
	}
	
	function obtenerClientes()
	{
		global $con;
		$limit=$_POST["limit"];
		$start=$_POST["start"];
		$idEstado=$_POST["idEstado"];
		$cadCondWhere="1=1";
		if(isset($_POST["filter"]))
			$cadCondWhere=generarCadenaConsultasFiltro($_POST["filter"]);
		$orden="apellidoPaterno,apellidoMaterno,nombres";
		if(isset($_POST["sort"]))
			$orden=$_POST["sort"]." ".$_POST["dir"];
		$consulta="select count(*) from _813_tablaDinamica c WHERE  idEstado=".$idEstado." and ".$cadCondWhere;
		$nReg=$con->obtenerValor($consulta);
		
		$consulta="SELECT id__813_tablaDinamica, apellidoPaterno, apellidoMaterno,nombres FROM _813_tablaDinamica c
						 WHERE idEstado=".$idEstado." and ".$cadCondWhere." order by  ".$orden." limit ".$start.",".$limit;
		$clientes='{"registros":'.utf8_encode($con->obtenerFilasJSON($consulta)).',"numReg":"'.$nReg.'"}';
		echo $clientes;
	}
	
	function obtenerAccionesCliente()
	{
		global $con;
		$limit=$_POST["limit"];
		$start=$_POST["start"];
		$idCliente=$_POST["idCliente"];
		$orden="";
		if(isset($_POST["sort"]))
			$orden=$_POST["sort"]." ".$_POST["dir"];
		$nReg=0;
		
		$consulta="SELECT  idAccionSeguimiento,idCliente,fecha,u.Nombre,idFormularioSeguimiento,idRegistroSeguimiento FROM 3000_registroSeguimientoClientes r,800_usuarios u WHERE u.idUsuario=r.responsable AND idCliente=".$idCliente." ORDER BY fecha desc";
		$resFilas=$con->obtenerFilas($consulta);
		$cadenaRegistros="";
		while($fila=mysql_fetch_row($resFilas))
		{
			$obj='{"idAccion":"'.$fila[0].'","accion":"","fechaAccion":"'.$fila[2].'","responsable":"'.$fila[3].'","comentarios":"","idFormulario":"'.$fila[4].'","idRegistro":"'.$fila[5].'"}';
			if($cadenaRegistros=="")
				$cadenaRegistros=$obj;
			else
				$cadenaRegistros.=",".$obj;
			$nReg++;
		}
		
		$cadenaRegistros='['.$cadenaRegistros.']';
		$acciones='{"registros":'.$cadenaRegistros.',"numReg":"'.$nReg.'"}';
		echo $acciones;
	}
	
	function obtenerClientesVolverLlamar()
	{
		global $con;
		$limit=$_POST["limit"];
		$start=$_POST["start"];
		$cadCondWhere="1=1";
		$idEstado=5;
		if(isset($_POST["filter"]))
			$cadCondWhere=generarCadenaConsultasFiltro($_POST["filter"]);
		$orden="apellidoPaterno,apellidoMaterno,nombres";
		if(isset($_POST["sort"]))
			$orden=$_POST["sort"]." ".$_POST["dir"];
		$consulta="select count(*) from _813_tablaDinamica c WHERE  idEstado=".$idEstado." and ".$cadCondWhere;
		$nReg=$con->obtenerValor($consulta);
		$consulta="select * from (SELECT id__813_tablaDinamica, apellidoPaterno, apellidoMaterno,nombres,(SELECT CONCAT(fechaVolverLlamada,' ',horaVolverLlamada) FROM _830_tablaDinamica WHERE idReferencia=c.id__813_tablaDinamica ORDER BY fechaVolverLlamada DESC,horaVolverLlamada desc LIMIT 0,1) as fechaLlamada FROM _813_tablaDinamica c
						 WHERE idEstado=".$idEstado." and ".$cadCondWhere.") as tmp order by  ".$orden." limit ".$start.",".$limit;
		$clientes='{"registros":'.utf8_encode($con->obtenerFilasJSON($consulta)).',"numReg":"'.$nReg.'"}';
		echo $clientes;
	}
	
	function obtenerClientesSinCita()
	{
		global $con;
		$limit=$_POST["limit"];
		$start=$_POST["start"];
		$idEstado='7,8';
		$cadCondWhere="1=1";
		if(isset($_POST["filter"]))
			$cadCondWhere=generarCadenaConsultasFiltro($_POST["filter"]);
		$orden="apellidoPaterno,apellidoMaterno,nombres";
		if(isset($_POST["sort"]))
			$orden=$_POST["sort"]." ".$_POST["dir"];
		$consulta="select count(*) from _813_tablaDinamica c WHERE  idEstado in (".$idEstado.") and ".$cadCondWhere;
		$nReg=$con->obtenerValor($consulta);
		
		$consulta="SELECT id__813_tablaDinamica, apellidoPaterno, apellidoMaterno,nombres,e.status FROM _813_tablaDinamica c,_821_tablaDinamica e
						 WHERE e.id__821_tablaDinamica=c.idEstado and c.idEstado in (".$idEstado.") and ".$cadCondWhere." order by  ".$orden." limit ".$start.",".$limit;
		$clientes='{"registros":'.utf8_encode($con->obtenerFilasJSON($consulta)).',"numReg":"'.$nReg.'"}';
		echo $clientes;
	}
	
	function obtenerClientesEsperaPromotor()
	{
		global $con;
		$limit=$_POST["limit"];
		$start=$_POST["start"];
		$cadCondWhere="1=1";
		$idEstado=$_POST["idEstado"];
		if(isset($_POST["filter"]))
			$cadCondWhere=generarCadenaConsultasFiltro($_POST["filter"]);
		$orden="apellidoPaterno,apellidoMaterno,nombres";
		if(isset($_POST["sort"]))
			$orden=$_POST["sort"]." ".$_POST["dir"];
		$consulta="select count(*) from _813_tablaDinamica c WHERE  idEstado=".$idEstado." and ".$cadCondWhere;
		$nReg=$con->obtenerValor($consulta);
		$consulta="select * from (SELECT id__813_tablaDinamica, apellidoPaterno, apellidoMaterno,nombres,
					(SELECT CONCAT(fechaCita,' ',horaCita) FROM _830_tablaDinamica WHERE idReferencia=c.id__813_tablaDinamica ORDER BY fechaCita DESC,horaCita desc LIMIT 0,1) as fechaCita 
					FROM _813_tablaDinamica c	 WHERE idEstado=".$idEstado." and ".$cadCondWhere.") as tmp order by  ".$orden." limit ".$start.",".$limit;
		$clientes='{"registros":'.utf8_encode($con->obtenerFilasJSON($consulta)).',"numReg":"'.$nReg.'"}';
		echo $clientes;
	}
	
	function obtenerClientesEsperaResultadoCita()
	{
		global $con;
		$limit=$_POST["limit"];
		$start=$_POST["start"];
		$cadCondWhere="1=1";
		$idEstado=9;
		if(isset($_POST["filter"]))
			$cadCondWhere=generarCadenaConsultasFiltro($_POST["filter"]);
		$orden="apellidoPaterno,apellidoMaterno,nombres";
		if(isset($_POST["sort"]))
			$orden=$_POST["sort"]." ".$_POST["dir"];
		$consulta="select count(*) from _813_tablaDinamica c WHERE  idEstado=".$idEstado." and ".$cadCondWhere;
		$nReg=$con->obtenerValor($consulta);
		$consulta="SELECT id__813_tablaDinamica, apellidoPaterno, apellidoMaterno,nombres,
				( SELECT fecha FROM 830_vistaCitas WHERE idReferencia=c.id__813_tablaDinamica ORDER BY fechaCita DESC,horaCita DESC LIMIT 0,1) as fechaCita,
		 			(SELECT Nombre FROM _833_tablaDinamica a,800_usuarios u WHERE u.idUsuario=a.agentes AND idReferencia=c.id__813_tablaDinamica order by id__833_tablaDinamica desc limit 0,1) as ejecutivo
					FROM _813_tablaDinamica c WHERE idEstado=".$idEstado." and ".$cadCondWhere." order by  ".$orden." limit ".$start.",".$limit;
		$clientes='{"registros":'.utf8_encode($con->obtenerFilasJSON($consulta)).',"numReg":"'.$nReg.'"}';
		echo $clientes;
	}
?>