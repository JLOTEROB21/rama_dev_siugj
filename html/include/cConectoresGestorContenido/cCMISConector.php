<?php 	include_once("conexionBD.php");	
		include_once("cmis/cmis_service.php");
		//include_once("latisErrorHandler.php");
		include_once("cConectoresGestorContenido/cBaseConectorGestorDocumental.php");
		
		class cCMISConector extends cBaseConectorGestorDocumental
		{
			
			var $conexion;
			var $ipServidor;
			var $usuario;
			var $password;
			var $raizServidor;
			var $fInfoComplementaria;
			var $statusActual;
			
			function cCMISConector($urlServidorCMIS,$usuarioServidorCMIS,$passwordServidorCMIS,$raizServidorCMIS,$infoComp=NULL)
			{
				global $con;
				$this->ipServidor=$urlServidorCMIS;
				$this->usuario=$usuarioServidorCMIS;
				$this->password= $passwordServidorCMIS;
				$this->raizServidor=$raizServidorCMIS;
				$this->fInfoComplementaria=$infoComp;
				$statusActual=0;
			}
			
			function conectar()
			{
				try
				{
					$this->conexion = new CMISService($this->ipServidor, $this->usuario, $this->password);
					$this->statusActual=1;

					return true;		
					
				}
				
				
				catch(CmisObjectNotFoundException $e)
				{
					$this->statusActual=3;
				}
				catch(Exception $e)
				{
					$res=$e->getMessage();
					if($res!="")
					{
						$objEx=json_decode($res);
						if(isset($objEx->status))
						{
							if($objEx->status->code==401)
							{
								$this->statusActual=2;

							}
						}
						else
						{
							$this->statusActual=4;
						}
					}
					else
						$this->statusActual=0;
					
					
				}
				$this->conexion=NULL;
				return false;

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
						$recurso = $this->conexion->getObjectByPath($rutaRecurso);
						return true;
					}
					catch(CmisObjectNotFoundException $e)
					{
						
						return false;
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
				if(!$this->conexion)
				{
					$this->conectar();
				}
				if($this->conexion)
				{
					try
					{
						$documento=$this->conexion->getObject($idDocumento);
						return $documento;
					}
					catch(CmisObjectNotFoundException $e)
					{

						return false;
					}
					catch(Exception $e)
					{

						return NULL;
						
						
					}
					
				}
				
				return NULL;
				
			}
			
			function crearDirectorio($rutaDirectorio)
			{
				$rutaDirectorio=$this->normalizarRuta($rutaDirectorio);
				if(!$this->conexion)
				{
					$this->conectar();
				}
				if($this->conexion)
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
								$folderPadre = $this->conexion->getObjectByPath($rutaPadre);
								$resultado = $this->conexion->createFolder($folderPadre->id, $r);
								

							}
							
							$rutaPadre.="/".$r;
							$rutaPadre=$this->normalizarRuta($rutaPadre);
							
							
							
						}
					}
					return true;
				}
				return false;
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
				$ruta=str_replace(".","",$ruta);
				$ruta=str_replace("?","",$ruta);
				$ruta=str_replace(" ","%20",$ruta);
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
				//$ruta=str_replace(" ","%20",$ruta);
				return $ruta;
					
			}
			
			function crearDocumento($rutaDirectorio,$nombreDocumento,$contenidoDocumento)
			{
				$rutaDirectorio=$this->normalizarRuta($rutaDirectorio);
				try
				{
					if($this->crearDirectorio($rutaDirectorio))
					{
						$nombreDocumento=$this->normalizarNombreArchivo($nombreDocumento);	
						$folderPadre = $this->conexion->getObjectByPath($rutaDirectorio);
						$resultado =  $this->conexion->createDocument($folderPadre->id, $nombreDocumento, array (), $contenidoDocumento, "application/octet-stream");
						return $resultado;
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

						return $this->conexion->getContentStream($idDocumento);
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
			
			function moverDocumento($idDocumento,$rutaDirectorio)
			{
				try
				{
					$rutaDirectorio=$this->normalizarRuta($rutaDirectorio);
					if($this->crearDirectorio($rutaDirectorio))
					{
						$documento=$this->conexion->getObject($idDocumento);
						$folderOrigen=$this->conexion->getFolderParent($idDocumento);
						$folderDestino = $this->conexion->getObjectByPath($rutaDirectorio);
						$this->conexion->moveObject($idDocumento, $folderDestino->id, $folderOrigen->id);
						return true;
					}
				}
				catch(Exception $e)
				{
					return false;
				}
			}
			
		}

?>