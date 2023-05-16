<?php

	$lenguaje="1";//1.-ESPAÑOL;2.- INGLES
	if(isset($_POST["leng"]))
	{
		$lenguaje=$_POST["leng"];
		$_SESSION["leng"]=$lenguaje;
	}
	else
		if(isset($_SESSION["leng"]))
		{
			$lenguaje=$_SESSION["leng"];
		}
		else
			$_SESSION["leng"]="1";
	$login="";
	if(isset($_SESSION["idUsr"]))
	{
		if($_SESSION["idUsr"]!="-1")
		{
			$login=$_SESSION["login"];
		}
		else
			$_SESSION["idRol"]="'-1000_0','-1001_0'";
	}
	else
		$_SESSION["idRol"]="'-1000_0','-1001_0'";
	
	function mostrarSiLog()
	{
		global $login;
		if($login=="")
			echo	"style=\"display:none\"";
		else
			echo "style=\"display:''\"";
	}
	
	function ocultarSiLog()
	{
		global $login;
		if($login=="")
			echo	"style=\"display:''\"";
		else
			echo "style=\"display:none\"";
	} 

	function generarCabeceraMenu($titulo)
	{
		global $colorLetra;
		$cabecera='	
                  	<td  height=23 align="center"><span class="letraTituloMenuIzq">'.uE($titulo).'</span></td>
                   ';
		return $cabecera;
	}
	
	function generarOpciones($padre)
	{
		global $con;
		$consulta="select distinct(pO.textoOpcion),pO.paginaUrlDestino,pO.idOpcion from 811_menusVSOpciones mO, 809_opciones 
					pO  where pO.idOpcion=mO.idOpcion and pO.idIdioma=".$_SESSION["leng"]." and  mO.idMenu=".$padre." order by mO.orden";
		$filas=$con->obtenerFilas($consulta);
		$opciones="";
		while($fila=mysql_fetch_row($filas))
		{
			if(strpos($fila[1],"?idFormulario"))
			{
				
				$arrOpciones=explode('=',$fila[1]);
				$idFormulario=$arrOpciones[1];
				if(strpos($fila[1],"administrarHorarioUnidadApartado.php"))
					$opciones.='<li class="bg_list_un"><a href="javaScript:enviarFormularioAdmon('.$idFormulario.')">'.uE($fila[0]).'</a></li>';
				else
					$opciones.='<li class="bg_list_un"><a href="javaScript:enviarFormulario('.$idFormulario.')">'.uE($fila[0]).'</a></li>';
			}
			else
			{
				if(strpos($fila[1],"?idTipoProyecto"))
				{
					$arrOpciones=explode('=',$fila[1]);
					$idTipoProyecto=$arrOpciones[1];
					
				}
				else
					$opciones.='<li class="bg_list_un"><a href="'.$fila[1].'">'.uE($fila[0]).'</a></li>';
			}
		}
		return $opciones;
		
	}
	
	
	
?>
