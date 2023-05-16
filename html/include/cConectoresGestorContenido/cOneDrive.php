<?php 	include_once("conexionBD.php");	
		
		$consulta="SELECT archivoInclude FROM 20000_conectoresServiciosNube"; 
		$res=$con->obtenerFilas($consulta);
		while($filaConector=mysql_fetch_assoc($res))
		{
			include_once($filaConector["archivoInclude"]);	
		}
		include_once("cConectoresGestorContenido/cBaseConectorGestorDocumental.php");
		
		
		class cOneDrive extends cBaseConectorGestorDocumental
		{
			
			var $conexion;
			var $ipServidor;
			var $usuario;
			var $password;
			var $raizServidor;
			var $fInfoComplementaria;
			var $statusActual;
			var $cConexion;
			
			function cOneDrive($urlServidor,$usuarioServidor,$passwordServidor,$raizServidor,$infoComp=NULL)
			{
				global $con;
				$this->ipServidor=$urlServidor;
				$this->usuario=$usuarioServidor;
				$this->password= $passwordServidor;
				$this->raizServidor=$raizServidor;
				$this->fInfoComplementaria=$infoComp;
				$this->statusActual=0;

				
				$consulta="SELECT tipoConector FROM 20001_conexionesServiciosNube WHERE idConexion=".$infoComp["idConexion"];
				$tipoConector=$con->obtenerValor($consulta);
				
				$consulta="SELECT nombreClase FROM 20000_conectoresServiciosNube WHERE idTipoConector=".$tipoConector;
				$nombreClase=$con->obtenerValor($consulta);
	
				eval('$this->cConexion= new '.$nombreClase.'('.$infoComp["idConexion"].');'); 
				
				
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
				$ruta=str_replace(" ","_",$ruta);
				return $ruta;
					
			}
			
			function conectar()
			{
				try
				{
					$response = $this->cConexion->ejecutarAPI("GET","me/drive/root/children");
					
					if(!$response)
					{
						$this->statusActual=0;
						return false;
					}
					$this->statusActual=1;
				
					return true;		
					
				}
				catch(Exception $e)
				{
					$this->statusActual=0;
					$this->conexion=NULL;
					return false;
					
				}
				$this->conexion=NULL;
				return false;

			}
			
			function existeRecurso($rutaRecurso)
			{
				$rutaRecurso=$this->normalizarRuta($rutaRecurso);

				if($this->statusActual==0)
				{
					$this->conectar();
				}

				if($this->statusActual==1)
				{
					try
					{
						$arrPath=explode("/",$rutaRecurso);
						unset($arrPath[0]);
						
						$pathActual="/";
						$resItemDrive="";
						$encontrado=false;
						foreach($arrPath as $item)
						{
							
							$resItemDrive=$this->existeItemDrive($pathActual,urlencode($item));
							
							if(!$resItemDrive)
							{
								return false;
							}
							if($pathActual=="/")
								$pathActual.=$resItemDrive;
							else
								$pathActual.=";".$resItemDrive;
							$encontrado=true;
						}
						
						return $encontrado;
						
					}
					catch(Exception $e)
					{
						return false;
					}
				}
				return NULL;
				
			}
			
			function existeItemDrive($path,$itemSearch)
			{
				
				$query=null;
				if($path=="/")
				{
					$query="me/drive/root/children";

				}
				else
				{
					$item = $this->currentPathObject($path);
					$query="me/drive/items/".$item->id."/children";
				}

				$response=$this->cConexion->ejecutarAPI("GET",$query);
				$response=json_decode($response);
				
				foreach ($response->value as $item) 
				{
					
					if(($item->name)&&(mb_strtoupper($item->name)==mb_strtoupper($itemSearch)))
					{
						return ''.$item->name.'|'.$item->id.'|'.(isset($item->folder)?"":$item->{"@microsoft.graph.downloadUrl"});
						
					}
					
				}
				return false;
				
			}
			
			function currentPathObject($path)
			{
			   $path = explode(";", $path);
			   $path = $path[sizeof($path)-1];
			   $path = explode("|", $path);
			   
			   $cadObj='{"id":"'.$path[1].'","name":"'.$path[0].'","urlDescarga":"'.$path[2].'"}';
			   
			   return json_decode($cadObj);
			}
			
			function existeObjeto($idDocumento)
			{
				return $this->existeRecurso($idDocumento);
				
			}
			
			function crearDirectorio($rutaDirectorio)
			{
				$rutaDirectorio=$this->normalizarRuta($rutaDirectorio);
				if($this->existeRecurso($rutaDirectorio))
				{
					return true;
				}
				
				if($this->statusActual==0)
				{
					$this->conectar();
				}

				if($this->statusActual==1)
				{
					$arrRuta=explode("/",$rutaDirectorio);

					$rutaPadre="/";
					$rutaActual="/";
					foreach($arrRuta as $r)
					{
						if($r!="")
						{
							$rutaActual.="/".$r;
							$rutaActual=$this->normalizarRuta($rutaActual);
							if(!$this->existeRecurso($rutaActual))
							{
								if($rutaPadre=="/")
								{
									$query="me/drive/root/children";
									
								}
								else
								{
									$path=$this->getIDItemDocument($rutaPadre);
									$item = $this->currentPathObject($path);
									$query="me/drive/items/".$item->id."/children";
									
								}
								

								$params = array	(
													"name" => $this->normalizarRuta($r),
													"folder" => new stdClass(),
													"@microsoft.graph.conflictBehavior" => "rename"
												 );

								$response=$this->cConexion->ejecutarAPI("POST",$query,$params,"",true);
								$response=json_decode($response);
								
								

							}
							
							$rutaPadre.="/".$r;
							$rutaPadre=$this->normalizarRuta($rutaPadre);
							
							
							
						}
					}
					return true;
				}
				return false;
			}
			
			function obtenerDocumento($idDocumento)
			{
				try
				{

					$documento=$this->existeObjeto($idDocumento);
					if($documento)
					{
						$contenidoArchivo="";
						$path=$this->getIDItemDocument($idDocumento);
						$item = $this->currentPathObject($path);
						$contenido=file_get_contents($item->urlDescarga);

						$urlContenido="";
						foreach($http_response_header as $linea)
						{
							if(strpos($linea,"Content-Location:")!==false)
							{
								$arrContenido=explode("Content-Location: ",$linea);
								$urlContenido=$arrContenido[1];
								break;
							}
							
						}
						$contenidoArchivo=file_get_contents($urlContenido);
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
			
			function obtenerDocumentoPDF($idDocumento,$getURL=false)
			{
				try
				{
					
					error_reporting(E_ALL ^ E_DEPRECATED ^ E_WARNING);
					$documento=$this->existeObjeto($idDocumento);
					if($documento)
					{
						$this->cConexion->actualizarTokenConexion();
						$contenidoArchivo="";
						$path=$this->getIDItemDocument($idDocumento);
						
						
						
						$item = $this->currentPathObject($path);
						
						

						$query="me/drive/items/".$item->id."/content?format=pdf";

						
						$curl = curl_init();
						$headers = array(
														 'Authorization: Bearer ' . $this->cConexion->oToken->access_token
													  );
						
						$url=$this->cConexion->api.$query;
						curl_setopt($curl, CURLOPT_URL, $url);
						curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
						$curl_error = curl_error($curl);
						curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
					   	$result = curl_exec($curl);
					   	$info = curl_getinfo($curl);
					   	if(isset($info["http_code"])=="302")
					   	{
						   	if($getURL)
						   	{
								return $info["redirect_url"];
							}
							else
							{
								
								$contenidoArchivo=file_get_contents($info["redirect_url"]);
								if(strlen($contenidoArchivo)!=0)
									return $contenidoArchivo;
								else
								{
									$totalIntentos=1;
									return $this->obtenerDocumentoPDFRetry($curl,$totalIntentos);
								}
							}
						   
					   	}
						return NULL;
					}
					else
					{
						return NULL;
					}
					
					return NULL;
				}
				catch(Exception $e)
				{

					return NULL;
				}
			}
			
			function obtenerDocumentoPDFRetry($curl,&$totalIntentos)
			{
				try
				{
					error_reporting(E_ALL ^ E_DEPRECATED ^ E_WARNING);
					$result = curl_exec($curl);
					$info = curl_getinfo($curl);
					if(isset($info["http_code"])=="302")
					{
						
							
						$contenidoArchivo=@file_get_contents($info["redirect_url"]);
						if(strlen($contenidoArchivo)!=0)
						{
							return $contenidoArchivo;
						}
						else
						{
							$totalIntentos++;	
							if($totalIntentos<6)
							{
								return $this->obtenerDocumentoPDFRetry($curl,$totalIntentos);
							}
							else
								return NULL;
						}
					}
					return NULL;
				}
				catch(Exception $e)
				{
					
					return NULL;
				}
			}
			
			
			function obtenerUrlDocumentoEdicion($idDocumento)
			{
				$documento=$this->existeObjeto($idDocumento);
				if($documento)
				{
					$contenidoArchivo="";
					$path=$this->getIDItemDocument($idDocumento);
					$item = $this->currentPathObject($path);
					$params = array(
										 "type" => "edit",
										 "scope" => "anonymous"
								   );
				   
				
					$response=$this->cConexion->ejecutarAPI("POST","me/drive/items/".$item->id."/createLink",$params,"",true);
					$response=json_decode($response);
					if($response)
					{
						return $response->link->webUrl;
					}
					return "";
				}
				return "";
			}
			
			function obtenerUrlDocumentoVisualizacionEmbebido($idDocumento)
			{
				$documento=$this->existeObjeto($idDocumento);
				if($documento)
				{
					$contenidoArchivo="";
					$path=$this->getIDItemDocument($idDocumento);
					$item = $this->currentPathObject($path);
					$params = array(
										 "type" => "embed",
										 "scope" => "anonymous"
								   );
				   

					$response=$this->cConexion->ejecutarAPI("POST","me/drive/items/".$item->id."/createLink",$params,"",true);
					$response=json_decode($response);
					

					if($response && isset($response->link))
					{
						return $response->link->webUrl;
					}
					return "";
				}
				return "";
			}
			
			function removerRecurso($idDocumento)
			{
				$documento=$this->existeObjeto($idDocumento);
				if($documento)
				{
					$contenidoArchivo="";
					$path=$this->getIDItemDocument($idDocumento);
					$item = $this->currentPathObject($path);
					$query="me/drive/items/".$item->id;
					$response = $this->cConexion->ejecutarAPI("DELETE",$query);
					$response=json_decode($response);
					if($response)
					{
						return true;
					}
					return false;
				}
				return true;
			}
			
			function moverDocumento($idDocumento,$rutaDirectorio)
			{
				global $con;
				try
				{
					if(($this->existeObjeto($idDocumento)) && ($this->existeObjeto($rutaDirectorio)||($rutaDirectorio=="/")))
					{
						$idItemOrigen=$this->getIDItemDocument($idDocumento);
						$idItemDestino=	$this->getIDItemDocument($rutaDirectorio);
						
						$iOrigen=$this->currentPathObject($idItemOrigen);
						$iDestino=$this->currentPathObject($idItemDestino);
						
						
						$params = array	(
											"parentReference" => array("id"=>$iDestino->id),
											"name" => $iOrigen->name
										 );
						
						$query="me/drive/items/".$iOrigen->id;
						
						
						$response=$this->cConexion->ejecutarAPI("PATCH",$query,$params,"",true);
						$oResp=json_decode($response);
						
						if(!isset($oResp->error))
						{
							return true;
						}
						return false;

						
						//$consulta="UPDATE 908_archivos SET documentoRepositorio='".$destinoArchivo."' WHERE documentoRepositorio='".$idDocumento."'";
						//$con->ejecutarConsulta($consulta);

					}
					else
						return false;
					
				}
				catch(Exception $e)
				{
					//echo $e->getMessage();
					return false;
				}
			}
			
			function crearDocumento($rutaDirectorio,$nombreDocumento,$contenidoDocumento)
			{
				global $baseDir;
				$nombreDocumento=$this->normalizarNombreArchivo($nombreDocumento);
				$rutaArchivo=$baseDir."/archivosTemporales/".generarNombreArchivoTemporal();
				escribirContenidoArchivo($rutaArchivo,bD($contenidoDocumento));
				if(file_exists($rutaArchivo))
				{
					
					$query="me/drive";
					$responseDrive=$this->cConexion->ejecutarAPI("GET",$query,null);
					$responseDrive=json_decode($responseDrive);
					$size=filesize($rutaArchivo);
					$params = array(
												"item" => array(
																	"@microsoft.graph.conflictBehavior" => "replace",
																	//"fileSize" => $size,
																	"fileSystemInfo" => array("@odata.type" => "microsoft.graph.fileSystemInfo"),
																	"name" => $nombreDocumento
																)
											);
					
					
					
					$query="me/drive/root:/".$nombreDocumento.":/createUploadSession";
					

					
					$response=$this->cConexion->ejecutarAPI("POST",$query,$params,"",true);
					$response=json_decode($response);

					
					
					$idItem=NULL;
					$fgetsLength = 100000000;
					if($fgetsLength > $size) 
						$fgetsLength = $size;
					$handle = fopen($rutaArchivo, 'r');
					$i = 0;
					while (!feof($handle)) 
					{
					   $firstByte = $i * $fgetsLength;
					   $lastByte = ($i + 1) * $fgetsLength - 1;
					   
					   if(($i + 1) * $fgetsLength - 1 > $size)
					   {
						  $fgetsLength  = $size - ($i * $fgetsLength);
						  $lastByte = $size - 1;
					   }
					   $bytes = fread($handle, $fgetsLength);
					   
					   
					   $headers = array(
										  "Content-Length: ".$fgetsLength,
										  "Content-Range: bytes ".$firstByte."-".$lastByte."/".$size
									   );
							
					   $uploaded=$this->cConexion->ejecutarAPI("PUT",$response->uploadUrl,$bytes,"",false,false,$headers);
					   $uploaded=json_decode($uploaded);
					   
					   
					   if(isset($uploaded->createdBy))
					   { 
					   		$idItem=$uploaded->id;
							break;
					   }
					   $i++;
					   
					}
					if($idItem)
					{
						$this->moverDocumento("/".$nombreDocumento,$rutaDirectorio);
					}
					unlink($rutaArchivo);
				}
				else
					return false;
				return true;
			}
			
			/////
			function getIDItemDocument($rutaDirectorio)
			{
				$rutaDirectorio=$this->normalizarRuta($rutaDirectorio);
				
				if($this->statusActual==0)
				{
					$this->conectar();
				}
				if($this->statusActual==1)
				{
					
					if($rutaDirectorio=="/")
					{
						$query="/me/drive/root";
						$response = $this->cConexion->ejecutarAPI("GET",$query);
						$response=json_decode($response);
						
						if($response)
						{
							return ''.$response->name.'|'.$response->id.'|'.(isset($response->folder)?"":$response->{"@microsoft.graph.downloadUrl"});
						}
					}
					
					$arrPath=explode("/",$rutaDirectorio);
					unset($arrPath[0]);
					
					$pathActual="/";
					$resItemDrive="";

					foreach($arrPath as $item)
					{
						
						$resItemDrive=$this->existeItemDrive($pathActual,urlencode($item));
						
						if(!$resItemDrive)
						{
							return false;
						}
						if($pathActual=="/")
							$pathActual.=$resItemDrive;
						else
							$pathActual.=";".$resItemDrive;
						
					}

					return $resItemDrive;
				}
			}
			
			
			
		}

?>
