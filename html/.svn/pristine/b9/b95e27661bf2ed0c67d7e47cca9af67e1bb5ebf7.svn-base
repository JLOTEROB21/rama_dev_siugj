<?php session_start();
error_reporting(E_ALL);
include("conexionBD.php");
include("funcionesPortal.php");



	
	$consulta="SELECT DISTINCT archivoInclude FROM 808_configuracionEstilosMenu WHERE idConfiguracion=".$iEstiloMenu;
	$nombreRendererMenu=$con->obtenerValor($consulta);
	if($nombreRendererMenu!="")
	{
		include($nombreRendererMenu);

	}
	

	$consulta="SELECT * FROM 903_variablesSistema";
	$fVariable=$con->obtenerPrimeraFilaAsoc($consulta);
	$tipoAutenticacion=$fVariable["tipoAutenticacion"]; //1 Sistema; 2 Servidor LDAP
	
	
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">

<title><?php echo $fVariable["tituloSistema"]?></title>

<meta name="format-detection" content="telephone=no"/>
<link rel="icon" href="images/favicon.ico" type="image/x-icon">
<link rel="stylesheet" href="../estilos/fontAwesome.min.css">
<link rel="stylesheet" type="text/css" href="../Scripts/ext/resources/css/ext-all.css.cgz"/>
<script type="text/javascript" src="../Scripts/ext/adapter/ext/ext-base.js.jgz"></script>
<script type="text/javascript" src="../Scripts/ext/ext-all.js.jgz"></script>
<script type="text/javascript" src="../Scripts/ext/idioma/ext-lang-es.js"></script>
<link rel="stylesheet" type="text/css" href="../Scripts/ext/resources/css/xtheme-gray.css"/>
<link rel="stylesheet" type="text/css" href="./css/estilos2016.css"/>
<link rel="stylesheet" type="text/css" href="../css/hayas.css.php"/>
<script type="text/javascript" src="../Scripts/base64.js"></script>
<script type="text/javascript" src="../Scripts/funcionesAjaxV2.js"></script>
<script type="text/javascript" src="../Scripts/funcionesUtiles.js.php"></script>
<script type="text/javascript" src="../Scripts/funcionesValidacion.js"></script>
<script type="text/javascript" src="../Scripts/jquery.min.js"></script>


<style>
<?php
	generarFuentesLetras();

	
	$nConfiguracion=0;
	$colorBoton="";
	$tituloSistema="";
	
?>	
</style>
<link rel="stylesheet" type="text/css" href="../principalPortal/css/controlesFrameWork.css"/>
<link rel="stylesheet" type="text/css" href="../principalPortal/css/estiloSIUGJ.css"/>

</head>

