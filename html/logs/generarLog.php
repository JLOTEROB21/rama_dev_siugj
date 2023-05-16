<?php
include("conexionBD.php"); 
$x=0;

$query="begin";
if($con->ejecutarConsultaLog($query))
{
	$query="select * from 8000_logSistema for update";
	$res=$con->obtenerFilas($query,false);
	$fp=fopen("log_".date("d_m_Y").".xml","w");
	$cadArchivo="";
	$bufferDatos="";
	$terminador="";
	fwrite($fp,"<log version='1.0'>");
	while($fila=mysql_fetch_row($res))
	{
		switch($fila[7])
		{
			case "0":
				$tipo="Acceso a pagina";
				$cadArchivo="<accionLog fecha='".date("d/m/Y",strtotime($fila[1]))."' hora='".date("h:i A",strtotime($fila[2]))."' idUsuario='".$fila[3]."' usuario='".obtenerNombreUsuario($fila[3])."' tipo='".$tipo."' idTipo='".$fila[7]."' dirIP='".$fila[8]."'><pagina>".$fila[4]."</pagina><parametros><![CDATA[".$fila[5]."]]></parametros></accionLog>";
			break;
			case "1":
				$tipo="Consulta a BD";
				$cadArchivo="<accionLog fecha='".date("d/m/Y",strtotime($fila[1]))."' hora='".date("h:i A",strtotime($fila[2]))."' idUsuario='".$fila[3]."' usuario='".obtenerNombreUsuario($fila[3])."' tipo='".$tipo."' idTipo='".$fila[7]."' dirIP='".$fila[8]."'><![CDATA[".$fila[6]."]]></accionLog>";
		
			break;
			case "2":
				$tipo="Modificacion sobre BD";
				$cadArchivo="<accionLog fecha='".date("d/m/Y",strtotime($fila[1]))."' hora='".date("h:i A",strtotime($fila[2]))."' idUsuario='".$fila[3]."' usuario='".obtenerNombreUsuario($fila[3])."' tipo='".$tipo."' idTipo='".$fila[7]."' dirIP='".$fila[8]."'><![CDATA[".$fila[6]."]]></accionLog>";
			break;
			case "3":
				$tipo="Inicio Sesion en sistema";
				$cadArchivo="<accionLog fecha='".date("d/m/Y",strtotime($fila[1]))."' hora='".date("h:i A",strtotime($fila[2]))."' idUsuario='".$fila[3]."' usuario='".obtenerNombreUsuario($fila[3])."' tipo='".$tipo."' idTipo='".$fila[7]."' dirIP='".$fila[8]."'><login><![CDATA[".$fila[5]."]]></login></accionLog>";
			break;
			case "4":
				$tipo="Fin de sesion en sistema";
				$cadArchivo="<accionLog fecha='".date("d/m/Y",strtotime($fila[1]))."' hora='".date("h:i A",strtotime($fila[2]))."' idUsuario='".$fila[3]."' usuario='".obtenerNombreUsuario($fila[3])."' tipo='".$tipo."' idTipo='".$fila[7]."' dirIP='".$fila[8]."'><login><![CDATA[".$fila[5]."]]></login></accionLog>";
			break;
			case "5":
				$tipo="Inicio Sesion en sistema fallida";
				$cadArchivo="<accionLog fecha='".date("d/m/Y",strtotime($fila[1]))."' hora='".date("h:i A",strtotime($fila[2]))."' tipo='".$tipo."' idTipo='".$fila[7]."' dirIP='".$fila[8]."'><login><![CDATA[".$fila[5]."]]></login></accionLog>";
			break;
			
		}
		fwrite($fp,$cadArchivo);
	}
	
	
	fwrite($fp,"</log>");
	fclose($fp);
	$consulta[$x]="delete from 8000_logSistema";
	$x++;
	$consulta[$x]="alter table 8000_logSistema AUTO_INCREMENT=1";
	$x++;
	$consulta[$x]="commit";
	$x++;
	$con->ejecutarBloque($consulta);
}

?>
