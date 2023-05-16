<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$idFormulario=bD($_GET["iF"]);
	$idRegistro=bD($_GET["iR"]);

	$consulta="SELECT idRegistroFormato FROM 3000_formatosRegistrados WHERE idFormulario=".$idFormulario." AND idRegistro=0";
	$idRegistroFormato=$con->obtenerValor($consulta);
	if($idRegistroFormato=="")
		$idRegistroFormato=-1;

	$archivoBase=$baseDir."/modulosEspeciales_SGJP/formatos/formatoBase.html";
	$cuerpoDocumento=leerContenidoArchivo($archivoBase);
	
	$consulta="SELECT id__44_tablaDinamica,CONCAT(IF(claveTipoMarcador='','',CONCAT('[',claveTipoMarcador,'] ')),nombreMarcador) AS marcador,descripcion 
				FROM _44_tablaDinamica WHERE situacion=1";
	$arrTiposMarcadores=$con->obtenerFilasArreglo($consulta);
?>

var cadenaFuncionValidacion='registrarArregloMarcadores';

var arrTiposMarcadores=<?php echo $arrTiposMarcadores?>;
var arrMarcadores=[];
function inyeccionCodigo()
{
	
	
	CKEDITOR.instances["txtDocumento"]=CKEDITOR.instances["txt_txtPlantillaDocumentovch"];
	
	if(esRegistroFormulario())
	{
		if(gE('idRegistroG').value=='-1')
		{
			establecerValorTextEnriquecido('txt_txtPlantillaDocumentovch',bD('<?php echo bE($cuerpoDocumento)?>'))



		}
		else
		{
			if(gEN('_arrMarcadoresvch')[0].value!='')
				arrMarcadores=eval(bD(gEN('_arrMarcadoresvch')[0].value));

		}
   		
   		var hIdRegistroFormato=cE('input');
   		hIdRegistroFormato.type='hidden';
   		hIdRegistroFormato.id='idRegistroFormato';
   		hIdRegistroFormato.value='<?php echo $idRegistroFormato?>';
   		
   		
   		var hTipoFormato=cE('input');
   		hTipoFormato.type='hidden';
   		hTipoFormato.id='tipoFormato';
   		hTipoFormato.value='0';
   		
   		
    	var hIdRegistro=cE('input');
   		hIdRegistro.type='hidden';
   		hIdRegistro.id='idRegistro';
   		hIdRegistro.value='0';
   		
   		
   		document.body.appendChild(hIdRegistroFormato);
   		document.body.appendChild(hTipoFormato);
   		document.body.appendChild(hIdRegistro);
    }
}

function registrarArregloMarcadores()
{
	var aMarcadores='';
    var x;
    var e;
    for(x=0;x<arrMarcadores.length;x++)
    {
    	e="['"+arrMarcadores[x][0]+"','"+arrMarcadores[x][1]+"','"+cv(arrMarcadores[x][2],false,true)+"']";
        if(aMarcadores=='')
        	aMarcadores=e;
        else
        	aMarcadores+=','+e;
        
        
    }
    aMarcadores='['+aMarcadores+']';
	gEN('_arrMarcadoresvch')[0].value=bE(aMarcadores);
    return true;
}

