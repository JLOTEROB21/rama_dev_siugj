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
    	loadScript('../modulosEspeciales_SGJP/Scripts/cParticipante.js.php', function()
    																		{
                                                                            }
					)
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
         
        
    }
   
}



function validarCarpetaAdministrativaSeleccionada()
{
	
    
    return true;
}


function addPromovente()
{
	
	var cmbParticipacion=crearComboExt('cmbParticipacion',arrParteProcesal,180,5,250);
    cmbParticipacion.setValue('101');
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            html:'Participaci&oacute;n dentro del asunto:'
                                                        },
                                                        cmbParticipacion
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Agregar Promovente',
										width: 500,
										height:130,
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
																}
															}
												},
										buttons:	[
														{
															
															text: '<?php echo $etj["lblBtnAceptar"]?>',
                                                            
															handler: function()
																	{
                                                                    	if(cmbParticipacion.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {
	                                                                            cmbParticipacion.focus();
                                                                            }
                                                                        	msgBox('Debe indicar la participaci&oacute;n del promovente dentro del asunto',resp);
                                                                        	return;
                                                                        }
																		agregarParticipante(cmbParticipacion.getValue(),cmbParticipacion.getRawValue())
                                                                        ventanaAM.close();
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


function agregarParticipante(f,parte)
{
	var objConf={};
    objConf.ocultaIdentificacion=true;
    objConf.idActividad=gE('sp_8981').innerHTML;
    objConf.idCarpeta=-1;
    objConf.ocultaCURP=true;
    objConf.ocultaRFC=true;
    objConf.afterRegister=promoventeAgregado;
	agregarParticipanteVentana(f,parte,objConf)
	
}   


function promoventeAgregado(idUsuario,nombre,tParticipante,arrParticipantes,arrParticipantesGlobal)
{
	
	var _nombrePromoventevch=gE('_usuarioPromoventevch');
	rellenarCombo(_nombrePromoventevch,eval(arrParticipantesGlobal),true);
    selElemCombo(_nombrePromoventevch,idUsuario);
}



