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
var cadenaFuncionValidacion='validarCarpetaAdministrativaSeleccionada';


function inyeccionCodigo()
{
	if(esRegistroFormulario())
    {
    	<?php
			if(!existeRol("'1_0'"))
			{
		?>
                var x;
                if(gE('_relacionPromocionvch'))
                {
                    for(x=0;x<gE('_relacionPromocionvch').options.length;x++)
                    {
                        if((gE('_relacionPromocionvch').options[x].value!='1')&&(gE('_relacionPromocionvch').options[x].value!='2'))
                        {
                            gE('_relacionPromocionvch').options[x]=null; 	        
                            x--;
                        }
                    }
                }
        <?php
			}
			else
			{
			?>
				var x;
                
                for(x=0;x<gE('_relacionPromocionvch').options.length;x++)
                {
					if((gE('_relacionPromocionvch').options[x].value!='1')&&(gE('_relacionPromocionvch').options[x].value!='2'))
                    {
                   		gE('_relacionPromocionvch').options[x]=null; 	        
                        x--;
                    }
                }
			
		<?php            		
            }
		?>
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
         }
         
         if(gE('_relacionPromocionvch'))
         {
             asignarEvento(gE('_relacionPromocionvch'),'change',function(combo)
                                                                        {
                                                                            gE('_figuraPromoventevch').disabled=false;
                                                                            var opcionSel=combo.options[combo.selectedIndex].value;
                                                                            switch(opcionSel)
                                                                            {
                                                                                case '1':
                                                                                    gE('sp_1582').innerHTML='Carpeta Judicial asociada:';
                                                                                break;
                                                                                case '2':
                                                                                    gE('sp_1582').innerHTML='Carpeta Judicial referida:';
                                                                                break;
                                                                                case '3':
                                                                                    selElemCombo(gE('_figuraPromoventevch'),'9');
                                                                                    lanzarEvento(gE('_figuraPromoventevch'),'change');
                                                                                    gE('_figuraPromoventevch').disabled=true;
                                                                                break;
                                                                            }
                                                                        }
                                                        ); 
         }
         
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
		
		if(gE('_noBilletevch'))
        {
        	gE('_noBilletevch').setAttribute('onkeypress','return soloNumero(event,false,false,this)');

            asignarEvento('_noBilletevch','change',function()
                                                            {
                                                                function funcAjax()
                                                                {
                                                                    var resp=peticion_http.responseText;
                                                                    arrResp=resp.split('|');
                                                                    if(arrResp[0]=='1')
                                                                    {
                                                                        if(arrResp[1]=='1')
                                                                            mE('div_8670');
                                                                        else
                                                                            oE('div_8670');
                                                                    }
                                                                    else
                                                                    {
                                                                        msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                    }
                                                                }
                                                                obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SICORE.php',funcAjax, 'POST','funcion=203&iR='+
                                                                                gE('idRegistroG').value+'&nB='+gE('_noBilletevch').value,true);
                                                            }
             
                           );
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
        
        if(gE('sp_5074'))
        {
            if(gE('sp_5074').innerHTML=='Petición sin asociación de Carpeta Judicial')
            {
                oE('div_1582');
                oE('div_2733');
            }
            else
            {
                if(gE('sp_5074').innerHTML=='Petición relacionada con capeta judical de la unidad de gestión')
                {
                    gE('sp_1582').innerHTML='No. de Expediente:';
                }
                else
                {
                    gE('sp_1582').innerHTML='No. de Expediente:';
                }	
            }
        }
        
        if(gE('sp_1605'))
        {
            if(gE('sp_1605').innerHTML!='Promoción de solicitud de programación de audiencia')
            {
                oE('div_2730');
                oE('div_2732');
                
            }
        }
    

    	<?php
		
		if($tipoMateria=="F")
		{
			
		?>
			
            if((!gE('sp_2729') || gE('sp_2729').innerHTML==''))
            {
            	oE('div_2728');
            }
            
        	if((!gE('sp_7698') || gE('sp_7698').innerHTML==''))
            {
            	oE('div_7697');
            }
        <?php	
			
		}
		
		
		if($tipoMateria=="C")
		{
			
		?>
        	
            if((!gE('sp_2729') || gE('sp_2729').innerHTML==''))
            {
            	oE('div_2728');
            }
           
            
            
        	if((!gE('sp_7702') || gE('sp_7702').innerHTML==''))
            {
            	oE('div_7701');
            }
        <?php	
			
		}
		
		?>
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