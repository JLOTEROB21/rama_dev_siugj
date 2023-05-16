<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	$fechaActual=date("Y-m-d")	;

	$iF=bD($_GET["iF"]);
	$iRef=($_GET["iRef"]);
	$iR=bD($_GET["iR"]);
	
	
	$consulta="SELECT * FROM _442_tablaDinamica WHERE id__442_tablaDinamica=".$iRef;
	$fSolicitud=$con->obtenerPrimeraFilaAsoc($consulta);
	$totalCopiasSimples=$fSolicitud["totalCopiasSimples"];
	$totalCopiasCertificadas=$fSolicitud["totalCopiasCertificadas"];
	
	$consulta="SELECT SUM(copiasSimplesEntregadas) FROM _449_tablaDinamica WHERE idReferencia=".$iRef;
	$totalSimplesEntregadas=$con->obtenerValor($consulta);
	if($totalSimplesEntregadas=="")
		$totalSimplesEntregadas=0;
	
	$consulta="SELECT SUM(copiasCertificadasEntregadas) FROM _449_tablaDinamica WHERE idReferencia=".$iRef;
	$totalCertificadasEntregadas=$con->obtenerValor($consulta);
	if($totalCertificadasEntregadas=="")
		$totalCertificadasEntregadas=0;
		
	$maxDisponiblesSimples=$totalCopiasSimples-$totalSimplesEntregadas;
	$maxDisponiblesCertificadas=$totalCopiasCertificadas-$totalCertificadasEntregadas;
	
	if($iR!=-1)
	{
		$consulta="SELECT copiasSimplesEntregadas,copiasCertificadasEntregadas FROM _449_tablaDinamica WHERE id__449_tablaDinamica=".$iR;
		$fRegistro=$con->obtenerPrimeraFila($consulta);
		$maxDisponiblesSimples+=$fRegistro[0];
		$maxDisponiblesCertificadas+=$fRegistro[1];
	}
	$consulta="SELECT contenido FROM 902_opcionesFormulario WHERE idGrupoElemento=7053 AND valor= ".$fSolicitud["parteSolicitante"];
	$tipoSolicitante=$con->obtenerValor($consulta);	
	$lblTipo="";
	$lblTipo2="";
	$lblTipo3="";
	if($fSolicitud["parteSolicitante"]==1)
	{
		$lblTipo="Tipo de figura juridica:";
		$consulta="SELECT contenido FROM 902_opcionesFormulario WHERE idGrupoElemento=7058 AND valor=".$fSolicitud["tipoFigura"];
		$lblTipo2=$con->obtenerValor($consulta);
		if($fSolicitud["tipoFigura"]==0)
		{
			$lblTipo3=$fSolicitud["nombre"]." ".$fSolicitud["apPaterno"]." ".$fSolicitud["apMaterno"];
			
		}
		else
		{
			$lblTipo3=obtenerNombreImplicado($fSolicitud["participanteSolicitante"]);
		}
		$tSolicitante=$fSolicitud["tipoFigura"];
	}
	else
	{
		$tSolicitante=$fSolicitud["tipoInstitucion"];
		$lblTipo="Tipo de institución:";
		$consulta="SELECT contenido FROM 902_opcionesFormulario WHERE idGrupoElemento=7059 AND valor=".$fSolicitud["tipoInstitucion"];
		$lblTipo2=$con->obtenerValor($consulta);
		switch($fSolicitud["tipoInstitucion"])
		{
			case 1:
			case 2:
			case 3:
				$consulta="SELECT nombre FROM _443_tablaDinamica WHERE id__443_tablaDinamica=".$fSolicitud["tribunalJuzgado"];
				$lblTipo3=$con->obtenerValor($consulta);
			break;
			case 4:
				$consulta="SELECT nombreUnidad FROM _17_tablaDinamica WHERE id__17_tablaDinamica=".$fSolicitud["salaPenal"];
				$lblTipo3=$con->obtenerValor($consulta);
			break;
			case 6:
				$consulta="SELECT nombreUnidad FROM _17_tablaDinamica WHERE id__17_tablaDinamica=".$fSolicitud["unidadGestion"];
				$lblTipo3=$con->obtenerValor($consulta);
			break;
			case 5:
				$consulta="SELECT nombre FROM 800_usuarios WHERE idUsuario=".$fSolicitud["juez"];
				$lblTipo3=$con->obtenerValor($consulta);
			break;
			case 0:
				$lblTipo3=$fSolicitud["otraDependencia"];
			break;
		}
	}
	$lblSolicitante='<table><tr height="27"><td width="180"><span class="TSJDF_Etiqueta">Tipo de solicitante:</span></td><td><span class="TSJDF_Control">'.$tipoSolicitante.'</span></td></tr>'.
					'<tr height="27"><td ><span class="TSJDF_Etiqueta">'.$lblTipo.'</span></td><td><span class="TSJDF_Control">'.$lblTipo2.'</span></td></tr>'.
					'<tr height="27"><td ><span class="TSJDF_Etiqueta">Nombre del solicitante:</span></td><td><span class="TSJDF_Control">'.$lblTipo3.'</span></td></tr></table>';
