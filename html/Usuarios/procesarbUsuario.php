<?php session_start();
	include("conexionBD.php");
	include("funcionesPortal.php");
	$funcion =$_POST["funcion"];
	if($incluirCabeceraISO)
		header('Content-Type: text/html; charset=iso-8859-1');
	switch($funcion)
	{
		case 1:
			criteriosBusqueda($con);
		break;
		case 2:
			criteriosBusquedaProfesores($con);
		break;
		case 3:
			criteriosBusquedaClienteEmpresa();
		break;
		case 4:
			criteriosBusquedaCerrador();
		break;
		case 5:
			buscarUsuario();
		break;
		case 6:
			buscarUsuarioRol();
		break;
		case 7:
			buscarAlumnoPlanEstudioInstitucion();
		break;
		
	}	
	
	function criteriosBusqueda($con)
	{
		$criterio=$_POST["criterio"];
		$campoB=$_POST["campoBusqueda"];
		$busquedaGlobal=0;
		if(isset($_POST["busquedaGlobal"]))
			$busquedaGlobal=$_POST["busquedaGlobal"];
		$condAux="";
		if((!existeRol("'1_0'"))&&(!existeRol("'11_0'"))&&(!existeRol("'112_0'")) &&($busquedaGlobal==0))
		{
			$condAux=" idUsuario in (select idUsuario from 801_adscripcion where Institucion='".$_SESSION["codigoInstitucion"]."') and ";
		}
		
		if(!existeRol("'1_0'"))
		{
			$condAux.=" idUsuario <>1 and ";
		}
		
		switch($campoB)
		{
			case "1": //Paterno
				$consulta="(select idUsuario,concat('[',idUsuario,'] ','<b>',Paterno,'</b>') as Paterno,Materno,Nom,Nombre,'' as Status from 802_identifica  where ".$condAux." Paterno like '".$criterio."%' COLLATE utf8_spanish2_ci   order by Paterno,Materno,Nom asc)";
			break;
			case "2": //Materno
				$consulta=" (select idUsuario,Paterno,concat('[',idUsuario,'] ','<b>',Materno,'</b>') as Materno,Nom,Nombre,'' as Status from 802_identifica  where ".$condAux." Materno like '".$criterio."%' COLLATE utf8_spanish2_ci order by Materno,Paterno,Nom asc)";
			break;
			case "3": //Nombre
				$consulta=" (select idUsuario,Paterno, Materno,concat('[',idUsuario,'] ','<b>',Nom,'</b>') as Nom,Nombre,'' as Status from 802_identifica  where ".$condAux." Nom like '".$criterio."%' COLLATE utf8_spanish2_ci order by Nom,Paterno,Materno asc)";
			break;
			case 4:
				$consulta=" (select concat('[',idUsuario,'] ','<b>',idUsuario,'</b>') as idUsuario,Paterno, Materno,Nom,Nombre,'' as Status,idUsuario as idUsr from 802_identifica  where ".$condAux." idUsuario like '".$criterio."%' order by Paterno,Materno,Nom asc)";
				
			break;
			case 5:
				$consulta="SELECT idUsuario,Paterno, Materno,Nom,Nombre,STATUS FROM (SELECT CONCAT('[',CONVERT(idUsuario,CHAR(30)) COLLATE utf8_spanish2_ci,']',Paterno,' ', Materno,' ',Nom) AS nUsuario ,idUsuario,Paterno,Materno,Nom,Nombre,'' AS STATUS 
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
			
			
			
			
			$obj='{"idUsuario":"'.$fila[0].'","Paterno":"'.cv($fila[1]).'","Materno":"'.cv($fila[2]).'","Nom":"'.cv($fila[3]).'","Nombre":"'.cv($fila[4]).
				'","Status":"'.$situaciones.'"}';
			if($arrDatos=="")
				$arrDatos=$obj;
			else
				$arrDatos.=",".$obj;
		}
		$obj='{"num":"'.$con->filasAfectadas.'","personas":['.($arrDatos).']}';
		echo $obj;
	}
	
	function criteriosBusquedaProfesores($con)
	{
		$criterio=$_POST["criterio"];
		$campoB=$_POST["campoBusqueda"];
		$condWhere="";
		if(isset($_POST["cadena"]))
		{
			$cadena=$_POST["cadena"];
			$consulta="SELECT idUsuario FROM 801_adscripcion WHERE institucion IN (".$cadena.")";
			$cadenaF=$con->obtenerListaValores($consulta);
			if($cadenaF=="")
				$cadenaF="-1";
			$condWhere=" and  i.idUsuario in(".$cadenaF.")";
		}
		switch($campoB)
		{
			case "1": //Paterno
				$consulta="(select i.idUsuario,concat('<b>',Paterno,'</b>') as Paterno,Materno,Nom,Nombre,'' as Status from 802_identifica i,807_usuariosVSRoles r where Paterno like '".$criterio."%'  and i.idUsuario=r.idUsuario and idRol=5 ".$condWhere." order by Paterno,Materno,Nom asc)";
			break;
			case "2": //Materno
				$consulta=" (select i.idUsuario,Paterno,concat('<b>',Materno,'</b>') as Materno,Nom,Nombre,'' as Status from 802_identifica i,807_usuariosVSRoles r where Materno like '".$criterio."%'  and i.idUsuario=r.idUsuario and idRol=5 ".$condWhere." order by Materno,Paterno,Nom asc)";
			break;
			case "3": //Nombre
				$consulta=" (select i.idUsuario,Paterno, Materno,concat('<b>',Nom,'</b>') as Nom,Nombre,'' as Status from 802_identifica i,807_usuariosVSRoles r where Nom like '".$criterio."%'  and i.idUsuario=r.idUsuario and idRol=5 ".$condWhere." order by Nom,Paterno,Materno asc)";
			break;
		}
		
		$res=$con->obtenerFilas($consulta);
		$arrDatos="";
		while($fila=mysql_fetch_row($res))
		{
			$consulta="select codigoRol from 807_usuariosVSRoles where idUsuario=".$fila[0];
			$resRol=$con->obtenerFilas($consulta);
			$situaciones="";
			while($filaRol=mysql_fetch_row($resRol))
			{
				if($situaciones=="")
					$situaciones=obtenerTituloRol($filaRol[0]);
				else
					$situaciones.=",".obtenerTituloRol($filaRol[0]);
			}
			$obj='{"idUsuario":"'.$fila[0].'","Paterno":"'.$fila[1].'","Materno":"'.$fila[2].'","Nom":"'.$fila[3].'","Nombre":"'.$fila[4].'","Status":"'.$situaciones.'"}';
			if($arrDatos=="")
				$arrDatos=$obj;
			else
				$arrDatos.=",".$obj;
		}
		$obj='{"num":"'.$con->filasAfectadas.'","personas":['.uDJ($arrDatos).']}';
		echo $obj;
	}
	
	function criteriosBusquedaClienteEmpresa()
	{
		global $con;
		$criterio=$_POST["query"];
		$campoB=$_POST["campoBusqueda"];
		$idCredito="-1";
		if(isset($_POST["idCredito"]))
			$idCredito=$_POST["idCredito"];
		$condWhere="";
		$comp="";
		if(isset($_POST["comp"]))
			$comp=$_POST["comp"];
		if($comp=="")
		{
			if($idCredito!="-1")
				$condWhere="";
				//$condWhere=" and idCliente not in (select idCliente from 709_aval where idCredito=".$idCredito.")";
				
		}
		else
		{
			$datosComp=explode('|',$comp);
			switch($datosComp[0])
			{
				case 1:
					$condWhere=" and idCliente not in (".$datosComp[1].")";
				break;
				case 2:
					$condWhere=" and idEmpresa not in (select idClientePrincipal from 715_principalesClientes where idCredito=".$datosComp[1].")";
				break;
			}
		}
		if($campoB=='1')
		{
			
			$consulta="select idCliente,nombre,(select Nombre from 800_usuarios where idUsuario=vc.idResponsable) as promotor,idResponsable,telefonos as telefono,email as mail from 700_vclientes vc where nombre like '".$criterio."%'".$condWhere;
		}
		else
		{
			$consulta="select idEmpresa,empresa,(select Nombre from 800_usuarios where idUsuario=e.idResponsable) as promotor,idResponsable,telefonos as telefono,email as mail from 700_empresas e where empresa like '".$criterio."%'".$condWhere;
		}
		
		$res=$con->obtenerFilas($consulta);
		$arrDatos="";
		$arrUsr=array();
		if(existeRol('39_-1')) //Gerente
		{
			$consulta="select codigoRol from 807_usuariosVSRoles where idUsuario=".$_SESSION["idUsr"]." and codigoRol like '39_%' and codigoRol <>'39_-1'";
			$rolGrupo=$con->obtenerValor($consulta);
			$datosRol=explode("_",$rolGrupo);
			$consulta="select idUsuario from 807_usuariosVSRoles where codigoRol='38_".$datosRol[1]."'";
			$resUsr=$con->obtenerFilas($consulta);
			while($filaUsr=mysql_fetch_row($resUsr))
				array_push($arrUsr,$filaUsr[0]);	
			
		}
		while($fila=mysql_fetch_row($res))
		{
			$accesible="0";
			
			if(existeRol("'38_-1'"))
			{
				if($fila[3]==$_SESSION["idUsr"])
					$accesible="1";
			}
			if(existeRol("'39_-1'")) //Gerente
			{
				$idPromotor=$fila[15];
				if(existeValor($arrUsr,$idPromotor))
					$accesible="1";
			}
			if(existeRol("'40_0'"))
				$accesible="1";
			if(existeRol("'41_0'"))
				$accesible="1";
			if(existeRol("'42_0'"))
				$accesible="1";
			if(existeRol("'1_0'"))
				$accesible="1";

			$obj='{"idUsuario":"'.$fila[0].'","Nombre":"'.$fila[1].'","complementario":"","respRegistro":"'.$fila[2].'","idResponsable":"'.$fila[3].'","acc":"'.bE($accesible).'","mail":"'.$fila[4].'","telefono":"'.$fila[5].'"}';
			if($arrDatos=="")
				$arrDatos=$obj;
			else
				$arrDatos.=",".$obj;
		}
		$obj='{"num":"'.$con->filasAfectadas.'","personas":['.uDJ($arrDatos).']}';
		echo $obj;
	}
	
	function criteriosBusquedaCerrador()
	{
		global $con;
		$criterio=$_POST["criterio"];
		$campoB=$_POST["campoBusqueda"];
		switch($campoB)
		{
			case "1": //Paterno
				$consulta="(select i.idUsuario,concat('<b>',Paterno,'</b>') as Paterno,Materno,Nom,Nombre,'' as Status from 802_identifica i,807_usuariosVSRoles r where Paterno like '".$criterio."%'  and i.idUsuario=r.idUsuario and idRol=40 order by Paterno,Materno,Nom asc)";
			break;
			case "2": //Materno
				$consulta=" (select i.idUsuario,Paterno,concat('<b>',Materno,'</b>') as Materno,Nom,Nombre,'' as Status from 802_identifica i,807_usuariosVSRoles r where Materno like '".$criterio."%'  and i.idUsuario=r.idUsuario and idRol=40 order by Materno,Paterno,Nom asc)";
			break;
			case "3": //Nombre
				$consulta=" (select i.idUsuario,Paterno, Materno,concat('<b>',Nom,'</b>') as Nom,Nombre,'' as Status from 802_identifica i,807_usuariosVSRoles r where Nom like '".$criterio."%'  and i.idUsuario=r.idUsuario and idRol=40 order by Nom,Paterno,Materno asc)";
			break;
		}
		
		$res=$con->obtenerFilas($consulta);
		$arrDatos="";
		while($fila=mysql_fetch_row($res))
		{
			$consulta="select codigoRol from 807_usuariosVSRoles where idUsuario=".$fila[0];
			$resRol=$con->obtenerFilas($consulta);
			$situaciones="";
			while($filaRol=mysql_fetch_row($resRol))
			{
				if($situaciones=="")
					$situaciones=obtenerTituloRol($filaRol[0]);
				else
					$situaciones.=",".obtenerTituloRol($filaRol[0]);
			}
			$obj='{"idUsuario":"'.$fila[0].'","Paterno":"'.$fila[1].'","Materno":"'.$fila[2].'","Nom":"'.$fila[3].'","Nombre":"'.$fila[4].'","Status":"'.$situaciones.'"}';
			if($arrDatos=="")
				$arrDatos=$obj;
			else
				$arrDatos.=",".$obj;
		}
		$obj='{"num":"'.$con->filasAfectadas.'","personas":['.uDJ($arrDatos).']}';
		echo $obj;
	}
	
	function buscarUsuario()
	{
		global $con;
		$criterio=$_POST["criterio"];
		$campoB=$_POST["campoBusqueda"];
		
		
		
		switch($campoB)
		{
			case "1": //Paterno
				$consulta="(select idUsuario,concat('<b>',Paterno,'</b>') as Paterno,Materno,Nom,Nombre,'' as Status from 802_identifica  where Paterno like '".$criterio."%' COLLATE utf8_spanish2_ci order by Paterno,Materno,Nom asc)";
			break;
			case "2": //Materno
				$consulta=" (select idUsuario,Paterno,concat('<b>',Materno,'</b>') as Materno,Nom,Nombre,'' as Status from 802_identifica  where Materno like '".$criterio."%' COLLATE utf8_spanish2_ci order by Materno,Paterno,Nom asc)";
			break;
			case "3": //Nombre
				$consulta=" (select idUsuario,Paterno, Materno,concat('<b>',Nom,'</b>') as Nom,Nombre,'' as Status from 802_identifica  where Nom like '".$criterio."%' COLLATE utf8_spanish2_ci order by Nom,Paterno,Materno asc)";
			break;
			case 4:
				$consulta=" (select concat('<b>',idUsuario,'</b>') as idUsuario,Paterno, Materno,Nom,Nombre,'' as Status,idUsuario as idUsr from 802_identifica  where idUsuario like '".$criterio."%'  order by Paterno,Materno,Nom asc)";
				
			break;
			case 5:
				$consulta="SELECT idUsuario,Paterno, Materno,Nom,Nombre,STATUS FROM (SELECT CONCAT('[',CONVERT(idUsuario,CHAR(30)) COLLATE utf8_spanish2_ci,']',Paterno,' ', Materno,' ',Nom) AS nUsuario ,idUsuario,Paterno,Materno,Nom,Nombre,'' AS STATUS 
				FROM 802_identifica) AS t WHERE nUsuario  LIKE '%".$criterio."%' ";
			break;
		}

		$res=$con->obtenerFilas($consulta);
		$arrDatos="";
		while($fila=mysql_fetch_row($res))
		{
			$consulta="SELECT o.unidad FROM 801_adscripcion a,817_organigrama o WHERE o.codigoUnidad=a.codigoUnidad AND idUsuario=".$fila[0];
			$departamento=$con->obtenerValor($consulta);
			if($departamento=="")
				$departamento="N/E";
			$obj='{"idUsuario":"'.$fila[0].'","Paterno":"'.$fila[1].'","Materno":"'.$fila[2].'","Nom":"'.$fila[3].'","Nombre":"'.$fila[4].'","Status":"'.$departamento.'"}';
			if($arrDatos=="")
				$arrDatos=$obj;
			else
				$arrDatos.=",".$obj;
		}
		$obj='{"num":"'.$con->filasAfectadas.'","personas":['.uDJ($arrDatos).']}';
		echo $obj;
	}
	
	function buscarUsuarioRol()
	{
		global $con;
		$criterio=$_POST["criterio"];
		$campoB=$_POST["campoBusqueda"];
		$listRoles=$_POST["listRoles"];
		$ocultarInstitucion=false;
		if(isset($_POST["oInstitucion"]))
			$ocultarInstitucion=true;
		$ocultarDepto=false;
		if(isset($_POST["oDepto"]))
			$ocultarDepto=true;
			
		$etInstitucion="INSTITUCIÓN";
		if(isset($_POST["etInstitucion"]))
			$etInstitucion=$_POST["etInstitucion"];
		$etDepto="DEPARTAMENTO";	
		if(isset($_POST["etDepto"]))
			$etInstitucion=$_POST["etDepto"];
		$condWhere="";
		
		if(isset($_POST["adscripcion"]))
		{
			$cadena=$_POST["adscripcion"];
			$consulta="SELECT idUsuario FROM 801_adscripcion WHERE institucion IN (".$cadena.")";
			$cadenaF=$con->obtenerListaValores($consulta);
			if($cadenaF=="")
				$cadenaF="-1";
			$condWhere=" and i.idUsuario in(".$cadenaF.")";
		}
		
		
		if(isset($_POST["cW"]))
		{
			$cond=bD($_POST["cW"]);
			if($condWhere=="")
				$condWhere=" and ".$cond;
			else
				$condWhere.=" and ".$cond;
				
		}
		
		switch($campoB)
		{
			case "1": //Paterno
				$consulta="select i.idUsuario,concat('[',i.idUsuario,'] ','<b>',Paterno,'</b>') as Paterno,Materno,Nom,Nombre,'' as Status from 802_identifica i,807_usuariosVSRoles r  
							where r.idUsuario=i.idUsuario and r.codigoRol in (".$listRoles.") ".$condWhere." and  Paterno like '".$criterio."%'  order by Paterno,Materno,Nom asc";
			break;
			case "2": //Materno
				$consulta="select i.idUsuario,CONCAT('[',i.idUsuario,'] ',Paterno) AS Paterno,concat('<b>',Materno,'</b>') as Materno,Nom,Nombre,'' as Status 
						from 802_identifica i,807_usuariosVSRoles r  where r.idUsuario=i.idUsuario and r.codigoRol in (".$listRoles.") and  
						Materno like '".$criterio."%' ".$condWhere." order by Materno,Paterno,Nom asc";
			break;
			case "3": //Nombre
				$consulta="select i.idUsuario,CONCAT('[',i.idUsuario,'] ',Paterno) AS Paterno, Materno,concat('<b>',Nom,'</b>') as Nom,Nombre,'' as Status from 802_identifica i,807_usuariosVSRoles r  
						where r.idUsuario=i.idUsuario and r.codigoRol in (".$listRoles.") and  Nom like '".$criterio."%'  ".$condWhere."  order by Nom,Paterno,Materno asc";
			break;
			case "4":  //cveEmpleado
				$consulta="select i.idUsuario,concat('[<b>',i.idUsuario,'</b> ',Paterno), Materno,Nom,Nombre,'' as Status from 802_identifica i,807_usuariosVSRoles r  
							where r.idUsuario=i.idUsuario and r.codigoRol in (".$listRoles.") and  i.idUsuario like '".$criterio."%' ".$condWhere." order by i.idUsuario asc";
				
			break;
			case "5":  //Cualquier parte
				$consulta="SELECT idUsuario,CONCAT('[',idUsuario,'] ',Paterno) AS Paterno, Materno,Nom,Nombre,STATUS,Paterno as Paterno2 FROM (
				
				SELECT CONCAT('[',i.idUsuario,'] ',upper(Paterno),' ', upper(Materno),' ',upper(Nom)) AS nUsuario ,i.idUsuario,Paterno,Materno,Nom,Nombre,'' 
				AS STATUS FROM 802_identifica i,807_usuariosVSRoles r  where r.idUsuario=i.idUsuario and r.codigoRol in (".$listRoles.") ".$condWhere."
				
				) AS t WHERE nUsuario LIKE concat('%',upper('".$criterio."'),'%')  order by Paterno2,Materno,Nom";
			
			break;
		}

		$res=$con->obtenerFilas($consulta);
		$nEmpleados=$con->filasAfectadas;
		$arrDatos="";
		$situaciones="";
		while($fila=mysql_fetch_row($res))
		{
			if(!$ocultarInstitucion)
			{
				$consulta="select o.unidad from 801_adscripcion a,817_organigrama o where o.codigoUnidad=a.Institucion and  a.idUsuario=".$fila[0];
				$institucion=$con->obtenerValor($consulta);
				if($institucion=="")
					$institucion="Desconocido";
				
				$situaciones="<b>".$etInstitucion.":</b> ".$institucion;
			}
			if(!$ocultarDepto)
			{
				$consulta="select o.unidad from 801_adscripcion a,817_organigrama o where o.codigoUnidad=a.codigoUnidad and  a.idUsuario=".$fila[0];
				$depto=$con->obtenerValor($consulta);
				if($depto=="")
					$depto="Desconocido";
				if($situaciones=="")
					$situaciones="<b>".$etDepto.": </b>".$depto;
				else		
					$situaciones.="<br><b>".$etDepto.": </b>".$depto;
			}
			
			$obj='{"idUsuario":"'.$fila[0].'","Paterno":"'.$fila[1].'","Materno":"'.$fila[2].'","Nom":"'.$fila[3].'","Nombre":"'.$fila[4].'","Status":"'.$situaciones.'"}';
			if($arrDatos=="")
				$arrDatos=$obj;
			else
				$arrDatos.=",".$obj;
		}
		$obj='{"num":"'.$nEmpleados.'","personas":['.uDJ($arrDatos).']}';
		echo $obj;
	}
	
	function buscarAlumnoPlanEstudioInstitucion()
	{
		global $con;
		$criterio=$_POST["criterio"];
		$campoB=$_POST["campoBusqueda"];
		$listRoles=$_POST["listRoles"];
		$ocultarInstitucion=false;
		if(isset($_POST["oInstitucion"]))
			$ocultarInstitucion=true;
		$ocultarDepto=false;
		if(isset($_POST["oDepto"]))
			$ocultarDepto=true;
			
		$etInstitucion="INSTITUCIÓN";
		if(isset($_POST["etInstitucion"]))
			$etInstitucion=$_POST["etInstitucion"];
		$etDepto="DEPARTAMENTO";	
		if(isset($_POST["etDepto"]))
			$etInstitucion=$_POST["etDepto"];
		$condWhere="";
		
		if(isset($_POST["adscripcion"]))
		{
			$cadena=$_POST["adscripcion"];
			
			
			$consulta="SELECT distinct idUsuario FROM 4529_alumnos WHERE plantel IN (".$cadena.")";
			$cadenaF=$con->obtenerListaValores($consulta);
			if($cadenaF=="")
				$cadenaF="-1";
			$condWhere=" and i.idUsuario in(".$cadenaF.")";
		}		
		
		if(isset($_POST["cW"]))
		{
			$cond=bD($_POST["cW"]);
			if($condWhere=="")
				$condWhere=" and ".$cond;
			else
				$condWhere.=" and ".$cond;
				
		}
		
		switch($campoB)
		{
			case "1": //Paterno
				$consulta="select i.idUsuario,concat('[',i.idUsuario,'] ','<b>',Paterno,'</b>') as Paterno,Materno,Nom,Nombre,'' as Status from 802_identifica i,807_usuariosVSRoles r  
							where r.idUsuario=i.idUsuario and r.codigoRol in (".$listRoles.") ".$condWhere." and  Paterno like '".$criterio."%'  order by Paterno,Materno,Nom asc";
			break;
			case "2": //Materno
				$consulta="select i.idUsuario,CONCAT('[',i.idUsuario,'] ',Paterno) AS Paterno,concat('<b>',Materno,'</b>') as Materno,Nom,Nombre,'' as Status 
						from 802_identifica i,807_usuariosVSRoles r  where r.idUsuario=i.idUsuario and r.codigoRol in (".$listRoles.") and  
						Materno like '".$criterio."%' ".$condWhere." order by Materno,Paterno,Nom asc";
			break;
			case "3": //Nombre
				$consulta="select i.idUsuario,CONCAT('[',i.idUsuario,'] ',Paterno) AS Paterno, Materno,concat('<b>',Nom,'</b>') as Nom,Nombre,'' as Status from 802_identifica i,807_usuariosVSRoles r  
						where r.idUsuario=i.idUsuario and r.codigoRol in (".$listRoles.") and  Nom like '".$criterio."%'  ".$condWhere."  order by Nom,Paterno,Materno asc";
			break;
			case "4":  //cveEmpleado
				$consulta="select i.idUsuario,concat('[<b>',i.idUsuario,'</b> ',Paterno), Materno,Nom,Nombre,'' as Status from 802_identifica i,807_usuariosVSRoles r  
							where r.idUsuario=i.idUsuario and r.codigoRol in (".$listRoles.") and  i.idUsuario like '".$criterio."%' ".$condWhere." order by i.idUsuario asc";
				
			break;
			case "5":  //Cualquier parte
				$consulta="SELECT idUsuario,CONCAT('[',idUsuario,'] ',Paterno) AS Paterno, Materno,Nom,Nombre,STATUS,Paterno as Paterno2 FROM (
				
				SELECT CONCAT('[',i.idUsuario,'] ',upper(Paterno),' ', upper(Materno),' ',upper(Nom)) AS nUsuario ,i.idUsuario,Paterno,Materno,Nom,Nombre,'' 
				AS STATUS FROM 802_identifica i  where 1=1 ".$condWhere."
				
				) AS t WHERE nUsuario LIKE concat('%',upper('".$criterio."'),'%')  order by Paterno2,Materno,Nom";
			
			break;
		}
		$res=$con->obtenerFilas($consulta);
		$nEmpleados=$con->filasAfectadas;
		$arrDatos="";
		$situaciones="";
		
		while($fila=mysql_fetch_row($res))
		{
			$institucion="";
			if(!$ocultarInstitucion)
			{
				$consulta="SELECT DISTINCT idInstanciaPlanEstudio FROM 4529_alumnos WHERE idUsuario=".$fila[0];
				$resPlanes=$con->obtenerFilas($consulta);
				while($filaInst=mysql_fetch_row($resPlanes))
				{
					if($institucion=="")
						$institucion=cv(obtenerNombreInstanciaPlan($filaInst[0]));
					else
						$institucion.="<br>".cv(obtenerNombreInstanciaPlan($filaInst[0]));
						
				}
				
				$situaciones="<b>Plan de estudios:</b><br>".$institucion;
			}
			
			$obj='{"idUsuario":"'.$fila[0].'","Paterno":"'.$fila[1].'","Materno":"'.$fila[2].'","Nom":"'.$fila[3].'","Nombre":"'.$fila[4].'","Status":"'.$situaciones.'"}';
			if($arrDatos=="")
				$arrDatos=$obj;
			else
				$arrDatos.=",".$obj;
		}
		$obj='{"num":"'.$nEmpleados.'","personas":['.uDJ($arrDatos).']}';
		echo $obj;
	}

?>