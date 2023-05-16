<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");
	
	$idFormulario=bD($_GET["iF"]);
	$idReferencia=bD($_GET["iR"]);
	
	$consulta="SELECT carpetaAdministrativa,imputado FROM _434_tablaDinamica WHERE id__434_tablaDinamica=".$idReferencia;
	$fDatosSolicitud=$con->obtenerPrimeraFilaAsoc($consulta);
	$cAdministrativa=$fDatosSolicitud["carpetaAdministrativa"];
	$imputado=$fDatosSolicitud["imputado"];
	
	$consulta="SELECT idActividad FROM 7006_carpetasAdministrativas WHERE carpetaAdministrativa='".$cAdministrativa."'";
	$idActividadCarpeta=$con->obtenerValor($consulta);
	if($idActividadCarpeta=="")
		$idActividadCarpeta=-1;	
	
	$consulta="SELECT id__47_tablaDinamica,CONCAT(IF(f.nombre IS NULL,'',f.nombre),' ',IF(f.apellidoPaterno IS NULL,'',f.apellidoPaterno),' ',
			IF(f.apellidoMaterno IS NULL,'',f.apellidoMaterno)) FROM 7005_relacionFigurasJuridicasSolicitud r,_47_tablaDinamica f WHERE 
			r.idActividad=".$idActividadCarpeta." AND idFiguraJuridica=4 	AND f.id__47_tablaDinamica=r.idParticipante ORDER BY 
			f.nombre,f.apellidoPaterno,f.apellidoMaterno";	
	$arrImputados=$con->obtenerFilasArreglo($consulta);
	
	$consulta="SELECT valor,texto FROM 1004_siNo";
	$arrSiNo=$con->obtenerFilasArreglo($consulta);

	$consulta="SELECT * FROM 7034_prescripciones WHERE idFormulario=".$idFormulario." AND idReferencia=".$idReferencia;
	$oPrescripcion=$con->obtenerFilasJson($consulta);

?>

var oPenaPrescripcion={};
var oPrescripcion=<?php echo $oPrescripcion?>;
var imputado=<?php echo $imputado?>;
var arrSiNo=<?php echo $arrSiNo?>;
var arrImputados=<?php echo $arrImputados?>;
var cAdministrativa='<?php echo $cAdministrativa?>';
Ext.onReady(inicializar);

