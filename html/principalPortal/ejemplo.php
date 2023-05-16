<?php include("conexionBD.php");
		$urlToken=str_replace("https://www.","",$urlSitio);
		$urlToken=str_replace("https://","",$urlToken);
		$urlToken=str_replace("http://www.","",$urlToken);
		$urlToken=str_replace("http://","",$urlToken);
		$urlToken=str_replace("/","",$urlToken);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<script type="text/javascript" src="base64.js"></script>
</head>

<body>
<script>
	///FUnciones varias	////		
	var HtmlEntities = function() {};

	HtmlEntities.map = {
							"'": "&apos;",
							"<": "&lt;",
							">": "&gt;",
							" ": "&nbsp;",
							"¡": "&iexcl;",
							"¢": "&cent;",
							"£": "&pound;",
							"¤": "&curren;",
							"¥": "&yen;",
							"¦": "&brvbar;",
							"§": "&sect;",
							"¨": "&uml;",
							"©": "&copy;",
							"ª": "&ordf;",
							"«": "&laquo;",
							"¬": "&not;",
							"®": "&reg;",
							"¯": "&macr;",
							"°": "&deg;",
							"±": "&plusmn;",
							"²": "&sup2;",
							"³": "&sup3;",
							"´": "&acute;",
							"µ": "&micro;",
							"¶": "&para;",
							"·": "&middot;",
							"¸": "&cedil;",
							"¹": "&sup1;",
							"º": "&ordm;",
							"»": "&raquo;",
							"¼": "&frac14;",
							"½": "&frac12;",
							"¾": "&frac34;",
							"¿": "&iquest;",
							"À": "&Agrave;",
							"Á": "&Aacute;",
							"Â": "&Acirc;",
							"Ã": "&Atilde;",
							"Ä": "&Auml;",
							"Å": "&Aring;",
							"Æ": "&AElig;",
							"Ç": "&Ccedil;",
							"È": "&Egrave;",
							"É": "&Eacute;",
							"Ê": "&Ecirc;",
							"Ë": "&Euml;",
							"Ì": "&Igrave;",
							"Í": "&Iacute;",
							"Î": "&Icirc;",
							"Ï": "&Iuml;",
							"Ð": "&ETH;",
							"Ñ": "&Ntilde;",
							"Ò": "&Ograve;",
							"Ó": "&Oacute;",
							"Ô": "&Ocirc;",
							"Õ": "&Otilde;",
							"Ö": "&Ouml;",
							"×": "&times;",
							"Ø": "&Oslash;",
							"Ù": "&Ugrave;",
							"Ú": "&Uacute;",
							"Û": "&Ucirc;",
							"Ü": "&Uuml;",
							"Ý": "&Yacute;",
							"Þ": "&THORN;",
							"ß": "&szlig;",
							"à": "&agrave;",
							"á": "&aacute;",
							"â": "&acirc;",
							"ã": "&atilde;",
							"ä": "&auml;",
							"å": "&aring;",
							"æ": "&aelig;",
							"ç": "&ccedil;",
							"è": "&egrave;",
							"é": "&eacute;",
							"ê": "&ecirc;",
							"ë": "&euml;",
							"ì": "&igrave;",
							"í": "&iacute;",
							"î": "&icirc;",
							"ï": "&iuml;",
							"ð": "&eth;",
							"ñ": "&ntilde;",
							"ò": "&ograve;",
							"ó": "&oacute;",
							"ô": "&ocirc;",
							"õ": "&otilde;",
							"ö": "&ouml;",
							"÷": "&divide;",
							"ø": "&oslash;",
							"ù": "&ugrave;",
							"ú": "&uacute;",
							"û": "&ucirc;",
							"ü": "&uuml;",
							"ý": "&yacute;",
							"þ": "&thorn;",
							"ÿ": "&yuml;",
							"Œ": "&OElig;",
							"œ": "&oelig;",
							"Š": "&Scaron;",
							"š": "&scaron;",
							"Ÿ": "&Yuml;",
							"ƒ": "&fnof;",
							"ˆ": "&circ;",
							"˜": "&tilde;",
							"Α": "&Alpha;",
							"Β": "&Beta;",
							"Γ": "&Gamma;",
							"Δ": "&Delta;",
							"Ε": "&Epsilon;",
							"Ζ": "&Zeta;",
							"Η": "&Eta;",
							"Θ": "&Theta;",
							"Ι": "&Iota;",
							"Κ": "&Kappa;",
							"Λ": "&Lambda;",
							"Μ": "&Mu;",
							"Ν": "&Nu;",
							"Ξ": "&Xi;",
							"Ο": "&Omicron;",
							"Π": "&Pi;",
							"Ρ": "&Rho;",
							"Σ": "&Sigma;",
							"Τ": "&Tau;",
							"Υ": "&Upsilon;",
							"Φ": "&Phi;",
							"Χ": "&Chi;",
							"Ψ": "&Psi;",
							"Ω": "&Omega;",
							"α": "&alpha;",
							"β": "&beta;",
							"γ": "&gamma;",
							"δ": "&delta;",
							"ε": "&epsilon;",
							"ζ": "&zeta;",
							"η": "&eta;",
							"θ": "&theta;",
							"ι": "&iota;",
							"κ": "&kappa;",
							"λ": "&lambda;",
							"μ": "&mu;",
							"ν": "&nu;",
							"ξ": "&xi;",
							"ο": "&omicron;",
							"π": "&pi;",
							"ρ": "&rho;",
							"ς": "&sigmaf;",
							"σ": "&sigma;",
							"τ": "&tau;",
							"υ": "&upsilon;",
							"φ": "&phi;",
							"χ": "&chi;",
							"ψ": "&psi;",
							"ω": "&omega;",
							"ϑ": "&thetasym;",
							"ϒ": "&Upsih;",
							"ϖ": "&piv;",
							"–": "&ndash;",
							"—": "&mdash;",
							"‘": "&lsquo;",
							"’": "&rsquo;",
							"‚": "&sbquo;",
							"“": "&ldquo;",
							"”": "&rdquo;",
							"„": "&bdquo;",
							"†": "&dagger;",
							"‡": "&Dagger;",
							"•": "&bull;",
							"…": "&hellip;",
							"‰": "&permil;",
							"′": "&prime;",
							"″": "&Prime;",
							"‹": "&lsaquo;",
							"›": "&rsaquo;",
							"‾": "&oline;",
							"⁄": "&frasl;",
							"€": "&euro;",
							"ℑ": "&image;",
							"℘": "&weierp;",
							"ℜ": "&real;",
							"™": "&trade;",
							"ℵ": "&alefsym;",
							"←": "&larr;",
							"↑": "&uarr;",
							"→": "&rarr;",
							"↓": "&darr;",
							"↔": "&harr;",
							"↵": "&crarr;",
							"⇐": "&lArr;",
							"⇑": "&UArr;",
							"⇒": "&rArr;",
							"⇓": "&dArr;",
							"⇔": "&hArr;",
							"∀": "&forall;",
							"∂": "&part;",
							"∃": "&exist;",
							"∅": "&empty;",
							"∇": "&nabla;",
							"∈": "&isin;",
							"∉": "&notin;",
							"∋": "&ni;",
							"∏": "&prod;",
							"∑": "&sum;",
							"−": "&minus;",
							"∗": "&lowast;",
							"√": "&radic;",
							"∝": "&prop;",
							"∞": "&infin;",
							"∠": "&ang;",
							"∧": "&and;",
							"∨": "&or;",
							"∩": "&cap;",
							"∪": "&cup;",
							"∫": "&int;",
							"∴": "&there4;",
							"∼": "&sim;",
							"≅": "&cong;",
							"≈": "&asymp;",
							"≠": "&ne;",
							"≡": "&equiv;",
							"≤": "&le;",
							"≥": "&ge;",
							"⊂": "&sub;",
							"⊃": "&sup;",
							"⊄": "&nsub;",
							"⊆": "&sube;",
							"⊇": "&supe;",
							"⊕": "&oplus;",
							"⊗": "&otimes;",
							"⊥": "&perp;",
							"⋅": "&sdot;",
							"⌈": "&lceil;",
							"⌉": "&rceil;",
							"⌊": "&lfloor;",
							"⌋": "&rfloor;",
							"⟨": "&lang;",
							"⟩": "&rang;",
							"◊": "&loz;",
							"♠": "&spades;",
							"♣": "&clubs;",
							"♥": "&hearts;",
							"♦": "&diams;"
						};

	HtmlEntities.decode = function(string) 
						{
							var entityMap = HtmlEntities.map;
							for (var key in entityMap) {
								var entity = entityMap[key];
								var regex = new RegExp(entity, 'g');
								string = string.replace(regex, key);
							}
							string = string.replace(/&quot;/g, '"');
							string = string.replace(/&amp;/g, '&');
							return string;
						}
	
	HtmlEntities.encode = function(string) 
						{
							var entityMap = HtmlEntities.map;
							string = string.replace(/&/g, '&amp;');
							string = string.replace(/"/g, '&quot;');
							for (var key in entityMap) {
								var entity = entityMap[key];
								var regex = new RegExp(key, 'g');
								string = string.replace(regex, entity);
							}
							return string;
						}				
							
	var PETICION_NO_INICIALIZADO = 0; 
	var PETICION_CARGANDO = 1; 
	var PETICION_CARGADO = 2;
	var PETICION_INTERACTIVO = 3; 
	var PETICION_COMPLETO = 4;
	var RESPUESTA_OK=200;
	var peticion_http;
	
	var msgEspereAjaxv2;

	function crearMotorAjax()
	{
		var motorAjax;
		if(window.XMLHttpRequest)
		{
			motorAjax=new XMLHttpRequest();
		}
		else
		{
			if(window.ActiveXObject)
			{
				motorAjax=new ActiveXObject("Microsoft.XMLHTTP");
			}
		}
		return motorAjax;
	}

	function obtenerDatosWebV2(urlADescargar,funcionAEjecutar, metodoInvocacion,parametros,mostrarMensajeEspere)
	{
		var peticion_http=crearMotorAjax();
		var datos=null;
		if(peticion_http)
		{
			peticion_http.onreadystatechange=function()
											{
												console.log(peticion_http);
												if(peticion_http.readyState==PETICION_COMPLETO)
												{
													if(peticion_http.status==RESPUESTA_OK)
													{
														funcionAEjecutar(peticion_http);
													}
													else
													{
														alert('No se ha podido establecer conexi&oacute;n con la p&aacute;gina: '+urlADescargar);
														return;
													}
												}
			
											}
			if(metodoInvocacion.toUpperCase()=="GET")
				urlADescargar=urlADescargar+"?"+parametros;
			else
				datos=parametros;
			
			
			peticion_http.open(metodoInvocacion,urlADescargar,true);
			peticion_http.setRequestHeader("Content-Type","text/xml; charset=utf-8");
			peticion_http.send(datos);
			
		}
		
	}


////////////Funciones de consulta
	  //nombre canonico del sitioa donde autentifica

	function ejecutarConsulta()
	{
		var urlConexion=document.getElementById('txtSitio').value;
		var usuario=document.getElementById('txtUsuario').value;
		var password=document.getElementById('txtPassword').value;
		var macAddress=document.getElementById('txtMacAddress').value.toUpperCase();
		var cadenaValidacion=usuario+'_@@_'+password+'_@@_'+macAddress;
		var resultado=encryptString(cadenaValidacion,urlConexion);//el resultado vendria a ser la urlAutentication 
		document.getElementById('txtResultado').value=resultado;
		//resultado=decryptString(resultado,'test-siugj.linktic.co');
		
		var consulta = "<soap:Envelope xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance'\r\n"+
							"xmlns:xsd='http://www.w3.org/2001/XMLSchema'\r\n"+
							"xmlns:soap='http://schemas.xmlsoap.org/soap/envelope/'>\r\n"+
							"<soap:Body>\r\n"+
								"<autenticateUser xmlns='http://tempuri.org/'>\r\n"+
									"<urlAutentication>"+resultado+"</urlAutentication>\r\n"+
									"<token>"+macAddress+"</token>\r\n"+
								"</autenticateUser>\r\n"+
							"</soap:Body>\r\n"+
						"</soap:Envelope> ";
		
		
		function resp(http)
		{
			var resultado=http.responseText;
			var arrResultado=resultado.split('<return xsi:type=\"xsd:string\">');
			
			resultado=arrResultado[1];
			arrResultado=resultado.split('</return>');
			resultado=HtmlEntities.decode(arrResultado[0]);
			document.getElementById('txtResultadoWS').value=resultado;
			var objResultado=eval('['+resultado+']')[0];
			if(objResultado.result=='1')
			{
				document.getElementById('txtToken').value=objResultado.tokenAccess;
				document.getElementById('txtMacAddress2').value=macAddress;
			}
		}
		obtenerDatosWebV2('https://'+urlConexion+'/webServices/wsMovilServices.php',resp, 'POST',consulta);
	}
	
	
	function ejecutarConsulta2()
	{
		var urlConexion=document.getElementById('txtSitio').value;
		var txtToken=document.getElementById('txtToken').value;
		var macAddress2=document.getElementById('txtMacAddress2').value.toUpperCase();
		
		var cmbStatusTarea=document.getElementById('cmbStatusTarea');
		
		var taskStatus=cmbStatusTarea.options[cmbStatusTarea.selectedIndex].value;
		var consulta = "<soap:Envelope xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance'\r\n"+
							"xmlns:xsd='http://www.w3.org/2001/XMLSchema'\r\n"+
							"xmlns:soap='http://schemas.xmlsoap.org/soap/envelope/'>\r\n"+
							"<soap:Body>\r\n"+
								"<usersTask xmlns='http://tempuri.org/'>\r\n"+
									"<stringTokenAccess>"+txtToken+"</stringTokenAccess>\r\n"+
									"<token>"+macAddress2+"</token>\r\n"+
									"<taskStatus>"+taskStatus+"</taskStatus>\r\n"+
								"</usersTask>\r\n"+
							"</soap:Body>\r\n"+
						"</soap:Envelope> ";
		
		
		function resp(http)
		{
			var resultado=http.responseText;
			var arrResultado=resultado.split('<return xsi:type=\"xsd:string\">');
			
			resultado=arrResultado[1];
			arrResultado=resultado.split('</return>');
			resultado=HtmlEntities.decode(arrResultado[0]);
			document.getElementById('txtResultadoWS2').value=resultado;
			
		}
		obtenerDatosWebV2('https://'+urlConexion+'/webServices/wsMovilServices.php',resp, 'POST',consulta);
	}
</script>
<span style="font-size:25px; color:#006"><b>Autenticacion</b></span><br /><br />
<table>
	<tr height="21">
    	<td width="150"><b>Url Sitio:</b></td><td><input type="text" id="txtSitio"   style="width:800px" value="<?php echo $urlToken?>"/></td>
    </tr>
	<tr height="21">
    	<td width="150"><b>Usuario:</b></td><td><input type="text" id="txtUsuario" value="s04" /></td>
    </tr>
    <tr height="21">
    	<td width="150"><b>Password:</b></td><td><input type="text" id="txtPassword" value="123456" /></td>
    </tr>
    <tr height="21">
    	<td width="150"><b>Mac Address:</b></td><td><input type="text" id="txtMacAddress" value="001ec29e286b" /></td>
    </tr>
    <tr height="21">
    	<td colspan="2" align="center"><button onclick="ejecutarConsulta()">Comenzar</button></td>
    </tr>
    <tr height="21">
    	<td width="150"><b>Resultado Codificaci&oacute;n:</b></td><td><textarea id="txtResultado" style="width:800px; height: 60px;"></textarea></td>
    </tr>
    <tr height="21">
    	<td width="150"><b>Respuesta WS:</b></td><td><textarea id="txtResultadoWS" style="width:800px; height: 60px;"></textarea></td>
    </tr>
</table>

<br /><br />



<span style="font-size:25px; color:#006"><b>Consulta de tareas</b></span><br /><br />

<table>
	
	<tr height="21">
    	<td width="150"><b>Token access:</b></td><td><input type="text" id="txtToken"   style="width:800px"/></td>
    </tr>
    <tr height="21">
    	<td width="150"><b>Mac Address:</b></td><td><input type="text" id="txtMacAddress2"  /></td>
    </tr>
    <tr height="21">
    	<td width="150"><b>Situaci&oacute;n tarea:</b></td><td><select id="cmbStatusTarea"><option value="0">Cualquiera</option><option selected="selected" value="1">Tareas activas</option><option value="2">Tareas atendidas</option></select></td>
    </tr>
    <tr height="21">
    	<td colspan="2" align="center"><button onclick="ejecutarConsulta2()">Comenzar</button></td>
    </tr>
    
    	<td width="150"><b>Respuesta WS:</b></td><td><textarea id="txtResultadoWS2" style="width:800px; height: 60px;"></textarea></td>
    </tr>
</table>
</body>
</html>
