<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");

	$fechaActual=date("Y-m-d")	;
	$horaActual=date("H:i");
	
	$idFormulario=bD($_GET["iF"]);
	$idRegistro=bD($_GET["iR"]);
	$idReferencia=($_GET["iRef"]);
	
	if($tipoMateria=="P")
	{
	
	$consulta="SELECT carpetaAdministrativa  FROM _491_tablaDinamica WHERE id__491_tablaDinamica=".$idReferencia;
	$cAdministrativa=$con->obtenerValor($consulta);
	
	$consulta="SELECT idActividad FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$cAdministrativa."'";
	$iActividad=$con->obtenerValor($consulta);
	
	
	
	
?>

var iActividad=<?php echo $iActividad?>;


function inyeccionCodigo()
{

	
}

  



function agregarParticipante()
{
	colapsarPanel();
	var iFiguraJuridica='4';
    var cAdministrativa='<?php echo $cAdministrativa?>';

    
    
	var obj={};
    obj.ancho='100%';
    obj.alto='100%';
    obj.modal=true;
    obj.url='../modeloPerfiles/registroFormularioV2.php';
    obj.funcionCerrar=function()
    				{
                    	restaurarPanel();
                    }
    obj.params=[
    				['accionCancelar','window.parent.accionCancelada()'],
                    ['cPagina','sFrm=true'],
                    ['pM','1'],
                    ['pE','1'],
                    ['actor','MTAx'],
                    ['idFormulario','47'],
                    ['idReferencia','-1'],
                    ['idRegistro','-1'],
                    ['figuraJuridica',iFiguraJuridica],
                    ['idActividad',iActividad],
                    ['funcPHPEjecutarNuevo',bE('participanteAgregado(idRegPadre)')]
               ];
    abrirVentanaFancy(obj);
}


function participanteAgregado(iParticipante,nombre)
{
	
	var opt=cE('option');
    opt.value=iParticipante;
    opt.text=nombre;
	gE('_imputadovch').options[gE('_imputadovch').options.length]=opt;
    gE('_imputadovch').selectedIndex=gE('_imputadovch').options.length-1;
    
}              
              
function funcionValidarGuardado()
{
	
    return true;
}      

function accionCancelada()
{
	restaurarPanel();
    cerrarVentanaFancy();
}   

function colapsarPanel()
{
	window.parent.gEx('panelListadoRegistros').setHeight(1);
    window.parent.gEx('vContenedor').doLayout();
}

function restaurarPanel()
{
	window.parent.gEx('panelListadoRegistros').setHeight(220);
    window.parent.gEx('vContenedor').doLayout();
}

<?php
	}
	else
	{
		
		$consulta="SELECT idExpediente FROM _493_tablaDinamica WHERE id__493_tablaDinamica=".$idRegistro;
		$idExpediente=$con->obtenerValor($consulta);
		
		$consulta="SELECT idActividad FROM 7006_carpetasAdministrativas WHERE idCarpeta=".$idExpediente;
		$idActividad=$con->obtenerValor($consulta);
		
		$consulta="SELECT GROUP_CONCAT(CONCAT(IF(p.nombre IS NULL,'',p.nombre),' ',IF(p.apellidoPaterno IS NULL,'',p.apellidoPaterno),' ',IF(p.apellidoMaterno IS NULL,'',p.apellidoMaterno))) AS actores 
					FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica p 
					WHERE r.idActividad=".$idActividad." AND r.idFiguraJuridica=2 AND  
					p.id__47_tablaDinamica=r.idParticipante ORDER BY p.nombre,p.apellidoPaterno,p.apellidoMaterno";
		$listaDemandados=$con->obtenerListaValores($consulta);
		
		$consulta="SELECT GROUP_CONCAT(CONCAT(IF(p.nombre IS NULL,'',p.nombre),' ',IF(p.apellidoPaterno IS NULL,'',p.apellidoPaterno),' ',IF(p.apellidoMaterno IS NULL,'',p.apellidoMaterno))) AS actores 
					FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica p 
					WHERE r.idActividad=".$idActividad." AND r.idFiguraJuridica=4 AND  
					p.id__47_tablaDinamica=r.idParticipante ORDER BY p.nombre,p.apellidoPaterno,p.apellidoMaterno";
		$listaActores=$con->obtenerListaValores($consulta);
		
		
		
		
?>	
var listaDemandados='<?php echo $listaDemandados?>';
var listaActores='<?php echo $listaActores?>';

function inyeccionCodigo()
{
	gE('sp_7839').innerHTML=listaActores;
    gE('sp_7840').innerHTML=listaDemandados;
	
}	
<?php
	}
?>