function inicializar()
{
	 new Ext.Button (
                                {
                                    icon:'../images/icon_big_tick.gif',
                                    cls:'x-btn-text-icon',
                                    text:'Guardar',
                                    width:110,
                                    height:30,
                                    renderTo:'contenedor1',
                                    handler:function()
                                            {
                                                if(cmbImputado.getValue()=='')
												{
													function resp()
													{
														cmbImputado.focus();
													}
													msgBox('Debe indicar el imputado al cual desea registrar la prescripci&oacute;n',resp);
													return;
												}

												if(cmbPena.getValue()=='')
												{
													function resp2()
													{
														cmbPena.focus();
													}
													msgBox('Debe indicar la pena sobre la cual desea registrar la prescripci&oacute;n',resp2);
													return;
												}

												if(cmbSentenciadoCiudadMexico.getValue()=='')
												{
													function resp3()
													{
														cmbSentenciadoCiudadMexico.focus();
													}
													msgBox('Debe indicar si el imputado/sentenciado se encuentra en la Ciudad de M&eacute;xico',resp3);
													return;
												}

												var txtFechaSustraccion=gEx('txtFechaSustraccion');

												if(txtFechaSustraccion.getValue()=='')
												{
													function resp4()
													{
														txtFechaSustraccion.focus();
													}
													msgBox('Debe indicar la fecha de sustracci&oacute;n del imputado/sentenciado',resp4);
													return;
												}

												var txtAniosPunitiva=gEx('txtAniosPunitiva');	
												var txtMesesPunitiva=gEx('txtMesesPunitiva');
												var txtDiasPunitiva=gEx('txtDiasPunitiva');
												if(txtAniosPunitiva.getValue()=='')
													txtAniosPunitiva.setValue(0);
												if(txtMesesPunitiva.getValue()=='')
													txtMesesPunitiva.setValue(0);
												if(txtDiasPunitiva.getValue()=='')
													txtDiasPunitiva.setValue(0);
												var abonoPrisionPreventiva=gEx('txtAnios').getValue()+'_'+gEx('txtMeses').getValue()+'_'+gEx('txtDias').getValue();
												var abonoPrisionPunitiva=txtAniosPunitiva.getValue()+'_'+txtMesesPunitiva.getValue()+'_'+txtDiasPunitiva.getValue();
												var abonoCumplimientoSentencia=gEx('txtAniosCumplimiento').getValue()+'_'+gEx('txtMesesCumplimiento').getValue()+'_'+gEx('txtDiasCumplimiento').getValue();

												var cadObj='{"sentenciado":"'+cmbImputado.getValue()+'","idPena":"'+cmbPena.getValue()+'","fechaBase":"'+txtFechaSustraccion.getValue().format('Y-m-d')+
														'","abonoPrisionPreventiva":"'+abonoPrisionPreventiva+'","abonoPrisionPunitiva":"'+abonoPrisionPunitiva+'","abonoCumplimientoSentencia":"'+
														abonoCumplimientoSentencia+'","comentariosPrisionPunitiva":"'+cv(gEx('txtComentarioPrision').getValue())+'",'+
														'"fechaPrescripcion":"'+gEx('txtFechaPrescripcion').getValue().format('Y-m-d')+'","sentenciadoEnCDMX":"'+cmbSentenciadoCiudadMexico.getValue()+
														'","comentariosAdicionales":"","carpetaAdministrativa":"'+cAdministrativa+
														'","idFormulario":"'+gE('idFormulario').value+'","idRegistro":"'+gE('idRegistro').value+'"}';


												function funcAjax()
												{
													var resp=peticion_http.responseText;
													arrResp=resp.split('|');
													if(arrResp[0]=='1')
													{
														function funcResp1()
														{
															refrescarMenuDTD();
														}
														msgBox('La información ha sido guardada correctamente',funcResp1);

													}
													else
													{
														msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
													}
												}
												obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=139&cadObj='+cadObj,true);

                                            }
                                    
                                }
                            )
                            
	
                            
	var cmbImputado=crearComboExt('cmbImputado',arrImputados,160,5,300);
    cmbImputado.setValue(imputado);
    cmbImputado.disable();
    
	var cmbSentenciadoCiudadMexico=crearComboExt('cmbSentenciadoCiudadMexico',arrSiNo,420,310,115);
	
	cmbSentenciadoCiudadMexico.on('select',calcularPrescripcion);
	
	cmbImputado.on('select',function(cmb,registro)
							{
								function funcAjax()
								{
									var resp=peticion_http.responseText;
									arrResp=resp.split('|');
									if(arrResp[0]=='1')
									{
										var arrDatos=eval(arrResp[1]);
										gEx('cmbPena').setValue('');
										gEx('cmbPena').getStore().loadData(arrDatos);
										limpiarDatosAbono();
									}
									else
									{
										msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
									}
								}
								obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=137&s='+registro.data.id+'&cA='+cAdministrativa,true);
							
							}
							
				)
	
	
	var cmbPena=crearComboExt('cmbPena',[],160,35,600);
	
	cmbPena.on('select',function(cmb,registro)
							{
								penaSelected();	
							
							}
							
				)
	
	new Ext.Panel	(	
    					{
                              renderTo:'tbPanel',
                              /*baseCls: 'x-plain',*/
                              layout:'absolute',
                              defaultType: 'label',
                              border:false,
                              
                              //title:'Datos Generales',
                              xtype:'panel',
                              width:850,
                              height:450,
                              items:	[
                                          {
                                              x:10,
                                              y:10,
                                              html:'<span class="TSJDF_Etiqueta">Imputado/sentenciado:</span>'
                                          },
                                          cmbImputado,
                                          {
                                              x:10,
                                              y:40,
                                              html:'<span class="TSJDF_Etiqueta">Pena:</span>'
                                          },
                                          cmbPena,
                                          {
                                              x:10,
                                              y:70,
                                              hidden:true,
                                              id:'lblFechaInicioPena',
                                              html:'<span class="TSJDF_Etiqueta">Fecha de inicio de pena:</span>'
                                          },
                                          {
                                              x:160,
                                              y:65,
                                              hidden:true,
                                              xtype:'datefield',
                                              id:'dteFechaInicio',
                                              disabled:true
            
                                          },
                                          {
                                              x:300,
                                              y:70,
                                              hidden:true,
                                              id:'lblFechaTerminoPena',
                                              html:'<span class="TSJDF_Etiqueta">Fecha de t&eacute;rmino de pena:</span>'
                                          },
                                          {
                                              x:475,
                                              y:65,
                                              hidden:true,
                                              xtype:'datefield',
                                              id:'dteFechaTermino',
                                              disabled:true
            
                                          },
                                          {
                                              xtype:'fieldset',
                                              width:230,
                                              
                                              id:'fsPeriodoPena',
                                              height:80,
                                              title:'Abono prisi&oacute;n preventiva',
                                              x:10,
                                              y:95,
                                              
                                              layout:'absolute',
                                              items:	[
                                                          {
                                                              x:10,
                                                              y:0,
                                                              xtype:'numberfield',
                                                              allowDecimals:false,
                                                              alowNegative:false,
                                                              width:40,
                                                              value:0,
                                                              disabled:true,
                                                              id:'txtAnios'
                                                          },
                                                          {
                                                              xtype:'label',
                                                              html:'<span class="TSJDF_Etiqueta" style="font-size:11px !important;">A&ntilde;os</span>',
                                                              x:15,
                                                              y:25
                                                          },
                                                          {
                                                              x:60,
                                                              y:0,
                                                              xtype:'numberfield',
                                                              width:40,
                                                              allowDecimals:false,
                                                              alowNegative:false,
                                                              value:0,
                                                              disabled:true,
                                                              id:'txtMeses'
                                                          },
                                                          {
                                                              xtype:'label',
                                                              html:'<span class="TSJDF_Etiqueta" style="font-size:11px !important;">Meses</span>',
                                                              x:65,
                                                              y:25
                                                          },
                                                          {
                                                              x:110,
                                                              y:0,
                                                              xtype:'numberfield',
                                                              width:40,
                                                              value:0,
                                                              disabled:true,
                                                              allowDecimals:false,
                                                              alowNegative:false,
                                                              id:'txtDias'
                                                          },
                                                          {
                                                              xtype:'label',
                                                              html:'<span class="TSJDF_Etiqueta" style="font-size:11px !important;">D&iacute;as</span>',
                                                              x:115,
                                                              y:25
                                                          }
                                                      ]
                                          } ,
                                          {
                                              xtype:'fieldset',
                                              width:230,																							
                                              id:'fsAbonoCumplimientoPena',
                                              height:80,
                                              title:'Abono cumplimiento sentencia',
                                              x:10,
                                              y:185,
                                              layout:'absolute',
                                              items:	[
                                                          {
                                                              x:10,
                                                              y:0,
                                                              xtype:'numberfield',
                                                              allowDecimals:false,
                                                              alowNegative:false,
                                                              width:40,
                                                              value:0,
                                                              disabled:true,
                                                              id:'txtAniosCumplimiento'
                                                          },
                                                          {
                                                              xtype:'label',
                                                              html:'<span class="TSJDF_Etiqueta" style="font-size:11px !important;">A&ntilde;os</span>',
                                                              x:15,
                                                              y:25
                                                          },
                                                          {
                                                              x:60,
                                                              y:0,
                                                              xtype:'numberfield',
                                                              width:40,
                                                              allowDecimals:false,
                                                              alowNegative:false,
                                                              value:0,
                                                              disabled:true,
                                                              id:'txtMesesCumplimiento'
                                                          },
                                                          {
                                                              xtype:'label',
                                                              html:'<span class="TSJDF_Etiqueta" style="font-size:11px !important;">Meses</span>',
                                                              x:65,
                                                              y:25
                                                          },
                                                          {
                                                              x:110,
                                                              y:0,
                                                              xtype:'numberfield',
                                                              width:40,
                                                              value:0,
                                                              disabled:true,
                                                              allowDecimals:false,
                                                              alowNegative:false,
                                                              id:'txtDiasCumplimiento'
                                                          },
                                                          {
                                                              xtype:'label',
                                                              html:'<span class="TSJDF_Etiqueta" style="font-size:11px !important;">D&iacute;as</span>',
                                                              x:115,
                                                              y:25
                                                          }
                                                      ]
                                          },
                                          {
                                              xtype:'fieldset',
                                              width:490,
                                              
                                              id:'fsAbonoPrisionPunitiva',
                                              height:170,
                                              title:'Abono prisi&oacute;n punitiva',
                                              x:260,
                                              y:95,
                                              layout:'absolute',
                                              items:	[
                                                          {
                                                              x:10,
                                                              y:0,
                                                              xtype:'numberfield',
                                                              allowDecimals:false,
                                                              alowNegative:false,
                                                              width:40,
                                                              value:0,
                                                              disabled:true,
                                                              listeners:	{
                                                                              change:calcularPenaCumplir
                                                                          },
                                                              id:'txtAniosPunitiva'
                                                          },
                                                          {
                                                              xtype:'label',
                                                              html:'<span class="TSJDF_Etiqueta" style="font-size:11px !important;">A&ntilde;os</span>',
                                                              x:15,
                                                              y:25
                                                          },
                                                          {
                                                              x:60,
                                                              y:0,
                                                              xtype:'numberfield',
                                                              width:40,
                                                              disabled:true,
                                                              listeners:	{
                                                                              change:calcularPenaCumplir
                                                                          },
                                                              allowDecimals:false,
                                                              alowNegative:false,
                                                              value:0,
            
                                                              id:'txtMesesPunitiva'
                                                          },
                                                          {
                                                              xtype:'label',
                                                              html:'<span class="TSJDF_Etiqueta" style="font-size:11px !important;">Meses</span>',
                                                              x:65,
                                                              y:25
                                                          },
                                                          {
                                                              x:110,
                                                              y:0,
                                                              xtype:'numberfield',
                                                              width:40,
                                                              value:0,
                                                              disabled:true,
                                                              listeners:	{
                                                                              change:calcularPenaCumplir
                                                                          },
                                                              allowDecimals:false,
                                                              alowNegative:false,
                                                              id:'txtDiasPunitiva'
                                                          },
                                                          {
                                                              xtype:'label',
                                                              html:'<span class="TSJDF_Etiqueta" style="font-size:11px !important;">D&iacute;as</span>',
                                                              x:115,
                                                              y:25
                                                          },
                                                          {
                                                              x:10,
                                                              y:45,
                                                              xtype:'label',
                                                              html:'<span class="TSJDF_Etiqueta" >Comentarios prisi&oacute;n punitiva:</span>'
                                                          },
                                                          {
                                                              x:10,
                                                              y:65,
                                                              width:450,
                                                              height:65,
                                                              disabled:true,
                                                              id:'txtComentarioPrision',
                                                              xtype:'textarea'
                                                          }
                                                      ]
                                          } ,
                                          {
                                              x:10,
                                              y:285,                                              
                                              xtype:'label',
                                              id:'lblFechaSustraccion',
                                              html:'<span class="TSJDF_Etiqueta">Fecha de sustracción del imputado/sentenciado:</span>'
                                          },
                                          {
                                              x:320,
                                              y:280,
                                              disabled:true,
                                              xtype:'datefield',
                                              id:'txtFechaSustraccion',
                                              listeners:	{
                                                              change:function()
                                                                      {
                                                                          calcularPenaCumplir();
                                                                      }
                                                          }
                                              
                                          },
                                          {
                                              x:10,
                                              y:315,
                                              xtype:'label',
                                              html:'<span class="TSJDF_Etiqueta">¿El imputado/sentenciado se encuentra en la Ciudad de M&eacute;xico?</span>'
                                          },
                                          cmbSentenciadoCiudadMexico,
                                          {
                                              x:10,
                                              y:345,
                                              xtype:'label',
                                              html:'<span class="TSJDF_Etiqueta">Fecha de prescripci&oacute;n:</span>'
                                          },
                                          {
                                              x:180,
                                              y:340,
                                              disabled:true,
                                              xtype:'datefield',
                                              id:'txtFechaPrescripcion'
                                          },
                                          {
                                              x:500,
                                              y:285,
                                              id:'lblPenaCumplir',
                                              xtype:'label',
                                              hidden:true,
                                              html:'<span class="TSJDF_Etiqueta">Pena por complir:</span>'
                                          },
                                          {
                                              xtype:'fieldset',
                                              width:230,
                                              border:false,
                                              hidden:true,
                                              id:'fsPeriodoCumplir',
                                              height:80,
                                              
                                              x:600,
                                              y:270,
                                              
                                              layout:'absolute',
                                              items:	[
                                                          {
                                                              x:10,
                                                              y:0,
                                                              xtype:'numberfield',
                                                              allowDecimals:false,
                                                              alowNegative:false,
                                                              width:40,
                                                              value:0,
                                                              disabled:true,
                                                              id:'txtAniosCumplir'
                                                          },
                                                          {
                                                              xtype:'label',
															  html:'<span class="TSJDF_Etiqueta" style="font-size:11px !important;">A&ntilde;os</span>',
                                                              x:15,
                                                              y:25
                                                          },
                                                          {
                                                              x:60,
                                                              y:0,
                                                              xtype:'numberfield',
                                                              width:40,
                                                              allowDecimals:false,
                                                              alowNegative:false,
                                                              value:0,
                                                              disabled:true,
                                                              id:'txtMesesCumplir'
                                                          },
                                                          {
                                                              xtype:'label',
                                                              html:'<span class="TSJDF_Etiqueta" style="font-size:11px !important;">Meses</span>',
                                                              x:65,
                                                              y:25
                                                          },
                                                          {
                                                              x:110,
                                                              y:0,
                                                              xtype:'numberfield',
                                                              width:40,
                                                              value:0,
                                                              disabled:true,
                                                              allowDecimals:false,
                                                              alowNegative:false,
                                                              id:'txtDiasCumplir'
                                                          },
                                                          {
                                                              xtype:'label',
                                                              html:'<span class="TSJDF_Etiqueta" style="font-size:11px !important;">D&iacute;as</span>',
                                                              x:115,
                                                              y:25
                                                          }
                                                      ]
                                          }
                                      ]
        
        
                        }
                    
                   )

	
	
	
	function funcAjax()
	{
		var resp=peticion_http.responseText;
		arrResp=resp.split('|');
		if(arrResp[0]=='1')
		{
			var arrDatos=eval(arrResp[1]);
			gEx('cmbPena').setValue('');
			gEx('cmbPena').getStore().loadData(arrDatos);
			limpiarDatosAbono();
			
			
			if(oPrescripcion.length>0)
			{
				gEx('cmbPena').setValue(oPrescripcion[0].idPena);
				penaSelected(	
								function()
								{
									var arrAbonoCumplimientoSentencia=oPrescripcion[0].abonoCumplimientoSentencia.split('_');
									var arrAbonoPrisionPreventiva=oPrescripcion[0].abonoPrisionPreventiva.split('_');
									var arrAbonoPrisionPunitiva=oPrescripcion[0].abonoPrisionPunitiva.split('_');


									gEx('txtAnios').setValue(arrAbonoPrisionPreventiva[0]);
									gEx('txtMeses').setValue(arrAbonoPrisionPreventiva[1]);
									gEx('txtDias').setValue(arrAbonoPrisionPreventiva[2]);

									gEx('txtAniosCumplimiento').setValue(arrAbonoCumplimientoSentencia[0]);
									gEx('txtMesesCumplimiento').setValue(arrAbonoCumplimientoSentencia[1]);
									gEx('txtDiasCumplimiento').setValue(arrAbonoCumplimientoSentencia[2]);

									gEx('txtAniosPunitiva').setValue(arrAbonoPrisionPunitiva[0]);
									gEx('txtMesesPunitiva').setValue(arrAbonoPrisionPunitiva[1]);
									gEx('txtDiasPunitiva').setValue(arrAbonoPrisionPunitiva[2]);

									gEx('txtComentarioPrision').setValue(escaparBR(oPrescripcion[0].comentariosPrisionPunitiva));

									gEx('txtFechaSustraccion').setValue(oPrescripcion[0].fechaSustraccion);
									gEx('cmbSentenciadoCiudadMexico').setValue(oPrescripcion[0].sentenciadoEnCDMX);


									calcularPenaCumplir();
									gEx('txtFechaPrescripcion').setValue(oPrescripcion[0].fechaPrescripcion);
									
									
									if(gE('sL').value=='1')                            
									{
										oE('sticky');
										gEx('txtAniosPunitiva').disable();
										gEx('txtMesesPunitiva').disable();
										gEx('txtDiasPunitiva').disable();
										gEx('txtComentarioPrision').setReadOnly(true);
										gEx('cmbPena').disable();
										gEx('txtFechaSustraccion').disable();
										gEx('cmbSentenciadoCiudadMexico').disable();
									}
									
								}
							)
				
				

			}
			
			
			
			
			
			
		}
		else
		{
			msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
		}
	}
	obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=137&s='+gEx('cmbImputado').getValue()+'&cA='+cAdministrativa,true);
	
}


