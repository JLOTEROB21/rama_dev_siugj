<?php session_start();
	;
	include("funcionesFormularios.php"); 
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
				obtenerPedidoaPendientes();
			break;
			case 2:
				agendarSolicitud();
			break;
			case 3:
				obtenerPedidosRecibidosAlmacen();
			break;
			case 4:
				obtenerPedidosPendientesAlmacen();
			break;
		}
	}
	
	function obtenerPedidoaPendientes()
	{
		global $con;
		
		$idProv=$_POST["idProv"];
		
		//$condWhere="";
//		if(isset($_POST["filter"]))
//		{
//			$arrFiltro=$_POST["filter"];
//			$ct=sizeof($arrFiltro);
//			for($x=0;$x<$ct;$x++)
//			{
//				switch($arrFiltro[$x]["data"]["type"])
//				{
//					case 'string':
//						$condWhere.=" and ".$arrFiltro[$x]["field"]." like '".$arrFiltro[$x]["data"]["value"]."%'";
//					break;
//				}
//			}
//		}
		
		$consulta="SELECT idPedido,folioPedido,p.idAlmacen,nombreAlmacen,date_format(fechaRecepcion,'%d/%m/%Y') as fechaRecepcion,date_format(fechaAgenda,'%d/%m/%Y') as fechaAgenda,date_format(fechaSolicitada,'%d/%m/%Y') as fechaSolicitada FROM 9102_PedidoCabecera p, 9030_almacenes a WHERE idProveedor_ult=".$idProv." AND p.idAlmacen=a.idAlmacen AND status_pedido=1 ORDER BY  fechaRecepcion ASC";
		$res=$con->obtenerFilas($consulta);	
		$nreg=$con->filasAfectadas;
		
		$arrPedidos="";
		while($fila=mysql_fetch_row($res))
		{
			
			$obj='{"idPedido":"'.$fila[0].'","folioPedido":"'.$fila[1].'","idAlmacen":"'.$fila[2].'","nombreAlmacen":"'.$fila[3].'","fechaRecepcion":"'.$fila[4].'","fechaAgenda":"'.$fila[5].'","fechaSolicitada":"'.$fila[6].'"}';	
			if($arrPedidos=="")
				$arrPedidos=$obj;
			else
				$arrPedidos.=",".$obj;
		}
		$obj='{"numReg":"'.$nreg.'","registros":['.$arrPedidos.']}';
		echo $obj;
	}
	
	function agendarSolicitud()
	{
	
		global $con;
		
		$idPedido=$_POST["idPedido"];
		$fechaSolicitada=$_POST["fechaAgendada"];
		$horaInicio=$_POST["horaInicio"];
		$horaI=date('H:i:s',strtotime($horaInicio));
		$tiempoE=$_POST["tiempoE"];
		$horaFin=strtotime('+ '.$tiempoE.' minutes',strtotime($horaI));
		$horaF=date('H:i:s',$horaFin);
		$query="UPDATE 9102_PedidoCabecera SET fechaSolicitada='".$fechaAgendada."',horaInicio='".$horaI."',horaFin='".$horaF."' WHERE idPedido=".$idPedido;
		if($con->ejecutarConsulta($query))
			echo "1|";
		else
			echo "|";
	}
?>	