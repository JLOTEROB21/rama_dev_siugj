<?php
	session_start();
	include("configurarIdiomaJS.php");
	include("conexionBD.php");

	
	$idFormulario=bD($_GET["iF"]);
	$idRegistro=bD($_GET["iR"]);
	$idReferencia=($_GET["iRef"]);
	
	$consulta="SELECT codigoInstitucion,numeracionExpediente FROM _478_tablaDinamica WHERE id__478_tablaDinamica=".$idReferencia;	
	$fRegistro=$con->obtenerPrimeraFila($consulta);
	$juzgado=$fRegistro[0];
	$numeracionExpediente=$fRegistro[1];
	$idMagistrado=-1;
	$nombreMagistrado='';
	$consulta="SELECT id__17_tablaDinamica FROM _17_tablaDinamica WHERE claveUnidad='".$fRegistro[0]."'";
	$idJuzgado=$con->obtenerValor($consulta);
	
	$consulta="SELECT claveElemento,nombreElemento FROM 1018_catalogoVarios WHERE tipoElemento=30";
	$arrSufijos=$con->obtenerFilasArreglo($consulta);
	$consulta="SELECT idMagistradoInstructor FROM _589_tablaDinamica WHERE idReferencia=".$idReferencia;
	$fRegistroMagistrado=$con->obtenerPrimeraFila($consulta);
	if(!$fRegistroMagistrado)
	{
		$consulta="SELECT idMagistradoCambio FROM _589_bitacoraCambiosMagistradoInstructor WHERE iFormulario=478 AND iRegistro=".$idReferencia." ORDER BY idRegistro DESC";
		$idMagistrado=$con->obtenerValor($consulta);
		if($idMagistrado=="")
		{
			$idMagistrado=asignarMagistradoInstructorExpediente($idJuzgado,478,$idReferencia);
		}
		$nombreMagistrado=obtenerNombreUsuario($idMagistrado);
	}
	
	
	$consulta="SELECT t.usuarioJuez,u.Nombre FROM _26_tablaDinamica t,_26_tipoJuez j,800_usuarios u WHERE idReferencia=".$idJuzgado." AND j.idPadre=t.id__26_tablaDinamica
				AND j.idOpcion=5 and t.usuarioJuez=u.idUsuario order by clave";
	$arrMagistrados=$con->obtenerFilasArreglo($consulta);
	
?>
var arrMagistrados=<?php echo $arrMagistrados?>;
var idMagistrado='<?php echo $idMagistrado?>';
var nombreMagistrado='<?php echo $nombreMagistrado?>';
var numeracionExpediente='<?php echo $numeracionExpediente?>';
var arrSufijos=<?php echo $arrSufijos?>;

var existeAudiencia=false;
var anio='<?php echo date("Y")?>';
var juzgado='<?php echo $juzgado?>';

function inyeccionCodigo()
{
	if(esRegistroFormulario())
    {
    	if(gE('idRegistroG').value=='-1')
        {
        	gEN('_idMagistradoInstructorvch')[0].value=idMagistrado;
            gE('sp_8955').innerHTML=nombreMagistrado;
        	
        }
         
    }
    
   
}



function modificarMagistradoInstructor()
{
	var cmbMagistradoInstructor=crearComboExt('cmbMagistradoInstructor',arrMagistrados,260,5,350);
	var form = new Ext.form.FormPanel(	
										{
											baseCls: 'x-plain',
											layout:'absolute',
											defaultType: 'label',
											items: 	[
                                            			{
                                                        	x:10,
                                                            y:10,
                                                            html:'Seleccione el Magistrado Instructor a Asignar:'
                                                        },
                                                        cmbMagistradoInstructor,
                                                        {
                                                        	x:10,
                                                            y:40,
                                                            html:'Ingrese el motivo del cambio:'
                                                        },
                                                        {
                                                        	x:10,
                                                            y:70,
                                                            xtype:'textarea',
                                                            width:650,
                                                            height:60,
                                                            id:'motivoCambio'
                                                        }
													]
										}
									);
	
	var ventanaAM = new Ext.Window(
									{
										title: 'Modificar Magistrado Instructor',
										width: 700,
										height:230,
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
																		if(cmbMagistradoInstructor.getValue()=='')
                                                                        {
                                                                        	function resp()
                                                                            {	
                                                                            	cmbMagistradoInstructor.focus();
                                                                            }
                                                                            msgBox('Debe seleccionar el magistrado instructor que desea asignar',resp);
                                                                            return;
                                                                        }
                                                                        
                                                                        var motivoCambio=gEx('motivoCambio');
                                                                        
                                                                        if(motivoCambio.getValue()=='')
                                                                        {
                                                                        	function resp2()
                                                                            {	
                                                                            	motivoCambio.focus();
                                                                            }
                                                                            msgBox('Debe seleccionar el motivo del cambio',resp2);
                                                                            return;
                                                                        }
                                                                        var cadObj='{"idUsuarioOriginal":"'+gEN('_idMagistradoInstructorvch')[0].value+'","idUsuarioCambio":"'+cmbMagistradoInstructor.getValue()+
                                                                        			'","motivoCambio":"'+cv(motivoCambio.getValue())+'","idFormulario":"478","idRegistro":"<?php echo $idReferencia?>","tipoAsignacion":"<?php echo $idJuzgado?>"}';
																		
                                                                        
                                                                        function funcAjax()
                                                                        {
                                                                            var resp=peticion_http.responseText;
                                                                            arrResp=resp.split('|');
                                                                            if(arrResp[0]=='1')
                                                                            {
                                                                                gEN('_idMagistradoInstructorvch')[0].value=cmbMagistradoInstructor.getValue();
                                                                               
																	            gE('sp_8955').innerHTML=cmbMagistradoInstructor.getRawValue();
                                                                                ventanaAM.close();
                                                                            }
                                                                            else
                                                                            {
                                                                                msgBox('<?php echo $etj["errOperacion"]?>'+' <br />'+arrResp[0]);
                                                                            }
                                                                        }
                                                                        obtenerDatosWeb('../paginasFunciones/funcionesModulosEspeciales_Juzgados.php',funcAjax, 'POST','funcion=11&cadObj='+cadObj,true);
                                                                        
                                                                        
                                                                        
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
  

