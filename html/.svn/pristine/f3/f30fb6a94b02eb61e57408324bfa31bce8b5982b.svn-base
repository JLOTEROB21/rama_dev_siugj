<?php
include("conexionBD.php"); 

	$funcion =$_POST["funcion"];
	switch($funcion)
	{
		case 1:
			guardarDatos($con);
		break;
		case 2:
			cargaCombo($con);
		break;
	}	
	
	function guardarDatos($con)
	{
		$Id=$_POST["objDatos"];
		$obj=json_decode($Id);
		//Personales
		$con->ejecutarConsulta("begin");
		$fecha = time(); 
		$fecha=date('Y/m/d',$fecha);
		
		$ano=substr($obj->FNacimiento,6,4);
		$mes=substr($obj->FNacimiento,3,2);
		$dia=substr($obj->FNacimiento,0,2);// 12/12/2009
		$Fnac=$ano."-".$mes."-".$dia;
		$nombreC=trim($obj->Nombre.' '.$obj->Apat.' '.$obj->Amat);
		$per="UPDATE 802_identifica SET Paterno='".cv($obj->Apat)."',Materno='".cv($obj->Amat)."',Nom='";
		$per.=cv($obj->Nombre)."',Nombre='".cv($nombreC)."',fechaNacimiento='".$Fnac."',Genero=".$obj->cmbGenero.",CURP='".cv($obj->CURP)."' ";
		$per.=" WHERE idUsuario=".$obj->IdAlumno;
		$con->ejecutarConsulta($per);
		
		
		
		$per1="UPDATE 4118_alumnos SET IdPrograma=".$obj->cmbPrograma.",Grado=".$obj->cmbGrado;
		$per1.=" WHERE IdAlumno=".$obj->IdAlumno;
		$con->ejecutarConsulta($per1);
		//echo $per1;exit;
		
		$sol="UPDATE 4131_solicitudDatos SET Actualizado=1, FechaActualizacion='".$fecha."' where IdAlumno=".$obj->IdAlumno;
		$con->ejecutarConsulta($sol);
		if($con->ejecutarConsulta("commit"))
		{
			
			$consulta="select Nombre from 802_identifica where idUsuario=".$obj->IdAlumno;
			$nombreHijo=$con->obtenerValor($consulta);
			$consulta="select idUsuario from 4131_solicitudDatos where IdAlumno=".$obj->IdAlumno;
			$idUsuario=$con->obtenerValor($consulta);
			$consulta="select Nombre from 802_identifica where idUsuario=".$idUsuario;
			$nombrePadre=$con->obtenerValor($consulta);
			$consulta="select Mail form 805_mails where idUsuario=".$idUsuario;
			$mail=$con->obtenerValor($consulta);
			$d=$mail;
			$a="Su solicitud ha sido atendida";
			$msg="<html>";
			$msg=$msg."Estimado sr(a). <b>".$nombrePadre."</b>:</br><br/><br/>";
			$msg=$msg."Por este medio le notificamos, que su solicitud de cambio de datos para su hijo(a): <b> ".$nombreHijo."</b> ha sido atendida.";
			$msg.="<center>atte.</center><br>";
			$msg.="<center>Portal CLH</center>";
			$msg=$msg."</html>";
			enviarMail($d,$a,$msg);
			
			
			echo "1|".$per;
		}
	}
	
	function cargaCombo($con)
	{
		$arrObj="";
		$arrObj1="";
		$datos=$_POST["objDatos"];
		$sql="SELECT cat_Grados.IdGrado,Grado FROM cat_Grados,cat_Programas, vs_ProgGrados
		WHERE cat_Grados.IdGrado=vs_ProgGrados.IdGrado
		and cat_Programas.IdPrograma=vs_ProgGrados.IdPrograma
		and cat_Programas.IdPrograma=".$datos;
		
		$sql1="SELECT cat_Grupos.idRol,Grupo FROM cat_Grupos,cat_Programas
		WHERE cat_Grupos.IdPrograma=cat_Programas.IdPrograma
		and cat_Programas.IdPrograma=".$datos;
		
		
		$result = $con->obtenerFilas($sql);
		while ( $row = mysql_fetch_row ( $result ) )
		{
			$obj='{"IdGrado":"'.$row[0].'","Grado":"'.$row[1].'º"}';
			if($arrObj=="")
				$arrObj=$obj;
			else
				$arrObj.=",".$obj;
		}
		
		$result1 = $con->obtenerFilas($sql1);
		while ( $row1 = mysql_fetch_row ( $result1 ) )
		{
			$obj1='{"idRol":"'.$row1[0].'","Grupo":"'.$row1[1].'"}';
			if($arrObj1=="")
				$arrObj1=$obj1;
			else
				$arrObj1.=",".$obj1;
		}
		
		echo utf8_decode('1|['.$arrObj.']|['.$arrObj1.']');
	}
	
	function enviarMail($destinatario,$asunto,$mensage)
	{
		$headers = "MIME-Version: 1.0\r \n"; 
		$headers .= "Content-type: text/html; charset=utf-8\r \n"; 
		$headers .= "From: clh@hayas.edu.mx\r \n"; 
		$headers .= "X-Priority: 3\r \n"; 
		$headers .= "X-MSMail-Priority: High\r \n"; 
		$headers .= "X-Mailer: Just My Server";
		$headers .= "To: ".$destinatario."\r\n";
		mail($destinatario,$asunto,$mensage,$headers);
	  } 
?>