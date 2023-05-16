<?php
	session_start();
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
				obtenerRegistrosGridDinamico();
			break;
			case 2:
				eliminarRegistro();
			break;
			case 3:
				resolverQuery();
			break;
		}
	}
	
	function obtenerRegistrosGridDinamico()
	{
		global $con;
		global $SO;
		$consulta="select * from (".bD($_POST["consulta"]).") as vQuery";

		$agrupacion=bD($_POST["agrupacion"]);
		$orden=$_POST["sort"];
		$direccion=$_POST["dir"];
		$posMin=$_POST["start"];
		$posMax=$_POST["limit"];
		$condExtra=$_POST["condExtra"];
		$filtroUsuario="";
		if(isset($_POST["filter"]))
		{
			$arrFiltro=$_POST["filter"];
			$ct=sizeof($arrFiltro);
			for($x=0;$x<$ct;$x++)
			{
				if($filtroUsuario=="")
					$filtroUsuario=$arrFiltro[$x]["field"]." like '%".$arrFiltro[$x]["data"]["value"]."%'";
				else
					$filtroUsuario.=" and ".$arrFiltro[$x]["field"]." like '%".$arrFiltro[$x]["data"]["value"]."%'";
			}
		}
		if($filtroUsuario!="")
			$consulta.=" where ".$filtroUsuario;
		if($condExtra!="")
		{
			$condExtra=bD($condExtra);
			if(strpos($consulta,"where")===false)
				$consulta.=" where ".$condExtra;
			else
				$consulta.=" and ".$condExtra;
		}

		$numElementos=$con->contarRegistros($consulta);

		$refOrden="";
		if($agrupacion!="")
			$refOrden=" order by ".$agrupacion.",".$orden." ".$direccion;
		
		if($orden!="")
		{
			if($refOrden=="")
				$refOrden= " order by ".$orden." ".$direccion;
			else
				$refOrden.= ", ".$orden." ".$direccion;
		}

		$consulta.=$refOrden." limit ".$posMin.",".$posMax;


		

		$datos=$con->obtenerFilasArreglo($consulta);


		$json= eregi_replace("[\n|\r|\n\r]", '',$con->obtenerFilasJson($consulta));
		if($SO==1)
		
		
			$arrJson='{"numReg":'.$numElementos.',registros:'.utf8_encode(($json)).'}';		
		else
			$arrJson='{"numReg":'.$numElementos.',registros:'.utf8_encode(nl2br($json)).'}';		
		echo $arrJson;
	}
	
	function eliminarRegistro()
	{
		global $con;
		$idRegistro=$_POST["id"];
		$idReferencia=$_POST["idReferencia"];
		$nTabla=bD($_POST["tb"]);	
		$campoID=bD($_POST["cId"]);
		$cad=bD($_POST["tblVal"]);
		$msgError=$_POST["msgError"];
		$obj;
		if($cad!="")
		{
			$obj=json_decode($cad);
			foreach($obj as $o)
			{
				$consulta="select count(*) from ".$o->tabla." where ".$o->campo."=".$idReferencia;

				$nReg=$con->obtenerValor($consulta); 
				if($nReg>0)
				{
					echo $msgError." esta siendo referida por otros registros y su eliminaci&oacute;n generar&iacute;a inconsistencias en la informaci&oacute;n";
					return;
				}
			}
		}
		$x=0;
		$query[$x]="begin";
		$x++;
		if(strpos($nTabla,"objTabla")===false)
		{
			$query[$x]="delete from ".$nTabla." where ".$campoID."=".$idRegistro;
			$x++;
		}
		else
		{
			$objTemp=json_decode($nTabla);
			foreach($objTemp->objTabla as $t)
			{
				$query[$x]="delete from ".$t->tabla." where ".$t->campo."=".$idRegistro;
				$x++;
			}
		}
		$query[$x]="commit";
		$x++;
		eB($query);
	}
	
	function resolverQuery()
	{
		global $con;
		$cadObj=$_POST["obj"];
		$func=$_POST["func"];
		$obj=json_decode($cadObj);
		$objNull=null;
		$res=resolverExpresionCalculoPHP($func,$obj,$objNull);
		echo "1|".$res;
		
			
	}
?>