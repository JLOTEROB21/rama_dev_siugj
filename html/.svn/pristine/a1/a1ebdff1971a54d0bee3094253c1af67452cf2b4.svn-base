<?php session_start();
	include("conexionBD.php"); 
	
	$parametros="";
	if(isset($_POST["funcion"]))
	{
		$funcion=$_POST["funcion"];
		if(isset($_POST["param"]))
		{
			$p=$_POST["param"];
			$parametros=json_decode($p,true);
			
		}
	}	
	
	switch($funcion)
	{
		case 1: 
			buscarAlumnosVentas();
		break;
		case 2: 
			obtenerVentasAlumno();
		break;
		case 3: 
			obtenerProductosVentas();
		break;
		case 4: 
			obtenerCostoConceptosVentas();
		break;
	}
	
	function buscarAlumnosVentas()
	{
		global $con;
		$criterio=$_POST["criterio"];
		$consulta="SELECT id__1069_tablaDinamica as idUsuario,nombre,apPaterno,apMaterno,CONCAT(apPaterno,' ',apMaterno,' ',nombre) as nombreCompleto 
					FROM _1069_tablaDinamica WHERE CONCAT(apPaterno,' ',apMaterno,' ',nombre) LIKE '%".cv($criterio)."%' ORDER BY apPaterno,apMaterno,nombre";
		
		$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrRegistros.'}';
		
	}
	
	function obtenerVentasAlumno()
	{
		global $con;
		$idUsuario=$_POST["idUsuario"];
		$tipoCliente=$_POST["tipoCliente"];
		$consulta="SELECT idVenta,folioVenta AS folio,fechaVenta as fechaVenta,total AS monto,formaPago,situacion,
					(SELECT GROUP_CONCAT(CONCAT(c.nombreConcepto,'<br>',p.descripcion))  FROM 6009_productosVentaCaja p,561_conceptosIngreso c 
					WHERE idVenta=v.idVenta AND c.idConcepto=p.idProducto ORDER BY c.nombreConcepto) as concepto
					 FROM 6008_ventasCaja v WHERE tipoCliente=".$tipoCliente." AND idCliente=".$idUsuario." order by fechaVenta desc";
		$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrRegistros.'}';
		
	}
	
	function obtenerProductosVentas()
	{
		global $con;
		$idVenta=$_POST["idVenta"];
		
		$aRegistro="";
		$consulta="SELECT * FROM 6009_productosVentaCaja WHERE idVenta=".$idVenta;
		$arrRegistros=$con->obtenerFilas($consulta);		
		while($fila=mysql_fetch_row($arrRegistros))
		{
			$consulta="SELECT nombreConcepto FROM 561_conceptosIngreso WHERE idConcepto=".$fila[2];
			$nConcepto=$con->obtenerValor($consulta);
			$oProducto='{"costoUnitarioConDescuento":"0","precioUnitarioOriginal":"'.$fila[17].'","tipoPrecio":"0","descuento":"'.$fila[15].
						'","numDevueltos":"0","sL":"1","idRegistro":"'.$fila[0].
						'","llave":"'.$fila[12].'","porcentajeIVA":"'.$fila[13].'","descripcion":"'.cv($fila[19]).'","cveProducto":"'.cv($fila[9]).
						'","concepto":"'.cv($nConcepto).'","costoUnitario":"'.$fila[5].'","cantidad":"'.$fila[4].'","subtotal":"'.$fila[6].'","iva":"'.$fila[7].
						'","total":"'.$fila[8].'","imagen":[],"tipoConcepto":"'.$fila[3].'","idProducto":"'.$fila[2].'","detalle":[],"tipoMovimiento":"'.
						$fila[11].'","dimensiones":"'.$fila[10].'","_parent":null,"_is_leaf":true}';
			if($aRegistro=="")						
				$aRegistro=$oProducto;
			else
				$aRegistro.=",".$oProducto;
				
		
		}
		
		$consulta="SELECT idCliente,situacion,idFactura FROM 6008_ventasCaja WHERE idVenta=".$idVenta;
		$fDVentas=$con->obtenerPrimeraFila($consulta);
		$idCliente=$fDVentas[0];
		$situacion=$fDVentas[1];
		$consulta="SELECT CONCAT(nombre,' ',apPaterno,' ',apMaterno) FROM _1069_tablaDinamica WHERE id__1069_tablaDinamica=".$idCliente;
		$nombreCliente=$con->obtenerValor($consulta);
		
		
		$idFactura="";
		if($fDVentas[2]!="")
		{
			$consulta="SELECT situacion FROM 703_relacionFoliosCFDI WHERE idFolio=".$fDVentas[2];
			$situacionFactura=$con->obtenerValor($consulta);
			
			if($situacionFactura==2)
				$idFactura=$fDVentas[2];
			
		}
		
		$cadObj='{"registros":['.$aRegistro.'],"idCliente":"'.$idCliente.'","nombreCliente":"'.$nombreCliente.'","situacion":"'.$situacion.'","idFactura":"'.$idFactura.'"}';
		
		echo "1|".$cadObj;
		
		
	}
	
	function obtenerCostoConceptosVentas()
	{
		global $con;
		
		$iA=$_POST["iA"];
		$iC=$_POST["iC"];
		$iM=$_POST["iM"];
		$c=$_POST["c"];
		$iP=$_POST["iP"];
		
		$aplicaDescuento=true;
		
		$fechaActual=date("Y-m-d");
		$diaSemana=date("w",strtotime($fechaActual));
		
		$consulta="SELECT fechaInicio FROM 4526_ciclosEscolares WHERE idCiclo=".$iC;
		$fInicio=$con->obtenerValor($consulta);
		$fInicio=date("Y",strtotime($fInicio));
		$fechaLimite=date($fInicio."-".str_pad($iM,2,"0",STR_PAD_LEFT)."-15");
		
		if(!(($diaSemana>0)&&($diaSemana<6)))
		{
			$aplicaDescuento=false;
		}
		
		$consulta="SELECT id__1069_tablaDinamica,apPaterno,apMaterno,nombre,curp,planEstudios,grados,grupo 
					FROM _1069_tablaDinamica WHERE id__1069_tablaDinamica=".$iA;
		
		$fila=$con->obtenerPrimeraFila($consulta);
		
		$consulta="SELECT i.idConcepto,i.nombreConcepto,porcentajeIVA,t.costoServicio FROM _1070_tablaDinamica c,_1071_tablaDinamica t,561_conceptosIngreso i WHERE t.idReferencia=c.id__1070_tablaDinamica 
					AND t.planEstudios=".$fila[5]." AND t.grado=".$fila[6]." AND i.idConcepto=c.conceptoIngreso and i.idConcepto=".$c;
		$fConcepto=$con->obtenerPrimeraFila($consulta);		

		
		$descuento=0;
		$total=0;
		$pocentajeDescuento=0;
		$descDescuento="";
		if($fConcepto[3]>0)
		{
			if($aplicaDescuento)
			{
				
				switch($fConcepto[0])
				{
					case 14:
					
						$consulta="SELECT porcentaje,tipoBeca FROM _1081_tablaDinamica WHERE alumno=".$iA." AND idEstado=2";
						$fBeca=$con->obtenerPrimeraFila($consulta);
						
						if($fBeca)
						{
							$pocentajeDescuento=$fBeca[0];
							$consulta="SELECT contenido FROM 902_opcionesFormulario WHERE idGrupoElemento=9497 AND valor=".$fBeca[1];
							$tipoBeca=$con->obtenerValor($consulta);
							$descDescuento="Descuento de ".number_format($fBeca[0],2)." % por tipo de beca: ".$tipoBeca;
						}
					break;
				}
				
				
				
			}
			
			
			$cobrable=1;
			$motivoNoCobro='';
			
			$consulta="SELECT p.idProductoVenta,folioVenta FROM 6009_productosVentaCaja p,6008_ventasCaja v WHERE v.tipoCliente=1 and 
						v.idCliente=".$fila[0]." AND v.situacion=1 and v.idVenta=p.idVenta AND idProducto=".$fConcepto[0];
			$rProductoVenta=$con->obtenerFilas($consulta);
			while($fProductoVenta=mysql_fetch_row($rProductoVenta))
			{
				$consulta="SELECT COUNT(*) FROM 6010_productosVentaMetaData WHERE idProductoVenta=".$fProductoVenta[0]." 
							AND ((campo='ciclo' AND valor='".$iC."')||(campo='mes' AND valor='".$iM."')||(campo='periodo' AND valor='".$iP."'))";
				$nCoincidencias=$con->obtenerValor($consulta);
				if($nCoincidencias==3)
				{
					$cobrable=0;
					$motivoNoCobro="El concepto ya ha sido cobrado previamente en la venta con folio: ".$fProductoVenta[1];
				}
				
			}
			
			
			$oC="['".$fConcepto[0]."','".cv($fConcepto[1])."','".$fConcepto[2]."','".$fConcepto[3]."',false,'','".$iC."','".$iP."','".$iM.
				"','".$pocentajeDescuento."','".cv($descDescuento)."',0,".$fConcepto[3].",1,'".$fechaLimite."',".$cobrable.",'".$motivoNoCobro."']";
			
			
			echo "1|[".$oC."]";
			
		}
		
		
		
	}
?>