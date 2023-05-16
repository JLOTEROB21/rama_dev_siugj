<?php session_start();
	
	include("conexionBD.php"); 

	include_once("funcionesEnvioMensajes.php"); 
	include_once("cActiveDirectory.php");
	include_once("latisErrorHandler.php");
	include_once("cConectoresGestorContenido/administradorConexionesGestorDocumental.php");
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
		case 8:
			autenticarUsuario();
		break;
		case 9:
			buscarUsuarioRol();
		break;
		case 10:
			probarConexionLDAP();
		break;
		case 11:
			probarConexionCMIS();
		break;
		case 12:
			reenviarCodigoAcceso();
		break;
		case 13:
			autenticar2FA();
		break;
		case 14:
			validarPalabraDiccionario();
		break;
		case 15:

			habilitarValorSesionUsuario();
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
		
		
		if(!$permitirLog)
		{
			echo "false";
			return;
		}
		
		$consulta="Select u.idUsuario,u.login,u.Nombre,a.Institucion,a.codigoUnidad,u.status,u.cambiarDatosUsr from 800_usuarios u,
					801_adscripcion a where a.idUsuario=u.idUsuario and u.Login='".cv($p["L"])."' and u.Password='".cv($p["P"])."' 
					and cuentaActiva=1"; //and Status=1
		
		
		$fila=$con->obtenerPrimeraFila($consulta);
		
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
		$consulta="Select imagen,idIdioma from 8002_idiomas where idiomaSistema=1";
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

		$mailAdministrador="";
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
			if((trim($obj->comentario)!="")&&($mailAdministrador!=""))
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
		$arrParam["nombre"]=$fDatos[2];
		$arrParam["login"]=$fDatos[0];
		$arrParam["passwd"]=$fDatos[1];
		$arrParam["email"]=$mail;
		if(enviarMensajeEnvio(11,$arrParam))
			echo "1|";
		
	}
	
	function autenticarUsuario()
	{
		global $con;
		global $Enable_AES_Ecrypt;
		global $versionLatis;
		
		$consulta="SELECT tipoAutenticacion,ipServidorLDAP,puertoServidorLDAP,modeloAutenticacion FROM 903_variablesSistema";
		$fConfiguracion=$con->obtenerPrimeraFilaAsoc($consulta);
		$tipoAutenticacion=$fConfiguracion["tipoAutenticacion"]; //1 Sistema; 2 Servidor LDAP
		
		$valInicioPwd="";
		$valFinPwd="";
		$passwd="";
		
		$login="";
		$valInicioLogin="";
		$valFinLogin="";
		$Enable_AES_Ecrypt=(isset($Enable_AES_Ecrypt)&&($Enable_AES_Ecrypt==true));
		$l=($_POST["l"]);
		$p=($_POST["p"]);
		$d=($_POST["d"]);
		$consulta="";	
		$login="";
		$fila=null;
		$consulta="";
		if($tipoAutenticacion==1)
		{
			if(!$Enable_AES_Ecrypt)
			{
				
				$consulta="Select u.idUsuario,u.login,u.Nombre,a.Institucion,a.codigoUnidad,u.status,u.cambiarDatosUsr,cuentaActiva,fechaCambioContrasena,fechaLimiteCambioContrasena from 800_usuarios u,
						801_adscripcion a where a.idUsuario=u.idUsuario and u.Login='".cv($l)."'";
				$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
				
				
				if(!$fRegistro)
				{
					$_SESSION["idUsr"]="-1";
					$_SESSION["login"]="";
					$_SESSION["idRol"]="-1000";
					$_SESSION["status"]="-1";
					guardarBitacoraInicioSesionFallida(cv($login));
					echo "1|0";
					return;
				}
				else
				{
					if($fRegistro["cuentaActiva"]==0)
					{
						echo "1|4";
						return;
					}
					else
					{
						if($fRegistro["cuentaActiva"]==100)
						{
							echo "1|3";
							return;
						}
					
					}
				}
				
				$l=bD($l);
				$p=bD($p);
				$consulta="Select u.idUsuario,u.login,u.Nombre,a.Institucion,a.codigoUnidad,u.status,u.cambiarDatosUsr,cuentaActiva,fechaCambioContrasena,fechaLimiteCambioContrasena from 800_usuarios u,
						801_adscripcion a where a.idUsuario=u.idUsuario and u.Login='".cv($l)."' and u.Password='".cv($p)."' 
						and cuentaActiva in(1,100)"; //and Status=1
			}
			else
			{
				
				
				$login=bD(decodificarAES_Encrypt($l,$valInicioLogin,$valFinLogin));
				$passwd=bD(decodificarAES_Encrypt($p,$valInicioPwd,$valFinPwd));

				
				$consulta="Select u.idUsuario,u.login,u.Nombre,a.Institucion,a.codigoUnidad,u.status,u.cambiarDatosUsr,cuentaActiva,fechaCambioContrasena,fechaLimiteCambioContrasena from 800_usuarios u,
						801_adscripcion a where a.idUsuario=u.idUsuario and u.Login='".cv($login)."'"; 
				
				$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
				
				if(!$fRegistro)
				{
					$_SESSION["idUsr"]="-1";
					$_SESSION["login"]="";
					$_SESSION["idRol"]="-1000";
					$_SESSION["status"]="-1";
					guardarBitacoraInicioSesionFallida(cv($login));
					echo "1|0";
					return;
				}
				else
				{
					if($fRegistro["cuentaActiva"]==0)
					{
						echo "1|4";
						return;
					}
					else
					{
						if($fRegistro["cuentaActiva"]==100)
						{
							echo "1|3";
							return;
						}
					
					}
				}
				
				
				$consulta="Select u.idUsuario,u.login,u.Nombre,a.Institucion,a.codigoUnidad,u.status,u.cambiarDatosUsr,cuentaActiva,fechaCambioContrasena,fechaLimiteCambioContrasena from 800_usuarios u,
						801_adscripcion a where a.idUsuario=u.idUsuario and u.Login='".cv($login)."' and u.Password=HEX(AES_ENCRYPT('".$passwd."', '".bD($versionLatis)."'))
						and cuentaActiva in(1,100)"; //and Status=1
						
				
			}
		
		}
		else
		{
			$login=bD($l);
			$passwd=bD($p);
			$domain=bD($d);
			if($Enable_AES_Ecrypt)
			{
				$login=decodificarAES_Encrypt($l,$valInicioLogin,$valFinLogin);
				$passwd=decodificarAES_Encrypt($p,$valInicioPwd,$valFinPwd);
				$domain=decodificarAES_Encrypt($d,$valInicioPwd,$valFinPwd);
			}
			
			//$domain="";
			$usr=$login;
			/*$arrLogin=explode("\\",$login);
			if(count($arrLogin)>1)
			{
				$domain=$arrLogin[0];
				$usr=$arrLogin[1];
			}*/
			
			
			$c=new cActiveDirectory($fConfiguracion["ipServidorLDAP"],$fConfiguracion["puertoServidorLDAP"]);
			$resultado=$c->autenticarUsuario($usr,$passwd,$domain);

			if($resultado["autenticado"])
			{
				$listaRolesBusqueda="";
				$arrRolesBusqueda=array();
				foreach($resultado["roles"] as $r)
				{
					$arrRolesBusqueda[mb_strtoupper($r)]["nombreRol"]=$r;
					$arrRolesBusqueda[mb_strtoupper($r)]["registrado"]=0;
					$arrRolesBusqueda[mb_strtoupper($r)]["idRol"]="";
					$arrRolesBusqueda[mb_strtoupper($r)]["asignadoUsuario"]=0;
					if($listaRolesBusqueda=='')
						$listaRolesBusqueda="'".cv(mb_strtoupper($r))."'";
					else
						$listaRolesBusqueda.=",'".cv(mb_strtoupper($r))."'";
						
				}
				
				
				$queryAux="SELECT upper(nombreGrupo),idRol FROM 8001_roles WHERE nombreGrupo IN(".$listaRolesBusqueda.")";
				$rGrupo=$con->obtenerFilas($queryAux);
				while($fGrupo=mysql_fetch_row($rGrupo))
				{
					$arrRolesBusqueda[$fGrupo[0]]["registrado"]=1;
					$arrRolesBusqueda[$fGrupo[0]]["idRol"]=$fGrupo[1];
				}
				
				
				foreach($arrRolesBusqueda as $lblRol =>$resto)
				{
					if($resto["registrado"]==0)
					{
						$x=0;
						$queryRol[$x]="begin";
						$x++;
						$queryRol[$x]="set @idRol:=(SELECT idRolSig FROM 4127_variablesSistema)";
						$x++;
					
						$queryRol[$x]="INSERT INTO 8001_roles(nombreGrupo,idIdioma,idRol,vistosAdmin,extensionRol,eliminable,extensionAvanzada,clave,activeDirec)
									VALUES('".cv($resto["nombreRol"])."',1,@idRol,1,0,0,0,'[AD]',1)";
						$x++;
						$queryRol[$x]="update 4127_variablesSistema set idRolSig=idRolSig+1";
						$x++;
						$queryRol[$x]="commit";
						$x++;
						
						if($con->ejecutarBloque($queryRol))
						{
							$queryAux="select @idRol";
							$idRol=$con->obtenerValor($queryAux);
							$arrRolesBusqueda[$lblRol]["idRol"]=$idRol;
						}
					}
					
				}
				
				$listaRolesUsuarios="";
				foreach($arrRolesBusqueda as $lblRol =>$resto)
				{
					if($listaRolesUsuarios=="")
						$listaRolesUsuarios=$resto["idRol"];
					else
						$listaRolesUsuarios.=",".$resto["idRol"];
				}
				
				
				
				$x=0;
				$query[$x]="begin";
				$x++;
				
				$consulta="Select u.idUsuario,u.login,u.Nombre,a.Institucion,a.codigoUnidad,'1' as status,'0' as cambiarDatosUsr,cuentaActiva 
							from 800_usuarios u,801_adscripcion a where u.login='".$resultado["sAMAccountName"].
							"' and a.idUsuario=u.idUsuario ";
				$fila=$con->obtenerPrimeraFila($consulta);
				if(!$fila)
				{
					$idUsuarioReg=crearBaseUsuario($resultado["apellidos"],"",$resultado["nombre"],$resultado["email"],"","",$listaRolesUsuarios,$resultado["sAMAccountName"],"");
					$query[$x]="UPDATE 800_usuarios SET cambiarDatosUsr='0' WHERE idUsuario=".$idUsuarioReg;
					$x++;
				
				}
				else
				{
					$query[$x]="UPDATE 802_identifica SET Nom='".cv($resultado["nombre"])."',Paterno='".cv($resultado["apellidos"])."' WHERE idUsuario=".$fila[0];
					$x++;
					
					$queryAux="SELECT r.idRol,idUsuariosVsRoles,upper(r.nombreGrupo) FROM 807_usuariosVSRoles uR,8001_roles r WHERE uR.idUsuario=".$fila[0].
							" AND r.idRol=uR.idRol AND r.activeDirectory=1";
					$rRolesAD=$con->obtenerFilas($queryAux);
					while($fRolAD=mysql_fetch_row($rRolesAD))
					{
						if(!isset($arrRolesBusqueda[$fRolAD[2]]))
						{
							$query[$x]="DELETE FROM 807_usuariosVSRoles WHERE idUsuariosVsRoles=".$fRolAD[1];
							$x++;
						}
						else
						{
							$arrRolesBusqueda[$fRolAD[2]]["asignadoUsuario"]=1;
						}
					}
					
					foreach($arrRolesBusqueda as $lblRol =>$resto)
					{
						if($resto["asignadoUsuario"]==0)
						{
							$query[$x]="INSERT INTO 807_usuariosVSRoles(idUsuario,idRol,idExtensionRol,codigoRol)
										values(".$fila[0].",".$resto["idRol"].",0,'".$resto["idRol"]."_0')";
							$x++;
						}
					}
					
					$queryAux="SELECT idMail FROM 805_mails WHERE idUsuario=".$fila[0]." AND Tipo=-1";
					$idMail=$con->obtenerValor($queryAux);
					if($idMail=="")
					{
						if(trim($resultado["email"])!="")
						{
							$query[$x]="INSERT INTO 805_mails(Mail,Tipo,Notificacion,idUsuario) VALUES('".cv($resultado["email"])."',-1,1,".$fila[0].")";
							$x++;	
						}
					}
					else
					{
						$query[$x]="UPDATE 805_mails SET Mail='".cv($resultado["email"])."' WHERE idMail=".$idMail;
						$x++;
					}
					
				}
				
				$query[$x]="commit";
				$x++;
				
				$con->ejecutarBloque($query);
				
			}
			else
			{
				
				$consulta="select * from 800_usuarios where 1=0";
			}
		}
		
		if(!$fila)
			$fila=$con->obtenerPrimeraFila($consulta);
		
		
		if($fila)
		{

			if($fila[7]==100)
			{
				echo "1|3";
				return;
			}
			if($fConfiguracion["modeloAutenticacion"]==2)
			{
			
				$_SESSION["2FA_".$fila[0]]=substr(hash("sha256",date("Y-m-d H:i:s".$fila[0])),0,6);
				
				
				$arrParam["nombreDestinatario"]=$fila[2];
				$arrParam["codigoAcceso"]=$_SESSION["2FA_".$fila[0]];
				
				$consulta="SELECT Mail FROM 805_mails WHERE idUsuario=".$fila[0];
				$resMail=$con->obtenerFilas($consulta);
				while($fMail=mysql_fetch_assoc($resMail))
				{
					$arrParam["emailDestinatario"]=$fMail["Mail"];
					enviarMensajeEnvio(27,$arrParam);
				}
				
				echo "1|2|".$fila[0];
				return;
			}
			
			
			$conAdscripcion="SELECT codigoUnidad FROM 801_adscripcion WHERE idUsuario=".$fila[0];
			$adscripcion=$con->obtenerValor($conAdscripcion);
			$conRol="SELECT idRol FROM 807_usuariosVSRoles WHERE idUsuario=".$fila[0]." AND idRol=1";
			$idRol=$con->obtenerValor($conRol);

			
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
			echo "1|1";
			
		}
		else
		{
			$_SESSION["idUsr"]="-1";
			$_SESSION["login"]="";
			$_SESSION["idRol"]="-1000";
			$_SESSION["status"]="-1";
			guardarBitacoraInicioSesionFallida(cv($login));
			echo "1|0";
		}
		
	}
	
	function buscarUsuarioRol()
	{
		global $con;
		$criterio=$_POST["criterio"];
		$roles=$_POST["roles"];
		$consulta="SELECT u.idUsuario,Nombre AS nombreUsuario FROM 800_usuarios u,807_usuariosVSRoles ur 
					WHERE Nombre LIKE '%".$criterio."%' and ur.codigoRol in(".$roles.") and u.idUsuario=ur.idUsuario 
					ORDER BY Nombre";
					
		$registros=utf8_encode($con->obtenerFilasJSON($consulta));
		
		
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$registros.'}';		
		
	}
	
	
	function probarConexionLDAP()
	{
		global $con;
		$idServidorLDAP=$_POST["ip"];
		$puertoLDAP=$_POST["port"];
		
		$c=new cActiveDirectory($idServidorLDAP,$puertoLDAP);
		if($c->conectar())
		{
			
			$resultado=$c->autenticarUsuario("default","default","default");			

			if($resultado["codigoAccion"]!="0000")
				echo "1|1";
			else
				echo "1|0";
		}
		else
			echo "1|0";
	}
	
	function probarConexionCMIS()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$cadObj=str_replace("\\","\\\\",$cadObj);
		$obj=json_decode($cadObj);
		$conexion=generarInstanciaTipoConectorConectorGestor($obj->tipoConector,$obj->urlServidor,$obj->usuario,$obj->password,$obj->raiz);
		if($conexion->conectar())
		{
			echo "1|1";;
		}
		else
		{
			echo "1|".$conexion->statusActual;
		}
		
	}
	
	function reenviarCodigoAcceso()
	{
		global $con;
		$iU=bD($_POST["iU"]);
		
		$consulta="Select u.idUsuario,u.login,u.Nombre,a.Institucion,a.codigoUnidad,u.status,u.cambiarDatosUsr from 800_usuarios u,
						801_adscripcion a where a.idUsuario=u.idUsuario and u.idUsuario=".$iU;
		$fila=$con->obtenerPrimeraFila($consulta);
		
		
		$_SESSION["2FA_".$fila[0]]=substr(hash("sha256",date("Y-m-d H:i:s".$fila[0])),0,6);
				
				
		$arrParam["nombreDestinatario"]=$fila[2];
		$arrParam["codigoAcceso"]=$_SESSION["2FA_".$fila[0]];
		
		$consulta="SELECT Mail FROM 805_mails WHERE idUsuario=".$fila[0];

		$resMail=$con->obtenerFilas($consulta);
		while($fMail=mysql_fetch_assoc($resMail))
		{
			$arrParam["emailDestinatario"]=$fMail["Mail"];
			enviarMensajeEnvio(27,$arrParam);
		}
		
		echo "1|";
		
	}
	
	
	function autenticar2FA()
	{
		global $con;
		$cA=bD($_POST["cA"]);
		$iU=bD($_POST["iU"]);
		
		
		
		if($_SESSION["2FA_".$iU]==$cA)
		{
			$consulta="Select u.idUsuario,u.login,u.Nombre,a.Institucion,a.codigoUnidad,u.status,u.cambiarDatosUsr from 800_usuarios u,
						801_adscripcion a where a.idUsuario=u.idUsuario and u.idUsuario=".$iU;
			$fila=$con->obtenerPrimeraFila($consulta);
			
			$conAdscripcion="SELECT codigoUnidad FROM 801_adscripcion WHERE idUsuario=".$fila[0];
			$adscripcion=$con->obtenerValor($conAdscripcion);
			$conRol="SELECT idRol FROM 807_usuariosVSRoles WHERE idUsuario=".$fila[0]." AND idRol=1";
			$idRol=$con->obtenerValor($conRol);

			
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
			echo "1|1";
			
			
		}
		else
		{
			echo "1|0";
		}
		
	}
	
	function validarPalabraDiccionario()
	{
		global $con;
		$cadenaValidacion=$_POST["pwd"];
		$consulta="SELECT COUNT(*) FROM _1160_tablaDinamica WHERE contrasenaRestringida='".$cadenaValidacion."'";
		$numReg=$con->obtenerValor($consulta);
		echo "1|".($numReg>0?1:0);
	}
	
	
	function habilitarValorSesionUsuario()
	{
		global 	$_SESSION;
		$arrTipoValores[1]="mostrarLupa";
		$arrTipoValores[2]="altoContraste";
		
		$tipoValor=$_POST["tipoValor"];
		$valorSesion=$_POST["valor"];
		
		if(isset($_SESSION))
		{
			$indice=$arrTipoValores[$tipoValor];
			
			$_SESSION[$indice]=$valorSesion;


		
			echo "1|";
		}
		
		
		
		
	}
?>