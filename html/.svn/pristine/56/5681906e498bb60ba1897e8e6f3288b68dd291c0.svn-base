<?php include("sesiones.php");
include("conexionBD.php"); 

ini_set("memory_limit","8000M");
set_time_limit(999000);

$periodoInicial="2019-09-01";
if(isset($_POST["fechaInicio"]))
	$periodoInicial=$_POST["fechaInicio"];

$periodoFinal="2019-09-23";
if(isset($_POST["fechaFin"]))
	$periodoFinal=$_POST["fechaFin"];
	
	
$nFila=2;
$nFilaImputado=2;
$nFilaVictima=2;
$nFilaDelito=2;
$libro=new cExcel("../modulosEspeciales_SGJP/formatos/plantillaIntercambioEstadistica.xlsx",true,"Excel2007");	

$consulta="SELECT s.*,c.idCarpeta,c.unidadGestion,c.fechaCreacion as fechaCreacionCarpeta,s.fechaRecepcionSistema,s.tipoAudiencia,
			s.iFormulario,s.iReferencia,c.idActividad  FROM _46_tablaDinamica s,7006_carpetasAdministrativas c WHERE c.fechaCreacion>='".$periodoInicial.
			"' AND c.fechaCreacion<='".$periodoFinal." 23:59:59' AND	c.idFormulario=46 AND c.tipoCarpetaAdministrativa=1 AND 
			c.idRegistro=s.id__46_tablaDinamica ORDER BY c.carpetaAdministrativa";
