<?php session_start();
ini_set("memory_limit","3000M");
set_time_limit(999000);
error_reporting(E_ALL);
include_once("conexionBD.php");

normalizarTelefonos();

function importarCircuitos()
{
	global $con;
	$x=0;
	$consulta[$x]="begin";
	$x++;
	
	
	$query="SELECT unidad,codigoUnidad,claveDepartamental FROM 817_organigrama WHERE institucion=10 ORDER BY codigoUnidad";
	$res=$con->obtenerFilas($query);
	while($fila=mysql_fetch_assoc($res))
	{
		$numHijo=1;
		$query="SELECT DISTINCT CODIGOCIRCUITO,CIRCUITO FROM _000_datosDespachosImportar WHERE CODIGOJURISDICCION='079' AND CODIGODISTRITO='".
				$fila["claveDepartamental"]."' ORDER BY CIRCUITO";
		
		$resCircuitos=	$con->obtenerFilas($query);
		while($filaCircuito=mysql_fetch_assoc($resCircuitos))
		{
			$codigoUnidadIndividual=str_pad($numHijo,4,"0",STR_PAD_LEFT);
			$codigoUnidad=$fila["codigoUnidad"].$codigoUnidadIndividual;
			$consulta[$x]="INSERT INTO 817_organigrama(unidad,codigoFuncional,codigoUnidad,institucion,unidadPadre,codigoIndividual,codigoDepto,claveDepartamental,codigoInstitucion,fechaCreacion,
							responsableCreacion,STATUS,instColaboradora,permiteAdscripcion) VALUES 
							('".$filaCircuito["CIRCUITO"]."','".$codigoUnidad."','".$codigoUnidad."',12,'".$fila["codigoUnidad"]."','".$codigoUnidadIndividual.
							"','".$filaCircuito["CODIGOCIRCUITO"]."','".$filaCircuito["CODIGOCIRCUITO"]."','1000','2022-10-04',1,1,0,0)";
			$x++;
			$numHijo++;
			
		}
	}
		
	$consulta[$x]="commit";
	$x++;
	
	$con->ejecutarBloque($consulta);
	
}

function importarMunicipios()
{
	global $con;
	$x=0;
	$consulta[$x]="begin";
	$x++;
	
	
	$query="SELECT codigoUnidad,unidad,claveDepartamental AS codigoCircuito,
			(SELECT claveDepartamental FROM 817_organigrama org WHERE org.codigoUnidad=o.unidadPadre) AS codigoDistrito 
			FROM 817_organigrama o WHERE institucion=12 order by unidad";
	$res=$con->obtenerFilas($query);
	while($fila=mysql_fetch_assoc($res))
	{
		$numHijo=1;
		$query="SELECT DISTINCT CODIGOMUNICIPIO,MUNICIPIO FROM _000_datosDespachosImportar WHERE CODIGOJURISDICCION='079' 
				AND CODIGODISTRITO='".$fila["codigoDistrito"]."' AND CODIGOCIRCUITO='".$fila["codigoCircuito"]."' ORDER BY municipio";
		
		$resCircuitos=	$con->obtenerFilas($query);
		while($filaCircuito=mysql_fetch_assoc($resCircuitos))
		{
			$codigoUnidadIndividual=str_pad($numHijo,4,"0",STR_PAD_LEFT);
			$codigoUnidad=$fila["codigoUnidad"].$codigoUnidadIndividual;
			$consulta[$x]="INSERT INTO 817_organigrama(unidad,codigoFuncional,codigoUnidad,institucion,unidadPadre,codigoIndividual,codigoDepto,claveDepartamental,codigoInstitucion,fechaCreacion,
							responsableCreacion,STATUS,instColaboradora,permiteAdscripcion) VALUES 
							('".$filaCircuito["MUNICIPIO"]."','".$codigoUnidad."','".$codigoUnidad."',13,'".$fila["codigoUnidad"]."','".$codigoUnidadIndividual.
							"','".$filaCircuito["CODIGOMUNICIPIO"]."','".$filaCircuito["CODIGOMUNICIPIO"]."','1000','2022-10-04',1,1,0,0)";
			$x++;
			$numHijo++;
			
			
		}
	}
		
	$consulta[$x]="commit";
	$x++;
	
	$con->ejecutarBloque($consulta);
	
}

