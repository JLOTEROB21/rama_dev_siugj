<?php session_start();
	include("conexionBD.php"); 
	include("funcGenerales.php");
	
	$idUsuario=$_POST["idUsuario"];
	$idProceso=$_POST["idProceso"];
	$reenviar=false;
	$cadenaSetNom="";
		
		$Nombre="";
		if(isset($_POST["Nombre"]))
		{
			$Nombre=$_POST['Nombre'];
			$cadenaSetNom.="Nom='".cv($Nombre)."'";
		}
		$Apat="";
		if(isset($_POST["Apat"]))
		{
			$Apat=$_POST['Apat'];
			$cadenaSetNom.=",Paterno='".cv($Apat)."'";
		}
		$Amat="";
		if(isset($_POST["Amat"]))
		{
			$Amat=$_POST['Amat'];
			$cadenaSetNom.=",Materno='".cv($Amat)."'";
		}
		
		if(isset($_POST["Prefijo"]))
		{
			$Prefijo=$_POST['Prefijo'];
			$cadenaSetNom.=",Prefijo='".cv($Prefijo)."'";
		}
		if(isset($_POST["ciuNac"]))
		{
			$ciuNac=$_POST['ciuNac'];
			$cadenaSetNom.=",ciudadNacimiento='".cv($ciuNac)."'";
		}
		
		
		if(isset($_POST["estNac"]))
		{
			$estNac=$_POST['estNac'];
			$cadenaSetNom.=",estadoNacimiento='".cv($estNac)."'";
		}
		if(isset($_POST["paisNac"]))
		{
			$paisNac=$_POST['paisNac'];
			$cadenaSetNom.=",paisNacimiento='".cv($paisNac)."'";
		}
		if(isset($_POST["Nacionalidad"]))
		{
			$Nacionalidad=$_POST['Nacionalidad'];
			$cadenaSetNom.=",Nacionalidad='".cv($Nacionalidad)."'";
		}
		
		 
		if(isset($_POST["FNacimiento"]))
		{
			$FNacimiento=$_POST['FNacimiento'];
			if($FNacimiento!="")
				$FNacimiento="'".cambiaraFechaMysql($FNacimiento)."'";	
			else
				$FNacimiento="NULL";
			$cadenaSetNom.=",fechaNacimiento=".$FNacimiento."";
		}
		
		
		if(isset($_POST["cvuConacyt"]))
		{
			$cvuConacyt=$_POST["cvuConacyt"];
			$cadenaSetNom.=",cvuConacyt='".cv($cvuConacyt)."'";
		}
		
		if(isset($_POST["cmbGenero"]))
		{
			$cmbGenero=$_POST['cmbGenero'];
			$cadenaSetNom.=",Genero=".cv($cmbGenero)."";
		}
		if(isset($_POST["RFC"]))
		{
			$RFC=$_POST['RFC'];
			$cadenaSetNom.=",RFC='".cv($RFC)."'";
		}
		if(isset($_POST["CURP"]))
		{
			$CURP=$_POST['CURP'];
			$cadenaSetNom.=",CURP='".cv($CURP)."'";
		}
		if(isset($_POST["IMSS"]))
		{
			$IMSS=$_POST['IMSS'];
			$cadenaSetNom.=",IMSS='".cv($IMSS)."'";
		}
		if(isset($_POST["cmbStatus"]))
		{
			$cmbStatus=$_POST['cmbStatus'];
			$cadenaSetNom.=",Status=".$cmbStatus."";
		}
		
		$Calle="";
		if(isset($_POST["Calle"]))
		{
			$Calle=$_POST['Calle'];
		}
		$Numero="";
		if(isset($_POST["Numero"]))
		{
			$Numero=$_POST['Numero'];
		}
		$Colonia="";
		if(isset($_POST["Colonia"]))
		{
			$Colonia=$_POST['Colonia'];
		}
		$Ciudad="";
		if(isset($_POST["Ciudad"]))
		{
			$Ciudad=$_POST['Ciudad'];
		}
		$Estado="";
		if(isset($_POST["Estado"]))
		{
			$Estado=$_POST['Estado'];
		}
		$Pais="";
		if(isset($_POST["Pais"]))
		{
			$Pais=$_POST['Pais'];
		}
		$CP="";
		if(isset($_POST["CP"]))
		{
			$CP=$_POST['CP'];
			if($CP=="")
				$CP="NULL";
		}
		
		if($CP=="")
				$CP="NULL";
		
		$cadTelefono="";
		if(isset($_POST["telefonos"]))
		{
			$cadTelefono=$_POST["telefonos"];
		}
		$cadCorreos="";
		if(isset($_POST["correos"]))
		{
			$cadCorreos=$_POST["correos"];
		}
		
		$Nombres=$Nombre." ".$Apat." ".$Amat;
		$cadenaSetNom.=",Nombre='".cv($Nombres)."'";
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
			
			//$consulta[$x]="UPDATE 802_identifica SET Nom='".cv($Nombre)."',Paterno='".cv($Apat)."',Materno='".cv($Amat)."',Nombre='".cv($Nombres)."',Prefijo='".cv($Prefijo)."',ciudadNacimiento='".cv($ciuNac)."',
//					estadoNacimiento='".cv($estNac)."',paisNacimiento='".cv($paisNac)."',Nacionalidad='".cv($Nacionalidad)."',RFC='".cv($RFC)."',
//					fechaNacimiento=".$FNacimiento.",Genero=".cv($cmbGenero).",CURP='".cv($CURP)."',IMSS='".cv($IMSS)."',Actualizado=1, Status=".$cmbStatus.",cvuConacyt='".cv($cvuConacyt)."' WHERE idUsuario=".$Id;
							
			$consulta[$x]="UPDATE 802_identifica SET ".$cadenaSetNom.",Actualizado=1 WHERE idUsuario=".$Id;
			
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
				$reenviar=true;
				
			}
	?>
	
    <body>
	<form method="post" action="fichaUsuario.php" id="frmEnvio">
    	<input type="hidden" name="idUsuario" value="<?php echo $idUsuario?>" />
        <input type="hidden" name="idProceso" value="<?php echo $idProceso?>" />
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