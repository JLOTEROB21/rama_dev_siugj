<?php 
	class cGoogleServices
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
		var $oToken;
		var $idConfiguracionConexion;
				
		function cGoogleServices($idConfiguracionConexion) 
		{
			global $urlSitio;
			global $googleClientSecret;
			global $googleClientID;
			$this->api = "https://www.googleapis.com/";
			$this->authApi = "https://accounts.google.com/o/oauth2/auth";
			$this->method = "me/calendars";
			$this->baseUrl = $urlSitio."modeloConectores/responseAutenticationGoogle.php";
			$this->baseUrl=str_replace("http:","https:",$this->baseUrl);
			$this->redirectUri = ($this->baseUrl);
			$this->scope = "https://www.googleapis.com/auth/calendar";
			$this->clientId = $googleClientID;//"938387765902-tm06j8q9l9bsuff0c5hgal4376gb3rnv.apps.googleusercontent.com";  AIzaSyB8XX3OxHCLI-UwA5KcCEh5Pk6c4vZjIXY
			$this->clientSecret=$googleClientSecret;//"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";			
			$this->urlLogin=$this->authApi;
			$this->idConfiguracionConexion=$idConfiguracionConexion;
		}
		
		
		function callAPI($method, $url, $data, $token)
		{
			$curl = curl_init();
			if($method == "POST")
			{
				curl_setopt($curl, CURLOPT_POST, 1);
				if($data)
					curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
			}
			
			curl_setopt($curl, CURLOPT_URL, $url);
			curl_setopt($curl, CURLOPT_VERBOSE, true);
			$curl_error = curl_error($curl);
		
			if(!$token)
				$headers = array(
									 'Content-Type: application/x-www-form-urlencoded'
								  );
			else
				$headers = array(
									 'Authorization: Bearer ' . $token
								  );
			curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		   
			$result = curl_exec($curl);
			
			if(!$result)
			{
				die("Connection Failure " . $reload);
			}
			curl_close($curl);
			return $result;
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
				   $calendarResponse = $this->callAPI("GET", $this->api . "calendar/v3/users/me/calendarList", null, $this->oToken->access_token);

				   $calendarResponse = json_decode($calendarResponse);
				   foreach ($calendarResponse->items as $calendar) 
				   {
					   $peticionAPI=$this->api . "calendar/v3/calendars/".$calendar->id."/events?timeMin=".date("Y-m-d\TH:i:s",strtotime($fechaInicio))."-05:00&timeMax=".date("Y-m-d\TH:i:s",strtotime($fechaFin))."-05:00";
						$eventListResponse = $this->callAPI("GET", $peticionAPI, null, $this->oToken->access_token);

						$eventListResponse = json_decode($eventListResponse);
						if(isset($eventListResponse->items))   
						{
						 	foreach ($eventListResponse->items as $event) 
							{

								if(!isset($event->start->dateTime))
								{
								   $start = $event->start->date;
								   $end = $event->end->date;
								}
								else
								{
								   $start = $event->start->dateTime;
								   $end = $event->end->dateTime;
								   
								   $dtStart = new DateTime(date("Y-m-d H:i:s",strtotime($start)), new DateTimeZone($event->start->timeZone));
								   $dtEnd = new DateTime(date("Y-m-d H:i:s",strtotime($end)), new DateTimeZone($event->start->timeZone));


									$dtStart->setTimezone(new DateTimeZone(date_default_timezone_get()));
									$dtEnd->setTimezone(new DateTimeZone(date_default_timezone_get()));
									
									$start=$dtStart->format("Y-m-d H:i:s");
									$end=$dtEnd->format("Y-m-d H:i:s");
								   
								   
								   
								}
								array_push($events, array(
														   "actividad" => $event->summary,
														   "inicio" => date("Y-m-d H:i:s",strtotime($start)),
														   "fin" =>  date("Y-m-d H:i:s",strtotime($end)),
														   "linkReunion"=>isset($event->conferenceData)?$event->conferenceData->entryPoints[0]->uri:"",
														   "contineLinkVideoConferencia"=>isset($event->conferenceData)?1:0,
														   "id"=>$event->id,
														   "idConexion"=>$this->idConfiguracionConexion
															)
										);
						 	}   
						}
				   }
					   
				   
			   }
		   }
		   return $events;
		}
		
		function salvarToken($token)
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
			$consulta[$x]="INSERT INTO 20001_conexionesServiciosNube(idUsuario,nombreConexion,descripcion,tipoConector,objConexionAcceso) VALUES(".$_SESSION["idUsr"].",'".cv($objSession->nombreConexion).
						"','".cv($objSession->descripcion)."',".$objSession->tipoConexion.",'".cv($objConexion)."')";
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
			$objConexion='{"access_token":"'.cv($token->access_token).'","refresh_token":"'.cv($this->oToken->refresh_token).'","expires_in":"'.date("Y-m-d H:i:s",$fechaVigencia).'"}';
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
										 "refresh_token" => $oToken->refresh_token,
										 "client_secret" => $this->clientSecret
									);
		  $tokenResponse = $this->callAPI("POST", $this->api . "oauth2/v4/token", $tokenRequest, null);
		  $tokenResponse = json_decode($tokenResponse);
		  if(!isset($tokenResponse->error)) 
		  {
			  return $this->actualizarToken($tokenResponse,$idRegistro);
		  }
		  return false;
		}
	}
	
?>