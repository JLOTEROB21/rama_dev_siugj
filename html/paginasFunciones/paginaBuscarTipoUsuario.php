<?php	session_start();
	include("conexionBD.php"); 
	include("funcionesPortal.php");
	$funcion =$_POST["funcion"];
	header('Content-Type: text/html; charset=iso-8859-1');
	switch($funcion)
	{
		case 1:
			criteriosBusqueda($con);
		break;
		case 2:
			buscarProfesor($con);
		break;
		
	}	
	
	function criteriosBusqueda($con)
	{
		$criterio=$_POST["criterio"];
		$campoB=$_POST["campoBusqueda"];
		
		if(existeRol("'1_0'"))
		{
			switch($campoB)
			{
				case "1": //Paterno
					$consulta="(select i.idUsuario,concat('<b>',Paterno,'</b>') as Paterno,Materno,Nom,Nombre from 802_identifica i,807_usuariosVSRoles u  where Paterno like '".$criterio."%' and  i.idUsuario=u.idUsuario and codigoRol='7_0' order by Paterno,Materno,Nom asc)";
				break;
				case "2": //Materno
					$consulta="(select i.idUsuario,Paterno,concat('<b>',Materno,'</b>') as Materno,Paterno,Nom,Nombre from 802_identifica i,807_usuariosVSRoles u  where Materno like '".$criterio."%' and  i.idUsuario=u.idUsuario and codigoRol='7_0' order by Materno,Paterno,Nom asc)";
				break;
				case "3": //Nombre
					$consulta="(select i.idUsuario,Paterno, Materno,concat('<b>',Nom,'</b>') as Nom,Nombre,Paterno,Materno from 802_identifica i,807_usuariosVSRoles u  where Nom like '".$criterio."%' and  i.idUsuario=u.idUsuario and codigoRol='7_0' order by Nom,Paterno,Materno asc)";
				break;
			}
		}
		else
		{
			switch($campoB)
			{
				case "1": //Paterno
					$consulta="(select i.idUsuario,concat('<b>',Paterno,'</b>') as Paterno,Materno,Nom,Nombre from 802_identifica i,807_usuariosVSRoles u where  Paterno like '".$criterio."%' and  u.idUsuario=i.idUsuario and codigoRol='7_0' order by Paterno,Materno,Nom asc)";
				break;
				case "2": //Materno
					$consulta=" (select i.idUsuario,Paterno,concat('<b>',Materno,'</b>') as Materno,Nom,Nombre from 802_identifica i,807_usuariosVSRoles u where Materno like '".$criterio."%' and a.idUsuario=i.idUsuario and codigoRol='7_0' order by Materno,Paterno,Nom asc)";
				break;
				case "3": //Nombre
					$consulta=" (select i.idUsuario,Paterno, Materno,concat('<b>',Nom,'</b>') as Nom,Nombre from 802_identifica i,,807_usuariosVSRoles u where  Nom like '".$criterio."%' and a.idUsuario=i.idUsuario and codigoRol='7_0' order by Nom,Paterno,Materno asc)";
				break;
			}
		}

		$arrDatos=$con->obtenerFilasJson($consulta);
		
		$obj='{"num":"'.$con->filasAfectadas.'","personas":'.($arrDatos).'}';
		
		echo $obj;
	}
	
	function buscarProfesor($con)
	{
		$criterio=$_POST["criterio"];
		$campoB=$_POST["campoBusqueda"];
		
		if(existeRol("'1_0'"))
		{
			switch($campoB)
			{
				case "1": //Paterno
					$consulta="(select i.idUsuario,concat('<b>',Paterno,'</b>') as Paterno,Materno,Nom,Nombre from 802_identifica i,807_usuariosVSRoles u  where Paterno like '".$criterio."%' and  i.idUsuario=u.idUsuario and codigoRol='5_0' order by Paterno,Materno,Nom asc)";
				break;
				case "2": //Materno
					$consulta="(select i.idUsuario,Paterno,concat('<b>',Materno,'</b>') as Materno,Paterno,Nom,Nombre from 802_identifica i,807_usuariosVSRoles u  where Materno like '".$criterio."%' and  i.idUsuario=u.idUsuario and codigoRol='5_0' order by Materno,Paterno,Nom asc)";
				break;
				case "3": //Nombre
					$consulta="(select i.idUsuario,Paterno, Materno,concat('<b>',Nom,'</b>') as Nom,Nombre,Paterno,Materno from 802_identifica i,807_usuariosVSRoles u  where Nom like '".$criterio."%' and  i.idUsuario=u.idUsuario and codigoRol='5_0' order by Nom,Paterno,Materno asc)";
				break;
			}
		}
		else
		{
			switch($campoB)
			{
				case "1": //Paterno
					$consulta="(select i.idUsuario,concat('<b>',Paterno,'</b>') as Paterno,Materno,Nom,Nombre from 802_identifica i,807_usuariosVSRoles u where  Paterno like '".$criterio."%' and  u.idUsuario=i.idUsuario and codigoRol='5_0' order by Paterno,Materno,Nom asc)";
				break;
				case "2": //Materno
					$consulta=" (select i.idUsuario,Paterno,concat('<b>',Materno,'</b>') as Materno,Nom,Nombre from 802_identifica i,807_usuariosVSRoles u where Materno like '".$criterio."%' and a.idUsuario=i.idUsuario and codigoRol='5_0' order by Materno,Paterno,Nom asc)";
				break;
				case "3": //Nombre
					$consulta=" (select i.idUsuario,Paterno, Materno,concat('<b>',Nom,'</b>') as Nom,Nombre from 802_identifica i,,807_usuariosVSRoles u where  Nom like '".$criterio."%' and a.idUsuario=i.idUsuario and codigoRol='5_0' order by Nom,Paterno,Materno asc)";
				break;
			}
		}

		$arrDatos=$con->obtenerFilasJson($consulta);
		
		$obj='{"num":"'.$con->filasAfectadas.'","personas":'.($arrDatos).'}';
		
		echo $obj;
	}
	
?>