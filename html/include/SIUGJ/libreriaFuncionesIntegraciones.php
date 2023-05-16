<?php include_once("latisErrorHandler.php");
include_once("cConectoresServicios/cConectorCalendarOffice365.php");	


function buscarInformacionSirna($numeroDocumento,$tipoDocumento,$urlConexion="")
{
	global $con;
	$arrResultado=array();
	$urlWebServices="";
	$curl_response="";
	try
	{
		$consulta="SELECT * FROM _1242_tablaDinamica WHERE codigo='00001/2022'";
		$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
		
		$urlWebServices=$fRegistro["urlConexion"];

		if($urlConexion!="")
			$urlWebServices=$urlConexion;
		$parametros=array();
		

		$urlWebServices=$fRegistro["urlConexion"]."?NumeroDocumento=".$numeroDocumento."&TipoDocumento=".$tipoDocumento;

		$curl = curl_init($urlWebServices);
		$curl_post_data = array();
		
	
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 8);
		curl_setopt($curl, CURLOPT_TIMEOUT , 6);
			
		$curl_response = curl_exec($curl);
		
		$oResp=	json_decode($curl_response);	

		if($oResp)
		{
			$arrResultado["Respuesta"]=$oResp->Respuesta=="Exitoso"?1:0;
			$arrResultado["TipoMensaje"]=$oResp->TipoMensaje;
			if($arrResultado["Respuesta"]==1)
			{
				$arrResultado["Apellidos"]=$oResp->datos->datosParametrosConsultarNalAbogados->Apellidos;
				$arrResultado["Calidad"]=$oResp->datos->datosParametrosConsultarNalAbogados->Calidad;
				$arrResultado["Celular"]=$oResp->datos->datosParametrosConsultarNalAbogados->Celular;
				$arrResultado["Ciudad"]=$oResp->datos->datosParametrosConsultarNalAbogados->Ciudad;
				$arrResultado["CiudadId"]=$oResp->datos->datosParametrosConsultarNalAbogados->CiudadId;
				$arrResultado["CorreoElectronico"]=$oResp->datos->datosParametrosConsultarNalAbogados->CorreoElectronico;
				$arrResultado["Departamento"]=$oResp->datos->datosParametrosConsultarNalAbogados->Departamento;
				$arrResultado["DepartamentoId"]=$oResp->datos->datosParametrosConsultarNalAbogados->DepartamentoId;
				$arrResultado["Direccion"]=$oResp->datos->datosParametrosConsultarNalAbogados->Direccion;
				$arrResultado["Estado"]=$oResp->datos->datosParametrosConsultarNalAbogados->Estado;
				$arrResultado["NoTarjeta"]=$oResp->datos->datosParametrosConsultarNalAbogados->NoTarjeta;
				$arrResultado["Nombres"]=$oResp->datos->datosParametrosConsultarNalAbogados->Nombres;
				$arrResultado["Pais"]=$oResp->datos->datosParametrosConsultarNalAbogados->Pais;
				$arrResultado["PaisId"]=$oResp->datos->datosParametrosConsultarNalAbogados->PaisId;
				$arrResultado["Telefono"]=$oResp->datos->datosParametrosConsultarNalAbogados->PaisId;
			}
			else
			{
				$arrResultado["Respuesta"]=2;
			}	
			return $arrResultado;
		}
		else
		{
			
			$tipoNotificacion=15;
			$idRegistroBitacora=registrarBitacoraConsumoServicioConexiones($tipoNotificacion,$numeroDocumento."_".$tipoDocumento);
			actualizarBitacoraConsumoServicioConexiones($idRegistroBitacora,"",0,$curl_response,$urlWebServices);
			
			$arrResultado["Respuesta"]=0;
			$arrResultado["TipoMensaje"]="Error en consulta";
			return $arrResultado;
		}
	}
	catch(Exception $e)
	{
		$tipoNotificacion=15;
		$idRegistroBitacora=registrarBitacoraConsumoServicioConexiones($tipoNotificacion,$numeroDocumento."_".$tipoDocumento);
		actualizarBitacoraConsumoServicioConexiones($idRegistroBitacora,$e->getMessage(),4,$curl_response,$urlWebServices);
		$arrResultado["Respuesta"]=0;
		$arrResultado["TipoMensaje"]=$e->getMessage();
		return $arrResultado;
	}
}

