<?php session_start();
	include("conexionBD.php");
	include_once("cConectoresServicios/cMicrosoftGraphRama.php");
?>
	<html>
    <body>
<?php

	
	$c=new cMicrosoftGraphRama($_SESSION["idUsr"]);
		
	if(isset($_GET["code"]) && $_GET["code"] != "")
	{
		$tokenRequest = array(
								  "grant_type" => "authorization_code",
								  "client_id" => $c->clientId,
								  "scope" => $c->scope,
								  "code" => $_GET["code"],
								  "redirect_uri" => $c->redirectUri,
								  "client_secret" => $c->clientSecret
						   );
	   
		$tokenResponse = $c->callAPI("POST", $c->authApi . "token", $tokenRequest, null);
		
		
		
		
		$tokenResponse = json_decode($tokenResponse);
		
		if(isset($tokenResponse->error)) 
		{
			die("Token failure. " . $reload);
		}
		else 
		{
			if($c->salvarToken($tokenResponse,$_GET["state"]))
			{
			?>
            <script>
				localStorage.setItem("cuentaNube", "ok");
				window.close();
			</script>
            <?php	
			}
		}
	   
	}
	
	
	
?>
</body>
</html>