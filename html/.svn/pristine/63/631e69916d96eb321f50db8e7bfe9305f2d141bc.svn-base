<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	
	$idFormulario=bD($_GET["iF"]);
	$idRegistro=bD($_GET["iR"]);
	$iRef=$_GET["iRef"];
	$nombreUnidades='';
	if($idRegistro!="-1")
	{
		$consulta="SELECT unidadesDestino,motivoIncompetencia FROM _554_tablaDinamica WHERE id__554_tablaDinamica=".$idRegistro;
		$fRegistro=$con->obtenerPrimeraFila($consulta);
		$listUnidades=$fRegistro[0];
		if($fRegistro[1]!=4)
		{
			$consulta="SELECT nombreUnidad FROM _17_tablaDinamica u
				  WHERE id__17_tablaDinamica in(".$listUnidades.") ORDER BY u.prioridad";
			
			$nombreUnidades=$con->obtenerListaValores($consulta);
		}
	}
	$lblResumen="Sin Carpeta Judicial Asignada";
	$consulta="SELECT i.apellidoMaterno,i.apellidoPaterno,i.nombre,
			(SELECT carpetaAdministrativa FROM 7006_carpetasAdministrativas WHERE idCarpeta=a.idCarpeta) AS carpetaJudicial,
			(SELECT nombreUnidad FROM _17_tablaDinamica WHERE id__17_tablaDinamica=a.idUnidadDestino)  AS unidadDestino,
			tipoAccion
			
			FROM 3250_asignacionIncompetencias a,_47_tablaDinamica i WHERE iFormulario=".$idFormulario." AND iRegistro=".$idRegistro."
			AND i.id__47_tablaDinamica=a.idImputado ORDER BY nombre, apellidoPaterno,apellidoMaterno";
			
	$res=$con->obtenerFilas($consulta);
	while($fila=mysql_fetch_row($res))			
	{
		$resumen=$fila[2]." ".$fila[1]." ".$fila[0]." [".($fila[5]==1?"Nueva carpeta":"Reaperturada")."]: ".$fila[3]." (".$fila[4].")";
		if($lblResumen=="Sin Carpeta Judicial Asignada")
			$lblResumen=$resumen;
		else
			$lblResumen.="<br>".$resumen;
	}
			
	
?>

var objInfo={};
var cadenaFuncionValidacion='prepararGuardado';

