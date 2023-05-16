<?php session_start();
	include("conexionBD.php"); 
	
	
	if(isset($_POST["parametros"]))
		$parametros=$_POST["parametros"];
	if(isset($_POST["funcion"]))
		$funcion=$_POST["funcion"];
	
	switch($funcion)
	{
		case 1:
			obtenerPeriodosDisponiblesPlugin();
		break;
	}

	function obtenerPeriodosDisponiblesPlugin()
	{
		global $con;
		$idFormulario=$_POST["idFormulario"];
		$idReferencia=$_POST["idReferencia"];
		$considerarPlantel=0;
		$sL=0;
		if(isset($_POST["sL"]))
			$sL=$_POST["sL"];
		
		
		
		$plantel="";
		if(isset($_POST["cPlantel"]))
			$considerarPlantel=$_POST["cPlantel"];
			
		$permitirMultipleSelPeriodo=0;
		if(isset($_POST["pMulSeleccion"]))
			$permitirMultipleSelPeriodo=$_POST["pMulSeleccion"];	
		
		$consulta="SELECT DISTINCT p.id__464_tablaDinamica,p.txtDescripcion FROM 4513_instanciaPlanEstudio i, _464_tablaDinamica p WHERE p.id__464_tablaDinamica=i.idPeriodicidad and p.idEstado=1 ";
		if($considerarPlantel==1)
		{
			
			if($idReferencia==-1)
				$plantel=$_SESSION["codigoInstitucion"];
			else
			{
				$consulta="SELECT codigoInstitucion FROM _".$idFormulario."_tablaDinamica WHERE id__".$idFormulario."_tablaDinamica=".$idReferencia;
				$plantel=$con->obtenerValor($consulta);
			}
			
			$consulta.=" and sede='".$plantel."'";
		}
		$consulta.=" ORDER BY p.txtDescripcion";
		
		$arrRegistros='';
		$res=$con->obtenerFilas($consulta);
		while($fila=mysql_fetch_row($res))
		{
			$arrPeriodos="";	
			$consulta="SELECT id__464_gridPeriodos,nombrePeriodo,prioridad FROM _464_gridPeriodos WHERE idReferencia=".$fila[0]." ORDER BY prioridad";
			$rPeriodo=$con->obtenerFilas($consulta);
			while($fPeriodo=mysql_fetch_row($rPeriodo))
			{
				
				$consulta="SELECT COUNT(*) FROM 3014_pluginPeriodos WHERE idFormulario=".$idFormulario." AND idReferencia=".$idReferencia." AND idPeriodo=".$fPeriodo[0];
				$nReg=$con->obtenerValor($consulta);
				
				$ctlComp="";
				if($permitirMultipleSelPeriodo==1)
				{
					$ctlComp='<input '.(($sL==1)?"disabled=disabled":"").' type=\"checkbox\" name=\"chkPeriodos\" id=\"p_'.$fPeriodo[0].'\" '.(($nReg==1)?"checked=checked":"").'><input type=\"hidden\" name=\"chkPeriodos\" value=\"'.$fPeriodo[0].'\"> ';
				}
				else
				{
					$ctlComp='<input '.(($sL==1)?"disabled=disabled":"").' type=\"checkbox\" name=\"chkPeriodos_'.$fila[0].'\" id=\"p_'.$fPeriodo[0].'\" '.(($nReg==1)?"checked=checked":"").'}\" onclick=\"chkPeriodoSeleccionado(this)\" ><input type=\"hidden\" name=\"chkPeriodos\" value=\"'.$fPeriodo[0].'\"> ';
				}
				
				$oP='{"icon":"../images/s.gif","text":"'.$ctlComp.' ['.$fPeriodo[2].'] '.cv($fPeriodo[1]).'","id":"'.$fPeriodo[0].'",leaf:true}';
				if($arrPeriodos=="")	
					$arrPeriodos=$oP;
				else
					$arrPeriodos.=",".$oP;
			}
			
			$o='{"icon":"../images/s.gif","text":"<b>'.cv($fila[1]).'</b>","id":"'.$fila[0].'",leaf:false,children:['.$arrPeriodos.'],"expanded":true}';
			if($arrRegistros=="")
				$arrRegistros=$o;
			else
				$arrRegistros.=",".$o;
		}
		
		echo "[".$arrRegistros."]";
	}