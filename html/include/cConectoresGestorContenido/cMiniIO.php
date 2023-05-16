<?php 	include_once("conexionBD.php");	
		include_once("cmis/cmis_service.php");
		include_once("awsMiniIO/aws-autoloader.php");
		//include_once("latisErrorHandler.php");
		include_once("cConectoresGestorContenido/cBaseConectorGestorDocumental.php");
		
		class cMiniIO extends cBaseConectorGestorDocumental
		{
			
			var $conexion;
			var $ipServidor;
			var $usuario;
			var $password;
			var $raizServidor;
			var $fInfoComplementaria;
			var $statusActual;
			
			function cMiniIO($urlServidor,$usuarioServidor,$passwordServidor,$raizServidor,$infoComp=NULL)
			{
				global $con;
				$this->ipServidor=$urlServidor;
				$this->usuario=$usuarioServidor;
				$this->password= $passwordServidor;
				$this->raizServidor=$raizServidor;
				$this->fInfoComplementaria=$infoComp;
				$statusActual=0;
			}
			
			function conectar()
			{
				try
				{
					if(mb_strtoupper($this->ipServidor)!="NONE")
					{

						$this->conexion = new Aws\S3\S3Client([
	
																"version" => "latest",
																"region" => "us-east-1",
																"endpoint" =>$this->ipServidor,	
																"http"    => [
																				'connect_timeout' => 3
																			],										
																"use_path_style_endpoint" => true,											
																"credentials" => [
																					"key" =>  $this->usuario,
																					"secret" =>  $this->password,
																
																				],                                        
												
															]);
					}
					else
					{

						$this->conexion = new Aws\S3\S3Client([
	
																"version" => "latest",
																"region" => "us-east-1",
																"http"    => [
																				'connect_timeout' => 3
																			],										
																"use_path_style_endpoint" => true,											
																"credentials" => [
																					"key" =>  $this->usuario,
																					"secret" =>  $this->password,
																
																				],                                        
												
															]);
					}
														
					$this->conexion->listBuckets();
					$existeRaiz=$this->conexion->doesBucketExist($this->raizServidor);

					if(!$existeRaiz)
					{

						$this->conexion->CreateBucket	(
															[
																"Bucket" => $this->raizServidor
															]
														);
					}
					else
					{

					}
					$this->statusActual=1;
					return true;		
					
				}
				catch(Exception $e)
				{
					
					$mensaje=$e->getMessage();

					if(strpos($mensaje,"Connection refused")!==false)
					{
						$this->statusActual=0;//No se pudo establecer la conexi&oacute;n con el servidor
					}
					else
					{
						if(strpos($mensaje,"InvalidAccessKeyId")!==false)
						{
							$this->statusActual=2;//El Usuario o la Contrase&ntilde;a es incorrecta
						}
						else
						{
							if(strpos($mensaje,"Could not resolve host")!==false)
							{
								$this->statusActual=3;//La URL de conexi&oacute;n al servidor es incorrecta
							}
							else
							{
								if(strpos($mensaje,"Connection timed")!==false)
								{
									$this->statusActual=4;//Error de conexion
								}
							}
						}
						
						
					}
					$this->conexion=NULL;
					return false;
				}
				

			}
			
			function existeRecurso($rutaRecurso)
			{
				$rutaRecurso=$this->normalizarRuta($rutaRecurso);
				if(!$this->conexion)
				{
					$this->conectar();
				}
				if($this->conexion)
				{
					try
					{
						$recurso = $this->conexion->doesObjectExist($this->raizServidor,$rutaRecurso);
						return $recurso;
					}
					catch(Exception $e)
					{
						return NULL;
						
						
					}
					
				}
				
				return NULL;
				
			}
			
			function existeObjeto($idDocumento)
			{
				return $this->existeRecurso($idDocumento);
				
			}
			
			function crearDirectorio($rutaDirectorio)
			{
				try
				{
					$arrRuta=explode($this->raizServidor."/",$rutaDirectorio);
					$rutaDirectorio=$arrRuta[count($arrRuta)-1];

				
					$rutaDirectorio.="/";
					$rutaDirectorio=str_replace("//","/",$rutaDirectorio);
					$rutaDirectorio=$this->normalizarRuta($rutaDirectorio);
					
					
					
					if(!$this->conexion)
					{
						$this->conectar();
					}
					if($this->conexion)
					{
						if(!$this->existeRecurso($rutaDirectorio))
						{
							$this->conexion->putObject(	array(
																	'Bucket' => $this->raizServidor,
																	'Key'    => $rutaDirectorio,
																	'Body'   => ""
																)
														);
						}
						return true;
					}
					return false;
				}
				catch(Exception $e)
				{

					return NULL;
					
					
				}
					

				
			}
			
			
			function normalizarRuta($ruta)
			{
				$ruta=str_replace("//","/",$ruta);
				$ruta=str_replace("-","",$ruta);
				$ruta=str_replace("*","",$ruta);
				$ruta=str_replace("\"","",$ruta);
				$ruta=str_replace("<","",$ruta);
				$ruta=str_replace(">","",$ruta);
				$ruta=str_replace("\\","",$ruta);
				//$ruta=str_replace(".","",$ruta);
				$ruta=str_replace("?","",$ruta);
				$ruta=str_replace(" ","_",$ruta);
				return $ruta;
					
			}
			
			function normalizarNombreArchivo($ruta)
			{
				$ruta=str_replace("//","/",$ruta);
				$ruta=str_replace("-","",$ruta);
				$ruta=str_replace("*","",$ruta);
				$ruta=str_replace("\"","",$ruta);
				$ruta=str_replace("<","",$ruta);
				$ruta=str_replace(">","",$ruta);
				$ruta=str_replace("\\","",$ruta);
				$ruta=str_replace("?","",$ruta);
				$ruta=str_replace("¿","",$ruta);
				$ruta=str_replace("!","",$ruta);
				$ruta=str_replace("¡","",$ruta);
				$ruta=str_replace(" ","_",$ruta);
				$ruta=str_replace("~","",$ruta);
				$ruta=str_replace("(","_",$ruta);
				$ruta=str_replace(")","_",$ruta);
				$ruta=str_replace("[","_",$ruta);
				$ruta=str_replace("]","_",$ruta);
				return quitarAcentos($ruta);
					
			}
			
			function crearDocumento($rutaDirectorio,$nombreDocumento,$contenidoDocumento)
			{
				$arrRuta=explode($this->raizServidor."/",$rutaDirectorio);
				$rutaDirectorio=$arrRuta[count($arrRuta)-1];
				$rutaDirectorio=$this->normalizarRuta($rutaDirectorio);
				try
				{
					if($this->crearDirectorio($rutaDirectorio))
					{
						$nombreDocumento=$this->normalizarNombreArchivo($nombreDocumento);	
						
						$nombreDocumentoFinal=str_replace("//","/",$rutaDirectorio."/".$nombreDocumento);
						$this->conexion->putObject(	array(
																	'Bucket' => $this->raizServidor,
																	'Key'    => $nombreDocumentoFinal,
																	'Body'   => $contenidoDocumento
																)
													);
						
						
						$objResultado=json_decode('{"id":"'.cv($nombreDocumentoFinal).'"}');

						return $objResultado;
					}
					else
						return false;
				}
				catch(Exception $e)
				{
					return false;
				}
			
			}
			
			function obtenerDocumento($idDocumento)
			{
				try
				{

					$documento=$this->existeObjeto($idDocumento);
					if($documento)
					{
						$contenidoArchivo="";
						$resultado= $this->conexion->getObject(array(
																			'Bucket' => $this->raizServidor,
																			'Key'    => $idDocumento
																		));
					
						
						$resultado['Body']->rewind();
						
						while ($data = $resultado['Body']->read(1024)) 
						{
							$contenidoArchivo.=$data;
						}
						
						return $contenidoArchivo;
						
						
					}
					else
					{
						return NULL;
					}
					
					return NULL;
				}
				catch(Exception $e)
				{
					varDUmp($e->getMessage());
					return NULL;
				}
			}
			
			function moverDocumento($idDocumento,$rutaDirectorio)
			{
				global $con;
				try
				{
					$arrRuta=explode("/",$rutaDirectorio);
					if($this->existeObjeto($idDocumento))
					{
						
						$rutaDirectorio=$this->normalizarRuta($rutaDirectorio);
						
						$arrArchivos=explode("/",$idDocumento);
						$destinoArchivo=$rutaDirectorio."/".$arrArchivos[count($arrArchivos)-1];
						$destinoArchivo=str_replace("//","/",$destinoArchivo);
						
						if($this->crearDirectorio($rutaDirectorio))
						{
							$key=$destinoArchivo;
							
							
							
							$resultado=$this->conexion->copyObject	(
																		array	(
																					'Bucket'=>$this->raizServidor,
																					'CopySource'=>$this->raizServidor."/".$idDocumento,
																					'Key'=>$key
																				)
																	);
							
							
							
																							
							if($this->existeObjeto($key))
							{																	
																	
								$resultado=$this->conexion->deleteObject(array(
																	'Bucket' =>$this->raizServidor,
																	'Key' => $idDocumento
																	)
															);
			
							
								$consulta="UPDATE 908_archivos SET documentoRepositorio='".$destinoArchivo."' WHERE documentoRepositorio='".$idDocumento."'";
								$con->ejecutarConsulta($consulta);
								return true;
							}
							return false;
						}
					}
					else
					{
						
						return false;
					}
				}
				catch(Exception $e)
				{
					echo $e->getMessage();
					return false;
				}
			}
			
		}

?>