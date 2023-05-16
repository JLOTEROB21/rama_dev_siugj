<?php session_start();
	include_once("conexionBDPO.php");
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
	}
	
	function verificarInicioReunion()
	{
		global $conPO;
		$idReunion=$_POST["idReunion"];
		$fechaActual=strtotime(date("Y-m-d H:i"));
		
		$consulta="SELECT * FROM 7050_reunionesVirtualesProgramadas WHERE idRegistro=".$idReunion;
		$fReunion=$conPO->obtenerPrimeraFilaAsoc($consulta);
		
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
		global $conPO;
		global $urlPantallaAccesoReunion;
		global $versionLatis;
		$meetID=$_POST["meetID"];
		$passwd=$_POST["passwd"];
		
		$consulta="SELECT * FROM 7050_reunionesVirtualesProgramadas r,7051_participantesReunionesVirtuales p WHERE r.idRegistro=p.idReunion AND
					r.reunionID='".$meetID."' AND BINARY p.passwdReunion='".$passwd."'";
		$fRegistro=$conPO->obtenerPrimeraFilaAsoc($consulta);
		
		if(!$fRegistro)
		{
			echo "1|0";
		}
		else
		{
			$consulta="select HEX(AES_ENCRYPT('".$fRegistro["reunionID"]."_".$passwd."', '".bD($versionLatis)."'))";
			$claveAcceso=$conPO->obtenerValor($consulta);
			$urlRedireccion=$urlPantallaAccesoReunion;
			echo "1|1|".$urlRedireccion."|meeting|".$claveAcceso;
		}
		
		
	}
	
	
	function verificarStatusReunion()
	{
		global $conPO;
		$idReunion=$_POST["idReunion"];
		$fechaActual=strtotime(date("Y-m-d H:i"));
		
		$consulta="SELECT * FROM 7050_reunionesVirtualesProgramadas WHERE idRegistro=".$idReunion;
		$fReunion=$conPO->obtenerPrimeraFilaAsoc($consulta);
		
		echo "1|".$fReunion["situacionActual"];
		
		
	}
	
	
	function ingresarAReunion()
	{
		global $conPO;
		global $urlPantallaEsperaModeradorReunionPO;
		global $urlPaginaRedireccionJoinReunionPO;
		global $urlPaginaNotificacionVideoMeetingPO;
		global $urlPaginaNotificacionEndMeetingPO;
		
		$noReunion=$_POST["noReunion"];
		$cveReunion=$_POST["cveReunion"];
		$nombre=$_POST["nombre"];
		$idReunion=$_POST["idReunion"];
		
		$cButon=new cBigBlueButton();
		
		$consulta="SELECT * FROM 7050_reunionesVirtualesProgramadas WHERE idRegistro=".$idReunion;
		$fReunion=$conPO->obtenerPrimeraFilaAsoc($consulta);
		if(($fReunion["situacionActual"]==3)||($fReunion["situacionActual"]==4))
		{
			echo "1|".$fReunion["situacionActual"];
			return;
		}
		$consulta="SELECT * FROM 7051_participantesReunionesVirtuales WHERE idReunion=".$idReunion." AND passwdReunion='".$cveReunion."'";
		$fParticipante=$conPO->obtenerPrimeraFilaAsoc($consulta);
		
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
				$arrParametros["meta_bbb-recording-ready-url"]=$urlPaginaNotificacionVideoMeetingPO."?idReunion=".$idReunion;
				$arrParametros["meta_endCallbackUrl"]=$urlPaginaNotificacionEndMeetingPO."?idReunion=".$idReunion;
				$resAccion=$cButon->programarReunion($arrParametros);	
				
				if($resAccion["resultado"])
				{
					$fReunion["meetingID"]=$resAccion["meetingID"];
					$consulta="UPDATE 7050_reunionesVirtualesProgramadas SET meetingID='".$resAccion["meetingID"]."' WHERE idRegistro=".$idReunion;
					$ingresar=$conPO->ejecutarConsulta($consulta);
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
				$consulta="UPDATE 7050_reunionesVirtualesProgramadas SET situacionActual=2,fechaRealInicio='".date("Y-m-d H:i:s")."'";
				if($fParticipante["rolParticipante"]==1)
				{
					$consulta.=",moderadorIngresado=1";
					$fReunion["moderadorIngresado"]=1;
				}
				$consulta.=" WHERE idRegistro=".$idReunion;
				$conPO->ejecutarConsulta($consulta);
				
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
				/*$arrPaginaEnlace=explode("?",$resAccion);
				
				$consulta="UPDATE 7050_reunionesVirtualesProgramadas SET situacionActual=2,fechaRealInicio='".date("Y-m-d H:i:s")."'";
				if($fParticipante["rolParticipante"]==1)
				{
					$consulta.=",moderadorIngresado=1";
					$fReunion["moderadorIngresado"]=1;
				}
				$consulta.=" WHERE idRegistro=".$idReunion;
				$conPO->ejecutarConsulta($consulta);
				
				
				$arrParametrosReunion="['cPagina','sFrm=true'],['url','".bE($arrPaginaEnlace[0])."'],['params','".bE($arrPaginaEnlace[1])."']";
				echo "1|1|".$urlPaginaRedireccionJoinReunionPO."|[".$arrParametrosReunion."]|".$fReunion["moderadorIngresado"];;*/
				return;
				
				/*if($resAccion["resultado"])
				{
					$consulta="UPDATE 7050_reunionesVirtualesProgramadas SET situacionActual=2";
					if($fParticipante["rolParticipante"]==1)
					{
						$consulta.=",moderadorIngresado=1";
						$fReunion["moderadorIngresado"]=1;
					}
					$consulta.=" WHERE idRegistro=".$idReunion;
					$con->ejecutarConsulta($consulta);
					$arrUrl=explode("?",$resAccion["url"]);
					$urlPantallaReunion=$arrUrl[0];

					echo "1|1|".$urlPaginaRedireccionJoinReunion."|[['sessionToken','".$resAccion["session_token"]."'],['cookie','".$resAccion["cookie"]."'],['urlPaginaReunion','".$urlPantallaReunion."']]|".$fReunion["moderadorIngresado"];;
					
				}
				else
				{
					echo "1|-1|NO SE PUDO INGRESAR A LA REUNI&Oacute;N DEBIDO AL SIGUIENTE PROBLEMA:<BR><BR>(".$resAccion["msgKey"].") ".$resAccion["msgError"];
					return;
				}*/
			}
			
			
		}
		else
		{
			echo "1|".($ingresar?1:0)."|".$urlPantallaEsperaModeradorReunionPO."|[['cPagina','sFrm=true'],['noReunion','".$noReunion."'],['cveReunion','".$cveReunion.
						"'],['nombre','".cv($nombre)."'],['idReunion','".$idReunion."']]|".$fReunion["moderadorIngresado"];
		}
	}
?>