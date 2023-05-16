<?php session_start(); 
	include("conexionBD.php"); 
	include("funcionesPortal.php");
	include("configurarIdioma.php");

	
	$iEstiloMenu=6;

	$leyenda="";
	if(!esUsuarioLog())
	{
		header('Location:'.$paginaCierreLogin);
		return;
	}
	
	$fechaActual=strtotime(date("Y-m-d"));

	$consulta="SELECT fechaCambioContrasena,fechaLimiteCambioContrasena
				FROM 800_usuarios WHERE idUsuario=".$_SESSION["idUsr"];
	$fDatosCta=$con->obtenerPrimeraFilaAsoc($consulta);
	
	$consulta="SELECT tituloSistema,cantidadCambioCrontrasena,cantidadperiodoContrasenaDeshabilita,catidadContrasenaAvisoVencimiento,periodoContrasenaAvisoVencimiento  FROM 903_variablesSistema";
	$fSistema=$con->obtenerPrimeraFila($consulta);
	if(($fSistema[1]>0)&&($fSistema[2]>0))
	{
		if($fDatosCta["fechaLimiteCambioContrasena"]!="")
		{
			if(strtotime($fDatosCta["fechaLimiteCambioContrasena"])<=$fechaActual)
			{
				$_SESSION["statusCuenta"]="2";
			}
		}
		
		if($fDatosCta["fechaCambioContrasena"]!="")
		{
			$fechaCambioContrasena=strtotime($fDatosCta["fechaCambioContrasena"]);

			$fechaAviso=strtotime("- ".($fSistema[3]." ".($fSistema[4]==0?" days":"months")),$fechaCambioContrasena);
			
			if($fechaActual>$fechaCambioContrasena)
			{
				$diferenciaDias=obtenerDiferenciaDias(date("Y-m-d",$fechaCambioContrasena),date("Y-m-d",$fechaActual));
				$leyenda="<br><img src='../images/exclamation.png'> <span style='font-weight:normal;'>Excedido ".($diferenciaDias==1?" 1 d&iacute;a ":($diferenciaDias." dias "))." de la fecha en que deb&iacute;a cambiar su contrase&ntilde;a</span>";	
			}
			else
			{
				if($fechaActual>=$fechaAviso)
				{
					$diferenciaDias=obtenerDiferenciaDias(date("Y-m-d",$fechaActual),date("Y-m-d",$fechaCambioContrasena));
					$leyenda="<br><img src='../images/exclamation.png'> <span style='font-weight:normal;'>".($diferenciaDias==1?"Resta 1 d&iacute;a ":("Restan ".$diferenciaDias." dias "))." para cambiar su contrase&ntilde;a</span>";	
				}
			}
			
		}
	}
	
	$consulta="SELECT DISTINCT archivoInclude FROM 808_configuracionEstilosMenu WHERE idConfiguracion=".$iEstiloMenu;
	$nombreRendererMenu=$con->obtenerValor($consulta);
	if($nombreRendererMenu!="")
	{
		include($nombreRendererMenu);

	}
	
	$consulta="SELECT datosValidados FROM 802_identifica WHERE idUsuario=".$_SESSION["idUsr"]." AND tipoIdentificacion=4";
	$datosValidados=$con->obtenerValor($consulta);
	if($datosValidados=="0")
	{
		$_SESSION["statusCuenta"]=2;
	}
	
	if(isset($_SESSION["statusCuenta"]))
	{
		
		
		if(($_SESSION["statusCuenta"]=="2")||($_SESSION["statusCuenta"]=="3"))
		{
			header('Location:../modulosEspeciales_SIUGJ/nUsuariosIntermedia.php');
		}
	}

	
	$nUsuario=obtenerNombreUsuario($_SESSION["idUsr"]);

	$nomPagina="inicio";
	
	
	
	
	$consulta="SELECT * FROM 4081_configuracionPortal";
	$fRegistroConfiguracion=$con->obtenerPrimeraFilaAsoc($consulta);
	
	$consulta="SELECT Nom,Paterno,Materno FROM 802_identifica WHERE idUsuario=".$_SESSION["idUsr"];
	$fIdentifica=$con->obtenerPrimeraFilaAsoc($consulta);
	
	$inicialesUsr=mb_strtoupper((strlen($fIdentifica["Nom"])>0?$fIdentifica["Nom"][0]:"").(strlen($fIdentifica["Paterno"])>0?$fIdentifica["Paterno"][0]:""));
	
	$datosContacto="";
	$consulta="SELECT (SELECT nombre FROM 238_paises WHERE idPais=d.Pais) AS pais,
			 (SELECT estado FROM 820_estados WHERE cveEstado=d.Estado) AS estado,
			  (SELECT municipio FROM 821_municipios WHERE cveMunicipio=d.Ciudad) AS municipio
			 FROM 803_direcciones d WHERE idUsuario=1 AND Tipo=0";
	$fEstado=$con->obtenerPrimeraFilaAsoc($consulta);
	
	
	
	if($fEstado["estado"]!="")
	{
		$datosContacto=$fEstado["estado"];
	}
	
	if($fEstado["municipio"]!="")
	{
		if($datosContacto!="")
			$datosContacto.=", ".$fEstado["municipio"]."<br>";
		else
			$datosContacto=$fEstado["municipio"]."<br>";
	}
	
	if($fEstado["pais"]!="")
	{
		$datosContacto.=$fEstado["pais"]."<br>";
	}
	
	$consulta="SELECT nombreGrupo FROM 8001_roles WHERE CONCAT(idRol,'_',extensionRol) IN(".$_SESSION["idRol"].") ORDER BY nombreGrupo";
	$roles=$con->obtenerListaValores($consulta,"");
	$roles=str_replace(",","<br>",$roles);
	$consulta="SELECT Mail  FROM 805_mails WHERE idUsuario=".$_SESSION["idUsr"]." ORDER BY Mail";
	$mails=$con->obtenerListaValores($consulta);
	
	if($mails!="")
		$datosContacto.=str_replace(",","<br>",$mails)."<br>";