function penaSelected(afterEjecution)
{
	function funcAjax()
	{
			var resp=peticion_http.responseText;
			arrResp=resp.split('|');
			if(arrResp[0]=='1')
			{
				oPenaPrescripcion=eval('['+arrResp[1]+']')[0];
				limpiarDatosAbono();
				gEx('txtAniosPunitiva').disable();
				gEx('txtMesesPunitiva').disable();
				gEx('txtDiasPunitiva').disable();
				gEx('txtComentarioPrision').disable();
				gEx('lblFechaInicioPena').hide();
				gEx('dteFechaInicio').hide();
				gEx('lblFechaTerminoPena').hide();
				gEx('dteFechaTermino').hide();
				gEx('lblPenaCumplir').hide();
				gEx('fsPeriodoCumplir').hide();
				gEx('lblFechaInicioPena').hide();

				gEx('txtFechaSustraccion').disable();


				gEx('dteFechaInicio').setValue(oPenaPrescripcion.fechaInicioPena);
				gEx('dteFechaTermino').setValue(oPenaPrescripcion.fechaTermino);
				if(oPenaPrescripcion.fechaTermino!='')
				{
					gEx('lblFechaInicioPena').show();
					gEx('dteFechaInicio').show();
					gEx('lblFechaTerminoPena').show();
					gEx('dteFechaTermino').show();
				}


				var arrDias=oPenaPrescripcion.abonoPrisionPreventiva.split('_');
				gEx('txtAnios').setValue(arrDias[0]);
				gEx('txtMeses').setValue(arrDias[1]);
				gEx('txtDias').setValue(arrDias[2]);

				gEx('txtFechaSustraccion').setMinValue(oPenaPrescripcion.fechaInicioPena);
				gEx('txtFechaSustraccion').setMaxValue(oPenaPrescripcion.fechaTermino);
				if(oPenaPrescripcion.tipoEntrada=='5')
				{
					gEx('txtAniosPunitiva').enable();
					gEx('txtMesesPunitiva').enable();
					gEx('txtDiasPunitiva').enable();											
					gEx('txtComentarioPrision').enable();
					gEx('lblPenaCumplir').show();
					gEx('fsPeriodoCumplir').show();
					if(oPenaPrescripcion.esPrivativaLibertad=='1')
					{
						gEx('txtFechaSustraccion').enable();
						gEx('lblFechaSustraccion').setText('<span class="TSJDF_Etiqueta">Fecha de sustracción del imputado/sentenciado:</span>',false);
					}
					calcularPenaCumplir();
				}
				else
				{
					gEx('lblFechaSustraccion').setText('<span class="TSJDF_Etiqueta">Fecha de ejecutoria:</span>',false);
					gEx('txtFechaSustraccion').setValue(oPenaPrescripcion.fechaInicio);
					calcularPrescripcion();
				}
				
				
				if(afterEjecution)
					afterEjecution();
				
			}
			else
			{
				msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
			}
		}
	obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_SGP.php',funcAjax, 'POST','funcion=138&iP='+gEx('cmbPena').getValue(),true);
}

