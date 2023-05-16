<?php session_start();
	include("conexionBD.php"); 
	include_once("funcionesEnvioMensajes.php"); 
	
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
		case 1: //Autentificar Usuario
			buscarUsuario($parametros);
		break;
		case 2:
			cerrarSesion();
		break;
		case 3:
			obtenerBanderasIdiomas();
		break;
		case 4:
			obtenerBanderasIdiomasAyuda();
		break;
		case 5:
			habilitarDebug();
		break;
		case 6:
			guardarComentarioUsuario();
		break;
		case 7:
			enviarDatosAccesoUsuario();
		break;
		
	}
	
	function obtenerBanderasIdiomas()
	{
		global $con;
		$consulta="Select imagen,idIdioma from 8002_idiomas";
		$res=$con->obtenerFilas($consulta);
		$filaText="{[";
		$items="";
		$valor="";
		$ct=0;
		$nDTD="";
		$descripcion="";
		$idDescripcion="";
		while($fila=mysql_fetch_row($res))
		{
			if($_SESSION["idDTD"]!="-1")
			{
				$consulta2="Select nombre,descripcion,idDescripcionDTD from tbl_DescripcionDTD where idDTD=".$_SESSION["idDTD"]." and idIdioma=".$fila[1];
				$res2=$con->obtenerFilas($consulta2);
				if($fila2=mysql_fetch_row($res2))
				{
					$nDTD=str_replace("_"," ",$fila2[0]);
					$descripcion=str_replace("_"," ",$fila2[1]);
					$idDescripcion=$fila2[2];
				}
			}
			$valor= '{"imagen":"'.$fila[0].'","idIdioma":"'.$fila[1].'","nombreDTD":"'.utf8_encode($nDTD).'","descripcion":"'.utf8_encode($descripcion).'","idDescripcion":"'.$idDescripcion.'"}';
			
			if($items=="")
				$items.=$valor;
			else
				$items.=",".$valor;
			
		}
		$filaText.=$items."]}";
		echo $filaText;
		
	}
	
	function buscarUsuario($p)
	{
		global $con;
		$permitirLog=true;
		global $considerarAdscripcion;
		/*$fechaCorte=strtotime(date("Y-m-d"));
		$existeArchivo=file_exists("./log.txt");
		if(($fechaCorte>=strtotime("2011-01-31"))||(!$existeArchivo))
		{
			
			$permitirLog=false;
			if($existeArchivo)
				unlink("log.txt");
		}*/
		
		if(!$permitirLog)
		{
			echo "false";
			return;
		}
		
		$consulta="Select u.idUsuario,u.login,u.Nombre,a.Institucion,a.codigoUnidad,u.status,u.cambiarDatosUsr from 800_usuarios u,801_adscripcion a where a.idUsuario=u.idUsuario and u.Login='".cv($p["L"])."' and u.Password='".cv($p["P"])."' and cuentaActiva=1"; //and Status=1
		$res=$con->obtenerFilas($consulta);
		$fila=mysql_fetch_row($res);
		if($fila!=false)
		{
			$conAdscripcion="SELECT codigoUnidad FROM 801_adscripcion WHERE idUsuario=".$fila[0];
			$adscripcion=$con->obtenerValor($conAdscripcion);
			$conRol="SELECT idRol FROM 807_usuariosVSRoles WHERE idUsuario=".$fila[0]." AND idRol=1";
			$idRol=$con->obtenerValor($conRol);

			/*if(($adscripcion=="") && ($idRol!=1)&&($considerarAdscripcion))
			{
				$_SESSION["idUsr"]="-1";
				$_SESSION["login"]="";
				$_SESSION["idRol"]="-1000";
				$_SESSION["status"]="-1";
				guardarBitacoraInicioSesionFallida(cv($p["L"]));
				
				echo "-100";
				return;
			}
			else
			{*/
				$_SESSION["idUsr"]=$fila[0];
				$_SESSION["login"]=$fila[1];
				$_SESSION["nombreUsr"]=$fila[2];
				$_SESSION["statusCuenta"]=$fila[6];
				$consulta="select codigoRol from 807_usuariosVSRoles where idUsuario=".$fila[0];
				$resRoles=$con->obtenerFilas($consulta);
				$listaGrupo="";
				while($fRoles=mysql_fetch_row($resRoles))
				{
					$arrRol=explode("_",$fRoles[0]);
					$rol="'".$fRoles[0]."'";
					if($arrRol[1]!="0")
						$rol.=",'".$arrRol[0]."_-1'";
					
					if($listaGrupo=="")
						$listaGrupo=$rol;
					else
						$listaGrupo.=",".$rol;
				}
				if($listaGrupo=="")
					$listaGrupo='-1';
				$_SESSION["idRol"]=$listaGrupo.",'-100_0'";
				$_SESSION["codigoUnidad"]=$fila[4];
				$_SESSION["codigoInstitucion"]=$fila[3];
				guardarBitacoraInicioSesion();
			//}
		}
		else
		{
			$_SESSION["idUsr"]="-1";
			$_SESSION["login"]="";
			$_SESSION["idRol"]="-1000";
			$_SESSION["status"]="-1";
			guardarBitacoraInicioSesionFallida(cv($p["L"]));
		}
		$resultado= json_encode($fila);
		echo $resultado;
	}
	
	function cerrarSesion()
	{
		guardarBitacoraFinSesion();
		session_destroy(); 
	}
	
	function obtenerBanderasIdiomasAyuda()
	{
		global $con;
		$consulta="Select imagen,idIdioma from 8002_idiomas";
		$res=$con->obtenerFilas($consulta);
		$filaText="{[";
		$items="";
		$valor="";
		$ct=0;
		$nDTD="";
		$descripcion="";
		$idDescripcion="";
		while($fila=mysql_fetch_row($res))
		{
			$valor= '{"imagen":"'.$fila[0].'","idIdioma":"'.$fila[1].'","msgAyuda":"","idMSg":""}';
			
			if($items=="")
				$items.=$valor;
			else
				$items.=",".$valor;
			
		}
		$filaText.=$items."]}";
		echo $filaText;
	}
	
	function habilitarDebug()
	{
		$tipoDebug=$_POST["tDebug"];
		$accion=$_POST["accion"];
		switch($tipoDebug) //Calculo
		{
			case 1:
				$_SESSION["debuggerCalculos"]=$accion;
			break;
			case 2:
				$_SESSION["debuggerQueries"]=$accion;
			break;
			case 3:
				$_SESSION["debuggerBloque"]=$accion;
			break;
			case 4:
				$_SESSION["debuggerConsulta"]=$accion;
			break;
		}
		echo "1|";
			
	}
	
	function guardarComentarioUsuario()
	{
		global  $con;

		$mailAdministrador="inap@grupolatis.net";
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		
		$mail="";
		if(isset($obj->email))
			$mail=$obj->email;
		else
		{
			if(isset($_SESSION["idUsr"]))
			{
				$consulta="SELECT Mail FROM 805_mails WHERE idUsuario=".$_SESSION["idUsr"];
				$mail=$con->obtenerValor($consulta);
				
			}
		}
		
		$nombre="";
		if(isset($obj->nombre))
			$nombre=$obj->nombre;
		else
		{
			if(isset($_SESSION["nombreUsr"]))
				$nombre=$_SESSION["nombreUsr"];
		}
			
		$consulta="INSERT INTO 001_comentariosUsuariosSistema(nombreUsuario,email,comentario,fechaComentario) VALUES('".cv($nombre)."','".cv($mail)."','".cv($obj->comentario)."','".date("Y-m-d H:i")."')";
		
		if($con->ejecutarConsulta($consulta))
		{
			if(trim($obj->comentario)!="")
			{
				if(enviarMail($mailAdministrador,"Duda / comentario de usuario",$obj->comentario,$mail,$nombre))
				{
					echo "1|";
				}
			}
			else
			{
				echo "1|";
			}
		}
	}
	
	function enviarDatosAccesoUsuario()
	{
		global $con;
		global $mailAdministrador;
		$mail=$_POST["mail"];
		$consulta="SELECT Login,PASSWORD,Nombre,u.idUsuario FROM 800_usuarios u,805_mails m WHERE u.idUsuario=m.idUsuario AND m.Mail='".$mail."'";
		$fDatos=$con->obtenerPrimeraFila($consulta);
		if(!$fDatos)
		{
			echo "2|";
			return;
		}
		$arrParam=array();
		$arrParam["idUsuario"]=$fDatos[3];
		if(enviarMensajeEnvio(5,$arrParam))
			echo "1|";
		
	}
?>