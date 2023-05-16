<?php session_start();
	include_once("conexionBD.php");
	include_once("utiles.php");
	include_once("SIUGJ/libreriaFuncionesIntegraciones.php");
	


	$funcion="";
	if(isset($_POST["parametros"]))
		$parametros=$_POST["parametros"];
	if(isset($_POST["funcion"]))
		$funcion=$_POST["funcion"];

	
	switch($funcion)
	{
		case 1:
			obtenerPartesExpediente();
		break;
		case 2:
			buscarDatosPartesProcesales();
		break;
		case 3:
			asociarParteProcesalRegistro();
		break;
		case 4:
			obtenerInformacionParteProcesal();
		break;	
	}
	




	function obtenerPartesExpediente()
	{
		global $con;
		
		$numReg=0;
		$idActividad=$_POST["idActividad"];
		$consulta="	SELECT idRelacion,idFiguraJuridica,
					CONCAT(IF(p.nombre IS NULL,'',p.nombre),' ',IF(p.apellidoPaterno IS NULL,'',p.apellidoPaterno),' ',IF(p.apellidoMaterno IS NULL,'',p.apellidoMaterno)) AS nombre,
					id__47_tablaDinamica,p.nombre as nombreRazonSocial,apellidoPaterno,apellidoMaterno,p.idActividad FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica p WHERE r.idActividad=".$idActividad."
					AND  p.id__47_tablaDinamica=r.idParticipante ORDER BY p.nombre,p.apellidoPaterno,p.apellidoMaterno";

		$res=$con->obtenerfilas($consulta);
		$arrRegistros="";
		while($fila=$con->fetchRow($res))
		{
				
			$relacion="";
			
			$consulta="SELECT idOpcion FROM _47_personasAsocia WHERE idPadre=".$fila[3]."
						UNION
						SELECT 	idActorRelacionado FROM 7005_relacionParticipantes WHERE idActividad=".$idActividad." AND idParticipante=".$fila[3];
			$listaRelacionados=$con->obtenerListaValores($consulta);
			if($listaRelacionados!="")
			{
				$consulta="SELECT CONCAT(IF(p.nombre IS NULL,'',p.nombre),' ',IF(p.apellidoPaterno IS NULL,'',p.apellidoPaterno),' ',IF(p.apellidoMaterno IS NULL,'',p.apellidoMaterno)) AS nombre FROM
						_47_tablaDinamica p WHERE p.id__47_tablaDinamica in(".$listaRelacionados.") ORDER BY p.nombre,p.apellidoPaterno,p.apellidoMaterno";
				$resAsocia=$con->obtenerfilas($consulta);	
				while($filaAsocia=$con->fetchRow($resAsocia))
				{
					if($relacion=="")
						$relacion=$filaAsocia[0];
					else
						$relacion.="<br>".$filaAsocia[0];
				}
			}
			
			$direccion="";
			
			$domicilio=obtenerUltimoDomicilioFiguraJuridica($fila[3]);
			$oDomicilio=json_decode($domicilio);
			$direccion=$oDomicilio->lblDireccion;
			
			$permiteEditar=0;
			if($fila[7]==$idActividad)
			{
				
				$consulta="SELECT idCuentaAcceso FROM 7005_relacionFigurasJuridicasSolicitud WHERE idActividad=".$idActividad." AND idParticipante=".$fila[3];
				$idCuentaAcceso=$con->obtenerValor($consulta);
				if(($idCuentaAcceso!="")&&($idCuentaAcceso!="-1"))
				{
					$consulta="SELECT tipoCreacion FROM 800_usuarios WHERE idUsuario=".$idCuentaAcceso;
					$tipoCreacion=$con->obtenerValor($consulta);
					if($tipoCreacion==2)
						$permiteEditar=1;
				}
				else
					$permiteEditar=1;
			}
			
			
			$o='{"idParticipante":"'.$fila[0].'","nombre":"'.cv($fila[4]).'","primerApellido":"'.cv($fila[5]).'","segundoApellido":"'.cv($fila[6]).'","idRegistro":"'.$fila[3].
					'","nombreParticipante":"'.cv($fila[2]).'","figura":"'.$fila[1].'","relacion":"'.cv($relacion).'","direccion":"'.cv($direccion).
					'","permiteEditar":"'.$permiteEditar.'"}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
			
			$numReg++;
		}
		
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
	}
	
	
	function buscarDatosPartesProcesales()
	{
		global $con;
		$tipoBusqueda=$_POST["tB"];
		$valorBusqueda=$_POST["vB"];
		$tipoFigura=$_POST["iF"];
		$tipoEntidad=$_POST["tipoEntidad"];
		$esModuloExpediente=isset($_POST["esModuloExpediente"])?$_POST["esModuloExpediente"]:0;
		$esModuloExpediente=$esModuloExpediente==1;
		
		$arrFigurasRegistraduria[0]=1;
		$arrFigurasRegistraduria[2]=1;
		$arrFigurasRegistraduria[6]=1;
		$arrFigurasRegistraduria[7]=1;
		$arrFigurasRegistraduria[11]=1;
		$arrFigurasRegistraduria[16]=1;
		
		
		$consulta="SELECT * FROM _1242_tablaDinamica WHERE codigo='00001/2022'";
		$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
		$habilitarBusquedaSirna=$fRegistro["servicioHabilitado"]==1;
		
		$consulta="SELECT * FROM _1242_tablaDinamica WHERE codigo='00003/2022'";
		$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
		$habilitarBusquedaRues=$fRegistro["servicioHabilitado"]==1;
		
		
		$consulta="SELECT * FROM _1242_tablaDinamica WHERE codigo='00004/2022'";
		$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
		$habilitarBusquedaRegistraduria=false;
		
		if($tipoEntidad!=2)
		{
			$habilitarBusquedaRues=false;
		}
		

		if(($tipoFigura!=5)&&($tipoFigura!=17))
		{
			$habilitarBusquedaSirna=false;
		}
		
		if((isset($arrFigurasRegistraduria[$tipoFigura])  || $esModuloExpediente )&&($fRegistro["servicioHabilitado"]==1) && (!$habilitarBusquedaSirna))
		{
			$habilitarBusquedaRegistraduria=true;
		}
		
				
		$arrResultados=NULL;
		
		$fBusqueda=NULL;
		
		
		switch($tipoBusqueda)
		{
			
			case 0:
				$consulta="SELECT id__47_tablaDinamica as idParticipante,tipoPersona,nacionalidad,otraNacionalidad,apellidoPaterno,apellidoMaterno,fechaNacimiento,estadoCivil,tipoIdentificacion,
					folioIdentificacion,nombre,genero,esMexicano,grupoEtnico,discapacidad,tarjetaProfesional,fechaIdentificacion,tipoEntidad  FROM _47_tablaDinamica p,
					7025_datosContactoParticipante dC,7025_correosElectronico cE WHERE cE.idReferencia=dC.idRegistro AND cE.correo='".cv($valorBusqueda)."' and p.id__47_tablaDinamica=dC.idParticipante";
				$fBusqueda=$con->obtenerPrimeraFilaAsoc($consulta);
			break;
			default:
				$consulta="SELECT id__47_tablaDinamica as idParticipante,tipoPersona,nacionalidad,otraNacionalidad,apellidoPaterno,apellidoMaterno,fechaNacimiento,estadoCivil,
						tipoIdentificacion,folioIdentificacion,nombre,genero,esMexicano,grupoEtnico,discapacidad,tarjetaProfesional,fechaIdentificacion,tipoEntidad
						FROM _47_tablaDinamica WHERE tipoIdentificacion=".$tipoBusqueda.
						" AND folioIdentificacion='".cv($valorBusqueda)."'";

				$fBusqueda=$con->obtenerPrimeraFilaAsoc($consulta);
				
				
				if(!$fBusqueda)
				{
					$consulta="SELECT '-1' as idParticipante,'1' as tipoPersona,Nacionalidad as nacionalidad,'' as otraNacionalidad,
							  Paterno as apellidoPaterno,Materno as apellidoMaterno,fechaNacimiento as fechaNacimiento,'' as estadoCivil,
							  tipoIdentificacion,noIdentificacion as folioIdentificacion,Nom as nombre,Genero as genero,'0' as esMexicano,
							  grupoEtnico,discapacidad,idUsuario,'' as tarjetaProfesional,fechaExpedicionDocumento as fechaIdentificacion,
							  '' as tipoEntidad,idUsuario
							  FROM 802_identifica WHERE 
							  tipoIdentificacion=".$tipoBusqueda." AND noIdentificacion='".cv($valorBusqueda)."'";
				
					$fBusqueda=$con->obtenerPrimeraFilaAsoc($consulta);
				}
				
				
			break;
		}
		
		
		
		
		if((($tipoBusqueda==4)||($tipoBusqueda==7))&&($habilitarBusquedaSirna))
		{
			$arrResultados=buscarInformacionSirna($valorBusqueda,$tipoBusqueda==4?1:2);
			
		}
		
		if(($tipoBusqueda==4)&&($habilitarBusquedaRegistraduria))
		{
			$arrResultados=buscarInformacionRegistraduria($valorBusqueda);
		}
		

		
		if(($tipoBusqueda==14)&&($habilitarBusquedaRues))
		{
			$arrResultados=buscarInformacionRues($valorBusqueda);
			
			
			
		}
		
		$servicioUsado="";
		
		
		
		if(($fBusqueda && $tipoFigura!=0))
		{
			$objDatosParticipante='';
			foreach($fBusqueda as $clave=>$valor)
			{
				$o='"'.$clave.'":"'.cv($valor).'"';
				if($objDatosParticipante=="")
					$objDatosParticipante=$o;
				else
					$objDatosParticipante.=",".$o;
			}
			$objDatosParticipante='{'.$objDatosParticipante.'}';
			if($fBusqueda["idParticipante"]!=-1)
				$objInfo=obtenerUltimoDomicilioFiguraJuridica($fBusqueda["idParticipante"]);
			else
				$objInfo=obtenerUltimoDomicilioUsuario($fBusqueda["idUsuario"]);
			
			$situacionCedula=0;
			switch($tipoBusqueda)
			{
				case 4:
				case 7:
					$situacionCedula="";
					if($habilitarBusquedaSirna)
					{
						$servicioUsado="SIRNA";
						$situacionCedula=0;
						if($arrResultados)
						{
							if($arrResultados["Respuesta"]==2)
							{
								$situacionCedula=-1;
							}
							
							if($arrResultados["Respuesta"]==1)
							{
								$situacionCedula=$arrResultados["Estado"]=="Vigente"?"1":"2";
							}
						}
						
					}
					if(($habilitarBusquedaRegistraduria)&&($tipoBusqueda==4))
					{
						$servicioUsado="REGISTRADURIA";
						$situacionCedula=0;

						if($arrResultados)
						{
							if($arrResultados["Respuesta"]==2)
							{
								$situacionCedula=-1;
							}
							
							if($arrResultados["Respuesta"]==1)
							{
								$situacionCedula=$arrResultados["Estado"];
							}
						}
						
					}
					
				break;
				case 14:
					$situacionCedula="";
					if($habilitarBusquedaRues)
					{
						$servicioUsado="RUES";
						$situacionCedula=-1001;
						if($arrResultados)
						{
							
							if($arrResultados["Respuesta"]==2)
							{
								$situacionCedula=-1000;
								
								
							}
							
							if($arrResultados["Respuesta"]==4)
							{
								$situacionCedula=-1001;
							}
							
							if($arrResultados["Respuesta"]==1)
							{
								
								$situacionCedula=$arrResultados["Estado"]=="ACTIVA"?"-1002":"";
							}
						}
						
					}
					

				break;
				
			}
				
			$oFinalParticipante='{"servicioUsado":"'.$servicioUsado.'","esInfoWS":"0","conInformacion":"1","validaCedulaProfesional":"'.((($tipoFigura==5)||($habilitarBusquedaRues)||($habilitarBusquedaRegistraduria))?1:0).'","situacionCedula":"'.$situacionCedula.'","datosParticipante":'.$objDatosParticipante.',"datosContacto":'.$objInfo.'}';
			echo "1|1|".bE($oFinalParticipante);
			
		}
		else
		{
			
			$objDatosParticipante="{}";
			$objInfo="{}";

			switch($tipoBusqueda)
			{
				case 0:
					$consulta="SELECT '-1' as idParticipante,'1' as tipoPersona,Nacionalidad as nacionalidad,'' as otraNacionalidad,
										Paterno as apellidoPaterno,Materno as apellidoMaterno,fechaNacimiento as fechaNacimiento,'' as estadoCivil,
										tipoIdentificacion,noIdentificacion as folioIdentificacion,Nom as nombre,Genero as genero,'0' as esMexicano,
										grupoEtnico,discapacidad,p.idUsuario,'' as tarjetaProfesional,
										'' as fechaIdentificacion,'' as tipoEntidad FROM 802_identifica p,
										805_mails dC WHERE dC.idUsuario=p.idUsuario AND dC.Mail='".cv($valorBusqueda)."'";
		
					$fBusqueda=$con->obtenerPrimeraFilaAsoc($consulta);
					if($fBusqueda)
					{
						$objDatosParticipante='';
						foreach($fBusqueda as $clave=>$valor)
						{
							$o='"'.$clave.'":"'.cv($valor).'"';
							if($objDatosParticipante=="")
								$objDatosParticipante=$o;
							else
								$objDatosParticipante.=",".$o;
						}
						$objDatosParticipante='{'.$objDatosParticipante.'}';
						
					
						$consulta="SELECT * FROM 803_direcciones WHERE idUsuario=".$fBusqueda["idUsuario"]." AND Tipo=0";
						$fDireccion=$con->obtenerPrimeraFilaAsoc($consulta);
						
						
						$consulta="SELECT estado FROM 820_estados WHERE cveEstado='".$fDireccion["Estado"]."'";
						$lblEstado=$con->obtenerValor($consulta);
						
						$consulta="SELECT municipio FROM 821_municipios WHERE cveMunicipio='".$fDireccion["Municipio"]."'";
						$lblMunicipio=$con->obtenerValor($consulta);
						
						$consulta="SELECT Mail as mail FROM 805_mails WHERE idUsuario=".$fBusqueda["idUsuario"];
						$correoElectronico=$con->obtenerFilasJSON($consulta);
						
						
						$consulta="SELECT Tipo2 AS tipoTelefono,codArea AS idPais,Lada AS lada,Numero AS numero,Extension AS extension FROM 804_telefonos
									WHERE idUsuario=".$fBusqueda["idUsuario"]." and numero<>''";
						$arrTelefonos=$con->obtenerFilasJSON($consulta);
						
						$objInfo='{"calle":"'.cv($fDireccion["Calle"]).'","noExt":"'.cv($fDireccion["Numero"]).'","noInt":"'.cv($fDireccion["NumeroInt"]).
								'","colonia":"'.cv($fDireccion["Colonia"]).'","cp":"'.cv($fDireccion["CP"]).'","estado":"'.$fDireccion["Estado"].
								'","lblEstado":"'.cv($lblEstado).
								'","municipio":"'.$fDireccion["Municipio"].'","lblMunicipio":"'.cv($lblMunicipio).
								'","localidad":"","entreCalle":"","yCalle":"","referencias":"","telefonos":'.$arrTelefonos.
								',"correos":'.$correoElectronico.',"lblDireccion":""}';
						 
					
						$oFinalParticipante='{"servicioUsado":"'.$servicioUsado.'","esInfoWS":"0","conInformacion":"1","existeUsuario":"1","validaCedulaProfesional":"0","situacionCedula":"0","datosParticipante":'.$objDatosParticipante.',"datosContacto":'.$objInfo.'}';
						echo "1|1|".bE($oFinalParticipante);
						return;
					}
				break;
				case 4:
				case 7:
					
					$esInfoWS=0;
					$conInformacion=0;
					$situacionCedula=0;
					if($habilitarBusquedaSirna)
					{
						$servicioUsado="SIRNA";
						if($arrResultados["Respuesta"]==2)
						{
							$situacionCedula=-1;
							$objDatosParticipante='{"idParticipante":"0","tipoPersona":"1","nacionalidad":"","otraNacionalidad":"","apellidoPaterno":"",'.
												'"apellidoMaterno":"","fechaNacimiento":"","estadoCivil":"","tipoIdentificacion":"'.$tipoBusqueda.'","folioIdentificacion":"",'.
												'"nombre":"","genero":"","esMexicano":"","grupoEtnico":"","discapacidad":"","tarjetaProfesional":"",
												"fechaIdentificacion":"","tipoEntidad":""}';
							$objInfo='{"calle":"","noExt":"","noInt":"","colonia":"","cp":"","estado":"","lblEstado":"","municipio":"",'.
									'"lblMunicipio":"","localidad":"","entreCalle":"","yCalle":"","referencias":"","telefonos":[],"correos":[],"lblDireccion":""}';
							
						}
						
						if($arrResultados["Respuesta"]==1)
						{
							$esInfoWS=1;
							$conInformacion=1;
							$departamentoID=str_pad(($arrResultados["DepartamentoId"]*1),2,"0",STR_PAD_LEFT);
							$ciudadID=str_pad(($arrResultados["CiudadId"]*1),3,"0",STR_PAD_LEFT);
							$ciudadID=$departamentoID.$ciudadID;
							$situacionCedula=$arrResultados["Estado"]=="Vigente"?"1":"2";
							
							$correoElectronico='';
							if(($arrResultados["CorreoElectronico"]!="")&&($arrResultados["CorreoElectronico"]!="NO REGISTRA")&&($arrResultados["CorreoElectronico"]!="No registra información de correo electrónico"))
							{
								$correoElectronico='{"mail":"'.cv($arrResultados["CorreoElectronico"]).'"}';
							}
							$arrTelefonos="";
							if(($arrResultados["Celular"]!="")&&($arrResultados["Celular"]!="NO REGISTRA"))
							{
								$arrTelefonos='{"tipoTelefono":"2","lada":"","numero":"'.cv($arrResultados["Celular"]).'","extension":"","idPais":"52"}';
							}
							
		
							if(($arrResultados["Telefono"]!="")&&($arrResultados["Telefono"]!="NO REGISTRA"))
							{
								if($arrTelefonos=="")
									$arrTelefonos='{"tipoTelefono":"1","lada":"","numero":"'.cv($arrResultados["Telefono"]).'","extension":"","idPais":"52"}';
								else
									$arrTelefonos.=',{"tipoTelefono":"1","lada":"","numero":"'.cv($arrResultados["Telefono"]).'","extension":"","idPais":"52"}';
							}
							
							$arrResultados["Apellidos"]=trim(normalizarEspacios($arrResultados["Apellidos"]));
							$arrResultados["ApellidoPaterno"]=$arrResultados["Apellidos"];
							$arrResultados["ApellidoMaterno"]="";
							
							$arrPreposision=array();
							$arrPreposision[0]=" de la ";
							$arrPreposision[1]=" del ";
							$arrPreposision[2]=" de los ";
							$arrPreposision[3]=" DE LA ";
							$arrPreposision[4]=" DEL ";
							$arrPreposision[5]=" DE LOS ";
							$arrPreposision[6]="de la ";
							$arrPreposision[7]="del ";
							$arrPreposision[8]="de los ";
							$arrPreposision[9]="DE LA ";
							$arrPreposision[10]="DEL ";
							$arrPreposision[11]="DE LOS ";
							$tokenEncontrado="";

							foreach($arrPreposision as $p)
							{
								if(strpos($arrResultados["Apellidos"],$p)!==false)
								{
									$tokenEncontrado=$p;
									
									break;
								}
							}
							
							if($tokenEncontrado=="")
							{
								$arrInfoApellido=explode(" ",$arrResultados["Apellidos"]);
								if(count($arrInfoApellido)>1)
								{
									$arrResultados["ApellidoPaterno"]=$arrInfoApellido[0];
									$arrResultados["ApellidoMaterno"]=$arrInfoApellido[1];
								}
								else
								{
									$arrResultados["ApellidoPaterno"]=$arrInfoApellido[0];
								}
							}
							else
							{
								if(strpos(trim($arrResultados["Apellidos"]),$p)===0)
								{
									$cadenaAux=str_replace($tokenEncontrado,"",trim($arrResultados["Apellidos"]));
									$arrTokens=explode(" ",$cadenaAux);
									
									$arrResultados["ApellidoPaterno"]=$tokenEncontrado." ".$arrTokens[0];
									if(count($arrTokens)>1)
									{
										$arrResultados["ApellidoMaterno"]=$arrTokens[1];
									}

								}
								else
								{

									$arrTokens=explode($tokenEncontrado,$arrResultados["Apellidos"]);
									
									$arrResultados["ApellidoPaterno"]=trim($arrTokens[0]);
									$arrResultados["ApellidoMaterno"]=$tokenEncontrado." ".trim($arrTokens[1]);
									
								}
							}
							
							
							$objDatosParticipante='{"idParticipante":"0","tipoPersona":"1","nacionalidad":"","otraNacionalidad":"","apellidoPaterno":"'.cv($arrResultados["ApellidoPaterno"]).
												'","apellidoMaterno":"'.cv($arrResultados["ApellidoMaterno"]).'","fechaNacimiento":"","estadoCivil":"","tipoIdentificacion":"'.$tipoBusqueda.'","folioIdentificacion":"'.$valorBusqueda.
												'","nombre":"'.cv($arrResultados["Nombres"]).'","genero":"","esMexicano":"","grupoEtnico":"","discapacidad":"","tarjetaProfesional":"'.
												$arrResultados["NoTarjeta"].'","fechaIdentificacion":"","tipoEntidad":"2","esInfoWS":"1","conInformacion":"1"}';
							$objInfo='{"calle":"'.cv($arrResultados["Direccion"]).'","noExt":"","noInt":"","colonia":"","cp":"","estado":"'.$departamentoID.'","lblEstado":"'.cv($arrResultados["Departamento"]).
									'","municipio":"'.$ciudadID.'","lblMunicipio":"'.cv($arrResultados["Ciudad"]).
									'","localidad":"","entreCalle":"","yCalle":"","referencias":"","telefonos":['.$arrTelefonos.
									'],"correos":['.$correoElectronico.'],"lblDireccion":""}';
						}

						$oFinalParticipante='{"servicioUsado":"'.$servicioUsado.'","esInfoWS":"'.$esInfoWS.'","conInformacion":"'.$conInformacion.'","validaCedulaProfesional":"'.(($tipoFigura==5 || $tipoFigura==17)?1:0).'","situacionCedula":"'.$situacionCedula.'","datosParticipante":'.$objDatosParticipante.',"datosContacto":'.$objInfo.'}';
						echo "1|1|".bE($oFinalParticipante);
						return;
					}
					else
					{
						if(($habilitarBusquedaRegistraduria)&&($tipoBusqueda==4))
						{
							$servicioUsado="REGISTRADURIA";
							
							if($arrResultados["Respuesta"]==2)
							{
								$situacionCedula=-1;
								$objDatosParticipante='{"idParticipante":"0","tipoPersona":"1","nacionalidad":"","otraNacionalidad":"","apellidoPaterno":"",'.
													'"apellidoMaterno":"","fechaNacimiento":"","estadoCivil":"","tipoIdentificacion":"'.$tipoBusqueda.'","folioIdentificacion":"",'.
													'"nombre":"","genero":"","esMexicano":"","grupoEtnico":"","discapacidad":"","tarjetaProfesional":"",
													"fechaIdentificacion":"","tipoEntidad":"","esInfoWS":"0","conInformacion":"0"}';
								$objInfo='{"calle":"","noExt":"","noInt":"","colonia":"","cp":"","estado":"","lblEstado":"","municipio":"",'.
										'"lblMunicipio":"","localidad":"","entreCalle":"","yCalle":"","referencias":"","telefonos":[],"correos":[],"lblDireccion":""}';
								
							}
							
							if($arrResultados["Respuesta"]==1)
							{
								$esInfoWS=1;;
								$conInformacion=1;
								$departamentoID=$arrResultados["DepartamentoId"];
								$ciudadID=$arrResultados["CiudadId"];
								
								$situacionCedula=$arrResultados["Estado"];//=="Vigente"?"1":"2"
								
								$correoElectronico='';
								if(($arrResultados["CorreoElectronico"]!="")&&($arrResultados["CorreoElectronico"]!="NO REGISTRA")&&($arrResultados["CorreoElectronico"]!="No registra información de correo electrónico"))
								{
									$correoElectronico='{"mail":"'.cv($arrResultados["CorreoElectronico"]).'"}';
								}
								$arrTelefonos="";
								if(($arrResultados["Celular"]!="")&&($arrResultados["Celular"]!="NO REGISTRA"))
								{
									$arrTelefonos='{"tipoTelefono":"2","lada":"","numero":"'.cv($arrResultados["Celular"]).'","extension":"","idPais":"52"}';
								}
								
			
								if(($arrResultados["Telefono"]!="")&&($arrResultados["Telefono"]!="NO REGISTRA"))
								{
									if($arrTelefonos=="")
										$arrTelefonos='{"tipoTelefono":"1","lada":"","numero":"'.cv($arrResultados["Telefono"]).'","extension":"","idPais":"52"}';
									else
										$arrTelefonos.=',{"tipoTelefono":"1","lada":"","numero":"'.cv($arrResultados["Telefono"]).'","extension":"","idPais":"52"}';
								}
								
								$arrResultados["Apellidos"]=trim(normalizarEspacios($arrResultados["Apellidos"]));
								$arrResultados["ApellidoPaterno"]=$arrResultados["ApellidoPaterno"];
								$arrResultados["ApellidoMaterno"]=$arrResultados["ApellidoMaterno"];
								
								
								
								
								$objDatosParticipante='{"idParticipante":"0","tipoPersona":"1","nacionalidad":"","otraNacionalidad":"","apellidoPaterno":"'.cv($arrResultados["ApellidoPaterno"]).
													'","apellidoMaterno":"'.cv($arrResultados["ApellidoMaterno"]).'","fechaNacimiento":"","estadoCivil":"","tipoIdentificacion":"'.$tipoBusqueda.'","folioIdentificacion":"'.$valorBusqueda.
													'","nombre":"'.cv($arrResultados["Nombres"]).'","genero":"","esMexicano":"","grupoEtnico":"","discapacidad":"","tarjetaProfesional":"'.
													$arrResultados["NoTarjeta"].'","fechaIdentificacion":"'.$arrResultados["fechaExpedicion"].
													'","tipoEntidad":"2","fechaDefuncion":"'.$arrResultados["fechaDefuncion"].'","esInfoWS":"1","conInformacion":"1"}';
								$objInfo='{"calle":"'.cv($arrResultados["Direccion"]).'","noExt":"","noInt":"","colonia":"","cp":"","estado":"'.$departamentoID.'","lblEstado":"'.cv($arrResultados["Departamento"]).
										'","municipio":"'.$ciudadID.'","lblMunicipio":"'.cv($arrResultados["Ciudad"]).
										'","localidad":"","entreCalle":"","yCalle":"","referencias":"","telefonos":['.$arrTelefonos.
										'],"correos":['.$correoElectronico.'],"lblDireccion":"","fechaExpedicion":"'.$arrResultados["fechaExpedicion"].
										'","fechaDefuncion":"'.$arrResultados["fechaDefuncion"].'"}';
							}
							
							if($arrResultados["Respuesta"]==4)
							{
								$situacionCedula=-1001;
							}
							
							
							$oFinalParticipante='{"servicioUsado":"'.$servicioUsado.'","esInfoWS":"'.$esInfoWS.'","conInformacion":"'.$conInformacion.'","validaCedulaProfesional":"1","situacionCedula":"'.$situacionCedula.'","datosParticipante":'.$objDatosParticipante.',"datosContacto":'.$objInfo.'}';
							echo "1|1|".bE($oFinalParticipante);
							return;
						}
						else
							if($tipoBusqueda>0)
							{
								$consulta="SELECT '-1' as idParticipante,'1' as tipoPersona,Nacionalidad as nacionalidad,'' as otraNacionalidad,
											Paterno as apellidoPaterno,Materno as apellidoMaterno,fechaNacimiento as fechaNacimiento,'' as estadoCivil,
											tipoIdentificacion,noIdentificacion as folioIdentificacion,Nom as nombre,Genero as genero,'0' as esMexicano,
											grupoEtnico,discapacidad,idUsuario,'' as tarjetaProfesional,fechaExpedicionDocumento as fechaIdentificacion,
											'' as tipoEntidad
											FROM 802_identifica WHERE 
											tipoIdentificacion=".$tipoBusqueda." AND noIdentificacion='".cv($valorBusqueda)."'";
								$fBusqueda=$con->obtenerPrimeraFilaAsoc($consulta);
								
								
								
							}
							else
							{
								$consulta="SELECT '-1' as idParticipante,'1' as tipoPersona,Nacionalidad as nacionalidad,'' as otraNacionalidad,
											Paterno as apellidoPaterno,Materno as apellidoMaterno,fechaNacimiento as fechaNacimiento,'' as estadoCivil,
											tipoIdentificacion,noIdentificacion as folioIdentificacion,Nom as nombre,Genero as genero,'0' as esMexicano,
											grupoEtnico,discapacidad,p.idUsuario,'' as tarjetaProfesional,fechaExpedicionDocumento  as fechaIdentificacion,
											'' as tipoEntidad FROM 802_identifica p,
											805_mails dC WHERE dC.idUsuario=p.idUsuario AND dC.Mail='".cv($valorBusqueda)."'";
								
								$fBusqueda=$con->obtenerPrimeraFilaAsoc($consulta);
							}
					
						if($fBusqueda)
						{
							$situacionCedula=0;
							$esInfoWS=0;
							$conInformacion=1;
							$objDatosParticipante='';
							foreach($fBusqueda as $clave=>$valor)
							{
								$o='"'.$clave.'":"'.cv($valor).'"';
								if($objDatosParticipante=="")
									$objDatosParticipante=$o;
								else
									$objDatosParticipante.=",".$o;
							}
							$objDatosParticipante='{'.$objDatosParticipante.'}';
							
						
							$consulta="SELECT * FROM 803_direcciones WHERE idUsuario=".$fBusqueda["idUsuario"]." AND Tipo=0";
							$fDireccion=$con->obtenerPrimeraFilaAsoc($consulta);
							
							
							$consulta="SELECT estado FROM 820_estados WHERE cveEstado='".$fDireccion["Estado"]."'";
							$lblEstado=$con->obtenerValor($consulta);
							
							$consulta="SELECT municipio FROM 821_municipios WHERE cveMunicipio='".$fDireccion["Municipio"]."'";
							$lblMunicipio=$con->obtenerValor($consulta);
							
							$consulta="SELECT Mail as mail FROM 805_mails WHERE idUsuario=".$fBusqueda["idUsuario"];
							$correoElectronico=$con->obtenerFilasJSON($consulta);
							
							
							$consulta="SELECT Tipo2 AS tipoTelefono,codArea AS idPais,Lada AS lada,Numero AS numero,Extension AS extension FROM 804_telefonos
										WHERE idUsuario=".$fBusqueda["idUsuario"]." and numero<>''";
							$arrTelefonos=$con->obtenerFilasJSON($consulta);
							
							$objInfo='{"calle":"'.cv($fDireccion["Calle"]).'","noExt":"'.cv($fDireccion["Numero"]).'","noInt":"'.cv($fDireccion["NumeroInt"]).
									'","colonia":"'.cv($fDireccion["Colonia"]).'","cp":"'.cv($fDireccion["CP"]).'","estado":"'.$fDireccion["Estado"].
									'","lblEstado":"'.cv($lblEstado).
									'","municipio":"'.$fDireccion["Municipio"].'","lblMunicipio":"'.cv($lblMunicipio).
									'","localidad":"","entreCalle":"","yCalle":"","referencias":"","telefonos":'.$arrTelefonos.
									',"correos":'.$correoElectronico.',"lblDireccion":""}';
							 
						
							$oFinalParticipante='{"servicioUsado":"'.$servicioUsado.'","esInfoWS":"'.$esInfoWS.'","conInformacion":"'.$conInformacion.'","existeUsuario":"1","validaCedulaProfesional":"0","situacionCedula":"0","datosParticipante":'.$objDatosParticipante.',"datosContacto":'.$objInfo.'}';
							echo "1|1|".bE($oFinalParticipante);
							return;
						}
					}
				break;
				
				case 14:
					$esInfoWS=0;
					$conInformacion=0;
					if($habilitarBusquedaRues)
					{
						$servicioUsado="RUES";
						$situacionCedula=-1001;
						
						if($arrResultados["Respuesta"]==2)
						{
							$situacionCedula=-1000;
							
							$objDatosParticipante='{"idParticipante":"0","tipoPersona":"2","nacionalidad":"","otraNacionalidad":"","apellidoPaterno":"",'.
												'"apellidoMaterno":"","fechaNacimiento":"","estadoCivil":"","tipoIdentificacion":"","folioIdentificacion":"",'.
												'"nombre":"","genero":"","esMexicano":"","grupoEtnico":"","discapacidad":"","tarjetaProfesional":"",
												"fechaIdentificacion":"","tipoEntidad":"'.$tipoEntidad.'","esInfoWS":"0","conInformacion":"0"}';
							$objInfo='{"calle":"","noExt":"","noInt":"","colonia":"","cp":"","estado":"","lblEstado":"","municipio":"",'.
									'"lblMunicipio":"","localidad":"","entreCalle":"","yCalle":"","referencias":"","telefonos":[],"correos":[],"lblDireccion":""}';
							
						}
						
						if($arrResultados["Respuesta"]==4)
						{
							$situacionCedula=-1001;
							
							$objDatosParticipante='{"idParticipante":"0","tipoPersona":"2","nacionalidad":"","otraNacionalidad":"","apellidoPaterno":"",'.
												'"apellidoMaterno":"","fechaNacimiento":"","estadoCivil":"","tipoIdentificacion":"","folioIdentificacion":"",'.
												'"nombre":"","genero":"","esMexicano":"","grupoEtnico":"","discapacidad":"","tarjetaProfesional":"",
												"fechaIdentificacion":"","tipoEntidad":"'.$tipoEntidad.'","esInfoWS":"0","conInformacion":"0"}';
							$objInfo='{"calle":"","noExt":"","noInt":"","colonia":"","cp":"","estado":"","lblEstado":"","municipio":"",'.
									'"lblMunicipio":"","localidad":"","entreCalle":"","yCalle":"","referencias":"","telefonos":[],"correos":[],"lblDireccion":""}';
							
						}
						
						if($arrResultados["Respuesta"]==1)
						{
							$esInfoWS=1;
							$conInformacion=1;
							$departamentoID=str_pad(($arrResultados["DepartamentoId"]*1),2,"0",STR_PAD_LEFT);
							$ciudadID=str_pad(($arrResultados["CiudadId"]*1),3,"0",STR_PAD_LEFT);
							$ciudadID=$departamentoID.$ciudadID;
							$situacionCedula=$arrResultados["Estado"]=="ACTIVA"?"-1002":"";
							
							$correoElectronico='';
							if(($arrResultados["CorreoElectronico"]!="")&&($arrResultados["CorreoElectronico"]!="NO REGISTRA")&&($arrResultados["CorreoElectronico"]!="No registra información de correo electrónico"))
							{
								$correoElectronico='{"mail":"'.cv($arrResultados["CorreoElectronico"]).'"}';
							}
							$arrTelefonos="";
							if(($arrResultados["Celular"]!="")&&($arrResultados["Celular"]!="NO REGISTRA"))
							{
								$arrTelefonos='{"tipoTelefono":"2","lada":"","numero":"'.cv($arrResultados["Celular"]).'","extension":"","idPais":"52"}';
							}
							

							if(($arrResultados["Telefono"]!="")&&($arrResultados["Telefono"]!="NO REGISTRA"))
							{
								if($arrTelefonos=="")
									$arrTelefonos='{"tipoTelefono":"1","lada":"","numero":"'.cv($arrResultados["Telefono"]).'","extension":"","idPais":"52"}';
								else
									$arrTelefonos.=',{"tipoTelefono":"1","lada":"","numero":"'.cv($arrResultados["Telefono"]).'","extension":"","idPais":"52"}';
							}
							
							
							$objDatosParticipante='{"idParticipante":"0","tipoPersona":"2","nacionalidad":"","otraNacionalidad":"","apellidoPaterno":"'.cv($arrResultados["ApellidoPaterno"]).
												'","apellidoMaterno":"'.cv($arrResultados["ApellidoMaterno"]).'","fechaNacimiento":"","estadoCivil":"","tipoIdentificacion":"","folioIdentificacion":"","nombre":"'.
												cv($arrResultados["Nombres"]).'","genero":"","esMexicano":"","grupoEtnico":"","discapacidad":"","tarjetaProfesional":"",
												"fechaIdentificacion":"","tipoEntidad":"'.$tipoEntidad.'","esInfoWS":"1","conInformacion":"1"}';
							$objInfo='{"calle":"'.cv($arrResultados["Direccion"]).'","noExt":"","noInt":"","colonia":"","cp":"","estado":"'.$departamentoID.'","lblEstado":"'.cv($arrResultados["Departamento"]).
									'","municipio":"'.$ciudadID.'","lblMunicipio":"'.cv($arrResultados["Ciudad"]).
									'","localidad":"","entreCalle":"","yCalle":"","referencias":"","telefonos":['.$arrTelefonos.'],"correos":['.$correoElectronico.'],"lblDireccion":""}';
						}
						
						
						
						
						$oFinalParticipante='{"servicioUsado":"'.$servicioUsado.'","esInfoWS":"'.$esInfoWS.'","conInformacion":"'.$conInformacion.'","validaCedulaProfesional":"1","situacionCedula":"'.$situacionCedula.'","datosParticipante":'.$objDatosParticipante.',"datosContacto":'.$objInfo.'}';
						echo "1|1|".bE($oFinalParticipante);
						return;
					}
				break;
				default:
					$fBusqueda=NULL;
					if($tipoBusqueda>0)
					{
						$consulta="SELECT '-1' as idParticipante,'1' as tipoPersona,Nacionalidad as nacionalidad,'' as otraNacionalidad,
									Paterno as apellidoPaterno,Materno as apellidoMaterno,fechaNacimiento as fechaNacimiento,'' as estadoCivil,
									tipoIdentificacion,noIdentificacion as folioIdentificacion,Nom as nombre,Genero as genero,'0' as esMexicano,
									grupoEtnico,discapacidad,idUsuario,'' as tarjetaProfesional,fechaExpedicionDocumento as fechaIdentificacion,
									'' as tipoEntidad
									FROM 802_identifica WHERE 
									tipoIdentificacion=".$tipoBusqueda." AND noIdentificacion='".cv($valorBusqueda)."'";
						$fBusqueda=$con->obtenerPrimeraFilaAsoc($consulta);
						
						
						
					}
					else
					{
						$consulta="SELECT '-1' as idParticipante,'1' as tipoPersona,Nacionalidad as nacionalidad,'' as otraNacionalidad,
									Paterno as apellidoPaterno,Materno as apellidoMaterno,fechaNacimiento as fechaNacimiento,'' as estadoCivil,
									tipoIdentificacion,noIdentificacion as folioIdentificacion,Nom as nombre,Genero as genero,'0' as esMexicano,
									grupoEtnico,discapacidad,p.idUsuario,'' as tarjetaProfesional,fechaExpedicionDocumento  as fechaIdentificacion,
									'' as tipoEntidad FROM 802_identifica p,
									805_mails dC WHERE dC.idUsuario=p.idUsuario AND dC.Mail='".cv($valorBusqueda)."'";
						
						$fBusqueda=$con->obtenerPrimeraFilaAsoc($consulta);
					}
					
				  if($fBusqueda)
				  {
					  $situacionCedula=0;
					  $esInfoWS=0;
					  $conInformacion=1;
					  $objDatosParticipante='';
					  foreach($fBusqueda as $clave=>$valor)
					  {
						  $o='"'.$clave.'":"'.cv($valor).'"';
						  if($objDatosParticipante=="")
							  $objDatosParticipante=$o;
						  else
							  $objDatosParticipante.=",".$o;
					  }
					  $objDatosParticipante='{'.$objDatosParticipante.'}';
					  
				  
					  $consulta="SELECT * FROM 803_direcciones WHERE idUsuario=".$fBusqueda["idUsuario"]." AND Tipo=0";
					  $fDireccion=$con->obtenerPrimeraFilaAsoc($consulta);
					  
					  
					  $consulta="SELECT estado FROM 820_estados WHERE cveEstado='".$fDireccion["Estado"]."'";
					  $lblEstado=$con->obtenerValor($consulta);
					  
					  $consulta="SELECT municipio FROM 821_municipios WHERE cveMunicipio='".$fDireccion["Municipio"]."'";
					  $lblMunicipio=$con->obtenerValor($consulta);
					  
					  $consulta="SELECT Mail as mail FROM 805_mails WHERE idUsuario=".$fBusqueda["idUsuario"];
					  $correoElectronico=$con->obtenerFilasJSON($consulta);
					  
					  
					  $consulta="SELECT Tipo2 AS tipoTelefono,codArea AS idPais,Lada AS lada,Numero AS numero,Extension AS extension FROM 804_telefonos
								  WHERE idUsuario=".$fBusqueda["idUsuario"]." and numero<>''";
					  $arrTelefonos=$con->obtenerFilasJSON($consulta);
					  
					  $objInfo='{"calle":"'.cv($fDireccion["Calle"]).'","noExt":"'.cv($fDireccion["Numero"]).'","noInt":"'.cv($fDireccion["NumeroInt"]).
							  '","colonia":"'.cv($fDireccion["Colonia"]).'","cp":"'.cv($fDireccion["CP"]).'","estado":"'.$fDireccion["Estado"].
							  '","lblEstado":"'.cv($lblEstado).
							  '","municipio":"'.$fDireccion["Municipio"].'","lblMunicipio":"'.cv($lblMunicipio).
							  '","localidad":"","entreCalle":"","yCalle":"","referencias":"","telefonos":'.$arrTelefonos.
							  ',"correos":'.$correoElectronico.',"lblDireccion":""}';
					   
				  
					  $oFinalParticipante='{"servicioUsado":"'.$servicioUsado.'","esInfoWS":"'.$esInfoWS.'","conInformacion":"'.$conInformacion.'","existeUsuario":"1","validaCedulaProfesional":"0","situacionCedula":"0","datosParticipante":'.$objDatosParticipante.',"datosContacto":'.$objInfo.'}';
					  echo "1|1|".bE($oFinalParticipante);
					  return;
				  }
				break;					
				
			}
			echo "1|0";
		}
		
	}
	
	function asociarParteProcesalRegistro()
	{
		global $con;
		$iA=$_POST["iA"];
		$iP=$_POST["iP"];
		$iF=$_POST["iF"];
		
		$consulta="SELECT COUNT(*) FROM 7005_relacionFigurasJuridicasSolicitud WHERE idActividad=".$iA." AND idParticipante=".$iP." AND idFiguraJuridica=".$iF;
		$numReg=$con->obtenerValor($consulta);
		if($numReg==0)
		{
			$consulta="SELECT idCuentaAcceso FROM 7005_relacionFigurasJuridicasSolicitud WHERE idParticipante=".$iP;
			$idCuentaAcceso=$con->obtenerValor($consulta);
			if($idCuentaAcceso=="")
				$idCuentaAcceso="NULL";
			$consulta="INSERT INTO 7005_relacionFigurasJuridicasSolicitud(idActividad,idParticipante,idFiguraJuridica,situacion,idCuentaAcceso,etapaProcesal,situacionProcesal,cuentaAccesoGenerica)
					VALUES(".$iA.",".$iP.",".$iF.",1,".$idCuentaAcceso.",1,1,0)";
			$con->ejecutarConsulta($consulta);
			echo "1|".$iP."|".$iA."|".$iF;
			return;
		}
		echo "1|".$iP."|".$iA."|".$iF;
		
		
		
	}
	
	
	function obtenerInformacionParteProcesal()
	{
		global	 $con;
		$idParticipante=$_POST["idParticipante"];
		$tipoFigura=$_POST["figuraJuridica"];
		
		$consulta="SELECT id__47_tablaDinamica as idParticipante,tipoPersona,nacionalidad,otraNacionalidad,apellidoPaterno,apellidoMaterno,fechaNacimiento,estadoCivil,
						tipoIdentificacion,folioIdentificacion,nombre,genero,esMexicano,grupoEtnico,discapacidad,tarjetaProfesional,fechaIdentificacion,tipoEntidad
						FROM _47_tablaDinamica WHERE id__47_tablaDinamica=".$idParticipante;

		$fBusqueda=$con->obtenerPrimeraFilaAsoc($consulta);
		
		
		$tipoBusqueda=$fBusqueda["tipoIdentificacion"];
		$objDatosParticipante='';
		foreach($fBusqueda as $clave=>$valor)
		{
			$o='"'.$clave.'":"'.cv($valor).'"';
			if($objDatosParticipante=="")
				$objDatosParticipante=$o;
			else
				$objDatosParticipante.=",".$o;
		}
		$objDatosParticipante='{'.$objDatosParticipante.'}';
		$objInfo=obtenerUltimoDomicilioFiguraJuridica($idParticipante);
		$situacionCedula=0;
		
		$consulta="SELECT * FROM _1242_tablaDinamica WHERE codigo='00001/2022'";
		$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
		$habilitarBusquedaSirna=$fRegistro["servicioHabilitado"]==1;
		
		$consulta="SELECT * FROM _1242_tablaDinamica WHERE codigo='00003/2022'";
		$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
		$habilitarBusquedaRues=$fRegistro["servicioHabilitado"]==1;

		if(($fBusqueda["tipoEntidad"]!=2)&&($fBusqueda["tipoPersona"]==2))
		{
			$habilitarBusquedaRues=false;
		}
		

		if(($tipoFigura!=5)&&($tipoFigura!=17))
		{
			$habilitarBusquedaSirna=false;
		}
		
		if(($tipoFigura==0)&&($fRegistro["servicioHabilitado"]==1))
		{
			$habilitarBusquedaRegistraduria=true;
		}

		$validaCedulaProfesional=0;


		$habilitarBusquedaRues=false;
		$habilitarBusquedaRegistraduria=false;
		$arrResultados=NULL;
		
		if((($tipoBusqueda==4)||($tipoBusqueda==7))&&($habilitarBusquedaSirna))
		{
			$validaCedulaProfesional=1;
			$arrResultados=buscarInformacionSirna($fBusqueda["folioIdentificacion"],$tipoBusqueda==4?1:2);
			
			
		}
		
		if(($tipoBusqueda==4)&&($habilitarBusquedaRegistraduria))
		{
			$validaCedulaProfesional=1;
			$arrResultados=buscarInformacionRegistraduria($fBusqueda["folioIdentificacion"]);

			
			
		}
		

		
		if(($tipoBusqueda==14)&&($habilitarBusquedaRues))
		{
			$validaCedulaProfesional=1;
			$arrResultados=buscarInformacionRues($fBusqueda["folioIdentificacion"]);
			
			
		}
		
		
		$situacionCedula=0;
		switch($tipoBusqueda)
		{
			case 4:
			case 7:
				$situacionCedula="";
				if($habilitarBusquedaSirna)
				{
					$situacionCedula=0;
					if($arrResultados)
					{
						if($arrResultados["Respuesta"]==2)
						{
							$situacionCedula=-1;
						}
						
						if($arrResultados["Respuesta"]==1)
						{
							$situacionCedula=$arrResultados["Estado"]=="Vigente"?"1":"2";
						}
					}
					
				}
				if($habilitarBusquedaRegistraduria)
				{
					$situacionCedula=0;
					if($arrResultados)
					{
						if($arrResultados["Respuesta"]==2)
						{
							$situacionCedula=-1;
						}
						
						if($arrResultados["Respuesta"]==1)
						{
							$situacionCedula=$arrResultados["Estado"];
						}
					}
					
				}
				
			break;
			case 14:
				$situacionCedula="";
				if($habilitarBusquedaRues)
				{
					$situacionCedula=-1001;
					if($arrResultados)
					{
						
						if($arrResultados["Respuesta"]==2)
						{
							$situacionCedula=-1000;
							
							
						}
						
						if($arrResultados["Respuesta"]==4)
						{
							$situacionCedula=-1001;
						}
						
						if($arrResultados["Respuesta"]==1)
						{
							
							$situacionCedula=$arrResultados["Estado"]=="ACTIVA"?"-1002":"";
						}
					}
					
				}
				

			break;
			
		}
		
		
		
		
		$oFinalParticipante='{"esInfoWS":"0","conInformacion":"0","validaCedulaProfesional":"'.$validaCedulaProfesional.'","situacionCedula":"'.
							$situacionCedula.'","datosParticipante":'.$objDatosParticipante.',"datosContacto":'.$objInfo.'}';
		echo "1|1|".bE($oFinalParticipante);
			
	}
		
?>
