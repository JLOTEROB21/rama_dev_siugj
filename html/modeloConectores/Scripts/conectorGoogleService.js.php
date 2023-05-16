<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	include_once("cConectoresServicios/cGoogleServices.php");
	
	$c=new cGoogleServices($_SESSION["idUsr"]);
?>

cGoogleServices={};

cGoogleServices.continueConfiguration=function(cadObj)
										{
                                        	var objConf=eval('['+cadObj+']')[0];
                                        	var obj={};
                                            obj.url='<?php echo $c->urlLogin?>';
                                            obj.params=	[
                                                            ['client_id','<?php echo $c->clientId?>'],
                                                            ['response_type','code'],
                                                            ['redirect_uri','<?php echo $c->redirectUri?>'],
                                                            ['scope','<?php echo ($c->scope)?>'],
                                                            ['prompt','consent'],
                                                            ['prompt','login'],
                                                            ['login_hint',gEx('txtNombreConexion').getValue()]
                                                        ];
                                            enviarFormularioDatos(obj.url,obj.params,'POST','_BLANK');
                                        }