<?php
	session_start();

	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$idAuto="-1";
	$idFormulario=bD($_GET["iF"]);

	$idRegistro=bD($_GET["iR"]);


	$fechaActual=date("Y-m-d")	;
	$errorLLenadoActuacion="false";
	$horaActual=date("H:i");
	$nombreArchivo="";
	if($idRegistro!=-1)
	{
		$consulta="SELECT autoApelacion FROM _699_tablaDinamica WHERE id__699_tablaDinamica=".$idRegistro;
		$idAuto=$con->obtenerValor($consulta);
		if($idAuto=="")
			$idAuto=-1;
		$consulta="SELECT nomArchivoOriginal FROM 908_archivos WHERE idArchivo=".$idAuto;
		$nombreArchivo=$con->obtenerValor($consulta);
	
	
		$consulta="SELECT tipoActuacion FROM _699_tablaDinamica WHERE id__699_tablaDinamica=".$idRegistro;
		$fRegistro=$con->obtenerPrimeraFilaAsoc($consulta);
		
		
		if($fRegistro["tipoActuacion"]=="")
		{
			$errorLLenadoActuacion="true";
		}
		
	}
	



?>

var errorLLenadoActuacion=<?php echo $errorLLenadoActuacion?>;
var opcionSeleccionada='-1';

function inyeccionCodigo()
{
	gE('sp_15669').innerHTML='';
    if(esRegistroFormulario())
    {
    	if(gE('idRegistroG').value!='-1')
        {
        	opcionSeleccionada=gE('_tipoActuacionvch').options[gE('_tipoActuacionvch').selectedIndex].value;
            
        }
    	limpiarCombo(gE('_tipoActuacionvch'));
        
        
        
        
    	asignarEvento(gE('_promoventevch'),'change',function()
        							{
                                    	buscarActuacionesDisponibles()	;
                                    }
        			);                     
        
        
        asignarEvento(gE('_tipoActuacionvch'),'change',function(cmb)
        							{
                                    	var tipoActuacion=cmb.options[cmb.selectedIndex].value;
                                       	if(tipoActuacion=='17')
                                        {
                                        	mE('div_12527');
                                            mE('div_12528');
                                            gE('_medidaProvisionalvch').setAttribute('val','obl');
                                        }
                                        else
                                        {
                                        	oE('div_12527');
                                            oE('div_12528');
                                            gE('_medidaProvisionalvch').value='0';
                                            gE('_medidaProvisionalvch');
                                            gE('_medidaProvisionalvch').setAttribute('val','');
                                        }
                                        
                                        
                                        if(tipoActuacion=='25')
                                        {
                                        	mE('div_13061');
                                            mE('div_13062');
                                            gE('_autoApelacionvch').setAttribute('val','obl');
                                            mE('div_13063');
                                        }
                                        else
                                        {
                                        	oE('div_13061');
                                            oE('div_13062');
                                            oE('div_13063');
                                        	gE('_autoApelacionvch').setAttribute('val','');
                                        }
                                    }
        			); 
        
        asignarEvento(gE('opt_tipoAccionvch_1'),'click',function()
        							{
                                    	buscarActuacionesDisponibles();
                                    }
        			);    
        
         asignarEvento(gE('opt_tipoAccionvch_2'),'click',function()
        							{
                                    	buscarActuacionesDisponibles();
                                    }
        			);
        
        
		if(gEN('_cAdministrativavch')[0].value!='N/E')
        {
        	gEx('ext__carpetaAdministrativaActuacionesIntervinientesvch').setValue(gEN('_cAdministrativavch')[0].value);
            gE('_carpetaAdministrativaActuacionesIntervinientesvch').value=gEN('_cAdministrativavch')[0].value;
            gEx('ext__carpetaAdministrativaActuacionesIntervinientesvch').disable();
            funcionEventoCambio(gEx('ext__carpetaAdministrativaActuacionesIntervinientesvch'),true);
            function funcAjax(peticion_http)
            {
                var resp=peticion_http.responseText;
                arrResp=resp.split('|');
                if(arrResp[0]=='1')
                {
                    
                    
                    if(arrResp[1]!='-1')
                    {
                    	var _promoventevch=gE('_promoventevch');
                        
                        var sp=cE('span');
                        sp.setAttribute('class','SIUGJ_ControlEtiqueta');
                        sp.innerHTML=arrResp[2];
                        
                        var parentNode=_promoventevch.parentNode;
                        parentNode.removeChild(_promoventevch);
                        
                        var e=cE('input');
                        e.type='hidden';
                        e.name='_promoventevch';
                         e.id='_promoventevch';
                        e.value=arrResp[1];
                        parentNode.appendChild(e);
                        
                        parentNode.appendChild(sp);
                        
                    }
                    
                    
                }
                else
                {
                    msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                }
            }
            obtenerDatosWebV2('../modulosEspeciales_SIUGJ/paginasFunciones/funcionesScriptsFormularios.php',funcAjax, 'POST','funcion=2&cAdministrativa='+gE('_carpetaAdministrativaActuacionesIntervinientesvch').value,true);
            
            
            
            
			
        }
                        
        if(gE('idRegistroG').value=='-1')
        {
            if(gEx('f_sp_fechaRecepciondte')) 
            {
             	gEx('f_sp_fechaRecepciondte').setValue('<?php echo $fechaActual?>');
             	gEx('f_sp_fechaRecepciondte').fireEvent('change', gEx('f_sp_fechaRecepciondte'), gEx('f_sp_fechaRecepciondte').getValue());

             	gEx('f_sp_fechaRecepciondte').fireEvent('select', gEx('f_sp_fechaRecepciondte'));
             }

             if(gEx('f_sp_horaRectme'))
             {
	         	gEx('f_sp_horaRectme').setValue('<?php echo $horaActual?>');
             	gEx('f_sp_horaRectme').fireEvent('change', gEx('f_sp_horaRectme'), gEx('f_sp_horaRectme').getValue());
             }   
             
             
                  	
        }
        else
        {
        	
            
        
        	buscarActuacionesDisponibles(opcionSeleccionada);
            lanzarEvento('_tipoActuacionvch','change');  
        }
        
        <?php
		if(existeRol("'23_0'"))
		{
		?>
            gEx('f_sp_fechaRecepciondte').disable();
            gEx('f_sp_horaRectme').disable();
    	<?php
		}
		?>
        
    }
    else
    {
    	if(gE('sp_11177').innerHTML=='SOLICITUD DE EJECUCIÓN DE SENTENCIA')
        {
        	mE('div_12527');
           	mE('div_12528');
        }
        else
        {
        	oE('div_12527');
           	oE('div_12528');
            
        }
        
        
        if(gE('sp_11177').innerHTML=='REGISTRO DE APELACIÓN SOBRE AUTO')
        {
        	mE('div_13061');
            mE('div_13062');
        }
        else
        {
        	oE('div_13061');
            oE('div_13062');
            oE('div_13063');
        }
        
        
        if(errorLLenadoActuacion)
        {
        	gE('sp_15669').innerHTML='<a href="javascript:editRegistro()" style="color:#F00"><img src="../principalPortal/imagesSIUGJ/error.png" width="20" height="20"  /> Debe indicar el tipo de actuaci&oacute;n a realizar</a>';
        }
        
    }
}