function buscarInformacionSirnaSOAP($numeroDocumento,$tipoDocumento,$urlConexion="")
{
	global $con;
	$arrResultado=array();
	try
	{
		$consulta="SELECT * FROM _1242_tablaDinamica WHERE codigo='00001/2022'";
		$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
		
		$urlWebServices=$fRegistro["urlConexion"];
		if($urlConexion!="")
			$urlWebServices=$urlConexion;
		$parametros=array();
		$xml='<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:tem="http://tempuri.org/" xmlns:urna="http://schemas.datacontract.org/2004/07/Urna.CSJ.Entidad.Consulta.Publica.Parametros">
		   <soapenv:Header/>
		   <soapenv:Body>
			  <tem:ConsultaRegistroNalAbogados>
				 <tem:parametros>
					<urna:NumeroDocumento>'.$numeroDocumento.'</urna:NumeroDocumento>
					<urna:TipoDocumento>'.$tipoDocumento.'</urna:TipoDocumento>
				 </tem:parametros>
			  </tem:ConsultaRegistroNalAbogados>
		   </soapenv:Body>
		</soapenv:Envelope>';

		$curl = curl_init($urlWebServices);
		$curl_post_data = $xml;
		
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POST, true);
		


		curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 8);
		curl_setopt($curl, CURLOPT_TIMEOUT , 6);
		curl_setopt($curl, CURLOPT_HTTPHEADER, 	array(                                                                          
														'Content-Type: text/xml;charset=UTF-8',
														'SOAPAction: http://tempuri.org/ISerConsultaRegistroNalAbogados/ConsultaRegistroNalAbogados',                                                                                
														)                                                                       
					);                                                                                                                   
									
		$curl_response = curl_exec($curl);

		
		$arrRespuesta=explode("<s:Body>",$curl_response);
		if(count($arrRespuesta)>1)
		{
			$xml=$arrRespuesta[1];
			$arrRespuesta=explode("</s:Body>",$xml);
			$xml=$arrRespuesta[0];
			
			$xml=str_replace("<a:","<a_",$xml);
			$xml=str_replace("<b:","<b_",$xml);
			$xml=str_replace("</a:","</a_",$xml);
			$xml=str_replace("</b:","</b_",$xml);
			$cXML=simplexml_load_string($xml);	
		
			
			$arrResultado["Respuesta"]=(string)$cXML->ConsultaRegistroNalAbogadosResult[0]->Respuesta[0]=="Exitoso"?1:0;
			$arrResultado["TipoMensaje"]=(string)$cXML->ConsultaRegistroNalAbogadosResult[0]->TipoMensaje[0];
			if($arrResultado["Respuesta"]==1)
			{
				$arrResultado["Apellidos"]=(string)$cXML->ConsultaRegistroNalAbogadosResult[0]->a_Datos[0]->b_DatosParametrosConsultaNalAbogados[0]->b_Apellidos[0];
				$arrResultado["Calidad"]=(string)$cXML->ConsultaRegistroNalAbogadosResult[0]->a_Datos[0]->b_DatosParametrosConsultaNalAbogados[0]->b_Calidad[0];
				$arrResultado["Celular"]=(string)$cXML->ConsultaRegistroNalAbogadosResult[0]->a_Datos[0]->b_DatosParametrosConsultaNalAbogados[0]->b_Celular[0];
				$arrResultado["Ciudad"]=(string)$cXML->ConsultaRegistroNalAbogadosResult[0]->a_Datos[0]->b_DatosParametrosConsultaNalAbogados[0]->b_Ciudad[0];
				$arrResultado["CiudadId"]=(string)$cXML->ConsultaRegistroNalAbogadosResult[0]->a_Datos[0]->b_DatosParametrosConsultaNalAbogados[0]->b_CiudadId[0];
				$arrResultado["CorreoElectronico"]=(string)$cXML->ConsultaRegistroNalAbogadosResult[0]->a_Datos[0]->b_DatosParametrosConsultaNalAbogados[0]->b_CorreoElectronico[0];
				$arrResultado["Departamento"]=(string)$cXML->ConsultaRegistroNalAbogadosResult[0]->a_Datos[0]->b_DatosParametrosConsultaNalAbogados[0]->b_Departamento[0];
				$arrResultado["DepartamentoId"]=(string)$cXML->ConsultaRegistroNalAbogadosResult[0]->a_Datos[0]->b_DatosParametrosConsultaNalAbogados[0]->b_DepartamentoId[0];
				$arrResultado["Direccion"]=(string)$cXML->ConsultaRegistroNalAbogadosResult[0]->a_Datos[0]->b_DatosParametrosConsultaNalAbogados[0]->b_Direccion[0];
				$arrResultado["Estado"]=(string)$cXML->ConsultaRegistroNalAbogadosResult[0]->a_Datos[0]->b_DatosParametrosConsultaNalAbogados[0]->b_Estado[0];
				$arrResultado["NoTarjeta"]=(string)$cXML->ConsultaRegistroNalAbogadosResult[0]->a_Datos[0]->b_DatosParametrosConsultaNalAbogados[0]->b_NoTarjeta[0];
				$arrResultado["Nombres"]=(string)$cXML->ConsultaRegistroNalAbogadosResult[0]->a_Datos[0]->b_DatosParametrosConsultaNalAbogados[0]->b_Nombres[0];
				$arrResultado["Pais"]=(string)$cXML->ConsultaRegistroNalAbogadosResult[0]->a_Datos[0]->b_DatosParametrosConsultaNalAbogados[0]->b_Pais[0];
				$arrResultado["PaisId"]=(string)$cXML->ConsultaRegistroNalAbogadosResult[0]->a_Datos[0]->b_DatosParametrosConsultaNalAbogados[0]->b_PaisId[0];
				$arrResultado["Telefono"]=(string)$cXML->ConsultaRegistroNalAbogadosResult[0]->a_Datos[0]->b_DatosParametrosConsultaNalAbogados[0]->Telefono[0];
			}
			else
			{
				$arrResultado["Respuesta"]=2;
			}
			
			return $arrResultado;
		}
		else
		{
			$arrResultado["Respuesta"]=0;
			$arrResultado["TipoMensaje"]="Error en consulta";
			return $arrResultado;
		}
	}
	catch(Exception $e)
	{
		$arrResultado["Respuesta"]=0;
		$arrResultado["TipoMensaje"]=$e->getMessage();
		return $arrResultado;
	}
}