?>
var lblSolicitante='<?php echo $lblSolicitante?>';
var maxDisponiblesSimples=<?php echo $maxDisponiblesSimples?>;
var maxDisponiblesCertificadas=<?php echo $maxDisponiblesCertificadas?>;
var tCopiasSimples=maxDisponiblesSimples;
var tCopiasCertificadas=maxDisponiblesCertificadas;
var parteSolicitante=<?php echo $fSolicitud["parteSolicitante"] ?>;
var tipoSolicitante=<?php echo $tSolicitante ?>;
function inyeccionCodigo()
{
	
	gE('sp_7126').innerHTML=lblSolicitante;
	if(esRegistroFormulario())
    {
		var arrValoresSimples=[];
		var x;
        for(x=0;x<=maxDisponiblesSimples;x++)
        {
        	arrValoresSimples.push([x,x]);
        }
        
        var arrValoresCertificadas=[];

        for(x=0;x<=maxDisponiblesCertificadas;x++)
        {
        	arrValoresCertificadas.push([x,x]);
        }        
        
        if(gE('idRegistroG').value!='-1')
        {
        	tCopiasSimples=gE('_copiasSimplesEntregadasvch').options[gE('_copiasSimplesEntregadasvch').selectedIndex].value;
            tCopiasCertificadas=gE('_copiasCertificadasEntregadasvch').options[gE('_copiasCertificadasEntregadasvch').selectedIndex].value;
        }
        else
        {
        	gEx('f_sp_dteFechaEntregadte').setValue('<?php echo $fechaActual?>');
       		gEx('f_sp_dteFechaEntregadte').fireEvent('change', gEx('f_sp_dteFechaEntregadte'), gEx('f_sp_dteFechaEntregadte').getValue());
   		
        	selElemCombo(gE('_tipoOperacionvch'),'1');
        }
        
        rellenarCombo(gE('_copiasSimplesEntregadasvch'),arrValoresSimples,false);
        rellenarCombo(gE('_copiasCertificadasEntregadasvch'),arrValoresCertificadas,false);
        selElemCombo(gE('_copiasSimplesEntregadasvch'),tCopiasSimples);
        selElemCombo(gE('_copiasCertificadasEntregadasvch'),tCopiasCertificadas);
        lanzarEvento(gE('_copiasSimplesEntregadasvch'),'change',gE('_copiasSimplesEntregadasvch'));
        lanzarEvento(gE('_copiasCertificadasEntregadasvch'),'change',gE('_copiasCertificadasEntregadasvch'));

        if(!((parteSolicitante==1)||((parteSolicitante==2)&&(tipoSolicitante==5))))
        {
        	gE('opt_mostrarEntregadoAvch_1').checked=true;
            lanzarEvento(gE('opt_mostrarEntregadoAvch_1'),'click',gE('opt_mostrarEntregadoAvch_1'));
        }
        asignarEvento('_tipoOperacionvch','change',function()
        											{
                                                    	var valor=gE('_tipoOperacionvch').options[gE('_tipoOperacionvch').selectedIndex].value;
                                                        if(valor=='1')
                                                        {
                                                        	if(!((parteSolicitante==1)||((parteSolicitante==2)&&(tipoSolicitante==5))))
                                                            {
                                                                gE('opt_mostrarEntregadoAvch_1').checked=true;
                                                                lanzarEvento(gE('opt_mostrarEntregadoAvch_1'),'click',gE('opt_mostrarEntregadoAvch_1'));
                                                            }
                                                        }
                                                    }
        			)
        
        
        
   	}
    else
    {
    	if(gE('sp_7133').innerHTML=='Sí')
        {
        	oE('div_7127');
            oE('div_7129');
            oE('div_7128');
            oE('div_7130');
        }
        
        if((gE('sp_7128').innerHTML=='Sí')||(gE('sp_7128').innerHTML=='Si'))
        {
        	oE('div_7110');
            oE('div_7117');
            oE('div_7129');
            
            
            oE('div_7111');
            oE('div_7112');
            oE('div_7113');
            
            oE('div_7114');
            oE('div_7115');
            oE('div_7116');
            
            oE('div_7117');
            oE('div_7118');
            
            oE('div_7129');
            oE('div_7130');
        }
        
        if((gE('sp_7135').innerHTML=='Cancelación de copias'))
        {
        	oE('div_7110');
            oE('div_7117');
            oE('div_7129');
            
            
            oE('div_7111');
            oE('div_7112');
            oE('div_7113');
            
            oE('div_7114');
            oE('div_7115');
            oE('div_7116');
            
            oE('div_7117');
            oE('div_7118');
            
            oE('div_7129');
            oE('div_7130');
            
            oE('div_7127');
            oE('div_7128');
        }
        
    }
    
}