function inyeccionCodigo()
{
	
    gE('sp_8944').innerHTML='<?php echo $lblResumen?>';
	if(esRegistroFormulario())
    {
    	dE('opt_materiaDestinovch_1');
	    dE('opt_materiaDestinovch_2');
        var carpetaAdministrativa=gEN('_carpetaAdministrativavch')[0];
        dE('_unidadReceptoravch');
        gE('sp_9037').innerHTML='<?php echo $nombreUnidades?>';
        
        if(gE('idRegistroG').value=='-1')
        {
        	dE('_motivoIncompetenciavch');
            
            var arrImputados=eval(gE('lista_imputadosRemitearr').value);
            if(arrImputados.length==1)
            {
                gE('opt_imputadosRemitearr_'+arrImputados[0][0]).checked=true;
                
                selCheck(gE('opt_imputadosRemitearr_'+arrImputados[0][0]));
                
            }
		}
        else
        {
        	var valor=gE('_motivoIncompetenciavch').options[gE('_motivoIncompetenciavch').selectedIndex].value;
            
            if(valor=='40')
            {

            	hE('_unidadReceptoravch');
            }
        }
       
        
        
        
        
        function funcAjax()
        {
            var resp=peticion_http.responseText;
            arrResp=resp.split('|');
            if(arrResp[0]=='1')
            {
                objInfo=eval('['+arrResp[4]+']')[0];
                if(gE('idRegistroG').value=='-1')
                {
                	gE('opt_materiaDestinovch_'+objInfo.tipoMateria).checked=true;
                
                	gE('_materiaDestinovch').value=objInfo.tipoMateria;
                    if(objInfo.fiscaliaAsociada!='-1')
                    {
                        selElemCombo(gE('_fiscaliavch'),objInfo.fiscaliaAsociada);
                    }
                }
                
                if(objInfo.tipoMateria=='2')
                {
                    delElemCombo(gE('_tipoUnidadDestinovch'),'X');
                    delElemCombo(gE('_motivoIncompetenciavch'),'3');
                    
                }
                hE('_motivoIncompetenciavch');
                
            }
            else
            {
                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
            }
        }
        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=149&cA='+carpetaAdministrativa.value,true);
        
        
        
        asignarEvento('_fiscaliavch','change',function(cmb)
        													{
                                                            	definirEdificioDestino();
                                                            }
                      )
        
        asignarEvento('opt_materiaDestinovch_1','click',function(cmb)
        													{
                                                            	definirEdificioDestino();
                                                            }
                      )
        
        asignarEvento('_tipoUnidadDestinovch','change',function(cmb)
        													{
                                                            	definirEdificioDestino();
                                                            }
                      )
                      
		asignarEvento('_unidadReceptoravch','change',function(cmb)
        													{
                                                            	definirEdificioDestino();
                                                            }
                      )                      
                      
		asignarEvento('opt_materiaDestinovch_2','click',function(cmb)
        													{
                                                            	definirEdificioDestino();
                                                            }
                      )                      
                      
        asignarEvento('_motivoIncompetenciavch','change',function(cmb)
        													{
                                                            	//gE('_lugarInternamientovch').selectedIndex=0;
                                                                mE('div_8909');
                                                                mE('div_8910');
                                                                gE('_tipoUnidadDestinovch').setAttribute('val','obl');
                                                            	var valor=gE('_motivoIncompetenciavch').options[gE('_motivoIncompetenciavch').selectedIndex].value;
                                                                switch(parseInt(valor))
                                                                {
                                                                	case 0:
                                                                    	gE('opt_materiaDestinovch_'+(objInfo.tipoMateria=='1'?2:1)).checked=true;
                                                                        lanzarEvento('opt_materiaDestinovch_'+(objInfo.tipoMateria=='1'?2:1),'click');
                                                                    break;
                                                                    
                                                                    case 3:
                                                                    	gE('opt_materiaDestinovch_'+objInfo.tipoMateria).checked=true;
                                                                        lanzarEvento('opt_materiaDestinovch_'+objInfo.tipoMateria,'click');
                                                                        
                                                                        gE('_unidadReceptoravch').selectedIndex=0;
                                                                        dE('_unidadReceptoravch');
                                                                        gE('sp_9037').innerHTML='';
                                                                        
                                                                    break;
                                                                    case 4:
                                                                    
                                                                    	function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                                gE('opt_materiaDestinovch_'+objInfo.tipoMateria).checked=true;
                                                                                lanzarEvento('opt_materiaDestinovch_'+objInfo.tipoMateria,'click');
                                                                                gE('sp_9037').innerHTML='';
                                                                                oE('div_9033')
                                                                                oE('div_9035')
                                                                                oE('div_8909');
                                                                                oE('div_8910');
                                                                                gE('_tipoUnidadDestinovch').setAttribute('val','');
                                                                                gE('_unidadReceptoravch').selectedIndex=0;
                                                                                if(arrResp[1]!='-1')
                                                                                {
                                                                                	selElemCombo(gE('_unidadDestinovch'),arrResp[1]);
                                                                                }
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_formulariosDinamicos.php',funcAjax, 'POST','funcion=1&cA='+carpetaAdministrativa.value,true);
                                                                    	
                                                                    
                                                                    	
                                                                    break;
                                                                    case 40:
                                                                    	gE('opt_materiaDestinovch_'+objInfo.tipoMateria).checked=true;
                                                                        lanzarEvento('opt_materiaDestinovch_'+objInfo.tipoMateria,'click');
                                                                        gE('sp_9037').innerHTML='';
                                                                        oE('div_9033')
                                                                        oE('div_9035')
                                                                        oE('div_8909');
                                                                        oE('div_8910');
                                                                        gE('_tipoUnidadDestinovch').setAttribute('val','');
                                                                        gE('_unidadReceptoravch').selectedIndex=0;
                                                                    break;
                                                                    case 5:
                                                                    	if(objInfo.tipoMateria=='2')
                                                                        {
                                                                        	gE('opt_materiaDestinovch_1').checked=true;
                                                                            lanzarEvento('opt_materiaDestinovch_1','click');
                                                                        }
                                                                        else
                                                                        {
                                                                    		gE('opt_materiaDestinovch_'+objInfo.tipoMateria).checked=true;
	                                                                        lanzarEvento('opt_materiaDestinovch_'+objInfo.tipoMateria,'click');
                                                                        }
                                                                        gE('_unidadReceptoravch').selectedIndex=0;
                                                                        dE('_unidadReceptoravch');
                                                                        gE('sp_9037').innerHTML='';
                                                                    break;
                                                                    default:
                                                                    	gE('opt_materiaDestinovch_'+objInfo.tipoMateria).checked=true;
                                                                        lanzarEvento('opt_materiaDestinovch_'+objInfo.tipoMateria,'click');
                                                                    break;
                                                                    
                                                                    
                                                                    
                                                                }
                                                                
                                                               
                                                            }
        			)
        
        asignarEvento('_lugarInternamientovch','change',function(cmb)
        												{
                                                        	buscarDestinoPorCentroInternamiento();
                                                        }
                     )
        
        
        asignarEvento('opt_privadoLibertadvch_0','click',function(cmb)
        													{
                                                            	definirEdificioDestino();
                                                            }
                      )
        
         asignarEvento('opt_privadoLibertadvch_1','click',function(cmb)
        													{
                                                            	definirEdificioDestino();
                                                            }
                      )
   	} 
    else
    {
    	if((gE('sp_8943').innerHTML=='Por turno extraordinario violencia de género')||(gE('sp_8910').innerHTML=='Penal Adolescentes')||(gE('sp_8943').innerHTML=='Por mandato judicial - zona territorial'))
        {
        	oE('div_9033');
            oE('div_9035');

        }
        
        
        if(gE('sp_8943').innerHTML=='Por turno extraordinario violencia de género')
        {
        	
            oE('div_8917');
            oE('div_8920');
            oE('div_8909');
            oE('div_8910');
        }
        else
        {
        	oE('div_8945');
        }
    	if(gE('sp_8918').innerHTML=='No')
        {
        	oE('div_8916');
            oE('div_8919');
            
        }
        
        if(gE('sp_8943').innerHTML!='Otro')
        {
        	oE('div_8946');
        }
        
        gE('sp_9037').innerHTML='<?php echo $nombreUnidades?>';
        
    }
}

