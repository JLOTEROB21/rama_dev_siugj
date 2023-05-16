<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	include_once("cConectoresServicios/cMicrosoftGraphRama.php");
	
	$c=new cMicrosoftGraphRama($_SESSION["idUsr"]);
?>

cMicrosoftGraphRama={};

cMicrosoftGraphRama.continueConfiguration=function(cadObj)
										{
                                        	var objConf=eval('['+cadObj+']')[0];
                                        
                                        	var obj={};
                                            obj.url='<?php echo $c->urlLogin?>';
                                            obj.params=	[
                                                            ['client_id','<?php echo $c->clientId?>'],
                                                            ['response_type','code'],
                                                            ['redirect_uri','<?php echo $c->redirectUri?>'],
                                                            ['response_mode','query'],
                                                            ['scope','<?php echo ($c->scope)?>'],
                                                            ['state',objConf.cuentaSistema?objConf.cuentaSistema:'0'],
                                                            ['prompt','login'],
                                                            ['login_hint',gEx('txtNombreConexion').getValue()]
                                                        ];
                                                        
                                                        
                                           	
                                            
                                                         
                                            enviarFormularioDatos(obj.url,obj.params,'POST','_BLANK');
                                        }