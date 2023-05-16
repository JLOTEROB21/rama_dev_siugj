<?php

	include("conexionBD.php");
	include_once("PHPWord.php");
	include_once("zip.lib.php"); 
	include_once("numeroToLetra.php"); 
	$enterWord='<w:p w:rsidRDefault="003819FA" w:rsidR="0050562A"><w:r><w:t></w:t></w:r></w:p>';
	$tipoInfome=-1;
	if(isset($_GET["tipoInfome"]))
		$tipoInfome=$_GET["tipoInfome"];
	
	$imputado=$_GET["nombre"];
	
	switch($tipoInfome)
	{
		case 1:		//No existe
			$fechaActual=strtotime(date("Y-m-d"));
			
			
			
			$PHPWord = new PHPWord();
			$document = $PHPWord->loadTemplate($baseDir.'\\modulosEspeciales_SGJP\\formatos\\informeNoAcuerdoReparatorio.docx');	
			
			$arrValores=array();
			
			$arrValores["dia"]=date("d",$fechaActual);
			$arrValores["mes"]=$arrMesLetra[(date("m",$fechaActual)*1)-1];
			$arrValores["anio"]=date("Y",$fechaActual);
			$arrValores["imputado"]=utf8_decode($imputado);
			$arrValores["fechaImpresion"]=date("d/m/Y H:i:s");
			
			
			foreach($arrValores as $llave=>$valor)
			{
				$document->setValue("[".$llave."]",utf8_decode($valor));	
			}
			
			$nombreAleatorio=generarNombreArchivoTemporal();
			$nomArchivo=$nombreAleatorio.".docx";
			$document->save($nomArchivo);
			
			$nombreFinal=str_replace(".docx",".pdf",$nomArchivo);
			generarDocumentoPDF($nomArchivo,false,false,true,$nombreFinal,"","./");
			
			header("Content-type:application/pdf"); 
			header("Content-length: ".filesize($nombreFinal)); 
			header("Content-Disposition: inline; filename=".$nombreFinal);
			readfile($nombreFinal);
			
			
			unlink($nombreFinal);
		break;		
		case 2:
			$fechaActual=strtotime(date("Y-m-d"));
			
			$listaAcuerdos=$_GET["listaAcuerdos"];
			
			$PHPWord = new PHPWord();
			$document = $PHPWord->loadTemplate($baseDir.'\\modulosEspeciales_SGJP\\formatos\\informeAcuerdoReparatorio.docx');	
			$acuerdo='';
			
			
			$consulta="SELECT * FROM 3014_registroAcuerdosReparatorios WHERE idRegistro in (".$listaAcuerdos.")";
			$res=$con->obtenerFilas($consulta);
			while($fAcuerdo=mysql_fetch_row($res))
			{
				if($acuerdo=="")
					$acuerdo=generarTablaAcuerdo($fAcuerdo[0]);
				else
					$acuerdo.=$enterWord.generarTablaAcuerdo($fAcuerdo[0]);
			}

			$arrValores=array();
			$arrValores["dia"]=date("d",$fechaActual);
			$arrValores["mes"]=$arrMesLetra[(date("m",$fechaActual)*1)-1];
			$arrValores["anio"]=date("Y",$fechaActual);
			$arrValores["imputado"]=utf8_decode($imputado);
			$arrValores["acuerdo"]=$acuerdo;
			$arrValores["fechaImpresion"]=date("d/m/Y H:i:s");
			foreach($arrValores as $llave=>$valor)
			{
				$document->setValue("[".$llave."]",utf8_decode($valor));	
			}
			
			
			$nombreAleatorio=generarNombreArchivoTemporal();
			$nomArchivo=$nombreAleatorio.".docx";
			$document->save($nomArchivo);
			
			$nombreFinal=str_replace(".docx",".pdf",$nomArchivo);
			generarDocumentoPDF($nomArchivo,false,false,true,$nombreFinal,"MS_OFFICE","./");

			header("Content-type:application/pdf"); 
			header("Content-length: ".filesize($nombreFinal)); 
			header("Content-Disposition: inline; filename=".$nombreFinal);
			readfile($nombreFinal);
			
			
			unlink($nombreFinal);
			
			
		break;
	}
	
	function generarTablaAcuerdo($idAcuerdo)
	{
		global $con;
		global $enterWord;
		
		$consulta="SELECT * FROM 3014_registroAcuerdosReparatorios WHERE idRegistro=".$idAcuerdo;
		$fAcuerdo=$con->obtenerPrimeraFila($consulta);
		
		$consulta="SELECT horaInicioEvento FROM 7000_eventosAudiencia WHERE idRegistroEvento=".$fAcuerdo[5];
		$fechaInicioEvento=$con->obtenerValor($consulta);
		$resumen=trim($fAcuerdo[1]);
		$consulta="SELECT carpetaAdministrativa FROM 7007_contenidosCarpetaAdministrativa WHERE tipoContenido=3 AND idRegistroContenidoReferencia=".$fAcuerdo[5];
		$carpetaAdministrativa=$con->obtenerValor($consulta);
		
		$situacionActual="";
		switch($fAcuerdo[7])
		{
			case 1:
				$situacionActual="Activo";
			break;
			case 2:
				$situacionActual="Revocado";
			break;
			case 3:
				$situacionActual="Cumplido";
			break;
		}
		
		$historialCambios="";
		
		$arrBitacoraComentarios=array();
		$arrComentarios=array();
		$arrComentarios[$fAcuerdo[8]!=""?$fAcuerdo[8]:$fechaInicioEvento]=$fAcuerdo[6]==""?"(Sin comentarios)":$fAcuerdo[6];
		$consulta="SELECT comentariosAdicionales,fechaCambio,fechaExtinsion FROM 3014_modificacionesAcuerdoReparatorio WHERE idAcuerdo=".$fAcuerdo[0].
					" order by idRegistro";
		$rComentarios=$con->obtenerFilas($consulta);
		while($fComentarios=mysql_fetch_row($rComentarios))
		{
			$arrComentarios[$fComentarios[1]]=$fComentarios[0]==""?"(Sin comentarios)":$fComentarios[0];
		}
		
		
		$comentariosAdicionales="";
		if(sizeof($arrComentarios)==1)
		{
			foreach($arrComentarios as $fecha=>$resto)
			{
				$arrBitacoraComentarios[strtotime($fecha)]=$resto;
			}
				//$comentariosAdicionales="(".date("d/m/Y H:i",strtotime($fecha))." hrs.): ".$resto;
				
		}
		else
		{
			$ultimafecha="";
			$primerComentario="";
			$posicion=0;
			foreach($arrComentarios as $fecha=>$resto)
			{
				
				if($posicion==0)
				{
					$ultimafecha=$fecha;
					$primerComentario=$resto;
				}
				else
				{
					
					$arrBitacoraComentarios[strtotime($ultimafecha)]=$resto;
					$ultimafecha=$fecha;
					
				}
				$posicion++;
			}
			
			$comentario="(".date("d/m/Y H:i",strtotime($ultimafecha))." hrs.): ".$primerComentario;
			$arrBitacoraComentarios[strtotime($ultimafecha)]=$primerComentario;
					//echo $comentario."<br><br>";
			
		}
		
		$tblBitacora="";
		foreach($arrBitacoraComentarios as $fecha=>$comentarios)			
		{
			$tblBitacora.="";
		}
		$tblAcuerdo='<w:tbl>
						<w:tblPr>
						<w:tblStyle w:val="Tablaconcuadrcula"/>
						<w:tblW w:w="0" w:type="auto"/>
						<w:tblLook w:val="04A0" w:firstRow="1" w:lastRow="0" w:firstColumn="1" w:lastColumn="0" w:noHBand="0" w:noVBand="1"/>
						</w:tblPr>
						<w:tblGrid>
						<w:gridCol w:w="2547"/>
						<w:gridCol w:w="6281"/>
						</w:tblGrid>
						<w:tr w:rsidR="009E4DCD" w:rsidTr="009E4DCD">
						<w:tc>
						<w:tcPr>
						<w:tcW w:w="2547" w:type="dxa"/>
						</w:tcPr>
						<w:p w:rsidR="009E4DCD" w:rsidRPr="009E4DCD" w:rsidRDefault="009E4DCD">
						<w:pPr>
						<w:rPr>
						<w:b/>
						</w:rPr>
						</w:pPr>
						<w:r w:rsidRPr="009E4DCD">
						<w:rPr>
						<w:b/>
						</w:rPr>
						<w:t>Carpeta Judicial</w:t>
						</w:r>
						<w:r>
						<w:rPr>
						<w:b/>
						</w:rPr>
						<w:t>:</w:t>
						</w:r>
						</w:p>
						</w:tc>
						<w:tc>
						<w:tcPr>
						<w:tcW w:w="6281" w:type="dxa"/>
						</w:tcPr>
						<w:p w:rsidR="009E4DCD" w:rsidRDefault="006D56EA" w:rsidP="009E4DCD">
						<w:pPr>
						<w:jc w:val="both"/>
						</w:pPr>
						<w:r>
						<w:t>'.$carpetaAdministrativa.'</w:t>
						</w:r>
						</w:p>
						</w:tc>
						</w:tr>
						<w:tr w:rsidR="006D56EA" w:rsidTr="009E4DCD">
						<w:tc>
						<w:tcPr>
						<w:tcW w:w="2547" w:type="dxa"/>
						</w:tcPr>
						<w:p w:rsidR="006D56EA" w:rsidRPr="009E4DCD" w:rsidRDefault="006D56EA" w:rsidP="006D56EA">
						<w:pPr>
						<w:rPr>
						<w:b/>
						</w:rPr>
						</w:pPr>
						<w:r w:rsidRPr="009E4DCD">
						<w:rPr>
						<w:b/>
						</w:rPr>
						<w:t>Tipo de Cumplimiento:</w:t>
						</w:r>
						</w:p>
						</w:tc>
						<w:tc>
						<w:tcPr>
						<w:tcW w:w="6281" w:type="dxa"/>
						</w:tcPr>
						<w:p w:rsidR="006D56EA" w:rsidRDefault="006D56EA" w:rsidP="006D56EA">
						<w:pPr>
						<w:jc w:val="both"/>
						</w:pPr>
						<w:r>
						<w:t>'.($fAcuerdo[2]==1?"Inmediato":"Diferido").'</w:t>
						</w:r>
						</w:p>
						</w:tc>
						</w:tr>
						<w:tr w:rsidR="006D56EA" w:rsidTr="009E4DCD">
						<w:tc>
						<w:tcPr>
						<w:tcW w:w="2547" w:type="dxa"/>
						</w:tcPr>
						<w:p w:rsidR="006D56EA" w:rsidRPr="009E4DCD" w:rsidRDefault="006D56EA" w:rsidP="006D56EA">
						<w:pPr>
						<w:rPr>
						<w:b/>
						</w:rPr>
						</w:pPr>
						<w:r w:rsidRPr="009E4DCD">
						<w:rPr>
						<w:b/>
						</w:rPr>
						<w:t>Acuerdo Aprobado:</w:t>
						</w:r>
						</w:p>
						</w:tc>
						<w:tc>
						<w:tcPr>
						<w:tcW w:w="6281" w:type="dxa"/>
						</w:tcPr>
						<w:p w:rsidR="006D56EA" w:rsidRDefault="006D56EA" w:rsidP="006D56EA">
						<w:pPr>
						<w:jc w:val="both"/>
						</w:pPr>
						<w:r>
						<w:t>'.($fAcuerdo[3]==1?"Sí":"No").'</w:t>
						</w:r>
						</w:p>
						</w:tc>
						</w:tr>
						<w:tr w:rsidR="006D56EA" w:rsidTr="009E4DCD">
						<w:tc>
						<w:tcPr>
						<w:tcW w:w="2547" w:type="dxa"/>
						</w:tcPr>
						<w:p w:rsidR="006D56EA" w:rsidRPr="009E4DCD" w:rsidRDefault="006D56EA" w:rsidP="006D56EA">
						<w:pPr>
						<w:rPr>
						<w:b/>
						</w:rPr>
						</w:pPr>
						<w:r w:rsidRPr="009E4DCD">
						<w:rPr>
						<w:b/>
						</w:rPr>
						<w:t>Fecha de extinsión de la acción Penal:</w:t>
						</w:r>
						</w:p>
						</w:tc>
						<w:tc>
						<w:tcPr>
						<w:tcW w:w="6281" w:type="dxa"/>
						</w:tcPr>
						<w:p w:rsidR="006D56EA" w:rsidRDefault="006D56EA" w:rsidP="006D56EA">
						<w:pPr>
						<w:jc w:val="both"/>
						</w:pPr>
						<w:r>
						<w:t>'.(($fAcuerdo[4]=="")?"--":date("d/m/Y",strtotime($fAcuerdo[4]))).'</w:t>
						</w:r>
						</w:p>
						</w:tc>
						</w:tr>
						<w:tr w:rsidR="006D56EA" w:rsidTr="009E4DCD">
						<w:tc>
						<w:tcPr>
						<w:tcW w:w="2547" w:type="dxa"/>
						</w:tcPr>
						<w:p w:rsidR="006D56EA" w:rsidRPr="009E4DCD" w:rsidRDefault="006D56EA" w:rsidP="006D56EA">
						<w:pPr>
						<w:rPr>
						<w:b/>
						</w:rPr>
						</w:pPr>
						<w:r w:rsidRPr="009E4DCD">
						<w:rPr>
						<w:b/>
						</w:rPr>
						<w:t>Resumen:</w:t>
						</w:r>
						</w:p>
						</w:tc>
						<w:tc>
						<w:tcPr>
						<w:tcW w:w="6281" w:type="dxa"/>
						</w:tcPr>
						<w:p w:rsidR="006D56EA" w:rsidRDefault="006D56EA" w:rsidP="006D56EA">
						<w:pPr>
						<w:jc w:val="both"/>
						</w:pPr>
						<w:r>
						<w:t>'.$resumen.'</w:t>
						</w:r>
						</w:p>
						</w:tc>
						</w:tr>
						<w:tr w:rsidR="006D56EA" w:rsidTr="009E4DCD">
						<w:tc>
						<w:tcPr>
						<w:tcW w:w="2547" w:type="dxa"/>
						</w:tcPr>
						<w:p w:rsidR="006D56EA" w:rsidRPr="009E4DCD" w:rsidRDefault="006D56EA" w:rsidP="006D56EA">
						<w:pPr>
						<w:rPr>
						<w:b/>
						</w:rPr>
						</w:pPr>
						<w:r w:rsidRPr="009E4DCD">
						<w:rPr>
						<w:b/>
						</w:rPr>
						<w:t>Situación Actual:</w:t>
						</w:r>
						</w:p>
						</w:tc>
						<w:tc>
						<w:tcPr>
						<w:tcW w:w="6281" w:type="dxa"/>
						</w:tcPr>
						<w:p w:rsidR="006D56EA" w:rsidRDefault="006D56EA" w:rsidP="006D56EA">
						<w:pPr>
						<w:jc w:val="both"/>
						</w:pPr>
						<w:r>
						<w:t>'.$situacionActual.'</w:t>
						</w:r>
						</w:p>
						</w:tc>
						</w:tr>
						
					</w:tbl>';
				/*
				<w:tr w:rsidR="006D56EA" w:rsidTr="009E4DCD">
						<w:tc>
						<w:tcPr>
						<w:tcW w:w="2547" w:type="dxa"/>
						</w:tcPr>
						<w:p w:rsidR="006D56EA" w:rsidRPr="009E4DCD" w:rsidRDefault="006D56EA" w:rsidP="006D56EA">
						<w:pPr>
						<w:rPr>
						<w:b/>
						</w:rPr>
						</w:pPr>
						<w:r>
						<w:rPr>
						<w:b/>
						</w:rPr>
						<w:t>Historial de cambios</w:t>
						</w:r>
						<w:r w:rsidRPr="009E4DCD">
						<w:rPr>
						<w:b/>
						</w:rPr>
						<w:t>:</w:t>
						</w:r>
						</w:p>
						</w:tc>
						<w:tc>
						<w:tcPr>
						<w:tcW w:w="6281" w:type="dxa"/>
						</w:tcPr>
						<w:tbl>
						<w:tblPr>
						<w:tblStyle w:val="Tablaconcuadrcula"/>
						<w:tblW w:w="0" w:type="auto"/>
						<w:tblLook w:val="04A0" w:noVBand="1" w:noHBand="0" w:lastColumn="0" w:firstColumn="1" w:lastRow="0" w:firstRow="1"/>
						</w:tblPr>
						<w:tblGrid>
						<w:gridCol w:w="6055"/>
						</w:tblGrid>
						<w:tr w:rsidR="003519C7" w:rsidTr="003519C7">
						<w:tc>
						<w:tcPr>
						<w:tcW w:w="6055" w:type="dxa"/>
						</w:tcPr>
						<w:p w:rsidRDefault="008F18C9" w:rsidR="003519C7" w:rsidP="00754A2E">
						<w:pPr>
						<w:jc w:val="both"/>
						</w:pPr>
						<w:r>
						<w:t>[a]</w:t>
						</w:r>
						</w:p>
						</w:tc>
						</w:tr>
						<w:tr w:rsidR="003519C7" w:rsidTr="003519C7">
						<w:tc>
						<w:tcPr>
						<w:tcW w:w="6055" w:type="dxa"/>
						</w:tcPr>
						<w:p w:rsidRDefault="008F18C9" w:rsidR="003519C7" w:rsidP="00754A2E">
						<w:pPr>
						<w:jc w:val="both"/>
						</w:pPr>
						<w:r>
						<w:t>[b]</w:t>
						</w:r>
						</w:p>
						</w:tc>
						</w:tr>
						<w:tr w:rsidR="003519C7" w:rsidTr="003519C7">
						<w:tc>
						<w:tcPr>
						<w:tcW w:w="6055" w:type="dxa"/>
						</w:tcPr>
						<w:p w:rsidRDefault="008F18C9" w:rsidR="003519C7" w:rsidP="00754A2E">
						<w:pPr>
						<w:jc w:val="both"/>
						</w:pPr>
						<w:r>
						<w:t>[c]</w:t>
						</w:r>
						<w:bookmarkStart w:name="_GoBack" w:id="0"/>
						<w:bookmarkEnd w:id="0"/>
						</w:p>
						</w:tc>
						</w:tr>
						</w:tbl>
						<w:p w:rsidRDefault="00754A2E" w:rsidR="00754A2E" w:rsidRPr="00754A2E" w:rsidP="00754A2E">
						<w:pPr>
						
						<w:jc w:val="both"/>
						
						</w:pPr>
						
						</w:p>
						
						</w:tc>
						</w:tr>
				*/
		return $tblAcuerdo;	
	}
?>