function definirEdificioDestino()
{
	gE('sp_9037').innerHTML='';

    var motivoIncompetencia=parseInt(gE('_motivoIncompetenciavch').options[gE('_motivoIncompetenciavch').selectedIndex].value);
	var materia=gE('opt_materiaDestinovch_1').checked?1:2; //1 Adultos 2 adolescentes
    if(materia==2)
    {
    	selElemCombo(gE('_unidadReceptoravch'),'4');
        dE('_unidadReceptoravch');
        if(motivoIncompetencia!='4')
	        determinarPosiblesUnidadesDestino();
        else
        	gE('sp_9037').innerHTML='';
    }
    else
    {
    	hE('_unidadReceptoravch');
        if(motivoIncompetencia=='4')
        {
        	selElemCombo(gE('_unidadReceptoravch'),'-1');
        }
        else
        {
        	if(motivoIncompetencia=='40')
            {
            	determinarPosiblesUnidadesDestinoEdificio();
            }
            else
            {
                var cmbTipoUnidad=gE('_tipoUnidadDestinovch');
                var tipoUnidadDestino=cmbTipoUnidad.options[cmbTipoUnidad.selectedIndex].value;
                switch(tipoUnidadDestino)
                {
                    case 'A': //Querella
                        selElemCombo(gE('_unidadReceptoravch'),'5');
                        dE('_unidadReceptoravch');
                        determinarPosiblesUnidadesDestino();
                    break;
                    case 'B': //Oficio
                        buscarDestinoPorFiscalia();
                    break;
                    case 'X': //Unidad 12
                        selElemCombo(gE('_unidadReceptoravch'),'5');
                        dE('_unidadReceptoravch');
                        determinarPosiblesUnidadesDestino();
                    break;
                    case 'M':  //Unidad 11
                        selElemCombo(gE('_unidadReceptoravch'),'10');
                        dE('_unidadReceptoravch');
                        determinarPosiblesUnidadesDestino();
                    break;
                }
        	}
        }
        
        
        
        
    }
 
 	
}