function importarDespachos()
{
	global $con;
	$x=0;
	$consulta[$x]="begin";
	$x++;
	
	
	$query="SELECT codigoUnidad,unidad,claveDepartamental AS codigoMunicipio,
			(SELECT claveDepartamental FROM 817_organigrama org WHERE org.codigoUnidad=o.unidadPadre) AS codigoCircuito 
			FROM 817_organigrama o WHERE institucion=13 order by unidad";
	$res=$con->obtenerFilas($query);
	while($fila=mysql_fetch_assoc($res))
	{
		$numHijo=1;
		$query="SELECT DISTINCT CODIGODESPACHO,NOMBREDESPACHO FROM _000_datosDespachosImportar WHERE CODIGOJURISDICCION='079' 
				AND CODIGOMUNICIPIO='".$fila["codigoMunicipio"]."' AND CODIGOCIRCUITO='".$fila["codigoCircuito"]."' 
				and NOMBREDESPACHO not like '%tribunal superior%' and NOMBREDESPACHO not like '%casacion%'
				ORDER BY NOMBREDESPACHO";
		
		$resCircuitos=	$con->obtenerFilas($query);
		while($filaCircuito=mysql_fetch_assoc($resCircuitos))
		{
			$codigoUnidadIndividual=str_pad($numHijo,4,"0",STR_PAD_LEFT);
			$codigoUnidad=$fila["codigoUnidad"].$codigoUnidadIndividual;
			$consulta[$x]="INSERT INTO 817_organigrama(unidad,codigoFuncional,codigoUnidad,institucion,unidadPadre,codigoIndividual,codigoDepto,claveDepartamental,codigoInstitucion,fechaCreacion,
							responsableCreacion,STATUS,instColaboradora,permiteAdscripcion) VALUES 
							('".$filaCircuito["NOMBREDESPACHO"]."','".$codigoUnidad."','".$codigoUnidad."',9,'".$fila["codigoUnidad"]."','".$codigoUnidadIndividual.
							"','".$filaCircuito["CODIGODESPACHO"]."','".$filaCircuito["CODIGODESPACHO"]."','1000','2022-10-04',1,1,0,0)";
			$x++;
			$numHijo++;
			
			
		}
	}
		
	$consulta[$x]="commit";
	$x++;
	
	$con->ejecutarBloque($consulta);
	
}


function normalizarNombres()
{
	global $con;
	$consulta="SELECT CODIGODESPACHO,NOMBREDESPACHO FROM _000_datosDespachosImportar";
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_assoc($res))
	{
		$consulta="UPDATE _000_datosDespachosImportar SET NOMBREDESPACHO='".removerEspacioNombre($fila["NOMBREDESPACHO"])."' WHERE CODIGODESPACHO='".$fila["CODIGODESPACHO"]."'";
		$con->ejecutarConsulta($consulta);
	}
}


function removerEspacioNombre($nombre)
{
	
	while(strpos($nombre,"  ")!==false)
	{
		$nombre=str_replace("  "," ",$nombre);
	}
	
	
	return $nombre;
}