function buscarInformacionRues($nit)
{
	global $con;
	
	try
	{
	
		$consulta="SELECT * FROM _1242_tablaDinamica WHERE codigo='00002/2022'";
		$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
		
		$arrParametros=array();
		$consulta="SELECT * FROM _1242_gParametrosAdicionales WHERE idReferencia=".$fRegistro["id__1242_tablaDinamica"];
		$res=$con->obtenerFilas($consulta);
		while($fila=$con->fetchAssoc($res))
		{
			$arrParametros[$fila["nombreParametro"]]=$fila;
		}
		
		$urlWebServices=$fRegistro["urlConexion"];

		$curl = curl_init($urlWebServices);
		$curl_post_data = array();
		$curl_post_data["username"]=$arrParametros["username"]["valor"];
		$curl_post_data["password"]=$arrParametros["password"]["valor"];
		$curl_post_data["grant_type"]=$arrParametros["grant_type"]["valor"];
	
		
		/*$out = fopen('php://output', 'w');
		curl_setopt($curl, CURLOPT_VERBOSE, true);  
		curl_setopt($curl, CURLOPT_STDERR, $out);  */
	
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
		curl_setopt($curl, CURLOPT_TIMEOUT , 5);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($curl_post_data));
		curl_setopt($curl, CURLOPT_HTTPHEADER, 	array(                                                                          
														  'Content-Type: application/x-www-form-urlencoded',
														  'x-road-client: '.$arrParametros["x-road-client"]["valor"]                                                                             
														  )                                                                       
					  );                                                                                                                   
		
		$curl_response = curl_exec($curl);
	
	
		$oResp=	json_decode($curl_response);	
		if(!$oResp)
		{
			$tipoNotificacion=16;
			$idRegistroBitacora=registrarBitacoraConsumoServicioConexiones($tipoNotificacion,$nit);
			actualizarBitacoraConsumoServicioConexiones($idRegistroBitacora,"",10,$curl_response,$urlWebServices);
			$arrResultado["Respuesta"]=4;
			return $arrResultado;
		}
	
		if(!isset($oResp->access_token))
		{
	
			$arrResultado["Respuesta"]=4;
			$tipoNotificacion=16;
			$idRegistroBitacora=registrarBitacoraConsumoServicioConexiones($tipoNotificacion,$nit);
			actualizarBitacoraConsumoServicioConexiones($idRegistroBitacora,"",11,$curl_response,$urlWebServices);
			return $arrResultado;
		}
		$token=$oResp->access_token;
	
		$consulta="SELECT * FROM _1242_tablaDinamica WHERE codigo='00003/2022'";
		$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
		
		$arrParametros=array();
		$consulta="SELECT * FROM _1242_gParametrosAdicionales WHERE idReferencia=".$fRegistro["id__1242_tablaDinamica"];
		$res=$con->obtenerFilas($consulta);
		while($fila=$con->fetchAssoc($res))
		{
			$arrParametros[$fila["nombreParametro"]]=$fila;
		}
		
		$numeroVerificador=calcularDigitoVerificador($nit);
		
		$urlWebServices=$fRegistro["urlConexion"]."?usuario=".$arrParametros["username"]["valor"] ."&nit=".$nit."&dv=".$numeroVerificador;
		$curl = curl_init($urlWebServices);
		$curl_post_data = array();
		
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POST, true);
		
	
		curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
		curl_setopt($curl, CURLOPT_HTTPHEADER, 	array(                                                                          
														  'Authorization: Bearer '.$token,
														  'x-road-client: '.$arrParametros["x-road-client"]["valor"]                                                                              
													)                                                                       
					  );  					
									
		$curl_response = curl_exec($curl);
		
		$oResp=	json_decode($curl_response);
		
		if($oResp)
		{
	
			$arrResultado["Respuesta"]=isset($oResp->error)?0:1;
			$arrResultado["TipoMensaje"]=isset($oResp->error)?$oResp->error->message:"";
			$arrResultado["errorCodigo"]=isset($oResp->error)?$oResp->error->code:"";
			
			if($arrResultado["Respuesta"]==1)
			{
	
				$arrResultado["Apellidos"]=trim($oResp->registros[0]->primerApellidoPersonaNatural." ".$oResp->registros[0]->segundoApellidoPersonaNatural);
				$arrResultado["ApellidoPaterno"]=trim($oResp->registros[0]->primerApellidoPersonaNatural);
				$arrResultado["ApellidoMaterno"]=trim($oResp->registros[0]->segundoApellidoPersonaNatural);
				$arrResultado["Calidad"]="";
				$arrResultado["Celular"]="";
				
				$arrResultado["CiudadId"]=substr($oResp->registros[0]->codDaneMunicipioFiscal,2);
				$consulta="SELECT municipio FROM 821_municipios WHERE cveMunicipio='".$oResp->registros[0]->codDaneMunicipioFiscal."'";
				$arrResultado["Ciudad"]=$con->obtenerValor($consulta);
				
				
				$arrResultado["CorreoElectronico"]=$oResp->registros[0]->correoElectronicoFiscal!=""?$oResp->registros[0]->correoElectronicoFiscal:$oResp->registros[0]->correoElectronicoComercial;
				$arrResultado["DepartamentoId"]=substr($oResp->registros[0]->codDaneMunicipioFiscal,0,2);
				
				$consulta="SELECT estado FROM 820_estados WHERE cveEstado='".$arrResultado["DepartamentoId"]."'";
				$arrResultado["Departamento"]=$con->obtenerValor($consulta);
				
				
				$arrResultado["Direccion"]=$oResp->registros[0]->aclaracionDireccionFiscal;
				$arrResultado["Estado"]=$oResp->registros[0]->nomEstadoMatricula;
				$arrResultado["NoTarjeta"]="";
				$arrResultado["Nombres"]=($oResp->registros[0]->razonSocialEmpresa=="")?trim($oResp->registros[0]->primerNomPersonaNatural." ".$oResp->registros[0]->segundoNomPersonaNatural):$oResp->registros[0]->razonSocialEmpresa;
				$arrResultado["Pais"]="";
				$arrResultado["PaisId"]="";
				$arrResultado["Telefono"]=$oResp->registros[0]->telefonoFiscal1;
	
				return $arrResultado;
			}
			else
			{
	
				if($arrResultado["errorCodigo"]==404)
				{
					$arrResultado["Respuesta"]=2;
				}
				else
				{
					$arrResultado["Respuesta"]=4;
					$tipoNotificacion=16;
					$idRegistroBitacora=registrarBitacoraConsumoServicioConexiones($tipoNotificacion,$nit);
					actualizarBitacoraConsumoServicioConexiones($idRegistroBitacora,"",12,$curl_response,$urlWebServices);
				}
	
				return $arrResultado;	
			}
			
		}
		else
		{
			$tipoNotificacion=16;
			$idRegistroBitacora=registrarBitacoraConsumoServicioConexiones($tipoNotificacion,$nit);
			actualizarBitacoraConsumoServicioConexiones($idRegistroBitacora,"",0,$curl_response,$urlWebServices);
			$arrResultado["Respuesta"]=4;
			return $arrResultado;
		}
	}
	catch(Exception $e)
	{

		$tipoNotificacion=16;
		$idRegistroBitacora=registrarBitacoraConsumoServicioConexiones($tipoNotificacion,$nit);
		actualizarBitacoraConsumoServicioConexiones($idRegistroBitacora,$e->getMessage(),4,$curl_response,$urlWebServices);
		$arrResultado["Respuesta"]=4;
		return $arrResultado;
	}
}

