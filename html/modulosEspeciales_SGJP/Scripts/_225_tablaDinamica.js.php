<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$consulta="SELECT id__5_tablaDinamica,nombreTipo FROM _5_tablaDinamica";
	$arrFiguras=$con->obtenerFilasArreglo($consulta);
?>

var arrFiguras=<?php echo $arrFiguras?>;

Ext.onReady(inicializar);

function inicializar()
{
	if(esRegistroFormulario())
    {
    	asignarEvento('opt_tipoPersonavch_1','click',function()
                                                        {
                                                            gE('sp_3024').innerHTML='Nombre';
                                                            gE('_nombrevch').setAttribute('size',30);
                                                            
                                                        }
                    );
		asignarEvento('opt_tipoPersonavch_2','click',function()
                                                        {
                                                            gE('sp_3024').innerHTML='Raz&oacute;n social:';
                                                            gE('_nombrevch').setAttribute('size',60);
                                                            
                                                        }
                    );   
                    
                    
		
        setTimeout(	function()
        			{
                    	var fechaNacimiento=gEx('f_sp_fechaNacimientodte');
                        
                        if(fechaNacimiento)
                        {
                        
                            fechaNacimiento.on('change',function()
                                                        {
                                                            calcularEdad()
                                                        }
                                              )
                        } 
                    },1000
        			) 
                               
                                     
    }
	if((esRegistroFormulario())&&(gE('idRegistroG').value=='-1'))
    {
	    if(gEN('_idUsuariovch')[0].value!='-1')
    		cargarDatosParticipante();
    }
    else
    {
    	if(!esRegistroFormulario())
        {
        	gE('div_3036').style.width='280px';
            gE('div_3042').style.width='280px';
            
            gE('div_3056').style.width='280px';
            gE('div_3057').style.width='280px';
            
        	if(gE('sp_4834').innerHTML=='Moral')
            {
            	oE('div_3026');
                oE('div_3027');
                oE('div_3028');
                oE('div_3029');
                oE('div_4835');
                oE('div_4836');
                oE('div_4837');
                oE('div_4838');
                gE('sp_3024').innerHTML='Raz&oacute;n social:';
                
                oE('div_5004');
                oE('div_5005');
                oE('div_5006');
                oE('div_5007');
                oE('div_5008');
                oE('div_5009');
                oE('div_5010');
                oE('div_5011');
                
            }
            
            if((gE('sp_4836').innerHTML=='Sí')||(gE('sp_4836').innerHTML=='No especificado'))
            {
            	oE('div_4837');
                oE('div_4838');
            }
            
            if(gE('sp_3071').innerHTML=='Sí')
            {
            	oE('div_3052');
                oE('div_3053');
                oE('div_3056');
                oE('div_3060');
                oE('div_3063');
                oE('div_3066');
                oE('div_3067');
                oE('div_3054');
                oE('div_3057');
                oE('div_3061');
                oE('div_3064');
                oE('div_3068');
                oE('div_3069');
                
                oE('div_3055');
                oE('div_3089');
                oE('div_3062');
                oE('div_3065');
                
                oE('div_5018');
                oE('div_5020');
                oE('div_5022');
                oE('div_5019');
                oE('div_5021');
                oE('div_5023');
                
            }
        }
    }
	
}

