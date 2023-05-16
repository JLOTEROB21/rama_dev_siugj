<?php session_start();
include("conexionBD.php");

$respaldoSession=$_SESSION;

aperturarSesionUsuario(4147);

$consulta="SELECT tituloSistema FROM 903_variablesSistema";
$fSistema=$con->obtenerPrimeraFila($consulta);

if(isset($_GET['iM'])) 
{	
	$idNotificacion=$_GET['iM'];
	
	$consulta="SELECT AES_DECRYPT(UNHEX('".$idNotificacion."'), '".bD($versionLatis)."') AS idNotificacion";
	$idNotificacion=$con->obtenerValor($consulta);
	$consulta="SELECT * FROM _665_tablaDinamica WHERE id__665_tablaDinamica=".$idNotificacion;
	$fNotificacion=$con->obtenerPrimeraFilaAsoc($consulta);
	if(!$fNotificacion)
	{
?>
            <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
            <link rel="stylesheet" type="text/css" href="../css/hayas.css.php" media="screen" />
            <link rel="stylesheet" type="text/css" href="../estilos/estilos.css" media="screen" />
            <!--[if IE 8]><link rel="stylesheet" type="text/css" href="../estilos/estilosExtIE8.css" media="screen" /><![endif]-->
            <!--[if IE 7]><link rel="stylesheet" type="text/css" href="../estilos/estilosExtIE7.css" media="screen" /><![endif]-->
            <!--[if IE 6]><link rel="stylesheet" type="text/css" href="../estilos/estilosExtIE6.css" media="screen" /><![endif]-->
            <!--[if IE]><link rel="stylesheet" type="text/css" href="../estilos/estilosExtIE8.css" media="screen" /><![endif]-->
            
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <title><?php echo $fSistema[0]?></title>
            </head>
            
            <body>
                <table width="100%">
                <tr>
                    <td align="center">
                        <table width="100%" >
                            <tr>
                                <td align="left"  style="padding-left:60px; padding-top:20px">
                                    <img src="<?php echo $urlSitio?>principalPortal/imagesSIUGJ/logoRamaJudicial2.png" width="20%" >
                                </td>  
                            </tr>
                            <tr>
                                <td align="center"><br />
                                    <table width="800">
                                        <tr>
                                            <td>
                               
                                                <fieldset class="frameHijo"><legend><b>Notificaci&oacute;n Inexistente</b></legend>
                                                    <table width="100%">
                                                        <tr>
                                                            <td width="145">
                                                                <img src="<?php echo $urlSitio?>images/prohibido.png" />
                                                            </td>
                                                            <td><span class="letraRoja">La Notificaci&oacute;n que desea marcar como recibida NO existe<br />
                                                            <br />
                                                            </span>
                                                                
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </fieldset>
                                                <script>
													setTimeout(function(){ window.close() }, 5000);
												</script>
                                
                                        
                                            </td>
                                        </tr>
                                    </table>
                                
                                </td>
                            </tr>
                        </table>                
                    </td>
                </tr>
               </table>
            </body>
            </html>
<?php        
     }
     else
     {

		 $consulta="SELECT COUNT(*) FROM _722_tablaDinamica WHERE idReferencia=".$idNotificacion." and medioNotificacionResultadoNotificacion=1";
		 $numReg=$con->obtenerValor($consulta);
		 if($numReg==0)
		 {
			 $consulta="INSERT INTO _722_tablaDinamica(idReferencia,fechaCreacion,responsable,fechaRealizacionDiligenciaResultadoNotificacion,
						horaRealizacionDiligenciaResultadoNotificacion,
						realizarNotificacionResultadoNotificacion,medioNotificacionResultadoNotificacion,confirmadoMedianteCorreo)
						VALUES(".$idNotificacion.",'".date("Y-m-d H:i:s")."',".$_SESSION["idUsr"].",'".date("Y-m-d")."','".date("H:i")."',1,1,1)";
			 $con->ejecutarConsulta($consulta);
			 
			 $idRegistro=$con->obtenerUltimoID();
			 asignarFolioRegistro(722,$idRegistro);
			 
		 }
		 cambiarEtapaFormulario(665,$idNotificacion,5.5,"",-1,"NULL","NULL",0);

?>
			<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
            <link rel="stylesheet" type="text/css" href="../css/hayas.css.php" media="screen" />
            <link rel="stylesheet" type="text/css" href="../estilos/estilos.css" media="screen" />
            <!--[if IE 8]><link rel="stylesheet" type="text/css" href="../estilos/estilosExtIE8.css" media="screen" /><![endif]-->
            <!--[if IE 7]><link rel="stylesheet" type="text/css" href="../estilos/estilosExtIE7.css" media="screen" /><![endif]-->
            <!--[if IE 6]><link rel="stylesheet" type="text/css" href="../estilos/estilosExtIE6.css" media="screen" /><![endif]-->
            <!--[if IE]><link rel="stylesheet" type="text/css" href="../estilos/estilosExtIE8.css" media="screen" /><![endif]-->
            
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <title><?php echo $fSistema[0]?></title>
            </head>
            
            <body>
                <table width="100%">
                <tr>
                    <td align="center">
                        <table width="100%" >
                            <tr>
                                <td align="left"  style="padding-left:60px; padding-top:20px">
                                    <img src="<?php echo $urlSitio?>principalPortal/imagesSIUGJ/logoRamaJudicial2.png" width="20%" >
                                </td>  
                            </tr>
                            <tr>
                                <td align="center"><br />
                                    <table width="800">
                                        <tr>
                                            <td>
                               
                                                <fieldset class="frameHijo"><legend><b>Notificaci&oacute;n Recibida</b></legend>
                                                    <table width="100%">
                                                        <tr>
                                                            <td width="145">
                                                                <img src="<?php echo $urlSitio?>images/accept.png" />
                                                            </td>
                                                            <td><span class="letraRoja">La Notificaci&oacute;n ha sido confirmada, gracias por su reporte<br />
                                                            <br />
                                                            </span>
                                                                
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </fieldset>
                                                <script>
													setTimeout(function(){ window.close() }, 5000);
												</script>
                                
                                        
                                            </td>
                                        </tr>
                                    </table>
                                
                                </td>
                            </tr>
                        </table>                
                    </td>
                </tr>
               </table>
            </body>
            </html>
<?php
		 
     }   
}
else
{
?>
			<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
            <link rel="stylesheet" type="text/css" href="../css/hayas.css.php" media="screen" />
            <link rel="stylesheet" type="text/css" href="../estilos/estilos.css" media="screen" />
            <!--[if IE 8]><link rel="stylesheet" type="text/css" href="../estilos/estilosExtIE8.css" media="screen" /><![endif]-->
            <!--[if IE 7]><link rel="stylesheet" type="text/css" href="../estilos/estilosExtIE7.css" media="screen" /><![endif]-->
            <!--[if IE 6]><link rel="stylesheet" type="text/css" href="../estilos/estilosExtIE6.css" media="screen" /><![endif]-->
            <!--[if IE]><link rel="stylesheet" type="text/css" href="../estilos/estilosExtIE8.css" media="screen" /><![endif]-->
            
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <title><?php echo $fSistema[0]?></title>
            </head>
            
            <body>
                <table width="100%">
                <tr>
                    <td align="center">
                        <table width="100%" >
                            <tr>
                                <td align="left"  style="padding-left:60px; padding-top:20px">
                                    <img src="<?php echo $urlSitio?>principalPortal/imagesSIUGJ/logoRamaJudicial2.png" width="20%" >
                                </td>  
                            </tr>
                            <tr>
                                <td align="center"><br />
                                    <table width="800">
                                        <tr>
                                            <td>
                               
                                                <fieldset class="frameHijo"><legend><b>Notificaci&oacute;n Inexistente</b></legend>
                                                    <table width="100%">
                                                        <tr>
                                                            <td width="145">
                                                                <img src="<?php echo $urlSitio?>images/prohibido.png" />
                                                            </td>
                                                            <td><span class="letraRoja">La Notificaci&oacute;n que desea marcar como recibida NO existe<br />
                                                            <br />
                                                            </span>
                                                                
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </fieldset>
                                                <script>
													setTimeout(function(){ window.close() }, 5000);
												</script>
                                
                                        
                                            </td>
                                        </tr>
                                    </table>
                                
                                </td>
                            </tr>
                        </table>                
                    </td>
                </tr>
               </table>
            </body>
            </html>
<?php
}

$_SESSION=$respaldoSession;
?>