function buscarDestinoPorFiscalia()
{
	gE('sp_9037').innerHTML='';
    gE('_unidadReceptoravch').selectedIndex=-1;
	var unidadDestino=gE('_tipoUnidadDestinovch').options[gE('_tipoUnidadDestinovch').selectedIndex].value;
	var fiscalia=	gE('_fiscaliavch').options[gE('_fiscaliavch').selectedIndex].value;
    var lugarInternamiento='';
    if( (unidadDestino=='B') &&((fiscalia=='51')||(fiscalia=='85')) &&(!gE('opt_privadoLibertadvch_0').checked))
    {
    	if((gE('opt_privadoLibertadvch_1').checked)&&(gE('_lugarInternamientovch').selectedIndex!=-1))
        {
        	
        	lugarInternamiento=gE('_lugarInternamientovch').options[gE('_lugarInternamientovch').selectedIndex].value;
           
        } 
        else
	        return;
    }
    
    ejecutarBusquedaFiscalia(fiscalia,lugarInternamiento);
    
}

function buscarDestinoPorCentroInternamiento()
{
	//gE('sp_9037').innerHTML='';
    //gE('_unidadReceptoravch').selectedIndex=-1;
	var unidadDestino=gE('_tipoUnidadDestinovch').options[gE('_tipoUnidadDestinovch').selectedIndex].value;
	var fiscalia=	gE('_fiscaliavch').options[gE('_fiscaliavch').selectedIndex].value;
    var lugarInternamiento='';
    if( (unidadDestino=='B') &&((fiscalia=='51')||(fiscalia=='85')))
    {
    	if((gE('opt_privadoLibertadvch_1').checked)&&(gE('_lugarInternamientovch').selectedIndex!=-1))
        {
        	
        	lugarInternamiento=gE('_lugarInternamientovch').options[gE('_lugarInternamientovch').selectedIndex].value;
           	ejecutarBusquedaFiscalia(fiscalia,lugarInternamiento);
        } 
        
    }
    
   
    
}