?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">

    <title><?php echo $fSistema[0]?></title>

    <link rel="stylesheet" type="text/css" href="../Scripts/ext/resources/css/ext-all.css.cgz" />
    <script type="text/javascript" src="../Scripts/ext/adapter/ext/ext-base.js.jgz"></script>
    <script type="text/javascript" src="../Scripts/ext/ext-all.js.jgz"></script>
    <script type="text/javascript" src="../Scripts/ext/idioma/ext-lang-es.js"></script>

    <link rel="stylesheet" type="text/css" href="./css/estilos2016.css" />

    <script type="text/javascript" src="../Scripts/base64.js"></script>

    <script type="text/javascript" src="../Scripts/funcionesUtiles.js.php"></script>
    <script type="text/javascript" src="../Scripts/funcionesValidacion.js"></script>

    <script type="text/javascript" src="../Scripts/jQuery/jquery-1.9.1.js"></script>
    <script src="../Scripts/collapsible/jquery.collapsible.js"></script>

    <link rel="stylesheet" href="../Scripts/fancyBox/fancybox/jquery.fancybox-1.3.4.css" type="text/css"
        media="screen" />
    <script type="text/javascript" src="../Scripts/fancyBox/fancybox/jquery.fancybox.js"></script>

    <link rel="stylesheet" type="text/css" href="../Scripts/ux/treeGrid/treegrid.css" />
    <script type="text/javascript" src="../Scripts/ux/treeGrid/TreeGridSorter.js"></script>
    <script type="text/javascript" src="../Scripts/ux/treeGrid/TreeGridColumnResizer.js"></script>
    <script type="text/javascript" src="../Scripts/ux/treeGrid/TreeGridNodeUIV2.js"></script>
    <script type="text/javascript" src="../Scripts/ux/treeGrid/TreeGridLoader.js"></script>
    <script type="text/javascript" src="../Scripts/ux/treeGrid/TreeGridColumns.js"></script>
    <script type="text/javascript" src="../Scripts/ux/treeGrid/TreeGrid.js"></script>


    <script type="text/javascript" src="../Scripts/funcionesAjax.js.jgz"></script>
    <script type="text/javascript" src="../modulosEspeciales_SGJP/Scripts/cGeneracionDocumentos.js.php"></script>
    <link rel="stylesheet" type="text/css" href="../Scripts/classNotify/jquery.classynotty.css" />
    <script src="../Scripts/classNotify/jquery.classynotty.js"></script>

    <script type="text/javascript" src="../modulosEspeciales_SGJP/Scripts/controlAgenda.js.php"></script>
    <script type="text/javascript" src="../Scripts/controlNotificaciones.js.php"></script>
    <script type="text/javascript" src="../modulosEspeciales_SGJP/Scripts/cValidarFirmaDocumento.js.php"></script>
    <script type="text/javascript" src="../modulosEspeciales_SGJP/Scripts/funcionesTableroControl.js.php"></script>
    <script type="text/javascript" src="./Scripts/cNotificadores.js.php"></script>
    <script type="text/javascript" src="../modulosEspeciales_SGJP/Scripts/cRevisionAlertas.js.php"></script>


    <script type="text/javascript" src="../principalPortal/Scripts/funcionesAdministracion.js.php"></script>

    <script type="text/javascript" src="./Scripts/inicioNuevo.js.php"></script>
    <link rel="stylesheet" type="text/css" href="../principalPortal/css/controlesFrameWork.css" />
    <link rel="stylesheet" type="text/css" href="../principalPortal/css/estiloSIUGJ.css" />
    <style>
    <?php generarFuentesLetras();
    ?>
    </style>
    <?php
	generarConfiguracionesMenus($iEstiloMenu);
	
	$nConfiguracion=0;

