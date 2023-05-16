<?php session_start();
	include("conexionBD.php"); 
	include("funcGenerales.php");
	$bandera =$_POST["banderaGuardar"];
	if(isset($_POST["banderaAccion"]))
		$accion =$_POST["banderaAccion"];
	$idUsuario=$_POST["idUsuario"];
	$reenviar=false;
	$ocultarCuerpo=false;
	$urlReenvio="intermediaMostrar.php";
	switch($bandera)
	{
		case "nIdentificaActualizaUsuario":
			actualizarDatosUsuario();
		break;
		
	}	
	
	
	
	function actualizarDatosUsuario()
	{
		global $considerarFichaMedica;
		global $reenviar;
		global $idUsuario;
		global $con;
		global $urlReenvio;
		global $versionLatis;
		$Nombre=isset($_POST['Nombre'])?$_POST['Nombre']:'-1984';
		$Apat=isset($_POST['Apat'])?$_POST['Apat']:'-1984';
		$Amat=isset($_POST['Amat'])?$_POST['Amat']:'-1984';
		$tipoIdentificacion=isset($_POST['tipoIdentificacion'])?$_POST['tipoIdentificacion']:'-1984';
		$noIdentificacion=isset($_POST['noIdentificacion'])?$_POST['noIdentificacion']:'-1984';
		$FExpedicion=isset($_POST['FExpedicion'])?$_POST['FExpedicion']:'-1984';
		
		
		$Prefijo=$_POST['Prefijo'];
		
		$ciuNac=isset($_POST['ciuNac'])?$_POST['ciuNac']:"";
		$estNac=isset($_POST['estNac'])?$_POST['estNac']:"";
		$paisNac=isset($_POST['paisNac'])?$_POST['paisNac']:"";
		
		$Nacionalidad=$_POST['nacionalidad'];
		$FNacimiento=$_POST['FNacimiento'];
		$cvuConacyt="";
		if(isset($_POST['cvuConacyt']))
			$cvuConacyt=$_POST['cvuConacyt'];
		if($FNacimiento=="")
			$FNacimiento="NULL";
		else
			$FNacimiento="'".cambiaraFechaMysql($FNacimiento)."'";	
		$cmbGenero=$_POST['cmbGenero'];
		$RFC=isset($_POST['RFC'])?$_POST['RFC']:"";
		$CURP=isset($_POST['CURP'])?$_POST['CURP']:"";
		$IMSS=isset($_POST['IMSS'])?$_POST['IMSS']:"";
		
		$grupoEtnico=$_POST["grupoEtnico"];
		$discapacidad=$_POST["discapacidad"];
		$validado=isset($_POST["validado"])?$_POST["validado"]:"0";
		$esCambioDatosUsrPrimeraVez=isset($_POST["cambioDatosUsrPrimeraVez"])?true:false;
		//Direcciones
		$Calle=$_POST['direccion'];
		$Numero=isset($_POST['Numero'])?$_POST['Numero']:"";
		$Colonia=$_POST['colonia'];
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
					$consulta[$x]="insert into 804_telefonos(codArea,Numero,Extension,Tipo,Tipo2,idUsuario,verificado) values('".
									$datosTel[0]."','".$datosTel[1]."','".$datosTel[2]."',0,".$datosTel[3].",".$Id.",".$datosTel[4].")";
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
					if(!(isset($datosMail[1])))
					{
						$datosMail[1]=1;
						$datosMail[2]=1;
					}
					$consulta[$x]="insert into 805_mails(Mail,Tipo,Notificacion,idUsuario) values('".$datosMail[0]."',".$datosMail[1].",".$datosMail[2].",".$Id.")";
					$x++;
					
				}
			}
				
			
			$consulta[$x]="UPDATE 802_identifica SET Prefijo='".cv($Prefijo)."',ciudadNacimiento='".cv($ciuNac)."',
					estadoNacimiento='".cv($estNac)."',paisNacimiento='".cv($paisNac)."',Nacionalidad='".cv($Nacionalidad)."',RFC='".cv($RFC)."',
					fechaNacimiento=".$FNacimiento.",Genero=".cv($cmbGenero).",CURP='".cv($CURP)."',IMSS='".cv($IMSS).
					"',Actualizado=1,cvuConacyt='".cv($cvuConacyt)."',grupoEtnico=".($grupoEtnico==""?"NULL":$grupoEtnico).",discapacidad=".($discapacidad==""?"NULL":$discapacidad).
					",datosValidados=".$validado;
			
			if($Nombre!=-1984)
			{
				$consulta[$x].=",Nom='".cv($Nombre)."',Paterno='".cv($Apat)."',Materno='".cv($Amat)."',Nombre='".cv($Nombres).
							"',tipoIdentificacion=".$tipoIdentificacion.",noIdentificacion='".cv($noIdentificacion).
							"',fechaExpedicionDocumento=".($FExpedicion==""?"NULL":"'".cambiaraFechaMysql($FExpedicion)."'");
			}
			
			$consulta[$x].=" WHERE idUsuario=".$Id;
			
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
			if($esCambioDatosUsrPrimeraVez)
			{
				$consulta[$x]="UPDATE 800_usuarios SET cambiarDatosUsr=0 WHERE idUsuario=".$Id;
				$x++;
			}
			
			$consulta[$x]="UPDATE 800_usuarios SET PASSWORD=HEX(AES_ENCRYPT('".cv($_POST["Contrasena"])."', '".bD($versionLatis).
							"')) WHERE idUsuario=".$Id;
			$x++;
			$consulta[$x]="commit";
			
			if($con->ejecutarBloque($consulta))
			{	
				if($esCambioDatosUsrPrimeraVez)
				{
					$urlReenvio="../principalPortal/inicio.php";
					$_SESSION["statusCuenta"]=0;
				}
				else
					$urlReenvio="../cuentasUsuario/nUsuariosIntermedia.php";
				$reenviar=true;
				
				
			}
		}
	}
	
	
?>
<?php

if (!$ocultarCuerpo)
{
	?>
<body>
	<form method="post" action="<?php echo $urlReenvio?>" id="frmEnvio">
    	<input type="hidden" name="idUsuario" value="<?php echo $idUsuario?>" />
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