function ejecutarBusquedaFiscalia(fiscalia,lugarInternamiento)
{
	
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {

        	hE('_unidadReceptoravch');
            selElemCombo(gE('_unidadReceptoravch'),arrResp[1]);     
                      
            if(arrResp[1]!='-1')	
            	dE('_unidadReceptoravch');
            determinarPosiblesUnidadesDestino();
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=228&lugarInternamiento='+lugarInternamiento+'&fiscalia='+fiscalia,true);
}

function determinarPosiblesUnidadesDestino()
{
	
    var tipoUnidad='D';
    var idEdificio=gE('_unidadReceptoravch').options[gE('_unidadReceptoravch').selectedIndex].value;
    
    var materia=gE('opt_materiaDestinovch_1').checked?1:2; //1 Adultos 2 adolescentes
    if(materia=='2')
    {
    	tipoUnidad='D';
    }
    else
    {

		tipoUnidad=gE('_tipoUnidadDestinovch').options[gE('_tipoUnidadDestinovch').selectedIndex].value;
        
        
    }
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var arrUgas=eval(''+arrResp[1]+'');
            var x;
            var lblUgas='';
            var idUgas='';
            for(x=0;x<arrUgas.length;x++)
            {
	            if(lblUgas=='')
                {
                	lblUgas=arrUgas[x][1];
                    idUgas=arrUgas[x][0];
                }
                else
                {
                	lblUgas+=', '+arrUgas[x][1];
                    idUgas+=','+arrUgas[x][0];
                }
            }
            
            gE('sp_9037').innerHTML=lblUgas;
            gEN('_unidadesDestinovch')[0].value=idUgas;

        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=229&tipoUnidad='+tipoUnidad+'&idEdificio='+idEdificio,true);
}

function determinarPosiblesUnidadesDestinoEdificio()
{
	
    var tipoUnidad='D';
    var idEdificio=gE('_unidadReceptoravch').options[gE('_unidadReceptoravch').selectedIndex].value;
    
    var materia=gE('opt_materiaDestinovch_1').checked?1:2; //1 Adultos 2 adolescentes
    if(materia=='2')
    {
    	tipoUnidad='D';
    }
    else
    {

		tipoUnidad='A,B,M';
        
        
    }
    function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var arrUgas=eval(''+arrResp[1]+'');
            var x;
            var lblUgas='';
            var idUgas='';
            for(x=0;x<arrUgas.length;x++)
            {
	            if(lblUgas=='')
                {
                	lblUgas=arrUgas[x][1];
                    idUgas=arrUgas[x][0];
                }
                else
                {
                	lblUgas+=', '+arrUgas[x][1];
                    idUgas+=','+arrUgas[x][0];
                }
            }
            
            gE('sp_9037').innerHTML=lblUgas;
            gEN('_unidadesDestinovch')[0].value=idUgas;

        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=229&tipoUnidad='+tipoUnidad+'&idEdificio='+idEdificio,true);
}

function determinarReclusorioDestino()
{
	gE('sp_9037').innerHTML='';
    gE('_unidadReceptoravch').selectedIndex=-1;
	if(gE('opt_privadoLibertadvch_1').checked)
    {
        hE('_unidadReceptoravch');
        var valor=gE('_lugarInternamientovch').options[gE('_lugarInternamientovch').selectedIndex].value;
        switch(valor)
        {
            case '00020008': //Centro Femenil de Reinserción Social (Santa Martha)
                selElemCombo(gE('_unidadReceptoravch'),'10');
                dE('_unidadReceptoravch');
            break;
            case '00020001': //Reclusorio Preventivo Varonil Norte
                selElemCombo(gE('_unidadReceptoravch'),'7');
                dE('_unidadReceptoravch');
            break;
            case '00020002': //Reclusorio Preventivo Varonil Oriente
                selElemCombo(gE('_unidadReceptoravch'),'8');
                dE('_unidadReceptoravch');
            break;
            case '00020003': //Reclusorio Preventivo Varonil Sur
                selElemCombo(gE('_unidadReceptoravch'),'9');
                dE('_unidadReceptoravch');
                
            break;
            default:
                selElemCombo(gE('_unidadReceptoravch'),'-1');
            break;
        }
        
    }
    else
    {
    	selElemCombo(gE('_unidadReceptoravch'),'5');
        dE('_unidadReceptoravch');
    }
    var motivoIncompetencia=parseInt(gE('_motivoIncompetenciavch').options[gE('_motivoIncompetenciavch').selectedIndex].value);
    if(motivoIncompetencia==5)
    	hE('_unidadReceptoravch');
    	
}


function prepararGuardado()
{
	hE('_fiscaliavch');
    hE('_unidadReceptoravch');
    hE('opt_materiaDestinovch_1');
    hE('opt_materiaDestinovch_2');
	return true;
}