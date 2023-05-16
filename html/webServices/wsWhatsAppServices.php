<?php 
	include_once("conexionBD.php");
	include_once("nusoap/nusoap.php");
	include_once("latisErrorHandler.php");
	ini_set('default_socket_timeout', 160000);
	ini_set('post_max_size', '1024M');
	ini_set('upload_max_filesize', '1024M');
	
	
	function enviarMensaje($numeroDestino,$MensajeDestino,$prefijoCelular="521",$numeroOrigen="16474927546")
	{
		try
		{
			$parametros="To=".urlencode("whatsapp:+".$prefijoCelular.$numeroDestino)."&From=".urlencode("whatsapp:+".$numeroOrigen)."&Body=".urlencode($MensajeDestino);
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, 'https://api.twilio.com/2010-04-01/Accounts/ACd04f8d12abcea1340fc64a135c30cd2a/Messages.json');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS,$parametros);	
			curl_setopt($ch, CURLOPT_USERPWD, 'ACd04f8d12abcea1340fc64a135c30cd2a:eb9353b26fc1e7bb3b5d0cf9cd43f5be');
			
			$result = curl_exec($ch);
			
			$r=json_decode($result);
	
			if (curl_errno($ch)) 
			{
				return '{"resultado":"0","mensajeError":"'.curl_error($ch).'","idMensaje":"","responseString":""}';
				echo 'Error:' . curl_error($ch);
			}
			curl_close($ch);
		
			return '{"resultado":"1","mensajeError":"","idMensaje":"'.$r->sid. '","responseString":"'.bE($result).'"}';
				
		
		}
		catch(Exception $e)
		{
			
	
			return '{"resultado":"0","mensajeError":"'.$e->getMessage().'","idMensaje":"","responseString":""}';
		}
	}

	function enviarMensajeSMS($numeroDestino,$MensajeDestino,$prefijoCelular="521",$numeroOrigen="16474927546")
	{
		try
		{
			$parametros="To=".urlencode("+".$prefijoCelular.$numeroDestino)."&From=".urlencode("+".$numeroOrigen)."&Body=".urlencode($MensajeDestino);
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, 'https://api.twilio.com/2010-04-01/Accounts/ACd04f8d12abcea1340fc64a135c30cd2a/Messages.json');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS,$parametros);	
			curl_setopt($ch, CURLOPT_USERPWD, 'ACd04f8d12abcea1340fc64a135c30cd2a:eb9353b26fc1e7bb3b5d0cf9cd43f5be');
			
			$result = curl_exec($ch);
			
			$r=json_decode($result);
	
			if (curl_errno($ch)) 
			{
				return '{"resultado":"0","mensajeError":"'.curl_error($ch).'","idMensaje":"","responseString":""}';
				echo 'Error:' . curl_error($ch);
			}
			curl_close($ch);
		
			return '{"resultado":"1","mensajeError":"","idMensaje":"'.$r->sid. '","responseString":"'.bE($result).'"}';
				
		
		}
		catch(Exception $e)
		{
			
	
			return '{"resultado":"0","mensajeError":"'.$e->getMessage().'","idMensaje":"","responseString":""}';
		}
	}
	
	
	class soap_serverPGJ extends nusoap_server 
	{
		function parseRequest($headers, $data) 
		{
			
			$this->debug('Entering parseRequest() for data of length ' . strlen($data) . ' headers:');
			$this->appendDebug($this->varDump($headers));
			if (!isset($headers['content-type'])) {
				$this->setError('Request not of type text/xml (no content-type header)');
				return false;
			}
			if (!strstr($headers['content-type'], 'text/xml')) {
				$this->setError('Request not of type text/xml');
				return false;
			}
			if (strpos($headers['content-type'], '=')) {
				$enc = str_replace('"', '', substr(strstr($headers["content-type"], '='), 1));
				$this->debug('Got response encoding: ' . $enc);
				if(preg_match('/^(ISO-8859-1|US-ASCII|UTF-8)$/i',$enc)){
					$this->xml_encoding = strtoupper($enc);
				} else {
					$this->xml_encoding = 'US-ASCII';
				}
			} else {
				// should be US-ASCII for HTTP 1.0 or ISO-8859-1 for HTTP 1.1
				$this->xml_encoding = 'ISO-8859-1';
			}
			$this->debug('Use encoding: ' . $this->xml_encoding . ' when creating nusoap_parser');
			// parse response, get soap parser obj
			$parser = new nusoap_parser(utf8_encode($data),$this->xml_encoding,'',$this->decode_utf8);
			// parser debug
			$this->debug("parser debug: \n".$parser->getDebug());
			// if fault occurred during message parsing
			if($err = $parser->getError()){
				$this->result = 'fault: error in msg parsing: '.$err;
				$this->fault('SOAP-ENV:Client',"error in msg parsing:\n".$err);
			// else successfully parsed request into soapval object
			} else {
				// get/set methodname
				$this->methodURI = $parser->root_struct_namespace;
				$this->methodname = $parser->root_struct_name;
				$this->debug('methodname: '.$this->methodname.' methodURI: '.$this->methodURI);
				$this->debug('calling parser->get_soapbody()');
				$this->methodparams = $parser->get_soapbody();
				// get SOAP headers
				$this->requestHeaders = $parser->getHeaders();
				// get SOAP Header
				$this->requestHeader = $parser->get_soapheader();
				// add document for doclit support
				$this->document = $parser->document;
			}
		 }
	}
	
	
	$arrParam=array();
	$server = new soap_serverPGJ;
	$ns=$urlSitio."/webServices";
	$server->configurewsdl('ApplicationServices',$ns);
	$server->wsdl->schematargetnamespace=$ns;
	$server->register('enviarMensaje',array('numeroDestino'=>'xsd:string','MensajeDestino'=>'xsd:string','prefijoCelular'=>'xsd:string','numeroOrigen'=>'xsd:string'),array('return' => 'xsd:string'),$ns,false,'rpc','encoded','Envío de mensajes por whatsapp');
	$server->register('enviarMensajeSMS',array('numeroDestino'=>'xsd:string','MensajeDestino'=>'xsd:string','prefijoCelular'=>'xsd:string','numeroOrigen'=>'xsd:string'),array('return' => 'xsd:string'),$ns,false,'rpc','encoded','Envío de mensajes por whatsapp');
	
	if (isset($HTTP_RAW_POST_DATA)) 
	{
		$input = $HTTP_RAW_POST_DATA;
	}
	else 
	{
		$input = implode("rn", file('php://input'));
	}
	
	
	$server->service($input);
?>