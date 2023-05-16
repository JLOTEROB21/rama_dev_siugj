<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");

	$fechaActual=date("Y-m-d")	;
	$horaActual=date("H:i");
	
	$consulta="SELECT id__5_tablaDinamica,nombreTipo FROM _5_tablaDinamica WHERE situacion=1 ORDER BY nombreTipo";
	$arrParticipacion=$con->obtenerFilasArreglo($consulta);
	
	
	$consulta="SELECT idGenero,genero FROM 1005_generoUsuario";
	$arrGenero=$con->obtenerFilasArreglo($consulta);
?>
var validandoBillete=false;

var arrGenero=<?php echo $arrGenero?>;
var arrParticipacion=<?php echo $arrParticipacion?>;



function inyeccionCodigo()
{
	if(esRegistroFormulario())
    {
    	
    	if(gE('idRegistroG').value=='-1')
        {
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
             
             if(gEN('_procesoJudicialvch')[0].value!='N/E')
             {
             	gEx('ext__carpetaAdministrativavch').setValue(gEN('_procesoJudicialvch')[0].value);
                gEx('ext__carpetaAdministrativavch').disable();
                gE('_carpetaAdministrativavch').value=gEN('_procesoJudicialvch')[0].value;
             	obtenerInfoProcesoJudicial(gEN('_procesoJudicialvch')[0].value);
             	
                
             }
             
         }
         
          gEx('ext__carpetaAdministrativavch').on('select',function(cmb,registro)
      												{
                                                    	obtenerInfoProcesoJudicial(registro.data.id);
                                                    }
      										) 
         
         
         if(gE('opt_chkPersonaNoRegistradaarr_1'))
         {
             asignarEvento(gE('opt_chkPersonaNoRegistradaarr_1'),'click',function(chk)
                                                                        {
                                                                            if(chk.checked)
                                                                            {
                                                                                desHabilitarComboNombre();	
                                                                                habilitarCamposNombre();
                                                                                mE('div_5072');
                                                                                gE('opt_chkPersonaNoRegistradaarr_1').checked=true;
                                                                            }
                                                                            else
                                                                            {
                                                                                habilitarComboNombre();	
                                                                                desHabilitarCamposNombre();
                                                                            }
                                                                        }
                                                        );   
		 }
         
         if(gE('_figuraPromoventevch'))
         {                                                      
            asignarEvento(gE('_figuraPromoventevch'),'change',function(combo)
                                                                        {
                                                                            var opcionSel=combo.options[combo.selectedIndex].value;
                                                                            switch(opcionSel)
                                                                            {
                                                                                case '9':
                                                                                case '11':
                                                                                    desHabilitarComboNombre();
                                                                                    habilitarCamposNombre();
                                                                                    
                                                                                break;
                                                                                case '10':
                                                                                    desHabilitarComboNombre();
                                                                                    desHabilitarCamposNombre();
                                                                                    oE('div_1585');
                                                                                break;
                                                                                default:
                                                                                    desHabilitarCamposNombre();
                                                                                    habilitarComboNombre();
                                                                                break;
                                                                            }
                                                                        }
                                                        );  
        	lanzarEvento(gE('_figuraPromoventevch'),'change');                                            
         }
		gE('sp_10722').innerHTML= '' ;
        
        if(gEN('_procesoJudicialvch')[0].value!='N/E')
       {
         
          oE('div_2750');
          oE('div_2751');
          oE('div_2752');
          oE('div_2262');
          oE('div_4295');
          oE('div_5072');
          oE('div_1585');
          oE('div_5071');
          gE('_usuarioPromoventevch').setAttribute('val','');
          
       }
       else
       {
       		oE('div_10725');
          	oE('div_10726');
       }
        
		
    }
    else
    {
    
    	
    	if(gE('sp_4295'))
        {
            if((gE('sp_4295').innerHTML!='Otro')&&(gE('sp_4295').innerHTML!='Juez'))
            {
                oE('div_4299');
                oE('div_4300');
                oE('div_4301');
            }
            
            if(gE('sp_4295').innerHTML=='Ministerio público')
            {
                oE('div_1585');
            }
        }
        
        
       if(gEN('_procesoJudicialvch')[0].value!='N/E')
       {
         
          oE('div_2750');
          oE('div_2751');
          oE('div_2752');
          oE('div_2262');
          oE('div_4295');
          oE('div_5072');
          oE('div_1585');
          oE('div_5071');
          obtenerInfoProcesoJudicial(gEN('_procesoJudicialvch')[0].value);
          
       }
       else
       {
       		oE('div_10725');
          	oE('div_10726');
       }
        
       
    }
}