function buscarInformacionRegistraduria($nuip)
{
	global $con;
	
	try
	{
		$consulta="SELECT * FROM _1242_tablaDinamica WHERE codigo='00004/2022'";
		$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
		
		$arrParametros=array();
		$consulta="SELECT * FROM _1242_gParametrosAdicionales WHERE idReferencia=".$fRegistro["id__1242_tablaDinamica"];
		
		$res=$con->obtenerFilas($consulta);
		while($fila=$con->fetchAssoc($res))
		{
			$arrParametros[$fila["nombreParametro"]]=$fila;
		}
		
		$urlWebServices=$fRegistro["urlConexion"]."?nuip=".$nuip;
	
		$curl = curl_init($urlWebServices);
		$curl_post_data = array();
		
	
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		/*curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
		curl_setopt($curl, CURLOPT_TIMEOUT , 5);*/
			
		$curl_response = curl_exec($curl);
		
		$oResp=	json_decode($curl_response);	
		
		if(!$oResp || !isset($oResp->datosCedulas) || !isset($oResp->datosCedulas->datos->codError))
		{
	
			$arrResultado["Respuesta"]=4;
			return $arrResultado;
		}
		
	
	
		if($oResp)
		{
			
			$arrResultado["Respuesta"]=($oResp->datosCedulas->datos->codError==0)?1:0;
			$arrResultado["TipoMensaje"]=isset($oResp->datosCedulas->datos->codError)?$oResp->datosCedulas->datos->codError:"";
			$arrResultado["errorCodigo"]=isset($oResp->datosCedulas->datos->codError)?$oResp->datosCedulas->datos->codError:"";
	
			if($arrResultado["Respuesta"]==1)
			{
				$primerApellido=getValueRegistraduria($oResp->datosCedulas->datos->primerApellido);
				$segundoApellido=getValueRegistraduria($oResp->datosCedulas->datos->segundoApellido);
				$primerNombre=getValueRegistraduria($oResp->datosCedulas->datos->primerNombre);
				$segundoNombre=getValueRegistraduria($oResp->datosCedulas->datos->segundoNombre);
				$arrResultado["Apellidos"]=trim($primerApellido).(getValueRegistraduria($oResp->datosCedulas->datos->particula)==""?" ":(" ".getValueRegistraduria($oResp->datosCedulas->datos->particula)." ")).$segundoApellido;
				$arrResultado["ApellidoPaterno"]=trim($primerApellido);
				$arrResultado["ApellidoMaterno"]=trim((getValueRegistraduria($oResp->datosCedulas->datos->particula)==""?" ":(" ".getValueRegistraduria($oResp->datosCedulas->datos->particula)." ")).$segundoApellido);
				$arrResultado["Calidad"]="";
				$arrResultado["Celular"]="";
				$arrResultado["CorreoElectronico"]="";
				$consulta="SELECT cveEstado,estado FROM 820_estados WHERE estado='".cv(getValueRegistraduria($oResp->datosCedulas->datos->departamentoExpedicion))."'";
				$fEstado=$con->obtenerPrimeraFilaAsoc($consulta);
				$arrResultado["Departamento"]=$fEstado["estado"];
				$arrResultado["DepartamentoId"]=$fEstado["cveEstado"];
				
				$consulta="SELECT cveMunicipio,municipio FROM 821_municipios WHERE municipio='".cv(getValueRegistraduria($oResp->datosCedulas->datos->municipioExpedicion)).
							"' and cveEstado='".$fEstado["cveEstado"]."'";
				$fMunicipio=$con->obtenerPrimeraFilaAsoc($consulta);
				
				$arrResultado["CiudadId"]=$fMunicipio["municipio"];			
				$arrResultado["Ciudad"]=$fMunicipio["cveMunicipio"];			
				
				$arrResultado["Direccion"]="";
				$arrResultado["Estado"]=getValueRegistraduria($oResp->datosCedulas->datos->estadoCedula);
				$arrResultado["NoTarjeta"]="";
				$arrResultado["Nombres"]=trim($primerNombre).(trim($segundoNombre)!=""?(" ".$segundoNombre):"");
				
				$arrResultado["Nombres"]=str_replace(".","",$arrResultado["Nombres"]);
				
				$arrResultado["Pais"]="";
				$arrResultado["PaisId"]="";
				$arrResultado["Telefono"]="";
				
				$arrFecha=explode("/",$oResp->datosCedulas->datos->fechaExpedicion);
				$arrResultado["fechaExpedicion"]=$arrFecha[2]."-".$arrFecha[1]."-".$arrFecha[0];
	
				$fechaDefuncion="";
				if(getValueRegistraduria($oResp->datosCedulas->datos->fechaDefuncion)!='')
				{
					$arrFechaDeuncion=explode("/",getValueRegistraduria($oResp->datosCedulas->datos->fechaDefuncion));
					$fechaDefuncion=$arrFechaDeuncion[2]."-".$arrFechaDeuncion[1]."-".$arrFechaDeuncion[0];
					
				}
				
				$arrResultado["fechaDefuncion"]=$fechaDefuncion;
	
				return $arrResultado;
			}
			else
			{
	
				if($arrResultado["errorCodigo"]==1)
				{
					$arrResultado["Respuesta"]=2;
				}
	
				return $arrResultado;	
			}
			
		}
		return $arrResultado;
	}
	catch(Exception $e)
	{
		$tipoNotificacion=13;
		$idRegistroBitacora=registrarBitacoraConsumoServicioConexiones($tipoNotificacion,$nuip);
		actualizarBitacoraConsumoServicioConexiones($idRegistroBitacora,$e->getMessage(),4,$curl_response,$urlWebServices);
		$arrResultado["Respuesta"]=4;
		return $arrResultado;
	}
}

