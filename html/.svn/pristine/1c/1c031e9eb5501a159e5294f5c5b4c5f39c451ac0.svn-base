<?php session_start();
	include("conexionBD.php");
	$parametros="";
	$funcion="";
	if(isset($_POST["funcion"]))
	{
		$funcion=$_POST["funcion"];
	}	
	switch($funcion)
	{
		
		case 2:
			obtenerAsignaciones();
		break;
		case 3:
			obtenerProfesoresDisponibles();
		break;
		case 4:
			eliminarFecha();
		break;
		case 5:
			validarFecha();
		break;
		case 6:
			validarProgramaCiclo();
		break;
		case 7:
			programaMateria();
		break;
		case 8:
			validarFechaAbierta();
		break;
		case 9:
			validarFechaMateria();
		break;
		case 10:
			guardarDiasMateria();
		break;
		case 11:
			obtenerElementosPerfil();
		break;
		case 12:
			guardarPerfilParticipacion();
		break;
		case 13:
			compruebaFechaSemanas();
		break;
		case 14:
			obtenerFechas();
		break;
		case 15:
			obtenerFechasInsc();
		break;
		case 16:
			guardarFechas();
		break;
		case 17:
			guardarFechasInsc();
		break;
		case 18:
			clonarMapaCurricular();
		break;
		case 100:
			guardarBoletaMateria();
		break;
	}
	
	function obtenerAsignaciones()
	{
		global $con;
		$idRol=$_POST["idRol"];
		$consulta="select idElementoMapa,idUsuario as idProfesor from 4049_materiaVSProfesorVSGrupo where idRol=".$idRol;
		$arrAsignaciones= $con->obtenerFilasArreglo($consulta);
		//$arrCadObj=$con->obtenerFilasJSON($consulta);
		//echo "1|".$arrCadObj;	
		echo "1|".$arrAsignaciones;
		
	}
	function obtenerProfesoresDisponibles ()
	{
		global $con;
		$param=$_POST["param"];
		
		$obj=json_decode(dvJs($param));
		$idRol=$obj->idRol;
		$idElementoMapa=$obj->idElementoMapa;
		//despliega el profesor asignado
		$consulta="SELECT i.idUsuario, CONCAT (Paterno,' ',Materno,' ' ,Nom)AS nombre  FROM 802_identifica i,4049_materiaVSProfesorVSGrupo m 
		WHERE i.idUsuario=m.idUsuario AND m.idElementoMapa=".$idElementoMapa." AND m.idRol=".$idRol. " AND estado=1";
		$fila=$con->obtenerPrimeraFila($consulta);	
		$idProfesor="-1";
		$nomProfesor="Sin Profesor";
		if($fila[0]!="")
		{
			$idProfesor=$fila[0];
			$nomProfesor=$fila[1];
		}
		
		//despliega a todos los maestros menos el que estaba asignado
		$consulta="SELECT i.idUsuario, CONCAT (Paterno,' ',Materno,' ' ,Nom)AS nombre  FROM 802_identifica i,807_usuariosVSRoles u
		WHERE i.idUsuario=u.idUsuario AND u.idRol=5 AND i.idUsuario<>".$idProfesor." ORDER BY nombre";
		$arreglo=$con->obtenerFilasArreglo($consulta);
				
		echo "1|".$idProfesor."|".$nomProfesor."|".$arreglo;

		
	}
	
	function eliminarFecha()
	{
	  global $con;
	  $id=$_POST["idTabla"];
	  $consulta="delete from  4068_fechaCalendario where idFechaCalendario=".$id;
	  $re1=$con->ejecutarConsulta($consulta);
		  
	  if(($re1))
			  echo "1|";
		  else
			  echo "|";
		
	}
	
	function validarFecha()
	{
	  global $con;
	  $bandera=$_POST["bandera"];
	  
	  //echo $bandera;
	  
	  switch($bandera)
	  {
		case 1:
		    $fechaInicio=$_POST["fechaInicio"];
		    $fechaFin=$_POST["fechaFin"];
			$idMapaCurricular=$_POST["idMapaCurricular"];
			
			$fechaI=cambiaraFechaMysql($fechaInicio);
			$fechaF=cambiaraFechaMysql($fechaFin);
		    if(isset($_POST["arreglo"]))
		    {	
			   $grados=$_POST["arreglo"];
		    }
		   
		    if($grados!="null")
		    {
				$grados=$_POST["arreglo"];
				$arreglo=explode(",",$grados);
				$tamano=sizeof($arreglo);
				
				$fechasPeriodo="SELECT fechaInicio,fechaFin FROM 4068_fechaCalendario WHERE idMapaCurricular=".$idMapaCurricular." AND idEtiqueta=10";
				$fechasP=$con->obtenerPrimeraFila($fechasPeriodo);
				
				$cFechaI=strtotime($fechaI);
			    $cFechaFin=strtotime($fechaF);
			    $fMinima=strtotime($fechasP[0]);
			    $fMaxima=strtotime($fechasP[1]);
				
				if((($cFechaI>=$fMinima) && ($cFechaI<= $fMaxima)) && (($cFechaFin>=$fMinima) && ($cFechaFin<=$fMaxima)))
				       echo "1|".$bandera."|1";
			       else
				       echo "|";//haber prueba
		    }
		    else
		    {
				$cFechaI=strtotime($fechaI);
			    $cFechaFin=strtotime($fechaF);
				
				$fechasPeriodo="SELECT fechaInicio,fechaFin FROM 4068_fechaCalendario WHERE idMapaCurricular=".$idMapaCurricular." AND idEtiqueta=10";
				$fechasP=$con->obtenerPrimeraFila($fechasPeriodo);
				$fMinima=strtotime($fechasP[0]);
			    $fMaxima=strtotime($fechasP[1]);
				
				if((($cFechaI>=$fMinima) && ($cFechaI<= $fMaxima)) && (($cFechaFin>=$fMinima) && ($cFechaFin<=$fMaxima)))
				{
					$idGrado=$_POST["idGrado"];
					
					$fechasGrado="select idFechaCalendario, idEtiqueta,fechaInicio,fechaFin,idGrado  from 4068_fechaCalendario where idMapaCurricular=".$idMapaCurricular."  and idGrado=".$idGrado." and idEtiqueta not in 
								  (select idEtiqueta from 4068_fechaCalendario where idetiqueta=1 and idMapaCurricular=".$idMapaCurricular." and idGrado=".$idGrado.")";
					
					$resFilas=$con->obtenerFilas($fechasGrado);
					$filas=$con->filasAfectadas;
					if($filas> 0)
					{
						$minFechasInicio="select min(fechaInicio) from 4068_fechaCalendario where idMapaCurricular=".$idMapaCurricular."  and idGrado=".$idGrado." and idEtiqueta not in 
										 (select idEtiqueta from 4068_fechaCalendario where idetiqueta=1 and idMapaCurricular=".$idMapaCurricular." and idGrado=".$idGrado.")";
						$minima=$con->obtenerValor($minFechasInicio);
						
						$maxFechaInicio="select max(fechaInicio) from 4068_fechaCalendario where idMapaCurricular=".$idMapaCurricular."  and idGrado=".$idGrado." and idEtiqueta not in 
									   (select idEtiqueta from 4068_fechaCalendario where idetiqueta=1 and idMapaCurricular=".$idMapaCurricular." and idGrado=".$idGrado.")";
						$maximaInicio=$con->obtenerValor($maxFechaInicio);	
						
						$maxFechaFin="select max(fechaFin) from 4068_fechaCalendario where idMapaCurricular=".$idMapaCurricular."  and idGrado=".$idGrado." and idEtiqueta not in 
									  (select idEtiqueta from 4068_fechaCalendario where idetiqueta=1 and idMapaCurricular=".$idMapaCurricular." and idGrado=".$idGrado.")";
						$maximaFin=$con->obtenerValor($maxFechaFin);	
						
						if($maximaInicio> $maximaFin)
						{
							$maxima=$maximaInicio;
						}
						else
						{
							$maxima=$maximaFin;
						}
						
						$cFechaI=strtotime($fechaI);
						$cFechaFin=strtotime($fechaF);
						$fMinima=strtotime($minima);
						$fMaxima=strtotime($maxima);
						
						if(($cFechaI<=$fMinima) && ($cFechaFin>=$fMaxima)) 
							echo "1|".$bandera."|1";
						else
							echo "1|".$bandera."|2";//haber prueba
					}
					else
					{
						echo "1|".$bandera."|1";	
					}			       
				}
				else
				{
					echo "|";//haber prueba
				}
			}
			
		break;
		
		case 2:
			$fechaInicio=$_POST["fechaInicio"];
		    $fechaFin=$_POST["fechaFin"];
			$idMapaCurricular=$_POST["idMapaCurricular"];
			
			$fechaI=cambiaraFechaMysql($fechaInicio);
			$fechaF=cambiaraFechaMysql($fechaFin);
			
			
			 $fechaMinima="select min(fechaInicio) from 4068_fechaCalendario where idMapaCurricular=".$idMapaCurricular." and idEtiqueta=1";
			 $minima=$con->obtenerValor($fechaMinima);
			
			 if($minima=="")
			 {
			 	$minima=0;
			 }
			 
			 $fechaMaxima="select max(fechaFin) from 4068_fechaCalendario where idMapaCurricular=".$idMapaCurricular." and idEtiqueta=1";
			 $maxima=$con->obtenerValor($fechaMaxima);
			
			 if($minima=="")
			 {
			 	$minima=0;
			 }
				
				
			 $cFechaI=strtotime($fechaI);
			 $cFechaFin=strtotime($fechaF);
			 $fMinima=strtotime($minima);
			 $fMaxima=strtotime($maxima);
			 
			 //echo $fechaI.">=".$minima.") && (".$fechaI."<= ".$maxima.")) && ((".$fechaF.">=".$minima.") && (".$fechaF."<=".$maxima;
			 //echo $cFechaI.">=".$fMinima.") && (".$cFechaI."<= ".$fMaxima.")) && ((".$cFechaFin.">=".$fMinima.") && (".$cFechaFin."<=".$fMaxima;
			 //este es el if que se forma creo que hay erroetes checa,minima 14/12 y maqxima 1/12?, creoq ue hay error no?
			 if((($cFechaI>=$fMinima) && ($cFechaI<= $fMaxima)) && (($cFechaFin>=$fMinima) && ($cFechaFin<=$fMaxima)))
				echo "1|".$bandera."";
			 else
				echo "|";//haber prueba
		
		break;
		
		case 3:
			$fechaInicio=$_POST["fechaInicio"];
			$idMapaCurricular=$_POST["idMapaCurricular"];
			
			$fechaI=cambiaraFechaMysql($fechaInicio);
			
			$fechaMinima="select min(fechaInicio) from 4068_fechaCalendario where idMapaCurricular=".$idMapaCurricular." and idEtiqueta=1";
		    $minima=$con->obtenerValor($fechaMinima);
			
		    if($minima=="")
		    {
			  $minima=0;
			}
			
			 $fechaMaxima="select max(fechaFin) from 4068_fechaCalendario where idMapaCurricular=".$idMapaCurricular." and idEtiqueta=1";
			 $maxima=$con->obtenerValor($fechaMaxima);
			
			 if($minima=="")
			 {
			 	$minima=0;
			 }
			 
			 
			 $cFechaI=strtotime($fechaI);
			 $fMinima=strtotime($minima);
			 $fMaxima=strtotime($maxima);
			
			 
			 if(($cFechaI>=$fMinima) && ($cFechaI<= $fMaxima))
				echo "1|".$bandera."";
			 else
				echo "|";//haber prueba
			
		break;
		case 4:
			 $fechaInicio=$_POST["fechaInicio"];
			 $idMapaCurricular=$_POST["idMapaCurricular"];
			 $fechaI=cambiaraFechaMysql($fechaInicio);
			 
			 
			 if(isset($_POST["arreglo"]))
			 {	
				$grados=$_POST["arreglo"];
			 }
			 
			 if($grados!="null")
			 {
				 
				$grados=$_POST["arreglo"];
				$arreglo=explode(",",$grados);
				$tamano=sizeof($arreglo);

				$gradosConfl="";
				$gradosError="";
				for($x=0;$x<$tamano;$x++)
				{
				   $idGrado=$arreglo[$x];
				   $consulNombre="select leyenda from 4014_grados where idGrado=".$idGrado;
				   $nombre=$con->obtenerValor($consulNombre);
					
				   $fechasGrado="select fechaInicio,fechaFin from 4014_grados where idGrado=".$idGrado;
				   $fechasG=$con->obtenerPrimeraFila($fechasGrado);
				   
				   
				   if($fechasG[0]=="" && $fechasG[1]=="")
				   {
					  $mensaje=$nombre." :No cuenta con fechas de inicio<br>";
					  
					  if($gradosConfl=="")
					  	$gradosConfl="<font color='#FF0000'>*</font>".$mensaje;
					  else
					  	$gradosConfl.="<font color='#FF0000'>*</font>".$mensaje;
						
				   }
				   else
				   {
				   		$cFechaI=strtotime($fechaI);
			       		$fMinima=strtotime($fechasG[0]);
			       		$fMaxima=strtotime($fechasG[1]);
				   
						if(($cFechaI>=$fMinima) && ($cFechaI<= $fMaxima))
						{
						}
						else
						{
							$mensaje2=$nombre."&nbsp;:Esta Fecha no esta dentro del rango de fechas del grado<br>";
							if($gradosError=="")
					  			$gradosError="<font color='#FF0000'>*</font>".$mensaje2;
					  		else
					  			$gradosError.="<font color='#FF0000'>*</font>".$mensaje2;
						}
				   }
				}
				
				if($gradosConfl=="" && $gradosError=="")
				{
					echo "1|".$bandera;
				}
				else
				{
					echo "2|".$bandera."|2|".$gradosConfl."|".$gradosError;
				}
			 
			 }
			 else
			 {
			 	 $idGrado=$_POST["idGrado"];
				 
				 $fechasGrado="select fechaInicio,fechaFin from 4014_grados where idGrado=".$idGrado;
				 $fechasG=$con->obtenerPrimeraFila($fechasGrado);
				   
                   $cFechaI=strtotime($fechaI);
			       $fMinima=strtotime($fechasG[0]);
			       $fMaxima=strtotime($fechasG[1]); 
				   
				   if(($cFechaI>=$fMinima) && ($cFechaI<= $fMaxima))
				       echo "1|".$bandera."";
			       else
				       echo "2|".$bandera."|3";
				
			 }
			 
		break;
		case 5:
			 $fechaInicio=$_POST["fechaInicio"];
			 $fechaFin=$_POST["fechaFin"];
			 $idMapaCurricular=$_POST["idMapaCurricular"];
			 
			 $fechaI=cambiaraFechaMysql($fechaInicio);
			 $fechaF=cambiaraFechaMysql($fechaFin);
			 
			 if(isset($_POST["arreglo"]))
			 {	
				$grados=$_POST["arreglo"];
			 }
			 
			 if($grados!="null")
			 {
				$grados=$_POST["arreglo"];
				$arreglo=explode(",",$grados);
				$tamano=sizeof($arreglo);
				$gradosConfl="";
				$gradosError="";
				for($x=0;$x<$tamano;$x++)
				{
				   $idGrado=$arreglo[$x];
				   $consulNombre="select leyenda from 4014_grados where idGrado=".$idGrado;
				   $nombre=$con->obtenerValor($consulNombre);
					
				   $fechasGrado="select fechaInicio,fechaFin from 4014_grados where idGrado=".$idGrado;
				   $fechasG=$con->obtenerPrimeraFila($fechasGrado);
					
					if($fechasG[0]=="" && $fechasG[1]=="")
				   {
					  $mensaje=$nombre." :No cuenta con fechas de inicio<br>";
					  
					  if($gradosConfl=="")
					  	$gradosConfl="<font color='#FF0000'>*</font>".$mensaje;
					  else
					  	$gradosConfl.="<font color='#FF0000'>*</font>".$mensaje;
						
				   }
				   else
				   {
				   		$cFechaI=strtotime($fechaI);
			       		$fMinima=strtotime($fechasG[0]);
			       		$fMaxima=strtotime($fechasG[1]);
						
						$cFechaI=strtotime($fechaI);
					    $cFechaFin=strtotime($fechaF);
					    $fMinima=strtotime($fechasG[0]);
					    $fMaxima=strtotime($fechasG[1]);
				   
						if((($cFechaI>=$fMinima) && ($cFechaI<= $fMaxima)) && (($cFechaFin>=$fMinima) && ($cFechaFin<=$fMaxima)))
						{
						}
						else
						{
							$mensaje2=$nombre."&nbsp;:Esta Fecha no esta dentro del rango de fechas del grado<br>";
							if($gradosError=="")
					  			$gradosError="<font color='#FF0000'>*</font>".$mensaje2;
					  		else
					  			$gradosError.="<font color='#FF0000'>*</font>".$mensaje2;
						}
				   }
				}
				
				if($gradosConfl=="" && $gradosError=="")
				{
					echo "1|".$bandera;
				}
				else
				{
					echo "2|".$bandera."|2|".$gradosConfl."|".$gradosError;
				}	
			 
			 }
			 else
			 {
			 
			 	 $idGrado=$_POST["idGrado"];
				 
				 $fechasGrado="select fechaInicio,fechaFin from 4014_grados where idGrado=".$idGrado;
				 $fechasG=$con->obtenerPrimeraFila($fechasGrado);
				  
                 $cFechaI=strtotime($fechaI);
				 $cFechaFin=strtotime($fechaF);
			     $fMinima=strtotime($fechasG[0]);
			     $fMaxima=strtotime($fechasG[1]); 
				   
				 if((($cFechaI>=$fMinima) && ($cFechaI<= $fMaxima)) && (($cFechaFin>=$fMinima) && ($cFechaFin<=$fMaxima)))
				     echo "1|".$bandera."";
			     else
				     echo "2|".$bandera."|3";//haber prueba
				
			 }
			
		break;
		case 6:
			$fechaInicio=$_POST["fechaInicio"];
			//$fechaFin=$_POST["fechaFin"];
			 $idMapaCurricular=$_POST["idMapaCurricular"];
			 
			 $fechaI=cambiaraFechaMysql($fechaInicio);
			 //$fechaF=cambiaraFechaMysql($fechaFin);
			 
			 if(isset($_POST["arreglo"]))
			 {	
				$grados=$_POST["arreglo"];
			 }
			 
			 if($grados!="null")
			 {
				 
				$grados=$_POST["arreglo"];
				//echo $grados;
				
				$arreglo=explode(",",$grados);
				
				$tamano=sizeof($arreglo);
//				$tamano=$tamano-1;
//				echo $tamano;
				//$tamano=$_POST["tamano"];
				//echo $tamano;
				for($x=0;$x<$tamano;$x++)
				{
					//echo $x;
					$idGrado=$arreglo[$x];
					//echo $idGrado;
					
				   $fechaMinima="select min(fechaInicio) from 4068_fechaCalendario where idMapaCurricular=".$idMapaCurricular." and idEtiqueta=1 and idGrado=".$idGrado;
				   //echo $fechaMinima;
				   $minima=$con->obtenerValor($fechaMinima);
				   if($minima=="")
				   {
					  $consulNombre="select leyenda from 4014_grados where idGrado=".$idGrado;
					  $nombre=$con->obtenerValor($consulNombre);
					  
					  echo "2|".$nombre."|";
				   }
				   
				   $fechaMaxima="select max(fechaFin) from 4068_fechaCalendario where idMapaCurricular=".$idMapaCurricular." and idEtiqueta=1 and idGrado=".$idGrado;
			       $maxima=$con->obtenerValor($fechaMaxima);
			
			       if($minima=="")
			       {
			 	   	  $consulNombre="select leyenda from 4014_grados where idGrado=".$idGrado;
					  $nombre=$con->obtenerValor($consulNombre);
					  
					  echo "2|".$nombre."|";
					 
			       }
			   
				   $cFechaI=strtotime($fechaI);
				   //$cFechaFin=strtotime($fechaF);
			       $fMinima=strtotime($minima);
			       $fMaxima=strtotime($maxima);
				   
				   if(($cFechaI>=$fMinima) && ($cFechaI<= $fMaxima))
				       echo "1|".$bandera."|";
			       else
				       echo "|";//haber prueba
				}
			 
			 }
			 else
			 {
			 
			 	 $idGrado=$_POST["idGrado"];
                 //echo $idGrado;
//				 return;
				  $fechaMinima="select min(fechaInicio) from 4068_fechaCalendario where idMapaCurricular=".$idMapaCurricular." and idEtiqueta=1 and idGrado=".$idGrado;
				  $minima=$con->obtenerValor($fechaMinima);
				   if($minima=="")
				   {
					  
					  echo "|";
				   }
				   
				   $fechaMaxima="select max(fechaFin) from 4068_fechaCalendario where idMapaCurricular=".$idMapaCurricular." and idEtiqueta=1 and idGrado=".$idGrado;
			       $maxima=$con->obtenerValor($fechaMaxima);
			
			       if($minima=="")
			       {
			 	   	 
					  echo "|";
			       }
			 	  
                   $cFechaI=strtotime($fechaI);
				   //$cFechaFin=strtotime($fechaF);
			       $fMinima=strtotime($minima);
			       $fMaxima=strtotime($maxima); 
				   
				    if(($cFechaI>=$fMinima) && ($cFechaI<= $fMaxima))
				       echo "1|".$bandera."";
			       else
				       echo "|";//haber prueba
				
			 }
		break;
		case 10:
		    $fechaInicio=$_POST["fechaInicio"];
		    $fechaFin=$_POST["fechaFin"];
			$idMapaCurricular=$_POST["idMapaCurricular"];
			
			$fechaI=cambiaraFechaMysql($fechaInicio);
			$fechaF=cambiaraFechaMysql($fechaFin);
			$idGrado=$_POST["idGrado"];
			
			$conDatosMapa="select idPrograma,ciclo from 4029_mapaCurricular where idMapaCurricular=".$idMapaCurricular ;
			$datosM=$con->obtenerPrimeraFila($conDatosMapa);
			
			$idPrograma=$datosM[0];
			$idCiclo=$datosM[1];
			
			$fechasGrados="SELECT min(fechaInicio),max(fechaInicio) FROM 4014_grados WHERE idPrograma=".$idPrograma." AND ciclo=".$idCiclo;
			$resGrados=$con->obtenerPrimeraFila($fechasGrados);
			
			if($resGrados[0]=="" && $resGrados[1]=="")
			{
				echo "1|".$bandera."|1";
			}
			else
			{
				$minima=$resGrados[0];
				$maxima=$resGrados[1];
				
				//$fechasGrado="select fechaInicio,fechaFin  from 4068_fechaCalendario where idMapaCurricular=".$idMapaCurricular." and idEtiqueta not in 
//							  (select idEtiqueta from 4068_fechaCalendario where idetiqueta=1 and idMapaCurricular=".$idMapaCurricular.")";
//				
//				$resFilas=$con->obtenerFilas($fechasGrado);
//				$filas=$con->filasAfectadas;
//				
//				if($filas > 0)
//				{
//					$minFechasInicio="select min(fechaInicio) from 4068_fechaCalendario where idMapaCurricular=".$idMapaCurricular." and idEtiqueta not in 
//									 (select idEtiqueta from 4068_fechaCalendario where idetiqueta=10 and idMapaCurricular=".$idMapaCurricular.")";
//					$minima=$con->obtenerValor($minFechasInicio);
//					
//					$maxFechaInicio="select max(fechaInicio) from 4068_fechaCalendario where idMapaCurricular=".$idMapaCurricular." and idEtiqueta not in 
//								   (select idEtiqueta from 4068_fechaCalendario where idetiqueta=10 and idMapaCurricular=".$idMapaCurricular." )";
//					$maximaInicio=$con->obtenerValor($maxFechaInicio);	
//					
//					$maxFechaFin="select max(fechaFin) from 4068_fechaCalendario where idMapaCurricular=".$idMapaCurricular." and idEtiqueta not in 
//								  (select idEtiqueta from 4068_fechaCalendario where idetiqueta=10 and idMapaCurricular=".$idMapaCurricular.")";
//					$maximaFin=$con->obtenerValor($maxFechaFin);	
//					
//					if($maximaInicio> $maximaFin)
//					{
//						$maxima=$maximaInicio;
//					}
//					else
//					{
//						$maxima=$maximaFin;
//					}
					
					
					$cFechaI=strtotime($fechaI);
					$cFechaFin=strtotime($fechaF);
					$fMinima=strtotime($minima);
					$fMaxima=strtotime($maxima);
					
					if(($cFechaI<=$fMinima) && ($cFechaFin>=$fMaxima)) 
						echo "1|".$bandera."|1";
					else
						echo "2|".$bandera."|1";//haber prueba
				//}
				//else
				//{
					//echo "1|".$bandera."|1";
				//}
			
			}
		break;
	  }
	 		
	}
	
	
	function validarProgramaCiclo()
	{
	  global $con;
	  $idCiclo=$_POST["idCiclo"];
	  
	  $consulta="SELECT idPrograma, nombrePrograma FROM 4004_programa WHERE ciclo=".$idCiclo." AND idPrograma NOT IN (SELECT idPrograma FROM 4029_mapaCurricular WHERE ciclo=".$idCiclo.")";
	  $res=$con->obtenerFilas($consulta);
	  $filas=$con->filasAfectadas;	  
	  if($filas>0)
			  echo "1|";
		  else
			  echo "2|";
		
	}
	
	function programaMateria()
	{
	  global $con;
	  $idCiclo=$_POST["idCiclo"];
	  $idMateria=$_POST["idMateria"];
	  $idPrograma=$_POST["idPrograma"];
	  $idGrado=$_POST["idGrado"];
	  
	  $consulta="insert into 4157_materiaVSPrograma (idMateria,idPrograma,ciclo,idGrado,estadoCambio) values ('".$idMateria."','".$idPrograma."','".$idCiclo."','".$idGrado."','1')";
	  //echo $consulta;
	  $res=$con->ejecutarConsulta($consulta);
	  if($res)
			  echo "1|";
		  else
			  echo "2|";
		
	}
	
	function validarFechaAbierta()
	{
	  global $con;
	  $bandera=$_POST["bandera"];
	  
	  //echo $bandera;
	  
	  switch($bandera)
	  {
		case 1:
		    $fechaInicio=$_POST["fechaInicio"];
		    $fechaFin=$_POST["fechaFin"];
			$idMapaCurricular=$_POST["idMapaCurricular"];
			
			$fechaI=cambiaraFechaMysql($fechaInicio);
			$fechaF=cambiaraFechaMysql($fechaFin);
			
			$fechasGrado="select idFechaCalendario, idEtiqueta,fechaInicio,fechaFin  from 4068_fechaCalendario where idMapaCurricular=".$idMapaCurricular." and idEtiqueta not in 
						  (select idEtiqueta from 4068_fechaCalendario where idetiqueta=1 and idMapaCurricular=".$idMapaCurricular.")";
			
			$resFilas=$con->obtenerFilas($fechasGrado);
			$filas=$con->filasAfectadas;
			if($filas >0)
			{
				$minFechasInicio="select min(fechaInicio) from 4068_fechaCalendario where idMapaCurricular=".$idMapaCurricular." and idEtiqueta not in 
                                 (select idEtiqueta from 4068_fechaCalendario where idetiqueta=1 and idMapaCurricular=".$idMapaCurricular." )";
				$minima=$con->obtenerValor($minFechasInicio);
				
				$maxFechaInicio="select max(fechaInicio) from 4068_fechaCalendario where idMapaCurricular=".$idMapaCurricular." and idEtiqueta not in 
                               (select idEtiqueta from 4068_fechaCalendario where idetiqueta=1 and idMapaCurricular=".$idMapaCurricular." )";
	            $maximaInicio=$con->obtenerValor($maxFechaInicio);	
				
				$maxFechaFin="select max(fechaFin) from 4068_fechaCalendario where idMapaCurricular=".$idMapaCurricular."  and idEtiqueta not in 
							  (select idEtiqueta from 4068_fechaCalendario where idetiqueta=1 and idMapaCurricular=".$idMapaCurricular." )";
                $maximaFin=$con->obtenerValor($maxFechaFin);	
				
				if($maximaInicio> $maximaFin)
				{
					$maxima=$maximaInicio;
				}
				else
				{
					$maxima=$maximaFin;
				}
				
				
				$cFechaI=strtotime($fechaI);
			    $cFechaFin=strtotime($fechaF);
			    $fMinima=strtotime($minima);
			    $fMaxima=strtotime($maxima);
				
				if(($cFechaI<=$fMinima) && ($cFechaFin>=$fMaxima)) 
					echo "1|".$bandera."|1";
				else
					echo "1|".$bandera."|2";//haber prueba
			}
			else
			{
			
				echo "1|".$bandera."|1";
			}
			
		break;
		
		case 2:
			$fechaInicio=$_POST["fechaInicio"];
		    $fechaFin=$_POST["fechaFin"];
			$idMapaCurricular=$_POST["idMapaCurricular"];
			
			$fechaI=cambiaraFechaMysql($fechaInicio);
			$fechaF=cambiaraFechaMysql($fechaFin);
			
			
			 $fechaMinima="select min(fechaInicio) from 4068_fechaCalendario where idMapaCurricular=".$idMapaCurricular." and idEtiqueta=1";
			 $minima=$con->obtenerValor($fechaMinima);
			
			 if($minima=="")
			 {
			 	$minima=0;
			 }
			 
			 $fechaMaxima="select max(fechaFin) from 4068_fechaCalendario where idMapaCurricular=".$idMapaCurricular." and idEtiqueta=1";
			 $maxima=$con->obtenerValor($fechaMaxima);
			
			 if($minima=="")
			 {
			 	$minima=0;
			 }
				
				
			 $cFechaI=strtotime($fechaI);
			 $cFechaFin=strtotime($fechaF);
			 $fMinima=strtotime($minima);
			 $fMaxima=strtotime($maxima);
			 
			 //echo $fechaI.">=".$minima.") && (".$fechaI."<= ".$maxima.")) && ((".$fechaF.">=".$minima.") && (".$fechaF."<=".$maxima;
			 //echo $cFechaI.">=".$fMinima.") && (".$cFechaI."<= ".$fMaxima.")) && ((".$cFechaFin.">=".$fMinima.") && (".$cFechaFin."<=".$fMaxima;
			 //este es el if que se forma creo que hay erroetes checa,minima 14/12 y maqxima 1/12?, creoq ue hay error no?
			 if((($cFechaI>=$fMinima) && ($cFechaI<= $fMaxima)) && (($cFechaFin>=$fMinima) && ($cFechaFin<=$fMaxima)))
				echo "1|".$bandera."";
			 else
				echo "|";//haber prueba
		
		break;
		
		case 3:
			$fechaInicio=$_POST["fechaInicio"];
			$idMapaCurricular=$_POST["idMapaCurricular"];
			
			$fechaI=cambiaraFechaMysql($fechaInicio);
			
			$fechaMinima="select min(fechaInicio) from 4068_fechaCalendario where idMapaCurricular=".$idMapaCurricular." and idEtiqueta=1";
		    $minima=$con->obtenerValor($fechaMinima);
			
		    if($minima=="")
		    {
			  $minima=0;
			}
			
			 $fechaMaxima="select max(fechaFin) from 4068_fechaCalendario where idMapaCurricular=".$idMapaCurricular." and idEtiqueta=1";
			 $maxima=$con->obtenerValor($fechaMaxima);
			
			 if($minima=="")
			 {
			 	$minima=0;
			 }
			 
			 
			 $cFechaI=strtotime($fechaI);
			 $fMinima=strtotime($minima);
			 $fMaxima=strtotime($maxima);
			
			 
			 if(($cFechaI>=$fMinima) && ($cFechaI<= $fMaxima))
				echo "1|".$bandera."";
			 else
				echo "|";//haber prueba
			
		break;
		case 4:
			$fechaInicio=$_POST["fechaInicio"];
			$idMapaCurricular=$_POST["idMapaCurricular"];
			
			$fechaI=cambiaraFechaMysql($fechaInicio);
			
			$fechaMinima="select min(fechaInicio) from 4068_fechaCalendario where idMapaCurricular=".$idMapaCurricular." and idEtiqueta=1";
		    $minima=$con->obtenerValor($fechaMinima);
			
		    if($minima=="")
		    {
			  $minima=0;
			}
			
			 $fechaMaxima="select max(fechaFin) from 4068_fechaCalendario where idMapaCurricular=".$idMapaCurricular." and idEtiqueta=1";
			 $maxima=$con->obtenerValor($fechaMaxima);
			
			 if($minima=="")
			 {
			 	$minima=0;
			 }
			 
			 
			 $cFechaI=strtotime($fechaI);
			 $fMinima=strtotime($minima);
			 $fMaxima=strtotime($maxima);
			
			 
			 if(($cFechaI>=$fMinima) && ($cFechaI<= $fMaxima))
				echo "1|".$bandera."";
			 else
				echo "|";//haber prueba
			 
			 
		break;
		case 5:
			 $fechaInicio=$_POST["fechaInicio"];
			 $fechaFin=$_POST["fechaFin"];
			 $idMapaCurricular=$_POST["idMapaCurricular"];
			 
			 $fechaI=cambiaraFechaMysql($fechaInicio);
			 $fechaF=cambiaraFechaMysql($fechaFin);
			 
			 if(isset($_POST["arreglo"]))
			 {	
				$grados=$_POST["arreglo"];
			 }
			 
			 if($grados!="null")
			 {
				 
				$grados=$_POST["arreglo"];
				//echo $grados;
				
				$arreglo=explode(",",$grados);
				
				$tamano=sizeof($arreglo);
//				$tamano=$tamano-1;
//				echo $tamano;
				//$tamano=$_POST["tamano"];
				//echo $tamano;
				for($x=0;$x<$tamano;$x++)
				{
					//echo $x;
					$idGrado=$arreglo[$x];
					//echo $idGrado;
					
				   $fechaMinima="select min(fechaInicio) from 4068_fechaCalendario where idMapaCurricular=".$idMapaCurricular." and idEtiqueta=1 and idGrado=".$idGrado;
				   //echo $fechaMinima;
				   $minima=$con->obtenerValor($fechaMinima);
				   if($minima=="")
				   {
					  $consulNombre="select leyenda from 4014_grados where idGrado=".$idGrado;
					  $nombre=$con->obtenerValor($consulNombre);
					  
					  echo "2|".$nombre."|";
				   }
				   
				   $fechaMaxima="select max(fechaFin) from 4068_fechaCalendario where idMapaCurricular=".$idMapaCurricular." and idEtiqueta=1 and idGrado=".$idGrado;
			       $maxima=$con->obtenerValor($fechaMaxima);
			
			       if($minima=="")
			       {
			 	   	  $consulNombre="select leyenda from 4014_grados where idGrado=".$idGrado;
					  $nombre=$con->obtenerValor($consulNombre);
					  
					  echo "2|".$nombre."|";
					 
			       }
			   
				   $cFechaI=strtotime($fechaI);
				   $cFechaFin=strtotime($fechaF);
			       $fMinima=strtotime($minima);
			       $fMaxima=strtotime($maxima);
				   
				   if((($cFechaI>=$fMinima) && ($cFechaI<= $fMaxima)) && (($cFechaFin>=$fMinima) && ($cFechaFin<=$fMaxima)))
				       echo "1|".$bandera."|";
			       else
				       echo "|";//haber prueba
				}
			 
			 }
			 else
			 {
			 
			 	 $idGrado=$_POST["idGrado"];
                 //echo $idGrado;
//				 return;
				  $fechaMinima="select min(fechaInicio) from 4068_fechaCalendario where idMapaCurricular=".$idMapaCurricular." and idEtiqueta=1 and idGrado=".$idGrado;
				  $minima=$con->obtenerValor($fechaMinima);
				   if($minima=="")
				   {
					  
					  echo "|";
				   }
				   
				   $fechaMaxima="select max(fechaFin) from 4068_fechaCalendario where idMapaCurricular=".$idMapaCurricular." and idEtiqueta=1 and idGrado=".$idGrado;
			       $maxima=$con->obtenerValor($fechaMaxima);
			
			       if($minima=="")
			       {
			 	   	 
					  echo "|";
			       }
			 	  
                   $cFechaI=strtotime($fechaI);
				   $cFechaFin=strtotime($fechaF);
			       $fMinima=strtotime($minima);
			       $fMaxima=strtotime($maxima); 
				   
				    if((($cFechaI>=$fMinima) && ($cFechaI<= $fMaxima)) && (($cFechaFin>=$fMinima) && ($cFechaFin<=$fMaxima)))
				       echo "1|".$bandera."";
			       else
				       echo "|";//haber prueba
				
			 }
			
		break;
		case 6:
			$fechaInicio=$_POST["fechaInicio"];
			//$fechaFin=$_POST["fechaFin"];
			 $idMapaCurricular=$_POST["idMapaCurricular"];
			 
			 $fechaI=cambiaraFechaMysql($fechaInicio);
			 //$fechaF=cambiaraFechaMysql($fechaFin);
			 
			 if(isset($_POST["arreglo"]))
			 {	
				$grados=$_POST["arreglo"];
			 }
			 
			 if($grados!="null")
			 {
				 
				$grados=$_POST["arreglo"];
				//echo $grados;
				
				$arreglo=explode(",",$grados);
				
				$tamano=sizeof($arreglo);
//				$tamano=$tamano-1;
//				echo $tamano;
				//$tamano=$_POST["tamano"];
				//echo $tamano;
				for($x=0;$x<$tamano;$x++)
				{
					//echo $x;
					$idGrado=$arreglo[$x];
					//echo $idGrado;
					
				   $fechaMinima="select min(fechaInicio) from 4068_fechaCalendario where idMapaCurricular=".$idMapaCurricular." and idEtiqueta=1 and idGrado=".$idGrado;
				   //echo $fechaMinima;
				   $minima=$con->obtenerValor($fechaMinima);
				   if($minima=="")
				   {
					  $consulNombre="select leyenda from 4014_grados where idGrado=".$idGrado;
					  $nombre=$con->obtenerValor($consulNombre);
					  
					  echo "2|".$nombre."|";
				   }
				   
				   $fechaMaxima="select max(fechaFin) from 4068_fechaCalendario where idMapaCurricular=".$idMapaCurricular." and idEtiqueta=1 and idGrado=".$idGrado;
			       $maxima=$con->obtenerValor($fechaMaxima);
			
			       if($minima=="")
			       {
			 	   	  $consulNombre="select leyenda from 4014_grados where idGrado=".$idGrado;
					  $nombre=$con->obtenerValor($consulNombre);
					  
					  echo "2|".$nombre."|";
					 
			       }
			   
				   $cFechaI=strtotime($fechaI);
				   //$cFechaFin=strtotime($fechaF);
			       $fMinima=strtotime($minima);
			       $fMaxima=strtotime($maxima);
				   
				   if(($cFechaI>=$fMinima) && ($cFechaI<= $fMaxima))
				       echo "1|".$bandera."|";
			       else
				       echo "|";//haber prueba
				}
			 
			 }
			 else
			 {
			 
			 	 $idGrado=$_POST["idGrado"];
                 //echo $idGrado;
//				 return;
				  $fechaMinima="select min(fechaInicio) from 4068_fechaCalendario where idMapaCurricular=".$idMapaCurricular." and idEtiqueta=1 and idGrado=".$idGrado;
				  $minima=$con->obtenerValor($fechaMinima);
				   if($minima=="")
				   {
					  
					  echo "|";
				   }
				   
				   $fechaMaxima="select max(fechaFin) from 4068_fechaCalendario where idMapaCurricular=".$idMapaCurricular." and idEtiqueta=1 and idGrado=".$idGrado;
			       $maxima=$con->obtenerValor($fechaMaxima);
			
			       if($minima=="")
			       {
			 	   	 
					  echo "|";
			       }
			 	  
                   $cFechaI=strtotime($fechaI);
				   //$cFechaFin=strtotime($fechaF);
			       $fMinima=strtotime($minima);
			       $fMaxima=strtotime($maxima); 
				   
				    if(($cFechaI>=$fMinima) && ($cFechaI<= $fMaxima))
				       echo "1|".$bandera."";
			       else
				       echo "|";//haber prueba
				
			 }
		break;
		
	  }
	 		
	}
	
	function validarFechaMateria()
	{
	  global $con;
	  $idMapaCurricular=$_POST["idMapaCurricular"];
	  $nuevaFecha=$_POST["nuevaFecha"];
	  
	
	  $consultaMin="SELECT MIN(fechaInicio) FROM 4068_fechaCalendario WHERE idMapaCurricular=".$idMapaCurricular." AND idEtiqueta=1" ;
	  $minimo=$con->obtenerValor($consultaMin);
	  
	  $consultaMax="SELECT MAX(fechaFin) FROM 4068_fechaCalendario WHERE idMapaCurricular=".$idMapaCurricular." AND idEtiqueta=1" ;
	  $maximo=$con->obtenerValor($consultaMax);
	  //echo $consulta;
	 $nueva=cambiaraFechaMysql($nuevaFecha);
	 
	 $cFechaI=strtotime($minimo);
	 $cFechaFin=strtotime($maximo);
	 $nuevaFechaT=strtotime($nueva);
	 //echo $nuevaFechaT;
	 if(($nuevaFechaT>=$cFechaI) && ($nuevaFechaT<= $cFechaFin)) 
		 echo "1|";
	 else
		 echo "2|";//haber prueba
		
	}
	
	
	function guardarDiasMateria()
	{
	  global $con;
	  $idMapaCurricular=$_POST["idMapaCurricular"];
	  $dias=$_POST["cadenaDias"];
	  $idMateria=$_POST["idMateria"];
	  
	  $arreglo=explode('_',$dias);
	  $tamano=sizeof($arreglo);
	  
	  $consulta="begin";
	  $ct=0;
	  if($con->ejecutarConsulta($consulta))
	  {
		  $consulta="DELETE FROM 4161_materiaDias WHERE idMateria=".$idMateria." AND idMapaCurricular=".$idMapaCurricular;
		  if($con->ejecutarConsulta($consulta))
		  {
			for($y=0;$y< $tamano;$y++)
			{
				  $dia=$arreglo[$y];
				  
				  $conExiste="SELECT dia FROM 4161_materiaDias WHERE idMateria=".$idMateria." AND idMapaCurricular=".$idMapaCurricular." AND dia=".$dia ;
				  //echo $conExiste;
				  $valor=$con->obtenerValor($conExiste);
				  if($valor=="")
				  {
					  $query[$ct]="insert into 4161_materiaDias(idMateria,idMapaCurricular,dia) values ('".$idMateria."','".$idMapaCurricular."','".$dia."')";
					  $ct++;
				  }
			}
		  
		 
		 $query[$ct]="commit";
		 }
		 if($con->ejecutarBloque($query)) 
			 echo "1|";
		 else
			 echo "2|";//haber prueba
	  }
		
	}
	
	function obtenerElementosPerfil()
	{
	  global $con;
	  $id=$_POST["id"];
	  
	  $consulta="SELECT idElementoPerfilAutor,descParticipacion FROM 953_elementosPerfilesParticipacionAutor WHERE idPerfilAutor=".$id ;
	  $arreglo=$con->obtenerFilasArreglo($consulta);
	  
	  echo "1|".uEJ($arreglo);
	}
	
	function guardarPerfilParticipacion ()
	{
	  global $con;
	  $idMapaCurricular=$_POST["idMapaCurricular"];
	  $comboPerfil=$_POST["comboPerfil"];
	  $comboParticipacion=$_POST["comboParticipacion"];
	  $participacionInvitado=0;
	  if(isset($_POST["invitado"]))
	  		$participacionInvitado=$_POST["invitado"];
	  $consulta="UPDATE 4029_mapaCurricular SET idPerfilParticipacion='".$comboPerfil."',idParticipacionPrincipal='".$comboParticipacion."',idParticipacionInvitado='".$participacionInvitado."'  WHERE idMapaCurricular=".$idMapaCurricular ;
	  
	  if($con->ejecutarConsulta($consulta))
	  	 echo "1|";
	  else
	  	 echo "2|";
	}
	
	function compruebaFechaSemanas()
	{
		global $con;
		$idGrado=$_POST["idGrado"];
		$idMapaCurricular=$_POST["idMapaCurricular"];
		$fecha=$_POST["fchInicio"];
		$numSemanas=$_POST["numSemana"];
		
		$consulta="SELECT fechaInicio,fechaFin FROM 4068_fechaCalendario WHERE idGrado=".$idGrado." AND idMapaCurricular=".$idMapaCurricular." AND idEtiqueta=1";
		$fechas=$con->obtenerPrimeraFila($consulta);
		
		$fechaCompara=strtotime(cambiaraFechaMysql($fecha));
		$fechaInicio=strtotime($fechas[0]);
		$fechaFin=strtotime($fechas[1]);
		
		if(($fechaCompara >=$fechaInicio) && ($fechaCompara<=$fechaFin))
		{
			$numero=($numSemanas*7)-1;
			$fechaFinSemana=strtotime("+".$numero."day",($fechaCompara));
			$formatoFecha=date('d/m/Y',$fechaFinSemana);
			$formatoFechaFin=cambiaraFechaMysql($formatoFecha);
			if($fechaFinSemana > $fechaFin)
			{
				echo "1|3|".$formatoFecha;
			}
			else
			{
				echo "1|1|".$formatoFecha ;
			}
		}
		else
		{
			echo "2|";
		}
	}
	
	function obtenerFechas()
	{
		global $con;
		$idElemento=base64_decode($_POST["idElemento"]);
		$tipo=$_POST["tipo"];
		if($tipo==1)
			$consulta="select fechaInicio,fechaFin from 4014_grados where idGrado=".$idElemento;
		else
			$consulta="select mat.fechaInicio,mat.fechaFin,idPadre,idGrado,m.idPrograma from 4031_elementosMapa em,4029_mapaCurricular m,4013_materia mat where mat.idMateria=em.idMateria and m.idMapaCurricular=em.idMapaCurricular and idElementoMapa=".$idElemento;
		$fila=$con->obtenerPrimeraFila($consulta);
		$fInicio=$fila[0];
		if($fInicio!="")
			$fInicio=date("d/m/Y",strtotime($fInicio));
		$fFin=$fila[1];
		if($fFin!="")
			$fFin=date("d/m/Y",strtotime($fFin));
		$comp="";
		if($tipo!=1)
		{
			if($fila[2]=="0")
				$consulta="select fechaInicio,fechaFin from 4014_grados where idGrado=".$fila[3];
			else
				$consulta="select mat.fechaInicio,mat.fechaFin from 4031_elementosMapa em,4029_mapaCurricular mc,4013_materia mat where mat.idMateria=em.idMateria and mc.idMapaCurricular=em.idMapaCurricular and mc.idPrograma=".$fila[4]." and em.idMateria=".$fila[2];	
			$fila=$con->obtenerPrimeraFila($consulta);
			$fInicioPadre=$fila[0];
			if($fInicioPadre!="")
				$fInicioPadre=date("d/m/Y",strtotime($fInicioPadre));
			$fFinPadre=$fila[1];
			if($fFinPadre!="")
				$fFinPadre=date("d/m/Y",strtotime($fFinPadre));
				
			$consulta="select idMateria,idTipoComponente from 4031_elementosMapa em where em.idElementoMapa=".$idElemento;
			$filaElem=$con->obtenerPrimeraFila($consulta);
			if(($filaElem[1]==1)||($filaElem[1]==3))
			{
				$consulta="select min(m.fechaInicio),max(m.fechaFin) from 4031_elementosMapa em,4013_materia m where m.idMateria=em.idMateria and em.idPadre=".$filaElem[0];
				$filaFecha=$con->obtenerPrimeraFila($consulta);
				if($filaFecha[0]!="")
					$comp="|".date("d/m/Y",strtotime($filaFecha[0]))."|".date("d/m/Y",strtotime($filaFecha[1]));
				else
					$comp="||";
					
			}
			$comp="|".$fInicioPadre."|".$fFinPadre.$comp;
		}
		else
		{
			$conDatosGrado="SELECT idPrograma,ciclo FROM 4014_grados WHERE idGrado=".$idElemento;
			$datosG=$con->obtenerPrimeraFila($conDatosGrado);
			$idPrograma=$datosG[0];
			$idCiclo=$datosG[1];
			
			$conMapa="select idMapaCurricular from 4029_mapaCurricular where idPrograma=".$idPrograma." and ciclo=".$idCiclo;
			$idMapaCurricular=$con->obtenerValor($conMapa);
			if($idMapaCurricular=="")
				$idMapaCurricular="-1";
			//$consulta="select min(mat.fechaInicio),max(mat.fechaFin) from 4031_elementosMapa em,4013_materia mat where mat.idMateria=em.idMateria and em.idGrado=".$idElemento;
			$consulta="SELECT fechaInicio,fechaFin FROM 4068_fechaCalendario WHERE idMapaCurricular=".$idMapaCurricular." AND idEtiqueta=10";
			$fila=$con->obtenerPrimeraFila($consulta);
			$fInicioPadre=$fila[0];
			if($fInicioPadre!="")
				$fInicioPadre=date("d/m/Y",strtotime($fInicioPadre));
			$fFinPadre=$fila[1];
			if($fFinPadre!="")
				$fFinPadre=date("d/m/Y",strtotime($fFinPadre));
			$comp="|".$fInicioPadre."|".$fFinPadre;
		}
		
		echo "1|".$fInicio."|".$fFin.$comp;
	}
	
	function obtenerFechasInsc()
	{
		global $con;
		$idElemento=base64_decode($_POST["idElemento"]);
		$tipo=$_POST["tipo"];
		if($tipo==1)
			$consulta="select fechaInicioInsc,fechaFinInsc,fechaFin from 4014_grados where idGrado=".$idElemento;
		else
		{
			$consulta="select idMateria from 4031_elementosMapa where idElementoMapa=".$idElemento;
			$idMateria=$con->obtenerValor($consulta);
			$consulta="select fechaInicioInsc,fechaFinInsc,fechaFin from 4013_materia  where idMateria=".$idMateria;
		}
		$fila=$con->obtenerPrimeraFila($consulta);
		$fInicio=$fila[0];
		if($fInicio!="")
			$fInicio=date("d/m/Y",strtotime($fInicio));
		$fFin=$fila[1];
		if($fFin!="")
			$fFin=date("d/m/Y",strtotime($fFin));
		$fFinCurso=$fila[2];
		if($fFinCurso!="")
			$fFinCurso=date("d/m/Y",strtotime($fFinCurso));
		$comp="|".$fFinCurso;
		
		echo "1|".$fInicio."|".$fFin.$comp;
	}
	
	function guardarFechas()
	{
		global $con;

		$idElemento=base64_decode($_POST["idElemento"]);
		$tipo=$_POST["tipo"];
		$fInicio=$_POST["fInicio"];
		$fFin=$_POST["fFin"];
		$ajustarH=false;
		if(isset($_POST["ajustarH"]))
		{
			if($_POST["ajustarH"]==1)
				$ajustarH=true;
			else
				$ajustarH=false;
		}
		$noValidacion=false;
		if(isset($_POST["nValidacion"]))
			$noValidacion=true;
		$ajustarPadre=false;
		if(isset($_POST["ajustarPadre"]))
			$ajustarPadre=true;
		$x=0;
		$consulta[$x]="begin";
		$x++;
	
		if($tipo==1) //grados
		{
			$consulta[$x]="update 4014_grados set fechaInicio='".cambiaraFechaMysql($fInicio)."',fechaFin='".cambiaraFechaMysql($fFin)."' where idGrado=".$idElemento;
			$x++;
			if($ajustarH)
			{
				
				$query="select idPrograma from 4014_grados where idGrado=".$idElemento;
				$idPrograma=$con->obtenerValor($query);
				$query="select em.idElementoMapa,em.idMateria from 4031_elementosMapa em,4029_mapaCurricular mc where mc.idMapaCurricular=em.idMapaCurricular and em.idTipoHorario=1 and em.idGrado=".$idElemento." and idPrograma=".$idPrograma;
				
				$resMatHijas=$con->obtenerFilas($query);				
				while($filaMat=mysql_fetch_row($resMatHijas))
				{
					$consulta[$x]="update 4013_materia set fechaInicio='".cambiaraFechaMysql($fInicio)."',fechaFin='".cambiaraFechaMysql($fFin)."' where idMateria=".$filaMat[1];
					$x++;
					$consulta[$x]="update 965_actividadesUsuario set fechaInicio='".cambiaraFechaMysql($fInicio)."',fechaFin='".cambiaraFechaMysql($fFin)."' where idMateria=".$filaMat[1];
					$x++;

					ajustarHijosElementoMapa($filaMat[1],$idPrograma,$consulta,$x,cambiaraFechaMysql($fInicio),cambiaraFechaMysql($fFin));
				}
			}
		}
		else
		{
			$query="select idGrado,idPadre,noSemanas,idMapaCurricular,idMateria from 4031_elementosMapa where idElementoMapa=".$idElemento;
			$filaE=$con->obtenerPrimeraFila($query);
			if($fFin=='null')
				$fFin= date("Y-m-d",strtotime('+ '.((7*$filaE[2])-1).' days ',strtotime(cambiaraFechaMysql($fInicio))));
			else
				$fFin=cambiaraFechaMysql($fFin);
			if($noValidacion)
			{
				$consulta[$x]="update 4013_materia set fechaInicio='".cambiaraFechaMysql($fInicio)."',fechaFin='".$fFin."' where idMateria=".$filaE[4];
				$x++;
				$consulta[$x]="update 965_actividadesUsuario set fechaInicio='".cambiaraFechaMysql($fInicio)."',fechaFin='".$fFin."' where idMateria=".$filaE[4];
				$x++;
				if($ajustarPadre)
				{
					if($filaE[1]!=0)//
						ajustarPadreElementoMapa($fFin,$filaE[1],$filaE[3],1,$consulta,$x);
					else
						ajustarPadreElementoMapa($fFin,$filaE[0],$filaE[3],0,$consulta,$x);
				}
			}
			else
			{
				if($filaE[1]!=0)
				{
					$query="select fechaFin from 4013_materia where idMateria=".$filaE[1];
					$filaP=$con->obtenerPrimeraFila($query);
					$fFinPadre=strtotime($filaP[0]);
				}
				else
				{
					$query="select fechaFin from 4014_grados where idGrado=".$filaE[0];
					$filaP=$con->obtenerPrimeraFila($query);
					$fFinPadre=strtotime($filaP[0]);
				}
				if(strtotime($fFin)>$fFinPadre)
				{
					echo "2|".date("d/m/Y",strtotime($fFin));
					return;
				}
				else
				{
					$consulta[$x]="update 4013_materia set fechaInicio='".cambiaraFechaMysql($fInicio)."',fechaFin='".$fFin."' where idMateria=".$filaE[4];
					$x++;
					$consulta[$x]="update 965_actividadesUsuario set fechaInicio='".cambiaraFechaMysql($fInicio)."',fechaFin='".$fFin."' where idMateria=".$filaE[4];
					$x++;
				}
			}
			
			if($ajustarH)
			{
				$query="select em.idMateria,m.idPrograma from 4031_elementosMapa em,4013_materia m 
				where m.idMateria=em.idMateria and em.idElementoMapa=".$idElemento;
				
				$filaMat=$con->obtenerPrimeraFila($query);
				$idMateria=$filaMat[0];
				$idPrograma=$filaMat[1];
				ajustarHijosElementoMapa($idMateria,$idPrograma,$consulta,$x,cambiaraFechaMysql($fInicio),$fFin);
			}
		}
		$consulta[$x]="commit";
		$x++;
		if($con->ejecutarBloque($consulta))
			echo "1|";
		else
			echo "|";
	}
	
	function ajustarHijosElementoMapa($idMateria,$idPrograma,&$consulta,&$x,$fInicio,$fFin)
	{
		global $con;
		$query="select em.idElementoMapa,em.idMateria,em.idTipoHorario,em.noSemanas from 4031_elementosMapa em,4029_mapaCurricular mc where 
				mc.idMapaCurricular=em.idMapaCurricular and em.idPadre=".$idMateria." and  idPrograma=".$idPrograma;
		$resMatHijas=$con->obtenerFilas($query);				
		while($filaMat=mysql_fetch_row($resMatHijas))
		{
			if($filaMat[2]==1)
			{
				$consulta[$x]="update 4013_materia set fechaInicio='".$fInicio."',fechaFin='".$fFin."' where idMateria=".$filaMat[1];
				$x++;
				$consulta[$x]="update 965_actividadesUsuario set fechaInicio='".$fInicio."',fechaFin='".$fFin."' where idMateria=".$filaMat[1];
				$x++;
			}
			else
			{
				
				$nSemanasMateria=$filaMat[3];
				$fFinAux= date("Y-m-d",strtotime('+ '.((7*$nSemanasMateria)-1).' days ',strtotime(($fInicio))));
				$consulta[$x]="update 4013_materia set fechaInicio='".$fInicio."',fechaFin='".$fFinAux."' where idMateria=".$filaMat[1];
				$x++;
				$consulta[$x]="update 965_actividadesUsuario set fechaInicio='".$fInicio."',fechaFin='".$fFinAux."' where idMateria=".$filaMat[1];
				$x++;
			}
			
			ajustarHijosElementoMapa($filaMat[1],$idPrograma,$consulta,$x,$fInicio,$fFin);
		}
	}
	
	function ajustarPadreElementoMapa($fFin,$idPadre,$idMapaCurricular,$tipo,&$consulta,&$x)//1 Materia, 0 grado
	{
		global $con;
		if($tipo!=0)
		{
			$consulta[$x]="update 4013_materia set fechaFin='".$fFin."' where idMateria=".$idPadre." and idMapaCurricular=".$idMapaCurricular;
			$x++;
			$consulta[$x]="update 965_actividadesUsuario set fechaFin='".$fFin."' where idMateria=".$idPadre." and idMapaCurricular=".$idMapaCurricular;
			$x++;

			$query="select idGrado,idPadre from 4031_elementosMapa where idMateria==".$idPadre." and idMapaCurricular=".$idMapaCurricular;
			
			if($fila[1]!=0)
				ajustarPadreElementoMapa($fFin,$filaE[1],$idMapaCurricular,1,$consulta,$x);
			else
				ajustarPadreElementoMapa($fFin,$filaE[0],$idMapaCurricular,0,$consulta,$x);
				
		}
		else
		{
			$consulta[$x]="update 4014_grados set fechaFin='".$fFin."' where idGrado=".$idPadre;
			$x++;
			//ajustarPadreElementoMapa($fFin,$filaE[0],$idMapaCurricular);
		}
	}
	
	function guardarFechasInsc()
	{
		global $con;
		$idElemento=base64_decode($_POST["idElemento"]);
		$fInicio=$_POST["fInicio"];
		$fFin=$_POST["fFin"];
		$tipo=$_POST["tipo"];
		
		if($tipo==1)		
			$consulta="update 4014_grados set fechaInicioInsc='".cambiaraFechaMysql($fInicio)."', fechaFinInsc='".cambiaraFechaMysql($fFin)."' where idGrado=".$idElemento;
		else
		{
			$consulta="select idMateria from 4031_elementosMapa where idElementoMapa=".$idElemento;
			$idMateria=$con->obtenerValor($consulta);
			$consulta="update 4013_materia set fechaInicioInsc='".cambiaraFechaMysql($fInicio)."', fechaFinInsc='".cambiaraFechaMysql($fFin)."' where idMateria=".$idMateria;
		}
		if($con->ejecutarConsulta($consulta))			
			echo "1|";
		else
			echo "|";
	}
	
	
	function guardarBoletaMateria()
	{
		global $con;
		$idMateria=$_POST["idMateria"];
		$idGrado=$_POST["idGrado"];
		$boletas=$_POST["cadenaBoleta"];
		$arreglo=explode("_",$boletas);
		$tamano=sizeof($arreglo);
		
		$consulta="begin";
		$ct=0;
		if($con->ejecutarConsulta($consulta))
		{
			$query[$ct]="DELETE FROM 4167_boletaElemento WHERE idMateria=".$idMateria." AND idGrado=".$idGrado ;
			$ct++;
			for($x=0;$x<$tamano;$x++)
			{
				$idBoleta=$arreglo[$x];
				
				$query[$ct]="INSERT INTO 4167_boletaElemento(idMateria,idGrado,idBoleta)  VALUES('".$idMateria."','".$idGrado."','".$idBoleta."')" ;
				$ct++;
			}
		
		$query[$ct]="commit";
		if($con->ejecutarBloque($query))			
			echo "1|";
		else
			echo "|";
		}
	}
	
	
	function clonarMapaCurricular()
	{
		
		global $con;
		$cicloDestino=$_POST["cicloDestino"];
		$idMapaCurricular=$_POST["iM"];
		$listElementos=$_POST["listElementos"];
		$arrElem=explode(",",$listElementos);
		$consulta="SELECT idPrograma,ciclo FROM 4029_mapaCurricular WHERE idMapaCurricular=".$idMapaCurricular;
		$fila=$con->ObtenerPrimeraFila($consulta);
		$idProgramaOrigen=$fila[0];
		$cicloOrigen=$fila[1];
		$consulta="select * from 4029_mapaCurricular where ciclo=".$cicloDestino." and idPrograma=".$idProgramaOrigen;
		$filaAux=$con->obtenerPrimeraFila($consulta);
		if($filaAux)
		{
			$consulta="select nombrePrograma from 4004_programa where idPrograma=".$idProgramaOrigen;
			$nPrograma=$con->obtenerValor($consulta);
			echo "El programa ".$nPrograma." para el ciclo ".$cicloDestino." ya cuenta con un mapa curricular registrado"	;
			return;
		}
		$arreglo=array();
		$arreglo["MapaCurricular"]=1;
		if(sizeof($arrElem)>0)
		{
			foreach($arrElem as $e)	
			{
				$arreglo[$e]=1;
			}
		}
		
		/////------------
		$idProgramaOrigen;
		$cicloOrigen;
		$cicloDestino;
		$arreglo;
		
		
		$idMapaNuevo="-1";
		echo "1|".$idMapaNuevo;
		
		
		
	}
?>