function asignarEspecialidades()
{
	global $con;
	$consulta="SELECT * FROM _17_tablaDinamica WHERE tipoUnidad=19";
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_assoc($res))
	{
		$consulta="SELECT CODIGOESPECIALIDAD FROM _000_datosDespachosImportar WHERE CODIGODESPACHO='".$fila["claveRegistro"]."'";
		$idEspecialidad=$con->obtenerValor($consulta)*1;
		
		$arrEspecialidad=array();
		switch($idEspecialidad)
		{
			case 3:
				$oEspecialidad=array();
				$oEspecialidad["especialidad"]="3";
				$oEspecialidad["detalle"]="";
				array_push($arrEspecialidad,$oEspecialidad);
			break;
			case 4:
				$oEspecialidad=array();
				$oEspecialidad["especialidad"]="11";
				$oEspecialidad["detalle"]="";
				array_push($arrEspecialidad,$oEspecialidad);
			break;
			case 5:
				$oEspecialidad=array();
				$oEspecialidad["especialidad"]="2";
				$oEspecialidad["detalle"]="";
				array_push($arrEspecialidad,$oEspecialidad);
			break;
			case 7:
				$oEspecialidad=array();
				$oEspecialidad["especialidad"]="11";
				$oEspecialidad["detalle"]="5";
				array_push($arrEspecialidad,$oEspecialidad);
			break;
			case 8:
				$oEspecialidad=array();
				$oEspecialidad["especialidad"]="9";
				$oEspecialidad["detalle"]="";
				array_push($arrEspecialidad,$oEspecialidad);
			break;
			case 9:
				$oEspecialidad=array();
				$oEspecialidad["especialidad"]="2";
				$oEspecialidad["detalle"]="";
				array_push($arrEspecialidad,$oEspecialidad);
			break;
			case 10:
				$oEspecialidad=array();
				$oEspecialidad["especialidad"]="10";
				$oEspecialidad["detalle"]="";
				array_push($arrEspecialidad,$oEspecialidad);
			break;
			case 12:
				$oEspecialidad=array();
				$oEspecialidad["especialidad"]="3";
				$oEspecialidad["detalle"]="";
				array_push($arrEspecialidad,$oEspecialidad);
				$oEspecialidad=array();
				$oEspecialidad["especialidad"]="2";
				$oEspecialidad["detalle"]="";
				array_push($arrEspecialidad,$oEspecialidad);
			break;
			case 13:
				$oEspecialidad=array();
				$oEspecialidad["especialidad"]="3";
				$oEspecialidad["detalle"]="";
				array_push($arrEspecialidad,$oEspecialidad);
				$oEspecialidad=array();
				$oEspecialidad["especialidad"]="10";
				$oEspecialidad["detalle"]="";
				array_push($arrEspecialidad,$oEspecialidad);
			break;
			case 14:
				$oEspecialidad=array();
				$oEspecialidad["especialidad"]="2";
				$oEspecialidad["detalle"]="";
				array_push($arrEspecialidad,$oEspecialidad);
				$oEspecialidad=array();
				$oEspecialidad["especialidad"]="3";
				$oEspecialidad["detalle"]="";
				array_push($arrEspecialidad,$oEspecialidad);
				$oEspecialidad=array();
				$oEspecialidad["especialidad"]="10";
				$oEspecialidad["detalle"]="";
				array_push($arrEspecialidad,$oEspecialidad);
			break;
			case 18:
				$oEspecialidad=array();
				$oEspecialidad["especialidad"]="12";
				$oEspecialidad["detalle"]="9";
				array_push($arrEspecialidad,$oEspecialidad);
			break;			
			case 19:
				$oEspecialidad=array();
				$oEspecialidad["especialidad"]="11";
				$oEspecialidad["detalle"]="8";
				array_push($arrEspecialidad,$oEspecialidad);
			break;
			case 20:
				$oEspecialidad=array();
				$oEspecialidad["especialidad"]="11";
				$oEspecialidad["detalle"]="6";
				array_push($arrEspecialidad,$oEspecialidad);
			break;
			case 21:
				$oEspecialidad=array();
				$oEspecialidad["especialidad"]="3";
				$oEspecialidad["detalle"]="1";
				array_push($arrEspecialidad,$oEspecialidad);
			break;
			case 46:
				$oEspecialidad=array();
				$oEspecialidad["especialidad"]="11";
				$oEspecialidad["detalle"]="4";
				array_push($arrEspecialidad,$oEspecialidad);
			break;
			case 47:
				$oEspecialidad=array();
				$oEspecialidad["especialidad"]="13";
				$oEspecialidad["detalle"]="";
				array_push($arrEspecialidad,$oEspecialidad);
			break;
			case 48:
				$oEspecialidad=array();
				$oEspecialidad["especialidad"]="14";
				$oEspecialidad["detalle"]="";
				array_push($arrEspecialidad,$oEspecialidad);
			break;
			case 71:
				$oEspecialidad=array();
				$oEspecialidad["especialidad"]="12";
				$oEspecialidad["detalle"]="10";
				array_push($arrEspecialidad,$oEspecialidad);
			break;
			case 87:
				$oEspecialidad=array();
				$oEspecialidad["especialidad"]="11";
				$oEspecialidad["detalle"]="7";
				array_push($arrEspecialidad,$oEspecialidad);
			break;
			case 88:
				$oEspecialidad=array();
				$oEspecialidad["especialidad"]="11";
				$oEspecialidad["detalle"]="3";
				array_push($arrEspecialidad,$oEspecialidad);
			break;
			
			
		}
		
		$x=0;
		$query=array();
		$query[$x]="begin";
		$x++;
		foreach($arrEspecialidad as $oEspecialidad)
		{
			
			
			$query[$x]="INSERT INTO _1284_tablaDinamica(idReferencia,fechaCreacion,responsable,especialidad,detalleEspecialidad)
						VALUES(".$fila["id__17_tablaDinamica"].",'2022-10-08 16:40',1,".$oEspecialidad["especialidad"].",".
						($oEspecialidad["detalle"]==""?"NULL":$oEspecialidad["detalle"]).")";
			$x++;
			
			
		}
		
		$query[$x]="UPDATE _17_tablaDinamica SET actualizado=1 WHERE id__17_tablaDinamica=".$fila["id__17_tablaDinamica"];
		$x++;
		$query[$x]="commit";
		$x++;
			
		$con->ejecutarBloque($query);
		
	}
}