?>

</head>

<body style="background-color:#1A3E9A">

    <div id="parentMenu">
        <div class="main clearfix" id="arranqueHamburguesa"
            style="position:absolute;top:-26px; left:-45px;z-index:100000">
            <div class="column">
                <div id="dl-menu" class="dl-menuwrapper">
                    <button class="dl-trigger">Open Menu</button>
                    <ul class="dl-menu">
                        <?php
    				echo genearOpcionesMenusPrincipal($nomPagina,3);
    
    
    			?>
                    </ul>
                </div>
            </div>
        </div>
        <table width="100%" class="tablaGlobal">
            <tr>
                <td align="center">

                    <div class="rectangulo1">
                        <img class="imagenLogoGov" src="../principalPortal/imagesSIUGJ/logo_gov.png">

                    </div>
                    <div class="rectangulo2">
                        <img class="imagenLogo" src="../principalPortal/imagesSIUGJ/logoRamaJudicial2.png">
                        <img class="imagenLogo2"
                            src="../principalPortal/imagesSIUGJ/Paleta_SIUGJ_Mesa_de_trabajo_1.png">

                        <div class="etiquetaBienvenido">Bienvenido:&nbsp; <span
                                class="nombreUsuario"><?php echo $nUsuario.$leyenda?></span></div>
                        <?php
			if(esAdscripcionUnidadGestion()>0)
			{
			?>
                        <div class="divBusqueda" id="lblCarpetaJudicial"></div>
                        <?php
			}
			?>

                        <div class="etiquetaSalir">
                            <table width="200">
                                <tr>
                                    <td class="menuInicialUsuario" width="30">
                                        <div class="divMenuIcon">
                                            <img src="../principalPortal/imagesSIUGJ/portapapeles.png">
                                            <div class="dropdown-child" id="dropTareas">
                                                <table width="100%">

                                                    <tr>
                                                        <td align="center" class="tdDropdown tdDropdownHover">
                                                            <table width="100%">
                                                                <tr>
                                                                    <td width="30" align="left"
                                                                        style="padding-left:10px"><img
                                                                            src="../principalPortal/imagesSIUGJ/bulletTask_green.png">
                                                                    </td>
                                                                    <td align="left"><a
                                                                            href="javascript:mostrarTareasPendientes()">Tareas
                                                                            pendientes</a></td>
                                                                    <td align="right" style="padding-right:10px">
                                                                        <a href="javascript:mostrarTareasPendientes()">
                                                                            <div id="divPendientes">
                                                                                (0)
                                                                            </div>
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <td align="center" class="tdDropdown tdDropdownHover">
                                                            <table width="100%">
                                                                <tr>
                                                                    <td width="30" align="left"
                                                                        style="padding-left:10px"><img
                                                                            src="../principalPortal/imagesSIUGJ/bulletTask_red.png">
                                                                    </td>
                                                                    <td align="left"><a
                                                                            href="javascript:mostrarTareasVencidas();"
                                                                            style="color:#9B2027">Tareas vencidas</a>
                                                                    </td>
                                                                    <td align="right" style="padding-right:10px;">
                                                                        <a href="javascript:mostrarTareasVencidas();"
                                                                            style="color:#9B2027">
                                                                            <div style="color:#9B2027" id="divVencidas">
                                                                                (0)
                                                                            </div>
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <td align="center" class="tdDropdown tdDropdownHover">
                                                            <table width="100%">
                                                                <tr>
                                                                    <td width="30" align="left"
                                                                        style="padding-left:10px"><img
                                                                            src="../principalPortal/imagesSIUGJ/bulletTask_yellow.png">
                                                                    </td>
                                                                    <td align="left"><a
                                                                            href="javascript:mostrarTareasPorVencer();">Tareas
                                                                            por vencer</a></td>
                                                                    <td align="right" style="padding-right:10px">
                                                                        <a href="javascript:mostrarTareasPorVencer();">
                                                                            <div id="divPorVencer">
                                                                                (0)
                                                                            </div>
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <td align="center" class="tdDropdown tdDropdownHover">
                                                            <table width="100%">
                                                                <tr>
                                                                    <td width="30" align="left"
                                                                        style="padding-left:10px"><img
                                                                            src="../principalPortal/imagesSIUGJ/bulletTask_black.png">
                                                                    </td>
                                                                    <td align="left"><a
                                                                            href="javascript:mostrarTareasRealizadas()">Tareas
                                                                            realizadas</a></td>
                                                                    <td align="right" style="padding-right:10px">
                                                                        <a href="javascript:mostrarTareasRealizadas()">
                                                                            <div id="divRealizadas">
                                                                                (0)
                                                                            </div>
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <td align="center" class="tdDropdownHover">
                                                            <table width="100%">
                                                                <tr>

                                                                    <td colspan="3" align="center"><a
                                                                            href="javascript:mostrarTodasTareas()">Ver
                                                                            todas</a></td>
                                                                </tr>
                                                            </table>
                                                        </td>

                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </td>
                                    <td width="50" align="left">
                                        <div class="burbujaNotificacionV2" id="total_tareas"
                                            onmouseover="mostrarMenu('dropTareas')"
                                            onmouseout="ocultarMenu('dropTareas')">
                                            <div></div>
                                        </div>
                                    </td>
                                    <td class="menuInicialUsuario" width="30">
                                        <div class="divMenuIcon">
                                            <img src="../principalPortal/imagesSIUGJ/campana.png">
                                            <div class="dropdown-child" id="dropNotificaciones">

                                            </div>
                                        </div>

                                    </td>
                                    <td width="50">
                                        <div class="burbujaNotificacionV2" id="total_notificaciones"
                                            onmouseover="mostrarMenu('dropNotificaciones')"
                                            onmouseout="ocultarMenu('dropNotificaciones')">
                                            <div></div>
                                        </div>
                                    </td>
                                    <td class="menuInicialUsuario" width="40">
                                        <div class="inicialesUsuario">
                                            <div><?php echo $inicialesUsr?></div>
                                            <div class="dropdown-child">
                                                <table width="100%">
                                                    <tr>
                                                        <td colspan="2" align="center" class="tdDropdown">
                                                            <div class="inicialesUsuario2"><?php echo $inicialesUsr?>
                                                            </div><br>
                                                            <div style="font-size:16px; font-weight:700">
                                                                <?php echo $nUsuario?>
                                                            </div>

                                                            <div style="font-size:12px; font-weight:500">
                                                                <?php echo $datosContacto?>
                                                            </div>

                                                            <div style="font-size:12px; font-weight:700">
                                                                <?php echo $roles?>
                                                            </div>
                                                            <br>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td align="center" class="tdDropdown tdDropdownHover">
                                                            <table wi>
                                                                <tr>
                                                                    <td width="30"><a
                                                                            href="javascript:abrirDatosAccesoCuenta();"><img
                                                                                src="../principalPortal/imagesSIUGJ/editUser.png"></a>
                                                                    </td>
                                                                    <td align="center"><a
                                                                            href="javascript:abrirDatosAccesoCuenta();">Editar
                                                                            usuario</a></td>
                                                                </tr>
                                                            </table>
                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <td align="center" class="tdDropdownHover">
                                                            <table>
                                                                <tr>
                                                                    <td width="30"><a
                                                                            href="javascript:cerrarSesionPrincipal()"><img
                                                                                src="../principalPortal/imagesSIUGJ/exit.png"></a>
                                                                    </td>
                                                                    <td align="center"><a
                                                                            href="javascript:cerrarSesionPrincipal()">Cerrar
                                                                            sesi&oacute;n</a></td>
                                                                </tr>
                                                            </table>
                                                        </td>

                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                        </div>
                </td>

                <!--<td><a href="javascript:cerrarSesionPrincipal()">Salir</a></td><td><a href="javascript:cerrarSesionPrincipal()">
            		 <img class="" src="../principalPortal/imagesSIUGJ/Vector.png"></a>-->
                </td>
            </tr>
        </table>
    </div>
    </div>
    <table width="100%" cellspacing="0" style="padding:0px; border:0px">
        <tr>
            <td colspan="2">

            </td>
        </tr>

        <tr>
            <td colspan="8" valign="top" align="center">

                <!--<div >
                <div class="wrap">
                    <nav>
                    <ul class="menu" >
                        
            	</ul>
                    <div class="clearfix"></div>
                    </nav>
                </div>	
            </div>-->



            </td>
        </tr>
        <tr style="display:none">
            <td colspan="8">

                <div class="rectangulo3">
                    <div id="tblNotificacionesBar" class="tblNotificacionesBar">

                    </div>
                </div>
            </td>
        </tr>


        <tr>

            <td align="center" colspan="8">
                <table width="100%">
                    <tr>

                        <td align="center" style="vertical-align:top">

                            <!--   Aqui!-->





                            <!-- /dl-menuwrapper -->

                            <span id="tblTabla">
                            </span>
                        </td>
                    </tr>
                </table>

            </td>
        </tr>

    </table>

    <div class="rectangulo4">
        <br>
        <table width="100%">
            <tr>
                <td align="center">
                    <br>
                    <table>
                        <tr>
                            <td width="350" align="left" class="celdaInferior"><span class="letraBarraInferior">Cuentas
                                    de correo para Notificaciones Judiciales</span></td>
                            <td width="351" align="center" class="celdaInferior"><span
                                    class="letraBarraInferior">Pol&iacute;ticas de Privacidad y Condiciones de
                                    Uso</span></td>
                            <td width="155" align="center" class="celdaInferior"><span class="letraBarraInferior">Correo
                                    Institucional</span></td>
                            <td width="268" align="center" class="celdaInferiorUltima"><span
                                    class="letraBarraInferior">Directorio de Correos electr&oacute;nicos</span></td>
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
                                    Mapa del sitio 2
                                </span>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

        </table>
    </div>
    </td>
    </tr>
    </table>
    <iframe id="framePrincipal" name="framePrincipal" src="" width="1" height="1"
        onload="frameLoadPrincipal(this)">
    </iframe>
    <br><br>

    <form method="post" action="" id='frmEnvioDatos'>
        <input type="hidden" name="confReferencia" value="<?php echo $nConfiguracion ?>" />

        <input type="hidden" id="tipoFormato" value="" />
        <input type="hidden" id="idRegistroFormato" value="" />
        <input type="hidden" id="idFormulario" name="idFormulario" value="" />
        <input type="hidden" id="idRegistro" value="" />
        <input type="hidden" id="idReferencia" value="" />
        <input type="hidden" id="sL" value="" />
        <input type="hidden" id="idFormularioProceso" value="-1" />

    </form>


</body>

</html>