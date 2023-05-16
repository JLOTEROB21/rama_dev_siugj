<?php session_start();
	;
	include_once("conexionBD.php"); 	
	$consulta="SELECT archivoInclude FROM 250_conectoresSistema";
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))
	{
		include_once($fila[0]); 	
	}
	
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
				validarConexion();
			break;
			case 2:
				obtenerNombreFuncion();
			break;
			case 3:
				actualizarDatosSesion();
			break;
			case 4:
				obtenerVerificacionRequerimientosSistema();
			break;
			case 5:
				registrarInformacionConectorServiciosNube();
			break;
			case 6:
				obtenerPolicitasEventosBitacora();
			break;
			case 7:
				monitorerComponentesSistema();
			break;
			case 8:
				buscarExistenciaRegistro();
			break;
		}
	}
	
	function validarConexion()
	{
		global $con;

		$cadObj=bD($_POST["cadObj"]);
		$obj=json_decode($cadObj);
		
		$consulta="SELECT nombreClase FROM 250_conectoresSistema WHERE idTipoConector=".$obj->t;		
		$nClase=$con->obtenerValor($consulta);
		$conAux=NULL;
		eval('$conAux=new '.$nClase.'("'.$obj->h.'","'.$obj->p.'","'.$obj->u.'","'.$obj->pw.'","'.$obj->b.'");');

		if($conAux->conexion)
			echo "1|1";
		else
		{
		
			echo "1|0";
		}
	}
	
	function obtenerNombreFuncion()
	{
		global $con;
		$idFuncion=$_POST["idFuncion"];
		$consulta="SELECT nombreConsulta FROM 991_consultasSql WHERE idConsulta=".$idFuncion;
		$nFuncion=$con->obtenerValor($consulta);
		echo "1|".$nFuncion;
	}
	
	function actualizarDatosSesion()
	{
		$nSesion=$_POST["nS"];
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		$reflectionClase = new ReflectionObject($obj);
		
		foreach ($reflectionClase->getProperties() as $property => $value) 
		{
			$nombre=$value->getName();
			$valor=$value->getValue($obj);
			
			cambiarValorObjParametros($nSesion,$nombre,$valor);	
			
		}
		echo "1|";
		
		
	}
	
	
	function obtenerVerificacionRequerimientosSistema()
	{
		global $con;
		
		$aRegistros="";
		
		$numReg=0;
		$arrRegistros=array();
		
		$o=array();
		
		$o[0]='1';
		$o[1]='Verificando instalación de módulo Bcmath';
		array_push($arrRegistros,$o);
		$o[0]='2';
		$o[1]='Verificando instalación de módulo bz2';
		array_push($arrRegistros,$o);
		$o[0]='3';
		$o[1]='Verificando instalación de módulo calendar';
		array_push($arrRegistros,$o);
		$o[0]='4';
		$o[1]='Verificando instalación de módulo Core ';
		array_push($arrRegistros,$o);
		$o[0]='5';
		$o[1]='Verificando instalación de módulo ctype ';
		array_push($arrRegistros,$o);
		$o[0]='6';
		$o[1]='Verificando instalación de módulo curl ';
		array_push($arrRegistros,$o);
		$o[0]='7';
		$o[1]='Verificando instalación de módulo dom ';
		array_push($arrRegistros,$o);
		$o[0]='8';
		$o[1]='Verificando instalación de módulo exif ';
		array_push($arrRegistros,$o);
		$o[0]='9';
		$o[1]='Verificando instalación de módulo ffmpeg ';
		array_push($arrRegistros,$o);
		$o[0]='10';
		$o[1]='Verificando instalación de módulo filter ';
		array_push($arrRegistros,$o);
		$o[0]='11';
		$o[1]='Verificando instalación de módulo ftp ';
		array_push($arrRegistros,$o);
		$o[0]='12';
		$o[1]='Verificando instalación de módulo gd ';
		array_push($arrRegistros,$o);
		$o[0]='13';
		$o[1]='Verificando instalación de módulo iconv ';
		array_push($arrRegistros,$o);
		$o[0]='14';
		$o[1]='Verificando instalación de módulo imagick ';
		array_push($arrRegistros,$o);
		$o[0]='15';
		$o[1]='Verificando instalación de módulo imap ';
		array_push($arrRegistros,$o);
		$o[0]='16';
		$o[1]='Verificando instalación de módulo json ';
		array_push($arrRegistros,$o);
		$o[0]='17';
		$o[1]='Verificando instalación de módulo ldap ';
		array_push($arrRegistros,$o);
		$o[0]='18';
		$o[1]='Verificando instalación de módulo libxml ';
		array_push($arrRegistros,$o);
		$o[0]='19';
		$o[1]='Verificando instalación de módulo magickwand ';
		array_push($arrRegistros,$o);
		$o[0]='20';
		$o[1]='Verificando instalación de módulo mbstring ';
		array_push($arrRegistros,$o);
		$o[0]='21';
		$o[1]='Verificando instalación de módulo mcrypt ';
		array_push($arrRegistros,$o);
		$o[0]='22';
		$o[1]='Verificando instalación de módulo mysql ';
		array_push($arrRegistros,$o);
		$o[0]='23';
		$o[1]='Verificando instalación de módulo openssl ';
		array_push($arrRegistros,$o);
		$o[0]='24';
		$o[1]='Verificando instalación de módulo SimpleXML ';
		array_push($arrRegistros,$o);
		$o[0]='25';
		$o[1]='Verificando instalación de módulo Soap ';
		array_push($arrRegistros,$o);
		$o[0]='26';
		$o[1]='Verificando instalación de módulo Xml ';
		array_push($arrRegistros,$o);
		$o[0]='27';
		$o[1]='Verificando instalación de módulo Xmlreader ';
		array_push($arrRegistros,$o);
		$o[0]='28';
		$o[1]='Verificando instalación de módulo Zend Guard Loader ';
		array_push($arrRegistros,$o);
		$o[0]='29';
		$o[1]='Verificando instalación de módulo Zip ';
		array_push($arrRegistros,$o);
		$o[0]='30';
		$o[1]='Verificando instalación de módulo Zlib ';
		array_push($arrRegistros,$o);
		$o[0]=31;
		$o[1]="Verificando conexi&oacute;n con SMDB";
		array_push($arrRegistros,$o);
		$o[0]=32;
		$o[1]="Verificando existencia de BD (MAJO_DB)";
		array_push($arrRegistros,$o);
		
		
		
		foreach($arrRegistros as $o)
		{
			$r='{"idRequerimiento":"'.$o[0].'","lblRequerimiento":"'.$o[1].'","situacion":"1","mensaje":"OK"}';
			if($aRegistros=="")
				$aRegistros=$r;
			else
				$aRegistros.=",".$r;
		}
		
		echo '{numReg:"'.$numReg.'",registros:['.$aRegistros.']}';
		
		
	}
	
	
	function registrarInformacionConectorServiciosNube()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$_SESSION["conectorServicioNube"]=$obj;
		echo "1|";
	}
	
	function obtenerPolicitasEventosBitacora()
	{
		global $con;
		
		$consulta="SELECT idTipoRegistro as idRegistroBitacora,nombreTipoRegistro as descripcionBitacora,tipoComponente,
					(SELECT valor FROM 00021_tiposRegistroBitacoraAcceso WHERE idRegistroBitacora=t.idTipoRegistro) as valor 
					FROM 00019_tiposRegistroBitacora t";
		$arrRegistros=$con->obtenerFilasJSON($consulta);
		
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.utf8_encode($arrRegistros).'}';
		
		
		
	}
	
	
	function monitorerComponentesSistema()
	{
		global $con;
		global $baseDir;
		$cacheCalculos=NULL;
		$numReg=0;
		$arrRegistros="";
		$consulta="SELECT * FROM 00020_tiposCompoentesRegistroBitacora ORDER BY nombreTipoComponene";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_assoc($res))
		{
			$componenteOnline=1;
			
			$cadParametros='{"idComponente":"'.$fila["idRegistro"].'"}';
			$objParametros=json_decode($cadParametros);
			$resultadoEvaluacion="2";
			if(($fila["funcionVerificacionDisponibilidad"]!="")&&($fila["funcionVerificacionDisponibilidad"]!="-1"))
			{
				$resultadoEvaluacion=removerComillasLimite(resolverExpresionCalculoPHP($fila["funcionVerificacionDisponibilidad"],$objParametros,$cacheCalculos));
				if($resultadoEvaluacion==0)
				{
					
					escribirContenidoArchivoAppend($baseDir."/logs/".date("Y_m_d").".xml","<evento><fecha>".date("Y-m-d H:i:s")."</fecha><tipoEvento>Fallo de Componente</tipoEvento><componente>".$fila["nombreTipoComponene"])."</componente></evento>";
				}
				else
				{
					escribirContenidoArchivoAppend($baseDir."/logs/".date("Y_m_d").".xml","<evento><fecha>".date("Y-m-d H:i:s")."</fecha><tipoEvento>Componente En Línea</tipoEvento><componente>".$fila["nombreTipoComponene"])."</componente></evento>";
				}
			
			}
			$o='{"idRegistro":"'.$fila["idRegistro"].'","nombreTipoComponene":"'.$fila["nombreTipoComponene"].'","componenteOnline":"'.$resultadoEvaluacion.'"}';
		
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			$numReg++;
		}
		
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
	}
	
	function escribirContenidoArchivoAppend($archivo,$contenido)
	{
		$fp=fopen($archivo,"a");
		
		if(!fwrite($fp,$contenido))
		{
			return false;
		}
		fclose($fp);
		
		return true;
	}
	
	function buscarExistenciaRegistro()
	{
		global $con;
		$tabla=$_POST["tabla"];
		$campoBusqueda=$_POST["campoBusqueda"];
		$valor=$_POST["valor"];
		$campoIRegistro=$_POST["campoIRegistro"];
		$iRegistroIgnorar=$_POST["iRegistroIgnorar"];
		
		$consulta="SELECT COUNT(*) FROM ".$tabla." WHERE ".$campoBusqueda."='".$valor."'  AND ".$campoIRegistro."<>".$iRegistroIgnorar;
		$numFilas=$con->obtenerValor($consulta);
		
		
		if($numFilas>0)
		{
			echo "1|1";
			return;
		}
		echo "1|0";
		
		
	}
?>