function getValueRegistraduria($valor)
{
	
	return gettype($valor)=='array'?"":$valor;
	
}


function calcularDigitoVerificador($numIdentificacion)
{
	
	$arrSucesion[0]=41;
	$arrSucesion[1]=37;
	$arrSucesion[2]=29;
	$arrSucesion[3]=23;
	$arrSucesion[4]=19;
	$arrSucesion[5]=17;
	$arrSucesion[6]=13;
	$arrSucesion[7]=7;
	$arrSucesion[8]=3;

	$total=0;
	$arrResultados=array();
	for($x=0;$x<9;$x++)
	{
		$arrResultados[$x]=$numIdentificacion[$x]*$arrSucesion[$x];
		$total+=$arrResultados[$x];
	}
	//echo "Total: ".$total."<br>";
	$resultado=$total/11;
	
	//echo "Módulo 11: ".$resultado."<br>";
	
	$parteDecimal=parteDecimal($resultado);
	
	//echo "Parte decimal 11: ".$parteDecimal."<br>";
	
	$resultado=("0.".$parteDecimal)*11;
	
	
	$resultado2=round($resultado);
	
	if(($resultado2==0)||($resultado2==1))
		return $resultado2;
	else
		return 11-$resultado2;
	
		
}


function buscarInformacionEtiquetado($palabraClave)
{
	global $con;
	
	
	$consulta="SELECT * FROM _1242_tablaDinamica WHERE codigo='00005/2022'";
	$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
	
	/*$arrParametros=array();
	$consulta="SELECT * FROM _1242_gParametrosAdicionales WHERE idReferencia=".$fRegistro["id__1242_tablaDinamica"];
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchAssoc($res))
	{
		$arrParametros[$fila["nombreParametro"]]=$fila;
	}
	*/
	$urlWebServices=$fRegistro["urlConexion"]."?v=1&query=".urlencode($palabraClave);

	$curl = curl_init($urlWebServices);
	$curl_post_data = array();
	

	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	
	$curl_response = curl_exec($curl);
	
	$oResp=	json_decode($curl_response);	
	$aRegistros="";
	$numReg=0;
	
	if(isset($oResp->suggestions))
	{
		for($pos=0;$pos<count($oResp->suggestions);$pos++)
		{
			$o='{"idEtiqueta":"'.$oResp->data[$pos].'","etiqueta":"'.cv($oResp->suggestions[$pos]).'"}';
			if($aRegistros=="")
				$aRegistros=$o;
			else
				$aRegistros.=",".$o;
			$numReg++;
		}
	}
	
	$arrRegistros='{"numReg":"'.$numReg.'","registros":['.$aRegistros.']}';

	return $arrRegistros;

	
	
	
}