function calcularPenaCumplir()
{
	var arrPenaBase=oPenaPrescripcion.periodoPena.split('_');
	var arrAbonoPrisionPreventiva=oPenaPrescripcion.abonoPrisionPreventiva.split('_');
	var diasComputo=0;
	if(gEx('txtFechaSustraccion').getValue()!='')
	{
		diasComputo=obtenerDiferenciaDias(gEx('dteFechaInicio').getValue().format('Y-m-d'),gEx('txtFechaSustraccion').getValue().format('Y-m-d'));
		diasComputo--;
	}
	var abonoCumplimientoSentencia=convertirDiasArrComputo(diasComputo);
	gEx('txtAniosCumplimiento').setValue(abonoCumplimientoSentencia[0]);
	gEx('txtMesesCumplimiento').setValue(abonoCumplimientoSentencia[1]);
	gEx('txtDiasCumplimiento').setValue(abonoCumplimientoSentencia[2]);
	
	
	var abonoPrisionPunitiva=[];
	abonoPrisionPunitiva[0]=gEx('txtAniosPunitiva').getValue();
	abonoPrisionPunitiva[1]=gEx('txtMesesPunitiva').getValue();
	abonoPrisionPunitiva[2]=gEx('txtDiasPunitiva').getValue();
	
	var arrResultado=restarComputo(arrPenaBase,arrAbonoPrisionPreventiva);
	arrResultado=restarComputo(arrResultado,abonoCumplimientoSentencia);
	arrResultado=restarComputo(arrResultado,abonoPrisionPunitiva);
	gEx('txtAniosCumplir').setValue(arrResultado[0]);
	gEx('txtMesesCumplir').setValue(arrResultado[1]);
	gEx('txtDiasCumplir').setValue(arrResultado[2]);
	calcularPrescripcion();
}


