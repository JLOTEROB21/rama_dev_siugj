<?php  include_once("conexionBD.php");
	
	$consulta="SELECT archivoInclude FROM 20000_conectoresServiciosNube"; 
	$res=$con->obtenerFilas($consulta);
	while($filaConector=mysql_fetch_assoc($res))
	{
		include_once($filaConector["archivoInclude"]);	
	}

	class cMicrosoftCalendarOffice365
	{
		var $conexion;
		var $ipServidor;
		var $usuario;
		var $password;
		var $raizServidor;
		var $fInfoComplementaria;
		var $statusActual;
		var $cConexion;
		var $fInfoConexion;
		function cMicrosoftCalendarOffice365($urlServidor,$usuarioServidor,$passwordServidor,$raizServidor,$infoComp=NULL)
		{
			global $con;
			$this->ipServidor=$urlServidor;
			$this->usuario=$usuarioServidor;
			$this->password= $passwordServidor;
			$this->raizServidor=$raizServidor;
			$this->fInfoComplementaria=$infoComp;
			$this->statusActual=0;
			
			$consulta="SELECT * FROM 20001_conexionesServiciosNube WHERE idConexion=".$infoComp["idConexion"];
			$this->fInfoConexion=$con->obtenerPrimeraFilaAsoc($consulta);
			$tipoConector=$this->fInfoConexion["tipoConector"];
			$this->fInfoConexion=$con->obtenerPrimeraFilaAsoc($consulta);
			$consulta="SELECT nombreClase FROM 20000_conectoresServiciosNube WHERE idTipoConector=".$tipoConector;
			$nombreClase=$con->obtenerValor($consulta);

			eval('$this->cConexion= new '.$nombreClase.'('.$infoComp["idConexion"].');'); 
		}
		
		function getTimezone()
		{
		   global $api;
		   $respuesta = $this->cConexion->ejecutarAPI("GET","/me/mailboxSettings/timeZone");
		   $objResp=json_decode($respuesta);

		   return $objResp->value;
		}

		function obtenerEventosRango($fechaInicio,$fechaFin)
		{
		   global $api;
		   global $con;
		   
  		   $events = array();
		  
		  	$calendarResponse = $this->cConexion->ejecutarAPI("GET","me/calendar/calendarview?startdatetime=".date("Y-m-d\TH:i:s",strtotime($fechaInicio))."&enddatetime=".date("Y-m-d\TH:i:s",strtotime($fechaFin)));
				   
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
											  "contineLinkVideoConferencia"=>isset($event->onlineMeeting)?1:0
									  	)
					  	);
		 	}
		  
		  
		   	return $events;
		}
		
		function crearEventoTeams($fechaInicial,$fechaFinal,$arrDestinatarios,$asunto,$proveedor,$cuerpoMail)
		{
			$fInicial=date("Y-m-d\TH:i:s",strtotime($fechaInicial));
			$fFinal=date("Y-m-d\TH:i:s",strtotime($fechaFinal));
			
			$timezone=$this->getTimezone();
			$query=null;
			$query="/me/calendar/events";
			$params = array(
							  "start" => array(
							  					
												"dateTime" =>$fInicial,
												"timeZone" => $timezone
												
							  				),
							  
							  "end" => array(
							  					
												"dateTime" =>$fechaFinal,
												"timeZone" => $timezone
												
							  				),
							  "subject" => $asunto,
							  "attendees"=>$arrDestinatarios,
							  /*"organizer"=>array	(	
							  							"emailAddress"=>$this->fInfoConexion["nombreConexion"]
							  						),*/
							  "body" => array(
												"contentType" => "HTML",
												"content" => $cuerpoMail
											  ),
							  "hideAttendees"=>true,
							  "isOrganizer"=>true,
							  "isOnlineMeeting"=>true,
							  "onlineMeetingProvider"=>$proveedor
						  );
						  

						  
			$response=$this->cConexion->ejecutarAPI("POST",$query,$params,"",true);
			$response=json_decode($response);
			$eventoResponse=$response;
			
			if(isset($response->onlineMeeting) &&($response->onlineMeeting->joinUrl))
			{
				$query='/me/onlineMeetings?$filter=JoinWebUrl%20eq%20\''.$response->onlineMeeting->joinUrl.'\'';
				$response=$this->cConexion->ejecutarAPI("GET",$query,$params,"",true);
				$response=json_decode($response);
				
				if(count($response->value)>0)
				{
					$evento=$response->value[0];
					$query="/me/onlineMeetings/".$evento->id;
					
					$params = array(
										"lobbyBypassSettings"=>array(
																		"scope"=>"everyone"
																	)
									);
					
					$response=$this->cConexion->ejecutarAPI("PATCH",$query,$params,"",true);
					
					$response=json_decode($response);

			
				}
				
				
			}
			
			
			return $eventoResponse;
		}
		
		
		function crearEventoTeamsV2($fechaInicial,$fechaFinal,$arrDestinatarios,$asunto,$proveedor,$cuerpoMail)
		{
			$fInicial=date("Y-m-d\TH:i:s",strtotime($fechaInicial));
			$fFinal=date("Y-m-d\TH:i:s",strtotime($fechaFinal));
			
			$timezone=$this->getTimezone();
			$query=null;
			$query="/me/onlineMeetings";
			$params["allowedPresenters"]="roleIsPresenter";
			$params["allowMeetingChat"]="disabled";
			$params["allowAttendeeToEnableMic"]="true";
			$params["recordAutomatically"]="true";
			$params["allowedPresenters"]="roleIsPresenter";
			$params["startDateTime"]=$fInicial."-07:00";
			$params["endDateTime"]=$fFinal."-07:00";
			$params["subject"]="Evento de prueba";
			$params["lobbyBypassSettings"]="everyone";
			
			/*$params = array(
							  "start" => array(
							  					
												"dateTime" =>$fInicial,
												"timeZone" => $timezone
												
							  				),
							  
							  "end" => array(
							  					
												"dateTime" =>$fechaFinal,
												"timeZone" => $timezone
												
							  				),
							  "subject" => $asunto,
							  "attendees"=>$arrDestinatarios,
							  "body" => array(
												"contentType" => "HTML",
												"content" => $cuerpoMail
											  ),
							  "hideAttendees"=>true,
							  "isOrganizer"=>true,
							  "isOnlineMeeting"=>true,
							  "onlineMeetingProvider"=>$proveedor
						  );*/
						  
			$response=$this->cConexion->ejecutarAPI("POST",$query,$params,"",true);
			$response=json_decode($response);
			return $response;
		}
		
		function cancelEventoTeams($idEvento,$motivoCancelacion)
		{
			global $api;
			
			$params = array(
							 
							  "Comment"=>$motivoCancelacion
						  );
						  
			
			$calendarResponse = $this->cConexion->ejecutarAPI("POST","/me/events/".$idEvento."/cancel",$params,"",true);
			if($this->cConexion->cabecerasUltimaEjecucion["http_code"]==202)
			 	return true;
			return false;

		}
		
		function modificarEventoTeams($idEvento,$fechaInicial,$fechaFinal,$arrDestinatarios,$asunto,$proveedor,$cuerpoMail)
		{
			$fInicial=date("Y-m-d\TH:i:s",strtotime($fechaInicial));
			$fFinal=date("Y-m-d\TH:i:s",strtotime($fechaFinal));
			
			$timezone=$this->getTimezone();
			$query=null;
			$query="/me/calendar/events/".$idEvento;
			$params = array(
							  "start" => array(
							  					
												"dateTime" =>$fInicial,
												"timeZone" => $timezone
												
							  				),
							  
							  "end" => array(
							  					
												"dateTime" =>$fechaFinal,
												"timeZone" => $timezone
												
							  				),
							  "subject" => $asunto,
							  "attendees"=>$arrDestinatarios,
							  "body" => array(
												"contentType" => "HTML",
												"content" => $cuerpoMail
											  ),
							  "hideAttendees"=>true,
							  "isOrganizer"=>true,
							  "isOnlineMeeting"=>true,
							  "onlineMeetingProvider"=>$proveedor
						  );
			
						  
			$response=$this->cConexion->ejecutarAPI("PATCH",$query,$params,"",true);
			$response=json_decode($response);

			return $response;
		}
		
		function obtenerInfoEventoTeams($idEvento)
		{
			$query="/me/calendar/events/".$idEvento;
			
						  
			$response=$this->cConexion->ejecutarAPI("GET",$query);
			$response=json_decode($response);
			return $response;
		}
		
		function obtenerUrlGrabacionEvento($idEvento)
		{
			$query="me/drive/root/children";
			$response=$this->cConexion->ejecutarAPI("GET",$query);
			$response=json_decode($response);
			
			$idRecordingFolder="";
			$itemSearch="Recordings";
			foreach ($response->value as $item) 
			{
				
				if(($item->name)&&(mb_strtoupper($item->name)==mb_strtoupper($itemSearch)))
				{
					$idRecordingFolder=$item->id;
					break;
					
				}
				
			}
			if($idRecordingFolder!="")
			{
				$query="me/drive/root/children";
				
				$query="me/drive/items/".$idRecordingFolder."/children";
				
				$response=$this->cConexion->ejecutarAPI("GET",$query);
				$response=json_decode($response);
				
				$itemGrabacion=NULL;
				foreach ($response->value as $item) 
				{
					$arrNombreDocumento=explode(" ",$item->name);
					if($arrNombreDocumento[0]==$idEvento)
					{
						$itemGrabacion=$item;
						break;
						
					}
				}
				
				if($itemGrabacion)
				{
					$params = array(
										 "type" => "view",
										 "scope" => "anonymous"
								   );
				   
				
					$response=$this->cConexion->ejecutarAPI("POST","me/drive/items/".$itemGrabacion->id."/createLink",$params,"",true);
					$response=json_decode($response);
					if(isset($response->link))
					{
						return $response->link->webUrl;
					}
				}
			}
			
			$item=NULL;
			$params=NULL;
			$query="/me/drive/sharedWithMe";

			$response=$this->cConexion->ejecutarAPI("GET",$query,$params,"",true);

			$response=json_decode($response);
			
			foreach($response->value as $r)
			{

				if(strpos($r->name,$idEvento)!==false)
				{
					
					$item=$r;
					break;
				}
			}
			
			if($item)
			{
				$query="/sites/".$item->remoteItem->sharepointIds->siteId."/drive/items/".$item->id."/createLink";
				
				$params=array	(
									"type"=>"view",
									"scope"=>"anonymous"
								);
				
				$response=$this->cConexion->ejecutarAPI("POST",$query,$params,"",true);
	
				$response=json_decode($response);	
				if(isset($response->link))
				{
					return $response->link->webUrl;
				}
			}
			
			
			return;
			
			
			
		}
		
		
		function getChats($fechaInicial,$fechaFinal="")
		{
			
			$comp="";
			if($fechaFinal!="")
			{
				$comp='and lastUpdatedDateTime le '.$fechaFinal."T23:59:59.0Z";
			}
			$query='/me/chats';
						  //?$filter=(lastUpdatedDateTime ge '.$fechaInicial.'T00:00:00.0Z'.$comp.')
			$response=$this->cConexion->ejecutarAPI("GET",$query,null,"",true);
			$response=json_decode($response);
			return $response;
		}
		
		
		function getMessagesChat($chatId)
		{
			
			
			$query='/me/chats/'.$chatId."/messages";
			$response=$this->cConexion->ejecutarAPI("GET",$query,null,"",true);
			$response=json_decode($response);
			return $response;
		}
		
		function obtenerURLGrabacionEventoAudiencia($idEvento)
		{
			$item=NULL;
			$cveAudiencia="[".$idEvento."_".obtenerPrefijoSitio()."]";
			$params=NULL;
			$query="/me/drive/root/search(q='".$cveAudiencia."')?select=*";

			$response=$this->cConexion->ejecutarAPI("GET",$query,$params,"",true);

			$response=json_decode($response);
			
			varDUmp($response);
			return;
				
			foreach($response->value as $r)
			{
				if(strpos($r->name,"[".$cveAudiencia."]")!==false)
				{
					$item=$r;
					break;
				}
			}
			
			if($item)
			{
				
				$query="/me/drive/items/".$item->id."/createLink";
				$params=array(
								"type"=>"view",
								"scope"=>"anonymous"
							);
				$response=$this->cConexion->ejecutarAPI("POST",$query,$params,"",true);
				$response=json_decode($response);	
				varDUmp($response);
			}
			else
			{
			}
			varDump($r);
			
		}
	}

?>
