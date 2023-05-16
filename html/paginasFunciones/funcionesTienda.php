<?php session_start();
	;
	include("funcionesFormularios.php"); 
	include("configurarIdioma.php");
	include_once("libreriasFunciones/cPagoReferenciado.php");
	include_once("cAlmacen.php");
	include_once("funcionesPortal.php");
	
	if(isset($_POST["funcion"]))
		$funcion=$_POST["funcion"];
	
	switch($funcion)
	{
		case 1:
			agregarProductoCarrito();
		break;
		case 2:
			obtenerTotalProductosCarrito();
		break;
		case 3:
			obtenerProductosCarrito();
		break;
		case 4:
			removerProductoCarrito();
		break;
		case 5:
			actualizarProductoCarrito();
		break;
		case 6:
			obtenerTotalPedidosActivos();
		break;
		case 7:
			generarPedidoCarrito();
		break;
		case 8:
			obtenerPedidosActivos();
		break;
	}
		
	function agregarProductoCarrito()
	{
		$idProducto=$_POST["idProducto"]	;
		$cantidad=$_POST["cantidad"]	;
		$precio=$_POST["precio"];
		
		if(!isset($_SESSION["carrito"]))
		{
			$_SESSION["carrito"]=array();
		}
		if(isset($_SESSION["carrito"][$idProducto]))
			$_SESSION["carrito"][$idProducto]["cantida"]+=$cantidad;
		else
			$_SESSION["carrito"][$idProducto]["cantida"]=$cantidad;
		$_SESSION["carrito"][$idProducto]["costoUnitario"]=$precio;
		$_SESSION["carrito"][$idProducto]["total"]=($_SESSION["carrito"][$idProducto]["cantida"]*$_SESSION["carrito"][$idProducto]["costoUnitario"]);
		echo "1|";
		
	}
	
	function obtenerProductosCarrito()
	{
		global $con;
		$arrProductos="";
		$numReg=0;
		
		if(isset($_SESSION["carrito"]))
		{
			foreach($_SESSION["carrito"] as $idProducto=>$resto)
			{
				$consulta="select cveProducto,nombreProducto FROM 6901_catalogoProductos WHERE idProducto=".$idProducto;
				$fProducto=$con->obtenerPrimeraFila($consulta);
				$p='{"idProducto":"'.$idProducto.'","nombreProducto":"['.cv($fProducto[0]).'] '.cv($fProducto[1]).'","costoUnitario":"'.$resto["costoUnitario"].'","cantidad":"'.$resto["cantida"].'","total":"'.$resto["total"].'"}';
				if($arrProductos=="")
					$arrProductos=$p;
				else
					$arrProductos.=",".$p;
				$numReg++;
			}
		}
		
		echo '{"numReg":"'.$numReg.'","registros":['.($arrProductos).']}';
		
	}
	
	function actualizarProductoCarrito()
	{
		$idProducto=$_POST["idProducto"];
		$cantidad=$_POST["cantidad"];
		$_SESSION["carrito"][$idProducto]["cantida"]=$cantidad;
		$_SESSION["carrito"][$idProducto]["total"]=($_SESSION["carrito"][$idProducto]["cantida"]*$_SESSION["carrito"][$idProducto]["costoUnitario"]);
		echo "1|";
	}
	
	function removerProductoCarrito()
	{
		$idProducto=$_POST["idProducto"];
		unset($_SESSION["carrito"][$idProducto]);
		echo "1|";
	}
	
	function generarPedidoCarrito()
	{
		global $con;
		
		if(!esUsuarioLog())
		{
			echo "2|";	
		}

		
		$x=0;
		$llavePedido=rand(0,1000)."_".date("Y_m_d_H_i_s");
		$query[$x]="begin";
		$x++;
		if(isset($_SESSION["carrito"]))
		{
			$consulta="INSERT INTO 6934_pedidosTienda(fechaCreacion,idUsuarioPedido,situacion)
						VALUES('".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",1)";
			if(!$con->ejecutarConsulta($consulta))
				return;
			$idPedido=$con->obtenerUltimoID();
			$query[$x]="set @idPedido:=".$idPedido;
			$x++;
			$subTotal=0;
			$iva=0;
			$total=0;
			foreach($_SESSION["carrito"] as $idProducto=>$resto)
			{
				$subTotal+=$resto["total"];
				$iva+=0;
				$total+=$resto["total"];
				$query[$x]="INSERT INTO 6935_productosPedidoTienda(idPedido,idProducto,cantidad,precioUnitario,subtotal,iva,total)
							VALUES(@idPedido,".$idProducto.",".$resto["cantida"].",".$resto["costoUnitario"].",".$resto["total"].",0,".$resto["total"].")";
				$x++;
				
				$consulta="SELECT idAlmacen FROM 6901_catalogoProductos WHERE idProducto=".$idProducto;
				$idAlmacen=$con->obtenerValor($consulta);
				
				$c=new cAlmacen($idAlmacen);
				
				$objAsiento='{
								"tipoMovimiento":"28",
								"cantidadOperacion":"",
								"idProducto":"",
								"tipoReferencia":"4",
								"datoReferencia1":"'.$llavePedido.'"
							}';
							
				$arrMovimientos=array();
				
				$oProducto=json_decode($objAsiento);
				$oProducto->cantidadOperacion=$resto["cantida"];
				$oProducto->idProducto=$idProducto;
				array_push($arrMovimientos,$oProducto);
					
				$c->asentarArregloMovimientos($arrMovimientos,$query,$x,true);
				
			}
			$arrDimensionesReferencia=array();
			$objDatos["plantel"]='';
			$objDatos["idConcepto"]=$idPedido;
			$objDatos["idUsuario"]=$_SESSION["idUsr"];
			$arrFechasPago=array();
			$obj=array();
			$obj["monto"]=$total;
			$obj["fechaInicio"]=date("Y-m-d");
			$obj["fechaFin"]="";
			array_push($arrFechasPago,$obj);
			$idPagoReferenciado=generarReferenciaPago($objDatos,$arrFechasPago,$arrDimensionesReferencia,"pagoPedidoVentaTiendaVirtual",0,"","NULL",true);
			
			$consulta="SELECT idReferencia FROM 6011_movimientosPago WHERE  idMovimiento=".$idPagoReferenciado;
			$idPagoReferenciado=$con->obtenerValor($consulta);
			$query[$x]="update 6934_pedidosTienda set subtotal=".$subTotal.",iva=".$iva.",montoTotal=".$total.",idPagoReferenciado=".$idPagoReferenciado." where idPedidoTienda=@idPedido";
			$x++;
			$query[$x]="update 6920_movimientosAlmacen SET datoReferencia1=@idPedido WHERE datoReferencia1='".$llavePedido."' and tipoReferencia=4";
			$x++;
		
		}
		$query[$x]="commit";
		$x++;
		if($con->ejecutarBloque($query))
		{
			$_SESSION["carrito"]=array();
			unset($_SESSION["carrito"]);
			echo "1|".$idPedido;	
		}
		
	}
	
	function obtenerTotalProductosCarrito()
	{
		$total=0;
		if(isset($_SESSION["carrito"]))
		{
			foreach($_SESSION["carrito"] as $idProducto=>$resto)
			{
				$total+=$resto["cantida"];
			}
		}
		echo "1|".$total;
	}
	
	function obtenerTotalPedidosActivos()
	{
		global $con;
		$total=0;
		if(isset($_SESSION["idUsr"]))
		{
			$consulta="SELECT COUNT(*) FROM 6934_pedidosTienda WHERE idUsuarioPedido=".$_SESSION["idUsr"]." AND situacion=1";
			$total=$con->obtenerValor($consulta);
		}
		echo "1|".$total;
	}
	
	function obtenerPedidosActivos()
	{
		global $con;	
		$numReg=0;
		$arrPedidos="";
		$idUsuario=-1;
		if(isset($_SESSION["idUsr"]))
		{
			$idUsuario=$_SESSION["idUsr"];
		}
		if($idUsuario=="")
			$idUsuario=-1;
		$consulta="SELECT  idPedidoTienda,idPagoReferenciado,fechaCreacion,montoTotal FROM 6934_pedidosTienda WHERE idUsuarioPedido=".$idUsuario." AND situacion=1";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$descripcion="<table>";
			$descripcion.="<tr>";
			$descripcion.="<td width='250' align='center'><span class='corpo8_bold'>Producto</span></td><td width='120' align='center'><span class='corpo8_bold'>Precio Unitario</span></td><td width='120' align='center'><span class='corpo8_bold'>Cantidad</span></td><td width='120' align='center'><span class='corpo8_bold'>Total</span></td>";
			$descripcion.="</tr>";
			$descripcion.="<tr style='height:1px'>";
			$descripcion.="<td colspan='4' align='center' style='background-color:#900'></td>";
			$descripcion.="</tr>";
			
			$consulta="SELECT CONCAT('[',cveProducto,'] ', nombreProducto),precioUnitario,cantidad,total FROM 6935_productosPedidoTienda t,6901_catalogoProductos p WHERE idPedido=".$fila[0]."
				AND p.idProducto=t.idProducto";
			$resP=$con->obtenerFilas($consulta);
			while($filaP=mysql_fetch_row($resP))
			{
				$descripcion.="<tr><td>".cv($filaP[0])."</td><td>$ ".number_format($filaP[1],2)."</td><td>".$filaP[2]."</td><td>$ ".number_format($filaP[3],2)."</td></tr>";
			}
			
			$descripcion.="</table>";
			$o='{"idPedido":"'.$fila[0].'","idReferencia":"'.$fila[1].'","fechaPedido":"'.date("Y-m-d H:i:s").'","montoTotal":"'.$fila[3].'","descripcion":"'.$descripcion.'"}';
			if($arrPedidos=="")
				$arrPedidos=$o;
			else
				$arrPedidos.=",".$o;
			$numReg++;
		}
		echo '{"numReg":"'.$numReg.'","registros":['.($arrPedidos).']}';
	}
?>