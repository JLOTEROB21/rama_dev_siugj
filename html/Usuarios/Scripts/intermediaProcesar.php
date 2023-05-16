<?php session_start();

	include_once("conexionBD.php"); 
	include_once("funcGenerales.php");
	$bandera =$_POST["banderaGuardar"];
	if(isset($_POST["banderaAccion"]))
		$accion =$_POST["banderaAccion"];
	$idUsuario=$_POST["idUsuario"];
	$reenviar=false;
	$ocultarCuerpo=false;
	$regresaPagInicio=false;
	$pRedireccion="";
	


	
	if(isset($_POST["pRedireccion"]))
			$pRedireccion=$_POST["pRedireccion"];
	
	if(isset($_POST["regresaPagInicio"]))
		$regresaPagInicio=true;
	switch($bandera)
	{
		case "nIdentifica":
			guardaIdentifica($con,$accion);
		break;
		
		case "nAdscripcion":
			guardaAdscripcion($con,$accion);
		break;
		case "nUsuarios":
			guardaUsuario($con);
		break;
		case "generaLogin":
			generaLogin($con);
		break;
	}	
	
	function guardaUsuario($con)
	{
		
		global $reenviar;
		global $considerarFichaMedica;
		global $Enable_AES_Ecrypt;
		global $versionLatis;
		global $bandera;
		$Enable_AES_Ecrypt=(isset($Enable_AES_Ecrypt)&&($Enable_AES_Ecrypt==true));
		$Id=$_POST['idUsuario'];
		$Login=$_POST['cmbLogin'];
		$Contrasena=$_POST['Contrasena'];
		$baderaRegresar=$_POST["bandera"];
		$adscripcion=$_POST["adscripcion"];
		
		$cambiarDatosUsr=0;
		$cuentaActiva=0;
		
		if(isset($_POST["cambiarDatosUsr"]))
			$cambiarDatosUsr=$_POST["cambiarDatosUsr"];
		
		if(isset($_POST["cuentaActiva"]))
			$cuentaActiva=$_POST["cuentaActiva"];
			
		$vCU=$_POST["vCU"];
		
		$consulta="SELECT * FROM 903_variablesSistema WHERE idVariable=1";
		$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);	

		
		$fechaCambioContrasena="NULL";
		$fechaLimiteCambioContrasena="NULL";
		if($fRegistro["cantidadCambioCrontrasena"]>0)
		{
			$fechaCambioContrasena=date("Y-m-d",strtotime("+".($fRegistro["cantidadCambioCrontrasena"]." ".($fRegistro["periodoCambioCrontrasena"]==0?" days":"months")),strtotime($fechaActualiza)));
			
			
			
			if($fRegistro["cantidadperiodoContrasenaDeshabilita"]>0)
			{
				$fechaLimiteCambioContrasena=	date("Y-m-d",strtotime("+".($fRegistro["cantidadperiodoContrasenaDeshabilita"]." ".
									($fRegistro["periodoContrasenaDeshabilita"]==0?" days":"months")),strtotime($fechaCambioContrasena)));
			}
			
			$fechaCambioContrasena="'".$fechaCambioContrasena."'";
			$fechaLimiteCambioContrasena="'".$fechaLimiteCambioContrasena."'";
			
		}
		
		
		
		$FechaActualiza=date('Y-m-d');
		$x=0;
		$consulta[$x]="begin";
		$x++;
		
		$query="SELECT * FROM 800_usuarios WHERE idUsuario=".$Id;
		$fUsuario=$con->obtenerPrimeraFila($query);
		if($fUsuario)
		{
			if($Enable_AES_Ecrypt)
				$consulta[$x]="UPDATE 800_usuarios SET Login='".cv($Login)."',Password=HEX(AES_ENCRYPT('".$Contrasena."', '".bD($versionLatis).
							"')),cambiarDatosUsr=".$cambiarDatosUsr.",cuentaActiva=".$cuentaActiva.",FechaActualiza='".$FechaActualiza.
							"',FechaCambio='".$FechaActualiza."',fechaCambioContrasena=".$fechaCambioContrasena.
							",fechaLimiteCambioContrasena=".$fechaLimiteCambioContrasena." WHERE idUsuario=".$Id;
			else
				$consulta[$x]="UPDATE 800_usuarios SET Login='".cv($Login)."',Password='".cv($Contrasena).
							"',cambiarDatosUsr=".$cambiarDatosUsr.",cuentaActiva=".$cuentaActiva.",FechaActualiza='".$FechaActualiza.
							"',FechaCambio='".$FechaActualiza."',fechaCambioContrasena=".$fechaCambioContrasena.
							",fechaLimiteCambioContrasena=".$fechaLimiteCambioContrasena." WHERE idUsuario=".$Id;
		}
		else
		{
			$query="SELECT Nombre FROM 802_identifica WHERE idUsuario=".$Id;
			$nombre=$con->obtenerValor($query);
			if($Enable_AES_Ecrypt)
				$consulta[$x]="insert into 800_usuarios(idUsuario,Login,PASSWORD,STATUS,Nombre,fechaCreacion,paso,
							idIdioma,cuentaActiva,cambiarDatosUsr,registradoEnPlantel,fechaCambioContrasena,fechaLimiteCambioContrasena)
							VALUES(".$Id.",'".cv($Login)."',HEX(AES_ENCRYPT('".$Contrasena."', '".bD($versionLatis)."')),1,'".cv($nombre)."','".
							date("Y-m-d H:i:s")."',1,1,".$cuentaActiva.",".$cambiarDatosUsr.",0,".$fechaCambioContrasena.",".$fechaLimiteCambioContrasena.")";
							
	
			else
				$consulta[$x]="insert into 800_usuarios(idUsuario,Login,PASSWORD,STATUS,Nombre,fechaCreacion,paso,
							idIdioma,cuentaActiva,cambiarDatosUsr,registradoEnPlantel,fechaCambioContrasena,fechaLimiteCambioContrasena)
							VALUES(".$Id.",'".cv($Login)."','".cv($Contrasena)."',1,'".cv($nombre)."','".
							date("Y-m-d H:i:s")."',1,1,".$cuentaActiva.",".$cambiarDatosUsr.",0,".$fechaCambioContrasena.",".$fechaLimiteCambioContrasena.")";
		}
		$x++;
		
		if($vCU==0)
		{
			$consulta[$x]="DELETE FROM 807_usuariosVSRoles WHERE idUsuario=".$Id;
			$x++;
			$listadoRoles=$_POST["listadoRoles"];
			
			if($listadoRoles!="")
			{
				$arrRoles=explode(',',$listadoRoles);
				$cont=sizeof($arrRoles);
				for($y=0;$y<$cont;$y++)
				{
					$datosRol=explode('_',$arrRoles[$y]);
					$rol="INSERT INTO 807_usuariosVSRoles (idRol,idUsuario,idExtensionRol,codigoRol)VALUES(".$datosRol[0].",".cv($Id).",".$datosRol[1].",'".$arrRoles[$y]."')";
					$consulta[$x]=$rol;
					$x++;
					if($arrRoles[$y]=='7_0')
					{
						if($considerarFichaMedica)
						{
							$query="select IdAlumno from 4120_fichaMedica where IdAlumno=".$Id;
							$res=$con->obtenerValor($query);
							if($res=="")
							{
								$consulta[$x]="insert into 4120_fichaMedica(IdAlumno,Llenada) values(".$Id.",0)";
								$x++;
								
							}
						}
					}
				}
			}
			
			$consulta[$x]="update 801_adscripcion SET Institucion='".$adscripcion."' WHERE idUsuario=".$Id;
			$x++;
		
		}
		$consulta[$x]="commit";
		$x++;
		
		if($con->ejecutarBloque($consulta))
		{
			if($baderaRegresar==1)
			{
			?>
			
				
				<script>
					 window.parent.regresarGuardar('<?php echo $bandera?>');
				</script>
			<?php
			}
		}
	}
	
	function generaLogin($con)
	{
		global $con;
		$consulta="SELECT lower(Paterno),lower(Materno),lower(Nom) FROM 802_identifica WHERE idUsuario=".$_POST['idUsuario'];
		$fila=$con->obtenerRegistros($consulta);
		$paterno=$fila[0];
		$materno=$fila[1];
		$nombre=$fila[2];
		$arrOpciones[0]=(algLogin3($fila));
		$arrOpciones[1]=(algLogin1($fila));
		$arrOpciones[2]=(algLogin2($fila));
		$ctArr=sizeof($arrOpciones);
		$arrOpc="";
		for($x=0;$x<$ctArr;$x++)
		{
			if($arrOpc=="")
				$arrOpc=$arrOpciones[$x];
			else
				$arrOpc.="|".$arrOpciones[$x];
		}
		
		//Agregar al combo el login actual
		$consulta="SELECT Login FROM 800_usuarios WHERE idUsuario=".$_POST['idUsuario'];
		$log=$con->obtenerRegistros($consulta);
		$loginOK=$log[0];
		if($loginOK=="NULL")
			$loginOK="Seleccione";
		$arrOpc.="|".($loginOK);
		echo (quitarAcentos($arrOpc));
		global $ocultarCuerpo;
		$ocultarCuerpo=true;
	}
	
	function existeLogin($login)
	{
		global $con;
		global $conexion;
		$cond2="";
		if(isset($_POST["idUsuario"]))
			$cond2=" and idUsuario<>".$_POST["idUsuario"];
		$consulta="SELECT Login FROM 800_usuarios WHERE Login='".$login."'".$cond2;
		$ct=$con->contarRegistros($consulta);
		if($ct==0)
			return false;
		else
			return true;
	}
	
	function algLogin1($fila)  //Primera y segunda letra del nombre, apellido Paterno y primera letra del apellido materno
	{
		//$aPaterno=obtenerNomMayor(trim(utf8_encode($fila[0])));
		$aPaterno=uEJ(str_replace(' ','',trim(($fila[0]))));
		$aMaterno=uEJ(obtenerNomMayor(trim(($fila[1]))));
		$nombre=uEJ(trim(($fila[2])));
		$iPN=substr(trim($nombre),0,2);
		$iN=$iPN;
		$loginUsado=true;
		$ctN=1;
		$lnombre="";
		while($loginUsado)
		{
			if($ctN<=1)
				$lnombre=substr($aMaterno,0,1);
			else
				$lnombre=substr($aMaterno,0,1).$ctN;
			$login =strtolower($iN);
			$login.=strtolower($aPaterno);
			$login.=strtolower($lnombre);
			$login=str_replace(" ","_",$login);
			if(!existeLogin($login))
				return quitarAcentos(($login));
			$ctN++;
		}
	}
	
	function algLogin2($fila) //Primera letra del nombre, apellido paterno, primera y segunda letra del apellido materno
	{
		//$aPaterno=obtenerNomMayor(trim(utf8_encode($fila[0])));
		$aPaterno=uEJ(str_replace(' ','',trim(($fila[0]))));
		$aMaterno=uEJ(obtenerNomMayor(trim(($fila[1]))));
		$nombre=uEJ(trim(($fila[2])));
		$iPN=substr($nombre,0,1);
		$iN=$iPN;
		$loginUsado=true;
		$ctN=2;
		$lnombre="";
		while($loginUsado)
		{
			if($ctN<=strlen($aMaterno))
				$lnombre=substr($aMaterno,0,$ctN);
			else
				$lnombre=$aMaterno.$ctN;
			$login =strtolower($iN);
			$login.=strtolower($aPaterno);
			$login.=strtolower($lnombre);
			$login=str_replace(" ","_",$login);
			if(!existeLogin($login))
				return quitarAcentos($login);
			$ctN++;
		}
	}
	
	function algLogin3($fila) //Primera letra del nombre, apellido paterno, inicial del apellido materno
	{
		//$aPaterno=obtenerNomMayor(trim(utf8_encode($fila[0])));
		$aPaterno=uEJ(str_replace(' ','',trim(($fila[0]))));
		$aMaterno=uEJ(obtenerNomMayor(trim(($fila[1]))));
		$nombre=uEJ(trim(($fila[2])));
		$iPN=substr($nombre,0,1);
		$iN=$iPN;
		$loginUsado=true;
		$ctN=1;
		$lnombre="";
		while($loginUsado)
		{
			if($ctN<=1)
				$lnombre=substr($aMaterno,0,1);
			else
				$lnombre=substr($aMaterno,0,1).$ctN;
			$login =strtolower($iN);
			$login.=strtolower($aPaterno);
			$login.=strtolower($lnombre);
			$login=str_replace(" ","_",$login);
			if(!existeLogin($login))
			{
				return quitarAcentos(($login));
			}
			$ctN++;
		}
	}
	
	function obtenerNomMayor($apellido)
	{
		$arrNom=explode(' ',$apellido);		
		if(sizeof($arrNom)>1)
		{

			$ctNom=sizeof($arrNom);
			$nomMayor="";
			for($x=0;$x<$ctNom;$x++)
			{
				if(strlen($arrNom[$x])>=strlen($nomMayor))
					$nomMayor=$arrNom[$x];
			}
		}
		else
			$nomMayor=$apellido;
		return $nomMayor;
	}
	
	function guardaAdscripcion($con,$accion)
	{
		global $reenviar;
		global $idUsuario;
		global $externosOrganigrama;
		$Id=$_POST['idUsuario'];
		$idUsuario=$Id;
		
		$query="select Status from 800_usuarios where idUsuario=".$Id;
		$tipoUsuario=$con->obtenerValor($query);
		
		if(($tipoUsuario==5)&&(!$externosOrganigrama))
		{
		
			if(isset($_POST['Dependencia']))
				$Dependencia=$_POST['Dependencia'];
			if(isset($_POST['Institucion']))
				$Institucion=$_POST['Institucion'];
			
			$criterio="puestoAbierto='".cv($_POST['txtPuesto'])."',cod_Puesto='-2',";
			$Calle=$_POST['Calle'];
			$Numero=$_POST['Numero'];
			$Colonia=$_POST['Colonia'];
			$Ciudad=$_POST['Ciudad'];
			$Estado=$_POST['Estado'];
			$Pais=$_POST['Pais'];
			$CP=$_POST['CP'];
			if($CP=="")
				$CP="NULL";
			$x=0;
			$consulta[$x]="begin";
			$x++;
			$consulta[$x]="UPDATE 801_adscripcion SET institucionAbierto='".cv($Institucion)."',Dependencia='".cv($Dependencia)."',".$criterio."cod_Area='',Actualizado=1 WHERE idUsuario=".$Id;
			$x++;
			$consulta[$x]="UPDATE 803_direcciones SET Calle='".cv($Calle)."',Numero='".cv($Numero)."',Colonia='".cv($Colonia)."',Ciudad='".cv($Ciudad)."',
							CP=".cv($CP).",Estado='".cv($Estado)."',Pais='".cv($Pais)."' WHERE Tipo=1 AND idUsuario=".$Id;
			$x++;
		}
		else
		{
			if(isset($_POST['codigoUnidad']))
				$codigoUnidad=$_POST['codigoUnidad'];
			if(isset($_POST['Institucion']))
				$Institucion=$_POST['Institucion'];
			$cmbPuesto=$_POST["cmbPuesto"];
			$x=0;
			$consulta[$x]="begin";
			$x++;
			$consulta[$x]="UPDATE 801_adscripcion SET Institucion='".cv($Institucion)."',codigoUnidad='".$codigoUnidad."',Dependencia='',cod_Area='',cod_Puesto='".$cmbPuesto."',Actualizado=1 WHERE idUsuario=".$Id;
			$x++;
		}
		
		
		$consulta[$x]="delete from 804_telefonos where idUsuario=".$Id." and Tipo=1";
		$x++;
		
		$consulta[$x]="delete from 805_mails where idUsuario=".$Id." and Tipo=1";
		$x++;
		
		$cadTelefono=$_POST["telefonos"];
		$cadCorreos=$_POST["correos"];
		
		if($cadTelefono!="")
		{
			$arrTelefonos=explode(',',$cadTelefono);
			$ct=sizeof($arrTelefonos);
			for($y=0;$y<$ct;$y++)
			{
				$datosTel=explode('_',$arrTelefonos[$y]);
				$consulta[$x]="insert into 804_telefonos(Lada,Numero,Extension,Tipo,Tipo2,idUsuario) values('".$datosTel[0]."','".$datosTel[1]."','".$datosTel[2]."',1,".$datosTel[3].",".$Id.")";
				$x++;
			}
		}
		
		if($cadCorreos!="")
		{
			$arrCorreos=explode(',',$cadCorreos);
			$ct=sizeof($arrCorreos);
			for($y=0;$y<$ct;$y++)
			{
				$datosMail=explode('/',$arrCorreos[$y]);
				$consulta[$x]="insert into 805_mails(Mail,Tipo,Notificacion,idUsuario) values('".$datosMail[0]."',".$datosMail[1].",".$datosMail[2].",".$Id.")";
				$x++;
			}
		}
		
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
			$reenviar=true;
	}//Guarda Asscripcion
	
	function guardaIdentifica($con,$accion)
	{
		global $bandera;
		//Identifica
		//error_reporting(E_ALL ^ E_NOTICE);
		global $considerarFichaMedica;
		global $reenviar;
		global $idUsuario;		

		$baderaRegresar=$_POST["bandera"];
		$Nombre=$_POST['Nombre'];
		$Apat=$_POST['Apat'];
		$Amat=$_POST['Amat'];
		$Prefijo=$_POST['Prefijo'];
		$ciuNac=$_POST['ciuNac'];
		$estNac=$_POST['estNac'];
		$paisNac=$_POST['paisNac'];
		$Nacionalidad=$_POST['Nacionalidad'];
		$FNacimiento=$_POST['FNacimiento'];
		$cvuConacyt="";
		if(isset($_POST['cvuConacyt']))
			$cvuConacyt=$_POST['cvuConacyt'];
		if($FNacimiento=="")
			$FNacimiento="NULL";
		else
			$FNacimiento="'".cambiaraFechaMysql($FNacimiento)."'";	
		$cmbGenero=$_POST['cmbGenero'];
		$RFC=$_POST['RFC'];
		$CURP=$_POST['CURP'];
		$IMSS=$_POST['IMSS'];
		$cmbStatus=$_POST['cmbStatus'];
		//Direcciones
		$Calle=$_POST['Calle'];
		$Numero=$_POST['Numero'];
		$Colonia=$_POST['Colonia'];
		$Ciudad=$_POST['Ciudad'];
		$Estado=$_POST['Estado'];
		$Pais=$_POST['Pais'];
		$CP=$_POST['CP'];
		//Telefonos
		$cadTelefono=$_POST["telefonos"];
		$cadCorreos=$_POST["correos"];
		if($CP=="")
			$CP="NULL";
		$Nombres=$Nombre." ".$Apat." ".$Amat;
		$x=0;
		$query="begin";
		if($con->ejecutarConsulta($query))
		{
			if($accion=="Nuevo")
			{
				$fecha = time(); 
				$fechaActual=date('Y/m/d',$fecha);
				$idUsuario=$con->agregarRegistro("insert into 800_usuarios (Nombre,FechaActualiza,cambiarDatosUsr)VALUES('".cv($Nombres)."','".cv($fechaActual)."',2)");
				$Id=$idUsuario;
				$consulta[$x]="insert into 801_adscripcion (idUsuario,Actualizado,Institucion)VALUES(".cv($Id).",0,'".$_SESSION["codigoInstitucion"]."')";
				$x++;
				$consulta[$x]="insert into 802_identifica (idUsuario)VALUES(".cv($Id).")";
				$x++;
				$consulta[$x]="INSERT INTO 803_direcciones (Tipo,Calle,Numero,Colonia,Ciudad,CP,Estado,Pais,idUsuario)VALUES(0,'".cv($Calle)."',
							'".cv($Numero)."','".cv($Colonia)."','".cv($Ciudad)."',".$CP.",'".cv($Estado)."','".cv($Pais)."',".cv($Id).")";
				$x++;
				$consulta[$x]="INSERT INTO 803_direcciones (Tipo,idUsuario)VALUES(1,".cv($Id).")";
				$x++;
				$consulta[$x]="INSERT INTO 806_fotos (idUsuario)VALUES(".cv($Id).")";
				$x++;
				$consulta[$x]="insert into 807_usuariosVSRoles(idUsuario,idRol,idExtensionRol,codigoRol) values(".$Id.",-1000,0,'-1000_0')";
				$x++;
				
				
				
				if($cadTelefono!="")
				{
					$arrTelefonos=explode(',',$cadTelefono);
					$ct=sizeof($arrTelefonos);
					for($y=0;$y<$ct;$y++)
					{
						$datosTel=explode('_',$arrTelefonos[$y]);
						$consulta[$x]="insert into 804_telefonos(Lada,Numero,Extension,Tipo,Tipo2,idUsuario) values('".$datosTel[0]."','".$datosTel[1]."','".$datosTel[2]."',0,".$datosTel[3].",".$Id.")";
						$x++;
					}
				}
				
				if($cadCorreos!="")
				{
					$arrCorreos=explode(',',$cadCorreos);
					$ct=sizeof($arrCorreos);
					for($y=0;$y<$ct;$y++)
					{
						$datosMail=explode('/',$arrCorreos[$y]);
						$consulta[$x]="insert into 805_mails(Mail,Tipo,Notificacion,idUsuario) values('".$datosMail[0]."',".$datosMail[1].",".$datosMail[2].",".$Id.")";
						$x++;
					}
				}
			}
			else
			{
				$Id="-1";
				if(isset($_POST['idUsuario']))
					$Id=$_POST['idUsuario'];
				
				
				$consulta[$x]="UPDATE 803_direcciones SET Calle='".cv($Calle)."',Numero='".cv($Numero)."',Colonia='".cv($Colonia)."',Ciudad='".cv($Ciudad)."',
						CP=".$CP.",Estado='".cv($Estado)."',Pais='".cv($Pais)."' WHERE Tipo=0 AND idUsuario=".$Id;
				$x++;
				
				$consulta[$x]="delete from 804_telefonos where idUsuario=".$Id." and Tipo=0";
				$x++;
				
				if($cadTelefono!="")
				{
					$arrTelefonos=explode(',',$cadTelefono);
					$ct=sizeof($arrTelefonos);
					for($y=0;$y<$ct;$y++)
					{
						$datosTel=explode('_',$arrTelefonos[$y]);
						$consulta[$x]="insert into 804_telefonos(Lada,Numero,Extension,Tipo,Tipo2,idUsuario) values('".$datosTel[0]."','".$datosTel[1]."','".$datosTel[2]."',0,".$datosTel[3].",".$Id.")";
						$x++;
					}
				}
				
				$consulta[$x]="delete from 805_mails where idUsuario=".$Id." and Tipo=0";
				$x++;
				
				if($cadCorreos!="")
				{
					$arrCorreos=explode(',',$cadCorreos);
					$ct=sizeof($arrCorreos);
					for($y=0;$y<$ct;$y++)
					{
						$datosMail=explode('/',$arrCorreos[$y]);
						$consulta[$x]="insert into 805_mails(Mail,Tipo,Notificacion,idUsuario) values('".$datosMail[0]."',".$datosMail[1].",".$datosMail[2].",".$Id.")";
						$x++;
					}
				}
				
				
			}
			
			$consulta[$x]="UPDATE 802_identifica SET Nom='".cv($Nombre)."',Paterno='".cv($Apat)."',Materno='".cv($Amat)."',Nombre='".cv($Nombres)."',Prefijo='".cv($Prefijo)."',ciudadNacimiento='".cv($ciuNac)."',
					estadoNacimiento='".cv($estNac)."',paisNacimiento='".cv($paisNac)."',Nacionalidad='".cv($Nacionalidad)."',RFC='".cv($RFC)."',
					fechaNacimiento=".$FNacimiento.",Genero=".cv($cmbGenero).",CURP='".cv($CURP)."',IMSS='".cv($IMSS)."',Actualizado=1, Status=".$cmbStatus.",cvuConacyt='".cv($cvuConacyt)."' WHERE idUsuario=".$Id;
							
			$x++;
			if (!empty($_FILES['archivo']['name']))
			{
				$binario_nombre_temporal=$_FILES['archivo']['tmp_name'] ;
				$binario_contenido = addslashes(fread(fopen($binario_nombre_temporal, "rb"), filesize($binario_nombre_temporal)));
				$binario_nombre=$_FILES['archivo']['name'];
				$binario_peso=$_FILES['archivo']['size'];
				$binario_tipo=$_FILES['archivo']['type'];
				$consulta[$x] = "UPDATE 806_fotos SET Binario='".$binario_contenido."', Nombre='".$binario_nombre."', Tamano='".$binario_peso."', Tipo='".$binario_tipo."' WHERE idUsuario=".$Id;
				$x++;
			}
			
			$consulta[$x]="commit";
			
			if($con->ejecutarBloque($consulta))
			{	
				if($baderaRegresar==0)
				{
					if(actualizarDireccionDependencias($Id))
						$reenviar=true;
				}
				else
				{
				?>
                
                	
					<script>
						 window.parent.regresarGuardar('<?php echo $bandera?>');
        			</script>
				<?php
				}
			}
		}
	}
	

	
?>
<?php

if (!$ocultarCuerpo)
{
	
		
		
	?>
<body>

	<form method="post" action="../Usuarios/tblInformacionUsuarios.php" id="frmEnvio">
    	<input type="hidden" name="idUsuario" value="<?php echo $idUsuario?>" />
        <input type="hidden" name="cPagina" value="sFrm=true" />
        
    </form>
   <?php
	
	
		if($reenviar)
		{
	?>
		<script>
    		document.getElementById('frmEnvio').submit();  
        </script>
    <?php 
		}
	?>
</body>
<?php
}
?>