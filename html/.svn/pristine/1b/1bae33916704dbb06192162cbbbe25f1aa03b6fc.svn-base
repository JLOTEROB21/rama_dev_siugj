<?php 
include("conexionBD.php"); 
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>CENSIDA</title>
    <meta charset="utf-8">
    
    <link rel="icon" href="images/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="../Scripts/ext/resources/css/ext-all.css.cgz"/>
    <link rel="stylesheet" href="css/grid.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="../Scripts/opentip/opentip.css" media="screen" />
	
	<script type="text/javascript" src="../Scripts/ext/adapter/ext/ext-base.js.jgz"></script>
    <script type="text/javascript" src="../Scripts/ext/ext-all.js.jgz"></script>
    <script type="text/javascript" src="../Scripts/funcionesAjax.js.jgz"></script>
    <script type="text/javascript" src="../Scripts/funcionesUtiles.js.php"></script>   
    <script type="text/javascript" src="../Scripts/funcionesValidacion.js"></script>
    <script type="text/javascript" src="../Scripts/ext/idioma/ext-lang-es.js"></script>
    <script type="text/javascript" src="../principalPortal/Scripts/accesoSmsp.js.php"></script>  

<style>
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
</style>
</head>

<body>
    <table width="100%">
        <tr>
            <td style="text-align:center;" id="tblRegistro">
                <div>
                    <form id="frmEnvio">
                    
                    <table >
                    <tr>
                    	<td align="right">
                        	<b><label style="font-size:22px; color:#000">Actualizar datos de registro</label></b>
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
                            <tr>
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
                                <td width="125">
                                    <label>Apellido Paterno:</label><span style="color:#F00"><b>*</b></span>&nbsp;
                                </td>
                                <td>
                                    <input type="text" name="txtApPaterno" id="txtApPaterno" maxlength="40"  style="width:140px" val="obl" campo="Apellido Paterno" />
                                </td>
                                <td width="10">
                                </td>
                                <td  width="115">
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
											$consulta="SELECT codigoUnidad,unidad FROM 817_organigrama WHERE unidadPadre='0001' ORDER BY unidad";
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
                            <tr>
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
                            <tr>
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
                            <tr>
                            	<td>
                                    <label>Estado/Provicia: <span style="color:#F00"><b>*</b></span></label>
                                </td>
                                <td>
                                    <select id="cmbEstado" name="cmbEstado" style="display:none">
                                    <option value="-1">Seleccione</option>
                                    <?php
										$consulta="SELECT cveEstado,estado FROM 820_estados ORDER BY estado";
										$con->generarOpcionesSelect($consulta);
										
									?>
                                    </select>
                                    <input type="text" id="txtEstado" name="txtEstado" style="width:180px">
                                </td>
                                <td >
                                </td>
                                <td>
                                    <label>Municipio: <span style="color:#F00"><b>*</b></span></label>
                                </td>
                                <td>
                                     <input type="text" maxlength="250"  style="width:180px" id='txtMunicipio' name="txtMunicipio" val='' campo='Municipio' />
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
                            <tr>
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
                            <tr>
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
                            <tr>
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

                                        <td align="right"><div class="but mar5 floatl"><input style="width:80px" type="button" onClick="registrarCuenta()" name="btnAgregarAutor" id="btnAgregarAutor" value="Actualizar" class="botonAccion" /><div class="clearl"></div></div></td>
                                    </tr>
                                </table>
                                
                                
                                
                                
                                </td>
                            </tr>
                            </table>
                    	</td>
                    </tr>
                    </table>
                    </form>
                    <br>
                     
                </div>
                
            
            </td>
        </tr>
    </table>
</body>
</html>