$res=$con->obtenerFilas($consulta);
while($fila=mysql_fetch_assoc($res))
{
	$consulta="SELECT id__17_tablaDinamica FROM _17_tablaDinamica WHERE claveUnidad='".$fila["unidadGestion"]."'";
	$idUGJ=$con->obtenerValor($consulta);
	$arrCarpeta=explode("/",$fila["carpetaAdministrativa"]);	
	$arrHoja1=array();	
	$arrHoja1["A"]=$fila["idCarpeta"];
	$arrHoja1["B"]=$idUGJ;
	$arrHoja1["C"]=date("Y-m-d H:i",strtotime($fila["fechaRecepcionSistema"]==""?$fila["fechaCreacionCarpeta"]:$fila["fechaRecepcionSistema"]));
	$arrHoja1["D"]=date("Y-m-d H:i",strtotime($fila["fechaCreacionCarpeta"]));
	$arrHoja1["E"]=$fila["folioCarpetaInvestigacion"];
	$arrHoja1["F"]=$arrCarpeta[1]*1;
	$arrHoja1["G"]=date("Y",strtotime($fila["fechaCreacionCarpeta"]));
	$arrHoja1["H"]=$fila["carpetaAdministrativa"];
	$arrHoja1["I"]=$fila["tipoAudiencia"];
	$incompetencia="NULL";
	if($fila["tipoAudiencia"]==91)
	{
		$consulta="SELECT motivoIncompetencia FROM _554_tablaDinamica WHERE id__554_tablaDinamica=".$fila["iReferencia"];
		$incompetencia=$con->obtenerValor($consulta);
		if($incompetencia=="")
			$incompetencia="NULL";
	}
	$arrHoja1["J"]=$incompetencia;
	
	foreach($arrHoja1 as $columna=>$valor)
	{
		$libro->setValor($columna.$nFila,$arrHoja1[$columna]);
	}
	
	$consulta="SELECT r.idFiguraJuridica AS iFiguraJuridica,i.* FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica i 
				WHERE r.idActividad=".$fila["idActividad"]." AND r.idFiguraJuridica IN(2,4) 
				AND i.id__47_tablaDinamica=r.idParticipante ORDER BY idFiguraJuridica";
	
	$rParticipante=$con->obtenerFilas($consulta);
	while($fParticipante=mysql_fetch_assoc($rParticipante))
	{
		
		$consulta="SELECT * FROM _49_tablaDinamica WHERE idReferencia=".$fParticipante["id__47_tablaDinamica"];
		$fDatosC=$con->obtenerPrimeraFilaAsoc($consulta);
		
		$iContacto=json_decode(obtenerUltimoDomicilioFiguraJuridica($fParticipante["id__47_tablaDinamica"]));
		
		if($fParticipante["iFiguraJuridica"]==2)
		{
			$libro->cambiarHojaActiva(3);
			
			$nacionalidad="NULL";
			switch($fParticipante["esMexicano"])
			{
				case 0:
					$nacionalidad=1;
				break;
				case 1:
				case 2:
						$nacionalidad=$fParticipante["nacionalidad"];
				
				break;
				
			}
			
			if($nacionalidad=="")
				$nacionalidad="NULL";
				
			$paisResidencia="NULL";	
			if($iContacto->estado!="")
			{
				$paisResidencia="146";
			}
			$hablaLengua=($fDatosC["lengua"]!="" && $fDatosC["lengua"]!="-1")?"1":($fDatosC["requiereInterprete"]==""?"NULL":"0");	
			$lenguaIndigena=(($hablaLengua=="NULL")||($hablaLengua==0))?"NULL":($fDatosC["lengua"]!="" && $fDatosC["lengua"]!="-1")?$fDatosC["lengua"]:"NULL";
			
			$hablaLenguaExtranjera=($fDatosC["idiomaTraductor"]!="" && $fDatosC["idiomaTraductor"]!="-1")?"1":($fDatosC["requiereTraductor"]==""?"NULL":"0");	
			$lenguaExtranjera=(($hablaLenguaExtranjera=="NULL")||($hablaLenguaExtranjera==0))?"NULL":($fDatosC["idiomaTraductor"]!="" && $fDatosC["idiomaTraductor"]!="-1")?$fDatosC["idiomaTraductor"]:"NULL";
			
			$arrHoja4=array();
			$arrHoja4["A"]=$fParticipante["id__47_tablaDinamica"];
			$arrHoja4["B"]=$fila["idCarpeta"];
			$arrHoja4["C"]=$fParticipante["tipoPersona"];
			$arrHoja4["D"]=1;
			$arrHoja4["E"]="ND";
			$arrHoja4["F"]=$fParticipante["nombre"]==""?"NULL":$fParticipante["nombre"];
			$arrHoja4["G"]=$fParticipante["apellidoPaterno"]==""?"NULL":$fParticipante["apellidoPaterno"];
			$arrHoja4["H"]=$fParticipante["apellidoMaterno"]==""?"NULL":$fParticipante["apellidoMaterno"];
			$arrHoja4["I"]=$fParticipante["genero"]==""?"NULL":$fParticipante["genero"];
			$arrHoja4["J"]=$fParticipante["fechaNacimiento"]==""?"NULL":$fParticipante["fechaNacimiento"];
			$arrHoja4["K"]=$fParticipante["edad"]==""?"NULL":$fParticipante["edad"];
			$arrHoja4["L"]=$fParticipante["estadoCivil"]==""?"NULL":$fParticipante["estadoCivil"];
			$arrHoja4["M"]=$fParticipante["curp"]==""?"NULL":$fParticipante["curp"];
			$arrHoja4["N"]=$fParticipante["rfcEmpresa"]==""?"NULL":$fParticipante["rfcEmpresa"];
			$arrHoja4["O"]=$fParticipante["tipoPersona"]==2?($fParticipante["nombre"]==""?"NULL":$fParticipante["nombre"]):"NULL";
			$arrHoja4["P"]=$fDatosC["lgbttti"]==""?"NULL":$fDatosC["lgbttti"];
			$arrHoja4["Q"]=($fDatosC["requiereInterprete"]==2 || $fDatosC["requiereInterprete"]=="")?"NULL":$fDatosC["requiereInterprete"];
			$arrHoja4["R"]="ND";
			
			$arrHoja4["S"]="ND";
			$arrHoja4["T"]="ND";
			$arrHoja4["U"]="ND";

			$arrHoja4["V"]=$fParticipante["fechaNacimiento"]==""?"NULL":$fParticipante["fechaNacimiento"];
			$arrHoja4["W"]=$nacionalidad;
			$arrHoja4["X"]=$paisResidencia;
			$arrHoja4["Y"]=$iContacto->estado==""?"NULL":$iContacto->estado;
			$arrHoja4["Z"]=$iContacto->municipio==""?"NULL":$iContacto->municipio;
			$arrHoja4["AA"]=($fDatosC["poblacionCallejera"]==2  || $fDatosC["poblacionCallejera"]=="")?"NULL":$fDatosC["poblacionCallejera"];
			$arrHoja4["AB"]=$fDatosC["capacidaDiferente"]==""?"NULL":$fDatosC["capacidaDiferente"];
			$arrHoja4["AC"]="ND";
			$arrHoja4["AD"]="ND";
			$arrHoja4["AE"]=$fDatosC["sabeLeerEscribir"]==""?"NULL":$fDatosC["sabeLeerEscribir"];
			$arrHoja4["AF"]=$fDatosC["nivelEscolaridad"]==""?"NULL":$fDatosC["nivelEscolaridad"];
			$arrHoja4["AG"]="ND";
			$arrHoja4["AH"]=$fDatosC["entiendeIdiomaEspanol"]==""?"NULL":$fDatosC["entiendeIdiomaEspanol"];
			$arrHoja4["AI"]=$hablaLengua;
			$arrHoja4["AJ"]=$lenguaIndigena;
			$arrHoja4["AK"]=$hablaLenguaExtranjera;
			$arrHoja4["AL"]=$lenguaExtranjera;
			$arrHoja4["AM"]=$fDatosC["tipoOcupacion"]==""?"NULL":$fDatosC["tipoOcupacion"];
			foreach($arrHoja4 as $columna=>$valor)
			{
				$libro->setValor($columna.$nFilaVictima,$valor);
				
			}
			$nFilaVictima++;
		}
		else
		{
			$libro->cambiarHojaActiva(2);
			$nacionalidad="NULL";
			switch($fParticipante["esMexicano"])
			{
				case 0:
					$nacionalidad=1;
				break;
				case 1:
				case 2:
						$nacionalidad=$fParticipante["nacionalidad"];
				
				break;
				
			}
			
			if($nacionalidad=="")
				$nacionalidad="NULL";
				
			$paisResidencia="NULL";	
			if($iContacto->estado!="")
			{
				$paisResidencia="146";
			}
			$hablaLengua=($fDatosC["lengua"]!="" && $fDatosC["lengua"]!="-1")?"1":($fDatosC["requiereInterprete"]==""?"NULL":"0");	
			$lenguaIndigena=(($hablaLengua=="NULL")||($hablaLengua==0))?"NULL":($fDatosC["lengua"]!="" && $fDatosC["lengua"]!="-1")?$fDatosC["lengua"]:"NULL";
			
			$hablaLenguaExtranjera=($fDatosC["idiomaTraductor"]!="" && $fDatosC["idiomaTraductor"]!="-1")?"1":($fDatosC["requiereTraductor"]==""?"NULL":"0");	
			$lenguaExtranjera=(($hablaLenguaExtranjera=="NULL")||($hablaLenguaExtranjera==0))?"NULL":($fDatosC["idiomaTraductor"]!="" && $fDatosC["idiomaTraductor"]!="-1")?$fDatosC["idiomaTraductor"]:"NULL";
			
			$arrHoja3=array();
			$arrHoja3["A"]=$fParticipante["id__47_tablaDinamica"];
			$arrHoja3["B"]=$fila["idCarpeta"];
			$arrHoja3["C"]=$fParticipante["tipoPersona"];
			$arrHoja3["D"]=$fParticipante["nombre"]==""?"NULL":$fParticipante["nombre"];
			$arrHoja3["E"]=$fParticipante["apellidoPaterno"]==""?"NULL":$fParticipante["apellidoPaterno"];
			$arrHoja3["F"]=$fParticipante["apellidoMaterno"]==""?"NULL":$fParticipante["apellidoMaterno"];
			$arrHoja3["G"]=$fParticipante["genero"]==""?"NULL":$fParticipante["genero"];
			$arrHoja3["H"]=$fParticipante["fechaNacimiento"]==""?"NULL":$fParticipante["fechaNacimiento"];
			$arrHoja3["I"]=$fParticipante["edad"]==""?"NULL":$fParticipante["edad"];
			$arrHoja3["J"]=$fParticipante["estadoCivil"]==""?"NULL":$fParticipante["estadoCivil"];
			$arrHoja3["K"]=$fParticipante["curp"]==""?"NULL":$fParticipante["curp"];
			$arrHoja3["L"]=$fParticipante["rfcEmpresa"]==""?"NULL":$fParticipante["rfcEmpresa"];
			$arrHoja3["M"]=$fParticipante["tipoPersona"]==2?($fParticipante["nombre"]==""?"NULL":$fParticipante["nombre"]):"NULL";
			$arrHoja3["N"]=($fDatosC["requiereInterprete"]==2 || $fDatosC["requiereInterprete"]=="")?"NULL":$fDatosC["requiereInterprete"];
			$arrHoja3["O"]="ND";
			$arrHoja3["P"]="ND";
			$arrHoja3["Q"]="ND";
			$arrHoja3["R"]="ND";
			$arrHoja3["S"]=$fParticipante["fechaNacimiento"]==""?"NULL":$fParticipante["fechaNacimiento"];
			$arrHoja3["T"]=$nacionalidad;
			$arrHoja3["U"]=$paisResidencia;
			$arrHoja3["V"]=$iContacto->estado==""?"NULL":$iContacto->estado;
			$arrHoja3["W"]=$iContacto->municipio==""?"NULL":$iContacto->municipio;
			$arrHoja3["X"]=($fDatosC["poblacionCallejera"]==2  || $fDatosC["poblacionCallejera"]=="")?"NULL":$fDatosC["poblacionCallejera"];
			$arrHoja3["Y"]=$fDatosC["capacidaDiferente"]==""?"NULL":$fDatosC["capacidaDiferente"];
			$arrHoja3["Z"]="ND";
			$arrHoja3["AA"]=$fDatosC["sabeLeerEscribir"]==""?"NULL":$fDatosC["sabeLeerEscribir"];
			$arrHoja3["AB"]=$fDatosC["nivelEscolaridad"]==""?"NULL":$fDatosC["nivelEscolaridad"];
			$arrHoja3["AC"]="ND";
			$arrHoja3["AD"]=$fDatosC["entiendeIdiomaEspanol"]==""?"NULL":$fDatosC["entiendeIdiomaEspanol"];
			$arrHoja3["AE"]=$hablaLengua;
			$arrHoja3["AF"]=$lenguaIndigena;
			$arrHoja3["AG"]=$hablaLenguaExtranjera;
			$arrHoja3["AH"]=$lenguaExtranjera;
			$arrHoja3["AI"]=$fDatosC["tipoOcupacion"]==""?"NULL":$fDatosC["tipoOcupacion"];
			foreach($arrHoja3 as $columna=>$valor)
			{
				$libro->setValor($columna.$nFilaImputado,$valor);
				
			}
			$nFilaImputado++;
		}
	}
	
	$libro->cambiarHojaActiva(4);
	$consulta="SELECT * FROM _61_tablaDinamica WHERE idActividad=".$fila["idActividad"];
	$rDelito=$con->obtenerFilas($consulta);
	while($fDelito=mysql_fetch_assoc($rDelito))
	{
		$arrHoja4=array();
		$arrHoja4["A"]=$fDelito["id__61_tablaDinamica"];
		$arrHoja4["B"]=$fila["idCarpeta"];
		$arrHoja4["C"]="ND";
		$arrHoja4["D"]=$fDelito["denominacionDelito"]==""?"NULL":$fDelito["denominacionDelito"];
		$arrHoja4["E"]="ND";
		$arrHoja4["F"]="ND";
		$arrHoja4["G"]=$fDelito["calificativo"]==""?"NULL":($fDelito["calificativo"]==2?"1":"0");
		$arrHoja4["H"]="ND";
		$arrHoja4["I"]=$fDelito["calificativo"]==""?"NULL":($fDelito["calificativo"]==3?"1":"0");
		$arrHoja4["J"]=$fDelito["calificativo"]==""?"NULL":($fDelito["calificativo"]==1?"1":"0");
		$arrHoja4["K"]=($fDelito["gradoRealizacion"]=="" || $fDelito["gradoRealizacion"]=="3")?"NULL":($fDelito["gradoRealizacion"]==1?"2":"1");
		$arrHoja4["L"]="ND";
		$arrHoja4["M"]="ND";
		$arrHoja4["N"]="ND";
		$arrHoja4["O"]="ND";
		$arrHoja4["P"]="ND";
		$arrHoja4["Q"]="ND";
		$arrHoja4["R"]="ND";
		$arrHoja4["S"]="ND";
		
		foreach($arrHoja4 as $columna=>$valor)
		{
			$libro->setValor($columna.$nFilaDelito,$arrHoja4[$columna]);
			
		}
		$nFilaDelito++;
	}
	$libro->cambiarHojaActiva(0);
	$nFila++;
}