<body  style="background:#F4F5F7;" id="bodyDocument">
	<table width="100%"  class="tablaGlobal">
	<tr>
	<td align="center">
    	<div class="rectangulo1">
        	<img class="imagenLogoGov" src="../principalPortal/imagesSIUGJ/logo_gov.png">
        </div>
        <div class="rectangulo2Index" style="height:150px">
			<a href="<?php echo $urlSitio?>"><img class="imagenLogo" src="../principalPortal/imagesSIUGJ/logoRamaJudicial2.png"></a>
            <img class="imagenLogo2" src="../principalPortal/imagesSIUGJ/Paleta_SIUGJ_Mesa_de_trabajo_1.png">
            
             
           
        </div>
       
	</td>
	</tr>
	</table>   
    <div id="areaCentralTrabajo" style="height:1000px; background-color:#FFF">
    <br>
    <table width="100%">	
    <tr>
    	<td align="left">
        &nbsp;&nbsp;&nbsp;&nbsp;<span class="letraTituloPagina">Validaci&oacute;n de Documento mediante QR</span>
        </td>
    </tr>
    <tr>
    	<TD>
        	<?php
				$folioQR="";
				$idDocumentoEncoded="";
				if(isset($_GET["idDoc"]))
				{
					$folioQR=$_GET["idDoc"];
				}
				$consulta="SELECT idArchivo,nomArchivoOriginal,fechaCreacion,responsable,sha512 FROM 908_archivos WHERE folioQR='".$folioQR."'";
				$filaCodigo=$con->obtenerPrimeraFilaAsoc($consulta);
				
				$situacion='<img src="../images/cancel_round.png" title="Documento NO registrado en sistema" alt="Documento NO registrado en sistema"> Documento NO registrado en sistema';
				$nombreDocumento="----------";
				$fechaRegistro="----------";
				$nombreResponsable="----------";
				if($filaCodigo)
				{
					$situacion='<img src="../images/accept_green.png" title="Documento registrado en sistema" alt="Documento registrado en sistema"> Documento registrado en sistema';
					$nombreDocumento=$filaCodigo["nomArchivoOriginal"];
					$fechaRegistro=date("d/m/Y h:i:s",strtotime($filaCodigo["fechaCreacion"]));
					$nombreResponsable=obtenerNombreUsuario($filaCodigo["responsable"]);
					$idDocumentoEncoded=$filaCodigo["sha512"];
					
					
				}
			?>
            <br><br>
            <table>
            	<tr height="26" >
                	<td width="260">&nbsp;&nbsp;&nbsp;&nbsp;<span class="SIUGJ_Etiqueta">Situaci&oacute;n del Documento:</span></td><td><span class="SIUGJ_Control_Azul"><?php echo $situacion?></span></td>
                </tr>
                <tr height="26">
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;<span class="SIUGJ_Etiqueta">Nombre del Documento:</span></td><td><span class="SIUGJ_Control_Azul"><?php echo $nombreDocumento?></span></td>
                </tr>
                <tr height="26">
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;<span class="SIUGJ_Etiqueta">Fecha de Registro:</span></td><td><span class="SIUGJ_Control_Azul"><?php echo $fechaRegistro?></span></td>
                </tr>
                <tr height="26">
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;<span class="SIUGJ_Etiqueta">Responsable del Registro:</span></td><td><span class="SIUGJ_Control_Azul"><?php echo $nombreResponsable?></span></td>
                </tr>
               
            </table>
            <br>
            <table width="100%">
            <tr style="display:<?php echo $filaCodigo?"":"none" ?>">
            	<td>
                	<span id="tblDocumentoViewer">
                    </span>
                </td>
            </tr>
            </table>
            
    	</TD>	
    </tr>
    </table>

    </div>
    
    <div class="rectangulo4">
        <br>
			<table width="100%">
            <tr>
            	<td align="center">
                <br>
                	<table>
                    	<tr>
                        	<td width="350" align="left" class="celdaInferior"><span class="letraBarraInferior">Cuentas de correo para Notificaciones Judiciales</span></td>
                            <td width="351" align="center" class="celdaInferior"><span class="letraBarraInferior">Pol&iacute;ticas de Privacidad y Condiciones de Uso</span></td>
                            <td width="155" align="center" class="celdaInferior"><span class="letraBarraInferior">Correo Institucional</span></td>
                            <td width="268" align="center" class="celdaInferiorUltima"><span class="letraBarraInferior">Directorio de Correos electr&oacute;nicos</span></td>
                        </tr>
                        <tr>
                        	<td colspan="2" align="left"><br><br>
                            <span class="letraBarraInferior2">
                            Calle 12 No. 7 - 65, Palacio de Justicia Alfonso Reyes Echandía, Bogotá Colombia<br>
                            Horario de Atención Lunes a Viernes<br>
                            8:00 a.m. a 1:00 p.m. - 2:00 p.m. a 5:00 p.m.
                            </span>

                            </td>
                            <td colspan="2"><br><br><br>
                            <span class="letraBarraInferior2">
                            PBX: (571) 565 8500 - E-mail: info@cendoj.ramajudicial.gov.co<br>
                            Acceder a los Canales de Atención<br>
                            Mapa del sitio
                            </span>

                            </td>
                            
                        </tr>
                        <tr>
                        	<td colspan="4" align="center">
                            <br><br>
                            	<table>
                                	<tr>
                                    	<td align="center" width="120">
                                        	<img src="../principalPortal/imagesSIUGJ/logoFace.png">
                                        </td>
                                        <td align="center" width="120">
                                        	<img src="../principalPortal/imagesSIUGJ/logoTwitter.png">
                                        </td>
                                        <td align="center" width="120">
                                        	<img src="../principalPortal/imagesSIUGJ/logoInstagram.png">
                                        </td>
                                        <td align="center" width="120">
                                        	<img src="../principalPortal/imagesSIUGJ/logoYoutube.png">
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            </table>
        </div>   
        <form method="post"	action="" id='frmEnvioDatos'>
          <input type="hidden" name="confReferencia" value="<?php echo $nConfiguracion ?>" />
      	</form>
      	<script>
			Ext.onReady(inicializar);

			function inicializar()
			{
				<?php
				if($filaCodigo)
				{
				?>
				new Ext.Panel (
									{
										  height:800,
										  renderTo:'tblDocumentoViewer',
										  layout:'border',
										  items:	[
													  new Ext.ux.IFrameComponent({ 
		  
																						  id: 'frameContenidoReporte', 
																						  anchor:'100% 100%',
																						  region:'center',
																						  loadFuncion:function(iFrame)
																									  {
																										  
																									  },

																						  url: '../paginasFunciones/white.php',
																						  style: 'width:100%;height:100%' 
																				  })
												  ]
									  }
								)
								
				gEx('frameContenidoReporte').load	(
                                            {
                                                url:'../visoresGaleriaDocumentos/visorDocumentosGeneral.php',
                                                params:	{
                                                            iD:'<?php echo $idDocumentoEncoded?>',
															eV2:1,
                                                            cPagina:'sFrm=true'
                                                        }
                                            }
                                        );                     								
								
			
				<?php
				}
				?>
			}
		</script>        
</body>
</html>