function cargarDatosParticipante()
{
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
          	var obj= eval("["+arrResp[1]+"]")[0];
           
           	gE('opt_tipoPersonavch_'+obj.tipoPersona).checked=true;
        
            lanzarEvento('opt_tipoPersonavch_'+obj.tipoPersona,'click');   
            
            
            gE('sp_3110').innerHTML=formatearValorRenderer(arrFiguras,obj.tipoParticipante);
            gE('_figuraJuridicavch').innerHTML=obj.tipoParticipante;
            gEN('_figuraJuridicavch')[0].value=obj.tipoParticipante;
            gE('_nombrevch').value=obj.nombre;
            gE('_apPaternovch').value=obj.apPaterno;
            gE('_apMaternovch').value=obj.apMaterno;
            
            gE('opt_esMexicanovch_'+obj.nacionalidadMexicana).checked=true;
            gE('_otraNacionalidadvch').value=obj.especifiqueNacionalidad;
            gE('_rfcvch').value=obj.rfc;
            gE('_curpvch').value=obj.curp;
            
            selElemCombo(gE('_generovch'),obj.genero);
            if(obj.fechaNacimiento!='')
            {
                gEx('f_sp_fechaNacimientodte').setValue(obj.fechaNacimiento);
                gEx('f_sp_fechaNacimientodte').fireEvent('change', gEx('f_sp_fechaNacimientodte'), gEx('f_sp_fechaNacimientodte').getValue());
			}            
            
            gE('_edadint').value=obj.edad;
            
            gE('_entreCallevch').value=obj.domicilioPersonal.entreCalle;
            gE('_yCallevch').value=obj.domicilioPersonal.yCalle;
            gE('_otrasReferenciasmem').value=obj.domicilioPersonal.otrasReferencias;
            
            gE('_entreCalleNotificacionvch').value=obj.domicilioNotificaciones.entreCalle;
            gE('_yCalleNotificacionvch').value=obj.domicilioNotificaciones.yCalle;
            gE('_otrasReferenciasNotificacionmem').value=obj.domicilioNotificaciones.otrasReferencias;
            

            lanzarEvento('opt_esMexicanovch_'+obj.nacionalidadMexicana,'click');  
            selElemCombo(gE('_nacionalidadvch'),obj.nacionalidad);
            lanzarEvento('_nacionalidadvch','select');  
            gE('_callevch').value=obj.domicilioPersonal.calle;
            gE('_noExtvch').value=obj.domicilioPersonal.noExt;
            gE('_noIntvch').value=obj.domicilioPersonal.noInt;
            gE('_coloniavch').value=obj.domicilioPersonal.colonia;
            gE('_cpint').value=obj.domicilioPersonal.cp;
            selElemCombo(gE('_estadovch'),obj.domicilioPersonal.estado);
            obtenerMunicipiosEstadoDomilioPersonal(obj.domicilioPersonal.municipio);
            gE('_localidadvch').value=obj.domicilioPersonal.localidad;
            gE('opt_siNovch_'+obj.mismoDomicilioNotificaciones).checked=true;
            
            lanzarEvento('opt_siNovch_'+obj.mismoDomicilioNotificaciones,'click');
            
            gE('_calleNotificacionvch').value=obj.domicilioNotificaciones.calle;
            gE('_noExtNotificacionvch').value=obj.domicilioNotificaciones.noExt;
            gE('_noIntNotificacionvch').value=obj.domicilioNotificaciones.noInt;
            gE('_coloniaNotificacionvch').value=obj.domicilioNotificaciones.colonia;
            gE('_cpNotificacionint').value=obj.domicilioNotificaciones.cp;
            selElemCombo(gE('_estadoNotificacionvch'),obj.domicilioNotificaciones.estado);
            obtenerMunicipiosEstadoDomilioNotificacion(obj.domicilioNotificaciones.municipio);
            gE('_localidadNotificacionvch').value=obj.domicilioNotificaciones.localidad;
            
            var arrTelefonos=[];
            var x;
            for(x=0;x<obj.telefonos.length;x++)
            {
	            arrTelefonos.push(['-1','-1',obj.telefonos[x].tipoTelefono,obj.telefonos[x].lada,obj.telefonos[x].telefono,obj.telefonos[x].extension]);
            }
            gEx('grid_3074').getStore().loadData(arrTelefonos);
            
            var arrMail=[];
            var x;
            for(x=0;x<obj.mail.length;x++)
            {
	            arrMail.push(['-1','-1',obj.mail[x].email]);
            }
            gEx('grid_3076').getStore().loadData(arrMail);
            
            var arrRed=[];
            var x;
            for(x=0;x<obj.redesSociales.length;x++)
            {
	            arrRed.push(['-1','-1',obj.redesSociales[x].redSocial,obj.redesSociales[x].idRedSocial]);
            }
            gEx('grid_3078').getStore().loadData(arrRed);
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=88&iE='+gEN('_idEventovch')[0].value+'&iU='+gEN('_idUsuariovch')[0].value,true);
}


function obtenerMunicipiosEstadoDomilioPersonal(municipio)
{
	var _estadovch=gE('_estadovch');
	var cveEstado=_estadovch.options[_estadovch.selectedIndex].value;
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var arrMunicipios=eval(arrResp[1]);
            llenarCombo(gE('_municipiovch'),arrMunicipios,true);
            selElemCombo(gE('_municipiovch'),municipio);
            
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=89&cveEstado='+cveEstado,true);
    

}

function obtenerMunicipiosEstadoDomilioNotificacion(municipio)
{
	var _estadovch=gE('_estadoNotificacionvch');
	var cveEstado=_estadovch.options[_estadovch.selectedIndex].value;
	function funcAjax()
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
        	var arrMunicipios=eval(arrResp[1]);
            llenarCombo(gE('_municipioNotificacionvch'),arrMunicipios,true);
            selElemCombo(gE('_municipioNotificacionvch'),municipio);
            
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=89&cveEstado='+cveEstado,true);
    

}

function calcularEdad()
{
	var fechaNacimiento=gEx('f_sp_fechaNacimientodte');
    
    
    var edad=0;
    
    var fechaActual=Date.parseDate('<?php echo date("Y-m-d")?>','Y-m-d');
    
    fechaNacimiento=fechaNacimiento.getValue();
    
    fechaCumpleados=Date.parseDate(fechaActual.format("Y")+'-'+fechaNacimiento.format('m-d'),'Y-m-d');
    
    edad=parseInt(fechaActual.format('Y'))-parseInt(fechaNacimiento.format('Y'));
    if(fechaCumpleados>fechaActual)
    {
    	edad--;
    }
    
    
    
    gE('_edadint').value=edad;
}