$libro->cambiarHojaActiva(1);

$nFilaExhorto=2;
$consulta="SELECT s.*,c.idCarpeta,c.idActividad FROM _92_tablaDinamica s,7006_carpetasAdministrativas c WHERE c.fechaCreacion>='".$periodoInicial.
		"' AND c.fechaCreacion<='".$periodoFinal." 23:59:59' and c.tipoCarpetaAdministrativa=2 and c.idFormulario=92 and 
		c.idRegistro=s.id__92_tablaDinamica";
$res=$con->obtenerFilas($consulta);
while($fila=mysql_fetch_assoc($res))
{
	$arrCarpeta=explode("/",$fila["carpetaExhorto"]);
	$arrHoja2=array();
	$arrHoja2["A"]=$fila["idCarpeta"];
	$arrHoja2["B"]=date("Y-m-d H:i",strtotime($fila["fechaCreacion"]));
	$arrHoja2["C"]=date("Y-m-d H:i",strtotime($fila["fechaCreacion"]));
	$arrHoja2["D"]=$arrCarpeta[1]*1;
	$arrHoja2["E"]=date("Y",strtotime($fila["fechaCreacion"]));
	$arrHoja2["F"]=$fila["carpetaExhorto"];
	$arrHoja2["G"]=$fila["entidadFederativa"];
	$arrHoja2["H"]=$fila["autoridaExhortante"];
	
	foreach($arrHoja2 as $columna=>$valor)
	{
		$libro->setValor($columna.$nFilaExhorto,$arrHoja2[$columna]);
	}
	
	$consulta="SELECT r.idFiguraJuridica AS iFiguraJuridica,i.* FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica i 
				WHERE r.idActividad=".$fila["idActividad"]." AND r.idFiguraJuridica IN(2,4) 
				AND i.id__47_tablaDinamica=r.idParticipante ORDER BY idFiguraJuridica";
	
	$rParticipante=$con->obtenerFilas($consulta);
	while($fParticipante=mysql_fetch_assoc($rParticipante))
	{
		
		$consulta="SELECT * FROM _49_tablaDinamica WHERE idReferencia=".$fParticipante["id__47_tablaDinamica"];
		$fDatosC=$con->obtenerPrimeraFilaAsoc($consulta);
		
		$iContacto=json_decode(obtenerUltimoDomicilioFiguraJuridica($fParticipante["id__47_tablaDinamica"]));
		
		if($fParticipante["iFiguraJuridica"]==2)
		{
			$libro->cambiarHojaActiva(3);
			
			$nacionalidad="NULL";
			switch($fParticipante["esMexicano"])
			{
				case 0:
					$nacionalidad=1;
				break;
				case 1:
				case 2:
						$nacionalidad=$fParticipante["nacionalidad"];
				
				break;
				
			}
			
			if($nacionalidad=="")
				$nacionalidad="NULL";
				
			$paisResidencia="NULL";	
			if($iContacto->estado!="")
			{
				$paisResidencia="146";
			}
			$hablaLengua=($fDatosC["lengua"]!="" && $fDatosC["lengua"]!="-1")?"1":($fDatosC["requiereInterprete"]==""?"NULL":"0");	
			$lenguaIndigena=(($hablaLengua=="NULL")||($hablaLengua==0))?"NULL":($fDatosC["lengua"]!="" && $fDatosC["lengua"]!="-1")?$fDatosC["lengua"]:"NULL";
			
			$hablaLenguaExtranjera=($fDatosC["idiomaTraductor"]!="" && $fDatosC["idiomaTraductor"]!="-1")?"1":($fDatosC["requiereTraductor"]==""?"NULL":"0");	
			$lenguaExtranjera=(($hablaLenguaExtranjera=="NULL")||($hablaLenguaExtranjera==0))?"NULL":($fDatosC["idiomaTraductor"]!="" && $fDatosC["idiomaTraductor"]!="-1")?$fDatosC["idiomaTraductor"]:"NULL";
			
			$arrHoja4=array();
			$arrHoja4["A"]=$fParticipante["id__47_tablaDinamica"];
			$arrHoja4["B"]=$fila["idCarpeta"];
			$arrHoja4["C"]=$fParticipante["tipoPersona"];
			$arrHoja4["D"]=1;
			$arrHoja4["E"]="ND";
			$arrHoja4["F"]=$fParticipante["nombre"]==""?"NULL":$fParticipante["nombre"];
			$arrHoja4["G"]=$fParticipante["apellidoPaterno"]==""?"NULL":$fParticipante["apellidoPaterno"];
			$arrHoja4["H"]=$fParticipante["apellidoMaterno"]==""?"NULL":$fParticipante["apellidoMaterno"];
			$arrHoja4["I"]=$fParticipante["genero"]==""?"NULL":$fParticipante["genero"];
			$arrHoja4["J"]=$fParticipante["fechaNacimiento"]==""?"NULL":$fParticipante["fechaNacimiento"];
			$arrHoja4["K"]=$fParticipante["edad"]==""?"NULL":$fParticipante["edad"];
			$arrHoja4["L"]=$fParticipante["estadoCivil"]==""?"NULL":$fParticipante["estadoCivil"];
			$arrHoja4["M"]=$fParticipante["curp"]==""?"NULL":$fParticipante["curp"];
			$arrHoja4["N"]=$fParticipante["rfcEmpresa"]==""?"NULL":$fParticipante["rfcEmpresa"];
			$arrHoja4["O"]=$fParticipante["tipoPersona"]==2?($fParticipante["nombre"]==""?"NULL":$fParticipante["nombre"]):"NULL";
			$arrHoja4["P"]=$fDatosC["lgbttti"]==""?"NULL":$fDatosC["lgbttti"];
			$arrHoja4["Q"]=($fDatosC["requiereInterprete"]==2 || $fDatosC["requiereInterprete"]=="")?"NULL":$fDatosC["requiereInterprete"];
			$arrHoja4["R"]="ND";
			
			$arrHoja4["S"]="ND";
			$arrHoja4["T"]="ND";
			$arrHoja4["U"]="ND";

			$arrHoja4["V"]=$fParticipante["fechaNacimiento"]==""?"NULL":$fParticipante["fechaNacimiento"];
			$arrHoja4["W"]=$nacionalidad;
			$arrHoja4["X"]=$paisResidencia;
			$arrHoja4["Y"]=$iContacto->estado==""?"NULL":$iContacto->estado;
			$arrHoja4["Z"]=$iContacto->municipio==""?"NULL":$iContacto->municipio;
			$arrHoja4["AA"]=($fDatosC["poblacionCallejera"]==2  || $fDatosC["poblacionCallejera"]=="")?"NULL":$fDatosC["poblacionCallejera"];
			$arrHoja4["AB"]=$fDatosC["capacidaDiferente"]==""?"NULL":$fDatosC["capacidaDiferente"];
			$arrHoja4["AC"]="ND";
			$arrHoja4["AD"]="ND";
			$arrHoja4["AE"]=$fDatosC["sabeLeerEscribir"]==""?"NULL":$fDatosC["sabeLeerEscribir"];
			$arrHoja4["AF"]=$fDatosC["nivelEscolaridad"]==""?"NULL":$fDatosC["nivelEscolaridad"];
			$arrHoja4["AG"]="ND";
			$arrHoja4["AH"]=$fDatosC["entiendeIdiomaEspanol"]==""?"NULL":$fDatosC["entiendeIdiomaEspanol"];
			$arrHoja4["AI"]=$hablaLengua;
			$arrHoja4["AJ"]=$lenguaIndigena;
			$arrHoja4["AK"]=$hablaLenguaExtranjera;
			$arrHoja4["AL"]=$lenguaExtranjera;
			$arrHoja4["AM"]=$fDatosC["tipoOcupacion"]==""?"NULL":$fDatosC["tipoOcupacion"];
			foreach($arrHoja4 as $columna=>$valor)
			{
				$libro->setValor($columna.$nFilaVictima,$valor);
				
			}
			$nFilaVictima++;
		}
		else
		{
			$libro->cambiarHojaActiva(2);
			$nacionalidad="NULL";
			switch($fParticipante["esMexicano"])
			{
				case 0:
					$nacionalidad=1;
				break;
				case 1:
				case 2:
						$nacionalidad=$fParticipante["nacionalidad"];
				
				break;
				
			}
			
			if($nacionalidad=="")
				$nacionalidad="NULL";
				
			$paisResidencia="NULL";	
			if($iContacto->estado!="")
			{
				$paisResidencia="146";
			}
			$hablaLengua=($fDatosC["lengua"]!="" && $fDatosC["lengua"]!="-1")?"1":($fDatosC["requiereInterprete"]==""?"NULL":"0");	
			$lenguaIndigena=(($hablaLengua=="NULL")||($hablaLengua==0))?"NULL":($fDatosC["lengua"]!="" && $fDatosC["lengua"]!="-1")?$fDatosC["lengua"]:"NULL";
			
			$hablaLenguaExtranjera=($fDatosC["idiomaTraductor"]!="" && $fDatosC["idiomaTraductor"]!="-1")?"1":($fDatosC["requiereTraductor"]==""?"NULL":"0");	
			$lenguaExtranjera=(($hablaLenguaExtranjera=="NULL")||($hablaLenguaExtranjera==0))?"NULL":($fDatosC["idiomaTraductor"]!="" && $fDatosC["idiomaTraductor"]!="-1")?$fDatosC["idiomaTraductor"]:"NULL";
			
			$arrHoja3=array();
			$arrHoja3["A"]=$fParticipante["id__47_tablaDinamica"];
			$arrHoja3["B"]=$fila["idCarpeta"];
			$arrHoja3["C"]=$fParticipante["tipoPersona"];
			$arrHoja3["D"]=$fParticipante["nombre"]==""?"NULL":$fParticipante["nombre"];
			$arrHoja3["E"]=$fParticipante["apellidoPaterno"]==""?"NULL":$fParticipante["apellidoPaterno"];
			$arrHoja3["F"]=$fParticipante["apellidoMaterno"]==""?"NULL":$fParticipante["apellidoMaterno"];
			$arrHoja3["G"]=$fParticipante["genero"]==""?"NULL":$fParticipante["genero"];
			$arrHoja3["H"]=$fParticipante["fechaNacimiento"]==""?"NULL":$fParticipante["fechaNacimiento"];
			$arrHoja3["I"]=$fParticipante["edad"]==""?"NULL":$fParticipante["edad"];
			$arrHoja3["J"]=$fParticipante["estadoCivil"]==""?"NULL":$fParticipante["estadoCivil"];
			$arrHoja3["K"]=$fParticipante["curp"]==""?"NULL":$fParticipante["curp"];
			$arrHoja3["L"]=$fParticipante["rfcEmpresa"]==""?"NULL":$fParticipante["rfcEmpresa"];
			$arrHoja3["M"]=$fParticipante["tipoPersona"]==2?($fParticipante["nombre"]==""?"NULL":$fParticipante["nombre"]):"NULL";
			$arrHoja3["N"]=($fDatosC["requiereInterprete"]==2 || $fDatosC["requiereInterprete"]=="")?"NULL":$fDatosC["requiereInterprete"];
			$arrHoja3["O"]="ND";
			$arrHoja3["P"]="ND";
			$arrHoja3["Q"]="ND";
			$arrHoja3["R"]="ND";
			$arrHoja3["S"]=$fParticipante["fechaNacimiento"]==""?"NULL":$fParticipante["fechaNacimiento"];
			$arrHoja3["T"]=$nacionalidad;
			$arrHoja3["U"]=$paisResidencia;
			$arrHoja3["V"]=$iContacto->estado==""?"NULL":$iContacto->estado;
			$arrHoja3["W"]=$iContacto->municipio==""?"NULL":$iContacto->municipio;
			$arrHoja3["X"]=($fDatosC["poblacionCallejera"]==2  || $fDatosC["poblacionCallejera"]=="")?"NULL":$fDatosC["poblacionCallejera"];
			$arrHoja3["Y"]=$fDatosC["capacidaDiferente"]==""?"NULL":$fDatosC["capacidaDiferente"];
			$arrHoja3["Z"]="ND";
			$arrHoja3["AA"]=$fDatosC["sabeLeerEscribir"]==""?"NULL":$fDatosC["sabeLeerEscribir"];
			$arrHoja3["AB"]=$fDatosC["nivelEscolaridad"]==""?"NULL":$fDatosC["nivelEscolaridad"];
			$arrHoja3["AC"]="ND";
			$arrHoja3["AD"]=$fDatosC["entiendeIdiomaEspanol"]==""?"NULL":$fDatosC["entiendeIdiomaEspanol"];
			$arrHoja3["AE"]=$hablaLengua;
			$arrHoja3["AF"]=$lenguaIndigena;
			$arrHoja3["AG"]=$hablaLenguaExtranjera;
			$arrHoja3["AH"]=$lenguaExtranjera;
			$arrHoja3["AI"]=$fDatosC["tipoOcupacion"]==""?"NULL":$fDatosC["tipoOcupacion"];
			foreach($arrHoja3 as $columna=>$valor)
			{
				$libro->setValor($columna.$nFilaImputado,$valor);
				
			}
			$nFilaImputado++;
		}
	}
	$libro->cambiarHojaActiva(1);
	$nFilaExhorto++;
}

$numFila=2;
$libro->cambiarHojaActiva(5);



$libro->generarArchivo("Excel2007","informeEstadistica_".str_replace("-","_",$periodoInicial)."_".str_replace("-","_",$periodoFinal).".xlsx");	