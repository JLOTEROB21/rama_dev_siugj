<?php session_start();
	include("conexionBD.php");
	include("nusoap/nusoap.php");
	include_once("funcionesNeotrai.php");
	ini_set('default_socket_timeout', 160000);
	
	
	function buscarUsuario($cadObj)
	{
		global $con;	
		$obj=json_decode(utf8_encode($cadObj));
		
		$condAux="";
		$criterio=$obj->criterio;
		$campoB=$obj->campoBusqueda;
		
		switch($campoB)
		{
			case "1": //Paterno
				$consulta="(select idUsuario,Paterno,Materno,Nom,Nombre,'' as Status,(SELECT unidad FROM 817_organigrama o,801_adscripcion a WHERE a.idUsuario=i.idUsuario AND o.codigoUnidad=a.Institucion) as adscripcion from 802_identifica i  where ".$condAux." Paterno like '".$criterio."%' COLLATE utf8_spanish2_ci   order by Paterno,Materno,Nom asc)";
			break;
			case "2": //Materno
				$consulta=" (select idUsuario,Paterno,Materno,Nom,Nombre,'' as Status,(SELECT unidad FROM 817_organigrama o,801_adscripcion a WHERE a.idUsuario=i.idUsuario AND o.codigoUnidad=a.Institucion) as adscripcion from 802_identifica  where ".$condAux." Materno like '".$criterio."%' COLLATE utf8_spanish2_ci order by Materno,Paterno,Nom asc)";
			break;
			case "3": //Nombre
				$consulta=" (select idUsuario,Paterno, Materno,Nom,Nombre,'' as Status,(SELECT unidad FROM 817_organigrama o,801_adscripcion a WHERE a.idUsuario=i.idUsuario AND o.codigoUnidad=a.Institucion) as adscripcion from 802_identifica  where ".$condAux." Nom like '".$criterio."%' COLLATE utf8_spanish2_ci order by Nom,Paterno,Materno asc)";
			break;
			
			case 5:
				$consulta="SELECT idUsuario,Paterno, Materno,Nom,Nombre,STATUS,adscripcion FROM (SELECT CONCAT('[',CONVERT(idUsuario,CHAR(30)) COLLATE utf8_spanish2_ci,']',Paterno,' ', Materno,' ',Nom) AS nUsuario ,idUsuario,Paterno,Materno,Nom,Nombre,'' AS STATUS,
				(SELECT unidad FROM 817_organigrama o,801_adscripcion a WHERE a.idUsuario=i.idUsuario AND o.codigoUnidad=a.Institucion) as adscripcion 
				FROM 802_identifica ) AS t WHERE ".$condAux." nUsuario  LIKE '%".$criterio."%' ";
			break;
		}
		$res=$con->obtenerFilas($consulta);
		$arrDatos="";
		while($fila=mysql_fetch_row($res))
		{
			if($campoB!=4)
				$consulta="select codigoRol from 807_usuariosVSRoles where idUsuario=".$fila[0];
			else
				$consulta="select codigoRol from 807_usuariosVSRoles where idUsuario=".$fila[6];
			$resRol=$con->obtenerFilas($consulta);
			$situaciones="";
			while($filaRol=mysql_fetch_row($resRol))
			{
				$sitaciones="";
				if($situaciones=="")
					$situaciones=obtenerTituloRol($filaRol[0]);
				else
					$situaciones.=",".obtenerTituloRol($filaRol[0]);
			}
			
			$consulta="";
			$adscripcion=$fila[6];
			$obj='<usuario><idUsuario>'.$fila[0].'</idUsuario><adscripcion>'.cv($adscripcion).'</adscripcion><Paterno>'.cv($fila[1]).'</Paterno><Materno>'.cv($fila[2]).'</Materno><Nom>'.cv($fila[3]).'</Nom><Nombre>'.cv($fila[4]).'</Nombre><Status>'.$situaciones.'</Status></usuario>';
			//$obj='{"idUsuario":"'.$fila[0].'","Paterno":"'.cv($fila[1]).'","Materno":"'.cv($fila[2]).'","Nom":"'.cv($fila[3]).'","Nombre":"'.cv($fila[4]).'","Status":"'.$situaciones.'"}';
			if($arrDatos=="")
				$arrDatos=$obj;
			else
				$arrDatos.=$obj;
		}
		
		return '<?xml version="1.0" encoding="utf-8"?><resultado>'.$arrDatos.'</resultado>';
		
	}
	
	
	
	function obtenerDatosUsuario($cadObj)
	{
		global $con;	
		$obj=json_decode(utf8_encode($cadObj));
		$consulta="";
		
		
		$obj->idUsuario=normalizarIdUsuarioTipo($obj->idUsuario,$obj->tipoUsuario);
		
		switch($obj->tipoUsuario)
		{
			case 1:
				$consulta="SELECT Paterno,Materno,Nom,(SELECT Binario FROM 806_fotos WHERE idUsuario=i.idUsuario) as foto FROM 802_identifica i WHERE idUsuario=".$obj->idUsuario;
			break;		
			case 2:
				$consulta="SELECT aPaterno,aMaterno,nombre FROM _1013_tablaDinamica WHERE id__1013_tablaDinamica=".$obj->idUsuario;
			break;		
		}
		
		$fDatos=$con->obtenerPrimeraFila($consulta);
		$idUsr=-1;
		if($fDatos)
		{
			$idUsr=$obj->idUsuario;
			switch($obj->tipoUsuario)
			{
				case 2:
					$archivo="";
					$consulta="SELECT idArchivoImagen FROM 9058_imagenesControlGaleria where idElementoFormulario=8650 AND idRegistro=".$obj->idUsuario;
					$idArchivo=$con->obtenerValor($consulta);
					if($idArchivo=="")
					{
						$archivo="../images/imgNoDisponible.jpg";
					}
					else
					{
						$archivo="../documentosUsr/archivo_".$idArchivo;
					}
					$f=fopen($archivo,"r");
					$fDatos[3]=fread($f,filesize($archivo));
					fclose($f);
				break;
			}
			
			
		}
		return '<?xml version="1.0" encoding="utf-8"?><resultado><foto>'.bE($fDatos[3]).'</foto><idUsuario>'.$idUsr.'</idUsuario><Paterno>'.cv($fDatos[0]).'</Paterno><Materno>'.cv($fDatos[1]).'</Materno><Nom>'.cv($fDatos[2]).'</Nom></resultado>';
		
	}
	
	function registrarHuella($cadObj)
	{
		global $con;	
		$obj=json_decode(utf8_encode($cadObj));
		
		
		$obj->idUsuario=normalizarIdUsuarioTipo($obj->idUsuario,$obj->tipoUsuario);
		
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="delete from 908_catalogoHuellas where idUsuario=".$obj->idUsuario." and tipoUsuario=".$obj->tipoUsuario." and noHuella=".$obj->noHuella;
		$x++;
		$consulta[$x]="INSERT INTO 908_catalogoHuellas(idUsuario,tipoUsuario,fechaCreacion,horaCreacion,noHuella,huella)
						VALUES(".$obj->idUsuario.",".$obj->tipoUsuario.",'".date("Y-m-d")."','".date("H:i:s")."',".$obj->noHuella.",'".$obj->huella."')";
		$x++;
		$consulta[$x]="commit";
		$x++;
		$res=0;
		if($con->ejecutarBloque($consulta))
			$res=1;
		return $res;
		
	}
	
	function obtenerHuellasUsuario($cadObj)
	{
		global $con;	
		$obj=json_decode(utf8_encode($cadObj));
		$obj->idUsuario=normalizarIdUsuarioTipo($obj->idUsuario,$obj->tipoUsuario);
		$consulta="";
		switch($obj->tipoUsuario)
		{
			case 1:
				$consulta="SELECT Paterno,Materno,Nom,(SELECT Binario FROM 806_fotos WHERE idUsuario=i.idUsuario) as foto FROM 802_identifica i WHERE idUsuario=".$obj->idUsuario;
			break;		
			case 2:
				$consulta="SELECT aPaterno,aMaterno,nombre FROM _1013_tablaDinamica WHERE id__1013_tablaDinamica=".$obj->idUsuario;
			break;		
		}
		$resultado=-1;
		$nombre="";
		$fDatos=$con->obtenerPrimeraFila($consulta);
		$idUsr=-1;
		$arrHuellas="";
		if($fDatos)
		{
			$resultado=1;
			$idUsr=$obj->idUsuario;
			$nombre=$fDatos[0]." ".$fDatos[1]." ".$fDatos[2];
			$consulta="SELECT noHuella,huella FROM 908_catalogoHuellas WHERE idUsuario=".$obj->idUsuario." AND tipoUsuario=".$obj->tipoUsuario;
			$resUsr=$con->obtenerFilas($consulta);
			while($fUsr=mysql_fetch_row($resUsr))
			{
				$o='{"valor1":"'.$fUsr[0].'","valor2":"'.$fUsr[1].'","valor3":"","valor4":"","valor5":""}';
				if($arrHuellas=="")
					$arrHuellas=$o;
				else
					$arrHuellas.=",".$o;
					
			}
			
			
		}
		return '{"resultado":"'.$resultado.'","tipoUsuario":"'.$obj->tipoUsuario.'","idUsuario":"'.$obj->idUsuario.'","nombre":"'.cv($nombre).'","arrHuellas":['.$arrHuellas.']}';
		
	}
	
	
	/*$obj='{"criterio":"ma","campoBusqueda":"5"}';
	echo buscarUsuario($obj);
	return;*/
	
	$arrParam=array();
	$server = new soap_server;
	$ns=$urlSitio."/webServices";
	$server->configurewsdl('ApplicationServices',$ns);
	$server->wsdl->schematargetnamespace=$ns;
	$server->register('buscarUsuario',array('cadObj'=>'xsd:string'),array('return' => 'xsd:string'),$ns,false,'rpc','encoded','Buscar Usuario');
	$server->register('obtenerDatosUsuario',array('cadObj'=>'xsd:string'),array('return' => 'xsd:string'),$ns,false,'rpc','encoded','Obtener Datos de Usuario');
	$server->register('registrarHuella',array('cadObj'=>'xsd:string'),array('return' => 'xsd:string'),$ns,false,'rpc','encoded','Registrar/Actualizar Huella de usuario');
	$server->register('obtenerHuellasUsuario',array('cadObj'=>'xsd:string'),array('return' => 'xsd:string'),$ns,false,'rpc','encoded','Obtener Huellas de usuario');
	if (isset($HTTP_RAW_POST_DATA)) 
	{
		$input = $HTTP_RAW_POST_DATA;
	}
	else 
	{
		$input = implode("rn", file('php://input'));
	}
	$server->service($input);
?>