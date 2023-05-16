<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$fechaActual=date("Y-m-d")	;
	$horaActual=date("H:i");
	$idFormulario=bD($_GET["iF"]);
	$idRegistro=bD($_GET["iR"]);
	$idReferencia=($_GET["iRef"]);
	$codigoInstitucion=$_SESSION["codigoInstitucion"];
	
	$idParticipante=-1;
	if($idRegistro!=-1)
	{
		$consulta="SELECT nombreApelante,carpetaAdministrativa FROM _451_tablaDinamica WHERE id__451_tablaDinamica=".$idRegistro;
		$fRegistro=$con->obtenerPrimeraFila($consulta);	
		$idParticipante=$fRegistro[0];
		$cAdministrativa=$fRegistro[1];
		
		$consulta="SELECT unidadGestion FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$cAdministrativa."'";
		$codigoInstitucion=$con->obtenerValor($consulta);
	}
	
	$consulta="SELECT idEstado FROM _451_tablaDinamica WHERE id__451_tablaDinamica=".$idRegistro;
	$idEstado=$con->obtenerValor($consulta);
	if($idEstado=="")
	{
		$idEstado=0;
	}
	
	
	$consulta="SELECT codigoUnidad,unidad FROM 817_organigrama";
	$arrUnidadGestion=$con->obtenerFilasArreglo($consulta);
	
	
	$consulta="SELECT tipoMateria FROM _17_tablaDinamica WHERE claveUnidad='".$codigoInstitucion."'";
	$tMateria=$con->obtenerValor($consulta);
	
	
	$consulta="SELECT claveUnidad,nombreUnidad FROM _17_tablaDinamica WHERE cmbCategoria=3 AND tipoMateria=".$tMateria." ORDER BY prioridad";
	$arrSalasPermitidas=$con->obtenerFilasArreglo($consulta);
?>

var arrSalasPermitidas=<?php echo $arrSalasPermitidas?>;
var salaPenalAntecede='';
var arrUnidadGestion=<?php echo $arrUnidadGestion?>;
var idEstado=<?php echo $idEstado?>;
var idParticipante=<?php echo $idParticipante?>;


var cadenaFuncionValidacion='funcionValidarGuardado';

function inyeccionCodigo()
{
	
	if(!esRegistroFormulario())
    {
    	gE('sp_7194').innerHTML=formatearCampoFormulario(gE('sp_7194').innerHTML);
        
        if(gE('sp_9781').innerHTML!='Si')
        {
        	oE('div_9782');
            oE('sp_9783');
        }
    }
    else
    {
     	asignarEvento(gE('opt_existeAntecedenteSalavch_1'),'click',function(val)
        														{
                                                                	
                                                                	if(((gE('_salaAntecedentevch').selectedIndex==0)||(gE('_salaAntecedentevch').selectedIndex==-1))&&(salaPenalAntecede!=''))
                                                                    {
                                                                    	selElemCombo(gE('_salaAntecedentevch'),salaPenalAntecede);
                                                                    }
                                                                }
        				)
    	
    
       asignarEvento(gE('_nombreApelantevch'),'change',buscarDomilicio)
       if(idEstado>=1.5)
       {
	       	gEx('ext__carpetaAdministrativavch').disable();
       }
       
       
       if(gEx('f_sp_fechaRecepciondte'))
        {
            gEx('f_sp_fechaRecepciondte').setValue('<?php echo $fechaActual?>');
         
            gEx('f_sp_fechaRecepciondte').fireEvent('change', gEx('f_sp_fechaRecepciondte'), gEx('f_sp_fechaRecepciondte').getValue());
            gEx('f_sp_fechaRecepciondte').fireEvent('select', gEx('f_sp_fechaRecepciondte'));
         }
         if(gEx('f_sp_horaRecepciontme'))
         {
             gEx('f_sp_horaRecepciontme').setValue('<?php echo $horaActual?>');
            gEx('f_sp_horaRecepciontme').fireEvent('change', gEx('f_sp_horaRecepciontme'), gEx('f_sp_horaRecepciontme').getValue());
         }
         
         gE('_carpetaApelacionvch').innerHTML=formatearCampoFormulario(Ext.util.Format.stripTags(gE('_carpetaApelacionvch').innerHTML));
       
       	gEx('ext__carpetaAdministrativavch').on('select',function(cmb,registro)
        													{
                                                            	buscarAntecenteSala(registro.data.id);
                                                            }
        										)
	
    	var _salaAntecedentevch=gE('_salaAntecedentevch');
        var x;
        for(x=0;x<_salaAntecedentevch.options.length;x++)
        {
        	if(_salaAntecedentevch.options[x].value!='-1')
            {
                if(existeValorMatriz(arrSalasPermitidas,_salaAntecedentevch.options[x].value)==-1)
                {
                    _salaAntecedentevch.options[x]=null;
                    x--;
                }
			}
        }
    }

    gE('sp_7272').innerHTML='';
    loadScript('../modulosEspeciales_SGJP/Scripts/cDireccionContacto.js.php?iF=<?php echo $idFormulario?>&iR=<?php echo $idRegistro?>', function()
    																		{
                                                                            	
                                                                            	var obj={};
                                                                                obj.idParticipante=idParticipante;
                                                                                obj.renderTo='sp_7272';
                                                                                obj.permiteEditar=esRegistroFormulario();                                                                             
                                                                                
                                                                                construirTableroDireccion(obj);
                                                                            }
				)
   
}  