function importarDirecciones()
{
	global $con;
	$consulta="SELECT * FROM _17_tablaDinamica WHERE tipoUnidad=19";
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_assoc($res))
	{
		$consulta="SELECT DIRECCION,TELEFONO,CORREO,CODIGOMUNICIPIO FROM _000_datosDespachosImportar WHERE CODIGODESPACHO='".$fila["claveRegistro"]."'";
		$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
		
		$x=0;
		$query=array();
		$query[$x]="begin";
		$x++;
		
		$query[$x]="INSERT INTO _638_tablaDinamica(idReferencia,fechaCreacion,responsable,calle,departamentos,municipio)
					VALUES(".$fila["id__17_tablaDinamica"].",'".date("Y-m-d H:i:s")."',1,'".cv($fRegistro["DIRECCION"])."','".substr($fRegistro["CODIGOMUNICIPIO"],0,2)."','".$fRegistro["CODIGOMUNICIPIO"]."')";
		$x++;
		$query[$x]="set @idDireccion:=(select last_insert_id())";
		$x++;
		if($fRegistro["TELEFONO"]!="NR")
		{
			$query[$x]="INSERT INTO _638_gridTelefono(idReferencia,numero) VALUES(@idDireccion,'".$fRegistro["TELEFONO"]."')";
			$x++;
		}
		
		if(($fRegistro["CORREO"]!="NR")&&($fRegistro["CORREO"]!="NULL") && ($fRegistro["CORREO"]!=""))
		{
			$query[$x]="INSERT INTO _638_gridCorreo(idReferencia,email) VALUES(@idDireccion,'".$fRegistro["CORREO"]."')";
			$x++;
		}
		$query[$x]="commit";
		$x++;
			
		$con->ejecutarBloque($query);
		
		
	}
}