function habilitarCamposNombre()
{
	mE('div_1585');
	mE('div_4296');
    gE('_apPaternovch').setAttribute('val','obl');
    mE('div_4297');
    
    mE('div_4298');
    gE('_nombrevch').setAttribute('val','obl');
    mE('div_4299');
    mE('div_4300');
    mE('div_4301');
    

}

function desHabilitarCamposNombre()
{
	oE('div_4296');
    gE('_apPaternovch').setAttribute('val','');
    gE('_apPaternovch').value='';
    oE('div_4297');
    gE('_apMaternovch').value='';
    oE('div_4298');
    gE('_nombrevch').setAttribute('val','');
    gE('_nombrevch').value='';
    oE('div_4299');
    oE('div_4300');
    oE('div_4301');
}

function habilitarComboNombre()
{
	mE('div_1585');
	mE('div_5071');
    mE('div_5072');
    gE('_usuarioPromoventevch').setAttribute('val','obl');
}

function desHabilitarComboNombre()
{
	oE('div_5071');
    gE('_usuarioPromoventevch').setAttribute('val','');
    oE('div_5072');
    gE('opt_chkPersonaNoRegistradaarr_1').checked=false;
}

function validarCarpetaAdministrativaSeleccionada()
{
	<?php
	if($tipoMateria=="SC")
	{
		echo "return validarBilleteDeposito();";
	}
	?>
	
	var tipoPromocion=gE('_relacionPromocionvch').options[gE('_relacionPromocionvch').selectedIndex].value;
	
    var _tipoRequerimiento=gE('_tipoPromocionesvch').options[gE('_tipoPromocionesvch').selectedIndex].value;
    
    
    if((tipoPromocion!='1')&&(_tipoRequerimiento!='1'))
    {
    	msgBox('S&oacute;lo se permiten requerimientos de tipo "Tr&aacute;mite" cuando el tipo de promoci&oacute;n recibida no pertenece a una carpeta de la unidad');
    	return false;
    }
    
    
    
    switch(tipoPromocion)
    {
    	case '1':
        	var _carpetaAdministrativavch=gE('_carpetaAdministrativavch');
            if(_carpetaAdministrativavch.value=='-1')
            {	
                function respAux()
                {
                    gEx('ext__carpetaAdministrativavch').setValue('');
                    gEx('ext__carpetaAdministrativavch').focus(false,500);
                }
                msgBox('Debe seleccionar la carpeta administrativa a la cual desea asociar la promoci&oacute;n',respAux);
                return false;
            }
        break;
        case '2':
        	var _carpetaAdministrativavch=gE('_carpetaAdministrativaReferidavch');
            if(_carpetaAdministrativavch.value=='-1')
            {	
                function respAux()
                {
                    gEx('ext__carpetaAdministrativaReferidavch').setValue('');
                    gEx('ext__carpetaAdministrativaReferidavch').focus(false,500);
                }
                msgBox('Debe seleccionar la carpeta administrativa referida en la promoci&oacute;n',respAux);
                return false;
            }
        break;
        case '3':
        
        break;
        
    }
	gE('_figuraPromoventevch').disabled=false;
    return true;
}


