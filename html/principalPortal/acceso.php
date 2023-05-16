<?php  	session_start();
include("conexionBD.php"); 
include_once("funcionesPortal.php"); 


if(esUsuarioLog())
{
	header('Location:../principalPortal/inicio.php');
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>IEP</title>
    <meta charset="utf-8">
    <meta name="format-detection" content="telephone=no"/>
    <link rel="icon" href="images/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="../Scripts/ext/resources/css/ext-all.css.cgz"/>
    <link rel="stylesheet" href="css/grid.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/jquery.js"></script>
    <script src="js/jquery-migrate-1.2.1.js"></script>
    <!--[if (gt IE 9)|!(IE)]><!-->
    <script src="js/wow/wow.js"></script>
    <script>
        $(document).ready(function () {
            if ($('html').hasClass('desktop')) {
                new WOW().init();
            }
        });
    </script>
	<script type="text/javascript" src="../Scripts/funcionesValidacion.js"></script>
    <link rel="stylesheet" type="text/css" href="../Scripts/opentip/opentip.css" media="screen" />
	<script type="text/javascript" src="../Scripts/opentip/opentip-jquery-excanvas.min.js"></script>

    <!--<![endif]-->
    <!--[if lt IE 9]>
    <html class="ie8">
    <div id="ie6-alert" style="width: 100%; text-align:center;">
        <img src="http://beatie6.frontcube.com/images/ie6.jpg" alt="Upgrade IE 6" width="640" height="344" border="0"
             usemap="#Map" longdesc="http://die6.frontcube.com"/>
        <map name="Map" id="Map">
            <area shape="rect" coords="496,201,604,329"
                  href="http://www.microsoft.com/windows/internet-explorer/default.aspx" target="_blank"
                  alt="Download Interent Explorer"/>
            <area shape="rect" coords="380,201,488,329" href="http://www.apple.com/safari/download/" target="_blank"
                  alt="Download Apple Safari"/>
            <area shape="rect" coords="268,202,376,330" href="http://www.opera.com/download/" target="_blank"
                  alt="Download Opera"/>
            <area shape="rect" coords="155,202,263,330" href="http://www.mozilla.com/" target="_blank"
                  alt="Download Firefox"/>
            <area shape="rect" coords="35,201,143,329" href="http://www.google.com/chrome" target="_blank"
                  alt="Download Google Chrome"/>
        </map>
    </div>
    <script src="js/html5shiv.js"></script>
    <link rel="stylesheet" type="text/css" media="screen" href="css/ie.css">
    <![endif]-->
	<script type="text/javascript" src="../Scripts/ext/adapter/ext/ext-base.js.jgz"></script>
    <script type="text/javascript" src="../Scripts/ext/ext-all.js.jgz"></script>
    <script type="text/javascript" src="../Scripts/funcionesAjax.js.jgz"></script>
    <script type="text/javascript" src="../Scripts/funcionesUtiles.js.php"></script>   
    <script type="text/javascript" src="../Scripts/funcionesValidacion.js"></script>
    <script type="text/javascript" src="../Scripts/ext/idioma/ext-lang-es.js"></script>
    <script type="text/javascript" src="../principalPortal/Scripts/acceso.js.php"></script>  

<style>
	.isStuck 
	{
		background:#FFF;
	}
	.header 
	{
		background:#FFF;
	}
	.letraRojaSubrayada8
	{
		color:#900;
		text-decoration:underline;
	}
	.search-item {
				font: normal 11px tahoma, arial, helvetica, sans-serif;
				padding: 3px 10px 3px 10px;
				border: 1px solid #fff;
				border-bottom: 1px solid #eeeeee;
				white-space: normal;
				color: #555;
				}
	.botonAccion
	{
		height:22px;
		width:85px; 
		text-align:center; 
		border-style:solid; 
		border-width:1px; 
		background-color:#FFF;
		
	}
	
	.botonAccion:hover  
	{
		border-style:solid; 
		border-width:1px; 
		background-color:#CCC;
		cursor:pointer; cursor: hand;
	}
	
	.container 
	{
		margin-right:0px !important;
		margin-left: 0px !important;
		
	}
	
	.ext-mb-aceptado {
					  background-image: url(../images/publish_f2.png) ;
					  background-repeat:no-repeat;
					}
	
</style>
</head>

<body>

<div class="page">

    <!--========================================================
                              HEADER
    =========================================================-->
    <table width="100%">
    	<tr>
        	<td align="center">
                <header id="header" class="header page2">
                    <div id="stuck_container">
                        <div class="container">
                            
                                 <table width="100%">
                                 	<tr>
                                    	<td align="center">
                                        
                                            <table  >
                                                <tr>
                                                    <td  align="center"><br><br>
                                                        <span style="font-size:42px; color:#900; line-height:40px"><b>
                                                        Chiles y Semillas<br>
                                                        El Zacatecano</b>
                                                        </span>
                                                        </td>
                                                    </td>                                                  
                                                    
                                                 </tr>
                                                  <tr>
                                                    <td  align="right">
                                                        <span style="color:#030; font-size:15px">
                                                        Grupo Latis
                                                        </span>
                                                        </td>
                                                    </td>
                                                    
                                                    
                                                 </tr>
                                            </table>
                                        </td>
                                  </tr>
                              </table>
                                        
                                    
              
            
                            
                            <div class="clearfix"></div>
                        </div>
            
                    </div>
            
                </header>
            </td>
        </tr>
    </table>
    <!--========================================================
                              CONTENT
    =========================================================-->
    <section id="content" class="content">

        <div class="container">
            <div class="wrapper3">
				
                
                <div class="row off1">
                    <div class="grid_10">
                        <div class="icon-box box wow fadeInLeft" data-wow-delay="0.2s">
                            <div class="box_left">
                              <div class="icon icon__mod fa fa-folder-open-o"></div>
                            </div>
                            <div class="box_cnt o__hidden">
                               
                             
                                
                            </div>
                        </div>
                    </div>
               </div>
                
                
               

                
                    
                    
                    
				<div class="row off1">
					
                    <div class="grid_6a">
                      <div class="icon-box box wow fadeInLeft" data-wow-delay="0.2s">
                            <div class="box_left">
                                <div class="icon icon__mod fa fa-user">
                                
                                
                                </div>
                            </div>
                            <div class="box_cnt o__hidden">
                                
                                <p class="off3">
                                
                                
                                <table>
                                	<tr>
                                    	<td style="display:" id="tblLogin">
                                        	<div class="right">
                                                <h1  style="font-size:15px">Ingresa tu nombre de usuario y contraseña</h1>
                                                
                                                <form action="forms/login">
                                                    <table>
                                                    
                                                    <tr>
                                                    	<td width="120">
	                                                    <label>Nombre de usuario</label>
                                                        </td>
                                                        <td>
	                                                    <input name="text" type="text"  class="cTexto" id="txtLogin"  maxlength="80" />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                    	<td>
	                                                    <label>Contraseña</label>
                                                        </td>
                                                        <td>
	                                                    <input name="password" type="password" class="cTexto" id="txtPass" maxlength="80"/>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                    <td colspan="2">
                                                    	<span id="filaErrorLogin" style="display:none">
                                                            <p><div style="font-size:12px;color:#F00 !important; padding-top:5px; padding-bottom:5px"><b>Usuario / contraseña incorrecta</b></div></p>
                                                        </span>
                                                    </td>
                                                    </tr>
                                                    <tr>
                                                    <td colspan="2" align="center">
                                                    <div class="but mar5 floatl"><input  type="button" onClick="autentificarUsuario()" name="login" value="Ingresar" class="botonAccion" /> <div class="clearl"></div></div>
                                                    </td>
                                                    </tr>
                                                    <tr style="display:none">
                                                    	<td colspan="2">
                                                        	¿Aún no tienes una cuenta? <a href="javascript:mostrarVentanaNuevoRegistro()"><span  style="color:#F00">
                       
                                                            Regístrate</span></span></a>
                                                        </td>
                                                    </tr>
                                                    <tr style="display:none">
                                                    <td colspan="2">
                                                    
                                                    ¿Olvidaste tu contraseña? <a href="javascript:mostrarVentanaRecuperarContrasena()"><span  style="color:#F00">
              
                                                    Recuperar contraseña</span></span></a>
                                                    </td>
                                                    </tr>
                                                    
                                                    </table>
                                                </form>
                                            </div>
                                        </td>
                                        <td>
                                        </td>
                                        <td style="display:none; line-height:normal !important; max-width:none !important; height:inherit !important;" id="tblRegistro">
                                        	<form id="frmEnvio">
                    
                                                <table >
                                                <tr>
                                                    <td align="right">
                                                        <b><label style="font-size:22px; color:#000">Ficha de registro de cuenta</label></b>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="left" style="padding:10px">
                                                        <table>
                                                        <tr height="45">
                                                            <td colspan="11" style="vertical-align:middle; background:url(../principalPortal/images/field_bg2.png)">
                                                                <b><label style="font-size:15px; color:#000">Datos generales:</label></b>
                                                            </td>
                                                            
                                                        </tr>
                                                        <tr height="25">
                                                            <td>
                                                                <label>Título (Dr., Sr.):</label>
                                                            </td>
                                                            <td>
                                                                <input type="text" maxlength="20" size="7" id='txtPrefijo' name='txtPrefijo' val='' campo='Prefijo' />
                                                            </td>
                                                            <td >
                                                            </td>
                                                            <td>
                                                                
                                                            </td>
                                                            <td>
                                                                
                                                            </td>
                                                            <td >
                                                            </td>
                                                            <td>
                                                                
                                                            </td>
                                                            <td>
                                                                
                                                            </td>
                                                        </tr>
                                                        
                                                        
                                                        <tr height="25">
                                                            <td width="135">
                                                                <label>Apellido Paterno:</label><span style="color:#F00"><b>*</b></span>&nbsp;
                                                            </td>
                                                            <td>
                                                                <input type="text" name="txtApPaterno" id="txtApPaterno" maxlength="40"  style="width:140px" val="obl" campo="Apellido Paterno" />
                                                            </td>
                                                            <td width="10">
                                                            </td>
                                                            <td  width="125">
                                                                <label>Apellido Materno:</label>&nbsp;
                                                            </td>
                                                            <td>
                                                                <input type="text" maxlength="40" size="30" id='txtApMaterno' style="width:140px" />
                                                            </td>
                                                            <td width="10">
                                                            </td>
                                                            <td  width="80">
                                                                 <label>Nombre:</label><span style="color:#F00"><b>*</b></span>&nbsp;
                                                            </td>
                                                            <td>
                                                                <input type="text" maxlength="40" size="30" id='txtNombre' name="txtNombre" val='obl' campo='Nombre' style="width:180px" />
                                                            </td>
                                                        </tr>
                                                        <tr height="25">
                                                            <td>
                                                                <label>Sexo:</label>
                                                            </td>
                                                            <td>
                                                                <div style="color:#000000; font-size:11px" ><input type="radio" id="sexoM"  checked="checked" /> Hombre&nbsp;&nbsp;&nbsp; <input type="radio"  id="sexoF"  /> Mujer</div>
                                                            </td>
                                                             <td >
                                                            </td>
                                                            <td  >
                                                                
                                                            </td>
                                                            <td>
                                                                
                                                            </td>
                                                            <td >
                                                            </td>
                                                            <td  >
                                                                
                                                            </td>
                                                            <td>
                                                                
                                                            </td>
                                                            
                                                            
                                                        </tr>
                                                        
                                                        <tr height="25">
                                                            <td>
                                                                <label>Instituci&oacute;n: <span style="color:#F00"><b>*</b></span></label>
                                                            </td>
                                                            <td colspan="11">
                                                                <select id="cmbInstitucion" name="cmbInstitucion" style="max-width:700px;min-width:300px" val="obl" campo="Instituci&oacute;n" >
                                                                    <option value="-1">Seleccione</option>
                                                                    <?php
                                                                        $consulta="SELECT codigoUnidad,unidad FROM 817_organigrama WHERE unidadPadre='0001' and status=1 ORDER BY unidad";
                                                                        $con->generarOpcionesSelect($consulta);
                                                                    ?>
                                                                </select>	
                                                            </td>
                                                            
                                                        </tr>
                                                        <tr height="25">
                                                            <td colspan="2">
                                                            
                                                            </td>
                                                            <td colspan="9">
                                                                <span style="color:#000">¿No encuentra su instituci&oacute;n? Reg&iacute;strela <a href="javascript:agregarInstitucion()"><span style="color:#900"><b>AQU&Iacute;</b></span></a></span>
                                                            </td>
                                                            
                                                        </tr>
                                                        <tr height="25">
                                                            <td>
                                                                <label>Departamento: <span style="color:#F00"><b>*</b></span></label>
                                                            </td>
                                                            <td colspan="11">
                                                                <input type="text" id="txtDepartamento" name="txtDepartamento" style="max-width:700px;min-width:500px" val="obl" campo="Departamento">
                            
                                                            </td>
                                                            
                                                        </tr>
                                                        
                                                         <tr height="10">
                                                            <td colspan="11">
                                                                
                                                            </td>
                                                            
                                                        </tr>
                            
                                                        <tr height="45">
                                                            <td colspan="11" style="vertical-align:middle; background:url(../principalPortal/images/field_bg2.png)">
                                                                <b><label style="font-size:15px; color:#000">Direcci&oacute;n de correspondencia:</label></b>
                                                            </td>
                                                            
                                                        </tr>
                                                        <tr height="25">
                                                            <td>
                                                                <label>Calle: <span style="color:#F00"><b>*</b></span></label>
                                                            </td>
                                                            <td>
                                                                <input type="text" maxlength="250"  style="width:180px" id='txtCalle' name="txtCalle" val='obl' campo='Calle' />
                                                            </td>
                                                            <td >
                                                            </td>
                                                            <td>
                                                                <label>No. Int.:</label>
                                                            </td>
                                                            <td>
                                                                <input type="text" maxlength="100"  style="width:110px" id='txtNoInt' name="txtNoInt" val='' campo='No. Int' />
                                                            </td>
                                                            <td >
                                                            </td>
                                                            <td>
                                                                <label>No. Ext.:</label>
                                                            </td>
                                                            <td>
                                                                <input type="text" maxlength="100"  style="width:110px" id='txtNoExt' name="txtNoExt" val='' campo='No. Ext' />
                                                            </td>
                                                        </tr>
                                                        <tr height="25">
                                                            <td>
                                                                <label>Colonia: <span style="color:#F00"><b>*</b></span></label>
                                                            </td>
                                                            <td>
                                                                <input type="text" maxlength="250"  style="width:180px" id='txtColonia' name="txtColonia" val='obl' campo='Colonia' />
                                                            </td>
                                                            <td >
                                                            </td>
                                                            <td>
                                                                <label>CP: <span style="color:#F00"><b>*</b></span></label>
                                                            </td>
                                                            <td>
                                                                <input type="text" maxlength="70"  style="width:110px" id='txtCP' val='obl' campo='CP' name="txtCP" onkeypress="return soloNumero(event,false,false,this)" />
                                                            </td>
                                                            <td >
                                                            </td>
                                                            <td>
                                                                <label>País: <span style="color:#F00"><b>*</b></span></label>
                                                            </td>
                                                            <td>
                                                                <select id="cmbPais" name="cmbPais" onChange="selPais(this)">
                                                                <?php
                                                                    $consulta="SELECT idPais,nombre FROM 238_paises ORDER BY nombre";
                                                                    $con->generarOpcionesSelect($consulta,146);
                                                                    
                                                                ?>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr height="25">
                                                            <td>
                                                                <label>Estado/Provicia: <span style="color:#F00"><b>*</b></span></label>
                                                            </td>
                                                            <td>
                                                                <select id="cmbEstado" name="cmbEstado" style="display:">
                                                                <option value="-1">Seleccione</option>
                                                                <?php
                                                                    $consulta="SELECT cveEstado,estado FROM 820_estados ORDER BY estado";
                                                                    $con->generarOpcionesSelect($consulta);
                                                                    
                                                                ?>
                                                                </select>
                                                                <input type="text" id="txtEstado" name="txtEstado" style="width:160px;display:none">
                                                            </td>
                                                            <td >
                                                            </td>
                                                            <td>
                                                                <label>Municipio/Delegaci&oacute;n: <span style="color:#F00"><b>*</b></span></label>
                                                            </td>
                                                            <td>
                                                                 <input type="text" maxlength="250"  style="width:160px" id='txtMunicipio' name="txtMunicipio" val='' campo='Municipio/Delegaci&oacute;n' />
                                                            </td>
                                                            <td >
                                                            </td>
                                                            <td>
                                                                
                                                            </td>
                                                            <td>
                                                                
                                                            </td>
                                                        </tr>
                                                         <tr height="10">
                                                            <td colspan="11">
                                                                
                                                            </td>
                                                            
                                                        </tr>
                                                        <tr height="45">
                                                            <td colspan="11" style="vertical-align:middle; background:url(../principalPortal/images/field_bg2.png)">
                                                                <b><label style="font-size:15px; color:#000">Datos de contacto:</label></b>
                                                            </td>
                                                            
                                                        </tr>
                                                        <tr height="25">
                                                            <td colspan="11">
                                                                <table width="100%">
                                                                    <tr height="25">
                                                                        <td>
                                                                            <label>E-mail de contacto:</label><span style="color:#F00"><b>*</b></span>&nbsp;
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" maxlength="50" style="width:200px" id='txtMail' name="txtMail" val='obl' campo='E-mail de contacto' />
                                                                        </td>
                                                                        <td >
                                                                        </td>
                                                                        <td>
                                                                            <label>Confirme E-mail:</label>
                                                                         </td>
                                                                         <td>
                                                                            <input type="text" maxlength="50" style="width:200px" id='txtMail2' val='' campo='' />
                                                                        </td>
                                                                        
                                                                    </tr>
                                                                    
                                                                    
                                                             
                                                                    <tr height="25">
                                                                        <td>
                                                                            <label>E-mail de contacto alterno (opcional):</label><span style="color:#F00"><b></b></span>&nbsp;
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" maxlength="50" style="width:200px" id='txtMailAlterno' val='' campo='' />
                                                                        </td>
                                                                        <td >
                                                                        </td>
                                                                        <td>
                                                                            
                                                                         </td>
                                                                         <td>
                                                                            
                                                                        </td>
                                                                        
                                                                    </tr>
                                                                    <tr height="25">
                                                                    	<td valign="top">
                                                                        	<label>Tel&eacute;fono de contacto:</label>&nbsp;
                                                                        </td>
                                                                        <td colspan="4">
                                                                        	<table>
                                                                            	<tr height="25">
                                                                                	<td width="110">
                                                                                        <label>Tipo de tel&eacute;fono: <span style="color:#F00"><b>*</b></span></label>
                                                                                    </td>
                                                                                    <td>
                                                                                        <select id="cmbTipotelefono" name="cmbTipotelefono" val="obl" campo="Tipo de tel&eacute;fono">
                                                                                        <option value="-1">Seleccione</option>
                                                                                        <option value="0">Fijo</option>
                                                                                        <option value="1">M&oacute;vil (Celular)</option>
                                                                                        </select>
                                                                                    </td>
                                                                                    <td width="15" >
                                                                                    </td>
                                                                                    <td width="50">
                                                                                        <label>Lada:</label>
                                                                                    </td>
                                                                                    <td>
                                                                                        <input type="text" maxlength="250"  style="width:50px" id='txtLada' name="txtLada" val='' campo='Lada' onkeypress="return soloNumero(event,false,false,this)" />
                                                                                    </td>
                                                                                    <td width="15" >
                                                                                    </td>
                                                                                    <td width="80">
                                                                                        <label>Tel&eacute;fono:<span style="color:#F00"><b>*</b></span></label>
                                                                                    </td>
                                                                                    <td>
                                                                                        <input type="text" maxlength="100"  style="width:90px" id='txtTelefono' name="txtTelefono" val='obl' campo='Tel&eacute;fono' onkeypress="return soloNumero(event,false,false,this)" />
                                                                                    </td>
                                                                                    <td width="15" >
                                                                                    </td>
                                                                                    <td width="80">
                                                                                        <label>Extensi&oacute;n:</label>
                                                                                    </td>
                                                                                    <td>
                                                                                        <input type="text" maxlength="100"  style="width:60px" id='txtExtension' name="txtExtension" val='' campo='Extensi&oacute;n' onkeypress="return soloNumero(event,false,false,this)" />
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        
                                                        
                                                            
                                                        </tr>
                                                        <tr height="10">
                                                            <td colspan="11">
                                                                
                                                            </td>
                                                            
                                                        </tr>
                                                        <tr height="45">
                                                            <td colspan="11" style="vertical-align:middle; background:url(../principalPortal/images/field_bg2.png)">
                                                                <b><label style="font-size:15px; color:#000">Cuenta de acceso:</label></b>
                                                            </td>
                                                            
                                                        </tr>
                                                        <tr height="25">
                                                            <td>
                                                                <label>Login:</label>
                                                            </td>
                                                            <td>
                                                                <span style="color:#000">(Corresponde al e-mail de contacto)</span>
                                                            </td>
                                                            <td >
                                                            </td>
                                                            <td>
                            
                                                            </td>
                                                            <td>
                                                            </td>
                                                            <td >
                                                            </td>
                                                            <td>
                                                                
                                                            </td>
                                                            <td>
                                                                
                                                            </td>
                                                        </tr>
                                                        <tr height="25">
                                                            <td>
                                                                <label>Contrase&ntilde;a: <span style="color:#F00"><b>*</b></span></label>
                                                            </td>
                                                            <td>
                                                                <input type="password" maxlength="250"  style="width:180px" id='txtContrasena' name="txtContrasena" val='obl' campo='Contrase&ntilde;a' />
                                                            </td>
                                                            <td >
                                                            </td>
                                                            <td>
                                                                <label>Confirme contrase&ntilde;a:</label>
                                                            </td>
                                                            <td>
                                                                <input type="password" maxlength="250"  style="width:180px" id='txtContrasena2' val='' />
                                                            </td>
                                                            <td >
                                                            </td>
                                                            <td>
                                                                
                                                            </td>
                                                            <td>
                                                                
                                                            </td>
                                                        </tr>
                                                        <tr height="25">
                                                            <td colspan="8" align="center"><br>
                                                            <table width="100%">
                                                                <tr>
                            										<td align="left"><div class="but mar5 floatl"><input style="width:80px" type="button" onClick="regresarLogin()" name="" id="" value="Regresar" class="botonAccion" /><div class="clearl"></div></div></td>
                                                                    <td align="right"><div class="but mar5 floatl"><input style="width:80px" type="button" onClick="registrarCuenta()" name="btnAgregarAutor" id="btnAgregarAutor" value="Registrarse" class="botonAccion" /><div class="clearl"></div></div></td>
                                                                </tr>
                                                            </table>
                                                            
                                                            
                                                            
                                                            
                                                            </td>
                                                        </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                                </table>
                                                </form>
                                        
                                        
                                        </td>
                                        <td id='pRecuperarcontrasena' style="display:none">
                                        	<div id="pass_1">
                                            <h1 style="font-size:15px;">Ingrese la dirección de e-mail con la cual se registr&oacute;</h1>
                                            <p>Por favor, ingrese su dirección de correo electr&oacute;nico, de esta forma recibir&aacute; un email con sus datos de acceso</p>
                                            <br>
                                            <form action="forms/recuperarclave">
                                                <div id="errormsg" class="errormsg"></div>
                                                <label>Email:</label>&nbsp;
                                                <input type="email" id="email"  style="width:250px" />
                                                <div class="clear"></div><br>
                                                <table width="100%">
                                                	<tr>
                                                    	<td align="left"><div class="but mar5 floatl"><input style="width:80px" type="button" onClick="regresarLogin()" name="" id="" value="Regresar" class="botonAccion" /><div class="clearl"></div></div></td>
                                                        
                                                        <td align="right">
                                                        	<div class="but mar5 floatl"><input style="width:160px" type="button" name="login" value="Enviar datos de acceso" class="botonAccion" onClick="recuperarDatosAcceso()" /> <div class="clearl"></div></div>
                                                        </td>
                                                    </tr>
                                                </table>
                                                
                                            </form>
                                            </div>
                                            <div id="pass_2" style="display:none">
                                            <h1>Email enviado</h1>
                                            <p>Por favor, revisa tu bandeja de entrada para recuperar tu contraseña.</p>
                                            </div>
                                        </td>
                                        
                                    </tr>
                                </table>
                                
                                
                                 </p>
                            </div>
                        </div>
                    </div>
                    
                </div>




            </div>
        </div>
        
        

    </section>

    <!--========================================================
                              FOOTER
    =========================================================-->
    <footer id="footer page2" class="footer page2">
        <div class="container">
            <div class="row">
                
                
            </div>

            <p class="copyright wow fadeInUp" data-wow-delay="0.2s">
                Latis &copy;
            <span id="copyright-year"></span></p>
        </div>

    </footer>
</div>
<script src="js/script.js"></script>
</body>
</html>
