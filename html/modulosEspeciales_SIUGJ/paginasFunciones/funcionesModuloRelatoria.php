<?php session_start();
	include_once("conexionBD.php");
	include_once("utiles.php");
	include_once("SIUGJ/libreriaFuncionesIntegraciones.php");


	
	if(isset($_POST["parametros"]))
		$parametros=$_POST["parametros"];
	if(isset($_POST["funcion"]))
		$funcion=$_POST["funcion"];
	$lenguaje=$_SESSION["leng"];
	
	switch($funcion)
	{
		case 1:
			obtenerSeccionesRelatoria();
		break;
		case 2:
			guardarValorSeccion();
		break;
		case 3:
			obtenerEtiquetasDocumento();
		break;
		case 4:
			buscarEtiquetasDocumento();
		break;
		case 5:
			removerEtiquetasDocumento();
		break;
		case 6:
			registrarEtiquetaDocumento();
		break;		
	}
	




	function obtenerSeccionesRelatoria()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idDocumento=$_POST["idDocumento"];
		$idRegistro=$_POST["idRegistro"];
		
		$arrSecciones="";
		$consulta="SELECT claveElemento,nombreElemento,datosComplementarios FROM 1018_catalogoVarios WHERE tipoElemento=41 ORDER BY idElementoCatalogo";
		
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_assoc($res))
		{
			
			$consulta="SELECT valorSeccion FROM _1137_seccionesRelatoria WHERE idFormulario=".$idFormulario." AND idReferencia=".$idRegistro." AND idSeccion=".$fila["claveElemento"];
			$valorSeccion=$con->obtenerValor($consulta);
			
			$icono="bullet_red2.png";
			if($valorSeccion!="")
			{
				$icono="bullet-green.png";
			}
			
			$o='{"expanded":true,"icon":"../images/'.$icono.'","id":"s_'.$fila["claveElemento"].'","text":"'.cv($fila["nombreElemento"]).'","leaf":true,"valorSeccion":"'.bE($valorSeccion).
				'","datosComplementarios":"'.bE($fila["datosComplementarios"]).'","cls":"cssNodoSeccionRelatoria"}';
			if($arrSecciones=="")
				$arrSecciones=$o;
			else
				$arrSecciones.=",".$o;
		}
		
		
		
		echo '['.$arrSecciones.']';
	}
	
	
	function guardarValorSeccion()
	{
		global $con;
		
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		$consulta="SELECT idRegistroRelatoria FROM _1137_seccionesRelatoria WHERE idFormulario=".$obj->idFormulario." AND idReferencia=".$obj->idReferencia." AND idSeccion=".$obj->idSeccion;
		$idRegistroRelatoria=$con->obtenerValor($consulta);
		if($idRegistroRelatoria=="")
		{
			$consulta="INSERT INTO _1137_seccionesRelatoria(idFormulario,idReferencia,idSeccion,valorSeccion) VALUES(".$obj->idFormulario.",".
						$obj->idReferencia.",".$obj->idSeccion.",'".cv($obj->valorSeccion)."')";
		}
		else
		{
			$consulta="update _1137_seccionesRelatoria set valorSeccion='".cv($obj->valorSeccion)."' where idRegistroRelatoria=".$idRegistroRelatoria;
		}
		
		eC($consulta);
	}
	
	function obtenerEtiquetasDocumento()
	{
		global $con;
		$idDocumento=$_POST["idDocumento"];
		
		
		$consulta="SELECT idRegistro,idEtiqueta,lblEtiqueta FROM 908_etiquetadoDocumentos WHERE idArchivo ORDER BY lblEtiqueta";
		$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrRegistros.'}';
		
	}
	
	function buscarEtiquetasDocumento()
	{
		global $con;
		$criterio=$_POST["criterio"];
		
		echo buscarInformacionEtiquetado($criterio);
		
	}
	
	
	function removerEtiquetasDocumento()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		
		$consulta="delete FROM 908_etiquetadoDocumentos WHERE idRegistro=".$obj->iRegistro;
		if($con->ejecutarConsulta($consulta))
		{
			$consulta="SELECT COUNT(*) FROM 908_etiquetadoDocumentos WHERE idArchivo=".$obj->idArchivo;
			$numRegistro=$con->obtenerValor($consulta);
			if($numRegistro==0)
			{
				$consulta="delete FROM _1137_seccionesRelatoria WHERE idFormulario=".$obj->idFormulario." AND idReferencia=".$obj->idReferencia." AND idSeccion=".$obj->idSeccion;
				eC($consulta);
				return;
			}
			echo "1|";
		}
		
	}
	
	function registrarEtiquetaDocumento()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		$consulta="SELECT COUNT(*) FROM 908_etiquetadoDocumentos WHERE idArchivo=".$obj->idArchivo." AND idEtiqueta=".$obj->idEtiqueta;
		$numRegistro=$con->obtenerValor($consulta);
		if($numRegistro==0)
		{
			
			$consulta="INSERT INTO 908_etiquetadoDocumentos(idArchivo,idEtiqueta,lblEtiqueta) VALUES(".$obj->idArchivo.",".$obj->idEtiqueta.",'".cv($obj->lblEtiqueta)."')";
		
			if($con->ejecutarConsulta($consulta))
			{
				
				$consulta="SELECT COUNT(*) FROM _1137_seccionesRelatoria WHERE idFormulario=".$obj->idFormulario." AND idReferencia=".$obj->idReferencia." AND idSeccion=".$obj->idSeccion;
				$numRegistro=$con->obtenerValor($consulta);
				if($numRegistro==0)
				{
				
					$consulta="INSERT INTO _1137_seccionesRelatoria(idFormulario,idReferencia,idSeccion,valorSeccion) values(".$obj->idFormulario.",".$obj->idReferencia.",".$obj->idSeccion.",1)";
					eC($consulta);
					return;
				}
				
			}
			echo "1|";
			return;
		}
		
		echo "1|";
	}
	
?>