function buscarPrecioDolar($fechaActual)
{
	global $con;
	
	
	$consulta="SELECT * FROM _1242_tablaDinamica WHERE codigo='00006/2022'";
	$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
	
	/*$arrParametros=array();
	$consulta="SELECT * FROM _1242_gParametrosAdicionales WHERE idReferencia=".$fRegistro["id__1242_tablaDinamica"];
	$res=$con->obtenerFilas($consulta);
	while($fila=$con->fetchAssoc($res))
	{
		$arrParametros[$fila["nombreParametro"]]=$fila;
	}
	*/
	$urlWebServices=$fRegistro["urlConexion"]."?vigenciahasta=".$fechaActual;

	$curl = curl_init($urlWebServices);
	$curl_post_data = array();
	

	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	
	$curl_response = curl_exec($curl);
	$cadResp='{"resultado":'.$curl_response.'}';
	
	$oResp=	json_decode($cadResp);	
	$aRegistros="";
	$numReg=0;
	
	
	
	
	
	if($oResp && count($oResp->resultado)>0 && isset($oResp->resultado[0]->valor))
	{
		return $oResp->resultado[0]->valor;
	}
	
	return NULL;
}


function getCambioMoneda($fecha,$tipoModena)
{
	global $con;
	$consulta="SELECT tipoCambio FROM _1283_tablaDinamica WHERE fechaAplicacion<='".$fecha."' AND cmbMoneda=".$tipoModena." ORDER BY fechaAplicacion DESC";
	$monedaCambio=$con->obtenerValor($consulta);
	if($monedaCambio=="")
		$monedaCambio=0;
	return $monedaCambio;
}