function addPromovente()
{
	if(gE('_idCarpetaAdministrativavch').value=='-1')
    {
    	function respAux()
        {
        	gE('t__idCarpetaAdministrativavch').focus();
        }
    	msgBox('Primero debe ingresar el No. de Expediente',respAux);
    	return;
    }
	var cmbParticipacion=crearComboExt('cmbParticipacion',arrParticipacion,110,95,200);
    var cmbGenero=crearComboExt('cmbGenero',arrGenero,110,65,150);
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            html:'Nombre:'
                                                        },
                                                        {
                                                        	x:110,
                                                            width:180,
                                                            id:'txtNombre',
                                                            y:5,
                                                            xtype:'textfield'
                                                        },
                                                        {
                                                        	x:310,
                                                            y:10,
                                                            html:'Ap. Paterno:'
                                                        },
                                                        {
                                                        	x:390,
                                                            width:150,
                                                            id:'txtApPaterno',
                                                            y:5,
                                                            xtype:'textfield'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            html:'Ap. Materno:'
                                                        },
                                                        {
                                                        	x:110,
                                                            width:150,
                                                            id:'txtApMaterno',
                                                            y:35,
                                                            xtype:'textfield'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:70,
                                                            html:'G&eacute;nero:'
                                                        },
                                                        cmbGenero,
                                                         {
                                                         
                                                        	x:10,
                                                            y:100,
                                                            html:'Participaci&oacute;n:'
                                                        },
                                                        cmbParticipacion
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar promovente',
										width: 750,
										height:220,
										layout: 'fit',
										plain:true,
										modal:true,
										bodyStyle:'padding:5px;',
										buttonAlign:'center',
										items: form,
										listeners : {
													show : {
																buffer : 10,
																fn : function() 
																{
                                                                	gEx('txtNombre').focus(false,500);
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',                                                            
															handler: function()
																	{
																		var txtNombre=gEx('txtNombre');	
                                                                        var txtApPaterno=gEx('txtApPaterno');
                                                                        var txtApMaterno=gEx('txtApMaterno');
                                                                        
                                                                        if(txtNombre.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
                                                                            	txtNombre.focus();
                                                                            }
                                                                            msgBox('Debe ingresar el nombre del promovente',resp);
                                                                            return;
                                                                        }
                                                                        if(cmbGenero.getValue()=='')
                                                                        {
                                                                        	function resp2()
                                                                            {
                                                                            	cmbGenero.focus();
                                                                            }
                                                                            msgBox('Debe ingresar el g&eacute;nero del promovente',resp2);
                                                                            return;
                                                                        }
                                                                        
                                                                        if(cmbParticipacion.getValue()=='')
                                                                        {
                                                                        	function resp3()
                                                                            {
                                                                            	cmbParticipacion.focus();
                                                                            }
                                                                            msgBox('Debe la participaci&oacute;n del promovente',resp3);
                                                                            return;
                                                                        }
                                                                        
                                                                        var cadObj='{"nombre":"'+cv(txtNombre.getValue())+'","apPaterno":"'+cv(txtApPaterno.getValue())+
                                                                        	'","apMaterno":"'+cv(txtApMaterno.getValue())+'","figura":"'+cmbParticipacion.getValue()+
                                                                            '","idCarpeta":"'+gE('_idCarpetaAdministrativavch').value+'","genero":"'+cmbGenero.getValue()+'"}';
																	
                                                                    
                                                                    	function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                                var arrOpciones=eval(arrResp[1]);
                                                                                
                                                                                rellenarCombo(gE('_usuarioPromoventevch'),arrOpciones);
                                                                                selElemCombo(gE('_usuarioPromoventevch'),arrResp[2]);
                                                                                ventanaAM.close();
                                                                                
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SICORE.php',funcAjax, 'POST','funcion=20&cadObj='+cadObj,true);
                                                                    
                                                                    }
														},
														{
															text: '<?php echo $etj["lblBtnCancelar"]?>',
															handler:function()
																	{
																		ventanaAM.close();
																	}
														}
													]
									}
								);
	ventanaAM.show();	
}



function validarBilleteDeposito()
{
	if(gE('div_8670').style.display=='')
    {
    	msgBox('El número de billete ingresado ya ha sido registrado previamente!');
    	return false;
    }
    
    return true;
}

function obtenerInfoProcesoJudicial(cupj)
{
	function funcAjax(peticion_http)
    {
        var resp=peticion_http.responseText;
        arrResp=resp.split('|');
        if(arrResp[0]=='1')
        {
         	var obj=eval('['+arrResp[1]+']')[0];  
            gE('sp_10722').innerHTML= obj.leyenda ;
        }
        else
        {
            msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
        }
    }
    obtenerDatosWebV2('../modulosEspeciales_SGJ/paginasFunciones/funcionesModulosEspeciales_SGJ.php',funcAjax, 'POST','funcion=2&cupj='+cupj,true);
    
}