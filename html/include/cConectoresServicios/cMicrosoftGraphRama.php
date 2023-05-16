<?php  include_once("conexionBD.php");
	$enableDebug=false;
	class cMicrosoftGraphRama
	{
		var $api;
		var $authApi;
		var $method;
		var $baseUrl;
		var $redirectUri;
		var $scope;
		var $clientId;
		var $clientSecret;
		var $urlLogin;
		var $idUsuario;
		var $oToken;
		var $idConfiguracionConexion;
				
		function cMicrosoftGraphRama($idConfiguracionConexion) 
		{
			global $urlSitio;
			global $microsoftGraphClientSecret;
			global $microsoftGraphClientID;
			
			$this->api = "https://graph.microsoft.com/v1.0/";
			$this->authApi ="https://login.microsoftonline.com/common/oauth2/v2.0/";"https://login.microsoftonline.com/common/oauth2/";
			
			$this->method = "me/calendars";
			$this->baseUrl = $urlSitio."modeloConectores/responseAutenticationMicrosoftGraphRama.php";
			$this->baseUrl=str_replace("http:","https:",$this->baseUrl);
			$this->redirectUri = ($this->baseUrl);
			$this->scope = "offline_access user.read calendars.read calendars.readwrite MailboxSettings.Read files.read.all files.readwrite.all OnlineMeetings.ReadWrite Chat.ReadWrite Sites.ReadWrite.All";
			$this->clientId = $microsoftGraphClientID;//"1d520ff3-b3c5-4627-a41f-abaffce47847";  
			$this->clientSecret=$microsoftGraphClientSecret;	//EYn8Q~oPKzBADwfW_0dWc6rxadXZ~rrety1zybiB		
			$this->urlLogin=$this->authApi . "authorize";
			$this->idConfiguracionConexion=$idConfiguracionConexion;
		}
		
		
		function callAPI($method, $url, $data, $token,$isJSON = false, $timeZone = false, $setHeaders = false)
		{
			$cabeceraResponse="";
			$idRegistro=$this->agregarRegistroBitacora($url);
			try
			{
		
				$curl = curl_init();
				
				if(!$token)
				{
					$headers = array(
										 'Content-Type: application/x-www-form-urlencoded'
									  );
				}
				else
				{
					$headers = array(
										 'Authorization: Bearer ' . $token
									  );
					if($isJSON) 
						array_push($headers, 'Content-Type: application/json');
					if($timeZone) 
						array_push($headers, 'Prefer: outlook.timezone="' . $timeZone . '"');
				}
				
				
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
						curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
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
				//curl_setopt($curl, CURLOPT_HEADER, 1);
				
				$result = curl_exec($curl);
				

				
				$header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
				$headers = substr($result, 0, $header_size);
				$body = substr($result, $header_size);
				$arrValores=$this->headersToArray($headers);	
				$cabeceraResponse="";
				foreach($arrValores as $campo=>$valor)
				{
					if($cabeceraResponse=="")
						$cabeceraResponse=$campo.": ".$valor;
					else
						$cabeceraResponse="\r\n".$campo.": ".$valor;
				}
				
				$this->actualizarRegistroBitacora($idRegistro,$result,$cabeceraResponse);
	
 				
				if(!$result && $method !== 'DELETE')
				{
					die("Connection Failure ". curl_error($curl) . curl_errno($curl));
				}
				curl_close($curl);
				return $result;
			}
			catch(Exception $e)
			{
				$this->actualizarRegistroBitacora($idRegistro,$e->getMessage(),"");
				return NULL;
	
			}
		} 
	
	
		function ejecutarAPI($method, $url, $data=NULL,$api="",$esJSONData=false, $timeZone = false, $setHeaders = false)
		{
			global $con;
			
			
			if($api!="")
			{
				$url=$api.$url;
			}
			else
			{
				if(!((strpos($url,"https://")!==false) && (strpos($url,"https://")==0)))
					$url=$this->api.$url;
			}
			
			
			
			$continuar=$this->actualizarTokenConexion();
			
			
			
			if($continuar)
			{	

				return $this->callAPI($method, $url, $data, $this->oToken->access_token,$esJSONData, $timeZone, $setHeaders);
			}
			else
				return false;
		}
		
		function headersToArray( $str )
		{
			$headers = array();
			$headersTmpArray = explode( "\r\n" , $str );
			for ( $i = 0 ; $i < count( $headersTmpArray ) ; ++$i )
			{
				// we dont care about the two \r\n lines at the end of the headers
				if ( strlen( $headersTmpArray[$i] ) > 0 )
				{
					// the headers start with HTTP status codes, which do not contain a colon so we can filter them out too
					if ( strpos( $headersTmpArray[$i] , ":" ) )
					{
						$headerName = substr( $headersTmpArray[$i] , 0 , strpos( $headersTmpArray[$i] , ":" ) );
						$headerValue = substr( $headersTmpArray[$i] , strpos( $headersTmpArray[$i] , ":" )+1 );
						$headers[$headerName] = $headerValue;
					}
				}
			}
			return $headers;
		}
	
		function actualizarTokenConexion()
		{
			global $con;
			$consulta="SELECT * FROM 20001_conexionesServiciosNube WHERE idConexion=".$this->idConfiguracionConexion;
		   	$fila=$con->obtenerPrimeraFilaAsoc($consulta);
		   
		  	$objToken=$fila["objConexionAcceso"];

			$this->oToken=json_decode($objToken);
			$continuar=true;
			$fechaActual=strtotime(date("Y-m-d H:i:s"));
			if(strtotime($this->oToken->expires_in)<$fechaActual)
			{
				
				 $continuar=$this->updateTokenAcceso($this->oToken,$fila["idConexion"]);
			}
			
			return $continuar;
		}
	
	
		function obtenerEventosRango($fechaInicio,$fechaFin)
		{
		   global $api;
		   global $con;
		   
  		   $events = array();
		   $consulta="SELECT * FROM 20001_conexionesServiciosNube WHERE idConexion=".$this->idConfiguracionConexion;
		   $res=$con->obtenerFilas($consulta);
		   
		   while($fila=mysql_fetch_assoc($res))
		   {
			   $objToken=$fila["objConexionAcceso"];
			   $this->oToken=json_decode($objToken);
			   $continuar=true;
			   $fechaActual=strtotime(date("Y-m-d H:i:s"));
			   if(strtotime($this->oToken->expires_in)<$fechaActual)
			   {
					 $continuar=$this->updateTokenAcceso($this->oToken,$fila["idConexion"]);
			   }
			   
			   if($continuar)
			   {
				   $calendarResponse = $this->callAPI("GET", $this->api . "me/calendar/calendarview?startdatetime=".date("Y-m-d\TH:i:s",strtotime($fechaInicio))."&enddatetime=".date("Y-m-d\TH:i:s",strtotime($fechaFin)), null, $this->oToken->access_token);
				   
				   $calendarResponse = json_decode($calendarResponse);
		
				   foreach ($calendarResponse->value as $event) 
				   {
						
						$dtStart = new DateTime(date("Y-m-d H:i:s",strtotime($event->start->dateTime)), new DateTimeZone($event->start->timeZone));
						$dtEnd = new DateTime(date("Y-m-d H:i:s",strtotime($event->end->dateTime)), new DateTimeZone($event->end->timeZone));


						$dtStart->setTimezone(new DateTimeZone(date_default_timezone_get()));
						$dtEnd->setTimezone(new DateTimeZone(date_default_timezone_get()));
						  
						$start=$dtStart->format("Y-m-d H:i:s");
						$end=$dtEnd->format("Y-m-d H:i:s");
					  	array_push($events, array(
													"actividad" => $event->subject,
													"inicio" =>  date("Y-m-d H:i:s",strtotime($start)),
													"fin" => date("Y-m-d H:i:s",strtotime($end)),
													"id"=>$event->id,
													//"body"=>$event->body,
													"linkReunion"=>isset($event->onlineMeeting)?$event->onlineMeeting->joinUrl:"",
													"contineLinkVideoConferencia"=>isset($event->onlineMeeting)?1:0,
													"idConexion"=>$this->idConfiguracionConexion
												)
								);
				   }
			   }
		   }
		   return $events;
		}
		
		function salvarToken($token,$conexionSistema=0)
		{
			global $con;
			$objSession=$_SESSION["conectorServicioNube"];
			$minutos=($token->expires_in/60);
			$minutos=parteEntera($minutos);
			$fechaVigencia=strtotime("+ ".$minutos." minutes",strtotime(date("Y-m-d H:i:s")));
			$objConexion='{"access_token":"'.cv($token->access_token).'","refresh_token":"'.cv($token->refresh_token).'","expires_in":"'.date("Y-m-d H:i:s",$fechaVigencia).'"}';
			
			$x=0;
			$consulta[$x]="begin";
			$x++;
			$consulta[$x]="INSERT INTO 20001_conexionesServiciosNube(idUsuario,nombreConexion,descripcion,tipoConector,objConexionAcceso,conexionSistema) 
						VALUES(".$_SESSION["idUsr"].",'".cv($objSession->nombreConexion)."','".cv($objSession->descripcion)."',".$objSession->tipoConexion.
						",'".cv($objConexion)."',".$conexionSistema.")";
			$x++;
			$consulta[$x]="set @idRegistro:=(select last_insert_id())";
			$x++;
			$arrServicios=explode(",",$objSession->servicios);
			foreach($arrServicios as $s)
			{
				$consulta[$x]="INSERT INTO 20001_serviciosConexionNube(idConexionServicioNube,tipoServicio) VALUES(@idRegistro,".$s.")";
				$x++;
			}
			
			$consulta[$x]="commit";
			$x++;
			if($con->ejecutarBloque($consulta))
			{
				unset($_SESSION["conectorServicioNube"]);
				return true;
			}
		}
		
		
		function actualizarToken($token,$idRegistro)
		{
			global $con;
			
			$minutos=($token->expires_in/60);
			$minutos=parteEntera($minutos);
			$fechaVigencia=strtotime("+ ".$minutos." minutes",strtotime(date("Y-m-d H:i:s")));
			$objConexion='{"access_token":"'.cv($token->access_token).'","refresh_token":"'.cv($token->refresh_token).'","expires_in":"'.date("Y-m-d H:i:s",$fechaVigencia).'"}';
			$this->oToken=json_decode($objConexion);
			$x=0;
			$consulta[$x]="begin";
			$x++;
			$consulta[$x]="update 20001_conexionesServiciosNube set objConexionAcceso='".cv($objConexion)."' where idConexion=".$idRegistro;
			$x++;
			
			
			$consulta[$x]="commit";
			$x++;
			if($con->ejecutarBloque($consulta))
			{
				return true;
			}
		}
	
		function updateTokenAcceso($oToken,$idRegistro)
		{
			
			$tokenRequest = array	(
										 "grant_type" => "refresh_token",
										 "client_id" => $this->clientId,
										 "scope" => $this->scope,
										 "refresh_token" => $oToken->refresh_token,
										 "redirect_uri" => $this->baseUrl,
										 "client_secret" => $this->clientSecret
									);
		  

		  $tokenResponse = $this->callAPI("POST", $this->authApi . "token", $tokenRequest, null);
		  $tokenResponse = json_decode($tokenResponse);
		  if(!isset($tokenResponse->error)) 
		  {
			  return $this->actualizarToken($tokenResponse,$idRegistro);
		  }
		  return false;
		}
		
		function agregarRegistroBitacora($url)
		{
			global $con;
			global $enableDebug;
			if(!$enableDebug)
				return true;
			
			$consulta="INSERT INTO 20001_bitacoraConexionServiciosNube(fechaRegistro,metodo,idConexion) 
						VALUES('".date("Y-m-d H:i:s")."','".cv($url)."',".$this->idConfiguracionConexion.")";
			if($con->ejecutarConsulta($consulta))
			{
				return $con->obtenerUltimoID();	
			}
			
		}
		
		function actualizarRegistroBitacora($idRegistro,$respuesta,$cabecerasResponse)
		{
			global $con;
			global $enableDebug;
			if(!$enableDebug)
				return true;
			
			$consulta="update 20001_bitacoraConexionServiciosNube set respuesta='".cv($respuesta)."',cabecerasResponse='".cv($cabecerasResponse)."' where idRegistro=".$idRegistro;
			return $con->ejecutarConsulta($consulta);
			
		}
	}
	
?>