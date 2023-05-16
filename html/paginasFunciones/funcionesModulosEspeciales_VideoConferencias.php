<?php session_start();
	include_once("conexionBD.php");
	include_once("utiles.php");
	include_once("funcionesReunionesVirtuales.php");
	include_once("cBBB.php");
	;
	
	if(isset($_POST["parametros"]))
		$parametros=$_POST["parametros"];
	if(isset($_POST["funcion"]))
		$funcion=$_POST["funcion"];
	
	
	switch($funcion)
	{
		case 1:
			obtenerReunionesProgramadas();
		break;
		case 2:
			buscarUsuarioSistema();
		break;
		case 3:
			registrarReunion();
		break;
		case 4:
			obtenerParticipantesReunion();
		break;
		case 5:
			reenviarInvitacion();
		break;
		case 6:
			confirmarReunion();
		break;
		case 7:
			cancelarReunionReunion();
		break;
		case 8:
			verificarInicioReunion();
		break;
		case 9:
			buscarReunion();
		break;
		case 10:
			verificarStatusReunion();
		break;
		case 11:
			ingresarAReunion();
		break;
		case 12:
			obtenerContactosReunion();
		break;
		case 13:
			buscarInformacionContactosMail();
		break;
		case 14:
			registrarInformacionContactosMail();
		break;
		case 15:
			registrarInformacionGruposMail();
		break;
		case 16:
			obtenerGruposContactosReunion();
		break;
		case 17:
			obtenerContactosAsociadosGrupos();
		break;
		
	}
	
	function obtenerReunionesProgramadas()
	{
		global $con;
		$numReg=0;
		$arrRegistros="";
		$consulta="SELECT * FROM 7050_reunionesVirtualesProgramadas ORDER BY fechaRegistro DESC";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_assoc($res))
		{
			
			$participantesConsiderados="<table>";
			$consulta="SELECT idRegistro,tipoParticipante,nombreParticipante,rolParticipante,eMail FROM 7051_participantesReunionesVirtuales 
						WHERE idReunion=".$fila["idRegistro"]." ORDER BY tipoParticipante";
			$resParticipantes=$con->obtenerFilas($consulta);
			while($filaParticipante=mysql_fetch_assoc($resParticipantes))
			{

				$nombreParticipante="";
				$rolReunion=$filaParticipante["rolParticipante"]==1?"<span title='Moderador' alt='Moderador'>(<b>M</b>)</span>":"<span title='Invitado' alt='Invitado'>(I)</span>";
				$imagenRol=$filaParticipante["rolParticipante"]==1?"<img src='../images/user_gray.png' width='14' height='14'>":"<img src='../images/user.png'  width='14' height='14'>";
				switch($filaParticipante["tipoParticipante"])
				{
					case 1:
						$nombreParticipante=obtenerNombreUsuario($filaParticipante["nombreParticipante"]);
					break;
					case 2:
						$nombreParticipante=$filaParticipante["nombreParticipante"];
					break;
					
					case 4:
						$consulta=" SELECT apellidoPaterno,apellidoMaterno,nombre FROM _47_tablaDinamica WHERE id__47_tablaDinamica=".$filaParticipante["nombreParticipante"];
						$fBusqueda=$con->obtenerPrimeraFila($consulta);
						$nombreParticipante=$fBusqueda[2]." ".$fBusqueda[0]." ".$fBusqueda[1];
					break;
				}
				
				
				
				$comp="";
				if($fila["situacionActual"]=="1")
				{
					$comp.="<td>&nbsp;<a style='cursor:pointer' onclick=\\\"reenviarInvitacion('".bE($filaParticipante["idRegistro"])."')\\\"><img src='../images/email_go.png' width='14' height='14' title='Reenviar Invitaci&oacute;n' alt='Reenviar Invitaci&oacute;n'></a>&nbsp;</td>";
					$comp.="<td>&nbsp;<a style='cursor:pointer' onclick=\\\"imprimirInvitacion('".bE($filaParticipante["idRegistro"])."')\\\"><img src='../images/vcard.png' width='14' height='14' title='Imprimir Invitaci&oacute;n' alt='Imprimir Invitaci&oacute;n'></a>&nbsp;</td>";
				}
				$participantesConsiderados.="<tr><td align='center'>".$rolReunion."&nbsp;&nbsp;&nbsp;</td>".$comp."<td >".$nombreParticipante."</td></tr>";
				
//				
				$participantesConsiderados.="</tr>";
			}
			$participantesConsiderados.="</table>";
			
			$comentariosCancelacion="";
			if($fila["fechaCancelacion"]!="")
			{
				$comentariosCancelacion="Motivo de la cancelación: ".$fila["motivoCancelacion"].
											"<br />Cancelado por: ".obtenerNombreUsuario($fila["respCancelacion"]).
											"<br />Fecha de cancelación: ".date("d/m/Y",strtotime($fila["fechaCancelacion"]));
			}
			
			$o='{"idRegistro":"'.$fila["idRegistro"].'","fechaRegistro":"'.$fila["fechaRegistro"].'","idResponsableRegistro":"'.cv(obtenerNombreUsuario($fila["idResponsableRegistro"])).
				'","situacionActual":"'.$fila["situacionActual"].'","nombreReunion":"'.cv($fila["nombreReunion"]).'","fechaProgramada":"'.$fila["fechaProgramada"].
				'","duracion":"'.$fila["duracion"].'","meetingID":"'.$fila["reunionID"].'","maxParticipantes":"'.$fila["maxParticipantes"].
				'","permiteGrabacion":"'.$fila["permiteGrabacion"].'","grabarAlIniciar":"'.$fila["grabarAlIniciar"].
				'","permiteDetenerIniciarGrabacion":"'.$fila["permiteDetenerIniciarGrabacion"].'","webCamSoloModerador":"'.$fila["webCamSoloModerador"].
				'","silencioAlIniciar":"'.$fila["silencioAlIniciar"].'","permitirDesSileciarParticipantes":"'.$fila["permitirDesSileciarParticipantes"].
				'","deshabilitarCamaraParticipantes":"'.$fila["deshabilitarCamaraParticipantes"].'","deshabilitarMicrofonoParticipantes":"'.$fila["deshabilitarMicrofonoParticipantes"].
				'","deshabilitarChatPrivado":"'.$fila["deshabilitarChatPrivado"].'","deshabilitarChatPublico":"'.$fila["deshabilitarChatPublico"].
				'","deshabilitarNotas":"'.$fila["deshabilitarNotas"].'","iniciarAlIngresarModerador":"'.$fila["iniciarAlIngresarModerador"].
				'","participantesConsiderados":"'.$participantesConsiderados.'","comentariosCancelacion":"'.cv($comentariosCancelacion).'"}';
			
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			$numReg++;
			
		}
		
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
	}
	
	function buscarUsuarioSistema()
	{
		global $con;
		$numReg=0;
		$arrRegistros="";
		$query=$_POST["query"];
		$consulta="select * from (SELECT u.idUsuario,u.Nombre,'1' as tipoUsuario,i.Prefijo as prefijo,'' as puesto,
					(select unidad FROM 817_organigrama WHERE codigoUnidad=a.Institucion) as institucion 
					FROM 800_usuarios u,801_adscripcion a,802_identifica i WHERE u.Nombre LIKE '%".$query."%' and a.idUsuario=u.idUsuario
					and i.idUsuario=a.idUsuario
					union
					SELECT idRegistro as idUsuario,nombreContacto as Nombre,'2' as tipoUsuario,
					prefijo,puesto,institucion FROM 805_contactosCorreo c WHERE c.idUsuario=".$_SESSION["idUsr"]." AND nombreContacto LIKE '%".$query."%')
					as tmp 	 ORDER BY Nombre";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$roles="";
			$mail="";
			if($fila[2]==1)
			{
				$consulta="SELECT m.Mail FROM 805_mails m WHERE m.idUsuario=".$fila[0]."  ORDER BY Mail";
				$mail=$con->obtenerListaValores($consulta);
				if($mail=="")
				{
					$mail="Sin direcci&oacute;n de correo registrado";
				}
				
				$consulta="SELECT if(codArea is null or codArea='','52',codArea) as codPais,Lada AS lada,Numero AS numero FROM 804_telefonos WHERE idUsuario=".$fila[0]." and Tipo2=2";
				$arrTelefonos=$con->obtenerFilasJSON($consulta);
			}
			else
			{
				$consulta="SELECT mail FROM 805_mailsContactosCorreo WHERE idContacto=".$fila[0]."  ORDER BY mail";
				$mail=$con->obtenerListaValores($consulta);
				if($mail=="")
				{
					$mail="Sin direcci&oacute;n de correo registrado";
				}
				
				$consulta="SELECT codPais,lada,telefono as numero FROM 805_telefonosContactoCorreo WHERE idContacto=".$fila[0];
				$arrTelefonos=$con->obtenerFilasJSON($consulta);
			}
			$o='{"idUsuario":"'.$fila[0].'","nombreUsuario":"'.cv($fila[1]).'","roles":"'.$roles.'","eMail":"'.$mail.'","tipoUsuario":"'.$fila[2].
			'","arrTelefonos":'.$arrTelefonos.',"institucion":"'.cv($fila[5]).'"}';
		
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			$numReg++;
		}
		
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
	}
	
	function registrarReunion()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		
		$x=0;
		$query[$x]="begin";
		$x++;
		$obj=json_decode($cadObj);
		$confSesion=$obj->confSesion;
		if($obj->idReunion==-1)
		{
			$encontrado=true;
			$reunionID=rand(1000,9999)."-".date("Hi",strtotime($obj->fechaReunion))."-".date("ym",strtotime($obj->fechaReunion))."-".rand(1000,9999);
			while($encontrado)
			{
				$consulta="SELECT COUNT(*) FROM 7050_reunionesVirtualesProgramadas WHERE reunionID='".$reunionID."'";
				$numRegistros=$con->obtenerValor($consulta);
				$encontrado=$numRegistros>0;
			}
			
			
			$query[$x]="INSERT INTO 7050_reunionesVirtualesProgramadas(fechaRegistro,idResponsableRegistro,situacionActual,nombreReunion,fechaProgramada,
						duracion,passwdModerador,passParticipante,reunionID,maxParticipantes,permiteGrabacion,grabarAlIniciar,permiteDetenerIniciarGrabacion,
						webCamSoloModerador,silencioAlIniciar,permitirDesSileciarParticipantes,deshabilitarCamaraParticipantes,deshabilitarMicrofonoParticipantes,
						deshabilitarChatPrivado,deshabilitarChatPublico,deshabilitarNotas,iniciarAlIngresarModerador) values 
						('".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",0,'".cv($obj->tituloReunion)."','".$obj->fechaReunion."',".$obj->duracionEstimada.
						",'".generarPasswordAleatorio()."','".generarPasswordAleatorio()."','".$reunionID."',".$obj->totalParticipantes.",".$confSesion->permiteGrabacion.
						",".$confSesion->grabarAlIniciar.",".$confSesion->permiteDetenerIniciarGrabacion.",".$confSesion->webCamSoloModerador.
						",".$confSesion->silencioAlIniciar.",".$confSesion->permitirDesSileciarParticipantes.",".$confSesion->deshabilitarCamaraParticipantes.
						",".$confSesion->deshabilitarMicrofonoParticipantes.",".$confSesion->deshabilitarChatPrivado.",".$confSesion->deshabilitarChatPublico.
						",".$confSesion->deshabilitarNotas.",".$confSesion->iniciarAlIngresarModerador.")";
			$x++;
			$query[$x]="set @idReunion:=(select last_insert_id())";
			$x++;
			
		}
		else
		{
			$query[$x]="set @idReunion:=".$obj->idReunion;
			$x++;
			
			$query[$x]="update 7050_reunionesVirtualesProgramadas set nombreReunion='".cv($obj->tituloReunion)."',fechaProgramada='".$obj->fechaReunion.
						"',duracion=".$obj->duracionEstimada.",maxParticipantes=".$obj->totalParticipantes.",permiteGrabacion=".$confSesion->permiteGrabacion.
						",grabarAlIniciar=".$confSesion->grabarAlIniciar.",permiteDetenerIniciarGrabacion=".$confSesion->permiteDetenerIniciarGrabacion.
						",webCamSoloModerador=".$confSesion->webCamSoloModerador.",silencioAlIniciar=".$confSesion->silencioAlIniciar.
						",permitirDesSileciarParticipantes=".$confSesion->permitirDesSileciarParticipantes.",deshabilitarCamaraParticipantes=".
						$confSesion->deshabilitarCamaraParticipantes.",deshabilitarMicrofonoParticipantes=".$confSesion->deshabilitarMicrofonoParticipantes.",
						deshabilitarChatPrivado=".$confSesion->deshabilitarChatPrivado.",deshabilitarChatPublico=".$confSesion->deshabilitarChatPublico.
						",deshabilitarNotas=".$confSesion->deshabilitarNotas.",iniciarAlIngresarModerador=".$confSesion->iniciarAlIngresarModerador." where idRegistro=@idReunion";
						
			$x++;
			
			$query[$x]="DELETE FROM 7051_participantesReunionesVirtuales WHERE idReunion=@idReunion";
			$x++;
		}
		
		
		foreach($obj->participantes as $p)
		{
			$nombreParticipante="";
			switch($p->tipoParticipante)
			{
				case 1:
					$nombreParticipante=$p->idParticipante;
				break;
				case 2:
				case 3:
					$nombreParticipante=$p->nombreParticipante;
				break;
			}
			
			$passwdReunion=generarPasswordAleatorio();
			$query[$x]="INSERT INTO 7051_participantesReunionesVirtuales(idReunion,tipoParticipante,nombreParticipante,rolParticipante,eMail,noParticipantes,passwdReunion,telefono)
						VALUES(@idReunion,".$p->tipoParticipante.",'".cv($nombreParticipante)."',".$p->tipoParticipacion.",'".$p->email."',".$p->noParticipantes.",'".
						$passwdReunion."','".$p->telefono."')";
			$x++;
		}
		
		$query[$x]="commit";
		$x++;
		
		eB($query);
	}
	
	
	function obtenerParticipantesReunion()
	{
		global $con;
		
		$idReunion=$_POST["idReunion"];
		
		$arrRegistros="";
		$numReg=0;
		
		$consulta="SELECT * FROM 7051_participantesReunionesVirtuales WHERE idReunion=".$idReunion." ORDER BY tipoParticipante";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_assoc($res))
		{
			$nombreParticipante="";
			switch($fila["tipoParticipante"])
			{
				case 1:
					$nombreParticipante=obtenerNombreUsuario($fila["nombreParticipante"]);
				break;
				case 2:
					$nombreParticipante=$fila["nombreParticipante"];
				break;
				
				case 4:
					$consulta=" SELECT apellidoPaterno,apellidoMaterno,nombre FROM _47_tablaDinamica WHERE id__47_tablaDinamica=".$fila["nombreParticipante"];
					$fBusqueda=$con->obtenerPrimeraFila($consulta);
					$nombreParticipante=$fBusqueda[2]." ".$fBusqueda[0]." ".$fBusqueda[1];
				break;
			}
			
			
			$o='{"idParticipante":"'.$fila["idRegistro"].'","nombreParticipante":"'.cv($nombreParticipante).'","tipoParticipacion":"'.$fila["rolParticipante"].
				'","email":"'.$fila["eMail"].'","telefono":"'.$fila["telefono"].'","tipoParticipante":"'.$fila["tipoParticipante"].'","noParticipantes":"'.$fila["noParticipantes"].'"}';
			
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			$numReg++;
		}
		
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
		
	}
	
	
	function reenviarInvitacion()
	{
		global $con;
		$idRegistro=$_POST["idRegistro"];
		$consulta="SELECT idReunion FROM 7051_participantesReunionesVirtuales WHERE idRegistro=".$idRegistro;
		$idReunion=$con->obtenerValor($consulta);
		
		enviarInvitacionesReunion($idReunion,$idRegistro);
		
		echo "1|";
	}
	
	function confirmarReunion()
	{
		global $con;
		$idReunion=$_POST["idReunion"];
		$consulta="UPDATE 7050_reunionesVirtualesProgramadas SET situacionActual=1 WHERE idRegistro=".$idReunion;

		if($con->ejecutarConsulta($consulta))
		{
			@enviarInvitacionesReunion($idReunion);
			echo "1|";
		}
	}
	
	function cancelarReunionReunion()
	{
		global $con;
		$idReunion=$_POST["idReunion"];
		$motivoCancelacion=$_POST["motivo"];
		$consulta="UPDATE 7050_reunionesVirtualesProgramadas SET situacionActual=4,fechaCancelacion='".date("Y-m-d H:i:s").
					"', respCancelacion=".$_SESSION["idUsr"].",motivoCancelacion='".cv($motivoCancelacion).
					"' WHERE idRegistro=".$idReunion;
		if($con->ejecutarConsulta($consulta))
		{
			@enviarInvitacionesReunion($idReunion,"",0);
			echo "1|";
		}
	}
	
	
	function verificarInicioReunion()
	{
		global $con;
		$idReunion=$_POST["idReunion"];
		$fechaActual=strtotime(date("Y-m-d H:i"));
		
		$consulta="SELECT * FROM 7050_reunionesVirtualesProgramadas WHERE idRegistro=".$idReunion;
		$fReunion=$con->obtenerPrimeraFilaAsoc($consulta);
		
		$fechaSesion=strtotime($fReunion["fechaProgramada"]);
		
		if($fechaSesion<=$fechaActual)
		{
			echo "1|0_0_0";
		}
		else
		{
			$diferenciaMinutos=obtenerDiferenciaMinutos(date("Y-m-d H:i",$fechaActual),date("Y-m-d H:i",$fechaSesion));
			
			$horas=floor($diferenciaMinutos/60);
			$totalMinutos=$diferenciaMinutos-($horas*60);
			$totalDias=0;
			$totalHoras=0;

			if($horas>=24)
			{
				$totalDias=floor($horas/24);
				$totalHoras=$horas-($totalDias*24);
			}
			else
			{
				$totalHoras=$horas;
			}
			

			
			echo "1|".$totalDias."_".$totalHoras."_".$totalMinutos;
		}
		
		
	}
	
	function buscarReunion()
	{
		global $con;
		global $urlPantallaAccesoReunion;
		global $versionLatis;
		$meetID=$_POST["meetID"];
		$passwd=$_POST["passwd"];
		
		$consulta="SELECT * FROM 7050_reunionesVirtualesProgramadas r,7051_participantesReunionesVirtuales p WHERE r.idRegistro=p.idReunion AND
					r.reunionID='".$meetID."' AND BINARY p.passwdReunion='".$passwd."'";
		$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
		
		if(!$fRegistro)
		{
			echo "1|0";
		}
		else
		{
			$consulta="select HEX(AES_ENCRYPT('".$fRegistro["reunionID"]."_".$passwd."', '".bD($versionLatis)."'))";
			$claveAcceso=$con->obtenerValor($consulta);
			$urlRedireccion=$urlPantallaAccesoReunion;
			echo "1|1|".$urlRedireccion."|meeting|".$claveAcceso;
		}
		
		
	}
	
	
	function verificarStatusReunion()
	{
		global $con;
		$idReunion=$_POST["idReunion"];
		$fechaActual=strtotime(date("Y-m-d H:i"));
		
		$consulta="SELECT * FROM 7050_reunionesVirtualesProgramadas WHERE idRegistro=".$idReunion;
		$fReunion=$con->obtenerPrimeraFilaAsoc($consulta);
		
		echo "1|".$fReunion["situacionActual"];
		
		
	}
	
	
	function ingresarAReunion()
	{
		global $con;
		global $urlPantallaEsperaModeradorReunion;
		global $urlPaginaRedireccionJoinReunion;
		global $urlPaginaNotificacionVideoMeeting;
		global $urlPaginaNotificacionEndMeeting;
		
		$noReunion=$_POST["noReunion"];
		$cveReunion=$_POST["cveReunion"];
		$nombre=$_POST["nombre"];
		$idReunion=$_POST["idReunion"];
		
		$cButon=new cBigBlueButton();
		
		$consulta="SELECT * FROM 7050_reunionesVirtualesProgramadas WHERE idRegistro=".$idReunion;
		$fReunion=$con->obtenerPrimeraFilaAsoc($consulta);
		if(($fReunion["situacionActual"]==3)||($fReunion["situacionActual"]==4))
		{
			echo "1|".$fReunion["situacionActual"];
			return;
		}
		$consulta="SELECT * FROM 7051_participantesReunionesVirtuales WHERE idReunion=".$idReunion." AND passwdReunion='".$cveReunion."'";
		$fParticipante=$con->obtenerPrimeraFilaAsoc($consulta);
		
		$ingresar=false;
		if($fReunion["iniciarAlIngresarModerador"]==1)
		{
			
			if($fParticipante["rolParticipante"]==1)
			{

				$ingresar=true;
			}
			else
			{
				if($fReunion["moderadorIngresado"]==1)
					$ingresar=true;
			}
		}
		else
			$ingresar=true;
		
		if($ingresar)
		{	
			
			if($fReunion["meetingID"]=="")
			{

				$arrParametros=array();
				$arrParametros["name"]=$fReunion["nombreReunion"];
				$arrParametros["attendeePW"]=$fReunion["passParticipante"];
				$arrParametros["moderatorPW"]=$fReunion["passwdModerador"];
				$arrParametros["maxParticipants"]=$fReunion["maxParticipantes"];
				$arrParametros["record"]=$fReunion["permiteGrabacion"]==1?"true":"false";
				$arrParametros["duration"]=$fReunion["duracion"];
				$arrParametros["autoStartRecording"]=$fReunion["grabarAlIniciar"]==1?"true":"false";
				$arrParametros["allowStartStopRecording"]=$fReunion["permiteDetenerIniciarGrabacion"]==1?"true":"false";
				$arrParametros["webcamsOnlyForModerator"]=$fReunion["webCamSoloModerador"]==1?"true":"false";
				$arrParametros["muteOnStart"]="true"; $fReunion["silencioAlIniciar"]==1?"true":"false";
				$arrParametros["allowModsToUnmuteUsers"]=$fReunion["permitirDesSileciarParticipantes"]==1?"true":"false";
				$arrParametros["lockSettingsDisableCam"]=$fReunion["deshabilitarCamaraParticipantes"]==1?"true":"false";
				$arrParametros["lockSettingsDisableMic"]=$fReunion["deshabilitarMicrofonoParticipantes"]==1?"true":"false";
				$arrParametros["lockSettingsDisablePrivateChat"]=$fReunion["deshabilitarChatPrivado"]==1?"true":"false";
				$arrParametros["lockSettingsDisablePublicChat"]=$fReunion["deshabilitarChatPublico"]==1?"true":"false";
				$arrParametros["lockSettingsDisableNote"]=$fReunion["deshabilitarNotas"]==1?"true":"false";
				$arrParametros["meta_bbb-recording-ready-url"]=$urlPaginaNotificacionVideoMeeting."?idReunion=".$idReunion;
				$arrParametros["meta_endCallbackUrl"]=$urlPaginaNotificacionEndMeeting."?idReunion=".$idReunion;


				$resAccion=$cButon->programarReunion($arrParametros);	
				
				if($resAccion["resultado"])
				{
					$fReunion["meetingID"]=$resAccion["meetingID"];
					$consulta="UPDATE 7050_reunionesVirtualesProgramadas SET meetingID='".$resAccion["meetingID"]."' WHERE idRegistro=".$idReunion;
					$ingresar=$con->ejecutarConsulta($consulta);
				}
				else
				{
					echo "1|-1|NO SE PUDO CREAR LA REUNI&Oacute;N DEBIDO AL SIGUIENTE PROBLEMA:<BR><BR>(".$resAccion["msgKey"].") ".$resAccion["msgError"];
					return;
				}
			}
			
			if($fReunion["meetingID"]!="")
			{
				$arrParametros=array();
				$arrParametros["fullName"]=$nombre;
				$arrParametros["meetingID"]=$fReunion["meetingID"];
				$arrParametros["password"]=$fParticipante["rolParticipante"]==1?$fReunion["passwdModerador"]:$fReunion["passParticipante"];
				$arrParametros["userID"]=$fParticipante["idRegistro"];
				
				$resAccion=$cButon->compartirReunion($arrParametros);
				
				
				//$arrPaginaEnlace=explode("?",$resAccion);
				
				
				$consulta="UPDATE 7050_reunionesVirtualesProgramadas SET situacionActual=2,fechaRealInicio='".date("Y-m-d H:i:s")."'";
				if($fParticipante["rolParticipante"]==1)
				{
					$consulta.=",moderadorIngresado=1";
					$fReunion["moderadorIngresado"]=1;
				}
				$consulta.=" WHERE idRegistro=".$idReunion;
				$con->ejecutarConsulta($consulta);
				
				$arrPaginaEnlace=explode("?",$resAccion);
				$urlPantallaAudiencia=$arrPaginaEnlace[0];
				$arrParametrosReunion="";
				$aParametros=explode("&",$arrPaginaEnlace[1]);
				foreach($aParametros as $p)
				{
					$oParam=explode("=",$p);
					$o="['".$oParam[0]."','".$oParam[1]."']";
					if($arrParametrosReunion=="")
						$arrParametrosReunion=$o;
					else
						$arrParametrosReunion.=",".$o;
				}
				$urlPantallaAudiencia=$resAccion;
				
				echo "1|1|".$urlPantallaAudiencia."|[".$arrParametrosReunion."]|".$fReunion["moderadorIngresado"];
				
				/*$arrParametrosReunion="['cPagina','sFrm=true'],['url','".bE($arrPaginaEnlace[0])."'],['params','".bE($arrPaginaEnlace[1])."']";
				echo "1|1|".$urlPaginaRedireccionJoinReunion."|[".$arrParametrosReunion."]|".$fReunion["moderadorIngresado"];
				return;
				
				/*if($resAccion["resultado"])
				{
					
					$arrUrl=explode("?",$resAccion["url"]);
					$urlPantallaReunion=$arrUrl[0];

					echo "1|1|".$urlPaginaRedireccionJoinReunion."|[['sessionToken','".$resAccion["session_token"]."'],['cookie','".$resAccion["cookie"]."'],['urlPaginaReunion','".$urlPantallaReunion."']]|".$fReunion["moderadorIngresado"];;
					
				}
				else
				{
					echo "1|-1|NO SE PUDO INGRESAR A LA REUNI&Oacute;N DEBIDO AL SIGUIENTE PROBLEMA:<BR><BR>(".$resAccion["msgKey"].") ".$resAccion["msgError"];
					return;
				}*/
				/*return;
				
				varDUmp($resAccion);
				return;
				$arrPaginaEnlace=explode("?",$resAccion);
				$urlPantallaAudiencia=$arrPaginaEnlace[0];
				$arrParametrosReunion="";
				$aParametros=explode("&",$arrPaginaEnlace[1]);
				foreach($aParametros as $p)
				{
					$oParam=explode("=",$p);
					$o="['".$oParam[0]."','".$oParam[1]."']";
					if($arrParametrosReunion=="")
						$arrParametrosReunion=$o;
					else
						$arrParametrosReunion.=",".$o;
				}
				$urlPantallaAudiencia=$resAccion;
				
				echo "1|1|".$urlPantallaAudiencia."|[".$arrParametrosReunion."]";
				*/
			}
			
			
		}
		else
		{
			echo "1|".($ingresar?1:0)."|".$urlPantallaEsperaModeradorReunion."|[['cPagina','sFrm=true'],['noReunion','".$noReunion."'],['cveReunion','".$cveReunion.
						"'],['nombre','".cv($nombre)."'],['idReunion','".$idReunion."']]|".$fReunion["moderadorIngresado"];
		}
	}
	
	
	function obtenerContactosReunion()
	{
		global $con;
		
		$arrContactos="";
		$consulta="SELECT * FROM 805_contactosCorreo WHERE idUsuario=".$_SESSION["idUsr"]." ORDER BY nombreContacto";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$listaMails="";
			$arrMails="";
			$consulta="SELECT mail FROM 805_mailsContactosCorreo WHERE idContacto=".$fila[0];
			$rMails=$con->obtenerFilas($consulta);
			while($fMail=mysql_fetch_row($rMails))
			{
				if($arrMails=="")
				{
					$arrMails="['".$fMail[0]."']";
					$listaMails="&lt;".$fMail[0]."&gt;";
				}
				else
				{
					$arrMails.=",['".$fMail[0]."']";
					$listaMails.=", &lt;".$fMail[0]."&gt;";
				}
			}
			
			if($listaMails=="")
				$listaMails="&lt;Sin correo registrado&gt;";
				
				
			
			$arrTelefonos="";
			$consulta="SELECT * FROM 805_telefonosContactoCorreo WHERE idContacto=".$fila[0];
			$rTelefonos=$con->obtenerFilas($consulta);
			while($fTelefono=mysql_fetch_row($rTelefonos))
			{
				if($arrTelefonos=="")
				{
					$arrTelefonos="['".$fTelefono[2]."','".$fTelefono[3]."','".$fTelefono[4]."']";
					
				}
				else
				{
					$arrTelefonos.=",['".$fTelefono[2]."','".$fTelefono[3]."','".$fTelefono[4]."']";
					
				}
			}
			
				
			
			$oContacto='{"id":"c_'.$fila[0].'","tipo":"2","prefijo":"'.cv($fila[4]).'","puesto":"'.cv($fila[5]).'","institucion":"'.cv($fila[6]).
						'","nombreContacto":"'.cv($fila[1]).'","text":"'.cv($fila[1]).' <i>'.$listaMails.'</i>","arrMails":['.$arrMails.
						'],"arrTelefonos":['.$arrTelefonos.'],"icon":"../images/s.gif","leaf":true,children:[]}';
			if($arrContactos=="")
				$arrContactos=$oContacto;
			else	
				$arrContactos.=",".$oContacto;
		}
		$arrContactos="[".$arrContactos."]";
		
		$arrContactoGrupos="";
		$arrContactosGruposHijos="";
		$arrGrupos="";
		$consulta="SELECT * FROM 805_gruposContactosCorreo WHERE idUsuario=".$_SESSION["idUsr"]." ORDER BY nombreGrupo";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$consulta="SELECT * FROM 805_contactosCorreoGrupos WHERE idGrupo=".$fila[0];
			$rContactos=$con->obtenerFilas($consulta);
			while($fContacto=mysql_fetch_row($rContactos))
			{
				$listaMails="";
				if($fContacto[3]==1)
				{
					$consulta="SELECT Mail FROM 805_mails WHERE idUsuario=".$fContacto[2];
					$rMails=$con->obtenerFilas($consulta);
					while($fMail=mysql_fetch_row($rMails))
					{
						if($listaMails=="")
						{
							
							$listaMails="&lt;".$fMail[0]."&gt;";
						}
						else
						{
							
							$listaMails.=", &lt;".$fMail[0]."&gt;";
						}
					}
					
					if($listaMails=="")
						$listaMails="&lt;Sin correo registrado&gt;";
					$nombreContacto=obtenerNombreUsuario($fContacto[2],true);
					
				}
				else
				{
					$consulta="SELECT mail FROM 805_mailsContactosCorreo WHERE idContacto=".$fContacto[2];
					$rMails=$con->obtenerFilas($consulta);
					while($fMail=mysql_fetch_row($rMails))
					{
						if($listaMails=="")
						{
							
							$listaMails="&lt;".$fMail[0]."&gt;";
						}
						else
						{
							
							$listaMails.=", &lt;".$fMail[0]."&gt;";
						}
					}
					
					if($listaMails=="")
						$listaMails="&lt;Sin correo registrado&gt;";
					
					$consulta="SELECT nombreContacto,prefijo FROM 805_contactosCorreo WHERE idRegistro=".$fContacto[2];
					$fNombreC=$con->obtenerPrimeraFila($consulta);
					if($fNombreC[1]!="")
						$nombreContacto=trim($fNombreC[1]." ".$fNombreC[0]);
					else
						$nombreContacto=trim($fNombreC[0]);
				}
				$oContactoGrupo="['".$fContacto[2]."','".$fContacto[3]."','".cv($nombreContacto)."']";
				$oContactoGrupoHijo='{"id":"cg_'.$fContacto[2].'","tipo":"4","text":"'.cv($nombreContacto).' <i>'.$listaMails.'</i>","icon":"../images/user_gray.png","leaf":true,children:[]}';
				if($arrContactoGrupos=="")
				{
					$arrContactoGrupos=$oContactoGrupo;
					$arrContactosGruposHijos=$oContactoGrupoHijo;
				}				
				else
				{
					$arrContactoGrupos.=",".$oContactoGrupo;
					$arrContactosGruposHijos.=",".$oContactoGrupoHijo;
				}
			}
			
			$arrContactoGrupos="[".$arrContactoGrupos."]";
			
			$oContacto='{"expanded":true,"id":"g_'.$fila[0].'","tipo":"3","text":"<b>'.cv($fila[1]).'</b>","nombreGrupo":"'.cv($fila[1]).'","arrContactoGrupos":'.$arrContactoGrupos.',"icon":"../images/s.gif","leaf":false,children:['.$arrContactosGruposHijos.']}';
			if($arrGrupos=="")
				$arrGrupos=$oContacto;
			else	
				$arrGrupos.=",".$oContacto;
		}
		$arrGrupos="[".$arrGrupos."]";
		
		
		echo '[{"expanded":true,"id":"nodo_0","tipo":"0","text":"<span style=\'color:#900\'><b>Contactos</b></span>","icon":"../images/user.png","leaf":'.($arrContactos=="[]"?"true":"false").',children:'.$arrContactos.
				'},{"expanded":true,"id":"nodo_1","tipo":"1","text":"<span style=\'color:#900\'><b>Grupos</b></span>","icon":"../images/users.png","leaf":'.($arrGrupos=="[]"?"true":"false").',children:'.$arrGrupos.'}]';
		
	}	
	
	function buscarInformacionContactosMail()
	{
		global $con;
		$criterio=$_POST["criterio"];
		
		$arrRegistros="";
		$consulta="SELECT * FROM (
					SELECT idUsuario,Nombre,'1' AS tipo FROM 800_usuarios WHERE Nombre LIKE '%".$criterio."%'
					UNION 
					SELECT idRegistro AS idUsuario,nombreContacto AS Nombre,'2' AS tipo FROM 805_contactosCorreo WHERE nombreContacto LIKE '%".$criterio."%') AS tmp
					ORDER BY Nombre";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_assoc($res))
		{
			$mails="";
			switch($fila["tipo"])	
			{
				case 1:
					$consulta="SELECT Mail FROM 805_mails WHERE idUsuario=".$fila["idUsuario"];
				break;
				case 2:
					$consulta="SELECT mail FROM 805_mailsContactosCorreo WHERE idContacto=".$fila["idUsuario"];
				break;
			}
				
			$rMail=	$con->obtenerFilas($consulta);
			while($fMail=mysql_fetch_row($rMail))
			{
				if($mails=="")
					$mails="&lt;".$fMail[0]."&gt;";
				else
					$mails.=", &lt;".$fMail[0]."&gt;";
			}
			if($mails=="")
				$mails	="[Sin direcciones de correo registradas]";			
			$o='{"idContacto":"'.cv($fila["idUsuario"]).'","nombreContacto":"'.cv($fila["Nombre"]).'","tipoContacto":"'.cv($fila["tipo"]).
				'","lblTipoContacto":"'.($fila["tipo"]==1?"Usuario de sistema":"Contacto").'","mails":"'.$mails.'"}';
		
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
		}
		
		echo '{"registros":['.$arrRegistros.']}';
	}
	
	function registrarInformacionContactosMail()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		$idContacto=0;
		
		$x=0;
		$consulta[$x]="begin";
		$x++;
		if($obj->idContacto==-1)
		{
			$consulta[$x]="INSERT INTO 805_contactosCorreo(nombreContacto,idUsuario,situacion,prefijo,puesto,institucion) VALUES('".cv($obj->nombreContacto).
						"',".$_SESSION["idUsr"].",1,'".cv($obj->prefijo)."','".cv($obj->puesto)."','".cv($obj->institucion)."')";
			$x++;
			$consulta[$x]="set @idRegistro:=(select last_insert_id())";
			$x++;
		}
		else
		{
			$consulta[$x]="UPDATE 805_contactosCorreo SET nombreContacto='".cv($obj->nombreContacto)."',prefijo='".cv($obj->prefijo).
						"',puesto='".cv($obj->puesto)."',institucion='".cv($obj->institucion)."' WHERE idRegistro=".$obj->idContacto;
			$x++;
			$consulta[$x]="set @idRegistro:=".$obj->idContacto;
			$x++;
		}
		
		$consulta[$x]="DELETE FROM 805_mailsContactosCorreo WHERE idContacto=@idRegistro";
		$x++;
		
		foreach($obj->emails as $m)
		{
			$consulta[$x]="INSERT INTO 805_mailsContactosCorreo(idContacto,mail) VALUES(@idRegistro,'".cv($m->mail)."')";
			$x++;
		}
		
		$consulta[$x]="DELETE FROM 805_telefonosContactoCorreo WHERE idContacto=@idRegistro";
		$x++;
		if($obj->arrTelefonos!="")
		{
			$arrTelefonoContacto=explode(",",$obj->arrTelefonos);
			
			foreach($arrTelefonoContacto as $t)
			{
				$arrTel1=explode(") ",$t);
				
				$pais=str_replace("(","",$arrTel1[0]);
				$arrTel2=explode("-",$arrTel1[1]);
				$consulta[$x]="INSERT INTO 805_telefonosContactoCorreo(idContacto,codPais,lada,telefono) VALUES(@idRegistro,'".$pais."','".cv($arrTel2[0])."','".cv($arrTel2[1])."')";
				
				
				$x++;
			}
		}
		$consulta[$x]="commit";
		$x++;

		eB($consulta);
	}
	
	function registrarInformacionGruposMail()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$idContacto=0;
		
		$x=0;
		$consulta[$x]="begin";
		$x++;
		if($obj->idGrupo==-1)
		{
			$consulta[$x]="INSERT INTO 805_gruposContactosCorreo(nombreGrupo,idUsuario,situacion) VALUES('".cv($obj->nombreGrupo).
						"',".$_SESSION["idUsr"].",1)";
			$x++;
			$consulta[$x]="set @idRegistro:=(select last_insert_id())";
			$x++;
		}
		else
		{
			$consulta[$x]="UPDATE 805_gruposContactosCorreo SET nombreGrupo='".cv($obj->nombreGrupo)."' WHERE idGrupo=".$obj->idGrupo;
			$x++;
			$consulta[$x]="set @idRegistro:=".$obj->idGrupo;
			$x++;
		}
		
		$consulta[$x]="DELETE FROM 805_contactosCorreoGrupos WHERE idGrupo=@idRegistro";
		$x++;
		
		foreach($obj->arrContactos as $c)
		{
			$consulta[$x]="INSERT INTO 805_contactosCorreoGrupos(idGrupo,idContacto,tipoContacto)
							 VALUES(@idRegistro,".$c->idContacto.",".$c->tipoContacto.")";
			$x++;
		}
		
		$consulta[$x]="commit";
		$x++;
		eB($consulta);
	}
	
	function obtenerGruposContactosReunion()
	{
		global $con;
		$arrContactoGrupos="";
		$arrContactosGruposHijos="";
		$arrGrupos="";
		$consulta="SELECT * FROM 805_gruposContactosCorreo WHERE idUsuario=".$_SESSION["idUsr"]." ORDER BY nombreGrupo";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$consulta="SELECT * FROM 805_contactosCorreoGrupos WHERE idGrupo=".$fila[0];
			$rContactos=$con->obtenerFilas($consulta);
			while($fContacto=mysql_fetch_row($rContactos))
			{
				$listaMails="";
				if($fContacto[3]==1)
				{
					$consulta="SELECT Mail FROM 805_mails WHERE idUsuario=".$fContacto[2];
					$rMails=$con->obtenerFilas($consulta);
					while($fMail=mysql_fetch_row($rMails))
					{
						if($listaMails=="")
						{
							
							$listaMails="&lt;".$fMail[0]."&gt;";
						}
						else
						{
							
							$listaMails.=", &lt;".$fMail[0]."&gt;";
						}
					}
					
					if($listaMails=="")
						$listaMails="&lt;Sin correo registrado&gt;";
					$nombreContacto=obtenerNombreUsuario($fContacto[2],true);
					
				}
				else
				{
					$consulta="SELECT mail FROM 805_mailsContactosCorreo WHERE idContacto=".$fContacto[2];
					$rMails=$con->obtenerFilas($consulta);
					while($fMail=mysql_fetch_row($rMails))
					{
						if($listaMails=="")
						{
							
							$listaMails="&lt;".$fMail[0]."&gt;";
						}
						else
						{
							
							$listaMails.=", &lt;".$fMail[0]."&gt;";
						}
					}
					
					if($listaMails=="")
						$listaMails="&lt;Sin correo registrado&gt;";
					
					$consulta="SELECT nombreContacto,prefijo FROM 805_contactosCorreo WHERE idRegistro=".$fContacto[2];
					$fNombreC=$con->obtenerPrimeraFila($consulta);
					if($fNombreC[1]!="")
						$nombreContacto=trim($fNombreC[1]." ".$fNombreC[0]);
					else
						$nombreContacto=trim($fNombreC[0]);
				}
				$oContactoGrupo="['".$fContacto[2]."','".$fContacto[3]."','".cv($nombreContacto)."']";
				$oContactoGrupoHijo='{"id":"cg_'.$fContacto[2].'","tipo":"4","text":"'.cv($nombreContacto).' <i>'.$listaMails.'</i>","icon":"../images/user_gray.png","leaf":true,children:[]}';
				if($arrContactoGrupos=="")
				{
					$arrContactoGrupos=$oContactoGrupo;
					$arrContactosGruposHijos=$oContactoGrupoHijo;
				}				
				else
				{
					$arrContactoGrupos.=",".$oContactoGrupo;
					$arrContactosGruposHijos.=",".$oContactoGrupoHijo;
				}
			}
			
			$arrContactoGrupos="[".$arrContactoGrupos."]";
			
			$oContacto='{"expanded":true,checked:false,"id":"g_'.$fila[0].'","tipo":"3","text":"<b>'.cv($fila[1]).'</b>","nombreGrupo":"'.cv($fila[1]).'","arrContactoGrupos":'.$arrContactoGrupos.',"icon":"../images/s.gif","leaf":false,children:['.$arrContactosGruposHijos.']}';
			if($arrGrupos=="")
				$arrGrupos=$oContacto;
			else	
				$arrGrupos.=",".$oContacto;
		}
		$arrGrupos="[".$arrGrupos."]";
		
		
		echo '[{"expanded":true,"id":"nodo_1","tipo":"1","text":"<span style=\'color:#900\'><b>Grupos</b></span>","icon":"../images/users.png","leaf":'.($arrGrupos=="[]"?"true":"false").',children:'.$arrGrupos.'}]';
		
	}	
	
	
	function obtenerContactosAsociadosGrupos()
	{
		global $con;
		$listGrupos=$_POST["listGrupos"];
		$arrContactos="";
		$aContactos=array();
		$consulta="SELECT * FROM 805_contactosCorreoGrupos WHERE idGrupo in(".$listGrupos.")";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_assoc($res))
		{
			$nombre="";
			$rol="2";
			$email="";
			$telefono="";
			if($fila["tipoContacto"]==1)
			{
				$nombre=obtenerNombreUsuario($fila["idContacto"],true);
				$consulta="SELECT Mail FROM 805_mails WHERE idUsuario=".$fila["idContacto"];
				$email=$con->obtenerListaValores($consulta);
				
				$consulta="SELECT codArea,Lada,Numero FROM 804_telefonos WHERE idUsuario=".$fila["idContacto"]." AND Tipo2=2";
				$rTel=$con->obtenerFilas($consulta);
				while($fTel=mysql_fetch_assoc($rTel))
				{
					
					$t='('.($fTel["codArea"]==""?"52":$fTel["codArea"]).') '.$fTel["Lada"].'-'.$fTel["Numero"];
					if($telefono=="")
						$telefono=$t;
					else
						$telefono.=",".$t;
				}
			}
			else
			{
				$consulta="SELECT nombreContacto,prefijo FROM 805_contactosCorreo WHERE idRegistro=".$fila["idContacto"];
				$fNombreC=$con->obtenerPrimeraFila($consulta);
				if($fNombreC[1]!="")
					$nombre=trim($fNombreC[1]." ".$fNombreC[0]);
				else
					$nombre=trim($fNombreC[0]);
				
				$consulta="SELECT mail FROM 805_mailsContactosCorreo WHERE idContacto=".$fila["idContacto"];
				$email=$con->obtenerListaValores($consulta);
				
				
				$consulta="SELECT * FROM 805_telefonosContactoCorreo WHERE idContacto=".$fila["idContacto"];
				$rTel=$con->obtenerFilas($consulta);
				while($fTel=mysql_fetch_assoc($rTel))
				{
					
					$t='('.$fTel["codPais"].') '.$fTel["lada"].'-'.$fTel["telefono"];
					if($telefono=="")
						$telefono=$t;
					else
						$telefono.=",".$t;
				}
				
			}
			
			$o="['".cv($nombre)."','".$rol."','".$email."','".$telefono."','".($fila["tipoContacto"]==1?$fila["idContacto"]:-1)."','".($fila["tipoContacto"]==1?1:2)."']";
			$aContactos[$fila["idContacto"]."_".$fila["tipoContacto"]]=$o;
		}
		
		foreach($aContactos as $o)
		{
			if($arrContactos=="")
				$arrContactos=$o;
			else
				$arrContactos.=",".$o;
		}
		echo "1|[".$arrContactos."]";
		
	}
?>