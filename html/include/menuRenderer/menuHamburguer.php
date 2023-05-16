<?php
	function inicializarMenuRenderer($menu,$tipoMenu,$nElemento)
	{

		if($tipoMenu==1)
		{
			
		
		}
		else
		{
			echo '	<li><a href="#"><span>'.($menu["icono"]!=""?"<img src='".$menu["icono"]."'>":"").'</span> '.$menu["titulo"]."</a>
						<ul class='dl-submenu'>";
			if(isset($menu["opciones"]))							
				echo generarOpcionesMenuHamburguesaVertical($menu["opciones"]);
			echo "		</ul>
					</li>";
			
		}
	}
	
	
	function generarOpcionesMenuHamburguesaVertical($arrOpciones)
	{
		
		foreach($arrOpciones as $opt)	
		{

			$img="";
			if(($opt["bullet"]!="")&&($opt["bullet"]!="NULL"))
				$img='<img src="../media/verBullet.php?id='.$opt["idOpcion"].'">&nbsp;';
				
			if(strpos($opt["url"],"?idFormulario")!==false)	
			{
				$arrDatos=explode("?idFormulario=",$opt["url"]);
				$opt["url"]="javascript:abrirPaginaIframe('../modeloProyectos/visorRegistrosProcesosV2.php',".$arrDatos[1].")";
			}
			
			if(strpos($opt["url"],"ingresarProceso(")!==false)	
			{
				$opt["url"]=str_replace("ingresarProceso(","ingresarProcesoIframeV2(",$opt["url"]);
			}
				
			echo '<li style="z-index:1000;" ><a href="'.$opt["url"].'" >'.$opt["texto"].'</a>';
			
			if(sizeof($opt["opciones"])>0)
			{
				echo "<ul class='dl-submenu'>";
				echo generarOpcionesMenuHamburguesaVertical($opt["opciones"]);
				echo "</ul>";
			}
			
			echo '</li>';

		}
	}
	
	
	
?>