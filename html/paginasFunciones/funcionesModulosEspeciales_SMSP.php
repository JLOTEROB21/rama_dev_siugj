<?php session_start();
	;
	include("funcionesFormularios.php"); 
	include("configurarIdioma.php");
	include_once("cfdi/cFactura.php");
	
	
	if(isset($_POST["parametros"]))
		$parametros=$_POST["parametros"];
	if(isset($_POST["funcion"]))
		$funcion=$_POST["funcion"];
	$lenguaje=$_SESSION["leng"];
	
	switch($funcion)
	{
		case 1:
			registrarInstitucion();
		break;
		case 2:
			registrarUsuarioPortal();
		break;
		case 3:
			actualizarUsuarioPortal();
		break;
		case 4:
			obtenerInformacionInstituciones();
		break;
		case 5:
			actualizarDatosIntitucion();
		break;
		case 6:
			autorizarInstitucion();
		break;
		case 7:
			reemplazarInstitucion();
		break;
		case 8:
			registrarDatosParticipante();
		break;
		case 9:
			registrarDatosRevisor();
		break;
		case 10:
			registrarAsociacionRevisorProyecto();
		break;
		case 11:
			obtenerRevisoresAsociadosProyecto();
		break;
		case 12:
			removerAsociacionRevisorProyecto();
		break;
		case 13:
			obtenerSituacionRevisoresProyectos();
		break;
		
	}
	
	
	function registrarInstitucion()
	{
		global $con;
		global $lPorcionCodFun;
		$cadObj=$_POST["param"];
		$obj=json_decode($cadObj);
		$codigoUPadre=$obj->codigoUPadre;

		$tamUnidad=4;
		
		$codUnidad="";
		if(isset($obj->codUnidad))
			$codUnidad=$obj->codUnidad;
		
		$telefonos="";
		if(isset($obj->telefonos))
		{
			$telefonos=$obj->telefonos;
		}
		
		$idUsuario="-1000";
		if(isset($_SESSION["idUsr"]))
			$idUsuario=$_SESSION["idUsr"];
		
		$query="select codigoFuncional from 817_organigrama where codigoUnidad='".$codigoUPadre."'";
		$codigoF=$con->obtenerValor($query);
		$codigoFuncionalNuevo="";
		$codigoUnidadNuevo="";
		$x=0;
		$cadComodines=str_pad("",$lPorcionCodFun,'_',STR_PAD_LEFT);
		$codigoInicial=str_pad("1",$lPorcionCodFun,'0',STR_PAD_LEFT);
		$query="begin";
		if($con->ejecutarConsulta($query))
		{
			if($codUnidad=="")
			{
				
				$query="SELECT max(codigoUnidad) FROM 817_organigrama WHERE unidadPadre='".$codigoUPadre."'";

				$res=$con->obtenerValor($query);
				
				if($res!="")
				{
					$res++;
					$numUnidades=parteEntera(strlen($res)/$tamUnidad);

					if((sizeof($res)%$tamUnidad)!=0)
					{
						$numUnidades++;
					}
					
					$codigoUnidadNuevo=str_pad($res,($tamUnidad*$numUnidades),'0',STR_PAD_LEFT);
				}
				else
				{
					$valor=1;	
					$codigoFuncionalNuevo=str_pad($valor,$tamUnidad,'0',STR_PAD_LEFT);
					$codigoUnidadNuevo=$codigoUPadre.$codigoFuncionalNuevo;
				}
				
				$codigoIndividual=substr($codigoUnidadNuevo,strlen($codigoUnidadNuevo)-$tamUnidad);
				
				$codCC="";
				if(isset($obj->CC))
					$codCC=$obj->CC;
				
				$query="insert into 817_organigrama(unidad,codigoFuncional,codigoUnidad,descripcion,institucion,codCentroCosto,unidadPadre,codigoIndividual,nuevoRegistro) 
						value('".cv($obj->nombre)."','".$codigoUnidadNuevo."','".$codigoUnidadNuevo."','".cv($obj->descripcion)."',".$obj->institucion.",'".$codCC."','".$codigoUPadre."','".$codigoIndividual."',1)";
				if($con->ejecutarConsulta($query))		
				{
					$idOrganigrama=$con->obtenerUltimoID();
					if(isset($obj->objInst))
					{
						$objInst=$obj->objInst;
						$consulta[$x]="insert into 247_instituciones(idOrganigrama,cp,ciudad,estado,idPais,fechaCreacion,responsable,calle,numero,numeroExt,colonia) values
						('".$idOrganigrama."','".cv($objInst->cp)."','".cv($objInst->municipio)."','".cv($objInst->estado)."',".cv($objInst->pais).",'".date("Y-m-d")."',".$idUsuario.
						",'".cv($obj->calle)."','".cv($obj->noInt)."','".cv($obj->noExt)."','".cv($obj->colonia)."')";
						$x++;	
					}
					
					if($telefonos!="")
					{
						$arrTelefonos=explode(",",$telefonos);
						$nTel=sizeof($arrTelefonos);
						for($y=0;$y<$nTel;$y++)
						{
							$datosTel=explode("_",$arrTelefonos[$y]);
							$tipo=$datosTel[0];
							$codArea=$datosTel[1];
							$lada=$datosTel[2];
							$tel=$datosTel[3];
							$ext=$datosTel[4];
							$consulta[$x]="	insert into 818_telefonosOrganigrama(codArea,lada,telefono,extension,tipoTel,idOrganigrama) 
											values('".$codArea."','".$lada."','".$tel."','".$ext."',".$tipo.",".$idOrganigrama.")";
							$x++;	
						}
					}
					$consulta[$x]="commit";
					$x++;
					if($con->ejecutarBloque($consulta))
					{
							$consulta="SELECT codigoUnidad,unidad FROM 817_organigrama WHERE unidadPadre='".$codigoUPadre."' ORDER BY status desc,unidad";
							$arrInstituciones=$con->obtenerFilasArreglo($consulta);
							$objDatos='{"arrInstituciones":'.$arrInstituciones.',"idInstitucion":"'.$codigoUnidadNuevo.'"}';
							echo "1|".$objDatos;
						
					}
						
					else
						echo "|";
				}
			}
			else
			{
				$codCC="";
				if(isset($obj->CC))
					$codCC=$obj->CC;
				$x=0;
				$consulta[$x]="update 817_organigrama set unidad='".cv($obj->nombre)."', descripcion='".cv($obj->descripcion)."',codCentroCosto='".$codCC."' where codigoUnidad='".$codUnidad."'";
				$x++;
				$query="select idOrganigrama from 817_organigrama where codigoUnidad='".$codUnidad."'" ;
				$idOrganigrama=$con->obtenerValor($query);
				$consulta[$x]="	delete from 818_telefonosOrganigrama where idOrganigrama=".$idOrganigrama;
				$x++;		
				if($telefonos!="")
				{
					$arrTelefonos=explode(",",$telefonos);
					$nTel=sizeof($arrTelefonos);
					for($y=0;$y<$nTel;$y++)
					{
						$datosTel=explode("_",$arrTelefonos[$y]);
						$tipo=$datosTel[0];
						$codArea=$datosTel[1];
						$lada=$datosTel[2];
						$tel=$datosTel[3];
						$ext=$datosTel[4];
						$consulta[$x]="	insert into 818_telefonosOrganigrama(codArea,lada,telefono,extension,tipoTel,idOrganigrama) 
										values('".$codArea."','".$lada."','".$tel."','".$ext."',".$tipo.",".$idOrganigrama.")";
						$x++;										
							
					}
				}
				
				if(isset($obj->objInst))
				{
					$objInst=$obj->objInst;
					
					$consulta[$x]="update 247_instituciones set cp='".cv($objInst->cp)."',ciudad='".cv($objInst->ciudad)."',estado='".cv($objInst->estado)."',idPais=".$objInst->idPais.
									", calle='".cv($obj->calle)."',numero='".cv($obj->noInt)."',numeroExt='".cv($obj->noExt)."',colonia='".cv($obj->colonia)."' 
									where idOrganigrama=".$idOrganigrama;
					$x++;
					$consulta[$x]="commit";
					if($con->ejecutarBloque($consulta))
						echo "1|".$idOrganigrama;
					else
						echo "|";
				}
				else
				{
					$consulta[$x]="commit";
					if($con->ejecutarBloque($consulta))
						echo "1|".$idOrganigrama;
					else
						echo "|";
				}
			}
		}
		else
			echo "|";
	}
	
	function registrarUsuarioPortal()
	{
		global $con;
		global $mostrarXML;
		global $urlSitio;
		
		
		$cadObjJson=$_POST["cadObj"];
		
		$objJson=json_decode($cadObjJson);
		
		$mail=$objJson->email;
		
		$query="SELECT COUNT(*) FROM 805_mails WHERE Mail='".cv($mail)."'";
		$nReg=$con->obtenerValor($query);
		if($nReg>0)
		{
			echo "1|2";
			return;
		}
		
		if($objJson->emailAlterno!="")
		{
			$mail.=",".$objJson->emailAlterno;
		}
		$idUsuario=crearBaseUsuario($objJson->apPaterno,$objJson->txtApMaterno,$objJson->nombre,$mail,$objJson->institucion,$objJson->departamento,$roles="-1000,115");
		
		
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="UPDATE 802_identifica SET Prefijo='".cv($objJson->titulo)."',Genero='".$objJson->sexo."' WHERE idUsuario=".$idUsuario;
		$x++;
		$consulta[$x]="UPDATE 803_direcciones SET tipo=0, Calle='".cv($objJson->calle)."',Numero='".cv($objJson->noInt)."',Colonia='".cv($objJson->colonia)."',Municipio='".cv($objJson->municipio).
					"',CP=".($objJson->cp==""?"NULL":$objJson->cp).",Pais='".cv($objJson->pais)."',noExt='".cv($objJson->noExt)."',Estado='".cv($objJson->estado)."' WHERE idUsuario=".$idUsuario;
		$x++;
		$consulta[$x]="UPDATE 800_usuarios SET Login='".$objJson->email."',PASSWORD='".$objJson->passwd."',cambiarDatosUsr=0 WHERE idUsuario=".$idUsuario;
		$x++;
		
		$consulta[$x]="delete from 804_telefonos where idUsuario=".$idUsuario;
		$x++;
		
		if(sizeof($objJson->arrTelefonos)>0)
		{
			foreach($objJson->arrTelefonos as $o)
			{
				$consulta[$x]="INSERT INTO 804_telefonos(Lada,Numero,Extension,Tipo,Tipo2,idUsuario) VALUES('".$o->lada."','".$o->telefono."','".$o->extension."',0,".$o->tipoTelefono.",".$idUsuario.")";
				$x++;
			}
		}
		$consulta[$x]="commit";
		$x++;
		
		if($con->ejecutarBloque($consulta))		
		{
			$link="<a href='".$urlSitio."/registroUsuario/activaCuenta.php?cta=".base64_encode("cuenta:".$idUsuario)."'>".$urlSitio."/registroUsuario/activaCuenta.php?cta=".base64_encode("cuenta:".$idUsuario)."</a>";
			$arrParametros["idUsuario"]=$idUsuario;
			$arrParametros["link"]=$link;
			@enviarMensajeEnvio(6,$arrParametros);
			echo "1|";
		}
		else
			echo "|";
	}
	
	
	function actualizarUsuarioPortal()
	{
		global $con;
		global $mostrarXML;
		global $urlSitio;
		
		
		$cadObjJson=$_POST["cadObj"];
		
		$objJson=json_decode($cadObjJson);
		$idUsuario=$objJson->idUsuario;
		$mail=$objJson->email;
		
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="UPDATE 802_identifica SET Prefijo='".cv($objJson->titulo)."',Genero='".$objJson->sexo."',Paterno='".cv($objJson->apPaterno)."',Materno='".cv($objJson->txtApMaterno).
					"',Nom='".cv($objJson->nombre)."',Genero='".$objJson->sexo."' WHERE idUsuario=".$idUsuario;
		$x++;
		$consulta[$x]="UPDATE 803_direcciones SET tipo=0, Calle='".cv($objJson->calle)."',Numero='".cv($objJson->noInt)."',Colonia='".cv($objJson->colonia)."',Municipio='".cv($objJson->municipio).
					"',CP=".($objJson->cp==""?"NULL":$objJson->cp).",Pais='".cv($objJson->pais)."',noExt='".cv($objJson->noExt)."',Estado='".cv($objJson->estado)."' WHERE idUsuario=".$idUsuario;
		$x++;
		$consulta[$x]="UPDATE 800_usuarios SET PASSWORD='".$objJson->passwd."',cambiarDatosUsr=0 WHERE idUsuario=".$idUsuario;
		$x++;
		$consulta[$x]="UPDATE 801_adscripcion SET Institucion='".$objJson->institucion."',codigoUnidad='".$objJson->departamento."' WHERE idUsuario=".$idUsuario;
		$x++;
		$consulta[$x]="DELETE FROM 805_mails WHERE idUsuario=".$idUsuario;
		$x++;
		
		$consulta[$x]="INSERT INTO 805_mails(Mail,Tipo,Notificacion,idUsuario) VALUES('".$objJson->email."',1,1,".$idUsuario.")";
		$x++;
		if($objJson->emailAlterno!="")
		{
			$consulta[$x]="INSERT INTO 805_mails(Mail,Tipo,Notificacion,idUsuario) VALUES('".$objJson->emailAlterno."',1,1,".$idUsuario.")";
			$x++;
		}
		
		
		$consulta[$x]="delete from 804_telefonos where idUsuario=".$idUsuario;
		$x++;
		
		if(sizeof($objJson->arrTelefonos)>0)
		{
			foreach($objJson->arrTelefonos as $o)
			{
				$consulta[$x]="INSERT INTO 804_telefonos(Lada,Numero,Extension,Tipo,Tipo2,idUsuario) VALUES('".$o->lada."','".$o->telefono."','".$o->extension."',0,".$o->tipoTelefono.",".$idUsuario.")";
				$x++;
			}
		}
		
		$consulta[$x]="commit";
		$x++;
		
		if($con->ejecutarBloque($consulta))		
		{
			echo "1|";
		}
		else
			echo "|";
	}
	
	function obtenerInformacionInstituciones()
	{
		global $con;
		$nuevoRegistro=$_POST["nuevoRegistro"];
		$busquedaCoincidencia=$_POST["busquedaCoincidencia"];
		$nombreInstitucion="";
		if($busquedaCoincidencia==1)
			$nombreInstitucion=$_POST["nombreInstitucion"];
		$consulta="SELECT o.idOrganigrama,codigoUnidad,unidad AS institucion,i.calle,numero AS noInt,numeroExt AS noExt,cp,idPais AS pais,colonia,estado,municipio 
					FROM 817_organigrama o,247_instituciones i WHERE  i.idOrganigrama=o.idOrganigrama and o.unidadPadre='0001' and status=1 and o.nuevoRegistro=".$nuevoRegistro;
					
		if($busquedaCoincidencia==1)			
		{
			$consulta.=" and  Match(unidad) against('".cv($nombreInstitucion)."')";
		}
					
		$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));					
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrRegistros.'}';			
		
	}
	
	function actualizarDatosIntitucion()
	{
		global $con;
		$cadObj=$_POST["param"];
		$obj=json_decode($cadObj);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		$consulta[$x]="UPDATE 817_organigrama SET unidad='".cv($obj->nombre)."' WHERE idOrganigrama=".$obj->idOrganigrama;
		$x++;
		$idOrganigrama=$obj->idOrganigrama;
		$obj=$obj->objInst;
		$consulta[$x]="UPDATE 247_instituciones SET calle='".cv($obj->calle)."',numero='".cv($obj->noInt)."',numeroExt='".cv($obj->noExt)."',colonia='".cv($obj->colonia).
					"',cp=".($obj->cp==""?"NULL":$obj->cp).",idPais=".cv($obj->pais).",estado='".cv($obj->estado)."',municipio='".cv($obj->municipio)."' WHERE idOrganigrama=".$idOrganigrama;
		$x++;
		$consulta[$x]="commit";
		$x++;

		eB($consulta);
		
	}
	
	function autorizarInstitucion()
	{
		global $con;
		$idOrganigrama=$_POST["idOrganigrama"];
		$consulta="UPDATE 817_organigrama SET nuevoRegistro=0 WHERE idOrganigrama=".$idOrganigrama;
		eC($consulta);
	}
	
	function reemplazarInstitucion()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		
		$consulta="SELECT codigoUnidad FROM 817_organigrama WHERE idOrganigrama=".$obj->origen;

		$codigoOrigen=$con->obtenerValor($consulta);
		
		$consulta="SELECT codigoUnidad FROM 817_organigrama WHERE idOrganigrama=".$obj->destino;
		$codigoDestino=$con->obtenerValor($consulta);
		
		$x=0;
		$query[$x]="begin";
		$x++;
		$query[$x]="UPDATE 801_adscripcion SET Institucion='".$codigoOrigen."' WHERE Institucion='".$codigoDestino."'";
		$x++;
		$query[$x]="UPDATE _541_tablaDinamica SET institucion='".$codigoOrigen."' WHERE institucion='".$codigoDestino."'";
		$x++;
		$query[$x]="UPDATE 817_organigrama SET STATUS=0 WHERE idOrganigrama=".$obj->destino;
		$x++;
		$query[$x]="UPDATE 817_organigrama SET STATUS=1 WHERE idOrganigrama=".$obj->origen;
		$x++;
		$query[$x]="commit";
		$x++;	
		eB($query);
	}
	
	
	function registrarDatosParticipante()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		$x=0;
		$consulta[$x]="begin";
		$x++;
		if($obj->idParticipante==-1)
		{
			$consulta[$x]="INSERT INTO 1053_participantesTrabajo(apPaterno,apMaterno,nombre,email,emailAlterno,codigoInstitucion,idUsuario) 
						VALUES('".cv($obj->apPaterno)."','".cv($obj->apMaterno)."','".cv($obj->nombre)."','".cv($obj->emailContacto)."','".
						cv($obj->emailAlterno)."','".cv($obj->institucion)."',".$obj->idUsuario.")";
			$x++;
			
			$consulta[$x]="set @idRegistro:=(select last_insert_id())";
			$x++;
		}
		else
		{
			if($obj->idParticipante>0)
			{
				$consulta[$x]="update 1053_participantesTrabajo set apPaterno='".cv($obj->apPaterno)."',apMaterno='".cv($obj->apMaterno)."',nombre='".cv($obj->nombre).
							"',email='".cv($obj->emailContacto)."',emailAlterno='".cv($obj->emailAlterno)."' where idRegistro=".$obj->idParticipante;
				$x++;
			}
			else
			{
				$consulta[$x]="UPDATE 802_identifica SET Paterno='".cv($obj->apPaterno)."',Materno='".cv($obj->apMaterno)."',Nom='".cv($obj->nombre)."' WHERE idUsuario=".abs($obj->idParticipante);
				$x++;
				$consulta[$x]="UPDATE 801_adscripcion SET Institucion='".cv($obj->institucion)."' WHERE idUsuario=".abs($obj->idParticipante);
				$x++;
				$consulta[$x]="DELETE FROM 805_mails WHERE idUsuario=".abs($obj->idParticipante);
				$x++;
				$consulta[$x]="INSERT INTO 805_mails(Mail,Tipo,Notificacion,idUsuario) VALUES('".cv($obj->emailContacto)."',1,1,".abs($obj->idParticipante).")";
				$x++;
				if($obj->emailAlterno!="")
				{
					$consulta[$x]="INSERT INTO 805_mails(Mail,Tipo,Notificacion,idUsuario) VALUES('".cv($obj->emailAlterno)."',1,1,".abs($obj->idParticipante).")";
					$x++;
				}
			}

			$consulta[$x]="set @idRegistro:=".$obj->idParticipante;
			$x++;
		}
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
		{
			$query="select @idRegistro";
			$idRegistro=$con->obtenerValor($query);
			$query="SELECT idRegistro,nombre,apPaterno,apMaterno,nom,email,emailAlterno,(select unidad from 817_organigrama where codigoUnidad=v.codigoInstitucion) as institucion FROM 1053_vistaParticipantes v WHERE idUsuarioRegistro='".$obj->idUsuario."' ORDER BY apPaterno,apMaterno,nombre";
			$arrParticipantes=$con->obtenerFilasArreglo($query);
			echo "1|".$arrParticipantes."|".$idRegistro;
		}
		
		
	}
	
	function registrarDatosRevisor()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		$x=0;
		$consulta[$x]="begin";
		$x++;
		
		
		
		
			
		if($obj->idUsuario==-1)
		{
			$obj->idUsuario=crearBaseUsuario($obj->apPaterno,$obj->apMaterno,$obj->nombre,($obj->email.",".$obj->email2),"","","117");
			
			
			$consulta[$x]="INSERT INTO _545_tablaDinamica(fechaCreacion,responsable,idEstado,nombreRevisor,apPaterno,apMaterno,emailContacto,emailContacto2,idUsuario)
					VALUES('".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",1,'".cv($obj->nombre)."','".cv($obj->apPaterno)."','".cv($obj->apMaterno).
					"','".cv($obj->email)."','".cv($obj->email2)."',".$obj->idUsuario.")";
			$x++;
			
			$consulta[$x]="update 800_usuarios set Login='".cv($obj->email)."' where idUsuario=".$obj->idUsuario;
			$x++;
			
			
		}
		else
		{
			$consulta[$x]="update _545_tablaDinamica set nombreRevisor='".cv($obj->nombre)."',apPaterno='".cv($obj->apPaterno)."',apMaterno='".cv($obj->apMaterno)."',
							emailContacto='".cv($obj->email)."',emailContacto2='".cv($obj->email2)."' where idUsuario=".$obj->idUsuario;
			$x++;
		}
			
		$consulta[$x]="commit";
		$x++;
			
		if($con->ejecutarBloque($consulta))
		{	
			
			$arrParam["mail"]=$obj->email;
			$arrParam["nombreRevisor"]=$obj->nombre." ".$obj->apPaterno." ".$obj->apMaterno;
			
			$consulta="SELECT Login, PASSWORD FROM 800_usuarios WHERE idUsuario=".$obj->idUsuario;
			$fDatosUsr=$con->obtenerPrimeraFila($consulta);
			
			$arrParam["usr"]=$fDatosUsr[0];
			$arrParam["passwd"]=$fDatosUsr[1];
			
			@enviarMensajeEnvio(12,$arrParam);
			if($fDatosRevisor[3]!="")
			{
				$arrParam["mail"]=$fDatosRevisor[3];
				
			}
			@enviarMensajeEnvio(12,$arrParam);
			
			$consulta="SELECT idUsuario,concat(nombreRevisor,' ',apPaterno,' ',apMaterno) as nombreRevisor,emailContacto,emailContacto2,nombreRevisor,apPaterno,apMaterno 
				FROM _545_tablaDinamica WHERE responsable=".$_SESSION["idUsr"]." ORDER BY nombreRevisor,apPaterno,apMaterno";
			$arrRevisores=$con->obtenerFilasArreglo($consulta);
			
			
			
			
			echo "1|".$obj->idUsuario."|".$arrRevisores;
		}
		
	}
	
	function registrarAsociacionRevisorProyecto()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		
		$consulta="INSERT INTO 1011_asignacionRevisoresProyectos(idUsuario,idProyecto,tipoRevisor,idFormulario,situacion,fechaAsignacion) 
					VALUES(".$obj->idRevisor.",".$obj->idReferencia.",2,".$obj->idFormulario.",1,'".date("Y-m-d H:i:s")."')";
		
		eC($consulta);
	}
	
	function obtenerRevisoresAsociadosProyecto()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idReferencia=$_POST["idReferencia"];
		$consulta="SELECT a.idUsuario AS idRevisor,CONCAT(r.nombreRevisor,' ',r.apPaterno,' ',r.apMaterno) AS revisor,situacion,
					IF(r.emailContacto2='',r.emailContacto,CONCAT(r.emailContacto,', ',r.emailContacto2))AS emailContacto, 
					if(situacion='1','',(SELECT total FROM _544_tablaDinamica WHERE idReferencia=".$idReferencia." AND responsable=a.idUsuario)) as calificacion,
					if(situacion='1','',(SELECT comentariosAdicionales FROM _544_tablaDinamica WHERE idReferencia=".$idReferencia." AND responsable=a.idUsuario)) as comentariosAdicionales
					FROM 1011_asignacionRevisoresProyectos a,_545_tablaDinamica r
					WHERE idFormulario=".$idFormulario." AND idProyecto=".$idReferencia." AND tipoRevisor=2 AND r.idUsuario=a.idUsuario and a.situacion>0
					
					union
					
					SELECT a.idUsuario AS idRevisor,CONCAT(r.Nom,' ',r.Paterno,' ',r.Materno) AS revisor,situacion,
					(SELECT Mail FROM 805_mails WHERE idUsuario=r.idUsuario)AS emailContacto, 
					if(situacion='1','',(SELECT total FROM _544_tablaDinamica WHERE idReferencia=".$idReferencia." AND responsable=a.idUsuario)) as calificacion,
					if(situacion='1','',(SELECT comentariosAdicionales FROM _544_tablaDinamica WHERE idReferencia=".$idReferencia." AND responsable=a.idUsuario)) as comentariosAdicionales
					FROM 1011_asignacionRevisoresProyectos a,802_identifica r
					WHERE idFormulario=".$idFormulario." AND idProyecto=".$idReferencia." AND tipoRevisor=1 AND r.idUsuario=a.idUsuario and a.situacion>0
					
					
					";
		$arrRegistros=utf8_encode($con->obtenerFilasJSON($consulta));					
		echo '{"numReg":"'.$con->filasAfectadas.'","registros":'.$arrRegistros.'}';
					
		
	}
	
	function removerAsociacionRevisorProyecto()
	{
		global $con;
		$cadObj=$_POST["cadObj"];
		$obj=json_decode($cadObj);
		
		
		$consulta="DELETE FROM 1011_asignacionRevisoresProyectos WHERE idFormulario=".$obj->idFormulario." AND idProyecto=".$obj->idReferencia." AND idUsuario=".$obj->idRevisor;
		
		eC($consulta);
	}
	
	function obtenerSituacionRevisoresProyectos()
	{
		global $con;
		$idCoordinador=$_POST["iC"];
		
		$arrProyectos=array();
		$arrRegistros="";
		$numReg=0;
		
		$consulta="SELECT p.id__541_tablaDinamica,p.codigo,'1' as tipo FROM 1011_asignacionRevisoresProyectos a,_541_tablaDinamica p 
					WHERE a.idUsuario=".$idCoordinador." AND a.tipoRevisor=1 AND p.id__541_tablaDinamica=a.idProyecto";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$arrProyectos[$fila[0]]=1;
		}
		
		$consulta="select  * from (SELECT idUsuario,CONCAT(nombreRevisor,' ',apPaterno,' ',apMaterno) AS nombre,'2' as tipo FROM _545_tablaDinamica WHERE responsable=".$idCoordinador."
					union 
					select idUsuario,CONCAT(r.Nom,' ',r.Paterno,' ',r.Materno) as nombre,'1' as tipo from 802_identifica r where idUsuario=".$idCoordinador.") as tmp
		
		 order by nombre";
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$o='{"idRevisor":"'.$fila[0].'","nombreRevisor":"'.cv($fila[1]).'"';
			
			foreach($arrProyectos as $iP=>$resto)
			{
				$total="";
				$comentarios="";
				$consulta="SELECT situacion FROM 1011_asignacionRevisoresProyectos WHERE idFormulario=541 AND idProyecto=".$iP." AND idUsuario=".$fila[0]." AND tipoRevisor=".$fila[2];
				$situacion=$con->obtenerValor($consulta);
				
				if($situacion!="")
				{
					$consulta="SELECT total,comentariosAdicionales,id__544_tablaDinamica FROM _544_tablaDinamica WHERE idReferencia=".$iP." AND responsable=".$fila[0];
					$fEvaluacion=$con->obtenerPrimeraFila($consulta);
					
					$total=$fEvaluacion[0];
					$total.="_".bE($fEvaluacion[1])."_".$fEvaluacion[2];
					
				}
				else
				{
					$total=-1;
				}
				
				$o.=',"p_'.$iP.'":"'.$total.'"';
			}
			
			$o.='}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
				
			$numReg++;	
				
		}
		
		echo '{"numReg":"'.$numReg.'","registros":['.$arrRegistros.']}';
		
	}
?>