function buscarInformacionEFinomina($cc)
{
	global $con;
	$tipoNotificacion=17;
	try
	{
	
		$consulta="SELECT * FROM _1242_tablaDinamica WHERE codigo='00003/2023'";
		$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
		
		$arrParametros=array();
		$consulta="SELECT * FROM _1242_gParametrosAdicionales WHERE idReferencia=".$fRegistro["id__1242_tablaDinamica"];
		$res=$con->obtenerFilas($consulta);
		while($fila=$con->fetchAssoc($res))
		{
			$arrParametros[$fila["nombreParametro"]]=$fila;
		}
		
		$urlWebServices=$fRegistro["urlConexion"];

		$curl = curl_init($urlWebServices);
		$curl_post_data = array();
		
	
		
		/*$out = fopen('php://output', 'w');
		curl_setopt($curl, CURLOPT_VERBOSE, true);  
		curl_setopt($curl, CURLOPT_STDERR, $out);  */
		$cadenaConsulta='{"Entidad": "'.$arrParametros["Entidad"]["valor"].'", "Usuario": "'.$arrParametros["Usuario"]["valor"].
						'", "Clave": "'.$arrParametros["Clave"]["valor"].'", "CodEmpresa": "'.$arrParametros["CodEmpresa"]["valor"].'"}';
	
		$timeout=10;
	
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout);
		curl_setopt($curl, CURLOPT_TIMEOUT , $timeout);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $cadenaConsulta);
		curl_setopt($curl, CURLOPT_HTTPHEADER, 	array(                                                                          
														  'Content-Type: application/json'
														  )                                                                       
					  );                                                                                                                   
		
		$curl_response = curl_exec($curl);
		$oResp=	json_decode($curl_response);	
		if(!$oResp)
		{
			
			$idRegistroBitacora=registrarBitacoraConsumoServicioConexiones($tipoNotificacion,$cc);
			actualizarBitacoraConsumoServicioConexiones($idRegistroBitacora,"",10,$curl_response,$urlWebServices);
			$arrResultado["Respuesta"]=4;
			return $arrResultado;
		}
		if(!isset($oResp->access_token))
		{
	
			$arrResultado["Respuesta"]=4;
			$idRegistroBitacora=registrarBitacoraConsumoServicioConexiones($tipoNotificacion,$cc);
			actualizarBitacoraConsumoServicioConexiones($idRegistroBitacora,"",11,$curl_response,$urlWebServices);
			return $arrResultado;
		}
		$token=$oResp->access_token;
		
		$consulta="SELECT * FROM _1242_tablaDinamica WHERE codigo='00004/2023'";
		$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
		
		$arrParametros=array();
		$consulta="SELECT * FROM _1242_gParametrosAdicionales WHERE idReferencia=".$fRegistro["id__1242_tablaDinamica"];
		$res=$con->obtenerFilas($consulta);
		while($fila=$con->fetchAssoc($res))
		{
			$arrParametros[$fila["nombreParametro"]]=$fila;
		}
		
		
		$urlWebServices=$fRegistro["urlConexion"].$cc;
		$curl = curl_init($urlWebServices);
		$curl_post_data = array();
		
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POST, false);
		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout);
		curl_setopt($curl, CURLOPT_TIMEOUT , $timeout);
		
	
		curl_setopt($curl, CURLOPT_HTTPHEADER, 	array(                                                                          
														  'Authorization: Bearer '.$token
													)                                                                       
					  );  					
									
		$curl_response = curl_exec($curl);
		$oResp=	json_decode($curl_response);
		
		if($oResp)
		{

			$arrResultado["Respuesta"]=$oResp->totalItems==0?0:1;
			$arrResultado["TipoMensaje"]="";
			$arrResultado["errorCodigo"]="";
			
			if($arrResultado["Respuesta"]==1)
			{
				$oResultado=$oResp->datos[0];
				
				$arrResultado["Apellidos"]=trim($oResultado->apellidO1," ".$oResultado->apellidO2);
				$arrResultado["ApellidoPaterno"]=trim($oResultado->apellidO1);
				$arrResultado["ApellidoMaterno"]=trim($oResultado->apellidO2);
				
				$arrResultado["primerNombre"]=trim($oResultado->nombrE1);
				$arrResultado["segundoNombre"]=trim($oResultado->nombrE2);
				
				$arrResultado["Calidad"]="";
				$arrResultado["Celular"]="";
				
				$arrResultado["CiudadId"]="";
				$arrResultado["Ciudad"]="";
				
				
				$arrResultado["CorreoElectronico"]=$oResultado->correo;
				$arrResultado["DepartamentoId"]="";
				$arrResultado["Departamento"]="";
				
				
				$arrResultado["Direccion"]=$oResultado->direccion;
				$arrResultado["Estado"]="1";
				$arrResultado["estadoempleado"]=$oResultado->estadoempleado;
				$arrResultado["NoTarjeta"]="";
				$arrResultado["Nombres"]=($arrResultado["primerNombre"]." ".$arrResultado["segundoNombre"]);
				$arrResultado["Pais"]="";
				$arrResultado["PaisId"]="";
				$arrResultado["sexo"]=$oResultado->sexo;
				$arrResultado["Telefono"]=$oResultado->telefono;
				
				$consulta="SELECT * FROM _1242_tablaDinamica WHERE codigo='00005/2023'";
				$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
				
				$arrParametros=array();
				$consulta="SELECT * FROM _1242_gParametrosAdicionales WHERE idReferencia=".$fRegistro["id__1242_tablaDinamica"];
				$res=$con->obtenerFilas($consulta);
				while($fila=$con->fetchAssoc($res))
				{
					$arrParametros[$fila["nombreParametro"]]=$fila;
				}
				
				
				$urlWebServices=$fRegistro["urlConexion"].$cc;
				$curl = curl_init($urlWebServices);
				$curl_post_data = array();
				
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($curl, CURLOPT_POST, false);
				curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout);
				curl_setopt($curl, CURLOPT_TIMEOUT , $timeout);
				
			
				curl_setopt($curl, CURLOPT_HTTPHEADER, 	array(                                                                          
																  'Authorization: Bearer '.$token
															)                                                                       
							  );  					
											
				$curl_response = curl_exec($curl);
				$oResp=	json_decode($curl_response);

				
				$arrResultado["ultimoCargo"]="";
				$arrResultado["ultimaDependencia"]="";
				$arrResultado["estatusActualNomina"]=$arrResultado["estadoempleado"];
				
				if(($oResp)&&($oResp->totalItems>0))
				{
					
					$oResultado=$oResp->datos;
					$arrResultado["ultimoCargo"]=$oResultado->cargo;
					$arrResultado["ultimaDependencia"]=$oResultado->dependencia;
				}
	
	
	
				return $arrResultado;
			}
			else
			{
	
				$arrResultado["Respuesta"]=2;
				return $arrResultado;	
			}
			
		}
		else
		{

			$idRegistroBitacora=registrarBitacoraConsumoServicioConexiones($tipoNotificacion,$cc);
			actualizarBitacoraConsumoServicioConexiones($idRegistroBitacora,"",0,$curl_response,$urlWebServices);
			$arrResultado["Respuesta"]=4;
			return $arrResultado;
		}
	}
	catch(Exception $e)
	{
		echo $e->getMessage();
		$idRegistroBitacora=registrarBitacoraConsumoServicioConexiones($tipoNotificacion,$cc);
		actualizarBitacoraConsumoServicioConexiones($idRegistroBitacora,$e->getMessage(),4,$curl_response,$urlWebServices);
		$arrResultado["Respuesta"]=4;
		return $arrResultado;
	}
}
?>