function importarDespachosTribunalSuperior()
{
	global $con;
	$x=0;
	$consulta[$x]="begin";
	$x++;
	
	
	$query="SELECT codigoUnidad,unidad,claveDepartamental AS codigoTribunal,
			(SELECT claveDepartamental FROM 817_organigrama org WHERE org.codigoUnidad=o.unidadPadre) AS codigoDistrito 
			FROM 817_organigrama o WHERE institucion=20 ORDER BY unidad";
	$res=$con->obtenerFilas($query);
	while($fila=mysql_fetch_assoc($res))
	{
		$numHijo=1;
		$query="SELECT DISTINCT CODIGODESPACHO,NOMBREDESPACHO FROM _000_datosDespachosImportar WHERE CODIGOJURISDICCION='079' 
				AND CODIGODISTRITO='".$fila["codigoDistrito"]."' and NOMBREDESPACHO like '%tribunal%'
				ORDER BY NOMBREDESPACHO";
		
		$resCircuitos=	$con->obtenerFilas($query);
		while($filaCircuito=mysql_fetch_assoc($resCircuitos))
		{
			$codigoUnidadIndividual=str_pad($numHijo,4,"0",STR_PAD_LEFT);
			$codigoUnidad=$fila["codigoUnidad"].$codigoUnidadIndividual;
			$consulta[$x]="INSERT INTO 817_organigrama(unidad,codigoFuncional,codigoUnidad,institucion,unidadPadre,codigoIndividual,codigoDepto,claveDepartamental,codigoInstitucion,fechaCreacion,
							responsableCreacion,STATUS,instColaboradora,permiteAdscripcion) VALUES 
							('".$filaCircuito["NOMBREDESPACHO"]."','".$codigoUnidad."','".$codigoUnidad."',21,'".$fila["codigoUnidad"]."','".$codigoUnidadIndividual.
							"','".$filaCircuito["CODIGODESPACHO"]."','".$filaCircuito["CODIGODESPACHO"]."','1000','2022-10-04',1,1,0,0)";
			$x++;
			$numHijo++;
			
			
		}
	}
		
	$consulta[$x]="commit";
	$x++;
	
	$con->ejecutarBloque($consulta);
	
}


function importarDespachosCorteSuprema()
{
	global $con;
	$x=0;
	$consulta[$x]="begin";
	$x++;
	
	
	
	$numHijo=1;
	$query="SELECT * FROM _000_datosDespachosImportar WHERE  CODIGOJURISDICCION='079'";
	
	$resCircuitos=	$con->obtenerFilas($query);
	while($filaCircuito=mysql_fetch_assoc($resCircuitos))
	{
		$fila["codigoUnidad"]="1000000400020001";
		$codigoUnidadIndividual=str_pad($numHijo,4,"0",STR_PAD_LEFT);
		$codigoUnidad=$fila["codigoUnidad"].$codigoUnidadIndividual;
		$consulta[$x]="INSERT INTO 817_organigrama(unidad,codigoFuncional,codigoUnidad,institucion,unidadPadre,codigoIndividual,codigoDepto,claveDepartamental,codigoInstitucion,fechaCreacion,
						responsableCreacion,STATUS,instColaboradora,permiteAdscripcion) VALUES 
						('".$filaCircuito["NOMBREDESPACHO"]."','".$codigoUnidad."','".$codigoUnidad."',19,'".$fila["codigoUnidad"]."','".$codigoUnidadIndividual.
						"','".$filaCircuito["CODIGODESPACHO"]."','".$filaCircuito["CODIGODESPACHO"]."','1000','2022-10-04',1,1,0,0)";
		$x++;
		$numHijo++;
		
		
	}
	
		
	$consulta[$x]="commit";
	$x++;
	
	$con->ejecutarBloque($consulta);
	
}


function normalizarTelefonos()
{
	global $con;
	$consulta="SELECT * FROM _638_gridTelefono";
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_assoc($res))
	{
		if(strpos($fila["numero"],'Ext')!==false)
		{
			$arrTelefono=explode("Ext",$fila["numero"]);
			$consulta="UPDATE _638_gridTelefono SET numero='".trim(normalizarValor($arrTelefono[0],true))."',extension='".trim(normalizarValor($arrTelefono[1],true))."' WHERE id__638_gridTelefono=".$fila["id__638_gridTelefono"];
			$con->ejecutarConsulta($consulta);
		}
		else
		{
			$consulta="UPDATE _638_gridTelefono SET numero='".trim(normalizarValor($fila["numero"],true))."' WHERE id__638_gridTelefono=".$fila["id__638_gridTelefono"];
			$con->ejecutarConsulta($consulta);
		}
	}
	
	
}

?>