<?php
	include_once("conexionBD.php"); 
	include_once("latisErrorHandler.php");
		
	class cFirmaConsejo
	{
		var $api;
		var $method;
		var $clientId;
		var $clientSecret;
		var $clientLogin;
		var $oToken;
		var $clientIDUser;
		var $correosFirmantes;

				
		function __construct($usuario="",$contrasena="") 
		{
			global $con;
			
			$consulta="SELECT * FROM _1242_tablaDinamica WHERE codigo='00006/2023'";
			$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
			
			$arrParametros=array();
			$consulta="SELECT * FROM _1242_gParametrosAdicionales WHERE idReferencia=".$fRegistro["id__1242_tablaDinamica"];
			
			$res=$con->obtenerFilas($consulta);
			while($fila=$con->fetchAssoc($res))
			{
				$arrParametros[$fila["nombreParametro"]]=$fila;
			}
			
			$this->api =$fRegistro["urlConexion"];
			$this->clientLogin=$usuario==""?"usuarioprueba1@deaj.ramajudicial.gov.co":$usuario;
			$this->clientSecret=$contrasena==""?"SiujUnidadInformatica*":$contrasena;
			$this->clientId=$arrParametros["clientId"]["valor"];		
			$this->correosFirmantes=array();
			
			$this->oToken=NULL;
			
		}
				
		function generarTokenAcceso()
		{
			global $con;
			$this->method="User/LoginExt";
			
			$arrParams["aplicativo"]=$this->clientId;
			$arrParams["usuario"]=$this->clientLogin;
			$arrParams["clave"]=$this->clientSecret;
			
			
			
			$resultado=$this->callAPI("POST", $this->api.$this->method, $arrParams, NULL,true, $setHeaders = false,$contentType="application/json");
			
			$oResultado=json_decode($resultado);
			if(!$oResultado->error)
			{
				$this->oToken=$oResultado->result->accessToken;
				$this->clientIDUser=$oResultado->result->idusuario;
				return true;
			}
			else
			{
				$this->oToken=NULL;
			}
			
			return false;
			
			
		}
		
		function obtenerDocumentoFirmado($idDocumento)
		{
			try
			{
				$objResultado=NULL;
				
				if(!$this->oToken)
				{
					$this->generarTokenAcceso();
				}
				if($this->oToken)
				{
					$this->method="Archivos/ObtenerArchivosFirmadosById?id=".$idDocumento;
					
	
					
					$resultado=$this->callAPI("GET", $this->api.$this->method, NULL, $this->oToken,false, $setHeaders = false,$contentType="application/json");
					$resultado=str_replace("null",'""',$resultado);
	
					if($resultado=="[]")
					{
						
						$objResultado=json_decode('{"resultado":"0","msgErr":"No se ha encontrado el documento","noErr":"20"}');
					}
					else
						$objResultado=json_decode('{"resultado":"1","msgErr":"","noErr":"","datosComplementarios":'.$resultado.'}');
					
				}
				else
				{
					$objResultado=json_decode('{"resultado":"0","msgErr":"No se pudo obtener el token de autenticaci&oacute;n en el servidor de firma","noErr":"10"}');
				}
	
				return $objResultado;
			}
			catch(Exception $e)
			{
				return json_decode('{"resultado":"0","msgErr":"'.$e->getMessage().'","noErr":"30"}');
				
				
			}
		}		
		
		function generarFirmarElectronicaDocumento($cuerpoArchivo,$nombreArchivo,$tituloDocumento)
		{
			global $baseDir;
			try
			{
				$objResultado=NULL;
				
				if(!$this->oToken)
				{
					$this->generarTokenAcceso();
				}
				if($this->oToken)
				{
					$rutaArchivo=$baseDir."/archivosTemporales/".generarNombreArchivoTemporal();
					
					escribirContenidoArchivo($rutaArchivo,bD($cuerpoArchivo));
					
					$this->method="Archivos/FirmarArchivo";
					$arrParams["IdUsuario"]=$this->clientIDUser;
					$arrParams["Titulo"]=$tituloDocumento;
					$arrParams["Archivo"]=curl_file_create($rutaArchivo,"application/pdf",$nombreArchivo);

					$resultado=$this->callAPI("POST", $this->api.$this->method, $arrParams, $this->oToken,false, $setHeaders = false,$contentType="multipart/form-data");
					unlink($rutaArchivo);
					$resultado=str_replace("null",'""',$resultado);
					
					$objResultado=json_decode($resultado);
					if($objResultado->firmo==1)
					{
						$objResultado=json_decode('{"resultado":"1","msgErr":"","noErr":"","datosComplementarios":'.$resultado.'}');
					}
					else
					{
						$objResultado=json_decode('{"resultado":"0","msgErr":"Error: '.cv($objResultado->error).', Tipo error: '.$objResultado->tipoError.'","noErr":"40"}');
					}
					
				}
				else
				{
					$objResultado=json_decode('{"resultado":"0","msgErr":"No se pudo obtener el token de autenticaci&oacute;n en el servidor de firma","noErr":"10"}');
				}
	
				return $objResultado;
			}
			catch(Exception $e)
			{
				echo $e->getMessage();
				return json_decode('{"resultado":"0","msgErr":"'.$e->getMessage().'","noErr":"30"}');
			}
		}
		
		function firmarElectronicamenteDocumento($cuerpoArchivo,$nombreArchivo,$tituloDocumento)
		{
			global $baseDir;
			try
			{
				$respuesta =$this->generarFirmarElectronicaDocumento($cuerpoArchivo,$nombreArchivo,$tituloDocumento);
				if($respuesta->resultado==1)
				{
					$resultadoDocumento=$this->obtenerDocumentoFirmado($respuesta->datosComplementarios->idArchivoFirmado);
					if($resultadoDocumento->resultado==1)
					{
						return $resultadoDocumento;
					}
					return json_decode('{"resultado":"0","msgErr":"'.$resultadoDocumento->msgErr.'","noErr":"60"}');
					
				}
				return $respuesta;
			}
			catch(Exception $e)
			{
				echo $e->getMessage();
				return json_decode('{"resultado":"0","msgErr":"'.$e->getMessage().'","noErr":"50"}');
			}
		}
		
		function firmarElectronicamenteDocumentoPonente($cuerpoArchivo,$nombreArchivo,$tituloDocumento,$correosFirmantes)
		{
			global $baseDir;
			try
			{
				$this->correosFirmantes=$correosFirmantes;
				$respuesta =$this->generarFirmarElectronicaDocumentoPrimerPonente($cuerpoArchivo,$nombreArchivo,$tituloDocumento);
				if($respuesta->resultado==1)
				{
					$resultadoDocumento=$this->obtenerDocumentoFirmado($respuesta->datosComplementarios->idArchivoFirmado);
					if($resultadoDocumento->resultado==1)
					{
						return $resultadoDocumento;
					}
					return json_decode('{"resultado":"0","msgErr":"'.$resultadoDocumento->msgErr.'","noErr":"60"}');
					
				}
				return $respuesta;
			}
			catch(Exception $e)
			{
				echo $e->getMessage();
				return json_decode('{"resultado":"0","msgErr":"'.$e->getMessage().'","noErr":"50"}');
			}
		}
		
		function firmarElectronicamenteDocumentoColaborador($idDocumento,$tipoFirma,$comentariosAdicionales)
		{
			global $baseDir;
			try
			{
				
				$respuesta =$this->generarFirmarElectronicaDocumentoColaborador($idDocumento,$tipoFirma,$comentariosAdicionales);
				if($respuesta->resultado==1)
				{
					$resultadoDocumento=$this->obtenerDocumentoFirmado($idDocumento);
					if($resultadoDocumento->resultado==1)
					{
						return $resultadoDocumento;
					}
					return json_decode('{"resultado":"0","msgErr":"'.$resultadoDocumento->msgErr.'","noErr":"60"}');
					
				}
				return $respuesta;
			}
			catch(Exception $e)
			{
				echo $e->getMessage();
				return json_decode('{"resultado":"0","msgErr":"'.$e->getMessage().'","noErr":"50"}');
			}
		}
		
		
		function firmarElectronicamenteDocumentoColegiado($idDocumento)
		{
			global $baseDir;
			try
			{
				
				$respuesta =$this->generarFirmaElectronicaDocumentoColegiado($idDocumento);
				if($respuesta->resultado==1)
				{
					$resultadoDocumento=$this->obtenerDocumentoFirmado($respuesta->datosComplementarios->idArchivoFirmado);
					if($resultadoDocumento->resultado==1)
					{
						return $resultadoDocumento;
					}
					return json_decode('{"resultado":"0","msgErr":"'.$resultadoDocumento->msgErr.'","noErr":"60"}');
					
				}
				return $respuesta;
			}
			catch(Exception $e)
			{
				echo $e->getMessage();
				return json_decode('{"resultado":"0","msgErr":"'.$e->getMessage().'","noErr":"50"}');
			}
		}
		
		
		
		function generarFirmarElectronicaDocumentoPrimerPonente($cuerpoArchivo,$nombreArchivo,$tituloDocumento)
		{
			global $baseDir;
			try
			{

				$objResultado=NULL;
				
				if(!$this->oToken)
				{
					$this->generarTokenAcceso();
				}
				if($this->oToken)
				{
					$rutaArchivo=$baseDir."/archivosTemporales/".generarNombreArchivoTemporal();
					
					escribirContenidoArchivo($rutaArchivo,bD($cuerpoArchivo));
					
					$firmantes="";
					foreach($this->correosFirmantes as $oFirmante)
					{
						if($firmantes=="")
							$firmantes=$oFirmante["mail"];
						else
							$firmantes.=";".$oFirmante["mail"];
					}
					
					$this->method="Archivos/InsertarArchivoFirmaColegiada";
					$arrParams["IdUsuario"]=$this->clientIDUser;
					$arrParams["NombreArchivo"]=$tituloDocumento;
					$arrParams["Archivo"]=curl_file_create($rutaArchivo,"application/pdf",$nombreArchivo);
					$arrParams["Correo"]=$firmantes;
					$arrParams["Mensaje"]="Firma colegiada de documento: ".$tituloDocumento;
					$arrParams["FechaLimite"]=date("Y-m-d",strtotime("+1 year",strtotime(date("Y-m-d"))));
					

					$resultado=$this->callAPI("POST", $this->api.$this->method, $arrParams, $this->oToken,false, $setHeaders = false,$contentType="multipart/form-data");
					unlink($rutaArchivo);
					$resultado=str_replace("null",'""',$resultado);
					
					$objResultado=json_decode($resultado);
					if($objResultado->firmo==1)
					{
						$objResultado=json_decode('{"resultado":"1","msgErr":"","noErr":"","datosComplementarios":'.$resultado.'}');
					}
					else
					{
						$objResultado=json_decode('{"resultado":"0","msgErr":"Error: '.cv($objResultado->error).', Tipo error: '.$objResultado->tipoError.'","noErr":"40"}');
					}
					
				}
				else
				{
					$objResultado=json_decode('{"resultado":"0","msgErr":"No se pudo obtener el token de autenticaci&oacute;n en el servidor de firma","noErr":"10"}');
				}
	
				return $objResultado;
			}
			catch(Exception $e)
			{
				echo $e->getMessage();
				return json_decode('{"resultado":"0","msgErr":"'.$e->getMessage().'","noErr":"30"}');
			}
		}
		
		function generarFirmarElectronicaDocumentoColaborador($idDocumento,$tipoFirma,$comentariosAdicionales)
		{
			global $baseDir;
			try
			{

				$objResultado=NULL;
				
				if(!$this->oToken)
				{
					$this->generarTokenAcceso();
				}
				if($this->oToken)
				{
					
					$this->method="Archivos/ActualizarYFirmaArchivoColegiada";
					$arrParams["idUsuario"]=$this->clientIDUser;
					$arrParams["isFirmado"]=$tipoFirma;
					$arrParams["observaciones"]=$comentariosAdicionales;
					$arrParams["idArhivoFirmaElectronica"]=$idDocumento;
					
					
					$arrParametros=array();
					array_push($arrParametros,$arrParams);
					

					$resultado=$this->callAPI("POST", $this->api.$this->method, $arrParametros, $this->oToken,true, $setHeaders = false,$contentType="application/json");

					$resultado=str_replace("null",'""',$resultado);
					
					$objResultado=json_decode($resultado);
					if($objResultado->resultado)
					{
						$objResultado=json_decode('{"resultado":"1","msgErr":"","noErr":"","datosComplementarios":'.$resultado.'}');
					}
					else
					{
						$objResultado=json_decode('{"resultado":"0","msgErr":"Error: '.cv($objResultado->error).', Tipo error: '.$objResultado->tipoError.'","noErr":"40"}');
					}
					
				}
				else
				{
					$objResultado=json_decode('{"resultado":"0","msgErr":"No se pudo obtener el token de autenticaci&oacute;n en el servidor de firma","noErr":"10"}');
				}
	
				return $objResultado;
			}
			catch(Exception $e)
			{
				echo $e->getMessage();
				return json_decode('{"resultado":"0","msgErr":"'.$e->getMessage().'","noErr":"30"}');
			}
		}
		
		function generarFirmaElectronicaDocumentoColegiado($idDocumento)
		{
			global $baseDir;
			try
			{

				$objResultado=NULL;
				
				if(!$this->oToken)
				{
					$this->generarTokenAcceso();
				}
				if($this->oToken)
				{

					$this->method="Archivos/FirmarDocumentoColegiadoExt";
					$arrParams["idArchivoFirmaElectronica"]=$idDocumento;
					$resultado=$this->callAPI("POST", $this->api.$this->method, $arrParams, $this->oToken,true, $setHeaders = false,$contentType="application/json");

					$resultado=str_replace("null",'""',$resultado);
					
					$objResultado=json_decode($resultado);
					if($objResultado->firmo)
					{
						$objResultado=json_decode('{"resultado":"1","msgErr":"","noErr":"","datosComplementarios":'.$resultado.'}');
					}
					else
					{
						$objResultado=json_decode('{"resultado":"0","msgErr":"Error: '.cv($objResultado->error).', Tipo error: '.$objResultado->tipoError.'","noErr":"40"}');
					}
					
				}
				else
				{
					$objResultado=json_decode('{"resultado":"0","msgErr":"No se pudo obtener el token de autenticaci&oacute;n en el servidor de firma","noErr":"10"}');
				}
	
				return $objResultado;
			}
			catch(Exception $e)
			{
				echo $e->getMessage();
				return json_decode('{"resultado":"0","msgErr":"'.$e->getMessage().'","noErr":"30"}');
			}
		}
		
		
		function callAPI($method, $url, $data, $token,$isJSON = false, $setHeaders = false,$contentType="application/x-www-form-urlencoded")
		{

			$curl = curl_init();
			$headers=array();
			if($token)
			{
				array_push($headers, 'Authorization: Bearer ' . $token);
			
			}
			if($contentType!="")	
				array_push($headers, 'Content-Type: '.$contentType);
			
			
			
			if(($method == "POST" || $method == "PATCH"))
			{
			   	if($method == "PATCH")
			 	{
				 	curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PATCH");
			   	}
				else
				{
				 	curl_setopt($curl, CURLOPT_POST, 1);
			   	}
				
			   	if($data)
				{
				  if($isJSON) 
				  {
					  
					
				  	curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
				  }
				  else 
				  {
					  	if($contentType!="multipart/form-data")
						{

							curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
						}
						else
						{

							curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
						}
				  }
			   	}
				  
			}
			else 
				if($method == "DELETE")
				{
					curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
				}
				else 
					if($method == "PUT")
					{
						curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
						curl_setopt($curl, CURLOPT_POSTFIELDS, $data ); 
						if($setHeaders)
						{
							$headers = array_merge($headers, $setHeaders);
						}
						

					}
			
			curl_setopt($curl, CURLOPT_URL, $url);

			$curl_error = curl_error($curl);
			
			curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
			curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
			curl_setopt($curl, CURLOPT_TIMEOUT , 5);
			$result = curl_exec($curl);
			$info = curl_getinfo($curl);
			
			if(!$result && $method !== 'DELETE')
			{
				die("Connection Failure ". curl_error($curl) . curl_errno($curl));
			}
			curl_close($curl);
			return $result;
		} 
		
	}
?>        