function buscarActuacionesDisponibles(opcionSeleccionada)
{
	var _tipoActuacionvch=gE('_tipoActuacionvch');
    
    limpiarCombo(_tipoActuacionvch);
    
	var idParticipante=gE('_promoventevch').options?(gE('_promoventevch').options[gE('_promoventevch').selectedIndex].value):gE('_promoventevch').value;
    var tipoActuacion=gE('opt_tipoAccionvch_1').checked?'1':(gE('opt_tipoAccionvch_2').checked?2:0);
    
    
	var cadObj='{"cup":"'+gE('_carpetaAdministrativaActuacionesIntervinientesvch').value+'","idParticipante":"'+idParticipante+'","tipoActuacion":"'+tipoActuacion+'"}';
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
            var arrRegistros=eval(arrResp[1]);
            arrRegistros.splice(0,0,['-1','Seleccione']);
            llenarCombo(_tipoActuacionvch,arrRegistros);
            if(opcionSeleccionada)
            {
            	selElemCombo(_tipoActuacionvch,opcionSeleccionada);
                lanzarEvento('_tipoActuacionvch','change');  
        	}
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../modulosEspeciales_SIUGJ/paginasFunciones/funcionesScriptsFormularios.php',funcAjax, 'POST','funcion=1&cadObj='+cadObj,true);
	
}


function mostrarAutoApela()
{
	var idAuto='<?php echo $idAuto?>';
    var nombreArchivo='<?php echo $nombreArchivo?>';
    
	if(esRegistroFormulario())
	{
        idAuto=gE('_autoApelacionvch').options[gE('_autoApelacionvch').selectedIndex].value;
        if(idAuto=='-1')
        {	
            msgBox('Debe seleccionar el auto que desea observar');
            return;
        }
        nombreArchivo=gE('_autoApelacionvch').options[gE('_autoApelacionvch').selectedIndex].text;
        
       
	}
    
    var extension=nombreArchivo.split('.');
    window.parent.mostrarVisorDocumentoProceso(extension[extension.length-1],idAuto,null,nombreArchivo);   
}

function editRegistro()
{
	modificarRegistro(gE('idRegistroG').value);
}