function buscarDomilicio()
{
	var cmb=gE('_nombreApelantevch');
    var obj={};
    obj.idParticipante=cmb.options[cmb.selectedIndex].value;
    obj.renderTo='sp_7272';
    obj.permiteEditar=esRegistroFormulario();    
    construirTableroDireccion(obj);
    
}

function agregarParticipante()
{

	var iFiguraJuridica=gE('_figuraJuridicavch').options[gE('_figuraJuridicavch').selectedIndex].value;
    var cAdministrativa=gE('_carpetaAdministrativavch').value;
    
    if(iFiguraJuridica=='-1')
    {
    	msgBox('Debe indicar el tipo de figura jur&iacute;dica a agregar');
    	return;
    }
    
    if(cAdministrativa=='-1')
    {
    	msgBox('Debe indicar la carpeta judicial al cual pertenece el apelante a agregar');
    	return;
    }
    
	var obj={};
    obj.ancho='100%';
    obj.alto='100%';
    obj.modal=true;
    obj.url='../modeloPerfiles/registroFormularioV2.php';
    
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
                    ['idActividad',gE('sp_7269').innerHTML],
                    ['funcPHPEjecutarNuevo',bE('participanteAgregado(idRegPadre)')]
               ];
    abrirVentanaFancy(obj);
}


function participanteAgregado(iParticipante,nombre)
{
	
	var opt=cE('option');
    opt.value=iParticipante;
    opt.text=nombre;
	gE('_nombreApelantevch').options[gE('_nombreApelantevch').options.length]=opt;
    gE('_nombreApelantevch').selectedIndex=gE('_nombreApelantevch').options.length-1;
    buscarDomilicio();
}              
              
function funcionValidarGuardado()
{
	
    return true;
}      

function accionCancelada()
{
	
    cerrarVentanaFancy();
}    


function buscarAntecenteSala(cJudicial)
{
	salaPenalAntecede='';
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
         	if(arrResp[1]=='1')
            {
            	salaPenalAntecede=arrResp[2];
            	mE('div_9832');
                gE('sp_9832').innerHTML='Se ha detectado que la carpeta cuenta con antecedente en: '+formatearValorRenderer(arrUnidadGestion,arrResp[2])+' (TOCA: '+arrResp[3]+')';
            }
            else
            {  
            	oE('div_9832'); 
                gE('sp_9832').innerHTML='';
        	}
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=301&cJudicial='+cJudicial,true);
    
	
}    