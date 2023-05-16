<?php $baseDir="/var/www/html";


        $comandoInstalado=esSubversionInstalado();
        if($comandoInstalado)
        {
                $noRevision=actualizarSistema();
                if($noRevision!="")
                {
                         echo "Actualizado revisi&oacute;n: ".$noRevision."<br>\n\r";
                }
                else
                {
                        echo "No se pudo actualizar.<br>\n\r";
                }
        }
        else
        {
                global $baseDir;
                $arrSalida=array();
                $resultado=0;
                //$comando="su root -c \"apt-get install subversion -y 2>&1\"";//
				$comando="export HOME=/tmp && ".$baseDir."/tareasProgramadas/installSubversion.sh";
                exec($comando,$arrSalida,$resultado);
                $comandoInstalado=esSubversionInstalado();
                if($comandoInstalado)
                {
                         $noRevision=actualizarSistema();

                        if($noRevision!="")
                        {
                                echo "Actualizado revisi&oacute;n: ".$noRevision."<br>\n\r";
                        }
                        else
                        {
                                echo "No se pudo actualizar..<br>\n\r";
                        }
                }
                else
                {
                        echo "No se encuentra instalado Subversi&oacute;n.<br>\n\r";
                }

        }
	
	function actualizarSistema()
	{
			global $baseDir;
			$arrSalida=array();
			$resultado=0;
			$comando="export HOME=/tmp && export LC_CTYPE=en_US.UTF-8  && svn update ".$baseDir." 2>&1";//
			
			exec($comando,$arrSalida,$resultado);
			$actualizado="";
			foreach($arrSalida as $s)
			{
					$actualizado=(strpos($s,"At revisi")!==false)||(strpos($s,"En la revisi")!==false)||(strpos($s,"Updated to revis")!==false)||(strpos($s,"Actualizado a la revisi")!==false);
					if($actualizado)
					{
							$arrRevision=explode(" ",$s);
							$noRevision=$arrRevision[count($arrRevision)-1];

							$contenidoArchivo=leerContenidoArchivo($baseDir."/version.html");


							$arrContenidoArchivo=explode(" ",$contenidoArchivo);
							$contenidoArchivo="Release: ".$arrContenidoArchivo[1]."<br>Revisi&oacuten: ".$noRevision;

							escribirContenidoArchivo($baseDir."/showVersion.html",$contenidoArchivo);

							return $noRevision;
					}





			}

			return $actualizado;

	}
	
	function esSubversionInstalado()
	{
			$arrSalida=array();
			$resultado=0;
			$comando="export HOME=/tmp && svn 2>&1";//
			exec($comando,$arrSalida,$resultado);

			$comandoInstalado=false;
			foreach($arrSalida as $s)
			{
					$comandoInstalado=strpos($s,"svn help")!==false;
			}

			return $comandoInstalado;
	}


	function leerContenidoArchivo($archivo)
	{
		$cuerpoArchivo="";
		if(file_exists($archivo))
		{
			$fp=fopen($archivo,"r");
			while ( ($linea = fgets($fp)) !== false) 
			{
				
				$cuerpoArchivo.=$linea;
			}
			fclose($fp);
		}
		return $cuerpoArchivo;
	}
	
	function escribirContenidoArchivo($archivo,$contenido)
	{
		$fp=fopen($archivo,"w");
		
		if(!fwrite($fp,$contenido))
		{
			return false;
		}
		fclose($fp);
		
		
		
		return true;
	}

?>