function calcularPrescripcion()
{
	var txtFechaPrescripcion=gEx('txtFechaPrescripcion');
	var txtFechaSustraccion=gEx('txtFechaSustraccion');
	var cmbSentenciadoCiudadMexico=gEx('cmbSentenciadoCiudadMexico');
	
	if(txtFechaSustraccion.getValue()=='')
	{
		txtFechaPrescripcion.setValue('');
		return;
	}
	
	if(cmbSentenciadoCiudadMexico.getValue()=='')
	{
		txtFechaPrescripcion.setValue('');
		return;
	}
	
	var fechaBase=null;
	if(txtFechaSustraccion.disabled)
		fechaBase=txtFechaSustraccion.getValue();
	else	
		fechaBase=txtFechaSustraccion.getValue().add(Date.DAY,1);
	var arrSumar=[];
	arrSumar[0]=0;
	arrSumar[1]=0;
	arrSumar[2]=0;
	aniosPrescripcion=parseFloat(oPenaPrescripcion.aniosPrescripcion);
	if(oPenaPrescripcion.tipoEntrada=='5')
	{
		if(parseFloat(gEx('txtAniosCumplir').getValue())<aniosPrescripcion)
		{
			arrSumar[0]=aniosPrescripcion;
			arrSumar[1]=0;
			arrSumar[2]=0;
		}
		else
		{
			arrSumar[0]=parseFloat(gEx('txtAniosCumplir').getValue());
			arrSumar[1]=parseFloat(gEx('txtMesesCumplir').getValue());
			arrSumar[2]=parseFloat(gEx('txtDiasCumplir').getValue());
		}
	}
	else
	{
		arrSumar[0]=aniosPrescripcion;
		arrSumar[1]=0;
		arrSumar[2]=0;
	}
	
	
	fechaBase=fechaBase.add(Date.YEAR,arrSumar[0]);
	fechaBase=fechaBase.add(Date.MONTH,arrSumar[1]);
	fechaBase=fechaBase.add(Date.DAY,arrSumar[2]);
	if(cmbSentenciadoCiudadMexico.getValue()=='0')
	{
		fechaBase=fechaBase.add(Date.YEAR,arrSumar[0]);
		fechaBase=fechaBase.add(Date.MONTH,arrSumar[1]);
		fechaBase=fechaBase.add(Date.DAY,arrSumar[2]);
	}
	
	txtFechaPrescripcion.setValue(fechaBase);
}

function limpiarDatosAbono()
{
	gEx('dteFechaInicio').setValue('');
	gEx('dteFechaTermino').setValue('');
	gEx('txtFechaSustraccion').setValue('');
	gEx('txtFechaPrescripcion').setValue('');
	
	gEx('txtAnios').setValue('0');
	gEx('txtMeses').setValue('0');
	gEx('txtDias').setValue('0');
	
	gEx('txtAniosCumplimiento').setValue('0');
	gEx('txtMesesCumplimiento').setValue('0');
	gEx('txtDiasCumplimiento').setValue('0');
	
	gEx('txtAniosPunitiva').setValue('0');
	gEx('txtMesesPunitiva').setValue('0');
	gEx('txtDiasPunitiva').setValue('0');
	
	gEx('txtComentarioPrision').setValue('');
	
	gEx('cmbSentenciadoCiudadMexico').setValue('');
	
	gEx('txtAniosCumplir').setValue('0');
	gEx('txtMesesCumplir').setValue('0');
	gEx('txtDiasCumplir').setValue('0');
}


function refrescarMenuDTD()
{
	window.parent.mostrarMenuDTD();
}